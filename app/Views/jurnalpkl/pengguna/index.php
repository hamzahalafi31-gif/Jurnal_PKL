
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Manajemen Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="card border-0 shadow-sm mb-4"
         style="border-radius:16px;background:linear-gradient(120deg,#155eef,#4388ff);color:white;">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-2">Manajemen Pengguna</h3>
            <p class="mb-0">
                Kelola akun admin, petugas, pembimbing, dan anggota PKL.
            </p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
    <h5 class="fw-bold mb-0">Daftar Pengguna</h5>

    <a href="<?= base_url('manajemen-pengguna/tambah') ?>"
       class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i>
        Tambah Pengguna
    </a>
</div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (!empty($pengguna)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($pengguna as $user): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($user['nama']) ?></td>
                                <td><?= esc($user['username']) ?></td>
                                <td><?= esc($user['email']) ?></td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?= esc(ucfirst($user['role'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['status'] === 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('manajemen-pengguna/edit/' . $user['id']) ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-muted small">
                Total pengguna: <?= count($pengguna ?? []) ?>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
