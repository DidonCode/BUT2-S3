<?php

    require('php/database.php');
    include_once('php/session.php');
    
    if(valid()){

    $requete = $pdo->prepare("SELECT pseudo FROM account WHERE id =?");
    $requete->execute(array($_SESSION['id']));

    $pseudo = $requete->fetch();

    $requete = $pdo-> prepare("SELECT id, pseudo, fullName, bio, profil FROM account WHERE id = ?");
        $requete->execute(array($_SESSION['id']));
        
        $profilData = $requete->fetchAll();


        $id = $profilData[0]['id'];
        $pseudo = $profilData[0]['pseudo'];
        $fullName = $profilData[0]['fullName'];
        $bio = $profilData[0]['bio'];
        $PDP = $profilData[0]['profil'];
    }

    if(isset($_GET['profil'])){
        $requete = $pdo-> prepare("SELECT id, pseudo, fullName, bio, profil FROM account WHERE pseudo = ?");
        $requete->execute(array($_GET['profil']));
        
        $profilData = $requete->fetchAll();
            // destroySession();
    }


    $requete = $pdo->prepare("SELECT id, spot, content, contentType, description, date, enableComment FROM post WHERE publisher =?");
    $requete->execute(array($id));

    $postData = $requete->fetchAll();

    $postNumber = $requete->rowcount();

    
    
    

    // var_dump($postData);




    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/profil.css">
    <link rel="stylesheet" type="text/css" href="css/side-bar.css">
</head>

<body>

    <?php 
        if(!empty($profilData)){
        
            $id = $profilData[0]['id'];
            $pseudo = $profilData[0]['pseudo'];
            $fullName = $profilData[0]['fullName'];
            $bio = $profilData[0]['bio'];
            $PDP = $profilData[0]['profil'];
        }
        else{
            include_once("php/side-bar.php");
            echo "Désolé nous ne trouvons pas ce profil.";
            exit();
        }
    ?>
<div class="main-container">
    <?php 
        include_once("php/side-bar.php");
    ?>
    <div class="container">
        <div id="settings">
            <div id="menuButton" class="svg-button">
                <a href="settings.php"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                </svg></a>
            </div>
            <div id="contextMenu" class="context-menu">
            </div>
        </div>
        <div id="bio">
            <div class="photo-profil">
                <?php echo '<img src="'.$PDP. '" alt="photo-profil">'; ?>
            </div>
            <div class="profil-info">
                <ul class="informations">
                    <li class="settings">
                       <div class = "certif">
                            <p class="username"><?php echo $pseudo; ?></p>
                            <svg style="position: relative; left:10px;" color="rgb(0, 149, 246)" fill="rgb(0, 149, 246)" height="18" role="img" viewBox="0 0 40 40" width="18">
                                <path d="M19.998 3.094 14.638 0l-2.972 5.15H5.432v6.354L0 14.64 3.094 20 0 25.359l5.432 3.137v5.905h5.975L14.638 40l5.36-3.094L25.358 40l3.232-5.6h6.162v-6.01L40 25.359 36.905 20 40 14.641l-5.248-3.03v-6.46h-6.419L25.358 0l-5.36 3.094Zm7.415 11.225 2.254 2.287-11.43 11.5-6.835-6.93 2.244-2.258 4.587 4.581 9.18-9.18Z" fill-rule="evenodd"></path>
                            </svg>
                        </div>
                        <br>    
                        <button id="followButton" class="follow-button" onclick="toggleFollow()">Follow</button>
                    </li>
                    <li><span>0</span> Post</li>
                    <li><span id="followerCount">0</span> Followers</li>
                    <li><span>0</span> Suivi</li>
                </ul>
				<div class="texte-bio">
					<p><?php echo $bio; ?></p>
				</div>
            </div>
            
        </div>
        <div class="grid-container">
        <div class="AffichagePost">

            <?php

            for($i=0; $i<$postNumber; $i++){

                $postId = $postData[$i]['id'];
                $postSpot = $postData[$i]['spot'];
                $postContent = $postData[$i]['content'];
                $postContentType = $postData[$i]['contentType'];
                $postDescription = $postData[$i]['description'];
                $postDate = $postData[$i]['date'];
                $postEnableComment = $postData[$i]['enableComment'];

           
                if($postContentType == "image"){
                    echo '<img src="' . $postContent . '">';
                    echo '<div class="affichagePostLike"></div>';
                }

                else{
                    echo '<video muted autoplay loop>
                            <source src="'.$postContent.'" type="video/mp4"/>
                        </video>';
                }

            }    

            ?>
        </div>
        </div>
    </div>
	<div id="settings">
        <div id="contextMenu" class="context-menu">
            <ul>
                <li><a href="#">Modifier le nom</a></li><br>
                <li><a href="#">Modifier la bio</a></li><br>
                <li><a href="#">Modifier la photo de profil</a></li><br>
                <li><a href="#">Changer le mot de passe</a></li><br>
                <li><a href="#">Compte bloqué</a></li>
            </ul>
        </div>
    </div>
</div>

<script>
    let isFollowed = false;
    let followerCount = 0;

    function toggleFollow() {
        if (isFollowed) {
            isFollowed = false;
            followerCount--;
            document.getElementById('followButton').innerText = 'Follow';
        } else {
            isFollowed = true;
            followerCount++;
            document.getElementById('followButton').innerText = 'Followed';
        }
        document.getElementById('followerCount').innerText = followerCount;
    }

    document.addEventListener("DOMContentLoaded", function () {
        const menuButton = document.getElementById("menuButton");
        const contextMenu = document.getElementById("contextMenu");

        menuButton.addEventListener("click", function (event) {
            event.stopPropagation();
            contextMenu.style.display = contextMenu.style.display === "block" ? "none" : "block";
        });

        document.addEventListener("click", function () {
            contextMenu.style.display = "none";
        });

        contextMenu.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    });
</script>

<script src="https://kit.fontawesome.com/bd843d384a.js" crossorigin="anonymous"></script>
<script src="js/side-bar.js"></script>
</body>
</html>
