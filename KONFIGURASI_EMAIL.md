# Konfigurasi Email MikPay

Panduan lengkap untuk mengkonfigurasi email di MikPay agar fitur kirim email credentials berjalan dengan baik.

## 1. Konfigurasi untuk Development/Testing (Mailtrap)

Mailtrap adalah layanan untuk testing email tanpa mengirim email real. Sangat cocok untuk development.

### Langkah-langkah:

1. **Daftar di Mailtrap** (gratis):
   - Kunjungi: https://mailtrap.io/
   - Buat akun gratis
   - Buat inbox baru
   - Copy SMTP credentials

2. **Update file `.env`**:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"
```

3. **Clear config cache**:
```bash
php artisan config:clear
```

4. **Test kirim email**:
   - Login sebagai admin
   - Buka `/admin/users`
   - Klik "Kirim Email" pada user
   - Cek inbox Mailtrap untuk melihat email

---

## 2. Konfigurasi untuk Production (Gmail SMTP)

Untuk production, Anda bisa menggunakan Gmail SMTP atau email service lainnya.

### A. Menggunakan Gmail SMTP

1. **Buat App Password di Gmail**:
   - Login ke Google Account
   - Buka: https://myaccount.google.com/security
   - Aktifkan 2-Step Verification
   - Buat App Password: https://myaccount.google.com/apppasswords
   - Copy App Password yang di-generate

2. **Update file `.env`**:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"
```

**Catatan**: Gmail akan menggunakan email Gmail Anda sebagai pengirim, tapi `MAIL_FROM_ADDRESS` akan muncul di email yang diterima.

---

### B. Menggunakan Email Custom Domain (Recommended)

Jika Anda punya domain `mikpay.link`, lebih baik setup email di hosting/email service.

#### Opsi 1: Menggunakan Hosting Email (cPanel, dll)

Jika hosting Anda menyediakan email service:

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.mikpay.link
MAIL_PORT=587
MAIL_USERNAME=admin@mikpay.link
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"
```

#### Opsi 2: Menggunakan SendGrid (Gratis 100 email/hari)

1. **Daftar di SendGrid**: https://sendgrid.com/
2. **Buat API Key**:
   - Dashboard → Settings → API Keys
   - Create API Key
   - Copy API Key

3. **Update file `.env`**:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"
```

#### Opsi 3: Menggunakan Mailgun

1. **Daftar di Mailgun**: https://www.mailgun.com/
2. **Dapatkan SMTP credentials**
3. **Update file `.env`**:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=your_mailgun_username
MAIL_PASSWORD=your_mailgun_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"
```

---

## 3. Konfigurasi untuk XAMPP (Local Development)

Jika menggunakan XAMPP di Windows, Anda bisa menggunakan beberapa opsi:

### Opsi 1: Mailtrap (Paling Mudah)
Ikuti langkah di bagian 1 di atas.

### Opsi 2: Fake SMTP Server
Install aplikasi seperti:
- **FakeSMTP**: https://nilhcem.github.io/FakeSMTP/
- **MailHog**: https://github.com/mailhog/MailHog

Kemudian konfigurasi:

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"
```

### Opsi 3: Log Email (Untuk Testing)
Email akan disimpan di file log, tidak benar-benar dikirim:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"
```

Email akan tersimpan di: `storage/logs/laravel.log`

---

## 4. Testing Konfigurasi Email

Setelah konfigurasi, test dengan cara berikut:

### A. Test via Tinker

```bash
php artisan tinker
```

Kemudian jalankan:

```php
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialsMail;
use App\Models\User;

$user = User::first();
$password = 'test123456';
Mail::to($user->email)->send(new UserCredentialsMail($user, $password));
```

### B. Test via Admin Panel

1. Login sebagai admin
2. Buka `/admin/users`
3. Klik "Kirim Email" pada user
4. Cek apakah email terkirim

---

## 5. Troubleshooting

### Error: "Connection could not be established"

**Solusi**:
- Pastikan `MAIL_HOST` benar
- Pastikan `MAIL_PORT` benar
- Cek firewall tidak memblokir port
- Untuk Gmail, pastikan "Less secure app access" diaktifkan atau gunakan App Password

### Error: "Authentication failed"

**Solusi**:
- Pastikan `MAIL_USERNAME` dan `MAIL_PASSWORD` benar
- Untuk Gmail, gunakan App Password, bukan password biasa
- Pastikan 2-Step Verification sudah diaktifkan

### Email tidak terkirim tapi tidak ada error

**Solusi**:
- Cek spam folder
- Cek konfigurasi `MAIL_FROM_ADDRESS`
- Pastikan email service tidak memblokir
- Cek log: `storage/logs/laravel.log`

### Clear cache setelah update .env

```bash
php artisan config:clear
php artisan cache:clear
```

---

## 6. Rekomendasi untuk Production

1. **Gunakan email service profesional**:
   - SendGrid (100 email/hari gratis)
   - Mailgun (5000 email/bulan gratis)
   - Amazon SES (sangat murah)

2. **Setup SPF, DKIM, dan DMARC** untuk domain Anda agar email tidak masuk spam

3. **Gunakan queue** untuk kirim email agar tidak blocking:
   ```env
   QUEUE_CONNECTION=database
   ```
   Kemudian jalankan:
   ```bash
   php artisan queue:work
   ```

4. **Monitor email delivery** untuk memastikan email terkirim

---

## 7. Contoh Konfigurasi Lengkap

### Development (Mailtrap):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=abc123def456
MAIL_PASSWORD=xyz789uvw012
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"
```

### Production (SendGrid):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"
```

### Production (Gmail):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"
```

---

## 8. Catatan Penting

- **Jangan commit file `.env`** ke git
- **Gunakan environment variables** yang berbeda untuk development dan production
- **Test email** sebelum deploy ke production
- **Monitor email delivery** untuk memastikan semua email terkirim
- **Backup credentials** email di tempat yang aman

---

## 9. Quick Start (Recommended untuk Development)

1. Daftar Mailtrap (gratis): https://mailtrap.io/
2. Copy SMTP credentials
3. Update `.env` dengan credentials Mailtrap
4. Clear cache: `php artisan config:clear`
5. Test kirim email via admin panel
6. Cek inbox Mailtrap untuk melihat email

Selesai! Email sudah siap digunakan. 🎉
