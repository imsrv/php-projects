<?php
include("prepend.php");
$error = "";
if($save){

	if($cfg_admin_password1 != "" || $cfg_admin_password2 != "") {
		if ($cfg_admin_password1 == $cfg_admin_password2) {
			$cfg_admin_password = md5($cfg_admin_password1);
			$session["password"] = $cfg_admin_password;
		} else {
			$output_msg = "Sorry, your two passwords did not match";
		}
	}

	if(!$output_msg) {
		$cnt = "";
		$cnt .= "<?php\n";
		$cnt .= "define(\"DOCROOT\", \"$cfg_docroot\");\n";
		$cnt .= "define(\"SENDCARD_HOST\", \"$cfg_sendcard_host\");\n";
		$cnt .= "define(\"SENDCARD_DIR\", \"$cfg_sendcard_dir\");\n";
		$cnt .= "define(\"ADMIN_PASSWORD\", \"$cfg_admin_password\");\n";
		$cnt .= "\$first_time = 0;\n";
		$cnt .= "?";
		$cnt .= ">";
		
		$file = fopen("config.php", "w+"); 
		fwrite ($file, $cnt); 
		fclose ($file);
		$output_msg = "Changes saved!";
	}
}



$DOCROOT = DOCROOT;
if ($DOCROOT == "") {
	$DOCROOT = $DOCUMENT_ROOT . "/" . SENDCARD_DIR; 
}

$SENDCARD_HOST = SENDCARD_HOST;
if ($SENDCARD_HOST == "") {
	$SENDCARD_HOST = "http://" . $HTTP_HOST . "/" . SENDCARD_DIR; 
}
?> 


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#ffffff">

<h2><?php echo($output_msg); ?></h2>

<form method="post" action="setup.php">
  <p>Please check that this is the directory you installed sendcard in (from your 
	top public directory).  You must include a trailing slash.<br>
	<input type="text" name="cfg_sendcard_dir" value="<?php echo (SENDCARD_DIR); ?>">
  </p>
  <p>Please check that this is the full pathe to the directory you installed sendcard in. 
	You must include a trailing slash.<br>
	<input type="text" name="cfg_sendcard_host" value="<?php echo ($SENDCARD_HOST); ?>">
  </p>
  <p>So is this the full system path to the directory where sendcard.php is? It must have a trailing slash.<br>
	<input type="text" name="cfg_docroot" value="<?php echo ($DOCROOT); ?>">
  </p>
  <p>If you wish to change your password, please enter a password and confirm it. 
	If you do not wish to change it, please leave these boxes blank.<br>
	<input type="password" name="cfg_admin_password1"><br>
	<input type="password" name="cfg_admin_password2">
  </p>
  <p> 
	<input type="hidden" name="cfg_admin_password" value="<?php echo (ADMIN_PASSWORD); ?>">
	<input type="submit" name="save" value="Save">
	<input type="reset" name="reset" value="Reset">
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
