-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2018 at 10:05 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apartment`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `id` int(11) NOT NULL,
  `building_name` varchar(45) NOT NULL,
  `building_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `address` varchar(45) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `logo` varchar(45) DEFAULT NULL,
  `electric` int(11) NOT NULL COMMENT 'ค่าไฟฟ้าต่อหน่วย',
  `water` int(11) NOT NULL COMMENT 'ค่าน้ำต่อหน่วย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ตารางค่าไฟ ค่าน้ำ';

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `address`, `phone`, `logo`, `electric`, `water`) VALUES
(1, 'MGS IT Solution', '57 ม.12 ต.เมืองปราสาท อ.โนนสูง จ.นครราชสีมา', '085-0970766', '', 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(45) NOT NULL COMMENT 'ชื่อ-นามสกุล',
  `address` text NOT NULL COMMENT 'ที่อยู่',
  `work_address` text COMMENT 'สถานที่ทำงาน',
  `phone` varchar(45) NOT NULL COMMENT 'เบอร์ติดต่อ',
  `citizen` varchar(45) NOT NULL COMMENT 'รหัสบัตรประชาชน',
  `gender` enum('ชาย','หญิง') DEFAULT NULL COMMENT 'เพศ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ผู้เช่า';

-- --------------------------------------------------------

--
-- Table structure for table `energies`
--

CREATE TABLE `energies` (
  `id` int(11) NOT NULL,
  `peroid` date NOT NULL COMMENT 'รอบเดือน',
  `water_unit` int(11) NOT NULL COMMENT 'เลขมิเตอร์น้ำ',
  `electric_unit` int(11) NOT NULL COMMENT 'เลขมิเตอร์ไฟฟ้า',
  `rooms_id` int(11) NOT NULL COMMENT 'ห้อง',
  `users_id` int(11) NOT NULL COMMENT 'ผู้จดบันทึก',
  `record_date` datetime NOT NULL COMMENT 'วันที่บันทึก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='บันทึกหน่วยไฟฟ้าน้ำปะปา';

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expenses_1` varchar(200) NOT NULL COMMENT 'ค่าใช้จ่าย',
  `expenses_1_price` int(11) NOT NULL,
  `expenses_2` varchar(200) DEFAULT NULL COMMENT 'ค่าใช้จ่าย',
  `expenses_2_price` int(11) DEFAULT NULL,
  `expenses_3` varchar(200) DEFAULT NULL COMMENT 'ค่าใช้จ่าย',
  `expenses_3_price` int(11) DEFAULT NULL,
  `expenses_4` varchar(200) DEFAULT NULL COMMENT 'ค่าใช้จ่าย',
  `expenses_4_price` int(11) DEFAULT NULL,
  `expenses_5` varchar(200) DEFAULT NULL COMMENT 'ค่าใช้จ่าย',
  `expenses_5_price` int(11) DEFAULT NULL,
  `expenses_6` varchar(200) DEFAULT NULL,
  `expenses_6_price` int(11) DEFAULT NULL,
  `expenses_7` varchar(200) DEFAULT NULL,
  `expenses_7_price` int(11) DEFAULT NULL,
  `expenses_8` varchar(200) DEFAULT NULL,
  `expenses_8_price` int(11) DEFAULT NULL,
  `expenses_9` varchar(200) DEFAULT NULL,
  `expenses_9_price` int(11) DEFAULT NULL,
  `expenses_10` varchar(200) DEFAULT NULL,
  `expenses_10_price` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL COMMENT 'รวมค่าใช้จ่าย',
  `date_record` date DEFAULT NULL COMMENT 'วันที่บึนทึก',
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='รายจ่าย';

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` varchar(25) NOT NULL,
  `leasing_id` varchar(25) NOT NULL COMMENT 'เลขที่สัญญา',
  `rooms_id` int(11) NOT NULL COMMENT 'ห้องพัก',
  `deposit` int(11) DEFAULT NULL COMMENT 'ค่าประกันห้อง',
  `rental` int(11) NOT NULL COMMENT 'ค่าห้อง',
  `electric_unit_from` int(11) NOT NULL COMMENT 'หน่วยไฟฟ้าครั้งก่อน',
  `electric_unit_to` int(11) NOT NULL COMMENT 'หน่วยไฟฟ้าล่าสุด',
  `electric_price` int(11) NOT NULL COMMENT 'ค่าไฟฟ้า',
  `water_unit_from` int(11) NOT NULL COMMENT 'หน่วยน้ำปะปาครั้งก่อน',
  `water_unit_to` int(11) NOT NULL COMMENT 'หน่วยน้ำปะปาครั้งล่าสุด',
  `water_price` int(11) NOT NULL COMMENT 'ค่าน้ำ',
  `additional_1` varchar(100) DEFAULT NULL COMMENT 'ค่าใช้จ่ายเพิ่มเติม',
  `additional_1_price` int(11) DEFAULT NULL COMMENT 'บาท',
  `additional_2` varchar(100) DEFAULT NULL COMMENT 'ค่าใช้จ่ายเพิ่มเติม',
  `additional_2_price` int(11) DEFAULT NULL COMMENT 'บาท',
  `additional_3` varchar(100) DEFAULT NULL COMMENT 'ค่าใช้จ่ายเพิ่มเติม',
  `additional_3_price` int(11) DEFAULT NULL COMMENT 'บาท',
  `additional_4` varchar(100) DEFAULT NULL COMMENT 'ค่าใช้จ่ายเพิ่มเติม',
  `additional_4_price` int(11) DEFAULT NULL COMMENT 'บาท',
  `additional_5` varchar(100) DEFAULT NULL COMMENT 'ค่าใช้จ่ายเพิ่มเติม',
  `additional_5_price` int(11) DEFAULT NULL COMMENT 'บาท',
  `refun_1` varchar(100) DEFAULT NULL COMMENT 'คืนเงิน',
  `refun_1_price` int(11) DEFAULT NULL COMMENT 'คืนเงิน',
  `refun_2` varchar(100) DEFAULT NULL COMMENT 'คืนเงิน',
  `refun_2_price` int(11) DEFAULT NULL COMMENT 'คืนเงิน',
  `total` int(11) NOT NULL COMMENT 'รวม',
  `comment` varchar(255) DEFAULT NULL COMMENT 'หมายเหตุ',
  `appointment` date NOT NULL COMMENT 'วันกำหนดชำระ',
  `status` enum('รอการชำระ','ชำระแล้ว') NOT NULL DEFAULT 'รอการชำระ' COMMENT 'สถานะการชำระ',
  `users_id` int(11) NOT NULL,
  `invoice_date` datetime NOT NULL COMMENT 'วันที่ออกใบแจ้งหนี้'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ใบแจ้งหนี้';

-- --------------------------------------------------------

--
-- Table structure for table `leasing`
--

CREATE TABLE `leasing` (
  `id` varchar(25) NOT NULL,
  `leasing_code` varchar(100) DEFAULT NULL COMMENT 'เลขที่สัญญา',
  `move_in` date NOT NULL COMMENT 'วันที่ย้ายเข้า',
  `move_out` date DEFAULT NULL COMMENT 'วันที่ย้ายออก',
  `users_id` int(11) NOT NULL,
  `rooms_id` int(11) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `leasing_date` datetime NOT NULL COMMENT 'วันที่บันทึก',
  `status` enum('IN','OUT','CANCEL') NOT NULL DEFAULT 'IN' COMMENT 'สถานะสัญญาเช่า',
  `comment` text COMMENT 'หมายเหตุ',
  `deposit` int(11) DEFAULT NULL COMMENT 'ค่าประกันห้อง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='รายการเช่า';

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `id` varchar(25) NOT NULL,
  `leasing_id` varchar(25) NOT NULL,
  `rental` int(11) NOT NULL COMMENT 'ค่าเช่า',
  `deposit` int(11) NOT NULL COMMENT 'ค่าประกันห้อง',
  `electric_price` int(11) NOT NULL DEFAULT '0' COMMENT 'ค่าไฟฟ้า',
  `water_price` int(11) NOT NULL DEFAULT '0' COMMENT 'ค่าน้ำ',
  `additional_1` varchar(100) DEFAULT NULL COMMENT 'ค่าใช้จ่ายเพิ่มเติม',
  `additional_1_price` int(11) DEFAULT NULL,
  `additional_2` varchar(100) DEFAULT NULL,
  `additional_2_price` int(11) DEFAULT NULL,
  `additional_3` varchar(100) DEFAULT NULL,
  `additional_3_price` int(11) DEFAULT NULL,
  `additional_4` varchar(100) DEFAULT NULL,
  `additional_4_price` int(11) DEFAULT NULL,
  `additional_5` varchar(100) DEFAULT NULL,
  `additional_5_price` int(11) DEFAULT NULL,
  `refun_1` varchar(100) DEFAULT NULL,
  `refun_1_price` int(11) DEFAULT NULL,
  `refun_2` varchar(100) DEFAULT NULL,
  `refun_2_price` int(11) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL COMMENT 'หมายเหตุ',
  `invoice_id` varchar(25) NOT NULL,
  `users_id` int(11) NOT NULL,
  `receipt_date` datetime DEFAULT NULL COMMENT 'วันที่ชำระ',
  `status` enum('void','normal') NOT NULL DEFAULT 'normal' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='รายการชำระ';

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL COMMENT 'รหัสห้อง',
  `name` varchar(45) NOT NULL COMMENT 'ชื่อห้อง/เลขห้อง',
  `monthly_price` int(11) NOT NULL COMMENT 'ราคาต่อเเดือน',
  `deposit` int(11) DEFAULT NULL COMMENT 'ค่าประกันห้อง',
  `details` text COMMENT 'รายละเอียดห้อง',
  `type` enum('ห้องแอร์','ห้องพัดลม') NOT NULL DEFAULT 'ห้องพัดลม' COMMENT 'ประเภทห้อง',
  `daily_price` int(11) DEFAULT NULL COMMENT 'ราคารายวัน',
  `building_id` int(11) NOT NULL COMMENT 'ตึก/อาคาร',
  `status` enum('ว่าง','ไม่ว่าง') NOT NULL DEFAULT 'ว่าง' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ห้องพัก';

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL COMMENT 'ชื่อผู้ใช้งาน',
  `password` varchar(300) NOT NULL COMMENT 'รหัสผ่าน',
  `fullname` varchar(100) NOT NULL COMMENT 'ชื่อ-นามสกุล',
  `role` enum('user','admin') NOT NULL DEFAULT 'user' COMMENT 'สิทธิ์การใช้งาน',
  `status` enum('active','suspend') NOT NULL DEFAULT 'active' COMMENT 'สถานะ',
  `authKey` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ผู้ใช้งาน';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `role`, `status`, `authKey`) VALUES
(2, 'admin', '$2y$13$j8jQ377hd.LzeX37p1FTNem4X7ju5LLdLBZf4lNnUfYd5cOiJyO.e', 'ผู้ดูแลระบบ', 'admin', 'active', 'FG8ssmgy94xZd1MeOYj_g3fezL0c8ZHO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `energies`
--
ALTER TABLE `energies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_energies_rooms1_idx` (`rooms_id`),
  ADD KEY `fk_energies_users1_idx` (`users_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_expenses_users1_idx` (`users_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payments_leasing1_idx` (`leasing_id`),
  ADD KEY `fk_invoice_users1_idx` (`users_id`) USING BTREE;

--
-- Indexes for table `leasing`
--
ALTER TABLE `leasing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rents_users1_idx` (`users_id`),
  ADD KEY `fk_rents_rooms1_idx` (`rooms_id`),
  ADD KEY `fk_rents_customers1_idx` (`customers_id`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payments_leasing1_idx` (`leasing_id`),
  ADD KEY `fk_receipt_invoice1_idx` (`invoice_id`),
  ADD KEY `fk_receipt_users1_idx` (`users_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD KEY `fk_rooms_building1_idx` (`building_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `energies`
--
ALTER TABLE `energies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสห้อง';
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `energies`
--
ALTER TABLE `energies`
  ADD CONSTRAINT `fk_energies_rooms1` FOREIGN KEY (`rooms_id`) REFERENCES `rooms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_energies_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `fk_expenses_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk_invoice_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_payments_leasing10` FOREIGN KEY (`leasing_id`) REFERENCES `leasing` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leasing`
--
ALTER TABLE `leasing`
  ADD CONSTRAINT `fk_rents_customers1` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rents_rooms1` FOREIGN KEY (`rooms_id`) REFERENCES `rooms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rents_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `receipt`
--
ALTER TABLE `receipt`
  ADD CONSTRAINT `fk_payments_leasing1` FOREIGN KEY (`leasing_id`) REFERENCES `leasing` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_receipt_invoice1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_receipt_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fk_rooms_building1` FOREIGN KEY (`building_id`) REFERENCES `building` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
