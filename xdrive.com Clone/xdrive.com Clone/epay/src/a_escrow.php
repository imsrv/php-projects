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
					<td><font face="Arial, Helvetica, sans-serif" size="3" color="#000066"><b>
						Escrow Transfer From Me <span class=small>(About <a href=index.php?read=safetransfers.htm&<?=$id?>brand=<?$brand?>>Safe Transfers</a>)</span>
					</b></font></td>
				</tr>
				<tr>
					<td bgcolor="#000000" height=1></td>
				</tr>
				<tr>
					<td> </td>
				</tr>
				<tr>
					<td>
						<TABLE class=design cellspacing=0>
						<TR>
							<TH>Paid To</TH>
							<TH>Amount</TH>
							<TH>&nbsp;</TH>
						</TR>

						<?
						$r = mysql_query("SELECT epay_safetransfers.id,username,amount FROM epay_safetransfers,epay_users WHERE paidto=epay_users.id AND paidby=$user");
						$i = 1;
						while ($a = mysql_fetch_object($r))
						{
						?>
						<TR><TD class=row<?=$i?>><?=$a->username?></TD>
							<TD class=row<?=$i?>><?=prsumm($a->amount)?></TD>
							<TD class=row<?=$i?>><a href=index.php?a=stransfer&id=<?=$a->id?>&<?=$id?>brand=<?$brand?>>Confirm payment</a>
						<?
						  $i = 3 - $i;
						}
						?>
						</TD></TR>
						</table>
						<a href=index.php?a=stransfer&<?=$id?>brand=<?$brand?>>Place new safe transfer</a><br>
						<BR>
					</td>
				</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
					<td><font face="Arial, Helvetica, sans-serif" size="3" color="#000066"><b>
						Escrow Transfers To Me<span class=small>(About <a href=index.php?read=safetransfers.htm&<?=$id?>brand=<?$brand?>>Safe Transfers</a>)</span>
					</b></font></td>
				</tr>
				<tr>
					<td bgcolor="#000000" height=1></td>
				</tr>
				<tr>
					<td> </td>
				</tr>
				<tr>
					<td>
						<TABLE class=design cellspacing=0>
						<TR>
							<TH>Paid by</TH>
							<TH>Amount</TH>
							<TH>&nbsp;</TH>
						</TR>

						<?
						$r = mysql_query("SELECT epay_safetransfers.id,username,amount FROM epay_safetransfers,epay_users WHERE paidby=epay_users.id AND paidto=$user");
						$i = 1;
						while ($a = mysql_fetch_object($r))
						{
						?>
						<TR><TD class=row<?=$i?>><?=$a->username?>
						    <TD class=row<?=$i?>><?=prsumm($a->amount)?>
						    <TD class=row<?=$i?>><a href=index.php?a=stransfer&id=<?=$a->id?>&<?=$id?>&brand=<?=$brand?>>Cancel Payment</a>
						<?
						  $i = 3 - $i;
						}
						?>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</table>