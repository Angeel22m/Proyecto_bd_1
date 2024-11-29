
--PROCEDIMIENTO PARA OBTENER LOS VEHICULOS POR MODELO
CREATE procedure ObtenerVehiculosPorModelo(

    In p_idModelo INT 
)
BEGIN
SELECT V.color, V.transmision, M.nombre, M.marca, M.estiloCarroceria 
FROM Vehiculos V JOIN Modelos M 
ON M.idModelo = V.idModelo
WHERE V.idModelo=p_idModelo;
END;


--PROCEDIMIENTO PARA OBTENER LOS VEHICULOS POR MODELO CON VALIDACIONES


CREATE PROCEDURE ObtenerVehiculosPorModeloMejorado(
    IN p_idModelo INT
)
BEGIN
    -- Verificar si el modelo existe
    IF EXISTS (SELECT 1 FROM Modelos WHERE idModelo = p_idModelo) THEN
        -- Verificar si hay vehículos asociados al modelo
        IF EXISTS (SELECT 1 FROM Vehiculos WHERE idModelo = p_idModelo) THEN
            -- Consultar vehículos del modelo
            SELECT V.color, V.transmision, M.nombre 
            FROM Vehiculos V 
            JOIN Modelos M ON M.idModelo = V.idModelo
            WHERE V.idModelo = p_idModelo;
        ELSE
            -- Mensaje si no hay vehículos asociados
            SELECT CONCAT('No se encontraron vehículos para el modelo con ID: ', p_idModelo) AS Mensaje;
        END IF;
    ELSE
        -- Mensaje si el modelo no existe
        SELECT CONCAT('El modelo con ID: ', p_idModelo, ' no existe.') AS Mensaje;
    END IF;
END;


CREATE PROCEDURE obtenerElNumeroDeVehiculosPorModelo(
    IN p_idModelo INT,
    OUT countVehiculo INT
)
BEGIN
    -- Verifica si existe el modelo
    IF EXISTS (SELECT 1 FROM Modelos M WHERE M.idModelo = p_idModelo) THEN
        -- Verifica si hay vehículos con ese modelo
        IF EXISTS (SELECT 1 FROM Vehiculos V WHERE V.idModelo = p_idModelo) THEN
            -- Consulta el número de vehículos asociados al modelo
            SELECT COUNT(*) INTO countVehiculo 
            FROM Vehiculos V 
            WHERE V.idModelo = p_idModelo;
        ELSE
            -- Si no hay vehículos
            SET countVehiculo = 0; 
        END IF; 
    ELSE
        -- Si no existe el modelo
        SET countVehiculo = NULL;
        SELECT CONCAT('El modelo con ID: ', p_idModelo, ' no existe.') AS Mensaje;
    END IF;
END ;


CREATE PROCEDURE obtenerElNumeroDeVehiculosPorModeloHandler(
    IN p_idModelo INT,
    OUT countVehiculo INT
)
BEGIN
    -- Declarar un manejador para errores
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        SET countVehiculo = NULL;

    -- Verifica si el modelo existe
    IF EXISTS (SELECT 1 FROM Modelos M WHERE M.idModelo = p_idModelo) THEN
        -- Verifica si hay vehículos con ese modelo
        IF EXISTS (SELECT 1 FROM Vehiculos V WHERE V.idModelo = p_idModelo) THEN
            -- Consulta el número de vehículos asociados al modelo
            SELECT COUNT(*) INTO countVehiculo 
            FROM Vehiculos V 
            WHERE V.idModelo = p_idModelo;
        ELSE
            -- Si no hay vehículos, asigna 0
            SET countVehiculo = 0; 
        END IF;
    ELSE
        -- Si no existe el modelo
        SET countVehiculo = NULL;
        SELECT CONCAT('El modelo con ID: ', p_idModelo, ' no existe.') AS Mensaje;
    END IF;
END; 

CREATE PROCEDURE obtenerElNumeroDeVehiculosPorModeloSignal(
    IN p_idModelo INT,
    OUT countVehiculo INT
)
BEGIN
    -- Verifica si el modelo existe
    IF NOT EXISTS (SELECT 1 FROM Modelos M WHERE M.idModelo = p_idModelo) THEN
        -- Si no existe el modelo, genera un error
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'El modelo no existe.';
    ELSE
        -- Verifica si hay vehículos con ese modelo
        IF EXISTS (SELECT 1 FROM Vehiculos V WHERE V.idModelo = p_idModelo) THEN
            -- Consulta el número de vehículos asociados al modelo
            SELECT COUNT(*) INTO countVehiculo 
            FROM Vehiculos V 
            WHERE V.idModelo = p_idModelo;
        ELSE
            -- Si no hay vehículos, asigna 0
            SET countVehiculo = 0; 
        END IF;
    END IF;
END; 


--validar numero de telefono

CREATE FUNCTION validarNumero (f_noTelefono VARCHAR(15)) 
RETURNS INT 
NOT DETERMINISTIC
BEGIN
    DECLARE result INT;

    IF EXISTS (SELECT 1 FROM clientes c WHERE c.noTelefono = f_noTelefono) THEN
        SET result = 0;
    ELSE
        SET result = 1;
    END IF;

    RETURN result;
END
