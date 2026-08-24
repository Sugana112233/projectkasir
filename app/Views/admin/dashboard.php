<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Kasir Bangunan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f8f9fa; font-family: 'Segoe UI', Roboto, sans-serif; }
        
        /* Sidebar Styling */
        .sidebar {
            position: fixed; left: 0; top: 0; width: 260px; height: 100vh;
            background: #0d0e12; z-index: 1000; overflow-y: auto; display: flex; flex-direction: column;
        }
        .sidebar .logo { padding: 25px 20px; border-bottom: 1px solid #22252a; }
        .sidebar .logo h3 { color: #fff; font-size: 1.15rem; font-weight: 700; }
        .sidebar .logo p { color: #6c757d; font-size: 11px; margin-top: 3px; }
        .sidebar .menu { list-style: none; padding: 15px 0; margin-bottom: auto; }
        .sidebar .menu li a {
            display: flex; align-items: center; padding: 12px 22px; color: #a0a5b1;
            text-decoration: none; font-size: 0.9rem; transition: all 0.2s ease;
        }
        .sidebar .menu li a i { width: 25px; font-size: 1rem; }
        .sidebar .menu li a:hover { background: #1a1c23; color: #fff; }
        .sidebar .menu li a.active { background: #1a1c23; color: #fff; border-left: 4px solid #0d6efd; font-weight: 600; }
        .sidebar .footer { padding: 18px; border-top: 1px solid #22252a; background: #0d0e12; }
        .sidebar .footer .logout-link {
            display: flex; align-items: center; justify-content: center; padding: 10px;
            background: #ffffff; color: #000; text-decoration: none; border-radius: 8px;
            font-weight: 600; font-size: 0.88rem; transition: all 0.2s;
        }
        .sidebar .footer .logout-link:hover { background: #e2e6ea; }

        /* Main Content Layout */
        .main-content { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        .top-navbar {
            background: #fff; padding: 0 30px; height: 70px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid #e9ecef;
        }
        .page-title { font-size: 1.25rem; font-weight: 700; color: #212529; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-avatar {
            width: 42px; height: 42px; background: #212529; color: #fff;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-weight: 700; font-size: 1rem;
        }
        
        .content-area { padding: 30px; flex: 1; }

        /* Banner Welcome */
        .welcome-card {
            background: #ffffff; border-radius: 12px; padding: 25px 30px;
            border: 1px solid #e9ecef; margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        /* Stat Cards */
        .stat-card {
            background: #fff; border-radius: 12px; padding: 22px;
            border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; margin-bottom: 15px;
        }
        .icon-blue { background: #e7f1ff; color: #0d6efd; }
        .icon-green { background: #e6f4ea; color: #198754; }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: #212529; line-height: 1; }
        .stat-label { font-size: 0.85rem; color: #6c757d; margin-top: 5px; }

        /* Section Cards */
        .card-custom {
            background: #fff; border-radius: 12px; border: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02); height: 100%;
        }
        .card-custom-header {
            padding: 18px 22px; border-bottom: 1px solid #e9ecef;
            font-weight: 700; color: #212529; display: flex; align-items: center; gap: 10px;
        }

        /* Quick Action Buttons */
        .quick-btn {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 18px 10px; background: #f8f9fa; border: 1px solid #e9ecef;
            border-radius: 10px; text-decoration: none; color: #333;
            transition: all 0.2s; text-align: center; height: 100%;
        }
        .quick-btn:hover { background: #212529; color: #fff; border-color: #212529; }
        .quick-btn i { font-size: 1.4rem; margin-bottom: 8px; }
        .quick-btn span { font-size: 0.82rem; font-weight: 600; }

        /* Activity Items */
        .activity-item { display: flex; gap: 15px; padding: 14px 0; border-bottom: 1px solid #f1f3f5; }
        .activity-item:last-child { border-bottom: none; }
        .activity-icon {
            width: 36px; height: 36px; border-radius: 50%; background: #f1f3f5;
            display: flex; align-items: center; justify-content: center; font-size: 0.9rem; flex-shrink: 0;
        }

        footer { background: #fff; padding: 15px; border-top: 1px solid #e9ecef; text-align: center; color: #6c757d; font-size: 0.85rem; }
    </style>
</head>
<body>

    <!-- PEMANGGILAN SIDEBAR LENGKAP VIA PARTIAL -->
    <?= view('admin/partials/sidebar', ['menu' => 'dashboard']) ?>

    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="page-title"><i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin</div>
            <div class="user-profile">
                <div class="user-avatar"><?= strtoupper(substr($user['nama'] ?? 'S', 0, 1)) ?></div>
                <div class="d-none d-sm-block">
                    <div class="fw-bold fs-6"><?= esc($user['nama'] ?? 'Sugana') ?></div>
                    <small class="text-muted"><?= esc(strtoupper($user['level'] ?? 'ADMIN')) ?> • <?= esc($user['nik'] ?? '24153') ?></small>
                </div>
                <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-secondary btn-sm ms-3">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </nav>

        <!-- Main Content Area -->
        <div class="content-area">
            
            <!-- Banner Selamat Datang -->
            <div class="welcome-card">
                <h4 class="fw-bold mb-1">Selamat Datang, <?= esc($user['nama'] ?? 'Sugana') ?>!</h4>
                <p class="text-muted mb-0">Anda login sebagai <strong>Administrator</strong>. Silakan kelola operasional toko bangunan Anda melalui menu ringkasan di bawah ini.</p>
            </div>

            <!-- Ringkasan Statistik -->
            <div class="row g-3 mb-4">
                <div class="col-md-6 col-lg-6">
                    <div class="stat-card">
                        <div class="stat-icon icon-blue">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="stat-value"><?= $total_produk ?? 2 ?></div>
                        <div class="stat-label">Total Produk Tersedia</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="stat-card">
                        <div class="stat-icon icon-green">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-value"><?= $total_kasir ?? 1 ?></div>
                        <div class="stat-label">Total Kasir Aktif</div>
                    </div>
                </div>
            </div>

            <!-- Panel Aktivitas & Aksi Cepat -->
            <div class="row g-4">
                <!-- Aktivitas Terbaru -->
                <div class="col-lg-7">
                    <div class="card-custom">
                        <div class="card-custom-header">
                            <i class="fas fa-history text-primary"></i> Aktivitas Terbaru
                        </div>
                        <div class="p-3">
                            <div class="activity-item">
                                <div class="activity-icon text-primary"><i class="fas fa-user-check"></i></div>
                                <div>
                                    <div class="fw-bold fs-6">Sistem Berhasil Dijalankan</div>
                                    <div class="text-muted small">Login Administrator berhasil dicatat.</div>
                                    <div class="text-muted mt-1" style="font-size: 0.75rem;">Baru saja</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon text-success"><i class="fas fa-check-circle"></i></div>
                                <div>
                                    <div class="fw-bold fs-6">Sistem Kasir Ready</div>
                                    <div class="text-muted small">Semua modul pendaftaran & data barang siap digunakan.</div>
                                    <div class="text-muted mt-1" style="font-size: 0.75rem;">Hari ini</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat (Grid Simetris) -->
                <div class="col-lg-5">
                    <div class="card-custom">
                        <div class="card-custom-header">
                            <i class="fas fa-bolt text-warning"></i> Navigasi & Aksi Cepat
                        </div>
                        <div class="p-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="<?= base_url('admin/kasir') ?>" class="quick-btn">
                                        <i class="fas fa-user-plus"></i>
                                        <span>Data Kasir</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="<?= base_url('admin/produk') ?>" class="quick-btn">
                                        <i class="fas fa-box-open"></i>
                                        <span>Data Produk</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="<?= base_url('admin/jenis-produk') ?>" class="quick-btn">
                                        <i class="fas fa-tags"></i>
                                        <span>Jenis Produk</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="<?= base_url('admin/laporan') ?>" class="quick-btn">
                                        <i class="fas fa-chart-pie"></i>
                                        <span>Lihat Laporan</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <footer>
            &copy; 2026 Kasir Bangunan • Sistem Kasir Tb Sari Uma Dukuh
        </footer>
    </div>

</body>
</html>