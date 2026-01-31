<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun MikPay Anda Telah Diaktifkan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #4D44B5;
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .credentials-box {
            background: #ffffff;
            border: 2px solid #4D44B5;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .credential-item {
            margin: 15px 0;
            padding: 10px;
            background: #f1f5f9;
            border-radius: 6px;
        }
        .credential-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }
        .credential-value {
            font-size: 18px;
            color: #4D44B5;
            font-weight: 700;
            font-family: 'Courier New', monospace;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #4D44B5 0%, #6366f1 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }
        .warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Akun MikPay Anda Telah Diaktifkan!</h1>
        </div>
        
        <p>Halo <strong>{{ $user->name }}</strong>,</p>
        
        <p>Selamat! Akun MikPay Anda telah disetujui dan diaktifkan oleh admin. Berikut adalah informasi login Anda:</p>
        
        <div class="credentials-box">
            <div class="credential-item">
                <div class="credential-label">Email:</div>
                <div class="credential-value">{{ $user->email }}</div>
            </div>
            <div class="credential-item">
                <div class="credential-label">Password Default:</div>
                <div class="credential-value">{{ $password }}</div>
            </div>
            @if($user->subdomain)
            <div class="credential-item">
                <div class="credential-label">Subdomain Anda:</div>
                <div class="credential-value">{{ $user->subdomain }}.mikpay.link</div>
            </div>
            @endif
        </div>
        
        <div class="warning">
            <strong>⚠️ Penting:</strong> Untuk keamanan, segera ubah password default setelah login pertama kali.
        </div>
        
        <div style="text-align: center;">
            <a href="{{ url('/login') }}" class="button">Login ke MikPay</a>
        </div>
        
        <div class="content">
            <h3 style="margin-top: 0;">Informasi Penting:</h3>
            <ul>
                <li>Anda mendapatkan <strong>trial gratis 7 hari</strong> untuk semua fitur premium</li>
                <li>Setelah trial berakhir, pilih paket langganan untuk melanjutkan</li>
                <li>Jika ada pertanyaan, hubungi kami di <strong>admin@mikpay.link</strong></li>
            </ul>
        </div>
        
        <p>Terima kasih telah bergabung dengan MikPay!</p>
        
        <div class="footer">
            <p>Email ini dikirim dari <strong>admin@mikpay.link</strong></p>
            <p>MikPay - Sistem Pembayaran & Billing MikroTik</p>
            <p>&copy; {{ date('Y') }} MikPay. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
