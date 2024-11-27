<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<p>hola Mundo</p>
<script>
    document.getElementById('telefono').addEventListener('input', async function () {
        const telefono = this.value;
        if (telefono.length > 0) {
            try {
                const response = await fetch('http://localhost/Proyecto_bd_1/BackEnd/validarTelefono.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ telefono: telefono })
                });
                const result = await response.json();
                const mensaje = document.getElementById('mensaje');
                mensaje.textContent = result.existe ? 'El número ya está registrado' : 'Número disponible';
                mensaje.style.color = result.existe ? 'red' : 'green';
            } catch (error) {
                document.getElementById('mensaje').textContent = 'Error al validar el número';
                document.getElementById('mensaje').style.color = 'orange';
            }
        } else {
            document.getElementById('mensaje').textContent = '';
        }
    });
</script>
</body>
</html>
