<?
//+----------------------------------
//	AnnoucementX Board Script
//	Version: 1.0
//	Author: Cat
//	Created: 2004/11/31
//	Updated: 2005/10/12
//	Description: Configures Admin CP
//+----------------------------------


// All the predefined values and settings
// And of course security

session_start();

error_reporting (E_ERROR | E_WARNING | E_PARSE);

require ("../conf_global.php");

define ('USER',$username_file);
define ('PASS',$password_file);
define ('DATA',$database_file);
define ('HOST',$host_file);

$username=$_SESSION['admin_username'];
$password=$_SESSION['admin_password'];

if ($username=='') {

	header ("Location:index.php");
	exit;
	
}

if ($logger==1) {

	$index=true;

}

if (phpversion() >= "4.2.0") {

	@ $category = $_GET['category'];
	@ $id = $_GET['id'];
	@ $code = $_GET['code'];

}

/*if ($index!=true) {

	header("Location:./index.php");
	exit;

}*/

// Here goes some deco-stuff and the switch

$idx=new Admin;
$groups=new Groups;
$user=new User;
$modify=new Modify;
$skin=new Skin;
$db=new Database;

$idx->show_header();

switch ($code) {

case "general":
	$idx->show_general($username,$password);
break;

case "general_end":
	$idx->general_end($username,$password);
break;

case "security":
	$idx->show_security($username,$password);
break;

case "security_end":
	$idx->security_end($username,$password);
break;

case "advanced":
	$idx->show_advanced($username,$password);
break;

case "advanced_end":
	$idx->advanced_end($username,$password);
break;

case "badwords":
	$idx->show_badwords($username,$password);
break;

case "badwords_end":
	$idx->badwords_end($username,$password);
break;

case "show_add_badword":
	$idx->show_add_badword($username,$password);
break;

case "show_mod_badword":
	$idx->show_mod_badword($username,$password);
break;

case "show_del_badword":
	$idx->show_del_badword($username,$password);
break;

case "add_badword":
	$idx->add_badword($username,$password);
break;

case "delete_badword":
	$idx->delete_badword($username,$password);
break;

case "modify_badword":
	$idx->modify_badword($username,$password);
break;

case "adduser":
	$user->view_add($username,$password);
break;

case "adduser_end":
	$user->add_finish($username,$password);
break;

case "edit_user":
	$user->view_edit($username,$password);
break;

case "edit_user_middle":
	$user->view_edit_middle($username,$password);
break;

case "edit_user_end":
	$user->edit_finish($username,$password);
break;

case "delete_user":
	$user->view_delete($username,$password);
break;

case "delete_user_end":
	$user->delete_finish($username,$password);
break;

case "ban_user":
	$user->view_ban($username,$password);
break;

case "ban_user_end":
	$user->ban_finish($username,$password);
break;

case "unban_user":
	$user->unban_user($username,$password);
break;

case "groups":
	$groups->view_groups($username,$password);
break;

case "add_group":
	$groups->add_group($username,$password);
break;

case "delete_group":
	$groups->delete_group($username,$password,$id);
break;

case "modify_group":
	$groups->modify_group($username,$password,$id);
break;

case "modify_group_end":
	$groups->modify_end($username,$password);
break;

case "manage_skins":
	$skin->manage_skins($username,$password);
break;

case "add_skin":
	$skin->view_add_skin($username,$password);
break;

case "delete_skin":
	$skin->view_del_skin($username,$password);
break;

case "modify_skin":
	$skin->view_mod_skin($username,$password,$id);
break;

case "add_skin_end":
	$skin->add_skin_end($username,$password);
break;

case "del_skin_end":
	$skin->add_skin_end($username,$password);
break;

case "mod_skin_end":
	$skin->mod_skin_end($username,$password);
break;

case "change_skin":
	$skin->change_skin($username,$password);
break;

case "manage_css":
	$skin->manage_css($username,$password);
break;

case "manage_css_file":
	$skin->manage_css_file($username,$password);
break;

case "manage_css_finish":
	$skin->manage_css_finish($username,$password);
break;

case "forums":
	$idx->show_forums($username,$password);
break;

case "add_forum":
	$idx->add_forum($username,$password);
break;

case "delete_forum":
	$idx->delete_forum($username,$password,$category);
break;

case "modify_forum":
	$modify->view_modify($username,$password,$category);
break;

case "modify_end":
	$modify->do_modify($username,$password);
break;

case "login":
	$idx->login();
break;

case "account_change":
	$idx->account_change($username,$password);
break;

case "db_optimize":
	$db->db_optimise();
break;

case "db_opt_finish":
	$db->do_optimise();
break;

case "db_backup":
	$db->db_backup();
break;

case "db_backup_finish":
	$db->do_backup();
break;

case "db_restore":
	$db->db_restore();
break;

case "db_restore_finish":
	$db->do_restore();
break;

default:
	$idx->show_welcome($username,$password);
break;

}

$idx->show_pagetail();

// Functions list is right below
// Even I do not clearly know where some stuff can be, so do not advise changing anything here

class Admin {

	function login() {
	
	$user=$_POST['user'];
	$pass=$_POST['pass'];
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$if_qr="SELECT * FROM groups WHERE Name=$user AND Pr_admin='yes'";
	$if=mysql_query($if_qr) or die ('AnnouncementX Error: ' . mysql_error());
	
	mysql_close($link);
	
	$get_if=mysql_num_rows($if);
	
		if ($get_if>0) {
	
			$_SESSION['admin_username']=$user;
			$_SESSION['admin_password']=$pass;
			header ("Location:./index.php");
			exit;
	
		} else {
	
echo <<<END

	<html>
	<head>
	<title>AnnouncementX Admin CP - Login</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="admin_cp_css.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	<table width="100%" height="90%" align="center" border="0">
		<tr>
			<td align="center">
				<table width="250" align="center" border="1" bordercolor="#000000" style="border-collapse: collapse" cellpadding="3">
					<tr>
						<td align="center" class="header">
						Please, LogIn
						</td>
					</tr>
					<tr>
						<td align="center" class="table_row" height="240">
							<form name="login" action="admin_main.php?code=login" method="post">
							Wrong username or password, please, re-login.<br /><br />
								<label for="name">Username: </label>
								<input type="text" name="user" class="field" value="" size="25">
								<br /><br />
								<label for="pass">Password: </label>
								<input type="password" name="pass" class="field" value="" size="22">
								<br /><br />
								<input type="submit" name="submit" value="Login to AdminCP" class="submit">
							</form>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	</body>
	</html>
	
END;
	
		}
	
	}
	
	function copyright() {
	
		echo "<center>&copy; 2004-2005 AnnouncementX</center>";
	
	}
	
	function show_forums($username,$password) {
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$go_qr="SELECT * FROM categories";
	
	$go=mysql_query($go_qr) or die ('AnnouncementX Error: ' . mysql_error());
	
	mysql_close($link);
	
	$c_num=mysql_num_rows($go);
		
echo <<<END
	<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<tr>
			<td align=center class=header colspan=2>
			Manage Categories
			</td>
		</tr>
		<tr>
			<th width='70%' align=center class=table_row>
			<b>Name</b>
			</th>
			<th align=center class=table_row>
			<b>Actions</b>
			</th>
		</tr>
END;
		for ($i=0; $i<$c_num; $i++) {
		
			$id=mysql_result($go,$i,'id');
			$name=mysql_result($go,$i,'Name');
			$description=mysql_result($go,$i,'Description');
			echo "<tr>
				<td align=center class=table_row>
				$name<br />
				$description
				</td>
				<td align=center class=table_row>
				<a href='admin_main.php?code=delete_forum&category=$id'><img src='del.gif' width=24 height=24 alt='Delete category ($name)' border=0></a> | 
				<a href='admin_main.php?code=modify_forum&category=$id'><img src='edit.gif' width=24 height=24 alt='Edit category ($name)' border=0></a>
				</td>
			</tr>
			";

		}
		
echo <<<END
		<tr>
			<td align=center class=table_bottom colspan=2>
			</td>
		</tr>
	</table>
	<br /><br />
	<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<tr>
			<td align=center class=header>
			Add a category
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<form name='add_forum' action='admin_main.php?code=add_forum' method='post'>
			<label for='category'>New Category: </label>
			<input type=text name='category' value='' size=30 class='field'><br /><br />
			Description:<br /><br />
			<textarea name=description class=field rows=15 cols=28></textarea><br /><br />
			<input type=submit name=submit value="Create New Category">
			</form>
			</td>
		</tr>
		<tr>
			<td align=center class=table_bottom>
			</td>
		</tr>
	</table>
END;
	}
	
	function delete_forum($username,$password,$category) {
	
		if (isset($category)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			$delete_qr="DELETE FROM categories WHERE id='$category'";
			$delete=mysql_query($delete_qr) or die ('AnnouncementX Error: ' . mysql_error());
			
			$sql=mysql_query("DELETE FROM `replies` WHERE `Category`='$category'") or die ("AnnouncementX Error: " . mysql_error());
			
			mysql_close($link);
			
			if (!headers_sent) {
			
				header("Location:admin_main.php?code=forums");
				exit;
				
			} else {
			
				echo "<a href='admin_main.php?code=forums'>Click here to continue</a>";
				
			}
			
		} else {
		
			echo "Unknown Error";
			
		}
		
	}
	
	function add_forum($username,$password) {
	
	$category=$_POST['category'];
	$description=$_POST['description'];
	
		if (isset($category,$description)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$add_qr="INSERT INTO categories(`Name`,`Description`) VALUES ('$category','$description')";
			$add=mysql_query($add_qr) or die ('AnnouncementX Error: ' . mysql_error());
			
			mysql_close($link);
			
				echo "<a href='admin_main.php?code=forums'>Click here to continue</a>";
							
		}
		
	}
			
