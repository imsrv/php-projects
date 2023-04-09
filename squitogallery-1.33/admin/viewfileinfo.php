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
require('../dbfns.inc.php');
require('../lang/'.$_SESSION['language'].'.inc.php');
require('admin_photo.class.php');
$obj = new Photo();
$obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
// get children
$obj->set_display(3,0,$webimageroot,$images,$thumbnails,$photoroot);
if(isset($_POST['submit']))
{
   $db=dbConnect();
   if($_POST['modeofform']=='i')
   {
      $answers = $_POST['form_input'];
      foreach($answers as $key=>$value)
      {
       $query =  "insert into fileinfo_a values ('',$key,'".$_POST['photo_id'] . "','".$value[0]."')";
       mysql_query($query,$db);

      }
   echo 'inserted';
   mysql_close();
   exit;


   }
   if($_POST['modeofform']=='u')
   {
      $answers = $_POST['form_input'];
      foreach($answers as $key=>$value)
      {
       $query = "update fileinfo_a set answer='".$value[0]."' where q_id = $key and photo_id = '".$_POST['photo_id']."'";
       mysql_query($query,$db);
      }
      echo 'updated';
   mysql_close();
   exit;


   }
}
?>

<html><head><title><?php echo $obj->get_imagename($_GET['photo_id']).' Fileinfo';?></title>
<link rel="stylesheet" href="../squito.css" type="text/css">
</head><body onload="self.focus()">
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<table>
<?php
$db = dbConnect();
print '<hr><b>File Info for <i>'.$obj->get_imagename($_GET['photo_id']).'</i></b><hr>';
$query = 'select id,question from fileinfo_q';
$result=mysql_query($query,$db);
while($myrow=mysql_fetch_array($result))
{
 $q_id[$myrow['id']]=$myrow['question'];

}
foreach($q_id as $key=>$value)
{
$query = 'select * from fileinfo_a where photo_id = "'.$_GET['photo_id'].'" and q_id='.$key ;
//echo $query;
if(!mysql_num_rows($result))
$modeofform='i';
else
$modeofform='u';
$result = mysql_query($query,$db);
$myrow = mysql_fetch_array($result);
echo '<tr><td>'.$value.': </td><td>'.'<input type="text" name="form_input['.$key.'][]" value="'.$myrow['answer'].'"></td></tr>'."\n";
}



?>

</table>
<input type="hidden" name="modeofform" value="<?php echo $modeofform;?>">
<?php if($modeofform == "u")
echo '<input type="hidden" name="photo_id" value="'.$myrow['photo_id'].'">';
?>
<input type="submit" name="submit" value="save">
</form>
</body></html>