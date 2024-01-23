<!DOCTYPE html>
<html>
	<head>
		<title>Boîte de réception • Direct</title>
		<meta charset="utf-8">
        <link rel="shortcut icon" type="image/x-icon" href="images/icon.ico">
		<link rel="stylesheet" type="text/css" href="css/side-bar.css">
        <link rel="stylesheet" type="text/css" href="css/message.css">
	</head>

    <?php

        try{
            require_once("php/database.php");
            include_once("php/session.php");
            include_once("php/function.php");
            include_once("php/api.php");

            checkSession();

            if(isset($_GET['direct']) && !empty($_GET['direct'])){
                $requete = $pdo->prepare("SELECT id, pseudo, profile FROM account WHERE pseudo = ?");
                $requete->execute(array($_GET['direct']));
                $accountDirectData = $requete->fetchAll();
            }

            if(isset($_POST['message'], $_POST['direct'])){
                $requete = $pdo->prepare("SELECT id FROM account WHERE pseudo = ?");
                $requete->execute(array($_POST['direct']));
                $accoutData = $requete->fetchAll();

                $requete = $pdo->prepare("INSERT INTO message (id, sender, receiver, message, date, view) VALUES ('0', ?, ?, ?, ?, 0)");
                $requete->execute(array($_SESSION['id'], $accoutData[0]['id'], $_POST['message'], getActuallyDate()));

                header("Location: message.php?direct=".$_POST['direct']);
            }
    ?>

	<body>
		<div class="main-container">
			<?php
				include_once('php/side-bar.php');
			?>

            <div class="message-popup-contact-background">
                <div class="message-popup-contact">
                    <div class="message-popup-header">
                        <h3>Nouveau Message</h3>
                        <svg fill="currentColor" height="18" width="18" viewBox="0 0 24 24" class="message-popup-contact-close">
                            <polyline fill="none" points="20.643 3.357 12 12 3.353 20.647" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                            <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" x1="20.649" x2="3.354" y1="20.649" y2="3.354"/>
                        </svg>
                    </div>

                    <input type="text" class="message-popup-contact-input" autocomplete="username" placeholder="Rechercher un compte">

                    <div class="message-popup-contact-list">

                    </div>

                    <button class="message-popup-contact-create">Discuter</button>
                </div>
            </div>

			<div class="container">
                <div class="contact-bar">
                    <div class="contact-bar-header">
                        <h3>Messages</h3>
                        <svg fill="currentColor" height="24" width="24" viewBox="0 0 24 24" class="contact-new">
                            <path d="M12.202 3.203H5.25a3 3 0 0 0-3 3V18.75a3 3 0 0 0 3 3h12.547a3 3 0 0 0 3-3v-6.952" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            <path d="M10.002 17.226H6.774v-3.228L18.607 2.165a1.417 1.417 0 0 1 2.004 0l1.224 1.225a1.417 1.417 0 0 1 0 2.004Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="16.848" x2="20.076" y1="3.924" y2="7.153"/>
                        </svg>
                    </div>
                    <div class="contact-bar-container">
                        <?php
                            $requete = $pdo->prepare("SELECT sender, receiver FROM message WHERE sender = ? OR receiver = ?");
                            $requete->execute(array($_SESSION['id'], $_SESSION['id']));
                            $contactData = $requete->fetchAll();

                            $contactId = array();
                            for($i = 0; $i < count($contactData); $i++){
                                if ($contactData[$i]['sender'] == $_SESSION['id']) {
                                    if (!in_array($contactData[$i]['receiver'], $contactId)) {
                                        array_push($contactId, $contactData[$i]['receiver']);
                                    }
                                } 
                                else {
                                    if (!in_array($contactData[$i]['sender'], $contactId)) {
                                            array_push($contactId, $contactData[$i]['sender']);
                                        }
                                    }
                            }

                            for($i = 0; $i < count($contactId); $i++){
                                $requete = $pdo->prepare("SELECT id, pseudo, profile FROM account WHERE id = ?");
                                $requete->execute(array($contactId[$i]));
                                $accountData = $requete->fetchAll();

                                $requete = $pdo->prepare("SELECT * FROM message WHERE sender = ? OR receiver = ?");
                                $requete->execute(array($accountData[0]['id'], $accountData[0]['id']));
                                $messageData = $requete->fetchAll();

                                echo '<div class="contact">';

                                if(isset($_GET['direct']) && $accountData[0]['pseudo'] == $_GET['direct']){
                                    echo '<a href="message.php" class="contact-header">';
                                }else{
                                    echo '<a href="message.php?direct='.$accountData[0]['pseudo'].'" class="contact-header">';
                                }

                                echo '
                                        <img src="'.$accountData[0]['profile'].'" class="contact-header-profile">
                                        <div class="contact-header-information">
                                            <p class="contact-name">'.$accountData[0]['pseudo'].'</p>';

                                            if(isset($messageData) && count($messageData) > 0){
                                                $lastMessage = $messageData[count($messageData) - 1];

                                                if($lastMessage['sender'] == $_SESSION['id']){
                                                    echo '
                                                    <p class="contact-last-message">Vous: '.htmlspecialchars($lastMessage['message']).' • '.dateDiffActually($lastMessage['date']).'</p>';
                                                }else{
                                                    if($lastMessage['view'] == 0){
                                                        echo '
                                                        <p class="contact-last-message" style="font-weight: 700;">'.htmlspecialchars($lastMessage['message']).' • '.dateDiffActually($lastMessage['date']).'</p><div class="view-notification"></div>';
                                                    }else{
                                                        echo '
                                                        <p class="contact-last-message">'.htmlspecialchars($lastMessage['message']).' • '.dateDiffActually($lastMessage['date']).'</p>';
                                                    }
                                                }
                                            }
                                        echo '
                                        </div>
                                    </a>
                                </div>';
                            }
                        ?>
                    </div>
                </div>

                <?php
                    if(!isset($_GET['direct'])){
                        echo '
                        <link rel="stylesheet" type="text/css" href="css/error.css">

                        <div class="error" style="width: 20%">
                            <img src="images/icon.ico" class="error-logo">
                            <p class="error-title">Vos messages</p>
                            <p class="error-sub-title">Envoyez des photos et des messages privés à un(e) ami(e) ou à un groupe</p>
                        </div>
                        </div></div>
                        <script src="js/side-bar.js"></script>
                        <script src="js/message.js"></script>';
                        exit();
                    }

                    if(isset($_GET['direct'], $accountDirectData) && count($accountDirectData) == 0){
                        include_once("php/error404.php");
                        echo '</div></div>';
                        exit();
                    }
                ?>

                <div class="message-container">
                    <div class="message-header">
                        <div class="message-header-container">
                            <div class="contact-header-container">
                                <?php echo '<a href="profile.php?profile='.$accountDirectData[0]['pseudo'].'" class="contact-header">'; ?>
                                    <?php echo '<img src="'.$accountDirectData[0]['profile'].'" class="contact-header-profile">'; ?>
                                    <p class="contact-name"><?php echo $accountDirectData[0]['pseudo']; ?></p>
                                </a>
                            </div>

                            <div class="contact-action-container">
                                <div class="contact-action">
                                    <svg fill="currentColor" height="24" width="24" viewBox="0 0 24 24">
                                        <path d="M18.227 22.912c-4.913 0-9.286-3.627-11.486-5.828C4.486 14.83.731 10.291.921 5.231a3.289 3.289 0 0 1 .908-2.138 17.116 17.116 0 0 1 1.865-1.71 2.307 2.307 0 0 1 3.004.174 13.283 13.283 0 0 1 3.658 5.325 2.551 2.551 0 0 1-.19 1.941l-.455.853a.463.463 0 0 0-.024.387 7.57 7.57 0 0 0 4.077 4.075.455.455 0 0 0 .386-.024l.853-.455a2.548 2.548 0 0 1 1.94-.19 13.278 13.278 0 0 1 5.326 3.658 2.309 2.309 0 0 1 .174 3.003 17.319 17.319 0 0 1-1.71 1.866 3.29 3.29 0 0 1-2.138.91 10.27 10.27 0 0 1-.368.006Zm-13.144-20a.27.27 0 0 0-.167.054A15.121 15.121 0 0 0 3.28 4.47a1.289 1.289 0 0 0-.36.836c-.161 4.301 3.21 8.34 5.235 10.364s6.06 5.403 10.366 5.236a1.284 1.284 0 0 0 .835-.36 15.217 15.217 0 0 0 1.504-1.637.324.324 0 0 0-.047-.41 11.62 11.62 0 0 0-4.457-3.119.545.545 0 0 0-.411.044l-.854.455a2.452 2.452 0 0 1-2.071.116 9.571 9.571 0 0 1-5.189-5.188 2.457 2.457 0 0 1 .115-2.071l.456-.855a.544.544 0 0 0 .043-.41 11.629 11.629 0 0 0-3.118-4.458.36.36 0 0 0-.244-.1Z"/>
                                    </svg>

                                    <svg fill="currentColor" height="24" width="24" viewBox="0 0 24 24">
                                        <rect fill="none" height="18" rx="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="16.999" x="1" y="3"/>
                                        <path d="m17.999 9.146 2.495-2.256A1.5 1.5 0 0 1 23 8.003v7.994a1.5 1.5 0 0 1-2.506 1.113L18 14.854" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="message-content">

                        <?php
                            if(isset($accountDirectData)){
                                $messageData = getMessages($_SESSION['id'], $accountDirectData[0]['id'], 20, null);
                                echo printMessage($messageData, $accountDirectData[0]['id'], true);

                                $requete = $pdo->prepare("UPDATE message SET view = ? WHERE receiver = ?");
                                $requete->execute(array(1, $_SESSION['id']));
                            }
                        ?>
                    </div>
                    <div class="message-action">
                        <?php
                            if(isset($accountDirectData) && validSession()){
                                $requete = $pdo->prepare("SELECT COUNT(*) FROM account_block WHERE (reporter = ? AND account = ?) OR (reporter = ? AND account = ?)");
                                $requete->execute(array($_SESSION['id'], $accountDirectData[0]['id'], $accountDirectData[0]['id'], $_SESSION['id']));
                                $blockAccount = $requete->fetchAll();

                                if($blockAccount[0][0] == 0){
                                    echo '<input type="text" autocomplete="off" maxlength="255" class="message-input" placeholder="Un petit message..." require_onced>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
	</body>
</html>

<?php
    } catch(Exception $e) {
        $error = $e->getMessage();
        include_once("php/error400.php");
    }
?>

<script src="js/side-bar.js"></script>
<script src="js/message.js"></script>