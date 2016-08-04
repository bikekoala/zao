-- MySQL dump 10.13  Distrib 5.5.27, for debian-linux-gnu (armv7l)
--
-- Host: localhost    Database: zao
-- ------------------------------------------------------
-- Server version	5.5.27-0ubuntu2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `date` date NOT NULL COMMENT '日期',
  `topic` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '话题',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `view_counts` int(11) unsigned NOT NULL COMMENT '浏览次数',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`),
  KEY `state` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='节目表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `program_participant`
--

DROP TABLE IF EXISTS `program_participant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `program_participant` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `program_id` int(11) unsigned NOT NULL COMMENT '节目编号',
  `participant_id` int(11) unsigned NOT NULL COMMENT '参与人编号',
  PRIMARY KEY (`id`),
  KEY `program_id` (`program_id`),
  KEY `participant_id` (`participant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='节目参与者表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `program_music`
--

DROP TABLE IF EXISTS `program_music`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `program_music` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `program_id` int(11) unsigned NOT NULL COMMENT '节目编号',
  `music_id` int(11) unsigned NOT NULL COMMENT '音乐编号',
  `program_part` varchar(3) COLLATE utf8_unicode_ci NOT NULL COMMENT '节目时段',
  `start_sec` int(11) unsigned NOT NULL COMMENT '开始秒数',
  `end_sec` int(11) unsigned NOT NULL COMMENT '结束秒数',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '链接',
  PRIMARY KEY (`id`),
  KEY `program_id` (`program_id`),
  KEY `music_id` (`music_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='节目音乐表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `program_artist`
--

DROP TABLE IF EXISTS `program_artist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `program_artist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `program_id` int(11) unsigned NOT NULL COMMENT '节目编号',
  `artist_id` int(11) unsigned NOT NULL COMMENT '歌手编号',
  PRIMARY KEY (`id`),
  KEY `program_id` (`program_id`),
  KEY `artist_id` (`artist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='节目歌手表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '姓名',
  `counts` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='参与者表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `audios`
--

DROP TABLE IF EXISTS `audios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `date` date NOT NULL COMMENT '日期',
  `part` varchar(3) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '时段',
  `title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '标题',
  `source` varchar(10) CHARACTER SET utf8 NOT NULL COMMENT '来源',
  `download` tinyint(1) NOT NULL COMMENT '是否下载',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '链接',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_part_source` (`date`,`part`,`source`),
  KEY `state` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='声音表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `musics`
--

DROP TABLE IF EXISTS `musics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `musics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '歌曲',
  `album` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '专辑',
  `genres` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '流派',
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '唱片公司',
  `release_date` char(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '发行日期',
  `acrid` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'ACR ID',
  `isrc` char(12) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'ISRC code',
  `upc` char(12) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'UPC code',
  `external_metadata` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'External 3rd Party IDs and metadata',
  `counts` int(11) unsigned NOT NULL COMMENT '次数',
  PRIMARY KEY (`id`),
  KEY `counts` (`counts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='音乐表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `music_artist`
--

DROP TABLE IF EXISTS `music_artist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `music_artist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `music_id` int(11) unsigned NOT NULL COMMENT '音乐编号',
  `artist_id` int(11) unsigned NOT NULL COMMENT '歌手编号',
  PRIMARY KEY (`id`),
  KEY `music_id` (`music_id`),
  KEY `artist_id` (`artist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='音乐歌手表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `artists`
--

DROP TABLE IF EXISTS `artists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `artists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `counts` int(11) unsigned NOT NULL COMMENT '次数',
  PRIMARY KEY (`id`),
  KEY `counts` (`counts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='歌手表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `log_id` bigint(64) unsigned NOT NULL COMMENT '记录ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `action` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '操作类型',
  `meta` text NOT NULL COMMENT 'META',
  `date` datetime NOT NULL COMMENT '操作时间',
  `ext_created_at` datetime NOT NULL COMMENT '创建时间',
  `ext_program_date` date DEFAULT NULL COMMENT '节目日期',
  `ext_has_topic` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有话题',
  `ext_has_participant` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有参与人',
  `ext_is_agree` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否同意',
  PRIMARY KEY (`id`),
  UNIQUE KEY `log_id` (`log_id`),
  KEY `program_contribution` (`action`,`ext_has_topic`,`ext_has_participant`,`ext_program_date`,`ext_is_agree`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='多说评论表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `heres`
--

DROP TABLE IF EXISTS `heres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heres` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `date` year(4) NOT NULL COMMENT '日期',
  `lng` decimal(10,6) NOT NULL COMMENT '经度',
  `lat` decimal(10,6) NOT NULL COMMENT '纬度',
  `country` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '省份',
  `location` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '地点',
  `gm_url` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'GM URL',
  `gm_place_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'GM地名ID',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='打卡表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `ds_id` varchar(20) NOT NULL DEFAULT '' COMMENT '多说用户ID',
  `name` varchar(128) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '名字',
  `url` varchar(256) NOT NULL DEFAULT '' COMMENT '链接地址',
  `avatar_url` varchar(256) NOT NULL DEFAULT '' COMMENT '头像地址',
  `meta` text CHARACTER SET utf8mb4 NOT NULL COMMENT '原始信息',
  `state` tinyint(1) unsigned NOT NULL COMMENT '原始信息',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ds_id` (`ds_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='后台管理员表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `message` varchar(1000) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '消息',
  `state` tinyint(1) unsigned NOT NULL COMMENT '状态',
  `duration_at` datetime NOT NULL COMMENT '过期时间',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `state_duration_at` (`state`,`duration_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='通知消息表';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-04 16:32:22
