<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service: TelegramService
 * Gửi thông báo qua Telegram Bot
 */
class TelegramService
{
    private ?string $botToken;
    private ?string $chatId;
    private bool $enabled;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
        $this->enabled = !empty($this->botToken) && !empty($this->chatId);
    }

    /**
     * Gửi tin nhắn đến group admin
     */
    public function send(string $message): bool
    {
        if (!$this->enabled) {
            Log::debug('Telegram notification skipped (not configured)');
            return false;
        }

        try {
            $response = Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if (!$response->successful()) {
                Log::error('Telegram API error', ['response' => $response->json()]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Telegram send failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Thông báo user mới đăng ký
     */
    public function notifyNewUser(User $user): bool
    {
        $message = "🎉 <b>User mới đăng ký</b>\n\n"
            . "👤 <b>Tên:</b> {$user->name}\n"
            . "📧 <b>Email:</b> {$user->email}\n"
            . "📱 <b>SĐT:</b> {$user->phone}\n"
            . "🕐 <b>Thời gian:</b> " . now()->format('d/m/Y H:i');

        return $this->send($message);
    }

    /**
     * Thông báo nạp tiền thành công
     */
    public function notifyDeposit(User $user, int $amount, int $newBalance): bool
    {
        $formattedAmount = number_format($amount, 0, ',', '.');
        $formattedBalance = number_format($newBalance, 0, ',', '.');

        $message = "💰 <b>Nạp tiền thành công</b>\n\n"
            . "👤 <b>User:</b> {$user->name} (#{$user->id})\n"
            . "💵 <b>Số tiền:</b> +{$formattedAmount} VND\n"
            . "💳 <b>Số dư mới:</b> {$formattedBalance} VND\n"
            . "🕐 <b>Thời gian:</b> " . now()->format('d/m/Y H:i');

        return $this->send($message);
    }

    /**
     * Thông báo thiệp mới được tạo
     */
    public function notifyNewInvitation(User $user, Invitation $invitation): bool
    {
        $message = "💒 <b>Thiệp mới được tạo</b>\n\n"
            . "👤 <b>User:</b> {$user->name} (#{$user->id})\n"
            . "💌 <b>Thiệp:</b> {$invitation->title}\n"
            . "🔗 <b>Link:</b> {$invitation->public_url}\n"
            . "📋 <b>Template:</b> {$invitation->template->name}\n"
            . "🕐 <b>Thời gian:</b> " . now()->format('d/m/Y H:i');

        return $this->send($message);
    }

    /**
     * Thông báo mua gói thành công
     */
    public function notifyPurchase(User $user, Invitation $invitation, int $amount): bool
    {
        $formattedAmount = number_format($amount, 0, ',', '.');

        $message = "🛒 <b>Mua gói thành công</b>\n\n"
            . "👤 <b>User:</b> {$user->name} (#{$user->id})\n"
            . "💌 <b>Thiệp:</b> {$invitation->title}\n"
            . "💵 <b>Số tiền:</b> {$formattedAmount} VND\n"
            . "🕐 <b>Thời gian:</b> " . now()->format('d/m/Y H:i');

        return $this->send($message);
    }

    /**
     * Thông báo lỗi hệ thống
     */
    public function notifyError(string $error, ?array $context = null): bool
    {
        $message = "⚠️ <b>Lỗi hệ thống</b>\n\n"
            . "❌ <b>Lỗi:</b> {$error}\n"
            . "🕐 <b>Thời gian:</b> " . now()->format('d/m/Y H:i');

        if ($context) {
            $message .= "\n📋 <b>Context:</b> " . json_encode($context, JSON_UNESCAPED_UNICODE);
        }

        return $this->send($message);
    }
}
