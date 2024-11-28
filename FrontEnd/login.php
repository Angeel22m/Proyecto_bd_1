
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="POST" action="http://localhost/Proyecto_bd_1/backEnd/login">
        <label for="nombreUsuario">Usuario:</label>
        <input type="text" name="nombreUsuario" id="nombreUsuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        <br>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>


