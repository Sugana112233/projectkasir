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
    <?= view('admin/partials/sidebar', ['menu' => 'produk', 'user' => $user ?? []]) ?>
    
    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title"><i class="fas fa-plus-circle me-2"></i> Tambah Produk</div>
            <div class="d-flex align-items-center gap-3">
                <div class="user-avatar"><?= strtoupper(substr($user['nama'] ?? 'A', 0, 1)) ?></div>
                <div><strong><?= $user['nama'] ?? 'Admin' ?></strong><br><small>Admin</small></div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </div>
        </nav>
        
        <div class="content-area">
            <div class="mb-3">
                <a href="<?= base_url('admin/produk') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
            
            <div class="form-card">
                <h4 class="fw-bold mb-4"><i class="fas fa-box me-2"></i> Form Tambah Produk</h4>
                
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/produk/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Produk</label>
                            <input type="text" class="form-control" 
                                   name="kode_produk" 
                                   value="<?= $kodeProduk ?? '' ?>" 
                                   placeholder="Kode produk" 
                                   required readonly>
                            <small class="text-muted">Kode produk otomatis digenerate</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Produk</label>
                            <select name="id_jenis" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                <?php foreach($jenis as $j): ?>
                                <option value="<?= $j['id'] ?>"><?= $j['kode_jenis'] ?> - <?= $j['nama_jenis'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="<?= old('nama_produk') ?>" placeholder="Nama produk" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Produk</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi produk (spesifikasi, ukuran, dll)"><?= old('deskripsi') ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga Beli</label>
                            <input type="text" name="harga_beli" id="harga_beli" class="form-control" 
                                   value="<?= old('harga_beli') ?>" placeholder="0" 
                                   onkeyup="formatRupiah(this)" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga Jual</label>
                            <input type="text" name="harga_jual" id="harga_jual" class="form-control" 
                                   value="<?= old('harga_jual') ?>" placeholder="0" 
                                   onkeyup="formatRupiah(this)" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?= old('stok') ?>" placeholder="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stok Minimal</label>
                            <input type="number" name="stok_minimal" class="form-control" value="<?= old('stok_minimal', 5) ?>" placeholder="5">
                        </div>
                       <div class="col-md-4 mb-3">
                                <label class="form-label">Satuan</label>
                                <select name="satuan" class="form-control" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    
                                    <!-- Kemasan / Hitungan Umum -->
                                    <option value="pcs" <?= old('satuan') == 'pcs' ? 'selected' : '' ?>>Pcs (Piece)</option>
                                    <option value="buah" <?= old('satuan') == 'buah' ? 'selected' : '' ?>>Buah</option>
                                    <option value="unit" <?= old('satuan') == 'unit' ? 'selected' : '' ?>>Unit</option>
                                    <option value="set" <?= old('satuan') == 'set' ? 'selected' : '' ?>>Set</option>
                                    <option value="dus" <?= old('satuan') == 'dus' ? 'selected' : '' ?>>Dus / Karton</option>
                                    <option value="box" <?= old('satuan') == 'box' ? 'selected' : '' ?>>Box</option>
                                    <option value="pack" <?= old('satuan') == 'pack' ? 'selected' : '' ?>>Pack</option>
                                    <option value="roll" <?= old('satuan') == 'roll' ? 'selected' : '' ?>>Roll / Gulung</option>
                                    <option value="ikat" <?= old('satuan') == 'ikat' ? 'selected' : '' ?>>Ikat</option>
                                    <option value="lembar" <?= old('satuan') == 'lembar' ? 'selected' : '' ?>>Lembar</option>
                                    <option value="batang" <?= old('satuan') == 'batang' ? 'selected' : '' ?>>Batang</option>
                                    <option value="kaleng" <?= old('satuan') == 'kaleng' ? 'selected' : '' ?>>Kaleng</option>
                                    <option value="galon" <?= old('satuan') == 'galon' ? 'selected' : '' ?>>Galon</option>
                                    <option value="pail" <?= old('satuan') == 'pail' ? 'selected' : '' ?>>Pail / Ember</option>
                                    <option value="sak" <?= old('satuan') == 'sak' ? 'selected' : '' ?>>Sak / Bag</option>
                                    <option value="ball" <?= old('satuan') == 'ball' ? 'selected' : '' ?>>Ball</option>

                                    <!-- Ukuran Panjang / Luas / Volume -->
                                    <option value="meter" <?= old('satuan') == 'meter' ? 'selected' : '' ?>>Meter (m)</option>
                                    <option value="cm" <?= old('satuan') == 'cm' ? 'selected' : '' ?>>Centimeter (cm)</option>
                                    <option value="m2" <?= old('satuan') == 'm2' ? 'selected' : '' ?>>Meter Persegi (m²)</option>
                                    <option value="m3" <?= old('satuan') == 'm3' ? 'selected' : '' ?>>Kubik / Meter Kubik (m³)</option>

                                    <!-- Berat & Volume Cair -->
                                    <option value="kg" <?= old('satuan') == 'kg' ? 'selected' : '' ?>>Kilogram (kg)</option>
                                    <option value="gram" <?= old('satuan') == 'gram' ? 'selected' : '' ?>>Gram (g)</option>
                                    <option value="ton" <?= old('satuan') == 'ton' ? 'selected' : '' ?>>Ton</option>
                                    <option value="liter" <?= old('satuan') == 'liter' ? 'selected' : '' ?>>Liter</option>

                                    <!-- Angkutan Bangunan -->
                                    <option value="rit" <?= old('satuan') == 'rit' ? 'selected' : '' ?>>Engkel /  Truk</option>
                                    <option value="colt" <?= old('satuan') == 'colt' ? 'selected' : '' ?>>Colt</option>
                        
                                </select>
                            </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan produk"><?= old('keterangan') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Foto Produk</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Upload foto produk (format: jpg, png, jpeg, webp | maks: 2MB)</small>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" value="1" checked>
                            <label class="form-check-label">Aktif</label>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn-dark"><i class="fas fa-save me-2"></i> Simpan</button>
                        <a href="<?= base_url('admin/produk') ?>" class="btn-outline-dark"><i class="fas fa-times me-2"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
        
        <script>
        function formatRupiah(input) {
            var value = input.value.replace(/[^\d]/g, '');
            if (value) {
                input.value = parseInt(value).toLocaleString('id-ID');
            }
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            var hargaJual = document.getElementById('harga_jual');
            var hargaBeli = document.getElementById('harga_beli');
            if (hargaJual) {
                hargaJual.value = hargaJual.value.replace(/\./g, '');
            }
            if (hargaBeli) {
                hargaBeli.value = hargaBeli.value.replace(/\./g, '');
            }
        });
        </script>
        
        <footer class="text-center py-3 border-top bg-white">
            <p class="text-muted small mb-0">&copy; 2025 Kasir Bangunan</p>
        </footer>
    </div>
</body>
</html>