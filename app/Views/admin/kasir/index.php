<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Data Kasir' ?> - Kasir Bangunan</title>
    
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
        
        body {
            background: var(--gray-50);
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            z-index: 99;
        }
        
        .page-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--black);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--black);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .content-area {
            padding: 30px;
            flex: 1;
        }
        
        .card-custom {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            overflow: hidden;
        }
        
        .card-custom-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--gray-200);
            background: var(--white);
        }
        
        .btn-primary {
            background: var(--black);
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            background: #333333;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.85rem;
            margin: 0 2px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-edit {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-edit:hover {
            background: #bfdbfe;
            color: #1e40af;
        }
        
        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background: #fca5a5;
            color: #dc2626;
        }
        
        .logout-btn {
            background: none;
            border: 1px solid var(--gray-300);
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            color: var(--gray-600);
        }
        
        .logout-btn:hover {
            background: var(--gray-100);
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- PEMANGGILAN SIDEBAR PARTIAL -->
    <?= view('admin/partials/sidebar', ['menu' => $menu ?? 'kasir', 'user' => $user ?? []]) ?>
    
    <div class="main-content">
        <nav class="top-navbar">
            <div class="page-title">
                <i class="fas fa-users me-2"></i> Data Kasir
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <?= strtoupper(substr($user['nama'] ?? 'S', 0, 1)) ?>
                </div>
                <div>
                    <strong><?= $user['nama'] ?? 'Sugana' ?></strong><br>
                    <small class="text-muted"><?= strtoupper($user['level'] ?? 'ADMIN') ?></small>
                </div>
                <a href="<?= base_url('auth/logout') ?>" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </div>
        </nav>
        
        <div class="content-area">
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <div class="card-custom">
                <div class="card-custom-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i> Daftar Kasir
                    </h5>
                    <a href="<?= base_url('admin/kasir/create') ?>" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i> Tambah Kasir
                    </a>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tableKasir">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">NIK</th>
                                    <th width="25%">Nama</th>
                                    <th width="15%">Status</th>
                                    <th width="20%">Tanggal Daftar</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($kasir)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach($kasir as $k): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= esc($k['nik']) ?></strong></td>
                                        <td><?= esc($k['nama']) ?></td>
                                        <td>
                                            <?php if($k['status'] == 'aktif'): ?>
                                                <span class="status-badge status-active">
                                                    <i class="fas fa-check-circle me-1"></i> Aktif
                                                </span>
                                            <?php else: ?>
                                                <span class="status-badge status-inactive">
                                                    <i class="fas fa-times-circle me-1"></i> Nonaktif
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($k['created_at'])) ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="<?= base_url('admin/kasir/edit/'.$k['id']) ?>" class="action-btn btn-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <?php if($k['status'] == 'aktif'): ?>
                                                    <a href="<?= base_url('admin/kasir/status/'.$k['id'].'/nonaktif') ?>" class="action-btn btn-edit" title="Nonaktifkan" onclick="return confirm('Nonaktifkan kasir ini?')">
                                                        <i class="fas fa-toggle-on"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= base_url('admin/kasir/status/'.$k['id'].'/aktif') ?>" class="action-btn btn-edit" title="Aktifkan" onclick="return confirm('Aktifkan kasir ini?')">
                                                        <i class="fas fa-toggle-off"></i>
                                                    </a>
                                                <?php endif; ?>
                                                
                                                <a href="<?= base_url('admin/kasir/delete/'.$k['id']) ?>" class="action-btn btn-delete" title="Hapus" onclick="return confirm('Yakin hapus kasir <?= esc($k['nama']) ?>?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="p-3 text-center border-top bg-white">
            <p class="text-muted mb-0">&copy; 2026 Kasir Bangunan • Sistem Kasir Tb Sari Uma Dukuh</p>
        </footer>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#tableKasir').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                pageLength: 10,
                responsive: true
            });
        });
    </script>
</body>
</html>