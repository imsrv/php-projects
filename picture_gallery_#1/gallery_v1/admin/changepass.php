<?
if (!ini_get('register_globals')) 
   {
       $types_to_register = array('GET','POST','COOKIE','SESSION','SERVER');
       foreach ($types_to_register as $type)
       {
           if (@count(${'HTTP_' . $type . '_VARS'}) > 0)
           {
               extract(${'HTTP_' . $type . '_VARS'}, EXTR_OVERWRITE);
           }
       }
   }

session_start();
if(!session_is_registered("auth"))
	header ("Location: index.php");

include ("include/header.php");
$lold_password = "Old password";
$lnew_password = "New password";
$lrnew_password = "Retype new password";
$lbtn_confirm = "Change";
$lbtn_cancel    = "Clear";
$passerrors = array("Your password was not changed!","Your password was changed!","The old password is incorect! Please type the correct password and try again","Please type the same new password in both fields");
$lchangepass = "Change password";

?>
<form action="updatepassword.php" method="post" name="change">
<table cellspacing="15" cellpadding="0" align="center" border="0">
<tr>
	<td class="title" valign="top" align="center"><?=$lchangepass?></td>
</tr>
<tr><td><img src="images/pixel.gif" width="1" height="30" border="0"></td></tr>
<tr>
	<td>
	<table cellspacing="0" cellpadding="0" align="center" border="0">
    <tr>
    	<td class="textblack11b"><?=$lold_password?></td>
		<td rowspan="5"><img src="images/pixel.gif" width="10" height="1" border="0"</td>
		<td><input type="password" name="oldp" id="oldp" size="25" class="textBox" onFocus="this.style.backgroundColor='#ffffff'" onBlur="this.style.backgroundColor='#f5f5f5'"></td>
	</tr>
	<tr><td><img src="images/pixel.gif" width="1" height="5" border="0"</td></tr>
	<tr>
		<td class="textblack11b"><?=$lnew_password?></td>
		<td><input type="password" name="newp" id="newp" size="25" class="textBox" onFocus="this.style.backgroundColor='#ffffff'" onBlur="this.style.backgroundColor='#f5f5f5'"></td>
	</tr>
	<tr><td><img src="images/pixel.gif" width="1" height="5" border="0"</td></tr>
	<tr>
		<td class="textblack11b"><?=$lrnew_password?></td>
		<td><input type="password" name="rnewp" id="rnewp" size="25" class="textBox" onFocus="this.style.backgroundColor='#ffffff'" onBlur="this.style.backgroundColor='#f5f5f5'"></td>
    </tr>
	<tr><td colspan="2"><img src="images/pixel.gif" width="1" height="10" border="0"</td></tr>
	<tr>
		<td align="right" colspan="3">
			<table cellspacing="0" cellpadding="0" border="0">
            <tr>
            	<td><input type="submit" value="<?=$lbtn_confirm?>" class="textBox"></td>
				<td><img src="images/pixel.gif" width="10" height="1" border="0"</td>
				<td><input type="reset" value="<?=$lbtn_cancel?>" class="textBox"></td>
            </tr>
            </table>
		</td>
	</tr>
	<tr><td colspan="2"><img src="images/pixel.gif" width="1" height="10" border="0"</td></tr>
    </table>
	</td>
</tr>
<?
if(isset($err)){
	echo "<tr><td class=\"error\" colspan=\"2\" align=\"center\">" . $passerrors[$err] . "</td></tr>";
}
?>
</table>
</form>
<?
include ("include/bottom.php");
?>
