<?php
class ClientesController {

    public function crearCliente($nombre, $direccion, $noTelefono, $sexo, $ingresosAnuales) {
        // Crear instancia del modelo
        $clienteModel = new ClientesModel();

        // Llamar al método del modelo para crear el cliente
        $response = $clienteModel::crearCliente($nombre, $direccion, $noTelefono, $sexo, $ingresosAnuales);
        
        return;
    }

    public function readAll(){
        $clienteModel = new ClientesModel();
        // Llamando método para hacer la lectura en la tabla de Empleado
        $clientes = Utf8Convert::utf8_convert($clienteModel::readAll());

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

    public function actualizarCliente($idCliente, $campos){
        
        $datos = array(
            "idCliente" => $idCliente,
            "nombre" => !empty($campos['nombre']) ? $campos['nombre'] : null,
            "direccion" => !empty($campos['direccion']) ? $campos['direccion'] : null,
            "sexo" => !empty($campos['sexo']) ? $campos['sexo'] : null,
            "noTelefono" => !empty($campos['noTelefono']) ? $campos['noTelefono'] : null,
            "ingresosAnuales" => !empty($campos['ingresosAnuales']) ? $campos['ingresosAnuales'] : null
        );
        
        $clienteModel = new ClientesModel();
        $clienteModel::actualizarCliente($idCliente,$datos);
    }

    public function eliminarCliente($idCliente){
        // Crear instancia del modelo de clientes
        $clienteModel = new ClientesModel();
        
        // Intentar eliminar el cliente
        $response = $clienteModel::eliminarCliente($idCliente);
    
        
    }
    
}
