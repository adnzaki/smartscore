-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 14 Mar 2018 pada 20.42
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
  `user_id` varchar(100) DEFAULT NULL,
  `password_pengguna` varchar(50) DEFAULT NULL,
  `status_pengguna` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_pengguna`, `user_id`, `password_pengguna`, `status_pengguna`) VALUES
(1, 'Administrator', 'admin', 'admin', 'admin');

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
(23, 320, 320, 1, '2.00'),
(24, 320, 321, 1, '0.25'),
(25, 320, 344, 1, '0.33'),
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
(71, 326, 318, 1, '3.00'),
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
(92, 322, 343, 1, '3.00'),
(93, 322, 320, 1, '2.00'),
(94, 322, 321, 1, '0.33'),
(95, 322, 344, 1, '0.14'),
(96, 322, 323, 1, '0.33'),
(97, 322, 325, 1, '0.14'),
(98, 322, 326, 1, '0.33'),
(99, 322, 328, 1, '0.33'),
(100, 322, 322, 1, '1.00');

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
  `eigen_kriteria` decimal(4,3) DEFAULT NULL
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
(318, '098209238', '0928301481', 'Al Azza Herfa Akbar', 'L', 'Jakarta', '2006-05-06', 'Jl. jalan', 'heheh', 'hehehe', 6, 'aktif'),
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
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `perbandingan_alternatif`
--
ALTER TABLE `perbandingan_alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

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
