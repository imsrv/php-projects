<?
include("header.inc.php");
if($user_rights[editfiles] == "Y")
 {
  if($submit == 1)
   {
    $release = $db_handler->sql_fetch_array($db_handler->sql_query("SELECT release_id FROM $sql_table[files] WHERE file_id='$file_id'"));
    $release_id = $release[release_id];
    $db_handler->sql_query("DELETE FROM $sql_table[files] WHERE file_id='$file_id'");
    $db_handler->sql_query("DELETE FROM $sql_table[files] WHERE mirror='$file_id'");
    echo "<br>done...<br><a href=\"editrelease.php?release_id=$release_id\">Zur�ck zum Release</a>";
   }
  else
   {
    echo makedialog("Datei l�schen?","
         <input type=\"hidden\" name=\"file_id\" value=\"$file_id\">
         Wenn sie die Datei l�schen, werden auch alle dazugeh�rigen
         Mirrors gel�scht. Wollen sie die Datei l�schen?","  Ja  ","delfile.php");
   }
 }
else
 { echo "Sie haben keine Berechtigung diese Seite zu sehen"; }
include("footer.inc.php");
?>
