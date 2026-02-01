#!/bin/bash
# Script untuk Fix Telegram Bot di VPS

echo "=== Fix Telegram Bot MikPay di VPS ==="
echo ""

cd /var/www/mikpay || exit 1

# 1. Clear config cache
echo "1. Clearing config cache..."
php artisan config:clear
php artisan cache:clear
echo "✅ Config cache cleared"
echo ""

# 2. Cek konfigurasi .env
echo "2. Checking .env configuration..."
if grep -q "TELEGRAM_BOT_TOKEN" .env && grep -q "TELEGRAM_CHAT_ID" .env; then
    echo "✅ Telegram configuration found in .env"
    echo ""
    echo "Current configuration:"
    grep "TELEGRAM_BOT_TOKEN" .env | sed 's/=.*/=***HIDDEN***/'
    grep "TELEGRAM_CHAT_ID" .env
else
    echo "❌ Telegram configuration not found in .env"
    echo ""
    echo "Please add to .env:"
    echo "TELEGRAM_BOT_TOKEN=your_bot_token"
    echo "TELEGRAM_CHAT_ID=your_chat_id"
    exit 1
fi

# 3. Test koneksi internet
echo ""
echo "3. Testing internet connection..."
if curl -s --max-time 5 https://api.telegram.org > /dev/null; then
    echo "✅ Internet connection OK"
else
    echo "❌ Cannot reach Telegram API"
    echo "   Check firewall or network settings"
    exit 1
fi

# 4. Test Telegram bot
echo ""
echo "4. Testing Telegram bot..."
php test-telegram.php

echo ""
echo "=== Fix Complete ==="
