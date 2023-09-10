<?php

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/profil.css">
		<link rel="stylesheet" href="../css/colors.css">
	</head>

	<body>
		<div class="main-container">
			<?php 
				include_once("../php/side-bar.php");
			?>

			<div class="container">
				<div class="settings">
					<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/></svg>
				</div>
				<section class="bio">
					<div class="photo-profil">
						<img src="../images/profil/profil-instahess.png" alt="photo-profil">
					</div>
					<div class="profil-info">
						<ul class="informations"><p class="username">Mango_Manga</p>
							<p>Post</p>
							<p>Followers</p>
							<p>Suivi</p>
						</ul>
						<button class="follow">Follow</button>
					</div>
					<div class="texte-bio">
						<p>Ceci est une bio de profil</p>
					</div>
				</div>
			</section>
		</div>



		<script src="https://kit.fontawesome.com/bd843d384a.js" crossorigin="anonymous"></script>
	</body>
</html>