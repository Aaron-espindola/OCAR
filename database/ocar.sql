-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-09-2024 a las 20:24:42
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
-- Base de datos: `ocar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id_adm` int(225) NOT NULL,
  `nombre_adm` varchar(225) NOT NULL,
  `apellido_adm` varchar(225) NOT NULL,
  `email_adm` varchar(225) NOT NULL,
  `passsword` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id_adm`, `nombre_adm`, `apellido_adm`, `email_adm`, `passsword`) VALUES
(9, 'Trencito', 'Tactico', 'Trencito.TK@gmail.com', '$2y$10$ZXBgJydGc61.Pco/nsaAo.PqYYw3.V7uhivvjqzLpsslRJysarsum'),
(10, 'Aaron', 'Espindola', 'aaronthxmas@gmail.com', '$2y$10$tKCaZ2kb6y4MJ75wxLWG0.WXBxO0jqvVclca0SijruiOojFrrqAlW');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arreglo`
--

CREATE TABLE `arreglo` (
  `id_arreglo` int(5) NOT NULL,
  `fecha_ingr` date NOT NULL,
  `fecha_salida` date DEFAULT NULL,
  `desc_arreglo` text NOT NULL,
  `kilometros` int(10) NOT NULL,
  `patente` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `arreglo`
--

INSERT INTO `arreglo` (`id_arreglo`, `fecha_ingr`, `fecha_salida`, `desc_arreglo`, `kilometros`, `patente`) VALUES
(42, '2024-09-03', '0000-00-00', 'Cambios en el motor, cambios en las pinzas de frenos, ajustes en la transmisión ', 23000, 'AB 776 CZ '),
(43, '2024-09-15', '0000-00-00', 'Ajustes en el motor, cambios de los rings de las ruedas.', 25000, 'AB 776 CZ ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(5) NOT NULL,
  `nombre_c` varchar(30) NOT NULL,
  `apellido_c` varchar(30) NOT NULL,
  `alias` varchar(40) DEFAULT NULL,
  `dni` int(10) DEFAULT NULL,
  `correo_c` varchar(100) DEFAULT NULL,
  `telefono` int(14) NOT NULL,
  `calle` varchar(30) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `localidad` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre_c`, `apellido_c`, `alias`, `dni`, `correo_c`, `telefono`, `calle`, `numero`, `localidad`) VALUES
(49, 'Camila Belen', 'García', 'Camilucky', 12456789, 'cami_garcia@gmail.com', 12345672, 'sunchales ', 6399, 'Gonzalez Catan'),
(50, 'Mateo', 'Espindola', 'Matu', 12345678, 'Mateo.Espi@gmail.com', 1112332451, 'cepeda', 3338, 'Gonzalez Catan'),
(51, 'Violeta', 'Avalos', 'Lali', 2368012, 'ayelen_099@outlook.com', 234293785, 'Barrientos', 4268, 'Gonzalez Catan'),
(52, 'Leon', 'Kennedy', 'LSK', 42775232, 'Leon.s.kennedy@gmail.com', 1133942854, 'sunchales ', 4268, 'Palermo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comp_extra`
--

CREATE TABLE `comp_extra` (
  `id_extra` int(11) NOT NULL,
  `desc_componente` varchar(50) DEFAULT NULL,
  `valor_componente` float DEFAULT NULL,
  `id_arreglo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comp_extra`
--

INSERT INTO `comp_extra` (`id_extra`, `desc_componente`, `valor_componente`, `id_arreglo`) VALUES
(41, 'Componente 1', 15000, 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `textColor` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `title`, `descripcion`, `color`, `textColor`, `start`, `end`) VALUES
(1, 'Evento 1', 'Apertura de OCAR al publico!', '#000000', '#FFFFFF', '2024-04-01 00:00:00', '2024-04-01 00:00:00'),
(9, 'Prueba titulo 3', 'descripcion 3', '#ff0000', '#FFFFFF', '2024-04-16 17:48:00', '2024-04-16 17:48:00'),
(11, 'Prueba 5', ' Descripcion de prueba 5', '#10ad93', '#FFFFFF', '2024-04-11 09:00:00', '2024-04-11 09:00:00'),
(12, ' Te quiero muchito <3', ' Calendario Terminado!\n', '#190bd5', '#FFFFFF', '2024-04-18 18:13:00', '2024-04-18 18:13:00'),
(13, ' Titulo 3', ' Descripcion 3', '#3bc1e3', '#FFFFFF', '2024-04-14 16:00:00', '2024-04-14 16:00:00'),
(14, ' Titulo 4', ' Descripcion 4 ', '#d80e0e', '#FFFFFF', '2024-04-14 12:53:00', '2024-04-14 12:53:00'),
(15, ' - Prueba de titulo evento 2', ' scascasc', '#000000', '#FFFFFF', '2024-04-14 09:00:00', '2024-04-14 09:00:00'),
(16, ' Titulo 7', ' ksxkdtsxlucclu', '#e71313', '#FFFFFF', '2024-05-03 08:29:00', '2024-05-03 08:29:00'),
(17, ' Titulo de prueba', ' Desc de prueba xd', '#e90707', '#FFFFFF', '2024-09-13 15:30:00', '2024-09-13 15:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(5) NOT NULL,
  `fecha_pago` date NOT NULL,
  `monto` float NOT NULL,
  `forma_pago` varchar(20) NOT NULL,
  `id_presupuesto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto`
--

CREATE TABLE `presupuesto` (
  `id_presupuesto` int(11) NOT NULL,
  `mano_obra` int(10) NOT NULL,
  `monto_total` int(225) NOT NULL,
  `id_repuesto` int(11) NOT NULL,
  `id_extra` int(11) DEFAULT NULL,
  `id_arreglo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuesto`
--

INSERT INTO `presupuesto` (`id_presupuesto`, `mano_obra`, `monto_total`, `id_repuesto`, `id_extra`, `id_arreglo`) VALUES
(109, 5000, 220000, 52, 41, 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repuestos`
--

CREATE TABLE `repuestos` (
  `id_repuesto` int(5) NOT NULL,
  `desc_repuesto` text NOT NULL,
  `reparacion` char(2) NOT NULL,
  `valor_reparacion` float DEFAULT NULL,
  `lugar_reparacion` varchar(30) DEFAULT NULL,
  `compra` char(2) NOT NULL,
  `valor_compra` float DEFAULT NULL,
  `lugar_compra` varchar(30) DEFAULT NULL,
  `origen_repuesto` varchar(50) DEFAULT NULL,
  `id_arreglo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `repuestos`
--

INSERT INTO `repuestos` (`id_repuesto`, `desc_repuesto`, `reparacion`, `valor_reparacion`, `lugar_reparacion`, `compra`, `valor_compra`, `lugar_compra`, `origen_repuesto`, `id_arreglo`) VALUES
(50, 'Nuevas bujías para el motor', 'no', 0, '', 'si', 150000, 'LaFiat', 'taller', 42),
(51, 'Nuevas pinzas de frenos brembo x4', 'no', 0, '', 'si', 0, '', 'cliente', 42),
(52, 'Ajuste de la transmisión a una transmisión más suave y de competición para circuitos de carreras ', 'si', 50000, 'Taller', 'no', 0, '', '-', 42),
(53, 'Cambio de electrónica', 'no', 0, '', 'si', 15000, 'Taller', 'taller', 43),
(54, 'Cambio de rings ', 'no', 0, '', 'si', 0, '', 'cliente', 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `patente` varchar(10) NOT NULL,
  `marca` varchar(20) NOT NULL,
  `modelo` varchar(25) NOT NULL,
  `anio` int(5) NOT NULL,
  `color` varchar(15) NOT NULL,
  `motor` varchar(100) NOT NULL,
  `combustible` varchar(100) NOT NULL,
  `transmision` varchar(100) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`patente`, `marca`, `modelo`, `anio`, `color`, `motor`, `combustible`, `transmision`, `id_cliente`) VALUES
('AB 123 CC', 'Toyota', 'Supra MK4', 2015, 'Naranja', '', '', '', 50),
('AB 776 CZ', 'Subaru', 'WRX STI', 2014, 'azul', '2.4-liter DOHC', 'Nafta', 'Symmetrical All-Wheel Drive', 52);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_adm`);

--
-- Indices de la tabla `arreglo`
--
ALTER TABLE `arreglo`
  ADD PRIMARY KEY (`id_arreglo`),
  ADD KEY `fk_patente` (`patente`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `comp_extra`
--
ALTER TABLE `comp_extra`
  ADD PRIMARY KEY (`id_extra`),
  ADD KEY `fk_arreglo2` (`id_arreglo`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_presupuesto` (`id_presupuesto`);

--
-- Indices de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  ADD PRIMARY KEY (`id_presupuesto`),
  ADD KEY `fk_repuesto` (`id_repuesto`),
  ADD KEY `fk_extra` (`id_extra`),
  ADD KEY `fk_arreglo3` (`id_arreglo`);

--
-- Indices de la tabla `repuestos`
--
ALTER TABLE `repuestos`
  ADD PRIMARY KEY (`id_repuesto`),
  ADD KEY `fk_arreglo` (`id_arreglo`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`patente`),
  ADD KEY `fk_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id_adm` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `arreglo`
--
ALTER TABLE `arreglo`
  MODIFY `id_arreglo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `comp_extra`
--
ALTER TABLE `comp_extra`
  MODIFY `id_extra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT de la tabla `repuestos`
--
ALTER TABLE `repuestos`
  MODIFY `id_repuesto` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `arreglo`
--
ALTER TABLE `arreglo`
  ADD CONSTRAINT `fk_patente` FOREIGN KEY (`patente`) REFERENCES `vehiculo` (`patente`);

--
-- Filtros para la tabla `comp_extra`
--
ALTER TABLE `comp_extra`
  ADD CONSTRAINT `fk_arreglo2` FOREIGN KEY (`id_arreglo`) REFERENCES `arreglo` (`id_arreglo`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_presupuesto` FOREIGN KEY (`id_presupuesto`) REFERENCES `presupuesto` (`id_presupuesto`);

--
-- Filtros para la tabla `presupuesto`
--
ALTER TABLE `presupuesto`
  ADD CONSTRAINT `fk_arreglo3` FOREIGN KEY (`id_arreglo`) REFERENCES `arreglo` (`id_arreglo`),
  ADD CONSTRAINT `fk_extra` FOREIGN KEY (`id_extra`) REFERENCES `comp_extra` (`id_extra`),
  ADD CONSTRAINT `fk_repuesto` FOREIGN KEY (`id_repuesto`) REFERENCES `repuestos` (`id_repuesto`);

--
-- Filtros para la tabla `repuestos`
--
ALTER TABLE `repuestos`
  ADD CONSTRAINT `fk_arreglo` FOREIGN KEY (`id_arreglo`) REFERENCES `arreglo` (`id_arreglo`);

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
