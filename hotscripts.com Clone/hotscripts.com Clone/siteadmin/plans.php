<?
include_once("logincheck.php");
include_once("../config.php");
function main()
{


$sql="select * from sbwmd_plans  ";

$rs0_query=mysql_query ($sql);

?><strong>Website plans to buy impressions</strong><br>
<table width="750" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#f5f5f5"> 
    <td width="45"><strong><font size="2" face="Arial, Helvetica, sans-serif">Credits</font></strong></td>
    <td width="135"><strong><font size="2" face="Arial, Helvetica, sans-serif">Price</font></strong></td>
    <td width="123"><strong><font size="2" face="Arial, Helvetica, sans-serif">Edit</font></strong></td>
    <td width="123"><strong><font size="2" face="Arial, Helvetica, sans-serif">Delete</font></strong></td>
  </tr>
  <?
$cnt=0;
while ($rs0=mysql_fetch_array($rs0_query))
{
$cnt++;
?>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif"><? echo  $rs0["credits"]; ?></font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif"><? echo $rs0["price"]; ?></font></td>
    <td><a href="editplan.php?id=<?php echo $rs0["id"]; ?>">Edit</a></td>
    <td><a href="deleteplan.php?id=<?php echo $rs0["id"]; ?>">Delete</a></td>
  </tr>
  <?
 }
 ?>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
<script language="JavaScript">
<!--
function Validate()
{

if (form123.credits.value==''  || isNaN(form123.credits.value) || form123.credits.value<=0  )
{
	alert("Please provide some non-negative numeric value  for credits");
	document.form123.credits.focus();
	return (false);
}
if (form123.price.value==''  || isNaN(form123.price.value) || form123.price.value<=0  )
{
	alert("Please provide some non-negative numeric value  for price");
	document.form123.price.focus();
	return (false);
}


return(true);
}

//-->
</script>

<br>
<form action="insertplan.php" method="post" name="form123" id="form123" onsubmit="return Validate();">
  <div align="center"> <font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
    <?  
	if (IsSet($_REQUEST["msg"]))
	{
	   echo $_REQUEST["msg"];
	}
	
	?>
    </font><br>
    <table width="518" border="0" cellspacing="10" cellpadding="0">
      <tr bgcolor="#666666"> 
        <td height="25" colspan="2"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp;Add 
          New Plan</font></strong></td>
      </tr>
      <tr> 
        <td bgcolor="#f5f5f5"><b><font size="2" face="Arial, Helvetica, sans-serif">Credits 
          :</font></b></td>
        <td> <input name="credits" type="text" size="4" border="0"></td>
      </tr>
      <tr> 
        <td width="248"><b><font size="2" face="Arial, Helvetica, sans-serif">Price 
          :</font></b></td>
        <td width="240"> <input name="price" type="text" size="4" border="0"></td>
      </tr>
      <tr> 
        <td colspan="2" background="images/dots.gif"></td>
      </tr>
      <tr> 
        <td colspan="2"> <div align="center"> 
            <input type="submit" name="submitButtonName" value="Add" border="0">
            <br>
          </div></td>
      </tr>
    </table>
  </div>
</form>
<?
}//main()
include "template.php";
?>

