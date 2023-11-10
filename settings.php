<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/settings.css">
</head>
<body>
<div class="sidebar">
    <h2>Paramètres</h2>
    <ul>
        <li id="general">Général</li>
        <li id="privacy">Confidentialité</li>
        <li id="security">Sécurité</li>
    </ul>
</div>

<div class="settings-container">
    <div class="setting-item general" id="changePseudo">
        <h3>Changer de pseudo</h3>
        <div class="sub-menu" id="pseudoSubMenu">
            <input type="text" placeholder="Nouveau pseudo">
        </div>
    </div>

    <div class="setting-item general" id="changeName">
        <h3>Changer de nom</h3>
        <div class="sub-menu" id="nameSubMenu">
            <input type="text" placeholder="Nouveau nom">
        </div>
    </div>

    <div class="setting-item general" id="changePhoto">
        <h3>Changer photo de profil</h3>
        <div class="sub-menu" id="photoSubMenu">
            <input type="file" accept="image/*">
        </div>
    </div>

    <div class="setting-item general" id="changeBio">
        <h3>Modifier la bio</h3>
        <div class="sub-menu" id="bioSubMenu">
            <textarea placeholder="Nouvelle bio"></textarea>
        </div>
    </div>

    <div class="setting-item security" id="changePassword">
        <h3>Changer de mot de passe</h3>
        <div class="sub-menu" id="passwordSubMenu">
            <input type="password" placeholder="Nouveau mot de passe">
        </div>
    </div>

    <div class="setting-item privacy" id="blockedAccounts">
        <h3>Comptes bloqués</h3>
        <div class="sub-menu" id="blockedSubMenu">
            <p>Aucun compte bloqué pour le moment.</p>
        </div>
    </div>

    <button class="apply-btn" onclick="applyChanges()">Appliquer les modifications</button>
</div>
    <script src="js/settings.js"></script>
</body>
</html>
