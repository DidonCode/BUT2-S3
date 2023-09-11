<?php
	session_start();

	function create($userData){
		$_SESSION['id'] = $userData['id'];
		$_SESSION['email'] = $userData['email'];
		$_SESSION['password'] = $userData['password'];
		$_SESSION['pseudo'] = $userData['pseudo'];
		$_SESSION['fullName'] = $userData['fullName'];
		$_SESSION['grade'] = $userData['grade'];
		$_SESSION['profil'] = $userData['profil'];
		header("Location: ../account/profil.php");
	}

	function destroy(){
		session_unset();
		session_destroy();
		header("Location: ../account/form.php");
	}

	function valid(){
		if(isset($_SESSION['id'])){
			return true;
		}
		return false;
	}

	function check(){
		if(!valid()){
			destroy();
		}
	}
?>