-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.20 - Source distribution
-- Server OS:                    Linux
-- HeidiSQL Version:             9.1.0.4886
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for 1368
CREATE DATABASE IF NOT EXISTS `1368` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `1368`;


-- Dumping structure for table 1368.1368_sessions
CREATE TABLE IF NOT EXISTS `1368_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  `prevent_update` int(10) DEFAULT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.1368_sessions: ~6 rows (approximately)
DELETE FROM `1368_sessions`;
/*!40000 ALTER TABLE `1368_sessions` DISABLE KEYS */;
INSERT INTO `1368_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`, `prevent_update`) VALUES
	('1f5f1e8c1757fa17742b7ec46b8759ad', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36', 1421848842, 'a:7:{s:9:"user_data";s:0:"";s:6:"userid";s:1:"2";s:12:"nama_lengkap";s:7:"manager";s:8:"username";s:7:"manager";s:5:"email";s:17:"manager@gmail.com";s:5:"level";s:7:"manager";s:10:"akses_menu";s:50:"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20";}', NULL),
	('21ea0231e1971bd612f6de6ead8ea341', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:35.0) Gecko/20100101 Firefox/35.0', 1422243772, '', NULL),
	('dff509e64f431fea3429f81c3b5afecd', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.91 Safari/537.36', 1422374239, '', NULL),
	('f3953b9b80f8d4dce4ee7579006ec01b', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:35.0) Gecko/20100101 Firefox/35.0', 1422243772, '', NULL),
	('f7a923ecb4fcde5be9e37e4b0da56447', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:34.0) Gecko/20100101 Firefox/34.0', 1421554011, 'a:7:{s:9:"user_data";s:0:"";s:6:"userid";s:1:"2";s:12:"nama_lengkap";s:7:"manager";s:8:"username";s:7:"manager";s:5:"email";s:17:"manager@gmail.com";s:5:"level";s:7:"manager";s:10:"akses_menu";s:50:"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20";}', NULL),
	('f8371844c6fe70e08a65726068056bda', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:35.0) Gecko/20100101 Firefox/35.0', 1422406305, '', NULL);
/*!40000 ALTER TABLE `1368_sessions` ENABLE KEYS */;


-- Dumping structure for procedure 1368.proc_update_stok_from_penjualan
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_update_stok_from_penjualan`(IN `in_tipe` INT, IN `in_id_produk` INT, IN `in_kuantitas` INT)
BEGIN
 	DECLARE done INT;	
 	DECLARE v_id_bahan_mentah INT;
 	DECLARE v_kuantitas INT;
 	
 	DECLARE cur1 CURSOR FOR
 		SELECT id_bahan_mentah,kuantitas 
		FROM tbl_produk_assemble
 		WHERE id_produk = in_id_produk;
 	
	DECLARE CONTINUE HANDLER FOR NOT found SET done=1;	
	OPEN cur1;   
	mainloop:LOOP 
		FETCH cur1 INTO v_id_bahan_mentah,v_kuantitas;
   	IF done = 1 THEN LEAVE mainloop; END IF; 
   	
   	/*jika disetujui*/
   	IF(in_tipe = '1') THEN
   		INSERT IGNORE tbl_stok(id_bahan_mentah,stok) VALUES(v_id_bahan_mentah,-(v_kuantitas * in_kuantitas))
   		ON DUPLICATE KEY UPDATE stok = stok - (v_kuantitas * in_kuantitas);
   	END IF;
	
	END LOOP mainloop;
	CLOSE cur1;
END//
DELIMITER ;


-- Dumping structure for table 1368.tbl_bahan_mentah
CREATE TABLE IF NOT EXISTS `tbl_bahan_mentah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_bahan` varchar(50) DEFAULT NULL,
  `deskripsi` varchar(50) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `hrg_terakhir` double NOT NULL DEFAULT '0',
  `terhapus` enum('Y','N') DEFAULT 'N',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_bahan_mentah: ~7 rows (approximately)
