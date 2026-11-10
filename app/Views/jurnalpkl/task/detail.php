
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Detail Tugas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$role = session()->get('role');
$isPengelola = in_array($role, ['admin', 'petugas']);
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="font-weight-bold text-primary">Detail Tugas</h4>
            <p class="text-muted mb-0">Informasi dan hasil pengerjaan tugas PKL</p>
        </div>

        <a href="<?= base_url('task') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <!-- Informasi Tugas -->
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-primary text-white">
            <strong><i class="bi bi-clipboard-check"></i> Informasi Tugas</strong>
        </div>

        <div class="card-body">

            <h5 class="font-weight-bold">
                <?= esc($task['judul']) ?>
            </h5>

            <p class="text-muted">
                <?= nl2br(esc($task['deskripsi'] ?? '-')) ?>
            </p>

            <hr>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>Pembuat Tugas:</strong><br>
                    <?= esc($task['nama_pembuat'] ?? '-') ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Penanggung Jawab:</strong><br>
                    <?= esc($task['nama_penanggung_jawab'] ?? 'Belum ditentukan') ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Prioritas:</strong><br>
                    <?= esc(ucfirst($task['prioritas'])) ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Status:</strong><br>

                    <?php
                    $warna = [
                        'menunggu' => 'secondary',
                        'dikerjakan' => 'primary',
                        'selesai' => 'success',
                        'revisi' => 'danger'
                    ];
                    $warnaStatus = $warna[$task['status']] ?? 'secondary';
                    ?>

                    <span class="badge badge-<?= $warnaStatus ?>">
                        <?= esc(ucwords(str_replace('_', ' ', $task['status']))) ?>
                    </span>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Tanggal Mulai:</strong><br>
                    <?= !empty($task['tanggal_mulai'])
                        ? date('d-m-Y', strtotime($task['tanggal_mulai']))
                        : '-' ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Deadline:</strong><br>
                    <?= !empty($task['deadline'])
                        ? date('d-m-Y', strtotime($task['deadline']))
                        : '-' ?>
                </div>

            </div>

        </div>
    </div>

    <!-- Hasil Pengerjaan -->
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-info text-white">
            <strong><i class="bi bi-file-earmark-text"></i> Hasil Pengerjaan</strong>
        </div>

        <div class="card-body">

            <?php if (!empty($task['hasil_pengerjaan'])): ?>

                <div class="mb-3">
                    <?= nl2br(esc($task['hasil_pengerjaan'])) ?>
                </div>

                <?php if (!empty($task['file_hasil'])): ?>
                    <hr>

                    <strong>File Hasil:</strong><br>

                    <a href="<?= base_url('uploads/tasks/' . rawurlencode($task['file_hasil'])) ?>"
                       target="_blank"
                       rel="noopener">
                        <i class="bi bi-file-earmark-arrow-down"></i>
                        Lihat / Unduh File
                    </a>
                <?php endif; ?>

            <?php else: ?>

                <p class="text-muted mb-0">
                    Belum ada hasil pengerjaan yang dikirim.
                </p>

            <?php endif; ?>

        </div>
    </div>

    <!-- Form Anggota -->
    <?php if (!$isPengelola && $task['status'] !== 'selesai'): ?>

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-success text-white">
                <strong><i class="bi bi-send"></i> Kirim Hasil Tugas</strong>
            </div>

            <div class="card-body">

                <?php if ($task['status'] === 'revisi' && !empty($task['catatan_revisi'])): ?>
                    <div class="alert alert-warning">
                        <strong>Catatan Revisi:</strong><br>
                        <?= nl2br(esc($task['catatan_revisi'])) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('task/kirim-hasil/' . $task['id_task']) ?>"
                      method="post"
                      enctype="multipart/form-data">

                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label>Hasil Pengerjaan <span class="text-danger">*</span></label>

                        <textarea name="hasil_pengerjaan"
                                  class="form-control"
                                  rows="5"
                                  required
                                  placeholder="Jelaskan hasil pengerjaan tugas..."><?= esc($task['hasil_pengerjaan'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload File Hasil (Opsional)</label>

                        <input type="file"
                               name="file_hasil"
                               class="form-control-file"
                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">

                        <small class="text-muted">
                            Format PDF, JPG, PNG, DOC, DOCX, XLS, XLSX. Maksimal 5 MB.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send"></i> Kirim Hasil
                    </button>

                </form>

            </div>
        </div>

    <?php endif; ?>

    <!-- Form Pemeriksaan Admin/Petugas -->
    <?php if ($isPengelola && !empty($task['hasil_pengerjaan'])): ?>

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-warning">
                <strong><i class="bi bi-clipboard-check"></i> Pemeriksaan Tugas</strong>
            </div>

            <div class="card-body">

                <form action="<?= base_url('task/review/' . $task['id_task']) ?>"
                      method="post">

                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label>Status Pemeriksaan</label>

                        <select name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>

                            <option value="selesai"
                                <?= $task['status'] === 'selesai' ? 'selected' : '' ?>>
                                Selesai
                            </option>

                            <option value="revisi"
                                <?= $task['status'] === 'revisi' ? 'selected' : '' ?>>
                                Revisi
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Catatan Revisi</label>

                        <textarea name="catatan_revisi"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Tuliskan catatan jika tugas perlu diperbaiki..."><?= esc($task['catatan_revisi'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Pemeriksaan
                    </button>

                </form>

            </div>
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>
