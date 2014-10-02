# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.20)
# Database: standx
# Generation Time: 2014-10-02 11:24:01 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table nanx_activity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity`;

CREATE TABLE `nanx_activity` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(30) NOT NULL DEFAULT '' COMMENT '活动代码code',
  `activity_type` char(20) DEFAULT NULL,
  `memo` char(255) DEFAULT NULL,
  `base_table` char(100) DEFAULT NULL,
  `service_url` char(100) DEFAULT NULL,
  `url_for_get_cfg` varchar(255) NOT NULL DEFAULT '' COMMENT '执行活动的url',
  `url_para` char(255) DEFAULT NULL,
  `pic_url` char(100) NOT NULL DEFAULT '' COMMENT '显示的图片地址',
  `grid_title` char(30) DEFAULT NULL,
  `sql` varchar(900) DEFAULT NULL,
  `extra_js` char(30) DEFAULT NULL,
  `js_function_point` char(100) DEFAULT NULL,
  `level` char(6) NOT NULL DEFAULT 'F',
  `data_url` char(255) DEFAULT NULL,
  `win_size_height` int(255) DEFAULT NULL,
  `win_size_width` int(255) DEFAULT NULL,
  `win_size_width_operation` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`)
) ENGINE=InnoDB AUTO_INCREMENT=230 DEFAULT CHARSET=utf8 COMMENT='活动注册表格';

LOCK TABLES `nanx_activity` WRITE;
/*!40000 ALTER TABLE `nanx_activity` DISABLE KEYS */;

INSERT INTO `nanx_activity` (`pid`, `activity_code`, `activity_type`, `memo`, `base_table`, `service_url`, `url_for_get_cfg`, `url_para`, `pic_url`, `grid_title`, `sql`, `extra_js`, `js_function_point`, `level`, `data_url`, `win_size_height`, `win_size_width`, `win_size_width_operation`)
VALUES
	(90,'NANX_TBL_DATA','service',NULL,NULL,'rdbms/getTableFields','rdbms/getTableFields','table','http://127.0.0.1/nanx/imgs/icon-48-banner-categories.png','',NULL,NULL,NULL,'system','curd/listData',662,800,NULL),
	(91,'NANX_TBL_STRU','service',NULL,NULL,'rdbms/get_table_creation_info_no_directshow','rdbms/get_table_creation_info_no_directshow','table','http://127.0.0.1/nanx/imgs/icon-48-banner-categories.png',NULL,NULL,NULL,NULL,'system','rdbms/get_table_creation_info_directshow',NULL,NULL,NULL),
	(92,'NANX_TBL_INDEX','service',NULL,NULL,'rdbms/get_min_table_indexes_no_directshow','rdbms/get_min_table_indexes_no_directshow','table','http://127.0.0.1/nanx/imgs/icon-48-banner-categories.png',NULL,NULL,NULL,NULL,'system','rdbms/get_min_table_indexes_directshow',NULL,NULL,NULL),
	(93,'NANX_TBL_CREATE','service',NULL,NULL,'rdbms/get_table_creation_info_no_directshow','rdbms/get_table_creation_info_no_directshow','table','http://127.0.0.1/nanx/imgs/icon-48-banner-categories.png',NULL,NULL,NULL,NULL,'system','rdbms/get_table_creation_info_directshow',NULL,NULL,NULL),
	(116,'NANX_SYS_CONFIG','service',NULL,'',NULL,'',NULL,'',NULL,NULL,NULL,NULL,'system','curd/listData',NULL,NULL,NULL),
	(134,'NANX_APP_SUMMARY','html',NULL,NULL,NULL,'',NULL,'icon-48-links.png','NANX_APP_SUMMARY',NULL,NULL,NULL,'system','tree/systemSummary',NULL,NULL,NULL),
	(177,'NANX_TB_LAYOUT','sql',NULL,NULL,NULL,'',NULL,'',NULL,'select   field_list   from  nanx_activity_biz_layout   where  raw_table=$table',NULL,NULL,'system','curd/listData',NULL,NULL,NULL),
	(226,'NANX_FS_2_TABLE','service',NULL,NULL,'file/getFSGridFields','file/getFSGridFields',NULL,'default_act.png','',NULL,NULL,NULL,'system','file/fs2array',662,800,899),
	(227,'act_standx_saleinfo_1745194825','table',NULL,'standx_saleinfo',NULL,'',NULL,'act_common.png','活动_销售情况',NULL,NULL,NULL,'F',NULL,662,800,NULL),
	(228,'act_standx_sales_1822890602','table',NULL,'standx_sales',NULL,'',NULL,'act_common.png','活动_销售人员',NULL,NULL,NULL,'F',NULL,662,800,NULL),
	(229,'prod_mnt','table',NULL,'standx_prod_list',NULL,'',NULL,'act_common.png','产品列表管理',NULL,NULL,NULL,'F','curd/listData',644,800,899);

/*!40000 ALTER TABLE `nanx_activity` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_activity_a2a_btns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity_a2a_btns`;

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



# Dump of table nanx_activity_batch_btns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity_batch_btns`;

CREATE TABLE `nanx_activity_batch_btns` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` varchar(255) DEFAULT NULL,
  `btn_name` varchar(255) DEFAULT NULL,
  `op_field` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`,`op_field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;



# Dump of table nanx_activity_biz_layout
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity_biz_layout`;

CREATE TABLE `nanx_activity_biz_layout` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(30) DEFAULT NULL,
  `raw_table` char(100) NOT NULL DEFAULT '',
  `row` int(11) NOT NULL DEFAULT '0',
  `field_list` char(100) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;



