CREATE DATABASE IF NOT EXISTS petshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- Drop database petshop;
-- Use the database
USE petshop;
--
-- Database: `petshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `IDadmin` int(11) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`IDadmin`, `username`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'kien', '0708'),
(3, 'khoa', '0690'),
(4, 'kiet', '0722'),
(5, 'kha', '0597'),
(6,'1','1');
-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `IDbooking` int(11) NOT NULL,
  `time_arrival` datetime DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `booking_status` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`IDbooking`, `time_arrival`, `phone_number`, `booking_status`) VALUES
(1, '2024-04-25 10:00:00', 123456789, 'Đợi'),
(2, '2024-04-26 11:00:00', 987654321, 'Đã đến'),
(3, '2024-05-08 10:00:00', 22222, 'Đã đến'),
(4, '2024-05-08 11:04:00', 9292929, 'Đã đến'),
(5, '2024-05-08 12:04:00', 64466363, 'Đã đến'),
(7, '2024-05-08 13:17:00', 336091630, 'Đã đến'),
(12, '2024-05-08 14:25:00', 93838838, 'Đã đến'),
(14, '2024-05-08 14:29:00', 336091630, 'Đã đến'),
(15, '2024-05-08 14:30:00', 8882828, 'Đợi'),
(16, '2024-05-09 15:06:00', 38388383, 'Đợi'),
(17, '2024-05-09 15:09:00', 838373, 'Đợi'),
(18, '2024-05-09 15:10:00', 352003083, 'Đã đến'),
(19, '2024-05-09 15:12:00', 1234567890, 'Đợi'),
(20, '2024-05-09 15:16:00', 2147483647, 'Đợi');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `IDCustomer` int(11) NOT NULL,
  `Name_customer` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Diachi` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`IDCustomer`, `Name_customer`, `DateOfBirth`, `Diachi`, `PhoneNumber`, `email`) VALUES
(1, 'John Doe', '2024-05-01', 'TP HCM', 123456789, 'john@example.com'),
(2, 'Jane Smith', '2024-05-02', 'TP HCM', 987654321, 'jane@example.com'),
(3, 'lll', '2024-05-08', 'TP HCM', 336091630, 'kien@gmail.com'),
(4, 'iii', '2024-05-08', 'TP HCM', 22222, 'ddd@gmail.com'),
(5, 'bbrbrbrbbr', '2024-05-08', 'TP HCM', 9292929, 'lll@gmail.com'),
(6, 'www', '2024-05-08', 'TP HCM', 29299, 'ppp@gmail.com'),
(7, 'oooo', '2024-05-08', 'TP HCM', 3030, 'cc@gmail.com'),
(8, 'hdhdhd', '2024-05-25', 'TP HCM', 200, 'l123@gmail.com'),
(9, 'ieiie', '2024-05-25', 'TP HCM', 201, '321@gmail.com'),
(10, 'ieii3', '2024-05-08', 'TP HCM', 202, '3333@gmail.com'),
(11, 'ieii4', '2024-05-08', 'TP HCM', 203, 'ldld4@gmail.com');
-- --------------------------------------------------------

--
-- Table structure for table `history_feedback`
--

