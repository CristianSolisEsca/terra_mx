<?php  

	class Conection{
		
		var $con;
 
		var $ipPublica = "";
		var $local = false;
		
		function __construct(){
			$this->startConection();
		}

		public function startConection(){
			$this->con = mysqli_connect('127.0.0.1', 'root', 'Axios9408@', 'tasks_db');

			if (!$this->con) {
				throw new Exception("Error de conexión: " . mysqli_connect_error());
			}
			
			mysqli_set_charset($this->con, "utf8");
		}
	}

?>

