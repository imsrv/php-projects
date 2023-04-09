<?
include "config.php";
include "header.php";

$squery = mysql_db_query ($dbname,"select *,if (rank/votes, rank/votes,0) as ranks,if (stars, stars,0) as star from top_user where status='Y' order by sid DESC limit $last_ssites",$db) or die (mysql_error());

?>
<center>
<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><a href=add.php>Add Site</a> || <a href=edit.php>Edit Site</a> || <a href="last.php">Last <?echo $last_ssites?> Submitted Sites</a> || <a href=help.php>Help</a></font>
</center>
<BR>

<table bgcolor="black" align="center" width="600" border="0" cellspacing=1 cellpadding=3>
	<tr>
		<td bgcolor="#C3D8E9" colspan="4" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><a href="<? echo $url_to_folder?>"><? echo $top_name;?></a></font></td>
	</tr>
	<tr>
		<td bgcolor="#5087AF" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $SITE?></font></td>
		<td bgcolor="#5087AF" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $VOTES?></font></td>
		<td bgcolor="#5087AF" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $HITS?></font></td>
		<td bgcolor="#5087AF" align="center"><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $RATING;?></font></td>
	</tr>
<TR>
	<TD Colspan="4" BGCOLOR="white" Align="center">
		<? include "ads1.html";?>
	</TD>
</TR>
<?

$cc=10;
$img_num = 1;

while ($rows = mysql_fetch_array($squery)) {
	$jscript_imgs[$img_num] = $rows[banner];	
	if ($rows[ranks] > 0) {
		$rating = $rows[ranks];
	}
	else { $rating = 0;}
	?>
	<tr>
		<td bgcolor="white">
			<center><a href="out.php?<? echo "site=".$rows[sid];?>" target="_blank" onmouseover="window.status='<? echo $rows[url]?>'; return true;" onmouseout="window.status=''; return true;">
			<? 
			echo "<IMG SRC=\"images/nota.gif\" BORDER=\"0\" width=\"$max_banner_width\" height=\"$max_banner_height\" NAME=\"banner_$img_num\"><br>";
			$img_num++;
			//if (check_banner($rows[banner]) != 1) echo "<IMG LowSrc=\"images/nota.gif\" SRC=\"images/nota.gif\" BORDER=\"0\" width=\"$max_banner_width\" height=\"$max_banner_height\">";
			//else echo "<IMG LowSrc=\"images/nota.gif\" SRC=\"$rows[banner]\" BORDER=\"0\" width=\"$max_banner_width\" height=\"$max_banner_height\">";
			?>
			</A></center>
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
			echo "<B><font size=\"-2\">Category <A HREF=\"index.php?cid=$rows[category]\">$categ</A></font></B>";
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
		<A HREF="rate.php?site=<? echo $rows[sid]?>">Rate it!</A>
		</font>
		</td>
	</tr>
	<?
$cc--;
}
?>
<script language="javascript"><!--
function DisplayImg(imgnum){
<?	
foreach($jscript_imgs as $key => $value) {		
	if(trim($value) != "" ) {
?>
		if(imgnum = <?=$key?>)	{
			document.banner_<?=$key?>.src = "<?=$value?>";
		}
<?
	}
}
?>
}
function  getCamImage(){
<?
foreach($jscript_imgs as $key => $value){
	if (trim($value) != "" )
	{ 
?>
	DisplayImg("<?=$key?>");
<? 
	}
}
?>
}
//--></script>
	<TR>
		<TD Colspan="4" BGCOLOR="white" Align="center">
			<? include "ads2.html";?>
		</TD>
	</TR>
	<tr>
		<td valign="top" align="left" bgcolor="#ffff99" colspan="6">
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