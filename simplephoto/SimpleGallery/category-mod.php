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

    $id          = $_REQUEST['id'];
    $title       = $_REQUEST['title'];
    $description = $_REQUEST['description'];

    $res = mysql_query("SELECT username FROM freephp_gallery_admin WHERE username='$username' AND password='$password'");

    if(mysql_num_rows($res) != 0) {

    	if ($_SERVER['REQUEST_METHOD'] == "POST") {

        	$sql = "UPDATE freephp_gallery_category SET title='$title', description='$description' WHERE id = '$id'";
        	$result = mysql_query($sql);

    		header("Location: category-disp.php");

    	} else {


    	    $result9 = mysql_query("select * from freephp_gallery_category where id='$id'");
        	while ($row9=mysql_fetch_assoc($result9)) {


        		echo "


        		<TABLE BORDER=0 width=98% align=center>
        		<TR>

        		<TD VALIGN=top width=40px></tD>

        		<TD VALIGN=top>

        		<span CLASS=emph>• Welcome $username</span> : Modify Category

        		<BR><BR>

        		<TABLE BORDER=0 width=98% align=center><TR><TD>

        		<TABLE BORDER=0>
        		<form action='category-mod.php?id=$row9[id]' method=post>

        		<TR>
        			<TD>title:</TD>
        			<TD>&nbsp;<input type=text name='title' value=$row9[title] size=35></TD>
        		</TR>


        		<TR>
        			<TD valign=top>Description</TD>
        			<TD valign=top>&nbsp;<textarea name='description' cols='35' rows=10>$row9[description]</TEXTAREA></TD>
        		</TR>


        		</TABLE>


        		<input type='submit' name='submit' value='Modify Category'>
        		</form>

        		</TD></tR></TABLE></TD></TR></tABLE>";


        	}

    	}

	} else {

	include("inc/loginform.php");

	}

 	include("inc/footer.php");

?>