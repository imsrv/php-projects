<?php

echo $tabletop;
require_once('b2config.php');

if (!$posts) {
	if ($posts_per_page) {
		$posts=$posts_per_page;
	} else {
		$posts=10;
		$posts_per_page=$posts;
	}
}

if ((!empty($poststart)) && (!empty($postend)) && ($poststart == $postend)) {
	$p=$poststart;
	$poststart=0;
	$postend=0;
}

if (!$poststart) {
	$poststart=0;
	$postend=$posts;
}

$nextXstart=$postend;
$nextXend=$postend+$posts;

$previousXstart=($poststart-$posts);
$previousXend=$poststart;
if ($previousXstart < 0) {
	$previousXstart=0;
	$previousXend=$posts;
}

?>

<table width="100%">
<tr>
<td valign="top" width="200">
Show posts: </td>
<td>
<table cellpadding="0" cellspacing="0" border="0">
<td colspan="2" align="center"><!-- show next/previous X posts -->
<form name="previousXposts" method="get"><?php
if ($previousXstart > 0) {
?>
<input type="hidden" name="poststart" value="<?php echo $previousXstart; ?>" />
<input type="hidden" name="postend" value="<?php echo $previousXend; ?>" />
<input type="submit" name="submitprevious" class="search" value="< <?php echo $posts ?>" /><?php
}
?></form></td><td><form name="nextXposts" method="get">
<input type="hidden" name="poststart" value="<?php echo $nextXstart; ?>" />
<input type="hidden" name="postend" value="<?php echo $nextXend; ?>" />
<input type="submit" name="submitnext" class="search" value="<?php echo $posts ?> >" /></form>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td valign="top" width="200"><!-- show X first/last posts -->
<form name="showXfirstlastposts" method="get">
<input type="text" name="posts" value="<?php echo $posts ?>" style="width:40px;" /?>
<select name="order">&nbsp;<option value="DESC" <?php
if (!isset($order))
	$order="DESC";
$i = $order;
if ($i == "DESC")
echo " selected";
?>>last posts</option>
<option value="ASC" <?php
if ($i == "ASC")
echo " selected";
?>>first posts</option>
</select>&nbsp;<input type="submit" name="submitfirstlast" class="search" value="OK" />
</form>
</td>
<td valign="top"><!-- show post X to post X -->
<form name="showXfirstlastposts" method="get">
<input type="text" name="poststart" value="<?php echo $poststart ?>" style="width:40px;" /?>&nbsp;to&nbsp;<input type="text" name="postend" value="<?php echo $postend ?>" style="width:40px;" /?>&nbsp;<select name="order">
<option value="DESC" <?php
$i = $order;
if ($i == "DESC")
echo " selected";
?>>from the end</option>
<option value="ASC" <?php
if ($i == "ASC")
echo " selected";
?>>from the start</option>
</select>&nbsp;<input type="submit" name="submitXtoX" class="search" value="OK" /></form>
</td>

</tr>
</table>
<?php echo $tablebottom ?>

<br />

<?php echo $tabletop ?>
<table width="100%">
	<td valign="top" width="33%">
		<form name="searchform" action="b2edit.php" method="get">
			<input type="hidden" name="a" value="s" />
			<input onFocus="this.value='';" onBlur="if (this.value=='') {this.value='search...';}" type="text" name="s" value="search..." size="7" style="width: 100px;" />
			<input type="submit" name="submit" value="search" class="search" />
		</form>
	</td>
<td valign="top" width="33%" align="center">
	<form name="viewcat" action="b2edit.php" method="get">
		<select name="cat" style="width:140px;">
		<option value="all">All Categories</option>
		<?php
	$query="SELECT * FROM $tablecategories";
	$result=mysql_query($query);
	$querycount++;
	$width = ($mode=="sidebar") ? "100%" : "170px";
	while($row = mysql_fetch_object($result)) {
		echo "<option value=\"".$row->cat_ID."\"";
		if ($row->cat_ID == $postdata["Category"])
			echo " selected";
		echo ">".$row->cat_name."</option>";
	}
		?>
		</select>
		<input type="submit" name="submit" value="View" class="search" />
	</form>
