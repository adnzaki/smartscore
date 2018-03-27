-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27 Mar 2018 pada 07.33
-- Versi Server: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartscore`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `agama`
--

CREATE TABLE `agama` (
  `id_agama` int(11) NOT NULL,
  `nama_agama` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `agama`
--

INSERT INTO `agama` (`id_agama`, `nama_agama`) VALUES
(1, 'Islam'),
(2, 'Katholik'),
(3, 'Kristen Protestan'),
(4, 'Hindu'),
(5, 'Budha');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_alternatif`
--

CREATE TABLE `daftar_alternatif` (
  `id_daftar_alternatif` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `daftar_alternatif`
--

INSERT INTO `daftar_alternatif` (`id_daftar_alternatif`, `id_siswa`) VALUES
(1, 318),
(3, 320),
(4, 321),
(10, 322),
(6, 323),
(7, 325),
(8, 326),
(9, 328),
(2, 343),
(5, 344);

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(100) DEFAULT NULL,
  `j_kelamin_guru` char(1) DEFAULT NULL,
  `tempat_lahir_guru` varchar(100) DEFAULT NULL,
  `tgl_lahir_guru` date DEFAULT NULL,
  `agama_guru` varchar(50) DEFAULT NULL,
  `id_jenis_guru` int(11) DEFAULT NULL,
  `pend_guru` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `j_kelamin_guru`, `tempat_lahir_guru`, `tgl_lahir_guru`, `agama_guru`, `id_jenis_guru`, `pend_guru`) VALUES
