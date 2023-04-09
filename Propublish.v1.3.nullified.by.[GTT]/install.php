<html>

<head>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>


<h2>PHP ProPublish Install Program</h2>

<p>PHP ProPublish is a program by DeltaScripts. <br />By installing this
program, you agree to the licence terms.</p> 

<? 
$url ="";
$error = 0;
$no_pre_errors = 1;

// Do some checks

// Check that 
if (file_exists("admin/db.php"))
{
	echo "<p><b>Information</b><br>The program seems to already be installed, since databasefile db.inc.php already exists!
	 Installer will now exit due to security reasons.</p>";
	//exit;
}


if (fileperms("admin/")<>16895)
{
	echo "<p><b>Notice:</b><br>Your admin directory is not writeable. Do \"chmod 777\".</p>";
}


// Check filepermissions
if (isset($_POST["submit"]))
{
	echo "<h3>Doing install stuff</h3>";
	
	
	// Set up database
	mysql_connect ($_POST["mysql_host"],$_POST["mysql_user"],$_POST["mysql_pass"]);
	mysql_select_db ($_POST["mysql_db"]);
	
	// Setting up datbasefile
	$file_name = "admin/db.php";
  	$file_pointer = fopen($file_name, "w");
  	fwrite($file_pointer,'<?
	mysql_connect ("' . $_POST["mysql_host"] . '","' . $_POST["mysql_user"] . '","' . $_POST["mysql_pass"] . '");
	mysql_select_db ("' . $_POST["mysql_db"] . '"); ?>');
  	fclose($file_pointer);
	
	
	$filename = 'propub.sql';     
	$handle = fopen($filename, "rb"); 
	$contents = fread ($handle, filesize ($filename)); 
	$contents .= "\n\n"; 
	fclose ($handle); 
	$queries = explode(";", $contents); 
	$querycount = count($queries)-1; 

	for($i=0; $i < $querycount; $i++) 
	{ 
    	$result = mysql_query($queries[$i]); 
	    if(mysql_errno() != 0)
	    {  
	        echo '<br>' . mysql_errno() . ": " . mysql_error(). "\n"; 
	        $error = 1;
	    }
	}

	
	// Set up default settings
	$file_name = "admin/set_inc.php";
  	$file_pointer = fopen($file_name, "w");
  	fwrite($file_pointer,"<?
  	\$set_email=\"\";
 	\$set_htmleditor=\"1\";
	\$set_normaleditor=\"1\";
	\$fp_limit=\"20\";
	\$lang=\"eng.php\";
	\$set_url=\"" . $_POST["url"] . "\";
	\$set_inform_new=\"\";
	\$set_autovalidate=\"1\";
	\$text_w_plain=\"64\";
	\$text_h_plain=\"25\";
	\$text_w_html=\"534\";
	\$text_h_html=\"300\";
  	\r ?>");
  	fclose($file_pointer);
  	
  	  	
  	
	if (!$error)
	{
		echo "<p><b>INSTALLED</b></p>";	
		echo "<p>Program was successfully installed. Please delete this file now, then ";
		echo "visit <a href='login.php/'><b><u>adminarea</u></b></a> to complete the settings.
		<p>Username: <b>admin@gtt.com</b><br>Password: <b>GTT</b>. </p>";
		
	}
	
	
	if ($error)
	{
		echo "<p><b><font color='red'>Warning: Install Failed</font></b></p>";	
		echo "<p>Please review the settings you gave us, go back to correct. Do NOT proceed.</p>";
		
		echo "<p>" . $_POST["mysql_host"] . "<br />";
		echo $_POST["mysql_db"] . "<br />";
		echo $_POST["mysql_user"] . "<br />";
		echo $_POST["mysql_pass"] . "<br />";
		echo $_POST["url"] . "<br />";
	}	
}
elseif ($no_pre_errors) 
{
?>	

<form method="post" action="install.php">

<h3>MySQl database-info</h3>
<p>Hostname:<br /><input type='text' name='mysql_host'></p>
<p>Databasename:<br /><input type='text' name='mysql_db'></p>
<p>Username:<br /><input type='text' name='mysql_user'></p>
<p>Password:<br /><input type='text' name='mysql_pass'></p>

<h3>Simple Settings</h3>
<p>URL (to this dir, no trailing slash):<br /><input type='text' name='url' size="50" value="http://"></p>

<p><input type="submit" name="submit" value="Install program" /></p>
</form>
<?
}
else 
{
		
}
/*
	Pro Publish v1.3
	Nullified by GTT
*/
?>

</body>
</html>