</td>
<td valign="top" width="33%" align="right">
<form name="viewarc" action="b2edit.php" method="get">
	<?php

	if ($archive_mode == "monthly") {
		echo "<select name=\"m\" style=\"width:120px;\">";
		$arc_sql="SELECT DISTINCT YEAR(post_date), MONTH(post_date) FROM $tableposts ORDER BY post_date DESC";
		$querycount++;
		$arc_result=mysql_query($arc_sql) or die($arc_sql."<br />".mysql_error());
		while($arc_row = mysql_fetch_array($arc_result)) {
			$arc_year  = $arc_row["YEAR(post_date)"];
			$arc_month = $arc_row["MONTH(post_date)"];
			echo "<option value=\"$arc_year".zeroise($arc_month,2)."\">";
			echo $month[zeroise($arc_month,2)]." $arc_year";
			echo "</option>\n";
		}
	} elseif ($archive_mode == "daily") {
		$archive_day_date_format = "Y/m/d";
		$arc_sql="SELECT DISTINCT YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) FROM $tableposts ORDER BY post_date DESC";
		$querycount++;
		$arc_result=mysql_query($arc_sql) or die($arc_sql."<br />".mysql_error());
		while($arc_row = mysql_fetch_array($arc_result)) {
			$arc_year  = $arc_row["YEAR(post_date)"];
			$arc_month = $arc_row["MONTH(post_date)"];
			$arc_dayofmonth = $arc_row["DAYOFMONTH(post_date)"];
			echo "<option value=\"$arc_year".zeroise($arc_month,2).zeroise($arc_dayofmonth,2)."\">";
			echo mysql2date($archive_day_date_format, $arc_year.zeroise($arc_month,2).zeroise($arc_dayofmonth,2)." 00:00:00");
			echo "</option>\n";
		}
	} elseif ($archive_mode == "weekly") {
		echo "<select name=\"w\" style=\"width:120px;\">";
		if (!isset($start_of_week)) {
			$start_of_week = 1;
		}
		$archive_week_start_date_format = "Y/m/d";
		$archive_week_end_date_format   = "Y/m/d";
		$archive_week_separator = " - ";
		$arc_sql="SELECT DISTINCT YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date), WEEK(post_date) FROM $tableposts ORDER BY post_date DESC";
		$querycount++;
		$arc_result=mysql_query($arc_sql) or die($arc_sql."<br />".mysql_error());
		$arc_w_last = '';
		while($arc_row = mysql_fetch_array($arc_result)) {
			$arc_year = $arc_row["YEAR(post_date)"];
			$arc_w = $arc_row["WEEK(post_date)"];
			if ($arc_w != $arc_w_last) {
				$arc_w_last = $arc_w;
				$arc_ymd = $arc_year."-".zeroise($arc_row["MONTH(post_date)"],2)."-" .zeroise($arc_row["DAYOFMONTH(post_date)"],2);
				$arc_week = get_weekstartend($arc_ymd, $start_of_week);
				$arc_week_start = date($archive_week_start_date_format, $arc_week['start']);
				$arc_week_end = date($archive_week_end_date_format, $arc_week['end']);
				echo "<option value=\"$arc_w\">";
				echo $arc_week_start.$archive_week_separator.$arc_week_end;
				echo "</option>\n";
			}
		}
	} elseif ($archive_mode == "postbypost") {
		echo '<input type="hidden" name="more" value="1" />';
		echo '<select name="p" style="width:120px;">';
		$requestarc = " SELECT ID,post_date,post_title FROM $tableposts ORDER BY post_date DESC";
		$querycount++;
		$resultarc = mysql_query($requestarc);
		while($row=mysql_fetch_object($resultarc)) {
			if ($row->post_date != "0000-00-00 00:00:00") {
				echo "<option value=\"".$row->ID."\">";
				if (strip_tags($row->post_title)) {
					echo strip_tags(stripslashes($row->post_title));
				} else {
					echo $row->ID;
				}
				echo "</option>\n";
			}
		}
	}

	echo "</select>";
	?>
	<input type="submit" name="submit" value="View" class="search" />
</form>
</td>

</table>
<br />

