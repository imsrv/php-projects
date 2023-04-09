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
require('../config.inc.php');
require('admin_photo.class.php');
require('../lang/'.$_SESSION['language'].'.inc.php');
$obj = new Photo();
$obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
// get children
$obj->set_display(3,0,$webimageroot,$images,$thumbnails,$photoroot);
?>
<html><head><title><?php echo $obj->get_imagename($_GET['photo_id']).' Comments';?></title>
<link rel="stylesheet" href="../squito.css" type="text/css">
</head><body onload="self.focus()">
<?php
$obj->delete_folder(0);
?>
</body></html>