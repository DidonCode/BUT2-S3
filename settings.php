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
    <div class="container">
	<?php 
		include_once("php/side-bar.php");
	?>
  <div class="settings-panel">
    <div class="settings-header">
      <h2>PHOTO DE PROFIL</h2>
    </div>
    <div class="settings-content">
      <div class="settings-profile-section">
        <div class="settings-profile-image">
          <img src="images/profil/civilisation.jpg" alt="">
        </div> <br>
        <input type="file" id="fileInput" accept="image/*"> <br>
        <button class="settings-apply-btn">Enregistrer la sélection</button>
      </div>
    </div>
  </div>

  <div class="settings-panel">
    <div class="settings-header">
      <h2>INFORMATIONS</h2>
    </div>
    <div class="settings-content">
      <div class="settings-info-section">
        <h3>Modifier les informations</h3>

        <div class="settings-form-group settings-change-input">
        <input type="input" class="settings-form-field" placeholder="" name="newPseudo" id="newPseudo" required />
        <label for="newPseudo" class="settings-form-label">Nouveau pseudo</label>
    </div>

    <div class="settings-form-group settings-change-input">
        <input type="input" class="settings-form-field" placeholder="" name="newName" id="newName" required />
        <label for="newName" class="settings-form-label">Nouveau nom</label>
    </div>
        
    <div class="settings-form-group settings-change-input">
        <textarea class="settings-form-field" placeholder="" name="newBio" id="newBio" required></textarea>
        <label for="newBio" class="settings-form-label">Nouvelle bio</label>
    </div>

        <button class="settings-apply-btn">Enregistrer la sélection</button>
      </div>
    </div>
  </div>
  
  <div class="settings-panel">
    <div class="settings-header">
      <h2>SÉCURITÉ</h2>
    </div>
    <div class="settings-content">
      <div class="settings-info-section">
      <div class="settings-form-group settings-change-input">
        <input type="password" class="settings-form-field" placeholder="" name="newPassword" id="newPassword" required />
        <label for="newPassword" class="settings-form-label">Nouveau mot de passe</label>
    </div>
        <button class="settings-apply-btn">Enregistrer la sélection</button>
      </div>
    </div>
  </div>
  
  <div class="settings-panel">
    <div class="settings-header">
      <h2>CONFIDENTIALITÉ</h2>
    </div>
    <div class="settings-content">
      <div class="settings-info-section">
      <div id="settings-blockedAccounts">
        <h3>Comptes bloqués</h3>
        <p>Aucun compte bloqué pour le moment.</p>
    </div>
        <button class="settings-apply-btn">Enregistrer la sélection</button>
      </div>
    </div>
  </div>
</div>
</div>
    <script src="js/settings.js"></script>
    <script src="js/side-bar.js"></script>
</body>
</html>
