-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2024 a las 19:18:42
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
-- Base de datos: `tarea2u5`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `apellidos`) VALUES
('Luis', 'García'),
('María', 'López'),
('Carlos', 'Pérez'),
('Ana', 'Martínez'),
('José', 'Rodríguez'),
('Laura', 'González'),
('Juan', 'Hernández'),
('Elena', 'Fernández'),
('Miguel', 'Sánchez'),
('Isabel', 'Ramírez');

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  AUTO_INCREMENT=20;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarUsuario`(IN nombreUsuario VARCHAR(255), IN apellidosUsuario VARCHAR(255))
BEGIN
    INSERT INTO usuarios (nombre, apellidos) VALUES (nombreUsuario, apellidosUsuario);
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `contarUsuarios`(OUT totalUsuarios INT)
BEGIN
    SELECT COUNT(*) INTO totalUsuarios FROM usuarios;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerNombreUsuario`(IN idUsuario INT, OUT nombreUsuario VARCHAR(255))
BEGIN
    SELECT nombre INTO nombreUsuario FROM usuarios WHERE id = idUsuario;
END$$
DELIMITER ;