DELETE FROM `tbl_bahan_mentah`;
/*!40000 ALTER TABLE `tbl_bahan_mentah` DISABLE KEYS */;
INSERT INTO `tbl_bahan_mentah` (`id`, `kode_bahan`, `deskripsi`, `id_satuan`, `hrg_terakhir`, `terhapus`, `updated_at`) VALUES
	(1, 'UDANG 001', 'UDANG JENIS A UKURAN A', 1, 300000, 'N', '2015-01-23 12:51:15'),
	(2, 'UDANG 002', 'UDANG JENIS B UKURAN B', 1, 0, 'N', '2015-01-14 09:09:32'),
	(3, 'UDANG 003', 'UDANG JENIS C UKURAN C', 1, 0, 'N', '2015-01-23 16:57:00'),
	(4, 'PLASTIK 001 BRAND AA', 'PLASTIK JENIS A BRAND AA', 2, 0, 'N', '2015-01-17 10:01:51'),
	(5, 'PLASTIK 002 BRAND BB', 'PLASTIK JENIS B BRAND BB', 2, 0, 'N', '2015-01-14 09:09:36'),
	(6, 'DUS 001', 'DUS 5KG', 2, 0, 'N', '2015-01-14 09:09:41'),
	(7, 'DUS 002', 'DUS 10KG', 2, 0, 'N', '2015-01-14 09:09:43'),
	(8, 'xxxx', 'xxxxx', 1, 0, 'Y', '2015-01-23 16:56:10');
/*!40000 ALTER TABLE `tbl_bahan_mentah` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_brg_keluar
CREATE TABLE IF NOT EXISTS `tbl_brg_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_penjualan` varchar(50) DEFAULT NULL,
  `kode_keluar` varchar(50) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `pemeriksa` varchar(50) DEFAULT NULL,
  `keterangan` text,
  `terhapus` enum('Y','N') DEFAULT 'N',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_brg_keluar: ~0 rows (approximately)
DELETE FROM `tbl_brg_keluar`;
/*!40000 ALTER TABLE `tbl_brg_keluar` DISABLE KEYS */;
INSERT INTO `tbl_brg_keluar` (`id`, `kode_penjualan`, `kode_keluar`, `tgl`, `id_user`, `pemeriksa`, `keterangan`, `terhapus`, `update_at`) VALUES
	(1, 'SO-000001', 'WO-000001', '2015-01-20', 2, 'bpk joni', '', 'N', '2015-01-20 00:18:12');
/*!40000 ALTER TABLE `tbl_brg_keluar` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_brg_keluar_details
CREATE TABLE IF NOT EXISTS `tbl_brg_keluar_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_brg_keluar` int(11) NOT NULL DEFAULT '0',
  `id_produk` int(11) DEFAULT NULL,
  `keadaan` enum('matang','mentah') DEFAULT 'mentah',
  `kuantitas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_brg_keluar_details: ~0 rows (approximately)
DELETE FROM `tbl_brg_keluar_details`;
/*!40000 ALTER TABLE `tbl_brg_keluar_details` DISABLE KEYS */;
INSERT INTO `tbl_brg_keluar_details` (`id`, `id_brg_keluar`, `id_produk`, `keadaan`, `kuantitas`) VALUES
	(1, 1, 1, 'matang', 10);
/*!40000 ALTER TABLE `tbl_brg_keluar_details` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_brg_masuk
CREATE TABLE IF NOT EXISTS `tbl_brg_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pembelian` varchar(50) DEFAULT NULL,
  `kode_masuk` varchar(50) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `pemeriksa` varchar(50) DEFAULT NULL,
  `keterangan` text,
  `terhapus` enum('Y','N') DEFAULT 'N',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_brg_masuk: ~1 rows (approximately)
DELETE FROM `tbl_brg_masuk`;
/*!40000 ALTER TABLE `tbl_brg_masuk` DISABLE KEYS */;
INSERT INTO `tbl_brg_masuk` (`id`, `kode_pembelian`, `kode_masuk`, `tgl`, `id_user`, `pemeriksa`, `keterangan`, `terhapus`, `update_at`) VALUES
	(1, 'PO-000001', 'WI-000001', '2015-01-20', 2, 'bpk joni', '', 'N', '2015-01-20 00:17:28');
