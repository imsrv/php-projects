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

	if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $parent      = $_POST['parent'];
        $title       = $_POST['title'];
        $description = $_POST['description'];

		$sql = "INSERT INTO freephp_gallery_category (id, parent, title, description) VALUES ('NULL','$parent','$title','$description')";
		$result = mysql_query($sql);
        header("Location: category.php");

	} else {

	    echo "

        	<span CLASS=emph>• Welcome $username</span> : Add Category

        	<BR><BR>

        	<TABLE BORDER=0 width=98% align=center><TR><TD>

        	<TABLE BORDER=0>
        	<form action='category.php' method=post>
        	<TR>

        	<TD><B>Category:</B></TD>
        	<TD><select name='parent'><option value='0' selected>(no parent)</option>

	    ";


		$result0 = mysql_query("select * from freephp_gallery_category where parent='0'");

        while ($row0=mysql_fetch_assoc($result0)) {

           echo "<option value='$row0[id]'>$row0[title]</option>";

		   $result1 = mysql_query("select * from freephp_gallery_category where parent='$row0[id]'");

           while ($row1=mysql_fetch_assoc($result1)) {

              echo "<option value='$row1[id]'>- $row1[title]</option>";

 		      $result2 = mysql_query("select * from freephp_gallery_category where parent='$row1[id]'");

           	  while ($row2=mysql_fetch_assoc($result2)) {

           	     echo "<option value='$row2[id]'>-- $row2[title]</option>";

		         $result3 = mysql_query("select * from freephp_gallery_category where parent='$row2[id]'");

                 while ($row3=mysql_fetch_assoc($result3)) {

           		    echo "<option value='$row3[id]'>--- $row3[title]</option>";
 		         }
    		  }
  		   }
		}



    	echo "

    	</select></TD>
    	</TR>

    		<TR>
    			<TD>Name:</TD>
    			<TD><input type=text name='title'></TD>
    		</TR>

    			<TR>
    				<TD COLSPAN=2>You may use standard html to jazz up the descriptions.<BR>HTML Examples are below.</TD>
    			</TR>

    			<TR>
    				<TD valign=top>Description</TD>
    				<TD valign=top>&nbsp;<textarea name='description' cols='35' rows=10>To Create a line break use '<BR>' Example : This is your text.<BR> To make text Bold use <B></B>  Example: <B>Your Bold Text</B>  To change font color use <FONT> Example: <FONT COLOR=black>Black Text</FONT></TEXTAREA></TD>
    			</TR>

    	</TABLE>


    	<input type='submit' name='submit' value='Add Category'>
    	</form>

    	</TD></tR></TABLE>";

	}
?>









