<?php

// Obtención de la ruta y parámetros de la solicitud
$requestUri = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'] ?? '';
$queryString = $parsedUrl['query'] ?? '';

$arrayRutas = explode('/', trim($path, '/'));
$queryParams = [];
parse_str($queryString, $queryParams);

// Asegúrate de trabajar con índices continuos y revisar bien la URL
$arrayRutas = array_values(array_filter($arrayRutas));

// Verifica que la ruta tiene al menos los segmentos necesarios
if (count($arrayRutas) >= 3) {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $archiveRoute = $arrayRutas[2] ?? null; // Tercer segmento

    switch ($archiveRoute) {
        case 'login':
            handleLogin($requestMethod);
            break;

        case 'cliente';
            handleCliente($requestMethod);
            break;

        case 'ventas';
            handleVentas($requestMethod);
            break;

        default:
            // Respuesta para rutas no encontradas
            echo json_encode([
                "status" => 404,
                "detalle" => "Página no encontrada."
            ]);
            break;
        
    }
} else {
    echo json_encode([
        "status" => 404,
        "detalle" => "Ruta incompleta o no encontrada."
    ]);
}


function handleLogin($method) {
    if ($method === 'POST') {
        session_start();

        // Verifica que los datos POST estén presentes
        if (isset($_POST['nombreUsuario']) && isset($_POST['contrasena'])) {
            $nombreUsuario = $_POST['nombreUsuario'];
            $contrasena = $_POST['contrasena'];
            $login = new Login();
            $rol = $login->validarUsuario($nombreUsuario, $contrasena);

            if ($rol) {
                // Establece la conexión con el usuario correcto
                $_SESSION['usuario'] = $nombreUsuario;
                $_SESSION['password'] = $contrasena;
                $_SESSION['rol'] = $rol;

                echo json_encode([
                    "status" => 200,
                    "message" => "Inicio de sesión exitoso.",
                    "rol" => $rol
                ]);
            } else {
                echo json_encode([
                    "status" => 401,
                    "detalle" => "Credenciales inválidas."
                ]);
            }
        } else {
            echo json_encode([
                "status" => 400,
                "detalle" => "Faltan datos de inicio de sesión.",
                "mensaje"=> !empty($nombreUsuario) ? $nombreUsuario : null
            ]);
        }
    } else {
        echo json_encode([
            "status" => 405,
            "detalle" => "Método no permitido."
        ]);
    }
}


