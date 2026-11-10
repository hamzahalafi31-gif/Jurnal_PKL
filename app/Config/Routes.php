<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Variabel Filter
$authFilter = ['filter' => 'auth'];

// Variabel Role
$admin     = ['filter' => 'role:admin'];
$petugas   = ['filter' => 'role:petugas'];
$anggota   = ['filter' => 'role:anggota'];
$allRole   = ['filter' => 'role:admin, petugas, anggota'];
$adminPetugas = ['filter' => 'role:admin,petugas'];

// Login
$routes->get('/login', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');

// Register
$routes->get('/register', 'Auth::register');
$routes->post('/register/store', 'Auth::store');

// Landing Page
$routes->get('/', 'Landing::index');

// Dashboard Jurnal PKL
$routes->get('/dashboard', 'DashboardPkl::index', $authFilter);
$routes->get('/dashboard-pkl', 'DashboardPkl::index', $authFilter);

// ========================================
// FITUR JURNAL PKL
// ========================================

// Presensi
$routes->group('presensi', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Presensi::index');
    $routes->get('create', 'Presensi::create');
    $routes->post('store', 'Presensi::store');
    $routes->post('pulang', 'Presensi::pulang');
});

// Rekap Presensi khusus Admin dan Petugas
$routes->get('/presensi/rekap', 'Presensi::rekap', $adminPetugas);


// Task Management
$routes->group('task', ['filter' => 'auth'], function ($routes) {

    // Daftar dan detail tugas
    $routes->get('/', 'Task::index');
    $routes->get('detail/(:num)', 'Task::detail/$1');

    // Membuat tugas
    $routes->get('create', 'Task::create');
    $routes->post('store', 'Task::store');

    // Mengedit dan menghapus tugas
    $routes->get('edit/(:num)', 'Task::edit/$1');
    $routes->post('update/(:num)', 'Task::update/$1');
    $routes->post('delete/(:num)', 'Task::delete/$1');

    // Anggota mengirim hasil pengerjaan
    $routes->post('kirim-hasil/(:num)', 'Task::kirimHasil/$1');

    // Admin/Petugas memeriksa hasil pengerjaan
    $routes->post('review/(:num)', 'Task::review/$1');
});


// Jurnal Aktivitas
$routes->group('jurnal', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Jurnal::index');
    $routes->get('rekap', 'Jurnal::rekap');
    $routes->get('create', 'Jurnal::create');
    $routes->post('store', 'Jurnal::store');
    $routes->get('detail/(:num)', 'Jurnal::detail/$1');
    $routes->get('edit/(:num)', 'Jurnal::edit/$1');
    $routes->post('update/(:num)', 'Jurnal::update/$1');
    $routes->get('delete/(:num)', 'Jurnal::delete/$1');
    
    // Persetujuan jurnal oleh admin/petugas
    $routes->post('setujui/(:num)', 'Jurnal::setujui/$1');
    $routes->post('tolak/(:num)', 'Jurnal::tolak/$1');

});

// Chatroom
$routes->group('chat', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Chat::index');
    $routes->post('send', 'Chat::send');
    $routes->get('messages', 'Chat::messages');
});
// Halaman User
$routes->get('/users/create', 'Users::create'); // form tambah user
$routes->post('/users/store', 'Users::store'); // aksi simpan user
$routes->get('/users', 'Users::index', $allRole); // menampilkan data user hanya untuk admin dan petugas
$routes->get('/users/edit/(:num)', 'Users::edit/$1', $allRole); // form edit user
$routes->post('/users/update/(:num)', 'Users::update/$1', $allRole); // aksi update user
$routes->get('/users/delete/(:num)', 'Users::delete/$1', $allRole); // aksi hapus user
$routes->get('users/detail/(:num)', 'Users::detail/$1', $allRole); // aksi detail user
$routes->get('users/print', 'Users::print', $allRole); // aksi print data user
$routes->get('users/wa/(:num)', 'Users::wa/$1', $allRole); // aksi kirim ke whatsapp


