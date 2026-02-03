/*
 Navicat Premium Data Transfer

 Source Server         : My Local Host
 Source Server Type    : MySQL
 Source Server Version : 100425
 Source Host           : localhost:3306
 Source Schema         : survei_kepuasan

 Target Server Type    : MySQL
 Target Server Version : 100425
 File Encoding         : 65001

 Date: 19/12/2025 08:18:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for t_kepuasan_surveior
-- ----------------------------
DROP TABLE IF EXISTS `t_kepuasan_surveior`;
CREATE TABLE `t_kepuasan_surveior`  (
  `IdKepuasanSurveior` int NOT NULL AUTO_INCREMENT,
  `IdSurveiKepuasan` int NOT NULL,
  `IdMemberData` int NULL DEFAULT NULL,
  `InteraksiSurveior` tinyint NULL DEFAULT NULL COMMENT 'Interaksi surveior dengan tim RS',
  `KetepatanWaktu` tinyint NULL DEFAULT NULL COMMENT 'Ketepatan waktu pelaksanaan survei',
  `KemampuanKomunikasi` tinyint NULL DEFAULT NULL COMMENT 'Kemampuan berkomunikasi dan memberikan edukasi\r\nKemampuan berkomunikasi dengan baik',
  `SikapPerilaku` tinyint NULL DEFAULT NULL COMMENT 'Sikap dan perilaku selama survei',
  PRIMARY KEY (`IdKepuasanSurveior`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_kepuasan_surveior
-- ----------------------------

-- ----------------------------
-- Table structure for t_survei_kepuasan
-- ----------------------------
DROP TABLE IF EXISTS `t_survei_kepuasan`;
CREATE TABLE `t_survei_kepuasan`  (
  `IdSurveiKepuasan` int NOT NULL AUTO_INCREMENT,
  `IdKegiatanAkreditasi` int NOT NULL,
  `TglPengisian` datetime NULL DEFAULT NULL,
  `PersiapanWeb` tinyint NULL DEFAULT NULL COMMENT 'Kemudahan akses & info web',
  `PersiapanSpeak` tinyint NULL DEFAULT NULL COMMENT 'Kemudahan registrasi online SPEAK',
  `PersiapanKomunikasiPic` tinyint NULL DEFAULT NULL COMMENT 'Komunikasi narahubung ke RS',
  `PersiapanKecepatanRespon` tinyint NULL DEFAULT NULL COMMENT 'Kecepatan respon setelah registrasi',
  `PersiapanJadwalSurveior` tinyint NULL DEFAULT NULL COMMENT 'Ketepatan jadwal & nama surveior',
  `PersiapanAlurMekanisme` tinyint NULL DEFAULT NULL COMMENT 'Kejelasan alur akreditasi',
  `PersiapanKualitasIT` tinyint NULL DEFAULT NULL COMMENT 'Kualitas media komunikasi/TI',
  `PelaksanaanKetepatanWaktu` tinyint NULL DEFAULT NULL COMMENT 'Ketepatan waktu pelaksanaan',
  `PelaksanaanDaring` tinyint NULL DEFAULT NULL COMMENT 'Pelaksanaan daring (Online)',
  `PelaksanaanLuring` tinyint NULL DEFAULT NULL COMMENT 'Pelaksanaan luring (Offline)',
  `PelaksanaanInstrumen` tinyint NULL DEFAULT NULL COMMENT 'Penggunaan instrumen survei',
  `PelaksanaanExitConference` tinyint NULL DEFAULT NULL COMMENT 'Sistematika & kejelasan exit conference',
  `SaranMasukan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`IdSurveiKepuasan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_survei_kepuasan
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
