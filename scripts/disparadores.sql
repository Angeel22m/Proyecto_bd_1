 USE compania;

-- Tabla para registro unificado de bitácoras
CREATE TABLE BITACORA (
    idLog INT AUTO_INCREMENT PRIMARY KEY,
    tabla_afectada VARCHAR(50) NOT NULL,
    accion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    descripcion TEXT,
    usuario VARCHAR(50) DEFAULT CURRENT_USER(),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Generador de triggers dinámicos
DELIMITER $$

CREATE PROCEDURE GENERAR_TRIGGER(
    IN tabla VARCHAR(50),
    IN clave VARCHAR(50)
)
BEGIN
    -- Trigger AFTER INSERT
    SET @sql_insert = CONCAT(
        'CREATE TRIGGER AFTER_INSERT_', tabla, ' ',
        'AFTER INSERT ON ', tabla, ' ',
        'FOR EACH ROW ',
        'BEGIN ',
        'INSERT INTO BITACORA (tabla_afectada, accion, descripcion) ',
        'VALUES (\'', tabla, '\', \'INSERT\', CONCAT(\'Se insertó un registro con ', clave, ' = \', NEW.', clave, ')); ',
        'END;'
    );
    PREPARE stmt FROM @sql_insert;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

    -- Trigger AFTER UPDATE
    SET @sql_update = CONCAT(
        'CREATE TRIGGER AFTER_UPDATE_', tabla, ' ',
        'AFTER UPDATE ON ', tabla, ' ',
        'FOR EACH ROW ',
        'BEGIN ',
        'INSERT INTO BITACORA (tabla_afectada, accion, descripcion) ',
        'VALUES (\'', tabla, '\', \'UPDATE\', CONCAT(\'Se actualizó un registro con ', clave, ' = \', OLD.', clave, ')); ',
        'END;'
    );
    PREPARE stmt FROM @sql_update;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

    -- Trigger AFTER DELETE
    SET @sql_delete = CONCAT(
        'CREATE TRIGGER AFTER_DELETE_', tabla, ' ',
        'AFTER DELETE ON ', tabla, ' ',
        'FOR EACH ROW ',
        'BEGIN ',
        'INSERT INTO BITACORA (tabla_afectada, accion, descripcion) ',
        'VALUES (\'', tabla, '\', \'DELETE\', CONCAT(\'Se eliminó un registro con ', clave, ' = \', OLD.', clave, ')); ',
        'END;'
    );
    PREPARE stmt FROM @sql_delete;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;

-- Creación de triggers para las tablas
CALL GENERAR_TRIGGER('PLANTAS', 'idPlanta');
CALL GENERAR_TRIGGER('CLIENTES', 'idCliente');
CALL GENERAR_TRIGGER('CONCESIONARIOS', 'idConcesionario');
CALL GENERAR_TRIGGER('MODELOS', 'idModelo');
CALL GENERAR_TRIGGER('PROVEEDORES', 'idProveedor');
CALL GENERAR_TRIGGER('VEHICULOS', 'VIN');
CALL GENERAR_TRIGGER('VENTAS', 'idVenta');
