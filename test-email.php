<?php
/**
 * Script Test Email untuk MikPay
 * 
 * Cara penggunaan:
 * 1. Pastikan file .env sudah dikonfigurasi dengan benar
 * 2. Jalankan: php test-email.php
 * 3. Cek apakah email terkirim
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialsMail;
use App\Models\User;

echo "=== Test Email MikPay ===\n\n";

// Cek konfigurasi email
$mailer = config('mail.default');
$host = config('mail.mailers.smtp.host');
$port = config('mail.mailers.smtp.port');
$from = config('mail.from.address');

echo "Konfigurasi Email:\n";
echo "- Mailer: {$mailer}\n";
echo "- Host: {$host}\n";
echo "- Port: {$port}\n";
echo "- From: {$from}\n\n";

if ($mailer === 'log') {
    echo "⚠️  WARNING: Mailer menggunakan 'log', email akan disimpan di storage/logs/laravel.log\n";
    echo "   Untuk mengirim email real, ubah MAIL_MAILER=smtp di file .env\n\n";
}

// Cari user untuk test
$user = User::where('role', 'user')->first();

if (!$user) {
    echo "❌ Tidak ada user untuk test. Silakan buat user terlebih dahulu.\n";
    exit(1);
}

echo "Mengirim email test ke: {$user->email}\n";
echo "User: {$user->name}\n\n";

$testPassword = 'TestPassword123';

try {
    Mail::to($user->email)->send(new UserCredentialsMail($user, $testPassword));
    
    echo "✅ Email berhasil dikirim!\n\n";
    
    if ($mailer === 'log') {
        echo "📝 Email tersimpan di: storage/logs/laravel.log\n";
        echo "   Buka file tersebut untuk melihat isi email.\n";
    } else {
        echo "📧 Cek inbox email: {$user->email}\n";
        echo "   Jika tidak ada, cek folder spam.\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
    echo "Troubleshooting:\n";
    echo "1. Pastikan konfigurasi email di .env sudah benar\n";
    echo "2. Pastikan MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD sudah diisi\n";
    echo "3. Untuk development, gunakan Mailtrap (gratis)\n";
    echo "4. Clear config cache: php artisan config:clear\n";
    exit(1);
}

echo "\n=== Test Selesai ===\n";
