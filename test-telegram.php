<?php
/**
 * Script Test Telegram Bot untuk MikPay
 * 
 * Cara penggunaan:
 * 1. Pastikan file .env sudah dikonfigurasi dengan TELEGRAM_BOT_TOKEN dan TELEGRAM_CHAT_ID
 * 2. Jalankan: php test-telegram.php
 * 3. Cek Telegram Anda untuk melihat notifikasi
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\TelegramService;
use App\Models\User;
use Illuminate\Support\Facades\Http;

echo "=== Test Telegram Bot MikPay ===\n\n";

// Cek konfigurasi
$botToken = config('services.telegram.bot_token');
$chatId = config('services.telegram.chat_id');

echo "Konfigurasi Telegram:\n";
echo "- Bot Token: " . (empty($botToken) ? "❌ TIDAK DIKONFIGURASI" : "✅ " . substr($botToken, 0, 10) . "...") . "\n";
echo "- Chat ID: " . (empty($chatId) ? "❌ TIDAK DIKONFIGURASI" : "✅ " . $chatId) . "\n\n";

if (empty($botToken) || empty($chatId)) {
    echo "❌ ERROR: Bot Token atau Chat ID belum dikonfigurasi!\n\n";
    echo "Langkah-langkah:\n";
    echo "1. Buka file .env\n";
    echo "2. Tambahkan:\n";
    echo "   TELEGRAM_BOT_TOKEN=your_bot_token\n";
    echo "   TELEGRAM_CHAT_ID=your_chat_id\n";
    echo "3. Clear config: php artisan config:clear\n";
    echo "4. Jalankan script ini lagi\n";
    exit(1);
}

// Validasi format bot token
if (!preg_match('/^\d+:[A-Za-z0-9_-]+$/', $botToken)) {
    echo "❌ ERROR: Format Bot Token tidak valid!\n";
    echo "Format yang benar: 123456789:ABCdefGHIjklMNOpqrsTUVwxyz\n";
    exit(1);
}

// Test koneksi ke Telegram API
echo "Testing koneksi ke Telegram API...\n";
try {
    $testUrl = "https://api.telegram.org/bot{$botToken}/getMe";
    $response = Http::timeout(10)->get($testUrl);
    
    if ($response->successful()) {
        $data = $response->json();
        if (isset($data['ok']) && $data['ok'] === true) {
            echo "✅ Bot Token valid!\n";
            echo "   Bot Name: " . ($data['result']['first_name'] ?? 'N/A') . "\n";
            echo "   Bot Username: @" . ($data['result']['username'] ?? 'N/A') . "\n\n";
        } else {
            echo "❌ Bot Token tidak valid atau bot tidak ditemukan!\n";
            echo "   Response: " . $response->body() . "\n";
            exit(1);
        }
    } else {
        echo "❌ Gagal mengakses Telegram API!\n";
        echo "   Status Code: " . $response->status() . "\n";
        echo "   Response: " . $response->body() . "\n";
        exit(1);
    }
} catch (\Exception $e) {
    echo "❌ Error koneksi ke Telegram API: " . $e->getMessage() . "\n";
    echo "   Pastikan VPS bisa akses internet dan tidak diblokir firewall.\n";
    exit(1);
}

// Test kirim pesan sederhana
echo "Mengirim pesan test...\n";
$telegramService = new TelegramService();

$testMessage = "🧪 <b>Test Telegram Bot</b>\n\n";
$testMessage .= "Ini adalah pesan test dari MikPay.\n";
$testMessage .= "Jika Anda menerima pesan ini, berarti konfigurasi sudah benar! ✅\n\n";
$testMessage .= "Waktu: " . date('d/m/Y H:i:s');

$result = $telegramService->sendMessage($testMessage);

if ($result) {
    echo "✅ Pesan test berhasil dikirim!\n";
    echo "📱 Cek Telegram Anda sekarang.\n\n";
} else {
    echo "❌ Gagal mengirim pesan test.\n";
    echo "\nTroubleshooting:\n";
    echo "1. Pastikan bot sudah di-start (kirim /start ke bot)\n";
    echo "2. Untuk group, pastikan bot sudah di-add ke group\n";
    echo "3. Cek Chat ID sudah benar (bisa negatif untuk group)\n";
    echo "4. Cek log: tail -f storage/logs/laravel.log\n";
    exit(1);
}

// Test notifikasi registrasi (jika ada user)
$user = User::where('role', 'user')->first();

if ($user) {
    echo "\nMengirim notifikasi registrasi test...\n";
    $result = $telegramService->sendNewRegistrationNotification($user);
    
    if ($result) {
        echo "✅ Notifikasi registrasi berhasil dikirim!\n";
    } else {
        echo "❌ Gagal mengirim notifikasi registrasi.\n";
        echo "   Cek log untuk detail error.\n";
    }
} else {
    echo "\n⚠️  Tidak ada user untuk test notifikasi registrasi.\n";
}

echo "\n=== Test Selesai ===\n";
echo "\nJika semua test berhasil, bot Telegram sudah siap digunakan! 🎉\n";