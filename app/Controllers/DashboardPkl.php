<?php

namespace App\Controllers;

class DashboardPkl extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        $db = \Config\Database::connect();

        switch ($role) {

            // =====================================
            // DASHBOARD ADMIN
            // =====================================
            case 'admin':

                $data = [
    'totalPengguna' => $db->table('users')->countAll(),

    'totalAdmin' => $db->table('users')
        ->where('role', 'admin')
        ->countAllResults(),

    'totalPetugas' => $db->table('users')
        ->where('role', 'petugas')
        ->countAllResults(),

    'totalAnggota' => $db->table('users')
        ->where('role', 'anggota')
        ->countAllResults(),

    'totalPembimbing' => $db->table('users')
        ->where('role', 'pembimbing')
        ->countAllResults(),

    'totalDataAnggotaPkl' => $db->table('users')
    ->where('role', 'anggota')
    ->countAllResults(),
];

                return view('jurnalpkl/dashboard/admin', $data);


            // =====================================
            // DASHBOARD PETUGAS
            // =====================================
            case 'petugas':

                $tanggalHariIni = date('Y-m-d');

                $data = [

                    // Total anggota PKL
                    'totalAnggota' => $db->table('users')
                        ->where('role', 'anggota')
                        ->countAllResults(),

                    // Anggota yang hadir hari ini
                    'hadirHariIni' => $db->table('presensi')
                        ->where('tanggal', $tanggalHariIni)
                        ->where('status', 'hadir')
                        ->countAllResults(),

                    // Jurnal yang menunggu persetujuan
                    'jurnalMenunggu' => $db->table('jurnal_aktivitas')
                        ->where('status', 'menunggu')
                        ->countAllResults(),

                    // Tugas yang sedang dikerjakan
                    'tugasBerjalan' => $db->table('tasks')
                        ->where('status', 'dikerjakan')
                        ->countAllResults(),
                ];

                return view('jurnalpkl/dashboard/petugas', $data);


            // =====================================
            // DASHBOARD ANGGOTA
            // =====================================
            case 'anggota':

                return view('jurnalpkl/dashboard/anggota');


            // =====================================
            // DASHBOARD PEMBIMBING
            // =====================================
            case 'pembimbing':

                return view('jurnalpkl/dashboard/pembimbing');


            // =====================================
            // ROLE TIDAK DIKENALI
            // =====================================
            default:

                return redirect()->to('/login')
                    ->with('error', 'Role pengguna tidak dikenali.');
        }
    }
}
