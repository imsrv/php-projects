<table border="0" cellpadding="0" cellspacing="0" width="95%" height="474" bgcolor="#FFFFFF">
  <tr>
   <td><p align="center"><big><big><script language="php">
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$tbl_bgcolor="#FFFFFF";
$hdr2_bgcolor="#EFEFEF";
$bdy2_bgcolor="#FFFFFF";
print($merchant_name);</script></big></big><br>
    <script language="php">print("Telephone: ".$merchant_phone."<br>");
print("Fax: ".$merchant_fax."<br>");
print("E-Mail: ".$merchant_email."<br>");
</script></td>
    <td width="302" bgcolor="#EFEFEF" valign="top" height="17"><p align="right"><script
    language="php">print($merchant_address."<br>");
print($merchant_city.", ");
print($merchant_province."<br>");
print($merchant_country.", ");
print($merchant_postal_code."<br>");
</script></td>
  </tr>
  <tr>
    <td width="302" height="23" bgcolor="#EFEFEF">&nbsp;</td>
    <td width="302" height="23" bgcolor="#EFEFEF">&nbsp;</td>
  </tr>
  <tr>
	<td width="302" height="23"><p align="center"><big>Date:</big>
	<script language="php">print(date("D M d, Y",time()));</script><big> </big></td>
    <td width="302" height="23"><p align="center"><font color="#FF0000"><big>Invoice # </big><script language="php"> if($action== "Print Invoice"){ print("Print/Fax");}</script></font></td>
  </tr>
  <tr>
    <td width="302" bgcolor="#EFEFEF" height="23"><font size="4"><script language="php">
echo "Account Details for $PHP_AUTH_USER<br>";
if($PHP_AUTH_USER != ""){
$query = "Select * from billto where user_id='$PHP_AUTH_USER'";
$select = mysql($database,$query);
print(mysql_error());
$billto_fname=mysql_result($select,0,"fname");
$billto_lname=mysql_result($select,0,"lname");
$billto_addr1=mysql_result($select,0,"addr1");
$billto_addr2=mysql_result($select,0,"addr2");
$billto_city=mysql_result($select,0,"city");
$billto_province=mysql_result($select,0,"province");
$billto_country=mysql_result($select,0,"country");
$billto_pcode=mysql_result($select,0,"pcode");
$billto_phone=mysql_result($select,0,"phone");
$billto_fax=mysql_result($select,0,"fax");
$billto_email=mysql_result($select,0,"email");
}
</script>

