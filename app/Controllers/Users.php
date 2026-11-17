<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AnggotaModel;


class Users extends BaseController
{
    protected $users;
    protected $anggota;
    

    public function __construct()
    {
        $this->users  = new UsersModel();
        $this->anggota = new AnggotaModel();
        
    }

    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama'     => 'required',
            'email'    => 'required|valid_email',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[4]',
            'nis'      => 'required',
            'alamat'   => 'required',
            'no_hp'    => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', implode('<br>', $validation->getErrors()));
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/users', $namaFoto);
        }

        $userData = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'anggota',
            'foto'     => $namaFoto,
        ];

        $this->users->save($userData);
        $userId = $this->users->getInsertID();

        $this->anggota->save([
            'user_id'      => $userId,
            'nis'          => $this->request->getPost('nis'),
            'alamat'       => $this->request->getPost('alamat'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'tanggal_daftar' => date('Y-m-d'),
        ]);

        return redirect()->to('/login')->with('success', 'User berhasil ditambahkan!');
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        $builder = $this->users;

        if ($keyword) {
            $builder = $builder->like('nama', $keyword);
        }

        if ($role) {
            $builder = $builder->where('role', $role);
        }

        $data['users'] = $builder->paginate(10);
        $data['pager'] = $this->users->pager;
        $data['keyword'] = $keyword;
        $data['role'] = $role;

        return view('users/index', $data);
    }

    public function edit($id)
{
    $user = $this->users->find($id);

    if (!$user) {
        return redirect()->to('/users')->with('error', 'Data tidak ditemukan');
    }

    $data['user'] = $user;

    if ($user['role'] === 'anggota') {
        $data['anggota'] = $this->anggota->getByUserId($id);
    }

    return view('users/edit', $data);
}

    public function update($id)
    {
        $user = $this->users->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'Data tidak ditemukan');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama'     => 'required',
            'email'    => 'required|valid_email',
            'username' => "required|is_unique[users.username,id,$id]",
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', implode('<br>', $validation->getErrors()));
        }

        $fotoBaru = $this->request->getFile('foto');
        $namaFoto = $user['foto'];

        if ($fotoBaru && $fotoBaru->isValid() && $fotoBaru->getName() != '') {
            if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
                unlink(FCPATH . 'uploads/users/' . $user['foto']);
            }
            $namaFoto = $fotoBaru->getRandomName();
            $fotoBaru->move(FCPATH . 'uploads/users', $namaFoto);
        }

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
            'foto'     => $namaFoto,
        ];

        if ($this->request->getPost('password') != "") {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

       $this->users->update($id, $data);

// Perbarui session jika pengguna mengedit profilnya sendiri
if (session()->get('id') == $id) {
    session()->set([
        'nama' => $data['nama'],
        'foto' => $namaFoto
    ]);
}

// Data profil dan foto sudah diperbarui melalui tabel users.
// Tabel anggota_kelompok khusus untuk hubungan pengguna dengan kelompok.

$session = session();
$loggedInId = $session->get('id');
$loggedInRole = $session->get('role');

if ($loggedInRole === 'admin') {
    return redirect()->to('/users')
        ->with('success', 'Data user berhasil diupdate!');
}

if ($loggedInId == $id) {
    return redirect()->to('/users/edit/' . $id)
        ->with('success', 'Data user berhasil diupdate!');
}

return redirect()->to('/users')
    ->with('success', 'Data user berhasil diupdate!');
}

    public function delete($id)
    {
        $user = $this->users->find($id);

        if ($user['foto'] && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/users/' . $user['foto']);
        }

        $this->users->delete($id);

        return redirect()->to('/users')->with('success', 'User berhasil dihapus!');
    }

    public function detail($id)
{
    $user = $this->users->find($id);

    if (!$user) {
        return redirect()->to('/users')->with('error', 'Data tidak ditemukan');
    }

    $data['user'] = $user;

    // Ambil data anggota PKL
    if ($user['role'] === 'anggota') {
        $data['anggota'] = $this->anggota->getByUserId($id);
    }

    

    return view('users/detail', $data);
    }

    public function print()
    {
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        $builder = $this->users;

        if ($keyword) {
            $builder = $builder->like('nama', $keyword);
        }

        if ($role) {
            $builder = $builder->where('role', $role);
        }

        $data['users'] = $builder->findAll();

        return view('users/print', $data);
    }

    public function wa($id)
    {
        $user = $this->users->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $pesan = "DATA USER\n\n";
        $pesan .= "ID: " . $user['id'] . "\n";
        $pesan .= "Nama: " . $user['nama'] . "\n";
        $pesan .= "Email: " . $user['email'] . "\n";
        $pesan .= "Username: " . $user['username'] . "\n";
        $pesan .= "Role: " . ucfirst($user['role']) . "\n";

        $url = "https://wa.me/6285175017991?text=" . urlencode($pesan);

        return redirect()->to($url);
    }
}