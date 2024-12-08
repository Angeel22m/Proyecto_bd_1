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

	case 'planta';
            handlePlanta($requestMethod);
            break;

	case 'modelo';
            handleModelo($requestMethod);
            break;

	case 'proveedor';
            handleProveedor($requestMethod);
            break;

    case 'venta';
            handleVentas($requestMethod);
            break;
    case 'vehiculo';
            handleVehiculos($requestMethod);
            break;
    case 'viewConcesionarios';
        switch($requestMethod){
            case 'GET';
            $view = new ViewController();
            try {
                $result = $view->readAllConcesionarios();               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al obtener los clientes.",
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

    break;

    case 'viewConcesionario':
        switch ($requestMethod) {
            case 'GET':
                $view = new ViewController();
                $idConcesionario = isset($_GET['idConcesionario']) ? $_GET['idConcesionario'] : null;
    
                // Validar idConcesionario
                if (!$idConcesionario || !filter_var($idConcesionario, FILTER_VALIDATE_INT)) {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El idConcesionario es obligatorio y debe ser un número válido."
                    ]);
                    break;
                }
    
                try {
                    // Intentar obtener el concesionario
                    $result = $view->readConcesionario($idConcesionario);
    
                    
                } catch (Exception $e) {
                    // Manejo de errores generales
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al obtener el concesionario.",
                        "detalle" => $e->getMessage()
                    ]);
                }
                break;
    
            default:
                // Respuesta para métodos no permitidos
                echo json_encode([
                    "status" => 405,
                    "detalle" => "Método no permitido para esta ruta."
                ]);
                break;
        }

    break;

    case 'viewVehiculosConcesionarios';
    switch ($requestMethod) {
        case 'GET':
            $view = new ViewController();
            $idConcesionario = isset($_GET['idConcesionario']) ? $_GET['idConcesionario'] : null;

            // Validar idConcesionario
            if (!$idConcesionario || !filter_var($idConcesionario, FILTER_VALIDATE_INT)) {
                echo json_encode([
                    "status" => 400,
                    "error" => "El idConcesionario es obligatorio y debe ser un número válido."
                ]);
                break;
            }

            try {
                // Intentar obtener el concesionario
                $result = $view->readVehiculosConcesionario($idConcesionario);

                
            } catch (Exception $e) {
                // Manejo de errores generales
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al obtener los vehiculos.",
                    "detalle" => $e->getMessage()
                ]);
            }
            break;

        default:
            // Respuesta para métodos no permitidos
            echo json_encode([
                "status" => 405,
                "detalle" => "Método no permitido para esta ruta."
            ]);
            break;
    }

    break;
    case 'viewInformeVentas';
    switch($requestMethod){
        case 'GET';
        $view = new ViewController();
        try {
            $result = $view->readInformeVentas();               
        } catch (Exception $e) {
            echo json_encode([
                "status" => 500,
                "error" => "Error interno al obtener los clientes.",
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

break;
     
case 'viewMUV';
switch($requestMethod){
    case 'GET';
    $view = new ViewController();
    try {
        $result = $view->viewMUV();               
    } catch (Exception $e) {
        echo json_encode([
            "status" => 500,
            "error" => "Error interno al obtener los clientes.",
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

break;

case 'viewMTD';
switch($requestMethod){
    case 'GET';
    $view = new ViewController();
    try {
        $result = $view->viewMTD();               
    } catch (Exception $e) {
        echo json_encode([
            "status" => 500,
            "error" => "Error interno al obtener los clientes.",
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
break;

case 'viewTV';
switch($requestMethod){
    case 'GET';
    $view = new ViewController();
    try {
        $result = $view->viewTV();               
    } catch (Exception $e) {
        echo json_encode([
            "status" => 500,
            "error" => "Error interno al obtener los clientes.",
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
break;

case 'viewTI';

switch($requestMethod){
    case 'GET';
    $view = new ViewController();
    try {
        $result = $view->viewTI();               
    } catch (Exception $e) {
        echo json_encode([
            "status" => 500,
            "error" => "Error interno al obtener los clientes.",
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
break;

case 'viewConvertibles';
switch($requestMethod){
    case 'GET';
    $view = new ViewController();
    try {
        $result = $view->viewConvertibles();               
    } catch (Exception $e) {
        echo json_encode([
            "status" => 500,
            "error" => "Error interno al obtener los clientes.",
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
break;

case 'historial';
switch($requestMethod){
    case 'GET';
    $view = new ViewController();
    try {
        $result = $view->historial();               
    } catch (Exception $e) {
        echo json_encode([
            "status" => 500,
            "error" => "Error interno al obtener los clientes.",
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
break;
      
        
    }}
 else {
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
                isset($_POST['nombre'], $_POST['direccion'], $_POST['noTelefono'], $_POST['sexo'], $_POST['ingresosAnuales']) &&
    !empty(trim($_POST['nombre'])) &&
    !empty(trim($_POST['direccion'])) &&
    !empty(trim($_POST['noTelefono'])) &&
    !empty(trim($_POST['sexo'])) &&
    !empty(trim($_POST['ingresosAnuales']))
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
                     "error" => "El idCliente es obligatorio para actualizar."
                 ]);
                 break;
             }
            // Leer el cuerpo de la solicitud para datos JSON
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
                        $cliente->eliminarCliente($idCliente);                       
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


function handlePlanta($method) {
    $planta = new PlantasController();

    switch ($method) {
        case 'POST':
            // Verifica que los datos POST estén presentes
            if (
                isset($_POST['nombre'], $_POST['ubicacion'])
                &&!empty(trim($_POST['nombre']))
                &&!empty(trim($_POST['ubicacion']))
            ) {
                $nombre = $_POST['nombre'];
                $ubicacion = $_POST['ubicacion'];

                try {
                    $planta->crearPlanta($nombre, $ubicacion);                  
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al crear la planta.",
                        "detalle" => $e->getMessage()
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => 400,
                    "error" => "Faltan datos obligatorios para crear la planta."
                ]);
            }
            break;

        case 'GET':
            try {
                $result = $planta->readAll();               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al obtener las plantas.",
                    "detalle" => $e->getMessage()
                ]);
            }
            break;

        case 'PUT':

             // Obtener el idPlanta de la ruta (en la URL)
             $idPlanta = isset($_GET['idPlanta']) ? $_GET['idPlanta'] : null;
            
             if (!$idPlanta) {
                 echo json_encode([
                     "status" => 400,
                     "error" => "El idPlanta es obligatorio para actualizar."
                 ]);
                 break;
             }
            // Leer el cuerpo de la solicitud para datos JSON
            parse_str(file_get_contents("php://input"), $putData);

            // Validar que al menos un campo opcional esté presente
            $campos = [];
            if (!empty($putData['nombre'])) $campos['nombre'] = $putData['nombre'];
            if (!empty($putData['ubicacion'])) $campos['ubicacion'] = $putData['ubicacion'];

            if (empty($campos)) {
                echo json_encode([
                    "status" => 400,
                    "error" => "Debe proporcionar al menos un campo para actualizar."
                ]);
                break;
            }

            try {
                
                $planta->actualizarPlanta($idPlanta, $campos);               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al actualizar la planta.",
                    "detalle" => $e->getMessage()
                ]);
            }
            break;

            case 'DELETE':
                // Obtener el ID de la planta desde los parámetros de la URL
                if (isset($_GET['idPlanta'])) {
                    $idPlanta = $_GET['idPlanta'];
    
                    try {
                        $planta->eliminarPlanta($idPlanta);                       
                    } catch (Exception $e) {
                        echo json_encode([
                            "status" => 500,
                            "error" => "Error interno al eliminar la planta",
                            "detalle" => $e->getMessage()
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El idPlanta es obligatorio para eliminar una planta."
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

function handleModelo($method) {
    $modelo = new ModelosController ();

    switch ($method) {
        case 'POST':
            // Verifica que los datos POST estén presentes y no estén vacíos
            if (
                isset($_POST['nombre'], $_POST['estiloCarroceria'], $_POST['marca']) &&
                !empty(trim($_POST['nombre'])) &&
                !empty(trim($_POST['estiloCarroceria'])) &&
                !empty(trim($_POST['marca']))
            ) {
                $nombre = trim($_POST['nombre']);
                $estiloCarroceria = trim($_POST['estiloCarroceria']);
                $marca = trim($_POST['marca']);
        
                try {
                    $modelo->crearModelo($nombre, $estiloCarroceria, $marca);                 
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al crear el modelo.",
                        "detalle" => $e->getMessage()
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => 400,
                    "error" => "Faltan datos obligatorios o contienen valores vacíos."
                ]);
            }
            break;
        

        case 'GET':
            try {
                $result = $modelo->readAll();               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al obtener los modelos.",
                    "detalle" => $e->getMessage()
                ]);
            }
            break;

        case 'PUT':

            // Obtener el idModelo de la ruta (en la URL)
            $idModelo = isset($_GET['idModelo']) ? $_GET['idModelo'] : null;
            
            if (!$idModelo) {
                echo json_encode([
                    "status" => 400,
                    "error" => "El idModelo es obligatorio para actualizar."
                ]);
                break;
            }
            // Leer el cuerpo de la solicitud para datos JSON
            parse_str(file_get_contents("php://input"), $putData);

            // Validar que al menos un campo opcional esté presente
            $campos = [];
            if (!empty($putData['nombre'])) $campos['nombre'] = $putData['nombre'];
            if (!empty($putData['estiloCarroceria'])) $campos['estiloCarroceria'] = $putData['estiloCarroceria'];
            if (!empty($putData['marca'])) $campos['marca'] = $putData['marca'];
            
            if (empty($campos)) {
                echo json_encode([
                    "status" => 400,
                    "error" => "Debe proporcionar al menos un campo para actualizar."
                ]);
                break;
            }

            try {
                
                $modelo->actualizarModelo($idModelo, $campos);               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al actualizar el modelo.",
                    "detalle" => $e->getMessage()
                ]);
            }
            break;

            case 'DELETE':
                // Obtener el ID del modelo desde los parámetros de la URL
                if (isset($_GET['idModelo'])) {
                    $idModelo = $_GET['idModelo'];
    
                    try {
                        $modelo->eliminarModelo($idModelo);                       
                    } catch (Exception $e) {
                        echo json_encode([
                            "status" => 500,
                            "error" => "Error interno al eliminar el modelo.",
                            "detalle" => $e->getMessage()
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El idModelo es obligatorio para eliminar un modelo."
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

function handleProveedor($method) {
    $proveedor = new ProveedoresController();

    switch ($method) {
        case 'POST':
            // Verifica que los datos POST estén presentes
            if (
                isset($_POST['nombre'], $_POST['direccion'], $_POST['noTelefono'])
                &&!empty(trim($_POST['nombre']))
                &&!empty(trim($_POST['direccion']))
                &&!empty(trim($_POST['noTelefono']))
            ) {
                $nombre = $_POST['nombre'];
                $direccion = $_POST['direccion'];
                $noTelefono = $_POST['noTelefono'];

                try {
                    $proveedor->crearProveedor($nombre, $direccion, $noTelefono);
                  
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al crear el proveedor.",
                        "detalle" => $e->getMessage()
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => 400,
                    "error" => "Faltan datos obligatorios para crear el proveedor."
                ]);
            }
            break;

        case 'GET':
            try {
                $result = $proveedor->readAll();               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al obtener los proveedores.",
                    "detalle" => $e->getMessage()
                ]);
            }
            break;

        case 'PUT':

             // Obtener el idProveedor de la ruta (en la URL)
             $idProveedor = isset($_GET['idProveedor']) ? $_GET['idProveedor'] : null;
            
             if (!$idProveedor) {
                 echo json_encode([
                     "status" => 400,
                     "error" => "El idProveedor es obligatorio para actualizar."
                 ]);
                 break;
             }
            // Leer el cuerpo de la solicitud para datos JSON
            parse_str(file_get_contents("php://input"), $putData);    

            // Validar que al menos un campo opcional esté presente
            $campos = [];
            if (!empty($putData['nombre'])) $campos['nombre'] = $putData['nombre'];
            if (!empty($putData['direccion'])) $campos['direccion'] = $putData['direccion'];
            if (!empty($putData['noTelefono'])) $campos['noTelefono'] = $putData['noTelefono'];

            if (empty($campos)) {
                echo json_encode([
                    "status" => 400,
                    "error" => "Debe proporcionar al menos un campo para actualizar."
                ]);
                break;
            }

            try {
                
                $proveedor->actualizarProveedor($idProveedor, $campos);               
            } catch (Exception $e) {
                echo json_encode([
                    "status" => 500,
                    "error" => "Error interno al actualizar el proveedor.",
                    "detalle" => $e->getMessage()
                ]);
            }
            break;

            case 'DELETE':
                // Obtener el ID del proveedor desde los parámetros de la URL
                if (isset($_GET['idProveedor'])) {
                    $idProveedor = $_GET['idProveedor'];
    
                    try {
                        $proveedor->eliminarProveedor($idProveedor);                       
                    } catch (Exception $e) {
                        echo json_encode([
                            "status" => 500,
                            "error" => "Error interno al eliminar el proveedor.",
                            "detalle" => $e->getMessage()
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El idProveedor es obligatorio para eliminar un proveedor."
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



function handleVentas($method) {
    $venta = new VentasController();

    switch ($method) {
        case 'POST':
            // Verifica que los datos POST estén presentes
            if (
                isset($_POST['idConcesionario'], $_POST['VIN'], $_POST['precio'],$_POST['idCliente'])
                &&!empty(trim($_POST['idConcesionario']))            
                &&!empty(trim($_POST['VIN']))
                &&!empty(trim($_POST['precio']))
                &&!empty(trim($_POST['idCliente']))
            ) {
                $idConcesionario = $_POST['idConcesionario'];
                $idCliente = $_POST['idCliente'];
                $VIN = $_POST['VIN'];
                $precio = $_POST['precio'];
                

                try {
                   
                    $venta->crearVenta($idConcesionario, $idCliente, $VIN, $precio);                   
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
                    "error" => "Faltan datos obligatorios para crear el venta."
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
                if (!empty($putData['idConcesionario'])) $campos['idConcesionario'] = $putData['idConcesionario'];
                if (!empty($putData['idVenta'])) $campos['idVenta'] = $putData['idVenta'];
                if (!empty($putData['VIN'])) $campos['VIN'] = $putData['VIN'];
                if (!empty($putData['precio'])) $campos['precio'] = $putData['precio'];
                if (!empty($putData['idCliente'])) $campos['idCliente'] = $putData['idCliente'];
          
            
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
                // Obtener el VIN de la ruta (en la URL)
                $VIN = isset($_GET['VIN']) ? $_GET['VIN'] : null;
                
                if (!$VIN) {
                    echo json_encode([
                        "status" => 400,
                        "error" => "El VIN es obligatorio para actualizar un Vehiculo."
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
                    $vehiculos->actualizarVehiculo($VIN, $campos);                               
                } catch (Exception $e) {
                    echo json_encode([
                        "status" => 500,
                        "error" => "Error interno al actualizar el Vehiculos.",
                        "detalle" => $e->getMessage()
                    ]);
                }
                break;
            
            case 'DELETE':
                // Obtener el ID de la Vehiculos desde los parámetros de la URL
                if (isset($_GET['VIN'])) {
                    $VIN = $_GET['VIN'];
    
                    try {
                        $vehiculos->eliminarVehiculo($VIN);                       
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

?>