Bill To:</font></td>
<td width="302" bgcolor="#EFEFEF" height="23"><font size="4"><script language="php">
if($PHP_AUTH_USER != ""){
$query = "Select * from shipto where user_id='$PHP_AUTH_USER'";
$select = mysql($database,$query);
$do_shipto = mysql_numrows($select);
print(mysql_error());
$shipto_fname=mysql_result($select,0,"fname");
$shipto_lname=mysql_result($select,0,"lname");
$shipto_addr1=mysql_result($select,0,"addr1");
$shipto_addr2=mysql_result($select,0,"addr2");
$shipto_city=mysql_result($select,0,"city");
$shipto_province=mysql_result($select,0,"province");
$shipto_country=mysql_result($select,0,"country");
$shipto_pcode=mysql_result($select,0,"pcode");
$shipto_phone=mysql_result($select,0,"phone");
$shipto_fax=mysql_result($select,0,"fax");
$shipto_email=mysql_result($select,0,"email");
}
</script>
Ship To:</font></td>
  </tr>
  <tr>
    <td width="302" height="21"><strong>Name:</strong> <script language="php"> print($billto_fname);print(" ".$billto_lname)</script></td>
    <td width="302" height="21"><strong>Name:</strong> <script language="php"> print($shipto_fname);print(" ".$shipto_lname)</script></td>
  </tr>
  <tr>
    <td width="302" height="21"><strong>Address: </strong><script language="php"> print($billto_addr1)</script></td>
    <td width="302" height="21"><strong>Address:</strong> <script language="php"> print($shipto_addr1)</script></td>
  </tr>
  <tr>
    <td width="302" height="17">&nbsp;<script language="php"> print($billto_addr2)</script></td>
    <td width="302" height="17">&nbsp;<script language="php"> print($shipto_addr2)</script></td>
  </tr>
  <tr>
    <td width="302" height="21"><strong>City:</strong> <script language="php"> print($billto_city)</script></td>
    <td width="302" height="21"><strong>City:</strong> <script language="php"> print($shipto_city)</script></td>
  </tr>
  <tr>
    <td width="302" height="21"><strong>State:</strong> <script language="php"> print($billto_province)</script></td>
    <td width="302" height="21"><strong>State:</strong> <script language="php"> print($shipto_province)</script></td>
  </tr>
  <tr>
    <td width="302" height="21"><strong>Zip Code:</strong> <script language="php"> print($billto_pcode)</script></td>
    <td width="302" height="21"><strong>Zip Code:</strong> <script language="php"> print($shipto_pcode)</script></td>
  </tr>
  <tr>
    <td width="302" height="21"><strong>Country:</strong> <script language="php"> print($billto_country)</script></td>
    <td width="302" height="21"><strong>Country:</strong> <script language="php"> print($shipto_country)</script></td>
  </tr>
  <tr>
    <td width="302" height="21"><strong>Email:</strong> <script language="php"> print($billto_email)</script></td>
    <td width="302" height="21"><strong>Email:</strong> <script language="php"> print($shipto_email)</script></td>
  </tr>
  <tr>
    <td width="302" height="21"><strong>Telephone:</strong> <script language="php"> print($billto_phone)</script></td>
    <td width="302" height="21"><strong>Telephone:</strong> <script language="php"> print($shipto_phone)</script></td>
  </tr>
  <tr>
    <td width="302" height="21"><strong>Fax:</strong> <script language="php"> print($billto_fax)</script></td>
    <td width="302" height="21"><strong>Fax:</strong> <script language="php"> print($shipto_fax)</script></td>
  </tr>
  <tr>
    <td width="302" height="21">&nbsp;</td>
    <td width="293" height="21">&nbsp;</td>
  </tr>
  <tr>
    <font size="4"><td width="302" bgcolor="#EFEFEF" height="23"></font><font size="4"><script language="php">
if($PHP_AUTH_USER != ""){
$query = "Select * from payment where user_id='$PHP_AUTH_USER'";
$select = mysql($database,$query);
print(mysql_error());
if(mysql_numrows($select) > 0){
$card_number=mysql_result($select,0,"card_number");
$card_name=mysql_result($select,0,"card_name");
$exp_month=mysql_result($select,0,"exp_month");
$exp_year=mysql_result($select,0,"exp_year");
$pay_method=mysql_result($select,0,"pay_method");
}
}
</script>Payment Information:</font></td>
    <td width="293" bgcolor="#EFEFEF" height="23">&nbsp;</td>
  </tr>
  <tr>
    <td width="302" height="21">Payment Method/Credit Card Type:</td>
    <td width="293" height="21"><script language="php"> print($pay_method)</script>&nbsp;</td>
  </tr>
  <tr>
    <td width="302" height="21">Credit Card Number:</td>
    <td width="293" height="21"><script language="php"> print($card_number)</script>&nbsp;</td>
  </tr>
  <tr>
    <td width="302" height="21">Expiry Date:</td>
    <td width="293" height="21"><script language="php"> print("Month: ".$exp_month); print(" / Year: ".$exp_year) </script>&nbsp; </td>
  </tr>
  <tr>
    <td width="302" height="21">Name on Card:</td>
    <td width="293" height="21"><script language="php"> print($card_name)</script>&nbsp; </td>
  </tr>
  <tr>
    <font size="4"><td width="302" height="21"></font>&nbsp;</td>
    <td width="293" height="21">&nbsp;</td>
  </tr>
  <tr>
    <td width="302" bgcolor="#EFEFEF" height="23"><font size="4">Order Details</font></td>
    <td width="293" bgcolor="#EFEFEF" height="23">&nbsp;</td>
  </tr>
  <tr>
    <td width="595" colspan="2" height="17">&nbsp;</td>
  </tr>
</table>
