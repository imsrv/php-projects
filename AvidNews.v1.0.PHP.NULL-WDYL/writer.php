<?php

/*------------------------------------\
| AvidNews Version 1.00               |
| News/article management system      |
+-------------------------------------+
| ADMIN.PHP :: The admin control centr|
+-------------------------------------+
| (C) Copyright 2003 Avid New Media   |
| Consult README for further details  |
+------------------------------------*/

# Include configuration script

include './config.php';
include './functions.php';
$sitename = $CONF['sitename'];

define("SITENAME", $sitename);
define("USERNAME", $user);
# Connect to MySQL database

mysql_connect($CONF['dbhost'], $CONF['dbuser'], $CONF['dbpass']);
mysql_select_db($CONF['dbname']);

# Get our variables into a better format

$_SUBMIT = array_merge( $HTTP_GET_VARS, $HTTP_POST_VARS );
extract( $_SUBMIT, EXTR_OVERWRITE );

# Login action

if($action == "login")
{
	if($submit == 1)
	{
		$password = crypt($password, "DD");
		
		$result = mysql_query("SELECT username, password, status FROM `$CONF[table_prefix]admins`
				     WHERE username = '$username' AND
					 password = '$password'");
				 
			if(mysql_num_rows($result) == 0)
		{
			$login_error = 1;
		}
		else
		{
			setcookie("admindata[0]", $username);
			setcookie("admindata[1]", $password);
		}
			while($info = mysql_fetch_array($result))
			{
			if($info['status'] == "admin")
			{
				header("Location: admin.php");
			}
						
			if($info['status'] == "writer")
			{
				header("Location: writer.php?user=$username");
	}

			exit();
			
		}
		
	}
	include './adminheaderout.inc';
		
	echo("<img src=\"images\lock.gif\" border=\"0\" align=\"absmiddle\"> <FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Login</FONT></FONT><br>
		Please enter your username and password to login:<br><br><P><P><P><P>");
		
	if($login_error == 1) { echo("<span class=error><b>Error:</b> Invalid Username/Password combination.</span>"); }
	
	echo("<form action='writer.php?action=login' method=post>
		<input type=hidden name=submit value=1>
		<table cellpadding=0 cellspacing=0
		 <tr>
		  <td><b>Username:</b> </td><td>&nbsp;&nbsp;<input type=text name=username size=20></td>
		 </tr>
	          <tr>
	  	  <td><b>Password:</b> </td><td>&nbsp;&nbsp;<input type=password name=password size=20></td>
	          </tr>
	         </table>
		<br><input type=submit value='Login'> <input type=reset></form>");
	
	include './adminfooter.inc';
	
	exit();
	
}
# Auth the administrator

auth_admin();

# Logout action

if($action == "logout")
{
			$username = "";
	        $password = "";
        
			setcookie("admindata[0]", $username, time() - 99999999999);
			setcookie("admindata[1]", $password, time() - 99999999999);
			
			header("Location: admin.php?action=login");
		
			
			
		}
	

# Auth the administrator

auth_admin();

# News management actions

if($action == "delete") {
	
	$result = mysql_query("DELETE FROM `$CONF[table_prefix]news`
			     WHERE id = '$id'");
	
	header("Location: writer.php?action=news&user=$user");
	
	exit();
	
}

if($action == "news")
{
	
	if($add == 1)
	{
		$errors = array();
		
		//-------------------------
		
		$req = array("headline", "blurb", "article", "added_by");
		
		foreach($req as $field)
		{
			if(empty($_SUBMIT[$field]))
			{
				$error = 1;
			}
		}
		
		if($error == 1)
		{
			$errors[] = "You have not filled in all required fields.";
		}
		
		//-------------------------
		
		if($image_name != "")
		{
			if(!move_uploaded_file($image, $CONF["image_upload_dir"].$image_name))
			{
				$errors[] = "Could not upload the image you selected.";
				$error = 1;
			}
		}
		
		//--------------------------
		
		if($error != 1)
		{
			$result = mysql_query("INSERT INTO `$CONF[table_prefix]news`
					     VALUES ('',
						    '".addslashes($_SUBMIT['category'])."',
					     	'".addslashes($_SUBMIT['headline'])."',
						    '".addslashes($_SUBMIT['blurb'])."',
						    '".addslashes($_SUBMIT['article'])."',
						    '".time()."',
						    '".$_SUBMIT['added_by']."',
						    '$image_name',
						    '$live')");
		}
		
	}		

	include './writerheader.inc';
	define("USERNAME", $user);
	echo("<script language=javascript>
		function deleteNews(id)
		{
			if(confirm(\"Are you sure you wish to delete this news item?\"))
			{
				location.href = \"writer.php?action=delete&id=\"+id;
			}
		}
		</script>");
	
	echo("<FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>News Management</font></font></font><br>");
	echo("Please select a news item to edit or add a new news item:<br><br><P><P><P><P>");
	
	echo("<table width=100% cellpadding=0 cellspacing=0 style=\"border: 1px solid #1E212A\">
		<Tr bgcolor=#1E212A height=20><td colspan=2><font color=white>&nbsp;&nbsp;<b>News Items</b></font></tr>");
 
	$news = mysql_query("SELECT * FROM `$CONF[table_prefix]news`
			   WHERE added_by = '$user' 
			   ORDER BY date_added DESC LIMIT 5");

	if(mysql_num_rows($news) == 0)
	{
		echo("<tr><td colspan=2>&nbsp;&nbsp;There are no news items on the system.</td></tr>");
	}
	
	while($row_info = mysql_fetch_array($news))
	{
		echo("<tr height=17><td><img src=\"images/arrowicon.gif\" border=\"0\" align=\"absmiddle\">&nbsp;&nbsp;$row_info[headline]</td><td>[ <a href='writer.php?action=editenews&id=$row_info[id]'>Edit</a> ]</tD></tr>");
	}
	echo("</table><br><b>Add a News Item</b><br>Please fill in this form to add a news item:<br><br>");
	
	if($error == 1)
	{
		foreach($errors as $error)
		{
			echo("<font color=#990000><b>Error:</b> $error</font><br>");
		}
		
		echo("<br>");
	}
				   
		echo("<form action='$PHP_SELF?action=news&user=$user' method=post enctype='multipart/form-data'>
		<input type=hidden name=add value=1>
		<input type=hidden name=user value=$user>
		<input type=hidden name=live value=no>
		<table cellpadding=0 cellspacing=0>
		<tr><td><b>Category:</b> </td><td><SELECT NAME=category SIZE=1><OPTION VALUE=>No Categories Listed");
		
		$cats = mysql_query("SELECT catid, catname FROM `$CONF[table_prefix]categories`
			   ORDER BY catid ASC
			   LIMIT 30");
			   while($row2_info = mysql_fetch_array($cats))
			   
		echo("<OPTION VALUE=$row2_info[catid]>$row2_info[catname]");
		echo("</SELECT></td></tr>");
		echo("<tr><td><b>Headline:</b> (*) </td><td><input type=text name=headline size=30></td></tr>
		 <tr><td><b>Blurb:</b> (*) </td><td><textarea name=blurb cols=30 rows=3></textarea></td></tr>
		 <tr><td valign=top><b>Article:</b> (*)</td><td><textarea name=article cols=30 rows=10></textarea></td></tr>
		 <tr><td><b>Added By:</b></td><td>$user<input type=hidden name=added_by size=30 value=$user></td></tr>
		 <tr><td><b>Image:</b></td><td><input type=file name=image></td></tr>
		</table><br><input type=submit value='Add News'> <input type=reset>
		</form>");
	include './writerfooter.inc';
	
	exit();
	
	
}

# Begin Edit News
if($action == "editenews")
{
	
	if($update == 1)
	{
		if($_FILES['image']['name'] != "")
		{
			move_uploaded_file($_FILES['image']['tmp_name'], $CONF["image_upload_dir"].$_FILES['image']['name']);
			
			$result = mysql_query("UPDATE `$CONF[table_prefix]news` SET image = '$_FILES[image][name]' WHERE id = '$id'");
		}
		
		$array = array("category", "headline", "blurb", "text", "added_by", "image", "live");
		
		foreach($array as $edititem)
		{
			$result = mysql_query("UPDATE `$CONF[table_prefix]news`
					     SET $edititem = '".addslashes($_SUBMIT[$edititem])."'
					     WHERE id = '$id'");
		}
		
		$updated=1;
	}
	
	include './writerheader.inc';
	define("USERNAME", $user);
	echo("<FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Editing News Article</font></font></font><br>Please make any article changes and click 'Save Changes':<br><br>");
	
	if($updated == 1)
	{
		echo("<font color=#006633><b>Success:</b> Your changes have been saved.</font><br><br>");
	}
			
	echo("<form action='$PHP_SELF?action=editenews&id=$id' method=post enctype='multipart/form-data'>
		<input type=hidden name=update value=1>
		<input type=hidden name=user value=$user>
		<input type=hidden name=live value=no>
		<table cellpadding=0 cellspacing=0>");
		
		$result = mysql_query("SELECT * FROM `$CONF[table_prefix]news`
		WHERE id = '$id'");
		$row11_info = mysql_fetch_array($result);
		
		echo("<tr><td><input type=hidden name=category value=\"$row11_info[category]\"></td></tr>
		<tr><td><b>Headline:</b> (*) </td><td><input type=text name=headline size=30 value=\"$row11_info[headline]\"></td></tr>
		 <tr><td><b>Blurb:</b> (*) </td><td><textarea name=blurb cols=30 rows=3>$row11_info[blurb]</textarea></td></tr>
		 <tr><td valign=top><b>Article:</b> (*)</td><td><textarea name=text cols=30 rows=10>$row11_info[text]</textarea></td></tr>
		 <tr><td><b>Added By:</b></td><td>$row11_info[added_by]<input type=hidden name=added_by size=30 value=\"$row11_info[added_by]\"></td></tr>
		 <tr><td><b>Image:</b></td><td><input type=file name=image value=\"$row11_info[image]\"></td></tr>
		</table><br><input type=submit value='Edit News'> <input type=reset>
		</form>");
		
	include './writerfooter.inc';
	
	exit();
	
}
# End Edit News

if($action == "templates")
{
	
	if($update == 1)
	{
		$array = array("html_header", "headline_header", "headline_footer", "headline_bit", "headline_separator", "article_header", "article_footer", "show_article");
		
		foreach($array as $item)
		{
			$result = mysql_query("UPDATE `$CONF[table_prefix]templates`
					     SET code = '".addslashes($_SUBMIT[$item])."'
					     WHERE name = '$item'");
		}
		
		$updated=1;
	}
	
	$result = mysql_query("SELECT * FROM `$CONF[table_prefix]templates`");
	
	while($row_info = mysql_fetch_array($result))
	{
		$TEMPLATE[$row_info['name']] = $row_info['code'];
	}

	include './writerheader.inc';
	define("USERNAME", $user);
	echo("<FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Template Management</font></font></font><br>Please make any template changes and click 'Save Changes':<br><br>");
	
	if($updated == 1)
	{
		echo("<font color=#006633><b>Success:</b> Your changes have been saved.</font><br><br>");
	}
	
	echo("<form action='$PHP_SELF?action=templates' method=post>
		<input type=hidden name=update value=1>");
	
	echo("<table cellpadding=0 cellspacing=0>
		<tr><td><b>Style Sheet:</b><br>Included before headline display</td><td><textarea rows=7 cols=50 name=html_header>$TEMPLATE[html_header]</textarea></td></tr>
		<tr><td><b>Headline Header:</b><br>Start of the headlines table</td><td><textarea rows=7 cols=50 name=headline_header>$TEMPLATE[headline_header]</textarea></td></tr>
		<tr><td><b>Headline Footer:</b><br>End of the headlines table</td><td><textarea rows=7 cols=50 name=headline_footer>$TEMPLATE[headline_footer]</textarea></td></tr>
		<tr><td><b>Headline Layout:</b><br>Each headline row</td><td><textarea rows=7 cols=50 name=headline_bit>$TEMPLATE[headline_bit]</textarea></td></tr>
		<tr><td><b>Headline Separator:</b><br>Displayed between each headline</td><td><textarea rows=7 cols=50 name=headline_separator>$TEMPLATE[headline_separator]</textarea></td></tr>
		<tr><td><b>Article Header:</b><br>Displayed before each article</td><td><textarea rows=7 cols=50 name=article_header>$TEMPLATE[article_header]</textarea></td></tr>
		<tr><td><b>Article Footer:</b><br>Displayed after each article</td><td><textarea rows=7 cols=50 name=article_footer>$TEMPLATE[article_footer]</textarea></td></tr>
		<tr><td><b>Show Article:</b><br>The main article display</td><td><textarea rows=7 cols=50 name=show_article>$TEMPLATE[show_article]</textarea></td></tr>
	      </table><br>
		<input type=submit value='Save Changes'> <input type=reset value='Revert to Saved'></form>");
	
	include './writerfooter.inc';
	
	exit();
	
}

if($action == "admins")
{
	
	if($cp == 1)
	{
		
		if($update == 1)
		{
			$errors = array();
		
			//-------------------------
			
			$req = array("old", "new");
			
			foreach($req as $field)
			{
				if(empty($_SUBMIT[$field]))
				{
					$error = 1;
				}
			}
			
			if($error == 1)
			{
				$errors[] = "You have not filled in all required fields.";
			}
			
			$result = mysql_query("SELECT * FROM `$CONF[table_prefix]admins`
					     WHERE id = '$id'
					     AND   password = '".crypt($old, "DD")."'");
			if(mysql_num_rows($result) == 0)
			{
				$error = 1;
				$errors[] = "Your current password is incorrect.";
			}
			
			//--------------------------
			
			if($error != 1)
			{
				$result = mysql_query("UPDATE `$CONF[table_prefix]admins`
						     SET password = '".crypt($new, "DD")."'
						     WHERE id = '$id'");
				$pass=1;
				
				header("Location: admin.php?action=admins&cp=1");
				
				exit();
			}
			
		}
		
		$result = mysql_query("SELECT * FROM `$CONF[table_prefix]admins`
				     WHERE id = '$id'");
		$row_info = mysql_fetch_array($result);
		
		include './writerheader.inc';
		define("USERNAME", $user);
		echo("<b>Change Password</b><br>Please fill in this form to change this user's password:<br><br>");
		
		if($error == 1)
		{
			foreach($errors as $error)
			{
				echo("<font color=#990000><b>Error:</b> $error</font><br>");
			}
			
			echo("<br>");
		}
		
		echo("<form action='$PHP_SELF' method=post>
			<input type=hidden name=cp value=1>
			<input type=hidden name=id value=$id>
			<input type=hidden name=update value=1>
			<input type=hidden name=action value=admins>");
	
		echo("<table cellpadding=0 cellspacing=0>
			<tr><Td><b>Old Password:</b> </td><td><input type=password name=old size=30></td></tr>
			<tr><Td><b>New Password:</b> </td><td><input type=password name=new size=30></td></tr>
		     </table><br>
			<input type=submit value='Save Password'></form>");
		
		include './writerfooter.inc';
		
		exit();
		
	}
	
	if($add == 1)
	{
		$errors = array();
		
		//-------------------------
		
		$req = array("username" ,"password" ,"status" ,"name" ,"email");
		
		foreach($req as $field)
		{
			if(empty($_SUBMIT[$field]))
			{
				$error = 1;
			}
		}
		
		if($error == 1)
		{
			$errors[] = "You have not filled in all required fields.";
		}
		
		//--------------------------
		
		$result = mysql_query("SELECT id FROM `$CONF[table_prefix]admins`
				     WHERE username = '$username'");
		
		if(mysql_num_rows($result) != 0)
		{
			$error = 1;
			$errors[] = "The username you entered is already in use.";
		}
				
		//--------------------------
		
		if($error != 1)
		{
			$result = mysql_query("INSERT INTO `$CONF[table_prefix]admins`
					     VALUES ('','$username',
					     '".crypt($password, "DD")."', '$status')");
		}
		
	}
	
	if(isset($d))
	{
		$result = mysql_query("DELETE FROM `$CONF[table_prefix]admins`
			     	     WHERE id = '$d'");
	
		header("Location: admin.php?action=admins");
	
		exit();	
	}
	
	include './writerheader.inc';
	define("USERNAME", $user);
	echo("<img src=\"images/adminicon.gif\" border=\"0\" align=\"absmiddle\"> <FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Admin Management</font></font></font><br>From here you can control the admins using the system:<br><br>");
	
	if($pass == 1)
	{
		echo("<font color=#006633><b>Success:</b> Your changes have been saved.</font><br><br>");
	}
	
	echo("<table width=100% cellpadding=0 cellspacing=0 style=\"border: 1px solid #1E212A\">
		<Tr bgcolor=#1E212A height=20><td colspan=2><font color=white>&nbsp;&nbsp;<b>Admins</b></font></tr>");
	
	$news = mysql_query("SELECT * FROM `$CONF[table_prefix]admins`
			   ORDER BY username DESC");
	
	if(mysql_num_rows($news) == 0)
	{
		echo("<tr><td colspan=2>&nbsp;&nbsp;There are no admins on the system.</td></tr>");
	}
	
	echo("<script language=javascript>
		function deleteAdmin(id)
		{
			if(confirm(\"Are you sure you wish to delete this user?\"))
			{
				location.href = \"admin.php?action=admins&d=\"+id;
			}
		}
		</script>");
	
	while($row_info = mysql_fetch_array($news))
	{
		echo("<tr height=17><td><img src=\"images/arrowicon.gif\" border=\"0\" align=\"absmiddle\">&nbsp;&nbsp;$row_info[username]</td><td>[ <a href='admin.php?action=admins&cp=1&id=$row_info[id]'>Change Password</a> | <a href='javascript:deleteAdmin($row_info[id])'>Delete</a> ]</tD></tr>");
	}
	
	echo("</table><br><b>Add An Admin</b><br>Please fill in this form to add an administrator:<br><br>");
	
	if($error == 1)
	{
		foreach($errors as $error)
		{
			echo("<font color=#990000><b>Error:</b> $error</font><br>");
		}
		
		echo("<br>");
	}
	
	echo("<form action='$PHP_SELF?action=admins' method=post>
		<input type=hidden name=add value=1>");
	
	echo("<table cellpadding=0 cellspacing=0>
		<tr><td><b>Username:</b> </td><td> <input type=text name=username size=30></td></tr>
		<tr><td><b>Password:</b> </td><td> <input type=password name=password size=30></td></tr>
	    <tr><td><b>Status:</b> </td><td><SELECT NAME=status SIZE=1><OPTION VALUE=admin>Administrator<OPTION VALUE=writer>Writer</SELECT></td></tr>
		  </table><br>
		<input type=submit value='Add Admin'> <input type=reset></form>");
	
	include './writerfooter.inc';
	
	exit();
	
}

# Category management actions

if($action == "deletecat") {
	
	$result = mysql_query("DELETE FROM `$CONF[table_prefix]categories`
			     WHERE catid = '$catid'");
	$result = mysql_query("DELETE FROM `$CONF[table_prefix]news` 
	WHERE category = '$catid'");
	
	header("Location: admin.php?action=categories");

	echo("Category, and News under the category have been deleted.");
	
	exit();
	
}

if($action == "categories")
{
	
	if($add == 1)
	{
		$errors = array();
		
		//-------------------------
		
		$req = array("catname");
		
		foreach($req as $field)
		{
			if(empty($_SUBMIT[$field]))
			{
				$error = 1;
			}
		}
		
		if($error == 1)
		{
			$errors[] = "You have not filled in all required fields.";
		}
		
		if($error != 1)
		{
			$result = mysql_query("INSERT INTO `$CONF[table_prefix]categories`
					     VALUES ('',
						    '$catname')");
		}
		
	}		

	include './writerheader.inc';
	define("USERNAME", $user);
	echo("<script language=javascript>
		function deleteCat(catid)
		{
			if(confirm(\"Are you sure you wish to delete this category? It will delete all of the news under it as well.\"))
			{
				location.href = \"admin.php?action=deletecat&catid=\"+catid;
			}
		}
		</script>");
	
	echo("<FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Category Management</font></font></font><br>");
	echo("Please select a category to delete or add a new category:<br><br><P><P><P><P>");
	
	echo("<table width=100% cellpadding=0 cellspacing=0 style=\"border: 1px solid #1E212A\">
		<Tr bgcolor=#1E212A height=20><td colspan=4><font color=white>&nbsp;&nbsp;<b>Categories</b></font></tr>");
	
	$result = mysql_query("SELECT catid, catname FROM `$CONF[table_prefix]categories`
			   ORDER BY catid ASC
			   LIMIT 5");
	
	if(mysql_num_rows($result) == 0)
	{
		echo("<tr><td colspan=2>&nbsp;&nbsp;There are no news categories on the system.</td></tr>");
	}
	
	while($row_info = mysql_fetch_array($result))
	{
		echo("<tr height=17><td width=20><img src=\"images/arrowicon.gif\" border=\"0\" align=\"absmiddle\"></td><td>$row_info[catname]</td><td><b>Category ID:</b> $row_info[catid]</td><td>[ <a href='javascript:deleteCat($row_info[catid])'>Delete</a> ]</tD></tr>");
	}
	
	echo("</table><br><b>Add a new category</b><br>Please fill in this form to add a category item:<br><br>");
	
	if($error == 1)
	{
		foreach($errors as $error)
		{
			echo("<font color=#990000><b>Error:</b> $error</font><br>");
		}
		
		echo("<br>");
	}
	
	echo("<form action='$PHP_SELF?action=categories' method=post>
		<input type=hidden name=add value=1>
		<table cellpadding=0 cellspacing=0>
		 <tr><td><b>Category Name:</b> (*) </td><td><input type=text name=catname size=30></td></tr>
		</table><br><input type=submit value='Add Category'> <input type=reset>
		</form>");
	
	include './writerfooter.inc';
	
	exit();
	
	
}

# Begin User Profile Edit

if($action == "editprofile")
{
	
	if($update == 1)
	{
		$array = array("name", "email", "bio", "website", "photo");
		
		foreach($array as $edititem)
		{
			
			$result = mysql_query("UPDATE `$CONF[table_prefix]admins`
					     SET $edititem = '".addslashes($_SUBMIT[$edititem])."'
					     WHERE username = '$user'");
		}
		
		$updated=1;
	}
	
	include './writerheader.inc';
	define("USERNAME", $user);
	echo("<FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Editing Your Profile</font></font></font><br>Please make any profile changes and click 'Save Changes':<br><br>");
	
	if($updated == 1)
	{
		echo("<font color=#006633><b>Success:</b> Your profile changes have been saved.</font><br><br>");
	}
			
	echo("<table width=100%><tr><td width=50%>
	<form action='$PHP_SELF?action=editprofile&user=$user' method=post enctype='multipart/form-data'>
		<input type=hidden name=update value=1>
		<table cellpadding=0 cellspacing=0>");
		
		$result = mysql_query("SELECT * FROM `$CONF[table_prefix]admins`
		WHERE username = '$user'");
		$row_info = mysql_fetch_array($result);
		
		echo("<tr><td><b>Name:</b> (*) </td><td><input type=text name=name size=30 value=\"$row_info[name]\"></td></tr>
		<tr><td><b>Email:</b> (*) </td><td><input type=text name=email value=\"$row_info[email]\"></td></tr>
		 <tr><td valign=top><b>Bio:</b> (*)</td><td><textarea name=bio cols=30 rows=10>$row_info[bio]</textarea></td></tr>
		 <tr><td><b>Website:</b></td><td><input type=text name=website size=30 value=\"$row_info[website]\"></td></tr>
		 <tr><td><b>Photo URL:</b></td><td><input type=text name=photo value=\"$row_info[photo]\" onFocus=\"if(this.value=='http://')this.value='';\"></td></tr>
		</table><br><input type=submit value='Edit Profile'> <input type=reset>
		</form></td><td>");
		
		if($row_info[photo] == "")
		{
			$biophoto = "images/nophoto.gif";
		}
		else
		{
		$biophoto = "$row_info[photo]";
	}
		echo("<center><b>Bio Photo:</b><br><img src=\"$biophoto\"></td></tr></table>");
		
	include './writerfooter.inc';
	
	exit();
	
}

# End User Profile Edit

# Special Tags
if($action == "specialtags")
{
	include './writerheader.inc';
	include 'specialtagsw.html';
	include './writerfooter.inc';
	exit();
}
# End Special Tags

# End Category management actions
if($action == "viewall")
{
include './writerheader.inc';
define("USERNAME", $user);
echo("<FONT SIZE=4><FONT FACE=Arial>$sitename News Management Writer Panel</font></font></font><br>Hi $user, the $sitename writer's panel allows you to write and submit your articles<br>to the $sitename administrators.  If your article is approved, it will go live on the site.<br><P><P>");
echo("<table width=100% cellpadding=0 cellspacing=0>");
echo("<tr><td width=30% valign=top>");
echo("<table width=100% cellpadding=0 cellspacing=0 style=\"border: 1px solid #1E212A\">
		<tr bgcolor=#1E212A height=20><td colspan=2><font color=white>&nbsp;&nbsp;<b>Your 5 Latest $row6_info[catname] Items</b></font></tr></td>");
	
	$news = mysql_query("SELECT * FROM `$CONF[table_prefix]news`
	WHERE category = '$catid' 
	ORDER BY date_added DESC LIMIT 5");
	
	if(mysql_num_rows($news) == 0)
	{
		echo("<tr><td colspan=2>&nbsp;&nbsp;There are no news items on the system.</td></tr>");
	}
	
	while($row_info = mysql_fetch_array($news))
	{
		$row_info[date] = date("m.d.Y", $row_info['date_added']);
		echo("<tr height=17><p><td width=20 valign=top><img src=\"images/arrowicon.gif\" border=\"0\" align=\"absmiddle\"></td><td><b><a href=\"viewarticle.php?id=$row_info[id]\" target=blank class=welcomenews>$row_info[headline]</a></b><br><i>$row_info[date]</i><br><font color=gray>$row_info[blurb]</font><p></td></tr>");
	}
echo("</tr></td></table><td width=70% valign=top><p align=right>");
echo("<form action='$PHP_SELF?user=$user' method=post><b>View News in other Categories:</b><br><SELECT NAME=catid SIZE=1><OPTION VALUE=>");
	
		$cats = mysql_query("SELECT catid, catname FROM `$CONF[table_prefix]categories`
			   ORDER BY catid ASC
			   LIMIT 30");
			   while($row7_info = mysql_fetch_array($cats))
			   
		echo("<OPTION VALUE=$row7_info[catid]>$row7_info[catname]");
		echo("</SELECT> <input type=submit name=submit value=View></form></table");
include './writerfooter.inc';
}
else
{

# start welcome screen
include './writerheader.inc';
define("USERNAME", $user);
echo("<FONT SIZE=4><FONT FACE=Arial>$sitename News Management Writer Panel</font></font></font><br>Hi $user, the $sitename writer's panel allows you to write and submit your articles<br>to the $sitename administrators.  If your article is approved, it will go live on the site.<br><P><P>");
echo("<table width=100% cellpadding=0 cellspacing=0>");
echo("<tr><td width=30% valign=top>");
echo("<table width=100% cellpadding=0 cellspacing=0 style=\"border: 1px solid #1E212A\">
		<tr bgcolor=#1E212A height=20><td colspan=2><font color=white>&nbsp;&nbsp;<b>Your 5 Latest $row6_info[catname] Items</b></font></tr></td>");
	
	$news = mysql_query("SELECT * FROM `$CONF[table_prefix]news`
	WHERE added_by = '$user' 
	ORDER BY date_added DESC LIMIT 5");
	
	if(mysql_num_rows($news) == 0)
	{
		echo("<tr><td colspan=2>&nbsp;&nbsp;There are no news items on the system.</td></tr>");
	}
	
	while($row_info = mysql_fetch_array($news))
	{
		$row_info[date] = date("m.d.Y", $row_info['date_added']);
		echo("<tr height=17><p><td width=20 valign=top><img src=\"images/arrowicon.gif\" border=\"0\" align=\"absmiddle\"></td><td><b><a href=\"viewarticle.php?id=$row_info[id]\" target=blank class=welcomenews>$row_info[headline]</a></b><br><i>$row_info[date]</i><br><font color=gray>$row_info[blurb]</font><p></td></tr>");
	}
echo("</tr></td></table><td width=70% valign=top><p align=right>");
echo("<form action='$PHP_SELF?action=viewall&user=$user' method=post><b>View News in other Categories:</b><br><SELECT NAME=catid SIZE=1><OPTION VALUE=>");
	
		$cats = mysql_query("SELECT catid, catname FROM `$CONF[table_prefix]categories`
			   ORDER BY catid ASC
			   LIMIT 30");
			   while($row7_info = mysql_fetch_array($cats))
			   
		echo("<OPTION VALUE=$row7_info[catid]>$row7_info[catname]");
		echo("</SELECT> <input type=submit name=submit value=View></form></table");
include './writerfooter.inc';

}

?>