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
			setcookie("admindata[0]", $username, (time() + (365 * 24 * 60 * 60 * 1000)));
			setcookie("admindata[1]", $password, (time() + (365 * 24 * 60 * 60 * 1000)));
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
	
	admin_header2();
	
	echo("<img src=\"images\lock.gif\" border=\"0\" align=\"absmiddle\"> <FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Login</FONT></FONT><br>
		Please enter your username and password to login:<br><br><P><P><P><P>");
		
	if($login_error == 1) { echo("<span class=error><b>Error:</b> Invalid Username/Password combination.</span>"); }
	
	echo("<form action='admin.php?action=login' method=post>
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
	
	admin_footer();
	
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
	
	header("Location: admin.php?action=news");
	
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

	admin_header();
	
	echo("<script language=javascript>
		function deleteNews(id)
		{
			if(confirm(\"Are you sure you wish to delete this news item?\"))
			{
				location.href = \"admin.php?action=delete&id=\"+id;
			}
		}
		</script>");
	
	echo("<FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>News Management</font></font></font><br>");
	echo("Please select a news item to edit or add a new news item:<br><br><P><P><P><P>");
	
	echo("<table width=100% cellpadding=0 cellspacing=0 style=\"border: 1px solid #1E212A\">
		<Tr bgcolor=#1E212A height=20><td colspan=2><font color=white>&nbsp;&nbsp;<b>News Items</b></font></tr>");
	
	$news = mysql_query("SELECT * FROM `$CONF[table_prefix]news`
			   ORDER BY date_added DESC
			   LIMIT 5");
	
	if(mysql_num_rows($news) == 0)
	{
		echo("<tr><td colspan=2>&nbsp;&nbsp;There are no news items on the system.</td></tr>");
	}
	
	while($row_info = mysql_fetch_array($news))
	{
		echo("<tr height=17><td><img src=\"images/arrowicon.gif\" border=\"0\" align=\"absmiddle\">&nbsp;&nbsp;$row_info[headline]</td><td>[ <a href='admin.php?action=editenews&id=$row_info[id]'>Edit</a> | <a href='javascript:deleteNews($row_info[id])'>Delete</a> ]</tD></tr>");
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
				   
		echo("<form action='$PHP_SELF?action=news' method=post enctype='multipart/form-data'>
		<input type=hidden name=add value=1>
		<table cellpadding=0 cellspacing=0>
		<tr><td><b>Category:</b> </td><td><SELECT NAME=category SIZE=1><OPTION VALUE=>No Categories Listed");
		
		$cats = mysql_query("SELECT catid, catname FROM `$CONF[table_prefix]categories`
			   ORDER BY catid ASC
			   LIMIT 30");
			   while($row2_info = mysql_fetch_array($cats))
			   
		echo("<OPTION VALUE=$row2_info[catid]>$row2_info[catname]");
		echo("</SELECT></td></tr>");
		echo("<tr><td><b>Headline:</b> (*) </td><td><input type=text name=headline size=50></td></tr>
		 <tr><td><b>Blurb:</b> (*) </td><td><textarea name=blurb cols=50 rows=8></textarea></td></tr>
		 <tr><td valign=top><b>Article:</b> (*)</td><td><textarea name=article cols=50 rows=10></textarea></td></tr>
		 <tr><td><b>Added By:</b></td><td><input type=text name=added_by size=50></td></tr>
		 <tr><td><b>Image:</b></td><td><input type=file name=image></td></tr>
		 <tr><td><b>Status:</b></td><td><INPUT TYPE=RADIO NAME=live VALUE=yes>Live <INPUT TYPE=RADIO NAME=live VALUE=no>Not-Live</td><tr>
		</table><br><center><input type=submit value='Add News'> <input type=reset></center>
		</form>");
	admin_footer();
	
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
			
			$result = mysql_query("UPDATE `$CONF[table_prefix]news` SET image = '".$_FILES[image][name]."' WHERE id = '$id'");
		}
		
		$array = array("category", "headline", "blurb", "text", "added_by", "live");
		
		foreach($array as $edititem)
		{
			$result = mysql_query("UPDATE `$CONF[table_prefix]news`
					     SET $edititem = '".addslashes($_SUBMIT[$edititem])."'
					     WHERE id = '$id'");
		}
		
		$updated=1;
	}
	
	admin_header();
	
	echo("<FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Editing News Article</font></font></font><br>Please make any article changes and click 'Save Changes':<br><br>");
	
	if($updated == 1)
	{
		echo("<font color=#006633><b>Success:</b> Your changes have been saved.</font><br><br>");
	}
			
	echo("<form action='$PHP_SELF?action=editenews&id=$id' method=post enctype='multipart/form-data'>
		<input type=hidden name=update value=1>
		<table cellpadding=0 cellspacing=0>");
		
		echo("<tr><td><b>Category:</b> </td><td><SELECT NAME=category SIZE=1><OPTION VALUE=>No Categories Listed");
		
		$result = mysql_query("SELECT * FROM `$CONF[table_prefix]news`
		WHERE id = '$id'");
		
		$row11_info = mysql_fetch_array($result);
		
		$cats = mysql_query("SELECT catid, catname FROM `$CONF[table_prefix]categories`
			   ORDER BY catid ASC
			   LIMIT 30");
			   while($row2_info = mysql_fetch_array($cats))
		
			   
		echo("<OPTION ".sprintf("%s", $row11_info['category'] == $row2_info['catid'] ? " selected " : "")." VALUE=$row2_info[catid]>$row2_info[catname]");
		echo("</SELECT></td></tr>");
		
		echo("<tr><td><b>Headline:</b> (*) </td><td><input type=text name=headline size=50 value=\"$row11_info[headline]\"></td></tr>
		 <tr><td><b>Blurb:</b> (*) </td><td><textarea name=blurb cols=50 rows=8>$row11_info[blurb]</textarea></td></tr>
		 <tr><td valign=top><b>Article:</b> (*)</td><td><textarea name=text cols=50 rows=10>$row11_info[text]</textarea></td></tr>
		 <tr><td><b>Username:</b></td><td><input type=text name=added_by size=50 value=\"$row11_info[added_by]\"></td></tr>
		 <tr><td><b>Image:</b></td><td><input type=file name=image></td></tr>");
		 
		 if($row11_info[live] == "yes")
		 {
			 echo("<tr><td><b>Status:</b></td><td><INPUT TYPE=RADIO NAME=live VALUE=yes CHECKED>Live <INPUT TYPE=RADIO NAME=live VALUE=no>Not-Live</td></tr>");
		 }
		 if($row11_info[live] == "no")
		 {
			 echo("<tr><td><b>Status:</b></td><td><INPUT TYPE=RADIO NAME=live VALUE=yes>Live <INPUT TYPE=RADIO NAME=live VALUE=no CHECKED>Not-Live</td></tr>");
		 }
		echo("</table><br><center><input type=submit value='Edit News'> <input type=reset></center>
		</form><br><b>Note:</b> In order to keep the current image for this article, enter nothing in the image box");
		
	admin_footer();
	
	exit();
	
}
# End Edit News

# templates
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

	admin_header();
	
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
	
	admin_footer();
	
	exit();
	
}
# end templates

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
		
		admin_header();
		
		echo("<b>Change User Password</b><br>Please fill in this form to change this user's password:<br><br>");
		
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
		
		admin_footer();
		
		exit();
		
	}

# Begin Edit User Info
	if($ei == 1)
	{
	if($update == 1)
		{
			$array = array("name", "status", "email", "bio", "website", "photo");
			
			foreach($array as $field)
			{
							
			$result = mysql_query("UPDATE `$CONF[table_prefix]admins`
						     SET $field = '".addslashes($_SUBMIT[$field])."'
						     WHERE id = '$id'");
				}
		
		$updated=1;
	}
		admin_header();
		
		echo("<FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Editing User's Profile</font></font></font><br>Please make any profile changes and click 'Save Changes':<br><br>");
	
	if($updated == 1)
	{
		echo("<font color=#006633><b>Success:</b> User's profile changed.</font><br><br>");
	}
	
		echo("<table width=100%><tr><td width=50%>
		<form action='$PHP_SELF' method=post>
			<input type=hidden name=ei value=1>
			<input type=hidden name=id value=$id>
			<input type=hidden name=update value=1>
			<input type=hidden name=action value=admins>
			<table cellpadding=0 cellspacing=0>");
			
		$result = mysql_query("SELECT * FROM `$CONF[table_prefix]admins`
		WHERE id = '$id'");
		$row_info = mysql_fetch_array($result);
	
		echo("<tr><td><b>Name:</b> (*) </td><td><input type=text name=name size=30 value=\"$row_info[name]\"></td></tr>
		<tr><td><b>Status:</b> </td><td><SELECT NAME=status SIZE=1><OPTION VALUE=admin>Administrator<OPTION VALUE=writer>Writer</SELECT></td></tr>
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
		
		admin_footer();
		
		exit();
		
	}
# End Edit User info
	if($add == 1)
	{
		$errors = array();
		
		//-------------------------
		
		$req = array("username", "password", "status", "name", "email");
		
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
					     VALUES ('',
						    '$username',
						    '".crypt($password, "DD")."','$status','$name','$email','','','')");
		}
		
	}
	
	if(isset($d))
	{
		$result = mysql_query("DELETE FROM `$CONF[table_prefix]admins`
			     	     WHERE id = '$d'");
	
		header("Location: admin.php?action=admins");
	
		exit();	
	}
	
	admin_header();
	
	echo("<img src=\"images/adminicon.gif\" border=\"0\" align=\"absmiddle\"> <FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Admin & Writer Management</font></font></font><br>From here you can control the admins and writers using the system:<br><br>");
	
	if($pass == 1)
	{
		echo("<font color=#006633><b>Success:</b> Your changes have been saved.</font><br><br>");
	}
	echo("<table width=100% cellpadding=0 cellspacing=0 style=\"border: 1px solid #1E212A\">
		<Tr bgcolor=#1E212A height=20><td colspan=2><font color=white>&nbsp;&nbsp;<b>List of users with $status status</b></font></tr>");
	
		if($status == "")
		{
			$news = mysql_query("SELECT * FROM `$CONF[table_prefix]admins`
			   ORDER BY username DESC");
		   }else{
	$news = mysql_query("SELECT * FROM `$CONF[table_prefix]admins`
			   WHERE status = '$status' ORDER BY username DESC");
}
	if(mysql_num_rows($news) == 0)
	{
		echo("<tr><td colspan=2>&nbsp;&nbsp;There are no $status's on the system.</td></tr>");
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
		echo("<tr height=17><td><img src=\"images/arrowicon.gif\" border=\"0\" align=\"absmiddle\">&nbsp;&nbsp;$row_info[username]</td><td>[ <a href='admin.php?action=admins&cp=1&id=$row_info[id]'>Change Password</a> | <a href='admin.php?action=admins&ei=1&id=$row_info[id]'>Edit Information</a> | <a href='javascript:deleteAdmin($row_info[id])'>Delete</a> ]</tD></tr>");
	}
	
	echo("</table><br><b>Add An Admin or Writer</b><br>Please fill in this form to add an administrator or writer:<br><br>");
	
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
		<tr><td><b>Username: </b></td><td><input type=text name=username size=30></td></tr>
		<tr><td><b>Password: </b></td><td><input type=password name=password size=30></td></tr>
	    <tr><td><b>Status: </b></td><td><SELECT NAME=status SIZE=1><OPTION VALUE=admin>Administrator<OPTION VALUE=writer>Writer</SELECT></td></tr>
	    <tr><td><b>Name: </b></td><td><input type=text name=name size=30></td></tr>
	    <tr><td><b>Email: </b></td><td><input type=text name=email size=30></td></tr>
		<table><br><input type=submit value='Add Admin'> <input type=reset></form></table>");
	
	admin_footer();
	
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

	admin_header();
	
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
			   ORDER BY catid ASC");
	
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
	
	admin_footer();
	
	exit();
	
	
}
# End Category management actions

# Begin Profile Templates

if($action == "protemplates")
{
	
	if($update == 1)
	{
		$array = array("style_sheet", "profile_header", "profile_footer", "show_profile");
		
		foreach($array as $item)
		{
			$result = mysql_query("UPDATE `$CONF[table_prefix]protemplates`
					     SET code = '".addslashes($_SUBMIT[$item])."'
					     WHERE name = '$item'");
		}
		
		$updated=1;
	}
	
	$result = mysql_query("SELECT * FROM `$CONF[table_prefix]protemplates`");
	
	while($row_info = mysql_fetch_array($result))
	{
		$TEMPLATE[$row_info['name']] = $row_info['code'];
	}

	admin_header();
	
	echo("<FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Profile Template Management</font></font></font><br>Please make any template changes and click 'Save Changes':<br><br>");
	
	if($updated == 1)
	{
		echo("<font color=#006633><b>Success:</b> Your changes have been saved.</font><br><br>");
	}
	
	echo("<form action='$PHP_SELF?action=protemplates' method=post>
		<input type=hidden name=update value=1>");
	
	echo("<table cellpadding=0 cellspacing=0>
		<tr><td><b>Style Sheet:</b><br>Your profile stylesheet</td><td><textarea rows=7 cols=50 name=style_sheet>$TEMPLATE[style_sheet]</textarea></td></tr>
		<tr><td><b>Profile Header:</b><br>Displayed before each profile</td><td><textarea rows=7 cols=50 name=profile_header>$TEMPLATE[profile_header]</textarea></td></tr>
		<tr><td><b>Profile Footer:</b><br>Displayed after each profile</td><td><textarea rows=7 cols=50 name=profile_footer>$TEMPLATE[profile_footer]</textarea></td></tr>
		<tr><td><b>Show Profile:</b><br>The main profile display</td><td><textarea rows=7 cols=50 name=show_profile>$TEMPLATE[show_profile]</textarea></td></tr>
	      </table><br>
		<input type=submit value='Save Changes'> <input type=reset value='Revert to Saved'></form>");
	
	admin_footer();
	
	exit();
	
}

# End Profile Templates

# Main Welcome Screen View All
if($action == "artviewall")
{
	admin_header();
	echo("<p><p><TABLE WIDTH=\"100%\" CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\">
    <TR>
     <TD WIDTH=\"100%\" VALIGN=BOTTOM>
       <a href=\"admin.php\"><img src=\"images/stattab.gif\" border=\"0\"></a><a href=\"admin.php?action=artviewall&em=view\"><img src=\"images/viewlivetab.gif\" border=\"0\"></a><a href=\"admin.php?action=artviewua&em=view\"><img src=\"images/viewunapptab.gif\" border=\"0\"></a></TD>
    </TR>
    <TR>
     <TD WIDTH=\"100%\" BGCOLOR=\"#666699\" VALIGN=TOP>
      <P>
       <IMG SRC=\"images/pixle.gif\" WIDTH=\"1\" HEIGHT=\"1\" VSPACE=\"0\" HSPACE=\"0\" BORDER=\"0\"></TD>
    </TR>
   </TABLE>");
	include 'viewall.php';
admin_footer();
exit();
}

# End Viewall

# Get Code
if($action == "getcode1")
{
	admin_header();
		$cats = mysql_query("SELECT catid, catname FROM `$CONF[table_prefix]categories`
			   ORDER BY catid ASC
			   LIMIT 30");
			   	
		echo("<form action='$PHP_SELF?action=getcode2' method=post enctype='multipart/form-data'>
		<FONT FACE=\"Arial,Helvetica,Monaco\"><FONT SIZE=\"4\"><I><FONT COLOR=\"#002B55\">Get
        Code</FONT></I></FONT></FONT><BR><FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\">In this area, you will receive the code needed to display your headlines on your website.</FONT></FONT></P>
        <P><FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\">Please fill out the form below, and press the 'Get Code' </FONT></FONT><BR><HR WIDTH=\"100%\" SIZE=\"2\"><FONT SIZE=\"2\"><FONT FACE=\"Arial,Helvetica,Monaco\"><b>What category 
        would you like</FONT></FONT><BR><FONT SIZE=\"2\"><FONT FACE=\"Arial,Helvetica,Monaco\">to link to?</b></FONT></FONT><BR>
        <select name=category><OPTION VALUE=\"\" selected>-- Select a News Category --");			   
		while($row2_info = mysql_fetch_array($cats))
		echo("<OPTION VALUE=$row2_info[catid]>$row2_info[catname]");
		
		echo("</SELECT><p>");
		echo("<FONT SIZE=\"2\"><FONT FACE=\"Arial,Helvetica,Monaco\"><b>What type of code 
		would you like to use?</b></FONT></FONT><BR>
		<FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\"><SELECT NAME=\"code_type\" SIZE=\"1\"><OPTION SELECTED>-- select a code type --<OPTION VALUE=\"phpinclude\">PHP Include<OPTION VALUE=\"jsinclude\">JavaScript Include</SELECT></FONT></FONT></P>
		<P>");
		echo("<FONT SIZE=\"2\"><FONT FACE=\"Arial,Helvetica,Monaco\"><b>How many headlines 
		would you like</FONT></FONT><BR><FONT SIZE=\"2\"><FONT FACE=\"Arial,Helvetica,Monaco\">to display</b> (enter a number)?</FONT></FONT><BR>
		<FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\"><INPUT TYPE=TEXT NAME=\"itemnumber\" SIZE=\"20\" MAXLENGTH=\"256\"></FONT></FONT></P>
		<P><FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\"><INPUT TYPE=SUBMIT VALUE=\"Get Code\"> <INPUT TYPE=RESET VALUE=\"Reset Form\"></FONT></FONT></P>
		</FORM>");
	admin_footer();
	exit();
}
if($action == "getcode2")
{
	admin_header();
	if($code_type == "phpinclude")
	{
	echo("<FONT SIZE=\"4\"><FONT FACE=\"Arial,Helvetica,Monaco\"><B><FONT COLOR=\"#002B55\">Your
    PHP Code</FONT></B></FONT></FONT><BR>
   <FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\">Copy and paste the 
   code below, in your page, wherever you would like your headlines</FONT></FONT><BR>
   <FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\">to appear.</FONT></FONT></P>
  <P>
   <FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\"><B><FONT COLOR=\"RED\">Note</FONT></B></FONT></FONT><B><FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\"><FONT COLOR=\"RED\">:</FONT></FONT></FONT></B><FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\"> 
   This code will only work, if the page you insert it into, has a .php extension.</FONT></FONT><BR>
   <FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\">(i.e. index.php) 
   There will be more code options in later upgrades.</FONT></FONT><p>");
	echo("<textarea rows=7 cols=70><?php include(\"$CONF[domain]headlines.php?category=$category&items=$itemnumber\") ?></textarea>");
}

if($code_type == "jsinclude")
	{
		echo("<FONT SIZE=\"4\"><FONT FACE=\"Arial,Helvetica,Monaco\"><B><FONT COLOR=\"#002B55\">Your
    JavaScript Code</FONT></B></FONT></FONT><BR>
   <FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\">Copy and paste the 
   code below, in your page, wherever you would like your headlines</FONT></FONT><BR>
   <FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\">to appear.</FONT></FONT></P>
  <P>
   <FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\"><B><FONT COLOR=\"RED\">Note</FONT></B></FONT></FONT><B><FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\"><FONT COLOR=\"RED\">:</FONT></FONT></FONT></B><FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\"> 
   Unlike the PHP include version, this version will work on any page, including pages with the .html ext.  Please keep in mind however, that images may not show up properly in the JavaScript headlines.</FONT></FONT><BR>
   <FONT SIZE=\"1\"><FONT FACE=\"Arial,Helvetica,Monaco\">If you plan to use images within your headlines, and want to use the JavaScript code, you MUST use the full URL in your headline template<br>
   (i.e. http://www.yourdomain.com/images/\$news_info[image]) 
   </FONT></FONT><p>");
	echo("<textarea rows=7 cols=70><script language=\"javascript\" src=\"$CONF[domain]syndinews.php?category=$category&items=$itemnumber\"></script></textarea>");
}
	admin_footer();
	exit();
}
# End Get Code

# Special Tags
if($action == "specialtags")
{
	admin_header();
	include 'specialtags.html';
	admin_footer();
	exit();
}
# End Special Tags

# Unapproved Articles
if($action == "artviewua")
{
	admin_header();
	echo("<p><p><TABLE WIDTH=\"100%\" CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\">
    <TR>
     <TD WIDTH=\"100%\" VALIGN=BOTTOM>
       <a href=\"admin.php\"><img src=\"images/stattab.gif\" border=\"0\"></a><a href=\"admin.php?action=artviewall&em=view\"><img src=\"images/viewlivetab.gif\" border=\"0\"></a><a href=\"admin.php?action=artviewua&em=view\"><img src=\"images/viewunapptab.gif\" border=\"0\"></a></TD>
    </TR>
    <TR>
     <TD WIDTH=\"100%\" BGCOLOR=\"#666699\" VALIGN=TOP>
      <P>
       <IMG SRC=\"images/pixle.gif\" WIDTH=\"1\" HEIGHT=\"1\" VSPACE=\"0\" HSPACE=\"0\" BORDER=\"0\"></TD>
    </TR>
   </TABLE>");
	include 'viewua.php';
	admin_footer();
	exit();
}
# End Unapproved Articles

# Initial Welcome Screen
admin_header();
echo("<p><p><TABLE WIDTH=\"100%\" CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\">
    <TR>
     <TD WIDTH=\"100%\" VALIGN=BOTTOM>
      <a href=\"admin.php\"><img src=\"images/stattab.gif\" border=\"0\"></a><a href=\"admin.php?action=artviewall&em=view\"><img src=\"images/viewlivetab.gif\" border=\"0\"></a><a href=\"admin.php?action=artviewua&em=view\"><img src=\"images/viewunapptab.gif\" border=\"0\"></a></TD>
    </TR>
    <TR>
     <TD WIDTH=\"100%\" BGCOLOR=\"#666699\" VALIGN=TOP>
      <P>
       <IMG SRC=\"images/pixle.gif\" WIDTH=\"1\" HEIGHT=\"1\" VSPACE=\"0\" HSPACE=\"0\" BORDER=\"0\"></TD>
    </TR>
   </TABLE>");
include 'stats.php';
echo("<script language=javascript>
		function deleteNews(id)
		{
			if(confirm(\"Are you sure you wish to delete this news item?\"))
			{
				location.href = \"admin.php?action=delete&id=\"+id;
			}
		}
		</script>");
		

# End Initial Welcome Screen
admin_footer();
?>