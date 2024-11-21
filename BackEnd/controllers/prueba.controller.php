<?php

class PruebaController{

    public function metodoControllerPrueba(){

        // Convertir datos a UTF-8 antes de codificar a JSON
        $prueba_utf8 = Utf8Convert::utf8_convert(PruebaModel::mostrarPrueba());

        if(empty($prueba_utf8)){

            $json = array(
                "status" => 404,
                "detalle" => "Esta vacío"
            );

        } else {

            $json = array(
                "status" => 200,
                "detalle" => $prueba_utf8
            );
        }
        
        echo json_encode($json, true);
        return;
    }     
}
