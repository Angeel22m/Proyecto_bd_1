<?php
class VentasController {

    public function crearVenta($idConcesionario, $idVenta, $VIN, $precio) {
        // Crear instancia del modelo
        $ventasModel = new ventasModel();

        // Llamar al método del modelo para crear el cliente
        $response = $ventasModel::crearVenta($idConcesionario, $idVenta, $VIN, $precio);
                
        return;
    }

    public function readAll(){
        $ventasModel = new ventasModel();
        // Llamando método para hacer la lectura en la tabla de Empleado
        $ventas = Utf8Convert::utf8_convert($ventasModel::readAll());

        if(empty($ventas)){

            $json=array(
                "status"=>404,
                "detalle"=>"No hay ventas almacenados en la base de datos."
            );

            echo json_encode($json, true);
            return;
        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$ventas
            );

            echo json_encode($json, true);
            return;
        }
    }

    public function actualizarVenta($idVenta, $campos){

        $datos = 
        $json = array(
            "idVenta" => $idVenta,
            "idConcesionario" => !empty($campos['idConcesionario']) ? $campos['idConcesionario'] : null,
            "idCliente" => !empty($campos['idCliente']) ? $campos['idCliente'] : null,
            "VIN" => !empty($campos['VIN']) ? $campos['VIN'] : null,
            "precio" => !empty($campos['precio']) ? $campos['precio'] : null
        );
        
        $ventasModel = new VentasModel();
        $ventasModel::actualizarVenta($datos);
    }

    public function eliminarVenta($idVenta){
        // Crear instancia del modelo de clientes
        $ventasModel = new VentasModel();
        
        // Intentar eliminar el cliente
        $response = $ventasModel::eliminarVenta($idVenta);
    
        
    }


    
}
