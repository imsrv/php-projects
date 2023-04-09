<html>
<head>
<?
	include "head.php";
?>
	<script language="JavaScript" type="text/javascript" src="js/swfobject.js"></script>
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" bottommargin="0" topmargin="0" scroll="no" style="overflow: none">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr>
	<td width="100%" height="100%">
<?
if ($_GET["detectflash"] != "false") {
?>
	<div id="flashcontent" class="gri11dark" align="center" style="font-family: Verdana; font-size: 11px; width: 100%; height: 100%"><b>You need to upgrade your Flash Player.</b><br/>Photo Flash Gallery requires Macromedia Flash, version 8 or greater. Please click <a href="http://www.adobe.com/products/flashplayer/" target="_blank" style="color: #FF0000" class="gri11dark"><strong>here</strong></a> to download.<br/>Or, if you're absolutely positive you have Flash 8 or greater, click <a href="?detectflash=false" style="color: #FF0000">here</a> to force the site to load.</div>
	<script type="text/javascript">
		// <![CDATA[
		var so = new SWFObject("gallery.swf", "gallery", "100%", "100%", "8", "#FFFFFF");
		so.addParam("salign", "lt");
		so.addParam("scale", "noscale");
		so.addParam("menu", "true");
		so.write("flashcontent");
		// ]]>
	</script>
<?
} else {
?>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="100%" height="100%" id="gallery" align="left">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="gallery.swf" />
<param name="quality" value="high" />
<param name="menu" value="false" />
<param name="scale" value="noscale" />
<param name="salign" value="lt" />
<param name="bgcolor" value="#ffffff" />
<embed src="gallery.swf" menu="false" quality="high" scale="noscale" salign="lt" bgcolor="#ffffff" width="100%" height="100%" name="gallery" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
<?
}
?>
	</td>
</tr>
</table>
</body>
</html>