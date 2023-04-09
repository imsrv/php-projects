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

$suid = $_REQUEST['EXTRA_INFO'];
$PAYMENT_BATCH_NUM = $_REQUEST['PAYMENT_BATCH_NUM'];
$PAYER_ACCOUNT = $_REQUEST['PAYER_ACCOUNT'];
$PAYER_AMOUNT = $_REQUEST['PAYMENT_AMOUNT'];
$amount = $PAYER_AMOUNT;

$fees = myround($amount * $dep_np_percent / 100, 2) + $dep_np_fee;

if( ($HASH == md5("abdo".$CHECKSUM.$suid)) && ($PAYMENT_BATCH_NUM != 0) && (!empty($PAYER_ACCOUNT)) ){
	// ---------------
	// Process payment
	$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE suid='".addslashes($suid)."'"));
	if ($r ){
		transact(18,$r->id,($amount-$fees),'Deposit','',$fees,1,'',addslashes($orderno));
		// Notify admin
		$message = $GLOBALS[$r->type]." $r->username has just deposited {$currency}$amount via NetPay!";
		if ($dep_notify){
			mail($adminemail, "$sitename Deposit", $message, $defaultmail);
		}
	}
	// ---------------

header("Location: ../../index.php?a=account&suid=$suid");
?>