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
    $isAjax = $this->request->isAJAX();

    // Fungsi untuk mengirim respons
    $respond = function ($success, $message, $status = 422) use ($isAjax) {
        if ($isAjax) {
            return $this->response
                ->setStatusCode($status)
                ->setJSON([
                    'success' => $success,
                    'message' => $message,
                    'csrfHash' => csrf_hash()
                ]);
        }

        return redirect()->to('/chat')
            ->with($success ? 'success' : 'error', $message);
    };

    if (!$this->request->is('post')) {
        return $respond(false, 'Metode pengiriman tidak diizinkan.', 405);
    }

    $idUser = session()->get('id');

    if (empty($idUser)) {
        return $respond(false, 'Silakan login kembali.', 401);
    }

    $pesan = trim((string) $this->request->getPost('pesan'));
    $file = $this->request->getFile('lampiran');

    $adaFile = $file && $file->getError() !== UPLOAD_ERR_NO_FILE;

    if ($pesan === '' && !$adaFile) {
        return $respond(false, 'Pesan atau lampiran harus diisi.');
    }

    if (mb_strlen($pesan) > 2000) {
        return $respond(false, 'Pesan maksimal 2.000 karakter.');
    }

    $namaFile = null;

    if ($adaFile) {
        $ekstensiDiizinkan = [
            'jpg', 'jpeg', 'png', 'webp',
            'pdf', 'doc', 'docx', 'xls', 'xlsx'
        ];

        if (!$file->isValid()) {
            return $respond(false, 'File gagal diunggah.');
        }

        $ekstensi = strtolower($file->getClientExtension());

        if (!in_array($ekstensi, $ekstensiDiizinkan, true)) {
            return $respond(false, 'Jenis file tidak diizinkan.');
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return $respond(false, 'Ukuran file maksimal 5 MB.');
        }

        $folder = FCPATH . 'uploads/chat';

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $namaFile = $file->getRandomName();

        if (!$file->move($folder, $namaFile)) {
            return $respond(false, 'Gagal menyimpan lampiran.');
        }
    }

    $tersimpan = $this->chat->insert([
        'id_user' => $idUser,
        'pesan' => $pesan,
        'file_lampiran' => $namaFile
    ]);

    if (!$tersimpan) {
        return $respond(false, 'Pesan gagal disimpan.', 500);
    }

    return $respond(true, 'Pesan berhasil dikirim.', 200);
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
