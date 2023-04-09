<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#           Todd M. Findley                                                        #
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
if ($_POST['signup']){
	$posterr = 0;

	if($useturingnumber){
		if( $_SESSION['noautomationcode'] != $_POST['thecode'] ){
			errform('The Turing Number code does not match', 'thecode'); // #err
		}
	}  
	// Check username
	if (!preg_match("/^[\\w\\-]{1,16}$/i", $_POST['login2']))
		errform('The username should consist from letters and digits only', 'login2'); // #err

	// Check if it exists
	if ($_POST['login2']){
	$r = mysql_fetch_row(mysql_query("SELECT id FROM epay_users WHERE username='".addslashes($_POST['login2'])."'"));
	if ($r[0])
		errform('The username you have chosen already exists. Please pick another.', 'login2'); // #err
	}

	if(!$allow_same_ip){
		if(!isset($_GET["ipaddress"]) || ($_GET["ipaddress"] == "")) { 
			$ipaddress = $_SERVER['REMOTE_ADDR'];
			$local = 1; 
		} else {
			$ipaddress = $_GET["ipaddress"];
			$local = 0; 
		}
		if($ipaddress){
			$qr = mysql_fetch_row(mysql_query("SELECT ipaddress FROM epay_signups WHERE ipaddress='$ipaddress'"));
			if ($qr[0]){
				errform('A user has already signed up from the same IP as you.', 'login2'); // #err
			}else{
				$qr = mysql_fetch_row(mysql_query("SELECT ipaddress FROM epay_users WHERE (ipaddress='$ipaddress' OR lastip='$ipaddress') AND type !='sys'"));
				if ($qr[0]){
					errform('A user has already signed up from the same IP as you.', 'login2'); // #err
				}
			}
		}	
	}
  
	// Check email
	if (!email_check($_POST['email']) ){
		errform('You have entered an invalid email address', 'email'); // #err
	}

	if(!$_POST['iagree']){
		errform('You must agree to the Terms and Conditions in order to signup', 'iagree'); // #err
	}
	
	// Check if email exists
	if (!$allow_same_email && !$posterr){
		$r = mysql_fetch_row(mysql_query("SELECT id FROM epay_users WHERE email='".addslashes($_POST['email'])."'"));
		if ($r){
			errform('The email address you supplied is already registered in the database.', 'email'); // #err
		}
	}
}

if ($_POST['signup'] && !$posterr){
	if(!isset($_GET["ipaddress"]) || ($_GET["ipaddress"] == "")) { 
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$local = 1; 
	} else {
		$ipaddress = $_GET["ipaddress"];
		$local = 0; 
	}
	$r = mysql_fetch_row(mysql_query("SELECT id FROM epay_users WHERE id='".addslashes($_POST['r'])."'"));
	$referred = ($r[0] ? $r[0] : "NULL");
  
	$uid = substr( md5(time()), 8, 16 );
	mysql_query("INSERT INTO epay_signups SET
					id='$uid',
					email='{$_POST['email']}',
					user='{$_POST['login2']}',
					type='$atype',
					expire=DATE_ADD(NOW(),INTERVAL 3 DAY),
					referredby=$referred,
					ipaddress='$ipaddress'") or die( mysql_error() );
//	mysql_query("INSERT INTO epay_signups VALUES('$uid','{$_POST['email']}','{$_POST['login2']}','$atype',DATE_ADD(NOW(),INTERVAL 3 DAY),$referred,'$ipaddress')");
	mail(	$_POST['email'], "Confirm E-mail for $sitename", 
    		$emailtop.gettemplate("email_signup", "$siteurl/epay/admin/confirm.php?id=$uid").$emailbottom, 
  			$defaultmail); 
  	prpage("html_signup");
}else{
	if($_GET['semail'])$_POST['email']=$_GET['semail'];
?>

<BR>
<CENTER>
<TABLE class=design cellspacing=0 width=75%>
<FORM method=post>
<TR><TH colspan=2>New Users Registration</TH></TR>
<TR>
	<TD>Select a Username:</TD>
	<TD>
		<INPUT type=text name=login2 size=16 maxLength=16 value="<?=htmlspecialchars($_POST['login2'])?>">
	</TD>
</TR>
<TR>
	<TD>
		Email address:<BR>
		<SPAN class=small> Note: Valid email address is required to complete signup process. (<a href=index.php?read=privacy.htm&brand=<?=$brand?>&<?=$id?>>Privacy Policy</a>)</span>
	</TD>
	<TD><INPUT type=text name=email size=30 value="<?=htmlspecialchars($_POST['email'])?>"></TD></TR>
<?
	if($useturingnumber){
?>
<TR>
	<TD>
		Turing Number:<br>
	</TD>
	<Td>
		<INPUT type=text name=thecode size=30 maxLength=30 value="">
<?
		$sid	=	session_id();
		if(!$sid){
			session_start();
			$sid	=	session_id();
		}
		$noautomationcode = "";
		for($i=0; $i<5;$i++){
			$noautomationcode = $noautomationcode.rand(0,9);
		}
		//save it in session
		$_SESSION['noautomationcode'] = $noautomationcode;
?>
		<img src='epay/humancheck/humancheck_showcode.php'>
	</td>
<?
	}
?>
<TR>
	<TD colspan=2>
	    <input type="checkbox" name="iagree" value="1">Yes, I have read the the <a href="javascript:window.open('popup.php?read=terms.htm','','width=500,height=500,scrollbars=yes,resizable=yes');void(0);">Terms and Conditions</a> prior to signing up
	</TD>
</TR>
<?	if($charge_signup){	?>
<TR>
	<TD colspan=2>
		Please note, there is a one-time signup fee of $ <?=$signup_fee?> required upon <br>
		completion of registration.
	</TD>
</TR>
<?	}	?>
<TR>
	<TH colspan=2 class=submit>
		<INPUT type="submit" name=signup class=button value='Sign up >>'>
	</TH>
	<?=($_COOKIE['fastrefer'] ? "<input type=hidden name=r value=\"".htmlspecialchars($_COOKIE['fastrefer'])."\">\n" : "")?>
	<?=$id_post?>
</TR>
</FORM>
</TABLE>
<BR>
<DIV class=small>Please provide a valid e-mail address, as you will have to confirm it before finishing the signup process.</DIV>
</CENTER>
<?
}
?>