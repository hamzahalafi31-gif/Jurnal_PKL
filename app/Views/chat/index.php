
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Chatroom
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $idLogin = session()->get('id'); ?>



<style>
    .chat-area {
        height: 480px;
        overflow-y: auto;
        background: #f3f6fb;
        padding: 20px;
        border-radius: 10px;
    }

    .chat-row {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        margin-bottom: 16px;
        min-width: 0;
    }

    .chat-row.own {
        flex-direction: row-reverse;
    }

    .chat-avatar {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 50%;
        object-fit: cover;
        background: #dce5f5;
    }

    .chat-bubble {
    display: block;
    flex: 0 1 auto;
    width: fit-content;
    max-width: min(75%, 350px);
    height: fit-content;
    padding: 10px 14px;
    border-radius: 14px;
    background: white;
    box-shadow: 0 2px 5px rgba(0,0,0,.06);
    overflow-wrap: anywhere;
}

    .chat-row.own .chat-bubble {
        background: #0d6efd;
        color: white;
        border-bottom-right-radius: 3px;
    }

    .chat-row:not(.own) .chat-bubble {
        border-bottom-left-radius: 3px;
    }

    .chat-bubble .chat-image {
    display: block;
    width: 260px;
    max-width: 100%;
    height: auto;
    max-height: 260px;
    object-fit: contain;
    border-radius: 10px;
}

    .chat-name {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #0d6efd;
    }

    .chat-row.own .chat-name {
        color: #e8f1ff;
    }

    .chat-time {
        font-size: 10px;
        text-align: right;
        margin-top: 8px;
        opacity: .75;
    }

    @media (max-width: 576px) {
        .chat-area {
            padding: 12px;
        }

        .chat-bubble {
            max-width: 85%;
        }

        .chat-bubble img {
            width: 180px;
            max-height: 180px;
        }
    }
</style>



<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-1">
                <i class="bi bi-chat-dots"></i>
                Chatroom Jurnal PKL
            </h5>
            <small>Ruang komunikasi Admin, Petugas, dan Anggota PKL</small>
        </div>

        <div class="card-body">

            <div id="chatMessages" class="chat-area">

                <?php if (!empty($messages)): ?>

                    <?php foreach ($messages as $item): ?>

                        <?php
                            $isOwn = (int) $item['id_user'] === (int) $idLogin;
                            $foto = $item['foto_pengirim'] ?? null;
                        ?>

                        <div class="chat-row <?= $isOwn ? 'own' : '' ?>">

                            <?php if (!empty($foto)): ?>
                                <img
                                    src="<?= base_url('uploads/users/' . rawurlencode(basename($foto))) ?>"
                                    class="chat-avatar"
                                    alt="Foto profil">
                            <?php else: ?>
                                <div class="chat-avatar d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-fill text-secondary fs-4"></i>
                                </div>
                            <?php endif; ?>

                            <div class="chat-bubble">

                                <div class="chat-name">
                                    <?= esc($item['nama_pengirim']) ?>
                                    <?= $isOwn ? '(Anda)' : '' ?>
                                </div>

                                
<div style="white-space: pre-wrap;"><?= esc($item['pesan']) ?></div>

<?php if (!empty($item['file_lampiran'])): ?>
    <?php
        $namaFile = basename($item['file_lampiran']);
        $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        $urlFile = base_url('uploads/chat/' . rawurlencode($namaFile));
        $jenisGambar = ['jpg', 'jpeg', 'png', 'webp'];
    ?>

    <div class="mt-2">
        <?php if (in_array($ekstensi, $jenisGambar, true)): ?>
            <a href="<?= esc($urlFile) ?>" target="_blank">
                <img src="<?= esc($urlFile) ?>"
                     alt="Lampiran gambar"
                     class="chat-image">
            </a>
        <?php else: ?>
            <i class="bi bi-paperclip"></i>
            <a href="<?= esc($urlFile) ?>"
               target="_blank"
               rel="noopener noreferrer">
                Lihat lampiran
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
                                <div class="chat-time">
                                    <?= esc(date('d-m-Y H:i', strtotime($item['created_at']))) ?>
                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="text-center text-muted mt-5">
                        <i class="bi bi-chat-square-text" style="font-size: 45px;"></i>
                        <p class="mt-3">Belum ada pesan.</p>
                        <small>Jadilah orang pertama yang mengirim pesan!</small>
                    </div>

                <?php endif; ?>

            </div>

            
