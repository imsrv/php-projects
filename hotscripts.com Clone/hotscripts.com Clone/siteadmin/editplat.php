<?
include_once "../config.php";
include "logincheck.php";
?>

<SCRIPT language=javascript>
function validate() {
	if (document.frm1.plat_name.value == ''){
		alert('Please enter the platform name.');
		return false;
	}
	
	return true;

}
	
</SCRIPT>
<div align="center">
<form name="frm1" onsubmit="return validate();" method="post" action="update_plat.php">
    <table width="400" border="0" cellpadding="0" cellspacing="0" bordercolor="#cccccc">
      <tr bgcolor="#cccccc"> 
        <td colspan="4"><font color="darkred" size="2" face="Verdana, Arial, Helvetica, sans-serif">
		Edit Platform 
		 <?
	$plat=mysql_fetch_array(mysql_query("select * from sbwmd_platforms where id=".$_REQUEST["id"]));
	echo $plat["plat_name"]." ";
	?>for Category
          <?
	$catname=mysql_fetch_array(mysql_query("select cat_name from sbwmd_categories where id=".$plat["cid"]));
	echo $catname[0];
	?>
          </font></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="baseline">&nbsp;</td>
        <td height="20" valign="baseline">&nbsp;</td>
        <td height="20" valign="baseline">&nbsp;</td>
      </tr>
      <tr> 
        <td width="46%" height="20" align="right" valign="middle"><font color="#004080" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#ff0000">*</font>Enter 
          Platform:</strong> </font> </td>
        <td width="20%" height="20" valign="baseline"> <p> 
            <input type="hidden" name="id" value=<? echo $_REQUEST["id"];?>>
            <input type="text" name="plat_name" value=<? echo $plat["plat_name"];?>>
          </p></td>
        <td width="34%" height="20" valign="baseline"> <input type="submit" name="Submit" value="Submit"> 
        </td>
      </tr>
    </table>
</form>
</div>
