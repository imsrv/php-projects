<?
//+----------------------------------
//	AnnoucementX
//	Version: 1.0
//	Author: Cat
//	Created: 2004/11/28
//	Description: Handle the Admin CP
//+----------------------------------

session_start();

error_reporting (E_ERROR | E_WARNING | E_PARSE);

require('../conf_global.php');

define ('USER',$username_file);
define ('PASS',$password_file);
define ('DATA',$database_file);
define ('HOST',$host_file);

$index=true;

if (phpversion() >= "4.2.0") {

	$login = $_GET['login'];

}

if ($login=='yes') {

	$user=$_POST['user'];
	$pass=$_POST['pass'];
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$if=mysql_query("SELECT `Group` FROM members WHERE `Name`='$user' AND `Password`='$pass'") or die("AnnouncementX Error: " . mysql_error());
	$result=mysql_fetch_row($if);
	
	$if_2=mysql_query("SELECT `Pr_admin` FROM groups WHERE `Name`='$result[0]'") or die ("AnnouncementX Error: " . mysql_error());
	$result_2=mysql_fetch_row($if_2);
		
	mysql_close($link);
	
		if ($result_2[0] == 'yes') {
	
			$_SESSION['admin_username']=$user;
			$_SESSION['admin_password']=$pass;
			echo "Sessions are set<br /><a href='./index.php?".strip_tags(sid)."'>Click here to continue</a>";
			exit;
	
		} else {
		
			echo "Error: you do not have permission to administrate AnnouncementX<br />Or password that you have entered is incorrect";
			exit;
		
		}

}


$username=$_SESSION['admin_username'];
$password=$_SESSION['admin_password'];

if (isset($username,$password) && $username!='') {

		echo "<html>
		<head>
		<title>AnnouncementX Admin CP</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<link href='admin_cp_css.css' rel='stylesheet' type='text/css'>
		</head>
		
		<frameset cols='200,*' noresize>
		  <frame name='contents' target='main' src='./admin_menu.php?username=".$username."&password=".$password."'>
		  <frame name='main' src='./admin_main.php?username=$username&password=$password&code='>
		  <noframes>
		  <body>
		
		  <p>This page uses frames, but your browser doesn't support them.</p>
		
		  </body>
		  </noframes>
		</frameset>
		
		</html>";		

} else {

	echo "<html>
		<head>
		<title>AnnouncementX Admin CP - Login</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<link href='admin_cp_css.css' rel='stylesheet' type='text/css'>
		</head>
		<body>
		<table width='100%' height='90%' align='center' border='0'>
			<tr>
				<td align='center'>
					<table width='250' align='center' border='1' bordercolor='#000000' style='border-collapse: collapse' cellpadding='3'>
						<tr>
							<td align='center' class='header'>
							Please, LogIn
							</td>
						</tr>
						<tr>
							<td align='center' class='table_row' height='240'>
								<form name='login' action='./index.php?login=yes' method='post'>
									<label for='name'>Username: </label>
									<input type='text' name='user' class='field' value='' size='25'>
									<br /><br />
									<label for='pass'>Password: </label>
									<input type='password' name='pass' class='field' value='' size='22'>
									<br /><br />
									<input type='submit' name='submit' value='Login to AdminCP' class='submit'>
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</body>
		</html>";

}

?>
