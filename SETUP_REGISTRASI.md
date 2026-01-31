# Setup Registrasi & Admin MikPay

## Langkah-langkah Setup

### 1. Update Database

Jalankan migration untuk menambahkan field baru ke tabel users:

```bash
php artisan migrate:fresh
```

Atau jika database sudah ada data, buat migration baru:

```bash
php artisan make:migration add_subdomain_role_status_to_users_table
```

### 2. Seed Database

Jalankan seeder untuk membuat user admin dan user default:

```bash
php artisan db:seed --class=UserSeeder
```

Atau jalankan semua seeder:

```bash
php artisan db:seed
```

### 3. User Default yang Dibuat

**Admin:**
- Email: `ndiandie@gmail.com`
- Password: `MikPayandidev.id`
- Role: `admin`
- Status: `active`

**User:**
- Email: `user@andidev.id`
- Password: `andidev.id`
- Role: `user`
- Status: `active`
- Subdomain: `test-user`

### 4. Routes yang Tersedia

- `/registrasi` - Halaman registrasi
- `/registrasi/success` - Halaman sukses registrasi
- `/login` - Halaman login
- `/admin/users` - Halaman admin untuk kelola users (hanya admin)
- `/logout` - Logout

### 5. Fitur Registrasi

- Form registrasi lengkap dengan validasi
- Check subdomain real-time (icon centang jika tersedia)
- Syarat dan ketentuan yang dapat dikoreksi
- Auto lowercase subdomain
- Validasi format subdomain
- Reserved subdomain (www, admin, api, dll)

### 6. Fitur Admin

- List semua user yang mendaftar
- Update status user (active/inactive/pending)
- Hapus user
- Filter berdasarkan status
- Informasi lengkap user (nama, email, subdomain, dll)

### 7. Database Schema

Tabel `users` memiliki field tambahan:
- `subdomain` - Subdomain unik untuk user
- `role` - Enum: 'admin' atau 'user'
- `status` - Enum: 'active', 'inactive', atau 'pending'
- `phone` - No. telepon (nullable)
- `address` - Alamat (nullable)

### 8. Catatan Penting

- Pastikan database `mikpay` sudah dibuat
- Update file `.env` dengan konfigurasi database yang benar
- Subdomain akan menjadi: `{subdomain}.mikpay.link`
- User baru akan memiliki status `pending` dan perlu approval admin
- Hanya admin yang dapat mengakses halaman `/admin/users`
