<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AnggotaModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    // Menampilkan halaman view/auth/login
    public function login()
    {
        return view('auth/login');
    }

    // Memproses data login yang diinput pada halaman login
    public function prosesLogin()
{
    $session = session();
    $usersModel = new UsersModel();

    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $users = $usersModel->getUsersByUsername($username);

    if ($users && $users['status'] !== 'aktif') {
        $session->setFlashdata('error', 'Akun kamu sedang nonaktif.');
        return redirect()->to('/login');
    }

    if ($users) {
        if (password_verify($password, $users['password'])) {
            $session->set([
                'id' => $users['id'],
                'nama' => $users['nama'],
                'email' => $users['email'],
                'username' => $users['username'],
                'role' => $users['role'],
                'foto' => $users['foto'],
                'logged_in' => true
            ]);

           // Mengarahkan semua pengguna ke Dashboard Jurnal PKL
return redirect()->to('/dashboard-pkl');
        } else {
            $session->setFlashdata('salahpw', 'Password salah');
            return redirect()->to('/login');
        }
    } else {
        $session->setFlashdata('error', 'Nama tidak ditemukan');
        return redirect()->to('/login');
    }
}

    // Logout (keluar dari aplikasi)
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Menampilkan halaman registrasi
    public function register()
    {
        return view('auth/register');
    }

    // Memproses data registrasi (simpan ke users & anggota)
    
public function store()
{
    $db = \Config\Database::connect();

    $usersModel = new UsersModel();
    $anggotaModel = new AnggotaModel();
    $kelompokId = 1;

    // Validasi data registrasi
    $rules = [
        'nama' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
        'password' => 'required|min_length[6]',
        'password_confirm' => 'required|matches[password]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->validator->listErrors());
    }

    // Memulai transaksi database
    $db->transBegin();

    try {
        // Menghitung jumlah anggota kelompok
        $jumlahAnggota = $anggotaModel
            ->where('id_kelompok', $kelompokId)
            ->countAllResults();

        if ($jumlahAnggota >= 5) {
            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Kelompok PKL sudah penuh. Maksimal 5 anggota.');
        }

        // Menyimpan data pengguna
        $usersModel->insert([
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role' => 'anggota',
            'status' => 'aktif'
        ]);

        $userId = $usersModel->getInsertID();

        if (!$userId) {
            throw new \RuntimeException('Gagal menyimpan pengguna.');
        }

        // Memasukkan pengguna ke kelompok PKL
        $anggotaModel->insert([
            'id_user' => $userId,
            'id_kelompok' => $kelompokId,
            'tanggal_bergabung' => date('Y-m-d')
        ]);

        if ($db->transStatus() === false) {
            throw new \RuntimeException('Gagal menyimpan data anggota.');
        }

        $db->transCommit();

        return redirect()->to('/login')
            ->with('success', 'Registrasi berhasil! Silakan login.');

    } catch (\Throwable $e) {
        $db->transRollback();

        log_message('error', 'Registrasi gagal: ' . $e->getMessage());

        return redirect()->back()
            ->withInput()
            ->with('error', 'Registrasi gagal. Silakan periksa kembali data kamu.');
    }
}
}