<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --success: #27ae60;
            --warning: #f39c12;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --gray: #95a5a6;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a2980, #26d0ce);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .login-header {
            background: linear-gradient(to right, var(--primary), #34495e);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to right,
                transparent 20%,
                rgba(255,255,255,0.1) 50%,
                transparent 80%
            );
            transform: rotate(30deg);
            animation: shine 3s infinite linear;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) rotate(30deg); }
            100% { transform: translateX(100%) rotate(30deg); }
        }
        
        .logo {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: white;
        }
        
        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        
        .logo-subtext {
            font-size: 0.9rem;
            opacity: 0.9;
            font-weight: 300;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            z-index: 2;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            background: white;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            z-index: 2;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, var(--secondary), #2980b9);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(52, 152, 219, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: linear-gradient(to right, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 4px solid var(--success);
        }
        
        .alert-danger {
            background: linear-gradient(to right, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 4px solid var(--accent);
        }
        
        .register-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .register-link a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .register-link a:hover {
            color: var(--primary);
            text-decoration: underline;
        }
        
        .construction-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            color: var(--gray);
            font-size: 1.2rem;
        }
        
        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }
        
        .forgot-password a {
            color: var(--gray);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .forgot-password a:hover {
            color: var(--secondary);
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--dark);
        }
        
        .form-check-input:checked {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
        
        @media (max-width: 480px) {
            .login-container {
                max-width: 100%;
            }
            
            .login-body {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-hard-hat"></i>
            </div>
            <div class="logo-text">KASIR BANGUNAN</div>
            <div class="logo-subtext">Sistem Kasir Toko Material Bangunan</div>
        </div>
        
        <div class="login-body">
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <form action="<?= base_url('auth/login') ?>" method="POST" id="loginForm">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label class="form-label fw-bold mb-2" style="color: var(--primary);">NIK</label>
                    <div class="input-icon">
                        <i class="fas fa-id-card"></i>
                        <input type="text" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('nik')) ? 'is-invalid' : '' ?>" 
                               name="nik" 
                               value="<?= old('nik') ?>" 
                               placeholder="Masukkan NIK Anda"
                               required
                               autofocus>
                    </div>
                    <?php if(session('validation') && session('validation')->hasError('nik')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('validation')->getError('nik') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label class="form-label fw-bold mb-2" style="color: var(--primary);">Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('password')) ? 'is-invalid' : '' ?>" 
                               name="password" 
                               id="password"
                               placeholder="Masukkan password"
                               required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <?php if(session('validation') && session('validation')->hasError('password')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('validation')->getError('password') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="remember-me">
                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                        <label class="form-check-label" for="rememberMe">
                            Ingat saya
                        </label>
                    </div>
                    <div class="forgot-password">
                        <a href="#">
                            <i class="fas fa-key me-1"></i>Lupa password?
                        </a>
                    </div>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>MASUK KE SISTEM</span>
                </button>
                
                <div class="register-link">
                    <p>Belum punya akun? 
                        <a href="<?= base_url('auth/register') ?>">
                            <i class="fas fa-user-plus me-1"></i>Daftar di sini
                        </a>
                    </p>
                </div>
                
                <div class="construction-icons">
                    <i class="fas fa-tools" title="Perkakas"></i>
                    <i class="fas fa-bolt" title="Listrik"></i>
                    <i class="fas fa-home" title="Material Bangunan"></i>
                    <i class="fas fa-paint-roller" title="Cat"></i>
                    <i class="fas fa-truck" title="Pengiriman"></i>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const nik = this.querySelector('input[name="nik"]').value.trim();
            const password = this.querySelector('input[name="password"]').value.trim();
            
            if (!nik || !password) {
                e.preventDefault();
                alert('Harap isi NIK dan Password!');
            }
        });
        
        // Auto focus on NIK field
        document.addEventListener('DOMContentLoaded', function() {
            const nikField = document.querySelector('input[name="nik"]');
            if (nikField) {
                nikField.focus();
            }
        });
    </script>
</body>
</html>