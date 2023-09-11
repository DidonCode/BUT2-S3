<style>
	@import "css/colors.css";

	html{
		height: 100%;
	}

	body{
		padding: 0px;
		margin: 0px;
		height: 100%;
	}

	.side-nav-bar{
		user-select: none;
		width: 320px;
		background-color: var(--background-color);
		padding: 0px 5px 0px 5px;
		border: 2px solid black;
		border-left: none;
		border-bottom: none;
		border-top: none;
		transition: 0.8s;
	}

	.side-nav-bar .side-nav-logo{
		height: 20px;
		margin-left: 10px;
		padding-top: 30px;
		margin-bottom: 50px;
	}

	.logo-title{
		font-size: 2.2em;
		margin: 0px;
		width: 100%;
	}

	.side-nav-button{
		width: 98%;
		height: 30px;
		margin: 10px 0px 10px 2px;
		padding: 12px 0px 5px 0px;
	}

	.side-nav-button:hover{
		background-color: rgba(0, 0, 0, 0.05);
		border-radius: 0.5em;
	}

	.side-nav-button a{
		display: table;
		margin: auto 0;
		text-decoration: none;
		color: black;
	}

	.side-nav-button span{
		font-size: 16px;
		font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
		letter-spacing: 0.5px;
		font-weight: 400;
		display: table-cell;
		vertical-align: middle;
		text-align: left;
		margin: 0;
	}

	.side-nav-button svg, .side-nav-profil{
		display: table-cell;
		vertical-align: middle;
		padding: 0px 15px 0px 10px;
	}

	.side-nav-profil{
		overflow-clip-margin: content-box;
		overflow: clip;
		padding: 0px;
		margin-left: 10px;
		margin-right: 15px;
		width: 24px;
		height: 24px;
		border-radius: 50%;
	}

	.side-nav-sub{
		width: 380px;
		height: 100%;
		background-color: white;
		position: relative;
		left: 50px;
		z-index: -1;
		box-shadow: 10px 10px 14px 0px rgba(199,199,199,0.75);
		transition: 0.8s;
	}

	.icon-title{
		display: none;
	}

	@keyframes disappear {
		0%{ opacity: 1; }
		50%{ opacity: 0.5; }
		100%{ opacity: 0; }
	}

	@keyframes appear {
		0%{ opacity: 0; }
		50%{ opacity: 0.5; }
		100%{ opacity: 1; }
	}

</style>

<?php
	include_once('session.php');
	check();
?>

