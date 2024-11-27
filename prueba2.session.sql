 
CREATE USER 'Angel'@'localhost' IDENTIFIED BY '12345678';
GRANT SELECT ON compania.clientes TO 'Angel'@'localhost';
-- Agrega más tablas si es necesario
FLUSH PRIVILEGES;


CREATE TABLE usuarios_aplicacion (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    nombreUsuario VARCHAR(50) UNIQUE NOT NULL,
    contrasenaHash VARCHAR(255) NOT NULL,
    rol ENUM('lectura', 'admin') NOT NULL
);

INSERT INTO usuarios_aplicacion (nombreUsuario, contrasenaHash, rol)
VALUES (
    
    'Angel',
    '12345678',
    'lectura'
  );

  SELECT * from usuarios_aplicacion;


  SHOW GRANTS FOR 'usuario'@'localhost';

-- Crea el usuario con contraseña segura
CREATE USER 'Validaciones'@'localhost' IDENTIFIED BY '12345678';

-- Otorga permisos de solo lectura en la tabla usuarios_aplicacion
GRANT SELECT ON compania.usuarios_aplicacion TO 'Validaciones'@'localhost';

-- Guarda los cambios en los privilegios
FLUSH PRIVILEGES;

SELECT * from clientes
