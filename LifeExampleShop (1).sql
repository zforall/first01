-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 17, 2012 at 09:23 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `LifeExampleShop`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `url`, `parent`, `sort`) VALUES
(1, 'Мониторы', 'monitory', 5, 0),
(2, 'Периферия', 'periferiya', 5, 0),
(3, 'Мышки', 'myshki', 2, 0),
(4, 'Разное', 'raznoe', 0, 0),
(5, 'Компьютеры', 'kompyutery', 0, 0),
(8, 'Роликовые', 'rolikovyie', 3, 0),
(14, 'струйные', 'struynyie', 13, 0),
(15, 'лазерные', 'lazernyie', 13, 0),
(16, 'Калькуляторы', 'kalkulyatoryi', 2, 0),
(18, 'Оптические', 'opticheskie', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `summ` varchar(255) NOT NULL,
  `order_content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `date`, `name`, `email`, `phone`, `adres`, `summ`, `order_content`) VALUES
(80, 1338545364, 'asd', 'mark-avdeev@mail.ru', '123', 'werweqr', '123', 'a:1:{i:72;a:2:{s:5:\\"price\\";s:3:\\"123\\";s:5:\\"count\\";i:1;}}'),
(81, 1338979545, 'Марк', 'mark-avdeev@mail.ru', '123', '123', '500', 'a:1:{i:58;a:2:{s:5:\\"price\\";s:3:\\"500\\";s:5:\\"count\\";i:1;}}');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `desc` text NOT NULL,
  `price` varchar(255) CHARACTER SET utf8 NOT NULL,
  `url` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `cat_id`, `name`, `desc`, `price`, `url`, `image_url`, `code`) VALUES
(58, 4, 'Мышь', 'тру мышь', '500', 'myish', '1.jpg', 'm1'),
(59, 5, 'Клавиатура4', 'Клавиатура', '679', 'klaviatura', '3.jpg', 'k-1'),
(60, 5, 'Колонки', 'Колонкии5', '800', 'kolonki', '4.jpg', 'kol-1'),
(61, 3, 'Модем', 'Wi-fi модем1', '1200', 'modem', '6.jpg', 'modem-1'),
(63, 5, 'системный блок', 'компьбтер', '22300', 'sistemnyiy_blok', '', 's1'),
(64, 1, 'Монитор', 'Монитор', '9900', 'monitor', '2.jpg', 'mon1'),
(71, 4, 'Тестовый товар', 'Описание для тестового товара', '160', 'testovyiy_tovar', 'page-about-icon.png', 'T1'),
(73, 4, 'наушники', 'Очень удобное оголовье, лучшие басы для своего ценового сегмента, "выносливый" джек. Довольно мощное пассивное шумоподавление. Хороши для метро и/или для другого транспорта.', '347', 'naushniki', 'i.jpg', 'NT-1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `pass`, `role`) VALUES
(1, 'admin', '1', 1),
(2, 'mark', '123456', 2);
