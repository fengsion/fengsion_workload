-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-05-22 16:07:40
-- 服务器版本： 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workload`
--
CREATE DATABASE IF NOT EXISTS `workload` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `workload`;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id',
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `userId` varchar(30) NOT NULL COMMENT '用户ID',
  `role` varchar(10) NOT NULL COMMENT '用户类型',
  `name` varchar(32) NOT NULL COMMENT '姓名',
  `password` varchar(48) NOT NULL COMMENT '密码',
  `status` tinyint(4) NOT NULL COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `userId`, `role`, `name`, `password`, `status`) VALUES
(2, 'administrator', '1111111', '管理员', 'hhh', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1),
(7, '00207', '2088512762727243', '教师', '胡泽军', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1);

-- --------------------------------------------------------

--
-- 表的结构 `work`
--

CREATE TABLE `work` (
  `id` int(11) NOT NULL COMMENT '主键',
  `year` varchar(4) NOT NULL COMMENT '材料年度',
  `teacherId` varchar(10) NOT NULL COMMENT '教工号',
  `typeId` int(11) NOT NULL COMMENT '类别id',
  `content` varchar(500) NOT NULL COMMENT '内容',
  `amount` int(11) NOT NULL COMMENT '数量',
  `classHour` int(11) DEFAULT NULL COMMENT '折算课时',
  `money` int(11) DEFAULT NULL COMMENT '奖励金额',
  `evidence` varchar(200) DEFAULT NULL COMMENT '证明材料',
  `remarks` varchar(200) DEFAULT NULL COMMENT '备注',
  `recorder` varchar(32) NOT NULL COMMENT '记录人',
  `status` varchar(2) NOT NULL COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `work`
--

INSERT INTO `work` (`id`, `year`, `teacherId`, `typeId`, `content`, `amount`, `classHour`, `money`, `evidence`, `remarks`, `recorder`, `status`) VALUES
(1, '2018', '00207', 1, '白白白白白白白白白白白白白白', 1, 12, 333, 'rrrrrrrrrrrrrrrrrrrrrrr', 'qrwrqerqewrer', 'rrrrr', '确认');

-- --------------------------------------------------------

--
-- 表的结构 `worktype`
--

CREATE TABLE `worktype` (
  `id` int(11) NOT NULL COMMENT '主键',
  `bigType` varchar(30) NOT NULL COMMENT '大类',
  `typeName` varchar(32) NOT NULL COMMENT '类别名',
  `rank` varchar(32) NOT NULL COMMENT '级别',
  `content` varchar(500) NOT NULL COMMENT ' 内容',
  `classHour` varchar(200) NOT NULL COMMENT '课时',
  `price` varchar(200) NOT NULL COMMENT '价格',
  `memo` varchar(100) DEFAULT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `worktype`
--

INSERT INTO `worktype` (`id`, `bigType`, `typeName`, `rank`, `content`, `classHour`, `price`, `memo`) VALUES
(1, '科研', '论文', '一般刊物', '一般刊物（含外国）、省级重要报纸（学术、理论版）、一般索引', '\r\n{"C":"","L":"3","H":"6","TL":"","TH":"44"}', '{"C":"","L":"-34","H":"68","TL":"0","TH":""}', ''),
(2, '科研', '论文', '核心期刊', '核心期刊、国家重要报纸（学术、理论版）、一般索引全文转载', '\r\n{"C":"","L":"3","H":"6","TL":"","TH":"44"}', '{"C":"","L":"-34","H":"68","TL":"0","TH":""}', NULL),
(3, '科研', '论文', '权威期刊', '权威期刊（含外国）、重要索引', '\r\n{"C":"","L":"3","H":"6","TL":"","TH":"44"}', '{"C":"","L":"-34","H":"68","TL":"0","TH":""}', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worktype`
--
ALTER TABLE `worktype`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `worktype`
--
ALTER TABLE `worktype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键', AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