	function show_badwords($username,$password) {
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$check_qr="SELECT * FROM badwords";
		$check=mysql_query($check_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
		$status_qr="SELECT * FROM config WHERE `Name`='Badwords'";
		$status=mysql_query($status_qr) or die('AnnouncementX Error: ' . mysql_error());
		
		$result=mysql_result($status,0,'Value');
		
		mysql_close($link);
		
		$num=mysql_num_rows($check);		
		
echo <<<END

	<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<tr>
			<td align=center class=header>
			Current Badwords
			</td>
		</tr>
END;
		for ($i=0; $i<$num; $i++) {
		
		$badword=mysql_result($check,$i,'Word');
		echo "<tr>\n<td align=center class=table_row>$badword</td>\n</tr>";
		
		}
		
echo <<<END
		<tr>
			<td align=center class=table_bottom>
			</td>
		</tr>
	</table>
	<br /><br />
	<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
	<form name='badwords' action='admin_main.php?code=badwords_end&' method='post'>
		<tr>
			<td align=center class=header>
			Badwords Settings
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			Badwords: <input type=radio name=badwords value=On checked> On   <input type=radio name=badwords value=Off> Off<br />
			Current Status: $result
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<input type=submit name=submit value='Save Changes' class=submit>  <input type=reset name=reset>
			</td>
		</tr>
		</tr>
		<tr>
			<td align=center class=table_row>
			<a href='#' title='Add a badword' onClick='javascript:window.open("admin_main.php?code=show_add_badword&logger=1","Badword Manipulations","width=600,height=400,scrollbars=yes")'>Add a badword</a> | 
			<a href='#' title='Modify a badword' onClick='javascript:window.open("admin_main.php?code=show_mod_badword&logger=1","Badword Manipulations","width=600,height=400,scrollbars=yes")'>Modify a badword</a> | 
			<a href='#' title='Delete a badword' onclick="javascript:window.open('admin_main.php?code=show_del_badword&logger=1','Badword Manipulations','width=600,height=400,scrollbars=yes')">Delete a badword</a>  
			</td>		
		</tr>
		<tr>
			<td align=center class=table_bottom>
			</td>
		</tr>
	</table>

END;

	}
	
	function show_add_badword($username,$password) {
	
echo <<<END

		<html>
		<head>
		<title>AnnouncementX Admin CP</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<link href='admin_cp_css.css' rel='stylesheet' type='text/css'>
		</head>
		
		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='add_badword' action='admin_main.php?code=add_badword' method='post'>
		<tr>
			<td align=center class=header>
			Add a Badword
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<label for='badword'>New Badword: </label><input type=text name=badword size='30' class=field>
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<input type=submit name=submit value='Add a Badword' class=submit>  <input type=reset name=reset>
			</td>
		</tr>
		<tr>
			<td align=center class=table_bottom>
			</td>
		</tr>
		</table>

END;
	
	}
	
	function show_mod_badword($username,$password) {
	
echo <<<END

		<html>
		<head>
		<title>AnnouncementX Admin CP</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<link href='admin_cp_css.css' rel='stylesheet' type='text/css'>
		</head>

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='modify_badword' action='admin_main.php?code=modify_badword' method='post'>
		<tr>
			<td align=center class=header>
			Modify a Badword
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<label for='badword'>Modify a Badword: </label><input type=text name=badword size='30' class=field>
			<br /><br />
			<label for='new_badword'>Replace it with: </label><input type=text name=new_badword size='30' class=field>
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<input type=submit name=submit value='Modify a Badword' class=submit>  <input type=reset name=reset>
			</td>
		</tr>
		<tr>
			<td align=center class=table_bottom>
			</td>
		</tr>
		</table>

END;
	
	}
	
	function show_del_badword($username,$password) {
	
echo <<<END
	
		<html>
		<head>
		<title>AnnouncementX Admin CP</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<link href='admin_cp_css.css' rel='stylesheet' type='text/css'>
		</head>
		
		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='delete_badword' action='admin_main.php?code=delete_badword' method='post'>
		<tr>
			<td align=center class=header>
			Delete a Badword
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<label for='badword'>Delete Badword: </label><input type=text name=badword size='30' class=field>
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<input type=submit name=submit value='Delete a Badword' class=submit>  <input type=reset name=reset>
			</td>
		</tr>
		<tr>
			<td align=center class=table_bottom>
			</td>
		</tr>
		</table>
		
END;
	
	}
	
	function add_badword($username,$password) {
	
		$badword=$_POST['badword'];
		
		if (isset($badword)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$update_qr="INSERT INTO badwords(Word) VALUES ('$badword')";
			$update=mysql_query($update_qr) or die ('AnnouncementX Error: ' . mysql_error());
			
			mysql_close($link);
			
			if (!headers_sent) {
			
				header("Location:admin_main.php?code=badwords");
				
			} else {
			
				echo "<center>Badword <b>$badword</b> has been succesfully added<br />Now you can close this window</center>";
				
			}
			
		} else {
		
			if (!headers_sent) {
			
				header("Location:admin_main.php?code=badwords");
				exit;
				
			} else {
			
				echo "<a href='admin_main.php?code=badwords>Click here to continue</a>";
				
			}
			
		}
		
	}
	
	function delete_badword($username,$password) {
	
		$badword=$_POST['badword'];
		
		if(isset($badword)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$delete_qr="DELETE FROM badwords WHERE `Word`='$badword'";
			$delete=mysql_query($delete_qr) or die ('AnnouncementX Error: ' . mysql_error());
			
			mysql_close($link);
			
			if (!headers_sent) {
			
				header("Location:admin_main.php?code=badwords");
				exit;
				
			} else {
			
				echo "<center>Badword <b>$badword</b> has been succesfully deleted<br />Now you can close this window</center>";
				
			}
			
		} else {
		
			if (!headers_sent) {
			
				header("Location:admin_main.php?code=badwords");
				exit;
				
			} else {
			
				echo "<a href=admin_main.php?code=badwords>Click here to continue</a>";
				
			}
			
		}
		
	}
	
	function modify_badword($username,$password) {
	
		$badword=$_POST['badword'];
		$new_badword=$_POST['new_badword'];
		
		if (isset($badword,$new_badword)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$replace_qr="UPDATE badwords SET `Word`='$new_badword' WHERE `Word`='$badword'";
			$replace=mysql_query($replace_qr) or die ('AnnouncementX Error: ' . mysql_error());
			
			mysql_close($link);
			
			if (!headers_sent) {
			
				header("Location:admin_main.php?code=badwords");
				
			} else {
			
				echo "<center>Badword <b>$badword</b> has been succesfully modified<br />Now you can close this window</center>";
				
			}
			
		} else {
		
			if (!headers_sent) {
			
				header("Location:admin_main.php?code=badwords");
				exit;
				
			} else {
			
				echo "<a href=admin_main.php?code=badwords>Click here to continue</a>";
				
			}
			
		}
		
	}
	
	function badwords_end($username,$password) {
	
		$value=$_POST['badwords'];
		
		if (isset($value)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql=mysql_query("UPDATE config SET `Value`='$value' WHERE `Name`='BadWords'") or die ("AnnouncementX Error: " . mysql_error());
			
			mysql_close($link);
			
			echo "<a href='admin_main.php?code=badwords&".strip_tags(sid)."'>Click here to continue</a>";
					
		} else {
			
			echo "Unknown Error";
		
		}
	
	}
	
	function show_header() {
	
echo <<<END
	
	<html>
	<head>
		<title>AnnouncementX AdminCP</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="admin_cp_css.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	
END;

	}
	
	function show_pagetail() {
	
		echo "</body></html>";
	
	}
	
	function show_advanced($username,$password) {
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$sql[0]=mysql_query("SELECT Value FROM config WHERE `Name`='Ip_logs'") or die ("AnnouncementX Error: " . mysql_error());
		$sql[1]=mysql_query("SELECT Value FROM config WHERE `Name`='Emails'") or die ("AnnouncementX Error: " . mysql_error());
		$sql[2]=mysql_query("SELECT Value FROM config WHERE `Name`='Guests_post'") or die ("AnnouncementX Error: " . mysql_error());
		$sql[3]=mysql_query("SELECT Value FROM config WHERE `Name`='PM_number'") or die ("AnnouncementX Error: " . mysql_error());
		
		$result[0]=mysql_result($sql[0],0,'Value');
		$result[1]=mysql_result($sql[1],0,'Value');
		$result[2]=mysql_result($sql[2],0,'Value');
		$result[3]=mysql_result($sql[3],0,'Value');
			
		mysql_close($link);
	
echo <<<END
	<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
	<form name='security' action='admin_main.php?code=advanced_end' method='post'>
		<tr>
			<td align=center class=header>
			Advanced Settings
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			Ip Logs: <input type=radio name=ip_logs value=On checked> On   <input type=radio name=ip_logs value=Off> Off<br />
			Current Status: $result[0]
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			E-mails: <input type=radio name=emails value=On checked> On   <input type=radio name=emails value=Off> Off<br />
			Current Status: $result[1]
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			Can Guests Post: <input type=radio name=guests_post value=On checked> On   <input type=radio name=guests_post value=Off> Off<br />
			Current Status: $result[2]
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<label for='pms'>Max. PM Number</label><input type=text name=pms value=$result[3] size=4 maxlength=3 class=field>
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<input type=submit name=submit value='Save Changes'>  <input type=reset name=reset>
			</td>
		</tr>
		<tr>
			<td align=center class=table_bottom>
			</td>
		</tr>
	</form>
	</table>
END;
	}
	
	function advanced_end($username,$password) {
	
		$ips=$_POST['ip_logs'];
		$emails=$_POST['emails'];
		$guests=$_POST['guests_post'];
		$pms=$_POST['pms'];
		
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$update_qr_1="UPDATE config SET `Value`='$ips' WHERE `Name`='Ip_logs'";
		$update_qr_2="UPDATE config SET `Value`='$emails' WHERE `Name`='Emails'";
		$update_qr_3="UPDATE config SET `Value`='$guests' WHERE `Name`='Guests_post'";
		$update_qr_4="UPDATE config SET `Value`='$pms' WHERE `Name`='PM_number'";
		
		$update_1=mysql_query($update_qr_1) or die ('AnnouncementX Error: ' . mysql_error());
		$update_2=mysql_query($update_qr_2) or die ('AnnouncementX Error: ' . mysql_error());
		$update_3=mysql_query($update_qr_3) or die ('AnnouncementX Error: ' . mysql_error());
		$update_4=mysql_query($update_qr_4) or die ('AnnouncementX Error: ' . mysql_error());
		
		mysql_close($link);
		
		if (!headers_sent) {
		
			header("Location:admin_main.php?code=advanced");
			
		} else {
		
			echo "<a href=admin_main.php?code=advanced>Click here to continue</a>";
			
		}
		
	}
	
	function show_security($username,$password) {
		
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$sql[0]=mysql_query("SELECT Value FROM config WHERE `Name`='Cookies'") or die ("AnnouncementX Error: " . mysql_error());
		$sql[1]=mysql_query("SELECT Value FROM config WHERE `Name`='Registrations'") or die ("AnnouncementX Error: " . mysql_error());
		$sql[2]=mysql_query("SELECT Value FROM config WHERE `Name`='Validation'") or die ("AnnouncementX Error: " . mysql_error());
		
		$result[0]=mysql_result($sql[0],0,'Value');
		$result[1]=mysql_result($sql[1],0,'Value');
		$result[2]=mysql_result($sql[2],0,'Value');
		
		mysql_close($link);
		
		
		
echo <<<END

	<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
	<form name='security' action='admin_main.php?code=security_end' method='post'>
		<tr>
			<td align=center class=header>
			Security/Registration Settings
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			Cookies: <input type=radio name=cookies value=On checked> On   <input type=radio name=cookies value=Off> Off<br />
			Current Status: $result[0]
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			Registrations: <input type=radio name=registrations value=On checked> On   <input type=radio name=registrations value=Off> Off<br />
			Current Status: $result[1]
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			Validation: <input type=radio name=validation value=On checked> On   <input type=radio name=validation value=Off> Off<br />
			Current Status: $result[2]
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			<input type=submit name=submit value='Save Changes'>  <input type=reset name=reset>
			</td>
		</tr>
		<tr>
			<td align=center class=table_bottom>
			</td>
		</tr>
	</form>
	</table>
END;

	}
	
	function security_end($username,$password) {
	
	$cookies=$_POST['cookies'];
	$registrations=$_POST['registrations'];
	$validation=$_POST['validation'];
	
		if (isset($cookies,$registrations,$validation)) {
		
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$update_qr_1="UPDATE config SET `Value`='$cookies' WHERE `Name`='Cookies'";
		$update_qr_2="UPDATE config SET `Value`='$registrations' WHERE `Name`='Registrations'";
		$update_qr_3="UPDATE config SET `Value`='$validation' WHERE `Name`='Validation'";
		
		$update_1=mysql_query($update_qr_1) or die ('AnnouncementX Error: ' . mysql_error());
		$update_2=mysql_query($update_qr_2) or die ('AnnouncementX Error: ' . mysql_error());
		$update_3=mysql_query($update_qr_3) or die ('AnnouncementX Error: ' . mysql_error());
		
		mysql_close($link);
			
			if (!headers_sent) {
		
				header("Location:admin_main.php?code=security");
		
			} else {
		
				echo "<a href='admin_main.php?code=security'>Click here to continue</a>";
		
			}
			
		} else {
		
			echo "Unknown Error!";
			
		}
		
	}
	
	function show_welcome($username,$password) {
	
	$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
	mysql_select_db(DATA,$link);
	
	$get_qr=mysql_query("SELECT * FROM members WHERE `Name`='$username' AND `Password`='$password'") or die ('AnnouncementX Error: ' . mysql_error());
	$members_all=mysql_query("SELECT * FROM members") or die ('AnnouncementX Error: ' . mysql_error());
	
	$members_num=mysql_num_rows($members_all);
	$members_last=mysql_result($members_all,$members_num-1,"Name");
	
	mysql_close($link);
	
	$email=mysql_result($get_qr,0,'Email');

	echo"<script language='JavaScript'>
	<!--
		function ValidateForm() 
		{
			var check = 0;
			if (document.edit_account.username.value = '') { check = 1 }
			if (document.edit_account.password.value = '') { check = 1 }
			if (check = 1) {
			alert('Please, fill in all the fields in the form!'); 
			return false;
			} else {
			document.edit_account.submit.disabled = true;
			return true;
			}
		}
	-->
	</script>";

echo <<<END

	<center>
	<h3>Welcome to AdminCP, $username!<h3>
	<br /><br />
	</center>
	If you want to change your settings (e.g. password, e-mail), you can easily do it by filling the form right below.
	<br /><br />
	To change settings that will take effect on the board, please, select an item from the manu at the left side of the screen.
	<br /><br />
	<center>
	<h3>$username - Current Account Settings</h3><br />
	</center>
	<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<tr>
			<td align=center class=header>
			Current account settings
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
			To change anything, just change the value in a field.
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
				<table width=100% align=center border=0 cellpadding=3>
				<form name=edit_account action='admin_main.php?code=account_change' method=post>
					<tr>
						<td align=center class=table_row>
							<label for='username'>Username: </label>
							<input type=text name='username' value=$username size=30 class=field>
						</td>
					</tr>
					<tr>
						<td align=center class=table_row>
							<label for='password'>Password: </label>
							<input type=password name='password' value=$password size='30' class=field>
							&nbsp;(current password: $password)
						</td>
					</tr>
					<tr>
						<td align=center class=table_row>
							<label for='email'>E-Mail: </label>
							<input type=text name='email' value='$email' size=30 class=field>
						</td>
					</tr>
					<tr>
						<td align=center class=table_row>
							<input type=submit name=submit value='Edit Your Settings' class=submit>
							&nbsp;&nbsp;<input type=reset name=reset>
						</td>
					</tr>
					<tr>
						<td align="center" class="table_bottom">
						</td>
					</tr>
				</form>
				</table>
			</td>
		</tr>
	</table>
	<br /><br />
	<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<tr>
			<td align=center class=header>
			Some Stats
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
				Total Members: $members_num
			</td>
		</tr>
		<tr>
			<td align="center" class="table_row">
				Last Registered Member: $members_last
			</td>
		</tr>
		<tr>
			<td align="center" class="table_bottom">
			</td>
		</tr>
	</table>
END;
	
	}
	
	function account_change($username,$password) {
	
	$user_new=$_POST['username'];
	$pass_new=$_POST['password'];
	$email_new=$_POST['email'];
		
		if ($username=$user_new) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$insert_qr="UPDATE members SET Password=$pass_new, Email=$email WHERE Name=$username";
			$inset=mysql_query($insert_qr) or die ('AnnouncementX Error: ' . mysql_error());
			
			mysql_close($link);
			
			$_SESSION['admin_password']=$pass_new;
			
			if (!headers_sent) {
			
				header("Location:admin_main.php?code=");
				exit;
				
			} else {
			
				echo "<a href='admin_main.php?code=' title='continue'>Click here to continue</a>";
			
			}
		
		}
		
		if ($username!=$user_new) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$insert_qr="UPDATE members SET Name=$user_new, Password=$pass_new, Email=$email WHERE Name=$username";
			$inset=mysql_query($insert_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
			mysql_close($link);
		
			$_SESSION['admin_username']=$user_new;
			$_SESSION['admin_password']=$pass_new;
			
			if (!headers_sent) {
			
				header("Location:admin_main.php?code=");
				exit;
				
			} else {
			
				echo "<a href='admin_main.php?code=' title='continue'>Click here to continue</a>";
			
			}
		
		}
	
	}
	