<table cellspacing="0" cellpadding="5" border="0" width="100%">
	<?php
	// these lines are b2's "motor", do not alter nor remove them
	include("blog.header.php");

	while($row = mysql_fetch_object($result)) {
		$posts_per_page = 10;
	start_b2(); ?>
		<tr>
		<td>
			<p>
				<b><?php the_time('Y/m/d @ H:i:s'); ?></b> [ <a href="b2edit.php?p=<?php echo $id ?>&c=1"><?php comments_number('no comment', '1 comment', "% comments") ?><?php trackback_number('', ', 1 trackback', ', % trackbacks') ?><?php pingback_number('', ', 1 pingback', ', % pingbacks') ?></a>
				<?php
				if (($user_level > $authordata[13]) or ($user_login == $authordata[1])) {
				echo " - <a href=\"b2edit.php?action=edit&post=".$postdata["ID"];
				if ($m)
				echo "&m=$m";
				echo "\">Edit</a>";
				echo " - <a href=\"b2edit.php?action=delete&post=".$postdata["ID"]."\" onclick=\"return confirm('You are about to delete this post \'".$row->post_title."\'\\n  \'Cancel\' to stop, \'OK\' to delete.')\">Delete</a> ";
				}
				?>
				]
				<br />
				<font color="#999999"><b><a href="<?php permalink_single($blogfilename); ?>" title="permalink"><?php the_title() ?></a></b> by <b><?php the_author() ?> (<a href="javascript:profile(<?php the_author_ID() ?>)"><?php the_author_nickname() ?></a>)</b>, in <b><?php the_category() ?></b></font><br />
				<?php permalink_anchor(); ?>
				<?php
				if ($safe_mode)
					echo "<xmp>";
				the_content();
				if ($safe_mode)
					echo "</xmp>";
				?>
				</p>
				<?php

				// comments
				if (($withcomments) or ($c)) {

					$queryc = "SELECT * FROM $tablecomments WHERE comment_post_ID = $id ORDER BY comment_date";
					$resultc = mysql_query($queryc);
					if ($resultc) {
					?>

					<a name="comments"></a>
					<p><b><font color="#ff3300">::</font> comments</b></p>

					<?php
					while($rowc = mysql_fetch_object($resultc)) {
						$commentdata = get_commentdata($rowc->comment_ID);
					?>
				
					<!-- comment -->
					<p>
					<b><?php comment_author() ?> ( <?php comment_author_email_link() ?> / <?php comment_author_url_link() ?> )</b> (IP: <?php comment_author_IP() ?>)
					<br />
					<?php comment_text() ?>
					<br />
					<?php comment_date('Y/m/d') ?> @ <?php comment_time() ?><br />
					<?php 
					if (($user_level > $authordata[13]) or ($user_login == $authordata[1])) {
						echo "[ <a href=\"b2edit.php?action=editcomment&comment=".$commentdata["comment_ID"]."\">Edit</a>";
						echo " - <a href=\"b2edit.php?action=deletecomment&p=".$postdata["ID"]."&comment=".$commentdata["comment_ID"]."\">Delete</a> ]";
					}
					?>
					</p>
					<!-- /comment -->


					<?php //end of the loop, don't delete
					}

					if ($comment_error)
						echo "<p><font color=\"red\">Error: please fill the required fields (name & comment)</font></p>";
					?>

					<p><b><font color="#ff3300">::</font> leave a comment</b></p>


					<!-- form to add a comment -->

					<form action="b2comments.post.php" method="post">
						<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
						<input type="hidden" name="redirect_to" value="<?php echo $HTTP_SERVER_VARS["REQUEST_URI"]; ?>" />
						<input type="text" name="author" class="textarea" value="<?php echo $user_nickname ?>" size="20" tabindex="1" /><br />
						<input type="text" name="email" class="textarea" value="<?php echo $user_email ?>" size="20" tabindex="2" /><br />
						<input type="text" name="url" class="textarea" value="<?php echo $user_url ?>" size="20" tabindex="3" /><br />
						<textarea cols="40" rows="4" name="comment" tabindex="4" class="textarea">comment</textarea><br />
						<input type="checkbox" name="comment_autobr" value="1" checked tabindex="6" class="checkbox" /> Auto-BR (line-breaks become &lt;br> tags)<br />
						<input type="submit" name="submit" class="buttonarea" value="ok" tabindex="5" />

					</form>


					<!-- /form -->


					<?php // if you delete this the sky will fall on your head
					}
				}
				?>
			<br />
			</td>
		</tr>
	<?php

	}
	?>
	</table>
<?php echo $tablebottom ?>
<br />
<?php echo $tabletop ?>
<table width="100%">
<tr>
<td valign="top" width="200">
Show posts: </td>
<td>
<table cellpadding="0" cellspacing="0" border="0">
<td colspan="2" align="center"><!-- show next/previous X posts -->
<form name="previousXposts" method="get"><?php
if ($previousXstart > -1) {
?>
<input type="hidden" name="poststart" value="<?php echo $previousXstart; ?>" />
<input type="hidden" name="postend" value="<?php echo $previousXend; ?>" />
<input type="submit" name="submitprevious" class="search" value="< Previous <?php echo $posts ?>" /><?php
}
?></form></td><td><form name="nextXposts" method="get">
<input type="hidden" name="poststart" value="<?php echo $nextXstart; ?>" />
<input type="hidden" name="postend" value="<?php echo $nextXend; ?>" />
<input type="submit" name="submitnext" class="search" value="Next <?php echo $posts ?> >" /></form>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td valign="top" width="200"><!-- show X first/last posts -->
<form name="showXfirstlastposts" method="get">
<input type="text" name="posts" value="<?php echo $posts ?>" style="width:40px;" /?>
<select name="order">&nbsp;<option value="DESC" <?php
$i = $order;
if ($i == "DESC")
echo " selected";
?>>last posts</option>
<option value="ASC" <?php
if ($i == "ASC")
echo " selected";
?>>first posts</option>
</select>&nbsp;<input type="submit" name="submitfirstlast" class="search" value="OK" />
</form>
</td>
<td valign="top"><!-- show post X to post X -->
<form name="showXfirstlastposts" method="get">
<input type="text" name="poststart" value="<?php echo $poststart ?>" style="width:40px;" /?>&nbsp;to&nbsp;<input type="text" name="postend" value="<?php echo $postend ?>" style="width:40px;" /?>&nbsp;<select name="order">
<option value="DESC" <?php
$i = $order;
if ($i == "DESC")
echo " selected";
?>>from the end</option>
<option value="ASC" <?php
if ($i == "ASC")
echo " selected";
?>>from the start</option>
</select>&nbsp;<input type="submit" name="submitXtoX" class="search" value="OK" /></form>
</td>

</tr>
</table>
<?php echo $tablebottom ?>