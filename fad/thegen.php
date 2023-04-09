<? if($_POST['dest']){
 $itsdone = true;
	$query = "SELECT * FROM online WHERE id='1'";
	$result=@mysql_query($query);
	$row = @mysql_fetch_array($result);
	$num = $row[1];
	$num = $num+1;
	$query = "UPDATE online SET `count`='$num' WHERE id='1'";
	$result=@mysql_query($query);
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
		
	if($_POST['username'] != NULL){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$logontext = "<?
		//***********************************************************************************//
		//** Please leave this message alone, no one will be able to see it, except coders.**//
		// This script is copyrighted by PHP scripts, a Marsal Design Company.***************//
		// To get your own verison of this system, please do download it from our site*******//
		// located at http://www.free-php-scripts.net.***************************************//
		// Script is free, no advertisement, no nothing....**********************************//
		//***********************************************************************************//
		
		@session_start();
		// Check Log-In Info";
		
		if($logstyle == 'sessions') {
			$logontext .= '
			if($_SESSION["adminin"] == "Yes") {
				header(\'Location: ' . $destination . '\');
				exit();
			}';
		}
		if($logstyle == 'cookies') {
			$logontext .= '
			if($_COOKIE["adminin"] == "Yes") {
				header(\'Location: ' . $destination . '\');
				exit();
			}';
		}
		if($logstyle == 'both') {
			$logontext .= '
			if($_SESSION["adminin"] == "Yes" || $_SESSION["adminin"] == "Yes") {
				header(\'Location: ' . $destination . '\');
				exit(); 
			}';
		}	
		$logontext .= '
		// If the form was submited check if the username and password match
		
		if($_POST["Submit"]){
			if($_POST["username"] == ' . $username . ' && $_POST["password"] == ' . $password . '){
			// Log User In
			// If username and password is right , store the session in a cookie';
		if($logstyle == 'sessions') {
			$logontext .= '
			$_SESSION["adminin"] = "Yes";';
		}
		if($logstyle == 'cookies') {
			$logontext .= '
			setcookie ("adminin", "Yes",time()+' . $session_len . ');';
		}
		if($logstyle == 'both') {
			$logontext .= '
			setcookie ("adminin", "Yes",time()+' . $session_len . '); // Set the length of the cookie to selected time in seconds
			$_SESSION["adminin"] = "Yes";';
		}				
		if($_POST['pastrack'] == 'yes'){
			$goback = '$_SERVER["HTTP_REFERRER"]';
		} else {
			$goback == NULL;
		}
		if($goback == NULL){		
			$location = $destination;
			$logontext .= '
			// Redirect to the page
				header("Location: ' . $location . '");
				exit();';
		} else {
			$location = $goback;
			$logontext .= '
			// Redirect to the page
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
			$error = "Password and/or Username Not Valid, Please Try Again!";
		}
		}?>
		<html>
		<head>
		<title>Please Log In</title>
		</head>
		<body>
		<form action="<? echo $_SERVER["PHP_SELF"];?>" method="post" name="adminlogin" id="adminlogin">
	 	<table width="100%" border="5" align="center" cellpadding="5" cellspacing="0">
    	<tr bgcolor="#000000"> 
      	<td colspan="2"><div align="center"><font color="#FFFFFF"><strong>PLEASE 
        LOG IN:</strong></font></div></td>
	    </tr>
    	<tr> 
      	<td width="47%"><font face="Georgia, Times New Roman, Times, serif"><strong>Username:</strong></font></td>
      	<td width="53%"><input name="username" type="text"  class="input" id="username" size="25"></td>
    	</tr>
    	<tr> 
      	<td><font face="Georgia, Times New Roman, Times, serif"><strong>Password:</strong></font></td>
      	<td><input name="password" type="password" id="password" size="22"></td>
    	</tr>
    	<tr> 
      	<td colspan="2"><div align="center"><font face="Georgia, Times New Roman, Times, serif"><strong>
        <input name="Submit" type="submit" id="Submit"  value="Log In">
        </strong></font> </div></td>
    	</tr>
	 	</table>
  		<table width="100%" border="0">
    	<tr>
      	<td><div align="center"><strong><font color="#FF0000"><? echo $error; ?></font></strong></div></td>
    	</tr>
  		</table>
  		</form>
 		</html>
 		</body>';
		$short = '$_SESSION';	
		$logofftext = "<?
		//***********************************************************************************//
		//** Please leave this message alone, no one will be able to see it, except coders.**//
		// This script is copyrighted by PHP scripts, a Marsal Design Company.***************//
		// To get your own verison of this system, please do download it from our site*******//
		// located at http://www.free-php-scripts.net.***************************************//
		// Script is free, no advertisement, no nothing....**********************************//
		//***********************************************************************************//
		// ------------------------ KILL ALL -----------------------------------------------------
		session_start();
		// Delete the cookie
		setcookie ('adminin','');
		// Set its time to minus 300 (more secure)
		setcookie ('adminin' , '',time()-43200);
		// End All Session ID'S
		" . $short . " = array();
		// KILL ALL SESSIONS
		session_destroy();
		//Rdirect User our
		header('Location: login.php' );
		exit(); ?>";
		if($logstyle == 'sessions') {
			$protecttext = '<?
		@session_start();
		if($_SESSION["adminin"] != "Yes"){
			header("Location: login.php");
			exit();
		} ?>';
		}
		if($logstyle == 'cookies') {
			$protecttext = '<?
		if($_COOKIE["adminin"] != "Yes"){
			header("Location: login.php");
			exit();
		} ?>';
		}
		if($logstyle == 'both') {
			$protecttext = '<?
		@session_start();
		if($_COOKIE["adminin"] != "Yes" && $_SESSION["adminin"] != "Yes"){
			header("Location: login.php");
			exit();
		}?>';
		}
	} else {
	$username = $_POST['dusername'];
	$password = $_POST['dpassword'];
	$host = $_POST['hostname'];
	$dataname = $_POST['dataname'];
	$tablename = $_POST['tablenames'];
	$userfield = $_POST['field1'];
	$passfield = $_POST['field2'];
	$care = '$dbc';
	$logontext = "<?
	//***********************************************************************************//
	//** Please leave this message alone, no one will be able to see it, except coders.**//
	// This script is copyrighted by PHP scripts, a Marsal Design Company.***************//
	// To get your own verison of this system, please do download it from our site*******//
	// located at http://www.free-php-scripts.net.***************************************//
	// Script is free, no advertisement, no nothing....**********************************//
	//***********************************************************************************//
	//First thing To Do is to check if the user have already logged in, if they did, redirect to main page instead of
	// Having to log-in Again
	@session_start();
	define ('DB_USER', '" . $username ."'); // Database User Name
	define ('DB_PASSWORD', '" . $password . "'); // Database User Password
	define ('DB_HOST', '" . $host . "'); // Host Name (mostly localhost)
	" . $care . " = mysql_connect (DB_HOST, DB_USER, DB_PASSWORD); // Establishes connection
	mysql_select_db('" . $dataname . "');  // database name to connect to
	// Check Log-In Info";
	if($logstyle == 'sessions') {
		$logontext .= '
		if($_SESSION["adminin"] == "Yes") {
			header(\'Location: ' . $destination . '\');
			exit();
		}';
	}
	if($logstyle == 'cookies') {
		$logontext .= '
		if($_COOKIE["adminin"] == "Yes") {
			header(\'Location: ' . $destination . '\');
			exit();
		}';
	}
	if($logstyle == 'both') {
		$logontext .= '
		if($_SESSION["adminin"] == "Yes" || $_SESSION["adminin"] == "Yes") {
			header(\'Location: ' . $destination . '\');
			exit();
		}
		$theuser = $_POST["username"];
		$thepass = $_POST["password"];';
	}	
	$hate = '$query';
	$user = '$theuser';
	$pass = '$thepass';
	if($_POST['passis'] == 'text'){
		$queryn = " = \"SELECT * FROM " . $tablename . " WHERE `" . $userfield . "`='$user' AND `" . $passfield . "`='$pass'\";";
	} else {
		$queryn = " = \"SELECT * FROM " . $tablename . " WHERE `" . $userfield . "`='$user' AND `" . $passfield . "`=PASSWORD('$pass')\";";
	}
	
	$logontext .= '
	// If the form was submited check if the username and password match
	if($_POST["Submit"]){
		' . $hate .  $queryn . '
		$result = @mysql_query($query);
		$num = @mysql_num_rows($result);
			if($num != 0){
				// Log User In
				// If username and password is right , store the session in a cookie';

	if($logstyle == 'sessions') {
		$logontext .= '
				$_SESSION["adminin"] = "Yes";';
	}
	if($logstyle == 'cookies') {
		$logontext .= '
				setcookie ("adminin", "Yes",time()+' . $session_len . ');';
	}
	if($logstyle == 'both') {
		$logontext .= '
				setcookie ("adminin", "Yes",time()+' . $session_len . '); // Set the length of the cookie to selected time in seconds
				$_SESSION["adminin"] = "Yes";';
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
		$logontext .= '
		// Redirect to the page
		if($_SERVER["HTTP_REFERRER"] != NULL){
			header("Location: " . $_SERVER["HTTP_REFERRER"]);
			exit();
		} else {
			header("Location: ' . $destination . '");
			exit();
		}';
	}	
		
	$logontext .= '} else {
			$error = "Password and/or Username Not Valid, Please Try Again!";
		}
		} ?>
		<html>
		<head>
		<title>Please Log In</title>
		</head>
		<body>
		<form action="<? echo $_SERVER["PHP_SELF"];?>" method="post" name="adminlogin" id="adminlogin">
		<table width="100%" border="5" align="center" cellpadding="5" cellspacing="0">
	    <tr bgcolor="#000000"> 
	    <td colspan="2"><div align="center"><font color="#FFFFFF"><strong>PLEASE 
        LOG IN:</strong></font></div></td>
	    </tr>
    	<tr> 
      	<td width="47%"><font face="Georgia, Times New Roman, Times, serif"><strong>Username:</strong></font></td>
	    <td width="53%"><input name="username" type="text"  class="input" id="username" size="25"></td>
	    </tr>
    	<tr> 
	    <td><font face="Georgia, Times New Roman, Times, serif"><strong>Password:</strong></font></td>
    	<td><input name="password" type="password" id="password" size="22"></td>
	    </tr>
    	<tr> 
	    <td colspan="2"><div align="center"><font face="Georgia, Times New Roman, Times, serif"><strong>
        <input name="Submit" type="submit" id="Submit"  value="Log In">
        </strong></font> </div></td>
    	</tr>
  		</table>
  		<table width="100%" border="0">
    	<tr>
      	<td><div align="center"><strong><font color="#FF0000"><? echo $error; ?></font></strong></div></td>
    	</tr>
  		</table>
  		</form>
  		</html>
 		</body>';
		$short = '$_SESSION';
		$logofftext = "<?
		//***********************************************************************************//
		//** Please leave this message alone, no one will be able to see it, except coders.**//
		// This script is copyrighted by PHP scripts, a Marsal Design Company.***************//
		// To get your own verison of this system, please do download it from our site*******//
		// located at http://www.free-php-scripts.net.***************************************//
		// Script is free, no advertisement, no nothing....**********************************//
		//***********************************************************************************//
		// ------------------------ KILL ALL -----------------------------------------------------
		session_start();
		// Delete the cookie
		setcookie ('adminin','');
		// Set its time to minus 300 (more secure)
		setcookie ('adminin' , '',time()-43200);
		// End All Session ID'S
		" . $short . " = array();
		// KILL ALL SESSIONS
		session_destroy();
		//Rdirect User our
		header('Location: login.php' );
		exit(); ?>";
	if($logstyle == 'sessions') {
		$protecttext = '<?
		@session_start();
		if($_SESSION["adminin"] != "Yes"){
			header("Location: login.php");
			exit();
		} ?>';
	}
	if($logstyle == 'cookies') {
		$protecttext = '<? if($_COOKIE["adminin"] != "Yes"){
		header("Location: login.php");
		exit();} ?>';
	}
	if($logstyle == 'both') {
		$protecttext = '<?
		@session_start();
		if($_COOKIE["adminin"] != "Yes" && $_SESSION["adminin"] != "Yes"){
			header("Location: login.php");
			exit();
		}?>';
	}	
	
}
}
?>