/*!40000 ALTER TABLE `tbl_brg_masuk` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_brg_masuk_details
CREATE TABLE IF NOT EXISTS `tbl_brg_masuk_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_brg_masuk` int(11) DEFAULT NULL,
  `id_bahan_mentah` int(11) NOT NULL,
  `kuantitas` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_brg_masuk_details: ~1 rows (approximately)
DELETE FROM `tbl_brg_masuk_details`;
/*!40000 ALTER TABLE `tbl_brg_masuk_details` DISABLE KEYS */;
INSERT INTO `tbl_brg_masuk_details` (`id`, `id_brg_masuk`, `id_bahan_mentah`, `kuantitas`, `updated_at`) VALUES
	(1, 1, 1, 50, '2015-01-20 00:17:28');
/*!40000 ALTER TABLE `tbl_brg_masuk_details` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_konsumen
CREATE TABLE IF NOT EXISTS `tbl_konsumen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `kantor` text NOT NULL,
  `gudang` text NOT NULL,
  `cp_nama` varchar(50) NOT NULL,
  `cp_telp` varchar(50) NOT NULL,
  `cp_email` varchar(50) NOT NULL,
  `cp_jabatan` varchar(50) NOT NULL,
  `terhapus` enum('Y','N') DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_konsumen: ~1 rows (approximately)
DELETE FROM `tbl_konsumen`;
/*!40000 ALTER TABLE `tbl_konsumen` DISABLE KEYS */;
INSERT INTO `tbl_konsumen` (`id`, `nama`, `kantor`, `gudang`, `cp_nama`, `cp_telp`, `cp_email`, `cp_jabatan`, `terhapus`, `updated_at`) VALUES
	(1, 'PT.Pembeli 1', 'Jl.xxxx xxxxx xxxxxxx\nxxxxxxxxx\nxxxxxxxxxxxxxxxxxxxxx', 'Jl.xxxx xxxxx xxxxxxx\nxxxxxxxxx\nxxxxxxxxxxxxxxxxxxxxx', 'cp buyer 1', 'cp telp buyer 1', 'xx@gmail.com', 'cp jabatan buyer 1', 'N', '2015-01-14 08:58:48');
/*!40000 ALTER TABLE `tbl_konsumen` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_menu
CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `id` int(11) NOT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `url_bawah` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_menu: ~20 rows (approximately)
DELETE FROM `tbl_menu`;
/*!40000 ALTER TABLE `tbl_menu` DISABLE KEYS */;
INSERT INTO `tbl_menu` (`id`, `id_parent`, `nama`, `url`, `url_bawah`, `icon`) VALUES
	(1, 0, 'Master Data', '#', 'data/index', 'fa-briefcase'),
	(3, 1, 'Data Konsumen', 'data/konsumen', 'data/konsumen', 'fa-bars'),
	(2, 1, 'Data User', 'data/user', 'data/user', 'fa-bars'),
	(4, 1, 'Data Supplier', 'data/supplier', 'data/supplier', 'fa-bars'),
	(7, 0, 'Penjualan', 'transaksi/penjualan', 'transaksi/penjualan', 'fa-hand-o-left'),
	(8, 0, 'Pembelian', 'transaksi/pembelian', 'transaksi/pembelian', 'fa-hand-o-right'),
	(12, 9, 'Stok Opname', 'barang/stok_opname', 'barang/stok_opname', 'fa-database'),
	(13, 0, 'Pesan', '#', 'pesan/index', 'fa-envelope-o'),
	(14, 13, 'Pesan Masuk', 'pesan/masuk', 'pesan/masuk', 'fa-mail-reply'),
	(15, 13, 'Pesan Keluar', 'pesan/keluar', 'pesan/keluar', 'fa-mail-forward'),
	(16, 13, 'Buat Pesan', 'pesan/keluar/add', 'pesan/keluar/add', 'fa-edit'),
	(9, 0, 'Barang', '#', 'barang/index', 'fa-database'),
	(10, 9, 'Barang Masuk', 'barang/masuk', 'barang/masuk', 'fa-arrow-left'),
	(11, 9, 'Barang Keluar', 'barang/keluar', 'barang/keluar', 'fa-arrow-right'),
	(5, 1, 'Data Bahan Mentah', 'data/bahan_mentah', 'data/bahan_mentah', 'fa-bars'),
	(6, 1, 'Data Produk', 'data/produk', 'data/produk', 'fa-bars'),
	(17, 0, 'Laporan', '#', 'laporan/index', 'fa-newspaper-o'),
	(19, 17, 'Pembelian', 'laporan/pembelian', 'laporan/pembelian', 'fa-file-text'),
	(18, 17, 'Penjualan', 'laporan/penjualan', 'laporan/penjualan', 'fa-file-text'),
	(20, 17, 'Stok', 'laporan/stok', 'laporan/stok', 'fa-file-text');
