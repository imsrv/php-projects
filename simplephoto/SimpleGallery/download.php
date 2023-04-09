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

    $sql = "UPDATE freephp_gallery SET  downloads = downloads + 1 WHERE id = '$id'";
	$result = mysql_query($sql);

    $sql2="select * from freephp_gallery where id='$id'";
    $query2 = mysql_query($sql2);

    while($result2=mysql_fetch_assoc($query2)){

	    echo "

		<DIV ALIGN=center class=emphp>

		<B>To Download right click and hit save as:</B><BR><BR>

		<IMG SRC='images/fullsize/$result2[id].jpg' border=0>

		</DIV>

    	";
	}

	include("inc/footer.php");
?>