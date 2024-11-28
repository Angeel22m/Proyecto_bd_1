<?php
class ClientesController {

    public function crearCliente($nombre, $direccion, $noTelefono, $sexo, $ingresosAnuales) {
        // Crear instancia del modelo
        $clienteModel = new ClientesModel();

        // Llamar al método del modelo para crear el cliente
        $response = $clienteModel::crearCliente($nombre, $direccion, $noTelefono, $sexo, $ingresosAnuales);

        // Verificar si la respuesta está vacía o si hubo un error
        if (isset($response['status']) && $response['status'] !== 200) {
            // Error en la creación del cliente
            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            // Cliente creado exitosamente
            echo json_encode([
                "status" => 200,
                "data" => $response['data'] ?? null
            ], JSON_PRETTY_PRINT);
        }

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
}