# Dump of table nanx_activity_curd_cfg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity_curd_cfg`;

CREATE TABLE `nanx_activity_curd_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(30) DEFAULT NULL,
  `fn_add` char(1) DEFAULT NULL,
  `fn_update` char(1) NOT NULL DEFAULT '0',
  `fn_del` char(1) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nanx_activity_field_public_display_cfg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity_field_public_display_cfg`;

CREATE TABLE `nanx_activity_field_public_display_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `field_e` char(30) DEFAULT NULL,
  `field_c` varchar(255) DEFAULT NULL,
  `field_width` int(255) DEFAULT NULL,
  `label_width` int(255) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `base_table` (`field_e`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='活动UI的字段配置。';

LOCK TABLES `nanx_activity_field_public_display_cfg` WRITE;
/*!40000 ALTER TABLE `nanx_activity_field_public_display_cfg` DISABLE KEYS */;

INSERT INTO `nanx_activity_field_public_display_cfg` (`pid`, `field_e`, `field_c`, `field_width`, `label_width`)
VALUES
	(1,'sex','性别',200,NULL),
	(2,'datatype','数据类型',300,NULL),
	(3,'length','长度',NULL,NULL),
	(4,'default_value','缺省值',NULL,NULL),
	(5,'primary_key','主键',NULL,NULL),
	(6,'not_null','非空',NULL,NULL),
	(7,'auto_increment','自动增长',NULL,NULL),
	(8,'comment','备注',NULL,NULL),
	(9,'unsigned','无符号',NULL,NULL),
	(10,'index','索引',NULL,NULL),
	(11,'columns','相关列',NULL,NULL),
	(12,'add_column','修改列',NULL,NULL),
	(13,'option','选项',NULL,NULL),
	(20,'key','配置项',NULL,NULL),
	(21,'value','值',NULL,NULL),
	(22,'tips','提示',NULL,NULL),
	(23,'can_delete','是否可删除',NULL,NULL),
	(111,'field_name','字段名',NULL,NULL),
	(112,'count(*)','汇总',NULL,NULL),
	(133,'field_e','英文字段名',NULL,NULL),
	(134,'field_c','中文字段名',NULL,NULL),
	(135,'field_width','字段长度',NULL,NULL),
	(136,'s_city','城市',300,400);

/*!40000 ALTER TABLE `nanx_activity_field_public_display_cfg` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_activity_field_special_display_cfg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity_field_special_display_cfg`;

CREATE TABLE `nanx_activity_field_special_display_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `base_table` char(100) NOT NULL DEFAULT '',
  `field_e` char(30) NOT NULL DEFAULT '',
  `label_width` int(255) DEFAULT NULL,
  `field_c` varchar(255) DEFAULT NULL,
  `field_width` int(11) DEFAULT NULL,
  `show_as_pic` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `base_table` (`base_table`,`field_e`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='活动UI的字段配置。';

LOCK TABLES `nanx_activity_field_special_display_cfg` WRITE;
/*!40000 ALTER TABLE `nanx_activity_field_special_display_cfg` DISABLE KEYS */;

INSERT INTO `nanx_activity_field_special_display_cfg` (`pid`, `base_table`, `field_e`, `label_width`, `field_c`, `field_width`, `show_as_pic`)
VALUES
	(1,'standx_saleinfo','salenum',NULL,'salenum',NULL,0),
	(2,'standx_saleinfo','prod',NULL,NULL,NULL,0);

/*!40000 ALTER TABLE `nanx_activity_field_special_display_cfg` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_activity_forbidden_field
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity_forbidden_field`;

CREATE TABLE `nanx_activity_forbidden_field` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(30) DEFAULT NULL,
  `field` char(30) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`,`field`)
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=utf8;



# Dump of table nanx_activity_js_btns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity_js_btns`;

CREATE TABLE `nanx_activity_js_btns` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(30) NOT NULL DEFAULT '',
  `jsfile` char(40) DEFAULT NULL,
  `btn_name` char(30) DEFAULT NULL,
  `function_name` char(40) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nanx_activity_nofity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity_nofity`;

CREATE TABLE `nanx_activity_nofity` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(30) NOT NULL DEFAULT '' COMMENT '活动代码code',
  `action` char(11) NOT NULL DEFAULT '',
  `receiver_role_list` char(255) DEFAULT NULL,
  `tpl` char(255) DEFAULT NULL,
  `rule_name` char(30) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`,`action`,`receiver_role_list`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='活动注册表格';



# Dump of table nanx_activity_pid_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_activity_pid_order`;

