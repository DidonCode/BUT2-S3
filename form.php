<?php
	
	include_once("php/session.php");
	require("php/database.php");

	if(isset($_POST['signin'])){
		$email = $_POST['email'];
		$pseudo = $_POST['pseudo'];
		$fullName = $_POST['fullName'];
		$password = $_POST['password'];

		$requete = $pdo->prepare("SELECT * FROM account WHERE email = ?");
		$requete->execute(array($email));

		$emailCount = $requete->rowCount();

		if($emailCount == 0){

			$requete = $pdo->prepare("SELECT * FROM account WHERE pseudo = ?");
			$requete->execute(array($pseudo));

			$pseudoCount = $requete->rowCount();

			if($pseudoCount == 0){

				$requete = $pdo->prepare("INSERT INTO account (id, email, password, pseudo, fullName, grade, profil) VALUES ('0', ?, ?, ?, ?; '0', 'images/profil/profil-instahess.png')");
				$requete->execute(array($email, $password, $pseudo, $fullName));

				$requete = $pdo->prepare("SELECT * FROM account WHERE email = ? AND password = ?");
				$requete->execute(array($email, $password));

				$userData = $requete->fetchAll();

				create($userData[0]);
			}else{
				$signinError = "Désolé ce nom d'utilisateur est deja pris !";
			}

		}else{
			$signinError = "Désolé cet email est deja pris !";
		}
	}

	if(isset($_POST['signup'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		if(strpos($email, "@") !== false){
			$requete = $pdo->prepare("SELECT * FROM account WHERE email = ? AND password = ?");
		}else{
			$requete = $pdo->prepare("SELECT * FROM account WHERE pseudo = ? AND password = ?");
		}

		$requete->execute(array($email, $password));

		$userCount = $requete->rowCount();

		if($userCount == 1){
			$userData = $requete->fetchAll();

			create($userData[0]);
		}else{
			if($userCount == 0){
				$signupError = "Mauvais identifiant ou mot de passe !";
			}
		}
	}

?>

<!DOCTYPE html>
<html style="height: 100%">
	<head>
		<title>InstaHess-Connexion</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/form.css">
	</head>

	<body style="height: 100%;">
		<div class="background-login"></div>
		<div class="logo">
			<h1 class="logo-title">InstaHess</h1>
		</div>
		<div class="container" id="container">
			<div class="form-container sign-up-container">
				<form method="POST">
					<h1>Creez votre compte</h1>
					<span>Seulement si vous n'avez pas de compte</span>
					<input type="email" name="email" placeholder="Email" required />
					<input type="text" name="pseudo" placeholder="Nom d'utilisateur" required />
					<input type="text" name="fullName" placeholder="Nom" required />
					<input type="password" name="password" placeholder="Password" required />
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
					<input type="text" name="email" placeholder="Email" required />
					<input type="password" name="password" placeholder="Password" required />
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

		<script src="js/connexion.js"></script>
	</body>
</html>