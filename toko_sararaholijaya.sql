-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2023 at 04:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_sararaholijaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_barang`
--

CREATE TABLE `data_barang` (
  `kode_barang` char(6) NOT NULL,
  `nama_barang` char(100) NOT NULL,
  `kategori` char(100) NOT NULL,
  `harga_modal` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `jumlah_stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_barang`
--

INSERT INTO `data_barang` (`kode_barang`, `nama_barang`, `kategori`, `harga_modal`, `harga_satuan`, `jumlah_stok`) VALUES
('BP01PM', 'Kain Batik Motif Sioföna (Merah)', 'Kain Batik Bahan Prima', 145000, 170000, 11),
('BP02DH', 'Kain Batik Motif Tanö Niha Kotak Kecil (Hitam)', 'Kain Batik Bahan Dobi', 175000, 200000, 15),
('BP02DK', 'Kain Batik Motif Tanö Niha Kotak Kecil (Kuning)', 'Kain Batik Bahan Dobi', 175000, 200000, 12),
('BP02DM', 'Kain Batik Motif Tanö Niha Kotak Kecil (Merah)', 'Kain Batik Bahan Dobi', 175000, 200000, 12),
('BP02PH', 'Kain Batik Motif Tanö Niha Kotak Kecil (Hitam)', 'Kain Batik Bahan Prima', 145000, 170000, 0),
('BP02PK', 'Kain Batik Motif Tanö Niha Kotak Kecil (Merah)', 'Kain Batik Bahan Prima', 145000, 170000, 0),
('BP05PM', 'Kain Batik Motif Manari Moyo (Merah)', 'Kain Batik Bahan Prima', 165000, 190000, 0),
('BP06PM', 'Kain Batik Motif  YNF (Merah)', 'Kain Batik Bahan Prima', 145000, 170000, 12),
('BP07PH', 'Kain Batik Motif Sumange Sisara Afo (Hitam)', 'Kain Batik Bahan Prima', 155000, 180000, 0),
('BP2PSH', 'Kain Batik Motif Tanö Niha Kotak Kecil (Hitam)', 'Kain Batik Bahan Primisima', 155000, 180000, 0),
('BP2PSK', 'Kain Batik Motif Tanö Niha Kotak Kecil (Kuning)', 'Kain Batik Bahan Primisima', 155000, 200000, 0),
('BP2PSM', 'Kain Batik Motif Tanö Niha Kotak Kecil (Merah)', 'Kain Batik Bahan Primisima', 155000, 180000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `kode_barang` char(6) NOT NULL,
  `nama_barang` char(100) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `kwitansi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `kode_barang`, `nama_barang`, `tanggal_pembelian`, `jumlah_beli`, `harga_beli`, `kwitansi`) VALUES