<div class="side-nav-bar">
	<div style="position: fixed; z-index: 1;">
		<div class="side-nav-logo">
			<h1 class="logo-title">InstaHess</h1>
			<svg width="24px" height="48px" class="icon-title">
				<defs>
					<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
						<stop offset="0%" style="stop-color: var(--yellow-logo); stop-opacity: 1" />
						<stop offset="100%" style="stop-color: var(--purple-logo); stop-opacity: 1" />
					</linearGradient>
				</defs>
				<g xmlns="http://www.w3.org/2000/svg" transform="translate(0.000000,40.000000) scale(0.0500000,-0.0500000)">
					<path d="M227 567c-14-43-31-67-93-127-86-82-105-119-105-196 0-137 102-232 238-221 125 10 212 113 200 238-3 30-13 71-22 90l-18 34-12-47c-15-62-39-95-81-116-26-12-39-13-52-6-30 19-26 53 14 112 51 77 57 141 20 204-14 24-36 54-49 66l-23 22-17-53z" fill="url(#gradient)" />
				</g>
			</svg>
		</div>

		<div class="side-nav-menu" style="z-index: 1;">
			<div class="side-nav-button">
				<?php
					if(basename($_SERVER['PHP_SELF']) == "index.php"){
						echo '<a>';
					}
					else {
						echo '<a href="../index.php">';
					}
				
					echo '
						<svg height="24" width="24" viewBox="0 0 24 24">
							<path d="M22 23h-6.001a1 1 0 0 1-1-1v-5.455a2.997 2.997 0 1 0-5.993 0V22a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V11.543a1.002 1.002 0 0 1 .31-.724l10-9.543a1.001 1.001 0 0 1 1.38 0l10 9.543a1.002 1.002 0 0 1 .31.724V22a1 1 0 0 1-1 1Z"/>
						</svg>
						<span>Accueil</span>
					</a>';
				?>
			</div>

			<div class="side-nav-button"  onclick="openSearchSide()">
				<a>
					<svg height="24" width="24" viewBox="0 0 24 24">
						<path d="M19 10.5A8.5 8.5 0 1 1 10.5 2a8.5 8.5 0 0 1 8.5 8.5Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
						<line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="16.511" x2="22" y1="16.511" y2="22"/>
					</svg>
					<span>Recherche</span>
				</a>
			</div>

			<div class="side-nav-button">
				<a href="">
					<svg height="24" width="24" viewBox="0 0 24 24">
						<line fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2" x1="22" x2="9.218" y1="3" y2="10.083"/>
						<polygon fill="none" points="11.698 20.334 22 3.001 2 3.001 9.218 10.084 11.698 20.334" stroke="currentColor" stroke-linejoin="round" stroke-width="2"/>
					</svg>
					<span>Messages</span>
				</a>
			</div>

			<div class="side-nav-button" onclick="openNotificationSide()">
				<a>
					<svg height="24" width="24" viewBox="0 0 24 24">
						<path d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"/>
					</svg>
					<span>Notification</span>
				</a>
			</div>

			<div class="side-nav-button">
				<a href="">
					<svg width="24" height="24" viewBox="0 0 24 24">
						<path d="M2 12v3.45c0 2.849.698 4.005 1.606 4.944.94.909 2.098 1.608 4.946 1.608h6.896c2.848 0 4.006-.7 4.946-1.608C21.302 19.455 22 18.3 22 15.45V8.552c0-2.849-.698-4.006-1.606-4.945C19.454 2.7 18.296 2 15.448 2H8.552c-2.848 0-4.006.699-4.946 1.607C2.698 4.547 2 5.703 2 8.552Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" fill="none" />
						<line x1="6.545" y1="12.001" x2="17.455" y2="12.001" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" fill="none" />
						<line x1="12.003" y1="6.545" x2="12.003" y2="17.455" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" fill="none" />
					</svg>
					<span>Créer</span>
				</a>
			</div>

			<div class="side-nav-button">
				<?php
					$profil = "";
					if(basename($_SERVER['PHP_SELF']) == "index.php"){
						echo '<a href="account/profil.php">';
						$profil = $_SESSION['profil'];
					}
					else {
						echo '<a>';
						$profil = "../".$_SESSION['profil'];
					}

					echo'
						<img class="side-nav-profil" src="'.$profil.'" />
						<span>Profil</span>
					</a>';
				?>
			</div>
		</div>
	</div>

	<div class="side-nav-sub" style="width: 0px;">
		
	</div>
</div>

<script>
	function openSearchSide(){
		if(!subSideBarIsOpen()){
			subSideBarOpen(true);
		}else{
			subSideBarOpen(false);
		}
	}

	function openNotificationSide(){
		if(!subSideBarIsOpen()){
			subSideBarOpen(true);
		}else{
			subSideBarOpen(false);
		}
	}

	function subSideBarOpen(open){
		var subPanel = document.getElementsByClassName("side-nav-sub")[0];
		var sideBar = document.getElementsByClassName("side-nav-bar")[0];
		var sideNavButton = sideBar.getElementsByClassName("side-nav-button");
		var titleSpan = sideBar.getElementsByTagName("span");
		var logoTitle = sideBar.getElementsByClassName("logo-title")[0];
		var iconTitle = sideBar.getElementsByClassName("icon-title")[0];

		if(!open){ //Close
			subPanel.style.width = "0px";
			for(var i = 0; i < titleSpan.length; i++){
				titleSpan[i].style.display = "";
				sideNavButton[i].style.width = "";
			}
			sideBar.style.width = "";
			iconTitle.style.animation = "disappear 0.4s linear";
			setTimeout(() => {
				iconTitle.style.display = "none";
				logoTitle.style.display = "block";
				logoTitle.style.animation = "appear 0.4s linear";
			}, "380");
		
		}
		else{ //Open
			subPanel.style.width = "";
			for(var i = 0; i < titleSpan.length; i++){
				titleSpan[i].style.display = "none";
				sideNavButton[i].style.width = "45px";
			}
			sideBar.style.width = "45px";
			logoTitle.style.animation = "disappear 0.4s linear";
			setTimeout(() => {
				logoTitle.style.display = "none";
				iconTitle.style.display = "block";
				iconTitle.style.animation = "appear 0.4s linear";
			}, "380");
		}
	}

	function subSideBarIsOpen(){
		var subPanel = document.getElementsByClassName("side-nav-sub")[0];
		if(subPanel.style.width == "0px"){
			return false;
		}else{
			return true;
		}
	}
</script>