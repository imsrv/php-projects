<?
  include 'common.php';
 $table="banners";
$connection = mysql_connect($DB_SERVER, $DB_LOGIN, $DB_PASSWORD)
          or die ("Couldn't connect to server.");

$db = mysql_select_db($DB, $connection)
         or die ("Couldn't connect to db.");
if($value=='true')
  $act="false";
  else
  $act="true";

           $query = "UPDATE  $table SET active='$act' WHERE bannerID='$bannerID'";
            $res = mysql_query($query,$connection)
               or die ("Couldn't insert records!");

    header("Location:admin.php?position=$position&info=Activation Completed");
   exit();
?>