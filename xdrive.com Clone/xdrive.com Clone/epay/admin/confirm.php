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

	mysql_query("DELETE FROM epay_signups WHERE NOW()>expire");
	$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_signups WHERE id='".addslashes($_GET['id'])."'"));
	if (!$r){
		header("Location: ../../index.php");
		exit;
	}
  
	$a = mysql_fetch_row(mysql_query("SELECT id,type FROM epay_users WHERE username='$r->user'"));
	if (!$a){
		$a = mysql_fetch_row(mysql_query("SELECT id FROM epay_users WHERE id=$r->referredby"));
		$referer = ($a[0] ? $a[0] : "NULL");

		mysql_query("INSERT INTO epay_users(username,type,email,referredby,signed_on) VALUES('$r->user','$r->type','$r->email',$referer,NOW())");
		$user = mysql_insert_id();
		if ($signup_bonus){
			transact(1,$user,$signup_bonus,"Account signup bonus");
		}
		$r = mysql_query("SELECT * FROM epay_hold WHERE paidto='{$r->email}'");
		while ($a = mysql_fetch_object($r)){
			$afrom = pruserObj($a->paidby);
			$from = $afrom->name." ( ".$afrom->email." )";
			$amount = $a->amount;
			if($transfer_percent || $transfer_fee){
				$fee = myround($amount * $transfer_percent / 100, 2) + $transfer_fee;
				$amount = $amount - $fee;
			}
			transact(98,$user,$amount,"Money Transfer From $from",'',$fee);
		}
/*
		if ($r->referredby){
			$ref = myround($signup_bonus * $referral_payout / 100, 2);
			if ($ref){
				transact(1,$r->referredby,$ref,"Referral for $r->user",$pid);
			}
		}
*/
	}else{
		$user = $a[0];
		mysql_query("UPDATE epay_users SET email='$r->email' WHERE id=$user");
		$r->type = $a[1];
	}
	mysql_query("DELETE FROM epay_signups WHERE user='$r->user'");
	if (!$allow_same_email){
		mysql_query("DELETE FROM epay_signups WHERE email='$r->email'");
	}
	($userip = $_SERVER['HTTP_X_FORWARDED_FOR']) or ($userip = $_SERVER['REMOTE_ADDR']);
	$suid = substr( md5($userip.time()), 8, 16 );
	mysql_query("UPDATE epay_users SET lastlogin=NOW(),lastip='$userip',suid='$suid' WHERE id=$user");

	mysql_query("DELETE FROM epay_visitors WHERE ip='$userip'");
	setcookie("c_user".$r->type, "$r->user");
	$data->username = $r->user;
	mail($adminemail, "$sitename New User",
		gettemplate("email_new_user", "$siteurl/index.php?a=uview&user=$user", $r->email,$r->user), 
		$defaultmail);

	if($charge_signup){
		mail($r->email, "Signup Fee Reminder",
			gettemplate("signup_fee"), 
			$defaultmail);
	}
	header("Location: ../../index.php?a=edit&suid=$suid");
?>