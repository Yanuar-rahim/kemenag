-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2026 at 03:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `konten`, `tanggal`, `gambar`) VALUES
(1, 'Pendaftaran Layanan Kemenag Baubau Dibuka', 'Pendaftaran layanan Kemenag Baubau untuk tahun 2026 telah dibuka. Silakan mengakses website kami untuk informasi lebih lanjut.', '2026-01-04 16:00:00', 'G8YiyZLaUAAF6OZ.jpg'),
(2, 'Penerimaan Calon Pegawai Negeri Sipil (CPNS)', 'Kemenag Baubau mengumumkan penerimaan CPNS tahun 2026. Pengumuman lengkap dapat diakses di website resmi kami.', '2026-01-03 16:00:00', 'IMG-20240901-WA0001.jpg'),
(3, 'Webinar Pendidikan Agama Islam 2026', 'Kami mengadakan webinar tentang pendidikan agama Islam. Daftar sekarang dan ikuti webinar bermanfaat ini!', '2026-01-02 16:00:00', '0e17febd522cd9389b04ce5c00f25aec_XL.jpg'),
(4, 'Pentingnya Pengembangan Pendidikan Karakter', 'Kemenag Baubau mengajak masyarakat untuk berpartisipasi dalam pengembangan pendidikan karakter di sekolah-sekolah.', '2026-01-01 16:00:00', 'membangun-pendidikan-karakter-di-desa-cipari-peran-pemerintah-dan-nilai-nilai-lokal.jpg'),
(5, 'Layanan Konsultasi Perkawinan di Kemenag', 'Kemenag Baubau menyediakan layanan konsultasi perkawinan bagi yang membutuhkan bantuan. Silakan hubungi kami untuk informasi lebih lanjut.', '2025-12-31 16:00:00', 'images (1).jpg'),
(6, 'Bantuan Sosial Untuk Masyarakat', 'Program bantuan sosial dari Kemenag Baubau diperuntukkan bagi masyarakat yang membutuhkan. Segera ajukan bantuan melalui website kami.', '2025-12-30 16:00:00', 'WhatsApp Image 2020-05-01 at 15.21.13 (1).jpeg'),
(7, 'Pembangunan Infrastruktur di Kemenag Baubau', 'Kemenag Baubau melaksanakan proyek pembangunan infrastruktur untuk memperbaiki pelayanan kepada masyarakat. Baca selengkapnya di artikel ini.', '2025-12-29 16:00:00', 'IMG-20210605-WA0005.jpg'),
(8, 'Pelatihan Guru Agama Se-Kota Baubau', 'Kemenag Baubau akan mengadakan pelatihan bagi guru agama di seluruh wilayah Baubau. Informasi dan pendaftaran bisa diakses melalui website resmi kami.', '2025-12-28 16:00:00', 'pce1by9cs3wdvm7.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
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
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `nama_layanan`, `deskripsi`, `gambar`, `status`, `created_at`) VALUES
(1, 'Layanan Nikah', 'Pelayanan pencatatan dan administrasi pernikahan', '', 'Aktif', '2026-01-04 04:05:58'),
(2, 'Layanan Haji & Umrah', 'Pelayanan informasi dan administrasi haji dan umrah', '', 'Aktif', '2026-01-04 04:05:58'),
(3, 'Layanan Pendidikan', 'Pelayanan terkait madrasah dan pendidikan keagamaan', '', 'Aktif', '2026-01-04 04:05:58'),
(4, 'Layanan Keagamaan', 'Pelayanan bimbingan dan kegiatan keagamaan', 'layanan_1767507611.jpg', 'Aktif', '2026-01-04 04:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_layanan`
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
-- Dumping data for table `pengajuan_layanan`
--

INSERT INTO `pengajuan_layanan` (`id`, `nama`, `email`, `nik`, `alamat`, `no_hp`, `nama_layanan`, `keterangan`, `tanggal_pengajuan`, `status`, `created_at`) VALUES
(2, 'La Ode Yanuar Rahim', 'yanuarrahim@gmail.com', '7472050901050002', 'Jalan Sarikaya', '082331096562', 'Layanan Nikah', 'juakka', '2026-01-04', 'Menunggu', '2026-01-04 13:40:52'),
(3, 'La Ode Yanuar Rahim', 'yanuarrahim@gmail.com', '7472050901050002', 'Jalan Sarikaya', '082331096562', 'Layanan Pendidikan', 'afafa', '2026-01-04', 'Menunggu', '2026-01-04 13:41:28'),
(4, 'La Ode Yanuar Rahim', 'yanuarrahim@gmail.com', '7472050901050002', 'Jalan Sarikaya', '082331096562', 'Layanan Keagamaan', 'arafaf', '2026-01-04', 'Selesai', '2026-01-04 13:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `username`, `password`, `role`, `nik`, `alamat`, `no_hp`) VALUES
(2, 'La Ode Yanuar Rahim', 'yanuarrahim@gmail.com', 'yanuar', '$2y$10$SO7PcMFLZQ79LnwvwUDxcu8MVEFo/4tWH6qNvcLhxZhxZDZ9zHKn2', 'user', '7472050901050002', 'Jalan Sarikaya', '082331096562'),
(3, 'La Ode Yanuar Rahim', 'yanuarrahim519@gmail.com', 'admin', '$2y$10$7ohg6fiXpu8OFqM4AdZrcueToOze7yzTM.uz8YRecvBMji3n8U0cK', 'admin', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan_layanan`
--
ALTER TABLE `pengajuan_layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengajuan_layanan`
--
ALTER TABLE `pengajuan_layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