/*!40000 ALTER TABLE `tbl_menu` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_pembelian
CREATE TABLE IF NOT EXISTS `tbl_pembelian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dibuat_oleh` int(11) NOT NULL,
  `kode_pembelian` varchar(50) NOT NULL,
  `kode_penjualan_terkait` varchar(50) NOT NULL,
  `status` enum('pending','disetujui','ditolak') NOT NULL DEFAULT 'pending',
  `disetujui_oleh` int(11) NOT NULL,
  `tgl_pembelian` date DEFAULT NULL,
  `id_supplier` int(11) NOT NULL,
  `tgl_kirim` date DEFAULT NULL,
  `alamat_pengiriman` text,
  `term_pembayaran` text,
  `term_pengiriman` text,
  `biaya_kirim` double DEFAULT NULL,
  `diskon` float DEFAULT NULL,
  `pajak` float DEFAULT NULL,
  `besar_trans` double NOT NULL,
  `catatan_pembelian` text NOT NULL,
  `terhapus` enum('Y','N') NOT NULL DEFAULT 'N',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='purchase order\r\nkode_penjualan_terkait = kode penjualan yang membuat adanya pembelian bahan.';

-- Dumping data for table 1368.tbl_pembelian: ~1 rows (approximately)
DELETE FROM `tbl_pembelian`;
/*!40000 ALTER TABLE `tbl_pembelian` DISABLE KEYS */;
INSERT INTO `tbl_pembelian` (`id`, `dibuat_oleh`, `kode_pembelian`, `kode_penjualan_terkait`, `status`, `disetujui_oleh`, `tgl_pembelian`, `id_supplier`, `tgl_kirim`, `alamat_pengiriman`, `term_pembayaran`, `term_pengiriman`, `biaya_kirim`, `diskon`, `pajak`, `besar_trans`, `catatan_pembelian`, `terhapus`, `updated_at`) VALUES
	(1, 2, 'PO-000001', 'SO-000001', 'disetujui', 2, '2015-01-19', 1, '2015-01-19', 'alamat', 'ini adalah term pembayaran\r\nyang sangat panjang baaanget lho', '', 1200000, 10, 0, 5580000, '', 'N', '2015-01-23 13:42:45'),
	(2, 3, 'PO-000002', 'SO-000001', 'pending', 2, '2015-01-19', 1, '2015-01-19', 'alamat', 'ini adalah term pembayaran\nyang sangat panjang baaanget lho', '', 1200000, 10, 0, 1080000, '', 'N', '2015-01-26 10:49:26');
/*!40000 ALTER TABLE `tbl_pembelian` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_pembelian_details
CREATE TABLE IF NOT EXISTS `tbl_pembelian_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pembelian` int(11) DEFAULT NULL,
  `id_bahan_mentah` int(11) DEFAULT NULL,
  `kuantitas` int(11) DEFAULT NULL,
  `harga_per_item` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='kode produk = kode produk dari supplier';

-- Dumping data for table 1368.tbl_pembelian_details: ~0 rows (approximately)
DELETE FROM `tbl_pembelian_details`;
/*!40000 ALTER TABLE `tbl_pembelian_details` DISABLE KEYS */;
INSERT INTO `tbl_pembelian_details` (`id`, `id_pembelian`, `id_bahan_mentah`, `kuantitas`, `harga_per_item`) VALUES
	(1, 1, 1, 50, 100000);
