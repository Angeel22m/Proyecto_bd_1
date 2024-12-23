
---procedimiento para crear una nueva planta

DELIMITER $$

create PROCEDURE crearPlanta(
    IN p_nombre VARCHAR(20),
    IN p_ubicacion VARCHAR(50)
)
BEGIN
    IF NOT EXISTS (
        SELECT 1 
        FROM PLANTAS 
        WHERE nombre = p_nombre 
          AND ubicacion = p_ubicacion
    ) THEN
        INSERT INTO PLANTAS (nombre, ubicacion) 
        VALUES (p_nombre, p_ubicacion);
        SELECT 'Planta registrada exitosamente.' AS Mensaje;
    ELSE
        SELECT 'Ya existe una planta con el mismo nombre y ubicación.' AS Mensaje;
    END IF;
END$$

DELIMITER ;


--procdedimiento para actualizar planta
DELIMITER $$

CREATE PROCEDURE actualizarPlanta(
    IN p_idPlanta INT,
    IN p_nombre VARCHAR(20),
    IN p_ubicacion VARCHAR(50)
)
BEGIN
    -- Verifica si la planta existe
    IF EXISTS (
        SELECT 1 
        FROM PLANTAS 
        WHERE idPlanta = p_idPlanta
    ) THEN
        -- Actualiza los campos proporcionados
        UPDATE PLANTAS
        SET 
            nombre = COALESCE(p_nombre, nombre),
            ubicacion = COALESCE(p_ubicacion, ubicacion)
        WHERE idPlanta = p_idPlanta;

        SELECT CONCAT('La planta con ID ', p_idPlanta, ' fue actualizada exitosamente.') AS Mensaje;
    ELSE
        SELECT CONCAT('No existe una planta con el ID: ', p_idPlanta) AS Mensaje;
    END IF;
END$$

DELIMITER ;

-- procedimiento para eliminar planta
DELIMITER $$

CREATE PROCEDURE eliminarPlanta(
    IN p_idPlanta INT
)
BEGIN
    -- Verifica si la planta existe
    IF EXISTS (SELECT 1 FROM PLANTAS WHERE idPlanta = p_idPlanta) THEN
        -- Elimina las relaciones en la tabla MODELOSXPLANTAS si existen
        IF EXISTS (SELECT 1 FROM MODELOSXPLANTAS WHERE idPlanta = p_idPlanta) THEN
            DELETE FROM MODELOSXPLANTAS WHERE idPlanta = p_idPlanta;            
        END IF;

        -- Ahora elimina la planta
        DELETE FROM PLANTAS WHERE idPlanta = p_idPlanta;

        -- Mensaje de confirmación
        SELECT CONCAT('La planta con ID ', p_idPlanta, ' fue eliminada exitosamente.') AS Mensaje;
    ELSE
        -- Si la planta no existe
        SELECT CONCAT('No existe una planta con el ID: ', p_idPlanta) AS Mensaje;
    END IF;
END$$

DELIMITER ;


--procedimiento para crear cliente 
DELIMITER $$

