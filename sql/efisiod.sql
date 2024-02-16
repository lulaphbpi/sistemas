/*
SQLyog Community v13.1.2 (64 bit)
MySQL - 10.1.40-MariaDB : Database - consnae
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`consnae` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `consnae`;

/*Table structure for table `agenda` */

DROP TABLE IF EXISTS `agenda`;

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `pessoaagenda_id` int(11) NOT NULL,
  `escala_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `agenda` */

/*Table structure for table `ciclomenstrual` */

DROP TABLE IF EXISTS `ciclomenstrual`;

CREATE TABLE `ciclomenstrual` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dias` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ciclomenstrual` */

insert  into `ciclomenstrual`(`id`,`descricao`,`dias`) values 
(0,'Não tem',NULL),
(1,'MenstruaÃ§Ã£o','2 a 7 dias'),
(2,'Fase folicular','8 dias'),
(3,'OvulaÃ§Ã£o','1 dia'),
(4,'Fase luteÃ­nica','14 dias');

/*Table structure for table `componentedeexame` */

DROP TABLE IF EXISTS `componentedeexame`;

CREATE TABLE `componentedeexame` (
  `id` int(11) NOT NULL,
  `exame_id` int(3) DEFAULT NULL,
  `descricao` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unidade` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referencia` text COLLATE utf8_unicode_ci,
  `metodo` text COLLATE utf8_unicode_ci,
  `notas` text COLLATE utf8_unicode_ci,
  `nvalor` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `componentedeexame` */

insert  into `componentedeexame`(`id`,`exame_id`,`descricao`,`unidade`,`referencia`,`metodo`,`notas`,`nvalor`) values 
(1,46,'','','Negativo para ovos, cistos ou larvas de parasitos na amostra examinada.','SedimentaÃ§Ã£o EspontÃ¢nea','','1'),
(2,47,'','','','MÃ©todo de Ritchie','','1'),
(3,48,'','','','Faust','','1'),
(4,49,'','','','Direto a fresco','','1'),
(6,50,'Albumina','g/dL','RecÃ©m-nascido (2 a 4 dias): 2,8 - 4,4 g/dL\r\n4 dias - 14 anos: 3,8 - 5,4 g/dL\r\nAdultos: 3,5 - 5,0 g/dL\r\n> 60 anos: 3,4 - 4,8g/dL','ReaÃ§Ã£o colorimÃ©trica - Verde de Bromocresol','','1'),
(7,12,'','','','','','1'),
(8,51,'Amilase','U/L','Soro ou plasma: 22 - 80 U/L','ReaÃ§Ã£o cinÃ©tica','','1'),
(9,52,'','mg/dL','Adultos e crianÃ§as acima de um mÃªs de idade: 0,2 - 1,0 mg/dL\r\nRN Prematuros: AtÃ© 24 horas: 1 - 8 mg/dL\r\n AtÃ© 48 horas: 6 - 12 mg/dL\r\n 3 - 5 dias: 10 - 14 mg/dL\r\nRN a termo: AtÃ© 24 horas: 2 - 6 mg/dL\r\n AtÃ© 48 horas: 6 - 12 mg/dL\r\n 3 - 5 dias: 4 - 8 mg/dL','ReaÃ§Ã£o colorimÃ©trica','','1'),
(10,14,'','mg/dL','Adultos: 8.5 - 10.4 mg/dL\r\nRecÃ©m nascidos: 7.8 - 11.2 mg/dL','ReaÃ§Ã£o colorimÃ©trica - Arsenaso III','','1'),
(11,52,'','mg/dL','Adultos e crianÃ§as acima de um mÃªs de idade: 0,2 - 1,0 mg/dL\r\nRN Prematuros: AtÃ© 24 horas: 1 - 8 mg/dL\r\n AtÃ© 48 horas: 6 - 12 mg/dL\r\n 3 - 5 dias: 10 - 14 mg/dL\r\nRN a termo: AtÃ© 24 horas: 2 - 6 mg/dL\r\n AtÃ© 48 horas: 6 - 12 mg/dL\r\n 3 - 5 dias: 4 - 8 mg/dL','ReaÃ§Ã£o colorimÃ©trica - Diazo','','1'),
(12,53,'','mg/dL','Adultos e crianÃ§as acima de um mÃªs de idade: 0.0 - 0.4 mg/dL.','ReaÃ§Ã£o colorimÃ©trica - Diazo','','1'),
(13,54,'Colesterol total','mg/dL','Colesterol desejado: < 200mg/dL\r\nLimiar: 200 a 239 mg/dL\r\nElevado: > 240 mg/dL','ReaÃ§Ã£o enzimÃ¡tica - Esterase-Peroxidase','','1'),
(14,30,'Crearance de creatinina','mg/dL','Soro= Homens: 0.7 - 1.4 mg/dL\r\n           Mulheres: 0.6 - 1.2 mg/dL\r\nUrina: 0.6 - 1.6 g/24 h (600 - 1600 mg/24 h)','ReaÃ§Ã£o cinÃ©tica - Picrato Alcalino','','1'),
(15,15,'','U/L','Masculinos: 24 a 195 U/L\r\nFemininos: 24 a 170 U/L\r\nRecÃ©m nascidos: 2 a 3 vezes os valores dos adultos.','ReaÃ§Ã£o enzimÃ¡tica','','1'),
(16,31,'','U/L','Homens      Mulheres\r\n 1 - 9 anos:        <350 U/L     < 350 U/L\r\n10 - 14 anos:     <275 U/L      < 280 U/L\r\n15 - 19 anos:     <155 U/L      < 150 U/L\r\n20 - 50 anos:   53 - 128U/L      42 - 98 U/L\r\n> 60 anos:       56 - 119U/L      53 -141 U/L','ReaÃ§Ã£o enzimÃ¡tica - p-Nitrofenilfosfato (IFCC)','','1'),
(17,28,'','g/dL','Soro: 6,5 â€“ 8,0 g/dL','ReaÃ§Ã£o colorimÃ©trica - Biureto','','1'),
(18,21,'','mg/dL','DesejÃ¡vel: < 150 mg/dL\r\nLimiar Alto: 150 a 200 mg/dL\r\nElevado: 200 a 499 mg/dL \r\nMuito elevado: > 500 mg/dL','ReaÃ§Ã£o enzimÃ¡tica','','1'),
(19,25,'Glicose','mg/dL','70 - 99 mg/dL','ReaÃ§Ã£o cinÃ©tica - Oxidase','','1'),
(21,26,'Glicemia - pÃ³s prandial','','','ReaÃ§Ã£o enzimÃ¡tica','','1'),
(22,39,'','','AMOSTRA REAGENTE\r\nAMOSTRA NÃƒO REAGENTE \r\nAMOSTRA COM RESULTADO NÃƒO DEFINIDO','ImunocromatogrÃ¡fico','','1'),
(23,38,'Amostra reagente','','','Imunocromatografia','','1'),
(24,29,'','mg/dL','Soro: 15 a 38 mg/dL','ReaÃ§Ã£o cinÃ©tica - Urease GluDH â€“ UV','','1'),
(25,1,'Eritrograma','','','','','0'),
(26,45,'Caracteres Gerais','','','','','0'),
(27,38,'Amostra nÃ£o reagente','','','ImunocromatogrÃ¡fico','','1'),
(29,10,'','','INTERPRETAÃ‡ÃƒO DE ACORDO COM O GRUPO SANGUÃNEO DO PACIENTE.','AglutinaÃ§Ã£o','','1'),
(30,22,'Colesterol HDL','mg/dL','Adulto:\r\nDesejÃ¡vel > 40,0 mg/dL','ColorimÃ©trico','','1'),
(31,36,'Beta-HCG','','','ImunocromatogrÃ¡fico','','1'),
(32,55,'','','','ELISA','','1'),
(33,56,'Chagas- IFI','','','ImunofluorescÃªncia Indireta','','1'),
(34,57,'Leishmaniose - Elisa v','','','ELISA','','1'),
(35,58,'','','','ImunofluorescÃªncia Indireta','','1'),
(36,38,'Amostra com resultado nÃ£o conclusivo','','','Imunocromatografia','','1'),
(37,1,'EritrÃ³citos','m/mmÂ³','4,0 a 5,0 m/mmÂ³','','','1'),
(38,1,'Hemoglobina','g/dL','11,5 a 16 g/dL','','','1'),
(39,45,'Aspecto','','LÃ­mpido','','','1'),
(40,45,'Cor','','Amarelo Claro','','','1'),
(41,45,'pH','','Ãcida: < 7,0 / Alcalina: >7,0','','','1'),
(42,45,'Densidade','','1.010 a 1.025','','','1'),
(43,1,'HematÃ³crito','%','35,0 a 46,0 %','','','1'),
(44,1,'VCM','fL','80,0 a 99,0 fL','','','1'),
(45,1,'HCM','pg','26,0 a 34,0 pg','','','1'),
(46,1,'RDW - Ãndice de Anisocitose','%','11,0 a 14,5 %','','','1'),
(47,1,'Leucograma','','','','','0'),
(48,1,'LeucÃ³citos','und/mmÂ³','3.500 a 11.000','','','1'),
(49,1,'Bastonetes','und/mmÂ³','0 a 5 %        0 a 500 /mmÂ³','','','1'),
(50,1,'Segmentados','und/mmÂ³','50 a 75 %      1.750 a 8.200 und/mmÂ³','','','1'),
(51,1,'EosinÃ³filos','und/mmÂ³','1 a 4 %         35 a 500 und/mmÂ³','','','1'),
(52,1,'BasÃ³filos','und/mmÂ³','0 a 2 %          0 a 200 mmÂ³','','','1'),
(53,1,'LinfÃ³citos','und/mmÂ³','20 a 45 %          700 a 4.500 und/mmÂ³','','','1'),
(54,1,'MonÃ³citos','und/mmÂ³','2 a 10 %          700 a 1.000 und/mmÂ³','','','1'),
(55,1,'Plaquetas','','','','','0'),
(56,1,'Plaquetas','und/mmÂ³','150.000 a 459,000 und/mmÂ³','','','1'),
(57,45,'AnÃ¡lise BioquÃ­mica','','','','','0'),
(58,45,'Glicose','','Negativo','','','1'),
(59,45,'Bilirrubina','','Negativo','','','1'),
(60,45,'Corpos cetÃ´nicos','','Negativo','','','1'),
(61,45,'Hemoglobina','','Negativo','','','1'),
(62,45,'ProteÃ­na','','Negativo','','','1'),
(63,45,'Nitrito','','Negativo','','','1'),
(64,45,'UrobilinogÃªnio','','Normal','','','1'),
(65,45,'Sedimentoscopia 400X','','','','','0'),
(66,45,'CÃ©lulas Epiteliais','','Raras','','','1'),
(67,45,'PiÃ³citos','','Raros','','','1'),
(68,45,'EritrÃ³citos','','Ausente','','','1'),
(69,45,'Cilindros','','Ausente','','','1'),
(70,45,'Cristais','','Ausente','','','1'),
(71,23,'Colesterol LDL','','','','','1');

/*Table structure for table `consulta` */

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

/*Data for the table `consulta` */

insert  into `consulta`(`id`,`cpfresponsavel`,`tipodeacompanhante_id`,`convenio_id`,`cartaosus`,`planodesaude_id`,`medico_id`,`dataregistro`,`dataconsulta`,`horario`,`consultapessoa_id`,`confirmado`,`realizado`) values 
(1,'',0,1,'',0,1,'2019-12-05','2019-12-05','12:00h',740,'N','N'),
(2,'',0,1,'',0,1,'2019-12-10','2019-12-10','12:00h',740,'N','N');

/*Table structure for table `convenio` */

DROP TABLE IF EXISTS `convenio`;

CREATE TABLE `convenio` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `convenio` */

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

/*Data for the table `diautil` */

insert  into `diautil`(`id`,`dia`,`turno_id`,`statusdiautil_id`,`descricao`,`limite`,`confirmados`,`efetivados`) values 
(1,'2019-12-13',1,1,'',3,0,0),
(2,'2019-12-16',1,1,'',3,0,0),
(3,'2019-12-18',1,1,'',3,0,0),
(4,'2019-12-20',1,1,'',3,0,0);

/*Table structure for table `escala` */

DROP TABLE IF EXISTS `escala`;

CREATE TABLE `escala` (
  `id` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `limite` tinyint(4) DEFAULT NULL,
  `quantidade` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `escala` */

insert  into `escala`(`id`,`data`,`limite`,`quantidade`) values 
(1,'2018-08-21',30,0);

/*Table structure for table `especialidade` */

DROP TABLE IF EXISTS `especialidade`;

CREATE TABLE `especialidade` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `especialidade` */

insert  into `especialidade`(`id`,`descricao`) values 
(1,'ClÃ­nica Geral'),
(2,'Cardiologia'),
(3,'Gastroenterologia');

/*Table structure for table `exame` */

DROP TABLE IF EXISTS `exame`;

CREATE TABLE `exame` (
  `id` int(11) NOT NULL,
  `sigla` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descricao` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipodeamostra_id` tinyint(4) DEFAULT NULL,
  `observacao` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `setor_id` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `exame` */

insert  into `exame`(`id`,`sigla`,`descricao`,`tipodeamostra_id`,`observacao`,`setor_id`) values 
(1,'HEM','HEMOGRAMA',3,'JEJUM DESEJÃVEL DE 4 HORAS',1),
(2,'TTP','TEMPO DE TROMBOPLASTINA PARCIAL',4,'TEMPO DE TROMBOPLASTINA PARCIAL ATIVADO - JEJUM DESEJÃVEL DE 4 HORAS',1),
(3,'TAP','TEMPO DE ATIVIDADE DE PROTROMBINA',4,'TEMPO DE ATIVIDADE DE PROTROMBINA - JEJUM DESEJÃVEL DE 4 HORAS ',1),
(4,'VHS','VELOCIDADE DE HEMOSSEDIMENTAÃ‡ÃƒO',3,'JEJUM NÃƒO OBRIGATÃ“RIO',1),
(6,'HTC','HEMATÃ“CRITO',3,'JEJUM DESEJÃVEL DE 4 HORAS',1),
(8,'PLA','PLAQUETAS - CONTAGEM E OBSERVA',3,'JEJUM DESEJÃVEL DE 4 HORAS',1),
(10,'GS-RH','GRUPO SANGUÃNEO + FATOR RH',3,'JEJUM NÃƒO OBRIGATÃ“RIO',1),
(14,'CA','CÃLCIO',1,'JEJUM DE 4 HORAS',1),
(15,'CPK N','CREATINOFOSFOQUINASE NAC',1,'JEJUM DE 4 HORAS',1),
(16,'CORT','CORTISOL',1,'',1),
(20,'LIPID','LIPIDOGRAMA COMPLETO',1,'JEJUM DE 12 HORAS',1),
(21,'TRI','TRIGLICERÃDEOS',1,'JEJUM DE 12 HORAS',1),
(22,'HDL','COLESTEROL HDL',1,'',1),
(23,'LDL','COLESTEROL LDL',1,'',1),
(24,'VLDL','COLESTEROL VLDL',1,'',1),
(25,'GLI','GLICEMIA - EM JEJUM',1,'JEJUM DE 8 A 14 HORAS OU CONFORME ORIENTAÃ‡ÃƒO MÃ‰DICA. ',1),
(26,'G-P','GLICEMIA - PÃ“S PRANDIAL',1,'JEJUM OBRIGATÃ“RIO DE 2 HORAS APÃ“S REFEIÃ‡ÃƒO OU CONFORME ORIENTAÃ‡ÃƒO',1),
(27,'HBA1C','HEMOGLOBINA GLICADA ',3,'JEJUM NÃƒO OBRIGATÃ“RIO',1),
(28,'PRO','PROTEÃNA TOTAL',1,'JEJUM NÃƒO OBRIGATÃ“RIO',1),
(29,'U','URÃ‰IA',1,'JEJUM DE 4 HORAS',1),
(30,'C-CRE','CLEARANCE DE CREATININA',15,'JEJUM DE 4 HORAS. URINA NÃƒO HÃ PREPARO ESPECÃFICO',1),
(31,'FAL','FOSFATASE ALCALINA',1,'JEJUM DE 4 HORAS',1),
(32,'LIPAS','LIPASE',1,'JEJUM NÃƒO OBRIGATÃ“RIO',1),
(33,'TGO','TRANSAMINASE OXALACÃ‰TICA',1,'JEJUM NÃƒO OBRIGATÃ“RIO',1),
(34,'TGP','TRANSAMINASE PIRÃšVICA',1,'JEJUM NÃƒO OBRIGATÃ“RIO',1),
(35,'PRO-C','PROTEÃNA C REATIVA',1,'JEJUM NÃƒO OBRIGATÃ“RIO',1),
(36,'B-HCG','BETA-HCG',1,'JEJUM NÃƒO OBRIGATÃ“RIO',1),
(38,'CHIK','CHIKUNGUNYA IgM',1,'',1),
(39,'DEN','DENGUE IgM/IgG',1,'',1),
(40,'HIV','HIV 1/2',1,'',1),
(41,'HCV','HCV',1,'',1),
(42,'HBV','HBV-HBsAg',1,'',1),
(43,'SIF','SÃFILIS',1,'',1),
(44,'ZIC','ZICA IgM/IgG',1,'',1),
(45,'EAS','EAS, ROTINA',2,'',1),
(46,'EPF','PARASITOLÃ“GICO',5,'',1),
(47,'EPF 2','PARASITOLÃ“GICO 2',5,'',1),
(48,'EPF','PARASITOLÃ“GICO 3',5,'',1),
(49,'EPF 4','PARASITOLÃ“GICO 4',5,'',1),
(50,'ALB','ALBUMINA',1,'JEJUM DE 4 HORAS',1),
(51,'AMI','AMILASE',1,'',1),
(52,'BIL','BILIRRUBINA TOTAL',1,'JEJUM DE 4 HORAS',1),
(53,'BIL-D','BILIRRUBINA DIRETA',1,'JEJUM DE 4 HORAS',1),
(54,'COL T','COLESTEROL TOTAL',1,'JEJUM DE 12 HORAS',1),
(55,'CHA 1','CHAGAS - ELISA',1,'',1),
(56,'CHA 2','CHAGAS - IFI',1,'',1),
(57,'LEI 1','LEISHMANIOSE - ELISA',1,'',1),
(58,'LEI 2','LEISHMANIOSE - IFI',1,'',1),
(59,'FOS','FÃ“SFORO ',1,'',1);

/*Table structure for table `examerequerido` */

DROP TABLE IF EXISTS `examerequerido`;

CREATE TABLE `examerequerido` (
  `id` int(11) NOT NULL,
  `requisicao_id` int(11) DEFAULT NULL,
  `exame_id` int(11) DEFAULT NULL,
  `convenio_id` tinyint(4) DEFAULT NULL,
  `datacoleta` date DEFAULT NULL,
  `horacoleta` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datacoletada` date DEFAULT NULL,
  `horacoletada` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dataresultado` date DEFAULT NULL,
  `horaresultado` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dataentrega` date DEFAULT NULL,
  `horaentrega` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `documentoentrega` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entregouguia` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statusexamerequerido_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `examerequerido` */

/*Table structure for table `grupo` */

DROP TABLE IF EXISTS `grupo`;

CREATE TABLE `grupo` (
  `id` tinyint(11) NOT NULL,
  `grupo` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `grupo` */

insert  into `grupo`(`id`,`grupo`,`descricao`) values 
(1,'adm','AdministraÃ§Ã£o'),
(2,'rec','RecepÃ§ao'),
(3,'enf','Enfermeira(o)'),
(4,'est','EstagiÃ¡ria(o)'),
(5,'coo','Coordenador(a)'),
(6,'med','Medica(o)');

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

/*Data for the table `hystory` */

insert  into `hystory`(`id`,`usuario_id`,`objeto`,`ssql`,`data`) values 
(1,1,'marcarConsulta-c1.php','insert into consulta values (\n		2,\n		\'\',\n		0,\n		1,\n		\'\',\n		0,\n		1,\n		\'2019-12-10\',\n		\'2019-12-10\',\n		\'12:00h\',\n		740,\n		\'N\',\n		\'N\')','2019-12-10 09:12:29'),
(2,1,'cadastrarDiautil-c1.php','update diautil set \r\n				turno_id=1,\r\n				statusdiautil_id=1,\r\n				descricao=\'\',\r\n				limite=11\r\n				where id=1','2019-12-11 04:12:32'),
(3,1,'cadastrarDiautil-c1.php','update diautil set \r\n				turno_id=1,\r\n				statusdiautil_id=1,\r\n				descricao=\'\',\r\n				limite=11\r\n				where id=1','2019-12-13 02:12:51'),
(4,1,'cadastrarDiautil-c1.php','delete from diautil where id=1','2019-12-13 02:12:59'),
(5,1,'cadastrarDiautil-c1.php','insert into diautil (\r\n					id, dia, turno_id, statusdiautil_id,\r\n					descricao, limite,\r\n					confirmados, efetivados) values (\r\n					1, \'2019-12-13\', 1, 1, \r\n					\'\', 15, \r\n					0, 0)','2019-12-13 02:12:06'),
(6,1,'cadastrarDiautil-c1.php','insert into diautil (\r\n					id, dia, turno_id, statusdiautil_id,\r\n					descricao, limite,\r\n					confirmados, efetivados) values (\r\n					2, \'2019-12-16\', 1, 1, \r\n					\'\', 15, \r\n					0, 0)','2019-12-13 02:12:39'),
(7,1,'cadastrarDiautil-c1.php','insert into diautil (\r\n					id, dia, turno_id, statusdiautil_id,\r\n					descricao, limite,\r\n					confirmados, efetivados) values (\r\n					3, \'2019-12-18\', 1, 1, \r\n					\'\', 15, \r\n					0, 0)','2019-12-13 02:12:56'),
(8,1,'cadastrarDiautil-c1.php','insert into diautil (\r\n					id, dia, turno_id, statusdiautil_id,\r\n					descricao, limite,\r\n					confirmados, efetivados) values (\r\n					4, \'2019-12-20\', 1, 1, \r\n					\'\', 15, \r\n					0, 0)','2019-12-13 02:12:13');

/*Table structure for table `itemexamerequerido` */

DROP TABLE IF EXISTS `itemexamerequerido`;

CREATE TABLE `itemexamerequerido` (
  `id` int(11) NOT NULL,
  `examerequerido_id` int(11) DEFAULT NULL,
  `componentedeexame_id` tinyint(11) DEFAULT NULL,
  `valor1` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valor2` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `icodigo` (`examerequerido_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `itemexamerequerido` */

/*Table structure for table `lista` */

DROP TABLE IF EXISTS `lista`;

CREATE TABLE `lista` (
  `id` int(11) DEFAULT NULL,
  `descricao` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `lista` */

/*Table structure for table `medico` */

DROP TABLE IF EXISTS `medico`;

CREATE TABLE `medico` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `crm` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `especialidade_id` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `medico` */

insert  into `medico`(`id`,`nome`,`crm`,`especialidade_id`) values 
(1,'Carlos Arakem','2020/Pi',1),
(2,'JosÃ© de Anchieta Moura Cortez','0001 / Pi',1);

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

/*Data for the table `pes001` */

insert  into `pes001`(`ord`,`pessoaid`,`natureza`,`cpf`,`nome`,`sexo`,`datanascimento`,`fone`,`cartaosus`,`email`,`nivel`,`identificacao`,`status`,`ativo`) values 
(1,268,'','77061950315','ANDRE LUIZ DOS REIS BARBOSA','M','1977-03-08',' ','','','','','Cadastrado',''),
(2,15,'','03865470335','KELSON LUIZ DA SILVA SALES','M','1989-06-27','3221-1565 ','','kelsonfisio@hotmail.com','','kelson','Cadastrado','S'),
(3,528,'','89787528372','LUIZ ALVES PORTELA JUNIOR','M','1981-12-28',' ','','','','','Cadastrado',''),
(4,103,'','91242797491','LUIZ ANTONIO DE OLIVEIRA','M','1973-07-12',' ','','','','','Cadastrado',''),
(5,740,'Paciente/Pardo','07100735343','LUIZ CARLOS JR','M','1995-12-19','32221122','','','/S','luiz','Cadastrado','S'),
(6,725,'','19130449472','LUIZ CARLOS MORAES DE BRITO','M','1959-06-11',' ','','','','','Cadastrado',''),
(7,707,'','10592261387','LUIZ DA COSTA DEUS','M','1958-08-16',' ','','','','','Cadastrado',''),
(8,450,'','04376179396','LUIZ GONZAGA ALVES DOS SANTOS FILHO','M','1990-04-23','995930121 99314765','','luizgonga@hotmail.com','','','Cadastrado',''),
(9,102,'','76303535372','LUIZ MACHADO MATOS JUNIOR','M','1975-04-10','86-9444-4748 ','','juniorjunior@ufpi.edu.br','','','Cadastrado',''),
(10,635,'','81885814372','LUIZA MARCIA CARVALHO DOS REIS','F','1978-03-29','94632057 99478068','','luizamcreis@hotmail.com','','','Cadastrado','');

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

/*Data for the table `pessoa` */

insert  into `pessoa`(`id`,`pessoa_id`,`naturezadapessoa_id`,`cartaosus`,`nomemae`,`cor_id`,`data`,`observacoes`) values 
(1,740,2,'','Silvana Alencar',5,'2019-12-04','');

/*Table structure for table `pessoaagenda` */

DROP TABLE IF EXISTS `pessoaagenda`;

CREATE TABLE `pessoaagenda` (
  `id` int(11) NOT NULL,
  `tipo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cnpjcpf` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `denominacaocomum` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` tinytext COLLATE utf8_unicode_ci,
  `fone` tinytext COLLATE utf8_unicode_ci,
  `email` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datanascimento` date DEFAULT NULL,
  `sexo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rg` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expedidorrg_id` tinyint(6) DEFAULT NULL,
  `formacaoprofissional_id` smallint(6) DEFAULT '0',
  `logradouro` tinytext COLLATE utf8_unicode_ci,
  `numero` int(11) DEFAULT NULL,
  `complemento` tinytext COLLATE utf8_unicode_ci,
  `bairro` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cep` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `municipio` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uf` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `naturezadapessoa_id` tinyint(4) DEFAULT NULL,
  `nomemae` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cor_id` tinyint(4) DEFAULT NULL,
  `convenio_id` tinyint(4) DEFAULT NULL,
  `cartaosus` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `planodesaude_id` tinyint(4) DEFAULT NULL,
  `cartaosaude` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipodevinculo_id` tinyint(4) DEFAULT NULL,
  `matriculainstitucional` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `agenda_id` int(11) DEFAULT NULL,
  `protocolo` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `pessoaagenda` */

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

/*Data for the table `requisicao` */

/*Table structure for table `setor` */

DROP TABLE IF EXISTS `setor`;

CREATE TABLE `setor` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `setor` */

insert  into `setor`(`id`,`descricao`) values 
(1,'BioquÃ­mica'),
(2,'Hematologia'),
(3,'Microbiologia'),
(4,'Parasitologia'),
(5,'Imunologia');

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

/*Table structure for table `statusexamerequerido` */

DROP TABLE IF EXISTS `statusexamerequerido`;

CREATE TABLE `statusexamerequerido` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `statusexamerequerido` */

insert  into `statusexamerequerido`(`id`,`descricao`) values 
(1,'Cadastrado'),
(2,'Aguardando LiberaÃ§Ã£o'),
(3,'Liberado');

/*Table structure for table `statusrequisicao` */

DROP TABLE IF EXISTS `statusrequisicao`;

CREATE TABLE `statusrequisicao` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `statusrequisicao` */

insert  into `statusrequisicao`(`id`,`descricao`) values 
(1,'Cadastrada'),
(2,'Aguardando LiberaÃ§Ã£o'),
(3,'Liberada'),
(4,'Finalizada'),
(5,'Cancelada');

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

/*Table structure for table `tipodeamostra` */

DROP TABLE IF EXISTS `tipodeamostra`;

CREATE TABLE `tipodeamostra` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tipodeamostra` */

insert  into `tipodeamostra`(`id`,`descricao`) values 
(1,'Soro'),
(2,'Urina'),
(3,'Sangue Total'),
(4,'Plasma'),
(5,'Fezes'),
(6,'SecreÃ§Ã£o'),
(7,'Escarro'),
(8,'Esperma'),
(9,'Swab '),
(10,'Urina de Jato MÃ©dio'),
(11,'Liquor'),
(12,'Raspado'),
(13,'Unha'),
(14,'PÃªlo'),
(15,'Sangue e Urina'),
(16,'Plasma e Soro');

/*Table structure for table `tipodeexame` */

DROP TABLE IF EXISTS `tipodeexame`;

CREATE TABLE `tipodeexame` (
  `id` int(11) NOT NULL,
  `sigla` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomepadrao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomecompleto` varchar(240) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tipodeexame` */

/*Table structure for table `turno` */

DROP TABLE IF EXISTS `turno`;

CREATE TABLE `turno` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `turno` */

insert  into `turno`(`id`,`descricao`) values 
(1,'ManhÃ£'),
(2,'Tarde'),
(3,'Noite');

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `pessoa_id` int(11) DEFAULT NULL,
  `grupo_id` tinyint(4) DEFAULT NULL,
  `ativo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `usuario` */

insert  into `usuario`(`id`,`pessoa_id`,`grupo_id`,`ativo`) values 
(1,740,2,'S');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