(1, 'Dedi Mulyadi, S.Pd.', 'L', 'Ciamis', '1965-11-02', 'Islam', 2, 'S1 PPKn'),
(2, 'Aep Saepudin, S.Pd.', 'L', 'Bandung', '1968-12-17', 'Islam', 2, 'S1 PGSD'),
(3, 'Nurhasan Effendi, S.Pd.', 'L', 'Bekasi', '1963-12-12', 'Islam', 1, 'S1 PLS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_guru`
--

CREATE TABLE `jenis_guru` (
  `id_jenis_guru` int(11) NOT NULL,
  `nama_jenis_guru` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_guru`
--

INSERT INTO `jenis_guru` (`id_jenis_guru`, `nama_jenis_guru`) VALUES
(1, 'Guru Mapel'),
(2, 'Guru Kelas'),
(3, 'Guru Ekskul');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `nama_kriteria` varchar(50) DEFAULT NULL,
  `eigen_value` decimal(4,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `eigen_value`) VALUES
(1, 'Rapor', '0.288'),
(2, 'Absensi', '0.188'),
(3, 'Keterampilan', '0.074'),
(4, 'Sikap Sosial', '0.225'),
(5, 'Sikap Spiritual', '0.225');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_pengguna` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password_pengguna` varchar(250) DEFAULT NULL,
  `status_pengguna` varchar(10) DEFAULT NULL,
  `network_status` varchar(10) NOT NULL DEFAULT 'offline'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_pengguna`, `email`, `username`, `password_pengguna`, `status_pengguna`, `network_status`) VALUES
(1, 'Administrator', 'administrator@smartscore.com', 'admin', '$2y$10$.FfVZyRXsoHHWLPcW51RBeWKT9JpyMw7695/Dxuq/9XslRHozlYWu', 'admin', 'offline'),
(2, 'Adnan Zaki', 'adnanzaki@wolestech.com', 'adnzaki', '$2y$10$2Cget7xT7pO3wqMBxkmofO/iqAL9MRaa6N/ZnMzFajpND3CganJ.W', 'user', 'offline'),
(3, 'Dani Rusmawana', 'danirusmawan@wolestech.com', 'danirus', '$2y$10$160kvkaHjo6l0NrbMgCZpuEfdY.Eysz65SAps5ku9pMhswjdjIHlC', 'user', 'offline'),
(4, 'Mukhlisin', 'mukhlis@gmail.com', 'mukhlis', '$2y$10$qWWAYseQ/CLhlVZqcncb9.pcXIzS8gBjOl2FL0Dvubf1GPI7aOevS', 'user', 'offline'),
(5, 'Rino Swastika', 'rinouhuy@gmail.com', 'rinohs', '$2y$10$/jRwJ466oPciipkE1vp.qeWAl/qEwGJ.b/KQCdFckCmWrIUtW1yGy', 'user', 'offline'),
(6, 'kampret', 'kampret@sda.com', 'uhuy12', '$2y$10$LMxRYKeuEyHSIcYm4Zqhruh6SFH338S9RrpmRCTRrmUze9HxA7Bhi', 'user', 'offline'),
(7, 'Uswatun Hasanah', 'uswatun@gmail.com', 'dasnd', '$2y$10$y6yyD8cY0TuFlcK4Ut9zZeSI/KT0ywB8ecat/2Av3h1myX5kaODK2', 'user', 'offline'),
(8, 'abdulid', 'aaaaaaas@sdkjfbs.co', 'dsajdsa', '$2y$10$E/Hqxk5hrQrBGfja25feoOGwXFmWVBcoflCsuX2SVcoxOP4nc/Dwq', 'user', 'offline');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perbandingan_alternatif`
--

CREATE TABLE `perbandingan_alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `pembanding` int(11) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nilai_perbandingan` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `perbandingan_alternatif`
--

INSERT INTO `perbandingan_alternatif` (`id_alternatif`, `id_siswa`, `pembanding`, `id_kriteria`, `nilai_perbandingan`) VALUES
(1, 318, 318, 1, '1.00'),
(2, 318, 343, 1, '3.00'),
(3, 318, 320, 1, '3.00'),
(4, 318, 321, 1, '5.00'),
(5, 318, 344, 1, '0.33'),
(6, 318, 323, 1, '1.00'),
(7, 318, 325, 1, '0.33'),
(8, 318, 326, 1, '3.00'),
(9, 318, 328, 1, '1.00'),
(10, 318, 322, 1, '3.00'),
(11, 343, 318, 1, '0.33'),
(12, 343, 343, 1, '1.00'),
(13, 343, 320, 1, '2.00'),
(14, 343, 321, 1, '3.00'),
(15, 343, 344, 1, '0.20'),
(16, 343, 323, 1, '0.33'),
(17, 343, 325, 1, '0.20'),
(18, 343, 326, 1, '0.50'),
(19, 343, 328, 1, '0.33'),
(20, 343, 322, 1, '1.00'),
(21, 320, 318, 1, '0.33'),
(22, 320, 343, 1, '0.50'),
(23, 320, 320, 1, '1.00'),
(24, 320, 321, 1, '2.00'),
(25, 320, 344, 1, '0.25'),
(26, 320, 323, 1, '0.33'),
(27, 320, 325, 1, '0.20'),
(28, 320, 326, 1, '1.00'),
(29, 320, 328, 1, '1.00'),
(30, 320, 322, 1, '0.50'),
(31, 321, 318, 1, '0.20'),
(32, 321, 343, 1, '0.33'),
(33, 321, 320, 1, '0.50'),
(34, 321, 321, 1, '1.00'),
(35, 321, 344, 1, '0.20'),
(36, 321, 323, 1, '0.33'),
(37, 321, 325, 1, '0.20'),
(38, 321, 326, 1, '1.00'),
(39, 321, 328, 1, '0.50'),
(40, 321, 322, 1, '3.00'),
(41, 344, 318, 1, '3.00'),
(42, 344, 343, 1, '5.00'),
(43, 344, 320, 1, '4.00'),
(44, 344, 321, 1, '5.00'),
(45, 344, 344, 1, '1.00'),
(46, 344, 323, 1, '1.00'),
(47, 344, 325, 1, '1.00'),
(48, 344, 326, 1, '3.00'),
(49, 344, 328, 1, '3.00'),
(50, 344, 322, 1, '7.00'),
(51, 323, 318, 1, '1.00'),
(52, 323, 343, 1, '3.00'),
(53, 323, 320, 1, '3.00'),
(54, 323, 321, 1, '3.00'),
(55, 323, 344, 1, '1.00'),
(56, 323, 323, 1, '1.00'),
(57, 323, 325, 1, '0.33'),
(58, 323, 326, 1, '3.00'),
(59, 323, 328, 1, '3.00'),
(60, 323, 322, 1, '3.00'),
(61, 325, 318, 1, '3.00'),
(62, 325, 343, 1, '5.00'),
(63, 325, 320, 1, '5.00'),
(64, 325, 321, 1, '5.00'),
(65, 325, 344, 1, '1.00'),
(66, 325, 323, 1, '3.00'),
(67, 325, 325, 1, '1.00'),
(68, 325, 326, 1, '3.00'),
(69, 325, 328, 1, '4.00'),
(70, 325, 322, 1, '7.00'),
(71, 326, 318, 1, '0.33'),
(72, 326, 343, 1, '2.00'),
(73, 326, 320, 1, '1.00'),
(74, 326, 321, 1, '1.00'),
(75, 326, 344, 1, '0.33'),
(76, 326, 323, 1, '0.33'),
(77, 326, 325, 1, '0.33'),
(78, 326, 326, 1, '1.00'),
(79, 326, 328, 1, '1.00'),
(80, 326, 322, 1, '3.00'),
(81, 328, 318, 1, '1.00'),
(82, 328, 343, 1, '3.00'),
(83, 328, 320, 1, '1.00'),
(84, 328, 321, 1, '2.00'),
(85, 328, 344, 1, '0.33'),
(86, 328, 323, 1, '0.33'),
(87, 328, 325, 1, '0.25'),
(88, 328, 326, 1, '1.00'),
(89, 328, 328, 1, '1.00'),
(90, 328, 322, 1, '3.00'),
(91, 322, 318, 1, '0.33'),
(92, 322, 343, 1, '1.00'),
(93, 322, 320, 1, '2.00'),
(94, 322, 321, 1, '0.33'),
(95, 322, 344, 1, '0.14'),
(96, 322, 323, 1, '0.33'),
(97, 322, 325, 1, '0.14'),
(98, 322, 326, 1, '0.33'),
(99, 322, 328, 1, '0.33'),
(100, 322, 322, 1, '1.00'),
(101, 318, 318, 2, '1.00'),
(102, 318, 343, 2, '2.00'),
(103, 343, 318, 2, '0.50'),
(104, 318, 320, 2, '3.00'),
(105, 320, 318, 2, '0.33'),
(106, 318, 321, 2, '3.00'),
(107, 321, 318, 2, '0.33'),
(108, 318, 344, 2, '0.33'),
(109, 344, 318, 2, '3.00'),
(110, 318, 323, 2, '1.00'),
(111, 323, 318, 2, '1.00'),
(112, 318, 325, 2, '0.33'),
(113, 325, 318, 2, '3.00'),
(114, 318, 326, 2, '0.33'),
(115, 326, 318, 2, '3.00'),
(116, 318, 328, 2, '0.50'),
(117, 328, 318, 2, '2.00'),
(118, 318, 322, 2, '3.00'),
(119, 322, 318, 2, '0.33'),
(120, 343, 343, 2, '1.00'),
(121, 343, 320, 2, '1.00'),
(122, 320, 343, 2, '1.00'),
(123, 343, 321, 2, '3.00'),
(124, 321, 343, 2, '0.33'),
(125, 343, 344, 2, '0.33'),
(126, 344, 343, 2, '3.00'),
(127, 343, 325, 2, '0.33'),
(128, 325, 343, 2, '3.00'),
(129, 343, 323, 2, '0.33'),
(130, 323, 343, 2, '3.00'),
(131, 343, 326, 2, '0.33'),
(132, 326, 343, 2, '3.00'),
(133, 343, 328, 2, '0.50'),
(134, 328, 343, 2, '2.00'),
(135, 343, 322, 2, '1.00'),
(136, 322, 343, 2, '1.00'),
(137, 320, 320, 2, '1.00'),
(138, 320, 321, 2, '2.00'),
(139, 321, 320, 2, '0.50'),
(140, 320, 344, 2, '0.25'),
(141, 344, 320, 2, '4.00'),
(142, 320, 323, 2, '0.33'),
(143, 323, 320, 2, '3.00'),
(144, 320, 325, 2, '0.20'),
(145, 325, 320, 2, '5.00'),
(146, 320, 326, 2, '1.00'),
(147, 326, 320, 2, '1.00'),
(148, 320, 328, 2, '1.00'),
(149, 328, 320, 2, '1.00'),
(150, 320, 322, 2, '2.00'),
(151, 322, 320, 2, '0.50'),
(152, 321, 321, 2, '1.00'),
(153, 321, 344, 2, '0.20'),
(154, 344, 321, 2, '5.00'),
(155, 321, 323, 2, '0.33'),
(156, 325, 321, 2, '5.00'),
(157, 321, 325, 2, '0.20'),
(158, 326, 321, 2, '1.00'),
(159, 321, 326, 2, '1.00'),
(160, 328, 321, 2, '2.00'),
(161, 321, 328, 2, '0.50'),
(162, 322, 321, 2, '0.33'),
(163, 321, 322, 2, '3.00'),
(164, 323, 321, 2, '3.00'),
(165, 344, 344, 2, '1.00'),
(166, 344, 323, 2, '1.00'),
(167, 323, 344, 2, '1.00'),
(168, 344, 325, 2, '1.00'),
(169, 325, 344, 2, '1.00'),
(170, 344, 326, 2, '3.00'),
(171, 326, 344, 2, '0.33'),
(172, 344, 328, 2, '3.00'),
(173, 328, 344, 2, '0.33'),
(174, 344, 322, 2, '7.00'),
(175, 322, 344, 2, '0.14'),
(176, 323, 323, 2, '1.00'),
(177, 323, 325, 2, '0.33'),
(178, 326, 323, 2, '0.33'),
(179, 323, 326, 2, '3.00'),
(180, 325, 323, 2, '3.00'),
(181, 323, 328, 2, '3.00'),
(182, 328, 323, 2, '0.33'),
(183, 323, 322, 2, '3.00'),
(184, 322, 323, 2, '0.33'),
(185, 325, 325, 2, '1.00'),
(186, 325, 326, 2, '3.00'),
(187, 326, 325, 2, '0.33'),
(188, 325, 328, 2, '4.00'),
(189, 328, 325, 2, '0.25'),
(190, 325, 322, 2, '5.00'),
(191, 322, 325, 2, '0.20'),
(192, 326, 326, 2, '1.00'),
(193, 326, 328, 2, '1.00'),
(194, 328, 326, 2, '1.00'),
(195, 326, 322, 2, '3.00'),
(196, 322, 326, 2, '0.33'),
(197, 328, 328, 2, '1.00'),
(198, 328, 322, 2, '3.00'),
(199, 322, 328, 2, '0.33'),
(200, 322, 322, 2, '1.00'),
(201, 318, 318, 3, '1.00'),
(202, 318, 343, 3, '1.00'),
(203, 343, 318, 3, '1.00'),
(204, 318, 320, 3, '3.00'),
(205, 320, 318, 3, '0.33'),
(206, 318, 321, 3, '3.00'),
(207, 321, 318, 3, '0.33'),
(208, 318, 344, 3, '0.33'),
(209, 344, 318, 3, '3.00'),
(210, 318, 323, 3, '1.00'),
(211, 323, 318, 3, '1.00'),
(212, 318, 325, 3, '0.33'),
(213, 325, 318, 3, '3.00'),
(214, 318, 326, 3, '3.00'),
(215, 326, 318, 3, '0.33'),
(216, 318, 328, 3, '0.50'),
(217, 328, 318, 3, '2.00'),
(218, 318, 322, 3, '3.00'),
(219, 322, 318, 3, '0.33'),
(220, 343, 343, 3, '1.00'),
(221, 343, 320, 3, '1.00'),
(222, 320, 343, 3, '1.00'),
(223, 343, 321, 3, '3.00'),
(224, 321, 343, 3, '0.33'),
(225, 343, 344, 3, '0.33'),
(226, 344, 343, 3, '3.00'),
(227, 343, 323, 3, '0.33'),
(228, 323, 343, 3, '3.00'),
(229, 343, 325, 3, '0.33'),
(230, 325, 343, 3, '3.00'),
(231, 343, 326, 3, '0.33'),
(232, 326, 343, 3, '3.00'),
(233, 343, 328, 3, '0.50'),
(234, 328, 343, 3, '2.00'),
(235, 343, 322, 3, '1.00'),
(236, 322, 343, 3, '1.00'),
(237, 320, 320, 3, '1.00'),
(238, 320, 321, 3, '2.00'),
(239, 321, 320, 3, '0.50'),
(240, 320, 344, 3, '0.25'),
(241, 344, 320, 3, '4.00'),
(242, 320, 323, 3, '0.33'),
(243, 323, 320, 3, '3.00'),
(244, 320, 325, 3, '0.20'),
(245, 325, 320, 3, '5.00'),
(246, 320, 326, 3, '1.00'),
(247, 326, 320, 3, '1.00'),
(248, 320, 328, 3, '1.00'),
(249, 328, 320, 3, '1.00'),
(250, 320, 322, 3, '2.00'),
(251, 322, 320, 3, '0.50'),
(252, 321, 321, 3, '1.00'),
(253, 321, 344, 3, '0.20'),
(254, 344, 321, 3, '5.00'),
(255, 321, 323, 3, '0.33'),
(256, 323, 321, 3, '3.00'),
(257, 321, 325, 3, '0.20'),
(258, 325, 321, 3, '5.00'),
(259, 321, 326, 3, '1.00'),
(260, 326, 321, 3, '1.00'),
(261, 321, 328, 3, '0.50'),
(262, 328, 321, 3, '2.00'),
(263, 321, 322, 3, '3.00'),
(264, 322, 321, 3, '0.33'),
(265, 344, 344, 3, '1.00'),
(266, 344, 323, 3, '1.00'),
(267, 323, 344, 3, '1.00'),
(268, 344, 325, 3, '1.00'),
(269, 325, 344, 3, '1.00'),
(270, 344, 326, 3, '3.00'),
(271, 326, 344, 3, '0.33'),
(272, 344, 328, 3, '3.00'),
(273, 328, 344, 3, '0.33'),
(274, 344, 322, 3, '7.00'),
(275, 322, 344, 3, '0.14'),
(276, 323, 323, 3, '1.00'),
(277, 323, 325, 3, '0.25'),
(278, 325, 323, 3, '4.00'),
(279, 323, 326, 3, '3.00'),
(280, 326, 323, 3, '0.33'),
(281, 323, 328, 3, '3.00'),
(282, 328, 323, 3, '0.33'),
(283, 323, 322, 3, '3.00'),
(284, 322, 323, 3, '0.33'),
(285, 325, 325, 3, '1.00'),
(286, 325, 326, 3, '3.00'),
(287, 326, 325, 3, '0.33'),
(288, 325, 328, 3, '4.00'),
(289, 328, 325, 3, '0.25'),
(290, 325, 322, 3, '5.00'),
(291, 322, 325, 3, '0.20'),
(292, 326, 326, 3, '1.00'),
(293, 326, 328, 3, '1.00'),
(294, 328, 326, 3, '1.00'),
(295, 326, 322, 3, '3.00'),
(296, 322, 326, 3, '0.33'),
(297, 328, 328, 3, '1.00'),
(298, 328, 322, 3, '3.00'),
(299, 322, 328, 3, '0.33'),
(300, 322, 322, 3, '1.00'),
(301, 318, 318, 4, '1.00'),
(302, 318, 343, 4, '1.00'),
(303, 343, 318, 4, '1.00'),
(304, 318, 320, 4, '3.00'),
(305, 320, 318, 4, '0.33'),
(306, 318, 321, 4, '3.00'),
(307, 321, 318, 4, '0.33'),
(308, 318, 323, 4, '1.00'),
(309, 323, 318, 4, '1.00'),
(310, 318, 325, 4, '0.33'),
(311, 325, 318, 4, '3.00'),
(312, 318, 344, 4, '0.33'),
(313, 344, 318, 4, '3.00'),
(314, 318, 326, 4, '3.00'),
(315, 326, 318, 4, '0.33'),
(316, 318, 328, 4, '0.50'),
(317, 328, 318, 4, '2.00'),
(318, 318, 322, 4, '3.00'),
(319, 322, 318, 4, '0.33'),
(320, 343, 343, 4, '1.00'),
(321, 343, 320, 4, '0.50'),
(322, 320, 343, 4, '2.00'),
(323, 343, 321, 4, '3.00'),
(324, 321, 343, 4, '0.33'),
(325, 343, 344, 4, '0.33'),
(326, 344, 343, 4, '3.00'),
(327, 343, 323, 4, '0.33'),
(328, 323, 343, 4, '3.00'),
(329, 343, 325, 4, '0.33'),
(330, 325, 343, 4, '3.00'),
(331, 343, 326, 4, '0.33'),
(332, 326, 343, 4, '3.00'),
(333, 343, 328, 4, '0.50'),
(334, 328, 343, 4, '2.00'),
(335, 343, 322, 4, '1.00'),
(336, 322, 343, 4, '1.00'),
(337, 320, 320, 4, '1.00'),
(338, 320, 321, 4, '2.00'),
(339, 321, 320, 4, '0.50'),
(340, 320, 344, 4, '0.25'),
(341, 344, 320, 4, '4.00'),
(342, 320, 323, 4, '0.33'),
(343, 323, 320, 4, '3.00'),
(344, 320, 325, 4, '0.33'),
(345, 325, 320, 4, '3.00'),
(346, 320, 326, 4, '1.00'),
(347, 326, 320, 4, '1.00'),
(348, 320, 328, 4, '1.00'),
(349, 328, 320, 4, '1.00'),
(350, 320, 322, 4, '2.00'),
(351, 322, 320, 4, '0.50'),
(352, 321, 321, 4, '1.00'),
(353, 321, 344, 4, '0.20'),
(354, 344, 321, 4, '5.00'),
(355, 321, 323, 4, '0.33'),
(356, 323, 321, 4, '3.00'),
(357, 321, 325, 4, '0.20'),
(358, 325, 321, 4, '5.00'),
(359, 321, 326, 4, '1.00'),
(360, 326, 321, 4, '1.00'),
(361, 321, 328, 4, '0.50'),
(362, 328, 321, 4, '2.00'),
(363, 321, 322, 4, '3.00'),
(364, 322, 321, 4, '0.33'),
(365, 344, 344, 4, '1.00'),
(366, 344, 323, 4, '1.00'),
(367, 323, 344, 4, '1.00'),
(368, 344, 325, 4, '1.00'),
(369, 325, 344, 4, '1.00'),
(370, 344, 326, 4, '3.00'),
(371, 326, 344, 4, '0.33'),
(372, 344, 328, 4, '3.00'),
(373, 328, 344, 4, '0.33'),
(374, 344, 322, 4, '7.00'),
(375, 322, 344, 4, '0.14'),
(376, 323, 323, 4, '1.00'),
(377, 323, 325, 4, '0.25'),
(378, 325, 323, 4, '4.00'),
(379, 323, 326, 4, '3.00'),
(380, 326, 323, 4, '0.33'),
(381, 323, 328, 4, '3.00'),
(382, 328, 323, 4, '0.33'),
(383, 323, 322, 4, '3.00'),
(384, 322, 323, 4, '0.33'),
(385, 325, 325, 4, '1.00'),
(386, 325, 326, 4, '3.00'),
(387, 326, 325, 4, '0.33'),
(388, 325, 328, 4, '2.00'),
(389, 328, 325, 4, '0.50'),
(390, 325, 322, 4, '5.00'),
(391, 322, 325, 4, '0.20'),
(392, 326, 326, 4, '1.00'),
(393, 326, 328, 4, '1.00'),
(394, 328, 326, 4, '1.00'),
(395, 326, 322, 4, '3.00'),
(396, 322, 326, 4, '0.33'),
(397, 328, 328, 4, '1.00'),
(398, 328, 322, 4, '3.00'),
(399, 322, 328, 4, '0.33'),
(400, 322, 322, 4, '1.00'),
(401, 318, 318, 5, '1.00'),
(402, 318, 343, 5, '3.00'),
(403, 343, 318, 5, '0.33'),
(404, 318, 320, 5, '0.33'),
(405, 320, 318, 5, '3.00'),
(406, 318, 321, 5, '3.00'),
(407, 321, 318, 5, '0.33'),
(408, 318, 344, 5, '1.00'),
(409, 344, 318, 5, '1.00'),
(410, 318, 323, 5, '0.33'),
(411, 323, 318, 5, '3.00'),
(412, 318, 325, 5, '1.00'),
(413, 325, 318, 5, '1.00'),
(414, 318, 326, 5, '2.00'),
(415, 326, 318, 5, '0.50'),
(416, 318, 328, 5, '3.00'),
(417, 328, 318, 5, '0.33'),
(418, 318, 322, 5, '0.33'),
(419, 322, 318, 5, '3.00'),
(420, 343, 343, 5, '1.00'),
(421, 343, 320, 5, '0.50'),
(422, 320, 343, 5, '2.00'),
(423, 343, 321, 5, '3.00'),
(424, 321, 343, 5, '0.33'),
(425, 343, 344, 5, '0.33'),
(426, 344, 343, 5, '3.00'),
(427, 343, 323, 5, '0.33'),
(428, 323, 343, 5, '3.00'),
(429, 343, 325, 5, '3.00'),
(430, 325, 343, 5, '0.33'),
(431, 343, 326, 5, '1.00'),
(432, 326, 343, 5, '1.00'),
(433, 343, 328, 5, '0.33'),
(434, 328, 343, 5, '3.00'),
(435, 343, 322, 5, '0.20'),
(436, 322, 343, 5, '5.00'),
(437, 320, 320, 5, '1.00'),
(438, 320, 321, 5, '3.00'),
(439, 321, 320, 5, '0.33'),
(440, 320, 344, 5, '2.00'),
(441, 344, 320, 5, '0.50'),
(442, 320, 323, 5, '1.00'),
(443, 323, 320, 5, '1.00'),
(444, 320, 325, 5, '3.00'),
(445, 325, 320, 5, '0.33'),
(446, 320, 326, 5, '3.00'),
(447, 326, 320, 5, '0.33'),
(448, 320, 328, 5, '3.00'),
(449, 328, 320, 5, '0.33'),
(450, 320, 322, 5, '0.50'),
(451, 322, 320, 5, '2.00'),
(452, 321, 321, 5, '1.00'),
(453, 321, 344, 5, '3.00'),
(454, 344, 321, 5, '0.33'),
(455, 321, 323, 5, '1.00'),
(456, 323, 321, 5, '1.00'),
(457, 321, 325, 5, '1.00'),
(458, 325, 321, 5, '1.00'),
(459, 321, 328, 5, '1.00'),
(460, 328, 321, 5, '1.00'),
(461, 321, 326, 5, '1.00'),
(462, 326, 321, 5, '1.00'),
(463, 321, 322, 5, '0.20'),
(464, 322, 321, 5, '5.00'),
(465, 344, 344, 5, '1.00'),
(466, 344, 323, 5, '0.33'),
(467, 323, 344, 5, '3.00'),
(468, 344, 325, 5, '1.00'),
(469, 325, 344, 5, '1.00'),
(470, 344, 326, 5, '3.00'),
(471, 326, 344, 5, '0.33'),
(472, 344, 328, 5, '3.00'),
(473, 328, 344, 5, '0.33'),
(474, 344, 322, 5, '0.33'),
(475, 322, 344, 5, '3.00'),
(476, 323, 323, 5, '1.00'),
(477, 323, 325, 5, '5.00'),
(478, 326, 323, 5, '0.14'),
(479, 323, 326, 5, '7.00'),
(480, 328, 323, 5, '0.33'),
(481, 323, 328, 5, '3.00'),
(482, 325, 323, 5, '0.20'),
(483, 323, 322, 5, '1.00'),
(484, 322, 323, 5, '1.00'),
(485, 325, 325, 5, '1.00'),
(486, 325, 326, 5, '1.00'),
(487, 326, 325, 5, '1.00'),
(488, 325, 328, 5, '1.00'),
(489, 328, 325, 5, '1.00'),
(490, 325, 322, 5, '0.20'),
(491, 322, 325, 5, '5.00'),
(492, 326, 326, 5, '1.00'),
(493, 326, 328, 5, '1.00'),
(494, 328, 326, 5, '1.00'),
(495, 326, 322, 5, '0.14'),
(496, 322, 326, 5, '7.00'),
(497, 328, 328, 5, '1.00'),
(498, 328, 322, 5, '0.20'),
(499, 322, 328, 5, '5.00'),
(500, 322, 322, 5, '1.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perbandingan_kriteria`
--

CREATE TABLE `perbandingan_kriteria` (
  `id_perbandingan` int(11) NOT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `pembanding` int(11) DEFAULT NULL,
  `nilai_perbandingan` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `perbandingan_kriteria`
--

INSERT INTO `perbandingan_kriteria` (`id_perbandingan`, `id_kriteria`, `pembanding`, `nilai_perbandingan`) VALUES
(119, 1, 1, '1.00'),
(120, 1, 2, '3.00'),
(121, 2, 1, '0.33'),
(122, 2, 2, '1.00'),
(123, 1, 3, '3.00'),
(124, 2, 3, '3.00'),
(125, 3, 1, '0.33'),
(126, 3, 2, '0.33'),
(127, 3, 3, '1.00'),
(128, 1, 4, '1.00'),
(129, 2, 4, '1.00'),
(130, 3, 4, '0.33'),
(131, 4, 1, '1.00'),
(132, 4, 2, '1.00'),
(133, 4, 3, '3.00'),
(134, 4, 4, '1.00'),
(135, 1, 5, '1.00'),
(136, 2, 5, '1.00'),
(137, 3, 5, '0.33'),
(138, 4, 5, '1.00'),
(139, 5, 1, '1.00'),
(140, 5, 2, '1.00'),
(141, 5, 3, '3.00'),
(142, 5, 4, '1.00'),
(143, 5, 5, '1.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prioritas_solusi`
--

CREATE TABLE `prioritas_solusi` (
  `id_prioritas` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nilai_kriteria` decimal(4,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rombel`
--

CREATE TABLE `rombel` (
  `id_rombel` int(11) NOT NULL,
  `nama_rombel` varchar(50) DEFAULT NULL,
  `tingkat` int(11) DEFAULT NULL,
  `paralel` varchar(5) NOT NULL,
  `id_guru` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rombel`
--

INSERT INTO `rombel` (`id_rombel`, `nama_rombel`, `tingkat`, `paralel`, `id_guru`) VALUES
(6, 'Kelas 5A', 5, 'A', 1),
(8, 'Kelas 5B', 5, 'B', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `idSetting` int(11) NOT NULL,
  `settingName` varchar(50) DEFAULT NULL,
  `settingValue` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`idSetting`, `settingName`, `settingValue`) VALUES
(0, 'appUrl', 'localhost:8080'),
(1, 'colorTheme', 'light');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` char(9) DEFAULT NULL,
  `nisn` char(10) DEFAULT NULL,
  `nama_siswa` varchar(100) DEFAULT NULL,
  `j_kelamin_siswa` char(1) DEFAULT NULL,
  `tempat_lahir_siswa` varchar(100) DEFAULT NULL,
  `tgl_lahir_siswa` date DEFAULT NULL,
  `alamat_siswa` varchar(250) DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `id_rombel` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nisn`, `nama_siswa`, `j_kelamin_siswa`, `tempat_lahir_siswa`, `tgl_lahir_siswa`, `alamat_siswa`, `nama_ayah`, `nama_ibu`, `id_rombel`, `status`) VALUES
(318, '098209238', '0928301481', 'Al Azza Herfa Akbarrr', 'L', 'Jakarta', '2006-05-06', 'Jl. jalan', 'heheh', 'hehehe', 6, 'aktif'),
(320, '518131351', '3581381463', 'Desi Asca Safitri', 'P', 'Ciamis', '1906-01-12', 'Jl.Pariwisata 2 No.12A', 'Asep Adang Rustiawan', 'Elis Faridah', 8, 'aktif'),
(321, '248218413', '3513814381', 'Dimaz Aryo Wicaksono', 'L', 'Bekasi', '2004-02-15', 'Jl.Borobudur Blok 6 No.11', 'Tony Hamidi', 'Sri Mulyati', 6, 'aktif'),
(322, '248218414', '3446247299', 'Tsalisa Laila Hazna ', 'L', 'Bekasi', '2004-08-04', 'Jl. Bambu Kuning No. 162', 'parano', 'Asiah', 8, 'aktif'),
(323, '248218415', '3378680217', 'Mahesa Arya Saputra', 'L', 'Bekasi', '2004-05-04', 'Jl.Carita C No.199 Blok VII', 'Yogie Muliantoni R.', 'Dini Gema Juniarsih', 6, 'aktif'),
(325, '248218417', '3243546053', 'Nabil Caesar Ramadhan', 'L', 'Karanganyar', '2004-12-18', 'Jl.Kinan No.3 Kp.Sepatan', 'Arif Widodo', 'Wahyu Tri Susilowati', 6, 'aktif'),
(326, '248218418', '3175978971', 'Nova Pratama ', 'P', 'Bekasi', '2005-06-28', 'Pengasinan Jl.Gapo Gg.Botton', 'Burhanudin', 'Marnia', 8, 'aktif'),
(328, '248218420', '3040844807', 'Shofa Pritama ', 'L', 'Bekasi', '2005-08-11', 'Jl.Masjid Al Hidayah Gg.H.Salam I', 'Joko Prayitno', 'Rubiati', 8, 'aktif'),
(343, '092384023', '1209830192', 'Annisarizqa Asward', 'P', 'Cirebon', '1997-04-01', 'Jl. Kamu Masih panjang neng', 'Suradiman', 'MKLS', 6, 'aktif'),
(344, '390345908', '2903280948', 'Imam Al Gazali', 'L', 'Jakarta', '1998-06-06', 'dhs', 'jkbjk', 'jk', 6, 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `tahun_ajaran` int(11) NOT NULL,
  `nama_tahun_ajaran` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`tahun_ajaran`, `nama_tahun_ajaran`) VALUES
(20161, '2016/2017 Ganjil'),
(20162, '2016/2017 Genap');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_log`
--

CREATE TABLE `user_log` (
  `id_log` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `waktu_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agama`
--
ALTER TABLE `agama`
  ADD PRIMARY KEY (`id_agama`);

--
-- Indexes for table `daftar_alternatif`
--
ALTER TABLE `daftar_alternatif`
  ADD PRIMARY KEY (`id_daftar_alternatif`),
  ADD KEY `fk_siswa_alternatif` (`id_siswa`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD KEY `id_jenis_guru` (`id_jenis_guru`);

--
-- Indexes for table `jenis_guru`
--
ALTER TABLE `jenis_guru`
  ADD PRIMARY KEY (`id_jenis_guru`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `perbandingan_alternatif`
--
ALTER TABLE `perbandingan_alternatif`
  ADD PRIMARY KEY (`id_alternatif`),
  ADD KEY `fk_param_kriteria` (`id_kriteria`),
  ADD KEY `fk_pembanding_alternatif` (`pembanding`),
  ADD KEY `fk_siswa` (`id_siswa`);

--
-- Indexes for table `perbandingan_kriteria`
--
ALTER TABLE `perbandingan_kriteria`
  ADD PRIMARY KEY (`id_perbandingan`),
  ADD KEY `fk_kriteria` (`id_kriteria`),
  ADD KEY `fk_pembanding` (`pembanding`);

--
-- Indexes for table `prioritas_solusi`
--
ALTER TABLE `prioritas_solusi`
  ADD PRIMARY KEY (`id_prioritas`),
  ADD KEY `fk_siswa_prioritas` (`id_siswa`),
  ADD KEY `fk_kriteria_prioritas` (`id_kriteria`);

--
-- Indexes for table `rombel`
--
ALTER TABLE `rombel`
  ADD PRIMARY KEY (`id_rombel`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`idSetting`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`tahun_ajaran`),
  ADD UNIQUE KEY `tahun_ajaran` (`nama_tahun_ajaran`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id_log`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agama`
--
ALTER TABLE `agama`
  MODIFY `id_agama` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `daftar_alternatif`
--
ALTER TABLE `daftar_alternatif`
  MODIFY `id_daftar_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenis_guru`
--
ALTER TABLE `jenis_guru`
  MODIFY `id_jenis_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `perbandingan_alternatif`
--
ALTER TABLE `perbandingan_alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=501;

--
-- AUTO_INCREMENT for table `perbandingan_kriteria`
--
ALTER TABLE `perbandingan_kriteria`
  MODIFY `id_perbandingan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `prioritas_solusi`
--
ALTER TABLE `prioritas_solusi`
  MODIFY `id_prioritas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rombel`
--
ALTER TABLE `rombel`
  MODIFY `id_rombel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `daftar_alternatif`
--
ALTER TABLE `daftar_alternatif`
  ADD CONSTRAINT `fk_siswa_alternatif` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`id_jenis_guru`) REFERENCES `jenis_guru` (`id_jenis_guru`);

--
-- Ketidakleluasaan untuk tabel `perbandingan_alternatif`
--
ALTER TABLE `perbandingan_alternatif`
  ADD CONSTRAINT `fk_param_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_pembanding_alternatif` FOREIGN KEY (`pembanding`) REFERENCES `siswa` (`id_siswa`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `perbandingan_kriteria`
--
ALTER TABLE `perbandingan_kriteria`
  ADD CONSTRAINT `fk_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_pembanding` FOREIGN KEY (`pembanding`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `prioritas_solusi`
--
ALTER TABLE `prioritas_solusi`
  ADD CONSTRAINT `fk_kriteria_prioritas` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_siswa_prioritas` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `rombel`
--
ALTER TABLE `rombel`
  ADD CONSTRAINT `rombel_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
