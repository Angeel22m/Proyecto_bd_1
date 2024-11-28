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
        case 'hola':
            echo json_encode(["status" => 200, "message" => "Hola Mundo"]);
            break;

        case 'getClientes':
            handleGetClientes($requestMethod);
            break;

        case 'login':
            handleLogin($requestMethod);
            break;

        case 'nuevoCliente';
            handleNuevoCliente($requestMethod);
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

/**
 * Función para manejar solicitudes GET para obtener clientes.
 * 
 * @param string $method Método HTTP de la solicitud.
 */
function handleGetClientes($method) {
    if ($method === 'GET') {
        $pruebaController = new PruebaController();
        try {
            $pruebaController->metodoControllerPrueba();
        } catch (Exception $e) {
            echo json_encode([
                "status" => 500,
                "error" => "Error interno al obtener los clientes.",
                "detalle" => $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            "status" => 405,
            "detalle" => "Método no permitido."
        ]);
    }
}

/**
 * Función para manejar el inicio de sesión.
 * 
 * @param string $method Método HTTP de la solicitud.
 */
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
                "detalle" => "Faltan datos de inicio de sesión."
            ]);
        }
    } else {
        echo json_encode([
            "status" => 405,
            "detalle" => "Método no permitido."
        ]);
    }
}


/**
 * Función para las solicitudes En cliente.
 * 
 * @param string $method Método HTTP de la solicitud.
 */
function handleNuevoCliente($method) {

    if ($method === 'POST') {
        session_start();

        // Verifica que los datos POST estén presentes
        if (isset($_POST['nombre']) && isset($_POST['direccion'])
         && isset($_POST['noTelefono']) && isset($_POST['sexo'])
         && isset($_POST['ingresosAnuales'])) {

            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $noTelefono = $_POST['noTelefono'];
            $sexo = $_POST['sexo'];
            $ingresosAnuales = $_POST['ingresosAnuales'];

            $cliente = new ClientesController();
            $cliente->crearCliente($nombre,$direccion,$noTelefono,$sexo,$ingresosAnuales);

           
    }
 else {
    echo json_encode([
        "status" => 405,
        "detalle" => "Método no permitido."
    ]);
}
}}



?>

