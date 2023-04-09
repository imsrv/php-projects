<?
include "config.php";

if ($submit AND $site AND $REQUEST_METHOD == "POST" AND $use_review == 1) {

        $review = trim($review);
	$review = preg_replace('/[^a-zA-Z ]/', '', $review);
	$review = htmlspecialchars($review);

        $name = trim($name);
	$name = preg_replace('/[^a-zA-Z ]/', '', $name);
	$name = htmlspecialchars($name);

	$check_email = check_email_addr($email);

	$err = "";
	if (!$name) $err.="Please specify Your Name.<BR>";
	if (!$email) $err.="Please specify Your Email.<BR>";
	if (!$review) $err.="Please write Your Review.<BR>";
	if ($check_email == 0) $err.="Please specify real email address.<BR>";
	if ($anti_review[$site] == 1) $err.="Sorry, but you can not post more than one review per day.<BR>";
	
	if (!$err) { 
		$cdate = date ("Ymd");		
		$query = mysql_db_query ($dbname,"select postip from top_review where sid=$site AND postdate='$cdate' AND postip='$REMOTE_ADDR'",$db) or die (mysql_error());
		if (mysql_num_rows($query) > 0) {
			$perr=1;
		}
		else {
			mysql_db_query ($dbname,"insert into top_review (postip,rating,sid,review,name,email) values ('$REMOTE_ADDR','$rating','$site','$review','$name','$email')",$db) or die (mysql_error());
			setcookie ("anti_review[$site]", "1",time()+86400);
		}
	}
}

include "header.php";

if ($site) {
	if (!$from OR $from < 0 OR $from < $review_step) $from = 0;
	$query = mysql_db_query ($dbname,"select *,DATE_FORMAT(postdate, '%M/%d/%Y') as post_date from top_review where sid=$site ORDER BY rid DESC LIMIT $from,$review_step",$db) or die (mysql_error());
	$tquery = mysql_db_query ($dbname,"select count(rid) as rtotal from top_review where sid=$site",$db) or die (mysql_error());
	$squery = mysql_db_query ($dbname,"select title from top_user where sid=$site ",$db) or die (mysql_error());
	$srows = mysql_fetch_array($squery);

	if ($err) echo "<center><font color=\"red\" face=\"$font_face\" size=\"$font_size\">$err</font></center>";
	if ($perr==1)  echo "<center><font color=\"red\" face=\"$font_face\" size=\"$font_size\">Sorry, but you can not post more than one review per day.</font></center>";

	echo "<CENTER><font color=\"$font_color\" face=\"$font_face\" size=\"$font_size\">
		<A HREF=\"out.php?site=$site\">$srows[title]</A> Reviews:<BR>
		<A HREF=\"$url_to_folder\">Return to $top_name</A>
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
			echo " [<a href=\"?from=$sstep&site=$site\">$i</a>] ";
		}
			$sstep = $sstep + $step;
			$i++;
	}
	echo "</font></B></div>";

	
	while ($rows = mysql_fetch_array($query)) {
		echo "<HR><font color=\"$font_color\" face=\"$font_face\" size=\"$font_size\">
		<A HREF=\"mailto:$rows[email]\">$rows[name]</A><BR>
		Rating: $rows[rating]<BR>
		$rows[review] - $rows[post_date]
		</font>";
	}
	?>
		<HR>
		<form action="review.php" method="post">
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Name:</font><BR>
		<input type=text name=name size=20 maxlenght=20><BR>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Email Address:</font><BR>
		<input type=text name=email size=20 maxlenght=40><BR>
		<?
		if (!$phptopsites_review[$site]) {
			?>
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Rating:</font><BR>
			<select name=rating>
				<option value=1>1 (worst)</option>	
				<option value=2>2</option>	
				<option value=3>3</option>	
				<option value=4>4</option>	
				<option value=5>5</option>	
				<option value=6>6</option>	
				<option value=7>7</option>	
				<option value=8>8</option>	
				<option value=9>9</option>	
				<option value=10>10 best</option>	
			</select><BR>
			<?
		}
		else {
			?>
			<input type=hidden name=rating value="<? echo $phptopsites_review[$site];?>">
			<?
		}
		?>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Review:</font><BR>
		<textarea rows=10 cols=40 name=review></textarea><BR>
		<input type=submit name=submit>
		<input type=reset name=reset>
		<input type=hidden name=site value="<? echo $site;?>">
		</form>
	<?
}

include "footer.php";
?>
