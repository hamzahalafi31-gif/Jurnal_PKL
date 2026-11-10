
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Task Management
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="font-weight-bold text-primary">Task Management</h4>
            <p class="text-muted mb-0">Daftar tugas Praktik Kerja Lapangan</p>
        </div>

        <?php if (in_array(session()->get('role'), ['admin', 'petugas'])): ?>
            <a href="<?= base_url('task/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Tugas
            </a>
        <?php endif; ?>
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

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Judul Tugas</th>
                            <?php if (in_array(session()->get('role'), ['admin', 'petugas'])): ?>
                                <th>Penanggung Jawab</th>
                            <?php endif; ?>
                            <th>Prioritas</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($tasks)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><?= $no++ ?></td>

                                    <td>
                                        <strong><?= esc($task['judul']) ?></strong>
                                    </td>

                                    <?php if (in_array(session()->get('role'), ['admin', 'petugas'])): ?>
                                        <td>
                                            <?= esc($task['nama_penanggung_jawab'] ?? 'Belum ditentukan') ?>
                                        </td>
                                    <?php endif; ?>

                                    <td>
                                       
<?php
$prioritas = [
    'rendah' => ['bg' => '#6c757d', 'color' => '#ffffff'],
    'sedang' => ['bg' => '#ffc107', 'color' => '#212529'],
    'tinggi' => ['bg' => '#dc3545', 'color' => '#ffffff']
];

$warnaPrioritas = $prioritas[$task['prioritas']] ?? $prioritas['rendah'];
?>

<span class="badge"
      style="background-color: <?= $warnaPrioritas['bg'] ?>; color: <?= $warnaPrioritas['color'] ?>;">
    <?= esc(ucfirst($task['prioritas'])) ?>
</span>

                                    </td>

                                    <td>
                                        <?= !empty($task['deadline'])
                                            ? date('d-m-Y', strtotime($task['deadline']))
                                            : '-' ?>
                                    </td>

                                    <td>
                                        
<?php
$status = [
    'menunggu' => ['bg' => '#6c757d', 'color' => '#ffffff'],
    'dikerjakan' => ['bg' => '#0d6efd', 'color' => '#ffffff'],
    'selesai' => ['bg' => '#198754', 'color' => '#ffffff'],
    'revisi' => ['bg' => '#dc3545', 'color' => '#ffffff']
];

$warnaStatus = $status[$task['status']] ?? $status['menunggu'];
?>

<span class="badge"
      style="background-color: <?= $warnaStatus['bg'] ?>; color: <?= $warnaStatus['color'] ?>;">
    <?= esc(ucwords(str_replace('_', ' ', $task['status']))) ?>
</span>

                                    </td>

                                    <td>
                                        <a href="<?= base_url('task/detail/' . $task['id_task']) ?>"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>

                                        <?php if (in_array(session()->get('role'), ['admin', 'petugas'])): ?>
                                            <a href="<?= base_url('task/edit/' . $task['id_task']) ?>"
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="<?= base_url('task/delete/' . $task['id_task']) ?>"
                                                  method="post"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="<?= in_array(session()->get('role'), ['admin', 'petugas']) ? 7 : 6 ?>"
                                    class="text-center text-muted py-4">
                                    Belum ada tugas.
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
