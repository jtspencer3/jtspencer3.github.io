<!--
    Name: Joel Spencer
    Pawprint: jtswgb    
    Date: 12-11-2020
    Purpose: Final for CS2830 Fall 2020
        Website built for sharing dog images using html, css, javascript, jquery, php, and mySQL
-->
<?php
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
	
    $title = 'Dog Gallery';
//	if($loggedIn === false) {
//        include 'guestNav.php';
//    } else {
//        include 'loggedInNav.php';
//    }
?>

<!DOCTYPE HTML>
<html lang='en'>
    <head>
        <title>Image Gallery</title>
        <meta charset="utf-8">
        <script src="nav.js"></script>
        <style>
        body {
            text-align: center;
        }
        
        .img {
            position: relative;
            object-fit: contain;
            min-width: 100%;
            margin: auto;
            height: 100%;
        }

        .block {
            width: 25vw;
            height: 25vw;
            position: relative;
            margin: 7px;
            overflow: hidden;
            display: flex;
        }
        
        
        #wrapper {
            display: flex;
            width: 80%;
            margin: 35px auto;
            flex-wrap: wrap;
            position: relative;
            text-align: center;
            flex: 33%;
            justify-content: center;
        }
        h2 {
            margin: 75px auto 20px auto;
        }
        
        @media screen and (max-width: 800px) {
          .block {
            flex: 50%;
            max-width: 50%;
          }
        }

        /* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {
          .block {
            flex: 100%;
            max-width: 100%;
          }
        }
        <?php
        
        if($loggedIn === false) {
            include 'guestNav.css';
        } else {
            include 'loggedInNav.css';
        }
        ?>
        
    </style>
    </head>
    
    <body>
        <?php
        
        if($loggedIn === false) {
            include 'guestNav.php';
        } else {
            include 'loggedInNav.php';
        }
        ?>
        <h2>Dog Gallery</h2>
        <?php 
        if($loggedIn == false){echo  '<h4>Log in to add your own pictures and view your own gallery!</h4>';} ?>
        <div id="wrapper">
            
<?php
            
        require_once 'db.conf';
        
        // Connect to the database
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        
        
        // Check for errors
        if ($mysqli->connect_error) {
            $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
			require "login_form.php";
            exit;
        }

        $nameQuery = "SELECT img_name, img_dir FROM images";

        $result = $mysqli->query($nameQuery);
            
        // If there was a result...
        if ($result) {
            while($row = $result->fetch_assoc()) {
                $imgSrc = $row['img_dir'] . $row['img_name'];
                echo '<div class="block"><img src="' . $row['img_dir'] . $row['img_name'] . '" alt="' . $row['img_name'] . '" class="img"></div>';
            }       
        }

        // Close the results
        $result->close();
        // Close the DB connection
        $mysqli->close();

        
?>
        </div>
        <div class="block">
        
        </div>
    </body>
</html>