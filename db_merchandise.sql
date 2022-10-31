-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Okt 2022 pada 06.33
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_merchandise`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `adminid` int(11) NOT NULL,
  `emailadmin` varchar(150) NOT NULL,
  `namaadmin` varchar(150) NOT NULL,
  `level` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_admin`
--

INSERT INTO `tbl_admin` (`adminid`, `emailadmin`, `namaadmin`, `level`) VALUES
(2, 'fankdiazizp@gmail.com', 'Fandi Aziz Pratama', 'Admin'),
(4, '202040242@mhs.udb.ac.id', 'FANDI AZIZ PRATAMA', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_transaksioffline`
--

CREATE TABLE `tbl_detail_transaksioffline` (
  `id` int(11) NOT NULL,
  `transofflineid` char(10) NOT NULL,
  `produkid` int(11) NOT NULL,
  `hargajual` int(11) NOT NULL,
  `jml` int(11) NOT NULL,
  `ukuran` varchar(100) DEFAULT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_detail_transaksioffline`
--

INSERT INTO `tbl_detail_transaksioffline` (`id`, `transofflineid`, `produkid`, `hargajual`, `jml`, `ukuran`, `subtotal`) VALUES
(3, '1608220001', 6, 130000, 10, 'L', 1300000),
(4, '1608220001', 14, 1000, 2, NULL, 2000),
(5, '1608220002', 10, 12000, 1, NULL, 12000),
(6, '1608220003', 10, 12000, 1, NULL, 12000),
(7, '1608220004', 6, 130000, 1, 'L', 130000),
(8, '1009220001', 15, 100000, 1, NULL, 100000),
(10, '1009220003', 15, 100000, 1, NULL, 100000),
(11, '1009220004', 10, 10000, 20, 'Kecil', 200000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_transaksionline`
--

CREATE TABLE `tbl_detail_transaksionline` (
  `id` int(11) NOT NULL,
  `pembeliid` int(11) NOT NULL,
  `produkid` int(11) NOT NULL,
  `jml` int(11) NOT NULL,
  `ukuran` varchar(50) DEFAULT NULL,
  `hargajual` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `transonlineid` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_detail_transaksionline`
--

INSERT INTO `tbl_detail_transaksionline` (`id`, `pembeliid`, `produkid`, `jml`, `ukuran`, `hargajual`, `subtotal`, `transonlineid`) VALUES
(15, 2, 10, 1, NULL, 12000, 12000, '1408220005'),
(16, 2, 6, 1, 'L', 130000, 130000, '1408220005'),
(26, 2, 10, 1, NULL, 12000, 12000, '1508220002'),
(27, 2, 10, 1, NULL, 12000, 12000, '1508220002'),
(28, 2, 10, 1, NULL, 12000, 12000, '1508220002'),
(29, 8, 6, 1, 'M', 120000, 120000, '1508220003'),
(30, 2, 6, 1, 'M', 120000, 120000, '1508220004'),
(31, 2, 6, 3, 'L', 130000, 390000, '1608220001'),
(32, 2, 6, 1, 'M', 120000, 120000, '1608220001'),
(33, 2, 6, 1, 'L', 130000, 130000, '1608220002'),
(34, 2, 6, 1, 'M', 120000, 120000, '2008220001'),
(36, 8, 6, 2, 'M', 120000, 240000, '0909220001'),
(37, 8, 10, 2, 'Sangat Besar', 30000, 60000, '0909220002'),
(38, 2, 14, 2, NULL, 1000, 2000, '0909220003'),
(39, 2, 15, 3, NULL, 100000, 300000, '0909220003'),
(40, 2, 15, 1, NULL, 100000, 100000, '0909220004'),
(41, 2, 6, 1, 'L', 130000, 130000, '1009220001'),
(42, 2, 10, 3, 'Sangat Besar', 30000, 90000, '2709220001'),
(43, 2, 10, 1, 'Sangat Besar', 30000, 30000, '2709220002'),
(44, 2, 10, 3, 'Sangat Besar', 30000, 90000, '2909220001'),
(45, 8, 14, 1, NULL, 1000, 1000, '2909220002'),
(46, 2, 6, 1, 'XL', 130000, 130000, '3009220001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_gambar_produk`
--

CREATE TABLE `tbl_gambar_produk` (
  `gambarprodukid` int(11) NOT NULL,
  `gambarproduk` varchar(100) NOT NULL,
  `produkid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_gambar_produk`
--

INSERT INTO `tbl_gambar_produk` (`gambarprodukid`, `gambarproduk`, `produkid`) VALUES
(10, '1658976415_587fbbd085cebb94a70d.png', 6),
(11, '1658976419_2ae092e3963f5fb894b2.png', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_gambar_review`
--

CREATE TABLE `tbl_gambar_review` (
  `id` int(11) NOT NULL,
  `reviewid` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_gambar_review`
--

INSERT INTO `tbl_gambar_review` (`id`, `reviewid`, `gambar`) VALUES
(3, 15, '1662708170_2219dfa8e7043663513d.png'),
(4, 15, '1662708316_d3c45ad3f19ce9317be1.png'),
(7, 32, '1662711457_a9bd500efea21cacd781.png'),
(8, 34, '1662721337_d7b11a476f42ea3bc8ce.png'),
(9, 34, '1662721343_7d55c908d627852d3d7e.png'),
(10, 34, '1662721348_66f7d5828d0b275b8bea.png'),
(16, 33, '1664287259_faa6c37bc8adf6cfb302.png'),
(17, 33, '1664287259_89b1b87065d295daf013.png'),
(19, 33, '1664287533_8c5547f5973640147529.png'),
(25, 39, '1664288178_dd0ad3a5235890cc2a7c.png'),
(27, 39, '1664512512_b4f1162e8ce718017088.png'),
(28, 39, '1664512512_baee63679eb9be8ae741.png'),
(29, 39, '1664512512_0f6503cd1c39c1774e18.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `kategoriid` int(11) NOT NULL,
  `namakategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`kategoriid`, `namakategori`) VALUES
(2, 'PDH'),
(3, 'Stiker'),
(10, 'Aksesoris'),
(11, 'Kebab');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_keranjang`
--

CREATE TABLE `tbl_keranjang` (
  `id` int(11) NOT NULL,
  `pembeliid` int(11) NOT NULL,
  `produkid` int(11) NOT NULL,
  `ukuranprodukid` int(11) DEFAULT NULL,
  `jml` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_keranjang`
--

INSERT INTO `tbl_keranjang` (`id`, `pembeliid`, `produkid`, `ukuranprodukid`, `jml`) VALUES
(89, 2, 10, 19, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pembeli`
--

CREATE TABLE `tbl_pembeli` (
  `pembeliid` int(11) NOT NULL,
  `emailpembeli` varchar(150) NOT NULL,
  `passwordpembeli` varchar(150) DEFAULT NULL,
  `namapembeli` varchar(150) NOT NULL,
  `telppembeli` char(13) DEFAULT NULL,
  `alamatpembeli` text DEFAULT NULL,
  `provinsipembeli` varchar(100) DEFAULT NULL,
  `distrikpembeli` varchar(150) DEFAULT NULL,
  `profilpembeli` varchar(150) DEFAULT NULL,
  `token_daftar` varchar(150) DEFAULT NULL,
  `level` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pembeli`
--

INSERT INTO `tbl_pembeli` (`pembeliid`, `emailpembeli`, `passwordpembeli`, `namapembeli`, `telppembeli`, `alamatpembeli`, `provinsipembeli`, `distrikpembeli`, `profilpembeli`, `token_daftar`, `level`) VALUES
(2, 'andiazizp123@gmail.com', '$2y$10$QN6AgizdPppQulhCt79IaOBx5.mM.8e0MOoGihk05zDHj0o7K9hWS', 'Fandi Aziz P', '089', 'jakarta', '1', '16', NULL, NULL, 'Pembeli'),
(5, '', '', 'Fandi Jeger', '123', NULL, NULL, NULL, NULL, NULL, 'Pembeli'),
(6, '', '', '111', '111', NULL, NULL, NULL, NULL, NULL, 'Pembeli'),
(8, 'fandi.vbnetti20a4@gmail.com', '$2y$10$QN6AgizdPppQulhCt79IaOBx5.mM.8e0MOoGihk05zDHj0o7K9hWS', 'Fandi Aziz Pratama', '0895392518509', 'Banyu harum\r\n', '11', '42', NULL, NULL, 'Pembeli'),
(9, 'jonimaulindar@gmail.com', '$2y$10$QN6AgizdPppQulhCt79IaOBx5.mM.8e0MOoGihk05zDHj0o7K9hWS', 'Fandos', '0895392518500', NULL, NULL, NULL, NULL, NULL, 'Pembeli'),
(11, 'fandi@gmail.com', '$2y$10$QN6AgizdPppQulhCt79IaOBx5.mM.8e0MOoGihk05zDHj0o7K9hWS', 'fandiazzi', '0895', 'jakarta', '1ffds', '16', '11-1664634162.png', NULL, 'pembeli'),
(13, 'fandi.web2ti20a4@gmail.com', '$2y$10$QN6AgizdPppQulhCt79IaOBx5.mM.8e0MOoGihk05zDHj0o7K9hWS', 'Fandi Aziz Pratama 2', '0895392518509', '', '', NULL, NULL, NULL, 'Pembeli'),
(18, 'zkk6264@gmail.com', '$2y$10$v89BHVxOFBnOLVWcfxoIdear4FRjewWA391pgyRsqEaGEWx2A6Zk.', 'Fandikk', NULL, NULL, NULL, NULL, NULL, '7b52009b64fd0a2a49e6d8a939753077792b0554', 'Pembeli');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `produkid` int(11) NOT NULL,
  `tglpost` date NOT NULL,
  `namaproduk` varchar(150) NOT NULL,
  `gambarutama` varchar(100) NOT NULL,
  `kategoriid` int(11) NOT NULL,
  `satuanid` int(11) NOT NULL,
  `deskripsiproduk` text NOT NULL,
  `beratproduk` int(11) NOT NULL,
  `hargaproduk` int(11) NOT NULL,
  `statusproduk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_produk`
--

INSERT INTO `tbl_produk` (`produkid`, `tglpost`, `namaproduk`, `gambarutama`, `kategoriid`, `satuanid`, `deskripsiproduk`, `beratproduk`, `hargaproduk`, `statusproduk`) VALUES
(6, '2022-07-28', 'PDH HMPTI', '1660635171_b4226fd2be14d2d2aa2a.jpg', 2, 1, '<p>Deskrpisi dari hmpti adalah ....</p>', 500, 120000, 1),
(10, '2022-07-28', 'Stiker HMPTI ', '1660635270_3ae61a6f58ba8b449599.png', 3, 1, '<p>tidak ada deskripsi</p>', 10, 12000, 1),
(14, '2022-08-15', 'Produk Apa saja', '1660635215_481d9ba6967b55cc6d4e.png', 11, 7, '<p>fd</p>', 1000, 1000, 1),
(15, '2022-08-20', 'PDH INFORMATIC ENGINEERING', '1660986154_bad527b7facece1bbbb8.jpg', 2, 1, '<p>tidak ada deskripsi</p>', 500, 100000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_review`
--

CREATE TABLE `tbl_review` (
  `reviewid` int(11) NOT NULL,
  `detailtransid` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `review` text NOT NULL,
  `ranting` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_review`
--

INSERT INTO `tbl_review` (`reviewid`, `detailtransid`, `tanggal`, `review`, `ranting`) VALUES
(15, 15, '2022-09-27 21:32:02', 'Mantap produknya sangat indah', 3),
(32, 16, '2022-09-09 22:58:49', 'mantap jiwa', 5),
(33, 33, '2022-09-27 21:00:47', 'Produknya sangat baguss sekalich saya suka dech', 4),
(34, 37, '2022-09-09 15:36:28', 'Produknya sangat keren', 5),
(35, 38, '2022-09-09 22:43:59', 'Bagus Banget Aku suka deh', 5),
(36, 39, '2022-09-09 22:51:10', 'Saya sangat suka', 3),
(37, 40, '2022-09-09 22:57:31', 'Mantap sekali, salam dari maluku', 5),
(39, 41, '2022-09-30 11:35:36', 'sangat bagus sekali, saya ingin segera mencobanya :v', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_satuan`
--

CREATE TABLE `tbl_satuan` (
  `satuanid` int(11) NOT NULL,
  `namasatuan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_satuan`
--

INSERT INTO `tbl_satuan` (`satuanid`, `namasatuan`) VALUES
(1, 'PCS'),
(7, 'Pack');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id` int(11) NOT NULL,
  `namawebsite` varchar(100) NOT NULL,
  `logowebsite` varchar(100) NOT NULL,
  `favicon` varchar(100) NOT NULL,
  `alamattoko` text NOT NULL,
  `provinsi` int(11) NOT NULL,
  `distrik` int(11) NOT NULL,
  `judulcarousel` varchar(150) NOT NULL,
  `gambarcarousel` varchar(150) NOT NULL,
  `deskripsicarousel` text NOT NULL,
  `lokasigmap` text NOT NULL,
  `tentangkami` text NOT NULL,
  `kontak` text NOT NULL,
  `supported` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `namawebsite`, `logowebsite`, `favicon`, `alamattoko`, `provinsi`, `distrik`, `judulcarousel`, `gambarcarousel`, `deskripsicarousel`, `lokasigmap`, `tentangkami`, `kontak`, `supported`) VALUES
(1, 'HMPTI Merchendaice', '1662861202_32ccadb898ea7192fe50.png', '1662826677_d1672639cbb545124452.png', 'Bandardawung, Tawangmangu, Karanganyar', 10, 169, 'PDH INFORMATIC ENGINEERING', '1662826757_4425bae8b837fe1434e0.jpg', 'DAPATKAN KEMEJA PDH TEKNIK INFORMATIKA, SEBAGAI MOTIVASI DAN JATI DIRI ANDA. BURUAN SEBELUM KEHABISAN MASA PRE ORDER!\r\n\r\nttd Fandos Aziz P', 'https://goo.gl/maps/5hqiXTvm23ywHqZa6', 'Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae. mantap<br>', 'andiazizp123@gmail.com#0895392518509#https://www.instagram.com/hmpti.udb', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_support`
--

CREATE TABLE `tbl_support` (
  `supportid` int(11) NOT NULL,
  `supported` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `linkwebsite` text NOT NULL,
  `settingid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_support`
--

INSERT INTO `tbl_support` (`supportid`, `supported`, `gambar`, `linkwebsite`, `settingid`) VALUES
(1, 'Universitas Duta Bangsa', '1662890933_7ad1297dc6c6d40b6489.png', 'https://udb.ac.id/', 1),
(3, 'Bem Fikom UDB', '1662891630_4684483b44583b921e2b.jpg', '', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_temp_transaksioffline`
--

CREATE TABLE `tbl_temp_transaksioffline` (
  `id` int(11) NOT NULL,
  `transofflineid` char(10) NOT NULL,
  `produkid` int(11) NOT NULL,
  `hargajual` int(11) NOT NULL,
  `jml` int(11) NOT NULL,
  `ukuran` varchar(100) DEFAULT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_temp_transaksioffline`
--

INSERT INTO `tbl_temp_transaksioffline` (`id`, `transofflineid`, `produkid`, `hargajual`, `jml`, `ukuran`, `subtotal`) VALUES
(13, '1908220001', 6, 120000, 1, 'M', 120000),
(14, '2208220001', 15, 100000, 1, NULL, 100000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksioffline`
--

CREATE TABLE `tbl_transaksioffline` (
  `transofflineid` char(10) NOT NULL,
  `tgltransaksi` date NOT NULL,
  `namapembeli` varchar(150) NOT NULL,
  `totalbayar` int(11) NOT NULL,
  `dibayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `kasir` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_transaksioffline`
--

INSERT INTO `tbl_transaksioffline` (`transofflineid`, `tgltransaksi`, `namapembeli`, `totalbayar`, `dibayar`, `kembalian`, `kasir`) VALUES
('1009220001', '2022-09-10', 'Fandos', 100000, 100000, 0, 'FANDI AZIZ PRATAMA'),
('1009220003', '2022-09-10', 'Fandi Aziz P', 100000, 100000, 0, 'FANDI AZIZ PRATAMA'),
('1009220004', '2022-09-10', 'Fandi Aziz Pratama', 200000, 200000, 0, 'FANDI AZIZ PRATAMA'),
('1608220001', '2022-08-16', 'Fandos', 1302000, 135000, 0, 'Fandos'),
('1608220002', '2022-08-16', 'totol', 12000, 10000, 0, 'Fandos'),
('1608220003', '2022-08-16', 'Fandi Aziz P', 12000, 50000, 38000, 'Fandos'),
('1608220004', '2022-08-16', 'totol', 130000, 200000, 70000, 'FANDI AZIZ PRATAMA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksionline`
--

CREATE TABLE `tbl_transaksionline` (
  `transonlineid` char(10) NOT NULL,
  `tgltransaksi` datetime NOT NULL,
  `pembeliid` int(11) NOT NULL,
  `alamat` text DEFAULT NULL,
  `noresi` varchar(100) DEFAULT NULL,
  `totalberat` int(11) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `distrik` varchar(100) DEFAULT NULL,
  `tipe` varchar(100) DEFAULT NULL,
  `kodepos` varchar(10) DEFAULT NULL,
  `ekspedisi` varchar(100) DEFAULT NULL,
  `paket` varchar(100) DEFAULT NULL,
  `ongkir` int(11) DEFAULT NULL,
  `estimasi` varchar(50) DEFAULT NULL,
  `totalpembelian` int(11) DEFAULT NULL,
  `payment_type` varchar(100) DEFAULT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `snapToken` text DEFAULT NULL,
  `pdf_url` text DEFAULT NULL,
  `statuspembayaran` varchar(50) DEFAULT NULL,
  `statuspembelian` varchar(50) DEFAULT NULL,
  `totalbayar` int(11) DEFAULT NULL,
  `notelp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_transaksionline`
--

INSERT INTO `tbl_transaksionline` (`transonlineid`, `tgltransaksi`, `pembeliid`, `alamat`, `noresi`, `totalberat`, `provinsi`, `distrik`, `tipe`, `kodepos`, `ekspedisi`, `paket`, `ongkir`, `estimasi`, `totalpembelian`, `payment_type`, `order_id`, `snapToken`, `pdf_url`, `statuspembayaran`, `statuspembelian`, `totalbayar`, `notelp`) VALUES
('0909220001', '2022-09-09 15:29:06', 8, 'Bandardawung', NULL, 1000, 'Jawa Tengah', 'Karanganyar', 'Kabupaten', '57718', 'jne', 'CTC', 6000, '3-6', 240000, 'bank_transfer', '1074518280', '467fabba-49c2-4ca8-9ad7-4c985eff1b15', 'https://app.sandbox.midtrans.com/snap/v1/transactions/467fabba-49c2-4ca8-9ad7-4c985eff1b15/pdf', 'expire', 'gagal', 246000, '0895392518509'),
('0909220002', '2022-09-09 15:30:56', 8, '12', 'JP9848635675', 20, 'Jawa Timur', 'Jombang', 'Kabupaten', '61415', 'jne', 'OKE', 17000, '3-6', 60000, 'bank_transfer', '2055165235', '5e148dd1-fff7-4d95-a8eb-20b28594cae8', 'https://app.sandbox.midtrans.com/snap/v1/transactions/5e148dd1-fff7-4d95-a8eb-20b28594cae8/pdf', 'settlement', 'diterima', 77000, '1234567890123'),
('0909220003', '2022-09-09 22:39:53', 2, 'tawangmangu', 'JP9848635675', 3500, 'Jawa Tengah', 'Karanganyar', 'Kabupaten', '57718', 'jne', 'CTC', 24000, '3-6', 302000, 'bank_transfer', '1013672135', '30190cb9-c50c-414d-9fb6-b44ed804dddb', 'https://app.sandbox.midtrans.com/snap/v1/transactions/30190cb9-c50c-414d-9fb6-b44ed804dddb/pdf', 'settlement', 'diterima', 326000, '123456789012'),
('0909220004', '2022-09-09 22:53:42', 2, 'Langit Ke 7', 'JP9848635675', 500, 'Maluku', 'Ambon', 'Kota', '97222', 'pos', 'Pos Reguler', 56000, '7 HARI', 100000, 'bank_transfer', '2053053002', 'a7b85555-a9c1-4d13-8a8c-6ec0b2fc8c02', 'https://app.sandbox.midtrans.com/snap/v1/transactions/a7b85555-a9c1-4d13-8a8c-6ec0b2fc8c02/pdf', 'settlement', 'diterima', 156000, '123456789012'),
('1009220001', '2022-09-10 10:44:56', 2, 'bandardawung, tawangmangu', 'JP9848635675', 500, 'Jawa Tengah', 'Karanganyar', 'Kabupaten', '57718', 'jne', 'CTC', 6000, '3-6', 130000, 'bank_transfer', '4156199', '40d8ddb8-e539-47e5-a24b-28aeba469be8', 'https://app.sandbox.midtrans.com/snap/v1/transactions/40d8ddb8-e539-47e5-a24b-28aeba469be8/pdf', 'settlement', 'diterima', 136000, '0895392518509'),
('1408220005', '2022-08-14 10:35:30', 2, 'Bandar RT 01/06, Bandardawung, Tawangmangu', 'JP9848635675', 510, 'Jawa Tengah', 'Karanganyar', 'Kabupaten', '57718', 'jne', 'CTC', 6000, '3-6', 142000, 'bank_transfer', '1552828653', '3991b107-abf2-4eb7-8484-ed38c6685894', 'https://app.sandbox.midtrans.com/snap/v1/transactions/3991b107-abf2-4eb7-8484-ed38c6685894/pdf', 'settlement', 'diterima', 148000, '0895392518509'),
('1508220002', '2022-08-15 10:13:28', 2, '12', NULL, 30, 'Kalimantan Tengah', 'Seruyan', 'Kabupaten', '74211', 'jne', 'OKE', 44000, '5-7', 36000, 'bank_transfer', '1183395022', 'b2ce4c15-5b2b-401a-b926-b30604da543c', 'https://app.sandbox.midtrans.com/snap/v1/transactions/b2ce4c15-5b2b-401a-b926-b30604da543c/pdf', 'expire', 'gagal', 80000, '12'),
('1508220003', '2022-08-15 10:14:51', 8, '12', NULL, 500, 'Jawa Tengah', 'Magelang', 'Kota', '56133', 'jne', 'OKE', 8000, '2-3', 120000, 'bank_transfer', '985410736', '87176847-0fbd-47ee-84d1-3e0bec34d9fc', 'https://app.sandbox.midtrans.com/snap/v1/transactions/87176847-0fbd-47ee-84d1-3e0bec34d9fc/pdf', 'expire', 'gagal', 128000, '12'),
('1508220004', '2022-08-15 10:16:25', 2, 'dwsfew', NULL, 500, 'Lampung', 'Way Kanan', 'Kabupaten', '34711', 'tiki', 'ECO', 25000, '5', 120000, 'cstore', '1734548614', '0bb89baa-34bd-4298-87e6-bc2a3a1e68b5', 'https://app.sandbox.midtrans.com/snap/v1/transactions/0bb89baa-34bd-4298-87e6-bc2a3a1e68b5/pdf', 'expire', 'gagal', 145000, '343268'),
('1608220001', '2022-08-16 10:21:32', 2, 'bandardawung, Tawangmangu', NULL, 2000, 'Jawa Tengah', 'Karanganyar', 'Kabupaten', '57718', 'jne', 'CTC', 12000, '3-6', 510000, 'cstore', '141263403', '6d0354d4-ae5a-4047-81ee-1bb21a10bdb6', 'https://app.sandbox.midtrans.com/snap/v1/transactions/6d0354d4-ae5a-4047-81ee-1bb21a10bdb6/pdf', 'expire', 'gagal', 522000, '123'),
('1608220002', '2022-08-16 10:27:09', 2, 'klaten', 'JP9848635675', 500, 'Jawa Tengah', 'Klaten', 'Kabupaten', '57411', 'jne', 'REG', 6000, '3-6', 130000, 'bank_transfer', '1574959274', '74d69633-aa06-49ea-a06e-7509366c5e60', 'https://app.sandbox.midtrans.com/snap/v1/transactions/74d69633-aa06-49ea-a06e-7509366c5e60/pdf', 'settlement', 'diterima', 136000, '123'),
('2008220001', '2022-08-20 10:52:52', 2, 'Bandar RT 01/06, Bandardawung, Tawangmangu', '', 500, 'Jawa Tengah', 'Karanganyar', 'Kabupaten', '57718', 'jne', 'CTC', 6000, '3-6', 120000, 'bank_transfer', '1159620485', '48335c4c-d317-4dc0-a3d8-7846d8bae854', 'https://app.sandbox.midtrans.com/snap/v1/transactions/48335c4c-d317-4dc0-a3d8-7846d8bae854/pdf', 'settlement', 'dikirim', 126000, '0895392518509'),
('2709220001', '2022-09-27 21:51:09', 2, 'Bandardawung', NULL, 30, 'Bangka Belitung', 'Bangka Barat', 'Kabupaten', '33315', 'jne', 'OKE', 38000, '3-6', 90000, 'bank_transfer', '2006854960', 'dc907e33-b299-4d4e-bb3e-e2c7cbc0de1c', 'https://app.sandbox.midtrans.com/snap/v1/transactions/dc907e33-b299-4d4e-bb3e-e2c7cbc0de1c/pdf', 'expire', 'gagal', 128000, '0895391518509'),
('2709220002', '2022-09-27 21:53:50', 2, 'ret', NULL, 10, 'Bali', 'Badung', 'Kabupaten', '80351', 'pos', 'Pos Reguler', 15000, '5 HARI', 30000, 'bank_transfer', '1858748296', 'a45e5a28-8ce6-462e-a857-91d143ad4bfb', 'https://app.sandbox.midtrans.com/snap/v1/transactions/a45e5a28-8ce6-462e-a857-91d143ad4bfb/pdf', 'settlement', 'pending', 45000, '0895392518509'),
('2909220001', '2022-09-29 16:24:31', 2, 'Bandar, Bandardawung, Tawangmangu', NULL, 30, 'Jawa Tengah', 'Semarang', 'Kabupaten', '50511', 'jne', 'REG', 11000, '1-2', 90000, 'bank_transfer', '824156727', 'cf7c6eed-3153-4228-a7c5-27bf0e793cd7', 'https://app.sandbox.midtrans.com/snap/v1/transactions/cf7c6eed-3153-4228-a7c5-27bf0e793cd7/pdf', 'expire', 'gagal', 101000, '0895392518509'),
('2909220002', '2022-09-29 20:34:40', 8, 'Jakarta laut cina utara', NULL, 1000, 'DKI Jakarta', 'Jakarta Barat', 'Kota', '11220', 'pos', 'Pos Nextday', 27000, '1 HARI', 1000, 'bank_transfer', '1288026549', '26c9c8ed-6bc4-4261-a59a-2ceede4f5b75', 'https://app.sandbox.midtrans.com/snap/v1/transactions/26c9c8ed-6bc4-4261-a59a-2ceede4f5b75/pdf', 'pending', 'pending', 28000, '0895392518509'),
('3009220001', '2022-09-30 11:33:19', 2, 'Bandar, Bandardawung, Tawangmangu', NULL, 500, 'Jawa Tengah', 'Semarang', 'Kabupaten', '50511', 'jne', 'REG', 11000, '1-2', 130000, 'bank_transfer', '919927948', '74148f7e-533d-4df7-8a8a-40af3e890a6f', 'https://app.sandbox.midtrans.com/snap/v1/transactions/74148f7e-533d-4df7-8a8a-40af3e890a6f/pdf', 'settlement', 'pending', 141000, '0895392518509');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_ukuran_produk`
--

CREATE TABLE `tbl_ukuran_produk` (
  `ukuranprodukid` int(11) NOT NULL,
  `produkid` int(11) NOT NULL,
  `ukuran` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `hargaproduk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_ukuran_produk`
--

INSERT INTO `tbl_ukuran_produk` (`ukuranprodukid`, `produkid`, `ukuran`, `status`, `hargaproduk`) VALUES
(3, 6, 'M', 1, 120000),
(4, 6, 'L', 1, 130000),
(18, 6, 'XL', 1, 130000),
(19, 10, 'Sangat Besar', 1, 30000),
(20, 10, 'Kecil', 1, 10000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indeks untuk tabel `tbl_detail_transaksioffline`
--
ALTER TABLE `tbl_detail_transaksioffline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produkid` (`produkid`),
  ADD KEY `transofflineid` (`transofflineid`);

--
-- Indeks untuk tabel `tbl_detail_transaksionline`
--
ALTER TABLE `tbl_detail_transaksionline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produkid` (`produkid`),
  ADD KEY `transonlineid` (`transonlineid`);

--
-- Indeks untuk tabel `tbl_gambar_produk`
--
ALTER TABLE `tbl_gambar_produk`
  ADD PRIMARY KEY (`gambarprodukid`),
  ADD KEY `produkid` (`produkid`);

--
-- Indeks untuk tabel `tbl_gambar_review`
--
ALTER TABLE `tbl_gambar_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_gambar_review_ibfk_1` (`reviewid`);

--
-- Indeks untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`kategoriid`);

--
-- Indeks untuk tabel `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produkid` (`produkid`),
  ADD KEY `ukuranprodukid` (`ukuranprodukid`);

--
-- Indeks untuk tabel `tbl_pembeli`
--
ALTER TABLE `tbl_pembeli`
  ADD PRIMARY KEY (`pembeliid`);

--
-- Indeks untuk tabel `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`produkid`),
  ADD KEY `kategoriid` (`kategoriid`),
  ADD KEY `satuanid` (`satuanid`);

--
-- Indeks untuk tabel `tbl_review`
--
ALTER TABLE `tbl_review`
  ADD PRIMARY KEY (`reviewid`),
  ADD KEY `detailtransid` (`detailtransid`);

--
-- Indeks untuk tabel `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  ADD PRIMARY KEY (`satuanid`);

--
-- Indeks untuk tabel `tbl_setting`
--
ALTER TABLE `tbl_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_support`
--
ALTER TABLE `tbl_support`
  ADD PRIMARY KEY (`supportid`);

--
-- Indeks untuk tabel `tbl_temp_transaksioffline`
--
ALTER TABLE `tbl_temp_transaksioffline`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_transaksioffline`
--
ALTER TABLE `tbl_transaksioffline`
  ADD PRIMARY KEY (`transofflineid`);

--
-- Indeks untuk tabel `tbl_transaksionline`
--
ALTER TABLE `tbl_transaksionline`
  ADD PRIMARY KEY (`transonlineid`),
  ADD KEY `pembeliid` (`pembeliid`);

--
-- Indeks untuk tabel `tbl_ukuran_produk`
--
ALTER TABLE `tbl_ukuran_produk`
  ADD PRIMARY KEY (`ukuranprodukid`),
  ADD KEY `produkid` (`produkid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_detail_transaksioffline`
--
ALTER TABLE `tbl_detail_transaksioffline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_detail_transaksionline`
--
ALTER TABLE `tbl_detail_transaksionline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `tbl_gambar_produk`
--
ALTER TABLE `tbl_gambar_produk`
  MODIFY `gambarprodukid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tbl_gambar_review`
--
ALTER TABLE `tbl_gambar_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `kategoriid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT untuk tabel `tbl_pembeli`
--
ALTER TABLE `tbl_pembeli`
  MODIFY `pembeliid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `produkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `reviewid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  MODIFY `satuanid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_support`
--
ALTER TABLE `tbl_support`
  MODIFY `supportid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_temp_transaksioffline`
--
ALTER TABLE `tbl_temp_transaksioffline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tbl_ukuran_produk`
--
ALTER TABLE `tbl_ukuran_produk`
  MODIFY `ukuranprodukid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_detail_transaksioffline`
--
ALTER TABLE `tbl_detail_transaksioffline`
  ADD CONSTRAINT `tbl_detail_transaksioffline_ibfk_1` FOREIGN KEY (`produkid`) REFERENCES `tbl_produk` (`produkid`),
  ADD CONSTRAINT `tbl_detail_transaksioffline_ibfk_2` FOREIGN KEY (`transofflineid`) REFERENCES `tbl_transaksioffline` (`transofflineid`);

--
-- Ketidakleluasaan untuk tabel `tbl_detail_transaksionline`
--
ALTER TABLE `tbl_detail_transaksionline`
  ADD CONSTRAINT `tbl_detail_transaksionline_ibfk_1` FOREIGN KEY (`produkid`) REFERENCES `tbl_produk` (`produkid`),
  ADD CONSTRAINT `tbl_detail_transaksionline_ibfk_2` FOREIGN KEY (`transonlineid`) REFERENCES `tbl_transaksionline` (`transonlineid`);

--
-- Ketidakleluasaan untuk tabel `tbl_gambar_produk`
--
ALTER TABLE `tbl_gambar_produk`
  ADD CONSTRAINT `tbl_gambar_produk_ibfk_1` FOREIGN KEY (`produkid`) REFERENCES `tbl_produk` (`produkid`);

--
-- Ketidakleluasaan untuk tabel `tbl_gambar_review`
--
ALTER TABLE `tbl_gambar_review`
  ADD CONSTRAINT `tbl_gambar_review_ibfk_1` FOREIGN KEY (`reviewid`) REFERENCES `tbl_review` (`reviewid`);

--
-- Ketidakleluasaan untuk tabel `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
  ADD CONSTRAINT `tbl_keranjang_ibfk_1` FOREIGN KEY (`produkid`) REFERENCES `tbl_produk` (`produkid`),
  ADD CONSTRAINT `tbl_keranjang_ibfk_2` FOREIGN KEY (`ukuranprodukid`) REFERENCES `tbl_ukuran_produk` (`ukuranprodukid`);

--
-- Ketidakleluasaan untuk tabel `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD CONSTRAINT `tbl_produk_ibfk_1` FOREIGN KEY (`kategoriid`) REFERENCES `tbl_kategori` (`kategoriid`),
  ADD CONSTRAINT `tbl_produk_ibfk_3` FOREIGN KEY (`satuanid`) REFERENCES `tbl_satuan` (`satuanid`);

--
-- Ketidakleluasaan untuk tabel `tbl_review`
--
ALTER TABLE `tbl_review`
  ADD CONSTRAINT `tbl_review_ibfk_1` FOREIGN KEY (`detailtransid`) REFERENCES `tbl_detail_transaksionline` (`id`);

--
-- Ketidakleluasaan untuk tabel `tbl_transaksionline`
--
ALTER TABLE `tbl_transaksionline`
  ADD CONSTRAINT `tbl_transaksionline_ibfk_1` FOREIGN KEY (`pembeliid`) REFERENCES `tbl_pembeli` (`pembeliid`);

--
-- Ketidakleluasaan untuk tabel `tbl_ukuran_produk`
--
ALTER TABLE `tbl_ukuran_produk`
  ADD CONSTRAINT `tbl_ukuran_produk_ibfk_1` FOREIGN KEY (`produkid`) REFERENCES `tbl_produk` (`produkid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
