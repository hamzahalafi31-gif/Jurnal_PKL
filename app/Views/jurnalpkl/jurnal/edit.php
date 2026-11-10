
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Edit Jurnal Aktivitas
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Jurnal Aktivitas
            </h6>

            <a href="<?= base_url('jurnal') ?>" class="btn btn-secondary btn-sm">
                Kembali
            </a>
        </div>

        <div class="card-body">

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('jurnal/update/' . $jurnal['id_jurnal']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="tanggal">Tanggal Kegiatan</label>
                    <input
                        type="date"
                        name="tanggal"
                        id="tanggal"
                        class="form-control"
                        value="<?= old('tanggal', $jurnal['tanggal']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="judul_kegiatan">Judul Kegiatan</label>
                    <input
                        type="text"
                        name="judul_kegiatan"
                        id="judul_kegiatan"
                        class="form-control"
                        value="<?= old('judul_kegiatan', $jurnal['judul_kegiatan']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="deskripsi_kegiatan">Deskripsi Kegiatan</label>
                    <textarea
                        name="deskripsi_kegiatan"
                        id="deskripsi_kegiatan"
                        class="form-control"
                        rows="5"
                        required
                    ><?= old('deskripsi_kegiatan', $jurnal['deskripsi_kegiatan']) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="jam_mulai">Jam Mulai</label>
                        <input
                            type="time"
                            name="jam_mulai"
                            id="jam_mulai"
                            class="form-control"
                            value="<?= old('jam_mulai', $jurnal['jam_mulai']) ?>"
                            required
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="jam_selesai">Jam Selesai</label>
                        <input
                            type="time"
                            name="jam_selesai"
                            id="jam_selesai"
                            class="form-control"
                            value="<?= old('jam_selesai', $jurnal['jam_selesai']) ?>"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a href="<?= base_url('jurnal') ?>" class="btn btn-light">
                    Batal
                </a>
            </form>

        </div>
    </div>

</div>
<?= $this->endSection() ?>
