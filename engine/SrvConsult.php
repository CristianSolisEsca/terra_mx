<?php  

	require 'dao.php';
	
	class SrvConsult extends DAO{
	function __construct(){
		$this->startConection();		
	}

	public function getTaskUser($user_id) {
		$datos = $this->daoQuery("SELECT id, task_name, task_description, status, due_date 
								  FROM tasks
								  WHERE user_id = $user_id AND is_deleted = 0
								  ORDER BY due_date");
	
		$json = array();
		foreach ($datos as $key) {
			$json[] = array(
				'id'         		=> $key['id'],  
				'task_name'  		=> $key['task_name'], 
				'task_description'  => $key['task_description'], 
				'status'     		=> $key['status'], 
				'due_date'   		=> $key['due_date'],
			);
		}
	
		if (empty($json)) {
			$json = array('error' => 'No se encontraron datos');
		}
	
		header('Content-Type: application/json');
		echo json_encode($json);
	}
	
	}


?>

