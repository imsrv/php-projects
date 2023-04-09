<?

// AnnouncementX v.1.1 Updater
// Created: 09/22/2005
// Author: Ivan Cat
// Description: Updates the database structure
// to make everything work ok

error_reporting (E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

$class = new Update;


require ("./conf_global.php");

define ('USER',$username_file);
define ('PASS',$password_file);
define ('DATA',$database_file);
define ('HOST',$host_file);

switch ($p) {

	case "welcome":
		$class->show_header();
		$class->welcome();
	break;
	
	case "start":
		$class->show_header();
		$class->start();
	break;
	
	case "confirm":
		$class->show_header();
		$class->confirm();
	break;
	
	case "update":
		$class->show_header();
		$class->show_update_new();
	break;

	default:
	
		header("Location:./update.php?p=welcome");
		exit;
		
	break;

}

$class->show_bottom();

class Update {

	function welcome() {
	
	$license=file_get_contents("./install/gpl.txt");
	
	echo "<script language='JavaScript'>
	<!--
	
		function Check() {
		
			if (document.license.agree.checked) {
			
				document.license.agree.checked = false;
				return false;
			
			} else {
			
				document.license.agree.checked = true;
				document.license.submit.disabled = false;
				return false;
			
			}
			
		}
	
	-->
	</script>";
	
echo <<<END

	<table align=center class=maintable>
		<tr>
			<td align=center class=HEADER>
			AnnouncementX Update:
			</td>
		</tr>
		<tr>
			<td align=center class=main>
			Welcome! This is AnnouncementX Update utility that will help you to update your AX from v.1.0 to v.1.1<br /><br />
			Please, first of all accept the new license agreement:<br /><br />
			<form name='license' action='./update.php?p=start' method='post'>
			<textarea name='license' rows=14 cols=60 class=textarea>$license</textarea><br /><br />
			<input type=checkbox name='agree' value=1> <a href='#' title='I agree' onClick='Check()'>I agree</a><br />
			<input type=submit name=submit value='Continue' class=submit disabled>
			</form>
			</td>
		</tr>
	</table>

END;
	
	}
	
	function start() {
	
	$agree=$_POST['agree'];
	
		if (isset($agree)) {
		
echo <<<END

		<table align=center class=maintable>
			<tr>
				<td align=center class=HEADER>
				AnnouncementX Update:
				</td>
			</tr>
			<tr>
				<td align=center class=main>
				<strong>Important: </strong>only administrators can run updates, please, if you are an administrator, enter your username and password:<br /><br />
				<form name='confirm' action='./update.php?p=confirm' method='post'>
				<input type=hidden name=security value=1>
				Username: <input type=text name='user' value='Username' onFocus="this.value=''"><br /><br />
				Password: <input type=password name='pass' value='Password' onFocus="this.value=''"><br /><br />
				<input type=checkbox name='md5' value='1'> Use md5 encryption (more secure)<br /><br />
				<input type=submit name=submit class=submit value='Continue'>
				</td>
			</tr>
		</table>

END;
		
		} else {
		
			echo "Critical Error!";
			exit;
		
		}
	
	}
	
	function confirm() {
	
	$security=$_POST['security'];
	
		if (isset($security)) {
		
			$md5=$_POST['md5'];
			
			$user=$_POST['user'];
			$pass=$_POST['pass'];
			
			if (isset($md5)) {
			
				$pass=md5($pass);
			
			}
			
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql=mysql_query("SELECT `Name`,`Password`,`Group` FROM `members` WHERE `Name`='$user'") or die ("AnnouncementX Error: " . mysql_error());
			
			$group=mysql_result($sql,0,'Group');
			
			$query=mysql_query("SELECT `Pr_admin` FROM `groups` WHERE `Name`='$group'") or die ("AnnouncementX Error: " . mysql_error());
			
			$permissions=mysql_fetch_row($query);
			
			mysql_close($link);
			
			if ($permissions[0]='yes') {
			
				$password=mysql_result($sql,0,'Password');
				
				if (isset($md5)) {
				
					$password=md5($password);
				
				}
				
				if ($pass == $password) {
				
echo <<<END

					<table align=center class=maintable>
						<tr>
							<td align=center class=HEADER>
							AnnouncementX Update:
							</td>
						</tr>
						<tr>
							<td align=center class=main>
							Your username & password have been accepted, click 'Continue' to start the update process:<br /><br />
							<form name='update' action='./update.php?p=update' method='post'>
								<input type=hidden name=security value=1>
								<input type=submit name=submit value='Continue' class=submit>
							</form>
							</td>
						</tr>
					</table>

END;
				
				} else {
				
					echo "Critical Error: wrong password!";
					exit;
				
				}
			
			} else {
			
				echo "Critical Error: you do not have permissions to update AX!";
				exit;
			
			}
		
		} else {
		
			echo "Critical Error! Hacking attempt!";
			exit;
		
		}
	
	}
	
	function show_update() {
	
	$security=$_POST['security'];
	
		if (isset($security)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql=mysql_query("SELECT `id`,`Category` FROM `replies`") or die ("AnnouncementX Error: " . mysql_error());
			
			$num=mysql_num_rows($sql);
			
			$count=0;
			
			for ($i=0;$i<$num;$i++) {
			
				$rid=mysql_result($sql,$i,'id');
				$category=mysql_result($sql,$i,'Category');
				
				$query=mysql_query("SELECT `id` FROM `categories` WHERE `Name`='$category'") or die ("AnnouncementX Error: " . mysql_error());
				
				$id=mysql_result($query,0,'id');
				
				$update=mysql_query("UPDATE `replies` SET `Category`='$id' WHERE `id`='$rid'") or die ("AnnouncementX Error: " . mysql_error());
				
				$count++;
			
			}
			
			$posts=mysql_query("SELECT id,Category FROM `posts`") or die ("AnnouncementX Error: " . mysql_error());
			
			$pnum=mysql_num_rows($posts);
			
			for ($i=0;$i<$pnum;$i++) {
			
				$pid=mysql_result($posts,$i,'id');
				$category=mysql_result($posts,$i,'Category');
				
				$request=mysql_query("SELECT `id` FROM `categories` WHERE `Name`='$category'") or die ("AnnouncementX Error: " . mysql_error());
				
				$id=mysql_result($request,0,'id');
				
				$update_again=mysql_query("UPDATE `posts` SET `Category`='$id' WHERE `id`='$pid'") or die ("AnnouncementX Error: " . mysql_error());
				
				$count++;
			
			}
			
				$getridofatable=mysql_query("DROP TABLE IF EXISTS `notebook`") or die ("AnnouncementX Error: " . mysql_error());
				
				$createtbl='CREATE TABLE `notebook` (' 
					. ' `id` int(10) NOT NULL AUTO_INCREMENT, ' 
					. ' `mid` int(10) NOT NULL, ' 
					. ' `Message` text NOT NULL, ' 
					. ' PRIMARY KEY (`id`)' 
					. ' )';
					
				$create=mysql_query($createtbl) or die ("AnnouncementX Error: " . mysql_error());
			
			$members=mysql_query("SELECT id FROM `members`") or die ("AnnouncementX Error: " . mysql_error());
			
			for ($i=0;$i<mysql_num_rows($members);$i++) {
			
				$mid=mysql_result($members,$i,'id');
								
				$addqr=mysql_query("INSERT INTO `notebook` VALUES ('','$mid','It is the place for your personal notes!')") or die ("AnnouncementX Error: " . mysql_error());
			
				$count++;
			
			}
			
			mysql_close($link);
			
echo <<<END

			<table align=center class=maintable>
				<tr>
					<td align=center class=HEADER>
					AnnouncementX Update:
					</td>
				</tr>
				<tr>
					<td align=center class=main>
					<b>Congratulations!</b> You have succesfully updated AX, click the link below to continue:<br /><br />
					<a href='./index.php?do=&' title='Continue'>Click here to continue</a><br /><br />
					Requests to DB made: <b>$count</b>
					</td>
				</tr>
			</table>

END;
		
		} else {
		
			echo "Hacking attempt!";
			exit;
		
		}
	
	}
	
	function show_update_new() {
	
		$security=$_POST['security'];
		
		if (isset($security)) {
		
			$count == 0; // DB Requests counter
			
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			// First part of the update process start
			// Updating `posts`
			
			$sql=mysql_query("SELECT * FROM `posts`") or die ("AnnouncementX Error: " . mysql_error());
			
			$rows=mysql_num_rows($sql);
			
			for ($i=0;$i<$rows;$i++) {
			
				$pid=mysql_result($sql,$i,'id'); // Post id
				$cat=mysql_result($sql,$i,'Category'); // Category name
				
				$subsql=mysql_query("SELECT `id` FROM `categories` WHERE `Name`='$cat'") or die ("AnnouncementX Error: " . mysql_error());
				
				@ $cid=mysql_result($subsql,0,'id');
				
				$checkrow=mysql_num_rows($subsql);
				
				if ($checkrow < 1) {
				
					echo "Post Query General Error: no categories found (post id: ".$pid.", cat name: ".$cat.")";
				
				} elseif ($checkrow == 1) {
				
					$updatesql=mysql_query("UPDATE `posts` SET `Category`='$cid' WHERE `id`='$pid'") or die ("AnnouncementX Error: " . mysql_error());
					$count++;
				
				} else {
				
					echo "Post Query General Error: more than 1 category with then name <b>".$cat."</b> found in the database";
					exit;
				
				}
			
			}
			
			// End of the first step
			
			// Second step of the update process
			// Updating `replies`
			
			$sql=mysql_query("SELECT * FROM `replies`") or die ("AnnouncementX Error: " . mysql_error());
			
			$rows=mysql_num_rows($sql);
			
			for ($i=0;$i<$rows;$i++) {
			
				$rid=mysql_result($sql,$i,'id');
				$cat=mysql_result($sql,$i,'Category');
				
				$subsql=mysql_query("SELECT `id` FROM `categories` WHERE `Name`='$cat'") or die ("AnnouncementX Error: " . mysql_error());
				
				$cid=mysql_result($subsql,0,'id');
				
				$checkrow=mysql_num_rows($subsql);
				
				if ($checkrow < 1) {
				
					echo "Replies Query General Error: no categories found (reply id: ".$rid.", cat name: ".$cat.")";
					exit;
				
				} elseif ($checkrow == 1) {
				
					$updatesql=mysql_query("UPDATE `replies` SET `Category`='$cid' WHERE `id`='$rid'") or die ("AnnouncementX Error: " . mysql_error());
					$count++;
				
				} else {
				
					echo "Replies Query General Error: more than 1 category with then name <b>".$cat."</b> found in the database";
					exit;
				
				}

			}
			
			// End of second step
			
			// Third step of the updating process
			// Adding new table and giving each registered user personal notebook
			
			$getridofatable=mysql_query("DROP TABLE IF EXISTS `notebook`") or die ("AnnouncementX Error: " . mysql_error());
				
			$createtbl='CREATE TABLE `notebook` (' 
				. ' `id` int(10) NOT NULL AUTO_INCREMENT, ' 
				. ' `mid` int(10) NOT NULL, ' 
				. ' `Message` text NOT NULL, ' 
				. ' PRIMARY KEY (`id`)' 
				. ' )';
					
			$create=mysql_query($createtbl) or die ("AnnouncementX Error: " . mysql_error());
			
			$members=mysql_query("SELECT id FROM `members`") or die ("AnnouncementX Error: " . mysql_error());
			
			for ($i=0;$i<mysql_num_rows($members);$i++) {
			
				$mid=mysql_result($members,$i,'id');
								
				$addqr=mysql_query("INSERT INTO `notebook` VALUES ('','$mid','It is the place for your personal notes!')") or die ("AnnouncementX Error: " . mysql_error());
			
				$count++;
			
			}
			
			// End of the third step
			
			// Outputing the results
			
echo <<<END

			<table align=center class=maintable>
				<tr>
					<td align=center class=HEADER>
					AnnouncementX Update:
					</td>
				</tr>
				<tr>
					<td align=center class=main>
					<b>Congratulations!</b> You have succesfully updated AX, click the link below to continue:<br /><br />
					<a href='./index.php?do=&' title='Continue'>Click here to continue</a><br /><br />
					Requests to DB made: <b>$count</b>
					</td>
				</tr>
			</table>

END;
		
			// End of the results
			
			// Closing the db connection
			
			mysql_close($link);
			
			// End of the update process
		
		} else {
		
			echo "Access denied!";
			exit;
		
		}
	
	}
	
	function show_header() {
	
echo <<<END

	<html>
	<head>
	<title>AnnouncementX Update</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="./Cache/default.css" rel="stylesheet" type="text/css"> 	
	</head>
	
	<body topmargin=40>

END;
	
	}
	
	function show_bottom() {
	
		echo "</body></html>";
	
	}

}

?>