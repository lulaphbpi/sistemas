/*
SQLyog Community v13.1.2 (64 bit)
MySQL - 10.1.40-MariaDB : Database - efisio
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`efisio` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `efisio`;

/*Table structure for table `agenda` */


DROP TABLE IF EXISTS `consulta`;

CREATE TABLE `consulta` (
  `id` int(11) NOT NULL,
  `cpfresponsavel` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipodeacompanhante_id` tinyint(4) DEFAULT NULL,
  `convenio_id` int(11) DEFAULT NULL,
  `cartaosus` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `planodesaude_id` tinyint(4) DEFAULT NULL,
  `medico_id` int(11) DEFAULT NULL,
  `dataregistro` date DEFAULT NULL,
  `dataconsulta` date DEFAULT NULL,
  `horario` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consultapessoa_id` int(11) DEFAULT NULL,
  `confirmado` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `realizado` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `convenio` */

DROP TABLE IF EXISTS `convenio`;

CREATE TABLE `convenio` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert  into `convenio`(`id`,`descricao`) values 
(1,'SUS'),
(2,'Particular');

/*Table structure for table `cor` */

DROP TABLE IF EXISTS `cor`;

CREATE TABLE `cor` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cor` */

insert  into `cor`(`id`,`descricao`) values 
(1,'Amarelo'),
(2,'Branco'),
(3,'IndÃ­gena'),
(4,'Negro'),
(5,'Pardo');

/*Table structure for table `diautil` */

DROP TABLE IF EXISTS `diautil`;

CREATE TABLE `diautil` (
  `id` int(11) DEFAULT NULL,
  `dia` date DEFAULT NULL,
  `turno_id` tinyint(4) DEFAULT NULL,
  `statusdiautil_id` tinyint(4) DEFAULT NULL,
  `descricao` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `limite` int(11) DEFAULT NULL,
  `confirmados` int(11) DEFAULT NULL,
  `efetivados` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `escala` */

DROP TABLE IF EXISTS `escala`;

CREATE TABLE `escala` (
  `id` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `limite` tinyint(4) DEFAULT NULL,
  `quantidade` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `especialidade` */

DROP TABLE IF EXISTS `especialidade`;

CREATE TABLE `especialidade` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `exame` */

/*Table structure for table `grupo` */

DROP TABLE IF EXISTS `grupo`;

CREATE TABLE `grupo` (
  `id` tinyint(11) NOT NULL,
  `grupo` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `hystory` */

DROP TABLE IF EXISTS `hystory`;

CREATE TABLE `hystory` (
  `id` double NOT NULL AUTO_INCREMENT,
  `usuario_id` int(30) DEFAULT NULL,
  `objeto` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssql` blob,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `medico` */

DROP TABLE IF EXISTS `medico`;

CREATE TABLE `medico` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `crm` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `especialidade_id` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `naturezadapessoa` */

DROP TABLE IF EXISTS `naturezadapessoa`;

CREATE TABLE `naturezadapessoa` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `naturezadapessoa` */

insert  into `naturezadapessoa`(`id`,`descricao`) values 
(1,'Operador de Sistema'),
(2,'Paciente');
/*Table structure for table `niveldousuario` */

DROP TABLE IF EXISTS `niveldousuario`;

CREATE TABLE `niveldousuario` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `niveldousuario` */

insert  into `niveldousuario`(`id`,`descricao`) values 
(1,'Administrador'),
(2,'Operador RecepÃ§Ã£o'),
(3,'MÃ©dica(o)'),
(4,'Enfermeira(o)'),
(5,'Paciente');

/*Table structure for table `pes001` */

DROP TABLE IF EXISTS `pes001`;

CREATE TABLE `pes001` (
  `ord` int(11) NOT NULL,
  `pessoaid` int(11) NOT NULL,
  `natureza` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpf` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` tinytext COLLATE utf8_unicode_ci,
  `sexo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datanascimento` date DEFAULT NULL,
  `fone` tinytext COLLATE utf8_unicode_ci,
  `cartaosus` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nivel` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identificacao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ativo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `pessoa` */

DROP TABLE IF EXISTS `pessoa`;

CREATE TABLE `pessoa` (
  `id` int(11) NOT NULL,
  `pessoa_id` int(11) DEFAULT NULL,
  `naturezadapessoa_id` tinyint(4) DEFAULT NULL,
  `cartaosus` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomemae` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cor_id` tinyint(4) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `observacoes` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


/*Table structure for table `planodesaude` */

DROP TABLE IF EXISTS `planodesaude`;

CREATE TABLE `planodesaude` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*Data for the table `planodesaude` */

insert  into `planodesaude`(`id`,`descricao`) values 
(1,'Allianz Saúde'),
(2,'Ameno Saúde'),
(3,'Ameplan Saúde'),
(4,'Amil Saúde'),
(5,'Amr Saúde'),
(6,'Ana Costa Saúde'),
(7,'Biosaude'),
(8,'Blue Med Saúde'),
(9,'Bradesco Saúde'),
(10,'Caixa Saúde'),
(11,'Care Plus Saúde'),
(12,'Central Nacional Unimed'),
(13,'Classes Laboriosas'),
(14,'Garantia de Saúde'),
(15,'Greenline Saúde'),
(16,'Hapvida'),
(17,'Interclínicas'),
(18,'Med Tour Saúde'),
(19,'Next Saúde'),
(20,'Notre Dame Intermédica'),
(21,'Omint Saúde'),
(22,'One Health'),
(23,'Plamta'),
(24,'Plena Saúde'),
(25,'Porto Seguro Saúde'),
(26,'Prevent Senior'),
(27,'Samed Saúde'),
(28,'Santa Helena Saúde'),
(29,'São Cristovão Saúde'),
(30,'São Miguel Saúde'),
(31,'Seguros Unimed Saúde'),
(32,'Sompo Saúde'),
(33,'Sul América Saúde'),
(34,'Trasmontano Saúde'),
(35,'Unihosp Saúde'),
(36,'Unimed');

/*Table structure for table `requisicao` */

DROP TABLE IF EXISTS `requisicao`;

CREATE TABLE `requisicao` (
  `id` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `pessoa_id` int(11) DEFAULT NULL,
  `medico_id` int(11) DEFAULT NULL,
  `guia` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statusrequisicao_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `setor` */

DROP TABLE IF EXISTS `setor`;

CREATE TABLE `setor` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `statusdiautil` */

DROP TABLE IF EXISTS `statusdiautil`;

CREATE TABLE `statusdiautil` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `statusdiautil` */

insert  into `statusdiautil`(`id`,`descricao`) values 
(1,'Ativo'),
(2,'Inativo');

/*Table structure for table `tipodeacompanhante` */

DROP TABLE IF EXISTS `tipodeacompanhante`;

CREATE TABLE `tipodeacompanhante` (
  `id` tinyint(4) DEFAULT NULL,
  `descricao` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tipodeacompanhante` */

insert  into `tipodeacompanhante`(`id`,`descricao`) values 
(0,'Sem Acompanhante'),
(1,'MÃ£e/Pai'),
(2,'IrmÃ£(o)'),
(3,'Tia(o)'),
(4,'AvÃ³(Ã´)'),
(5,'Filha(o)'),
(6,'Sobrinha(o)'),
(7,'Vizinha(o)'),
(8,'Amiga(o)'),
(9,'Outro');

/*Table structure for table `turno` */

DROP TABLE IF EXISTS `turno`;

CREATE TABLE `turno` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `pessoa_id` int(11) DEFAULT NULL,
  `grupo_id` tinyint(4) DEFAULT NULL,
  `ativo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
