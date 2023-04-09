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
if (eregi("menu-type-standard.php",$_SERVER['PHP_SELF']))
{
 Header("Location: index.php");
 exit;
}
?>
<center><table width="100%" border="0" cellspacing="4" cellpadding="3" class="table-bg-menu">
<tr>
<form name="M_F" action="get_details.php" method="post">
<input type="hidden" name="the_page">
<?
$handle = opendir('content/');
while($item=readdir($handle))
{
 if (((ereg(".html",$item)>0)||(ereg(".php",$item)>0))AND($item!=INITIAL_PAGE))
 {
  $item_array=explode(".",$item);
  echo "<td><center><small><a onmouseover=\"return showw('$item_array[0]')\" onmouseout=\"clearw()\"
  href=\"javascript:menu('$item')\">$item_array[0]</a></small><center></td>";
 }
}
closedir($handle);
?>
<script language="JavaScript"><!--
function showw(w){window.status=w;return true;}
function clearw(){window.status='';}
function menu(a_page)
{
 with (document.M_F)
 {
  the_page.value=a_page;
  submit();
 }
}
// --></script>
</form>
  </tr>
</table></center>
