<div class="notification-container">
	<h2 class="side-bar-notification-title">Notifications</h2>
	<hr style="border: 0.1px solid var(--border-color); margin-top: 20px; margin-bottom: 20px;">
	<div class="notification-result">
		<?php
			if(validSession()){
				$requete = $pdo->prepare("SELECT * FROM notification WHERE notified = ?");
				$requete->execute(array($_SESSION['id']));

				$notificationData = $requete->fetchAll();
				
				if(count($notificationData) > 0){
					for($i = 0; $i < count($notificationData); $i++){
						echo '<div class="notification-account" name="'.$notificationData[$i]['id'].'">';
						echo generateNotification($notificationData[$i]['id'], $notificationData[$i]['notified'], $notificationData[$i]['notifier'], $notificationData[$i]['type'], $notificationData[$i]['post'], $notificationData[$i]['comment'], $notificationData[$i]['view']);
						echo'</div>';
					}
				}else{
					echo '<p class="notification-error">Vous avez aucune notification</p>';
				}
			}else{
				echo '<p class="notification-error">Vous devez vous connecter</p>';
			}
		?>
	</div>
</div>

<?php
	if(validSession()){
		echo '<script src="js/notification.js"></script>';
	}
?>