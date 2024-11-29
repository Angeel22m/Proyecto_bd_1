<?php

class Login {

    // Definir constantes de configuración de la base de datos
    const DB_HOST = 'localhost';
    const DB_PORT = 3308;
    const DB_NAME = 'compania';
    const DB_USER_ADMIN = 'Validaciones';  // Usuario con permisos de validación
    const DB_PASS_ADMIN = '12345678';    // Contraseña del usuario admin

    /**
     * Conexión a la base de datos usando PDO
     */
    private function conectarDB($usuario, $contrasena) {
        try {
            $dsn = "mysql:host=" . self::DB_HOST . ";port=" . self::DB_PORT . ";dbname=" . self::DB_NAME;
            $conn = new PDO($dsn, $usuario, $contrasena);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            // En lugar de die(), se puede registrar el error y retornar un mensaje genérico
            error_log("Error en la conexión: " . $e->getMessage());
            return null; // Retornar null si la conexión falla
        }
    }

    /**
     * Valida las credenciales del usuario
     */
    public function validarUsuario($nombreUsuario, $contrasena) {
        // Intentamos conectar con el usuario administrador para validar las credenciales
        $conn = $this->conectarDB(self::DB_USER_ADMIN, self::DB_PASS_ADMIN);

        if ($conn === null) {
            return false; // Si no se pudo conectar, retornar false
        }

        try {
            $stmt = $conn->prepare("SELECT contrasenaHash, rol FROM usuarios_aplicacion WHERE nombreUsuario = :nombreUsuario");
            $stmt->bindParam(':nombreUsuario', $nombreUsuario);
            $stmt->execute();

            // Verificamos si existe el usuario en la base de datos
            if ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Validamos la contraseña con password_verify
                if (password_verify($contrasena, $fila['contrasenaHash'])) {
                    return $fila['rol']; // Retorna el rol del usuario si las credenciales son correctas
                } else {
                    return false; // Contraseña incorrecta
                }
            }

            return false; // Usuario no encontrado

        } catch (PDOException $e) {
            // Loguear error en la base de datos y retornar un mensaje general
            error_log("Error al validar usuario: " . $e->getMessage());
            return false; // Devolver false si ocurre un error en la consulta
        } finally {
            // Cerramos la conexión explícitamente
            $conn = null;
        }
    }
}

?>