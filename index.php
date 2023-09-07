<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/index.css">
	</head>

	<body>
		<div class="main-container">
			<?php 
				include_once("php/side-bar.php");
			?>

			<div class="container">
				<?php
					include("php/post.php");
				?>
			</div>
		</div>
	</body>
</html>