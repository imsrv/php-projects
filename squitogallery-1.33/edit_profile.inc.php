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
if(isset($_POST['subEditUserProfile']))
{

update_profile();
}

?>

<table width="100%" cellpadding="5"><tr>
    <td class="editprofile" align="center" class="sidebox"><B><font color="#FFFFFF">Edit
      Profile</font></b></td>
  </tr></table>

<form name="edtProfile" method="post" action="">
<br>
  <table width="100%">
  

<tr><td>User Name:</td><td> <?php echo $_SESSION['squitouser']; ?></td></tr>
<tr><td>Email Address:</td><td><input type="text" name="email" value="<?php echo $_SESSION['squitoemail']; ?>"></td></tr>
<?php
$query = 'select * from profile_q';
$result = mysql_query($query,$db);
while($myrow =  mysql_fetch_array($result))
{
$query = 'select * from profile_a where q_id ="'.$myrow['id'] .'" and u_id="'.$_SESSION['squitoid'].'" order by q_id asc';
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
<tR><td>Password: </td><td><input type="password" name="form_password" ></td></tr>
<tR><td>Verify Password: </td><td><input type="password" name="form_password_verify" ></td></tr>
</table>
<input type="hidden" name="form_id" value="<?php echo $edituser['id']; ?>">
<input type="submit" name="subEditUserProfile" Value="Save">
</form>
