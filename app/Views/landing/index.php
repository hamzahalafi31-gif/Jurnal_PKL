
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($judul) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
<style>
    body {
        font-family: Arial, sans-serif;
        background: #EAF2FC;
        color: #252b42;
    }

    /* Navbar */
    .navbar {
        background: #173B75;
        padding: 15px 0;
    }

    .navbar-brand {
        font-size: 22px;
        letter-spacing: 0.5px;
    }

    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, #173B75, #2878D0);
        color: white;
        padding: 90px 20px;
        text-align: center;
    }

    .hero h1 {
        font-size: 42px;
        font-weight: bold;
    }

    .hero p {
        font-size: 18px;
    }

    /* Section */
    .section {
        padding: 55px 0;
    }

    /* Card */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(23, 59, 117, 0.08);
    }

    /* Member Card */
    .member-card {
        padding: 25px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .member-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(23, 59, 117, 0.15);
    }

    .member-icon {
        width: 65px;
        height: 65px;
        margin: auto auto 15px;
        border-radius: 50%;
        background: #EAF2FC;
        color: #2878D0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    /* Button */
    .btn-light {
        color: #173B75;
        font-weight: 600;
    }

    .btn-light:hover {
        background: #EAF2FC;
        color: #173B75;
    }

    /* Footer */
    footer {
        background: #173B75;
        color: white;
        padding: 20px;
        text-align: center;
    }
    
/* ==============================
   ANIMASI LANDING PAGE
============================== */

/* Hero Section */
.hero {
    position: relative;
    overflow: hidden;
}

/* Animasi judul */
.hero h1 {
    animation: fadeUp 0.9s ease-out;
}

/* Animasi deskripsi */
.hero p {
    animation: fadeUp 1.2s ease-out;
}

/* Animasi tombol */
.hero .btn {
    animation: fadeUp 1.5s ease-out;
    transition: all 0.3s ease;
}

/* Efek hover tombol */
.hero .btn:hover {
    transform: translateY(-5px) scale(1.04);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

/* Animasi muncul dari bawah */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Efek hover kartu */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(23, 59, 117, 0.15);
}

/* Navigasi lebih halus */
.navbar {
    transition: all 0.3s ease;
}

/* Menghormati pengaturan minim animasi */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
    }
}


/* ==============================
   HERO DECORATION
============================== */

.hero {
    position: relative;
    overflow: hidden;
    isolation: isolate;
}

/* Lingkaran dekorasi pertama */
.hero::before {
    content: "";
    position: absolute;
    width: 280px;
    height: 280px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    top: -100px;
    left: -70px;
    animation: floating 7s ease-in-out infinite;
    z-index: -1;
}

/* Lingkaran dekorasi kedua */
.hero::after {
    content: "";
    position: absolute;
    width: 350px;
    height: 350px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.07);
    bottom: -180px;
    right: -80px;
    animation: floating 9s ease-in-out infinite reverse;
    z-index: -1;
}

/* Animasi bergerak */
@keyframes floating {
    0%, 100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-25px);
    }
}


/* ==============================
   NAVBAR MODERN
============================== */

.navbar {
    padding: 17px 0;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.12);
}

.navbar-brand {
    font-size: 23px;
    font-weight: bold;
    transition: 0.3s ease;
}

.navbar-brand:hover {
    transform: scale(1.05);
    color: #cfe3ff !important;
}

/* Tombol Navbar */
.navbar .btn {
    border-radius: 8px;
    padding: 9px 20px;
    transition: all 0.3s ease;
}

/* Tombol Login */
.navbar .btn-outline-light:hover {
    background: #ffffff;
    color: #173B75;
    transform: translateY(-3px);
}

/* Tombol Daftar */
.navbar .btn-light:hover {
    background: #dceaff;
    color: #173B75;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
}


/* ==============================
   HERO BUTTON
============================== */

