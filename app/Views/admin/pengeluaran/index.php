<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengeluaran - Kasir Bangunan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html, body { height: 100%; margin: 0; }
        body { display: flex; flex-direction: column; min-height: 100vh; background: #f5f5f5; font-family: 'Segoe UI', sans-serif; }
        .main-content { flex: 1 0 auto; display: flex; flex-direction: column; min-height: 100vh; margin-left: 260px; }
        .content-area { flex: 1 0 auto; padding: 30px; }
        .main-footer { flex-shrink: 0; padding: 15px 30px; border-top: 1px solid #ddd; background: #fff; text-align: center; margin-top: auto; }
        .main-footer p { margin: 0; color: #666; font-size: 0.85rem; }
        
        .top-navbar { background: #fff; padding: 0 30px; height: 70px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ddd; }
        .page-title { font-size: 1.3rem; font-weight: 600; color: #000; }
        .user-avatar { width: 40px; height: 40px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; }
        .logout-btn { background: none; border: 1px solid #ddd; padding: 8px 15px; border-radius: 6px; text-decoration: none; color: #666; }
        .logout-btn:hover { background: #f5f5f5; }
        
        .card-custom { background: #fff; border-radius: 12px; border: 1px solid #ddd; overflow: hidden; }
        .card-custom-header { padding: 18px 25px; border-bottom: 1px solid #ddd; background: #fff; }
        .btn-dark-custom { background: #000; color: #fff; border: none; padding: 8px 20px; border-radius: 6px; text-decoration: none; }
        .btn-dark-custom:hover { background: #333; color: #fff; }
        .table-custom { width: 100%; border-collapse: collapse; }
        .table-custom th { background: #f8f9fa; padding: 12px 15px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd; }
        .table-custom td { padding: 12px 15px; border-bottom: 1px solid #ddd; vertical-align: middle; }
        .table-custom tr:hover { background: #f8f9fa; }
        .btn-edit { background: #f0f0f0; color: #333; border: none; padding: 5px 10px; border-radius: 4px; }
        .btn-edit:hover { background: #ddd; }
        .btn-delete { background: #fee; color: #dc3545; border: none; padding: 5px 10px; border-radius: 4px; }
        .btn-delete:hover { background: #fdd; }
        
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <!-- ========== SIDEBAR PAKAI PARTIAL ========== -->
    <?= view('admin/partials/sidebar', ['menu' => 'pengeluaran']) ?>
    
    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title"><i class="fas fa-money-bill-wave me-2"></i> Data Pengeluaran</div>
            <div class="d-flex align-items-center gap-3">
                <div class="user-avatar">A</div>
                <div><strong>Admin</strong><br><small>Admin</small></div>
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
            
            <div class="card-custom">
                <div class="card-custom-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i> Daftar Pengeluaran</h5>
                    <a href="<?= base_url('admin/pengeluaran/create') ?>" class="btn-dark-custom">
                        <i class="fas fa-plus me-2"></i> Tambah Pengeluaran
                    </a>
                </div>
                <div class="p-0">
                    <div class="table-responsive">
                        <table class="table-custom" id="tablePengeluaran">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($pengeluaran)): ?>
                                    <?php $no=1; foreach($pengeluaran as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= $p['kode_transaksi'] ?></strong></td>
                                        <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                                        <td><?= $p['nama_kategori'] ?? '-' ?></td>
                                        <td><?= $p['deskripsi'] ?></td>
                                        <td class="text-danger">Rp <?= number_format($p['jumlah'], 0, ',', '.') ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/pengeluaran/edit/'.$p['id']) ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
                                            <a href="<?= base_url('admin/pengeluaran/delete/'.$p['id']) ?>" class="btn-delete" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                            Belum ada data pengeluaran
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FOOTER -->
        <footer class="main-footer">
            <p>&copy; 2025 Kasir Bangunan • Sistem Kasir Tb Sari Uma Dukuh</p>
        </footer>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>