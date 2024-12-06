<?php
class VentasModel {
    static public function crearVenta($idConcesionario, $idCliente, $VIN, $precio) {
        try {
            // Obtener la conexión
            $connection = Connection::connect();
    
            if (!$connection) {
                throw new Exception("Error: No se pudo establecer la conexión a la base de datos.");
            }
    
            // Preparar el procedimiento almacenado
            $script = $connection->prepare('CALL crearVenta(:idConcesionario, :idCliente, :VIN, :precio)');
    
            // Vincular las variables a los parámetros de la consulta
            $script->bindParam(':idConcesionario', $idConcesionario, PDO::PARAM_STR); // Vinculando :idConcesionario
            $script->bindParam(':idCliente', $idCliente, PDO::PARAM_STR); // Vinculando :idVenta
            $script->bindParam(':VIN', $VIN, PDO::PARAM_STR); // Vinculando :VIN
            $script->bindParam(':precio', $precio, PDO::PARAM_STR); // Vinculando :precio
            
    
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
                    // Si el mensaje contiene "exitosamente", significa que la venta fue creada
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
                "select * from VENTAS"
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
    

    public static function actualizarVenta($Datos){
        
// Preparación de la consulta de actualización
$query = Connection::connect()->prepare(
    "CALL actualizarVenta(
       :idVenta,
    :idConcesionario,
    :idCliente,
    :VIN,
    :precio
    )"
);

// Vinculación de los parámetros
$query->bindParam(":idVenta", $Datos["idVenta"], PDO::PARAM_INT);
$query->bindParam(":idConcesionario", $Datos["idConcesionario"], PDO::PARAM_STR);
$query->bindParam(":idCliente", $Datos["idCliente"], PDO::PARAM_STR);
$query->bindParam(":VIN", $Datos["VIN"], PDO::PARAM_STR);
$query->bindParam(":precio", $Datos["precio"], PDO::PARAM_STR);

try {
    // Ejecución de la consulta
    $query->execute();

// Obtener el mensaje de la consulta
$message = $query->fetch(PDO::FETCH_ASSOC);

// Verificar el mensaje y tomar acción
if ($message) {
    if (strpos($message['Mensaje'], 'exitosamente') !== false) {
        // Si el mensaje contiene "exitosamente"
        echo json_encode([
            "status" => 200,
            "message" => $message['Mensaje']
        ]);
    } else {
        // Si no contiene "exitosamente",
        echo json_encode([
            "status" => 404,
            "error" => $message['Mensaje']
        ]);
    }
}
} catch (PDOException $e) {
    echo json_encode([
        "status" => 500,
        "error" => "Error interno al actualizar la venta.",
        "detalle" => $e->getMessage()
    ]);
}

    }


    public static function eliminarVenta($idVenta) {
       $conn = Connection::connect(); 
        try {
            // Preparar la consulta SQL para eliminar el cliente por su ID
            $stmt = $conn->prepare("call eliminarVenta(:idVenta)");
            $stmt->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
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
