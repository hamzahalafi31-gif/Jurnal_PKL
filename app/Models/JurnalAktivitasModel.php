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
    
    // Mengambil data dan ringkasan rekap jurnal
    public function getRekap($idUser = null, $tanggalMulai = null, $tanggalSelesai = null)
    {
        $builder = $this->db->table('jurnal_aktivitas');

        $builder->select('
            jurnal_aktivitas.*,
            users.nama AS nama_user
        ');

        $builder->join(
            'users',
            'users.id = jurnal_aktivitas.id_user'
        );

        // Filter berdasarkan pengguna jika diperlukan
        if ($idUser !== null) {
            $builder->where('jurnal_aktivitas.id_user', $idUser);
        }

        // Filter tanggal mulai
        if (!empty($tanggalMulai)) {
            $builder->where('jurnal_aktivitas.tanggal >=', $tanggalMulai);
        }

        // Filter tanggal selesai
        if (!empty($tanggalSelesai)) {
            $builder->where('jurnal_aktivitas.tanggal <=', $tanggalSelesai);
        }

        $builder->orderBy('jurnal_aktivitas.tanggal', 'DESC');

        $data = $builder->get()->getResultArray();

        return [
            'data'       => $data,
            'total'      => count($data),
            'menunggu'   => count(array_filter($data, fn($item) => $item['status'] === 'menunggu')),
            'disetujui'  => count(array_filter($data, fn($item) => $item['status'] === 'disetujui')),
            'ditolak'    => count(array_filter($data, fn($item) => $item['status'] === 'ditolak')),
        ];
    }

}