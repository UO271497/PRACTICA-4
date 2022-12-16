-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-12-2021 a las 14:55:06
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `weblibros`
--
CREATE DATABASE IF NOT EXISTS `weblibros` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `weblibros`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

DROP TABLE IF EXISTS `autores`;
CREATE TABLE IF NOT EXISTS `autores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id`, `nombre`) VALUES
(2, 'Agatha Christie'),
(1, 'Laura Gallego'),
(3, 'Robert Jordan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `idLibro` int(11) NOT NULL,
  `texto` varchar(140) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idLibro` (`idLibro`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `alias`, `idLibro`, `texto`) VALUES
(1, 'Manolo el del Bombo', 5, 'Una obra de arte contemporanea'),
(2, 'Elisa', 2, 'Un clásico de la literatura juvenil'),
(3, 'James', 8, 'Estuve tenso hasta la última hoja!'),
(4, 'Vaina loca', 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fringilla vel mauris quis suscipit. Pellentesque placerat viverra ante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editoriales`
--

DROP TABLE IF EXISTS `editoriales`;
CREATE TABLE IF NOT EXISTS `editoriales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `editoriales`
--

INSERT INTO `editoriales` (`id`, `nombre`) VALUES
(3, 'Algani Editorial'),
(2, 'Andavira Editora'),
(1, 'Apiario Editora');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

DROP TABLE IF EXISTS `libros`;
CREATE TABLE IF NOT EXISTS `libros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `idAutor` int(11) NOT NULL,
  `idEditorial` int(11) NOT NULL,
  `genero` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idAutor` (`idAutor`),
  KEY `idEditorial` (`idEditorial`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `nombre`, `idAutor`, `idEditorial`, `genero`) VALUES
(2, 'Memorias de Idhún', 1, 1, 'Fantasía'),
(3, 'Alas de fuego', 1, 2, 'Fantasía'),
(5, 'La Rueda del Tiempo', 3, 3, 'Fantasía'),
(6, 'Elephants Can Remember', 2, 2, 'Suspense'),
(7, 'Five Little Pigs', 2, 3, 'Suspense'),
(8, ' Murder in Mesopotamia', 2, 1, 'Suspense');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `digital`
--

DROP TABLE IF EXISTS `digital`;
CREATE TABLE IF NOT EXISTS `digital` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `nombreReferencia` varchar(255) NOT NULL,
  `basadaLibro` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `digital`
--

INSERT INTO `digital` (`id`, `nombre`, `nombreReferencia`,`basadaLibro`) VALUES
(2, 'Memorias de Idhún (Serie de animación)', 'Memorias de Idhún','True'),
(5, 'La rueda del tiempo (Serie Amazon Prime)', 'La rueda del tiempo','True'),
(6, 'Inception', '','False'),
(8, 'Avengers: La era de Ultrón', '','False'),
(7, 'Poirot: Five little pigs', 'Five Little Pigs','True');
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idLibro`) REFERENCES `libros` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`idEditorial`) REFERENCES `editoriales` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `libros_ibfk_2` FOREIGN KEY (`idAutor`) REFERENCES `autores` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;