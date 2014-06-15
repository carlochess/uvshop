
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- compra
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `compra`;

CREATE TABLE `compra`
(
    `id_prod` VARCHAR(10),
    `id_compra` INTEGER NOT NULL AUTO_INCREMENT,
    `id_factura` INTEGER(4),
    `cant_prod` INTEGER NOT NULL,
    `valor` DECIMAL NOT NULL,
    `iva` TINYINT NOT NULL,
    `porcetaje_red` SMALLINT NOT NULL,
    PRIMARY KEY (`id_compra`),
    INDEX `id_prod` (`id_prod`(10)),
    INDEX `id_factura` (`id_factura`(4)),
    CONSTRAINT `compra_ibfk_1`
        FOREIGN KEY (`id_factura`)
        REFERENCES `factura` (`id_factura`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- factura
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `factura`;

CREATE TABLE `factura`
(
    `id_factura` INTEGER(5) NOT NULL AUTO_INCREMENT,
    `id_cliente` VARCHAR(40) NOT NULL,
    `fecha` DATE NOT NULL,
    `cantidad_productos` INTEGER NOT NULL,
    `valor` DECIMAL NOT NULL,
    `iva` TINYINT NOT NULL,
    PRIMARY KEY (`id_factura`),
    INDEX `factura_ibfk_1` (`id_cliente`(40)),
    CONSTRAINT `factura_ibfk_1`
        FOREIGN KEY (`id_cliente`)
        REFERENCES `producto` (`id_prod`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- imagen
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `imagen`;

CREATE TABLE `imagen`
(
    `id_imagen` INTEGER NOT NULL AUTO_INCREMENT,
    `id_prod` VARCHAR(10) NOT NULL,
    `ruta` VARCHAR(40) NOT NULL,
    `ancho` INTEGER NOT NULL,
    `largo` INTEGER NOT NULL,
    `extension` VARCHAR(6) NOT NULL,
    PRIMARY KEY (`id_imagen`),
    INDEX `id_prod` (`id_prod`(10)),
    CONSTRAINT `imagen_ibfk_1`
        FOREIGN KEY (`id_prod`)
        REFERENCES `producto` (`id_prod`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- metodo_pago
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `metodo_pago`;

CREATE TABLE `metodo_pago`
(
    `id_factura` INTEGER(5) NOT NULL,
    `id_pago` INTEGER(40) NOT NULL AUTO_INCREMENT,
    `tipo` VARCHAR(3) NOT NULL,
    `cuotas` INTEGER NOT NULL,
    `monto` INTEGER,
    PRIMARY KEY (`id_pago`),
    INDEX `id_factura` (`id_factura`(5)),
    CONSTRAINT `metodo_pago_ibfk_1`
        FOREIGN KEY (`id_factura`)
        REFERENCES `factura` (`id_factura`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- precio
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `precio`;

CREATE TABLE `precio`
(
    `id_precio` INTEGER NOT NULL AUTO_INCREMENT,
    `cod_producto` VARCHAR(20),
    `fecha_ini` DATE NOT NULL,
    `fecha_fin` DATE NOT NULL,
    `valor` DECIMAL NOT NULL,
    PRIMARY KEY (`id_precio`),
    INDEX `precio_ibfk_1` (`cod_producto`(20)),
    CONSTRAINT `precio_ibfk_1`
        FOREIGN KEY (`cod_producto`)
        REFERENCES `producto` (`id_prod`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- producto
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto`
(
    `id_prod` VARCHAR(10) DEFAULT '' NOT NULL,
    `nombre` VARCHAR(30) NOT NULL,
    `empresa_fab` VARCHAR(20) NOT NULL,
    `descripcion` TEXT NOT NULL,
    `iva` TINYINT NOT NULL,
    `categoria` VARCHAR(25),
    `unidades` INTEGER,
    PRIMARY KEY (`id_prod`),
    INDEX `id_categoria` (`categoria`(25))
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- promocion
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `promocion`;

CREATE TABLE `promocion`
(
    `id_promocion` INTEGER NOT NULL AUTO_INCREMENT,
    `cod_producto` VARCHAR(20),
    `fecha_ini` DATE NOT NULL,
    `fecha_fin` DATE NOT NULL,
    `valor` DECIMAL NOT NULL,
    `porcetaje_red` SMALLINT NOT NULL,
    PRIMARY KEY (`id_promocion`),
    INDEX `cod_producto` (`cod_producto`(20)),
    CONSTRAINT `promocion_ibfk_1`
        FOREIGN KEY (`cod_producto`)
        REFERENCES `producto` (`id_prod`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- usuario
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario`
(
    `nombre` VARCHAR(25) NOT NULL,
    `apellidos` VARCHAR(30) NOT NULL,
    `tipo_id` VARCHAR(4) NOT NULL,
    `id` VARCHAR(20) NOT NULL,
    `telefono` VARCHAR(20) NOT NULL,
    `fecha_cumple` DATE NOT NULL,
    `email` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
