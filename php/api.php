<?php

    require_once("database.php");
    include_once("session.php");
    include_once("function.php");
    include_once("notification-function.php");
    include_once("post-function.php");
    include_once("message-function.php");
    include_once("popup-function.php");

    // if(!validSession()){
    //     header("Location: form.php");
    //     exit();
    // }

    //---------------MORE-FUNCTION---------------\\

    function postExist($postId){
        global $pdo;

        $requete = $pdo->prepare("SELECT * FROM post WHERE id = ?");
        $requete->execute(array($postId));

        $postData = $requete->fetchAll();

        if(count($postData) > 0){
            return $postData[0];
        }

        return null;
    }

    function accountExist($accountId){
        global $pdo;

        $requete = $pdo->prepare("SELECT id, email, pseudo, fullName, bio, privatePost, privateLike, verified, admin, profile FROM account WHERE id = ?");
        $requete->execute(array($accountId));

        $accountData = $requete->fetchAll();

        if(count($accountData) > 0){
            return $accountData[0];
        }

        return null;
    }

    function commentExist($commentId){
        global $pdo;

        $requete = $pdo->prepare("SELECT * FROM post_comment WHERE id = ?");
        $requete->execute(array($commentId));

        $commentData = $requete->fetchAll();

        if(count($commentData) > 0){
            return $commentData[0];
        }

        return null;
    }

    //---------------UPDATE-FUNCTION---------------\\

    function updateFollow($accountFollowedId, $accountFollowId, $state){
        global $pdo;

        try {
            $requete = $pdo->prepare("SELECT * FROM follow WHERE follower = ? AND followed = ?");
            $requete->execute(array($accountFollowId, $accountFollowedId));
            $exist = $requete->rowCount();

            if($exist > 0){
                try {
                    $requete = $pdo->prepare("UPDATE follow SET follow = ? WHERE follower = ? AND followed = ?");
                    $requete->execute(array($state, $accountFollowId, $accountFollowedId));

                } catch (PDOException $e) {
                    throw new Exception("Error on updating follow. ".$e->getMessage());
                }
            }else{
                throw new Exception("Follow line not found.");
            }
        } catch (PDOException $e) {
            throw new Exception("Error on find follow line. ".$e->getMessage());
        }
    }

    //---------------DELETE-FUNCTION---------------\\

    function deleteAccountBlock($accountId, $reporterId){
        global $pdo;

        if(accountExist($accountId) == null){
            throw new Exception("Account not found."); 
        }

        try {
            $requete = $pdo->prepare("SELECT * FROM account_block WHERE reporter = ? AND account = ?");
            $requete->execute(array($reporterId, $accountId));
            $existCount = $requete->rowCount();

            if($existCount > 0){
                $requete = $pdo->prepare("DELETE FROM account_block WHERE reporter = ? AND account = ?");
                $requete->execute(array($reporterId, $accountId));

                return true;
            }else{
                throw new Exception("Account block line not found.");
            }
        } catch (PDOException $e){
            throw new Exception("Error on find account block line. ".$e->getMessage());
        }
    }

    function deletePost($postId){
        global $pdo;

        try{
            $requete = $pdo->prepare("SELECT content FROM post WHERE id = ?");
            $requete->execute(array($postId));
            $postData = $requete->fetchAll();
            
            if(count($postData) > 0){
                unlink("../".$postData[0]['content']);
            }

            try {
                $requete = $pdo->prepare("CALL deletePost(?)");
                $requete->execute(array($postId));

                return true;
            } catch (PDOException $e) {
                throw new Exception("Error on deleting post data. ".$e->getMessage());
            }
        }catch(PDOException $e){
            throw new Exception("Error on deleting post file. ".$e->getMessage());
        }

    }

    function deleteFollow($accountFollowedId, $accountFollowId){
        global $pdo;

        try {
            $requete = $pdo->prepare("SELECT * FROM follow WHERE follower = ? AND followed = ?");
            $requete->execute(array($accountFollowId, $accountFollowedId));
            $exist = $requete->rowCount();

            if($exist > 0){

                try{
                    $requete = $pdo->prepare("DELETE FROM follow WHERE follower = ? AND followed = ?");
                    $requete->execute(array($accountFollowId, $accountFollowedId));

                    return true;

                } catch (PDOException $e) {
                    throw new Exception("Error on deleting follow. ".$e->getMessage());
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Error on find follow line. ".$e->getMessage());
        }

    }

    function deleteLike($postId, $accountId){
        global $pdo;

        try {
            $requete = $pdo->prepare("SELECT * FROM post_like WHERE post = ? AND account = ?");
            $requete->execute(array($postId, $accountId));
            $postData = $requete->fetchAll();

            if(isset($postData) && count($postData) > 0){
                if($postData[0]['love'] == 0){
                    return true;
                }

                try{
                    $requete = $pdo->prepare("UPDATE post_like SET love = ? WHERE post = ? AND account = ?");
                    $requete->execute(array(0, $postId, $accountId));

                    return true;
                } catch (PDOException $e) {
                    throw new Exception("Error on updating post like. ".$e->getMessage());
                }
            }else{
                throw new Exception("Post like line not found.");
            }
        } catch (PDOException $e) {
            throw new Exception("Error on find post like line. ".$e->getMessage());
        }
    }

    function deleteNotification($notificationId){
        global $pdo;

        try {
            $requete = $pdo->prepare("DELETE FROM notification WHERE id = ?");
            $requete->execute(array($notificationId));

            return true;
        } catch (PDOException $e){
            throw new Exception("Error on delete notification. ".$e->getMessage());
        }
    }

    function deleteComment($commentId){
        global $pdo;

        if(commentExist($commentId) == null){
            throw new Exception("Comment not found.");
        }

        try {
            $requete = $pdo->prepare("DELETE FROM post_comment WHERE id = ?");
            $requete->execute(array($commentId));

            return true;
        } catch (PDOException $e){
            throw new Exception("Error on delete notification. ".$e->getMessage());
        }
    }

    //---------------GET-FUNCTION---------------\\

    function getResearch($researchValue){
        global $pdo;

        if(validSession()){
            $requete = $pdo->prepare("SELECT pseudo, profile FROM account WHERE pseudo LIKE ? AND id != ?");
            $requete->execute(array($researchValue, $_SESSION['id']));
        }
        else{
            $requete = $pdo->prepare("SELECT pseudo, profile FROM account WHERE pseudo LIKE ?");
            $requete->execute(array($researchValue));
        }

        $searchData = $requete->fetchAll();

        if(count($searchData) > 0){
            return $searchData;
        }

        return null;
    }

    function getPosts($limit, $condition){
        global $pdo;

        $sql = "SELECT * FROM post ";

        if(isset($condition)){
            for($i = 0; $i < count($condition); $i++){
                if(!filter_var($condition[$i], FILTER_VALIDATE_INT)){
                    throw new Exception("Error with id to get post.");
                }

                if($i == 0){
                    $sql .= "WHERE id != ".$condition[$i]." AND ";
                }
                elseif($i == count($condition) - 1){
                    $sql .= "id != ".$condition[$i]." ";
                }
                else{
                    $sql .= "id != ".$condition[$i]." AND ";
                }
            }
        }

        $sql .= "LIMIT $limit";

        $requete = $pdo->prepare($sql);
        $requete->execute();
        $postData = $requete->fetchAll();

        $htmlData = array();

        if(count($postData) > 0){
            for($i = 0; $i < count($postData); $i++){
                $postAllData = getAllPostData($postData[$i]);
                array_push($htmlData, printPost($postAllData[0], $postAllData[1], $postAllData[2], $postAllData[3], $postAllData[4]));
            }

            return $htmlData;
        }else{
            return null;
        }
    }

    function getMessages($senderId, $receiverId, $limit, $dateCondition){
        global $pdo;

        $sql = "SELECT * FROM message WHERE (sender = ? OR receiver = ?) AND (sender = ? OR receiver = ?) ";

        if(isset($dateCondition)){
            $sql .= "AND STR_TO_DATE(date, '%H:%i:%s %d-%m-%Y') < STR_TO_DATE('".$dateCondition."', '%H:%i:%s %d-%m-%Y') ";
        }

        $sql .= "ORDER BY STR_TO_DATE(date, '%H:%i:%s %d-%m-%Y') DESC LIMIT ".$limit;

        $requete = $pdo->prepare($sql);
        $requete->execute(array($receiverId, $receiverId, $senderId, $senderId));
        $messageData = $requete->fetchAll();
        $messageData = array_reverse($messageData);

        return $messageData;
    }

    function getMessageView($senderId, $receiverId){
        global $pdo;

        $requete = $pdo->prepare("SELECT * FROM message WHERE sender = ? AND receiver = ? ORDER BY STR_TO_DATE(date, '%H:%i:%s %d-%m-%Y') DESC LIMIT 1");
        $requete->execute(array($senderId, $receiverId));
        $messageData = $requete->fetchAll();
        $messageData = array_reverse($messageData);

        return $messageData;
    }

    //---------------ADD-FUNCTION---------------\\

    function addMessage($senderId, $receiverId, $message){
        global $pdo;

        if(accountExist($senderId) == null){
            throw new Exception("Sender account not found."); 
        }

        if(accountExist($receiverId) == null){
            throw new Exception("Receiver account not found."); 
        }

        try{
            $requete = $pdo->prepare("INSERT INTO message (id, sender, receiver, message, date, view) VALUES ('0', ?, ?, ?, ?, 0)");
            $requete->execute(array($senderId, $receiverId, $message, getActuallyDate()));

            return true;
        } catch (PDOException $e){
            throw new Exception("Error on insert message. ".$e->getMessage());
        }
    }

    function addAccountBlock($accountId, $reporterId){
        global $pdo;

        if(accountExist($accountId) == null){
            throw new Exception("Account not found."); 
        }

        try {
            $requete = $pdo->prepare("SELECT * FROM account_block WHERE reporter = ? AND account = ?");
            $requete->execute(array($reporterId, $accountId));
            $existCount = $requete->rowCount();

            if($existCount == 0){
                $requete = $pdo->prepare("INSERT INTO account_block (reporter, account) VALUES (?, ?)");
                $requete->execute(array($reporterId, $accountId));

                try{
                    deleteFollow($accountId, $reporterId);
                    deleteFollow($reporterId, $accountId);
                } catch (PDOException $e){

                }

                return true;
            }else{
                return true;
            }
        } catch (PDOException $e){
            throw new Exception("Error on find account block line. ".$e->getMessage());
        }
    }

    function addAccountReport($accountId, $reporterId){
        global $pdo;

        if(accountExist($accountId) == null){
            throw new Exception("Account not found."); 
        }

        try {
            $requete = $pdo->prepare("SELECT * FROM account_report WHERE reporter = ? AND account = ?");
            $requete->execute(array($reporterId, $accountId));
            $existCount = $requete->rowCount();

            if($existCount == 0){
                $requete = $pdo->prepare("INSERT INTO account_report (reporter, account) VALUES (?, ?)");
                $requete->execute(array($reporterId, $accountId));

                return true;
            }else{
                return true;
            }
        } catch (PDOException $e){
            throw new Exception("Error on find account report line. ".$e->getMessage());
        }
    }

    function addPostReport($postId, $reporterId){
        global $pdo;

        if(postExist($postId) == null){
            throw new Exception("Post not found."); 
        }

        if(accountExist($reporterId) == null){
            throw new Exception("Reporter account not found.");
        }

        try {
            $requete = $pdo->prepare("SELECT * FROM post_report WHERE reporter = ? AND post = ?");
            $requete->execute(array($reporterId, $postId));
            $existCount = $requete->rowCount();

            if($existCount == 0){
                $requete = $pdo->prepare("INSERT INTO post_report (reporter, post) VALUES (?, ?)");
                $requete->execute(array($reporterId, $postId));

                return true;
            }else{
                return true;
            }
        } catch (PDOException $e){
            throw new Exception("Error on find post report line. ".$e->getMessage());
        }
    }

    function addNotification($notified, $notifier, $type, $post, $comment){
        global $pdo;

        if(accountExist($notified) == null || accountExist($notifier) == null){
            throw new Exception("Account not found.");
        }

        try {
            $requete = $pdo->prepare("INSERT INTO notification (id, notified, notifier, type, post, comment) VALUES ('0', ?, ?, ?, ?, ?)");
            $requete->execute(array($notified, $notifier, $type, $post, $comment));

            return true;
        } catch (PDOException $e){
            throw new Exception("Error on insert notification. ".$e->getMessage());
        }
    }

    function addLike($postId, $accountId){
        global $pdo;

         if(postExist($postId) == null){
            throw new Exception("Post not found."); 
        }

        if(accountExist($accountId) == null){
            throw new Exception("Account not found.");
        }

        try {
            $requete = $pdo->prepare("SELECT * FROM post_like WHERE post = ? AND account = ?");
            $requete->execute(array($postId, $accountId));
            $postData = $requete->fetchAll();

            if(count($postData) > 0){
                if($postData[0]['love'] == 1){
                    return true;
                }

                try {
                    $requete = $pdo->prepare("UPDATE post_like SET love = ? WHERE post = ? AND account = ?");
                    $requete->execute(array(1, $postId, $accountId));

                    return true;
                } catch (PDOException $e){
                    throw new Exception("Error on updating post like line. ".$e->getMessage());
                }
            }
            else{
                try {
                    $requete = $pdo->prepare("INSERT INTO post_like (id, post, account, love) VALUES ('0', ?, ?, ?)");
                    $requete->execute(array($postId, $accountId, 1));

                    return true;
                } catch (PDOException $e){
                    throw new Exception("Error on insert post like line. ".$e->getMessage());
                }
            }
        } catch (PDOException $e){
            throw new Exception("Error on find post like line. ".$e->getMessage());
        }
    }

    function addComment($postId, $accountId, $comment){
        global $pdo;

        $postData = postExist($postId);
        if($postData == null){
            throw new Exception("Post not found."); 
        }

        if(accountExist($accountId) == null){
            throw new Exception("Account not found.");
        }

        try {
            $date = getActuallyDate();

            $requete = $pdo->prepare("INSERT INTO post_comment (id, post, publisher, message, date) VALUES (0, ?, ?, ?, ?)");
            $requete->execute(array($postId, $accountId, $comment, $date));

            $requete = $pdo->prepare("SELECT id FROM post_comment WHERE post = ? AND publisher = ? AND message = ? AND date = ?");
            $requete->execute(array($postId, $accountId, $comment, $date));
            $commentData = $requete->fetchAll();

            if(count($commentData) > 0 && $postData['publisher'] != $_SESSION['id']){
                addNotification($postData['publisher'], $_SESSION['id'], 2, $postId, $commentData[0]['id']);
            }

            return true;
        } catch (PDOException $e){
            throw new Exception("Error on insert comment. ".$e->getMessage());
        }
    }

    function addFollow($accountFollowedId, $accountFollowId, $state){
        global $pdo;

        if(accountExist($accountFollowedId) == null){
            throw new Exception("Follower account not found.");
        }

        if(accountExist($accountFollowId) == null){
            throw new Exception("Follower account not found.");
        }

        try{
            $requete = $pdo->prepare("SELECT * FROM follow WHERE follower = ? AND followed = ?");
            $requete->execute(array($accountFollowId, $accountFollowedId));
            $exist = $requete->rowCount();

            if($exist == 0){
                try {
                    $requete = $pdo->prepare("INSERT INTO follow (follower, followed, follow) VALUES (?, ?, ?)");
                    $requete->execute(array($accountFollowId, $accountFollowedId, $state));

                    return true;
                } catch (PDOException $e){
                    throw new Exception("Error on insert follow. ".$e->getMessage());
                }
            }else{
                return true;
            }
        } catch (PDOException $e){
            throw new Exception("Error on find follow line. ".$e->getMessage());
        }
    }

    //---------------EVENT---------------\\

    //---------------ACCOUNT---------------\\

    if(count(array_keys($_POST)) == 1 && isset($_POST['accountReport'])){

        if(!empty($_POST['accountReport'])){

            $requete = $pdo->prepare("SELECT id FROM account WHERE pseudo = ?");
            $requete->execute(array($_POST['accountReport']));
            $accountData = $requete->fetchAll();

            if(count($accountData) > 0){
                try{
                    addAccountReport($accountData[0]['id'], $_SESSION['id']);
                    echo json_encode(generateValidationPopup("Votre signalement a bien été pris en compte."));
                }catch(Exception $e){
                    echo json_encode(generateErrorPopup($e->getMessage()));
                }
            }
        }
    }

    if(count(array_keys($_POST)) == 1 && isset($_POST['accountBlock'])){

        if(!empty($_POST['accountBlock'])){
            $requete = $pdo->prepare("SELECT id FROM account WHERE pseudo = ?");
            $requete->execute(array($_POST['accountBlock']));
            $accountData = $requete->fetchAll();

            if(count($accountData) > 0){
                try{
                    addAccountBlock($accountData[0]['id'], $_SESSION['id']);
                    echo json_encode(generateValidationPopup("Ce compte a bien été bloqué."));
                }catch(Exception $e){
                    echo json_encode(generateErrorPopup($e->getMessage()));
                }
            }
        }
    }

    if(count(array_keys($_POST)) == 1 && isset($_POST['accountUnblock'])){
        
        if(!empty($_POST['accountUnblock'])){
            $requete = $pdo->prepare("SELECT id FROM account WHERE pseudo = ?");
            $requete->execute(array($_POST['accountUnblock']));
            $accountData = $requete->fetchAll();

            if(count($accountData) > 0){
                try{
                    deleteAccountBlock($accountData[0]['id'], $_SESSION['id']);
                    echo json_encode(generateValidationPopup("Ce compte a bien été débloqué."));
                }catch(Exception $e){
                    echo json_encode(generateErrorPopup($e->getMessage()));
                }
            }
        }
    }

    if(count(array_keys($_POST)) == 3 && isset($_POST['account'], $_POST['choice'], $_POST['notification'])){

        if(!empty($_POST['account']) && !empty($_POST['choice']) && !empty($_POST['notification'])){
            $requete = $pdo->prepare("SELECT id, privatePost FROM account WHERE pseudo = ?");
            $requete->execute(array($_POST['account']));
            $accountData = $requete->fetchAll();

            if(count($accountData) > 0 && filter_var($_POST['choice'], FILTER_VALIDATE_INT)){
                if($_POST['choice'] == 0 || $_POST['choice'] == 1){
                    $requete = $pdo->prepare("DELETE FROM notification WHERE id = ? AND account = ?");
                    $requete->execute(array($_POST['notification'], $_SESSION['id']));
                }

                if($_POST['choice'] == 0){
                    deleteFollow($_SESSION['id'], $accountData[0]['id']);
                }
                else if($_POST['choice'] == 1){
                    updateFollow($_SESSION['id'], $accountData[0]['id'], 1);
                }
            }
        }
    }

    if(count(array_keys($_POST)) == 2 && isset($_POST['follow'], $_POST['account'])){

        if(!empty($_POST['follow']) && !empty($_POST['account'])){
            $requete = $pdo->prepare("SELECT id, privatePost FROM account WHERE pseudo = ?");
            $requete->execute(array($_POST['account']));
            $accountData = $requete->fetchAll();

            if(count($accountData) > 0 && filter_var($_POST['follow'], FILTER_VALIDATE_INT)){

                if($_POST['follow'] == 2){
                    deleteFollow($accountData[0]['id'], $_SESSION['id']);

                    $requete = $pdo->prepare("SELECT id FROM notification WHERE notified = ? AND notifier = ? AND type = 0");
                    $requete->execute(array($accountData[0]['id'], $_SESSION['id']));
                    $notificationData = $requete->fetchAll();
                    if(count($notificationData) > 0){
                        deleteNotification($notificationData[0]['id']);
                    }

                    echo json_encode("unfollow");
                }
                else if($_POST['follow'] == 1){

                    if($accountData[0]['privatePost'] == 0){
                        addFollow($accountData[0]['id'], $_SESSION['id'], 1);
                        addNotification($accountData[0]['id'], $_SESSION['id'], 1, -1, -1);
                        echo json_encode("followed");
                    }
                    else{
                        addFollow($accountData[0]['id'], $_SESSION['id'], 0);
                        addNotification($accountData[0]['id'], $_SESSION['id'], 0, -1, -1);
                        echo json_encode("requested");
                    }
                }else{
                    echo json_encode("error");
                }
            }else{
                echo json_encode("error");
            }
        }else{
            echo json_encode("error");
        }
    }

    //---------------POST---------------\\

    if(count(array_keys($_POST)) == 1 && isset($_POST['likes'])){

        if(!empty($_POST['likes'])){
    		$likes = explode(",", $_POST['likes']);

    		for($i = 0; $i < count($likes); $i+=2){

                if(filter_var($likes[$i], FILTER_VALIDATE_INT) && filter_var($likes[$i + 1], FILTER_VALIDATE_INT)){
                    $postLike = $likes[$i + 1]; 
        			$postId = $likes[$i];

                    if($postLike == -1){ 
                        deleteLike($postId, $_SESSION['id']);
                    }
                    else{
                        addLike($postId, $_SESSION['id']);
                    }
                }
            }
        }
    }

    if(count(array_keys($_POST)) == 2 && isset($_POST['post'], $_POST['comment'])){

        if(!empty($_POST['post']) && !empty($_POST['comment']) && filter_var($_POST['post'], FILTER_VALIDATE_INT)){
            addComment($_POST['post'], $_SESSION['id'], $_POST['comment']);
            header("Location: ../post.php?post=".$_POST['post']);
        }
    }

    if(count(array_keys($_POST)) == 1 && isset($_POST['postReport'])){

        if(!empty($_POST['postReport']) && filter_var($_POST['postReport'], FILTER_VALIDATE_INT)){
            try{
                addPostReport($_POST['postReport'], $_SESSION['id']);
                echo json_encode(generateValidationPopup("Votre signalement a bien été pris en compte."));
            }catch(Exception $e){
                echo json_encode(generateErrorPopup($e->getMessage()));
            }
        }
    }

    if(count(array_keys($_POST)) == 1 && isset($_POST['postDelete'])){
        $requete = $pdo->prepare("SELECT publisher FROM post WHERE id = ?");
        $requete->execute(array($_POST['postDelete']));

        $publisherData = $requete->fetchAll();

        if(count($publisherData) > 0 && $publisherData[0]['publisher'] == $_SESSION['id']){
            try{
                deletePost($_POST['postDelete']);
                echo json_encode(generateValidationPopup("Votre post a bien été supprimer."));
            }catch(Exception $e){
                echo json_encode(generateErrorPopup($e->getMessage()));
            }
        }
    }

    if(count(array_keys($_POST)) == 2 && isset($_POST['getPost'], $_POST['existingPost'])){
        $existingPost = explode(",", $_POST['existingPost']);

        $result = getPosts(5, $existingPost);
            
        if($result != null){
            echo json_encode($result);
        }else{
            echo "";
        }
    }

    //---------------MESSAGE---------------\\

    if(count(array_keys($_POST)) == 2 && isset($_POST['receiver'], $_POST['message'])){
        $message = $_POST['message'];

        $requete = $pdo->prepare("SELECT id FROM account WHERE pseudo = ?");
        $requete->execute(array($_POST['receiver']));
        $accountData = $requete->fetchAll();

        if(!empty($message) && count($accountData) > 0){
            if(!inLength($message, 255)){
                $message = substr($message, 255);
            }

            try{
                addMessage($_SESSION['id'], $accountData[0]['id'], $message, null);
                $result = getMessages($_SESSION['id'], $accountData[0]['id'], 1, null);
                echo json_encode(printMessage($result, $accountData[0]['id'], true));
            } catch (Exeception $e){
                echo json_encode($e);
            }
        }

        echo "";
    }

    if(count(array_keys($_POST)) == 1 && isset($_POST['receiverRefresh'])){
        $requete = $pdo->prepare("SELECT id FROM account WHERE pseudo = ?");
        $requete->execute(array($_POST['receiverRefresh']));
        $accountData = $requete->fetchAll();

        if(count($accountData) > 0){
            try{
                $data = array("", "");

                $result = getMessages($_SESSION['id'], $accountData[0]['id'], 1, null);
                if(count($result) > 0 && $result[0]['receiver'] == $_SESSION['id'] && $result[0]['view'] == 0){
                    $data[0] = printMessage($result, $accountData[0]['id'], true);

                    $requete = $pdo->prepare("UPDATE message SET view = ? WHERE id = ?");
                    $requete->execute(array(1, $result[0]['id']));
                }

                $view = getMessageView($_SESSION['id'], $accountData[0]['id']);
                if(count($view) > 0 && $view[0]['view'] == 1){
                    $data[1] = "view";
                }

                echo json_encode($data);
            } catch (Exeception $e){
                echo json_encode($e);
            }
        }
    }

    if(count(array_keys($_POST)) == 2 && isset($_POST['receiver'], $_POST['date'])){
        $requete = $pdo->prepare("SELECT id FROM account WHERE pseudo = ?");
        $requete->execute(array($_POST['receiver']));
        $accountData = $requete->fetchAll();

        if(count($accountData) > 0 && isset($_POST['date']) && !empty($_POST['date'])){
            try{
                $result = getMessages($_SESSION['id'], $accountData[0]['id'], 10, $_POST['date']);

                if(count($result) > 0){
                    $data = printMessage($result, $accountData[0]['id'], false);

                    echo json_encode($data);
                }
            } catch (Exeception $e){
                echo json_encode($e);
            }
        }
    }   

    //---------------OTHER---------------\\

    if(count(array_keys($_POST)) == 1 && isset($_POST['search']) && !empty($_POST['search'])){
        $value = $_POST['search'];

        if(!inLength($value, 255)){
            $value = substr($value, 255);
        }

        $result = getResearch($_POST['search']."%");
        
        if($result != null){
            echo json_encode($result);
        }else{
            echo "";
        }
    }

    if(count(array_keys($_POST)) == 1 && isset($_POST['viewNotification'])){
        if(!empty($_POST['viewNotification']) && filter_var($_POST['viewNotification'], FILTER_VALIDATE_INT)){
            $requete = $pdo->prepare("UPDATE notification SET view = 1 WHERE account = ?");
            $requete->execute(array($_SESSION['id']));
        }
    }
?>