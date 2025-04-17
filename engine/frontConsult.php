<?php 

	require 'SrvConsult.php';

	$inst = new SrvConsult();

	if (isset($_POST['getTaskUser'])) {
		$inst->getTaskUser($_POST['user']);
	}

	if (isset($_POST['getTaskUserAdd'])) {
		$inst->getTaskUserAdd($_POST['task_name'], $_POST['task_description'], $_POST['task_status'], $_POST['user_id'] );
	}

	


?>