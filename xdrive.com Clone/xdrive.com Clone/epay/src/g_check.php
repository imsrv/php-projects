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
	$fee = myround($amount * $dep_check_percent / 100) + $dep_check_fee;
	if ($amount >= $minimal_deposit){
?>
		<DIV class=large>Regular Mail Payments</DIV>
		<BR>
			Please forward a current check in the amount of <?=prsumm($amount + $fee)?> to the following address:<br>
		<BR>
		<DIV class=highlight width=100%>
		  <?=nl2br($dep_check)?>
		</DIV>
		<BR>
		<FONT color=red><B>Please Note:</B></FONT> Include a note with your username (<?=$data->username?>) and the email address you registered with (<?=$data->email?>), so we can credit your account accordingly.<BR>
		Thank you.
<?
			$processed = 1;
	}else{
			errform('Sorry, but the minimum amount you can deposit is '.$currency.$minimal_deposit);
	}
?>