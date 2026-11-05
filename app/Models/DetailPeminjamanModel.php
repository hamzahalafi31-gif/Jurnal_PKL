<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPeminjamanModel extends Model
{
    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_detail';

    protected $allowedFields = [
        'id_peminjaman',
        'id_buku',
        'jumlah'
    ];

    protected $useTimestamps = false;

    /**
     * Mengambil semua buku berdasarkan ID peminjaman.
     */
    public function getByPeminjaman($idPeminjaman)
    {
        return $this->where('id_peminjaman', $idPeminjaman)
                    ->findAll();
    }

    /**
     * Mengambil daftar ID buku berdasarkan ID peminjaman.
     */
    public function getBukuIds($idPeminjaman): array
    {
        $details = $this->select('id_buku')
                        ->where('id_peminjaman', $idPeminjaman)
                        ->findAll();

        return array_values(array_unique(array_map(
            'intval',
            array_column($details, 'id_buku')
        )));
    }

    /**
     * Mengganti daftar buku dalam satu peminjaman.
     * Panggil fungsi ini di dalam transaksi database.
     */
    public function replaceDetails($idPeminjaman, array $idBuku): bool
    {
        $idBuku = array_values(array_unique(array_filter(
            array_map('intval', $idBuku),
            static fn($id) => $id > 0
        )));

        if (empty($idBuku)) {
            return false;
        }

        $this->where('id_peminjaman', $idPeminjaman)->delete();

        $data = [];

        foreach ($idBuku as $id) {
            $data[] = [
                'id_peminjaman' => $idPeminjaman,
                'id_buku'       => $id,
                'jumlah'        => 1
            ];
        }

        return $this->insertBatch($data) !== false;
    }
}
