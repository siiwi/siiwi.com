-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        10.0.15-MariaDB - mariadb.org binary distribution
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出 siiwi 的数据库结构
DROP DATABASE IF EXISTS `siiwi`;
CREATE DATABASE IF NOT EXISTS `siiwi` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `siiwi`;


-- 导出  表 siiwi.si_global_language 结构
DROP TABLE IF EXISTS `si_global_language`;
CREATE TABLE IF NOT EXISTS `si_global_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `image` varchar(64) NOT NULL,
  `directory` varchar(32) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 正在导出表  siiwi.si_global_language 的数据：0 rows
DELETE FROM `si_global_language`;
/*!40000 ALTER TABLE `si_global_language` DISABLE KEYS */;
INSERT INTO `si_global_language` (`language_id`, `name`, `code`, `locale`, `image`, `directory`, `sort_order`, `status`) VALUES
	(1, 'English', 'en', 'en_US.UTF-8,en-US,en-gb,english', 'en.png', 'English', 1, 1);
/*!40000 ALTER TABLE `si_global_language` ENABLE KEYS */;


-- 导出  表 siiwi.si_global_service 结构
DROP TABLE IF EXISTS `si_global_service`;
CREATE TABLE IF NOT EXISTS `si_global_service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '服务ID',
  `service_name` varchar(50) NOT NULL COMMENT '服务名称',
  `service_key` varchar(50) NOT NULL COMMENT 'key',
  `service_secret` varchar(50) NOT NULL COMMENT 'secret',
  `service_status` tinyint(1) NOT NULL COMMENT '服务状态（0-不可以，1-可用）',
  PRIMARY KEY (`service_id`),
  UNIQUE KEY `service_key` (`service_key`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 正在导出表  siiwi.si_global_service 的数据：1 rows
DELETE FROM `si_global_service`;
/*!40000 ALTER TABLE `si_global_service` DISABLE KEYS */;
INSERT INTO `si_global_service` (`service_id`, `service_name`, `service_key`, `service_secret`, `service_status`) VALUES
	(1, '主站', '1357876052594', '9fdfdb04df2c2659c6179874482', 1);
/*!40000 ALTER TABLE `si_global_service` ENABLE KEYS */;


-- 导出  表 siiwi.si_user 结构
DROP TABLE IF EXISTS `si_user`;
CREATE TABLE IF NOT EXISTS `si_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `user_name` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户名称',
  `user_role_id` int(11) NOT NULL DEFAULT '1' COMMENT '角色ID（1-注册用户，2-添加用户）',
  `user_store_id` int(11) NOT NULL COMMENT '店铺ID',
  `user_group_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `user_parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户父级ID',
  `user_email` varchar(50) NOT NULL COMMENT '用户电邮',
  `user_password` varchar(50) NOT NULL COMMENT '用户密码',
  `salt` varchar(10) NOT NULL COMMENT '混淆码',
  `user_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态（0-不可以，2-可用）',
  `add_timestamp` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- 正在导出表  siiwi.si_user 的数据：3 rows
DELETE FROM `si_user`;
/*!40000 ALTER TABLE `si_user` DISABLE KEYS */;
INSERT INTO `si_user` (`user_id`, `user_name`, `user_role_id`, `user_store_id`, `user_group_id`, `user_parent_id`, `user_email`, `user_password`, `salt`, `user_status`, `add_timestamp`) VALUES
	(1, 'test', 1, 0, 0, 0, 'test@siiwi.com', '4779690461f45502d245db0161cf3540', '7f85d7', 1, 1443101837),
	(2, 'order', 2, 1, 1, 1, 'order@siiwi.com', '95b319ff819d111080604a3c8b9c5371', '5bfd28', 1, 1443101837),
	(3, 'account', 1, 2, 5, 1, 'account@siiwi.com', '88b75d43018fbabf28c0551d0078df56', '579fec', 1, 1443101837);
/*!40000 ALTER TABLE `si_user` ENABLE KEYS */;


-- 导出  表 siiwi.si_user_category 结构
DROP TABLE IF EXISTS `si_user_category`;
CREATE TABLE IF NOT EXISTS `si_user_category` (
  `user_category_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `user_category_name` varchar(50) NOT NULL COMMENT '分类名称',
  `user_category_type` tinyint(1) NOT NULL COMMENT '分类类别（0-系统分类，1-自定义分类）',
  `user_category_parent_id` int(11) NOT NULL COMMENT '父级分类ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `user_store_id` int(11) NOT NULL COMMENT '店铺ID',
  `user_category_desc` text NOT NULL COMMENT '分类描述',
  `user_category_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '分类状态（0-不可用，1-可用）',
  `add_timestamp` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`user_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='产品类别';

-- 正在导出表  siiwi.si_user_category 的数据：13 rows
DELETE FROM `si_user_category`;
/*!40000 ALTER TABLE `si_user_category` DISABLE KEYS */;
INSERT INTO `si_user_category` (`user_category_id`, `user_category_name`, `user_category_type`, `user_category_parent_id`, `user_id`, `user_store_id`, `user_category_desc`, `user_category_status`, `add_timestamp`) VALUES
	(1, '服装', 0, 0, 0, 0, '', 1, 0),
	(2, '鞋靴', 0, 0, 0, 0, '', 1, 0),
	(3, '箱包', 0, 0, 0, 0, '', 1, 0),
	(4, '美妆', 0, 0, 0, 0, '', 1, 0),
	(5, '数码', 0, 0, 0, 0, '', 1, 0),
	(6, '建材', 0, 0, 0, 0, '', 1, 0),
	(7, '家居', 0, 0, 0, 0, '', 1, 0),
	(8, '百货', 0, 0, 0, 0, '', 1, 0),
	(9, '食品', 0, 0, 0, 0, '', 1, 0),
	(10, '美妆', 0, 0, 0, 0, '', 1, 0),
	(11, '连衣裙', 1, 1, 1, 1, '', 1, 1443101328),
	(12, 'T恤', 1, 1, 1, 1, '', 1, 1443101328),
	(13, '风衣', 1, 1, 1, 2, '', 1, 1443101328);
/*!40000 ALTER TABLE `si_user_category` ENABLE KEYS */;


-- 导出  表 siiwi.si_user_category_attribute 结构
DROP TABLE IF EXISTS `si_user_category_attribute`;
CREATE TABLE IF NOT EXISTS `si_user_category_attribute` (
  `user_category_attribute_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '属性ID',
  `user_category_attribute_name` varchar(50) NOT NULL COMMENT '属性名称',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `user_store_id` int(11) NOT NULL COMMENT '店铺ID',
  `user_category_id` int(11) NOT NULL COMMENT '分类ID',
  `user_category_attribute_desc` text NOT NULL COMMENT '属性描述',
  `user_category_attribute_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '属性状态（0-不可以，1-可用）',
  `add_timestamp` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`user_category_attribute_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='类别属性';

-- 正在导出表  siiwi.si_user_category_attribute 的数据：4 rows
DELETE FROM `si_user_category_attribute`;
/*!40000 ALTER TABLE `si_user_category_attribute` DISABLE KEYS */;
INSERT INTO `si_user_category_attribute` (`user_category_attribute_id`, `user_category_attribute_name`, `user_id`, `user_store_id`, `user_category_id`, `user_category_attribute_desc`, `user_category_attribute_status`, `add_timestamp`) VALUES
	(1, '颜色', 1, 1, 11, '', 1, 1443101512),
	(2, '尺寸', 1, 1, 11, '', 1, 1443101512),
	(3, '颜色', 1, 2, 13, '', 1, 1443101512),
	(4, '尺码', 1, 2, 13, '', 1, 1443101512);
/*!40000 ALTER TABLE `si_user_category_attribute` ENABLE KEYS */;


-- 导出  表 siiwi.si_user_group 结构
DROP TABLE IF EXISTS `si_user_group`;
CREATE TABLE IF NOT EXISTS `si_user_group` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `user_store_id` int(11) NOT NULL COMMENT '店铺ID',
  `user_group_name` varchar(50) NOT NULL COMMENT '用户组名称',
  `user_group_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态（0-不可以，1-可用）',
  `add_timestamp` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`user_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- 正在导出表  siiwi.si_user_group 的数据：5 rows
DELETE FROM `si_user_group`;
/*!40000 ALTER TABLE `si_user_group` DISABLE KEYS */;
INSERT INTO `si_user_group` (`user_group_id`, `user_id`, `user_store_id`, `user_group_name`, `user_group_status`, `add_timestamp`) VALUES
	(1, 1, 1, '订单组', 1, 1443100582),
	(2, 1, 1, '财务组', 1, 1443100606),
	(3, 1, 2, '订单组', 1, 1443100629),
	(4, 1, 2, '物流租', 1, 1443100660),
	(5, 1, 2, '财务组', 1, 1443100689);
/*!40000 ALTER TABLE `si_user_group` ENABLE KEYS */;


-- 导出  表 siiwi.si_user_product_brand 结构
DROP TABLE IF EXISTS `si_user_product_brand`;
CREATE TABLE IF NOT EXISTS `si_user_product_brand` (
  `user_product_brand_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '品牌ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `user_store_id` int(11) NOT NULL COMMENT '店铺ID',
  `user_product_brand_name` varchar(50) NOT NULL COMMENT '品牌名称',
  `user_product_brand_logo` varchar(80) NOT NULL COMMENT '品牌logo',
  `user_product_brand_desc` text NOT NULL COMMENT '品牌描述',
  `user_product_brand_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '品牌状态（0-可用，1-不可用）',
  `add_timestamp` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`user_product_brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='产品品牌列表';

-- 正在导出表  siiwi.si_user_product_brand 的数据：2 rows
DELETE FROM `si_user_product_brand`;
/*!40000 ALTER TABLE `si_user_product_brand` DISABLE KEYS */;
INSERT INTO `si_user_product_brand` (`user_product_brand_id`, `user_id`, `user_store_id`, `user_product_brand_name`, `user_product_brand_logo`, `user_product_brand_desc`, `user_product_brand_status`, `add_timestamp`) VALUES
	(1, 1, 1, '韩都衣舍', 'https://gdp.alicdn.com/imgextra/i1/263817957/TB2q_06fpXXXXcGXXXXXXXXXXXX-2638179', '', 1, 1443100841),
	(2, 1, 2, '梵菲', 'https://g-search1.alicdn.com/img/bao/uploaded/i4/4d/27/TB1AC1jGVXXXXXvXVXXwu0bFX', '', 1, 1443100957);
/*!40000 ALTER TABLE `si_user_product_brand` ENABLE KEYS */;


-- 导出  表 siiwi.si_user_store 结构
DROP TABLE IF EXISTS `si_user_store`;
CREATE TABLE IF NOT EXISTS `si_user_store` (
  `user_store_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '店铺ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `user_store_name` varchar(50) NOT NULL COMMENT '店铺名称',
  `user_store_desc` text NOT NULL COMMENT '店铺描述',
  `user_store_status` tinyint(1) NOT NULL COMMENT '店铺状态（0-不可以，1-可用）',
  `add_timestamp` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`user_store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户下所属店铺列表';

-- 正在导出表  siiwi.si_user_store 的数据：2 rows
DELETE FROM `si_user_store`;
/*!40000 ALTER TABLE `si_user_store` DISABLE KEYS */;
INSERT INTO `si_user_store` (`user_store_id`, `user_id`, `user_store_name`, `user_store_desc`, `user_store_status`, `add_timestamp`) VALUES
	(1, 1, '韩都衣舍旗舰店', '韩都衣舍旗舰店', 1, 1443100383),
	(2, 1, '梵菲设计师原创', 'DIY', 1, 1443100509);
/*!40000 ALTER TABLE `si_user_store` ENABLE KEYS */;


-- 导出  表 siiwi.si_user_supplier 结构
DROP TABLE IF EXISTS `si_user_supplier`;
CREATE TABLE IF NOT EXISTS `si_user_supplier` (
  `user_supplier_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '供应商ID',
  `user_supplier_name` varchar(50) NOT NULL COMMENT '供应商名称',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `user_store_id` int(11) NOT NULL COMMENT '店铺ID',
  `user_supplier_address` varchar(100) NOT NULL COMMENT '供应商地址',
  `user_supplier_contact` varchar(50) NOT NULL COMMENT '供应商联系人',
  `user_supplier_phone` varchar(20) NOT NULL COMMENT '供应商联系电话',
  `user_supplier_email` varchar(50) NOT NULL COMMENT '供应商电邮',
  `user_supplier_desc` text NOT NULL COMMENT '供应商描述',
  `user_supplier_url` varchar(50) NOT NULL COMMENT '供应商主页地址',
  `user_supplier_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '供应商状态（0-不可用，1-可用）',
  `add_timestamp` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`user_supplier_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='供应商列表';

-- 正在导出表  siiwi.si_user_supplier 的数据：4 rows
DELETE FROM `si_user_supplier`;
/*!40000 ALTER TABLE `si_user_supplier` DISABLE KEYS */;
INSERT INTO `si_user_supplier` (`user_supplier_id`, `user_supplier_name`, `user_id`, `user_store_id`, `user_supplier_address`, `user_supplier_contact`, `user_supplier_phone`, `user_supplier_email`, `user_supplier_desc`, `user_supplier_url`, `user_supplier_status`, `add_timestamp`) VALUES
	(1, '上海XX纺织厂', 1, 1, '', '', '', '', '', '', 1, 0),
	(2, '上海XX纺织厂', 1, 1, '', '', '', '', '', '', 1, 1443084823),
	(3, '上海XX纺织厂', 1, 1, '上海XX区XX路XX号', '李XX', '136********', 'root', '', '', 1, 1443084903),
	(4, '上海XX纺织厂', 1, 1, '上海XX区XX路XX号', '李XX', '136********', 'root@1234.com', '', '', 1, 1443084909);
/*!40000 ALTER TABLE `si_user_supplier` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
