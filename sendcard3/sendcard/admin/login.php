<?php
session_start();

if(isset($process)) {
include("config.php");

$session["password"] = md5($password);
	if($session["password"] == ADMIN_PASSWORD) {
		session_register("session");
		$error = "You are now logged in.  please <a href=\"index.php\">click here</a> to continue.";
		header("Location: $redirect");
	} else {
		$error = "Sorry, your password was incorrect.  Please try again.";
	}

}

if(isset($action) && $action == "logout") {
	session_destroy();
	$error = "You are now logged out";
}
if(!isset($error) ) {
	$error = "";
}

?>



<html>
<head>
<title>sendcard administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF">
<p>&nbsp;</p>
<h2 align="center" color="#FF0000"><?php echo $error; ?></h2>
<table width="300" border="1" cellspacing="0" cellpadding="10" align="center" bordercolor="#333333">
  <tr bgcolor="#CCFF00"> 
	<td> <font size="+2">sendcard login </font> 
	  <form name="form1" method="post" action="login.php">
		Enter your password: 
		<input type="password" name="password">
		<input type="hidden" name="process" value="1">
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
		<input type="submit" name="submit" value="Submit">
	  </form>
	</td>
  </tr>
</table>
<p>&nbsp; </p>
</body>
</html>
