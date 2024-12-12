<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php'); // Redirige a la página de login
    exit;
}

// Verificar permisos (opcional, si usas roles)
if ($_SESSION['rol'] !== 'admin') {
    echo "No tienes permiso para acceder a esta página.";
    exit;
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Vista de Administrador</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
    </head>
    
    <style>.containertable{
      position: absolute;
      top: 10%;
      left: 10%;
  }
  
  .containerControllers{
      position: absolute;
      top: 10%;
      right: 5%;
      border-radius: 5%;
      width: 20%;
  }
  
  .table-mode {
      display: none; 
  }
  .table-mode.active {
      display: table; 
  }</style>
    <body>
      <!-- Botón de Cerrar Sesión -->
    <div class="d-flex justify-content-end mb-3">
            <a href="http://localhost/Proyecto_bd_1/FrontEnd/cerrarsession.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
    <!-- tablas -->
    <div class="containertable border " id="containerTable">
      <div id="title" class="text-center text-center text-primary">Clientes</div>


      <div id="Clientes" class="table-mode active">
        <table class="table table-bordered" >
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nombre</th>
              <th scope="col">Dirección</th>
              <th scope="col">Numero Telefónico</th>
              <th scope="col">Sexo</th>
              <th scope="col">Ingresos anuales</th>
            </tr>
          </thead>
          <tbody id="clientesTableBody">

          </tbody>
        </table>
      </div>
      

      <div id="Concesionarios" class="table-mode">
        <table class="table table-bordered" >
          <thead>
            <tr>
              <th scope="col">ID Concesionarios</th>
              <th scope="col">Nombre</th>
              <th scope="col">Dirección</th>
              <th scope="col">Numero Telefónico</th>
            </tr>
          </thead>
          <tbody id="concesionarioTableBody">

          </tbody>
        </table>
      </div>

      <div id="Vehículos" class="table-mode">
        <table class="table table-bordered" >
          <thead>
            <tr>
              <th scope="col">VIN</th>
              <th scope="col">ID Modelo</th>
              <th scope="col">color</th>
              <th scope="col">Numero motor</th>
              <th scope="col">Transmisión</th>
              <th scope="col">Fecha de Fabricación</th>
            </tr>
          </thead>
          <tbody id="vehiculosTableBody">

          </tbody>
        </table>
      </div>

      <div id="Modelos" class="table-mode">
        <table class="table table-bordered" >
          <thead>
            <tr>
              <th scope="col">ID Modelo</th>
              <th scope="col">Nombre</th>
              <th scope="col">Estilo de carrocería</th>
              <th scope="col">Marca</th>
            </tr>
          </thead>
          <tbody id="modelosTableBody">

          </tbody>
        </table>
      </div>

      <div id="Plantas" class="table-mode">
        <table class="table table-bordered" >
          <thead>
            <tr>
              <th scope="col">ID Planta</th>
              <th scope="col">Nombre</th>
              <th scope="col">Ubicación</th>
            </tr>
          </thead>
          <tbody id="plantasTableBody">

          </tbody>
        </table>
      </div>

      <div id="Prooveedores" class="table-mode">
        <table class="table table-bordered" >
          <thead>
            <tr>
              <th scope="col">ID Prooveedor</th>
              <th scope="col">Nombre</th>
              <th scope="col">Dirección</th>
              <th scope="col">Numero Telefónico</th>
            </tr>
          </thead>
          <tbody id="prooveedoresTableBody">

          </tbody>
        </table>
      </div>

      <div id="Ventas" class="table-mode">
        <table class="table table-bordered" >
          <thead>
            <tr>
              <th scope="col">ID Venta</th>
              <th scope="col">Fecha </th>
              <th scope="col">ID Concesionario</th>
              <th scope="col">ID Cliente</th>
              <th scope="col">VIN</th>
              <th scope="col">Precio </th>
            </tr>
          </thead>
          <tbody id="ventasTableBody">
          
          </tbody>
        </table>
      </div>

        <div id="Bitácora" class="table-mode">
          <table class="table table-bordered" >
            <thead>
              <tr>
                <th scope="col">Tabla</th>
                <th scope="col">Usuario que cambio</th>
                <th scope="col">Accion que hizo</th>
                <th scope="col">Fecha</th>
              </tr>
            </thead>
            <tbody id="BitacoraTableBody" >
  
            </tbody>
          </table>
        </div>

    </div>

    <!-- controles -->
    <div class="container containerControllers border" id="controllers">
        <div class="mb-2 row text-center text-secundary">
            <label  class="col-form-label border-bottom">Elija la tabla</label>
              <select class="form-select text-center text-primary" id="SelectTable" >
                <option value="Clientes">Clientes</option>
                <option value="Concesionarios">Concesionarios</option>
                <option value="Vehículos">Vehículos</option>
                <option value="Modelos">Modelos</option>
                <option value="Plantas">Plantas</option>
                <option value="Prooveedores">Prooveedores</option>
                <option value="Ventas">Ventas</option>
                <option value="Bitácora">Bitácora</option>
              </select>
          </div>

        <div class="mb-2 row text-center text-secundary">
            <label  class="col-form-label border-bottom">Agregar a la tabla</label>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal" id="buttonAgregar">Agregar</button>
          </div>

          <div class="mb-2 row text-center text-secundary">
            <label  class="col-form-label border-bottom">borre una tupla</label>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#DeleteModal" id="buttonBorrar">Borrar</button>
          </div>

          <div class="mb-2 row text-center text-secundary">
            <label  class="border-bottom">Actualice una tupla</label>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#UpdateModal" id="buttonActualizar">Actualizar</button>
        </div>   
    </div>

    <!-- modal de agregar -->
    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Agregar tupla</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div id="Clientes" class="table-mode active">
            <form id="agregarCliente" >
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Nombre</label>
                <div>
                  <input type="text" class="form-control" name="nombre">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Direccion</label>
                <div>
                  <input type="text" class="form-control" name="direccion">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Número telefónico</label>
                <div>
                  <input type="text" class="form-control" name = "noTelefono">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Sexo</label>
                <div>
                  <select  class="form-control" name="sexo">
                    <option value="">Seleccione el sexo</option>
                    <option value="masculino">masculino</option>
                    <option value="femenino">femenino</option>
                    <option value="otro">otro</option>
                  </select>
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Ingresos anuales</label>
                <div>
                  <input type="text" class="form-control" name="ingresosAnuales">
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Agregar Cliente</button>
            </form>

          </div>
            
      
            <div id="Concesionarios" class="table-mode">
            <form id="agregarConcesionario">
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Nombre</label>
                <div>
                  <input type="text" class="form-control" name="nombre">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Direccion</label>
                <div>
                  <input type="text" class="form-control" name="direccion">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Número telefónico</label>
                <div>
                  <input type="text" class="form-control" name="noTelefono">
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Agregar Concesionario</button>
            </form>
            </div>
          
            
          <div id="Vehículos" class="table-mode">
          <form id="agregarVehiculo">
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">VIN</label>
                <div>
                  <input type="text" class="form-control" name="VIN">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">ID Modelo</label>
                <div>
                  <select type="text" class="form-control" name="idModelo" id="inAgregarvehiculoModelo">
                    <option value="">Seleccione el modelo</option>
                  </select>
                </div>
              </div>
              <div class="mb-2 row text-secondary">
  <label class="col-form-label">Color</label>
  <div>
    <select class="form-control" name="color">
      <option value="" disabled selected>Selecciona un color</option>
      <option value="rojo">Rojo</option>
      <option value="azul">Azul</option>
      <option value="blanco">Blanco</option>
      <option value="negro">Negro</option>
      <option value="gris">Gris</option>
    </select>
  </div>
</div>


              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Numero motor</label>
                <div>
                  <input type="text" class="form-control" name="noMotor">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Transmisión</label>
                <div>
                  <input type="text" class="form-control" name="transmision">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Fecha de fabricacion</label>
                <div>
                  <input type="text" class="form-control" name="fechaFabricacion">
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Agregar Vehículo</button>
            </form>
            </div>
      
            <div id="Modelos" class="table-mode">

            <form id="agregarModelo">
            <div class="mb-2 row text-secondary">
            <label class="col-form-label">Nombre</label>
            <div>
            <input type="text" class="form-control" name="nombre" required>
            </div>
            </div>
            <div class="mb-2 row text-secondary">
            <label class="col-form-label">Estilo de carrocería</label>
            <div>
            <select class="form-control" name="estiloCarroceria" required>
              <option value="">Seleccione un estilo</option>
              <option value="sedan">Sedan</option>
              <option value="hatchback">Hatchback</option>
              <option value="suv">SUV</option>
              <option value="coupe">Coupé</option>
              <option value="pickup">Pickup</option>
              <option value="convertible">Convertible</option>
            </select>
            </div>
            </div>
            <div class="mb-2 row text-secondary">
      <div class="mb-2 row text-secondary">
      <label class="col-form-label">Marca</label>
      </div>
      <div>
        <input type="text" class="form-control" name="marca" required>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Agregar Modelo</button>
  </form>
  </div>
      
                <div id="Plantas" class="table-mode">
                <form id="agregarPlanta">
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Nombre</label>
                  <div>
                    <input type="text" class="form-control" name="nombre">
                  </div>
                </div>
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Ubicación</label>
                  <div>
                    <input type="text" class="form-control" name="ubicacion">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">modificar planta</button>
                </form>
              </div>

            <div id="Prooveedores" class="table-mode">
              <form id="agregarProoveedor">
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Nombre</label>
                <div>
                  <input type="text" class="form-control" name="nombre">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Direccion</label>
                <div>
                  <input type="text" class="form-control" name="direccion">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Numero telefónico</label>
                <div>
                  <input type="text" class="form-control" name="noTelefono">
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Agregar Prooveedor</button>
            </form>
            </div>
      
            <div id="Ventas" class="table-mode">

              <form id="agregarVenta">
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">ID Concesionario</label>
                <div>
                  <select type="text" class="form-control" name="idConcesionario" id="inAgregarVentaConcesionario">
                    <option value="">Seleccione el concesionario</option>
                  </select>
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">ID Cliente</label>
                <div>
                  <select type="text" class="form-control" name="idCliente" id="inAgregarVentaCliente">
                    <option value="">Seleccione el cliente</option>
                  </select>
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">VIN</label>
                <div>
                  <select type="text" class="form-control" name="VIN" id="inAgregarVentaVehiculo">
                    <option value="">Seleccione el vehiculo</option>
                  </select>
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Precio</label>
                <div>
                  <input type="text" class="form-control" name="precio">
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Agregar venta</button>
            </form>
            </div>
      
              <div id="Bitácora" class="table-mode">
                <h2 class="text-primary">No se puede agregar</h2>
              </div>
      
              <button type="button" style="position: absolute; bottom: 3%; right: 3%;" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>



    <!-- modal de borrar -->
    <div class="modal fade" id="DeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Borrar tupla</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div id="Clientes" class="table-mode active">

              <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID</label>
                  <div>
                    <select type="text" class="form-control" id="inEliminarCliente">
                      <option value="">Seleccione el cliente</option>
                      </select>
                  </div>
                </div>
                <button type="button" class="btn btn-primary" id="btnEliminarCliente" >Borrar Cliente</button>
              </div>
              
        
              <div id="Concesionarios" class="table-mode">
  
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID Concesionario</label>
                  <div>
                    <select type="text" class="form-control" id="inEliminarConcesionario">
                      <option value="">Seleccione el concesionario</option>
                    </select>
                  </div>
                </div>
                <button type="button" class="btn btn-primary" id="btnEliminarConcesionario" >Borrar Concesionario</button>
              </div>
        
              <div id="Vehículos" class="table-mode">
          
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">VIN</label>
                  <div>
                    <select type="text" class="form-control" id="inEliminarVehiculo">
                      <option value="">Seleccione el Vehiculo</option>
                    </select>
                  </div>
                </div>
                <button type="button" class="btn btn-primary" id="btnEliminarVehiculo" >Borrar Vehículo</button>
              </div>
        
              <div id="Modelos" class="table-mode">
  
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID Modelo</label>
                  <div>
                    <select type="text" class="form-control" id="inEliminarModelo">
                      <option value="">Seleccione el Modelo</option>
                    </select>
                  </div>
                </div>

                <button type="button" class="btn btn-primary" id="btnEliminarModelo" >Borrar Modelo</button>
              </div>
        
              <div id="Plantas" class="table-mode">
          
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID Planta</label>
                  <div>
                    <select type="text" class="form-control" id="inEliminarPlanta">
                      <option value="">Seleccione la planta</option>
                    </select>
                  </div>
                  
                </div>
                <button type="button" class="btn btn-primary" id="btnEliminarPlanta" >Borrar Planta</button>
          
              </div>
        
              <div id="Prooveedores" class="table-mode">
                
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID Prooveedor</label>
                  <div>
                    <select type="text" class="form-control" id="inEliminarProoveedor">
                      <option value="">Seleccione el prooveedor</option>
                    </select>
                  </div>
                  
                </div>
                <button type="button" class="btn btn-primary" id="btnEliminarProoveedor" >Borrar Prooveedor</button>
  
              </div>
        
              <div id="Ventas" class="table-mode">
                
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID Venta</label>
                  <div>
                    <select type="text" class="form-control" id="inEliminarVenta">
                    <option value="">Seleccione la venta</option>
                    </select>
                  </div>
                </div>
               
                <button type="button" class="btn btn-primary" id="btnEliminarVenta" >Borrar Venta</button>
              </div>
        
                <div id="Bitácora" class="table-mode">
                  <h2 class="text-primary">No se puede eliminar.</h2>
                </div>
                <button type="button" style="position: absolute; bottom: 3%; right: 3%;" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

    <!-- modal de modificar -->
    <div class="modal fade" id="UpdateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Actualizar tupla</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div id="Clientes" class="table-mode active">

              <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID</label>
                  <div>
                    <select type="text" class="form-control" id="inmodificarCliente">
                      <option value="">Seleccione el cliente</option>
                    </select>
                  </div>
                </div>

                <form id="modificarCliente">
                <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Nombre</label>
                <div>
                  <input type="text" class="form-control" name="nombre">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Direccion</label>
                <div>
                  <input type="text" class="form-control" name="direccion">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Número telefónico</label>
                <div>
                  <input type="text" class="form-control" name = "noTelefono">
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Sexo</label>
                <div>
                  <select  class="form-control" name="sexo">
                    <option value="">Seleccione el sexo</option>
                    <option value="masculino">masculino</option>
                    <option value="femenino">femenino</option>
                    <option value="otro">otro</option>
                  </select>
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">Ingresos anuales</label>
                <div>
                  <input type="text" class="form-control" name="ingresosAnuales">
                </div>
              </div>
                <button type="submit" class="btn btn-primary">modificar Cliente</button>
                </form>
                
              </div>
              
        
              <div id="Concesionarios" class="table-mode">
  
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID Concesionario</label>
                  <div>
                    <select type="text" class="form-control" id="inmodificarConcesionario">
                      <option value="">Seleccione el concesionario</option>
                    </select>
                  </div>
                </div>
                <form id="modificarConcesionario" >
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Nombre</label>
                  <div>
                    <input type="text" class="form-control" name="nombre">
                  </div>
                </div>
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Direccion</label>
                  <div>
                    <input type="text" class="form-control" name="direccion">
                  </div>
                </div>
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Número telefónico</label>
                  <div>
                    <input type="text" class="form-control" name="noTelefono">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">modificar concesionario</button>
                </form>
              </div>
        
              <div id="Vehículos" class="table-mode">
          
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">VIN</label>
                  <div>
                    <select type="text" class="form-control" id="inmodificarVehiculo">
                      <option value="">Seleccione el vehiculo</option>
                    </select>
                  </div>
                </div>
                <form id="modificarVehiculo">
                <div class="mb-2 row text-secondary">
                <label  class="col-form-label">ID Modelo</label>
                <div>
                  <select type="text" class="form-control" name="idModelo" id="inModificarvehiculoModelo">
                    <option value="">Seleccione el modelo</option>
                  </select>
                </div>
              </div>
                <div class="mb-2 row text-secondary">
  <label class="col-form-label">Color</label>
  <div>
    <select class="form-control" name="color">
      <option value="" disabled selected>Selecciona un color</option>
      <option value="rojo">Rojo</option>
      <option value="azul">Azul</option>
      <option value="blanco">Blanco</option>
      <option value="negro">Negro</option>
      <option value="gris">Gris</option>
    </select>
  </div>
</div>


                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Transmisión</label>
                  <div>
                    <input type="text" class="form-control" name="transmision">
                  </div>
                </div>
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Numero Motor</label>
                  <div>
                    <input type="text" class="form-control" name="noMotor">
                  </div>
                </div>
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Fecha fabricacion</label>
                  <div>
                    <input type="text" class="form-control" name="fechaFabricacion">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">modificar vehiculo</button>
                </form>
              </div>
        
              <div id="Modelos" class="table-mode">
  
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID Modelo</label>
                  <div>
                    <select type="text" class="form-control" id="inmodificarModelo">
                      <option value="">Seleccione el modelo</option>
                    </select>
                  </div>
                </div>
                <form id="modificarModelo" >
                <div class="mb-2 row text-secondary">
            <label class="col-form-label">Nombre</label>
            <div>
            <input type="text" class="form-control" name="nombre" >
            </div>
            </div>
            <div class="mb-2 row text-secondary">
            <label class="col-form-label">Estilo de carrocería</label>
            <div>
            <select class="form-control" name="estiloCarroceria" >
              <option value="">Seleccione un estilo</option>
              <option value="sedan">Sedan</option>
              <option value="hatchback">Hatchback</option>
              <option value="suv">SUV</option>
              <option value="coupe">Coupé</option>
              <option value="pickup">Pickup</option>
              <option value="convertible">Convertible</option>
            </select>
            </div>
            </div>
            <div class="mb-2 row text-secondary">
      <div class="mb-2 row text-secondary">
      <label class="col-form-label">Marca</label>
      </div>
      <div>
        <input type="text" class="form-control" name="marca" >
      </div>
    </div>
                <button type="submit" class="btn btn-primary">modificar modelo</button>
                </form>
              </div>
        
              <div id="Plantas" class="table-mode">
          
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID Planta</label>
                  <div>
                    <select type="text" class="form-control" id="inmodificarPlanta">
                      <option value="">Seleccione la planta</option>
                    </select>
                  </div>
                </div>

                <form id="modificarPlanta">
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Nombre</label>
                  <div>
                    <input type="text" class="form-control" name="nombre">
                  </div>
                </div>
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Ubicación</label>
                  <div>
                    <input type="text" class="form-control" name="ubicacion">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">modificar planta</button>
                </form>
              </div>
        
              <div id="Prooveedores" class="table-mode">
                
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID Prooveedor</label>
                  <div>
                    <select type="text" class="form-control" id="inmodificarProoveedor">
                      <option value="">seleccione el prooveedor</option>
                    </select>
                  </div>
                </div>
                <form id="modificarProoveedor">
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Nombre</label>
                  <div>
                    <input type="text" class="form-control" name="nombre">
                  </div>
                </div>
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Direccion</label>
                  <div>
                    <input type="text" class="form-control" name="direccion">
                  </div>
                </div>
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Numero telefónico</label>
                  <div>
                    <input type="text" class="form-control" name="noTelefono">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">modificar prooveedor</button>
                </form>
              </div>
        
              <div id="Ventas" class="table-mode">
                
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">ID Venta</label>
                  <div>
                    <select type="text" class="form-control" id="inmodificarVenta">
                      <option value="">Seleccione la venta</option>
                    </select>
                  </div>
                </div>
                <form id="modificarVenta">
                <div class="mb-2 row text-secondary">
                <label  class="col-form-label">ID Concesionario</label>
                <div>
                  <select type="text" class="form-control" name="idConcesionario" id="inModificarVentaConcesionario">
                    <option value="">Seleccione el concesionario</option>
                  </select>
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">ID Cliente</label>
                <div>
                  <select type="text" class="form-control" name="idCliente" id="inModificarVentaCliente">
                    <option value="">Seleccione el cliente</option>
                  </select>
                </div>
              </div>
              <div class="mb-2 row text-secondary">
                <label  class="col-form-label">VIN</label>
                <div>
                  <select type="text" class="form-control" name="VIN" id="inModificarVentaVehiculo">
                    <option value="">Seleccione el vehiculo</option>
                  </select>
                </div>
              </div>
                <div class="mb-2 row text-secondary">
                  <label  class="col-form-label">Precio</label>
                  <div>
                    <input type="text" class="form-control" name="precio">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">modificar venta</button>
                </form>
              </div>
        
                <div id="Bitácora" class="table-mode">
                  <h2 class="text-primary"> No se puede modificar</h2>
                </div>
        
                <button type="button" style="position: absolute; bottom: 3%; right: 3%;" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

  </body>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
    <script>
    const selector = document.getElementById('SelectTable');
    const tables = document.querySelectorAll('.table-mode');
    selector.addEventListener('change', (event) => {
    const selectedTable = event.target.value;
      
    tables.forEach(table => {
      if (table.id === selectedTable) {
        table.classList.add('active');
      } else {
      table.classList.remove('active');
      }
      });
      document.getElementById("title").innerHTML = selectedTable;
      });
    </script>

    <script>
      //api
      const apiClientes = 'http://localhost/Proyecto_bd_1/BackEnd/cliente';
      const apiConcesionarios = 'http://localhost/Proyecto_bd_1/BackEnd/viewConcesionarios';//es otra
      const apiVehiculos = 'http://localhost/Proyecto_bd_1/BackEnd/vehiculo';
      const apiModelos = 'http://localhost/Proyecto_bd_1/BackEnd/modelo';
      const apiPlanta = 'http://localhost/Proyecto_bd_1/BackEnd/planta';
      const apiProoveedores = 'http://localhost/Proyecto_bd_1/BackEnd/proveedor';
      const apiVenta = 'http://localhost/Proyecto_bd_1/BackEnd/venta';
      const apiBitacora ='http://localhost/Proyecto_bd_1/BackEnd/bitacora';

      //las tablas
      const clientesTableBody = document.getElementById('clientesTableBody');
      const concesionarioTableBody = document.getElementById('concesionarioTableBody');
      const vehiculosTableBody = document.getElementById('vehiculosTableBody');
      const modelosTableBody = document.getElementById('modelosTableBody');
      const plantasTableBody = document.getElementById('plantasTableBody');
      const prooveedoresTableBody = document.getElementById('prooveedoresTableBody');
      const ventasTableBody = document.getElementById('ventasTableBody');
      const vehiculosxconcesionariosTableBody = document.getElementById('vehiculosxconcesionariosTableBody');
      const modelosxplantasTableBody = document.getElementById('modelosxplantasTableBody');
      const modelosxprooveedoresTableBody =document.getElementById('modelosxprooveedoresTableBody');



      //funciones asincronas de carga
      async function loadClientes(){
        try{
        const response = await fetch(apiClientes);
        const clientes = await response.json();
        const opcionesEliminar = document.getElementById('inEliminarCliente');
        const opcionesModificar = document.getElementById('inmodificarCliente');
        const opcionesAgregarVenta = document.getElementById('inAgregarVentaCliente');
        const opcionesModificarVenta =document.getElementById('inModificarVentaCliente');

        clientesTableBody.innerHTML = '';
        clientes.detalle.forEach(cliente => {
          const row = document.createElement('tr');
          row.innerHTML = `<td>${cliente.idCliente}</td>
                        <td>${cliente.nombre}</td>
                        <td>${cliente.direccion}</td>
                        <td>${cliente.noTelefono}</td>
                        <td>${cliente.sexo}</td>
                        <td>${cliente.ingresosAnuales}</td>`;
        clientesTableBody.appendChild(row);

        const option1 = document.createElement('option');
        option1.value = `${cliente.idCliente}`
        option1.textContent = `cliente: ${cliente.idCliente}, ${cliente.nombre}`;
        const option2 = document.createElement('option');
        option2.value = `${cliente.idCliente}`
        option2.textContent = `cliente: ${cliente.idCliente}, ${cliente.nombre}`;
        const option3 = document.createElement('option');
        option3.value = `${cliente.idCliente}`
        option3.textContent = `cliente: ${cliente.idCliente}, ${cliente.nombre}`;
        const option4 = document.createElement('option');
        option4.value = `${cliente.idCliente}`
        option4.textContent = `cliente: ${cliente.idCliente}, ${cliente.nombre}`;

        opcionesEliminar.appendChild(option1);
        opcionesModificar.appendChild(option2);
        opcionesAgregarVenta.appendChild(option3);
        opcionesModificarVenta.appendChild(option4);
        
      })}catch (error){
        console.error('Error al cargar los clientes:', error);
      }
      }

      async function loadConcesionarios() {
            try {
                const response = await fetch(apiConcesionarios);
                const concesionarios = await response.json();
                const opcionesEliminar = document.getElementById('inEliminarConcesionario');
                const opcionesModificar = document.getElementById('inmodificarConcesionario');
                const opcionesAgregarVenta = document.getElementById('inAgregarVentaConcesionario');
                const opcionesModificarVenta =document.getElementById('inModificarVentaConcesionario');
                
                concesionarioTableBody.innerHTML = '';
                concesionarios.detalle.forEach(concesionario => {
                const row =document.createElement('tr')
                row.innerHTML = `<td>${concesionario.idConcesionario}</td>
                        <td>${concesionario.nombre}</td>
                        <td>${concesionario.direccion}</td>
                        <td>${concesionario.noTelefono}</td>`;
                        concesionarioTableBody.appendChild(row);   


                        const option1 = document.createElement('option');
                        option1.value = `${concesionario.idConcesionario}`
                        option1.textContent = `concesionario: ${concesionario.idConcesionario}, ${concesionario.nombre}`;
                        const option2 = document.createElement('option');
                        option2.value = `${concesionario.idConcesionario}`
                        option2.textContent = `concesionario: ${concesionario.idConcesionario}, ${concesionario.nombre}`;
                        const option3 = document.createElement('option');
                        option3.value = `${concesionario.idConcesionario}`
                        option3.textContent = `concesionario: ${concesionario.idConcesionario}, ${concesionario.nombre}`;
                        const option4 = document.createElement('option');
                        option4.value = `${concesionario.idConcesionario}`
                        option4.textContent = `concesionario: ${concesionario.idConcesionario}, ${concesionario.nombre}`;

                        opcionesEliminar.appendChild(option1);
                        opcionesModificar.appendChild(option2);
                        opcionesAgregarVenta.appendChild(option3);
                        opcionesModificarVenta.appendChild(option4);
                });
            } catch (error) {
                console.error('Error al cargar los concesionarios:', error);
            }
        }

      async function loadVehiculos() {
            try {
                const response = await fetch(apiVehiculos);
                const vehiculos = await response.json();
                const opcionesEliminar = document.getElementById('inEliminarVehiculo');
                const opcionesModificar = document.getElementById('inmodificarVehiculo');
                const opcionesAgregarVenta = document.getElementById('inAgregarVentaVehiculo');
                const opcionesModificarVenta =document.getElementById('inModificarVentaVehiculo');

                vehiculosTableBody.innerHTML = '';
                vehiculos.detalle.forEach(vehiculo => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${vehiculo.VIN}</td>
                        <td>${vehiculo.idModelo}</td>
                        <td>${vehiculo.color}</td>
                        <td>${vehiculo.noMotor}</td>
                        <td>${vehiculo.transmision}</td>
                        <td>${vehiculo.fechaFabricacion}</td>
                    `;
                    vehiculosTableBody.appendChild(row);

                    const option1 = document.createElement('option');
                    option1.value = `${vehiculo.VIN}`
                        option1.textContent = `vehiculo: ${vehiculo.VIN}`;
                        const option2 = document.createElement('option');
                        option2.value = `${vehiculo.VIN}`
                        option2.textContent = `vehiculo: ${vehiculo.VIN}`;
                        const option3 = document.createElement('option');
                        option3.value = `${vehiculo.VIN}`
                        option3.textContent = `vehiculo: ${vehiculo.VIN}`;
                        const option4 = document.createElement('option');
                        option4.value = `${vehiculo.VIN}`
                        option4.textContent = `vehiculo: ${vehiculo.VIN}`;

                        opcionesEliminar.appendChild(option1);
                        opcionesModificar.appendChild(option2);
                        opcionesAgregarVenta.appendChild(option3);
                        opcionesModificarVenta.appendChild(option4);

                });
            } catch (error) {
                console.error('Error al cargar los vehículos:', error);
            }
        }

        async function loadModelos(){
          try {
            const response =await fetch(apiModelos);
            const modelos = await response.json();
            const opcionesEliminar =document.getElementById('inEliminarModelo');
            const opcionesModificar =document.getElementById('inmodificarModelo');
            const opcionesAgregarVehiculo = document.getElementById('inAgregarvehiculoModelo');
            const opcionesModificarvehiculo = document.getElementById('inModificarvehiculoModelo')

            modelosTableBody.innerHTML = '';
            modelos.detalle.forEach(modelo =>{
              const row = document.createElement('tr');
              row.innerHTML = `
                <td>${modelo.idModelo}</td>
                <td>${modelo.nombre}</td>
                <td>${modelo.estiloCarroceria}</td>
                <td>${modelo.marca}</td>
                `;
                modelosTableBody.appendChild(row);  
                
                const option1 = document.createElement('option');
                    option1.value = `${modelo.idModelo}`
                        option1.textContent = `Modelo: ${modelo.idModelo}, ${modelo.nombre}`;
                        const option2 = document.createElement('option');
                        option2.value = `${modelo.idModelo}`
                        option2.textContent = `Modelo: ${modelo.idModelo}, ${modelo.nombre}`;
                        const option3 = document.createElement('option');
                        option3.value = `${modelo.idModelo}`
                        option3.textContent = `Modelo: ${modelo.idModelo}, ${modelo.nombre}`;
                        const option4 = document.createElement('option');
                        option4.value = `${modelo.idModelo}`
                        option4.textContent = `Modelo: ${modelo.idModelo}, ${modelo.nombre}`;

                        opcionesEliminar.appendChild(option1);
                        opcionesModificar.appendChild(option2);
                        opcionesAgregarVehiculo.appendChild(option3);
                        opcionesModificarvehiculo.appendChild(option4);
            })
          } catch (error) {
            console.error('Error al cargar los modelos:', error);
          }
        }

        async function loadPlantas(){
          try {
            const response =await fetch(apiPlanta);
            const plantas = await response.json();
            const opcionesEliminar =document.getElementById('inEliminarPlanta');
            const opcionesModificar =document.getElementById('inmodificarPlanta');

            plantasTableBody.innerHTML = '';
            plantas.detalle.forEach(planta =>{
              const row = document.createElement('tr');
              row.innerHTML = `
                <td>${planta.idPlanta}</td>
                <td>${planta.nombre}</td>
                <td>${planta.ubicacion}</td>
                `;
                plantasTableBody.appendChild(row); 

                const option1 = document.createElement('option');
                option1.value = `${planta.idPlanta}`
                        option1.textContent = `planta: ${planta.idPlanta}, ${planta.nombre}`;
                        const option2 = document.createElement('option');
                        option2.value = `${planta.idPlanta}`
                        option2.textContent = `planta: ${planta.idPlanta}, ${planta.nombre}`;

                        opcionesEliminar.appendChild(option1);
                        opcionesModificar.appendChild(option2);
                

            })
          } catch (error) {
            console.error('Error al cargar las plantas:', error);
          }
        }

        async function loadProovedores(){
          try {
            const response =await fetch(apiProoveedores);
            const proveedores = await response.json();
            const opcionesEliminar =document.getElementById('inEliminarProoveedor');
            const opcionesModificar =document.getElementById('inmodificarProoveedor');

            prooveedoresTableBody.innerHTML = '';
            proveedores.detalle.forEach(prooveedor =>{
              const row = document.createElement('tr');
              row.innerHTML = `
                <td>${prooveedor.idProveedor}</td>
                <td>${prooveedor.nombre}</td>
                <td>${prooveedor.direccion}</td>
                <td>${prooveedor.noTelefono}</td>
                `;
                prooveedoresTableBody.appendChild(row); 
                
                const option1 = document.createElement('option');
                option1.value = `${prooveedor.idProveedor}`
                        option1.textContent = `prooveedor: ${prooveedor.idProveedor}, ${prooveedor.nombre}`;
                        const option2 = document.createElement('option');
                        option2.value = `${prooveedor.idProveedor}`
                        option2.textContent = `prooveedor: ${prooveedor.idProveedor}, ${prooveedor.nombre}`;

                        opcionesEliminar.appendChild(option1);
                        opcionesModificar.appendChild(option2);
            })
          } catch (error) {
            console.error('Error al cargar los prooveedores:', error);
          }
        }

        async function loadVentas(){
          try {
            const response = await fetch(apiVenta);
            const ventas = await response.json();
            const opcionesEliminar =document.getElementById('inEliminarVenta');
            const opcionesModificar =document.getElementById('inmodificarVenta');

            ventasTableBody.innerHTML = '';
            ventas.detalle.forEach(venta =>{
              const row = document.createElement('tr');
              row.innerHTML = `
                <td>${venta.idVenta}</td>
                <td>${venta.fecha}</td>
                <td>${venta.idConcesionario}</td>
                <td>${venta.idCliente}</td>
                <td>${venta.VIN}</td>
                <td>${venta.precio}</td>
                `;
                ventasTableBody.appendChild(row); 
                
                const option1 = document.createElement('option');
                option1.value = `${venta.idVenta}`
                option1.textContent = `venta: ${venta.idVenta}`;
                const option2 = document.createElement('option');
                option2.value = `${venta.idVenta}`
                option2.textContent = `venta: ${venta.idVenta}`;

                opcionesEliminar.appendChild(option1);
                opcionesModificar.appendChild(option2);
            })
          } catch (error) {
            console.error('Error al cargar las ventas:', error);
          }
        }
<<<<<<< HEAD

        async function loadBitacora(){
          try {
            const response =await fetch(apiBitacora);
            const bitacoras = await response.json();

            BitacoraTableBody.innerHTML = '';
            bitacoras.detalle.forEach(bitacora =>{
              const row = document.createElement('tr');
              row.innerHTML = `
                <td>${bitacora.tabla_afectada}</td>
                <td>${bitacora.usuario}</td>
                <td>${bitacora.accion}</td>
                <td>${bitacora.fecha}</td>
                `;
                BitacoraTableBody.appendChild(row);              
            })
          } catch (error) {
            console.error('Error al cargar los prooveedores:', error);
          }
        }
        //falta modeloxplantas,ModeloxProoveedor, vehiculoxconcesionario
=======
        
>>>>>>> 2c5118af6467a2c6002b220d27c6c47f38ab4117

        
        loadClientes();
        loadConcesionarios();
        loadVehiculos();
        loadModelos();
        loadPlantas();
        loadProovedores();
        loadVentas();
        loadBitacora();

      
        //agregar a cliente
        async function handleAgregarCliente(event) {
            event.preventDefault(); 

            const formData = new FormData(document.getElementById("agregarCliente"));
            
            try {
                const response = await fetch( apiClientes , {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                switch (data.status) {
                    case 200:
                        alert("cliente creado exitosamente"); 
                        loadClientes();
                        break;
                    case 401:
                        alert("Credenciales inválidas. Por favor, verifica");
                        break;
                    case 400:
                        alert("Faltan datos o los datos son incorrectos.");
                        break;
                    case 405:
                        alert("Método no permitido. Por favor, utiliza el método adecuado.");
                        break;
                    default:
                        alert("Error desconocido. Intenta nuevamente.");
                        break;
                }
            } catch (error) {
                alert("Ocurrió un error al intentar agregar al cliente. Intenta nuevamente.");
                console.error(error);
            }
        }

        //agregar a concesionario aun no funciona
        /*
        async function handleAgregarConcesionario(event) {
            event.preventDefault(); 

            const formData = new FormData(document.getElementById("agregarConcesionario"));
            
            try {
                const response = await fetch( apiConcesionarios , {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                switch (data.status) {
                    case 200:
                        alert("concesionario creado exitosamente");
                        loadConcesionarios(); 
                        break;
                    case 401:
                        alert("Credenciales inválidas. Por favor, verifica");
                        break;
                    case 400:
                        alert("Faltan datos o los datos son incorrectos.");
                        break;
                    case 405:
                        alert("Método no permitido. Por favor, utiliza el método adecuado.");
                        break;
                    default:
                        alert("Error desconocido. Intenta nuevamente.");
                        break;
                }
            } catch (error) {
                alert("Ocurrió un error al agregar el concesionario. Intenta nuevamente.");
                console.error(error);
            }
        }
        */

        async function handleAgregarVehiculo(event) {
            event.preventDefault(); 

            const formData = new FormData(document.getElementById("agregarVehiculo"));
            
            try {
                const response = await fetch( apiVehiculos , {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                switch (data.status) {
                    case 200:
                        alert("vehiculo agregado exitosamente"); 
                        loadVehiculos();
                        break;
                    case 401:
                        alert("Credenciales inválidas. Por favor, verifica");
                        break;
                    case 400:
                        alert("Faltan datos o los datos son incorrectos.");
                        break;
                    case 405:
                        alert("Método no permitido. Por favor, utiliza el método adecuado.");
                        break;
                    default:
                        alert("Error desconocido. Intenta nuevamente.");
                        break;
                }
            } catch (error) {
                alert("Ocurrió un error al intentar agregar el vehiculo. Intenta nuevamente.");
                console.error(error);
            }
        }

        async function handleAgregarModelo(event) {
            event.preventDefault(); 

            const formData = new FormData(document.getElementById("agregarModelo"));
            
            try {
                const response = await fetch( apiModelos , {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                switch (data.status) {
                    case 200:
                        alert("Modelo agregado exitosamente"); 
                        loadModelos();
                        break;
                    case 401:
                        alert("Credenciales inválidas. Por favor, verifica");
                        break;
                    case 400:
                        alert("Faltan datos o los datos son incorrectos.");
                        break;
                    case 405:
                        alert("Método no permitido. Por favor, utiliza el método adecuado.");
                        break;
                    default:
                        alert("Error desconocido. Intenta nuevamente.");
                        break;
                }
            } catch (error) {
                alert("Ocurrió un error al intentar agregar el Modelo. Intenta nuevamente.");
                console.error(error);
            }
        }

        async function handleAgregarPlantas(event) {
            event.preventDefault(); 

            const formData = new FormData(document.getElementById("agregarPlanta"));
            
            try {
                const response = await fetch( apiPlanta , {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                switch (data.status) {
                    case 200:
                        alert("Planta agregada exitosamente"); 
                        loadPlantas();
                        break;
                    case 401:
                        alert("Credenciales inválidas. Por favor, verifica");
                        break;
                    case 400:
                        alert("Faltan datos o los datos son incorrectos.");
                        break;
                    case 405:
                        alert("Método no permitido. Por favor, utiliza el método adecuado.");
                        break;
                    default:
                        alert("Error desconocido. Intenta nuevamente.");
                        break;
                }
            } catch (error) {
                alert("Ocurrió un error al intentar agregar la planta. Intenta nuevamente.");
                console.error(error);
            }
        }

        async function handleAgregarProoveedor(event) {
            event.preventDefault(); 

            const formData = new FormData(document.getElementById("agregarProoveedor"));
            
            try {
                const response = await fetch( apiProoveedores , {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                switch (data.status) {
                    case 200:
                        alert("Prooveedor Agregado exitosamente"); 
                        loadProovedores();
                        break;
                    case 401:
                        alert("Credenciales inválidas. Por favor, verifica");
                        break;
                    case 400:
                        alert("Faltan datos o los datos son incorrectos.");
                        break;
                    case 405:
                        alert("Método no permitido. Por favor, utiliza el método adecuado.");
                        break;
                    default:
                        alert("Error desconocido. Intenta nuevamente.");
                        break;
                }
            } catch (error) {
                alert("Ocurrió un error al intentar agregar el prooveedor. Intenta nuevamente.");
                console.error(error);
            }
        }

        async function handleAgregarVenta(event) {
            event.preventDefault(); 

            const formData = new FormData(document.getElementById("agregarVenta"));
            
            try {
                const response = await fetch( apiVenta , {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();

                switch (data.status) {
                    case 200:
                        alert("venta Agregado exitosamente"); 
                        loadVentas();
                        break;
                    case 401:
                        alert("Credenciales inválidas. Por favor, verifica");
                        break;
                    case 400:
                        alert("Faltan datos o los datos son incorrectos.");
                        break;
                    case 405:
                        alert("Método no permitido. Por favor, utiliza el método adecuado.");
                        break;
                    default:
                        alert("Error desconocido. Intenta nuevamente.");
                        break;
                }
            } catch (error) {
                alert("Ocurrió un error al intentar agregar la venta. Intenta nuevamente.");
                console.error(error);
            }
        }

        //falta modeloxplantas,ModeloxProoveedor, vehiculoxconcesionario

        document.getElementById("agregarCliente").addEventListener("submit",handleAgregarCliente);
        //document.getElementById("agregarConcesionario").addEventListener("submit",handleAgregarConcesionario);
        document.getElementById("agregarVehiculo").addEventListener("submit",handleAgregarVehiculo);
        document.getElementById("agregarModelo").addEventListener("submit",handleAgregarModelo);
        document.getElementById("agregarPlanta").addEventListener("submit",handleAgregarPlantas);
        document.getElementById("agregarProoveedor").addEventListener("submit",handleAgregarProoveedor);
        document.getElementById("agregarVenta").addEventListener("submit",handleAgregarVenta);

        //Borrar
        async function EliminarCliente(id) {
        try {
        const response = await fetch( apiClientes+'?idCliente='+id.trim() , {
         method: "DELETE",
        });

        const data = await response.json();

        switch (data.status) {
        case 200:
            alert("cliente eliminado");
            loadClientes(); 
            break;
        default:
            alert("no se pudo eliminar.");
            break;
                  }
        } catch (error) {
        alert("Ocurrió un error al intentar eliminar el cliente. Intenta nuevamente.");
        console.error(error);
        }
        }

        document.getElementById('btnEliminarCliente').addEventListener('click', ()=>{
        
        const id = document.getElementById('inEliminarCliente').value;
        EliminarCliente(id);
        document.getElementById('inEliminarCliente').value= '';
        })

        async function EliminarVehiculo(id) {
        try {
        const response = await fetch( apiVehiculos+'?VIN='+id.trim() , {
         method: "DELETE",
        });

        const data = await response.json();

        switch (data.status) {
        case 200:
            alert("Vehiculo eliminado");
            loadClientes(); 
            break;
        default:
            alert("no se pudo eliminar.");
            break;
                  }
        } catch (error) {
        alert("Ocurrió un error al intentar eliminar el Vehiculo. Intenta nuevamente.");
        console.error(error);
        }
        }

        document.getElementById('btnEliminarVehiculo').addEventListener('click', ()=>{
        
        const id = document.getElementById('inEliminarVehiculo').value;
        EliminarVehiculo(id);
        document.getElementById('inEliminarVehiculo').value= '';
        })

      
        async function EliminarModelo(id) {
        try {
        const response = await fetch( apiModelos+'?idModelo='+id.trim() , {
         method: "DELETE",
        });

        const data = await response.json();

        switch (data.status) {
        case 200:
            alert("Modelo eliminado");
            loadModelos(); 
            break;
        default:
            alert("no se pudo eliminar.");
            break;
                  }
        } catch (error) {
        alert("Ocurrió un error al intentar eliminar el Modelo. Intenta nuevamente.");
        console.error(error);
        }
        }

        document.getElementById('btnEliminarModelo').addEventListener('click', ()=>{
        
        const id = document.getElementById('inEliminarModelo').value;
        EliminarModelo(id);
        document.getElementById('inEliminarModelo').value= '';
        })


        async function EliminarPlanta(id) {
        try {
        const response = await fetch( apiPlanta+'?idPlanta='+id.trim() , {
         method: "DELETE",
        });

        const data = await response.json();

        switch (data.status) {
        case 200:
            alert("planta eliminada");
            loadPlantas(); 
            break;
        default:
            alert("no se pudo eliminar.");
            break;
                  }
        } catch (error) {
        alert("Ocurrió un error al intentar eliminar la planta. Intenta nuevamente.");
        console.error(error);
        }
        }

        document.getElementById('btnEliminarPlanta').addEventListener('click', ()=>{
        
        const id = document.getElementById('inEliminarPlanta').value;
        EliminarPlanta(id);
        document.getElementById('inEliminarPlanta').value= '';
        })

        async function EliminarProoveedor(id) {
        try {
        const response = await fetch( apiProoveedores+'?idProveedor='+id.trim() , {
         method: "DELETE",
        });

        const data = await response.json();

        switch (data.status) {
        case 200:
            alert("prooveedor eliminada");
            loadProovedores(); 
            break;
        default:
            alert("no se pudo eliminar.");
            break;
                  }
        } catch (error) {
        alert("Ocurrió un error al intentar eliminar el prooveedor. Intenta nuevamente.");
        console.error(error);
        }
        }

        document.getElementById('btnEliminarProoveedor').addEventListener('click', ()=>{
        
        const id = document.getElementById('inEliminarProoveedor').value;
        EliminarProoveedor(id);
        document.getElementById('inEliminarProoveedor').value= '';
        })

        async function EliminarVenta(id) {
        try {
        const response = await fetch( apiVenta+'?idVenta='+id.trim() , {
         method: "DELETE",
        });

        const data = await response.json();

        switch (data.status) {
        case 200:
            alert("venta eliminada");
            loadVentas(); 
            break;
        default:
            alert("no se pudo eliminar.");
            break;
                  }
        } catch (error) {
        alert("Ocurrió un error al intentar eliminar la venta. Intenta nuevamente.");
        console.error(error);
        }
        }

        document.getElementById('btnEliminarVenta').addEventListener('click', ()=>{
        
        const id = document.getElementById('inEliminarVenta').value;
        EliminarVenta(id);
        document.getElementById('inEliminarVenta').value= '';
        })


    async function handleModificarCliente(event) {
    event.preventDefault();

    
    // Capturar el formulario y datos del cliente
    const formElement = document.getElementById('modificarCliente');
    const formData = new FormData(formElement);
    const id = document.getElementById('inmodificarCliente').value.trim();

    // Convertir FormData a URLSearchParams para x-www-form-urlencoded
    const urlEncodedData = new URLSearchParams();
    formData.forEach((value, key) => {
        urlEncodedData.append(key, value.trim());
    });

    console.log("Datos enviados como x-www-form-urlencoded:", urlEncodedData.toString());

    try {
        // Realizar la solicitud PUT
        const response = await fetch(`${apiClientes}?idCliente=${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: urlEncodedData.toString(), // Convertido a una cadena
        });

        // Leer la respuesta JSON
        const data = await response.json();
        console.log("Respuesta de la API:", data);

        // Manejar respuestas basadas en el estado devuelto
        switch (response.status) {
            case 200:
                alert("Cliente actualizado exitosamente.");
                loadClientes();
                break;
            case 401:
                alert("Credenciales inválidas. Por favor, verifica.");
                break;
            case 400:
                alert(data.error || "Faltan datos o los datos son incorrectos.");
                break;
            case 405:
                alert("Método no permitido. Por favor, utiliza el método adecuado.");
                break;
            default:
                alert("Error desconocido. Intenta nuevamente.");
                break;
        }
    } catch (error) {
        alert("Ocurrió un error al intentar modificar el cliente. Intenta nuevamente.");
        console.error("Error capturado:", error);
    }
}


    //el de concesionario    

async function handleModificarVehiculo(event) {
    event.preventDefault();

    
   
    const formElement = document.getElementById('modificarVehiculo');
    const formData = new FormData(formElement);
    const id = document.getElementById('inmodificarVehiculo').value.trim();

    const urlEncodedData = new URLSearchParams();
    formData.forEach((value, key) => {
        urlEncodedData.append(key, value.trim());
    });

    console.log("Datos enviados como x-www-form-urlencoded:", urlEncodedData.toString());

    try {

        const response = await fetch(`${apiVehiculos}?VIN=${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: urlEncodedData.toString(), 
        });

        const data = await response.json();
        console.log("Respuesta de la API:", data);

        switch (response.status) {
            case 200:
                alert("Vehiculo actualizado exitosamente.");
                loadVehiculos();
                break;
            case 401:
                alert("Credenciales inválidas. Por favor, verifica.");
                break;
            case 400:
                alert(data.error || "Faltan datos o los datos son incorrectos.");
                break;
            case 405:
                alert("Método no permitido. Por favor, utiliza el método adecuado.");
                break;
            default:
                alert("Error desconocido. Intenta nuevamente.");
                break;
        }
    } catch (error) {
        alert("Ocurrió un error al intentar modificar el vehiculo. Intenta nuevamente.");
        console.error("Error capturado:", error);
    }
}

async function handleModificarModelo(event) {
    event.preventDefault();

    
   
    const formElement = document.getElementById('modificarModelo');
    const formData = new FormData(formElement);
    const id = document.getElementById('inmodificarModelo').value.trim();

    const urlEncodedData = new URLSearchParams();
    formData.forEach((value, key) => {
        urlEncodedData.append(key, value.trim());
    });

    console.log("Datos enviados como x-www-form-urlencoded:", urlEncodedData.toString());

    try {

        const response = await fetch(`${apiModelos}?idModelo=${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: urlEncodedData.toString(), 
        });

        const data = await response.json();
        console.log("Respuesta de la API:", data);

        switch (response.status) {
            case 200:
                alert("modelo actualizado exitosamente.");
                loadModelos();
                break;
            case 401:
                alert("Credenciales inválidas. Por favor, verifica.");
                break;
            case 400:
                alert(data.error || "Faltan datos o los datos son incorrectos.");
                break;
            case 405:
                alert("Método no permitido. Por favor, utiliza el método adecuado.");
                break;
            default:
                alert("Error desconocido. Intenta nuevamente.");
                break;
        }
    } catch (error) {
        alert("Ocurrió un error al intentar modificar el modelo. Intenta nuevamente.");
        console.error("Error capturado:", error);
    }
}

async function handleModificarPlanta(event) {
    event.preventDefault();

    
   
    const formElement = document.getElementById('modificarPlanta');
    const formData = new FormData(formElement);
    const id = document.getElementById('inmodificarPlanta').value.trim();

    const urlEncodedData = new URLSearchParams();
    formData.forEach((value, key) => {
        urlEncodedData.append(key, value.trim());
    });

    console.log("Datos enviados como x-www-form-urlencoded:", urlEncodedData.toString());

    try {

        const response = await fetch(`${apiPlanta}?idPlanta=${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: urlEncodedData.toString(), 
        });

        const data = await response.json();
        console.log("Respuesta de la API:", data);

        switch (response.status) {
            case 200:
                alert("planta actualizada exitosamente.");
                loadPlantas();
                break;
            case 401:
                alert("Credenciales inválidas. Por favor, verifica.");
                break;
            case 400:
                alert(data.error || "Faltan datos o los datos son incorrectos.");
                break;
            case 405:
                alert("Método no permitido. Por favor, utiliza el método adecuado.");
                break;
            default:
                alert("Error desconocido. Intenta nuevamente.");
                break;
        }
    } catch (error) {
        alert("Ocurrió un error al intentar modificar la planta. Intenta nuevamente.");
        console.error("Error capturado:", error);
    }
}

async function handleModificarProoveedor(event) {
    event.preventDefault();

    
   
    const formElement = document.getElementById('modificarProoveedor');
    const formData = new FormData(formElement);
    const id = document.getElementById('inmodificarProoveedor').value.trim();

    const urlEncodedData = new URLSearchParams();
    formData.forEach((value, key) => {
        urlEncodedData.append(key, value.trim());
    });

    console.log("Datos enviados como x-www-form-urlencoded:", urlEncodedData.toString());

    try {

        const response = await fetch(`${apiProoveedores}?idProveedor=${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: urlEncodedData.toString(), 
        });

        const data = await response.json();
        console.log("Respuesta de la API:", data);

        switch (response.status) {
            case 200:
                alert("prooveedor actualizado exitosamente.");
                loadProovedores();
                break;
            case 401:
                alert("Credenciales inválidas. Por favor, verifica.");
                break;
            case 400:
                alert(data.error || "Faltan datos o los datos son incorrectos.");
                break;
            case 405:
                alert("Método no permitido. Por favor, utiliza el método adecuado.");
                break;
            default:
                alert("Error desconocido. Intenta nuevamente.");
                break;
        }
    } catch (error) {
        alert("Ocurrió un error al intentar modificar el prooveedor. Intenta nuevamente.");
        console.error("Error capturado:", error);
    }
}

async function handleModificarVenta(event) {
    event.preventDefault();

    
   
    const formElement = document.getElementById('modificarVenta');
    const formData = new FormData(formElement);
    const id = document.getElementById('inmodificarVenta').value.trim();

    const urlEncodedData = new URLSearchParams();
    formData.forEach((value, key) => {
        urlEncodedData.append(key, value.trim());
    });

    console.log("Datos enviados como x-www-form-urlencoded:", urlEncodedData.toString());

    try {

        const response = await fetch(`${apiVenta}?idVenta=${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: urlEncodedData.toString(), 
        });

        const data = await response.json();
        console.log("Respuesta de la API:", data);

        switch (response.status) {
            case 200:
                alert("venta actualizada exitosamente.");
                loadVentas();
                break;
            case 401:
                alert("Credenciales inválidas. Por favor, verifica.");
                break;
            case 400:
                alert(data.error || "Faltan datos o los datos son incorrectos.");
                break;
            case 405:
                alert("Método no permitido. Por favor, utiliza el método adecuado.");
                break;
            default:
                alert("Error desconocido. Intenta nuevamente.");
                break;
        }
    } catch (error) {
        alert("Ocurrió un error al intentar modificar la venta. Intenta nuevamente.");
        console.error("Error capturado:", error);
    }
}
        
        document.getElementById('modificarCliente').addEventListener("submit",handleModificarCliente);
        //concesionarios
        document.getElementById('modificarVehiculo').addEventListener("submit",handleModificarVehiculo);
        document.getElementById('modificarModelo').addEventListener("submit",handleModificarModelo);
        document.getElementById('modificarPlanta').addEventListener("submit",handleModificarPlanta);
        document.getElementById('modificarProoveedor').addEventListener("submit",handleModificarProoveedor);
        document.getElementById('modificarVenta').addEventListener("submit",handleModificarVenta);
    </script>

    </html>