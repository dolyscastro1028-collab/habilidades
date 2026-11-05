
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `clases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `curso_id` bigint unsigned NOT NULL,
  `estudiante_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clases_curso_id_estudiante_id_unique` (`curso_id`,`estudiante_id`),
  KEY `clases_estudiante_id_foreign` (`estudiante_id`),
  CONSTRAINT `clases_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `clases_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `clases` WRITE;
/*!40000 ALTER TABLE `clases` DISABLE KEYS */;
INSERT INTO `clases` VALUES (1,1,1,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(2,2,1,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(3,1,2,'2026-11-06 02:08:19','2026-11-06 02:08:19');
/*!40000 ALTER TABLE `clases` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cursos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duracion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `materia` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `portada` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profesor_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cursos_profesor_id_foreign` (`profesor_id`),
  CONSTRAINT `cursos_profesor_id_foreign` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cursos` WRITE;
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT INTO `cursos` VALUES (1,'Excel básico','20 horas','Ofimática',NULL,1,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(2,'Programación con Python','30 horas','Programación',NULL,1,'2026-11-06 02:08:19','2026-11-06 02:08:19');
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `estudiantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiantes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `identificacion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad` tinyint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `estudiantes_user_id_unique` (`user_id`),
  UNIQUE KEY `estudiantes_identificacion_unique` (`identificacion`),
  CONSTRAINT `estudiantes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `estudiantes` WRITE;
/*!40000 ALTER TABLE `estudiantes` DISABLE KEYS */;
INSERT INTO `estudiantes` VALUES (1,3,'1001001001',16,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(2,4,'1001001002',17,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(3,5,'1001001003',16,'2026-11-06 02:08:19','2026-11-06 02:08:19');
/*!40000 ALTER TABLE `estudiantes` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `lecciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecciones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `modulo_id` bigint unsigned NOT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` longtext COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_archivo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lecciones_modulo_id_foreign` (`modulo_id`),
  CONSTRAINT `lecciones_modulo_id_foreign` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `lecciones` WRITE;
