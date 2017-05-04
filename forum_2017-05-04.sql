# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.35)
# Database: forum
# Generation Time: 2017-05-04 04:28:21 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `comments_ibfk_2` (`topic_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;

INSERT INTO `comments` (`id`, `content`, `user_id`, `topic_id`, `updated_at`, `created_at`)
VALUES
	(5,' m ',4,9,'2017-05-04 10:44:32','2017-05-04 10:44:32'),
	(6,' ,m,m ,m ,m ,m ,. .,.,lkjnhjbjhbgb',4,4,'2017-05-04 10:45:02','2017-05-04 10:45:02'),
	(7,'adsklfnkadslf',4,4,'2017-05-04 10:46:08','2017-05-04 10:46:08'),
	(8,'fjdha',4,4,'2017-05-04 10:47:07','2017-05-04 10:47:07'),
	(9,'dcbkjcd ncx',4,4,'2017-05-04 10:47:29','2017-05-04 10:47:29'),
	(10,'TRNJSKEAGVEDJS',4,10,'2017-05-04 15:09:30','2017-05-04 15:09:30');

/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table topics
# ------------------------------------------------------------

DROP TABLE IF EXISTS `topics`;

CREATE TABLE `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `userRelation` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;

INSERT INTO `topics` (`id`, `title`, `content`, `user_id`, `created_at`, `updated_at`)
VALUES
	(2,'Title','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi eu porta purus, quis elementum leo. Quisque quis arcu ac felis convallis rhoncus. Pellentesque dignissim tortor eget nunc convallis hendrerit. Morbi rhoncus viverra massa sed volutpat. Nullam non nisi congue lacus feugiat consectetur at id ipsum. Cras cursus tempor feugiat. Duis et justo eu lorem facilisis accumsan vel sed lectus. Aliquam erat volutpat.',4,'2017-05-01 11:43:32','2017-05-01 11:37:50'),
	(4,'Title1','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi eu porta purus, quis elementum leo. Quisque quis arcu ac felis convallis rhoncus. Pellentesque dignissim tortor eget nunc convallis hendrerit. Morbi rhoncus viverra massa sed volutpat. Nullam non nisi congue lacus feugiat consectetur at id ipsum. Cras cursus tempor feugiat. Duis et justo eu lorem facilisis accumsan vel sed lectus. Aliquam erat volutpat.',5,'2017-05-01 11:48:48','2017-05-01 11:37:50'),
	(9,'Test2','Qui occaecat ut reprehenderit enim numquam molestiae laboris asperiores atque non corrupti, voluptas.',4,'2017-05-04 10:38:32','2017-05-04 10:38:32'),
	(10,'Test3','At aliquid eum voluptatibus sunt, animi, fugiat, doloribus exercitation consequatur ut aut at inventore asperiores.',4,'2017-05-04 12:15:13','2017-05-04 12:15:13');

/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` char(60) DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `admin`)
VALUES
	(4,'Catherine','catherinegfromont@gmail.com','$2y$10$/GPJQ1TUm8S8IKYQIE.iPu5BjdQ0uYooOY0jANqfd3sfsfHP7Pnvy',1),
	(5,'Catherine1','catherinegfromont1@gmail.com','$2y$10$/GPJQ1TUm8S8IKYQIE.iPu5BjdQ0uYooOY0jANqfd3sfsfHP7Pnvy',0),
	(6,'vosyfe','kezuxibi@gmail.com','$2y$10$8xqc13dAeUxalTd/INnv.OgHptuv.kARNCZhLluUpD1O/HlUpsVkW',0),
	(7,'civeril','paxawebit@yahoo.com','$2y$10$GXhZvqdSABGeqVA8/D1RcOAXaXYzDnEQUeaCk/WiutEMvkWfMZUyO',0);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
