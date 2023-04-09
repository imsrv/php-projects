<?
include "../config.php";
include "header.php";

if ($sid AND $a=="edit") {
	if (!$from OR $from < 0 OR $from < $review_step) $from = 0;
	$query = mysql_db_query ($dbname,"select * from top_review where sid=$sid ORDER BY rid DESC LIMIT $from,$review_step",$db) or die (mysql_error());
	$tquery = mysql_db_query ($dbname,"select count(rid) as rtotal from top_review where sid=$sid",$db) or die (mysql_error());
	$squery = mysql_db_query ($dbname,"select title from top_user where sid=$sid ",$db) or die (mysql_error());
	$srows = mysql_fetch_array($squery);

	echo "<CENTER><font color=\"$font_color\" face=\"$font_face\" size=\"$font_size\">
		<A HREF=\"out.php?site=$sid\">$srows[title]</A> Reviews:
		</font></CENTER>";

	echo "<div align=right><B><font color=\"$font_color\" face=\"$font_face\" size=\"-2\">Reviews:";

	$trows = mysql_fetch_array($tquery);

	$count = $trows[rtotal];
	$i = 0;
	$step = $review_step;
	$sstep = 0;

	while ($sstep < $count) {
		if ($from == $sstep) {
			echo " [$i] ";
		}
		else {
			echo " [<a href=\"?from=$sstep&sid=$sid&a=edit\">$i</a>] ";
		}
			$sstep = $sstep + $step;
			$i++;
	}
	echo "</font></B></div>";

	
	while ($rows = mysql_fetch_array($query)) {
		echo "<HR><font color=\"$font_color\" face=\"$font_face\" size=\"$font_size\">
		<A HREF=\"mailto:$rows[email]\">$rows[name]</A><BR>
		Rating: $rows[rating]<BR>
		$rows[review]<BR>
		<A HREF=\"reditor.php?rid=$rows[rid]&a=update_1&sid=$sid\">Edit</A> | <A HREF=\"reditor.php?rid=$rows[rid]&a=delete&sid=$sid\">Delete</A>
		</font>";
	}
}

if ($sid AND $a=="delete" AND $rid) {
	$query = mysql_db_query ($dbname,"delete from top_review where sid=$sid AND rid=$rid",$db) or die (mysql_error());	
	if ($query) echo "Review was deleted. <A HREF=\"reditor.php?sid=$sid&a=edit\">Back</A>";
}

if ($sid AND $a=="update_1" AND $rid) {
	$query = mysql_db_query ($dbname,"select * from top_review where sid=$sid AND rid=$rid",$db) or die (mysql_error());	
	$rows = mysql_fetch_array($query);
	?>
		<form action="reditor.php" method="post">
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Name:</font><BR>
		<input type=text name=name size=20 maxlenght=20 value="<? echo $rows[name]?>"><BR>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Email Address:</font><BR>
		<input type=text name=email size=20 maxlenght=40 value="<? echo $rows[email]?>"><BR>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">IP Address:</font><BR>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $rows[postip]?></font><BR>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Rating:</font><BR>
			<select name=rating>
			<?
			$i = 1;
			while ($i <= 10) {
				if ($i == $rows[rating]) echo "<option selected value=$i>$i</option>";
				else echo "<option value=$i>$i</option>";
				$i++;
			}
			?>
			</select><BR>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Review:</font><BR>
		<textarea rows=10 cols=40 name=review><? echo $rows[review]?> [Edited by admin]</textarea><BR>
		<input type=submit name=submit>
		<input type=hidden name=sid value="<? echo $sid;?>">
		<input type=hidden name=rid value="<? echo $rid;?>">
		<input type=hidden name=postdate value="<? echo $rows[postdate];?>">
		<input type=hidden name=a value="update_2">
		</form>
	<?

}

if ($sid AND $a=="update_2" AND $rid) {
	$query = mysql_db_query ($dbname,"update top_review set name='$name',email='$email',rating='$rating',review='$review',postdate='$postdate' where sid=$sid AND rid=$rid",$db) or die (mysql_error());
	if ($query) echo "Review was updated. <A HREF=\"reditor.php?sid=$sid&a=edit\">Back</A>";
}

include "footer.php";
?>