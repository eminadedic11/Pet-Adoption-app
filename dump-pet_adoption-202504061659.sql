-- MySQL dump 10.13  Distrib 9.2.0, for macos14.7 (x86_64)
--
-- Host: localhost    Database: pet_adoption
-- ------------------------------------------------------
-- Server version	9.2.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adoptions`
--

DROP TABLE IF EXISTS `adoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adoptions` (
  `adoption_id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(100) DEFAULT NULL,
  `request_date` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `pet_id` int DEFAULT NULL,
  PRIMARY KEY (`adoption_id`),
  KEY `adoptions_users_FK` (`user_id`),
  KEY `adoptions_pets_FK` (`pet_id`),
  CONSTRAINT `adoptions_pets_FK` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`),
  CONSTRAINT `adoptions_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adoptions`
--

LOCK TABLES `adoptions` WRITE;
/*!40000 ALTER TABLE `adoptions` DISABLE KEYS */;
INSERT INTO `adoptions` VALUES (1,'pending','2025-04-05 22:32:03',1,2),(2,'approved','2025-04-05 22:32:03',2,5),(3,'rejected','2025-04-05 22:32:03',3,1),(4,'pending','2025-04-05 22:32:03',4,4),(5,'approved','2025-04-05 22:32:03',5,9),(6,'pending','2025-04-05 22:32:03',6,6),(7,'rejected','2025-04-05 22:32:03',7,3),(8,'pending','2025-04-05 22:32:03',8,8),(9,'pending','2025-04-05 22:00:00',1,1),(10,'pending','2025-04-05 22:32:03',10,10),(11,'pending','2025-04-05 22:00:00',1,1),(12,'pending','2025-04-05 22:00:00',1,1),(13,'pending','2025-04-05 22:00:00',1,1);
/*!40000 ALTER TABLE `adoptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical_records`
--

DROP TABLE IF EXISTS `medical_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medical_records` (
  `medical_record_id` int NOT NULL AUTO_INCREMENT,
  `vaccinations` varchar(100) DEFAULT NULL,
  `medical_conditions` varchar(100) DEFAULT NULL,
  `last_checkup_date` date DEFAULT NULL,
  `pet_id` int DEFAULT NULL,
  PRIMARY KEY (`medical_record_id`),
  KEY `medical_records_pets_FK` (`pet_id`),
  CONSTRAINT `medical_records_pets_FK` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_records`
--

LOCK TABLES `medical_records` WRITE;
/*!40000 ALTER TABLE `medical_records` DISABLE KEYS */;
INSERT INTO `medical_records` VALUES (1,'Rabies, Parvo','None','2024-12-01',1),(2,'Rabies','Mild allergy','2024-11-15',2),(3,'Parvo, Distemper','Skin rash','2024-10-20',3),(4,'Rabies, Flu','None','2024-12-05',4),(5,'Distemper','Dental issues','2024-11-22',5),(6,'Rabies, Parvo','Heart murmur','2024-09-30',6),(7,'Flu','None','2024-10-10',7),(8,'Parvo','Leg injury','2024-12-10',8),(9,'Rabies','Eye infection','2024-11-01',9),(10,'Flu, Distemper','None','2024-11-18',10);
/*!40000 ALTER TABLE `medical_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pets`
--

DROP TABLE IF EXISTS `pets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pets` (
  `pet_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `species` varchar(100) DEFAULT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pets`
--

LOCK TABLES `pets` WRITE;
/*!40000 ALTER TABLE `pets` DISABLE KEYS */;
INSERT INTO `pets` VALUES (1,'Max','Dog','Labrador',3,'Friendly and playful.','available','dog1.jpg','2025-04-05 22:31:33'),(2,'Bella','Cat','Siamese',2,'Quiet and loves attention.','adopted','cat1.jpg','2025-04-05 22:31:33'),(3,'Rocky','Dog','Bulldog',4,'Strong and calm.','available','dog2.jpg','2025-04-05 22:31:33'),(4,'Luna','Cat','Persian',1,'Soft and cuddly.','available','cat2.jpg','2025-04-05 22:31:33'),(5,'Leo','Dog','Beagle',2,'Energetic and alert.','adopted','dog3.jpg','2025-04-05 22:31:33'),(6,'Amina','Cat','Golden Retriever',4,'Still friendly, but older.','adopted','buddy_updated.jpg','2025-04-05 22:31:33'),(7,'Buddy','Dog','Golden Retriever',3,'Loyal and friendly.','available','dog4.jpg','2025-04-05 22:31:33'),(8,'Milo','Cat','Bengal',2,'Curious and playful.','available','cat4.jpg','2025-04-05 22:31:33'),(9,'Zoe','Dog','Poodle',6,'Smart and quiet.','adopted','dog5.jpg','2025-04-05 22:31:33'),(10,'Nala','Cat','Ragdoll',4,'Fluffy and affectionate.','available','cat5.jpg','2025-04-05 22:31:33'),(12,'Emina','Dog','Golden Retriever',3,'Friendly and energetic.','available','buddy.jpg','2025-04-05 22:48:12');
/*!40000 ALTER TABLE `pets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `review_id` int NOT NULL AUTO_INCREMENT,
  `rating` int DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`review_id`),
  KEY `reviews_users_FK` (`user_id`),
  CONSTRAINT `reviews_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (11,5,'Amazing experience!','2025-04-05 22:32:34',1),(12,4,'Great service.','2025-04-05 22:32:34',2),(13,3,'It was okay.','2025-04-05 22:32:34',3),(14,5,'Loved it!','2025-04-05 22:32:34',4),(15,4,'Staff was helpful.','2025-04-05 22:32:34',5),(16,5,'Would recommend!','2025-04-05 22:32:34',6),(17,2,'Not the best.','2025-04-05 22:32:34',7),(18,5,'Fantastic!','2025-04-05 22:32:34',8),(19,3,'Average process.','2025-04-05 22:32:34',9),(20,4,'Pretty good.','2025-04-05 22:32:34',10);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `created_at` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Alice Johnson','alice1@example.com','pass123','111-111-1111','user','2025-04-06 00:30:48'),(2,'Bob Smith','bob@example.com','pass123','222-222-2222','admin','2025-04-06 00:30:48'),(3,'Charlie Brown','charlie@example.com','pass123','333-333-3333','user','2025-04-06 00:30:48'),(4,'Dana White','dana@example.com','pass123','444-444-4444','user','2025-04-06 00:30:48'),(5,'Eve Adams','eve@example.com','pass123','555-555-5555','admin','2025-04-06 00:30:48'),(6,'Frank Hall','frank@example.com','pass123','666-666-6666','user','2025-04-06 00:30:48'),(7,'Grace Lee','grace@example.com','pass123','777-777-7777','user','2025-04-06 00:30:48'),(8,'Henry King','henry@example.com','pass123','888-888-8888','user','2025-04-06 00:30:48'),(9,'Ivy Stone','ivy@example.com','pass123','999-999-9999','user','2025-04-06 00:30:48'),(10,'Jack Wolf','jack@example.com','pass123','000-000-0000','user','2025-04-06 00:30:48'),(11,'John Doe','john@example.com','$2y$12$fXAURBL.KmdldX/h5Z15dO4SZaBPAfDc4RYZ5EG8QGLQjw2V5zyYu','1234567890','user','2025-04-06 00:40:04');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'pet_adoption'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-06 16:59:27
