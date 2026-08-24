<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Laporan'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; background: #f8f9fa; }
        .card { margin-bottom: 20px; }
        .navbar { margin-bottom: 30px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('admin/dashboard'); ?>">Kasir System</a>
            <div class="navbar-nav">
                <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
                <a class="nav-link" href="<?= base_url('admin/laporan'); ?>">Laporan</a>
                <a class="nav-link" href="<?= base_url('admin/produk'); ?>">Produk</a>
                <a class="nav-link" href="<?= base_url('admin/kasir'); ?>">Kasir</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="mb-4"><?= $page_title ?? 'Laporan'; ?></h1>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>
        
        <?= $this->renderSection('content') ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>