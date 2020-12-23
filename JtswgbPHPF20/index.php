<!--
    name: Joel Spencer
    pawprint: jtswgb
    date: 10/29/2020
    Challenge: PHPF20
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Forms</title>
        <meta charset="utf-8">
        <script src="jquery-3.5.1.min.js"></script>
        <link rel="stylesheet" href="styles.css" type="text/css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
        <script>
            function hideAll() {
                $("#name").hide();
                $("#hamNum").hide();
                $("#password").hide();
                $("#listCreator").hide();
                $("#cylinderSA").hide();
            }

            function showName() {
                $("#name").show();
                $("#hamNum").hide();
                $("#password").hide();
                $("#listCreator").hide();
                $("#cylinderSA").hide();
            }

            function showHamNum() {
                $("#name").hide();
                $("#hamNum").show();
                $("#password").hide();
                $("#listCreator").hide();
                $("#cylinderSA").hide();
            }

            function showPassword() {
                $("#name").hide();
                $("#hamNum").hide();
                $("#password").show();
                $("#listCreator").hide();
                $("#cylinderSA").hide();
            }

            function showListCreator() {
                $("#name").hide();
                $("#hamNum").hide();
                $("#password").hide();
                $("#listCreator").show();
                $("#cylinderSA").hide();
            }

            function showCylinder() {
                $("#name").hide();
                $("#hamNum").hide();
                $("#password").hide();
                $("#listCreator").hide();
                $("#cylinderSA").show();
            }

            function validateName() {
                var firstName = document.forms["#nameForm"]["fname"].value;
                var lastName = document.forms["#nameForm"]["lname"].value;
                var firstName = firstName.trim();
                var lastName = lastName.trim();
                if (firstName.length == 0) {
                    alert("First name must be filled out");
                    return false; 
                }
                if (lastName.length == 0) {
                    alert("Last name must be filled out");
                    return false; 
                }
            }

            function validatehamNum() {
                var x = document.forms["#hamNumForm"]["#hamNum"].value;
                var x = x.trim();
                if (x <= 0) {
                    alert("Invalid input. Number must be greater than 0");
                    return false;
                }

                if (x.isInteger() == false) {
                    alert("Invalid input. Must enter an integer");
                    return false;
                }
                if (x.length == 0) {
                    alert("Invalid input. Input can not be empty");
                    return false;
                }
            }

            function validateListCreator() {
                var x = document.forms["#listCreatorForm"]["#a"].value;
                var y = document.forms["#listCreatorForm"]["#b"].value;
                var x = x.trim();
                var y = y.trim();
                if ((x.length > 1) || (y.length > 1)) {
                    alert("Invalid input. Input should be one keystroke each");
                    return false;
                }
                if ((x.length == 0) || (y.length == 0)) {
                    alert("Invalid input. Input can not be empty");
                    return false;
                }
            }
            function validateCylinder() {
                var height = document.forms["#cylinderForm"]["#height"].value;
                var radius = document.forms["#cylinderForm"]["#radius"].value;
                var height = height.trim();
                var radius = radius.trim();
                if(!height.isNumeric()) {
                    alert("Invalid input. Height must be a number");
                }
                if(!radius.isNumeric()) {
                    alert("Invalid input. Radius must be a number");
                }
                if ((x.length == 0) || (y.length == 0)) {
                    alert("Invalid input. Input can not be empty");
                    return false;
                }

            }
            
            /* When the user clicks on the button, 
            toggle between hiding and showing the dropdown content */
            function myFunction() {
              document.getElementById("myDropdown").classList.toggle("show");
            }

            // Close the dropdown if the user clicks outside of it
            window.onclick = function(event) {
              if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                  var openDropdown = dropdowns[i];
                  if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                  }
                }
              }
            }
            
            function clearAll() {
                document.getElementById("nameForm").reset();
                document.getElementById("hamNumForm").reset();
                document.getElementById("passwordForm").reset();
                document.getElementById("listCreatorForm").reset();
                document.getElementById("cylinderForm").reset();
                $("#output").remove();
            }
