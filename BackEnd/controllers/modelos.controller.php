<?php
class ModelosController {

    public function nuevoModelo($nombre, $estiloCarroceria, $marca) {
        // Crear instancia del modelo
        $modeloModel = new ModelosModel();

        // Llamar al método del modelo para crear el Modelo
        $response = $modeloModel::nuevoModelo($nombre, $estiloCarroceria, $marca);    
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
        }
    }
    

