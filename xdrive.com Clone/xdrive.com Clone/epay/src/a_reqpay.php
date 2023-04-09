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
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
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
					<td><font face="Arial, Helvetica, sans-serif" size="3" color="#000066"><b>Request Money</b></font></td>
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
		if (!$r){
//			errform("There are no users with the specified username", 'username');
		}
	}

	if ($_POST['transfer'] && !$posterr){
		$amount = $_POST['amount'];
		$afrom = pruserObj($user);
		$from = $afrom->email;
		$_POST['username'] = str_replace("\r\n",",",$_POST['username']);
		$users = explode(",",$_POST['username']);
		while( list(,$duser) = each($users) ){
			if($_POST['memo']){
				$comments = $_POST['memo'];  
			}else{
				$comments = "Request For Money from ".$afrom->user;
			}
			echo "Sending Request to: $duser<br>";			
			// send mail to user
			$r = mysql_fetch_row(mysql_query(
				"SELECT id FROM epay_users WHERE (username='".addslashes($duser)."' OR email='".addslashes($duser)."')"
			));
			if (!$r){
				// unknown user
				$info = $from."@@".$amount;
				mail($duser, "Request For Money From $sitename", 
					$emailtop.
					gettemplate("reqpay_unknown", "$siteurl?a=signup&semail=".$_POST['username'],$info).
					$emailbottom, 
					$defaultmail
				);
			}else{
				// known user
				$info = $from."@@".$amount;
				mail($duser, "Request For Money From $sitename", 
					$emailtop.
					gettemplate("reqpay_email", "$siteurl/",$info).
					$emailbottom, 
					$defaultmail
				); 
			}
		}
		echo "Request has been sent<br>";
//		$action = 'account';
//		header("Location:?a=account");
	}else{
?>
		<CENTER>
		<P><FONT COLOR="#FF0000" FACE="Verdana,Tahoma,Arial,Helvetica,Sans-serif,sans-serif"><B>
 		Bill customers, individuals or groups by email, even if they don't have a <?=$sitename?> 
 		account! The recipient will receive an email with instructions on how to pay you using 
 		<?=$sitename?>. 
		</B></FONT></p>
		<TABLE class=design cellspacing=0 width=100%>
		<form method=post>
		<TR>
			<TH colspan=2>Request Money from Another Account</TH>
		</TR>
		<TR>
			<TD>
				Recipient's Email:<br>
			</TD>
			<TD><textarea name="username" cols="30" rows="6"><?=$_POST['username']?></textarea></TD>
		<TR>
			<TD>Amount:</TD>
			<TD><?=$currency?> <INPUT type=text name=amount size=5 maxLength=5 value="<?=$_POST['amount']?>"></TD></TR>
		<TR><TD>Notes: (optional)</TD>
			<TD><textarea name="memo" cols="30" rows="6"><?=$_POST['SUGGESTED_MEMO']?></textarea></TD></TR>
		<TR>
			<TH class=submit colspan=2><input type=submit name=transfer value='Request >>'></TH>
		</TR>
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