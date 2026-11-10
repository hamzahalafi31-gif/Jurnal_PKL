<?php

namespace App\Controllers;

use App\Models\TaskModel;

class Task extends BaseController
{
    protected $task;

    public function __construct()
    {
        $this->task = new TaskModel();
    }

    // Memeriksa hak akses
    private function isPengelola()
    {
        return in_array(session()->get('role'), ['admin', 'petugas']);
    }

    // Memeriksa apakah tugas boleh diakses pengguna
    private function aksesTask($idTask)
    {
        $task = $this->task->find($idTask);

        if (!$task) {
            return null;
        }

        $role = session()->get('role');
        $idUser = session()->get('id');

        if (
            !$this->isPengelola() &&
            (int) $task['id_penanggung_jawab'] !== (int) $idUser
        ) {
            return null;
        }

        return $task;
    }

    // Daftar tugas
    public function index()
    {
        if ($this->isPengelola()) {
            $data['tasks'] = $this->task->getAllTasks();
        } else {
            $data['tasks'] = $this->task
                ->where('id_penanggung_jawab', session()->get('id'))
                ->orderBy('deadline', 'ASC')
                ->findAll();
        }

        return view('jurnalpkl/task/index', $data);
    }

    // Form tambah tugas
    public function create()
    {
        if (!$this->isPengelola()) {
            return redirect()->to('/task')
                ->with('error', 'Kamu tidak memiliki akses.');
        }

        $data['anggota'] = $this->dbAnggota();

        return view('jurnalpkl/task/create', $data);
    }

    // Mengambil daftar anggota PKL
    private function dbAnggota()
    {
        return \Config\Database::connect()
            ->table('users')
            ->where('role', 'anggota')
            ->where('status', 'aktif')
            ->get()
            ->getResultArray();
    }

    // Menyimpan tugas baru
    public function store()
    {
        if (!$this->isPengelola()) {
            return redirect()->to('/task')
                ->with('error', 'Kamu tidak memiliki akses.');
        }

        $rules = [
            'judul' => 'required|max_length[150]',
            'deskripsi' => 'permit_empty',
            'prioritas' => 'required|in_list[rendah,sedang,tinggi]',
            'id_penanggung_jawab' => 'permit_empty|integer',
            'tanggal_mulai' => 'permit_empty|valid_date[Y-m-d]',
            'deadline' => 'permit_empty|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $idAnggota = $this->request->getPost('id_penanggung_jawab');

        if ($idAnggota) {
            $anggotaValid = \Config\Database::connect()
                ->table('users')
                ->where('id', $idAnggota)
                ->where('role', 'anggota')
                ->where('status', 'aktif')
                ->countAllResults();

            if (!$anggotaValid) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Anggota tidak ditemukan.');
            }
        }

        $this->task->insert([
            'id_pembuat' => session()->get('id'),
            'id_penanggung_jawab' => $idAnggota ?: null,
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'prioritas' => $this->request->getPost('prioritas'),
            'status' => 'menunggu',
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai') ?: null,
            'deadline' => $this->request->getPost('deadline') ?: null,
        ]);

        return redirect()->to('/task')
            ->with('success', 'Tugas berhasil dibuat.');
    }

    // Detail tugas
    public function detail($idTask)
    {
        $task = $this->aksesTask($idTask);

        if (!$task) {
            return redirect()->to('/task')
                ->with('error', 'Tugas tidak ditemukan atau akses ditolak.');
        }

        $data['task'] = $this->task->getDetailTask($idTask);

        return view('jurnalpkl/task/detail', $data);
    }

    // Form edit tugas
    public function edit($idTask)
    {
        if (!$this->isPengelola()) {
            return redirect()->to('/task')
                ->with('error', 'Kamu tidak memiliki akses.');
        }

        $task = $this->task->find($idTask);

        if (!$task) {
            return redirect()->to('/task')
                ->with('error', 'Tugas tidak ditemukan.');
        }

        $data['task'] = $task;
        $data['anggota'] = $this->dbAnggota();

        return view('jurnalpkl/task/edit', $data);
    }

