<?php  
require 'dao.php';

class SrvLogin extends DAO {

    function __construct(){
        $this->startConection();
    }

    public function userExist($email){
        if (empty($email)) {
            die("Parameter 'email' is empty");
        }

        $resultSet = $this->daoQuery("SELECT COUNT(*) n FROM users WHERE email = '".addslashes($email)."'");

        return $resultSet[0]['n'] == '1';
    }

    public function userActive($email){
        if (empty($email)) {
            die("Parameter 'email' is empty");
        }

        $resultSet = $this->daoQuery("SELECT COUNT(*) n FROM users WHERE email = '".addslashes($email)."' AND status = 1");

        return $resultSet[0]['n'] == '1';
    }

    public function engineLogin($email, $password){
        if (empty($email) || empty($password)) {
            die("Invalid Parameters");
        }
    
        // Busca el password hash por email
        $resultSet = $this->daoQuery("SELECT password FROM users WHERE email = '".addslashes($email)."'");
    
        if (count($resultSet) === 0) {
            return false; // No existe el usuario
        }
    
        $hash = $resultSet[0]['password'];
    
        // Verifica la contraseña con password_verify
        return password_verify($password, $hash);
    }
    
    
    public function makeSessionData($email){
        $resultSet = $this->daoQuery("SELECT id, name FROM users WHERE email = '".addslashes($email)."'");
    
        if (count($resultSet) == 0) return false;
    
        session_start();
        $_SESSION['userID']  = $resultSet[0]['id'];
        $_SESSION['name']    = $resultSet[0]['name'];
        $_SESSION['logged']  = true;
    
        return true;
    }
    public function destroySessionData(){
        session_start();
        session_destroy();
    }

    public function getRealName(){
        session_start();
        return $_SESSION['name'] ?? null;
    }
}
?>
