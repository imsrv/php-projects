<?
##############################################################################
#                                                                            #
#                                login.php                                   #
#                                                                            #
##############################################################################
# PROGRAM : E-MatchMaker                                                     #
# VERSION : 1.51                                                             #
#                                                                            #
# NOTES   : site using default site layout and graphics                      #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2001-2002                                                    #
# Supplied by          : CyKuH [WTN]                                         #
# Nullified by         : CyKuH [WTN]                                         #
# Distribution:        : via WebForum and xCGI Forums File Dumps             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of MatchMakerSoftware             #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?

require_once("siteconfig.php");
require("login-functions.php");

if (!$_POST['username'] || !$_POST['password']) {
	header("Location: index.php");
	exit;
}

$login = $loginlib->login($_POST['username'], $_POST['password']);

if (!$login) {
        $centerimage = "images/home_big.gif";
        include("writecombo.php");
        include("select_values.php");
        include("static/header.html");
	include("static/login_error.html");
}
else {
	if($action == "updateprofile") {
	  header("Location: updateprofile.php?action=create");
	  exit;
	}
	else {
	  if($action == "read") {
		header("Location: email.php?action=$action&msg_id=$msg_id&msg_index=$msg_index");
		exit;
	  }
	  else {
		  header("Location: index.php");
		  exit;
	  }
	}
}

?>
