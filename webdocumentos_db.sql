-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 20, 2023 at 10:48 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdocumentos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjuntar_documentos`
--

CREATE TABLE `adjuntar_documentos` (
  `id` bigint UNSIGNED NOT NULL,
  `documento_id` bigint UNSIGNED NOT NULL,
  `archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adjuntar_documentos`
--

INSERT INTO `adjuntar_documentos` (`id`, `documento_id`, `archivo`, `tipo`, `ext`, `created_at`, `updated_at`) VALUES
(1, 1, '1699983229documento.docx', 'archivo', 'docx', '2023-11-14 17:33:49', '2023-11-14 17:33:49'),
(3, 1, '1699983430smartphone.png', 'imagen', 'png', '2023-11-14 17:37:10', '2023-11-14 17:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `configuracions`
--

CREATE TABLE `configuracions` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_sistema` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `web` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actividad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configuracions`
--

INSERT INTO `configuracions` (`id`, `nombre_sistema`, `alias`, `razon_social`, `ciudad`, `dir`, `fono`, `web`, `actividad`, `correo`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'WEBDOCUMENTOS', 'WEBDOCUMENTOS', 'WEBDOCUMENTOS', 'LA PAZ', 'LOS OLIVOS', '222222', NULL, 'ACTIVIDAD', 'webdocumentos@gmail.com', 'logo.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dependencias`
--

CREATE TABLE `dependencias` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dependencias`
--

INSERT INTO `dependencias` (`id`, `nombre`, `descripcion`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'DEPENDENCIA #1', 'DESC. DEPENDENCIA 1', '2023-11-13', '2023-11-13 19:09:33', '2023-11-13 19:09:33'),
(2, 'DEPENDENCIA #2', '', '2023-11-13', '2023-11-13 19:10:25', '2023-11-13 19:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `devolucion_documentos`
--

CREATE TABLE `devolucion_documentos` (
  `id` bigint UNSIGNED NOT NULL,
  `documento_id` bigint UNSIGNED NOT NULL,
  `funcionario_id` bigint UNSIGNED NOT NULL,
  `cantidad_documentos` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `devolucion_documentos`
--

INSERT INTO `devolucion_documentos` (`id`, `documento_id`, `funcionario_id`, `cantidad_documentos`, `fecha`, `hora`, `descripcion`, `observacion`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, '2023-11-16', '09:41:00', 'DESC. DEVOLUCION #1', 'OBS. DEVOLUCION #1', '2023-11-16', '2023-11-16 13:43:49', '2023-11-16 13:43:49'),
(2, 2, 2, 4, '2023-11-16', '09:46:00', 'DESC. DEVOLUCION #2', 'OBS. DEVOLUCION #2', '2023-11-16', '2023-11-16 13:46:37', '2023-11-16 13:46:37'),
(3, 1, 2, 4, '2023-11-16', '09:47:00', 'DESC. DEVOLUCION PRESTAMO #3', 'OBS. DEVOLUCION PRESTAMO #3', '2023-11-16', '2023-11-16 13:48:13', '2023-11-16 13:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `documentos`
--

CREATE TABLE `documentos` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dependencia_id` bigint UNSIGNED NOT NULL,
  `funcionario_id` bigint UNSIGNED NOT NULL,
  `oficina_id` bigint UNSIGNED NOT NULL,
  `estante_id` bigint UNSIGNED NOT NULL,
  `nivel` int NOT NULL,
  `division` int NOT NULL,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documentos`
--

INSERT INTO `documentos` (`id`, `codigo`, `descripcion`, `dependencia_id`, `funcionario_id`, `oficina_id`, `estante_id`, `nivel`, `division`, `estado`, `fecha`, `hora`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'DOC-1', 'DESCRIPCIÓN DOCUMENTO #1', 1, 1, 1, 1, 1, 1, 'EN ARCHIVO', '2023-11-14', '12:44:00', '2023-11-14', '2023-11-14 16:44:38', '2023-11-16 13:48:13'),
(2, 'DOC-2', 'DOCUMENTO #2', 2, 1, 2, 1, 1, 2, 'EN ARCHIVO', '2023-11-15', '11:34:00', '2023-11-15', '2023-11-15 15:35:11', '2023-11-16 13:46:37'),
(3, 'DOC-3', 'DOCUMENTO #3', 2, 1, 2, 2, 1, 1, 'EN ARCHIVO', '2023-11-15', '12:06:00', '2023-11-15', '2023-11-15 16:06:52', '2023-11-15 19:29:33');

-- --------------------------------------------------------

--
-- Table structure for table `estantes`
--

CREATE TABLE `estantes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel` int NOT NULL,
  `division` int NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `estantes`
--

INSERT INTO `estantes` (`id`, `nombre`, `nivel`, `division`, `descripcion`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'ESTANTE #1', 3, 5, 'DESC. ESTANTE 1', '2023-11-14', '2023-11-14 15:53:40', '2023-11-14 15:53:40'),
(2, 'ESTANTE #2', 3, 4, '', '2023-11-14', '2023-11-14 15:53:51', '2023-11-14 15:53:51');

-- --------------------------------------------------------

--
-- Table structure for table `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gestion_ingreso` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_ingreso` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_baja` date NOT NULL,
  `fecha_item` date NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `user_id`, `codigo`, `gestion_ingreso`, `tipo_ingreso`, `fecha_baja`, `fecha_item`, `descripcion`, `observaciones`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 3, 'F001', '2023', 'NORMAL', '2024-06-01', '2023-01-01', 'DESCRIPCION FUNCIONARIO', 'OBSERVACIONES FUNCIONARIO', '2023-11-13', '2023-11-13 19:16:54', '2023-11-13 19:16:54'),
(2, 4, 'F002', '2023', 'NORMAL', '2025-05-04', '2023-01-01', '', '', '2023-11-15', '2023-11-15 16:11:32', '2023-11-15 16:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `historial_accions`
--

CREATE TABLE `historial_accions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `accion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datos_original` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `datos_nuevo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `modulo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `historial_accions`
--

