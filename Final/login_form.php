<!--
    Name: Joel Spencer
    Pawprint: jtswgb    
    Date: 12-11-2020
    Purpose: Final for CS2830 Fall 2020
        Website built for sharing dog images using html, css, javascript, jquery, php, and mySQL

    Code taken from lecture and modified
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
	
	echo $loggedIn;

    $title = 'Log In';
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<title>Database Login</title>
	<link href="app.css" rel="stylesheet" type="text/css">
    <link href="../jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <style>
        <?php
        if($loggedIn === false) {
            include 'guestNav.css';
        } else {
            header ('location: addPics.css');
        }
        ?>
    </style>
    <script src='nav.js'></script>
    <script src="../jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <script src="../jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
    <script>
        $(function(){
            $("input[type=submit]").button();
        });
    </script>
</head>
<body>
    <?php
        if($loggedIn === false) {
            include 'guestNav.php';
        } else {
            header ('location: addPics.php');
        }
    ?>
    <div id="loginWidget" class="ui-widget">
        <h1 class="ui-widget-header">Login</h1>
        
        <?php
            if ($error) {
                print "<div class=\"ui-state-error\">$error</div>\n";
            }
        ?>
        
        <form action="login.php" method="POST">
            
            <input type="hidden" name="action" value="do_login">
            
            <div class="stack">
                <label for="username">User name:</label>
                <input type="text" id="username" name="username" class="ui-widget-content ui-corner-all" autofocus value="<?php print $username; ?>">
            </div>
            
            <div class="stack">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="ui-widget-content ui-corner-all">
            </div>
            
            <div class="stack">
                <input type="submit" value="Submit">
            </div>
        </form>
        <br>
        <a href="createUser_form.php">Not a user?</a>
    </div>
</body>
</html>