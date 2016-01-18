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
  `day` tinyint(1) unsigned NOT NULL COMMENT '周几',
  `topic` varchar(255) NOT NULL DEFAULT '' COMMENT '话题',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`),
  KEY `state` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='节目表';
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='节目参与者表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `counts` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='参与者表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `audio`
--

DROP TABLE IF EXISTS `audio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audio` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `date` date NOT NULL COMMENT '日期',
  `time` varchar(3) NOT NULL COMMENT '时段',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `source` varchar(10) NOT NULL COMMENT '来源',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `date_source_state` (`date`,`source`,`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='声音表';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-18 23:06:13