.hero .btn {
    border-radius: 10px;
    padding: 13px 28px;
    font-size: 17px;
    font-weight: bold;
    border: none;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
}

.hero .btn:hover {
    background: #dceaff;
    color: #173B75;
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}


/* ==============================
   PROFILE SECTION
============================== */

.profile-section {
    background: #EAF2FC;
}

.section-label {
    display: inline-block;
    color: #2878D0;
    font-size: 12px;
    font-weight: bold;
    letter-spacing: 2px;
}

.section-heading h2 {
    color: #173B75;
}

.section-heading p {
    font-size: 15px;
}

/* Profile Card */

.profile-card {
    overflow: hidden;
    border-radius: 18px;
    transition: all 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(23, 59, 117, 0.15);
}

/* Profile Header */

.profile-header {
    background: linear-gradient(135deg, #173B75, #2878D0);
    color: white;
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.profile-badge {
    background: rgba(255, 255, 255, 0.18);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    letter-spacing: 1px;
}

.profile-symbol {
    font-size: 55px;
    background: rgba(255, 255, 255, 0.15);
    width: 85px;
    height: 85px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Profile Body */

.profile-body {
    padding: 30px;
}

/* Information Box */

.info-box {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #F5F8FD;
    border: 1px solid #E3ECF8;
    border-radius: 12px;
    padding: 18px;
    height: 100%;
    transition: all 0.3s ease;
}

.info-box:hover {
    background: #EAF2FC;
    border-color: #2878D0;
    transform: translateY(-3px);
}

.info-icon {
    min-width: 45px;
    height: 45px;
    background: #DCEAFF;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.info-box small {
    color: #718096;
    display: block;
    margin-bottom: 5px;
}

.info-box h6 {
    color: #173B75;
    font-weight: bold;
    margin: 0;
}

.profile-description {
    background: #F5F8FD;
    border-left: 4px solid #2878D0;
    padding: 18px;
    border-radius: 8px;
    color: #526078;
}

/* Responsive */

@media (max-width: 576px) {
    .profile-header {
        padding: 22px;
    }

    .profile-symbol {
        width: 60px;
        height: 60px;
        font-size: 35px;
    }

    .profile-body {
        padding: 18px;
    }
}


/* ==============================
   MEMBER SECTION
============================== */

.member-section {
    background: #FFFFFF;
}

.member-section .section-heading h2 {
    color: #173B75;
}

/* Member Card */

.member-card-modern {
    background: #FFFFFF;
    border: 1px solid #E5EDF8;
    border-radius: 18px;
    padding: 30px 20px;
    text-align: center;
    height: 100%;

    box-shadow: 0 5px 18px rgba(23, 59, 117, 0.06);

    opacity: 0;
    animation: memberFadeUp 0.7s ease forwards;
    animation-delay: var(--delay);

    transition: all 0.3s ease;
}

/* Hover Effect */

.member-card-modern:hover {
    transform: translateY(-10px);
    border-color: #2878D0;

    box-shadow: 0 15px 30px rgba(23, 59, 117, 0.13);
}

/* Avatar */

.member-avatar {
    width: 85px;
    height: 85px;

    margin: 0 auto 20px;

    border-radius: 50%;

    background: linear-gradient(
        135deg,
        #173B75,
        #2878D0
    );

    color: #FFFFFF;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 32px;
    font-weight: bold;

    border: 5px solid #EAF2FC;

    transition: all 0.3s ease;
}

.member-card-modern:hover .member-avatar {
    transform: scale(1.1) rotate(5deg);
}

/* Member Information */

.member-info h5 {
    color: #173B75;
    font-weight: bold;
    margin-bottom: 12px;
    overflow-wrap: anywhere;
}

.member-role {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    background: #EAF2FC;
    color: #2878D0;

    padding: 7px 14px;
    border-radius: 20px;

    font-size: 12px;
    font-weight: bold;
}

/* Status Dot */

.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #2878D0;
}

/* Footer Card */

.member-footer {
    border-top: 1px solid #EAF2FC;
    margin-top: 22px;
    padding-top: 15px;

    color: #718096;
    font-size: 12px;
}

/* Empty State */

.empty-member {
    text-align: center;
    padding: 40px;
    background: #F5F8FD;
    border-radius: 15px;
}

.empty-icon {
    font-size: 45px;
    margin-bottom: 15px;
}

/* Animation */

@keyframes memberFadeUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Accessibility */

@media (prefers-reduced-motion: reduce) {
    .member-card-modern {
        opacity: 1;
        animation: none;
        transition: none;
    }
}


/* ==============================
   MODERN FOOTER
============================== */

.main-footer {
    background: linear-gradient(
        135deg,
        #142F60,
        #173B75
    );

    color: #FFFFFF;
    padding: 55px 0 20px;
}

/* Brand */

.footer-brand {
    font-size: 25px;
    font-weight: bold;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

/* Footer Title */

.footer-title {
    font-weight: bold;
    margin-bottom: 15px;
}

/* Description */

.footer-description {
    color: #D5E3F7;
    line-height: 1.8;
    font-size: 14px;
    max-width: 450px;
}

/* Link */

.footer-link {
    color: #FFFFFF;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s ease;
}

.footer-link:hover {
    color: #91C4FF;
    padding-left: 5px;
}

/* Divider */

.footer-divider {
    border-color: rgba(255,255,255,0.2);
    margin: 30px 0 20px;
}

/* Bottom */

.footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    flex-wrap: wrap;

    color: #D5E3F7;
    font-size: 13px;
}

/* Back To Top */

.back-to-top {
    color: #FFFFFF;
    text-decoration: none;
    background: rgba(255,255,255,0.12);
    padding: 10px 16px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.back-to-top:hover {
    background: #FFFFFF;
    color: #173B75;
    transform: translateY(-3px);
}

/* Smooth Scrolling */

html {
    scroll-behavior: smooth;
}

/* Responsive */

@media (max-width: 576px) {
    .footer-bottom {
        flex-direction: column;
        align-items: flex-start;
    }
}

</style>

</head>
<body>

<nav id="top" class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            JURNAL PKL
        </a>

        <div class="ms-auto">
            <a href="<?= base_url('/login') ?>" class="btn btn-outline-light me-2">
                Login
            </a>

            <a href="<?= base_url('/register') ?>" class="btn btn-light">
                Daftar
            </a>
        </div>
    </div>
</nav>

<section class="hero">
    <div class="container">
        <h1>Selamat Datang di Jurnal Kerja PKL</h1>

        <p class="lead mt-3">
            Platform digital untuk mencatat aktivitas,
            presensi, dan perkembangan kegiatan PKL.
        </p>

        <a href="<?= base_url('/login') ?>" class="btn btn-light btn-lg mt-3">
            Mulai Sekarang
        </a>
    </div>
</section>


<section class="section profile-section">
    <div class="container">

        <div class="section-heading text-center mb-5">
            <span class="section-label">INFORMASI PKL</span>
            <h2 class="fw-bold mt-2">Profil Kelompok PKL</h2>
            <p class="text-muted">
                Informasi lengkap mengenai kelompok praktik kerja lapangan.
            </p>
        </div>

        <?php if (!empty($kelompok)): ?>

            <div class="card profile-card">

                <div class="profile-header">
                    <div>
                        <span class="profile-badge">KELOMPOK PKL</span>

                        <h3 class="fw-bold mt-2 mb-1">
                            <?= esc($kelompok['nama_kelompok']) ?>
                        </h3>

                        <p class="mb-0">
                            Kelompok Praktik Kerja Lapangan
                        </p>
                    </div>

                    <div class="profile-symbol">🎓</div>
                </div>

                <div class="profile-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-icon">🏫</div>
                                <div>
                                    <small>Sekolah</small>
                                    <h6>
                                        <?= esc($kelompok['nama_sekolah']) ?>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-icon">🏢</div>
                                <div>
                                    <small>Instansi</small>
                                    <h6>
                                        <?= esc($kelompok['nama_instansi']) ?>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-icon">📍</div>
                                <div>
                                    <small>Alamat Instansi</small>
                                    <h6>
                                        <?= esc($kelompok['alamat_instansi']) ?>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-icon">👨‍🏫</div>
                                <div>
                                    <small>Pembimbing</small>
                                    <h6>
                                        <?= esc($kelompok['nama_pembimbing']) ?>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-box">
                                <div class="info-icon">📅</div>
                                <div>
                                    <small>Periode PKL</small>
                                    <h6>
                                        <?= esc($kelompok['tanggal_mulai']) ?>
                                        s/d
                                        <?= esc($kelompok['tanggal_selesai']) ?>
                                    </h6>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="profile-description mt-4">
                        <?= esc($kelompok['deskripsi']) ?>
                    </div>

                </div>
            </div>

        <?php else: ?>

            <div class="alert alert-warning">
                Data kelompok belum tersedia.
            </div>

        <?php endif; ?>

    </div>
</section>



<section class="section member-section">
    <div class="container">

        <div class="section-heading text-center mb-5">
            <span class="section-label">TIM KAMI</span>

            <h2 class="fw-bold mt-2">
                Anggota Kelompok PKL
            </h2>

            <p class="text-muted">
                Kenali anggota kelompok yang mengikuti kegiatan PKL.
            </p>
        </div>

        <div class="row g-4">

            <?php if (!empty($anggota)): ?>

                <?php foreach ($anggota as $index => $item): ?>

                    <div class="col-12 col-sm-6 col-lg-3">

                        <div class="member-card-modern"
                             style="--delay: <?= $index * 0.12 ?>s">

                            <div class="member-avatar">
                                <?= esc(strtoupper(substr($item['nama'], 0, 1))) ?>
                            </div>

                            <div class="member-info">

                                <h5>
                                    <?= esc($item['nama']) ?>
                                </h5>

                                <span class="member-role">
                                    <span class="status-dot"></span>
                                    Anggota PKL
                                </span>

                            </div>

                            <div class="member-footer">
                                Peserta Praktik Kerja Lapangan
                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-12">
                    <div class="empty-member">
                        <div class="empty-icon">👥</div>

                        <h5>Belum Ada Anggota</h5>

                        <p>
                            Anggota kelompok belum terdaftar.
                        </p>
                    </div>
                </div>

            <?php endif; ?>

        </div>

    </div>
</section>



<footer class="main-footer">

    <div class="container">

        <div class="row g-4">

            <!-- Identitas Aplikasi -->
            <div class="col-md-6">

                <h4 class="footer-brand">
                    JURNAL PKL
                </h4>

                <p class="footer-description">
                    Platform digital untuk membantu siswa
                    mencatat aktivitas, presensi, dan
                    perkembangan kegiatan Praktik Kerja Lapangan.
                </p>

            </div>

            <!-- Informasi -->
            <div class="col-md-6">

                <h5 class="footer-title">
                    Tentang Aplikasi
                </h5>

                <p class="footer-description">
                    Jurnal Kerja PKL merupakan aplikasi
                    pencatatan kegiatan praktik kerja lapangan
                    secara digital dan terstruktur.
                </p>

                <a href="<?= base_url('/') ?>" class="footer-link">
                    Halaman Utama
                </a>

            </div>

        </div>

        <hr class="footer-divider">

        <div class="footer-bottom">

            <p class="mb-0">
                &copy; <?= date('Y') ?> Jurnal Kerja PKL.
                Dibuat oleh Kelompok PKL.
            </p>

            <a href="#top" class="back-to-top">
                ↑ Kembali ke Atas
            </a>

        </div>

    </div>

</footer>


</body>
</html>
