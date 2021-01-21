-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-01-2021 a las 00:14:20
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbproyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `estado` enum('0','1') NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `categoria`, `estado`, `id_usuario`) VALUES
(6, 'Escolares', '1', 1),
(7, 'Variedades', '1', 1),
(8, 'gomas', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `cedula_cliente` varchar(100) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `apellido_cliente` varchar(100) NOT NULL,
  `telefono_cliente` varchar(100) NOT NULL,
  `correo_cliente` varchar(100) NOT NULL,
  `direccion_cliente` varchar(100) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `estado` enum('0','1') NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `cedula_cliente`, `nombre_cliente`, `apellido_cliente`, `telefono_cliente`, `correo_cliente`, `direccion_cliente`, `fecha_ingreso`, `estado`, `id_usuario`) VALUES
(7, '1002308792', 'Nadir', 'Babilonia', '3164627307', 'nadirmarsigliababilonia@gmail.com', 'MZ 24 lt 14', '2020-11-26', '1', 1),
(8, '1211111', 'dilan', 'devoz', '317345678', 'dilan@gmail.com', 'casa lora MZ 24 lt 14', '2020-12-02', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compras` int(11) NOT NULL,
  `fecha_compra` date NOT NULL,
  `numero_compra` varchar(100) NOT NULL,
  `proveedor` varchar(100) NOT NULL,
  `cedula_proveedor` varchar(100) NOT NULL,
  `comprador` varchar(100) NOT NULL,
  `moneda` varchar(100) NOT NULL,
  `subtotal` varchar(100) NOT NULL,
  `total_iva` varchar(100) NOT NULL,
  `total` varchar(100) NOT NULL,
  `tipo_pago` varchar(100) NOT NULL,
  `estado` enum('0','1') NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compras`, `fecha_compra`, `numero_compra`, `proveedor`, `cedula_proveedor`, `comprador`, `moneda`, `subtotal`, `total_iva`, `total`, `tipo_pago`, `estado`, `id_usuario`, `id_proveedor`) VALUES
(9, '2020-11-30', 'F000001', 'purina', '100230', 'nadir de jesus', 'COP$', '4200', '840', '5040', 'EFECTIVO', '1', 1, 5),
(10, '2020-11-30', 'F000002', 'cocacola', '1002308792', 'nadir de jesus', 'COP$', '700', '140', '840', 'EFECTIVO', '1', 1, 6),
(11, '2020-12-02', 'F000003', 'cocacola', '1002308792', 'nadir de jesus', 'COP$', '2400', '480', '2880', 'EFECTIVO', '1', 1, 6),
(12, '2020-12-04', 'F000004', 'cocacola', '1002308792', 'Dilan Sebastian', 'COP$', '35000', '7000', '42000', 'EFECTIVO', '1', 4, 6),
(13, '2020-12-24', 'F000005', 'robles_s', '1234567', 'nadir de jesus', 'COP$', '21000', '4200', '25200', 'EFECTIVO', '1', 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id_detalle_compras` int(11) NOT NULL,
  `numero_compra` varchar(100) NOT NULL,
  `cedula_proveedor` varchar(100) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `moneda` varchar(100) NOT NULL,
  `precio_compra` varchar(100) NOT NULL,
  `cantidad_compra` varchar(100) NOT NULL,
  `descuento` varchar(100) NOT NULL,
  `importe` varchar(100) NOT NULL,
  `fecha_compra` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `estado` enum('0','1') NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id_detalle_compras`, `numero_compra`, `cedula_proveedor`, `id_producto`, `producto`, `moneda`, `precio_compra`, `cantidad_compra`, `descuento`, `importe`, `fecha_compra`, `id_usuario`, `id_proveedor`, `estado`, `id_categoria`) VALUES
