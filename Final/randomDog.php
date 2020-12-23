<!DOCTYPE HTML>

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

    $title = 'Random Dog Image Generator';
//    if($loggedIn === false) {
//        include 'guestNav.php';
//    } else {
//        include 'loggedInNav.php';
//    }
?>

<html lang="en">
    <head>
        
        <!-- API used: https://dog.ceo/dog-api/documentation/ -->
        
        
        <title>Random Dog Image Generator</title>
        <meta charset="utf-8">
        <link href="randomDog.css" type="text/css" rel="stylesheet">
        <link rel='stylesheet' type="text/css" href="jquery-ui-1.12.1.custom/jquery-ui.min.css">
        <style>
                    <?php
        
                    if($loggedIn === false) {
                        include 'guestNav.css';
                    } else {
                        include 'loggedInNav.css';
                    }
                    ?>
        </style>
        <script src="nav.js"></script>
        <script src='jquery-ui-1.12.1.custom/external/jquery/jquery.js'></script>
        <script src='jquery-ui-1.12.1.custom/jquery-ui.min.js'></script>
        <script>   
            $(document).ready(function(){
                $('button').button();
                $( "select" ).selectmenu();
                $('#breedList').addClass( "overflow" );
                
                $.getJSON('https://dog.ceo/api/breeds/list', function(data){
                    var breedData = data;
                    
                    // Reference for dynamically added option elements: https://stackoverflow.com/questions/170986/what-is-the-best-way-to-add-options-to-a-select-from-a-javascript-object-with-jq
                    
                    if(breedData['status'] === 'success'){
                        
                        var output = [];
                        
                        output.push('<option value="value" disabled selected>Select a breed</option>');
                        
                        $.each(breedData["message"], function(key)
                        {
                            var breed = breedData['message'][key];
                            
                            output.push('<option value="'+ breed +'">'+ breed +'</option>');
                        });

                        $('#breedList').html(output.join(''));
                    }
                });
                
                $(document).on('click', '#breedButton', function(){
                    var selectedBreed = $('#breedList').val();
                    if(selectedBreed == 'value' || selectedBreed === null){
                        window.alert('Select a breed!');
                    }
                    else{
                        $("#pictureWrapper").empty();
                        document.getElementById('loader').display = 'block';
                        var URL = 'https://dog.ceo/api/breed/' + selectedBreed + '/images/random';
                        $.getJSON(URL, function(data){
                            var dogData = data;
                            if(dogData['status'] === 'success'){
                                document.getElementById('loader').display = 'none';
                                $("#pictureWrapper").append('<img src="' + dogData['message'] + '" alt="' + selectedBreed + '">');
                            }
                            else{
                                window.alert('Error loading image');
                            }
                        });
                    }
                    
                });
            });
            
            function getImage(){
                $.getJSON("https://dog.ceo/api/breeds/image/random", function(data) {
                    $("#pictureWrapper").empty();
                    $("#loader").show();
                    var dogData = data;
                    if(dogData['status'] === 'success'){
                        $("#loader").hide();
                        $("#pictureWrapper").append('<img src="' + dogData['message'] + '" alt="Random Dog">');
                    }
                    else{
                        window.alert('Error loading image');
                    }
                });
            }
        </script>
    </head>
    <body onload="getImage()">
        <?php
        
        if($loggedIn === false) {
            include 'guestNav.php';
        } else {
            include 'loggedInNav.php';
        }
        ?>
        <div id='wrapper'>
            <h1>Dog Image Generator</h1>
            <div id='loader'></div>
            <div id="pictureWrapper">
            
            </div>
            <button class='ui-button' id='dogButton' name='dogButton' type="button" onclick="getImage()">Random Dog</button><br><hr><br>
            <select name="breedList" id="breedList">
            </select><br>
            <button class='ui-button' id="breedButton" type="button">Random Dog from Breed</button>
        </div>
        
    </body>
</html>