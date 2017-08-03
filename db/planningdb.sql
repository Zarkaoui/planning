-- MySQL dump 10.13  Distrib 5.6.34, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: db_planning
-- ------------------------------------------------------
-- Server version	5.6.34

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
-- Table structure for table `abs_categorie`
--

DROP TABLE IF EXISTS `abs_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_categorie` (
  `cat_id` int(2) NOT NULL AUTO_INCREMENT,
  `cat_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_categorie`
--

LOCK TABLES `abs_categorie` WRITE;
/*!40000 ALTER TABLE `abs_categorie` DISABLE KEYS */;
INSERT INTO `abs_categorie` VALUES (1,'Interne'),(2,'Externe');
/*!40000 ALTER TABLE `abs_categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_categorie2`
--

DROP TABLE IF EXISTS `abs_categorie2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_categorie2` (
  `cat2_id` int(2) NOT NULL AUTO_INCREMENT,
  `cat2_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cat2_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_categorie2`
--

LOCK TABLES `abs_categorie2` WRITE;
/*!40000 ALTER TABLE `abs_categorie2` DISABLE KEYS */;
INSERT INTO `abs_categorie2` VALUES (1,'Orange'),(2,'Neo Soft'),(3,'Sopra Steria'),(4,'Sofrecom');
/*!40000 ALTER TABLE `abs_categorie2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_conges`
--

DROP TABLE IF EXISTS `abs_conges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_conges` (
  `conges_id` int(5) NOT NULL AUTO_INCREMENT,
  `conges_employe` int(3) NOT NULL,
  `conges_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `conges_type` int(2) NOT NULL,
  `conges_demijournee` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `conges_debut` int(5) NOT NULL,
  `conges_periodicite` int(2) NOT NULL,
  `conges_periodicite_debut` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `conges_periodicite_fin` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `conges_commentaire` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `conges_login_saisie` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `conges_date_saisie` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`conges_id`)
) ENGINE=InnoDB AUTO_INCREMENT=376 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_conges`
--

LOCK TABLES `abs_conges` WRITE;
/*!40000 ALTER TABLE `abs_conges` DISABLE KEYS */;
INSERT INTO `abs_conges` VALUES (45,1,'24-07-2017',1,'0',0,0,'','','','administrateur','21-06-2017'),(46,1,'25-07-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(47,1,'26-07-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(48,1,'27-07-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(49,1,'28-07-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(50,1,'31-07-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(51,1,'01-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(52,1,'02-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(53,1,'03-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(54,1,'04-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(55,1,'07-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(56,1,'08-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(57,1,'09-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(58,1,'10-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(59,1,'11-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(60,1,'14-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(61,1,'16-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(62,1,'17-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(63,1,'18-08-2017',1,'0',45,0,'','','','administrateur','21-06-2017'),(64,7,'07-07-2017',1,'0',0,0,'0','0','','doc','21-06-2017'),(65,7,'10-07-2017',1,'0',64,0,'0','0','','doc','21-06-2017'),(66,7,'11-07-2017',1,'0',64,0,'0','0','','doc','21-06-2017'),(67,7,'12-07-2017',1,'0',64,0,'0','0','','doc','21-06-2017'),(68,7,'13-07-2017',1,'0',64,0,'0','0','','doc','21-06-2017'),(69,7,'17-07-2017',1,'0',64,0,'0','0','','doc','21-06-2017'),(105,7,'11-08-2017',1,'0',0,0,'','','Apache','administrateur','21-06-2017'),(106,7,'14-08-2017',1,'0',105,0,'','','Apache','administrateur','21-06-2017'),(107,7,'16-08-2017',1,'0',105,0,'','','Apache','administrateur','21-06-2017'),(108,7,'17-08-2017',1,'0',105,0,'','','Apache','administrateur','21-06-2017'),(109,7,'18-08-2017',1,'0',105,0,'','','Apache','administrateur','21-06-2017'),(110,7,'21-08-2017',1,'0',105,0,'','','Apache','administrateur','21-06-2017'),(111,7,'22-08-2017',1,'0',105,0,'','','Apache','administrateur','21-06-2017'),(112,7,'23-08-2017',1,'0',105,0,'','','Apache','administrateur','21-06-2017'),(113,7,'24-08-2017',1,'0',105,0,'','','Apache','administrateur','21-06-2017'),(114,7,'25-08-2017',1,'0',105,0,'','','Apache','administrateur','21-06-2017'),(115,7,'28-08-2017',1,'0',105,0,'','','Apache','administrateur','21-06-2017'),(116,7,'15-11-2017',1,'0',0,0,'0','0','','administrateur','21-06-2017'),(117,7,'16-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(118,7,'17-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(119,7,'20-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(120,7,'21-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(121,7,'22-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(122,7,'23-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(123,7,'24-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(124,7,'27-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(125,7,'28-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(126,7,'29-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(127,7,'30-11-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(128,7,'01-12-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(129,7,'04-12-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(130,7,'05-12-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(131,7,'06-12-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(132,7,'07-12-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(133,7,'08-12-2017',1,'0',116,0,'0','0','','administrateur','21-06-2017'),(134,7,'05-07-2017',4,'0',0,0,'0','0','Echange recherche ONF avec Arnaud Diquelou Orange ','administrateur','21-06-2017'),(135,8,'03-07-2017',1,'0',0,0,'0','0','','doc','21-06-2017'),(136,8,'04-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(137,8,'05-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(138,8,'06-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(139,8,'07-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(140,8,'10-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(141,8,'11-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(142,8,'12-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(143,8,'13-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(144,8,'17-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(145,8,'18-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(146,8,'19-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(147,8,'20-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(148,8,'21-07-2017',1,'0',135,0,'0','0','','doc','21-06-2017'),(149,8,'23-06-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(150,8,'04-08-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(151,8,'18-08-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(152,8,'01-09-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(153,2,'02-06-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(154,2,'16-06-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(155,2,'30-06-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(156,2,'26-06-2017',1,'0',0,0,'0','0','','doc','21-06-2017'),(157,2,'27-06-2017',1,'0',156,0,'0','0','','doc','21-06-2017'),(158,2,'28-06-2017',1,'0',156,0,'0','0','','doc','21-06-2017'),(159,2,'29-06-2017',1,'0',156,0,'0','0','','doc','21-06-2017'),(160,2,'03-07-2017',1,'0',0,0,'0','0','','doc','21-06-2017'),(161,2,'04-07-2017',1,'0',160,0,'0','0','','doc','21-06-2017'),(162,2,'05-07-2017',1,'0',160,0,'0','0','','doc','21-06-2017'),(163,2,'06-07-2017',1,'0',160,0,'0','0','','doc','21-06-2017'),(164,2,'07-07-2017',1,'0',160,0,'0','0','','doc','21-06-2017'),(165,2,'10-07-2017',1,'0',160,0,'0','0','','doc','21-06-2017'),(166,2,'11-07-2017',1,'0',160,0,'0','0','','doc','21-06-2017'),(167,2,'12-07-2017',1,'0',160,0,'0','0','','doc','21-06-2017'),(168,2,'13-07-2017',1,'0',160,0,'0','0','','doc','21-06-2017'),(169,2,'28-06-2018',10,'0',0,0,'0','0','','doc','21-06-2017'),(170,2,'11-08-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(171,2,'25-08-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(172,2,'08-09-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(173,2,'22-09-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(174,2,'06-10-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(175,2,'20-10-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(176,2,'03-11-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(177,2,'17-11-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(178,2,'01-12-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(179,2,'15-12-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(180,2,'29-12-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(181,2,'28-07-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(182,11,'06-07-2017',1,'0',0,0,'0','0','','doc','21-06-2017'),(183,11,'07-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(184,11,'10-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(185,11,'11-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(186,11,'12-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(187,11,'13-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(188,11,'17-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(189,11,'18-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(190,11,'19-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(191,11,'20-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(192,11,'21-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(193,11,'24-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(194,11,'25-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(195,11,'26-07-2017',1,'0',182,0,'0','0','','doc','21-06-2017'),(196,8,'15-09-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(197,8,'29-09-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(198,8,'13-10-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(199,8,'27-10-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(200,8,'10-11-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(201,8,'24-11-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(202,8,'08-12-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(203,8,'22-12-2017',10,'0',0,0,'0','0','','doc','21-06-2017'),(257,9,'03-07-2017',1,'0',0,0,'0','0','','doc','22-06-2017'),(258,9,'04-07-2017',1,'0',257,0,'0','0','','doc','22-06-2017'),(259,9,'05-07-2017',1,'0',257,0,'0','0','','doc','22-06-2017'),(260,9,'06-07-2017',1,'0',257,0,'0','0','','doc','22-06-2017'),(261,9,'07-07-2017',1,'0',257,0,'0','0','','doc','22-06-2017'),(262,3,'24-07-2017',1,'0',0,0,'0','0','','doc','22-06-2017'),(263,3,'25-07-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(264,3,'26-07-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(265,3,'27-07-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(266,3,'28-07-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(267,3,'31-07-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(268,3,'01-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(269,3,'02-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(270,3,'03-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(271,3,'04-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(272,3,'07-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(273,3,'08-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(274,3,'09-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(275,3,'10-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(276,3,'11-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(277,3,'14-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(278,3,'16-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(279,3,'17-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(280,3,'18-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(281,3,'21-08-2017',1,'0',262,0,'0','0','','doc','22-06-2017'),(282,3,'23-06-2017',1,'a',0,0,'0','0','','doc','22-06-2017'),(283,4,'22-06-2017',4,'0',0,0,'0','0','Docker','administrateur','22-06-2017'),(284,4,'23-06-2017',4,'0',283,0,'0','0','Docker','administrateur','22-06-2017'),(285,4,'26-06-2017',1,'0',0,0,'0','0','','administrateur','22-06-2017'),(286,4,'27-06-2017',1,'0',285,0,'0','0','','administrateur','22-06-2017'),(287,4,'28-06-2017',1,'0',285,0,'0','0','','administrateur','22-06-2017'),(288,4,'29-06-2017',1,'0',285,0,'0','0','','administrateur','22-06-2017'),(289,4,'30-06-2017',1,'0',285,0,'0','0','','administrateur','22-06-2017'),(290,4,'03-07-2017',1,'0',285,0,'0','0','','administrateur','22-06-2017'),(301,10,'31-07-2017',1,'0',0,0,'0','0','','doc','22-06-2017'),(302,10,'01-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(303,10,'02-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(304,10,'03-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(305,10,'04-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(306,10,'07-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(307,10,'08-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(308,10,'09-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(309,10,'10-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(310,10,'11-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(311,10,'14-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(312,10,'16-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(313,10,'17-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(314,10,'18-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(315,10,'21-08-2017',1,'0',301,0,'0','0','','doc','22-06-2017'),(326,6,'10-07-2017',1,'0',0,0,'0','0','','doc','22-06-2017'),(327,6,'11-07-2017',1,'0',326,0,'0','0','','doc','22-06-2017'),(328,6,'12-07-2017',1,'0',326,0,'0','0','','doc','22-06-2017'),(329,6,'13-07-2017',1,'0',326,0,'0','0','','doc','22-06-2017'),(330,6,'21-07-2017',1,'0',0,0,'0','0','','doc','22-06-2017'),(331,6,'24-07-2017',1,'0',330,0,'0','0','','doc','22-06-2017'),(332,6,'25-07-2017',1,'0',330,0,'0','0','','doc','22-06-2017'),(333,6,'26-07-2017',1,'0',330,0,'0','0','','doc','22-06-2017'),(334,6,'27-07-2017',1,'0',330,0,'0','0','','doc','22-06-2017'),(335,6,'28-07-2017',1,'0',330,0,'0','0','','doc','22-06-2017'),(336,6,'31-07-2017',1,'0',330,0,'0','0','','doc','22-06-2017'),(337,6,'01-08-2017',1,'0',330,0,'0','0','','doc','22-06-2017'),(338,6,'02-08-2017',1,'0',330,0,'0','0','','doc','22-06-2017'),(339,6,'03-08-2017',1,'0',330,0,'0','0','','doc','22-06-2017'),(340,6,'04-08-2017',1,'0',330,0,'0','0','','doc','22-06-2017'),(341,9,'30-06-2017',1,'0',0,0,'','','','doc','28-06-2017'),(352,4,'13-07-2017',1,'0',0,0,'','','','doc','04-07-2017'),(353,4,'17-07-2017',1,'0',352,0,'','','','doc','04-07-2017'),(354,4,'18-07-2017',1,'0',352,0,'','','','doc','04-07-2017'),(355,4,'19-07-2017',1,'0',352,0,'','','','doc','04-07-2017'),(356,4,'20-07-2017',1,'0',352,0,'','','','doc','04-07-2017'),(357,4,'21-07-2017',1,'0',352,0,'','','','doc','04-07-2017'),(358,4,'14-08-2017',1,'0',0,0,'','','','doc','04-07-2017'),(359,4,'16-08-2017',1,'0',358,0,'','','','doc','04-07-2017'),(360,4,'17-08-2017',1,'0',358,0,'','','','doc','04-07-2017'),(361,4,'18-08-2017',1,'0',358,0,'','','','doc','04-07-2017'),(362,4,'22-09-2017',1,'0',0,0,'','','','doc','05-07-2017'),(363,4,'25-09-2017',1,'0',362,0,'','','','doc','05-07-2017'),(364,4,'13-10-2017',1,'0',0,0,'','','','doc','05-07-2017'),(365,4,'16-10-2017',1,'0',364,0,'','','','doc','05-07-2017'),(366,4,'17-10-2017',1,'0',364,0,'','','','doc','05-07-2017'),(367,4,'18-10-2017',1,'0',364,0,'','','','doc','05-07-2017'),(368,4,'19-10-2017',1,'0',364,0,'','','','doc','05-07-2017'),(369,4,'20-10-2017',1,'0',364,0,'','','','doc','05-07-2017'),(370,4,'23-10-2017',1,'0',364,0,'','','','doc','05-07-2017'),(371,4,'24-10-2017',1,'0',364,0,'','','','doc','05-07-2017'),(372,4,'25-10-2017',1,'0',364,0,'','','','doc','05-07-2017'),(373,4,'26-10-2017',1,'0',364,0,'','','','doc','05-07-2017'),(374,4,'27-10-2017',1,'0',364,0,'','','','doc','05-07-2017'),(375,4,'30-10-2017',1,'0',364,0,'','','','doc','05-07-2017');
/*!40000 ALTER TABLE `abs_conges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_droits_ent`
--

DROP TABLE IF EXISTS `abs_droits_ent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_droits_ent` (
  `droits_ent_util` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `droits_ent_id` int(2) NOT NULL,
  PRIMARY KEY (`droits_ent_util`,`droits_ent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_droits_ent`
--

LOCK TABLES `abs_droits_ent` WRITE;
/*!40000 ALTER TABLE `abs_droits_ent` DISABLE KEYS */;
INSERT INTO `abs_droits_ent` VALUES ('doc',0),('doc',2),('doc',4),('helene',0),('ide',0);
/*!40000 ALTER TABLE `abs_droits_ent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_droits_sect`
--

DROP TABLE IF EXISTS `abs_droits_sect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_droits_sect` (
  `droits_sect_util` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `droits_sect_id` int(2) NOT NULL,
  PRIMARY KEY (`droits_sect_util`,`droits_sect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_droits_sect`
--

LOCK TABLES `abs_droits_sect` WRITE;
/*!40000 ALTER TABLE `abs_droits_sect` DISABLE KEYS */;
INSERT INTO `abs_droits_sect` VALUES ('doc',0),('doc',6),('helene',0),('ide',0);
/*!40000 ALTER TABLE `abs_droits_sect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_employe`
--

DROP TABLE IF EXISTS `abs_employe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_employe` (
  `emp_id` int(3) NOT NULL AUTO_INCREMENT,
  `emp_nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `emp_prenom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `emp_actif` int(1) NOT NULL,
  `emp_arrivee` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_statut` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `emp_samedi` int(1) NOT NULL,
  `emp_date_naissance` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_categorie1` int(2) NOT NULL,
  `emp_categorie2` int(2) NOT NULL,
  `emp_fonction` int(2) NOT NULL,
  `emp_secteur` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `emp_depart` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_ent` int(2) NOT NULL,
  `emp_nb_conges_cours` float NOT NULL,
  `emp_nb_conges_report` float NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_employe`
--

LOCK TABLES `abs_employe` WRITE;
/*!40000 ALTER TABLE `abs_employe` DISABLE KEYS */;
INSERT INTO `abs_employe` VALUES (1,'FERNANDES','Edgar',1,'00-00-0000','pt',0,'00-00-0000',2,3,2,'6','00-00-0000',2,365,0),(2,'AGULLO','Jean',1,'00-00-0000','pt',0,'00-00-0000',1,1,2,'6','00-00-0000',2,365,0),(3,'GOTTIS','Amedee',1,'00-00-0000','pt',0,'00-00-0000',1,1,2,'6','00-00-0000',2,365,0),(4,'MOINET','Laurent',1,'00-00-0000','pt',0,'00-00-0000',1,1,2,'6','00-00-0000',2,365,0),(5,'BODHUIN','Laurent',0,'00-00-0000','pt',0,'00-00-0000',1,1,2,'5','00-00-0000',3,365,0),(6,'DE VERBIGIER','Jerome',1,'00-00-0000','pt',0,'00-00-0000',2,2,2,'6','00-00-0000',2,365,0),(7,'DUBUCQ','Yannick',1,'00-00-0000','pt',0,'00-00-0000',1,1,1,'6','00-00-0000',2,365,0),(8,'GUY','Jean-Michel',1,'00-00-0000','pt',0,'00-00-0000',1,1,2,'6','00-00-0000',2,365,0),(9,'NICOLETTA','Pierre',1,'00-00-0000','pt',0,'00-00-0000',1,1,2,'6','00-00-0000',2,365,0),(10,'NIHUELLOU','Frederic',1,'00-00-0000','pt',0,'00-00-0000',2,2,2,'6','00-00-0000',2,365,0),(11,'SALAUN','Joel',1,'00-00-0000','pt',0,'00-00-0000',2,2,2,'6','00-00-0000',2,365,0),(12,'RADIGOIS','Helene',0,'00-00-0000','pt',0,'00-00-0000',1,1,1,'5','00-00-0000',3,365,0),(13,'ROUSSIN','Soizick',0,'00-00-0000','pt',0,'00-00-0000',1,1,2,'5','00-00-0000',3,365,0),(14,'LABIDI','Wassim',1,'00-00-0000','pt',0,'00-00-0000',1,4,2,'6','00-00-0000',4,365,0),(15,'BELMANAA','Hamed',1,'00-00-0000','pt',0,'00-00-0000',1,4,2,'6','00-00-0000',4,365,0);
/*!40000 ALTER TABLE `abs_employe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_entreprise`
--

DROP TABLE IF EXISTS `abs_entreprise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_entreprise` (
  `ent_id` int(2) NOT NULL AUTO_INCREMENT,
  `ent_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ent_addr1` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ent_addr2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ent_cp` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `ent_ville` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ent_tel` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ent_fax` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ent_comm` text COLLATE utf8_unicode_ci NOT NULL,
  `ent_parent` int(2) NOT NULL,
  PRIMARY KEY (`ent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_entreprise`
--

LOCK TABLES `abs_entreprise` WRITE;
/*!40000 ALTER TABLE `abs_entreprise` DISABLE KEYS */;
INSERT INTO `abs_entreprise` VALUES (1,'Orange','','','','Auncun','','','',0),(2,'DOC','','','','DOC','','','',1),(3,'SmartGIDF','','','','SmartGIDF','','','',1),(4,'Tunis','','','','Tunis','','','',1);
/*!40000 ALTER TABLE `abs_entreprise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_feries`
--

DROP TABLE IF EXISTS `abs_feries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_feries` (
  `feries_id` int(3) NOT NULL AUTO_INCREMENT,
  `feries_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `feries_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `feries_fixe` int(1) NOT NULL,
  PRIMARY KEY (`feries_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_feries`
--

LOCK TABLES `abs_feries` WRITE;
/*!40000 ALTER TABLE `abs_feries` DISABLE KEYS */;
INSERT INTO `abs_feries` VALUES (1,'1er Janvier','01-01-1900',1),(3,'Victoire 1945','08-05-1946',1),(4,'14 Juillet','14-07-1880',1),(5,'Assomption','15-08-1900',1),(6,'Toussaint','01-11-1900',1),(7,'Armistice 1918','11-11-1919',1),(15,'Fete du travail','01-05-2017',1),(17,'Jeudi Ascension','25-05-2017',0),(18,'Lundi Paques','17-04-2017',0),(20,'Lundi Pentecote','05-06-2017',0),(21,'Noel','25-12-2017',1);
/*!40000 ALTER TABLE `abs_feries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_fonction`
--

DROP TABLE IF EXISTS `abs_fonction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_fonction` (
  `fonct_id` int(2) NOT NULL AUTO_INCREMENT,
  `fonct_nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`fonct_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_fonction`
--

LOCK TABLES `abs_fonction` WRITE;
/*!40000 ALTER TABLE `abs_fonction` DISABLE KEYS */;
INSERT INTO `abs_fonction` VALUES (1,'Manager'),(2,'Expert');
/*!40000 ALTER TABLE `abs_fonction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_periodicite`
--

DROP TABLE IF EXISTS `abs_periodicite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_periodicite` (
  `periodicite_id` int(2) NOT NULL AUTO_INCREMENT,
  `periodicite_libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `periodicite_jours` int(3) NOT NULL,
  PRIMARY KEY (`periodicite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_periodicite`
--

LOCK TABLES `abs_periodicite` WRITE;
/*!40000 ALTER TABLE `abs_periodicite` DISABLE KEYS */;
INSERT INTO `abs_periodicite` VALUES (1,'Aucune',0),(2,'Journée',1),(3,'Semaine',5);
/*!40000 ALTER TABLE `abs_periodicite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_secteur`
--

DROP TABLE IF EXISTS `abs_secteur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_secteur` (
  `sect_id` int(2) NOT NULL AUTO_INCREMENT,
  `sect_nom` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `sect_intitule` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`sect_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_secteur`
--

LOCK TABLES `abs_secteur` WRITE;
/*!40000 ALTER TABLE `abs_secteur` DISABLE KEYS */;
INSERT INTO `abs_secteur` VALUES (5,'IDE','Identite'),(6,'B2R','B2R');
/*!40000 ALTER TABLE `abs_secteur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_type`
--

DROP TABLE IF EXISTS `abs_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_type` (
  `type_id` int(2) NOT NULL AUTO_INCREMENT,
  `type_nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type_couleur` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `type_commentaire` int(1) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_type`
--

LOCK TABLES `abs_type` WRITE;
/*!40000 ALTER TABLE `abs_type` DISABLE KEYS */;
INSERT INTO `abs_type` VALUES (1,'Conges','#FF0000',0),(4,'Formation','#A10684',1),(10,'Temps convenu','#FFFF00',0);
/*!40000 ALTER TABLE `abs_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abs_utilisateur`
--

DROP TABLE IF EXISTS `abs_utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abs_utilisateur` (
  `util_login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `util_password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `util_nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `util_prenom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `util_admin_secteur` int(1) NOT NULL,
  `util_admin_general` int(1) NOT NULL,
  `util_actif` int(1) NOT NULL,
  PRIMARY KEY (`util_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abs_utilisateur`
--

LOCK TABLES `abs_utilisateur` WRITE;
/*!40000 ALTER TABLE `abs_utilisateur` DISABLE KEYS */;
INSERT INTO `abs_utilisateur` VALUES ('administrateur','9d138837c9f8dc31296fb939bd8edafe586dac25','Admin','Planning',1,1,1),('doc','f7f029ecb98abe979074a3ab45b74dbd9af02d42','B2R','doc',1,0,1),('helene','cb4a0f2ddeb1db137d2178af0f7e4dc6479de99e','RADIGOIS','Helene',0,0,1),('ide','f0261b037b9ae5dac9dd83d540eac374734e5f0d','SSO','Identite',0,0,1);
/*!40000 ALTER TABLE `abs_utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-11  9:20:20
