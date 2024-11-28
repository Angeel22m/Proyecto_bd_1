<?php
class ClientesModel {
    static public function crearCliente($nombre, $direccion, $noTelefono, $sexo, $ingresosAnuales) {
        try {
            // Obtener la conexión
            $connection = Connection::connect();

            if (!$connection) {
                throw new Exception("Error: No se pudo establecer la conexión a la base de datos.");
            }

            // Preparar el procedimiento almacenado
            $script = $connection->prepare('CALL crearCliente(:nombre, :direccion, :noTelefono, :sexo, :ingresosAnuales)');

            // Vincular las variables a los parámetros de la consulta
            $script->bindParam(':nombre', $nombre, PDO::PARAM_STR); // Vinculando :nombre
            $script->bindParam(':direccion', $direccion, PDO::PARAM_STR); // Vinculando :direccion
            $script->bindParam(':noTelefono', $noTelefono, PDO::PARAM_STR); // Vinculando :noTelefono
            $script->bindParam(':sexo', $sexo, PDO::PARAM_STR); // Vinculando :sexo
            $script->bindParam(':ingresosAnuales', $ingresosAnuales, PDO::PARAM_INT); // Vinculando :ingresosAnuales

            // Ejecutar la consulta
            $script->execute();

            // Obtener los resultados si existen
            $result = $script->fetchAll(PDO::FETCH_ASSOC);

            // Liberar los recursos
            $script->closeCursor();
            $script = null;

            // Retornar el resultado
            return [
                "status" => 200,
                "message" => "Cliente creado exitosamente",
                "data" => $result
            ];
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

    public static function readAll() {
        try {
            // Preparación de la consulta de lectura.
            $query = Connection::connect()->prepare(
                "select * from vista_clientes"
            );
    
            // Ejecución de la consulta.
            $query->execute();
    
            // Capturando los datos pedidos por la consulta.
            $result = $query->fetchAll(PDO::FETCH_CLASS);
    
            // Finalizando la variable de consulta.
            $query->closeCursor();
            $query = null;
    
            // Retornando los datos solicitados.
            return $result;
    
        } catch (PDOException $e) {
            // Manejo de errores específicos de PDO.
            throw new Exception("Error al leer los datos: " . $e->getMessage());
        } catch (Exception $e) {
            // Manejo de errores generales.
            throw new Exception("Se produjo un error: " . $e->getMessage());
        }
    }
    

    public static function updateCliente($Datos){



    }
    
}
