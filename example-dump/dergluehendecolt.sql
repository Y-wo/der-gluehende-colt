-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2023 at 06:15 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dergluehendecolt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_entity`
--

CREATE TABLE `admin_entity` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_entity`
--

INSERT INTO `admin_entity` (`id`, `member_id`, `password`) VALUES
(1, 5, '202cb962ac59075b964b07152d234b70'),
(4, 6, '202cb962ac59075b964b07152d234b70'),
(5, 21, 'test'),
(6, 20, 'test'),
(7, 11, '098f6bcd4621d373cade4e832627b4f6'),
(8, 15, '202cb962ac59075b964b07152d234b70'),
(9, 22, '098f6bcd4621d373cade4e832627b4f6'),
(10, 24, '202cb962ac59075b964b07152d234b70'),
(11, 26, '202cb962ac59075b964b07152d234b70'),
(12, 14, '81dc9bdb52d04dc20036dbd8313ed055'),
(13, 27, '202cb962ac59075b964b07152d234b70'),
(14, 31, '098f6bcd4621d373cade4e832627b4f6'),
(15, 12, '202cb962ac59075b964b07152d234b70'),
(16, 34, '81dc9bdb52d04dc20036dbd8313ed055'),
(17, 36, '202cb962ac59075b964b07152d234b70'),
(22, 43, '202cb962ac59075b964b07152d234b70'),
(23, 44, '202cb962ac59075b964b07152d234b70'),
(25, 47, '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_entity`
--

CREATE TABLE `attendance_entity` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_entity`
--

INSERT INTO `attendance_entity` (`id`, `member_id`, `date`, `department_id`) VALUES
(17, 6, '2023-03-07 19:39:54', 1),
(18, 6, '2023-03-07 19:53:05', 1),
(20, 5, '2023-03-01 19:55:54', 1),
(119, 5, '2023-03-01 17:06:20', 2),
(120, 5, '2023-03-02 17:06:20', 3),
(121, 5, '2023-03-04 17:07:02', 1),
(122, 5, '2023-03-03 17:07:02', 2),
(171, 5, '2023-03-11 08:11:51', 1),
(174, 11, '2023-03-11 17:15:19', 1),
(175, 15, '2023-03-11 17:37:44', 1),
(183, 16, '2023-03-13 09:36:23', 2),
(184, 8, '2023-03-13 09:36:24', 1),
(188, 14, '2023-03-13 18:17:30', 1),
(198, 30, '2023-03-18 14:12:10', 1),
(199, 28, '2023-03-18 14:12:13', 1),
(208, 5, '2023-03-19 20:06:32', 2),
(212, 46, '2023-03-19 20:07:02', 1),
(214, 20, '2023-03-19 20:15:16', 1),
(217, 26, '2023-03-19 20:22:03', 1),
(226, 5, '2023-04-27 19:26:34', 2),
(229, 43, '2023-04-27 19:27:03', 2),
(234, 43, '2023-04-27 20:17:46', 1),
(235, 15, '2023-04-27 20:19:26', 1),
(236, 15, '2023-04-27 20:19:26', 2),
(237, 15, '2023-04-27 20:19:27', 3);

-- --------------------------------------------------------

--
-- Table structure for table `department_entity`
--

CREATE TABLE `department_entity` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `costs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department_entity`
--

INSERT INTO `department_entity` (`id`, `name`, `costs`) VALUES
(1, 'Schusswaffen', 10),
(2, 'Bogen', 8),
(3, 'Luftdruck', 10);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230110124537', '2023-01-10 13:45:46', 46),
('DoctrineMigrations\\Version20230110124951', '2023-01-10 13:49:56', 38),
('DoctrineMigrations\\Version20230131104007', '2023-01-31 11:40:34', 70),
('DoctrineMigrations\\Version20230131104249', '2023-01-31 11:42:58', 71),
('DoctrineMigrations\\Version20230131105201', '2023-01-31 11:52:09', 70),
('DoctrineMigrations\\Version20230131113349', '2023-01-31 12:33:53', 52),
('DoctrineMigrations\\Version20230131113719', '2023-01-31 12:37:25', 126),
('DoctrineMigrations\\Version20230201092717', '2023-02-01 10:27:28', 64),
('DoctrineMigrations\\Version20230201093703', '2023-02-01 10:37:11', 74),
('DoctrineMigrations\\Version20230201095754', '2023-02-01 10:59:32', 112),
('DoctrineMigrations\\Version20230201101750', '2023-02-01 11:17:55', 57),
('DoctrineMigrations\\Version20230201113011', '2023-02-01 12:30:17', 97),
('DoctrineMigrations\\Version20230201113225', '2023-02-01 12:32:31', 67),
('DoctrineMigrations\\Version20230201113432', '2023-02-01 12:34:38', 92),
('DoctrineMigrations\\Version20230201114257', '2023-02-01 12:43:04', 114),
('DoctrineMigrations\\Version20230201145013', '2023-02-01 15:50:28', 46),
('DoctrineMigrations\\Version20230201151314', '2023-02-01 16:13:18', 52),
('DoctrineMigrations\\Version20230201152236', '2023-02-01 16:22:40', 47),
('DoctrineMigrations\\Version20230201152649', '2023-02-01 16:26:57', 41),
('DoctrineMigrations\\Version20230201153828', '2023-02-01 16:38:31', 47),
('DoctrineMigrations\\Version20230201160533', '2023-02-01 17:05:36', 56),
('DoctrineMigrations\\Version20230201160940', '2023-02-01 17:09:45', 78),
('DoctrineMigrations\\Version20230201161136', '2023-02-01 17:11:40', 71),
('DoctrineMigrations\\Version20230207080003', '2023-02-07 09:00:15', 82),
('DoctrineMigrations\\Version20230207105427', '2023-02-07 11:54:30', 42),
('DoctrineMigrations\\Version20230207105510', '2023-02-07 11:55:16', 28),
('DoctrineMigrations\\Version20230207110618', '2023-02-07 12:06:21', 38),
('DoctrineMigrations\\Version20230207112523', '2023-02-07 12:25:26', 38),
('DoctrineMigrations\\Version20230207113809', '2023-02-07 12:38:13', 35),
('DoctrineMigrations\\Version20230207114024', '2023-02-07 12:40:27', 41),
('DoctrineMigrations\\Version20230207114215', '2023-02-07 12:42:18', 66),
('DoctrineMigrations\\Version20230207114327', '2023-02-07 12:43:31', 62),
('DoctrineMigrations\\Version20230207114448', '2023-02-07 12:44:51', 64),
('DoctrineMigrations\\Version20230207114908', '2023-02-07 12:49:13', 50),
('DoctrineMigrations\\Version20230207115133', '2023-02-07 12:51:36', 45),
('DoctrineMigrations\\Version20230207115259', '2023-02-07 12:53:03', 36),
('DoctrineMigrations\\Version20230214165158', '2023-02-14 17:52:22', 89),
('DoctrineMigrations\\Version20230215150153', '2023-02-15 16:02:03', 37),
('DoctrineMigrations\\Version20230307183918', '2023-03-07 19:39:27', 96),
('DoctrineMigrations\\Version20230311070226', '2023-03-11 08:02:34', 62);

-- --------------------------------------------------------

--
-- Table structure for table `location_entity`
--

CREATE TABLE `location_entity` (
  `id` int(11) NOT NULL,
  `zip` int(11) NOT NULL,
  `locus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location_entity`
--

INSERT INTO `location_entity` (`id`, `zip`, `locus`) VALUES
(1, 2341, 'adsf'),
(2, 55131, 'Mainz'),
(3, 55123, 'Bingen'),
(4, 86763, 'Fugit dolor accusan'),
(5, 39449, 'Itaque qui id non v'),
(6, 58971, 'Est praesentium quid'),
(7, 17131, 'Accusantium eum aut '),
(8, 79702, 'Aliquid officia dolo'),
(9, 52146, 'In consequatur qui c'),
(10, 77942, 'Ut et ipsum pariatur'),
(11, 10767, 'Facere qui lorem ali'),
(12, 10800, 'Mollitia odio esse '),
(13, 79576, 'Ullam adipisci omnis'),
(14, 44437, 'Pariatur Ipsum eos'),
(15, 81522, 'Numquam non voluptat'),
(16, 6, '7'),
(17, 71438, 'Sit necessitatibus a'),
(18, 2147483647, 'Pariatur Ipsum eos2222222222'),
(19, 79686, 'Sed sit laboriosam '),
(20, 52230, 'Rerum laboriosam no'),
(21, 64533, 'Officia quidem excep'),
(22, 49409, 'Amet odit repellend'),
(23, 76491, 'Libero duis ut nostr'),
(24, 13427, 'Ea ut labore sit ab'),
(25, 58990, 'Do provident dolor '),
(26, 96677, 'Autem ea similique e'),
(27, 45951, 'Tenetur beatae id si'),
(28, 53522, 'Dolore dolor officia'),
(29, 33057, 'Eiusmod tempore qua'),
(30, 53490, 'Quidem beatae except'),
(31, 99456, 'Eaque qui dicta nisi'),
(32, 98598, 'Dolores dolorem erro'),
(33, 86835, 'Et facilis nihil duc'),
(34, 41632, 'Et do mollit repudia'),
(35, 41637, 'Consequatur aute Nam'),
(36, 84187, 'Tempore illo neque '),
(37, 18122, 'Molestiae eligendi t'),
(38, 19314, 'Sit officia at eum t'),
(39, 77889, 'Sapiente eiusmod id'),
(40, 66385, 'Qui eius reiciendis '),
(41, 59606, 'In dolor a tempora r'),
(42, 12976, 'In nostrud tempore '),
(43, 77965, 'Eaque magnam ut et n'),
(44, 60353, 'Culpa sint ipsam sun'),
(45, 20671, 'Eos exercitationem i'),
(46, 21753, 'Reprehenderit ipsa '),
(47, 12049, 'Officia in veritatis');

-- --------------------------------------------------------

--
-- Table structure for table `member_department_entity`
--

CREATE TABLE `member_department_entity` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_department_entity`
--

INSERT INTO `member_department_entity` (`id`, `member_id`, `department_id`) VALUES
(5, 6, 1),
(7, 7, 2),
(8, 8, 3),
(9, 8, 1),
(10, 11, 1),
(11, 11, 2),
(12, 11, 3),
(13, 12, 2),
(14, 14, 1),
(15, 14, 2),
(16, 14, 3),
(17, 15, 1),
(18, 15, 2),
(19, 15, 3),
(22, 17, 2),
(23, 17, 3),
(24, 18, 2),
(25, 19, 3),
(26, 20, 1),
(27, 20, 2),
(34, 21, 2),
(35, 22, 1),
(36, 22, 3),
(37, 23, 1),
(38, 23, 2),
(39, 24, 1),
(40, 24, 2),
(41, 24, 3),
(42, 25, 1),
(43, 26, 1),
(44, 27, 1),
(45, 27, 3),
(46, 28, 1),
(47, 29, 1),
(48, 29, 2),
(49, 29, 3),
(50, 30, 1),
(51, 30, 2),
(52, 30, 3),
(53, 31, 3),
(54, 5, 1),
(55, 5, 2),
(56, 5, 3),
(57, 32, 1),
(58, 32, 3),
(59, 33, 3),
(60, 34, 3),
(61, 35, 2),
(62, 36, 1),
(63, 36, 2),
(64, 37, 2),
(65, 38, 1),
(66, 38, 3),
(67, 39, 1),
(68, 39, 2),
(69, 39, 3),
(70, 40, 3),
(71, 42, 3),
(72, 43, 1),
(73, 43, 2),
(74, 43, 3),
(75, 44, 1),
(77, 44, 3),
(78, 45, 2),
(79, 45, 3),
(80, 46, 1),
(81, 46, 3),
(82, 47, 1),
(83, 47, 2),
(84, 47, 3),
(85, 48, 2),
(86, 48, 3),
(87, 41, 1),
(88, 41, 2),
(89, 49, 1),
(90, 49, 3),
(91, 50, 2),
(92, 50, 3);

-- --------------------------------------------------------

--
-- Table structure for table `member_entity`
--

CREATE TABLE `member_entity` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `house_number` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `phone` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `location_id` int(11) NOT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_entity`
--

INSERT INTO `member_entity` (`id`, `first_name`, `last_name`, `email`, `street`, `house_number`, `created_at`, `phone`, `deleted`, `location_id`, `birthday`) VALUES
(5, 'Maxi', '1234', 'asdf@asdf3', 'asdf 4', '5', '2023-02-01 12:37:03', '1234', 0, 16, '2023-03-11'),
(6, 'Thalia', 'asdf', 'sdfg@sdfg', 'sdfg', '1234', '2023-02-01 17:12:07', '1234', 1, 1, '2023-03-13'),
(7, 'Hans ', 'Wurst', 'hans@email.de', 'blabla', '12', '2023-03-10 17:48:17', '1234', 1, 1, '2005-03-11'),
(8, 'Inga', 'Ingostochter', 'inga@email.de', 'etetetet', '123', '2023-03-10 17:55:11', '432', 1, 1, '2004-03-19'),
(9, 'Ann', 'Edwards', 'kunezave@mailinator.com', 'Architecto praesenti', '707', '2023-03-11 17:02:19', '63', 1, 9, '1999-07-11'),
(11, 'Orla', 'Justice', 'zugaxop@mailinator.com', 'Sunt dolor fugiat ', '218', '2023-03-11 17:14:58', '72', 1, 10, '1993-02-02'),
(12, 'Quentin', 'Bailey', 'myryfyjud@mailinator.com', 'Nisi a alias volupta', '730', '2023-03-11 17:15:51', '97', 1, 11, '2022-08-01'),
(13, 'Constance', 'Murray', 'demeceweg@mailinator.com', 'Non sunt velit non a', '733', '2023-03-11 17:30:02', '63', 1, 12, '2013-03-15'),
(14, 'Constance32452345', 'Murray', 'demeceweg@mailinator.com', 'Non sunt velit non a', '733', '2023-03-11 17:30:18', '63', 1, 12, '2013-02-18'),
(15, 'Constance', 'Murray', 'demeceweg@mailinator.com', 'Non sunt velit non a', '733', '2023-03-11 17:30:24', '63', 0, 12, '2013-02-18'),
(16, 'Bevis', 'Pratt', 'wivon@mailinator.com', 'Facilis delectus ip', '21', '2023-03-11 17:36:11', '57', 1, 13, '1972-11-28'),
(17, 'Bevis', 'Pratt', 'wivon@mailinator.com', 'Facilis delectus ip', '21', '2023-03-11 17:37:19', '57', 1, 13, '1972-11-28'),
(18, 'Mccarthy44444', 'Mccarth666', 'vyfozacahu@mailinator.com32334234222222222222', 'Elit enim eos pari234234234', '1032222222222', '2023-03-11 17:37:27', '40444', 1, 18, '1997-06-02'),
(19, 'Daphne', 'Lancaster', 'tuvuh@mailinator.com', 'Pariatur Consequat', '675', '2023-03-11 17:37:36', '91', 0, 15, '2005-10-13'),
(20, 'Kirby111', 'Mercado', 'rywad@mailinator.com', 'Saepe in libero cons', '784', '2023-03-11 17:39:08', '59', 0, 2, '2022-04-25'),
(21, 'Burgesssdfsdf', 'Burgess', 'kimygaze@mailinator.com', 'Anim et dicta mollit', '490', '2023-03-13 11:54:42', '42', 1, 17, '2014-08-22'),
(22, 'Lance', 'Bishop', 'koxy@mailinator.com', 'Impedit veritatis e', '240', '2023-03-13 21:08:23', '37', 1, 19, '1990-08-28'),
(23, 'Jin', 'Compton', 'fofuc@mailinator.com', 'Et rerum voluptate i', '189', '2023-03-13 21:16:05', '67', 1, 20, '2021-08-05'),
(24, 'Tana', 'Stevens', 'zynola@mailinator.com', 'Illo accusamus duis ', '344', '2023-03-15 20:47:46', '62', 1, 21, '2008-06-27'),
(25, 'Kato', 'Spence', 'cowyzesil@mailinator.com', 'Aut iusto recusandae', '296', '2023-03-16 20:30:36', '89', 0, 22, '1979-12-04'),
(26, 'Nicole', 'Wilkinson', 'kazolasy@mailinator.com', 'Exercitationem moles', '541', '2023-03-17 20:21:03', '84', 0, 23, '1970-11-26'),
(27, 'Gwendolyn tesssst', 'Key', 'hyji@mailinator.com', 'Quas illum proident', '723', '2023-03-18 11:15:48', '69', 1, 24, '1997-05-28'),
(28, 'Brady', 'Aguirre', 'xepilapyji@mailinator.com', 'Ex irure repudiandae', '971', '2023-03-18 11:17:03', '15', 0, 25, '1998-12-11'),
(29, 'Illiana', 'Little', 'qytaheheha@mailinator.com', 'Esse est omnis veli', '74', '2023-03-18 12:05:30', '12', 1, 26, '2007-02-01'),
(30, 'Ayanna', 'Wolf', 'gegalacam@mailinator.com', 'Error cupidatat beat', '302', '2023-03-18 13:33:29', '33', 1, 27, '2019-07-16'),
(31, 'Sade test', 'Franklin', 'micusyr@mailinator.com', 'Iste totam expedita ', '12', '2023-03-18 15:58:37', '38', 1, 28, '2018-01-13'),
(32, 'Duncan 2234', 'Hughes', 'nomu@mailinator.com', 'Cupidatat exercitati', '301', '2023-03-18 16:19:24', '6', 1, 29, '2023-07-25'),
(33, 'Gavin', 'Collins', 'refedi@mailinator.com', 'Recusandae Ullamco ', '235', '2023-03-18 16:19:34', '69', 1, 30, '2008-11-23'),
(34, 'Sade test', 'Whitfield', 'zypycyxot@mailinator.com', 'Libero totam hic sit', '358', '2023-03-18 16:28:59', '6', 1, 31, '1973-11-10'),
(35, 'Mariam', 'Small', 'cywys@mailinator.com', 'Similique exercitati', '597', '2023-03-19 16:50:47', '16', 1, 32, '2017-11-08'),
(36, 'Amethyst', 'Good', 'gyviso@mailinator.com', 'Dolorum sed illum i', '118', '2023-03-19 16:51:59', '37', 1, 33, '2011-01-14'),
(37, 'Dillon', 'Green', 'jufuneryx@mailinator.com', 'In eligendi et ut es', '160', '2023-03-19 16:52:25', '88', 1, 34, '2018-11-11'),
(38, 'Fitzgerald', 'Foster', 'ragiga@mailinator.com', 'Consequat Ullam eiu', '295', '2023-03-19 16:52:54', '18', 1, 35, '1994-06-26'),
(39, 'Lisandra', 'Abbott', 'rigo@mailinator.com', 'Eveniet fugit dict', '833', '2023-03-19 16:55:52', '92', 1, 36, '1994-05-08'),
(40, 'Anika', 'Evans', 'nibyha@mailinator.com', 'Quasi veniam ipsa ', '421', '2023-03-19 19:37:34', '86', 0, 37, '2005-03-26'),
(41, 'Zachery', 'Preston', 'beqocavi@mailinator.com', 'Perferendis voluptat', '613', '2023-03-19 19:37:44', '12', 0, 38, '2014-12-16'),
(42, 'Suki', 'Tate', 'xiwe@mailinator.com', 'Proident distinctio', '320', '2023-03-19 19:37:48', '33', 0, 39, '2003-04-01'),
(43, 'Castor', 'Durham', 'wefalupisy@mailinator.com', 'Nulla quo veritatis ', '633', '2023-03-19 19:37:54', '84', 0, 40, '2018-08-10'),
(44, 'Justina', 'Lindsay', 'pofeqypyz@mailinator.com', 'Quos vitae tempora s', '344', '2023-03-19 19:37:58', '76', 0, 41, '1985-07-16'),
(45, 'Hope', 'Moses', 'jysavup@mailinator.com', 'Accusantium ex fugia', '31', '2023-03-19 19:38:03', '55', 1, 42, '1990-10-10'),
(46, 'Sandra', 'Vance', 'gyvikimex@mailinator.com', 'Sequi minus sint qui', '148', '2023-03-19 19:42:36', '80', 0, 43, '2022-01-08'),
(47, 'Clayton test', 'Bradshaw', 'ruxy@mailinator.com', 'Culpa in veritatis v', '632', '2023-03-19 19:48:41', '26', 0, 44, '1997-01-02'),
(48, 'Tuckerasdfasdf', 'Freeman', 'jebud@mailinator.com', 'Dolor elit mollit s', '943', '2023-03-19 20:17:03', '68', 1, 45, '1970-05-06'),
(49, 'Ahmed', 'Hendricks', 'sywel@mailinator.com', 'Accusamus molestiae ', '465', '2023-03-22 12:26:53', '35', 1, 46, '1985-09-10'),
(50, 'Avram', 'Phillips', 'sezalabere@mailinator.com', 'Aute illum anim non', '55', '2023-04-27 20:19:37', '22', 0, 47, '1973-02-09');

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_entity`
--
ALTER TABLE `admin_entity`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_53E075917597D3FE` (`member_id`);

--
-- Indexes for table `attendance_entity`
--
ALTER TABLE `attendance_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A4025F6C7597D3FE` (`member_id`),
  ADD KEY `IDX_A4025F6CAE80F5DF` (`department_id`);

--
-- Indexes for table `department_entity`
--
ALTER TABLE `department_entity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `location_entity`
--
ALTER TABLE `location_entity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_department_entity`
--
ALTER TABLE `member_department_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_536B1BA67597D3FE` (`member_id`),
  ADD KEY `IDX_536B1BA6AE80F5DF` (`department_id`);

--
-- Indexes for table `member_entity`
--
ALTER TABLE `member_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2AFEC65B64D218E` (`location_id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_entity`
--
ALTER TABLE `admin_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `attendance_entity`
--
ALTER TABLE `attendance_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `department_entity`
--
ALTER TABLE `department_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `location_entity`
--
ALTER TABLE `location_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `member_department_entity`
--
ALTER TABLE `member_department_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `member_entity`
--
ALTER TABLE `member_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_entity`
--
ALTER TABLE `admin_entity`
  ADD CONSTRAINT `FK_53E075917597D3FE` FOREIGN KEY (`member_id`) REFERENCES `member_entity` (`id`);

--
-- Constraints for table `attendance_entity`
--
ALTER TABLE `attendance_entity`
  ADD CONSTRAINT `FK_A4025F6C7597D3FE` FOREIGN KEY (`member_id`) REFERENCES `member_entity` (`id`),
  ADD CONSTRAINT `FK_A4025F6CAE80F5DF` FOREIGN KEY (`department_id`) REFERENCES `department_entity` (`id`);

--
-- Constraints for table `member_department_entity`
--
ALTER TABLE `member_department_entity`
  ADD CONSTRAINT `FK_536B1BA67597D3FE` FOREIGN KEY (`member_id`) REFERENCES `member_entity` (`id`),
  ADD CONSTRAINT `FK_536B1BA6AE80F5DF` FOREIGN KEY (`department_id`) REFERENCES `department_entity` (`id`);

--
-- Constraints for table `member_entity`
--
ALTER TABLE `member_entity`
  ADD CONSTRAINT `FK_2AFEC65B64D218E` FOREIGN KEY (`location_id`) REFERENCES `location_entity` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
