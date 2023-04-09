<?
//----------------------------------------//
// Decoded and fixed by WAXZY [MST]
// 07/30/2007
//----------------------------------------//
$ver = "v1.05";

@include ('you_config.php');
@include ('loginchk.php');
/* 
CHECKING FOR GLOBALS OFF TESTING ONLY ...
if(ini_get('register_globals') != 1){
	echo "<CENTER></font><Font Face=Arial color=#CCCCCC Size=-1><b>Register globals is Off script complience check...</font></CENTER><BR>";
}else{
	echo "<CENTER></font><Font Face=Arial color=#CCCCCC Size=-1><b>Register globals is On</font></CENTER><BR>";
}
*/
$linefeed = chr(13).chr(10);# needed as delimiter in flat files
$page = $_SERVER['PHP_SELF'];
# Load clip list into array from flat file
//Must exist lets check ...
if(file_exists($url_file)){
	$file = file($url_file);
	foreach($file as $line) {
		$clip = $line;
		$clips[] = trim($clip);
	}
}else{
	$missing = ' - <B>ERROR:</B> DB File was not found!';
}
$countit = count($clips) + 1;
# Calculate pagination info
#----------------------------
$current_page = trim(strip_tags($_REQUEST['pageno']));
if ($current_page < 1){
	$current_page = 1;
}
$real_count = $countit - 1;
$total_pages = @ceil($real_count/$records_per_page);
if ($current_page > $total_pages){
	$current_page = $total_pages;
}
if($total_pages > 1){
	$first_record = (($current_page - 1) * $records_per_page);
	$last_record = ($first_record + $records_per_page - 1);
	if ($last_record > ($countit - 2)){
		$last_record = $countit - 2;
	}
}else{
	$first_record = 0;//fix 1 to 0
	$last_record = $countit - 2;
}
# Renumber sort priority.
# --------------------
$auto_sort = $_POST['auto_sort'];
$resort_it = trim(strip_tags($_REQUEST['resort']));
if ($auto_sort == '1' or $resort_it == '1'){
	$i=0;
	while ($clips[$i]){
		$ii = $i + 1;
		$my_clip = explode('|', $clips[$i]);
		$my_clip[0] = ($ii*10);
		$clipz[$i] = implode('|', $my_clip);
		#print "clipz i is $clipz[$i]<br>";
		$i++;
	}
	@sort($clipz , SORT_NUMERIC);
	$fh = fopen($url_file, 'w') or die("can't open file");
	$i=0;
	while ($clipz[$i]){
		$data =  "$clipz[$i]$linefeed";
		#print "$data<br>";
		fwrite($fh, $data);
		$i++;
	}
	fclose($fh);
	print"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=./admin.php?pageno=$current_page\">";
}
$editit = $_POST['editit'];
# Edit a video clip.
# --------------------
$input = trim(strip_tags($_REQUEST['edit']));
if ($editit){
	$edited = $input;
	if ($edited > 0 && $edited < $countit){
		$record_to_edit = $edited - 1;
		$so = trim(strip_tags($_REQUEST['so']));
		$cn = trim(strip_tags(ucwords($_REQUEST['cn'])));
		//Bad code here could damage our DB or be used for evil ...
		$so = preg_replace("/(#|;|\||~|\*)/i", '', $so);
		$cn = preg_replace("/(#|;|\||~|\*)/i", '', $cn);
		$cn = stripslashes($cn);
		$cn = eregi_replace(' +', ' ', $cn);
		$cn = str_replace('"','&quot;', $cn);
		$li = trim(strip_tags($_REQUEST['li']));
		$li = preg_replace("/(#|;|\||~|\*)/i", '', $li);
		//Quick security check for evil script call ...
		$cl = substr(strrchr($li, '/'), +1);
		if (preg_match('/\./', $cl)){
			$li = preg_match('/^(http:\/\/.+)\/(.+)/', $li, $matches);
			$li = $matches[1];
		}
		$views = trim(strip_tags($_REQUEST['views']));
		$stat_select = trim(strip_tags($_REQUEST['stat_select']));
		$changed_clip = "$so|$cn|$li|$views|$stat_select|0|0";
		$clips[$record_to_edit] = $changed_clip;
		sort($clips , SORT_NUMERIC);
		$fh = fopen($url_file, 'w') or die("can't open file");
		$i=0;
		while ($clips[$i]){
			$data =  "$clips[$i]$linefeed";
			fwrite($fh, $data);
			$i++;
		}
		fclose($fh);
	}
}
# --------------------
# Delete a video clip.
# --------------------
$input = trim(strip_tags($_REQUEST['delete']));
//Check our DB file for correct permissions!
//Show only custom system soft errors to end user! 
//not useless php err they wouldn't understand ...
if (!is_writable($url_file) && $input) {
	$err = '<tr><td colspan="6" align="center" class="err" height="28" bgcolor="#F8CA84"><B>ERROR:</B> DB file must be set to 666, clip data could not be deleted!</span></td></tr>';
}else{
	if ($input && $allow_del == 'yes'){
		$delete = $input;
		if ($delete > 0 && $delete < $countit){			
			unset($clips[($delete - 1)]);
			$clips = array_values($clips);
			sort($clips , SORT_NUMERIC);
			$fh = fopen($url_file, 'w') or die("can't open file");
			$i=0;
			while ($clips[$i]){
				$data =  "$clips[$i]$linefeed";
				fwrite($fh, $data);
				$i++;
			}
			fclose($fh);
		}
		print"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=./admin.php?pageno=$current_page\">";
	}else{
		if ($input){
			$err = '<tr><td colspan="6" align="center" class="err" height="28" bgcolor="#F8CA84"><B>ERROR:</B> clip data deletion has been disabled!</span></td></tr>';
		}
	}
}

