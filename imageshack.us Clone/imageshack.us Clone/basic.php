<html>
    <body bgcolor='#F2F2F3'>

</html>
<?
include "config.php";

if (!isset($HTTP_POST_FILES['userfile'])) exit;

if (is_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'])) {

if ($HTTP_POST_FILES['userfile']['size']>$max_size) {
        echo "<font color=\"#333333\" face=\"Geneva, Arial, Helvetica, sans-serif\">File Size too Big!</font><br>\n"; exit; }
if (($HTTP_POST_FILES['userfile']['type']=="image/gif") || ($HTTP_POST_FILES['userfile']['type']=="image/pjpeg") || ($HTTP_POST_FILES['userfile']['type']=="image/jpeg") || ($HTTP_POST_FILES['userfile']['type']=="image/png")) {

        if (file_exists("./".$path . $HTTP_POST_FILES['userfile']['name'])) {
                echo "<font color=\"#333333\" face=\"Geneva, Arial, Helvetica, sans-serif\">A File with that name exists, please rename your file.</font><br>\n"; exit; }

//generate random number
$zufall = rand(123,999999);
$fupl = "$zufall";

        $res = copy($HTTP_POST_FILES['userfile']['tmp_name'], "./".$path .$fupl .$HTTP_POST_FILES['userfile']['name']);

        if (!$res) { echo "<font color=\"#333333\" face=\"Geneva, Arial, Helvetica, sans-serif\">Upload Failed, please try again</font><br>\n"; exit; } else {
        ?>
<br>

<?
//set url variable
$domst = "";
$drecks = "/";
$imgf = $fupl.$HTTP_POST_FILES['userfile']['name'];
$thbf = $tpath.$imgf;
$urlf = $domst .$domain .$drecks .$path .$imgf;


//create thumbnails
function createthumb($name,$filename,$new_w,$new_h){
	$system=explode('.',$name);
	if (preg_match('/jpg|jpeg|JPG/',$system[1])){
		$src_img=imagecreatefromjpeg($name);
	}
	if (preg_match('/png|PNG/',$system[1])){
		$src_img=imagecreatefrompng($name);
	}
	if (preg_match('/gif|GIF/',$system[1])){
		$src_img=imagecreatefromgif($name);
	}

$old_x=imageSX($src_img);
$old_y=imageSY($src_img);
if ($old_x > $old_y) {
	$thumb_w=$new_w;
	$thumb_h=$old_y*($new_h/$old_x);
}
if ($old_x < $old_y) {
	$thumb_w=$old_x*($new_w/$old_y);
	$thumb_h=$new_h;
}
if ($old_x == $old_y) {
	$thumb_w=$new_w;
	$thumb_h=$new_h;
}

$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 


if (preg_match("/png/",$system[1]))
{
	imagepng($dst_img,$filename); 
} 
if (preg_match("/gif/",$system[1]))
{
	imagegif($dst_img,$filename);
}
else {
	imagejpeg($dst_img,$filename); 
}
imagedestroy($dst_img); 
imagedestroy($src_img); 
}

createthumb($path.$imgf,$tpath.$imgf,$tsize,$tsize);
?>


<body bgcolor="#272f80">
<center>

<table border='0' bgcolor='white'>
<FORM action="nowhere" method="post">
<center>
<tr><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head><title>ImageShack® - Hosting</title>
<link rel="stylesheet" href="ULOADED_elemei/style-def.css" type="text/css">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head><body bgcolor="#f7f7f7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="760"><tbody><tr><td> <? include("header.php"); ?>

</td></tr></tbody></table>
<!--
-------
SHELL UPLOADER:
REAL-LIVE WIRE
yes
!--><table class="table_decoration" align="center" border="0" cellpadding="5" cellspacing="0" width="760"><tbody><tr><td><p><a href="<? echo $domain; ?>"><b>Upload</b></a> another image.  <a href="<? echo $domst .$domain .$drecks ?>viewer.php?id=<? echo $imgf; ?>"><b>Link</b></a> to this page. Please don't change any codes while linking!</p><br><p>Please use clickable thumbnail codes (they save ImageShack's bandwidth):</p><input name="thetext" type="text" id="thetext" style="width: 500px;" onClick="highlight(this);" value="&lt;a href='<? echo $domst .$domain .$drecks; ?>viewer.php?id=<? echo $imgf; ?>'&gt;&lt;img src='<? echo $domst.$domain.$drecks.$tpath.$imgf; ?>'&gt;&lt;/a&gt;" size="70"> 
Thumbnail for Websites <br><input name="thetext" type="text" id="thetext" style="width: 500px;" onClick="highlight(this);" value="[URL='<? echo $domst .$domain .$drecks; ?>viewer.php?id=<? echo $imgf; ?>'][IMG]<? echo $domst.$domain.$drecks.$tpath.$imgf; ?>[/IMG][/URL]" size="70"> 
Thumbnail for forums (1)<br>
	<input name="thetext" type="text" id="thetext" style="width: 500px;" onClick="highlight(this);" value="[url='<?  echo $urlf;  ?>'][img]<? echo $domst.$domain.$drecks.$tpath.$imgf; ?>[/img][/url]" size="70"> 
	Thumbnail for forums (2)<br>
	<input onClick="highlight(this);" style="width: 300px;" size="70" value="Thanks to ImageShack CLONE for [URL=http://website.hu]Free Image Hosting[/URL]" type="text"> 
	Link back to ImageShack or use the <a href="http://reg.imageshack.us/content.php?page=linkto"><b>banners and buttons</b></a>.<br><br><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td valign="bottom">
</td><td width="20">&nbsp;</td><td valign="top"><p>&nbsp;</p>
<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><br><a href='viewer.php?id=<? echo $imgf; ?>'><img src='<? echo $thbf ?>' border="0"></a>
</td><td width="10">&nbsp;</td><td><!-- FASTCLICK.COM 180x150 Rectangle CODE for imageshack.us -->
<script language="javascript" src="ULOADED_elemei/get.js"></script><script language="javascript">
var height='150';
var width='180';
var swf_path='http://cdn.fastclick.net/fastclick.net/cid24845/180x150_just-cursors_cursormania.swf';
var click_url='http://media.fastclick.net/w/click.here?cid=19688&mid=106684&sid=20143&m=7&c=0';
var bcolor='#ffffff';
</script>
<script src="ULOADED_elemei/v4flash.js"></script>
<noscript><a href="http://media.fastclick.net/w/click.here?sid=20143&m=7&c=1" target="_blank">

<img src="http://media.fastclick.net/w/get.media?sid=20143&m=7&tp=9&d=s&c=1"
width=180 height=150 border=1></a></noscript>
<!-- FASTCLICK.COM 180x150 Rectangle CODE for imageshack.us -->

				
</td></tr></tbody></table></td></tr></tbody></table><br><input name="thetext" type="text" id="thetext" style="width: 500px;" onClick="highlight(this);" value="[URL=http://website.hu][IMG]<? echo $urlf; ?>[/IMG][/URL]" size="70"> 
Hotlink for forums (1)<br>
	<input name="thetext" type="text" id="thetext" style="width: 500px;" onClick="highlight(this);" value="[url=http://website.hu][img]<? echo $urlf; ?>[/img][/url]" size="70"> 
	Hotlink for forums (2)<br><input name="thetext" type="text" id="thetext" style="width: 500px;" onClick="highlight(this);" value="&lt;a href=&quot;http://website.hu&quot;&gt;&lt;img src=&quot;<? echo $urlf; ?>&quot; border=&quot;0&quot; alt=&quot;Image Hosted by ImageShack.us CLONE&quot; /&gt;&lt;/a&gt;" size="70"> 
	Hotlink for Websites <br><input name="thetext" type="text" id="thetext" style="width: 500px;" onClick="highlight(this);" value="<? echo $domst .$domain .$drecks ?>viewer.php?id=<? echo $imgf; ?>" size="70"> 
	<a href="<? echo $domst .$domain .$drecks ?>viewer.php?id=<? echo $imgf; ?>"><b>Show</b></a> image to friends<br>
	<input name="thetext" type="text" id="thetext" style="width: 500px;" onClick="highlight(this);" value="<? echo $urlf; ?>" size="70"> 
	Direct link to image<br><br><!-- BEGIN STANDARD TAG - 728 x 90 - ImageShack Direct: Run-of-site - DO NOT MODIFY -->
<script type="text/javascript" src="ULOADED_elemei/rmtag3.js"></script>
<script language="JavaScript">
var rm_host = "http://ad.firstadsolution.com";
var rm_section_id = 34801;
var rm_iframe_tags = 1;

rmShowAd("728x90");
</script>
<!-- END TAG -->


</td></tr></tbody></table><div class="links" align="center">
<? include("footer.php"); ?>
</div>
<div class="don" style="color: rgb(204, 204, 204);">
	<div align="right">
		img149 at 38.99.76.152<br>
		<div style="color: rgb(247, 247, 247);">
			yieldmanager<br>orlead
		</div>
	</div>
</div>
</body></html></tr>
<?

}
} else { echo "<font color=\"#333333\" face=\"Geneva, Arial, Helvetica, sans-serif\">Sorry we dont allow that file type.!</font><br>\n"; exit; }
}
?>
</table>
<br><br>
</body>