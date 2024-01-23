	<?php
	require_once("database.php");
	include_once("session.php");

	$LIMIT = 5;

	$requete = $pdo->prepare("SELECT followed FROM follow WHERE follower = ? LIMIT ".$LIMIT);
	$requete->execute(array($_SESSION['id']));
	$followerData = $requete->fetchAll();

	for($i = 0; $i < count($followerData); $i++){
		$requete = $pdo->prepare("SELECT id, pseudo, fullName, profile FROM account WHERE id = (SELECT followed FROM follow WHERE follower = ? AND follow = 1 LIMIT 1) AND id != ?");
		$requete->execute(array($followerData[$i]['followed'], $_SESSION['id']));
		$followedData = $requete->fetchAll();
	}
?>

<div class="follower-bar">
	<?php echo '<a href="profile.php?profile='.$_SESSION['pseudo'].'" class="follower-header">' ?>
		<?php echo '<img src="'.$_SESSION['profile'].'" class="follower-header-profile">' ?>
		<div class="follower-header-information">
			<p class="follower-publisher"><?php echo $_SESSION['pseudo']; ?></p>
			<p class="follower-fullName"><?php echo $_SESSION['fullName']; ?></p>
		</div>
	</a>

	<?php
		echo '<p class="follower-suggestion">Suggestions pour vous</p>';
		echo '<div class="follower-content">';
		
		if(isset($followedData, $followerData) && count($followedData) > 0 && count($followerData) > 0){
			//$max = $LIMIT;
			//if(count($followedData) < $LIMIT){ $max = count($followedData); }

			for($i = 0; $i < count($followedData); $i++){
				echo '
				<a href="profile.php?profile='.$followedData[$i]['pseudo'].'" class="follower-suggestion-header">
					<img src="'.$followedData[$i]['profile'].'" class="follower-header-profile">
					<div class="follower-header-information">
						<p class="follower-publisher">'.$followedData[$i]['pseudo'].'</p>
						<p class="follower-fullName">'.$followedData[$i]['fullName'].'</p>
					</div>
				</a>
				';
			}
		}else{
			$requete = $pdo->prepare("SELECT followed, COUNT(*) FROM follow WHERE follow = 1 GROUP BY followed ORDER BY COUNT(*) DESC LIMIT ".$LIMIT);
			$requete->execute();

			$popularFollowedData = $requete->fetchAll();

			if(count($popularFollowedData) > 0){

				for($i = 0; $i < count($popularFollowedData); $i++){

					$requete = $pdo->prepare("SELECT id, pseudo, fullName, profile FROM account WHERE id = ? AND id != ?");
					$requete->execute(array($popularFollowedData[$i]['followed'], $_SESSION['id']));

					$popularAccountData = $requete->fetchAll();

					if(count($popularAccountData) > 0){
						echo '
						<a href="profile.php?profile='.$popularAccountData[0]['pseudo'].'" class="follower-suggestion-header">
							<img src="'.$popularAccountData[0]['profile'].'" class="follower-header-profile">
							<div class="follower-header-information">
								<p class="follower-publisher">'.$popularAccountData[0]['pseudo'].'</p>
								<p class="follower-fullName">'.$popularAccountData[0]['fullName'].'</p>
							</div>
						</a>
						';
					}
				}
			}else{
				echo '<p class="follower-error">Aucune suggestion.</p>';
			}
		}
	?>
	</div>
</div>