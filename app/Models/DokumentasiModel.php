<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumentasiModel extends Model
{
    protected $table = 'dokumentasi';
    protected $primaryKey = 'id_dokumentasi';

    protected $allowedFields = [
        'id_jurnal',
        'nama_file',
        'keterangan'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Mengambil dokumentasi berdasarkan jurnal
    public function getByJurnal($idJurnal)
    {
        return $this->where('id_jurnal', $idJurnal)
                    ->orderBy('uploaded_at', 'DESC')
                    ->findAll();
    }
}