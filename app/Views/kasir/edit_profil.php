<?= $this->extend('kasir/layout') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 col-md-8 offset-md-2">

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card-custom">
            <div class="card-header"><i class="fas fa-user-edit me-2"></i> Edit Profil Saya</div>
            <div class="card-body p-4">
                <form action="<?= base_url('kasir/update_profil') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= esc($user['nama'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= esc($user['username'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diubah">
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-2">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>