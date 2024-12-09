<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php'); // Redirige a la página de login
    exit;
}

// Verificar permisos (permitir acceso si el usuario es administrador o concesionario)
if ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'cliente') {
    echo "No tienes permiso para acceder a esta página.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Cliente</title>
</head>
<body>
<div class="container my-4">
        <!-- Botón de Cerrar Sesión -->
        <div class="d-flex justify-content-end mb-3">
            <a href="http://localhost/Proyecto_bd_1/FrontEnd/cerrarsession.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    <div class="container my-4">
        <h1 class="text-center text-primary mb-4">Gestión de Concesionarios</h1>
        
        <!-- Selector de Concesionarios -->
        <div class="mb-3">
            <label for="concesionarioSelect" class="form-label">Selecciona un Concesionario</label>
            <select class="form-select" id="concesionarioSelect">
                <option value="" selected disabled>Selecciona...</option>
            </select>
        </div>
        
        <!-- Información del Concesionario -->
        <div id="concesionarioInfo" class="my-4">
            <h2 class="text-center text-primary">Información del Concesionario</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>                        
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Número Telefónico</th>
                    </tr>
                </thead>
                <tbody id="concesionarioTableBody">
                    <!-- Se llenará dinámicamente -->
                </tbody>
            </table>
        </div>
        
        <!-- Autos por Concesionario -->
        <div id="vehiculosInfo" class="my-4">
            <h2 class="text-center text-primary">Autos del Concesionario</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>VIN</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>Transmisión</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody id="vehiculosTableBody">
                    <!-- Se llenará dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // URL de las APIs
        const apiConcesionarios = 'http://localhost/Proyecto_bd_1/BackEnd/viewConcesionarios'; // API para obtener los concesionarios
        const apiConcesionarioInfo = id => `http://localhost/Proyecto_bd_1/BackEnd/viewConcesionario?idConcesionario=${id}`; // API para información del concesionario
        const apiVehiculos = id => `http://localhost/Proyecto_bd_1/BackEnd/viewVehiculosConcesionarios?idConcesionario=${id}`; // API para vehículos por concesionario

        // Referencias a los elementos
        const concesionarioSelect = document.getElementById('concesionarioSelect');
        const concesionarioTableBody = document.getElementById('concesionarioTableBody');
        const vehiculosTableBody = document.getElementById('vehiculosTableBody');

        // Función para llenar el selector de concesionarios
        async function loadConcesionarios() {
            try {
                const response = await fetch(apiConcesionarios);
                const concesionarios = await response.json();

                // Llenar el selector
                concesionarios.detalle.forEach(concesionario => {
                    const option = document.createElement('option');
                    option.value = concesionario.idConcesionario;
                    option.textContent = `${concesionario.nombre}`;
                    concesionarioSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error al cargar los concesionarios:', error);
            }
        }

        // Función para obtener información del concesionario
        async function loadConcesionarioInfo(id) {
            try {
                const response = await fetch(apiConcesionarioInfo(id));
                const info = await response.json();
                
                // Llenar la tabla con la información del concesionario
                concesionarioTableBody.innerHTML = `
                    <tr>
                        <td>${info.detalle['0'].nombre}</td>
                        <td>${info.detalle['0'].direccion}</td>
                        <td>${info.detalle['0'].noTelefono}</td>
                    </tr>
                `;
            } catch (error) {
                console.error('Error al cargar la información del concesionario:', error);
            }
        }

        // Función para obtener vehículos del concesionario
        async function loadVehiculos(id) {
            try {
                const response = await fetch(apiVehiculos(id));
                const vehiculos = await response.json();

                // Llenar la tabla con los vehículos
                vehiculosTableBody.innerHTML = '';
                vehiculos.detalle.forEach(vehiculo => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${vehiculo.VIN}</td>
                        <td>${vehiculo.marca}</td>
                        <td>${vehiculo.color}</td>
                        <td>${vehiculo.transmision}</td>
                        <td>${vehiculo.precio}</td>
                    `;
                    vehiculosTableBody.appendChild(row);
                });
            } catch (error) {
                console.error('Error al cargar los vehículos:', error);
            }
        }

        // Evento cuando se selecciona un concesionario
        concesionarioSelect.addEventListener('change', () => {
            const selectedId = concesionarioSelect.value;
            loadConcesionarioInfo(selectedId);
            loadVehiculos(selectedId);
        });

        // Cargar los concesionarios al inicio
        loadConcesionarios();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
