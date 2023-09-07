<style>
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
		min-width: 320px;
		height: 100%;
		padding: 0px 5px 0px 5px;
		border: 2px solid black;
		border-left: none;
		border-bottom: none;
		border-top: none;
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
	}

	.side-nav-button{
		width: 98%;
		height: 30px;
		margin: 10px 0px 10px 2px;
		padding: 8px 0px 8px 0px;
		transition: 0.3s;
	}

	.side-nav-button:hover{
		background-color: rgba(0, 0, 0, 0.05);
		border-radius: 0.5em;
		transition: 0.3s;
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
		width: 24px;
		height: 24px;
		border-radius: 50%;
	}
</style>

<div class="side-nav-bar">
	<div class="side-nav-logo">
		<h1 class="logo-title">InstaHess</h1>
	</div>

	<div class="side-nav-menu">
		<div class="side-nav-button">
			<a href="">
				<svg height="24" width="24" viewBox="0 0 24 24">
					<path d="M22 23h-6.001a1 1 0 0 1-1-1v-5.455a2.997 2.997 0 1 0-5.993 0V22a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V11.543a1.002 1.002 0 0 1 .31-.724l10-9.543a1.001 1.001 0 0 1 1.38 0l10 9.543a1.002 1.002 0 0 1 .31.724V22a1 1 0 0 1-1 1Z"/>
				</svg>
				<span>Accueil</span>
			</a>
		</div>

		<div class="side-nav-button">
			<a href="">
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

		<div class="side-nav-button">
			<a href="">
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
			<a href="">
				<img class="side-nav-profil" src="" />
				<span>Profil</span>
			</a>
		</div>

	</div>
</div>