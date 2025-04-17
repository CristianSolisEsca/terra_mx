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

	function getTaskUserAdd($task_name, $task_description, $task_status, $user_id) {

		if (empty($task_name) || empty($task_description) || empty($task_status) || empty($user_id)) {
			echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
			return;
		}
	
		$query = "INSERT INTO tasks (task_name, task_description, status, user_id, is_deleted) 
				  VALUES ('".$task_name."', '".$task_description."', '".$task_status."', ".$user_id.", 0)"; 

		$result = $this->daoQuery($query);
	
		if ($result) {
			echo json_encode(['success' => true, 'message' => 'Tarea agregada correctamente.']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Error al agregar la tarea.']);
		}
	}
	
	public function getTaskUserDataOnlyID($task_id) {
		$datos = $this->daoQuery("SELECT id, task_name, task_description, status, due_date 
								  FROM tasks
								  WHERE id = $task_id");
	
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

	function getTaskUserUpdate($task_id, $task_name, $task_description, $task_status) {

		$checkTaskData = $this->daoQuery("SELECT * FROM tasks WHERE id = '".intval($task_id)."'");

		ob_start(); 

		$this->daoQuery("UPDATE tasks SET 
			task_name = '".$task_name."', 
			task_description = '".$task_description."', 
			status = '".$task_status."' 
			WHERE id = ".intval($task_id)."");

		$checkUpdate = $this->daoQuery("SELECT COUNT(*) c FROM tasks WHERE id = ".intval($task_id)."");

		ob_clean(); 

		header('Content-Type: application/json');

		if ($checkUpdate[0]['c'] == "1") {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
		return;
	}


	function getTaskUserDelete($task_id) {

		$checkTaskData = $this->daoQuery("SELECT * FROM tasks WHERE id = '".intval($task_id)."'");

		ob_start(); 

		//LO que he aprendido a hacer son borrados logicos no delete directos ya que puede utilizarse mas adelante la información o sirve de historico

		$this->daoQuery("UPDATE tasks SET 
			is_deleted = 1 
			WHERE id = ".intval($task_id)."");

		$checkUpdate = $this->daoQuery("SELECT COUNT(*) c FROM tasks WHERE id = ".intval($task_id)."");

		ob_clean(); 

		header('Content-Type: application/json');

		if ($checkUpdate[0]['c'] == "1") {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
		return;
	}


	}


?>

