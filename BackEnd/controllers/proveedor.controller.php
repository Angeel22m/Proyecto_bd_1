<?php
class ProveedoresController {

    public function nuevoProveedor($nombre, $direccion, $noTelefono ) {
        // Crear instancia del modelo
        $proveedorModel = new ProveedoresModel();

        // Llamar al método del modelo para crear un proveedor
        $response = $proveedorModel::nuevoProveedor($nombre, $direccion, $noTelefono);

        return;
    }

    public function readAll(){
        $proveedorModel = new ProveedoresModel();
        // Llamando método para hacer la lectura en la tabla
        $proveedores = Utf8Convert::utf8_convert($proveedorModel::readAll());

        if(empty($proveedores)){

            $json=array(
                "status"=>404,
                "detalle"=>"No hay proveedores almacenados en la base de datos."
            );

            echo json_encode($json, true);
            return;
        }else{
            $json=array(
                "status"=>200,
                "detalle"=>$proveedores
            );

            echo json_encode($json, true);
            return;
        }
    }

    public function actualizarProveedor($idProveedor, $campos){

        $datos = 
        $json = array(
            "idProveedor" => $idProveedor,
            "nombre" => !empty($campos['nombre']) ? $campos['nombre'] : null,
            "direccion" => !empty($campos['direccion']) ? $campos['direccion'] : null
        );
        
        $proveedorModel = new ProveedoresModel();
        $proveedorModel::actualizarProveedor($datos);
    }

    public function eliminarProveedor($idProveedor){
        // Crear instancia del modelo de proveedores
        $proveedorModel = new ProveedoresModel();
        
        // Intentar eliminar el proveedor
        $response = $proveedorModel::eliminarProveedor($idProveedor);
    
        }
    }
    
