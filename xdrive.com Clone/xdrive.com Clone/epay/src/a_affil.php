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
	<tr bgcolor="#FFFFFF">
		<td width="10"></td>
		<td width="150" valign="top">
<?
			$affil = 1;
			include("src/acc_menu.php");
?>
		</td>
		<td width=10> </td>
		<td width="519" valign="top" bgcolor="#FFFFFF">
			<table width="100%" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#FFFFFF">
			<tr>
				<td width="519" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#FFFFFF">
					<tr>
						<td><span class="text4">Affiliate Program</span></td>
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
	if( !$_REQUEST['be'] ){
		$_REQUEST['read'] = "referrals.htm";
		if ($_REQUEST['read']){
			if (!@include('help/'.$_REQUEST['read'])){
				echo "Cannot find file: <i>help/",$_REQUEST['read'],"</i><br>";
			}
		}

	}else if($_REQUEST['be'] == "stats"){
		include("src/g_stats.php");
	}else if($_REQUEST['be'] == "dl"){
		include("src/g_dline.php");
	}else if($_REQUEST['be'] == "code"){
		$_REQUEST['read'] = "referrals_code.htm";
		if ($_REQUEST['read']){
			if (!@include('help/'.$_REQUEST['read'])){
				echo "Cannot find file: <i>help/",$_REQUEST['read'],"</i><br>";
			}
		}
	}
?>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>