<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Kasir Bangunan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: 'Segoe UI', sans-serif; }
        
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
        
        .card-custom {
            background: #fff; border-radius: 12px; border: 1px solid #ddd; overflow: hidden;
        }
        .card-custom-header {
            padding: 18px 25px; border-bottom: 1px solid #ddd; background: #fff;
        }
        .stat-box {
            background: #fff; border-radius: 10px; padding: 20px;
            border: 1px solid #ddd; text-align: center;
        }
        .stat-value { font-size: 1.5rem; font-weight: 700; }
        .stat-label { font-size: 0.75rem; color: #666; text-transform: uppercase; letter-spacing: 0.5px; }
        .table-custom { width: 100%; border-collapse: collapse; }
        .table-custom th { background: #f8f9fa; padding: 12px 15px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd; }
        .table-custom td { padding: 12px 15px; border-bottom: 1px solid #ddd; }
        .table-custom tr:hover { background: #f8f9fa; }
        .btn-dark { background: #000; color: #fff; border: none; padding: 8px 20px; border-radius: 6px; text-decoration: none; }
        .btn-dark:hover { background: #333; color: #fff; }
        
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <!-- PEMANGGILAN SIDEBAR PARTIAL (KONSISTEN MEMAKAI MENU 'laporan') -->
    <?php if (file_exists(APPPATH . 'Views/admin/partials/sidebar.php')): ?>
        <?= view('admin/partials/sidebar', ['menu' => 'laporan', 'user' => $user ?? []]) ?>
    <?php else: ?>
        <div class="sidebar">
            <div class="logo">
                <h3><i class="fas fa-store me-2"></i>Kasir Bangunan</h3>
                <p>Toko Material Bangunan</p>
            </div>
            <ul class="menu">
                <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="<?= base_url('admin/kasir') ?>"><i class="fas fa-users"></i> Data Kasir</a></li>
                <li><a href="<?= base_url('admin/produk') ?>"><i class="fas fa-boxes"></i> Produk</a></li>
                <li><a href="<?= base_url('admin/jenis-produk') ?>"><i class="fas fa-tags"></i> Jenis Produk</a></li>
                <li><a href="<?= base_url('admin/laporan') ?>" class="active"><i class="fas fa-chart-line"></i> Laporan</a></li>
                <li><a href="#"><i class="fas fa-money-bill-wave"></i> Keuangan</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
            </ul>
            <div class="footer">
                <a href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title"><i class="fas fa-file-invoice me-2"></i> Laporan Keuangan</div>
            <div class="d-flex align-items-center gap-3">
                <div class="user-avatar"><?= strtoupper(substr($user['nama'] ?? 'A', 0, 1)) ?></div>
                <div><strong><?= esc($user['nama'] ?? 'Admin') ?></strong><br><small><?= esc(ucfirst($user['level'] ?? 'Admin')) ?></small></div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </div>
        </nav>
        
        <div class="content-area">
            <div class="mb-3">
                <a href="<?= base_url('admin/laporan') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
            
            <!-- Filter -->
            <div class="card-custom mb-4">
                <div class="card-custom-header">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i> Filter Periode</h5>
                </div>
                <div class="p-4">
                    <form method="post" action="<?= base_url('admin/laporan/keuangan') ?>" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="<?= $start_date ?? date('Y-m-01') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control" value="<?= $end_date ?? date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn-dark w-100"><i class="fas fa-search me-2"></i> Tampilkan</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Statistik -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-box">
                        <div class="stat-value text-primary">Rp <?= number_format($total_penjualan ?? 0, 0, ',', '.') ?></div>
                        <div class="stat-label">Total Penjualan</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-box">
                        <div class="stat-value text-success">Rp <?= number_format($total_pemasukan ?? 0, 0, ',', '.') ?></div>
                        <div class="stat-label">Pemasukan Manual</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-box">
                        <div class="stat-value text-danger">Rp <?= number_format($total_pengeluaran ?? 0, 0, ',', '.') ?></div>
                        <div class="stat-label">Total Pengeluaran</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-box">
                        <div class="stat-value <?= ($total_pendapatan_bersih ?? 0) >= 0 ? 'text-dark' : 'text-danger' ?>">
                            Rp <?= number_format($total_pendapatan_bersih ?? 0, 0, ',', '.') ?>
                        </div>
                        <div class="stat-label">Saldo Bersih</div>
                    </div>
                </div>
            </div>
            
            <!-- Tabel Pendapatan Harian -->
            <div class="card-custom">
                <div class="card-custom-header">
                    <h5 class="mb-0"><i class="fas fa-table me-2"></i> Pendapatan Harian</h5>
                </div>
                <div class="p-0">
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Transaksi</th>
                                    <th>Penjualan</th>
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($pendapatan_harian)): ?>
                                    <?php $no=1; foreach($pendapatan_harian as $h): ?>
                                    <?php 
                                        $penjualan   = $h['total'] ?? $h['total_penjualan'] ?? 0;
                                        $pemasukan   = $h['pemasukan'] ?? $h['total_pemasukan'] ?? 0;
                                        $pengeluaran = $h['pengeluaran'] ?? $h['total_pengeluaran'] ?? 0;
                                        $transaksi   = $h['total_transaksi'] ?? $h['jumlah'] ?? 0;
                                        $saldo       = ($penjualan + $pemasukan) - $pengeluaran;
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= date('d/m/Y', strtotime($h['tanggal'])) ?></td>
                                        <td class="text-center"><?= $transaksi ?></td>
                                        <td>Rp <?= number_format($penjualan, 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($pemasukan, 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($pengeluaran, 0, ',', '.') ?></td>
                                        <td class="fw-bold <?= $saldo >= 0 ? 'text-dark' : 'text-danger' ?>">
                                            Rp <?= number_format($saldo, 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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