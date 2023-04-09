<form method="<? echo $method ?>" action="<? echo $SCRIPT_NAME ?>">

<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$query = "Select * from billto where user_id='$PHP_AUTH_USER'";
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
<table width="95%" bgcolor="#FFFFFF" border="0" cellspacing="0">
    <tr>
      <td colspan="2"><p><big>Bill To Information</big></td>
    </tr>
	<? if ($update == "False"){ ?>
    <tr>
      <td colspan="2"><p><big><font color="#ff0000">There was a problem with the form... </big><br>
	  <font color="#0000FF"><? print($message);?></font></font><br></td>
    </tr>
	<? } ?>
    <tr>
      <td colspan="2"><p><font color="#ff0000">Please Note: All fields are required...</font></td>
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
      <td align="left">&nbsp;&nbsp;&nbsp;&nbsp; </td>
      <td align="left"><input name="addr2" size="34" value="<? print($addr2) ?>"> </td>
    </tr>
    <tr>
      <td align="left">City </td>
      <td align="left"><input name="city" size="34" value="<? print($city) ?>"> </td>
    </tr>
    <tr>
      <td align="left">State</td>
      <td align="left"><input name="province" size="34" value="<? print($province) ?>"><br>Please use two character abbr. for US States.</td>
    </tr>
    <tr>
      <td align="left">Zip</td>
      <td align="left"><input name="pcode" size="34" value="<? print($pcode) ?>"> </td>
    </tr>
    <tr>
      <td align="left">Country </td>
      <td align="left"><input name="country" size="34" value="<? print($country) ?>"> </td>
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
	<input type="hidden" name="action" value="Update Bill To Info">
	<input type="submit" value="Continue"><br><br></td>
    </tr>
  </table>
</form>
</center>
