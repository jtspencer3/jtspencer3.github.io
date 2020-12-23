<!--
    Name: Joel Spencer
    Pawprint: jtswgb    
    Date: 12-11-2020
    Purpose: Final for CS2830 Fall 2020
        Website built for sharing dog images using html, css, javascript, jquery, php, and mySQL
-->
<?php
    if(!session_start()) {
		// If the session couldn't start, present an error
		header("Location: error.php");
		exit;
	}
    
    $loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	
	if ($loggedIn == false) {
		header("Location: login.php");
		exit;
	}
    
    include 'loggedInNav.php';
    
    require_once 'db.conf';
    
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
    // Require our Upload class
    require_once "Upload.php";

	$target_dir = "uploads/";
?>
<!DOCTYPE html>
<!-- Upload Handler taken from lecture and modified -->
<html lang='en'>
<head>
	<title>Image Upload</title>
    <meta charset="utf-8">
    <style>
        #errorMsg {
            display: block;
            position: relative;
            margin: 75px auto;
            width: 100%;
            border: 2px solid black;
        }
        
        div {
            margin: 75px;
        }
    </style>
</head>
<body>
    <div id="errorMsg">
<?php
    
     

    try {
        // Call a static function to reorder the contents of the $_FILES array
        $files = Upload::reorderFilesArray('files');

        // Static methods allow us to call those methods without an object instance
        // For example, above we can call "reorderFilesArray()" without creating a new Upload object
        // A Scope Resolution Operator (the "::") allows us to call static methods

        // Reference
        // http://www.php.net/manual/en/language.oop5.static.php
        // http://www.php.net/manual/en/language.oop5.paamayim-nekudotayim.php
    } catch (UploadExceptionNoFile $e) {
        print 'No file was uploaded.';
    } 
    ?>
        </div>
    <?php
    $n = 0;
    
    foreach($files as $file){
        $n++;
    
        try {       
            $upload = new Upload($file);
            $origFileName = $upload->getOrigFileName();
            $fileExt = $upload->getFileExt();
            $fileSize = $upload->getFileSize();
            $mimeType = $upload->getMimeType();

//            print "Original File Name: $origFileName<br>\n";
//            print "File Extension: $fileExt<br>\n";
//            print "Mime Type: $mimeType<br>\n";
//            print "File Size: $fileSize<br>\n";
			
			if(!is_dir($target_dir) && !mkdir($target_dir)){
				die("error creating folder $targer_dir"); 
			}
            
         // http://php.net/manual/en/mysqli.real-escape-string.php
            $fileName = $mysqli->real_escape_string($origFileName);
            $dir = $mysqli->real_escape_string($target_dir);

            // Check for errors
            if ($mysqli->connect_error) {
                $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
                require "login_form.php";
                exit;
            }
            
            $username = $_SESSION['loggedin'];
            
            if ($fileExt == 'jpg' || $fileExt == 'gif' || $fileExt == 'png' || $fileExt == 'jpeg') {
                $destFilePath = $target_dir . $origFileName;
                $upload->moveFile($destFilePath);
                $imgQuery = "INSERT INTO images (img_name, img_dir, username) VALUES ('$fileName', '$dir', '$username')";

                if ($mysqli->query($imgQuery) === TRUE) {
                    // How many records were returned?
                    $match = $mysqliResult->num_rows;
            
                        $error = 'Image Uploaded Successfully';
                        require "addPics.php";
                        print 'Success';
                        exit;
                }
            }
            else{
                print "Error: uploaded file must be an image with a file extension of .jpg, .gif, or .png";
            }
            
            

            print "<hr>\n";

        } catch (UploadExceptionNoFile $e) {
            print "No file was uploaded.<br>\n";
        } catch (UploadException $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            print "Error: $message (code=$code)<br>\n";
        }
    }

?>
</body>
</html>
