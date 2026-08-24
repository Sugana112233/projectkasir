<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Kasir System' ?> - TB Sari Uma Dukuh</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --black-bg: #0d0e12;
            --black-card: #14161d;
            --gray-light: #f8f9fa;
            --border-color: #e9ecef;
            --sidebar-width: 260px;
        }

        body {
            background-color: var(--gray-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* SIDEBAR STYLE */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--black-bg);
            color: #fff;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .sidebar .brand {
    padding: 18px 22px;
    border-bottom: 1px solid #22252a;
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Mentok ke kiri sejajar menu */
    gap: 12px;
        }

        .sidebar .brand a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
        }

        .sidebar-logo {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #33363d;
            flex-shrink: 0;
        }

        .brand-text {
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .sidebar-logo:hover {
            transform: scale(1.05);
            border-color: #fff;
        }

        .sidebar .nav-menu {
            list-style: none;
            padding: 15px 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar .nav-item a {
            display: flex;
            align-items: center;
            padding: 12px 22px;
            color: #a0a5b1;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-item a i {
            width: 25px;
            font-size: 1rem;
        }

        .sidebar .nav-item a:hover {
            background-color: #1a1c23;
            color: #fff;
        }

        .sidebar .nav-item a.active {
            background-color: #1a1c23;
            color: #fff;
            border-left: 4px solid #0d6efd;
            font-weight: 600;
        }

        .sidebar .sidebar-footer {
            padding: 18px;
            border-top: 1px solid #22252a;
        }

        .sidebar .btn-logout {
            width: 100%;
            background: #ffffff;
            color: #000;
            font-weight: 600;
            border: none;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            display: block;
            text-align: center;
            font-size: 0.88rem;
            transition: all 0.2s;
        }

        .sidebar .btn-logout:hover {
            background: #e2e6ea;
        }

        /* MAIN CONTENT LAYOUT */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .top-navbar {
            height: 70px;
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .top-navbar .page-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            color: #000;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            background: #000;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .content-body {
            padding: 30px;
            flex: 1;
        }

        .card-custom {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .card-custom .card-header {
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            padding: 18px 24px;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
       <!-- Header Logo (Pojok Kiri Atas Mentok Kiri + Teks SUD) -->
<div class="brand">
    <a href="<?= base_url('kasir') ?>">
        <img src="<?= base_url('assets/img/Logosu.jpeg') ?>" alt="Logo SU" class="sidebar-logo">
        <span class="brand-text">Sari Uma Dukuh</span>
    </a>
</div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="<?= base_url('kasir') ?>" class="<?= (($menu ?? '') == 'kasir' || ($menu ?? '') == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('kasir/transaksi') ?>" class="<?= (($menu ?? '') == 'transaksi') ? 'active' : '' ?>">
                    <i class="fas fa-shopping-cart"></i> Transaksi Kasir
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('kasir/riwayat') ?>" class="<?= (($menu ?? '') == 'riwayat') ? 'active' : '' ?>">
                    <i class="fas fa-history"></i> Riwayat Transaksi
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('kasir/edit_profil') ?>" class="<?= (($menu ?? '') == 'profil') ? 'active' : '' ?>">
                    <i class="fas fa-user-cog"></i> Edit Profil
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <a href="<?= base_url('auth/logout') ?>" class="btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>

    <div class="main-wrapper">
        <nav class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title"><?= $title ?? 'Dashboard Kasir' ?></h1>
            </div>
            
            <div class="user-profile">
                <div class="avatar-circle">
                    <?= strtoupper(substr($user['nama'] ?? session()->get('nama') ?? 'K', 0, 1)) ?>
                </div>
                <div class="d-none d-sm-block">
                    <div class="fw-bold fs-6"><?= $user['nama'] ?? session()->get('nama') ?? 'Kasir' ?></div>
                    <small class="text-muted">Kasir Toko</small>
                </div>
            </div>
        </nav>

        <div class="content-body">
            <?= $this->renderSection('content') ?>
        </div>

        <footer class="bg-white p-3 text-center border-top text-muted small">
            &copy; 2026 Sistem Kasir UD Sari Uma Dukuh
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>