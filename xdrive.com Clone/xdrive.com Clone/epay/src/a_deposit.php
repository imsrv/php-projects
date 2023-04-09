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
		<td bgcolor="#FFFFFF">
			<table width="620" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#FFFFFF">
			<tr>
				<td width=150 height="314" valign="top">
<?
	include("src/acc_menu.php");
?>
			</td>
			<td width=20> </td>
			<td width="519" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#FFFFFF">
				<tr>
					<td><font face="Arial, Helvetica, sans-serif" size="3" color="#000066"><b>Deposit Money</b></font></td>
				</tr>
				<tr>
					<td bgcolor="#000000" height=1></td>
				</tr>
				<tr>
					<td> </td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">
<?
	$source = $_POST['source'];
	$amount = (float)$_POST['amount'];
	$processed = 0;

	// PayPal processing
	if ($paypal_use && $source == 'paypal'){
		include("src/g_paypal.php");
	}else if ($stormpay_use && $source == 'stormpay'){
		// StormPay processing
		include("src/g_stormpay.php");
	}elseif ($cc_use && $source == 'cc'){
		// 2CheckOut Credit card processing
		include("src/g_2checkout.php");
	}elseif ($kagi_use && $source == 'kagi'){
		// Kagi Credit card processing
		include("src/g_kagi.php");
	}elseif ($anet_use && $source == 'anet'){
		// Authorize.Net Credit card processing
		include("src/g_anet.php");
	}elseif ($anet_use && $source == 'anetc'){
		// Authorize.Net Credit card processing
		include("src/g_anetcheck.php");
	}elseif ($eg_use && $source == 'eg'){
		// E-Gold processing
		include("src/g_egold.php");
	}elseif ($np_use && $source == 'np'){
		// Netpay processing
		include("src/g_netpay.php");
	}elseif ($check_use && $source == 'check'){
		// Check processing
		include("src/g_check.php");
	}
	if (!$processed){
		// Generate form
?>
		<P><FONT COLOR="#FF0000" FACE="Verdana,Tahoma,Arial,Helvetica,Sans-serif,sans-serif"><B>
		Please choose which method you prefer to fund your <?=$sitename?> account with.
		</B></FONT><B></B></P>
		<P><FONT SIZE="-2" FACE="Verdana,Tahoma,Arial,Helvetica,Sans-serif,sans-serif">
		Funding of your account usually occurs in less than 1 hour (during business hours), but could take up to 
		12 hours unless stated as "instant funding method".
		</FONT></P>
		<TABLE class=design cellspacing=0>
		<FORM method=post>
		<TR><TH colspan=2>Deposit Funds to Your Account</TH</TR>
		<TR><TD>Amount to deposit:</TD>
		<TD><?=$currency?> <input type=text size=7 maxLength=7 name=amount></TD></TR>
		<TR><TD valign="top">Payment method:</TD>
		<TD>
<?
  		// PayPal
  		if ($paypal_use){
    			echo "<input type=radio class=checkbox name=source value='paypal' ",($source == 'paypal' ? 'checked' : ''),">","Paypal";
    			if ($dep_pp_percent || $dep_pp_fee){
    	  			echo " <span class=small>(cost: ",
					($dep_pp_percent ? "$dep_pp_percent%" : ""),
					($dep_pp_percent && $dep_pp_fee ? " + " : ""),
					($dep_pp_fee ? $currency.$dep_pp_fee : ""),
					")</span>";
			}
			echo "<br>\n";
		}
  		// StormPay
  		if ($stormpay_use){
    			echo "<input type=radio class=checkbox name=source value='stormpay' ",($source == 'stormpay' ? 'checked' : ''),">","StormPay";
    			if ($dep_sp_percent || $dep_sp_fee){
    	  			echo " <span class=small>(cost: ",
					($dep_sp_percent ? "$dep_sp_percent%" : ""),
					($dep_sp_percent && $dep_sp_fee ? " + " : ""),
					($dep_sp_fee ? $currency.$dep_sp_fee : ""),
					")</span>";
			}
			echo "<br>\n";
		}
  		// 2CheckOut
  		if ($cc_use){
    			echo "<input type=radio class=checkbox name=source value='cc' ",($source == 'cc' ? 'checked' : ''),">","Credit Card / Online Check";
    			if ($dep_cc_percent || $dep_cc_fee){
      			echo " <span class=small>(cost: ",
					 ($dep_cc_percent ? "$dep_cc_percent%" : ""),
					 ($dep_cc_percent && $dep_cc_fee ? " + " : ""),
					 ($dep_cc_fee ? $currency.$dep_cc_fee : ""),
           			")</span>";
           	}
    			echo "<br>\n";
  		}
		//Kagi
  		if ($kagi_use){
    			echo "<input type=radio class=checkbox name=source value='kagi' ",($source == 'kagi' ? 'checked' : ''),">","Credit Card (Kagi)";
    			if ($dep_kagi_percent || $dep_kagi_fee){
      			echo " <span class=small>(cost: ",
					 ($dep_kagi_percent ? "$dep_kagi_percent%" : ""),
					 ($dep_kagi_percent && $dep_kagi_fee ? " + " : ""),
					 ($dep_kagi_fee ? $currency.$dep_kagi_fee : ""),
           			")</span>";
           	}
    			echo "<br>\n";
  		}
		// Authorize.Net
		if ($anet_use){
			echo "<input type=radio class=checkbox name=source value='anet' ",($source == 'anet' ? 'checked' : ''),">",
			"Credit Card";
			if ($dep_anet_percent || $dep_anet_fee)
				echo " <span class=small>(cost: ",
				($dep_anet_percent ? "$dep_anet_percent%" : ""),
				($dep_anet_percent && $dep_anet_fee ? " + " : ""),
				($dep_anet_fee ? $currency.$dep_anet_fee : ""),
				")</span>";
			echo "<br>\n";
			echo "<input type=radio class=checkbox name=source value='anetc' ",($source == 'anetc' ? 'checked' : ''),">",
			"Deposit from Bank Account";
			if ($dep_anet_percent || $dep_anet_fee)
				echo " <span class=small>(cost: ",
				($dep_anet_percent ? "$dep_anet_percent%" : ""),
				($dep_anet_percent && $dep_anet_fee ? " + " : ""),
				($dep_anet_fee ? $currency.$dep_anet_fee : ""),
				")</span>";
			echo "<br>\n";
		}
  		// E-Gold
  		if ($eg_use){
    			echo "<input type=radio class=checkbox name=source value='eg' ",($source == 'eg' ? 'checked' : ''),">","E-Gold";
    			if ($dep_eg_percent || $dep_eg_fee){
      			echo " <span class=small>(cost: ",
					 ($dep_eg_percent ? "$dep_eg_percent%" : ""),
					 ($dep_eg_percent && $dep_eg_fee ? " + " : ""),
					 ($dep_eg_fee ? $currency.$dep_eg_fee : ""),
           			")</span>";
           	}
    			echo "<br>\n";
  		}
  		// NetPay
  		if ($np_use){
    			echo "<input type=radio class=checkbox name=source value='np' ",($source == 'np' ? 'checked' : ''),">","NetPay";
    			if ($dep_np_percent || $dep_np_fee){
      			echo " <span class=small>(cost: ",
					 ($dep_np_percent ? "$dep_np_percent%" : ""),
					 ($dep_np_percent && $dep_np_fee ? " + " : ""),
					 ($dep_np_fee ? $currency.$dep_np_fee : ""),
           			")</span>";
           	}
    			echo "<br>\n";
  		}
  		// Check
  		if ($check_use){
			echo "<input type=radio class=checkbox name=source value='check' ",($source == 'check' ? 'checked' : ''),">","Regular Mail";
			if ($dep_check_percent || $dep_check_fee){
				echo " <span class=small>(cost: ",
					($dep_check_percent ? "$dep_check_percent%" : ""),
					($dep_check_percent && $dep_check_fee ? " + " : ""),
					($dep_check_fee ? $currency.$dep_check_fee : ""),
					")</span>";
			}
			echo "<br>\n";
		}
?>
		</TD></TR>
		<TR><TH colspan=2 class=submit>
			<INPUT type=submit class=button value='Deposit >>'></TH>
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