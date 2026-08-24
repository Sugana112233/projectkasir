<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Kasir Bangunan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
        }
        .main-content {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-left: 260px;
        }
        .content-area {
            flex: 1 0 auto;
            padding: 30px;
        }
        .main-footer {
            flex-shrink: 0;
            padding: 15px 30px;
            border-top: 1px solid #ddd;
            background: #fff;
            text-align: center;
            margin-top: auto;
        }
        .main-footer p {
            margin: 0;
            color: #666;
            font-size: 0.85rem;
        }
        
        .top-navbar {
            background: #fff;
            padding: 0 30px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }
        .page-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #000;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            background: #000;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .logout-btn {
            background: none;
            border: 1px solid #ddd;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            color: #666;
        }
        .logout-btn:hover {
            background: #f5f5f5;
        }
        
        .card-custom {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #ddd;
            overflow: hidden;
            margin-bottom: 25px;
        }
        .card-custom-header {
            padding: 18px 25px;
            border-bottom: 1px solid #ddd;
            background: #fff;
        }
        .card-custom-header h5 {
            font-weight: 600;
            color: #000;
            margin: 0;
        }
        
        .form-control {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 10px 15px;
        }
        .form-control:focus {
            border-color: #000;
            outline: none;
            box-shadow: none;
        }
        
        .btn-dark-custom {
            background: #000;
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-dark-custom:hover {
            background: #333;
            color: #fff;
        }
        
        .setting-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        .setting-item:last-child {
            border-bottom: none;
        }
        .setting-item .icon {
            width: 40px;
            height: 40px;
            background: #f0f0f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #000;
            font-size: 1.2rem;
        }
        .setting-item .info h6 {
            font-weight: 600;
            margin: 0;
            color: #000;
        }
        .setting-item .info p {
            margin: 0;
            color: #666;
            font-size: 0.85rem;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <?= view('admin/partials/sidebar', ['menu' => 'pengaturan', 'user' => $user ?? []]) ?>
    
    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title"><i class="fas fa-cog me-2"></i> Pengaturan</div>
            <div class="d-flex align-items-center gap-3">
                <div class="user-avatar"><?= strtoupper(substr($user['nama'] ?? 'A', 0, 1)) ?></div>
                <div><strong><?= $user['nama'] ?? 'Admin' ?></strong><br><small>Admin</small></div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </div>
        </nav>
        
        <div class="content-area">
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            
            <!-- PROFIL ADMIN -->
            <div class="card-custom">
                <div class="card-custom-header">
                    <h5><i class="fas fa-user me-2"></i> Profil Admin</h5>
                </div>
                <div class="p-4">
                    <form action="<?= base_url('admin/pengaturan/updateProfil') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">NIK</label>
                                <input type="text" class="form-control" value="<?= $user['nik'] ?? '-' ?>" readonly disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="<?= $user['nama'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Level</label>
                                <input type="text" class="form-control" value="Admin" readonly disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <input type="text" class="form-control" value="Aktif" readonly disabled>
                            </div>
                        </div>
                        <button type="submit" class="btn-dark-custom">
                            <i class="fas fa-save me-2"></i> Update Profil
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- PENGATURAN LAINNYA -->
            <div class="card-custom">
                <div class="card-custom-header">
                    <h5><i class="fas fa-sliders-h me-2"></i> Pengaturan Lainnya</h5>
                </div>
                <div class="p-0">
                    <div class="setting-item">
                        <div class="d-flex align-items-center">
                            <div class="icon"><i class="fas fa-store"></i></div>
                            <div class="info">
                                <h6>Informasi Toko</h6>
                                <p>Kasir Bangunan - Tb Sari Uma Dukuh</p>
                            </div>
                        </div>
                        <span class="badge bg-dark">Aktif</span>
                    </div>
                    
                    <div class="setting-item">
                        <div class="d-flex align-items-center">
                            <div class="icon"><i class="fas fa-code"></i></div>
                            <div class="info">
                                <h6>Versi Sistem</h6>
                                <p>Versi 1.0.0</p>
                            </div>
                        </div>
                        <span class="badge bg-dark">Stabil</span>
                    </div>
                    
                    <div class="setting-item">
                        <div class="d-flex align-items-center">
                            <div class="icon"><i class="fas fa-database"></i></div>
                            <div class="info">
                                <h6>Database</h6>
                                <p>MySQL - kasir_bangunan</p>
                            </div>
                        </div>
                        <span class="badge bg-success">Online</span>
                    </div>
                    
                    <div class="setting-item">
                        <div class="d-flex align-items-center">
                            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="info">
                                <h6>Server Time</h6>
                                <p><?= date('d F Y H:i:s') ?> WIB</p>
                            </div>
                        </div>
                        <span class="badge bg-dark"><?= date('H:i') ?></span>
                    </div>
                    
                    <div class="setting-item">
                        <div class="d-flex align-items-center">
                            <div class="icon"><i class="fas fa-version"></i></div>
                            <div class="info">
                                <h6>PHP Version</h6>
                                <p>PHP <?= phpversion() ?></p>
                            </div>
                        </div>
                        <span class="badge bg-dark">PHP</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FOOTER -->
        <footer class="main-footer">
            <p>&copy; 2025 Kasir Bangunan • Sistem Kasir Tb Sari Uma Dukuh</p>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>