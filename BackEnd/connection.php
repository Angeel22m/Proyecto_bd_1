<?php

class Connection {
    private static $conexion = null;

    static public function connect() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || !isset($_SESSION['password'])) {
            header("Location: login.php");
            exit;
        }

        $host = 'database-1.cbaawie4sxdu.us-east-1.rds.amazonaws.com';
        $usuario = $_SESSION['usuario'];
        $contrasena = $_SESSION['password'];
        $baseDeDatos = 'compania';
        $puerto = 3306;

        if (empty($usuario) || empty($contrasena)) {
            echo "Error: Las credenciales de la sesión están vacías.";
            exit;
        }

        try {
            if (self::$conexion === null) {
                self::$conexion = new PDO(
                    "mysql:host={$host};port={$puerto};dbname={$baseDeDatos};charset=utf8",
                    $usuario,
                    $contrasena
                );
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$conexion;
        } catch (PDOException $e) {
            throw new Exception("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }
}
