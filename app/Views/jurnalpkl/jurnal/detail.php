
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Detail Jurnal Aktivitas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Detail Jurnal Aktivitas
            </h6>

            <a href="<?= base_url('jurnal') ?>" class="btn btn-secondary btn-sm">
                Kembali
            </a>
        </div>

        <div class="card-body">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <table class="table table-bordered">
                <tr>
                    <th width="25%">Tanggal</th>
                    <td><?= esc($jurnal['tanggal']) ?></td>
                </tr>
                <tr>
                    <th>Judul Kegiatan</th>
                    <td><?= esc($jurnal['judul_kegiatan']) ?></td>
                </tr>
                <tr>
                    <th>Deskripsi Kegiatan</th>
                    <td><?= nl2br(esc($jurnal['deskripsi_kegiatan'])) ?></td>
                </tr>
                <tr>
                    <th>Jam Mulai</th>
                    <td><?= esc($jurnal['jam_mulai'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Jam Selesai</th>
                    <td><?= esc($jurnal['jam_selesai'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if ($jurnal['status'] === 'disetujui'): ?>
                            <span class="badge badge-success">Disetujui</span>
                        <?php elseif ($jurnal['status'] === 'ditolak'): ?>
                            <span class="badge badge-danger">Ditolak</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Menunggu</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Catatan Pembimbing</th>
                    <td>
                        <?= !empty($jurnal['catatan_pembimbing'])
                            ? nl2br(esc($jurnal['catatan_pembimbing']))
                            : 'Belum ada catatan.' ?>
                    </td>
                </tr>
            </table>

            <?php if (
                in_array(session()->get('role'), ['admin', 'petugas']) &&
                $jurnal['status'] === 'menunggu'
            ): ?>

                <hr>

                <h6 class="font-weight-bold text-primary mb-3">
                    Pemeriksaan Jurnal
                </h6>

                <form action="<?= base_url('jurnal/setujui/' . $jurnal['id_jurnal']) ?>"
                      method="post" class="mb-4">

                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label>Catatan Pembimbing (Opsional)</label>
                        <textarea
                            name="catatan_pembimbing"
                            class="form-control"
                            rows="3"
                            maxlength="1000"
                            placeholder="Masukkan catatan jika diperlukan..."
                        ></textarea>
                    </div>

                    <button type="submit" class="btn btn-success"
                            onclick="return confirm('Apakah kamu yakin ingin menyetujui jurnal ini?')">
                        <i class="fas fa-check"></i> Setujui Jurnal
                    </button>
                </form>

                <form action="<?= base_url('jurnal/tolak/' . $jurnal['id_jurnal']) ?>"
                      method="post">

                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label>Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea
                            name="catatan_pembimbing"
                            class="form-control"
                            rows="3"
                            maxlength="1000"
                            placeholder="Tuliskan alasan penolakan jurnal..."
                            required
                        ></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah kamu yakin ingin menolak jurnal ini?')">
                        <i class="fas fa-times"></i> Tolak Jurnal
                    </button>
                </form>

            <?php endif; ?>

        </div>
    </div>

</div>
<?= $this->endSection() ?>
