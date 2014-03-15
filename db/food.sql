-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 15 日 15:23
-- 服务器版本: 5.5.31
-- PHP 版本: 5.4.16

SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `food`
--
CREATE DATABASE IF NOT EXISTS `food` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE food;

-- --------------------------------------------------------

--
-- 表的结构 `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL COMMENT 'menu type',
  `name` varchar(80) NOT NULL,
  `price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '单价(单位分)',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点单次数',
  `delete` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`),
  KEY `price` (`price`,`tid`,`delete`)
) TYPE=MyISAM  COMMENT='菜单' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `menu`
--

INSERT INTO `menu` (`id`, `tid`, `name`, `price`, `count`, `delete`) VALUES
(1, 1, '农家小炒肉', 1400, 0, '0'),
(2, 1, '牛肉羹', 1300, 0, '0');

-- --------------------------------------------------------

--
-- 表的结构 `menutype`
--

CREATE TABLE IF NOT EXISTS `menutype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `title` varchar(80) NOT NULL DEFAULT '默认菜单',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tid` (`title`)
) TYPE=MyISAM  COMMENT='菜单类型' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `menutype`
--

INSERT INTO `menutype` (`id`, `title`) VALUES
(1, '东餐厅菜单');

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `total` int(10) unsigned NOT NULL DEFAULT '0',
  `dealtime` int(10) unsigned NOT NULL,
  `average` int(10) unsigned NOT NULL DEFAULT '0',
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `deadline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`)
) TYPE=MyISAM COMMENT='订单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ordership`
--

CREATE TABLE IF NOT EXISTS `ordership` (
  `oid` int(10) unsigned NOT NULL COMMENT '订单号',
  `rid` int(10) unsigned NOT NULL COMMENT '订单单条记录号',
  `mid` int(10) unsigned NOT NULL COMMENT '菜单ID',
  UNIQUE KEY `rid` (`rid`),
  KEY `oid` (`oid`,`mid`)
) TYPE=MyISAM COMMENT='订单关系';

-- --------------------------------------------------------

--
-- 表的结构 `record`
--

CREATE TABLE IF NOT EXISTS `record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'menutype id',
  `oid` int(10) unsigned NOT NULL COMMENT '订单号order id',
  `mid` int(10) unsigned NOT NULL COMMENT '菜名ID',
  `price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '单价单位(分)',
  `lastupdate` int(10) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '1',
  `usertoken` char(32) NOT NULL DEFAULT '' COMMENT '用户标识',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`usertoken`),
  KEY `price` (`price`),
  KEY `oid` (`oid`)
) TYPE=MyISAM COMMENT='订单记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL DEFAULT '',
  `usertoken` char(32) NOT NULL DEFAULT '',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  `realname` varchar(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `token` (`usertoken`)
) TYPE=MyISAM COMMENT='用户' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
