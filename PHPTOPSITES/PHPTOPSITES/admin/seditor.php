<?
include "../config.php";
include "header.php";
?>
<center>
<font face=verdana size=2>
<form action="seditor.php" method="post">
	Site ID: <input type=text name=sid value="<? echo $sid?>"><BR>
	<input type=submit name=submit>
</form>
</font>
</center>
<?
if ($sid AND !$a) {
	?>
	<table align=center border=1 cellpadding=3 cellspacing=0>
	<tr>
		<td align=center bgcolor="#5087AF"><B><font face=verdana size=2 color="white">Site ID:</font></B></td>
		<td align=center bgcolor="#5087AF"><B><font face=verdana size=2 color="white">Site Title:</font></B></td>
		<td align=center bgcolor="#5087AF"><B><font face=verdana size=2 color="white">Action:</font></B></td>
		<td align=center bgcolor="#5087AF"><B><font face=verdana size=2 color="white">Reviews:</font></B></td>
	</tr>
	<?
	$query = mysql_db_query ($dbname,"select sid,title from top_user where sid like '%$sid%' order by sid",$db) or die (mysql_error());
	while ($rows = mysql_fetch_array($query)) {
		echo "<tr>
			<td><font face=verdana size=2>$rows[sid]</font></td>
			<td><font face=verdana size=2>$rows[title]</font></td>
			<td><font face=verdana size=2><a href=\"seditor.php?sid=$rows[sid]&a=edit\">Edit</a> | <a href=\"seditor.php?sid=$rows[sid]&a=delete\">Delete</a></font></td>
			<td><font face=verdana size=2><a href=\"reditor.php?sid=$rows[sid]&a=edit\">Edit</a> | <a href=\"reditor.php?sid=$rows[sid]&a=edit\">Delete</a></font></td>
		      </tr>";
	}
	?>
	</table>
	<?
}
if ($sid AND $a) {
	if ($a == "edit") {
		$query = mysql_db_query ($dbname,"select * from top_user where sid=$sid",$db) or die (mysql_error());
		$rows = mysql_fetch_array($query);
		?>
		<Table Align="center" Border="1" Width="400" CellPadding="3" CellSpacing="0">
		<tr>
		<td>
			<form action="seditor.php" method="post">
			User Name:<BR>
			<input type="text" name="name" value="<? echo $rows[name]?>"><BR>
			Password:<BR>
			<input type="text" name="passw" value="<? echo $rows[password]?>"><BR>
			Email Address:<BR>
			<input type="text" name="email" value="<? echo $rows[email]?>"><BR>
			Site Title:<BR>
			<input size=50 type="text" name="title" value="<? echo $rows[title]?>"><BR>
			Site URL:<BR>
			<input size=50 type="text" name="url" value="<? echo $rows[url]?>"><BR>
			Link Back URL:<BR>
			<input size=50 type="text" name="linkback" value="<? echo $rows[linkback]?>"><BR>
			Banner URL:<BR>
			<input size=50 type="text" name="banner_url" value="<? echo $rows[banner]?>"><BR>
			Current Width for any Banner is <? echo $max_banner_width;?><BR>
			<input size="4" type="text" name="banner_w" value="<? echo $max_banner_width;?>"><BR>
			Current Height for any Banner is <? echo $max_banner_height;?><BR>
			<input size="4" type="text" name="banner_h" value="<? echo $max_banner_height;?>"><BR>
			Site Description:<BR>
			<input size="50" type="text" name="description" value="<? echo $rows[description]?>"><BR>
			Hits OUT:<BR>
			<input size="10" type="text" name="hitout" value="<? echo $rows[hitout]?>"><BR>
			STATUS:<BR>
			<select name=status>
			<? if ($rows[status] == "Y") echo "<option value=Y selected>OK</option>"; else echo "<option value=Y>OK</option>"?>
			<? if ($rows[status] == "N") echo "<option value=N selected>Waiting for Validation</option>"; else echo "<option value=N>Waiting for Validation</option>"?>
			</select><BR>
			STARS:<BR>
			<select name=stars>
			<? if ($rows[stars] == 0) echo "<option value=0 selected>0</option>"; else echo "<option value=0>0</option>"?>
			<? if ($rows[stars] == 1) echo "<option value=2 selected>1</option>"; else echo "<option value=2>1</option>"?>
			<? if ($rows[stars] == 2) echo "<option value=3 selected>2</option>"; else echo "<option value=3>2</option>"?>
			<? if ($rows[stars] == 3) echo "<option value=4 selected>3</option>"; else echo "<option value=4>3</option>"?>
			<? if ($rows[stars] == 4) echo "<option value=5 selected>4</option>"; else echo "<option value=5>4</option>"?>
			<? if ($rows[stars] == 5) echo "<option value=6 selected>5</option>"; else echo "<option value=6>5</option>"?>
			</select><BR>
			Site Category:<BR>
			<select name=category>
			<?
			$query = mysql_db_query ($dbname,"select * from top_cats order by catname",$db) or die (mysql_error());
			while ($rowss = mysql_fetch_array($query))
			{
				echo "<option value=$rowss[cid]";
				if ($rows[category] == $rowss[cid]) {echo " selected";}
				echo ">$rowss[catname]</option><BR>";
			}
			?>
			</select><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Country:</font><BR>
			<select name=country>
			<?
			$handle=opendir("../images/flags");
			while (false!==($file = readdir($handle))) { 
			    if ($file != "." && $file != "..") { 
				$country = substr($file,0,strpos($file,'.'));
				echo "<option value=\"".$file."\" ";
				if ($rows[country] == $file) echo "selected";
				echo ">".$country."</option>\n";
			    } 
			}
			closedir($handle); 
			?>
			</select>
			</font>
			<BR>
			<center>
			<BR>
			<input type="submit" name="submit">
			<input type=hidden name=sid value="<? echo $rows[sid]?>">
			<input type=hidden name=a value="update">
			</center>
			</form>
		</td>
		</tr>
		</Table>
		<?		
	}
	if ($a == "update") {
		$query = mysql_db_query ($dbname,"Update top_user set name='$name',password='$passw',email='$email',title='$title',url='$url',banner='$banner_url',bannerw=$banner_w,bannerh=$banner_h,description='$description',category=$category,hitout=$hitout,stars=$stars,country='$country',status='$status',linkback='$linkback' Where sid=$sid",$db) or die(mysql_error());
		echo "Site has been updated.<BR>";
	}
	if ($a == "delete") {
		mysql_db_query ($dbname,"delete from top_user where sid=$sid",$db) or die (mysql_error());
		mysql_db_query ($dbname,"delete from top_hits where sid=$sid",$db) or die (mysql_error());
		mysql_db_query ($dbname,"delete from top_review where sid=$sid",$db) or die (mysql_error());
	}
}
include "footer.php";
?>