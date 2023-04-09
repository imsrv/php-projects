<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
?>
<br>
<table border=0 cellpadding=3 cellspacing=0 width="90%"  bgcolor="<? print($tbl_bgcolor)?>">
<tr>
<td bgcolor="<? print($hdr_bgcolor)?>">
<p>
<?
if($action ==""){$action = "Welcome!";}
// echo "Action: $action<br>\n";
?>
</td>
</tr>

<tr>
<td  height=200  bgcolor="<? print($bdy_bgcolor)?>"><? print($font) ?>
<?
switch ($action) {
	case "View":
		include("wines.php3");
		break;
	case "View Cart":
		include("cart.php3");
		break;
	case "Empty Cart":
		include("delete.php3");
		break;
	case "Update Cart":
		include("cart.php3");
		break;
	case "Order Items":
		include("order.php3");
		break;
	case "Check Out":
		include("checkout.php3");
		break;
	case "Secure Checkout":
		if($login == "True"){
			$action = "Bill To";
			include("billto.php3");
		}else{
			include("login-create.php3");
		}
		break;
	case "Unsecure Checkout":
		if($login == "True"){
			$action = "Bill To";
			include("billto.php3");
		}else{
			include("login-create.php3");
		}
		break;
	case "Create Account":
		include("create_account.php3");
		break;
	case "Log In":
		include("login.php3");
		break;
	case "Remember Me":
		include("login.php3");
		break;
	case "Bill To":
		include("billto.php3");
		break;
	case "Ship To":
		include("shipto.php3");
		break;
	case "Payment":
		include("payment.php3");
		break;
	case "Invoice":
		include("cart.php3");
		break;
	case "Submit Order On Line":
		include("submit.php3");
		break;
	case "varietal":
		include("varietals.php3");
		break;
	case "winery":
		include("wineries.php3");
		break;
	default:
		</script></p>

		<p><BIG>The Wine Catalog can be viewed by selecting either the VARIETAL name or the WINERY
		name. A list of available wines will be presented.</BIG></p>

		<p><?
		include("varietals.php3");
		echo "<p>\n";
		include("wineries.php3");
	break;
}
?>
</td>
</tr>
<tr>
<td align="right" bgcolor="<? print($ftr_bgcolor)?>">
<p>
<form method="<? print($method) ?>" action="<? print($SCRIPT_NAME) ?>">
<? EchoFormVars() ?>
<input type="submit" value="Continue Shopping" name="action">
<input type="submit" name="action" value="View Cart">
<input type="submit" name="action" value="Check Out">
<input type="submit" name="action" value="Log In">
</p>

</td>
</tr>
</table>
