<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil - MikPay</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-mikpay.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .success-container {
            background: white;
            border-radius: 16px;
            padding: 3rem;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: white;
        }
        
        .success-container h1 {
            font-size: 2rem;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        
        .success-container p {
            color: #64748b;
            line-height: 1.8;
            margin-bottom: 2rem;
        }
        
        .info-box {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: left;
        }
        
        .info-box p {
            margin-bottom: 0.5rem;
            color: #475569;
        }
        
        .info-box strong {
            color: #1e293b;
        }
        
        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #4D44B5 0%, #6366f1 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(77, 68, 181, 0.3);
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        <h1>Registrasi Berhasil!</h1>
        <p>
            Terima kasih telah mendaftar di MikPay. Akun Anda sedang menunggu persetujuan dari admin. 
            Email dan password default akan dikirim ke alamat email Anda dalam <strong>1x24 jam</strong> setelah persetujuan admin.
        </p>
        
        <div class="info-box">
            <p><strong>Langkah Selanjutnya:</strong></p>
            <p>1. Tunggu persetujuan dari admin (biasanya 1-2 hari kerja)</p>
            <p>2. Setelah disetujui, Anda akan menerima email dari <strong>admin@mikpay.link</strong> yang berisi:</p>
            <p style="margin-left: 1.5rem;">• Email akun Anda</p>
            <p style="margin-left: 1.5rem;">• Password default untuk login</p>
            <p style="margin-left: 1.5rem;">• Link akses subdomain Anda</p>
            <p>3. Login menggunakan email dan password yang dikirim melalui email</p>
            <p>4. Nikmati trial gratis 5 hari untuk semua fitur premium</p>
            <p style="margin-top: 1rem; color: #f59e0b; font-weight: 600;">
                ⏰ Email akan dikirim dalam maksimal 1x24 jam setelah persetujuan admin
            </p>
        </div>
        
        <a href="/" class="btn">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>
