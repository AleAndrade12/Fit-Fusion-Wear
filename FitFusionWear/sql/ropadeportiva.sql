-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Servidor: db5016656134.hosting-data.io
-- Tiempo de generación: 05-12-2024 a las 04:59:37
-- Versión del servidor: 8.0.36
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbs13496899`
--
CREATE DATABASE IF NOT EXISTS `dbs13496899` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dbs13496899`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `nombre_completo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `usuario` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`id`, `nombre_completo`, `correo`, `contrasena`, `usuario`) VALUES
(1, 'Alejandra Andrade', 'andradealejandrar@gmail.com', '123', 'Ale1212');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int NOT NULL,
  `cliente_id` int NOT NULL,
  `producto_codigo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` int NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `cliente_id`, `producto_codigo`, `cantidad`, `fecha_agregado`) VALUES
(30, 66, '1400g', 1, '2024-11-13 13:46:14'),
(32, 66, '1517l', 1, '2024-11-13 13:46:20'),
(35, 66, '1317l', 1, '2024-11-13 13:46:29'),
(36, 66, '1492Tam', 1, '2024-11-13 13:46:32'),
(40, 63, '1567Cr', 1, '2024-12-05 02:39:39'),
(41, 63, '1492Tbn', 1, '2024-12-05 02:39:47'),
(55, 1, '1492Tbn', 1, '2024-12-05 04:35:18'),
(56, 1, '1586ch', 1, '2024-12-05 04:35:21'),
(57, 1, '1600ch', 1, '2024-12-05 04:35:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `nombre_completo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_general_ci,
  `usuario` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre_completo`, `telefono`, `direccion`, `usuario`, `contrasena`, `correo`) VALUES
(1, 'Kareline Monserrath Andrade Rivera', '8446231489', 'Colonia Campo Verde 2623 Prolongación Pablo L Sidar', 'Kare9508', '123', 'andradekare@gmail.com'),
(58, 'Carolina Betzabe Carrizales Vazques', '8449631584', 'Calle Nueva España 276 Urdiñola', 'Caro012', 'Caro1265*', 'carito12@gmail.com'),
(59, 'Sandra Nelida Rivera Moreno', '8446231489', 'Colonia Campo Verde 2623 Prolongación Pablo L Sidar', 'SandraN159', 'Sandra101277*', 'Sandra12@gmail.com'),
(61, 'Victor Andrade Tello', '8441235687', 'Colonia Campo Verde 2623 Prolongación Pablo L Sidar', 'Victor9856', 'Vic2209*', 'victorandrade@gmail.com'),
(62, 'Paulina Cardenas', '8446231489', 'Colonia Campo Verde 2623 Prolongación Pablo L Sidar', 'Pau159', 'Paulina123*', 'PauCar12@gmail.com'),
(63, 'Jhonatan Smith Hernandez Guillermo', '8442337329', 'mario morales nuevo ramos', 'JhonSmith', 'Samanth@272001', 'Smitherdezz3@gmail.com'),
(64, 'Arzola paseme paro', '8443410584', 'Segovia Gil', 'PasemeInge', 'Aa123456.', 'orlandoavilacespedes@gmail.com'),
(65, 'Eduardo Castillo', '8445647767', 'Lomas Turbas 69', 'Peña Nieto', 'Hacker23&', 'eduardocastillo1390@gmail.com'),
(66, 'Cesar Alonso Garcia Suarez', '8447894561', 'Prueba #1', 'CesarAGS', 'Prueba#123', 'supertiki.cags@gmail.com'),
(67, 'Hector Daniel Salas Perez', '8442325436', 'Hacienda San Rafael Av. La Nogalera $154', 'Est0R', '$amh731021B65', 'hectordanielsalas@gmail.com'),
(68, 'Alejandra Guadalupe Andrade Rivera', '8445858564', 'Colonia Campo Verde 2623 Prolongación Pablo L Sidar', 'Ale1230', 'Ale121203*', 'andradealejandrar@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intentos_fallidos`
--

