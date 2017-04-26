-- MySQL dump 10.13  Distrib 5.5.53, for Win32 (AMD64)
--
-- Host: localhost    Database: shop
-- ------------------------------------------------------
-- Server version	5.5.53-log

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
-- Table structure for table `aq_address`
--

DROP TABLE IF EXISTS `aq_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_address` (
  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '地址编号',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地址所属用户ID',
  `consignee` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `province` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '省份，保存是ID',
  `city` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '市',
  `district` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `street` varchar(100) NOT NULL DEFAULT '' COMMENT '街道地址',
  `zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '邮政编码',
  `telephone` varchar(20) NOT NULL DEFAULT '' COMMENT '电话',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '移动电话',
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_address`
--

LOCK TABLES `aq_address` WRITE;
/*!40000 ALTER TABLE `aq_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `aq_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_admin`
--

DROP TABLE IF EXISTS `aq_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_admin` (
  `admin_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `admin_name` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_admin`
--

LOCK TABLES `aq_admin` WRITE;
/*!40000 ALTER TABLE `aq_admin` DISABLE KEYS */;
INSERT INTO `aq_admin` VALUES (1,'admin','202cb962ac59075b964b07152d234b70','admin@qq.cn',0);
/*!40000 ALTER TABLE `aq_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_attribute`
--

DROP TABLE IF EXISTS `aq_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_attribute` (
  `attr_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品属性ID',
  `attr_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品属性名称',
  `type_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '商品属性所属类型ID',
  `attr_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性是否可选 0 为唯一，1为单选，2为多选',
  `attr_input_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性录入方式 0为手工录入，1为从列表中选择，2为文本域',
  `attr_value` text COMMENT '属性的值',
  `sort_order` tinyint(4) NOT NULL DEFAULT '50' COMMENT '属性排序依据',
  PRIMARY KEY (`attr_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_attribute`
--

LOCK TABLES `aq_attribute` WRITE;
/*!40000 ALTER TABLE `aq_attribute` DISABLE KEYS */;
INSERT INTO `aq_attribute` VALUES (1,'白色',1,2,2,'',50),(2,'5.15寸',2,2,2,'',50);
/*!40000 ALTER TABLE `aq_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_brand`
--

DROP TABLE IF EXISTS `aq_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_brand` (
  `brand_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品品牌ID',
  `brand_name` varchar(30) NOT NULL DEFAULT '' COMMENT '商品品牌名称',
  `brand_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '商品品牌描述',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '商品品牌网址',
  `logo` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌logo',
  `smalllogo` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌logo缩略图',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '50' COMMENT '商品品牌排序依据',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示，默认显示',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_brand`
--

LOCK TABLES `aq_brand` WRITE;
/*!40000 ALTER TABLE `aq_brand` DISABLE KEYS */;
INSERT INTO `aq_brand` VALUES (1,'小米','手机','http://www.mi.com/','20170417/2017041718504758f49e0714096.jpg','./public/uploads/20170417/2017041718504758f49e0714',50,1),(2,'无印良品','男装','http://www.muji.com.cn/','20170417/2017041718553858f49f2a6e498.jpg','./public/uploads/20170417/2017041718553858f49f2a6e',50,1),(3,'海澜之家','男装','http://www.heilanhome.com/','20170417/2017041719001058f4a03a9a5f0.jpg','./public/uploads/20170417/2017041719001058f4a03a9a',50,1);
/*!40000 ALTER TABLE `aq_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_cart`
--

DROP TABLE IF EXISTS `aq_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_cart` (
  `cart_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_img` varchar(50) NOT NULL DEFAULT '' COMMENT '商品图片',
  `goods_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '商品数量',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成交价格',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '小计',
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_cart`
--

LOCK TABLES `aq_cart` WRITE;
/*!40000 ALTER TABLE `aq_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `aq_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_category`
--

DROP TABLE IF EXISTS `aq_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_category` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类别ID',
  `cat_name` varchar(30) NOT NULL DEFAULT '' COMMENT '商品类别名称',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类别父ID',
  `cat_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '商品类别描述',
  `sort_order` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序依据',
  `unit` varchar(15) NOT NULL DEFAULT '' COMMENT '单位',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示，默认显示',
  PRIMARY KEY (`cat_id`),
  KEY `pid` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_category`
--

LOCK TABLES `aq_category` WRITE;
/*!40000 ALTER TABLE `aq_category` DISABLE KEYS */;
INSERT INTO `aq_category` VALUES (1,'家用电器',0,'顶级分类 。',50,'件',1),(2,'手机/运营商',0,'手机。',50,'件',1),(3,'电脑/办公',0,'办公',50,'件',1),(4,'家居/家居/家装/厨具',0,'家用',50,'件',1),(5,'男装/女装/童装/内衣',0,'衣服',50,'件',1),(6,'美妆个护/宠物',0,'化妆',50,'件',1),(7,'女鞋/箱包/珠宝',0,'奢侈品',50,'个',1),(8,'男鞋/运动/户外',0,'运动',50,'个',1),(9,'汽车/汽车用品',0,'汽车',50,'辆',1),(10,'食品/酒类',0,'吃的',50,'件',1),(11,'图书',0,'书',50,'本',1),(12,'电视',1,'电视',50,'台',1),(13,'手机',2,'手机',50,'',1),(14,'厨具',4,'厨具',50,'',1),(15,'男装',5,'男装',50,'',1),(16,'女装',5,'女装',50,'',1),(17,'POLO衫',15,'Polo',50,'',1),(18,'奢侈品',7,'奢侈',50,'',1);
/*!40000 ALTER TABLE `aq_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_galary`
--

DROP TABLE IF EXISTS `aq_galary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_galary` (
  `img_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片编号',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `img_url` varchar(50) NOT NULL DEFAULT '' COMMENT '图片URL',
  `thumb_url` varchar(50) NOT NULL DEFAULT '' COMMENT '缩略图URL',
  `img_desc` varchar(50) NOT NULL DEFAULT '' COMMENT '图片描述',
  PRIMARY KEY (`img_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_galary`
--

LOCK TABLES `aq_galary` WRITE;
/*!40000 ALTER TABLE `aq_galary` DISABLE KEYS */;
/*!40000 ALTER TABLE `aq_galary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_goods`
--

DROP TABLE IF EXISTS `aq_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `goods_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '商品货号',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_brief` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简单描述',
  `goods_desc` text COMMENT '商品详情',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属类别ID',
  `brand_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属品牌ID',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '本店价格',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `promote_start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销起始时间',
  `promote_end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销截止时间',
  `goods_img` varchar(50) NOT NULL DEFAULT '' COMMENT '商品图片',
  `goods_thumb` varchar(50) NOT NULL DEFAULT '' COMMENT '商品缩略图',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型ID',
  `is_promote` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否促销，默认为0不促销',
  `is_best` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否精品,默认为0',
  `is_new` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否新品，默认为0',
  `is_hot` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否热卖,默认为0',
  `is_onsale` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架,默认为1',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`goods_id`),
  KEY `cat_id` (`cat_id`),
  KEY `brand_id` (`brand_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_goods`
--

LOCK TABLES `aq_goods` WRITE;
/*!40000 ALTER TABLE `aq_goods` DISABLE KEYS */;
INSERT INTO `aq_goods` VALUES (1,'ECS000032','小米4','','<p>掏出来搞事情</p>',13,1,3612.00,3010.00,0.00,1243785600,1417276800,'20170418/2017041802061258f50414094ae.jpg','',4,0,1,0,1,1,0,1,1492452372),(2,'ECS000034','HLA海澜之家趣味印花polo衫','','<p>&nbsp;polo衫</p>',17,3,222.00,245.00,0.00,1243785600,1417276800,'20170418/2017041802094058f504e4cfa1c.jpg','',4,0,3,0,1,1,0,1,1492452580),(3,'ECS045单独删掉','polo衫','','<p>&nbsp;添加商品属性</p>',17,2,3612.00,3010.00,0.00,1243785600,1417276800,'20170418/2017041802141958f505fb6bca9.jpg','',4,0,1,0,1,1,0,1,1492452859);
/*!40000 ALTER TABLE `aq_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_goods_attr`
--

DROP TABLE IF EXISTS `aq_goods_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_goods_attr` (
  `goods_attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `attr_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '属性ID',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
  `attr_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '属性价格',
  PRIMARY KEY (`goods_attr_id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_goods_attr`
--

LOCK TABLES `aq_goods_attr` WRITE;
/*!40000 ALTER TABLE `aq_goods_attr` DISABLE KEYS */;
INSERT INTO `aq_goods_attr` VALUES (1,3,1,'纯白',0.00);
/*!40000 ALTER TABLE `aq_goods_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_goods_type`
--

DROP TABLE IF EXISTS `aq_goods_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_goods_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类型ID',
  `type_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品类型名称',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_goods_type`
--

LOCK TABLES `aq_goods_type` WRITE;
/*!40000 ALTER TABLE `aq_goods_type` DISABLE KEYS */;
INSERT INTO `aq_goods_type` VALUES (1,'颜色'),(2,'屏幕尺寸'),(3,'布料'),(4,'产地');
/*!40000 ALTER TABLE `aq_goods_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_message`
--

DROP TABLE IF EXISTS `aq_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg` text,
  `sender` varchar(32) NOT NULL DEFAULT '游客',
  `receiver` varchar(32) NOT NULL DEFAULT '所有人',
  `color` char(7) NOT NULL DEFAULT '',
  `biaoqing` varchar(32) NOT NULL DEFAULT '',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_message`
--

LOCK TABLES `aq_message` WRITE;
/*!40000 ALTER TABLE `aq_message` DISABLE KEYS */;
INSERT INTO `aq_message` VALUES (1,'大家好\r\n','游客','所有人','','','2017-04-17 17:38:11');
/*!40000 ALTER TABLE `aq_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_order`
--

DROP TABLE IF EXISTS `aq_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '订单号',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `address_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址id',
  `order_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态 1 待付款 2 待发货 3 已发货 4 已完成',
  `postscripts` varchar(255) NOT NULL DEFAULT '' COMMENT '订单附言',
  `shipping_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '送货方式ID',
  `pay_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付方式ID',
  `goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总金额',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `order_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `address_id` (`address_id`),
  KEY `pay_id` (`pay_id`),
  KEY `shipping_id` (`shipping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_order`
--

LOCK TABLES `aq_order` WRITE;
/*!40000 ALTER TABLE `aq_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `aq_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_order_goods`
--

DROP TABLE IF EXISTS `aq_order_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_order_goods` (
  `rec_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_img` varchar(50) NOT NULL DEFAULT '' COMMENT '商品图片',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成交价格',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '购买数量',
  `goods_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品小计',
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_order_goods`
--

LOCK TABLES `aq_order_goods` WRITE;
/*!40000 ALTER TABLE `aq_order_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `aq_order_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_payment`
--

DROP TABLE IF EXISTS `aq_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_payment` (
  `pay_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '支付方式ID',
  `pay_name` varchar(30) NOT NULL DEFAULT '' COMMENT '支付方式名称',
  `pay_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '支付方式描述',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用，默认启用',
  PRIMARY KEY (`pay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_payment`
--

LOCK TABLES `aq_payment` WRITE;
/*!40000 ALTER TABLE `aq_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `aq_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_region`
--

DROP TABLE IF EXISTS `aq_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_region` (
  `region_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '地区ID',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `region_name` varchar(30) NOT NULL DEFAULT '' COMMENT '地区名称',
  `region_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '地区类型 1 省份 2 市 3 区(县)',
  PRIMARY KEY (`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_region`
--

LOCK TABLES `aq_region` WRITE;
/*!40000 ALTER TABLE `aq_region` DISABLE KEYS */;
/*!40000 ALTER TABLE `aq_region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_shipping`
--

DROP TABLE IF EXISTS `aq_shipping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_shipping` (
  `shipping_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `shipping_name` varchar(30) NOT NULL DEFAULT '' COMMENT '送货方式名称',
  `shipping_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '送货方式描述',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '送货费用',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用，默认启用',
  PRIMARY KEY (`shipping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_shipping`
--

LOCK TABLES `aq_shipping` WRITE;
/*!40000 ALTER TABLE `aq_shipping` DISABLE KEYS */;
/*!40000 ALTER TABLE `aq_shipping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aq_user`
--

DROP TABLE IF EXISTS `aq_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aq_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户密码,md5加密',
  `user_ip` varchar(10) NOT NULL COMMENT '用户ip',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户注册时间',
  PRIMARY KEY (`user_id`),

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aq_user`
--

LOCK TABLES `aq_user` WRITE;
/*!40000 ALTER TABLE `aq_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `aq_user` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `aq_user_info`;
create table aq_user_info(
   user_info_id int unsigned auto_increment,
   age tinyint unsigned,
   edu enum('小学','中学','大学','硕士','博士'),
   hobby set('排球','篮球','足球','橄榄球','棒球','乒乓球'),
   area enum('东北','华北','西北','华东','华南','华西'),
   user_id int unsigned not null default '0' comment '用户id',
   FOREIGN KEY (user_id) REFERENCES aq_user(user_id),
   primary key (user_info_id),
   unique key (user_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-18  3:47:27
