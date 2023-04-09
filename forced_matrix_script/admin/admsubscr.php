<?
/* nulled by [GTT] :) */ 
@session_start();
if(session_is_registered("admin"))
{include("functions.php");
include ('header.php');
db_connect();
admin_menu();
 if ($editid)
 {
  if ($updateid)
   mysql_query("update subscribtions set name='$name', description='$description', duration='$duration', signupfee='$signupfee', reoccuringfee ='$reoccuringfee' where id='$updateid'");
  display_subscribtion_form($editid);
  echo "<a href=admsubscr.php>Back</a>";
 }
 else if ($codeid)
 {
  display_code($codeid, "subscr");
  echo "<a href=admsubscr.php>Back</a>";
 }
 else
 {
  if ($add&&$name&&$duration&&$reoccuringfee )
   $res=mysql_query("insert into subscribtions (id, name, description, duration, signupfee, reoccuringfee ) values ('', '$name', '$description', '$duration', '$signupfee', '$reoccuringfee ')") or die(mysql_error());
  else if ($delid)
  mysql_query("delete from subscribtions where id='$delid'");
   display_subscribtions();
  echo "<br><br><center><font size=\"3\">Setup new subscribtion here</font></center>";
  display_subscribtion_form("");

 }

?>
<div align="center"><br>
</div>
<form method="post" action="adminlogin.php">
  <div align="center">
    <input type="submit" name="Submit" value="Click here to return to Main Menu">
  </div>
</form>
<div align="center">
  <?
}
else echo "You are not logged in!";

function display_subscribtion_form($id)
{
if ($id)
 $subscribtion=db_result_to_array("select * from subscribtions where id='$id'");
?>
</div>
<form  action=admsubscr.php method=post>
  <?
if (!$id) echo "<input type=hidden name =add value=true>";
else echo "<input type=hidden name =editid value=\"$id\"> <input type=hidden name =updateid value=\"$id\">";
?>
  <div align="center">
    <table width="727" border="0" align="center" cellpadding="0" cellspacing="10">
      <tr>
        <td width="20%" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subscribtion
          Name</font></td>
        <td width="80%"><input name="name" type="name" id="name" value="<?echo $subscribtion[0]['name'];?>"></td>
      </tr>
      <tr>
        <td width="20%" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subscribtion
          Description</font></td>
        <td width="80%"><input name="description" type="name" id="description" value="<?echo $subscribtion[0]['description'];?>"></td>
      </tr>
      <tr>
        <td align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sign
          up Fee</font></td>
        <td><input name="signupfee" type="text" size="10" maxlength="10" value="<?echo $subscribtion[0]['signupfee'];?>">
          Leave Blank if None. If entering an amount do not use $ a dollar sign
        </td>
      </tr>
      <tr>
        <td align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Duration
          (In days)</font></td>
        <td><input name="duration" type="text" size="10" maxlength="10" value="<?echo $subscribtion[0]['duration'];?>"></td>
      </tr>
      <tr>
        <td align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Re-uccuring
          Fee</font></td>
        <td><input name="reoccuringfee" type="text" size="10" maxlength="10" value="<?echo $subscribtion[0]['reoccuringfee'];?>">
          Do not put any $ Dollar Signs, enter only a number like 5.00</td>
      </tr>
      <tr>
        <td align="center"> </td>
        <td> </td>
      </tr>
      <tr>
        <td align="center"> </td>
        <td><input name="create" type="submit" id="create" value="<?if ($id) echo "Edit"; else echo "Add new";?> product"></td>
      </tr>
    </table>
  </div>
</form>
<div align="center">
  <?
}
?>
</div>