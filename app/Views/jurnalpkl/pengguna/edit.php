
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Edit Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="card border-0 shadow-sm mb-4"
         style="border-radius:16px;background:linear-gradient(120deg,#155eef,#4388ff);color:white;">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-2">Edit Pengguna</h3>
            <p class="mb-0">Perbarui informasi akun pengguna Jurnal PKL.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('manajemen-pengguna/update/' . $pengguna['id']) ?>"
                  method="post">

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control"
                           value="<?= esc($pengguna['nama']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= esc($pengguna['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control"
                           value="<?= esc($pengguna['username']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Role Pengguna</label>
                    <select name="role" class="form-select" required>
                        <option value="anggota" <?= $pengguna['role'] === 'anggota' ? 'selected' : '' ?>>Anggota</option>
                        <option value="petugas" <?= $pengguna['role'] === 'petugas' ? 'selected' : '' ?>>Petugas</option>
                        <option value="pembimbing" <?= $pengguna['role'] === 'pembimbing' ? 'selected' : '' ?>>Pembimbing</option>
                        <option value="admin" <?= $pengguna['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>

                    <a href="<?= base_url('manajemen-pengguna') ?>"
                       class="btn btn-light border">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
