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

        $category    = $_POST['category'];
        $title       = $_POST['title'];
        $keywords    = $_POST['keywords'];
        $description = $_POST['description'];

        $sql = "INSERT INTO freephp_gallery (category,title,keywords,description) VALUES ('$category','$title','$keywords','$description')";
		$result = mysql_query($sql);

		$id  = mysql_insert_id();
		$jpg = $id.".jpg";


		if ($_FILES['image']['type'] != 'image/gif') {

            $im_convert = str_replace("/","\\",$im_convert);
            
			Exec("$im_convert -geometry \"$thumb_width"."x"."$thumb_height\" -quality \"$thumbquality\" \"" . $_FILES['image']['tmp_name'] . "\" \"$base_dir/images/thumbs/$jpg\"");
			Exec("$im_convert -geometry \"$preview_width"."x"."$preview_height\" -quality \"$thumbquality\" \"" . $_FILES['image']['tmp_name'] . "\" \"$base_dir/images/preview/$jpg\"");
			copy($_FILES['image']['tmp_name'], "$base_dir/images/fullsize/$jpg");

			echo "<br>Item Added Successfully<BR>";

            header("Location: additem.php");

		} else {

        	$sqld = "DELETE FROM freephp_gallery WHERE id = '$id'";
			$resultd = mysql_query($sqld);
			echo "GIF images are not allowed to be uploaded. Please try again.";
		}

	} else {


		echo "

		<span CLASS=emph>Add Photo

		<BR><BR>

		<TABLE BORDER=0 width=98% align=center><TR><TD>

		<TABLE BORDER=0>
		<form action='additem.php' method='post' enctype='multipart/form-data'>
			<TR>
				<TD valign=top>Category</TD>
				<TD valign=top>

				&nbsp;<select name='category'>

				<option value='' selected>Select Category</option>";

				$result0 = mysql_query("select * from freephp_gallery_category");
       			while ($row0=mysql_fetch_assoc($result0)) {

       					echo "<option value=$row0[id]>$row0[title]</option>";

				}
		echo "

				</select>

				</TD>
			</TR>


			<TR>
				<TD valign=top>Title</TD>
				<TD valign=top>&nbsp;<input type='text' name='title' size='35' value=''></TD>
			</TR>

			<TR>
				<TD valign=top>Keywords</TD>
				<TD valign=top>&nbsp;<input type='text' name='keywords' size='35' value=''></TD>
			</TR>

			<TR>
				<TD COLSPAN=2>You may use standard html to jazz up the descriptions.<BR>HTML Examples are below.</TD>
			</TR>

			<TR>
				<TD valign=top>Description</TD>
				<TD valign=top>&nbsp;<textarea name='description' cols='35' rows=10>To Create a line break use '<BR>' Example : This is your text.<BR> To make text Bold use <B></B>  Example: <B>Your Bold Text</B>  To change font color use <FONT> Example: <FONT COLOR=black>Black Text</FONT></TEXTAREA></TD>
			</TR>



			<TR>
				<TD COLSPAN=2>.jpg images only all others will be deleted.<BR>Thumbnails and preview images will be automatically created.</TD>
			</TR>



			<TR>
				<TD valign=top>Image</TD>
				<TD valign=top>&nbsp;<input type='file' name='image'></TD>
			</TR>

			<TR>
				<TD colspan=2><input type='submit' name='submit' value='Add Item'></TD>
			</TR>
		</form>
		</tABLE>

		</TD></TR></TABLE>

		";


	}
?>