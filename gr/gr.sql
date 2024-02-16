/*
SQLyog Community v8.3 Beta2
MySQL - 5.5.32 : Database - gr
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`gr` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `gr`;

/*Table structure for table `bloco` */

CREATE TABLE `bloco` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `relatorio_id` int(11) DEFAULT NULL COMMENT 'Relatório',
  `tipobloco_id` int(11) DEFAULT NULL COMMENT 'Tipo ',
  `estilo_id` int(11) DEFAULT NULL COMMENT 'Estilo',
  `conteudo` text COLLATE utf8_unicode_ci COMMENT 'Conteúdo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `bloco` */

LOCK TABLES `bloco` WRITE;

insert  into `bloco`(`id`,`relatorio_id`,`tipobloco_id`,`estilo_id`,`conteudo`) values (1,3,1,1,'********** Gerador de RelatÃ³rios - GERPHPPDF **********\r\n'),(2,3,2,1,'UNIVERSIDADE FEDERAL DO PIAUÃ                                                                                                                 PÃ¡g.: @@  \r\nNÃšCLEO DE TECNOLOGIA DA INFORMAÃ‡ÃƒO                                                                                                    Data: @@/@@/@@@@\r\n------------------------------------------------------------------------------------------------------------------------------------------------------\r\n'),(3,3,3,1,'   Id Comunidade                                         Nome                                                       Inicio     FimMandato Contato   \r\n----- -------------------------------------------------- ---------------------------------------------------------- ---------- ---------- ------------\r\n\r\n'),(4,3,4,1,'@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@@@');

UNLOCK TABLES;

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

insert  into `estilo`(`id`,`papel`,`orientacao`,`fonte`,`estilo`,`nrolinhas`,`nrocolunas`,`alturalinha`) values (1,'A4','P','Courier','N',61,150,'0.4');

UNLOCK TABLES;

/*Table structure for table `fonte` */

CREATE TABLE `fonte` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `fonte` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Fonte',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `fonte` */

LOCK TABLES `fonte` WRITE;

UNLOCK TABLES;

/*Table structure for table `hystory` */

