<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - MikPay</title>
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
            padding: 2rem 1rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #4D44B5 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            margin-bottom: 1rem;
        }
        
        .logo img {
            height: 40px;
            width: auto;
        }
        
        .header h1 {
            font-size: 2rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            color: #64748b;
        }
        
        .registration-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .form-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .terms-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-height: 600px;
            overflow-y: auto;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #1e293b;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #4D44B5;
        }
        
        .form-group input.error {
            border-color: #ef4444;
        }
        
        .subdomain-check {
            position: relative;
        }
        
        .subdomain-check input {
            padding-right: 45px;
        }
        
        .subdomain-status {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.25rem;
        }
        
        .subdomain-status .fa-check-circle {
            color: #10b981;
        }
        
        .subdomain-status .fa-times-circle {
            color: #ef4444;
        }
        
        .subdomain-status .fa-spinner {
            color: #64748b;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: translateY(-50%) rotate(0deg); }
            to { transform: translateY(-50%) rotate(360deg); }
        }
        
        .subdomain-hint {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.5rem;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin-top: 0.25rem;
        }
        
        .checkbox-group label {
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        .checkbox-group label a {
            color: #4D44B5;
            text-decoration: none;
        }
        
        .checkbox-group label a:hover {
            text-decoration: underline;
        }
        
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #4D44B5 0%, #6366f1 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(77, 68, 181, 0.3);
        }
        
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .terms-section h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #1e293b;
        }
        
        .terms-section h4 {
            font-size: 1.125rem;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            color: #1e293b;
        }
        
        .terms-section p {
            color: #64748b;
            line-height: 1.8;
            margin-bottom: 1rem;
        }
        
        .terms-section ul {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
            color: #64748b;
        }
        
        .terms-section li {
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }
        
        @media (max-width: 968px) {
            .registration-wrapper {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="/" class="logo">
                <img src="{{ asset('images/logo-mikpay.png') }}" alt="MikPay Logo">
                <span>MikPay</span>
            </a>
            <h1>Daftar Akun MikPay</h1>
            <p>Buat akun baru untuk mulai menggunakan sistem pembayaran & billing MikroTik</p>
        </div>
        
        <div class="registration-wrapper">
        <div class="terms-section" id="terms-content">
                <h3>Syarat dan Ketentuan</h3>
                
                <h4>1. Ketentuan Umum</h4>
                <p>
                    Dengan mendaftar dan menggunakan layanan MikPay, Anda menyetujui untuk mematuhi semua syarat dan ketentuan yang berlaku. 
                    Syarat dan ketentuan ini dapat diubah sewaktu-waktu tanpa pemberitahuan sebelumnya.
                </p>
                
                <h4>2. Akun Pengguna</h4>
                <ul>
                    <li>Anda bertanggung jawab untuk menjaga kerahasiaan informasi akun Anda</li>
                    <li>Anda wajib memberikan informasi yang akurat dan terkini</li>
                    <li>Setiap akun akan mendapatkan subdomain unik yang tidak dapat diubah</li>
                    <li>Subdomain yang dipilih harus mematuhi aturan penamaan yang berlaku</li>
                </ul>
                
                <h4>3. Penggunaan Layanan</h4>
                <ul>
                    <li>Layanan MikPay hanya dapat digunakan untuk keperluan bisnis yang sah</li>
                    <li>Dilarang menggunakan layanan untuk aktivitas ilegal atau melanggar hukum</li>
                    <li>Anda bertanggung jawab atas semua aktivitas yang terjadi di akun Anda</li>
                    <li>Kami berhak menangguhkan atau menghentikan akun yang melanggar ketentuan</li>
                </ul>
                
                <h4>4. Pembayaran dan Paket</h4>
                <ul>
                    <li>Setelah periode tertentu, Anda harus berlangganan paket berbayar untuk melanjutkan</li>
                    <li>Pembayaran dilakukan sesuai dengan paket yang dipilih</li>
                    <li>Tidak ada pengembalian dana untuk pembayaran yang sudah dilakukan</li>
                    <li>Pilih paket sesuai kebutuhan bisnis Anda saat registrasi</li>
                </ul>
                
                <h4>5. Data dan Privasi</h4>
                <ul>
                    <li>Kami menghormati privasi data pengguna sesuai dengan kebijakan privasi</li>
                    <li>Data yang Anda input akan disimpan dengan aman</li>
                    <li>Kami tidak akan membagikan data Anda kepada pihak ketiga tanpa izin</li>
                    <li>Anda berhak meminta penghapusan data pribadi Anda</li>
                </ul>
                
                <h4>6. Batasan Tanggung Jawab</h4>
                <p>
                    MikPay tidak bertanggung jawab atas kerugian yang timbul akibat penggunaan layanan, 
                    termasuk namun tidak terbatas pada kehilangan data, gangguan bisnis, atau kerugian finansial lainnya.
                </p>
                
                <h4>7. Perubahan Layanan</h4>
                <p>
                    Kami berhak mengubah, menangguhkan, atau menghentikan layanan kapan saja tanpa pemberitahuan sebelumnya. 
                    Perubahan fitur atau layanan tidak menjadi alasan untuk pengembalian dana.
                </p>
                
                <h4>8. Kontak</h4>
                <p>
                    Jika Anda memiliki pertanyaan mengenai syarat dan ketentuan ini, silakan hubungi kami melalui email atau kontak yang tersedia.
                </p>
                
                <p style="margin-top: 2rem; font-weight: 600; color: #1e293b;">
                    Dengan mencentang kotak persetujuan, Anda menyatakan telah membaca, memahami, dan menyetujui semua syarat dan ketentuan di atas.
                </p>
            </div>


            <div class="form-section">
                <form id="registrationForm" method="POST" action="{{ route('registrasi.store') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email <span style="color: #ef4444;">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">No. Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="subdomain">Subdomain <span style="color: #ef4444;">*</span></label>
                        <div class="subdomain-check">
                            <input type="text" id="subdomain" name="subdomain" value="{{ old('subdomain') }}" 
                                   placeholder="nama-bisnis" required 
                                   pattern="[a-z0-9]([a-z0-9\-]{0,61}[a-z0-9])?"
                                   style="text-transform: lowercase;">
                            <div class="subdomain-status" id="subdomainStatus" style="display: none;">
                                <i class="fas fa-spinner"></i>
                            </div>
                        </div>
                        <div class="subdomain-hint">
                            Subdomain Anda akan menjadi: <strong id="subdomainPreview">nama-bisnis</strong>.mikpay.link
                        </div>
                        @error('subdomain')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="error-message" id="subdomainError" style="display: none;"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Alamat lengkap">
                        @error('address')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="package">Pilih Paket <span style="color: #ef4444;">*</span></label>
                        <div style="display: grid; gap: 1rem; margin-top: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.75rem; padding: 1.25rem; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s; position: relative;" 
                                   onmouseover="this.style.borderColor='#4D44B5'; this.style.background='#f8fafc';" 
                                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='white';">
                                <input type="radio" name="package" value="1_bulan" id="package_1_bulan" {{ old('package') == '1_bulan' ? 'checked' : '' }} required style="width: 20px; height: 20px; cursor: pointer;">
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                        <div style="font-weight: 700; color: #1e293b; font-size: 1.125rem;">Paket 1 Bulan</div>
                                        <div style="text-align: right;">
                                            <div style="font-weight: 800; color: #4D44B5; font-size: 1.5rem;">Rp 50.000</div>
                                            <div style="font-size: 0.875rem; color: #64748b;">per bulan</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.75rem; padding: 1.25rem; border: 2px solid #f97316; border-radius: 12px; cursor: pointer; transition: all 0.3s; position: relative; background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);" 
                                   onmouseover="this.style.borderColor='#ea580c'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(249, 115, 22, 0.2)';" 
                                   onmouseout="this.style.borderColor='#f97316'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <input type="radio" name="package" value="5_bulan" id="package_5_bulan" {{ old('package') == '5_bulan' ? 'checked' : '' }} required style="width: 20px; height: 20px; cursor: pointer;">
                                <div style="flex: 1; position: relative;">
                                    <div style="position: absolute; top: -10px; right: -10px; background: #f97316; color: white; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 700; transform: rotate(12deg);">
                                        POPULER
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                        <div style="font-weight: 700; color: #1e293b; font-size: 1.125rem;">Paket 5 Bulan</div>
                                        <div style="text-align: right;">
                                            <div style="text-decoration: line-through; color: #94a3b8; font-size: 1rem; margin-bottom: 0.25rem;">Rp 250.000</div>
                                            <div style="font-weight: 800; color: #4D44B5; font-size: 1.5rem;">Rp 200.000</div>
                                            <div style="font-size: 0.875rem; color: #64748b;">5 bulan (hemat Rp 50.000)</div>
                                        </div>
                                    </div>
                                    <div style="background: #fee2e2; color: #dc2626; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; display: inline-block; margin-top: 0.5rem;">
                                        DISKON 20%
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('package')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="terms" name="terms" value="1" required>
                        <label for="terms">
                            Saya telah membaca dan menyetujui <a href="#terms-content">Syarat dan Ketentuan</a> yang berlaku <span style="color: #ef4444;">*</span>
                        </label>
                    </div>
                    @error('terms')
                        <div class="error-message" style="margin-top: -1rem; margin-bottom: 1rem;">{{ $message }}</div>
                    @enderror
                    
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </button>
                </form>
            </div>
            
            
        </div>
    </div>
    
    <script>
        const subdomainInput = document.getElementById('subdomain');
        const subdomainStatus = document.getElementById('subdomainStatus');
        const subdomainError = document.getElementById('subdomainError');
        const subdomainPreview = document.getElementById('subdomainPreview');
        const submitBtn = document.getElementById('submitBtn');
        let checkTimeout;
        
        // Auto lowercase subdomain
        subdomainInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.toLowerCase().replace(/[^a-z0-9\-]/g, '');
            subdomainPreview.textContent = e.target.value || 'nama-bisnis';
        });
        
        // Check subdomain availability
        subdomainInput.addEventListener('input', function() {
            const subdomain = this.value.trim();
            
            // Clear previous timeout
            clearTimeout(checkTimeout);
            
            if (subdomain.length < 3) {
                subdomainStatus.style.display = 'none';
                subdomainError.style.display = 'none';
                subdomainInput.classList.remove('error');
                return;
            }
            
            // Validate format
            const pattern = /^[a-z0-9]([a-z0-9\-]{0,61}[a-z0-9])?$/;
            if (!pattern.test(subdomain)) {
                subdomainStatus.style.display = 'none';
                subdomainError.style.display = 'block';
                subdomainError.textContent = 'Format tidak valid. Hanya huruf kecil, angka, dan tanda hubung';
                subdomainInput.classList.add('error');
                submitBtn.disabled = true;
                return;
            }
            
            // Debounce check
            checkTimeout = setTimeout(() => {
                checkSubdomain(subdomain);
            }, 500);
        });
        
        function checkSubdomain(subdomain) {
            subdomainStatus.style.display = 'block';
            subdomainStatus.innerHTML = '<i class="fas fa-spinner"></i>';
            subdomainError.style.display = 'none';
            subdomainInput.classList.remove('error');
            
            fetch('{{ route("registrasi.check-subdomain") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ subdomain: subdomain })
            })
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                    subdomainStatus.innerHTML = '<i class="fas fa-check-circle"></i>';
                    subdomainInput.classList.remove('error');
                    submitBtn.disabled = false;
                } else {
                    subdomainStatus.innerHTML = '<i class="fas fa-times-circle"></i>';
                    subdomainError.style.display = 'block';
                    subdomainError.textContent = data.message;
                    subdomainInput.classList.add('error');
                    submitBtn.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                subdomainStatus.style.display = 'none';
            });
        }
    </script>
</body>
</html>
