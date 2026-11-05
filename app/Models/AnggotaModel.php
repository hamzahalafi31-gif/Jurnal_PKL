<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota_kelompok';
    protected $primaryKey = 'id_anggota_kelompok';

    protected $allowedFields = [
        'id_user',
        'id_kelompok',
        'tanggal_bergabung'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Mengambil kelompok berdasarkan ID pengguna
    public function getByUserId($idUser)
    {
        return $this->where('id_user', $idUser)->first();
    }

    // Mengambil seluruh anggota beserta nama pengguna
    public function getAllWithUser()
    {
        return $this->select('
                anggota_kelompok.*,
                users.nama
            ')
            ->join(
                'users',
                'users.id = anggota_kelompok.id_user'
            )
            ->findAll();
    }
}
