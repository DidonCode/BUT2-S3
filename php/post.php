<?php

	require('php/database.php');
	include_once('php/session.php');
	include_once('php/function.php');

	if(count(array_keys($_POST)) == 1){
		$postId = 0;
		$comment = "";
		foreach($_POST as $key => $value) {
			$postId = $key;
			$comment = $value;
			break;
		}

		$_SESSION['postId'] = $postId;

		$requete = $pdo->prepare("INSERT INTO comment (id, post, publisher, message, date) VALUES (0, ?, ?, ?, ?)");
		$requete->execute(array($postId, $_SESSION['id'], $comment, getActuallyDate()));
	}

	function printPost($postData) {
		global $pdo;

		$postId = $postData['id'];
		$postContent = $postData['content'];
		$postType = $postData['contentType'];
		$postDescription = $postData['description'];
		$postSpot = $postData['spot'];
		$postDate = $postData['date'];

		$requete = $pdo->prepare("SELECT pseudo, profil FROM account WHERE id = ?");
		$requete->execute(array($postData['publisher']));
		$accountData = $requete->fetchAll();

		$accountProfil = $accountData[0]['profil'];
		$accountName = $accountData[0]['pseudo'];

		$requete = $pdo->prepare("SELECT * FROM comment WhERE post = ?");
		$requete->execute(array($postData['id']));
		$commentData = $requete->fetchAll();

		if(isset($_SESSION['postId']) && $_SESSION['postId'] == $postId){
			echo '<div class="post" id="open" name="'.$postId.'">';
			$_SESSION['postId'] = 0;
		}
		else{
			echo '<div class="post" name="'.$postId.'">';
		}
		echo '
			<div class="post-header">
				<img src="' . $accountProfil .'" class="post-header-profil">
				<div class="post-header-information">
					<p class="post-publisher">' . $accountName . ' • '. dateDiffActually($postDate).'</p>
					<p class="post-spot">'. $postSpot . '</p>
				</div>
			</div>
			<div class="post-content">';
				if($postType == "image"){
					echo '<img src="' . $postContent . '">';
				}
				else if($postType == "video"){
					echo '<video muted autoplay loop>
							<source src="' . $postContent . '" type="video/mp4"/>
						</video>
					';
				};
		echo'
		</div>
			<div class="post-footer">
				<div class="post-actions">
					<button class="post-action-like">
						<svg height="24" width="24" viewBox="0 0 24 24" class="post-like-style">
							<path d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 	2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 	6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 	45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"/>

						</svg>
						<svg height="24" width="24" viewBox="0 0 48 48" color="rgb(255, 48, 64)" fill="rgb(255, 48, 64)" class="post-like-style">
							<path d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"/>
						</svg>
					</button>';
		echo'
					<button class="post-action-comment">
						<svg height="24" width="24" viewBox="0 0 24 24">
							<path d="M20.656 17.008a9.993 9.993 0 1 0-3.59 3.615L22 22Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2"/>
						</svg>
					</button>
				</div>
				<p class="post-like"><span class="post-like-counter"></span> J\'aime</p>
				<p class="post-description"><span style="font-weight: 600;">' . $accountName . '</span> ' . $postDescription . '</p>
			</div>

			<div class="post-popup-background">
				<div class="post-popup">
					<div class="post-popup-container">
						<div class="post-popup-content">';
							if($postType == "image"){
								echo '<img src="' . $postContent . '">';
							}
							else if($postType == "video"){
								echo '<video muted autoplay loop>
									<source src="' . $postContent . '" type="video/mp4"/>
									</video>
								';
							};
							echo'
						</div>
						<div class="post-popup-comment">
							<div class="post-popup-header">
								<img src="' . $accountProfil .'" class="post-popup-header-profil">
								<div class="post-popup-header-information">
									<p class="post-popup-publisher">' . $accountName . ' • '.dateDiffActually($postDate).'</p>
									<p class="post-popup-spot">'. $postSpot . '</p>
								</div>
							</div>

							<hr style="border: 0.1px solid rgba(0, 0, 0, 0.05); margin-top: 20px; margin-bottom: 20px;">

							<div class="post-popup-comment-container">';

							for($i = 0; $i < count($commentData); $i++){
								$requete = $pdo->prepare("SELECT pseudo, profil FROM account WHERE id = ?");
								$requete->execute(array($commentData[$i]['publisher']));
								$commentAccountData = $requete->fetchAll();

								$commentAccountProfil = $commentAccountData[0]['profil'];
								$commentAccountName = $commentAccountData[0]['pseudo'];

								$commentMessage = $commentData[$i]['message'];
								$commentDate = $commentData[$i]['date'];

								echo'
								<div class="post-popup-comment-header">
									<img src="' . $commentAccountProfil .'" class="post-popup-header-comment-profil">
									<div class="post-popup-comment-header-information">
										<p class="post-popup-comment-publisher">' . $commentAccountName . ' • '.dateDiffActually($commentDate).'</p>
										<p class="post-popup-comment-message">'. $commentMessage . '</p>
									</div>
								</div>';
							}

							echo'
							</div>

							<form method="POST">
								<input type="text" class="post-popup-comment-input" placeholder="Ajouter un commentaire..." name="'.$postId.'"> 
							</form>
						</div>
					</div>
					<button class="post-popup-close">
						<svg height="18" width="18" viewBox="0 0 24 24" color="rgb(255, 255, 255)" fill="rgb(255, 255, 255)">
							<polyline fill="none" points="20.643 3.357 12 12 3.353 20.647" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
							<line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" x1="20.649" x2="3.354" y1="20.649" y2="3.354"/>
						</svg>
					</button>
				</div>
			</div>
		</div>

		<link rel="stylesheet" type="text/css" href="css/post.css">
		<script src="js/post.js"></script>';
	}

	$requete = $pdo->prepare("SELECT * FROM post");
	$requete->execute(array());

	$postData = $requete->fetchAll();

	for($i = 0; $i < count($postData); $i++){
		printPost($postData[$i]);
	}
?>