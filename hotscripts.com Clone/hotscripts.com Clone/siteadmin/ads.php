<?
include_once("logincheck.php");
include_once("../config.php");
function main()
{


$sql="select * from sbwmd_ads  ";

$rs0_query=mysql_query ($sql);

?><strong>Website plans to buy impressions</strong><br><br><a href="addad.php">Add a banner Ad</a><br>
 <br>
 <font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
<?  
	if (IsSet($_REQUEST["msg"]))
	{
	   echo $_REQUEST["msg"];
	}
	
	?>
</font><br>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr bgcolor="#000000"> 
    <td width="19%"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Url</font></strong></td>
    <td width="17%"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Email</font></strong></td>
    <td width="8%"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Credits</font></strong></td>
    <td width="7%"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Displays</font></strong></td>
    <td width="7%"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Balance</font></strong></td>
    <td width="6%"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Paid</font></strong></td>
    <td width="8%"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Approved</font></strong></td>
    <td width="9%"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Send 
      Stats</font></strong></td>
    <td width="4%"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Edit</font></strong></td>
    <td width="15%"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Delete</font></strong></td>
  </tr>
  <?
$cnt=0;
while ($rs0=mysql_fetch_array($rs0_query))
{
$cnt++;
?>
  <tr> 
    <td bgcolor="#F3F3F3"><font size="2" face="Arial, Helvetica, sans-serif"><? echo  $rs0["url"]; ?></font></td>
    <td bgcolor="#F3F3F3"><a href="email.php?id=<? echo $rs0["email"];?>"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $rs0["email"]; ?></font></a></td>
    <td bgcolor="#F2F2F2"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $rs0["credits"]; ?></font></td>
    <td bgcolor="#F2F2F2"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $rs0["displays"]; ?></font></td>
    <td bgcolor="#F2F2F2"><font size="2" face="Arial, Helvetica, sans-serif"><? echo ($rs0["credits"]-$rs0["displays"]); ?></font></td>
    <td bgcolor="#F2F2F2"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $rs0["paid"]; ?></font></td>
    <td bgcolor="#F2F2F2"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $rs0["approved"]; ?></font></td>
    <td bgcolor="#CCCCCC"><a href="sendstats.php?id=<?php echo $rs0["id"]; ?>">Send</a></td>
    <td bgcolor="#CCCCCC"><a href="editad.php?id=<?php echo $rs0["id"]; ?>">Edit</a></td>
    <td bgcolor="#CCCCCC"><a href="deletead.php?id=<?php echo $rs0["id"]; ?>">Delete</a></td>
  </tr>
  <?
 }
 ?>
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
