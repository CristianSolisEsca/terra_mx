<?php

require_once 'DAO.php';  
class SrvRegister extends DAO {

    public function __construct(){
        $this->startConection();
    }

    public function registerUser($name, $email, $password){
        if (empty($name) || empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
            exit;
        }

        if ($this->userExist($email)) {
            echo json_encode(['status' => 'error', 'message' => 'El correo electrónico ya está registrado']);
            exit;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);


        $query = "INSERT INTO users (name, email, password, status, created_at) VALUES ('$name', '$email', '$passwordHash', 1, NOW())";


        if ($this->daoQuery($query)) {
            echo json_encode(['status' => 'success', 'message' => 'Usuario registrado exitosamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos']);
        }

        exit;
    }

    
    
    


    public function handleRegistrationRequest() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            // Valida que los datos no estén vacíos
            if (empty($name) || empty($email) || empty($password)) {
                echo 'error';
                error_log('Datos vacíos: ' . json_encode($_POST));
                exit;
            }


            if ($this->registerUser($name, $email, $password)) {
                echo 'success'; 
                error_log('Usuario registrado: ' . $email); 
            } else {
                echo 'error'; 
                error_log('Error al registrar el usuario: ' . $email);
            }
        }
    }
}


$srvRegister = new SrvRegister();
$srvRegister->handleRegistrationRequest();
?>
