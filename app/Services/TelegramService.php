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
        // Validasi konfigurasi
        if (empty($this->botToken)) {
            Log::warning('Telegram bot token not configured in .env (TELEGRAM_BOT_TOKEN)');
            return false;
        }

        if (empty($this->chatId)) {
            Log::warning('Telegram chat ID not configured in .env (TELEGRAM_CHAT_ID)');
            return false;
        }

        // Validasi format bot token
        if (!preg_match('/^\d+:[A-Za-z0-9_-]+$/', $this->botToken)) {
            Log::error('Invalid Telegram bot token format');
            return false;
        }

        try {
            $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
            
            $response = Http::timeout(15)
                ->retry(2, 100)
                ->post($url, [
                    'chat_id' => $this->chatId,
                    'text' => $message,
                    'parse_mode' => $parseMode,
                    'disable_web_page_preview' => true,
                ]);

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['ok']) && $responseData['ok'] === true) {
                    Log::info('Telegram message sent successfully', [
                        'chat_id' => $this->chatId,
                        'message_id' => $responseData['result']['message_id'] ?? null
                    ]);
                    return true;
                } else {
                    Log::error('Telegram API returned error', [
                        'response' => $responseData
                    ]);
                    return false;
                }
            } else {
                $statusCode = $response->status();
                $responseBody = $response->body();
                $responseData = $response->json();
                
                Log::error('Telegram API request failed', [
                    'status_code' => $statusCode,
                    'response' => $responseBody,
                    'error_code' => $responseData['error_code'] ?? null,
                    'description' => $responseData['description'] ?? null
                ]);
                
                return false;
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Telegram connection error: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error('Telegram Service Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send notification for new registration
     */
    public function sendNewRegistrationNotification($user)
    {
        try {
            // Escape HTML characters untuk keamanan
            $name = htmlspecialchars($user->name ?? 'N/A', ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($user->email ?? 'N/A', ENT_QUOTES, 'UTF-8');
            $subdomain = htmlspecialchars($user->subdomain ?? 'N/A', ENT_QUOTES, 'UTF-8');
            $phone = $user->phone ? htmlspecialchars($user->phone, ENT_QUOTES, 'UTF-8') : null;
            $address = $user->address ? htmlspecialchars($user->address, ENT_QUOTES, 'UTF-8') : null;
            $date = $user->created_at ? $user->created_at->format('d/m/Y H:i:s') : 'N/A';

            $message = "🔔 <b>Pendaftaran Baru MikPay</b>\n\n";
            $message .= "👤 <b>Nama:</b> {$name}\n";
            $message .= "📧 <b>Email:</b> {$email}\n";
            
            if ($subdomain && $subdomain !== 'N/A') {
                $message .= "🌐 <b>Subdomain:</b> {$subdomain}.mikpay.link\n";
            }
            
            if ($phone) {
                $message .= "📱 <b>No. Telepon:</b> {$phone}\n";
            }
            
            if ($address) {
                $message .= "📍 <b>Alamat:</b> {$address}\n";
            }
            
            $message .= "\n";
            $message .= "📅 <b>Tanggal Daftar:</b> {$date}\n";
            $message .= "⏳ <b>Status:</b> Pending Approval\n\n";
            $message .= "Silakan cek admin panel untuk aktivasi akun.";

            return $this->sendMessage($message);
        } catch (\Exception $e) {
            Log::error('Error preparing Telegram registration notification', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send notification when user is activated
     */
    public function sendUserActivatedNotification($user)
    {
        try {
            // Escape HTML characters untuk keamanan
            $name = htmlspecialchars($user->name ?? 'N/A', ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($user->email ?? 'N/A', ENT_QUOTES, 'UTF-8');
            $subdomain = htmlspecialchars($user->subdomain ?? 'N/A', ENT_QUOTES, 'UTF-8');

            $message = "✅ <b>User Diaktifkan</b>\n\n";
            $message .= "👤 <b>Nama:</b> {$name}\n";
            $message .= "📧 <b>Email:</b> {$email}\n";
            
            if ($subdomain && $subdomain !== 'N/A') {
                $message .= "🌐 <b>Subdomain:</b> {$subdomain}.mikpay.link\n";
            }
            
            $message .= "\n";
            $message .= "User telah diaktifkan dan siap menggunakan layanan.";

            return $this->sendMessage($message);
        } catch (\Exception $e) {
            Log::error('Error preparing Telegram activation notification', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
