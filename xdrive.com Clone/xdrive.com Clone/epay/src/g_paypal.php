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
	$fee = myround($amount * $dep_pp_percent / 100) + $dep_pp_fee;
	if ($amount >= $minimal_deposit){
?>
		<DIV class=large>PayPal Payments</div><br>
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
		<FORM method=post action="https://www.paypal.com/cgi-bin/webscr">
			<INPUT type=HIDDEN name="cmd" value="_xclick">
			<INPUT type=HIDDEN name="business" value="<?=$paypal_id?>">
			<INPUT type=HIDDEN name="item_name" value="<? echo "$sitename Deposit"; ?>">
			<INPUT type=HIDDEN name="no_shipping" value="1">
			<INPUT type=HIDDEN name="notify_url" value="<? echo "$siteurl/epay/admin/deposit_paypal.php"; ?>">
			<INPUT type=HIDDEN name="return" value="<? echo "$siteurl/"; ?>">
			<INPUT type=HIDDEN name="custom" value="<?=$suid?>">
			<INPUT type=HIDDEN name="no_note" value="1">
			<INPUT type=HIDDEN name="amount" value="<?=myround($amount + $fee)?>">
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