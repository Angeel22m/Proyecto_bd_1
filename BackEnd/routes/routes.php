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
                    echo json_encode([
                        "status" => 201,
                        "message" => "Cliente creado con éxito"
                    ]);
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
            // Leer el cuerpo de la solicitud para datos JSON
            parse_str(file_get_contents("php://input"), $putData);

            if (!isset($putData['idCliente'])) {
                echo json_encode([
                    "status" => 400,
                    "error" => "El idCliente es obligatorio para actualizar un cliente."
                ]);
                break;
            }

            $idCliente = $putData['idCliente'];

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
                
                $cliente->actualizarCliente($idCliente, $campos);               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al actualizar el cliente.",
                    "detalle" => $e->getMessage()
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





?>

