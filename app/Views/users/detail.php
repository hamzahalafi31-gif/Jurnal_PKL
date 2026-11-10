<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Detail User
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Akun</h6>
                <div>
                    <?php if (session()->get('role') == 'admin' || session()->get('id') == $user['id']): ?>
                        <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-warning me-2">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    <?php endif; ?>
                    <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama</th>
                            <td><?= esc($user['nama']) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= esc($user['email']) ?></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td><?= esc($user['username']) ?></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php elseif ($user['role'] === 'petugas'): ?>
                                    <span class="badge bg-warning text-dark">Petugas</span>
                                <?php else: ?>
                                    <span class="badge bg-info">Anggota</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php if ($user['status'] === 'aktif'): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Terdaftar</th>
                            <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 text-center">
                    <?php if ($user['foto']): ?>
                        <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" alt="Foto" class="img-thumbnail mb-3" style="max-width: 200px;">
                    <?php else: ?>
                        <div class="bg-light rounded p-5 mb-3">
                            <i class="bi bi-person-circle text-muted" style="font-size: 5rem;"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Anggota PKL -->
    <?php if (isset($anggota) && !empty($anggota)): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Data Anggota PKL
            </h6>
        </div>

        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="30%">ID Anggota</th>
                    <td><?= esc($anggota['id_anggota_kelompok']) ?></td>
                </tr>
                <tr>
                    <th>ID Kelompok</th>
                    <td><?= esc($anggota['id_kelompok']) ?></td>
                </tr>
                <tr>
                    <th>Tanggal Bergabung</th>
                    <td>
                        <?= !empty($anggota['tanggal_bergabung'])
                            ? date('d/m/Y', strtotime($anggota['tanggal_bergabung']))
                            : '-' ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php elseif (isset($anggota)): ?>
    <div class="card shadow mb-4">
        <div class="card-body text-center text-muted py-4">
            Data anggota PKL belum tersedia.
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($petugas)): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Petugas</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Jabatan</th>
                        <td><?= esc($petugas['jabatan']) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php endif; ?>



    <!-- Aksi Cepat -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
        </div>
        <div class="card-body">
            <div class="d-grid gap-2">
                <?php if (session()->get('role') == 'admin'): ?>
                    <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit Data
                    </a>
                    <a href="<?= base_url('users/wa/' . $user['id']) ?>" target="_blank" class="btn btn-outline-success">
                        <i class="bi bi-whatsapp"></i> Kirim WA
                    </a>
                    <a href="<?= base_url('users/delete/' . $user['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                        <i class="bi bi-trash"></i> Hapus
                    </a>
                <?php elseif (session()->get('id') == $user['id']): ?>
                    <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit Profil
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>