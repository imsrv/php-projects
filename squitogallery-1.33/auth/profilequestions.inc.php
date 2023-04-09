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
if($_SESSION['auth'] && $_SESSION['level']>199)
{
   if($_POST['subDelQuestion'])
   {
   $delquestion = $_POST['form_delquestion'];
if(is_array($delquestion))
foreach($delquestion as $value)
{
$db=dbConnect();
$query = 'DELETE from profile_q where id = "'.$value.'"';
mysql_query($query, $db);
$query = 'DELETE from profile_a where q_id = "'.$value.'"';
mysql_query($query, $db);

mysql_close();
}


   }
?>

<script language="JavaScript">
   <!--
   function CheckAll()
   {
      for (var i=0;i<document.delQuestion.elements.length;i++)
      {
         var e = document.delQuestion.elements[i];
         if (e.name != "allbox")
            e.checked = document.delQuestion.allbox.checked;
      }
   }
   //-->
</script>
<table width="400" cellpadding="5"><tr>
    <td bgcolor="#000066" align="center" class="sidebox"><B><font color="#FFFFFF">Add New User</font></b></td>
  </tr></table>
<?php
?>

<form method="post" name="delQuestion" action="admin.php?menu=profilequestions" onsubmit="return confirm('Are you sure you want to delete user(s)?')">
<br>
  <table width="400" cellspacing="0" cellpadding="5"><tr><td colspan="2"></td><td bgcolor="#FFFFFF"><B>Select All:<input name="allbox" type="checkbox" value="1"
   onClick="CheckAll();"></B><input type="Submit" NAME="subDelQuestion" value="Delete"></td></tr>
<?php
$db=dbConnect();
$query = 'select * from profile_q';
$result = mysql_query($query,$db);
while($myrow =  mysql_fetch_array($result))
{
echo '<tr><td colspan="2">'.$myrow['question'].'</td><td bgcolor="#EEEEEE" width="10"></td></tr>';
echo '<tr><td colspan="2">';
if($myrow['type']==1)
echo '<input type=text size='.$myrow['cols'].' name="form_q['.$myrow['id'].'][]">';
if($myrow['type']==2)
echo '<textarea cols='.$myrow['cols'].' rows='.$myrow['rows'].' name="form_q['.$myrow['id'].'][]"></textarea>';
echo '</td><td bgcolor="#EEEEEE" nowrap><a href="admin.php?menu=editquestion">Edit</a> | <input type="checkbox" name="form_delquestion[]" value = "'.$myrow['id'].'"></td></tr>'."\n";
}
?>
<tr><td colspan="3"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?menu=addquestion">Add question?</a></td></tr>

</form>
<?php
}
else
header('Location: ../admin.php');
?>