<?php

namespace App\Controllers;

use App\Models\JurnalAktivitasModel;

class Jurnal extends BaseController
{
    protected $jurnal;

    public function __construct()
    {
        $this->jurnal = new JurnalAktivitasModel();
    }

    // Memastikan hanya admin dan petugas yang dapat melakukan persetujuan
    private function bolehReview()
    {
        return in_array(session()->get('role'), ['admin', 'petugas']);
    }

    // Menampilkan daftar jurnal
    public function index()
    {
        $role = session()->get('role');
        $idUser = session()->get('id');

        if (in_array($role, ['admin', 'petugas'])) {
            $jurnal = $this->jurnal->getAllWithUser();
        } else {
            $jurnal = $this->jurnal->getByUser($idUser);
        }

        return view('jurnalpkl/jurnal/index', [
            'jurnal' => $jurnal
        ]);
    }

    // Form tambah jurnal
    public function create()
    {
        if (session()->get('role') !== 'anggota') {
            return redirect()->to('/jurnal')
                ->with('error', 'Hanya anggota yang dapat membuat jurnal.');
        }

        return view('jurnalpkl/jurnal/create');
    }

    // Menyimpan jurnal
    public function store()
    {
        if (session()->get('role') !== 'anggota') {
            return redirect()->to('/jurnal')
                ->with('error', 'Akses ditolak.');
        }

        $rules = [
            'tanggal' => 'required|valid_date',
            'judul_kegiatan' => 'required|max_length[150]',
            'deskripsi_kegiatan' => 'required',
            'jam_mulai' => 'permit_empty',
            'jam_selesai' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->jurnal->insert([
            'id_user' => session()->get('id'),
            'tanggal' => $this->request->getPost('tanggal'),
            'judul_kegiatan' => $this->request->getPost('judul_kegiatan'),
            'deskripsi_kegiatan' => $this->request->getPost('deskripsi_kegiatan'),
            'jam_mulai' => $this->request->getPost('jam_mulai') ?: null,
            'jam_selesai' => $this->request->getPost('jam_selesai') ?: null,
            'status' => 'menunggu'
        ]);

        return redirect()->to('/jurnal')
            ->with('success', 'Jurnal aktivitas berhasil disimpan.');
    }

    // Detail jurnal
    public function detail($id)
    {
        $item = $this->jurnal->find($id);

        if (!$item) {
            return redirect()->to('/jurnal')
                ->with('error', 'Jurnal tidak ditemukan.');
        }

        $role = session()->get('role');

        if (!in_array($role, ['admin', 'petugas', 'anggota'])) {
            return redirect()->to('/jurnal')
                ->with('error', 'Akses ditolak.');
        }

        if (
            $role === 'anggota' &&
            $item['id_user'] != session()->get('id')
        ) {
            return redirect()->to('/jurnal')
                ->with('error', 'Kamu tidak memiliki akses ke jurnal ini.');
        }

        return view('jurnalpkl/jurnal/detail', [
            'jurnal' => $item
        ]);
    }

    // Form edit jurnal
    public function edit($id)
    {
        if (session()->get('role') !== 'anggota') {
            return redirect()->to('/jurnal')
                ->with('error', 'Hanya anggota yang dapat mengedit jurnal.');
        }

        $item = $this->jurnal->find($id);

        if (!$item || $item['id_user'] != session()->get('id')) {
            return redirect()->to('/jurnal')
                ->with('error', 'Jurnal tidak ditemukan atau akses ditolak.');
        }

        if (!in_array($item['status'], ['menunggu', 'ditolak'])) {
            return redirect()->to('/jurnal')
                ->with('error', 'Jurnal yang sudah disetujui tidak dapat diedit.');
        }

        return view('jurnalpkl/jurnal/edit', [
            'jurnal' => $item
        ]);
    }

    // Memperbarui jurnal
    public function update($id)
    {
        if (session()->get('role') !== 'anggota') {
            return redirect()->to('/jurnal')
                ->with('error', 'Akses ditolak.');
        }

        $item = $this->jurnal->find($id);

        if (!$item || $item['id_user'] != session()->get('id')) {
            return redirect()->to('/jurnal')
                ->with('error', 'Akses ditolak.');
        }

        if (!in_array($item['status'], ['menunggu', 'ditolak'])) {
            return redirect()->to('/jurnal')
                ->with('error', 'Jurnal sudah disetujui dan tidak dapat diedit.');
        }

        $rules = [
            'tanggal' => 'required|valid_date',
            'judul_kegiatan' => 'required|max_length[150]',
            'deskripsi_kegiatan' => 'required',
            'jam_mulai' => 'permit_empty',
            'jam_selesai' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->jurnal->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'judul_kegiatan' => $this->request->getPost('judul_kegiatan'),
            'deskripsi_kegiatan' => $this->request->getPost('deskripsi_kegiatan'),
            'jam_mulai' => $this->request->getPost('jam_mulai') ?: null,
            'jam_selesai' => $this->request->getPost('jam_selesai') ?: null,
            'status' => 'menunggu',
            'catatan_pembimbing' => null
        ]);

        return redirect()->to('/jurnal')
            ->with('success', 'Jurnal berhasil diperbarui.');
    }