</script>
    </head>
 <body onload="hideAll()"> 
    <div id="wrapper" class="center">
        <h2 class="center">PHP Playground</h2>
        <hr>
        <h4 class="center">Form Section</h4>
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn">Select a function:</button>
            <div id="myDropdown" class="dropdown-content">
                <span onclick="clearAll(); showName()">Name</span>
                <span onclick="clearAll(); showHamNum()">Hamming Number</span>
                <span onclick="clearAll(); showPassword()">Password Function</span>
                <span onclick="clearAll(); showListCreator()">List Creator</span>
                <span onclick="clearAll(); showCylinder()">Cylinder Surface Area</span>
            </div>
        </div>
            <div id="name" class="center function">
                <form class="center" id="nameForm" action="index.php" method="GET" onsubmit="validateName()">
                    <label for="fname">First Name:</label><br>
                    <input type="text" id="fname" name="fname" minlength="1" placeholder="First" required><br>
                    <label for="lname">Last Name:</label><br>
                    <input type="text" id="lname" name="lname" minlength="1" placeholder="Last" required><br>
                    <input id="nameSubmit" class="submit" type="submit" value="Submit">
                    <input type="hidden" name="page" value="1">
                </form>
                <button class="submit" onclick="clearAll()">Clear</button>
            </div>
        <div id="hamNum" class="center function">
            <form class="center" id="hamNumForm" action="index.php" method="GET" onsubmit="validatehamNum()">
                <label for="hamNumber">Enter Number: </label><br>
                <input type="number" id="hamNumber" name="hamNumber" minlength="1" min="1" placeholder="Enter Number" required><br>
                <input id="hamNumSubmit" class="submit" type="submit" value="Submit"><br>
                <input type="hidden" name="page" value="2">
            </form>
                <button class="submit" onclick="clearAll()">Clear</button>
        </div>
        <div id="password" class="center function">
            <form class="center" id="passwordForm" action="index.php" method="POST">
                <label for="userName">Username: </label><br>
                <input type="text" name="userName" id="userName" minlength="1" placeholder="Username" required><br>
                <label for="password">Password: </label><br>
                <input type="password" id="password" name="password" minlength="1" placeholder="Password" required><br>
                <input id="passSubmit" class="submit" type="submit" value="Submit">
                <input type="hidden" name="page" value="3">
            </form>
                <button class="submit" onclick="clearAll()">Clear</button>
        </div>
        <div id="listCreator" class="center function">
            <form class="center" id="listCreatorForm" action="index.php" method="GET" onsubmit="validateListCreator()">
                <label for="a">Value 1: </label><br>
                <input type="text" id="a" name="a"  minlength="1" maxlength="1" placeholder="a"><br>
                <label for="b">Value 2: </label><br>
                <input type="text" id="b" name="b" minlength="1" maxlength="1" placeholder="b"><br>
                <input id="listCreatorSubmit" class="submit" type="submit" value="Submit">
                <input type="hidden" name="page" value="4"> 
            </form>
                <button class="submit" onclick="clearAll()">Clear</button>
        </div>
        <div id="cylinderSA" class="center function">
            <form class="center" id="cylinderForm" action="index.php" method="GET" onsubmit="validateCylinderSA()">
                <label for="height">Height: </label><br>
                <input type="number" id="height" name="height" min="1" step="0.01" placeholder="Height"><br>
                <label for="radius">Radius: </label><br>
                <input type="number" id="radius" name="radius" min="0.01" step="0.01" placeholder="Radius"><br>
                <input id="cylinderSubmit" class="submit" type="submit" value="Submit">
                <input type="hidden" name="page" value="5">
            </form>
                <button class="submit" onclick="clearAll()">Clear</button>
        </div>
        <div id="outputWrapper" class="center">
            <?php
    
                // function resource: https://www.w3resource.com/php-exercises/challenges/1/php-challenges-1-exercise-20.php#:~:text=php%20function%20is_hamming_numbers(%24x,hamming_numbers_sequence(%24x)%20%7B%20if%20(%24

            function is_hamming_number ($x) {
                if ($x == 1)
                {
                    return "a Hamming Number";
                }
                if ($x % 2 == 0)
                {
                    return is_hamming_number($x/2);
                }

                if ($x % 3 == 0)
                {
                    return is_hamming_number($x/3);
                }
                if ($x % 5 == 0)
                {
                    return is_hamming_number($x/5);
                }	
                    return "not a Hamming Number";
                }
        
                // Handling Name form
            if ($_GET['page'] == 1) {
                if ((!empty($_GET['fname'])) && (!empty($_GET['lname']))) {
                    $firstName = $_GET['fname'];
                    $lastName = $_GET['lname'];
                    $firstName = trim($firstName);
                    $lastName = trim($lastName);
                    if ((strlen($firstName) == 0)) {
                        echo "<p id='output'>First name must be filled out</p>";
                        return false;
                    }
                    if ((strlen($lastName) == 0)) {
                        echo "<p id='output'>Last name must be filled out</p>";
                        return false;
                    }
                    echo "<p id='output'>Hello $firstName $lastName, welcome to my PHP playground, designed to simulate the value of server-side development and use in web development!</p>";   
                }
                else {
                    echo "<p id='output'>Invalid input. Please enter your first and last name</p>";
                    return false;
                }
            }
                // Handling Hamming Number form
            if ($_GET['page'] == 2) {
                if (isset($_GET['hamNumber'])) {
                    $x = $_GET['hamNumber'];
                    if (!is_numeric($x)) {
                        echo "<p id='output'>Invalid input. Input must be a number</p>";
                        return false;
                    }
                    if ($x >= 1) {
                        echo "<p id='output'>" . $x . " is " . is_hamming_number($x) . "</p>";
                    }
                    else {
                        echo "<p id='output'>Invalid input. Input must be greater than 0</p>";
                        return false;
                    }
                }
                else {
                    echo "<p id='output'>Invalid input. Please enter a number</p>";
                    return false;
                }
            }

                // Handling password form
            if ($_POST['page'] == 3) {
                if (isset($_POST['userName']) && isset($_POST['password'])) {
                    if(($_POST['userName'] == "test-user") && ($_POST['password'] == "test-pass")) {
                        echo "<p id='output'>Credentials validated with POST</p>";
                    }
                    else {
                        echo "<p id='output'>Username or password is incorrect</p>";
                        return false;
                    }
                }
            }



                // Handling the list creator form
            if ($_GET['page'] == 4) {


            if ((!empty($_GET['a'])) && (!empty($_GET['b']))) {
                $a = $_GET['a'];
                $b = $_GET['b'];

                if ($a == $b) {
                    echo "<p id='output'>[$a]</p>";
                }
                else {
                    if((ord($a)) > (ord($b))) {
                        $descending = range($a,$b);
                        $descending = implode(",", $descending);
                        echo "<p id='output'>[$descending]</p>";
                    }
                    else { // $a < $b
                        $ascending = range($a, $b);
                        $ascending = implode(",", $ascending);
                        echo "<p id='output'>[$ascending]</p>";
                        }
                    }   
                }

                }

                // Handling the cylinder surface area form
            if ($_GET['page'] == 5) {
                if((isset($_GET['height'])) && (isset($_GET['radius']))) {
                    if (!is_numeric($_GET['height'])) {
                        echo "<p id='output'>Invalid input. Height must be a number</p>";
                        return false;
                    }
                    if (!is_numeric($_GET['radius'])) {
                        echo "<p id='output'>Invalid input. Radius must be a number</p>";
                        return false;
                    }
                    if((($_GET['height']) < 0) && ($_GET['radius'] < 0)) {
                        echo "<p id='output'> Invalid input. Height and radius must be greater than 0</p>";
                        return false;
                    }
                    else {
                        $x = ((2*pi()*$_GET['height'] * $_GET['radius']) + (2*pi()*(radius*radius)));
                        echo "<p id='output'>The surface area of the cylinder is " . number_format($x,2) . "</p>";
                    }
                }
                else {
                    echo "<p id='output'>Invalid input. Please enter numbers for the height and radius</p>";
                    return false;
                }
            }
        ?>

        </div>
     </div>
        <a id="projectsLink" href="/Portfolio/Projects.html">Back to projects</a>
    </body>
</html>