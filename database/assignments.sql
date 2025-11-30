-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2025 a las 10:01:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `equipocom`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assignments`
--

CREATE TABLE `assignments` (
  `idAssignment` bigint(20) UNSIGNED NOT NULL,
  `User_id` bigint(20) UNSIGNED NOT NULL,
  `Boss_id` bigint(20) UNSIGNED NOT NULL,
  `Date` datetime NOT NULL,
  `Document` varchar(200) DEFAULT NULL,
  `Image` varchar(200) DEFAULT NULL,
  `Comment` varchar(150) DEFAULT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `assignments`
--

INSERT INTO `assignments` (`idAssignment`, `User_id`, `Boss_id`, `Date`, `Document`, `Image`, `Comment`, `Status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-11-30 01:10:00', 'documents/assignments/documento_20251130_011142_692be01eb4d64.pdf', NULL, 'se asigno estos 3 equipost', 1, '2025-11-30 06:11:42', '2025-11-30 08:56:31'),
(2, 1, 2, '2025-11-30 01:11:00', 'documents/assignments/documento_20251130_011231_692be04f88226.pdf', 'images/assignments/imagen_20251130_011231_692be04f8b09f.png', 'SE ASIGNO ESTA IMPRESORA EPSON', 1, '2025-11-30 06:12:31', '2025-11-30 06:12:31'),
(3, 1, 1, '2025-11-30 01:12:00', 'documents/assignments/documento_20251130_011314_692be07a2bdd7.pdf', 'images/assignments/imagen_20251130_011314_692be07a2fe0e.png', 'SE LE ASIGNO ESTOS EQUIPOe', 1, '2025-11-30 06:13:14', '2025-11-30 08:18:15'),
(4, 1, 3, '2025-11-30 03:56:00', 'documents/assignments/documento_20251130_035719_692c06efa8459.pdf', NULL, 'se asignaron 3 equipos', 1, '2025-11-30 08:57:21', '2025-11-30 08:57:21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`idAssignment`),
  ADD KEY `assignments_user_id_foreign` (`User_id`),
  ADD KEY `assignments_boss_id_foreign` (`Boss_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `assignments`
--
ALTER TABLE `assignments`
  MODIFY `idAssignment` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_boss_id_foreign` FOREIGN KEY (`Boss_id`) REFERENCES `bosses` (`idBoss`),
  ADD CONSTRAINT `assignments_user_id_foreign` FOREIGN KEY (`User_id`) REFERENCES `users` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