	function show_general($username,$password) {
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$a[0]='Application';
		$a[1]='Title';
		$a[2]='Subtitle';
		$a[3]='Path';
		$a[4]='Offline_message';
		
		$sql[0]=mysql_query("SELECT Value FROM config WHERE `Name`='Application'") or die ("AnnouncementX Error: " . mysql_error());
		$sql[1]=mysql_query("SELECT Value FROM config WHERE `Name`='Title'") or die ("AnnouncementX Error: " . mysql_error());
		$sql[2]=mysql_query("SELECT Value FROM config WHERE `Name`='Subtitle'") or die ("AnnouncementX Error: " . mysql_error());
		$sql[3]=mysql_query("SELECT Value FROM config WHERE `Name`='Path'") or die ("AnnouncementX Error: " . mysql_error());
		$sql[4]=mysql_query("SELECT Value FROM config WHERE `Name`='Offline_message'") or die ("AnnouncementX Error: " . mysql_error());
		
		$result[0]=mysql_result($sql[0],0,'Value');
		$result[1]=mysql_result($sql[1],0,'Value');
		$result[2]=mysql_result($sql[2],0,'Value');
		$result[3]=mysql_result($sql[3],0,'Value');
		$result[4]=mysql_result($sql[4],0,'Value');
		
		mysql_close($link);
		
echo <<<END
	
	<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>

END;

	echo"<script language='JavaScript'>
	<!--
	
	function EnableForm()
	{
	
	document.general.submit.disabled = false;
	return false;
	
	}
	
	-->
	</script>";
	
echo <<<END
	
	<form name="general" action="admin_main.php?code=general_end&" method="post">
		<tr>
			<td align=center class=header>
			General Settings
			</td>
		</tr>
		<tr>
			<td align=center class=table_row>
				AnnouncementX: <input type="checkbox" name="application" value="On" onFocus="EnableForm()" checked> On<br />
				Current Status: <b>$result[0]</b>
			</td>
		</tr>
		<tr>
			<td align="center" class="table_row">
				<label for="title">Title: </label>
				<input type="text" name="title" value="$result[1]" size="30" class="field" onChange="EnableForm()">
			</td>
		</tr>
		<tr>
			<td align="center" class="table_row">
				<label for="subtitle">Subtitle: </label>
				<input type="text" name="subtitle" value="$result[2]" size="30" class="field" onChange="EnableForm()">
			</td>
		</tr>
		<tr>
			<td align="center" class="table_row">
				<label for="path">Path: </label>
				<input type="text" name="path" value="$result[3]" size="30" class="field" onChange="EnableForm()">
			</td>
		</tr>
		<tr>
			<td align="center" class="table_row">
				<label for="message">Offline Message: </label>
				<textarea name="message" rows="10" cols="28" onChange="EnableForm()">$result[4]</textarea>
			</td>
		</tr>
		<tr>
			<td align="center" class="table_row">
				<input type="submit" name="submit" value="Save Changes" disabled>   <input type="reset" name="reset">
			</td>
		</tr>
		<tr>
			<td align="center" class="table_bottom">
			</td>
		</tr>
	</form>
	</table>
	
END;

	}
	
