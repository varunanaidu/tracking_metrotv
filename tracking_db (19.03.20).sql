-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 19, 2020 at 08:16 AM
-- Server version: 5.5.56-MariaDB
-- PHP Version: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tracking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `loglogin`
--

CREATE TABLE `loglogin` (
  `id` int(11) NOT NULL,
  `cempnip` varchar(20) CHARACTER SET latin1 NOT NULL,
  `ip_address` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `browser` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `log_login` datetime DEFAULT NULL,
  `latitude` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `longitude` varchar(20) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tab_courier`
--

CREATE TABLE `tab_courier` (
  `CourierID` int(11) NOT NULL,
  `CourierCode` varchar(10) NOT NULL,
  `CourierName` varchar(100) NOT NULL,
  `CourierStatus` int(11) NOT NULL DEFAULT '1' COMMENT '1= External ; 2 = Internal',
  `isActive` int(11) NOT NULL DEFAULT '1' COMMENT '1 = active ; 2 = disabled',
  `EntryBy` varchar(100) NOT NULL,
  `EntryBy_date` datetime NOT NULL,
  `EditBy` int(100) DEFAULT NULL,
  `EditBy_date` datetime DEFAULT NULL,
  `DeleteBy` int(100) DEFAULT NULL,
  `DeleteBy_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_courier`
--

INSERT INTO `tab_courier` (`CourierID`, `CourierCode`, `CourierName`, `CourierStatus`, `isActive`, `EntryBy`, `EntryBy_date`, `EditBy`, `EditBy_date`, `DeleteBy`, `DeleteBy_date`) VALUES
(1, 'C001', 'Courier 1', 1, 1, '1193748', '2020-02-04 11:52:13', 1193748, '2020-02-05 10:22:34', NULL, NULL),
(2, 'C002', 'Courier 2', 2, 1, '1193748', '2020-02-04 11:52:23', 1193748, '2020-02-05 10:22:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tab_invoice`
--

CREATE TABLE `tab_invoice` (
  `InvID` int(11) NOT NULL,
  `InvType` int(11) NOT NULL COMMENT '0 = Manual ; 1 = BMS',
  `InvNo` varchar(100) NOT NULL,
  `PONo` varchar(100) NOT NULL,
  `PO_Type` varchar(255) NOT NULL,
  `AgencyName` varchar(255) DEFAULT NULL,
  `AgencyAddr` varchar(255) DEFAULT NULL,
  `AgencyTelp` varchar(255) DEFAULT NULL,
  `AdvertiserName` varchar(255) DEFAULT NULL,
  `AdvertiserAddr` varchar(255) DEFAULT NULL,
  `AdvertiserTelp` varchar(255) DEFAULT NULL,
  `ProductName` varchar(255) DEFAULT NULL,
  `BillingType` varchar(255) NOT NULL,
  `AE_Name` varchar(255) DEFAULT NULL,
  `IsSentToCourier` int(11) DEFAULT NULL COMMENT '0 = Send ; 1 = Unsend',
  `AgencyDisc` int(11) DEFAULT NULL,
  `Nett` int(11) DEFAULT NULL,
  `Gross` int(11) DEFAULT NULL,
  `ReferTo_BMSInvoice` int(11) DEFAULT NULL COMMENT '0 = YES ; 1 = NO',
  `isDirectClient` int(11) DEFAULT NULL COMMENT '0 = YES ; 1 = NO',
  `PeriodMonth` int(11) NOT NULL,
  `PeriodYear` int(11) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Active ; 1 = Deleted',
  `EntryBy` int(11) NOT NULL,
  `EntryBy_date` datetime NOT NULL,
  `EditBy` int(11) DEFAULT NULL,
  `EditBy_date` datetime DEFAULT NULL,
  `DeleteBy` int(11) DEFAULT NULL,
  `DeleteBy_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tab_inv_sts`
--

CREATE TABLE `tab_inv_sts` (
  `InvStsID` int(11) NOT NULL,
  `InvStsCode` varchar(3) NOT NULL,
  `InvStsName` varchar(255) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Active ; 1 = Deleted',
  `EntryBy` varchar(100) NOT NULL,
  `EntryBy_date` datetime NOT NULL,
  `EditBy` varchar(100) DEFAULT NULL,
  `EditBy_date` datetime DEFAULT NULL,
  `DeleteBy` varchar(100) DEFAULT NULL,
  `DeleteBy_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_inv_sts`
--

INSERT INTO `tab_inv_sts` (`InvStsID`, `InvStsCode`, `InvStsName`, `isActive`, `EntryBy`, `EntryBy_date`, `EditBy`, `EditBy_date`, `DeleteBy`, `DeleteBy_date`) VALUES
(1, '0', 'Draft', 0, '1193748', '2020-02-10 15:48:02', '1193748', '2020-02-10 15:48:02', NULL, NULL),
(2, '1', 'Send By Billing', 0, '1193748', '2020-02-10 15:48:02', '1193748', '2020-02-10 15:48:02', NULL, NULL),
(3, '2', 'Received by GA', 0, '1193748', '2020-02-10 15:48:32', '1193748', '2020-02-10 15:48:32', NULL, NULL),
(4, '3A', 'PickUp By External Messenger', 0, '1193748', '2020-02-10 15:48:51', '1193748', '2020-02-10 15:48:51', NULL, NULL),
(5, '3B', 'PickUp By Internal Messenger', 0, '1193748', '2020-02-10 15:49:10', '1193748', '2020-02-10 15:49:10', NULL, NULL),
(6, '4A', 'Received by Client', 0, '1193748', '2020-02-10 15:49:26', '1193748', '2020-02-10 15:49:26', NULL, NULL),
(7, '4B', 'Direct Return by Client', 0, '1193748', '2020-02-10 15:49:40', '1193748', '2020-02-10 15:49:40', NULL, NULL),
(8, '5', 'Package Return', 0, '1193748', '2020-02-10 15:49:54', '1193748', '2020-02-12 16:43:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tab_nav`
--

CREATE TABLE `tab_nav` (
  `nav_id` int(11) NOT NULL,
  `nav_name` varchar(100) NOT NULL,
  `nav_ctr` varchar(100) NOT NULL,
  `nav_parent` int(11) NOT NULL,
  `nav_level` int(11) NOT NULL,
  `nav_order` int(11) NOT NULL,
  `dev_only` int(11) NOT NULL DEFAULT '0' COMMENT '0 = NO ; 1 = YES',
  `create_date` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `edited_date` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_nav`
--

INSERT INTO `tab_nav` (`nav_id`, `nav_name`, `nav_ctr`, `nav_parent`, `nav_level`, `nav_order`, `dev_only`, `create_date`, `create_by`, `edited_date`, `edited_by`) VALUES
(6, 'Developer', 'developer', 0, 0, 6, 1, '2020-01-31 16:03:04', 1193748, '2020-01-31 16:03:04', 1193748),
(7, 'Uac', 'uac', 6, 1, 2, 1, '2020-01-31 16:20:53', 1193748, '2020-01-31 16:20:53', 1193748),
(8, 'Navigation', 'navigations', 6, 1, 1, 1, '2020-01-31 16:21:06', 1193748, '2020-01-31 16:21:06', 1193748),
(10, 'Master', 'master', 0, 0, 4, 0, '2020-02-04 10:43:42', 1193755, '2020-02-04 10:43:42', 1193755),
(11, 'Courier', 'courier', 10, 1, 1, 0, '2020-02-04 10:44:08', 1193755, '2020-02-04 10:44:08', 1193755),
(12, 'Invoice Status', 'invoice_status', 10, 1, 2, 0, '2020-02-04 15:11:56', 1193748, '2020-02-04 15:11:56', 1193748),
(13, 'Deleted', 'deleted', 0, 0, 5, 0, '2020-02-05 09:06:57', 1193748, '2020-02-05 09:06:57', 1193748),
(14, 'Courier', 'courier/deleted', 13, 1, 1, 0, '2020-02-05 09:07:29', 1193748, '2020-02-05 09:07:29', 1193748),
(15, 'Invoice Status', 'invoice_status/deleted', 13, 1, 2, 0, '2020-02-05 09:08:00', 1193748, '2020-02-05 09:08:00', 1193748),
(16, 'Invoice', 'invoice', 0, 0, 2, 0, '2020-02-06 09:25:13', 1193748, '2020-02-06 09:25:13', 1193748),
(17, 'Manual', 'invoice/manual', 16, 1, 2, 0, '2020-02-06 09:25:54', 1193748, '2020-02-06 09:25:54', 1193748),
(18, 'BMS', 'invoice/bms', 16, 1, 3, 0, '2020-02-06 09:26:21', 1193748, '2020-02-06 09:26:21', 1193748),
(22, 'Dashboard', 'site', 0, 0, 1, 0, '2020-02-06 16:07:39', 1193748, '2020-02-06 16:07:39', 1193748),
(24, 'Dashboard', 'site', 22, 1, 1, 0, '2020-02-06 16:09:24', 1193748, '2020-02-06 16:09:24', 1193748),
(25, 'Manual Invoice', 'invoice/deleted_manual', 13, 1, 3, 0, '2020-02-10 14:46:53', 1193748, '2020-02-10 14:47:38', 1193748),
(26, 'BMS Invoice', 'invoice/deleted_bms', 13, 1, 4, 0, '2020-02-10 14:47:21', 1193748, '2020-02-10 14:47:21', 1193748),
(30, 'Tracking', '-', 0, 0, 3, 0, '2020-02-14 16:01:39', 1193748, '2020-02-14 16:01:39', 1193748),
(31, 'Approval', 'approval', 30, 1, 1, 0, '2020-02-14 16:01:59', 1193748, '2020-02-14 16:01:59', 1193748),
(33, 'Delivery', 'delivery', 30, 1, 3, 0, '2020-02-19 14:51:06', 1193748, '2020-02-19 14:51:06', 1193748),
(34, 'Received', 'received', 30, 1, 4, 0, '2020-02-19 16:18:43', 1193748, '2020-02-19 16:18:43', 1193748),
(35, 'All Invoice', 'invoice/all', 16, 1, 4, 0, '2020-03-05 09:10:43', 1193748, '2020-03-05 09:10:43', 1193748),
(36, 'Returned', 'returned', 30, 1, 5, 0, '2020-03-19 10:14:42', 1193748, '2020-03-19 10:24:29', 1193748);

-- --------------------------------------------------------

--
-- Table structure for table `tab_uac`
--

CREATE TABLE `tab_uac` (
  `user_id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `create_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tab_uac`
--

INSERT INTO `tab_uac` (`user_id`, `nav_id`, `create_date`, `create_by`) VALUES
(1020570, 6, '2020-03-02 10:14:10', 1193748),
(1153216, 6, '2020-03-13 09:50:57', 1193755),
(1193748, 6, '2020-03-19 10:17:45', 1193748),
(1193755, 6, '2020-03-09 15:47:07', 1193755),
(1020570, 7, '2020-03-02 10:14:10', 1193748),
(1153216, 7, '2020-03-13 09:50:57', 1193755),
(1193748, 7, '2020-03-19 10:17:45', 1193748),
(1193755, 7, '2020-03-09 15:47:07', 1193755),
(1020570, 8, '2020-03-02 10:14:10', 1193748),
(1153216, 8, '2020-03-13 09:50:57', 1193755),
(1193748, 8, '2020-03-19 10:17:45', 1193748),
(1193755, 8, '2020-03-09 15:47:07', 1193755),
(1020570, 10, '2020-03-02 10:14:10', 1193748),
(1153216, 10, '2020-03-13 09:50:57', 1193755),
(1193748, 10, '2020-03-19 10:17:45', 1193748),
(1193755, 10, '2020-03-09 15:47:07', 1193755),
(1020570, 11, '2020-03-02 10:14:10', 1193748),
(1153216, 11, '2020-03-13 09:50:57', 1193755),
(1193748, 11, '2020-03-19 10:17:45', 1193748),
(1193755, 11, '2020-03-09 15:47:07', 1193755),
(1020570, 12, '2020-03-02 10:14:10', 1193748),
(1153216, 12, '2020-03-13 09:50:57', 1193755),
(1193748, 12, '2020-03-19 10:17:45', 1193748),
(1193755, 12, '2020-03-09 15:47:07', 1193755),
(1020570, 13, '2020-03-02 10:14:10', 1193748),
(1153216, 13, '2020-03-13 09:50:57', 1193755),
(1193748, 13, '2020-03-19 10:17:45', 1193748),
(1193755, 13, '2020-03-09 15:47:07', 1193755),
(1020570, 14, '2020-03-02 10:14:10', 1193748),
(1153216, 14, '2020-03-13 09:50:57', 1193755),
(1193748, 14, '2020-03-19 10:17:45', 1193748),
(1193755, 14, '2020-03-09 15:47:07', 1193755),
(1020570, 15, '2020-03-02 10:14:10', 1193748),
(1153216, 15, '2020-03-13 09:50:57', 1193755),
(1193748, 15, '2020-03-19 10:17:45', 1193748),
(1193755, 15, '2020-03-09 15:47:07', 1193755),
(1020570, 16, '2020-03-02 10:14:10', 1193748),
(1153216, 16, '2020-03-13 09:50:57', 1193755),
(1193748, 16, '2020-03-19 10:17:45', 1193748),
(1193755, 16, '2020-03-09 15:47:07', 1193755),
(1020570, 17, '2020-03-02 10:14:10', 1193748),
(1153216, 17, '2020-03-13 09:50:57', 1193755),
(1193748, 17, '2020-03-19 10:17:45', 1193748),
(1193755, 17, '2020-03-09 15:47:07', 1193755),
(1020570, 18, '2020-03-02 10:14:10', 1193748),
(1153216, 18, '2020-03-13 09:50:57', 1193755),
(1193748, 18, '2020-03-19 10:17:45', 1193748),
(1193755, 18, '2020-03-09 15:47:07', 1193755),
(1020570, 22, '2020-03-02 10:14:10', 1193748),
(1153216, 22, '2020-03-13 09:50:57', 1193755),
(1193748, 22, '2020-03-19 10:17:45', 1193748),
(1193755, 22, '2020-03-09 15:47:07', 1193755),
(1020570, 24, '2020-03-02 10:14:10', 1193748),
(1153216, 24, '2020-03-13 09:50:57', 1193755),
(1193748, 24, '2020-03-19 10:17:45', 1193748),
(1193755, 24, '2020-03-09 15:47:07', 1193755),
(1020570, 25, '2020-03-02 10:14:10', 1193748),
(1153216, 25, '2020-03-13 09:50:57', 1193755),
(1193748, 25, '2020-03-19 10:17:45', 1193748),
(1193755, 25, '2020-03-09 15:47:07', 1193755),
(1020570, 26, '2020-03-02 10:14:10', 1193748),
(1153216, 26, '2020-03-13 09:50:57', 1193755),
(1193748, 26, '2020-03-19 10:17:45', 1193748),
(1193755, 26, '2020-03-09 15:47:07', 1193755),
(1020570, 30, '2020-03-02 10:14:10', 1193748),
(1153216, 30, '2020-03-13 09:50:57', 1193755),
(1193748, 30, '2020-03-19 10:17:45', 1193748),
(1193755, 30, '2020-03-09 15:47:07', 1193755),
(1020570, 31, '2020-03-02 10:14:10', 1193748),
(1153216, 31, '2020-03-13 09:50:57', 1193755),
(1193748, 31, '2020-03-19 10:17:45', 1193748),
(1193755, 31, '2020-03-09 15:47:07', 1193755),
(1020570, 32, '2020-03-02 10:14:10', 1193748),
(1020570, 33, '2020-03-02 10:14:10', 1193748),
(1153216, 33, '2020-03-13 09:50:57', 1193755),
(1193748, 33, '2020-03-19 10:17:45', 1193748),
(1193755, 33, '2020-03-09 15:47:07', 1193755),
(1020570, 34, '2020-03-02 10:14:10', 1193748),
(1153216, 34, '2020-03-13 09:50:57', 1193755),
(1193748, 34, '2020-03-19 10:17:45', 1193748),
(1193755, 34, '2020-03-09 15:47:07', 1193755),
(1153216, 35, '2020-03-13 09:50:57', 1193755),
(1193748, 35, '2020-03-19 10:17:45', 1193748),
(1193755, 35, '2020-03-09 15:47:07', 1193755),
(1193748, 36, '2020-03-19 10:17:45', 1193748);

-- --------------------------------------------------------

--
-- Table structure for table `tr_log_tracking`
--

CREATE TABLE `tr_log_tracking` (
  `ReceiptSendPkgID` int(11) NOT NULL,
  `ReceiptSendPkgName` varchar(255) DEFAULT NULL,
  `ReceiptSendPkgReceiver` varchar(255) DEFAULT NULL,
  `InvID` int(11) NOT NULL,
  `InvStsID` int(11) NOT NULL,
  `CourierID` int(11) DEFAULT NULL,
  `SendDate` datetime DEFAULT NULL,
  `ResiNoFromCourier` varchar(255) NOT NULL,
  `ReceiptPathFilename` varchar(255) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Active ; 1 = Deleted',
  `EntryBy` varchar(255) NOT NULL,
  `EntryBy_date` datetime NOT NULL,
  `EditBy` varchar(255) NOT NULL,
  `EditBy_date` datetime NOT NULL,
  `DeleteBy` varchar(255) DEFAULT NULL,
  `DeleteBy_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tr_tracking`
--

CREATE TABLE `tr_tracking` (
  `ReceiptSendPkgID` int(11) NOT NULL,
  `ReceiptSendPkgName` varchar(255) DEFAULT NULL,
  `ReceiptSendPkgReceiver` varchar(255) DEFAULT NULL,
  `InvID` int(11) NOT NULL,
  `InvStsID` int(11) NOT NULL,
  `CourierID` int(11) DEFAULT NULL,
  `SendDate` datetime DEFAULT NULL,
  `ResiNoFromCourier` varchar(255) NOT NULL,
  `ReceiptPathFilename` varchar(255) NOT NULL,
  `ReasonReturned` text,
  `isActive` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Active ; 1 = Deleted',
  `EntryBy` varchar(255) NOT NULL,
  `EntryBy_date` datetime NOT NULL,
  `EditBy` varchar(255) NOT NULL,
  `EditBy_date` datetime NOT NULL,
  `DeleteBy` varchar(255) DEFAULT NULL,
  `DeleteBy_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_all_delinvoice`
-- (See below for the actual view)
--
CREATE TABLE `vw_all_delinvoice` (
`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodMonth` int(11)
,`PeriodYear` int(11)
,`isActive` int(11)
,`EntryBy` int(11)
,`EntryBy_date` datetime
,`EditBy` int(11)
,`EditBy_date` datetime
,`DeleteBy` int(11)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_all_invoice`
-- (See below for the actual view)
--
CREATE TABLE `vw_all_invoice` (
`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodMonth` int(11)
,`PeriodYear` int(11)
,`isActive` int(11)
,`EntryBy` int(11)
,`EntryBy_date` datetime
,`EditBy` int(11)
,`EditBy_date` datetime
,`DeleteBy` int(11)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_bms_invoice`
-- (See below for the actual view)
--
CREATE TABLE `vw_bms_invoice` (
`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodMonth` int(11)
,`PeriodYear` int(11)
,`isActive` int(11)
,`EntryBy` int(11)
,`EntryBy_date` datetime
,`EditBy` int(11)
,`EditBy_date` datetime
,`DeleteBy` int(11)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_courier`
-- (See below for the actual view)
--
CREATE TABLE `vw_courier` (
`CourierID` int(11)
,`CourierCode` varchar(10)
,`CourierName` varchar(100)
,`CourierStatus` int(11)
,`isActive` int(11)
,`EntryBy` varchar(100)
,`EntryBy_date` datetime
,`EditBy` int(100)
,`EditBy_date` datetime
,`DeleteBy` int(100)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_delbms_invoice`
-- (See below for the actual view)
--
CREATE TABLE `vw_delbms_invoice` (
`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isActive` int(11)
,`EntryBy` int(11)
,`EntryBy_date` datetime
,`EditBy` int(11)
,`EditBy_date` datetime
,`DeleteBy` int(11)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_delinv_sts`
-- (See below for the actual view)
--
CREATE TABLE `vw_delinv_sts` (
`InvStsID` int(11)
,`InvStsCode` varchar(3)
,`InvStsName` varchar(255)
,`isActive` int(11)
,`EntryBy` varchar(100)
,`EntryBy_date` datetime
,`EditBy` varchar(100)
,`EditBy_date` datetime
,`DeleteBy` varchar(100)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_delmanual_invoice`
-- (See below for the actual view)
--
CREATE TABLE `vw_delmanual_invoice` (
`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isActive` int(11)
,`EntryBy` int(11)
,`EntryBy_date` datetime
,`EditBy` int(11)
,`EditBy_date` datetime
,`DeleteBy` int(11)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_deltracking`
-- (See below for the actual view)
--
CREATE TABLE `vw_deltracking` (
`ReceiptSendPkgID` int(11)
,`ReceiptSendPkgName` varchar(255)
,`ReceiptSendPkgReceiver` varchar(255)
,`SendDate` datetime
,`ResiNoFromCourier` varchar(255)
,`ReceiptPathFilename` varchar(255)
,`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodMonth` int(11)
,`PeriodYear` int(11)
,`InvStsID` int(11)
,`InvStsCode` varchar(3)
,`InvStsName` varchar(255)
,`CourierID` int(11)
,`CourierCode` varchar(10)
,`CourierName` varchar(100)
,`CourierStatus` int(11)
,`EntryBy` varchar(255)
,`EntryBy_date` datetime
,`EditBy` varchar(255)
,`EditBy_date` datetime
,`DeleteBy` varchar(255)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_inv_sts`
-- (See below for the actual view)
--
CREATE TABLE `vw_inv_sts` (
`InvStsID` int(11)
,`InvStsCode` varchar(3)
,`InvStsName` varchar(255)
,`isActive` int(11)
,`EntryBy` varchar(100)
,`EntryBy_date` datetime
,`EditBy` varchar(100)
,`EditBy_date` datetime
,`DeleteBy` varchar(100)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_manual_invoice`
-- (See below for the actual view)
--
CREATE TABLE `vw_manual_invoice` (
`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodMonth` int(11)
,`PeriodYear` int(11)
,`isActive` int(11)
,`EntryBy` int(11)
,`EntryBy_date` datetime
,`EditBy` int(11)
,`EditBy_date` datetime
,`DeleteBy` int(11)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_nav`
-- (See below for the actual view)
--
CREATE TABLE `vw_nav` (
`nav_id` int(11)
,`nav_name` varchar(100)
,`nav_ctr` varchar(100)
,`nav_parent` int(11)
,`nav_level` int(11)
,`nav_order` int(11)
,`dev_only` int(11)
,`create_date` datetime
,`create_by` int(11)
,`edited_date` datetime
,`edited_by` int(11)
,`parent_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_pick_messenger_invoices`
-- (See below for the actual view)
--
CREATE TABLE `vw_pick_messenger_invoices` (
`ReceiptSendPkgID` int(11)
,`ReceiptSendPkgName` varchar(255)
,`ReceiptSendPkgReceiver` varchar(255)
,`SendDate` datetime
,`ResiNoFromCourier` varchar(255)
,`ReceiptPathFilename` varchar(255)
,`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodYear` int(11)
,`PeriodMonth` int(11)
,`CourierID` int(11)
,`CourierCode` varchar(10)
,`CourierName` varchar(100)
,`CourierStatus` int(11)
,`InvStsID` int(11)
,`InvStsCode` varchar(3)
,`InvStsName` varchar(255)
,`EntryBy` varchar(255)
,`EntryBy_date` datetime
,`EditBy` varchar(255)
,`EditBy_date` datetime
,`DeleteBy` varchar(255)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_ready_to_send_invoices`
-- (See below for the actual view)
--
CREATE TABLE `vw_ready_to_send_invoices` (
`ReceiptSendPkgID` int(11)
,`ReceiptSendPkgName` varchar(255)
,`ReceiptSendPkgReceiver` varchar(255)
,`SendDate` datetime
,`ResiNoFromCourier` varchar(255)
,`ReceiptPathFilename` varchar(255)
,`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodMonth` int(11)
,`PeriodYear` int(11)
,`InvStsID` int(11)
,`InvStsCode` varchar(3)
,`InvStsName` varchar(255)
,`CourierID` int(11)
,`CourierCode` varchar(10)
,`CourierName` varchar(100)
,`CourierStatus` int(11)
,`EntryBy` varchar(255)
,`EntryBy_date` datetime
,`EditBy` varchar(255)
,`EditBy_date` datetime
,`DeleteBy` varchar(255)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_received_by_client_invoices`
-- (See below for the actual view)
--
CREATE TABLE `vw_received_by_client_invoices` (
`ReceiptSendPkgID` int(11)
,`ReceiptSendPkgName` varchar(255)
,`ReceiptSendPkgReceiver` varchar(255)
,`SendDate` datetime
,`ResiNoFromCourier` varchar(255)
,`ReceiptPathFilename` varchar(255)
,`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodMonth` int(11)
,`PeriodYear` int(11)
,`InvStsID` int(11)
,`InvStsCode` varchar(3)
,`InvStsName` varchar(255)
,`CourierID` int(11)
,`CourierCode` varchar(10)
,`CourierName` varchar(100)
,`CourierStatus` int(11)
,`EntryBy` varchar(255)
,`EntryBy_date` datetime
,`EditBy` varchar(255)
,`EditBy_date` datetime
,`DeleteBy` varchar(255)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_received_by_ga_invoices`
-- (See below for the actual view)
--
CREATE TABLE `vw_received_by_ga_invoices` (
`ReceiptSendPkgID` int(11)
,`ReceiptSendPkgName` varchar(255)
,`ResiNoFromCourier` varchar(255)
,`ReceiptPathFilename` varchar(255)
,`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodYear` int(11)
,`PeriodMonth` int(11)
,`CourierID` int(11)
,`CourierCode` varchar(10)
,`CourierName` varchar(100)
,`CourierStatus` int(11)
,`InvStsID` int(11)
,`InvStsCode` varchar(3)
,`InvStsName` varchar(255)
,`EntryBy` varchar(255)
,`EntryBy_date` datetime
,`EditBy` varchar(255)
,`EditBy_date` datetime
,`DeleteBy` varchar(255)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_returned_invoices`
-- (See below for the actual view)
--
CREATE TABLE `vw_returned_invoices` (
`ReceiptSendPkgID` int(11)
,`ReceiptSendPkgName` varchar(255)
,`ReceiptSendPkgReceiver` varchar(255)
,`SendDate` datetime
,`ResiNoFromCourier` varchar(255)
,`ReceiptPathFilename` varchar(255)
,`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodMonth` int(11)
,`PeriodYear` int(11)
,`InvStsID` int(11)
,`InvStsCode` varchar(3)
,`InvStsName` varchar(255)
,`CourierID` int(11)
,`CourierCode` varchar(10)
,`CourierName` varchar(100)
,`CourierStatus` int(11)
,`EntryBy` varchar(255)
,`EntryBy_date` datetime
,`EditBy` varchar(255)
,`EditBy_date` datetime
,`DeleteBy` varchar(255)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_send_by_billing_invoices`
-- (See below for the actual view)
--
CREATE TABLE `vw_send_by_billing_invoices` (
`ReceiptSendPkgID` int(11)
,`ReceiptSendPkgName` varchar(255)
,`ReceiptSendPkgReceiver` varchar(255)
,`SendDate` datetime
,`ResiNoFromCourier` varchar(255)
,`ReceiptPathFilename` varchar(255)
,`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodMonth` int(11)
,`PeriodYear` int(11)
,`InvStsID` int(11)
,`InvStsCode` varchar(3)
,`InvStsName` varchar(255)
,`CourierID` int(11)
,`CourierCode` varchar(10)
,`CourierName` varchar(100)
,`CourierStatus` int(11)
,`EntryBy` varchar(255)
,`EntryBy_date` datetime
,`EditBy` varchar(255)
,`EditBy_date` datetime
,`DeleteBy` varchar(255)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_tracking`
-- (See below for the actual view)
--
CREATE TABLE `vw_tracking` (
`ReceiptSendPkgID` int(11)
,`ReceiptSendPkgName` varchar(255)
,`ReceiptSendPkgReceiver` varchar(255)
,`SendDate` datetime
,`ResiNoFromCourier` varchar(255)
,`ReceiptPathFilename` varchar(255)
,`InvID` int(11)
,`InvType` int(11)
,`InvNo` varchar(100)
,`PONo` varchar(100)
,`PO_Type` varchar(255)
,`AgencyName` varchar(255)
,`AgencyAddr` varchar(255)
,`AgencyTelp` varchar(255)
,`AdvertiserName` varchar(255)
,`AdvertiserAddr` varchar(255)
,`AdvertiserTelp` varchar(255)
,`ProductName` varchar(255)
,`BillingType` varchar(255)
,`AE_Name` varchar(255)
,`IsSentToCourier` int(11)
,`AgencyDisc` int(11)
,`Nett` int(11)
,`Gross` int(11)
,`ReferTo_BMSInvoice` int(11)
,`isDirectClient` int(11)
,`PeriodMonth` int(11)
,`PeriodYear` int(11)
,`InvStsID` int(11)
,`InvStsCode` varchar(3)
,`InvStsName` varchar(255)
,`CourierID` int(11)
,`CourierCode` varchar(10)
,`CourierName` varchar(100)
,`CourierStatus` int(11)
,`EntryBy` varchar(255)
,`EntryBy_date` datetime
,`EditBy` varchar(255)
,`EditBy_date` datetime
,`DeleteBy` varchar(255)
,`DeleteBy_date` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_uac`
-- (See below for the actual view)
--
CREATE TABLE `vw_uac` (
`user_id` int(11)
,`nav_id` int(11)
,`nav_name` varchar(100)
,`nav_ctr` varchar(100)
,`nav_parent` int(11)
,`nav_level` int(11)
,`nav_order` int(11)
,`dev_only` int(11)
,`parent_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_all_delinvoice`
--
DROP TABLE IF EXISTS `vw_all_delinvoice`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_all_delinvoice`  AS  select `tab_invoice`.`InvID` AS `InvID`,`tab_invoice`.`InvType` AS `InvType`,`tab_invoice`.`InvNo` AS `InvNo`,`tab_invoice`.`PONo` AS `PONo`,`tab_invoice`.`PO_Type` AS `PO_Type`,`tab_invoice`.`AgencyName` AS `AgencyName`,`tab_invoice`.`AgencyAddr` AS `AgencyAddr`,`tab_invoice`.`AgencyTelp` AS `AgencyTelp`,`tab_invoice`.`AdvertiserName` AS `AdvertiserName`,`tab_invoice`.`AdvertiserAddr` AS `AdvertiserAddr`,`tab_invoice`.`AdvertiserTelp` AS `AdvertiserTelp`,`tab_invoice`.`ProductName` AS `ProductName`,`tab_invoice`.`BillingType` AS `BillingType`,`tab_invoice`.`AE_Name` AS `AE_Name`,`tab_invoice`.`IsSentToCourier` AS `IsSentToCourier`,`tab_invoice`.`AgencyDisc` AS `AgencyDisc`,`tab_invoice`.`Nett` AS `Nett`,`tab_invoice`.`Gross` AS `Gross`,`tab_invoice`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`tab_invoice`.`isDirectClient` AS `isDirectClient`,`tab_invoice`.`PeriodMonth` AS `PeriodMonth`,`tab_invoice`.`PeriodYear` AS `PeriodYear`,`tab_invoice`.`isActive` AS `isActive`,`tab_invoice`.`EntryBy` AS `EntryBy`,`tab_invoice`.`EntryBy_date` AS `EntryBy_date`,`tab_invoice`.`EditBy` AS `EditBy`,`tab_invoice`.`EditBy_date` AS `EditBy_date`,`tab_invoice`.`DeleteBy` AS `DeleteBy`,`tab_invoice`.`DeleteBy_date` AS `DeleteBy_date` from `tab_invoice` where (`tab_invoice`.`isActive` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_all_invoice`
--
DROP TABLE IF EXISTS `vw_all_invoice`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_all_invoice`  AS  select `tab_invoice`.`InvID` AS `InvID`,`tab_invoice`.`InvType` AS `InvType`,`tab_invoice`.`InvNo` AS `InvNo`,`tab_invoice`.`PONo` AS `PONo`,`tab_invoice`.`PO_Type` AS `PO_Type`,`tab_invoice`.`AgencyName` AS `AgencyName`,`tab_invoice`.`AgencyAddr` AS `AgencyAddr`,`tab_invoice`.`AgencyTelp` AS `AgencyTelp`,`tab_invoice`.`AdvertiserName` AS `AdvertiserName`,`tab_invoice`.`AdvertiserAddr` AS `AdvertiserAddr`,`tab_invoice`.`AdvertiserTelp` AS `AdvertiserTelp`,`tab_invoice`.`ProductName` AS `ProductName`,`tab_invoice`.`BillingType` AS `BillingType`,`tab_invoice`.`AE_Name` AS `AE_Name`,`tab_invoice`.`IsSentToCourier` AS `IsSentToCourier`,`tab_invoice`.`AgencyDisc` AS `AgencyDisc`,`tab_invoice`.`Nett` AS `Nett`,`tab_invoice`.`Gross` AS `Gross`,`tab_invoice`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`tab_invoice`.`isDirectClient` AS `isDirectClient`,`tab_invoice`.`PeriodMonth` AS `PeriodMonth`,`tab_invoice`.`PeriodYear` AS `PeriodYear`,`tab_invoice`.`isActive` AS `isActive`,`tab_invoice`.`EntryBy` AS `EntryBy`,`tab_invoice`.`EntryBy_date` AS `EntryBy_date`,`tab_invoice`.`EditBy` AS `EditBy`,`tab_invoice`.`EditBy_date` AS `EditBy_date`,`tab_invoice`.`DeleteBy` AS `DeleteBy`,`tab_invoice`.`DeleteBy_date` AS `DeleteBy_date` from `tab_invoice` where (`tab_invoice`.`isActive` = 0) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_bms_invoice`
--
DROP TABLE IF EXISTS `vw_bms_invoice`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_bms_invoice`  AS  select `tab_invoice`.`InvID` AS `InvID`,`tab_invoice`.`InvType` AS `InvType`,`tab_invoice`.`InvNo` AS `InvNo`,`tab_invoice`.`PONo` AS `PONo`,`tab_invoice`.`PO_Type` AS `PO_Type`,`tab_invoice`.`AgencyName` AS `AgencyName`,`tab_invoice`.`AgencyAddr` AS `AgencyAddr`,`tab_invoice`.`AgencyTelp` AS `AgencyTelp`,`tab_invoice`.`AdvertiserName` AS `AdvertiserName`,`tab_invoice`.`AdvertiserAddr` AS `AdvertiserAddr`,`tab_invoice`.`AdvertiserTelp` AS `AdvertiserTelp`,`tab_invoice`.`ProductName` AS `ProductName`,`tab_invoice`.`BillingType` AS `BillingType`,`tab_invoice`.`AE_Name` AS `AE_Name`,`tab_invoice`.`IsSentToCourier` AS `IsSentToCourier`,`tab_invoice`.`AgencyDisc` AS `AgencyDisc`,`tab_invoice`.`Nett` AS `Nett`,`tab_invoice`.`Gross` AS `Gross`,`tab_invoice`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`tab_invoice`.`isDirectClient` AS `isDirectClient`,`tab_invoice`.`PeriodMonth` AS `PeriodMonth`,`tab_invoice`.`PeriodYear` AS `PeriodYear`,`tab_invoice`.`isActive` AS `isActive`,`tab_invoice`.`EntryBy` AS `EntryBy`,`tab_invoice`.`EntryBy_date` AS `EntryBy_date`,`tab_invoice`.`EditBy` AS `EditBy`,`tab_invoice`.`EditBy_date` AS `EditBy_date`,`tab_invoice`.`DeleteBy` AS `DeleteBy`,`tab_invoice`.`DeleteBy_date` AS `DeleteBy_date` from `tab_invoice` where ((`tab_invoice`.`InvType` = 1) and (`tab_invoice`.`isActive` = 0)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_courier`
--
DROP TABLE IF EXISTS `vw_courier`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_courier`  AS  select `tab_courier`.`CourierID` AS `CourierID`,`tab_courier`.`CourierCode` AS `CourierCode`,`tab_courier`.`CourierName` AS `CourierName`,`tab_courier`.`CourierStatus` AS `CourierStatus`,`tab_courier`.`isActive` AS `isActive`,`tab_courier`.`EntryBy` AS `EntryBy`,`tab_courier`.`EntryBy_date` AS `EntryBy_date`,`tab_courier`.`EditBy` AS `EditBy`,`tab_courier`.`EditBy_date` AS `EditBy_date`,`tab_courier`.`DeleteBy` AS `DeleteBy`,`tab_courier`.`DeleteBy_date` AS `DeleteBy_date` from `tab_courier` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_delbms_invoice`
--
DROP TABLE IF EXISTS `vw_delbms_invoice`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_delbms_invoice`  AS  select `tab_invoice`.`InvID` AS `InvID`,`tab_invoice`.`InvType` AS `InvType`,`tab_invoice`.`InvNo` AS `InvNo`,`tab_invoice`.`PONo` AS `PONo`,`tab_invoice`.`PO_Type` AS `PO_Type`,`tab_invoice`.`AgencyName` AS `AgencyName`,`tab_invoice`.`AgencyAddr` AS `AgencyAddr`,`tab_invoice`.`AgencyTelp` AS `AgencyTelp`,`tab_invoice`.`AdvertiserName` AS `AdvertiserName`,`tab_invoice`.`AdvertiserAddr` AS `AdvertiserAddr`,`tab_invoice`.`AdvertiserTelp` AS `AdvertiserTelp`,`tab_invoice`.`ProductName` AS `ProductName`,`tab_invoice`.`BillingType` AS `BillingType`,`tab_invoice`.`AE_Name` AS `AE_Name`,`tab_invoice`.`IsSentToCourier` AS `IsSentToCourier`,`tab_invoice`.`AgencyDisc` AS `AgencyDisc`,`tab_invoice`.`Nett` AS `Nett`,`tab_invoice`.`Gross` AS `Gross`,`tab_invoice`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`tab_invoice`.`isActive` AS `isActive`,`tab_invoice`.`EntryBy` AS `EntryBy`,`tab_invoice`.`EntryBy_date` AS `EntryBy_date`,`tab_invoice`.`EditBy` AS `EditBy`,`tab_invoice`.`EditBy_date` AS `EditBy_date`,`tab_invoice`.`DeleteBy` AS `DeleteBy`,`tab_invoice`.`DeleteBy_date` AS `DeleteBy_date` from `tab_invoice` where ((`tab_invoice`.`InvType` = 1) and (`tab_invoice`.`isActive` = 1)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_delinv_sts`
--
DROP TABLE IF EXISTS `vw_delinv_sts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_delinv_sts`  AS  select `tab_inv_sts`.`InvStsID` AS `InvStsID`,`tab_inv_sts`.`InvStsCode` AS `InvStsCode`,`tab_inv_sts`.`InvStsName` AS `InvStsName`,`tab_inv_sts`.`isActive` AS `isActive`,`tab_inv_sts`.`EntryBy` AS `EntryBy`,`tab_inv_sts`.`EntryBy_date` AS `EntryBy_date`,`tab_inv_sts`.`EditBy` AS `EditBy`,`tab_inv_sts`.`EditBy_date` AS `EditBy_date`,`tab_inv_sts`.`DeleteBy` AS `DeleteBy`,`tab_inv_sts`.`DeleteBy_date` AS `DeleteBy_date` from `tab_inv_sts` where (`tab_inv_sts`.`isActive` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_delmanual_invoice`
--
DROP TABLE IF EXISTS `vw_delmanual_invoice`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_delmanual_invoice`  AS  select `tab_invoice`.`InvID` AS `InvID`,`tab_invoice`.`InvType` AS `InvType`,`tab_invoice`.`InvNo` AS `InvNo`,`tab_invoice`.`PONo` AS `PONo`,`tab_invoice`.`PO_Type` AS `PO_Type`,`tab_invoice`.`AgencyName` AS `AgencyName`,`tab_invoice`.`AgencyAddr` AS `AgencyAddr`,`tab_invoice`.`AgencyTelp` AS `AgencyTelp`,`tab_invoice`.`AdvertiserName` AS `AdvertiserName`,`tab_invoice`.`AdvertiserAddr` AS `AdvertiserAddr`,`tab_invoice`.`AdvertiserTelp` AS `AdvertiserTelp`,`tab_invoice`.`ProductName` AS `ProductName`,`tab_invoice`.`BillingType` AS `BillingType`,`tab_invoice`.`AE_Name` AS `AE_Name`,`tab_invoice`.`IsSentToCourier` AS `IsSentToCourier`,`tab_invoice`.`AgencyDisc` AS `AgencyDisc`,`tab_invoice`.`Nett` AS `Nett`,`tab_invoice`.`Gross` AS `Gross`,`tab_invoice`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`tab_invoice`.`isActive` AS `isActive`,`tab_invoice`.`EntryBy` AS `EntryBy`,`tab_invoice`.`EntryBy_date` AS `EntryBy_date`,`tab_invoice`.`EditBy` AS `EditBy`,`tab_invoice`.`EditBy_date` AS `EditBy_date`,`tab_invoice`.`DeleteBy` AS `DeleteBy`,`tab_invoice`.`DeleteBy_date` AS `DeleteBy_date` from `tab_invoice` where ((`tab_invoice`.`InvType` = 0) and (`tab_invoice`.`isActive` = 1)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_deltracking`
--
DROP TABLE IF EXISTS `vw_deltracking`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_deltracking`  AS  select `tt`.`ReceiptSendPkgID` AS `ReceiptSendPkgID`,`tt`.`ReceiptSendPkgName` AS `ReceiptSendPkgName`,`tt`.`ReceiptSendPkgReceiver` AS `ReceiptSendPkgReceiver`,`tt`.`SendDate` AS `SendDate`,`tt`.`ResiNoFromCourier` AS `ResiNoFromCourier`,`tt`.`ReceiptPathFilename` AS `ReceiptPathFilename`,`vi`.`InvID` AS `InvID`,`vi`.`InvType` AS `InvType`,`vi`.`InvNo` AS `InvNo`,`vi`.`PONo` AS `PONo`,`vi`.`PO_Type` AS `PO_Type`,`vi`.`AgencyName` AS `AgencyName`,`vi`.`AgencyAddr` AS `AgencyAddr`,`vi`.`AgencyTelp` AS `AgencyTelp`,`vi`.`AdvertiserName` AS `AdvertiserName`,`vi`.`AdvertiserAddr` AS `AdvertiserAddr`,`vi`.`AdvertiserTelp` AS `AdvertiserTelp`,`vi`.`ProductName` AS `ProductName`,`vi`.`BillingType` AS `BillingType`,`vi`.`AE_Name` AS `AE_Name`,`vi`.`IsSentToCourier` AS `IsSentToCourier`,`vi`.`AgencyDisc` AS `AgencyDisc`,`vi`.`Nett` AS `Nett`,`vi`.`Gross` AS `Gross`,`vi`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`vi`.`isDirectClient` AS `isDirectClient`,`vi`.`PeriodMonth` AS `PeriodMonth`,`vi`.`PeriodYear` AS `PeriodYear`,`vs`.`InvStsID` AS `InvStsID`,`vs`.`InvStsCode` AS `InvStsCode`,`vs`.`InvStsName` AS `InvStsName`,`vc`.`CourierID` AS `CourierID`,`vc`.`CourierCode` AS `CourierCode`,`vc`.`CourierName` AS `CourierName`,`vc`.`CourierStatus` AS `CourierStatus`,`tt`.`EntryBy` AS `EntryBy`,`tt`.`EntryBy_date` AS `EntryBy_date`,`tt`.`EditBy` AS `EditBy`,`tt`.`EditBy_date` AS `EditBy_date`,`tt`.`DeleteBy` AS `DeleteBy`,`tt`.`DeleteBy_date` AS `DeleteBy_date` from (((`tr_tracking` `tt` left join `vw_all_delinvoice` `vi` on((`tt`.`InvID` = `vi`.`InvID`))) left join `vw_inv_sts` `vs` on((`tt`.`InvStsID` = `vs`.`InvStsID`))) left join `vw_courier` `vc` on((`tt`.`CourierID` = `vc`.`CourierID`))) where (`tt`.`isActive` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_inv_sts`
--
DROP TABLE IF EXISTS `vw_inv_sts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_inv_sts`  AS  select `tab_inv_sts`.`InvStsID` AS `InvStsID`,`tab_inv_sts`.`InvStsCode` AS `InvStsCode`,`tab_inv_sts`.`InvStsName` AS `InvStsName`,`tab_inv_sts`.`isActive` AS `isActive`,`tab_inv_sts`.`EntryBy` AS `EntryBy`,`tab_inv_sts`.`EntryBy_date` AS `EntryBy_date`,`tab_inv_sts`.`EditBy` AS `EditBy`,`tab_inv_sts`.`EditBy_date` AS `EditBy_date`,`tab_inv_sts`.`DeleteBy` AS `DeleteBy`,`tab_inv_sts`.`DeleteBy_date` AS `DeleteBy_date` from `tab_inv_sts` where (`tab_inv_sts`.`isActive` = 0) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_manual_invoice`
--
DROP TABLE IF EXISTS `vw_manual_invoice`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_manual_invoice`  AS  select `tab_invoice`.`InvID` AS `InvID`,`tab_invoice`.`InvType` AS `InvType`,`tab_invoice`.`InvNo` AS `InvNo`,`tab_invoice`.`PONo` AS `PONo`,`tab_invoice`.`PO_Type` AS `PO_Type`,`tab_invoice`.`AgencyName` AS `AgencyName`,`tab_invoice`.`AgencyAddr` AS `AgencyAddr`,`tab_invoice`.`AgencyTelp` AS `AgencyTelp`,`tab_invoice`.`AdvertiserName` AS `AdvertiserName`,`tab_invoice`.`AdvertiserAddr` AS `AdvertiserAddr`,`tab_invoice`.`AdvertiserTelp` AS `AdvertiserTelp`,`tab_invoice`.`ProductName` AS `ProductName`,`tab_invoice`.`BillingType` AS `BillingType`,`tab_invoice`.`AE_Name` AS `AE_Name`,`tab_invoice`.`IsSentToCourier` AS `IsSentToCourier`,`tab_invoice`.`AgencyDisc` AS `AgencyDisc`,`tab_invoice`.`Nett` AS `Nett`,`tab_invoice`.`Gross` AS `Gross`,`tab_invoice`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`tab_invoice`.`isDirectClient` AS `isDirectClient`,`tab_invoice`.`PeriodMonth` AS `PeriodMonth`,`tab_invoice`.`PeriodYear` AS `PeriodYear`,`tab_invoice`.`isActive` AS `isActive`,`tab_invoice`.`EntryBy` AS `EntryBy`,`tab_invoice`.`EntryBy_date` AS `EntryBy_date`,`tab_invoice`.`EditBy` AS `EditBy`,`tab_invoice`.`EditBy_date` AS `EditBy_date`,`tab_invoice`.`DeleteBy` AS `DeleteBy`,`tab_invoice`.`DeleteBy_date` AS `DeleteBy_date` from `tab_invoice` where ((`tab_invoice`.`InvType` = 0) and (`tab_invoice`.`isActive` = 0)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_nav`
--
DROP TABLE IF EXISTS `vw_nav`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_nav`  AS  select `tn`.`nav_id` AS `nav_id`,`tn`.`nav_name` AS `nav_name`,`tn`.`nav_ctr` AS `nav_ctr`,`tn`.`nav_parent` AS `nav_parent`,`tn`.`nav_level` AS `nav_level`,`tn`.`nav_order` AS `nav_order`,`tn`.`dev_only` AS `dev_only`,`tn`.`create_date` AS `create_date`,`tn`.`create_by` AS `create_by`,`tn`.`edited_date` AS `edited_date`,`tn`.`edited_by` AS `edited_by`,`tn2`.`nav_name` AS `parent_name` from (`tab_nav` `tn` left join `tab_nav` `tn2` on((`tn`.`nav_parent` = `tn2`.`nav_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_pick_messenger_invoices`
--
DROP TABLE IF EXISTS `vw_pick_messenger_invoices`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_pick_messenger_invoices`  AS  select `tt`.`ReceiptSendPkgID` AS `ReceiptSendPkgID`,`tt`.`ReceiptSendPkgName` AS `ReceiptSendPkgName`,`tt`.`ReceiptSendPkgReceiver` AS `ReceiptSendPkgReceiver`,`tt`.`SendDate` AS `SendDate`,`tt`.`ResiNoFromCourier` AS `ResiNoFromCourier`,`tt`.`ReceiptPathFilename` AS `ReceiptPathFilename`,`vi`.`InvID` AS `InvID`,`vi`.`InvType` AS `InvType`,`vi`.`InvNo` AS `InvNo`,`vi`.`PONo` AS `PONo`,`vi`.`PO_Type` AS `PO_Type`,`vi`.`AgencyName` AS `AgencyName`,`vi`.`AgencyAddr` AS `AgencyAddr`,`vi`.`AgencyTelp` AS `AgencyTelp`,`vi`.`AdvertiserName` AS `AdvertiserName`,`vi`.`AdvertiserAddr` AS `AdvertiserAddr`,`vi`.`AdvertiserTelp` AS `AdvertiserTelp`,`vi`.`ProductName` AS `ProductName`,`vi`.`BillingType` AS `BillingType`,`vi`.`AE_Name` AS `AE_Name`,`vi`.`IsSentToCourier` AS `IsSentToCourier`,`vi`.`AgencyDisc` AS `AgencyDisc`,`vi`.`Nett` AS `Nett`,`vi`.`Gross` AS `Gross`,`vi`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`vi`.`isDirectClient` AS `isDirectClient`,`vi`.`PeriodYear` AS `PeriodYear`,`vi`.`PeriodMonth` AS `PeriodMonth`,`vc`.`CourierID` AS `CourierID`,`vc`.`CourierCode` AS `CourierCode`,`vc`.`CourierName` AS `CourierName`,`vc`.`CourierStatus` AS `CourierStatus`,`vs`.`InvStsID` AS `InvStsID`,`vs`.`InvStsCode` AS `InvStsCode`,`vs`.`InvStsName` AS `InvStsName`,`tt`.`EntryBy` AS `EntryBy`,`tt`.`EntryBy_date` AS `EntryBy_date`,`tt`.`EditBy` AS `EditBy`,`tt`.`EditBy_date` AS `EditBy_date`,`tt`.`DeleteBy` AS `DeleteBy`,`tt`.`DeleteBy_date` AS `DeleteBy_date` from (((`tr_tracking` `tt` left join `vw_all_invoice` `vi` on((`tt`.`InvID` = `vi`.`InvID`))) left join `vw_courier` `vc` on((`tt`.`CourierID` = `vc`.`CourierID`))) left join `vw_inv_sts` `vs` on((`tt`.`InvStsID` = `vs`.`InvStsID`))) where ((`tt`.`isActive` = 0) and (`vs`.`InvStsCode` in ('3A','3B'))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_ready_to_send_invoices`
--
DROP TABLE IF EXISTS `vw_ready_to_send_invoices`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_ready_to_send_invoices`  AS  select `vt`.`ReceiptSendPkgID` AS `ReceiptSendPkgID`,`vt`.`ReceiptSendPkgName` AS `ReceiptSendPkgName`,`vt`.`ReceiptSendPkgReceiver` AS `ReceiptSendPkgReceiver`,`vt`.`SendDate` AS `SendDate`,`vt`.`ResiNoFromCourier` AS `ResiNoFromCourier`,`vt`.`ReceiptPathFilename` AS `ReceiptPathFilename`,`vt`.`InvID` AS `InvID`,`vt`.`InvType` AS `InvType`,`vt`.`InvNo` AS `InvNo`,`vt`.`PONo` AS `PONo`,`vt`.`PO_Type` AS `PO_Type`,`vt`.`AgencyName` AS `AgencyName`,`vt`.`AgencyAddr` AS `AgencyAddr`,`vt`.`AgencyTelp` AS `AgencyTelp`,`vt`.`AdvertiserName` AS `AdvertiserName`,`vt`.`AdvertiserAddr` AS `AdvertiserAddr`,`vt`.`AdvertiserTelp` AS `AdvertiserTelp`,`vt`.`ProductName` AS `ProductName`,`vt`.`BillingType` AS `BillingType`,`vt`.`AE_Name` AS `AE_Name`,`vt`.`IsSentToCourier` AS `IsSentToCourier`,`vt`.`AgencyDisc` AS `AgencyDisc`,`vt`.`Nett` AS `Nett`,`vt`.`Gross` AS `Gross`,`vt`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`vt`.`isDirectClient` AS `isDirectClient`,`vt`.`PeriodMonth` AS `PeriodMonth`,`vt`.`PeriodYear` AS `PeriodYear`,`vt`.`InvStsID` AS `InvStsID`,`vt`.`InvStsCode` AS `InvStsCode`,`vt`.`InvStsName` AS `InvStsName`,`vt`.`CourierID` AS `CourierID`,`vt`.`CourierCode` AS `CourierCode`,`vt`.`CourierName` AS `CourierName`,`vt`.`CourierStatus` AS `CourierStatus`,`vt`.`EntryBy` AS `EntryBy`,`vt`.`EntryBy_date` AS `EntryBy_date`,`vt`.`EditBy` AS `EditBy`,`vt`.`EditBy_date` AS `EditBy_date`,`vt`.`DeleteBy` AS `DeleteBy`,`vt`.`DeleteBy_date` AS `DeleteBy_date` from `vw_tracking` `vt` where ((`vt`.`ReceiptSendPkgID` = (select max(`vw_tracking`.`ReceiptSendPkgID`) from `vw_tracking` where (`vt`.`InvID` = `vw_tracking`.`InvID`))) and (`vt`.`InvStsID` in (3,4,5))) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_received_by_client_invoices`
--
DROP TABLE IF EXISTS `vw_received_by_client_invoices`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_received_by_client_invoices`  AS  select `vw_tracking`.`ReceiptSendPkgID` AS `ReceiptSendPkgID`,`vw_tracking`.`ReceiptSendPkgName` AS `ReceiptSendPkgName`,`vw_tracking`.`ReceiptSendPkgReceiver` AS `ReceiptSendPkgReceiver`,`vw_tracking`.`SendDate` AS `SendDate`,`vw_tracking`.`ResiNoFromCourier` AS `ResiNoFromCourier`,`vw_tracking`.`ReceiptPathFilename` AS `ReceiptPathFilename`,`vw_tracking`.`InvID` AS `InvID`,`vw_tracking`.`InvType` AS `InvType`,`vw_tracking`.`InvNo` AS `InvNo`,`vw_tracking`.`PONo` AS `PONo`,`vw_tracking`.`PO_Type` AS `PO_Type`,`vw_tracking`.`AgencyName` AS `AgencyName`,`vw_tracking`.`AgencyAddr` AS `AgencyAddr`,`vw_tracking`.`AgencyTelp` AS `AgencyTelp`,`vw_tracking`.`AdvertiserName` AS `AdvertiserName`,`vw_tracking`.`AdvertiserAddr` AS `AdvertiserAddr`,`vw_tracking`.`AdvertiserTelp` AS `AdvertiserTelp`,`vw_tracking`.`ProductName` AS `ProductName`,`vw_tracking`.`BillingType` AS `BillingType`,`vw_tracking`.`AE_Name` AS `AE_Name`,`vw_tracking`.`IsSentToCourier` AS `IsSentToCourier`,`vw_tracking`.`AgencyDisc` AS `AgencyDisc`,`vw_tracking`.`Nett` AS `Nett`,`vw_tracking`.`Gross` AS `Gross`,`vw_tracking`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`vw_tracking`.`isDirectClient` AS `isDirectClient`,`vw_tracking`.`PeriodMonth` AS `PeriodMonth`,`vw_tracking`.`PeriodYear` AS `PeriodYear`,`vw_tracking`.`InvStsID` AS `InvStsID`,`vw_tracking`.`InvStsCode` AS `InvStsCode`,`vw_tracking`.`InvStsName` AS `InvStsName`,`vw_tracking`.`CourierID` AS `CourierID`,`vw_tracking`.`CourierCode` AS `CourierCode`,`vw_tracking`.`CourierName` AS `CourierName`,`vw_tracking`.`CourierStatus` AS `CourierStatus`,`vw_tracking`.`EntryBy` AS `EntryBy`,`vw_tracking`.`EntryBy_date` AS `EntryBy_date`,`vw_tracking`.`EditBy` AS `EditBy`,`vw_tracking`.`EditBy_date` AS `EditBy_date`,`vw_tracking`.`DeleteBy` AS `DeleteBy`,`vw_tracking`.`DeleteBy_date` AS `DeleteBy_date` from `vw_tracking` where (`vw_tracking`.`InvStsCode` = '4A') ;

-- --------------------------------------------------------

--
-- Structure for view `vw_received_by_ga_invoices`
--
DROP TABLE IF EXISTS `vw_received_by_ga_invoices`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_received_by_ga_invoices`  AS  select `tt`.`ReceiptSendPkgID` AS `ReceiptSendPkgID`,`tt`.`ReceiptSendPkgName` AS `ReceiptSendPkgName`,`tt`.`ResiNoFromCourier` AS `ResiNoFromCourier`,`tt`.`ReceiptPathFilename` AS `ReceiptPathFilename`,`vi`.`InvID` AS `InvID`,`vi`.`InvType` AS `InvType`,`vi`.`InvNo` AS `InvNo`,`vi`.`PONo` AS `PONo`,`vi`.`PO_Type` AS `PO_Type`,`vi`.`AgencyName` AS `AgencyName`,`vi`.`AgencyAddr` AS `AgencyAddr`,`vi`.`AgencyTelp` AS `AgencyTelp`,`vi`.`AdvertiserName` AS `AdvertiserName`,`vi`.`AdvertiserAddr` AS `AdvertiserAddr`,`vi`.`AdvertiserTelp` AS `AdvertiserTelp`,`vi`.`ProductName` AS `ProductName`,`vi`.`BillingType` AS `BillingType`,`vi`.`AE_Name` AS `AE_Name`,`vi`.`IsSentToCourier` AS `IsSentToCourier`,`vi`.`AgencyDisc` AS `AgencyDisc`,`vi`.`Nett` AS `Nett`,`vi`.`Gross` AS `Gross`,`vi`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`vi`.`isDirectClient` AS `isDirectClient`,`vi`.`PeriodYear` AS `PeriodYear`,`vi`.`PeriodMonth` AS `PeriodMonth`,`vc`.`CourierID` AS `CourierID`,`vc`.`CourierCode` AS `CourierCode`,`vc`.`CourierName` AS `CourierName`,`vc`.`CourierStatus` AS `CourierStatus`,`vs`.`InvStsID` AS `InvStsID`,`vs`.`InvStsCode` AS `InvStsCode`,`vs`.`InvStsName` AS `InvStsName`,`tt`.`EntryBy` AS `EntryBy`,`tt`.`EntryBy_date` AS `EntryBy_date`,`tt`.`EditBy` AS `EditBy`,`tt`.`EditBy_date` AS `EditBy_date`,`tt`.`DeleteBy` AS `DeleteBy`,`tt`.`DeleteBy_date` AS `DeleteBy_date` from (((`tr_tracking` `tt` left join `vw_all_invoice` `vi` on((`tt`.`InvID` = `vi`.`InvID`))) left join `vw_courier` `vc` on((`tt`.`CourierID` = `vc`.`CourierID`))) left join `vw_inv_sts` `vs` on((`tt`.`InvStsID` = `vs`.`InvStsID`))) where ((`tt`.`isActive` = 0) and (`vs`.`InvStsCode` like '2')) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_returned_invoices`
--
DROP TABLE IF EXISTS `vw_returned_invoices`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_returned_invoices`  AS  select `vw_tracking`.`ReceiptSendPkgID` AS `ReceiptSendPkgID`,`vw_tracking`.`ReceiptSendPkgName` AS `ReceiptSendPkgName`,`vw_tracking`.`ReceiptSendPkgReceiver` AS `ReceiptSendPkgReceiver`,`vw_tracking`.`SendDate` AS `SendDate`,`vw_tracking`.`ResiNoFromCourier` AS `ResiNoFromCourier`,`vw_tracking`.`ReceiptPathFilename` AS `ReceiptPathFilename`,`vw_tracking`.`InvID` AS `InvID`,`vw_tracking`.`InvType` AS `InvType`,`vw_tracking`.`InvNo` AS `InvNo`,`vw_tracking`.`PONo` AS `PONo`,`vw_tracking`.`PO_Type` AS `PO_Type`,`vw_tracking`.`AgencyName` AS `AgencyName`,`vw_tracking`.`AgencyAddr` AS `AgencyAddr`,`vw_tracking`.`AgencyTelp` AS `AgencyTelp`,`vw_tracking`.`AdvertiserName` AS `AdvertiserName`,`vw_tracking`.`AdvertiserAddr` AS `AdvertiserAddr`,`vw_tracking`.`AdvertiserTelp` AS `AdvertiserTelp`,`vw_tracking`.`ProductName` AS `ProductName`,`vw_tracking`.`BillingType` AS `BillingType`,`vw_tracking`.`AE_Name` AS `AE_Name`,`vw_tracking`.`IsSentToCourier` AS `IsSentToCourier`,`vw_tracking`.`AgencyDisc` AS `AgencyDisc`,`vw_tracking`.`Nett` AS `Nett`,`vw_tracking`.`Gross` AS `Gross`,`vw_tracking`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`vw_tracking`.`isDirectClient` AS `isDirectClient`,`vw_tracking`.`PeriodMonth` AS `PeriodMonth`,`vw_tracking`.`PeriodYear` AS `PeriodYear`,`vw_tracking`.`InvStsID` AS `InvStsID`,`vw_tracking`.`InvStsCode` AS `InvStsCode`,`vw_tracking`.`InvStsName` AS `InvStsName`,`vw_tracking`.`CourierID` AS `CourierID`,`vw_tracking`.`CourierCode` AS `CourierCode`,`vw_tracking`.`CourierName` AS `CourierName`,`vw_tracking`.`CourierStatus` AS `CourierStatus`,`vw_tracking`.`EntryBy` AS `EntryBy`,`vw_tracking`.`EntryBy_date` AS `EntryBy_date`,`vw_tracking`.`EditBy` AS `EditBy`,`vw_tracking`.`EditBy_date` AS `EditBy_date`,`vw_tracking`.`DeleteBy` AS `DeleteBy`,`vw_tracking`.`DeleteBy_date` AS `DeleteBy_date` from `vw_tracking` where (`vw_tracking`.`InvStsCode` like '5') ;

-- --------------------------------------------------------

--
-- Structure for view `vw_send_by_billing_invoices`
--
DROP TABLE IF EXISTS `vw_send_by_billing_invoices`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_send_by_billing_invoices`  AS  select `vw_tracking`.`ReceiptSendPkgID` AS `ReceiptSendPkgID`,`vw_tracking`.`ReceiptSendPkgName` AS `ReceiptSendPkgName`,`vw_tracking`.`ReceiptSendPkgReceiver` AS `ReceiptSendPkgReceiver`,`vw_tracking`.`SendDate` AS `SendDate`,`vw_tracking`.`ResiNoFromCourier` AS `ResiNoFromCourier`,`vw_tracking`.`ReceiptPathFilename` AS `ReceiptPathFilename`,`vw_tracking`.`InvID` AS `InvID`,`vw_tracking`.`InvType` AS `InvType`,`vw_tracking`.`InvNo` AS `InvNo`,`vw_tracking`.`PONo` AS `PONo`,`vw_tracking`.`PO_Type` AS `PO_Type`,`vw_tracking`.`AgencyName` AS `AgencyName`,`vw_tracking`.`AgencyAddr` AS `AgencyAddr`,`vw_tracking`.`AgencyTelp` AS `AgencyTelp`,`vw_tracking`.`AdvertiserName` AS `AdvertiserName`,`vw_tracking`.`AdvertiserAddr` AS `AdvertiserAddr`,`vw_tracking`.`AdvertiserTelp` AS `AdvertiserTelp`,`vw_tracking`.`ProductName` AS `ProductName`,`vw_tracking`.`BillingType` AS `BillingType`,`vw_tracking`.`AE_Name` AS `AE_Name`,`vw_tracking`.`IsSentToCourier` AS `IsSentToCourier`,`vw_tracking`.`AgencyDisc` AS `AgencyDisc`,`vw_tracking`.`Nett` AS `Nett`,`vw_tracking`.`Gross` AS `Gross`,`vw_tracking`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`vw_tracking`.`isDirectClient` AS `isDirectClient`,`vw_tracking`.`PeriodMonth` AS `PeriodMonth`,`vw_tracking`.`PeriodYear` AS `PeriodYear`,`vw_tracking`.`InvStsID` AS `InvStsID`,`vw_tracking`.`InvStsCode` AS `InvStsCode`,`vw_tracking`.`InvStsName` AS `InvStsName`,`vw_tracking`.`CourierID` AS `CourierID`,`vw_tracking`.`CourierCode` AS `CourierCode`,`vw_tracking`.`CourierName` AS `CourierName`,`vw_tracking`.`CourierStatus` AS `CourierStatus`,`vw_tracking`.`EntryBy` AS `EntryBy`,`vw_tracking`.`EntryBy_date` AS `EntryBy_date`,`vw_tracking`.`EditBy` AS `EditBy`,`vw_tracking`.`EditBy_date` AS `EditBy_date`,`vw_tracking`.`DeleteBy` AS `DeleteBy`,`vw_tracking`.`DeleteBy_date` AS `DeleteBy_date` from `vw_tracking` where (`vw_tracking`.`InvStsCode` like '1') ;

-- --------------------------------------------------------

--
-- Structure for view `vw_tracking`
--
DROP TABLE IF EXISTS `vw_tracking`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_tracking`  AS  select `tt`.`ReceiptSendPkgID` AS `ReceiptSendPkgID`,`tt`.`ReceiptSendPkgName` AS `ReceiptSendPkgName`,`tt`.`ReceiptSendPkgReceiver` AS `ReceiptSendPkgReceiver`,`tt`.`SendDate` AS `SendDate`,`tt`.`ResiNoFromCourier` AS `ResiNoFromCourier`,`tt`.`ReceiptPathFilename` AS `ReceiptPathFilename`,`vi`.`InvID` AS `InvID`,`vi`.`InvType` AS `InvType`,`vi`.`InvNo` AS `InvNo`,`vi`.`PONo` AS `PONo`,`vi`.`PO_Type` AS `PO_Type`,`vi`.`AgencyName` AS `AgencyName`,`vi`.`AgencyAddr` AS `AgencyAddr`,`vi`.`AgencyTelp` AS `AgencyTelp`,`vi`.`AdvertiserName` AS `AdvertiserName`,`vi`.`AdvertiserAddr` AS `AdvertiserAddr`,`vi`.`AdvertiserTelp` AS `AdvertiserTelp`,`vi`.`ProductName` AS `ProductName`,`vi`.`BillingType` AS `BillingType`,`vi`.`AE_Name` AS `AE_Name`,`vi`.`IsSentToCourier` AS `IsSentToCourier`,`vi`.`AgencyDisc` AS `AgencyDisc`,`vi`.`Nett` AS `Nett`,`vi`.`Gross` AS `Gross`,`vi`.`ReferTo_BMSInvoice` AS `ReferTo_BMSInvoice`,`vi`.`isDirectClient` AS `isDirectClient`,`vi`.`PeriodMonth` AS `PeriodMonth`,`vi`.`PeriodYear` AS `PeriodYear`,`vs`.`InvStsID` AS `InvStsID`,`vs`.`InvStsCode` AS `InvStsCode`,`vs`.`InvStsName` AS `InvStsName`,`vc`.`CourierID` AS `CourierID`,`vc`.`CourierCode` AS `CourierCode`,`vc`.`CourierName` AS `CourierName`,`vc`.`CourierStatus` AS `CourierStatus`,`tt`.`EntryBy` AS `EntryBy`,`tt`.`EntryBy_date` AS `EntryBy_date`,`tt`.`EditBy` AS `EditBy`,`tt`.`EditBy_date` AS `EditBy_date`,`tt`.`DeleteBy` AS `DeleteBy`,`tt`.`DeleteBy_date` AS `DeleteBy_date` from (((`tr_tracking` `tt` left join `vw_all_invoice` `vi` on((`tt`.`InvID` = `vi`.`InvID`))) left join `vw_inv_sts` `vs` on((`tt`.`InvStsID` = `vs`.`InvStsID`))) left join `vw_courier` `vc` on((`tt`.`CourierID` = `vc`.`CourierID`))) where (`tt`.`isActive` = 0) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_uac`
--
DROP TABLE IF EXISTS `vw_uac`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dev`@`%` SQL SECURITY DEFINER VIEW `vw_uac`  AS  select `tu`.`user_id` AS `user_id`,`vn`.`nav_id` AS `nav_id`,`vn`.`nav_name` AS `nav_name`,`vn`.`nav_ctr` AS `nav_ctr`,`vn`.`nav_parent` AS `nav_parent`,`vn`.`nav_level` AS `nav_level`,`vn`.`nav_order` AS `nav_order`,`vn`.`dev_only` AS `dev_only`,`vn`.`parent_name` AS `parent_name` from (`tab_uac` `tu` left join `vw_nav` `vn` on((`tu`.`nav_id` = `vn`.`nav_id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loglogin`
--
ALTER TABLE `loglogin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tab_courier`
--
ALTER TABLE `tab_courier`
  ADD PRIMARY KEY (`CourierID`);

--
-- Indexes for table `tab_invoice`
--
ALTER TABLE `tab_invoice`
  ADD PRIMARY KEY (`InvID`);

--
-- Indexes for table `tab_inv_sts`
--
ALTER TABLE `tab_inv_sts`
  ADD PRIMARY KEY (`InvStsID`);

--
-- Indexes for table `tab_nav`
--
ALTER TABLE `tab_nav`
  ADD PRIMARY KEY (`nav_id`);

--
-- Indexes for table `tab_uac`
--
ALTER TABLE `tab_uac`
  ADD PRIMARY KEY (`nav_id`,`user_id`);

--
-- Indexes for table `tr_log_tracking`
--
ALTER TABLE `tr_log_tracking`
  ADD PRIMARY KEY (`ReceiptSendPkgID`);

--
-- Indexes for table `tr_tracking`
--
ALTER TABLE `tr_tracking`
  ADD PRIMARY KEY (`ReceiptSendPkgID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loglogin`
--
ALTER TABLE `loglogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tab_courier`
--
ALTER TABLE `tab_courier`
  MODIFY `CourierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tab_invoice`
--
ALTER TABLE `tab_invoice`
  MODIFY `InvID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tab_inv_sts`
--
ALTER TABLE `tab_inv_sts`
  MODIFY `InvStsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tab_nav`
--
ALTER TABLE `tab_nav`
  MODIFY `nav_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tr_log_tracking`
--
ALTER TABLE `tr_log_tracking`
  MODIFY `ReceiptSendPkgID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_tracking`
--
ALTER TABLE `tr_tracking`
  MODIFY `ReceiptSendPkgID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
