<?
include_once "../config.php";
include "logincheck.php";
?><div align="center">

    
  <table width="400" border="0" cellpadding="0" cellspacing="0" bordercolor="#cccccc">
    <tr bgcolor="#cccccc"> 
      <td colspan="2"><font color="darkred" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        Delete Platform 
        <?
	$plat=mysql_fetch_array(mysql_query("select * from sbwmd_platforms where id=".$_REQUEST["id"]));
	echo $plat["plat_name"]." ";
	?>
        under Category 
        <?
	$catname=mysql_fetch_array(mysql_query("select cat_name from sbwmd_categories where id=".$plat["cid"]));
	echo $catname[0];
	?>
        </font></td>
    </tr>
    <tr>
      <td height="20" align="left" valign="baseline">&nbsp;</td>
    </tr>
    <tr> 
      <td height="20" align="left" valign="baseline"><font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Do 
        you really want to delete this Platform? </font>
<p></p></td>
    </tr>
    <tr> 
      <td height="20" align="left" valign="baseline"><form name="form2" method="post" action="deleteplat_ad.php">
          <input name="id" type="hidden" id="id" value="<? echo $_REQUEST["id"];?>">
          <input type="button" name="no" value="No" onClick="javascript:window.history.go(-1);" >
          &nbsp;&nbsp;&nbsp; 
          <input type="submit" name="yes" value="Yes" >
        </form></td>
    </tr>
  </table>

</div>
