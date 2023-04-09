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
	$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE username='".addslashes($_GET['id'])."' OR id='".addslashes($_GET['id'])."'")); 
	if ($r->type == 'sys') exit;

	$tt = $_GET['id'];
	$_GET['id'] = $_GET['ed'];
	$_fpr_add = 1;
	require("admin/g_uedit.php");
	if ($_fpr_err) exit;
	$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE username='".addslashes($tt)."'")); 
?>