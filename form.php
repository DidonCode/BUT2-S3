<!DOCTYPE html>
<html>
	<head>
		<title>Connexion et inscription • Nexia</title>
		<meta charset="utf-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/icon.ico">
		<link rel="stylesheet" type="text/css" href="css/form.css">
	</head>

	<?php
		try{
			require_once("php/database.php");
		    include_once("php/session.php");
		    include_once("php/function.php");

		    if(validSession()){
		        header("Location: index.php");
		    }

		    if(isset($_POST['signin'])){
		        $email = $_POST['email'];
		        $pseudo = $_POST['pseudo'];
		        $fullName = $_POST['fullName'];
		        $password = $_POST['password'];

		        if(isset($email, $pseudo, $fullName, $password) && !empty($email) && !empty($pseudo) && !empty($fullName) && !empty($password)){

		        	if(!inLength($email, 255)) { $signinError = "Le champ email est trop long"; }
			        if(!inLength($pseudo, 255)) { $signinError = "Le champ pseudo est trop long"; }
			        if(!inLength($fullName, 255)) { $signinError = "Le champ nom est trop long"; }
			        if(!inLength($password, 255)) { $signinError = "Le champ mot de passe est trop long"; }
			        
			        $password = password_hash($password, PASSWORD_DEFAULT);

			        $requete = $pdo->prepare("SELECT * FROM account WHERE email = ?");
			        $requete->execute(array($email));

			        $emailCount = $requete->rowCount();

			        if($emailCount == 0){

			            $requete = $pdo->prepare("SELECT * FROM account WHERE pseudo = ?");
			            $requete->execute(array($pseudo));

			            $pseudoCount = $requete->rowCount();

			            if($pseudoCount == 0){

			                $requete = $pdo->prepare("INSERT INTO account (id, email, password, pseudo, fullName, bio, profile) VALUES ('0', ?, ?, ?, ?, '', 'images/default-profile.png')");
			                $requete->execute(array($email, $password, $pseudo, $fullName));

			                $requete = $pdo->prepare("SELECT * FROM account WHERE email = ? AND password = ?");
			                $requete->execute(array($email, $password));

			                $userData = $requete->fetchAll();
			                
			                createSession($userData[0]);
			            }else{
			                $signinError = "Désolé ce nom d'utilisateur est déja pris !";
			            }

			        }else{
			            $signinError = "Désolé cet email est deja pris !";
			        }

		        }else{
		        	$signinError = "Tous les champs ne sont pas remplis !";
		        }
		    }

		    if(isset($_POST['signup'])){
		        $email = $_POST['email'];
		        $password = $_POST['password'];

		        if(isset($email, $password) && !empty($email) && !empty($password)){

			        if(!inLength($email, 255)) { $signupError = "Le champ email est trop long"; }
			        if(!inLength($password, 255)) { $signupError = "Le champ mot de passe est trop long"; }

			        if(filter_var($email, FILTER_VALIDATE_EMAIL) !== true){
			            $requete = $pdo->prepare("SELECT * FROM account WHERE email = ?");
			        }else{
			            $requete = $pdo->prepare("SELECT * FROM account WHERE pseudo = ?");
			        }

			        $requete->execute(array($email));

			        $accounts = $requete->fetchAll();
					
			        for($i = 0; $i < count($accounts); $i++) {
			        	if(password_verify($password, $accounts[$i]['password'])){
			        		createSession($accounts[$i]);
			        		break;
			        	}
			        }

			        $signupError = "Mauvais identifiant ou mot de passe !";
			    }else{
			    	$signupError = "Tous les champs ne sont pas remplis !";
			    }
		    }
	?>

	<body id="form">
		<div class="background-login"></div>
		<div class="logo">
			<h1 class="logo-title">Nexia</h1>
		</div>
		<div class="container" id="container">
			<div class="form-container sign-up-container">
				<form method="POST" id="signinForm">
					<h1>Creez votre compte</h1>
					<span>Seulement si vous n'avez pas de compte</span>
					<input type="email" name="email" placeholder="Email" maxlength="255" autocomplete="email" required />
					<input type="text" name="pseudo" placeholder="Nom d'utilisateur" maxlength="255" autocomplete="username" required />
					<input type="text" name="fullName" placeholder="Nom" maxlength="255" autocomplete="given-name" required />
					<input type="password" name="password" placeholder="Password" maxlength="255" autocomplete="new-password" required />
					<input type="submit" name="signin" value="S'inscrire"></input>
					<?php
						if(isset($signinError)){
							echo '<p class="error">'.$signinError.'</p>';
						}
					?>
				</form>
			</div>
			<div class="form-container sign-in-container">
				<form method="POST" id="signupForm">
					<h1>Connexion</h1>
					<span>Si vous avez déjà un compte</span>
					<input type="text" name="email" placeholder="Email" maxlength="255" autocomplete="email" required />
					<input type="password" name="password" placeholder="Password" maxlength="255" autocomplete="current-password" required />
					<a href="#">Mot de passe oublié ?</a>
					<input type="submit" name="signup" value="Connexion"></input>
					<?php
						if(isset($signupError)){
							echo '<p class="error">'.$signupError.'</p>';
						}
					?>
				</form>
			</div>
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-left">
						<h1>De retour parmi nous ?</h1>
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
				- Projet Nexia BUT Informatique Nevers 2023
			</p>
		</footer>
	</body>
</html>

<?php
	} catch(Exception $e) {
		$error = $e->getMessage();
		include_once("php/error400.php");
	}
?>


<script src="js/form.js"></script>
<script src="js/side-bar.js"></script>
