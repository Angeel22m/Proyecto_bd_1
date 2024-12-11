CREATE TABLE HISTORIAL_BUSQUEDAS (
    idBusqueda INT AUTO_INCREMENT PRIMARY KEY,
    idConcesionario INT NOT NULL,
    idModelo INT NULL,
    color ENUM('rojo', 'azul', 'blanco', 'negro', 'gris') NULL,
    transmision ENUM('manual', 'automática') NULL,
    fechaBusqueda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idConcesionario) REFERENCES CONCESIONARIOS(idConcesionario)
        ON DELETE CASCADE ON UPDATE CASCADE
);
