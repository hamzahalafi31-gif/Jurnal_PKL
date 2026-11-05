<?php

namespace App\Models;

use CodeIgniter\Model;

class JurnalAktivitasModel extends Model
{
    protected $table = 'jurnal_aktivitas';
    protected $primaryKey = 'id_jurnal';

    protected $allowedFields = [
        'id_user',
        'tanggal',
        'judul_kegiatan',
        'deskripsi_kegiatan',
        'jam_mulai',
        'jam_selesai',
        'status',
        'catatan_pembimbing'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Menampilkan jurnal milik pengguna tertentu
    public function getByUser($idUser)
    {
        return $this->where('id_user', $idUser)
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }

    // Menampilkan seluruh jurnal beserta nama pengguna
    public function getAllWithUser()
    {
        return $this->select('
                jurnal_aktivitas.*,
                users.nama AS nama_user
            ')
            ->join(
                'users',
                'users.id = jurnal_aktivitas.id_user'
            )
            ->orderBy('jurnal_aktivitas.tanggal', 'DESC')
            ->findAll();
    }
}