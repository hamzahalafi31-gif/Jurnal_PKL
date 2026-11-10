
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Tambah Tugas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="font-weight-bold text-primary">Tambah Tugas</h4>
            <p class="text-muted mb-0">Buat tugas baru untuk anggota PKL</p>
        </div>

        <a href="<?= base_url('task') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <strong><i class="bi bi-clipboard-plus"></i> Formulir Tugas PKL</strong>
        </div>

        <div class="card-body">

            <form action="<?= base_url('task/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label>Judul Tugas <span class="text-danger">*</span></label>
                    <input type="text"
                           name="judul"
                           class="form-control"
                           value="<?= old('judul') ?>"
                           placeholder="Masukkan judul tugas"
                           maxlength="150"
                           required>
                </div>

                <div class="form-group">
                    <label>Deskripsi Tugas</label>
                    <textarea name="deskripsi"
                              class="form-control"
                              rows="4"
                              placeholder="Jelaskan tugas yang harus dikerjakan"><?= old('deskripsi') ?></textarea>
                </div>

                <div class="form-group">
                    <label>Penanggung Jawab</label>
                    <select name="id_penanggung_jawab" class="form-control">
                        <option value="">-- Pilih Anggota PKL --</option>

                        <?php foreach ($anggota as $item): ?>
                            <option value="<?= esc($item['id']) ?>"
                                <?= old('id_penanggung_jawab') == $item['id'] ? 'selected' : '' ?>>
                                <?= esc($item['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">
                        Pilih anggota yang akan menerima tugas.
                    </small>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Prioritas <span class="text-danger">*</span></label>
                        <select name="prioritas" class="form-control" required>
                            <option value="">-- Pilih Prioritas --</option>
                            <option value="rendah" <?= old('prioritas') == 'rendah' ? 'selected' : '' ?>>Rendah</option>
                            <option value="sedang" <?= old('prioritas') == 'sedang' ? 'selected' : '' ?>>Sedang</option>
                            <option value="tinggi" <?= old('prioritas') == 'tinggi' ? 'selected' : '' ?>>Tinggi</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Tanggal Mulai</label>
                        <input type="date"
                               name="tanggal_mulai"
                               class="form-control"
                               value="<?= old('tanggal_mulai') ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Deadline</label>
                        <input type="date"
                               name="deadline"
                               class="form-control"
                               value="<?= old('deadline') ?>">
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-end">
                    <a href="<?= base_url('task') ?>" class="btn btn-light mr-2">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Tugas
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
