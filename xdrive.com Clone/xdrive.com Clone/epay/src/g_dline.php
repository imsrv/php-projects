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
	<script>
		colorover='#E0E0E0'; colorout='#F0F0F0'; colorclick='#F0D8D8';
		function mover (object) {
			if (object.style.backgroundColor.toUpperCase()!=colorclick) object.style.backgroundColor=colorover;
		}
		function mout (object) {
			if (object.style.backgroundColor.toUpperCase()!=colorclick) object.style.backgroundColor=colorout;
		}
	</script>
	<table height="100%" width="100%" border="0" cellspacing="2" cellpadding="2" class="empty">
	<tr bgcolor="#FFFFFF">
		<td height="25" colspan="3">
			<font face="Arial, Helvetica, sans-serif" size="3" color="#000066"><b>Your Downline:</b></font>
		</td>
	</tr>
	</table>
	<br>
<?
	downline($user,1);
	$ltotal = $level1 + $level2 + $level3 + $level4 + $level5 + $level6;
	$stotal = $sales1 + $sales2 + $sales3 + $sales4 + $sales5 + $sales6;
	$etotal = $earned1 + $earned2 + $earned3 + $earned4 + $earned5 + $earned6;
?>
	<table align="center" cellpadding="1" cellspacing="1" class="Stats">
	<tr class="StatsTitle">
		<td colspan="4">Your downline referrals</td>
	</tr>
	<tr class="StatsSTitle">
		<td>Level</td><td>Referrals</td><td>Sales</td><td>Earned</td>
	</tr>
	<tr onMouseOver="mover(this);" onMouseOut="mout(this);" on onMouseDown="mclick(this);">
		<td><b>1</b></td>
		<td><?=($level1 ? $level1 : 0)?></td>
		<td><?=($sales1 ? $sales1 : 0)?></td>
		<td><?=($earned1 ? $currency." ".myround($earned1,2) : 0)?></td>
	</tr>
	<tr onMouseOver="mover(this);" onMouseOut="mout(this);" on onMouseDown="mclick(this);">
		<td><b>2</b></td>
		<td><?=($level2 ? $level2 : 0)?></td>
		<td><?=($sales2 ? $sales2 : 0)?></td>
		<td><?=($earned2 ? $currency." ".myround($earned2,2) : 0)?></td>
	</tr>
	<tr onMouseOver="mover(this);" onMouseOut="mout(this);" on onMouseDown="mclick(this);">
		<td><b>3</b></td>
		<td><?=($level3 ? $level3 : 0)?></td>
		<td><?=($sales3 ? $sales3 : 0)?></td>
		<td><?=($earned3 ? $currency." ".myround($earned3,2) : 0)?></td>
	</tr>
	<tr onMouseOver="mover(this);" onMouseOut="mout(this);" on onMouseDown="mclick(this);">
		<td><b>4</b></td>
		<td><?=($level4 ? $level4 : 0)?></td>
		<td><?=($sales4 ? $sales4 : 0)?></td>
		<td><?=($earned4 ? $currency." ".myround($earned4,2) : 0)?></td>
	</tr>
	<tr onMouseOver="mover(this);" onMouseOut="mout(this);" on onMouseDown="mclick(this);">
		<td><b>5</b></td>
		<td><?=($level5 ? $level5 : 0)?></td>
		<td><?=($sales5 ? $sales5 : 0)?></td>
		<td><?=($earned5 ? $currency." ".myround($earned5,2) : 0)?></td>
	</tr>
	<tr onMouseOver="mover(this);" onMouseOut="mout(this);" on onMouseDown="mclick(this);">
		<td><b>6</b></td>
		<td><?=($level6 ? $level6 : 0)?></td>
		<td><?=($sales6 ? $sales6 : 0)?></td>
		<td><?=($earned6 ? $currency." ".myround($earned6,2) : 0)?></td>
	</tr>
	<tr class="StatsSTitle"> 
		<td>Totals:</td>
		<td><div align="right"><?=($ltotal ? $ltotal : 0)?></div></td>
		<td><div align="right"><?=($stotal ? $stotal : 0)?></div></td>
		<td><div align="right"><?=($etotal ? $currency." ".myround($etotal,2) : 0)?></div></td>
	</tr>
	</table>
	<br><br>
	<table width="480" align="center" cellpadding="1" cellspacing="1" class="Stats">
	<tr class="StatsTitle">
		<td colspan="7">Your direct referrals (level 1)</td>
	</tr>
<?
	$qr1 = mysql_query("SELECT * FROM epay_users WHERE referredby=$user");
	if( mysql_num_rows($qr1) >= 1){
		while( $row = mysql_fetch_object($qr1) ){
			$aqr1 = mysql_query("SELECT COUNT(*) AS sales FROM epay_transactions WHERE paidto='$user' AND paidby='99' AND relatedproject='{$row->id}'");
			if($aqr1){
				$arow = mysql_fetch_object($aqr1);
				$mysales = $arow->sales;
			}
			$aqr1 = mysql_query("SELECT SUM(amount) AS earned FROM epay_transactions WHERE paidto='$user' AND paidby='99' AND relatedproject='{$row->id}'");
			if($aqr1){
				$arow = mysql_fetch_object($aqr1);
				$myearned = $arow->earned;
			}
?>
			<tr class="StatsSTitle"> 
				<td colspan="7"><?=$row->username?> (<?=$row->email?>)</td>
			</tr>
<?
		}
	}else{
?>
		<tr class="StatsSTitle"> 
			<td colspan="7">No referrals on this level.</td>
		</tr>
<?
	}
?>
	</table>
	<br>
<?
	function downline($user,$curLev){
		global $level1,$sales1,$earned1;
		global $level2,$sales2,$earned2;
		global $level3,$sales3,$earned3;
		global $level4,$sales4,$earned4;
		global $level5,$sales5,$earned5;
		global $level6,$sales6,$earned6;
		$qr1 = mysql_query("SELECT * FROM epay_users WHERE referredby=$user");
		if($qr1){
			while( $row = mysql_fetch_object($qr1) ){
				$myLev = $curLev + 1;
				if($myLev > 6)return;
				$aqr1 = mysql_query("SELECT COUNT(*) AS sales FROM epay_transactions WHERE paidto='$user' AND paidby='99' AND relatedproject='{$row->id}'");
				if($aqr1){
					$arow = mysql_fetch_object($aqr1);
					$sales = $arow->sales;
				}
				$aqr1 = mysql_query("SELECT SUM(amount) AS earned FROM epay_transactions WHERE paidto='$user' AND paidby='99' AND relatedproject='{$row->id}'");
				if($aqr1){
					$arow = mysql_fetch_object($aqr1);
					$earned = $arow->earned;
				}
				if($curLev == 1){
					$level1++;
					$sales1 .= $sales;
					$earned1 .= $earned;
				}else if($curLev == 2){
					$level2++;
					$sales2 .= $sales;
					$earned2 .= $earned;
				}else if($curLev == 3){
					$level3++;
					$sales3 .= $sales;
					$earned3 .= $earned;
				}else if($curLev == 4){
					$level4++;
					$sales4 .= $sales;
					$earned4 .= $earned;
				}else if($curLev == 5){
					$level5++;
					$sales5 .= $sales;
					$earned5 .= $earned;
				}else if($curLev == 6){
					$level6++;
					$sales6 .= $sales;
					$earned6 .= $earned;
				}
				downline($row->id,$myLev);
			}
		}
	}
?>