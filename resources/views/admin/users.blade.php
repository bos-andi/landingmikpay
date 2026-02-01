<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Users - MikPay</title>
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
        
        .logo img {
            height: 32px;
            width: auto;
        }
        
        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        
        .nav-links a {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
        }
        
        .nav-links a:hover, .nav-links a.active {
            color: #4D44B5;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .page-header {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .page-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .page-header p {
            color: #64748b;
        }
        
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #f1f5f9;
        }
        
        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        tr:hover {
            background: #f8fafc;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .status-active {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }
        
        .btn-success {
            background: #10b981;
            color: white;
        }
        
        .btn-danger {
            background: #ef4444;
            color: white;
        }
        
        .btn-warning {
            background: #f59e0b;
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #cbd5e1;
        }
        
        .btn-primary {
            background: #6366f1;
            color: white;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .modal-header h2 {
            margin: 0;
            color: #1e293b;
        }
        
        .close {
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
            border: none;
            background: none;
        }
        
        .close:hover {
            color: #1e293b;
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
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #6366f1;
        }
        
        .form-group small {
            color: #64748b;
            font-size: 0.875rem;
        }
        
        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }
        
        .btn-cancel {
            background: #e2e8f0;
            color: #1e293b;
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
            <a href="{{ route('admin.users') }}" class="active">Kelola Users</a>
            <a href="{{ route('admin.settings') }}">Settings</a>
            <span>Selamat datang, {{ auth()->user()->name }}</span>
            <a href="{{ route('logout') }}">Logout</a>
        </div>
    </nav>
    
    <div class="container">
        <div class="page-header">
            <h1>Kelola Users</h1>
            <p>Kelola dan aktifkan akun pengguna yang mendaftar</p>
        </div>
        
        <div class="table-container">
            @if($users->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Subdomain</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->subdomain)
                                        <strong>{{ $user->subdomain }}.mikpay.link</strong>
                                    @else
                                        <span style="color: #cbd5e1;">-</span>
                                    @endif
                                </td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    <span class="status-badge status-{{ $user->status }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="actions">
                                        @if($user->status === 'pending')
                                            <button class="btn btn-success btn-sm" onclick="updateStatus({{ $user->id }}, 'active')">
                                                <i class="fas fa-check"></i> Aktifkan
                                            </button>
                                        @elseif($user->status === 'active')
                                            <button class="btn btn-warning btn-sm" onclick="updateStatus({{ $user->id }}, 'inactive')">
                                                <i class="fas fa-pause"></i> Nonaktifkan
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm" onclick="updateStatus({{ $user->id }}, 'active')">
                                                <i class="fas fa-check"></i> Aktifkan
                                            </button>
                                        @endif
                                        <button class="btn btn-primary btn-sm" onclick="showSendEmailModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')" style="background: #6366f1;">
                                            <i class="fas fa-envelope"></i> Kirim Email
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>Belum ada user yang mendaftar</p>
                </div>
            @endif
        </div>
    </div>
    
    <script>
        function updateStatus(userId, status) {
            if (!confirm('Yakin ingin mengubah status user ini?')) {
                return;
            }
            
            fetch(`/admin/users/${userId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengupdate status');
            });
        }
        
        function deleteUser(userId) {
            if (!confirm('Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')) {
                return;
            }
            
            fetch(`/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus user');
            });
        }
        
        function showSendEmailModal(userId, userName, userEmail) {
            const modal = document.getElementById('emailModal');
            document.getElementById('modalUserName').textContent = userName;
            document.getElementById('modalUserEmail').textContent = userEmail;
            document.getElementById('sendEmailUserId').value = userId;
            document.getElementById('customPassword').value = '';
            modal.style.display = 'flex';
        }
        
        function closeEmailModal() {
            document.getElementById('emailModal').style.display = 'none';
        }
        
        function sendEmail() {
            const userId = document.getElementById('sendEmailUserId').value;
            const customPassword = document.getElementById('customPassword').value;
            
            if (!confirm('Yakin ingin mengirim email credentials ke user ini?')) {
                return;
            }
            
            const btn = document.getElementById('sendEmailBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            
            fetch(`/admin/users/${userId}/send-credentials`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    password: customPassword || null 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeEmailModal();
                } else {
                    alert('Error: ' + (data.message || 'Terjadi kesalahan'));
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-envelope"></i> Kirim Email';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim email');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-envelope"></i> Kirim Email';
            });
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('emailModal');
            if (event.target == modal) {
                closeEmailModal();
            }
        }
    </script>
    
    <!-- Email Modal -->
    <div id="emailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-envelope"></i> Kirim Email Credentials</h2>
                <button class="close" onclick="closeEmailModal()">&times;</button>
            </div>
            
            <div class="form-group">
                <label>Nama User:</label>
                <div id="modalUserName" style="padding: 0.5rem; background: #f1f5f9; border-radius: 6px;"></div>
            </div>
            
            <div class="form-group">
                <label>Email Tujuan:</label>
                <div id="modalUserEmail" style="padding: 0.5rem; background: #f1f5f9; border-radius: 6px;"></div>
            </div>
            
            <div class="form-group">
                <label for="customPassword">Password Custom (Opsional):</label>
                <input type="text" id="customPassword" placeholder="Kosongkan untuk generate otomatis">
                <small>Jika dikosongkan, sistem akan generate password random 12 karakter</small>
            </div>
            
            <div style="background: #fef3c7; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border-left: 4px solid #f59e0b;">
                <strong>⚠️ Perhatian:</strong> Email akan dikirim dari <strong>admin@mikpay.link</strong> ke email user di atas. 
                Pastikan konfigurasi email sudah benar di file <code>.env</code>.
            </div>
            
            <input type="hidden" id="sendEmailUserId">
            
            <div class="modal-actions">
                <button class="btn btn-cancel" onclick="closeEmailModal()">Batal</button>
                <button class="btn btn-primary" id="sendEmailBtn" onclick="sendEmail()">
                    <i class="fas fa-envelope"></i> Kirim Email
                </button>
            </div>
        </div>
    </div>
</body>
</html>
