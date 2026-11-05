
<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table = 'presensi';
    protected $primaryKey = 'id_presensi';

    protected $allowedFields = [
        'id_user',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'foto_masuk',
        'foto_pulang',
        'status',
        'keterangan'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Mengambil presensi berdasarkan ID pengguna
    public function getByUser($idUser)
    {
        return $this->where('id_user', $idUser)
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }

    // Mengambil presensi berdasarkan tanggal
    public function getByTanggal($tanggal)
    {
        return $this->where('tanggal', $tanggal)
                    ->findAll();
    }

    // Memeriksa apakah pengguna sudah presensi hari ini
    public function getPresensiHariIni($idUser)
    {
        return $this->where('id_user', $idUser)
                    ->where('tanggal', date('Y-m-d'))
                    ->first();
    }
}
