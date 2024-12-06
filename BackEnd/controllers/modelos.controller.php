<?php
class ModelosController {

    public function nuevoModelo($nombre, $estiloCarroceria, $marca) {
        // Crear instancia del modelo
        $modeloModel = new ModelosModel();

        // Llamar al método del modelo para crear el Modelo
        $response = $modeloModel::nuevoModelo($nombre, $estiloCarroceria, $marca);

        // Verificar si la respuesta está vacía o si hubo un error
        if (isset($response['status']) && $response['status'] !== 200) {
            // Error en la creación del Modelo
            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            // Modelo creado exitosamente
            echo json_encode([
                "status" => 200,
                "data" => $response['data'] ?? null
            ], JSON_PRETTY_PRINT);
        }

        return;
    }

    public function readAll(){
        $modeloModel = new ModelosModel();
        // Llamando método para hacer la lectura en la tabla 
        $modelos = Utf8Convert::utf8_convert($modeloModel::readAll());

        if(empty($modelos)){

            $json=array(
                "status"=>404,
                "detalle"=>"No hay Modelos almacenados en la base de datos."
            );

            echo json_encode($json, true);
            return;
        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$modelos
            );

            echo json_encode($json, true);
            return;
        }
    }

    public function actualizarModelo($idModelo, $campos){

        $datos = 
        $json = array(
            "idModelo" => $idModelo,
            "nombre" => !empty($campos['nombre']) ? $campos['nombre'] : null,
            "estiloCarroceria" => !empty($campos['estiloCarroceria']) ? $campos['estiloCarroceria'] : null,
            "marca" => !empty($campos['marca']) ? $campos['marca'] : null
        );
        
        $modeloModel = new ModelosModel();
        $modeloModel::actualizarModelo($datos);
    }

    public function eliminarModelo($idModelo){
        // Crear instancia del modelo de Modelos
        $modeloModel = new ModelosModel();
        
        // Intentar eliminar el modelo
        $response = $modeloModel::eliminarModelo($idModelo);
    
        // Comprobamos si la eliminación fue exitosa
        if ($response === false) { // Cambié a 'false', asumiendo que el modelo devuelve false si no se encuentra el Modelo
            // Modelo no encontrado
            $json = array(
                "status" => 404,
                "detalle" => "No existe el modelo con el ID: $idModelo"
            );
            echo json_encode($json, true);
            return;
        } else {
            // Modelo eliminado correctamente
            $json = array(
                "status" => 200,
                "detalle" => "Modelo con ID: $idModelo ha sido eliminado correctamente"
            );
            echo json_encode($json, true);
            return;
        }
    }
    
}