<form action="<?= base_url('chat/send') ?>"
      method="post"
      enctype="multipart/form-data"
      class="mt-3">

    <?= csrf_field() ?>

    <div class="mb-2">
        <textarea
            name="pesan"
            class="form-control"
            placeholder="Tulis pesan di sini..."
            rows="2"
            maxlength="2000"></textarea>
    </div>

    <div class="d-flex flex-wrap gap-2 align-items-center">
        <input
            type="file"
            name="lampiran"
            class="form-control"
            accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.xls,.xlsx"
            style="max-width: 350px;">

        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-send-fill"></i> Kirim
        </button>
    </div>

</form>

<small class="text-muted">
    Lampiran: JPG, PNG, WEBP, PDF, Word, atau Excel. Maksimal 5 MB.
</small>


            <small class="text-muted">
                Maksimal 2.000 karakter per pesan.
            </small>

        </div>
    </div>
</div>

<script>
    
const chatMessages = document.getElementById('chatMessages');

let lastMessageId = <?= !empty($messages)
    ? (int) end($messages)['id_chat']
    : 0 ?>;

function scrollChatToBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Posisi awal
scrollChatToBottom();

// Mengambil pesan terbaru setiap 3 detik
async function refreshChat() {
    try {
        const response = await fetch(
            '<?= base_url('chat/messages') ?>',
            {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        );

        if (!response.ok) return;

        const result = await response.json();

        if (!result.messages) return;

        const messages = result.messages;

        if (messages.length === 0) return;

        const newestId = Math.max(
            ...messages.map(item => Number(item.id_chat))
        );

        // Tidak memperbarui jika belum ada pesan baru
        if (newestId <= lastMessageId) return;

        const wasAtBottom =
            chatMessages.scrollHeight -
            chatMessages.scrollTop -
            chatMessages.clientHeight < 100;

        // Memperbarui isi percakapan
        chatMessages.innerHTML = messages.map(item => {
            const own = Number(item.id_user) === <?= (int) session()->get('id') ?>;

            const foto = item.foto_pengirim
                ? '<?= base_url('uploads/users/') ?>' +
                  encodeURIComponent(
                      item.foto_pengirim.split('/').pop().split('\\').pop()
                  )
                : null;

            const avatar = foto
                ? `<img src="${foto}" class="chat-avatar" alt="Foto profil">`
                : `<div class="chat-avatar d-flex align-items-center justify-content-center">
                       <i class="bi bi-person-fill text-secondary fs-4"></i>
                   </div>`;

            const safeName = escapeHtml(item.nama_pengirim);
            const safeMessage = escapeHtml(item.pesan);
            const fileName = item.file_lampiran
    ? item.file_lampiran.split('/').pop().split('\\').pop()
    : '';

const extension = fileName.includes('.')
    ? fileName.split('.').pop().toLowerCase()
    : '';

const imageExtensions = ['jpg', 'jpeg', 'png', 'webp'];

const fileUrl = `<?= base_url('uploads/chat/') ?>${encodeURIComponent(fileName)}`;

const attachment = fileName
    ? (imageExtensions.includes(extension)
        ? `<div class="mt-3">
            <a href="${fileUrl}" target="_blank">
                <img src="${fileUrl}"
                     alt="Lampiran gambar"
                     style="max-width:100%; max-height:300px;
                            border-radius:10px; object-fit:contain;">
            </a>
           </div>`
        : `<div class="mt-3">
            <i class="bi bi-paperclip"></i>
            <a href="${fileUrl}" target="_blank"
               rel="noopener noreferrer">
                Lihat lampiran
            </a>
           </div>`)
    : '';
               

            const date = new Date(
                item.created_at.replace(' ', 'T')
            );

            const time = date.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            return `
                <div class="chat-row ${own ? 'own' : ''}">
                    ${avatar}
                    <div class="chat-bubble">
                        <div class="chat-name">
                            ${safeName} ${own ? '(Anda)' : ''}
                        </div>
                        <div style="white-space: pre-wrap;">${safeMessage}</div>
                    ${attachment}
                    <div class="chat-time">${time}</div>
                    </div>
                </div>
            `;
        }).join('');

        lastMessageId = newestId;

        if (wasAtBottom) {
            scrollChatToBottom();
        }

    } catch (error) {
        console.error('Gagal memperbarui chat:', error);
    }
}

// Mengamankan teks pesan sebelum ditampilkan
function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[char]);
}

setInterval(refreshChat, 3000);

</script>

<?= $this->endSection() ?>
