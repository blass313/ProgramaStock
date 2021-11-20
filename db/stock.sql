-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2021 a las 05:22:01
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
CREATE DATABASE stock;

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `cod` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(150) NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_por_kg` double NOT NULL,
  `precio_bolsa` double NOT NULL,
  `sugerido` int(11) NOT NULL,
  `porcentajekg` int(11) NOT NULL,
  `porcentajebolsa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `cod`, `name`, `description`, `categoria`, `stock`, `precio_por_kg`, `precio_bolsa`, `sugerido`, `porcentajekg`, `porcentajebolsa`) VALUES
(8, 2017, 'A. DEL PLATA CAB.SAUV.', '750x6', 'VINOS', 16, 257, 2351, 12, 45, 30),
(15, 10103, 'MILLER', '330x24 NR', 'CCU', 10, 80.34, 1928.03, 7, 40, 30),
(16, 20134, 'TORO BLANCO', '930X6', 'FECOVITA', 101, 126.76, 760.58, 300, 40, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(250) NOT NULL,
  `activate` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `activate`) VALUES
(2, 'blass313', 'blas.casciari@gmail.com', 'fs.8MgNVlt32.', 1),
(3, 'blas', 'blas@gmail.com', 'fs.8MgNVlt32.', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
