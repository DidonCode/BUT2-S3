<?php
	session_start();
	require("../php/database.php");

	if(isset($_POST['signin'])){
		$email = $_POST['email'];
		$pseudo = $_POST['pseudo'];
		$password = $_POST['password'];

		$query = $pdo->prepare("SELECT * FROM account WHERE email = ?");
		$query->execute(array($email));

		$emailCount = $query->rowCount();

		if($emailCount == 0){

			$query = $pdo->prepare("SELECT * FROM account WHERE pseudo = ?");
			$query->execute(array($pseudo));

			$pseudoCount = $query->rowCount();

			if($pseudoCount == 0){

				$query = $pdo->prepare("INSERT INTO account (id, email, password, pseudo) VALUES ('0', ?, ?, ?)");
				$query->execute(array($email, $password, $pseudo));

				header("Location: dashboard.php");
			}else{
				$signinError = "Désolé ce nom d'utilisateur est deja pris !";
			}

		}else{
			$signinError = "Désolé cette email est deja prise !";
		}
	}

	if(isset($_POST['signup'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		if(strpos($email, "@") !== false){
			$query = $pdo->prepare("SELECT * FROM account WHERE email = ? AND password = ?");
		}else{
			$query = $pdo->prepare("SELECT * FROM account WHERE pseudo = ? AND password = ?");
		}

		$query->execute(array($email, $password));

		$userCount = $query->rowCount();

		if($userCount == 1){
			$userData = $query->fetchAll();

			$_SESSION['id'] = $userData['id'];
			$_SESSION['email'] = $userData['email'];
			$_SESSION['password'] = $userData['password'];
			$_SESSION['pseudo'] = $userData['pseudo'];

			header("Location: dashboard.php");
		}else{
			if($userCount == 0){
				$signupError = "Mauvais identifiant ou mot de passe !";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>InstaHess-Connexion</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/connexion.css">
	</head>

	<body>
		<div class="logo"><img src="../images/InstaHess.png" alt="logo"></div>
		<div class="container" id="container">
			<div class="form-container sign-up-container">
				<form method="POST">
					<h1>Creez votre compte</h1>
					<span>Seulement si vous n'avez pas de compte</span>
					<input type="email" name="email" placeholder="Email" />
					<input type="text" name="pseudo" placeholder="Nom d'utilisateur" />
					<input type="password" name="password" placeholder="Password" />
					<input type="submit" name="signin" value="S'inscrire"></input>
					<?php
						if(isset($signinError)){
							echo "<p style='color: red'>".$signinError."</p>";
						}
					?>
				</form>
			</div>
			<div class="form-container sign-in-container">
				<form method="POST">
					<h1>Connexion</h1>
					<span>Si vous avez déjà un compte</span>
					<input type="text" name="email" placeholder="Email" />
					<input type="password" name="password" placeholder="Password" />
					<a href="#">Mot de passe oublié ?</a>
					<input type="submit" name="signup" value="Connexion"></input>
					<?php
						if(isset($signupError)){
							echo "<p style='color: red'>".$signupError."</p>";
						}
					?>
				</form>
			</div>
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-left">
						<h1>De retour parmis nous ?</h1>
						<p>Vous pouvez vous reconnectez à votre compte juste ici</p>
						<button class="ghost" id="signIn">Connexion</button>
					</div>
					<div class="overlay-panel overlay-right">
						<h1>Oh une nouvelle tête !</h1>
						<p>Tu n'as pas de compte ? Inscris toi et rejoins tes amis sur InstaHess</p>
						<button class="ghost" id="signUp">S'inscrire</button>
					</div>
				</div>
			</div>
		</div>
		
		<footer>
			<p>
				Crée par Richard / Théo / Tahar / Killian
				- Projet InstaHess BUT Informatique Nevers 2023
			</p>
		</footer>

		<script src="../js/connexion.js"></script>
	</body>
</html>