    // Memperbarui tugas
    public function update($idTask)
    {
        if (!$this->isPengelola()) {
            return redirect()->to('/task')
                ->with('error', 'Kamu tidak memiliki akses.');
        }

        if (!$this->task->find($idTask)) {
            return redirect()->to('/task')
                ->with('error', 'Tugas tidak ditemukan.');
        }

        $rules = [
            'judul' => 'required|max_length[150]',
            'deskripsi' => 'permit_empty',
            'prioritas' => 'required|in_list[rendah,sedang,tinggi]',
            'id_penanggung_jawab' => 'permit_empty|integer',
            'tanggal_mulai' => 'permit_empty|valid_date[Y-m-d]',
            'deadline' => 'permit_empty|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $idAnggota = $this->request->getPost('id_penanggung_jawab');

        if ($idAnggota) {
            $anggotaValid = \Config\Database::connect()
                ->table('users')
                ->where('id', $idAnggota)
                ->where('role', 'anggota')
                ->where('status', 'aktif')
                ->countAllResults();

            if (!$anggotaValid) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Anggota tidak ditemukan.');
            }
        }

        $this->task->update($idTask, [
            'id_penanggung_jawab' => $idAnggota ?: null,
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'prioritas' => $this->request->getPost('prioritas'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai') ?: null,
            'deadline' => $this->request->getPost('deadline') ?: null,
        ]);

        return redirect()->to('/task')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    // Menghapus tugas
    public function delete($idTask)
    {
        if (!$this->isPengelola()) {
            return redirect()->to('/task')
                ->with('error', 'Kamu tidak memiliki akses.');
        }

        if (!$this->task->find($idTask)) {
            return redirect()->to('/task')
                ->with('error', 'Tugas tidak ditemukan.');
        }

        $this->task->delete($idTask);

        return redirect()->to('/task')
            ->with('success', 'Tugas berhasil dihapus.');
    }

    // Anggota mengirim hasil pengerjaan
    public function kirimHasil($idTask)
    {
        if (session()->get('role') !== 'anggota') {
            return redirect()->to('/task')
                ->with('error', 'Khusus anggota PKL.');
        }

        $task = $this->aksesTask($idTask);

        if (!$task) {
            return redirect()->to('/task')
                ->with('error', 'Tugas tidak ditemukan.');
        }

        if ($task['status'] === 'selesai') {
            return redirect()->to('/task')
                ->with('error', 'Tugas sudah selesai.');
        }

        $hasil = trim($this->request->getPost('hasil_pengerjaan'));

        if ($hasil === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Hasil pengerjaan wajib diisi.');
        }

        $data = [
            'hasil_pengerjaan' => $hasil,
            'status' => 'menunggu',
        ];

        $file = $this->request->getFile('file_hasil');

        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            if (!$file->isValid()) {
                return redirect()->back()
                    ->with('error', 'File gagal diunggah.');
            }

            $jenisFile = [
                'pdf',
                'jpg',
                'jpeg',
                'png',
                'doc',
                'docx',
                'xls',
                'xlsx'
            ];

            if (
                !in_array(strtolower($file->getExtension()), $jenisFile) ||
                $file->getSizeByUnit('mb') > 5
            ) {
                return redirect()->back()
                    ->with('error', 'Format file tidak sesuai atau ukuran melebihi 5 MB.');
            }

            $folder = FCPATH . 'uploads/tasks/';

            if (!is_dir($folder)) {
                mkdir($folder, 0755, true);
            }

            $namaFile = $file->getRandomName();
            $file->move($folder, $namaFile);

            $data['file_hasil'] = $namaFile;
        }

        $this->task->update($idTask, $data);

        return redirect()->to('/task/detail/' . $idTask)
            ->with('success', 'Hasil pengerjaan berhasil dikirim.');
    }

    // Admin/Petugas memeriksa hasil tugas
    
public function review($idTask)
{
    if (!$this->isPengelola()) {
        return redirect()->to('/task')
            ->with('error', 'Kamu tidak memiliki akses.');
    }

    $task = $this->task->find($idTask);

    if (!$task) {
        return redirect()->to('/task')
            ->with('error', 'Tugas tidak ditemukan.');
    }

    // Mengambil status pemeriksaan
    $status = $this->request->getPost('status');

    if (!in_array($status, ['selesai', 'revisi'], true)) {
        return redirect()->back()
            ->with('error', 'Status pemeriksaan tidak valid.');
    }

    // Mengambil catatan revisi
    $catatan = trim($this->request->getPost('catatan_revisi') ?? '');

    // Catatan wajib diisi jika tugas perlu direvisi
    if ($status === 'revisi' && $catatan === '') {
        return redirect()->back()
            ->with('error', 'Catatan revisi wajib diisi.');
    }

    // Menyimpan hasil pemeriksaan
    $this->task->update($idTask, [
        'status' => $status,
        'catatan_revisi' => $status === 'revisi' ? $catatan : null,
    ]);

    return redirect()->to('/task/detail/' . $idTask)
        ->with('success', 'Pemeriksaan tugas berhasil disimpan.');
}

}
