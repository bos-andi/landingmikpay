# Konfigurasi Telegram Bot untuk Notifikasi MikPay

Panduan lengkap untuk setup Telegram bot notifikasi di MikPay.

## 1. Membuat Telegram Bot

### Langkah-langkah:

1. **Buka Telegram dan cari BotFather**:
   - Buka aplikasi Telegram
   - Search: `@BotFather`
   - Klik Start

2. **Buat Bot Baru**:
   ```
   /newbot
   ```
   - Masukkan nama bot (contoh: `MikPay Notification Bot`)
   - Masukkan username bot (contoh: `mikpay_notification_bot`)
   - BotFather akan memberikan **Bot Token**

3. **Simpan Bot Token**:
   - Copy token yang diberikan (format: `123456789:ABCdefGHIjklMNOpqrsTUVwxyz`)
   - Token ini akan digunakan di konfigurasi

---

## 2. Mendapatkan Chat ID

Ada beberapa cara untuk mendapatkan Chat ID:

### Cara 1: Menggunakan Bot Get ID

1. **Cari bot `@userinfobot`** di Telegram
2. **Start bot tersebut**
3. Bot akan memberikan Chat ID Anda
4. Copy Chat ID (format: `123456789` atau `-1001234567890` untuk group)

### Cara 2: Menggunakan Bot Send Message

1. **Kirim pesan ke bot Anda** (bot yang baru dibuat)
2. **Buka URL di browser**:
   ```
   https://api.telegram.org/bot<BOT_TOKEN>/getUpdates
   ```
   Ganti `<BOT_TOKEN>` dengan token bot Anda

3. **Cari `"chat":{"id"`** di response JSON
4. Copy nilai `id` tersebut

### Cara 3: Menggunakan Bot GetUpdates (Programmatic)

Jalankan di terminal:
```bash
curl https://api.telegram.org/bot<BOT_TOKEN>/getUpdates
```

Cari `chat.id` di response.

---

## 3. Konfigurasi di MikPay

### Update file `.env`:

Tambahkan konfigurasi berikut:

```env
TELEGRAM_BOT_TOKEN=123456789:ABCdefGHIjklMNOpqrsTUVwxyz
TELEGRAM_CHAT_ID=123456789
```

**Catatan:**
- `TELEGRAM_BOT_TOKEN`: Token dari BotFather
- `TELEGRAM_CHAT_ID`: Chat ID Anda atau group chat ID

### Clear config cache:

```bash
php artisan config:clear
```

---

## 4. Test Notifikasi

### Via Tinker:

```bash
php artisan tinker
```

```php
use App\Services\TelegramService;
use App\Models\User;

$telegramService = new TelegramService();
$user = User::first();
$telegramService->sendNewRegistrationNotification($user);
```

### Via Registrasi:

1. Buka halaman `/registrasi`
2. Daftar dengan data baru
3. Cek Telegram Anda, seharusnya ada notifikasi

---

## 5. Format Notifikasi

### Notifikasi Pendaftaran Baru:

```
🔔 Pendaftaran Baru MikPay

👤 Nama: [Nama User]
📧 Email: [Email User]
🌐 Subdomain: [subdomain].mikpay.link
📱 No. Telepon: [Phone] (jika ada)
📍 Alamat: [Address] (jika ada)

📅 Tanggal Daftar: [Tanggal]
⏳ Status: Pending Approval

Silakan cek admin panel untuk aktivasi akun.
```

### Notifikasi User Diaktifkan:

```
✅ User Diaktifkan

👤 Nama: [Nama User]
📧 Email: [Email User]
🌐 Subdomain: [subdomain].mikpay.link

User telah diaktifkan dan siap menggunakan layanan.
```

---

## 6. Troubleshooting

### Notifikasi tidak terkirim

1. **Cek Bot Token**:
   - Pastikan token benar
   - Pastikan tidak ada spasi di awal/akhir

2. **Cek Chat ID**:
   - Pastikan Chat ID benar
   - Untuk group, pastikan bot sudah di-add ke group
   - Untuk group, Chat ID biasanya negatif (contoh: `-1001234567890`)

3. **Cek Bot Status**:
   - Pastikan bot masih aktif
   - Test dengan kirim `/start` ke bot

4. **Cek Log**:
   ```bash
   tail -f storage/logs/laravel.log
   ```
   Cari error terkait Telegram

### Error: "Unauthorized" atau "Chat not found"

**Solusi:**
- Pastikan bot sudah di-start oleh user yang memiliki Chat ID tersebut
- Untuk group, pastikan bot sudah di-add ke group
- Pastikan Chat ID benar (bisa negatif untuk group)

### Error: "Bad Request"

**Solusi:**
- Cek format message (jangan ada karakter khusus yang tidak didukung)
- Pastikan parse_mode sesuai (HTML/Markdown)

---

## 7. Advanced: Setup Group Chat

Jika ingin notifikasi dikirim ke group:

1. **Buat group di Telegram**
2. **Add bot ke group**:
   - Buka group
   - Add member
   - Cari username bot Anda
   - Add bot ke group

3. **Dapatkan Group Chat ID**:
   - Kirim pesan ke group
   - Buka: `https://api.telegram.org/bot<BOT_TOKEN>/getUpdates`
   - Cari `"chat":{"id"` untuk group (biasanya negatif)
   - Copy Chat ID group

4. **Update `.env`**:
   ```env
   TELEGRAM_CHAT_ID=-1001234567890
   ```

---

## 8. Security Best Practices

1. **Jangan commit `.env`** ke git
2. **Gunakan environment variables** yang berbeda untuk dev/prod
3. **Rotate bot token** jika terdeteksi kebocoran
4. **Limit akses bot** hanya untuk notifikasi (jangan berikan admin rights)

---

## 9. Contoh Konfigurasi Lengkap

### Development:
```env
TELEGRAM_BOT_TOKEN=123456789:ABCdefGHIjklMNOpqrsTUVwxyz
TELEGRAM_CHAT_ID=123456789
```

### Production:
```env
TELEGRAM_BOT_TOKEN=987654321:XYZabcDEFghiJKLmnoPQRstuv
TELEGRAM_CHAT_ID=-1001234567890
```

---

## 10. Quick Start

1. Buat bot via `@BotFather` → dapatkan token
2. Dapatkan Chat ID via `@userinfobot` atau `getUpdates`
3. Update `.env` dengan token dan chat ID
4. Clear config: `php artisan config:clear`
5. Test via registrasi atau tinker
6. Selesai! 🎉

---

## 11. Catatan Penting

- Bot token bersifat rahasia, jangan share ke publik
- Chat ID bisa berubah jika user menghapus chat dengan bot
- Untuk group, bot harus di-add terlebih dahulu
- Notifikasi akan otomatis terkirim saat:
  - User baru mendaftar
  - Admin mengaktifkan user

---

**Selamat! Telegram bot notifikasi sudah siap digunakan!** 🤖