CREATE PROCEDURE crearCliente(
    IN p_nombre VARCHAR(20),
    IN p_direccion VARCHAR(50),
    IN p_noTelefono VARCHAR(15),
    IN p_sexo ENUM('masculino', 'femenino', 'otro'),
    IN p_ingresosAnuales INT
)
BEGIN
    -- Validar si ya existe un cliente con el mismo número de teléfono
    IF EXISTS (
        SELECT 1 
        FROM CLIENTES 
        WHERE noTelefono = p_noTelefono
    ) THEN
        SELECT 'Ya existe un cliente con este número de teléfono.' AS Mensaje;
    ELSE
        -- Intentar insertar el cliente
        INSERT INTO CLIENTES (
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
END $$

DELIMITER ;

--procedimiento para actualizar cliente
DELIMITER $$

CREATE PROCEDURE actualizarCliente(
    IN p_idCliente INT,
    IN p_nombre VARCHAR(20),
    IN p_direccion VARCHAR(50),
    IN p_noTelefono VARCHAR(15),
    IN p_sexo ENUM('masculino', 'femenino', 'otro'),
    IN p_ingresosAnuales INT
)
BEGIN
    -- Verificar si el cliente existe
    IF EXISTS (SELECT 1 FROM CLIENTES WHERE idCliente = p_idCliente) THEN
        -- Actualizar cliente usando COALESCE para manejar NULL
        UPDATE CLIENTES
        SET 
            nombre = COALESCE(p_nombre, nombre),
            direccion = COALESCE(p_direccion, direccion),
            noTelefono = COALESCE(p_noTelefono, noTelefono),
            sexo = COALESCE(p_sexo, sexo),
            ingresosAnuales = COALESCE(p_ingresosAnuales, ingresosAnuales)
        WHERE idCliente = p_idCliente;
        -- Confirmación
        SELECT 'Cliente actualizado exitosamente.' AS Mensaje;
    ELSE
        -- Cliente no encontrado
        SELECT CONCAT('No existe cliente con el ID: ', p_idCliente) AS Mensaje;
    END IF;
END $$

DELIMITER ;


--procedimiento para eliminar cliente
DELIMITER $$

CREATE PROCEDURE eliminarCliente(
    IN p_idCliente INT
)
BEGIN
    -- Verificar si el cliente existe
    IF EXISTS (SELECT 1 FROM CLIENTES WHERE idCliente = p_idCliente) THEN

        -- Primero eliminar las ventas asociadas al cliente, si existen
        DELETE FROM VENTAS WHERE idCliente = p_idCliente;

        -- Luego eliminar el cliente
        DELETE FROM CLIENTES WHERE idCliente = p_idCliente;

        -- Confirmación
        SELECT 'Cliente y sus registros asociados fueron eliminados exitosamente.' AS Mensaje;

    ELSE
        -- Cliente no encontrado
        SELECT CONCAT('No existe un cliente con el ID: ', p_idCliente) AS Mensaje;
    END IF;
END $$

DELIMITER ;




-- procedimiento para crear un nuevo vehiculo
DELIMITER $$

create PROCEDURE crearVehiculo(
    IN v_VIN VARCHAR(17),
    IN v_idModelo INT,
    IN v_color VARCHAR(10),
    IN v_noMotor INT,
    IN v_transmision VARCHAR(10),
    IN v_fechaFabricacion DATE
)
BEGIN
    IF v_color NOT IN ('rojo', 'azul', 'blanco', 'negro', 'gris') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Color inválido';
    ELSEIF v_transmision NOT IN ('manual', 'automática') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tipo de transmisión inválido';
    ELSE
        IF NOT EXISTS (SELECT 1 FROM VEHICULOS WHERE VIN = v_VIN) THEN
            IF EXISTS (SELECT 1 FROM MODELOS WHERE idModelo = v_idModelo) THEN
                INSERT INTO VEHICULOS (VIN, idModelo, color, noMotor, transmision, fechaFabricacion)
                VALUES (v_VIN, v_idModelo, v_color, v_noMotor, v_transmision, v_fechaFabricacion);
                SELECT 'Vehículo registrado correctamente' AS resultado;
            ELSE
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El modelo especificado no existe';
            END IF;
        ELSE
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El vehículo con el VIN especificado ya existe';
        END IF;
    END IF;
END$$

DELIMITER ;

-- procedimiento para actualizar un vehiculo
DELIMITER $$

CREATE PROCEDURE actualizarVehiculo(
    IN v_VIN VARCHAR(17),
    IN v_idModelo INT,
    IN v_color ENUM('rojo', 'azul', 'blanco', 'negro', 'gris'),
    IN v_noMotor INT,
    IN v_transmision ENUM('manual', 'automática'),
    IN v_fechaFabricacion DATE
)
BEGIN
 DECLARE v_error_message TEXT;
 DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
  	BEGIN
        GET DIAGNOSTICS CONDITION 1
            v_error_message = MESSAGE_TEXT;
        SELECT CONCAT('Error: ', v_error_message) AS Mensaje;
    END;
            
	 IF EXISTS (SELECT 1 FROM VEHICULOS v WHERE v.VIN = v_VIN) THEN
            UPDATE VEHICULOS SET 
            modelo = CASE WHEN v_idModelo IS NOT NULL AND 
				EXISTS (SELECT 1 FROM MODELOS m WHERE m.idModelo = v_idModelo) 
				THEN v_idModelo ELSE modelo END,
				color = COALESCE(v_color, color),
				motor = COALESCE(v_noMotor, noMotor),
				tansmision = COALESCE(v_transmision, transmision),
				fechaFabricacion = COALESCE(v_fechaFabricacion, fechaFabricacion);
            SELECT 'Vehiculo actualizado exitosamente' AS Mensaje;
        ELSE
             SELECT  'El vehículo con el VIN especificado no existe' AS Mensaje;
        END IF;
END$$
DELIMITER ;

-- procedimiento para eliminar vehiculo
DELIMITER $$

CREATE PROCEDURE eliminarVehiculo(
    IN v_VIN VARCHAR(17)
)
BEGIN     
    -- Verificar si el vehículo existe
    IF EXISTS (SELECT 1 FROM VEHICULOS WHERE VIN = v_VIN) THEN
        
        -- Eliminar las relaciones en VEHICULOSXCONCESIONARIOS si existen
        DELETE FROM VEHICULOSXCONCESIONARIOS WHERE VIN = v_VIN;

        -- Eliminar las relaciones en VENTAS si existen
        DELETE FROM VENTAS WHERE VIN = v_VIN;

        -- Ahora eliminar el vehículo de la tabla VEHICULOS
        DELETE FROM VEHICULOS WHERE VIN = v_VIN;

        -- Confirmación
        SELECT 'Vehículo y sus registros relacionados fueron eliminados exitosamente.' AS Mensaje;

    ELSE
        -- Vehículo no encontrado
        SELECT 'El vehículo con el VIN especificado no existe' AS Mensaje;
    END IF;
END$$

DELIMITER ;


-- procedimiento para añadir un proveedor
DELIMITER $$

create PROCEDURE crearProveedor(
	p_nombre VARCHAR(20),
   p_direccion VARCHAR(50),
   p_noTelefono VARCHAR(15))
BEGIN     
	 IF EXISTS (
	 SELECT 1 FROM PROVEEDORES p
	 WHERE p.nombre = p_nombre
	 AND p.direccion = p_direccion
	 AND p.noTelefono = p_noTelefono
	 ) THEN
	 SELECT 'Ya esxiste un proveedor con estos datos' AS Mensaje;
   ELSE
   INSERT INTO PROVEEDORES (nombre, direccion, noTelefono)
   VALUES (p_nombre, p_direccion, p_noTelefono);
   SELECT 'Proveedor añadido con exito ' AS Mensaje;
   END IF;
END$$
DELIMITER ;

-- procedimiento para actualizar un proveedor
DELIMITER $$

CREATE PROCEDURE actualizarProveedor(
	p_idProveedor INT,
	p_nombre VARCHAR(20),
   p_direccion VARCHAR(50),
   p_noTelefono VARCHAR(15))
BEGIN     
	 IF EXISTS (
	 SELECT 1 FROM PROVEEDORES p
	 WHERE p.idProveedor = p_idProveedor
	 ) THEN
	UPDATE PROVEEDORES SET 
	nombre = COALESCE(p_nombre, nombre),
	direccion = COALESCE(p_direccion, direccion),
	noTelefono = COALESCE(p_noTelefono, noTelefono)
	WHERE idProveedor = p_idProveedor;
   SELECT 'Proveedor actualizado exitosamente ' AS Mensaje;
   ELSE
   SELECT 'No esxiste un proveedor con estos datos' AS Mensaje;
   END IF;
END$$
DELIMITER ;

-- procedimiento para eliminar un proveedor
DELIMITER $$

CREATE PROCEDURE eliminarProveedor(
    IN p_idProveedor INT
)
BEGIN
    -- Verificar si el proveedor existe
    IF EXISTS (SELECT 1 FROM PROVEEDORES WHERE idProveedor = p_idProveedor) THEN
        
        -- Eliminar las relaciones en MODELOSXPROVEEDORES si existen
        DELETE FROM MODELOSXPROVEEDORES WHERE idProveedor = p_idProveedor;

        -- Ahora eliminar el proveedor de la tabla PROVEEDORES
        DELETE FROM PROVEEDORES WHERE idProveedor = p_idProveedor;

        -- Confirmación
        SELECT 'Proveedor y sus registros relacionados fueron eliminados exitosamente.' AS Mensaje;

    ELSE
        -- Proveedor no encontrado
        SELECT 'No existe un proveedor con el ID especificado' AS Mensaje;
    END IF;
END$$

DELIMITER ;


-- procedimiento para añadir un nuevo modelo
DELIMITER $$

create PROCEDURE crearModelo(
	m_nombre VARCHAR(10),
  m_estiloCarroceria ENUM('sedan', 'hatchback', 'suv', 'coupe', 'pickup', 'convertible'),
   m_marca VARCHAR(10))
BEGIN     
	IF EXISTS (
	SELECT 1 FROM MODELOS m
	WHERE m.nombre = m_nombre
	AND m.estiloCarroceria = m_estiloCarroceria
	AND m.marca = m_marca
	) THEN
	SELECT 'Ya esxiste un modelo con estos datos' AS Mensaje;
   ELSE
   INSERT INTO modelos (nombre, estiloCarroceria, marca)
   VALUES (m_nombre, m_estiloCarroceria, m_marca);
   SELECT 'Modelo agregado con exito ' AS Mensaje;
   END IF;
END$$
DELIMITER ;

-- procedimiento para actualizar un modelo
DELIMITER $$

CREATE PROCEDURE actualizarModelo(
	m_idModelo INT,
	m_nombre VARCHAR(10),
  m_estiloCarroceria ENUM('sedan', 'hatchback', 'suv', 'coupe', 'pickup', 'convertible'),
   m_marca VARCHAR(10))
BEGIN     
	 IF EXISTS (
	 SELECT 1 FROM MODELOS m
	 WHERE m.idModelo = m_idModelo
	 ) THEN
	UPDATE MODELOS SET 
	nombre = COALESCE(m_nombre, nombre),
	estiloCarroceria = COALESCE(m_estiloCarroceria, estiloCarroceria),
	marca = COALESCE(m_marca, marca)
	WHERE idModelo = m_idModelo;
   SELECT 'Modelo actualizado exitosamente ' AS Mensaje;
   ELSE
   SELECT 'No esxiste un modelo con estos datos' AS Mensaje;
   END IF;
END$$
DELIMITER ;

-- procedimiento para eliminar un modelos
DELIMITER $$

CREATE PROCEDURE eliminarModelo(
    m_idModelo INT
)
BEGIN
    -- Verificar si el modelo existe
    IF EXISTS (
        SELECT 1 FROM MODELOS m
        WHERE m.idModelo = m_idModelo
    ) THEN
        -- Eliminar registros dependientes
        DELETE FROM VEHICULOS WHERE idModelo = m_idModelo;
        DELETE FROM MODELOSXPLANTAS WHERE idModelo = m_idModelo;
        DELETE FROM MODELOSXPROVEEDORES WHERE idModelo = m_idModelo;
        DELETE FROM VEHICULOSXCONCESIONARIOS WHERE VIN IN (SELECT VIN FROM VEHICULOS WHERE idModelo = m_idModelo);

        -- Finalmente eliminar el modelo
        DELETE FROM MODELOS WHERE idModelo = m_idModelo;

        -- Confirmar la eliminación
        SELECT 'Modelo eliminado exitosamente' AS Mensaje;
    ELSE
        -- En caso de que no exista el modelo
        SELECT 'No existe un modelo con estos datos' AS Mensaje;
    END IF;
END$$

DELIMITER ;


--procedimiento para crear ventas
DELIMITER $$

CREATE PROCEDURE crearVenta(
    IN p_idConcesionario INT,
    IN p_idCliente INT,
    IN p_VIN VARCHAR(17),
    IN p_precio DECIMAL(10,2)
)
BEGIN
    -- Variable para capturar errores
    DECLARE v_error_message TEXT;

    -- Handler para manejar excepciones SQL
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            v_error_message = MESSAGE_TEXT;
        SELECT CONCAT('Error al crear la venta: ', v_error_message) AS Mensaje;
    END;

    -- Validar existencia de los datos relacionados
    IF NOT EXISTS (SELECT 1 FROM Concesionarios WHERE idConcesionario = p_idConcesionario) THEN
        SELECT 'El concesionario especificado no existe.' AS Mensaje;
    ELSEIF NOT EXISTS (SELECT 1 FROM Clientes WHERE idCliente = p_idCliente) THEN
        SELECT 'El cliente especificado no existe.' AS Mensaje;
    ELSEIF NOT EXISTS (SELECT 1 FROM Vehiculos WHERE VIN = p_VIN) THEN
        SELECT 'El vehículo especificado no existe.' AS Mensaje;
    ELSE
        -- Intentar crear la venta con la fecha actual
        INSERT INTO VENTAS (fecha, idConcesionario, idCliente, VIN, precio)
        VALUES (CURRENT_DATE, p_idConcesionario, p_idCliente, p_VIN, p_precio);
        SELECT 'Venta creada exitosamente.' AS Mensaje;
    END IF;
END$$

DELIMITER ;

---Actualizar venta
DELIMITER $$

create PROCEDURE actualizarVenta(
    IN p_idVenta INT,
    IN p_idConcesionario INT,
    IN p_idCliente INT,
    IN p_VIN VARCHAR(17),
    IN p_precio DECIMAL(10, 2)
)
BEGIN
    -- Variable para capturar errores
    DECLARE v_error_message TEXT;
    DECLARE v_status INT DEFAULT 0;

    -- Handler para manejar excepciones SQL
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN
        SET v_status = 1;
        GET DIAGNOSTICS CONDITION 1
            v_error_message = MESSAGE_TEXT;
        SELECT CONCAT('Error al actualizar la venta: ', v_error_message) AS Mensaje;
    END;

    -- Validaciones
    IF NOT EXISTS (SELECT 1 FROM VENTAS WHERE idVenta = p_idVenta) THEN
        SELECT CONCAT('No existe una venta con el ID: ', p_idVenta) AS Mensaje;

    ELSE
        -- Validar concesionario solo si el valor no es NULL
        IF p_idConcesionario IS NOT NULL AND NOT EXISTS (SELECT 1 FROM CONCESIONARIOS WHERE idConcesionario = p_idConcesionario) THEN
            SELECT CONCAT('El concesionario con ID: ', p_idConcesionario, ' no existe.') AS Mensaje;

        -- Validar cliente solo si el valor no es NULL
        ELSEIF p_idCliente IS NOT NULL AND NOT EXISTS (SELECT 1 FROM CLIENTES WHERE idCliente = p_idCliente) THEN
            SELECT CONCAT('El cliente con ID: ', p_idCliente, ' no existe.') AS Mensaje;

        -- Validar VIN solo si el valor no es NULL
        ELSEIF p_VIN IS NOT NULL AND NOT EXISTS (SELECT 1 FROM VEHICULOS WHERE VIN = p_VIN) THEN
            SELECT CONCAT('El vehículo con VIN: ', p_VIN, ' no existe.') AS Mensaje;

        ELSE
            -- Intentar actualizar la venta
            UPDATE VENTAS
            SET             
                idConcesionario = COALESCE(p_idConcesionario, idConcesionario),
                idCliente = COALESCE(p_idCliente, idCliente),
                VIN = COALESCE(p_VIN, VIN),
                precio = COALESCE(p_precio, precio)
            WHERE idVenta = p_idVenta;

            -- Confirmar éxito si no hubo errores
            IF v_status = 0 THEN
                SELECT 'Venta actualizada exitosamente.' AS Mensaje;
            END IF;
        END IF;
    END IF;
END $$

DELIMITER ;



--procedimiento para eliminar venta
DELIMITER $$

CREATE PROCEDURE eliminarVenta(
    IN p_idVenta INT
)
BEGIN
    -- Variable para capturar errores
    DECLARE v_error_message TEXT;

    -- Handler para manejar excepciones SQL
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            v_error_message = MESSAGE_TEXT;
        SELECT CONCAT('Error al eliminar la venta: ', v_error_message) AS Mensaje;
    END;

    -- Verificar si la venta existe
    IF EXISTS (SELECT 1 FROM VENTAS WHERE idVenta = p_idVenta) THEN
        -- Eliminar la venta
        DELETE FROM VENTAS WHERE idVenta = p_idVenta;
        SELECT 'Venta eliminada exitosamente.' AS Mensaje;
    ELSE
        SELECT CONCAT('No existe una venta con el ID: ', p_idVenta) AS Mensaje;
    END IF;
END$$

DELIMITER ;

--procedimiento para crear concesionario
DELIMITER $$

CREATE PROCEDURE crearConcesionario(
    IN p_nombre VARCHAR(50),
    IN p_direccion VARCHAR(100),
    IN p_noTelefono VARCHAR(15)
)
BEGIN
    -- Validar si ya existe un concesionario con el mismo teléfono o dirección
    IF EXISTS (
        SELECT 1
        FROM CONCESIONARIOS
        WHERE noTelefono = p_noTelefono OR direccion = p_direccion
    ) THEN
        SELECT 'Ya existe un concesionario con este número de teléfono o dirección.' AS Mensaje;
    ELSE
        -- Insertar el nuevo concesionario
        INSERT INTO CONCESIONARIOS (nombre, direccion, noTelefono)
        VALUES (p_nombre, p_direccion, p_noTelefono);
        -- Confirmación de éxito
        SELECT 'Concesionario creado exitosamente.' AS Mensaje;
    END IF;
END $$

DELIMITER ;

--procedimiento para actualizar concesionario
DELIMITER $$

CREATE PROCEDURE actualizarConcesionario(
    IN p_idConcesionario INT,
    IN p_nombre VARCHAR(20),
    IN p_direccion VARCHAR(50),
    IN p_noTelefono VARCHAR(15)
)
BEGIN
    -- Validar si el concesionario existe
    IF EXISTS (SELECT 1 FROM CONCESIONARIOS WHERE idConcesionario = p_idConcesionario) THEN
        -- Actualizar los campos proporcionados usando COALESCE
        UPDATE CONCESIONARIOS
        SET 
            nombre = COALESCE(p_nombre, nombre),
            direccion = COALESCE(p_direccion, direccion),
            noTelefono = COALESCE(p_noTelefono, noTelefono)
        WHERE idConcesionario = p_idConcesionario;
        -- Confirmación de éxito
        SELECT 'Concesionario actualizado exitosamente.' AS Mensaje;
    ELSE
        -- Mensaje si no se encuentra el concesionario
        SELECT CONCAT('No existe un concesionario con el ID: ', p_idConcesionario) AS Mensaje;
    END IF;
END $$

DELIMITER ;

--procedimiento para eliminar consecionarioDELIMITER $$

DELIMITER $$
CREATE PROCEDURE eliminarConcesionario(
    IN p_idConcesionario INT
)
BEGIN
    -- Verificar si el concesionario existe
    IF EXISTS (SELECT 1 FROM CONCESIONARIOS WHERE idConcesionario = p_idConcesionario) THEN
        -- Eliminar las dependencias primero (ventas relacionadas)
        DELETE FROM VENTAS WHERE idConcesionario = p_idConcesionario;
        
        -- Si hay más tablas dependientes, se deben eliminar aquí
        -- Ejemplo: Eliminar vehículos asociados a ese concesionario
        DELETE FROM VEHICULOSXCONCESIONARIOS WHERE idConcesionario = p_idConcesionario;

        -- Eliminar concesionario
        DELETE FROM CONCESIONARIOS WHERE idConcesionario = p_idConcesionario;

        -- Confirmación de éxito
        SELECT 'Concesionario eliminado exitosamente.' AS Mensaje;
    ELSE
        -- Mensaje si no se encuentra el concesionario
        SELECT CONCAT('No existe un concesionario con el ID: ', p_idConcesionario) AS Mensaje;
    END IF;
END $$

DELIMITER ;