function handleCliente($method) {
    $cliente = new ClientesController();

    switch ($method) {
        case 'POST':
            // Verifica que los datos POST estén presentes
            if (
                isset($_POST['nombre'], $_POST['direccion'], $_POST['noTelefono'], $_POST['sexo'], $_POST['ingresosAnuales'])
            ) {
                $nombre = $_POST['nombre'];
                $direccion = $_POST['direccion'];
                $noTelefono = $_POST['noTelefono'];
                $sexo = $_POST['sexo'];
                $ingresosAnuales = $_POST['ingresosAnuales'];

                try {
                    $cliente->crearCliente($nombre, $direccion, $noTelefono, $sexo, $ingresosAnuales);                   
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al crear el cliente.",
                        "detalle" => $e->getMessage()
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => 400,
                    "error" => "Faltan datos obligatorios para crear el cliente."
                ]);
            }
            break;

        case 'GET':
            try {
                $result = $cliente->readAll();               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al obtener los clientes.",
                    "detalle" => $e->getMessage()
                ]);
            }
            break;
            case 'PUT':
                // Obtener el idCliente de la ruta (en la URL)
                $idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : null;
            
                if (!$idCliente) {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El idCliente es obligatorio para actualizar un cliente."
                    ]);
                    break;
                }
            
                // Leer el cuerpo de la solicitud para obtener los datos del cliente en form data
                parse_str(file_get_contents("php://input"), $putData);
            
                // Validar que al menos un campo opcional esté presente
                $campos = [];
                if (!empty($putData['nombre'])) $campos['nombre'] = $putData['nombre'];
                if (!empty($putData['direccion'])) $campos['direccion'] = $putData['direccion'];
                if (!empty($putData['noTelefono'])) $campos['noTelefono'] = $putData['noTelefono'];
                if (!empty($putData['sexo'])) $campos['sexo'] = $putData['sexo'];
                if (!empty($putData['ingresosAnuales'])) $campos['ingresosAnuales'] = $putData['ingresosAnuales'];
            
                if (empty($campos)) {
                    echo json_encode([
                        "status" => 400,
                        "error" => "Debe proporcionar al menos un campo para actualizar."
                    ]);
                    break;
                }
            
                try {
                    // Llamar al método para actualizar el cliente
                    $cliente->actualizarCliente($idCliente, $campos);                               
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al actualizar el cliente.",
                        "detalle" => $e->getMessage()
                    ]);
                }
                break;
            
            case 'DELETE':
                // Obtener el ID del cliente desde los parámetros de la URL
                if (isset($_GET['idCliente'])) {
                    $idCliente = $_GET['idCliente'];
    
                    try {
                        $cliente->eliminarClientePorID($idCliente);                       
                    } catch (Exception $e) {
                        echo json_encode([
                            "status" => 500,
                            "error" => "Error interno al eliminar el cliente.",
                            "detalle" => $e->getMessage()
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El idCliente es obligatorio para eliminar un cliente."
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


//

//manejador para Ventas

function handleVentas($method) {
    $venta = new VentasController();

    switch ($method) {
        case 'POST':
            // Verifica que los datos POST estén presentes
            if (
                isset($_POST['idConsecionario'], $_POST['idVenta'], $_POST['VIN'], $_POST['precio'])
            ) {
                $idConsecionario = $_POST['idConsecionario'];
                $idVenta = $_POST['idVenta'];
                $VIN = $_POST['VIN'];
                $precio = $_POST['precio'];
                

                try {
                    $venta->crearVenta($idConsecionario, $idVenta, $VIN, $precio);                   
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al crear el venta$venta.",
                        "detalle" => $e->getMessage()
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => 400,
                    "error" => "Faltan datos obligatorios para crear el venta$venta."
                ]);
            }
            break;

        case 'GET':
            try {
                $result = $venta->readAll();               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al obtener los clientes.",
                    "detalle" => $e->getMessage()
                ]);
            }
            break;
            case 'PUT':
                // Obtener el idVenta de la ruta (en la URL)
                $idVenta = isset($_GET['idVenta']) ? $_GET['idVenta'] : null;
            
                if (!$idVenta) {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El idVenta es obligatorio para actualizar un venta$venta."
                    ]);
                    break;
                }
            
                // Leer el cuerpo de la solicitud para obtener los datos del venta$venta en form data
                parse_str(file_get_contents("php://input"), $putData);
            
                // Validar que al menos un campo opcional esté presente
                $campos = [];
                if (!empty($putData['idConsecionario'])) $campos['idConsecionario'] = $putData['idConsecionario'];
                if (!empty($putData['idVenta'])) $campos['idVenta'] = $putData['idVenta'];
                if (!empty($putData['VIN'])) $campos['VIN'] = $putData['VIN'];
                if (!empty($putData['precio'])) $campos['precio'] = $putData['precio'];
          
            
                if (empty($campos)) {
                    echo json_encode([
                        "status" => 400,
                        "error" => "Debe proporcionar al menos un campo para actualizar."
                    ]);
                    break;
                }
            
                try {
                    // Llamar al método para actualizar el venta$venta
                    $venta->actualizarVenta($idVenta, $campos);                               
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al actualizar el venta$venta.",
                        "detalle" => $e->getMessage()
                    ]);
                }
                break;
            
            case 'DELETE':
                // Obtener el ID de la venta desde los parámetros de la URL
                if (isset($_GET['idVenta'])) {
                    $idVenta = $_GET['idVenta'];
    
                    try {
                        $venta->eliminarVenta($idVenta);                       
                    } catch (Exception $e) {
                        echo json_encode([
                            "status" => 500,
                            "error" => "Error interno al eliminar el venta$venta.",
                            "detalle" => $e->getMessage()
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El idVenta es obligatorio para eliminar un venta$venta."
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