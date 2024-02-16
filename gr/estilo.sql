/*
SQLyog Community v8.3 Beta2
MySQL - 5.5.32 : Database - pcprii
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pcprii` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `pcprii`;

/*Table structure for table `estilo` */

CREATE TABLE `estilo` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `papel` varchar(2) COLLATE utf8_unicode_ci DEFAULT 'A4' COMMENT 'Papel',
  `orientacao` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'P' COMMENT 'Orientação',
  `fonte` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'Courier' COMMENT 'Fonte',
  `estilo` varchar(1) COLLATE utf8_unicode_ci DEFAULT 'N' COMMENT 'Estilo',
  `nrolinhas` int(11) DEFAULT '61' COMMENT 'N Linhas',
  `nrocolunas` int(11) DEFAULT '93' COMMENT 'N Colunas',
  `alturalinha` varchar(3) COLLATE utf8_unicode_ci DEFAULT '0.4' COMMENT 'Altura da Linha',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `estilo` */

LOCK TABLES `estilo` WRITE;

insert  into `estilo`(`id`,`papel`,`orientacao`,`fonte`,`estilo`,`nrolinhas`,`nrocolunas`,`alturalinha`) values (1,'A4','P','Courier','N',61,93,'0.4'),(2,'A4','L','Courier','N',35,150,'0.4');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
