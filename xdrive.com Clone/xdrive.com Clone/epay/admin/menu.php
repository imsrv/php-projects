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
	session_start();
	if($_SESSION['suid']){$suid = $_SESSION['suid'];$id = "suid=$suid";}
	if(!$suid){$suid = $_GET['suid'];$id = "suid=$suid";}
	($userip = $_SERVER['HTTP_X_FORWARDED_FOR']) or ($userip = $_SERVER['REMOTE_ADDR']);
	if($securelogin){
		$qr1 = mysql_fetch_row(mysql_query("SELECT id FROM epay_users WHERE id=3 AND suid='".addslashes($suid)."' AND NOW()<DATE_ADD(lastlogin, INTERVAL $session_mins MINUTE) AND lastip='$userip'"));
	}else{
		$qr1 = mysql_fetch_row(mysql_query("SELECT id FROM epay_users WHERE id=3 AND suid='".addslashes($suid)."'")); // AND NOW()<DATE_ADD(lastlogin, INTERVAL $session_mins MINUTE) AND lastip='$userip'
	}
	if (!$qr1) die("<a href=index.php target=_top style='color: white;'>Please login again</a>");
	mysql_query("UPDATE epay_users SET lastlogin=NOW() WHERE id=3");
?>
<HEAD>
	<TITLE><?=$sitename?> Administration</TITLE>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<SCRIPT LANGUAGE="JavaScript">
	<!-- // hide
	function gotowhat(s){
		var d = s.options[s.selectedIndex].value
		if(d){
			parent.right.location.href = "right.php?a=config&what="+d+"&<?=$id?>";
		}
		s.selectedIndex=0
	}
	function gotomod(s){
		var d = s.options[s.selectedIndex].value
		if(d){
			parent.right.location.href = "right.php?a=moderate&whatm="+d+"&<?=$id?>";
		}
		s.selectedIndex=0
	}
	function gotoedit(s){
		var d = s.options[s.selectedIndex].value
		if(d){
			parent.right.location.href = "right.php?a=editpage&filename="+d+"&<?=$id?>";
		}
		s.selectedIndex=0
	}
	function gotocluster(s){       
		var d = s.options[s.selectedIndex].value
		if(d){
			parent.right.location.href = d
		}
		s.selectedIndex=0
	}
	// end hide -->
	</SCRIPT> 
	<style type="text/css">
	<!--
		a:hover {  font-weight: bold; text-decoration: none; text-transform: capitalize}
		a:link {  font-weight: bold; text-decoration: none; text-transform: capitalize}
		a:visited {  font-weight: bold; text-decoration: none; text-transform: capitalize}
		a:active {  font-weight: bold; text-decoration: none; text-transform: capitalize}
		.menu {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; font-weight: bold; color: #FFFFFF; background-color: #000099; text-decoration: none}
		.label {  font-family: Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; text-decoration: none}
		.fields {  font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #000099; text-decoration: none; background-color: #F3F3F3; border-color: #666666 #333333 #333333 #999999; font-style: normal; padding-top: 0px; padding-right: 2px; padding-bottom: 0px; padding-left: 2px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px}
		.fields_text {  font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: normal; color: #000000; background-color: #E5E5E5; border-color: #000099 #000099 #000099 #000033 border-top-width: thin; border-right-width: thin}
		.fields_text2 {  font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: normal; color: #000000; background-color: #DBDBDB; border-color: #000099 #000099 #000099 #000033 border-top-width: thin; border-right-width: thin}
		.fields_back {  background-color: #000099; font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #FFFFFF}
		.main {  font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000099; background-color: #F9F9F9}
	-->
	</style>
</head>
<body rightmargin="0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fields_text">
<tr><FORM method=post action=right.php target=right name="form1"><INPUT type=hidden name=a><INPUT type=hidden name=suid value="<?=$suid?>">
	<td bgcolor="#CCCCCC"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="0" height="21" class="fields_back">
		<tr> 
			<td>
<!--- --------------------------------------------------------------------------- -->
				<table width="75%" border="0" cellspacing="1" cellpadding="1" height="0" class="label">
				<tr> 
					<td>
						<? list($r1) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE paidto>10 AND paidto<100 AND pending=1")); ?> 
						<? list($r2) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE paidto>10 AND paidto<100 AND pending=0")); ?> 
						<? list($r3) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE paidby>10 AND paidby<100 AND pending=1")); ?> 
						<? list($r4) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE paidby>10 AND paidby<100 AND pending=0")); ?> 
						<? list($r5) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_safetransfers")); ?>
						<SELECT class="menu" onChange="gotocluster(this)">
							<option value="">ACCOUNTING
							<option value=right.php?a=reports&<?=$id?>>&gt; Transaction Summary
							<option>- -WITHDRAWALS- -
							<option value=right.php?a=newwdr&<?=$id?>>&gt; Charge user
							<option value=right.php?a=viewwdr&t=1&<?=$id?>>&gt; View pending(<?=$r1?>)
							<option value=right.php?a=viewwdr&t=0&<?=$id?>>&gt; archived (<?=$r2?>)
							<option>- -DEPOSITS- -
							<option value=right.php?a=newdep&<?=$id?>>&gt; Add funds
							<option value=right.php?a=viewdep&t=1&<?=$id?>>&gt; View pending (<?=$r3?>)
							<option value=right.php?a=viewdep&t=0&<?=$id?>>&gt; archived (<?=$r4?>)
							<option>- -SAFE TRANSFERS- -
							<option value=right.php?a=safetr&<?=$id?> target=right>&gt; Pending safe transfers (<?=$r5?>)
							<OPTION>--------------------------------</OPTION>
						</select>
					<td>
						<SELECT class="menu" onChange="gotocluster(this)">
							<? list($r1) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_users WHERE type != 'sys'")); ?>
							<? list($r2) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_users WHERE type != 'sys' AND suspended=1")); ?>
							<option value="">MEMBERS
							<option value=right.php?a=searchu&<?=$id?>>&gt; List Accounts (<?=($r1)?>)
							<option value=right.php?a=searchu&sus=1&<?=$id?>>&gt; List Suspended Accounts (<?=($r2)?>)
							<option value=right.php?a=addu&<?=$id?>>&gt; Add New Account
							<OPTION>--------------------------------</OPTION>
						</SELECT>
					<td>
						<SELECT class="menu" onChange="gotowhat(this)">
							<option value="">SITE CONFIG SELECTIONS
							<option value=2>&gt; Script Configuration
							<option value=11>&gt; Accounting Configuration
							<option value=1>&gt; Email & Misc. Templates
							<option value=12>&gt; Categories for Selling
							<option value=9>&gt; FAQ Sections List
							<option value=10>&gt; FAQ List
							<OPTION>--------------------------------</OPTION>
						  </SELECT>
					</TD>
					<TD>
						<SELECT class="menu" onChange="gotoedit(this)">
							<option value="">EDIT TEMPLATES
							<?if ( !@file_exists('header.htm') ){?>
							<option value="header.php">&gt; Header
							<?}else{?>
							<option value="header.htm">&gt; Header
							<?}?>
							<?if ( !@file_exists('footer.htm') ){?>
							<option value="footer.php">&gt; Footer
							<?}else{?>
							<option value="footer.htm">&gt; Footer
							<?}?>
							<option value="src/default.htm">&gt; Default page
							<option value="src/defaultfaq.htm">&gt; Default FAQ page
							<option>- -Help Files- -
							<option value="help/aboutus.htm">&gt; About Us
							<option value="help/fees.htm">&gt; Fees
							<option value="help/contact.htm">&gt; Contact
							<option value="help/privacy.htm">&gt; Privacy
<?	if($affil_on){	?>
							<option value="help/referrals.htm">&gt; Affiliate Details
							<option value="help/referrals_code.htm">&gt; Affiliate Links
<?	}	?>
							<option value="help/terms.htm">&gt; Terms
							<option value="help/linkcodes.htm">&gt; Link Codes
							<OPTION>--------------------------------</OPTION>
						</SELECT>
					<td>
						<SELECT class="menu" onChange="gotocluster(this)">
							<option value="">MISCELLANEOUS
							<option value=right.php?a=massmail&<?=$id?> target=right>&gt; Mass Mailing
							<option value=right.php?a=backup&<?=$id?> target=right>&gt; Backup
							<option value=right.php?a=restore&<?=$id?> target=right>&gt; Restore
							<OPTION>--------------------------------</OPTION>
						</select>
					</TD>
<!--
					<TD>
						<a href=# onClick="document.location.reload();">Reload menu</a>
					</TD>
-->
					</FORM>
				</tr>
				</table>
<!--- --------------------------------------------------------------------------- -->
		</tr>
		</table>
	</td>
</tr>
</table>
</body>
</html>