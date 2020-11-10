-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2020-11-10 16:15:39
-- 伺服器版本： 10.1.38-MariaDB
-- PHP 版本： 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `test`
--

-- --------------------------------------------------------

--
-- 資料表結構 `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `Currency` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '幣別',
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 傾印資料表的資料 `currency`
--

INSERT INTO `currency` (`id`, `Currency`, `status`) VALUES
(1, '美金 (USD)', 1),
(2, '港幣 (HKD)', 1),
(3, '英鎊 (GBP)', 1),
(4, '澳幣 (AUD)', 1),
(5, '加拿大幣 (CAD)', 1),
(6, '新加坡幣 (SGD)', 1),
(7, '瑞士法郎 (CHF)', 1),
(8, '日圓 (JPY)', 1),
(9, '南非幣 (ZAR)', 1),
(10, '瑞典幣 (SEK)', 1),
(11, '紐元 (NZD)', 1),
(12, '泰幣 (THB)', 1),
(13, '菲國比索 (PHP)', 1),
(14, '印尼幣 (IDR)', 1),
(15, '歐元 (EUR)', 1),
(16, '韓元 (KRW)', 1),
(17, '越南盾 (VND)', 1),
(18, '馬來幣 (MYR)', 1),
(19, '人民幣 (CNY)', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動增長(AUTO_INCREMENT)
--

--
-- 使用資料表自動增長(AUTO_INCREMENT) `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
