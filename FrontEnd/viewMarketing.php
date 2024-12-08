<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Reportes - Ventas</title>
</head>
<body>
<div class="container my-4">
    <!-- Botón de Cerrar Sesión -->
    <div class="d-flex justify-content-end mb-3">
        <a href="/logout" class="btn btn-danger">Cerrar Sesión</a>
    </div>

    <!-- Título -->
    <h1 class="text-center text-primary mb-4">Informes</h1>

    <!-- Selector de tipo de informe -->
    <div class="mb-3">
        <label for="reportTypeSelect" class="form-label">Selecciona un Informe</label>
        <select class="form-select" id="reportTypeSelect">
            <option value="" selected disabled>Selecciona un informe...</option>
            <option value="ventas">Informes de Ventas</option>
            <option value="historial-busquedas">Historial de busquedas</option>
            <option value="mejores-marcas-unidades">Mejores Marcas por Unidades Vendidas</option>
            <option value="mejores-marcas-dolares">Mejores Marcas por Total en Dólares</option>
            <option value="tendencias-ventas">Tendencias de Ventas</option>
            <option value="tiempo-inventario">Tiempo Promedio de Inventario</option>
            <option value="convertibles">Ventas de Convertibles</option>
            
        </select>
    </div>

    <!-- Contenedor de resultados -->
    <div id="reportContainer" class="my-4">
        <h2 class="text-center text-primary">Resultados</h2>
        <table class="table table-bordered">
            <thead id="tableHeader">
                <!-- Encabezados dinámicos -->
            </thead>
            <tbody id="tableBody">
                <!-- Datos dinámicos -->
            </tbody>
        </table>
    </div>
</div>

<script>
    // URLs base para las APIs
    const apiEndpoints = {
        ventas: 'http://localhost/Proyecto_bd_1/BackEnd/viewInformeVentas',
        "mejores-marcas-unidades": 'http://localhost/Proyecto_bd_1/BackEnd/viewMUV',
        "mejores-marcas-dolares": 'http://localhost/Proyecto_bd_1/BackEnd/viewMTD',
        "tendencias-ventas": 'http://localhost/Proyecto_bd_1/BackEnd/viewTV',
        "tiempo-inventario": 'http://localhost/Proyecto_bd_1/BackEnd/viewTI',
        convertibles: 'http://localhost/Proyecto_bd_1/BackEnd/viewConvertibles',
        "historial-busquedas":'http://localhost/Proyecto_bd_1/BackEnd/historial',
    };

    // Elementos del DOM
    const reportTypeSelect = document.getElementById('reportTypeSelect');
    const tableHeader = document.getElementById('tableHeader');
    const tableBody = document.getElementById('tableBody');

    // Función para cargar datos dinámicos según el tipo de informe
    async function loadReport(reportType) {
        try {
            const response = await fetch(apiEndpoints[reportType]);
            const data = await response.json();

            // Limpia los encabezados y el cuerpo de la tabla
            tableHeader.innerHTML = '';
            tableBody.innerHTML = '';

            // Accede a "detalle" si existe
            const details = data.detalle || data;

            // Generar encabezados dinámicos
            if (details.length > 0) {               
                const headers = Object.keys(details[0]);
                const headerRow = document.createElement('tr');
                headers.forEach((header) => {
                    const th = document.createElement('th');
                    th.textContent = header;
                    headerRow.appendChild(th);
                });
                tableHeader.appendChild(headerRow);
            }

            // Generar filas dinámicas
            details.forEach((item) => {
                const row = document.createElement('tr');
                Object.values(item).forEach((value) => {
                    const td = document.createElement('td');
                    td.textContent = value;
                    row.appendChild(td);
                });
                tableBody.appendChild(row);
            });
        } catch (error) {
            console.error('Error al cargar el informe:', error);
        }
    }

    // Evento al seleccionar un tipo de informe
    reportTypeSelect.addEventListener('change', () => {
        const reportType = reportTypeSelect.value;
        if (reportType) {
            loadReport(reportType);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
