<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $botToken;
    protected $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
    }

    /**
     * Send message to Telegram
     */
    public function sendMessage($message, $parseMode = 'HTML')
    {
        if (empty($this->botToken) || empty($this->chatId)) {
            Log::warning('Telegram bot token or chat ID not configured');
            return false;
        }

        try {
            $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
            
            $response = Http::timeout(10)->post($url, [
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => $parseMode,
            ]);

            if ($response->successful()) {
                return true;
            } else {
                Log::error('Telegram API Error: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Telegram Service Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send notification for new registration
     */
    public function sendNewRegistrationNotification($user)
    {
        $message = "🔔 <b>Pendaftaran Baru MikPay</b>\n\n";
        $message .= "👤 <b>Nama:</b> {$user->name}\n";
        $message .= "📧 <b>Email:</b> {$user->email}\n";
        $message .= "🌐 <b>Subdomain:</b> {$user->subdomain}.mikpay.link\n";
        
        if ($user->phone) {
            $message .= "📱 <b>No. Telepon:</b> {$user->phone}\n";
        }
        
        if ($user->address) {
            $message .= "📍 <b>Alamat:</b> {$user->address}\n";
        }
        
        $message .= "\n";
        $message .= "📅 <b>Tanggal Daftar:</b> " . $user->created_at->format('d/m/Y H:i:s') . "\n";
        $message .= "⏳ <b>Status:</b> Pending Approval\n\n";
        $message .= "Silakan cek admin panel untuk aktivasi akun.";

        return $this->sendMessage($message);
    }

    /**
     * Send notification when user is activated
     */
    public function sendUserActivatedNotification($user)
    {
        $message = "✅ <b>User Diaktifkan</b>\n\n";
        $message .= "👤 <b>Nama:</b> {$user->name}\n";
        $message .= "📧 <b>Email:</b> {$user->email}\n";
        $message .= "🌐 <b>Subdomain:</b> {$user->subdomain}.mikpay.link\n";
        $message .= "\n";
        $message .= "User telah diaktifkan dan siap menggunakan layanan.";

        return $this->sendMessage($message);
    }
}
