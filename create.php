<!DOCTYPE html>
<html>
	<head>
		<title>Crée une publication • Nexia</title>
		<meta charset="utf-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/icon.ico">
		<link rel="stylesheet" type="text/css" href="css/create.css">
		<link rel="stylesheet" type="text/css" href="css/side-bar.css">
	</head>

	<?php

		try{
			require_once("php/database.php");
			include_once("php/session.php");
			include_once("php/function.php");
			
			checkSession();

			if(isset($_POST['send'])){
				$postSpot = $_POST['post-spot'];
				$postDescription = $_POST['post-description'];

				if(!inLength($postSpot, 255)) { $error = "Le champ lieu est trop long"; }
				if(!inLength($postDescription, 255)) { $error = "Le champ description est trop long"; }

				if(isset($_POST['post-enableComment'])){
					$postEnableComment = 1;
				}else{
					$postEnableComment = 0;
				}
				$contentTypeFile = "image";
				
				if(isset($_FILES['post-content']) AND !empty($_FILES['post-content']['name'])) {
					$sizeMax = 50000000; //50mo
					$validateExtension = array('jpg', 'jpeg', 'png', 'gif', 'mp4');

					if($_FILES['post-content']['size'] <= $sizeMax) {
						$uploadedExtension = strtolower(pathinfo($_FILES['post-content']['name'], PATHINFO_EXTENSION));

						if($uploadedExtension == "mp4") {
							$contentTypeFile = "video";
						}

						if(in_array($uploadedExtension, $validateExtension)) {
							$requete = $pdo->prepare("SELECT id FROM post ORDER BY id DESC LIMIT 1");
							$requete->execute();
							$postCount = $requete->fetchAll();

							$filePath = "images/post/".($postCount[0][0] + 1).".".$uploadedExtension;

							if($uploadedExtension != "mp4" && $uploadedExtension != "gif"){
								$imageData = $_POST['post-imageData'];
								$imageData = str_replace('data:image/png;base64,', '', $imageData);
								$imageData = base64_decode($imageData);
			
								$image = imagecreatefromstring($imageData);
								
								imagepng($image, $filePath);
								imagedestroy($image);
							}
							else{
								move_uploaded_file($_FILES['post-content']['tmp_name'], $filePath);
							}

							if(file_exists($filePath)) {
								$requete = $pdo->prepare("INSERT INTO post (id, publisher, spot, content, contentType, description, date, enableComment) VALUES ('0', ?, ?, ?, ?, ?, ?, ?)");
								$requete->execute(array($_SESSION['id'], $postSpot, $filePath, $contentTypeFile, $postDescription, getActuallyDate(), $postEnableComment));

								$requete = $pdo->prepare("SELECT id FROM post WHERE publisher = ? AND content = ?");
								$requete->execute(array($_SESSION['id'], $filePath));

								$postId = $requete->fetchAll();

								if(count($postId)){
									header("Location: post.php?post=".$postId[0]['id']);
								}
							}else{
								$error = "Erreur durant l'importation de votre ".$contentTypeFile." ".$filePath." ".$_FILES['post-content']['tmp_name'];
							}
						}else{
							$error = "Votre fichier doit être au format jpg, jpeg, png, gif, mp4";
						}
					}else{
						$error = "Votre ".$contentTypeFile." ne doit pas dépasser 50Mo";
					}
				}else{
					$error = "Veuillez insérer une image ou une vidéo";
				}
			}
	?> 

	<body>
		<div class="main-container">
			<?php
				include_once('php/side-bar.php');
			?>

			<div class="container">
				<form method="POST" enctype="multipart/form-data" style="position: relative; z-index: 1;">
					<div class="upload-post">
						<input type="file" name="post-content" class="post-content" accept="image/png, image/jpg, image/jpeg, image/gif, video/mp4" require>
                        <label for="file" class="open-post-content">
                            <svg viewBox="0 0 512 512" class="post-content-icon">
                                <path d="M288 109.3V352c0 17.7-14.3 32-32 32s-32-14.3-32-32V109.3l-73.4 73.4c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l128-128c12.5-12.5 32.8-12.5 45.3 0l128 128c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L288 109.3zM64 352H192c0 35.3 28.7 64 64 64s64-28.7 64-64H448c35.3 0 64 28.7 64 64v32c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V416c0-35.3 28.7-64 64-64zM432 456a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/>
                            </svg>
                            Cliquer pour choisir un fichier
                        </label>
						<input type="hidden" name="post-imageData" id="imageData">
						<?php
							if(isset($error)){
								echo '<p style="color: red">'.$error.'</p>';
							}
						?>
					</div>

					<div class="effect-post">
						<img src="" class="effect-preview">
						<div class="effect-preview-menu">
							<button class="effect-preview-select" onclick="changeEffectType('grayscale'); return false;">
								<img src="" style="filter: grayscale(100%);">
							</button>

							<button class="effect-preview-select" onclick="changeEffectType('invert'); return false;">
								<img src="" style="filter: invert(100%);">
							</button>

							<button class="effect-preview-select" onclick="changeEffectType('sepia'); return false;">
								<img src="" style="filter: sepia(100%);">
							</button>

							<button class="effect-preview-select" onclick="changeEffectType('saturate'); return false;">
								<img src="" style="filter: saturate(100%);">
							</button>

							<button class="effect-preview-select" onclick="changeEffectType('brightness'); return false;">
								<img src="" style="filter: brightness(50%);">
							</button>

							<button class="effect-preview-select" onclick="changeEffectType('opacity'); return false;">
								<img src="" style="filter: opacity(10%);">
							</button>
						</div>
						<br>
						<input type="range" name="" min="10" max="100" onmousemove="changeEffectStrength(this)" class="effect-control">
					</div>

					<div class="effect-video">
						<video muted autoplay loop class="effect-preview">
						</video>
					</div>

					<div class="information-post">
						<input type="text" name="post-spot" placeholder="Le lieu..." class="post-spot" autocomplete="off" maxlength="255">
						<div style="display: inline-flex; padding: 20px 0px 20px 0px;">
							<label class="switch">
								<input name="post-enableComment" type="checkbox" value="1" checked>
								<span class="slider round"></span>
							</label>
							<p>Activer les commentaires</p>
						</div>
						<textarea name="post-description" placeholder="Une petite description..." class="post-description" autocomplete="off" maxlength="255"></textarea>
						<div style="text-align: center;">
							<input type="submit" name="send" value="Publier" class="post-publish">
						</div>
					</div>
				</form>
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
<script src="js/create.js"></script>