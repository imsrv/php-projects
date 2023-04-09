<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?
	$source = $_POST['source'];
	$amount = (float)$_POST['amount'];
	if (!$step) $step = 1;
	$balance = balance($user);

	// PayPal processing
	if ($paypal_use && $source == 'paypal'){
		$fee = $wdr_pp_fee;
		if ($amount >= $minimal_withdrawal + $fee && $balance >= $amount){
			$step = 2;
			$fields = array(
				array("x_email", "PayPal E-mail")
			);
			$title = "PayPal Recipient Information";
			if ($_POST['proceed2'])
				$step = 3;
			if ($_POST['proceed3'])
				$step = 4;
		}else{
			if ($balance < $amount)
				errform("Sorry, but you do not have sufficient funds in your account to conduct this transaction.");
			else
				errform('The minimum amount of funds you may withdraw is '.$currency.($minimal_withdrawal + $fee));
			$step = 1;
		}
	}elseif ($source == 'wire'){
		// Wire transfer processing
		$fee = $wdr_wire_fee;
		if ($amount >= $minimal_withdrawal + $fee && $balance >= $amount){
			$step = 2;
			$fields = array(
				array("x_name", "Account Holder's Name", 30),
				array("x_bank", "Bank Name", 30),
				array("x_address", "Bank Street Address", 40),
				array("x_address2", "", 40, 1),
				array("x_city", "Bank City", 30),
				array("x_state", "Bank State/Province", 30),
				array("x_country", "Bank Country", 30),
				array("x_postcode", "Bank Zip/Postal Code", 10),
				array("x_accno", "Bank Account Number", 20),
				array("x_swift", "Bank Routing/Swift Code", 20),
				array("x_acctype", "Bank Account Type", -1),
				array("x_info", "Additional Information", -2)
			);
			$title = "Provide Bank Information";
			if ($_POST['proceed2'])
				$step = 3;
			if ($_POST['proceed3'])
				$step = 4;
		}else{
			if ($balance < $amount)
				errform("Sorry, but you do not have sufficient funds in your account to conduct this transaction.");
			else
				errform('The minimum amount of funds you may withdraw is '.$currency.($minimal_withdrawal + $fee));
			$step = 1;
		}
	}elseif ($check_use && $source == 'check'){
		// Check processing
		$fee = $wdr_check_fee;
		if ($amount >= $minimal_withdrawal + $fee && $balance >= $amount){
			$step = 2;
			$fields = array(
				array("x_cname", "Check Payable To"),
				array("x_caddress", "Address"),
				array("x_ccity", "City, State/Province, Country"),
				array("x_cpostcode", "Zip/Postal Code")
			);
			$title = "Provide check information";
			if ($_POST['proceed2'])
				$step = 3;
			if ($_POST['proceed3'])
				$step = 4;
		}else{
			if ($balance < $amount)
				errform("Sorry, but you do not have sufficient funds in your account to conduct this transaction.");
			else
				errform('The minimum amount of funds you may withdraw is '.$currency.($minimal_withdrawal + $fee));
			$step = 1;
		}
	}elseif ($_POST['proceed1']){
		errform('Please select a payment method');
		$step = 1;
	}
?>
<table width="700" border="0" align="center" bgcolor="#FFFFFF">
<tr>
	<td>
		<table width="620" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#FFFFFF">
		<tr>
			<td width=150 height="314" valign="top">
<?
	include("src/acc_menu.php");
?>
			</td>
			<td width=20> </td>
			<td width="519" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
					<td><font face="Arial, Helvetica, sans-serif" size="3" color="#000066"><b>
					Withdraw Money 
<?					if ($step <= 3) echo "(Step $step of 3)<BR>";	?>

					</b></font></td>
				</tr>
				<tr>
					<td bgcolor="#000000" height=1></td>
				</tr>
				<tr>
					<td> </td>
				</tr>
				<tr>
					<td>
