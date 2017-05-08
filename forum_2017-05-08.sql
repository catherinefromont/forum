# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.35)
# Database: forum
# Generation Time: 2017-05-08 03:42:30 +0000
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
	(4,'Title1','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi eu porta purus, quis elementum leo. Quisque quis arcu ac felis convallis rhoncus. Pellentesque dignissim tortor eget nunc convallis hendrerit. Morbi rhoncus viverra massa sed volutpat. Nullam non nisi congue lacus feugiat consectetur at id ipsum. Cras cursus tempor feugiat. Duis et justo eu lorem facilisis accumsan vel sed lectus. Aliquam erat volutpat.',5,'2017-05-01 11:48:48','2017-05-01 11:37:50');

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
	(7,'civeril','paxawebit@yahoo.com','$2y$10$GXhZvqdSABGeqVA8/D1RcOAXaXYzDnEQUeaCk/WiutEMvkWfMZUyO',0),
	(8,'livasikapy','codyf@hotmail.com','$2y$10$UI8NUiIcHC1aOTEdl9/L9OPndl95df/bLsbYay88oS9h6znPCY5JO',0),
	(12,'wasohiky','mukad@gmail.com','$2y$10$.yziMb1MhTtxUqTbjsi/2OxdY/NJL7Ar2s8sYakPN7/NYnKYkFprW',0),
	(13,'pedator','fisir@yahoo.com','$2y$10$8SosnvsBeWFNPL.c1qHKY.mc.yvOgUGEn8yEmWoyYH/Wo8n/f4vZa',0),
	(14,'zexyw','seqaq@hotmail.com','$2y$10$7DoQuQYRy6i9W2yg7z3sYexRjAPvmngqWwDVq5UHgtoC3HfMZ6YMe',0),
	(15,'mycahimuga','giqirop@gmail.com','$2y$10$VdogU4AOGugnZAaMy0NOeulMAMutDLfoKwsy.cCYZE1ykTZoJTg02',0),
	(16,'komelydo','bokitumi@gmail.com','$2y$10$d4dXXpQbFyE0skeRJfmHDeAuwVvGBJ196KbpNteX5doy1pDeffhX2',0),
	(17,'tygep','savaxekec@yahoo.com','$2y$10$jS6Fp2WbX82zIHa3gS6LMuItP6EMECB40Dzm7v/CMiLHZqZZrogcm',0),
	(18,'lol','lol@lol.com','$2y$10$GVbEWtjAb/J.AShRG8vwbehpafuu4xY7WHswAiOKaomrkyizPAH4S',0),
	(19,'nilygu','cufosoni@yahoo.com','$2y$10$tl2HRB/g75CbPjFkbaKI3eiOAusFyNAWF8OOzyOhsLFUQTiFx5UOu',0),
	(20,'kezumitit','vyqebom@gmail.com','$2y$10$jgqnD1HYA0YpqOehbXJVMuyaLE8WUY5DJrezaksgA8YLGdJMPoTMi',0),
	(21,'kezumitit','vyqebom@gmail.com','$2y$10$4sN4vBOEcKoRkAEPGcgCMOzHvl6PWgplxrebVhtUamiPt6XiJoBX.',0),
	(22,'rihym','velevesi@gmail.com','$2y$10$PXIiAhRg1xscWg7riVwCWengmJCi9E7T4HADPJK3KtAnmfo7YmZhG',0),
	(23,'wihapusa','lyjyhotyfo@gmail.com','$2y$10$fq60MRzVbhEU/0W7uWT6seS5yhOR56uncuiFHfMIBNzD3VTOCCJaK',0);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
