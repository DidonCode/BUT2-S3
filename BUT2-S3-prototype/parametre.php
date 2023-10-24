<!DOCTYPE html>
<html>
<head>
    <title>Profil-Parametres</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/settings.css">
    <link rel="stylesheet" href="css/side-bar.css">
</head>

<body>
    <?php 
    include_once("php/side-bar.php");
    ?>
    
    <div class="profil">
        <p class="title">Profil</p>
        <label for="">Changer pseudo :</label>
        <input type="text" placeholder="Eemple : Fromage_du_92">
        <br>
        <label for="">Changer de nom</label>
        <input type="text" placeholder="Dupont David">
        <br>
        <label for="">Modifier mot de passe</label>
        <input type="text">
        <br>
        <label for="">Confirmer le nouveau mot de passe</label>
        <input type="text">
        <br>
        <label for="">Changer de biographie</label>
        <textarea name="" id="" cols="30" rows="10"></textarea>
        <br>
        <p>Passer votre compte en priver ?</p>
        <input type="radio" id="oui" name="oui" value="oui" />
        <label for="oui">Oui</label>
        <input type="radio" id="non" name="non" value="non" checked/>
        <label for="non">Non</label>
        <br>
        <br>
  </div>

  <div class="Compte">
    <p>Compte</p>
    <p>Voici les comptes que vous avez bloquer : </p>
    <p>Voici les personnes que vous suivez</p>
  </div>

  <div class="confirmed">
    <button>Confirmer</button>
  </div>
</body>
</html>