-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aktivitas_log`
--

DROP TABLE IF EXISTS `aktivitas_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aktivitas_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `modul` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aksi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aktivitas_log_user_id_foreign` (`user_id`),
  KEY `aktivitas_log_modul_created_at_index` (`modul`,`created_at`),
  CONSTRAINT `aktivitas_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aktivitas_log`
--

LOCK TABLES `aktivitas_log` WRITE;
/*!40000 ALTER TABLE `aktivitas_log` DISABLE KEYS */;
INSERT INTO `aktivitas_log` VALUES (1,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260901/64546','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-01 08:48:01','2026-09-01 08:48:01'),(2,23,'pengaduan','kirim_pengaduan','Warga Badriyah mengirimkan laporan pengaduan LAPOR-20260903-0002 di Dusun Kebunan','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 00:49:42','2026-09-03 00:49:42'),(3,23,'pengaduan','kirim_pengaduan','Warga Badriyah mengirimkan laporan pengaduan LAPOR-20260903-0003 di Dusun Kebunan','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 00:49:45','2026-09-03 00:49:45'),(4,4,'pengaduan','kirim_pengaduan','Warga SUHRAWI mengirimkan laporan pengaduan LAPOR-20260903-0004 di Dusun Kebunan','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 01:40:46','2026-09-03 01:40:46'),(5,1,'pengaduan','tindak_lanjut_pengaduan','Memperbarui status pengaduan LAPOR-20260903-0004 menjadi \'selesai\'','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-03 01:42:27','2026-09-03 01:42:27'),(6,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260905/6A38D','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-04 23:50:53','2026-09-04 23:50:53'),(7,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260905/12AA2','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-04 23:54:26','2026-09-04 23:54:26'),(8,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260905/98D23','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-04 23:59:04','2026-09-04 23:59:04'),(10,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260906/45094','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-06 08:50:06','2026-09-06 08:50:06'),(11,25,'pengaduan','kirim_pengaduan','Warga moh sabri mengirimkan laporan pengaduan LAPOR-20260906-0001 di Dusun Kebunan','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-06 08:54:25','2026-09-06 08:54:25'),(12,1,'pengaduan','tindak_lanjut_pengaduan','Memperbarui status pengaduan LAPOR-20260906-0001 menjadi \'menunggu\'','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-06 08:56:00','2026-09-06 08:56:00'),(13,1,'pengaduan','tindak_lanjut_pengaduan','Memperbarui status pengaduan LAPOR-20260906-0001 menjadi \'menunggu\'','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-06 08:56:41','2026-09-06 08:56:41'),(14,1,'pengaduan','tindak_lanjut_pengaduan','Memperbarui status pengaduan LAPOR-20260906-0001 menjadi \'menunggu\'','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-06 08:56:46','2026-09-06 08:56:46'),(15,1,'pengaduan','tindak_lanjut_pengaduan','Memperbarui status pengaduan LAPOR-20260906-0001 menjadi \'menunggu\'','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-06 08:58:06','2026-09-06 08:58:06'),(16,1,'pengaduan','tindak_lanjut_pengaduan','Memperbarui status pengaduan LAPOR-20260906-0001 menjadi \'menunggu\'','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-06 08:59:25','2026-09-06 08:59:25'),(17,1,'pengaduan','tindak_lanjut_pengaduan','Memperbarui status pengaduan LAPOR-20260906-0001 menjadi \'diproses\'','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-06 09:02:43','2026-09-06 09:02:43'),(18,1,'pengaduan','tindak_lanjut_pengaduan','Memperbarui status pengaduan LAPOR-20260906-0001 menjadi \'diproses\'','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-06 09:03:02','2026-09-06 09:03:02'),(19,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260907/255F1','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-06 17:08:33','2026-09-06 17:08:33'),(20,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260907/13048','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 03:15:15','2026-09-07 03:15:15'),(21,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260907/8EAA9','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 04:16:30','2026-09-07 04:16:30'),(22,5,'pengaduan','kirim_pengaduan','Warga Moh Sabri mengirimkan laporan pengaduan LAPOR-20260907-0001 di Dusun Kebunan','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 09:58:05','2026-09-07 09:58:05'),(23,1,'pengaduan','tindak_lanjut_pengaduan','Memperbarui status pengaduan LAPOR-20260907-0001 menjadi \'diproses\'','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-07 09:59:35','2026-09-07 09:59:35'),(24,26,'pengaduan','kirim_pengaduan','Warga moh sabri mengirimkan laporan pengaduan LAPOR-20260908-0001 di Dusun Kebunan','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-08 05:03:24','2026-09-08 05:03:24'),(25,26,'pengaduan','kirim_pengaduan','Warga moh sabri mengirimkan laporan pengaduan LAPOR-20260908-0001 di Dusun Kebunan','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-08 05:11:31','2026-09-08 05:11:31'),(26,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260908/22160','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-08 05:31:00','2026-09-08 05:31:00'),(27,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260908/5724E','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-08 05:35:08','2026-09-08 05:35:08'),(28,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260813/00004','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-08 05:42:48','2026-09-08 05:42:48'),(29,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260908/68F08','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-08 05:43:16','2026-09-08 05:43:16'),(30,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260910/2F8B9','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','2026-09-10 14:31:09','2026-09-10 14:31:09'),(31,4,'pengaduan','kirim_pengaduan','Warga SUHRAWI mengirimkan laporan pengaduan LAPOR-20260912-0001 di Dusun Kebunan','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-12 05:06:24','2026-09-12 05:06:24'),(32,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260914/B7169','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-14 05:13:22','2026-09-14 05:13:22'),(33,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260915/6119A','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-14 20:08:47','2026-09-14 20:08:47'),(34,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260915/CEF43','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-14 21:34:01','2026-09-14 21:34:01'),(35,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260915/854FB','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-14 22:27:40','2026-09-14 22:27:40'),(36,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260915/63AAE','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-14 22:47:00','2026-09-14 22:47:00'),(37,1,'surat','verifikasi','Menyetujui permohonan surat #SRT/20260915/F3B2D','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-14 23:02:29','2026-09-14 23:02:29');
/*!40000 ALTER TABLE `aktivitas_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `berita`
--

