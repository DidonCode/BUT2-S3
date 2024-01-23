<?php
    require_once("database.php");
    include_once("session.php");
    include_once("function.php");

    function getAllPostData($postData) {
        global $pdo;

        $requete = $pdo->prepare("SELECT pseudo, profile FROM account WHERE id = ?");
        $requete->execute(array($postData['publisher']));
        $accountData = $requete->fetchAll();

        $commentData = null;
        if(isset($postData['enableComment']) && $postData['enableComment'] == 1){
            $requete = $pdo->prepare("SELECT * FROM post_comment WhERE post = ?");
            $requete->execute(array($postData['id']));
            $commentData = $requete->fetchAll();
        }

        if(validSession()){
            $requete = $pdo->prepare("SELECT * FROM post_like WHERE post = ? AND account = ?");
            $requete->execute(array($postData['id'], $_SESSION['id']));
            $userData = $requete->fetchAll();

            if(count($userData) > 0){
                $userLike = $userData[0]['love'];
            }else{
                $userLike = 0;
            }
        }else{
            $userLike = 0;
        }

        $requete = $pdo->prepare("SELECT COUNT(*) FROM post_like WHERE post = ? AND love = 1");
        $requete->execute(array($postData['id']));
        $postLike = $requete->fetchAll();

        return array(0 => $postData, 1 => $accountData, 2 => $commentData, 3 => $userLike, 4 => $postLike);
    }

    function printPost($postData, $accountData, $commentData, $userLike, $postLike) {
        $postId = $postData['id'];
        $postContent = $postData['content'];
        $postType = $postData['contentType'];
        $postDescription = $postData['description'];
        $postSpot = $postData['spot'];
        $postDate = $postData['date'];

        $accountProfile = $accountData[0]['profile'];
        $accountName = $accountData[0]['pseudo'];

        $htmlData = "";

        $htmlData .= '
        <div class="post" name="'.$postId.'">
            <div class="post-header">
                <a href="profile.php?profile='.$accountName.'" class="post-header-account">
                    <img src="'.$accountProfile.'" class="post-header-profile">
                    <div class="post-header-information">
                        <p class="post-publisher">'.$accountName.' • '.dateDiffActually($postDate).'</p>
                        <p class="post-spot">'.htmlspecialchars($postSpot).'</p>
                    </div>
                </a>
                <svg height="24" width="24" viewBox="0 0 24 24" class="post-header-option">
                    <circle cx="12" cy="12" r="1.5"/>
                    <circle cx="6" cy="12" r="1.5"/>
                    <circle cx="18" cy="12" r="1.5"/>
                </svg>
            </div>
            <div class="post-content">';
                if($postType == "image"){
                    $htmlData .= '<img src="'.$postContent.'">';
                }
                else if($postType == "video"){
                    $htmlData .= '<video muted autoplay loop>
                        <source src="'.$postContent.'" type="video/mp4"/>
                        </video>
                        <div class="mute-sound-post">
                            <svg height="12" width="12" viewBox="0 0 48 48">
                                <path clip-rule="evenodd" d="M1.5 13.3c-.8 0-1.5.7-1.5 1.5v18.4c0 .8.7 1.5 1.5 1.5h8.7l12.9 12.9c.9.9 2.5.3 2.5-1v-9.8c0-.4-.2-.8-.4-1.1l-22-22c-.3-.3-.7-.4-1.1-.4h-.6zm46.8 31.4-5.5-5.5C44.9 36.6 48 31.4 48 24c0-11.4-7.2-17.4-7.2-17.4-.6-.6-1.6-.6-2.2 0L37.2 8c-.6.6-.6 1.6 0 2.2 0 0 5.7 5 5.7 13.8 0 5.4-2.1 9.3-3.8 11.6L35.5 32c1.1-1.7 2.3-4.4 2.3-8 0-6.8-4.1-10.3-4.1-10.3-.6-.6-1.6-.6-2.2 0l-1.4 1.4c-.6.6-.6 1.6 0 2.2 0 0 2.6 2 2.6 6.7 0 1.8-.4 3.2-.9 4.3L25.5 22V1.4c0-1.3-1.6-1.9-2.5-1L13.5 10 3.3-.3c-.6-.6-1.5-.6-2.1 0L-.2 1.1c-.6.6-.6 1.5 0 2.1L4 7.6l26.8 26.8 13.9 13.9c.6.6 1.5.6 2.1 0l1.4-1.4c.7-.6.7-1.6.1-2.2z" fill-rule="evenodd"/>
                            </svg>
                            <svg height="12" width="12" viewBox="0 0 24 24" style="display: none">
                                <path d="M16.636 7.028a1.5 1.5 0 1 0-2.395 1.807 5.365 5.365 0 0 1 1.103 3.17 5.378 5.378 0 0 1-1.105 3.176 1.5 1.5 0 1 0 2.395 1.806 8.396 8.396 0 0 0 1.71-4.981 8.39 8.39 0 0 0-1.708-4.978Zm3.73-2.332A1.5 1.5 0 1 0 18.04 6.59 8.823 8.823 0 0 1 20 12.007a8.798 8.798 0 0 1-1.96 5.415 1.5 1.5 0 0 0 2.326 1.894 11.672 11.672 0 0 0 2.635-7.31 11.682 11.682 0 0 0-2.635-7.31Zm-8.963-3.613a1.001 1.001 0 0 0-1.082.187L5.265 6H2a1 1 0 0 0-1 1v10.003a1 1 0 0 0 1 1h3.265l5.01 4.682.02.021a1 1 0 0 0 1.704-.814L12.005 2a1 1 0 0 0-.602-.917Z"/>
                            </svg>
                        </div>
                    ';
                }
        $htmlData .= '
        </div>
        <div class="post-footer">
            <div class="post-actions">
                <button class="post-action-like">';
                    if($userLike == 0){
                        $htmlData .= '<svg height="24" width="24" viewBox="0 0 24 24" class="post-like-style" style="display: block">';
                    }else{
                        $htmlData .= '<svg height="24" width="24" viewBox="0 0 24 24" class="post-like-style" style="display: none">';
                    }
                    $htmlData .= '
                    <path d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 	2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 	6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 	45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"/>
                    </svg>';

                    if($userLike == 0){
                        $htmlData .= '<svg height="24" width="24" viewBox="0 0 48 48" class="post-like-style" style="display: none; fill: rgb(255, 48, 64)">';
                    }else{
                        $htmlData .= '<svg height="24" width="24" viewBox="0 0 48 48" class="post-like-style" style="display: block; fill: rgb(255, 48, 64)">';
                    }
                    $htmlData .= '
                        <path d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"/>
                    </svg>
                </button>
                <button class="post-action-comment">
                    <svg height="24" width="24" viewBox="0 0 24 24">
                        <path d="M20.656 17.008a9.993 9.993 0 1 0-3.59 3.615L22 22Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                </button>
            </div>
            <p class="post-like"><span class="post-like-counter">'.$postLike[0][0].'</span> J\'aime</p>';
            if(!empty($postDescription)){
                $htmlData .= '<p class="post-description"><span style="font-weight: 600;">'.$accountName.'</span> '.htmlspecialchars($postDescription).'</p>';
            }
        $htmlData .= '</div>';

        $htmlData .= printPostPopup($postData, $accountData, $commentData, $userLike);

        $htmlData .= '</div>';

        return $htmlData;
    }

    function printPostSquare($postData, $commentData) {
        global $pdo;

        $postContent = $postData['content'];
        $postType = $postData['contentType'];

        $htmlData = "";

        $htmlData .= '<div class="post-content">';

        if($postType == "image"){
            $htmlData .= '<img src="'.$postContent.'">';
        }
        else if($postType == "video"){
            $htmlData .= '<video>
                    <source src="'.$postContent.'" type="video/mp4"/>
                </video>
            ';
        };

        $htmlData .= '<div class="post-preview-stat">';

        $htmlData .= '<div class="post-preview-stat-container">';

        $htmlData .= '<div class="post-preview-stat-stats">';

        $htmlData .= '<svg height="24" width="24" viewBox="0 0 48 48" class="post-like-style" stroke="none" d>
                        <path d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"/>
                    </svg>';

        $requete = $pdo->prepare("SELECT count(*) FROM post_like WHERE post = ? AND love = 1");
        $requete->execute(array($postData['id']));
        $likeData = $requete->fetchAll();

        $htmlData .= '<p>'.$likeData[0][0].'</p>';
        
        $htmlData .= '</div>';
        $htmlData .= '<div class="post-preview-stat-stats">';

        $htmlData .= '<svg height="24" width="24" viewBox="0 0 24 24">
                        <path d="M20.656 17.008a9.993 9.993 0 1 0-3.59 3.615L22 22Z" fill="white" stroke="white" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>';

        if(isset($commentData)){
            $htmlData .= '<p>'.count($commentData).'</p>';
        }else{
            $htmlData .= '<p>0</p>';
        }

        $htmlData .= '</div>';
        $htmlData .= '</div>';
        $htmlData .= '</div>';
        $htmlData .= '</div>';

        return $htmlData;
    }

    function printPostPopup($postData, $accountData, $commentData, $userLike) {
        global $pdo;

        $postId = $postData['id'];
        $postPublisher = $postData['publisher'];
        $postContent = $postData['content'];
        $postType = $postData['contentType'];
        $postDescription = $postData['description'];
        $postSpot = $postData['spot'];
        $postDate = $postData['date'];
        $postCommentEnable = $postData['enableComment'];

        $accountProfile = $accountData[0]['profile'];
        $accountName = $accountData[0]['pseudo'];

        $htmlData = "";

        $htmlData .= '
            <div class="post-popup-background">
                <div class="post-popup">
                    <div class="post-popup-container">
                        <div class="post-popup-content">';
                            if($postType == "image"){
                                $htmlData .= '<img src="'.$postContent.'">';
                            }
                            else if($postType == "video"){
                                $htmlData .= '<video muted autoplay loop>
                                    <source src="'.$postContent.'" type="video/mp4"/>
                                    </video>
                                    <div class="mute-sound-post">
                                        <svg height="12" width="12" viewBox="0 0 48 48" style="display: block">
                                            <path clip-rule="evenodd" d="M1.5 13.3c-.8 0-1.5.7-1.5 1.5v18.4c0 .8.7 1.5 1.5 1.5h8.7l12.9 12.9c.9.9 2.5.3 2.5-1v-9.8c0-.4-.2-.8-.4-1.1l-22-22c-.3-.3-.7-.4-1.1-.4h-.6zm46.8 31.4-5.5-5.5C44.9 36.6 48 31.4 48 24c0-11.4-7.2-17.4-7.2-17.4-.6-.6-1.6-.6-2.2 0L37.2 8c-.6.6-.6 1.6 0 2.2 0 0 5.7 5 5.7 13.8 0 5.4-2.1 9.3-3.8 11.6L35.5 32c1.1-1.7 2.3-4.4 2.3-8 0-6.8-4.1-10.3-4.1-10.3-.6-.6-1.6-.6-2.2 0l-1.4 1.4c-.6.6-.6 1.6 0 2.2 0 0 2.6 2 2.6 6.7 0 1.8-.4 3.2-.9 4.3L25.5 22V1.4c0-1.3-1.6-1.9-2.5-1L13.5 10 3.3-.3c-.6-.6-1.5-.6-2.1 0L-.2 1.1c-.6.6-.6 1.5 0 2.1L4 7.6l26.8 26.8 13.9 13.9c.6.6 1.5.6 2.1 0l1.4-1.4c.7-.6.7-1.6.1-2.2z" fill-rule="evenodd"/>
                                        </svg>
                                        <svg height="12" width="12" viewBox="0 0 24 24" style="display: none">
                                            <path d="M16.636 7.028a1.5 1.5 0 1 0-2.395 1.807 5.365 5.365 0 0 1 1.103 3.17 5.378 5.378 0 0 1-1.105 3.176 1.5 1.5 0 1 0 2.395 1.806 8.396 8.396 0 0 0 1.71-4.981 8.39 8.39 0 0 0-1.708-4.978Zm3.73-2.332A1.5 1.5 0 1 0 18.04 6.59 8.823 8.823 0 0 1 20 12.007a8.798 8.798 0 0 1-1.96 5.415 1.5 1.5 0 0 0 2.326 1.894 11.672 11.672 0 0 0 2.635-7.31 11.682 11.682 0 0 0-2.635-7.31Zm-8.963-3.613a1.001 1.001 0 0 0-1.082.187L5.265 6H2a1 1 0 0 0-1 1v10.003a1 1 0 0 0 1 1h3.265l5.01 4.682.02.021a1 1 0 0 0 1.704-.814L12.005 2a1 1 0 0 0-.602-.917Z"/>
                                        </svg>
                                    </div>
                                ';
                            };
                        $htmlData .= '
                        </div>
                        <div class="post-popup-comment">
                            <div class="post-popup-header">
                                <a href="profile.php?profile='.$accountName.'" class="post-popup-header-account">
                                    <img src="'.$accountProfile.'" class="post-popup-header-profile">
                                    <div class="post-popup-header-information">
                                        <p class="post-popup-publisher">'.$accountName.' • '.dateDiffActually($postDate).'</p>
                                        <p class="post-popup-spot">'.htmlspecialchars($postSpot).'</p>
                                    </div>
                                </a>
                                <svg height="24" width="24" viewBox="0 0 24 24" class="post-header-option">
                                    <circle cx="12" cy="12" r="1.5"/>
                                    <circle cx="6" cy="12" r="1.5"/>
                                    <circle cx="18" cy="12" r="1.5"/>
                                </svg>
                            </div>';

                            if(!empty($postDescription)){
                                $htmlData .= '<p class="post-description">'.htmlspecialchars($postDescription).'</p>';
                            }

                        $htmlData .= '
                            <hr style="border: 0.1px solid var(--border-color); margin-top: 15px; margin-bottom: 20px;">

                            <div class="post-popup-comment-container">';
                            if(isset($postCommentEnable) && $postCommentEnable == 1){
                                for($i = 0; $i < count($commentData); $i++){
                                    $requete = $pdo->prepare("SELECT pseudo, profile FROM account WHERE id = ?");
                                    $requete->execute(array($commentData[$i]['publisher']));
                                    $commentAccountData = $requete->fetchAll();

                                    $commentAccountProfile = $commentAccountData[0]['profile'];
                                    $commentAccountName = $commentAccountData[0]['pseudo'];

                                    $commentMessage = $commentData[$i]['message'];
                                    $commentDate = $commentData[$i]['date'];

                                    $htmlData .= '
                                    <div class="post-popup-comment-header">
                                        <img src="'.$commentAccountProfile.'" class="post-popup-header-comment-profile">
                                        <div class="post-popup-comment-header-information">
                                            <p class="post-popup-comment-publisher">'.$commentAccountName.' • '.dateDiffActually($commentDate).'</p>
                                            <p class="post-popup-comment-message">'.htmlspecialchars($commentMessage).'</p>
                                        </div>';

                                    if(validSession() && $commentData[$i]['publisher'] == $_SESSION['id']){
                                        $htmlData .= '
                                        <svg height="16" width="14" viewBox="0 0 448 512" fill="currentColor">
                                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                            </svg>';
                                    }

                                    $htmlData .= ' </div>';
                                }
                            }
                            else{
                                $htmlData .= '<p class="post-popup-comment-alert">Les commentaires ont été désactivé !</p>';
                            }

                            $htmlData .= '
                            </div>
                            
                            <div class="post-actions">
                                <button class="post-action-like">';
                                    if($userLike == 0){
                                        $htmlData .= '<svg height="24" width="24" viewBox="0 0 24 24" class="post-like-style" style="display: block">';
                                    }else{
                                        $htmlData .= '<svg height="24" width="24" viewBox="0 0 24 24" class="post-like-style" style="display: none">';
                                    }
                                    $htmlData .= '
                                    <path d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 	2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 	6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 	45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"/>
                                    </svg>';

                                    if($userLike == 0){
                                        $htmlData .= '<svg height="24" width="24" viewBox="0 0 48 48" class="post-like-style" style="display: none; fill: rgb(255, 48, 64)">';
                                    }else{
                                        $htmlData .= '<svg height="24" width="24" viewBox="0 0 48 48" class="post-like-style" style="display: block; fill: rgb(255, 48, 64)">';
                                    }
                                    $htmlData .= '
                                        <path d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"/>
                                    </svg>
                                </button>';

                            if(isset($postCommentEnable) && $postCommentEnable == 1){
                                     $htmlData .= '
                                    <button class="post-action-comment">
                                        <svg height="24" width="24" viewBox="0 0 24 24">
                                            <path d="M20.656 17.008a9.993 9.993 0 1 0-3.59 3.615L22 22Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2"/>
                                        </svg>
                                    </button>';
                            }

                            $htmlData .= '</div>';

                            if(isset($postCommentEnable) && $postCommentEnable == 1){
                                 $htmlData .= '
                                <form action="php/api.php" method="POST" class="post-popup-comment-form">
                                    <input type="text" class="post-popup-comment-input" placeholder="Ajouter un commentaire..." autocomplete="off" name="comment">
                                    <input type="hidden" style="display: none" name="post" value="'.$postId.'"> 
                                </form>';
                            }
                        $htmlData .= '
                        </div>
                    </div>
                    <button class="post-popup-close">
                        <svg height="18" width="18" viewBox="0 0 24 24" color="rgb(255, 255, 255)" fill="rgb(255, 255, 255)">
                            <polyline fill="none" points="20.643 3.357 12 12 3.353 20.647" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
                            <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" x1="20.649" x2="3.354" y1="20.649" y2="3.354"/>
                        </svg>
                    </button>
                </div>
            </div>';
            
            $htmlData .= '
            <div class="post-popup-option-background">
                <div class="post-popup-option">';
                    if(validSession()){
                        $requete = $pdo->prepare("SELECT * FROm post_report WhERE reporter = ? AND post = ?");
                        $requete->execute(array($_SESSION['id'], $postId));
                        $reportCount = $requete->rowCount();

                        if($reportCount == 0 && $postPublisher != $_SESSION['id']){
                            $htmlData .= '<button class="post-popup-option-report" style="color: #ED4956;">Signaler</button>';
                        }
                    }
                    if(validSession() && $_SESSION['id'] == $postPublisher){
                        $htmlData .= '<button class="post-popup-option-delete" style="color: #ED4956;">Supprimer</button>';
                    }
                $htmlData .= '
                    <button><a href="post.php?post='.$postId.'">Accéder à la publication</a></button>
                    <button class="post-popup-option-close">Annuler</button>
                </div>
            </div>';
        return $htmlData;
    }
?>