(12, 'F000001', '100230', 13, 'sabanas', 'COP$', '350', '12', '0', '4200', '2020-11-30', 1, 5, '1', 6),
(13, 'F000002', '1002308792', 14, 'cocacola litro', 'COP$', '350', '2', '0', '700', '2020-11-30', 1, 6, '1', 7),
(14, 'F000003', '1002308792', 15, 'colbon ', 'COP$', '200', '12', '0', '2400', '2020-12-02', 1, 6, '1', 8),
(15, 'F000004', '1002308792', 14, 'cocacola litro', 'COP$', '350', '100', '0', '35000', '2020-12-04', 4, 6, '1', 7),
(16, 'F000005', '1234567', 14, 'cocacola litro', 'COP$', '350', '60', '0', '21000', '2020-12-24', 1, 8, '1', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id_detalle_ventas` int(11) NOT NULL,
  `numero_venta` varchar(100) NOT NULL,
  `cedula_cliente` varchar(100) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `moneda` varchar(100) NOT NULL,
  `precio_venta` varchar(100) NOT NULL,
  `cantidad_venta` varchar(100) NOT NULL,
  `descuento` varchar(100) NOT NULL,
  `importe` varchar(100) NOT NULL,
  `fecha_venta` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `estado` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id_detalle_ventas`, `numero_venta`, `cedula_cliente`, `id_producto`, `producto`, `moneda`, `precio_venta`, `cantidad_venta`, `descuento`, `importe`, `fecha_venta`, `id_usuario`, `id_cliente`, `estado`) VALUES
(15, 'F000001', '1002308792', 9, 'jabon casa', 'COP$', '200', '2', '0', '400', '2020-11-30', 1, 7, '1'),
(16, 'F000002', '1002308792', 13, 'sabanas', 'COP$', '355', '1', '0', '355', '2020-11-30', 1, 7, '1'),
(17, 'F000003', '1002308792', 14, 'cocacola litro', 'COP$', '355', '1', '0', '355', '2020-11-30', 1, 7, '1'),
(18, 'F000004', '1211111', 14, 'cocacola litro', 'COP$', '355', '1', '0', '355', '2020-12-02', 1, 8, '1'),
(19, 'F000004', '1211111', 15, 'colbon ', 'COP$', '300', '2', '0', '600', '2020-12-02', 1, 8, '1'),
(20, 'F000005', '1211111', 15, 'colbon ', 'COP$', '300', '2', '0', '600', '2020-12-02', 1, 8, '1'),
(21, 'F000005', '1211111', 9, 'Caja de Colores Prismacolor x 15', '$', '200', '1', '0', '200', '2020-12-02', 1, 8, '1'),
(22, 'F000006', '1211111', 9, 'Caja de Colores Prismacolor x 15', '$', '200', '5', '0', '1000', '2020-12-02', 3, 8, '1'),
(23, 'F000007', '1002308792', 15, 'colbon ', 'COP$', '300', '1', '0', '300', '2020-12-03', 1, 7, '1'),
(24, 'F000007', '1002308792', 9, 'Caja de Colores Prismacolor x 15', 'COP$', '200', '1', '0', '200', '2020-12-03', 1, 7, '1'),
(25, 'F000007', '1002308792', 13, 'sabanas', 'COP$', '355', '1', '0', '355', '2020-12-03', 1, 7, '1'),
(26, 'F000008', '1211111', 14, 'cocacola litro', 'COP$', '355', '50', '20', '14200', '2020-12-04', 4, 8, '1'),
(27, 'F000009', '1002308792', 14, 'cocacola litro', 'COP$', '355', '1', '0', '355', '2021-01-17', 1, 7, '1'),
(28, 'F000009', '1002308792', 15, 'colbon ', 'COP$', '300', '1', '0', '300', '2021-01-17', 1, 7, '1'),
(29, 'F000009', '1002308792', 9, 'Caja de Colores Prismacolor x 15', 'COP$', '200', '1', '0', '200', '2021-01-17', 1, 7, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `cedula_empresa` varchar(100) NOT NULL,
  `nombre_empresa` varchar(100) NOT NULL,
  `direccion_empresa` varchar(100) NOT NULL,
  `correo_empresa` varchar(100) NOT NULL,
  `telefono_empresa` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `cedula_empresa`, `nombre_empresa`, `direccion_empresa`, `correo_empresa`, `telefono_empresa`, `id_usuario`) VALUES
