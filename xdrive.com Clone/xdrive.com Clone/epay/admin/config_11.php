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

if ($_POST['change2'] && $action == 'config')
{
  $a_int = array(
    'project_max_days', 'project_urgent_days', 'ulist_page',
	'b_period','s_period','g_period','p_period','charge_signup'
  );
  $a_percent = array(
    'referral_payout', 'dep_pp_percent','dep_sp_percent', 'dep_cc_percent','dep_eg_percent',
    'dep_np_percent','special_discount','transfer_percent', 'dep_anet_percent', 'dep_kagi_percent'
  );
  $a_float = array(
    'signup_bonus',  
    'minimal_transfer', 'dep_pp_fee','dep_sp_fee', 'dep_cc_fee','dep_anet_fee','dep_eg_fee',
    'dep_np_fee','dep_check_fee', 'minimal_deposit','wdr_pp_fee','wdr_check_fee', 'wdr_wire_fee',
    'minimal_withdrawal','signup_fee','ex_rate','transfer_fee','dep_kagi_fee'
  );
  $a_string = array(
     'paypal_id','stormpay_id', 'tocheckout_sid','egold_sid','netpay_sid','sales_tax','currency',
     'dcolor','bcolor','scolor','gcolor','pcolor',
     'anet_sid','anet_pwd','kagi_sid'
  );
  $a_check = array(
    'dep_notify', 'wdr_notify','paypal_use', 'paypal_auto_deposit', 
    'stormpay_use', 'stormpay_auto_deposit', 
    'cc_use', 'check_use','multi_special','multi_levels','eg_use',
    'np_use','send_i','send_r','anet_use','affil_on','kagi_use'
  );
  $a_textarea = array(
    'dep_check'
  );
  
  $str = "<?\n";
  while ($a = each($_POST))
  {
    if (substr($a[0], 0, 9) == 'separator')
      $str .= "\n// $a[1]\n";
    elseif (in_array($a[0], $a_int))
      $str .= '$'."{$a[0]} = ".(int)$a[1].";\n";
    elseif (in_array($a[0], $a_percent))
    {
      $x = (double)$a[1];
      if ($x < 0 || $x > 100) $x = 0;
      $str .= '$'."{$a[0]} = $x;\n";
    }
    elseif (in_array($a[0], $a_float))
      $str .= '$'."{$a[0]} = ".number_format($a[1], 2, '.', '').";\n";
    elseif (in_array($a[0], $a_string))
      $str .= '$'."{$a[0]} = \"".preg_replace("/[\"\\\\]/", "\\\\\\0", $a[1])."\";\n";
    elseif (in_array($a[0], $a_check))
      $str .= '$'."{$a[0]} = ".($a[1] ? '1' : '0').";\n";
    elseif (in_array($a[0], $a_textarea))
      $str .= '$'."{$a[0]} = \"".str_replace(array("\r","\n"), array("","\\n"), preg_replace("/[\"\\\\]/", "\\\\\\0", $a[1]))."\";\n";
  }
  $str .= "\n?>";

  $f = fopen("config2.php", "w");
  if ($f)
  {
    fwrite($f, $str);
    fclose($f);
    echo "<div style='color: red;'>Update variables successful.</div><br>";
  }
  else
    echo "<div style='color: red;'>Update variables failed. Check write permissions for file \"config2.php\".</div><br>";
  
  include("config2.php");
}

?>
<TABLE class=design width=100% cellspacing=0>
<!------///////////////--->
<TR><TH colspan=2>Currency Options
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>currency</b> - Currency sign (e.g. "$").
	<TD><input type=text size=10 name=currency value="<?=htmlspecialchars($currency)?>">
<TR><TD><b>credit value</b> - How much is one credit worth? (e.g. "1.0").
	<TD><input type=text size=10 name=ex_rate value="<?=$ex_rate?>">
