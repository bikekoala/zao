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
  KEY `program_id` (`program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='节目参与者表';
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
  `url` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '链接',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_part_source` (`date`,`part`,`source`),
  KEY `state` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='声音表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `duoshuo`
--

DROP TABLE IF EXISTS `duoshuo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `duoshuo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `log_id` bigint(64) unsigned NOT NULL COMMENT '记录ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `action` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '操作类型',
  `meta` text CHARACTER SET utf8mb4 NOT NULL COMMENT 'META',
  `date` datetime NOT NULL COMMENT '操作时间',
  `ext_created_at` datetime NOT NULL COMMENT '创建时间',
  `ext_program_date` date DEFAULT NULL COMMENT '节目日期',
  `ext_has_topic` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有话题',
  `ext_has_participant` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有参与人',
  `ext_is_agree` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否同意',
  PRIMARY KEY (`id`),
  UNIQUE KEY `log_id` (`log_id`),
  KEY `program_contribution` (`action`,`ext_has_topic`,`ext_has_participant`,`ext_program_date`,`ext_is_agree`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-18 19:59:55
