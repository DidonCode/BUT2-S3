<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/settings.css">
    <link rel="stylesheet" type="text/css" href="css/side-bar.css">
</head>
<body>
<div class="main-container">
	<?php 
		include_once("php/side-bar.php");
	?>
<div class="container">
    <div class="general">
        <h1>GÉNÉRAL</h1>
        <div id="changePseudo">
            <h3>Changer de pseudo</h3>
            <input type="text" placeholder="Nouveau pseudo">
        </div>
    

    <div id="changeName">
        <h3>Changer de nom</h3>
        <div id="nameSubMenu">
            <input type="text" placeholder="Nouveau nom">
        </div>
    </div>

    <div id="changePhoto">
        <h3>Changer photo de profil</h3>
        <div id="photoSubMenu">
            <input type="file" accept="image/*">
        </div>
    </div>

    <div id="changeBio">
        <h3>Modifier la bio</h3>
        <div id="bioSubMenu">
            <textarea placeholder="Nouvelle bio"></textarea>
        </div>
    </div>
    </div>
    <div class="securite">
    <h1>SÉCURITÉ</h1>
    <div id="changePassword">
        <h3>Changer de mot de passe</h3>
            <input type="password" placeholder="Nouveau mot de passe">
    </div>
    </div>
    <div class="confidentialite">
    <h1>CONFIDENTIALITÉ</h1>
    <div id="blockedAccounts">
        <h3>Comptes bloqués</h3>
        <p>Aucun compte bloqué pour le moment.</p>
    </div>
    </div>
    <button class="apply-btn" onclick="applyChanges()">Appliquer les modifications</button>
</div>
</div>
    <script src="js/settings.js"></script>
    <script src="js/side-bar.js"></script>
</body>
</html>
