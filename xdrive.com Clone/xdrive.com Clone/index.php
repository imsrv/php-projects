<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       													 #
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
	if ($_SESSION['r']){
		$_GET['r'] = $_SESSION['r'];
	}
	if ($_GET['r']){
		$_SESSION['r'] = $_GET['r'];
		setcookie("fastrefer", $_GET['r'], time()+86400);
		$_COOKIE['fastrefer'] = $_GET['r']; 
	}

	chdir('epay');
	require('src/common.php');

	//Cobrand
	$brand = $_GET['brand'];
	//End Cobrand

	$requirelogin = array(
		'account', 'deposit', 'transfer', 'withdraw', 'viewtransactions','transdet',
		'edit', 'signupfee', 'stransfer', 'adm_bid_e', 'adm_bid_d', 
		'adm_mb_e',  'adm_mb_d', 'adm_pr_e',  'adm_pr_d',
		'adm_pru_e', 'adm_pru_d', 'adm','login','user_product','user_single_item',
		'submit_site','stransfer','escrow','affil','reqpay'
	);
	$stdactions = array(
		'special', 'uview', 'project', 'reviews', 'projects', 'ulist',
		'viewprs', 'remind', 'board', 'search', 'whoonline', 'quotes','myareas',
		'tellafriend','whatshot','browse'
	);
	$atype = '';
	require('src/session.php');

	if ($brand){
		myheader($brand);
	}else if ( !@file_exists('header.htm') ){
		include('header.php');
	}else{
		include('header.htm');
	}
	// Print logged user
	if ($data){
		echo "<div align=right class=tiny>You are now logged in as <b>$data->username</b> --- <a href=?a=account&$id>Manage Account</a>","</div>";
	}elseif ($_COOKIE['c_user']){
		echo "<div align=right class=tiny>Welcome back, <b>",$_COOKIE['c_user'],"</b>!</div>";
	}
	if ($_REQUEST['read']){
		if (!@include('help/'.$_REQUEST['read'])){
			echo "Cannot find file: <i>help/",$_REQUEST['read'],"</i><br>";
		}
	}else{
		if ($action == 'blogin') $action = 'board';
		// Include action modules
		if ($action){
			if (in_array($action, $requirelogin) || in_array($action, $stdactions) || $action == 'signup' || $action == 'adm'){
				include("src/a_$action.php");
			}else{
				$action = '';
			}
		}

		if (!$action){
			include('src/a_default.php');
		}
	}
	if ($brand){
		myfooter($brand);
	}else if ( !@file_exists('footer.htm') ){
		include('footer.php');
	}else{
		include('footer.htm');
	}
?>