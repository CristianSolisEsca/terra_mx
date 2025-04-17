<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 p-4">

    <div class="flex justify-center items-center h-screen">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-3xl font-semibold text-center text-gray-700 mb-6">Registro</h2>

            <form id="registerForm">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600">Nombre Completo</label>
                    <input id="name" name="name" type="text" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Ingresa tu nombre">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">Correo Electrónico</label>
                    <input id="email" name="email" type="email" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="ejemplo@dominio.com">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">Contraseña</label>
                    <input id="password" name="password" type="password" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Ingresa una contraseña">
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Confirmar Contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Confirma tu contraseña">
                </div>

                <!-- Botón de Registro -->
                <div class="mb-4">
                    <button type="submit" class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        Crear Cuenta
                    </button>
                </div>

                <!-- Link a Login -->
                <div class="text-center text-sm">
                    <span class="text-gray-600">¿Ya tienes una cuenta? </span>
                    <a href="login.php" class="text-blue-500 hover:underline">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>

    <script>
     $(document).ready(function(){
    $('#registerForm').on('submit', function(e){
        e.preventDefault(); 

        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var password_confirmation = $('#password_confirmation').val();

        if (password !== password_confirmation) {
            Swal.fire({
                icon: 'error',
                title: 'Las contraseñas no coinciden',
                text: 'Por favor, asegúrate de que las contraseñas sean iguales.',
            });
            return;
        }

        $.ajax({
            url: 'engine/SrvRegister.php',
            type: 'POST',
            data: {name: name, email: email, password: password},
            success: function(response){
                try {
                    var res = JSON.parse(response); 

                    if(res.status === 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Registro exitoso',
                            text: res.message, 
                        }).then(() => {
                            window.location.href = 'login.php'; 
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al registrar',
                            text: res.message, 
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de comunicación',
                        text: 'Hubo un problema al procesar la respuesta del servidor.',
                    });
                }
            },
            error: function(){
                Swal.fire({
                    icon: 'error',
                    title: 'Error de comunicación',
                    text: 'Hubo un problema al comunicarse con el servidor. Intenta nuevamente más tarde.',
                });
            }
        });
    });
});

    </script>
</body>
</html>
