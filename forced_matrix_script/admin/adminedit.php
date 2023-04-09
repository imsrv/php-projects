<?php
/* nulled by [GTT] :) */    

@session_start();

if(session_is_registered("admin"))

{

include("functions.php");
include("header.php");
db_connect();

if(@$update){

mysql_query("update admininfo set name='$name',password='$password',email='$email'");}

$result=mysql_query("select * from admininfo");

$result=mysql_fetch_array($result);?>

<?admin_menu();?><center>
<form action="adminedit.php">
  <div align="center">
    <input type="hidden" name="update" value="1">
    <table width="727" border="0" align="center">
      <tr>
        <td width="101">&nbsp;</td>
        <td width="187">Current:</td>
        <td width="396">Update to:</td>
      </tr>
      <tr>
        <td width="101">Username:</td>
        <td width="187"><b><?echo $result['name']?></b></td>
        <td width="396"> <input type="text" name="name" size="30" maxlength="250" value="<?echo $result['name']?>">
        </td>
      </tr>
      <tr>
        <td width="101">&nbsp;</td>
        <td width="187"><b></b></td>
        <td width="396">&nbsp;</td>
      </tr>
      <tr>
        <td width="101">Email:</td>
        <td width="187"><b><?echo $result['email']?></b></td>
        <td width="396"> <input type="text" name="email" size="30" maxlength="100" value="<?echo $result['email']?>">
        </td>
      </tr>
      <tr>
        <td width="101">&nbsp;</td>
        <td width="187">&nbsp;</td>
        <td width="396">&nbsp;</td>
      </tr>
      <tr>
        <td width="101">Password:</td>
        <td width="187"><b><?echo $result['password']?></b></td>
        <td width="396"> <input type="text" name="password" size="12" maxlength="50" value="<?echo $result['password']?>">
        </td>
      <tr align="center">
        <td colspan="3"><br> <br> <br> <input type="submit" value="Update Details">
        </td>
      </tr>
    </table>
  </div>
</form>
<div align="center"><br>
</div>
<form method="post" action="adminlogin.php">
  <div align="center">
    <input type="submit" name="Submit" value="Click here to return to Main Menu">
  </div>
</form>
<div align="center"><center>
  <?}

else echo "You are not logged in!";

?>
</div>
