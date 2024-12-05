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

// Contenido protegido
echo "Bienvenido, " . htmlspecialchars($_SESSION['usuario']) . ". Esta es una página protegida.";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lectura de Relación con Fetch</title>
    <script>
        // Función para obtener y mostrar los datos de la relación usando Fetch
        async function cargarDatosRelacion() {
            try {
                // Realizamos la solicitud usando fetch
                const response = await fetch("http://localhost/Proyecto_bd_1/backEnd/cliente");

                // Verificar si la respuesta es exitosa
                if (response.ok) {
                    const data = await response.json(); // Convertir la respuesta a JSON
                    
                    // Limpiar cualquier dato previo en la tabla
                    document.getElementById('tablaClientes').innerHTML = "";
                     
                    // Verificar si el estado es 200
                    if (data.status === 200) {
                        // Iterar sobre la lista de datos y agregarlos a la tabla
                        data.detalle.forEach(Cliente => {
                            document.getElementById('tablaClientes').innerHTML += `
                                <tr>
                                    <td>${Cliente.nombre}</td>
                                    <td>${Cliente.noTelefono}</td>
                                </tr>
                            `;
                        });
                    } else {
                        alert("Error al obtener los datos: " + data.detalle);
                    }
                } else {
                    // Si la respuesta no es exitosa, lanzar un error
                    throw new Error('Error al realizar la solicitud');
                }
            } catch (error) {
                // Manejo de errores de la solicitud
                alert("Ocurrió un error al intentar obtener los datos.");
                console.error(error);
            }
        }


        // Llamar a la función para cargar los datos al cargar la página
        window.onload = function() {
            cargarDatosRelacion();
        }
    </script>
</head>
<body>
    <h1>Clientes</h1>

    <!-- Tabla para mostrar los datos de la relación -->
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Telefono</th>
            </tr>
        </thead>
        <tbody id="tablaClientes">
            <!-- Aquí se insertarán los datos de la API -->
        </tbody>
    </table>

    <a href="http://localhost/Proyecto_bd_1/FrontEnd/cerrarsession.php">Cerrar la Seccion</a>

</body>
</html>

