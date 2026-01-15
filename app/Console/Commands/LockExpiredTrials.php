<?php

namespace App\Console\Commands;

use App\Models\Invitation;
use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Command: Khóa các thiệp trial hết hạn
 * Chạy mỗi giờ qua Cron Job
 */
class LockExpiredTrials extends Command
{
    protected $signature = 'invitations:lock-expired';
    protected $description = 'Khóa các thiệp đã hết thời gian dùng thử';

    public function handle(TelegramService $telegramService): int
    {
        $this->info('Đang quét thiệp hết hạn trial...');

        $count = 0;

        Invitation::expiredTrials()
            ->chunk(100, function ($invitations) use (&$count) {
                foreach ($invitations as $invitation) {
                    $invitation->lock();
                    $count++;

                    Log::info('Locked expired trial invitation', [
                        'invitation_id' => $invitation->id,
                        'slug' => $invitation->slug,
                        'user_id' => $invitation->user_id,
                    ]);
                }
            });

        $this->info("Đã khóa {$count} thiệp hết hạn trial.");

        if ($count > 0) {
            $telegramService->send("🔒 <b>Cron Job</b>: Đã khóa {$count} thiệp hết hạn trial.");
        }

        return Command::SUCCESS;
    }
}
