<!DOCTYPE html>
<html>
    <head>
        <title>Nexia</title>
        <meta charset="utf-8">
        <link rel="shortcut icon" type="image/x-icon" href="images/icon.ico">
        <link rel="stylesheet" type="text/css" href="css/post.css">
        <link rel="stylesheet" type="text/css" href="css/popup.css">
        <link rel="stylesheet" type="text/css" href="css/follower-bar.css">
        <link rel="stylesheet" type="text/css" href="css/side-bar.css">
        <link rel="stylesheet" type="text/css" href="css/index.css">
    </head>

    <?php

    try{

        require_once("php/database.php");
        include_once("php/function.php");
        include_once("php/session.php");
        include_once("php/post-function.php");

        checkSession();
    ?>

    <body>
        <div class="main-container">
            <?php 
                include_once("php/side-bar.php");
            ?>

            <div class="container">
                <div class="story">
                    <div>
                        
                    </div>
                </div>

                <?php
                    $date = new DateTime(getActuallyDate());
                    $date->modify('-1 week');

                    $request = $pdo->prepare("SELECT * FROM post WHERE publisher IN (SELECT followed FROM follow WHERE follower = ? AND follow = 1) AND STR_TO_DATE(date, '%H:%i:%s %d-%m-%Y') >= STR_TO_DATE(?, '%H:%i:%s %d-%m-%Y') ORDER BY STR_TO_DATE(date, '%H:%i:%s %d-%m-%Y') DESC");
                    $request->execute(array($_SESSION['id'], $date->format("H:i:s d-m-Y")));
                    
                    $postCount = $request->rowCount();

                    if($postCount >= 1){
                        $postData = $request->fetchAll();

                        for($i = 0; $i < $postCount; $i++){
                            $allPostData = getAllPostData($postData[$i]);
                            echo printPost($allPostData[0], $allPostData[1], $allPostData[2], $allPostData[3], $allPostData[4]);
                        }
                    }
                ?>

                <div class="index-post-separator">
                    <svg viewBox="0 0 256 256">
                        <defs>
                            <linearGradient id="gradientt" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color: var(--yellow-logo); stop-opacity: 1" />
                                <stop offset="100%" style="stop-color: var(--purple-logo); stop-opacity: 1" />
                            </linearGradient>
                        </defs>
                        <g transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                        <path d="M 42.933 61.058 c -0.019 0 -0.037 0 -0.056 -0.001 c -0.55 -0.016 -1.069 -0.256 -1.435 -0.666 L 24.076 40.958 c -0.736 -0.824 -0.665 -2.088 0.159 -2.824 c 0.824 -0.734 2.087 -0.666 2.824 0.159 l 15.956 17.855 l 43.572 -43.571 c 0.781 -0.781 2.047 -0.781 2.828 0 c 0.781 0.781 0.781 2.047 0 2.828 L 44.347 60.472 C 43.971 60.848 43.462 61.058 42.933 61.058 z" transform=" matrix(1 0 0 1 0 0) " fill="url(#gradientt)" stroke-linecap="round" />
                        <path d="M 45 90 C 20.187 90 0 69.813 0 45 C 0 20.187 20.187 0 45 0 c 1.104 0 2 0.896 2 2 s -0.896 2 -2 2 C 22.393 4 4 22.393 4 45 s 18.393 41 41 41 s 41 -18.393 41 -41 c 0 -1.104 0.896 -2 2 -2 s 2 0.896 2 2 C 90 69.813 69.813 90 45 90 z" transform=" matrix(1 0 0 1 0 0) " fill="url(#gradientt)" stroke-linecap="round" />
                        </g>
                    </svg>
                    <hr>
                    <h2>Vous êtes à jour</h2>
                    <p>Vous avez vu toutes les nouvelles publications de ces 7 derniers jours.</p>
                </div>

                <?php
                    $request = $pdo->prepare("SELECT * FROM post WHERE publisher NOT IN (SELECT followed FROM follow WHERE follower = ? AND follow = 1) AND publisher != ? ORDER BY STR_TO_DATE(date, '%H:%i:%s %d-%m-%Y') DESC LIMIT 5;");
                    $request->execute(array($_SESSION['id'], $_SESSION['id']));
                    
                    $postCount = $request->rowCount();

                    if($postCount >= 1){
                        $postData = $request->fetchAll();

                        for($i = 0; $i < $postCount; $i++){
                            $allPostData = getAllPostData($postData[$i]);
                            echo printPost($allPostData[0], $allPostData[1], $allPostData[2], $allPostData[3], $allPostData[4]);
                        }
                    }
                ?>
            </div>

            <?php
                include_once("php/follower-bar.php");
            ?>
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
<script src="js/post.js"></script>
<script src="js/index.js"></script>