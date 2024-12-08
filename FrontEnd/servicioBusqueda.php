<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Búsqueda de Vehículos</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        h1 {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Servicio de Búsquedas de Vehículos</h1>
        
        <!-- Formulario de búsqueda -->
        <form id="searchForm" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="color" class="form-label">Color</label>
                    <select id="color" name="color" class="form-select">
                        <option value="">Seleccione...</option>
                        <option value="rojo">Rojo</option>
                        <option value="azul">Azul</option>
                        <option value="blanco">Blanco</option>
                        <option value="negro">Negro</option>
                        <option value="gris">Gris</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="transmision" class="form-label">Transmisión</label>
                    <select id="transmision" name="transmision" class="form-select">
                        <option value="">Seleccione...</option>
                        <option value="manual">Manual</option>
                        <option value="automática">Automática</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="estiloCarroceria" class="form-label">Estilo de Carrocería</label>
                    <select id="estiloCarroceria" name="estiloCarroceria" class="form-select">
                        <option value="">Seleccione...</option>
                        <option value="sedan">Sedan</option>
                        <option value="hatchback">Hatchback</option>
                        <option value="suv">SUV</option>
                        <option value="coupe">Coupe</option>
                        <option value="pickup">Pickup</option>
                        <option value="convertible">Convertible</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" id="marca" name="marca" class="form-control" placeholder="Ingrese la marca">
                </div>
            </div>
            <div class="mt-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <!-- Tabla de resultados -->
        <div>
            <h2 class="text-center text-primary mb-3">Resultados</h2>
            <table class="table table-bordered table-hover">
                <thead id="tableHeader">
                    <!-- Encabezados dinámicos -->
                </thead>
                <tbody id="tableBody">
                    <!-- Filas dinámicas -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const searchForm = document.getElementById('searchForm');
        const tableHeader = document.getElementById('tableHeader');
        const tableBody = document.getElementById('tableBody');
        
        // URL de la API
        const apiEndpoint = 'http://localhost/Proyecto_bd_1/BackEnd/buscarVehiculo'; // Cambia por tu endpoint real

        // Manejo del evento submit del formulario
        searchForm.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevenir recarga de la página

            // Crear el FormData con los datos del formulario
            const formData = new FormData(searchForm);

            try {
                // Hacer la solicitud a la API con POST
                const response = await fetch(apiEndpoint, {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                // Limpiar la tabla
                tableHeader.innerHTML = '';
                tableBody.innerHTML = '';

                // Verificar si hay datos en la respuesta
                const details = Array.isArray(data.detalle) ? data.detalle : [data.detalle];

                // Crear encabezados dinámicos
                if (details.length > 0) {
                    const headers = Object.keys(details[0]);
                    const headerRow = document.createElement('tr');
                    headers.forEach(header => {
                        const th = document.createElement('th');
                        th.textContent = header;
                        headerRow.appendChild(th);
                    });
                    tableHeader.appendChild(headerRow);
                } else {
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = `<td colspan="5" class="text-center">No se encontraron resultados</td>`;
                    tableBody.appendChild(emptyRow);
                    return;
                }

                // Crear filas dinámicas
                details.forEach(item => {
                    const row = document.createElement('tr');
                    Object.values(item).forEach(value => {
                        const td = document.createElement('td');
                        td.textContent = value;
                        row.appendChild(td);
                    });
                    tableBody.appendChild(row);
                });
            } catch (error) {
                console.error('Error al realizar la búsqueda:', error);
                tableBody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Ocurrió un error al cargar los datos</td></tr>`;
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
