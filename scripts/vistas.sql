-- 1
CREATE VIEW Tendencias_Ventas AS
 SELECT 
    CASE 
        WHEN c.ingresosAnuales <= 100000 THEN 'Bajo'
        WHEN c.ingresosAnuales BETWEEN 100001 AND 500000 THEN 'Medio'
        WHEN c.ingresosAnuales > 500000 THEN 'Alto'
        ELSE 'No especificado'
    END AS RangoIngresos,
    c.sexo AS Genero,
	 m.marca AS Marca,
    YEAR(v.fecha) AS Año,
    MONTH(v.fecha) AS Mes,
    WEEK(v.fecha) AS Semana,
    COUNT(v.idVenta) AS TotalVentas,
    SUM(v.precio) AS TotalIngresos
FROM 
    compania.VENTAS v
JOIN 
    compania.VEHICULOS veh ON v.VIN = veh.VIN
JOIN 
    compania.MODELOS m ON veh.idModelo = m.idModelo
JOIN 
    compania.CLIENTES c ON v.idCliente = c.idCliente
WHERE 
    v.fecha >= DATE_SUB(CURDATE(), INTERVAL 3 YEAR)
GROUP BY 
    RangoIngresos, c.sexo, m.marca, Año, Mes, Semana
ORDER BY 
    Año, Mes, Semana, RangoIngresos, genero, Marca;
    

-- 2  
CREATE VIEW Transmision_Vehiculo AS
SELECT 
    veh.VIN,
    c.nombre AS Cliente,
    c.direccion AS Direccion,
    c.noTelefono AS Telefono,
    veh.transmision,
    veh.fechaFabricacion,
    p.nombre AS Proveedor,
    pl.idPlanta
FROM 
    compania.VEHICULOS veh
JOIN 
    compania.MODELOS m ON veh.idModelo = m.idModelo
JOIN 
    compania.MODELOSXPROVEEDORES mp ON m.idModelo = mp.idModelo
JOIN 
    compania.PROVEEDORES p ON mp.idProveedor = p.idProveedor
JOIN 
    compania.MODELOSXPLANTAS mpl ON m.idModelo = mpl.idModelo
JOIN 
    compania.PLANTAS pl ON mpl.idPlanta = pl.idPlanta
JOIN 
    compania.VENTAS v ON veh.VIN = v.VIN
JOIN 
    compania.CLIENTES c ON v.idCliente = c.idCliente
WHERE 
p.nombre = 'Central Autoparts'
AND pl.idPlanta = (
   SELECT DISTINCT pl.idPlanta 
   FROM compania.MODELOSXPROVEEDORES mp
   JOIN compania.MODELOSXPLANTAS mpl ON mp.idModelo = mpl.idModelo
   JOIN compania.PROVEEDORES p ON mp.idProveedor = p.idProveedor
   WHERE p.nombre = 'Central Autoparts'
)
 AND veh.transmision = 'manual';



-- 3
CREATE VIEW Mejores_Marcas_Vendidas AS
SELECT 
    m.marca AS Marca,
    SUM(v.precio) AS TotalDolaresVendidos
FROM 
    compania.VENTAS v
JOIN 
    compania.VEHICULOS veh ON v.VIN = veh.VIN
JOIN 
    compania.MODELOS m ON veh.idModelo = m.idModelo
WHERE 
    v.fecha >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) 
GROUP BY 
    m.marca
ORDER BY 
    TotalDolaresVendidos DESC
LIMIT 2;


-- 4
CREATE VIEW Mejores_Marcas_Unidad AS 
SELECT 
    m.marca AS Marca,
    COUNT(v.idVenta) AS UnidadesVendidas
FROM 
    compania.VENTAS v
JOIN 
    compania.VEHICULOS veh ON v.VIN = veh.VIN
JOIN 
    compania.MODELOS m ON veh.idModelo = m.idModelo
WHERE 
    v.fecha >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
GROUP BY 
    m.marca
ORDER BY 
    UnidadesVendidas DESC
LIMIT 2;


-- 5
CREATE VIEW Ventas_Convertibles AS 
SELECT 
    MONTH(v.fecha) AS Mes,
    COUNT(v.idVenta) AS VentasConvertibles
FROM 
    compania.VENTAS v
JOIN 
    compania.VEHICULOS veh ON v.VIN = veh.VIN
JOIN 
    compania.MODELOS m ON veh.idModelo = m.idModelo
WHERE 
    m.estiloCarroceria = 'convertible'
GROUP BY 
    Mes
ORDER BY 
    VentasConvertibles DESC;


-- 6
CREATE VIEW Tiempo_Inventario AS 
SELECT 
    c.nombre AS Concesionario,
    c.direccion AS Direccion,
    AVG(DATEDIFF(v.fecha, i.fechaIngreso)) AS TiempoPromedioInventario
FROM 
    compania.VEHICULOSXCONCESIONARIOS i
JOIN 
    compania.VENTAS v ON i.VIN = v.VIN
JOIN 
    compania.CONCESIONARIOS c ON i.idConcesionario = c.idConcesionario
WHERE 
    v.fecha IS NOT NULL
GROUP BY 
    c.idConcesionario
ORDER BY 
    TiempoPromedioInventario DESC;


-- Procedimiento para buscar transmision defectuosa
DELIMITER $$

CREATE PROCEDURE TransmisionDefectuosa(
    IN f_fechaInicio DATE,
    IN f_fechaFin DATE
)
BEGIN
    SELECT 
        VIN,
        Cliente,
        Direccion,
        Telefono
    FROM 
      Transmision_Vehiculo
    WHERE 
      fechaFabricacion BETWEEN f_fechaInicio AND f_fechaFin;
END$$

DELIMITER ;
