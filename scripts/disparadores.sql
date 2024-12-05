 compania;
-- tablas para llevar registro de la bitacora plantas
CREATE TABLE BITACORA_PLANTAS (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idPlanta INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Disparador para cuando se inserte una planta
DELIMITER $$

CREATE TRIGGER AFTER_INSERT_PLANTAS 
AFTER INSERT ON PLANTAS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_PLANTAS (idPlanta, accion, descripcion)
    VALUES (NEW.idPlanta, 'INSERT', CONCAT('Se creó la planta con ID: ', NEW.idPlanta));
END$$

DELIMITER ;

--Disparador para cuando se actualice una planta
DELIMITER $$

CREATE TRIGGER AFTER_UPDATE_PLANTAS
AFTER UPDATE ON PLANTAS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_PLANTAS (idPlanta, accion, descripcion)
    VALUES (OLD.idPlanta, 'UPDATE', CONCAT('Se actualizo la planta con ID: ', OLD.idPlanta));
END$$

DELIMITER ;


--Disparador para cuando se elimine una planta
DELIMITER $$

CREATE TRIGGER after_delete_plantas
AFTER DELETE ON PLANTAS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_PLANTAS (idPlanta, accion, descripcion)
    VALUES (OLD.idPlanta, 'DELETE', CONCAT('Se elimino la planta con ID: ', OLD.idPlanta));
END$$

DELIMITER ;


-- tabla para llevar registro de la bitacora CLIENTES
CREATE TABLE BITACORA_CLIENTES (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idCliente INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Disparador para cuando se inserte un cliente
DELIMITER $$

CREATE TRIGGER AFTER_INSERT_CLIENTES 
AFTER INSERT ON CLIENTES
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_CLIENTES(idCliente, accion, descripcion)
    VALUES (NEW.idCliente, 'INSERT', CONCAT('Se creó la planta con ID: ', NEW.idCliente));
END$$

DELIMITER ;

-- Disparador para cuando se actualice un cliente
DELIMITER $$

CREATE TRIGGER AFTER_UPDATE_CLIENTES
AFTER UPDATE ON CLIENTES
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_CLIENTES (idCliente, accion, descripcion)
    VALUES (OLD.idCliente, 'UPDATE', CONCAT('Se actualizo el cliente con ID: ', OLD.idCliente));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un cliente
DELIMITER $$

CREATE TRIGGER AFTER_DELETE_CLIENTES
AFTER DELETE ON CLIENTES
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_CLIENTES (idCliente, accion, descripcion)
    VALUES (OLD.idCliente, 'DELETE', CONCAT('Se elimino el cliente con ID: ', OLD.idCliente));
END$$

DELIMITER ; 

-- tabla para llevar registro de la bitacora CONCESIONARIOS
CREATE TABLE BITACORA_CONCESIONARIOS (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idConcesionario INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Disparador para cuando se inserte un concesionario
DELIMITER $$

CREATE TRIGGER AFTER_INSERT_CONCESIONARIOS 
AFTER INSERT ON CONCESIONARIOS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_CONCESIONARIOS(idConcesionario, accion, descripcion)
    VALUES (NEW.idConcesionario, 'INSERT', CONCAT('Se creó el concesionario con ID: ', NEW.idConcesionario));
END$$

DELIMITER ;

-- Disparador para cuando se actualice un concensionario
DELIMITER $$

CREATE TRIGGER AFTER_UPDATE_CONCESIONARIOS
AFTER UPDATE ON CONCESIONARIOS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_CONCESIONARIOS (idConcesionario, accion, descripcion)
    VALUES (OLD.idConcesionario, 'UPDATE', CONCAT('Se actualizo el concensionario con ID: ', OLD.idConcesionario));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un concensionario
DELIMITER $$

CREATE TRIGGER AFTER_DELETE_CONCESIONARIOS
AFTER DELETE ON CONCESIONARIOS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_CONCESIONARIOS (idConcesionario, accion, descripcion)
    VALUES (OLD.idConcesionario, 'DELETE', CONCAT('Se elimino el concensionario con ID: ', OLD.idConcesionario));
END$$

DELIMITER ; 

-- tabla para llevar registro de la bitacora MODELOS
CREATE TABLE BITACORA_MODELOS (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idModelo INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Disparador para cuando se inserte un modelo
DELIMITER $$

CREATE TRIGGER AFTER_INSERT_MODELOS
AFTER INSERT ON MODELOS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_MODELOS(idModelo, accion, descripcion)
    VALUES (NEW.idModelo, 'INSERT', CONCAT('Se creó el modelo con ID: ', NEW.idModelo));
END$$

DELIMITER ;

-- Disparador para cuando se actualice un modelo
DELIMITER $$

CREATE TRIGGER AFTER_UPDATE_MODELOS
AFTER UPDATE ON MODELOS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_MODELOS (idModelo, accion, descripcion)
    VALUES (OLD.idModelo, 'UPDATE', CONCAT('Se modifico el modelo con ID: ', OLD.idModelo));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un modelo
DELIMITER $$

CREATE TRIGGER AFTER_DELETE_MODELOS
AFTER DELETE ON MODELOS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_MODELOS (idModelo, accion, descripcion)
    VALUES (OLD.idModelo, 'DELETE', CONCAT('Se elimino el modelo con ID: ', OLD.idModelo));
END$$

DELIMITER ; 

-- tabla para llevar registro de la bitacora PROVEEDORES
CREATE TABLE BITACORA_PROVEEDORES(
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idProveedor INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Disparador para cuando se inserte un proveedor
DELIMITER $$

CREATE TRIGGER AFTER_INSERT_PROVEEDORES
AFTER INSERT ON PROVEEDORES
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_PROVEEDORES(idProveedor, accion, descripcion)
    VALUES (NEW.idProveedor, 'INSERT', CONCAT('Se creó el proveedor con ID: ', NEW.idProveedor));
END$$

DELIMITER ;

-- Disparador para cuando se actualice un proveedor
DELIMITER $$

CREATE TRIGGER AFTER_UPDATE_PROVEEDORES
AFTER UPDATE ON PROVEEDORES
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_PROVEEDORES (idProveedor, accion, descripcion)
    VALUES (OLD.idProveedor, 'UPDATE', CONCAT('Se modifico el proveedor con ID: ', OLD.idProveedor));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un proveedor
DELIMITER $$

CREATE TRIGGER AFTER_DELETE_PROVEEDORES
AFTER DELETE ON PROVEEDORES
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_PROVEEDORES (idProveedor, accion, descripcion)
    VALUES (OLD.idProveedor, 'DELETE', CONCAT('Se elimino el modelo con ID: ', OLD.idProveedor));
END$$

DELIMITER ; 

-- tabla para llevar registro de la bitacora VEHICULOS
CREATE TABLE BITACORA_VEHICULOS (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    VIN INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Disparador para cuando se inserte un vehiculo
DELIMITER $$

CREATE TRIGGER AFTER_INSERT_VEHICULOS
AFTER INSERT ON VEHICULOS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_VEHICULOS(VIN, accion, descripcion)
    VALUES (NEW.VIN, 'INSERT', CONCAT('Se creó el vehiculo con VIN: ', NEW.VIN));
END$$

DELIMITER ;

-- Disparador para cuando se actualice un vehiculo
DELIMITER $$

CREATE TRIGGER AFTER_UPDATE_VEHICULOS
AFTER UPDATE ON VEHICULOS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_VEHICULOS (VIN, accion, descripcion)
    VALUES (OLD.VIN, 'UPDATE', CONCAT('Se modifico el vehiculo con VIN: ', OLD.VIN));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un vehiculo
DELIMITER $$

CREATE TRIGGER AFTER_DELETE_VEHICULOS
AFTER DELETE ON VEHICULOS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_VEHICULOS (VIN, accion, descripcion)
    VALUES (OLD.VIN, 'DELETE', CONCAT('Se elimino el vehiculo con VIN: ', OLD.VIN));
END$$

DELIMITER ; 

-- tabla para llevar registro de la bitacora VENTAS
CREATE TABLE BITACORA_VENTAS(
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idVenta INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Disparador para cuando se insertar una venta
DELIMITER $$

CREATE TRIGGER AFTER_INSERT_VENTAS
AFTER INSERT ON VENTAS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_VENTAS(idVenta, accion, descripcion)
    VALUES (NEW.idVenta, 'INSERT', CONCAT('Se creó una venta con ID: ', NEW.idVenta));
END$$

DELIMITER ;

-- Disparador para cuando se actualice una venta
DELIMITER $$

CREATE TRIGGER AFTER_UPDATE_VENTAS
AFTER UPDATE ON VENTAS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_VENTAS (idVenta, accion, descripcion)
    VALUES (OLD.idVenta, 'UPDATE', CONCAT('Se modifico la venta con ID : ', OLD.idVenta));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un venta
DELIMITER $$

CREATE TRIGGER AFTER_DELETE_VENTAS
AFTER DELETE ON VENTAS
FOR EACH ROW
BEGIN
    INSERT INTO BITACORA_VENTAS (idVenta, accion, descripcion)
    VALUES (OLD.idVenta, 'DELETE', CONCAT('Se elimino la venta con ID: ', OLD.idVenta));
END$$

DELIMITER ;