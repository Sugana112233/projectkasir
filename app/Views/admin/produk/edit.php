<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Kasir Bangunan</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
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
        
        body {
            background-color: var(--white);
            color: var(--gray-900);
            min-height: 100vh;
        }
        
        .main-content {
            margin-left: 260px;
            padding: 0;
            min-height: 100vh;
            background: var(--gray-50);
        }
        
        .top-navbar {
            background: var(--white);
            padding: 0 30px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .page-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--black);
            margin: 0;
        }
        
        .content-area {
            padding: 30px;
        }
        
        .form-card {
            background: var(--white);
            border-radius: 12px;
            padding: 30px;
            border: 1px solid var(--gray-200);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--black);
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border: 2px solid var(--gray-300);
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 16px;
            height: 48px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--black);
            box-shadow: 0 0 0 3px rgba(0,0,0,0.1);
        }
        
        .input-group-text {
            background: var(--gray-100);
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
        }
        
        .btn-submit {
            background: var(--black);
            color: var(--white);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
        }
        
        .btn-submit:hover {
            background: var(--gray-900);
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--black);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--gray-200);
        }
        
        .currency-input {
            text-align: right;
            font-weight: 500;
        }
        
        .preview-box {
            background: var(--gray-50);
            border: 2px dashed var(--gray-300);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .preview-box i {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Include Sidebar -->
    <?= view('admin/partials/sidebar', ['menu' => $menu, 'user' => $user]) ?>
    
    <!-- MAIN CONTENT -->
    <div class="main-content d-flex flex-column">
        <!-- TOP NAVBAR -->
        <nav class="top-navbar">
            <div class="page-title">
                <i class="fas fa-edit me-2"></i> Edit Produk
            </div>
            
            <div class="user-info">
                <div class="user-avatar" style="width: 40px; height: 40px; background: var(--black); color: var(--white); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.1rem;">
                    <?= strtoupper(substr($user['nama'], 0, 1)) ?>
                </div>
                <div class="user-details">
                    <h6 style="margin: 0; font-weight: 600; color: var(--black);"><?= $user['nama'] ?></h6>
                    <small style="color: var(--gray-600); font-size: 0.85rem;"><?= strtoupper($user['level']) ?> • <?= $user['nik'] ?></small>
                </div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn" style="background: none; border: 1px solid var(--gray-300); color: var(--gray-700); padding: 8px 15px; border-radius: 6px; font-weight: 500; transition: all 0.3s; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </nav>
        
        <!-- CONTENT AREA -->
        <div class="content-area fade-in">
            <!-- Flash Message -->
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
            
            <!-- Form Card -->
            <div class="form-card">
                <form action="<?= base_url('admin/produk/update/'.$produk['id']) ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <!-- Basic Information -->
                    <div class="mb-4">
                        <div class="section-title">
                            <i class="fas fa-info-circle me-2"></i> Informasi Dasar
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Produk</label>
                                <input type="text" 
                                       class="form-control <?= (session('validation') && session('validation')->hasError('kode_produk')) ? 'is-invalid' : '' ?>" 
                                       name="kode_produk" 
                                       value="<?= old('kode_produk', $produk['kode_produk']) ?>" 
                                       placeholder="Kode produk"
                                       required>
                                <?php if(session('validation') && session('validation')->hasError('kode_produk')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('kode_produk') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Produk</label>
                                <select class="form-select <?= (session('validation') && session('validation')->hasError('id_jenis')) ? 'is-invalid' : '' ?>" 
                                        name="id_jenis" required>
                                    <option value="">-- Pilih Jenis Produk --</option>
                                    <?php foreach($jenis as $j): ?>
                                    <option value="<?= $j['id'] ?>" <?= (old('id_jenis', $produk['id_jenis']) == $j['id']) ? 'selected' : '' ?>>
                                        <?= $j['kode_jenis'] ?> - <?= $j['nama_jenis'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(session('validation') && session('validation')->hasError('id_jenis')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('id_jenis') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" 
                                   class="form-control <?= (session('validation') && session('validation')->hasError('nama_produk')) ? 'is-invalid' : '' ?>" 
                                   name="nama_produk" 
                                   value="<?= old('nama_produk', $produk['nama_produk']) ?>" 
                                   placeholder="Masukkan nama produk lengkap"
                                   required
                                   autofocus>
                            <?php if(session('validation') && session('validation')->hasError('nama_produk')): ?>
                                <div class="invalid-feedback">
                                    <?= session('validation')->getError('nama_produk') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Keterangan (Opsional)</label>
                            <textarea class="form-control" 
                                      name="keterangan" 
                                      rows="3" 
                                      placeholder="Deskripsi produk, spesifikasi, atau informasi tambahan"><?= old('keterangan', $produk['keterangan'] ?? '') ?></textarea>
                        </div>
                    </div>
                    
                    <!-- Pricing & Stock -->
                    <div class="mb-4">
                        <div class="section-title">
                            <i class="fas fa-money-bill-wave me-2"></i> Harga & Stok
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Beli</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" 
                                           class="form-control currency-input <?= (session('validation') && session('validation')->hasError('harga_beli')) ? 'is-invalid' : '' ?>" 
                                           name="harga_beli" 
                                           value="<?= old('harga_beli', number_format($produk['harga_beli'], 0, ',', '.')) ?>" 
                                           placeholder="0"
                                           onkeyup="formatCurrency(this)"
                                           required>
                                </div>
                                <?php if(session('validation') && session('validation')->hasError('harga_beli')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('harga_beli') ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted">Harga beli dari supplier</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" 
                                           class="form-control currency-input <?= (session('validation') && session('validation')->hasError('harga_jual')) ? 'is-invalid' : '' ?>" 
                                           name="harga_jual" 
                                           value="<?= old('harga_jual', number_format($produk['harga_jual'], 0, ',', '.')) ?>" 
                                           placeholder="0"
                                           onkeyup="formatCurrency(this)"
                                           required>
                                </div>
                                <?php if(session('validation') && session('validation')->hasError('harga_jual')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('harga_jual') ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted">Harga jual ke customer</small>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stok Awal</label>
                                <input type="number" 
                                       class="form-control <?= (session('validation') && session('validation')->hasError('stok')) ? 'is-invalid' : '' ?>" 
                                       name="stok" 
                                       value="<?= old('stok', $produk['stok']) ?>" 
                                       placeholder="0"
                                       min="0"
                                       required>
                                <?php if(session('validation') && session('validation')->hasError('stok')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('stok') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stok Minimal</label>
                                <input type="number" 
                                       class="form-control <?= (session('validation') && session('validation')->hasError('stok_minimal')) ? 'is-invalid' : '' ?>" 
                                       name="stok_minimal" 
                                       value="<?= old('stok_minimal', $produk['stok_minimal']) ?>" 
                                       placeholder="5"
                                       min="1"
                                       required>
                                <?php if(session('validation') && session('validation')->hasError('stok_minimal')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('stok_minimal') ?>
                                    </div>
                                <?php endif; ?>
                                <small class="text-muted">Akan muncul peringatan jika stok ≤ ini</small>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Satuan</label>
                                <select class="form-select <?= (session('validation') && session('validation')->hasError('satuan')) ? 'is-invalid' : '' ?>" 
                                        name="satuan" required>
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
                                <?php if(session('validation') && session('validation')->hasError('satuan')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('satuan') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div class="mb-4">
                        <div class="section-title">
                            <i class="fas fa-toggle-on me-2"></i> Status Produk
                        </div>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch" name="status" <?= (old('status', $produk['status']) == 'aktif') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="statusSwitch">
                                Aktifkan produk untuk dijual
                            </label>
                        </div>
                        <small class="text-muted">Jika dinonaktifkan, produk tidak akan muncul di transaksi kasir</small>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save me-2"></i> Update Produk
                        </button>
                        <a href="<?= base_url('admin/produk') ?>" class="btn btn-outline-secondary" style="padding: 12px 30px; border-radius: 8px;">
                            <i class="fas fa-times me-2"></i> Batal
                        </a>
                        <a href="<?= base_url('admin/produk/delete/' . $produk['id']) ?>" class="btn btn-outline-danger" style="padding: 12px 30px; border-radius: 8px;" onclick="return confirm('Yakin hapus produk ini?')">
                            <i class="fas fa-trash me-2"></i> Hapus
                        </a>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Produk</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi produk"><?= $produk['deskripsi'] ?? '' ?></textarea>
                    </div>

                    <!-- Foto Produk -->
                    <div class="mb-3">
                        <label class="form-label">Foto Produk</label>
                        <?php if(!empty($produk['foto']) && file_exists('uploads/produk/' . $produk['foto'])): ?>
                            <div class="mb-2">
                                <img src="<?= base_url('uploads/produk/' . $produk['foto']) ?>" 
                                    alt="<?= $produk['nama_produk'] ?>" 
                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                <br>
                                <small class="text-muted">Foto saat ini</small>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Upload foto produk baru (format: jpg, png, jpeg, webp | maks: 2MB)</small>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- FOOTER -->
        <footer class="main-footer" style="padding: 20px 30px; border-top: 1px solid var(--gray-200); background: var(--white); margin-top: auto;">
            <p class="footer-text" style="color: var(--gray-600); font-size: 0.9rem; text-align: center; margin: 0;">
                &copy; 2024 Kasir Bangunan • Sistem Kasir Toko Material Bangunan
            </p>
        </footer>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Format currency input
        function formatCurrency(input) {
            let value = input.value.replace(/[^\d]/g, '');
            if (value) {
                value = parseInt(value);
                input.value = value.toLocaleString('id-ID');
            } else {
                input.value = '';
            }
        }
        
        // Form validation
        document.getElementById('formProduk').addEventListener('submit', function(e) {
            const hargaBeli = document.querySelector('input[name="harga_beli"]').value;
            const hargaJual = document.querySelector('input[name="harga_jual"]').value;
            const stok = document.querySelector('input[name="stok"]').value;
            
            // Convert currency back to number
            const hargaBeliNum = parseInt(hargaBeli.replace(/[^\d]/g, '')) || 0;
            const hargaJualNum = parseInt(hargaJual.replace(/[^\d]/g, '')) || 0;
            
            if (hargaJualNum < hargaBeliNum) {
                e.preventDefault();
                alert('Harga jual tidak boleh lebih rendah dari harga beli!');
                return false;
            }
            
            if (parseInt(stok) < 0) {
                e.preventDefault();
                alert('Stok tidak boleh negatif!');
                return false;
            }
        });
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Auto focus on product name field
            document.querySelector('input[name="nama_produk"]').focus();
        });
    </script>
</body>
</html>