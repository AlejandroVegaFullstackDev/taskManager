<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Gestión de Tareas</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Bootstrap Icons (Opcional) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  
@vite(['resources/css/app.css', 'resources/css/style.css'])
</head>
<body>
  <div class="d-flex align-items-center justify-content-center" style="min-height:100vh; background-color: #f8f9fa;">
    <div class="p-4 rounded shadow login-container" style="max-width: 400px; width: 100%;">
      <h2 class="mb-4 text-center login-title">
        <i class="bi bi-person-circle"></i> Iniciar Sesión
      </h2>
      <form id="loginForm">
        <div class="form-group mb-3">
          <label for="email" class="fw-bold mb-1">Correo Electrónico</label>
          <input type="email" id="email" class="form-control rounded-pill" placeholder="Ingrese su email" required>
        </div>
        <div class="form-group mb-4">
          <label for="password" class="fw-bold mb-1">Contraseña</label>
          <input type="password" id="password" class="form-control rounded-pill" placeholder="Ingrese su contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm p-2">
          <i class="bi bi-box-arrow-in-right"></i> Ingresar
        </button>
      </form>
      <div id="error" class="mt-3 text-danger text-center"></div>
    </div>
  </div>

  <!-- jQuery y Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  @vite(['resources/js/app.js', 'resources/js/scripts.js'])

  <style>

  </style>
</body>
</html>
