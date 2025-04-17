<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | Task Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
  <div class="w-full max-w-sm sm:max-w-md md:max-w-lg bg-white p-6 sm:p-8 rounded-xl shadow-lg">
    <h1 class="text-2xl sm:text-3xl font-bold text-center mb-6">Iniciar Sesión</h1>
    <form id="loginForm" name="loginForm" class="space-y-5">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
        <input
          type="email"
          id="email"
          name="email"
          required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300 text-base sm:text-lg"
          placeholder="tu@correo.com"
        />
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
        <input
          type="password"
          id="password"
          name="password"
          required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300 text-base sm:text-lg"
          placeholder="********"
        />
      </div>
      <button
        type="submit"
        class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition text-base sm:text-lg"
      >
        Entrar
      </button>
    </form>
    <p class="text-center text-sm sm:text-base text-gray-500 mt-6">
      ¿No tienes cuenta? <a href="register.php" class="text-blue-600 hover:underline">Regístrate</a>
    </p>
  </div>

  <script type="text/javascript" src="js/login.js"></script>
</body>
</html>
