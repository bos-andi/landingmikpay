<?php
/**
 * Script untuk Fix/Reset Password Admin di VPS
 * 
 * Cara penggunaan:
 * 1. Upload file ini ke VPS
 * 2. Jalankan: php fix-admin-password.php
 * 3. Password admin akan direset
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Fix Admin Password MikPay ===\n\n";

// Cek admin user
$admin = User::where('email', 'ndiandie@gmail.com')->first();

if (!$admin) {
    echo "❌ Admin user tidak ditemukan!\n";
    echo "Membuat admin user baru...\n\n";
    
    $admin = User::create([
        'name' => 'Admin MikPay',
        'email' => 'ndiandie@gmail.com',
        'password' => Hash::make('MikPayandidev.id'),
        'role' => 'admin',
        'status' => 'active',
        'subdomain' => null,
    ]);
    
    echo "✅ Admin user berhasil dibuat!\n\n";
} else {
    echo "✅ Admin user ditemukan: {$admin->name}\n";
    echo "Email: {$admin->email}\n";
    echo "Status: {$admin->status}\n\n";
    
    echo "Mereset password admin...\n";
    $admin->password = Hash::make('MikPayandidev.id');
    $admin->status = 'active';
    $admin->role = 'admin';
    $admin->save();
    
    echo "✅ Password admin berhasil direset!\n\n";
}

echo "=== Informasi Login ===\n";
echo "Email: ndiandie@gmail.com\n";
echo "Password: MikPayandidev.id\n";
echo "Role: admin\n";
echo "Status: active\n\n";

// Test password
echo "Testing password...\n";
if (Hash::check('MikPayandidev.id', $admin->password)) {
    echo "✅ Password hash valid!\n";
} else {
    echo "❌ Password hash tidak valid!\n";
}

echo "\n=== Selesai ===\n";
echo "Silakan coba login dengan kredensial di atas.\n";
