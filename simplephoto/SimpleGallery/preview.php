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

    $sql="select * from freephp_gallery where id='$id'";
    $query = mysql_query($sql);

    while($result=mysql_fetch_assoc($query)){

	$sql2="select * from freephp_gallery_category where id='$result[category]'";
        $query2 = mysql_query($sql2);

	while($result2=mysql_fetch_assoc($query2)){

	echo "<B>Return to : <A HREF='gallery.php?cid=$result2[id]'>$result2[title]</A></b><BR><BR>";


    	$re = mysql_query("SELECT username FROM freephp_gallery_admin WHERE username='$username' AND password='$password'");
    	if(mysql_num_rows($re) != 0) {

		echo "<CENTER><A HREF='item-del.php?id=$id' class=small> ( Delete photo ) </A></CENTER>";

	} else {

		echo "";

	}



	echo "

	<div align=center>

	<A HREF='download.php?id=$result[id]'><IMG SRC='images/preview/$result[id].jpg' border=0></A>

	<BR>

	<B>$result[title]</B> downloads($result[downloads])<BR>
	$result[description]

	<BR><BR>



	</DIV>

	";

	}
	}



 	include("inc/footer.php");

?>