INSERT INTO `historial_accions` (`id`, `user_id`, `accion`, `descripcion`, `datos_original`, `datos_nuevo`, `modulo`, `fecha`, `hora`, `created_at`, `updated_at`) VALUES
(1, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA RESERVA DE DOCUMENTO', 'created_at: 2023-11-16 09:17:14<br/>descripcion: RESERVA #1<br/>documento_id: 1<br/>estado: <br/>fecha: 2023-11-16<br/>fecha_registro: 2023-11-16<br/>funcionario_id: 1<br/>hora: 09:16<br/>id: 1<br/>observacion: OBS. RESERVA #1<br/>updated_at: 2023-11-16 09:17:14<br/>', NULL, 'RESERVA DE DOCUMENTOS', '2023-11-16', '09:17:14', '2023-11-16 13:17:14', '2023-11-16 13:17:14'),
(2, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA RESERVA DE DOCUMENTO', 'created_at: 2023-11-16 09:17:42<br/>descripcion: DESC. RESERVA #2<br/>documento_id: 2<br/>estado: <br/>fecha: 2023-11-16<br/>fecha_registro: 2023-11-16<br/>funcionario_id: 2<br/>hora: 09:17<br/>id: 2<br/>observacion: OBS. RESERVA #2<br/>updated_at: 2023-11-16 09:17:42<br/>', NULL, 'RESERVA DE DOCUMENTOS', '2023-11-16', '09:17:42', '2023-11-16 13:17:42', '2023-11-16 13:17:42'),
(3, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRESTAMO DE DOCUMENTO', 'cantidad_documentos: 3<br/>created_at: 2023-11-16 09:22:54<br/>dependencia_id: 2<br/>descripcion: DESC. PRESTAMO #1<br/>documento_id: 1<br/>estado: <br/>fecha: 2023-11-16<br/>fecha_registro: 2023-11-16<br/>funcionario_id: 1<br/>hora: 09:19<br/>id: 1<br/>observacion: OBS. PRESTAMO #1<br/>tipo_documento: TIPO #1<br/>updated_at: 2023-11-16 09:22:54<br/>', NULL, 'PRESTAMO DE DOCUMENTOS', '2023-11-16', '09:22:54', '2023-11-16 13:22:54', '2023-11-16 13:22:54'),
(4, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA DEVOLUCIÓN DE DOCUMENTO', 'cantidad_documentos: 3<br/>created_at: 2023-11-16 09:43:49<br/>descripcion: DESC. DEVOLUCION #1<br/>documento_id: 1<br/>fecha: 2023-11-16<br/>fecha_registro: 2023-11-16<br/>funcionario_id: 1<br/>hora: 09:41<br/>id: 1<br/>observacion: OBS. DEVOLUCION #1<br/>updated_at: 2023-11-16 09:43:49<br/>', NULL, 'DEVOLUCIÓN DE DOCUMENTOS', '2023-11-16', '09:43:49', '2023-11-16 13:43:49', '2023-11-16 13:43:49'),
(5, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRESTAMO DE DOCUMENTO', 'cantidad_documentos: 4<br/>created_at: 2023-11-16 09:45:47<br/>dependencia_id: 2<br/>descripcion: DESC. PRESTAMO #2<br/>documento_id: 2<br/>estado: <br/>fecha: 2023-11-16<br/>fecha_registro: 2023-11-16<br/>funcionario_id: 2<br/>hora: 09:45<br/>id: 2<br/>observacion: OBS. PRESTAMO #2<br/>tipo_documento: TIPO #2<br/>updated_at: 2023-11-16 09:45:47<br/>', NULL, 'PRESTAMO DE DOCUMENTOS', '2023-11-16', '09:45:47', '2023-11-16 13:45:47', '2023-11-16 13:45:47'),
(6, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA DEVOLUCIÓN DE DOCUMENTO', 'cantidad_documentos: 4<br/>created_at: 2023-11-16 09:46:37<br/>descripcion: DESC. DEVOLUCION #2<br/>documento_id: 2<br/>fecha: 2023-11-16<br/>fecha_registro: 2023-11-16<br/>funcionario_id: 2<br/>hora: 09:46<br/>id: 2<br/>observacion: OBS. DEVOLUCION #2<br/>updated_at: 2023-11-16 09:46:37<br/>', NULL, 'DEVOLUCIÓN DE DOCUMENTOS', '2023-11-16', '09:46:37', '2023-11-16 13:46:37', '2023-11-16 13:46:37'),
(7, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UN PRESTAMO DE DOCUMENTO', 'cantidad_documentos: 4<br/>created_at: 2023-11-16 09:47:27<br/>dependencia_id: 2<br/>descripcion: DESC. PRESTAMO #3. PRESTAMO DIRECTO<br/>documento_id: 1<br/>estado: <br/>fecha: 2023-11-16<br/>fecha_registro: 2023-11-16<br/>funcionario_id: 2<br/>hora: 09:46<br/>id: 3<br/>observacion: OBS. PRESTAMO #3. PRESTAMO DIRECTO<br/>tipo_documento: TIPO #2<br/>updated_at: 2023-11-16 09:47:27<br/>', NULL, 'PRESTAMO DE DOCUMENTOS', '2023-11-16', '09:47:27', '2023-11-16 13:47:27', '2023-11-16 13:47:27'),
(8, 1, 'CREACIÓN', 'EL USUARIO  REGISTRO UNA DEVOLUCIÓN DE DOCUMENTO', 'cantidad_documentos: 4<br/>created_at: 2023-11-16 09:48:13<br/>descripcion: DESC. DEVOLUCION PRESTAMO #3<br/>documento_id: 1<br/>fecha: 2023-11-16<br/>fecha_registro: 2023-11-16<br/>funcionario_id: 2<br/>hora: 09:47<br/>id: 3<br/>observacion: OBS. DEVOLUCION PRESTAMO #3<br/>updated_at: 2023-11-16 09:48:13<br/>', NULL, 'DEVOLUCIÓN DE DOCUMENTOS', '2023-11-16', '09:48:13', '2023-11-16 13:48:13', '2023-11-16 13:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000002_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2022_10_13_132625_create_configuracions_table', 1),
(4, '2023_08_26_190801_create_historial_accions_table', 1),
(5, '2023_11_13_123333_create_funcionarios_table', 2),
(6, '2023_11_13_123459_create_dependencias_table', 2),
(7, '2023_11_13_123523_create_oficinas_table', 2),
(8, '2023_11_13_123535_create_estantes_table', 2),
(9, '2023_11_13_125115_create_documentos_table', 2),
(10, '2023_11_13_125628_create_reserva_documentos_table', 2),
(11, '2023_11_13_125647_create_prestamo_documentos_table', 2),
(12, '2023_11_13_125705_create_devolucion_documentos_table', 2),
(13, '2023_11_13_130530_create_adjuntar_documentos_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `oficinas`
--

CREATE TABLE `oficinas` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oficinas`
--

INSERT INTO `oficinas` (`id`, `nombre`, `descripcion`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'OFICINA #1', 'DESC. OFICINA 1', '2023-11-13', '2023-11-13 19:29:57', '2023-11-13 19:29:57'),
(2, 'OFICINA #2', '', '2023-11-13', '2023-11-13 19:30:02', '2023-11-13 19:30:02');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prestamo_documentos`
--

CREATE TABLE `prestamo_documentos` (
  `id` bigint UNSIGNED NOT NULL,
  `documento_id` bigint UNSIGNED NOT NULL,
  `funcionario_id` bigint UNSIGNED NOT NULL,
  `tipo_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad_documentos` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `dependencia_id` bigint UNSIGNED NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prestamo_documentos`
--

INSERT INTO `prestamo_documentos` (`id`, `documento_id`, `funcionario_id`, `tipo_documento`, `cantidad_documentos`, `fecha`, `hora`, `dependencia_id`, `descripcion`, `observacion`, `fecha_registro`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'TIPO #1', 3, '2023-11-16', '09:19:00', 2, 'DESC. PRESTAMO #1', 'OBS. PRESTAMO #1', '2023-11-16', 0, '2023-11-16 13:22:54', '2023-11-16 13:43:49'),
(2, 2, 2, 'TIPO #2', 4, '2023-11-16', '09:45:00', 2, 'DESC. PRESTAMO #2', 'OBS. PRESTAMO #2', '2023-11-16', 0, '2023-11-16 13:45:47', '2023-11-16 13:46:37'),
(3, 1, 2, 'TIPO #2', 4, '2023-11-16', '09:46:00', 2, 'DESC. PRESTAMO #3. PRESTAMO DIRECTO', 'OBS. PRESTAMO #3. PRESTAMO DIRECTO', '2023-11-16', 0, '2023-11-16 13:47:27', '2023-11-16 13:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `reserva_documentos`
--

CREATE TABLE `reserva_documentos` (
  `id` bigint UNSIGNED NOT NULL,
  `documento_id` bigint UNSIGNED NOT NULL,
  `funcionario_id` bigint UNSIGNED NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `fecha_registro` date NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reserva_documentos`
--

INSERT INTO `reserva_documentos` (`id`, `documento_id`, `funcionario_id`, `descripcion`, `observacion`, `fecha`, `hora`, `fecha_registro`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'RESERVA #1', 'OBS. RESERVA #1', '2023-11-16', '09:16:00', '2023-11-16', 0, '2023-11-16 13:17:14', '2023-11-16 13:22:54'),
(2, 2, 2, 'DESC. RESERVA #2', 'OBS. RESERVA #2', '2023-11-16', '09:17:00', '2023-11-16', 0, '2023-11-16 13:17:42', '2023-11-16 13:45:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `materno` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` enum('ADMINISTRADOR','OPERADOR','FUNCIONARIO') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `acceso` int NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usuario`, `nombre`, `paterno`, `materno`, `ci`, `ci_exp`, `dir`, `correo`, `fono`, `tipo`, `foto`, `password`, `acceso`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin', NULL, '0', '', '', NULL, '', 'ADMINISTRADOR', NULL, '$2y$10$RrCZZySOwPej2gMFWsrjMe6dLzfaL5Q88h4J75I1FesEBRNPwq1x.', 1, '2023-11-01', NULL, NULL),
(2, 'JPERES', 'JUAN', 'PERES', 'MAMANI', '1234', 'LP', 'LOS OLIVOS', NULL, '77777', 'OPERADOR', '1699455836_JPERES.jpg', '$2y$10$xIRVAm.8iVqsiJRl/eWMcO6hWHi.BA6rZAZCciYVvu9vDyy3yx6Ry', 1, '2023-11-08', '2023-11-08 15:03:56', '2023-11-15 19:36:20'),
(3, 'FGONZALES', 'FERNANDO', 'GONZALES', 'MARTINES', '1111', 'LP', NULL, NULL, '777777', 'FUNCIONARIO', NULL, '$2y$10$cSrzU1ME21B10bI3wFPuQuWwX59KiP/0v5mzgIvAWgS0dO8vp08HO', 1, '2023-11-13', '2023-11-13 19:16:54', '2023-11-13 19:17:59'),
(4, 'FMAMANI', 'FELIPE', 'MAMANI', 'MAMANI', '2222', 'PT', NULL, NULL, '666666', 'FUNCIONARIO', NULL, '$2y$10$Mm6dl26X398VZwZ/SkZMRO.ditNPU.Vjk24v07Bof/W6WqTwGA51S', 1, '2023-11-15', '2023-11-15 16:11:32', '2023-11-15 16:11:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjuntar_documentos`
--
ALTER TABLE `adjuntar_documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adjuntar_documentos_documento_id_foreign` (`documento_id`);

--
-- Indexes for table `configuracions`
--
ALTER TABLE `configuracions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dependencias`
--
ALTER TABLE `dependencias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devolucion_documentos`
--
ALTER TABLE `devolucion_documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devolucion_documentos_documento_id_foreign` (`documento_id`),
  ADD KEY `devolucion_documentos_funcionario_id_foreign` (`funcionario_id`);

--
-- Indexes for table `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documentos_codigo_unique` (`codigo`);

--
-- Indexes for table `estantes`
--
ALTER TABLE `estantes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `funcionarios_codigo_unique` (`codigo`),
  ADD KEY `funcionarios_user_id_foreign` (`user_id`);

--
-- Indexes for table `historial_accions`
--
ALTER TABLE `historial_accions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oficinas`
--
ALTER TABLE `oficinas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `prestamo_documentos`
--
ALTER TABLE `prestamo_documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prestamo_documentos_documento_id_foreign` (`documento_id`),
  ADD KEY `prestamo_documentos_funcionario_id_foreign` (`funcionario_id`),
  ADD KEY `prestamo_documentos_dependencia_id_foreign` (`dependencia_id`);

--
-- Indexes for table `reserva_documentos`
--
ALTER TABLE `reserva_documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserva_documentos_documento_id_foreign` (`documento_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_usuario_unique` (`usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjuntar_documentos`
--
ALTER TABLE `adjuntar_documentos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `configuracions`
--
ALTER TABLE `configuracions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dependencias`
--
ALTER TABLE `dependencias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `devolucion_documentos`
--
ALTER TABLE `devolucion_documentos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `estantes`
--
ALTER TABLE `estantes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `historial_accions`
--
ALTER TABLE `historial_accions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `oficinas`
--
ALTER TABLE `oficinas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prestamo_documentos`
--
ALTER TABLE `prestamo_documentos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reserva_documentos`
--
ALTER TABLE `reserva_documentos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adjuntar_documentos`
--
ALTER TABLE `adjuntar_documentos`
  ADD CONSTRAINT `adjuntar_documentos_documento_id_foreign` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`);

--
-- Constraints for table `devolucion_documentos`
--
ALTER TABLE `devolucion_documentos`
  ADD CONSTRAINT `devolucion_documentos_documento_id_foreign` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`),
  ADD CONSTRAINT `devolucion_documentos_funcionario_id_foreign` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`);

--
-- Constraints for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `funcionarios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `prestamo_documentos`
--
ALTER TABLE `prestamo_documentos`
  ADD CONSTRAINT `prestamo_documentos_dependencia_id_foreign` FOREIGN KEY (`dependencia_id`) REFERENCES `dependencias` (`id`),
  ADD CONSTRAINT `prestamo_documentos_documento_id_foreign` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`),
  ADD CONSTRAINT `prestamo_documentos_funcionario_id_foreign` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`);

--
-- Constraints for table `reserva_documentos`
--
ALTER TABLE `reserva_documentos`
  ADD CONSTRAINT `reserva_documentos_documento_id_foreign` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
