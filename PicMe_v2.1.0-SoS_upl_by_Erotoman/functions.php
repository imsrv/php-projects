<?php
/*
#
#	$Id: FUNCTIONS.PHP
#	Version 2.1.0
#
*/

// VOTES REMAINING
 function voteremain(){
 global $HTTP_COOKIE_VARS;
 $votesleft = $HTTP_COOKIE_VARS["votesleft"];
 if ($showvotes == "1") {
	$vleft = $maxvotes -$votesleft;
	}
 return $vleft;
}

// GD Library
function RatioResizeImgGD($src_file, $dest_file, $newWidth) {
	global 
	$gallerypath
	;
	// find the image size & type
	if(!function_exists('imagecreate')){return $src_file;}

	$imginfo = @getimagesize($src_file);
	switch($imginfo[2]) {
		case 1: $type = IMG_GIF; break;
		case 2: $type = IMG_JPG; break;
		case 3: $type = IMG_PNG; break;
		case 4: $type = IMG_WBMP; break;
		default: return $src_file; break;
	}
	
	switch($type) {
		case IMG_GIF:
			if(!function_exists('imagecreatefromgif')){return $src_file;}
			$srcImage = @imagecreatefromgif("$src_file");
			break;
		case IMG_JPG:
			if(!function_exists('imagecreatefromjpeg')){return $src_file;}
			$srcImage = @ImageCreateFromJpeg($src_file);
			break;
		case IMG_PNG:
			if(!function_exists('imagecreatefrompng')){return $src_file;}
			$srcImage = @imagecreatefrompng("$src_file");
			break;
		case IMG_WBMP:
			if(!function_exists('imagecreatefromwbmp')){return $src_file;}
			$srcImage = @imagecreatefromwbmp("$src_file");
			break;
		default: return $src_file;
	}
	
	if($srcImage){
		// height/width
		$srcWidth = $imginfo[0];
		$srcHeight = $imginfo[1];
		$ratioWidth = $srcWidth/$newWidth;
		$destWidth = $newWidth;
		$destHeight = $srcHeight / $ratioWidth;
		// resize
		$destImage = @imagecreate($destWidth, $destHeight);
		imagecopyresized($destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
		// create and save final picture
			switch($type){
			case IMG_GIF: @imagegif($destImage, "$dest_file"); break;
			case IMG_JPG: @imagejpeg($destImage, "$dest_file"); break;
			case IMG_PNG: @imagepng($destImage, "$dest_file"); break;
			case IMG_WBMP: @imagewbmp($destImage, "$dest_file"); break;
		}

		// free the memory
		@imagedestroy($srcImage);
		@imagedestroy($destImage);

		return $dest_file;
	}
	else
	{
		return $src_file;
	}
}

// ImageMagick
function RatioResizeImgImageMagick($src_file, $dest_file, $newwidth){
	global
		$gallerypath
	;
	// find the image size
	$imginfo = @getimagesize($src_file);
	if ($imginfo == NULL)
		return $src_file;
	
	// height/width
	$srcWidth = $imginfo[0];
	$srcHeight = $imginfo[1];

	$ratioWidth = $srcWidth/$newWidth;
	$ratioHeight = 0;
	$destWidth = $newWidth;
	$destHeight = $srcHeight / $ratioWidth;
	
	// resize
	exec("convert -quality 80 -antialias -sample \"".$destWidth."x".$destHeight."\" \"$src_file\" \"$dest_file\"");
	return $dest_file;
}

// GET USERS ONLINE
function getUsersOnline(){
	global $HTTP_SERVER_VARS; 
	// Set length of session to twenty minutes 
	define("SESSION_LENGTH", 5); 
	$userIP = $HTTP_SERVER_VARS["REMOTE_ADDR"]; 
	$timeMax = time() - (60 * SESSION_LENGTH); 
	$result = mysql_query("select count(*) from usersonline where unix_timestamp(dateAdded) >= '$timeMax' and userIP = '$userIP'"); 
	$recordExists = mysql_result($result, 0, 0) > 0 ? true : false; 
		if(!$recordExists) 
		{ 
			// Add a record for this user 
			@mysql_query("insert into usersonline(userIP) values('$userIP')"); 
		} 
	$query = ("select count(*) from usersonline where unix_timestamp(dateAdded) >= '$timeMax'");
	$numguests = mysql_query($query) or die("Select Failed!");
	$numguest = mysql_fetch_array($numguests);
	return $numguest[0];
}

// GET NUMBER OF PICS
function gettotpics(){
		$query = ("select count(*) from picuploads");
		$numpics1 = mysql_query($query) or die("Select Failed!");
		$numpics = mysql_fetch_array($numpics1);
		return $numpics[0];
}

// GET NUMBER OF COMMENTS
function comments(){
		$query = ("select count(*) from comments");
		$numcom1 = mysql_query($query) or die("Select Failed!");
		$numcom = mysql_fetch_array($numcom1);
		return $numcom[0];
}

// GENERATE PASSWORD
function generate() {
        $length ="6";              // the length of the password required
        $possible = '23456789' . 
                'abcdefghijkmnpqrstuvwxyz';
//            'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $str ="";
        while (strlen($str) < $length) {
        $str.=substr($possible, (rand() % strlen($possible)),1);
   }
         return($str);
}

// MAKE THE THUMBNAIL
function makethumb($file_name) {
	if($thumbType =="0") {  // GD
		 RatioResizeImgGD("$fullpathuploads/$file_name","$fullpaththumb/$file_name","$new_w");
	}
	if($thumbType == "1") { // MAGIC
		RatioResizeImgImageMagick("$fullpathuploads/$file_name","$fullpaththumb/$file_name","$new_w");
	}
}

// GET NUMBER OF USERS
function numusers(){
		$query = ("select count(*) from users");
		$numusers1 = mysql_query($query) or die("Select Failed!");
		$numusers = mysql_fetch_array($numusers1);
		return $numusers[0];
}

// GET USER COMMENTS
function getUcomments($picid){
	$ucomments= "
	<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n
	  <tbody>\n
	    <tr valign=\"top\">
		  <td width=\"100%\">\n
	";
	$sql = "select * from comments where pid ='$picid' ORDER BY id DESC LIMIT 20";  	
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 
		$user = $row["userid"];
		$text = $row["text"];		
		if($bg == "#fff8dc") { $bg = "#fffaf0";} else { $bg ="#fff8dc";}
		$ucomments = $ucomments ."		
		<b><a href=showprofile.php?name=$user>$user</a></b>\n
 		 <div class=\"hilite\">\n
			$text<hr>\n
		</div>\n";		
	}		
	
	$query = ("select count(*) from comments where pid ='$picid'");
	$num2 = mysql_query($query) or die("Select Failed!");
	$num = mysql_fetch_array($num2);	
	if($num[0] >0) {
		if($num[0] >$maxcomments) {
		$ucomments = $ucomments ."&nbsp;<a href=\"#\" onClick=\"MoreComments=window.open('$PHP_SELF?allcomments=on&id=$id','MoreComments','toolbar=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizeable=yes,width=400,height=400,left=20,top=20'); return false;\">more comments..</a></td>\n</tr></table>\n";
		} else {
				$ucomments = $ucomments ."</td>\n</tr></table>\n";
		}		
	} else { 
	$ucomments = "No comments have been submitted.";
	}
	return $ucomments;
}

