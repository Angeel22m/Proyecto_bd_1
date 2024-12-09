<?php
class VehiculosModel{

    
    static public function crearVehiculo($idModelo, $noMotor, $VIN, $fechaFabricacion, $color, $transmision) {
        try {
            // Obtener la conexión
            $connection = Connection::connect();

            if (!$connection) {
                throw new Exception("Error: No se pudo establecer la conexión a la base de datos.");
            }

            // Preparar el procedimiento almacenado
            $script = $connection->prepare('CALL crearVehiculo(:VIN,:idModelo,:color,:noMotor,:transmision,:fechaFabricacion)');

            // Vincular las variables a los parámetros de la consulta
            $script->bindParam(':VIN', $VIN, PDO::PARAM_STR); // Vinculando :VIN
            $script->bindParam(':idModelo', $idModelo, PDO::PARAM_INT); // Vinculando :idModelo
            $script->bindParam(':color', $color, PDO::PARAM_STR); // Vinculando :color
            $script->bindParam(':noMotor', $noMotor, PDO::PARAM_INT); // Vinculando :noMotor
            $script->bindParam(':transmision', $transmision, PDO::PARAM_STR); // Vinculando :transmision
            $script->bindParam(':fechaFabricacion', $fechaFabricacion, PDO::PARAM_STR); // Vinculando :transmision

            
    
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
                "select * from VEHICULOS"
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
    

    public static function actualizarVehiculo($VIN, $Datos)
{
    // Preparación de la consulta
    $query = Connection::connect()->prepare(
        "CALL actualizarVehiculo(
            :VIN,
            :idModelo,
            :color,
            :noMotor,
            :transmision,
            :fechaFabricacion
        )"
    );

    // Vinculación de los parámetros    
    $query->bindParam(":VIN", $VIN, PDO::PARAM_STR);
    $query->bindParam(":idModelo", $Datos["idModelo"], PDO::PARAM_INT);
    $query->bindParam(":noMotor", $Datos["noMotor"], PDO::PARAM_STR); // Revisar tipo de dato
    $query->bindParam(":color", $Datos["color"], PDO::PARAM_STR);
    $query->bindParam(":transmision", $Datos["transmision"], PDO::PARAM_STR);
    $query->bindParam(":fechaFabricacion", $Datos["fechaFabricacion"], PDO::PARAM_STR);

    try {
        // Ejecución de la consulta
        $query->execute();

        // Obtener el mensaje de la consulta
        $message = $query->fetch(PDO::FETCH_ASSOC);

        // Verificar si se obtuvo un mensaje
        if ($message && isset($message['Mensaje'])) {
            if (stripos($message['Mensaje'], 'exitosamente') !== false) {
                // Éxito en la actualización
                echo json_encode([
                    "status" => 200,
                    "message" => $message['Mensaje']
                ]);
            } else {
                // Error en la actualización
                echo json_encode([
                    "status" => 404,
                    "error" => $message['Mensaje']
                ]);
            }
        } else {
            // Sin mensaje devuelto
            echo json_encode([
                "status" => 500,
                "error" => "Error al obtener el mensaje del procedimiento almacenado."
            ]);
        }
    } catch (PDOException $e) {
        // Error en la ejecución del procedimiento
        echo json_encode([
            "status" => 500,
            "error" => "Error interno al actualizar el vehículo.",
            "detalle" => $e->getMessage()
        ]);
    }
}


    public static function eliminarVehiculo($VIN) {
       $conn = Connection::connect(); 
        try {
            // Preparar la consulta SQL para eliminar el cliente por su ID
            $stmt = $conn->prepare("call eliminarVehiculo(:VIN)");
            $stmt->bindParam(':VIN', $VIN, PDO::PARAM_STR);
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

    
    public static function buscarVehiculo($datos) {
        try {
            // Preparación de la consulta de lectura.
            $query = Connection::connect()->prepare(
                "call BuscarVehiculos(:color,:transmision,:estiloCarroceria,:marca)"

            );
           
            $query->bindParam(":color", $datos["color"], PDO::PARAM_STR);           
            $query->bindParam(":transmision", $datos["transmision"], PDO::PARAM_STR);
            $query->bindParam(":estiloCarroceria", $datos["estiloCarroceria"], PDO::PARAM_STR);
            $query->bindParam(":marca", $datos["marca"], PDO::PARAM_STR);    
    
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
}