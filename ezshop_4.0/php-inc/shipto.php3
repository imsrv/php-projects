<form method="<? echo $method ?>" action="<? echo $SCRIPT_NAME ?>">
<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$query = "Select fname from shipto where user_id='$PHP_AUTH_USER'";
$select = mysql($database,$query);

if(mysql_result($select,0,"fname") == ""){
	$query = "Select * from billto where user_id='$PHP_AUTH_USER'";
}else{
	$query = "Select * from shipto where user_id='$PHP_AUTH_USER'";
}

$select = mysql($database,$query);
print(mysql_error());
$go = mysql_numrows($select);
if($go >0){
$fname=mysql_result($select,0,"fname");
$lname=mysql_result($select,0,"lname");
$addr1=mysql_result($select,0,"addr1");
$addr2=mysql_result($select,0,"addr2");
$city=mysql_result($select,0,"city");
$province=mysql_result($select,0,"province");
$country=mysql_result($select,0,"country");
$pcode=mysql_result($select,0,"pcode");
$phone=mysql_result($select,0,"phone");
$fax=mysql_result($select,0,"fax");
$email=mysql_result($select,0,"email");
}
include("topnavbar.php3");
EchoFormVars();
?>
<center>
<table width="95%"  bgcolor="#FFFFFF" border="0" cellspacing="0">
	<? if ($update == "False"){ ?>
    <tr>
      <td colspan="2"><p><big><blink><font color="#ff0000">There was a problem with the form... </blink></big><br>The error message is displayed below...</p>
	 <p><font color="#0000FF"><? print($message);?></font><br>We have filled out the form using your Bill To information.. if this is okay, please press the continue button below.</font><br></p></td>
    </tr>
	<? } ?>
    <tr>
      <td align="left" colspan="2"><p><big>Ship To Information</big></p></td>
    </tr>
    <tr>
      <td align="left" colspan="2"><p>Shipping Charges are based on the shipping destination. Your Order will be sent to the Address below. When you have finished filling out this form, press the continue button.</p>
	  <p>Please remember... we can not ship to all states! If shipping destination is one of the restricted states, we will not be able to complete your order!</td>
    </tr>
    <tr>
      <td align="left"><br>First Name </td>
      <td align="left"><br><input name="fname" size="34" value="<? print($fname) ?>"> </td>
    </tr>
    <tr>
      <td align="left">Last Name</td>
      <td align="left"><input name="lname" size="34" value="<? print($lname) ?>"></td>
    </tr>
    <tr>
      <td align="left">Address </td>
      <td align="left"><input name="addr1" size="34" value="<? print($addr1) ?>"> </td>
    </tr>
    <tr>
      <td align="left">Address 2</td>
      <td align="left"><input name="addr2" size="34" value="<? print($addr2) ?>"> </td>
    </tr>
    <tr>
      <td align="left">City </td>
      <td align="left"><input name="city" size="34" value="<? print($city) ?>"> </td>
    </tr>
    <tr>
      <td align="left">State</td>
      <td align="left"><SELECT SIZE=1 NAME="province">
