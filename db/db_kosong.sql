/*
 Navicat Premium Data Transfer

 Source Server         : root
 Source Server Type    : MySQL
 Source Server Version : 50532
 Source Host           : localhost:3306
 Source Schema         : testing

 Target Server Type    : MySQL
 Target Server Version : 50532
 File Encoding         : 65001

 Date: 01/12/2019 19:36:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (3, 'admin 01', '085806234028', 'admin01@mail.com', NULL, NULL);

-- ----------------------------
-- Table structure for auth_person
-- ----------------------------
DROP TABLE IF EXISTS `auth_person`;
CREATE TABLE `auth_person`  (
  `id_auth` int(11) NOT NULL AUTO_INCREMENT,
  `id_person` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `token` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_auth`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 176 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for contoh
-- ----------------------------
DROP TABLE IF EXISTS `contoh`;
CREATE TABLE `contoh`  (
  `id_contoh` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_contoh`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of contoh
-- ----------------------------
INSERT INTO `contoh` VALUES (1, 'contoh', '32131233', 'mpampam5@gmail.comss');

-- ----------------------------
-- Table structure for deposit
-- ----------------------------
DROP TABLE IF EXISTS `deposit`;
CREATE TABLE `deposit`  (
  `id_deposit` int(11) NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_person` int(11) NULL DEFAULT NULL,
  `amount` bigint(11) NULL DEFAULT NULL,
  `amount_acc` bigint(11) NULL DEFAULT NULL,
  `biaya_admin` bigint(11) NULL DEFAULT NULL,
  `status` enum('process','cancel','approved') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'process',
  `metode_pembayaran` int(11) NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created` datetime NULL DEFAULT NULL,
  `time_approved` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_deposit`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 135 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of deposit
-- ----------------------------
INSERT INTO `deposit` VALUES (131, 'DP291119-16', 178, 10000524, 10000000, 150000, 'approved', 2, '{\"approved_by\":\"admin\",\"id_admin\":\"1\",\"time_approved\":\"2019-11-29 17:43:28\",\"keteragan\":\"approved\"}', '2019-11-29 17:41:51', NULL);
INSERT INTO `deposit` VALUES (132, 'DP291119-17', 178, 5000471, 5000000, 150000, 'approved', 3, '{\"approved_by\":\"admin\",\"id_admin\":\"1\",\"time_approved\":\"2019-11-29 18:00:07\",\"keteragan\":\"approved\"}', '2019-11-29 17:58:36', NULL);
INSERT INTO `deposit` VALUES (133, 'DP291119-18', 178, 10000461, 10000000, 150000, 'approved', 3, '{\"approved_by\":\"admin\",\"id_admin\":\"1\",\"time_approved\":\"2019-11-29 18:17:39\",\"keteragan\":\"approved\"}', '2019-11-29 18:17:10', NULL);
INSERT INTO `deposit` VALUES (134, 'DP291119-19', 178, 1000752, NULL, 0, 'process', 4, NULL, '2019-11-29 19:20:17', NULL);

-- ----------------------------
-- Table structure for history_comission
-- ----------------------------
DROP TABLE IF EXISTS `history_comission`;
CREATE TABLE `history_comission`  (
  `di_history` int(11) NOT NULL AUTO_INCREMENT,
  `id_person` int(11) NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`di_history`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for investment
-- ----------------------------
DROP TABLE IF EXISTS `investment`;
CREATE TABLE `investment`  (
  `id_invest` int(11) NOT NULL AUTO_INCREMENT,
  `kode_invest` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_person` int(11) NULL DEFAULT NULL,
  `group` int(11) NULL DEFAULT NULL,
  `amount` bigint(11) NULL DEFAULT NULL,
  `status` enum('ongoing','done') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'ongoing',
  `alamat_kirim_spk` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `qr_code` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created` date NULL DEFAULT NULL,
  `kontrak_start` date NULL DEFAULT NULL,
  `kontrak_end` date NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id_invest`, `kode_invest`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 81 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of investment
-- ----------------------------
INSERT INTO `investment` VALUES (77, 'MEM-000022-INV003', 178, 1, 2000000, 'ongoing', '123456', 'contoh_01_MEM-000022-INV003.png', '2019-11-29', '2019-11-01', '2020-05-01', NULL);
INSERT INTO `investment` VALUES (78, 'MEM-000022-INV004', 178, 1, 1000000, 'ongoing', 'ddas', 'contoh_01_MEM-000022-INV004.png', '2019-11-29', '2019-12-01', '2020-06-01', NULL);
INSERT INTO `investment` VALUES (79, 'MEM-000022-INV001', 178, 15, 1000000, 'ongoing', 'dsadas', 'contoh_01_MEM-000022-INV001.png', '2019-11-11', '2019-12-15', '2020-06-15', NULL);
INSERT INTO `investment` VALUES (80, 'MEM-000022-INV001', 178, 1, 1000000, 'ongoing', 'rewwe', 'contoh_01_MEM-000022-INV001.png', '2019-11-04', '2019-11-01', '2020-05-01', NULL);

-- ----------------------------
-- Table structure for investment_dividen
-- ----------------------------
DROP TABLE IF EXISTS `investment_dividen`;
CREATE TABLE `investment_dividen`  (
  `id_invest_dividen` int(11) NOT NULL AUTO_INCREMENT,
  `id_invest` int(11) NULL DEFAULT NULL,
  `id_person` int(11) NULL DEFAULT NULL,
  `no_dividen` int(11) NULL DEFAULT NULL,
  `time_dividen` date NULL DEFAULT NULL,
  `persentase` int(11) NULL DEFAULT NULL,
  `amount` bigint(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_invest_dividen`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 63 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for investment_profit
-- ----------------------------
DROP TABLE IF EXISTS `investment_profit`;
CREATE TABLE `investment_profit`  (
  `id_invest_profit` int(11) NOT NULL AUTO_INCREMENT,
  `id_invest` int(11) NULL DEFAULT NULL,
  `no_profit` int(11) NULL DEFAULT NULL,
  `time_profit` date NULL DEFAULT NULL,
  `name_profit` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `amount_profit` bigint(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_invest_profit`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 223 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for level_person
-- ----------------------------
DROP TABLE IF EXISTS `level_person`;
CREATE TABLE `level_person`  (
  `id_level` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `comission` int(11) NULL DEFAULT NULL,
  `created` datetime NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_level`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of level_person
-- ----------------------------
INSERT INTO `level_person` VALUES (1, 'Founder', 6, '2019-10-29 13:35:30', NULL);
INSERT INTO `level_person` VALUES (2, 'Co Founder', 5, '2019-10-29 13:35:50', NULL);
INSERT INTO `level_person` VALUES (3, 'Agency', 4, '2019-10-22 19:46:15', NULL);
INSERT INTO `level_person` VALUES (4, 'Member', 3, '2019-10-29 19:46:20', NULL);

-- ----------------------------
-- Table structure for pengeluaran_baju
-- ----------------------------
DROP TABLE IF EXISTS `pengeluaran_baju`;
CREATE TABLE `pengeluaran_baju`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_person` int(11) NULL DEFAULT NULL,
  `ukuran_baju` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` enum('belum','sudah') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'belum',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pengeluaran_baju
-- ----------------------------
INSERT INTO `pengeluaran_baju` VALUES (3, 178, 'XL', 'belum');
INSERT INTO `pengeluaran_baju` VALUES (4, 178, 'XL', 'belum');

-- ----------------------------
-- Table structure for rekening_person
-- ----------------------------
DROP TABLE IF EXISTS `rekening_person`;
CREATE TABLE `rekening_person`  (
  `id_rekening_person` int(11) NOT NULL AUTO_INCREMENT,
  `id_person` int(11) NULL DEFAULT NULL,
  `nama_rekening` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_rekening` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bank` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `file_foto_rek` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_rekening_person`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 173 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for setting_financial
-- ----------------------------
DROP TABLE IF EXISTS `setting_financial`;
CREATE TABLE `setting_financial`  (
  `id_financial` int(11) NOT NULL,
  `deposit_status` enum('on','off') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `deposit_min` bigint(11) NULL DEFAULT NULL,
  `deposit_max` bigint(11) NULL DEFAULT NULL,
  `withdraw_status` enum('on','off') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `withdraw_min` bigint(11) NULL DEFAULT NULL,
  `withdraw_max` bigint(11) NULL DEFAULT NULL,
  `invesment_royalti` int(11) NULL DEFAULT NULL,
  `invesment_kontrak` int(11) NULL DEFAULT NULL,
  `invesment_profit` int(11) NULL DEFAULT NULL,
  `invesment_min` bigint(11) NULL DEFAULT NULL,
  `invesment_max` bigint(11) NULL DEFAULT NULL,
  `invesment_status` enum('on','off') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `biaya_admin` bigint(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_financial`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of setting_financial
-- ----------------------------
INSERT INTO `setting_financial` VALUES (999, 'on', 1000000, 1000000000, 'on', 100000, 10000000, 20, 6, 1, 1000000, 0, 'on', 150000);

-- ----------------------------
-- Table structure for setting_rekening
-- ----------------------------
DROP TABLE IF EXISTS `setting_rekening`;
CREATE TABLE `setting_rekening`  (
  `id_rekening` int(11) NOT NULL AUTO_INCREMENT,
  `nama_rekening` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_rekening` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bank` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `created` datetime NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_rekening`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of setting_rekening
-- ----------------------------
INSERT INTO `setting_rekening` VALUES (1, 'Irfan', '2832183821', 'BNI', '1', '2019-10-29 03:11:03', NULL);
INSERT INTO `setting_rekening` VALUES (2, 'PT. CHEETAH BINTANG LIMA', '064201001903302', 'BRI', '0', '2019-10-31 01:07:31', '2019-11-16 13:47:58');
INSERT INTO `setting_rekening` VALUES (3, 'PT CHEETAH BINTANG LIMA', '1740002771111', 'MANDIRI', '0', '2019-11-16 13:48:45', NULL);
INSERT INTO `setting_rekening` VALUES (4, 'PT CHEETAH BINTANG LIMA', '7685591111', 'BCA', '0', '2019-11-16 13:49:17', NULL);

-- ----------------------------
-- Table structure for setting_system
-- ----------------------------
DROP TABLE IF EXISTS `setting_system`;
CREATE TABLE `setting_system`  (
  `id_setting_system` int(11) NULL DEFAULT NULL,
  `title` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon1` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon2` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `background` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of setting_system
-- ----------------------------
INSERT INTO `setting_system` VALUES (999, 'PT. CHEETAH BINTANG LIMA', 'cheetahbintang5@gmail.com', '0411-4101629', '085240362883', 'JL. TUN ABD RAZAK KOMP RUKO CITRALAND BLOK F NO.8 GOWA, SULAWESI-SELATAN', 'background-login.jpeg');

-- ----------------------------
-- Table structure for tb_admin
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin`;
CREATE TABLE `tb_admin`  (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `username` varchar(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `level` enum('admin','superadmin') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` enum('n','y') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'n',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `created` datetime NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_admin`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_admin
-- ----------------------------
INSERT INTO `tb_admin` VALUES (1, 'Hasby Support', 'admin@mail.com', '082348577797', 'admin', '$2y$10$vQSIqxXayAUcfM71Knhr7emUdYdxTsgMlrNjk1iDaQrchDHoXpqe6', 'TWJMQ0k3MmgybWg5NzYwUVorUlBRZz09', 'superadmin', 'y', '0', '2019-09-15 23:50:04', '2019-11-16 03:08:57');
INSERT INTO `tb_admin` VALUES (2, 'admin IT', 'pengguna@mail.com', '085288882994', 'pengguna', '$2y$10$uWMnbbIKcjBEF2fbdOxqyuDcqt9dMOc3sIBcbl/ntiILz0PCqySue', 'QXErRjdHMis5azUzWktUckt1THpBZz09', 'admin', 'y', '0', '2019-10-26 04:30:40', '2019-11-16 11:38:44');
INSERT INTO `tb_admin` VALUES (3, 'BRIGITA', 'thebrigit@gmail.com', '08534061828', 'ACCGITA', '$2y$10$vqfbyuHOjgB7MecgsIskpe40iwYaLx6X7r5xS2.duq7ErLkVnEPSq', 'dk90aW5VTDYxWXBPRVZaYkt0OHJzQT09', 'admin', 'y', '1', '2019-11-16 12:02:08', NULL);
INSERT INTO `tb_admin` VALUES (4, 'Mauliddya Wahyu', 'lidyamolly9@gmail.com', '081326902310', 'ACCLIDYA03', '$2y$10$lN/G5zA4oCis9xi70ll0.eSCBpaYb7hXiIYA2rLCq2YovCyo3WE0a', 'RjdYM3RlQ3g2Y0JMNTB3ZHZ0aU9CUT09', 'admin', 'y', '0', '2019-11-16 12:50:43', NULL);
INSERT INTO `tb_admin` VALUES (5, 'BRIGITA. MB', 'therebrigit@gmail.com', '085340618285', 'ACCGITA02', '$2y$10$L9gw2UlCxfYbL/W2JN71ze0Qc5qQ.EufgfReepXyC8BEaARgrCf9u', 'NWtQWm95aHVVTmdwQjRKS3IyMUNrQT09', 'admin', 'y', '0', '2019-11-16 13:14:59', NULL);
INSERT INTO `tb_admin` VALUES (6, 'Reski Amalia', 'kikisugito2@gmail.com', '085399255565', 'ACCKIKI01', '$2y$10$i9LeBM6YM2qFTz2ukyhbJ.Xz.gx7clOMrOeT.YNjcCQrqVEKKfigC', 'TzBRZjBtMVBSSnpBeFRJcHpRUVFmdz09', 'admin', 'y', '0', '2019-11-16 13:27:19', NULL);
INSERT INTO `tb_admin` VALUES (7, 'AUDI AULIAH ALI', 'audiaauliahali@gmail.com', '08875944053', 'ADMAUDI01', '$2y$10$XM1FYoPHL26.8hg9YMqw4OxA9MyflTADRN9ebzCAIMzb5VZ0Cfn8O', 'dmZ4eEh0dlVuSlhzdzI4bSs0ZnZwUT09', 'admin', 'y', '0', '2019-11-16 13:39:16', NULL);
INSERT INTO `tb_admin` VALUES (8, 'SUPRIADI', 'supriadisudi@gmail.com', '085241621378', 'ADMSUDI03', '$2y$10$rxhZyQITPtKp0/hwqg0xhuwIXkVvNZtBrlg9yIHGc9TR6qWVBRZd.', 'bmw5TGJFR3BhNjZ2ZU5md2x2VndVZz09', 'admin', 'y', '0', '2019-11-16 14:34:30', NULL);
INSERT INTO `tb_admin` VALUES (9, 'SAMSAM A. Md', 'samsamlanas11@gmail.com', '082144121144', 'ADMSAMSAM02', '$2y$10$jaKke.0SU7WymZ2f8RerdeVFbH94Kr8Mq7F1FCChGtTSGgCHh8AYq', 'S1F2MmFhRzIyOWsxNUMrYndvOGZCQT09', 'admin', 'y', '0', '2019-11-16 15:08:19', NULL);

-- ----------------------------
-- Table structure for tb_person
-- ----------------------------
DROP TABLE IF EXISTS `tb_person`;
CREATE TABLE `tb_person`  (
  `id_person` int(11) NOT NULL AUTO_INCREMENT,
  `is_parent` int(11) NULL DEFAULT NULL COMMENT 'id_person',
  `kode_person` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_level` int(11) NULL DEFAULT NULL,
  `nik` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal_lahir` date NULL DEFAULT NULL,
  `telepon1` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon2` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pekerjaan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ukuran_baju` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `file_foto` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `file_ktp` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waris_nama` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waris_hubungan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waris_telepon` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `waris_alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_active` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '1',
  `is_complate` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `is_complate_berkas` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created` datetime NULL DEFAULT NULL,
  `modified` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_person`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 179 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
