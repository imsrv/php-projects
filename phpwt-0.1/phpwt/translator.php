<?php
include("config.php");
include("net.inc.php");
include("html.inc.php");
include("trans.inc.php");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="default.css" />
</head>
<body>

<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >
if($_POST["translate"]) {
	echo "<center><img src='logo.jpg' border='0'></center><br />";
	echo "<center>by Paolo Ardoino [ paolo.ardoino@gmail.com ]</center>";
	echo "<div align='left'>";
        if($_FILES["sitemap"]["tmp_name"] != "") {
                $sitemap = file($_FILES["sitemap"]["tmp_name"]);
	}
	$lang = $_POST["lang"];
	$tlang = explode("|", $lang);
	if($tlang[0] != "en") {
		echo "<b>Translating pages to English. Pleas wait...</b><br />";
		for($i = 0; $i < sizeof($sitemap); $i++) {
			if(trim($sitemap[$i]) != "") {
				echo "<b>Translating <font color='#0000ff'>".trim($sitemap[$i])."</font>...</b> ";
				getTranslation(trim($sitemap[$i]), $tlang[0], "en", trim($sitemap[$i]));
				echo "<font color='#00aa00'><b>Done.</b></font><br />";
			}
		}
		echo "<font color='#00aa00'><b>Done.</b></font><br /><br />";
		echo "<b>Rebuilding English tree...</b><br />";
		rebuildLinks("en");
		echo "<font color='#00aa00'><b>Done.</b></font><br /><br />";
		translateEn2All();
	} else {
		translateEn2All($sitemap);
	}
	echo "<b>Rebuilding German tree...</b><br />";
	rebuildLinks("de");
	echo "<font color='#00aa00'><b>Done.</b></font><br /><br />";
	echo "<b>Rebuilding Italian tree...</b><br />";
	rebuildLinks("it");
	echo "<font color='#00aa00'><b>Done.</b></font><br /><br />";
	echo "<b>Rebuilding French tree...</b><br />";
	rebuildLinks("fr");
	echo "<font color='#00aa00'><b>Done.</b></font><br /><br />";
	echo "<b>Rebuilding Spanish tree...</b><br />";
	rebuildLinks("es");
	echo "<font color='#00aa00'><b>Done.</b></font><br /><br />";
	echo "<b>Rebuilding Portuguese tree...</b><br />";
	rebuildLinks("pt");
	echo "<font color='#00aa00'><b>Done.</b></font><br /><br />";
	echo "<b>Rebuilding Japanese tree...</b><br />";
	rebuildLinks("ja");
	echo "<font color='#00aa00'><b>Done.</b></font><br />";
	echo "</div>";
} else {
?>
	<center><img src='logo.jpg' border='0'></center><br />
	<center>by Paolo Ardoino [ paolo.ardoino@gmail.com ]</center>
	<form enctype="multipart/form-data" method="post" action="translator.php">
	<table align="center">
	<tr><td><b>Select the main language of your site</b></td>
	<td><select name="lang">
	<?php 
		foreach($langs as $l1 => $l2) {
			echo "<option value='".$l2."'>".$l1;
		}
	?>
	</select></td></tr><br />
	<tr><td><b>File containing your website's sitemap</b></td>
	<td><input type="file" name="sitemap" size="23"></td>
	</tr><br />
	<tr><td colspan="2" align="center">
	<input type="submit" name="translate" value="Translate"></td></tr>
	</table>
	</form>
<?php } ?>
</body>
</html>
