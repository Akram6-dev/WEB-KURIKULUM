-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Mar 2026 pada 04.00
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smkn1_kurikulum_v3`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id_absen` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `nama` varchar(100) NOT NULL,
  `status` enum('Hadir','Izin','Sakit','Alpa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'NESAS_CEREN', '2026-02-25 07:56:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(100) DEFAULT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `mapel` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `guru_pengampu` varchar(100) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_kelas`, `hari`, `jam_mulai`, `jam_selesai`, `mapel`, `guru_pengampu`, `kelas`) VALUES
(1, 6, 'Senin', '18:25:00', '17:24:00', 'lonte', 'askom', 'X AKL 3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`, `keterangan`, `deskripsi`, `logo`) VALUES
(1, 'RPL', NULL, 'Rekayasa Perangkat Lunak - Mempelajari pengembangan aplikasi dan sistem informasi', NULL),
(2, 'TKJ', NULL, 'Teknik Komputer dan Jaringan - Mempelajari instalasi dan konfigurasi jaringan komputer', NULL),
(3, 'AKL', NULL, 'Akuntansi dan Keuangan Lembaga - Mempelajari pencatatan dan pelaporan keuangan', NULL),
(4, 'DKV', NULL, 'Desain Komunikasi Visual - Mempelajari desain grafis dan multimedia', NULL),
(5, 'MPLB', NULL, 'Manajemen Perkantoran dan Layanan Bisnis - Mempelajari administrasi perkantoran', NULL),
(6, 'PEMASARAN', NULL, 'Bisnis Daring dan Pemasaran - Mempelajari strategi pemasaran digital', NULL),
(7, 'TO', NULL, 'Teknik Otomotif - Mempelajari perawatan dan perbaikan kendaraan bermotor', NULL),
(8, 'TM', NULL, 'Teknik Pemesinan - Mempelajari pengoperasian mesin produksi dan manufaktur', NULL),
(9, 'Teknik Logistik', NULL, 'Teknik Logistik - Mempelajari manajemen rantai pasok dan distribusi', NULL),
(10, 'KULINER', NULL, 'Tata Boga - Mempelajari pengolahan makanan dan manajemen dapur', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) DEFAULT NULL,
  `tingkat` enum('10','11','12') DEFAULT NULL,
  `id_jurusan` int(11) DEFAULT NULL,
  `wali_kelas` varchar(100) DEFAULT NULL,
  `jumlah_siswa` int(11) DEFAULT 0,
  `laki` int(11) DEFAULT 0,
  `perempuan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `tingkat`, `id_jurusan`, `wali_kelas`, `jumlah_siswa`, `laki`, `perempuan`) VALUES
(59, 'X KULINER', '10', 10, 'Hermawati Setyani Aksari, S.Pd.', 0, 0, 0),
(60, 'XI KULINER', '11', 10, 'Elin Neli Novianti, S.Pd.', 0, 0, 0),
(61, 'XII KULINER', '12', 10, 'Asep Saepulloh, S.S.', 0, 0, 0),
(62, 'X TL', '10', 9, 'Faisal Akbar, S.E.', 0, 0, 0),
(63, 'XI TL', '11', 9, 'Deni Ariyanto, S.Pd.', 0, 0, 0),
(64, 'XII TL', '12', 9, 'Rizky Hakiki, S.T.', 0, 0, 0),
(65, 'X DKV 1', '10', 4, 'Asep Dani Noviandi, S.An.', 0, 0, 0),
(66, 'XI DKV 1', '11', 4, 'Jelin, S.Pd.I.', 0, 0, 0),
(67, 'XII DKV 1', '12', 4, 'Cici Harisningsih, S.Pd.', 0, 0, 0),
(68, 'X DKV 2', '10', 4, 'Hj. Iin Indriasari, S.Pd.', 0, 0, 0),
(69, 'XI DKV 2', '11', 4, 'Dra. Hj. Heti Perdiati', 0, 0, 0),
(70, 'XII DKV 2', '12', 4, 'Yayang Willy Rukmana, S.Ds.', 0, 0, 0),
(71, 'X TM 1', '10', 8, 'Asep Romdon, S.T.', 0, 0, 0),
(72, 'XI TPM 1', '11', 8, 'Keresna Bayu Wijaya Kusuma, S.Pd.', 0, 0, 0),
(73, 'XII TPM 1', '12', 8, 'Sri Andani, S.Pd.', 0, 0, 0),
(74, 'X TM 2', '10', 8, 'Ace Shobandi, S.E.', 0, 0, 0),
(75, 'XI TPM 2', '11', 8, 'Iin Irmayanti, S.Pd.', 0, 0, 0),
(76, 'XII TPM 2', '12', 8, 'Isep Rahmanto, S.T.', 0, 0, 0),
(77, 'X TM 3', '10', 8, 'Rahmat Hidayat, S.Pd.', 0, 0, 0),
(78, 'XI TPM 3', '11', 8, 'H. Johan Suhendi, S.T.', 0, 0, 0),
(79, 'XII TPM 3', '12', 8, 'Mas Achmad Yusuf Wibisono, S.T.', 0, 0, 0),
(80, 'X TO 1', '10', 7, 'Dadang, S.Pd. I.', 0, 0, 0),
(81, 'XI TSM 1', '11', 7, 'Ahmad Ruhyanto, S.Pd.', 0, 0, 0),
(82, 'XII TSM 1', '12', 7, 'Firmansyah, S.T.', 0, 0, 0),
(83, 'X TO 2', '10', 7, 'Nia Amalia, S.Pd.', 0, 0, 0),
(84, 'XI TSM 2', '11', 7, 'Eko Agus Prasetiyo, S.Pd.', 0, 0, 0),
(85, 'XII TSM 2', '12', 7, 'Guntur Widiantono, S.T.', 0, 0, 0),
(86, 'X TO 3', '10', 7, 'Hj. Siti Maemunah, S.Pd., M.M.Pd.', 0, 0, 0),
(87, 'XI TSM 3', '11', 7, 'Asep Rohendi, S.Pd.', 0, 0, 0),
(88, 'XII TSM 3', '12', 7, 'Ari Wahyudani, S.Pd.', 0, 0, 0),
(89, 'X PPLG 1', '10', 1, 'Wendy Supriatna, S.Pd.', 0, 0, 0),
(90, 'XI RPL 1', '11', 1, 'Buyung Supriadi, S.S.', 0, 0, 0),
(91, 'XII RPL 1', '12', 1, 'Retno Novia Andriani, S.Kom', 0, 0, 0),
(92, 'X PPLG 2', '10', 1, 'Iis Ismayati, S.T.', 0, 0, 0),
(93, 'XI RPL 2', '11', 1, 'Ai Sa\'adatuddaroin, S.Pd.', 0, 0, 0),
(94, 'XII RPL 2', '12', 1, 'Deni Rahman Hakim, S.Pd.', 0, 0, 0),
(95, 'X TJKT 1', '10', 2, 'Dede Iskandar, S.T.', 0, 0, 0),
(96, 'XI TKJ 1', '11', 2, 'Gelar Laksana Cita, S.Pd.', 0, 0, 0),
(97, 'XII TKJ 1', '12', 2, 'Lisna Herliani, S.Pd.I.', 0, 0, 0),
(98, 'X TJKT 2', '10', 2, 'Annia Devalusiani Nurul Jaeni, M.Pd.', 0, 0, 0),
(99, 'XI TKJ 2', '11', 2, 'Elis Waliah, S.Ag.', 0, 0, 0),
(100, 'XII TKJ 2', '12', 2, 'Asep Ridwan, S.T.', 0, 0, 0),
(101, 'X AKL 1', '10', 3, 'Fippa Insani, S.Pd.', 0, 0, 0),
(102, 'XI AK 1', '11', 3, 'Putri Maulida Hutami, S.Pd.', 0, 0, 0),
(103, 'XII AK 1', '12', 3, 'Kartiwi, S.Pd.I.', 0, 0, 0),
(104, 'X AKL 2', '10', 3, 'Irwan Saputra, S.Pd.', 0, 0, 0),
(105, 'XI AK 2', '11', 3, 'Titah Utami, S.Pd.', 0, 0, 0),
(106, 'XII AK 2', '12', 3, 'H. Pepen Apendi, S.Pd., M.Pd.I.', 0, 0, 0),
(107, 'X AKL 3', '10', 3, 'Aang Awaludin, S.Pd.I.', 0, 0, 0),
(108, 'XI AK 3', '11', 3, 'Hafizh Handitia, S.Pd.', 0, 0, 0),
(109, 'XII AK 3', '12', 3, 'Sapa Oktapiani, S.Pd.', 0, 0, 0),
(110, 'X MPLB 1', '10', 5, 'Andina Nurma Fadhila, S.Hum.', 0, 0, 0),
(111, 'XI MP 1', '11', 5, 'Wida Widianingsih, S.Pd.', 0, 0, 0),
(112, 'XII MP 1', '12', 5, 'Regina Srinita Chatulistiwa Putri, S.Pd.', 0, 0, 0),
(113, 'X MPLB 2', '10', 5, 'Puttu Aliyah Setia Raya, S.Pd.', 0, 0, 0),
(114, 'XI MP 2', '11', 5, 'Dini Nurmaladewi, S.An.', 0, 0, 0),
(115, 'XII MP 2', '12', 5, 'Dra. Hj. Yayah Bahriah', 0, 0, 0),
(116, 'X MPLB 3', '10', 5, 'Hibar Rahayu, S.Pd.', 0, 0, 0),
(117, 'XI MP 3', '11', 5, 'Dini Wulandari, S.Pd.', 0, 0, 0),
(118, 'XII MP 3', '12', 5, 'Sari Utami, S.E.', 0, 0, 0),
(119, 'X PS 1', '10', 6, 'Asep Komara, S.Pd.', 0, 0, 0),
(120, 'XI BR 1', '11', 6, 'Hj. Siti Halimah, S.Pd.', 0, 0, 0),
(121, 'XII BR 1', '12', 6, 'Hj. Chairzawati, S.E.', 0, 0, 0),
(122, 'X PS 2', '10', 6, 'Reni Ika Wijayanti, M.Pd.', 0, 0, 0),
(123, 'XI BR 2', '11', 6, 'Heni Ariska, S.Pd.', 0, 0, 0),
(124, 'XII BR 2', '12', 6, 'Dra. Carsih', 0, 0, 0),
(125, 'X PS 3', '10', 6, 'Ismaela, S.E.', 0, 0, 0),
(126, 'XI BR 3', '11', 6, 'Rika Tri Mulyawati, S.Pd.', 0, 0, 0),
(127, 'XII BR 3', '12', 6, 'Setyasih, S.E.', 0, 0, 0),
(128, 'X PS 4', '10', 6, 'Nani Suryani, S.Pd.', 0, 0, 0),
(129, 'XI BD', '11', 6, 'Fahmi Ibrahim S., S.Pd.', 0, 0, 0),
(130, 'XII BD', '12', 6, 'Lia Yuliasari, S.Pd.', 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `judul` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_upload` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('KV26bBDLgWmedUhcnTYlZzGJ1ZA5gBifoXWxOCZT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRFFJVXlNZlpNNTBjYTJHWlpJbjZ2aHloUG1MWFpIRFFOSVVjR3FqciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxNToia3VyaWt1bHVtLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1OiJhZG1pbiI7czo1OiJhZG1pbiI7fQ==', 1772261870);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama_siswa` varchar(100) DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `jk` varchar(2) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `nis`, `id_kelas`, `jk`, `foto`) VALUES
(1, 'Muhammad Alfa Mafaza', '123456', 10, 'P', NULL),
(2, 'asep.sql', '67676767676767676767', 122, 'P', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
