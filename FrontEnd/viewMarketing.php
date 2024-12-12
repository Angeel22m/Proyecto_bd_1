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
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Reportes - Ventas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container my-4">
    <!-- Botón de Cerrar Sesión -->
    <div class="d-flex justify-content-end mb-3">
        <a href="http://localhost/Proyecto_bd_1/FrontEnd/cerrarsession.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>

    <!-- Título -->
    <h1 class="text-center text-primary mb-4">Informes</h1>

    <!-- Botón para ir al historial -->
    <div class="d-flex justify-content-end mb-4">
        <a href="http://localhost/Proyecto_bd_1/FrontEnd/historialBusquedas.php" class="btn btn-secondary">Ver Tendencia de Busquedas</a>
    </div>

    <!-- Contenedor para gráficos -->
    <div class="my-4">
        <canvas id="chartGenero" width="400" height="200"></canvas>
    </div>
    <div class="my-4">
        <canvas id="chartAnio" width="400" height="200"></canvas>
    </div>
    <div class="my-4">
        <canvas id="chartMarca" width="400" height="200"></canvas>
    </div>
    <div class="my-4">
        <canvas id="chartMejoresMarcas" width="400" height="200"></canvas>
    </div>
</div>

<script>
    const apiEndpoint = 'http://localhost/Proyecto_bd_1/BackEnd/viewTV';

    async function loadReport() {
        try {
            const response = await fetch(apiEndpoint);
            const data = await response.json();
            const details = data.detalle;

            const generoData = {};
            const anioData = {};
            const marcaData = {};
            const mejoresMarcasData = {};

            details.forEach(item => {
                const totalIngresos = parseFloat(item.TotalIngresos);
                const totalVentas = parseInt(item.TotalVentas);

                // Agrupar por género
                generoData[item.Genero] = (generoData[item.Genero] || 0) + totalIngresos;

                // Agrupar por año
                anioData[item.Año] = (anioData[item.Año] || 0) + totalIngresos;

                // Agrupar por marca (ingresos)
                marcaData[item.Marca] = (marcaData[item.Marca] || 0) + totalIngresos;

                // Agrupar por marca (unidades vendidas)
                mejoresMarcasData[item.Marca] = (mejoresMarcasData[item.Marca] || 0) + totalVentas;
            });

            // Crear gráficos
            createChart('chartGenero', 'Ingresos Totales por Género', generoData);
            createChart('chartAnio', 'Ingresos Totales por Año', anioData);
            createChart('chartMarca', 'Ingresos Totales por Marca', marcaData);
            createChart('chartMejoresMarcas', 'Mejores Marcas por Unidades Vendidas', mejoresMarcasData);
        } catch (error) {
            console.error('Error al cargar el informe:', error);
        }
    }

    function createChart(canvasId, title, data) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        const labels = Object.keys(data);
        const values = Object.values(data);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: title,
                    data: values,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: title
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Cargar los reportes al cargar la página
    loadReport();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
