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
	$fee = myround($amount * $dep_cc_percent / 100) + $dep_cc_fee;
	if ($amount >= $minimal_deposit){
		// http://order.kagi.com/cgi-bin/store.cgi?storeID=4XH&&
?>
		<DIV class=large>Credit Card Payments</DIV>
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
		<form action="https://www.2checkout.com/cgi-bin/Abuyers/purchase.2c" method="POST">
			<INPUT type=HIDDEN name=x_login value="<?=$tocheckout_sid?>"> 
			<INPUT type=HIDDEN name=x_invoice_num value="<?=$suid?>">
			<INPUT type=HIDDEN name=x_Receipt_Link_URL value="<? echo "$siteurl/fastpay/admin/deposit_2checkout.php"; ?>">
			<INPUT type=HIDDEN name=x_amount value="<?=($amount + $fee)?>">
			<INPUT type=submit class=button value='Deposit Money at 2Checkout Now'>
		</FORM>
		</DIV>
		</B>
<?
		$processed = 1;
	}else{
		errform('Sorry, but the minimum amount you can deposit is '.$currency.$minimal_deposit);
	}
?>