<!------///////////////--->
<TR><TH colspan=2>Signup Options</TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>Signup Bonus</b> - Amount to credit newly registered members. Default: "1"</TD>
	<TD><input type=text size=10 name=signup_bonus value="<?=htmlspecialchars($signup_bonus)?>"></TD></TR>
<TR><TD><b>Have a Signup Fee</b> - Allows you to charge users for signup.</TD>
	<TD><input type=checkbox class=checkbox name=charge_signup value=1 <? if ($charge_signup) echo 'checked'; ?>></TD></TR>
<TR><TD><b>Signup Fee</b> - Amount to charge for signup.</TD>
	<TD><input type=text size=10 name=signup_fee value="<?=htmlspecialchars($signup_fee)?>"></TD></TR>
<!------///////////////--->
<TR><TH colspan=2>Payments and Charges</TH></TR>
<!------\\\\\\\\\\\\\\\--->
<input type=hidden name=separator4 value="$">
<TR><TD><b>Affiliate System</b> - Turn Affiliate System on or off. <br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></TD>
	<TD><input type=checkbox class=checkbox name=affil_on value=1 <? if ($affil_on) echo 'checked'; ?>></TD></TR>
<TR><TD><b>Referral Payout</b> - Payout for referred users by registered members. The percentage of the income from a registered member that is given to the person that referred him. Reasonable values are 0 - 50.</TD>
	<TD><input type=text size=10 name=referral_payout value="<?=htmlspecialchars($referral_payout)?>"></TD></TR>
<TR><TD><b>Minimum Transfer</b> - Minimum transfer amount (dollars). Default: "5"</TD>
	<TD><input type=text size=10 name=minimal_transfer value="<?=htmlspecialchars($minimal_transfer)?>"></TD></TR>
<TR><TD><b>Transfer Fee</b> - Percentage to charge individuals when they receive money. Default: "5"</TD>
	<TD><input type=text size=10 name=transfer_percent value="<?=htmlspecialchars($transfer_percent)?>"></TD></TR>
<TR><TD><b>Transfer Fee</b> - Fee to charge individuals when they receive money (dollars). Default: "5"</TD>
	<TD><input type=text size=10 name=transfer_fee value="<?=htmlspecialchars($transfer_fee)?>"></TD></TR>
<TR><TD><b>Sales Tax</b> - If applicable. Default: "0"</TD>
	<TD><input type=text size=10 name=sales_tax value="<?=htmlspecialchars($sales_tax)?>"></TD></TR>
<TR><TD><b>Send Invoices</b> - If you wish to send an invoice after each financial transaction</TD>
<td><input type=checkbox class=checkbox name=send_i value=1 <? if ($send_i) echo 'checked'; ?>></TD></TR>
<TR><TD><b>Send Receipts</b> - If you wish to send a receipt along with each invoice</TD>
	<td><input type=checkbox class=checkbox name=send_r value=1 <? if ($send_r) echo 'checked'; ?>></TD></TR>

<!------///////////////--->
<TR><TH colspan=2>Credit Card Transactions<input type=hidden name=separator5 value="DEPOSIT"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>Deposits - Notify</b> - Notify admin for all deposit events.  <br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></TD>
	<TD><input type=checkbox class=checkbox name=dep_notify value=1 <? if ($dep_notify) echo 'checked'; ?>></TD></TR>
<TR><td><b>PayPal Transaction Fees</b> - Percentage to charge PayPal users. Default: "3.2"</TD>
	<TD><input type=text size=10 name=dep_pp_percent value="<?=htmlspecialchars($dep_pp_percent)?>"></TD></TR>
<TR><TD><b>Additional PayPal Transaction Fees</b> - Additional admin transaction fee for PayPal users. Default: "0.3" ($0.30)</TD>
	<TD><input type=text size=10 name=dep_pp_fee value="<?=htmlspecialchars($dep_pp_fee)?>"></TD></TR>
