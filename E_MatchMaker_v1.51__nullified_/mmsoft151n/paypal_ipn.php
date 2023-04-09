<?
##############################################################################
#                                                                            #
#                            paypal_ipn.php                                  #
#                                                                            #
##############################################################################
# PROGRAM : E-MatchMaker                                                     #
# VERSION : 1.51                                                             #
#                                                                            #
# NOTES   : site using default site layout and graphics                      #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2001-2002                                                    #
# Supplied by          : CyKuH [WTN]                                         #
# Nullified by         : CyKuH [WTN]                                         #
# Distribution:        : via WebForum and xCGI Forums File Dumps             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of MatchMakerSoftware             #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?

require_once("siteconfig.php");


// class that works with PayPal Instant Payment Notification. It takes what was
// sent from PayPal and sends an indentical response back to PayPal, then waits
// for verification from PayPal
class paypal_ipn
{
	var $paypal_post_vars;
	var $paypal_response;

	var $timeout;

	// error logging info
	var $error_log_file;
	var $error_email;

	function paypal_ipn($paypal_post_vars)
	{
		$this->paypal_post_vars = $paypal_post_vars;

		$this->timeout = 120;
	}

	// sends response back to paypal
	function send_response()
	{
		$fp = @fsockopen( "www.paypal.com", 80, &$errno, &$errstr, 120 ); 

		if( !$fp )
		{ 
			$this->error_out("PHP fsockopen() error: " . $errstr);
		}

		else 
		{
			// put all POST variables received from Paypal back into a URL encoded string
			foreach($this->paypal_post_vars AS $key => $value)
			{
				// if magic quotes gpc is on, PHP added slashes to the values so we need
				// to strip them before we send the data back to Paypal.
				if( @get_magic_quotes_gpc() )
				{
					$value = stripslashes($value);
				}

				// make an array of URL encoded values
				$values[] = "$key" . "=" . urlencode($value);
			}

			// join the values together into one url encoded string
			$response = @implode("&", $values);

			// add paypal cmd variable
			$response .= "&cmd=_notify-validate";

			fputs( $fp, "POST /cgi-bin/webscr HTTP/1.0\r\n" ); 
			fputs( $fp, "Host: https://www.paypal.com\r\n" ); 
			fputs( $fp, "User-Agent: ".$GLOBALS['HTTP_USER_AGENT'] ."\r\n" ); 
			fputs( $fp, "Accept: */*\r\n" ); 
			fputs( $fp, "Accept: image/gif\r\n" ); 
			fputs( $fp, "Accept: image/x-xbitmap\r\n" ); 
			fputs( $fp, "Accept: image/jpeg\r\n" ); 
			fputs( $fp, "Content-type: application/x-www-form-urlencoded\r\n" ); 
			fputs( $fp, "Content-length: " . strlen($response) . "\r\n\n" ); 

			// send url encoded string of data
			fputs( $fp, "$response\n\r" ); 
			fputs( $fp, "\r\n" );

			$this->send_time = time();
			$this->paypal_response = ""; 

			// get response from paypal
			while( !feof( $fp ) ) 
			{ 
				$this->paypal_response .= fgets( $fp, 1024 ); 

				// waited too long?
				if( $this->send_time < time() - $this->timeout )
				{
					$this->error_out("Timed out waiting for a response from PayPal. ($this->timeout seconds)");
				}

			} // end while

			fclose( $fp );

		} // end else

	} // end function send_response()

	// returns true if paypal says the order is good, false if not
	function is_verified()
	{
		if( ereg("VERIFIED", $this->paypal_response) )
		{
			return true;
		}
		else
		{
			return false;
		}

	} // end function is_verified

	// returns the paypal payment status
	function get_payment_status()
	{
		return $this->paypal_post_vars['payment_status'];
	}

	// writes error to logfile, exits script
	function error_out($message)
	{

		$date = date("D M j G:i:s T Y", time());

		// add on the data we sent:
		$message .= "\n\nThe following input was received from (and sent back to) PayPal:\n\n";

		@reset($this->paypal_post_vars);
		while( @list($key,$value) = @each($this->paypal_post_vars) )
		{
			$message .= $key . ':' . " \t$value\n";
		}

		// log to file?
		if( $this->error_log_file )
		{
			@fopen($this->error_log_file, 'a');
			$message = "$date\n\n" . $message . "\n\n";
			@fputs($fp, $message);
			@fclose($fp);
		}

		// email errors?
		if( $this->error_email )
		{
			mail($this->error_email, "[$date] paypay_ipn error", $message);
		}

		exit;

	} // end function error_out

} // end class paypal_ipn

// PayPal will send the information through a POST
$paypal_info = $HTTP_POST_VARS;

$paypal_ipn = new paypal_ipn($paypal_info);

// where to contact us if something goes wrong
$paypal_ipn->error_email = $mmconfig->webmaster;

// We send an identical response back to PayPal for verification
$paypal_ipn->send_response();

// PayPal will tell us whether or not this order is valid.
// This will prevent people from simply running your order script
// manually

if( !$paypal_ipn->is_verified() )
{
	// bad order, someone must have tried to run this script manually
	$paypal_ipn->error_out("Bad order (PayPal says it's invalid)");
}

// payment status
switch( $paypal_ipn->get_payment_status() )
{
	case 'Completed':
		// order is good
	break;

	case 'Pending':
		// money isn't in yet, just quit.
		// paypal will contact this script again when it's ready
		$paypal_ipn->error_out("Pending Payment");
	break;

	case 'Failed':
		// whoops, not enough money
		$paypal_ipn->error_out("Failed Payment");
	break;

	case 'Denied':
		// denied payment by us
		// not sure what causes this one
		$paypal_ipn->error_out("Denied Payment");
	break;

	default:
		// order is no good
		$paypal_ipn->error_out("Unknown Payment Status" . $paypal_ipn->get_payment_status());
	break;

} // end switch

// Email the information to us
$date = date("D M j G:i:s T Y", time());

$message .= "\n\nThe following info was received from PayPal - $date:\n\n";
@reset($paypal_info);
while( @list($key,$value) = @each($paypal_info) )
{
	$message .= $key . ':' . " \t$value\n";
}

if($payment_gross == $mmconfig->vmembercost && $receiver_email == $mmconfig->paypalemail) {
  $noerror1 = $db->Execute("update verified set paid = 1 where username = '$username'");
  $noerror2 = $db->Execute("update verified set paid = 1 where username = '$custom'");
  $noerror2 = $db->Execute("update verified set paid = 1 where username = '$invoice'");
  if($noerror1 && $noerror2)
     mail("$mmconfig->webmaster", "[$date] Verified Member PayPal Payment Notification", $message);
  else 
     mail("$mmconfig->webmaster", "[$date] Verified Member Payment Status Update Error", $message);
  header("Location: index.php");
  exit;
}
else {
  mail("$mmconfig->webmaster", "[$date] Verified Member Possible Hacker Attempt", "Member paid an amount not equal to price set for Verified Member program.\n" . $message);
}

?>
