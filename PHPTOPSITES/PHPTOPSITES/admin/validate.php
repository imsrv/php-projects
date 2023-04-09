<?
include "../config.php";
include "header.php";

$query = mysql_db_query ($dbname,"select * from top_user where status='N'",$db) or die (mysql_error());

if (mysql_num_rows($query) > 0) {
	echo "<form action=\"clean.php\" method=\"post\">";

	while ($rows=mysql_fetch_array($query)) {
		echo "
			<table align=center width=90% border=0 cellpadding=3 cellspacing=0>
			<tr><td Bgcolor=#7F7F7F><font size=2 color=white>Site ID # $rows[sid]</font>&nbsp;&nbsp;&nbsp;<a href=\"".$rows[url]."\"><font color=#ffffff size=2>Review this Site</font></a></td></tr>
			<tr><td bgcolor=#C0C0C0>";
				?>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Name: <? echo $rows[name]?></font><BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Password: <? echo $rows[password]?></font><BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Email Address: <? echo $rows[email]?></font><BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site Title: <? echo $rows[title]?></font><BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site URL: <? echo $rows[url]?></font><BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Link back URL: <? echo $rows[linkback]?></font>&nbsp;&nbsp;&nbsp;<a href="<? echo $rows[linkback]?>"><font color=#000000 size=2>Open</font></a><BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Banner URL: <? echo $rows[banner]?></font><BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">
				<input type="checkbox" name="usedefault[]" value="yes"><font size="1"><b>Use a default "Not Available" Banner ?</b><BR>
				The URL to current banner will be replaced with "Not Available" banner.
				</font>
				<hr>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">
				Banner Connection Result <font size="1"><b>(first 10 strings from connection):</b><BR>
				<? 
				$host = substr($rows[banner],7,strlen($rows[banner]));
				$path = substr($host,strpos($host,"/"),strlen($rows[banner]));
				$host = substr($host,0,strpos($host,"/"));
				
				if ($host && $path) $fd = fsockopen($host,80,$errno,$errstr,10);
		
				if ($fd) {		
					fputs ($fd, "GET http://$host/$path HTTP/1.0\r\n\r\n");
		
				        $vc = 0;
					while (!feof ($fd) && $vc < 10) {
					     $buffer = fgets($fd, 128);
					     if (strstr($buffer,'200') && $vc == 0) { $buffer="<b>".$buffer."</b>|| <font color=\"green\">OK</font>" ;}
					     elseif (!strstr($buffer,'200') && $vc == 0) { $buffer="<b>".$buffer."</b>|| <font color=\"red\">May be ERROR</font>" ;}
					     if (strstr($buffer,'Content-Type:')) {
					     	 if (strstr($buffer,'image/gif') || strstr($buffer,'image/jpeg')) { $buffer="<b>".$buffer."</b>|| <font color=\"green\">OK</font>" ;}
						 else { $buffer="<b>".$buffer."</b>|| <font color=\"red\">May be Error</font>" ;}
					     }
					     echo $buffer."<br>";
					     $vc = $vc + 1;
					}
					fclose($fd);
				}
				?>
				</font>
				<hr>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Banner width: <? echo $rows[bannerw];?></font><BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Banner height: <? echo $rows[bannerh];?></font><BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site Description: <? echo $rows[description]?></font><BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Site Category:</font>
				<select name="category[]">
				<?
				$cquery = mysql_db_query ($dbname,"select * from top_cats order by catname",$db) or die (mysql_error());
				while ($rowss = mysql_fetch_array($cquery))
				{
					echo "<option value=$rowss[cid]";
					if ($rows[category] == $rowss[cid]) {echo " selected";}
					echo ">$rowss[catname]</option>\n";
				}
				?>
				</select>
				<BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Country:</font>
				<?
				$handle=opendir("../images/flags");
				while (false!==($file = readdir($handle))) { 
				    if ($file != "." && $file != "..") { 
					$country = substr($file,0,strpos($file,'.'));
				if ($rows[country] == $file) echo $country;
				    } 
				}
				closedir($handle); 
				?>
				<BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Action: </font>
				<SELECT NAME="a[]">
					<option value="Ignore Site">Ignore Site</option>
					<option value="Add Site">Add Site</option>
					<option value="Reject Site">Reject Site</option>
				</SELECT>
				<BR>
				<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Reject Reason:</font><BR>
				<input size="50" type="text" name="reason[]"><BR>			
				<BR>
				<center>
				<BR>
				<input type=hidden name="sid[]" value="<? echo $rows[sid]?>">
				<input type=hidden name="email[]" value="<? echo $rows[email]?>">
				<input type=hidden name="passwd[]" value="<? echo $rows[password]?>">
				<input type=hidden name="banner[]" value="<? echo $rows[banner]?>">
				</center>
				<? 
		echo "</td></tr></table><BR>";
	}
echo "<center><input type=\"submit\" name=\"submit\"></center></form>";
}
else {
?>
<table align=center width=90% border=0 cellpadding=3 cellspacing=0>
	<tr>
		<td bgcolor="#eeeeee" align="center"><br><font face="<? echo $font_face;?>" size="2">Sorry, there are no sites to validate.</font><br><br></td>
	</tr>
</table>
<?
}
include "footer.php";
?>