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
<table width="700" border="0" align="center" bgcolor="#FFFFFF">
<tr>
	<td>
		<table width="620" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#FFFFFF">
		<tr>
			<td width=150 height="314" valign="top">
<?
	include("src/acc_menu.php");
?>
			</td>
			<td width=20> </td>
			<td width="519" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
					<td><font face="Arial, Helvetica, sans-serif" size="3" color="#000066"><b>Send Money</b></font></td>
				</tr>
				<tr>
					<td bgcolor="#000000" height=1></td>
				</tr>
				<tr>
					<td> </td>
				</tr>
				<tr>
					<td>
<?
	$balance = balance($user);
	if ($_POST['transfer']){
		$posterr = 0;
		$_POST['amount'] = myround($_POST['amount']);

		// Check funds
		if ($balance < $_POST['amount'])
			errform('You do not have enough money in your account', 'amount');
		if ($_POST['amount'] < 0)
			errform('Please enter a valid amount', 'amount');
		if ($_POST['amount'] >= $minimal_transfer){
			// asdfasdfsdaafd
		}else{
			errform('Sorry, but the minimum amount you can transfer is '.$currency.$minimal_transfer,'amount');
		}

		// Check username
		$r = mysql_fetch_row(mysql_query(
			"SELECT id FROM epay_users WHERE (username='".addslashes($_POST['username'])."' OR email='".addslashes($_POST['username'])."')"
		));
		if($r->id == $user){
			errform("You cannot send money to yourself", 'username');
		}
		$afrom = pruserObj($user);
		$from = $afrom->email;
		$username = $afrom->username;
		if($username == $_POST['username'] || $from == $_POST['username']){
			errform("You cannot send money to yourself", 'username');
		}
	}

	if ($_POST['transfer'] && !$posterr){
		$amount = $_POST['amount'];
		$afrom = pruserObj($user);
		$from = $afrom->email;
		if($transfer_percent || $transfer_fee){
			$fee = myround($amount * $transfer_percent / 100, 2) + $transfer_fee;
			$amount = $amount - $fee;
		}
		if($_POST['memo']){
			$comments = $_POST['memo'];  
		}else{
			$comments = "Money Transfer To ".$_POST['username'];
		}
		$r = mysql_fetch_row(mysql_query(
			"SELECT id FROM epay_users WHERE (username='".addslashes($_POST['username'])."' OR email='".addslashes($_POST['username'])."')"
		));
		if (!$r){
			// unknown user
			transact($user,98,$_POST['amount'],"Transfer to {$_POST['username']}",'',$fee);
			mysql_query("INSERT INTO epay_hold(paidby,paidto,amount) VALUES($user,'{$_POST['username']}',{$_POST['amount']})");
			$info = $from."@@".$_POST['amount'];
			mail($_POST['username'], "Money Transfer From $sitename", 
				$emailtop.
				gettemplate("transfer_unknown", "$siteurl?a=signup&semail=".$_POST['username'],$info).
				$emailbottom, 
				$defaultmail
			);
		}else{
			// known user
			transact($user,$r[0],$_POST['amount'],$comments,'',$fee);
			$info = $from."@@".$amount;
			mail($_POST['username'], "Money Transfer From $sitename", 
				$emailtop.
				gettemplate("transfer_email", "$siteurl",$info).
				$emailbottom, 
				$defaultmail
			); 
		}		
		$action = 'account';
		header("Location:?a=account");
	}else{
?>
		<CENTER>
		<P><FONT COLOR="#FF0000" FACE="Verdana,Tahoma,Arial,Helvetica,Sans-serif,sans-serif"><B>
		You must add funds to your account before you can send payments. If you have already added funds to your account then proceed by clicking on one of the links below. 
		</B></FONT></p>
		<TABLE class=design cellspacing=0>
			<form method=post>
		<TR><TH colspan=2>Send Money to Another Account</TH></TR>
		<TR><TD>Send Money To:</TD>
			<TD><INPUT type=text name=username size=16 maxLength=40 value="<?=$_POST['username']?>"></TD>
		<TR><TD>Amount to transfer:</TD>
			<TD><?=$currency?> <INPUT type=text name=amount size=5 maxLength=5 value="<?=$_POST['amount']?>"></TD></TR>
		<TR><TD>Notes: (optional)</TD>
			<TD><textarea name="memo" cols="30" rows="6"><?=$_POST['SUGGESTED_MEMO']?></textarea></TD></TR>
		<TR><TH class=submit colspan=2><input type=submit name=transfer value='Transfer >>'></TH></TR>
		<?=$id_post?>
		</FORM>
		</TABLE>
		</CENTER>
<?
	}
?>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</table>