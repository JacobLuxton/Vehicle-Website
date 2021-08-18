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
-- Table structure for table `web_users`
--

DROP TABLE IF EXISTS `web_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `web_users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `web_users`
--

LOCK TABLES `web_users` WRITE;
/*!40000 ALTER TABLE `web_users` DISABLE KEYS */;
INSERT INTO `web_users` VALUES (1,'abc@abc.com','$2y$10$ugzjqN5TWIH2hxJWaVjsreYhn.J2J3Yu1sM92e9t1K8MP8RBlhct.'),(2,'asd@gmsil.com','$2y$10$bG4hVn4ER2F.jSvTQ7Mrn.ucqI0AUHB5F5VhTFSPFP47stPK/2Hzi'),(3,'ahs@hjs.com','$2y$10$h2XzqU0U.5KRdbpwzLJnJug1pr208WVxV1r7CCCejAUoxYcTyNgo.'),(4,'abc@gmail.com','$2y$10$xqgner/DSe27EgBbjF1LjuirG8T5zpz9MbeH4ycPFiIBWF88paXZi'),(5,'JJ@gmail.com','$2y$10$h082woyuX3pJqRYcT7KxBeOsvHPwmZucJ3qe5Jf4yQvKBMAkI/sOy'),(6,'abb@gmail.com','$2y$10$CvQr0Gg9HiEJjQllLPKYz.v/n8nb0nti0JI5bpiJ9FuzJr4HW.ljG'),(7,'f@f.com','$2y$10$maQ0xN.nl95AKwGnGRt/jOxam1yWXeJZe1KDiCMfISI7XrM3K1RJ.'),(8,'a@a.com','$2y$10$f5BCPD57neWnv8Lfghx9Qe/gVugD4FLAdwzC/GBgvZ5MOHFIc1zhe');
/*!40000 ALTER TABLE `web_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-08-18 16:17:41
