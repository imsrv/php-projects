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
	$today = getdate(); 
	list($r1) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE paidto>10 AND paidto<100 AND pending=1"));
	list($r2) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE paidto>10 AND paidto<100 AND pending=0"));
	list($r3) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE paidby>10 AND paidby<100 AND pending=1"));
	list($r4) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_transactions WHERE paidby>10 AND paidby<100 AND pending=0"));
	list($r5) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_safetransfers"));
	list($r6) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM epay_users WHERE type != 'sys'"));
?>
	<TABLE class=design width=100% cellspacing=0>
	<tr>
		<td><br>
			<P>
				<b>Welcome!!!... From this administration panel you will have full control of your site.</B> 
				<br><br>
				<TABLE class=design bgColor=#ffffff cellPadding=3 cellSpacing=0 width=100% border='1' BORDERCOLOR="#C0C0C0" STYLE="border-collapse: collapse">
				<TR>
					<TD class='a1'>Total Number of Users:</TD>
					<TD class='a1'><?=$r6?></TD>
					<TD class='a1'>Total Number of Transactions:</TD>
					<TD class='a1'><?=( ($r1+$r2) + ($r3+$r4) )?></TD>
				</TR>
				<TR>
					<TD class='a1'>Total Number of Pending Withdrawals:</TD>
					<TD class='a1'><?=$r1?></TD>
					<TD class='a1'>Total Number of Withdrawals:</TD>
					<TD class='a1'><?=$r2?></TD>
				</TR>
				<TR>
					<TD class='a1'>Total Number of Pending Deposits:</TD>
					<TD class='a1'><?=$r3?></TD>
					<TD class='a1'>Total Number of Deposits:</TD>
					<TD class='a1'><?=$r4?></TD>
				</TR>
				</TABLE>		
		</td>
	</tr>
	</table>
	<br><br>
	<br>
	<FORM method=post action=right.php target=right name="sform1">
	<INPUT type=hidden name=a>
	<INPUT type=hidden name=suid value="<?=$suid?>">
	<TABLE class=design width=100% cellspacing=0>
	<TR>
		<TH colspan=5>Search Users</TH>
	</TR>
	<TR>
		<TD>Search</TD>
		<TD><INPUT type=text name=search size=27></TD>
		<TD><INPUT type=button onClick="sform1.a.value='searchu'; sform1.submit();" value="Search &gt;&gt;"></TD>
	</TR>
	</TABLE>