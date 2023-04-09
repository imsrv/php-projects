<?
#########################################################
# Simple Gallery                                        #
#########################################################
#                                                       #
# Created by: Doni Ronquillo                            #
#                                                       #
# This script and all included functions, images,       #
# and documentation are copyright 2003                  #
# free-php.net (http://free-php.net) unless             #
# otherwise stated in the module.                       #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
#########################################################

    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);

	include("inc/config.php");
	include("inc/header.php");



	echo "
		<BR>
		<DIV CLASS=emph>• Logged out of Admin Area</DIV>
		<BR>
		<TABLE BORDER=0 width=98% align=center><TR><TD>
		<TABLE BORDER=0><TR><TD>
		You have been logged out of the admin area.
		</TD></TR></tABLE>
		</TD></TR></tABLE>

		";


	include("inc/footer.php");
?>