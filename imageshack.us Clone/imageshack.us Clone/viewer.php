<?php
$id = $_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><title>ImageShack - Hosting :: <? print("$id"); ?></title>


<link rel="stylesheet" href="viewer_elemei/style-def.css" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcuticon" href="favicon.ico"><style type="text/css">
body, p, td {color: #111111;}
.plusminus {padding: 1px; background-color: #F7F7F7; border: 1px solid #111111;}
input, textarea, select {
        font-family: Verdana, Arial;
        font-size: 11px;
        color: #111111;
        border: solid 1px;
        border-color: #DBDBDB;
        background-color: #F7F7F7;
}
</style> <script type="text/javascript">var actualWidth = 350;var actualHeight = 19;function scaleImg() {if (fitsInWindow())return;what = document.getElementById('thepic');if(what.width==tableWidth()) {what.width=actualWidth;what.height=actualHeight;displayWarning("none");}else{what.style.cursor = "pointer";what.width=tableWidth();what.height = (actualHeight/actualWidth) * what.width;displayWarning("block");}}function liveResize() {if (fitsInWindow())return;what = document.getElementById('thepic');if (what.width!=actualWidth) {what.width=tableWidth();what.height = (actualHeight/actualWidth) * what.width;displayWarning("block");}}function setImgWidth() {if (fitsInWindow())return;document.getElementById('thepic').width=tableWidth();displayWarning("block");}function fitsInWindow() {if (actualWidth<tableWidth()) {displayWarning("none");return true;}return false;}function tableWidth() {return windowWidth()-100;}function windowWidth() {if (navigator.appName=="Netscape")return window.innerWidth;return document.body.offsetWidth;}function displayWarning(how) {document.getElementById('scalewarning').style.display=how;}onresize=liveResize;</script>
<script type="text/javascript">function highlight(field){field.focus();field.select();}</script></head><body bgcolor="#f7f7f7"><div align="center">
<p>Learn more about the <b><a href="http://toolbar.imageshack.us/">ImageShack Toolbar</a></b> now!</p>
<p><a href="http://toolbar.imageshack.us/"><img src="viewer_elemei/toolbar_img2.png"></a></p>
</div>
<div id="scalewarning" style="display: none;" align="center">
This image has been scaled down to fit your computer screen. Click on it to show it in the original size.</div>
<p align="center">

<?php

include "config.php";
echo "<center>";
echo "<br>";
if ($_GET['id'])
{
	$id = $_GET['id'];
}
else
{
	die ("No ID Selected");
}

echo "<body bgcolor='#F2F2F3'>";
echo "<table border='0' bgcolor='white'>";
echo "<tr><td>";
echo "<img src='./$path" . $id . "'>";
echo "</td></tr>";
echo "</table>";
?>


&nbsp;</p>
<label>
<div align="center">
  <input name="textfield" type="text" value="<?print("". $domain ."/viewer.php?id= ". $id . "");  ?>" size="60" />
</div>
</label>
<br>
  <table class="table_decoration" align="center" border="0" cellpadding="5" cellspacing="0" width="720"><tbody><tr><td align="center"><input value="Free Image Hosting" onClick="window.location='<? echo("$domain"); ?>'" type="button">
          <form method="post" action="basic.php" enctype="multipart/form-data" onSubmit="disableme('butan')">
<input name="MAX_FILE_SIZE" value="3145728" type="hidden">Upload an image: <input name="refer" value="" type="hidden">
<input name="userfile" type="file" id="userfile" size="30"> 
<input name="upload" type="submit" id="butan" style="width: 100px;" value="host it!">
</form></td>
</tr><tr><td><table border="0" cellpadding="3" cellspacing="0"><tbody><tr><td valign="top"></td></tr></tbody></table></td></tr></tbody></table><br><div align="center"><a href="<? echo("$domain"); ?>">
<img src="viewer_elemei/imageshack.png" title="ImageShack Frog" alt="ImageShack Frog"></a></div>

</body></html>