<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Settings - MikPay</title>
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
            background: #f8fafc;
            color: #1e293b;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, #4D44B5 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #64748b;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover, .nav-links a.active {
            color: #4D44B5;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-header h1 {
            font-size: 2rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .page-header p {
            color: #64748b;
        }
        
        .settings-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .settings-card h2 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 0.75rem;
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
        
        .form-group input[type="text"],
        .form-group input[type="number"] {
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
        
        .form-group small {
            color: #64748b;
            font-size: 0.875rem;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4D44B5 0%, #6366f1 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(77, 68, 181, 0.3);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="/" class="logo">
            <img src="{{ asset('images/logo-mikpay.png') }}" alt="MikPay Logo">
            <span>MikPay Admin</span>
        </a>
        <div class="nav-links">
            <a href="{{ route('admin.users') }}">Kelola Users</a>
            <a href="{{ route('admin.settings') }}" class="active">Settings</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #64748b; cursor: pointer; font-weight: 500;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-cog"></i> Settings</h1>
            <p>Kelola pengaturan trial dan paket MikPay</p>
        </div>

        <div id="alertMessage" class="alert"></div>

        <form id="settingsForm">
            @csrf
            
            <!-- Trial Settings -->
            <div class="settings-card">
                <h2><i class="fas fa-calendar-alt"></i> Pengaturan Trial</h2>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="trial_enabled" name="trial_enabled" {{ isset($settings['trial_enabled']) && $settings['trial_enabled'] ? 'checked' : '' }}>
                        <label for="trial_enabled">Aktifkan Trial Gratis</label>
                    </div>
                    <small>Centang untuk mengaktifkan fitur trial gratis untuk user baru</small>
                </div>
                
                <div class="form-group">
                    <label for="trial_days">Durasi Trial (Hari)</label>
                    <input type="number" id="trial_days" name="trial_days" value="{{ $settings['trial_days'] ?? 5 }}" min="0" max="365" required>
                    <small>Jumlah hari trial gratis yang diberikan kepada user baru (0-365 hari)</small>
                </div>
            </div>

            <!-- Package Settings -->
            <div class="settings-card">
                <h2><i class="fas fa-box"></i> Pengaturan Paket</h2>
                
                <div class="form-group">
                    <label for="package_basic_price">Harga Paket Basic (Rp)</label>
                    <input type="number" id="package_basic_price" name="package_basic_price" value="{{ $settings['package_basic_price'] ?? 0 }}" min="0" step="1000">
                    <small>Harga bulanan untuk paket Basic</small>
                </div>
                
                <div class="form-group">
                    <label for="package_premium_price">Harga Paket Premium (Rp)</label>
                    <input type="number" id="package_premium_price" name="package_premium_price" value="{{ $settings['package_premium_price'] ?? 0 }}" min="0" step="1000">
                    <small>Harga bulanan untuk paket Premium</small>
                </div>
                
                <div class="form-group">
                    <label for="package_enterprise_price">Harga Paket Enterprise (Rp)</label>
                    <input type="number" id="package_enterprise_price" name="package_enterprise_price" value="{{ $settings['package_enterprise_price'] ?? 0 }}" min="0" step="1000">
                    <small>Harga bulanan untuk paket Enterprise</small>
                </div>
            </div>

            <div style="text-align: center; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Settings
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('settingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const alertDiv = document.getElementById('alertMessage');
            
            fetch('{{ route("admin.settings.update") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alertDiv.className = 'alert alert-success';
                    alertDiv.textContent = data.message;
                    alertDiv.style.display = 'block';
                    setTimeout(() => {
                        alertDiv.style.display = 'none';
                    }, 3000);
                } else {
                    alertDiv.className = 'alert alert-error';
                    alertDiv.textContent = data.message || 'Terjadi kesalahan';
                    alertDiv.style.display = 'block';
                }
            })
            .catch(error => {
                alertDiv.className = 'alert alert-error';
                alertDiv.textContent = 'Terjadi kesalahan saat menyimpan settings';
                alertDiv.style.display = 'block';
            });
        });
    </script>
</body>
</html>
