<?
include_once "logincheck.php";
include_once "../config.php";

?>
<?
if ( isset($_REQUEST["msg"])&&$_REQUEST['msg']<>"")
{
?>
<br>
<table align="center" bgcolor="#FEFCFC"   border="0" cellpadding="5" >
  <tr> 
    <td><b><font face="verdana, arial" size="1" color="#666666"> 
      <?
print($_REQUEST['msg']); 

?>
      </font></b></td>
  </tr>
</table>
<?
}//end if
?>
   
<p>&nbsp;</p><table width="90%" border="0" align="left" cellpadding="4" cellspacing="0">
  <tr bgcolor="#cccccc"> 
    <td colspan="4"><font color="darkred" size="2" face="Verdana, Arial, Helvetica, sans-serif">Platforms for Category  
	<?
	$catname=mysql_fetch_array(mysql_query("select cat_name from sbwmd_categories where id=".$_REQUEST["cid"]));
	echo $catname[0];
	?></font></td>
  </tr>
  <?
					   $cnt=1;
					   $rs_query_t=mysql_query("select * from sbwmd_platforms where cid=".$_REQUEST["cid"]);
                        while($rs_t=mysql_fetch_array($rs_query_t))
						{
	  ?>
  
  <tr> 
    <td width="6%"><img src="images/space.gif" height="8" width="35"></td>
    <td width="39%" align="left" valign="top"> <div align="left"><font color="#0033FF" size="2" face="Arial, Helvetica, sans-serif"><? echo $rs_t["plat_name"] ;?></font></div></td>
    <td width="13%" align="center"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><a href="delete_plat.php?id=<? echo $rs_t["id"];?>">Remove</a></font></font></div></td>
    <td align="center"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><a href="editplat.php?id=<? echo $rs_t["id"];?>">Edit</a></font></font><font size="1"></font></font></div></td>
  </tr>
  <?
$cnt++;
  }
 ?>
  <tr> 
    <td colspan=4> 
      <? if($cnt<=1)
	{
	?>
      <div align="center"><font color="#FF0000" size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>There 
        is not any Platform in this category</strong> </font> </div>
      <?
	}?>
    </td>
  </tr>
  <tr> 
    <td colspan="4"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="add_platform.php?cid=<? echo $_REQUEST["cid"];?>"><strong>Add 
        New Platform</strong></a></font> </div></td>
  </tr>
</table>


