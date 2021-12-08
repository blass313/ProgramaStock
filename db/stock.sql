-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2021 a las 07:42:42
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
-- Estructura de tabla para la tabla `distribuidora`
--

CREATE TABLE `distribuidora` (
  `id` int(11) UNSIGNED NOT NULL,
  `fecha_de_factura` date NOT NULL,
  `nombre_distribuidora` varchar(150) NOT NULL,
  `monto` double NOT NULL,
  `estado` varchar(100) NOT NULL,
  `numero_boleta` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `distribuidora`
--

INSERT INTO `distribuidora` (`id`, `fecha_de_factura`, `nombre_distribuidora`, `monto`, `estado`, `numero_boleta`) VALUES
(4, '2021-10-12', 'ccu', 10000, 'impaga', '51315135151'),
(6, '2021-10-12', 'CCU', 10523.5, 'impaga', 'A20005-30578549'),
(7, '2021-11-25', 'FECOVITA', 10325.33, 'impaga', 'AC5000-325469'),
(8, '2021-11-27', 'CHAMPAGNE', 102578.33, 'impaga', 'AB500-68548785');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion`
--

CREATE TABLE `facturacion` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `ingreso` int(11) NOT NULL,
  `salida` int(11) NOT NULL,
  `personas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `facturacion`
--

INSERT INTO `facturacion` (`id`, `fecha`, `ingreso`, `salida`, `personas`) VALUES
(4, '2021-12-05', 17200, 4235, 36),
(5, '2021-12-05', 9250, 0, 21),
(6, '0000-00-00', 111, 1111, 1111),
(7, '2021-12-03', 1111, 1111, 1111),
(8, '2021-12-06', 36000, 23000, 44);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `cod` int(11) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(150) NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `stock` int(11) NOT NULL,
  `kg` int(11) NOT NULL,
  `precio_bolsa` double NOT NULL,
  `sugerido` int(11) NOT NULL,
  `porcentajekg` int(11) NOT NULL,
  `porcentajebolsa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `cod`, `name`, `description`, `categoria`, `stock`, `kg`, `precio_bolsa`, `sugerido`, `porcentajekg`, `porcentajebolsa`) VALUES
(16, 20134, 'CATCHOW', 'GATITO', 'GALLEGO', 1, 15, 6000, 2, 40, 30),
(27, 2020, 'CATCHOW', 'ADULTO', 'ERS', 3, 15, 4885, 3, 40, 30),
(28, 491, 'BIOPET', 'PERRO ADULTO', 'ERS', 10, 20, 1850, 7, 40, 30),
(29, NULL, 'ALPISTE', 'OTRO', 'GALLEGO', 15, 15, 4320, 20, 30, 40),
(30, NULL, 'CAT PRO', 'GATITO', 'ERS', 10, 8, 2526, 20, 40, 30),
(31, NULL, 'ECONOCAN', 'PERRO ADULTO', 'ECONOCAN1', 20, 15, 951, 22, 40, 30);

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
(2, 'blass313', 'blas.casciari@gmail.com', 'fs.8MgNVlt32.', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `distribuidora`
--
ALTER TABLE `distribuidora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `distribuidora`
--
ALTER TABLE `distribuidora`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
