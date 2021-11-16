-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2021 a las 06:54:33
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `stock`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `cod` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(150) NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  `precio_unidad` double NOT NULL,
  `precio_bulto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `cod`, `name`, `description`, `categoria`, `status`, `precio_unidad`, `precio_bulto`) VALUES
(6, 20113, 'SUTER CHAMP.', 'D.SEC 750X6', 'CHAMPAGNE MEDIA', 200, 231.85, 1391.09),
(7, 60010, 'FERNET BRANCA', '1/1x6', 'FERNET BRANCA', 300, 707.98, 4247.86),
(8, 2017, 'A. DEL PLATA CAB.SAUV.', '750x6', 'VINOS', 523, 381.89, 2291.36),
(9, 2014, 'VALMONT TTO', '750X6', 'VINO', 315, 228.97, 1373.82),
(10, 10070, 'AMSTEL PREMIUM ', '1/1X12', 'CCU', 300, 157.89, 1894.67);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
