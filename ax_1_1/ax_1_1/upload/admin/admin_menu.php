<?
//+----------------------------------
//	AnnoucementX Board Script
//	Version: 1.0
//	Author: Cat
//	Created: 2004/10/22
//	Updated: 2005/10/12
//	Description: Configures Admin CP
// 	menu
//+----------------------------------

$username = $_GET['username'];
$password = $_GET['password'];

global $username, $password;

if (isset($username,$password)) {
echo <<<END
<html>
<head>
<title>AnnouncementX Admin CP</title>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<link href='admin_cp_css.css' rel='stylesheet' type='text/css'>
</head>

<body>

<center>
<h3>AnnouncementX<br />
Admin CP</h3><br /><br />
<table width=170 align=center border=1 bordercolor='black' style='border-collapse: collapse' cellpadding=3>
	<tr>
		<td class=header align=center>
		General options
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=' target='main' title='Home'>AdminCP Home</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=forums' target='main' title='Manage categories'>Manage categoires</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=general' target='main' title='General Settings'>General Settings</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=security' target='main' title='Security/Registration'>Security/Registration</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=advanced' target='main' title='Advanced Settings'>Advanced Settings</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=badwords' target='main' title='Bad Words'>Bad Words Management</a>
		</td>
	</tr>
	<tr>
		<td class=menu_bottom>
		</td>
	</tr>
</table>
<br /><br />
<table width=170 align=center border=1 bordercolor='black' style='border-collapse: collapse' cellpadding=3>
	<tr>
		<td class=header align=center>
		User Settings
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=adduser' target='main' title='Add a Member'>Add a member</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=edit_user' target='main' title='Edit a Member'>Edit a member</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=delete_user' target='main' title='Delete a Member'>Delete a member</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=ban_user' target='main' title='Ban/Unban a Member'>Ban/Unban a member</a>
		</td>
	</tr>
	<tr>
		<td class=menu_bottom>
		</td>
	</tr>
</table>
<br /><br />
<table width=170 align=center border=1 bordercolor='black' style='border-collapse: collapse' cellpadding=3>
	<tr>
		<td class=header align=center>
		Group Settings
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=groups' target='main' title='Manage groups'>Manage groups</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=add_group' target='main' title='Add a group'>Add a group</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=delete_group' target='main' title='Delete a group'>Delete a group</a>
	</tr>
	<tr>
		<td class=menu_bottom>
		</td>
	</tr>
</table>
<br /><br />
<table width=170 align=center border=1 bordercolor='black' style='border-collapse: collapse' cellpadding=3>
	<tr>
		<td class=header align=center>
		Skin options
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=add_skin' target='main' title='Add a skin'>Add a skin</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=delete_skin' target='main' title='Delete a skin'>Delete a skin</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=manage_skins' target='main' title='Manage Skins'>Manage Skins</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=manage_css' target='main' title='Edit CSS'>Edit CSS file(s)</a>
		</td>
	</tr>
	<tr>
		<td class=menu_bottom>
		</td>
	</tr>
</table>
<br /><br />
<table width=170 align=center border=1 bordercolor='black' style='border-collapse: collapse' cellpadding=3>
	<tr>
		<td class=header align=center>
		Database Management
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=db_optimize' target='main' title='Optimize tables'>Optimize tables</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=db_backup' target='main' title='Backup database'>Backup database</a>
		</td>
	</tr>
	<tr>
		<td align=center class=menu_row>
		<a href='admin_main.php?code=db_restore' target='main' title='Restore database'>Restore database</a>
		</td>
	</tr>
	<tr>
		<td class=menu_bottom>
		</td>
	</tr>
</table>
<br /><br />
&copy; 2005 AnnouncementX.
<br />All rights reserved.
</center>
</body>
</html>
END;
} else {
echo "<a href='index.php' target=_top>You are not logged in!<br />Click here to continue</a>";
}
?>