<?php

require 'config.inc.php';

class DAO extends Conection {

    function __construct() {
        $this->startConection();
    }

    public function daoQuery($sql, $params = array()) {
        try {
            $this->isEmpty($sql); 
        } catch (Exception $e) {
            die($e->getMessage());
        }
    
        $stmt = mysqli_prepare($this->con, $sql);
    
        if ($stmt === false) {
            die("Error de preparación de consulta: " . mysqli_error($this->con));
        }
    
        if (!empty($params)) {

            $types = "";
            $bindParams = array();
    
            foreach ($params as $param) {

                if (is_int($param)) {
                    $types .= "i"; // Entero
                } elseif (is_double($param)) {
                    $types .= "d"; 
                } else {
                    $types .= "s"; 
                }
                $bindParams[] = &$param;
            }
    
            array_unshift($bindParams, $stmt, $types);
            call_user_func_array("mysqli_stmt_bind_param", $bindParams);
        }
    

        if (!mysqli_stmt_execute($stmt)) {
            die("Error al ejecutar la consulta: " . mysqli_stmt_error($stmt));
        }

        if (stripos(trim($sql), 'SELECT') === 0) {
            $result = mysqli_stmt_get_result($stmt);
            $toReturn = array();
    
            while ($array = mysqli_fetch_assoc($result)) { 
                $toReturn[] = $array;
            }
    
            mysqli_stmt_close($stmt);
            return $toReturn;
        } else {

            $affectedRows = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $affectedRows;
        }
    }

    public function isEmpty($parameter) {
        if (is_array($parameter)) {
            if (count($parameter) <= 0) {
                throw new Exception("Fatal error, array parameter is empty", 1);
            }
        } else {
            if ($parameter === "") {
                throw new Exception("Fatal error, missing SQL statement", 1);
            } else {
                return $parameter;
            }
        }
    }


    public function userExist($email) {
        if (empty($email)) {
            die("Email is empty");
        }
        $query = "SELECT COUNT(*) n FROM users WHERE email = ?"; 
        $params = [$email]; 

        $resultSet = $this->daoQuery($query, $params);

        return $resultSet[0]['n'] == '1';
    }

}

?>