# --------------------
# Add a video clip.
# --------------------
$addsn = trim(strip_tags($_POST['sort']));
$addit = trim(strip_tags($_POST['add']));
$addur = trim($_POST['url']);
$addcn = trim(strip_tags(ucwords($_POST['clip_name'])));
$addcn = stripslashes($addcn);
//Bad code here could damage our DB or be used for evil ...
$addur = preg_replace("/(#|;|\||~|\*)/i", '', $addur);
$addcn = preg_replace("/(#|;|\||~|\*)/i", '', $addcn);
$addcn = eregi_replace(' +', ' ', $addcn);
$addcn = str_replace('"','&quot;', $addcn);
$addur  = str_replace('\\','',$addur);
$regexp = "<embed\s[^>]*src=(\"??)([^\">]*?)\\1[^>]*>(.*)<\/embed>";
if(preg_match("/$regexp/siU", $addur, $matches)) { 
	$out = $matches[2];
}
$site = 'youtube';
$site_url = eregi_replace('^(.{2,6}://)?([^/]*)?(.*)', "\\2", $out);
$sck = preg_match("|^www.[$site]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i", $site_url);
//DC Dupe Post fix ...
//No 2 matching clip IDs are allowed!
$file = @file($url_file);
if(file_exists($url_file)){
	foreach ($file as $line) {
		$my_clip = explode('|', $line);
		if($out == $my_clip[2] && $addur){//Posible fix
			$err = '<tr><td colspan="6" align="center" class="err" height="28" bgcolor="#F8CA84"><B>ERROR:</B> Duplicate post, clip data not saved!</span></td></tr>';
			$chk = '1';
		} 
	}
}
//Default to 1 if empty sort field ...
if ($addsn == '' && $auto_sort == '0'){
	$addsn = '1';
}
//Check our DB file for correct permissions!
//Show only custom system soft errors to end user! 
//not useless php err they wouldn't understand ...
if (!is_writable($url_file) && $sck) {
	$err = '<tr><td colspan="6" align="center" class="err" height="28" bgcolor="#F8CA84"><B>ERROR:</B> DB file must be set to 666, clip data could not be saved!</span></td></tr>';
}else
if ($chk != '1'){
	if ($addit && $addur != 'Paste full You Tube Embed Code Here!' && $addcn != '' && $sck){
		if(file_exists($url_file)){
			$addl = @fopen($url_file, 'a');
			flock($addl, LOCK_EX);
			$data = "$addsn|$addcn|$out|0|0|0|0"."$linefeed";
			fputs($addl, $data);
			flock($addl, LOCK_UN);
			fclose($addl);
			$file = file($url_file);
			foreach($file as $line) {
				$clip = $line;
				$clipss[] = trim($clip);
			}
			sort($clipss , SORT_NUMERIC);
			$fh = @fopen($url_file, 'w');
			$i=0;
			while ($clipss[$i]){
				$data =  "$clipss[$i]$linefeed";
				@fwrite($fh, $data);
				$i++;
			}
			fclose($fh);
			print"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=./admin.php?pageno=$current_page\">";
		}
	}else{
		if (!$sck && $addcn != ''){
			$err = '<tr><td colspan="6" align="center" class="err" height="28" bgcolor="#F8CA84"><B>ERROR:</B> Invalid embed code '.$site_url.' clip data not saved!</span></td></tr>';
		}
		if($sck && $addcn == ''){
			$err = '<tr><td colspan="6" align="center" class="err" height="28" bgcolor="#F8CA84"><B>ERROR:</B> You must provide a Clip Name, clip data not saved!</span></td></tr>';
		}
	}
}
	
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><title>YouLoader Admin ';
echo $ver;
echo '</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<meta name="robots" content="noindex,nofollow">
<link href="admin.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="jsrout.js"></script>
</head>
<body>
<form method="POST" action="admin.php?pageno=';
echo $current_pag;
echo '"><div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<table width="675" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#EEEEEE" class="t2">
	<tr bgcolor="EEEEEE"  class="td1">
	  <td background="./images/bg1.gif" width="50" height="28" align="center" nowrap><strong>EDIT</strong></td>
		<td background="./images/bg1.gif" width="74" align="center" nowrap><strong><a href="admin.php?resort=1&pageno=';
