<?
/* TH-Rotating Banner Ad is copyright toddhost.com
   You may use this script free as long as you do not remove this notice
   or the link to our website.
*/
include("config.php");
$Query = "select ID, banner, link, shown from banner where  shown > 0 " ;
$Result = MySQL_Query($Query);

list($ID, $banner, $link, $shown) = MySQL_Fetch_Array($Result);
               $Query = "select ID, shown from  banner where 1";
               $Result = MySQL_Query($Query);
               list($SID) = MySQL_Fetch_Row($Result);
               $FirstID = $SID;
               do {
               if ($SetShown) {
               $NewShown = $SID;
               $SetShown = false;
               }
               if ($SID == $ID) {
               $OldShown = $SID;
               $SetShown = true;
               }
               }while (list($SID) = MySQL_Fetch_Row($Result));
               if ($SetShown) $NewShown = $FirstID;
               if ($OldShown != $NewShown) {
               $Query = "update banner set    shown = 0 where  ID = $OldShown";
               MySQL_Query($Query);
               $Query = "update banner set    shown = 1 where  ID = $NewShown";
               MySQL_Query($Query);
               }
echo "<a href=$link target=_blank><img src=$banner border=0></a><br><a href=http://www.toddhost.com target=_blank><font size=1>TH-Rotating Banner Ad &copy; ToddHost</font></a><br>";
?>
