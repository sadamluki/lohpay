/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 100129
 Source Host           : localhost:3306
 Source Schema         : lohpay

 Target Server Type    : MySQL
 Target Server Version : 100129
 File Encoding         : 65001

 Date: 11/01/2019 15:43:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account`  (
  `acc_no` int(11) NOT NULL,
  `pin` char(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pemilik` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `saldo` bigint(20) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`acc_no`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES (151094, '123321', 'Luki Sadam', 1000000000, '2018-11-23 15:36:13', NULL);

SET FOREIGN_KEY_CHECKS = 1;
