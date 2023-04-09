<?
##############################################################################
#                                                                            #
#                              register.php                                  #
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
require_once("login-functions.php");

$login_check = $loginlib->is_logged();

if (!$login_check) {

if (!$username || !$password || !$password2 || !$f_name || !$l_name || !$email) {
        $centerimage = "images/join_red_dot.gif";
        include("static/header.html");
	include("static/register.html");
	exit;
}

$register = $loginlib->register($username, $password, $password2, $f_name, $l_name, $email);

if ($register != 2) {
        include("static/header.html");
	include("static/register_error.html");
}
else {
        include("static/header.html");
	include("static/register_done.html");
}

}

else {
       header("Location: index.php");
       exit;
}

?>



