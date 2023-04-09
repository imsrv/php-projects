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
set_time_limit(300); 
session_start();
require('../config.inc.php');
require('../dbfns.inc.php');
require('admin_photo.class.php');
$obj = new Photo();
$obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
// get children
$obj->set_display(3,0,$webimageroot,$images,$thumbnails,$photoroot);
if(isset($_POST['submit']))
{
if($useimagemagick==1)
$gfxtype = 1;
if($usegd184==1)
$gfxtype = 2;
if($usegd201==1)
$gfxtype = 3;

for($x=0; $x<sizeof($_POST['form_import']); $x++)
{
//echo $gfxtype;
//echo $_POST['form_import'][$x].'<br>';
$obj->import_images($_POST['form_import'][$x],$_POST['form_dest'],$thumbsize,$imagemagickpath,$gfxtype);
$obj->flush_photofile_index();

}
echo '<script language="javascript">opener.location.href = opener.location.href; window.close();</script>';

}
//$obj->show_upload_form($_SESSION['error']);
?><html><head><title>Import Images</title>

<link rel="stylesheet" href="../squito.css" type="text/css">
</head><body onload="self.focus()"><form action="" METHOD="post" name="importfiles"><?
$files = read_in_dir($photoroot.'uploads','file');
 sort($files);
 echo 'Import Files into <select name="form_dest"><option value="'.$_GET['dir_id'].'">'.$obj->get_name($_GET['dir_id']).'</option>'."\n";
echo $obj->get_ancester_droplist(0);
echo '</option></select><br>';
?><script language="JavaScript">
   <!--
   function CheckAll()
   {
      for (var i=0;i<document.importfiles.elements.length;i++)
      {
         var e = document.importfiles.elements[i];
         if (e.name != "allbox")
            e.checked = document.importfiles.allbox.checked;
      }
   }
   //-->
</script>

<?php

for($x=0; $x<sizeof($files);$x++)
{
echo $files[$x].' <input type="checkbox" name="form_import[]" value="'.$photoroot.'uploads/'.$files[$x].'"><br>'."\n";

}
?><br><B>Check All:<input name="allbox" type="checkbox" value="1" onClick="CheckAll();"></B> <BR><br><BR><input type="submit" name="submit" value="Import">
</form>
</body></html>