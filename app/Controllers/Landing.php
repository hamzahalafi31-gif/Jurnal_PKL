<?php

namespace App\Controllers;

use App\Models\KelompokModel;
use App\Models\UsersModel;

class Landing extends BaseController
{
    public function index()
    {
        $kelompokModel = new KelompokModel();
        $usersModel = new UsersModel();

        // Mengambil data kelompok PKL
        $kelompok = $kelompokModel->first();

        // Mengambil anggota kelompok
        $anggota = $usersModel
            ->where('role', 'anggota')
            ->where('status', 'aktif')
            ->findAll();

        $data = [
            'judul'   => 'Jurnal Kerja PKL',
            'kelompok' => $kelompok,
            'anggota'  => $anggota,
        ];

        return view('landing/index', $data);
    }
}
