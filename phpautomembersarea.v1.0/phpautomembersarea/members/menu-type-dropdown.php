<?
/**********************************************************
 *             phpAutoMembersArea                         *
 *           Author:  Seiretto.com                        *
 *    phpAutoMembersArea © Copyright 2003 Seiretto.com    *
 *              All rights reserved.                      *
 **********************************************************
 *        Launch Date:  Dec 2003                          *
 *                                                        *
 *     Version    Date              Comment               *
 *     1.0       15th Dec 2003      Original release      *
 *                                                        *
 *  NOTES:                                                *
 *        Requires:  PHP 4.2.3 (or greater)               *
 *                   and MySQL                            *
 **********************************************************/
$phpAutoMembersArea_version="1.0";
// ---------------------------------------------------------
if (eregi("menu-type-dropdown.php",$_SERVER['PHP_SELF']))
{
 Header("Location: index.php");
 exit;
}
?>
<center>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
  <td class="table-bg-menu" width="100%" height="1"></td>
</tr>
<tr>
  <td class="table-bg-menu" width="100%">
<form name="M_F" action="get_details.php" method="post">
<input type="hidden" name="the_page">
<center><? echo MAIN_MENU_TEXT; ?> <select name="spage" class="dropdownc" onchange="Javascript:menu();">
<?
$handle = opendir('content/');
while($item=readdir($handle))
{
 if (((ereg(".html",$item)>0)||(ereg(".php",$item)>0))AND($item!=INITIAL_PAGE)AND($item[0]!="_"))
 {
  $item_array=explode(".",$item);
  echo "<option value=\"$item\">$item_array[0]</option>";
 }
}
closedir($handle);
?>
</select>
</center>
<script language="JavaScript"><!--
function menu()
{
 with (document.M_F)
 {
  the_page.value=spage.options[spage.selectedIndex].value;
  submit();
 }
}
var previous_spage="<? if (isset($HTTP_POST_VARS['the_page'])) echo $HTTP_POST_VARS['the_page']; ?>";
with (document.M_F)
 for(i=0;i<spage.options.length;i++) if (spage[i].value==previous_spage) spage.selectedIndex=i;
// --></script>
</td>
</tr>
</table>
</center></form>

