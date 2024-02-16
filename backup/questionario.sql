-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: localhost    Database: questionario
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.40-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `hystory`
--

DROP TABLE IF EXISTS `hystory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hystory` (
  `id` double NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `objeto` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssql` blob,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hystory`
--

LOCK TABLES `hystory` WRITE;
/*!40000 ALTER TABLE `hystory` DISABLE KEYS */;
INSERT INTO `hystory` VALUES (180,1,'cadastrarTipoquestao-q1.php','insert into tipoquestao (\r\n					id, descricao, nalternativas) values (\r\n					5, \'Label\', \'N\')','2020-03-09 08:03:20'),(181,1,'cadastrarQuestionario-q1.php','insert into questionario (\n			id, titulo, sigla, descricao, interessado, nroquestoes, sistema) \n			values (1, \'Músculo-esquelética\', \'ME-APG\', \'Avaliação Postural Global\', \'efisio\', 7, \'efisio\') ','2020-03-09 08:03:37'),(182,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (1, 1, 5, \'VISTA ANTERIOR\', 1, 0) ','2020-03-09 09:03:10'),(183,1,'cadastrarQuestao-q1.php','update questao set \n			id_tipoquestao =    3,\n			enunciado =    \'Cabeça\',\n			ordem =    2,\n			nalternativas = 0\n			where id=1','2020-03-09 09:03:54'),(184,1,'cadastrarQuestao-q1.php','update questao set \n			id_tipoquestao =    5,\n			enunciado =    \'VISTA ANTERIOR\',\n			ordem =    1,\n			nalternativas = 0\n			where id=1','2020-03-09 09:03:46'),(185,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (2, 1, 3, \'Cabeça\', 2, 0) ','2020-03-09 09:03:11'),(186,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (3, 1, 3, \'Ombros\', 3, 0) ','2020-03-09 09:03:27'),(187,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (4, 1, 1, \'Observações\', 0, 0) ','2020-03-09 09:03:44'),(188,1,'cadastrarQuestao-q1.php','update questao set \n			id_tipoquestao =    1,\n			enunciado =    \'Observações\',\n			ordem =    4,\n			nalternativas = 0\n			where id=4','2020-03-09 09:03:01'),(189,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (5, 1, 5, \'VISTA POSTERIOR\', 5, 0) ','2020-03-09 09:03:27'),(190,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (6, 1, 3, \'Escápulas\', 6, 0) ','2020-03-09 09:03:48'),(191,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (7, 1, 3, \'Ombros\', 7, 0) ','2020-03-09 09:03:57'),(192,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (1, 1, 2, \'Inclinada à Direita\', 1) ','2020-03-09 09:03:12'),(193,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (2, 2, 2, \'Inclinada à Esquerda\', 2) ','2020-03-09 09:03:41'),(194,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (3, 3, 2, \'Rodada à Direita\', 3) ','2020-03-09 09:03:00'),(195,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (4, 4, 2, \'Rodada à Esquerda\', 4) ','2020-03-09 09:03:16'),(196,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (5, 5, 2, \'Normal\', 5) ','2020-03-09 09:03:28'),(197,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (6, 1, 3, \'Direito mais elevado\', 1) ','2020-03-09 09:03:28'),(198,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (7, 2, 3, \'Esquerdo mais elevado\', 2) ','2020-03-09 09:03:43'),(199,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (8, 3, 3, \'Nivelados\', 3) ','2020-03-09 09:03:54'),(200,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (9, 1, 6, \'Abduzidas\', 1) ','2020-03-09 09:03:17'),(201,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (10, 2, 6, \'Aduzidas\', 2) ','2020-03-09 09:03:26'),(202,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (11, 3, 6, \'Aladas\', 3) ','2020-03-09 09:03:35'),(203,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (12, 4, 6, \'Normal\', 4) ','2020-03-09 09:03:42'),(204,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (13, 1, 7, \'Rodados internamente\', 1) ','2020-03-09 09:03:08'),(205,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (14, 2, 7, \'Rodados externamente\', 2) ','2020-03-09 09:03:22'),(206,1,'cadastrarOpcao-q1.php','insert into opcao (\n			id, ordem, id_questao, descricao, valor) \n			values (15, 2, 7, \'Normal\', 3) ','2020-03-09 09:03:31'),(207,1,'cadastrarQuestionario-q1.php','insert into questionario (\n			id, titulo, sigla, descricao, interessado, nroquestoes, sistema) \n			values (2, \'Avaliação Fisioterapêutica Traumato-Ortopédica\', \'ME-AFTO\', \'FICHA DE AVALIAÇÃO FISIOTERAPÊUTICA TRAUMATO-ORTOPÉDICA\', \'NAE\', 5, \'efisio\') ','2020-03-13 02:03:04'),(208,1,'cadastrarQuestionario-q1.php','update questionario set \n			sigla =    \'ME-AFTO\',\n			titulo=   \'Traumato-Ortopédica\',\n			descricao= \'Avaliação Fisioterapêutica Traumato-Ortopédica\',\n			interessado = \'NAE\',\n			nroquestoes =    5\n			where id=2','2020-03-13 02:03:40'),(209,1,'cadastrarQuestionario-q1.php','update questionario set \n			sigla =    \'ME-AFTO\',\n			titulo=   \'Traumato-Ortopédica\',\n			descricao= \'Avaliação Fisioterapêutica Traumato-Ortopédica\',\n			interessado = \'efisio\',\n			nroquestoes =    5\n			where id=2','2020-03-13 02:03:06'),(210,1,'cadastrarQuestionario-q1.php','insert into questionario (\n			id, titulo, sigla, descricao, interessado, nroquestoes, sistema) \n			values (3, \'Neurofuncional\', \'NF-ANF\', \'Avaliacao Neurofuncional - Adulto\', \'efisio\', 5, \'efisio\') ','2020-03-13 02:03:23'),(211,1,'cadastrarQuestionario-q1.php','update questionario set \n			sigla =    \'ME-APG\',\n			titulo=   \'Músculo-esquelética\',\n			descricao= \'Avaliação Postural Global\',\n			interessado = \'Clínica Escola de Fisioterapia\',\n			nroquestoes =    7\n			where id=1','2020-03-13 02:03:08'),(212,1,'cadastrarQuestionario-q1.php','update questionario set \n			sigla =    \'ME-AFTO\',\n			titulo=   \'Traumato-Ortopédica\',\n			descricao= \'Avaliação Fisioterapêutica Traumato-Ortopédica\',\n			interessado = \'Clínica Escola de Fisioterapia\',\n			nroquestoes =    5\n			where id=2','2020-03-13 02:03:18'),(213,1,'cadastrarQuestionario-q1.php','update questionario set \n			sigla =    \'ME-AFTO\',\n			titulo=   \'Traumato-Ortopédica\',\n			descricao= \'Avaliação Fisioterapêutica Traumato-Ortopédica\',\n			interessado = \'Clínica Escola de Fisioterapia\',\n			nroquestoes =    5\n			where id=2','2020-03-13 02:03:21'),(214,1,'cadastrarQuestionario-q1.php','update questionario set \n			sigla =    \'NF-ANF\',\n			titulo=   \'Neurofuncional\',\n			descricao= \'Avaliacao Neurofuncional - Adulto\',\n			interessado = \'Clínica Escola de Fisioterapia\',\n			nroquestoes =    5\n			where id=3','2020-03-13 02:03:30'),(215,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (8, 2, 5, \'1. Dados Pessoais\', 1, 0) ','2020-03-13 02:03:12'),(216,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (9, 2, 1, \'Diagnostico Medico\', 2, 0) ','2020-03-13 02:03:43'),(217,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (10, 2, 1, \'Diagnostico Cinetico-Funcional\', 3, 0) ','2020-03-13 02:03:18'),(218,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (11, 2, 2, \'Realizou ou realiza tratamento Fisioterapeutico ?\', 4, 0) ','2020-03-13 03:03:02'),(219,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (12, 2, 5, \'2. Anamnese\', 5, 0) ','2020-03-13 03:03:25'),(220,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (13, 2, 1, \'Queixa Principal\', 6, 0) ','2020-03-13 03:03:46'),(221,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (14, 3, 1, \'1. Dados Pessoais\', 1, 0) ','2020-03-13 03:03:03'),(222,1,'cadastrarQuestao-q1.php','update questao set \n			id_tipoquestao =    5,\n			enunciado =    \'1. Dados Pessoais\',\n			ordem =    1,\n			nalternativas = 0\n			where id=14','2020-03-13 03:03:32'),(223,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (15, 3, 1, \'Medico\', 2, 0) ','2020-03-13 03:03:04'),(224,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (16, 3, 1, \'Diagnostico Fisioterapeutico\', 3, 0) ','2020-03-13 03:03:29'),(225,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (17, 3, 1, \'Diagnostico Medico\', 4, 0) ','2020-03-13 03:03:49'),(226,1,'cadastrarQuestao-q1.php','insert into questao (\n			id, id_questionario, id_tipoquestao, enunciado, ordem, nalternativas) \n			values (18, 3, 1, \'Data do diagnostico\', 5, 0) ','2020-03-13 03:03:18');
/*!40000 ALTER TABLE `hystory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opcao`
--

DROP TABLE IF EXISTS `opcao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opcao` (
  `id` int(11) NOT NULL,
  `ordem` tinyint(4) DEFAULT NULL,
  `id_questao` int(11) DEFAULT NULL,
  `descricao` text COLLATE utf8_unicode_ci,
  `valor` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcao`
--

LOCK TABLES `opcao` WRITE;
/*!40000 ALTER TABLE `opcao` DISABLE KEYS */;
INSERT INTO `opcao` VALUES (1,1,2,'Inclinada Ã  Direita','1'),(2,2,2,'Inclinada Ã  Esquerda','2'),(3,3,2,'Rodada Ã  Direita','3'),(4,4,2,'Rodada Ã  Esquerda','4'),(5,5,2,'Normal','5'),(6,1,3,'Direito mais elevado','1'),(7,2,3,'Esquerdo mais elevado','2'),(8,3,3,'Nivelados','3'),(9,1,6,'Abduzidas','1'),(10,2,6,'Aduzidas','2'),(11,3,6,'Aladas','3'),(12,4,6,'Normal','4'),(13,1,7,'Rodados internamente','1'),(14,2,7,'Rodados externamente','2'),(15,2,7,'Normal','3');
/*!40000 ALTER TABLE `opcao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questao`
--

DROP TABLE IF EXISTS `questao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questao` (
  `id` int(11) NOT NULL,
  `id_questionario` int(11) DEFAULT NULL,
  `id_tipoquestao` tinyint(4) DEFAULT NULL,
  `enunciado` text COLLATE utf8_unicode_ci,
  `ordem` int(11) DEFAULT NULL,
  `nalternativas` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questao`
--

LOCK TABLES `questao` WRITE;
/*!40000 ALTER TABLE `questao` DISABLE KEYS */;
INSERT INTO `questao` VALUES (1,1,5,'VISTA ANTERIOR',1,0),(2,1,3,'CabeÃ§a',2,0),(3,1,3,'Ombros',3,0),(4,1,1,'ObservaÃ§Ãµes',4,0),(5,1,5,'VISTA POSTERIOR',5,0),(6,1,3,'EscÃ¡pulas',6,0),(7,1,3,'Ombros',7,0),(8,2,5,'1. Dados Pessoais',1,0),(9,2,1,'Diagnostico Medico',2,0),(10,2,1,'Diagnostico Cinetico-Funcional',3,0),(11,2,2,'Realizou ou realiza tratamento Fisioterapeutico ?',4,0),(12,2,5,'2. Anamnese',5,0),(13,2,1,'Queixa Principal',6,0),(14,3,5,'1. Dados Pessoais',1,0),(15,3,1,'Medico',2,0),(16,3,1,'Diagnostico Fisioterapeutico',3,0),(17,3,1,'Diagnostico Medico',4,0),(18,3,1,'Data do diagnostico',5,0);
/*!40000 ALTER TABLE `questao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionario`
--

DROP TABLE IF EXISTS `questionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionario` (
  `id` int(11) NOT NULL,
  `titulo` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sigla` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8_unicode_ci,
  `interessado` text COLLATE utf8_unicode_ci,
  `nroquestoes` int(11) DEFAULT NULL,
  `sistema` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionario`
--

LOCK TABLES `questionario` WRITE;
/*!40000 ALTER TABLE `questionario` DISABLE KEYS */;
INSERT INTO `questionario` VALUES (1,'MÃºsculo-esquelÃ©tica','ME-APG','AvaliaÃ§Ã£o Postural Global','ClÃ­nica Escola de Fisioterapia',7,'efisio'),(2,'Traumato-OrtopÃ©dica','ME-AFTO','AvaliaÃ§Ã£o FisioterapÃªutica Traumato-OrtopÃ©dica','ClÃ­nica Escola de Fisioterapia',5,'efisio'),(3,'Neurofuncional','NF-ANF','Avaliacao Neurofuncional - Adulto','ClÃ­nica Escola de Fisioterapia',5,'efisio');
/*!40000 ALTER TABLE `questionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionarioaplicado`
--

DROP TABLE IF EXISTS `questionarioaplicado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionarioaplicado` (
  `id` int(11) NOT NULL,
  `id_questionario` int(11) DEFAULT NULL,
  `interessado` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_interessado` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionarioaplicado`
--

LOCK TABLES `questionarioaplicado` WRITE;
/*!40000 ALTER TABLE `questionarioaplicado` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionarioaplicado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionarioresposta`
--

DROP TABLE IF EXISTS `questionarioresposta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionarioresposta` (
  `id` int(11) NOT NULL,
  `id_questionarioaplicado` int(11) DEFAULT NULL,
  `id_questao` int(11) DEFAULT NULL,
  `id_opcao` int(11) DEFAULT NULL,
  `valor` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionarioresposta`
--

LOCK TABLES `questionarioresposta` WRITE;
/*!40000 ALTER TABLE `questionarioresposta` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionarioresposta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoquestao`
--

DROP TABLE IF EXISTS `tipoquestao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoquestao` (
  `id` tinyint(4) NOT NULL,
  `descricao` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nalternativas` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoquestao`
--

LOCK TABLES `tipoquestao` WRITE;
/*!40000 ALTER TABLE `tipoquestao` DISABLE KEYS */;
INSERT INTO `tipoquestao` VALUES (1,'Texto','N'),(2,'Sim/NÃ£o','N'),(3,'Escolha Simples','S'),(4,'MÃºltiplas Escolhas','S'),(5,'Label','N');
/*!40000 ALTER TABLE `tipoquestao` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-13 17:13:06
