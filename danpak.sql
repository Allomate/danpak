-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2018 at 12:04 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `danpak`
--

-- --------------------------------------------------------

--
-- Table structure for table `ams`
--

CREATE TABLE `ams` (
  `id` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `checking_status` float NOT NULL COMMENT '1: check_in, 0: check_out',
  `employee_id` int(11) NOT NULL,
  `within_radius` float NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ams`
--

INSERT INTO `ams` (`id`, `latitude`, `longitude`, `checking_status`, `employee_id`, `within_radius`, `created_at`) VALUES
(1, 50, 20, 1, 38, 0, '2018-02-22 15:17:20');

-- --------------------------------------------------------

--
-- Table structure for table `area_management`
--

CREATE TABLE `area_management` (
  `id` int(11) NOT NULL,
  `area_name` varchar(100) NOT NULL,
  `area_poc_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area_management`
--

INSERT INTO `area_management` (`id`, `area_name`, `area_poc_id`, `region_id`) VALUES
(1, 'Area AS', 38, 1);

-- --------------------------------------------------------

--
-- Table structure for table `catalogues`
--

CREATE TABLE `catalogues` (
  `id` int(11) NOT NULL,
  `catalogue_name` varchar(100) NOT NULL,
  `item_id` varchar(500) NOT NULL COMMENT 'Comma Seperated',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catalogues`
--

INSERT INTO `catalogues` (`id`, `catalogue_name`, `item_id`, `created_at`) VALUES
(5, 'Test Catalogue', '401,403,405,404', '2018-02-14 23:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `catalogue_assignment`
--

CREATE TABLE `catalogue_assignment` (
  `id` int(11) NOT NULL,
  `catalogue_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `active_from` date DEFAULT NULL,
  `active_till` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catalogue_assignment`
--

INSERT INTO `catalogue_assignment` (`id`, `catalogue_id`, `employee_id`, `active_from`, `active_till`, `created_at`) VALUES
(12, 5, 38, '2018-02-19', '2018-02-22', '2018-02-19 11:44:09');

-- --------------------------------------------------------

--
-- Table structure for table `ci_session`
--

CREATE TABLE `ci_session` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_session`
--

INSERT INTO `ci_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('0122a8n12hctpgj2dudd08vqngo4etda', '192.168.10.5', 1520247046, 0x5f5f63695f6c6173745f726567656e65726174657c693a313532303234373030333b),
('554ku0go1crefooiuktv2g03jlhhgeg6', '127.0.0.1', 1519125330, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132353333303b),
('57lp8jppur7b8bcofaj221v0krcuchnd', '127.0.0.1', 1519123126, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132333132363b),
('6kmv3issk7c8c45qln0ns5pddq3sjr7m', '127.0.0.1', 1519214830, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393231343833303b),
('6o2245s934a85k1e2q67bs2jq12b9gov', '::1', 1520247024, 0x5f5f63695f6c6173745f726567656e65726174657c693a313532303234373032343b),
('7tdiavjetibkcs3ivf235j9irelcohb6', '127.0.0.1', 1519122931, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132323933313b),
('7vurfhg2e5ob14s2mnu4ojn27l1l9eat', '127.0.0.1', 1519121909, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132313930393b),
('89kuc3ro719lbp6rbbnrd5qqt7712vmh', '127.0.0.1', 1519192814, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393139323831343b),
('8ohi2h8hgc6f6pml798912q7ocork3ln', '127.0.0.1', 1519125843, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132353633353b),
('914jf5dcljdgopg5gojg588op0ohg10t', '127.0.0.1', 1519124286, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132343238363b),
('a00vn97lp736n1i4vt899ptfekh9b4ou', '127.0.0.1', 1519124655, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132343635353b),
('d7nd5628qcervev6s868225io2tog0at', '127.0.0.1', 1519127906, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132373930363b6f726465725f636f6d706c657465647c733a33373a224f7264657220686173206265656e20636f6d706c65746564207375636365737366756c6c79223b5f5f63695f766172737c613a313a7b733a31353a226f726465725f636f6d706c65746564223b733a333a226f6c64223b7d),
('ed5opi9uu24a1m7f5clavdm2oj2lei2g', '127.0.0.1', 1519124970, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132343937303b),
('hhdp4naieqab42hnpaj2ge0tjek9upa7', '127.0.0.1', 1519192819, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393139323831343b),
('kj511pbas16pdif86b27urorre15jdfm', '127.0.0.1', 1519125635, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132353633353b),
('mj4a75udn3s3efj4gt2r0dsbn1ocqe7c', '127.0.0.1', 1519294640, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393239343631363b),
('nlad7k8fondn9hs4vr0vp774nchb0o4l', '127.0.0.1', 1519122581, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132323538313b),
('oatd4gc14g9b5brdmvuspb8o7217bhds', '127.0.0.1', 1519123561, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393132333536313b),
('p4icif6g397ab9ol0qkdcsfl7vqmkkrh', '127.0.0.1', 1519214981, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531393231343833303b);

-- --------------------------------------------------------

--
-- Table structure for table `employees_info`
--

CREATE TABLE `employees_info` (
  `employee_id` int(11) NOT NULL,
  `employee_first_name` varchar(50) NOT NULL,
  `employee_last_name` varchar(50) NOT NULL,
  `employee_username` varchar(50) NOT NULL,
  `employee_password` varchar(50) NOT NULL,
  `employee_address` varchar(100) NOT NULL,
  `employee_city` varchar(60) NOT NULL,
  `employee_country` varchar(60) DEFAULT 'Pakistan',
  `employee_picture` varchar(500) NOT NULL,
  `reporting_to` int(11) DEFAULT NULL,
  `territory_id` int(11) NOT NULL,
  `employee_cnic` varchar(20) NOT NULL,
  `employee_hire_at` date NOT NULL,
  `employee_fire_at` date NOT NULL,
  `employee_designation` varchar(100) NOT NULL,
  `employee_phone` varchar(20) NOT NULL,
  `employee_salary` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees_info`
--

INSERT INTO `employees_info` (`employee_id`, `employee_first_name`, `employee_last_name`, `employee_username`, `employee_password`, `employee_address`, `employee_city`, `employee_country`, `employee_picture`, `reporting_to`, `territory_id`, `employee_cnic`, `employee_hire_at`, `employee_fire_at`, `employee_designation`, `employee_phone`, `employee_salary`, `created_at`) VALUES
(38, 'Junaid Ul Qayyum', 'Qureshi', 'junaidulqayyum', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'H#450/F-II, Jinnah St. Tench Bhatta', 'Rawalpindi', 'Pakistan', '', 38, 8, '3740561520111', '0000-00-00', '0000-00-00', 'Sr. Software Engineer', '923125847735', 50000, '2018-01-17 11:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `employee_session`
--

CREATE TABLE `employee_session` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `session` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_session`
--

INSERT INTO `employee_session` (`id`, `username`, `session`) VALUES
(24, 'junaidulqayyum', 'zYa0SPiZ2GynD9WoRIHVtqQBU4x5Xs6rd3LJFpuAe7wTEl1hON');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `item_id` int(11) NOT NULL,
  `item_sku` varchar(20) DEFAULT NULL,
  `item_barcode` varchar(20) DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_brand` varchar(100) NOT NULL,
  `item_size` varchar(50) NOT NULL,
  `item_color` varchar(200) DEFAULT NULL,
  `item_quantity` int(11) DEFAULT '0',
  `item_purchased_price` int(11) DEFAULT NULL,
  `item_sale_price` int(11) DEFAULT NULL,
  `item_expiry` date DEFAULT NULL,
  `item_image` varchar(500) DEFAULT NULL,
  `item_thumbnail` varchar(100) DEFAULT NULL,
  `item_description` varchar(500) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`item_id`, `item_sku`, `item_barcode`, `item_name`, `item_brand`, `item_size`, `item_color`, `item_quantity`, `item_purchased_price`, `item_sale_price`, `item_expiry`, `item_image`, `item_thumbnail`, `item_description`, `category_id`, `created_at`, `modified_at`) VALUES
(401, 'M&SSWEATER012', '5256827148672157', 'BLUEHARBOUR V-NECK SWEATER', 'MARKS&SPENCER', 'S', 'GREEN', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:26:10', NULL),
(402, 'M&SSWEATER012', '8087452110117635', 'BLUEHARBOUR V-NECK SWEATER', 'MARKS&SPENCER', 'M', 'GREEN', 0, 3000, 5000, '2018-01-16', './assets/uploads/inventory/1516702595-1508330013-route_pin_gps_locate_location_map_marker_navigate_navigation_plan_road_-512.png,./assets/uploads/inventory/1516702595-1508330013-route1600.png,./assets/uploads/inventory/1516702595-1508332612-route_pin_gps_locate_location_map_marker_navigate_navigation_plan_road_-512.png', './assets/uploads/inventory/1516702595-1508330013-Maps-Map-Marker-icon.png', '', 110, '2018-01-16 03:26:10', NULL),
(403, 'M&SSWEATER013', '5064770468593662', 'MARKS & SPENCER SWEATER', 'MARKS&SPENCER', 'S', 'BERRY', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:26:10', NULL),
(404, 'M&SSWEATER014', '7101394741521705', 'MARKS & SPENCER SWEATER', 'MARKS&SPENCER', 'S', 'KHAKI', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:26:10', NULL),
(405, 'M&SSWEATER014', '7540087541072693', 'MARKS & SPENCER SWEATER', 'MARKS&SPENCER', 'M', 'KHAKI', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:26:10', NULL),
(407, 'NCSWEATER016', '2599580817722805', 'NORTH COAST SWEATER', 'NORTH COST', 'S', 'BLUE', 0, 3000, 5000, '2018-01-16', '', '', '', 117, '2018-01-16 03:26:10', NULL),
(408, 'ESPIRITSWEATER017', '9779004237353931', 'ESPIRIT SWEATER', 'Test Brand', 'S', 'MULTI', 0, 3000, 5000, '2018-01-16', '', '', 'Test Description', 117, '2018-01-16 03:26:10', NULL),
(410, 'M&SSWEATER019', '3960207466437018', 'MARKS & SPENCER SWEATER', 'MARKS&SPENCER', 'S', 'LIGHT BLUE', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:26:10', NULL),
(411, 'ITALIANSWEATER020', '0617938816604563', 'ITALIAN SWEATER', 'ITALIAN', 'M', 'GREEN', 0, 3000, 5000, '2018-01-16', '', './assets/uploads/inventory/1516704500-1509101299-Screen_Shot_2017-10-27_at_5_55_34_AM.png', '', 116, '2018-01-16 03:26:10', NULL),
(413, 'M&SSWEATER022', '6284769344753635', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'M', 'LIGHT GREY', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:26:10', NULL),
(414, 'M&SSWEATER023', '4686050142899214', 'AUTOGRAPH SWEATER', 'AUTOGRAPH', 'M', 'ASH GREY', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:26:10', NULL),
(415, 'M&SSWEATER024', '0858418873406799', 'COLLIZIONE SWEATER', 'MARKS&SPENCER', 'M', 'PINKISH PEACH', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:26:10', NULL),
(416, 'NCSWEATER025', '9405429878941262', 'NORTH COAST SWEATER', 'NORTH COST', 'M', 'GREYMIX', 0, 3000, 5000, '2018-01-16', '', '', '', 117, '2018-01-16 03:26:10', NULL),
(417, 'M&SSWEATER026', '3814325550606356', 'MARKS & SPENCER V-NECK SWEATER', 'MARKS&SPENCER', 'M', 'BLUE ', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:26:10', NULL),
(418, 'NEXTSWEATER027', '4207290569888370', 'NEXT SWEATER', 'NEXT', 'M', 'GREY', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:26:10', NULL),
(419, 'NEXTSWEATER028', '1564253053114851', 'NEXT SWEATER', 'NEXT', 'M', 'BLACK', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:26:10', NULL),
(420, 'M&SSWEATERS029', '2717365227071907', 'MARKS & SPENCER SWEATER ', 'MARKS&SPENCER', 'M', 'BROWN', 0, 3000, 5000, '2018-01-16', '', '', '', 117, '2018-01-16 03:26:10', NULL),
(421, 'M&SSWEATERS030', '6345884039802714', 'MARKS & SPENCER SWEATER ZIPPER', 'MARKS&SPENCER', 'M', 'BEIGE', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:26:10', NULL),
(422, 'M&SSWEATERS031', '6499510440315754', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'M', 'BROWN', 0, 3000, 5000, '2018-01-16', '', '', '', 116, '2018-01-16 03:26:10', NULL),
(423, 'M&SSWEATERS032', '7623889391570222', 'COLLIZIONE SWEATER', 'MARKS&SPENCER', 'M', 'BLUE', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:26:10', NULL),
(424, 'M&SSWEATERS033', '6368260062922886', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'M', 'BRIGHT BLUE', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:26:11', NULL),
(425, 'NEXTSWEATER034', '3126588929399938', 'NEXT SWEATER', 'NEXT', 'M', 'GREEN', 0, 3000, 5000, '2018-01-16', '', '', '', 117, '2018-01-16 03:26:11', NULL),
(426, 'GALVANISWEATERS001', '5549510359427002', 'GALVANI SWEATER', 'GALVANI', 'S', 'PURPLE', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(427, 'GALVANISWEATERS002', '6264810077208889', 'GALVANI SWEATER', 'GALVANI', 'M', 'RED', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(428, 'GALVANISWEATERS003', '5680468042301368', 'GALVANI SWEATER', 'GALVANI', 'S', 'GREEN', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(429, 'M&SSWEATER004', '6560589351607717', 'BLUEHARBOUR V-NECK SWEATER', 'MARKS&SPENCER', 'S', 'GREY', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:27:31', NULL),
(430, 'M&SSWEATER005', '8904874209918193', 'MARKS & SPENCER REGULAR FIT SWEATER', 'MARKS&SPENCER', 'S', 'BROWN', 0, 3000, 5000, '2018-01-16', '', '', '', 117, '2018-01-16 03:27:31', NULL),
(431, 'M&SSWEATER006', '6062449981376244', 'MARKS & SPENCER SWEATER', 'MARKS&SPENCER', 'S', 'LIGHT GREEN', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(432, 'M&SSWEATER007', '6703082027013285', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'S', 'DARK GREY', 0, 3000, 5000, '2018-01-16', '', '', '', 116, '2018-01-16 03:27:31', NULL),
(433, 'M&SSWEATER008', '3069018011019378', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'XS', 'NAVY', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:27:31', NULL),
(434, 'M&SSWEATER008', '4591333660482518', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'S', 'NAVY', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:27:31', NULL),
(435, 'M&SSWEATER009', '1002090887812206', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'S', 'NAVY', 0, 3000, 5000, '2018-01-16', '', '', '', 116, '2018-01-16 03:27:31', NULL),
(436, 'M&SSWEATER010', '9586023426118483', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'S', 'ICE BLUE', 0, 3000, 5000, '2018-01-16', '', '', '', 116, '2018-01-16 03:27:31', NULL),
(437, 'M&SSWEATER011', '0537597524144978', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'S', 'FOWN', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:27:31', NULL),
(438, 'M&SSWEATER012', '1336116284665383', 'BLUEHARBOUR V-NECK SWEATER', 'MARKS&SPENCER', 'S', 'GREEN', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:27:31', NULL),
(439, 'M&SSWEATER012', '7665498787143736', 'BLUEHARBOUR V-NECK SWEATER', 'MARKS&SPENCER', 'M', 'GREEN', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:27:31', NULL),
(440, 'M&SSWEATER013', '7536393108389504', 'MARKS & SPENCER SWEATER', 'MARKS&SPENCER', 'S', 'BERRY', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(441, 'M&SSWEATER014', '1437103623075106', 'MARKS & SPENCER SWEATER', 'MARKS&SPENCER', 'S', 'KHAKI', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(442, 'M&SSWEATER014', '4288965955035144', 'MARKS & SPENCER SWEATER', 'MARKS&SPENCER', 'M', 'KHAKI', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(444, 'NCSWEATER016', '9513527947969898', 'NORTH COAST SWEATER', 'NORTH COST', 'S', 'BLUE', 0, 3000, 5000, '2018-01-16', '', '', '', 117, '2018-01-16 03:27:31', NULL),
(445, 'ESPIRITSWEATER017', '2546128972214751', 'ESPIRIT SWEATER', 'ESPIRIT', 'S', 'MULTI', 0, 3000, 5000, '2018-01-16', '', '', '', 117, '2018-01-16 03:27:31', NULL),
(447, 'M&SSWEATER019', '2315968114345517', 'MARKS & SPENCER SWEATER', 'MARKS&SPENCER', 'S', 'LIGHT BLUE', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(448, 'ITALIANSWEATER020', '0289777182298306', 'ITALIAN SWEATER', 'ITALIAN', 'M', 'GREEN', 0, 3000, 5000, '2018-01-16', '', '', '', 116, '2018-01-16 03:27:31', NULL),
(449, 'ZARASWEATER021', '5224541858757432', 'ZARA SWEATER', 'ZARA MAN', 'M', 'BLUE MULTI', 0, 3000, 5000, '2018-01-16', '', './assets/uploads/inventory/1516704464-1508335669-route1600.png', '', 116, '2018-01-16 03:27:31', NULL),
(450, 'M&SSWEATER022', '8717695716533870', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'M', 'LIGHT GREY', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(451, 'M&SSWEATER023', '5128341812141888', 'AUTOGRAPH SWEATER', 'AUTOGRAPH', 'M', 'ASH GREY', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(452, 'M&SSWEATER024', '7915949172211865', 'COLLIZIONE SWEATER', 'MARKS&SPENCER', 'M', 'PINKISH PEACH', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(453, 'NCSWEATER025', '1956278361214987', 'NORTH COAST SWEATER', 'NORTH COST', 'M', 'GREYMIX', 0, 3000, 5000, '2018-01-16', '', '', '', 117, '2018-01-16 03:27:31', NULL),
(454, 'M&SSWEATER026', '3346467218720431', 'MARKS & SPENCER V-NECK SWEATER', 'MARKS&SPENCER', 'M', 'BLUE ', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:27:31', NULL),
(455, 'NEXTSWEATER027', '2811288615705260', 'NEXT SWEATER', 'NEXT', 'M', 'GREY', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:27:31', NULL),
(456, 'NEXTSWEATER028', '8610290649743291', 'NEXT SWEATER', 'NEXT', 'M', 'BLACK', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:27:31', NULL),
(457, 'M&SSWEATERS029', '5431131922558908', 'MARKS & SPENCER SWEATER ', 'MARKS&SPENCER', 'M', 'BROWN', 0, 3000, 5000, '2018-01-16', '', '', '', 117, '2018-01-16 03:27:31', NULL),
(458, 'M&SSWEATERS030', '4538768162053455', 'MARKS & SPENCER SWEATER ZIPPER', 'MARKS&SPENCER', 'M', 'BEIGE', 0, 3000, 5000, '2018-01-16', '', '', '', 110, '2018-01-16 03:27:31', NULL),
(459, 'M&SSWEATERS031', '1267092075662779', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'M', 'BROWN', 0, 3000, 5000, '2018-01-16', '', '', '', 116, '2018-01-16 03:27:31', NULL),
(460, 'M&SSWEATERS032', '1109651583594593', 'COLLIZIONE SWEATER', 'MARKS&SPENCER', 'M', 'BLUE', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(461, 'M&SSWEATERS033', '4964340908385525', 'BLUEHARBOUR SWEATER', 'MARKS&SPENCER', 'M', 'BRIGHT BLUE', 0, 3000, 5000, '2018-01-16', '', '', '', 103, '2018-01-16 03:27:31', NULL),
(462, 'NEXTSWEATER034', '6680462772525442', 'NEXT SWEATER', 'NEXT', 'M', 'GREEN', 0, 3000, 5000, '2018-01-16', '', '', '', 117, '2018-01-16 03:27:31', NULL),
(463, 'Sku', 'Barcode', 'Test name', 'Test Brand', 'XL', NULL, 0, 123, 2300, '2018-12-30', './assets/uploads/inventory/1516693196-1505428748-1500204117-colorpop.jpg,./assets/uploads/inventory/1516693196-1505428761-roaring-lion-wallpapers-hd-1024x640.jpg,./assets/uploads/inventory/1516693196-1505428774-hd-pictures-of-lions1.jpg', './assets/uploads/inventory/1516693196-1505428774-hd-pictures-of-lions.jpg', 'Desc', NULL, '2018-01-23 12:39:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `catalogue_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `booker_lats` double NOT NULL,
  `booker_longs` double NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `booking_region` varchar(100) DEFAULT NULL,
  `booking_area` varchar(100) DEFAULT NULL,
  `booking_territory` varchar(100) DEFAULT NULL,
  `invoice_number` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `employee_id`, `catalogue_id`, `retailer_id`, `booker_lats`, `booker_longs`, `status`, `created_at`, `updated_at`, `booking_region`, `booking_area`, `booking_territory`, `invoice_number`) VALUES
(24, 38, 5, 2, 50, 54.645, 'Completed', '2018-02-20 15:31:30', NULL, '1', '1', '8', '1478247031'),
(25, 38, 5, 2, 50, 54.645, 'Processed', '2018-02-20 15:31:34', NULL, '1', '1', '8', '2077347522'),
(26, 38, 5, 9, 50, 54.645, NULL, '2018-02-20 15:39:03', NULL, '1', '1', '8', '1108521092'),
(27, 38, 5, 9, 50, 54.645, NULL, '2018-02-20 15:46:01', NULL, '1', '1', '8', '1613577593');

-- --------------------------------------------------------

--
-- Table structure for table `order_contents`
--

CREATE TABLE `order_contents` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_quantity_booker` int(11) NOT NULL,
  `item_quantity_updated` int(11) DEFAULT NULL,
  `item_status` int(1) NOT NULL DEFAULT '1' COMMENT '0:delete, 1:active, 2:order expanded',
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_contents`
--

INSERT INTO `order_contents` (`id`, `item_id`, `item_quantity_booker`, `item_quantity_updated`, `item_status`, `order_id`) VALUES
(28, 402, 10, NULL, 1, 24),
(29, 403, 9, NULL, 1, 24),
(30, 402, 10, NULL, 1, 25),
(31, 403, 11, NULL, 1, 25),
(32, 404, 12, NULL, 1, 25),
(33, 402, 10, NULL, 1, 26),
(34, 403, 0, NULL, 1, 26),
(35, 404, 0, NULL, 1, 26),
(36, 402, 10, NULL, 1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `regions_info`
--

CREATE TABLE `regions_info` (
  `id` int(11) NOT NULL,
  `region_name` varchar(100) NOT NULL,
  `region_poc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `retailers_details`
--

CREATE TABLE `retailers_details` (
  `id` int(11) NOT NULL,
  `retailer_name` varchar(100) NOT NULL,
  `retailer_address` varchar(500) NOT NULL,
  `retailer_lats` double NOT NULL,
  `retailer_longs` double NOT NULL,
  `retailer_city` varchar(100) DEFAULT NULL,
  `retailer_area_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retailers_details`
--

INSERT INTO `retailers_details` (`id`, `retailer_name`, `retailer_address`, `retailer_lats`, `retailer_longs`, `retailer_city`, `retailer_area_id`, `created_at`) VALUES
(2, 'Rasheed Kareyana Store', 'Donga Gali, House#450/F-II, Jinnah St. Tench Bhatta, Rawalpindi', 27.265489, 12, 'City Rajasthan', 4, '2018-02-20 15:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `service_secret_key`
--

CREATE TABLE `service_secret_key` (
  `id` int(11) NOT NULL,
  `api_secret` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_secret_key`
--

INSERT INTO `service_secret_key` (`id`, `api_secret`) VALUES
(1, '1IAR3gfWhGOia0rBbGL8gOwJOZjr7mPG-U8oeQwd4DpgpnXM7Y');

-- --------------------------------------------------------

--
-- Table structure for table `territory_management`
--

CREATE TABLE `territory_management` (
  `id` int(11) NOT NULL,
  `territory_name` varchar(100) NOT NULL,
  `territory_poc_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `territory_management`
--

INSERT INTO `territory_management` (`id`, `territory_name`, `territory_poc_id`, `area_id`) VALUES
(8, 'asds', 38, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ams`
--
ALTER TABLE `ams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area_management`
--
ALTER TABLE `area_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalogues`
--
ALTER TABLE `catalogues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalogue_assignment`
--
ALTER TABLE `catalogue_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_session`
--
ALTER TABLE `ci_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `employees_info`
--
ALTER TABLE `employees_info`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employee_session`
--
ALTER TABLE `employee_session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_session` (`session`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_contents`
--
ALTER TABLE `order_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regions_info`
--
ALTER TABLE `regions_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retailers_details`
--
ALTER TABLE `retailers_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_secret_key`
--
ALTER TABLE `service_secret_key`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `territory_management`
--
ALTER TABLE `territory_management`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ams`
--
ALTER TABLE `ams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `area_management`
--
ALTER TABLE `area_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `catalogues`
--
ALTER TABLE `catalogues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `catalogue_assignment`
--
ALTER TABLE `catalogue_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `employees_info`
--
ALTER TABLE `employees_info`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `employee_session`
--
ALTER TABLE `employee_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=464;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `order_contents`
--
ALTER TABLE `order_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `regions_info`
--
ALTER TABLE `regions_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retailers_details`
--
ALTER TABLE `retailers_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_secret_key`
--
ALTER TABLE `service_secret_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `territory_management`
--
ALTER TABLE `territory_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
