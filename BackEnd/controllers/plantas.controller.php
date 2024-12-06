<?php
class PlantasController {

    public function registrarNuevaPlanta($nombre, $ubicacion) {
        // Crear instancia del modelo
        $plantaModel = new PlantasModel();

        // Llamar al método del modelo para crear la Planta
        $response = $plantaModel::registrarNuevaPlanta($nombre, $ubicacion);
        return;
    }

    public function readAll(){
        $plantaModel = new PlantasModel();
        // Llamando método para hacer la lectura en la tabla
        $plantas = Utf8Convert::utf8_convert($plantaModel::readAll());

        if(empty($plantas)){

            $json=array(
                "status"=>404,
                "detalle"=>"No hay plantas almacenadas en la base de datos."
            );

            echo json_encode($json, true);
            return;
        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$plantas
            );

            echo json_encode($json, true);
            return;
        }
    }

    public function actualizarPlantaPorId($idPlanta, $campos){

        $datos = 
        $json = array(
            "idPlanta" => $idPlanta,
            "nombre" => !empty($campos['nombre']) ? $campos['nombre'] : null,
            "ubicacion" => !empty($campos['ubicacion']) ? $campos['ubicacion'] : null
	 );
        
        $plantaModel = new PlantasModel();
        $plantaModel::actualizarPlantaPorId($datos);
    }

    public function eliminarPlantaPorId($idPlanta){
        // Crear instancia del modelo de clientes
        $plantaModel = new PlantasModel();
        
        // Intentar eliminar la planta
        $response = $plantaModel::eliminarPlantaPorID($idPlanta);
    
        }
    }
    

