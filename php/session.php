<?php
	require_once("database.php");
	session_start();

	function setSessionValue($userData){
		if(isset($userData)){
			$_SESSION['id'] = $userData['id'];
			$_SESSION['email'] = $userData['email'];
			$_SESSION['pseudo'] = $userData['pseudo'];
			$_SESSION['fullName'] = $userData['fullName'];
			$_SESSION['bio'] = $userData['bio'];
			$_SESSION['privatePost'] = $userData['privatePost'];
			$_SESSION['privateLike'] = $userData['privateLike'];
			$_SESSION['verified'] = $userData['verified'];
			$_SESSION['admin'] = $userData['admin'];
			$_SESSION['profile'] = $userData['profile'];
		}else{
			throw new Exception("Error on user data");
		}
	}

	function createSession($userData){
		setSessionValue($userData);
		checkSession();
		header("Location: profile.php");
	}

	function reloadSession(){
		global $pdo;

		checkSession();

		$requete = $pdo->prepare("SELECT * FROM account WHERE id = ?");
		$requete->execute(array($_SESSION['id']));
		$userData = $requete->fetchAll();

		setSessionValue($userData[0]);
	}

	function destroySession(){
		session_unset();
		session_destroy();
	}

	function validSession(){
		if(isset($_SESSION['id'])){
			return true;
		}
		return false;
	}

	function checkSession(){
		if(!validSession()){
			echo '<script>localStorage.setItem("validSession", false);</script>';
			destroySession();
			header("Location: form.php");
		}else{
			echo '<script>localStorage.setItem("validSession", true);</script>';
		}
	}

	if(isset($_GET['disconnect']) && !empty($_GET['disconnect']) && $_GET['disconnect'] == 1){
		destroySession();
		header("Location: ../form.php");
	}

	function deleteAccount($accountId){
        global $pdo;

        try{
        	$requete = $pdo->prepare("SELECT id, content FROM post WHERE publisher = ?");
        	$requete->execute(array($_SESSION['id']));
        	$postData = $requete->fetchAll();

        	if(isset($postData)){
	        	for($i = 0; $i < count($postData); $i++){
	        		try {
	        			unlink($postData[$i]['content']);

		                $requete = $pdo->prepare("CALL deletePost(?)");
		                $requete->execute(array($postData[$i]['id']));
		            } catch (PDOException $e) {
		                throw new Exception("Error on deleting post. ".$e->getMessage());
		            }
	        	}
	        }

            try{
            	if($_SESSION['profile'] != "images/default-profile.png"){
	            	unlink($_SESSION['profile']);
	            }

            	try {
	                $requete = $pdo->prepare("CALL deleteAccount(?)");
	                $requete->execute(array($_SESSION['id']));

	                return true;
	            } catch (PDOException $e) {
	                throw new Exception("Error on deleting account data. ".$e->getMessage());
	            }
            }
            catch(PDOException $e){
	            throw new Exception("Error on deleting account file. ".$e->getMessage());
	        }
        }catch(PDOException $e){
            throw new Exception("Error on deleting account. ".$e->getMessage());
        }
    }
?>