-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Okt 2025 pada 08.33
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS gg_mart;
USE gg_mart;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gg_mart`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE  IF NOT EXISTS `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `kode_produk` char(12) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 1,
  `harga_satuan` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `kode_produk`, `jumlah`, `harga_satuan`, `subtotal`) VALUES
(47, 53, NULL, 1, 5000, 5000),
(48, 53, 'PRD_11781317', 1, 10000, 10000),
(49, 53, 'PRD_61487537', 1, 12000, 12000),
(50, 54, 'PRD_29664047', 1, 38000, 38000),
(51, 54, 'PRD_61487537', 1, 12000, 12000),
(52, 54, 'PRD_08202888', 1, 18000, 18000),
(53, 55, 'PRD_11781317', 1, 10000, 10000),
(54, 55, 'PRD_61487537', 1, 12000, 12000),
(55, 55, 'PRD_07112156', 1, 65000, 65000),
(56, 56, NULL, 1, 5000, 5000),
(57, 56, 'PRD_11781317', 1, 10000, 10000),
(58, 56, 'PRD_61487537', 1, 12000, 12000),
(59, 56, 'PRD_07112156', 1, 65000, 65000),
(60, 56, 'PRD_08202888', 1, 18000, 18000),
(61, 56, 'PRD_11189148', 1, 12000, 12000),
(62, 57, NULL, 3, 5000, 15000),
(63, 57, 'PRD_29026232', 3, 45000, 135000),
(64, 57, 'PRD_29664047', 3, 38000, 114000),
(65, 58, 'PRD_61487537', 3, 12000, 36000),
(66, 59, 'PRD_11781317', 3, 10000, 30000),
(67, 60, 'PRD_61336096', 2, 11000, 22000),
(68, 61, 'PRD_11189148', 1, 12000, 12000),
(69, 61, 'PRD_61336096', 1, 11000, 11000),
(70, 62, 'PRD_61487537', 1, 12000, 12000),
(71, 62, 'PRD_11781317', 1, 10000, 10000),
(72, 63, NULL, 1, 5000, 5000),
(73, 63, 'PRD_61336096', 1, 11000, 11000),
(74, 63, 'PRD_08202888', 1, 18000, 18000),
(75, 64, NULL, 2, 5000, 10000),
(76, 64, 'PRD_11781317', 2, 10000, 20000),
(77, 64, 'PRD_61487537', 1, 12000, 12000),
(78, 65, NULL, 1, 5000, 5000),
(79, 65, 'PRD_61487537', 2, 12000, 24000),
(80, 65, 'PRD_11189148', 1, 12000, 12000),
(81, 65, 'PRD_11781317', 1, 10000, 10000),
(82, 66, 'PRD_61336096', 1, 11000, 11000),
(83, 66, NULL, 2, 5000, 10000),
(84, 66, 'PRD_11781317', 1, 10000, 10000),
(85, 67, 'PRD_11781317', 1, 10000, 10000),
(86, 67, 'PRD_61487537', 1, 12000, 12000),
(87, 67, 'PRD_07112156', 1, 65000, 65000),
(88, 68, NULL, 88, 5000, 440000),
(89, 69, NULL, 1, 35000, 35000),
(90, 69, 'PRD_11189148', 1, 12000, 12000),
(91, 70, NULL, 9, 35000, 315000),
(92, 71, 'PRD_10158798', 3, 15000, 45000),
(93, 72, 'PRD_61487537', 7, 12000, 84000),
(94, 72, 'PRD_07112156', 5, 65000, 325000),
(95, 72, 'PRD_08202888', 3, 18000, 54000),
(96, 73, 'PRD_61487537', 7, 12000, 84000),
(97, 73, 'PRD_07112156', 5, 65000, 325000),
(98, 73, 'PRD_08202888', 3, 18000, 54000),
(99, 74, 'PRD_61336096', 1, 11000, 11000),
(100, 75, 'PRD_61487537', 1, 12000, 12000),
(101, 75, NULL, 1, 5000, 5000),
(102, 75, 'PRD_10158798', 3, 15000, 45000),
(103, 75, 'PRD_29026232', 3, 45000, 135000),
(104, 75, 'PRD_11781317', 2, 10000, 20000),
(105, 75, 'PRD_08202888', 1, 18000, 18000),
(106, 75, 'PRD_11189148', 3, 12000, 36000),
(107, 75, 'PRD_61336096', 1, 11000, 11000),
(108, 76, 'PRD_61336096', 1, 11000, 11000),
(109, 77, 'PRD_11189148', 1, 12000, 12000),
(110, 78, NULL, 1, 5000, 5000),
(111, 79, 'PRD_11781317', 1, 10000, 10000),
(112, 80, 'PRD_11781317', 1, 10000, 10000),
(113, 81, 'PRD_11781317', 1, 10000, 10000),
(114, 82, 'PRD_11781317', 1, 10000, 10000),
(115, 83, 'PRD_11781317', 1, 10000, 10000),
(116, 84, 'PRD_11781317', 1, 10000, 10000),
(117, 85, 'PRD_10158798', 14, 15000, 210000),
(118, 86, NULL, 2, 5000, 10000),
(119, 87, 'PRD_10158798', 2, 15000, 30000),
(120, 88, 'PRD_11781317', 1, 10000, 10000),
(121, 88, 'PRD_10158798', 2, 15000, 30000),
(122, 89, 'PRD_29026232', 2, 45000, 90000),
(123, 90, 'PRD_11781317', 2, 10000, 20000),
(124, 91, 'PRD_11781317', 1, 10000, 10000),
(125, 91, 'PRD_07112156', 1, 65000, 65000),
(126, 92, 'PRD_29026232', 2, 45000, 90000),
(127, 93, 'PRD_10158798', 1, 15000, 15000),
(128, 94, 'PRD_29026232', 1, 45000, 45000),
(129, 95, 'PRD_07112156', 2, 65000, 130000),
(130, 96, 'PRD_29026232', 1, 45000, 45000),
(131, 96, 'PRD_07112156', 1, 65000, 65000),
(132, 97, NULL, 1, 5000, 5000),
(133, 97, 'PRD_10158798', 2, 15000, 30000),
(134, 97, 'PRD_29026232', 3, 45000, 135000),
(135, 98, 'PRD_10158798', 21, 15000, 315000),
(136, 98, NULL, 5, 5000, 25000),
(137, 99, 'PRD_29026232', 2, 45000, 90000),
(138, 99, 'PRD_07112156', 2, 65000, 130000),
(139, 99, 'PRD_08202888', 2, 18000, 36000),
(140, 99, 'PRD_61336096', 2, 11000, 22000),
(141, 99, 'PRD_10158798', 2, 15000, 30000),
(142, 99, 'PRD_11781317', 1, 10000, 10000),
(143, 99, 'PRD_61487537', 1, 12000, 12000),
(144, 100, 'PRD_08202888', 1, 18000, 18000),
(145, 100, 'PRD_61487537', 1, 12000, 12000),
(146, 100, 'PRD_61336096', 1, 11000, 11000),
(147, 101, 'PRD_29026232', 1, 45000, 45000),
(148, 101, 'PRD_08202888', 1, 18000, 18000),
(149, 101, 'PRD_61336096', 1, 11000, 11000),
(150, 102, 'PRD_10158798', 1, 15000, 15000),
(151, 102, 'PRD_29026232', 1, 45000, 45000),
(152, 102, 'PRD_07112156', 1, 65000, 65000),
(153, 102, 'PRD_08202888', 1, 18000, 18000),
(154, 103, 'PRD_61336096', 1, 11000, 11000),
(155, 103, 'PRD_08202888', 1, 18000, 18000),
(156, 104, 'PRD_29026232', 1, 45000, 45000),
(157, 104, 'PRD_10158798', 1, 15000, 15000),
(158, 105, 'PRD_29026232', 1, 45000, 45000),
(159, 105, 'PRD_10158798', 1, 15000, 15000),
(160, 106, 'PRD_29026232', 1, 45000, 45000),
(161, 106, 'PRD_10158798', 1, 15000, 15000),
(162, 107, 'PRD_29026232', 1, 45000, 45000),
(163, 107, 'PRD_10158798', 1, 15000, 15000),
(164, 108, 'PRD_10158798', 2, 15000, 30000),
(165, 109, 'PRD_27765129', 1, 40000, 40000),
(166, 110, 'PRD_27765129', 1, 40000, 40000),
(167, 111, 'PRD_10158798', 3, 15000, 45000),
(168, 112, 'PRD_29026232', 1, 45000, 45000),
(169, 113, 'PRD_61487537', 1, 12000, 12000),
(170, 113, 'PRD_27765129', 1, 40000, 40000),
(171, 114, 'PRD_10158798', 1, 15000, 15000),
(172, 115, 'PRD_10158798', 1, 15000, 15000),
(173, 115, 'PRD_27765129', 1, 40000, 40000),
(174, 116, 'PRD_61487537', 1, 12000, 12000),
(175, 116, 'PRD_27765129', 1, 40000, 40000),
(176, 116, 'PRD_10158798', 1, 15000, 15000),
(177, 116, 'PRD_29026232', 1, 45000, 45000),
(178, 116, 'PRD_07112156', 1, 65000, 65000),
(179, 117, 'PRD_10158798', 1, 15000, 15000),
(180, 117, 'PRD_29026232', 1, 45000, 45000),
(181, 117, 'PRD_27765129', 1, 40000, 40000),
(182, 118, 'PRD_61487537', 1, 12000, 12000),
(183, 118, 'PRD_11781317', 1, 10000, 10000),
(184, 118, 'PRD_27765129', 1, 40000, 40000),
(185, 119, 'PRD_29026232', 2, 45000, 90000),
(186, 119, 'PRD_27765129', 1, 40000, 40000),
(187, 120, 'PRD_11781317', 1, 10000, 10000),
(188, 121, 'PRD_61336096', 1, 11000, 11000),
(189, 122, 'PRD_27765129', 1, 40000, 40000),
(190, 122, 'PRD_29026232', 1, 45000, 45000),
(191, 123, 'PRD_08202888', 1, 18000, 18000),
(192, 123, 'PRD_07112156', 1, 65000, 65000),
(193, 124, 'PRD_11189148', 1, 12000, 12000),
(194, 125, 'PRD_10158798', 1, 15000, 15000),
(195, 125, 'PRD_08202888', 1, 18000, 18000),
(196, 126, 'PRD_29664047', 1, 38000, 38000),
(197, 126, 'PRD_07112156', 1, 65000, 65000),
(198, 126, 'PRD_08202888', 1, 18000, 18000),
(221, 138, 'PRD_61336096', 1, 11000, 11000),
(222, 138, 'PRD_11189148', 1, 12000, 12000),
(223, 138, 'PRD_29026232', 1, 45000, 45000),
(224, 138, 'PRD_11781317', 40, 10000, 400000),
(225, 139, 'PRD_11781317', 7, 10000, 70000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE  IF NOT EXISTS `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(12, 'Sembako', 'Berbagai kebutuhan pokok rumah tangga seperti beras, gula, minyak goreng, tepung, dan garam.'),
(13, 'Minuman', 'Aneka minuman kemasan seperti air mineral, teh, kopi, dan minuman ringan.'),
(14, 'Snack & Cemilan', 'Camilan kering maupun basah seperti keripik, biskuit, kacang, dan kue kering.'),
(15, 'Bumbu Dapur', 'Bumbu masak instan, rempah-rempah, saus, kecap, dan penyedap rasa.'),
(16, 'Produk Susu & Olahan', 'Susu cair, susu bubuk, keju, yogurt, dan margarin.'),
(17, 'Sayur & Buah Segar', 'Aneka sayuran dan buah segar hasil petani lokal.'),
(18, 'Daging & Ikan', 'Produk protein hewani seperti ayam, sapi, dan ikan segar maupun beku.'),
(19, 'Makanan Instan', 'Mie instan, bubur instan, sarden, dan makanan siap saji lainnya.'),
(20, 'Kebutuhan Rumah Tangga', 'Barang harian seperti sabun, deterjen, tisu, dan alat kebersihan.'),
(21, 'Produk Lokal GMIT', 'Produk hasil jemaat dan UMKM binaan GMIT seperti madu, keripik pisang, kopi lokal, dan olahan pangan khas daerah. ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE  IF NOT EXISTS `produk` (
  `kode_produk` char(12) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `terjual` int(11) DEFAULT 0,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`kode_produk`, `id_kategori`, `nama_produk`, `deskripsi`, `harga`, `stok`, `terjual`, `gambar`, `tanggal_dibuat`) VALUES
('PRD_07112156', 12, 'Beras Premium 5kg', 'Beras putih pilihan dengan kualitas super, pulen dan harum. Cocok untuk konsumsi harian.', 65000, 26, 24, 'PRD_07112156249.jpg', '2025-10-13 21:05:11'),
('PRD_08202888', 12, 'Minyak Goreng Bimoli 1L', 'Minyak goreng sawit berkualitas tinggi, jernih dan tahan panas.', 18000, 47, 33, 'PRD_08202888147.jpg', '2025-10-13 21:07:00'),
('PRD_10158798', 13, 'Kopi Kapal Api Special Mix', 'Kopi robusta dengan rasa dan aroma khas Indonesia', 15000, 185, 106, 'PRD_10158798591.jpg', '2025-10-13 21:10:15'),
('PRD_11189148', 21, 'Keripik Singkong Pedas', 'Camilan renyah dengan rasa pedas gurih khas Indonesia.', 12000, 47, 13, 'PRD_11189148185.png', '2025-10-13 21:11:58'),
('PRD_11781317', 14, 'Biskuit Roma Kelapa', 'Biskuit klasik dengan rasa kelapa yang gurih dan nikmat.', 10000, 300, 75, 'PRD_11781317937.jpg', '2025-10-13 21:12:58'),
('PRD_27765129', 21, 'Kopi Bubuk Soe Asli 200g', 'Kopi bubuk khas Soe hasil produksi jemaat lokal GMIT.', 40000, 90, 40, 'PRD_27765129700.jpg', '2025-10-13 21:39:36'),
('PRD_29026232', 21, 'Madu Hutan Timor 250ml', 'Madu alami hasil hutan Timor, tanpa campuran dan pengawet.', 45000, 71, 54, 'PRD_29026232656.jpg', '2025-10-13 21:41:42'),
('PRD_29664047', 18, 'Daging Ayam Broiler 1kg', 'Daging ayam segar tanpa lemak berlebih, siap dimasak.', 38000, 98, 27, 'PRD_29664047.jpg', '2025-10-13 21:42:46'),
('PRD_61336096', 20, 'Saus Sambal ABC 275ml', 'Saus sambal pedas nikmat untuk pelengkap hidangan.', 11000, 24, 21, 'PRD_61336096655.jpg', '2025-10-13 21:15:36'),
('PRD_61487537', 20, 'Kecap Manis Bango 135ml', 'Kecap manis legendaris dengan rasa gurih dan manis seimbang.', 12000, 24, 36, 'PRD_61487537835.jpg', '2025-10-13 21:18:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE  IF NOT EXISTS `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal_transaksi` datetime DEFAULT current_timestamp(),
  `total_harga` int(11) NOT NULL,
  `status` enum('pending','diproses','dikirim','selesai','batal') DEFAULT 'pending',
  `kode_transaksi` char(15) DEFAULT NULL,
  `metode_bayar` enum('QRIS','TUNAI') DEFAULT 'TUNAI'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `tanggal_transaksi`, `total_harga`, `status`, `kode_transaksi`, `metode_bayar`) VALUES
(53, 1, '2025-10-14 00:24:26', 27000, 'pending', 'TRX_26665476539', 'TUNAI'),
(54, 1, '2025-10-14 00:59:49', 68000, 'pending', 'TRX_47898611238', 'TUNAI'),
(55, 1, '2025-10-14 00:59:54', 87000, 'pending', 'TRX_47945876105', 'TUNAI'),
(56, 1, '2025-10-14 00:59:59', 122000, 'pending', 'TRX_47995474912', 'TUNAI'),
(57, 1, '2025-10-14 01:00:07', 264000, 'pending', 'TRX_48079785819', 'TUNAI'),
(58, 1, '2025-10-14 01:00:12', 36000, 'pending', 'TRX_48121599165', 'TUNAI'),
(59, 1, '2025-10-14 01:01:18', 30000, 'pending', 'TRX_48788403493', 'QRIS'),
(60, 1, '2025-10-14 01:01:25', 22000, 'pending', 'TRX_48855032898', 'QRIS'),
(61, 1, '2025-10-14 01:01:29', 23000, 'pending', 'TRX_48892212639', 'QRIS'),
(62, 1, '2025-10-14 01:01:32', 22000, 'pending', 'TRX_48922656417', 'QRIS'),
(63, 1, '2025-10-14 01:01:36', 34000, 'pending', 'TRX_48965289589', 'QRIS'),
(64, 1, '2025-10-14 01:36:27', 42000, 'pending', 'TRX_69876074654', 'QRIS'),
(65, 1, '2025-10-14 01:46:20', 51000, 'pending', 'TRX_77580223761', 'QRIS'),
(66, 1, '2025-10-14 01:53:50', 31000, 'pending', 'TRX_80308729782', 'QRIS'),
(67, 1, '2025-10-14 01:54:29', 87000, 'pending', 'TRX_80693839323', 'TUNAI'),
(68, 1, '2025-10-14 01:54:40', 440000, 'pending', 'TRX_80803093642', 'TUNAI'),
(69, 1, '2025-10-14 02:42:30', 47000, 'pending', 'TRX_09506641456', 'QRIS'),
(70, 1, '2025-10-14 02:45:07', 315000, 'pending', 'TRX_11079778306', 'QRIS'),
(71, 1, '2025-10-14 02:46:54', 45000, 'pending', 'TRX_81214978752', 'QRIS'),
(72, 1, '2025-10-14 02:50:01', 463000, 'pending', 'TRX_14011289597', 'QRIS'),
(73, 1, '2025-10-14 02:50:01', 463000, 'pending', 'TRX_14012138175', 'QRIS'),
(74, 1, '2025-10-14 02:50:13', 11000, 'pending', 'TRX_14138131389', 'QRIS'),
(75, 1, '2025-10-14 02:51:27', 282000, 'pending', 'TRX_14877047612', 'TUNAI'),
(76, 1, '2025-10-14 02:51:31', 11000, 'pending', 'TRX_14916496784', 'QRIS'),
(77, 1, '2025-10-14 02:51:36', 12000, 'pending', 'TRX_14963382419', 'QRIS'),
(78, 1, '2025-10-14 08:28:51', 5000, 'pending', 'TRX_17316778101', 'QRIS'),
(79, 1, '2025-10-14 08:29:04', 10000, 'pending', 'TRX_17449377284', 'QRIS'),
(80, 1, '2025-10-14 08:30:01', 10000, 'pending', 'TRX_18010147887', 'TUNAI'),
(81, 1, '2025-10-14 08:30:07', 10000, 'pending', 'TRX_18074954880', 'TUNAI'),
(82, 1, '2025-10-14 08:30:13', 10000, 'pending', 'TRX_18135008616', 'TUNAI'),
(83, 1, '2025-10-14 08:30:16', 10000, 'pending', 'TRX_18169441378', 'TUNAI'),
(84, 1, '2025-10-14 08:30:39', 10000, 'pending', 'TRX_18393297318', 'TUNAI'),
(85, 1, '2025-10-14 11:30:13', 210000, 'pending', 'TRX_26138634493', 'QRIS'),
(86, 1, '2025-10-14 13:25:27', 10000, 'pending', 'TRX_95278926545', 'QRIS'),
(87, 1, '2025-10-14 13:27:28', 30000, 'pending', 'TRX_96489866653', 'QRIS'),
(88, 1, '2025-10-14 13:27:33', 40000, 'pending', 'TRX_96537074948', 'TUNAI'),
(89, 1, '2025-10-14 13:27:59', 90000, 'pending', 'TRX_96798016218', 'TUNAI'),
(90, 1, '2025-10-14 13:29:00', 20000, 'pending', 'TRX_97405634139', 'QRIS'),
(91, 1, '2025-10-14 13:29:04', 75000, 'pending', 'TRX_97447981374', 'TUNAI'),
(92, 1, '2025-10-14 13:29:51', 90000, 'pending', 'TRX_97914003570', 'TUNAI'),
(93, 1, '2025-10-14 13:30:02', 15000, 'pending', 'TRX_41980207743', 'TUNAI'),
(94, 1, '2025-10-14 13:30:06', 45000, 'pending', 'TRX_98067135264', 'TUNAI'),
(95, 1, '2025-10-14 13:30:17', 130000, 'pending', 'TRX_98170717855', 'TUNAI'),
(96, 1, '2025-10-14 13:30:33', 110000, 'pending', 'TRX_98338396246', 'TUNAI'),
(97, 1, '2025-10-14 13:31:25', 170000, 'pending', 'TRX_98856746452', 'QRIS'),
(98, 1, '2025-10-14 14:57:58', 340000, 'pending', 'TRX_50785623284', 'TUNAI'),
(99, 1, '2025-10-14 15:16:06', 330000, 'pending', 'TRX_26166206168', 'QRIS'),
(100, 1, '2025-10-14 15:16:12', 41000, 'pending', 'TRX_42617275749', 'TUNAI'),
(101, 1, '2025-10-14 15:18:07', 74000, 'pending', 'TRX_62874164190', 'QRIS'),
(102, 1, '2025-10-14 15:18:15', 143000, 'pending', 'TRX_62953968344', 'QRIS'),
(103, 1, '2025-10-14 15:24:34', 29000, 'pending', 'TRX_66746743615', 'QRIS'),
(104, 1, '2025-10-14 16:12:05', 60000, 'pending', 'TRX_95252352934', 'TUNAI'),
(105, 1, '2025-10-14 16:12:07', 60000, 'pending', 'TRX_95270889665', 'TUNAI'),
(106, 1, '2025-10-14 16:12:07', 60000, 'pending', 'TRX_29527487167', 'TUNAI'),
(107, 1, '2025-10-14 16:12:07', 60000, 'pending', 'TRX_95277163391', 'TUNAI'),
(108, 1, '2025-10-14 16:12:14', 30000, 'pending', 'TRX_29534417787', 'TUNAI'),
(109, 1, '2025-10-14 16:12:44', 40000, 'pending', 'TRX_29564541802', 'TUNAI'),
(110, 1, '2025-10-14 16:13:18', 40000, 'pending', 'TRX_95988681200', 'TUNAI'),
(111, 1, '2025-10-14 16:13:54', 45000, 'pending', 'TRX_96340801121', 'TUNAI'),
(112, 1, '2025-10-14 16:14:54', 45000, 'pending', 'TRX_96942286703', 'TUNAI'),
(113, 1, '2025-10-14 16:19:30', 52000, 'pending', 'TRX_99708468559', 'TUNAI'),
(114, 1, '2025-10-14 16:23:19', 15000, 'pending', 'TRX_01996168396', 'TUNAI'),
(115, 1, '2025-10-15 13:58:50', 55000, 'pending', 'TRX_79300467755', 'TUNAI'),
(116, 1, '2025-10-15 15:08:20', 177000, 'pending', 'TRX_21002136728', 'QRIS'),
(117, 1, '2025-10-15 15:17:40', 100000, 'pending', 'TRX_26608458999', 'QRIS'),
(118, 1, '2025-10-15 15:17:46', 62000, 'pending', 'TRX_26660081452', 'TUNAI'),
(119, 1, '2025-10-15 15:23:29', 130000, 'pending', 'TRX_13009684780', 'TUNAI'),
(120, 1, '2025-10-15 15:23:31', 10000, 'pending', 'TRX_30119679581', 'TUNAI'),
(121, 1, '2025-10-15 15:23:34', 11000, 'pending', 'TRX_30142415763', 'TUNAI'),
(122, 1, '2025-10-15 15:23:36', 85000, 'pending', 'TRX_30165779603', 'TUNAI'),
(123, 1, '2025-10-15 15:23:38', 83000, 'pending', 'TRX_30188607427', 'TUNAI'),
(124, 1, '2025-10-15 15:23:41', 12000, 'pending', 'TRX_30213526373', 'TUNAI'),
(125, 1, '2025-10-15 15:23:44', 33000, 'pending', 'TRX_30241197563', 'TUNAI'),
(126, 1, '2025-10-15 15:23:46', 121000, 'pending', 'TRX_30266436622', 'TUNAI'),
(138, 1, '2025-10-15 20:39:08', 468000, 'pending', 'TRX_19485845505', 'TUNAI'),
(139, 1, '2025-10-15 20:39:17', 70000, 'pending', 'TRX_19571041421', 'TUNAI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE  IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `tanggal_dibuat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `password`, `role`, `tanggal_dibuat`) VALUES
(1, 'stiven', 'stivenadu01@gmail.com', '$2y$10$.dQPTxottxQYUeLXg2Pgi.ffiCHHYdQCVn0mDomQXy0pdMhr8F2d.', 'admin', '2025-10-11 14:01:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_detail_transaksi` (`id_transaksi`),
  ADD KEY `fk_detail_produk` (`kode_produk`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kode_produk`),
  ADD KEY `fk_produk_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `fk_transaksi_user` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `fk_detail_produk` FOREIGN KEY (`kode_produk`) REFERENCES `produk` (`kode_produk`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `fk_produk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
