<?php
class VehiculosController{

    
    public function crearVehiculo($idModelo, $noMotor, $VIN, $fechaFabricacion, $color, $transmision) {
        // Crear instancia del modelo
        $vehiculoModel = new VehiculosModel();

        // Llamar al método del modelo para crear el cliente
        $response = $vehiculoModel::crearVehiculo($idModelo, $noMotor, $VIN, $fechaFabricacion, $color, $transmision);
        
        return;
    }

    public function readAll(){
        $vehiculoModel = new VehiculosModel();
        // Llamando método para hacer la lectura en la tabla de Empleado
        $clientes = Utf8Convert::utf8_convert($vehiculoModel::readAll());

        if(empty($clientes)){

            $json=array(
                "status"=>404,
                "detalle"=>"No hay clientes almacenados en la base de datos."
            );

            echo json_encode($json, true);
            return;
        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$clientes
            );

            echo json_encode($json, true);
            return;
        }
    }

    public function actualizarVehiculo($VIN, $campos){
        
        $datos = array(            
            "idModelo" => !empty($campos['idModelo']) ? $campos['idModelo'] : null,
            "fechaFabricacion" => !empty($campos['fechaFabricacion']) ? $campos['fechaFabricacion'] : null,
            "color" => !empty($campos['color']) ? $campos['color'] : null,
            "transmision" => !empty($campos['transmision']) ? $campos['transmision'] : null,
            "noMotor" => !empty($campos['noMotor']) ? $campos['noMotor'] : null
        );
        
        $vehiculoModel = new VehiculosModel();
        $vehiculoModel::actualizarVehiculo($VIN,$datos);
    }

    public function eliminarVehiculo($VIN){
        // Crear instancia del modelo de clientes
        $vehiculoModel = new VehiculosModel();
        
        // Intentar eliminar el cliente
        $response = $vehiculoModel::eliminarVehiculo($VIN);
    
        
    }
    
    public function buscarVehiculo($campos) {
        // Crear instancia del modelo
       
        $datos = array(            
            "estiloCarroceria" => !empty($campos['estiloCarroceria']) ? $campos['estiloCarroceria'] : null,
            "marca" => !empty($campos['marca']) ? $campos['marca'] : null,
            "color" => !empty($campos['color']) ? $campos['color'] : null,
            "transmision" => !empty($campos['transmision']) ? $campos['transmision'] : null,            
        );
      
        $vehiculoModel = new VehiculosModel();
        // Llamar al método del modelo para crear el cliente
        $response = $vehiculoModel::buscarVehiculo($datos);
       
        if(empty($response)){

            $json=array(
                "status"=>404,
                "detalle"=>["Mensaje"=>"No hay Coincidencias."]
            );

            echo json_encode($json, true);
            return;
        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$response
            );

            echo json_encode($json, true);
            return;
        }

    }

}