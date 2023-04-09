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
if ($user != 3) {

// Get balance and last transaction
$balance = balance($user, 1);
$r = mysql_fetch_object(mysql_query(
  "SELECT paidto,amount,comment,trdate FROM epay_transactions WHERE (paidto=$user OR paidby=$user) AND pending=0 ORDER BY trdate DESC LIMIT 1"
));
if ($r && $r->paidto != $user) $r->amount = -$r->amount;

?>
<!--
<div class=large>Account Management</div>
Welcome <?=htmlspecialchars($data->name)?> !<br>
<br>
-->
<?
if ($_POST['quote'])
{
  $r = mysql_fetch_row(mysql_query("SELECT * FROM epay_quotes WHERE submit_date=NOW() AND submit_by=$user"));
  if (!$r)
  {
    list($last) = mysql_fetch_row(mysql_query("SELECT MAX(id) FROM epay_quotes"));
    $id = $last + 1;
    mysql_query("INSERT INTO epay_quotes VALUES($id,'".addslashes($_POST['quote'])."',$user,NOW())");
    echo "Your quote was posted.<br><br>";
  }
}
$show = 1;
if( ($charge_signup) ){
	$show = 0;
	if( ($data->fee) ){
		$show = 1;
	}
}
?>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
<tr bgcolor="#FFFFFF">
	<td width="10"></td>
	<td width="150" valign="top">
<?
	include("src/acc_menu.php");
?>
	</td>
    <td width="20"></td>
    <td width="510" valign="top">
		<table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0" class="empty">
		<tr bgcolor="#FFFFFF">
			<td height="25" colspan="2">
				<span class="text4">Account Overview</span>
				<hr width="100%" size="1"><br>
			</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td width="15%" height="20"><strong>Name:</strong></td>
			<td><?=$data->username?></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td height="20"><strong>Email:</strong></td>
			<td><?=$data->email?></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td height="20"><strong>Balance:</strong></td>
			<td><?=prsumm($balance)?></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td height="20"><strong>Amount:</strong></td>
			<td><?=prsumm($r->amount, 1)?></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td height="20"><strong>Description: </strong></td>
			<td><?=htmlspecialchars($r->comment)?></td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td height="20"><strong>Date:</strong></td>
			<td><?=prdate($r->trdate)?></td>
		</tr>
		<tr>
			<td colspan=2 height="1" colspan="2" bgcolor="#C8C8C8">
				<a href=?a=viewtransactions&<?=$id?>>View All Transactions</a></SPAN>
				<hr width="100%" size="1"><br>
				Most Recent Transactions<br>
				<TABLE class=design cellspacing=0 width=100%>
				<tr>
					<th>To/From
					<th>Name/Email
					<th>Amount
					<th>Date
					<th>Status
					<TH>&nbsp;
<?
				// Most Recent Transactions
				$r2 = mysql_query("SELECT * FROM epay_transactions WHERE (paidto=$user OR paidby=$user) ORDER BY trdate DESC LIMIT 0,7");
				$i = 1;
				while ($a = mysql_fetch_object($r2)){
					if ($a->paidto != $user){
						$a->amount = -$a->amount;
						$tofrom = "From";
					}else{
						$tofrom = "To";
					}
?>
					<TR class=row<?=$i?>>
						<TD class=row<?=$i?> align=center><?=$tofrom?>
						<TD class=row<?=$i?> align=center><?=pruser($a->paidto == $user ? $a->paidby : $a->paidto)?>
						<TD class=row<?=$i?> align=center><?=prsumm($a->amount,1)?>
						<TD class=row<?=$i?> align=center><?=prdate($a->trdate)?>
						<TD class=row<?=$i?> align=center><?=($a->pending ? "pend" : "done")?>
						<TD class=row<?=$i?> align=center><a href="?a=transdet&did=<?=$a->id?>">Details</a>
					</TR>
<?
					$i = 3 - $i;
				}
?>
				</table>
				<br>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
  		<tr>
  			<td colspan="2" valign="bottom">
		  		<br><br><br><br><br><br><br>
				<!-- Referrals -->
				<TABLE cellspacing=1 class=empty>
				<TR>
				<TD class=small rowspan=2 valign=top>Your <a href=index.php?read=referrals.htm&<?=$id?>>referral URLs</a> are:&nbsp;
				<TD class=small><?=$siteurl?>/?r=<?=$user?></TD>
				</TR>
				</TABLE>
				<br>
		  	</td>
		</tr>
		</table>
	</td>
	<td width="10"></td>
</tr>
</table>
<?
}else{
	echo "<br><br><br>You are logged in as admin.<br><br><br>";
}
?>