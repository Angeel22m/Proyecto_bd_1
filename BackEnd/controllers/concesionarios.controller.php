<?php
class ConcesionariosController {

    public function crearConcesionario($nombre, $direccion, $noTelefono) {
        // Crear instancia del modelo
        $concesionarioModel = new ConcesionariosModel();

        // Llamar al método del modelo para crear el concensioario
        $response = $concesionarioModel::crearConcesionario($nombre, $direccion, $noTelefono);
        
        return;
    }

    public function readAll(){
        $concesionarioModel = new ConcesionariosModel();
        // Llamando método para hacer la lectura en la tabla 
        $concesionarios = Utf8Convert::utf8_convert($concesionarioModel::readAll());

        if(empty($concesionarios)){

            $json=array(
                "status"=>404,
                "detalle"=>"No hay concesionarios almacenados en la base de datos."
            );

            echo json_encode($json, true);
            return;
        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$concesionarios
            );

            echo json_encode($json, true);
            return;
        }
    }

    public function actualizarConcesionario($idConcesionario , $campos){
        
        $datos = array(
            "idConcesionario " => $idConcesionario,
            "nombre" => !empty($campos['nombre']) ? $campos['nombre'] : null,
            "direccion" => !empty($campos['direccion']) ? $campos['direccion'] : null,
            "noTelefono" => !empty($campos['noTelefono']) ? $campos['noTelefono'] : null
        );
        
        $concesionarioModel = new ConcesionariosModel();
        $concesionarioModel::actualizarConcesionario($idConcesionario ,$datos);
    }

    public function eliminarConcesionario($idConcesionario ){
        // Crear instancia del modelo de concesionarios
        $concesionarioModel = new ConcesionariosModel();
        
        // Intentar eliminar el Concesionario 
        $response = $concesionarioModel::eliminarConcesionario($idConcesionario);
    
        
    }
    
}
