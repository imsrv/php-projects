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

    $id = $_REQUEST['id'];

    $res = mysql_query("SELECT username FROM freephp_gallery_admin WHERE username='$username' AND password='$password'");
    if(mysql_num_rows($res) != 0) {

        $sql = "DELETE from freephp_gallery_category where id='$id'";
		$result = mysql_query($sql);

		header("Location: category-disp.php");

	} else {

	   include("inc/loginform.php");

	}

 	include("inc/footer.php");

?>