<?= $this->extend('kasir/layout') ?>

<?= $this->section('content') ?>

<style>
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 100%;
    }
    .stat-card .label { font-size: 0.85rem; color: #6c757d; }
    .stat-card .value { font-size: 1.35rem; font-weight: 700; color: #000; margin-top: 4px; }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 10px; background: #f8f9fa;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #000;
    }
    .btn-quick {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        padding: 16px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: 0.2s;
    }
    .btn-quick-primary { background: #0d0e12; color: #fff; }
    .btn-quick-primary:hover { background: #22252a; color: #fff; }
    .btn-quick-outline { border: 1px solid #e9ecef; color: #000; background: #fff; }
    .btn-quick-outline:hover { background: #f8f9fa; color: #000; }
</style>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="label">Transaksi Hari Ini</div>
                <div class="value"><?= $transaksi_hari_ini ?? 0 ?></div>
            </div>
            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="label">Pendapatan Hari Ini</div>
                <div class="value">Rp <?= number_format($pendapatan_hari_ini ?? 0, 0, ',', '.') ?></div>
            </div>
            <div class="stat-icon"><i class="fas fa-wallet"></i></div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="label">Total Transaksi</div>
                <div class="value"><?= $total_transaksi ?? 0 ?></div>
            </div>
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.') ?></div>
            </div>
            <div class="stat-icon"><i class="fas fa-coins"></i></div>
        </div>
    </div>
</div>

<div class="card-custom">
    <div class="card-header"><i class="fas fa-bolt me-2"></i> Aksi Cepat</div>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <a href="<?= base_url('kasir/transaksi') ?>" class="btn-quick btn-quick-primary">
                    <i class="fas fa-cart-plus me-2"></i> Transaksi Kasir Baru
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="<?= base_url('kasir/edit_profil') ?>" class="btn-quick btn-quick-outline">
                    <i class="fas fa-user-cog me-2"></i> Pengaturan Profil Saya
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>