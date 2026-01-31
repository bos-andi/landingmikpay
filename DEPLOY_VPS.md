# Panduan Deploy MikPay ke VPS

Panduan lengkap untuk deploy aplikasi MikPay ke VPS server.

## Prerequisites

- VPS dengan Ubuntu 20.04/22.04 atau Debian 11/12
- Akses root atau user dengan sudo
- Domain `mikpay.link` sudah diarahkan ke IP VPS
- SSH access ke VPS

---

## 1. Setup Server (VPS)

### A. Update System

```bash
sudo apt update && sudo apt upgrade -y
```

### B. Install Dependencies

```bash
# Install PHP 8.2 dan extensions
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.2 php8.2-fpm php8.2-cli php8.2-common php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Install Nginx
sudo apt install -y nginx

# Install MySQL
sudo apt install -y mysql-server

# Install Git
sudo apt install -y git
```

### C. Setup MySQL

```bash
sudo mysql_secure_installation
```

Buat database:

```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE mikpay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mikpay_user'@'localhost' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON mikpay.* TO 'mikpay_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## 2. Clone Repository

```bash
cd /var/www
sudo git clone https://github.com/bos-andi/landingmikpay.git mikpay
cd mikpay
```

---

## 3. Install Dependencies

```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies (jika perlu)
npm install
npm run build
```

---

## 4. Konfigurasi Environment

```bash
# Copy .env.example ke .env
cp .env.example .env

# Generate app key
php artisan key:generate
```

Edit file `.env`:

```env
APP_NAME=MikPay
APP_ENV=production
APP_KEY=base64:... (sudah di-generate)
APP_DEBUG=false
APP_URL=https://mikpay.link

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mikpay
DB_USERNAME=mikpay_user
DB_PASSWORD=your_strong_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@mikpay.link
MAIL_FROM_NAME="MikPay"

SESSION_DRIVER=database
SESSION_LIFETIME=120
```

---

## 5. Setup Database

```bash
# Run migrations
php artisan migrate --force

# Run seeders
php artisan db:seed --class=UserSeeder
```

---

## 6. Setup Storage & Permissions

```bash
# Create storage link
php artisan storage:link

# Set permissions
sudo chown -R www-data:www-data /var/www/mikpay
sudo chmod -R 755 /var/www/mikpay
sudo chmod -R 775 /var/www/mikpay/storage
sudo chmod -R 775 /var/www/mikpay/bootstrap/cache
```

---

## 7. Konfigurasi Nginx

Buat file konfigurasi Nginx:

```bash
sudo nano /etc/nginx/sites-available/mikpay
```

Isi dengan:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name mikpay.link www.mikpay.link;
    
    root /var/www/mikpay/public;
    index index.php index.html;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan site:

```bash
sudo ln -s /etc/nginx/sites-available/mikpay /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 8. Setup SSL (Let's Encrypt)

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Generate SSL certificate
sudo certbot --nginx -d mikpay.link -d www.mikpay.link

# Auto-renewal (sudah otomatis setup)
sudo certbot renew --dry-run
```

---

## 9. Setup Subdomain untuk User

Untuk membuat subdomain dinamis (misal: `user1.mikpay.link`), Anda perlu:

### A. Wildcard DNS

Di DNS provider, tambahkan:
```
Type: A
Name: *
Value: IP_VPS_ANDA
```

### B. Nginx Wildcard Configuration

Update `/etc/nginx/sites-available/mikpay`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name mikpay.link www.mikpay.link *.mikpay.link;
    
    # ... (sama seperti sebelumnya)
}
```

### C. SSL untuk Wildcard

```bash
sudo certbot --nginx -d mikpay.link -d www.mikpay.link -d *.mikpay.link
```

**Catatan**: Let's Encrypt tidak support wildcard via HTTP validation. Gunakan DNS validation:

```bash
sudo certbot certonly --manual --preferred-challenges dns -d mikpay.link -d *.mikpay.link
```

Atau gunakan Cloudflare untuk wildcard SSL otomatis.

---

## 10. Optimasi Production

```bash
# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

---

## 11. Setup Queue Worker (Opsional)

Jika menggunakan queue untuk email:

```bash
# Install Supervisor
sudo apt install -y supervisor

# Create supervisor config
sudo nano /etc/supervisor/conf.d/mikpay-worker.conf
```

Isi:

```ini
[program:mikpay-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/mikpay/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/mikpay/storage/logs/worker.log
stopwaitsecs=3600
```

Start supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start mikpay-worker:*
```

---

## 12. Setup Cron Job

```bash
sudo crontab -e -u www-data
```

Tambahkan:

```
* * * * * cd /var/www/mikpay && php artisan schedule:run >> /dev/null 2>&1
```

---

## 13. Firewall Setup

```bash
# Install UFW
sudo apt install -y ufw

# Allow SSH, HTTP, HTTPS
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Enable firewall
sudo ufw enable
```

---

## 14. Monitoring & Logs

```bash
# View Nginx logs
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/nginx/access.log

# View Laravel logs
tail -f /var/www/mikpay/storage/logs/laravel.log

# View PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

---

## 15. Backup Database

Buat script backup:

```bash
sudo nano /usr/local/bin/backup-mikpay.sh
```

Isi:

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/mikpay"
mkdir -p $BACKUP_DIR
mysqldump -u mikpay_user -p'your_password' mikpay > $BACKUP_DIR/mikpay_$DATE.sql
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
```

Buat executable:

```bash
sudo chmod +x /usr/local/bin/backup-mikpay.sh
```

Setup cron untuk backup harian:

```bash
sudo crontab -e
```

Tambahkan:

```
0 2 * * * /usr/local/bin/backup-mikpay.sh
```

---

## 16. Update Code (Setelah Push ke GitHub)

```bash
cd /var/www/mikpay
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload php8.2-fpm
```

---

## 17. Troubleshooting

### Error 502 Bad Gateway

```bash
# Cek PHP-FPM status
sudo systemctl status php8.2-fpm

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
```

### Permission Denied

```bash
sudo chown -R www-data:www-data /var/www/mikpay
sudo chmod -R 755 /var/www/mikpay
sudo chmod -R 775 /var/www/mikpay/storage
```

### Database Connection Error

```bash
# Test connection
mysql -u mikpay_user -p mikpay

# Cek .env file
cat /var/www/mikpay/.env | grep DB_
```

---

## 18. Checklist Deploy

- [ ] Server dependencies terinstall
- [ ] Database dibuat dan dikonfigurasi
- [ ] Repository di-clone
- [ ] Composer dependencies terinstall
- [ ] File `.env` dikonfigurasi
- [ ] Migration dijalankan
- [ ] Seeder dijalankan
- [ ] Storage link dibuat
- [ ] Permissions di-set
- [ ] Nginx dikonfigurasi
- [ ] SSL certificate terpasang
- [ ] Config, route, view di-cache
- [ ] Firewall dikonfigurasi
- [ ] Cron job di-setup
- [ ] Backup script di-setup

---

## 19. Quick Deploy Script

Buat file `deploy.sh`:

```bash
#!/bin/bash
cd /var/www/mikpay
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload php8.2-fpm
echo "Deploy completed!"
```

Jalankan:

```bash
chmod +x deploy.sh
./deploy.sh
```

---

## 20. Support

Jika ada masalah, cek:
- Laravel logs: `storage/logs/laravel.log`
- Nginx logs: `/var/log/nginx/error.log`
- PHP-FPM logs: `/var/log/php8.2-fpm.log`

---

**Selamat! Aplikasi MikPay sudah siap di-deploy ke VPS!** 🚀
