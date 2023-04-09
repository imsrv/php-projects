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
include('squitofns.inc.php');
$_SESSION['lastpage'] = $_SERVER['REQUEST_URI'];
if($_POST['subNewUser'])
{

if(!$_SESSION['error'])
{
request_login();
if(is_uploaded_file($_FILES['form_file']['tmp_name']))
$uploaded_file =handleupload($_POST['form_imagedir'],$imagemagickpath);

$_SESSION['usercreated'] = 1;
header('Location: http://'..'index.php');
}
else
header("location: http://);

}
?>

<html><head><title>Squito Auth v1.0 - New User Application</title>
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
function checkPass()
{
 if(document.newuserform.form_password.value)
 {
  if(document.newuserform.form_password.value == document.newuserform.form_vpassword.value)
 document.newuserform.subNewUser.disabled = false;
 }
}   </script>

<style type="text/css">
<!--
.bgtable {  border: #000000 solid; border-width: 1px 3px 3px 1px}
body {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #66666}

a {  font-family: Verdana, Arial, Helvetica, sans-serif; color: #009900; text-decoration: none; font-size: 11px }

a:hover {  text-decoration: underline }

td {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #66666}
.sidebox {  border: 1px #000000 solid}
.imagebox {  border: 1px #000000 solid}

.sportsbg {  background-image: url(images/sports.jpg); background-repeat: no-repeat; background-position: left top}

.vertical_line {  background-image: url(/images/spacer_white.gif); background-repeat: repeat-y}
INPUT, SELECT, TEXTAREA         {
 BACKGROUND-COLOR: #CCCCCC;
 BORDER-LEFT: #234D76 solid 1;
 BORDER-RIGHT: #234D76 solid 1;
 BORDER-TOP: #234D76 solid 1;
 BORDER-BOTTOM: #234D76 solid 1;
 COLOR: #000000;
 FONT-FAMILY: Verdana,Geneva,Arial,Helvetica,sans-serif;
 FONT-SIZE: 10px;
 }

-->
</style></head>
<body>
<?php
switch($_GET['menu'])
{

case 'addmug':
form($_SESSION['error']);
break;
default:
?>
<table width="400" cellpadding="5" align="center"><tr>
    <td bgcolor="#000066" align="center" class="sidebox"><B><font color="#FFFFFF">New User Application</font></b></td>
  </tr></table>
<?php
if($_SESSION['taken'])
echo '<br><h2>Username is taken please try again.</h2>';
?>

<form name="newuserform" method="post" action="index.php?menu=signup">
<br>
  <table width="400" align="center">
<tr><td><?php echo $lang['Username'];?></td><td> <input type="text" name="form_name" ></td></tr>
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
<tR><td>Password: </td><td><input type="password" name="form_password" onChange="checkPass()"></td></tr>
<tR><td>Verify Password: </td><td><input type="password" name="form_vpassword" onChange="checkPass()"></td></tr>
<?php
if($_SESSION['error'])
echo '<tr><td colspan="2">'.$_SESSION['error'].'</td></tr>';

?>
<tr><td>Email Address: </td><td><input type="text" name="form_email"></td></tr>
</table>
<input type="hidden" name="form_id" value="$id">
<INPUT TYPE="hidden" name="form_userupload" value="1">
<input type="hidden" name="form_imagedir" value="profiles">
<input type="submit" name="subNewUser" Value="Submit" disabled>
</form>
<?php
}
?>
</body></html>