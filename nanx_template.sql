-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: cloud_cnix
-- ------------------------------------------------------
-- Server version 5.6.35

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
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `timestamp` char(100) DEFAULT NULL,
  `user_data` text,
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(200) NOT NULL DEFAULT '',
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `prevent_update` int(10) DEFAULT NULL,
  `data` varchar(500) DEFAULT NULL,
  `id` char(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cnix_carslist`
--

DROP TABLE IF EXISTS `cnix_carslist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cnix_carslist` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT '保留列,请勿删除',
  `car_no` char(20) DEFAULT NULL COMMENT '车牌号',
  `drv_name` char(1) DEFAULT NULL COMMENT '司机名称',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cnix_carslist`
--

LOCK TABLES `cnix_carslist` WRITE;
/*!40000 ALTER TABLE `cnix_carslist` DISABLE KEYS */;
INSERT INTO `cnix_carslist` VALUES (1,'AK909090023','杨');
/*!40000 ALTER TABLE `cnix_carslist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cnix_ccx_products`
--

DROP TABLE IF EXISTS `cnix_ccx_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cnix_ccx_products` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bandwidth` char(10) DEFAULT NULL COMMENT '带宽',
  `custid` int(11) DEFAULT NULL,
  `ccx_id` int(11) DEFAULT NULL,
  `ccx_vbr` char(10) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL COMMENT '创建时间',
  `months` int(11) DEFAULT NULL,
  `expirdate` date DEFAULT NULL COMMENT '过期时间',
  `locationpid` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cnix_ccx_products`
--

LOCK TABLES `cnix_ccx_products` WRITE;
/*!40000 ALTER TABLE `cnix_ccx_products` DISABLE KEYS */;
INSERT INTO `cnix_ccx_products` VALUES (19,'2',2,1,'vbr','2017-11-14 15:07:17',6,NULL,1),(20,'1',2,NULL,'vbr','2018-01-11 13:02:52',NULL,NULL,NULL),(21,'1',2,NULL,'vbr','2018-01-11 13:03:14',NULL,NULL,NULL),(22,'2',2,NULL,'vbr','2018-01-12 10:11:27',NULL,NULL,NULL),(23,'5',2,NULL,'vbr','2018-01-12 10:17:13',NULL,NULL,NULL),(24,'1',2,NULL,'vbr','2018-01-12 10:19:12',NULL,NULL,NULL),(25,'1',2,NULL,'vbr','2018-01-12 10:19:53',NULL,NULL,NULL);
/*!40000 ALTER TABLE `cnix_ccx_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cnix_ccx_provider`
--

DROP TABLE IF EXISTS `cnix_ccx_provider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cnix_ccx_provider` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ccxname` char(20) DEFAULT NULL COMMENT '云服务商名称',
  `infotxt` char(200) DEFAULT NULL,
  `memo` char(40) DEFAULT NULL COMMENT '备注',
  `ccxcode` char(10) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cnix_ccx_provider`
--

LOCK TABLES `cnix_ccx_provider` WRITE;
/*!40000 ALTER TABLE `cnix_ccx_provider` DISABLE KEYS */;
INSERT INTO `cnix_ccx_provider` VALUES (1,'青云','青云服务商','青云','qingcloud'),(2,'阿里云','阿里云','','aliyun'),(3,'百度云','百度云','','baidu');
/*!40000 ALTER TABLE `cnix_ccx_provider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cnix_cloud_access`
--

DROP TABLE IF EXISTS `cnix_cloud_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cnix_cloud_access` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `custid` int(11) DEFAULT NULL,
  `ccx_id` int(11) DEFAULT NULL,
  `username` char(30) DEFAULT NULL,
  `password` char(30) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cnix_cloud_access`
--

LOCK TABLES `cnix_cloud_access` WRITE;
/*!40000 ALTER TABLE `cnix_cloud_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `cnix_cloud_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cnix_cloud_location`
--

DROP TABLE IF EXISTS `cnix_cloud_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cnix_cloud_location` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ccxid` int(11) DEFAULT NULL,
  `location` char(255) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cnix_cloud_location`
--

LOCK TABLES `cnix_cloud_location` WRITE;
/*!40000 ALTER TABLE `cnix_cloud_location` DISABLE KEYS */;
INSERT INTO `cnix_cloud_location` VALUES (1,1,'青云-北京节点'),(2,1,'青云-上海节点'),(3,2,'阿里-北京'),(4,2,'阿里-杭州'),(5,3,'百度-北京'),(6,3,'百度-上海'),(7,3,'百度-南京'),(8,3,'百度-广州'),(9,3,'天津');
/*!40000 ALTER TABLE `cnix_cloud_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cnix_cust`
--

DROP TABLE IF EXISTS `cnix_cust`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cnix_cust` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `custname` char(100) DEFAULT NULL,
  `contact` char(20) DEFAULT NULL,
  `mobile` char(11) DEFAULT NULL,
  `email` char(40) DEFAULT NULL,
  `custstatus` char(10) DEFAULT NULL,
  `account` char(40) DEFAULT NULL,
  `password` char(40) DEFAULT NULL,
  `weixin` char(1) DEFAULT NULL,
  `salt` char(30) DEFAULT NULL,
  `vlan` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cnix_cust`
--

LOCK TABLES `cnix_cust` WRITE;
/*!40000 ALTER TABLE `cnix_cust` DISABLE KEYS */;
INSERT INTO `cnix_cust` VALUES (1,'cust-a','aaa','111','111','',NULL,NULL,NULL,NULL,NULL),(2,'客户B','111','11','aaa@aaa.com','',NULL,'a2dcd3a8aff87029b6b3a8ce7f6e2769',NULL,'f880fb',NULL);
/*!40000 ALTER TABLE `cnix_cust` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cnix_invoice`
--

DROP TABLE IF EXISTS `cnix_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cnix_invoice` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ccx_prodid` int(11) DEFAULT NULL,
  `invoice_number` char(40) DEFAULT NULL,
  `money` float DEFAULT NULL,
  `worker` char(20) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cnix_invoice`
--

LOCK TABLES `cnix_invoice` WRITE;
/*!40000 ALTER TABLE `cnix_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `cnix_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cnix_presale_contact`
--

DROP TABLE IF EXISTS `cnix_presale_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cnix_presale_contact` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) DEFAULT NULL,
  `email` char(30) DEFAULT NULL,
  `phone` char(20) DEFAULT NULL,
  `company` char(100) DEFAULT NULL,
  `dept` char(30) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cnix_presale_contact`
--

LOCK TABLES `cnix_presale_contact` WRITE;
/*!40000 ALTER TABLE `cnix_presale_contact` DISABLE KEYS */;
INSERT INTO `cnix_presale_contact` VALUES (1,'1341','23412','34123','24','true','1234124'),(2,'134','aa@aa.com','12412','34124124','true',''),(3,'cc','cc@cc.com','1111','111','销售部','dfdsf'),(4,'xxx','xxx@aa.com','dfdsf','234234','管理部','234'),(5,'test1','test1@qq.com','18510273234','皓宽','销售部','test');
/*!40000 ALTER TABLE `cnix_presale_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cnix_vlan`
--

DROP TABLE IF EXISTS `cnix_vlan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cnix_vlan` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT '保留列,请勿删除',
  `vlan` char(200) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cnix_vlan`
--

LOCK TABLES `cnix_vlan` WRITE;
/*!40000 ALTER TABLE `cnix_vlan` DISABLE KEYS */;
INSERT INTO `cnix_vlan` VALUES (1,'vl111111'),(2,'v22222');
/*!40000 ALTER TABLE `cnix_vlan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity`
--

DROP TABLE IF EXISTS `nanx_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(255) NOT NULL DEFAULT '' COMMENT '活动代码code',
  `activity_type` char(20) DEFAULT NULL,
  `memo` char(255) DEFAULT NULL,
  `base_table` char(100) DEFAULT NULL,
  `service_url` char(100) DEFAULT NULL,
  `data_url` char(255) DEFAULT NULL,
  `url_for_get_cfg2` varchar(255) NOT NULL DEFAULT '' COMMENT '执行活动的url',
  `url_para` char(255) DEFAULT NULL,
  `pic_url` char(100) NOT NULL DEFAULT '' COMMENT '显示的图片地址',
  `grid_title` char(30) DEFAULT NULL,
  `sql` varchar(900) DEFAULT NULL,
  `extra_js` char(30) DEFAULT NULL,
  `js_function_point` char(100) DEFAULT NULL,
  `level` char(6) NOT NULL DEFAULT 'F',
  `win_size_height` int(255) DEFAULT NULL,
  `win_size_width` int(255) DEFAULT NULL,
  `win_size_width_operation` int(11) DEFAULT NULL,
  `view_filter` char(100) DEFAULT NULL,
  `view_filter_memo` char(250) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8 COMMENT='活动注册表格';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity`
--

LOCK TABLES `nanx_activity` WRITE;
/*!40000 ALTER TABLE `nanx_activity` DISABLE KEYS */;
INSERT INTO `nanx_activity` VALUES (90,'NANX_TBL_DATA','service',NULL,NULL,'mrdbms/getTableFields','curd/listData','rdbms/getTableFields','table','http://127.0.0.1/nanx/imgs/icon-48-banner-categories.png','',NULL,NULL,NULL,'system',662,800,NULL,NULL,NULL),(91,'NANX_TBL_STRU','service',NULL,NULL,'mrdbms/get_table_creation_info_no_directshow','rdbms/get_table_creation_info_directshow','rdbms/get_table_creation_info_no_directshow','table','http://127.0.0.1/nanx/imgs/icon-48-banner-categories.png',NULL,NULL,NULL,NULL,'system',NULL,NULL,NULL,NULL,NULL),(92,'NANX_TBL_INDEX','service',NULL,NULL,'mrdbms/get_min_table_indexes_no_directshow','rdbms/get_min_table_indexes_directshow','rdbms/get_min_table_indexes_no_directshow','table','http://127.0.0.1/nanx/imgs/icon-48-banner-categories.png',NULL,NULL,NULL,NULL,'system',NULL,NULL,NULL,NULL,NULL),(93,'NANX_TBL_CREATE','service',NULL,NULL,'mrdbms/get_table_creation_info_no_directshow','rdbms/get_table_creation_info_directshow','rdbms/get_table_creation_info_no_directshow','table','http://127.0.0.1/nanx/imgs/icon-48-banner-categories.png',NULL,NULL,NULL,NULL,'system',NULL,NULL,NULL,NULL,NULL),(116,'NANX_SYS_CONFIG','service',NULL,'',NULL,'curd/listData','',NULL,'',NULL,NULL,NULL,NULL,'system',NULL,NULL,NULL,NULL,NULL),(134,'NANX_APP_SUMMARY','html',NULL,NULL,NULL,'tree/systemSummary','',NULL,'icon-48-links.png','NANX_APP_SUMMARY',NULL,NULL,NULL,'system',NULL,NULL,NULL,NULL,NULL),(177,'NANX_TB_LAYOUT','sql',NULL,NULL,NULL,'curd/listData','',NULL,'',NULL,'select   field_list   from  nanx_activity_biz_layout   where  raw_table=$table',NULL,NULL,'system',NULL,NULL,NULL,NULL,NULL),(226,'NANX_FS_2_TABLE','service',NULL,NULL,'mfile/getFSGridFields','file/fs2array','mfile/getFSGridFields',NULL,'default_act.png','',NULL,NULL,NULL,'system',662,800,899,NULL,NULL),(234,'NANX_SQL_ACTIVITY','sql',NULL,NULL,NULL,'curd/listData','',NULL,'act_sql.png','run_sql','show tables;\n',NULL,NULL,'system',644,800,899,NULL,NULL),(247,'act_cnix_cust_1413684591','table',NULL,'cnix_cust',NULL,NULL,'',NULL,'user.png','活动_客户',NULL,NULL,NULL,'F',662,800,NULL,NULL,NULL),(248,'act_cnix_ccx_provider_1457807308','table',NULL,'cnix_ccx_provider',NULL,NULL,'',NULL,'node.png','云服务商',NULL,NULL,NULL,'F',662,800,NULL,NULL,NULL),(249,'act_cnix_cloud_access_41676287','table',NULL,'cnix_cloud_access',NULL,NULL,'',NULL,'lock.png','客户云access',NULL,NULL,NULL,'F',662,800,NULL,NULL,NULL),(250,'act_cnix_cloud_location_242945864','table',NULL,'cnix_cloud_location',NULL,NULL,'',NULL,'web browser.png','云服务商loc',NULL,NULL,NULL,'F',662,800,NULL,NULL,NULL),(251,'act_cnix_ccx_products_666479275','table',NULL,'cnix_ccx_products',NULL,NULL,'',NULL,'System folder.png','客户CCX产品列表',NULL,NULL,NULL,'F',662,800,NULL,NULL,NULL),(252,'act_cnix_presale_contact_2086450178','table',NULL,'cnix_presale_contact',NULL,NULL,'',NULL,'writemess.png','联系方式收集',NULL,NULL,NULL,'F',662,800,NULL,NULL,NULL),(253,'act_cnix_invoice_723349916','table',NULL,'cnix_invoice',NULL,NULL,'',NULL,'act_common.png','客户付款记录',NULL,NULL,NULL,'F',662,800,NULL,NULL,NULL),(254,'act_cnix_carslist_1254705227','table',NULL,'cnix_carslist',NULL,NULL,'',NULL,'honda.jpg','活动_货车资源',NULL,NULL,NULL,'F',662,800,NULL,NULL,NULL),(255,'act_cnix_vlan_145209745','table',NULL,'cnix_vlan',NULL,NULL,'',NULL,'act_common.png','活动_vlan',NULL,NULL,NULL,'F',662,800,NULL,NULL,NULL);
/*!40000 ALTER TABLE `nanx_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_a2a_btns`
--

DROP TABLE IF EXISTS `nanx_activity_a2a_btns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_a2a_btns` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` varchar(255) DEFAULT NULL,
  `btn_name` varchar(255) DEFAULT NULL,
  `btn_function` varchar(255) DEFAULT NULL,
  `btn_filter` varchar(255) DEFAULT NULL,
  `activity_for_btn` varchar(255) DEFAULT NULL,
  `field_for_main_activity` varchar(255) DEFAULT NULL,
  `field_for_sub_activity` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_a2a_btns`
--

LOCK TABLES `nanx_activity_a2a_btns` WRITE;
/*!40000 ALTER TABLE `nanx_activity_a2a_btns` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanx_activity_a2a_btns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_batch_btns`
--

DROP TABLE IF EXISTS `nanx_activity_batch_btns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_batch_btns` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` varchar(255) DEFAULT NULL,
  `btn_name` varchar(255) DEFAULT NULL,
  `op_field` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`,`op_field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_batch_btns`
--

LOCK TABLES `nanx_activity_batch_btns` WRITE;
/*!40000 ALTER TABLE `nanx_activity_batch_btns` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanx_activity_batch_btns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_biz_layout`
--

DROP TABLE IF EXISTS `nanx_activity_biz_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_biz_layout` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(255) DEFAULT NULL,
  `raw_table` char(100) NOT NULL DEFAULT '',
  `row` int(11) NOT NULL DEFAULT '0',
  `field_list` char(100) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_biz_layout`
--

LOCK TABLES `nanx_activity_biz_layout` WRITE;
/*!40000 ALTER TABLE `nanx_activity_biz_layout` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanx_activity_biz_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_curd_cfg`
--

DROP TABLE IF EXISTS `nanx_activity_curd_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_curd_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(255) DEFAULT NULL,
  `fn_add` char(1) DEFAULT NULL,
  `fn_update` char(1) NOT NULL DEFAULT '0',
  `fn_del` char(1) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_curd_cfg`
--

LOCK TABLES `nanx_activity_curd_cfg` WRITE;
/*!40000 ALTER TABLE `nanx_activity_curd_cfg` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanx_activity_curd_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_field_public_display_cfg`
--

DROP TABLE IF EXISTS `nanx_activity_field_public_display_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_field_public_display_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `field_e` char(30) DEFAULT NULL,
  `field_c` varchar(255) DEFAULT NULL,
  `field_width` int(255) DEFAULT NULL,
  `label_width` int(255) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `base_table` (`field_e`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='活动UI的字段配置。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_field_public_display_cfg`
--

LOCK TABLES `nanx_activity_field_public_display_cfg` WRITE;
/*!40000 ALTER TABLE `nanx_activity_field_public_display_cfg` DISABLE KEYS */;
INSERT INTO `nanx_activity_field_public_display_cfg` VALUES (1,'sex','性别',200,NULL),(2,'datatype','数据类型',300,NULL),(3,'length','长度',NULL,NULL),(4,'default_value','缺省值',NULL,NULL),(5,'primary_key','主键',NULL,NULL),(6,'not_null','非空',NULL,NULL),(7,'auto_increment','自动增长',NULL,NULL),(8,'comment','备注',NULL,NULL),(9,'unsigned','无符号',NULL,NULL),(10,'index','索引',NULL,NULL),(11,'columns','相关列',NULL,NULL),(12,'add_column','修改列',NULL,NULL),(13,'option','选项',NULL,NULL),(20,'key','配置项',NULL,NULL),(21,'value','值',NULL,NULL),(22,'tips','提示',NULL,NULL),(23,'can_delete','是否可删除',NULL,NULL),(111,'field_name','字段名',NULL,NULL),(112,'count(*)','汇总',NULL,NULL),(133,'field_e','英文字段名',NULL,NULL),(134,'field_c','中文字段名',NULL,NULL),(135,'field_width','字段长度',NULL,NULL),(136,'s_city','城市',300,400),(138,'guarantee_time_start','质保开始日期',NULL,NULL),(139,'guarantee_time_end','质保截至日期',NULL,NULL),(140,'install_time','安装日期',NULL,NULL),(141,'node_comu_status','网关通信状态',NULL,NULL),(142,'comu_status','门锁锁通信状态',NULL,NULL);
/*!40000 ALTER TABLE `nanx_activity_field_public_display_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_field_special_display_cfg`
--

DROP TABLE IF EXISTS `nanx_activity_field_special_display_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_field_special_display_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(255) DEFAULT NULL,
  `base_table` char(100) NOT NULL DEFAULT '',
  `field_e` char(30) NOT NULL DEFAULT '',
  `label_width` int(255) DEFAULT NULL,
  `field_c` varchar(255) DEFAULT NULL,
  `field_width` int(11) DEFAULT NULL,
  `show_as_pic` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`,`base_table`,`field_e`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='活动UI的字段配置。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_field_special_display_cfg`
--

LOCK TABLES `nanx_activity_field_special_display_cfg` WRITE;
/*!40000 ALTER TABLE `nanx_activity_field_special_display_cfg` DISABLE KEYS */;
INSERT INTO `nanx_activity_field_special_display_cfg` VALUES (1,'ref_activity','room_room','room',NULL,'room2',NULL,0),(2,'ref_activity','room_source','roomsize',NULL,'房间面积',NULL,0),(3,'ref_activity','room_host','idnumber',NULL,'身份证',NULL,0),(4,'ref_activity','room_host','gender',NULL,'性别',NULL,0),(5,'ref_activity','room_locklist','house_code',NULL,'房间所在地址',NULL,0),(6,'ref_activity','room_locklist','room_code',NULL,'房间号',NULL,0),(7,'ref_activity','room_locklist','power',NULL,'电量',NULL,0),(8,'ref_activity','room_locklist','lock_kind',NULL,'门锁类型',NULL,0),(9,'ref_activity','room_source','ownerid',NULL,'房东',NULL,0),(10,'ref_activity','room_source','roomtitle',NULL,'房间标题',NULL,0),(11,'ref_activity','room_source','address',NULL,'房间地址',NULL,0),(12,'ref_activity','room_source','hallroominfo',NULL,'门厅信息',NULL,0),(13,'ref_activity','room_source','status',NULL,'状态',NULL,0),(14,'ref_activity','room_source','price_day',NULL,'单价(天)',NULL,0),(15,'ref_activity','room_source','capacity',NULL,'容纳人数',NULL,0),(16,'ref_activity','room_source','carpark',NULL,'停车场',NULL,0),(17,'ref_activity','room_source','elevator',NULL,'电梯',NULL,0),(18,'ref_activity','room_source','hotwater24',NULL,'24小时热水',NULL,0),(19,'ref_activity','room_source','tvset',NULL,'电视',NULL,0),(20,'ref_activity','room_source','aircond',NULL,'空调',NULL,0),(21,'ref_activity','room_source','refrigerator',NULL,'冰箱',NULL,0),(22,'ref_activity','room_source','lockdeviceid',NULL,'门锁代码',NULL,0),(23,'ref_activity','room_source','rank',NULL,'等级',NULL,0),(24,'ref_activity','room_source','city',NULL,'所在城市',NULL,0),(25,'ref_activity','room_source','roomdesc',NULL,'房间信息',NULL,0),(26,'ref_activity','room_host','usertype',NULL,'用户类型',NULL,0),(27,'ref_activity','room_host','realname',NULL,'真实姓名',NULL,0),(28,'ref_activity','room_host','mobile',NULL,'手机号',NULL,0),(29,'ref_activity','room_host','weixin',NULL,'微信',NULL,0),(30,'ref_activity','room_host','weibo',NULL,'微博',NULL,0),(31,'ref_activity','room_host','resideprovince',NULL,'所在省份',NULL,0),(32,'ref_activity','room_host','residecity',NULL,'所在城市',NULL,0),(33,'ref_activity','room_host','password',NULL,'密码',NULL,0),(34,'ref_activity','room_host','remark',NULL,'备注',NULL,0),(35,'ref_activity','room_locknode','comu_status',NULL,'网关通信状态',NULL,0),(36,'ref_activity','room_locknode','comu_status_update_time',NULL,'状态更新时间',NULL,0),(37,'ref_activity','room_locknode','node_no',NULL,'网关代码',NULL,0),(38,'ref_activity','room_locknode','node_kind',NULL,'网关类型',NULL,0),(39,'ref_activity','room_locklist','lock_no',NULL,'门锁编码',NULL,0),(40,'ref_activity','room_user','createtime',NULL,'创建时间',NULL,0),(41,'ref_activity','room_user','lastip',NULL,'最后登录ip',NULL,0),(42,'ref_activity','room_user','mobile_verified',NULL,'手机是否验证',NULL,0),(43,'ref_activity','room_user','idnumber_verified',NULL,'身份证是否验证',NULL,0),(44,'ref_activity','room_source','lgt',NULL,'经度',NULL,0),(45,'ref_activity','room_source','lat',NULL,'纬度',NULL,0),(47,'ref_activity','room_source_pic','imgurl',NULL,'imgurl',NULL,1),(48,'ref_activity','room_source','washroomnum',NULL,'卫生间数量',NULL,0),(49,'ref_activity','room_source','bednum',NULL,'卧室数量',NULL,0),(50,'ref_activity','room_host','salt',NULL,'Salt值',NULL,0),(51,'ref_activity','room_source','distid',NULL,'区域ID',NULL,0),(52,'ref_activity','room_host','email',NULL,'邮件',NULL,0),(53,'ref_activity','room_host','sign',NULL,'简介',NULL,0),(54,'ref_activity','room_host','lastvisittime',NULL,'最后访问时间',NULL,0),(55,'ref_activity','room_host','sessionid',NULL,'会话ID',NULL,0),(56,'ref_activity','room_host','qq',NULL,'QQ',NULL,0),(57,'ref_activity','room_gj_notify_type','event_type',NULL,'推送事件类型 ',NULL,0),(58,'ref_activity','room_gj_response_code','respcode',NULL,'请求响应状态码 ',NULL,0),(59,'ref_activity','room_gj_response_code','respmsg',NULL,'请求响应状态信息',NULL,0),(60,'ref_activity','room_source_pic','covername',NULL,NULL,NULL,1),(61,'ref_activity','room_host','covername',NULL,'covername',NULL,0),(62,'ref_activity','room_host','idpic',NULL,'身份证扫描件',NULL,1),(63,'ref_activity','cnix_cust','custname',NULL,'客户名称',NULL,0),(64,'ref_activity','cnix_cust','contact',NULL,'联系人',NULL,0),(65,'ref_activity','cnix_cust','account',NULL,'帐号',NULL,0),(66,'ref_activity','cnix_carslist','car_no',NULL,'车牌号码',NULL,0);
/*!40000 ALTER TABLE `nanx_activity_field_special_display_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_forbidden_field`
--

DROP TABLE IF EXISTS `nanx_activity_forbidden_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_forbidden_field` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(255) DEFAULT NULL,
  `field` char(30) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`,`field`)
) ENGINE=MyISAM AUTO_INCREMENT=189 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_forbidden_field`
--

LOCK TABLES `nanx_activity_forbidden_field` WRITE;
/*!40000 ALTER TABLE `nanx_activity_forbidden_field` DISABLE KEYS */;
INSERT INTO `nanx_activity_forbidden_field` VALUES (186,'act_room_user_919102273','password'),(187,'act_room_user_919102273','salt'),(188,'act_room_user_919102273','sessionid');
/*!40000 ALTER TABLE `nanx_activity_forbidden_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_hooks`
--

DROP TABLE IF EXISTS `nanx_activity_hooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_hooks` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) DEFAULT NULL,
  `hook_type` char(11) DEFAULT NULL COMMENT 'check or data,check 返回tur/false,data执行数据操作',
  `activity_code` char(255) NOT NULL COMMENT '活动代码code',
  `extra_ci_model` char(100) DEFAULT NULL,
  `model_method` char(100) DEFAULT NULL,
  `hook_when` char(11) DEFAULT NULL COMMENT 'before or after',
  `hook_event` char(11) DEFAULT NULL,
  `memo` char(250) DEFAULT NULL,
  `execute_order` int(11) DEFAULT NULL COMMENT '执行顺序',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `hook_ind` (`hook_type`,`hook_when`,`hook_event`,`activity_code`,`extra_ci_model`,`model_method`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动注册表格';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_hooks`
--

LOCK TABLES `nanx_activity_hooks` WRITE;
/*!40000 ALTER TABLE `nanx_activity_hooks` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanx_activity_hooks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_js_btns`
--

DROP TABLE IF EXISTS `nanx_activity_js_btns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_js_btns` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(255) NOT NULL DEFAULT '',
  `jsfile` char(40) DEFAULT NULL,
  `btn_name` char(30) DEFAULT NULL,
  `function_name` char(40) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_js_btns`
--

LOCK TABLES `nanx_activity_js_btns` WRITE;
/*!40000 ALTER TABLE `nanx_activity_js_btns` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanx_activity_js_btns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_nofity`
--

DROP TABLE IF EXISTS `nanx_activity_nofity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_nofity` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(255) NOT NULL DEFAULT '' COMMENT '活动代码code',
  `action` char(11) NOT NULL DEFAULT '',
  `receiver_role_list` char(255) DEFAULT NULL,
  `tpl` char(255) DEFAULT NULL,
  `rule_name` char(30) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`,`action`,`receiver_role_list`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='活动注册表格';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_nofity`
--

LOCK TABLES `nanx_activity_nofity` WRITE;
/*!40000 ALTER TABLE `nanx_activity_nofity` DISABLE KEYS */;
INSERT INTO `nanx_activity_nofity` VALUES (1,'act_room_source_338448906','add','admin',NULL,'bbbb'),(2,'act_room_source_338448906','update','admin',NULL,'bbbb'),(3,'act_room_source_338448906','delete','admin',NULL,'bbbb'),(4,'act_room_source_338448906','execute','admin',NULL,'bbbb');
/*!40000 ALTER TABLE `nanx_activity_nofity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_activity_pid_order`
--

DROP TABLE IF EXISTS `nanx_activity_pid_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_activity_pid_order` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(255) NOT NULL DEFAULT '' COMMENT '活动代码code',
  `pid_order` char(4) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='活动注册表格';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_activity_pid_order`
--

LOCK TABLES `nanx_activity_pid_order` WRITE;
/*!40000 ALTER TABLE `nanx_activity_pid_order` DISABLE KEYS */;
INSERT INTO `nanx_activity_pid_order` VALUES (1,'act_room_sms_932531040','desc'),(2,'act_room_order_history_560853511','desc');
/*!40000 ALTER TABLE `nanx_activity_pid_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_biz_column_editor_cfg`
--

DROP TABLE IF EXISTS `nanx_biz_column_editor_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_biz_column_editor_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(250) DEFAULT NULL,
  `base_table` char(100) NOT NULL DEFAULT '',
  `field_e` char(30) NOT NULL DEFAULT '',
  `is_produce_col` tinyint(1) NOT NULL DEFAULT '0',
  `need_img_selector` tinyint(1) DEFAULT '0',
  `edit_as_html` tinyint(1) NOT NULL DEFAULT '0',
  `need_upload` tinyint(1) DEFAULT '0',
  `default_v` char(100) DEFAULT NULL,
  `readonly` int(1) DEFAULT '0',
  `cal_string` char(200) DEFAULT NULL,
  `use_random_pic_name` int(1) DEFAULT NULL,
  `categorydir` char(40) DEFAULT NULL,
  `path_col` char(40) DEFAULT NULL,
  `subdir_by_col` char(40) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_biz_column_editor_cfg`
--

LOCK TABLES `nanx_biz_column_editor_cfg` WRITE;
/*!40000 ALTER TABLE `nanx_biz_column_editor_cfg` DISABLE KEYS */;
INSERT INTO `nanx_biz_column_editor_cfg` VALUES (1,'ref_activity','room_host','usertype',0,0,0,0,'hoster',1,NULL,NULL,NULL,NULL,NULL),(2,'ref_activity','room_host','createtime',0,0,0,0,'datetime',0,NULL,NULL,NULL,NULL,NULL),(8,'ref_activity','room_host','idpic',0,0,0,1,NULL,0,NULL,NULL,NULL,NULL,NULL),(9,'ref_activity','room_source_pic','covername',0,0,0,1,NULL,0,NULL,1,'rooms',NULL,'sourceid'),(10,'ref_activity','room_mobile_code','code',0,0,0,0,NULL,1,NULL,NULL,NULL,NULL,NULL),(13,'ref_activity','room_mobile_code','transactionid',0,0,0,0,NULL,1,NULL,NULL,NULL,NULL,NULL),(14,'ref_activity','cnix_ccx_products','ccx_vbr',0,0,0,0,NULL,1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `nanx_biz_column_editor_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_biz_column_follow_cfg`
--

DROP TABLE IF EXISTS `nanx_biz_column_follow_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_biz_column_follow_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `base_table` char(100) NOT NULL DEFAULT '',
  `field_e` char(30) NOT NULL DEFAULT '',
  `combo_table` char(100) DEFAULT NULL,
  `combo_table_value_field` char(100) DEFAULT NULL,
  `base_table_follow_field` char(100) DEFAULT NULL,
  `combo_table_follow_field` varchar(255) DEFAULT NULL,
  `group_id` char(30) DEFAULT NULL,
  `level` int(10) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_biz_column_follow_cfg`
--

LOCK TABLES `nanx_biz_column_follow_cfg` WRITE;
/*!40000 ALTER TABLE `nanx_biz_column_follow_cfg` DISABLE KEYS */;
INSERT INTO `nanx_biz_column_follow_cfg` VALUES (20,'standx_inlist','prod_code','standx_prod_list','prod','price','price','yep8kA55',NULL);
/*!40000 ALTER TABLE `nanx_biz_column_follow_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_biz_column_trigger_group`
--

DROP TABLE IF EXISTS `nanx_biz_column_trigger_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_biz_column_trigger_group` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `base_table` char(100) NOT NULL DEFAULT '',
  `field_e` char(30) NOT NULL DEFAULT '',
  `combo_table` char(100) DEFAULT NULL,
  `list_field` char(30) DEFAULT NULL,
  `value_field` char(30) DEFAULT NULL,
  `filter_field` varchar(255) DEFAULT NULL,
  `group_id` char(30) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `group_type` char(7) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_biz_column_trigger_group`
--

LOCK TABLES `nanx_biz_column_trigger_group` WRITE;
/*!40000 ALTER TABLE `nanx_biz_column_trigger_group` DISABLE KEYS */;
INSERT INTO `nanx_biz_column_trigger_group` VALUES (54,'standx_vendor_list','prov','standx_prov_list','provname','provid',NULL,'AAA',1,'isgroup'),(55,'standx_vendor_list','city','standx_city_list','cityname','cityid','provid','AAA',2,'isgroup'),(56,'standx_vendor_list','dist','standx_dist_list','distname','distid','cityid','AAA',3,'isgroup'),(58,'standx_inlist','prod_code','standx_prod_list','prodname','prod',NULL,'yep8kA55',1,'nogroup'),(60,'room_source','ownerid','room_host','realname','pid',NULL,'0VrLRhm8',1,'nogroup'),(62,'room_locklist','node_no','room_locknode','node_no','node_no',NULL,'b4f9FXdU',1,'nogroup'),(63,'room_locklist','lock_kind','room_lock_kind','lock_type_text','lock_type_code',NULL,'Xbci6i01',1,'nogroup'),(64,'room_host','gender','room_code_sex','sex_string','sex_type',NULL,'9BzkgspS',1,'nogroup'),(65,'room_locknode','house_code','room_source','address','pid',NULL,'kxZIN0Ap',1,'nogroup'),(66,'room_locknode','node_kind','room_lock_kind','lock_type_text','lock_type_code',NULL,'5BA1kq9H',1,'nogroup'),(67,'room_locklist','house_code','room_source','address','pid',NULL,'Z4x3RPSh',1,'nogroup'),(68,'room_user','gender','room_code_sex','sex_string','sex_type',NULL,'HvqmBO5n',1,'nogroup'),(69,'room_source_pic','sourceid','room_source','roomtitle','pid',NULL,'ioSm4rdK',1,'nogroup'),(70,'room_city_list','provid','room_prov_list','provname','provid',NULL,'eSV73frH',1,'nogroup'),(72,'room_source','provid','room_prov_list','provname','provid',NULL,'省-城下拉',1,'isgroup'),(73,'room_source','cityid','room_city_list','cityname','cityid','provid','省-城下拉',2,'isgroup'),(74,'room_hot_city','provid','room_prov_list','provname','provid',NULL,'省市',1,'isgroup'),(75,'room_hot_city','cityid','room_city_list','cityname','cityid','provid','省市',2,'isgroup'),(76,'room_order_history','sourceid','room_source','roomtitle','pid',NULL,'ddU13dwU',1,'nogroup'),(77,'room_order_history','userid','room_user','realname','pid',NULL,'TD7FsZ72',1,'nogroup'),(78,'room_source','node_no','room_locknode','node_no','node_no',NULL,'网关_门锁列表',1,'isgroup'),(79,'room_source','lockdeviceid','room_locklist','lock_no','lock_no','node_no','网关_门锁列表',2,'isgroup'),(80,'cnix_cloud_location','ccxid','cnix_ccx_provider','ccxname','pid',NULL,'1E7IKz7p',1,'nogroup'),(81,'cnix_cloud_access','ccx_id','cnix_ccx_provider','ccxname','pid',NULL,'41g95vM0',1,'nogroup'),(82,'cnix_cloud_access','custid','cnix_cust','custname','pid',NULL,'utsGCLn0',1,'nogroup'),(83,'cnix_ccx_products','custid','cnix_cust','custname','pid',NULL,'WmFzblbF',1,'nogroup'),(84,'cnix_ccx_products','ccx_id','cnix_ccx_provider','ccxname','pid',NULL,'8i43fCHK',1,'nogroup'),(85,'cnix_ccx_products','locationpid','cnix_cloud_location','location','pid',NULL,'zQ28vGu2',1,'nogroup'),(86,'cnix_invoice','ccx_prodid','cnix_ccx_products','custid','pid',NULL,'GcDz64w6',1,'nogroup'),(88,'cnix_cust','vlan','cnix_vlan','vlan','vlan',NULL,'qmcLIr0i',1,'nogroup');
/*!40000 ALTER TABLE `nanx_biz_column_trigger_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_biz_tables`
--

DROP TABLE IF EXISTS `nanx_biz_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_biz_tables` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` char(100) DEFAULT NULL,
  `table_screen_name` char(30) DEFAULT NULL,
  `memo` char(30) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `table_screen_name` (`table_screen_name`),
  UNIQUE KEY `table_name` (`table_name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_biz_tables`
--

LOCK TABLES `nanx_biz_tables` WRITE;
/*!40000 ALTER TABLE `nanx_biz_tables` DISABLE KEYS */;
INSERT INTO `nanx_biz_tables` VALUES (21,'cnix_cust','客户',NULL),(22,'cnix_ccx_provider','业务表_cnix_ccx_provider',NULL),(23,'cnix_cloud_access','业务表_cnix_cloud_access',NULL),(24,'cnix_cloud_location','业务表_cnix_cloud_location',NULL),(25,'cnix_ccx_products','业务表_cnix_ccx_products',NULL),(26,'cnix_presale_contact','客户联系方式收集',NULL),(27,'cnix_invoice','业务表_cnix_invoice',NULL),(28,'cnix_carslist','货车资源',NULL),(29,'cnix_vlan','vlan',NULL);
/*!40000 ALTER TABLE `nanx_biz_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_country`
--

DROP TABLE IF EXISTS `nanx_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_country` (
  `pid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id` char(30) DEFAULT NULL,
  `lang_txt` char(100) DEFAULT NULL,
  `active` char(1) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_country`
--

LOCK TABLES `nanx_country` WRITE;
/*!40000 ALTER TABLE `nanx_country` DISABLE KEYS */;
INSERT INTO `nanx_country` VALUES (1,'af','Afrikaans',NULL),(2,'sq','Albanian',NULL),(3,'ar-dz','Arabic (Algeria)',NULL),(4,'ar-bh','Arabic (Bahrain)',NULL),(5,'ar-eg','Arabic (Egypt)',NULL),(6,'ar-iq','Arabic (Iraq)',NULL),(7,'ar-jo','Arabic (Jordan)',NULL),(8,'ar-kw','Arabic (Kuwait)',NULL),(9,'ar-lb','Arabic (Lebanon)',NULL),(10,'ar-ly','Arabic (libya)',NULL),(11,'ar-ma','Arabic (Morocco)',NULL),(12,'ar-om','Arabic (Oman)',NULL),(13,'ar-qa','Arabic (Qatar)',NULL),(14,'ar-sa','Arabic (Saudi Arabia)',NULL),(15,'ar-sy','Arabic (Syria)',NULL),(16,'ar-tn','Arabic (Tunisia)',NULL),(17,'ar-ae','Arabic (U.A.E.)',NULL),(18,'ar-ye','Arabic (Yemen)',NULL),(19,'ar','Arabic',NULL),(20,'hy','Armenian',NULL),(21,'as','Assamese',NULL),(22,'az','Azeri',NULL),(23,'eu','Basque',NULL),(24,'be','Belarusian',NULL),(25,'bn','Bengali',NULL),(26,'bg','Bulgarian',NULL),(27,'ca','Catalan',NULL),(28,'zh-cn','中文','y'),(29,'zh-hk','Chinese (Hong Kong)','y'),(30,'zh-mo','Chinese (Macau)','n'),(31,'zh-sg','Chinese (Singapore)','n'),(32,'zh-tw','Chinese (Taiwan)','y'),(34,'hr','Croatian',NULL),(35,'cs','Czech',NULL),(36,'da','Danish',NULL),(37,'div','Divehi',NULL),(38,'nl-be','Dutch (Belgium)',NULL),(39,'nl','Dutch (Netherlands)',NULL),(40,'en-au','English (Australia)',NULL),(41,'en-bz','English (Belize)',NULL),(42,'en-ca','English (Canada)',NULL),(43,'en-ie','English (Ireland)',NULL),(44,'en-jm','English (Jamaica)',NULL),(45,'en-nz','English (New Zealand)',NULL),(46,'en-ph','English (Philippines)',NULL),(47,'en-za','English (South Africa)',NULL),(48,'en-tt','English (Trinidad)',NULL),(49,'en-gb','English (United Kingdom)',NULL),(50,'en-us','English (United States)',NULL),(51,'en-zw','English (Zimbabwe)',NULL),(52,'en','English','y'),(53,'us','English (United States)',NULL),(54,'et','Estonian',NULL),(55,'fo','Faeroese',NULL),(56,'fa','Farsi',NULL),(57,'fi','Finnish',NULL),(58,'fr-be','French (Belgium)',NULL),(59,'fr-ca','French (Canada)',NULL),(60,'fr-lu','French (Luxembourg)',NULL),(61,'fr-mc','French (Monaco)',NULL),(62,'fr-ch','French (Switzerland)',NULL),(63,'fr','French (France)','y'),(64,'mk','FYRO Macedonian',NULL),(65,'gd','Gaelic',NULL),(66,'ka','Georgian',NULL),(67,'de-at','German (Austria)',NULL),(68,'de-li','German (Liechtenstein)',NULL),(69,'de-lu','German (Luxembourg)',NULL),(70,'de-ch','German (Switzerland)',NULL),(71,'de','German (Germany)','y'),(72,'el','Greek',NULL),(73,'gu','Gujarati',NULL),(74,'he','Hebrew',NULL),(75,'hi','Hindi',NULL),(76,'hu','Hungarian','y'),(77,'is','Icelandic',NULL),(78,'id','Indonesian',NULL),(79,'it-ch','Italian (Switzerland)',NULL),(80,'it','Italian (Italy)','y'),(81,'ja','Japanese','y'),(82,'kn','Kannada',NULL),(83,'kk','Kazakh',NULL),(84,'kok','Konkani',NULL),(85,'ko','Korean','y'),(86,'kz','Kyrgyz',NULL),(87,'lv','Latvian',NULL),(88,'lt','Lithuanian',NULL),(89,'ms','Malay',NULL),(90,'ml','Malayalam',NULL),(91,'mt','Maltese',NULL),(92,'mr','Marathi',NULL),(93,'mn','Mongolian (Cyrillic)',NULL),(94,'ne','Nepali (India)',NULL),(95,'nb-no','Norwegian (Bokmal)',NULL),(96,'nn-no','Norwegian (Nynorsk)',NULL),(97,'no','Norwegian (Bokmal)',NULL),(98,'or','Oriya',NULL),(99,'pl','Polish','y'),(100,'pt-br','Portuguese (Brazil)',NULL),(101,'pt','Portuguese (Portugal)',NULL),(102,'pa','Punjabi',NULL),(103,'rm','Rhaeto-Romanic',NULL),(104,'ro-md','Romanian (Moldova)',NULL),(105,'ro','Romanian',NULL),(106,'ru-md','Russian (Moldova)',NULL),(107,'ru','Russian',NULL),(108,'sa','Sanskrit',NULL),(109,'sr','Serbian',NULL),(110,'sk','Slovak',NULL),(111,'ls','Slovenian',NULL),(112,'sb','Sorbian',NULL),(113,'es-ar','Spanish (Argentina)',NULL),(114,'es-bo','Spanish (Bolivia)',NULL),(115,'es-cl','Spanish (Chile)',NULL),(116,'es-co','Spanish (Colombia)',NULL),(117,'es-cr','Spanish (Costa Rica)',NULL),(118,'es-do','Spanish (Dominican Republic)',NULL),(119,'es-ec','Spanish (Ecuador)',NULL),(120,'es-sv','Spanish (El Salvador)',NULL),(121,'es-gt','Spanish (Guatemala)',NULL),(122,'es-hn','Spanish (Honduras)',NULL),(123,'es-mx','Spanish (Mexico)',NULL),(124,'es-ni','Spanish (Nicaragua)',NULL),(125,'es-pa','Spanish (Panama)',NULL),(126,'es-py','Spanish (Paraguay)',NULL),(127,'es-pe','Spanish (Peru)',NULL),(128,'es-pr','Spanish (Puerto Rico)',NULL),(129,'es-us','Spanish (United States)',NULL),(130,'es-uy','Spanish (Uruguay)',NULL),(131,'es-ve','Spanish (Venezuela)',NULL),(132,'es','Spanish (Traditional Sort)',NULL),(133,'sx','Sutu',NULL),(134,'sw','Swahili',NULL),(135,'sv-fi','Swedish (Finland)',NULL),(136,'sv','Swedish',NULL),(137,'syr','Syriac',NULL),(138,'ta','Tamil',NULL),(139,'tt','Tatar',NULL),(140,'te','Telugu',NULL),(141,'th','Thai',NULL),(142,'ts','Tsonga',NULL),(143,'tn','Tswana',NULL),(144,'tr','Turkish',NULL),(145,'uk','Ukrainian',NULL),(146,'ur','Urdu',NULL),(147,'uz','Uzbek',NULL),(148,'vi','Vietnamese',NULL),(149,'xh','Xhosa',NULL),(150,'yi','Yiddish',NULL),(151,'zu','Zulu',NULL);
/*!40000 ALTER TABLE `nanx_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_lang`
--

DROP TABLE IF EXISTS `nanx_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_lang` (
  `pid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id` char(30) DEFAULT NULL,
  `lang_txt` char(100) DEFAULT NULL,
  `active` char(1) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_lang`
--

LOCK TABLES `nanx_lang` WRITE;
/*!40000 ALTER TABLE `nanx_lang` DISABLE KEYS */;
INSERT INTO `nanx_lang` VALUES (1,'af','Afrikaans',NULL),(2,'sq','Albanian',NULL),(3,'ar-dz','Arabic (Algeria)',NULL),(4,'ar-bh','Arabic (Bahrain)',NULL),(5,'ar-eg','Arabic (Egypt)',NULL),(6,'ar-iq','Arabic (Iraq)',NULL),(7,'ar-jo','Arabic (Jordan)',NULL),(8,'ar-kw','Arabic (Kuwait)',NULL),(9,'ar-lb','Arabic (Lebanon)',NULL),(10,'ar-ly','Arabic (libya)',NULL),(11,'ar-ma','Arabic (Morocco)',NULL),(12,'ar-om','Arabic (Oman)',NULL),(13,'ar-qa','Arabic (Qatar)',NULL),(14,'ar-sa','Arabic (Saudi Arabia)',NULL),(15,'ar-sy','Arabic (Syria)',NULL),(16,'ar-tn','Arabic (Tunisia)',NULL),(17,'ar-ae','Arabic (U.A.E.)',NULL),(18,'ar-ye','Arabic (Yemen)',NULL),(19,'ar','Arabic',NULL),(20,'hy','Armenian',NULL),(21,'as','Assamese',NULL),(22,'az','Azeri',NULL),(23,'eu','Basque',NULL),(24,'be','Belarusian',NULL),(25,'bn','Bengali',NULL),(26,'bg','Bulgarian',NULL),(27,'ca','Catalan',NULL),(28,'zh-cn','中文','y'),(29,'zh-hk','Chinese (Hong Kong)','y'),(30,'zh-mo','Chinese (Macau)','n'),(31,'zh-sg','Chinese (Singapore)','n'),(32,'zh-tw','Chinese (Taiwan)','y'),(34,'hr','Croatian',NULL),(35,'cs','Czech',NULL),(36,'da','Danish',NULL),(37,'div','Divehi',NULL),(38,'nl-be','Dutch (Belgium)',NULL),(39,'nl','Dutch (Netherlands)',NULL),(40,'en-au','English (Australia)',NULL),(41,'en-bz','English (Belize)',NULL),(42,'en-ca','English (Canada)',NULL),(43,'en-ie','English (Ireland)',NULL),(44,'en-jm','English (Jamaica)',NULL),(45,'en-nz','English (New Zealand)',NULL),(46,'en-ph','English (Philippines)',NULL),(47,'en-za','English (South Africa)',NULL),(48,'en-tt','English (Trinidad)',NULL),(49,'en-gb','English (United Kingdom)',NULL),(50,'en-us','English (United States)',NULL),(51,'en-zw','English (Zimbabwe)',NULL),(52,'en','English','y'),(53,'us','English (United States)',NULL),(54,'et','Estonian',NULL),(55,'fo','Faeroese',NULL),(56,'fa','Farsi',NULL),(57,'fi','Finnish',NULL),(58,'fr-be','French (Belgium)',NULL),(59,'fr-ca','French (Canada)',NULL),(60,'fr-lu','French (Luxembourg)',NULL),(61,'fr-mc','French (Monaco)',NULL),(62,'fr-ch','French (Switzerland)',NULL),(63,'fr','French (France)','y'),(64,'mk','FYRO Macedonian',NULL),(65,'gd','Gaelic',NULL),(66,'ka','Georgian',NULL),(67,'de-at','German (Austria)',NULL),(68,'de-li','German (Liechtenstein)',NULL),(69,'de-lu','German (Luxembourg)',NULL),(70,'de-ch','German (Switzerland)',NULL),(71,'de','German (Germany)','y'),(72,'el','Greek',NULL),(73,'gu','Gujarati',NULL),(74,'he','Hebrew',NULL),(75,'hi','Hindi',NULL),(76,'hu','Hungarian','y'),(77,'is','Icelandic',NULL),(78,'id','Indonesian',NULL),(79,'it-ch','Italian (Switzerland)',NULL),(80,'it','Italian (Italy)','y'),(81,'ja','Japanese','y'),(82,'kn','Kannada',NULL),(83,'kk','Kazakh',NULL),(84,'kok','Konkani',NULL),(85,'ko','Korean','y'),(86,'kz','Kyrgyz',NULL),(87,'lv','Latvian',NULL),(88,'lt','Lithuanian',NULL),(89,'ms','Malay',NULL),(90,'ml','Malayalam',NULL),(91,'mt','Maltese',NULL),(92,'mr','Marathi',NULL),(93,'mn','Mongolian (Cyrillic)',NULL),(94,'ne','Nepali (India)',NULL),(95,'nb-no','Norwegian (Bokmal)',NULL),(96,'nn-no','Norwegian (Nynorsk)',NULL),(97,'no','Norwegian (Bokmal)',NULL),(98,'or','Oriya',NULL),(99,'pl','Polish','y'),(100,'pt-br','Portuguese (Brazil)',NULL),(101,'pt','Portuguese (Portugal)',NULL),(102,'pa','Punjabi',NULL),(103,'rm','Rhaeto-Romanic',NULL),(104,'ro-md','Romanian (Moldova)',NULL),(105,'ro','Romanian',NULL),(106,'ru-md','Russian (Moldova)',NULL),(107,'ru','Russian',NULL),(108,'sa','Sanskrit',NULL),(109,'sr','Serbian',NULL),(110,'sk','Slovak',NULL),(111,'ls','Slovenian',NULL),(112,'sb','Sorbian',NULL),(113,'es-ar','Spanish (Argentina)',NULL),(114,'es-bo','Spanish (Bolivia)',NULL),(115,'es-cl','Spanish (Chile)',NULL),(116,'es-co','Spanish (Colombia)',NULL),(117,'es-cr','Spanish (Costa Rica)',NULL),(118,'es-do','Spanish (Dominican Republic)',NULL),(119,'es-ec','Spanish (Ecuador)',NULL),(120,'es-sv','Spanish (El Salvador)',NULL),(121,'es-gt','Spanish (Guatemala)',NULL),(122,'es-hn','Spanish (Honduras)',NULL),(123,'es-mx','Spanish (Mexico)',NULL),(124,'es-ni','Spanish (Nicaragua)',NULL),(125,'es-pa','Spanish (Panama)',NULL),(126,'es-py','Spanish (Paraguay)',NULL),(127,'es-pe','Spanish (Peru)',NULL),(128,'es-pr','Spanish (Puerto Rico)',NULL),(129,'es-us','Spanish (United States)',NULL),(130,'es-uy','Spanish (Uruguay)',NULL),(131,'es-ve','Spanish (Venezuela)',NULL),(132,'es','Spanish (Traditional Sort)',NULL),(133,'sx','Sutu',NULL),(134,'sw','Swahili',NULL),(135,'sv-fi','Swedish (Finland)',NULL),(136,'sv','Swedish',NULL),(137,'syr','Syriac',NULL),(138,'ta','Tamil',NULL),(139,'tt','Tatar',NULL),(140,'te','Telugu',NULL),(141,'th','Thai',NULL),(142,'ts','Tsonga',NULL),(143,'tn','Tswana',NULL),(144,'tr','Turkish',NULL),(145,'uk','Ukrainian',NULL),(146,'ur','Urdu',NULL),(147,'uz','Uzbek',NULL),(148,'vi','Vietnamese',NULL),(149,'xh','Xhosa',NULL),(150,'yi','Yiddish',NULL),(151,'zu','Zulu',NULL);
/*!40000 ALTER TABLE `nanx_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_session_log`
--

DROP TABLE IF EXISTS `nanx_session_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_session_log` (
  `ts` datetime DEFAULT NULL,
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `action_cmd` char(20) DEFAULT NULL,
  `act_code` char(100) DEFAULT NULL,
  `table` char(100) DEFAULT NULL,
  `pids` varchar(255) DEFAULT NULL,
  `rawdata` text,
  `old_data` text,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_session_log`
--

LOCK TABLES `nanx_session_log` WRITE;
/*!40000 ALTER TABLE `nanx_session_log` DISABLE KEYS */;
INSERT INTO `nanx_session_log` VALUES ('2017-11-02 06:01:01',1,'管理员[cnix]','add','act_cnix_ccx_provider_1457807308','cnix_ccx_provider','','ccxname:青云,infotxt:青云服务商,memo:青云',NULL),('2017-11-02 06:01:51',2,'管理员[cnix]','update','act_cnix_ccx_provider_1457807308','cnix_ccx_provider','','pid:1,ccxname:青云,infotxt:青云服务商,memo:青云,ccxcode:qingyun','pid:1,ccxname:青云,infotxt:青云服务商,memo:青云,ccxcode:NULL'),('2017-11-02 06:02:15',3,'管理员[cnix]','update','act_cnix_ccx_provider_1457807308','cnix_ccx_provider','','pid:1,ccxname:青云,infotxt:青云服务商,memo:青云,ccxcode:qingcloud','pid:1,ccxname:青云,infotxt:青云服务商,memo:青云,ccxcode:qingyun'),('2017-11-02 06:07:07',4,'管理员[cnix]','add','act_cnix_cloud_location_242945864','cnix_cloud_location','','ccxid:1,location:青云-北京节点',NULL),('2017-11-02 06:07:16',5,'管理员[cnix]','add','act_cnix_cloud_location_242945864','cnix_cloud_location','','ccxid:1,location:青云-上海节点',NULL),('2017-11-02 06:07:43',6,'管理员[cnix]','add','act_cnix_cust_1413684591','cnix_cust','','custname:cust-a,contact:aaa,mobile:111,email:111,custstatus:NULL',NULL),('2017-11-02 06:07:53',7,'管理员[cnix]','add','act_cnix_cust_1413684591','cnix_cust','','custname:cust-b,contact:111,mobile:11,email:NULL,custstatus:NULL',NULL),('2017-11-02 06:13:09',8,'管理员[cnix]','add','act_cnix_ccx_provider_1457807308','cnix_ccx_provider','','ccxname:阿里云,infotxt:阿里云,memo:NULL,ccxcode:aliyun',NULL),('2017-11-02 06:13:23',9,'管理员[cnix]','add','act_cnix_cloud_location_242945864','cnix_cloud_location','','ccxid:2,location:阿里-北京',NULL),('2017-11-02 06:13:33',10,'管理员[cnix]','add','act_cnix_cloud_location_242945864','cnix_cloud_location','','ccxid:2,location:阿里-杭州',NULL),('2017-11-13 12:26:57',11,'管理员[cnix]','delete','act_cnix_ccx_products_666479275','cnix_ccx_products','0:4,1:3,2:2','0','0:[pid:4,bandwidth:1,custid:2,ccx_id:1,ccx_vbr:vbr,createtime:2017-11-13 12:26:24,months:3,expirdate:,locationpid:1],1:[pid:3,bandwidth:2,custid:2,ccx_id:2,ccx_vbr:vbr,createtime:2017-11-13 12:26:10,months:12,expirdate:,locationpid:4],2:[pid:2,bandwidth:1,custid:2,ccx_id:1,ccx_vbr:vbr,createtime:2017-11-13 12:26:05,months:3,expirdate:,locationpid:1]'),('2017-11-13 12:41:02',12,'管理员[cnix]','add','act_cnix_ccx_provider_1457807308','cnix_ccx_provider','','ccxname:百度云,infotxt:百度云,memo:NULL,ccxcode:baidu',NULL),('2017-11-13 12:41:22',13,'管理员[cnix]','add','act_cnix_cloud_location_242945864','cnix_cloud_location','','ccxid:3,location:百度-北京',NULL),('2017-11-13 12:41:33',14,'管理员[cnix]','add','act_cnix_cloud_location_242945864','cnix_cloud_location','','ccxid:3,location:百度-上海',NULL),('2017-11-13 12:41:42',15,'管理员[cnix]','add','act_cnix_cloud_location_242945864','cnix_cloud_location','','ccxid:3,location:百度-南京',NULL),('2017-11-13 12:41:53',16,'管理员[cnix]','add','act_cnix_cloud_location_242945864','cnix_cloud_location','','ccxid:3,location:百度-广州',NULL),('2017-11-13 13:12:50',17,'管理员[cnix]','delete','act_cnix_ccx_products_666479275','cnix_ccx_products','0:9,1:10,2:11,3:12,4:13,5:14,6:15','0','0:[pid:9,bandwidth:1,custid:2,ccx_id:,ccx_vbr:vbr,createtime:2017-11-13 12:33:44,months:3,expirdate:,locationpid:0],1:[pid:10,bandwidth:1,custid:2,ccx_id:,ccx_vbr:vbr,createtime:2017-11-13 12:34:01,months:3,expirdate:,locationpid:0],2:[pid:11,bandwidth:1,custid:2,ccx_id:,ccx_vbr:vbr,createtime:2017-11-13 12:34:14,months:3,expirdate:,locationpid:0],3:[pid:12,bandwidth:1,custid:2,ccx_id:,ccx_vbr:vbr,createtime:2017-11-13 12:34:55,months:3,expirdate:,locationpid:0],4:[pid:13,bandwidth:1,custid:2,ccx_id:,ccx_vbr:vbr,createtime:2017-11-13 12:35:29,months:3,expirdate:,locationpid:0],5:[pid:14,bandwidth:1,custid:2,ccx_id:,ccx_vbr:vbr,createtime:2017-11-13 12:36:42,months:3,expirdate:,locationpid:0],6:[pid:15,bandwidth:1,custid:2,ccx_id:,ccx_vbr:vbr,createtime:2017-11-13 12:37:09,months:3,expirdate:,locationpid:0]'),('2017-11-19 15:32:54',18,'管理员[cnix]','add','act_cnix_cloud_location_242945864','cnix_cloud_location','','ccxid:3,location:天津',NULL),('2017-11-19 15:38:38',19,'管理员[cnix]','add','act_cnix_carslist_1254705227','cnix_carslist','','car_no:AK909090023,drv_name:杨司机',NULL),('2017-11-21 13:41:50',20,'管理员[cnix]','add','act_cnix_vlan_145209745','cnix_vlan','','vlan:vl111111',NULL),('2017-11-21 13:41:57',21,'管理员[cnix]','add','act_cnix_vlan_145209745','cnix_vlan','','vlan:v22222',NULL);
/*!40000 ALTER TABLE `nanx_session_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_shadow`
--

DROP TABLE IF EXISTS `nanx_shadow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_shadow` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT '保留列,请勿删除',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_shadow`
--

LOCK TABLES `nanx_shadow` WRITE;
/*!40000 ALTER TABLE `nanx_shadow` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanx_shadow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_sms`
--

DROP TABLE IF EXISTS `nanx_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_sms` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `sender` char(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `receiver` char(20) DEFAULT NULL,
  `msg` varchar(255) DEFAULT NULL,
  `sendtime` datetime DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_sms`
--

LOCK TABLES `nanx_sms` WRITE;
/*!40000 ALTER TABLE `nanx_sms` DISABLE KEYS */;
INSERT INTO `nanx_sms` VALUES (1,'系统通知','room:对活动:房源管理执行了\'修改记录\'操作','room','room:对活动:房源管理执行了\'修改记录\'操作','2017-09-27 15:46:48');
/*!40000 ALTER TABLE `nanx_sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_system_cfg`
--

DROP TABLE IF EXISTS `nanx_system_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_system_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` char(30) NOT NULL DEFAULT '',
  `config_value` char(100) NOT NULL DEFAULT '',
  `config_memo` varchar(255) DEFAULT '',
  `memo_of_config_item` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_system_cfg`
--

LOCK TABLES `nanx_system_cfg` WRITE;
/*!40000 ALTER TABLE `nanx_system_cfg` DISABLE KEYS */;
INSERT INTO `nanx_system_cfg` VALUES (1,'VER','2.02','系统版 本','Version of system'),(2,'BANNER_TITLE','CNIX','网站左上角标题','Text on  lett-top '),(3,'SECRET_KEY','3cd9342dc190','应用加密串','Secret key'),(6,'PAGE_TITLE','CNIX','浏览器标题333','Title of Browser'),(7,'APP_PREFIX','cnix','表格前缀','Prefix of table'),(8,'COMPANY_LOGO','Light_On.png','企业的logo','Logo on login'),(9,'WIN_SIZE_HEIGHT','644','窗口高度(像素为单位)','Default window  height'),(10,'WIN_SIZE_WIDTH','800','窗口宽度(像素为单位)','Default window  width'),(11,'WIN_SIZE_WIDTH_OPERATION','899','数据修改窗口的宽度(像素为单位))','Default window width on modify data');
/*!40000 ALTER TABLE `nanx_system_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_user`
--

DROP TABLE IF EXISTS `nanx_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_user` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `user` char(30) DEFAULT NULL COMMENT '登录名,唯一索引.',
  `password` char(64) DEFAULT NULL COMMENT 'md5加密的密码',
  `staff_name` char(10) DEFAULT NULL COMMENT '对应员工的姓名,暂不管同名的员工',
  `active` char(1) NOT NULL DEFAULT '' COMMENT '是否激活(Y,N)',
  `last_login_ts` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次登录时间',
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `salt` char(6) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_user`
--

LOCK TABLES `nanx_user` WRITE;
/*!40000 ALTER TABLE `nanx_user` DISABLE KEYS */;
INSERT INTO `nanx_user` VALUES (3,'cnix','b62fdfd165082eda2215655b520ae2f4','管理员','Y','0000-00-00 00:00:00',NULL,NULL,'9414fe');
/*!40000 ALTER TABLE `nanx_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_user_role`
--

DROP TABLE IF EXISTS `nanx_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_user_role` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `role_code` char(30) NOT NULL DEFAULT '',
  `role_name` char(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `role_code` (`role_code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_user_role`
--

LOCK TABLES `nanx_user_role` WRITE;
/*!40000 ALTER TABLE `nanx_user_role` DISABLE KEYS */;
INSERT INTO `nanx_user_role` VALUES (4,'admin','管理员'),(6,'sales','销售'),(7,'market','市场');
/*!40000 ALTER TABLE `nanx_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_user_role_assign`
--

DROP TABLE IF EXISTS `nanx_user_role_assign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_user_role_assign` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `user` char(30) DEFAULT NULL,
  `role_code` char(30) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `user` (`user`,`role_code`),
  KEY `user_2` (`user`),
  KEY `role_code` (`role_code`),
  CONSTRAINT `nanx_user_role_assign_ibfk_1` FOREIGN KEY (`user`) REFERENCES `nanx_user` (`user`),
  CONSTRAINT `nanx_user_role_assign_ibfk_2` FOREIGN KEY (`role_code`) REFERENCES `nanx_user_role` (`role_code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_user_role_assign`
--

LOCK TABLES `nanx_user_role_assign` WRITE;
/*!40000 ALTER TABLE `nanx_user_role_assign` DISABLE KEYS */;
INSERT INTO `nanx_user_role_assign` VALUES (3,'cnix','admin');
/*!40000 ALTER TABLE `nanx_user_role_assign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_user_role_privilege`
--

DROP TABLE IF EXISTS `nanx_user_role_privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_user_role_privilege` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `role_code` char(30) DEFAULT NULL,
  `activity_code` char(255) NOT NULL DEFAULT '',
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `role_code` (`role_code`,`activity_code`),
  KEY `activity_code` (`activity_code`),
  CONSTRAINT `nanx_user_role_privilege_ibfk_2` FOREIGN KEY (`role_code`) REFERENCES `nanx_user_role` (`role_code`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_user_role_privilege`
--

LOCK TABLES `nanx_user_role_privilege` WRITE;
/*!40000 ALTER TABLE `nanx_user_role_privilege` DISABLE KEYS */;
INSERT INTO `nanx_user_role_privilege` VALUES (21,'admin','act_cnix_cust_1413684591',NULL),(22,'admin','act_cnix_ccx_provider_1457807308',NULL),(23,'admin','act_cnix_cloud_access_41676287',NULL),(24,'admin','act_cnix_cloud_location_242945864',NULL),(25,'admin','act_cnix_ccx_products_666479275',NULL),(26,'admin','act_cnix_presale_contact_2086450178',NULL),(27,'admin','act_cnix_invoice_723349916',NULL),(28,'admin','act_cnix_carslist_1254705227',NULL),(29,'admin','act_cnix_vlan_145209745',NULL);
/*!40000 ALTER TABLE `nanx_user_role_privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nanx_who_is_who`
--

DROP TABLE IF EXISTS `nanx_menu`;

CREATE TABLE `nanx_menu` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `activity_code` char(100) DEFAULT NULL,
  `grid_title` char(200) DEFAULT NULL,
  `activity_type` char(100) DEFAULT NULL,
  `role_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



DROP TABLE IF EXISTS `nanx_who_is_who`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nanx_who_is_who` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` char(30) DEFAULT NULL,
  `inner_table` char(30) DEFAULT NULL,
  `inner_table_pid` int(11) DEFAULT NULL,
  `inner_table_value_field` char(100) DEFAULT NULL,
  `inner_table_value` char(100) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pk_whoiswho` (`inner_table`,`inner_table_pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nanx_who_is_who`
--

LOCK TABLES `nanx_who_is_who` WRITE;
/*!40000 ALTER TABLE `nanx_who_is_who` DISABLE KEYS */;
/*!40000 ALTER TABLE `nanx_who_is_who` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-04 12:04:05
