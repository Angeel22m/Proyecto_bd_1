<?php

class ViewController{

    
    public function readAllConcesionarios(){
        $view = new ViewModel();
        // Llamando método para hacer la lectura en la tabla de Empleado
        $result = Utf8Convert::utf8_convert($view::readAllConcesionarios());

        if(empty($result)){

            $json=array(
                "status"=>404,
                "detalle"=>"No hay view almacenados en la base de datos."
            );

            echo json_encode($json, true);
            return;
        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$result
            );

            echo json_encode($json, true);
            return;
        }
    }

    
    public function readConcesionario($idConcesionario){
        $view = new ViewModel();
        // Llamando método para hacer la lectura en la tabla de Empleado
        $result = Utf8Convert::utf8_convert($view::readConcesionario($idConcesionario));

        if(empty($result)){

            $json=array(
                "status"=>404,
                "detalle"=>"No hay."
            );

            echo json_encode($json, true);
            return;
        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$result
            );

            echo json_encode($json, true);
            return;
        }
    }

    public function readVehiculosConcesionario($idConcesionario){
        $view = new ViewModel();
        // Llamando método para hacer la lectura en la tabla de Empleado
        $result = Utf8Convert::utf8_convert($view::readVehiculosConcesionario($idConcesionario));

        if(empty($result)){

            $json=array(
                "status"=>404,
                "detalle"=>"No hay."
            );

            echo json_encode($json, true);
            return;
        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$result
            );

            echo json_encode($json, true);
            return;
        }
    }

}