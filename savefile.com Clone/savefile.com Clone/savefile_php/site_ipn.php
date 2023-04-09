<?php
	include("include/common.php");
	if(phpversion() <= "4.0.6") { $_POST = ($HTTP_POST_VARS); }
	$log = "* Local Site IPN Initiated.\n";

	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value"; 
	}

	### PostMode 1: Live Via PayPal Network
	if ($postmode == 1) {
		$log .= "* PostMode = 1: Posting to PayPal Network...\n";
		$fp = fsockopen ("www.paypal.com", 80, $errno, $errstr, 30);
		$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen ($req) . "\r\n\r\n"; 
	}elseif ($postmode == 2) {
		$log .= "* PostMode = 2: Posting to EliteWeaver.co.uk Tester...\n";
		$fp = fsockopen ("www.eliteweaver.co.uk", 80, $errno, $errstr, 30);
		$header .= "POST /testing/ipntest.php HTTP/1.0\r\n";
		$header .= "Host: www.eliteweaver.co.uk\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen ($req) . "\r\n\r\n"; 
	}else {
		$pme=1;
		$log .= "* PostMode = $postmode: INVALID. Should be 1 or 2.\n";
		$log .= "* Exiting\n\n";
		exit; 
	}
	$fp = 1;
	$pme = 1;
	### Posting Error (not posting back)
	if (!$fp && !$pme) {
		$log .= "* Error Number: $errno Error String: $errstr\n";
		$log .= "* Exiting\n\n";
		exit; 
	}else {
		$log .= "* Connection Established\n";
		$log .= "* Waiting for reply";

		### Standard Instant Payment Notifiction Variables 
		$receiver_email = $_POST['receiver_email'];
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$quantity = $_POST['quantity'];
		$invoice = $_POST['invoice'];
		$custom = $_POST['custom'];
		$option_name1 = $_POST['option_name1'];
		$option_selection1 = $_POST['option_selection1'];
		$option_name2 = $_POST['option_name2'];
		$option_selection2 = $_POST['option_selection2'];
		$num_cart_items = $_POST['num_cart_items'];
		$payment_status = $_POST['payment_status'];
		$pending25_reason = $_POST['pending25_reason'];
		$payment_date = $_POST['payment_date'];
		$settle_amount = $_POST['settle_amount'];
		$settle_currency = $_POST['settle_currency'];
		$exchange_rate = $_POST['exchange_rate'];
		$payment_gross = $_POST['payment_gross'];
		$payment_fee = $_POST['payment_fee'];
		$mc_gross = $_POST['mc_gross'];
		$mc_fee = $_POST['mc_fee'];
		$mc_currency = $_POST['mc_currency'];
		$txn_id = $_POST['txn_id'];
		$txn_type = $_POST['txn_type'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$address_street = $_POST['address_street'];
		$address_city = $_POST['address_city'];
		$address_state = $_POST['address_state'];
		$address_zip = $_POST['address_zip'];
		$address_country = $_POST['address_country'];
		$address_status = $_POST['address_status'];
		$payer_email = $_POST['payer_email'];
		$payer_id = $_POST['payer_id'];
		$payer_status = $_POST['payer_status'];
		$payment_type = $_POST['payment_type'];
		$notify_version = $_POST['notify_version'];
		$verify_sign = $_POST['verify_sign'];


		### Subscription Instant Payment Notifiction Variables 
		$subscr_date = $_POST['subscr_date'];
		$period1 = $_POST['period1'];
		$period2 = $_POST['period2'];
		$period3 = $_POST['period3'];
		$amount1 = $_POST['amount1'];
		$amount2 = $_POST['amount2'];
		$amount3 = $_POST['amount3'];
		$recurring = $_POST['recurring'];
		$reattempt = $_POST['reattempt'];
		$retry_at = $_POST['retry_at'];
		$recur_times = $_POST['recur_times'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$subscr_id = $_POST['subscr_id'];

		if ($_REQUEST['payment_status'] == "Completed" || $_REQUEST['payment_status'] == "Pending") {
			$log .= "\n* This Transaction is Valid.\n";
			$log .= "* Transaction Occured on $payment_date.\n";
			if ($txn_type == "subscr_payment") {
				$log .= "* This is a Subscription Signup\n";
				mt_srand((double)microtime()*1000000^getmypid());
				$pass_length = mt_rand($this->min_pass_length,$this->max_pass_length);
				while(strlen($spassword)<$pass_length) {
					$spassword.=substr($this->chars,(mt_rand()%strlen($this->chars)),1); 
				}
				include("include/emails.php");
				$signupmessage = str_replace("<username>","$option_selection1",$signupmessage);
				$signupmessage=str_replace("<password>","$spassword",$signupmessage);
				$signupmessage=str_replace("<first_name>","$first_name",$signupmessage);
				$signupmessage=str_replace("<last_name>","$last_name",$signupmessage);
				$signupmessage=str_replace("<login_url>","$login_url",$signupmessage);
				$subject = "$signupsubject";
				$message = "$signupmessage";
				mail($payer_email,$subject,$message,"From: $admin25email");
				$admin25signupmessage = str_replace("<username>","$option_selection1",$admin25signupmessage);
				$admin25signupmessage = str_replace("<password>","$spassword",$admin25signupmessage);
				$admin25signupmessage = str_replace("<first_name>","$first_name",$admin25signupmessage);
				$admin25signupmessage = str_replace("<last_name>","$last_name",$admin25signupmessage);
				$admin25signupmessage = str_replace("<member_email>","$payer_email",$admin25signupmessage);
				$subject = "$admin25signupsubject";
				$message = "$admin25signupmessage";
				mail($admin25email,$subject,$message,"From: $admin25email"); 
				mysql_query("insert into users25 (uid, username, password, first_name, last_name, street, city, state, zip, country, email, telephone, last_paid, signup_date) values ('','$option_selection1', '$spassword', '$first_name', '$last_name', '$address_street', '$address_city', '$address_state', '$address_zip', '$address_country', '$payer_email', '', '$payment_date', '$payment_date')");

				mysql_query("delete from pending25 where username='$option_selection1'");
				$log .= "* Member Recorded - Username: $option_selection1\n";
				$log .= "* Sending Welcome Email to $payer_email\n";
				$log .= "* Sending New Signup Alert Email to Admin\n";
			}
			if ($txn_type == "subscr_cancel") {
				$log .= "* This is a Subscription Cancel\n";
				include("include/emails.php");
				$cancelmessage = str_replace("<username>","$option_selection1",$cancelmessage);
				$cancelmessage=str_replace("<first_name>","$first_name",$cancelmessage);
				$cancelmessage=str_replace("<last_name>","$last_name",$cancelmessage);
				$subject = "$cancelsubject";
				$message = "$cancelmessage";
				mail($payer_email,$subject,$message,"From: $admin25email");
				$admin25cancelmessage = str_replace("<username>","$option_selection1",$admin25cancelmessage);
				$admin25cancelmessage = str_replace("<password>","$spassword",$admin25cancelmessage);
				$admin25cancelmessage = str_replace("<first_name>","$first_name",$admin25cancelmessage);
				$admin25cancelmessage = str_replace("<last_name>","$last_name",$admin25cancelmessage);
				$admin25cancelmessage = str_replace("<member_email>","$payer_email",$admin25cancelmessage);
				$subject = "$admin25cancelsubject";
				$message = "$admin25cancelmessage";
				mail($admin25email,$subject,$message,"From: $admin25email"); 
				mysql_query("update users25 set last_paid='Cancelled $payment_date' where username='$option_selection1'");
				$log .= "* Member Cancelled! - Username: $option_selection1\n";
				$log .= "* Sending Cancellation Email to $payer_email\n";
				$log .= "* Sending Cancellation Alert Email to Admin\n";
				$log .= "* This member needs to be manually deleted by Admin. Removing a member is final, and all member, sale, and product data is lost forever. This is why the cancellation needs to be verified by a real human, and is not automatically performed by the script. Sometimes PayPal will cancel one of it's member's subscriptions for a minor infraction like letting a credit card on file expire, and that is no reason for someone to lose all their info here.\n";
			}
			if ($txn_type == "subscr_payment2") {
					$log .= "* This is a Subscription Payment\n";
					include("include/emails.php");
					$paymentmessage = str_replace("<username>","$option_selection1",$paymentmessage);
					$paymentmessage = str_replace("<first_name>","$first_name",$paymentmessage);
					$paymentmessage=str_replace("<last_name>","$last_name",$paymentmessage);
					$subject = "$paymentsubject";
					$message = "$paymentmessage";
					mail($payer_email,$subject,$message,"From: $admin25email");
					$admin25paymentmessage = str_replace("<username>","$option_selection1",$admin25paymentmessage);
					$admin25paymentmessage = str_replace("<password>","$spassword",$admin25paymentmessage);
					$admin25paymentmessage = str_replace("<first_name>","$first_name",$admin25paymentmessage);
					$admin25paymentmessage = str_replace("<last_name>","$last_name",$admin25paymentmessage);
					$admin25paymentmessage = str_replace("<member_email>","$payer_email",$admin25paymentmessage);
					$subject = "$admin25paymentsubject";
					$message = "$admin25paymentmessage";
					mail($admin25email,$subject,$message,"From: $admin25email"); 
					mysql_query("update users25 set last_paid='$payment_date' where username='$option_selection1'");
					$log .= "* Payment Recorded! - Username: $option_selection1\n";
					$log .= "* Sending Payment Received Email to $payer_email\n";
					$log .= "* Sending Payment Received Alert Email to Admin\n";
				}
				if ($txn_type == "subscr_eot") {
				}
			}else{
				$log .= "\n* This Transaction is INVALID.\n";
				if ($txn_type == "subscr_signup") {
					$log .= "* This is an INVALID Subscription Signup\n"; 
				}
				if ($txn_type == "subscr_cancel") {
					$log .= "* This is an INVALID Subscription Cancellation\n"; 
				}
				if ($txn_type == "subscr_payment") {
					$log .= "* This is an INVALID Subscription Payment\n"; 
				}
				if ($txn_type == "subscr_eot") {
					$log .= "* This is an INVALID Subscription End Of Term\n"; 
				}
			} ### END INVALID TRANSACTION
		} ### Terminate the Socket connection
		$log .= "* Connection Closed\n";
		### Save Log Info and Print To Screen
		$file = "$logfile";
		$fp = fopen($file,"a+");
		$stuff = "$log";
		fputs($fp,"$stuff");
		fclose ($fp);
		$log = str_replace("\n","<br>",$log);
		$log .= "* Transaction Logged\n";
		echo "$log";

		### Exit
		exit;
		$log .= "* Exiting\n\n";
?>