CREATE TABLE `nanx_activity_pid_order` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `activity_code` char(30) NOT NULL DEFAULT '' COMMENT '活动代码code',
  `pid_order` char(4) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `activity_code` (`activity_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='活动注册表格';



# Dump of table nanx_biz_column_editor_cfg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_biz_column_editor_cfg`;

CREATE TABLE `nanx_biz_column_editor_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `base_table` char(100) NOT NULL DEFAULT '',
  `field_e` char(30) NOT NULL DEFAULT '',
  `is_produce_col` tinyint(1) NOT NULL DEFAULT '0',
  `need_img_selector` tinyint(1) DEFAULT '0',
  `edit_as_html` tinyint(1) NOT NULL DEFAULT '0',
  `need_upload` tinyint(1) DEFAULT '0',
  `default_v` char(100) DEFAULT NULL,
  `combo_table` char(100) DEFAULT NULL,
  `list_field` char(100) DEFAULT NULL,
  `value_field` char(100) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

LOCK TABLES `nanx_biz_column_editor_cfg` WRITE;
/*!40000 ALTER TABLE `nanx_biz_column_editor_cfg` DISABLE KEYS */;

INSERT INTO `nanx_biz_column_editor_cfg` (`pid`, `base_table`, `field_e`, `is_produce_col`, `need_img_selector`, `edit_as_html`, `need_upload`, `default_v`, `combo_table`, `list_field`, `value_field`)
VALUES
	(2,'standx_saleinfo','salenum',0,0,0,0,'',NULL,NULL,NULL),
	(3,'standx_saleinfo','sales',0,0,0,0,NULL,'combo_table','list_field','value_field'),
	(4,'standx_saleinfo','prod',0,0,1,0,NULL,NULL,NULL,NULL),
	(5,'standx_prod_list','prod_desc',0,0,1,0,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `nanx_biz_column_editor_cfg` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_biz_column_follow_cfg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_biz_column_follow_cfg`;

CREATE TABLE `nanx_biz_column_follow_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `base_table` char(100) NOT NULL DEFAULT '',
  `field_e` char(30) NOT NULL DEFAULT '',
  `combo_table` char(100) DEFAULT NULL,
  `combo_table_value_field` char(100) DEFAULT NULL,
  `base_table_follow_field` char(100) DEFAULT NULL,
  `combo_table_follow_field` varchar(255) DEFAULT NULL,
  `group_id` char(30) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;



# Dump of table nanx_biz_column_trigger_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_biz_column_trigger_group`;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

LOCK TABLES `nanx_biz_column_trigger_group` WRITE;
/*!40000 ALTER TABLE `nanx_biz_column_trigger_group` DISABLE KEYS */;

INSERT INTO `nanx_biz_column_trigger_group` (`pid`, `base_table`, `field_e`, `combo_table`, `list_field`, `value_field`, `filter_field`, `group_id`, `level`, `group_type`)
VALUES
	(1,'standx_saleinfo','sales','standx_sales','salesname','saleid',NULL,'tzP6nR6n',1,'nogroup'),
	(2,'standx_saleinfo','prod','standx_prod_list','prod_name','prod_code',NULL,'op6m2dF5',1,'nogroup');

/*!40000 ALTER TABLE `nanx_biz_column_trigger_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_biz_tables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_biz_tables`;

CREATE TABLE `nanx_biz_tables` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` char(100) DEFAULT NULL,
  `table_screen_name` char(30) DEFAULT NULL,
  `memo` char(30) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `table_screen_name` (`table_screen_name`),
  UNIQUE KEY `table_name` (`table_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

LOCK TABLES `nanx_biz_tables` WRITE;
/*!40000 ALTER TABLE `nanx_biz_tables` DISABLE KEYS */;

INSERT INTO `nanx_biz_tables` (`pid`, `table_name`, `table_screen_name`, `memo`)
VALUES
	(2,'standx_saleinfo','销售情况',NULL),
	(3,'standx_sales','销售人员',NULL),
	(4,'standx_prod_list','产品列表',NULL);

/*!40000 ALTER TABLE `nanx_biz_tables` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_lang
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_lang`;

CREATE TABLE `nanx_lang` (
  `pid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `id` char(30) DEFAULT NULL,
  `lang_txt` char(100) DEFAULT NULL,
  `active` char(1) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;

LOCK TABLES `nanx_lang` WRITE;
/*!40000 ALTER TABLE `nanx_lang` DISABLE KEYS */;

INSERT INTO `nanx_lang` (`pid`, `id`, `lang_txt`, `active`)
VALUES
	(1,'af','Afrikaans',NULL),
	(2,'sq','Albanian',NULL),
	(3,'ar-dz','Arabic (Algeria)',NULL),
	(4,'ar-bh','Arabic (Bahrain)',NULL),
	(5,'ar-eg','Arabic (Egypt)',NULL),
	(6,'ar-iq','Arabic (Iraq)',NULL),
	(7,'ar-jo','Arabic (Jordan)',NULL),
	(8,'ar-kw','Arabic (Kuwait)',NULL),
	(9,'ar-lb','Arabic (Lebanon)',NULL),
	(10,'ar-ly','Arabic (libya)',NULL),
	(11,'ar-ma','Arabic (Morocco)',NULL),
	(12,'ar-om','Arabic (Oman)',NULL),
	(13,'ar-qa','Arabic (Qatar)',NULL),
	(14,'ar-sa','Arabic (Saudi Arabia)',NULL),
	(15,'ar-sy','Arabic (Syria)',NULL),
	(16,'ar-tn','Arabic (Tunisia)',NULL),
	(17,'ar-ae','Arabic (U.A.E.)',NULL),
	(18,'ar-ye','Arabic (Yemen)',NULL),
	(19,'ar','Arabic',NULL),
	(20,'hy','Armenian',NULL),
	(21,'as','Assamese',NULL),
	(22,'az','Azeri',NULL),
	(23,'eu','Basque',NULL),
	(24,'be','Belarusian',NULL),
	(25,'bn','Bengali',NULL),
	(26,'bg','Bulgarian',NULL),
	(27,'ca','Catalan',NULL),
	(28,'zh-cn','中文','y'),
	(29,'zh-hk','Chinese (Hong Kong)','y'),
	(30,'zh-mo','Chinese (Macau)','n'),
	(31,'zh-sg','Chinese (Singapore)','n'),
	(32,'zh-tw','Chinese (Taiwan)','y'),
	(34,'hr','Croatian',NULL),
	(35,'cs','Czech',NULL),
	(36,'da','Danish',NULL),
	(37,'div','Divehi',NULL),
	(38,'nl-be','Dutch (Belgium)',NULL),
	(39,'nl','Dutch (Netherlands)',NULL),
	(40,'en-au','English (Australia)',NULL),
	(41,'en-bz','English (Belize)',NULL),
	(42,'en-ca','English (Canada)',NULL),
	(43,'en-ie','English (Ireland)',NULL),
	(44,'en-jm','English (Jamaica)',NULL),
	(45,'en-nz','English (New Zealand)',NULL),
	(46,'en-ph','English (Philippines)',NULL),
	(47,'en-za','English (South Africa)',NULL),
	(48,'en-tt','English (Trinidad)',NULL),
	(49,'en-gb','English (United Kingdom)',NULL),
	(50,'en-us','English (United States)',NULL),
	(51,'en-zw','English (Zimbabwe)',NULL),
	(52,'en','English','y'),
	(53,'us','English (United States)',NULL),
	(54,'et','Estonian',NULL),
	(55,'fo','Faeroese',NULL),
	(56,'fa','Farsi',NULL),
	(57,'fi','Finnish',NULL),
	(58,'fr-be','French (Belgium)',NULL),
	(59,'fr-ca','French (Canada)',NULL),
	(60,'fr-lu','French (Luxembourg)',NULL),
	(61,'fr-mc','French (Monaco)',NULL),
	(62,'fr-ch','French (Switzerland)',NULL),
	(63,'fr','French (France)','y'),
	(64,'mk','FYRO Macedonian',NULL),
	(65,'gd','Gaelic',NULL),
	(66,'ka','Georgian',NULL),
	(67,'de-at','German (Austria)',NULL),
	(68,'de-li','German (Liechtenstein)',NULL),
	(69,'de-lu','German (Luxembourg)',NULL),
	(70,'de-ch','German (Switzerland)',NULL),
	(71,'de','German (Germany)','y'),
	(72,'el','Greek',NULL),
	(73,'gu','Gujarati',NULL),
	(74,'he','Hebrew',NULL),
	(75,'hi','Hindi',NULL),
	(76,'hu','Hungarian','y'),
	(77,'is','Icelandic',NULL),
	(78,'id','Indonesian',NULL),
	(79,'it-ch','Italian (Switzerland)',NULL),
	(80,'it','Italian (Italy)','y'),
	(81,'ja','Japanese','y'),
	(82,'kn','Kannada',NULL),
	(83,'kk','Kazakh',NULL),
	(84,'kok','Konkani',NULL),
	(85,'ko','Korean','y'),
	(86,'kz','Kyrgyz',NULL),
	(87,'lv','Latvian',NULL),
	(88,'lt','Lithuanian',NULL),
	(89,'ms','Malay',NULL),
	(90,'ml','Malayalam',NULL),
	(91,'mt','Maltese',NULL),
	(92,'mr','Marathi',NULL),
	(93,'mn','Mongolian (Cyrillic)',NULL),
	(94,'ne','Nepali (India)',NULL),
	(95,'nb-no','Norwegian (Bokmal)',NULL),
	(96,'nn-no','Norwegian (Nynorsk)',NULL),
	(97,'no','Norwegian (Bokmal)',NULL),
	(98,'or','Oriya',NULL),
	(99,'pl','Polish','y'),
	(100,'pt-br','Portuguese (Brazil)',NULL),
	(101,'pt','Portuguese (Portugal)',NULL),
	(102,'pa','Punjabi',NULL),
	(103,'rm','Rhaeto-Romanic',NULL),
	(104,'ro-md','Romanian (Moldova)',NULL),
	(105,'ro','Romanian',NULL),
	(106,'ru-md','Russian (Moldova)',NULL),
	(107,'ru','Russian',NULL),
	(108,'sa','Sanskrit',NULL),
	(109,'sr','Serbian',NULL),
	(110,'sk','Slovak',NULL),
	(111,'ls','Slovenian',NULL),
	(112,'sb','Sorbian',NULL),
	(113,'es-ar','Spanish (Argentina)',NULL),
	(114,'es-bo','Spanish (Bolivia)',NULL),
	(115,'es-cl','Spanish (Chile)',NULL),
	(116,'es-co','Spanish (Colombia)',NULL),
	(117,'es-cr','Spanish (Costa Rica)',NULL),
	(118,'es-do','Spanish (Dominican Republic)',NULL),
	(119,'es-ec','Spanish (Ecuador)',NULL),
	(120,'es-sv','Spanish (El Salvador)',NULL),
	(121,'es-gt','Spanish (Guatemala)',NULL),
	(122,'es-hn','Spanish (Honduras)',NULL),
	(123,'es-mx','Spanish (Mexico)',NULL),
	(124,'es-ni','Spanish (Nicaragua)',NULL),
	(125,'es-pa','Spanish (Panama)',NULL),
	(126,'es-py','Spanish (Paraguay)',NULL),
	(127,'es-pe','Spanish (Peru)',NULL),
	(128,'es-pr','Spanish (Puerto Rico)',NULL),
	(129,'es-us','Spanish (United States)',NULL),
	(130,'es-uy','Spanish (Uruguay)',NULL),
	(131,'es-ve','Spanish (Venezuela)',NULL),
	(132,'es','Spanish (Traditional Sort)',NULL),
	(133,'sx','Sutu',NULL),
	(134,'sw','Swahili',NULL),
	(135,'sv-fi','Swedish (Finland)',NULL),
	(136,'sv','Swedish',NULL),
	(137,'syr','Syriac',NULL),
	(138,'ta','Tamil',NULL),
	(139,'tt','Tatar',NULL),
	(140,'te','Telugu',NULL),
	(141,'th','Thai',NULL),
	(142,'ts','Tsonga',NULL),
	(143,'tn','Tswana',NULL),
	(144,'tr','Turkish',NULL),
	(145,'uk','Ukrainian',NULL),
	(146,'ur','Urdu',NULL),
	(147,'uz','Uzbek',NULL),
	(148,'vi','Vietnamese',NULL),
	(149,'xh','Xhosa',NULL),
	(150,'yi','Yiddish',NULL),
	(151,'zu','Zulu',NULL);

/*!40000 ALTER TABLE `nanx_lang` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_session_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_session_log`;

CREATE TABLE `nanx_session_log` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `action_cmd` char(20) DEFAULT NULL,
  `act_code` char(100) DEFAULT NULL,
  `table` char(100) DEFAULT NULL,
  `pids` varchar(255) DEFAULT NULL,
  `rawdata` text,
  `ts` datetime DEFAULT NULL,
  `old_data` text,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

LOCK TABLES `nanx_session_log` WRITE;
/*!40000 ALTER TABLE `nanx_session_log` DISABLE KEYS */;

INSERT INTO `nanx_session_log` (`pid`, `user`, `action_cmd`, `act_code`, `table`, `pids`, `rawdata`, `ts`, `old_data`)
VALUES
	(1,'管理员[admin]','add','act_standx_sales_1822890602','standx_sales','','saleid:10001,salesname:Alex',NULL,NULL),
	(2,'管理员[admin]','add','act_standx_sales_1822890602','standx_sales','','saleid:1002,salesname:Tom',NULL,NULL),
	(3,'管理员[admin]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:10001,prod:iphone,salenum:100',NULL,NULL),
	(4,'管理员[admin]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:10001,prod:iPad,salenum:120',NULL,NULL),
	(5,'管理员[admin]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:1002,prod:ThinkPad,salenum:20',NULL,NULL),
	(6,'管理员[admin]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:1002,prod:VDX,salenum:120',NULL,NULL),
	(7,'alex[alex]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:alex,prod:ddd,salenum:333',NULL,NULL),
	(8,'alex[alex]','delete','act_standx_saleinfo_1745194825','standx_saleinfo','0:5','0',NULL,'0:[pid:5,sales:alex,prod:ddd,salenum:333]'),
	(9,'alex[alex]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:NULL,prod:666,salenum:6666',NULL,NULL),
	(10,'alex[alex]','delete','act_standx_saleinfo_1745194825','standx_saleinfo','0:5','0',NULL,'0:[pid:5,sales:,prod:666,salenum:6666]'),
	(11,'alex[alex]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:10001,prod:DVD,salenum:200',NULL,NULL),
	(12,'alex[alex]','update','act_standx_saleinfo_1745194825','standx_saleinfo','','pid:6,sales:10001,prod:DVD,salenum:444',NULL,'pid:6,sales:10001,prod:DVD,salenum:200'),
	(13,'管理员[admin]','delete','act_standx_saleinfo_1745194825','standx_saleinfo','0:14','0',NULL,'0:[pid:14,sales:10001,prod:SUN,salenum:100]'),
	(14,'alex[alex]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:1002,salenum:1200,prod:STH',NULL,NULL),
	(15,'alex[alex]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:10001,salenum:200,prod:vvvvv',NULL,NULL),
	(16,'tom[tom]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:1002,salenum:200,prod:tom input<br>',NULL,NULL),
	(17,'tom[tom]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:1002,salenum:200,prod:ddd',NULL,NULL),
	(18,'tom[tom]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:1002,salenum:200,prod:b666',NULL,NULL),
	(19,'alex[alex]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:10001,salenum:200,prod:alexinput',NULL,NULL),
	(20,'alex[alex]','update','act_standx_saleinfo_1745194825','standx_saleinfo','','pid:19,sales:10001,salenum:200,prod:v',NULL,'pid:19,sales:10001,prod:alexinput,salenum:200'),
	(21,'alex[alex]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:10001,salenum:200,prod:12345',NULL,NULL),
	(22,'alex[alex]','add','prod_mnt','standx_prod_list','','prod_name:DVD播放器,prod_code:DVD,prod_desc:NULL',NULL,NULL),
	(23,'alex[alex]','add','prod_mnt','standx_prod_list','','prod_name:MAC Air电脑,prod_code:MAC,prod_desc:NULL',NULL,NULL),
	(24,'alex[alex]','add','prod_mnt','standx_prod_list','','prod_name:iPhone5S手机,prod_code:iPhone5S,prod_desc:NULL',NULL,NULL),
	(25,'alex[alex]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:10001,prod:DVD,salenum:12',NULL,NULL),
	(26,'alex[alex]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:10001,prod:MAC,salenum:14',NULL,NULL),
	(27,'alex[alex]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:10001,prod:MAC,salenum:88',NULL,NULL),
	(28,'tom[tom]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:1002,prod:MAC,salenum:8888',NULL,NULL),
	(29,'tom[tom]','add','act_standx_saleinfo_1745194825','standx_saleinfo','','sales:1002,prod:DVD,salenum:9000',NULL,NULL);

/*!40000 ALTER TABLE `nanx_session_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_shadow
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_shadow`;

CREATE TABLE `nanx_shadow` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT '保留列,请勿删除',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nanx_sms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_sms`;

CREATE TABLE `nanx_sms` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `sender` char(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `receiver` char(20) DEFAULT NULL,
  `msg` varchar(255) DEFAULT NULL,
  `sendtime` datetime DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nanx_system_cfg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_system_cfg`;

CREATE TABLE `nanx_system_cfg` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` char(30) NOT NULL DEFAULT '',
  `config_value` char(100) NOT NULL DEFAULT '',
  `config_memo` varchar(255) DEFAULT '',
  `memo_of_config_item` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

LOCK TABLES `nanx_system_cfg` WRITE;
/*!40000 ALTER TABLE `nanx_system_cfg` DISABLE KEYS */;

INSERT INTO `nanx_system_cfg` (`pid`, `config_key`, `config_value`, `config_memo`, `memo_of_config_item`)
VALUES
	(1,'VER','2.02','系统版 本','Version of system'),
	(2,'BANNER_TITLE','standx','网站左上角标题','Text on  lett-top '),
	(3,'SECRET_KEY','3cd9342dc190','应用加密串','Secret key'),
	(6,'PAGE_TITLE','Brower title/浏览器标题','浏览器标题','Title of Browser'),
	(7,'APP_PREFIX','standx','表格前缀','Prefix of table'),
	(8,'COMPANY_LOGO','nanx_logo.png','企业的logo','Logo on login'),
	(9,'WIN_SIZE_HEIGHT','644','窗口高度(像素为单位)','Default window  height'),
	(10,'WIN_SIZE_WIDTH','800','窗口宽度(像素为单位)','Default window  width'),
	(11,'WIN_SIZE_WIDTH_OPERATION','899','数据修改窗口的宽度(像素为单位))','Default window width on modify data');

/*!40000 ALTER TABLE `nanx_system_cfg` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_user`;

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
  `inner_table` char(100) DEFAULT NULL,
  `inner_table_column` char(11) DEFAULT NULL,
  `inner_table_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='用户表';

LOCK TABLES `nanx_user` WRITE;
/*!40000 ALTER TABLE `nanx_user` DISABLE KEYS */;

INSERT INTO `nanx_user` (`pid`, `user`, `password`, `staff_name`, `active`, `last_login_ts`, `mobile`, `email`, `salt`, `inner_table`, `inner_table_column`, `inner_table_value`)
VALUES
	(1,'admin','372022d41cd4d911995fbf20ff8c098a','管理员','Y','0000-00-00 00:00:00',NULL,NULL,'99932f',NULL,NULL,NULL),
	(2,'alex','d18912629b5260cbb2bbb47300252096','alex','Y','0000-00-00 00:00:00',NULL,NULL,'bdd432','standx_sales','saleid',10001),
	(3,'tom','5cae0e33a5e01b4edaa1366d15ed119f','tom','Y','0000-00-00 00:00:00',NULL,NULL,'758e53',NULL,NULL,NULL);

/*!40000 ALTER TABLE `nanx_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_user_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_user_role`;

CREATE TABLE `nanx_user_role` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `role_code` char(30) NOT NULL DEFAULT '',
  `role_name` char(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `role_code` (`role_code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

LOCK TABLES `nanx_user_role` WRITE;
/*!40000 ALTER TABLE `nanx_user_role` DISABLE KEYS */;

INSERT INTO `nanx_user_role` (`pid`, `role_code`, `role_name`)
VALUES
	(4,'admin','管理员'),
	(5,'sales','sales');

/*!40000 ALTER TABLE `nanx_user_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_user_role_assign
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_user_role_assign`;

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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

LOCK TABLES `nanx_user_role_assign` WRITE;
/*!40000 ALTER TABLE `nanx_user_role_assign` DISABLE KEYS */;

INSERT INTO `nanx_user_role_assign` (`pid`, `user`, `role_code`)
VALUES
	(40,'admin','admin'),
	(41,'alex','sales'),
	(42,'tom','sales');

/*!40000 ALTER TABLE `nanx_user_role_assign` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_user_role_privilege
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_user_role_privilege`;

CREATE TABLE `nanx_user_role_privilege` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `role_code` char(30) DEFAULT NULL,
  `activity_code` char(30) NOT NULL DEFAULT '',
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `role_code` (`role_code`,`activity_code`),
  KEY `activity_code` (`activity_code`),
  CONSTRAINT `nanx_user_role_privilege_ibfk_1` FOREIGN KEY (`activity_code`) REFERENCES `nanx_activity` (`activity_code`),
  CONSTRAINT `nanx_user_role_privilege_ibfk_2` FOREIGN KEY (`role_code`) REFERENCES `nanx_user_role` (`role_code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

LOCK TABLES `nanx_user_role_privilege` WRITE;
/*!40000 ALTER TABLE `nanx_user_role_privilege` DISABLE KEYS */;

INSERT INTO `nanx_user_role_privilege` (`pid`, `role_code`, `activity_code`, `display_order`)
VALUES
	(1,'admin','act_standx_sales_1822890602',NULL),
	(2,'admin','act_standx_saleinfo_1745194825',NULL),
	(3,'sales','act_standx_saleinfo_1745194825',NULL),
	(4,'admin','prod_mnt',NULL),
	(5,'sales','prod_mnt',NULL);

/*!40000 ALTER TABLE `nanx_user_role_privilege` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nanx_who_is_who
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nanx_who_is_who`;

CREATE TABLE `nanx_who_is_who` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` char(30) DEFAULT NULL,
  `inner_table` char(30) DEFAULT NULL,
  `inner_table_pid` int(11) DEFAULT NULL,
  `inner_table_value_field` char(100) DEFAULT NULL,
  `inner_table_value` char(100) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pk_whoiswho` (`inner_table`,`inner_table_pid`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

LOCK TABLES `nanx_who_is_who` WRITE;
/*!40000 ALTER TABLE `nanx_who_is_who` DISABLE KEYS */;

INSERT INTO `nanx_who_is_who` (`pid`, `user`, `inner_table`, `inner_table_pid`, `inner_table_value_field`, `inner_table_value`)
VALUES
	(35,'alex','standx_sales',1,'saleid','10001'),
	(36,'tom','standx_sales',2,'saleid','1002');

/*!40000 ALTER TABLE `nanx_who_is_who` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pbcatcol
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pbcatcol`;

CREATE TABLE `pbcatcol` (
  `pbc_tnam` char(193) NOT NULL,
  `pbc_tid` int(11) DEFAULT NULL,
  `pbc_ownr` char(193) NOT NULL,
  `pbc_cnam` char(193) NOT NULL,
  `pbc_cid` smallint(6) DEFAULT NULL,
  `pbc_labl` varchar(254) DEFAULT NULL,
  `pbc_lpos` smallint(6) DEFAULT NULL,
  `pbc_hdr` varchar(254) DEFAULT NULL,
  `pbc_hpos` smallint(6) DEFAULT NULL,
  `pbc_jtfy` smallint(6) DEFAULT NULL,
  `pbc_mask` varchar(31) DEFAULT NULL,
  `pbc_case` smallint(6) DEFAULT NULL,
  `pbc_hght` smallint(6) DEFAULT NULL,
  `pbc_wdth` smallint(6) DEFAULT NULL,
  `pbc_ptrn` varchar(31) DEFAULT NULL,
  `pbc_bmap` char(1) DEFAULT NULL,
  `pbc_init` varchar(254) DEFAULT NULL,
  `pbc_cmnt` varchar(254) DEFAULT NULL,
  `pbc_edit` varchar(31) DEFAULT NULL,
  `pbc_tag` varchar(254) DEFAULT NULL,
  UNIQUE KEY `pbcatc_x` (`pbc_tnam`,`pbc_ownr`,`pbc_cnam`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pbcatedt
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pbcatedt`;

CREATE TABLE `pbcatedt` (
  `pbe_name` varchar(30) NOT NULL,
  `pbe_edit` varchar(254) DEFAULT NULL,
  `pbe_type` smallint(6) DEFAULT NULL,
  `pbe_cntr` int(11) DEFAULT NULL,
  `pbe_seqn` smallint(6) NOT NULL,
  `pbe_flag` int(11) DEFAULT NULL,
  `pbe_work` char(32) DEFAULT NULL,
  UNIQUE KEY `pbcate_x` (`pbe_name`,`pbe_seqn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `pbcatedt` WRITE;
/*!40000 ALTER TABLE `pbcatedt` DISABLE KEYS */;

INSERT INTO `pbcatedt` (`pbe_name`, `pbe_edit`, `pbe_type`, `pbe_cntr`, `pbe_seqn`, `pbe_flag`, `pbe_work`)
VALUES
	('#####','#####',90,1,1,32,'10'),
	('###,###.00','###,###.00',90,1,1,32,'10'),
	('###-##-####','###-##-####',90,1,1,32,'00'),
	('DD/MM/YY','DD/MM/YY',90,1,1,32,'20'),
	('DD/MM/YY HH:MM:SS','DD/MM/YY HH:MM:SS',90,1,1,32,'40'),
	('DD/MM/YY HH:MM:SS:FFFFFF','DD/MM/YY HH:MM:SS:FFFFFF',90,1,1,32,'40'),
	('DD/MM/YYYY','DD/MM/YYYY',90,1,1,32,'20'),
	('DD/MM/YYYY HH:MM:SS','DD/MM/YYYY HH:MM:SS',90,1,1,32,'40'),
	('DD/MMM/YY','DD/MMM/YY',90,1,1,32,'20'),
	('DD/MMM/YY HH:MM:SS','DD/MMM/YY HH:MM:SS',90,1,1,32,'40'),
	('DDD/YY','DDD/YY',90,1,1,32,'20'),
	('DDD/YY HH:MM:SS','DDD/YY HH:MM:SS',90,1,1,32,'40'),
	('DDD/YYYY','DDD/YYYY',90,1,1,32,'20'),
	('DDD/YYYY HH:MM:SS','DDD/YYYY HH:MM:SS',90,1,1,32,'40'),
	('HH:MM:SS','HH:MM:SS',90,1,1,32,'30'),
	('HH:MM:SS:FFF','HH:MM:SS:FFF',90,1,1,32,'30'),
	('HH:MM:SS:FFFFFF','HH:MM:SS:FFFFFF',90,1,1,32,'30'),
	('MM/DD/YY','MM/DD/YY',90,1,1,32,'20'),
	('MM/DD/YY HH:MM:SS','MM/DD/YY HH:MM:SS',90,1,1,32,'40'),
	('MM/DD/YYYY','MM/DD/YYYY',90,1,1,32,'20'),
	('MM/DD/YYYY HH:MM:SS','MM/DD/YYYY HH:MM:SS',90,1,1,32,'40');

/*!40000 ALTER TABLE `pbcatedt` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pbcatfmt
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pbcatfmt`;

CREATE TABLE `pbcatfmt` (
  `pbf_name` varchar(30) NOT NULL,
  `pbf_frmt` varchar(254) DEFAULT NULL,
  `pbf_type` smallint(6) DEFAULT NULL,
  `pbf_cntr` int(11) DEFAULT NULL,
  UNIQUE KEY `pbcatf_x` (`pbf_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `pbcatfmt` WRITE;
/*!40000 ALTER TABLE `pbcatfmt` DISABLE KEYS */;

INSERT INTO `pbcatfmt` (`pbf_name`, `pbf_frmt`, `pbf_type`, `pbf_cntr`)
VALUES
	('#,##0','#,##0',81,0),
	('#,##0.00','#,##0.00',81,0),
	('0','0',81,0),
	('0%','0%',81,0),
	('0.00','0.00',81,0),
	('0.00%','0.00%',81,0),
	('0.00E+00','0.00E+00',81,0),
	('d-mmm','d-mmm',84,0),
	('d-mmm-yy','d-mmm-yy',84,0),
	('h:mm AM/PM','h:mm AM/PM',84,0),
	('h:mm:ss','h:mm:ss',84,0),
	('h:mm:ss AM/PM','h:mm:ss AM/PM',84,0),
	('m/d/yy','m/d/yy',84,0),
	('m/d/yy h:mm','m/d/yy h:mm',84,0),
	('mmm-yy','mmm-yy',84,0),
	('[General]','[General]',81,0);

/*!40000 ALTER TABLE `pbcatfmt` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pbcattbl
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pbcattbl`;

CREATE TABLE `pbcattbl` (
  `pbt_tnam` char(193) NOT NULL,
  `pbt_tid` int(11) DEFAULT NULL,
  `pbt_ownr` char(193) NOT NULL,
  `pbd_fhgt` smallint(6) DEFAULT NULL,
  `pbd_fwgt` smallint(6) DEFAULT NULL,
  `pbd_fitl` char(1) DEFAULT NULL,
  `pbd_funl` char(1) DEFAULT NULL,
  `pbd_fchr` smallint(6) DEFAULT NULL,
  `pbd_fptc` smallint(6) DEFAULT NULL,
  `pbd_ffce` char(18) DEFAULT NULL,
  `pbh_fhgt` smallint(6) DEFAULT NULL,
  `pbh_fwgt` smallint(6) DEFAULT NULL,
  `pbh_fitl` char(1) DEFAULT NULL,
  `pbh_funl` char(1) DEFAULT NULL,
  `pbh_fchr` smallint(6) DEFAULT NULL,
  `pbh_fptc` smallint(6) DEFAULT NULL,
  `pbh_ffce` char(18) DEFAULT NULL,
  `pbl_fhgt` smallint(6) DEFAULT NULL,
  `pbl_fwgt` smallint(6) DEFAULT NULL,
  `pbl_fitl` char(1) DEFAULT NULL,
  `pbl_funl` char(1) DEFAULT NULL,
  `pbl_fchr` smallint(6) DEFAULT NULL,
  `pbl_fptc` smallint(6) DEFAULT NULL,
  `pbl_ffce` char(18) DEFAULT NULL,
  `pbt_cmnt` varchar(254) DEFAULT NULL,
  UNIQUE KEY `pbcatt_x` (`pbt_tnam`,`pbt_ownr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pbcatvld
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pbcatvld`;

CREATE TABLE `pbcatvld` (
  `pbv_name` varchar(30) NOT NULL,
  `pbv_vald` varchar(254) DEFAULT NULL,
  `pbv_type` smallint(6) DEFAULT NULL,
  `pbv_cntr` int(11) DEFAULT NULL,
  `pbv_msg` varchar(254) DEFAULT NULL,
  UNIQUE KEY `pbcatv_x` (`pbv_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table standx_prod_list
# ------------------------------------------------------------

DROP TABLE IF EXISTS `standx_prod_list`;

CREATE TABLE `standx_prod_list` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT '保留列,请勿删除',
  `prod_name` char(20) DEFAULT NULL,
  `prod_desc` char(1) DEFAULT NULL,
  `prod_code` char(20) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `standx_prod_list` WRITE;
/*!40000 ALTER TABLE `standx_prod_list` DISABLE KEYS */;

INSERT INTO `standx_prod_list` (`pid`, `prod_name`, `prod_desc`, `prod_code`)
VALUES
	(1,'DVD播放器','','DVD'),
	(2,'MAC Air电脑','','MAC'),
	(3,'iPhone5S手机','','iPhone5S');

/*!40000 ALTER TABLE `standx_prod_list` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table standx_saleinfo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `standx_saleinfo`;

CREATE TABLE `standx_saleinfo` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT '保留列,请勿删除',
  `sales` char(10) DEFAULT NULL,
  `prod` char(10) DEFAULT NULL,
  `salenum` int(12) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

LOCK TABLES `standx_saleinfo` WRITE;
/*!40000 ALTER TABLE `standx_saleinfo` DISABLE KEYS */;

INSERT INTO `standx_saleinfo` (`pid`, `sales`, `prod`, `salenum`)
VALUES
	(21,'10001','DVD',12),
	(22,'10001','MAC',14),
	(23,'10001','MAC',88),
	(24,'1002','MAC',8888),
	(25,'1002','DVD',9000);

/*!40000 ALTER TABLE `standx_saleinfo` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table standx_sales
# ------------------------------------------------------------

DROP TABLE IF EXISTS `standx_sales`;

CREATE TABLE `standx_sales` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT '保留列,请勿删除',
  `saleid` int(22) DEFAULT NULL,
  `salesname` char(20) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `standx_sales` WRITE;
/*!40000 ALTER TABLE `standx_sales` DISABLE KEYS */;

INSERT INTO `standx_sales` (`pid`, `saleid`, `salesname`)
VALUES
	(1,10001,'Alex'),
	(2,1002,'Tom');

/*!40000 ALTER TABLE `standx_sales` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
