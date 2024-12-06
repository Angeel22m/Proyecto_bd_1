<?php
class ModelosModel {
    static public function nuevoModelo($nombre, $estiloCarroceria, $marca) {
        try {
            // Obtener la conexión
            $connection = Connection::connect();

            if (!$connection) {
                throw new Exception("Error: No se pudo establecer la conexión a la base de datos.");
            }

            // Preparar el procedimiento almacenado
            $script = $connection->prepare('CALL nuevoModelo(:nombre, :estiloCarroceria, :marca)');

            // Vincular las variables a los parámetros de la consulta
            $script->bindParam(':nombre', $nombre, PDO::PARAM_STR); // Vinculando :nombre
            $script->bindParam(':estiloCarroceria', $estiloCarroceria, PDO::PARAM_STR); // Vinculando :estiloCarroceria
	    $script->bindParam(':marca', $marca, PDO::PARAM_STR); // Vinculando :marca
           

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
                "message" => "Modelo creado exitosamente",
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
                "select * from vista_modelos"
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
    

    public static function actualizarModelo($Datos){
        
// Preparación de la consulta de actualización
$query = Connection::connect()->prepare(
    "CALL actualizarModelo(
        :idModelo,
        :nombre,
        :estiloCarroceria,
        :marca
    )"
);

// Vinculación de los parámetros
$query->bindParam(":idModelo", $Datos["idModelo"], PDO::PARAM_INT);
$query->bindParam(":nombre", $Datos["nombre"], PDO::PARAM_STR);
$query->bindParam(":estiloCarroceria", $Datos["estiloCarroceria"], PDO::PARAM_STR);
$query->bindParam(":marca", $Datos["marca"], PDO::PARAM_STR);


try {
    // Ejecución de la consulta
    $query->execute();

// Obtener el mensaje de la consulta
$message = $query->fetch(PDO::FETCH_ASSOC);
 
// Verificar el mensaje y tomar acción
if ($message) {
    if (strpos($message['Mensaje'], 'exitosamente') !== false) {
        // Si el mensaje contiene "exitosamente", significa que el modelo fue actualizado
        echo json_encode([
            "status" => 200,
            "message" => $message['Mensaje']
        ]);
    } else {
        // Si no contiene "exitosamente", significa que no se encontró al modelo
        echo json_encode([
            "status" => 404,
            "error" => $message['Mensaje']
        ]);
    }
}   
} catch (PDOException $e) {
    echo json_encode([
        "status" => 500,
        "error" => "Error interno al actualizar el modelo.",
        "detalle" => $e->getMessage()
    ]);
}

    }


    public static function eliminarModelo($idModelo) {
       $conn = Connection::connect(); 
        try {
            // Preparar la consulta SQL para eliminar el modelo por su ID
            $stmt = $conn->prepare("call eliminarModelo(:idModelo)");
            $stmt->bindParam(':idModelo', $idModelo, PDO::PARAM_INT);
            $stmt->execute();

// Obtener el mensaje de la consulta
$message = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar el mensaje y tomar acción
if ($message) {
    if (strpos($message['Mensaje'], 'exitosamente') !== false) {
        // Si el mensaje contiene "exitosamente", significa que el modelo fue eliminado
        echo json_encode([
            "status" => 200,
            "message" => $message['Mensaje']
        ]);
    } else {
        // Si no contiene "exitosamente", significa que no se encontró al modelo
        echo json_encode([
            "status" => 404,
            "error" => $message['Mensaje']
        ]);
     }
}

        } catch (Exception $e) {
            // Manejo de errores, por ejemplo, si la base de datos no responde
            error_log($e->getMessage()); // Registrar el error en un log
            return false;
        }
    }
    
}
