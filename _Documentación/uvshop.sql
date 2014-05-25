SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `compra` (
  `id_prod` varchar(10) DEFAULT NULL,
  `id_compra` int(11) NOT NULL AUTO_INCREMENT,
  `id_factura` int(4) DEFAULT NULL,
  `cant_prod` int(11) NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `iva` tinyint(4) NOT NULL,
  `porcetaje_red` smallint(6) NOT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `id_prod` (`id_prod`),
  KEY `id_factura` (`id_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `factura` (
  `id_factura` int(5) NOT NULL AUTO_INCREMENT,
  `id_cliente` varchar(40) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad_productos` int(11) NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `iva` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_factura`),
  KEY `factura_ibfk_1` (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

CREATE TABLE IF NOT EXISTS `imagen` (
  `id_imagen` int(11) NOT NULL AUTO_INCREMENT,
  `id_prod` varchar(10) NOT NULL,
  `ruta` varchar(40) NOT NULL,
  `ancho` int(11) NOT NULL,
  `largo` int(11) NOT NULL,
  `extension` varchar(6) NOT NULL,
  PRIMARY KEY (`id_imagen`),
  KEY `id_prod` (`id_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `metodo_pago` (
  `id_factura` int(5) NOT NULL,
  `id_pago` int(40) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(3) NOT NULL,
  `cuotas` int(11) NOT NULL,
  `monto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `id_factura` (`id_factura`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

CREATE TABLE IF NOT EXISTS `precio` (
  `id_precio` int(11) NOT NULL AUTO_INCREMENT,
  `cod_producto` varchar(20) DEFAULT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_precio`),
  KEY `precio_ibfk_1` (`cod_producto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

CREATE TABLE IF NOT EXISTS `producto` (
  `id_prod` varchar(10) NOT NULL DEFAULT '',
  `nombre` varchar(30) NOT NULL,
  `empresa_fab` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  `iva` tinyint(4) NOT NULL,
  `categoria` varchar(25) DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_prod`),
  KEY `id_categoria` (`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `promocion` (
  `id_promocion` int(11) NOT NULL AUTO_INCREMENT,
  `cod_producto` varchar(20) DEFAULT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `porcetaje_red` smallint(6) NOT NULL,
  PRIMARY KEY (`id_promocion`),
  KEY `cod_producto` (`cod_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `usuario` (
  `nombre` varchar(25) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `tipo_id` varchar(4) NOT NULL,
  `id` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `fecha_cumple` date NOT NULL,
  `email` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE;

ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `producto` (`id_prod`) ON DELETE CASCADE;

ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `producto` (`id_prod`) ON DELETE CASCADE;

ALTER TABLE `metodo_pago`
  ADD CONSTRAINT `metodo_pago_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE;

ALTER TABLE `precio`
  ADD CONSTRAINT `precio_ibfk_1` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `promocion`
  ADD CONSTRAINT `promocion_ibfk_1` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`id_prod`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
