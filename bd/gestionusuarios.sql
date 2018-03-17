-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-02-2018 a las 21:40:16
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestionusuarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuadros`
--

CREATE TABLE `cuadros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `pintor_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cuadros`
--

INSERT INTO `cuadros` (`id`, `titulo`, `imagen`, `pintor_fk`) VALUES
(1, 'La familia de Carlos IV', 'familia_de_Carlos_IV.jpg', 1),
(2, 'Fusilamientos 3 de Mayo', 'fusilamientos_3_mayo.jpg', 1),
(4, 'La habitación', 'habitacion.jpg', 3),
(5, 'Las meninas', 'las_meninas.jpg', 2),
(6, 'Los borrachos', 'los_borrachos.jpg', 2),
(7, 'Los girasoles', 'los_girasoles.jpg', 3),
(8, 'La maja vestida', 'maja_vestida.jpg', 1),
(9, 'Noche estrellada', 'noche_estrellada.jpg', 3),
(10, 'La rendición de Breda', 'rendicion_breda.jpg', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pintores`
--

CREATE TABLE `pintores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pintores`
--

INSERT INTO `pintores` (`id`, `nombre`) VALUES
(1, 'Goya'),
(2, 'Velazquez'),
(3, 'Van Gogh');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `pintor_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `clave`, `email`, `pintor_fk`) VALUES
(3, 'juan', 'juan', 'juan@sdfsdf.com', 2),
(4, 'juan', 'ff', 'juan@gmail.com', 1),
(5, 'ivan', 'ivan', 'ivan@asasd.com', 1),
(6, 'aaa', 'aaa', 'aaa@aaa.com', 3),
(7, 'aaa', 'aaa', 'aaa@aaa.com', 1),
(8, 'aaa', 'aaa', 'aaa@aaa.com', 1),
(9, 'bbc', 'bbb', 'bbb@bbb.com', 1),
(10, '', '', '', 1),
(11, '', '', '', 1),
(12, '', '', '', 1),
(13, '', '', '', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuadros`
--
ALTER TABLE `cuadros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pintores`
--
ALTER TABLE `pintores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuadros`
--
ALTER TABLE `cuadros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `pintores`
--
ALTER TABLE `pintores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
