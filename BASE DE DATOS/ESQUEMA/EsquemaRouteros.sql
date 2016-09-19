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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones`
--

LOCK TABLES `configuraciones` WRITE;
/*!40000 ALTER TABLE `configuraciones` DISABLE KEYS */;
INSERT INTO `configuraciones` VALUES (1,'LLAVE','$UjhY&743*#4#r1+u38s'),(2,'REINTENTOS_FALLIDOS_USUARIO','3');
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
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` int(11) NOT NULL,
  `submenu_id` int(11) DEFAULT NULL,
  `menu` varchar(45) COLLATE utf8_bin NOT NULL,
  `ruta_url` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estados_menu_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `estados_menu_idfk_idx` (`estados_menu_id`),
  KEY `submenu_idfk_idx` (`submenu_id`),
  CONSTRAINT `estados_menu_idfk` FOREIGN KEY (`estados_menu_id`) REFERENCES `estados_menu` (`estados_menu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `submenu_idfk` FOREIGN KEY (`submenu_id`) REFERENCES `menus` (`menu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Presenta los Menus que puede tener la aplicacion';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,1,NULL,'Inicio','configuracion_router.php',1,'2016-08-22 04:50:17',1),(2,1,NULL,'Usuarios',NULL,2,'2016-08-22 04:50:17',1),(3,1,NULL,'Perfiles',NULL,3,'2016-08-22 04:50:17',1),(4,1,NULL,'Auditoria',NULL,4,'2016-08-22 04:50:17',1),(5,1,NULL,'Salir','salir.php',7,'2016-08-22 04:50:17',1),(6,2,2,'Registar Usuarios','registra_usuarios_router.php',1,'2016-08-22 05:00:17',1),(7,2,2,'Consultar Usuarios','consulta_usuarios_router.php',2,'2016-08-22 05:00:17',1),(8,2,2,'Eliminar Usuarios','elimina_usuarios_router.php',3,'2016-08-22 05:00:17',1),(9,2,3,'Crear Perfiles','administra_perfiles_router.php',1,'2016-08-26 01:27:40',1),(10,2,4,'Auditoría HostPot','auditoria_eventos_router.php',1,'2016-08-30 23:30:30',1),(11,2,4,'Historial Eventos','historial_eventos_router.php',2,'2016-08-31 01:00:00',2),(12,2,3,'Eliminar Perfiles','elimina_perfiles_router.php',3,'2016-09-05 04:33:00',1),(13,2,3,'Consultar Perfiles','consulta_perfiles_router.php',2,'2016-09-05 04:33:00',1),(14,1,NULL,'Cambiar Clave','cambiar_clave.php',6,'2016-09-09 04:33:00',1),(15,2,4,'Auditoría Usuario','auditoria_eventos_usuario.php',2,'2016-09-16 23:00:00',1),(16,1,NULL,'Configuración','',5,'2016-09-18 23:00:00',1),(17,2,16,'Crear Router','crear_router.php',1,'2016-09-18 23:00:00',1),(18,2,16,'Actualizar Router','actualizar_router.php',2,'2016-09-18 23:00:00',1),(19,2,16,'Asignar Router a Usuario','asignar_router_a_usuarios.php',3,'2016-09-18 23:00:00',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus_perfil`
--

LOCK TABLES `menus_perfil` WRITE;
/*!40000 ALTER TABLE `menus_perfil` DISABLE KEYS */;
INSERT INTO `menus_perfil` VALUES (1,1,1,1,1),(2,2,1,1,0),(3,3,1,1,0),(4,4,1,1,0),(5,5,1,1,0),(6,6,1,1,0),(7,7,1,1,0),(8,8,1,1,0),(9,1,2,1,1),(10,2,2,1,0),(11,5,2,1,0),(12,7,2,1,0),(13,9,1,1,0),(14,10,1,1,0),(15,11,1,1,0),(16,12,1,1,0),(17,13,1,1,0),(18,13,2,1,0),(19,3,2,1,0),(20,14,1,1,0),(21,14,2,1,0),(22,15,1,1,0),(23,16,1,1,0),(24,17,1,1,0),(25,18,1,1,0),(26,19,1,1,0);
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
INSERT INTO `perfiles` VALUES (1,'Administrador','Perfil que Administra la Aplicación',1,'2016-08-18 03:56:14'),(2,'Usuario','Perfil usuario con permisos restringidos',1,'2016-08-18 03:56:55');
/*!40000 ALTER TABLE `perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurar_clave`
--

DROP TABLE IF EXISTS `restaurar_clave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurar_clave` (
  `restaurar_clave_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `usuario` varchar(45) COLLATE utf8_bin NOT NULL,
  `codigo` varchar(45) COLLATE utf8_bin NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`restaurar_clave_id`),
  UNIQUE KEY `usuario_id_UNIQUE` (`usuario_id`),
  KEY `fecha_idx` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurar_clave`
--

LOCK TABLES `restaurar_clave` WRITE;
/*!40000 ALTER TABLE `restaurar_clave` DISABLE KEYS */;
/*!40000 ALTER TABLE `restaurar_clave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `router_usuario`
--

DROP TABLE IF EXISTS `router_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `router_usuario` (
  `router_usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `router_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `principal` tinyint(4) NOT NULL DEFAULT '0',
  `estados_router_id` int(11) NOT NULL COMMENT 'Este campo se toma de los estados del Router.',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`router_usuario_id`),
  KEY `estado_fk_idx` (`estados_router_id`),
  KEY `usuario_fk_idx` (`usuario_id`),
  KEY `router_fk_idx` (`router_id`),
  CONSTRAINT `estado_fk` FOREIGN KEY (`estados_router_id`) REFERENCES `estados_router` (`estados_router_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `router_fk` FOREIGN KEY (`router_id`) REFERENCES `routers` (`router_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `usuario_fk` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table que presenta la información de la relacion entre los Routers que puede tener un usuario asignado.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `router_usuario`
--

LOCK TABLES `router_usuario` WRITE;
/*!40000 ALTER TABLE `router_usuario` DISABLE KEYS */;
INSERT INTO `router_usuario` VALUES (1,1,1,0,1,'2016-09-15 15:28:25'),(2,2,1,1,1,'2016-09-15 15:28:37'),(3,3,1,0,1,'2016-09-15 15:28:37'),(4,1,2,0,1,'2016-09-15 15:28:38'),(5,2,2,1,1,'2016-09-15 15:28:38');
/*!40000 ALTER TABLE `router_usuario` ENABLE KEYS */;
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
  `fechaactualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reintentos_conexion` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '3' COMMENT 'attempts: Connection attempt count',
  `retraso_conexion` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '3' COMMENT 'delay: Delay between connection attempts in seconds',
  `tiempo_maximo_conexion` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '3' COMMENT 'timeout: Connection attempt timeout and data read timeout',
  PRIMARY KEY (`router_id`),
  KEY `estados_router_idfk_idx` (`estados_router_id`),
  CONSTRAINT `estados_router_idfk` FOREIGN KEY (`estados_router_id`) REFERENCES `estados_router` (`estados_router_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routers`
--

LOCK TABLES `routers` WRITE;
/*!40000 ALTER TABLE `routers` DISABLE KEYS */;
INSERT INTO `routers` VALUES (1,'Rounter QA Pruebas','6.36','186.155.37.179','9090','3','654541',3,'2016-08-23 18:03:22','2016-09-19 03:48:05','3','3','3'),(2,'Router QA','6.36','186.155.37.179','8728','admin','sipltda2016',1,'2016-08-23 23:03:22','2016-09-19 00:49:29','3','3','3'),(3,'Rounter QA Pruebas','6.36','186.155.37.179','8728','prueba','pruebas123',1,'2016-08-23 23:03:22','2016-09-19 00:49:29','3','3','3');
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
  `intentos_fallidos` int(10) NOT NULL DEFAULT '0',
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
INSERT INTO `usuarios` VALUES (1,'ADMIN',NULL,'ADMINISTRADOR','ADMIN','PORTAL WEB','TELEFONO',1,'2016-08-22 04:30:18','󮼫AƬհfyϖ','corre@portalrouteros.com',1,0),(2,'USUARIO',NULL,'NOMBRE USUARIO','APELLIDO USUARIO','PORTAL ROUTEROS','TELEFONO',1,'2016-08-23 05:26:06','󮼫AƬհfyϖ','usuario@portalrouteros.com',2,0);
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

-- Dump completed on 2016-09-19  0:10:18



UPDATE usuarios SET intentos_fallidos = 0, estados_usuario_id = 1, clave = aes_encrypt('clave','$UjhY&743*#4#r1+u38s') WHERE usuario_id IN (1,2);
UPDATE routers SET usuario = 'admin', estados_router_id = 1, clave = '' WHERE router_id IN (1);
UPDATE routers SET usuario = 'admin', estados_router_id = 1, clave = 'sipltda2016' WHERE router_id IN (2);
UPDATE routers SET usuario = 'prueba', estados_router_id = 1, clave = 'pruebas123' WHERE router_id IN (3);

update router_usuario set principal = 0;
update router_usuario set principal = 1 where router_id = 2;
delete from routers where router_id > 3;