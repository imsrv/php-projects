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
if(isset($_POST['subAddUser']))
{
admin_adduser();
}
?>

<table width="400" cellpadding="5"><tr>
    <td bgcolor="#000066" align="center" class="sidebox"><B><font color="#FFFFFF">Add New User</font></b></td>
  </tr></table>
<?php
if(!isset($_SESSION['taken'])) $_SESSION['taken']=0;
if($_SESSION['taken']==1)
echo '<br><h2>Username is taken please try again.</h2>';
?>

<form method="post" action="admin.php?menu=adduser">
<br>
  <table width="400">
<tr><td>Handle:</td><td> <input type="text" name="form_name"></td></tr>
<?php
$db=dbConnect();
$query = 'select * from profile_q';
$result = mysql_query($query,$db);
while($myrow =  mysql_fetch_array($result))
{
echo '<tr><td colspan="2">'.$myrow['question'].'</td></tr><tr><td colspan="2">';
if($myrow['type']==1)
echo '<input type=text size='.$myrow['cols'].' name="form_q['.$myrow['id'].'][]">';
if($myrow['type']==2)
echo '<textarea cols='.$myrow['cols'].' rows='.$myrow['rows'].' name="form_q['.$myrow['id'].'][]"></textarea>';
echo '</td></tr>';
}
?>
<tr><td colspan="2"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?menu=addquestion">Add question?</a></td></tr>
<tR><td>Password: </td><td><input type="password" name="form_password"></td></tr>
<tR><td>User Level: </td><td><input type="text" name="form_access_level"></td></tr></table>
<input type="hidden" name="form_id" value="$id">
<input type="submit" name="subAddUser" Value="Submit">
</form>