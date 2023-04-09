<?php
/* nulled by [GTT] :) */ 
@session_start();
if(session_is_registered("admin"))
{include("functions.php");
include ('header.php');
db_connect();
if(@$edit&&@$who!=@$underwho) {mysql_query ("update users set referer='$underwho' where id=$who"); echo "<center></center><br>Done!<br></center>";}
$result=db_result_to_array("select id,frstname,lstname, banclicks, textclicks from users");
?>
<?admin_menu();?>

<CENTER><h1>Shift affiliate downline</h1><h3>Move this affiliate and their downline</h3>

<form action="adm-shift.php">
<input type="Hidden" name="edit" value="1">
<select name="who"><?

for($i=0;$i<count($result);$i++){
$id=$result[$i][0];
$lastname=$result[$i][2];
$firstname=$result[$i][1];
$balance=calc_balance($id);
$clicks=$result[$i][3]+$result[$i][4];
?>
<option value="<?echo $id;?>"><?echo"$id | $firstname $lastname | $clicks clicks | \$$balance earned"?></option>

<?}
?></select><h3>and make them referred by</h3><select name="underwho"><?

for($i=0;$i<count($result);$i++){
$id=$result[$i][0];
$lastname=$result[$i][2];
$firstname=$result[$i][1];
$balance=calc_balance($id);
$clicks=$result[$i][3]+$result[$i][4];
?>
<option value="<?echo $id;?>"><?echo"$id | $firstname | $lastname | $clicks clicks | \$$balance earned"?></option>

<?}?></select><br><br>
<input type="submit" name="shiftdownline" value="Shift this downline now"></form>

  <br>
  <form method="post" action="adminlogin.php">
  <input type="submit" name="Submit" value="Click here to return to Main Menu">
</form>
</CENTER>
<?}
 else echo "You are not logged in";
 ?>
