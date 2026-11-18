
<?= $this->extend('layouts/main') ?>

<?= $this->section('pageTitle') ?>
Obrolan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php $idLogin = session()->get('id'); ?>



<style>

/* INFORMASI PENGIRIM */
.chat-name {
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 6px;
    letter-spacing: 0.2px;
}

/* WAKTU PENGIRIMAN */
.chat-time {
    font-size: 10px;
    margin-top: 9px;
    text-align: right;
    opacity: 0.75;
    letter-spacing: 0.2px;
}

/* FOTO PROFIL */
.chat-avatar {
    width: 42px;
    height: 42px;
    min-width: 42px;
    border: 2px solid #ffffff;
    box-shadow: 0 2px 8px rgba(0,0,0,.10);
}

/* JARAK ANTAR PESAN */
.chat-row {
    margin-bottom: 20px;
    animation: munculPesan .25s ease;
}

@keyframes munculPesan {
    from {
        opacity: 0;
        transform: translateY(8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

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
    /* HEADER OBROLAN MODERN */
.obrolan-header {
    background: linear-gradient(135deg, #0d6efd, #084298);
    color: white;
    padding: 22px 25px;
    border-radius: 12px 12px 0 0;
}

.obrolan-header h5 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 5px;
}

.obrolan-header small {
    color: #e4efff;
    font-size: 13px;
}

.obrolan-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,.18);
    border-radius: 12px;
    font-size: 23px;
}

/* PENYEMPURNAAN GELEMBUNG OBROLAN */

.chat-area {
    background: #f5f8ff;
    border: 1px solid #e5ebf5;
    scroll-behavior: smooth;
}

.chat-bubble {
    padding: 12px 16px;
    border-radius: 16px;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07);
    transition: transform 0.2s ease,
                box-shadow 0.2s ease;
}

.chat-bubble:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.10);
}

.chat-row.own .chat-bubble {
    background: linear-gradient(135deg, #0d6efd, #2563eb);
    color: white;
}

.chat-row:not(.own) .chat-bubble {
    background: #ffffff;
    border: 1px solid #edf0f5;
}

.chat-name {
    font-size: 13px;
    font-weight: 700;
}

.chat-time {
    font-size: 10px;
    opacity: 0.7;
}

/* AREA INPUT OBROLAN */
#chatForm {
    margin-top: 18px !important;
}

#chatForm textarea {
    border: 1px solid #dce4f0;
    border-radius: 12px;
    padding: 14px 16px;
    font-size: 14px;
    resize: vertical;
    min-height: 65px;
    background: #ffffff;
    transition: all 0.25s ease;
}

#chatForm textarea:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.10);
    outline: none;
}

/* INPUT LAMPIRAN */
#chatForm input[type="file"] {
    border-radius: 10px;
    border: 1px solid #dce4f0;
    padding: 9px;
    font-size: 12px;
    background: #ffffff;
}

/* TOMBOL KIRIM */
#chatForm button[type="submit"] {
    border: none;
    border-radius: 10px;
    padding: 11px 24px;
    font-weight: 600;
    background: linear-gradient(135deg, #0d6efd, #084298);
    transition: all 0.25s ease;
}

#chatForm button[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 14px rgba(13, 110, 253, 0.25);
}

#chatForm button[type="submit"]:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* TAMPILAN HP */
@media (max-width: 576px) {
    #chatForm button[type="submit"] {
        width: 100%;
    }

    #chatForm input[type="file"] {
        max-width: 100% !important;
        width: 100%;
    }
}

/* STATUS ONLINE DAN OFFLINE */
.status-label {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 10px;
    font-weight: 500;
    margin-left: 6px;
    vertical-align: middle;
}

.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    display: inline-block;
}

.status-dot.online {
    background: #16a34a;
    box-shadow: 0 0 5px rgba(22, 163, 74, .5);
}

.status-dot.offline {
    background: #9ca3af;
}

</style>



