-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2014 a las 17:12:38
-- Versión del servidor: 5.5.36
-- Versión de PHP: 5.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `uvshop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` varchar(4) NOT NULL,
  `id_padre` varchar(4) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `id_padre`, `nombre`) VALUES
('1', '', 'Ollas'),
('2', '', 'Cuchillos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE IF NOT EXISTS `compra` (
  `id_prod` int(11) NOT NULL,
  `id_factura` varchar(4) NOT NULL,
  `cant_prod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `id_factura` varchar(5) NOT NULL,
  `id_cliente` varchar(40) NOT NULL,
  `fecha` date NOT NULL,
  `metodo_pago` varchar(3) NOT NULL,
  `cantidad_productos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE IF NOT EXISTS `imagen` (
  `id_prod` varchar(20) NOT NULL,
  `ruta` varchar(40) NOT NULL,
  `ancho` int(11) NOT NULL,
  `largo` int(11) NOT NULL,
  `extension` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`id_prod`, `ruta`, `ancho`, `largo`, `extension`) VALUES
('01', 'puke-rainbows', 0, 0, 'jpg'),
('02', 'Mandarina-004', 0, 0, 'jpg'),
('03', 'dobbybambola', 0, 0, 'jpg');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `prodpromo`
--
CREATE TABLE IF NOT EXISTS `prodpromo` (
`cod_producto` varchar(20)
,`valor` decimal(10,0)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `empresa_fab` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  `iva` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo`, `nombre`, `empresa_fab`, `descripcion`, `iva`) VALUES
('01', 'Carlos', 'Mi mama', 'Soy una mala persona', 10),
('02', 'Cristian', 'Mi mama', 'Es una pÃ©sima persona', 1),
('03', 'Mauricio', 'DoÃ±a mama de Mauro', 'Una buena persona', 5),
('04', 'Lau', 'Mama Lau', 'Es malaaaaaaaaa', 10),
('05', 'Lau2', 'Mama Lau', 'Es maaaaaaaaaala', 10),
('05', 'Lau3', 'Mama Lau', 'Es mala', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocion`
--

CREATE TABLE IF NOT EXISTS `promocion` (
  `cod_producto` varchar(20) NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `porcetaje_red` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `promocion`
--

INSERT INTO `promocion` (`cod_producto`, `fecha_ini`, `fecha_fin`, `valor`, `porcetaje_red`) VALUES
('01', '2014-03-09', '2014-03-11', '2000', 10);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `promosdeldia`
--
CREATE TABLE IF NOT EXISTS `promosdeldia` (
`nombre` varchar(30)
,`ruta` varchar(40)
,`extension` varchar(6)
,`descripcion` text
,`valor` decimal(10,0)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `id_prod` varchar(20) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `nombre` varchar(25) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `tipo_id` varchar(4) NOT NULL,
  `id` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `fecha_cumple` date NOT NULL,
  `email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura para la vista `prodpromo`
--
DROP TABLE IF EXISTS `prodpromo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prodpromo` AS select `promocion`.`cod_producto` AS `cod_producto`,`promocion`.`valor` AS `valor` from `promocion` where (now() between `promocion`.`fecha_ini` and `promocion`.`fecha_fin`);

-- --------------------------------------------------------

--
-- Estructura para la vista `promosdeldia`
--
DROP TABLE IF EXISTS `promosdeldia`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `promosdeldia` AS select `producto`.`nombre` AS `nombre`,`imagen`.`ruta` AS `ruta`,`imagen`.`extension` AS `extension`,`producto`.`descripcion` AS `descripcion`,`prodpromo`.`valor` AS `valor` from ((`prodpromo` join `producto`) join `imagen`) where ((`prodpromo`.`cod_producto` = `producto`.`codigo`) and (`producto`.`codigo` = `imagen`.`id_prod`));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
