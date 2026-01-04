-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Jan 2026 pada 09.08
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
-- Database: `kemenag`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan`
--

CREATE TABLE `layanan` (
  `id` int(11) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(100) NOT NULL,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `layanan`
--

INSERT INTO `layanan` (`id`, `nama_layanan`, `deskripsi`, `gambar`, `status`, `created_at`) VALUES
(1, 'Layanan Nikah', 'Pelayanan pencatatan dan administrasi pernikahan', '', 'Aktif', '2026-01-04 04:05:58'),
(2, 'Layanan Haji & Umrah', 'Pelayanan informasi dan administrasi haji dan umrah', '', 'Aktif', '2026-01-04 04:05:58'),
(3, 'Layanan Pendidikan', 'Pelayanan terkait madrasah dan pendidikan keagamaan', '', 'Aktif', '2026-01-04 04:05:58'),
(4, 'Layanan Keagamaan', 'Pelayanan bimbingan dan kegiatan keagamaan', 'layanan_1767507611.jpg', 'Aktif', '2026-01-04 04:05:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_layanan`
--

CREATE TABLE `pengajuan_layanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `nama_layanan` varchar(150) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `status` enum('Menunggu','Diproses','Selesai','Ditolak') DEFAULT 'Menunggu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengajuan_layanan`
--

INSERT INTO `pengajuan_layanan` (`id`, `nama`, `email`, `nik`, `alamat`, `no_hp`, `nama_layanan`, `keterangan`, `tanggal_pengajuan`, `status`, `created_at`) VALUES
(1, 'La Ode Yanuar Rahim', 'yanuarrahim@gmail.com', '', '', '', 'Layanan Nikah', 'Anak Kucai', '2026-01-04', 'Menunggu', '2026-01-04 06:02:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `nik` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `username`, `password`, `role`, `nik`, `alamat`, `no_hp`) VALUES
(2, 'La Ode Yanuar Rahim', 'yanuarrahim@gmail.com', 'yanuar', '$2y$10$SO7PcMFLZQ79LnwvwUDxcu8MVEFo/4tWH6qNvcLhxZhxZDZ9zHKn2', 'user', '7472050901050002', 'Jalan Sarikaya', '082331096562'),
(3, 'La Ode Yanuar Rahim', 'yanuarrahim519@gmail.com', 'admin', '$2y$10$7ohg6fiXpu8OFqM4AdZrcueToOze7yzTM.uz8YRecvBMji3n8U0cK', 'admin', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengajuan_layanan`
--
ALTER TABLE `pengajuan_layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_layanan`
--
ALTER TABLE `pengajuan_layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