	function general_end($username,$password) {
	
	$application=$_POST['application'];
	
	if ($application == 'On') {
	
		$application='On';
		
	} else {
	
		$application='Off';
	
	}
	
	$title=$_POST['title'];
	$subtitle=$_POST['subtitle'];
	$path=$_POST['path'];
	$offline_message=$_POST['message'];
		
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$update_qr_1="UPDATE config SET `Value`='$application' WHERE `Name`='Application'";
		$update_qr_2="UPDATE config SET `Value`='$title' WHERE `Name`='Title'";
		$update_qr_3="UPDATE config SET `Value`='$subtitle' WHERE `Name`='Subtitle'";
		$update_qr_4="UPDATE config SET `Value`='$path' WHERE `Name`='Path'";
		$update_qr_5="UPDATE config SET `Value`='$offline_message' WHERE `Name`='Offline_message'";
		
		$update_1=mysql_query($update_qr_1) or die ('AnnouncementX Error: ' . mysql_error());
		$update_2=mysql_query($update_qr_2) or die ('AnnouncementX Error: ' . mysql_error());
		$update_3=mysql_query($update_qr_3) or die ('AnnouncementX Error: ' . mysql_error());
		$update_4=mysql_query($update_qr_4) or die ('AnnouncementX Error: ' . mysql_error());
		$update_5=mysql_query($update_qr_5) or die ('AnnouncementX Error: ' . mysql_error());
		
		mysql_close($link);
		
		if (!headers_sent) {
		
			header("Location:admin_main.php?code=general");
		
		} else {
		
			echo"<a href='admin_main.php?code=general'>Click here to continue</a>";
		
		}
	
	}

}

class Groups {
	
	function view_groups($username,$password) {
		
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$get_g=mysql_query("SELECT * FROM groups") or die ('AnnouncementX Error: ' . mysql_error());
		
		mysql_close($link);
		
		$g_num=mysql_num_rows($get_g);
		
		$i=0;
		
		echo "<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
			<tr>
				<td align=center class=header colspan=2>
				Current Groups:
				</td>
			</tr>";
	
		while ($i<$g_num) {
	
			$id=mysql_result($get_g,$i,'id');
			$g_name=mysql_result($get_g,$i,'Name');
	
			echo "<tr><td align=center class=table_row width=70%>$g_name</td><td align=center class=table_row width=30%><a href='admin_main.php?code=delete_group&id=$id&' title='Delete group ($g_name)'><img src='del.gif' width=24 height=24 border=0></a>
			  <a href='admin_main.php?code=modify_group&id=$id' title='Modify Group ($g_name)'><img src='edit.gif' width=24 height=24 border=0></a></td></tr>";
	
			$i++;
	
		}
	
		echo "</table>";
	
		echo "<script language='javascript'>
		<!--
		function Validate() {
			if (document.add_group.group.value='') {
			alert ('Please, enter a group name!');
			return false;
			} else {
			document.add_group.submit.disabled = true;
			return true;
			}
		}
		-->
		</script>";
		
echo <<<END
			<br /><br />
			<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
			<form name='add_group' action='admin_main.php?code=add_group&' method='post'>
				<tr>
					<td align=center class=header>
					Add a group
					</td>
				</tr>
				<tr>
					<td align=center class=table_row>
					<label for='group'>New Group Name: </label><input type=text name='group' value='' size='30' class='field'>
					<br /><br />
					<strong>Description:</strong><br />
					<textarea name='descr' rows=14 cols=28 class=field></textarea>
					<br /><br />
					<strong>Privilegies:</strong><br />
					<input type=checkbox name='Pr_admin' value='yes'><label for='Pr_admin'>Admin</label>  
					<input type=checkbox name='Pr_mod' value='yes'><label for='Pr_mod'>Moderator</label>  
					<input type=checkbox name='Pr_valid' value='yes'><label for='Pr_valid'>Validating<label>  
					<input type=checkbox name='Pr_banned' value='yes'><label for='Pr_banned'>Banned</label>
					<br /><br />
					<input type=submit name=submit value='Add a group' class=submit>  <input type=reset name=reset>
					</td>
				</tr>
			</form>
			</table>
			
END;

	}
		
	function add_group($username,$password) {

	$name=$_POST['group'];
	$descr=$_POST['descr'];
	
	$pr[0]=$_POST['Pr_admin'];
	$pr[1]=$_POST['Pr_mod'];
	$pr[2]=$_POST['Pr_valid'];
	$pr[3]=$_POST['Pr_banned'];
	
	$e='';
	
		if ($descr == $e) {
	
			$descr='There is no description for this group';
	
		}
	
		if ($pr == $e) {
	
			$pr='No';
	
		}
	
		if (isset($name)) {
	
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
	
			$add_qr="INSERT INTO groups VALUES ('','$name','$descr','$pr[0]','$pr[1]','$pr[2]','$pr[3]')";
			$add=mysql_query($add_qr) or die ('AnnouncementX Error: ' . mysql_error());
	
			mysql_close($link);
		
				echo "<a href=admin_main.php?code=groups>Click here to continue</a>";
			
		}
	
	}
		
	function delete_group($username,$password,$id) {
			
		if (isset($id)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
	
			$delete=mysql_query("DELETE FROM groups WHERE `id`='$id'") or die ('AnnouncementX Error: ' . mysql_error());
		
			mysql_close($link);
		
				echo "<a href=admin_main.php?code=groups>Click here to continue</a>";
				
		}
	
	}
		
	function modify_group($username,$password,$id) {
		
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$query="SELECT * FROM groups WHERE `id`='$id'";
		$run=mysql_query($query) or die ('AnnouncementX Error: ' . mysql_error());
		
		$rows=mysql_fetch_row($run);
		
		if (mysql_num_rows($run)==0) {
		
			echo "Critical error, cannot resolve the group name<br /><a href='javascript:history.back()'>Click here to continue</a>";
		
		} elseif (mysql_num_rows($run)==1) {
		
echo <<<END

			<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
			<form name='modify_group' action='admin_main.php?code=modify_group_end' method='post'>
			<input type=hidden name='id' value='$id'>
				<tr>
					<td align=center class=header>
					Modify Group ($rows[1])
					</td>
				</tr>
				<tr>
					<td align=center class=table_row>
					<label for='name'>Group Name: </label>
					<input type=text name='name' value='$rows[1]' onfocus="this.value=''" size='30' class='field'><br /><br />
					Description:<br />
					<textarea name='description' rows=12 cols=28 class=field>$rows[2]</textarea><br />
					</td>
				</tr>
				<tr>
					<td align=center class=table_row>
					<b>Privilegies</b><br /><br />
					<input type=checkbox name='Pr_admin' value='yes'><label for='Pr_admin'>Admin</label>  
					<input type=checkbox name='Pr_mod' value='yes'><label for='Pr_mod'>Moderator</label>  
					<input type=checkbox name='Pr_valid' value='yes'><label for='Pr_valid'>Validating<label>  
					<input type=checkbox name='Pr_banned' value='yes'><label for='Pr_banned'>Banned</label>
					</td>
				</tr>
				<tr>
					<td align=center class=table_row>
					<input type=submit name=submit value='Save Changes' class=submit>  <input type=reset name=reset>
					</td>
				</tr>
				<tr>
					<td align=center class=table_bottom>
					</td>
				</tr>
			</form>
			</table>
			
END;

		} else {
		
			echo "Unknown Error!<br /><a href='javascript:history.back()'>Click here to continue";
		
		}
	
	}
		
	function modify_end($username,$password) {
	
		$id=$_POST['id'];
		$name=$_POST['name'];
		$descr=$_POST['description'];
	
		$pr[0]=$_POST['Pr_admin'];
		$pr[2]=$_POST['pr_mod'];
		$pr[3]=$_POST['Pr_valid'];
		$pr[1]=$_POST['Pr_banned'];
	
		$e='';
	
		if ($pr == $e) {
		
			$pr='no';
			
		}
		
		if (isset($id,$name)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
		
			$query="UPDATE groups SET `Name`='$name', `Description`='$descr', `Pr_admin`='$pr[0]', `Pr_banned`='$pr[1]', `Pr_mod`='$pr[2]', `Pr_valid`='$pr[3]' WHERE `id`='$id'";
			$run=mysql_query($query) or die ('AnnouncementX Error: ' . mysql_error());
		
			mysql_close($link);
		
			echo "Group <b>$name</b> has beem succesfully modified<br /><a href='admin_main.php?code=groups&' title='Continue'>Click here to continue</a>";
					
		} else {
		
			echo "Please, enter name and description for that group!<br /><a href='javascript:history.back()'>Click here to continue</a>";
		
		}
	
	}

}

class User {
		
	function view_add($username,$password) {
		
echo <<<END

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='add_user' action='admin_main.php?code=adduser_end' method='post'>
			<tr>
				<td align=center class=header>
				Add a User
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				Fields marked with <b>*</b> should be filled!
			</tr>
			<tr>
				<td align=center class=table_row>
				<label for='username'>Username* : </label>
				<input type=text name='username' value='' size=30 class=field>
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				<label for='password'>Password* : </label>
				<input type=password name='password' value='' size=30 class=field>
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				<label for='email'>E-Mail* : </label>
				<input type=text name='email' value='' size=30 class=field>
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				<label for='location'>Location: </label>
				<input type=text name='location' value='' size=30 class=field>
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				<label for='occupation'>Occupation: </label>
				<input type=text name='occupation' value='' size=30 class=field>
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				<label for=group>Group* : </label>
				<select size=1 name=group>
END;
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$query="SELECT * FROM groups";
			$run=mysql_query($query) or die ('AnnouncementX Error: ' . mysql_error());
			
			$num=mysql_num_rows($run);
			
			mysql_close($link);
			
			$i=0;
			
			while ($i<$num) {
			
			$name=mysql_result($run,$i,'Name');
			$phrase="<option value=$name>$name</option>";
			
				switch($name) {
				
				case "Member":
				$new_phrase="<option selected value=$name>$name</option>";
				echo $new_phrase;
				break;
					
				default:
				echo $phrase;
				break;
					
				
				}
			
			$i++;
			
			}
echo <<<END
				</select>
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				<input type=submit name=submit value='Save Changes' class=submit>   <input type=reset name=reset>
				</td>
			</tr>
			<tr>
				<td align=center class=table_bottom>
				</td>
			</tr>
		</form>
		</table>
END;
	}
		
