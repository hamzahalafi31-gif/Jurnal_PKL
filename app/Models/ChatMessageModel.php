<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatMessageModel extends Model
{
    protected $table = 'chat_messages';
    protected $primaryKey = 'id_chat';

    protected $allowedFields = [
        'id_user',
        'pesan',
        'file_lampiran'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Mengambil seluruh pesan beserta nama pengirim
    
public function getAllWithUser()
{
    return $this->select('
            chat_messages.*,
            users.nama AS nama_pengirim,
            users.foto AS foto_pengirim,
            users.last_seen_at AS terakhir_aktif
        ')
        ->join(
            'users',
            'users.id = chat_messages.id_user'
        )
        ->orderBy('chat_messages.created_at', 'ASC')
        ->findAll();
}

}