(1, 'BP01PM', 'Kain Batik Motif Sioföna (Merah)', '2023-06-15', 5, 145000, '64bce7dbc6880.jpg'),
(3, 'BP01PM', 'Kain Batik Motif Sioföna (Merah)', '2023-07-23', 10, 155000, '64bd3289c0f3d.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `kode_barang` char(6) NOT NULL,
  `nama_pembeli` char(50) NOT NULL,
  `nama_barang` char(100) NOT NULL,
  `kategori` char(100) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `jumlah_jual` int(11) NOT NULL,
  `potongan` int(11) NOT NULL,
  `harga_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `kode_barang`, `nama_pembeli`, `nama_barang`, `kategori`, `tanggal_penjualan`, `jumlah_jual`, `potongan`, `harga_total`) VALUES
(2, 'BP01PM', 'Ina Aurel', 'Kain Batik Motif Sioföna (Merah)', 'Kain Batik Bahan Prima', '2023-07-02', 2, 0, 340000),
(3, 'BP02DH', 'Adrian', 'Kain Batik Motif Tanö Niha Kotak Kecil (Hitam)', 'Kain Batik Bahan Dobi', '2023-07-23', 2, 10000, 390000),
(5, 'BP01PM', 'Ina Aurel', 'Kain Batik Motif Sioföna (Merah)', 'Kain Batik Bahan Prima', '2023-07-23', 2, 0, 340000);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `tanggal_riwayat` date NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat`
--

INSERT INTO `riwayat` (`id_riwayat`, `tanggal_riwayat`, `deskripsi`) VALUES
(1, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP07PH\nNama Barang: Kain Batik Motif Sumange Sisara Afo (Hitam)\nKategori: Kain Batik Bahan Prima\nHarga Modal: 155000\nHarga Satuan: 180000\nTanggal Perubahan: 2023-07-23 15:23:12'),
(2, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP06PM\nNama Barang: Kain Batik Motif  YNF (Merah)\nKategori: Kain Batik Bahan Prima\nHarga Modal: 145000\nHarga Satuan: 170000\nTanggal Perubahan: 2023-07-23 15:23:54'),
(3, '2023-07-23', 'Admin mengedit data pada tabel data barang:\nKode Barang: BP06PM\nNama Barang: Kain Batik Motif  YNF (Merah)\nKategori: Kain Batik Bahan Prima\nHarga Modal: 145000\nHarga Satuan: 170000\nTanggal Perubahan: 2023-07-23 15:25:36'),
(4, '2023-07-23', 'Admin mengedit data pada tabel data barang:\nKode Barang: BP07PH\nNama Barang: Kain Batik Motif Sumange Sisara Afo (Hitam)\nKategori: Kain Batik Bahan Prima\nHarga Modal: 155000\nHarga Satuan: 180000\nTanggal Perubahan: 2023-07-23 15:25:50'),
(5, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP05PM\nNama Barang: Kain Batik Motif Manari Moyo (Merah)\nKategori: Kain Batik Bahan Prima\nHarga Modal: 165000\nHarga Satuan: 190000\nTanggal Perubahan: 2023-07-23 15:26:58'),
(6, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP01PM\nNama Barang: Kain Batik Motif Sioföna (Merah)\nKategori: Kain Batik Bahan Prima\nHarga Modal: 145000\nHarga Satuan: 170000\nTanggal Perubahan: 2023-07-23 15:27:23'),
(7, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP02DK\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Kuning)\nKategori: Kain Batik Bahan Dobi\nHarga Modal: 175000\nHarga Satuan: 200000\nTanggal Perubahan: 2023-07-23 15:28:19'),
(8, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP02DH\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Hitam)\nKategori: Kain Batik Bahan Dobi\nHarga Modal: 175000\nHarga Satuan: 200000\nTanggal Perubahan: 2023-07-23 15:28:54'),
(9, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP02DM\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Merah)\nKategori: Kain Batik Bahan Dobi\nHarga Modal: 175000\nHarga Satuan: 200000\nTanggal Perubahan: 2023-07-23 15:29:26'),
(10, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP2PSK\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Kuning)\nKategori: Kain Batik Bahan Primisima\nHarga Modal: 155000\nHarga Satuan: 200000\nTanggal Perubahan: 2023-07-23 15:30:26'),
(11, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP2PSM\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Merah)\nKategori: Kain Batik Bahan Primisima\nHarga Modal: 155000\nHarga Satuan: 180000\nTanggal Perubahan: 2023-07-23 15:32:11'),
(12, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP2PSH\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Hitam)\nKategori: Kain Batik Bahan Primisima\nHarga Modal: 155000\nHarga Satuan: 180000\nTanggal Perubahan: 2023-07-23 15:33:09'),
(13, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP02PK\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Merah)\nKategori: Kain Batik Bahan Prima\nHarga Modal: 145000\nHarga Satuan: 170000\nTanggal Perubahan: 2023-07-23 15:33:40'),
(14, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP02PH\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Hitam)\nKategori: Kain Batik Bahan Prima\nHarga Modal: 145000\nHarga Satuan: 170000\nTanggal Perubahan: 2023-07-23 15:34:47'),
(15, '2023-07-23', 'Admin mengedit data pada stok barang:\nKode Barang: BP01PM\nNama Barang: Kain Batik Motif Sioföna (Merah)\nJumlah Stok: 12\nTanggal Perubahan: 2023-07-23 15:35:29'),
(16, '2023-07-23', 'Admin mengedit data pada stok barang:\nKode Barang: BP02DH\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Hitam)\nJumlah Stok: 12\nTanggal Perubahan: 2023-07-23 15:35:33'),
(17, '2023-07-23', 'Admin mengedit data pada stok barang:\nKode Barang: BP02DM\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Merah)\nJumlah Stok: 12\nTanggal Perubahan: 2023-07-23 15:35:38'),
(18, '2023-07-23', 'Admin mengedit data pada stok barang:\nKode Barang: BP02DK\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Kuning)\nJumlah Stok: 12\nTanggal Perubahan: 2023-07-23 15:35:44'),
(19, '2023-07-23', 'Owner menambah data pada tabel pembelian:\nID Pembelian: 1\nKode Barang: BP01PM\nNama Barang: Kain Batik Motif Sioföna (Merah)\nTanggal Pembelian: 2023-06-15\nJumlah Beli: 5\nHarga Beli: 145000\nKwitansi: 64bce7dbc6880.jpg\nTanggal Perubahan: 2023-07-23 15:42:03'),
(20, '2023-07-23', 'Admin menambah data pada tabel penjualan:\nID Penjualan: 1\nKode Barang: BP01PM\nNama Pembeli: Ina Aurel\nNama Barang: Kain Batik Motif Sioföna (Merah)\nKategori: Kain Batik Bahan Prima\nTanggal Penjualan: 2023-07-07\nJumlah Jual: 2\nHarga Potongan: 0\nHarga Total: 340000\nTanggal Perubahan: 2023-07-23 15:45:00'),
(21, '2023-07-23', 'Admin menghapus data pada tabel penjualan:\nID Penjualan: 1\nKode Barang: BP01PM\nNama Pembeli: Ina Aurel\nNama Barang: Kain Batik Motif Sioföna (Merah)\nKategori: Kain Batik Bahan Prima\nTanggal Penjualan: 2023-07-07\nJumlah Jual: 2\nHarga Potongan: 0\nHarga Total: 340000\nTanggal Perubahan: 2023-07-23 15:46:21'),
(22, '2023-07-23', 'Admin menambah data pada tabel penjualan:\nID Penjualan: 2\nKode Barang: BP01PM\nNama Pembeli: Ina Aurel\nNama Barang: Kain Batik Motif Sioföna (Merah)\nKategori: Kain Batik Bahan Prima\nTanggal Penjualan: 2023-07-02\nJumlah Jual: 2\nHarga Potongan: 0\nHarga Total: 340000\nTanggal Perubahan: 2023-07-23 15:46:35'),
(23, '2023-07-23', 'Owner mengedit data pada tabel pembelian:\nID Pembelian: 1\nKode Barang: BP01PM\nNama Barang: Kain Batik Motif Sioföna (Merah)\nTanggal Pembelian: 2023-06-15\nJumlah Beli: 5\nHarga Beli: 145000\nKwitansi: 64bce7dbc6880.jpg\nTanggal Perubahan: 2023-07-23 15:46:59'),
(24, '2023-07-23', 'Admin menambah data pada tabel penjualan:\nID Penjualan: 3\nKode Barang: BP02DH\nNama Pembeli: Adrian\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Hitam)\nKategori: Kain Batik Bahan Dobi\nTanggal Penjualan: 2023-07-23\nJumlah Jual: 2\nHarga Potongan: 10000\nHarga Total: 390000\nTanggal Perubahan: 2023-07-23 18:07:51'),
(25, '2023-07-23', 'Admin menambah data pada tabel penjualan:\nID Penjualan: 4\nKode Barang: BP01PM\nNama Pembeli: Manuel john\nNama Barang: Kain Batik Motif Sioföna (Merah)\nKategori: Kain Batik Bahan Prima\nTanggal Penjualan: 2023-07-23\nJumlah Jual: 2\nHarga Potongan: 0\nHarga Total: 340000\nTanggal Perubahan: 2023-07-23 20:51:17'),
(26, '2023-07-23', 'Admin mengedit data pada tabel penjualan:\nID Penjualan: 4\nKode Barang: BP01PM\nNama Pembeli: Manuel\nNama Barang: Kain Batik Motif Sioföna (Merah)\nKategori: Kain Batik Bahan Prima\nTanggal Penjualan: 2023-07-23\nJumlah Jual: 5\nHarga Potongan: 0\nHarga Total: 850000\nTanggal Perubahan: 2023-07-23 20:51:44'),
(27, '2023-07-23', 'Admin menghapus data pada tabel penjualan:\nID Penjualan: 4\nKode Barang: BP01PM\nNama Pembeli: Manuel\nNama Barang: Kain Batik Motif Sioföna (Merah)\nKategori: Kain Batik Bahan Prima\nTanggal Penjualan: 2023-07-23\nJumlah Jual: 5\nHarga Potongan: 0\nHarga Total: 850000\nTanggal Perubahan: 2023-07-23 20:51:57'),
(28, '2023-07-23', 'Admin menambah data pada tabel data barang:\nKode Barang: BP0123\nNama Barang: Kain Batik Motif\nKategori: Kain Batik Bahan Prima\nHarga Modal: 155000\nHarga Satuan: 170000\nTanggal Perubahan: 2023-07-23 20:53:51'),
(29, '2023-07-23', 'Admin mengedit data pada tabel data barang:\nKode Barang: BP0123\nNama Barang: Kain Batik Motif YNF\nKategori: Kain Batik Bahan Prima\nHarga Modal: 155000\nHarga Satuan: 170000\nTanggal Perubahan: 2023-07-23 20:54:14'),
(30, '2023-07-23', 'Admin menghapus data pada tabel data barang:\nKode Barang: BP0123\nNama Barang: Kain Batik Motif YNF\nKategori: Kain Batik Bahan Prima\nHarga Modal: 155000\nHarga Satuan: 170000\nTanggal Perubahan: 2023-07-23 20:54:34'),
(31, '2023-07-23', 'Owner mengedit data pada stok barang:\nKode Barang: BP02DH\nNama Barang: Kain Batik Motif Tanö Niha Kotak Kecil (Hitam)\nJumlah Stok: 15\nTanggal Perubahan: 2023-07-23 20:57:06'),
(32, '2023-07-23', 'Owner menambah data pada tabel pembelian:\nID Pembelian: 2\nKode Barang: BP06PM\nNama Barang: Kain Batik Motif  YNF (Merah)\nTanggal Pembelian: 2023-07-23\nJumlah Beli: 12\nHarga Beli: 150000\nKwitansi: 64bd31ed217de.jpg\nTanggal Perubahan: 2023-07-23 20:58:05'),
(33, '2023-07-23', 'Owner mengedit data pada tabel pembelian:\nID Pembelian: 2\nKode Barang: BP01PM\nNama Barang: Kain Batik Motif Sioföna (Merah)\nTanggal Pembelian: 2023-07-23\nJumlah Beli: 10\nHarga Beli: 150000\nKwitansi: 64bd31ed217de.jpg\nTanggal Perubahan: 2023-07-23 20:58:15'),
(34, '2023-07-23', 'Owner menambah data pada tabel pembelian:\nID Pembelian: 2\nKode Barang: BP01PM\nNama Barang: Kain Batik Motif Sioföna (Merah)\nTanggal Pembelian: 2023-07-23\nJumlah Beli: 10\nHarga Beli: 150000\nKwitansi: 64bd31ed217de.jpg\nTanggal Perubahan: 2023-07-23 20:58:20'),
(35, '2023-07-23', 'Admin menambah data pada tabel penjualan:\nID Penjualan: 5\nKode Barang: BP01PM\nNama Pembeli: Ina Aurel\nNama Barang: Kain Batik Motif Sioföna (Merah)\nKategori: Kain Batik Bahan Prima\nTanggal Penjualan: 2023-07-23\nJumlah Jual: 2\nHarga Potongan: 0\nHarga Total: 340000\nTanggal Perubahan: 2023-07-23 20:59:31'),
(36, '2023-07-23', 'Owner menambah data pada tabel pembelian:\nID Pembelian: 3\nKode Barang: BP01PM\nNama Barang: Kain Batik Motif Sioföna (Merah)\nTanggal Pembelian: 2023-07-23\nJumlah Beli: 10\nHarga Beli: 155000\nKwitansi: 64bd3289c0f3d.jpg\nTanggal Perubahan: 2023-07-23 21:00:41');

-- --------------------------------------------------------

--
-- Table structure for table `stok_barang`
--

CREATE TABLE `stok_barang` (
  `kode_barang` char(6) NOT NULL,
  `jumlah_stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `username` char(15) NOT NULL,
  `password` char(20) NOT NULL,
  `kode_pemulihan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `kode_pemulihan`) VALUES
(1, 'admin', '12345', 102030),
(3, 'owner', '123', 302010);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- Indexes for table `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
