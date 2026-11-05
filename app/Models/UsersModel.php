<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama',
        'email',
        'username',
        'password',
        'role',
        'foto',
        'status'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Mengambil pengguna berdasarkan username
    public function getUsersByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    // Mengambil seluruh pengguna aktif
    public function getUsersAktif()
    {
        return $this->where('status', 'aktif')
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }
}