    // Menghapus jurnal
    public function delete($id)
    {
        if (session()->get('role') !== 'anggota') {
            return redirect()->to('/jurnal')
                ->with('error', 'Hanya anggota yang dapat menghapus jurnal.');
        }

        $item = $this->jurnal->find($id);

        if (!$item || $item['id_user'] != session()->get('id')) {
            return redirect()->to('/jurnal')
                ->with('error', 'Akses ditolak.');
        }

        if ($item['status'] === 'disetujui') {
            return redirect()->to('/jurnal')
                ->with('error', 'Jurnal yang sudah disetujui tidak dapat dihapus.');
        }

        $this->jurnal->delete($id);

        return redirect()->to('/jurnal')
            ->with('success', 'Jurnal berhasil dihapus.');
    }

    // Menyetujui jurnal
    public function setujui($id)
    {
        if (!$this->bolehReview()) {
            return redirect()->to('/jurnal')
                ->with('error', 'Kamu tidak memiliki akses untuk menyetujui jurnal.');
        }

        $item = $this->jurnal->find($id);

        if (!$item) {
            return redirect()->to('/jurnal')
                ->with('error', 'Jurnal tidak ditemukan.');
        }

        if ($item['status'] !== 'menunggu') {
            return redirect()->to('/jurnal')
                ->with('error', 'Jurnal ini tidak sedang menunggu persetujuan.');
        }

        $this->jurnal->update($id, [
            'status' => 'disetujui',
            'catatan_pembimbing' => $this->request->getPost('catatan_pembimbing')
        ]);

        return redirect()->to('/jurnal')
            ->with('success', 'Jurnal berhasil disetujui.');
    }

    // Menolak jurnal
    public function tolak($id)
    {
        if (!$this->bolehReview()) {
            return redirect()->to('/jurnal')
                ->with('error', 'Kamu tidak memiliki akses untuk menolak jurnal.');
        }

        $item = $this->jurnal->find($id);

        if (!$item) {
            return redirect()->to('/jurnal')
                ->with('error', 'Jurnal tidak ditemukan.');
        }

        if ($item['status'] !== 'menunggu') {
            return redirect()->to('/jurnal')
                ->with('error', 'Jurnal ini tidak sedang menunggu persetujuan.');
        }

        $catatan = trim((string) $this->request->getPost('catatan_pembimbing'));

        if ($catatan === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Catatan penolakan wajib diisi.');
        }

        if (mb_strlen($catatan) > 1000) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Catatan maksimal 1000 karakter.');
        }

        $this->jurnal->update($id, [
            'status' => 'ditolak',
            'catatan_pembimbing' => $catatan
        ]);

        return redirect()->to('/jurnal')
            ->with('success', 'Jurnal berhasil ditolak dan catatan disimpan.');
    }
    
    // Menampilkan rekap jurnal aktivitas
    public function rekap()
    {
        $role = session()->get('role');

        if (!in_array($role, ['admin', 'petugas', 'anggota'])) {
            return redirect()->to('/jurnal')
                ->with('error', 'Akses ditolak.');
        }

        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalSelesai = $this->request->getGet('tanggal_selesai');

        // Validasi format tanggal
        foreach ([$tanggalMulai, $tanggalSelesai] as $tanggal) {
            if (
                !empty($tanggal) &&
                !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)
            ) {
                return redirect()->to('/jurnal/rekap')
                    ->with('error', 'Format tanggal tidak valid.');
            }
        }

        // Pastikan tanggal mulai tidak melebihi tanggal selesai
        if (
            !empty($tanggalMulai) &&
            !empty($tanggalSelesai) &&
            $tanggalMulai > $tanggalSelesai
        ) {
            return redirect()->to('/jurnal/rekap')
                ->with('error', 'Tanggal mulai tidak boleh melebihi tanggal selesai.');
        }

        // Anggota hanya melihat jurnal miliknya
        $idUser = ($role === 'anggota')
            ? session()->get('id')
            : null;

        $rekap = $this->jurnal->getRekap(
            $idUser,
            $tanggalMulai,
            $tanggalSelesai
        );

        return view('jurnalpkl/jurnal/rekap', [
            'rekap' => $rekap,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai
        ]);
    }

}
