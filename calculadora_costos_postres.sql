-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-01-2026 a las 04:17:49
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
(32, 1, 2, 'Harina de Trigo', 0.00, 1.00, 6.0000),
(33, 1, 2, 'Azúcar', 0.00, 1.00, 5.0000),
(34, 1, 5, 'Huevos', 0.00, 24.00, 7.3000),
(35, 1, 4, 'Leche', 0.00, 1.00, 4.7500),
(36, 1, 1, 'Cacao en Polvo', 0.00, 500.00, 2.8000),
(37, 1, 5, 'P01', 0.00, 100.00, 100.0000);

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
(117, 11, 32, 2.50, 'unidad'),
(118, 11, 33, 1.50, 'unidad'),
(119, 11, 34, 8.00, 'unidad'),
(120, 11, 35, 1.00, 'unidad'),
(121, 11, 36, 500.00, 'unidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `Id_receta` int(11) NOT NULL,
  `Id_usuario` int(11) NOT NULL,
  `nombre_postre` varchar(150) NOT NULL,
  `porciones` int(11) NOT NULL,
  `costo_ingredientes` decimal(10,2) DEFAULT NULL,
  `precio_venta_sug` decimal(10,2) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `porcentaje_ganancia` int(11) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`Id_receta`, `Id_usuario`, `nombre_postre`, `porciones`, `costo_ingredientes`, `precio_venta_sug`, `notas`, `porcentaje_ganancia`) VALUES
(11, 1, 'Torta de Chocolate', 8, 32.48, 64.97, NULL, 50);

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
(1, 'José', 'josewladimirgarcia17@gmail.com', '$2y$10$824G0Yhg.35dVZwXrNlW.OXPDHsNH2h7IJL4s0/xl9vGwuzIkaVv.');

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `costos_adicionales`
--
ALTER TABLE `costos_adicionales`
  MODIFY `Id_costo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `Id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `ingredientes_recetas`
--
ALTER TABLE `ingredientes_recetas`
  MODIFY `Id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `Id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tokens_temporales`
--
ALTER TABLE `tokens_temporales`
  MODIFY `Id_token` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `Id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `costos_adicionales`
--
ALTER TABLE `costos_adicionales`
  ADD CONSTRAINT `costos_adicionales_ibfk_1` FOREIGN KEY (`Id_receta`) REFERENCES `recetas` (`Id_receta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD CONSTRAINT `ingredientes_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ingredientes_recetas`
--
ALTER TABLE `ingredientes_recetas`
  ADD CONSTRAINT `ingredientes_recetas_ibfk_1` FOREIGN KEY (`Id_receta`) REFERENCES `recetas` (`Id_receta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ingredientes_recetas_ibfk_2` FOREIGN KEY (`Id_ingrediente`) REFERENCES `ingredientes` (`Id_ingrediente`) ON DELETE CASCADE ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
