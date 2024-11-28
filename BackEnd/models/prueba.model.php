<?php

class PruebaModel {

    static public function mostrarPrueba() {
        try {
            $connection = Connection::connect();

            if (!$connection) {
                throw new Exception("Error: No se pudo establecer la conexión a la base de datos.");
            }

            $script = $connection->prepare("SELECT * FROM modelos");
            $script->execute();
            $result = $script->fetchAll(PDO::FETCH_CLASS);
            $script->closeCursor();
            $script = null;
            return $result;
        } catch (PDOException $e) {
            // Registrar el error en un archivo de log
            error_log("Error al ejecutar la consulta: " . $e->getMessage(), 3, 'errors.log');
            return [
                "status" => 500,
                "error" => "Error en la base de datos. Verifique permisos o contacte al administrador."
            ];
        } catch (Exception $e) {
            // Manejar otros errores
            error_log("Error general: " . $e->getMessage(), 3, 'errors.log');
            return [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
    }
}
