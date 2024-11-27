<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_PORT', 3308); // Puerto de conexión
define('DB_NAME', 'compania');
define('DB_USER_ADMIN', 'root'); // Usuario con permisos de validación
define('DB_PASS_ADMIN', '12345678'); // Contraseña del usuario admin

/**
 * Conexión a la base de datos usando PDO
 */
function conectarDB($usuario, $contrasena) {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
        $conn = new PDO($dsn, $usuario, $contrasena);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
}

/**
 * Actualiza la contraseña del usuario
 */
function actualizarContraseña($nombreUsuario, $nuevaContraseña) {
    try {
        // Conectar a la base de datos como administrador
        $conn = conectarDB(DB_USER_ADMIN, DB_PASS_ADMIN);

        // Hashear la nueva contraseña
        $nuevaContraseñaHash = password_hash($nuevaContraseña, PASSWORD_DEFAULT);

        // Preparar y ejecutar la consulta de actualización
        $stmt = $conn->prepare("UPDATE usuarios_aplicacion SET contrasenaHash = :contrasenaHash WHERE nombreUsuario = :nombreUsuario");
        $stmt->bindParam(':contrasenaHash', $nuevaContraseñaHash);
        $stmt->bindParam(':nombreUsuario', $nombreUsuario);
        
        // Ejecutar la consulta
        $stmt->execute();

        echo "La contraseña se ha actualizado correctamente.";

    } catch (PDOException $e) {
        die("Error al actualizar la contraseña: " . $e->getMessage());
    }
}

// Si la solicitud es POST, procesar la actualización
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = $_POST['nombreUsuario'];
    $nuevaContraseña = $_POST['nuevaContraseña'];

    // Llamar a la función para actualizar la contraseña
    actualizarContraseña($nombreUsuario, $nuevaContraseña);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Contraseña</title>
</head>
<body>
    <h1>Actualizar Contraseña</h1>
    <form method="POST" action="">
        <label for="nombreUsuario">Usuario:</label>
        <input type="text" name="nombreUsuario" id="nombreUsuario" required>
        <br>
        <label for="nuevaContraseña">Nueva Contraseña:</label>
        <input type="password" name="nuevaContraseña" id="nuevaContraseña" required>
        <br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
