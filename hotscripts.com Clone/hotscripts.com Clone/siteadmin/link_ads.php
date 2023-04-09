<?
include_once("logincheck.php");
include_once("../config.php");
function main()
{


$sql="select * from sbwmd_banners  ";

$rs0_query=mysql_query ($sql);

?> <br>
<a href="add_link.php">Add a banner Ad</a><br>
 <br>
 <font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

</font><br>
<table width="78%" border="0" cellpadding="2" cellspacing="0">
  <tr bgcolor="#f5f5f5"> 
    <td width="4%">&nbsp;</td>
    <td width="67%"><strong><font size="2" face="Arial, Helvetica, sans-serif">Banner 
      Image</font></strong></td>
    <td width="29%"><strong><font size="2" face="Arial, Helvetica, sans-serif">Delete</font></strong></td>
  </tr>
  <?
$cnt=0;
while ($rs0=mysql_fetch_array($rs0_query))
{
$cnt++;
?>
  <tr> 
    <td>&nbsp;</td>
    <td><img src="../<? echo $rs0["img_url"]; ?>"></td>
    <td><a href="link_deletead.php?id=<?php echo $rs0["id"]; ?>">Delete</a></td>
  </tr>
  <?
 }
 ?>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
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
<?
}//main()
include "template.php";
?>