CREATE TABLE `hystory` (
  `id` double NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `objeto` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssql` blob,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=780 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `hystory` */

LOCK TABLES `hystory` WRITE;

insert  into `hystory`(`id`,`usuario_id`,`objeto`,`ssql`,`data`) values (746,113,'relatorio','insert into relatorio values (\'1\',\'rcadpes01\',\'Cadastro de Pessoa\',\'Cadastro de Pessoa\',\'Cadastro\',\'Pessoa\',\'1\')','2016-01-18 12:01:54'),(747,113,'relatorio','insert into relatorio values (\'2\',\'r\',\'Cadastro de Pessoal - Geral\',\'Cadastro Geral de Pessoal\',\'cadastro\',\'pessoa\',\'1\')','2016-01-19 12:01:12'),(748,113,'relatorio','insert into relatorio values (\'3\',\'rcadpes02\',\'Cadastro de Pessoal - Geral\',\'Cadastro Geral de Pessoal\',\'cadastro\',\'pessoa\',\'1\')','2016-01-19 12:01:49'),(749,113,'relatorio','UPDATE relatorio set identificador=\'rcadpes02a\',titulo=\'Cadastro de Pessoal - Geral Alfabética\',descricao=\'Cadastro Geral de Pessoal em Ordem Alfabética\',origem=\'cadastro\',funcao=\'pessoa\',estilo_id=\'1\' where id=2','2016-01-19 12:01:44'),(750,113,'relatorio','UPDATE relatorio set identificador=\'rcadpes02a\',titulo=\'Cadastro de Pessoal - Geral Alfabética\',descricao=\'Cadastro Geral de Pessoal em Ordem Alfabética - Emitido apenas para o Gestor de Negócios - Setor SDR/Projeto Mais Viver Semi-Árido - Governo do Estado do Piauí\',origem=\'cadastro\',funcao=\'pessoa\',estilo_id=\'1\' where id=2','2016-01-19 12:01:20'),(751,113,'tipobloco','UPDATE tipobloco set descricao=\'Cabeçalho Inicial\' where id=1','2016-01-27 10:01:40'),(752,113,'tipobloco','UPDATE tipobloco set descricao=\'Cabeçalho de Página\' where id=2','2016-01-27 10:01:00'),(753,113,'tipobloco','UPDATE tipobloco set descricao=\'Cabeçalho de Detalhe\' where id=3','2016-01-27 10:01:09'),(754,113,'tipobloco','UPDATE tipobloco set descricao=\'Cabeçalho de Grupo\' where id=5','2016-01-27 10:01:29'),(755,113,'tipobloco','UPDATE tipobloco set descricao=\'Rodapé de Página\' where id=7','2016-01-27 10:01:43'),(756,113,'tipobloco','UPDATE tipobloco set descricao=\'Rodapé Final\' where id=8','2016-01-27 10:01:50'),(757,113,'bloco','insert into bloco values (\'1\',1,\'1\',\'1\')','2016-02-02 06:02:55'),(758,113,'bloco','insert into bloco values (\'2\',1,\'2\',\'1\')','2016-02-04 07:02:46'),(759,113,'bloco','insert into bloco values (\'3\',1,\'3\',\'1\')','2016-02-04 07:02:02'),(760,113,'bloco','insert into bloco values (\'4\',1,\'4\',\'1\')','2016-02-04 07:02:10'),(761,113,'bloco','UPDATE bloco set tipobloco_id=\'1\',estilo_id=\'1\',conteudo=\'\' where id=1','2016-02-08 12:02:43'),(762,113,'bloco','UPDATE bloco set tipobloco_id=\'1\',estilo_id=\'1\',conteudo=\'********** Gerador de Relatórios - GERPHPPDF **********\r\n\' where id=1','2016-02-08 04:02:47'),(763,113,'bloco','UPDATE bloco set tipobloco_id=\'1\',estilo_id=\'1\',conteudo=\'********** Gerador de Relatórios - GERPHPPDF **********\r\n\' where id=1','2016-02-08 04:02:06'),(764,113,'bloco','UPDATE bloco set tipobloco_id=\'1\',estilo_id=\'1\',conteudo=\'********** Gerador de Relatórios - GERPHPPDF **********\r\n\' where id=1','2016-02-08 04:02:26'),(765,113,'bloco','UPDATE bloco set tipobloco_id=\'1\',estilo_id=\'1\',conteudo=\'********** Gerador de Relatórios - GERPHPPDF **********\r\n\' where id=1','2016-02-08 04:02:32'),(766,113,'bloco','UPDATE bloco set tipobloco_id=\'2\',estilo_id=\'1\',conteudo=\'UNIVERSIDADE FEDERAL DO PIAUÍ                                                        Pág.: @@  \r\nNÚCLEO DE TECNOLOGIA DA INFORMAÇÃO                                           Data: @@/@@/@@@@\r\n---------------------------------------------------------------------------------------------\r\n\' where id=2','2016-02-08 04:02:25'),(767,113,'bloco','UPDATE bloco set tipobloco_id=\'3\',estilo_id=\'1\',conteudo=\'   Id Comunidade                      Nome                  Inicio  Fim Mandato Contato    \' where id=3','2016-02-08 04:02:05'),(768,113,'bloco','UPDATE bloco set tipobloco_id=\'3\',estilo_id=\'1\',conteudo=\'   Id Comunidade                      Nome                Inicio     FimMandato Contato   \r\n----- ------------------------------- -----------------   ---------- ---------- ------------ \' where id=3','2016-02-08 04:02:58'),(769,113,'bloco','UPDATE bloco set tipobloco_id=\'4\',estilo_id=\'1\',conteudo=\'@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@@@\' where id=4','2016-02-08 05:02:20'),(770,113,'bloco','UPDATE bloco set tipobloco_id=\'3\',estilo_id=\'1\',conteudo=\'   Id Comunidade                Nome                     Inicio     FimMandato Contato   \r\n----- ------------------------- ------------------------ ---------- ---------- ------------\r\n\' where id=3','2016-02-08 05:02:07'),(771,113,'bloco','UPDATE bloco set tipobloco_id=\'4\',estilo_id=\'1\',conteudo=\'@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@@@\' where id=4','2016-02-08 06:02:26'),(772,113,'bloco','UPDATE bloco set tipobloco_id=\'3\',estilo_id=\'1\',conteudo=\'   Id Comunidade                                         Nome                                                       Inicio     FimMandato Contato   \r\n----- -------------------------------------------------- ---------------------------------------------------------- ---------- ---------- ------------\r\n@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@@@\r\n\' where id=3','2016-02-08 06:02:40'),(773,113,'bloco','UPDATE bloco set tipobloco_id=\'2\',estilo_id=\'1\',conteudo=\'UNIVERSIDADE FEDERAL DO PIAUÍ                                                                                                                 Pág.: @@  \r\nNÚCLEO DE TECNOLOGIA DA INFORMAÇÃO                                                                                                    Data: @@/@@/@@@@\r\n------------------------------------------------------------------------------------------------------------------------------------------------------\r\n\' where id=2','2016-02-08 06:02:15'),(774,113,'bloco','UPDATE bloco set tipobloco_id=\'1\',estilo_id=\'1\',conteudo=\'********** Gerador de Relatórios - GERPHPPDF **********\r\n\' where id=1','2016-02-08 06:02:07'),(775,113,'bloco','UPDATE bloco set tipobloco_id=\'2\',estilo_id=\'1\',conteudo=\'UNIVERSIDADE FEDERAL DO PIAUÍ                                                                                                                 Pág.: @@  \r\nNÚCLEO DE TECNOLOGIA DA INFORMAÇÃO                                                                                                    Data: @@/@@/@@@@\r\n------------------------------------------------------------------------------------------------------------------------------------------------------\r\n\' where id=2','2016-02-08 06:02:12'),(776,113,'bloco','UPDATE bloco set tipobloco_id=\'3\',estilo_id=\'1\',conteudo=\'   Id Comunidade                                         Nome                                                       Inicio     FimMandato Contato   \r\n----- -------------------------------------------------- ---------------------------------------------------------- ---------- ---------- ------------\r\n@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@@@\r\n\' where id=3','2016-02-08 06:02:17'),(777,113,'bloco','UPDATE bloco set tipobloco_id=\'4\',estilo_id=\'1\',conteudo=\'@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@ @@@@@@@@@@@@\' where id=4','2016-02-08 06:02:23'),(778,113,'bloco','UPDATE bloco set tipobloco_id=\'3\',estilo_id=\'1\',conteudo=\'   Id Comunidade                                         Nome                                                       Inicio     FimMandato Contato   \r\n----- -------------------------------------------------- ---------------------------------------------------------- ---------- ---------- ------------\r\n\r\n\' where id=3','2016-02-14 04:02:06'),(779,113,'relatorio','UPDATE relatorio set identificador=\'rcadass01\',titulo=\'Cadastro de Associações - Geral\',descricao=\'Lista de Associações\',origem=\'cadastro\',funcao=\'asssociacao\',estilo_id=\'1\' where id=3','2016-02-14 04:02:21');

UNLOCK TABLES;

/*Table structure for table `linha` */

CREATE TABLE `linha` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `bloco_id` int(11) DEFAULT NULL COMMENT 'Bloco',
  `linha` int(11) DEFAULT NULL COMMENT 'NºLinha',
  `mascara` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Máscara',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `linha` */

LOCK TABLES `linha` WRITE;

UNLOCK TABLES;

/*Table structure for table `relatorio` */

CREATE TABLE `relatorio` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `identificador` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Identificador',
  `titulo` text COLLATE utf8_unicode_ci COMMENT 'Título',
  `descricao` text COLLATE utf8_unicode_ci COMMENT 'Descrição',
  `origem` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Origem',
  `funcao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Função',
  `estilo_id` int(11) DEFAULT NULL COMMENT 'Estilo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `relatorio` */

LOCK TABLES `relatorio` WRITE;

insert  into `relatorio`(`id`,`identificador`,`titulo`,`descricao`,`origem`,`funcao`,`estilo_id`) values (1,'rcadpes01','Cadastro de Pessoa','Cadastro de Pessoa','Cadastro','Pessoa',1),(2,'rcadpes02a','Cadastro de Pessoal - Geral AlfabÃ©tica','Cadastro Geral de Pessoal em Ordem AlfabÃ©tica - Emitido apenas para o Gestor de NegÃ³cios - Setor SDR/Projeto Mais Viver Semi-Ãrido - Governo do Estado do PiauÃ­','cadastro','pessoa',1),(3,'rcadass01','Cadastro de AssociaÃ§Ãµes - Geral','Lista de AssociaÃ§Ãµes','cadastro','asssociacao',1);

UNLOCK TABLES;

/*Table structure for table `tipobloco` */

CREATE TABLE `tipobloco` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Descrição',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tipobloco` */

LOCK TABLES `tipobloco` WRITE;

insert  into `tipobloco`(`id`,`descricao`) values (1,'CabeÃ§alho Inicial'),(2,'CabeÃ§alho de PÃ¡gina'),(3,'CabeÃ§alho de Detalhe'),(4,'Detalhe'),(5,'CabeÃ§alho de Grupo'),(6,'Grupo'),(7,'RodapÃ© de PÃ¡gina'),(8,'RodapÃ© Final');

UNLOCK TABLES;

/*Table structure for table `usuario` */

CREATE TABLE `usuario` (
  `id` smallint(6) NOT NULL COMMENT 'Id',
  `identificacao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Identificação',
  `senha` tinytext COLLATE utf8_unicode_ci COMMENT 'Senha',
  `pessoa_fisica_id` smallint(6) DEFAULT NULL COMMENT 'Pessoa Física ´Id',
  `departamento_id` smallint(6) DEFAULT NULL COMMENT 'Departamento - Id',
  `ativo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Ativo (S/N)?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `usuario` */

LOCK TABLES `usuario` WRITE;

insert  into `usuario`(`id`,`identificacao`,`senha`,`pessoa_fisica_id`,`departamento_id`,`ativo`) values (113,'lula','535517356110fdc4187ec29edf0761b8',7571,1,'S'),(114,'gerson','2e3746e131d178d04609038957bfa567',7225,2,'S'),(115,'sabino','c151a4b99c455a436fd3422aab6fd4b8',7846,1,'S');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
