USE compania;

-- Insertar datos en la tabla Plantas
INSERT INTO Plantas (nombre, ubicacion) VALUES 
('Planta Norte', 'Monterrey'),
('Planta Sur', 'Guadalajara'),
('Planta Este', 'Ciudad de México'),
('Planta Oeste', 'Tijuana'),
('Planta Central', 'Querétaro');

-- Insertar datos en la tabla Modelos
INSERT INTO Modelos (nombre, estiloCarroceria, marca) VALUES 
('Modelo A', 'sedan', 'Toyota'),
('Modelo B', 'suv', 'Honda'),
('Modelo C', 'hatchback', 'Ford'),
('Modelo D', 'pickup', 'Chevrolet'),
('Modelo E', 'coupe', 'Nissan');

-- Insertar datos en la tabla Proveedores
INSERT INTO Proveedores (nombre, direccion, noTelefono) VALUES 
('Proveedor Uno', 'Av. Central 123', '+521234567890'),
('Proveedor Dos', 'Calle 4 #567', '+529876543210'),
('Proveedor Tres', 'Blvd. Norte 300', '+523451234567'),
('Proveedor Cuatro', 'Av. Sur #1500', '+524321098765'),
('Proveedor Cinco', 'Calle 10, Zona Centro', '+525678123450');

-- Insertar datos en la tabla Vehiculos
INSERT INTO Vehiculos (VIN, idModelo, color, noMotor, transmision) VALUES 
('1HGCM82633A123456', 1, 'rojo', 123456, 'manual'),
('2FZHAZBD21AH12345', 2, 'azul', 234567, 'automática'),
('3GCEK14T94G123456', 3, 'blanco', 345678, 'manual'),
('1FTFW1EF1EFA12345', 4, 'negro', 456789, 'automática'),
('5N1AT2MT0GC123456', 5, 'gris', 567890, 'manual');

-- Insertar datos en la tabla Concesionarios
INSERT INTO Concesionarios (nombre, direccion, noTelefono) VALUES 
('Concesionario Norte', 'Av. Norte 200', '+529993321123'),
('Concesionario Sur', 'Av. Sur 220', '+529993322456'),
('Concesionario Este', 'Av. Este 330', '+529993333789'),
('Concesionario Oeste', 'Av. Oeste 440', '+529993344012'),
('Concesionario Central', 'Av. Centro 550', '+529993355345');

-- Insertar datos en la tabla Clientes
INSERT INTO Clientes (nombre, direccion, noTelefono, sexo, ingresosAnuales) VALUES 
('Carlos Ramírez', 'Calle 1 #123', '+521234567890', 'masculino', 500000),
('Ana López', 'Calle 2 #456', '+521234567891', 'femenino', 600000),
('Luis Pérez', 'Calle 3 #789', '+521234567892', 'masculino', 450000),
('Marta Rodríguez', 'Calle 4 #101', '+521234567893', 'femenino', 550000),
('José García', 'Calle 5 #112', '+521234567894', 'otro', 700000);

-- Insertar datos en la tabla Ventas
INSERT INTO Ventas (fecha, idConcesionario, idCliente, VIN, precio) VALUES 
('2023-01-15', 1, 1, '1HGCM82633A123456', 300000.00),
('2023-02-20', 2, 2, '2FZHAZBD21AH12345', 400000.00),
('2023-03-10', 3, 3, '3GCEK14T94G123456', 350000.00),
('2023-04-05', 4, 4, '1FTFW1EF1EFA12345', 450000.00),
('2023-05-25', 5, 5, '5N1AT2MT0GC123456', 500000.00);

-- Insertar datos en la tabla ModelosXPlantas
INSERT INTO ModelosXPlantas (idModelo, idPlanta) VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Insertar datos en la tabla ModelosXProveedores
INSERT INTO ModelosXProveedores (idModelo, idProveedor) VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Insertar datos en la tabla VehiculosXConcesionarios
INSERT INTO VehiculosXConcesionarios (VIN, idConcesionario) VALUES 
('1HGCM82633A123456', 1),
('2FZHAZBD21AH12345', 2),
('3GCEK14T94G123456', 3),
('1FTFW1EF1EFA12345', 4),
('5N1AT2MT0GC123456', 5);

INSERT INTO Vehiculos (VIN, idModelo, color, noMotor, transmision) 
VALUES 
('JHMFA16507S123987', 2, 'gris', 678901, 'manual'),
('1FAFP4042WF123654', 3, 'rojo', 789012, 'automática'),
('4T1BF1FK7FU123789', 1, 'azul', 890123, 'manual'),
('3GCUKREC4FG123321', 4, 'negro', 901234, 'automática'),
('WBA3A5C50CF123432', 5, 'blanco', 123789, 'manual');



