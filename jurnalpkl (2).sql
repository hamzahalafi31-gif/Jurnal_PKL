-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Nov 2026 pada 07.12
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jurnalpkl`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota_kelompok`
--

CREATE TABLE `anggota_kelompok` (
  `id_anggota_kelompok` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kelompok` int(11) NOT NULL,
  `tanggal_bergabung` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota_kelompok`
--

INSERT INTO `anggota_kelompok` (`id_anggota_kelompok`, `id_user`, `id_kelompok`, `tanggal_bergabung`) VALUES
(1, 1, 1, '2026-11-05'),
(2, 2, 1, '2026-11-08'),
(3, 3, 1, '2026-11-08'),
(4, 6, 1, '2026-11-12'),
(5, 7, 1, '2026-11-12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id_chat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `file_lampiran` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `chat_messages`
--

INSERT INTO `chat_messages` (`id_chat`, `id_user`, `pesan`, `file_lampiran`, `created_at`) VALUES
(1, 2, 'Halo, selamat datang di Chatroom Jurnal PKL!', NULL, '2026-11-09 22:36:14'),
(2, 3, 'halo Juga', NULL, '2026-11-09 22:44:38'),
(3, 2, '', '1794293686_d44437d3e9950de19c5c.jpg', '2026-11-09 22:54:46'),
(4, 2, 'tes', NULL, '2026-11-09 23:28:11'),
(5, 2, 'tes', NULL, '2026-11-09 23:39:57'),
(6, 4, 'tes', NULL, '2026-11-09 23:43:11'),
(7, 4, 'tes', NULL, '2026-11-09 23:43:43'),
(8, 2, 'tes', NULL, '2026-11-09 23:48:31'),
(9, 1, 'tes', NULL, '2026-11-11 23:09:23'),
(10, 1, 'tes', NULL, '2026-11-11 23:09:29'),
(11, 1, 'tes', NULL, '2026-11-11 23:09:44'),
(12, 1, 'halooo', NULL, '2026-11-11 23:09:54'),
(13, 4, 'farrel', NULL, '2026-11-11 23:28:02'),
(14, 7, 'hadir', NULL, '2026-11-11 23:28:08'),
(15, 1, 'tes', NULL, '2026-11-16 21:35:21'),
(16, 1, 'tes', NULL, '2026-11-16 21:35:41'),
(17, 1, 'tes', NULL, '2026-11-16 21:38:26'),
(18, 1, 'tes', NULL, '2026-11-16 21:38:31'),
(19, 1, 'tes', NULL, '2026-11-16 21:38:55'),
(20, 1, 'tes', NULL, '2026-11-16 22:38:11'),
(21, 1, 'halo', NULL, '2026-11-16 22:42:09'),
(22, 1, 'haloooo', NULL, '2026-11-16 22:42:12'),
(23, 1, 'cek', NULL, '2026-11-16 22:42:17'),
(24, 1, 'ini', '1794897746_6985dcbea16ef81e89e9.png', '2026-11-16 22:42:26'),
(25, 4, 'tes', NULL, '2026-11-16 22:43:10'),
(26, 4, 'tes', NULL, '2026-11-16 22:43:12'),
(27, 1, 'tes', NULL, '2026-11-16 22:43:25'),
(28, 4, 'oke, mantap jun', NULL, '2026-11-16 22:43:39'),
(29, 1, 'oke pakkk', NULL, '2026-11-16 22:43:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumentasi`
--

CREATE TABLE `dokumentasi` (
  `id_dokumentasi` int(11) NOT NULL,
  `id_jurnal` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_aktivitas`
--

CREATE TABLE `jurnal_aktivitas` (
  `id_jurnal` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `judul_kegiatan` varchar(150) NOT NULL,
  `deskripsi_kegiatan` text NOT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `catatan_pembimbing` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurnal_aktivitas`
--

INSERT INTO `jurnal_aktivitas` (`id_jurnal`, `id_user`, `tanggal`, `judul_kegiatan`, `deskripsi_kegiatan`, `foto_bukti`, `jam_mulai`, `jam_selesai`, `status`, `catatan_pembimbing`, `created_at`, `updated_at`) VALUES
(1, 3, '2026-11-10', 'Mempelajari HTML dan CSS', 'contoh\"\r\n', NULL, '10:11:00', '11:07:00', 'disetujui', 'pelajari lagi', '2026-11-09 22:11:34', '2026-11-09 22:12:02'),
(2, 3, '2026-11-10', 'Mempelajari HTML dan CSS', 'contoh lagi', NULL, '22:12:00', '22:12:00', 'disetujui', 'sudah', '2026-11-09 22:12:28', '2026-11-09 22:13:07'),
(3, 7, '2026-11-12', 'magangg', 'magangg', NULL, '09:25:00', '10:26:00', 'disetujui', 'gs', '2026-11-11 23:26:06', '2026-11-11 23:27:15'),
(4, 7, '2026-11-12', 'magang', 'magang kela', '1794474448_2b126a4f37a751489bb7.png', '01:07:00', '01:08:00', 'disetujui', '', '2026-11-12 01:07:28', '2026-11-12 01:08:53'),
(5, 1, '2026-11-12', 'tes', 'tes', NULL, '01:30:00', '01:30:00', 'disetujui', '', '2026-11-12 01:30:32', '2026-11-12 01:31:15'),
(6, 1, '2026-11-12', 'tes', 'tes', NULL, '01:32:00', '01:32:00', 'disetujui', '', '2026-11-12 01:32:43', '2026-11-16 21:06:36'),
(7, 1, '2026-11-17', 'tes', 'tes\r\n', NULL, '20:59:00', '21:00:00', 'disetujui', '', '2026-11-16 21:05:50', '2026-11-16 21:06:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_foto`
--

CREATE TABLE `jurnal_foto` (
  `id_foto` int(11) NOT NULL,
  `id_jurnal` int(11) NOT NULL,
  `nama_foto` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurnal_foto`
--

INSERT INTO `jurnal_foto` (`id_foto`, `id_jurnal`, `nama_foto`, `created_at`) VALUES
(1, 7, '1794891950_3788ff1f25d3b96a68de.png', '2026-11-16 21:05:50'),
(2, 7, '1794891950_0ebf9cfba5d56e3e7249.png', '2026-11-16 21:05:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelompok`
--

CREATE TABLE `kelompok` (
  `id_kelompok` int(11) NOT NULL,
  `nama_kelompok` varchar(100) NOT NULL,
  `nama_sekolah` varchar(150) NOT NULL,
  `nama_instansi` varchar(150) NOT NULL,
  `alamat_instansi` text DEFAULT NULL,
  `nama_pembimbing` varchar(100) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelompok`
--

INSERT INTO `kelompok` (`id_kelompok`, `nama_kelompok`, `nama_sekolah`, `nama_instansi`, `alamat_instansi`, `nama_pembimbing`, `tanggal_mulai`, `tanggal_selesai`, `deskripsi`, `created_at`) VALUES
(1, 'Kelompok PKL 1', 'Nama Sekolah Kamu', 'Nama Instansi PKL', 'Alamat Instansi', 'Nama Pembimbing', '2026-01-01', '2026-12-31', 'Kelompok Praktik Kerja Lapangan', '2026-11-03 21:53:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id_presensi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `foto_masuk` varchar(255) DEFAULT NULL,
  `foto_pulang` varchar(255) DEFAULT NULL,
  `status` enum('hadir','izin','sakit','alpha') DEFAULT 'hadir',
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id_presensi`, `id_user`, `tanggal`, `jam_masuk`, `jam_pulang`, `foto_masuk`, `foto_pulang`, `status`, `keterangan`, `created_at`) VALUES
(1, 1, '2026-11-06', '07:39:07', '07:43:59', NULL, '1793951039_a60f464b602781e0f91f.png', 'hadir', NULL, '2026-11-05 23:39:07'),
(2, 2, '2026-11-10', '04:25:32', '04:25:57', '1794284732_583cb49bb31ab7dd0da3.png', '1794284757_a9f56ecd42d45684598d.png', 'hadir', NULL, '2026-11-09 20:25:32'),
(3, 7, '2026-11-12', '07:22:57', '07:23:09', '1794468177_8b9966946e52a2860ee7.png', '1794468189_a6f73436a09dbce61d53.png', 'hadir', NULL, '2026-11-11 23:22:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `id_task` int(11) NOT NULL,
  `id_pembuat` int(11) NOT NULL,
  `id_penanggung_jawab` int(11) DEFAULT NULL,
  `judul` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `prioritas` enum('rendah','sedang','tinggi') DEFAULT 'sedang',
  `status` enum('menunggu','dikerjakan','selesai','revisi') DEFAULT 'menunggu',
  `tanggal_mulai` date DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hasil_pengerjaan` text DEFAULT NULL,
  `file_hasil` varchar(255) DEFAULT NULL,
  `catatan_revisi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tasks`
--

INSERT INTO `tasks` (`id_task`, `id_pembuat`, `id_penanggung_jawab`, `judul`, `deskripsi`, `prioritas`, `status`, `tanggal_mulai`, `deadline`, `created_at`, `updated_at`, `hasil_pengerjaan`, `file_hasil`, `catatan_revisi`) VALUES
(1, 4, 3, 'Dokumen', 'Memeriksa dokumen', 'tinggi', 'selesai', '2026-11-09', '2026-11-30', '2026-11-09 21:39:44', '2026-11-09 21:51:01', 'Saya telah melengkapi dokumentasi kegiatan PKL dan memperbaiki hasil pengerjaan sesuai catatan revisi dari Petugas.', NULL, NULL),
(3, 4, 7, 'ngopi', 'ngopi', 'rendah', 'selesai', '2026-11-11', '2026-11-11', '2026-11-11 23:24:13', '2026-11-11 23:25:27', 'atoss', NULL, NULL),
(4, 4, 1, 'Dokumen', 'hitung dokumen', 'sedang', 'selesai', '2026-11-12', '2026-11-12', '2026-11-12 01:13:41', '2026-11-12 01:17:32', 'sudah selesaii', '1794475030_bbb288577616c18f4b18.png', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','anggota','pembimbing','petugas') NOT NULL DEFAULT 'anggota',
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `email`, `password`, `role`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hamzah Alafi Iskandar', 'Hamzah', 'hamzah.alafi31@smk.belajar.id', '$2y$10$xA/6h5GPOZOycVnxh2.P/ODr3oNJYDi13YBKXPlbrTC8EVkfVemwm', 'anggota', '1794892445_0562d83a2a50d61bff4d.jpg', 'aktif', '2026-11-05 09:57:12', '2026-11-17 05:14:09'),
(2, 'Administrator', 'admin', 'admin@Jurnal.PKL', '$2y$10$fNziLS/.yHmvnOJ4sQzaie2xad.uAZcQdybft9sgZF8noIeBv/A3C', 'admin', NULL, 'aktif', '2026-11-08 04:05:18', '2026-11-07 20:09:43'),
(3, 'Saif Paqihul Kamal', 'Paqih', 'saif@smk.belajar.id', '$2y$10$JJsua993zN.7L.eUsiGHd.NlNId29ro2D321iFF56sfGQEiOVep7q', 'anggota', NULL, 'aktif', '2026-11-08 05:15:02', '2026-11-12 09:14:51'),
(4, 'Fauzi Abdul Aziz Bashri', 'Fauzi', 'Fauzy@Jurnal.PKL', '$2y$10$X4pFwjtuvIKYIhiK8b2XHelBo69BAj/G6sveSBlmz1p0gM43.ORpe', 'petugas', NULL, 'aktif', '2026-11-08 05:18:53', '2026-11-08 05:18:53'),
(6, 'Zahran Fauzan Zamzami', 'rannn', 'zahran.fauzan154@smk.belajar.id', '$2y$10$fWZ897nOLkDcVjrkPdU6y.WmfoF1KGQzWiqI43Y6VPSGXOsLNqfXi', 'anggota', NULL, 'aktif', '2026-11-12 07:11:47', '2026-11-12 07:11:47'),
(7, 'Farrel Imaduddin Al Ashari', 'farrel', 'farrelll176@gmail.com', '$2y$10$kXAgCQ7HqyPoBmYM3Fa1ju9I1aC2Ab6NAoUg/vbO50xIw.LCpi352', 'anggota', NULL, 'aktif', '2026-11-12 07:14:33', '2026-11-12 07:14:33'),
(8, 'Lupi Maulana', 'upy', 'Alli@gmail.com', 'upyyyy', 'anggota', NULL, 'aktif', '2026-11-11 23:20:00', '2026-11-11 23:20:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota_kelompok`
--
ALTER TABLE `anggota_kelompok`
  ADD PRIMARY KEY (`id_anggota_kelompok`),
  ADD UNIQUE KEY `unik_anggota_kelompok` (`id_user`,`id_kelompok`),
  ADD KEY `id_kelompok` (`id_kelompok`);

--
-- Indeks untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `fk_chat_user` (`id_user`);

--
-- Indeks untuk tabel `dokumentasi`
--
ALTER TABLE `dokumentasi`
  ADD PRIMARY KEY (`id_dokumentasi`),
  ADD KEY `id_jurnal` (`id_jurnal`);

--
-- Indeks untuk tabel `jurnal_aktivitas`
--
ALTER TABLE `jurnal_aktivitas`
  ADD PRIMARY KEY (`id_jurnal`),
  ADD KEY `fk_jurnal_user` (`id_user`);

--
-- Indeks untuk tabel `jurnal_foto`
--
ALTER TABLE `jurnal_foto`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `fk_jurnal_foto` (`id_jurnal`);

--
-- Indeks untuk tabel `kelompok`
--
ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`id_kelompok`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD UNIQUE KEY `unik_presensi_harian` (`id_user`,`tanggal`);

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id_task`),
  ADD KEY `fk_tasks_pembuat` (`id_pembuat`),
  ADD KEY `fk_tasks_penanggung_jawab` (`id_penanggung_jawab`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggota_kelompok`
--
ALTER TABLE `anggota_kelompok`
  MODIFY `id_anggota_kelompok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `dokumentasi`
--
ALTER TABLE `dokumentasi`
  MODIFY `id_dokumentasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurnal_aktivitas`
--
ALTER TABLE `jurnal_aktivitas`
  MODIFY `id_jurnal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jurnal_foto`
--
ALTER TABLE `jurnal_foto`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kelompok`
--
ALTER TABLE `kelompok`
  MODIFY `id_kelompok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id_task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota_kelompok`
--
ALTER TABLE `anggota_kelompok`
  ADD CONSTRAINT `anggota_kelompok_ibfk_2` FOREIGN KEY (`id_kelompok`) REFERENCES `kelompok` (`id_kelompok`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_anggota_kelompok_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `fk_chat_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `dokumentasi`
--
ALTER TABLE `dokumentasi`
  ADD CONSTRAINT `dokumentasi_ibfk_1` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal_aktivitas` (`id_jurnal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jurnal_aktivitas`
--
ALTER TABLE `jurnal_aktivitas`
  ADD CONSTRAINT `fk_jurnal_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jurnal_foto`
--
ALTER TABLE `jurnal_foto`
  ADD CONSTRAINT `fk_jurnal_foto` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal_aktivitas` (`id_jurnal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `fk_presensi_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_pembuat` FOREIGN KEY (`id_pembuat`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tasks_penanggung_jawab` FOREIGN KEY (`id_penanggung_jawab`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
