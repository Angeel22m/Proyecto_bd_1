USE compania;
CREATE TABLE Plantas (
  idPlanta INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(20) NOT NULL,
  ubicacion VARCHAR(50) NOT NULL
);

CREATE TABLE MODELOS (
  idModelo INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(10) NOT NULL,
  estiloCarroceria ENUM('sedan', 'hatchback', 'suv', 'coupe', 'pickup') NOT NULL,
  marca VARCHAR(10) NOT NULL
);

CREATE TABLE PROVEEDORES (
  idProveedor INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(20) NOT NULL,
  direccion VARCHAR(50) NOT NULL,
  noTelefono VARCHAR(15) NOT NULL
);

CREATE TABLE VEHICULOS (
  VIN VARCHAR(17) PRIMARY KEY,
  idModelo INT NOT NULL,
  color ENUM('rojo', 'azul', 'blanco', 'negro', 'gris') NOT NULL,
  noMotor INT NOT NULL CHECK (noMotor > 0),
  transmision ENUM('manual', 'automática') NOT NULL,
  FOREIGN KEY (idModelo) REFERENCES Modelos(idModelo)
    ON DELETE CASCADE ON UPDATE CASCADE 
);

CREATE TABLE CONCESIONARIOS (
  idConcesionario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(20) NOT NULL,
  direccion VARCHAR(50) NOT NULL,
  noTelefono VARCHAR(15) NOT NULL
);

CREATE TABLE CLIENTES (
  idCliente INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(20) NOT NULL,
  direccion VARCHAR(50) NOT NULL,
  noTelefono VARCHAR(15) NOT NULL,
  sexo ENUM('masculino', 'femenino', 'otro') NOT NULL,
  ingresosAnuales INT NOT NULL CHECK (ingresosAnuales > 0)
);

CREATE TABLE VENTAS (
  idVenta INT AUTO_INCREMENT PRIMARY KEY,
  fecha DATE NOT NULL,
  idConcesionario INT NOT NULL,
  idCliente INT NOT NULL,
  VIN VARCHAR(17) NOT NULL,
  precio DECIMAL(10,2) NOT NULL CHECK (precio > 0),
  FOREIGN KEY (idConcesionario) REFERENCES Concesionarios(idConcesionario)
        ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (idCliente) REFERENCES Clientes(idCliente),
  FOREIGN KEY (VIN) REFERENCES Vehiculos(VIN)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE MODELOSXPLANTAS (
  idModelo INT NOT NULL,
  idPlanta INT NOT NULL,
  PRIMARY KEY (idModelo, idPlanta),
  FOREIGN KEY (idModelo) REFERENCES Modelos(idModelo)
        ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (idPlanta) REFERENCES Plantas(idPlanta)
        ON DELETE CASCADE ON UPDATE CASCADE 
);

CREATE TABLE MODELOSXPROVEEDORES (
  idModelo INT NOT NULL,
  idProveedor INT NOT NULL,
  PRIMARY KEY (idModelo, idProveedor),
  FOREIGN KEY (idModelo) REFERENCES Modelos(idModelo)
        ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (idProveedor) REFERENCES Proveedores(idProveedor)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE VEHICULOSXCONCESIONARIOS (
  VIN VARCHAR(17) NOT NULL,
  idConcesionario INT NOT NULL,
  PRIMARY KEY (VIN, idConcesionario),
  FOREIGN KEY (VIN) REFERENCES Vehiculos(VIN)
        ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (idConcesionario) REFERENCES Concesionarios(idConcesionario)
        ON DELETE CASCADE ON UPDATE CASCADE
);
