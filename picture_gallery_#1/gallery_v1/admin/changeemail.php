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
$lines = file('files/adminmail.php');

array_splice($lines,0,1);
array_splice($lines,count($lines)-1);

$email = $lines[0];
$lchangeemail = "Change Admin Email";
$lsetemail = "Your email is:";
$lchangebtn="Change";
$lclearbtn = "Clear";
$emailerror = array("Your email was not changed!","Your email was changed!");
?>
<form action="updateemail.php" method="post" name="change">
<table cellspacing="15" cellpadding="0" align="center" border="0">
<tr>
	<td class="title" valign="top" align="center"><?=$lchangeemail?></td>
</tr>
<tr><td><img src="images/pixel.gif" width="1" height="20" border="0"></td></tr>
<tr>
	<td>
	<table cellspacing="0" cellpadding="0" align="center" border="0">
    <tr>
    	<td class="textblack11b"><?=$lsetemail?></td>
		<td rowspan="5"><img src="images/pixel.gif" width="10" height="1" border="0"</td>
		<td><input type="text" name="oldp" id="oldp" size="25" class="textBox" onFocus="this.style.backgroundColor='#ffffff'" onBlur="this.style.backgroundColor='#f5f5f5'" value="<?echo $email?>"></td>
	</tr>
	<tr><td><img src="images/pixel.gif" width="1" height="5" border="0"</td></tr>
	<tr>
		<td align="right" colspan="3">
			<table cellspacing="0" cellpadding="0" border="0">
            <tr>
            	<td><input type="submit" value="<?=$lchangebtn?>" class="textBox"></td>
				<td><img src="images/pixel.gif" width="10" height="1" border="0"</td>
				<td><input type="reset" value="<?=$lclearbtn?>" class="textBox"></td>
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
	echo "<tr><td class=\"error\" colspan=\"2\" align=\"center\">" . $emailerror[$err] . "</td></tr>";
}
?>
</table>
</form>
<?
include ("include/bottom.php");
?>
