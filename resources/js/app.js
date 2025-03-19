import './bootstrap';

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