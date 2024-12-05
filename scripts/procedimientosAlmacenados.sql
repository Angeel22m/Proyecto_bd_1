
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
DELIMITER $$

CREATE PROCEDURE actualizarClientePorId(
    IN p_idCliente INT,
    IN p_nombre VARCHAR(255),
    IN p_direccion VARCHAR(255),
    IN p_sexo ENUM('masculino','femenino','otro'),
    IN p_noTelefono VARCHAR(15),
    IN p_ingresosAnuales INT(10)
)
BEGIN
    -- Verificamos si existe el cliente
    IF EXISTS(SELECT 1 FROM clientes WHERE idCliente = p_idCliente) THEN
        -- Si el cliente existe, realizamos la actualización
        UPDATE clientes
        SET 
            nombre = COALESCE(p_nombre, nombre),
            direccion = COALESCE(p_direccion, direccion),
            sexo = COALESCE(p_sexo, sexo),
            noTelefono = COALESCE(p_noTelefono, noTelefono),
            ingresosAnuales = COALESCE(p_ingresosAnuales, ingresosAnuales)
        WHERE idCliente = p_idCliente;

    ELSE
        -- Si no existe el cliente, enviamos un mensaje con el error
        SELECT CONCAT('No existe cliente con el id: ', p_idCliente) AS Mensaje;
    END IF;
    
END$$

DELIMITER ;


-- procedimiento para elimanar una cliente por id

delimiter $$
CREATE procedure eliminarClientePorId(
    In p_idCliente INT
)
BEGIN
    IF EXISTS (SELECT 1 FROM clientes c WHERE c.idCliente  = p_idCliente) THEN
             DELETE FROM clientes
             WHERE idCliente = p_idCliente;
             SELECT 'cliente eliminado' as Mensaje;
            ELSE
            SELECT CONCAT('no existe una cliente con el Id: ',p_idPlanta) as Mensaje;
     END IF;
END $$

delimiter;


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
