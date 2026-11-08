<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AnggotaModel;

class ManajemenPengguna extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    // Menampilkan pengguna berdasarkan role
public function index()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->to('/dashboard-pkl')
            ->with('error', 'Kamu tidak memiliki akses.');
    }

    // Mengambil filter role dari URL
    $role = $this->request->getGet('role');

    // Role yang diperbolehkan
    $roleDiizinkan = [
        'admin',
        'petugas',
        'anggota',
        'pembimbing'
    ];

    // Memeriksa role yang dikirim
    if ($role && !in_array($role, $roleDiizinkan, true)) {
        return redirect()->to('/manajemen-pengguna')
            ->with('error', 'Filter role tidak valid.');
    }

    // Mengambil data pengguna
    $builder = $this->users->orderBy('nama', 'ASC');

    if ($role) {
        $builder->where('role', $role);
    }

    $data = [
        'title' => $role
            ? 'Manajemen Pengguna - ' . ucfirst($role)
            : 'Manajemen Pengguna',

        'pengguna' => $builder->findAll(),

        'role' => $role
    ];

    return view('jurnalpkl/pengguna/index', $data);
}

    // Menampilkan form tambah pengguna
    public function tambah()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard-pkl')
                ->with('error', 'Kamu tidak memiliki akses.');
        }

        return view('jurnalpkl/pengguna/tambah', [
            'title' => 'Tambah Pengguna'
        ]);
    }

    // Menampilkan form edit pengguna
    public function edit($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard-pkl')
                ->with('error', 'Kamu tidak memiliki akses.');
        }

        $pengguna = $this->users->find($id);

        if (!$pengguna) {
            return redirect()->to('/manajemen-pengguna')
                ->with('error', 'Pengguna tidak ditemukan.');
        }

        return view('jurnalpkl/pengguna/edit', [
            'title' => 'Edit Pengguna',
            'pengguna' => $pengguna
        ]);
    }

    // Menyimpan pengguna baru
    public function simpan()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard-pkl')
                ->with('error', 'Kamu tidak memiliki akses.');
        }

        $nama     = trim($this->request->getPost('nama'));
        $email    = trim($this->request->getPost('email'));
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');

        if (
            $nama === '' ||
            $email === '' ||
            $username === '' ||
            $password === ''
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Semua kolom wajib diisi.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Format email tidak valid.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password minimal 6 karakter.');
        }

        $roleDiizinkan = [
            'admin',
            'anggota',
            'petugas',
            'pembimbing'
        ];

        if (!in_array($role, $roleDiizinkan, true)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Role pengguna tidak valid.');
        }

        if ($this->users->where('email', $email)->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email sudah digunakan.');
        }

        if ($this->users->where('username', $username)->first()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username sudah digunakan.');
        }

        $db = \Config\Database::connect();
        $anggotaModel = new AnggotaModel();

        $kelompok = null;

        if ($role === 'anggota') {
            $kelompok = $db->table('kelompok')
                ->orderBy('id_kelompok', 'ASC')
                ->get()
                ->getRowArray();

            if (!$kelompok) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Belum ada kelompok PKL.');
            }

            $jumlahAnggota = $anggotaModel
                ->where('id_kelompok', $kelompok['id_kelompok'])
                ->countAllResults();

            if ($jumlahAnggota >= 5) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kelompok PKL sudah mencapai batas 5 anggota.');
            }
        }

        $db->transBegin();

        $userId = $this->users->insert([
            'nama'     => $nama,
            'email'    => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => $role,
            'status'   => 'aktif'
        ]);

        if (!$userId) {
            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan akun pengguna.');
        }

        if ($role === 'anggota') {
            $berhasil = $anggotaModel->insert([
                'id_user' => $userId,
                'id_kelompok' => $kelompok['id_kelompok'],
                'tanggal_bergabung' => date('Y-m-d')
            ]);

            if (!$berhasil) {
                $db->transRollback();

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan data kelompok anggota.');
            }
        }

        if ($db->transStatus() === false) {
            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengguna.');
        }

        $db->transCommit();

        return redirect()->to('/manajemen-pengguna')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Memperbarui data pengguna
    public function update($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard-pkl')
                ->with('error', 'Kamu tidak memiliki akses.');
        }

        $pengguna = $this->users->find($id);

        if (!$pengguna) {
            return redirect()->to('/manajemen-pengguna')
                ->with('error', 'Pengguna tidak ditemukan.');
        }

        $nama     = trim($this->request->getPost('nama'));
        $email    = trim($this->request->getPost('email'));
        $username = trim($this->request->getPost('username'));
        $role     = $this->request->getPost('role');

        if ($nama === '' || $email === '' || $username === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Semua kolom wajib diisi.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Format email tidak valid.');
        }

        $roleDiizinkan = [
            'admin',
            'anggota',
            'petugas',
            'pembimbing'
        ];

        if (!in_array($role, $roleDiizinkan, true)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Role tidak valid.');
        }

        $emailAda = $this->users
            ->where('email', $email)
            ->where('id !=', $id)
            ->first();

        if ($emailAda) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email sudah digunakan pengguna lain.');
        }

        $usernameAda = $this->users
            ->where('username', $username)
            ->where('id !=', $id)
            ->first();

        if ($usernameAda) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username sudah digunakan pengguna lain.');
        }

        $db = \Config\Database::connect();
        $anggotaModel = new AnggotaModel();

        $relasiAnggota = $anggotaModel->getByUserId($id);
        $kelompok = null;

        if ($role === 'anggota' && !$relasiAnggota) {
            $kelompok = $db->table('kelompok')
                ->orderBy('id_kelompok', 'ASC')
                ->get()
                ->getRowArray();

            if (!$kelompok) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Belum ada kelompok PKL.');
            }

            $jumlahAnggota = $anggotaModel
                ->where('id_kelompok', $kelompok['id_kelompok'])
                ->countAllResults();

            if ($jumlahAnggota >= 5) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kelompok PKL sudah mencapai batas 5 anggota.');
            }
        }

        $db->transBegin();

        $berhasil = $this->users->update($id, [
            'nama' => $nama,
            'email' => $email,
            'username' => $username,
            'role' => $role
        ]);

        if (!$berhasil) {
            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui pengguna.');
        }

        if ($role === 'anggota' && !$relasiAnggota) {
            $dbBerhasil = $anggotaModel->insert([
                'id_user' => $id,
                'id_kelompok' => $kelompok['id_kelompok'],
                'tanggal_bergabung' => date('Y-m-d')
            ]);

            if (!$dbBerhasil) {
                $db->transRollback();

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal membuat relasi anggota.');
            }
        }

        if ($role !== 'anggota' && $relasiAnggota) {
            $dbBerhasil = $anggotaModel
                ->where('id_user', $id)
                ->delete();

            if (!$dbBerhasil) {
                $db->transRollback();

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal memperbarui relasi anggota.');
            }
        }

        if ($db->transStatus() === false) {
            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui pengguna.');
        }

        $db->transCommit();

        return redirect()->to('/manajemen-pengguna')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }
}
