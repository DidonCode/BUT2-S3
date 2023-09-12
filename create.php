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
				<form method="" enctype="multipart/form-data" style="position: relative; z-index: 1;">
					<div class="upload-post">
						<input type="file" name="post-content" class="post-content" accept="image/png, image/jpg, image/jpeg, image/gif, video/mp4">
					</div>

					<div class="effect-post">
						<img src="" class="effect-preview">
						<button class="effect-preview-select" onclick="changeEffectType('grayscale'); return false;">
							<img src="" style="filter: grayscale(50%);">
						</button>

						<button class="effect-preview-select" onclick="changeEffectType('invert'); return false;">
							<img src="" style="filter: invert(50%);">
						</button>

						<button class="effect-preview-select" onclick="changeEffectType('sepia'); return false;">
							<img src="" style="filter: sepia(50%);">
						</button>

						<button class="effect-preview-select" onclick="changeEffectType('saturate'); return false;">
							<img src="" style="filter: saturate(50%);">
						</button>

						<input type="range" name="" min="0" max="100" onmousemove="changeEffectStrength(this)">
					</div>

					<div class="information-post">
						<input type="text" name="post-spot" placeholder="Le lieu...">
						<textarea name="post-description" placeholder="Une petite description..."></textarea>
						<input type="submit" name="send" value="Publier">
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
    const inputFile = document.getElementsByClassName('post-content')[0];
    const imagesPreview = document.getElementsByClassName('effect-preview-select');
    const imagePreview = document.getElementsByClassName('effect-preview')[0];

	inputFile.addEventListener('change', function() {
		const selectedFile = inputFile.files[0];
		if (selectedFile && !selectedFile.name.match(/\.(mp4|)$/i)) {
			const imageURL = URL.createObjectURL(selectedFile);
			effectPost.style.display = "block";
			for(let i = 0; i < imagesPreview.length; i++){
				imagesPreview[i].getElementsByTagName("img")[0].src = imageURL;
			}
			imagePreview.src = imageURL;
		} else {
			effectPost.style.display = "none";
			for(let i = 0; i < imagesPreview.length; i++){
				imagesPreview[i].getElementsByTagName("img")[0].src = "#";
			}
			imagePreview.src = "#";
		}
	});
</script>