<?php
    include_once("session.php");
?>
<link rel="stylesheet" type="text/css" href="css/error.css">
<div class="error">
    <img src="images/icon.ico" class="error-logo">
    <h1 class="error-title">Erreur 404</h1>
    <p class="error-sub-title">La page que vous recherchez est introuvable.</p>

    <?php
        if(validSession()){
            echo '<a href="index.php" class="error-button-return">Retour</a>';
        }else{
            echo '<a href="form.php" class="error-button-return">Retour</a>';
        }
    ?>
</div>

<script src="js/side-bar.js"></script>