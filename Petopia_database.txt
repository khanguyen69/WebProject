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
(1, '2024-04-25 10:00:00', '0123456789', 'Đợi'),
(2, '2024-04-26 11:00:00', '0987654321', 'Đã đến'),
(3, '2024-05-08 10:00:00', '0336091630', 'Đã đến'),
(4, '2024-05-08 11:04:00', '0937238491', 'Đã đến'),
(5, '2024-05-08 12:04:00', '0974558912', 'Đã đến'),
(6, '2024-05-08 13:17:00', '0988888888', 'Đã đến'),
(7, '2024-05-08 14:25:00', '0242453535', 'Đợi'),
(8, '2024-05-08 14:29:00', '0375384932', 'Đã đến'),
(9, '2024-05-08 14:30:00', '0123123123', 'Đợi'),
(10, '2024-05-09 15:06:00', '0976463231', 'Đợi'),
(11, '2024-05-10 12:00:00', '0990123456', 'Đợi'),
(12, '2024-05-10 13:00:00', '0901234567', 'Đợi'),
(13, '2024-05-11 09:00:00', '0912345678', 'Đã đến'),
(14, '2024-05-11 10:30:00', '0923456789', 'Đợi'),
(15, '2024-05-11 11:45:00', '0934567890', 'Đã đến'),
(16, '2024-05-11 14:00:00', '0945678901', 'Đợi'),
(17, '2024-05-11 15:30:00', '0956789012', 'Đã đến');



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
(1, 'John Doe', '1990-05-01', 'Atlanta', '0123456789', 'john@gmail.com'),
(2, 'Jane Smith', '1998-05-02', 'Chicago', '0987654321', 'jane@gmail.com'),
(3, 'Lipstick', '2004-05-08', 'Wichita', '0336091630', 'LamiGZ4@gmail.com'),
(4, 'Kasumi Taya', '2002-03-09', 'Osaka', '0736284912', 'Katzu@gmail.com'),
(5, 'Tiến Đạt', '2004-01-02', 'TP HCM', '0937238491', 'Dat09@gmail.com'),
(6, 'Hello', '2006-11-03', 'TP HCM', '0988888888', 'hi@hello.com'),
(7, 'Ngô Văn Tùng', '2004-02-19', 'Thủ Đức', '0974558912', 'Tung04@gmail.com'),
(8, 'Fumali Estagaba', '1982-02-01', 'Kangaba', '0242453535', 'Kamali@gmail.com'),
(9, 'Cam', '2002-02-27', 'KonTum', 	'0375384932', 'KTCam2k2@gmail.com'),
(10, 'Juice', '2008-07-31', 'Long An', '0528527345', 'Juicy2008@gmal.com'),
(11, '22520502', '2024-05-23', 'TP HCM', '0976463231', 'Helo@hi.com'),
(12,'Halfstack','1998-09-09','Đà Lạt', '0123123123','Huy1/2stack@gmail.com'),
(13, 'Nguyễn Văn A', '1985-04-23', '123 Đường Lê Lợi, Quận 1, TP.HCM', '0901234567', 'nguyenvana13@example.com'),
(14, 'Trần Thị B', '1990-08-15', '456 Đường Nguyễn Huệ, Quận 1, TP.HCM', '0912345678', 'tranthib14@example.com'),
(15, 'Lê Thị C', '1982-12-01', '789 Đường Hai Bà Trưng, Quận 3, TP.HCM', '0923456789', 'lethic15@example.com'),
(16, 'Phạm Văn D', '1975-06-20', '321 Đường Trần Hưng Đạo, Quận 5, TP.HCM', '0934567890', 'phamvand16@example.com'),
(17, 'Hoàng Thị E', '1995-11-30', '654 Đường Lý Tự Trọng, Quận 1, TP.HCM', '0945678901', 'hoangthie17@example.com'),
(18, 'Đặng Văn F', '1987-02-14', '987 Đường Võ Văn Kiệt, Quận 6, TP.HCM', '0956789012', 'dangvanf18@example.com'),
(19, 'Võ Thị G', '1992-09-25', '135 Đường Phan Xích Long, Quận Phú Nhuận, TP.HCM', '0967890123', 'vothig19@example.com'),
(20, 'Bùi Văn H', '1980-07-04', '246 Đường Trường Chinh, Quận Tân Bình, TP.HCM', '0978901234', 'buivanh20@example.com'),
(21, 'Đỗ Thị I', '1984-03-10', '357 Đường Điện Biên Phủ, Quận Bình Thạnh, TP.HCM', '0989012345', 'dothii21@example.com'),
(22, 'Lý Văn J', '1993-05-18', '468 Đường Nguyễn Văn Linh, Quận 7, TP.HCM', '0990123456', 'lyvanj22@example.com');
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
( 2, 2, 4, 'Good experience.'),
( 3, 3, 4, 'Nice!'),
( 4, 4, 5, 'Nutritious food.');

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
(1, 1, 1, 1, '2024-04-25 10:30:00', 300000, 'chưa thanh toán'),
(2, 7, 3, 7, '2024-05-09 20:38:00', 200000,'chưa thanh toán');

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
(1, 'Mèo', 'Mèo MS1', 'M1.jpg', '0123456789', 1),
(2, 'Mèo', 'Mèo MS2', 'M2.jpg', '0987654321', 2),
(3, 'Mèo', 'Mèo MS3', 'M3.jpg', '0242453535', 8),
(4, 'Mèo', 'Mèo MS4', 'M4.jpg', '0123456789', 1),
(5, 'Mèo', 'Mèo MS5', 'M5.jpg', '0736284912', 4),
(6, 'Mèo', 'Mèo MS6', 'M6.jpg', '0987654321', 2),
(7, 'Chó', 'Chó MS1', 'C1.jpg', '0974558912', 7),
(8, 'Chó', 'Chó MS2', 'C2.jpg', '0528527345', 10),
(9, 'Chó', 'Chó MS3', 'C3.jpg', '0988888888', 6),
(10, 'Chó', 'Chó MS4', 'C4.jpg', '0974558912', 7),
(11, 'Chó', 'Chó MS5', 'C5.jpg', '0987654321', 2),
(12, 'Chó', 'Chó MS6', 'C6.jpg', '0937238491', 5);


-- --------------------------------------------------------

--
-- Table structure for table `pet_pending`
--

CREATE TABLE `pet_pending` (
  `IDcome` int(11) ,
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
(1, '2024-04-27 12:00:00', 1, 'Tốt', 1, 'Cần tỉa lông', 1, 'Đang tại shop'),
(2, '2024-04-28 13:00:00', 2, 'Ổn', 2, 'Cần tiêm vác-xin', 2, 'Đã xong');

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
(1, 'Làm đẹp', 300000, 120, 5),
(2, 'Vaccin', 150000, 15, 4),
(3, 'Chăm sóc', 200000, 90, 5),
(4, 'Thức ăn', 30000, 20, 3);

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

