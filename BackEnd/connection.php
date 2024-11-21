<?php
class Connection {
    

    // Método para establecer conexión
    static public function connect() {
        $host = 'localhost';
        $usuario = 'root';
        $contrasena = '';
        $baseDeDatos = 'compania';
        $puerto = 3307; 
        $conexion = null;

        try {
            // Crear conexión con PDO
            $conexion = new PDO(
                "mysql:host={$host};port={$puerto};dbname={$baseDeDatos};charset=utf8",
                $usuario,
                $contrasena
            );
            // Configurar errores de PDO
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            // Manejar errores
            echo "Error al conectar: " . $e->getMessage();
            $conexion = null; // Asegurar que la conexión sea nula en caso de error
        }
    }

    // Método para cerrar la conexión
    public function desconectar() {
        $conexion = null;
        echo "Conexión cerrada<br>";
    }

    // Método para obtener la conexión actual
    public function getConexion() {
        return $conexion;
    }
}
