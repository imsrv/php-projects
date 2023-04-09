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
if(!$_GET['menu'])
header('location: '.$_SERVER['PHP_SELF'].'?menu=addremalbums');
if(!$_SESSION['auth'] && $_SESSION['level']!=200 && $_SESSION['progcode'] != 'squitogallery')
header('location: ../admin.php');


if(!isset($_SESSION['language']))
{
$_SESSION['language'] = 'english';
}
include('../config.inc.php');
include('../dbfns.inc.php');
 require('admin_photo.class.php');
if(isset($_POST['form_language']))
$_SESSION['language'] = $_POST['form_language'];
include('../lang/'.$_SESSION['language'].'.inc.php');
//include('admin_body.inc.php');
if(isset($_GET['imagedir']))
$imagedir = $_GET['imagedir'];
else $imagedir = 0;
if($lang['Photo Management']) $must = $lang['Photo Management']; else $must = 'Photo Management';
?>

<html><head><title><?php echo $site_name;?> - <?php echo $must;?></title>
<link rel="stylesheet" href="../squito.css" type="text/css"> </head>
<body>
<div align="center">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000066">
      <div align="center"><font color="#FFFFFF"><?php echo $must;?></font></div>
    </td>
  </tr>
  <tr>
  <?php if($lang['Admin Home']) $must = $lang['Admin Home']; else $must = 'Admin Home';?>
    <td bgcolor="#CCCCCC" align="center"><a href="http://<?php echo $homeURL.$webimageroot.'/'.$mainfilename; ?>"><?php echo $site_name; ?></a><br>| <a href="../admin.php"><?php echo $must;?></a> |
       <br><br></td></tr>
       <tr><td align="center"><form name="language_form" ACTION="<?php echo $_SESSION['lastpage0']; ?>" method="post"><select name="form_language" onChange="language_form.submit();"><option value="english">Choose Language</option><?php  echo "\n";
       $allfiles = read_in_dir($photoroot.'lang/','file');
       foreach($allfiles as $value)
       {
         $value = explode('.',$value);
         echo '<option value="'.$value[0].'">'.$value[0].'</option>'."\n";
       }
       ?>
       </select></form></td></tr>
<tr><td>
<?php

switch($_GET['menu'])
{
case 'addremalbums':

include($photoroot.'admin/admin_addremalbums.inc.php');

                break;
                case "images":
                include($photoroot.'admin/admin_images.inc.php');
                break;
				case "prefs":
				include($photoroot.'admin/prefs.inc.php');
				break;
}
?>
</body></html>