<?
switch ($step){
case 2:

echo <<<END
<SCRIPT language=JavaScript>
function setCookie(name, value, minutes) {
  if (minutes) { now = new Date(); now.setTime(now.getTime() + minutes*60*1000); }
  var curCookie = name + "=" + escape(value) + ((minutes) ? "; expires=" + now.toGMTString() : "");
  document.cookie = curCookie;
}

function getCookie(name) { 
  var prefix = name + "=";
  var cStartIdx = document.cookie.indexOf(prefix); 
  if (cStartIdx == -1) return '';
  var cEndIdx = document.cookie.indexOf(";", cStartIdx+prefix.length);
  if (cEndIdx == -1) cEndIdx = document.cookie.length;
  return unescape( document.cookie.substring(cStartIdx + prefix.length, cEndIdx) );
}
</SCRIPT>
END;

  // Generate form
  echo "<BR><CENTER>",
       "<TABLE class=design cellspacing=0><FORM method=post name=form1>",
       "<tr><th colspan=2>",$title;
  while ($a = each($fields))
  {
    $x = $a[1];
    $set .= "setCookie('$x[0]',form1.$x[0].value);";
    $get .= "form1.$x[0].value=getCookie('$x[0]');";
    if ($x[1])
      echo "<TR><TD>$x[1]<TD>";
    else
      echo "<BR>";
    switch ($x[2])
    {
      case -1:
        echo "<SELECT name=$x[0]><OPTION>Personal Checking<OPTION>Personal Savings",
             "<OPTION>Business Checking<OPTION>Business Savings</SELECT>";
        break;
      case -2:
        echo "<TEXTAREA name=$x[0] cols=40 rows=4></TEXTAREA>";
        break;
      default:
        echo "<INPUT type=text name=$x[0] size=$x[2]>";
    }
  }
  echo "<TR><TH colspan=2 class=submit>",
       "<INPUT type=submit class=button onClick=\"$set\" name=proceed2 value='Proceed >>'></TH>",
       "<INPUT type=hidden name=source value=$source>",
       "<INPUT type=hidden name=amount value=$amount>",
       $id_post,
       "</FORM></TABLE>",
       "</CENTER><BR>",
       "<SCRIPT language=JavaScript>$get</SCRIPT>";
  
  break;
case 3:
  $i = 0;
  $str = '';
  while ($a = each($_POST))
    if (substr($a[0], 0, 2) == 'x_')
    {
      if ($fields[$i][1])
        $value = $fields[$i][1].": ".$a[1];
      else
        $value = ", ".$a[1];
      $str .= htmlspecialchars($value);
      $hidden .= $value;
      $i++;
      if (!$fields[$i][3])
      {
        $str .= "<br>";
        $hidden .= "\n";
      }
    }
?>

<BR>
<B><div width=100% class=highlight>Please confirm the following before withdrawing funds:<br>
<BR>Received: <?=prsumm($amount - $fee)?><BR>
    Fee: +<?=prsumm($fee)?><BR>
    Total Withdrawn: <?=prsumm($amount)?><BR>
    <br>
    <?=$str?>
  </DIV>
  <CENTER>
  <FORM method=post>
    <INPUT type=hidden name=source value=<?=$source?>>
    <INPUT type=hidden name=amount value=<?=$amount?>>
    <INPUT type=hidden name=addinfo value="<?=htmlspecialchars($hidden)?>">
    <INPUT type=submit class=button name=proceed3 value='Withdraw Money'>
    <?=$id_post?>
  </FORM>
  </CENTER>
  </B>

<?       
  break;
case 4:
  // Update database
  //settype($fee, 'integer');
  $charge = $amount;
  $amount -= $fee;
  $a = mysql_fetch_row(mysql_query("SELECT id FROM epay_users WHERE username='".addslashes($source)."'"));
  if ($a)
    $addinfo = addslashes($_POST['addinfo']);
    transact($user,$a[0],$charge,'Withdrawal','',$fee,1,$addinfo);
    $action = 'account';
  
  // Notify admin
  $message = $GLOBALS[$data->type]." $data->username has just withdrawn {$currency}$amount !";
  if ($wdr_notify)
    mail($adminemail, "$sitename Withdrawal", $message, $defaultmail);
  ob_start();
  header("Location: index.php?a=account&suid=$suid");
  break;
default:
  {
?>

<BR>
<CENTER>
<TABLE class=design cellspacing=0>
<FORM method=post>
<TR><TH colspan=2>Withdraw funds from your account</TH>
<TR><TD>Amount to withdraw:</TD>
	<TD><?=$currency?> <INPUT type=text size=5 maxLength=5 name=amount>
<TR><TD>Payment method:</TD>
	<TD>
    
<?
  // PayPal
  if ($paypal_use)
    echo "<INPUT type=radio class=checkbox name=source value='paypal' ",($source == 'paypal' ? 'checked' : ''),">",
         "PayPal",
         " <SPAN class=small>(cost: ",prsumm($wdr_pp_fee),")</SPAN><BR>\n";
  // Wire
    echo "<INPUT type=radio class=checkbox name=source value='wire' ",($source == 'wire' ? 'checked' : ''),">",
         "Wire transfer",
         " <SPAN class=small>(cost: ",prsumm($wdr_wire_fee),")</SPAN><BR>\n";
  // Check
  if ($check_use)
    echo "<INPUT type=radio class=checkbox name=source value='check' ",($source == 'check' ? 'checked' : ''),">",
         "Regular Mail",
         " <SPAN class=small>(cost: ",prsumm($wdr_check_fee),")</SPAN><BR>\n";
?>       

<TR><TH colspan=2 class=submit><INPUT type=submit class=button name=proceed1 value='Proceed >>'></TH>
  <?=$id_post?>
</TR>
</FORM>
</TABLE>
</CENTER>

<?
  }
}
?>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</table>