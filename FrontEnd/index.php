<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Página de Ingreso</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            font-size: 1.25rem;
            font-weight: bold;
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            margin-bottom: 20px;
            padding-bottom: 10px;
            text-align: center;
        }

        .form-label {
            font-weight: bold;
            color: #495057;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background: #198754;
            color: white;
            font-weight: bold;
            border: none;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background: #157347;
        }

        .text-muted {
            text-align: center;
            font-size: 0.875rem;
            margin-top: 15px;
        }
    </style>

    <script>async function handleLogin(event) {
    event.preventDefault(); // Evitar el envío tradicional del formulario

    const formData = new FormData(document.getElementById("loginForm"));

    try {
        const response = await fetch("http://localhost/Proyecto_bd_1/backEnd/login", {
            method: "POST",
            body: formData,
        });

        const data = await response.json();

        if (data.status === 200) {
            alert("Inicio de sesión exitoso.");

            // Redirigir según el rol del usuario
            switch (data.rol) {
                case "admin":
                    window.location.href = "http://localhost/Proyecto_bd_1/FrontEnd/admin.php";
                    break;
                case "cliente":
                    window.location.href = "http://localhost/Proyecto_bd_1/FrontEnd/clienteView.php";
                    break;
                case "concesionario":
                    window.location.href = "http://localhost/Proyecto_bd_1/FrontEnd/servicioBusqueda.php";
                    break;
                case "marketing":
                    window.location.href = "http://localhost/Proyecto_bd_1/FrontEnd/viewMarketing.php";
                    break;
                default:
                    alert("Rol desconocido. Contacta al administrador.");
                    break;
            }
        } else {
            // Manejar errores de autenticación
            switch (data.status) {
                case 401:
                    alert("Credenciales inválidas. Por favor, verifica tu usuario y contraseña.");
                    break;
                case 400:
                    alert("Faltan datos de inicio de sesión o los datos son incorrectos.");
                    break;
                case 405:
                    alert("Método no permitido. Por favor, utiliza el método adecuado.");
                    break;
                default:
                    alert("Error desconocido. Intenta nuevamente.");
                    break;
            }
        }
    } catch (error) {
        alert("Ocurrió un error al intentar iniciar sesión. Intenta nuevamente.");
        console.error(error);
    }
}

    </script>
</head>
<body>
    <div class="login-container">
        <div class="login-header">Iniciar Sesión</div>
        <form id="loginForm">
            <div class="mb-3">
                <label for="nombreUsuario" class="form-label">Usuario</label>
                <input type="text" id="nombreUsuario" name="nombreUsuario" class="form-control" placeholder="Escribe tu usuario" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Escribe tu contraseña" required>
            </div>
            <button type="submit" class="btn btn-outline-success form-control">Ingresar</button>
        </form>
        <p class="text-muted">¿Olvidaste tu contraseña? Contacta al administrador.</p>
    </div>

    <script>
        document.getElementById("loginForm").addEventListener("submit", handleLogin);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>