/*!40000 ALTER TABLE `tbl_pembelian_details` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_penjualan
CREATE TABLE IF NOT EXISTS `tbl_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dibuat_oleh` int(11) NOT NULL,
  `kode_penjualan` varchar(50) NOT NULL,
  `tgl_penjualan` date NOT NULL DEFAULT '0000-00-00',
  `status` enum('pending','disetujui','ditolak') NOT NULL DEFAULT 'pending',
  `disetujui_oleh` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `tgl_kirim_diminta` date NOT NULL DEFAULT '0000-00-00',
  `alamat_pengiriman` text NOT NULL,
  `sp_nama` varchar(50) NOT NULL,
  `sp_telp` varchar(50) NOT NULL,
  `sp_email` varchar(50) NOT NULL,
  `sp_jabatan` varchar(50) NOT NULL,
  `catatan_penjualan` text NOT NULL,
  `keterangan` text NOT NULL,
  `besar_trans` double NOT NULL,
  `terhapus` enum('Y','N') NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='sales order\r\nsp_name = sales person name';

-- Dumping data for table 1368.tbl_penjualan: ~1 rows (approximately)
DELETE FROM `tbl_penjualan`;
/*!40000 ALTER TABLE `tbl_penjualan` DISABLE KEYS */;
INSERT INTO `tbl_penjualan` (`id`, `dibuat_oleh`, `kode_penjualan`, `tgl_penjualan`, `status`, `disetujui_oleh`, `id_konsumen`, `tgl_kirim_diminta`, `alamat_pengiriman`, `sp_nama`, `sp_telp`, `sp_email`, `sp_jabatan`, `catatan_penjualan`, `keterangan`, `besar_trans`, `terhapus`, `updated_at`) VALUES
	(1, 3, 'SO-000001', '2015-01-19', 'pending', 2, 1, '2015-01-19', 'Jl.xxxx xxxxx xxxxxxx\nxxxxxxxxx\nxxxxxxxxxxxxxxxxxxxxx', '', '', '', '', 'catatan penjualan', '', 500000, 'N', '2015-01-26 10:47:36');
/*!40000 ALTER TABLE `tbl_penjualan` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_penjualan_details
CREATE TABLE IF NOT EXISTS `tbl_penjualan_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `keadaan` enum('matang','mentah') DEFAULT 'mentah',
  `kuantitas` int(11) DEFAULT NULL,
  `harga_per_item` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_penjualan_details: ~1 rows (approximately)
DELETE FROM `tbl_penjualan_details`;
/*!40000 ALTER TABLE `tbl_penjualan_details` DISABLE KEYS */;
INSERT INTO `tbl_penjualan_details` (`id`, `id_penjualan`, `id_produk`, `keadaan`, `kuantitas`, `harga_per_item`) VALUES
	(2, 1, 1, 'matang', 10, 50000);
/*!40000 ALTER TABLE `tbl_penjualan_details` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_pesan
CREATE TABLE IF NOT EXISTS `tbl_pesan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengirim` int(11) NOT NULL,
  `id_penerima` int(11) NOT NULL,
  `status` enum('pending','terbaca') NOT NULL DEFAULT 'pending',
  `subyek` varchar(200) NOT NULL,
  `isi` text NOT NULL,
  `tgl_kirim` datetime NOT NULL,
  `tgl_dibaca` datetime NOT NULL,
  `terhapus_pengirim` enum('Y','N') NOT NULL DEFAULT 'N',
  `terhapus_penerima` enum('Y','N') NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_pesan: ~2 rows (approximately)
DELETE FROM `tbl_pesan`;
/*!40000 ALTER TABLE `tbl_pesan` DISABLE KEYS */;
INSERT INTO `tbl_pesan` (`id`, `id_pengirim`, `id_penerima`, `status`, `subyek`, `isi`, `tgl_kirim`, `tgl_dibaca`, `terhapus_pengirim`, `terhapus_penerima`, `updated_at`) VALUES
	(1, 1, 2, 'terbaca', 'manager tesr', '<p>manager test1</p>', '2015-01-22 08:49:43', '0000-00-00 00:00:00', 'N', 'N', '2015-01-23 12:52:11'),
	(2, 1, 2, 'terbaca', 'manager tesr', '<p>manager test</p>', '2015-01-22 08:49:43', '0000-00-00 00:00:00', 'N', 'N', '2015-01-23 13:16:09');
