<?php
class Connection {
    private $conexion;

    // Método para establecer conexión
    public function conectar() {
        $host = 'localhost';
        $usuario = 'root';
        $contrasena = '';
        $baseDeDatos = 'compania';
        $puerto = 3307; 
        $this->conexion = null;

        try {
            // Crear conexión con PDO
            $this->conexion = new PDO(
                "mysql:host={$host};port={$puerto};dbname={$baseDeDatos};charset=utf8",
                $usuario,
                $contrasena
            );
            // Configurar errores de PDO
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conexión exitosa a MariaDB<br>";
        } catch (PDOException $e) {
            // Manejar errores
            echo "Error al conectar: " . $e->getMessage();
            $this->conexion = null; // Asegurar que la conexión sea nula en caso de error
        }
    }

    // Método para cerrar la conexión
    public function desconectar() {
        $this->conexion = null;
        echo "Conexión cerrada<br>";
    }

    // Método para obtener la conexión actual
    public function getConexion() {
        return $this->conexion;
    }
}
