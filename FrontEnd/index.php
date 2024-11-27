</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos desde API</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Datos Obtenidos desde la API</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody id="data-table">
            <!-- Aquí se insertarán los datos dinámicamente -->
        </tbody>
    </table>

    <script>
        // URL de la API
        const apiUrl = 'http://localhost/Proyecto_bd_1/BackEnd/index.php';

        // Función para obtener datos de la API
        async function fetchData() {
            try {
                const response = await fetch(apiUrl, {
                    method: 'GET'
                });

                // Verificar si la respuesta es exitosa
                if (!response.ok) {
                    throw new Error(`Error al obtener datos: ${response.statusText}`);
                }

                // Parsear la respuesta a JSON
                const { detalle } = await response.json();

                // Insertar los datos en la tabla
                populateTable(detalle);
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Función para rellenar la tabla con los datos
        function populateTable(data) {
            const tableBody = document.getElementById('data-table');

            // Limpiar el contenido previo
            tableBody.innerHTML = '';

            // Recorrer los datos y generar filas
            data.forEach(item => {
                const row = document.createElement('tr');

                // Crear columnas para ID, Nombre, Teléfono y Dirección
                row.innerHTML = `
                    <td>${item.idCliente}</td>
                    <td>${item.nombre}</td>
                    <td>${item.noTelefono}</td>
                    <td>${item.direccion}</td>
                `;

                tableBody.appendChild(row);
            });
        }

        // Llamar a la función para obtener los datos al cargar la página
        fetchData();
    </script>
</body>
</html>
