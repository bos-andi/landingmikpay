# Troubleshooting Login Error di VPS

## Masalah: "Email atau password salah"

### Penyebab Umum:

1. **Database belum di-seed** - User admin belum ada di database
2. **Password hash tidak match** - Password di database berbeda
3. **Status user tidak active** - User ada tapi statusnya pending/inactive
4. **Database connection error** - Koneksi ke database bermasalah

---

## Solusi 1: Jalankan Seeder (Recommended)

```bash
cd /var/www/mikpay
php artisan db:seed --class=UserSeeder
```

Ini akan membuat/update user admin dengan:
- Email: `ndiandie@gmail.com`
- Password: `MikPayandidev.id`
- Role: `admin`
- Status: `active`

---

## Solusi 2: Reset Password Admin

### Via Script (Paling Mudah):

1. **Upload file `fix-admin-password.php` ke VPS**
2. **Jalankan**:
   ```bash
   cd /var/www/mikpay
   php fix-admin-password.php
   ```
3. **Login dengan**:
   - Email: `ndiandie@gmail.com`
   - Password: `MikPayandidev.id`

### Via Tinker:

```bash
php artisan tinker
```

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$admin = User::where('email', 'ndiandie@gmail.com')->first();

if (!$admin) {
    $admin = User::create([
        'name' => 'Admin MikPay',
        'email' => 'ndiandie@gmail.com',
        'password' => Hash::make('MikPayandidev.id'),
        'role' => 'admin',
        'status' => 'active',
    ]);
} else {
    $admin->password = Hash::make('MikPayandidev.id');
    $admin->status = 'active';
    $admin->role = 'admin';
    $admin->save();
}

echo "Admin password reset!";
```

### Via MySQL Direct:

```bash
sudo mysql -u root -p mikpay
```

```sql
UPDATE users 
SET password = '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5K5Q5K5Q5K5Q5K', 
    status = 'active', 
    role = 'admin' 
WHERE email = 'ndiandie@gmail.com';
```

**Catatan**: Hash di atas adalah contoh, gunakan Hash::make() untuk generate yang benar.

---

## Solusi 3: Cek Database Connection

```bash
# Test koneksi database
php artisan tinker
```

```php
DB::connection()->getPdo();
```

Jika error, cek file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mikpay
DB_USERNAME=mikpay_user
DB_PASSWORD=your_password
```

---

## Solusi 4: Cek User di Database

```bash
php artisan tinker
```

```php
use App\Models\User;

// Cek semua user
User::all();

// Cek admin khusus
$admin = User::where('email', 'ndiandie@gmail.com')->first();
if ($admin) {
    echo "User ditemukan!\n";
    echo "Status: " . $admin->status . "\n";
    echo "Role: " . $admin->role . "\n";
} else {
    echo "User tidak ditemukan!\n";
}
```

---

## Solusi 5: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## Solusi 6: Cek Status User

Pastikan user memiliki status `active`:

```bash
php artisan tinker
```

```php
use App\Models\User;

$admin = User::where('email', 'ndiandie@gmail.com')->first();
$admin->status = 'active';
$admin->save();
```

---

## Quick Fix Script

Buat file `fix-login.sh` di VPS:

```bash
#!/bin/bash
cd /var/www/mikpay
php artisan db:seed --class=UserSeeder
php artisan config:clear
php artisan cache:clear
echo "Done! Try login now."
```

Jalankan:
```bash
chmod +x fix-login.sh
./fix-login.sh
```

---

## Checklist

- [ ] Database sudah dibuat
- [ ] Migration sudah dijalankan
- [ ] Seeder sudah dijalankan
- [ ] User admin ada di database
- [ ] Status user = 'active'
- [ ] Role user = 'admin'
- [ ] Password sudah di-hash dengan benar
- [ ] Config cache sudah di-clear
- [ ] File .env sudah benar

---

## Default Credentials

**Admin:**
- Email: `ndiandie@gmail.com`
- Password: `MikPayandidev.id`

**User:**
- Email: `user@andidev.id`
- Password: `andidev.id`

---

## Test Login via Tinker

```bash
php artisan tinker
```

```php
use Illuminate\Support\Facades\Auth;
use App\Models\User;

$user = User::where('email', 'ndiandie@gmail.com')->first();

if (Auth::loginUsingId($user->id)) {
    echo "Login berhasil!\n";
} else {
    echo "Login gagal!\n";
}
```

---

Jika masih error, cek log:
```bash
tail -f storage/logs/laravel.log
```
