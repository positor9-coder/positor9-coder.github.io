<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio - Practica1</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!--
    Versión en HTML/JavaScript del PHP original.
    Esta página comprueba si existe `localStorage.username`.
    Si no existe redirige a login.html.
    Para integrarlo con tu backend, sustituye la lógica de JS
    por la inserción del nombre de usuario desde el servidor.
  -->

  <script>
    // Comportamiento cliente: revisar si hay usuario en localStorage
    const username = localStorage.getItem('username');
    if (!username) {
      // Si no hay usuario, redirigir a un login estático (cambia la ruta si necesitas)
      window.location.href = 'login.html';
    }
  </script>

  <main>
    <h2 id="welcome">Bienvenido, invitado!</h2>
    <p>Esta es la página protegida (index.html).</p>
    <p><a href="#" id="logout">Cerrar sesión</a></p>
  </main>

  <script>
    // Mostrar el nombre de usuario si está disponible
    const welcomeEl = document.getElementById('welcome');
    if (username) {
      // escapar caracteres para evitar XSS al insertar en el DOM
      const safeName = document.createTextNode(username);
      // limpiar y volver a insertar
      welcomeEl.textContent = 'Bienvenido, ';
      welcomeEl.appendChild(safeName);
      welcomeEl.appendChild(document.createTextNode('!'));
    }

    // Funcionalidad de "logout" que borra localStorage y redirige
    document.getElementById('logout').addEventListener('click', function (e) {
      e.preventDefault();
      localStorage.removeItem('username');
      // redirigir a la página de login
      window.location.href = 'login.html';
    });
  </script>
</body>
</html>
