<?
/* nulled by [GTT] :) */ 

@session_start();

if(session_is_registered("admin"))

{

include("functions.php");
include ('header.php');

db_connect();

$matrix_deep=db_result_to_array("select matrix_deep from admininfo");

if ($updateid)
if ( ($programid || $subscrid || ($name&&$price&&$description)) && !($programid && ($name&&$price&&$description)) && !($subscrid && ($name&&$price&&$description)) && !($subscrid && $programid) && $directaf)
 {
  for ($i=1; $i<=$matrix_deep[0][0]; $i++)
   mysql_query("update levels_commisions set commission='".$aff_comm[$i]."' where affitem_id=$updateid and level_num=$i");

  $r=mysql_query ("update aff_payments set name='$name',price='$price', description='$description', directaf='$directaf',af1='$af1',af2='$af2',af3='$af3',af4='$af4',af5='$af5',af6='$af6',af7='$af7',complurl='$complurl',recurring='$recurring',sid='$sid',subscrid='$subscrid', programid='$programid' where id='$updateid'") or die(mysql_error());
 }
else echo "<br><center><B>Error: </B>You have to specify either subscribtion or programm, or add another single item and ALL affiliate payments for it!<br><br></center>";

admin_menu();
?>



<center>

 <h3>Payment Settings for Item <?echo "$pid"?></h3>

 <?display_item_form($pid)?>


  <br>



  <form method="post" action="adminlogin.php">

  <input type="submit" name="Submit" value="Click here to return to Main Menu">

</form>

  </center>

  <?}

else echo "You are not logged in";

?>