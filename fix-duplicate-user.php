<?php
/**
 * Script untuk Fix/Check Duplicate User
 * 
 * Cara penggunaan:
 * 1. Upload file ini ke VPS
 * 2. Jalankan: php fix-duplicate-user.php
 * 3. Script akan menampilkan user duplikat dan opsi untuk menghapus
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== Fix Duplicate User MikPay ===\n\n";

// Cek user dengan email duplikat
$duplicateEmails = DB::table('users')
    ->select('email', DB::raw('count(*) as count'))
    ->groupBy('email')
    ->having('count', '>', 1)
    ->get();

if ($duplicateEmails->count() > 0) {
    echo "⚠️  Ditemukan email duplikat:\n\n";
    
    foreach ($duplicateEmails as $dup) {
        echo "Email: {$dup->email} (Terdaftar {$dup->count} kali)\n";
        
        $users = User::where('email', $dup->email)->orderBy('created_at', 'asc')->get();
        
        foreach ($users as $index => $user) {
            echo "  [{$user->id}] {$user->name} - Status: {$user->status} - Created: {$user->created_at}\n";
        }
        echo "\n";
    }
    
    echo "Untuk menghapus duplikat, edit script ini dan uncomment bagian delete.\n";
    echo "Atau hapus manual via admin panel.\n";
} else {
    echo "✅ Tidak ada email duplikat.\n";
}

// Cek user dengan subdomain duplikat
$duplicateSubdomains = DB::table('users')
    ->select('subdomain', DB::raw('count(*) as count'))
    ->whereNotNull('subdomain')
    ->groupBy('subdomain')
    ->having('count', '>', 1)
    ->get();

if ($duplicateSubdomains->count() > 0) {
    echo "\n⚠️  Ditemukan subdomain duplikat:\n\n";
    
    foreach ($duplicateSubdomains as $dup) {
        echo "Subdomain: {$dup->subdomain} (Terdaftar {$dup->count} kali)\n";
        
        $users = User::where('subdomain', $dup->subdomain)->orderBy('created_at', 'asc')->get();
        
        foreach ($users as $index => $user) {
            echo "  [{$user->id}] {$user->name} ({$user->email}) - Status: {$user->status} - Created: {$user->created_at}\n";
        }
        echo "\n";
    }
} else {
    echo "\n✅ Tidak ada subdomain duplikat.\n";
}

// Cek user dengan email spesifik
echo "\n=== Cek User: bosandi.developer@gmail.com ===\n";
$user = User::where('email', 'bosandi.developer@gmail.com')->first();

if ($user) {
    echo "✅ User ditemukan:\n";
    echo "  ID: {$user->id}\n";
    echo "  Nama: {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  Subdomain: " . ($user->subdomain ?? 'Tidak ada') . "\n";
    echo "  Status: {$user->status}\n";
    echo "  Role: {$user->role}\n";
    echo "  Created: {$user->created_at}\n";
    echo "\n";
    echo "Opsi:\n";
    echo "1. Jika ini user yang benar, tidak perlu dihapus\n";
    echo "2. Jika ini duplikat, hapus via admin panel atau database\n";
    echo "3. Untuk reset password: php fix-admin-password.php\n";
} else {
    echo "❌ User tidak ditemukan.\n";
}

echo "\n=== Selesai ===\n";
