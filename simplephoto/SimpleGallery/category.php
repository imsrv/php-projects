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

    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

	include("inc/config.php");
	include("inc/header.php");

    $res = mysql_query("SELECT username FROM freephp_gallery_admin WHERE username='$username' AND password='$password'");
    if(mysql_num_rows($res) != 0) {

    		echo "
    		<TABLE BORDER=0 width=98% align=center>
    		<TR>

    		<TD VALIGN=top width=40px></tD>

    		<TD VALIGN=top>";

    		include('inc/category.php');

    		echo "</TD></TR></tABLE>";

	} else {

	include("inc/loginform.php");

	}

 	include("inc/footer.php");

?>