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
	<DIV class=large>Transaction Record</DIV><BR>
<!--
	<TABLE class=design cellspacing=0 width=100%>
	<TR>
		<TH>Total Amount</TH>
		<TH>Fee Amount</TH>
		<TH>Net Amount</TH>
		<TH>To/From</TH>
		<TH>Description</TH>
		<TH>Date</TH>
-->
<?
	($startp = $_POST['startp'] or $startp = $_GET['startp']);
	$ulist_page = 3;
	if(!$startp){$startp = 0;}
	$qr2 = mysql_query("SELECT paidto,paidby,amount,epay_transactions.comment AS comment,trdate,id,fees FROM epay_transactions WHERE (paidto=$user OR paidby=$user) AND pending=0 ORDER BY trdate DESC") or die( mysql_error() );
	$numrows = mysql_num_rows($qr2);
	$r = mysql_query("SELECT paidto,paidby,amount,epay_transactions.comment AS comment,trdate,id,fees FROM epay_transactions WHERE (paidto=$user OR paidby=$user) AND pending=0 ORDER BY trdate DESC LIMIT $startp,$ulist_page") or die( mysql_error() );
	$i = 1;
	$current = balance($user, 1);
	$namount = 0;
	while ($a = mysql_fetch_object($r)){
		$namount = $a->amount;
		if($a->paidby != $user){
			$afrusr = pruserObj($a->paidby);
			if($a->fees){
				$namount = $a->amount - $a->fees;
				$a->fees = -$a->fees;
			}
		}
		if ($a->paidto != $user){
			$a->amount = -$a->amount;
		}
		$j = $i;
		echo 	
				"<TABLE class=design cellspacing=0 width=100%>",
				"<TR>",
				"	<TH>Transaction ID:</TH>",
				"	<TD class=row$i>",$a->id,
				"<TR>",
				"	<TH>To</TH>",
				"	<TD class=row".($j+1)." >",pruser($a->paidto),
				"<TR>",
				"	<TH>From</TH>",
				"	<TD class=row".($j+1)." >",pruser($a->paidby),
				"<TR>",
				"	<TH>Total Amount</TH>",
				"	<TD class=row".($j+1)." title='$current'>",prsumm($a->amount, 1),
				"<TR>",
				"	<TH>Fee Amount</TH>",
				"	<TD class=row".($j+1).">",prsumm($a->fees, 1),
				"<TR>",
				"	<TH>Net Amount</TH>",
				"	<TD class=row".($j+1).">",prsumm($namount, 1),
				"<TR>",
				"	<TH>Description</TH>",
				"	<TD class=row".($j+1).">",$a->comment,
				"<TR>",
				"	<TH>Date</TH>",
				"	<TD class=row".($j+1).">",prdate($a->trdate),
				"</TABLE><br><br>";
		if ($a->paidto != $a->paidby)
			$current -= $a->amount;
		$i = 3 - $i;
	}
?>
<br><br>
<TABLE class=empty cellspacing=0 width=100%>
<form method=post name=pform>
<input type=hidden name=startp value=0>
<TR>
		<td align=left><div align=left>
<?	if($startp > 0){	?>
			<a href="javascript:pform.startp.value = '<?=($startp - $ulist_page)?>'; pform.submit();"><b>&lt;&lt; Last <?=$ulist_page?> records</b></a>
<?	}else{	?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?	}	?>
		</td>
		<td align=center><div align=center>
			<b>&lt;&lt; Showing <?=($startp + $ulist_page)?> of <?=$numrows?> records &gt;&gt;</b>
		</td>
		<td align=right><div align=right>
<?	if($numrows > ($startp + $ulist_page)){		?>
			<a href="javascript:pform.startp.value = '<?=($startp + $ulist_page)?>'; pform.submit();"><b>Next <?=$ulist_page?> records &gt;&gt;</b></a>
<?	}else{	?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?	}	?>

		</td>
</TR>
</TABLE>
</form>
<!--
	</TD>
</TR>
</TABLE>
-->