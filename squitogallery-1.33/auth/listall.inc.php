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
if($_SESSION['auth']==1 && $_SESSION['level']>199)
{

if(isset($_POST['subDelUser']))
{
$deluser = $_POST['form_delete'];
if(is_array($deluser))
foreach($deluser as $value)
{
if($value!=1)
{
$db=dbConnect();
$query = 'DELETE from authorization where id = "'.$value.'"';
mysql_query($query, $db);
mysql_close();

}
}
}
?>

<script language = "JavaScript">
<!-- Begin hiding here --
function doSomething(userName)
{
if(confirm("Are you sure you want to delete \""+userName+"\" from the database?"))
{
document.delUser.submit();
}
}
// -- End hiding here -->
</script>
<script language="JavaScript">
   <!--
   function CheckAll()
   {
      for (var i=0;i<document.delUser.elements.length;i++)
      {
         var e = document.delUser.elements[i];
         if (e.name != "allbox")
            e.checked = document.delUser.allbox.checked;
      }
   }
   //-->
</script>
<form name="delUser" method="post" action="admin.php?menu=listall" onsubmit="confirm('Are you sure you want to delete user(s)?')">

<table border="0" cellspacing="0" cellpadding="5">
  <tr bgcolor="#000066">
    <td>
      <div align="center"><b><font color="#FFFFFF">User Id</font></b></div>
    </td>
    <td>
      <div align="center"><b><font color="#FFFFFF">Name</font></b></div>
    </td>
    <td>
   <div align="center"><b><font color="#FFFFFF">Access Level</font></b></div>
    </td>
        <td bgcolor="#CCCCCC">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B>All:<input name="allbox" type="checkbox" value="1"
   onClick="CheckAll();"></B><input type="Submit" NAME="subDelUser" value="Delete"></td>
  </tr>
  <?php
  $db = dbConnect();
  $query = 'select * from authorization order by name asc';
  $result = mysql_query($query, $db);
  while($myrow=mysql_fetch_array($result))
  {
  echo '<tr><td bgcolor="#DDDDDD">'.$myrow['id'].'</td><td>'.$myrow['name'].'</td><td bgcolor="#DDDDDD">'.$myrow['access_level'].'</td><td><a href="admin.php?menu=edituser&form_user='.$myrow['id'].'">Edit</a> | <input type=checkbox name="form_delete[]" value="'.$myrow['id'].'"> Delete</td></tr>'."\n";
  }
  mysql_close();
  ?>
</table>
<input type="hidden" name="form_user">
</form>
<br><BR>
<?php
}
else
{
echo 'You do not have access to this menu';
}
?>