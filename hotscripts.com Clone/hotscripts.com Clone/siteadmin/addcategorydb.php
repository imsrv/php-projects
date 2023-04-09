<?

include "logincheck.php";
include_once "../config.php";
function main()
{
if ( isset( $_REQUEST["pid"]))
{
$pid=$_REQUEST["pid"];
}
else
{
$pid=0;
}

$rs_query=mysql_query("Select * from sbwmd_categories where id=" . $pid );
	if ($rs=mysql_fetch_array($rs_query))
	{
	$catname=$rs["cat_name"];
	$category=$rs["id"];
	$cid=$rs["id"];
	}
    else
	{
	$catname="";
	$category=0;
	$cid=0;
	}
    $catpath="";
  	$rs_query=mysql_query("Select * from sbwmd_categories where id=" . $category );

	while ($rs=mysql_fetch_array($rs_query))
    {
    $catpath ="<font size='2' color='darkred'>>&nbsp;</font><a href=\"browsecats.php?cid=" . $rs["id"] . "\"><font size='2' color='darkred' face='Verdana, Arial, Helvetica, sans-serif'>" .$rs["cat_name"]."</a>" . $catpath; 
  	$rs_query=mysql_query("Select * from sbwmd_categories where id=" . $rs["pid"] );
    }

?> 

<SCRIPT language=javascript>
function validate() {
	if (document.frm1.cat_name.value == ''){
		alert('Please enter the category name.');
		return false;
	}
	
	return true;

}
</SCRIPT>
<div align="center">
<form name="frm1" onsubmit="return validate();" method="post" action="insertcategories.php">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#cccccc">
      <tr bgcolor="#CCCCCC"> 
        <td height="32" colspan="4">
<table cellpadding="3">
            <tr> 
              <td><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                &nbsp; <a href="browsecats.php"><font size="2" color="darkred" face="Verdana, Arial, Helvetica, sans-serif">All 
                Categories</font></a> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo  $catpath; ?></font></font></td>
            </tr>
          </table>
          <font color="darkred" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
          </font></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="baseline">&nbsp;</td>
        <td height="20" valign="baseline">&nbsp;</td>
        <td height="20" valign="baseline">&nbsp;</td>
      </tr>
      <tr> 
	  <?
	  $rs_t1=mysql_num_rows(mysql_query("select * from sbwmd_softwares where cid=".$_REQUEST["pid"]));
	if($rs_t1==0)
	{
	  ?>
	   <td width="46%" height="20" align="right" valign="middle"><font color="#004080" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#ff0000">*</font>Enter 
          Category:</strong> </font> </td>
        <td width="20%" height="20" valign="baseline"> <p> 
            <input type="hidden" name="pid" value=<? echo $_REQUEST["pid"];?>>
            <input type="text" name="cat_name">
          </p></td>
        <td width="34%" height="20" valign="baseline"> <input type="submit" name="Submit" value="Submit"> 
        </td>
      <?
	  }
	  else
	  {
	  ?>
	  
	  <td width="46%" height="20" align="left" valign="top" colspan=3><font color="#ff0000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>This 
category contains <? echo $rs_t1;?> Listings. You have to shift all these listings to any other category before adding sub category. </strong> </font> </td>
	 <tr><td><input type="button" name="no2" value="Go Back" onClick="javascript:window.history.go(-1);"></td>
	  </tr>
	  <?
	  }
	  ?>
	  </tr>
    </table>
</form>
</div>
<?
}// end main
include "template.php";
?>