<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Kasir Bangunan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
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
        
        .card-custom {
            background: #fff; border-radius: 12px; border: 1px solid #ddd;
            padding: 20px; margin-bottom: 20px;
        }
        
        .stat-card {
            background: #fff; border-radius: 12px; border: 1px solid #ddd;
            padding: 20px; text-align: center;
        }
        .stat-number { font-size: 2rem; font-weight: 700; color: #000; }
        .stat-label { color: #666; font-size: 0.9rem; }
        
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <?= view('admin/partials/sidebar', ['menu' => 'produk', 'user' => $user ?? []]) ?>
    
    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title"><i class="fas fa-box me-2"></i> Data Produk</div>
            <div class="d-flex align-items-center gap-3">
                <div class="user-avatar"><?= strtoupper(substr($user['nama'] ?? 'A', 0, 1)) ?></div>
                <div><strong><?= $user['nama'] ?? 'Admin' ?></strong><br><small>Admin</small></div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </div>
        </nav>
        
        <div class="content-area">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Banner Alert Stok Menipis -->
            <?php if (!empty($stokMinimal) && $stokMinimal > 0) : ?>
                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle fs-4 me-3"></i>
                    <div>
                        <strong>Peringatan Stok!</strong> Terdapat <strong><?= $stokMinimal ?> produk</strong> yang stoknya sudah menipis/habis.
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-list me-2"></i> Daftar Produk 
                        <span class="badge bg-dark ms-2"><?= count($produk ?? []) ?> produk</span>
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('admin/jenis_produk') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-tags me-2"></i> Jenis Produk
                        </a>
                        <a href="<?= base_url('admin/produk/create') ?>" class="btn btn-dark">
                            <i class="fas fa-plus me-2"></i> Tambah Produk
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tableProduk" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Deskripsi</th>
                                <th>Jenis</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produk)): ?>
                                <?php $no = 1; foreach ($produk as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php if (!empty($p['foto'])): ?>
                                            <img src="<?= base_url('uploads/produk/' . $p['foto']) ?>" width="40" height="40" class="rounded object-fit-cover">
                                        <?php else: ?>
                                            <div class="bg-light text-center rounded d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?= $p['kode_produk'] ?></strong></td>
                                    <td><?= $p['nama_produk'] ?></td>
                                    <td><?= !empty($p['deskripsi']) ? mb_strimwidth($p['deskripsi'], 0, 25, '...') : '-' ?></td>
                                    <td><?= $p['nama_jenis'] ?? '-' ?></td>
                                    <td>Rp <?= number_format($p['harga_jual'], 0, ',', '.') ?></td>
                                    <td>
                                        <span class="badge <?= $p['stok'] <= ($p['stok_minimal'] ?? 5) ? 'bg-warning text-dark' : 'bg-light text-dark border' ?>">
                                            <?= $p['stok'] ?> <?= $p['satuan'] ?? 'pcs' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/produk/updateStatus/' . $p['id'] . '/' . ($p['status'] == 'aktif' ? 'nonaktif' : 'aktif')) ?>" 
                                           class="badge text-decoration-none <?= $p['status'] == 'aktif' ? 'bg-success' : 'bg-danger' ?>">
                                            <?= ucfirst($p['status']) ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <!-- Tombol Detail / Deskripsi (Modal Trigger) -->
                                        <button type="button" class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $p['id'] ?>" title="Detail & Deskripsi">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="<?= base_url('admin/produk/edit/' . $p['id']) ?>" class="btn btn-sm btn-outline-dark me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/produk/delete/' . $p['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin menghapus produk ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ringkasan Statistik -->
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-label">Total Produk</div>
                        <div class="stat-number"><?= $totalProduk ?? 0 ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-label">Produk Aktif</div>
                        <div class="stat-number"><?= $produkAktif ?? 0 ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-label">Stok Rendah</div>
                        <div class="stat-number text-warning"><?= $stokMinimal ?? 0 ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-label">Total Jenis</div>
                        <div class="stat-number"><?= $totalJenis ?? 0 ?></div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="text-center py-3 border-top bg-white mt-4">
            <p class="text-muted small mb-0">&copy; 2025 Kasir Bangunan</p>
        </footer>
    </div>

    <!-- MODAL DETAIL PRODUK (DILETAKKAN DI LUAR TABEL) -->
    <?php if (!empty($produk)): ?>
        <?php foreach ($produk as $p): ?>
        <div class="modal fade" id="modalDetail<?= $p['id'] ?>" tabindex="-1" aria-labelledby="modalDetailLabel<?= $p['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="modalDetailLabel<?= $p['id'] ?>">
                            <i class="fas fa-info-circle me-2"></i> Detail Produk - <?= $p['nama_produk'] ?>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Foto Produk -->
                            <div class="col-md-5 text-center border-end">
                                <?php if (!empty($p['foto'])): ?>
                                    <img src="<?= base_url('uploads/produk/' . $p['foto']) ?>" class="img-fluid rounded border shadow-sm mb-2" style="max-height: 250px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center border mb-2" style="height: 200px;">
                                        <div class="text-muted text-center">
                                            <i class="fas fa-image fa-3x mb-2"></i>
                                            <p class="mb-0 small">Tidak Ada Foto</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <span class="badge <?= $p['status'] == 'aktif' ? 'bg-success' : 'bg-danger' ?> fs-6">
                                        Status: <?= ucfirst($p['status']) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Informasi Rincian Produk -->
                            <div class="col-md-7">
                                <table class="table table-sm table-borderless align-middle mb-0">
                                    <tr>
                                        <th width="35%" class="text-muted">Kode Produk</th>
                                        <td width="5%">:</td>
                                        <td><span class="badge bg-dark fs-6"><?= $p['kode_produk'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Nama Produk</th>
                                        <td>:</td>
                                        <td class="fw-bold"><?= $p['nama_produk'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Jenis / Kategori</th>
                                        <td>:</td>
                                        <td><?= $p['nama_jenis'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Harga Beli</th>
                                        <td>:</td>
                                        <td>Rp <?= number_format($p['harga_beli'] ?? 0, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Harga Jual</th>
                                        <td>:</td>
                                        <td class="fw-bold text-success">Rp <?= number_format($p['harga_jual'], 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Stok Saat Ini</th>
                                        <td>:</td>
                                        <td>
                                            <span class="badge <?= $p['stok'] <= ($p['stok_minimal'] ?? 5) ? 'bg-warning text-dark' : 'bg-info text-dark' ?>">
                                                <?= $p['stok'] ?> <?= $p['satuan'] ?? 'pcs' ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Stok Minimal</th>
                                        <td>:</td>
                                        <td><?= $p['stok_minimal'] ?? 5 ?> <?= $p['satuan'] ?? 'pcs' ?></td>
                                    </tr>
                                </table>

                                <hr class="my-2">

                                <div>
                                    <strong class="text-muted d-block mb-1"><i class="fas fa-align-left me-1"></i> Deskripsi:</strong>
                                    <p class="bg-light p-2 rounded small text-secondary mb-2" style="white-space: pre-line;">
                                        <?= !empty($p['deskripsi']) ? $p['deskripsi'] : 'Tidak ada deskripsi.' ?>
                                    </p>
                                </div>

                                <?php if (!empty($p['keterangan'])) : ?>
                                <div>
                                    <strong class="text-muted d-block mb-1"><i class="fas fa-sticky-note me-1"></i> Keterangan Tambahan:</strong>
                                    <p class="bg-light p-2 rounded small text-secondary mb-0">
                                        <?= $p['keterangan'] ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'none';

            $('#tableProduk').DataTable({
                "language": {
                    "emptyTable": "Belum ada data produk",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ produk",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 produk",
                    "lengthMenu": "Tampilkan _MENU_ produk per halaman",
                    "search": "Cari produk:",
                    "zeroRecords": "Tidak ada produk yang cocok",
                    "paginate": {
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>
</body>
</html>