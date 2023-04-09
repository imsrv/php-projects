<?
  include 'common.php';
 $table="banner_stat";
$connection = mysql_connect($DB_SERVER, $DB_LOGIN, $DB_PASSWORD)
          or die ("Couldn't connect to server.");

$db = mysql_select_db($DB, $connection)
         or die ("Couldn't connect to db.");
if(($position==1 || $position==2) && isset($bannerID)){

           $query = "DELETE from $table  WHERE bannerID='$bannerID'";
            $res = mysql_query($query,$connection)
              or die ("Couldn't insert records!");


   header("Location:stat.php?position=$position&info=Process completed!");
   exit();
   } else {
   echo "<h1> No type or banner selected</h1>";
   }
?>