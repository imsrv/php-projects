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
	$fee = myround($amount * $dep_sp_percent / 100) + $dep_sp_fee;
	if ($amount >= $minimal_deposit){
?>
		<DIV class=large>StormPay Payments</div><br>
		<BR>
		<B><DIV width=100% class=highlight>Please confirm the following before depositing funds:
		<BR>
		<BR>
			Your transfer amount: <?=prsumm($amount)?>
		<BR>
			Processing Fee: -<?=prsumm($fee)?>
		<BR>
			Total Credit Card Debit: <?=prsumm($amount + $fee)?>
		<BR>
		</DIV>
		<CENTER>
		<form method="post" action="https://www.stormpay.com/stormpay/handle_gen.php" target="_blank">
			<input type=hidden name=generic value="1">
			<input type=hidden name=payee_email value="<?=$stormpay_id?>">
			<input type=hidden name=product_name value="<? echo "$sitename Deposit"; ?>">
			<input type=hidden name=amount value="<?=myround($amount + $fee)?>">
			<input type=hidden name=quantity value="1">
			<input type=hidden name=require_IPN value="1">
			<input type=hidden name=notify_URL value="<? echo "$siteurl/epay/admin/deposit_paypal.php"; ?>">
			<input type=hidden name=return_URL value="<? echo "$siteurl/"; ?>">
			<input type=hidden name=user1 value="<?=$suid?>">
			<input type=submit class=button value='Deposit Money'>
		</form>
		</DIV>
		</B>
<?
		$processed = 1;
	}else{
			errform('Sorry, but the minimum amount you can deposit is '.$currency.$minimal_deposit);
	}
?>