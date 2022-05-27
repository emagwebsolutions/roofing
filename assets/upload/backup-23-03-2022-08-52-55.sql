-- MariaDB dump 10.19  Distrib 10.4.22-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: products
-- ------------------------------------------------------
-- Server version	10.4.22-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `ac_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type` varchar(100) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `open_balance` varchar(100) NOT NULL,
  `open_balance_date` date NOT NULL,
  `date` date NOT NULL,
  `par_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `par_type` varchar(255) NOT NULL,
  `bank_acc_no` varchar(255) NOT NULL,
  `routing_number` varchar(255) NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `sub_account` varchar(255) NOT NULL,
  `groups` text NOT NULL,
  PRIMARY KEY (`ac_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'Income','Income Account','','29','2021-08-31','2021-08-31',0,1,'top_level','','','','','[]'),(2,'Expense','Expense Account','','0','2021-08-31','2021-08-31',0,1,'top_level','','','','','[]'),(3,'Equity','Opening Balance Equity','','0','2021-08-31','2021-08-31',0,1,'top_level','','','','','[]');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill`
--

DROP TABLE IF EXISTS `bill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill` (
  `bill_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `bill_due_date` date NOT NULL,
  `vend_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `group_no` int(11) NOT NULL,
  `ac_id` int(11) NOT NULL,
  PRIMARY KEY (`bill_id`),
  KEY `bcusid` (`vend_id`),
  KEY `bacid` (`ac_id`),
  CONSTRAINT `bacid` FOREIGN KEY (`ac_id`) REFERENCES `accounts` (`ac_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bcusid` FOREIGN KEY (`vend_id`) REFERENCES `customers` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill`
--

