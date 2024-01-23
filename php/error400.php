<?php
    include_once("session.php");
?>
<link rel="stylesheet" type="text/css" href="css/error.css">
<div class="error">
    <img src="images/icon.ico" class="error-logo" style="width: 20%">
    <h1 class="error-title">Erreur 400</h1>
    <p class="error-sub-title">Une erreur est survenue.</p>

    <?php
        if(isset($error)){
            echo '<p class="error-message">'.$error.'</p>';
        }
    ?>

    <?php
        echo '<a onclick="location.reload()" class="error-button-return">Réessayer</a>';
    ?>
</div>