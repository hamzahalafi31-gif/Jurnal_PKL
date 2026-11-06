<?php

namespace App\Controllers;

use App\Models\PresensiModel;

class Presensi extends BaseController
{
    protected $presensi;

    public function __construct()
    {
        $this->presensi = new PresensiModel();
    }

    // Menampilkan halaman presensi
    public function index()
    {
        $idUser = session()->get('id');

        $data = [
            'title' => 'Presensi PKL',
            'presensiHariIni' => $this->presensi
                ->getPresensiHariIni($idUser),
            'riwayat' => $this->presensi
                ->getByUser($idUser)
        ];

        return view('jurnalpkl/presensi/index', $data);
    }

    // Menyimpan foto presensi
    private function uploadFoto($file)
    {
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return false;
        }

        $mime = $file->getMimeType();

        $allowedMime = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!in_array($mime, $allowedMime)) {
            return false;
        }

        if ($file->getSize() > 2 * 1024 * 1024) {
            return false;
        }

        $folder = FCPATH . 'uploads/presensi';

        if (!is_dir($folder)) {
            mkdir($folder, 0775, true);
        }

        $namaFile = $file->getRandomName();

        if (!$file->move($folder, $namaFile)) {
            return false;
        }

        return $namaFile;
    }

    // Presensi masuk
    public function store()
    {
        $idUser = session()->get('id');

        $presensiHariIni = $this->presensi
            ->getPresensiHariIni($idUser);

        if ($presensiHariIni) {
            return redirect()->to('/presensi')
                ->with('error', 'Kamu sudah melakukan presensi hari ini.');
        }

        $foto = $this->request->getFile('foto_masuk');

        $namaFoto = $this->uploadFoto($foto);

        if (!$namaFoto) {
            return redirect()->to('/presensi')
                ->with('error', 'Foto tidak valid. Gunakan JPG, PNG, atau WEBP maksimal 2 MB.');
        }

        $hasil = $this->presensi->insert([
            'id_user' => $idUser,
            'tanggal' => date('Y-m-d'),
            'jam_masuk' => date('H:i:s'),
            'foto_masuk' => $namaFoto,
            'status' => 'hadir',
            'keterangan' => null
        ]);

        if (!$hasil) {
            $path = FCPATH . 'uploads/presensi/' . $namaFoto;

            if (is_file($path)) {
                unlink($path);
            }

            return redirect()->to('/presensi')
                ->with('error', 'Presensi masuk gagal disimpan.');
        }

        return redirect()->to('/presensi')
            ->with('success', 'Presensi masuk berhasil disimpan.');
    }

    // Presensi pulang
    public function pulang()
    {
        $idUser = session()->get('id');

        $presensiHariIni = $this->presensi
            ->getPresensiHariIni($idUser);

        if (!$presensiHariIni) {
            return redirect()->to('/presensi')
                ->with('error', 'Kamu belum melakukan presensi masuk.');
        }

        if (!empty($presensiHariIni['jam_pulang'])) {
            return redirect()->to('/presensi')
                ->with('error', 'Kamu sudah melakukan presensi pulang.');
        }

        $foto = $this->request->getFile('foto_pulang');

        $namaFoto = $this->uploadFoto($foto);

        if (!$namaFoto) {
            return redirect()->to('/presensi')
                ->with('error', 'Foto tidak valid. Gunakan JPG, PNG, atau WEBP maksimal 2 MB.');
        }

        $hasil = $this->presensi->update(
            $presensiHariIni['id_presensi'],
            [
                'jam_pulang' => date('H:i:s'),
                'foto_pulang' => $namaFoto
            ]
        );

        if (!$hasil) {
            $path = FCPATH . 'uploads/presensi/' . $namaFoto;

            if (is_file($path)) {
                unlink($path);
            }

            return redirect()->to('/presensi')
                ->with('error', 'Presensi pulang gagal disimpan.');
        }

        return redirect()->to('/presensi')
            ->with('success', 'Presensi pulang berhasil disimpan.');
    }

    // Halaman tambah presensi
    public function create()
    {
        return redirect()->to('/presensi');
    }
}
