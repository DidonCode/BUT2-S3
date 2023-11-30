<?php
include_once('session.php');
//check();
?>

<div class="side-nav-bar">
    <div class="side-nav-bar-fixed">
        <div class="side-nav-logo">
            <a href="index.php" style="text-decoration: none;">
                <h1 class="logo-title"">Admin</h1>
                <svg width="30px" height="48px" class="icon-title">
                    <defs>
                        <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color: var(--yellow-logo); stop-opacity: 1" />
                            <stop offset="100%" style="stop-color: var(--purple-logo); stop-opacity: 1" />
                        </linearGradient>
                    </defs>
                    <g xmlns="http://www.w3.org/2000/svg"
                        transform="translate(3.000000,40.000000) scale(0.0500000,-0.0500000)">
                        <path
                            d="M227 567c-14-43-31-67-93-127-86-82-105-119-105-196 0-137 102-232 238-221 125 10 212 113 200 238-3 30-13 71-22 90l-18 34-12-47c-15-62-39-95-81-116-26-12-39-13-52-6-30 19-26 53 14 112 51 77 57 141 20 204-14 24-36 54-49 66l-23 22-17-53z"
                            fill="url(#gradient)" />
                    </g>
                </svg>
            </a>
        </div>

        <div class="side-nav-menu">
            <div class="side-nav-button">
                <a href="admin.php">
                    <?php
                    if (basename($_SERVER['PHP_SELF']) != "admin.php") {
                        echo '
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 512 512">
                            <style>svg{fill:#000000}</style>
                            <path d="M78.6 5C69.1-2.4 55.6-1.5 47 7L7 47c-8.5 8.5-9.4 22-2.1 31.6l80 104c4.5 5.9 11.6 9.4 19 9.4h54.1l109 109c-14.7 29-10 65.4 14.3 89.6l112 112c12.5 12.5 32.8 12.5 45.3 0l64-64c12.5-12.5 12.5-32.8 0-45.3l-112-112c-24.2-24.2-60.6-29-89.6-14.3l-109-109V104c0-7.5-3.5-14.5-9.4-19L78.6 5zM19.9 396.1C7.2 408.8 0 426.1 0 444.1C0 481.6 30.4 512 67.9 512c18 0 35.3-7.2 48-19.9L233.7 374.3c-7.8-20.9-9-43.6-3.6-65.1l-61.7-61.7L19.9 396.1zM512 144c0-10.5-1.1-20.7-3.2-30.5c-2.4-11.2-16.1-14.1-24.2-6l-63.9 63.9c-3 3-7.1 4.7-11.3 4.7H352c-8.8 0-16-7.2-16-16V102.6c0-4.2 1.7-8.3 4.7-11.3l63.9-63.9c8.1-8.1 5.2-21.8-6-24.2C388.7 1.1 378.5 0 368 0C288.5 0 224 64.5 224 144l0 .8 85.3 85.3c36-9.1 75.8 .5 104 28.7L429 274.5c49-23 83-72.8 83-130.5zM56 432a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/>
                        </svg>';
                    } else {
                        echo '
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 512 512">
                            <style>svg{fill:#000000}</style>
                            <path d="M78.6 5C69.1-2.4 55.6-1.5 47 7L7 47c-8.5 8.5-9.4 22-2.1 31.6l80 104c4.5 5.9 11.6 9.4 19 9.4h54.1l109 109c-14.7 29-10 65.4 14.3 89.6l112 112c12.5 12.5 32.8 12.5 45.3 0l64-64c12.5-12.5 12.5-32.8 0-45.3l-112-112c-24.2-24.2-60.6-29-89.6-14.3l-109-109V104c0-7.5-3.5-14.5-9.4-19L78.6 5zM19.9 396.1C7.2 408.8 0 426.1 0 444.1C0 481.6 30.4 512 67.9 512c18 0 35.3-7.2 48-19.9L233.7 374.3c-7.8-20.9-9-43.6-3.6-65.1l-61.7-61.7L19.9 396.1zM512 144c0-10.5-1.1-20.7-3.2-30.5c-2.4-11.2-16.1-14.1-24.2-6l-63.9 63.9c-3 3-7.1 4.7-11.3 4.7H352c-8.8 0-16-7.2-16-16V102.6c0-4.2 1.7-8.3 4.7-11.3l63.9-63.9c8.1-8.1 5.2-21.8-6-24.2C388.7 1.1 378.5 0 368 0C288.5 0 224 64.5 224 144l0 .8 85.3 85.3c36-9.1 75.8 .5 104 28.7L429 274.5c49-23 83-72.8 83-130.5zM56 432a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/>
                        </svg>';
                    }
                    ?>
                    <span>Admin Panel</span>
                </a>
            </div>

            <div class="side-nav-button" onclick="openSearchSide()">
                <a>
                    <svg height="24" width="24" viewBox="0 0 24 24" class="research-icon">
                        <path d="M19 10.5A8.5 8.5 0 1 1 10.5 2a8.5 8.5 0 0 1 8.5 8.5Z" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" x1="16.511" x2="22" y1="16.511" y2="22" />
                    </svg>
                    <svg height="24" width="24" viewBox="0 0 24 24" class="research-icon" style="display: none;">
                        <path d="M18.5 10.5a8 8 0 1 1-8-8 8 8 0 0 1 8 8Z" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                        <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="3" x1="16.511" x2="21.643" y1="16.511" y2="21.643" />
                    </svg>
                    <span>Recherche</span>
                </a>
            </div>

            <div class="side-nav-button">
                <a href="ticket.php">
                    <?php
                    if (basename($_SERVER['PHP_SELF']) != "ticket.php") {
                        echo '
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 576 512">
                            <style>svg{fill:#000000}</style>
                            <path d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z"/>
                        </svg>';
                    } else {
                        echo '
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 576 512">
                            <style>svg{fill:#000000}</style>
                            <path d="M64 64C28.7 64 0 92.7 0 128v64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320v64c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V320c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6V128c0-35.3-28.7-64-64-64H64zm64 112l0 160c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H144c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32H448c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V160z"/>
                        </svg>';
                    }
                    ?>
                    <span>Tickets</span>
                </a>
            </div>

            <div class="side-nav-button" onclick="openNotificationSide()">
                <a>
                    <svg height="24" width="24" viewBox="0 0 24 24" class="notification-icon">
                        <path
                            d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z" />
                    </svg>
                    <svg height="24" width="24" viewBox="0 0 24 24" class="notification-icon" style="display: none;">
                        <path
                            d="M17.075 1.987a5.852 5.852 0 0 0-5.07 2.66l-.008.012-.01-.014a5.878 5.878 0 0 0-5.062-2.658A6.719 6.719 0 0 0 .5 8.952c0 3.514 2.581 5.757 5.077 7.927.302.262.607.527.91.797l1.089.973c2.112 1.89 3.149 2.813 3.642 3.133a1.438 1.438 0 0 0 1.564 0c.472-.306 1.334-1.07 3.755-3.234l.978-.874c.314-.28.631-.555.945-.827 2.478-2.15 5.04-4.372 5.04-7.895a6.719 6.719 0 0 0-6.425-6.965Z" />
                    </svg>
                    <span>Notification</span>
                </a>
            </div>

            <div class="side-nav-button">
                <a href="database-management.php">
                    <?php
                    if (basename($_SERVER['PHP_SELF']) != "database-management.php") {
                        echo '
							<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 448 512">
                                <style>svg{fill:#000000}</style>
                                <path d="M448 80v48c0 44.2-100.3 80-224 80S0 172.2 0 128V80C0 35.8 100.3 0 224 0S448 35.8 448 80zM393.2 214.7c20.8-7.4 39.9-16.9 54.8-28.6V288c0 44.2-100.3 80-224 80S0 332.2 0 288V186.1c14.9 11.8 34 21.2 54.8 28.6C99.7 230.7 159.5 240 224 240s124.3-9.3 169.2-25.3zM0 346.1c14.9 11.8 34 21.2 54.8 28.6C99.7 390.7 159.5 400 224 400s124.3-9.3 169.2-25.3c20.8-7.4 39.9-16.9 54.8-28.6V432c0 44.2-100.3 80-224 80S0 476.2 0 432V346.1z"/>
                            </svg>';
                    } else {
                        echo '
							<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 448 512">
                                <style>svg{fill:#000000}</style>
                                <path d="M448 80v48c0 44.2-100.3 80-224 80S0 172.2 0 128V80C0 35.8 100.3 0 224 0S448 35.8 448 80zM393.2 214.7c20.8-7.4 39.9-16.9 54.8-28.6V288c0 44.2-100.3 80-224 80S0 332.2 0 288V186.1c14.9 11.8 34 21.2 54.8 28.6C99.7 230.7 159.5 240 224 240s124.3-9.3 169.2-25.3zM0 346.1c14.9 11.8 34 21.2 54.8 28.6C99.7 390.7 159.5 400 224 400s124.3-9.3 169.2-25.3c20.8-7.4 39.9-16.9 54.8-28.6V432c0 44.2-100.3 80-224 80S0 476.2 0 432V346.1z"/>
                            </svg>';
                    }
                    ?>
                    <span>Database</span>
                </a>
            </div>

            <div class="side-nav-button">
                <a href="profil.php">
                    <?php echo '<img class="side-nav-profil" src="' . $_SESSION['profil'] . '" />'; ?>
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