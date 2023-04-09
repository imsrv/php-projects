<?
if (file_exists("include/config.inc.php")) { include("include/config.inc.php"); }
else  { header ("Location:include/chooselang.php"); }

require("include/fonction.php");
require("include/cls.php");

$news = new newsletter; 


// Get the newsletter config
$news->get_config($f_host,$f_db,$f_user,$f_passwd,$f_tableconfig); 

$sql1="ALTER TABLE $news->tablenews ADD `hash` VARCHAR(255) NOT NULL"; 
$sql2="ALTER TABLE $news->tabletemp ADD `hash` VARCHAR(255) NOT NULL"; 


mysql_db_query($news->db,$sql1) or die ("Error in $sql1".MYSQL_ERROR());
mysql_db_query($news->db,$sql2) or die( MYSQL_ERROR());




$sql3="SELECT email from $news->tablenews";

$result= mysql_db_query($news->db,$sql3) or die ("Error in $sql3".MYSQL_ERROR());

while($row = mysql_fetch_array($result)) 
{
  $email= $row["email"];
  $hash = unique_id();
  $sql4 = "UPDATE $news->tablenews set hash = '$hash' WHERE email='$email'";
   mysql_db_query($news->db,$sql4) or die ("Error in $sql4".MYSQL_ERROR());
}


print ("Update successfull | Mise à jour effectuée");

?>