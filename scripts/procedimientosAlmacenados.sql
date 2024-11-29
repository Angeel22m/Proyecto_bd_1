
---procedimiento para crear una nueva planta

CREATE procedure registrarNuevaPlanta(
    In p_nombre VARCHAR(100),
    IN p_ubicacion VARCHAR(100)
)
BEGIN
    IF NOT EXISTS (SELECT 1 FROM Plantas p 
     WHERE p.nombre = p_nombre 
     and p.ubicacion = p_ubicacion ) THEN
        INSERT INTO Plantas (nombre, ubicacion) VALUES 
(p_nombre, p_ubicacion);
    ELSE 
        SELECT 'ya existe esa planta';
    END IF;

END;

--Actualizar planta

CREATE PROCEDURE actualizarPlantaPorId(
    IN p_idPlanta INT,
    IN p_nombre VARCHAR(100),
    IN p_ubicacion VARCHAR(100)
)
BEGIN
    -- Verifica si existe la planta
    IF EXISTS (SELECT 1 FROM Plantas P WHERE P.idPlanta = p_idPlanta) THEN
        -- Actualiza solo los campos proporcionados
        UPDATE Plantas
        SET 
            nombre = CASE WHEN p_nombre IS NOT NULL THEN p_nombre ELSE nombre END,
            ubicacion = CASE WHEN p_ubicacion IS NOT NULL THEN p_ubicacion ELSE ubicacion END
        WHERE idPlanta = p_idPlanta;
        -- Mensaje de confirmación
        SELECT CONCAT('La planta con ID ', p_idPlanta, ' fue actualizada correctamente.') AS Mensaje;
    ELSE
        -- Mensaje si la planta no existe
        SELECT CONCAT('No existe planta con el ID: ', p_idPlanta) AS Mensaje;
    END IF;
END; 

-- procedimiento para elimanar una planta por id
CREATE procedure eliminarPlantaPorId(
    In p_idPlanta INT
)
BEGIN
    IF EXISTS (SELECT 1 FROM Plantas P WHERE p.idPlanta = p_idPlanta) THEN
             DELETE FROM Plantas
             WHERE idPlanta = p_idPlanta;
            
        IF EXISTS (SELECT 1 FROM ModelosXPlantas mp WHERE mp.idPlanta = p_idPlanta) THEN
            DELETE FROM ModelosXPlantas
            WHERE idPlanta = p_idPlanta;
            END IF;
            ELSE
            SELECT CONCAT('no existe una planta con el Id: ',p_idPlanta) as Mensaje;
     END IF;
END;

--procedimiento para crear clientes

CREATE PROCEDURE crearCliente(
    IN p_nombre VARCHAR(100),
    IN p_direccion VARCHAR(100),
    IN p_noTelefono VARCHAR(15),
    IN p_sexo ENUM('masculino', 'femenino', 'otro'),
    IN p_ingresosAnuales INT
)
BEGIN
    -- Variables para capturar el error
    DECLARE v_error_message TEXT;

    -- Handler para manejar excepciones SQL
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Capturar el mensaje de error más reciente
        GET DIAGNOSTICS CONDITION 1
            v_error_message = MESSAGE_TEXT;

        -- Mostrar el mensaje de error al usuario
        SELECT CONCAT('Error: ', v_error_message) AS Mensaje;
    END;

    -- Validar si ya existe un cliente con los mismos datos
    IF EXISTS (
        SELECT 1 
        FROM clientes 
        WHERE nombre = p_nombre
          AND direccion = p_direccion
          AND noTelefono = p_noTelefono
          AND sexo = p_sexo
          AND ingresosAnuales = p_ingresosAnuales
    ) THEN
        -- Cliente ya existente
        SELECT 'El cliente ya existe con los mismos datos.' AS Mensaje;
    ELSE
        -- Intentar insertar el cliente
        INSERT INTO clientes (
            nombre,
            direccion,
            noTelefono,
            sexo,
            ingresosAnuales
        ) VALUES (
            p_nombre,
            p_direccion,
            p_noTelefono,
            p_sexo,
            p_ingresosAnuales
        );

        -- Confirmación de éxito
        SELECT 'Cliente creado exitosamente.' AS Mensaje;
    END IF;
END;


-- Acturalizar Cliente

CREATE PROCEDURE actualizarClientePorId(
    IN p_idCliente INT,
    IN p_nombre VARCHAR(255),
    IN p_direccion VARCHAR(255),
    IN p_sexo CHAR(1),
    IN p_noTelefono VARCHAR(15),
    IN p_ingresosAnuales DECIMAL(10,2)
)
BEGIN
    UPDATE clientes
    SET 
        nombre = COALESCE(p_nombre, nombre),
        direccion = COALESCE(p_direccion, direccion),
        sexo = COALESCE(p_sexo, sexo),
        noTelefono = COALESCE(p_noTelefono, noTelefono),
        ingresosAnuales = COALESCE(p_ingresosAnuales, ingresosAnuales)
    WHERE idCliente = p_idCliente;
END

-- PROCEDIMIENTO PARA ELIMINAR CLIENTE POR ID

CREATE PROCEDURE eliminarClientePorId(
    IN idCliente INT
)

BEGIN

END;


