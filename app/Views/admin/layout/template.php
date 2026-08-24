<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard'; ?> | Kasir Bangunan</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 70px;
            --primary: #2c3e50;
            --secondary: #7f8c8d;
            --success: #27ae60;
            --info: #3498db;
            --warning: #f39c12;
            --danger: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            background-color: #ffffff;
        }
        
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--dark);
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: white;
            font-size: 20px;
        }
        
        .logo-text {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
        }
        
        .logo-subtext {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 2px;
        }
        
        /* Sidebar Menu */
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #5d6d7e;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            margin: 5px 0;
        }
        
        .menu-item:hover {
            background-color: #f8f9fa;
            color: #2c3e50;
            border-left-color: #2c3e50;
        }
        
        .menu-item.active {
            background-color: #f8f9fa;
            color: #2c3e50;
            border-left-color: #2c3e50;
            font-weight: 600;
        }
        
        .menu-item i {
            width: 24px;
            margin-right: 12px;
            font-size: 16px;
            text-align: center;
        }
        
        .menu-badge {
            background-color: #e74c3c;
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: auto;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        /* Top Header */
        .top-header {
            height: var(--header-height);
            background-color: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 0 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .sidebar-toggle {
            display: none;
            background: transparent;
            border: none;
            font-size: 20px;
            color: #2c3e50;
            margin-right: 15px;
            cursor: pointer;
        }
        
        .header-left {
            display: flex;
            align-items: center;
        }
        
        .header-left h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 0;
            color: #2c3e50;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0;
            font-size: 14px;
        }
        
        .breadcrumb-item a {
            color: #7f8c8d;
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: #2c3e50;
            font-weight: 500;
        }
        
        /* Header Right */
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .notification-bell {
            position: relative;
            color: #5d6d7e;
            font-size: 20px;
            cursor: pointer;
        }
        
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #e74c3c;
            color: white;
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .date-time {
            font-size: 14px;
            color: #7f8c8d;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ecf0f1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c3e50;
            font-size: 18px;
        }
        
        .user-name {
            font-weight: 500;
            color: #2c3e50;
        }
        
        .user-role {
            font-size: 12px;
            color: #7f8c8d;
        }
        
        /* Content Area */
        .content-area {
            padding: 25px;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            background-color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .card-title {
            margin-bottom: 0;
            font-weight: 600;
            color: #2c3e50;
            font-size: 18px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Stats Cards */
        .stat-card {
            border-left: 4px solid;
            border-left-color: var(--primary);
        }
        
        .stat-card.income {
            border-left-color: var(--success);
        }
        
        .stat-card.orders {
            border-left-color: var(--info);
        }
        
        .stat-card.pending {
            border-left-color: var(--warning);
        }
        
        .stat-card.success {
            border-left-color: var(--primary);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 15px;
        }
        
        .stat-icon.income {
            background-color: rgba(39, 174, 96, 0.1);
            color: var(--success);
        }
        
        .stat-icon.orders {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--info);
        }
        
        .stat-icon.pending {
            background-color: rgba(243, 156, 18, 0.1);
            color: var(--warning);
        }
        
        .stat-icon.success {
            background-color: rgba(44, 62, 80, 0.1);
            color: var(--primary);
        }
        
        .stat-info h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        
        .stat-info p {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 0;
        }
        
        /* Buttons */
        .btn {
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
        }
        
        .btn-primary:hover {
            background-color: #34495e;
            border-color: #34495e;
        }
        
        .btn-outline-primary {
            color: #2c3e50;
            border-color: #2c3e50;
        }
        
        .btn-outline-primary:hover {
            background-color: #2c3e50;
            border-color: #2c3e50;
        }
        
        /* Tables */
        .table {
            color: #5d6d7e;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #2c3e50;
            background-color: #f8f9fa;
            padding: 15px;
        }
        
        .table td {
            padding: 15px;
            vertical-align: middle;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-badge.success {
            background-color: rgba(39, 174, 96, 0.1);
            color: #27ae60;
        }
        
        .status-badge.pending {
            background-color: rgba(243, 156, 18, 0.1);
            color: #f39c12;
        }
        
        .status-badge.failed {
            background-color: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }
        
        /* Footer */
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #e0e0e0;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
        }
        
        /* Mobile Responsive */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .main-content.active {
                margin-left: var(--sidebar-width);
            }
            
            .sidebar-toggle {
                display: block !important;
            }

            .date-time {
                display: none;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Logo -->
        <div class="sidebar-header">
            <a href="<?= base_url('admin/dashboard'); ?>" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div>
                    <div class="logo-text">Kasir Bangunan</div>
                    <div class="logo-subtext">Administrator Panel</div>
                </div>
            </a>
        </div>
        
        <!-- Menu -->
        <nav class="sidebar-menu">
            <a href="<?= base_url('admin/dashboard'); ?>" class="menu-item <?= (service('uri')->getSegment(2) ?? '') == 'dashboard' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="<?= base_url('admin/produk'); ?>" class="menu-item <?= (service('uri')->getSegment(2) ?? '') == 'produk' ? 'active' : ''; ?>">
                <i class="fas fa-box"></i>
                <span>Produk</span>
            </a>
            
            <a href="<?= base_url('admin/kasir'); ?>" class="menu-item <?= (service('uri')->getSegment(2) ?? '') == 'kasir' ? 'active' : ''; ?>">
                <i class="fas fa-user-tie"></i>
                <span>Kasir</span>
            </a>
            
            <a href="<?= base_url('admin/jenis-produk'); ?>" class="menu-item <?= (service('uri')->getSegment(2) ?? '') == 'jenis-produk' ? 'active' : ''; ?>">
                <i class="fas fa-tags"></i>
                <span>Jenis Produk</span>
            </a>
            
            <div class="menu-section mt-4">
                <small class="px-3 d-block text-uppercase" style="color: #95a5a6; font-size: 11px; font-weight: 600;">Laporan</small>
            </div>
            
            <a href="<?= base_url('admin/laporan'); ?>" class="menu-item <?= (service('uri')->getSegment(2) ?? '') == 'laporan' ? 'active' : ''; ?>">
                <i class="fas fa-chart-bar"></i>
                <span>Laporan</span>
            </a>
            
            <a href="<?= base_url('admin/pengaturan'); ?>" class="menu-item <?= (service('uri')->getSegment(2) ?? '') == 'pengaturan' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
        </nav>
        
        <!-- User Profile Footer -->
        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div>
                    <div class="user-name"><?= session()->get('nama_user') ?? 'Administrator'; ?></div>
                    <div class="user-role"><?= session()->get('role') ?? 'Super Admin'; ?></div>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="mb-1"><?= $page_title ?? 'Dashboard'; ?></h1>
                    <?php if(isset($breadcrumbs)): ?>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <?php foreach($breadcrumbs as $breadcrumb): ?>
                                    <?php if(isset($breadcrumb['active']) && $breadcrumb['active']): ?>
                                        <li class="breadcrumb-item active"><?= $breadcrumb['title']; ?></li>
                                    <?php else: ?>
                                        <li class="breadcrumb-item">
                                            <a href="<?= $breadcrumb['url']; ?>"><?= $breadcrumb['title']; ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="header-right">
                <div class="date-time">
                    <i class="far fa-calendar-alt me-1"></i>
                    <span id="current-date"><?= date('d M Y'); ?></span>
                    <span id="current-time" class="ms-2"><?= date('H:i:s'); ?></span>
                </div>
                
                <!-- Notification Dropdown -->
                <div class="dropdown">
                    <div class="notification-bell" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="far fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end p-2 style-dropdown" style="width: 280px;">
                        <li class="dropdown-header font-weight-bold">Notifikasi</li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item small text-wrap" href="#">
                                <strong>Stok Menipis:</strong> Semen Gresik sisa 5 sak.
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item small text-wrap" href="#">
                                <strong>Kasir Baru:</strong> Ahmad berhasil ditambahkan.
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <div class="user-profile dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div class="user-name"><?= session()->get('nama_user') ?? 'Admin'; ?></div>
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="<?= base_url('admin/profil'); ?>">
                            <i class="fas fa-user me-2"></i>Profil
                        </a>
                        <a class="dropdown-item" href="<?= base_url('admin/pengaturan'); ?>">
                            <i class="fas fa-cog me-2"></i>Pengaturan
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?= base_url('auth/logout'); ?>">
                            <i class="fas fa-sign-out-alt me-2"></i>Keluar
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Content Area -->
        <div class="content-area">
            <!-- Flash Messages -->
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <!-- Main Content Section -->
            <?= $this->renderSection('content') ?>
        </div>
    </main>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Real-time Date and Time Update
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            const dateStr = now.toLocaleDateString('id-ID', options);
            const timeStr = now.toLocaleTimeString('id-ID', { hour12: false });
            
            $('#current-date').text(dateStr);
            $('#current-time').text(timeStr);
        }
        
        $(document).ready(function() {
            // Update clock
            updateDateTime();
            setInterval(updateDateTime, 1000);
            
            // Auto dismiss flash alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
            
            // Responsive Sidebar Toggle
            $('#sidebarToggle, .sidebar-toggle').on('click', function(e) {
                e.stopPropagation();
                $('.sidebar').toggleClass('active');
                $('.main-content').toggleClass('active');
            });
            
            // Add Fade In Animation to Cards
            $('.card').addClass('fade-in');
        });
        
        // Helper Formatting Functions
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        function formatCurrency(amount) {
            return 'Rp ' + formatNumber(amount);
        }
        
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
        }
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>