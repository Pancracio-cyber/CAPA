-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-07-2020 a las 21:03:43
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `capa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudadanos`
--

CREATE TABLE `ciudadanos` (
  `IdCiudadanos` int(11) NOT NULL COMMENT 'Identificar la tabala Ciudadanos autoincrementable',
  `CURP` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Clave Única de Registro dem Población del Ciudadano',
  `Nombre` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nombre del Ciudadano',
  `ApellidoMaterno` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Apellido Materno del Ciudadano',
  `ApellidoPaterno` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Apellido Paterno del Ciudadano',
  `Sexo` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Sexo del Ciudadano',
  `RFC` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Registro Federal de Contribuyentes',
  `CorreoElectronico` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Correo Electronico del Ciudadano',
  `Telefono` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Número de telefono del Ciudadano',
  `solicitudes_IdSolicitud` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `IdSolicitud` int(11) NOT NULL COMMENT 'Identificador de las Solicitudes',
  `CURP` varchar(45) DEFAULT NULL,
  `FechaRegistro` date DEFAULT NULL COMMENT 'Fecha de Registro de la Solicitud',
  `FechaPago` date DEFAULT NULL COMMENT 'Fecha de Pago de la Solicitud',
  `Referencia` varchar(45) DEFAULT NULL COMMENT 'Referencia de Pago',
  `EstatusPago` varchar(45) DEFAULT NULL COMMENT 'Estatus de pago donde se vera si ya se realizo el pago, esta en tramite, etc.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`IdSolicitud`, `CURP`, `FechaRegistro`, `FechaPago`, `Referencia`, `EstatusPago`) VALUES
(1, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL),
(3, 'MOCE990815RCCRTCH', NULL, NULL, NULL, NULL),
(4, 'MOCE990815RCCRTCH', NULL, NULL, NULL, NULL),
(5, 'MOCE990815RCCRTCH', NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudadanos`
--
ALTER TABLE `ciudadanos`
  ADD PRIMARY KEY (`IdCiudadanos`),
  ADD KEY `fk_ciudadanos_solicitudes` (`solicitudes_IdSolicitud`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`IdSolicitud`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `IdSolicitud` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de las Solicitudes', AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ciudadanos`
--
ALTER TABLE `ciudadanos`
  ADD CONSTRAINT `fk_ciudadanos_solicitudes` FOREIGN KEY (`solicitudes_IdSolicitud`) REFERENCES `solicitudes` (`IdSolicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