echo $current_page;
echo '" title="Resort All Clips" class="M1">SORT</a>:</strong></td>
		<td background="./images/bg1.gif"  width="145" nowrap><strong>CLIP NAME:</strong></td>
		<td background="./images/bg1.gif"  width="265" nowrap><strong>YOU
		TUBE EMBED URL:</strong></td>
		<td background="./images/bg1.gif"  width="65" align="center" nowrap><strong>STATUS:</strong></td>
		<td background="./images/bg1.gif"  width="47" align="center" nowrap><strong>VIEWS:</strong></td>
	</tr>
	<tr bgcolor="EEEEEE" class="td1">
	  <td colspan="6" align="center" nowrap><hr size="1" noshade></td>
    </tr>';

#------------------
# Pagination start
#------------------
for ($i=$first_record;$i<=$last_record;$i++){
	$ii = $i + 1;
	$my_clip = explode('|', $clips[$i]);
	//Status disabled yes no block ...
	//Paul work your magic :-)
	if (!$my_clip[4] == '1'){
		$status = "<span class=\"ena\"><B>Enabled</B></span>";
	}else{
		$status = "<span class=\"dis\"><B>Disabled</B></span>";
	}
	//Auto trim long names to fit our table row.            
	$max_length = '23';
	$desc_len = $my_clip[1];
	if (strlen($desc_len) > $max_length){
		$desc_len = substr($desc_len, 0, $max_length);
		$pos = strrpos($desc_len, ' ');
		if ($pos === false) {
			$clip_title = substr($desc_len, 0, $max_length).' ...';
		}
			$clip_title = substr($desc_len, 0, $pos).' ...';
		}else{
			$clip_title = $desc_len;
		}
		//Begin DC edit field swapping block ...
		$edit = trim(strip_tags($_GET['edit']));
		// Alternate row colors ...
		if ($color == $row_color1){
			$color = $row_color2;
		}else{
			$color = $row_color1;
		}
		//Make URL link field READONLY!
		if ($url_edit == 'no'){
			$readonly  = 'READONLY';
			$title_tag = 'title="Editing clip URL has been disabled!"';
			// Alternate disabled field colors ...
			if ($dis_color == $row_color2){
				$dis_color = $row_color2;
			}else{
				$dis_color = $row_color1;
			}
		}
		//Auto link to our YouLoader PopUp window...
		$uri = str_replace( "\\\\", '/', dirname($_SERVER['PHP_SELF']));
		$url = $_SERVER['SERVER_NAME']."$uri/view.php";
		if ($ii == $edit){
			$flag = '1';
			echo '<tr><td align="center" class="S1" height="28"><select name="stat_select" class="SD1" title="Enable/Disable"><option value="0">Y</option><option value="1">N</option></select></td><td height="28" align="center" class="S1"><input name="edit" type="hidden" value="';
			echo $edit;
			echo '"><input type="text" name="so" value="';
			echo $my_clip[0];
			echo '" size="4" class="SF1"></td><td class="S1"><input type="text" name="cn" value="';
			echo $my_clip[1];
			echo '" class="S1" maxlength="30"></td><td class="S1"><input type="text" name="li" value="';
			echo $my_clip[2];
			echo '" ';
			echo $title_tag;
			echo ' class="S2" style="background-color:';
			echo $dis_color;
			echo '" ';
			echo $readonly;
			echo '></td><td width="65" align="center">';
			echo $status;
			echo '</td><td align="center" class="S1"><input name="views" type="text" value="';
			echo $my_clip[3];
			echo '" size="4" class="SF1"></td</tr>';
		}else{
			echo '<tr bgcolor="';
			echo $color;
			echo '"><td height="28" align="center"><a href="admin.php?delete=';
			echo $ii;
			echo '&pageno=';
			echo $current_page;
			echo '"><IMG SRC="./images/del.gif" border="0" height="11" width="11" title="DELETE" onClick="return del_me(1);"></a><a href="admin.php?edit=';
			echo $ii;
			echo '&pageno=';
			echo $current_page;
			echo '"><IMG SRC="./images/edit.gif" border="0" height="11" width="11" title="EDIT"></a></td>';
			//DC Mod get our PopUp YT ID for a match on click!
			$vc = substr(strrchr($my_clip[2], '/'), +1);
			echo '      <td align="center" class="S1">';
			echo $my_clip[0];
			echo '</td><td class="VC"><a href="#" onClick="open_window(\'http://';
			echo $url;
			echo '?vc=';
			echo $vc;
			echo '&pageno=';
			echo $current_page;
			echo '\',\'demo\',\'\',\'450\',\'410\',\'false\');return false;" title="Quick Preview!" class="VC">';
			echo $clip_title;
			echo '</a></td><td class="S1">';
			echo $my_clip[2];
			echo '</td><td width="65" align="center">';
			echo $status;
			echo '</td><td align="center" class="S1">';
			echo $my_clip[3];
			echo '</td></tr>';
		}
	}

