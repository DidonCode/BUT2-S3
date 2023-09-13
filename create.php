<?php

include_once('php/session.php');
include_once('php/function.php');
require("php/database.php");



if(isset($_POST['send'])){
	$uploaddir = 'images/post/';
	$uploadFile = $uploaddir . basename($_FILES['post-content']['name']);


	if(file_exists('name_file_upload.txt'))
	    $name = (int) file_get_contents('name_file_upload.txt');
	else
    $name = 1;

	if(isset($_FILES['post-content']) && $_FILES['post-content']['error'] == 0){
		if($_FILES['post-content']['size'] <= 4000000){
			$fileInfo = pathinfo($_FILES['post-content']['name']);
			$extension = $fileInfo['extension'];
			$allowedExtensions = ['jpg', 'png', 'gif','jpeg','mp4'];
			echo "test3";
			if($extension == 'jpg' || $extension == 'png' || $extension == 'gif'){
				$contentTypeFile = "image";
				echo "test1";
			}
			else if($extension == "mp4") {
				$contentTypeFile = "video";
				echo "test2";
			}

			if(in_array($extension, $allowedExtensions)){
				move_uploaded_file($_FILES['post-content']['tmp_name'], $uploaddir . $name.$extension );
				file_put_contents('name_file_upload.txt', (int) $name+1);
			}
		}
		var_dump($_FILES['post-content']);
	}

	$spotPost = $_POST['post-spot'];
	$contentPost = $uploadFile;
	$contentTypePost = $contentTypeFile;
	$descriptionPost = $_POST['post-description'];
	$statComment = $_POST['enableComment'];

	if($statComment =="on"){
		$statComment = 1;
	}
	else{
		$statComment = 0;
	}
	

	$requete = $pdo->prepare("INSERT INTO post (id, publisher, spot, content, contentType, description, date, enableComment) VALUES ('0', ?, ?, ?, ?, ?, ?, ?)");
	$requete->execute(array($_SESSION['id'], $spotPost, $contentPost, $contentTypePost, $descriptionPost, getActuallyDate(), $statComment));
}

?> 

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/create.css">
		<link rel="stylesheet" type="text/css" href="css/side-bar.css">
	</head>

	<body>
		<div class="main-container">
			<?php
				include_once('php/side-bar.php');
			?>

			<div class="container">
				<form method="POST" enctype="multipart/form-data" style="position: relative; z-index: 1;">
					<div class="upload-post">
						<input type="file" name="post-content" class="post-content" accept="image/png, image/jpg, image/jpeg, image/gif, video/mp4">
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
						<input type="text" name="post-spot" placeholder="Le lieu..." class="post-spot">
						<div style="display: inline-flex; padding: 20px 0px 20px 0px;">
							<label class="switch">
								<input name="enableComment" type="checkbox" checked>
								<span class="slider round"></span>
							</label>
							<p>Activer les commentaires</p>
						</div>
						<textarea name="post-description" placeholder="Une petite description..." class="post-description"></textarea>
						<div style="text-align: center;">
							<input type="submit" name="send" value="Publier" class="post-publish">
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>

<script src="js/side-bar.js"></script>

<script>
	var effectStrength = 50;
	var effectType = "";

	function changeEffectStrength(element){
		effectStrength = element.value;
		setModification();
	}

	function changeEffectType(type){
		effectType = type;
		setModification();
	}

	function setModification(){
		if(effectType !== ""){
			var preview = document.getElementsByClassName("effect-preview")[0];
			preview.style.filter = effectType + "(" + effectStrength + "%)";
		}
	}

	const effectPost = document.getElementsByClassName('effect-post')[0];
	const effectVideo = document.getElementsByClassName('effect-video')[0];
	const informationPost = document.getElementsByClassName('information-post')[0];
    const inputFile = document.getElementsByClassName('post-content')[0];
    const imagesPreview = document.getElementsByClassName('effect-preview-select');
    const effectPreview = document.getElementsByClassName('effect-preview');

	inputFile.addEventListener('change', function() {
		const selectedFile = inputFile.files[0];
		
		if(selectedFile){
			const url = URL.createObjectURL(selectedFile);

			if(selectedFile.name.match(/\.(png|jpeg|jpg|gif)$/i)) {
				effectVideo.style.display = "none";
				effectPost.style.display = "block";
				effectPost.style.animation = "appear 0.8s linear";
				setTimeout(() => {
					informationPost.style.animation = "appear 0.8s linear";
					informationPost.style.display = "block";
				}, 800);
				for(let i = 0; i < imagesPreview.length; i++){
					imagesPreview[i].getElementsByTagName("img")[0].src = url;
				}
				effectPreview[0].src = url;
				effectPreview[1].src = "#";
			}

			if(selectedFile.name.match(/\.(mp4|)$/i)) {
				effectVideo.style.display = "block";
				effectPost.style.display = "none";
				informationPost.style.animation = "appear 0.8s linear";
				informationPost.style.display = "block";
				for(let i = 0; i < imagesPreview.length; i++){
					imagesPreview[i].getElementsByTagName("img")[0].src = "#";
				}
				effectPreview[0].src = "#";
				effectPreview[1].src = url;
			}
		}
	});
</script>