<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/

	$destination = $_POST['dest'];
	$time = $_POST['time'];
	$timeframe = $_POST['timeis'];
	if($timeframe == 'seconds'){
		$session_len = $time * 1;
	}
	if($timeframe == 'minutes'){
		$session_len = $time * 60;
	}
	if($timeframe == 'hours'){
		$session_len = $time * 3600;
	}
	if($timeframe == 'days'){
		$session_len = $time * 86400;
	}
	if($timeframe == 'weeks'){
		$session_len = $time * 604800;
	}
	if($timeframe == 'months'){
		$session_len = $time * 18748800;
	}
	if($timeframe == 'years'){
		$session_len = $time * 224985600;
	}

	$logstyle = $_POST['logstyle'];	

	//If loggin the user via username/password
	if($_POST['username'] != NULL){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$logontext = "<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
//Start session
session_start();";
	
	$logontext .= '
// If the form was submited check if the username and password match
	if($_POST["username"] != NULL){

	if($_POST["username"] == "' . $username . '" && $_POST["password"] == "' . $password . '"){
	
	// Log User In';

	if($logstyle == 'sessions' || $logstyle == 'both') {
		$logontext .= '
		$_SESSION["adminin"] = "yes";';
	}

	if($logstyle == 'cookies' || $logstyle == 'both') {
		$logontext .= '
		setcookie ("adminin", "yes",time()+' . $session_len . ');';
	}

	if($_POST['pastrack'] == 'yes'){
		$goback = '$_SERVER["HTTP_REFERRER"]';
	} else {
		$goback == NULL;
	}

	if($goback == NULL){		
		$location = $destination;
		$logontext .= '
// Redirect to the main page
	header("Location: ' . $location . '");
	exit();';
	} else {
		$location = $goback;
		$logontext .= '
// Redirect to the page last viewed (tried to access but couldn\'t)
		
		if($_SERVER["HTTP_REFERRER"] != NULL){
			header("Location: " . $_SERVER["HTTP_REFERRER"]);
			exit();
		} else {
			header("Location: ' . $destination . '");
			exit();		
		}';
	}	

	$logontext .= '
	 } else {
		$message = "Password and/or Username Not Valid, Please Try Again!";
	}
}

if($message != NULL){
?>
<table width="100%" border="0">
    <tr>
      <td><div align="center"><strong><font color="#FF0000"><? echo $message; ?></font></strong></div></td>
    </tr>
</table>
<?php } ?>  
<form action="<? echo $_SERVER["PHP_SELF"];?>" method="post" name="adminlogin" id="adminlogin">
  <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
    <tr bgcolor="#99CC99"> 
      <td colspan="2"><div align="center"><strong>Please log in:</strong></div></td>
    </tr>
    <tr> 
      <td width="47%"><strong>Username:</strong></td>
      <td width="53%"><input name="username" type="text"  class="input" id="username" size="25"></td>
    </tr>
    <tr> 
      <td><strong>Password:</strong></td>
      <td><input name="password" type="password" id="password" size="22"></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center"><strong>
          <input name="Submit" type="submit" id="Submit"  value="Log In">
          </strong> </div></td>
    </tr>
  </table>
</form>';
	
	$logofftext = '<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/

	session_start();
	// Delete the cookie
	setcookie (\'adminin\',\'\');
	// Set its time to minus 300 (more secure)
	setcookie (\'adminin\' , \'\',time()-43200);

	// End All Session ID\'S
	$_SESSION = array();
	// KILL ALL SESSIONS
	session_destroy();
	//Rdirect User our
	header(\'Location: login.php\' );
	exit();
?>';

	if($logstyle == 'sessions') {
		$protecttext = '<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
session_start();
if($_SESSION["adminin"] != "yes"){
	header("Location: login.php");
	exit();	
} ?>';
	}

	if($logstyle == 'cookies') {
		$protecttext = '<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
session_start();
if($_COOKIE["adminin"] != "yes"){
	header("Location: login.php");
	exit();	
} ?>';
	}

	if($logstyle == 'both') {
		$protecttext = '<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
session_start();
if($_COOKIE["adminin"] != "yes" && $_SESSION["adminin"] != "yes"){
	header("Location: login.php");
	exit();
}
?>';
	}
		
} else {
//If submitting to a database,	
$username = $_POST['dusername'];
$password = $_POST['dpassword'];
$host = $_POST['hostname'];
$dataname = $_POST['dataname'];

$tablename = $_POST['tablenames'];
$userfield = $_POST['field1'];
$passfield = $_POST['field2'];


$logontext = '<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/

session_start();

// Database User Name
define (\'DB_USER\', \'' . $username .'\');
// Database User Password 
define (\'DB_PASSWORD\', \'' . $password . '\'); 
// Host Name (mostly localhost)
define (\'DB_HOST\', \'' . $host . '\'); 
// Establishes connection
$dbc = mysql_connect (DB_HOST, DB_USER, DB_PASSWORD); 
// database name to connect to
mysql_select_db(\'' . $dataname . '\');  

// Check Log-In Info';

	if($logstyle == 'sessions') {
		$logontext .= 'if($_SESSION["adminin"] == "yes") {
		header(\'Location: ' . $destination . '\');
		exit();
		}';
	}

	if($logstyle == 'cookies') {
		$logontext .= 'if($_COOKIE["adminin"] == "yes") {
		header(\'Location: ' . $destination . '\');
		exit();
		}';
	}

	if($logstyle == 'both') {
		$logontext .= 'if($_SESSION["adminin"] == "yes" || $_SESSION["adminin"] == "yes") {
		header(\'Location: ' . $destination . '\');
		exit();
		}
		
		//Collect user submited info
		$theuser = $_POST["username"];
		$thepass = $_POST["password"];';
	}	

	$hate = '$query';
	$user = '$theuser';
	$pass = '$thepass';
	if($_POST['passis'] == 'text'){
		$queryn = " = @mysql_query(\"SELECT * FROM " . $tablename . " WHERE `" . $userfield . "`='$user' AND `" . $passfield . "`='$pass'\");";
	} else {
		$queryn = " = @mysql_query(\"SELECT * FROM " . $tablename . " WHERE `" . $userfield . "`='$user' AND `" . $passfield . "`=PASSWORD('$pass')\");";
	}
	
	$logontext .= '
// If the form was submited check if the username and password match
	if($_POST["username"] != NULL){

	$get_user '. $queryn . '
	$user_count = @mysql_num_rows($get_user);
	if(@mysql_num_rows($get_user) <= 0){
	
	// Log User In
	// If username and password is right , store the session in a cookie';

	if($logstyle == 'sessions') {
		$logontext .= '
		$_SESSION["adminin"] = "yes";';
	}

	if($logstyle == 'cookies') {
		$logontext .= '
		setcookie ("adminin", "yes",time()+' . $session_len . ');';
	}

	if($logstyle == 'both') {
		$logontext .= '
		setcookie ("adminin", "yes",time()+' . $session_len . '); 
		$_SESSION["adminin"] = "yes";';
	}				


if($_POST['pastrack'] == 'yes'){
	$goback = '$_SERVER["HTTP_REFERRER"]';
} else {
	$goback == NULL;
}

		
	if($goback == NULL){		
		$location = $destination;
		$logontext .= '// Redirect to the page
		header("Location: ' . $location . '");
		exit();';
	} else {
		$location = $goback;
		$logontext .= '// Redirect to the page
		
		if($_SERVER["HTTP_REFERRER"] != NULL){
			header("Location: " . $_SERVER["HTTP_REFERRER"]);
			exit();
		} else {
			header("Location: ' . $destination . '");
			exit();
		
		}';
	}	
		


$logontext .= '} else {
		$message = "Password and/or Username Not Valid, Please Try Again!";
	}
}

if($message != NULL){
?>
  <table width="100%" border="0">
    <tr>
      <td><div align="center"><strong><font color="#FF0000"><? echo $message; ?></font></strong></div></td>
    </tr>
  </table>
<?php } ?>  
<form action="<? echo $_SERVER["PHP_SELF"];?>" method="post" name="adminlogin" id="adminlogin">
  <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#00CCFF">
    <tr bgcolor="#99CC99"> 
      <td colspan="2"><div align="center"><strong>Please login:</strong></div></td>
    </tr>
    <tr> 
      <td width="47%"><strong>Username:</strong></td>
      <td width="53%"><input name="username" type="text"  class="input" id="username" size="25"></td>
    </tr>
    <tr> 
      <td><strong>Password:</strong></td>
      <td><input name="password" type="password" id="password" size="22"></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center"><font face="Georgia, Times New Roman, Times, serif"><strong>
          <input name="Submit" type="submit" id="Submit"  value="Log In">
          </strong></font> </div></td>
    </tr>
  </table>
</form>';

$logofftext = '<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/

	session_start();
	// Delete the cookie
	setcookie (\'adminin\',\'\');
	// Set its time to minus 300 (more secure)
	setcookie (\'adminin\' , \'\',time()-43200);

	// End All Session ID\'S
	$_SESSION = array();
	// KILL ALL SESSIONS
	session_destroy();
	//Rdirect User our
	header(\'Location: login.php\');
	exit();
?>';
	if($logstyle == 'sessions') {
		$protecttext = '<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
session_start();
if($_SESSION["adminin"] != "yes"){
	header("Location: login.php");
	exit();
	
} ?>';
	}

	if($logstyle == 'cookies') {
		$protecttext = '<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
session_start();
if($_COOKIE["adminin"] != "yes"){
	header("Location: login.php");
	exit();
	
} ?>';
	}

	if($logstyle == 'both') {
		$protecttext = '<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
session_start();
if($_COOKIE["adminin"] != "yes" && $_SESSION["adminin"] != "yes"){
	header("Location: login.php");
	exit();
	
}
?>';
	}
}

?>