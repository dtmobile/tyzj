/*
Navicat MySQL Data Transfer

Source Server         : localhost_wamp2.2
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : tiyukeji

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2017-11-09 14:06:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_answer`
-- ----------------------------
DROP TABLE IF EXISTS `t_answer`;
CREATE TABLE `t_answer` (
`ID`  int(11) NOT NULL ,
`questionId`  int(11) NULL DEFAULT NULL ,
`context`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`person`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`answerDate`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `t_article`
-- ----------------------------
DROP TABLE IF EXISTS `t_article`;
CREATE TABLE `t_article` (
`ID`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`createUser`  int(11) NULL DEFAULT NULL ,
`issueId`  int(11) NULL DEFAULT NULL ,
`name`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`name_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`viceTitle`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`keyword`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`keyword_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`source`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`summary`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`summary_en`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`url`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`publishUrl`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`viewCount`  int(11) NULL DEFAULT NULL ,
`wordCount`  int(11) NULL DEFAULT NULL ,
`grade`  int(11) NULL DEFAULT NULL ,
`content`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`version`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`type`  int(11) NULL DEFAULT NULL ,
`status`  int(11) NULL DEFAULT NULL ,
`pubFlag`  int(11) NULL DEFAULT NULL ,
`creationdate`  datetime NULL DEFAULT NULL ,
`modifieddate`  datetime NULL DEFAULT NULL ,
`publishdate`  datetime NULL DEFAULT NULL ,
`owner`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`author`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`authorIntroduction`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`fenleihao`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`wenxianhao`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`xueke`  int(11) NULL DEFAULT NULL ,
`query1`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`query2`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`lockedFlag`  int(11) NULL DEFAULT NULL ,
`lockedBy`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`content_en`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`image`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`visit_num`  int(11) UNSIGNED NOT NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=2212

;

-- ----------------------------
-- Table structure for `t_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `t_attachment`;
CREATE TABLE `t_attachment` (
`ID`  int(11) NOT NULL ,
`articleID`  int(11) NULL DEFAULT NULL ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`type`  smallint(6) NULL DEFAULT NULL ,
`filename`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`bigFilename`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`linkAlt`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`srcFile`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fileExt`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`filesize`  decimal(19,0) NULL DEFAULT NULL ,
`contentType`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`creationdate`  datetime NULL DEFAULT NULL ,
`modifieddate`  datetime NULL DEFAULT NULL ,
`owner`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `t_counter`
-- ----------------------------
DROP TABLE IF EXISTS `t_counter`;
CREATE TABLE `t_counter` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`session_id`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`visit_time`  datetime NOT NULL ,
`visit_ip`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`online`  int(11) NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;

-- ----------------------------
-- Table structure for `t_dict`
-- ----------------------------
DROP TABLE IF EXISTS `t_dict`;
CREATE TABLE `t_dict` (
`ID`  int(11) NOT NULL ,
`code`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`name`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`summary`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`type`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`remarks`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`name_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`summary_en`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `t_dtproperties`
-- ----------------------------
DROP TABLE IF EXISTS `t_dtproperties`;
CREATE TABLE `t_dtproperties` (
`id`  int(11) NOT NULL ,
`objectid`  int(11) NULL DEFAULT NULL ,
`property`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`value`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`uvalue`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`lvalue`  longblob NULL ,
`version`  int(11) NOT NULL ,
PRIMARY KEY (`id`, `property`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `t_expert`
-- ----------------------------
DROP TABLE IF EXISTS `t_expert`;
CREATE TABLE `t_expert` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`periodical_id`  int(11) NULL DEFAULT NULL ,
`name`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`summary`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`job`  int(11) NULL DEFAULT NULL ,
`name_en`  varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`summary_en`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=64

;

-- ----------------------------
-- Table structure for `t_issue`
-- ----------------------------
DROP TABLE IF EXISTS `t_issue`;
CREATE TABLE `t_issue` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`createUser`  int(11) NULL DEFAULT NULL ,
`periodicalId`  int(11) NULL DEFAULT NULL ,
`name`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`summary`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`desciption`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`picPath`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`publshDate`  datetime NULL DEFAULT NULL ,
`createDate`  datetime NULL DEFAULT NULL ,
`name_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`summary_en`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`picPath_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=363

;

-- ----------------------------
-- Table structure for `t_news`
-- ----------------------------
DROP TABLE IF EXISTS `t_news`;
CREATE TABLE `t_news` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`image`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`createUser`  int(10) NULL DEFAULT NULL ,
`title`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`viceTitle`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`Content`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`createDate`  datetime NOT NULL ,
`title_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`viceTitle_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`Content_en`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=25

;

-- ----------------------------
-- Table structure for `t_periodical`
-- ----------------------------
DROP TABLE IF EXISTS `t_periodical`;
CREATE TABLE `t_periodical` (
`ID`  int(11) NOT NULL ,
`name`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`viceTitle`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`summary`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`name_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`viceTitle_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`summary_en`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `t_question`
-- ----------------------------
DROP TABLE IF EXISTS `t_question`;
CREATE TABLE `t_question` (
`ID`  int(11) NOT NULL ,
`name`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`person`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`questionDate`  datetime NULL DEFAULT NULL ,
`isAnswer`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `t_slide`
-- ----------------------------
DROP TABLE IF EXISTS `t_slide`;
CREATE TABLE `t_slide` (
`ID`  int(11) NOT NULL ,
`name`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`imgPath`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`imgUrl`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`isUse`  int(11) NULL DEFAULT NULL ,
`groupId`  int(11) NULL DEFAULT NULL ,
`typeId`  int(11) NULL DEFAULT NULL ,
`name_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`imgPath_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`bigImgPath`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`bigImgPath_en`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `t_syscfg`
-- ----------------------------
DROP TABLE IF EXISTS `t_syscfg`;
CREATE TABLE `t_syscfg` (
`name`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`value`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (`name`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `t_users`
-- ----------------------------
DROP TABLE IF EXISTS `t_users`;
CREATE TABLE `t_users` (
`ID`  int(11) NOT NULL ,
`userName`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fullName`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`password`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`dept`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`post`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`mobile`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`phone`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`emial`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`remark`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY (`ID`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Auto increment value for `t_article`
-- ----------------------------
ALTER TABLE `t_article` AUTO_INCREMENT=2212;

-- ----------------------------
-- Auto increment value for `t_counter`
-- ----------------------------
ALTER TABLE `t_counter` AUTO_INCREMENT=4;

-- ----------------------------
-- Auto increment value for `t_expert`
-- ----------------------------
ALTER TABLE `t_expert` AUTO_INCREMENT=64;

-- ----------------------------
-- Auto increment value for `t_issue`
-- ----------------------------
ALTER TABLE `t_issue` AUTO_INCREMENT=363;

-- ----------------------------
-- Auto increment value for `t_news`
-- ----------------------------
ALTER TABLE `t_news` AUTO_INCREMENT=25;
