/*
 Navicat Premium Data Transfer

 Source Server         : atomedya
 Source Server Type    : MySQL
 Source Server Version : 50713
 Source Host           : localhost:3306
 Source Schema         : php-user-roles

 Target Server Type    : MySQL
 Target Server Version : 50713
 File Encoding         : 65001

 Date: 14/05/2022 21:47:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `durum` tinyint(4) NULL DEFAULT 1,
  `yetki` tinyint(11) NULL DEFAULT NULL,
  `isSuperAdmin` tinyint(4) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Muhammed Fatih BAĞCIVAN', 'info@mfsoftware.net', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 1, 3, 1);
INSERT INTO `users` VALUES (4, 'Muhammed Fatih BAĞCIVANss', 'info@mfsoftware.nets', 'df8d515202d9b15c67de8b1b7cd3ee696e0bd728', 1, 1, 0);

-- ----------------------------
-- Table structure for yetkiler
-- ----------------------------
DROP TABLE IF EXISTS `yetkiler`;
CREATE TABLE `yetkiler`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `durum` tinyint(4) NULL DEFAULT 1,
  `yetkiler` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of yetkiler
-- ----------------------------
INSERT INTO `yetkiler` VALUES (1, 'Editör', 1, '{\"kullanicilar\":{\"listeleme\":\"on\"}}');
INSERT INTO `yetkiler` VALUES (3, 'Admin', 1, '{\"yetkiler\":{\"listeleme\":\"on\",\"ekleme\":\"on\",\"silme\":\"on\",\"guncelleme\":\"on\"},\"kullanicilar\":{\"listeleme\":\"on\",\"ekleme\":\"on\",\"silme\":\"on\",\"guncelleme\":\"on\"}}');

SET FOREIGN_KEY_CHECKS = 1;
