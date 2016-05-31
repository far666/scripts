-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2016 年 06 月 01 日 01:32
-- 伺服器版本: 5.6.30-0ubuntu0.15.10.1
-- PHP 版本： 5.6.11-1ubuntu3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `search`
--

-- --------------------------------------------------------

--
-- 資料表結構 `eyny_movie`
--

CREATE TABLE `eyny_movie` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `create_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `sent_record`
--

CREATE TABLE `sent_record` (
  `id` int(11) NOT NULL,
  `eyny_movie_id` int(11) NOT NULL,
  `wait_list_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `wait_list`
--

CREATE TABLE `wait_list` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `disable_key` varchar(64) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = normal , 1 = deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `eyny_movie`
--
ALTER TABLE `eyny_movie`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `sent_record`
--
ALTER TABLE `sent_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sent` (`eyny_movie_id`,`wait_list_id`);

--
-- 資料表索引 `wait_list`
--
ALTER TABLE `wait_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`keyword`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `eyny_movie`
--
ALTER TABLE `eyny_movie`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- 使用資料表 AUTO_INCREMENT `sent_record`
--
ALTER TABLE `sent_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `wait_list`
--
ALTER TABLE `wait_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