LOCK TABLES `bill` WRITE;
/*!40000 ALTER TABLE `bill` DISABLE KEYS */;
INSERT INTO `bill` VALUES (19,'2022-02-09','2022-02-23',16,'ertret',22,2);
/*!40000 ALTER TABLE `bill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) NOT NULL,
  `ref` varchar(100) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'LUBRICANTS (PETROL)','product'),(3,'FREIGHT MANAGEMENT','product'),(4,'LUBRICANTS (DIESEL)','product'),(5,'AUTOMATIC TRANSMISSION OIL (ATF)','product'),(6,'GEAR OILS','product'),(7,'HYDRAULIC OIL','product'),(8,'GREASE','product'),(9,'DIESEL EXHAUST FLUID','product'),(10,'RADIATOR COOLANT','product'),(11,'COMPRESSOR/CIRCULATING OILS','product'),(12,'FADA','product'),(13,'AGAIN','product'),(14,'ALASKAS','product'),(15,'SALA','product');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm`
--

DROP TABLE IF EXISTS `crm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crm` (
  `crm_id` int(11) NOT NULL AUTO_INCREMENT,
  `leadname` varchar(100) NOT NULL,
  `contactname` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `industry` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `lead_source` varchar(100) NOT NULL,
  `lead_status` varchar(100) NOT NULL,
  `sales_stage` varchar(100) NOT NULL,
  `skype` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `opp_name` varchar(100) NOT NULL,
  `closing_date` date DEFAULT NULL,
  `stage` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `probability` int(11) NOT NULL,
  `revenue` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `date` datetime DEFAULT NULL,
  `cust_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`crm_id`),
  KEY `cmsfk2` (`user_id`),
  CONSTRAINT `cmsfk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm`
--

LOCK TABLES `crm` WRITE;
/*!40000 ALTER TABLE `crm` DISABLE KEYS */;
/*!40000 ALTER TABLE `crm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `cust_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_mang` int(11) NOT NULL,
  `note` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `funds` varchar(100) NOT NULL,
  `ac_id` int(11) NOT NULL,
  PRIMARY KEY (`cust_id`),
  KEY `fkuss1` (`user_id`),
  CONSTRAINT `fkuss1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (2,'BENKANAS ENTERPRISE','00233264981295','','TEMA (Opposite Cocoa Processing Co Ltd)','2021-09-03',1,1,'','Customer','',0),(3,'BIBIARA NSO NYAME YE SPARE PARTS (EMELIA AYEKY)','00233554808852','','DAWENHYA (Near Police Station)','2021-09-16',1,1,'','Customer','',0),(4,'Dominic\'s Automobile','00233244889980','','Community 5, Behind Anasett Gas','2021-09-06',1,1,'','Customer','',0),(5,'Kwasi Asah (Automatic Transmission Specialist)','00233244787928','','Tema Industrial Area (Near Comm 1)','2021-10-11',1,1,'','Customer','',0),(6,'Junelight International Ltd (Mad. Vic Taylor)','00233244033958','','Comm 9 (Autoparts Market)','2021-09-07',1,1,'','Customer','',0),(7,'JABPAH ENTERPRISE (David Tetteh)','00233243341522','','COMM 9 (SPARE PARTS ENCLAVE)','2021-09-07',1,1,'','Customer','',0),(8,'GOLDREX AUTOMOBILE COMPANY LTD (REX ASIEDU)','0243377344','','DAWHENYA','2021-09-16',1,1,'','Customer','',0),(9,'Kafui Agbenu','0244329710','','Tema C25','2021-09-24',1,1,'','Customer','',0),(10,'EUNICE PUPLAMPU T/S AUTO SUPERMART','0201663849','euniceaadd@gmail.com','COMM 4, OPP CHEMU SEC SCH, TEMA','2021-09-30',1,1,'','Customer','',0),(11,'3F GHANA LTD','0540115830','sureshe@fff.co.in','TEMA FREE ZONES ENCLAVE','2021-10-04',1,1,'','Customer','',0),(12,'Novandi','0548111048','novandient@gmail.com','Tema','2021-10-04',1,1,'','Customer','',0),(13,'HEAVY MACHINERY DEALERSHIP (HMD)','+233 (0)556761081','yaw.aseidu@hmd-africa.com','PLOT# HI/MKT/25/A/13, COMM 25, TEMA','2021-10-04',1,1,'','Customer','',0),(14,'MIKEKUM ULTRA-MODERN ENGINEERING (MICHEAL KUMI)','0243416297','','TEMA FREEZONES ENCLAVE, FZE-KPONE BARRIER ROAD.','2021-10-04',1,1,'','Customer','',0),(15,'JOHN NARTEY COMPANY LTD','02441124426','mamalegejen@yahoo.com','Prampram','2021-10-06',1,1,'','Customer','',0),(16,'BMW Mechanic (Iddrisu Akwesi Baah)','0243385443','','Tema Comm 5 (Adj. Santa Barbara School)','2021-10-07',1,1,'','Customer','',0),(17,'WILMAR AFRICA LIMITED','+233 243112320','joseph.ansah@gh.wilmar-intl.com','Tema','2021-10-11',2,2,'','Customer','',0),(18,'Nutrifoods Ghana Limited (Tomato Factory)','+233 244481343','oseiyaw.adom@olamnet.com','Tema (Heavy Ind Area)','2021-10-11',2,2,'','Customer','',0),(19,'Chocomac Ghana Limited','+233 (0)244719989','ywkyei@chocomac.com','Tema FZE','2021-10-11',2,2,'','Customer','',0),(20,'Vehrad Transport & Haulage Co Ltd','0246704008','sammy.husseini@vehradtransport.com','Tema','2021-10-16',1,1,'','Customer','',0),(21,'Global Specialities Oils & Fats Ltd','0204354260','emma.aidoo@gsofl.com','Tema','2021-10-16',1,1,'','Customer','',0),(22,'Satellite Trans Ghana Limited','0544347380','samueladdymensah@yahoo.com','Plot No. 30F-Aflao-Dahwenya Road','2021-10-18',1,1,'','Customer','',0),(23,'MASAE GHANA LIMITED (Abigail Sefa)','0501338864','tmgr@masae-ghana.com','Masae Terminal, Industrial Area, Tema','2021-10-28',1,1,'','Customer','',0),(24,'JOZIDA CONSTRUCTION LTD (ANDREWS AMOAKO)','0246546590','amoakoandy@yahoo.com','COMM 25, VRA ROAD','2021-11-03',1,1,'','Customer','',0),(25,'KOUDIJS GH LTD (Fredrick Armoh)','0540252268','Famoh@koudijs.com.gh','FZE Tema','2021-11-03',1,1,'','Customer','',0),(26,'Van Vliet Automotive Ghana','+233 242438786','infogh@vanvliet-int.com','Aflao Road (Opposite DVLA Tema)','2021-12-08',1,1,'','Customer','',0),(27,'Global Wheels Company Limited','0244930338','percykrakue@gmail.com','Comm 1 Tema (Efua Harlem Bldg)','2021-12-15',1,1,'','Customer','',0),(28,'Cocoa Touton Processing Co Ltd','+233 596912965','w.chanayireh@touton.com','Tema Free Zone Enclave','2021-12-21',1,1,'','Customer','',0),(29,'KEVIC AUTO SERVICE (Victor Kwao)','0244069507','kevicautoservice@yahoo.com','Tema Comm 9','2022-01-14',1,1,'','Customer','',0),(30,'IKEN AUTO-TECH (Mawuli L. Boye)','0208787048 0548455322','tellboye@gmail.com','GN-0872-3757, Behind Emefs Estate, Comm 25','2022-01-31',1,1,'','Customer','',0);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entries`
--

DROP TABLE IF EXISTS `entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entries` (
  `entr_id` int(11) NOT NULL AUTO_INCREMENT,
  `ac_id` int(11) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `debit` varchar(255) NOT NULL,
  `credit` varchar(255) NOT NULL,
  `memo` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `entry_no` varchar(255) NOT NULL,
  `name_description` varchar(255) NOT NULL,
  `credit_type` varchar(255) NOT NULL,
  `debit_type` varchar(255) NOT NULL,
  `entry_type` varchar(255) NOT NULL,
  `group_no` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`entr_id`),
  KEY `gjfk2` (`user_id`),
  CONSTRAINT `gjfk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entries`
--

LOCK TABLES `entries` WRITE;
/*!40000 ALTER TABLE `entries` DISABLE KEYS */;
INSERT INTO `entries` VALUES (1,0,'Accounts Receivable','1412','','','BENKANAS ENTERPRISE',2,'2021-09-07','INV-000001','','Decrease','Increase','INV',1,1),(2,1,'Income','','1412','','BENKANAS ENTERPRISE',2,'2021-09-07','INV-000001','','Decrease','Increase','INV',1,1),(3,0,'Accounts Receivable','348','','','Akwesi Asah (Automatic Transmission Specialist)',5,'2021-09-06','INV-000014','','Decrease','Increase','INV',2,1),(4,1,'Income','','348','','Akwesi Asah (Automatic Transmission Specialist)',5,'2021-09-06','INV-000014','','Decrease','Increase','INV',2,1),(5,0,'Accounts Receivable','232','','','BENKANAS ENTERPRISE',2,'2021-09-07','INV-000012','','Decrease','Increase','INV',3,1),(6,1,'Income','','232','','BENKANAS ENTERPRISE',2,'2021-09-07','INV-000012','','Decrease','Increase','INV',3,1),(7,0,'Accounts Receivable','2220','','','Dominic\'s Automobile',4,'2021-09-07','INV-000018','','Decrease','Increase','INV',4,1),(8,1,'Income','','2220','','Dominic\'s Automobile',4,'2021-09-07','INV-000018','','Decrease','Increase','INV',4,1),(9,0,'Accounts Receivable','29.00','','','BIBIARA NSO NYAME YE SPARE PARTS (EMELIA AYEKY)',3,'2022-01-31','INV-000099','','Decrease','Increase','INV',5,1),(10,1,'Income','','29.00','','BIBIARA NSO NYAME YE SPARE PARTS (EMELIA AYEKY)',3,'2022-01-31','INV-000099','','Decrease','Increase','INV',5,1),(11,0,'Accounts Receivable','1520.00','','','Junelight International Ltd (Mad. Vic Taylor)',6,'2022-01-14','INV-000256','','Decrease','Increase','INV',6,1),(12,1,'Income','','1520.00','','Junelight International Ltd (Mad. Vic Taylor)',6,'2022-01-14','INV-000256','','Decrease','Increase','INV',6,1),(13,0,'Accounts Receivable','348.00','','','Junelight International Ltd (Mad. Vic Taylor)',6,'2022-01-14','INV-000383','','Decrease','Increase','INV',7,1),(14,1,'Income','','348.00','','Junelight International Ltd (Mad. Vic Taylor)',6,'2022-01-14','INV-000383','','Decrease','Increase','INV',7,1);
/*!40000 ALTER TABLE `entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `hist_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `link` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_mang` int(11) NOT NULL,
  PRIMARY KEY (`hist_id`),
  KEY `hist1` (`user_id`),
  KEY `hist2` (`user_mang`),
  CONSTRAINT `hist1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hist2` FOREIGN KEY (`user_mang`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (216,'Logged In','to the APP','2022-01-24 09:35:46','#','',1,1),(217,'Logged In','to the APP','2022-01-25 10:17:36','#','',1,1),(218,'Logged In','to the APP','2022-01-31 09:38:30','#','',1,1),(219,'Updated Invoice','CREDIT SALES 14 SEPT 2021','2022-01-31 09:46:25','?page=viewinvoice&inv_no=INV-000099','',1,1),(220,'added payment','GHs 29','2022-01-31 09:47:34','?page=viewreceipt&rec_no=26&inv_no=INV-000099&cust_id=3&amnt=29','',1,1),(221,'Added Invoice','Dexron VI','2022-01-31 10:02:28','?page=viewinvoice&inv_no=INV-000388','',1,1),(222,'Logged In','to the APP','2022-01-31 12:50:36','#','',1,1),(223,'Added New Customer','IKEN AUTO-TECH (Mawuli L. Boye)','2022-01-31 12:54:20','#','customer',1,1),(224,'Added Proforma','Price List','2022-01-31 13:09:39','?page=viewproforma&inv_no=PRO-000382','',1,1),(225,'Logged In','to the APP','2022-02-08 12:21:44','#','',1,1),(226,'Logged In','to the APP','2022-02-11 14:32:11','#','',1,1),(227,'Added Proforma','REVISED PROFORMA','2022-02-11 14:57:23','?page=viewproforma&inv_no=PRO-000418','',1,1),(228,'Added Proforma','20W-50 & 5W-40','2022-02-11 15:04:03','?page=viewproforma&inv_no=PRO-000420','',1,1),(229,'Logged In','to the APP','2022-02-14 00:59:57','#','',1,1),(230,'Logged In','to the APP','2022-02-14 02:08:30','#','',1,1),(231,'Logged In','to the APP','2022-02-14 04:53:20','#','',1,1),(232,'Logged In','to the APP','2022-02-14 05:07:42','#','',1,1),(233,'Logged In','to the APP','2022-02-14 07:35:33','#','',1,1),(234,'Added Invoice','TEST','2022-02-14 11:52:28','?page=viewinvoice&inv_no=INV-000389','',1,1),(235,'Logged In','to the APP','2022-02-15 13:55:57','#','',1,1),(236,'Logged In','to the APP','2022-02-15 23:10:32','#','',1,1),(237,'Logged In','to the APP','2022-02-16 08:52:44','#','',1,1),(238,'Logged In','to the APP','2022-02-19 12:58:32','#','',1,1),(239,'Logged In','to the APP','2022-02-19 14:07:31','#','',1,1),(240,'Logged In','to the APP','2022-02-19 18:02:14','#','',1,1),(241,'Logged In','to the APP','2022-02-20 08:46:18','#','',1,1),(242,'Logged In','to the APP','2022-02-20 09:30:01','#','',1,1),(243,'Logged In','to the APP','2022-02-21 09:05:05','#','',1,1),(244,'Logged In','to the APP','2022-02-22 04:58:45','#','',1,1),(245,'Logged In','to the APP','2022-02-22 14:03:17','#','',1,1);
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL,
  `reference` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `assigned` varchar(100) NOT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note`
--

LOCK TABLES `note` WRITE;
/*!40000 ALTER TABLE `note` DISABLE KEYS */;
INSERT INTO `note` VALUES (1,'TEST','<p>JIFOJERWE</p>\n','2021-09-01','2','60','Read','1'),(2,'TEST','<p>JIFOJERWE</p>\n','2021-09-01','2','60','Sent','1'),(5,'','Offer is valid up to the end of October 2021. Product quality data sheets can be downloaded from https://www.irvingoil.com/en-CA/blending-packaging/lubricants.','2021-10-04','PRO-000096','note','',''),(6,'','Kindly note that this offer is valid up to the end of October 2021.','2021-10-04','PRO-000140','note','',''),(7,'','PS: This offer is valid up to the end of the month of October 2021.','2021-10-04','PRO-000151','note','',''),(8,'','All prices are valid up to the end of October 2021.','2021-10-06','PRO-000162','note','',''),(9,'','We currently out of stock for the 205L barrels for this product due to a shipment delay. But we have the 18.9L buckets available. New stocks of the barrels will arrive in two weeks all things being equal.','2021-10-07','PRO-000185','note','',''),(10,'','PS; LUBEX-FG is food-grade grease for food processing lines. Infotech Sheets are available online on https://www.irvingoil.com/en-CA/blending-packaging/lubricants and/or via email (on demand). Kindly send email requests for infotech sheets to ceo@novandigh.com or info@novandigh.com','2021-10-11','PRO-000186','note','',''),(11,'','This price list is valid up to end of October 2021. Kindly contact Philip on 0244336509 or email: ceo@novandigh.com','2021-10-16','PRO-000192','note','',''),(12,'','Please Note: The above mentioned quotations are valid up to the end of October 2021. The TRANSFLO\'s are all Automatic Transmission Fluids (ATF). All the aforementioned products are IRVING OIL products.','2021-10-18','PRO-000241','note','',''),(13,'','Note: (1) Transflo is the name of Irving Oil\'s automatic transmission fluid. (2) IDO means Irving Diesel Oil. (3) BLU2 DEF is Irving Oil\'s own brand of Diesel Exhaust Fluid (popularly known as AdBlue).','2021-10-28','PRO-000255','note','',''),(14,'','Note: These quotations are valid up to 15th November 2021.','2021-11-03','PRO-000265','note','',''),(15,'','Note: The total is inclusive of taxes.','2021-11-10','PRO-000302','note','',''),(16,'','The attached prices are valid up to 31st December 2021 and inclusive of statutory taxes and levies.','2021-12-08','PRO-000305','note','',''),(17,'','Prices are inclusive of VAT and valid up to 31st December 2021.','2021-12-15','PRO-000335','note','',''),(18,'','This quotation is valid for seven (7) days effective today 14/01/2022.','2022-01-14','PRO-000352','note','',''),(19,'','Kindly note that the above mentioned quotations are valid for seven (7) days and subject to review and/or change thereafter.','2022-01-31','PRO-000382','note','',''),(20,'','VAT inclusive. This offer is valid for seven (7) calendar days.','2022-02-11','PRO-000420','note','','');
/*!40000 ALTER TABLE `note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` varchar(100) NOT NULL,
  `pay_type` varchar(100) NOT NULL,
  `pay_date` date NOT NULL,
  `pay_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`p_id`),
  KEY `fkicid` (`cust_id`),
  KEY `fkuisid` (`user_id`),
  CONSTRAINT `fkicid` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fkuisid` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (3,'232','Mobile Money','2021-09-02','REC-000001','INV-000012',2,1),(5,'348','Cash','2021-09-06','REC-000004','INV-000014',5,1),(6,'800','Mobile Money','2021-08-24','REC-000006','INV-000027',4,1),(7,'348','Cash','2021-09-07','REC-000007','INV-000001',2,1),(8,'740','Mobile Money','2021-09-22','REC-000008','INV-000115',4,1),(9,'60','Mobile Money','2021-09-22','REC-000009','INV-000125',4,1),(10,'760','Mobile Money','2021-09-24','REC-000010','INV-000126',9,1),(11,'348','Cash','2021-09-30','REC-000011','INV-000024',4,1),(12,'452','Cash','2021-09-30','REC-000012','INV-000125',4,1),(13,'1500','Cheque','2021-10-01','REC-000013','INV-000032',6,1),(14,'696','Mobile Money','2021-10-11','REC-000014','INV-000134',5,1),(16,'696','Mobile Money','2021-10-22','REC-000016','INV-000187',5,1),(17,'1500','Cheque','2021-10-21','REC-000017','INV-000032',6,1),(18,'4','Cash','2021-12-01','REC-000018','INV-000125',4,1),(19,'43','Cash','2021-12-01','REC-000019','INV-000128',4,1),(20,'473','Cash','2021-12-01','REC-000020','INV-000127',4,1),(21,'530','Cash','2021-12-01','REC-000021','INV-000018',4,1),(22,'532','Cash','2021-12-16','REC-000022','INV-000001',2,1),(23,'1000','Cheque','2021-12-16','REC-000023','INV-000018',4,1),(24,'348','Cash','2021-12-23','REC-000024','INV-000022',2,1),(25,'1440','Cheque','2022-01-13','REC-000025','INV-000032',6,1),(26,'29','Cash','2022-01-28','REC-000026','INV-000099',3,1);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_code` varchar(100) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `prod_qty` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `buying_price` varchar(100) NOT NULL,
  `selling_price` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `package` varchar(100) NOT NULL,
  `updated_on` date NOT NULL,
  PRIMARY KEY (`prod_id`),
  KEY `fkcat` (`cat_id`),
  CONSTRAINT `fkcat` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'','IRVING MAX1 ADV SYN DEXOS 0W20 (0.95L)','',9,'','40','2021-07-31 11:15:51','','2022-01-14'),(2,'','IRVING MAX 1 ADVANCE SYNTHETIC DEXOS 0W-20 (5L) ','36',1,'','190','2021-07-31 11:15:51','Pcs','2022-01-20'),(3,'','IRVING MAX 1 ADVANCED SYNTHETIC 5W-20 (0.95L)','',1,'','39.50','2021-07-31 11:15:51','Pcs','2022-01-14'),(4,'','IRVING MAX 1 ADVANCED SYNTHETIC 5W-20 (5L)','41',1,'','185','2021-07-31 11:15:51','Pcs','2022-01-14'),(5,'','IRVING MAX 1 ADVANCE SYNTHETIC DEXOS 5W-30 (0.95L)','',1,'','39','2021-07-31 11:15:51','Pcs','2022-01-14'),(6,'','IRVING MAX 1 ADVANCE SYNTHETIC DEXOS 5W-30 (5L)','21',1,'','180','2021-07-31 11:15:51','Pcs','2022-01-14'),(7,'','IRVING MAX 1 SYNTHETIC BLEND 10W-40 (0.95L)','',1,'','30','2021-07-31 11:15:51','Pcs','2022-01-14'),(8,'','IRVING MAX 1 SYNTHETIC BLEND 10W-40 (3.79L)','20',1,'','115','2021-07-31 11:15:51','Pcs','2022-01-14'),(9,'','IRVING MAX 1 20W-50 SN (0.95L)','',1,'','24','2021-07-31 11:15:51','Pcs','2022-01-14'),(10,'','IRVING MAX 1 20W-50 SN (5L)','',1,'','115','2021-07-31 11:15:51','Pcs','2022-01-14'),(11,'','IRVING ADVANT 5W-40 (0.95L)','',1,'','38','2021-07-31 11:15:51','Pcs','2022-01-14'),(12,'','IRVING ADVANT 5W-40 (5L)','',1,'','178.50','2021-07-31 11:15:51','Pcs','2022-01-14'),(13,'','IRVING DIESEL OIL PREMIUM+ PLUS 15W-40 CI-4 (205L)','',4,'','4700','2021-07-31 11:15:51','Pcs','2022-01-14'),(14,'','IRVING DIESEL OIL PREMIUM PLUS+HEAVY DUTY 15W-40 CK-4 (0.95L)','',4,'','28','2021-07-31 11:15:51','Pcs','2022-01-14'),(15,'','IRVING DIESEL OIL PREMIUM PLUS+HEAVY DUTY 15W-40 CK-4 (5L)','41',4,'','133','2021-07-31 11:15:51','Pcs','2022-01-14'),(16,'','IRVING DIESEL OIL PREMIUM PLUS+HEAVY DUTY 15W-40 CK-4 (205L)','',4,'','5400','2021-07-31 11:15:51','Pcs','2022-01-14'),(17,'','IRVING DIESEL OIL UNIVERSAL SYNTHETIC 5W-40 (5L)','8',4,'','136','2021-07-31 11:15:51','Pcs','2022-01-14'),(18,'','IRVING BLU2 DIESEL EXHAUST FLUID (1 X 3.79L)','',9,'','56','2021-07-31 11:15:51','Pcs','2022-01-14'),(19,'','IRVING BLU2 DIESEL EXHAUST FLUID (1 X 9.46L)','',9,'','121','2021-07-31 11:15:51','Pcs','2022-01-14'),(20,'','ATF - IRVING TRANSFLO DEXIII/MERC (0.95L)','496',5,'','29','2021-07-31 11:15:51','Pcs','2022-01-20'),(21,'','ATF - IRVING TRANSFLO DEXIII (3.79L)','',5,'','108','2021-07-31 11:15:51','Pcs','2022-01-14'),(22,'','ATF - IRVING TRANSFLO DEXIII (205L)','',5,'','5400','2021-07-31 11:15:51','Pcs','2022-01-14'),(23,'','ATF - IRVING TRANSFLO DEXRON VI (0.95L)','24',5,'','43','2021-07-31 11:15:51','Pcs','2022-01-14'),(24,'','ATF - IRVING TRANSFLO MV - MERCON V (0.95L)','27',12,'','43','2021-07-31 11:15:51','Bags','2022-02-20'),(25,'','IRVING HDH 80W90 (205L)','',6,'','4900','2021-07-31 11:15:51','Pcs','2022-01-14'),(26,'','IRVING HDH 85W140 (60L)','',6,'','1950','2021-07-31 11:15:51','Pcs','2022-01-14'),(27,'','IRVING HDH 85W140 (205L)','',6,'','5438','2021-07-31 11:15:51','Pcs','2022-01-14'),(28,'','IRVING GEAR OIL 150 (18.9L)','',6,'','435','2021-07-31 11:15:51','Pcs','2022-01-14'),(29,'','IRVING GEAR OIL 150 (205L)','',6,'','4350','2021-07-31 11:15:51','Pcs','2022-01-14'),(30,'','IRVING GEAR OIL 220 (18.9L)','',6,'','459.50','2021-07-31 11:15:51','Pcs','2022-01-14'),(31,'','IRVING GEAR OIL 220 205L','',6,'','4500','2021-07-31 11:15:51','Pcs','2022-01-14'),(32,'','IRVING GEAR OIL 320 18.9L','',6,'','480','2021-07-31 11:15:51','Pcs','2022-01-14'),(33,'','IRVING GEAR OIL 320 (205L)','',6,'','4750','2021-07-31 11:15:51','Pcs','2022-01-14'),(34,'','IRVING GEAR OIL 460 (205L)','',6,'','4890','2021-07-31 11:15:51','Pcs','2022-01-14'),(35,'','IRVING HYDRAULIC 32 (18.9L)','',7,'','390','2021-07-31 11:15:51','Pcs','2022-01-14'),(36,'','IRVING HYDRAULIC 32 (M) (205L)','',7,'','3800','2021-07-31 11:15:51','Pcs','2022-01-14'),(37,'','IRVING HYDRAULIC 46 (18.9L)','',7,'','405','2021-07-31 11:15:51','Pcs','2022-01-14'),(38,'','IRVING HYDRAULIC 46 (205L)','',7,'','3950','2021-07-31 11:15:51','Pcs','2022-01-14'),(39,'','IRVING HYDRAULIC 68 (18.9L)','',7,'','420','2021-07-31 11:15:51','Pcs','2022-01-14'),(40,'','IRVING HYDRAULIC 68 (205L)','',7,'','4070','2021-07-31 11:15:51','Pcs','2022-01-14'),(41,'','IRVING TRACTOR HYDRAULIC 3 SEASON (18.9L)','',7,'','485','2021-07-31 11:15:51','Pcs','2022-01-14'),(42,'','IRVING TRACTOR HYDRAULIC 3 SEASON (205L)','',7,'','4796','2021-07-31 11:15:51','Pcs','2022-01-14'),(43,'','IRVING TRACTOR HYD PREMIUM 4 SEASON (18.9L)','',7,'','665','2021-07-31 11:15:51','Pcs','2022-01-14'),(44,'','IRVING TRACTOR HYD PREMIUM 4 SEASON (205L)','',7,'','6715','2021-07-31 11:15:51','Pcs','2022-01-14'),(45,'','IRVING LUBEX FOOD GRADE GREASE (400GR TUBE)','1',8,'','30.20','2021-07-31 11:15:51','Pcs','2022-01-14'),(46,'','IRVING LUBEX MP #2 GREASE (400GR TUBE) - MULTI PURPOSE','',8,'','18','2021-07-31 11:15:51','Pcs','2022-01-14'),(47,'','IRVING LUBEX-EP 2 SPECIAL (RED) GREASE (400GR TUBE)','',8,'','25','2021-07-31 11:15:51','Pcs','2022-01-14'),(48,'','IRVING LUBEX-EP 2 SPECIAL (RED) GREASE (55KG)','',8,'','2400','2021-07-31 11:15:51','Pcs','2022-01-14'),(49,'','IRVING LUBEX-EP2 GREASE (400GR TUBE)','',8,'','22','2021-07-31 11:15:51','Pcs','2022-01-14'),(50,'','IRVING LUBEX-EP2 GREASE (17KG)','',8,'','702','2021-07-31 11:15:51','Pcs','2022-01-14'),(51,'','IRVING LUBEX-EP2 GREASE (180KG)','',8,'','6663','2021-07-31 11:15:51','Pcs','2022-01-14'),(52,'','IRVING LUBEX-EP2 GREASE (55KG)','',8,'','2250','2021-07-31 11:15:51','Pcs','2022-01-14'),(53,'','IRVING LUBEX FOOD-GRADE GREASE (55KG)','1',8,'','3800','2021-07-31 11:15:51','Pcs','2022-01-14'),(54,'','IRVING LUBEX MP#2 GREASE (55KG)','',8,'','2062','2021-07-31 11:15:51','Pcs','2022-01-14'),(55,'','IRVING LUBEX SYNTHETIC 2(46) GREASE (17KG)','',8,'','982','2021-07-31 11:15:51','Pcs','2022-01-14'),(56,'','IRVING UNIVERSAL ANTIFREEZE (US ONLY) RADIATOR COOLANT (3.8L)','',10,'','92','2021-07-31 11:15:51','Pcs','2022-01-14'),(57,'','US IRVING DIESEL COOLANT - PREMIX H/D EXTENDED LIFE - ANTIFREEZE (3.79L)','',10,'','80.50','2021-07-31 11:15:51','Pcs','2022-01-14'),(58,'','IRVING SYN E COMPRESSOR OIL 100 (MAERSK - AOF) 18.90L','',11,'','2870','2021-07-31 11:15:51','Pcs','2022-01-14'),(59,'','IRVING SYN P COMPRESSOR OIL 46 (MAERSK AOF) 18.90L','',11,'','3590','2021-07-31 11:15:51','Pcs','2022-01-14'),(79,'','AMA YAYRA','3',6,'','44','2022-02-14 11:50:11','Pcs','2022-02-14'),(80,'','AMA','7',8,'','44','2022-02-20 09:57:44','Boxes','2022-02-20'),(81,'','SAMSUNG PHONE','3',14,'','44','2022-02-20 14:38:45','Boxes','2022-02-20'),(82,'','ADARA','3',8,'','44','2022-02-20 15:16:56','Boxes','2022-02-20');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'admin'),(2,'user'),(3,'manager'),(4,'customer'),(5,'agent');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_price` varchar(100) NOT NULL,
  `qty` varchar(100) NOT NULL,
  `total` varchar(100) NOT NULL,
  `subtotal` varchar(100) NOT NULL,
  `vat` varchar(100) NOT NULL,
  `tduration` varchar(100) NOT NULL,
  `grandtotal` varchar(100) NOT NULL,
  `discount` varchar(100) NOT NULL,
  `trans_type` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `project` varchar(100) NOT NULL,
  `vat_rate` varchar(100) NOT NULL,
  `nhil` varchar(100) NOT NULL,
  `getfund` varchar(100) NOT NULL,
  `nhils` varchar(100) NOT NULL,
  `getfunds` varchar(100) NOT NULL,
  `discount_rate` varchar(100) NOT NULL,
  `exp_date` date NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `ac_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`s_id`),
  KEY `fkcid` (`cust_id`),
  KEY `fkusid` (`user_id`),
  CONSTRAINT `fkcid` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fkusid` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=423 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (8,'133','8','1064','1412','0','','1412','0','invoice','2021-09-03 08:34:26','INV-000001','IDO 15W40 (5L) & DEXIII (1L) - 3 SEPT 2021','','','','0','0','','2022-02-17',15,'IDO PREMIUM + 15W40 CK-4 (5L)','','',2,0,1,0),(12,'29','8','232','232','0','','232','0','invoice','2021-09-02 08:37:01','INV-000012','TRANSFLO DEXIII - 8 BOTTLES (2/09/21)','','','','0','0','','2022-02-18',20,'TRANSFLO DEXIII/MERC (0.95L)','','',2,0,1,0),(13,'29','12','348','1412','0','','1412','0','invoice','2021-09-03 08:34:26','INV-000001','IDO 15W40 (5L) & DEXIII (1L) - 3 SEPT 2021','','','','0','0','','2021-09-13',20,'TRANSFLO DEXIII/MERC (0.95L)','','',2,0,1,0),(18,'185','4','740','2220','0','','2220','0','invoice','2021-09-06 08:46:26','INV-000018','0W20 / 5W20 / 5W30 (5L)','','','','0','0','','2021-09-13',4,'MAX 1 ADVANCED SYN 5W20 (5L)','','',4,0,1,0),(19,'190','4','760','2220','0','','2220','0','invoice','2021-09-06 08:46:26','INV-000018','0W20 / 5W20 / 5W30 (5L)','','','','0','0','','2021-09-13',2,'MAX 1 ADV SYN DEXOS 0W20 (5L)','','',4,0,1,0),(20,'180','4','720','2220','0','','2220','0','invoice','2021-09-06 08:46:26','INV-000018','0W20 / 5W20 / 5W30 (5L)','','','','0','0','','2021-09-13',6,'MAX 1 ADV SYN DEXOS 5W30 (5L)','','',4,0,1,0),(21,'29','12','348','348','0','','348','0','invoice','2021-09-06 10:31:05','INV-000014','DEXIII (1L)','','','','0','0','','2021-09-06',20,'TRANSFLO DEXIII/MERC (0.95L)','','',5,0,1,0),(23,'29','12','348','348','0','','348','0','invoice','2021-09-06 14:23:23','INV-000022','DEXIII (12x1L) ATF','','','','0','0','','2022-02-16',20,'TRANSFLO DEXIII/MERC (0.95L)','','',2,0,1,0),(24,'29','12','348','348','0','','348','0','invoice','2021-09-06 14:27:41','INV-000024','DEXIII','','','','0','0','','2021-09-13',20,'TRANSFLO DEXIII/MERC (0.95L)','','',4,0,1,0),(31,'200','4','800','800','0','','800','0','invoice','2021-08-16 08:21:23','INV-000027','1sale 0W20 (1 carton)','','','','0','0','','2021-08-24',2,'MAX 1 ADV SYN DEXOS 0W20 (5L)','','',4,0,1,0),(64,'29','1','29','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',20,'TRANSFLO DEXIII/MERC (0.95L)','','',7,0,1,0),(65,'108','1','108','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',21,'TRANSFLO DEXIII/MERC (3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',7,0,1,0),(66,'43','1','43','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',23,'TRANSFLO DEXRON VI (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',7,0,1,0),(67,'43','1','43','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',24,'TRANSFLO MV - MERCON V (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',7,0,1,0),(68,'56','1','56','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',18,'BLU2 DEF, (1 X 3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',7,0,1,0),(69,'121','1','121','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',19,'BLU2 DEF, (1 X 9.46L)','','DIESEL EXHAUST FLUID',7,0,1,0),(70,'435','1','435','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',28,'GEAR OIL 150 (18.9L)','','DIESEL EXHAUST FLUID',7,0,1,0),(71,'459.50','1','459.50','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',30,'GEAR OIL 220 (18.9L)','','GEAR OILS',7,0,1,0),(72,'480','1','480','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',32,'GEAR OIL 320 18.9L','','GEAR OILS',7,0,1,0),(73,'4890','1','4890','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',34,'GEAR OIL 460 (205L)','','GEAR OILS',7,0,1,0),(74,'390','1','390','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',35,'HYDRAULIC 32 (18.9L)','','GEAR OILS',7,0,1,0),(75,'405','1','405','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',37,'HYDRAULIC 46 (18.9L)','','HYDRAULIC OIL',7,0,1,0),(76,'420','1','420','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',39,'HYDRAULIC 68 (18.9L)','','HYDRAULIC OIL',7,0,1,0),(77,'485','1','485','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',41,'TRACTOR HYDRAULIC 3 SEASON (18.9L)','','HYDRAULIC OIL',7,0,1,0),(78,'665','1','665','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',43,'TRACTOR HYD PREMIUM 4 SEASON (18.9L)','','HYDRAULIC OIL',7,0,1,0),(79,'28','1','28','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',14,'IDO PREMIUM + 15W40 CK-4 (0.95L)','','HYDRAULIC OIL',7,0,1,0),(80,'133','1','133','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',15,'IDO PREMIUM + 15W40 CK-4 (5L)','','LUBRICANTS (DIESEL)',7,0,1,0),(81,'140','1','140','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',17,'IDO UNIVERSAL SYN 5W40 (5L)','','LUBRICANTS (DIESEL)',7,0,1,0),(82,'40','1','40','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',1,'MAX 1 ADV SYN DEXOS 0W20 (0.95L)','','LUBRICANTS (DIESEL)',7,0,1,0),(83,'190','1','190','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',2,'MAX 1 ADV SYN DEXOS 0W20 (5L)','','LUBRICANTS (PETROL)',7,0,1,0),(84,'39.50','1','39.50','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',3,'MAX 1 ADVANCED SYN 5W20 (0.95)','','LUBRICANTS (PETROL)',7,0,1,0),(85,'185','1','185','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',4,'MAX 1 ADVANCED SYN 5W20 (5L)','','LUBRICANTS (PETROL)',7,0,1,0),(86,'39','1','39','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',5,'MAX 1 ADV SYN DEXOS 5W30 (0.95L)','','LUBRICANTS (PETROL)',7,0,1,0),(87,'180','1','180','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',6,'MAX 1 ADV SYN DEXOS 5W30 (5L)','','LUBRICANTS (PETROL)',7,0,1,0),(88,'30','1','30','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',7,'MAX 1 SYN BLEND 10W40 (0.95L)','','LUBRICANTS (PETROL)',7,0,1,0),(89,'115','1','115','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',8,'MAX 1 SYN BLEND 10W40 (3.79L)','','LUBRICANTS (PETROL)',7,0,1,0),(90,'24','1','24','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',9,'MAX 1-20W50 (SN) 0.95L','','LUBRICANTS (PETROL)',7,0,1,0),(91,'115','1','115','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',10,'MAX 1-20W50 (SN) 5L','','LUBRICANTS (PETROL)',7,0,1,0),(92,'38','1','38','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',11,'ADVANT 5W40 (0.95L)','','LUBRICANTS (PETROL)',7,0,1,0),(93,'178.50','1','178.50','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',12,'ADVANT 5W40 (5L)','','LUBRICANTS (PETROL)',7,0,1,0),(94,'92','1','92','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',56,'UNIVERSAL ANTIFREEZE (US ONLY) 3.8L','','LUBRICANTS (PETROL)',7,0,1,0),(95,'80.50','1','80.50','10677','0','1','10677','0','proforma','2021-09-07 20:07:07','PRO-000064','LUBE/DEF/HYD/etc','','','','0','0','','0000-00-00',57,'US IDC PREMIX H/D EXT/LIFE ANTIFREEZE (3.79L)','','RADIATOR COOLANT',7,0,1,0),(96,'190','8','1520','4440','0','9','4440','0','invoice','2021-09-08 12:52:46','INV-000032','0W20/5W20/5W30','','','','0','0','','2022-02-16',2,'MAX 1 ADV SYN DEXOS 0W20 (5L) ','','',6,0,1,0),(97,'185','8','1480','4440','0','9','4440','0','invoice','2021-09-08 12:52:46','INV-000032','0W20/5W20/5W30','','','','0','0','','2021-09-17',4,'MAX 1 ADVANCED SYN 5W20 (5L)','','LUBRICANTS (PETROL)',6,0,1,0),(98,'180','8','1440','4440','0','9','4440','0','invoice','2021-09-08 12:52:46','INV-000032','0W20/5W20/5W30','','','','0','0','','2021-09-17',6,'MAX 1 ADV SYN DEXOS 5W30 (5L)','','LUBRICANTS (PETROL)',6,0,1,0),(113,'29','1','29.00','29','0','-123','29.00','0.00','invoice','2022-01-31 09:46:25','INV-000099','CREDIT SALES 14 SEPT 2021','','','','0.00','0','','2021-09-30',20,'TRANSFLO DEXIII/MERC (0.95L)','','',3,0,1,0),(122,'185','4','740','740','0','10','740','0','invoice','2021-09-14 15:51:09','INV-000115','CREDIT SALES 14SEPT2021/INV1181352','','','','0','0','','2021-09-24',4,'MAX 1 ADVANCED SYN 5W20 (5L)','','',4,0,1,0),(125,'43','12','516','516','0','16','516','0','invoice','2021-09-14 08:40:36','INV-000125','MERCON V (0.95L)','','','','0','0','','2021-09-30',24,'TRANSFLO MV - MERCON V (0.95L)','','',4,0,1,0),(126,'190','4','760','760','0','3','760','0','invoice','2021-09-24 08:33:44','INV-000126','0W20','','','','0','0','','2021-09-27',2,'MAX 1 ADV SYN DEXOS 0W20 (5L) ','','',9,0,1,0),(127,'43','11','473','473','0','8','473','0','invoice','2021-09-23 08:50:47','INV-000127','DEXRON VI','','','','0','0','','2021-10-01',23,'TRANSFLO DEXRON VI (0.95L)','','',4,0,1,0),(128,'43','1','43','43','0','8','43','0','invoice','2021-09-23 08:52:37','INV-000128','DEXRON VI','','','','0','0','','2021-10-01',23,'TRANSFLO DEXRON VI (0.95L)','','',4,0,1,0),(129,'190','8','1520','5460','0','15','5460','0','invoice','2021-09-30 07:45:54','INV-000129','ENGINE OILS','','','','0','0','','2022-02-16',2,'MAX 1 ADV SYN DEXOS 0W20 (5L) ','','',10,0,1,0),(130,'185','8','1480','5460','0','15','5460','0','invoice','2021-09-30 07:45:54','INV-000129','ENGINE OILS','','','','0','0','','2021-10-15',4,'MAX 1 ADVANCED SYN 5W20 (5L)','','LUBRICANTS (PETROL)',10,0,1,0),(131,'180','8','1440','5460','0','15','5460','0','invoice','2021-09-30 07:45:54','INV-000129','ENGINE OILS','','','','0','0','','2021-10-15',6,'MAX 1 ADV SYN DEXOS 5W30 (5L)','','LUBRICANTS (PETROL)',10,0,1,0),(132,'115','4','460','5460','0','15','5460','0','invoice','2021-09-30 07:45:54','INV-000129','ENGINE OILS','','','','0','0','','2021-10-15',8,'MAX 1 SYN BLEND 10W40 (3.79L)','','LUBRICANTS (PETROL)',10,0,1,0),(133,'140','4','560','5460','0','15','5460','0','invoice','2021-09-30 07:45:54','INV-000129','ENGINE OILS','','','','0','0','','2021-10-15',17,'IDO UNIVERSAL SYN 5W40 (5L)','','LUBRICANTS (PETROL)',10,0,1,0),(134,'3800','1','3800','17205.2','0.00','NaN','17205.20','0.00','proforma','2021-10-04 11:20:29','PRO-000096','PROFORMA INVOICE','','','','0.00','0.00','','0000-00-00',53,'LUBEX-FG, 55KG','','',11,0,1,0),(135,'30.20','1','30.20','17205.2','0.00','NaN','17205.20','0.00','proforma','2021-10-04 11:20:29','PRO-000096','PROFORMA INVOICE','','','','0.00','0.00','','0000-00-00',45,'LUBEX-FG, 400GR TUBE','','',11,0,1,0),(136,'6663','1','6663','17205.2','0.00','NaN','17205.20','0.00','proforma','2021-10-04 11:20:29','PRO-000096','PROFORMA INVOICE','','','','0.00','0.00','','0000-00-00',51,'LUBEX-EP 2, 180KG','','',11,0,1,0),(137,'2250','1','2250','17205.2','0.00','NaN','17205.20','0.00','proforma','2021-10-04 11:20:29','PRO-000096','PROFORMA INVOICE','','','','0.00','0.00','','0000-00-00',52,'LUBEX-EP 2, 55KG','','',11,0,1,0),(138,'2400','1','2400','17205.2','0.00','NaN','17205.20','0.00','proforma','2021-10-04 11:20:29','PRO-000096','PROFORMA INVOICE','','','','0.00','0.00','','0000-00-00',48,'LUBEX-EP 2 SPECIAL (RED), 55KG','','',11,0,1,0),(139,'2062','1','2062','17205.2','0.00','NaN','17205.20','0.00','proforma','2021-10-04 11:20:29','PRO-000096','PROFORMA INVOICE','','','','0.00','0.00','','0000-00-00',54,'LUBEX MP #2, 55KG','','',11,0,1,0),(140,'1950','1','1950','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',26,'HDH 85W140 (60L)','','',12,0,1,0),(141,'4900','1','4900','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',25,'HDH 80W90 (205L)','','GEAR OILS',12,0,1,0),(142,'5438','1','5438','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',27,'HDH 85W140 (205L)','','GEAR OILS',12,0,1,0),(143,'435','1','435','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',28,'GEAR OIL 150 (18.9L)','','GEAR OILS',12,0,1,0),(144,'459.50','1','459.50','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',30,'GEAR OIL 220 (18.9L)','','GEAR OILS',12,0,1,0),(145,'480','1','480','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',32,'GEAR OIL 320 18.9L','','GEAR OILS',12,0,1,0),(146,'4890','1','4890','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',34,'GEAR OIL 460 (205L)','','GEAR OILS',12,0,1,0),(147,'29','1','29','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',20,'TRANSFLO DEXIII/MERC (0.95L)','','GEAR OILS',12,0,1,0),(148,'43','1','43','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',23,'TRANSFLO DEXRON VI (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',12,0,1,0),(149,'43','1','43','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',24,'TRANSFLO MV - MERCON V (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',12,0,1,0),(150,'108','1','108','18775.5','0.00','0','18775.50','0.00','proforma','2021-10-04 11:54:04','PRO-000140','Proforma Gear Oil','','','','0.00','0.00','','0000-00-00',21,'TRANSFLO DEXIII/MERC (3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',12,0,1,0),(151,'190','1','190','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',2,'MAX 1 ADV SYN DEXOS 0W20 (5L) ','','',14,0,1,0),(152,'185','1','185','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',4,'MAX 1 ADVANCED SYN 5W20 (5L)','','LUBRICANTS (PETROL)',14,0,1,0),(153,'180','1','180','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',6,'MAX 1 ADV SYN DEXOS 5W30 (5L)','','LUBRICANTS (PETROL)',14,0,1,0),(154,'29','1','29','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',20,'TRANSFLO DEXIII/MERC (0.95L)','','LUBRICANTS (PETROL)',14,0,1,0),(155,'108','1','108','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',21,'TRANSFLO DEXIII/MERC (3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',14,0,1,0),(156,'43','1','43','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',23,'TRANSFLO DEXRON VI (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',14,0,1,0),(157,'43','1','43','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',24,'TRANSFLO MV - MERCON V (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',14,0,1,0),(158,'115','1','115','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',8,'MAX 1 SYN BLEND 10W40 (3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',14,0,1,0),(159,'115','1','115','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',10,'MAX 1-20W50 (SN) 5L','','LUBRICANTS (PETROL)',14,0,1,0),(160,'133','1','133','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',15,'IDO PREMIUM + 15W40 CK-4 (5L)','','LUBRICANTS (PETROL)',14,0,1,0),(161,'140','1','140','1281','0.00','0','1281.00','0.00','proforma','2021-10-04 16:38:51','PRO-000151','PROFORMA 4/10/21','','','','0.00','0.00','','0000-00-00',17,'IDO UNIVERSAL SYN 5W40 (5L)','','LUBRICANTS (DIESEL)',14,0,1,0),(162,'4700','1','4700','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',13,'IDO PREMIUM + 15W40 CI-4 (205L)','','',15,0,1,0),(163,'5400','1','5400','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',16,'IDO PREMIUM + 15W40 CK-4 (205L)','','LUBRICANTS (DIESEL)',15,0,1,0),(164,'133','1','133','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',15,'IDO PREMIUM + 15W40 CK-4 (5L)','','LUBRICANTS (DIESEL)',15,0,1,0),(165,'140','1','140','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',17,'IDO UNIVERSAL SYN 5W40 (5L)','','LUBRICANTS (DIESEL)',15,0,1,0),(166,'4900','1','4900','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',25,'HDH 80W90 (205L)','','LUBRICANTS (DIESEL)',15,0,1,0),(167,'5438','1','5438','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',27,'HDH 85W140 (205L)','','GEAR OILS',15,0,1,0),(168,'1950','1','1950','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',26,'HDH 85W140 (60L)','','GEAR OILS',15,0,1,0),(169,'4350','1','4350','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',29,'GEAR OIL 150 (205L)','','GEAR OILS',15,0,1,0),(170,'435','1','435','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',28,'GEAR OIL 150 (18.9L)','','GEAR OILS',15,0,1,0),(171,'4500','1','4500','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',31,'GEAR OIL 220 205L','','GEAR OILS',15,0,1,0),(172,'459.50','1','459.50','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',30,'GEAR OIL 220 (18.9L)','','GEAR OILS',15,0,1,0),(173,'4750','1','4750','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',33,'GEAR OIL 320 (205L)','','GEAR OILS',15,0,1,0),(174,'480','1','480','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',32,'GEAR OIL 320 18.9L','','GEAR OILS',15,0,1,0),(175,'4890','1','4890','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',34,'GEAR OIL 460 (205L)','','GEAR OILS',15,0,1,0),(176,'390','1','390','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',35,'HYDRAULIC 32 (18.9L)','','GEAR OILS',15,0,1,0),(177,'405','1','405','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',37,'HYDRAULIC 46 (18.9L)','','HYDRAULIC OIL',15,0,1,0),(178,'420','1','420','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',39,'HYDRAULIC 68 (18.9L)','','HYDRAULIC OIL',15,0,1,0),(179,'485','1','485','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',41,'TRACTOR HYDRAULIC 3 SEASON (18.9L)','','HYDRAULIC OIL',15,0,1,0),(180,'665','1','665','44890.5','0.00','0','44890.50','0.00','proforma','2021-10-06 15:43:04','PRO-000162','Proforma Invoice','','','','0.00','0.00','','0000-00-00',43,'TRACTOR HYD PREMIUM 4 SEASON (18.9L)','','HYDRAULIC OIL',15,0,1,0),(183,'5400','1','5400','5820','0.00','0','5820.00','0.00','proforma','2021-10-07 16:14:31','PRO-000181','PROFORMA','','','','0.00','0.00','','0000-00-00',22,'TRANSFLO DEXIII (205L)','','',13,0,1,0),(184,'420','1','420','5820','0.00','0','5820.00','0.00','proforma','2021-10-07 16:14:31','PRO-000181','PROFORMA','','','','0.00','0.00','','0000-00-00',39,'HYDRAULIC 68 (18.9L)','','AUTOMATIC TRANSMISSION OIL (ATF)',13,0,1,0),(185,'4070','1','4070','4070','0.00','NaN','4070.00','0.00','proforma','2021-10-07 16:22:32','PRO-000185','HYDRAULIC 68 (DRUM 205L)','','','','0.00','0.00','','0000-00-00',40,'HYDRAULIC 68 (205L)','','',13,0,1,0),(186,'29','24','696.00','696','0.00','0','696.00','0.00','invoice','2021-10-11 07:57:37','INV-000134','DEX III - 24X1L','','','','0.00','0.00','','2022-02-17',20,'TRANSFLO DEXIII/MERC (0.95L)','','',5,0,1,0),(187,'3800','1','3800','12918.2','0.00','NaN','12918.20','0.00','proforma','2021-10-11 15:28:51','PRO-000186','Price List','','','','0.00','0.00','','0000-00-00',53,'LUBEX-FG, 55KG','','',17,0,1,0),(188,'30.20','1','30.20','12918.2','0.00','NaN','12918.20','0.00','proforma','2021-10-11 15:28:51','PRO-000186','Price List','','','','0.00','0.00','','0000-00-00',45,'LUBEX-FG, 400GR TUBE','','',17,0,1,0),(189,'2400','1','2400','12918.2','0.00','NaN','12918.20','0.00','proforma','2021-10-11 15:28:51','PRO-000186','Price List','','','','0.00','0.00','','0000-00-00',48,'LUBEX-EP 2 SPECIAL (RED), 55KG','','',17,0,1,0),(190,'25','1','25','12918.2','0.00','NaN','12918.20','0.00','proforma','2021-10-11 15:28:51','PRO-000186','Price List','','','','0.00','0.00','','0000-00-00',47,'LUBEX-EP 2 SPECIAL (RED), 400GR TUBE','','',17,0,1,0),(191,'6663','1','6663','12918.2','0.00','NaN','12918.20','0.00','proforma','2021-10-11 15:28:51','PRO-000186','Price List','','','','0.00','0.00','','0000-00-00',51,'LUBEX-EP 2, 180KG','','',17,0,1,0),(192,'29','1','29','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',20,'TRANSFLO DEXIII/MERC (0.95L)','','',20,0,1,0),(193,'108','1','108','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',21,'TRANSFLO DEXIII (3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',20,0,1,0),(194,'5400','1','5400','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',22,'TRANSFLO DEXIII (205L)','','AUTOMATIC TRANSMISSION OIL (ATF)',20,0,1,0),(195,'43','1','43','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',23,'TRANSFLO DEXRON VI (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',20,0,1,0),(196,'43','1','43','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',24,'TRANSFLO MV - MERCON V (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',20,0,1,0),(197,'56','1','56','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',18,'BLU2 DEF, 1 X 2.5GAL (1 X 3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',20,0,1,0),(198,'121','1','121','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',19,'BLU2 DEF, 1 X 2.5GAL (1 X 9.46L)','','DIESEL EXHAUST FLUID',20,0,1,0),(199,'4900','1','4900','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',25,'HDH 80W90 (205L)','','DIESEL EXHAUST FLUID',20,0,1,0),(200,'1950','1','1950','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',26,'HDH 85W140 (60L)','','GEAR OILS',20,0,1,0),(201,'5438','1','5438','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',27,'HDH 85W140 (205L)','','GEAR OILS',20,0,1,0),(202,'435','1','435','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',28,'GEAR OIL 150 (18.9L)','','GEAR OILS',20,0,1,0),(203,'4350','1','4350','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',29,'GEAR OIL 150 (205L)','','GEAR OILS',20,0,1,0),(204,'459.50','1','459.50','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',30,'GEAR OIL 220 (18.9L)','','GEAR OILS',20,0,1,0),(205,'4500','1','4500','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',31,'GEAR OIL 220 205L','','GEAR OILS',20,0,1,0),(206,'480','1','480','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',32,'GEAR OIL 320 18.9L','','GEAR OILS',20,0,1,0),(207,'4750','1','4750','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',33,'GEAR OIL 320 (205L)','','GEAR OILS',20,0,1,0),(208,'4890','1','4890','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',34,'GEAR OIL 460 (205L)','','GEAR OILS',20,0,1,0),(209,'18','1','18','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',46,'LUBEX MP #2, 400GR TUBE','','GEAR OILS',20,0,1,0),(210,'25','1','25','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',47,'LUBEX-EP 2 SPECIAL (RED), 400GR TUBE','','GREASE',20,0,1,0),(211,'2400','1','2400','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',48,'LUBEX-EP 2 SPECIAL (RED), 55KG','','GREASE',20,0,1,0),(212,'22','1','22','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',49,'LUBEX-EP 2, 400GR TUBE','','GREASE',20,0,1,0),(213,'702','1','702','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',50,'LUBEX-EP 2, (17KG)','','GREASE',20,0,1,0),(214,'6663','1','6663','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',51,'LUBEX-EP 2, 180KG','','GREASE',20,0,1,0),(215,'2250','1','2250','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',52,'LUBEX-EP 2, 55KG','','GREASE',20,0,1,0),(216,'2062','1','2062','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',54,'LUBEX MP #2, 55KG','','GREASE',20,0,1,0),(217,'982','1','982','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',55,'LUBEX SYN 2(46), 17KG','','GREASE',20,0,1,0),(218,'3800','1','3800','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',36,'HYDRAULIC 32 (M) 205L','','GREASE',20,0,1,0),(219,'405','1','405','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',37,'HYDRAULIC 46 (18.9L)','','HYDRAULIC OIL',20,0,1,0),(220,'3950','1','3950','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',38,'HYDRAULIC 46 (205L)','','HYDRAULIC OIL',20,0,1,0),(221,'420','1','420','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',39,'HYDRAULIC 68 (18.9L)','','HYDRAULIC OIL',20,0,1,0),(222,'4070','1','4070','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',40,'HYDRAULIC 68 (205L)','','HYDRAULIC OIL',20,0,1,0),(223,'485','1','485','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',41,'TRACTOR HYDRAULIC 3 SEASON (18.9L)','','HYDRAULIC OIL',20,0,1,0),(224,'4796','1','4796','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',42,'TRACTOR HYDRAULIC 3 SEASON (205L)','','HYDRAULIC OIL',20,0,1,0),(225,'6715','1','6715','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',44,'TRACTOR HYD PREMIUM 4 SEASON (205L)','','HYDRAULIC OIL',20,0,1,0),(226,'665','1','665','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',43,'TRACTOR HYD PREMIUM 4 SEASON (18.9L)','','HYDRAULIC OIL',20,0,1,0),(227,'4700','1','4700','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',13,'IDO PREMIUM + 15W40 CI-4 (205L)','','HYDRAULIC OIL',20,0,1,0),(228,'133','1','133','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',15,'IDO PREMIUM + 15W40 CK-4 (5L)','','LUBRICANTS (DIESEL)',20,0,1,0),(229,'5400','1','5400','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',16,'IDO PREMIUM + 15W40 CK-4 (205L)','','LUBRICANTS (DIESEL)',20,0,1,0),(230,'140','1','140','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',17,'IDO UNIVERSAL SYN 5W40 (5L)','','LUBRICANTS (DIESEL)',20,0,1,0),(231,'190','1','190','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',2,'MAX 1 ADV SYN DEXOS 0W20 (5L) ','','LUBRICANTS (DIESEL)',20,0,1,0),(232,'185','1','185','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',4,'MAX 1 ADVANCED SYN 5W20 (5L)','','LUBRICANTS (PETROL)',20,0,1,0),(233,'180','1','180','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',6,'MAX 1 ADV SYN DEXOS 5W30 (5L)','','LUBRICANTS (PETROL)',20,0,1,0),(234,'30','1','30','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',7,'MAX 1 SYN BLEND 10W40 (0.95L)','','LUBRICANTS (PETROL)',20,0,1,0),(235,'115','1','115','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',8,'MAX 1 SYN BLEND 10W40 (3.79L)','','LUBRICANTS (PETROL)',20,0,1,0),(236,'115','1','115','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',10,'MAX 1-20W50 (SN) 5L','','LUBRICANTS (PETROL)',20,0,1,0),(237,'178.50','1','178.50','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',12,'ADVANT 5W40 (5L)','','LUBRICANTS (PETROL)',20,0,1,0),(238,'92','1','92','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',56,'UNIVERSAL ANTIFREEZE (US ONLY) 3.8L','','LUBRICANTS (PETROL)',20,0,1,0),(239,'80.50','1','80.50','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',57,'US IDC PREMIX H/D EXT/LIFE ANTIFREEZE (3.79L)','','RADIATOR COOLANT',20,0,1,0),(240,'390','1','390','90311.5','0.00','0','90311.50','0.00','proforma','2021-10-16 17:24:26','PRO-000192','Proforma','','','','0.00','0.00','','0000-00-00',35,'HYDRAULIC 32 (18.9L)','','RADIATOR COOLANT',20,0,1,0),(241,'4900','1','4900','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',25,'HDH 80W90 (205L)','','',22,0,1,0),(242,'5400','1','5400','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',16,'IDO PREMIUM + 15W40 CK-4 (205L)','','GEAR OILS',22,0,1,0),(243,'4700','1','4700','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',13,'IDO PREMIUM + 15W40 CI-4 (205L)','','LUBRICANTS (DIESEL)',22,0,1,0),(244,'2400','1','2400','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',48,'LUBEX-EP 2 SPECIAL (RED), 55KG','','LUBRICANTS (DIESEL)',22,0,1,0),(245,'702','1','702','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',50,'LUBEX-EP 2, (17KG)','','GREASE',22,0,1,0),(246,'2250','1','2250','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',52,'LUBEX-EP 2, 55KG','','GREASE',22,0,1,0),(247,'6663','1','6663','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',51,'LUBEX-EP 2, 180KG','','GREASE',22,0,1,0),(248,'982','1','982','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',55,'LUBEX SYN 2(46), 17KG','','GREASE',22,0,1,0),(249,'2062','1','2062','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',54,'LUBEX MP #2, 55KG','','GREASE',22,0,1,0),(250,'29','1','29','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',20,'TRANSFLO DEXIII/MERC (0.95L)','','GREASE',22,0,1,0),(251,'108','1','108','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',21,'TRANSFLO DEXIII (3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',22,0,1,0),(252,'5400','1','5400','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',22,'TRANSFLO DEXIII (205L)','','AUTOMATIC TRANSMISSION OIL (ATF)',22,0,1,0),(253,'43','1','43','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',23,'TRANSFLO DEXRON VI (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',22,0,1,0),(254,'43','1','43','35682','0.00','0','35682.00','0.00','proforma','2021-10-18 15:45:24','PRO-000241','Proforma Invoice','','','','0.00','0.00','','0000-00-00',24,'TRANSFLO MV - MERCON V (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',22,0,1,0),(255,'29','24','696.00','696','0.00','1','696.00','0.00','invoice','2021-10-22 12:46:34','INV-000187','DEXIII - 24X1L','','','','0.00','0.00','','2022-02-17',20,'TRANSFLO DEXIII/MERC (0.95L)','','',5,0,1,0),(256,'29','1','29','20304','0.00','NaN','20304.00','0.00','proforma','2021-10-28 16:37:00','PRO-000255','Proforma Invoice (Irving Oil / Novandi)','','','','0.00','0.00','','0000-00-00',20,'TRANSFLO DEXIII/MERC (0.95L)','','',23,0,1,0),(257,'108','1','108','20304','0.00','NaN','20304.00','0.00','proforma','2021-10-28 16:37:00','PRO-000255','Proforma Invoice (Irving Oil / Novandi)','','','','0.00','0.00','','0000-00-00',21,'TRANSFLO DEXIII (3.79L)','','DIESEL EXHAUST FLUID',23,0,1,0),(258,'5400','1','5400','20304','0.00','NaN','20304.00','0.00','proforma','2021-10-28 16:37:00','PRO-000255','Proforma Invoice (Irving Oil / Novandi)','','','','0.00','0.00','','0000-00-00',22,'TRANSFLO DEXIII (205L)','','DIESEL EXHAUST FLUID',23,0,1,0),(259,'420','1','420','20304','0.00','NaN','20304.00','0.00','proforma','2021-10-28 16:37:00','PRO-000255','Proforma Invoice (Irving Oil / Novandi)','','','','0.00','0.00','','0000-00-00',39,'HYDRAULIC 68 (18.9L)','','',23,0,1,0),(260,'4070','1','4070','20304','0.00','NaN','20304.00','0.00','proforma','2021-10-28 16:37:00','PRO-000255','Proforma Invoice (Irving Oil / Novandi)','','','','0.00','0.00','','0000-00-00',40,'HYDRAULIC 68 (205L)','','',23,0,1,0),(261,'4700','1','4700','20304','0.00','NaN','20304.00','0.00','proforma','2021-10-28 16:37:00','PRO-000255','Proforma Invoice (Irving Oil / Novandi)','','','','0.00','0.00','','0000-00-00',13,'IDO PREMIUM + 15W40 CI-4 (205L)','','',23,0,1,0),(262,'5400','1','5400','20304','0.00','NaN','20304.00','0.00','proforma','2021-10-28 16:37:00','PRO-000255','Proforma Invoice (Irving Oil / Novandi)','','','','0.00','0.00','','0000-00-00',16,'IDO PREMIUM + 15W40 CK-4 (205L)','','',23,0,1,0),(263,'56','1','56','20304','0.00','NaN','20304.00','0.00','proforma','2021-10-28 16:37:00','PRO-000255','Proforma Invoice (Irving Oil / Novandi)','','','','0.00','0.00','','0000-00-00',18,'BLU2 DEF, 1 X 2.5GAL (1 X 3.79L)','','',23,0,1,0),(264,'121','1','121','20304','0.00','NaN','20304.00','0.00','proforma','2021-10-28 16:37:00','PRO-000255','Proforma Invoice (Irving Oil / Novandi)','','','','0.00','0.00','','0000-00-00',19,'BLU2 DEF, 1 X 2.5GAL (1 X 9.46L)','','',23,0,1,0),(272,'29','1','29','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',20,'TRANSFLO DEXIII/MERC (0.95L)','','',24,0,1,0),(273,'108','1','108','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',21,'TRANSFLO DEXIII (3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',24,0,1,0),(274,'5400','1','5400','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',22,'TRANSFLO DEXIII (205L)','','AUTOMATIC TRANSMISSION OIL (ATF)',24,0,1,0),(275,'43','1','43','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',23,'TRANSFLO DEXRON VI (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',24,0,1,0),(276,'43','1','43','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',24,'TRANSFLO MV - MERCON V (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',24,0,1,0),(277,'56','1','56','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',18,'BLU2 DEF, 1 X 2.5GAL (1 X 3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',24,0,1,0),(278,'121','1','121','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',19,'BLU2 DEF, 1 X 2.5GAL (1 X 9.46L)','','DIESEL EXHAUST FLUID',24,0,1,0),(279,'4900','1','4900','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',25,'HDH 80W90 (205L)','','DIESEL EXHAUST FLUID',24,0,1,0),(280,'435','1','435','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',28,'GEAR OIL 150 (18.9L)','','GEAR OILS',24,0,1,0),(281,'1950','1','1950','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',26,'HDH 85W140 (60L)','','GEAR OILS',24,0,1,0),(282,'459.50','1','459.50','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',30,'GEAR OIL 220 (18.9L)','','GEAR OILS',24,0,1,0),(283,'480','1','480','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',32,'GEAR OIL 320 18.9L','','GEAR OILS',24,0,1,0),(284,'702','1','702','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',50,'LUBEX-EP 2, (17KG)','','GEAR OILS',24,0,1,0),(285,'982','1','982','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',55,'LUBEX SYN 2(46), 17KG','','GREASE',24,0,1,0),(286,'2062','1','2062','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',54,'LUBEX MP #2, 55KG','','GREASE',24,0,1,0),(287,'2400','1','2400','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',48,'LUBEX-EP 2 SPECIAL (RED), 55KG','','GREASE',24,0,1,0),(288,'420','1','420','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',39,'HYDRAULIC 68 (18.9L)','','GREASE',24,0,1,0),(289,'4070','1','4070','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',40,'HYDRAULIC 68 (205L)','','HYDRAULIC OIL',24,0,1,0),(290,'3950','1','3950','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',38,'HYDRAULIC 46 (205L)','','HYDRAULIC OIL',24,0,1,0),(291,'405','1','405','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',37,'HYDRAULIC 46 (18.9L)','','HYDRAULIC OIL',24,0,1,0),(292,'3800','1','3800','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',36,'HYDRAULIC 32 (M) 205L','','HYDRAULIC OIL',24,0,1,0),(293,'390','1','390','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',35,'HYDRAULIC 32 (18.9L)','','HYDRAULIC OIL',24,0,1,0),(294,'485','1','485','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',41,'TRACTOR HYDRAULIC 3 SEASON (18.9L)','','HYDRAULIC OIL',24,0,1,0),(295,'665','1','665','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',43,'TRACTOR HYD PREMIUM 4 SEASON (18.9L)','','HYDRAULIC OIL',24,0,1,0),(296,'4796','1','4796','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',42,'TRACTOR HYDRAULIC 3 SEASON (205L)','','HYDRAULIC OIL',24,0,1,0),(297,'6715','1','6715','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',44,'TRACTOR HYD PREMIUM 4 SEASON (205L)','','HYDRAULIC OIL',24,0,1,0),(298,'4700','1','4700','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',13,'IDO PREMIUM + 15W40 CI-4 (205L)','','HYDRAULIC OIL',24,0,1,0),(299,'5400','1','5400','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',16,'IDO PREMIUM + 15W40 CK-4 (205L)','','LUBRICANTS (DIESEL)',24,0,1,0),(300,'133','1','133','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',15,'IDO PREMIUM + 15W40 CK-4 (5L)','','LUBRICANTS (DIESEL)',24,0,1,0),(301,'140','1','140','56239.5','0.00','0','56239.50','0.00','proforma','2021-11-03 16:35:16','PRO-000265','Proforma Invoice','','','','0.00','0.00','','0000-00-00',17,'IDO UNIVERSAL SYN 5W40 (5L)','','LUBRICANTS (DIESEL)',24,0,1,0),(302,'4700','5','23500.00','91200','0.00','0','91200.00','0.00','proforma','2021-11-10 07:53:34','PRO-000302','Cost Proposal (Proforma) - 11 Nov 2021','','','','0.00','0.00','','0000-00-00',13,'IDO PREMIUM + 15W40 CI-4 (205L)','','',13,0,1,0),(303,'5400','5','27000.00','91200','0.00','0','91200.00','0.00','proforma','2021-11-10 07:53:34','PRO-000302','Cost Proposal (Proforma) - 11 Nov 2021','','','','0.00','0.00','','0000-00-00',16,'IDO PREMIUM + 15W40 CK-4 (205L)','','LUBRICANTS (DIESEL)',13,0,1,0),(304,'4070','10','40700.00','91200','0.00','0','91200.00','0.00','proforma','2021-11-10 07:53:34','PRO-000302','Cost Proposal (Proforma) - 11 Nov 2021','','','','0.00','0.00','','0000-00-00',40,'HYDRAULIC 68 (205L)','','LUBRICANTS (DIESEL)',13,0,1,0),(305,'43','1','43','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',23,'TRANSFLO DEXRON VI (0.95L)','','',26,0,1,0),(306,'29','1','29','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',20,'TRANSFLO DEXIII/MERC (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',26,0,1,0),(307,'108','1','108','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',21,'TRANSFLO DEXIII (3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',26,0,1,0),(308,'5400','1','5400','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',22,'TRANSFLO DEXIII (205L)','','AUTOMATIC TRANSMISSION OIL (ATF)',26,0,1,0),(309,'56','1','56','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',18,'BLU2 DEF, 1 X 2.5GAL (1 X 3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',26,0,1,0),(310,'121','1','121','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',19,'BLU2 DEF, 1 X 2.5GAL (1 X 9.46L)','','DIESEL EXHAUST FLUID',26,0,1,0),(311,'4900','1','4900','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',25,'HDH 80W90 (205L)','','DIESEL EXHAUST FLUID',26,0,1,0),(312,'435','1','435','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',28,'GEAR OIL 150 (18.9L)','','GEAR OILS',26,0,1,0),(313,'4350','1','4350','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',29,'GEAR OIL 150 (205L)','','GEAR OILS',26,0,1,0),(314,'459.50','1','459.50','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',30,'GEAR OIL 220 (18.9L)','','GEAR OILS',26,0,1,0),(315,'4500','1','4500','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',31,'GEAR OIL 220 205L','','GEAR OILS',26,0,1,0),(316,'480','1','480','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',32,'GEAR OIL 320 18.9L','','GEAR OILS',26,0,1,0),(317,'4750','1','4750','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',33,'GEAR OIL 320 (205L)','','GEAR OILS',26,0,1,0),(318,'4890','1','4890','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',34,'GEAR OIL 460 (205L)','','GEAR OILS',26,0,1,0),(319,'420','1','420','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',39,'HYDRAULIC 68 (18.9L)','','GEAR OILS',26,0,1,0),(320,'4070','1','4070','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',40,'HYDRAULIC 68 (205L)','','HYDRAULIC OIL',26,0,1,0),(321,'405','1','405','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',37,'HYDRAULIC 46 (18.9L)','','HYDRAULIC OIL',26,0,1,0),(322,'3950','1','3950','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',38,'HYDRAULIC 46 (205L)','','HYDRAULIC OIL',26,0,1,0),(323,'390','1','390','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',35,'HYDRAULIC 32 (18.9L)','','HYDRAULIC OIL',26,0,1,0),(324,'3800','1','3800','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',36,'HYDRAULIC 32 (M) 205L','','HYDRAULIC OIL',26,0,1,0),(325,'133','1','133','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',15,'IDO PREMIUM + 15W40 CK-4 (5L)','','HYDRAULIC OIL',26,0,1,0),(326,'5400','1','5400','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',16,'IDO PREMIUM + 15W40 CK-4 (205L)','','LUBRICANTS (DIESEL)',26,0,1,0),(327,'4700','1','4700','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',13,'IDO PREMIUM + 15W40 CI-4 (205L)','','LUBRICANTS (DIESEL)',26,0,1,0),(328,'982','1','982','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',55,'LUBEX SYN 2(46), 17KG','','LUBRICANTS (DIESEL)',26,0,1,0),(329,'2062','1','2062','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',54,'LUBEX MP #2, 55KG','','GREASE',26,0,1,0),(330,'6663','1','6663','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',51,'LUBEX-EP 2, 180KG','','GREASE',26,0,1,0),(331,'2250','1','2250','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',52,'LUBEX-EP 2, 55KG','','GREASE',26,0,1,0),(332,'702','1','702','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',50,'LUBEX-EP 2, (17KG)','','GREASE',26,0,1,0),(333,'2400','1','2400','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',48,'LUBEX-EP 2 SPECIAL (RED), 55KG','','GREASE',26,0,1,0),(334,'140','1','140','68988.5','0.00','0','68988.50','0.00','proforma','2021-12-08 12:37:32','PRO-000305','Product list and prices','','','','0.00','0.00','','0000-00-00',17,'IDO UNIVERSAL SYN 5W40 (5L)','','GREASE',26,0,1,0),(335,'5400','1','5400','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',22,'TRANSFLO DEXIII (205L)','','',27,0,1,0),(336,'43','1','43','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',23,'TRANSFLO DEXRON VI (0.95L)','','DIESEL EXHAUST FLUID',27,0,1,0),(337,'5400','1','5400','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',16,'IDO PREMIUM + 15W40 CK-4 (205L)','','DIESEL EXHAUST FLUID',27,0,1,0),(338,'4700','1','4700','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',13,'IDO PREMIUM + 15W40 CI-4 (205L)','','',27,0,1,0),(339,'4890','1','4890','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',34,'GEAR OIL 460 (205L)','','',27,0,1,0),(340,'4750','1','4750','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',33,'GEAR OIL 320 (205L)','','',27,0,1,0),(341,'4500','1','4500','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',31,'GEAR OIL 220 205L','','',27,0,1,0),(342,'4350','1','4350','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',29,'GEAR OIL 150 (205L)','','',27,0,1,0),(343,'5438','1','5438','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',27,'HDH 85W140 (205L)','','',27,0,1,0),(344,'4900','1','4900','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',25,'HDH 80W90 (205L)','','',27,0,1,0),(345,'4070','1','4070','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',40,'HYDRAULIC 68 (205L)','','',27,0,1,0),(346,'2062','1','2062','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',54,'LUBEX MP #2, 55KG','','',27,0,1,0),(347,'2250','1','2250','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',52,'LUBEX-EP 2, 55KG','','',27,0,1,0),(348,'6663','1','6663','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',51,'LUBEX-EP 2, 180KG','','',27,0,1,0),(349,'2400','1','2400','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',48,'LUBEX-EP 2 SPECIAL (RED), 55KG','','',27,0,1,0),(350,'121','1','121','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',19,'BLU2 DEF, 1 X 2.5GAL (1 X 9.46L)','','',27,0,1,0),(351,'56','1','56','61993','0.00','NaN','61993.00','0.00','proforma','2021-12-15 11:17:14','PRO-000335','Price List','','','','0.00','0.00','','0000-00-00',18,'BLU2 DEF, 1 X 2.5GAL (1 X 3.79L)','','',27,0,1,0),(352,'29','1','29','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',20,'ATF - IRVING TRANSFLO DEXIII/MERC (0.95L)','','',29,0,1,0),(353,'108','1','108','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',21,'ATF - IRVING TRANSFLO DEXIII (3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',29,0,1,0),(354,'43','1','43','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',23,'ATF - IRVING TRANSFLO DEXRON VI (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',29,0,1,0),(355,'43','1','43','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',24,'ATF - IRVING TRANSFLO MV - MERCON V (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',29,0,1,0),(356,'133','1','133','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',15,'IRVING DIESEL OIL PREMIUM PLUS+HEAVY DUTY 15W-40 CK-4 (5L)','','AUTOMATIC TRANSMISSION OIL (ATF)',29,0,1,0),(357,'190','1','190','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',2,'IRVING MAX 1 ADVANCE SYNTHETIC DEXOS 0W-20 (5L) ','','LUBRICANTS (DIESEL)',29,0,1,0),(358,'185','1','185','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',4,'IRVING MAX 1 ADVANCED SYNTHETIC 5W-20 (5L)','','LUBRICANTS (PETROL)',29,0,1,0),(359,'180','1','180','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',6,'IRVING MAX 1 ADVANCE SYNTHETIC DEXOS 5W-30 (5L)','','LUBRICANTS (PETROL)',29,0,1,0),(360,'115','1','115','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',8,'IRVING MAX 1 SYNTHETIC BLEND 10W-40 (3.79L)','','LUBRICANTS (PETROL)',29,0,1,0),(361,'115','1','115','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',10,'IRVING MAX 1 20W-50 SN (5L)','','LUBRICANTS (PETROL)',29,0,1,0),(362,'178.50','1','178.50','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',12,'IRVING ADVANT 5W-40 (5L)','','LUBRICANTS (PETROL)',29,0,1,0),(363,'136','1','136','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',17,'IRVING DIESEL OIL UNIVERSAL SYNTHETIC 5W-40 (5L)','','LUBRICANTS (PETROL)',29,0,1,0),(364,'56','1','56','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',18,'IRVING BLU2 DIESEL EXHAUST FLUID (1 X 3.79L)','','LUBRICANTS (DIESEL)',29,0,1,0),(365,'121','1','121','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',19,'IRVING BLU2 DIESEL EXHAUST FLUID (1 X 9.46L)','','DIESEL EXHAUST FLUID',29,0,1,0),(366,'4900','1','4900','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',25,'IRVING HDH 80W90 (205L)','','DIESEL EXHAUST FLUID',29,0,1,0),(367,'5438','1','5438','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',27,'IRVING HDH 85W140 (205L)','','GEAR OILS',29,0,1,0),(368,'1950','1','1950','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',26,'IRVING HDH 85W140 (60L)','','GEAR OILS',29,0,1,0),(369,'435','1','435','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',28,'IRVING GEAR OIL 150 (18.9L)','','GEAR OILS',29,0,1,0),(370,'459.50','1','459.50','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',30,'IRVING GEAR OIL 220 (18.9L)','','GEAR OILS',29,0,1,0),(371,'480','1','480','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',32,'IRVING GEAR OIL 320 18.9L','','GEAR OILS',29,0,1,0),(372,'4890','1','4890','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',34,'IRVING GEAR OIL 460 (205L)','','GEAR OILS',29,0,1,0),(373,'390','1','390','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',35,'IRVING HYDRAULIC 32 (18.9L)','','GEAR OILS',29,0,1,0),(374,'405','1','405','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',37,'IRVING HYDRAULIC 46 (18.9L)','','HYDRAULIC OIL',29,0,1,0),(375,'420','1','420','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',39,'IRVING HYDRAULIC 68 (18.9L)','','HYDRAULIC OIL',29,0,1,0),(376,'485','1','485','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',41,'IRVING TRACTOR HYDRAULIC 3 SEASON (18.9L)','','HYDRAULIC OIL',29,0,1,0),(377,'665','1','665','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',43,'IRVING TRACTOR HYD PREMIUM 4 SEASON (18.9L)','','HYDRAULIC OIL',29,0,1,0),(378,'92','1','92','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',56,'IRVING UNIVERSAL ANTIFREEZE (US ONLY) RADIATOR COOLANT (3.8L)','','HYDRAULIC OIL',29,0,1,0),(379,'80.50','1','80.50','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',57,'US IRVING DIESEL COOLANT - PREMIX H/D EXTENDED LIFE - ANTIFREEZE (3.79L)','','RADIATOR COOLANT',29,0,1,0),(380,'4700','1','4700','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',13,'IRVING DIESEL OIL PREMIUM+ PLUS 15W-40 CI-4 (205L)','','RADIATOR COOLANT',29,0,1,0),(381,'5400','1','5400','32822.5','0.00','0','32822.50','0.00','proforma','2022-01-14 17:06:45','PRO-000352','PROFORMA','','','','0.00','0.00','','0000-00-00',16,'IRVING DIESEL OIL PREMIUM PLUS+HEAVY DUTY 15W-40 CK-4 (205L)','','LUBRICANTS (DIESEL)',29,0,1,0),(382,'190','8','1520.00','1520','0.00','0','1520.00','0.00','invoice','2022-01-13 17:14:20','INV-000256','MAX1 0W-20','','','','0.00','0.00','','0000-00-00',2,'IRVING MAX 1 ADVANCE SYNTHETIC DEXOS 0W-20 (5L) ','','',6,0,1,0),(383,'29','12','348.00','348','0.00','0','348.00','0.00','invoice','2022-01-13 17:19:36','INV-000383','DEXRON 3 - 13JAN22','','','','0.00','0.00','','0000-00-00',20,'ATF - IRVING TRANSFLO DEXIII/MERC (0.95L)','','',6,0,1,0),(384,'29','289','8381.00','8381','0.00','0','0.00','8381.00','invoice','2022-01-20 14:04:34','INV-000384','DEX III (RETURNS)','','','','0.00','0.00','100','0000-00-00',20,'ATF - IRVING TRANSFLO DEXIII/MERC (0.95L)','','',12,0,1,0),(385,'29','10','290.00','290','0.00','0','0.00','290.00','invoice','2022-01-20 14:11:40','INV-000385','DEXIII reconciliation','','','','0.00','0.00','100','0000-00-00',20,'ATF - IRVING TRANSFLO DEXIII/MERC (0.95L)','','',12,0,1,0),(386,'133','28','3724.00','5104','0.00','0','0.00','5104.00','invoice','2022-01-20 14:17:16','INV-000386','15W-40 & 10W-40 (RETURNS)','','','','0.00','0.00','100','0000-00-00',15,'IRVING DIESEL OIL PREMIUM PLUS+HEAVY DUTY 15W-40 CK-4 (5L)','','',12,0,1,0),(387,'115','12','1380.00','5104','0.00','0','0.00','5104.00','invoice','2022-01-20 14:17:16','INV-000386','15W-40 & 10W-40 (RETURNS)','','','','0.00','0.00','100','2022-02-18',8,'IRVING MAX 1 SYNTHETIC BLEND 10W-40 (3.79L)','','LUBRICANTS (DIESEL)',12,0,1,0),(388,'43','12','516.00','516','0.00','0','516.00','0.00','invoice','2022-01-26 10:02:27','INV-000388','Dexron VI','','','','0.00','0.00','','0000-00-00',23,'ATF - IRVING TRANSFLO DEXRON VI (0.95L)','','',6,0,1,0),(389,'29','1','29','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',20,'ATF - IRVING TRANSFLO DEXIII/MERC (0.95L)','','',30,0,1,0),(390,'108','1','108','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',21,'ATF - IRVING TRANSFLO DEXIII (3.79L)','','AUTOMATIC TRANSMISSION OIL (ATF)',30,0,1,0),(391,'43','1','43','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',23,'ATF - IRVING TRANSFLO DEXRON VI (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',30,0,1,0),(392,'43','1','43','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',24,'ATF - IRVING TRANSFLO MV - MERCON V (0.95L)','','AUTOMATIC TRANSMISSION OIL (ATF)',30,0,1,0),(393,'190','1','190','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',2,'IRVING MAX 1 ADVANCE SYNTHETIC DEXOS 0W-20 (5L) ','','AUTOMATIC TRANSMISSION OIL (ATF)',30,0,1,0),(394,'185','1','185','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',4,'IRVING MAX 1 ADVANCED SYNTHETIC 5W-20 (5L)','','LUBRICANTS (PETROL)',30,0,1,0),(395,'180','1','180','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',6,'IRVING MAX 1 ADVANCE SYNTHETIC DEXOS 5W-30 (5L)','','LUBRICANTS (PETROL)',30,0,1,0),(396,'115','1','115','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',8,'IRVING MAX 1 SYNTHETIC BLEND 10W-40 (3.79L)','','LUBRICANTS (PETROL)',30,0,1,0),(397,'115','1','115','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','2022-02-15',10,'IRVING MAX 1 20W-50 SN (5L)','','LUBRICANTS (PETROL)',30,0,1,0),(398,'178.50','1','178.50','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',12,'IRVING ADVANT 5W-40 (5L)','','LUBRICANTS (PETROL)',30,0,1,0),(399,'133','1','133','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',15,'IRVING DIESEL OIL PREMIUM PLUS+HEAVY DUTY 15W-40 CK-4 (5L)','','LUBRICANTS (PETROL)',30,0,1,0),(400,'136','1','136','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',17,'IRVING DIESEL OIL UNIVERSAL SYNTHETIC 5W-40 (5L)','','LUBRICANTS (DIESEL)',30,0,1,0),(401,'420','1','420','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',39,'IRVING HYDRAULIC 68 (18.9L)','','LUBRICANTS (DIESEL)',30,0,1,0),(402,'405','1','405','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',37,'IRVING HYDRAULIC 46 (18.9L)','','HYDRAULIC OIL',30,0,1,0),(403,'390','1','390','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',35,'IRVING HYDRAULIC 32 (18.9L)','','HYDRAULIC OIL',30,0,1,0),(404,'18','1','18','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',46,'IRVING LUBEX MP #2 GREASE (400GR TUBE) - MULTI PURPOSE','','HYDRAULIC OIL',30,0,1,0),(405,'25','1','25','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',47,'IRVING LUBEX-EP 2 SPECIAL (RED) GREASE (400GR TUBE)','','GREASE',30,0,1,0),(406,'2062','1','2062','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',54,'IRVING LUBEX MP#2 GREASE (55KG)','','GREASE',30,0,1,0),(407,'2400','1','2400','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',48,'IRVING LUBEX-EP 2 SPECIAL (RED) GREASE (55KG)','','GREASE',30,0,1,0),(408,'22','1','22','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',49,'IRVING LUBEX-EP2 GREASE (400GR TUBE)','','GREASE',30,0,1,0),(409,'702','1','702','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',50,'IRVING LUBEX-EP2 GREASE (17KG)','','GREASE',30,0,1,0),(410,'2250','1','2250','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',52,'IRVING LUBEX-EP2 GREASE (55KG)','','GREASE',30,0,1,0),(411,'4900','1','4900','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',25,'IRVING HDH 80W90 (205L)','','GREASE',30,0,1,0),(412,'1950','1','1950','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',26,'IRVING HDH 85W140 (60L)','','GEAR OILS',30,0,1,0),(413,'435','1','435','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',28,'IRVING GEAR OIL 150 (18.9L)','','GEAR OILS',30,0,1,0),(414,'459.50','1','459.50','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',30,'IRVING GEAR OIL 220 (18.9L)','','GEAR OILS',30,0,1,0),(415,'480','1','480','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',32,'IRVING GEAR OIL 320 18.9L','','GEAR OILS',30,0,1,0),(416,'56','1','56','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',18,'IRVING BLU2 DIESEL EXHAUST FLUID (1 X 3.79L)','','GEAR OILS',30,0,1,0),(417,'121','1','121','18551','0.00','0','18551.00','0.00','proforma','2022-01-31 13:09:39','PRO-000382','Price List','','','','0.00','0.00','','0000-00-00',19,'IRVING BLU2 DIESEL EXHAUST FLUID (1 X 9.46L)','','DIESEL EXHAUST FLUID',30,0,1,0),(418,'135','8','1080.00','1290','0.00','0','1290.00','0.00','proforma','2022-02-11 14:57:23','PRO-000418','REVISED PROFORMA','','','','0.00','0.00','','0000-00-00',10,'IRVING MAX 1 20W-50 SN (5L)','','',30,0,1,0),(419,'210','1','210.00','1290','0.00','0','1290.00','0.00','proforma','2022-02-11 14:57:23','PRO-000418','REVISED PROFORMA','','','','0.00','0.00','','0000-00-00',17,'IRVING DIESEL OIL UNIVERSAL SYNTHETIC 5W-40 (5L)','','LUBRICANTS (PETROL)',30,0,1,0),(420,'135','8','1080.00','1920','0.00','0','1920.00','0.00','proforma','2022-02-11 15:04:03','PRO-000420','20W-50 & 5W-40','','','','0.00','0.00','','0000-00-00',10,'IRVING MAX 1 20W-50 SN (5L)','','',30,0,1,0),(421,'210','4','840.00','1920','0.00','0','1920.00','0.00','proforma','2022-02-11 15:04:03','PRO-000420','20W-50 & 5W-40','','','','0.00','0.00','','2022-02-17',17,'IRVING DIESEL OIL UNIVERSAL SYNTHETIC 5W-40 (5L)','','LUBRICANTS (PETROL)',30,0,1,0),(422,'44','1','44','44','0.00','0','44.00','0.00','invoice','2022-02-14 11:52:28','INV-000389','TEST','','','','0.00','0.00','','0000-00-00',79,'AMA YAYRA','','',11,0,1,0);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `comp_id` int(11) NOT NULL AUTO_INCREMENT,
  `comp_name` varchar(100) NOT NULL,
  `comp_addr` varchar(100) NOT NULL,
  `comp_phone` varchar(100) NOT NULL,
  `comp_email` varchar(100) NOT NULL,
  `backup_email` varchar(100) NOT NULL,
  `comp_website` varchar(100) NOT NULL,
  `comp_terms` text NOT NULL,
  `comp_logo` varchar(100) NOT NULL,
  `cover_image` varchar(100) NOT NULL,
  `comp_bank` varchar(100) NOT NULL,
  `bank_acc` varchar(100) NOT NULL,
  `acc_name` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `email_url` varchar(100) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `instagram` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `sms_sender_id` varchar(100) NOT NULL,
  `sms_api_key` varchar(100) NOT NULL,
  `sms_api_url` varchar(100) NOT NULL,
  `sms_cc` varchar(100) NOT NULL,
  `activate_receipt_sms` varchar(100) NOT NULL,
  PRIMARY KEY (`comp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'NOVANDI ENTERPRISE','P. O. Box CU44, Central University, Miotso','+233 (0)244336509','info@novandigh.com','novandient@gmail.com','https://www.novandigh.com','','img800.jpeg','img421.jpeg','GCB BANK','1721180001903','Novandi Enterprise','GHs','Day','','','','','','','','','');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_date` date NOT NULL,
  `user_mang` int(11) NOT NULL,
  `login_date` datetime NOT NULL,
  `login_status` varchar(5) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Unblock',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$n7i8Z8GKMAUNcc1.jPQvC.fBBmCzdGQITfvL.swYvrB2tSYKhyAAC','ceo@novandigh.com','2021-08-31',1,'2022-02-22 14:03:28','Yes','Unblock'),(2,'Linda','$2y$10$KtxLXzNfto3LtINaFO8TuOZIBK1EsLYvFZWUcyCWQN9bK3czE/KvG','info@novandigh.com','2021-09-01',1,'2021-10-11 09:53:24','No','Unblock');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_details`
--

DROP TABLE IF EXISTS `users_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `hire_date` date NOT NULL,
  `department` varchar(100) NOT NULL,
  `signature` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_mang` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `tasks` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk1` (`user_id`),
  KEY `usm` (`user_mang`),
  KEY `rid` (`role_id`),
  CONSTRAINT `fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rid` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usm` FOREIGN KEY (`user_mang`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_details`
--

LOCK TABLES `users_details` WRITE;
/*!40000 ALTER TABLE `users_details` DISABLE KEYS */;
INSERT INTO `users_details` VALUES (1,'Philip','Oppong Boateng',' 233 (0)244336509','Prampram','img388.jpeg','2021-08-31','Management','img242.jpeg',1,1,1,'{\"dbbackup\":\"1\",\"expreminder\":\"1\"}'),(2,'Linda','Boateng',' 233 (0)248227145','Prampram','','2021-09-01','Administration','',2,1,1,'{\"dbbackup\":\"1\",\"expreminder\":\"1\"}');
/*!40000 ALTER TABLE `users_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-23  8:52:56
