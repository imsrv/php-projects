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
	$afrom = pruserObj($user);
	$from = $afrom->email;
	$fee = myround($amount * $dep_np_percent / 100) + $dep_np_fee;
	if ($amount >= $minimal_deposit){
		// http://order.kagi.com/cgi-bin/store.cgi?storeID=4XH&&
		$time = time();
?>
		<DIV class=large>E-Gold Payments</DIV>
		<BR>
		<BR>
		<B><DIV width=100% class=highlight>Please confirm the following before depositing funds:<br>
		<BR>
			Your transfer amount: <?=prsumm($amount)?>
		<BR>
			Processing Fee: -<?=prsumm($fee)?>
		<BR>
			Total Account Debit: <?=prsumm($amount + $fee)?>
		<BR>
		</DIV>
		<CENTER>
		<form action="https://www.netpay.tv/cgi-bin/merchant/mpay.cgi" method="POST" target=_top>
			<input type="hidden" name="PAYEE_ACCOUNT" value="<?=$netpay_sid?>">
			<input type="hidden" name="PAYEE_NAME" value="<?=$sitename." (".$siteurl.")"?>">
			<input type="hidden" name="PAYMENT_AMOUNT" value=<?=myround($amount + $fee)?>>
			<input type="hidden" name="NOPAYMENT_URL" value="<? echo "$siteurl"?>">
			<input type="hidden" name="MEMO" value=""Deposit to <?=$sitename?> Account">
			<input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK">
			<input type="hidden" name="STATUS_URL" value="<? echo "$siteurl/epay/admin/deposit_netpay.php"; ?>">
			<input type="hidden" name="RETURN_URL" value="<? echo "$siteurl/"; ?>">
			<input type="hidden" name="CANCEL_URL" value="<? echo "$siteurl/"; ?>">
			<input type="hidden" name="PRODUCT_NAME" value="Add Funds">
			<input type="hidden" name="EXTRA_INFO" value="<?=$suid?>">
			<INPUT type=submit class=button value='Deposit Money'>
		</FORM>
		</DIV>
		</B>

<?
		$processed = 1;
	}else{
		errform('Sorry, but the minimum amount you can deposit is '.$currency.$minimal_deposit);
	}
?>