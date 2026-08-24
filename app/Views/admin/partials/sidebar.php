<!-- STYLE KHUSUS SIDEBAR (Agar tidak pecah di halaman manapun) -->
<style>
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 260px;
        height: 100vh;
        background: #0d0e12;
        z-index: 1000;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        color: #ffffff;
    }
    .sidebar .logo {
        padding: 25px 20px;
        border-bottom: 1px solid #22252a;
    }
    .sidebar .logo h3 {
        color: #ffffff;
        font-size: 1.15rem;
        font-weight: 700;
        margin: 0;
    }
    .sidebar .logo p {
        color: #6c757d;
        font-size: 11px;
        margin: 3px 0 0 0;
    }
    .sidebar .menu {
        list-style: none;
        padding: 15px 0;
        margin: 0 0 auto 0;
    }
    .sidebar .menu li {
        margin: 0;
        padding: 0;
    }
    .sidebar .menu li a {
        display: flex;
        align-items: center;
        padding: 12px 22px;
        color: #a0a5b1;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .sidebar .menu li a i {
        width: 25px;
        font-size: 1rem;
    }
    .sidebar .menu li a:hover {
        background: #1a1c23;
        color: #ffffff;
    }
    .sidebar .menu li a.active {
        background: #1a1c23;
        color: #ffffff;
        border-left: 4px solid #0d6efd;
        font-weight: 600;
    }
    .sidebar .footer {
        padding: 18px;
        border-top: 1px solid #22252a;
        background: #0d0e12;
    }
    .sidebar .footer .logout-link {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        background: #ffffff;
        color: #000000;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.2s;
    }
    .sidebar .footer .logout-link:hover {
        background: #e2e6ea;
    }
</style>

<div class="sidebar">
    <div class="logo">
        <h3><i class="fas fa-store me-2"></i>Kasir Bangunan</h3>
        <p>Toko Material Bangunan</p>
    </div>
    
    <ul class="menu">
        <li>
            <a href="<?= base_url('admin/dashboard') ?>" class="<?= (isset($menu) && $menu == 'dashboard') ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/kasir') ?>" class="<?= (isset($menu) && $menu == 'kasir') ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Data Kasir
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/produk') ?>" class="<?= (isset($menu) && $menu == 'produk') ? 'active' : '' ?>">
                <i class="fas fa-boxes"></i> Produk
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/jenis-produk') ?>" class="<?= (isset($menu) && $menu == 'jenis_produk') ? 'active' : '' ?>">
                <i class="fas fa-tags"></i> Jenis Produk
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/laporan') ?>" class="<?= (isset($menu) && $menu == 'laporan') ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/pengeluaran') ?>" class="<?= (isset($menu) && $menu == 'pengeluaran') ? 'active' : '' ?>">
                <i class="fas fa-file-invoice-dollar"></i> Pengeluaran
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/pemasukan') ?>" class="<?= (isset($menu) && $menu == 'pemasukan') ? 'active' : '' ?>">
                <i class="fas fa-wallet"></i> Pemasukan
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/pengaturan') ?>" class="<?= (isset($menu) && $menu == 'pengaturan') ? 'active' : '' ?>">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
        </li>
    </ul>

    <div class="footer">
        <a href="<?= base_url('auth/logout') ?>" class="logout-link">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>