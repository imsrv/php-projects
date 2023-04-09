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
	$fee = myround($amount * $dep_kagi_percent / 100) + $dep_kagi_fee;
	if ($amount >= $minimal_deposit){
		$product = "US$ ".myround($amount + $fee)." - 1 * ".$suid."_ePayDeposit";
?>
		<DIV class=large>Credit Card Payments</DIV>
		<BR><BR>
		<B><DIV width=100% class=highlight>Please confirm the following before depositing funds:<br>
		<BR>
			Your transfer amount: <?=prsumm($amount)?>
		<BR>
			Processing Fee: -<?=prsumm($fee)?>
		<BR>
			Total Account Debit: <?=prsumm($amount + $fee)?>
		<BR><BR>
		</DIV>
		<CENTER>
		<form action="https://order.kagi.com/cgi-bin/store.cgi?storeID=<?=$kagi_sid?>&view=cart" method="POST">
			<INPUT type=HIDDEN name=Product value="<?=$product?>">
			<input type="hidden" name="customer/email" value="<?=$data->email?>">
			<INPUT type=submit class=button value='Deposit Money'>
		</FORM>
<?/*
		<form action="http://order.kagi.com/cgi-bin/store.cgi?storeID=<?=$kagi_sid?>&view=cart" method="POST">
			<INPUT TYPE="HIDDEN" NAME="Product" VALUE="US$ <?=myround($amount+$fee)?> - 1 * ePayDeposit">
			Email: <input type="text" name="customer/email"><br>
			Name: <input type="text" name="customer/shipping/name"><br>
		<input type="submit" value="Buy Now">
		</form>
*/?>
		<BR>
		<FONT color=red>
			<B>Please Note:</B></FONT> 
			Funds deposited via Kagi, can take 4-7 business days to be verified and show up in
			your account. Please Include a note with your username 
			(<?=$data->username?>) and the email address you registered with (<?=$data->email?>), 
			so we can credit your account accordingly.
		<BR>
		</DIV>
		</B>
<?
		$processed = 1;
	}else{
		errform('Sorry, but the minimum amount you can deposit is '.$currency.$minimal_deposit);
	}
?>