<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="obrolan-header">
            <div class="d-flex align-items-center gap-3">

                <div class="obrolan-icon">
                    <i class="bi bi-chat-dots-fill"></i>
                </div>

                <div>
                    <h5>Obrolan Jurnal PKL</h5>
                    <small>
                        Ruang komunikasi Admin, Petugas, dan Anggota PKL
                    </small>
                </div>

            </div>
        </div>

        <div class="card-body">

            <div id="chatMessages" class="chat-area">

                <?php if (!empty($messages)): ?>

                    <?php foreach ($messages as $item): ?>

                        <?php
                            $isOwn = (int) $item['id_user'] === (int) $idLogin;
                            $foto = $item['foto_pengirim'] ?? null;
                            $waktuAktif = !empty($item['terakhir_aktif'])
                                ? strtotime($item['terakhir_aktif'])
                                : 0;

                            $isOnline = $waktuAktif >= (time() - 120);
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

                                    <span class="status-label">
                                        <span class="status-dot <?= $isOnline ? 'online' : 'offline' ?>"></span>
                                        <?= $isOnline ? 'Online' : 'Offline' ?>
                                    </span>
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

            
<form id="chatForm"
      action="<?= base_url('chat/send') ?>"
      method="post"
      enctype="multipart/form-data"
      class="mt-3"
      data-ajax="true">

    <?= csrf_field() ?>

    <div class="mb-2">
        <textarea
        id="pesanChat"
        name="pesan"
        class="form-control"
        placeholder="Tulis obrolan di sini..."
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
        if (newestId <= lastMessageId) return;



        const wasAtBottom =
            chatMessages.scrollHeight -
            chatMessages.scrollTop -
            chatMessages.clientHeight < 100;

        // Memperbarui isi obrolan
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
            const waktuAktif = item.terakhir_aktif
                ? new Date(item.terakhir_aktif.replace(' ', 'T') + '+07:00')
                : null;

            const selisihWaktu = waktuAktif
                ? Date.now() - waktuAktif.getTime()
                : Infinity;

            const isOnline = selisihWaktu >= 0 && selisihWaktu <= 120000;

            const statusHtml = `
                <span class="status-label">
                    <span class="status-dot ${isOnline ? 'online' : 'offline'}"></span>
                    ${isOnline ? 'Online' : 'Offline'}
                </span>
            `;
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
                        ${statusHtml}
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
        console.error('Gagal memperbarui obrolan:', error);
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

// Mengirim pesan tanpa reload halaman
const chatForm = document.getElementById('chatForm');
const tombolKirim = chatForm.querySelector('button[type="submit"]');
const textareaPesan = document.getElementById('pesanChat');

chatForm.addEventListener('submit', async function(event) {
    event.preventDefault();

    if (tombolKirim.disabled) return;

    if (
        textareaPesan.value.trim() === '' &&
        !chatForm.querySelector('[name="lampiran"]').files.length
    ) {
        return;
    }

    const formData = new FormData(chatForm);

    tombolKirim.disabled = true;
    tombolKirim.innerHTML =
        '<span class="spinner-border spinner-border-sm"></span> Mengirim...';

    try {
        const response = await fetch(chatForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Pesan gagal dikirim.');
        }

        // Perbarui token CSRF jika token berubah
        if (result.csrfHash) {
            const csrfInput = chatForm.querySelector(
                'input[name="<?= csrf_token() ?>"]'
            );

            if (csrfInput) {
                csrfInput.value = result.csrfHash;
            }
        }

        // Kosongkan form setelah berhasil
        chatForm.reset();

        // Tampilkan pesan terbaru segera
        await refreshChat();

        scrollChatToBottom();

    } catch (error) {
        alert(error.message || 'Terjadi kesalahan saat mengirim pesan.');
    } finally {
        tombolKirim.disabled = false;
        tombolKirim.innerHTML =
            '<i class="bi bi-send-fill"></i> Kirim';
    }
});


// Kirim pesan dengan tombol Enter
const pesanChat = document.getElementById('pesanChat');

pesanChat.addEventListener('keydown', function(event) {

    // Enter saja untuk mengirim pesan
    if (
        event.key === 'Enter' &&
        !event.shiftKey &&
        !event.isComposing
    ) {
        event.preventDefault();

        const form = pesanChat.closest('form');

        if (form && pesanChat.value.trim() !== '') {
            form.requestSubmit();
        }
    }

});
</script>

<?= $this->endSection() ?>
