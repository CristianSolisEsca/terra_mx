<?php  
  session_start();

  if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
    header("location: ../login.php");
    exit(); 
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lista de Tareas</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100 min-h-screen">

  <header class="bg-blue-600 text-white p-4 shadow">
    <div class="max-w-5xl mx-auto flex justify-between items-center">
      <h1 class="text-xl font-bold">Task Manager</h1>
      <span class="text-sm">Bienvenido, <?php echo $_SESSION['name'];?></span>
      <input type="hidden" id="axios" value="<?php echo $_SESSION['userID']; ?>">
      <div class="flex justify-end">
        <a href="../logout.php" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>
    </div>
    </div>
  </header>

  <main class="max-w-5xl mx-auto p-6">
    <div class="mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">Tus Tareas</h2>
    </div>

    <div class="mb-6">
    <input type="text" id="searchTask" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Buscar tarea por nombre..." onkeyup="searchTask()" />
    </div>

    <!-- Botón para agregar tarea -->
    <div class="mb-6 flex justify-end">
      <button id="addTaskBtn" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
        <i class="fas fa-plus"></i> Agregar Tarea
      </button>
    </div>

    <div id="list" class="grid gap-4 md:grid-cols-2">
      <!-- Aquí se cargarán las tareas -->
    </div>
  </main>

  <script src="../js/gestTask.js"></script>
</body>
</html>
