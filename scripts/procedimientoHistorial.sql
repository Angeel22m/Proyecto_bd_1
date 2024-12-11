DELIMITER $$

CREATE PROCEDURE buscarVehiculos(
    IN p_idConcesionario INT,
    IN p_idModelo INT,
    IN p_color ENUM('rojo', 'azul', 'blanco', 'negro', 'gris'),
    IN p_transmision ENUM('manual', 'automática')
)
BEGIN
    INSERT INTO HISTORIAL_BUSQUEDAS (idConcesionario, idModelo, color, transmision)
    VALUES (p_idConcesionario, p_idModelo, p_color, p_transmision);

    SELECT v.VIN, vxc.idConcesionario, v.idModelo, v.color, v.transmision, v.fechaFabricacion
    FROM VEHICULOSXCONCESIONARIOS vxc
    JOIN VEHICULOS v ON v.VIN = vxc.VIN
    WHERE vxc.idConcesionario = p_idConcesionario
        AND (p_idModelo IS NULL OR v.idModelo = p_idModelo)
        AND (p_color IS NULL OR color = p_color)
        AND (p_transmision IS NULL OR transmision = p_transmision);
END$$

DELIMITER ;
