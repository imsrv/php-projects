
<?
include "config.php";
include "header.php";

//////////////////////////////////////////////////
//	The list of included Plugins		//
//////////////////////////////////////////////////

// Back up plugin
//	include "plugins/backup.plugin.php";

//////////////////////////////////////////////////

$reset_file = file($reset_log_file);

// checks reset time and resets if it's time
//###########

// makes sure the file isn't empty, if so writes time
if(empty($reset_file[0])){
reset_update_time($reset_log_file,$days_to_reset);
}

if($reset_file[0] <= time()){
reset_list($site_log_file,$total,$file);
reset_update_time($reset_log_file,$days_to_reset);
}
//###########

$reset_file = file($reset_log_file);

if (!$cid) {$cid = 0;}
if (!$from) {$from = 0;}

if ($cid == 0) {
	$squery = mysql_db_query ($dbname,"select *,if (rank/votes, rank/votes,0) as ranks,if (stars, stars,0) as star from top_user where status='Y' AND hitin>=$shown order by hitin DESC,ranks DESC,star DESC,hitout DESC limit $from,$t_step",$db) or die (mysql_error());
	$tquery = mysql_db_query ($dbname,"select count(sid) as total from top_user where status='Y'",$db) or die (mysql_error());
}
else {
	$squery = mysql_db_query ($dbname,"select *,if (rank/votes, rank/votes,0) as ranks,if (stars, stars,0) as star from top_user where status='Y' AND hitin>=$shown and category=$cid order by hitin DESC,ranks DESC,star DESC,hitout DESC limit $from,$t_step",$db) or die (mysql_error());
	$tquery = mysql_db_query ($dbname,"select count(sid) as total from top_user where status='Y' and category=$cid",$db) or die (mysql_error());
}

?>
<SCRIPT LANGUAGE="JavaScript">
<!-- 
if (window != top) { top.location.href = location.href; } 
-->
</SCRIPT>
<SCRIPT language=JavaScript><!--
	function changecat(newcat) {
	    exit=false;
	    site = "index.php?cid="+(newcat);
	    if (newcat!=0) {
		top.location.href=site;
	    } else {
		top.location.href="index.php";
	    }
	}
	-->
</SCRIPT>

<center>
<?
	if ($a_m == 1) { echo $vote_log_message;}
	if ($a_m == 2) { echo $anti_cheat_message;}
	if ($a_m == 5) { echo $cookie_message;}
?>
<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><a href=add.php>Add Site</a> || <a href=edit.php>Edit Site</a> || <a href=last.php>Last <? echo $last_ssites;?> Submitted Sites</a> || <a href=help.php>Help</a></font>
</center>
<BR>

<table bgcolor="black" align="center" width="600" border="0" cellspacing=1 cellpadding=3>
	<tr>
		<td bgcolor="#C3D8E9" colspan="5" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $top_name;?></font></td>
	</tr>
	<tr>
		<td bgcolor="white" colspan="5" align="right">
			<B><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="-2">Pages: 
			<?
			$trows = mysql_fetch_array($tquery);

			$count = $trows[total];
			$i = 0;
			$step = $t_step;
			$sstep = 0;

			echo $round;
			while ($sstep < $count) {
				if ($from == $sstep) {
					echo " [$i] ";
				}
				else {
					echo " [<a href=\"?from=$sstep&cid=$cid\">$i</a>] ";
				}
					$sstep = $sstep + $step;
					$i++;
			}
			?>
			</font></B>
		</td>
	</tr>
	<tr>
		<td align="center" BGCOLOR="#A3C2DD"><a href=random.php><img src="images/random.gif" width=20 height=15 border=0 ALT="Random Link"></a></td>
		<td colspan="4" align="right" BGCOLOR="#A3C2DD">
		<form action=index.php method=post>
		<table width=100% border=0 cellpadding=2 cellspacing=0>
		<tr>
			<td align=right><select name=cid onchange=changecat(this.options[this.selectedIndex].value)>
			<option value=0 <? if ($cid == 0) {echo "selected"; }?>>All</option>
			<?
			$query = mysql_db_query ($dbname,"select * from top_cats order by catname",$db) or die (mysql_error());
			while ($rows = mysql_fetch_array($query))
			{
				echo "<option value=$rows[cid]";
				if ($cid == $rows[cid]) {echo " selected";}
				echo ">$rows[catname]</option><BR>";
			}
			?>
			</select></td>
		</tr></table>
		</td>
	</tr>
	<tr>
		<td bgcolor="#5087AF" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $RANK;?></font></td>
		<td bgcolor="#5087AF" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $SITE;?></font></td>
		<td bgcolor="#5087AF" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $VOTES;?></font></td>
		<td bgcolor="#5087AF" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $HITS;?></font></td>
		<td bgcolor="#5087AF" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $RATING;?></font></td>
	</tr>
<TR>
	<TD Colspan="6" BGCOLOR="white" Align="center">
		<? include "ads1.html";?>
	</TD>
</TR>
<?

if (!$from) $cc=1;
else $cc = $from+1;

