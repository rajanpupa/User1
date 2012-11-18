<?php
	
	//session starting should be done early before anything
	session_start();
	
	//including the side wide constants
	include_once('configs/constants.php');
	
	// Database handeling codes, initiating
	try {
		$con_string = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
		$db = new PDO($con_string, DB_USER, DB_PASS);
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
		exit;
	}

?>
