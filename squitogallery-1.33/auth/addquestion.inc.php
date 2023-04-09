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
if(isset($_POST['subAddQuestion']))
{
admin_addquestion();
}
?>

<table width="400" cellpadding="5"><tr>
    <td bgcolor="#000066" align="center" class="sidebox"><B><font color="#FFFFFF">Add Question</font></b></td>
  </tr></table>

<form method="post" action="admin.php?menu=addquestion">
<br>
  <table width="400">
  <tr><td>Question: </td><td><input type="text" size="75" name="form_question"></td></tr>
 <tr><td>Type </td><td><select name="form_type" onChange="form.submit()"><option value="1">Text Field
 </option>
<?php if(isset($_POST['form_type'])) $type = $_POST['form_type'];
else $type = 1;?>
 <option value=2 <?php  if($type==2) echo 'SELECTED';?>>Text Box</option></select>
 Cols: <INPUT type="text" name="form_cols" size=3>
 <?php
 if($type==2)
 echo 'Rows: <input type="text" NAME="form_rows">';
 ?>
 </td></tr></table>

<input type="submit" name="subAddQuestion" Value="Submit">
</form>   <br><BR><BR>