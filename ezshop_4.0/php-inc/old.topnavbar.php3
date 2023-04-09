<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$on_style = "bgcolor='#FFF9DB'";
$off_style = "bgcolor='#C0C0C0'";
$link=EchoLinkVars();
?>

<center>
<table border="0" cellpadding="0" cellspacing="0" width="95%" height="35">
  <tr>
    <td width="20%" align="center" <? if($action == "View Cart" || $action == "Update Cart"){echo $on_style;}else{echo $off_style;}?>>
<center><input type="Submit" name="action" value="View Cart"></td>

<? if($action == "Log In" & $login != "True"){?>
    <td width="80%" align="center" <? if($action == "Log In"){echo $on_style;}else{echo $off_style;}?>>
<center><input type="Submit" name="action" value="Log In"></td>

<? } else if($checkout != "True"){?>
    <td width="80%" align="center" <? if($action == "Check Out"){echo $on_style;}else{echo $off_style;}?>>
<center><input type="Submit" name="action" value="Check Out"></td>

<? }else if($login != "True"){?>
    <td width="80%" align="center" <? if($action == "Unsecure Checkout" || $action == "Secure Checkout" || $action == "Create Account"){echo "bgcolor='#FFF9DB' style='border-bottom: 0px solid border-right: 0px none'";}else{echo "bgcolor='#C0C0C0' style='border-bottom: 1px solid border-right: 0px none'";}?>>
<center><input type="Submit" name="action" value="Create Account"></td>

<? }else{ ?>
    <td width="20%" align="center" <? if($action == "Bill To"){echo $on_style;}else{echo $off_style;}?>>
<center><input type="Submit" name="action" value="Bill To"></td>
    <td width="20%" align="center" <? if($action == "Ship To"){echo $on_style;}else{echo $off_style;}?>>
<center><input type="Submit" name="action" value="Ship To"></td>
    <td width="20%" align="center" <? if($action == "Payment"){echo $on_style;}else{echo $off_style;}?>>
<center><input type="Submit" name="action" value="Payment"></td>
    <td width="20%" align="center" <? if($action == "Invoice"){echo $on_style;}else{echo $off_style;}?>>
<center><input type="Submit" name="action" value="Invoice"></td>
<? } ?>
</tr>
</table>
</center>
