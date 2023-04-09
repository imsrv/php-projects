<?php
/*
    
	Squito Gallery 1.33
    Copyright (C) 2002-2003  SquitoSoft and Tim Stauffer

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

session_start();
include('head.inc.php');
$_SESSION['lastpage'] = $_SERVER['REQUEST_URI'];
?>
<html><head><title><?php echo $site_name;?> - Admin Menu</title>
<link rel="stylesheet" href="squito.css" type="text/css"></head>
<body>
<?php
if(!isset($_SESSION['auth'])) $auth = '';
else
$auth = $_SESSION['auth'];
if($auth != 1)
{
?>
<table bgcolor="#CCCCCC" cellspacing="0" cellpadding="5" class="sidebox" width="300">
  <tr>
    <td bgcolor="#000066" align="center"><b><font color="#FFFFFF">Login</font></b></td>
  </tr><tr><td>
<?php login_form($_SERVER['REQUEST_URI']);
?></td></tr></table>
            <?php
}
else
{
if(isset($_SESSION['level'])) $level = $_SESSION['level'];
else $level = '';
?>
<div align='center'>
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000066">
      <div align="center"><font color="#FFFFFF">Admin Menu</font></div>
    </td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" align="center"><BR>
 | <a href="auth/logout.php">Logout</a> |
 
  <?php if($level > 199) echo ' <a href="auth/admin.php">User Management</a> |'; ?>
  <?php if($level > 199) echo ' <a href="admin/admin.php">Photo Management</a> |'; ?>
  <?php if($level > 199) echo ' <a href="admin/admin.php?menu=prefs">Preferences</a> |'; ?>

  <br><BR><RB></td></tr></table> </div>
<?php

}
?>
</body></html>