#  End Pagination

//No clips found show our message instead of blank table ...
if ($countit <= '1'){
	echo '<tr><td align="center" colspan="6" class="dis"><B>PLEASE ADD CLIPS:</B> No Video Clips Found!'.$missing.'</td></tr>';
}
//Disable our edit button if were not in edit mode ...
if ($flag != '1'){
	$button = '<input type="button" value="Commit Edit" name="editit" class="button_dis">';
}else{
	$button = '<input type="submit" value="Commit Edit" name="editit" class="button_std">';
}
echo $err;


echo '<tr><td colspan="6"><hr size="1" noshade></td></tr><tr><td align="center" valign="top" class="S1">Auto:';
echo '<select name="auto_sort" class="SD1" title="Auto Sort Y/N">'."\n";
echo '<option value="0" ';
	if ($auto_sort == '0'){
		echo 'selected';
	}
echo ">N</option>\n";
echo '<option value="1" ';
	if ($auto_sort == '1'){
		echo 'selected';
	}
echo ">Y</option>\n</select>\n";
echo '</td><td align="center" valign="top" class="S1">Sorting:<br><input type="text" name="sort" size="2" value="" class="S1"></td><td valign="top" class="S1">Clip Name: <br><input type="text" onKeyUp="CharCoun(\'Text_Limit\',\'Chk_Limit\',\'Characters left {CHAR}\',29)" id="Text_Limit" name="clip_name" size="24" class="S1" maxlength="30"><BR><span class="S1" id="Chk_Limit">Clips In Database: ';
echo $countit-1;
echo '</span></td><td colspan="3"><textarea wrap="soft" rows="3" name="url" style="width:100%" onFocus="if (value ==\'Paste full You Tube Embed Code Here!\') {value =\'\'}" onBlur="if (value == \'\') {value = \'Paste full You Tube Embed Code Here!\'}">Paste full You Tube Embed Code Here!</textarea></tr></td><tr><td class="S1" colspan="3" nowrap><table width="100%" border="0" cellspacing="3" cellpadding="1" class="S3"><tr>';
# Display page numbers Block Style
if (($total_pages > 1) && ($total_pages < 11)){
	print"<td align=\"left\">Page: </td>";
	for ($j=1;$j<=$total_pages;$j++){
		if ($j == $current_page){
			print "<td align=\"center\" width=\"15\" class=\"sel\"><B>$j</B></td>";
		}else{
			print "<td align=\"center\" width=\"15\"><a href=\"admin.php?pageno=$j\" class=\"S3\"><B>$j</B></a></td>";
		}
	}
	//print "|</td>";
}else {
	if ($total_pages > 10){
		print"<td align=\"left\">Page: </td>";
		$start = $current_page - 3;
		if ($start < 1){
			$start = 1;
		}
		$end = $current_page + 3;
		if ($end > $total_pages - 1){
			$end = $total_pages - 1;
		}
		if ($start > 1){
        print "<td align=\"right\"><a href=\"admin.php?pageno=1\" class=\"S3\">1</a> ...</td>";	
		}
		for ($j=$start; $j<=$end; $j++){
	      	if ($j == $current_page){
			print "<td align=\"center\" width=\"15\" class=\"sel\"><B>$j</B></td>";
			}else{
	      	print "<td align=\"center\" width=\"15\"><a href=\"admin.php?pageno=$j\" class=\"S3\"><B>$j</B></a>";
	      		}
	      	}
	      	if ($end < $total_pages-1){
            $tot = ($total_pages-1);
            print"<td align=\"left\">... <a href=\"admin.php?pageno=$tot\" class=\"S3\">$tot</a></td>";	
	      	}else{
            print "<td align=\"center\" width=\"15\" class=\"sel\"><B>$tot</B></td>";
		}
	}
}	    
# End display page numbers

echo '	      
	</tr>
      </table></td>
	  <td colspan="3" align="right"><table width="100%" border="0" cellspacing="3" cellpadding="0">
        <tr>
          <td width="78%"><input name="submit" type="button" onClick="open_window(\'http://';
echo $url;
echo '\',\'demo\',\'\',\'450\',\'410\',\'false\');return false;"  value="View YouLoader Page!" class="button_spc">
          </td>
          <td width="11%" align="center">'; 
echo $button;
echo '</td>
          <td width="11%" align="right"><input type="submit" value="Add Video" name="add" class="button_std"></td>
        </tr>
      </table>	    
</td>
    </tr>
</table>
<div align="center"><a href="loginchk.php?mode=logout" style="color:white;">&raquo; LOGOUT</a></div>
</form>
</body>
</html>';
?>