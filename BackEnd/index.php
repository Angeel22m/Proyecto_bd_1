<?php
// incluimos los controladores 
require_once 'controllers/routes.controller.php';
require_once 'connection.php'; // Asegúrate de que la ruta sea correcta

// Crear una instancia de la clase Connection
$routes = new RoutesController();

// Conectar a la base de datos
$routes->startRoutes();

?>
