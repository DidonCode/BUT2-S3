<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/icon.ico">
		<link rel="stylesheet" type="text/css" href="css/post.css">
		<link rel="stylesheet" type="text/css" href="css/popup.css">
		<link rel="stylesheet" type="text/css" href="css/side-bar.css">
		<style>
			body{
				background-color: var(--background-color);
			}

			.main-container{
				display: flex;
				flex-direction: row;
				min-height: 100%;
			}

			.container {
				padding: 0 5%;
				margin: 0 auto;
				width: 100%;
				max-width: 1240px;
				user-select: none;
			}

			.post-popup-background{
				position: relative;
				display: block;
				z-index: 0;
				background-color: transparent;
				height: calc(100% - 40px);
			}

			.post-popup{
				height: 100%;
			}
		</style>
	</head>

	<?php
		try{
			require_once("php/database.php");
			include_once("php/session.php");
			include_once("php/function.php");
			include_once("php/post-function.php");
	?>

	<body>
		<div class="main-container">
			<?php
				include_once("php/side-bar.php");
			?>
			<div class="container">
				<?php
					if(isset($_GET['post']) && !empty($_GET['post'])){
						$requete = $pdo->prepare("SELECT * FROM post WHERE id = ?");
						$requete->execute(array($_GET['post']));
				
						$postCount = $requete->rowCount();
				
						if($postCount >= 1){

							$postData = $requete->fetchAll();
							$allPostData = getAllPostData($postData[0]);

							if(!empty($postData[0]['description'])){
								echo '<title>'.$postData[0]['description'].'. | Nexia</title>';
							}else{
								echo '<title>Nexia</title>';
							}

							echo printPostPopup($allPostData[0], $allPostData[1], $allPostData[2], $allPostData[3]);
						}else{
							include_once("php/error404.php");
						}
					}else{
						checkSession();
						header("Location: index.php");
					}
				?>
		</div>
	</body>
</html>

<?php
    } catch(Exception $e) {
        $error = $e->getMessage();
        include_once("php/error400.php");
    }
?>

<script src="js/post.js"></script>
<script src="js/side-bar.js"></script>