<?
//+----------------------------------
//	AnnoucementX LogIn Script
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/22
//	Updated: 2005/10/12
//+----------------------------------

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);


if (!isset($index)) {

	header("Location:index.php?do=");
	
}

class LOGIN {

	function go_switch($step) {

		global $functions;
	
		switch ($step) {
		
		case "1":
		
			$functions->do_header_login();
	
			$functions->do_script('login');
		
			$this->do_login();
			
		break;
			
		case "2":
		
			$this->do_login_again();
			
		break;
			
		case "auto_login":
		
			$this->do_autologin();
			
		break;
			
		default:
		
			$functions->do_header_login();
	
			$functions->do_script('login');
		
			if (!headers_sent) {
			
				header ("Location:./index.php?do=login&step=1");
				exit;
			
			} else {
			
				$url="./index.php?do=login&step=1";
				$functions->do_redirect($url);
			
			}
			
		break;
	
		}
		
	}
	
//+----------------------------------

	function do_login() {
	
	global $title;
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$cookie_qr="SELECT * FROM config WHERE Name='Cookies'";
	$get_cookies=mysql_query($cookie_qr) or die ('AnnouncementX Error: ' . mysql_error());
	$cookies=mysql_result($get_cookies,0,'Value');
	
	echo "
	<script language='JavaScript'>
	<!--
	
		function Blah() {
		
			if (document.login.remember.checked) {
			
				document.login.remember.checked = false;
				return false;
			
			} else {
			
				document.login.remember.checked = true;
				return true;
			
			}
			
		}
		
		function Encryption() {
		
			if (document.login.md5.checked) {
			
				document.login.md5.checked = false;
				return false;
			
			} else {
			
				document.login.md5.checked = true;
				return true;
			
			}
		
		}
	
	-->
	</script>
	";
	
echo <<<END
<table class=maintable align=center cellpadding='3'>
	<tr>
		<td align='center' class='HEADER'>
		:: $title -Login ::
		</td>
	</tr>
	<tr>
		<td align=left class='MAIN'>
		<div id='navstrip'>
		<a href='index.php?do' title='Home'>$title</a> > <a href=window.location() title='LogIn'>LogIn</a>
		</div>
		
		<h4>To LogIn, please, fill in the fields below</h4>
			<table align=center width=70% border=0 cellpadding=3>
			<form name='login' action='index.php?do=login&step=2' method='post' onsubmit='ValidateForm()'>
			<tr>
				<td align=left>
				<input type=text name='user' value='' size='30' class='field'>
				</td>
				<td align=left class='FORM'>
				Username
				</td>
				<td align=center class=MAIN>
END;
	switch ($cookies) {
	
	case "On":
	
		echo "<input type='checkbox' name='remember' value='true'><label for='remember'><a href='#' title='Remember me' onClick='Blah()'>Remember Me</a></label>";
	
	break;
	
	case "Off":
	
		echo "<input type='checkbox' name='remember' value='1' disabled><label for='remember'>Remember Me</label>";
	
	break;

	}
	
echo <<<END
				</td>
			</tr>
			<tr>
				<td align=left>
				<input type=password name='pass' value='' size='30' class='field'>
				</td>
				<td colspan=1 align=left class='FORM'>
				Password
				</td>
				<td align=center class='FORM'>
				<input type=checkbox name='md5' value='1'> <a href='#' title='Password Encryption' onClick='Encryption()'>Password Encryption</a><br />(more secure login)
				</td>
			</tr>
			<tr>
				<td align=center class=FORM colspan=3>
				<input type=submit name=submit value='Log In' class=submit>
				</td>
			</tr>
			</form>
			</table>
		</td>
	</tr>
</table>
END;

		mysql_close($link);
	
	}
	
