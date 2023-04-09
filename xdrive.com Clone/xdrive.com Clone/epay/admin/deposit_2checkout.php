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
	chdir('..');
	require('src/common.php');

	$suid = $_REQUEST['x_invoice_num'];
	if(!$suid)$suid = $_REQUEST['cart_order_id'];
	$amount = (float)$_REQUEST['total'];
	$orderno = $_REQUEST['order_number'];
	$fees = round($amount * $dep_cc_percent / 100, 2) + $dep_cc_fee;

	// ---------------
	// Process payment
	$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE suid='".addslashes($suid)."'"));
	if ($r && ($_REQUEST['x_2checked'] == 'Y') && ($_REQUEST['x_response_reason_code'] == '1') ){
		transact(13,$r->id,($amount-$fees),'Deposit','',$fees,1,'',addslashes($orderno));
		// Notify admin
		$message = $GLOBALS[$r->type]." $r->username has just deposited {$currency}$amount via 2CheckOut!";
		if ($dep_notify){
			mail($adminemail, "$sitename Deposit", $message, $defaultmail);
		}
	}
	// ---------------
	header("Location: ../../index.php?a=account&suid=$suid");
?>