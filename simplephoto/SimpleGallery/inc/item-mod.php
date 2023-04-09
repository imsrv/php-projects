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

    $id = $_REQUEST['id'];
    
	$sql="select * from freephp_gallery_item where id=$id";
	$query = mysql_query($sql);

	while ($row9=mysql_fetch_assoc($query)){

		echo "

		<span CLASS=emph>• Modify Resource

		<BR><BR>

		<TABLE BORDER=0 width=98% align=center><TR><TD>

		<TABLE BORDER=0>
		<form action='item-mod.php?id=$id' method='post'>

			<TR>
				<TD valign=top>Category</TD>
				<TD valign=top>&nbsp;<select name='category'>
		";

					$result4 = mysql_query("select * from category where id='$row9[category]'");
           					while ($row4=mysql_fetch_assoc($result4)) {
           					echo "<option value=$row4[id] selected>$row4[title]</option>";

					$result0 = mysql_query("select * from category");
           					while ($row0=mysql_fetch_assoc($result0)) {
           					echo "<option value=$row0[id]>$row0[title]</option>";


      						}}
		echo "
				</select>

				</TD>
			</TR>


			<TR>
				<TD valign=top>Title</TD>
				<TD valign=top>&nbsp;<input type='text' name='title' size='35' value='$row9[title]'></TD>
			</TR>

			<TR>
				<TD valign=top>Description</TD>
				<TD valign=top>&nbsp;<TEXTAREA name='description' rows='20' cols=40>$row9[description]</TEXTAREA></TD>
			</TR>


			<TR>
				<TD colspan=2><input type='submit' name='submit' value='Modify Item'></TD>
			</TR>
		</form>
		</tABLE>

		</TD></TR></TABLE>

		";

	}














?>