<OPTION VALUE="">Select State
<OPTION VALUE="AK" <? if($province == "AK"){ echo "Selected";}?>>AK
<OPTION VALUE="AR" <? if($province == "AR"){ echo "Selected";}?>>AR
<OPTION VALUE="AZ" <? if($province == "AZ"){ echo "Selected";}?>>AZ
<OPTION VALUE="CA" <? if($province == "CA"){ echo "Selected";}?>>CA
<OPTION VALUE="CO" <? if($province == "CO"){ echo "Selected";}?>>CO
<OPTION VALUE="CT" <? if($province == "CT"){ echo "Selected";}?>>CT
<OPTION VALUE="DC" <? if($province == "DC"){ echo "Selected";}?>>DC
<OPTION VALUE="DE" <? if($province == "DE"){ echo "Selected";}?>>DE
<OPTION VALUE="IA" <? if($province == "IA"){ echo "Selected";}?>>IA
<OPTION VALUE="ID" <? if($province == "ID"){ echo "Selected";}?>>ID
<OPTION VALUE="IL" <? if($province == "IL"){ echo "Selected";}?>>IL
<OPTION VALUE="IN" <? if($province == "IN"){ echo "Selected";}?>>IN
<OPTION VALUE="KS" <? if($province == "KS"){ echo "Selected";}?>>KS
<OPTION VALUE="LA" <? if($province == "LA"){ echo "Selected";}?>>LA
<OPTION VALUE="MA" <? if($province == "MA"){ echo "Selected";}?>>MA
<OPTION VALUE="MD" <? if($province == "MD"){ echo "Selected";}?>>MD
<OPTION VALUE="ME" <? if($province == "ME"){ echo "Selected";}?>>ME
<OPTION VALUE="MI" <? if($province == "MI"){ echo "Selected";}?>>MI
<OPTION VALUE="MN" <? if($province == "MN"){ echo "Selected";}?>>MN
<OPTION VALUE="MO" <? if($province == "MO"){ echo "Selected";}?>>MO
<OPTION VALUE="MS" <? if($province == "MS"){ echo "Selected";}?>>MS
<OPTION VALUE="MT" <? if($province == "MT"){ echo "Selected";}?>>MT
<OPTION VALUE="ND" <? if($province == "ND"){ echo "Selected";}?>>ND
<OPTION VALUE="NE" <? if($province == "NE"){ echo "Selected";}?>>NE
<OPTION VALUE="NH" <? if($province == "NH"){ echo "Selected";}?>>NH
<OPTION VALUE="NM" <? if($province == "NM"){ echo "Selected";}?>>NM
<OPTION VALUE="NV" <? if($province == "NV"){ echo "Selected";}?>>NV
<OPTION VALUE="NY" <? if($province == "NY"){ echo "Selected";}?>>NY
<OPTION VALUE="OH" <? if($province == "OH"){ echo "Selected";}?>>OH
<OPTION VALUE="OK" <? if($province == "OK"){ echo "Selected";}?>>OK
<OPTION VALUE="OR" <? if($province == "OR"){ echo "Selected";}?>>OR
<OPTION VALUE="PA" <? if($province == "PA"){ echo "Selected";}?>>PA
<OPTION VALUE="RI" <? if($province == "RI"){ echo "Selected";}?>>RI
<OPTION VALUE="SC" <? if($province == "SC"){ echo "Selected";}?>>SC
<OPTION VALUE="SD" <? if($province == "SD"){ echo "Selected";}?>>SD
<OPTION VALUE="TX" <? if($province == "TX"){ echo "Selected";}?>>TX
<OPTION VALUE="VA" <? if($province == "VA"){ echo "Selected";}?>>VA
<OPTION VALUE="VT" <? if($province == "VT"){ echo "Selected";}?>>VT
<OPTION VALUE="WA" <? if($province == "WA"){ echo "Selected";}?>>WA
<OPTION VALUE="WI" <? if($province == "WI"){ echo "Selected";}?>>WI
<OPTION VALUE="WV" <? if($province == "WV"){ echo "Selected";}?>>WV
<OPTION VALUE="WY" <? if($province == "WY"){ echo "Selected";}?>>WY
</SELECT>
</td>
    </tr>
    <tr>
      <td align="left">Zip</td>
      <td align="left"><input name="pcode" size="34" value="<? print($pcode) ?>"> </td>
    </tr>
    <tr>
      <td align="left">Country </td>
      <td align="left"><input type="hidden" name="country" value="USA">USA </td>
    </tr>
    <tr>
      <td align="left">Telephone </td>
      <td align="left"><input name="phone" size="34" value="<? print($phone) ?>"> </td>
    </tr>
    <tr>
      <td align="left">Fax</td>
      <td align="left"><input name="fax" size="34" value="<? print($fax) ?>"></td>
    </tr>
    <tr>
      <td align="left">Email </td>
      <td align="left"><input name="email" size="34" value="<? print($email) ?>"> </td>
    </tr>
    <tr>
      <td align="center" colspan="2"><br>
	<? if(isset($prev_action)){ ?>
	<input type="hidden" name="prev_action" value="<? print($prev_action) ?>">
	<? } ?>
	<input type="hidden" name="action" value="Update Ship To Info">
	<input type="submit" value="Continue"><br><br></td>
    </tr>
  </table>
</form>
</center>
