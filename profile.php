<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" type="image/x-icon" href="images/icon.ico">
        <link rel="stylesheet" type="text/css" href="css/popup.css">
		<link rel="stylesheet" type="text/css" href="css/post.css">
        <link rel="stylesheet" type="text/css" href="css/profile.css">
		<link rel="stylesheet" type="text/css" href="css/side-bar.css">

        <style>
            .post{
                background-color: transparent;
            }
        </style>
    </head>

    <?php
        try{
            require_once("php/database.php");
            include_once("php/session.php");
            include_once("php/function.php");
            include_once("php/post-function.php");
            
            if(isset($_GET['profile'])){
                $request = $pdo->prepare("SELECT id, pseudo, fullName, bio, privatePost, privateLike, verified, profile FROM account WHERE pseudo = ?");
                $request->execute(array($_GET['profile']));

                $profileCount = $request->rowCount();

                if($profileCount == 1){
                    $profileData = $request->fetchAll();

                    $profileId = $profileData[0]['id'];
                    $profilePseudo = $profileData[0]['pseudo'];
                    $profileFullName = $profileData[0]['fullName'];
                    $profileBio = $profileData[0]['bio'];
                    $profilePrivatePost = $profileData[0]['privatePost'];
                    $profilePrivateLike = $profileData[0]['privateLike'];
                    $profileVerified = $profileData[0]['verified'];
                    $profilProfile = $profileData[0]['profile'];
                }
            }else{
                checkSession();
            }

            if(isset($_GET['profile']) && $profileCount > 0){
                echo '<title>'.$profileFullName.'('.$profilePseudo.') • Photos et vidéo Nexia</title>';
            }
            else if(isset($_GET['profile']) && $profileCount == 0){
                echo '<title>Profil • Photos et vidéo Nexia</title>';
            }else if(validSession()){
                echo '<title>'.$_SESSION['fullName'].'('.$_SESSION['pseudo'].') • Photos et vidéo Nexia</title>';
            }

            function publishedPost($accountId){
                global $pdo;

                $request = $pdo->prepare("SELECT * FROM post WHERE publisher = ? ORDER BY STR_TO_DATE(date, '%H:%i:%s %d-%m-%Y') DESC");
                $request->execute(array($accountId));

                $postData = $request->fetchAll();
                return getPostHtml($postData);
            }

            function likedPost($accountId){
                global $pdo;

                $request = $pdo->prepare("SELECT post FROM post_like WHERE account = ?");
                $request->execute(array($accountId));

                $postLiked = $request->fetchAll();

                $html = "";
                for($i = 0; $i < count($postLiked); $i++){
                    $request = $pdo->prepare("SELECT * FROM post WHERE id = ? AND publisher != ?");
                    $request->execute(array($postLiked[$i]['post'], $accountId));

                    $postData = $request->fetchAll();
                    $html .= getPostHtml($postData);
                }

                return $html;
            }

            function getPostHtml($postData){
                $html = "";

                for($i = 0; $i < count($postData); $i++){
                    $allPostData = getAllPostData($postData[$i]);
                    $html .= '<div class="post" name="'.$postData[$i]['id'].'">';
                    $html .=  printPostSquare($allPostData[0], $allPostData[2]);
                    $html .=  printPostPopup($allPostData[0], $allPostData[1], $allPostData[2], $allPostData[3]);
                    $html .=  '</div>';
                }

                return $html;
            }

            function getPostWithCategory(){
                global $profileData, $profileId, $profilePrivatePost, $profilePrivateLike;

                $html = "";

                if(isset($profileData)){ $accountId = $profileId;
                }else{ $accountId = $_SESSION['id']; }

                if(isset($_GET['category'])){
                    if($_GET['category'] == "liked"){
                        if(isset($profileData) && $profilePrivateLike == 0 || isset($profileData) && validSession() && $accountId == $_SESSION['id'] || !isset($profileData) && validSession()){
                            $html = likedPost($accountId);
                            if(empty($html)){
                                $html = '<p style="margin: 25px auto;">Aucun post liké.</p>';
                            }
                        }else{
                            $html = '<p style="margin: 25px auto;">Ce compte a ses publications likés privées.</p>';
                        }
                    }
                    else if($_GET['category'] == "identified"){
                        $html = '<p style="margin: 25px auto;">Non implémenté</p>';
                    }
                }

                if(empty($html)){
                    if(isset($profileData) && $profilePrivatePost == 0 || isset($profileData) && validSession() && $accountId == $_SESSION['id'] || !isset($profileData) && validSession()){
                        $html = publishedPost($accountId);
                        if(empty($html)){
                            $html = '<p style="margin: 25px auto;">Aucune publication.</p>';
                        }
                    }else{
                        $html = '<p style="margin: 25px auto;">Ce compte est privé.</p>';
                    }
                }

                return $html;
            }
    ?>

    <body>
        <div class="main-container">
            <?php 
                include_once("php/side-bar.php");
            ?>
            <div class="container">
                <?php
                    if(isset($_GET['profile']) && $profileCount == 0){
                        include_once("php/error404.php");
                        echo '</div></div>';
                        exit();
                    }
                ?>
                <div class="profile-settings">
                	<?php
                		if(validSession() && ((isset($_GET['profile']) && $_SESSION['id'] === $profileId) || (!isset($_GET['profile'])))){
		                	echo '
		                    <a href="setting.php">
		                        <svg height="32" width="32" viewBox="0 0 24 24">
		                            <circle cx="12" cy="12" fill="none" r="8.635" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
		                            <path d="M14.232 3.656a1.269 1.269 0 0 1-.796-.66L12.93 2h-1.86l-.505.996a1.269 1.269 0 0 1-.796.66m-.001 16.688a1.269 1.269 0 0 1 .796.66l.505.996h1.862l.505-.996a1.269 1.269 0 0 1 .796-.66M3.656 9.768a1.269 1.269 0 0 1-.66.796L2 11.07v1.862l.996.505a1.269 1.269 0 0 1 .66.796m16.688-.001a1.269 1.269 0 0 1 .66-.796L22 12.93v-1.86l-.996-.505a1.269 1.269 0 0 1-.66-.796M7.678 4.522a1.269 1.269 0 0 1-1.03.096l-1.06-.348L4.27 5.587l.348 1.062a1.269 1.269 0 0 1-.096 1.03m11.8 11.799a1.269 1.269 0 0 1 1.03-.096l1.06.348 1.318-1.317-.348-1.062a1.269 1.269 0 0 1 .096-1.03m-14.956.001a1.269 1.269 0 0 1 .096 1.03l-.348 1.06 1.317 1.318 1.062-.348a1.269 1.269 0 0 1 1.03.096m11.799-11.8a1.269 1.269 0 0 1-.096-1.03l.348-1.06-1.317-1.318-1.062.348a1.269 1.269 0 0 1-1.03-.096" fill="none" stroke-linejoin="round" stroke-width="2"/>
		                        </svg>
		                    </a>';
		                }
		                else if(isset($_GET['profile'])){
                			echo '
		                    <svg width="32" height="32" viewBox="0 0 24 24" class="profile-header-option">
		                        <circle cx="12" cy="12" r="1.5"/>
		                        <circle cx="6" cy="12" r="1.5"/>
		                        <circle cx="18" cy="12" r="1.5"/>
		                    </svg>';
		                }
		            ?>
                </div>

				<div class="profile-popup-option-background">
					<div class="profile-popup-option">
                        <?php
                            if(validSession()){
                                $requete = $pdo->prepare("SELECT * FROM account_block WHERE reporter = ?");
                                $requete->execute(array($_SESSION['id']));
                                $reportData = $requete->fetchAll();

                                if(count($reportData) == 0){
                                    echo '<button class="profile-popup-option-block" style="color: #ED4956;">Bloquer</button>';
                                }else{
                                    echo '<button class="profile-popup-option-unblock" style="color: #ED4956;">Débloquer</button>';
                                }

                                $requete = $pdo->prepare("SELECT * FROM account_report WHERE reporter = ?");
                                $requete->execute(array($_SESSION['id']));
                                $reportData = $requete->fetchAll();

                                if(count($reportData) == 0){
                                    echo '<button class="profile-popup-option-report" style="color: #ED4956;">Signaler</button>';
                                }
                            }
                        ?>
						<button class="profile-popup-option-close">Annuler</button>
					</div>
				</div>

                <div class="profile-container">
                    <?php
                        if(isset($profileData)){
                            echo '<img src="'.$profilProfile.'" alt="profile-photo" class="profile-photo">';
                        }else{
                            echo '<img src="'.$_SESSION['profile'].'" alt="profile-photo" class="profile-photo">';
                        }
                    ?>
                    <div class="profile-informations">
                        <ul class="profile-informations-container">
                            <li>
                                <div class="profile-certification">
                                <?php
                                    if(isset($profileData)){
                                        echo '<p class="profile-username">'.$profilePseudo.'</p>';
                                        if($profileVerified == 1){
                                            echo '
                                                <svg style="position: relative; left:10px;" color="rgb(0, 149, 246)" fill="rgb(0, 149, 246)" height="18" role="img" viewBox="0 0 40 40" width="18">
                                                    <path d="M19.998 3.094 14.638 0l-2.972 5.15H5.432v6.354L0 14.64 3.094 20 0 25.359l5.432 3.137v5.905h5.975L14.638 40l5.36-3.094L25.358 40l3.232-5.6h6.162v-6.01L40 25.359 36.905 20 40 14.641l-5.248-3.03v-6.46h-6.419L25.358 0l-5.36 3.094Zm7.415 11.225 2.254 2.287-11.43 11.5-6.835-6.93 2.244-2.258 4.587 4.581 9.18-9.18Z" fill-rule="evenodd"></path>
                                                </svg>';
                                        }
                                    }else{
                                        echo '<p class="profile-username">'.$_SESSION['pseudo'].'</p>';
                                        if($_SESSION['verified'] == 1){
                                            echo '
                                                <svg style="position: relative; left:10px;" color="rgb(0, 149, 246)" fill="rgb(0, 149, 246)" height="18" role="img" viewBox="0 0 40 40" width="18">
                                                    <path d="M19.998 3.094 14.638 0l-2.972 5.15H5.432v6.354L0 14.64 3.094 20 0 25.359l5.432 3.137v5.905h5.975L14.638 40l5.36-3.094L25.358 40l3.232-5.6h6.162v-6.01L40 25.359 36.905 20 40 14.641l-5.248-3.03v-6.46h-6.419L25.358 0l-5.36 3.094Zm7.415 11.225 2.254 2.287-11.43 11.5-6.835-6.93 2.244-2.258 4.587 4.581 9.18-9.18Z" fill-rule="evenodd"></path>
                                                </svg>';
                                        }
                                    }
                                ?>
                                </div>
                                <br>
                                <?php
                                    $requestFollower = $pdo->prepare("SELECT COUNT(*) FROM follow WHERE follower = ? AND follow = 1");
                                    $requestFollowed = $pdo->prepare("SELECT follow FROM follow WHERE followed = ? AND follow = 1");
                                    if(isset($profileData)){
                                        $requestFollower->execute(array($profileId));
                                        $requestFollowed->execute(array($profileId));
                                    }else{
                                        $requestFollower->execute(array($_SESSION['id']));
                                        $requestFollowed->execute(array($_SESSION['id']));
                                    }

                                    $followerCountData = $requestFollower->fetchAll();
                                    $followedCountData = $requestFollowed->fetchAll();
                                ?>

                                <?php
                                    if(isset($profileData) && validSession() && $profileData[0]['id'] != $_SESSION['id']){
                                        $requete = $pdo->prepare("SELECT * FROM account_block WHERE (reporter = ? AND account = ?) OR (reporter = ? AND account = ?)");
                                        $requete->execute(array($_SESSION['id'], $profileId, $profileId, $_SESSION['id']));

                                        $blockData = $requete->fetchAll();

                                        if(count($blockData) == 0){
                                            $requete = $pdo->prepare("SELECT follow FROM follow WHERE follower = ? AND followed = ?");
                                            $requete->execute(array($_SESSION['id'], $profileId));
                                            $followData = $requete->fetchAll();
                                            
                                            if(count($followData) > 0 && $followData[0]['follow'] == 0){
                                                echo '<button class="profile-follow-button">Demandé</button>';
                                                echo '<script>let isWaiting = true; isFollowed = false;</script>';
                                            }
                                            else if(count($followData) > 0 && $followData[0]['follow'] == 1){
                                                echo '<button class="profile-follow-button">Suivi(e)</button>';
                                                echo '<script>let isWaiting = false; isFollowed = true;</script>';
                                            
                                            }else{
                                                echo '<button class="profile-follow-button">Suivre</button>';
                                                echo '<script>let isWaiting = false; isFollowed = false;</script>';
                                            }
                                        }
                                    } 
                                ?>
                                
                            </li>
                            
                            <?php
                                $request = $pdo->prepare("SELECT * FROM post WHERE publisher = ?");
                                if(isset($profileData)){
                                    $request->execute(array($profileId));
                                }else{
                                    $request->execute(array($_SESSION['id']));
                                }
        
                                $postCount = $request->rowCount();
                            ?>

                            <li>
                                <div class="profile-data">
                                    <span><?php echo $postCount; ?> publications</span>
                                    <span class="profile-follower-count"><?php echo count($followedCountData); ?> followers</span>
                                    <span><?php echo $followerCountData[0][0]; ?> suivi(e)s</span>
                                </div>
                            </li>
                        </ul>
                        <div class="profile-bio">
                            <?php
                                if(isset($profileData)){
                                    echo '<p>'.$profileBio.'</p>';
                                }else{
                                    echo '<p>'.$_SESSION['bio'].'</p>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="profile-category-container">
                    <?php
                        $category = array('publication', 'liked', 'identified');

                        if(!isset($_GET['category']) || !in_array($_GET['category'], $category) || $_GET['category'] == "publication"){
                            echo '<a class="profile-category" id="profile-category-selected">';
                        }else{
                            $newUrl = addParameterToUrl($_SERVER['REQUEST_URI'], "category", "publication");
                            echo '<a href="'.$newUrl.'" class="profile-category">';
                        }
                        echo '
                        <svg fill="currentColor" viewBox="0 0 24 24">
                                <rect fill="none" height="18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="18" x="3" y="3"/>
                                <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="9.015" x2="9.015" y1="3" y2="21"/>
                                <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="14.985" x2="14.985" y1="3" y2="21"/>
                                <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="21" x2="3" y1="9.015" y2="9.015"/>
                                <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="21" x2="3" y1="14.985" y2="14.985"/>
                            </svg>
                            <label>PUBLICATIONS</label>
                        </a>';

                        if(isset($_GET['category']) && $_GET['category'] == "liked"){
                            echo '<a class="profile-category" id="profile-category-selected">';
                        }else{
                            $newUrl = addParameterToUrl($_SERVER['REQUEST_URI'], "category", "liked");
                            echo '<a href="'.$newUrl.'" class="profile-category">';
                        }
                        echo '
                        <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"/>
                            </svg>
                            <label>AIMÉS</label>
                        </a>';

                        if(isset($_GET['category']) && $_GET['category'] == "identified"){
                            echo '<a class="profile-category" id="profile-category-selected">';
                        }else{
                            $newUrl = addParameterToUrl($_SERVER['REQUEST_URI'], "category", "identified");
                            echo '<a href="'.$newUrl.'" class="profile-category">';
                        }
                        echo '
                        <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10.201 3.797 12 1.997l1.799 1.8a1.59 1.59 0 0 0 1.124.465h5.259A1.818 1.818 0 0 1 22 6.08v14.104a1.818 1.818 0 0 1-1.818 1.818H3.818A1.818 1.818 0 0 1 2 20.184V6.08a1.818 1.818 0 0 1 1.818-1.818h5.26a1.59 1.59 0 0 0 1.123-.465Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                <path d="M18.598 22.002V21.4a3.949 3.949 0 0 0-3.948-3.949H9.495A3.949 3.949 0 0 0 5.546 21.4v.603" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                <circle cx="12.072" cy="11.075" fill="none" r="3.556" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            </svg>
                            <label>IDENTIFIÉ(E)</label>
                        </a>';
                    ?>
                </div>
                <div class="profile-post">
                    <?php
                        if(isset($profileData) && validSession()){
                            $requete = $pdo->prepare("SELECT * FROM follow WHERE follower = ? AND followed = ?");
                            $requete->execute(array($_SESSION['id'], $profileId));

                            $followData = $requete->fetchAll();

                            if(isset($blockData) && count($blockData) > 0){
                                if($blockData[0]['reporter'] == $_SESSION['id']) {
                                    echo '<p style="margin: 25px auto;">Vous avez bloqué ce compte.</p>';
                                }
                                else{
                                    echo '<p style="margin: 25px auto;">Ce compte vous a bloqué.</p>';
                                }
                            }else{
                                echo getPostWithCategory();
                            }
                        }else{
                            echo getPostWithCategory();
                        }
                    ?>
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

<script src="js/profile.js"></script>
<script src="js/side-bar.js"></script>
<script src="js/post.js"></script>