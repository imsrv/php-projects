<html>
<head>
<title>Upload Test</title>
</head>

<h1>File Upload Test</h1>
<form name="form1" method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data">
  <p>File to upload: <input type="file" name="file"><br>
  Destination folder <font size="1">(must have permission of 777)</font>: <input type="text" name="path"> (ie: /home/username/public_html/images)
  <br><input type="submit" name="submit" value="submit">
</form>

<?php
if ($file && $path && $submit) {
	echo "<hr>";
	//if (copy($file, "$path/$file_name")) { 
	if (move_uploaded_file($file, "$path/$file_name")) {
		echo "Your file (".$file_name.") was uploaded successfully! You should see it listed below in bold red.";
		echo "<hr>";
		echo dir_list($path,$file_name); 
	}
	else { echo "*** ERROR *** Your file was not successfully uploaded"; }
}


function dir_list($dir,$filename) {
	echo "<h3>Listing Of " . $dir . "</h3>";							   				
	$directory = opendir($dir);		    					
    
	if($directory) {
		while (($file = readdir($directory)) !== false) {
			if ($file != "." && $file != "..") {
				if ($file == $filename) { echo "<font color='red'><b>"; }
				echo $file;
				if ($file == $filename) { echo "</b></font>"; }
				echo "<br>";
			}
		}
    }
	closedir($directory);  
}

?>

</body>
</html>
