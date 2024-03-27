/*
SQLyog Ultimate v9.62 
MySQL - 5.6.37-log : Database - onlinehotelbooking
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`onlinehotelbooking` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `onlinehotelbooking`;

/*Table structure for table `entrance_and_pool` */

DROP TABLE IF EXISTS `entrance_and_pool`;

CREATE TABLE `entrance_and_pool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `no_of_adults` int(11) DEFAULT NULL,
  `no_of_children` int(11) DEFAULT NULL,
  `type` enum('entrance','pool') DEFAULT NULL,
  `transdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `entrance_and_pool` */

insert  into `entrance_and_pool`(`id`,`name`,`no_of_adults`,`no_of_children`,`type`,`transdate`) values (1,'Test',1,1,'pool','2024-03-16 12:34:40');

/*Table structure for table `event_bookings` */

DROP TABLE IF EXISTS `event_bookings`;

CREATE TABLE `event_bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number_of_tickets` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `payment` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_bookings_user_id_index` (`user_id`),
  KEY `event_bookings_event_id_index` (`event_id`),
  CONSTRAINT `event_bookings_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `event_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `event_bookings` */

insert  into `event_bookings`(`id`,`number_of_tickets`,`total_cost`,`status`,`payment`,`user_id`,`event_id`,`created_at`,`updated_at`) values (1,10,0,1,1,2,3,'2024-02-27 02:15:49',NULL),(2,2,5000,1,0,2,1,'2024-02-27 02:15:49',NULL),(3,4,10000,0,0,3,1,'2024-02-27 02:15:49',NULL);

/*Table structure for table `events` */

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `booker_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `venue` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `events_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `events` */

insert  into `events`(`id`,`booker_name`,`name`,`image`,`date`,`venue`,`price`,`capacity`,`description`,`status`,`created_at`,`updated_at`) values (1,NULL,'Overnight Campfire','1.jpg','2018-05-18','Playground',0,75,'Outing with Friends.',1,'2024-02-27 02:15:49',NULL),(2,NULL,'Horse Back Riding','2.jpg','2018-04-18','Bung-Aw Eco Farm Playground',0,1,'Enjoy riding with elegant horses.',1,'2024-02-27 02:15:49',NULL),(3,NULL,'ATV Rides','3.jpg','2018-04-20','Brg. Bogtongbod, Clarin, Bohol',0,1,'Having Fun and Chill Ride.',1,'2024-02-27 02:15:49',NULL),(4,NULL,'Overnight','4.jpg','2018-04-15','Bung-Aw Eco Farm Playground',300,4,'Enjoying and having fun overnight with friends.',1,'2024-02-27 02:15:49',NULL),(5,NULL,'Overnight Swimming in a Pool','5.jpg','2018-04-10','Pool Area',0,75,'Chilling and night swimming .',1,'2024-02-27 02:15:49',NULL),(7,NULL,'test',NULL,'2024-02-29','test',5999,45,'test',0,NULL,NULL),(10,'TestnAME','evenjt',NULL,'2024-03-11','venue',500,1,'desc',0,NULL,NULL);

/*Table structure for table `facilities` */

DROP TABLE IF EXISTS `facilities`;

CREATE TABLE `facilities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facilities_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `facilities` */

insert  into `facilities`(`id`,`name`,`icon`,`status`,`created_at`,`updated_at`) values (1,'Air Conditioner','air_conditioner.png',1,'2024-02-27 02:15:49',NULL),(2,'Bathtub','bathtub.png',1,'2024-02-27 02:15:49',NULL),(3,'Breakfast','breakfast.png',1,'2024-02-27 02:15:49',NULL),(4,'Computer','computer.png',1,'2024-02-27 02:15:49',NULL),(5,'First Aid Kit','first_aid_kit.png',1,'2024-02-27 02:15:49',NULL),(6,'Hair Dryer','hair_dryer.png',1,'2024-02-27 02:15:49',NULL),(7,'Mini Bar','mini_bar.png',1,'2024-02-27 02:15:49',NULL),(8,'Mini Cooler','mini_cooler.png',1,'2024-02-27 02:15:49',NULL),(9,'Parking','parking.png',1,'2024-02-27 02:15:49',NULL),(10,'Telephone','telephone.png',1,'2024-02-27 02:15:49',NULL),(11,'Television','television.png',1,'2024-02-27 02:15:49',NULL),(12,'Wifi','wifi.png',1,'2024-02-27 02:15:49',NULL);