CREATE TABLE `history_feedback` (
  `IDCustomer` int(11) NOT NULL,
  `ID_service` int(11) NOT NULL,
  `point_feedback` int(11) DEFAULT NULL,
  `comment_feedback` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ;

--
-- Dumping data for table `history_feedback`
--

INSERT INTO `history_feedback` (`IDCustomer`, `ID_service`, `point_feedback`, `comment_feedback`) VALUES
( 1, 1, 5, 'Great service!'),
( 2, 2, 4, 'Good experience.');

-- --------------------------------------------------------

--
-- Table structure for table `history_transaction`
--

CREATE TABLE `history_transaction` (
  `IDtrans` int(11) NOT NULL,
  `IDCustomer` int(11) DEFAULT NULL,
  `ID_service` int(11) DEFAULT NULL,
  `IDpet` int(11) DEFAULT NULL,
  `time_trans` datetime DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
    `Status` varchar(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `history_transaction`
--

INSERT INTO `history_transaction` (`IDtrans`, `IDCustomer`, `ID_service`, `IDpet`, `time_trans`, `total_price`,`Status`) VALUES
(1, 1, 1, 1, '2024-04-25 10:30:00', 50000, 'chưa thanh toán'),
(2, 3, 2, 3, '2024-05-09 20:38:00', 111000,'chưa thanh toán');

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `IDpet` int(11) NOT NULL,
  `Pet_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pet_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pet_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `PhoneNumber_owner` varchar(20) DEFAULT NULL,
  `IDCustomer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`IDpet`, `Pet_type`, `pet_name`, `pet_img`, `PhoneNumber_owner`, `IDCustomer`) VALUES
(1, 'Mèo ', 'Mèo MS1', 'm1.jpg', 123456789, 1),
(2, 'Mèo', 'Mèo MS2', 'm2.jpg', 987654321, 2),
(3, 'Mèo', 'Mèo MS3', 'm3.jpg', 33333, 8),
(4, 'Mèo', 'Mèo MS4', 'm4.jpg', 383838, 1),
(5, 'Mèo', 'Mèo MS5', 'm5.jpg', 39399339, 4),
(6, 'Mèo', 'Mèo MS6', 'm6.jpg', 373737, 2),
(7, 'Mèo', 'Mèo MS7', 'm7.jpg', 37373733, 5),
(8, 'Chó', 'Chó MS1', 'c1.jpg', 7373773, 7),
(9, 'Chó', 'Chó MS2', 'c2.jpg', 277277, 10),
(10, 'Chó', 'Chó MS3', 'c3.jpg', 383838, 6),
(11, 'Chó', 'Chó MS4', 'c4.jpg', 399393939, 7),
(12, 'Chó', 'Chó MS5', 'c5.jpg', 111, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pet_pending`
--

CREATE TABLE `pet_pending` (
  `IDcome` int(11) NOT NULL,
  `time_coming` datetime DEFAULT NULL,
  `IDpet` int(11) DEFAULT NULL,
  `healt_status` char(10) DEFAULT NULL,
  `ID_service` int(11) DEFAULT NULL,
  `note` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `IDCustomer` int(11) DEFAULT NULL,
  `work_status` char(20) DEFAULT NULL
) ;

--
-- Dumping data for table `pet_pending`
--

INSERT INTO `pet_pending` (`IDcome`, `time_coming`, `IDpet`, `healt_status`, `ID_service`, `note`, `IDCustomer`, `work_status`) VALUES
(1, '2024-04-27 12:00:00', 1, 'Tốt', 1, 'Cần chải lông', 1, 'Đang tại shop'),
(2, '2024-04-28 13:00:00', 2, 'Ổn', 2, 'cần tiêm vác-xin', 2, 'Đã xong');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ID_service` int(11) NOT NULL,
  `name_service` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price_service` int(11) NOT NULL,
  `minute_serving` int(11) NOT NULL,
  `point_avg` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ID_service`, `name_service`, `price_service`, `minute_serving`, `point_avg`) VALUES
(1, 'Chải lông', 200000, 60, 5),
(2, 'Vaccin', 100000, 30, 4),
(3, 'Chăm sóc', 120000, 10, 5),
(4, 'Thức ăn', 20000, 10, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`IDadmin`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`IDbooking`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`IDCustomer`),
  ADD UNIQUE KEY `UC_cus` (`PhoneNumber`,`email`);

--
-- Indexes for table `history_feedback`
--
ALTER TABLE `history_feedback`
  ADD PRIMARY KEY (`IDCustomer`,`ID_service`);

--
-- Indexes for table `history_transaction`
--
ALTER TABLE `history_transaction`
  ADD PRIMARY KEY (`IDtrans`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`IDpet`);

--
-- Indexes for table `pet_pending`
--
ALTER TABLE `pet_pending`
  ADD PRIMARY KEY (`IDcome`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ID_service`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `IDadmin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `IDbooking` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `IDCustomer` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_transaction`
--
ALTER TABLE `history_transaction`
  MODIFY `IDtrans` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `IDpet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_pending`
--
ALTER TABLE `pet_pending`
  MODIFY `IDcome` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ID_service` int(11) NOT NULL AUTO_INCREMENT;

