<?php
	$address = "localhost";
	$username = "root";
	$password = "root";
	$database = "insta_hess";

	try {
		$pdo = new PDO("mysql:host=".$address.";dbname=".$database, $username, $password);
		return $pdo;
	}catch(Exception $e) {
		//die('Erreur : '.$e->getMessage());
		echo $e->getMessage();
		//header("Location: error.php");
	}
?>