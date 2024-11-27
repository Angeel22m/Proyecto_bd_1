<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['password'])) {
    header("Location: login.php");
    exit;
}

try {
    // Configuración de conexión
    $dsn = "mysql:host=localhost;port=3308;dbname=compania;charset=utf8mb4";
    $usuario = $_SESSION['usuario'];
    $contrasena = $_SESSION['password'];

    // Crear conexión PDO
    $conn = new PDO($dsn, $usuario, $contrasena);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta segura de solo lectura
    $stmt = $conn->prepare("SELECT idCliente, nombre, direccion FROM clientes");
    $stmt->execute();

    // Mostrar los resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Accede a las columnas correctas de la tabla 'clientes'
        echo "ID Cliente: " . htmlspecialchars($row['idCliente']) . "<br>";
        echo "Nombre: " . htmlspecialchars($row['nombre']) . "<br>";
        echo "Dirección: " . htmlspecialchars($row['direccion']) . "<br>";
        echo "<hr>";  // Separador entre registros
    }
} catch (PDOException $e) {
    die("Error en la conexión o consulta: " . $e->getMessage());
}
?>