<TR><td><b>StormPay Transaction Fees</b> - Percentage to charge StormPay users. Default: "3.2"</TD>
	<TD><input type=text size=10 name=dep_sp_percent value="<?=htmlspecialchars($dep_sp_percent)?>"></TD></TR>
<TR><TD><b>Additional StormPay Transaction Fees</b> - Additional admin transaction fee for StormPay users. Default: "0.3" ($0.30)</TD>
	<TD><input type=text size=10 name=dep_sp_fee value="<?=htmlspecialchars($dep_sp_fee)?>"></TD></TR>
<TR><TD><b>2Checkout Transation Fees</b> - Percentage to charge individuals using 2Checkout. Default: "5.5"</TD>
	<TD><input type=text size=10 name=dep_cc_percent value="<?=htmlspecialchars($dep_cc_percent)?>"></TD></TR>
<TR><TD><b>Additional 2Checkout Transaction Fees</b> - Additional admin transaction fee for 2Checkout. Default: "0.5" ($0.50)</TD>
	<TD><input type=text size=10 name=dep_cc_fee value="<?=htmlspecialchars($dep_cc_fee)?>"></TD></TR>
<TR><TD><b>Authorize.Net Transation Fees</b> - Percentage to charge individuals using Authorize.Net. Default: "5.5"</TD>
	<TD><input type=text size=10 name=dep_anet_percent value="<?=htmlspecialchars($dep_anet_percent)?>"></TD></TR>
<TR><TD><b>Additional Authorize.Net Transaction Fees</b> - Additional admin transaction fee for Authorize.Net. Default: "0.5" ($0.50)</TD>
	<TD><input type=text size=10 name=dep_anet_fee value="<?=htmlspecialchars($dep_anet_fee)?>"></TD></TR>
<TR><TD><b>Kagi Transation Fees</b> - Percentage to charge individuals using Authorize.Net. Default: "5.5"</TD>
	<TD><input type=text size=10 name=dep_kagi_percent value="<?=htmlspecialchars($dep_kagi_percent)?>"></TD></TR>
<TR><TD><b>Additional Kagi Transaction Fees</b> - Additional admin transaction fee for Kagi. Default: "0.5" ($0.50)</TD>
	<TD><input type=text size=10 name=dep_kagi_fee value="<?=htmlspecialchars($dep_kagi_fee)?>"></TD></TR>
<TR><TD><b>E-Gold Transation Fees</b> - Percentage to charge individuals using E-Gold. Default: "5.5"</TD>
	<TD><input type=text size=10 name=dep_eg_percent value="<?=htmlspecialchars($dep_eg_percent)?>"></TD></TR>
<TR><TD><b>Additional E-Gold Transaction Fees</b> - Additional admin transaction fee for E-Gold. Default: "0.5" ($0.50)</TD>
	<TD><input type=text size=10 name=dep_eg_fee value="<?=htmlspecialchars($dep_eg_fee)?>"></TD></TR>
<TR><TD><b>NetPay Transation Fees</b> - Percentage to charge individuals using NetPay. Default: "5.5"</TD>
	<TD><input type=text size=10 name=dep_np_percent value="<?=htmlspecialchars($dep_np_percent)?>"></TD></TR>
<TR><TD><b>Additional NetPay Transaction Fees</b> - Additional admin transaction fee for NetPay. Default: "0.5" ($0.50)</TD>
	<TD><input type=text size=10 name=dep_np_fee value="<?=htmlspecialchars($dep_np_fee)?>"></TD></TR>
<TR><TD><b>Deposit by Cheque or Bank Draft</b> - Additional admin transaction fee for indviduals using checks. Default: "1.0" ($1.00)</TD>
	<TD><input type=text size=10 name=dep_check_fee value="<?=htmlspecialchars($dep_check_fee)?>"></TD></TR>
<TR><TD><b>Minimum deposit</B> - Minimum amount that a member can deposit into account. Default: "10" ($10.00)</TD>
	<TD><input type=text size=10 name=minimal_deposit value="<?=htmlspecialchars($minimal_deposit)?>"></TD></TR>


