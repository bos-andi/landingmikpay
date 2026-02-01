# Troubleshooting Telegram Bot di VPS

## Masalah: Bot Telegram tidak berfungsi di VPS

### Penyebab Umum:

1. **Konfigurasi .env belum di-set** - Bot token atau Chat ID belum dikonfigurasi
2. **Config cache belum di-clear** - Perubahan .env belum ter-load
3. **Bot belum di-start** - User belum pernah start bot
4. **Chat ID salah** - Chat ID tidak sesuai (bisa negatif untuk group)
5. **Firewall memblokir** - VPS tidak bisa akses Telegram API
6. **Bot token tidak valid** - Token salah atau expired

---

## Solusi 1: Quick Fix Script

Jalankan script fix di VPS:

```bash
cd /var/www/mikpay
chmod +x fix-telegram-vps.sh
./fix-telegram-vps.sh
```

Script ini akan:
- Clear config cache
- Cek konfigurasi .env
- Test koneksi internet
- Test Telegram bot

---

## Solusi 2: Manual Fix

### Step 1: Cek Konfigurasi .env

```bash
cd /var/www/mikpay
nano .env
```

Pastikan ada:
```env
TELEGRAM_BOT_TOKEN=123456789:ABCdefGHIjklMNOpqrsTUVwxyz
TELEGRAM_CHAT_ID=123456789
```

### Step 2: Clear Config Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### Step 3: Test Bot Token

```bash
php test-telegram.php
```

---

## Solusi 3: Cek Log untuk Error Detail

```bash
tail -f /var/www/mikpay/storage/logs/laravel.log
```

Cari error terkait Telegram, contoh:
- `Telegram bot token or chat ID not configured`
- `Telegram API Error`
- `Telegram connection error`

---

## Solusi 4: Test Koneksi ke Telegram API

```bash
# Test apakah VPS bisa akses Telegram API
curl -s https://api.telegram.org/bot<BOT_TOKEN>/getMe
```

Ganti `<BOT_TOKEN>` dengan token bot Anda.

Jika berhasil, akan return JSON dengan info bot.
Jika gagal, kemungkinan firewall memblokir.

---

## Solusi 5: Validasi Bot Token

```bash
php artisan tinker
```

```php
use Illuminate\Support\Facades\Http;

$botToken = config('services.telegram.bot_token');
$url = "https://api.telegram.org/bot{$botToken}/getMe";
$response = Http::get($url);
echo $response->body();
```

Jika return `{"ok":true,...}` berarti token valid.
Jika return `{"ok":false,"error_code":401}` berarti token tidak valid.

---

## Solusi 6: Validasi Chat ID

### Untuk Personal Chat:

1. **Start bot** di Telegram (kirim `/start` ke bot)
2. **Dapatkan Chat ID** via `@userinfobot` atau:
   ```bash
   curl https://api.telegram.org/bot<BOT_TOKEN>/getUpdates
   ```
3. **Cari `"chat":{"id"`** di response, copy nilai `id`

### Untuk Group Chat:

1. **Add bot ke group**
2. **Kirim pesan di group**
3. **Dapatkan Chat ID**:
   ```bash
   curl https://api.telegram.org/bot<BOT_TOKEN>/getUpdates
   ```
4. **Chat ID untuk group biasanya negatif** (contoh: `-1001234567890`)

---

## Solusi 7: Test Manual via cURL

```bash
# Test kirim pesan langsung
curl -X POST "https://api.telegram.org/bot<BOT_TOKEN>/sendMessage" \
  -d "chat_id=<CHAT_ID>" \
  -d "text=Test message from VPS" \
  -d "parse_mode=HTML"
```

Ganti `<BOT_TOKEN>` dan `<CHAT_ID>` dengan nilai yang benar.

Jika berhasil, akan return JSON dengan `"ok":true`.

---

## Solusi 8: Cek Firewall

```bash
# Cek apakah port 443 (HTTPS) terbuka
sudo ufw status

# Jika firewall aktif, pastikan tidak memblokir HTTPS
sudo ufw allow 443/tcp
```

---

## Solusi 9: Test dari PHP

```bash
php artisan tinker
```

```php
use App\Services\TelegramService;

$telegram = new TelegramService();
$result = $telegram->sendMessage("Test message");

if ($result) {
    echo "Success!\n";
} else {
    echo "Failed! Check logs.\n";
}
```

---

## Error Messages & Solutions

### "Telegram bot token or chat ID not configured"

**Solusi:**
- Pastikan `.env` sudah dikonfigurasi
- Clear config: `php artisan config:clear`

### "Invalid Telegram bot token format"

**Solusi:**
- Format token harus: `123456789:ABCdefGHIjklMNOpqrsTUVwxyz`
- Pastikan tidak ada spasi di awal/akhir

### "Telegram API returned error: Unauthorized"

**Solusi:**
- Bot token salah atau expired
- Generate token baru via @BotFather

### "Telegram API returned error: Bad Request: chat not found"

**Solusi:**
- Chat ID salah
- Bot belum di-start oleh user
- Untuk group, bot belum di-add ke group

### "Telegram connection error"

**Solusi:**
- VPS tidak bisa akses internet
- Firewall memblokir
- DNS tidak resolve

---

## Checklist

- [ ] `.env` sudah dikonfigurasi dengan `TELEGRAM_BOT_TOKEN` dan `TELEGRAM_CHAT_ID`
- [ ] Config cache sudah di-clear
- [ ] Bot token valid (test via `getMe` API)
- [ ] Chat ID benar (test via `getUpdates` API)
- [ ] Bot sudah di-start (untuk personal chat)
- [ ] Bot sudah di-add ke group (untuk group chat)
- [ ] VPS bisa akses internet
- [ ] Firewall tidak memblokir HTTPS
- [ ] Log tidak menunjukkan error

---

## Quick Test Commands

```bash
# 1. Test config
php artisan tinker
config('services.telegram.bot_token')
config('services.telegram.chat_id')

# 2. Test bot token
curl https://api.telegram.org/bot<TOKEN>/getMe

# 3. Test kirim pesan
php test-telegram.php

# 4. Test dari aplikasi
# Daftar user baru, cek Telegram
```

---

## Default Test

Setelah fix, test dengan:

```bash
cd /var/www/mikpay
php test-telegram.php
```

Jika semua test berhasil, bot sudah siap digunakan! 🎉

---

## Support

Jika masih error setelah semua solusi di atas:
1. Cek log: `tail -f storage/logs/laravel.log`
2. Test manual via cURL
3. Pastikan bot token dan chat ID benar
4. Cek apakah VPS bisa akses internet
