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
require('squitofns.inc.php');
if($_SESSION['usercreated'])
{
unset($_SESSION['usercreated']);
header('location: http://'.$homeURL.$webimageroot.'/auth/admin.php?menu=listall');
}
//if(isset($_SESSION['auth'])) $auth = $_SESSION['auth'];
//else $auth =0;
if( $_SESSION['auth'] == 1 && $_SESSION['level']>199)
{
?>
<html><head><title><?php echo $site_name;?> - User Management</title>
<link rel="stylesheet" href="../squito.css" type="text/css"> </head>
<body>
<div align="center">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000066">
      <div align="center"><font color="#FFFFFF">User Management</font></div>
    </td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" align="center">
      <p><a href="http://<?php echo $homeURL.$webimageroot.'/'.$mainfilename; ?>"><?php echo $site_name; ?></a><br>
        | <a href="../admin.php">Admin Home</a> | <a href="admin.php?menu=adduser"> Add User</a>
        | <a href="admin.php?menu=edituser">Edit User</a> | <a href="admin.php?menu=listall">List
        All</a> |<br>
      </p>
      <p>
          <?php
		  if(isset($_GET['menu'])) $menu = $_GET['menu'];
		  else 
		  $menu = '';
          switch ($menu)
          {
          case "adduser":
          include('addnewuser.inc.php');
          break;
          case "edituser":
          include('edituser.inc.php');
          break;
          case "listall":
          include('listall.inc.php');
          break;
           case "addquestion":
          include('addquestion.inc.php');
          break;

          }
          ?>
           </p>
    </td>
  </tr>
</table>
</div>
<?php
}
else
header('Location: http://'.$homeURL.$webimageroot.'/admin.php');
?>