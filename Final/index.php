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

    $title = 'Home';
//    if($loggedIn === false) {
//        include 'guestNav.php';
//    } else {
//        include 'loggedInNav.php';
//    }

    header('Access-Control-Allow-Origin: *'); 
?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <style>
            #mainWrapper {
                width: 95%;
                min-height: 1000px;
                text-align: center;
                position: relative;
                margin: 75px auto;
            }
            
            #factWrapper {
                width: 20%;
                text-align: center;
                overflow: hidden;
                float: left;
                border: 2px solid black;
            }
            
            #aboutWrapper {
                width: 75%;
                overflow: hidden;
                text-align: center;
                float: right;
                border: 2px solid black;
            }
            
            #aboutWrapper::after, #factWrapper::after , #topWrapper::after {
                content: "";
                clear: both;
                display: table;
                
            }
            
            #topWrapper {
                margin: 25px auto;
            }
            #factContainer {
                width: 90%;
                margin: auto;
            }
            
            #factButton {
                margin: 10px auto;
            }
            
            #aboutText {
                width: 90%;
                margin: 10px auto;
            }
            
            #myDogWrapper {
                width: 90%;
                margin: auto;
                border: 2px solid black;
                overflow: hidden;
            }
            
            #myDogInfoWrapper {
                float: left;
                text-align: center;
                width: 77%;
            }
            
            #myDogPicWrapper {
                position: relative;
                float: left;
                width: 23%;
                height: 100%;
                overflow: hidden;
            }
            
            #myDogInfoWrapper::after, #myDogWrapper::after, #myDogPicWrapper::after, #videoWrapper::after {
                content: "";
                clear: both;
                display: table;
            }
            
            #xanderPic {
                position: relative;
                height: 100%;
                width: 100%;
            }
            
            #myDogText {
                width: 90%;
                margin: 10px auto;
            }
            
            #videoWrapper {
                float: left;
                margin: 25px auto;
                position: relative;
                width: 100%;
                height: auto;
            }
            
            iframe {
                width: 50%;
                height: auto;
            }
            
            #loader {
              border: 8px solid #f3f3f3; /* Light grey */
              border-top: 8px solid #3498db; /* Blue */
              border-radius: 50%;
              width: 60px;
              height: 60px;
              animation: spin 2s linear infinite;
                margin: auto;
            }

            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }
            
            <?php
        
            if($loggedIn === false) {
                include 'guestNav.css';
            } else {
                include 'loggedInNav.css';
            }
            ?>
        </style>
        <link rel='stylesheet' type="text/css" href="jquery-ui-1.12.1.custom/jquery-ui.min.css">
        <script src='nav.js'></script>
        <script src='jquery-ui-1.12.1.custom/external/jquery/jquery.js'></script>
        <script src='jquery-ui-1.12.1.custom/jquery-ui.min.js'></script>
        <script>  
            
            // https://cors-anywhere.herokuapp.com/https://dog-api.kinduff.com/api/facts
            
            $(document).ready(function(){
                $.getJSON('https://quiet-garden-47350.herokuapp.com/https://dog-api.kinduff.com/api/facts', function(data){
                    $('#loader').show();
                    if(data['success'] === true){
                        $('#factContainer').empty();
                        var factData = data;
                        var facts = factData['facts'];
                        $('#loader').hide();
                        $('#factContainer').append(facts[0]);
                    }
                });
            });
            
            
            // Can't access API due to CORS headers, I used the cors anywhere proxy from github and it was working at first but I think it may be down at the time I am writing this. I tried to deploy my own proxy to access the API https://quiet-garden-47350.herokuapp.com/https://dog-api.kinduff.com/api/facts but this is giving me an error as well. Hopefully cors anywhere is just down currently since it was working last night but unfortnunately I didn't get any screenshots. I have another .getJSON request on randomDog.php though so I should be covered there, it is just frustrating I can't get this feature to work
            
            // src for cors anywhere: https://github.com/Rob--W/cors-anywhere/
            // I got it to work by adding the header on line 26
            // Source's for helping me work through that
            
            // https://stackoverflow.com/questions/20035101/why-does-my-javascript-code-receive-a-no-access-control-allow-origin-header-i
            // https://stackoverflow.com/questions/47076743/cors-anywhere-herokuapp-com-not-working-503-what-else-can-i-try
            
            function getDogFact(){
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    document.getElementById('factContainer').innerHTML = "";
                    $('#loader').show();
                    if (this.readyState == 4 && this.status == 200) {
                        $('#loader').hide();
                        var data = JSON.parse(xhttp.responseText);
                        if(data.success === true){
                            var facts = data.facts;
                            document.getElementById('factContainer').innerHTML = facts;
                        }
                        else {
                            var facts = 'Sorry, could not receive fact';
                            document.getElementById('factContainer').innerHTML = facts;
                        }
                    }
                };
                xhttp.open("GET", "https://quiet-garden-47350.herokuapp.com/https://dog-api.kinduff.com/api/facts", true);
                xhttp.send();
            }
        </script>
    </head>
    <body>
        <?php
        
        if($loggedIn === false) {
            include 'guestNav.php';
        } else {
            include 'loggedInNav.php';
        }
        ?>
        <div id="mainWrapper">
        <?php
            if($loggedIn === false){
                echo "<h1>Welcome to Joel's Dog Sharing App, I hope you enjoy!</h1>";
            }
            else{
                echo "<h1>Welcome Back!</h1>";
            }
        ?>
            <div id='topWrapper'>
                <div id='factWrapper'>
                    <h3>Dog Facts</h3>
                    <div id="loader"></div>
                    <div id='factContainer'></div>
                    <button class='ui-button' id="factButton" type="button" onclick='getDogFact()'>New Fact</button>
                </div>
                <div id="aboutWrapper">
                    <h3>About</h3>
                    <p id="aboutText">I created this page so people can have a place to share images of their dogs or any dogs you want to share. Almost everyone loves dogs and they are scientifically proven stress relievers. So with finals week coming up combined with the fact that I love dogs, I decided to make this page. I hope you enjoy and you can get some benefit from this website. Make sure you create an account and look around because you get access to more features! You can upload pictures of your dog and they will be added to the main gallery, along with your own personal gallery that you can only view when you are logged in! Whether you use my website to view pictures of your dog and other dogs, or you're just using it as a place to store images of your dog, I hope you find some benefit! </p>
                </div>
            </div>
            <div id="myDogWrapper">
                <div id="myDogInfoWrapper">
                    <h3>My Dog</h3>
                    <p id='myDogText'>I have a dog named Xander. He is a red Austrialian Labradoodle. He was born on June 21, 2020 so he is still a crazy little puppy. I got him when he was about eight weeks old and he was four pounds. Xander is about 20 pounds now and as playful as ever. Some of his favorite things include sticks, shoelaces and hoodie strings, ripping tags off of everything, and zoomies! I hope you enjoy the pictures of Xander and I hope you share pictures of your favorite dogs!</p>
                    <div id='videoWrapper'>
                        <iframe id='ytVideo' src="https://www.youtube.com/embed/9-5OQaBOR1Q"></iframe>
                    </div>
                </div>
                <div id="myDogPicWrapper">
                    <img id="xanderPic" src='images/Xander.jpg' alt='Xander'>
                </div>
            </div>
        </div>
    </body>
</html>