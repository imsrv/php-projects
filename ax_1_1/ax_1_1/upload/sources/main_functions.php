<?
//+----------------------------------
//	AnnoucementX Main Functions/variables
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/22
//	Updated: 2005/10/12
//	Description: Makes the AnnouncementX
//	work properly and without any bugs
//+----------------------------------

class FUNC {

	function get_skin() {
		global $used_skin, $used_css;
		$link=mysql_connect(HOST,USER,PASS) or die ('Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		$get_skin_query="SELECT Name,Value FROM config WHERE Name='Used_Skin'";
		$run=mysql_query($get_skin_query) or die ('AnnouncementX Error: ' . mysql_error());
		$rows=mysql_fetch_row($run);
		$skin_name=$rows[1];
		$get_skin_query_ok="SELECT Path,Css FROM skins WHERE Name='$rows[1]'";
		$run_2=mysql_query($get_skin_query_ok) or die ('AnnouncementX Error: ' . mysql_error());
		$get_skin=mysql_result($run_2,0,'Path');
		$get_css=mysql_result($run_2,0,'CSS');
		$GLOBALS['used_skin']=$get_skin;
		$GLOBALS['used_css']="./Cache".$get_css;
	mysql_close($link);
	}
	
	function do_bottom() {
		echo "</body>\n</html>";
	}
	
	function do_script($form_name) {
	echo "
	<script language='JavaScript'>
	<!--
	function ValidateForm {
	document.$form_name.submit.disabled = true;
	return true;
	}
	-->
	</script>
	";
	}
	
	function do_header_prof()  {
	
	global $title, $used_css, $used_skin;
	$file=$used_css;
	$handle=fopen($file,'r');
	$contents=fread($handle,filesize($file));
	$where="%IMG_DIR%";
	$replace=$used_skin;
	$new_contents=str_replace($where,$replace,$contents);
	fclose($handle);
echo <<<END
		<html>
		<head>
		<title>$title - Profile</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style type="text/css">
		<!--
END;
		echo $new_contents;
echo <<<END
		-->
		</style>
END;

		echo "<script type='text/javascript' src='./sources/bbcode_new.js'></script>";

echo <<<END
		</head>
		<body>
END;
	
	}
	
	function do_header_login() {
	
	global $title, $used_css, $used_skin;
	$file=$used_css;
	$handle=fopen($file,'r');
	$contents=fread($handle,filesize($file));
	$where="%IMG_DIR%";
	$replace=$used_skin;
	$new_contents=str_replace($where,$replace,$contents);
	fclose($handle);
echo <<<END
		<html>
		<head>
		<title>$title - LogIn</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style type="text/css">
		<!--
END;
		echo $new_contents;
echo <<<END
		-->
		</style>
END;

		echo "<script type='text/javascript' src='./sources/bbcode_new.js'></script>";

echo <<<END
		</head>
		<body>
END;
	}
	
	function do_header_logout() {
	
	global $title, $used_css, $used_skin;
	$file=$used_css;
	$handle=fopen($file,'r');
	$contents=fread($handle,filesize($file));
	$where="%IMG_DIR%";
	$replace=$used_skin;
	$new_contents=str_replace($where,$replace,$contents);
	fclose($handle);
echo <<<END
		<html>
		<head>
		<title>$title - LogOut</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style type="text/css">
		<!--
END;
		echo $new_contents;
echo <<<END
		-->
		</style>
END;

		echo "<script type='text/javascript' src='./sources/bbcode_new.js'></script>";

echo<<<END
		</head>
		<body>
END;
	}
	
	function do_header_reg() {
	
	global $title, $used_css, $used_skin;
	$file=$used_css;
	$handle=fopen($file,'r');
	$contents=fread($handle,filesize($file));
	$where="%IMG_DIR%";
	$replace=$used_skin;
	$new_contents=str_replace($where,$replace,$contents);
	fclose($handle);
echo <<<END
		<html>
		<head>
		<title>$title - Register</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style type="text/css">
		<!--
END;
		echo $new_contents;
echo <<<END
		-->
		</style>
END;

		echo "<script type='text/javascript' src='./sources/bbcode_new.js'></script>";

echo <<<END
		</head>
		<body>
END;
	}
	
	function do_header_index() {
	
	global $title, $used_css, $used_skin;
	$file=$used_css;
	$handle=fopen($file,'r');
	$contents=fread($handle,filesize($file));
	$where="%IMG_DIR%";
	$replace=$used_skin;
	$new_contents=str_replace($where,$replace,$contents);
	fclose($handle);
echo <<<END
		<html>
		<head>
		<title>$title - Home</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style type="text/css">
		<!--
END;
		echo $new_contents;
		
echo <<<END
		-->
		</style>
END;
		echo "<script type='text/javascript' src='./sources/bbcode_new.js'></script>";
		
echo <<<END
		</head>
		<body>
END;
	}
	
	function do_header_pm () {
	
	global $title, $used_css, $used_skin, $username;
	$file=$used_css;
	$handle=fopen($file,'r');
	$contents=fread($handle,filesize($file));
	$where="%IMG_DIR%";
	$replace=$used_skin;
	$new_contents=str_replace($where,$replace,$contents);
	fclose($handle);
echo <<<END
		<html>
		<head>
		<title>$title - $username - Personal Messages</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style type="text/css">
		<!--
END;
		echo $new_contents;
echo <<<END
		-->
		</style>
END;

		echo "<script type='text/javascript' src='./sources/bbcode_new.js'></script>";

echo <<<END
		</head>
		<body>
END;

	}
	
	function do_header_show() {
	
	global $title, $used_css, $used_skin;
	$file=$used_css;
	$handle=fopen($file,'r');
	$contents=fread($handle,filesize($file));
	$where="%IMG_DIR%";
	$replace=$used_skin;
	$new_contents=str_replace($where,$replace,$contents);
	fclose($handle);
echo <<<END
		<html>
		<head>
		<title>$title - Show Category</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style type="text/css">
		<!--
END;
		echo $new_contents;
echo <<<END
		-->
		</style>
END;
		echo "<script type='text/javascript' src='./sources/bbcode_new.js'></script>
		</head>
		<body>
";
		
	}
	
	function do_header_search() {
	
	global $title, $used_css, $used_skin;
	$file=$used_css;
	$handle=fopen($file,'r');
	$contents=fread($handle,filesize($file));
	$where="%IMG_DIR%";
	$replace=$used_skin;
	$new_contents=str_replace($where,$replace,$contents);
	fclose($handle);
echo <<<END
		<html>
		<head>
		<title>$title - Search</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style type="text/css">
		<!--
END;
		echo $new_contents;
echo <<<END
		-->
		</style>
END;

		echo "<script type='text/javascript' src='./sources/bbcode_new.js'></script>";

echo <<<END
		</head>
		<body>
END;
	
	}
	
	function do_copyright() {
	
	global $used_skin;
echo <<<END
	<div align=center id='copyright'>
	&copy; 2004-2005 AnnouncementX. All rights reserved.<br />
	Powered by <a href='http://www.php.net' title='PHP' target='_blank'>PHP</a> and <a href='http://www.mysql.com' title='MySQL' target='_blank'>MySQL</a>.<br />
	Currently used skin: $used_skin.<br />
	</div>
END;
	$this->do_info();
	}
	
	function do_info() { 
	$ips=$_SERVER['REMOTE_ADDR'];
	$browser=$_SERVER['HTTP_USER_AGENT'];
	
	if (strstr($browser,"MSIE")) {
		$b_output="Internet Explorer";
	} 
	else if(strstr($browser,"Maxthon")) {
		$b_output="Maxthon Browser";
	}
	else if(strstr($browser,"Opera")) {
		$b_output="Opera Browser";
	}
	else if (strstr($browser,"Firefox")) {
		$b_output="Firefox Browser";
	} 
	else if (strstr($browser,"Mozilla")) {
		$b_output="Mozilla Browser";
	}
	else {
		$b_output="UnknownBrowser";
	}
	
	$time=microtime();
	$time=number_format($time,5);
	$dates=date("dS of F Y, g:i:s A");
echo <<<END
	<div align='center' id='info'>
	<b>[ Load Time: </b>$time <b>] | [ IP Address: </b>$ips<b> ] | [ Current Date: </b>$dates<b> ] | [ Your Browser: </b>$b_output<b> ] </b>
	</div>
END;
	}
	
	function do_redirect($url) {
echo <<<END
	<table width='100%' height='90%' border=0>
	<tr>
	<td valign=middle>
		<table class=maintable align=center cellpadding='3'>
			<tr>
				<td align=center class=HEADER>
				::Operation Successful::
				</td>
			</tr>
			<tr>
				<td align=center class=MAIN>
				The operation has been done successfully!<br /><br />
				<a href='$url' title='Continue'>Click here to continue</a>
				<br />
				</td>
			</tr>
		</table>
	</td>
	</tr>
	</table>
END;
	}
	
	function do_login_check() {
		if ($username != '' && $password != '' && $_SESSION['username'] = '') {
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		$check_query="SELECT Name,Password FROM members WHERE Name=$username";
		$run=mysql_query($check_query) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_close($link);
		$user=mysql_result($run,0,'Name');
		$pass=mysql_result($run,0,'Password');
			if ($username = $user && $password = $pass) {
				header("Location:index.php?do=login&step=auto_login&username=$user&password=$pass");
				exit;
				if (!headers_sent) {
					$url='Location:index.php?do=login&step=auto_login&username=$user&password=$pass';
					$this->do_redirect($url);
					$this->do_copyright();
				}
			}
		}
	}
	
	function do_private_messages($username,$password) {
		
		if ($username == '' || $password== '') {
		
			echo "Unable to view private messages window, probably, you arere not logged in.";
			
		}
			
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		// Do we have any pms at all O_o
		
				
			$check="SELECT * FROM `pms` WHERE `To`='$username' AND `Read`='No'";
			$check_run=mysql_query($check) or die ('AnnouncementX Error: ' . mysql_error());
			$pms_num=mysql_num_rows($check_run);
			
			if ($pms_num == 0) {
			
			} else {
			
				$this->do_private_messages_show();
				
			}
				
		mysql_close($link);
		
	}
	
	function do_private_messages_show() {
	
	global $title, $errors, $username, $pms_num;
	
echo <<<END
			<table width='750' align='center' border='1' border-color='#ffffff' style='border-collapse: collapse' cellpadding='3'>
				<tr>
					<td align='center' class='HEADER'>
					:: $username - you have <b>$pms_num</b> new private message(s) ::
					</td>
				</tr>
				<tr>
					<td align=center class='MAIN'>
					$username, you have $pms_num unread messages. <br />
					<div align='right'><a href='index.php?do=pm&step=read'>Read Messages</a> :: <a href='index.php?do=pm&step=mark_as_read'>Mark all as read</a> :: <a href='index.php?do=pm&step=delete_all' title='Delete all messages'>Delete all</a></div>
					</td>
				</tr>
			</table>
			<br /><br />
END;

	}
	
	function do_menu($username,$password) {
	
	$connect=mysql_connect(HOST,USER,PASS) or die ('Cannot connect');
	mysql_select_db(DATA,$connect);
	
	if ($username!='') {
	
	$check_user=mysql_query("SELECT * FROM members WHERE Name='$username'",$connect) or die ('AnnouncementX Error: ' . mysql_error());
	$check_user_result=mysql_fetch_row($check_user);
	$check_admin="SELECT Pr_admin FROM groups WHERE Name='$check_user_result[6]'";
	$check_admin_run=mysql_query($check_admin,$connect) or die ('AnnouncementX Error: ' . mysql_error());
	$check_result=mysql_fetch_row($check_admin_run);
	$check_admin_result=$check_result[0];
	$forumsqr=mysql_query("SELECT `id`,`Name` FROM `categories`");
	
	}

	echo "<td width=30% align=center class=MENU>";
	
		switch ($username) {
		
		case "":
		
		echo "<b>Quick Login:</b><br />";

		$this->do_quick_login();
		
		
		
		$members=mysql_query("SELECT * FROM members",$connect);
		$members_num=mysql_num_rows($members);
		
		switch($members_num) {
		
		case "1":
		
			echo "<br />There is: <b>1</b> member";
		
		break;
		
		case "0":
		
			echo "<br />There are no members<br /><br />";
		
		break;
		
		default:
		
			echo "<br />There are: <b>$members_num</b> members<br /><br />";
		
		break;
		
		}
		
		/*echo "<hr width='90%'><br /><br />";
		
		$switch_qr="SELECT id,Name FROM categories";
		$switch=mysql_query($switch_qr,$connect) or die ('AnnouncementX Error: ' . mysql_error());

		$num_of_categories=mysql_num_rows($switch);
		
			if ($num_of_categories=0) {
			
				echo "There are no categories yet";
			
			} else {
			
				$i=0;
			
				echo "Overall categories: <b>$num_of_categories</b><br /><br /><form name='category_switch' action='index.php?do=show' method='post'>
				<select name='switch' size='1'><option name='category' value=''>Choose a category</option>";
				
					while ($i<$num_of_categories) {
					
						$id=mysql_result($switch,$i,'id');
						$name=mysql_result($switch,$i,'Name');
						
						echo "<option name=category value='$id'>$name</option>";
						
						$i++;
					
					}
				
			echo "</select><br />
			<input type=submit name=submit value='Switch to category' class=submit>
			</form>";
			
			} */
		
		echo "<br /><br /><a href='javascript:window.close()' title='Close Window'>Close Window</a></td>";

		break;

		default:

echo <<<END
		You are logged in as <b>$username</b><br /><br />

		 <a href='index.php?do=logout' title='Log Out, $username'>Log Out</a><br />
		 <a href='index.php?do=profile&step=view&who=$username' title='View/Edit Profile, $username'>Profile</a><br />
		 <a href='index.php?do=pm&step=read' title='Personal Messages'>Personal Messages</a><br />
		 <a href='index.php?do=profile&step=view&who=' title='View all members'>Members</a><br />
		 <a href='index.php?do=search&step=1' title='Search'>Search</a><br />
END;
			if ($check_admin_result == 'yes') {
				
				echo "<a href='index.php?do=admin' title='Go to Admin CP'>Admin CP</a>";
				
			}
		
		echo "<br /><br />
		<hr width='90%'><br /><br />";
		
		$members=mysql_query("SELECT * FROM members",$connect);
		$members_num=mysql_num_rows($members);
		
		switch($members_num) {
		
		case "1":
		
			echo "There is: <b>1</b> member";
		
		break;
		
		case "0":
		
			echo "<br />There are no members<br /><br />";
		
		break;
		
		default:
		
			echo "<br />There are: <b>$members_num</b> members<br /><br />";
		
		break;
		
		}
		
			// FORUM JUMP MOD START
			// CREATED BY cat (Ivan Cat)
			// DATE: 10/07/2005
			
			echo "<form name=forums_jump action='index.php?do=show&' method='post'>
			<select class=submit name=forums size=1 accesskey='F'>";
			
			while ($forum=mysql_fetch_row($forumsqr)) {
			
				echo "<option value='$forum[0]'>$forum[1]</option>";
			
			}		
			
			echo "</select>";
			
			$browser=$_SERVER['HTTP_USER_AGENT'];
			
			if (strstr($browser,'MSIE')) {
			
				echo "<input type=submit name=submit value='Go' class=submit>";
			
			} else {
			
				echo "<input type=submit name=submit value='Go' class=submit onClick=\"this.value='Jumping...';this.disabled=true\">";
			
			}
			echo "</form>";
		
			// FORUM JUMP MOD END
			// (C) 2005

		/*echo "<b>Categories:</b><br /><a href='index.php?do=' title='Home'>$title Home</a><br /><br />";
		
		$db=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error(menu/connect): ' . mysql_error());
		mysql_select_db(DATA,$db);
		
		$switch_qr="SELECT * FROM categories";
		$switch=mysql_query($switch_qr,$db) or die ('AnnouncementX Error: ' . mysql_error());

		$num=mysql_num_rows($switch);
		
			if ($num=0) {
			
				echo "There are no categories yet";
			
			} else {
			
				$i=0;
			
				echo "<form name='category_switch' action='index.php?do=show&category=switch' method='post'>
				<select name='switch' size='1'>";
				
					while ($i<$num) {
					
						$id=mysql_result($switch,$i,'id');
						$name=mysql_result($switch,$i,'Name');
						$description=mysql_result($switch,$i,'Description');
						
						echo "<option name='category' value='$id'>$name</option>";
						
						$i++;
					
					}
				
			echo "</select><br />
			<input type=submit name=submit value='Switch to category class=submit>
			</form>";
			
			}
		
		mysql_close($db); */
		
		echo "<br /><br /><a href='javascript:window.close()' title='Close Window'>Close Window</a></td>";
		
		break;
		
		}
	}
	
	function do_quick_login() {
	
	echo "
	<script language='JavaScript'>
	<!--
	
		function Blah() {
		
			if (document.show.remember.checked) {
			
				document.show.remember.checked = false;
				return false;
			
			} else {
			
				document.show.remember.checked = true;
				return true;
			
			}
			
		}
		
		function Show_encrypt() {
		
			if (document.show.md5.checked) {
			
				document.show.md5.checked = false;
				return false;
			
			} else {
			
				document.show.md5.checked = true;
				return true;
			
			}
			
		}
	
	-->
	</script>
	";
	
echo <<<END
		<form name='show' action='index.php?do=login&step=2' method='post'>
		<input type=text name='user' value='Username' onfocus="this.value=''" size='20' class=field><br /><br />
		<input type=password name='pass' value='catrules' onfocus="this.value=''" size='20' class=field><br />
		<input type=checkbox name='remember' value='1'><label for='remember'><a href='#' title='Remember Me' onClick='Blah()'>Remember Me</a></label><br />
		<input type=checkbox name='md5' value='1'><label for'md5'><a href='#' title='Password Encryption' onClick='Show_encrypt()'>Password Encryption</a></label><br /><br />
		<input type=submit name=submit value='LogIn' class=submit>
		</form>
		<br /><a href='index.php?do=register&step=1' title='Register'>Register</a>
END;

	}
	
	function guest_cant_post() {
		
echo <<<END
		<table width='750' align='center' border='1' border-color='#ffffff' style='border-collapse: collapse' cellpadding='3'>
			<tr>
				<td align='center' class='HEADER'>
				:: You cannot post as a guest ::
				</td>
			</tr>
			<tr>
				<td align=center class='MAIN'>
				Sorry, but guests are not allowed to post here.<br /><br />
				<a href='index.php?do=register&step=1'>Register</a><br /><br />
				<a href='index.php?do=login&step=1'>Log In</a><br /><br />
				</td>
			</tr>
		</table>
END;
	}
	
	function do_badwords_fix($message) {
	
		$phrase=$message;
		
		if (isset($counter)) {
		
			for ($i=0;$i<$counter;$i++) {
			
				$bad=$badword[$i];
				$message=str_replace($bad,"+-censored-+",$message);
			
			}
		
		}
				
	}
	
	function debug_mode() {
	
		global $username, $password;
	
		// IMPORTANT! I do not advise to use this function when you do not have enough experience to work with php and mysql
		
		if (isset($username,$password) && $username!='' && $password!='') {
		
			echo "<b>Username/Password DeBug:</b><br />Username: $username<br />Password: $password<br /><br />";
			
			$link_debug=mysql_pconnect(HOST,USER,PASS) or die ('AnnouncementX Error(DEBUG_MODE_CONNECT): ' . mysql_error());
			mysql_select_db(DATA,$link_debug);
			
			$user_permissions_check=mysql_query("SELECT Group FROM members WHERE Name='$username'",$link_debug) or die ('AnnouncementX Error(DEBUG_MODE_SELECT_USER): ' . mysql_error());
			$user_permissions_info=mysql_fetch_row($user_permissions_check);
			
			$user_group_after_check=$user_permissions_inf[0];
			
			$user_permissions_check_group=mysql_query("SELECT Name,Pr_admin FROM groups WHERE Name='$user_group_after_check'",$link_debug) or die ('AnnouncementX Error(DEBUG_MODE_GROUP_SELECT): ' . mysql_error());
			
			$user_permissions_check_group_info=mysql_fetch_row($user_permissions_check_group);
			
			$user_permissions_group_name=$user_permissions_check_group_info[0];
			
			echo "<b>You are in the following group:</b> $user_permissions_group_name<br /><br />";
			
			$user_permissions_group_permissions=$user_permissions_check_group_info[1];
			
			if ($user_permissions_group_permissions == 'yes') { 
			
				echo "<b>Host Name:</b> ".HOST."<br /><b>SQL Username:</b> ".USER."<br /><b>SQL Password:</b> ".PASS."<br /><b>SQL Database:</b> ".DATA."<br /><br />End of DEBUG Module";
				
			} else {
			
				echo "You do not have Admin Permissions to view additional information";
			
			}
		
		} else {
		
			echo "Probably, you are not logged in or there are some problems with our cookies/sessions and log in";
		
		}
	
	}
	
	function give_a_cookie($uc,$up) {
	
		$depass=base64_decode($up);
		setcookie('username',$uc,time()+604800);
		setcookie('password',$depass,time()+604800);
		$url='index.php?do=&'.strip_tags(sid);
		$this->do_redirect($url);
	
	}
	
	function BBCode() {
	
	$browser=$HTTP_SERVER_VARS['HTTP_USER_AGENT'];
	
	if (strstr($browser,'MSIE')) {
	
		$reference="<a href='javascript:BBReference()' title='BBCode Help<br />(c) cat 2005'>BB Code Reference</a>";
	
	} else {
	
		$reference="<a href='#' title='BBCode Help<br />(c) cat 2005' onClick=\"window.open('./index.php?do=bbcode_help&','BBCode Reference','width=450,height=400,resizable=yes,scrollbars=yes,status=yes')\">BB Code Reference</a>";

	}	
			
echo <<<END

				<form name="BBCodeStuff" action="#">
				<input type="button" name="bold" value="[B]" accesskey="B" onClick="SimpleTag('[B]')" onMouseOver="RunBBCodeMessage('Add bold text to your message, Alt+B')" onMouseOut="RunBBCodeMessageExit()">
				<input type="button" name="italic" value="[I]" accesskey="I" onClick="SimpleTag('[I]')" onMouseOver="RunBBCodeMessage('Add italic text to your message, Alt+I')" onMouseOut="RunBBCodeMessageExit()">
				<input type="button" name="underlined" value="[U]" accesskey="U" onClick="SimpleTag('[U]')" onMouseOver="RunBBCodeMessage('Add underlined text to your message, Alt+U')" onMouseOut="RunBBCodeMessageExit()">
				<input type="button" name="image" value="[IMG]" accesskey="M" onClick="PutImage()" onMouseOver="RunBBCodeMessage('Add an image to your message, Alt+M')" onMouseOut="RunBBCodeMessageExit()">
				<input type="button" name="url" value="[URL]" accesskey="R" onClick="PutURL()" onMouseOver="RunBBCodeMessage('Add an url to your message, Alt+R')" onMouseOut="RunBBCodeMessageExit()">
				<input type="button" name="email" value="@" accesskey="E" onClick="PutEmail()" onMouseOver="RunBBCodeMessage('Add an e-mail to your message, Alt+E')" onMouseOut="RunBBCodeMessageExit()">
				<input type="button" name="quote" value="[QUOTE]" accesskey="Q" onClick="PutQuote()" onMouseOver="RunBBCodeMessage('Add a quote to your message, Alt+Q')" onMouseOut="RunBBCodeMessageExit()">
				<input type="button" name="code" value="[CODE]" accesskey="C" onClick="SimpleTag('[CODE]')" onMouseOver="RunBBCodeMessage('Add code-like text to your message, Alt+C')" onMouseOut="RunBBCodeMessageExit()">
				<input type="text" name="BBCodeHelper" size="40" value="" readonly>&nbsp;&nbsp;
				$reference
				</form>

END;
	
	}
	
	function bbcode_reference() {
	
echo <<<END
	
		<center><h4>AX BB Code Reference</h4></center><br />

		<div align=left>

		Welcome to AX BB Code Reference! It will help you to know how to use AX BB Code correctly.<br />
		First fo all, table of contents:<br /><br />
		
		<b>Table of Contents:</b>
		<br /><br />
		&middot; <a href='#1' title='List of items'>List of items</a><br />
		&middot; <a href='#2' title='Using of BB Code'>Using of BB Code</a><br />
		&middot; <a href='#3' title='Unsupported commands (comparing to other BBs)'>Unsupported commands (comparing to other BBs)</a><br /><br />
		
		</div>
		
		<center><a name='#1'></a><h4>List of itmes</h4></center><br />
		
		<div align=left>
		
		Here is the list of items that are used in AX BB Code with a short explanations for each:<br /><br />
		
		<b>Button - Description</b><br /><br />
		
		<b>[B]</b> - Insert Bold text to your message, you can use <em>Alt+B</em> instead of pressing the button<br />
		<b>[I]</b> - Insert Italic text to your message, you can use <em>Alt+I</em> instead of pressing the button<br />
		<b>[U]</b> - Insert Underlined text to your message, you can use <em>Alt+U</em> isntead of pressing the button<br />
		<br />
		<b>[URL]</b> - Insert a hyperlink to your message; you have to type the url for the hyperlink, also you will be prompted to type
		some text that will be shown for this link, but if you do not, then the itself will be shown; you can use <em>Alt+U</em> instead of 
		pressing the button<br />
		<b>[IMG]</b> - Insert an image to your message; you will have to type the link to the image you would like to insert; you can use 
		<em>Alt+I</em> instead of pressing the button<br />
		<b>@</b> - Insert an e-mail to your message; you will have to type the e-mail address you would like to insert, als you will be prompted to 
		type some text that will be shown for this e-mail link, if you do not then e-mail address itself will be shown; you can use <em>Alt+E</em> 
		insead of pressing the button<br /><br />
		
		<b>[QUOTE]</b> - Insert a quote to your message; you will be prompted to enter the quoted text; you can use <em>Alt + Q</em> instead of pressing
		the button
		
		</div>
		
		<br /><br />
		
		<center><a name='#2'></a><h4>Using of BB Code</h4></center><br />
		
		<div align=left>
		
		In this section you will know how to use AX BB Code correctly to avoid mistakes. First of all - the list of commands:<br /><br />
		
		[B] - Bold text<br />
		[I] - Italic text<br />
		[U] - Underlined text<br /><br />
		
		[URL/][/URL] - Hyperlink<br />
		[IMG][/IMG] - Image<br />
		[EMAIL/][/EMAIL] - E-mail link<br /><br />
		
		[QUOTE][/QUOTE] - Quoted text<br />
		[CODE][/CODE] - Code-like text<br /><br />
		
		* All commands work ok even if they are lowercased<br /><br />
		
		<b>Use of Bold, Italic, Underlined text:</b><br /><br />
		
		Sometimes it is very important to mark some parts of your text as bold, italic or underline them. In 
		that case you can use the following:<br />
		
		[B]someText[/B]<br />
		[I]someText[/I]<br />
		[U]someText[/U]<br />
		
		<b>Important! </b>After you have clicked on the button that indicates [B],[I] or [U] changes its value to [*B],[*I] or [*U]; it means that you
		have opened a tag and have to close it or there can be some problems with viewing a message.<br /><br />
		
		<b>Use of Hyperlinks, E-mail links, Images:</b><br /><br />
		
		If you want to add a hyperlink to your message, you can click on the [URL] button. After that you will be prompted to enter the url (which
		is required) and some text for your hyperlink (which is optional). In case you have not entered any text for your link the link itself will be
		shown. Use of the [URL] tag:<br />
		[URL=www.me.com/]This is my site[/URL] - Link with text<br />
		[URL=www.me.com/]www.me.com[/URL] - Link without text (in that case link must be duplicated)<br /><br />
		
		If you would like to insert an image to your message, then just click on the [IMG] button and enter the url to your 
		image. Use of [IMG] tag:<br />
		
		[IMG]www.me.com/image.jpg[/IMG] -It will add an image to your message<br /><br />
		
		Also, sometimes you would like to put an e-mail, then just click at the '@' button and enter e-mail and some text for your link, 
		if text is not entered, then the link must be duplicated:
		
		[EMAIL=me@me.com/]My E-mail[/EMAIL] - E-mail link with text<br />
		[EMAIL=me@me.com/]me@me.com[/EMAIL] - E-mail link without text<br /><br />
		
		<b>Use of Quotes, Code-like text:</b><br /><br />
		
		And to insert a quote just click the [QUOTE] button and type the text you would like to mark as a quotation. Use of [QUOTE] tag:<br />
		[QUOTE]someText[/QUOTE]<br /><br />
		
		To insert a code-like text to your message you can use the [CODE] button. Press it once, tag [CODE] has been added to your message and the 
		button value has been changed to [*CODE]. After that - type your code, then - press the button once again: [/CODE] tag has been added, button 
		value has been changed back to [CODE]. Overall, the tag looks like that:<br />
		[CODE]SomeText[/CODE]
		
		</div>
		
		<br /><br />
		
		<center><a name='#3'></a><h4>Unsupported commands</h4></center><br />
		
		<div align=left>
		
		Well...there are some commands that are not supported by AX BB Code, so please, do not try to type them in your messages as it will take
		no effect. So, the list of unsupported commands is:<br /><br />
		
		[COLOR] - Different font color<br />
		[SIZE] - Different font size<br />
		[FONT] - Different font type<br /><br />
		
		*<b>Note: </b>overall, all BB Code commands that are not in the supported commands list are unsupported, so if the list above misses 
		some it does not mean they are supported, maybe in future versions some commands will be added.<br /><br />
		
		</div>
	
		<center>
		<input type=button name='close' value='Close' onClick='javascript:self.close()' onMouseOver="window.status='Close Reference'"><br /><br />
		&copy; 2005 AnnouncementX. All rights reserved
		</center>

END;
	
	}
		
	//-----------
	// Additional Functions
	//-----------
	
	function do_title() {
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		$get_title="SELECT Name,Value FROM config WHERE Name='Title'";
		$run=mysql_query($get_title) or die ('AnnouncementX Error: ' . mysql_error());
		$row=mysql_fetch_row($run);
		$GLOBALS['title']=$row[1];
		mysql_close($link);
	}
	
	function do_define() {
		define ('USER',$username_file);
		define ('PASS',$password_file);
		define ('DATA',$database_file);
		define ('HOST',$host_file);
	}
	
	function do_session() {
		session_start();
	}
	
	function do_date() {
		$date=date("dS of F, Y h:i:s A");
		echo $date;
	}
	
	function find_username_java() {
		echo "<script language='javascript'>
		<!--
		function FindUsername() 
		{
			var url='index.php?do=pm&step=find';
			window.open(url,'Find A Username','width=400,height=height='250',resizable=yes,scrollbars=yes,statusbar=no,menubar=no');
		}
		-->
		</script>";
	}

}
?>