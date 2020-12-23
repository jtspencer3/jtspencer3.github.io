<!--
    Name: Joel Spencer
    Pawprint: jtswgb    
    Date: 12-11-2020
    Purpose: Final for CS2830 Fall 2020
        Website built for sharing dog images using html, css, javascript, jquery, php, and mySQL
-->
<?php
// Code taken from lecture

	if(!session_start()) {
		header("Location: error.php");
		exit;
	}
	
	
	/*
		Destroying all session data
		http://php.net/manual/en/function.session-destroy.php
	*/
	// Unset all session variables
	$_SESSION = array();
	
	// If the session was propagated using a cookie, remove that cookie
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', 1,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	
	// Destroy the session
	session_destroy();	
	
	// Redirect to login
	header("Location: login.php");
    print("You have been logged out");
	exit;
?>
