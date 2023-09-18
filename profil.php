<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/profil.css">
    <link rel="stylesheet" type="text/css" href="css/side-bar.css">
</head>

<body>
<div class="main-container">
    <div class="container">
        <div id="bio">
            <div class="photo-profil">
                <img src="images/profil/profil-instahess.png" alt="photo-profil">
            </div>
            <div class="profil-info">
                <ul class="informations">
                    <li class="settings">
                        <p class="username">Mango_Manga</p>
                    </li>
                    <li>Post</li>
                    <li><span id="followerCount">0</span> Followers</li>
                    <li>Suivi</li>
                </ul>
				<div class="text-bio">
					<p>Ceci est une bio de profil</p>
				</div>
            </div>
        </div>
    </div>
	<div id="settings">
        <div id="menuButton" class="svg-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                <path d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
            </svg>
        </div>
        <!-- Menu contextuel -->
        <div id="contextMenu" class="context-menu">
            <ul>
                <li><a href="#">Modifier le nom</a></li>
                <li><a href="#">Modifier la bio</a></li>
                <li><a href="#">Modifier la photo de profil</a></li>
                <li><a href="#">Changer le mot de passe</a></li>
                <li><a href="#">Compte bloqué</a></li>
            </ul>
        </div>
    </div>
	<button id="followButton" class="follow-button" onclick="toggleFollow()">Follow</button>
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
