
---procedimiento para crear una nueva planta

DELIMITER $$

CREATE PROCEDURE registrarNuevaPlanta(
    IN p_nombre VARCHAR(20),
    IN p_ubicacion VARCHAR(50)
)
BEGIN
    IF NOT EXISTS (
        SELECT 1 
        FROM Plantas 
        WHERE nombre = p_nombre 
          AND ubicacion = p_ubicacion
    ) THEN
        INSERT INTO Plantas (nombre, ubicacion) 
        VALUES (p_nombre, p_ubicacion);
        SELECT 'Planta registrada exitosamente.' AS Mensaje;
    ELSE
        SELECT 'Ya existe una planta con el mismo nombre y ubicación.' AS Mensaje;
    END IF;
END$$

DELIMITER ;


--procdedimiento para actualizar planta
DELIMITER $$

CREATE PROCEDURE actualizarPlantaPorId(
    IN p_idPlanta INT,
    IN p_nombre VARCHAR(20),
    IN p_ubicacion VARCHAR(50)
)
BEGIN
    -- Verifica si la planta existe
    IF EXISTS (
        SELECT 1 
        FROM Plantas 
        WHERE idPlanta = p_idPlanta
    ) THEN
        -- Actualiza los campos proporcionados
        UPDATE Plantas
        SET 
            nombre = COALESCE(p_nombre, nombre),
            ubicacion = COALESCE(p_ubicacion, ubicacion)
        WHERE idPlanta = p_idPlanta;

        SELECT CONCAT('La planta con ID ', p_idPlanta, ' fue actualizada correctamente.') AS Mensaje;
    ELSE
        SELECT CONCAT('No existe una planta con el ID: ', p_idPlanta) AS Mensaje;
    END IF;
END$$

DELIMITER ;

-- procedimiento para eliminar planta

CREATE PROCEDURE eliminarPlantaPorId(
    IN p_idPlanta INT
)
BEGIN
    -- Verifica si la planta existe
    IF EXISTS (
        SELECT 1 
        FROM Plantas 
        WHERE idPlanta = p_idPlanta
    ) THEN
        -- Elimina registros relacionados en ModelosXPlantas
        DELETE FROM ModelosXPlantas 
        WHERE idPlanta = p_idPlanta;

        -- Elimina la planta
        DELETE FROM Plantas 
        WHERE idPlanta = p_idPlanta;

        SELECT CONCAT('La planta con ID ', p_idPlanta, ' y sus registros relacionados fueron eliminados.') AS Mensaje;
    ELSE
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

