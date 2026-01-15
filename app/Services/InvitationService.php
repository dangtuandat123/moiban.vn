<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Models\Invitation;
use App\Models\Package;
use App\Models\Template;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Service: InvitationService
 * Xử lý logic tạo, cập nhật, kích hoạt thiệp
 */
class InvitationService
{
    public function __construct(
        private WalletService $walletService,
        private TelegramService $telegramService
    ) {}

    /**
     * Tạo thiệp mới (trial)
     */
    public function create(User $user, Template $template, array $data): Invitation
    {
        return DB::transaction(function () use ($user, $template, $data) {
            // Tạo thiệp với status trial
            $invitation = Invitation::create([
                'user_id' => $user->id,
                'template_id' => $template->id,
                'slug' => $this->generateUniqueSlug(),
                'title' => $data['title'] ?? $template->name,
                'content' => $this->prepareDefaultContent($template, $data),
                'status' => 'trial',
                'trial_ends_at' => now()->addDays(config('app.trial_duration_days', 2)),
                'watermark_enabled' => true,
                'seo_meta' => $this->generateSeoMeta($data),
            ]);

            // Thông báo Telegram
            $this->telegramService->notifyNewInvitation($user, $invitation);

            return $invitation;
        });
    }

    /**
     * Cập nhật nội dung thiệp
     */
    public function update(Invitation $invitation, array $data): Invitation
    {
        $invitation->update([
            'title' => $data['title'] ?? $invitation->title,
            'content' => array_merge($invitation->content ?? [], $data['content'] ?? []),
            'seo_meta' => $this->generateSeoMeta($data['content'] ?? $invitation->content),
        ]);

        return $invitation->fresh();
    }

    /**
     * Mua gói và kích hoạt thiệp
     */
    public function purchaseAndActivate(Invitation $invitation, Package $package): Invitation
    {
        return DB::transaction(function () use ($invitation, $package) {
            $user = $invitation->user;
            $wallet = $user->wallet;

            // Kiểm tra số dư
            if ($wallet->balance < $package->price) {
                throw new InsufficientBalanceException(
                    "Số dư không đủ. Cần: " . number_format($package->price) . " VND"
                );
            }

            // Trừ tiền
            $wallet->purchase(
                $package->price,
                "Mua gói {$package->name} cho thiệp: {$invitation->title}",
                ['invitation_id' => $invitation->id, 'package_id' => $package->id]
            );

            // Tạo subscription record
            $subscription = $invitation->subscriptions()->create([
                'package_id' => $package->id,
                'amount_paid' => $package->price,
                'package_type' => $package->type,
                'starts_at' => now(),
                'ends_at' => $package->isLifetime() ? null : now()->addDays($package->duration_days),
            ]);

            // Kích hoạt thiệp
            $invitation->activate($package->duration_days);

            return $invitation->fresh();
        });
    }

    /**
     * Gia hạn thiệp
     */
    public function extend(Invitation $invitation, Package $package): Invitation
    {
        return $this->purchaseAndActivate($invitation, $package);
    }

    /**
     * Khóa các thiệp trial hết hạn (cho cron job)
     */
    public function lockExpiredTrials(): int
    {
        $count = 0;

        Invitation::expiredTrials()
            ->chunk(100, function ($invitations) use (&$count) {
                foreach ($invitations as $invitation) {
                    $invitation->lock();
                    $count++;
                }
            });

        return $count;
    }

    /**
     * Generate unique slug cho thiệp
     */
    private function generateUniqueSlug(): string
    {
        do {
            $slug = Str::lower(Str::random(8));
        } while (Invitation::where('slug', $slug)->exists());

        return $slug;
    }

    /**
     * Chuẩn bị content mặc định từ template config
     */
    private function prepareDefaultContent(Template $template, array $data): array
    {
        $content = [];
        $fields = $template->fields;

        foreach ($fields as $key => $field) {
            $content[$key] = $data[$key] ?? ($field['default'] ?? null);
        }

        return $content;
    }

    /**
     * Generate SEO meta từ content
     */
    private function generateSeoMeta(array $data): array
    {
        $groomName = $data['groom_name'] ?? 'Chú rể';
        $brideName = $data['bride_name'] ?? 'Cô dâu';

        return [
            'title' => "Thiệp cưới {$groomName} & {$brideName}",
            'description' => "Trân trọng kính mời bạn đến dự lễ thành hôn của {$groomName} và {$brideName}",
            'og_image' => null, // Sẽ được generate sau
        ];
    }
}