while ($rows = mysql_fetch_array($squery)) {
	$jscript_imgs[$img_num] = $rows[banner];	
	if ($rows[ranks] > 0) {
		$rating = $rows[ranks];
	}
	else { $rating = 0;}
	?>
	<tr>
		<td align="center" bgcolor="white">
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size-1;?>"><? echo $cc;?></font>
		</td>
		<td bgcolor="white">
			<center><a href="out.php?<? echo "site=".$rows[sid];?>" target="_blank" onmouseover="window.status='<? echo $rows[url]?>'; return true;" onmouseout="window.status=''; return true;">
			<? 
			echo "<IMG SRC=\"".$rows[banner]."\" BORDER=\"0\" width=\"$max_banner_width\" height=\"$max_banner_height\"><br>";
			?>
			</A></center>
			<?
				if ($rows[country]) {
					$country = substr($rows[country],0,strpos($rows[country],'.'));
					echo "<img width=\"20\" height=\"13\" align=\"center\" src=\"images/flags/".$rows[country]."\" border=1 Alt=\"".$country."\">";
				}
			?>		
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size-1;?>">		
			<a href="out.php?<? echo "site=".$rows[sid];?>" target="_blank" onmouseover="window.status='<? echo $rows[url]?>'; return true;" onmouseout="window.status=''; return true;"><? echo $rows[title];?></A>
			<? 
			if ($new_site_days > 0) {
				if (time() - $rows[sid] - 86400*$new_site_days < 0) echo $new_site_image;
			}	
			if ($rows[stars] > 0) {
				$sc = $rows[stars];
				while ($sc > 0) {
					echo "<img src=\"images/star.gif\" width=10 height=9 border=0 ALT=\"$rows[stars] Stars\">";
					$sc--;
				}
			}
			?>
			<BR>
		<? echo $rows[description];?>
		<div align=right>
		<?		
		if ($use_review == 1) {
			$reviews = get_site_reviews($rows[sid]);
			echo "<B><font size=\"-2\"><A HREF=\"review.php?site=$rows[sid]\">Write Review</A> ($reviews)</font></B>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if ($use_taf == 1) {
			echo "<B><font size=\"-2\"><A HREF=\"recommend.php?site=$rows[sid]&cid=$rows[category]\">Recommend it!</A></font></B>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if ($cid == 0) {
			$categ = get_site_category($rows[sid],$rows[category]);
			echo "<B><font size=\"-2\">Category : <A HREF=\"index.php?cid=$rows[category]\">$categ</A></font></B>";
		}
		?>
		</div>
		</font></td>
		<td align="center" bgcolor="white">
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size-1;?>"><? echo $rows[hitin];?></font>		
		</td>
		<td align="center" bgcolor="white">
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size-1;?>"><? echo $rows[hitout];?></font>		
		</td>
		<td align="center" bgcolor="white">
			<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size-1;?>"><? echo $rating;?><BR>
			<A HREF="rate.php?site=<? echo $rows[sid]?>">Rate It!</A>
			</font>		
		</td>
	</tr>
	<?
$cc++;
}

$query = mysql_db_query ($dbname,"select count(sid) as stotal from top_user where status='Y'",$db) or die (mysql_error());
$rows = mysql_fetch_array($query);
$stotal = $rows[stotal];

?>
	<TR>
		<TD Colspan="6" BGCOLOR="white" Align="center">
			<? include "ads2.html";?>
		</TD>
	</TR>
	<tr>
		<td bgcolor="#C3D8E9" colspan="6" align="center">
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size-1;?>"><? echo $stotal;?> Sites in our Database, List Views: <? include "counter.php";?><BR>
		In/Out resets every <?echo $days_to_reset;?> days, Next Reset: <? echo date("n/j/y h:i:s a", $reset_file[0])?>.<BR>
		<?
				

		$mtime2 = explode(" ", microtime());
		$endtime = $mtime2[1] + $mtime2[0];
		$totaltime = ($endtime - $starttime);
		$totaltime = number_format($totaltime, 7);

		echo "Processing Time: ".$totaltime." sec.";
		
		?>
		</font></td>
	</tr>
	<tr>
		<td valign="top" align = "left" bgcolor="#ffff99" colspan=5">
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size-1;?>">
		<img src="images/star.gif" width="10" height="9" border="0" alt="">=Useless
		<img src="images/star.gif" width="10" height="9" border="0" alt=""><img src="images/star.gif" width="10" height="9" border="0" alt="">=Boring
		<img src="images/star.gif" width="10" height="9" border="0" alt=""><img src="images/star.gif" width="10" height="9" border="0" alt=""><img src="images/star.gif" width="10" height="9" border="0" alt="">=Alright
		<img src="images/star.gif" width="10" height="9" border="0" alt=""><img src="images/star.gif" width="10" height="9" border="0" alt=""><img src="images/star.gif" width="10" height="9" border="0" alt=""><img src="images/star.gif" width="10" height="9" border="0" alt="">=Superb
		<img src="images/star.gif" width="10" height="9" border="0" alt=""><img src="images/star.gif" width="10" height="9" border="0" alt=""><img src="images/star.gif" width="10" height="9" border="0" alt=""><img src="images/star.gif" width="10" height="9" border="0" alt=""><img src="images/star.gif" width="10" height="9" border="0" alt="">=Outstanding
		</font>
		</td>
	</tr>
</table>
<?
include "footer.php";
?>
