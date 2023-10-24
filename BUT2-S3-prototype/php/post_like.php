<?php

	require('database.php');
	include_once('session.php');

	if(isset($_GET['likes'])){
		$likes = explode(",", $_GET['likes']);

		for($i = 0; $i < count($likes); $i+=2){
			$postLike = $likes[$i + 1]; 
			$postId = $likes[$i];

			$requete = $pdo->prepare("SELECT * FROM post_like WHERE post = ? AND account = ?");
			$requete->execute(array($postId, $_SESSION['id']));
			$exist = $requete->rowCount();
			$existingData = $requete->fetchAll();

			if($exist > 0){
				if($existingData[0]['love'] == $postLike){
					continue;
				}

				$requete = $pdo->prepare("UPDATE post_like SET love = ? WHERE post = ? AND account = ?");
				$requete->execute(array($postLike, $postId, $_SESSION['id']));
			}
			else{
				$requete = $pdo->prepare("INSERT INTO post_like (id, post, account, love) VALUES ('0', ?, ?, ?)");
				$requete->execute(array($postId, $_SESSION['id'], $postLike));
			}
		}

		header("Location: index.php");
	}

?>