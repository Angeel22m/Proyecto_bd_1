<?php

function handleVehiculos($method) {
    $vehiculos = new VehiculosController();

    switch ($method) {
        case 'POST':
            // Verifica que los datos POST estén presentes
            if (
                isset($_POST['idModelo'], $_POST['VIN'], $_POST['fechaFabricacion'],$_POST['noMotor'],$_POST['color'])
                &&!empty(trim($_POST['idModelo']))            
                &&!empty(trim($_POST['VIN']))
                &&!empty(trim($_POST['fechaFabricacion']))
                &&!empty(trim($_POST['noMotor']))
                &&!empty(trim($_POST['color']))
                &&!empty(trim($_POST['transmision']))

            ) {
                $idModelo = $_POST['idModelo'];
                $noMotor = $_POST['noMotor'];
                $VIN = $_POST['VIN'];
                $fechaFabricacion = $_POST['fechaFabricacion'];
                $color = $_POST['color'];
                $transmision = $_POST['transmision'];
                

                try {
                   
                    $vehiculos->crearVehiculo($idModelo, $noMotor, $VIN, $fechaFabricacion, $color, $transmision);                   
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al crear el vehiculo.",
                        "detalle" => $e->getMessage()
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => 400,
                    "error" => "Faltan datos obligatorios para crear el vehiculos."
                ]);
            }
            break;

        case 'GET':
            try {
                $result = $vehiculos->readAll();               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al obtener los clientes.",
                    "detalle" => $e->getMessage()
                ]);
            }
            break;
            case 'PUT':
                // Obtener el idVe$vehiculos de la ruta (en la URL)
                $vehiculos = isset($_GET['VIN']) ? $_GET['VIN'] : null;
            
                if ($vehiculos) {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El vehiculos es obligatorio para actualizar un Vehiculo."
                    ]);
                    break;
                }
            
                // Leer el cuerpo de la solicitud para obtener los datos del Ve$vehiculos$vehiculos en form data
                parse_str(file_get_contents("php://input"), $putData);
            
                // Validar que al menos un campo opcional esté presente
                $campos = [];
                if (!empty($putData['idModelo'])) $campos['idModelo'] = $putData['idModelo'];               
                if (!empty($putData['fechaFabricacion'])) $campos['fechaFabricacion'] = $putData['fechaFabricacion'];
                if (!empty($putData['noMotor'])) $campos['noMotor'] = $putData['noMotor'];
                if (!empty($putData['color'])) $campos['color'] = $putData['color'];
                if (!empty($putData['transmision'])) $campos['transmision'] = $putData['transmision'];

          
            
                if (empty($campos)) {
                    echo json_encode([
                        "status" => 400,
                        "error" => "Debe proporcionar al menos un campo para actualizar."
                    ]);
                    break;
                }
            
                try {
                    // Llamar al método para actualizar el Vehiculos
                    $vehiculos->actualizarVehiculos($VIN, $campos);                               
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al actualizar el Vehiculos.",
                        "detalle" => $e->getMessage()
                    ]);
                }
                break;
            
            case 'DELETE':
                // Obtener el ID de la Ve$vehiculos desde los parámetros de la URL
                if (isset($_GET['VIN'])) {
                    $vehiculos = $_GET['VIN'];
    
                    try {
                        $vehiculos->eliminarVehiculos($VIN);                       
                    } catch (Exception $e) {
                        echo json_encode([
                            "status" => 500,
                            "error" => "Error interno al eliminar el Vehiculo.",
                            "detalle" => $e->getMessage()
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El VIN es obligatorio para eliminar un Vehiculo."
                    ]);
                }
                break;

        default:
            echo json_encode([
                "status" => 405,
                "detalle" => "Método no permitido."
            ]);
            break;
    }
}