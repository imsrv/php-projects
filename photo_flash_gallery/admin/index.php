<?
session_start();
?>
<html>
<head>
<?
	include "../head.php";
?>
	<script language="JavaScript" type="text/javascript" src="js/swfobject.js"></script>
</head>
<body marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" bottommargin="0" topmargin="0" scroll="no" style="overflow: none">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr>
	<td width="100%" height="100%" align="center">
<?
if ($_GET["detectflash"] != "false") {
?>
	<div id="flashcontent" class="gri11dark" align="center" style="font-family: Verdana; font-size: 11px"><b>You need to upgrade your Flash Player.</b><br/>Photo Flash Gallery requires Macromedia Flash, version 8 or greater. Please click <a href="http://www.adobe.com/products/flashplayer/" target="_blank" style="color: #FF0000" class="gri11dark"><strong>here</strong></a> to download.<br/>Or, if you're absolutely positive you have Flash 8 or greater, click <a href="?detectflash=false" style="color: #FF0000">here</a> to force the site to load.</div>
	<script type="text/javascript">
		// <![CDATA[
		var so = new SWFObject("admin.swf", "admin", "800", "600", "8", "#FFFFFF");
		so.addParam("salign", "lt");
		so.addParam("scale", "noscale");
		so.addParam("FlashVars", "ch=<?=MD5(session_id())?>");
		so.addParam("menu", "false");
		so.write("flashcontent");
		// ]]>
	</script>
<?
} else {
?>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="800" height="600" id="admin" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="admin.swf" />
<param name="menu" value="false" />
<param name="quality" value="high" />
<param name="FlashVars" value="ch=<?=MD5(session_id())?>" />
<param name="bgcolor" value="#ffffff" />
<embed src="admin.swf" quality="high" menu="false" bgcolor="#ffffff" width="800" height="600" name="admin" align="middle" FlashVars="ch=<?=MD5(session_id())?>" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
<?
}
?>
	</td>
</tr>
</table>
</body>
</html>