/*!40000 ALTER TABLE `tbl_pesan` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_produk
CREATE TABLE IF NOT EXISTS `tbl_produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(50) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `hrg_terakhir` double NOT NULL DEFAULT '0',
  `terhapus` enum('Y','N') DEFAULT 'N',
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_produk: ~1 rows (approximately)
DELETE FROM `tbl_produk`;
/*!40000 ALTER TABLE `tbl_produk` DISABLE KEYS */;
INSERT INTO `tbl_produk` (`id`, `kode_produk`, `deskripsi`, `hrg_terakhir`, `terhapus`, `update_at`) VALUES
	(1, 'PROD-001', 'Produk 001', 10000, 'N', '2015-01-23 12:44:46');
/*!40000 ALTER TABLE `tbl_produk` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_produk_assemble
CREATE TABLE IF NOT EXISTS `tbl_produk_assemble` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `id_bahan_mentah` int(11) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_produk_assemble: ~3 rows (approximately)
DELETE FROM `tbl_produk_assemble`;
/*!40000 ALTER TABLE `tbl_produk_assemble` DISABLE KEYS */;
INSERT INTO `tbl_produk_assemble` (`id`, `id_produk`, `id_bahan_mentah`, `kuantitas`, `update_at`) VALUES
	(3, 1, 1, 10, '2015-01-19 18:48:54'),
	(4, 1, 7, 1, '2015-01-19 18:48:54'),
	(5, 1, 4, 10, '2015-01-19 18:48:54');
/*!40000 ALTER TABLE `tbl_produk_assemble` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_satuan
CREATE TABLE IF NOT EXISTS `tbl_satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_satuan: ~2 rows (approximately)
DELETE FROM `tbl_satuan`;
/*!40000 ALTER TABLE `tbl_satuan` DISABLE KEYS */;
INSERT INTO `tbl_satuan` (`id`, `nama`) VALUES
	(1, 'KG'),
	(2, 'Piece');
/*!40000 ALTER TABLE `tbl_satuan` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_settings
CREATE TABLE IF NOT EXISTS `tbl_settings` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_settings: ~11 rows (approximately)
DELETE FROM `tbl_settings`;
/*!40000 ALTER TABLE `tbl_settings` DISABLE KEYS */;
INSERT INTO `tbl_settings` (`id`, `nama`, `value`) VALUES
	(12, 'alamat_pengiriman', 'gudang PT 1386'),
	(8, 'cp_name', 'Bpk. Budi Setiawan'),
	(9, 'cp_telp', '0812445'),
	(10, 'cp_jabatan', 'sales executive'),
	(11, 'cp_email', 'sales@1368.com'),
	(1, 'perusahaan', 'PT 1368 '),
	(4, 'telp', '666999'),
	(5, 'fax', '666999'),
	(6, 'email', 'kontak@1368.com'),
	(7, 'website', 'www.1368.com'),
	(13, 'alamat_kantor', 'kantor PT 1368'),
	(3, 'po_box', '6608'),
	(2, 'logo', 'luckyshrimp_logo.jpg');
/*!40000 ALTER TABLE `tbl_settings` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_stok
CREATE TABLE IF NOT EXISTS `tbl_stok` (
  `id_bahan_mentah` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_bahan_mentah`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='kode_produk = kode produk dari supplier';

-- Dumping data for table 1368.tbl_stok: ~3 rows (approximately)
DELETE FROM `tbl_stok`;
/*!40000 ALTER TABLE `tbl_stok` DISABLE KEYS */;
INSERT INTO `tbl_stok` (`id_bahan_mentah`, `stok`, `updated_at`) VALUES
	(1, -200, '2015-01-23 14:10:25'),
	(3, 85, '2015-01-20 14:18:00'),
	(4, -200, '2015-01-23 14:10:25'),
	(7, -20, '2015-01-23 14:10:25');
/*!40000 ALTER TABLE `tbl_stok` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_stok_opname
CREATE TABLE IF NOT EXISTS `tbl_stok_opname` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_bahan_mentah` int(11) NOT NULL,
  `stok_lama` int(11) NOT NULL,
  `stok_baru` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_stok_opname: ~2 rows (approximately)
DELETE FROM `tbl_stok_opname`;
/*!40000 ALTER TABLE `tbl_stok_opname` DISABLE KEYS */;
INSERT INTO `tbl_stok_opname` (`id`, `id_user`, `id_bahan_mentah`, `stok_lama`, `stok_baru`, `keterangan`, `updated_at`) VALUES
	(1, 2, 3, 0, 100, '', '2015-01-20 14:10:55'),
	(2, 2, 3, 100, 85, 'pengurangan jadi 85', '2015-01-20 14:18:00');