CREATE PROCEDURE actualizarClientePorId(
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

--procedimiento para eliminar un cliente 
DELIMITER $$

CREATE PROCEDURE eliminarClientePorId(
    IN p_idCliente INT
)
BEGIN
    -- Verificar si el cliente existe
    IF EXISTS (SELECT 1 FROM CLIENTES WHERE idCliente = p_idCliente) THEN
        DELETE FROM CLIENTES WHERE idCliente = p_idCliente;
        -- Confirmación
        SELECT 'Cliente eliminado exitosamente.' AS Mensaje;
    ELSE
        -- Cliente no encontrado
        SELECT CONCAT('No existe un cliente con el ID: ', p_idCliente) AS Mensaje;
    END IF;
END $$

DELIMITER ;



-- procedimiento para crear un nuevo vehiculo
DELIMITER $$

CREATE PROCEDURE registrarNuevoVehiculo(
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
    IN v_VIN VARCHAR(17))
BEGIN     
	 IF EXISTS (SELECT 1 FROM VEHICULOS v WHERE v.VIN = v_VIN) THEN
            DELETE FROM vehiculos
            WHERE VIN = v_VIN;
         SELECT 'Vehiculo eliminado exitosamente' AS mensaje;
      ELSE
         SELECT 'El vehículo con el VIN especificado no existe' AS mensaje;
      END IF;
END$$
DELIMITER ;

-- procedimiento para añadir un proveedor
DELIMITER $$

CREATE PROCEDURE nuevoProveedor(
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
	 SELECT 'Ya esxiste un proveedor con estos datos' AS mensaje;
   ELSE
   INSERT INTO PROVEEDORES (nombre, direccion, noTelefono)
   VALUES (p_nombre, p_direccion, p_noTelefono);
   SELECT 'Proveedor añadido con exito ' AS mensaje;
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
	UPDATE proveedores SET 
	nombre = COALESCE(p_nombre, nombre),
	direccion = COALESCE(p_direccion, direccion),
	noTelefono = COALESCE(p_noTelefono, noTelefono)
	WHERE idProveedor = p_idProveedor;
   SELECT 'Proveedor actualizado con exito ' AS mensaje;
   ELSE
   SELECT 'No esxiste un proveedor con estos datos' AS mensaje;
   END IF;
END$$
DELIMITER ;

-- procedimiento para eliminar un proveedor
DELIMITER $$

CREATE PROCEDURE eliminarProveedor(
	p_idProveedor INT)
BEGIN     
	 IF EXISTS (
	 SELECT 1 FROM PROVEEDORES p
	 WHERE p.idProveedor = p_idProveedor
	 ) THEN
	DELETE FROM proveedores WHERE idProveedor = p_idProveedor; 
   SELECT 'Proveedor eliminado con exito ' AS mensaje;
   ELSE
   SELECT 'No esxiste un proveedor con estos datos' AS mensaje;
   END IF;
END$$
DELIMITER ;

-- procedimiento para añadir un nuevo modelo
DELIMITER $$

CREATE PROCEDURE nuevoModelo(
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
	SELECT 'Ya esxiste un modelo con estos datos' AS mensaje;
   ELSE
   INSERT INTO modelos (nombre, estiloCarroceria, marca)
   VALUES (m_nombre, m_estiloCarroceria, m_marca);
   SELECT 'Modelo agregado con exito ' AS mensaje;
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
   SELECT 'Modelo actualizado con exito ' AS mensaje;
   ELSE
   SELECT 'No esxiste un modelo con estos datos' AS mensaje;
   END IF;
END$$
DELIMITER ;

-- procedimiento para eliminar un modelos
DELIMITER $$

CREATE PROCEDURE eliminarModelo(
	m_idModelo INT)
BEGIN     
	 IF EXISTS (
	 SELECT 1 FROM MODELOS m
	 WHERE m.idModelo = m_idModelo
	 ) THEN
	DELETE FROM MODELOS
	WHERE idModelo = m_idModelo;
   SELECT 'Modelo eliminado con exito ' AS mensaje;
   ELSE
   SELECT 'No esxiste un modelo con estos datos' AS mensaje;
   END IF;
END$$
DELIMITER ;

--procedimiento para crear ventas
DELIMITER $$

CREATE PROCEDURE crearVenta(
    IN p_fecha DATE,
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
        -- Intentar crear la venta
        INSERT INTO VENTAS (fecha, idConcesionario, idCliente, VIN, precio)
        VALUES (p_fecha, p_idConcesionario, p_idCliente, p_VIN, p_precio);
        SELECT 'Venta creada exitosamente.' AS Mensaje;
    END IF;
END$$

DELIMITER ;


--procedimiento para actualizar ventas

DELIMITER $$

CREATE PROCEDURE actualizarVenta(
    IN p_idVenta INT,
    IN p_fecha DATE,
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
        SELECT CONCAT('Error al actualizar la venta: ', v_error_message) AS Mensaje;
    END;

    -- Verificar si la venta existe
    IF EXISTS (SELECT 1 FROM VENTAS WHERE idVenta = p_idVenta) THEN
        -- Actualizar la venta
        UPDATE VENTAS
        SET 
            fecha = COALESCE(p_fecha, fecha),
            idConcesionario = COALESCE(p_idConcesionario, idConcesionario),
            idCliente = COALESCE(p_idCliente, idCliente),
            VIN = COALESCE(p_VIN, VIN),
            precio = COALESCE(p_precio, precio)
        WHERE idVenta = p_idVenta;
        SELECT 'Venta actualizada exitosamente.' AS Mensaje;
    ELSE
        SELECT CONCAT('No existe una venta con el ID: ', p_idVenta) AS Mensaje;
    END IF;
END$$

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

CREATE PROCEDURE actualizarConcesionarioPorId(
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

--procedimiento para eliminar consecionario
DELIMITER $$

CREATE PROCEDURE eliminarConcesionarioPorId(
    IN p_idConcesionario INT
)
BEGIN
    -- Verificar si el concesionario existe
    IF EXISTS (SELECT 1 FROM CONCESIONARIOS WHERE idConcesionario = p_idConcesionario) THEN
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



