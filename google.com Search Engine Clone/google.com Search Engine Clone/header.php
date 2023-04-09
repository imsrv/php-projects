<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Endless Search [ Powered By EnDLeSs-4uM.CoM ]</title>
<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body>
<div align="center">
  <p>
    <script language="javascript">
function checkform (form) {
  if (form["query"].value == "") {
    alert("Please insert keyword(s) to search for");
    form["query"].focus();
    return false ; }
 return true; }
    </script>
  </p>
  <p>&nbsp;</p>
  <p><img src="images/logo.jpg"><br>
      </p>
</div>
<form name="googleFrm" method="get" action="search.php" onsubmit="return checkform(this);">
  <div align="center">
	<span class="white_bold_small"><p align="center"><b>Web</b><font size="-1">&nbsp;&nbsp;&nbsp;&nbsp;</font><a href="http://forum.endless-4um.com/index.php"><span style="text-decoration: none">Community</span></a><font size="-1">&nbsp;&nbsp;&nbsp;&nbsp;</font><a href="http://topsites.endless-4um.com/"><span style="text-decoration: none">Top Sites</span></a><font size="-1">&nbsp;&nbsp;&nbsp;&nbsp;</font><a href="http://theatre.endless-4um.com/"><span style="text-decoration: none">Theatre</span></a><br>
  </span>
    <input name="query" onfocus="this.value='';" type="text" id="query" size="60" value="Start searching here, then press Enter"> <br>
    &nbsp;<input name="www" type="hidden" id="www" value="true"><input type="submit" value="Endless Search"></p></div>
</form>