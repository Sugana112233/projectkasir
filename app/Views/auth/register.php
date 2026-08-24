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
            background: linear-gradient(135deg, #8e44ad, #3498db);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .register-container {
            width: 100%;
            max-width: 480px;
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
        
        .register-header {
            background: linear-gradient(to right, #e74c3c, #c0392b);
            color: white;
            padding: 25px 20px;
            text-align: center;
            position: relative;
        }
        
        .register-icon {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        
        .register-title {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .register-subtitle {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-top: 5px;
        }
        
        .register-body {
            padding: 25px;
        }
        
        .first-user-alert {
            background: linear-gradient(to right, #fff3cd, #ffeaa7);
            border-left: 4px solid var(--warning);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .first-user-alert i {
            color: var(--warning);
            margin-right: 10px;
        }
        
        .form-group {
            margin-bottom: 18px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 8px;
            font-size: 0.95rem;
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
        
        .form-control, .form-select {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%232c3e50' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px 12px;
            padding-right: 45px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            background: white;
        }
        
        .level-option {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        
        .level-option:hover {
            background: #f8f9fa;
        }
        
        .level-option.selected {
            border-color: var(--secondary);
            background: rgba(52, 152, 219, 0.1);
        }
        
        .level-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
            color: white;
        }
        
        .level-icon.admin {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
        }
        
        .level-icon.kasir {
            background: linear-gradient(45deg, #3498db, #2980b9);
        }
        
        .level-info h6 {
            margin-bottom: 3px;
            font-weight: 600;
        }
        
        .level-info p {
            font-size: 0.8rem;
            color: var(--gray);
            margin-bottom: 0;
        }
        
        .password-strength {
            height: 5px;
            background: #eee;
            border-radius: 3px;
            margin-top: 8px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s, background 0.3s;
        }
        
        .password-match {
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }
        
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, var(--accent), #c0392b);
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
            margin-top: 15px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(231, 76, 60, 0.3);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .login-link a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .login-link a:hover {
            color: var(--primary);
            text-decoration: underline;
        }
        
        .material-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin-top: 15px;
        }
        
        .material-tag {
            background: var(--primary);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        @media (max-width: 480px) {
            .register-container {
                max-width: 100%;
            }
            
            .register-body {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="register-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="register-title">PENDAFTARAN AKUN</div>
            <div class="register-subtitle">
                <?= $isFirstUser ? 'Buat Akun Administrator Pertama' : 'Tambah Pengguna Baru' ?>
            </div>
        </div>
        
        <div class="register-body">
            <?php if($isFirstUser): ?>
                <div class="first-user-alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Akun Administrator Pertama!</strong>
                    <p class="mb-0 mt-1" style="font-size: 0.9rem;">
                        Anda akan membuat akun administrator pertama dengan hak akses penuh.
                        Akun ini dapat menambahkan pengguna lain (admin/kasir).
                    </p>
                </div>
            <?php endif; ?>
            
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
            
            <form action="<?= base_url('auth/register') ?>" method="POST" id="registerForm">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label class="form-label">NIK (Nomor Induk Karyawan)</label>
                    <div class="input-icon">
                        <i class="fas fa-id-badge"></i>
                        <input type="text" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('nik')) ? 'is-invalid' : '' ?>" 
                               name="nik" 
                               value="<?= old('nik') ?>" 
                               placeholder="Contoh: ADM001, KSR001"
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
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('nama')) ? 'is-invalid' : '' ?>" 
                               name="nama" 
                               value="<?= old('nama') ?>" 
                               placeholder="Masukkan nama lengkap"
                               required>
                    </div>
                    <?php if(session('validation') && session('validation')->hasError('nama')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('validation')->getError('nama') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if(!$isFirstUser): ?>
                <!-- PILIHAN LEVEL (hanya tampil jika BUKAN first user) -->
                <div class="form-group">
                    <label class="form-label">Level Pengguna</label>
                    
                    <!-- Option 1: Dropdown Select -->
                    <div class="input-icon">
                        <i class="fas fa-user-tag"></i>
                        <select class="form-select <?= (session('validation') && session('validation')->hasError('level')) ? 'is-invalid' : '' ?>" 
                                name="level"
                                id="levelSelect"
                                required>
                            <option value="">-- Pilih Level Pengguna --</option>
                            <option value="admin" <?= old('level') == 'admin' ? 'selected' : '' ?>>Administrator</option>
                            <option value="kasir" <?= old('level') == 'kasir' ? 'selected' : '' ?>>Kasir</option>
                        </select>
                    </div>
                    
                    <?php if(session('validation') && session('validation')->hasError('level')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('validation')->getError('level') ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Option 2: Radio Button Style (lebih user friendly) -->
                    <div class="mt-3">
                        <div class="level-option <?= old('level') == 'admin' ? 'selected' : '' ?>" 
                             onclick="selectLevel('admin')">
                            <div class="level-icon admin">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="level-info">
                                <h6>Administrator</h6>
                                <p>Akses penuh: master data, laporan, transaksi</p>
                            </div>
                        </div>
                        
                        <div class="level-option <?= old('level') == 'kasir' ? 'selected' : '' ?>" 
                             onclick="selectLevel('kasir')">
                            <div class="level-icon kasir">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <div class="level-info">
                                <h6>Kasir</h6>
                                <p>Akses terbatas: transaksi penjualan saja</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="level" id="selectedLevel" value="<?= old('level') ?>">
                </div>
                <?php else: ?>
                    <!-- Jika first user, otomatis admin -->
                    <input type="hidden" name="level" value="admin">
                <?php endif; ?>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('password')) ? 'is-invalid' : '' ?>" 
                               name="password" 
                               id="password"
                               placeholder="Minimal 6 karakter"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray); cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrengthBar"></div>
                    </div>
                    <?php if(session('validation') && session('validation')->hasError('password')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('validation')->getError('password') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('confirm_password')) ? 'is-invalid' : '' ?>" 
                               name="confirm_password" 
                               id="confirm_password"
                               placeholder="Ketik ulang password"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray); cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-match" id="passwordMatch"></div>
                    <?php if(session('validation') && session('validation')->hasError('confirm_password')): ?>
                        <div class="invalid-feedback d-block">
                            <?= session('validation')->getError('confirm_password') ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i>
                    <span>
                        <?php if($isFirstUser): ?>
                            BUAT AKUN ADMINISTRATOR
                        <?php else: ?>
                            TAMBAHKAN PENGGUNA
                        <?php endif; ?>
                    </span>
                </button>
                
                <?php if($isFirstUser): ?>
                    <div class="login-link">
                        <p>Setelah membuat akun, Anda akan langsung login sebagai Administrator.</p>
                    </div>
                <?php else: ?>
                    <div class="login-link">
                        <p>Kembali ke 
                            <a href="<?= base_url('admin/dashboard') ?>">
                                <i class="fas fa-arrow-left me-1"></i>Dashboard Admin
                            </a>
                        </p>
                    </div>
                <?php endif; ?>
                
                <div class="material-tags">
                    <span class="material-tag">Semen</span>
                    <span class="material-tag">Cat</span>
                    <span class="material-tag">Paku</span>
                    <span class="material-tag">Pipa</span>
                    <span class="material-tag">Keramik</span>
                    <span class="material-tag">Besi</span>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Fungsi untuk pilihan level (radio button style)
        function selectLevel(level) {
            // Update dropdown select
            document.getElementById('levelSelect').value = level;
            document.getElementById('selectedLevel').value = level;
            
            // Update UI radio button style
            const options = document.querySelectorAll('.level-option');
            options.forEach(opt => {
                opt.classList.remove('selected');
                if (opt.getAttribute('onclick') === `selectLevel('${level}')`) {
                    opt.classList.add('selected');
                }
            });
        }
        
        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrengthBar');
            let strength = 0;
            
            if (password.length >= 6) strength += 25;
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            if (/[^A-Za-z0-9]/.test(password)) strength += 25;
            
            strength = Math.min(strength, 100);
            strengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                strengthBar.style.background = '#e74c3c';
            } else if (strength < 75) {
                strengthBar.style.background = '#f39c12';
            } else {
                strengthBar.style.background = '#27ae60';
            }
        });
        
        // Password match checker
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const matchDiv = document.getElementById('passwordMatch');
            
            if (confirmPassword === '') {
                matchDiv.style.display = 'none';
                return;
            }
            
            matchDiv.style.display = 'block';
            if (password === confirmPassword) {
                matchDiv.innerHTML = '<i class="fas fa-check-circle text-success"></i> Password cocok';
                matchDiv.className = 'password-match text-success';
            } else {
                matchDiv.innerHTML = '<i class="fas fa-times-circle text-danger"></i> Password tidak cocok';
                matchDiv.className = 'password-match text-danger';
            }
        });
        
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Auto focus on first field
        document.addEventListener('DOMContentLoaded', function() {
            const firstField = document.querySelector('input[name="nik"]');
            if (firstField) {
                firstField.focus();
            }
            
            // Set initial level selection jika ada old value
            const oldLevel = "<?= old('level') ?>";
            if (oldLevel) {
                selectLevel(oldLevel);
            }
        });
    </script>
</body>
</html>