	function do_login_again() {
	
		global $errors, $functions;
		
		$user=$_POST['user'];
		$pass=$_POST['pass'];
		$remember=$_POST['remember'];
		$md5=$_POST['md5'];
		
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$check_query="SELECT * FROM members WHERE Name='$user' AND Password='$pass'";
		$run=mysql_query($check_query) or die ('AnnouncementX Error(query/user_check): ' . mysql_error());
		
		$num=mysql_num_rows($run);
		
		if ($num < 1) {
		
			$functions->do_header_login();
			$errors->error_no_username_or_password();
			exit;
			
		} elseif ($num > 1) {
		
			echo "Undefined LogIn Error! Please, contact to the administrator if you get that error again. <a href='index.php?'".strip_tags(sid)." title='Continue'>Continue</a>";
			exit;
					
		} else {
		
			$usernm=mysql_result($run,0,'Name');
			$passwd=mysql_result($run,0,'Password');
			
			$ip_qr="SELECT * FROM config WHERE Name='Ip_logs'";
			$get_ip=$_SERVER['REMOTE_ADDR'];
			$log_ip=mysql_query($ip_qr) or die ('AnnouncementX Error(query/ip_info): ' . mysql_error());
			$log=mysql_result($log_ip,0,'Value');
			
			$group[0]=mysql_result($run,0,'Group');
			
			
			$group_qr=mysql_query("SELECT Pr_valid, Pr_banned FROM groups WHERE Name='$group'") or die ('AnnouncementX Error(query/permissions): ' . mysql_error());
			$permissions = mysql_fetch_row($group_qr);
			/*$group[1]=mysql_result($group_qr,0,'Pr_valid');
			$group[2]=mysql_result($group_qr,0,'Pr_banned');
			*/
			
			if ($permissions[0] == 'yes') {
						
				echo "<center><a href=index.php?do=register&step=first_validate>Click here to continue</a><br />Your current group is <b>$group[0]</b></center>";
				exit;
				
			
			} elseif ($permissions[1] == "yes") {
			
				echo "<center>Sorry, but you have been banned.<br /><a href='index.php'>Click here to return to the index</a>";
				exit;
			
			} else {
			
				if (isset($md5)) {
				
					$pass=md5($pass);
					$passwd=md5($passwd);
				
				}
			
				switch ($num) {
				
				case "1":
				
					if ($usernm == $user && $passwd == $pass) {
					
						switch ($remember) {
						
						case "1":
						
							$fld=$_SERVER['DOCUMENT_ROOT'];
							
							setcookie('a_username',$user,time()+60*60*24*100);
							setcookie('a_password',$pass,time()+60*60*24*100);
							
							$functions->do_header_login();
							
							$url="index.php?do=&".strip_tags(sid);
							$functions->do_redirect($url);
							if ($log = 'On') {
							
								$date=date('dS of F Y');
								$message="$date
								$get_ip logged as $user
								++++++++++++++++++++++";
								$to="./sources/ip_logs.txt";
								
								if (!is_writable($to)) {
								
									@ chmod($to,0777);
									@ $fp=fopen($to,'a');
									@ fwrite($fp,$message);
									@ fclose($fp);
								
								} else {
								
									@ $fp=fopen($to,'a');
									@ fwrite($fp,$message);
									@ fclose($fp);
								
								}
							
							}
							
						break;
						
						default:
						
							$_SESSION['username'] = $user;
							$_SESSION['password'] = $pass;
							
							$functions->do_header_login();
								
							$url='index.php?do=&'.strip_tags(sid);
							$functions->do_redirect($url);
							if ($log = 'On') {
							
								$date=date('dS of F Y');
								$message="$date
								$get_ip logged as $user
								++++++++++++++++++++++";
								$to="./sources/ip_logs.txt";
								
								if (!is_writable($to)) {
								
									@ chmod($to,0777);
									@ $fp=fopen($to,'a');
									@ fwrite($fp,$message);
									@ fclose($fp);
								
								} else {
								
									@ $fp=fopen($to,'a');
									@ fwrite($fp,$message);
									@ fclose($fp);
								
								}
							
							}

						break;
						
						}
						
					}
								
				break;
				
				default:
				
					$functions->do_header_login();
					$errors->error_invalid_username_password();
					exit;
					
				break;
				
				}
			
			}
		
		}
		
	}
	
	function do_autologin() {
	
	global $functions;
	
	$_SESSION['username'] = $_COOKIE['username'];
	$_SESSION['password'] = $_COOKIE['password'];
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$banned_qr=mysql_query("SELECT Group FROM members WHERE Name='$username'") or die ('AnnouncementX Error: ' . mysql_error());
	$banned=mysql_result($banned_qr,0,'Group');
	
	$group_qr=mysql_query("SELECT Pr_valid, Pr_banned FROM groups WHERE Name='$banned'") or die ('AnnouncementX Error: ' . mysql_error());
	$group_1=mysql_result($group_qr,0,'Pr_valid');
	$group_2=mysql_result($group_qr,0,'Pr_banned');
	
	$ip_qr="SELECT * FROM config WHERE Name=Ip_logs";
	$get_ip=$_SERVER['REMOTE_ADDR'];
	$log_ip=mysql_query($ip_qr) or die ('AnnouncementX Error: ' . mysql_error());
	$log=mysql_result($log_ip);
	
		if ($log = 'On') {
		
			$date=date('dS of F Y');
			$message='$date\n\$get logged as $user\n\n';
			$to="./sources/ip_logs.txt";
			$fp=fopen($to,'a');
			fwrite($fp,$message);
			fclose($fp);
		
		} 
		
		switch ($group_1) {
		
		case "Yes":
		
			if (!header("Location:index.php?do=register&step=first_validate")) {
			
				echo "<a href=index.php?do=register&step=first_validate>Click here to continue</a>";
				exit;
		
			}
		
		break;
		
		case "No":

		break;
		
		}
		
		switch ($group_2) {
		
		case "Yes":
		
			echo "<center>Sorry, but you have been banned.<br /><a href='index.php'>Click here to return to index</a>";
			exit;
			
		break;
		
		case "No":
		
		break;
		
		}
		
		if (!headers_sent) {
		
			header("Location:index.php?do=");
			exit;
			
		} else {
		
			$url='index.php?do=';
			$functions->do_redirect($url);
			
		}
		
	mysql_close($link);
	
	}
	
}
?>