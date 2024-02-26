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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `faculty` */

insert  into `faculty`(`id`,`name`,`course_abb`,`department`) values (1,'Dr. Deanne Cameren Evangelista','CpE','CEA'),(2,'Dr. Edgar Uy','CpE','CEA'),(3,'Dr. Edward Anuta','CpE','CEA'),(4,'Engr. Roselle Cimagala','CpE','CEA'),(5,'Elaine Cepe','CpE','CEA'),(6,'Girlei L. Valeroso, EdD FLT','BSEd Filipino and English','CTE'),(7,'Joann R. Talo, MSc','BEED & BSEd Mathematics Student Teacher Supervisor','CTE'),(8,'Rose Anne Q. Palma, MAT-SOCSCI','SSG Adviser','CTE'),(9,'Thesse D. Tahil, MSc','Part-time Instructor','CTE'),(10,'Ritchie Mar C. Ugsod, MSIT','Instructor 1','CTE'),(11,'Testingasdf','Testing','Testing');

/*Table structure for table `memo` */

DROP TABLE IF EXISTS `memo`;

CREATE TABLE `memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memo_number` varchar(255) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text,
  `additional_info` text,
  `is_void` int(11) DEFAULT '0',
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
  `user_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilege` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`user_name`,`username`,`password`,`privilege`) values (1,'University President','admin','*4ACFE3202A5FF5CF467898FC58AAB1D615029441','admin'),(2,'BISU-MC Director','admin2','*0E6FD44C7B722784DAE6E67EF8C06FB1ACB3E0A6','admin'),(3,'College of Engineering, Dean','admin3','*23EF57C77F8C48E0F66F59339F9729BADAFD3F37','admin'),(4,'Dr. Deanne Cameren Evangelista','user','*D5D9F81F5542DE067FFF5FF7A4CA4BDD322C578F','user');

/* Procedure structure for procedure `sp_edit` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_edit` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_edit`(
    in _id int(11),
    in _from varchar(255)
    )
BEGIN
	set @number = 1;
	set @bool = 1;
	
	while (@bool >= 1) Do
	
		SET @count := (SELECT count(*) as `count` FROM `memo` m where m.from = _from and m.memo_number = concat("000",@number));
		
		if (@count = 0) then
			UPDATE `memo` m SET m.`memo_number` = CONCAT("000",@number), m.`from` = _from WHERE m.`id` =_id;
			 
			set @bool = 0;
		end if;
		SET @number = @number + 1;
	end while;
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
