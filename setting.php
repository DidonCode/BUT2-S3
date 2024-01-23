<!DOCTYPE html>
<html>
	<head>
		<title>Modifier le profil • Nexia</title>
		<meta charset="UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/icon.ico">
		<link rel="stylesheet" type="text/css" href="css/side-bar.css">
		<link rel="stylesheet" type="text/css" href="css/setting.css">
	</head>

    <?php

        try{
            require_once("php/database.php");
            include_once("php/session.php");
            include_once("php/function.php");

            checkSession();

            if(isset($_POST['account-profile'])){

            	if(isset($_FILES['profile']) AND !empty($_FILES['profile']['name'])) {
					$sizeMax = 50000000; //50mo
					$validateExtension = array('jpg', 'jpeg', 'png');

					if($_FILES['profile']['size'] <= $sizeMax) {
						$uploadedExtension = strtolower(pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION));

						if(in_array($uploadedExtension, $validateExtension)) {
							$filePath = "images/profile/".$_SESSION['id'].".".$uploadedExtension;

							move_uploaded_file($_FILES['profile']['tmp_name'], $filePath);

							if(file_exists($filePath)) {
								unlink($_SESSION['profile']);

								$requete = $pdo->prepare("UPDATE account SET profile = ? WHERE id = ?");
								$requete->execute(array($filePath, $_SESSION['id']));

								reloadSession();

								header("Location: setting.php");
							}else{
								$accountProfile = "Erreur durant l'importation de votre image";
							}
						}else{
							$accountProfile = "Votre fichier doit être au format jpg, jpeg png";
						}
					}else{
						$accountProfile = "Votre ".$contentTypeFile." ne doit pas dépasser 50Mo";
					}
				}else{
					$accountProfile = "Veuillez insérer une image";
				}
            }

            if(isset($_POST['account-information'])){
            	$pseudo = $_POST['pseudo'];
            	$fullName = $_POST['fullName'];
            	$bio = $_POST['bio'];

            	if(isset($pseudo, $fullName, $bio) && !empty($pseudo) && !empty($fullName)) {
            		
	        		if(!inLength($pseudo, 255)) { $accountInformation = "Le champ pseudo est trop long"; }
	        		if(!inLength($fullName, 255)) { $accountInformation = "Le champ nom est trop long"; }
	    			if(!inLength($bio, 255)) { $accountInformation = "Le champ bio est trop long"; }

    				if(!isset($accountInformation)){
	            		$requete = $pdo->prepare("UPDATE account SET pseudo = ?, fullName = ?, bio = ? WHERE id = ?");
	            		$requete->execute(array($pseudo, $fullName, $bio, $_SESSION['id']));
	   
	            		reloadSession();

	            		header("Location: setting.php");
	            	}
            	}
            }

            if(isset($_POST['account-password'])){
            	$password = $_POST['password'];

            	if(isset($password) && !empty($password)){

            		if(!inLength($password, 255)) { $accountPassword = "Le champ mot de passe est trop long"; }

    				if(isset($accountPassword)){

	            		$password = password_hash($password, PASSWORD_DEFAULT);

	            		$requete = $pdo->prepare("UPDATE account SET password = ? WHERE id = ?");
	            		$requete->execute(array($password, $_SESSION['id']));

	            		header("Location: setting.php");
	            	}
            	}
            }

            if(isset($_POST['account-confidentiality'])){
            	$postVisibility = $_POST['post-visibility'];
            	$likeVisibility = $_POST['like-visibility'];
				var_dump($postVisibility);
            	if(isset($postVisibility) && $postVisibility >= 0 && $postVisibility <= 1 && $postVisibility != $_SESSION['privatePost']){
            		$requete = $pdo->prepare("UPDATE account SET privatePost = ? WHERE id = ?");
            		$requete->execute(array($postVisibility, $_SESSION['id']));
            	}

            	if(isset($likeVisibility) && $likeVisibility >= 0 && $likeVisibility <= 1 && $likeVisibility != $_SESSION['privateLike']){
					$requete = $pdo->prepare("UPDATE account SET privateLike = ? WHERE id = ?");
            		$requete->execute(array($likeVisibility, $_SESSION['id']));
            	}

            	reloadSession();

            	header("Location: setting.php");
            }

            if(isset($_POST['account-deleting'])){
            	deleteAccount($_SESSION['id']);
            	header('Location: php/session.php?disconnect=1');
            }
    ?>

	<body>
		<div class="main-container">
			<?php
				include_once('php/side-bar.php');
			?>
		<div class="container">
			<div class="settings-panel">
				<div class="settings-header">
					<h2>PHOTO DE PROFIL</h2>
				</div>
				<div class="settings-content">
					<div class="settings-profile-section">
						<form method="POST" enctype="multipart/form-data">
							<div class="settings-profile-image">
								<input type="file" id="settings-profile-image-upload" name="profile" accept="image/png, image/jpg, image/jpeg">
								<div>
									<?php
										echo '<img id="settings-profile-image-preview" src="'.$_SESSION['profile'].'" alt="">';
									?>
									<span>Cliquez pour changer</span>
								</div>

							</div>
							<br>
							<?php
								if(isset($accountProfile)){
									echo '<p style="color: red">'.$accountProfile.'</p>';
								}
							?>
							
							<input type="submit" class="settings-apply-btn" name="account-profile" value="Enregistrer la sélection"/>
						</form>
					</div>
				</div>
			</div>

			<div class="settings-panel">
				<div class="settings-header">
					<h2>INFORMATIONS</h2>
				</div>
				<div class="settings-content">
					<div class="settings-info-section">
						<h3>Modifier les informations</h3>

						<form method="POST">
							<div class="settings-form-group settings-change-input">
								<?php
									echo '<input type="input" class="settings-form-field" maxlength="255" autocomplete="off" name="pseudo" id="newPseudo" value="'.$_SESSION['pseudo'].'" require_onced />';
								?>
								<label for="newPseudo" class="settings-form-label">Nouveau pseudo</label>
							</div>

							<div class="settings-form-group settings-change-input">
								<?php
									echo '<input type="input" class="settings-form-field" maxlength="255" autocomplete="off" name="fullName" id="newName" value="'.$_SESSION['fullName'].'" require_onced />';
								?>
								<label for="newName" class="settings-form-label">Nouveau nom</label>
							</div>

							<div class="settings-form-group settings-change-input">
								<?php
									echo '<textarea class="settings-form-field" maxlength="255" autocomplete="off" name="bio" id="newBio" require_onced>'.$_SESSION['bio'].'</textarea>';
								?>
								<label for="newBio" class="settings-form-label">Nouvelle bio</label>
							</div>

							<?php
								if(isset($accountInformation)){
									echo '<p style="color: red">'.$accountInformation.'</p>';
								}
							?>

							<input type="submit" class="settings-apply-btn" name="account-information" value="Enregistrer la sélection"/>
						</form>
					</div>
				</div>
			</div>

			<div class="settings-panel">
				<div class="settings-header">
					<h2>SÉCURITÉ</h2>
				</div>
				<div class="settings-content">
					<div class="settings-info-section">
						<form method="POST">
							<div class="settings-form-group settings-change-input">
								<input type="password" class="settings-form-field" placeholder="" autocomplete="new-password" name="password" id="newPassword" require_onced />
								<label for="newPassword" class="settings-form-label">Nouveau mot de passe</label>
							</div>

