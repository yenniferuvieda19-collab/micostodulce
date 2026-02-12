-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-02-2026 a las 08:47:03
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
-- Base de datos: `calculadora_costos_postres`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costos_adicionales`
--

CREATE TABLE `costos_adicionales` (
  `Id_costo` int(11) NOT NULL,
  `Id_receta` int(11) NOT NULL,
  `nombre_costo` varchar(150) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `tipo_costo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos_adicionales`
--

CREATE TABLE `gastos_adicionales` (
  `Id_gasto` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `nombre_gasto` varchar(100) NOT NULL,
  `categoria` enum('Empaque','Servicio','Mano de Obra','Otro') DEFAULT 'Otro',
  `es_fijo` tinyint(1) NOT NULL DEFAULT 0,
  `precio_unitario` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `es_paquete` tinyint(1) DEFAULT 0,
  `cantidad_paquete` int(11) DEFAULT 1,
  `costo_paquete` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos_adicionales`
--

INSERT INTO `gastos_adicionales` (`Id_gasto`, `Id_usuario`, `nombre_gasto`, `categoria`, `es_fijo`, `precio_unitario`, `created_at`, `es_paquete`, `cantidad_paquete`, `costo_paquete`) VALUES
(5, 6, 'Delivery', '', 1, 3.00, '2026-02-12 00:36:45', 0, 1, 0.00),
(6, 6, 'Mano de Obra', '', 0, 10.00, '2026-02-12 00:37:01', 0, 1, 0.00),
(7, 7, 'Delivery', '', 1, 2.00, '2026-02-12 02:17:14', 0, 1, 0.00),
(8, 7, 'Mano de obra', '', 0, 30.00, '2026-02-12 02:17:38', 0, 1, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos_recetas`
--

CREATE TABLE `gastos_recetas` (
  `Id_gasto_receta` int(11) NOT NULL,
  `Id_receta` int(11) NOT NULL,
  `Id_gasto` int(11) NOT NULL,
  `precio_aplicado` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos_recetas`
--

INSERT INTO `gastos_recetas` (`Id_gasto_receta`, `Id_receta`, `Id_gasto`, `precio_aplicado`) VALUES
(6, 30, 0, 2.00),
(7, 30, 0, 5.05),
(8, 31, 0, 2.00),
(9, 32, 0, 2.00),
(10, 33, 0, 5.32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `Id_ingrediente` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `Id_unidad_base` int(11) NOT NULL,
  `nombre_ingrediente` varchar(150) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `cantidad_paquete` decimal(10,2) NOT NULL,
  `costo_unidad` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`Id_ingrediente`, `Id_usuario`, `Id_unidad_base`, `nombre_ingrediente`, `precio_compra`, `cantidad_paquete`, `costo_unidad`) VALUES
(48, 4, 5, 'huevos', 0.00, 24.00, 7.0000),
(49, 4, 1, 'harina', 0.00, 1000.00, 3.0000),
(50, 4, 1, 'azucar', 0.00, 1000.00, 4.0000),
(51, 4, 1, 'cacao', 0.00, 300.00, 1.0000),
(53, 6, 1, 'P01', 0.00, 1000.00, 10.0000),
(54, 6, 3, 'P02', 0.00, 1000.00, 10.0000),
(55, 6, 5, 'P03', 0.00, 1000.00, 10.0000),
(56, 7, 5, 'Huevos', 0.00, 15.00, 4.3000),
(57, 7, 1, 'Harina ', 0.00, 900.00, 2.0000),
(58, 7, 1, 'Leche', 0.00, 900.00, 12.0000),
(59, 7, 1, 'Mantequilla', 0.00, 500.00, 2.5000),
(60, 7, 1, 'Cacao', 0.00, 200.00, 4.7600),
(61, 7, 2, 'Azucar', 0.00, 1.00, 1.7000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes_recetas`
--

CREATE TABLE `ingredientes_recetas` (
  `Id_detalle` int(11) NOT NULL,
  `Id_receta` int(11) NOT NULL,
  `Id_ingrediente` int(11) NOT NULL,
  `cantidad_requerida` decimal(10,2) NOT NULL,
  `unidad_receta` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingredientes_recetas`
--

INSERT INTO `ingredientes_recetas` (`Id_detalle`, `Id_receta`, `Id_ingrediente`, `cantidad_requerida`, `unidad_receta`) VALUES
(195, 23, 49, 600.00, 'unidad'),
(196, 23, 50, 200.00, 'unidad'),
(197, 23, 48, 4.00, 'unidad'),
(198, 23, 51, 100.00, 'unidad'),
(202, 24, 49, 500.00, 'unidad'),
(203, 24, 48, 2.00, 'unidad'),
(204, 24, 50, 149.99, 'unidad'),
(208, 27, 53, 1000.00, 'unidad'),
(209, 27, 54, 1000.00, 'unidad'),
(210, 27, 55, 1000.00, 'unidad'),
(214, 28, 53, 1000.00, 'unidad'),
(215, 28, 54, 1000.00, 'unidad'),
(216, 28, 55, 1000.00, 'unidad'),
(232, 30, 61, 600.00, 'unidad'),
(233, 30, 60, 150.00, 'unidad'),
(234, 30, 57, 700.00, 'unidad'),
(235, 30, 56, 5.00, 'unidad'),
(236, 30, 58, 600.00, 'unidad'),
(237, 30, 59, 250.00, 'unidad'),
(238, 33, 60, 150.00, 'unidad'),
(239, 33, 61, 600.00, 'unidad'),
(240, 33, 57, 700.00, 'unidad'),
(241, 33, 58, 690.00, 'unidad'),
(242, 33, 56, 4.00, 'unidad'),
(243, 33, 59, 250.00, 'unidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

CREATE TABLE `produccion` (
  `Id_produccion` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `Id_receta` int(11) NOT NULL,
  `nombre_receta` varchar(255) NOT NULL,
  `cantidad_producida` int(11) NOT NULL,
  `costo_unitario` decimal(10,2) NOT NULL,
  `costo_adicional_total` decimal(10,2) NOT NULL,
  `costo_total_lote` decimal(10,2) NOT NULL,
  `fecha_produccion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `produccion`
--

INSERT INTO `produccion` (`Id_produccion`, `Id_usuario`, `Id_receta`, `nombre_receta`, `cantidad_producida`, `costo_unitario`, `costo_adicional_total`, `costo_total_lote`, `fecha_produccion`) VALUES
(17, 4, 23, 'torta de chocolate', 20, 0.00, 10.66, 8.20, '2026-02-11 00:00:00'),
(18, 4, 24, 'ponques', 5, 0.00, 3.49, 2.68, '2026-02-11 00:00:00'),
(20, 7, 30, 'Torta Vainilla', 12, 2.10, 25.28, 33.66, '2026-02-12 00:00:00'),
(22, 7, 33, 'Bizcocho marmoleado', 0, 4.33, -0.04, 23.06, '2026-02-12 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `Id_receta` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `nombre_postre` varchar(150) NOT NULL,
  `porciones` int(11) NOT NULL,
  `costo_ingredientes` decimal(10,2) NOT NULL,
  `precio_venta_sug` decimal(10,2) NOT NULL,
  `notas` text DEFAULT NULL,
  `porcentaje_ganancia` int(11) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`Id_receta`, `Id_usuario`, `nombre_postre`, `porciones`, `costo_ingredientes`, `precio_venta_sug`, `notas`, `porcentaje_ganancia`) VALUES
(23, 4, 'torta de chocolate', 10, 4.10, 5.33, '', 30),
(24, 4, 'ponques', 5, 2.68, 3.49, '', 30),
(27, 6, 'PRUEBA01', 1, 36.00, 54.00, '', 50),
(28, 6, 'PRUEBA02', 10, 30.00, 45.00, '', 50),
(30, 7, 'Torta Vainilla', 12, 16.83, 25.24, 'Hollaaaaa', 50),
(33, 7, 'Bizcocho marmoleado', 8, 23.06, 34.60, '', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens_temporales`
--

CREATE TABLE `tokens_temporales` (
  `Id_token` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `fecha_expiracion` datetime NOT NULL,
  `fecha_uso` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `Id_unidad` int(11) NOT NULL,
  `nombre_unidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`Id_unidad`, `nombre_unidad`) VALUES
(1, 'Gramos (gr)'),
(2, 'Kilos (Kg)'),
(3, 'Mililitros (ml)'),
(4, 'Litros (Lt)'),
(5, 'Unidades (Und)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_conversion`
--

CREATE TABLE `unidades_conversion` (
  `Id_unidad` int(11) NOT NULL,
  `nombre_unidad` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `factor_conversion` decimal(10,6) NOT NULL,
  `unidad_base` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id_usuario` int(11) NOT NULL,
  `Nombre` varchar(150) NOT NULL,
  `Correo` varchar(150) NOT NULL,
  `Contraseña` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id_usuario`, `Nombre`, `Correo`, `Contraseña`) VALUES
(4, 'Anyel', 'anyeldaniel0205@gmail.com', '$2y$10$OaXYB.DcIUtU6ruXz2rtEeOTgKVczoT9N7zkYaEZZrLcRDS.ILEHa'),
(5, 'Anyel2', 'anyelsilva0205@gmail.com', '$2y$10$SDTl1QFPszQl5FWxM6vWWu5ERAkM9hcEnHTo8LZyHdCgp6.RbwGLu'),
(6, 'JoséBackend', 'wladimirgarcia145@gmail.com', '$2y$10$BkM9m36S/sdMmOsmja/9zuG7Nd6XJLgP/TtQAHPulzl1b/O9e75iS'),
(7, 'Dulce Delicia', 'garciaandrese2603@gmail.com', '$2y$10$K1ZCxKZyRGplSs53vloXOexlc/3uR.hSsbsP2ovE2tuInk3YKf87K');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `Id_venta` int(11) NOT NULL,
  `Id_produccion` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `cantidad_vendida` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `precio_venta_total` decimal(10,2) NOT NULL,
  `nombre_receta` varchar(50) NOT NULL,
  `fecha_venta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`Id_venta`, `Id_produccion`, `Id_usuario`, `cantidad_vendida`, `precio_unitario`, `precio_venta_total`, `nombre_receta`, `fecha_venta`) VALUES
(1, 20, 7, 5, 2.10, 10.50, 'Torta Vainilla', '2026-02-12 00:00:00'),
(2, 20, 7, 6, 2.10, 12.60, 'Torta Vainilla', '2026-02-12 00:00:00'),
(3, 20, 7, 1, 2.10, 2.10, 'Torta Vainilla', '2026-02-12 00:00:00'),
(4, 22, 7, 3, 4.33, 12.99, 'Bizcocho marmoleado', '2026-02-12 00:00:00'),
(5, 22, 7, 5, 4.33, 21.65, 'Bizcocho marmoleado', '2026-02-12 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `costos_adicionales`
--
ALTER TABLE `costos_adicionales`
  ADD PRIMARY KEY (`Id_costo`),
  ADD KEY `idx_costos_adicionales_receta` (`Id_receta`);

--
-- Indices de la tabla `gastos_adicionales`
--
ALTER TABLE `gastos_adicionales`
  ADD PRIMARY KEY (`Id_gasto`),
  ADD KEY `Id_usuario` (`Id_usuario`);

--
-- Indices de la tabla `gastos_recetas`
--
ALTER TABLE `gastos_recetas`
  ADD PRIMARY KEY (`Id_gasto_receta`),
  ADD KEY `fk_receta` (`Id_receta`),
  ADD KEY `fk_gasto` (`Id_gasto`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`Id_ingrediente`),
  ADD KEY `idx_ingredientes_usuario` (`Id_usuario`) USING BTREE,
  ADD KEY `idx_ingredientes_unidad_base` (`Id_unidad_base`) USING BTREE;

--
-- Indices de la tabla `ingredientes_recetas`
--
ALTER TABLE `ingredientes_recetas`
  ADD PRIMARY KEY (`Id_detalle`),
  ADD KEY `idx_ingredientes_recetas_receta` (`Id_receta`),
  ADD KEY `idx_ingredientes_recetas_ingrediente` (`Id_ingrediente`);

--
-- Indices de la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD PRIMARY KEY (`Id_produccion`),
  ADD KEY `idx_produccion_recetas` (`Id_receta`),
  ADD KEY `index_produccion_usuario` (`Id_usuario`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`Id_receta`),
  ADD KEY `idx_recetas_usuario` (`Id_usuario`);

--
-- Indices de la tabla `tokens_temporales`
--
ALTER TABLE `tokens_temporales`
  ADD PRIMARY KEY (`Id_token`),
  ADD KEY `idx_tokens_usuario` (`Id_usuario`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`Id_unidad`);

--
-- Indices de la tabla `unidades_conversion`
--
ALTER TABLE `unidades_conversion`
  ADD PRIMARY KEY (`Id_unidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id_usuario`),
  ADD UNIQUE KEY `idx_correo_unico` (`Correo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`Id_venta`),
  ADD KEY `idx_ventas_recetas` (`Id_produccion`),
  ADD KEY `idx_produccion_usuarios` (`Id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `costos_adicionales`
--
ALTER TABLE `costos_adicionales`
  MODIFY `Id_costo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gastos_adicionales`
--
ALTER TABLE `gastos_adicionales`
  MODIFY `Id_gasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `gastos_recetas`
--
ALTER TABLE `gastos_recetas`
  MODIFY `Id_gasto_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `Id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `ingredientes_recetas`
--
ALTER TABLE `ingredientes_recetas`
  MODIFY `Id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT de la tabla `produccion`
--
ALTER TABLE `produccion`
  MODIFY `Id_produccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `Id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `tokens_temporales`
--
ALTER TABLE `tokens_temporales`
  MODIFY `Id_token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `Id_unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `unidades_conversion`
--
ALTER TABLE `unidades_conversion`
  MODIFY `Id_unidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `Id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `costos_adicionales`
--
ALTER TABLE `costos_adicionales`
  ADD CONSTRAINT `costos_adicionales_ibfk_1` FOREIGN KEY (`Id_receta`) REFERENCES `recetas` (`Id_receta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `costos_adicionales_ibfk_2` FOREIGN KEY (`Id_costo`) REFERENCES `gastos_adicionales` (`Id_gasto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gastos_adicionales`
--
ALTER TABLE `gastos_adicionales`
  ADD CONSTRAINT `gastos_adicionales_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD CONSTRAINT `ingredientes_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ingredientes_ibfk_2` FOREIGN KEY (`Id_unidad_base`) REFERENCES `unidades` (`Id_unidad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ingredientes_recetas`
--
ALTER TABLE `ingredientes_recetas`
  ADD CONSTRAINT `ingredientes_recetas_ibfk_1` FOREIGN KEY (`Id_receta`) REFERENCES `recetas` (`Id_receta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ingredientes_recetas_ibfk_2` FOREIGN KEY (`Id_ingrediente`) REFERENCES `ingredientes` (`Id_ingrediente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD CONSTRAINT `produccion_ibfk_1` FOREIGN KEY (`Id_receta`) REFERENCES `recetas` (`Id_receta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produccion_ibfk_2` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tokens_temporales`
--
ALTER TABLE `tokens_temporales`
  ADD CONSTRAINT `tokens_temporales_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `unidades_conversion`
--
ALTER TABLE `unidades_conversion`
  ADD CONSTRAINT `unidades_conversion_ibfk_1` FOREIGN KEY (`Id_unidad`) REFERENCES `ingredientes` (`Id_unidad_base`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`Id_produccion`) REFERENCES `produccion` (`Id_produccion`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
