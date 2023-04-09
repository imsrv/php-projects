<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
include("prefs.php3");

if(isset($PHP_AUTH_USER)){
	// User ID will be present if user has logged in. We must then authenticate
	// on each page to ensure user is not trying to trick program by changing 
	// his user id on the command line via get or post or fake cookies
	include("auth.php3");
}

include("functions.php3");

// EasyShop is copywrite Eyekon http://www.eyekon.com/Easy/Shop, All rights reserved 1998

// This file is included via the PHP Prepend File option as set in .htaccess (or <direcotory> option in apache)
// Since this file is coming first, make sure no output is generated anywhere (except in debug mode)
// This is required as authentication headers and cookies can not be sent
// if there is other output before them.

// Determine if session has been assigned... if not, set a session ID
// and set a cookie with session as value and restrict cookie to current server
// Expiry time is set to 24 hours
if(!isset($action)){ $action = "";}

if(!isset($session)){
	$session = uniqid($remote_host);
}
// Use exp to set session expiry... -1 for end of session (user closes browser)
// or a positive number in seconds (eg: 86400 = 1 day.. user can order stuff
// and come back up to one day later and the order will still be there.

$exp = "-1";

if($secure == "Yes"){
	// if user is in secure server, use secure cookie too
	SetCookies(1);
}else{
	SetCookies(0);
}

// The following section deals with user actions. For each possible action, 
// code below will be executed.

if(isset($action)){
	if($action == "Email Me My Password"){
		include("email_head.php3");
	}
	if($action == "Order Items"){
		include("order_head.php3");
	}
	if($action == "Empty Cart"){
		include("empty_head.php3");
	}
	if($action == "Update Cart"){
		include("update_head.php3");
	}
	if($action == "Log In"){
		include("auth.php3");
		$action = "Log In";
	}
	if($action == "Create Account"){
		include("create_head.php3");
	}
	if($action == "Update Bill To Info"){
		include("update_billto_head.php3");
	}
	if($action == "Update Ship To Info"){
		include("update_shipto_head.php3");
	}
	if($action == "Update Payment Info"){
		include("update_payment_head.php3");
	}
	if($action == "Submit Order On Line"){
		include("submit_head.php3");
	}
	if($action == "Print Invoice"){
		$tbl_bgcolor="#FFFFFF";
		$hdr_bgcolor="#EFEFEF";
		$bdy_bgcolor="#FFFFFF";
		include("cart.php3");
		exit;
	}
} // end if $action


?>
