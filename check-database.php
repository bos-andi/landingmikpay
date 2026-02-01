<?php
/**
 * Script untuk cek struktur tabel users
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Cek Struktur Tabel Users ===\n\n";

try {
    // Cek apakah tabel users ada
    if (Schema::hasTable('users')) {
        echo "✅ Tabel 'users' ditemukan\n\n";
        
        // Cek kolom yang ada
        $columns = DB::select("SHOW COLUMNS FROM users");
        
        echo "Kolom yang ada di tabel users:\n";
        foreach ($columns as $column) {
            echo "  - {$column->Field} ({$column->Type})\n";
        }
        
        // Cek khusus kolom package
        echo "\n";
        $hasPackage = collect($columns)->contains(function ($col) {
            return $col->Field === 'package';
        });
        
        if ($hasPackage) {
            echo "✅ Kolom 'package' ditemukan!\n";
        } else {
            echo "❌ Kolom 'package' TIDAK ditemukan!\n";
            echo "\nJalankan migration:\n";
            echo "php artisan migrate\n";
        }
        
        // Cek kolom voucher_code (opsional)
        $hasVoucher = collect($columns)->contains(function ($col) {
            return $col->Field === 'voucher_code';
        });
        
        if ($hasVoucher) {
            echo "✅ Kolom 'voucher_code' ditemukan (opsional)\n";
        }
        
    } else {
        echo "❌ Tabel 'users' tidak ditemukan!\n";
        echo "Jalankan migration:\n";
        echo "php artisan migrate\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Selesai ===\n";