<!------///////////////--->
<TR><TH colspan=2>Withdrawals<input type=hidden name=separator6 value="WITHDRAW"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>Notification</b> - Notify admin for all withdrawal events. <br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></TD>
<TD><input type=checkbox class=checkbox name=wdr_notify value=1 <? if ($wdr_notify) echo 'checked'; ?>></TD></TR>
<TR><TD><b>Withdrawal Fee PayPal</b> - Amount to charge for withdrawals using PayPal. Default: "0.0"</TD>
<TD><input type=text size=10 name=wdr_pp_fee value="<?=htmlspecialchars($wdr_pp_fee)?>"></TD></TR>
<TR><TD><b>Withdrawal Fee Check</b> - Amount to charge for withdrawals via checks. Default: "1.0"</TD>
<TD><input type=text size=10 name=wdr_check_fee value="<?=htmlspecialchars($wdr_check_fee)?>"></TD></TR>
<TR><TD><b>Withdrawal Wire Transfer</b> - Amount to charge for withdrawals via wire transfer. Default: "21.0"</TD>
<TD><input type=text size=10 name=wdr_wire_fee value="<?=htmlspecialchars($wdr_wire_fee)?>"></TD></TR>
<TR><TD><b>Withdrawal Minimum</b> - Minimu, withdrawal amount. This is the minimum withdrawal amount (not counting the comissions). Default: "30" ($30.00)</TD>
<TD><input type=text size=10 name=minimal_withdrawal value="<?=htmlspecialchars($minimal_withdrawal)?>"></TD></TR>

<!------///////////////--->
<TR><TH colspan=2>PayPal<input type=hidden name=separator7 value="PAYPAL"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>PaypPal Option</b> - Use PayPal processing. <br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></TD>
	<TD><input type=checkbox class=checkbox name=paypal_use value=1 <? if ($paypal_use) echo 'checked'; ?>></TD></TR>
<TR><TD><b>PayPal ID</b> - Your PayPal ID. This ID will be used for PayPal transactions.</TD>
	<TD><input type=text size=40 name=paypal_id value="<?=htmlspecialchars($paypal_id)?>"></TD></TR>
<TR><TD><b>PayPal Auto Deposit</b> - Fully automated PayPal deposits. <br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></TD>
	<TD><input type=checkbox class=checkbox name=paypal_auto_deposit value=1 <? if ($paypal_auto_deposit) echo 'checked'; ?>></TD></TR>

<!------///////////////--->
<TR><TH colspan=2>StormPay<input type=hidden name=separator8 value="STORMPAY"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>StormPay Option</b> - Use StormPay processing. <br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></TD>
	<TD><input type=checkbox class=checkbox name=stormpay_use value=1 <? if ($stormpay_use) echo 'checked'; ?>></TD></TR>
<TR><TD><b>StormPay ID</b> - Your StormPay ID. This ID will be used for StormPay transactions.</TD>
	<TD><input type=text size=40 name=stormpay_id value="<?=htmlspecialchars($stormpay_id)?>"></TD></TR>
<TR><TD><b>StormPay Auto Deposit</b> - Fully automated StormPay deposits. <br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></TD>
	<TD><input type=checkbox class=checkbox name=stormpay_auto_deposit value=1 <? if ($stormpay_auto_deposit) echo 'checked'; ?>></TD></TR>

<!------///////////////--->
<TR><TH colspan=2>2CheckOut<input type=hidden name=separator9 value="CC"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>2Checkout Option</b> - Use credit card processing. We recommend: Enable</b></TD>
	<td><input type=checkbox class=checkbox name=cc_use value=1 <? if ($cc_use) echo 'checked'; ?>></TD></TR>
