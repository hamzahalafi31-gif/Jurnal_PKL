<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokModel extends Model
{
    protected $table = 'kelompok';
    protected $primaryKey = 'id_kelompok';

    protected $allowedFields = [
        'nama_kelompok',
        'nama_sekolah',
        'nama_instansi',
        'alamat_instansi',
        'nama_pembimbing',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi'
    ];

    protected $returnType = 'array';
}
