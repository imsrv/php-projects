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

		<TD VALIGN=top>

		<span CLASS=emph>• Welcome $username</span> : Modify / Delete Categories

		<BR><BR>
		<TABLE BORDER=0 align=center width=98%  cellpadding=1 cellspacing=1>
			<TR>

				<TD>Category</TD>
				<TD>Action</TD>
			</TR>
		";

		$result = mysql_query("select * from freephp_gallery_category order by title");
           	while ($row=mysql_fetch_assoc($result)) {

			echo "
				<TR>
				<TD>$row[title]</TD>
				<TD><A HREF='category-mod.php?id=$row[id]'>modify</A> / <A HREF='category-del.php?id=$row[id]'>delete</A></TD>
				</TR>

			";

		}

		echo "</TABLE></TD></TR></tABLE>";

	} else {

	include("inc/loginform.php");

	}

 	include("inc/footer.php");

?>