
<hr class="sidebar-divider">

<!-- Dashboard -->
<a href="<?= base_url('dashboard-pkl') ?>"
   class="nav-link <?= strpos(uri_string(), 'dashboard-pkl') === 0 ? 'active' : '' ?>">
    <i class="bi bi-speedometer2"></i>
    <span class="nav-text">Dashboard</span>
</a>

<!-- Profil -->
<a href="<?= base_url('users/edit/' . session()->get('id')) ?>"
   class="nav-link <?= strpos(uri_string(), 'users/edit') === 0 ? 'active' : '' ?>">
    <i class="bi bi-person-circle"></i>
    <span class="nav-text">Profil</span>
</a>

<!-- Manajemen Pengguna (Khusus Admin) -->
<?php if (session()->get('role') === 'admin'): ?>

    <hr class="sidebar-divider">

    <a href="<?= base_url('manajemen-pengguna') ?>"
       class="nav-link <?= strpos(uri_string(), 'manajemen-pengguna') === 0 ? 'active' : '' ?>">

        <i class="bi bi-people-fill"></i>
        <span class="nav-text">Manajemen Pengguna</span>

    </a>

<?php endif; ?>

<!-- Data Anggota PKL (Khusus Petugas) -->
<?php if (session()->get('role') === 'petugas'): ?>

    <a href="<?= base_url('users?role=anggota') ?>"
       class="nav-link <?= uri_string() === 'users' ? 'active' : '' ?>">

        <i class="bi bi-people-fill"></i>
        <span class="nav-text">Data Anggota PKL</span>

    </a>

<?php endif; ?>

<!-- Presensi -->
<a href="<?= base_url('presensi') ?>"
   class="nav-link <?= strpos(uri_string(), 'presensi') === 0 ? 'active' : '' ?>">
    <i class="bi bi-calendar-check"></i>
    <span class="nav-text">Presensi PKL</span>
</a>

<!-- Task Management -->
<a href="<?= base_url('task') ?>"
   class="nav-link <?= strpos(uri_string(), 'task') === 0 ? 'active' : '' ?>">
    <i class="bi bi-list-task"></i>
    <span class="nav-text">Task Management</span>
</a>

<!-- Jurnal -->
<a href="<?= base_url('jurnal') ?>"
   class="nav-link <?= strpos(uri_string(), 'jurnal') === 0 ? 'active' : '' ?>">
    <i class="bi bi-journal-text"></i>
    <span class="nav-text">Jurnal Aktivitas</span>
</a>

<!-- Chatroom -->
<a href="<?= base_url('chat') ?>"
   class="nav-link <?= strpos(uri_string(), 'chat') === 0 ? 'active' : '' ?>">
    <i class="bi bi-chat-dots"></i>
    <span class="nav-text">Chatroom</span>
</a>
