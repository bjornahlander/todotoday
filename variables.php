<?php  
	//Database
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', 'root');
	define('DB_NAME', 'todotoday');

	//Facebook
	$appId = '1557477271168573';
	$appSecret = '4f473f50796197ebbc4d1345840934f0';
	$redirectUrl = 'http://localhost/'; 
	$scope = "public_profile, email";
	
	include_once "Utilities.php";
?>