<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id_task';

    protected $allowedFields = [
    'id_pembuat',
    'id_penanggung_jawab',
    'judul',
    'deskripsi',
    'prioritas',
    'status',
    'tanggal_mulai',
    'deadline',
    'hasil_pengerjaan',
    'file_hasil',
    'catatan_revisi'
];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Mengambil seluruh tugas
    public function getAllTasks()
    {
        return $this->select('
                tasks.*,
                pembuat.nama AS nama_pembuat,
                penanggung_jawab.nama AS nama_penanggung_jawab
            ')
            ->join(
                'users AS pembuat',
                'pembuat.id = tasks.id_pembuat'
            )
            ->join(
                'users AS penanggung_jawab',
                'penanggung_jawab.id = tasks.id_penanggung_jawab',
                'left'
            )
            ->orderBy('tasks.created_at', 'DESC')
            ->findAll();
    }

    // Mengambil tugas berdasarkan pengguna
    public function getByUser($idUser)
    {
        return $this->groupStart()
                    ->where('id_pembuat', $idUser)
                    ->orWhere('id_penanggung_jawab', $idUser)
                    ->groupEnd()
                    ->orderBy('deadline', 'ASC')
                    ->findAll();
    }
    // Mengambil detail tugas berdasarkan ID
public function getDetailTask($idTask)
{
    return $this->select('
            tasks.*,
            pembuat.nama AS nama_pembuat,
            penanggung_jawab.nama AS nama_penanggung_jawab
        ')
        ->join(
            'users AS pembuat',
            'pembuat.id = tasks.id_pembuat',
            'left'
        )
        ->join(
            'users AS penanggung_jawab',
            'penanggung_jawab.id = tasks.id_penanggung_jawab',
            'left'
        )
        ->where('tasks.id_task', $idTask)
        ->first();
}
}
