<?php
/***************************************************************************
 *                      Olate Download v2 - Download Manager
 *
 *                           http://www.olate.com
 *                            -------------------
 *   author                : David Mytton
 *   copyright             : (C) Olate 2003 
 *
 *   Support for Olate scripts is provided at the Olate website. Licensing
 *   information is available in the license.htm file included in this
 *   distribution and on the Olate website.                  
 ***************************************************************************/

// Start script
$admin = 2;
require_once('../../includes/init.php');  

// Start session
session_start();

// Function: Make sure user has logged in
admin_authenticate($config);

// Function: Display selected category
admin_categories_edit_view($_GET['id']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title>Olate Download - <?= $language['title_admin'] ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="../../css/style.css" title="default" />

</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="top"><hr width="1" size="1" color="#FFFFFF">
<table class="admin_main" align="center" border="1">
<tr>
<td class="admin_title"><table class="admin_title_table">
<tr>
<td class="admin_title"><strong>Olate Download - <?= $language['title_script'] ?></strong></td>
</tr>
</table></td>
</tr>
<tr>
<td class="admin_breadcrumb">
<table width="99%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="71%"><strong><a href="<?= $config['urlpath']; ?>/admin/main.php"><?= $language['link_administration']; ?></a><?= $language['title_categories_edit']; ?></strong></td>
<td width="29%"><div align="right"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?= $language['description_loggedinas'].' '.$_SESSION['admin_username']; ?>. <a href="<?= $config['urlpath']; ?>/admin/logout.php"><?= $language['link_logout']; ?></a>.</strong></font></div></td>
</tr>
</table></td>
</tr>
<tr>
<td valign="top" bordercolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><p><?= $language['description_categories_edit_view']; ?></p>
<form action="edit_process.php" method="post" name="edit" id="edit">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="12%"><?= $language['title_categories_name']; ?></td>
<td width="88%"><input name="name" type="text" id="name" value="<?= stripslashes($row['name']); ?>" size="25"></td>
</tr>
</table>
<p>
<input type="submit" name="Submit" value="<?= $language['button_update']; ?>">
<input name="id" type="hidden" id="id" value="<?= $row['id']; ?>">
</p>
</form></td>
</tr>
</table></td>
</tr>
<tr>
<td height="25" valign="middle" bordercolor="#FFFFFF" bgcolor="#E3E8EF"><?php
// Include Credits - REMOVAL WILL VOID LICENSE
require('../../includes/credits.php');
?></td>
</tr>
</table>
  <hr width="1" size="1" color="#FFFFFF"></td>
</tr>
</table>
</body>
</html>