// Kelola data Rak
$routes->get('/rak', 'Rak::index');
$routes->get('/rak/create', 'Rak::create');
$routes->post('/rak/store', 'Rak::store');
$routes->get('/rak/detail/(:num)', 'Rak::detail/$1');
$routes->get('/rak/edit/(:num)', 'Rak::edit/$1');
$routes->post('/rak/update/(:num)', 'Rak::update/$1');
$routes->get('/rak/delete/(:num)', 'Rak::delete/$1');
$routes->get('/rak/print', 'Rak::print');

// Kelola data kategori
$routes->get('/kategori', 'Kategori::index');
$routes->get('/kategori/create', 'Kategori::create');
$routes->post('/kategori/store', 'Kategori::store');
$routes->get('/kategori/detail/(:num)', 'Kategori::detail/$1');
$routes->get('/kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('/kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('/kategori/delete/(:num)', 'Kategori::delete/$1');
$routes->get('/kategori/print', 'Kategori::print');

// Kelola data Penulis
$routes->get('/penulis', 'Penulis::index');
$routes->get('/penulis/create', 'Penulis::create');
$routes->post('/penulis/store', 'Penulis::store');
$routes->get('/penulis/detail/(:num)', 'Penulis::detail/$1');
$routes->get('/penulis/edit/(:num)', 'Penulis::edit/$1');
$routes->post('/penulis/update/(:num)', 'Penulis::update/$1');
$routes->get('/penulis/delete/(:num)', 'Penulis::delete/$1');
$routes->get('/penulis/print', 'Penulis::print');

// Kelola data Penerbit
$routes->get('/penerbit', 'Penerbit::index');
$routes->get('/penerbit/create', 'Penerbit::create');
$routes->post('/penerbit/store', 'Penerbit::store');
$routes->get('/penerbit/detail/(:num)', 'Penerbit::detail/$1');
$routes->get('/penerbit/edit/(:num)', 'Penerbit::edit/$1');
$routes->post('/penerbit/update/(:num)', 'Penerbit::update/$1');
$routes->get('/penerbit/delete/(:num)', 'Penerbit::delete/$1');
$routes->get('/penerbit/print', 'Penerbit::print');

// Peminjaman
$routes->get('/peminjaman', 'Peminjaman::index', $allRole);
$routes->get('/peminjaman/create', 'Peminjaman::create', $allRole);
$routes->post('/peminjaman/store', 'Peminjaman::store', $allRole);
$routes->get('/peminjaman/detail/(:num)', 'Peminjaman::detail/$1', $allRole);
$routes->get('/peminjaman/edit/(:num)', 'Peminjaman::edit/$1', $allRole);
$routes->post('/peminjaman/update/(:num)', 'Peminjaman::update/$1', $allRole);
$routes->get('/peminjaman/delete/(:num)', 'Peminjaman::delete/$1', $allRole);
$routes->get('/peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1', $allRole);
$routes->get('/peminjaman/konfirmasi/(:num)', 'Peminjaman::konfirmasi/$1', $allRole);
$routes->get('/peminjaman/tolak/(:num)', 'Peminjaman::tolak/$1', $allRole);
$routes->get('/peminjaman/print', 'Peminjaman::print', $allRole);

/// Manajemen Pengguna (Khusus Admin)
$routes->group('manajemen-pengguna', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ManajemenPengguna::index', ['filter' => 'role:admin']);
    $routes->get('tambah', 'ManajemenPengguna::tambah', ['filter' => 'role:admin']);
    $routes->post('simpan', 'ManajemenPengguna::simpan', ['filter' => 'role:admin']);

    // Edit dan Update Pengguna
    $routes->get('edit/(:num)', 'ManajemenPengguna::edit/$1', ['filter' => 'role:admin']);
    $routes->post('update/(:num)', 'ManajemenPengguna::update/$1', ['filter' => 'role:admin']);
});
