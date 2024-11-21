
<?php
require_once("connection.php");

$requestUri = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'] ?? '';
$queryString = $parsedUrl['query'] ?? '';

$arrayRutas = explode('/', trim($path, '/'));
$queryParams = [];
parse_str($queryString, $queryParams);

if(count(array_filter($arrayRutas)) >= 3){

    if(isset($_SERVER['REQUEST_METHOD'])){

        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $arrayRutas = array_values(array_filter($arrayRutas)); // Aseguramos los índices continuos
        $archiveRoute = $arrayRutas[2] ?? null;

        switch ($archiveRoute){
            case 'hola.com':

                echo 'hola mundo';
                break;
            case 'index.php':
                $pruebaController = new PruebaController();

                $response = match($requestMethod){

                    'GET' => function() use ($pruebaController){
                        $pruebaController->metodoControllerPrueba(); // Asegúrate de que este método existe
                    },

                    default => function() {
                        // Responder con 405 Method Not Allowed si no es un GET
                        $json = array(
                            "status" => 405,
                            "detalle" => "Método no permitido."
                        );
                        echo json_encode($json, true);
                        return;
                    }, 
                };

                $response();
                break;

            default:
                $json = array(
                    "status" => 404,
                    "detalle" => "Página no encontrada."
                );
                echo json_encode($json, true);
                return;
                break;
        }
    }

} elseif(count(array_filter($arrayRutas)) < 3){

    if(count(array_filter($arrayRutas)) == 2){
        $json = array(
            "status" => 200,
            "detalle" => "Dirígete a la página principal"
        );
    } else {
        $json = array(
            "status" => 404,
            "detalle" => "No encontrado"
        );
    }

    echo json_encode($json, true);
    return;
}
?>
