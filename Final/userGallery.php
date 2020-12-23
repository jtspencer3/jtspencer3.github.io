<?php
    // HTTPS redirect
//    if ($_SERVER['HTTPS'] !== 'on') {
// 		$redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 		header("Location: $redirectURL");
// 		exit;
// 	}
	
	// http://us3.php.net/manual/en/function.session-start.php
	if(!session_start()) {
		// If the session couldn't start, present an error
		header("Location: error.php");
		exit;
	}
	
	// Check to see if the user has already logged in
	$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	
	if ($loggedIn === false) {
		header("Location: login.php");
		exit;
	}
    
    $title = 'User Gallery';
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>User Gallery</title>
        <meta charset="utf-8">
        <style>
            .slider-inner {
                width: 90%;
                height: 100%;
                position: relative;
                overflow: hidden;
                margin: auto;
                display: inline-block;
                text-align: center;
            }
            .slider-outer {
                width: 70%;
                height: 80%;
                margin: auto;
            }

            .slider-inner img.active {
                display: inline-block;
            }

            .prev, .next {
                position: absolute;
                margin-top: 200px;
                cursor: pointer;
            }

            .prev::after, .next::after {
                content: "";
                clear: both;
                display: table;
            }
            .prev {
                position: relative;
                margin-right: -53px;
                z-index: 100;
            }


            .next {
                position: relative;
                margin-left: -53px;
                z-index: 100;
            }
            
            #photoWrapper {
                width: 75%;
                margin: 75px auto;
                height: 1000px;
                position: relative;
            }
            
            div#photoWrapper>img {
                width: 100%;
                max-height: 400px;
            }
            
            .slider-inner img {
                display: none;
                width: auto;
                height: auto;
                max-height: 100%;
                max-width: 100%;
                position: absolute;
                overflow: hidden;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
            }
            
            <?php
            include 'loggedInNav.css';
            ?>
        </style>
        <script src='nav.js'></script>
        <script src='jquery-ui-1.12.1.custom/external/jquery/jquery.js'></script>
        <script>
            $(document).ready(function(){
                $(".next").on('click', function(){
                    var currentImg = $('.active');
                    var nextImg = currentImg.next();
                    
                    if(nextImg.length){
                        currentImg.removeClass('active').css('z-index', -10);
                        nextImg.addClass('active').css('z-indez', 10);
                    }
                });
                
                $(".prev").on('click', function(){
                    var currentImg = $('.active');
                    var prevImg = currentImg.prev();
                    
                    if(prevImg.length){
                        currentImg.removeClass('active').css('z-index', -10);
                        prevImg.addClass('active').css('z-indez', 10);
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php
            include 'loggedInNav.php';
        ?>
        <div id='photoWrapper'>
            <div class="slider-outer">
                    <img src="images/arrow-left.png" class="prev arrow" alt="Prev">
                    <div class="slider-inner">
                        
                        
<?php

    require_once 'db.conf';

    // Connect to the database
    $db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);


    // Check for errors
    if ($db->connect_error) {
        $error = 'Error: ' . $db->connect_errno . ' ' . $db->connect_error;
        require "login_form.php";
        exit;
    }

    $username = $_SESSION['loggedin'];

    $usernameQuery = "SELECT img_name, img_dir FROM images WHERE userName = '$username'";

    $result = $db->query($usernameQuery);

    $first = true;
    if ($result) {
        print $row;
        $match = $result->num_rows;
        if($match === 0){
            echo '<h2>Upload images to view them here!</h2>';
        }
        while($row = $result->fetch_assoc()) {
            if($first){
                echo '<img class="active img" src="' . $row['img_dir'] . $row['img_name'] .'" alt="' . $row['img_name'] . '">';
                $first = false;
            }
            else{
                echo '<img src="' . $row['img_dir'] . $row['img_name'] .'" alt="' . $row['img_name'] . '" class="img">';
            }
        } 
    }

    // Close the results
    $result->close();
    // Close the DB connection
    $db->close();
?>   
                    </div>
                    <img src="images/arrow-right.png" class="next arrow" alt="Next">
                </div>
            </div>
    </body>
</html>