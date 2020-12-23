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
	
	// Most code taken and modified from lecture
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

    $title = "Add Pictures";
    
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<title>File Upload</title>
    <meta charset="utf-8">
    <style>
        #wrapper {
            width: 90%;
            margin: 75px auto;
            text-align: center;
        }
        h1, p, form, label, input {
            margin: 10px auto;
        }
        <?php 
            include 'loggedInNav.css';
        ?>
    </style>
    <script src='nav.js'></script>
</head>
<body>
    <?php 
            include 'loggedInNav.php';
    ?>
    <div id='wrapper'>
        <h1>Add Dog Images to Gallery</h1>
        <p>Select a picture of your dog to add to the gallery!</p>

        <form action="uploadHandler.php" method="POST" enctype="multipart/form-data">
            <p>
                <label>File:</label>

                    <input type="file" name="files[]">

            </p>
            <input name="submit" type="submit" value="Upload">
        </form>
    </div>
</body>
</html>