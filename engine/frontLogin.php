<?php
require_once 'SrvLogin.php';

$login = new SrvLogin();

if (isset($_POST['resetSession'])) {
    $login->destroySessionData();
    exit;
}

if (isset($_POST['getRealName'])) {
    echo $login->getRealName();
    exit;
}

if (isset($_POST['email']) && isset($_POST['passw'])) {
    $email = $_POST['email'];
    $password = $_POST['passw'];

    if (!$login->userExist($email)) {
        echo json_encode("001"); // Usuario no existe
        exit;
    }

    // Verificar la contraseña (con hash) usando password_verify
    if (!$login->engineLogin($email, $password)) {
        echo json_encode("002"); // Contraseña incorrecta
        exit;
    }

    // Verificar si el usuario está activo
    if (!$login->userActive($email)) {
        echo json_encode("006"); // Usuario desactivado
        exit;
    }

    // Si todo está bien, crear la sesión
    if ($login->makeSessionData($email)) {
        echo json_encode("004"); // Éxito
        exit;
    } else {
        echo json_encode("003"); // Error al crear sesión
        exit;
    }
}
?>
