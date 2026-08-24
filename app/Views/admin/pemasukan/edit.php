<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemasukan - Kasir Bangunan</title>
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
        .logout-btn:hover { background: #f5f5f5; }
        
        .form-card {
            background: #fff; border-radius: 12px; border: 1px solid #ddd;
            padding: 30px; max-width: 700px; margin: 0 auto;
        }
        .form-label { font-weight: 600; color: #000; }
        .form-control { border: 2px solid #ddd; border-radius: 8px; padding: 10px 15px; }
        .form-control:focus { border-color: #000; outline: none; }
        .btn-dark { background: #000; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 600; width: 100%; }
        .btn-dark:hover { background: #333; }
        .btn-outline-dark { background: none; border: 1px solid #ddd; color: #666; padding: 12px; border-radius: 8px; font-weight: 600; width: 100%; }
        .btn-outline-dark:hover { background: #f5f5f5; }
        
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
    </style>
</head>
<body>
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
            <li><a href="<?= base_url('admin/laporan') ?>"><i class="fas fa-chart-line"></i> Laporan</a></li>
            <li><a href="<?= base_url('admin/pengeluaran') ?>"><i class="fas fa-money-bill-wave"></i> Pengeluaran</a></li>
            <li><a href="<?= base_url('admin/pemasukan') ?>" class="active"><i class="fas fa-arrow-trend-up"></i> Pemasukan</a></li>
        </ul>
        <div class="footer">
            <a href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title"><i class="fas fa-edit me-2"></i> Edit Pemasukan</div>
            <div class="d-flex align-items-center gap-3">
                <div class="user-avatar">A</div>
                <div><strong>Admin</strong><br><small>Admin</small></div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </div>
        </nav>
        
        <div class="content-area">
            <div class="mb-3">
                <a href="<?= base_url('admin/pemasukan') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
            
            <div class="form-card">
                <h4 class="fw-bold mb-4"><i class="fas fa-edit me-2"></i> Form Edit Pemasukan</h4>
                
                <form action="<?= base_url('admin/pemasukan/update/'.$pemasukan['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $pemasukan['tanggal'] ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= $pemasukan['id_kategori'] == $k['id'] ? 'selected' : '' ?>><?= $k['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Sumber</label>
                        <input type="text" name="sumber" class="form-control" value="<?= $pemasukan['sumber'] ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required><?= $pemasukan['deskripsi'] ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" value="<?= $pemasukan['jumlah'] ?>" required>
                    </div>
                    
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn-dark"><i class="fas fa-save me-2"></i> Update</button>
                        <a href="<?= base_url('admin/pemasukan') ?>" class="btn-outline-dark"><i class="fas fa-times me-2"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
        
        <footer class="text-center py-3 border-top bg-white">
            <p class="text-muted small mb-0">&copy; 2025 Kasir Bangunan</p>
        </footer>
    </div>
</body>
</html>