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
					<td><font face="Arial, Helvetica, sans-serif" size="3" color="#000066"><b>Sell Products or Services</b></font></td>
				</tr>
				<tr>
					<td bgcolor="#000000" height=1></td>
				</tr>
				<tr>
					<td> </td>
				</tr>
				<tr>
					<td>
						<font face="Arial, Helvetica, sans-serif" size="2"><a href="?a=submit_site"><font face="Arial, Helvetica, sans-serif" size="2">Submit
						Site to  <?=$sitename?> Shops</font></a></font>
					</td>
				</tr>
				<tr>
					<td width=375 valign="bottom"> If your website accepts <?=$sitename?>, add it here so that other members can visit your site</td>
				</tr>
				<tr>
					<td><font face="Arial, Helvetica, sans-serif" size="2"><a href="?a=user_single_item"><font face="Arial, Helvetica, sans-serif" size="2">Selling Single Items</font></a></font></td>
				</tr>
				<tr>
					<td width=375 valign="bottom">
						Sell individual items on your website by creating a customized payment button, and your 
						Buyers will be able to make their purchases quickly and securely on <?=$sitename?>'s hosted 
						payment pages
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>