DROP TABLE IF EXISTS `berita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `berita` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('berita','pengumuman','agenda','posyandu','bumdes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'berita',
  `ringkasan` text COLLATE utf8mb4_unicode_ci,
  `konten` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar_cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penulis_id` bigint unsigned DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `views` bigint unsigned NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `berita_slug_unique` (`slug`),
  KEY `berita_penulis_id_foreign` (`penulis_id`),
  CONSTRAINT `berita_penulis_id_foreign` FOREIGN KEY (`penulis_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `berita`
--

LOCK TABLES `berita` WRITE;
/*!40000 ALTER TABLE `berita` DISABLE KEYS */;
INSERT INTO `berita` VALUES (1,'Musrenbangdes Rombiya Barat: Prioritaskan Rabat Beton Jalan Antar-Dusun dan Pompa Air Pertanian','musrenbangdes-prioritas-jalan-dan-pertanian-2026','berita','Pemerintah Desa Rombiya Barat bersama BPD dan tokoh masyarakat 5 dusun menyepakati fokus pembangunan jalan rabat beton dan penguatan irigasi pertanian.','Pemerintah Desa Rombiya Barat, Kecamatan Ganding, Kabupaten Sumenep menggelar Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes) di Balai Desa Rombiya Barat.\n\nKepala Desa Rombiya Barat, Farhah, menegaskan bahwa usulan prioritas dari Dusun Kebunan, Buwa, Tanodung, Rombiya, dan Kalampok berpusat pada perbaikan akses jalan tani rabat beton serta pengadaan sarana irigasi pompa air sawah guna mendukung musim tanam tembakau dan tanaman pangan.\n\n\"Kami berkomitmen agar alokasi Dana Desa benar-benar menjawab kebutuhan riil masyarakat petani dan meningkatkan konektivitas antar dusun,\" ungkap Kepala Desa.',NULL,1,1,143,'2026-08-31 01:06:11','2026-09-01 08:43:46','2026-09-06 18:36:17'),(2,'Jadwal Posyandu Terpadu Balita dan Lansia di 5 Dusun Desa Rombiya Barat Bulan Ini','jadwal-posyandu-terpadu-5-dusun-bulan-ini','posyandu','Simak jadwal dan lokasi penimbangan balita, imunisasi rutin, serta pemeriksaan kesehatan lansia di 5 Dusun.','Puskesmas Pembantu bersama Kader Posyandu Desa Rombiya Barat mengumumkan jadwal pelayanan Posyandu Terpadu untuk bulan ini sebagai berikut:\n\n1. Posyandu Dusun Kebunan: Setiap tanggal 5 (Rumah Kasun Kebunan)\n2. Posyandu Dusun Buwa: Setiap tanggal 8 (Poskesdes Buwa)\n3. Posyandu Dusun Tanodung: Setiap tanggal 12 (Balai RT 03 Tanodung)\n4. Posyandu Dusun Rombiya: Setiap tanggal 16 (Halaman RA Sumber Mas)\n5. Posyandu Dusun Kalampok: Setiap tanggal 20 (Rumah Kasun Kalampok)\n\nLayanan meliputi penimbangan berat badan, pengukuran tinggi badan balita, imunisasi lengkap, serta pembagian PMT (Pemberian Makanan Tambahan).',NULL,1,1,98,'2026-08-28 01:06:11','2026-09-01 08:43:46','2026-09-06 18:36:17'),(3,'BUMDes Kencana Rombiya Barat Buka Layanan Distribusi Saprotan dan Agen Pembayaran Resmi','bumdes-kencana-buka-layanan-saprotan-dan-pembayaran','bumdes','BUMDes Kencana memperluas unit usaha untuk mempermudah petani mendapatkan sarana produksi tani dan pembayaran listrik/air.','Badan Usaha Milik Desa (BUMDes) Kencana Desa Rombiya Barat, Kecamatan Ganding kini resmi mengoperasikan unit penyedia Saprotan (Sarana Produksi Pertanian) dan agen pembayaran digital.\n\nUnit ini bertujuan mempermudah petani di 5 dusun dalam memperoleh pupuk, benih unggul jagung dan tembakau, serta melayani pembayaran tagihan listrik, BPJS, dan transfer perbankan tanpa harus menempuh jarak jauh ke pusat kecamatan.',NULL,1,1,175,'2026-08-24 01:06:11','2026-09-01 08:43:46','2026-09-06 18:36:17');
/*!40000 ALTER TABLE `berita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('si-pelayanan-desa-rombiyah-barat-cache-1b6453892473a467d07372d45eb05abc2031647a','i:3;',1789426960),('si-pelayanan-desa-rombiyah-barat-cache-1b6453892473a467d07372d45eb05abc2031647a:timer','i:1789426960;',1789426960),('si-pelayanan-desa-rombiyah-barat-cache-356a192b7913b04c54574d18c28d46e6395428ab','i:1;',1788796593),('si-pelayanan-desa-rombiyah-barat-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer','i:1788796593;',1788796593),('si-pelayanan-desa-rombiyah-barat-cache-472b07b9fcf2c2451e8781e944bf5f77cd8457c8','i:1;',1788277662),('si-pelayanan-desa-rombiyah-barat-cache-472b07b9fcf2c2451e8781e944bf5f77cd8457c8:timer','i:1788277662;',1788277662),('si-pelayanan-desa-rombiyah-barat-cache-4d134bc072212ace2df385dae143139da74ec0ef','i:2;',1788707406),('si-pelayanan-desa-rombiyah-barat-cache-4d134bc072212ace2df385dae143139da74ec0ef:timer','i:1788707406;',1788707406),('si-pelayanan-desa-rombiyah-barat-cache-887309d048beef83ad3eabf2a79a64a389ab1c9f','i:5;',1788846152),('si-pelayanan-desa-rombiyah-barat-cache-887309d048beef83ad3eabf2a79a64a389ab1c9f:timer','i:1788846152;',1788846152),('si-pelayanan-desa-rombiyah-barat-cache-91032ad7bbcb6cf72875e8e8207dcfba80173f7c','i:4;',1788750911),('si-pelayanan-desa-rombiyah-barat-cache-91032ad7bbcb6cf72875e8e8207dcfba80173f7c:timer','i:1788750911;',1788750911),('si-pelayanan-desa-rombiyah-barat-cache-c1dfd96eea8cc2b62785275bca38ac261256e278','i:4;',1788754568),('si-pelayanan-desa-rombiyah-barat-cache-c1dfd96eea8cc2b62785275bca38ac261256e278:timer','i:1788754568;',1788754568),('si-pelayanan-desa-rombiyah-barat-cache-f6e1126cedebf23e1463aee73f9df08783640400','i:4;',1788714435),('si-pelayanan-desa-rombiyah-barat-cache-f6e1126cedebf23e1463aee73f9df08783640400:timer','i:1788714435;',1788714435),('si-pelayanan-desa-rombiyah-barat-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6','i:1;',1789480068),('si-pelayanan-desa-rombiyah-barat-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer','i:1789480068;',1789480068);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_history`
--

DROP TABLE IF EXISTS `chat_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `chat_session_id` bigint unsigned NOT NULL,
  `pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jawaban` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_history_chat_session_id_foreign` (`chat_session_id`),
  CONSTRAINT `chat_history_chat_session_id_foreign` FOREIGN KEY (`chat_session_id`) REFERENCES `chat_session` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_history`
--

LOCK TABLES `chat_history` WRITE;
/*!40000 ALTER TABLE `chat_history` DISABLE KEYS */;
INSERT INTO `chat_history` VALUES (1,1,'Hai','Hai, selamat datang di layanan Desa Rombiyah Barat. Ada yang dapat saya bantu? Silakan sampaikan pertanyaan atau kebutuhan Anda terkait surat, SOP pelayanan, atau informasi desa.',NULL,'2026-09-06 08:21:09','2026-09-06 08:21:09'),(2,2,'p','Informasi tidak tersedia. Silakan menghubungi kantor desa untuk mendapatkan keterangan lebih lanjut.',NULL,'2026-09-06 09:16:23','2026-09-06 09:16:23'),(3,2,'Hai','Halo! Selamat datang di layanan Desa Rombiyah Barat. Ada yang bisa saya bantu terkait surat, SOP pelayanan, atau informasi desa? Silakan sampaikan pertanyaannya, saya siap membantu.',NULL,'2026-09-06 09:27:18','2026-09-06 09:27:18');
/*!40000 ALTER TABLE `chat_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_session`
--

DROP TABLE IF EXISTS `chat_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_session` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `dify_conversation_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `started_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_session_user_id_foreign` (`user_id`),
  CONSTRAINT `chat_session_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_session`
--

LOCK TABLES `chat_session` WRITE;
/*!40000 ALTER TABLE `chat_session` DISABLE KEYS */;
INSERT INTO `chat_session` VALUES (1,24,'8481aeb3-8ae8-4f7c-a405-a0710b58e75c','2026-09-06 08:21:09','2026-09-06 08:21:09','2026-09-06 08:21:09'),(2,25,'2b12333f-8529-4127-a509-73c11bf4ee02','2026-09-06 09:16:23','2026-09-06 09:16:23','2026-09-06 09:16:23');
/*!40000 ALTER TABLE `chat_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dokumen_persyaratan`
--

DROP TABLE IF EXISTS `dokumen_persyaratan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokumen_persyaratan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permohonan_id` bigint unsigned NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_dokumen` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ukuran_file` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dokumen_persyaratan_permohonan_id_foreign` (`permohonan_id`),
  CONSTRAINT `dokumen_persyaratan_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan_surat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dokumen_persyaratan`
--

LOCK TABLES `dokumen_persyaratan` WRITE;
/*!40000 ALTER TABLE `dokumen_persyaratan` DISABLE KEYS */;
INSERT INTO `dokumen_persyaratan` VALUES (1,5,'gambar flowchart terbaru.png','dokumen_persyaratan/2026/09/hy9bbTAQCTPLwLmCtJpFoYaFDU6wPend0LNLs7L9.png',NULL,NULL,'2026-09-01 08:46:56','2026-09-01 08:46:56'),(2,6,'gambar surat bimbingan.jpeg','dokumen_persyaratan/2026/09/B4oPBVD6ZgSnDX5co4KLjhoL2cuZsH2tMTfr6B29.jpg',NULL,NULL,'2026-09-04 23:38:47','2026-09-04 23:38:47'),(3,7,'gambar hasil cek turnitin.jpeg','dokumen_persyaratan/2026/09/UuetxYCFD5X5gfWlrukiRxD1uEKlowaWN3f7aMLP.jpg',NULL,NULL,'2026-09-04 23:54:05','2026-09-04 23:54:05'),(4,8,'gambar flowchart terbaru.png','dokumen_persyaratan/2026/09/3p2AVoNwXL8LV0zyUvIceH0FmBCCzl4Id1MVtuGU.png',NULL,NULL,'2026-09-04 23:57:44','2026-09-04 23:57:44'),(5,9,'gambar flowchart 3.png','dokumen_persyaratan/2026/09/LdLOwyaRfc2kO8i9TzTdYg8lUNRUDaXa381eCxgg.png','Fotokopi KTP Pemilik Usaha',1176183,'2026-09-06 08:48:09','2026-09-06 08:48:09'),(6,9,'gambar flowchart 1.png','dokumen_persyaratan/2026/09/TnsUPkHkKJMwQew5g8AkzKbxsD5xeH5saXoWQWXq.png','Fotokopi Kartu Keluarga (KK)',1034472,'2026-09-06 08:48:09','2026-09-06 08:48:09'),(7,9,'kerangka_pemikiran_sistem_desa.png','dokumen_persyaratan/2026/09/9iHOph27EGmdPDbvVCwjRL99gWFiQ33KUuvzSUkL.png','Surat Pengantar RT/RW',508369,'2026-09-06 08:48:09','2026-09-06 08:48:09'),(8,9,'gambar flowchart 4.png','dokumen_persyaratan/2026/09/OMN5SDpYrvQXTpgpxFdwQXTuurhugj1xmlGVcIJn.png','Foto Tempat / Aktivitas Usaha',1176183,'2026-09-06 08:48:09','2026-09-06 08:48:09'),(9,10,'gambar flowchart 2.png','dokumen_persyaratan/2026/09/L2R7P1RpWfeNFnU6eFND4BgVKwTPJSURlOq1LDPN.png','Fotokopi KTP Pemohon',885416,'2026-09-06 17:07:09','2026-09-06 17:07:09'),(10,10,'gambar dokumentasi 1.jpeg','dokumen_persyaratan/2026/09/9NTTFdapa5JaqN4YdYJkWON9KD5MzrCgBFLRzUvz.jpg','Fotokopi Kartu Keluarga (KK)',127571,'2026-09-06 17:07:09','2026-09-06 17:07:09'),(11,10,'ERD gambar png.png','dokumen_persyaratan/2026/09/m9pgiXrRyspxsCrawwxBidNeBleEJvZbDMwHRong.png','Surat Pengantar RT/RW',1261667,'2026-09-06 17:07:09','2026-09-06 17:07:09'),(12,10,'ERD.png','dokumen_persyaratan/2026/09/DkWuDhmdQAxCkEO8BdpSb1uN3BG8WAjqeWqScTOB.png','Foto Rumah / Kondisi Ekonomi',690870,'2026-09-06 17:07:09','2026-09-06 17:07:09'),(13,11,'gambar persetujuan skripsi.jpeg','dokumen_persyaratan/2026/09/d26E7G3glihw2SEvvQPm6XCJdIHm9JJrP0patEz1.jpg','Fotokopi KTP Pemilik Usaha',58743,'2026-09-07 03:14:45','2026-09-07 03:14:45'),(14,11,'dfd gambar.png','dokumen_persyaratan/2026/09/UcyPGpK9mGJ4GUfLMfK1JdNja8WtSTEedkMfg3D6.png','Fotokopi Kartu Keluarga (KK)',1291145,'2026-09-07 03:14:45','2026-09-07 03:14:45'),(15,11,'gambar flowchart 3.png','dokumen_persyaratan/2026/09/nrJpfVZOT01imxDs7t4GcE8sZwpiCLhMAoFBC8WN.png','Surat Pengantar RT/RW',1176183,'2026-09-07 03:14:45','2026-09-07 03:14:45'),(16,11,'ERD.png','dokumen_persyaratan/2026/09/Xl6KMQCSPyTMKY1XIKqeTJxhFmmYXCfyEhPli5o2.png','Foto Tempat / Aktivitas Usaha',690870,'2026-09-07 03:14:45','2026-09-07 03:14:45'),(17,12,'gambar flowchart 1.png','dokumen_persyaratan/2026/09/dXE3k7YdMqK69ZzF3ZHcBgVOcVpvFk94kXxgYv90.png','Fotokopi KTP Pemohon',1034472,'2026-09-07 04:15:59','2026-09-07 04:15:59'),(18,12,'ERD gambar png.png','dokumen_persyaratan/2026/09/HgSb08WGR1qSU6z5SpxP1l93vpvTfUeEeUjlymAT.png','Fotokopi Kartu Keluarga (KK)',1261667,'2026-09-07 04:15:59','2026-09-07 04:15:59'),(19,12,'ERD.png','dokumen_persyaratan/2026/09/AZyYPNoxLfheuAPE1qTwntPOIlCmd1JooqfugMMb.png','Surat Pengantar RT/RW',690870,'2026-09-07 04:15:59','2026-09-07 04:15:59'),(20,12,'gambar flowchart 2.png','dokumen_persyaratan/2026/09/3llvcDM9OKQKZeqZQRcj0UI6t2VbJOHUq4kUmDWm.png','Foto Rumah / Kondisi Ekonomi',885416,'2026-09-07 04:15:59','2026-09-07 04:15:59'),(24,14,'dfd gambar.png','dokumen_persyaratan/2026/09/PTDZK5iiis7VMOmIjDYqY4evugok97FKnKu3BuSt.png','Fotokopi KTP Pemohon',1291145,'2026-09-08 05:30:35','2026-09-08 05:30:35'),(25,14,'dfd gambar.png','dokumen_persyaratan/2026/09/N2J08pjWgZbRAfePsw1KB0Vg8XnuzNBJjwmicMww.png','Fotokopi Kartu Keluarga (KK)',1291145,'2026-09-08 05:30:35','2026-09-08 05:30:35'),(26,14,'gambar flowchart 4.png','dokumen_persyaratan/2026/09/FAUyzNhofoYNKCx1O2ENaVTzbdlsV5sAF3uq3Bdw.png','Surat Pengantar RT/RW',1176183,'2026-09-08 05:30:35','2026-09-08 05:30:35'),(27,14,'gambar flowchart 4.png','dokumen_persyaratan/2026/09/MKCtWbXMyWpV5v7bC7qbq5XITq5fM433KQjbleO5.png','Foto Rumah / Kondisi Ekonomi',1176183,'2026-09-08 05:30:35','2026-09-08 05:30:35'),(28,15,'ERD gambar png.png','dokumen_persyaratan/2026/09/SfgnD6g7ynUaBYipnj84kg7PCeUHrdNs09suKrqE.png','Fotokopi KTP Almarhum/Almarhumah',1261667,'2026-09-08 05:34:49','2026-09-08 05:34:49'),(29,15,'dfd gambar.png','dokumen_persyaratan/2026/09/Vvo9wefIRlqXbSOF4iz2hgiWYSEQLItLgpNEwucy.png','Fotokopi Kartu Keluarga (KK)',1291145,'2026-09-08 05:34:49','2026-09-08 05:34:49'),(30,15,'gambar flowchart 3.png','dokumen_persyaratan/2026/09/NHNb7lTBDgBDbacdMrVZIwGFpfuoAIUxPCGNchyo.png','Surat Keterangan Kematian Dokter/RS/Bidan',1176183,'2026-09-08 05:34:49','2026-09-08 05:34:49'),(31,15,'ERD gambar png.png','dokumen_persyaratan/2026/09/mwizac0tmHxbG2uW1H7rm0v7GrQcEH1Kvej0sr5o.png','Fotokopi KTP Pelapor / Ahli Waris',1261667,'2026-09-08 05:34:49','2026-09-08 05:34:49'),(32,16,'dfd gambar.png','dokumen_persyaratan/2026/09/c7BQS4M2NoWxFvzh4RRLuFVqgF5DmnUrPS3bEvBy.png','Fotokopi KTP Calon Mempelai & Orang Tua',1291145,'2026-09-08 05:42:30','2026-09-08 05:42:30'),(33,16,'ERD gambar png.png','dokumen_persyaratan/2026/09/6Oog2qs5RblxPl6ry8zPORVY0MwbNQqAIxoHj1I2.png','Fotokopi Kartu Keluarga (KK)',1261667,'2026-09-08 05:42:30','2026-09-08 05:42:30'),(34,16,'ERD gambar png.png','dokumen_persyaratan/2026/09/av34aCQY5XNsfS3wPNK7QEJ6vpi1HB9CAFrPKos7.png','Fotokopi Akta Kelahiran & Ijazah Terakhir',1261667,'2026-09-08 05:42:30','2026-09-08 05:42:30'),(35,16,'dfd gambar.png','dokumen_persyaratan/2026/09/bB46zReC8lPhlxJhbzREdEDbYOnhAD5ncAgtWUV6.png','Pas Foto 3x4 Calon Pengantin',1291145,'2026-09-08 05:42:30','2026-09-08 05:42:30'),(36,16,'gambar flowchart 4.png','dokumen_persyaratan/2026/09/uoheseZqYlP22aDAOK0XxWX5VUM8rqXZq5AeA38t.png','Surat Pengantar RT/RW',1176183,'2026-09-08 05:42:30','2026-09-08 05:42:30'),(37,17,'gambar dokumentasi.jpeg','dokumen_persyaratan/2026/09/YxdXo3TWfglquZrc18PIarjYJ3ZxjJr9GdvKfVT6.jpg','Fotokopi KTP Pemilik Usaha',134828,'2026-09-10 14:30:19','2026-09-10 14:30:19'),(38,17,'dfd gambar.png','dokumen_persyaratan/2026/09/opSdr0JBfZWSTNy0HAhBJwqJOuSBl3XsrNKgufGB.png','Fotokopi Kartu Keluarga (KK)',1291145,'2026-09-10 14:30:19','2026-09-10 14:30:19'),(39,17,'gambar flowchart 1.png','dokumen_persyaratan/2026/09/e1fxgcPHA39Rr47PGfj6JfhUhy2rmP8xbCWMk0bs.png','Surat Pengantar RT/RW',1034472,'2026-09-10 14:30:19','2026-09-10 14:30:19'),(40,17,'gambar flowchart 1.png','dokumen_persyaratan/2026/09/HWoMWSQUgL58PzpTStHse39mUT2mEcKxi3PzItWp.png','Foto Tempat / Aktivitas Usaha',1034472,'2026-09-10 14:30:19','2026-09-10 14:30:19'),(41,19,'arsitektur_sistem_desa_rombiyah_barat.png','dokumen_persyaratan/2026/09/0mkgdQU1biWOqLf48vddN7tMAiVdRFV0gEzrIyJn.png','Fotokopi KTP Pemohon',581862,'2026-09-12 05:07:22','2026-09-12 05:07:22'),(42,19,'dfd gambar.png','dokumen_persyaratan/2026/09/ewUfK6XwupbVTMNtT9fjhYpIwoe4NDxNZubx0MWB.png','Fotokopi Kartu Keluarga (KK)',1291145,'2026-09-12 05:07:22','2026-09-12 05:07:22'),(43,19,'gambar flowchart 2.png','dokumen_persyaratan/2026/09/Gapkd9kOOjICnQhNq5iMbraWZOzpIKo6vcGAuwZE.png','Surat Pengantar RT/RW',885416,'2026-09-12 05:07:22','2026-09-12 05:07:22'),(44,20,'dfd gambar.png','dokumen_persyaratan/2026/09/zRt3ugQcI79Zdi3v49bowc7kxujPZd0uyGb6Kc39.png','Fotokopi KTP',1291145,'2026-09-14 05:12:42','2026-09-14 05:12:42'),(45,20,'ERD.png','dokumen_persyaratan/2026/09/JKRGiMfSksDrX0pnKtOwwpXedt1o54wAaLBzuTQi.png','Fotokopi Kartu Keluarga (KK)',690870,'2026-09-14 05:12:42','2026-09-14 05:12:42'),(46,20,'ERD gambar png.png','dokumen_persyaratan/2026/09/o5zUhMbyQeaXLBTZyjuVm3Ije3j8eJfGycgp9nOD.png','Surat Pengantar RT/RW',1261667,'2026-09-14 05:12:42','2026-09-14 05:12:42'),(47,21,'dfd gambar.png','dokumen_persyaratan/2026/09/QOVsLFwWy09Vprltsk2GTYohw8kqpEwvyYpEossE.png','Fotokopi KTP',1291145,'2026-09-14 20:08:22','2026-09-14 20:08:22'),(48,21,'ERD gambar png.png','dokumen_persyaratan/2026/09/ES4SKFz8Jfuzyco2IRKrw5f3jXBlofn4voyrqR8d.png','Fotokopi Kartu Keluarga (KK)',1261667,'2026-09-14 20:08:22','2026-09-14 20:08:22'),(49,21,'ERD gambar png.png','dokumen_persyaratan/2026/09/orxVrmAJBfTfyIgtfmRvowJDaFMcWROM9F4F4kI6.png','Surat Pengantar RT/RW',1261667,'2026-09-14 20:08:22','2026-09-14 20:08:22'),(50,22,'dfd gambar.png','dokumen_persyaratan/2026/09/zRDuuiuWw76miAeHzbo0YDBZu8lWYOOhMIuAR9tZ.png','Fotokopi KTP Pemohon',1291145,'2026-09-14 21:33:32','2026-09-14 21:33:32'),(51,22,'dfd gambar.png','dokumen_persyaratan/2026/09/xsQSD6CEv57bqkHxYUSTBwhgwp3jhUzgiNVYr0ke.png','Fotokopi Kartu Keluarga (KK)',1291145,'2026-09-14 21:33:32','2026-09-14 21:33:32'),(52,22,'ERD gambar png.png','dokumen_persyaratan/2026/09/I6Fuej8A8FNOWzdwb4jMphrtVIRSdbRpiyohG7vO.png','Surat Pengantar RT/RW',1261667,'2026-09-14 21:33:32','2026-09-14 21:33:32'),(53,22,'ERD gambar png.png','dokumen_persyaratan/2026/09/nESzXVruX9mu5TTHOlrUQOc7KfXZ1fgk22YSmcNU.png','Foto Rumah / Kondisi Ekonomi',1261667,'2026-09-14 21:33:32','2026-09-14 21:33:32'),(54,23,'dfd gambar.png','dokumen_persyaratan/2026/09/ALWRdumUGqRidOolr5lit0IJXzSi9eIvqFKUXSSe.png','Fotokopi KTP Almarhum/Almarhumah',1291145,'2026-09-14 22:27:17','2026-09-14 22:27:17'),(55,23,'ERD gambar png.png','dokumen_persyaratan/2026/09/kEI5z20gnncHCzI0paCTKlxRlwRjJuBk7lDEQxPP.png','Fotokopi Kartu Keluarga (KK)',1261667,'2026-09-14 22:27:17','2026-09-14 22:27:17'),(56,23,'ERD.png','dokumen_persyaratan/2026/09/5gvJGU7cFSUJhBPUgHRrTHPyBeTtvN94vyBKdI1l.png','Surat Keterangan Kematian Dokter/RS/Bidan',690870,'2026-09-14 22:27:17','2026-09-14 22:27:17'),(57,23,'ERD gambar png.png','dokumen_persyaratan/2026/09/y2pFu7jx96nsXsLbqPw0rYHXJd5YlAS6pX7SDvqP.png','Fotokopi KTP Pelapor / Ahli Waris',1261667,'2026-09-14 22:27:17','2026-09-14 22:27:17'),(58,24,'dfd gambar.png','dokumen_persyaratan/2026/09/dkqUbx0EIkhNnWCsL6VA82Ae4qT7Yp13zeutajC5.png','Fotokopi KTP Pemohon',1291145,'2026-09-14 22:46:36','2026-09-14 22:46:36'),(59,24,'ERD.png','dokumen_persyaratan/2026/09/Q6horgA5S3ElqvIW8dYJ9AmlBc8YR9AHbckmYsH4.png','Fotokopi Kartu Keluarga (KK)',690870,'2026-09-14 22:46:36','2026-09-14 22:46:36'),(60,24,'ERD gambar png.png','dokumen_persyaratan/2026/09/c0GI6wzy8kyRaNCl61isAURea2CLTz1r8lp3UdBk.png','Surat Pengantar RT/RW',1261667,'2026-09-14 22:46:36','2026-09-14 22:46:36'),(61,24,'ERD gambar png.png','dokumen_persyaratan/2026/09/Cygqo0cvZWB1ibNL25o7BkKZsKB51L8DJTKQ4Yol.png','Foto Rumah / Kondisi Ekonomi',1261667,'2026-09-14 22:46:36','2026-09-14 22:46:36'),(62,24,'ERD.png','dokumen_persyaratan/2026/09/PF5SbwUsfkLzqgrIhzPwFYFTNz2kRaYXwt3t1QYr.png','Fotokopi Akta Kelahiran',690870,'2026-09-14 22:46:36','2026-09-14 22:46:36'),(63,24,'ERD.png','dokumen_persyaratan/2026/09/7huurNMib1B9mIk5UWlvWpUFYM52oS09dU0czznz.png','Fotokopi Kartu Pelajar/Mahasiswa',690870,'2026-09-14 22:46:36','2026-09-14 22:46:36'),(64,25,'dfd gambar.png','dokumen_persyaratan/2026/09/91lHYzJGull4ZaZJ5XHjqBhuU38PZxAplOTKumHn.png','Fotokopi KTP',1291145,'2026-09-14 23:02:05','2026-09-14 23:02:05'),(65,25,'ERD gambar png.png','dokumen_persyaratan/2026/09/M5Gt2jonez7m79hAlzLh8wwbqM2GdNeuPoJPSCOR.png','Fotokopi Kartu Keluarga (KK)',1261667,'2026-09-14 23:02:05','2026-09-14 23:02:05'),(66,25,'ERD gambar png.png','dokumen_persyaratan/2026/09/2Hd7m95rW5tIOyKNExXLuurM0At62eubdDBvNaa0.png','Surat Pengantar RT/RW',1261667,'2026-09-14 23:02:05','2026-09-14 23:02:05');
/*!40000 ALTER TABLE `dokumen_persyaratan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_surat`
--

DROP TABLE IF EXISTS `jenis_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_surat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `estimasi_waktu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1-3 Hari Kerja',
  `syarat` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenis_surat_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_surat`
--

LOCK TABLES `jenis_surat` WRITE;
/*!40000 ALTER TABLE `jenis_surat` DISABLE KEYS */;
INSERT INTO `jenis_surat` VALUES (1,'Surat Keterangan Tidak Mampu (SKTM)','SKTM','Surat keterangan untuk keperluan beasiswa, keringanan biaya berobat, atau bantuan sosial.','1-2 Hari Kerja','[{\"nama\": \"Fotokopi KTP Pemohon \", \"wajib\": true, \"keterangan\": \"Foto atau scan e-KTP asli pemohon.\"}, {\"nama\": \"Fotokopi Kartu Keluarga (KK)\", \"wajib\": true, \"keterangan\": \"Foto atau scan Kartu Keluarga warga Desa Rombiya Barat.\"}, {\"nama\": \"Surat Pengantar RT/RW\", \"wajib\": true, \"keterangan\": \"Surat pengantar asli bertanda tangan Ketua RT/RW setempat.\"}, {\"nama\": \"Foto Rumah / Kondisi Ekonomi\", \"wajib\": false, \"keterangan\": \"Foto tampak depan rumah atau bukti pendukung kondisi ekonomi (opsional).\"}, {\"nama\": \"Fotokopi Akta Kelahiran\", \"wajib\": true, \"keterangan\": \"Jika Surat Untuk Keperluan Anak\"}, {\"nama\": \"Fotokopi Kartu Pelajar/Mahasiswa\", \"wajib\": true, \"keterangan\": \"Surat Keterangan Aktif Sekolah/Mahasiswa Untuk Keperluan Beasiswa Pendidikan \"}]',1,'2026-09-01 08:43:46','2026-09-14 21:56:31'),(2,'Surat Keterangan Domisili','SKD','Surat keterangan menetap/bertempat tinggal di wilayah Desa Rombiya Barat.','1 Hari Kerja','[{\"nama\": \"Fotokopi KTP\", \"wajib\": true, \"keterangan\": \"Foto atau scan KTP pemohon.\"}, {\"nama\": \"Fotokopi Kartu Keluarga (KK)\", \"wajib\": true, \"keterangan\": \"Foto atau scan Kartu Keluarga.\"}, {\"nama\": \"Surat Pengantar RT/RW\", \"wajib\": true, \"keterangan\": \"Surat pengantar domisili dari Ketua RT/RW tempat tinggal saat ini.\"}]',1,'2026-09-01 08:43:46','2026-09-06 18:36:17'),(3,'Surat Keterangan Usaha (SKU)','SKU','Surat keterangan legalitas usaha berskala mikro/kecil di wilayah desa.','1-2 Hari Kerja','[{\"nama\": \"Fotokopi KTP Pemilik Usaha\", \"wajib\": true, \"keterangan\": \"Foto atau scan KTP pemilik usaha warga Rombiya Barat.\"}, {\"nama\": \"Fotokopi Kartu Keluarga (KK)\", \"wajib\": true, \"keterangan\": \"Foto atau scan Kartu Keluarga pemilik usaha.\"}, {\"nama\": \"Surat Pengantar RT/RW\", \"wajib\": true, \"keterangan\": \"Surat pengantar keterangan usaha dari RT/RW lokasi usaha.\"}, {\"nama\": \"Foto Tempat / Aktivitas Usaha\", \"wajib\": true, \"keterangan\": \"Foto tampak depan tempat usaha atau barang dagangan/kegiatan produksi.\"}]',1,'2026-09-01 08:43:46','2026-09-06 18:36:17'),(4,'Surat Pengantar Nikah (N1-N4)','SKN','Surat pengantar untuk pendaftaran pernikahan ke KUA / Catatan Sipil.','2-3 Hari Kerja','[{\"nama\": \"Fotokopi KTP Calon Mempelai & Orang Tua\", \"wajib\": true, \"keterangan\": \"Foto atau scan KTP calon pengantin dan kedua orang tua.\"}, {\"nama\": \"Fotokopi Kartu Keluarga (KK)\", \"wajib\": true, \"keterangan\": \"Foto atau scan Kartu Keluarga calon mempelai.\"}, {\"nama\": \"Fotokopi Akta Kelahiran & Ijazah Terakhir\", \"wajib\": true, \"keterangan\": \"Foto atau scan Akta Lahir dan Ijazah untuk verifikasi kesesuaian nama & tgl lahir.\"}, {\"nama\": \"Pas Foto 3x4 Calon Pengantin\", \"wajib\": true, \"keterangan\": \"Pas foto terbaru ukuran 3x4 background biru/merah.\"}, {\"nama\": \"Surat Pengantar RT/RW\", \"wajib\": true, \"keterangan\": \"Surat pengantar nikah dari Ketua RT/RW domisili.\"}]',1,'2026-09-01 08:43:46','2026-09-06 08:14:06'),(5,'Surat Keterangan Kematian','SKK','Surat keterangan resmi mengenai kematian warga desa.','1 Hari Kerja','[{\"nama\": \"Fotokopi KTP Almarhum/Almarhumah\", \"wajib\": true, \"keterangan\": \"Foto atau scan KTP almarhum/almarhumah yang meninggal dunia.\"}, {\"nama\": \"Fotokopi Kartu Keluarga (KK)\", \"wajib\": true, \"keterangan\": \"Foto atau scan KK almarhum/almarhumah.\"}, {\"nama\": \"Surat Keterangan Kematian Dokter/RS/Bidan\", \"wajib\": false, \"keterangan\": \"Surat kematian medis dari Puskesmas/RS/Bidan jika meninggal di fasilitas kesehatan.\"}, {\"nama\": \"Fotokopi KTP Pelapor / Ahli Waris\", \"wajib\": true, \"keterangan\": \"Foto atau scan KTP pelapor atau perwakilan keluarga.\"}]',1,'2026-09-01 08:43:46','2026-09-06 08:14:06'),(8,'surat keterangan ternak sapi/kambing','SURAT KETERANGAN TERNAK SAPI/KAMBING',NULL,'1-3 Hari Kerja','[{\"nama\": \"Fotokopi KTP pemilik\", \"wajib\": true, \"keterangan\": \"pdf jpg\"}, {\"nama\": \"fotokopi KK\", \"wajib\": true, \"keterangan\": \"pdf jpeg\"}, {\"nama\": \"foto lokasi\", \"wajib\": true, \"keterangan\": null}]',1,'2026-09-15 16:53:04','2026-09-15 16:55:26'),(9,'surat keterangan belum menikah','SURAT KETERANGAN BELUM MENIKAH',NULL,'1-3 Hari Kerja','[{\"nama\": \"Fotokopi KTP Pemohon Dan Orang Tua Wali\", \"wajib\": true, \"keterangan\": \"ppdf jpeg\"}, {\"nama\": \"fotokopi KK \", \"wajib\": true, \"keterangan\": \"pdf jpeg\"}, {\"nama\": \"surat pernyataan belum menika bermatrai\", \"wajib\": true, \"keterangan\": \"pdf jpeg\"}]',1,'2026-09-15 16:59:38','2026-09-15 16:59:38');
/*!40000 ALTER TABLE `jenis_surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knowledge_document`
--

DROP TABLE IF EXISTS `knowledge_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `knowledge_document` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_chunks` int NOT NULL DEFAULT '0',
  `is_indexed` tinyint(1) NOT NULL DEFAULT '0',
  `status_indexing` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `dify_document_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `knowledge_document_user_id_foreign` (`user_id`),
  CONSTRAINT `knowledge_document_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knowledge_document`
--

LOCK TABLES `knowledge_document` WRITE;
/*!40000 ALTER TABLE `knowledge_document` DISABLE KEYS */;
INSERT INTO `knowledge_document` VALUES (1,1,'surat edaran','knowledge-documents/01M1K78DV94FGPC82M99T2165V.pdf','SOP',0,0,'pending',NULL,'2026-09-03 01:48:07','2026-09-03 01:48:07');
/*!40000 ALTER TABLE `knowledge_document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_08_03_000001_create_jenis_surat_table',1),(5,'2026_08_03_000002_create_permohonan_surat_table',1),(6,'2026_08_03_000003_create_dokumen_persyaratan_table',1),(7,'2026_08_03_000004_create_notifikasi_table',1),(8,'2026_08_03_000005_create_chat_session_table',1),(9,'2026_08_03_000006_create_chat_history_table',1),(10,'2026_08_03_000007_create_knowledge_document_table',1),(11,'2026_08_03_000008_create_aktivitas_log_table',1),(12,'2026_08_03_000009_create_profil_desa_table',1),(13,'2026_09_02_000001_create_pengaduan_table',1),(14,'2026_09_02_000002_create_berita_table',1),(15,'2026_09_02_000003_create_program_bantuan_table',1),(16,'2026_09_02_000004_create_perangkat_desa_table',1),(17,'2026_09_03_000001_create_penerima_bantuan_table',2),(18,'2026_09_03_000002_add_foto_pengumuman_to_program_bantuan_table',2),(19,'2026_09_06_000001_add_dibatalkan_to_permohonan_surat_status',3),(20,'2026_09_12_000001_create_whatsapp_gateway_tables',4),(21,'2026_09_15_000001_create_password_reset_otps_table',5),(22,'2026_09_15_000002_add_reset_token_to_password_reset_otps_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifikasi`
--

DROP TABLE IF EXISTS `notifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifikasi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `permohonan_id` bigint unsigned DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dibaca_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifikasi_permohonan_id_foreign` (`permohonan_id`),
  KEY `notifikasi_user_id_dibaca_at_index` (`user_id`,`dibaca_at`),
  CONSTRAINT `notifikasi_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan_surat` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifikasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifikasi`
--

LOCK TABLES `notifikasi` WRITE;
/*!40000 ALTER TABLE `notifikasi` DISABLE KEYS */;
INSERT INTO `notifikasi` VALUES (1,21,5,NULL,'Permohonan Surat Keterangan Usaha (SKU) (SRT/20260901/64546) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-01 08:46:56','2026-09-01 08:46:56'),(2,21,5,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Usaha (SKU) (No: SRT/20260901/64546) telah disetujui dan siap diunduh.',NULL,'2026-09-01 08:48:01','2026-09-01 08:48:01'),(3,24,6,NULL,'Permohonan Surat Keterangan Usaha (SKU) (SRT/20260905/6A38D) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-04 23:38:47','2026-09-04 23:38:47'),(4,24,6,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Usaha (SKU) (No: SRT/20260905/6A38D) telah disetujui dan siap diunduh.',NULL,'2026-09-04 23:50:53','2026-09-04 23:50:53'),(5,24,7,NULL,'Permohonan Surat Keterangan Usaha (SKU) (SRT/20260905/12AA2) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-04 23:54:05','2026-09-04 23:54:05'),(6,24,7,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Usaha (SKU) (No: SRT/20260905/12AA2) telah disetujui dan siap diunduh.',NULL,'2026-09-04 23:54:26','2026-09-04 23:54:26'),(7,24,8,NULL,'Permohonan Surat Keterangan Kematian (SRT/20260905/98D23) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-04 23:57:44','2026-09-04 23:57:44'),(8,24,8,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Kematian (No: SRT/20260905/98D23) telah disetujui dan siap diunduh.',NULL,'2026-09-04 23:59:04','2026-09-04 23:59:04'),(10,25,9,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Usaha (SKU) (SRT/20260906/45094) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-06 08:48:09','2026-09-06 08:48:09'),(11,25,9,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Usaha (SKU) (No: SRT/20260906/45094) telah disetujui dan siap diunduh.',NULL,'2026-09-06 08:50:06','2026-09-06 08:50:06'),(12,25,10,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Tidak Mampu (SKTM) (SRT/20260907/255F1) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-06 17:07:09','2026-09-06 17:07:09'),(13,25,10,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Tidak Mampu (SKTM) (No: SRT/20260907/255F1) telah disetujui dan siap diunduh.',NULL,'2026-09-06 17:08:33','2026-09-06 17:08:33'),(14,20,11,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Usaha (SKU) (SRT/20260907/13048) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-07 03:14:45','2026-09-07 03:14:45'),(15,20,11,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Usaha (SKU) (No: SRT/20260907/13048) telah disetujui dan siap diunduh.',NULL,'2026-09-07 03:15:15','2026-09-07 03:15:15'),(16,6,12,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Tidak Mampu (SKTM) (SRT/20260907/8EAA9) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-07 04:15:59','2026-09-07 04:15:59'),(17,6,12,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Tidak Mampu (SKTM) (No: SRT/20260907/8EAA9) telah disetujui dan siap diunduh.',NULL,'2026-09-07 04:16:30','2026-09-07 04:16:30'),(19,26,14,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Tidak Mampu (SKTM) (SRT/20260908/22160) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-08 05:30:35','2026-09-08 05:30:35'),(20,26,14,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Tidak Mampu (SKTM) (No: SRT/20260908/22160) telah disetujui dan siap diunduh.',NULL,'2026-09-08 05:31:00','2026-09-08 05:31:00'),(21,26,15,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Kematian (SRT/20260908/5724E) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-08 05:34:49','2026-09-08 05:34:49'),(22,26,15,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Kematian (No: SRT/20260908/5724E) telah disetujui dan siap diunduh.',NULL,'2026-09-08 05:35:08','2026-09-08 05:35:08'),(23,26,16,'Permohonan Surat Diajukan','Permohonan Surat Pengantar Nikah (N1-N4) (SRT/20260908/68F08) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-08 05:42:30','2026-09-08 05:42:30'),(24,4,4,'Permohonan Surat Disetujui','Permohonan Surat Pengantar Nikah (N1-N4) (No: SRT/20260813/00004) telah disetujui dan siap diunduh.',NULL,'2026-09-08 05:42:48','2026-09-08 05:42:48'),(25,26,16,'Permohonan Surat Disetujui','Permohonan Surat Pengantar Nikah (N1-N4) (No: SRT/20260908/68F08) telah disetujui dan siap diunduh.',NULL,'2026-09-08 05:43:16','2026-09-08 05:43:16'),(26,4,17,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Usaha (SKU) (SRT/20260910/2F8B9) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-10 14:30:19','2026-09-10 14:30:19'),(27,4,17,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Usaha (SKU) (No: SRT/20260910/2F8B9) telah disetujui dan siap diunduh.',NULL,'2026-09-10 14:31:09','2026-09-10 14:31:09'),(28,4,19,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Tidak Mampu (SKTM) (SRT/20260912/52E92) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-12 05:07:22','2026-09-12 05:07:22'),(29,4,20,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Domisili (SRT/20260914/B7169) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-14 05:12:42','2026-09-14 05:12:42'),(30,4,20,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Domisili (No: SRT/20260914/B7169) telah disetujui dan siap diunduh.',NULL,'2026-09-14 05:13:22','2026-09-14 05:13:22'),(31,4,21,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Domisili (SRT/20260915/6119A) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-14 20:08:22','2026-09-14 20:08:22'),(32,4,21,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Domisili (No: SRT/20260915/6119A) telah disetujui dan siap diunduh.',NULL,'2026-09-14 20:08:47','2026-09-14 20:08:47'),(33,4,22,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Tidak Mampu (SKTM) (SRT/20260915/CEF43) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-14 21:33:32','2026-09-14 21:33:32'),(34,4,22,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Tidak Mampu (SKTM) (No: SRT/20260915/CEF43) telah disetujui dan siap diunduh.',NULL,'2026-09-14 21:34:01','2026-09-14 21:34:01'),(35,4,23,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Kematian (SRT/20260915/854FB) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-14 22:27:17','2026-09-14 22:27:17'),(36,4,23,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Kematian (No: SRT/20260915/854FB) telah disetujui dan siap diunduh.',NULL,'2026-09-14 22:27:40','2026-09-14 22:27:40'),(37,4,24,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Tidak Mampu (SKTM) (SRT/20260915/63AAE) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-14 22:46:36','2026-09-14 22:46:36'),(38,4,24,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Tidak Mampu (SKTM) (No: SRT/20260915/63AAE) telah disetujui dan siap diunduh.',NULL,'2026-09-14 22:47:00','2026-09-14 22:47:00'),(39,4,25,'Permohonan Surat Diajukan','Permohonan Surat Keterangan Domisili (SRT/20260915/F3B2D) berhasil dibuat dan sedang menunggu verifikasi petugas.',NULL,'2026-09-14 23:02:05','2026-09-14 23:02:05'),(40,4,25,'Permohonan Surat Disetujui','Permohonan Surat Keterangan Domisili (No: SRT/20260915/F3B2D) telah disetujui dan siap diunduh.',NULL,'2026-09-14 23:02:29','2026-09-14 23:02:29');
/*!40000 ALTER TABLE `notifikasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_otps`
--

DROP TABLE IF EXISTS `password_reset_otps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_otps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reset_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempts` tinyint unsigned NOT NULL DEFAULT '0',
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `verified_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_reset_otps_user_id_foreign` (`user_id`),
  KEY `password_reset_otps_nik_index` (`nik`),
  KEY `password_reset_otps_reset_token_index` (`reset_token`),
  CONSTRAINT `password_reset_otps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_otps`
--

LOCK TABLES `password_reset_otps` WRITE;
/*!40000 ALTER TABLE `password_reset_otps` DISABLE KEYS */;
INSERT INTO `password_reset_otps` VALUES (1,21,'3542389764144668','087880433119','150153',NULL,0,1,NULL,'2026-09-14 19:06:35','2026-09-14 18:56:35','2026-09-14 18:58:20'),(2,4,'3529102904650001','087880433119','643529',NULL,0,1,NULL,'2026-09-15 00:15:25','2026-09-15 00:05:25','2026-09-15 13:49:44'),(3,5,'3529100107430086','085954144435','227149',NULL,0,1,NULL,'2026-09-15 13:52:46','2026-09-15 13:42:46','2026-09-15 13:44:03'),(4,5,'3529100107430086','085954144435','205098',NULL,0,1,NULL,'2026-09-15 13:54:03','2026-09-15 13:44:03','2026-09-15 14:37:09'),(5,4,'3529102904650001','087880433119','370311',NULL,0,1,NULL,'2026-09-15 13:59:45','2026-09-15 13:49:45','2026-09-15 13:50:54'),(6,4,'3529102904650001','087880433119','590506',NULL,0,1,NULL,'2026-09-15 14:00:54','2026-09-15 13:50:54','2026-09-15 13:54:56'),(7,4,'3529102904650001','087880433119','406737',NULL,0,1,NULL,'2026-09-15 14:04:56','2026-09-15 13:54:56','2026-09-15 14:12:41'),(8,4,'3529102904650001','087880433119','244842',NULL,0,1,NULL,'2026-09-15 14:22:41','2026-09-15 14:12:41','2026-09-15 14:13:46'),(9,4,'3529102904650001','087880433119','368925',NULL,0,1,NULL,'2026-09-15 14:23:46','2026-09-15 14:13:46','2026-09-15 14:20:21'),(10,4,'3529102904650001','087880433119','355310',NULL,0,1,NULL,'2026-09-15 14:30:21','2026-09-15 14:20:21','2026-09-15 14:27:05'),(11,4,'3529102904650001','087880433119','320187',NULL,0,1,NULL,'2026-09-15 14:37:05','2026-09-15 14:27:05','2026-09-15 14:35:22'),(12,4,'3529102904650001','087880433119','179547',NULL,0,1,NULL,'2026-09-15 14:45:22','2026-09-15 14:35:22','2026-09-15 14:39:22'),(13,5,'3529100107430086','087880433119','720617',NULL,0,1,NULL,'2026-09-15 14:47:09','2026-09-15 14:37:09','2026-09-15 14:38:02'),(14,5,'3529100107430086','087880433119','558037',NULL,0,1,NULL,'2026-09-15 14:48:20','2026-09-15 14:38:20','2026-09-15 14:38:55'),(15,4,'3529102904650001','087880433119','839079',NULL,0,1,NULL,'2026-09-15 14:49:22','2026-09-15 14:39:22','2026-09-15 14:40:11'),(16,4,'3529102904650001','087880433119','413271','ErVVI31eQz57TnVFjBUdFsZc8iNr4uMIyt8ooRLnNciTdoIhRSoJnTuESYtZrNnw',0,1,'2026-09-15 15:34:35','2026-09-15 15:44:04','2026-09-15 15:34:04','2026-09-15 15:35:08'),(17,4,'3529102904650001','087880433119','545594','x0v5IfPYHHULFHYLcimXq14xkONtNuEsco7lU03EAd25h2SLVxYK9nRHIpDFlfq2',0,1,'2026-09-15 16:08:02','2026-09-15 16:23:02','2026-09-15 16:07:42','2026-09-15 16:09:19'),(18,4,'3529102904650001','087880433119','829427','bQOIP8vDbpmvv7bnJvfMB1f47oWDrELQW7vQMV9uhpjBGxVe0jEOT56MLYumg59A',0,1,'2026-09-15 16:09:45','2026-09-15 16:24:45','2026-09-15 16:09:33','2026-09-15 16:09:52'),(19,21,'3542389764144668','087880433119','729498','iLqSq7GNIn2tuqJY5YOm1KBOHPbkazFxAVVDk2Gbch1znYZhIRm4AH53BjAeRxuf',1,1,'2026-09-15 16:10:54','2026-09-15 16:25:54','2026-09-15 16:10:28','2026-09-15 16:11:01'),(20,4,'3529102904650001','087880433119','127271','295zUixrwW0IGbcvb7THG0G8U6ahmOBEo5kXTvJyTcX4IXdIAsiKq4ArJ0ykevpF',0,1,'2026-09-15 16:26:31','2026-09-15 16:41:31','2026-09-15 16:26:13','2026-09-15 16:26:57'),(21,5,'3529100107430086','087880433119','969345','JbsvkByfaNqNvuWCaA3KIjdMT3rjVpzH4TkLJ5CofkOxtPkMizSaMcLdXRBdGeb9',0,1,'2026-09-15 16:47:26','2026-09-15 17:02:26','2026-09-15 16:47:10','2026-09-15 16:47:55');
/*!40000 ALTER TABLE `password_reset_otps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penerima_bantuan`
--

DROP TABLE IF EXISTS `penerima_bantuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penerima_bantuan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `program_bantuan_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_penerima` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dusun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_bansos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rincian_yang_diterima` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tahap 1 - 2026',
  `status_penyaluran` enum('terdaftar','siap_diambil','sudah_diterima','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'terdaftar',
  `tanggal_penyaluran` date DEFAULT NULL,
  `lokasi_pengambilan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Kantor Balai Desa Rombiya Barat',
  `foto_dokumen_daftar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penerima_bantuan_program_bantuan_id_foreign` (`program_bantuan_id`),
  KEY `penerima_bantuan_user_id_foreign` (`user_id`),
  KEY `penerima_bantuan_dusun_status_penyaluran_index` (`dusun`,`status_penyaluran`),
  KEY `penerima_bantuan_nik_index` (`nik`),
  CONSTRAINT `penerima_bantuan_program_bantuan_id_foreign` FOREIGN KEY (`program_bantuan_id`) REFERENCES `program_bantuan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penerima_bantuan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penerima_bantuan`
--

LOCK TABLES `penerima_bantuan` WRITE;
/*!40000 ALTER TABLE `penerima_bantuan` DISABLE KEYS */;
INSERT INTO `penerima_bantuan` VALUES (1,7,3,'3529101508850003','Budi Santoso','Dusun Kebunan','RT 002 RW 002 Dusun Kebunan','Bantuan Cadangan Beras Pemerintah (CBP 10 Kg)','10 Kg Beras Medium Bulog + Minyak Goreng 1 Liter','Tahap 1 - 2026 (Maret 2026)','siap_diambil','2026-09-05','Kantor Balai Desa Rombiya Barat (Meja Dusun Kebunan)','images/balai_desa.jpeg','Bawa KTP asli dan Kartu Keluarga asli saat pengambilan di Balai Desa.','2026-09-03 01:06:11','2026-09-03 01:06:11'),(2,1,3,'3529101508850003','Budi Santoso','Dusun Kebunan','RT 002 RW 002 Dusun Kebunan','BLT Dana Desa (BLT-DD) 2026','Uang Tunai Rp 300.000 / Bulan (Triwulan 1 = Rp 900.000)','Triwulan 1 (Januari - Maret 2026)','siap_diambil','2026-09-06','Kantor Balai Desa Rombiya Barat','images/balai_desa.jpeg','Penetapan melalui Musyawarah Desa Khusus (Musdesus).','2026-09-03 01:06:11','2026-09-03 01:06:11'),(3,6,NULL,'3529015506480002','Nenek Siti Maryam','Dusun Buwa','RT 001 RW 001 Dusun Buwa','Bansos Lansia & Disabilitas (PKH Plus)','Bantuan Tunai Lansia Rp 600.000 / Triwulan + Paket Nutrisi Lansia','Tahap 1 - 2026','siap_diambil','2026-09-05','Kantor Balai Desa Rombiya Barat (Layanan Antar Kasun Buwa bagi yang sakit)','images/balai_desa.jpeg','Dapat diantar langsung ke rumah oleh Kasun Buwa jika penerima berhalangan hadir karena faktor usia.','2026-09-03 01:06:11','2026-09-03 01:06:11'),(4,7,NULL,'3529011208750003','Moh. Hasan','Dusun Buwa','RT 003 RW 001 Dusun Buwa','Bantuan Cadangan Beras Pemerintah (CBP 10 Kg)','10 Kg Beras Medium Bulog','Tahap 1 - 2026 (Maret 2026)','sudah_diterima','2026-08-30','Kantor Balai Desa Rombiya Barat','images/balai_desa.jpeg','Telah diserahterimakan pada tanggal 30 Aug 2026.','2026-09-03 01:06:11','2026-09-03 01:06:11'),(5,9,NULL,'3529011503820004','Ahmad Subandi','Dusun Tanodung','RT 002 RW 003 Dusun Tanodung','Bantuan Sarana Pupuk Bersubsidi & Bibit Tani','2 Karung Pupuk NPK Phonska Subsidi (100 Kg) + 1 Kantong Benih Jagung Hibrida','Musim Tanam 1 - 2026','siap_diambil','2026-09-04','Gudang Unit Saprotan BUMDes Kencana (Balai Desa)','images/balai_desa.jpeg','Membawa Kartu Tani / KTP dan bukti keanggotaan Poktan Tanodung.','2026-09-03 01:06:11','2026-09-03 01:06:11'),(6,5,NULL,'3529014809910005','Nurul Hidayati','Dusun Rombiya','RT 001 RW 002 Dusun Rombiya','Program Keluarga Harapan (PKH)','Bantuan Tunai PKH Rp 750.000 (Komponen Ibu Hamil & Balita)','Tahap 1 - Triwulan 1 2026','sudah_diterima','2026-09-01','Bank BRI Unit Ganding / Agen BRILink BUMDes','images/balai_desa.jpeg','Pencairan lancar melalui Kartu KKS Himbara.','2026-09-03 01:06:11','2026-09-03 01:06:11'),(7,8,NULL,'3529012805870006','Slamet Riyadi','Dusun Rombiya','RT 003 RW 002 Dusun Rombiya','BPNT / Program Sembako','Paket Sembako Pangan (Beras 10 Kg, Telur 1 Kg, Minyak Goreng 2L, Gula 1 Kg)','Bulan Maret 2026','siap_diambil','2026-09-05','e-Warong BUMDes Kencana Rombiyah Barat','images/balai_desa.jpeg','Bawa Kartu KKS dan KTP asli saat bertransaksi di e-Warong.','2026-09-03 01:06:11','2026-09-03 01:06:11'),(8,1,NULL,'3529010411780007','Zubairi','Dusun Kalampok','RT 002 RW 001 Dusun Kalampok','BLT Dana Desa (BLT-DD) 2026','Uang Tunai Rp 300.000 / Bulan (Tahap 1 = Rp 900.000)','Triwulan 1 (Januari - Maret 2026)','siap_diambil','2026-09-06','Kantor Balai Desa Rombiya Barat','images/balai_desa.jpeg','Membawa KTP asli dan KK.','2026-09-03 01:06:11','2026-09-03 01:06:11'),(9,8,NULL,'3529101705020003','Moh Sabri','Dusun Kebunan','RT 003 / RW 002','Bantuan Pangan Non Tunai (BPNT / Program Sembako)','beras gula minyak','tahap 3','terdaftar',NULL,'rumah pamong / kepala dusun',NULL,'fotocopy KK KTP','2026-09-06 17:26:31','2026-09-06 17:26:31');
/*!40000 ALTER TABLE `penerima_bantuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaduan`
--

DROP TABLE IF EXISTS `pengaduan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaduan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `kode_tiket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dusun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_detail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('menunggu','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `tanggapan_petugas` text COLLATE utf8mb4_unicode_ci,
  `petugas_id` bigint unsigned DEFAULT NULL,
  `ditanggapi_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengaduan_kode_tiket_unique` (`kode_tiket`),
  KEY `pengaduan_user_id_foreign` (`user_id`),
  KEY `pengaduan_petugas_id_foreign` (`petugas_id`),
  CONSTRAINT `pengaduan_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pengaduan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaduan`
--

LOCK TABLES `pengaduan` WRITE;
/*!40000 ALTER TABLE `pengaduan` DISABLE KEYS */;
INSERT INTO `pengaduan` VALUES (1,3,'LAPOR-2026-0001','jalan_infrastruktur','Dusun Kebunan','Penerangan Jalan dan Rabat Beton Rusak Dekat Batas Sawah RT 02','Mohon bantuan perbaikan rabat beton jalan tani yang ambles sekitar 15 meter setelah hujan lebat, serta penambahan 1 titik lampu jalan di persimpangan jalan Dusun Kebunan menuju Dusun Buwa.','Jalan Tani Dusun Kebunan RT 002 RW 002',NULL,'diproses','Laporan telah diverifikasi oleh Kasi Kesejahteraan dan Kasun Kebunan. Perbaikan masuk dalam alokasi pemeliharaan jalan lingkungan bulan ini.',1,'2026-09-02 01:06:11','2026-09-01 08:43:46','2026-09-03 01:06:11'),(2,3,'LAPOR-2026-0002','pertanian_irigasi','Dusun Tanodung','Permohonan Bantuan Pompa Air Sawah Musim Tanam','Kelompok tani di Dusun Tanodung RT 03 membutuhkan tambahan giliran operasional pompa air sawah desa karena sumur bor dangkal mulai surut.','Lahan Persawahan Dusun Tanodung RT 003 RW 004',NULL,'selesai','Pompa air cadangan BUMDes Kencana telah disalurkan dan dioperasikan bersama pengurus Poktan Tanodung.',1,'2026-09-02 20:06:11','2026-09-01 08:43:46','2026-09-03 01:06:11'),(3,22,'LAPOR-20260902-0001','pelayanan_desa','Dusun Kebunan','kurang mengetahui','cara mengetahui dusun saya dan rt rw saya','blabla',NULL,'menunggu',NULL,NULL,NULL,'2026-09-02 08:41:14','2026-09-02 08:41:14'),(4,22,'LAPOR-20260902-0002','pelayanan_desa','Dusun Kebunan','kurang mengetahui','cara mengetahui dusun saya dan rt rw saya','blabla',NULL,'menunggu',NULL,NULL,NULL,'2026-09-02 08:41:54','2026-09-02 08:41:54'),(5,22,'LAPOR-20260902-0003','pelayanan_desa','Dusun Kebunan','kurang mengetahui','cara mengetahui dusun saya dan rt rw saya','blabla',NULL,'menunggu',NULL,NULL,NULL,'2026-09-02 09:02:55','2026-09-02 09:02:55'),(6,23,'LAPOR-20260903-0001','pelayanan_desa','Dusun Kebunan','kehilangan','can been','rtt',NULL,'menunggu',NULL,NULL,NULL,'2026-09-03 00:35:23','2026-09-03 00:35:23'),(7,23,'LAPOR-20260903-0002','pelayanan_desa','Dusun Kebunan','kehilangan','can been','rtt',NULL,'menunggu',NULL,NULL,NULL,'2026-09-03 00:49:42','2026-09-03 00:49:42'),(8,23,'LAPOR-20260903-0003','pelayanan_desa','Dusun Kebunan','kehilangan','can been','rtt',NULL,'menunggu',NULL,NULL,NULL,'2026-09-03 00:49:45','2026-09-03 00:49:45'),(9,4,'LAPOR-20260903-0004','pelayanan_desa','Dusun Kebunan','anjeyyy','can beeen','lokal',NULL,'selesai',NULL,1,NULL,'2026-09-03 01:40:46','2026-09-03 01:42:27'),(10,25,'LAPOR-20260906-0001','kebersihan_lingkungan','Dusun Kebunan','pembersihan jalan','karna ahagjshdj','abv',NULL,'diproses','baik',1,NULL,'2026-09-06 08:54:25','2026-09-06 09:02:43'),(11,5,'LAPOR-20260907-0001','jalan_infrastruktur','Dusun Kebunan','rawat beton','abc','abc',NULL,'diproses','baik terima kasih',2,NULL,'2026-09-07 09:58:05','2026-09-07 09:59:35'),(13,26,'LAPOR-20260908-0001','kebersihan_lingkungan','Dusun Kebunan','abcc','bgaimna','abc',NULL,'menunggu',NULL,NULL,NULL,'2026-09-08 05:11:31','2026-09-08 05:11:31'),(14,4,'LAPOR-20260912-0001','jalan_infrastruktur','Dusun Kebunan','abc','abc','abc',NULL,'menunggu',NULL,NULL,NULL,'2026-09-12 05:06:24','2026-09-12 05:06:24');
/*!40000 ALTER TABLE `pengaduan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perangkat_desa`
--

DROP TABLE IF EXISTS `perangkat_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perangkat_desa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wilayah_tugas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip_atau_nomor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perangkat_desa`
--

LOCK TABLES `perangkat_desa` WRITE;
/*!40000 ALTER TABLE `perangkat_desa` DISABLE KEYS */;
INSERT INTO `perangkat_desa` VALUES (1,'hj.febri','Kepala Desa','Pemerintah Desa Rombiya Barat','197508122021122001',NULL,'082334567890',1,1,'2026-09-01 08:43:46','2026-09-06 18:38:00'),(2,'Ahmad Fauzi, S.Pd','Sekretaris Desa','Kantor Balai Desa','198205102015031002','images/pamong/sekdes_fauzi.jpg','081234567801',2,1,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(3,'Moh. Syafi\'i','Kaur Keuangan & Bendahara Desa','Kantor Balai Desa','198803152019011003','images/pamong/kaur_syafii.jpg','081234567802',3,1,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(4,'Siti Fatimah','Kaur Tata Usaha & Umum','Kantor Balai Desa','199007202020012004',NULL,'081234567803',4,1,'2026-09-01 08:43:46','2026-09-03 00:37:41'),(5,'Ali Wafa','Kasi Pelayanan & Kesejahteraan','Kantor Balai Desa','198511222018021005','images/pamong/kasi_aliwafa.jpg','081234567804',5,1,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(6,'Suhrawi','Kepala Dusun Kebunan','Dusun Kebunan','3529102904650001','images/pamong/kasun_suhrawi.jpg','081234567805',6,1,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(7,'Subairi','Kepala Dusun Buwa','Dusun Buwa','3529100107680167','perangkat-desa/01M1Y9A321DGDMPVKAKNBWDADY.jpeg','081234567806',7,1,'2026-09-01 08:43:46','2026-09-07 15:55:37'),(8,'Abd. Muni','Kepala Dusun Tanodung','Dusun Tanodung','3529102104600002','images/pamong/kasun_muni.jpg','081234567807',8,1,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(9,'Moh. Sabri','Kepala Dusun Rombiya','Dusun Rombiya','3529100107430086','images/pamong/kasun_sabri.jpg','081234567808',9,1,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(10,'Moh. Rofiqi','Kepala Dusun Kalampok','Dusun Kalampok','3529101504040003','images/pamong/kasun_rofiqi.jpg','081234567809',10,1,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(11,'Siti Aminah','Kaur Tata Usaha & Umum','Kantor Balai Desa','199007202020012004','images/pamong/kaur_aminah.jpg','081234567803',4,1,'2026-09-03 01:06:11','2026-09-03 01:06:11'),(12,'Holis, S.Sos','Kasi Pemerintahan','Kantor Balai Desa','198511252017041005','images/pamong/kasi_holis.jpg','081234567804',5,1,'2026-09-03 01:06:11','2026-09-03 01:06:11'),(13,'Zainal Abidin','Kasi Kesejahteraan (Kesra)','Kantor Balai Desa','198704182018021006','images/pamong/kasi_zainal.jpg','081234567805',6,1,'2026-09-03 01:06:11','2026-09-03 01:06:11'),(14,'Mahrus','Kasi Pelayanan','Kantor Balai Desa','199209142021051007','images/pamong/kasi_mahrus.jpg','081234567806',7,1,'2026-09-03 01:06:11','2026-09-03 01:06:11');
/*!40000 ALTER TABLE `perangkat_desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permohonan_surat`
--

DROP TABLE IF EXISTS `permohonan_surat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permohonan_surat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_permohonan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `petugas_id` bigint unsigned DEFAULT NULL,
  `jenis_surat_id` bigint unsigned NOT NULL,
  `status` enum('diajukan','diproses','disetujui','ditolak','butuh_koreksi','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `catatan_petugas` text COLLATE utf8mb4_unicode_ci,
  `file_pdf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_pemohon` json DEFAULT NULL,
  `tanggal_diproses` timestamp NULL DEFAULT NULL,
  `tanggal_selesai` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permohonan_surat_nomor_permohonan_unique` (`nomor_permohonan`),
  KEY `permohonan_surat_user_id_foreign` (`user_id`),
  KEY `permohonan_surat_petugas_id_foreign` (`petugas_id`),
  KEY `permohonan_surat_jenis_surat_id_foreign` (`jenis_surat_id`),
  KEY `permohonan_surat_status_created_at_index` (`status`,`created_at`),
  CONSTRAINT `permohonan_surat_jenis_surat_id_foreign` FOREIGN KEY (`jenis_surat_id`) REFERENCES `jenis_surat` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permohonan_surat_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `permohonan_surat_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permohonan_surat`
--

LOCK TABLES `permohonan_surat` WRITE;
/*!40000 ALTER TABLE `permohonan_surat` DISABLE KEYS */;
INSERT INTO `permohonan_surat` VALUES (1,'SRT/20260813/00001',4,1,1,'disetujui','Berkas lengkap. Surat Keterangan Tidak Mampu telah diterbitkan.',NULL,'{\"nik\": \"3529102904650001\", \"nama\": \"SUHRAWI\", \"alamat\": \"DUSUN KEBUNAN, RT 003 RW 002\"}','2026-08-30 08:43:46','2026-08-31 08:43:46','2026-09-01 08:43:46','2026-09-01 08:43:46'),(2,'SRT/20260813/00002',4,1,2,'diproses',NULL,NULL,'{\"nik\": \"3529102904650001\", \"nama\": \"SUHRAWI\", \"alamat\": \"DUSUN KEBUNAN, RT 003 RW 002\"}','2026-08-31 08:43:46',NULL,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(3,'SRT/20260813/00003',4,1,3,'butuh_koreksi','Mohon lampirkan foto tempat usaha yang lebih jelas.',NULL,'{\"nik\": \"3529102904650001\", \"nama\": \"SUHRAWI\", \"alamat\": \"DUSUN KEBUNAN, RT 003 RW 002\"}','2026-09-01 03:43:46',NULL,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(4,'SRT/20260813/00004',4,1,4,'disetujui','Permohonan surat disetujui.',NULL,'{\"nik\": \"3529102904650001\", \"nama\": \"SUHRAWI\", \"alamat\": \"DUSUN KEBUNAN, RT 003 RW 002\"}',NULL,'2026-09-08 05:42:48','2026-09-01 08:43:46','2026-09-08 05:42:48'),(5,'SRT/20260901/64546',21,1,3,'disetujui','yy',NULL,NULL,NULL,'2026-09-01 08:48:01','2026-09-01 08:46:56','2026-09-01 08:48:01'),(6,'SRT/20260905/6A38D',24,1,3,'disetujui','ABC',NULL,NULL,NULL,'2026-09-04 23:50:53','2026-09-04 23:38:47','2026-09-04 23:50:53'),(7,'SRT/20260905/12AA2',24,1,3,'disetujui','ABC',NULL,NULL,NULL,'2026-09-04 23:54:26','2026-09-04 23:54:05','2026-09-04 23:54:26'),(8,'SRT/20260905/98D23',24,1,5,'disetujui','HGHG',NULL,NULL,NULL,'2026-09-04 23:59:04','2026-09-04 23:57:44','2026-09-04 23:59:04'),(9,'SRT/20260906/45094',25,1,3,'disetujui','acvb',NULL,NULL,NULL,'2026-09-06 08:50:06','2026-09-06 08:48:09','2026-09-06 08:50:06'),(10,'SRT/20260907/255F1',25,1,1,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-06 17:08:33','2026-09-06 17:07:09','2026-09-06 17:08:33'),(11,'SRT/20260907/13048',20,1,3,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-07 03:15:15','2026-09-07 03:14:45','2026-09-07 03:15:15'),(12,'SRT/20260907/8EAA9',6,1,1,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-07 04:16:30','2026-09-07 04:15:59','2026-09-07 04:16:30'),(14,'SRT/20260908/22160',26,1,1,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-08 05:31:00','2026-09-08 05:30:35','2026-09-08 05:31:00'),(15,'SRT/20260908/5724E',26,1,5,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-08 05:35:08','2026-09-08 05:34:49','2026-09-08 05:35:08'),(16,'SRT/20260908/68F08',26,1,4,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-08 05:43:16','2026-09-08 05:42:30','2026-09-08 05:43:16'),(17,'SRT/20260910/2F8B9',4,1,3,'disetujui','acb',NULL,NULL,NULL,'2026-09-10 14:31:09','2026-09-10 14:30:19','2026-09-10 14:31:09'),(19,'SRT/20260912/52E92',4,NULL,1,'diajukan',NULL,NULL,NULL,NULL,NULL,'2026-09-12 05:07:22','2026-09-12 05:07:22'),(20,'SRT/20260914/B7169',4,1,2,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-14 05:13:22','2026-09-14 05:12:42','2026-09-14 05:13:22'),(21,'SRT/20260915/6119A',4,1,2,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-14 20:08:47','2026-09-14 20:08:22','2026-09-14 20:08:47'),(22,'SRT/20260915/CEF43',4,1,1,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-14 21:34:01','2026-09-14 21:33:32','2026-09-14 21:34:01'),(23,'SRT/20260915/854FB',4,1,5,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-14 22:27:40','2026-09-14 22:27:17','2026-09-14 22:27:40'),(24,'SRT/20260915/63AAE',4,1,1,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-14 22:47:00','2026-09-14 22:46:36','2026-09-14 22:47:00'),(25,'SRT/20260915/F3B2D',4,1,2,'disetujui','Permohonan surat disetujui.',NULL,NULL,NULL,'2026-09-14 23:02:29','2026-09-14 23:02:04','2026-09-14 23:02:29');
/*!40000 ALTER TABLE `permohonan_surat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil_desa`
--

DROP TABLE IF EXISTS `profil_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profil_desa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Rombiyah Barat',
  `kepala_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Farhah',
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ganding',
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sumenep',
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Jawa Timur',
  `kode_pos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '69462',
  `sejarah` text COLLATE utf8mb4_unicode_ci,
  `visi_misi` text COLLATE utf8mb4_unicode_ci,
  `dusun_list` json DEFAULT NULL,
  `potensi_desa` json DEFAULT NULL,
  `kontak` json DEFAULT NULL,
  `jam_operasional` json DEFAULT NULL,
  `statistik` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil_desa`
--

LOCK TABLES `profil_desa` WRITE;
/*!40000 ALTER TABLE `profil_desa` DISABLE KEYS */;
INSERT INTO `profil_desa` VALUES (1,'Rombiya Barat','hj.febri','Ganding','Sumenep','Jawa Timur','69462','Desa Rombiya Barat merupakan salah satu desa di wilayah Kecamatan Ganding, Kabupaten Sumenep, Madura, Jawa Timur. Desa ini memiliki tanah pertanian dan perkebunan yang subur dengan komoditas unggulan tembakau Madura, jagung, padi, dan olahan singkong, serta masyarakat yang menjunjung tinggi nilai gotong royong dan kearifan lokal keagamaan.','VISI:\nTerwujudnya Tata Kelola Pemerintahan dan Pelayanan Publik Desa Rombiya Barat yang Maju, Transparan, Adil, Sejahtera, dan Berbasis Digital Terpadu.\n\nMISI:\n1. Menyelenggarakan pelayanan administrasi dan persuratan desa yang cepat, transparan, dan bebas pungli.\n2. Mengoptimalkan pelayanan aspirasi dan pengaduan masyarakat di seluruh 5 dusun secara responsif.\n3. Meningkatkan kesejahteraan ekonomi warga melalui BUMDes Kencana dan pemberdayaan sektor pertanian tembakau & pangan.\n4. Mendorong transparansi penyaluran bantuan sosial (BLT-DD) dan pencegahan stunting melalui posyandu terintegrasi.','[{\"nama\": \"Dusun Kebunan\", \"kasun\": \"Kasun Kebunan\", \"deskripsi\": \"Sentra pertanian tanaman pangan dan perkebunan tembakau\", \"jumlah_rt\": 4}, {\"nama\": \"Dusun Buwa\", \"kasun\": \"Kasun Buwa\", \"deskripsi\": \"Wilayah pemukiman dan pertanian hortikultura\", \"jumlah_rt\": 3}, {\"nama\": \"Dusun Tanodung\", \"kasun\": \"Kasun Tanodung\", \"deskripsi\": \"Kawasan budidaya tanaman pangan dan peternakan rakyat\", \"jumlah_rt\": 4}, {\"nama\": \"Dusun Rombiya\", \"kasun\": \"Kasun Rombiya\", \"deskripsi\": \"Pusat kegiatan masyarakat dan sarana pendidikan\", \"jumlah_rt\": 4}, {\"nama\": \"Dusun Kalampok\", \"kasun\": \"Kasun Kalampok\", \"deskripsi\": \"Wilayah perkebunan dan sentra UMKM olahan singkong\", \"jumlah_rt\": 5}]','{\"umkm\": \"Keripik Singkong TTG, Makanan Olahan Tradisional, Kerajinan\", \"bumdes\": \"BUMDes Kencana (Perdagangan, Saprotan Pupuk, dan Jasa Desa)\", \"pertanian\": \"Pertanian Tembakau Madura, Padi, Jagung, dan Singkong (~298 Ha)\", \"peternakan\": \"Peternakan Sapi Madura dan Kambing\"}','{\"email\": \"pelayanan@rombiyabarat.desa.id\", \"telepon\": \"082334567890\", \"whatsapp\": \"082334567890\", \"alamat_kantor\": \"Jl. Raya Ganding - Rombiya Barat No. 01, Kec. Ganding, Kab. Sumenep, Jawa Timur 69462\"}','{\"Jumat\": \"08:00 - 11:30 WIB\", \"Senin - Kamis\": \"09:00 - 15:00 WIB\", \"Sabtu - Minggu\": \"Libur (Layanan Online 24 Jam)\"}','{\"jumlah_kk\": 560, \"jumlah_rt\": 20, \"jumlah_rw\": 5, \"sumber_data\": \"Disdukcapil Kabupaten Sumenep\", \"jumlah_dusun\": 5, \"jumlah_penduduk\": 1403, \"jumlah_laki_laki\": 652, \"jumlah_perempuan\": 751, \"jumlah_penduduk_max\": 1456}','2026-09-01 08:43:46','2026-09-15 16:30:06');
/*!40000 ALTER TABLE `profil_desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_bantuan`
--

DROP TABLE IF EXISTS `program_bantuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_bantuan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_program` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber_dana` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kriteria_penerima` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `syarat_dokumen` json DEFAULT NULL,
  `besaran_bantuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kuota_penerima` int DEFAULT NULL,
  `tahun_anggaran` int NOT NULL DEFAULT '2026',
  `status` enum('dibuka','proses_seleksi','penyaluran','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'penyaluran',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `foto_pengumuman` json DEFAULT NULL,
  `penanggung_jawab` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_bantuan`
--

LOCK TABLES `program_bantuan` WRITE;
/*!40000 ALTER TABLE `program_bantuan` DISABLE KEYS */;
INSERT INTO `program_bantuan` VALUES (1,'BLT Dana Desa (BLT-DD) Rombiya Barat TA 2026','blt_dana_desa','Alokasi Dana Desa (APBDes Rombiya Barat 2026)','Keluarga Penerima Manfaat (KPM) hasil Musyawarah Desa Khusus (Musdesus) yang belum tercover bansos PKH/BPNT.','[\"KTP Pemohon\", \"Kartu Keluarga (KK)\", \"Surat Penetapan KPM Musdesus\"]','Rp 300.000 / Bulan (Disalurkan Per Triwulan Rp 900.000)',85,2026,'penyaluran','Penyaluran tunai langsung di Balai Desa dihadiri BPD dan Pendamping Desa.',NULL,'Kepala Desa & Bendahara Desa','2026-09-01 08:43:46','2026-09-06 18:38:00'),(2,'Bantuan Pangan Cadangan Beras Pemerintah (CBP)','pangan_sembako','Badan Pangan Nasional / Bulog','Warga terdata dalam P3KE (Pensasaran Percepatan Penghapusan Kemiskinan Ekstrem) Desa Rombiya Barat.','[\"Fotokopi KTP\", \"Fotokopi KK\", \"Undangan barcode dari Kantor Pos/Desa\"]','10 kg Beras Medium / Bulan',320,2026,'penyaluran','Pengambilan beras dikoordinasikan oleh masing-masing Kepala Dusun di Balai Desa.',NULL,NULL,'2026-09-01 08:43:46','2026-09-06 18:38:00'),(3,'Bantuan Sarana Pupuk Organik & Pompa Air Pertanian','pertanian_bibit','Ketahanan Pangan Dana Desa 20% & Disperta Sumenep','Kelompok Tani (Poktan) & petani aktif tembakau/jagung di Dusun Kebunan, Buwa, Tanodung, Rombiya, Kalampok.','[\"KTP Petani\", \"Bukti Penggarap / Sertifikat / SPPT Lahan\", \"Rekomendasi Ketua Poktan\"]','Subsidi Pupuk Organik Cair & Pinjam Pakai Pompa Air Sawah',150,2026,'dibuka','Mendukung produktivitas komoditas tembakau Madura dan tanaman pangan musim tanam 2026.',NULL,NULL,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(4,'Program PMT Gizi Balita & Bumil (Pencegahan Stunting Desa)','kesehatan_stunting','Bidang Kesehatan Dana Desa & Puskesmas Ganding','Ibu hamil KEK (Kurang Energi Kronis) dan balita gizi kurang di 5 Posyandu Dusun.','[\"Buku KIA / KMS Balita\", \"Fotokopi KTP Orang Tua\", \"KK\"]','Paket Makanan Tambahan Bernutrisi Tinggi (Telur, Susu, Biskuit Gizi) selama 90 hari',45,2026,'penyaluran','Disalurkan saat jadwal posyandu bulanan di masing-masing dusun.',NULL,NULL,'2026-09-01 08:43:46','2026-09-01 08:43:46'),(5,'Program Keluarga Harapan (PKH) Kemensos RI','pkh','Kementerian Sosial RI (APBN)','Keluarga Miskin/Rentan terdaftar DTKS dengan komponen: Ibu Hamil/Nifas, Anak Balita, Anak Sekolah (SD/SMP/SMA), Lansia 60+ th, atau Penyandang Disabilitas Berat.','[\"KTP-el Asli\", \"Kartu Keluarga (KK)\", \"Kartu Keluarga Sejahtera (KKS/ATM Himbara)\"]','Bantuan Tunai Bersyarat Rp 225.000 - Rp 750.000 / Tahap',210,2026,'penyaluran','Pencairan melalui rekening Bank Himbara / PT Pos Indonesia terkoordinasi dengan Pendamping PKH Kecamatan Ganding.',NULL,'Zainal Abidin (Kasi Kesra) & Pendamping PKH','2026-09-03 01:06:11','2026-09-03 01:06:11'),(6,'Bansos Lansia & Disabilitas (PKH Plus Jawa Timur)','bansos_lansia','Dinas Sosial Provinsi Jawa Timur & Kab. Sumenep','Lansia berusia 60 tahun ke atas kurang mampu dan penyandang disabilitas berat non-produktif di 5 Dusun.','[\"Fotokopi KTP Lansia\", \"Fotokopi KK\", \"Surat Keterangan Domisili Dusun\"]','Bantuan Tunai Rp 600.000 / Triwulan',60,2026,'penyaluran','Penyaluran dapat diwakilkan oleh ahli waris dalam satu KK dengan membawa surat kuasa dan KTP asli.',NULL,'Kasi Kesra & Kepala Dusun Setempat','2026-09-03 01:06:11','2026-09-03 01:06:11'),(7,'Bantuan Cadangan Beras Pemerintah (CBP 10 Kg)','beras_cbp','Badan Pangan Nasional (Bapanas) & Perum BULOG','Warga KPM terdata dalam data Pensasaran Percepatan Penghapusan Kemiskinan Ekstrem (P3KE) Desa Rombiya Barat.','[\"KTP Asli Penerima\", \"Kartu Keluarga (KK)\", \"Undangan Pengambilan dari Balai Desa\"]','10 kg Beras Kualitas Medium / Bulan',320,2026,'penyaluran','Pengambilan beras dipusatkan di Kantor Balai Desa Rombiya Barat per jadwal dusun.',NULL,'Pemerintah Desa & 5 Kepala Dusun','2026-09-03 01:06:11','2026-09-06 18:38:00'),(8,'Bantuan Pangan Non Tunai (BPNT / Program Sembako)','bpnt_sembako','Kementerian Sosial RI (APBN)','Keluarga dengan kondisi sosial ekonomi 25% terendah di daerah pelaksanaan terdaftar di DTKS.','[\"Kartu Keluarga Sejahtera (KKS)\", \"KTP-el Asli\"]','Saldo Bansos Pangan Senilai Rp 200.000 / Bulan',195,2026,'penyaluran','Dapat dibelanjakan komoditas beras, telur, dan bahan pokok di e-Warong / Agen Resmi BUMDes Kencana.',NULL,'BUMDes Kencana & Kasi Kesra','2026-09-03 01:06:11','2026-09-03 01:06:11'),(9,'Bantuan Sarana Pupuk Bersubsidi & Bibit Tani','pertanian_pupuk','Ketahanan Pangan Dana Desa 20% & Disperta Sumenep','Petani terdaftar e-Alokasi Simluhtan dan tergabung dalam Kelompok Tani (Poktan) 5 Dusun.','[\"KTP Petani\", \"Kartu Tani / e-KTP Terdaftar\", \"SPPT Lahan Garapan\"]','Alokasi Pupuk NPK Phonska & Urea Bersubsidi serta Bibit Unggul',175,2026,'penyaluran','Pengambilan saprotan melalui unit usaha tani BUMDes Kencana Rombiya Barat.',NULL,'Pengurus BUMDes Kencana & Ketua Poktan','2026-09-03 01:06:11','2026-09-06 18:38:00');
/*!40000 ALTER TABLE `program_bantuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('jFS0W7rGwNE7hs4wEJIk5c8uv5j6MKk4JvLu9y18',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ1ZzJUUHZaOEt4Rk9HUFM3QVg1d0RTMTdXaldRbzNVSjVVMVdHSUl2IiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDAiLCJyb3V0ZSI6IndhcmdhLmxhbmRpbmcifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjV9',1789520671);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'warga',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nik_unique` (`nik`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator Desa Rombiya Barat','3529100101850001','admin@rombiyahbarat.desa.id','081234567890','Kantor Balai Desa Rombiya Barat, Kec. Ganding','admin',1,NULL,'$2y$12$ipJ6RZ9aybqxMCZHw1Iy2enYo60EIutT/8omG2AB.DBAXv.U0C8tq','VNUEVVzUmmMr1SEhex2jOwgS989yOTo2Kxqo2s9DjfU2xRulA1zL3tOpwDxe','2026-09-01 08:43:39','2026-09-06 18:38:00'),(2,'Petugas Pelayanan Desa','3529100202900002','petugas@rombiyahbarat.desa.id','081234567891','Kantor Balai Desa Rombiya Barat, Kec. Ganding','petugas',1,NULL,'$2y$12$JhPdzc3kktv33E6iVfzxLueBnUcSigY2OQtvd5/l3Si34u4zHZSpa',NULL,'2026-09-01 08:43:39','2026-09-06 18:38:00'),(3,'Budi Santoso','3529101508850003','warga@gmail.com','085712345678','Dusun Kebunan, RT 002 RW 002, Rombiya Barat','warga',1,NULL,'$2y$12$rEECFkEpXfD528VJrUcu8uPbMAmvxyZpIr29he4QMp7WRiPli/.e.',NULL,'2026-09-01 08:43:40','2026-09-06 18:38:00'),(4,'SUHRAWI','3529102904650001','suhrawi@gmail.com','087880433119','DUSUN KEBUNAN, RT 003 RW 002','warga',1,NULL,'$2y$12$NhV.VojeVJ//j/KhkN1fKu7CN5VDraZNisHne9Oe4BnB.QqNJIG3K',NULL,'2026-09-01 08:43:40','2026-09-15 16:26:57'),(5,'Moh Sabri','3529100107430086','mohsabri@gmail.com','087880433119','DUSUN KEBUNAN, RT 001 RW 002','warga',1,NULL,'$2y$12$3ksL6pjhEpI8iJd8E.JoKeIQgF0CneaMUNFMudPuzBKI83pySJdmq',NULL,'2026-09-01 08:43:40','2026-09-15 16:47:55'),(6,'BADRIYAH','3529104307730001','badriyah@gmail.com',NULL,'DUSUN KEBUNAN, RT 002 RW 002','warga',1,NULL,'$2y$12$4ap3j92EfWExIO5uxRk7RuxGev8qpqvwIavLfcM9BNsEMdeXzP3kW',NULL,'2026-09-01 08:43:41','2026-09-07 04:13:51'),(7,'KHAIRUL ANAM','3529101807020003','khairulanam@gmail.com',NULL,'DUSUN KEBUNAN, RT 003 RW 002','warga',1,NULL,'$2y$12$4TrqMDX2cbgOameWn1UWduOgwyI0iwoXHR3r/D/HBr4LhOi1j.Ppe',NULL,'2026-09-01 08:43:41','2026-09-01 08:43:41'),(8,'HIRA','3529104107540064','hira@gmail.com',NULL,'DUSUN KEBUNAN, RT 003 RW 002','warga',1,NULL,'$2y$12$ICLmufSoRTaGaWEDSeyvMeNsxLBD6oZR0M4HXQ40ULmkF0dyOwqXu',NULL,'2026-09-01 08:43:41','2026-09-01 08:43:41'),(9,'MUSLIHAH','3529104107730153','muslihah@gmail.com',NULL,'DUSUN BUWA, RT 001 RW 001','warga',1,NULL,'$2y$12$i7nHANYQOlfhbMpWRfqjEeHLtvAMH5ssGMPNA8EUbt97TsvAdvM6y',NULL,'2026-09-01 08:43:42','2026-09-01 08:43:42'),(10,'HARIYA','3529100107680167','hariya@gmail.com',NULL,'DUSUN BUWA, RT 001 RW 001','warga',1,NULL,'$2y$12$n/svibPbGV7HdzrER74H.uEAt13ks8VkFO2DHi3Ya5GU/Bx4J8VOa',NULL,'2026-09-01 08:43:42','2026-09-01 08:43:42'),(11,'ROKAYYAH','3529104107600210','rokayyah@gmail.com',NULL,'DUSUN TANODUNG, RT 003 RW 004','warga',1,NULL,'$2y$12$6zJXmhNnkSE14LvFR2BRtOwgDFj2Ne8fbUrPMR8IbIRSh9bnXYzlu',NULL,'2026-09-01 08:43:42','2026-09-01 08:43:42'),(12,'SYARIFAH','3529105208020003','syarifah@gmail.com',NULL,'DUSUN TANODUNG, RT 003 RW 004','warga',1,NULL,'$2y$12$eoPCZwnxvcnclx3A4vtYc.dbF..hAgojKq3GONbwuLdeO7cW3SXI.',NULL,'2026-09-01 08:43:43','2026-09-01 08:43:43'),(13,'AMRI','3529104107430162','amri@gmail.com',NULL,'DUSUN ROMBIYA, RT 003 RW 002','warga',1,NULL,'$2y$12$.GbUCWwoeO1dU0UtXffyB.VmjciEuDlreg0VB.Wosy/tE9KkZDrKK',NULL,'2026-09-01 08:43:43','2026-09-01 08:43:43'),(14,'RIAN MOR HIDAYAT','3529100506040002','rianmorhidayat@gmail.com',NULL,'DUSUN ROMBIYA, RT 003 RW 003','warga',1,NULL,'$2y$12$nFnEEBmbZK4ZvH8FjlmZ6uda0j7ABQGIjKJeSEDWwM9xNdygIItW.',NULL,'2026-09-01 08:43:44','2026-09-01 08:43:44'),(15,'ALMA','3529104107500168','alma@gmail.com',NULL,'DUSUN KALAMPOK, RT 002 RW 005','warga',1,NULL,'$2y$12$EEeC1t4ZJJn1N0nowjzeIegAqXwS3RLHFmwsFaaYi9.CI//VBEM0y',NULL,'2026-09-01 08:43:44','2026-09-01 08:43:44'),(16,'KUTSIYAH','352910700677004','kutsiyah@gmail.com',NULL,'DUSUN KALAMPOK, RT 002 RW 005','warga',1,NULL,'$2y$12$V27CnOa7Kbjg.N.RljOlJ.N.pYw7l2AyyM77DCsHFuP5cyC2XtuPG',NULL,'2026-09-01 08:43:44','2026-09-01 08:43:44'),(17,'EDJU','3529104107400015','edju@gmail.com',NULL,'DUSUN TANODUNG, RT 004 RW 004','warga',1,NULL,'$2y$12$/c1wZKDfPBGSLVGfAlkMFei/En2eOO154v.4cKSCe9i6DAFsm3Kh.',NULL,'2026-09-01 08:43:45','2026-09-01 08:43:45'),(18,'ABD. MUNI','3529102104600002','abdmuni@gmail.com',NULL,'DUSUN TANODUNG, RT 004 RW 004','warga',1,NULL,'$2y$12$KptG5hErpNmy2RYX60MM4u6m8XEZ3quGL/ad30kwk7h./ByjEwCAC',NULL,'2026-09-01 08:43:45','2026-09-01 08:43:45'),(19,'SUANI','3529104107420060','suani@gmail.com',NULL,'DUSUN KALAMPOK, RT 002 RW 005','warga',1,NULL,'$2y$12$s05yu4YUlEkLyk4RZ.JDH.8TZgf4hYkoq.sUbl3LxOm4oJlYJnfJy',NULL,'2026-09-01 08:43:45','2026-09-01 08:43:45'),(20,'MOH ROFIQI','3529101504040003','mohrofiqi@gmail.com',NULL,'DUSUN KALAMPOK, RT 001 RW 005','warga',1,NULL,'$2y$12$/LOK8qGzt04wvx6ETGqA7.ZYOM0DXP0sph2FijNzN6BfuSr/FiOGG',NULL,'2026-09-01 08:43:46','2026-09-07 03:13:25'),(21,'ahmad','3542389764144668','ahmad@gmail.com','087880433119','anjey','warga',1,NULL,'$2y$12$nLHcBNpMrtudVobsTA3/fuI4b5r8C3PYtsPiRhDH.fG6A68lUz0Dm',NULL,'2026-09-01 08:46:03','2026-09-15 16:11:01'),(22,'fulanm','3528987363562782','fulanm@gmail.com','087718975696','cegung','warga',1,NULL,'$2y$12$2502TiaKICbBdoDNLHBk8ONuX2tIVVA3DQDQCJtQ.ZPjpiA245/CS',NULL,'2026-09-02 08:35:20','2026-09-02 08:35:20'),(23,'Badriyah','3577623637627627','badriyahhh@gmail.com','087718975696','yyyy','warga',1,NULL,'$2y$12$7NT3n9CeZ2u.xfnzp4jz1.Qf6SfAYgwwzbWoGlAdzuI51vLRsMXNq',NULL,'2026-09-03 00:34:04','2026-09-03 00:34:04'),(24,'fulann','3529101705020003','sabri@gmail.com','087880433119','kebunan','warga',1,NULL,'$2y$12$Y5Bc8wzBFT2vqNv20VNPOOup0GA70z185uEU418ZhxwzUXQZodHwe',NULL,'2026-09-04 23:29:36','2026-09-06 07:43:16'),(25,'moh sabri','3529095410850003','sabri07@gmail.com','087880433119','idonisia','warga',1,NULL,'$2y$12$ecDExzxxOPK24a7NfBEFoe74z1kuLLvypmkaO0hPoLRtC9Xnu1HVK',NULL,'2026-09-06 08:45:40','2026-09-06 08:45:40'),(26,'moh sabri','1234567899340987','fulann07@gmail.com','abccc','kebunan','warga',1,NULL,'$2y$12$pwV1anJxVuAMBdveTVsakeLseZJTgMz8c8Sc3YhJlyjO4LhQiJTJ6',NULL,'2026-09-08 04:43:47','2026-09-08 04:43:47');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whatsapp_logs`
--

DROP TABLE IF EXISTS `whatsapp_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_tujuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_penerima` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_pesan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'surat',
  `referensi_id` bigint unsigned DEFAULT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','sent','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `response_payload` json DEFAULT NULL,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `whatsapp_logs_status_created_at_index` (`status`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whatsapp_logs`
--

LOCK TABLES `whatsapp_logs` WRITE;
/*!40000 ALTER TABLE `whatsapp_logs` DISABLE KEYS */;
INSERT INTO `whatsapp_logs` VALUES (1,'6282334567890','Bahruddin','surat',1,'Kabar Baik Bapak/Ibu *Bahruddin*,\n\nPermohonan surat Anda telah *DISETUJUI & SELESAI DITERBITKAN* secara resmi oleh Pemerintah Desa Rombiya Barat.\n\n📄 *Jenis Surat:* Surat Keterangan Usaha (SKU)\n🔢 *Nomor Registrasi:* SRT/20260912/99A12\n📅 *Tanggal Terbit:* 12 Sep 2026 11:10\n\nAnda dapat mengunduh dan mencetak langsung dokumen surat resmi berformat PDF melalui tautan berikut:\n📥 http://localhost:8000/layanan/surat/1/pdf\n\nSurat ini sah dan dilengkapi kode verifikasi digital desa.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','failed',NULL,'cURL error 7: Failed to connect to 127.0.0.1:3100 after 2019 ms: Could not connect to server (see https://curl.se/libcurl/c/libcurl-errors.html) for http://127.0.0.1:3100/send/message',NULL,'2026-09-12 04:10:36','2026-09-12 04:10:38'),(2,'6285954154437','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','failed','{\"error\": \"Gagal mengirim pesan: failed to save cached sessions: failed to store cached sessions: transaction: begin: SQL logic error: cannot start a transaction within a transaction (1)\"}','Gateway merespons: HTTP 500',NULL,'2026-09-12 04:38:53','2026-09-12 04:38:55'),(3,'6285954154437','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','failed','{\"error\": \"Gagal mengirim pesan: failed to save cached sessions: failed to store cached sessions: transaction: begin: SQL logic error: cannot start a transaction within a transaction (1)\"}','Gateway merespons: HTTP 500',NULL,'2026-09-12 04:39:09','2026-09-12 04:39:10'),(4,'6285954154437','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','sent','{\"success\": true, \"timestamp\": \"2026-09-12T11:52:04+07:00\", \"message_id\": \"3EB0BADE4037C70494DDEA\"}',NULL,'2026-09-12 04:52:02','2026-09-12 04:52:01','2026-09-12 04:52:02'),(5,'6285954154437','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','sent','{\"success\": true, \"timestamp\": \"2026-09-12T11:53:15+07:00\", \"message_id\": \"3EB0A47FC3B35940D49327\"}',NULL,'2026-09-12 04:53:13','2026-09-12 04:53:13','2026-09-12 04:53:13'),(6,'6285954154437','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','sent','{\"success\": true, \"timestamp\": \"2026-09-12T11:53:38+07:00\", \"message_id\": \"3EB04E11BA29AE4D498EC5\"}',NULL,'2026-09-12 04:53:37','2026-09-12 04:53:36','2026-09-12 04:53:37'),(7,'6282334567890','Petugas Pelayanan Desa','pengaduan',14,'📢 *LAPORAN ASPIRASI / PENGADUAN WARGA BARU*\n\nYth. Petugas & Kepala Dusun,\nTerdapat pengaduan masyarakat yang baru disampaikan warga:\n\n🎫 *No. Tiket:* LAPOR-20260912-0001\n👤 *Pelapor:* SUHRAWI\n📍 *Lokasi Dusun:* Dusun Kebunan\n📂 *Kategori:* jalan_infrastruktur\n📋 *Judul Laporan:* abc\n\nDetail tindak lanjut dapat diakses di panel admin:\n🔗 http://127.0.0.1:8000/admin/pengaduans/14/edit\n\n_SIPEDES Desa Rombiya Barat_','sent','{\"success\": true, \"timestamp\": \"2026-09-12T12:06:30+07:00\", \"message_id\": \"3EB0CB4DF8F6419605F5EA\"}',NULL,'2026-09-12 05:06:28','2026-09-12 05:06:27','2026-09-12 05:06:28'),(8,'6282334567890','Petugas Pelayanan Desa','surat',19,'🔔 *NOTIFIKASI SURAT BARU — SIPEDES DESA ROMBIYA BARAT*\n\nYth. Petugas / Pamong Desa,\nTerdapat permohonan surat baru yang masuk dan membutuhkan verifikasi:\n\n📄 *Jenis Surat:* Surat Keterangan Tidak Mampu (SKTM)\n🔢 *Nomor:* SRT/20260912/52E92\n👤 *Pemohon:* SUHRAWI\n📍 *Dusun:* DUSUN KEBUNAN, RT 003 RW 002\n🕒 *Waktu Pengajuan:* 12 Sep 2026 12:07 WIB\n\nSilakan buka panel dashboard SIPEDES untuk memverifikasi berkas persyaratan:\n🔗 http://127.0.0.1:8000/admin/permohonan-surats/19\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-12T12:07:24+07:00\", \"message_id\": \"3EB061D6F501E7FE21988B\"}',NULL,'2026-09-12 05:07:23','2026-09-12 05:07:22','2026-09-12 05:07:23'),(9,'6282334567890','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','sent','{\"success\": true, \"timestamp\": \"2026-09-14T11:40:41+07:00\", \"message_id\": \"3EB0DE3B27C82483B2EF74\"}',NULL,'2026-09-14 04:40:41','2026-09-14 04:40:40','2026-09-14 04:40:41'),(10,'6282334567890','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','sent','{\"success\": true, \"timestamp\": \"2026-09-14T11:40:47+07:00\", \"message_id\": \"3EB0DBFED749540CFF91F6\"}',NULL,'2026-09-14 04:40:47','2026-09-14 04:40:47','2026-09-14 04:40:47'),(11,'6282334567890','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','sent','{\"success\": true, \"timestamp\": \"2026-09-14T11:40:49+07:00\", \"message_id\": \"3EB06794371B7A8243790A\"}',NULL,'2026-09-14 04:40:49','2026-09-14 04:40:49','2026-09-14 04:40:49'),(12,'6287880433119','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','sent','{\"success\": true, \"timestamp\": \"2026-09-14T11:41:38+07:00\", \"message_id\": \"3EB0AB297F014D2DE39B17\"}',NULL,'2026-09-14 04:41:38','2026-09-14 04:41:37','2026-09-14 04:41:38'),(13,'6285954154437','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','sent','{\"success\": true, \"timestamp\": \"2026-09-14T11:55:15+07:00\", \"message_id\": \"3EB0A80B2B6BDB58E4A4F3\"}',NULL,'2026-09-14 04:55:15','2026-09-14 04:55:14','2026-09-14 04:55:15'),(14,'6285954154437','Uji Coba Admin','sistem',NULL,'Halo! Ini adalah pesan uji coba dari SIPEDES WhatsApp Gateway Desa Rombiya Barat.','sent','{\"success\": true, \"timestamp\": \"2026-09-14T11:56:24+07:00\", \"message_id\": \"3EB0A122DDE5A1DB57F0FE\"}',NULL,'2026-09-14 04:56:23','2026-09-14 04:56:23','2026-09-14 04:56:23'),(15,'6282334567890','Petugas Pelayanan Desa','surat',20,'🔔 *NOTIFIKASI SURAT BARU — SIPEDES DESA ROMBIYA BARAT*\n\nYth. Petugas / Pamong Desa,\nTerdapat permohonan surat baru yang masuk dan membutuhkan verifikasi:\n\n📄 *Jenis Surat:* Surat Keterangan Domisili\n🔢 *Nomor:* SRT/20260914/B7169\n👤 *Pemohon:* SUHRAWI\n📍 *Dusun:* DUSUN KEBUNAN, RT 003 RW 002\n🕒 *Waktu Pengajuan:* 14 Sep 2026 12:12 WIB\n\nSilakan buka panel dashboard SIPEDES untuk memverifikasi berkas persyaratan:\n🔗 http://localhost:8000/admin/permohonan-surats/20\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-14T12:12:46+07:00\", \"message_id\": \"3EB073D9E86AFD3FC50081\"}',NULL,'2026-09-14 05:12:46','2026-09-14 05:12:45','2026-09-14 05:12:46'),(16,'6287880433119','ahmad','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *ahmad*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *150153*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T08:56:38+07:00\", \"message_id\": \"3EB04D4B229EF33026DEA1\"}',NULL,'2026-09-14 18:56:37','2026-09-14 18:56:35','2026-09-14 18:56:37'),(17,'6287880433119','ahmad','sistem',NULL,'✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *ahmad*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada 15 September 2026 01:58 WIB.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T08:58:21+07:00\", \"message_id\": \"3EB0AD6F927E1A44030EFF\"}',NULL,'2026-09-14 18:58:20','2026-09-14 18:58:20','2026-09-14 18:58:20'),(18,'6282334567890','Petugas Pelayanan Desa','surat',21,'🔔 *NOTIFIKASI SURAT BARU — SIPEDES DESA ROMBIYA BARAT*\n\nYth. Petugas / Pamong Desa,\nTerdapat permohonan surat baru yang masuk dan membutuhkan verifikasi:\n\n📄 *Jenis Surat:* Surat Keterangan Domisili\n🔢 *Nomor:* SRT/20260915/6119A\n👤 *Pemohon:* SUHRAWI\n📍 *Dusun:* DUSUN KEBUNAN, RT 003 RW 002\n🕒 *Waktu Pengajuan:* 15 Sep 2026 03:08 WIB\n\nSilakan buka panel dashboard SIPEDES untuk memverifikasi berkas persyaratan:\n🔗 http://localhost:8000/admin/permohonan-surats/21\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T10:08:27+07:00\", \"message_id\": \"3EB05A69AAC3CAB4670C00\"}',NULL,'2026-09-14 20:08:26','2026-09-14 20:08:25','2026-09-14 20:08:26'),(19,'6282334567890','Petugas Pelayanan Desa','surat',22,'🔔 *NOTIFIKASI SURAT BARU — SIPEDES DESA ROMBIYA BARAT*\n\nYth. Petugas / Pamong Desa,\nTerdapat permohonan surat baru yang masuk dan membutuhkan verifikasi:\n\n📄 *Jenis Surat:* Surat Keterangan Tidak Mampu (SKTM)\n🔢 *Nomor:* SRT/20260915/CEF43\n👤 *Pemohon:* SUHRAWI\n📍 *Dusun:* DUSUN KEBUNAN, RT 003 RW 002\n🕒 *Waktu Pengajuan:* 15 Sep 2026 04:33 WIB\n\nSilakan buka panel dashboard SIPEDES untuk memverifikasi berkas persyaratan:\n🔗 http://localhost:8000/admin/permohonan-surats/22\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T11:33:38+07:00\", \"message_id\": \"3EB009CE605F2372E571B1\"}',NULL,'2026-09-14 21:33:37','2026-09-14 21:33:36','2026-09-14 21:33:37'),(20,'6282334567890','Petugas Pelayanan Desa','surat',23,'🔔 *NOTIFIKASI SURAT BARU — SIPEDES DESA ROMBIYA BARAT*\n\nYth. Petugas / Pamong Desa,\nTerdapat permohonan surat baru yang masuk dan membutuhkan verifikasi:\n\n📄 *Jenis Surat:* Surat Keterangan Kematian\n🔢 *Nomor:* SRT/20260915/854FB\n👤 *Pemohon:* SUHRAWI\n📍 *Dusun:* DUSUN KEBUNAN, RT 003 RW 002\n🕒 *Waktu Pengajuan:* 15 Sep 2026 05:27 WIB\n\nSilakan buka panel dashboard SIPEDES untuk memverifikasi berkas persyaratan:\n🔗 http://localhost:8000/admin/permohonan-surats/23\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T12:27:20+07:00\", \"message_id\": \"3EB0036A489A7C9CB5690E\"}',NULL,'2026-09-14 22:27:19','2026-09-14 22:27:19','2026-09-14 22:27:19'),(21,'6282334567890','Petugas Pelayanan Desa','surat',24,'🔔 *NOTIFIKASI SURAT BARU — SIPEDES DESA ROMBIYA BARAT*\n\nYth. Petugas / Pamong Desa,\nTerdapat permohonan surat baru yang masuk dan membutuhkan verifikasi:\n\n📄 *Jenis Surat:* Surat Keterangan Tidak Mampu (SKTM)\n🔢 *Nomor:* SRT/20260915/63AAE\n👤 *Pemohon:* SUHRAWI\n📍 *Dusun:* DUSUN KEBUNAN, RT 003 RW 002\n🕒 *Waktu Pengajuan:* 15 Sep 2026 05:46 WIB\n\nSilakan buka panel dashboard SIPEDES untuk memverifikasi berkas persyaratan:\n🔗 http://localhost:8000/admin/permohonan-surats/24\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T12:46:40+07:00\", \"message_id\": \"3EB0E829E7E5A89C8EBCCA\"}',NULL,'2026-09-14 22:46:39','2026-09-14 22:46:39','2026-09-14 22:46:39'),(22,'6282334567890','Petugas Pelayanan Desa','surat',25,'🔔 *NOTIFIKASI SURAT BARU — SIPEDES DESA ROMBIYA BARAT*\n\nYth. Petugas / Pamong Desa,\nTerdapat permohonan surat baru yang masuk dan membutuhkan verifikasi:\n\n📄 *Jenis Surat:* Surat Keterangan Domisili\n🔢 *Nomor:* SRT/20260915/F3B2D\n👤 *Pemohon:* SUHRAWI\n📍 *Dusun:* DUSUN KEBUNAN, RT 003 RW 002\n🕒 *Waktu Pengajuan:* 15 Sep 2026 06:02 WIB\n\nSilakan buka panel dashboard SIPEDES untuk memverifikasi berkas persyaratan:\n🔗 http://localhost:8000/admin/permohonan-surats/25\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T13:02:09+07:00\", \"message_id\": \"3EB0A8F37C30E79091A881\"}',NULL,'2026-09-14 23:02:08','2026-09-14 23:02:08','2026-09-14 23:02:08'),(23,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *643529*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T14:05:27+07:00\", \"message_id\": \"3EB0F6D61790A1BC9B5FAA\"}',NULL,'2026-09-15 00:05:25','2026-09-15 00:05:25','2026-09-15 00:05:25'),(24,'6285954144435','Moh Sabri','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *Moh Sabri*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *227149*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','failed','{\"error\": \"Gagal mengirim pesan: no LID found for 6285954144435@s.whatsapp.net from server\"}','Gateway merespons: Gagal mengirim pesan: no LID found for 6285954144435@s.whatsapp.net from server',NULL,'2026-09-15 13:42:46','2026-09-15 13:42:48'),(25,'6285954144435','Moh Sabri','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *Moh Sabri*,\n\nKode verifikasi OTP untuk mengatur ulang kata sandi akun SIPEDES Anda adalah:\n\n👉 *227149*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapapun demi keamanan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','failed','{\"error\": \"Gagal mengirim pesan: no LID found for 6285954144435@s.whatsapp.net from server\"}','Gateway merespons: Gagal mengirim pesan: no LID found for 6285954144435@s.whatsapp.net from server',NULL,'2026-09-15 13:42:48','2026-09-15 13:42:48'),(26,'6285954144435','Moh Sabri','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *Moh Sabri*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *205098*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','failed','{\"error\": \"Gagal mengirim pesan: no LID found for 6285954144435@s.whatsapp.net from server\"}','Gateway merespons: Gagal mengirim pesan: no LID found for 6285954144435@s.whatsapp.net from server',NULL,'2026-09-15 13:44:03','2026-09-15 13:44:03'),(27,'6285954144435','Moh Sabri','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *Moh Sabri*,\n\nKode verifikasi OTP untuk mengatur ulang kata sandi akun SIPEDES Anda adalah:\n\n👉 *205098*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapapun demi keamanan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','failed','{\"error\": \"Gagal mengirim pesan: no LID found for 6285954144435@s.whatsapp.net from server\"}','Gateway merespons: Gagal mengirim pesan: no LID found for 6285954144435@s.whatsapp.net from server',NULL,'2026-09-15 13:44:03','2026-09-15 13:44:03'),(28,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *370311*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T20:49:46+07:00\", \"message_id\": \"3EB009D7AE86F3C7842E15\"}',NULL,'2026-09-15 13:49:45','2026-09-15 13:49:45','2026-09-15 13:49:45'),(29,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *590506*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T20:50:54+07:00\", \"message_id\": \"3EB0622FEBDD491F246F34\"}',NULL,'2026-09-15 13:50:54','2026-09-15 13:50:54','2026-09-15 13:50:54'),(30,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *406737*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T20:54:56+07:00\", \"message_id\": \"3EB0710168CF4A3DD44E78\"}',NULL,'2026-09-15 13:54:56','2026-09-15 13:54:56','2026-09-15 13:54:56'),(31,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *244842*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:12:42+07:00\", \"message_id\": \"3EB0E607395DC37517F27A\"}',NULL,'2026-09-15 14:12:42','2026-09-15 14:12:41','2026-09-15 14:12:42'),(32,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *368925*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:13:47+07:00\", \"message_id\": \"3EB058D06E010FEF044B6B\"}',NULL,'2026-09-15 14:13:46','2026-09-15 14:13:46','2026-09-15 14:13:46'),(33,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *355310*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:20:22+07:00\", \"message_id\": \"3EB01DA9373A9EC15CC41E\"}',NULL,'2026-09-15 14:20:21','2026-09-15 14:20:21','2026-09-15 14:20:21'),(34,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *320187*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:27:06+07:00\", \"message_id\": \"3EB07580D3DBFC2AB55969\"}',NULL,'2026-09-15 14:27:05','2026-09-15 14:27:05','2026-09-15 14:27:05'),(35,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *179547*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:35:23+07:00\", \"message_id\": \"3EB074AA59EA658FCF0BFE\"}',NULL,'2026-09-15 14:35:22','2026-09-15 14:35:22','2026-09-15 14:35:22'),(36,'6287880433119','Moh Sabri','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *Moh Sabri*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *720617*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:37:10+07:00\", \"message_id\": \"3EB04F66EC06CC5DF9275C\"}',NULL,'2026-09-15 14:37:09','2026-09-15 14:37:09','2026-09-15 14:37:09'),(37,'6287880433119','Moh Sabri','sistem',NULL,'✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *Moh Sabri*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada 15 September 2026 21:38 WIB.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:38:03+07:00\", \"message_id\": \"3EB061F87CE198C5914B30\"}',NULL,'2026-09-15 14:38:02','2026-09-15 14:38:02','2026-09-15 14:38:02'),(38,'6287880433119','Moh Sabri','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *Moh Sabri*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *558037*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:38:21+07:00\", \"message_id\": \"3EB0FFBEA2BE150CD2699E\"}',NULL,'2026-09-15 14:38:20','2026-09-15 14:38:20','2026-09-15 14:38:20'),(39,'6287880433119','Moh Sabri','sistem',NULL,'✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *Moh Sabri*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada 15 September 2026 21:38 WIB.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:38:56+07:00\", \"message_id\": \"3EB0AA33860D6242CDD706\"}',NULL,'2026-09-15 14:38:55','2026-09-15 14:38:55','2026-09-15 14:38:55'),(40,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *839079*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:39:23+07:00\", \"message_id\": \"3EB0D9883A45E8DAA20B19\"}',NULL,'2026-09-15 14:39:23','2026-09-15 14:39:22','2026-09-15 14:39:23'),(41,'6287880433119','SUHRAWI','sistem',NULL,'✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *SUHRAWI*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada 15 September 2026 21:40 WIB.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T21:40:12+07:00\", \"message_id\": \"3EB0FDE19B9D78BA5D4467\"}',NULL,'2026-09-15 14:40:11','2026-09-15 14:40:11','2026-09-15 14:40:11'),(42,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *413271*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T22:34:06+07:00\", \"message_id\": \"3EB02077774A567C79385F\"}',NULL,'2026-09-15 15:34:06','2026-09-15 15:34:04','2026-09-15 15:34:06'),(43,'6287880433119','SUHRAWI','sistem',NULL,'✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *SUHRAWI*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada 15 September 2026 22:35 WIB.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T22:35:09+07:00\", \"message_id\": \"3EB01EA7530377A9D025B8\"}',NULL,'2026-09-15 15:35:09','2026-09-15 15:35:08','2026-09-15 15:35:09'),(44,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *545594*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T23:07:43+07:00\", \"message_id\": \"3EB0432B822EABAB94419D\"}',NULL,'2026-09-15 16:07:43','2026-09-15 16:07:43','2026-09-15 16:07:43'),(45,'6287880433119','SUHRAWI','sistem',NULL,'✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *SUHRAWI*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada 15 September 2026 23:09 WIB.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T23:09:20+07:00\", \"message_id\": \"3EB0E9773AFE987DDFD7C9\"}',NULL,'2026-09-15 16:09:20','2026-09-15 16:09:19','2026-09-15 16:09:20'),(46,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *829427*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T23:09:34+07:00\", \"message_id\": \"3EB031887E7701239D5C30\"}',NULL,'2026-09-15 16:09:33','2026-09-15 16:09:33','2026-09-15 16:09:33'),(47,'6287880433119','SUHRAWI','sistem',NULL,'✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *SUHRAWI*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada 15 September 2026 23:09 WIB.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T23:09:53+07:00\", \"message_id\": \"3EB0C372AD629AABF69D11\"}',NULL,'2026-09-15 16:09:52','2026-09-15 16:09:52','2026-09-15 16:09:52'),(48,'6287880433119','ahmad','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *ahmad*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *729498*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T23:10:28+07:00\", \"message_id\": \"3EB03371BB5C77833C12AF\"}',NULL,'2026-09-15 16:10:28','2026-09-15 16:10:28','2026-09-15 16:10:28'),(49,'6287880433119','ahmad','sistem',NULL,'✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *ahmad*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada 15 September 2026 23:11 WIB.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T23:11:02+07:00\", \"message_id\": \"3EB028BC8A870FBF40C8C5\"}',NULL,'2026-09-15 16:11:01','2026-09-15 16:11:01','2026-09-15 16:11:01'),(50,'6287880433119','SUHRAWI','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *SUHRAWI*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *127271*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T23:26:14+07:00\", \"message_id\": \"3EB079E5D9472D74A66613\"}',NULL,'2026-09-15 16:26:13','2026-09-15 16:26:13','2026-09-15 16:26:13'),(51,'6287880433119','SUHRAWI','sistem',NULL,'✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *SUHRAWI*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada 15 September 2026 23:26 WIB.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T23:26:58+07:00\", \"message_id\": \"3EB0A2C7C16D465E19488A\"}',NULL,'2026-09-15 16:26:58','2026-09-15 16:26:57','2026-09-15 16:26:58'),(52,'6287880433119','Moh Sabri','sistem',NULL,'🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *Moh Sabri*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *969345*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T23:47:11+07:00\", \"message_id\": \"3EB0F398488C0C052E5EA2\"}',NULL,'2026-09-15 16:47:10','2026-09-15 16:47:10','2026-09-15 16:47:10'),(53,'6287880433119','Moh Sabri','sistem',NULL,'✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *Moh Sabri*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada 15 September 2026 23:47 WIB.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','sent','{\"success\": true, \"timestamp\": \"2026-09-15T23:47:56+07:00\", \"message_id\": \"3EB0244ABB07B0E8CF01F3\"}',NULL,'2026-09-15 16:47:55','2026-09-15 16:47:55','2026-09-15 16:47:55');
/*!40000 ALTER TABLE `whatsapp_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whatsapp_templates`
--

DROP TABLE IF EXISTS `whatsapp_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('surat','pengaduan','sistem') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'surat',
  `target` enum('warga','petugas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'warga',
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `variabel_tersedia` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `whatsapp_templates_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whatsapp_templates`
--

LOCK TABLES `whatsapp_templates` WRITE;
/*!40000 ALTER TABLE `whatsapp_templates` DISABLE KEYS */;
INSERT INTO `whatsapp_templates` VALUES (1,'surat_masuk_petugas','Notifikasi Pengajuan Surat Baru (ke Petugas/Pamong)','surat','petugas','🔔 *NOTIFIKASI SURAT BARU — SIPEDES DESA ROMBIYA BARAT*\n\nYth. Petugas / Pamong Desa,\nTerdapat permohonan surat baru yang masuk dan membutuhkan verifikasi:\n\n📄 *Jenis Surat:* {jenis_surat}\n🔢 *Nomor:* {nomor_permohonan}\n👤 *Pemohon:* {nama_pemohon}\n📍 *Dusun:* {dusun}\n🕒 *Waktu Pengajuan:* {tanggal_pengajuan}\n\nSilakan buka panel dashboard SIPEDES untuk memverifikasi berkas persyaratan:\n🔗 {link_admin}\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','[\"jenis_surat\", \"nomor_permohonan\", \"nama_pemohon\", \"dusun\", \"tanggal_pengajuan\", \"link_admin\"]',1,'2026-09-12 03:59:20','2026-09-12 03:59:20'),(2,'surat_diajukan_warga','Konfirmasi Pengajuan Surat Diterima (ke Warga)','surat','warga','Salam Bapak/Ibu *{nama_pemohon}*,\n\nTerima kasih telah menggunakan layanan digital *SIPEDES Desa Rombiya Barat*.\nPermohonan surat Anda telah berhasil kami terima:\n\n📄 *Jenis Surat:* {jenis_surat}\n🔢 *No. Tiket Permohonan:* {nomor_permohonan}\n🕒 *Status Saat Ini:* Menunggu Verifikasi Petugas\n\nPamong desa kami akan segera memeriksa kelengkapan berkas Anda. Pantau perkembangan surat Anda melalui tautan berikut:\n🔗 {link_status}\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','[\"nama_pemohon\", \"jenis_surat\", \"nomor_permohonan\", \"link_status\"]',1,'2026-09-12 03:59:20','2026-09-12 03:59:20'),(3,'surat_diproses_warga','Pemberitahuan Surat Sedang Diproses (ke Warga)','surat','warga','Halo *{nama_pemohon}*,\n\nPermohonan surat Anda saat ini *SEDANG DIPROSES* oleh petugas balai desa:\n\n📄 *Jenis Surat:* {jenis_surat}\n🔢 *Nomor:* {nomor_permohonan}\n👨‍💼 *Petugas Verifikator:* {nama_petugas}\n\nMohon ditunggu, surat resmi Anda sedang disiapkan dan ditandatangani.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','[\"nama_pemohon\", \"jenis_surat\", \"nomor_permohonan\", \"nama_petugas\"]',1,'2026-09-12 03:59:20','2026-09-12 03:59:20'),(4,'surat_disetujui_warga','Pemberitahuan Surat Selesai & Siap Diunduh (ke Warga)','surat','warga','Kabar Baik Bapak/Ibu *{nama_pemohon}*,\n\nPermohonan surat Anda telah *DISETUJUI & SELESAI DITERBITKAN* secara resmi oleh Pemerintah Desa Rombiya Barat.\n\n📄 *Jenis Surat:* {jenis_surat}\n🔢 *Nomor Registrasi:* {nomor_permohonan}\n📅 *Tanggal Terbit:* {tanggal_selesai}\n\nAnda dapat mengunduh dan mencetak langsung dokumen surat resmi berformat PDF melalui tautan berikut:\n📥 {link_download_pdf}\n\nSurat ini sah dan dilengkapi kode verifikasi digital desa.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','[\"nama_pemohon\", \"jenis_surat\", \"nomor_permohonan\", \"tanggal_selesai\", \"link_download_pdf\"]',1,'2026-09-12 03:59:20','2026-09-12 03:59:20'),(5,'surat_koreksi_warga','Pemberitahuan Perbaikan Berkas Surat (ke Warga)','surat','warga','Yth. Bapak/Ibu *{nama_pemohon}*,\n\nPermohonan surat *{jenis_surat}* ({nomor_permohonan}) membutuhkan perbaikan berkas persyaratan.\n\n📝 *Catatan Petugas Verifikator:*\n\"{catatan_petugas}\"\n\nSilakan lakukan perbaikan atau unggah ulang dokumen pendukung melalui akun SIPEDES Anda:\n🔗 {link_status}\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','[\"nama_pemohon\", \"jenis_surat\", \"nomor_permohonan\", \"catatan_petugas\", \"link_status\"]',1,'2026-09-12 03:59:20','2026-09-12 03:59:20'),(6,'surat_ditolak_warga','Pemberitahuan Surat Ditolak (ke Warga)','surat','warga','Yth. Bapak/Ibu *{nama_pemohon}*,\n\nMohon maaf, permohonan surat *{jenis_surat}* ({nomor_permohonan}) belum dapat disetujui.\n\n⚠️ *Alasan:* \n\"{catatan_petugas}\"\n\nApabila memerlukan informasi lebih lanjut, silakan hubungi Balai Desa Rombiya Barat pada jam pelayanan kerja.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','[\"nama_pemohon\", \"jenis_surat\", \"nomor_permohonan\", \"catatan_petugas\"]',1,'2026-09-12 03:59:20','2026-09-12 03:59:20'),(7,'pengaduan_masuk_petugas','Alert Laporan Pengaduan Baru (ke Petugas/Pamong)','pengaduan','petugas','📢 *LAPORAN ASPIRASI / PENGADUAN WARGA BARU*\n\nYth. Petugas & Kepala Dusun,\nTerdapat pengaduan masyarakat yang baru disampaikan warga:\n\n🎫 *No. Tiket:* {kode_tiket}\n👤 *Pelapor:* {nama_pelapor}\n📍 *Lokasi Dusun:* {dusun}\n📂 *Kategori:* {kategori}\n📋 *Judul Laporan:* {judul_pengaduan}\n\nDetail tindak lanjut dapat diakses di panel admin:\n🔗 {link_admin}\n\n_SIPEDES Desa Rombiya Barat_','[\"kode_tiket\", \"nama_pelapor\", \"dusun\", \"kategori\", \"judul_pengaduan\", \"link_admin\"]',1,'2026-09-12 03:59:20','2026-09-12 03:59:20'),(8,'pengaduan_selesai_warga','Tanggapan Penanganan Pengaduan Selesai (ke Warga)','pengaduan','warga','Halo *{nama_pelapor}*,\n\nTerima kasih atas kepedulian Anda terhadap lingkungan Desa Rombiya Barat.\nLaporan pengaduan Anda telah ditindaklanjuti oleh pamong desa:\n\n🎫 *No. Tiket:* {kode_tiket}\n📋 *Judul:* {judul_pengaduan}\n✅ *Status:* Selesai Ditindaklanjuti\n\n💬 *Tanggapan Resmi Balai Desa:*\n\"{tanggapan_petugas}\"\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','[\"nama_pelapor\", \"kode_tiket\", \"judul_pengaduan\", \"tanggapan_petugas\"]',1,'2026-09-12 03:59:20','2026-09-12 03:59:20'),(9,'pengaduan_dibuat_warga','Bukti Tanda Terima Pengaduan (ke Warga Pelapor)','pengaduan','warga','Salam Bapak/Ibu *{nama_pelapor}*,\n\nLaporan aspirasi/pengaduan Anda telah resmi tercatat di sistem *SIPEDES Desa Rombiya Barat*:\n\n🎫 *No. Tiket:* {kode_tiket}\n📋 *Judul Laporan:* {judul_pengaduan}\n📂 *Kategori:* {kategori}\n🕒 *Waktu Lapor:* {tanggal_laporan}\n\nPamong desa akan meninjau dan menindaklanjuti laporan Anda. Anda dapat memantau perkembangannya pada akun SIPEDES Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','[\"nama_pelapor\", \"kode_tiket\", \"judul_pengaduan\", \"kategori\", \"tanggal_laporan\"]',1,'2026-09-12 04:06:05','2026-09-12 04:06:05'),(10,'otp_lupa_password','Kode OTP Reset Kata Sandi Akun Warga','sistem','warga','🔐 *KODE VERIFIKASI OTP — SIPEDES DESA ROMBIYA BARAT*\n\nYth. *{nama_warga}*,\n\nKami menerima permintaan untuk mereset kata sandi akun SIPEDES Anda. Berikut adalah kode verifikasi OTP Anda:\n\n👉 *{otp_code}*\n\nKode ini bersifat RAHASIA dan berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun termasuk perangkat desa.\n\nJika Anda tidak merasa meminta reset kata sandi, amankan akun Anda segera.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','[\"nama_warga\", \"otp_code\"]',1,'2026-09-14 18:51:46','2026-09-14 18:51:46'),(11,'password_berhasil_diubah','Notifikasi Kata Sandi Berhasil Diperbarui','sistem','warga','✅ *KATA SANDI BERHASIL DIPERBARUI — SIPEDES DESA ROMBIYA BARAT*\n\nHalo *{nama_warga}*,\n\nKata sandi akun SIPEDES Anda telah berhasil diubah pada {waktu}.\n\nJika Anda merasa tidak melakukan perubahan ini, segera hubungi Balai Desa Rombiya Barat untuk mengamankan akun Anda.\n\n_Pemerintah Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep_','[\"nama_warga\", \"waktu\"]',1,'2026-09-14 18:51:46','2026-09-14 18:51:46');
/*!40000 ALTER TABLE `whatsapp_templates` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-16  8:07:21
