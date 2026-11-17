
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Jurnal Aktivitas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="font-weight-bold text-primary">Jurnal Aktivitas PKL</h4>
            <p class="text-muted">Kelola dan pantau kegiatan PKL harian.</p>
        </div>

        <?php if (session()->get('role') === 'anggota'): ?>
            <a href="<?= base_url('jurnal/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jurnal
            </a>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Jurnal Aktivitas
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <?php if (in_array(session()->get('role'), ['admin', 'petugas'])): ?>
                                <th>Nama Anggota</th>
                            <?php endif; ?>
                            <th>Tanggal</th>
                            <th>Judul Kegiatan</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($jurnal)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($jurnal as $item): ?>
                                <?php
                                $warna = [
                                    'menunggu' => 'secondary',
                                    'disetujui' => 'success',
                                    'ditolak' => 'danger'
                                ];
                                ?>

                                <tr>
                                    <td><?= $no++ ?></td>

                                    <?php if (in_array(session()->get('role'), ['admin', 'petugas'])): ?>
                                        <td><?= esc($item['nama_user'] ?? '-') ?></td>
                                    <?php endif; ?>

                                    <td><?= esc($item['tanggal']) ?></td>
                                    <td><?= esc($item['judul_kegiatan']) ?></td>
                                    <td>
                                        <?= esc($item['jam_mulai'] ?? '-') ?>
                                        -
                                        <?= esc($item['jam_selesai'] ?? '-') ?>
                                    </td>
                                    
<td>
    <?php if ($item['status'] === 'disetujui'): ?>

        <span style="background-color: #198754; color: #ffffff; padding: 6px 12px; border-radius: 5px; display: inline-block;">
            Disetujui
        </span>

    <?php elseif ($item['status'] === 'ditolak'): ?>

        <span style="background-color: #dc3545; color: #ffffff; padding: 6px 12px; border-radius: 5px; display: inline-block;">
            Ditolak
        </span>

    <?php elseif ($item['status'] === 'menunggu'): ?>

        <span style="background-color: #ffc107; color: #212529; padding: 6px 12px; border-radius: 5px; display: inline-block;">
            Menunggu
        </span>

    <?php else: ?>

        <span style="background-color: #6c757d; color: #ffffff; padding: 6px 12px; border-radius: 5px; display: inline-block;">
            <?= esc($item['status'] ?? 'Tidak diketahui') ?>
        </span>

    <?php endif; ?>
</td>

                                    <td>
                                        <a href="<?= base_url('jurnal/detail/' . $item['id_jurnal']) ?>"
                                           class="btn btn-sm btn-info">
                                            Detail
                                        </a>

                                        <?php if (
                                            session()->get('role') === 'anggota' &&
                                            in_array($item['status'], ['menunggu', 'ditolak'])
                                        ): ?>
                                            <a href="<?= base_url('jurnal/edit/' . $item['id_jurnal']) ?>"
                                               class="btn btn-sm btn-warning">
                                                Edit
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?= in_array(session()->get('role'), ['admin', 'petugas']) ? 7 : 6 ?>"
                                    class="text-center text-muted">
                                    Belum ada jurnal aktivitas.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
