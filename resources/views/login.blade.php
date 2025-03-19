<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Gestión de Tareas</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h2>Iniciar Sesión</h2>
    <form id="loginForm">
      <div class="form-group">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" class="form-control" placeholder="Ingrese su email" required>
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" class="form-control" placeholder="Ingrese su contraseña" required>
      </div>
      <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
    <div id="error" class="mt-3 text-danger"></div>
  </div>

  <!-- jQuery y Bootstrap JS (opcionalmente puedes usar Vanilla JS) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      try {
        const response = await fetch('/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ email, password })
        });
        const data = await response.json();
        if(response.ok){
          // Guarda el token en localStorage
          localStorage.setItem('access_token', data.access_token);
          // Redirecciona a la página de tareas
          window.location.href = '/tasks';
        } else {
          document.getElementById('error').innerText = data.error || 'Error al iniciar sesión';
        }
      } catch (error) {
        document.getElementById('error').innerText = 'Error en la conexión al servidor';
      }
    });
  </script>
</body>
</html>
