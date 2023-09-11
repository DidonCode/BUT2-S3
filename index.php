<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="stylesheet" type="text/css" href="css/side-bar.css">
	</head>

	<body>
		<div class="main-container">
			<?php 
				include_once("php/side-bar.php");
			?>

			<div class="container">
				<div class="story">
					<div>
						
					</div>
				</div>

				<?php
					include("php/post.php");
				?>
			</div>

			<?php
				include("php/follower-bar.php");
			?>
		</div>
	</body>
</html>

<script src="js/side-bar.js"></script>