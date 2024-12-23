<?php
// incluimos los controladores 
require_once 'controllers/routes.controller.php';
require_once 'controllers/clientes.controller.php';
require_once 'controllers/plantas.controller.php';
require_once 'controllers/modelos.controller.php';
require_once 'controllers/proveedor.controller.php';
require_once 'controllers/login.controller.php';
require_once 'controllers/ventas.controller.php';
require_once 'controllers/vehiculos.controller.php';
require_once 'controllers/concesionarios.controller.php';
require_once 'controllers/view.controller.php';
require_once 'connection.php'; // Asegúrate de que la ruta sea correcta


//incluimos los modelos
require_once 'models/clientes.model.php';
require_once 'models/modelos.model.php';
require_once 'models/plantas.model.php';
require_once 'models/proveedores.model.php';
require_once 'models/ventas.model.php';
require_once 'models/vehiculos.model.php';
require_once 'models/concesionarios.model.php';
require_once 'models/view.model.php';

require_once './utf8_convert.php';

// Crear una instancia de la clase Connection
$routes = new RoutesController();

// Conectar a la base de datos
$routes->startRoutes();

?>
