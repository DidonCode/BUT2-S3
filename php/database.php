<?php
	$address = "localhost";
	$username = "root";
	$password = "Mypas$4Srv+";
	$database = "insta_hess_beta";

	try {
		$pdo = new PDO("mysql:host=".$address.";dbname=".$database, $username, $password);
		return $pdo;
	}catch(Exception $e) {
		throw new Exception("Database connection failed.");
	}
?>