-- MariaDB dump 10.17  Distrib 10.4.13-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: mdc_senior
-- ------------------------------------------------------
-- Server version	10.4.13-MariaDB

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
-- Table structure for table `mst_productdb`
--

DROP TABLE IF EXISTS `mst_productdb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_productdb` (
  `prod_id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_code` varchar(20) NOT NULL,
  `prod_name` varchar(50) NOT NULL,
  `prod_price` varchar(50) NOT NULL,
  `prod_packsize` varchar(20) NOT NULL,
  `prod_pertab` varchar(20) NOT NULL,
  `prod_segment` text NOT NULL,
  PRIMARY KEY (`prod_id`),
  KEY `prod_code` (`prod_code`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_productdb`
--

LOCK TABLES `mst_productdb` WRITE;
/*!40000 ALTER TABLE `mst_productdb` DISABLE KEYS */;
INSERT INTO `mst_productdb` VALUES (2,'307414','Cardipres Tab 12.5mg','321.43','30','10.71',''),(3,'307415','Cardipres Tab 25mg','495.54','30','16.52',''),(4,'307416','Cetadol Tab 325mg/37.5mg','2500.00','100','25',''),(5,'307417','Clovix Tab 75mg','862.50','30','28.75',''),(6,'307430','Euglotab Tab 5mg','550.00','100','5.5',''),(7,'307445','Glimesyn Tab 2mg','915.18','100','9.15',''),(8,'307446','Glimesyn Tab 3mg 30s','352.50','30','11.75',''),(9,'307455','Icox Cap 200mg','1250','50','25',''),(10,'307456','Itorvaz Tab 40mg','616.07','30','20.54',''),(11,'307457','Itorvaz Tab 80mg','747.32','30','24.91',''),(12,'307469','Kardia Tab 5mg','1500.00','100','15',''),(13,'307470','Kenzar Tab 50mg','468.75','30','15.63',''),(14,'307471','Kenzar Plus Tab 50/12.5mg','495.54','30','16.5',''),(15,'307472','Normax Tab 500mg','714.29','100','7.14',''),(16,'307473','Kenzar Tab 100mg','502.23','30','16.74',''),(19,'307502','Omnivox Tab 500mg','1240','20','62',''),(20,'307512','Prosec IV Inj Vial 40mg','463.00','1','463',''),(21,'307513','Ppar Tab 30mg','495.54','30','16.52',''),(22,'307514','Prosec Cap 20mg','575.00','20','28.75',''),(23,'307515','Provasc Tab 5mg','388.39','30','12.59',''),(24,'307516','Provasc Tab 10mg','522.32','30','17.41',''),(25,'307551','Tenorvas Tab 50mg','781.25','100','7.81',''),(26,'307552','Tenorvas Tab 100mg','1250.00','100','12.5',''),(27,'307555','TMZ-MR Tab 35mg','540.00','30','18',''),(28,'307559','Ultima Cap','1150.00','100','11.5',''),(29,'307563','Viamox Tab 1g','735.00','12','61.25',''),(30,'307564','Viatrex IM/IV Inj 1g Vial','5000.00','10','500',''),(31,'307565','Virbez Tab 150mg','468.75','30','15.63',''),(32,'307594','Zimcor Tab 40mg','585.00','30','19.5',''),(33,'307595','Zimcor Tab 80mg','1080.00','30','36',''),(34,'307596','Zinof Cap 200mg','459.82','20','22.99',''),(35,'307401','Antaxid Tab 40mg','1036','28','37',''),(36,'307474','Normax Tab 1g','1500','100','15',''),(37,'307475','Nuvert Tab 16mg','2200','100','22',''),(38,'307408','BESPRIN 100MG','350','100','3.50',''),(39,'307429','IgCo 30s','2500','30','83.33',''),(40,'270018','ENPLUS GOLD 400G','788','1','788',''),(41,'270019','ENPLUS GOLD 900G','1650','1','1650',''),(42,'307428','IgCo 10s','832.5','10','83.25',''),(43,'307517','PRONERV','1400','100','14',''),(44,'307562','VEZTENOR','616.07','30','20.54',''),(45,'307500','Omnivox FC Tab 500mg','1860','30','62',''),(46,'307566','Virbez FC Tab 300mg','696.43','30','23.21',''),(47,'310520','Saptaz IM/IV Inj 1g/125mg','1610','1','1610',''),(48,'307484','LUSTATIN 20MG','696.43','30','23.21',''),(49,'307485','LUSTATIN 40MG','1339.29','30','44.64',''),(50,'307540','SPIROFAR 25MG','1600','100','16',''),(51,'307447','Glimesyn Tab 3mg 100s','1049.11','100','10.49',''),(52,'307483','LUSTATIN 10MG','562.5','30','10.75',''),(53,'307535','SOLFI GREEN - STRAWBERRY FLAVOR','1800','30','60',''),(54,'307427','IgCo 1s','83.33','1','83.33',''),(55,'307503','OMEGA GOLD','2800','100','28',''),(56,'307400','AMIVAN 5MG','405','30','13.5',''),(57,'307419','ECOSPRIN PLUS','1050','30','35',''),(58,'307440','i-BREATH PLUS','722','1','722','ORAL'),(59,'307525','REZPIRA','600','1','600','ORAL'),(60,'307542','SUCRANORM 850MG','390','40','9.75','ORAL'),(61,'307454','Icox 200mg 100s','2625','100','26.25',''),(62,'307418','Citifar Tab 500mg','1995','30','66.5',''),(63,'307437','Fixbact Tab 200mg','4500','100','45',''),(64,'307468','Kenzolin Pdr Inj IV 4g/500m','950','1','950','');
/*!40000 ALTER TABLE `mst_productdb` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-05 15:26:53
