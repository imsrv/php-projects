<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley        										  #
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
	if ($_GET['r']){
		setcookie("fastrefer", $_GET['r'], time()+86400); $_COOKIE['fastrefer'] = $_GET['r']; 
	}
	chdir('epay');
	require('src/common.php');
	if ( !@file_exists('header.htm') ){
		include('header.php');
	}else{
		include('header.htm');
	}
	if ($data){
		echo "<div align=right class=tiny>You are now logged in as <b>$data->username</b> --- <a href=?a=account&$id>Manage Account</a>","</div>";
	}elseif ($_COOKIE['c_user']){
		echo "<div align=right class=tiny>Welcome back, <b>",$_COOKIE['c_user'],"</b>!</div>";
	}
	// Include action modules
	if (!$action){
		include('src/a_defaultfaq.php');
	}
	if ( !@file_exists('footer.htm') ){
		include('footer.php');
	}else{
		include('footer.htm');
	}
?>