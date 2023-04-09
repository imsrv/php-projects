<?
//----------------------------------------//
// Decoded and fixed by WAXZY [MST]
// 07/30/2007
//----------------------------------------//
session_name('MST2007');
session_cache_limiter('nocache');
session_start();
include("you_config.php");
$mypass = 'MST2007.php';
if (file_exists("$mypass")){
	include ("$mypass");
}
$mode = strtolower(trim(strip_tags($_GET['mode'])));
$offset = 60 * 60 * 24 * -1;
header('Cache-Control: public, must-revalidate');
//header("Pragma: private");
header('Expires: '.gmdate('D, d M Y H:i:s', time() + $offset).' GMT');
if ($mode == 'logout') {
	$_SESSION = array();
	$err = "<span class=\"B2\">YOU ARE NOW LOGGED OUT!</span>";
}
$submitted = trim(strip_tags($_POST['submitted']));
if ($submitted == 'true') { 
	$err = "<font color=\"#CC0000\" size=\"-2\" face=\"Arial\">ERROR INVALID ADMIN LOGIN!</font>";
	$username = trim(strip_tags($_POST['Username']));
	$password = trim(strip_tags($_POST['Password']));
	if ($username == $user && md5($password) == $pass) { 
		$_SESSION['Logged_In'] = 'true';
		$_SESSION['Username']  = $user;
		header('HTTP/1.x');
		print '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">'."\n".
		'<html><head>'."\n".
		'<title>Loading Admin!</title>'."\n".'<link href="admin.css" rel="stylesheet" type="text/css">'."\n".
		'</head><body>'."\n".
		'<META HTTP-EQUIV=REFRESH CONTENT="1; URL=http://'.$_SERVER['SERVER_NAME'].''.$path_to_dir.'admin.php">'."\n".
		'<DIV ALIGN="CENTER"><span class="M1"><B>Loading...</B>'."\n".
		'<BR>System is being loaded please wait.</span>'.
		'</DIV></body></html>'."\n";
		exit;
	} 
} 
// Loginform ...
if ($_SESSION['Logged_In'] != 'true') {
	// NS Check!
	$navigator_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if (stristr($navigator_user_agent, 'gecko')){
		$spacer = '&nbsp;';
	}
	if (file_exists("$mypass")){ 
		print '   
		<html>
		<head>
		
		<title>YouLoader System Admin</title>
		<meta name="robots" content="noindex,nofollow">
		<link href="admin.css" rel="stylesheet" type="text/css">
		
		</head>
		
		<body bgcolor="#eeeeee">
		<div align="center"><center>
		<br><br><br><br><br><br><br>
		
		<form name="form" method="post" action="'.$_SERVER['PHP_SELF'].'"> 
		
		<table border="0" cellpadding="4" cellspacing="1" WIDTH="298" bgcolor="#000000">  
		<tr bgcolor="#EEEEEE">
		<td width="100%" align="center">
		
		<br><span class="S1">'.$mysite_name.' <b>YouLoader System Admin - '.$ver.'</b> </span><br>
		</b><span class="S2">Admin: Login Below With Your
		User/Pass</span>
		<center><table border="0" cellPadding="0" cellSpacing="2" bgcolor="#EEEEEE">
		<TBODY>
				<tr align="center" bgcolor="#EEEEEE">
				  <td height="20" colspan="2">'.$err.'</td>
				  </tr>
				<tr bgcolor="#EEEEEE">
				  <td align="right"><span class="S1">Username:</span></td>
				  <td><span class="S1">
				  <input type="hidden" name="submitted" value="true"> 
				  <input maxLength="18" name="Username" value="" size="20"
				  style="font-family: Verdana, Tahoma; font-size: 9pt "></span></td>
				</tr>
				<tr>
				  <td align="right"><span class="S1">Password:</span></td>
				  <td><span class="S1"><input maxLength="18" name="Password" size="20" value=""
				  type="password" style="font-family: Verdana, Tahoma; font-size: 9pt"></span></td>
				</tr>
				<tr align="center">
				  <td colspan="2"><div align="center"><center><font face="Tahoma" size="2"><br>
		<input type="submit" value="SYSTEM LOGIN" class="button_spc">
					</font></td>
				</tr>
				 
		</TBODY>
			  </table>
			  </center>
		</form>'.$spacer.'
		</td>
		</tr>
		</table>
		</center>
		</body>
		</html>';
		exit;
	}else{
		if ($_POST){
			$strl = (strlen($_POST['Password_ck']) < 6);
			if ($_POST['Username_ck'] == '' or $_POST['Password_ck'] == ''){ 
				$err2 = "<font color=\"#CC0000\" size=\"-2\" face=\"Arial\">YOU DID NOT CHOOSE A USERNAME/PASS</font>";
			}else{
				if ($strl){
					$err2 = "<font color=\"#CC0000\" size=\"-2\" face=\"Arial\">PASSWORD MUST BE A MIN 6 CHAR LONG!</font>";
				}
			}
			print ' <html>
			<head>
			
			<title>YouLoader System Admin</title>
			<meta name="robots" content="noindex,nofollow">
			<link href="admin.css" rel="stylesheet" type="text/css">';
			//Auto refresh our login after gen ... 
			if (!file_exists("$mypass")){ 
				if (!$_POST['Password_ck'] == '' && !$_POST['Username_ck'] == '' && !$strl && @touch("$mypass")){     
					$my_usern  = $_POST['Username_ck'];
					$pass_make = md5($_POST['Password_ck']);
					$pwrite = "<?\n";
					$pwrite .= "\$user = \"$my_usern\";\n";
					$pwrite .= "\$pass = \"$pass_make\";\n";
					$pwrite .= '?>';
					$mypassw = @fopen("$mypass",'w+');
					@fputs($mypassw,$pwrite);
					@fclose($mypassw);
					chmod("$mypass", 0644);
					echo '<META HTTP-EQUIV=REFRESH CONTENT="1; URL=http://'.$_SERVER['SERVER_NAME'].''.$_SERVER['PHP_SELF'].'">';
					exit;
				}
			} 
			print ' </head>
			
			<body bgcolor="#eeeeee">
			<div align="center"><center>
			<br><br><br><br><br><br><br>
			
			<form name="form" method="post" action="'.$_SERVER['PHP_SELF'].'"> 
			
			<table border="0" cellpadding="4" cellspacing="1" WIDTH="298" bgcolor="#000000">  
			<tr bgcolor="#EEEEEE">
			<td width="100%" align="center">
			
			<br><span class="S1">'.$mysite_name.' <b>YouLoader System Admin - '.$ver.'</b></span><br>
			</b><span class="S2">First Time Setup: Please Enter A User/Pass.<BR>This is the information you will use every time you access the system!</span><center><table border="0" cellPadding="0" cellSpacing="2" bgcolor="#EEEEEE">
			<TBODY>
					<tr align="center" bgcolor="#EEEEEE">
					  <td height="20" colspan="2">'.$err2.'</td>
					  </tr>
					<tr bgcolor="#EEEEEE">
					  <td align="right"><span class="S1">Username:</span></td>
					  <td><span class="S1">
					  <input type="hidden" name="submitted" value="true"> 
					  <input maxLength="18" name="Username_ck" value="" size="20"
					  style="font-family: Verdana, Tahoma; font-size: 9pt "></span></td>
					</tr>
					<tr>
					  <td align="right"><span class="S1">Password:</span></td>
					  <td><font face="Tahoma" size="2"><input maxLength="18" name="Password_ck" size="20"
					  type="password" style="font-family: Verdana, Tahoma; font-size: 9pt"></span></td>
					</tr>
					<tr align="center">
					  <td colspan="2"><div align="center"><center><font face="Tahoma" size="2"><br>
			<input type="submit" value="SYSTEM SETUP" class="button_spc">
						</font></td>
					</tr>
					 
			</TBODY>
				  </table>
				  </center>
			</form>'.$spacer.'
			</td>
			</tr>
			</table>
			</center>
			</body>
			</html>';
			if (!file_exists("$mypass")){ 
				if (!$_POST['Password_ck'] == '' && !$_POST['Username_ck'] == '' && !$strl){                      
					die("<span class=\"M1\">Error setup failed, make sure permissions are correct!</span>");
				}
			}
		}
		exit;
	}
}
?>