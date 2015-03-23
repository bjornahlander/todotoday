<?php
	session_start(); 
	require_once "variables.php";
	

	error_reporting(E_ALL);
	ini_set("display_errors", 1);		
						

	try {
		$db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
	} catch(PDOException $e) {
		echo 'Connection faild: '.$e->getMessage();
		exit;
	}

	
?>