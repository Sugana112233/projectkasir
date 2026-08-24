<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jenis Produk - Kasir Bangunan</title>
    
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
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--gray-50); font-family: 'Segoe UI', sans-serif; }
        
        .sidebar {
            position: fixed; left: 0; top: 0; width: 260px; height: 100%;
            background: #000000; z-index: 1000; overflow-y: auto;
        }
        .sidebar .logo { padding: 25px 20px; border-bottom: 1px solid #333; }
        .sidebar .logo h3 { color: #fff; font-size: 1.2rem; }
        .sidebar .logo p { color: #999; font-size: 11px; margin: 5px 0 0; }
        .sidebar .menu { list-style: none; padding: 10px 0; }
        .sidebar .menu li a {
            display: block; padding: 12px 20px; color: #ccc;
            text-decoration: none; transition: all 0.3s;
        }
        .sidebar .menu li a:hover { background: #333; color: #fff; }
        .sidebar .menu li a.active { background: #333; color: #fff; border-left: 3px solid #fff; }
        .sidebar .footer {
            padding: 20px; border-top: 1px solid #333;
            position: absolute; bottom: 0; left: 0; right: 0;
            background: #000;
        }
        .sidebar .footer a {
            display: block; padding: 10px; background: #fff; color: #000;
            text-align: center; text-decoration: none; border-radius: 6px;
            font-weight: 600;
        }
        
        .main-content { margin-left: 260px; min-height: 100vh; }
        .top-navbar {
            background: #fff; padding: 0 30px; height: 70px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }
        .page-title { font-size: 1.3rem; font-weight: 600; color: #000; }
        .user-avatar {
            width: 40px; height: 40px; background: #000; color: #fff;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-weight: 600;
        }
        .content-area { padding: 30px; }
        .logout-btn { background: none; border: 1px solid #ddd; padding: 8px 15px; border-radius: 6px; text-decoration: none; color: #666; }
        .logout-btn:hover { background: #f5f5f5; }
        
        .form-card {
            background: #fff; border-radius: 12px; border: 1px solid #ddd;
            padding: 30px; max-width: 600px; margin: 0 auto;
        }
        .form-label { font-weight: 600; color: #000; }
        .form-control { border: 2px solid #ddd; border-radius: 8px; padding: 10px 15px; }
        .form-control:focus { border-color: #000; outline: none; }
        .btn-dark { background: #000; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 600; width: 100%; text-align: center; text-decoration: none; display: inline-block; }
        .btn-dark:hover { background: #333; color: #fff; }
        .btn-outline-dark { background: none; border: 1px solid #ddd; color: #666; padding: 12px; border-radius: 8px; font-weight: 600; width: 100%; text-align: center; text-decoration: none; display: inline-block; }
        .btn-outline-dark:hover { background: #f5f5f5; color: #333; }
        
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <?= view('admin/partials/sidebar', ['menu' => 'jenis_produk', 'user' => $user ?? []]) ?>
    
    <?php 
        // Konversi ke array jika $jenis dikirim dalam bentuk Object
        if (is_object($jenis)) {
            $jenis = (array) $jenis;
        }
    ?>

    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title"><i class="fas fa-edit me-2"></i> Edit Jenis Produk</div>
            <div class="d-flex align-items-center gap-3">
                <div class="user-avatar"><?= strtoupper(substr($user['nama'] ?? 'A', 0, 1)) ?></div>
                <div><strong><?= $user['nama'] ?? 'Admin' ?></strong><br><small>Admin</small></div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </div>
        </nav>
        
        <div class="content-area">
            <div class="mb-3">
                <a href="<?= base_url('admin/jenis-produk') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
            
            <div class="form-card">
                <h4 class="fw-bold mb-4"><i class="fas fa-edit me-2"></i> Form Edit Jenis Produk</h4>
                
                <form action="<?= base_url('admin/jenis-produk/update/' . ($jenis['id'] ?? '')) ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Kode Jenis</label>
                        <input type="text" name="kode_jenis" class="form-control" value="<?= $jenis['kode_jenis'] ?? '' ?>" required readonly>
                        <small class="text-muted">Kode tidak dapat diubah</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Jenis</label>
                        <input type="text" name="nama_jenis" class="form-control <?= (session('validation') && session('validation')->hasError('nama_jenis')) ? 'is-invalid' : '' ?>" value="<?= $jenis['nama_jenis'] ?? '' ?>" required>
                        <?php if(session('validation') && session('validation')->hasError('nama_jenis')): ?>
                            <div class="invalid-feedback"><?= session('validation')->getError('nama_jenis') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"><?= $jenis['keterangan'] ?? '' ?></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" value="1" <?= (($jenis['status'] ?? '') == 'aktif') ? 'checked' : '' ?>>
                            <label class="form-check-label">Aktif</label>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn-dark"><i class="fas fa-save me-2"></i> Update</button>
                        <a href="<?= base_url('admin/jenis-produk') ?>" class="btn-outline-dark"><i class="fas fa-times me-2"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
        
        <footer class="text-center py-3 border-top bg-white mt-auto">
            <p class="text-muted small mb-0">&copy; 2025 Kasir Bangunan</p>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>