/*!40000 ALTER TABLE `tbl_stok_opname` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_supplier
CREATE TABLE IF NOT EXISTS `tbl_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `cp_nama` varchar(50) NOT NULL,
  `cp_email` varchar(50) NOT NULL,
  `cp_telp` varchar(50) NOT NULL,
  `cp_jabatan` varchar(50) NOT NULL,
  `arr_bahan_mentah` varchar(50) NOT NULL,
  `terhapus` enum('Y','N') NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_supplier: ~2 rows (approximately)
DELETE FROM `tbl_supplier`;
/*!40000 ALTER TABLE `tbl_supplier` DISABLE KEYS */;
INSERT INTO `tbl_supplier` (`id`, `nama`, `alamat`, `cp_nama`, `cp_email`, `cp_telp`, `cp_jabatan`, `arr_bahan_mentah`, `terhapus`, `updated_at`) VALUES
	(1, 'PT. Supplier 1', 'Alamat Supplier 1\nJL.XXXX\nNo 28', 'CP Supplier 1', '', '', '', '1,2,3,4', 'N', '2015-01-21 15:25:41'),
	(2, 'PT. Supplier 2', 'Alamat Supplier 2', 'CP Supplier 2', 'ss@gmail.com', '', '', '4,6,7', 'N', '2015-01-08 06:49:50');