	function add_finish($username,$password) {
	
	$name=$_POST['username'];
	$pass=$_POST['password'];
	$email=$_POST['email'];
	$location=$_POST['location'];
	$occupation=$_POST['occupation'];
	$group=$_POST['group'];
	
		if (isset($name,$pass,$email,$group)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
		
			$add_qr="INSERT INTO members VALUES ('','$name','$pass','$email','$location','$occupation','$group')";
			$add=mysql_query($add_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
			mysql_close($link);	
		
				echo "<a href=admin_main.php?code=adduser>Click here to continue</a>";
				
		} else {
		
			echo "Please, fill in all necessary fields<br /><a href=javascript:history.back()>Click here to continue</a>";
		
		}
	
	}
		
	function view_edit($username,$password) {
	
echo <<<END

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='edit_user' action='admin_main.php?code=edit_user_middle' method='post'>
			<tr>
				<td align=center class=header>
				Edit a User
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				Please, enter a username:
				<br /><br /><input type=text name='username' value='' size=30 class=field><br /><br />
				<input type=submit name=submit value='Continue' class=submit>
				</td>
			</tr>
			<tr>
				<td align=center class=table_bottom>
				</td>
			</tr>
		</form>
		</table>
END;

	}
		
	function view_edit_middle($username,$password) {
		
	$user=$_POST['username'];
	
		if(isset($user)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
		
			$check_qr="SELECT * FROM members WHERE `Name`='$user'";
			$check=mysql_query($check_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
			$num=mysql_num_rows($check);
			
			$pass=mysql_result($check,0,'Password');
			$email=mysql_result($check,0,'Email');
			$location=mysql_result($check,0,'Location');
			$occupation=mysql_result($check,0,'Occupation');
		
			if ($num=0) {
		
				echo "<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
							<tr>
								<td align=center class=header>
								Edit a User - Error
								</td>
							</tr>
							<tr>
								<td align=center class=table_row>
								Sorry, but there is not username as $user in our database, please check the username.<br />
								<a href='javascript:history.back()'>Go Back</a>
								</td>
							</tr>
							<tr>
								<td align=center class=table_bottom>
								</td>
							</tr>
					</table>";
	
			} else {
		
					echo "<script language='JavaScript'>
							<!--
							function Validate() {
								if (document.edit_user.username.value = '' || document.edit_user.password.value = '' || document.edit_user.email.value = '') {
								alert('Please, enter a username!');
								} else {
									if(confirm('Are you sure you want to edit this member?')) {
									document.edit_user.submit.disabled = true;
									return true;
									} else {
									alert('Process Stopped!');
									return false;
									}
								}
							}
							-->
							</script>";
							
echo <<<END

						<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
						<form name='edit_user' action='admin_main.php?code=edit_user_end' method='post' onsubmit="Validate()">
						<input type=hidden name='old' value='$user'>
							<tr>
								<td align=center class=header>
								Edit a User
								</td>
							</tr>
							<tr>
								<td align=center class=table_row>
								<label for='username'>Username: </label><input type=text name='username' value='$user' onfocus="this.value=''" size=30 class=field>
								</td>
							</tr>
							<tr>
								<td align=center class=table_row>
								<label for='password'>Password: </label><input type=text name=password value='$pass' onfocus="this.value=''" size=30 class=field>
								</td>
							</tr>
							<tr>
								<td align=center class=table_row>
								<label for='email'>E-Mail: </label><input type=text name='email' value='$email' onfocus="this.value=''" size=30 class=field>
								</td>
							</tr>
							<tr>
								<td align=center class=table_row>
								<label for='location'>Location: </label><input type=text name='location' value='$location' onfocus="this.value=''" size=30 class=field>
								</td>
							</tr>
							<tr>
								<td align=center class=table_row>
								<label for='occupation'>Occupation: </label><input type=text name='occupation' value="$occupation" onfocus="this.value=''" size=30 class=field>
								</td>
							</tr>
							<tr>
								<td align=center class=table_row>
								<label for='group'>Group: </label><select name='group' size='1'>

END;
							
							$select=mysql_query("SELECT `Name` FROM groups") or die ("AnnouncementX Error: " . mysql_error());
							$g_num=mysql_num_rows($select);
							
							$i=0;
							
							while ($i<$g_num) {

								$g_name=mysql_result($select,$i,'Name');
								echo $g_name;
								echo "<option value='$g_name'>$g_name</option>";
								$i++;

							}
							
							mysql_close($link);
							
echo <<<END
						
								</select>
								</td>
							</tr>
							<tr>
								<td align=center class=table_row>
								<input type=submit name=submit value='Save Changes' class=submit>   <input type=reset name=reset>
								</td>
							</tr>
							<tr>
								<td align=center class=table_bottom>
								</td>
							</tr>
						</form>
						</table>
						
END;

			}
			
		}
		
	}
		
	function edit_finish($username,$password) {
	
	$old=$_POST['old'];
	$user=$_POST['username'];
	$pass=$_POST['password'];
	$email=$_POST['email'];
	$location=$_POST['location'];
	$occupation=$_POST['occupation'];
	$group=$_POST['group'];
	
		if (isset($user,$pass,$email,$group)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
		
			$update_qr="UPDATE members SET `Name`='$user', `Password`='$pass', `Email`='$email', `Location`='$location', `Occupation`='$occupation', `Group`='$group' WHERE `Name`='$old'";
			$update=mysql_query($update_qr) or die('AnnouncementX Error: ' . mysql_error());
		
			mysql_close($link);
					
				echo "<a href=admin_main.php?code=edit_user>Click here to continue</a>";
					
		}
	
	}
		
	function view_ban($username,$password) {
	
		echo "<script language='JavaScript'>
			<!--
			function Validate() {
				if (document.ban_user.username.value = '') {
				alert('Please, enter a username!');
				} else {
					if(confirm('Are you sure you want to ban this member?')) {
					document.ban_user.submit.disabled = true;
					return true;
					} else {
					alert('Process Stopped!');
					return false;
					}
				}
			}
			-->
			</script>";
					
echo <<<END
		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='ban_user' action='admin_main.php?code=ban_user_end&'.strip_tags(sid) method='post' onsubmit="">
			<tr>
				<td align=center class=header>
				Ban a User
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				Please, enter the username of user that should be banned:<br /><br />
				<input type=text name='username' value='' size=30 class=field><br /><br />
				<label for='group'>Banned Group: </label><select name='group' size='1'>
END;

			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$groups=mysql_query("SELECT Name FROM groups WHERE Pr_banned='Yes'") or die ('AnnouncementX Error: ' . mysql_error());
			$gr_num=mysql_num_rows($groups);
			
			$i=0;
			while ($i<$gr_num) {
			
				$name=mysql_result($groups,$i,'Name');
				echo "<option value=$name>$name</option>";
				$i++;
		
			}
		
			mysql_close($link);
			
echo <<<END

				</select>
				<br /><br />
				<input type=submit name=submit value="Ban Username" class=submit>
				</td>
			</tr>
			<tr>
				<td align=center class=table_bottom>
				</td>
			</tr>
		</form>
		</table>
		
		<br /><br />
		
		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='unban_user' action='admin_main.php?code=unban_user&'.strip_tags(sid) method='post' onsubmit="">
			<tr>
				<td align=center class=header>
				Unban a User
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				Please, enter the username of user that should be unbanned:<br /><br />
				<input type=text name='username' value='' size=30 class=field><br /><br />
				<label for='group'>Unbanned Group: </label><select name='group' size='1'>
		
END;

			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$groups=mysql_query("SELECT Name FROM groups WHERE Pr_banned='No'") or die ('AnnouncementX Error: ' . mysql_error());
			$gr_num=mysql_num_rows($groups);
			
			$i=0;
			while ($i<$gr_num) {
			
				$name=mysql_result($groups,$i,'Name');
				echo "<option value=$name>$name</option>";
				$i++;
		
			}
		
			mysql_close($link);
			
echo <<<END
		
				</select>
				<br /><br />
				<input type=submit name=submit value="Unban Username" class=submit>
				</td>
			</tr>
			<tr>
				<td align=center class=table_bottom>
				</td>
			</tr>
		</form>
		</table>


END;
	
	}
		
	function ban_finish($username,$password) {
	
	global $username, $password;
	
	$user=$_POST['username'];
	$group=$_POST['group'];
	
		if (isset($user)) {
			
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$check=mysql_query("SELECT Name FROM members WHERE `Name`='$user'") or die ('AnnouncementX Error: ' . mysql_error());
			$num=mysql_num_rows($check);
			switch ($num) {
			
			case "0":
			
				mysql_close($link);
		
				echo "There is no such username as <b>$user</b> in our database, please check it.<br /><a href='javascript:history.back()'>Go Back</a>";
		
			break;
				
			default:
		
				$ban_qr="UPDATE members SET `Group`='$group' WHERE `Name`='$user'";
				$ban=mysql_query($ban_qr) or die ('AnnouncementX Error: ' . mysql_error());
		
				mysql_close($link);
					
					echo "<a href=admin_main.php?code=ban_user>Click here to continue</a>";
					
			break;
				
			}
		
		}
	
	}
	
	function unban_user($username,$password) {
	
		$user=$_POST['username'];
		$group=$_POST['group'];
		
		if (isset($user)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql=mysql_query("UPDATE members SET `Group`='$group' WHERE `Name`='$user'") or die ("AnnouncementX Error: " . mysql_error());
			
			mysql_close($link);
			
			echo "<a href='admin_main.php?code=ban_user'>Click here to continue</a>";
		
		} else {
		
			echo "<center>Please, enter the username that you want to unban<br /><a href='javascript:history.go(-1)' title='Continue'>Click here to continue</a></center>";
		
		}
	
	}
		
	function view_delete($username,$password) {
	
		echo "<script language='JavaScript'>
			<!--
			function Validate() {
			
				if (document.delete_user.username.value = '') {
				alert('Please, enter a username!');
				
				} else {
				
					if(confirm('Are you sure you want to delete this member?')) {
					
					var NewCode = document.delete_user.username.value;
					
					document.delete_user.submit.disabled = true;
					return true;
					window.location='admin_main.php?code=delete_user_end&name=NewCode';
										
					} else {
					
					alert('Process Stopped!');
					return false;
					
					}
					
				}
				
			}
			-->
			</script>";
	
echo <<<END

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='delete_user' action='admin_main.php?code=delete_user_end' method='post' onsubmit="">
			<tr>
				<td align=center class=header>
				Delete a User
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				Please, enter the username of user that should be deleted:<br /><br />
				<input type=text name='username' value='' size=30 class=field><br /><br />
				<input type=submit name=submit value="Delete Username" class=submit>
				</td>
			</tr>
			<tr>
				<td align=center class=table_bottom>
				</td>
			</tr>
		</form>
		</table>
		
END;

	}
		
	function delete_finish($username,$password) {
		
	$name=$_POST['username'];
	
	echo $name;
	
		if (isset($name)) {
	
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
			
			$selectid=mysql_query("SELECT `id` FROM `members` WHERE `Name`='$name'") or die ("AnnouncementX Error: " . mysql_error());
			
			$uid=mysql_result($selectid,0,'id');
			
			$notebook=mysql_query("DELETE FROM `notebook` WHERE `mid`='$uid'") or die ("AnnouncementX Error: " . mysql_error());
	
			$del=mysql_query("DELETE FROM members WHERE Name='$name'") or die ('AnnouncementX Error: ' . mysql_error());
			
			$check=mysql_query("SELECT * FROM members WHERE Name = '$name'") or die ("AnnouncementX Error: " . mysql_error());
			$sum=mysql_num_rows($check);
			
			if ($sum==0) {
			
				echo "$user has been deleted";
				
			} else {
			
				echo "account has not been deleted";
				
			}
	
			mysql_close($link);
		
				echo "<a href='admin_main.php?code=delete_user'>Click here to continue</a>";
				
		}
	
	}

}

class Modify {
			
	function view_modify($username,$password,$category) {
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
	
		$description=mysql_query("SELECT * FROM categories WHERE id='$category'") or die('AnnouncementX Error: ' . mysql_error());
		
		$name=mysql_result($description,0,'Name');
		$descr=mysql_result($description,0,'Description');
	
		mysql_close($link);
		
echo <<<END

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='modify' action='admin_main.php?code=modify_end' method='post'>
		<input type=hidden name=category value=$category>
				<tr>
				<td align=center class=header>
				Edit Category ($name)
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				<label for='name'>New Name: </label>
				<input type=text name=name value='$name' size=30 class=field><br /><br />
				Description:<br /><br />
				<textarea name=description class=field rows=14 cols=28>$descr</textarea><br /><br />
				<input type=submit name=submit value='Modify Category'><br />
				</td>
			</tr>
			<tr>
				<td align=center class=table_bottom>
				</td>
			</tr>
		</form>
		</table>
		
END;

	}
		
	function do_modify($username,$password) {
		
	$category=$_POST['category'];
	$name=$_POST['name'];
	$descr=$_POST['description'];
		
		if (isset($category,$name)) {
	
			$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
			mysql_select_db(DATA,$link);
	
			$update_qr="UPDATE categories SET `Name`='$name',`Description`='$descr' WHERE `id`='$category'";
			$update=mysql_query($update_qr) or die ('AnnouncementX Error: ' . mysql_error());
	
			mysql_close($link);	
	
				echo "<a href=admin_main.php?code=forums>Click here to continue</a>";
		
		} else {
		
			echo "Unknown Error: Category parametrs are not set";
			exit;
		
		}
	
	}

}

class Skin {

	function manage_skins($username,$password) {
	
		$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
		mysql_select_db(DATA,$link);
		
		$sql=mysql_query("SELECT * FROM skins");
		$num=mysql_num_rows($sql);
		
echo <<<END

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
			<tr>
				<td align='center' class=header colspan=4>
				Manage Skins (total: $num)
				</td>
			</tr>
			<tr>
				<td align=center class=table_row width=5%>
				#
				</td>
				<td align=center class=table_row width=30%>
				Name (click on name to edit)
				</td>
				<td align=center class=table_row width=35%>
				Path to images
				</td>
				<td align=center class=table_row width=30%>
				Path to the CSS file
				</td>
			</tr>
			
END;

		$n=1;
		
		for ($i=0;$i<$num;$i++) {
		
			$id=mysql_result($sql,$i,'id');
			$name=mysql_result($sql,$i,'Name');
			$path=mysql_result($sql,$i,'Path');
			$css=mysql_result($sql,$i,'Css');
						
			echo "<tr>
			<td align=center class=table_row width=5%>$n</td>
			<td align=center class=table_row width=30%><a href='admin_main.php?code=modify_skin&id=$id&".strip_tags(sid)."' title='Edit this skin'>$name</a></td>
			<td align=center class=table_row width=35%>$path</td>
			<td align=center class=table_row width=30%>$css</td>
			</tr>";
			
			$n=$n+1;
		
		}
		
echo <<<END

			<tr>
				<td align=center class=table_bottom colspan=4>
				</td>
			</tr>
		</table>
		
		<br /><br />
		
		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
			<tr>
				<td align=center class=header>
				Used skin
				</td>
			</tr>

END;
		
		$sql_2=mysql_query("SELECT * FROM config WHERE `Name`='Used_skin'") or die ("AnnouncementX Error: " . mysql_error());
		$result=mysql_fetch_row($sql_2);
		
echo <<<END

			<tr>
				<td align=center class=table_row>
				Currently used skin: $result[1]
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				<form name='skin' action='admin_main.php?code=change_skin&' method='post'>
				Choose another skin: 
				<select name="skin" accesskey="S" size="1">

END;
				for ($i=0;$i<$num;$i++) {
				
					$name=mysql_result($sql,$i,'Name');
					$value=mysql_result($sql,$i,'id');
					
					echo "<option value='$value'>$name</option>";
				
				}
				
echo <<<END

			</select><br /><br />
			<input type=submit name=submit value='Change skin (Alt+C)' accesskey='C' class=submit>
			</form>
			</td>
		</tr>
		<tr>
			<td align=center class=table_bottom>
			</td>
		</tr>
	</table>

END;
					
		mysql_close($link);
	
	}
	
	function view_add_skin($username,$password) {
	
echo <<<END

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='add_skin' action='admin_main.php?code=add_skin_end&' method='post'>
			<tr>
				<td align='center' class=header colspan=2>
				Add a skin
				</td>
			</tr>
			<tr>
				<td align='center' class=table_row>
				Name:
				</td>
				<td align=center class=table_row>
				<input type=text name='name' value='' class=field>
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				Path to images:<br />(ex. "/default/")
				</td>
				<td align=center class=table_row>
				<input type=text name='images' value='' class=field>
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				Path to the CSS:<br />(ex. "/default.css")
				</td>
				<td align=center class=table_row>
				<input type=text name='css' value='' class=field>
				</td>
			</tr>
			<tr>
				<td align=center class=table_row colspan=2>
				<input type=submit name='submit' value='Add a skin (Alt+A)' accesskey="A" class=submit>
				</td>
			</tr>
			<tr>
				<td align=center class=table_bottom colspan=2>
				</td>
			</tr>
		</form>
		</table>

END;
	
	}
	
	function view_del_skin($username,$password) {
	
		$link=mysql_connect(HOST,USER,PASS) or die ('AnnouncementX Error: ' . mysql_error());
		mysql_select_db(DATA,$link);
		
		$sql=mysql_query("SELECT * FROM skins") or die ("AnnouncementX Error: " . mysql_error());
		
		$num=mysql_num_rows($sql);
		
echo <<<END

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
		<form name='delete_skin' action='admin_main.php?code=del_skin_end&' method='post'>
			<tr>
				<td align=center class=header>
				Delete a skin
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				Please, choose what skin should be deleted:
				<br /><br />
				<select name='skin' size='1' accesskey="S">

END;

		for ($i=0;$i<$num;$i++) {
		
			$name=mysql_result($sql,$i,'Name');
			$value=mysql_result($sql,$i,'id');
			
			echo "<option value='$value'>$name</option>";
		
		}
		
echo <<<END

				</select>
				<br /><br />
				<input type=submit name='submit' value='Delete a skin (Alt+D)' accesskey='D'>
				</td>
			</tr>
			<tr>
				<td align=center class=table_bottom>
				</td>
			</tr>
		</form>
		</table>

END;

	mysql_close($link);
	
	}
	
	function view_mod_skin($username,$password,$id) {
	
		if (isset($id)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql=mysql_query("SELECT * FROM skins WHERE `id`='$id'") or die ("AnnouncementX Error: " . mysql_error());
			$num=mysql_num_rows($sql);
			
			if ($num>1) {
			
				echo "Unknown error: there are more than 1 skin with such id";
				exit;
			
			}
			
			$result=mysql_fetch_row($sql);
			
			mysql_close($link);
			
echo <<<END

			<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
			<form name='modify_skin' action='admin_main.php?code=mod_skin_end&' method='post'>
			<input type=hidden name='id' value='$id'>
				<tr>
					<td align=center class=header colspan=2>
					Edit a skin
					</td>
				</tr>
				<tr>
					<td align=center class=table_row>
					Skin name:
					</td>
					<td align=center class=table_row>
					<input type=text name='name' value='$result[1]' class=field>
					</td>
				</tr>
				<tr>
					<td align=center class=table_row>
					Path to images:
					</td>
					<td align=center class=table_row>
					./Skin<input type=text name='path' value='$result[2]' class=field>
					</td>
				</tr>
				<tr>
					<td align=center class=table_row>
					Path to the CSS file:
					</td>
					<td align=center class=table_row>
					./Cache<input type=text name='css' value='$result[3]' class=field>
					</td>
				</tr>
				<tr>
					<td align=center class=table_row colspan=2>
					<input type=submit name=submit value='Modify a skin (Alt+M)' class=submit accesskey='M'>
					</td>
				</tr>
				<tr>
					<td align=center class=table_bottom colspan=2>
					</td>
				</tr>
			</form>
			</table>

END;
		
		} else {
		
			echo "Unknown error: skin id is not set";
		
		}
	
	}
	
	function change_skin($username,$password) {
	
	$id=$_POST['skin'];
	
		if (isset($id)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql[0]=mysql_query("SELECT `Name` FROM skins WHERE `id`='$id'") or die ("AnnouncementX Error: " . mysql_error());
			$result=mysql_fetch_row($sql[0]);
			
			$sql[1]=mysql_query("UPDATE config SET `Value`='$result[0]' WHERE `Name`='Used_Skin'") or die ("AnnouncementX Error: " . mysql_error());
			
			echo "<a href='admin_main.php?code=manage_skins&' title='Continue'>Click here to continue</a>";
			
			mysql_close($link);
		
		} else {
		
			echo "Unknown Error: id is not defined";
		
		}
	
	}
	
	function add_skin_end($username,$password) {
	
		$name=$_POST['name'];
		$path=$_POST['images'];
		$css=$_POST['css'];
		
		if (isset($name,$path,$css)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql=mysql_query("INSERT INTO skins VALUES ('','$name','$path','$css')") or die ("AnnouncementX Error: " . mysql_error());
			
			echo "Skin <b>$name</b> has been succesfully added<br /><a href='admin_main.php?code=manage_skins&' title='Continue'>Click here to continue</a>";
			
			mysql_close($link);
		
		} else {
		
			echo "Please, fill in <b>all</b> fields<br /><a href='javascript=history.back()'>Click here to continue</a>";
			
		}
	
	}
	
	function del_skin_end($username,$password) {
	
		$skin=$_POST['skin'];
		
		if (isset($skin)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql[0]=mysql_query("SELECT * FROM skins") or die ("AnnouncementX Error: " . mysql_error());
			$num=mysql_num_rows($sql[0]);
			
			$sql[1]=mysql_query("SELECT Value FROM config WHERE `Name`='Used_Skin'") or die ("AnnouncementX Error: " . mysql_error());
			$result=mysql_fetch_row($sql[1]);
			
			$sql[2]=mysql_query("SELECT `Name` FROM skins WHERE `id`='$skin'") or die ("AnnouncementX Error: " . mysql_error());
			$name=mysql_result($sql[2],0,'Name');
			
			if ($result[0]==$name) {
			
				echo "You cannot delete the used skin!<br /><a href='javascript:history.back()'>Click here to contine</a>";
				exit;
			
			}
			
			if ($num==1) {
			
				echo "There is only 1 skin, you cannot delete it till you add more<br /><a href='javascript:history.back()'>Click here to continue</a>";
				exit;
				
			}
			
			$sql[3]=mysql_query("DELETE FROM skins WHERE `id`='$skin'") or die ("AnnouncementX Error: " . mysql_error());
			
			echo "Skin <b>$name</b> has been succesfully deleted<br /><a href='admin_main.php?code=manage_skins&'>Click here to continue</a>";
		
			mysql_close($link);
		
		} else {
		
			echo "Unknown error: id is not defined";
		
		}
	
	}
	
	function mod_skin_end($username,$password) {
	
		$id=$_POST['id'];
		$name=$_POST['name'];
		$path=$_POST['path'];
		$css=$_POST['css'];
		
		if (isset($id,$name,$path,$css)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql=mysql_query("UPDATE skins SET `Name`='$name',`Path`='$path',`Css`='$css' WHERE `id`='$id'") or die ("AnnouncementX Error: " . mysql_error());
			
			mysql_close($link);
			
			echo "Skin <b>$name</b> has been succesfully updated<br /><a href='admin_main.php?code=manage_skins&' title='Continue'>Click here to continue</a>";
		
		} else {
		
			echo "Please, fill in all the fields!<br /><a href='javascrip:history.back()'>Click here to continue</a>";
		
		}
	
	}
	
	function manage_css($username,$password) {
	
		$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
		mysql_select_db(DATA,$link);
		
		$sql=mysql_query("SELECT * FROM `skins`");
		
		$num=mysql_num_rows($sql);
		
		mysql_close($link);
		
		echo "<script language='JavaScript'>
		<!--
		
			function Validate() {
			
				if (document.css.submit.disabled) {
				
					document.css.submit.disabled = false;
					document.css.submit.value='Edit CSS file';
					return false;
				
				}
			
			}
		
		-->
		</script>";
		
echo <<<END

			<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
				<tr>
					<td align=center class=header>
					Choose Skin Name:
					</td>
				</tr>
				<tr>
					<td align=center class=table_row>
						<form name='css' action='admin_main.php?code=manage_css_file' method='post'>
						<input type=hidden name=security value=1>
							<table align=center width=80% class=inlinetable>
								<tr>
									<td align=center class=inlineheader>
									Name:
									</td>
									<td align=center class=inlineheader>
									Choice:
									</td>
								</tr>
								
END;

								for ($i=0;$i<$num;$i++) {
								
									$id=mysql_result($sql,$i,'id');
									$name=mysql_result($sql,$i,'Name');
									
									echo "<tr>
										<td align=center class=inlinerow>$name</td>
										<td align=center class=inlinerow>
										<input type=radio name='skinid' value='$id' onFocus='Validate()'>
										</td>
									</tr>";
								
								}

echo <<<END
								<tr>
									<td align=center colspan=2 class=inlinerow>
										<input type=submit name=submit value='Please, choose skin name...' class=submit disabled>
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
				<tr>
					<td class=table_bottom>
					</td>
				</tr>
			</table>

END;
	
	}
	
	function manage_css_file($username,$password) {
	
		$security=$_POST['security'];
		
		if (isset($security)) {
		
			$id=$_POST['skinid'];
			
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
			
			$sql=mysql_query("SELECT * FROM `skins` WHERE `id`='$id'") or die ("AnnouncementX Error: " . mysql_error());
			
			$row=mysql_fetch_row($sql);
			
			mysql_close($link);
			
			$path=$row[3];
			
			if (isset($path)) {
			
				$fullpath="../Cache".$path;
				$contents=file_get_contents($fullpath);
				
				if (!is_writable($fullpath)) {
				
					$note="<br /><strong>Important:</strong> please, chmod <em>".$fullpath."</em> to <em>0777</em> before clicking 'Finish editing' button<br />";
				
				}
				
echo <<<END
				<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
					<tr>
						<td align=center class=header>
						Editing CSS File ($fullpath)
						</td>
					</tr>
					<tr>
						<td align=center class=table_row>
						$note
						CSS Document:<br /><br />
						<form name='css' action='admin_main.php?code=manage_css_finish' method='post'>
						<input type=hidden name=security value=1>
						<input type=hidden name='path' value='$fulldir'>
						<textarea name='contents' rows=14 cols=72 class=textarea>$contents</textarea><br /><br />
						<input type=submit name=submit value='Finish editing' class=submit>
						</form>
						</td>
					</tr>
					<tr>
						<td class=table_bottom>
						</td>
					</tr>
				</table>
END;
			
			}
		
		}
			
	}
	
	function manage_css_finish($username,$password) {
	
		$security=$_POST['security'];
		
		if (isset($security)) {
		
			$contents=$_POST['contents'];
			$path=$_POST['path'];
			
			if (!is_writable($path)) {
			
				echo "<strong>Critical Error!</strong> Cannot write to the file, please chmod it to 0777\n<a href='javascript:history.go(-1)' title='Back'>Go Back</a>";
				exit;
			
			}
			
			file_put_contents($fullpath,$contents);
			
			echo "Css file <strong>$fulldir</strong> has been succesfully changed!\n<a href='admin_main.php?code=manage_css&' title='Continue'>Click here to continue</a>";
		
		}
	
	}

}

class Database {

	function db_optimise() {
	
	$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
	
	$tables=mysql_list_tables(DATA,$link);
	$rows=mysql_num_rows($tables);
	
	mysql_close($link);
	
	echo "<script language='JavaScript'>
	<!--
	
		function Validate() {
		
			if (confirm('This process may take some minutes, are you sure you want to proceed?')) {
			
				document.optimize.submit.value='Optimising database...';
				document.optimize.submit.disabled = true;
				return true;
			
			} else {
			
				alert ('Operation has been stopped!');
				return;
			
			}
					
		}
	
		function Check() {
			
			if (document.optimize.tables[].checked = false) {
				
				document.optimize.tables[].checked;
				return true;
				
			} else {
				
				document.optimize.tables[].checked = false;
				return false;
				
			}
			
		}
	
	-->
	</script>
	";
	
echo <<<END

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
			<tr>
				<td align=center class=header>
					Optimize database
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
					<form name='optimize' action='./admin_main.php?code=db_opt_finish&'.strip_tags(sid) method='post' onSubmit='Validate()'>
					<input type=hidden name=security value=1>
					Are you sure want to proceed?<br />
					<strong>Note: </strong>only selected below tables will be optimized!<br /><br />
					<table class=inlinetable align=center width=30%>
						<tr>
							<td align=cetner class=inlineheader>
							</td>
							<td align=center class=inlineheader>
							Name:
							</td>
						</tr>
END;
			
					for ($i=0;$i<$rows;$i++) {
					
						$name=mysql_tablename($tables,$i);
						
						echo "<tr>
						<td align=center class=inlinerow><input type=checkbox name='tables[]' value='$name'></td><td align=center class=inlinerow>&nbsp;$name</td>
						</tr>";
					
					}
					
		echo "
					<tr>
					<td align=center class=inlinerow colspan=2>
					<input type=submit name=submit value='Yes' class=submit>&nbsp;&nbsp;&nbsp;
					<input type=button name=reject value='No' class=submit onClick='javascript:window.location=./admin_main.php?code=&'><br />
					</td>
					</tr>
					</table>
					</form>
				</td>
			</tr>
			<tr>
				<td class=table_bottom>
				</td>
			</tr>
		</table>";
	
	}
	
	function do_optimise() {
	
		$security=$_POST['security'];
		
		if (isset($security)) {
		
			$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
			mysql_select_db(DATA,$link);
						
			$tables = $_POST['tables'];
			
			$number=count($tables);
			
			foreach ($tables as $value) {		
			
				$sql = 'OPTIMIZE TABLE `$value`';
				
				if (!$sql) {
				
					echo "AnnouncementX Database Optimisation Error: " . mysql_error();
				
				}
			
			}
						
			mysql_close($link);
			
echo <<<END

			<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
				<tr>
					<td align=center class=header>
						Optimisation completed
					</td>
				</tr>
				<tr>
					<td align=center class=table_row>
					You have succesfully optimised <b>$number</b> table(s)!<br />
					<a href='./admin_main.php?code=db_optimize' title='Continue'>Click here to continue</a>					
					</td>
				</tr>
				<tr>
					<td class=table_bottom>
					</td>
				</tr>
			</table>
END;
		
		} else {
		
echo <<<END

			<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
				<tr>
					<td align=center class=header>
						Optimise database
					</td>
				</tr>
				<tr>
					<td align=center class=table_row>
					Sorry, your requiest cannot be confirmed.<br />
					<a href='./admin_main.php?code=db_optimize' title='Continue'>Click here to continue</a>					
					</td>
				</tr>
				<tr>
					<td class=table_bottom>
					</td>
				</tr>
			</table>
			
END;
		
		}
	
	}
	
	function db_backup() {
	
		echo "<script language='JavaScript'>
		<!--
		
			function Validate() {
			
				if (confirm('This process may take some minutes, are you sure you want to proceed?')) {
				
					document.backups.submit.value='Backuping Database...';
					document.backups.submit.disabled = true;
					return true;
				
				} else {
				
					alert ('Operation has been stopped!');
					return;
				
				}
			
			}
			
		-->
		</script>
		";
		
		$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
		
		$tables=mysql_list_tables(DATA,$link);
		$num=mysql_num_rows($tables);
	
echo <<<END

				<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
					<tr>
						<td align=center class=header>
							Optimise database
						</td>
					</tr>
					<tr>
						<td align=center class=table_row>
						<form name='backups' action='admin_main.php?code=db_backup_finish&' method='post' onSubmit='Validate()'>
						Please, choose what tables would you like to backup:<br />
						<strong>Note: </strong>before the backup session you must chmod the directory named 'Backups' to 0777!<br /><br />
						<table class=inlinetable align=center width=30%>
						<tr>
							<td align=cetner class=inlineheader>
							</td>
							<td align=center class=inlineheader>
							Name:
							</td>
						</tr>

END;

		for ($i=0;$i<$num;$i++) {
		
			$name=mysql_tablename($tables,$i);
			
			echo "<tr><td align=center class=inlinerow><input type=checkbox name='tables[]' value='$name'></td>
			<td align=center class=inlinerow>$name</td>";
		
		}
		
echo <<<END

						<tr>
							<td align=center class=inlinerow colspan=2>
							<input type=submit name=submit value='Start backup operation' class=submit>
							</td>
						</tr>
						</table>
						</form>
						</td>
					</tr>
					<tr>
						<td class=table_bottom>
						</td>
					</tr>
				</table>

END;
	
		mysql_close($link);
	
	}
	
	function do_backup() {
					
		$tables = $_POST['tables'];
				
		$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
		mysql_select_db(DATA,$link);
		
		$date=date("m_d_Y");
		
		$filename="../Backup/ax_backup_".$date.".sql";
		
		$count=count($tables);
				
		foreach ($tables as $value) {
		
			$fp=fopen($filename,'a');
					
			$write="\$sql[]='DROP TABLE `$value` IF EXISTS';\n\$sql[]='TRUNCATE TABLE `$value`';\n";
		
			$sql=mysql_query("SELECT * FROM `$value`") or die ("AnnouncementX Error: " . mysql_error());
			
			$fields=mysql_num_fields($sql);
			
			while ($row=mysql_fetch_row($sql)) {
			
				switch ($fields) {
				
					case "2":
					
						$query="\$sql[]='INSERT INTO `$value` VALUES ('$row[0]','$row[1]')';\n";
						
					break;
					
					case "3":
					
						$query="\$sql[]='INSERT INTO `$value` VALUES ('$row[0]','$row[1]','$row[2]')';\n";
					
					break;
					
					case "4":
					
						$query="\$sql[]='INSERT INTO `$value` VALUES ('$row[0]','$row[1]','$row[2]','$row[3]')';\n";
					
					break;
					
					case "5":
					
						$query="\$sql[]='INSERT INTO `$value` VALUES ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]')';\n";
					
					break;
					
					case "6":
					
						$query="\$sql[]='INSERT INTO `$values` VALUES ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]')';\n";
					
					break;
					
					case "7":
					
						$query="\$sql[]='INSERT INTO `$values` VALUES ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]')';\n";
					
					break;
					
					case "8":
					
						$query="\$sql[]='INSERT INTO `$values` VALUES ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]')';\n";
					
					break;
					
					case "9":
					
						$query="\$sql[]='INSERT INTO `$values` VALUES ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]')';\n";

					break;
					
					case "10":

						$query="\$sql[]='INSERT INTO `$values` VALUES ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]')';\n";

					break;
					
					case "11":

						$query="\$sql[]='INSERT INTO `$values` VALUES ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]','$row[10]')';\n";

					break;
					
					case "12":

						$query="\$sql[]='INSERT INTO `$values` VALUES ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]','$row[10]','$row[11]')';\n";

					break;
				
				}
				
				$write=$write.$query;
													
			}
			
			$additional="\n\n/*END OF TABLE $value*/\n\n";
			
			$write=$write.$additional;
			
			fwrite($fp,$write);
		
			fclose($fp);
					
		}
				
		$endfilename=$filename.".gz";
		
		$contents=file_get_contents($filename);
		
		if (!isset($contents)) {
		
			echo "<b>Critical Error!</b> Cannot get data from the temporary file. Operation has been terminated!\n";
		
		}
		
		$gz=gzopen($endfilename,"w9");
		
		gzwrite($gz,$contents);
		
		gzclose($gz);
		
		unlink($filename);
		
		/*if (!$unlink) {
		
			echo "<strong>Note!</strong> The <strong>.sql</strong> file has not been deleted from 'Backup' directory!\n\n";
			
			@ $chmod=chmod($filename,0666);
			
			if (!$chmod) {
			
				echo "<strong>Alert: </strong>system cannot chmod the <strong>.sql</strong> file to <strong>0666</strong>!\nPlease, remove the file!";
			
			}
		
		}*/
		
echo <<<END

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
			<tr>
				<td align=center class=header>
				Backup operation finished
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
				<br />
				Backup operation has been finished succesfully!<br />
				You have backuped <strong>$count</strong> tables!<br />
				<strong>Important! </strong>The file has been Gzipped!<br />
				You can browse 'Backups' directory by clicking on this link: <a href='../Backup/' title='Browse backups directory'>Backups directory</a><br /><br />
				<a href='./admin_main.php?code=db_backup' title='Continue'>Click here to continue</a>
				</td>
			</tr>
			<tr>
				<td align=center class=table_bottom>
				</td>
			</tr>
		</table>
		
END;
		
		mysql_close($link);
	
	}
	
	function db_restore() {
	
echo <<<END

		<table width=70% align=center border=1 bordercolor=black style='border-collapse: collapse' cellpadding=3>
			<tr>
				<td align=center class=header>
				Database Recovery Tool
				</td>
			</tr>
			<tr>
				<td align=center class=table_row>
					<form name='recover' enctype='multipart/form-data' action='./admin_main.php?code=db_restore_finish&' method='post'>
						<input type=hidden name=security value=1>
						Please, upload a gzipped backup file generated by <strong>AnnouncementX</strong> backup utility:<br /><br />
						File name: <input type="file" name="userfile"><br /><br />
						<input type=submit name=submit class=submit value='Start Restore Operation'>						
					</form>
				</td>
			</tr>
			<tr>
				<td align=center class=table_bottom>
				</td>
			</tr>
		</table>


END;
	
	}
	
	function do_restore() {
	
	$directory="../Backup/Recovery";
	$fulldir=$directory . basename($_FILES['userfile']['name']);
	
		if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
		
			echo "File ".$_FILES['userfile']['name']." uploaded succesfully!";
			
			if (move_uploaded_file($_FILES['userfile']['tmp_name'],$fulldir)) {
			
				echo "\nFile is valid and the restore process has begun!";
				
				$zp=gzopen($fulldir,'r');
				
				$contents="<?\n\n";
				$contents=$contents.gzread($zp,filesize($fulldir));
				$contents=$contents."\n\n?>";				
				
				if (isset($contents)) {
				
					$file="../Backup/Recovery/axtempfile.php";
					
					$fp=fopen($file,'w');
					
					fwrite($fp,$contents);
					
					fclose($fp);
				
				} else {
				
					echo "\n<strong>Critical Error: </strong>cannot read the file! Operation has been terminated!";
					exit;
				
				}
								
				gzclose($zp);
				
												
				$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
				mysql_select_db(DATA,$link);
							
				$sql = array();
				
				include ($file);
				
				$count=0;
				
				foreach ($sql as $q) {
				
					$query=mysql_query($q) or die ("AnnouncementX Error: " . mysql_error());
					$count++;
				
				}
				
				unlink($file);
				
				/*if (!$unlink) {
				
					echo "Could not delete the temporary file titled $tmpfile from the <strong>/tmp</strong> directory!";
				
				}*/
				
				echo "\nRestore process has been completed! You have executed <strong>$count</strong> queries from the uploaded file.
				\n<a href='./admin_main.php?code=db_restore&' title='Continue'>Click here to continue</a>"; 
				
				unlink ($fulldir);
				
				mysql_close($link);
			
			} else {
			
				echo "File is not valid, cannot start the restore process!";
				exit;
			
			}
		
		}
	
	}

}

?>