/*Table structure for table `facility_room_type` */

DROP TABLE IF EXISTS `facility_room_type`;

CREATE TABLE `facility_room_type` (
  `facility_id` int(10) unsigned NOT NULL,
  `room_type_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `facility_room_type_facility_id_index` (`facility_id`),
  KEY `facility_room_type_room_type_id_index` (`room_type_id`),
  CONSTRAINT `facility_room_type_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `facility_room_type_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `facility_room_type` */

insert  into `facility_room_type`(`facility_id`,`room_type_id`,`created_at`,`updated_at`) values (1,1,'2024-02-27 02:15:49',NULL),(2,1,'2024-02-27 02:15:49',NULL),(3,1,'2024-02-27 02:15:49',NULL),(4,1,'2024-02-27 02:15:49',NULL),(5,1,'2024-02-27 02:15:49',NULL),(6,1,'2024-02-27 02:15:49',NULL),(7,1,'2024-02-27 02:15:49',NULL),(8,1,'2024-02-27 02:15:49',NULL),(9,1,'2024-02-27 02:15:49',NULL),(10,1,'2024-02-27 02:15:49',NULL),(11,1,'2024-02-27 02:15:49',NULL),(12,1,'2024-02-27 02:15:49',NULL),(1,2,'2024-02-27 02:15:49',NULL),(2,2,'2024-02-27 02:15:49',NULL),(3,2,'2024-02-27 02:15:49',NULL),(4,2,'2024-02-27 02:15:49',NULL),(5,2,'2024-02-27 02:15:49',NULL),(6,2,'2024-02-27 02:15:49',NULL),(7,2,'2024-02-27 02:15:49',NULL),(8,2,'2024-02-27 02:15:49',NULL),(9,2,'2024-02-27 02:15:49',NULL),(10,2,'2024-02-27 02:15:49',NULL),(1,3,'2024-02-27 02:15:49',NULL),(2,3,'2024-02-27 02:15:49',NULL),(3,3,'2024-02-27 02:15:49',NULL),(4,3,'2024-02-27 02:15:49',NULL),(9,3,'2024-02-27 02:15:49',NULL),(10,3,'2024-02-27 02:15:49',NULL),(12,3,'2024-02-27 02:15:49',NULL),(1,4,'2024-02-27 02:15:49',NULL),(2,4,'2024-02-27 02:15:49',NULL),(3,4,'2024-02-27 02:15:49',NULL),(4,4,'2024-02-27 02:15:49',NULL),(8,4,'2024-02-27 02:15:49',NULL),(10,4,'2024-02-27 02:15:49',NULL);

/*Table structure for table `food_bulk_orders` */

DROP TABLE IF EXISTS `food_bulk_orders`;

CREATE TABLE `food_bulk_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `total_amount` decimal(12,2) DEFAULT '0.00',
  `transdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `food_bulk_orders` */

insert  into `food_bulk_orders`(`id`,`customer_name`,`total_amount`,`transdate`) values (1,'TestNsmr','450.00','2024-03-22 18:08:57');

/*Table structure for table `food_orders` */

DROP TABLE IF EXISTS `food_orders`;

CREATE TABLE `food_orders` (
  `food_id` int(10) unsigned NOT NULL,
  `room_booking_id` int(10) unsigned DEFAULT '0',
  `food_bulk_id` int(11) DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '1',
  `cost` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `food_orders_food_id_index` (`food_id`),
  KEY `food_orders_room_booking_id_index` (`room_booking_id`),
  CONSTRAINT `food_orders_food_id_foreign` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `food_orders` */

insert  into `food_orders`(`food_id`,`room_booking_id`,`food_bulk_id`,`quantity`,`cost`,`created_at`,`updated_at`) values (15,0,1,1,150,'2024-03-22 18:09:04',NULL),(16,0,1,1,150,'2024-03-22 18:09:04',NULL),(16,0,1,1,150,'2024-03-22 18:09:04',NULL),(17,0,1,1,150,'2024-03-22 18:09:51',NULL);

/*Table structure for table `foods` */

DROP TABLE IF EXISTS `foods`;

CREATE TABLE `foods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Appetizer','Soup','Salad','Main Course','Dessert') COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `foods` */

insert  into `foods`(`id`,`name`,`type`,`image`,`price`,`description`,`status`,`created_at`,`updated_at`) values (15,'Cornsilog','Appetizer','x29zmA7rB9OHOoQx6nRWwjTVYl66G1egMPLZGItW.jpg','150.00','Cornsilog',1,'2024-03-07 13:55:58','2024-03-07 13:55:58'),(16,'Hotsilog','Appetizer','JfDqC3FWltCSeMkVq7OHv2wNXvwFCNpimxnd8k7E.jpg','150.00','Hotsilog',1,'2024-03-07 13:56:20','2024-03-07 13:56:20'),(17,'Longsilog','Appetizer','Bu4s7sioLVh9PMavsOhqDiIuuv8sDhQeTuqGFiQ8.jpg','150.00','Longsilog',1,'2024-03-07 13:56:38','2024-03-07 13:56:38'),(18,'Shangsilog','Appetizer','WzQ5ZpO7eCAwNjws485KXtxPkVgsQgM2xDuZ2tfL.jpg','150.00','Shangsilog',1,'2024-03-07 13:57:03','2024-03-07 13:57:03'),(19,'Plain Rice','Appetizer','Qsytb1HzgUpvFadZzxz3LtEIvEeNiTH1NzuSbDvX.jpg','20.00','Plain Rice',1,'2024-03-07 13:57:32','2024-03-07 13:57:32'),(20,'Instant Coffee','Appetizer','A4Ap33KHEZBbIxf1rOE7eLgzZrsGLgpL7BPyyveP.jpg','30.00','Instant Coffee',1,'2024-03-07 13:58:02','2024-03-07 13:58:02'),(21,'2 Eggs','Appetizer','qMO5PwIqMRc2yzDSmNrGPerYDW8abSDrNL83teq5.jpg','40.00','2 Eggs',1,'2024-03-07 13:58:18','2024-03-07 13:58:18'),(22,'Longganissa','Appetizer','jGV0cdYVQqOZKPPgAD0scmXeP76hSQPJMiMhgD5G.jpg','60.00','Longganissa',1,'2024-03-07 13:58:34','2024-03-07 13:58:34'),(23,'Juice','Appetizer','V4m4JOSM7DHtcSksAfvN65PDYZRN456hyO9SBD7M.jpg','30.00','Juice',1,'2024-03-07 13:58:50','2024-03-07 13:58:50'),(24,'Corned Beef','Appetizer','EPUAS9IXetdmTyVS75DMclxc8gnWdgEURLU2yV2S.jpg','60.00','Corned Beef',1,'2024-03-07 13:59:05','2024-03-07 13:59:05'),(25,'Hotdog','Appetizer','t0iHfEF9XjdzyFHQvhIyBTx2ZDXEHMBGH5vh9DPL.jpg','60.00','Hotdog',1,'2024-03-07 13:59:22','2024-03-07 13:59:22'),(26,'Lumpia Shanghai','Appetizer','cmh8w5WC2VXB3MGZRNmQtWx9K6gXrUuNXD5Pn59d.jpg','60.00','Lumpia Shanghai',1,'2024-03-07 13:59:38','2024-03-07 13:59:38'),(27,'French Fries','Appetizer','Wu4DtwqA5Ehz1WzDUtkHInaXCv8D9s0fLTCkMIUA.jpg','79.00','French Fries',1,'2024-03-07 13:59:55','2024-03-07 13:59:55'),(28,'Vegetable Lumpia','Appetizer','1qDMJOv4aQQLoAXswIb9BREraU615cmFEaFRRlC7.jpg','79.00','Vegetable Lumpia',1,'2024-03-07 14:00:18','2024-03-07 14:00:18'),(29,'Tinolang Manok','Appetizer','mdeJ0kTbWRJHhwKL8kWKYpAwjXMCJRaHVAxv9Ets.jpg','159.00','Tinolang Manok',1,'2024-03-07 14:00:50','2024-03-07 14:00:50'),(30,'Sinigang na Baboy','Appetizer','n05wX5ScEXBj22t2Mkv3Y8IQygr8Z9ovkU8ec3Nw.jpg','199.00','Sinigang na Baboy',1,'2024-03-07 14:01:28','2024-03-07 14:01:28'),(31,'Pancit bam-I','Appetizer','XHuIOwmNvamqVKPZ18JXEBzurkq0oOY9N2undl5D.jpg','150.00','Pancit bam-I',1,'2024-03-07 14:01:50','2024-03-07 14:01:50'),(32,'Chicken Wings W/ Fries or Rice','Appetizer','pwco51VG06bVC01WTECSS0pBKf4fgm2ZnwNj2dr5.jpg','189.00','Chicken Wings W/ Fries or Rice',1,'2024-03-07 14:02:15','2024-03-07 14:02:15'),(33,'Pork Humba','Appetizer','es7OpURLR47LnVSGWVnjsDqhnrKRuALMfnwPR7nH.jpg','150.00','Pork Humba',1,'2024-03-07 14:02:57','2024-03-07 14:02:57'),(34,'Rice Platter','Appetizer','prTuIceyTTfH4i49okjOCbDxAhq3vRSlLJKQiQNz.jpg','50.00','Rice Platter',1,'2024-03-07 14:03:12','2024-03-07 14:03:12'),(35,'Red Horse','Appetizer','8u3LfzJAq898dif1azTclS9KE71HIGptOyZknIv6.jpg','130.00','Red Horse',1,'2024-03-07 14:03:44','2024-03-07 14:03:44'),(36,'Stallion','Appetizer','0XUqxwCHqhqZiGXGHiODlBWcBsj0vnnsBJ6gvGzg.jpg','50.00','Stallion',1,'2024-03-07 14:03:57','2024-03-07 14:03:57'),(37,'SMB Grande','Appetizer','ndmlbDF553aqXyDCB148I4Pwgy3nlSShU33aCCJC.jpg','120.00','SMB Grande',1,'2024-03-07 14:04:11','2024-03-07 14:04:11'),(38,'Pale Pilsen','Appetizer','5FeMQyLl7B7q6BR3wcPT76j3p9DUGun05EkqIC9s.jpg','50.00','Pale Pilsen',1,'2024-03-07 14:04:24','2024-03-07 14:04:24'),(39,'Coke Litro','Appetizer','esJe4wTc8IjcybPNScHLw1krpvAQAzU4o37zgwVe.jpg','60.00','Coke Litro',1,'2024-03-07 14:04:38','2024-03-07 14:04:38'),(40,'Coke Sakto','Appetizer','NAD4bBuOA3UeOcf6wE5cNLyJyL3lkJN5GnN7AzWL.jpg','20.00','Coke Sakto',1,'2024-03-07 14:04:55','2024-03-07 14:04:55'),(41,'Flavored Beer','Appetizer','K5OJRRWdCmxK3gMYCryUYdC7sgSlIc9QUg6STtcp.jpg','60.00','Flavored Beer',1,'2024-03-07 14:05:07','2024-03-07 14:05:07'),(42,'San Miguel Light','Appetizer','fSSKfUKRsEuYyEOvUITUNYEuKhNtfbu84Zraynz3.jpg','60.00','San Miguel Light',1,'2024-03-07 14:05:22','2024-03-07 14:05:22'),(43,'Juice in Pitchel','Appetizer','a8WCe3fQWiUK5xkBp7Xk7ClNllmDmk9xo9WBfxZH.jpg','99.00','Juice in Pitchel',1,'2024-03-07 14:05:40','2024-03-07 14:05:40'),(44,'Ice Tea','Appetizer','zLhxywgQRWEIKjMOQLUt4Y7kFeIj1h9dvpnZlZG0.jpg','99.00','Ice Tea',1,'2024-03-07 14:05:55','2024-03-07 14:05:55'),(45,'Bottled Water 500 ml','Appetizer','qzT0nonGCBmhS2CXA4FqFSvs5Hg3MlyzpfVYGpH9.jpg','20.00','Bottled Water 500 ml',1,'2024-03-07 14:06:53','2024-03-07 14:06:53'),(46,'Bottle Water 1L','Appetizer','jKsGJpktFYqPIdQdCTw9SjMAg9SuXsiQkDe2Ujis.jpg','40.00','Bottle Water 1L',1,'2024-03-07 14:07:08','2024-03-07 14:07:08');

/*Table structure for table `images` */

DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `room_type_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `images_room_type_id_index` (`room_type_id`),
  CONSTRAINT `images_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `images` */

insert  into `images`(`id`,`name`,`caption`,`is_primary`,`status`,`room_type_id`,`created_at`,`updated_at`) values (1,'c1uTBYaS9DSfzpvHhW2iASd0ujqUmZaWnWbvbbDy.jpg','Deluxe Room',1,1,1,'2024-02-27 02:15:49','2024-02-27 04:30:14'),(4,'vLATN00Ou2H6NP8OB0JNUNldpng2b9m2sUk5UyeK.jpg','Family',1,1,2,'2024-02-27 02:15:49','2024-02-27 04:30:41'),(7,'JMxLRYpsgQ4OFRBQDY8zXNcHP4kThcINRRJCHelo.jpg','Mini Kubo',1,1,3,'2024-02-27 02:15:49','2024-02-27 04:31:10'),(10,'10.jpg','New thing',1,1,4,'2024-02-27 02:15:49',NULL),(11,'11.jpg','Room with cool aspects',0,1,4,'2024-02-27 02:15:49',NULL),(12,'12.jpg','Amazing Room',0,1,4,'2024-02-27 02:15:49',NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pages` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `booker_name` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `remaining_balance` decimal(12,1) DEFAULT '0.0',
  `payment_type` int(11) NOT NULL DEFAULT '1' COMMENT '0 is for partial payment',
  `paid_item_type` enum('event','food','room','entrance','pool') DEFAULT NULL,
  `transdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `payments` */

insert  into `payments`(`id`,`item_id`,`booker_name`,`item_name`,`amount`,`remaining_balance`,`payment_type`,`paid_item_type`,`transdate`) values (1,1,'Test','Pool','150.00','0.0',1,'pool','2024-03-16 12:34:40'),(2,7,'','test','5999.00','0.0',1,'event','2024-03-16 12:35:22'),(3,1,'TestNsmr','Food Order','450.00','0.0',1,'food','2024-03-22 18:09:04'),(4,1,'test Manual','Delux Room - Room Number: 1','1999.00','0.0',1,'room','2024-03-22 20:12:07');

/*Table structure for table `paypal_payments` */

DROP TABLE IF EXISTS `paypal_payments`;

CREATE TABLE `paypal_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payer_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payer_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `paypal_payments` */

/*Table structure for table `reviews` */

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `review` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `room_booking_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_room_booking_id_index` (`room_booking_id`),
  CONSTRAINT `reviews_room_booking_id_foreign` FOREIGN KEY (`room_booking_id`) REFERENCES `room_bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `reviews` */

/*Table structure for table `room_bookings` */

DROP TABLE IF EXISTS `room_bookings`;

CREATE TABLE `room_bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `booker` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_id` int(10) unsigned NOT NULL,
  `user_id` int(10) NOT NULL,
  `arrival_date` date NOT NULL,
  `departure_date` date DEFAULT NULL,
  `room_cost` int(11) NOT NULL,
  `status` enum('pending','checked_in','checked_out','cancelled','approved','booked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_bookings_room_id_index` (`room_id`),
  CONSTRAINT `room_bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `room_bookings` */

insert  into `room_bookings`(`id`,`booker`,`room_id`,`user_id`,`arrival_date`,`departure_date`,`room_cost`,`status`,`payment`,`created_at`,`updated_at`) values (9,NULL,1,1,'2024-03-28','2024-03-29',1999,'pending',2,'2024-03-26 01:26:34','2024-03-26 01:43:17');

/*Table structure for table `room_types` */

DROP TABLE IF EXISTS `room_types`;

CREATE TABLE `room_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_per_day` int(11) NOT NULL,
  `discount_percentage` int(11) NOT NULL DEFAULT '0',
  `size` int(11) DEFAULT NULL,
  `max_adult` int(11) DEFAULT '0',
  `max_child` int(11) DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `room_service` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `room_types` */

insert  into `room_types`(`id`,`name`,`cost_per_day`,`discount_percentage`,`size`,`max_adult`,`max_child`,`description`,`room_service`,`status`,`created_at`,`updated_at`) values (1,'Delux Room',1999,0,3000,4,1,'Deluxe room with free breakfast',1,1,'2024-02-27 02:15:49','2024-02-27 04:19:00'),(2,'Family Room',2999,0,2000,4,1,'Family Room with free breakfast',1,1,'2024-02-27 02:15:49','2024-03-23 15:38:42'),(3,'Mini Kubo Room',1200,0,1400,4,2,'Mini Kubo with free breakfast \r\n',1,1,'2024-02-27 02:15:49','2024-02-27 04:19:25'),(4,'Big Kubo Room',9000,0,800,4,2,'Big Kubo room with free breakfast',0,0,'2024-02-27 02:15:49','2024-02-27 02:39:58');

/*Table structure for table `rooms` */

DROP TABLE IF EXISTS `rooms`;

CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_number` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `room_type_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rooms_room_number_unique` (`room_number`),
  KEY `rooms_room_type_id_index` (`room_type_id`),
  CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `rooms` */

insert  into `rooms`(`id`,`room_number`,`description`,`available`,`status`,`room_type_id`,`created_at`,`updated_at`) values (1,'1','Nihil aut soluta ratione debitis. Inventore in doloremque nihil maxime quis voluptates.',1,1,1,'2024-02-27 02:15:49','2024-02-27 02:15:49'),(3,'3','Fuga sed ratione et non. Dolorem ex quo eveniet qui nostrum. Excepturi necessitatibus voluptas velit illum quibusdam consequatur ad. Voluptas repellat ab id labore doloribus unde eveniet.',1,1,3,'2024-02-27 02:15:49','2024-02-27 02:15:49'),(4,'4','Qui esse nostrum molestias et. Hic praesentium consequatur fuga et ad praesentium rem. Corrupti ut amet incidunt aut.',1,1,2,'2024-02-27 02:15:49','2024-02-27 02:15:49'),(5,'5','Omnis sit odio quidem harum quas. Blanditiis iusto ut atque dolores. Cumque id quis asperiores. Voluptatem quibusdam sapiente voluptates consectetur aut.',1,1,4,'2024-02-27 02:15:49','2024-02-27 02:15:49'),(9,'9','Incidunt rem corporis voluptate ut. Ex maxime saepe veritatis molestiae optio est. Et beatae nemo suscipit repellat ab qui aut.',1,1,2,'2024-02-27 02:15:49','2024-02-27 02:15:49'),(10,'10','Delectus voluptatem nobis eos. Est quis dolore voluptas. Aut voluptate quasi ea non impedit iusto.',1,1,1,'2024-02-27 02:15:49','2024-02-27 02:15:49'),(11,'11','Iure odit saepe praesentium a dolores. Pariatur laboriosam autem reprehenderit. Nobis id provident iure.',1,1,3,'2024-02-27 02:15:49','2024-02-27 02:15:49'),(21,'21','Et et voluptatem omnis libero perferendis reprehenderit dolor. Dolor aliquam exercitationem porro quibusdam. Culpa vel et sed. Pariatur dolor sed facere rerum voluptas.',1,1,4,'2024-02-27 02:15:49','2024-02-27 02:15:49'),(30,'30','Ab et aut et eaque repellendus quia. Officia quibusdam modi quae quos animi non dolores. Impedit dicta ex dolorum libero est aspernatur.',1,1,4,'2024-02-27 02:15:49','2024-02-27 02:15:49');

/*Table structure for table `slider` */

DROP TABLE IF EXISTS `slider`;

CREATE TABLE `slider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `small_title` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `big_title` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_text` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `slider` */

insert  into `slider`(`id`,`name`,`small_title`,`big_title`,`description`,`link`,`link_text`,`status`,`created_at`,`updated_at`) values (1,'1.jpg','One Experience the resort','Bung-Aw Eco Farm','One Mauris non placerat nulla. Sed vestibulum quam mauris, et malesuada tortor venenatis sem porta est consectetur posuere. Praesent nisi velit, porttitor ut imperdiet a, pellentesque id mi.','room_type/1','Book Now',1,'2024-02-27 02:15:49',NULL),(2,'2.jpg','Two Experience the resort','Bung-Aw Eco Farm','Two Mauris non placerat nulla. Sed vestibulum quam mauris, et malesuada tortor venenatis sem porta est consectetur posuere. Praesent nisi velit, porttitor ut imperdiet a, pellentesque id mi.','room_type/2','Book Now',1,'2024-02-27 02:15:49',NULL),(3,'3.jpg','Three Experience the resort','Bung-Aw Eco Farm','Three Mauris non placerat nulla. Sed vestibulum quam mauris, et malesuada tortor venenatis sem porta est consectetur posuere. Praesent nisi velit, porttitor ut imperdiet a, pellentesque id mi.','room_type/3','Book Now',1,'2024-02-27 02:15:49',NULL),(4,'4.jpg','Four Experience the resort','Bung-Aw Eco Farm','Four Mauris non placerat nulla. Sed vestibulum quam mauris, et malesuada tortor venenatis sem porta est consectetur posuere. Praesent nisi velit, porttitor ut imperdiet a, pellentesque id mi.','room_type/4','Book Now',1,'2024-02-27 02:15:49',NULL);

/*Table structure for table `subscribers` */

DROP TABLE IF EXISTS `subscribers`;

CREATE TABLE `subscribers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `subscribers` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','others') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user','superadmin','cashier') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_facebook_id_unique` (`facebook_id`),
  UNIQUE KEY `users_twitter_id_unique` (`twitter_id`),
  UNIQUE KEY `users_google_id_unique` (`google_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`last_name`,`gender`,`phone`,`address`,`email`,`password`,`avatar`,`about`,`facebook_id`,`twitter_id`,`google_id`,`role`,`status`,`remember_token`,`created_at`,`updated_at`) values (1,'Jeric','Basco','male','09103456721','Brgy.San Antonio, Sagbayan, Bohol','jericbasco22@gmail.com','$2y$10$EppVeh/89qaRhQnoS34wSuja.YFkctx1g7NolXDiWjPKu1zZgnNDm','girl-1.png','hello from the other world',NULL,NULL,NULL,'user',1,'LGEQnUYsBmIivKoRdniuj48PNLdqyGxcvICcELv4HwrFpzt0LwSCtvkoxsib','2024-02-27 02:15:49',NULL),(2,'admin','admin','male','0912118872','Brgy.San Antonio, Sagbayan, Bohol','admin@gmail.com','$2y$10$mtLrpcUE1TqplK/db8zvY.5U38Nc4pCiNwIMQX0FJF1S1/9OeFKeu','boy-1.png','hello from the other world',NULL,NULL,NULL,'admin',1,'tyvhO8ppbpjhByJXXJPDe5dOaa2BNdrThSxwrCtpVlWDuqoRaXqQ3JGG0iaI','2024-02-27 02:15:49',NULL),(3,'super','admin','male','0912218872','Brgy.San Antonio, Sagbayan, Bohol','sadmin@gmail.com','$2y$10$PGYu1aNavhryLCLSocgWQ.jxZGz2n99ozsz6F7p1lik9b1bRFXK62','boy-1.png','hello from the other world',NULL,NULL,NULL,'superadmin',1,'6oBaIGd3RP','2024-02-27 02:15:49',NULL),(4,'cashier','1','male','0923928189','Test','cashier@gmail.com','*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19',NULL,NULL,NULL,NULL,NULL,'cashier',1,NULL,NULL,NULL);

/* Trigger structure for table `room_bookings` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `change_trigger` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `change_trigger` AFTER UPDATE ON `room_bookings` FOR EACH ROW BEGIN
	if new.payment <> 0 then
		set @_paymentCount := (select count(*) from payments p where p.item_id = new.id);
		set @_item_name := (SELECT rt.`name` FROM `room_types` rt WHERE rt.`id` = new.room_id);
		if @_paymentCount = 0 then
			if (new.payment = 1) then 
				insert into `payments` (`item_id`,`booker_name`,`item_name`,`amount`,`remaining_balance`,`payment_type`,`paid_item_type`)
				values (new.id,new.booker,@_item_name,0,new.room_cost,new.payment,"room");
			else
				INSERT INTO `payments` (`item_id`,`booker_name`,`item_name`,`amount`,`remaining_balance`,`payment_type`,`paid_item_type`)
				VALUES (new.id,new.booker,@_item_name,0,0,new.payment,"room");
			end if;
		else
			IF (new.payment = 1) THEN 
				update payments set `payment_type` = 1,`remaining_balance` = new.room_cost where item_id = new.id and paid_item_type = "room";
			ELSE
				UPDATE payments SET `payment_type` = 2,`remaining_balance` = 0 WHERE item_id = new.id AND paid_item_type = "room";
			END IF;
		end if;
	end if;
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
