CREATE DATABASE  IF NOT EXISTS `routeros` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `routeros`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: localhost    Database: routeros
-- ------------------------------------------------------
-- Server version	5.7.14-log

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
-- Table structure for table `configuraciones`
--

DROP TABLE IF EXISTS `configuraciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuraciones` (
  `configuracion_id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) COLLATE utf8_bin NOT NULL,
  `valor` varchar(45) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`configuracion_id`),
  UNIQUE KEY `descripcion_UNIQUE` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones`
--

LOCK TABLES `configuraciones` WRITE;
/*!40000 ALTER TABLE `configuraciones` DISABLE KEYS */;
INSERT INTO `configuraciones` VALUES (1,'LLAVE','$UjhY&743*/4#r1+u38s');
/*!40000 ALTER TABLE `configuraciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_menu`
--

DROP TABLE IF EXISTS `estados_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estados_menu` (
  `estados_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) NOT NULL,
  PRIMARY KEY (`estados_menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_menu`
--

LOCK TABLES `estados_menu` WRITE;
/*!40000 ALTER TABLE `estados_menu` DISABLE KEYS */;
INSERT INTO `estados_menu` VALUES (1,'ACTIVO'),(2,'INACTIVO'),(3,'BLOQUEADO');
/*!40000 ALTER TABLE `estados_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_perfil`
--

DROP TABLE IF EXISTS `estados_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estados_perfil` (
  `estados_perfil_id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) NOT NULL,
  PRIMARY KEY (`estados_perfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_perfil`
--

LOCK TABLES `estados_perfil` WRITE;
/*!40000 ALTER TABLE `estados_perfil` DISABLE KEYS */;
INSERT INTO `estados_perfil` VALUES (1,'ACTIVO'),(2,'INACTIVO'),(3,'BLOQUEADO');
/*!40000 ALTER TABLE `estados_perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_router`
--

DROP TABLE IF EXISTS `estados_router`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estados_router` (
  `estados_router_id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`estados_router_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_router`
--

LOCK TABLES `estados_router` WRITE;
/*!40000 ALTER TABLE `estados_router` DISABLE KEYS */;
INSERT INTO `estados_router` VALUES (1,'ACTIVO'),(2,'INACTIVO'),(3,'BLOQUEADO');
/*!40000 ALTER TABLE `estados_router` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_usuario`
--

DROP TABLE IF EXISTS `estados_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estados_usuario` (
  `estados_usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) NOT NULL,
  PRIMARY KEY (`estados_usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_usuario`
--

LOCK TABLES `estados_usuario` WRITE;
/*!40000 ALTER TABLE `estados_usuario` DISABLE KEYS */;
INSERT INTO `estados_usuario` VALUES (1,'ACTIVO'),(2,'INACTIVO'),(3,'BLOQUEADO');
/*!40000 ALTER TABLE `estados_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingresos` (
  `ingresos_id` bigint(20) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `usuario` varchar(45) COLLATE utf8_bin NOT NULL,
  `nombres` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `apellidos` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `fechaingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechamaximaingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ingresos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingresos`
--

LOCK TABLES `ingresos` WRITE;
/*!40000 ALTER TABLE `ingresos` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingresos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `submenu_id` int(11) DEFAULT NULL,
  `menu` varchar(45) COLLATE utf8_bin NOT NULL,
  `ruta_url` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estados_menu_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `estados_menu_idfk_idx` (`estados_menu_id`),
  KEY `submenu_id_idx` (`submenu_id`),
  CONSTRAINT `estados_menu_idfk` FOREIGN KEY (`estados_menu_id`) REFERENCES `estados_menu` (`estados_menu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `submenu_id` FOREIGN KEY (`submenu_id`) REFERENCES `menus` (`menu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Presenta los Menus que puede tener la aplicacion';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,1,NULL,'Inicio','configuracion_router.php',1,'2016-08-22 04:50:17',1),(2,1,NULL,'Usuarios',NULL,2,'2016-08-22 04:50:17',1),(3,1,NULL,'Routers',NULL,3,'2016-08-22 04:50:17',1),(4,1,NULL,'AdministraciÃ³n',NULL,4,'2016-08-22 04:50:17',1),(5,1,NULL,'Salir','salir.php',5,'2016-08-22 04:50:17',1),(6,2,2,'Registar Usuarios','registra_usuarios_router.php',1,'2016-08-22 05:00:17',1),(7,2,2,'Consultar Usuarios',NULL,2,'2016-08-22 05:00:17',1),(8,2,2,'Eliminar Usuarios','elimina_usuarios_router.php',3,'2016-08-22 05:00:17',1);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus_perfil`
--

DROP TABLE IF EXISTS `menus_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus_perfil` (
  `menus_perfil_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `estados_menu_id` int(11) NOT NULL,
  `principal` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menus_perfil_id`),
  KEY `perfil_id` (`perfil_id`),
  KEY `pagina_id` (`menu_id`),
  KEY `estados_menu_perfil_idfk_idx` (`estados_menu_id`),
  CONSTRAINT `estados_menu_perfil_idfk` FOREIGN KEY (`estados_menu_id`) REFERENCES `estados_menu` (`estados_menu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus_perfil`
--

LOCK TABLES `menus_perfil` WRITE;
/*!40000 ALTER TABLE `menus_perfil` DISABLE KEYS */;
INSERT INTO `menus_perfil` VALUES (1,1,1,1,1),(2,2,1,1,0),(3,3,1,1,0),(4,4,1,1,0),(5,5,1,1,0),(6,6,1,1,0),(7,7,1,1,0),(8,8,1,1,0),(9,1,2,1,0),(10,2,2,1,0),(11,5,2,1,0),(12,7,2,1,0);
/*!40000 ALTER TABLE `menus_perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paginas`
--

DROP TABLE IF EXISTS `paginas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paginas` (
  `pagina_id` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` int(11) NOT NULL,
  `descripcion_pagina` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `ruta_pagina` varchar(100) COLLATE utf8_bin NOT NULL,
  `estado` int(11) NOT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pagina_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paginas`
--

LOCK TABLES `paginas` WRITE;
/*!40000 ALTER TABLE `paginas` DISABLE KEYS */;
/*!40000 ALTER TABLE `paginas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfiles` (
  `perfil_id` int(10) NOT NULL AUTO_INCREMENT,
  `perfil` varchar(50) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estados_perfil_id` int(10) NOT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`perfil_id`),
  UNIQUE KEY `perfil_UNIQUE` (`perfil`),
  KEY `estados_perfil_fk1_idx` (`estados_perfil_id`),
  CONSTRAINT `estados_perfil_fk1` FOREIGN KEY (`estados_perfil_id`) REFERENCES `estados_perfil` (`estados_perfil_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfiles`
--

LOCK TABLES `perfiles` WRITE;
/*!40000 ALTER TABLE `perfiles` DISABLE KEYS */;
INSERT INTO `perfiles` VALUES (1,'Administrador','Perfil que Administra la AplicaciÃ³n',1,'2016-08-18 03:56:14'),(2,'Usuario','Perfil usuario con permisos restringidos',1,'2016-08-18 03:56:55');
/*!40000 ALTER TABLE `perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routers`
--

DROP TABLE IF EXISTS `routers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routers` (
  `router_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_bin NOT NULL,
  `version` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `puerto` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `usuario` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `clave` blob,
  `estados_router_id` int(11) NOT NULL,
  `fechacreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reintentos_conexion` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '3' COMMENT 'attempts: Connection attempt count',
  `retraso_conexion` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '3' COMMENT 'delay: Delay between connection attempts in seconds',
  `tiempo_maximo_conexion` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '3' COMMENT 'timeout: Connection attempt timeout and data read timeout',
  PRIMARY KEY (`router_id`),
  KEY `estados_router_idfk_idx` (`estados_router_id`),
  CONSTRAINT `estados_router_idfk` FOREIGN KEY (`estados_router_id`) REFERENCES `estados_router` (`estados_router_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routers`
--

LOCK TABLES `routers` WRITE;
/*!40000 ALTER TABLE `routers` DISABLE KEYS */;
INSERT INTO `routers` VALUES (1,'Rounter Development','6.36','192.168.56.2','8728','admin','ÖÔ7 ÅÏ®ð·µÆ',1,'2016-08-23 18:03:22','3','3','3');
/*!40000 ALTER TABLE `routers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `usuario_id` int(10) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `identificacion` varchar(45) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `estados_usuario_id` int(10) NOT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `clave` blob NOT NULL,
  `correo` varchar(100) NOT NULL,
  `perfil_id` int(10) NOT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `correo_UNIQUE` (`correo`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  KEY `fecha` (`fecharegistro`),
  KEY `estado_usuario_fk1_idx` (`estados_usuario_id`),
  CONSTRAINT `estado_usuario_fk1` FOREIGN KEY (`estados_usuario_id`) REFERENCES `estados_usuario` (`estados_usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'ADMIN',NULL,'ADMINISTRADOR','ADMIN','PORTAL WEB','TELEFONO',1,'2016-08-22 04:30:18','÷n<+A¦¬\íyðfy\ÎV','corre@portalrouteros.com',1),(2,'USUARIO',NULL,'NOMBRE USUARIO','APELLIDO USUARIO','PORTAL ROUTEROS','TELEFONO',1,'2016-08-23 05:26:06','÷n<+A¦¬\íyðfy\ÎV','usuario@portalrouteros.com',2);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'routeros'
--

--
-- Dumping routines for database 'routeros'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-25  0:13:13

 UPDATE usuarios SET clave = aes_encrypt('clave','$UjhY&743*#4#r1+u38s') WHERE usuario_id IN (1,2);