
<?php
require_once("connection.php");

//$arrayRutas = explode("/",$_SERVER['REQUEST_URI']);

// Obtener la URI completa
$requestUri = $_SERVER['REQUEST_URI'];

// Separar la URI en su componente de ruta y query string
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'] ?? '';
$queryString = $parsedUrl['query'] ?? '';

// Obtener los segmentos de la ruta
$arrayRutas = explode('/', trim($path, '/'));

$queryParams = [];

//Obtener parámetros de consulta (si es necesario)
parse_str($queryString, $queryParams);


if(count(array_filter($arrayRutas)) >= 3){

    if(isset($_SERVER['REQUEST_METHOD'])){

        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $archiveRoute = array_filter($arrayRutas)[2];

        switch ($archiveRoute){

            
            // ESTE SOLO ES PARA PROBAR LA CONEXIÓN.
            case 'index.php';

                $pruebaController = new PruebaController();

                $response = match($requestMethod){

                    'GET' => function() use ($pruebaController){

                        $pruebaController->metodoControllerPrueba();
                    },
                    default => function() {
                        
                        
                        /*
                        $json=array(
                            "status"=>404,
                            "detalle"=>"Página no encontrada."
                        );

                        echo json_encode($json, true);
                        return;
                        */
                    }, 
                };

                $response();
            break;
        

            default:

                $json=array(
                    "status"=>404,
                    "detalle"=>"Página no encontrada."
                );
                
                echo json_encode($json, true);
                return;
            break;
        }
    }

}elseif(count(array_filter($arrayRutas)) < 3){

    if(count(array_filter($arrayRutas)) == 2){

        $json=array(
            "status"=>200,
            "detalle"=>"Diriga a la página principal"
        );

    }else{

        $json=array(
            "status"=>404,
            "detalle"=>"No encontrado"
        );

    }
    echo json_encode($json, true);
    return;
}