<TR><TD><b>2Checkout ID</b> - 2CheckOut ID. This ID will be used for 2CheckOut transactions.</TD>
	<td><input type=text size=40 name=tocheckout_sid value="<?=htmlspecialchars($tocheckout_sid)?>"></TD></TR>

<!------///////////////--->
<TR><TH colspan=2>Authorize.Net<input type=hidden name=separator10 value="AN"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>Authorize.Net Payment Option</b> - For credit card processing.<BR>
		<FONT COLOR="#008000"><br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></FONT><BR>
	<td><input type=checkbox class=checkbox name=anet_use value=1 <? if ($anet_use) echo 'checked'; ?>></TD></TR>
<TR><TD><b>Authorize.Net ID</b> - Authorize.net ID. This ID will be used for Authorize.net transactions.</TD>
	<td><input type=text size=40 name=anet_sid value="<?=htmlspecialchars($anet_sid)?>"></TD></TR>
<TR><TD><b>Authorize.Net Password</b> - Authorize.net Password. This Password will be used for Authorize.net transactions.</TD>
	<td><input type=text size=40 name=anet_pwd value="<?=htmlspecialchars($anet_pwd)?>"></TD></TR>

<!------///////////////--->
<TR><TH colspan=2>Kagi<input type=hidden name=separator11 value="KAGI"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>Kagi Payment Option</b> - For credit card processing.<BR>
		<FONT COLOR="#008000"><br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></FONT><BR>
	<td><input type=checkbox class=checkbox name=kagi_use value=1 <? if ($kagi_use) echo 'checked'; ?>></TD></TR>
<TR><TD><b>Kagi ID</b> - Kagi ID. This ID will be used for Kagi transactions.</TD>
	<td><input type=text size=40 name=kagi_sid value="<?=htmlspecialchars($kagi_sid)?>"></TD></TR>

<!------///////////////--->
<TR><TH colspan=2>E-Gold<input type=hidden name=separator12 value="EGOLD"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>E-Gold Option</b> - Use E-Gold processing. We recommend: Enable</b></TD>
	<td><input type=checkbox class=checkbox name=eg_use value=1 <? if ($eg_use) echo 'checked'; ?>></TD></TR>
<TR><TD><b>E-Gold ID</b> - E-Gold ID. This ID will be used for E-Gold transactions.</TD>
	<td><input type=text size=40 name=egold_sid value="<?=htmlspecialchars($egold_sid)?>"></TD></TR>

<!------///////////////--->
<TR><TH colspan=2>NetPay<input type=hidden name=separator13 value="NETPAY"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>NetPay Option</b> - Use NetPay processing. We recommend: Enable</b></TD>
	<td><input type=checkbox class=checkbox name=np_use value=1 <? if ($np_use) echo 'checked'; ?>></TD></TR>
<TR><TD><b>NetPay ID</b> - NetPay ID. This ID will be used for NetPay transactions.</TD>
	<td><input type=text size=40 name=netpay_sid value="<?=htmlspecialchars($netpay_sid)?>"></TD></TR>

<!------///////////////--->
<TR><TH colspan=2>Checks<input type=hidden name=separator14 value="CHECK"></TH></TR>
<!------\\\\\\\\\\\\\\\--->
<TR><TD><b>Check Option</b> - Use check processing. <br><FONT COLOR="#008000"><b>We recommend: Enable</b></FONT></TD>
	<td><input type=checkbox class=checkbox name=check_use value=1 <? if ($check_use) echo 'checked'; ?>></TD></TR>
<TR><TD><b>Check Deposit Info</b> - Mailing address for check deposits. Place each value on a new row in the following order: Company, Address, City/State/Country, Postcode</TD>
<TD><textarea name=dep_check cols=40 rows=4><?=htmlspecialchars($dep_check)?></textarea></TD></TR>


<!------///////////////--->
<TR><th colspan=2 class=submit><input type=submit name=change2 value="Update variables">
<!------\\\\\\\\\\\\\\\--->
</TD></TR>
</TABLE>

</TD>
