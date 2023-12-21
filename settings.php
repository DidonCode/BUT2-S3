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
  <div class="panel">
    <div class="header">
      <h2>PHOTO DE PROFIL</h2>
    </div>
    <div class="content">
      <div class="profile-section">
        <div class="profile-image">
          <img src="images/profil/civilisation.jpg" alt="">
        </div> <br>
        <input type="file" id="fileInput" accept="image/*"> <br>
        <button class="apply-btn">Enregistrer la sélection</button>
      </div>
    </div>
  </div>

  <div class="panel">
    <div class="header">
      <h2>INFORMATIONS</h2>
    </div>
    <div class="content">
      <div class="info-section">
        <h3>Modifier les informations</h3>

        <div class="form__group change-input">
        <input type="input" class="form__field" placeholder="" name="newPseudo" id="newPseudo" required />
        <label for="newPseudo" class="form__label">Nouveau pseudo</label>
    </div>

    <div class="form__group change-input">
        <input type="input" class="form__field" placeholder="" name="newName" id="newName" required />
        <label for="newName" class="form__label">Nouveau nom</label>
    </div>
        
    <div class="form__group change-input">
        <textarea class="form__field" placeholder="" name="newBio" id="newBio" required></textarea>
        <label for="newBio" class="form__label">Nouvelle bio</label>
    </div>

        <button class="apply-btn">Enregistrer la sélection</button>
      </div>
    </div>
  </div>
  
  <div class="panel">
    <div class="header">
      <h2>SÉCURITÉ</h2>
    </div>
    <div class="content">
      <div class="info-section">
      <div class="form__group change-input">
        <input type="password" class="form__field" placeholder="" name="newPassword" id="newPassword" required />
        <label for="newPassword" class="form__label">Nouveau mot de passe</label>
    </div>
        <button class="apply-btn">Enregistrer la sélection</button>
      </div>
    </div>
  </div>
  
  <div class="panel">
    <div class="header">
      <h2>CONFIDENTIALITÉ</h2>
    </div>
    <div class="content">
      <div class="info-section">
      <div id="blockedAccounts">
        <h3>Comptes bloqués</h3>
        <p>Aucun compte bloqué pour le moment.</p>
    </div>
        <button class="apply-btn">Enregistrer la sélection</button>
      </div>
    </div>
  </div>
    <script src="js/settings.js"></script>
    <script src="js/side-bar.js"></script>
</body>
</html>
