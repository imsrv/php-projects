<?
include("header.inc.php");
if($user_rights[delfiles] == "Y")
 {
  if($submit == 1)
   {
    delrelease($release_id);
    echo "<br>done...";
   }
  else
   {
    echo makedialog("Release l�schen?","
         <input type=\"hidden\" name=\"release_id\" value=\"$release_id\">
         Beim l�schen eines Releases werden alle zugeh�rigen Kommentare, Files und Screens
         gel�scht. Wollen sie den Release wirklich l�schen?","  Ja  ","delrelease.php");
   }
 }
else
 { echo "Sie haben keine Berechtigung diese Seite zu sehen"; }
include("footer.inc.php");
?>