(1, '104442', 'Los 7 Colores', 'villas de la candelaria', 'los7colores@gmail.com', '300234567', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre`) VALUES
(1, 'Categoria'),
(2, 'Productos'),
(3, 'Proveedores'),
(4, 'Compras'),
(5, 'Clientes'),
(6, 'Ventas'),
(7, 'Reporte de Compras'),
(8, 'Reporte de Ventas'),
(9, 'Usuarios'),
(10, 'Empresa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `presentacion` varchar(100) NOT NULL,
  `moneda` varchar(45) NOT NULL,
  `precio_compra` varchar(45) NOT NULL,
  `precio_venta` varchar(45) NOT NULL,
  `stock` varchar(45) NOT NULL,
  `estado` enum('0','1') NOT NULL,
  `imagen` varchar(45) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `id_categoria`, `producto`, `presentacion`, `moneda`, `precio_compra`, `precio_venta`, `stock`, `estado`, `imagen`, `fecha_vencimiento`, `id_usuario`) VALUES
(9, 6, 'Caja de Colores Prismacolor x 15', 'Caja', 'COP$', '150', '200', '12', '1', '982808330.jpg', '2021-01-29', 1),
(13, 6, 'sabanas', 'Caja', 'COP$', '350', '355', '10', '1', '1146354162.jpg', '2020-11-03', 1),
(14, 7, 'cocacola litro', 'unidad', 'COP$', '350', '355', '109', '1', '582916019.5L', '2021-05-07', 1),
(15, 8, 'colbon ', 'unidad', 'COP$', '200', '300', '6', '1', '1647639027.jpg', '2021-05-07', 1),
(16, 8, 'colbon de dos unidades', 'Caja', 'COP$', '300', '400', '0', '1', '1843641819.jpg', '2021-01-13', 1),
(18, 7, 'exelent', 'Caja', 'COP$', '2000', '5000', '0', '1', '2000882875.jpg', '2020-12-25', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `cedula` varchar(45) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `fecha` date NOT NULL,
  `estado` enum('0','1') NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `cedula`, `razon_social`, `telefono`, `correo`, `direccion`, `fecha`, `estado`, `id_usuario`) VALUES
(5, '100230', 'purina', '8005464085', 'ia@gmail.com', 'Wilmington St\r\ncaldas 12', '2020-11-30', '1', 1),
(6, '1002308792', 'cocacola', '8005464085', 'cocacola@gmail.com', 'Wilmington St\r\ncaldas 12', '2020-11-30', '1', 1),
(7, '1211111', 'purina_dilan devoz', '8005464085', 'dilan2@gmail.com', 'Wilmington St\r\ncaldas 12', '2020-12-02', '1', 1),
(8, '1234567', 'robles_s', '12342', 'dismelzona90@dismelltda.com', 'q2f3', '2020-12-24', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `cedula` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `cargo` enum('0','1') NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `password2` varchar(100) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `estado` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombres`, `apellidos`, `cedula`, `telefono`, `correo`, `direccion`, `cargo`, `usuario`, `password`, `password2`, `fecha_ingreso`, `estado`) VALUES
(1, 'nadir de jesus', 'marsiglia babilonia', '1002308792', '3164627307', 'nadirmarsigliababilonia@gmail.com', 'cartagena de indias\r\nurb.villas de la candelar mz-24 lt-14', '1', 'nadir', 'nadirmb26', 'nadirmb26', '2017-12-26', '1'),
(3, 'Dairo', 'Babilonia', '1002308792', '3162513544', 'nadir@gmail.com', 'MZ 24 lt 14', '0', 'vendedor', '123', '123', '2020-11-26', '1'),
(4, 'Dilan Sebastian', 'Devoz Cardona', '1002390521', '3015131745', 'dilan@gmail.com', 'calle del coco', '1', 'Dilan', 'dilan1', 'dilan1', '2020-12-04', '1'),
(5, 'cesar', 'robles', '1100399420', '3205737910', 'cesar@hotmail.com', 'la granja mz j lote 11', '1', 'cesar', 'napoles', 'napoles', '2020-12-24', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `id_usuario_permiso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`id_usuario_permiso`, `id_usuario`, `id_permiso`) VALUES
(110, 1, 1),
(111, 1, 2),
(112, 1, 3),
(113, 1, 4),
(114, 1, 5),
(115, 1, 6),
(116, 1, 7),
(117, 1, 8),
(118, 1, 9),
(119, 1, 10),
(175, 3, 6),
(176, 3, 8),
(177, 4, 1),
(178, 4, 2),
(179, 4, 3),
(180, 4, 4),
(181, 4, 5),
(182, 4, 6),
(183, 4, 7),
(184, 4, 8),
(185, 4, 9),
(186, 4, 10),
(187, 5, 1),
(188, 5, 2),
(189, 5, 3),
(190, 5, 4),
(191, 5, 5),
(192, 5, 6),
(193, 5, 7),
(194, 5, 8),
(195, 5, 9),
(196, 5, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_ventas` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `numero_venta` varchar(100) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  `cedula_cliente` varchar(100) NOT NULL,
  `vendedor` varchar(100) NOT NULL,
  `moneda` varchar(100) NOT NULL,
  `subtotal` varchar(100) NOT NULL,
  `total_iva` varchar(100) NOT NULL,
  `total` varchar(100) NOT NULL,
  `tipo_pago` varchar(100) NOT NULL,
  `estado` enum('0','1') NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_ventas`, `fecha_venta`, `numero_venta`, `cliente`, `cedula_cliente`, `vendedor`, `moneda`, `subtotal`, `total_iva`, `total`, `tipo_pago`, `estado`, `id_usuario`, `id_cliente`) VALUES
(9, '2020-11-30', 'F000001', 'Nadir', '1002308792', 'nadir de jesus', 'COP$', '400', '80', '480', 'EFECTIVO', '1', 1, 7),
(10, '2020-11-30', 'F000002', 'Nadir', '1002308792', 'nadir de jesus', 'COP$', '355', '71', '426', 'EFECTIVO', '1', 1, 7),
(11, '2020-11-30', 'F000003', 'Nadir', '1002308792', 'nadir de jesus', 'COP$', '355', '71', '426', 'EFECTIVO', '1', 1, 7),
(12, '2020-12-02', 'F000004', 'dilan', '1211111', 'nadir de jesus', 'COP$', '955', '191', '1146', 'TRANSFERENCIA', '1', 1, 8),
(13, '2020-12-02', 'F000005', 'dilan', '1211111', 'nadir de jesus', 'COP$', '800', '160', '960', 'EFECTIVO', '1', 1, 8),
(14, '2020-12-02', 'F000006', 'dilan', '1211111', 'Dairo', 'COP$', '1000', '200', '1200', 'EFECTIVO', '1', 3, 8),
(15, '2020-12-03', 'F000007', 'Nadir', '1002308792', 'nadir de jesus', 'COP$', '855', '171', '1026', 'EFECTIVO', '1', 1, 7),
(16, '2020-12-04', 'F000008', 'dilan', '1211111', 'Dilan Sebastian', 'COP$', '14200', '2840', '17040', 'EFECTIVO', '1', 4, 8),
(17, '2021-01-17', 'F000009', 'Nadir', '1002308792', 'nadir de jesus', 'COP$', '855', '171', '1026', 'EFECTIVO', '1', 1, 7);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `fk_categoria_usuarios_idx` (`id_usuario`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `fk_clientes_usuario_idx` (`id_usuario`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compras`),
  ADD KEY `fk_compras_usuario_idx` (`id_usuario`),
  ADD KEY `fk_compras_proveedor_idx` (`id_proveedor`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id_detalle_compras`),
  ADD KEY `fk_detalle_compras_producto_idx` (`id_producto`),
  ADD KEY `fk_detalle_compras_usuario_idx` (`id_usuario`),
  ADD KEY `fk_detalle_compras_proveedor_idx` (`id_proveedor`),
  ADD KEY `fk_detalle_compras_categoria_idx` (`id_categoria`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id_detalle_ventas`),
  ADD KEY `fk_detalle_ventas_producto_idx` (`id_producto`),
  ADD KEY `fk_detalle_ventas_usuario_idx` (`id_usuario`),
  ADD KEY `fk_detalle_ventas_clientes_idx` (`id_cliente`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`),
  ADD KEY `fk_empresa_usuario_idx` (`id_usuario`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_categoria_idx` (`id_categoria`),
  ADD KEY `fk_producto_usuario_idx` (`id_usuario`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD KEY `fk_proveedor_usuario_idx` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`id_usuario_permiso`),
  ADD KEY `fk_usuario_permiso_usuario_idx` (`id_usuario`),
  ADD KEY `fk_usuario_permiso_permiso_idx` (`id_permiso`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_ventas`),
  ADD KEY `fk_ventas_usuario_idx` (`id_usuario`),
  ADD KEY `fk_ventas_cliente_idx` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id_detalle_compras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id_detalle_ventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `id_usuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_ventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_categoria_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compras_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `fk_detalle_compras_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_compras_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_compras_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_compras_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `fk_detalle_ventas_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_ventas_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_ventas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_empresa_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_proveedor_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `fk_usuario_permiso_permiso` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permiso_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ventas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