<!-- 							<ul>
								<li id="account-password-checker-uppercase">1 majuscule minimum</li>
								<li id="account-password-checker-number">1 chiffre minimum</li>
								<li id="account-password-checker-length">10 caractère minimum</li>
								<li id="account-password-checker-special_character">1 caractère spécial minimum</li>
							</ul> -->

							<?php
								if(isset($accountPassword)){
									echo '<p style="color: red">'.$accountPassword.'</p>';
								}
							?>

							<input type="submit" class="settings-apply-btn" name="account-password" value="Enregistrer la sélection"/>
						</form>
					</div>
				</div>
			</div>

			<div class="settings-panel">
				<div class="settings-header">
					<h2>CONFIDENTIALITÉ</h2>
				</div>
				<div class="settings-content">
					<div class="settings-info-section">
						<form method="POST">
							<div class="settings-visibilityAccount">
                                <h3>Visibilité du contenue</h3>
                                <div class="settings-visibility">
                                    <p>Visibilité des publications: </p>
                                    <select class="settings-selectbox" name="post-visibility">
                                        <option value="0" <?php if($_SESSION['privatePost'] == 0) echo "selected"; ?>>Public</option>
                                        <option value="1" <?php if($_SESSION['privatePost'] == 1) echo "selected"; ?>>Privée</option>
                                    </select>
                                </div>

                                <div class="settings-visibility">
                                    <p>Visibilité du contenue aimé: </p>
                                    <select class="settings-selectbox" name="like-visibility">
                                        <option value="0" <?php if($_SESSION['privateLike'] == 0) echo "selected"; ?>>Public</option>
                                        <option value="1" <?php if($_SESSION['privateLike'] == 1) echo "selected"; ?>>Privée</option>
                                    </select>
                                </div>
                            </div>

                            <div class="settings-deleteAccount">
                            	<h3>Suppression du compte</h3>
                            	<div>
                            		<input type="submit" class="setting-deleting-account"  name="account-deleting" value="Supprimer le compte"/>
                            	</div>
                            </div>

							<div class="settings-blockedAccounts">
								<h3>Comptes bloqués</h3>
								<div>
									<?php
										$requete = $pdo->prepare("SELECT account FROM account_block WHERE reporter = ?");
										$requete->execute(array($_SESSION['id']));
										$blockData = $requete->fetchAll();

										if(count($blockData) > 0){
											for($i = 0; $i < count($blockData); $i++){
												$requete = $pdo->prepare("SELECT profile, pseudo FROM account WHERE id = ?");
												$requete->execute(array($blockData[$i]['account']));
												$accountBlock = $requete->fetchAll();

												echo '
													<div class="setting-account-block">
														<div class="setting-account-block-information">
															<a href="profile.php?profile='.$accountBlock[$i]['pseudo'].'" class="setting-account-block-link">
																<img src="'.$accountBlock[$i]['profile'].'" class="setting-account-block-profile">
																<p class="setting-account-block-name">'.$accountBlock[$i]['pseudo'].'</p>
															</a>
														</div>
														<div class="setting-account-block-action">
															<svg viewBox="0 0 490 490" name="'.$accountBlock[$i]['pseudo'].'" class="settings-account-block">
																<polygon points="456.851,0 245,212.564 33.149,0 0.708,32.337 212.669,245.004 0.708,457.678 33.149,490 245,277.443 456.851,490   489.292,457.678 277.331,245.004 489.292,32.337 "/>
															</svg>
														</div>
													</div>
												';
											}
										}
										else{
											echo '<p>Aucun compte bloqué pour le moment.</p>';
										}
									?>
								</div>
							</div>
							<input type="submit" class="settings-apply-btn" name="account-confidentiality" value="Enregistrer la sélection"/>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<?php
    } catch(Exception $e) {
        $error = $e->getMessage();
        include_once("php/error400.php");
    }
?>

<script src="js/side-bar.js"></script>
<script src="js/setting.js"></script>