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
if(isset($_POST['subEditUser']))
{

update_user();
}

?>

<table width="400" cellpadding="5"><tr>
    <td bgcolor="#000066" align="center" class="sidebox"><B><font color="#FFFFFF">Edit
      User</font></b></td>
  </tr></table><?php  if(isset($_POST['form_user'])) echo $_POST['form_user']; if(isset($_GET['form_user'])) echo $_GET['form_user'];?><form name="findUser" method="post" action="admin.php?menu=edituser">

<center><select name="form_user" onChange = "findUser.submit();"><option>Select User</option>
<?php
$db =dbConnect();
$query = 'Select * from authorization order by name asc';
$result = mysql_query($query, $db);
while($myrow=mysql_fetch_array($result))
{
if($_POST['form_user'] == $myrow['id'] || $_GET['form_user'] == $myrow['id'])
$edituser = $myrow;
echo '<option value="'.$myrow['id'].'">'.$myrow['name'].'</option>';
}
?>
</select></center></form>
<?php
if(isset($_POST['form_user']) || isset($_GET['form_user']))
{
?>

<form method="post" action="admin.php?menu=edituser">
<br>
  <table width="400">
  <?php if($edituser['mug'])
  {
  ?>
  <tr><td colspan="2" align="center"><img src="profiles/<?php echo $edituser['mug']; ?>"></td></tr>
  <?php

  }
  ?>

<tr><td>User Name:</td><td> <?php echo $edituser['name']; ?></td></tr>
<?php
$query = 'select * from profile_q where '.$edituser['id'];
$result = mysql_query($query,$db);
while($myrow =  mysql_fetch_array($result))
{
$query = 'select * from profile_a where q_id ="'.$myrow['id'] .'" and u_id="'.$edituser['id'].'" order by q_id asc';
//echo '<tr><td colspan="2">'.$query.'</td></tr>';
$answers = mysql_query($query, $db);
$answer = mysql_fetch_array($answers);
echo '<tr><td>'.$myrow['question'].': </td><td>';
if($myrow['type']==1)
echo '<input type=text size='.$myrow['cols'].' name="form_q['.$myrow['id'].'][]" value="'.$answer['answer'].'">';
if($myrow['type']==2)
echo '<textarea cols='.$myrow['cols'].' rows='.$myrow['rows'].' name="form_q['.$myrow['id'].'][]">'.$answer['answer'].'</textarea>';



echo '</td></tr>';
}
?>
<tR><td>Password: </td><td><input type="password" name="form_password" value="encrypted"></td></tr>
<tR><td>User Level: </td><td><input type="text" name="form_access_level" value="<?php echo $edituser['access_level']; ?>"></td></tr></table>
<input type="hidden" name="form_id" value="<?php echo $edituser['id']; ?>">
<input type="submit" name="subEditUser" Value="Submit">
</form>
<?php
}
?>