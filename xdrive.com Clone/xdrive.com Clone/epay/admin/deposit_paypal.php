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

	$suid = $_REQUEST['custom'];
	$item_name = $_REQUEST['item_name'];
	$amount = (float)$_REQUEST['amount'];
	$amount = (float)$_REQUEST['amount'];
	$payment_status = $_REQUEST['payment_status'];

	if(!$amount){
		$amount = (float)$_REQUEST['payment_gross'];
	}
	$fees = myround($amount * $dep_pp_percent / 100, 2) + $dep_pp_fee;

	// Read post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	while (list($key,$value) = each($_REQUEST))
	$req .= "&".$key."=".urlencode($value);

	if ($_REQUEST['payment_status'] == "Completed" || $_REQUEST['payment_status'] == "Pending") { 
		// ---------------
		// Process payment
		$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE suid='".addslashes($suid)."'"));
		if ($r){
			$pending = ($paypal_auto_deposit ? 0 : 1);
			if( strstr(strtolower($item_name),"signup fee") ){
				transact($r->id,1,($amount-$fees),'Signup Fee','',$fees,$pending);
				mysql_query("UPDATE epay_users SET fee=1 WHERE suid='".addslashes($suid)."'");
			}else{
				transact(11,$r->id,($amount-$fees),'Deposit','',$fees,$pending);
			}
			// Notify admin
			$message = $GLOBALS[$r->type]." $r->username has just deposited {$currency}$amount via PayPal!";
			if ($dep_notify){
				mail($adminemail, "$sitename Deposit", $message, $defaultmail);
			}
			header("Location: ../../index.php?a=account&suid=$suid");
			exit;
		}
		// ---------------
	}
/*
	// Post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen ($req) . "\r\n\r\n";
	$fp = fsockopen ("www.paypal.com", 80, $errno, $errstr, 30);

	if (!$fp) {
		// HTTP ERROR
		echo "$errstr ($errno)";
	} else {
		fputs ($fp, $header.$req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			if (strcmp ($res, "VERIFIED") == 0) {
				// ---------------
				// Process payment
				$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE suid='".addslashes($suid)."'"));
				if ($r){
					$pending = ($paypal_auto_deposit ? 0 : 1);
					if( strstr(strtolower($item_name),"signup fee") ){
						transact($r->id,1,($amount-$fees),'Signup Fee','',$fees,$pending);
						mysql_query("UPDATE epay_users SET fee=1 WHERE suid='".addslashes($suid)."'");
					}else{
						transact(11,$r->id,($amount-$fees),'Deposit','',$fees,$pending);
					}
					// Notify admin
					$message = $GLOBALS[$r->type]." $r->username has just deposited {$currency}$amount via PayPal!";
					if ($dep_notify){
						mail($adminemail, "$sitename Deposit", $message, $defaultmail);
					}
					header("Location: ../../index.php?a=account&suid=$suid");
					exit;
				}
				// ---------------
			}
		}
		fclose ($fp);
	}
*/	
	header("Location: ../../index.php?a=account&suid=$suid");
?>