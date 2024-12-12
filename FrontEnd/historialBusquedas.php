<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php'); // Redirige a la página de login
    exit;
}

// Verificar permisos (permitir acceso si el usuario es administrador o concesionario)
if ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'marketing') {
    echo "No tienes permiso para acceder a esta página.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Historial de Búsquedas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container my-4">
    <!-- Botón de Regresar -->
    <div class="d-flex justify-content-end mb-3">
        <a href="http://localhost/Proyecto_bd_1/FrontEnd/viewMarketing.php" class="btn btn-primary">Volver a Informes</a>
    </div>

    <!-- Título -->
    <h1 class="text-center text-secondary mb-4">Historial de Búsquedas</h1>

    <!-- Contenedor para gráficos (en una cuadrícula de 2 columnas) -->
    <div class="row">
        <div class="col-6 my-4">
            <canvas id="chartColor" width="400" height="200"></canvas>
        </div>
        <div class="col-6 my-4">
            <canvas id="chartTransmision" width="400" height="200"></canvas>
        </div>
        <div class="col-6 my-4">
            <canvas id="chartMarca" width="400" height="200"></canvas>
        </div>
        <div class="col-6 my-4">
            <canvas id="chartEstiloCarroceria" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<script>
    const apiEndpoint = 'http://localhost/Proyecto_bd_1/BackEnd/historial';

    async function loadHistorial() {
        try {
            const response = await fetch(apiEndpoint);
            const data = await response.json();
            const historial = data.detalle;

            const colorData = {};
            const transmisionData = {};
            const marcaData = {};
            const estiloCarroceriaData = {};  // Nuevo objeto para los estilos de carrocería

            historial.forEach(item => {
                // Contar datos para los gráficos
                colorData[item.color] = (colorData[item.color] || 0) + 1;
                if (item.transmision) {
                    transmisionData[item.transmision] = (transmisionData[item.transmision] || 0) + 1;
                }
                if (item.marca) {
                    marcaData[item.marca] = (marcaData[item.marca] || 0) + 1;
                }
                if (item.estiloCarroceria) {  // Contar datos para el gráfico de estilo de carrocería
                    estiloCarroceriaData[item.estiloCarroceria] = (estiloCarroceriaData[item.estiloCarroceria] || 0) + 1;
                }
            });

            // Crear gráficos
            createChart('chartColor', 'Colores Más Buscados', colorData, [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ]);
            createChart('chartTransmision', 'Transmisión Más Buscada', transmisionData, [
                'rgba(123, 239, 178, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(153, 102, 255, 0.5)'
            ]);
            createChart('chartMarca', 'Marcas Más Buscadas', marcaData, [
                'rgba(255, 159, 64, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(153, 102, 255, 0.5)'
            ]);
            createChart('chartEstiloCarroceria', 'Estilos de Carrocería Más Buscados', estiloCarroceriaData, [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ]);
        } catch (error) {
            console.error('Error al cargar el historial:', error);
        }
    }

    function createChart(canvasId, title, data, colors) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        const labels = Object.keys(data);
        const values = Object.values(data);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: title,
                    data: values,
                    backgroundColor: colors,
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: title
                    }
                }
            }
        });
    }

    // Cargar el historial al cargar la página
    loadHistorial();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


