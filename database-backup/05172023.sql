/*
SQLyog Ultimate v9.62 
MySQL - 5.6.37-log : Database - mms2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mms2` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mms2`;

/*Table structure for table `faculty` */

DROP TABLE IF EXISTS `faculty`;

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `course_abb` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `faculty` */

insert  into `faculty`(`id`,`name`,`course_abb`,`department`) values (1,'Dr. Deanne Cameren Evangelista','CEA','CEA'),(2,'Dr. Edgar Uy','CpE','CEA'),(3,'Dr. Edward Anuta','CpE','CEA'),(4,'Engr. Roselle Cimagala','CpE','CEA'),(5,'Elaine Cepe','CpE','CEA'),(6,'Girlei L. Valeroso, EdD FLT','BSEd Filipino and English','CTE'),(7,'Joann R. Talo, MSc','BEED & BSEd Mathematics Student Teacher Supervisor','CTE'),(8,'Rose Anne Q. Palma, MAT-SOCSCI','SSG Adviser','CTE'),(9,'Thesse D. Tahil, MSc','Part-time Instructor','CTE'),(10,'Ritchie Mar C. Ugsod, MSIT','Instructor 1','CTE');

/*Table structure for table `memo` */

DROP TABLE IF EXISTS `memo`;

CREATE TABLE `memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memo_number` varchar(255) DEFAULT NULL,
  `send_to` varchar(255) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text,
  `additional_info` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `memo` */

/*Table structure for table `memo_route` */

DROP TABLE IF EXISTS `memo_route`;

CREATE TABLE `memo_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memo_id` int(11) NOT NULL,
  `faculty_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `memo_route` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilege` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`user_id`,`username`,`password`,`privilege`) values (1,45629,'admin','admin','admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
