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

	$suid = $_REQUEST['user1'];
	$item_name = $_REQUEST['product_name'];
	$amount = (float)$_REQUEST['amount'];
	$amount = (float)$_REQUEST['amount'];
	$status = (float)$_REQUEST['status'];
	if(!$amount){
		$amount = (float)$_REQUEST['payment_gross'];
	}
	$fees = myround($amount * $dep_sp_percent / 100, 2) + $dep_sp_fee;

//	SUCCESS, CANCEL or ERROR

	if($status == "SUCCESS"){
		// ---------------
		// Process payment
		$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE suid='".addslashes($suid)."'"));
		if ($r){
			$pending = ($paypal_auto_deposit ? 0 : 1);
			if( strstr(strtolower($item_name),"signup fee") ){
				transact($r->id,1,($amount-$fees),'Signup Fee','',$fees,$pending);
				mysql_query("UPDATE epay_users SET fee=1 WHERE suid='".addslashes($suid)."'");
			}else{
				transact(16,$r->id,($amount-$fees),'Deposit','',$fees,$pending);
			}
			// Notify admin
			$message = $GLOBALS[$r->type]." $r->username has just deposited {$currency}$amount via StormPay!";
			if ($dep_notify)
				mail($adminemail, "$sitename Deposit", $message, $defaultmail);
		}
		// ---------------
	}
	header("Location: ../../{$r->type}.php?a=account&suid=$suid");
?>