/*!40000 ALTER TABLE `tbl_supplier` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_template_akses_menu
CREATE TABLE IF NOT EXISTS `tbl_template_akses_menu` (
  `level` varchar(50) DEFAULT NULL,
  `akses_menu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_template_akses_menu: ~4 rows (approximately)
DELETE FROM `tbl_template_akses_menu`;
/*!40000 ALTER TABLE `tbl_template_akses_menu` DISABLE KEYS */;
INSERT INTO `tbl_template_akses_menu` (`level`, `akses_menu`) VALUES
	('marketing', '1,3,5,6,7,13,14,15,16,18,19,20'),
	('manager', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20'),
	('bahanbaku', '1,3,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20'),
	('packaging', '1,3,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20'),
	('produksi', '1,3,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20');
/*!40000 ALTER TABLE `tbl_template_akses_menu` ENABLE KEYS */;


-- Dumping structure for table 1368.tbl_user
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `userpass` varchar(50) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telp` varchar(50) NOT NULL,
  `level` enum('marketing','manager','bahanbaku','packaging','produksi','custom') NOT NULL,
  `akses_menu` varchar(100) NOT NULL,
  `otorisasi_trans` enum('Y','N') NOT NULL DEFAULT 'N',
  `terhapus` enum('Y','N') NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table 1368.tbl_user: ~5 rows (approximately)
DELETE FROM `tbl_user`;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` (`id`, `username`, `userpass`, `nama_lengkap`, `email`, `telp`, `level`, `akses_menu`, `otorisasi_trans`, `terhapus`, `updated_at`) VALUES
	(1, 'marketing', 'c769c2bd15500dd906102d9be97fdceb', 'marketing', 'marketing@gmail.com', '', 'marketing', '5,8,9,10,11', 'N', 'N', '2014-12-28 01:59:04'),
	(2, 'manager', '1d0258c2440a8d19e716292b231e3190', 'manager', 'manager@gmail.com', '', 'manager', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20', 'Y', 'N', '2015-01-25 05:21:01'),
	(3, 'bahanbaku', 'c8aa9dcb48722a931e2f1b23120d868b', 'bahanbaku', 'pembelian@gmail.com', '630245--', 'bahanbaku', '1,3,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20', 'N', 'N', '2015-01-26 10:53:36'),
	(4, 'packaging', '869b299375bab3ba9331a5ce61517631', 'packaging', 'packaging@gmail.com', '', 'packaging', '1,3,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20', 'N', 'N', '2015-01-26 10:53:39'),
	(5, 'produksi', 'edf3017a2946290b95c783bd1a7f0ba7', 'produksi', 'produksi@gmail.com', '', 'produksi', '1,3,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20', 'N', 'N', '2015-01-26 10:53:40');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;


-- Dumping structure for trigger 1368.tbl_brg_masuk_after_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tbl_brg_masuk_after_update` AFTER UPDATE ON `tbl_brg_masuk` FOR EACH ROW BEGIN
	DECLARE v_id_bahan_mentah INT;
	DECLARE v_kuantitas INT;
	DECLARE done INT;	
	
	DECLARE cur1 CURSOR FOR 
		SELECT id_bahan_mentah,kuantitas
		FROM tbl_brg_masuk_details
		WHERE id_brg_masuk = OLD.id;
	
	DECLARE CONTINUE HANDLER FOR NOT found SET done=1;	
		
	OPEN cur1;   
	mainloop:LOOP  
	
		FETCH cur1 INTO v_id_bahan_mentah,v_kuantitas;
   	IF done = 1 THEN LEAVE mainloop; END IF; 
   	
   	IF(NEW.terhapus = 'Y') THEN
   		UPDATE tbl_stok 
			SET stok = stok - v_kuantitas
			WHERE id_bahan_mentah = v_id_bahan_mentah; 
		ELSE
			UPDATE tbl_stok 
			SET stok = stok + v_kuantitas
			WHERE id_bahan_mentah = v_id_bahan_mentah;	  	
		END IF;   	
	
	END LOOP mainloop;
	CLOSE cur1;
	
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger 1368.tbl_brg_masuk_before_delete
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tbl_brg_masuk_before_delete` BEFORE DELETE ON `tbl_brg_masuk` FOR EACH ROW BEGIN
	
	DELETE FROM tbl_brg_masuk_details
	WHERE id_brg_masuk = OLD.id;
	
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger 1368.tbl_brg_masuk_details_after_delete
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tbl_brg_masuk_details_after_delete` AFTER DELETE ON `tbl_brg_masuk_details` FOR EACH ROW BEGIN
	
	/*log perubahan pada stok_opname*/
	DECLARE v_stok INT;
	
	SELECT IFNULL(stok,0) INTO v_stok FROM tbl_stok 
	WHERE id_bahan_mentah = old.id_bahan_mentah;
	
	INSERT INTO tbl_stok_opname(id_bahan_mentah,stok_lama,stok_baru,keterangan)
	VALUES(old.id_bahan_mentah,v_stok,(v_stok - old.kuantitas),'(AUTO) DELETE ON BRG_MASUK');
	
	UPDATE tbl_stok 
	SET stok = stok - old.kuantitas
	WHERE id_bahan_mentah = old.id_bahan_mentah;
	
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger 1368.tbl_brg_masuk_details_after_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tbl_brg_masuk_details_after_insert` AFTER INSERT ON `tbl_brg_masuk_details` FOR EACH ROW BEGIN
	
	INSERT IGNORE tbl_stok(id_bahan_mentah,stok) VALUES (NEW.id_bahan_mentah,NEW.kuantitas)
	ON DUPLICATE KEY UPDATE stok = stok + NEW.kuantitas;
	
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Dumping structure for trigger 1368.tbl_penjualan_after_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tbl_penjualan_after_update` AFTER UPDATE ON `tbl_penjualan` FOR EACH ROW BEGIN

 /*
 
 	jika diterima maka
 	1.get produk
 	2.get produk assemble
 	
 */
 	DECLARE done INT;	
 	DECLARE v_id_produk INT;
 	DECLARE v_kuantitas INT;
 	
 	DECLARE cur1 CURSOR FOR
 		SELECT id_produk,kuantitas 
		FROM tbl_penjualan_details
 		WHERE id_penjualan = OLD.id;
 	
	DECLARE CONTINUE HANDLER FOR NOT found SET done=1;	

	OPEN cur1;   
	mainloop:LOOP  	
		FETCH cur1 INTO v_id_produk,v_kuantitas;
   	IF done = 1 THEN LEAVE mainloop; END IF;
		
		IF(NEW.status = 'disetujui') THEN
			CALL proc_update_stok_from_penjualan(1,v_id_produk,v_kuantitas);
		/*ELSE
			CALL proc_update_stok_from_penjualan(0,v_id_produk,v_kuantitas);	*/
		END IF;	
		  	
  	END LOOP mainloop;
	CLOSE cur1;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
