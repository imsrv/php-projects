<?
/* TH-Rotating Banner Ad is copyright toddhost.com
   You may use this script free as long as you do not remove this notice
   or the link to our website.
*/
echo "<form action=$PHP_SELF method=post><input type=submit name=act value=install></form><br>";
echo "<center>Click the view button to see the banners in your database.<br><form action=$PHP_SELF method=post><input type=submit name=act value=view></form><br>";
echo "Enter the address to the image and the link address.<br><form action=$PHP_SELF method=post> <b>Banner: <input type=text name=banner value=http://> <b>Link: <input type=text name=link value=http://> <input type=submit name=act value=insert_ban></form><br>";
include("config.php");
if($act == "install"){
  $Create_Query =
  "CREATE TABLE banner (".
  "ID     int(11)       DEFAULT '' NOT NULL auto_increment, ".
  "banner     varchar(255)  DEFAULT '', ".
  "link     varchar(255)  DEFAULT '', ".
  "shown     int(11)  DEFAULT '0', ".
  "PRIMARY KEY (ID))";

  if (!@MySQL_Query($Create_Query, $dbID)):
    echo "<FONT SIZE=5>Error:</FONT><BR><BR>";
    echo "Unable to create the members table in $DBase.";
    exit;
  endif;
echo "Table created";
}
if($act == "insert_ban"){
$query = "select * from banner where shown > 0";
$result = mysql_query($query);
$num_row = mysql_num_rows($result);
if($num_row == 0){$shown = "1";}else{$shown = "0";}
$query = "INSERT INTO `banner` ( `ID` , `banner` , `link` , `shown` ) VALUES ( '', '$banner', '$link', '$shown')";
$result = mysql_query($query);
if (!$result){echo"Error: banner not added.";exit;}
echo "Banner has been added.";
}
if($act == "view"){
$query = "select * from banner where 1";
$result = mysql_query($query);
while($myrow = mysql_fetch_array($result)){
         echo "<p><img src=";
         echo $myrow["banner"] ;
         echo "><br>Link: ";
         echo $myrow["link"];
         echo "<br>Banner: ";
         echo $myrow["banner"];
         echo "  <a href=$PHP_SELF?act=delete&ID=";
         echo $myrow["ID"];
         echo ">[Delete]</a>";
         echo "</p>";
         }
}
if($act=="delete"){
$query = "delete from banner where ID = '$ID'";
$result = mysql_query($query);
if ($result){echo "Banner has been deleted.";}
}
?>
