<!--
    Name: Joel Spencer
    Pawprint: jtswgb    
    Date: 12-11-2020
    Purpose: Final for CS2830 Fall 2020
        Website built for sharing dog images using html, css, javascript, jquery, php, and mySQL
-->
<?php
// Code taken from lecture

    // see: http://us.php.net/manual/en/features.file-upload.php

	// list of UploadExceptionNoFile codes/messages
	// 2000 - no file was uploaded

	// list of UploadException codes/messages
	// 2001 - upload reports that referenced file was not uploaded
	// 2002 - the uploaded file exceeds the upload_max_filesize setting (' . ini_get('upload_max_filesize') . ') in php.ini
	// 2003 - the uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form
	// 2004 - the uploaded file was only partially uploaded
	// 2005 - the temporary directory is missing
	// 2006 - failed to write upload file to disk
	// 2007 - file upload was stopped by an extension
	// 2008 - an unknown error during the file upload
	// 2009 - uploaded file ({$this->origFileName}) could not be moved to file storage

	// refer to: http://us3.php.net/manual/en/features.file-upload.php
	// and: http://us3.php.net/manual/en/reserved.variables.files.php

	class UploadExceptionNoFile extends Exception {
		public function __construct($message, $code) {
			parent::__construct($message, $code);
		}
	}

	class UploadException extends Exception {
		public function __construct($message, $code) {
			parent::__construct($message, $code);
		}
	}

	class Upload {
		protected $inputName;
		protected $file;
		protected $mimeType;
		protected $fileSize;
		protected $origFileName;
		protected $fileExt;

		public function __construct($file) {
			$this->file = $file;

			try {
				$this->checkUploadError($this->file);
			} catch (Exception $e) {
				throw $e;
			}

			$this->mimeType = $this->file['type'];
			$this->origFileName = $this->file['name'];
			$this->tempFileName = $this->file['tmp_name'];
			$this->fileSize = $this->file['size'];

      // determine file extension of the original file
			preg_match('/\.([^\.]*$)/', $this->origFileName, $match);

			if (!empty($match)) {
				$this->fileExt = strtolower($match[1]);
			}
			else {
				$this->fileExt = '';
			}

		}

    public function moveFile($destPath) {
  		if (! move_uploaded_file($this->tempFileName, $destPath) ) {
				throw new UploadException("uploaded file ({$this->origFileName}) could not be moved to file storage", 2009);
			}
    }

		public function getInputName() {
			return $this->inputName;
		}

		public function getFile() {
			return $this->file;
		}

		public function getMimeType() {
			return $this->mimeType;
		}

		public function getFileSize() {
			return $this->fileSize;
		}

		public function getOrigFileName() {
			return $this->origFileName;
		}

		public function getTempFileName() {
			return $this->tempFileName;
		}

		public function getFileExt() {
			return $this->fileExt;
		}

		private function checkUploadError() {
			$error = $this->file['error'];

			switch($error) {
				case UPLOAD_ERR_OK:
					if (is_uploaded_file($this->file['tmp_name'])) {
						return;
					} else {
						throw new UploadException('upload reports that referenced file was not uploaded', 2001);
					}
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new UploadExceptionNoFile('no file was uploaded', 2000);
					break;
				case UPLOAD_ERR_INI_SIZE:
					throw new UploadException('the uploaded file exceeds the upload_max_filesize setting (' . ini_get('upload_max_filesize') . ') in php.ini', 2002);
					break;
				case UPLOAD_ERR_FORM_SIZE:
					throw new UploadException('the uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 2003);
					break;
				case UPLOAD_ERR_PARTIAL:
					throw new UploadException('the uploaded file was only partially uploaded', 2004);
					break;
				case UPLOAD_ERR_NO_TMP_DIR:
					throw new UploadException('the temporary directory is missing', 2005);
					break;
				case UPLOAD_ERR_CANT_WRITE:
					throw new UploadException('failed to write upload file to disk', 2006);
					break;
				case UPLOAD_ERR_EXTENSION:
					throw new UploadException('file upload was stopped by an extension', 2007);
					break;
				default:
					throw new UploadException('an unknown error during the file upload', 2008);
			}
		}

		// The purpose of this function is to reorder the contents of $_FILES
		public static function reorderFilesArray($inputName) {
			// Check to see if a file was uploaded
			if (empty($_FILES[$inputName])) {
				throw new UploadExceptionNoFile('no file was uploaded', 2000);
			}

			// We will return an array of files
			$arrayOfFiles = array();

			// Get file information from $_FILES
			$filesInfo = $_FILES[$inputName];

			// Check to see there is any file info
			if (isset($filesInfo)) {
				// Pull out name, type, etc. arrays
				$originalNames = $filesInfo['name'];
				$mimeTypes = $filesInfo['type'];
				$tempNames = $filesInfo['tmp_name'];
				$sizes = $filesInfo['size'];
				$errors = $filesInfo['error'];

				// Check to see if there was only one file uploaded
				if (gettype($originalNames) != 'array') {
					$arrayOfFiles[0] = $filesInfo;  // since there is only one
				}
				else {
					$numFiles = count($originalNames);
					for ($i = 0; $i < $numFiles; $i++) {
						$file = array();
						$file['name'] = $filesInfo['name'][$i];
						$file['type'] = $filesInfo['type'][$i];
						$file['tmp_name'] = $filesInfo['tmp_name'][$i];
						$file['size'] = $filesInfo['size'][$i];
						$file['error'] = $filesInfo['error'][$i];
						$arrayOfFiles[$i] = $file;
					}
				}
			}
			else {
				// If there is no file information, throw an exception
        		throw new UploadExceptionNoFile("no file was uploaded", 2000);
			}

			// Return the file(s)
			return $arrayOfFiles;
		}
	}
?>