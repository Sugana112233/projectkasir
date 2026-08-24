<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Kasir Bangunan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --black: #000000;
            --white: #FFFFFF;
            --gray-50: #FAFAFA;
            --gray-100: #F5F5F5;
            --gray-200: #EEEEEE;
            --gray-300: #E0E0E0;
            --gray-600: #757575;
        }
        
        body {
            background: var(--gray-50);
            font-family: 'Segoe UI', sans-serif;
        }
        
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }
        
        .top-navbar {
            background: var(--white);
            padding: 0 30px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .page-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--black);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--black);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .content-area {
            padding: 30px;
        }
        
        .form-card {
            background: var(--white);
            border-radius: 12px;
            padding: 30px;
            border: 1px solid var(--gray-200);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 2px solid var(--gray-300);
            border-radius: 8px;
            padding: 10px 15px;
        }
        
        .form-control:focus {
            border-color: var(--black);
            box-shadow: none;
        }
        
        .btn-submit {
            background: var(--black);
            color: var(--white);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
        }
        
        .btn-submit:hover {
            background: var(--gray-800);
        }
        
        .logout-btn {
            background: none;
            border: 1px solid var(--gray-300);
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            color: var(--gray-600);
        }
    </style>
</head>
<body>
    <?= view('admin/partials/sidebar', ['menu' => $menu, 'user' => $user]) ?>
    
    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title">
                <i class="fas fa-user-plus me-2"></i> Tambah Kasir Baru
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <?= strtoupper(substr($user['nama'], 0, 1)) ?>
                </div>
                <div>
                    <strong><?= $user['nama'] ?></strong><br>
                    <small class="text-muted">Admin</small>
                </div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </div>
        </nav>
        
        <div class="content-area">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            
            <div class="form-card">
                <h4 class="mb-4">Form Tambah Kasir</h4>
                
                <form action="<?= base_url('admin/kasir/store') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control <?= (session('validation') && session('validation')->hasError('nik')) ? 'is-invalid' : '' ?>" value="<?= old('nik') ?>" required>
                        <?php if(session('validation') && session('validation')->hasError('nik')): ?>
                            <div class="invalid-feedback"><?= session('validation')->getError('nik') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control <?= (session('validation') && session('validation')->hasError('nama')) ? 'is-invalid' : '' ?>" value="<?= old('nama') ?>" required>
                        <?php if(session('validation') && session('validation')->hasError('nama')): ?>
                            <div class="invalid-feedback"><?= session('validation')->getError('nama') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control <?= (session('validation') && session('validation')->hasError('password')) ? 'is-invalid' : '' ?>" required>
                        <?php if(session('validation') && session('validation')->hasError('password')): ?>
                            <div class="invalid-feedback"><?= session('validation')->getError('password') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" class="form-control <?= (session('validation') && session('validation')->hasError('confirm_password')) ? 'is-invalid' : '' ?>" required>
                        <?php if(session('validation') && session('validation')->hasError('confirm_password')): ?>
                            <div class="invalid-feedback"><?= session('validation')->getError('confirm_password') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" value="1" checked>
                            <label class="form-check-label">Aktifkan akun kasir</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save me-2"></i> Simpan Kasir
                    </button>
                    
                    <a href="<?= base_url('admin/kasir') ?>" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
        
        <footer class="p-3 text-center border-top bg-white">
            <p class="text-muted mb-0">&copy; 2025 Kasir Bangunan</p>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>