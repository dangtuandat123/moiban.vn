<?php

namespace App\Console\Commands;

use App\Models\Invitation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Command: Đánh dấu thiệp hết hạn
 * Chạy hàng ngày để cập nhật trạng thái thiệp đã hết thời hạn subscription
 */
class CleanupExpiredSubscriptions extends Command
{
    protected $signature = 'invitations:cleanup-expired';
    protected $description = 'Đánh dấu các thiệp hết hạn subscription';

    public function handle(): int
    {
        $this->info('Đang kiểm tra thiệp hết hạn...');

        // Tìm các thiệp đang active nhưng đã hết hạn
        $expiredInvitations = Invitation::where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->get();

        $count = $expiredInvitations->count();

        if ($count === 0) {
            $this->info('Không có thiệp nào hết hạn.');
            return self::SUCCESS;
        }

        foreach ($expiredInvitations as $invitation) {
            $invitation->update([
                'status' => 'expired',
                'watermark_enabled' => true, // Bật watermark khi hết hạn
            ]);

            Log::info('Invitation expired', [
                'invitation_id' => $invitation->id,
                'slug' => $invitation->slug,
                'expired_at' => $invitation->expires_at,
            ]);
        }

        $this->info("Đã đánh dấu {$count} thiệp hết hạn.");

        return self::SUCCESS;
    }
}
