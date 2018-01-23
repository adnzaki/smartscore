-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 23 Jan 2018 pada 16.04
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
(1, 'Rapor', '0.000'),
(2, 'Absensi', '0.000'),
(3, 'Keterampilan', '0.000'),
(4, 'Sikap Sosial', '0.000'),
(5, 'Sikap Spiritual', '0.000');

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
  `nilai_perbandingan` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 1, 1, '1.00'),
(2, 1, 2, '3.00'),
(3, 1, 3, '3.00'),
(4, 1, 4, '1.00'),
(5, 1, 5, '1.00'),
(6, 2, 1, '0.33'),
(7, 2, 2, '1.00'),
(8, 2, 3, '3.00'),
(9, 2, 4, '1.00'),
(10, 2, 5, '1.00'),
(11, 3, 1, '0.33'),
(12, 3, 2, '0.33'),
(13, 3, 3, '1.00'),
(14, 3, 4, '0.33'),
(15, 3, 5, '0.33'),
(16, 4, 1, '1.00'),
(17, 4, 2, '1.00'),
(18, 4, 3, '3.00'),
(19, 4, 4, '1.00'),
(20, 4, 5, '1.00'),
(21, 5, 1, '1.00'),
(22, 5, 2, '1.00'),
(23, 5, 3, '3.00'),
(24, 5, 4, '1.00'),
(25, 5, 5, '1.00');

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
(1, 'Kelas 1A', 1, 'A', 2),
(2, 'Kelas 3B', 3, 'B', 1),
(3, 'Kelas 2C', 2, 'C', 2),
(4, 'Kelas 4B', 4, 'B', 3);

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
  `agama_siswa` varchar(50) DEFAULT NULL,
  `pend_sblm` varchar(100) DEFAULT NULL,
  `alamat_siswa` varchar(250) DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `job_ayah` varchar(50) DEFAULT NULL,
  `job_ibu` varchar(50) DEFAULT NULL,
  `alamat_ortu` varchar(255) DEFAULT NULL,
  `telp_ortu` varchar(15) DEFAULT NULL,
  `nama_wali` varchar(50) DEFAULT NULL,
  `alamat_wali` varchar(255) DEFAULT NULL,
  `job_wali` varchar(50) DEFAULT NULL,
  `telp_wali` varchar(15) DEFAULT NULL,
  `id_rombel` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nisn`, `nama_siswa`, `j_kelamin_siswa`, `tempat_lahir_siswa`, `tgl_lahir_siswa`, `agama_siswa`, `pend_sblm`, `alamat_siswa`, `nama_ayah`, `nama_ibu`, `job_ayah`, `job_ibu`, `alamat_ortu`, `telp_ortu`, `nama_wali`, `alamat_wali`, `job_wali`, `telp_wali`, `id_rombel`, `status`) VALUES
(296, '518131350', '6153135813', 'Arvindha Pramudya', 'L', 'Jakarta', '2004-12-20', 'Islam', NULL, 'Jl.Taman Bekasi Asri No.35', 'Iswidiyanto', 'Hernawati', 'PNS', 'Wiraswasta', 'SDF', '12345678912', NULL, NULL, NULL, NULL, 1, 'aktif'),
(297, '518131351', '3581381463', 'Carissa Astrid Alissya', 'P', 'Ciamis', '1906-01-12', 'Islam', NULL, 'Jl.Pariwisata 2 No.12A', 'Asep Adang Rustiawan', 'Elis Faridah', 'PNS', 'PNS', 'SAD', '12345678912', NULL, NULL, NULL, NULL, 2, 'aktif'),
(298, '248218413', '3513814381', 'Fabian Noval Putra', 'L', 'Bekasi', '2004-02-15', 'Islam', NULL, 'Jl.Borobudur Blok 6 No.11', 'Tony Hamidi', 'Sri Mulyati', 'PNS', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 3, 'aktif'),
(299, '248218414', '3446247299', 'Fajar', 'L', 'Bekasi', '2004-08-04', 'Islam', NULL, 'Jl. Bambu Kuning No. 162', 'parano', 'Asiah', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 1, 'aktif'),
(300, '248218415', '3378680217', 'Faris Maulana Raka Utomo', 'L', 'Bekasi', '2004-05-04', 'Islam', NULL, 'Jl.Carita C No.199 Blok VII', 'Yogie Muliantoni R.', 'Dini Gema Juniarsih', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 2, 'aktif'),
(301, '248218416', '3311113135', 'Fitria Hayati Solichin', 'P', 'Bekasi', '2005-11-13', 'Islam', NULL, 'Jl. Haji Salam II No. 08', 'Solichin', 'Andriyani Milaningsih', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 3, 'aktif'),
(302, '248218417', '3243546053', 'Gilas Gemma Barratirani', 'L', 'Karanganyar', '2004-12-18', 'Islam', NULL, 'Jl.Kinan No.3 Kp.Sepatan', 'Arif Widodo', 'Wahyu Tri Susilowati', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 1, 'aktif'),
(303, '248218418', '3175978971', 'Hania Ayu Karin', 'P', 'Bekasi', '2005-06-28', 'Islam', NULL, 'Pengasinan Jl.Gapo Gg.Botton', 'Burhanudin', 'Marnia', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 2, 'aktif'),
(304, '248218419', '3108411889', 'Hendra Khumar', 'L', 'Pamekasan', '2003-02-02', 'Islam', NULL, 'Jl. Binacipta Kav. Binamarga', 'Fardan Ihsanuddin', 'Bahriyah', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 3, 'aktif'),
(305, '248218420', '3040844807', 'Ikhwan Arya Kusuma', 'L', 'Bekasi', '2005-08-11', 'Islam', NULL, 'Jl.Masjid Al Hidayah Gg.H.Salam I', 'Joko Prayitno', 'Rubiati', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 1, 'aktif'),
(306, '248218421', '2973277725', 'Jihan Hanifah Wal Hamidah', 'P', 'Bekasi', '2005-02-15', 'Islam', NULL, 'Jl. Pasir Putih H No. 207', 'Erry Prabowo', 'Eti Marliyana', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 2, 'aktif'),
(307, '248218424', '2770576479', 'Kevin Albimo Suwastono', 'L', 'Kota Bekasi', '2005-11-22', 'Islam', NULL, 'Jl.Kintamani I No.80', 'Suwastono', 'Septi Amelia', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 2, 'aktif'),
(308, '248218425', '2703009397', 'Laurensia Monika Dio Nathania', 'P', 'Bekasi', '2006-01-12', 'Katholik', NULL, 'Taman Bekasi Asri Blok B 5', 'Didik Dwi Budi Utomo', 'Okatavianna Setyorini', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 3, 'aktif'),
(309, '248218426', '2635442315', 'M. Dias Aryangga', 'L', 'Bekasi', '2005-07-08', 'Islam', NULL, 'Kp.Pengasinan', 'Subaryo', 'Fitri Komalasari', 'Wiraswasta', 'PNS', 'dsafs', '12345678912', NULL, NULL, NULL, NULL, 1, 'aktif'),
(310, '248218427', '2567875233', 'Muhamad Ramsey Akbar', 'L', 'Bekasi', '2005-02-01', 'Islam', NULL, 'Gg. Nyamuk No. 41', 'Beny Hamidi', 'Ovi Nofita', 'Wiraswasta', 'PNS', 'dsafs', '12345678913', NULL, NULL, NULL, NULL, 2, 'aktif'),
(311, '248218428', '2500308151', 'Mutia Nur Khoerani', 'P', 'Bekasi', '2005-05-28', 'Islam', NULL, 'Jl.Bambu Kuning', 'Supi Irawan', 'Sumiati', 'Wiraswasta', 'PNS', 'dsafs', '12345678914', NULL, NULL, NULL, NULL, 3, 'aktif'),
(312, '248218429', '2432741069', 'Nadya Wulandari', 'P', 'Bekasi', '2005-04-05', 'Islam', NULL, 'Jl. Kintamani', 'Zaidun Ubid', 'Aznawati', 'Wiraswasta', 'PNS', 'dsafs', '12345678915', NULL, NULL, NULL, NULL, 1, 'aktif'),
(313, '248218430', '2365173987', 'Najwa Alia', 'P', 'Semarang', '2005-04-22', 'Islam', NULL, 'Jl.Telaga Sarangan G No.167', 'Mochamad Ali', 'Tumini', 'Wiraswasta', 'PNS', 'dsafs', '12345678916', NULL, NULL, NULL, NULL, 2, 'aktif'),
(314, '248218431', '2297606905', 'Nur Fitri', 'P', 'Kab. Cirebon', '2004-11-01', 'Islam', NULL, 'Jl.Carita', 'Muhtarun', 'Yayah Juhariyah', 'Wiraswasta', 'PNS', 'dsafs', '12345678917', NULL, NULL, NULL, NULL, 3, 'aktif'),
(315, '248218432', '2230039823', 'Puan Hasanah Marwah', 'P', 'Jakarta', '2005-03-15', 'Islam', NULL, 'Jl.pangandaran', 'Harun Al Rasyid', 'Susanti', 'Wiraswasta', 'PNS', 'dsafs', '12345678918', NULL, NULL, NULL, NULL, 1, 'aktif'),
(316, '248218433', '2162472741', 'Raflyano Fitransyah', 'L', 'Bogor', '2004-11-12', 'Islam', NULL, 'Jl.Bina Cipta Kav.Bina Marga Blok H No.22A', 'RD. Indra Sampoerna', 'Yunia Nur Ismirat', 'Wiraswasta', 'PNS', 'dsafs', '12345678919', NULL, NULL, NULL, NULL, 2, 'aktif'),
(317, '248218434', '2094905659', 'Rama Alviansha', 'L', 'Kota Bekasi', '2005-10-05', 'Islam', NULL, 'Jl.Telaga Sarangan E No.231', 'A. Sofyan Syah', 'Santi', 'Wiraswasta', 'PNS', 'dsafs', '12345678920', NULL, NULL, NULL, NULL, 3, 'aktif');

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
  ADD KEY `fk_siswa` (`id_siswa`),
  ADD KEY `fk_pembanding_alternatif` (`pembanding`);

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
  ADD PRIMARY KEY (`id_prioritas`);

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
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perbandingan_kriteria`
--
ALTER TABLE `perbandingan_kriteria`
  MODIFY `id_perbandingan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `prioritas_solusi`
--
ALTER TABLE `prioritas_solusi`
  MODIFY `id_prioritas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rombel`
--
ALTER TABLE `rombel`
  MODIFY `id_rombel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`id_jenis_guru`) REFERENCES `jenis_guru` (`id_jenis_guru`);

--
-- Ketidakleluasaan untuk tabel `perbandingan_alternatif`
--
ALTER TABLE `perbandingan_alternatif`
  ADD CONSTRAINT `fk_pembanding_alternatif` FOREIGN KEY (`pembanding`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `fk_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Ketidakleluasaan untuk tabel `perbandingan_kriteria`
--
ALTER TABLE `perbandingan_kriteria`
  ADD CONSTRAINT `fk_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`),
  ADD CONSTRAINT `fk_pembanding` FOREIGN KEY (`pembanding`) REFERENCES `kriteria` (`id_kriteria`);

--
-- Ketidakleluasaan untuk tabel `rombel`
--
ALTER TABLE `rombel`
  ADD CONSTRAINT `rombel_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
