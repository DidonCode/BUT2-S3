<?php
    require_once("api.php");
    include_once("post-function.php");
    include_once("api.php");

    function generateNotification($id, $notified, $notifier, $type, $post, $comment, $view){
        global $pdo;

        $notifierData = accountExist($notifier);
        $postData = postExist($post);
        $commentData = commentExist($comment);

        if(accountExist($notified) == null || $notifierData == null || ($post >= 0 && $postData == null) || ($comment >= 0 && $commentData == null)){ 
            deleteNotification($id);
            return "";
        }
        
        if($view == 0){
            $requete = $pdo->prepare("UPDATE notification SET view = 1 WHERE id = ?");
            $requete->execute(array($id));
        }

        switch($type) {
            case 0:
                return generatePrivateFollowNotification($notifierData['profile'], $notifierData['pseudo']);
                break;

            case 1:
                return generateFollowNotification($notifierData['profile'], $notifierData['pseudo']);
                break;

            case 2:
                return generatePostCommentNotification($notifierData['profile'], $notifierData['pseudo'], $postData['id'], $commentData['message']);
                break;

            case 3:
                //return generatePostLikeNotification($notifierData['profile'], $notifierData['pseudo'], $postData['id']);
                break;
            
            default:
                throw new Exception("Undefined notification type.");
                break;
        }
    }

    //---------------ACCOUNT-FUNCTION---------------\\

    function generatePrivateFollowNotification($accountFollowerProfil, $accountFollowerPseudo){
        $content = '
            <div class="notification-information">
                <?php echo "aaa"; ?><img src="'.$accountFollowerProfil.'">
                <p>'.$accountFollowerPseudo.' a demandé à suivre votre compte.</p>
            </div>
            <button class="notification-accept" onclick="responceFollow(this, '.'\''.$accountFollowerPseudo.'\', 1)">Confirmer</button>
            <button class="notification-refuse" onclick="responceFollow(this, '.'\''.$accountFollowerPseudo.'\', 0)">Supprimer</button>
        ';

        return $content;
    }

    function generateFollowNotification($accountFollowerProfil, $accountFollowerPseudo){
        $content = '
            <div class="notification-information">
                <img src="'.$accountFollowerProfil.'">
                <p>'.$accountFollowerPseudo.' a commencé à suivre votre compte.</p>
            </div>
        ';

        return $content;
    }

    //---------------POST-FUNCTION---------------\\

    function generatePostCommentNotification($accountCommentProfil, $accountCommentPseudo, $postCommentId, $postComment){
        $content = '
            <div class="notification-information">
                <img src="'.$accountCommentProfil.'">
                <p>'.$accountCommentPseudo.' a commenté l\'une de vos publications: '.$postComment.'</p>
            </div>
            <button class="notification-accept" onclick="window.location.href=\'post.php?post='.$postCommentId.'\'">Voir</button>
        ';

        return $content;
    }

    function generatePostLikeNotification($accountCommentProfil, $accountCommentPseudo, $postLikeId){
        $content = '
            <div class="notification-information">
                <img src="'.$accountCommentProfil.'">
                <p>'.$accountCommentPseudo.' a aimé l\'une de vos publications.</p>
            </div>
            <button class="notification-accept" onclick="window.location.href=\'post.php?post='.$postLikeId.'\'">Voir</button>
        ';

        return $content;
    }
?>