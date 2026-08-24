<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Data Jenis Produk' ?> - Kasir Bangunan</title>
    
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
            --gray-400: #BDBDBD;
            --gray-500: #9E9E9E;
            --gray-600: #757575;
            --gray-700: #616161;
            --gray-800: #424242;
            --gray-900: #212121;
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
        
        .card { border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: #fff; }
        .card-header { background: #fff; border-bottom: 1px solid #ddd; padding: 15px 20px; }
        .card-body { padding: 20px; }
        
        .btn-dark { background: #000; color: #fff; border: none; padding: 8px 20px; border-radius: 6px; text-decoration: none; }
        .btn-dark:hover { background: #333; color: #fff; }
        .btn-outline-dark { background: none; border: 1px solid #ddd; color: #666; padding: 8px 20px; border-radius: 6px; text-decoration: none; }
        .btn-outline-dark:hover { background: #f5f5f5; }
        
        .table-custom { width: 100%; border-collapse: collapse; }
        .table-custom th { background: #f8f9fa; padding: 12px 15px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd; }
        .table-custom td { padding: 12px 15px; border-bottom: 1px solid #ddd; vertical-align: middle; }
        .table-custom tr:hover { background: #f8f9fa; }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-aktif { background: #d4edda; color: #155724; }
        .status-nonaktif { background: #f8d7da; color: #721c24; }
        
        .btn-edit { background: #f0f0f0; color: #333; border: none; padding: 5px 10px; border-radius: 4px; display: inline-block; }
        .btn-edit:hover { background: #ddd; color: #000; }
        .btn-delete { background: #fee; color: #dc3545; border: none; padding: 5px 10px; border-radius: 4px; display: inline-block; }
        .btn-delete:hover { background: #fdd; color: #a71d2a; }
        
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <?= view('admin/partials/sidebar', ['menu' => 'jenis_produk', 'user' => $user ?? []]) ?>
    
    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title"><i class="fas fa-tags me-2"></i> Data Jenis Produk</div>
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
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i> Daftar Jenis Produk
                        <span class="badge bg-dark ms-2"><?= count($jenis ?? []) ?> jenis</span>
                    </h5>
                    <a href="<?= base_url('admin/jenis-produk/create') ?>" class="btn btn-dark">
                        <i class="fas fa-plus me-2"></i> Tambah Jenis
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-custom" id="tableJenis">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Kode</th>
                                    <th width="30%">Nama Jenis</th>
                                    <th width="20%">Tanggal Dibuat</th>
                                    <th width="15%">Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($jenis)): ?>
                                    <?php foreach($jenis as $row): ?>
                                    <?php 
                                        $j = (array) $row; 
                                        $valStatus = strtolower(trim((string)($j['status'] ?? '')));
                                        $isAktif = in_array($valStatus, ['aktif', '1', 1, 'true'], true);
                                    ?>
                                    <tr>
                                        <!-- Kolom No dikosongkan karena diisi otomatis oleh JavaScript DataTables -->
                                        <td></td>
                                        <td><strong><?= $j['kode_jenis'] ?? '-' ?></strong></td>
                                        <td><?= $j['nama_jenis'] ?? '-' ?></td>
                                        <td><?= date('d/m/Y', strtotime($j['created_at'] ?? date('Y-m-d'))) ?></td>
                                        <td>
                                            <?php if($isAktif): ?>
                                                <span class="status-badge status-aktif">
                                                    <i class="fas fa-check-circle me-1"></i> Aktif
                                                </span>
                                            <?php else: ?>
                                                <span class="status-badge status-nonaktif">
                                                    <i class="fas fa-times-circle me-1"></i> Nonaktif
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/jenis-produk/edit/'.($j['id'] ?? '')) ?>" class="btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <?php if($isAktif): ?>
                                                <a href="<?= base_url('admin/jenis-produk/updateStatus/'.($j['id'] ?? '').'/nonaktif') ?>" class="btn-edit text-success" title="Nonaktifkan" onclick="return confirm('Nonaktifkan jenis ini?')">
                                                    <i class="fas fa-toggle-on fa-lg"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= base_url('admin/jenis-produk/updateStatus/'.($j['id'] ?? '').'/aktif') ?>" class="btn-edit text-secondary" title="Aktifkan" onclick="return confirm('Aktifkan jenis ini?')">
                                                    <i class="fas fa-toggle-off fa-lg"></i>
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?= base_url('admin/jenis-produk/delete/'.($j['id'] ?? '')) ?>" class="btn-delete" title="Hapus" onclick="return confirm('Yakin hapus?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fas fa-tags fa-2x d-block mb-2"></i>
                                            Belum ada data jenis produk
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="text-muted small">Total Jenis</div>
                            <div class="h3 mb-0"><?= count($jenis ?? []) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="text-muted small">Jenis Aktif</div>
                            <div class="h3 mb-0">
                                <?php 
                                    $aktifCount = 0;
                                    if(!empty($jenis)){
                                        foreach($jenis as $row) {
                                            $item = (array) $row;
                                            $val = strtolower(trim((string)($item['status'] ?? '')));
                                            if(in_array($val, ['aktif', '1', 1, 'true'], true)) {
                                                $aktifCount++;
                                            }
                                        }
                                    }
                                    echo $aktifCount;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="text-muted small">Jenis Nonaktif</div>
                            <div class="h3 mb-0">
                                <?php 
                                    $nonaktifCount = 0;
                                    if(!empty($jenis)){
                                        foreach($jenis as $row) {
                                            $item = (array) $row;
                                            $val = strtolower(trim((string)($item['status'] ?? '')));
                                            if(!in_array($val, ['aktif', '1', 1, 'true'], true)) {
                                                $nonaktifCount++;
                                            }
                                        }
                                    }
                                    echo $nonaktifCount;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="text-center py-3 border-top bg-white">
            <p class="text-muted small mb-0">&copy; 2025 Kasir Bangunan</p>
        </footer>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var t = $('#tableJenis').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
                pageLength: 10,
                responsive: true,
                order: [], // Menghilangkan pengurutan bawaan agar urutan awal tetap runtut
                columnDefs: [
                    {
                        searchable: false,
                        orderable: false,
                        targets: 0 // Kolom No tidak bisa di-sort
                    }
                ]
            });

            // Menghasilkan nomor urut otomatis dari 1, 2, 3...
            t.on('order.dt search.dt', function () {
                let i = 1;
                t.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                    this.data(i++);
                });
            }).draw();
        });
    </script>
</body>
</html>