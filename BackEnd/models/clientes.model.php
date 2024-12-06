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
            $script = $connection->prepare('CALL crearCliente(:)');

            // Vincular las variables a los parámetros de la consulta
            $script->bindParam(':nombre', $nombre, PDO::PARAM_STR); // Vinculando :nombre
            $script->bindParam(':direccion', $direccion, PDO::PARAM_STR); // Vinculando :direccion
            $script->bindParam(':noTelefono', $noTelefono, PDO::PARAM_STR); // Vinculando :noTelefono
            $script->bindParam(':sexo', $sexo, PDO::PARAM_STR); // Vinculando :sexo
            $script->bindParam(':ingresosAnuales', $ingresosAnuales, PDO::PARAM_INT); // Vinculando :ingresosAnuales

            
    
            // Ejecutar la consulta
            $script->execute();
    
            // Obtener el mensaje de la consulta
            $message = $script->fetch(PDO::FETCH_ASSOC);
    
            // Liberar los recursos
            $script->closeCursor();
            $script = null;
    
            // Verificar el mensaje y tomar acción
            if ($message) {
                if (strpos($message['Mensaje'], 'exitosamente') !== false) {
                    // Si el mensaje contiene "exitosamente"
                    echo json_encode([
                        "status" => 200,
                        "message" => $message['Mensaje']
                    ]);
                } else {
                    // Si no contiene "exitosamente"
                    echo json_encode([
                        "status" => 404,
                        "error" => $message['Mensaje']
                    ]);
                }
            } else {
                // Si no hay mensaje (posible error al ejecutar el procedimiento)
                echo json_encode([
                    "status" => 404,
                    "error" => "No se pudo crear el cliente."
                ]);
            }
    
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
                "select * from CLIENTES"
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
    

    public static function actualizarCliente($Datos){
        
// Preparación de la consulta de actualización
$query = Connection::connect()->prepare(
    "CALL actualizarClientePorId(
        :idCliente,
        :nombre,
        :direccion,
        :sexo,
        :noTelefono,
        :ingresosAnuales
    )"
);

// Vinculación de los parámetros
$query->bindParam(":idCliente", $Datos["idCliente"], PDO::PARAM_INT);
$query->bindParam(":nombre", $Datos["nombre"], PDO::PARAM_STR);
$query->bindParam(":direccion", $Datos["direccion"], PDO::PARAM_STR);
$query->bindParam(":sexo", $Datos["sexo"], PDO::PARAM_STR);
$query->bindParam(":noTelefono", $Datos["noTelefono"], PDO::PARAM_STR);
$query->bindParam(":ingresosAnuales", $Datos["ingresosAnuales"], PDO::PARAM_STR);

try {
    // Ejecución de la consulta
    $query->execute();

// Obtener el mensaje de la consulta
$message = $query->fetch(PDO::FETCH_ASSOC);

// Verificar el mensaje y tomar acción
if ($message) {
    if (strpos($message['Mensaje'], 'exitosamente') !== false) {
        // Si el mensaje contiene "exitosamente", significa que el cliente fue actualizado
        echo json_encode([
            "status" => 200,
            "message" => $message['Mensaje']
        ]);
    } else {
        // Si no contiene "exitosamente", significa que no se encontró al cliente
        echo json_encode([
            "status" => 404,
            "error" => $message['Mensaje']
        ]);
    }
}
} catch (PDOException $e) {
    echo json_encode([
        "status" => 500,
        "error" => "Error interno al actualizar el cliente.",
        "detalle" => $e->getMessage()
    ]);
}

    }


    public static function eliminarClientePorID($idCliente) {
       $conn = Connection::connect(); 
        try {
            // Preparar la consulta SQL para eliminar el cliente por su ID
            $stmt = $conn->prepare("call eliminarClientePorId(:idCliente)");
            $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmt->execute();
            
// Obtener el mensaje de la consulta
$message = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar el mensaje y tomar acción
if ($message) {
    if (strpos($message['Mensaje'], 'exitosamente') !== false) {
        // Si el mensaje contiene "exitosamente", significa que el cliente fue eliminado
        echo json_encode([
            "status" => 200,
            "message" => $message['Mensaje']
        ]);
    } else {
        // Si no contiene "exitosamente", significa que no se encontró al cliente
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
