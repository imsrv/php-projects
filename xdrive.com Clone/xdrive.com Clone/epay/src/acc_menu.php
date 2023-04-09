<?
$show = 1;
if( ($charge_signup) ){
	$show = 0;
	if( ($data->fee) ){
		$show = 1;
	}
}
?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbin">
		<tr><td class="tdtitle">My Account</td></tr>
		<tr>
			<td class="tdmenu">
					<a href=?a=account&<?=$id?>>Overview</a><BR>
					<a href=?a=edit&<?=$id?>>My Profile</a><BR>
<?	if($show){	?>
					<a href=?a=deposit&<?=$id?>>Deposit Money</a><BR>
					<a href=?a=transfer&<?=$id?>>Send Money</a><BR>
					<a href=?a=reqpay&<?=$id?>>Request Money</a><BR>
					<a href=?a=withdraw&<?=$id?>>Withdraw Money</a><BR>
					<a href=?a=user_product&<?=$id?>>Sell</a><BR>
					<a href=?a=escrow&<?=$id?>>Escrow</a><br>
<?	if($affil_on){	?>
					<a href=?a=affil&<?=$id?>>Affiliate Program</a><br>
	<?	if($affil){	?>
					<a href=?a=affil&<?=$id?>>· Program Details</a><br>
					<a href=?a=affil&be=stats&<?=$id?>>· Your Statistics</a><br>
					<a href=?a=affil&be=dl&<?=$id?>>· Your Downline</a><br>
					<a href=?a=affil&be=code&<?=$id?>>· Advertising Code</a><br>
	<?	}	?>
<?	}	?>
					<a href=?a=browse&<?=$id?>>Shop</a><BR>
<?	}else{	?>
					<a href=?a=signupfee&<?=$id?>>Pay Signup Fee</a><BR>
<?	}	?>
			</td>
		</tr>
		</table>
		<div align="center">
		<br>