CREATE TABLE `intentos_fallidos` (
  `id` int NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `intentos_fallidos`
--

INSERT INTO `intentos_fallidos` (`id`, `ip_address`, `username`, `timestamp`) VALUES
(1, '::1', 'Kare9508', '2024-11-13 01:21:45'),
(2, '201.148.14.100', 'CesarAGS', '2024-11-13 13:45:12'),
(3, '2806:2f0:31c0:1e89:589b:b87e:f6ca:829e', 'Kare9508', '2024-12-03 05:18:06'),
(4, '2806:2f0:3280:36a:19c1:36d2:be29:4e1a', 'Ale1212', '2024-12-05 03:02:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int NOT NULL,
  `cliente_id` int NOT NULL,
  `nombre_cliente` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono_cliente` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `direccion_cliente` text COLLATE utf8mb4_general_ci NOT NULL,
  `lista_compras` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `forma_entrega` enum('domicilio','punto_entrega') COLLATE utf8mb4_general_ci NOT NULL,
  `forma_pago` enum('efectivo','transferencia') COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_entrega` date NOT NULL
) ;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `nombre_cliente`, `telefono_cliente`, `direccion_cliente`, `lista_compras`, `total`, `forma_entrega`, `forma_pago`, `fecha_entrega`) VALUES
(14, 1, 'Kareline Monserrath Andrade Rivera', '8446231489', 'Colonia Campo Verde 2623 Prolongación Pablo L Sidar', '[{\"codigo\":\"1492Tnm\",\"nombre\":\"Short deportivo\",\"precio\":\"180.00\",\"cantidad\":1,\"subtotal\":180}]', '180.00', 'domicilio', 'transferencia', '2025-01-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `codigo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `stock` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `talla` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `categoria` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`codigo`, `stock`, `nombre`, `descripcion`, `talla`, `color`, `precio`, `categoria`) VALUES
('1317ac', 7, 'Top deportivo', 'Top deportivo', 'unitalla', 'Azul acero', '150.00', 'tops'),
('1317l', 4, 'Top deportivo', 'Top deportivo', 'unitalla', 'Lavanda', '150.00', 'tops'),
('1317rb', 6, 'Top deportivo', 'Top deportivo', 'unitalla', 'Rosa bb', '150.00', 'tops'),
('1371b', 5, 'Top deportivo', 'Top deportivo', 'unitalla', 'Blanco', '150.00', 'tops'),
('1400g', 0, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Greige', '180.00', 'shorts'),
('1480g', 7, 'Top deportivo', 'Top deportivo', 'unitalla', 'Greige', '150.00', 'tops'),
('1480l', 6, 'Top deportivo', 'Top deportivo', 'unitalla', 'Lavanda', '150.00', 'tops'),
('1492Tam', 5, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Aceituna Militar', '180.00', 'shorts'),
('1492Tbn', 0, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Blanco negro', '180.00', 'shorts'),
('1492Tm', 7, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Mauve', '180.00', 'shorts'),
('1492Tmej', 8, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Menta Jade', '180.00', 'shorts'),
('1492Tnm', 3, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Niagara marino', '180.00', 'shorts'),
('1492Ton', 8, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Oxford negro', '180.00', 'shorts'),
('1492Tvsm', 4, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Verde Seco militar', '180.00', 'shorts'),
('1517aa', 7, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Azul acero', '180.00', 'shorts'),
('1517l', 4, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Lavanda', '180.00', 'shorts'),
('1517n', 4, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Negro', '180.00', 'shorts'),
('1517oa', 9, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Olivo art', '180.00', 'shorts'),
('1522n', 3, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Negro', '180.00', 'shorts'),
('1522oa', 8, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Olivo art', '180.00', 'shorts'),
('155Tnn', 3, 'Enterizo deportivo', 'Enterizo deportivo con efecto push up', 'ch-m', 'Niagara negro', '250.00', 'enterizos'),
('1567Coa', 78, 'Conjunto deportivo', 'Conjunto deportivo top y short con efecto push up', 'extra_chico', 'Olivo art', '335.00', 'conjuntos'),
('1567Cr', 5, 'Conjunto deportivo', 'Conjunto deportivo top y short con efecto push up', 'xs-ch', 'Rojo', '330.00', 'conjuntos'),
('1578Caa', 8, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Azul acero', '180.00', 'shorts'),
('1578Cc', 9, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Ciruela', '180.00', 'shorts'),
('1578Cg', 8, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Greige', '180.00', 'shorts'),
('1578Cm', 6, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Mauve', '180.00', 'shorts'),
('1578Cn', 7, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Negro', '180.00', 'shorts'),
('1585XLb', 6, 'Leggins deportivo', 'Leggins deportivo sin efecto push up', 'xs-ch', 'Botella', '200.00', 'leggins'),
('1586ch', 4, 'Conjunto deportivo', 'Conjunto deportivo top y short con efecto push up', 'ch-m', 'Cherry', '330.00', 'conjuntos'),
('1593ac', 1, 'Short deportivo', 'Short deportivo con push up color liso', 'Unitalla', 'Aceituna', '180.00', 'Shorts'),
('1593az', 1, 'Short deportivo', 'Short deportivo con push up color liso', 'Unitalla', 'Azul acero', '180.00', 'Shorts'),
('1593ch', 1, 'Short deportivo', 'Short deportivo con push up color liso', 'Unitalla', 'Chocolate', '180.00', 'Shorts'),
('1593m', 0, 'Short deportivo', 'Short deportivo con push up color liso', 'Unitalla', 'Mauve', '180.00', 'Shorts'),
('1593Tcj', 1, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Crudo jade', '180.00', 'shorts'),
('1600a', 5, 'Leggins deportivo', 'Leggins deportivo con efecto push up', 'xs-ch', 'Almendra', '200.00', 'leggins'),
('1600ch', 3, 'Leggins deportivo', 'Leggins deportivo con efecto push up', 'xs-ch', 'Cherry', '200.00', 'leggins'),
('1600m', 9, 'Leggins deportivo', 'Leggins deportivo con efecto push up', 'xs-ch', 'Mauve', '200.00', 'leggins'),
('1600n', 8, 'Leggins deportivo', 'Leggins deportivo con efecto push up', 'xs-ch', 'Negro', '200.00', 'leggins'),
('1615an', 9, 'Leggins deportivo', 'Leggins deportivo con efecto push up', 'xs-ch', 'Almendra negro', '200.00', 'leggins'),
('1615ln', 8, 'Leggins deportivo', 'Leggins deportivo con efecto push up', 'xs-ch', 'Lana negro', '200.00', 'leggins'),
('1615n', 7, 'Leggins deportivo', 'Leggins deportivo con efecto push up', 'xs-ch', 'Negro', '200.00', 'leggins'),
('1615rb', 6, 'Leggins deportivo', 'Leggins deportivo con efecto push up', 'xs-ch', 'Rosa Barbie Negro', '200.00', 'leggins'),
('1629bn', 5, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Blanco negro', '180.00', 'shorts'),
('1629ll', 7, 'Short deportivo', 'Short deportivo con efecto push up', 'unitalla', 'Lila lavanda', '180.00', 'shorts'),
('1654Sche', 1, 'Short deportivo', 'Short deportivo con push up color liso', 'Unitalla', 'Cherry', '180.00', 'Shorts'),
('1663n', 1, 'Enterizo deportivo', 'Enterizo deportivo sin efecto push up', 'ch-m', 'Negro', '250.00', 'enterizos'),
('1669m', 4, 'Enterizo deportivo', 'Enterizo deportivo con efecto push up', 'ch-m', 'Mauve', '250.00', 'enterizos'),
('1670o', 6, 'Conjunto deportivo', 'Conjunto deportivo top y short con efecto push up', 'ch-m', 'Oxford', '330.00', 'conjuntos'),
('1670p', 6, 'Top deportivo', 'Conjunto deportivo top y short con efecto push up', 'ch-m', 'Petroleo', '330.00', 'conjuntos'),
('556m', 80, 'Leggins deportivo', 'Leggins deportivo', 'unitalla', 'Marino', '200.00', 'leggins');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `producto_codigo` (`producto_codigo`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `intentos_fallidos`
--
ALTER TABLE `intentos_fallidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `intentos_fallidos`
--
ALTER TABLE `intentos_fallidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`producto_codigo`) REFERENCES `productos` (`codigo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
