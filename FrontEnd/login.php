<?php
session_start();

// Datos de conexión
define('DB_HOST', 'localhost');
define('DB_PORT', 3308); // Puerto de conexión
define('DB_NAME', 'compania');
define('DB_USER_ADMIN', 'Validaciones'); // Usuario con permisos de validación
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
 * Valida las credenciales de usuario
 */
function validarUsuario($nombreUsuario, $contrasena) {
    try {
        $conn = conectarDB(DB_USER_ADMIN, DB_PASS_ADMIN);
        $stmt = $conn->prepare("SELECT contrasenaHash, rol FROM usuarios_aplicacion WHERE nombreUsuario = :nombreUsuario");
        $stmt->bindParam(':nombreUsuario', $nombreUsuario);
        $stmt->execute();

        if ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($contrasena, $fila['contrasenaHash'])) {
                return $fila['rol']; // Retorna el rol del usuario
            }
        }

        return false;
    } catch (PDOException $e) {
        die("Error al validar usuario: " . $e->getMessage());
    }
}

// Manejo de la solicitud POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = $_POST['nombreUsuario'];
    $contrasena = $_POST['contrasena'];

    $rol = validarUsuario($nombreUsuario, $contrasena);

    if ($rol) {
        // Establece la conexión con el usuario correcto
        if ($rol === 'lectura') {
            $_SESSION['usuario'] = $nombreUsuario;
            $_SESSION['password'] = $contrasena;
        } elseif ($rol === 'admin') {
            $_SESSION['usuario'] = $nombreUsuario;
            $_SESSION['password'] = $contrasena;
        }

        header("Location: dashboard.php");
        exit;
    } else {
        echo "Credenciales inválidas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="POST" action="">
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


