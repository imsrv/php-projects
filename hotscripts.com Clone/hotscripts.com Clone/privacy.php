<? 
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";
function main()
{
?>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" >
  <tr> 
    <td height="25"><font color="#000000"><strong>&nbsp;<a href="index.php"  class="barlink">HOME 
      </a>&gt;PRIVACY</font></strong></font>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td><div align="justify"></div>
      <?
					  $privacy=mysql_fetch_array(mysql_query("select privacy from sbwmd_config"));
					  echo str_replace("\n","<br>",$privacy["privacy"]);
					  ?>
    </td>
  </tr>
</table>


<?
}
include "template.php";
?>