/*!40000 ALTER TABLE `lecciones` DISABLE KEYS */;
INSERT INTO `lecciones` VALUES (1,1,'Introducción a las fórmulas','<p>En esta lección aprenderás: <strong>Introducción a las fórmulas</strong>.</p><p>Mira el video completo y luego marca la lección como completada.</p>','https://www.youtube.com/watch?v=9KiXJtMrmbc',NULL,1,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(2,1,'Funciones SUMA y PROMEDIO','<p>En esta lección aprenderás: <strong>Funciones SUMA y PROMEDIO</strong>.</p><p>Mira el video completo y luego marca la lección como completada.</p>','https://www.youtube.com/watch?v=LW0B8hgreeo',NULL,2,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(3,2,'Crear un gráfico de barras','<p>En esta lección aprenderás: <strong>Crear un gráfico de barras</strong>.</p><p>Mira el video completo y luego marca la lección como completada.</p>','https://www.youtube.com/watch?v=L5567d76dKk',NULL,1,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(4,2,'Personalizar gráficos','<p>En esta lección aprenderás: <strong>Personalizar gráficos</strong>.</p><p>Mira el video completo y luego marca la lección como completada.</p>','https://www.youtube.com/watch?v=ZN_IjSk0tw8',NULL,2,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(5,3,'Variables y tipos de datos','<p>En esta lección aprenderás: <strong>Variables y tipos de datos</strong>.</p><p>Mira el video completo y luego marca la lección como completada.</p>','https://www.youtube.com/watch?v=gF62RDGpW1k',NULL,1,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(6,3,'Entrada y salida','<p>En esta lección aprenderás: <strong>Entrada y salida</strong>.</p><p>Mira el video completo y luego marca la lección como completada.</p>','https://www.youtube.com/watch?v=EXno9AKikDo',NULL,2,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(7,4,'Condicionales if/else','<p>En esta lección aprenderás: <strong>Condicionales if/else</strong>.</p><p>Mira el video completo y luego marca la lección como completada.</p>','https://www.youtube.com/watch?v=iFBcCDDDsms',NULL,1,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(8,4,'Ciclos for y while','<p>En esta lección aprenderás: <strong>Ciclos for y while</strong>.</p><p>Mira el video completo y luego marca la lección como completada.</p>','https://www.youtube.com/watch?v=PWocHp9ZpEw',NULL,2,'2026-11-06 02:08:19','2026-11-06 02:08:19');
/*!40000 ALTER TABLE `lecciones` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_17_171245_create_estudiantes_table',1),(5,'2026_10_17_171257_create_profesors_table',1),(6,'2026_10_17_171306_create_cursos_table',1),(7,'2026_10_17_171323_create_clases_table',1),(8,'2026_10_17_175510_agregar_roles_y_usuarios',1),(9,'2026_11_05_000001_create_modulos_lecciones_progreso_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modulos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `curso_id` bigint unsigned NOT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modulos_curso_id_foreign` (`curso_id`),
  CONSTRAINT `modulos_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES (1,1,'Fórmulas',1,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(2,1,'Gráficos',2,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(3,2,'Fundamentos',1,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(4,2,'Estructuras de control',2,'2026-11-06 02:08:19','2026-11-06 02:08:19');
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `profesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profesores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `identificacion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad` tinyint unsigned NOT NULL,
  `materia` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profesores_user_id_unique` (`user_id`),
  UNIQUE KEY `profesores_identificacion_unique` (`identificacion`),
  CONSTRAINT `profesores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES (1,2,'10203040',35,'Informática','2026-11-06 02:08:19','2026-11-06 02:08:19');
/*!40000 ALTER TABLE `profesores` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `progreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `progreso` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `estudiante_id` bigint unsigned NOT NULL,
  `leccion_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `progreso_estudiante_id_leccion_id_unique` (`estudiante_id`,`leccion_id`),
  KEY `progreso_leccion_id_foreign` (`leccion_id`),
  CONSTRAINT `progreso_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `progreso_leccion_id_foreign` FOREIGN KEY (`leccion_id`) REFERENCES `lecciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `progreso` WRITE;
/*!40000 ALTER TABLE `progreso` DISABLE KEYS */;
INSERT INTO `progreso` VALUES (1,1,1,'2026-11-06 02:08:19','2026-11-06 02:08:19'),(2,1,2,'2026-11-06 02:08:19','2026-11-06 02:08:19');
/*!40000 ALTER TABLE `progreso` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','2026-11-06 02:08:18','2026-11-06 02:08:18'),(2,'profesor','2026-11-06 02:08:18','2026-11-06 02:08:18'),(3,'estudiante','2026-11-06 02:08:18','2026-11-06 02:08:18');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','admin@plataforma.com','2026-11-06 02:08:19','$2y$12$nJ.TXf1S3/sLEds8r7zRae4.ALqyuzdEtubD0GEoqMaD0Jbp1hVkW','jE0ykigRvw','2026-11-06 02:08:19','2026-11-06 02:08:19',1),(2,'Carlos Pérez','profesor@plataforma.com','2026-11-06 02:08:19','$2y$12$nJ.TXf1S3/sLEds8r7zRae4.ALqyuzdEtubD0GEoqMaD0Jbp1hVkW','B3ehjmSp5X','2026-11-06 02:08:19','2026-11-06 02:08:19',2),(3,'Laura Gómez','laura@plataforma.com','2026-11-06 02:08:19','$2y$12$nJ.TXf1S3/sLEds8r7zRae4.ALqyuzdEtubD0GEoqMaD0Jbp1hVkW','XuZXYoWiwy','2026-11-06 02:08:19','2026-11-06 02:08:19',3),(4,'Andrés Ruiz','andres@plataforma.com','2026-11-06 02:08:19','$2y$12$nJ.TXf1S3/sLEds8r7zRae4.ALqyuzdEtubD0GEoqMaD0Jbp1hVkW','Xij06b2SBS','2026-11-06 02:08:19','2026-11-06 02:08:19',3),(5,'Sofía Torres','sofia@plataforma.com','2026-11-06 02:08:19','$2y$12$nJ.TXf1S3/sLEds8r7zRae4.ALqyuzdEtubD0GEoqMaD0Jbp1hVkW','4NUurusbAZ','2026-11-06 02:08:19','2026-11-06 02:08:19',3);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

