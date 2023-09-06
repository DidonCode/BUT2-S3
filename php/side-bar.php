<style>
	.side-bar{
		width: 20%;
		position: absolute;
		top: 0px;
		left: 0px;
		background-color: white;
		border: 2px solid black;
		border-left: none;
		border-bottom: none;
		border-top: none;
		height: 100%;
	}

	.side-bar .logo-side-bar{
		width: 80%;
		margin: 0 auto;
	}

	.side-bar .logo-side-bar img{
		width: 100%;
		margin: 3vw 0px 3vw 0px;
	}

	.side-bar ul{
		padding-left: 1vw;
	}

	.side-bar ul li{
		text-decoration: none;
		color: white;
	}

	.side-bar ul li button {
		background: transparent;
		padding: 0.5vw;
		text-align: left;
		border: none;
		width: 98%;
		font-weight: 400;
		font-size: 1.4vw;
		transition: 0.5s;
	}

	.side-bar ul li button:hover {
		background-color: lightgray;
		border-radius: 0.3em;
		transition: 0.5s;
	}

	.side-bar ul li button i {
		color: black;
		margin: 5px;
		padding: 0px 20px 0px 10px;
	}

	.side-bar ul li button .profil-image {
		width: 1.5vw;
		height: 1.5vw;
		background-repeat: no-repeat;
		background-size: cover;
		margin: 0px 1.6vw 0px 0.9vw;
		border-radius: 50%;
		background-image: url('images/instahess.png');
	}

	.side-bar ul li button .profil-name {
		font-size: 1.4vw;
		font-weight: 400;
		margin: 0px;
	}
</style>

<script src="https://kit.fontawesome.com/bd843d384a.js" crossorigin="anonymous"></script>

<div class="side-bar">
	<div class="logo-side-bar">
		<img src="images/instahess.png">
	</div>
	<ul>
		<li><button><i class="fa-solid fa-house"></i>Accueil</button></li>
		<br>
		<li><button><i class="fa-solid fa-magnifying-glass"></i>Recherche</button></li>
		<br>
		<li><button onclick="document.location.href = 'account/message.php';"><i class="fa-solid fa-paper-plane"></i>Messages</button></li>
		<br>
		<li><button><i class="fa-solid fa-heart"></i>Notifications</button></li>
		<br>
		<li ><button onclick="document.location.href = 'account/profil.php';"><div style="display: inline-flex;"><div class="profil-image"></div><h1 class="profil-name">Profil</h1></div></button></li>
	</ul>
</div>