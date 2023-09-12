<?php
	include_once('session.php');
	check();
?>

<div class="side-nav-bar">
	<div class="side-nav-bar-fixed">
		<div class="side-nav-logo">
			<a href="index" style="text-decoration: none;">
				<h1 class="logo-title">InstaHess</h1>
				<svg width="30px" height="48px" class="icon-title">
					<defs>
						<linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
							<stop offset="0%" style="stop-color: var(--yellow-logo); stop-opacity: 1" />
							<stop offset="100%" style="stop-color: var(--purple-logo); stop-opacity: 1" />
						</linearGradient>
					</defs>
					<g xmlns="http://www.w3.org/2000/svg" transform="translate(3.000000,40.000000) scale(0.0500000,-0.0500000)">
						<path d="M227 567c-14-43-31-67-93-127-86-82-105-119-105-196 0-137 102-232 238-221 125 10 212 113 200 238-3 30-13 71-22 90l-18 34-12-47c-15-62-39-95-81-116-26-12-39-13-52-6-30 19-26 53 14 112 51 77 57 141 20 204-14 24-36 54-49 66l-23 22-17-53z" fill="url(#gradient)" />
					</g>
				</svg>
			</a>
		</div>

		<div class="side-nav-menu">
			<div class="side-nav-button">
				<a href="index">
					<?php
						if(basename($_SERVER['PHP_SELF']) != "index.php"){
							echo '
							<svg height="24" width="24" viewBox="0 0 24 24">
								<path d="M9.005 16.545a2.997 2.997 0 0 1 2.997-2.997A2.997 2.997 0 0 1 15 16.545V22h7V11.543L12 2 2 11.543V22h7.005Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2" />
							</svg>';
						}
						else{
							echo '
							<svg height="24" width="24" viewBox="0 0 24 24">
								<path d="M22 23h-6.001a1 1 0 0 1-1-1v-5.455a2.997 2.997 0 1 0-5.993 0V22a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V11.543a1.002 1.002 0 0 1 .31-.724l10-9.543a1.001 1.001 0 0 1 1.38 0l10 9.543a1.002 1.002 0 0 1 .31.724V22a1 1 0 0 1-1 1Z"/>
							</svg>';
						}
					?>
					<span>Accueil</span>
				</a>
			</div>

			<div class="side-nav-button" onclick="openSearchSide()">
				<a>
					<svg height="24" width="24" viewBox="0 0 24 24" class="research-icon">
						<path d="M19 10.5A8.5 8.5 0 1 1 10.5 2a8.5 8.5 0 0 1 8.5 8.5Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
						<line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="16.511" x2="22" y1="16.511" y2="22"/>
					</svg>
					<svg height="24" width="24" viewBox="0 0 24 24" class="research-icon" style="display: none;">
						<path d="M18.5 10.5a8 8 0 1 1-8-8 8 8 0 0 1 8 8Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
						<line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" x1="16.511" x2="21.643" y1="16.511" y2="21.643" />
					</svg>
					<span>Recherche</span>
				</a>
			</div>

			<div class="side-nav-button">
				<a href="message">
					<?php
						if(basename($_SERVER['PHP_SELF']) != "message.php"){
							echo '
							<svg height="24" width="24" viewBox="0 0 24 24">
								<line fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2" x1="22" x2="9.218" y1="3" y2="10.083"/>
								<polygon fill="none" points="11.698 20.334 22 3.001 2 3.001 9.218 10.084 11.698 20.334" stroke="currentColor" stroke-linejoin="round" stroke-width="2"/>
							</svg>';
						}
						else{
							echo '
							<svg height="24" width="24" viewBox="0 0 24 24">
								<path d="M22.91 2.388a.69.69 0 0 0-.597-.347l-20.625.002a.687.687 0 0 0-.482 1.178L7.26 9.16a.686.686 0 0 0 .778.128l7.612-3.657a.723.723 0 0 1 .937.248.688.688 0 0 1-.225.932l-7.144 4.52a.69.69 0 0 0-.3.743l2.102 8.692a.687.687 0 0 0 .566.518.655.655 0 0 0 .103.008.686.686 0 0 0 .59-.337L22.903 3.08a.688.688 0 0 0 .007-.692" />
							</svg>';
						}
					?>
					<span>Messages</span>
				</a>
			</div>

			<div class="side-nav-button" onclick="openNotificationSide()">
				<a>
					<svg height="24" width="24" viewBox="0 0 24 24" class="notification-icon">
						<path d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"/>
					</svg>
					<svg height="24" width="24" viewBox="0 0 24 24" class="notification-icon" style="display: none;">
						<path d="M17.075 1.987a5.852 5.852 0 0 0-5.07 2.66l-.008.012-.01-.014a5.878 5.878 0 0 0-5.062-2.658A6.719 6.719 0 0 0 .5 8.952c0 3.514 2.581 5.757 5.077 7.927.302.262.607.527.91.797l1.089.973c2.112 1.89 3.149 2.813 3.642 3.133a1.438 1.438 0 0 0 1.564 0c.472-.306 1.334-1.07 3.755-3.234l.978-.874c.314-.28.631-.555.945-.827 2.478-2.15 5.04-4.372 5.04-7.895a6.719 6.719 0 0 0-6.425-6.965Z"/>
					</svg>
					<span>Notification</span>
				</a>
			</div>

			<div class="side-nav-button">
				<a href="create">
					<?php
						if(basename($_SERVER['PHP_SELF']) != "create.php"){
							echo '
							<svg width="24" height="24" viewBox="0 0 24 24">
								<path d="M2 12v3.45c0 2.849.698 4.005 1.606 4.944.94.909 2.098 1.608 4.946 1.608h6.896c2.848 0 4.006-.7 4.946-1.608C21.302 19.455 22 18.3 22 15.45V8.552c0-2.849-.698-4.006-1.606-4.945C19.454 2.7 18.296 2 15.448 2H8.552c-2.848 0-4.006.699-4.946 1.607C2.698 4.547 2 5.703 2 8.552Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" fill="none" />
								<line x1="6.545" y1="12.001" x2="17.455" y2="12.001" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" fill="none" />
								<line x1="12.003" y1="6.545" x2="12.003" y2="17.455" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" fill="none" />
							</svg>';
						}
						else{
							echo '
							<svg height="24" width="24" viewBox="0 0 24 24">
								<path d="m12.003 5.545-.117.006-.112.02a1 1 0 0 0-.764.857l-.007.117V11H6.544l-.116.007a1 1 0 0 0-.877.876L5.545 12l.007.117a1 1 0 0 0 .877.876l.116.007h4.457l.001 4.454.007.116a1 1 0 0 0 .876.877l.117.007.117-.007a1 1 0 0 0 .876-.877l.007-.116V13h4.452l.116-.007a1 1 0 0 0 .877-.876l.007-.117-.007-.117a1 1 0 0 0-.877-.876L17.455 11h-4.453l.001-4.455-.007-.117a1 1 0 0 0-.876-.877ZM8.552.999h6.896c2.754 0 4.285.579 5.664 1.912 1.255 1.297 1.838 2.758 1.885 5.302L23 8.55v6.898c0 2.755-.578 4.286-1.912 5.664-1.298 1.255-2.759 1.838-5.302 1.885l-.338.003H8.552c-2.754 0-4.285-.579-5.664-1.912-1.255-1.297-1.839-2.758-1.885-5.302L1 15.45V8.551c0-2.754.579-4.286 1.912-5.664C4.21 1.633 5.67 1.05 8.214 1.002L8.552 1Z" />
							</svg>';
						}
					?>
					<span>Créer</span>
				</a>
			</div>

			<div class="side-nav-button">
				<a href="profil">
					<?php echo '<img class="side-nav-profil" src="'.$_SESSION['profil'].'" />'; ?>
					<span>Profil</span>
				</a>
			</div>
		</div>
	</div>

	<div class="side-nav-sub" style="width: 0px;">
		<div class="side-nav-sub-research">
			<?php
				include_once("php/side-bar-research.php")
			?>
		</div>

		<div class="side-nav-sub-notification">
			<?php
				include_once("php/side-bar-notification.php");
			?>
		</div>
	</div>
</div>