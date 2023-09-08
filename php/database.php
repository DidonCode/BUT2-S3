<?php
	$address = "127.0.0.1";
	$username = "root";
	$password = "";
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