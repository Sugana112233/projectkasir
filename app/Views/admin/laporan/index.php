<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Kasir Bangunan</title>
    
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
            --gray-400: #BDBDBD;
            --gray-500: #9E9E9E;
            --gray-600: #757575;
            --gray-700: #616161;
            --gray-800: #424242;
            --gray-900: #212121;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--gray-50); font-family: 'Segoe UI', sans-serif; }
        
        .main-content { margin-left: 260px; min-height: 100vh; }
        .top-navbar {
            background: var(--white); padding: 0 30px; height: 70px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid var(--gray-200);
        }
        .page-title { font-size: 1.3rem; font-weight: 600; color: var(--black); }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .user-avatar {
            width: 40px; height: 40px; background: var(--black); color: var(--white);
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;
        }
        .logout-btn {
            background: none; border: 1px solid var(--gray-300); padding: 8px 15px;
            border-radius: 6px; text-decoration: none; color: var(--gray-600);
        }
        .logout-btn:hover { background: var(--gray-100); color: var(--black); }
        .content-area { padding: 30px; }
        
        .card-custom {
            background: var(--white); border-radius: 12px; border: 1px solid var(--gray-200);
            overflow: hidden; transition: all 0.3s;
        }
        .card-custom:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .card-custom-header {
            padding: 18px 25px; border-bottom: 1px solid var(--gray-200);
            background: var(--white);
        }
        .card-custom-header h5 { font-weight: 600; color: var(--black); margin: 0; }
        
        .menu-card {
            background: var(--white); border-radius: 12px; border: 1px solid var(--gray-200);
            padding: 25px; text-align: center; transition: all 0.3s; cursor: pointer;
            height: 100%;
        }
        .menu-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-color: var(--black); }
        .menu-card .icon { font-size: 2.5rem; color: var(--black); margin-bottom: 15px; }
        .menu-card h5 { font-weight: 600; color: var(--black); }
        .menu-card p { color: var(--gray-600); font-size: 0.85rem; }
        .menu-card .btn-dark-custom {
            background: var(--black); color: var(--white); border: none;
            padding: 8px 25px; border-radius: 6px; text-decoration: none;
            font-weight: 500; display: inline-block; transition: all 0.3s;
        }
        .menu-card .btn-dark-custom:hover { background: var(--gray-800); transform: scale(1.02); }
        
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <?= view('admin/partials/sidebar', ['menu' => 'laporan', 'user' => $user ?? []]) ?>
    
    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title"><i class="fas fa-chart-line me-2"></i> Laporan</div>
            <div class="user-info">
                <div class="user-avatar"><?= strtoupper(substr($user['nama'] ?? 'A', 0, 1)) ?></div>
                <div><strong><?= $user['nama'] ?? 'Admin' ?></strong><br><small>Admin</small></div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </div>
        </nav>
        
        <div class="content-area">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1" style="color: var(--black);">Laporan</h2>
                    <p class="text-muted small">Pilih jenis laporan yang ingin Anda lihat</p>
                </div>
                <div>
                    <span class="badge bg-dark p-2">
                        <i class="fas fa-calendar-alt me-1"></i> <?= date('d F Y') ?>
                    </span>
                </div>
            </div>
            
            <!-- Menu Cards -->
            <div class="row">
                <!-- Laporan Keuangan -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="menu-card">
                        <div class="icon"><i class="fas fa-file-invoice"></i></div>
                        <h5>Laporan Keuangan</h5>
                        <p>Ringkasan penjualan, pemasukan, dan pengeluaran</p>
                        <a href="<?= base_url('admin/laporan/keuangan') ?>" class="btn-dark-custom">
                            <i class="fas fa-arrow-right me-2"></i> Lihat Laporan
                        </a>
                    </div>
                </div>
                
                <!-- Pengeluaran -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="menu-card">
                        <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                        <h5>Pengeluaran</h5>
                        <p>Kelola dan lihat data pengeluaran</p>
                        <a href="<?= base_url('admin/pengeluaran') ?>" class="btn-dark-custom">
                            <i class="fas fa-arrow-right me-2"></i> Lihat Pengeluaran
                        </a>
                    </div>
                </div>
                
                <!-- Pemasukan -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="menu-card">
                        <div class="icon"><i class="fas fa-arrow-trend-up"></i></div>
                        <h5>Pemasukan Manual</h5>
                        <p>Kelola dan lihat data pemasukan manual</p>
                        <a href="<?= base_url('admin/pemasukan') ?>" class="btn-dark-custom">
                            <i class="fas fa-arrow-right me-2"></i> Lihat Pemasukan
                        </a>
                    </div>
                </div>
            </div>
            
           <!-- Statistik Cepat -->
<div class="card mt-4">
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0"><i class="fas fa-chart-simple me-2"></i> Statistik Cepat</h5>
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <div class="p-3 border rounded">
                    <div class="fs-3 fw-bold text-primary"><?= $total_transaksi ?? 0 ?></div>
                    <div class="text-muted">Total Transaksi</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="p-3 border rounded">
                    <div class="fs-3 fw-bold text-success">Rp <?= number_format($total_pemasukan ?? 0, 0, ',', '.') ?></div>
                    <div class="text-muted">Total Pemasukan</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="p-3 border rounded">
                    <div class="fs-3 fw-bold text-danger">Rp <?= number_format($total_pengeluaran ?? 0, 0, ',', '.') ?></div>
                    <div class="text-muted">Total Pengeluaran</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="p-3 border rounded">
                    <div class="fs-3 fw-bold <?= ($saldo_bersih ?? 0) >= 0 ? 'text-dark' : 'text-danger' ?>">
                        Rp <?= number_format($saldo_bersih ?? 0, 0, ',', '.') ?>
                    </div>
                    <div class="text-muted">Saldo Bersih</div>
                </div>
            </div>
        </div>
    </div>
</div>
        
        <footer class="text-center py-3 border-top bg-white">
            <p class="text-muted small mb-0">&copy; 2025 Kasir Bangunan</p>
        </footer>
    </div>
</body>
</html>