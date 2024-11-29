-- tablas para llevar registro de la bitacora plantas
CREATE TABLE Bitacora_Plantas (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idPlanta INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Disparador para cuando se inserte una planta
DELIMITER $$

CREATE TRIGGER after_insert_plantas 
AFTER INSERT ON Plantas
FOR EACH ROW
BEGIN
    INSERT INTO Bitacora_Plantas (idPlanta, accion, descripcion)
    VALUES (NEW.idPlanta, 'INSERT', CONCAT('Se creó la planta con ID: ', NEW.idPlanta));
END$$

DELIMITER ;

--Disparador para cuando se actualice una planta
DELIMITER $$

CREATE TRIGGER after_update_plantas
AFTER UPDATE ON Plantas
FOR EACH ROW
BEGIN
    INSERT INTO Bitacora_Plantas (idPlanta, accion, descripcion)
    VALUES (OLD.idPlanta, 'UPDATE', CONCAT('Se actualizo la planta con ID: ', OLD.idPlanta));
END$$

DELIMITER ;


--Disparador para cuando se elimine una planta
DELIMITER $$

CREATE TRIGGER after_delete_plantas
AFTER DELETE ON Plantas
FOR EACH ROW
BEGIN
    INSERT INTO Bitacora_Plantas (idPlanta, accion, descripcion)
    VALUES (OLD.idPlanta, 'DELETE', CONCAT('Se elimino la planta con ID: ', OLD.idPlanta));
END$$

DELIMITER ;


-- tabla para llevar registro de la bitacora clientes
CREATE TABLE bitacora_clientes (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idCliente INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Disparador para cuando se inserte un cliente
DELIMITER $$

CREATE TRIGGER after_insert_clientes 
AFTER INSERT ON clientes
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_clientes(idCliente, accion, descripcion)
    VALUES (NEW.idCliente, 'INSERT', CONCAT('Se creó la planta con ID: ', NEW.idCliente));
END$$

DELIMITER ;

-- Disparador para cuando se actualice un cliente
DELIMITER $$

CREATE TRIGGER after_update_clientes
AFTER UPDATE ON clientes
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_clientes (idCliente, accion, descripcion)
    VALUES (OLD.idCliente, 'UPDATE', CONCAT('Se actualizo el cliente con ID: ', OLD.idCliente));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un cliente
DELIMITER $$

CREATE TRIGGER after_delete_clientes
AFTER DELETE ON clientes
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_clientes (idCliente, accion, descripcion)
    VALUES (OLD.idCliente, 'DELETE', CONCAT('Se elimino el cliente con ID: ', OLD.idCliente));
END$$

DELIMITER ; 

-- tabla para llevar registro de la bitacora concesionarios
CREATE TABLE bitacora_concesionarios (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idConcesionario INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Disparador para cuando se inserte un concesionario
DELIMITER $$

CREATE TRIGGER after_insert_concesionario 
AFTER INSERT ON concesionarios
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_concesionarios(idConcesionario, accion, descripcion)
    VALUES (NEW.idConcesionario, 'INSERT', CONCAT('Se creó el concesionario con ID: ', NEW.idConcesionario));
END$$

DELIMITER ;

-- Disparador para cuando se actualice un concensionario
DELIMITER $$

CREATE TRIGGER after_update_concensionarios
AFTER UPDATE ON concesionarios
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_concesionarios (idConcesionario, accion, descripcion)
    VALUES (OLD.idConcesionario, 'UPDATE', CONCAT('Se actualizo el concensionario con ID: ', OLD.idConcesionario));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un concensionario
DELIMITER $$

CREATE TRIGGER after_delete_concensionarios
AFTER DELETE ON concesionarios
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_concesionarios (idConcesionario, accion, descripcion)
    VALUES (OLD.idConcesionario, 'DELETE', CONCAT('Se elimino el concensionario con ID: ', OLD.idConcesionario));
END$$

DELIMITER ; 

-- tabla para llevar registro de la bitacora modelos
CREATE TABLE bitacora_modelos (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idModelo INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Disparador para cuando se inserte un modelo
DELIMITER $$

CREATE TRIGGER after_insert_modelos
AFTER INSERT ON modelos
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_modelos(idModelo, accion, descripcion)
    VALUES (NEW.idModelo, 'INSERT', CONCAT('Se creó el modelo con ID: ', NEW.idModelo));
END$$

DELIMITER ;

-- Disparador para cuando se actualice un modelo
DELIMITER $$

CREATE TRIGGER after_update_modelos
AFTER UPDATE ON modelos
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_modelos (idModelo, accion, descripcion)
    VALUES (OLD.idModelo, 'UPDATE', CONCAT('Se modifico el modelo con ID: ', OLD.idModelo));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un modelo
DELIMITER $$

CREATE TRIGGER after_delete_modelos
AFTER DELETE ON modelos
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_modelos (idModelo, accion, descripcion)
    VALUES (OLD.idModelo, 'DELETE', CONCAT('Se elimino el modelo con ID: ', OLD.idModelo));
END$$

DELIMITER ; 

-- tabla para llevar registro de la bitacora proveedores
CREATE TABLE bitacora_proveedores(
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idProveedor INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Disparador para cuando se inserte un proveedor
DELIMITER $$

CREATE TRIGGER after_insert_proveedores
AFTER INSERT ON proveedores
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_proveedores(idProveedor, accion, descripcion)
    VALUES (NEW.idProveedor, 'INSERT', CONCAT('Se creó el proveedor con ID: ', NEW.idProveedor));
END$$

DELIMITER ;

-- Disparador para cuando se actualice un proveedor
DELIMITER $$

CREATE TRIGGER after_update_proveedores
AFTER UPDATE ON proveedores
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_proveedores (idProveedor, accion, descripcion)
    VALUES (OLD.idProveedor, 'UPDATE', CONCAT('Se modifico el proveedor con ID: ', OLD.idProveedor));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un proveedor
DELIMITER $$

CREATE TRIGGER after_delete_proveedores
AFTER DELETE ON proveedores
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_proveedores (idProveedor, accion, descripcion)
    VALUES (OLD.idProveedor, 'DELETE', CONCAT('Se elimino el modelo con ID: ', OLD.idProveedor));
END$$

DELIMITER ; 

-- tabla para llevar registro de la bitacora vehiculos
CREATE TABLE bitacora_vehiculos(
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    VIN INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Disparador para cuando se inserte un vehiculo
DELIMITER $$

CREATE TRIGGER after_insert_vehiculos
AFTER INSERT ON vehiculos
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_vehiculos(VIN, accion, descripcion)
    VALUES (NEW.VIN, 'INSERT', CONCAT('Se creó el vehiculo con VIN: ', NEW.VIN));
END$$

DELIMITER ;

-- Disparador para cuando se actualice un vehiculo
DELIMITER $$

CREATE TRIGGER after_update_vehiculos
AFTER UPDATE ON vehiculos
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_vehiculos (VIN, accion, descripcion)
    VALUES (OLD.VIN, 'UPDATE', CONCAT('Se modifico el vehiculo con VIN: ', OLD.VIN));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un vehiculo
DELIMITER $$

CREATE TRIGGER after_delete_vehiculos
AFTER DELETE ON vehiculos
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_vehiculos (VIN, accion, descripcion)
    VALUES (OLD.VIN, 'DELETE', CONCAT('Se elimino el vehiculo con VIN: ', OLD.VIN));
END$$

DELIMITER ; 

-- tabla para llevar registro de la bitacora ventas
CREATE TABLE bitacora_ventas(
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    idVenta INT NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Disparador para cuando se insertar una venta
DELIMITER $$

CREATE TRIGGER after_insert_ventas
AFTER INSERT ON ventas
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_ventas(idVenta, accion, descripcion)
    VALUES (NEW.idVenta, 'INSERT', CONCAT('Se creó una venta con ID: ', NEW.idVenta));
END$$

DELIMITER ;

-- Disparador para cuando se actualice una venta
DELIMITER $$

CREATE TRIGGER after_update_ventas
AFTER UPDATE ON ventas
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_ventas (idVenta, accion, descripcion)
    VALUES (OLD.idVenta, 'UPDATE', CONCAT('Se modifico la venta con ID : ', OLD.idVenta));
END$$

DELIMITER ;

-- Disparador para cuando se elimine un venta
DELIMITER $$

CREATE TRIGGER after_delete_ventas
AFTER DELETE ON ventas
FOR EACH ROW
BEGIN
    INSERT INTO bitacora_ventas (idVenta, accion, descripcion)
    VALUES (OLD.idVenta, 'DELETE', CONCAT('Se elimino la venta con ID: ', OLD.idVenta));
END$$

DELIMITER ; 