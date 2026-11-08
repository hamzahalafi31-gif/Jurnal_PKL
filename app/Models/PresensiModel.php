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

    // Memeriksa presensi hari ini
    public function getPresensiHariIni($idUser)
    {
        return $this->where('id_user', $idUser)
                    ->where('tanggal', date('Y-m-d'))
                    ->first();
    }

    // Mengambil seluruh presensi beserta nama anggota
    public function getSemuaPresensi($tanggal = null, $keyword = null)
    {
        $builder = $this->db->table('presensi p');

        $builder->select('
            p.*,
            users.nama AS nama_anggota,
            users.username AS username_anggota
        ');

        $builder->join(
            'users',
            'users.id = p.id_user',
            'left'
        );

        // Filter tanggal
        if (!empty($tanggal)) {
            $builder->where('p.tanggal', $tanggal);
        }

        // Pencarian nama atau username
        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('users.nama', $keyword)
                    ->orLike('users.username', $keyword)
                    ->groupEnd();
        }

        $builder->orderBy('p.tanggal', 'DESC');
        $builder->orderBy('p.jam_masuk', 'DESC');

        return $builder->get()->getResultArray();
    }
}
