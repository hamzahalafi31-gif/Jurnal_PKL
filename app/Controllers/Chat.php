<?php

namespace App\Controllers;

use App\Models\ChatMessageModel;

class Chat extends BaseController
{
    protected $chat;

    public function __construct()
    {
        $this->chat = new ChatMessageModel();
    }

    // Menampilkan halaman Chatroom
    public function index()
    {
        $messages = $this->chat->getAllWithUser();

        return view('chat/index', [
            'messages' => $messages
        ]);
    }

    // Mengirim pesan
    
public function send()
{
    if (!$this->request->is('post')) {
        return redirect()->to('/chat');
    }

    $pesan = trim((string) $this->request->getPost('pesan'));
    $file = $this->request->getFile('lampiran');

    $adaFile = $file && $file->getError() !== UPLOAD_ERR_NO_FILE;

    if ($pesan === '' && !$adaFile) {
        return redirect()->to('/chat')
            ->with('error', 'Pesan atau lampiran harus diisi.');
    }

    if (mb_strlen($pesan) > 2000) {
        return redirect()->to('/chat')
            ->with('error', 'Pesan maksimal 2.000 karakter.');
    }

    $namaFile = null;

    if ($adaFile) {
        $ekstensiDiizinkan = [
            'jpg', 'jpeg', 'png', 'webp',
            'pdf', 'doc', 'docx', 'xls', 'xlsx'
        ];

        if (!$file->isValid()) {
            return redirect()->to('/chat')
                ->with('error', 'File gagal diunggah.');
        }

        $ekstensi = strtolower($file->getClientExtension());

        if (!in_array($ekstensi, $ekstensiDiizinkan, true)) {
            return redirect()->to('/chat')
                ->with('error', 'Jenis file tidak diizinkan.');
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return redirect()->to('/chat')
                ->with('error', 'Ukuran file maksimal 5 MB.');
        }

        $folder = FCPATH . 'uploads/chat';

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $namaFile = $file->getRandomName();

        if (!$file->move($folder, $namaFile)) {
            return redirect()->to('/chat')
                ->with('error', 'Gagal menyimpan lampiran.');
        }
    }

    $idUser = session()->get('id');

    if (empty($idUser)) {
        return redirect()->to('/login');
    }

    $this->chat->insert([
        'id_user' => $idUser,
        'pesan' => $pesan,
        'file_lampiran' => $namaFile
    ]);

    return redirect()->to('/chat')
        ->with('success', 'Pesan berhasil dikirim.');
}

    // Mengambil pesan terbaru untuk auto-refresh
public function messages()
{
    $messages = $this->chat->getAllWithUser();

    return $this->response->setJSON([
        'messages' => $messages
    ]);
}
}