// GET TOTAL PMs
function messages(){
		$query = ("select count(*) from messages");
		$mess1 = mysql_query($query) or die("Select Failed!");
		$messages = mysql_fetch_array($mess1);
		return $messages[0];
}

// NEWEST MEN
 function newmen(){
		$sql = "SELECT * FROM users WHERE sex='Male' ORDER BY updated DESC LIMIT 10";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $mname = $row["userid"];
	 $mid = $row["id"];
	 $tname=$tname."<li><a href=showprofile.php?name=$mname><font color=blue>$mname</a></font>";
}
	return $tname;
 }

// NEWEST FEMALES
function newfem(){
		$sql = "SELECT * FROM users WHERE sex='Female' ORDER BY updated DESC LIMIT 10";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $fname = $row["userid"];
	 $fid = $row["id"];
	 $ttname = $ttname ."<li><a href=showprofile.php?name=$fname><font color=red>$fname</a></font>";
		}
	return $ttname;
 }	

// TOP FEMALES
function topfem(){
		$sql = "SELECT * FROM picuploads WHERE catagory='2' ORDER BY points LIMIT 10";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $topf = $row["userid"];
	 $topfname = $topfname ."<li><a href=showprofile.php?name=$topf><font color=red>$topf</font></a>";
		}
	return $topfname;
 }
 
// TOP MALES
function topmen(){
		$sql = "SELECT * FROM picuploads WHERE catagory='1' ORDER BY points LIMIT 10";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $topm = $row["userid"];
	 $topmname = $topmname ."<li><a href=showprofile.php?name=$topm><font color=blue>$topm</font></a>";
		}
	return $topmname;
 }

// TOP 10 ALL
function topall(){
		$sql = "SELECT * FROM picuploads LIMIT 10";
		$sql_result = mysql_query($sql);
	while ($row = mysql_fetch_array($sql_result)) { 
	 $topa = $row["userid"];
	 $topaname = $topaname ."<li><a href=showprofile.php?name=$topa><font color=black>$topa</font></a>";
		}
	return $topaname;
 }
 
//  SUBMIT PHOTO INFO
function submitPhotoInfo($file_name,$title,$comment,$uname,$catagory) {
	$udate = date("Y-m-d H:i:s");
	$sql = "insert into picuploads values('','$file_name','$uname','$comment','$title','1','1','0','$udate',$catagory)"; // misc
	$sql_result = mysql_query($sql); 
}

// GET NUMBER OF VOTES
function gettotvotes(){
		$query = ("select SUM(votes) from picuploads");
		$how = mysql_query($query) or die("Select Failed!");
		$much = mysql_fetch_array($how);
echo $much[0];
}

// GET NUMBER OF POINTS
function gettotpoints(){
		$query = ("select SUM(points) from picuploads");
		$points = mysql_query($query) or die("Select Failed!");
		$pts = mysql_fetch_array($points);
echo $pts[0];
}

// GET FLAG AND COUNTRY LIST
function getFlagList($country){
	$d = dir(flags);
	$html = "<select name=country size=1>";
	while($entry = $d->read()){
		if($entry != "." && $entry != "..") {
			$short_entry = eregi_replace(".gif", "", $entry);
			$html .= "<option";
			if($short_entry != $country){
			$html .= ">";
			} else {
			$html .= " selected>";
			}
			$html .= $short_entry;
		}
	}
	$html .= "</select>";
	echo $html;
}
?>
