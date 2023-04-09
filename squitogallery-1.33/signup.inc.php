<?
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
if(isset($_POST['subNewUser']))
{
request_login();
}
function request_login()
{

   $db = dbConnect();
   $sql = 'select * from authorization where name like "' . $_POST['form_name'] . '"';
   $result=mysql_query($sql);
   $myrow = mysql_fetch_array($result);
   if(!$myrow['name']&&$_POST['form_name']&&$_POST['form_password'])
   {
   if(is_uploaded_file($_FILES['form_file']['tmp_name']))
  $imagesql = ",'".$_POST['form_name'].".jpg'";
   else
   $imagesql = ",''";
   $sql = "INSERT INTO authorization (name,email,password,access_level) VALUES ('".$_POST['form_name']."','".$_POST['form_email']."',password('".$_POST['form_password']."'),10)";
   //echo $sql,'<br>';
   MYSQL_QUERY($sql,$db);
   $query = 'select id from authorization where name = "'.$_POST['form_name'].'"';
   //echo $query.'<br>';
   $result = mysql_query($query);
   $newuser = mysql_fetch_array($result);

   $query = 'select * from profile_q order by id asc';
   $result = mysql_query($query,$db);
   while($myrow = mysql_fetch_array($result))
   {
    $query = 'insert into profile_a (u_id,q_id,answer) values ('.$newuser['id'].','.$myrow['id'].',"'.$_POST['form_q'][$myrow['id']][0].'")';
    //echo $query.'<br>';
    mysql_query($query,$db);
   }
   $query = 'select id,private from photodir';
   $result = mysql_query($query, $db);
   while($row = mysql_fetch_array($result))
   {
   if($row['private'])
     $query = 'insert into access (user_id, dir_id, r) values ("'.$newuser['id'].'","'.$row['id'].'","0")';
   else
     $query = 'insert into access (user_id, dir_id, r) values ("'.$newuser['id'].'","'.$row['id'].'","1")';
   mysql_query($query,$db);
   }
   MYSQL_CLOSE();
   $_SESSION['taken']=0;
   $_SESSION['attempt']=0;
   $_SESSION['usercreated'] = 1;
   //header('location: admin.php?menu=listall');
   }
   else{
   MYSQL_CLOSE();
   $_SESSION['taken']=1;
   //header('location: admin.php?menu=adduser');

   }
}
?>
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
function checkPass()
{
 if(document.newuserform.form_password.value)
 {
  if(document.newuserform.form_password.value == document.newuserform.form_vpassword.value)
 document.newuserform.subNewUser.disabled = false;
 }
}   </script>

<table width="100%" cellpadding="5"><tr>
    <td class="signup" align="center" class="sidebox"><B><font color="#FFFFFF">New User Application</font></b></td>
  </tr></table>
<?php
if($_SESSION['taken'])
echo '<br><b>Username is taken please try again.</b>';
if($_SESSION['usercreated'])
{
login_form($_SESSION['redirect']);
exit;
}
?>

<form name="newuserform" method="post" action="index.php?menu=signup">
<br>
  <table width="100%">
<tr><td><?php echo $lang['Username'];?>:</td><td> <input type="text" name="form_name" ></td></tr>
<?php
$db=dbConnect();
$query = 'select * from profile_q';
$result = mysql_query($query,$db);
while($myrow =  mysql_fetch_array($result))
{
echo '<tr><td>'.$myrow['question'].'</td><td>';
if($myrow['type']==1)
echo '<input type=text size='.$myrow['cols'].' name="form_q['.$myrow['id'].'][]">';
if($myrow['type']==2)
echo '<textarea cols='.$myrow['cols'].' rows='.$myrow['rows'].' name="form_q['.$myrow['id'].'][]"></textarea>';
echo '</td></tr>';
}
?>
<tR><td><?php echo $lang['Password'];?>: </td><td><input type="password" name="form_password" onChange="checkPass()"></td></tr>
<tR><td>Verify Password: </td><td><input type="password" name="form_vpassword" onChange="checkPass()"></td></tr>
<?php
if($_SESSION['error'])
echo '<tr><td colspan="2">'.$_SESSION['error'].'</td></tr>';

?>
<tr><td><?php echo $lang['Email'];?>: </td><td><input type="text" name="form_email"></td></tr>
</table>
<input type="hidden" name="form_id" value="<?php echo $id;?>">
<INPUT TYPE="hidden" name="form_userupload" value="1">
<input type="hidden" name="form_imagedir" value="profiles">
<input type="submit" name="subNewUser" Value="Submit" disabled>
</form>
