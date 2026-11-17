<?php

namespace App\Models;

use CodeIgniter\Model;

class JurnalFotoModel extends Model
{
    protected $table = 'jurnal_foto';
    protected $primaryKey = 'id_foto';

    protected $allowedFields = [
        'id_jurnal',
        'nama_foto'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Mengambil semua foto berdasarkan ID jurnal
    public function getByJurnal($idJurnal)
    {
        return $this->where('id_jurnal', $idJurnal)
                    ->orderBy('id_foto', 'ASC')
                    ->findAll();
    }
}
