<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MikPay - Sistem Pembayaran & Billing MikroTik Terbaik</title>
    <meta name="description" content="MikPay adalah sistem pembayaran dan billing untuk router MikroTik dengan fitur lengkap untuk tagihan WiFi, hotspot payment, PPP billing, dan voucher system.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-mikpay.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo-mikpay.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #4D44B5;
            --primary-dark: #3d35a0;
            --secondary: #f97316;
            --accent: #6366f1;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --gradient: linear-gradient(135deg, #4D44B5 0%, #6366f1 100%);
            --gradient-orange: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }
        
        .logo img {
            height: 40px;
            width: auto;
            object-fit: contain;
            display: block;
        }
        
        .logo .logo-fallback {
            display: none;
        }
        
        .logo img:not([src]) ~ .logo-fallback,
        .logo img[src=""] ~ .logo-fallback {
            display: inline-block;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }
        
        .btn-register {
            background: var(--gradient);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
            display: inline-block;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(77, 68, 181, 0.3);
        }
        
        /* Hero Section */
        .hero {
            margin-top: 80px;
            padding: 6rem 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            text-align: center;
        }
        
        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 1.25rem;
            color: var(--text-gray);
            margin-bottom: 2rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 1rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn-primary {
            background: var(--gradient);
            color: white;
            box-shadow: 0 10px 30px rgba(77, 68, 181, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(77, 68, 181, 0.4);
        }
        
        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }
        
        .btn-secondary:hover {
            background: var(--primary);
            color: white;
        }
        
        /* Section */
        .section {
            padding: 5rem 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }
        
        .section-title p {
            font-size: 1.125rem;
            color: var(--text-gray);
        }
        
        /* Features */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: white;
        }
        
        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-dark);
        }
        
        .feature-card p {
            color: var(--text-gray);
            line-height: 1.7;
        }
        
        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }
        
        .gallery-item {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            aspect-ratio: 16/9;
            background: var(--bg-light);
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 1.5rem;
            color: white;
        }
        
        .gallery-overlay h4 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .gallery-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient);
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        /* Pricing */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .pricing-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }
        
        .pricing-card.featured {
            border: 3px solid var(--secondary);
            transform: scale(1.05);
        }
        
        .pricing-card.featured::before {
            content: 'POPULER';
            position: absolute;
            top: 20px;
            right: -30px;
            background: var(--gradient-orange);
            color: white;
            padding: 5px 40px;
            font-size: 0.75rem;
            font-weight: 700;
            transform: rotate(45deg);
        }
        
        .pricing-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .pricing-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }
        
        .pricing-price {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        
        .pricing-duration {
            color: var(--text-gray);
            font-size: 0.9rem;
        }
        
        .pricing-original {
            text-decoration: line-through;
            color: var(--text-gray);
            font-size: 1.25rem;
            margin-right: 0.5rem;
        }
        
        .pricing-discount {
            background: #fee2e2;
            color: #dc2626;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 0.5rem;
        }
        
        .pricing-features {
            list-style: none;
            margin-bottom: 2rem;
        }
        
        .pricing-features li {
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .pricing-features li:last-child {
            border-bottom: none;
        }
        
        .pricing-features li i {
            color: #10b981;
            font-size: 1.125rem;
        }
        
        .pricing-button {
            width: 100%;
            text-align: center;
            padding: 1rem;
            background: var(--gradient);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
        }
        
        .pricing-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(77, 68, 181, 0.3);
        }
        
        .pricing-card.featured .pricing-button {
            background: var(--gradient-orange);
        }
        
        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        
        .footer p {
            opacity: 0.8;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .nav-links {
                gap: 1rem;
            }
            
            .logo img {
                height: 32px;
            }
            
            .logo {
                font-size: 1.25rem;
            }
            
            .features-grid,
            .gallery-grid,
            .pricing-grid {
                grid-template-columns: 1fr;
            }
            
            .pricing-card.featured {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="logo" style="text-decoration: none;">
                <img src="{{ asset('images/logo-mikpay.png') }}" alt="MikPay Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                <i class="fas fa-credit-card logo-fallback"></i>
                <span>MikPay</span>
            </a>
            <div class="nav-links">
                <a href="#features">Fitur</a>
                <a href="#gallery">Galeri</a>
                <a href="#pricing">Harga</a>
                <a href="#contact">Kontak</a>
                <a href="{{ route('registrasi') }}" class="btn-register">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <h1>Sistem Pembayaran & Billing MikroTik</h1>
            <p>Platform lengkap untuk mengelola tagihan WiFi, pembayaran hotspot, billing PPP, dan sistem voucher dengan otomatisasi penagihan yang canggih</p>
            <div class="hero-buttons">
                <a href="#pricing" class="btn btn-primary">
                    <i class="fas fa-rocket"></i> Mulai Sekarang
                </a>
                <a href="#features" class="btn btn-secondary">
                    <i class="fas fa-info-circle"></i> Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section" style="background: white;">
        <div class="container">
            <div class="section-title">
                <h2>Fitur Lengkap Sistem Pembayaran MikPay</h2>
                <p>Solusi lengkap untuk billing, payment, dan manajemen tagihan WiFi MikroTik</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Dashboard Real-time</h3>
                    <p>Monitor aktivitas router, pengguna aktif, dan statistik penggunaan secara real-time dengan visualisasi yang menarik</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Hotspot Payment Management</h3>
                    <p>Kelola pengguna hotspot dengan sistem pembayaran terintegrasi, tracking payment status, dan auto enable/disable berdasarkan pembayaran</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>PPP Billing & Payment</h3>
                    <p>Sistem billing untuk PPP secrets dengan tracking pembayaran, auto-disable saat telat bayar, dan reminder tagihan otomatis</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h3>Sistem Billing & Tagihan WiFi</h3>
                    <p>Generate tagihan otomatis, tracking pembayaran, reminder via WhatsApp, dan laporan keuangan lengkap untuk bisnis WiFi Anda</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h3>Voucher Payment System</h3>
                    <p>Generate voucher dengan harga custom, quick print untuk penjualan cepat, tracking penjualan voucher, dan laporan revenue</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Laporan Keuangan & Payment</h3>
                    <p>Tracking semua pembayaran, laporan pendapatan real-time, analisis cashflow, dan export data untuk akuntansi</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-whatsapp"></i>
                    </div>
                    <h3>WhatsApp API (Fonnte)</h3>
                    <p>Integrasi dengan Fonnte untuk mengirim notifikasi, reminder tagihan, dan informasi via WhatsApp</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Reminder Pembayaran Otomatis</h3>
                    <p>Notifikasi tagihan via WhatsApp, email reminder, auto-disable saat telat bayar, dan tracking status pembayaran</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3>Traffic Monitor</h3>
                    <p>Monitor traffic real-time, bandwidth usage, dan analisis penggunaan data per pengguna</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3>Log Activity</h3>
                    <p>Catat semua aktivitas sistem, login, perubahan data, dan audit trail untuk keamanan</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3>Multi-User Admin</h3>
                    <p>Dukungan multiple admin dengan level akses berbeda untuk manajemen tim yang fleksibel</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-infinity"></i>
                    </div>
                    <h3>Unlimited Router & User</h3>
                    <p>Tidak ada batasan jumlah router dan user admin yang dapat dikelola dalam satu akun</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3>API Access</h3>
                    <p>Akses API untuk integrasi dengan sistem lain dan automasi workflow</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3>White Label</h3>
                    <p>Custom branding dengan logo dan warna sendiri untuk identitas brand Anda</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Custom Domain</h3>
                    <p>Gunakan domain sendiri dengan subdomain untuk akses yang lebih profesional</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3>Backup Otomatis</h3>
                    <p>Backup data otomatis untuk keamanan dan recovery data yang mudah</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="section" style="background: var(--bg-light);">
        <div class="container">
            <div class="section-title">
                <h2>Galeri MikPay</h2>
                <p>Lihat tampilan dashboard billing, payment tracking, dan sistem tagihan MikPay</p>
            </div>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="/images/gallery/dashboard-overview.png" alt="Dashboard Overview - Monitor semua aktivitas dalam satu dashboard" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="gallery-placeholder" style="display: none;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Dashboard Overview</h4>
                        <p>Monitor semua aktivitas dalam satu dashboard</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <img src="/images/gallery/hotspot-payment.png" alt="Hotspot Payment - Kelola pembayaran pengguna hotspot" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="gallery-placeholder" style="display: none;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Hotspot Payment</h4>
                        <p>Kelola pembayaran pengguna hotspot</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <img src="/images/gallery/payment-billing-system.png" alt="Payment & Billing System - Sistem tagihan dan pembayaran otomatis" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="gallery-placeholder" style="display: none;">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Payment & Billing System</h4>
                        <p>Sistem tagihan dan pembayaran otomatis</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <img src="/images/gallery/invoice-payment.png" alt="Voucher Payment - Generate voucher dengan sistem pembayaran" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="gallery-placeholder" style="display: none;">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Invoice Payment</h4>
                        <p> Cetak Struk Pembayaran WiFi di System MikPay</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <img src="/images/gallery/payment-reports.png" alt="Payment Reports - Laporan pembayaran dan keuangan lengkap" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="gallery-placeholder" style="display: none;">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Payment Reports</h4>
                        <p>Laporan pembayaran dan keuangan lengkap</p>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <img src="/images/gallery/ppp-billing.png" alt="PPP Billing - Sistem billing dan pembayaran PPP" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="gallery-placeholder" style="display: none;">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>PPP Billing</h4>
                        <p>Sistem billing dan pembayaran PPP</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trial Promotion Section -->
    <section class="section" style="background: linear-gradient(135deg, #4D44B5 0%, #6366f1 100%); padding: 4rem 2rem;">
        <div class="container">
            <div style="text-align: center; color: white; max-width: 800px; margin: 0 auto;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">
                    <i class="fas fa-gift"></i>
                </div>
                <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; color: white;">
                    Masih Ragu? Coba Gratis Sekarang!
                </h2>
                <p style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.95; line-height: 1.8;">
                    Nikmati semua fitur premium MikPay secara <strong>GRATIS</strong> selama periode trial. 
                    Tidak perlu kartu kredit, tidak ada komitmen jangka panjang. 
                    Coba sekarang dan rasakan kemudahan mengelola billing & payment MikroTik Anda!
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 2rem;">
                    <div style="background: rgba(255,255,255,0.2); padding: 1rem 2rem; border-radius: 12px; backdrop-filter: blur(10px);">
                        <div style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">7 Hari</div>
                        <div style="opacity: 0.9;">Trial Gratis</div>
                    </div>
                    <div style="background: rgba(255,255,255,0.2); padding: 1rem 2rem; border-radius: 12px; backdrop-filter: blur(10px);">
                        <div style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">100%</div>
                        <div style="opacity: 0.9;">Fitur Premium</div>
                    </div>
                    <div style="background: rgba(255,255,255,0.2); padding: 1rem 2rem; border-radius: 12px; backdrop-filter: blur(10px);">
                        <div style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">0 Rupiah</div>
                        <div style="opacity: 0.9;">Tanpa Biaya</div>
                    </div>
                </div>
                <a href="{{ route('registrasi') }}" class="btn btn-primary" style="background: white; color: var(--primary); font-size: 1.125rem; padding: 1.25rem 3rem; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
                    <i class="fas fa-rocket"></i> Mulai Trial Gratis Sekarang
                </a>
                <p style="margin-top: 1.5rem; opacity: 0.8; font-size: 0.9rem;">
                    <i class="fas fa-check-circle"></i> Tidak perlu kartu kredit &bull; 
                    <i class="fas fa-check-circle"></i> Batal kapan saja &bull; 
                    <i class="fas fa-check-circle"></i> Upgrade kapan pun Anda siap
                </p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="section" style="background: white;">
        <div class="container">
            <div class="section-title">
                <h2>Pilih Paket yang Tepat</h2>
                <p>Paket fleksibel untuk kebutuhan bisnis Anda</p>
            </div>
            
            <div class="pricing-grid">
                <!-- Paket 1 Bulan -->
                <div class="pricing-card">
                    <div class="pricing-header">
                        <div class="pricing-name">Paket 1 Bulan</div>
                        <div class="pricing-price">Rp 50.000</div>
                        <div class="pricing-duration">per bulan</div>
                    </div>
                    
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Dashboard Real-time</li>
                        <li><i class="fas fa-check"></i> Hotspot Management</li>
                        <li><i class="fas fa-check"></i> PPP Secrets & Profiles</li>
                        <li><i class="fas fa-check"></i> Tagihan WiFi (Billing)</li>
                        <li><i class="fas fa-check"></i> Voucher System</li>
                        <li><i class="fas fa-check"></i> Laporan Keuangan</li>
                        <li><i class="fas fa-check"></i> WhatsApp API (Fonnte)</li>
                        <li><i class="fas fa-check"></i> Reminder Otomatis</li>
                        <li><i class="fas fa-check"></i> Traffic Monitor</li>
                        <li><i class="fas fa-check"></i> Log Activity</li>
                        <li><i class="fas fa-check"></i> Multi-User Admin</li>
                        <li><i class="fas fa-check"></i> Unlimited Router</li>
                        <li><i class="fas fa-check"></i> Unlimited User Admin</li>
                        <li><i class="fas fa-check"></i> API Access</li>
                        <li><i class="fas fa-check"></i> White Label</li>
                        <li><i class="fas fa-check"></i> Custom Domain</li>
                        <li><i class="fas fa-check"></i> Backup Otomatis</li>
                        <li><i class="fas fa-check"></i> Support 24/7</li>
                    </ul>
                    
                    <a href="{{ route('registrasi') }}" class="pricing-button">
                        Pilih Paket
                    </a>
                </div>
                
                <!-- Paket 5 Bulan (Featured) -->
                <div class="pricing-card featured">
                    <div class="pricing-header">
                        <div class="pricing-name">Paket 5 Bulan</div>
                        <div class="pricing-price">
                            <span class="pricing-original">Rp 250.000</span>
                            Rp 200.000
                        </div>
                        <div class="pricing-duration">5 bulan (hemat Rp 50.000)</div>
                        <div class="pricing-discount">DISKON 20%</div>
                    </div>
                    
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Dashboard Real-time</li>
                        <li><i class="fas fa-check"></i> Hotspot Management</li>
                        <li><i class="fas fa-check"></i> PPP Secrets & Profiles</li>
                        <li><i class="fas fa-check"></i> Tagihan WiFi (Billing)</li>
                        <li><i class="fas fa-check"></i> Voucher System</li>
                        <li><i class="fas fa-check"></i> Laporan Keuangan</li>
                        <li><i class="fas fa-check"></i> WhatsApp API (Fonnte)</li>
                        <li><i class="fas fa-check"></i> Reminder Otomatis</li>
                        <li><i class="fas fa-check"></i> Traffic Monitor</li>
                        <li><i class="fas fa-check"></i> Log Activity</li>
                        <li><i class="fas fa-check"></i> Multi-User Admin</li>
                        <li><i class="fas fa-check"></i> Unlimited Router</li>
                        <li><i class="fas fa-check"></i> Unlimited User Admin</li>
                        <li><i class="fas fa-check"></i> API Access</li>
                        <li><i class="fas fa-check"></i> White Label</li>
                        <li><i class="fas fa-check"></i> Custom Domain</li>
                        <li><i class="fas fa-check"></i> Backup Otomatis</li>
                        <li><i class="fas fa-check"></i> Support 24/7</li>
                        <li><i class="fas fa-star"></i> <strong>Semua Fitur Premium</strong></li>
                    </ul>
                    
                    <a href="{{ route('registrasi') }}" class="pricing-button">
                        Pilih Paket Populer
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <h3 style="margin-bottom: 1rem; font-size: 1.5rem;">MikPay</h3>
            <p>Sistem Pembayaran & Billing MikroTik</p>
            <p style="margin-top: 1rem; opacity: 0.7;">
                &copy; 2024 MikPay. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Smooth Scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.15)';
            } else {
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            }
        });
    </script>
</body>
</html>
