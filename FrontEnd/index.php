<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Pagina de Ingreso</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <style>
          .container1 {
            width: 30%;
            position: absolute;
            top: 30%;
            left: 30%;
            }
        </style>
         <script>

          // Función para manejar el formulario
          async function handleLogin(event) {
              event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional
      
                // Crear un objeto FormData con los datos del formulario
                const formData = new FormData(document.getElementById("loginForm"));
      
              
              try {
                  // Enviar datos al servidor con fetch
                  const response = await fetch("http://localhost/Proyecto_bd_1/backEnd/login", {
                      method: "POST",                
                      body:formData,
                  });
      
                  // Obtener el JSON de la respuesta
                  const data = await response.json(); 
      
                  // Evaluar el status de la respuesta
                  switch (data.status) {
                      case 200:
                          alert("Inicio de sesión exitoso.");
                          // Redirigir a otra página (cambia la URL de acuerdo con tu necesidad)
                          window.location.href = "http://localhost/Proyecto_bd_1/FrontEnd/clientes.php"; // Cambia la URL de destino
                          break;
      
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
              } catch (error) {
                  // Manejo de errores en la conexión o en el código
                  alert("Ocurrió un error al intentar iniciar sesión. Intenta nuevamente.");
                  console.error(error);
              }
          }
      </script>
    </head>
    <body >
     

        <div class="container1 container border" id="container">

          <form id="loginForm">
            <div class="mb-2 row text-center text-primary">
            <label  class="col-form-label border-bottom">Ingrese su Usuario y Contraseña</label>
          </div>
        <div class="mb-2 row text-secondary">
            <label  class="col-form-label">Usuario</label>
            <div>
              <input type="text" name="nombreUsuario" class="form-control" id="nombreUsuario" required>
            </div>
          </div>
          <div class="mb-2 row text-secondary">
            <label  class="col-form-label">Contraseña</label>
            <div>
              <input type="password" name="contrasena" class="form-control" id="contrasena" required>
            </div>
          </div>
          <div class="mb-2 text-center">
            <button type="submit" class="btn btn-outline-success">Ingresar</button>
        </div>
      </form>

        </div>
    </body>
    <script>
      // Asociar el evento submit al formulario
      document.getElementById("loginForm").addEventListener("submit", handleLogin);
  </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>