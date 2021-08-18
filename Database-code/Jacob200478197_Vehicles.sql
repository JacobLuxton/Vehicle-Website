-- MySQL dump 10.13  Distrib 8.0.25, for Win64 (x86_64)
--
-- Host: 172.31.22.43    Database: Jacob200478197
-- ------------------------------------------------------
-- Server version	8.0.26-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Vehicles`
--

DROP TABLE IF EXISTS `Vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Vehicles` (
  `carNumber` int NOT NULL AUTO_INCREMENT,
  `carMake` char(15) NOT NULL,
  `carModel` char(15) NOT NULL,
  `carYear` int DEFAULT NULL,
  `colour` char(10) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`carNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vehicles`
--

LOCK TABLES `Vehicles` WRITE;
/*!40000 ALTER TABLE `Vehicles` DISABLE KEYS */;
INSERT INTO `Vehicles` VALUES (1,'Ford','Escape',2019,'Blue','t5gn4fsnd22019FOS13000101.jpg'),(2,'Dodge','Ram',2017,'Black','t5gn4fsnd2dodge-ram.jpg'),(3,'Nissan','Maxima',2323,'Red',NULL),(4,'Dodge','Viper',2018,'Green',NULL),(5,'Toyota','Supra',1994,'Orange','t5gn4fsnd2toyota-supra.jpg'),(6,'Nissan','Skyline',1999,'Blue','t5gn4fsnd2skyline.jpg'),(7,'Mazda','Miata',2019,'Red','t5gn4fsnd2miata.png'),(8,'Infiniti','g37',2010,'Silver',NULL),(9,'Volkswagen','Golf',2014,'Black',NULL),(10,'Chevrolet','Camaro',1995,'White',NULL),(11,'Volvo','s60',2002,'Green','4lsaesbcv4volvo.png'),(26,'Volkswagen','Golf',2020,'Black','4lsaesbcv4golf-GTI.jpg'),(34,'Mazda','speed',2020,'Green',NULL);
/*!40000 ALTER TABLE `Vehicles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-08-18 16:17:42
