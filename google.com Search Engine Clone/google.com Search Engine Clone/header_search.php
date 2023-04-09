<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Endless Search [ Powered By EnDLeSs-4uM.CoM ]</title>
<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body>
<script language="javascript">
function checkform (form) {
  if (form["query"].value == "") {
    alert("Please insert keyword(s) to search for");
    form["query"].focus();
    return false ; }
 return true; }
</script>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="250"><a href="<?php echo $yourWebsite;?>"><img src="images/logo_sm.jpg" border="0"></a></td>
    <td><form name="googleFrm" method="get" action="search.php" onsubmit="return checkform(this);">
      <table width="100%"  border="0" cellspacing="0" cellpadding="10">
        <tr>
          <td><span class="white_bold_small"><b>Web</b><font size="-1">&nbsp;&nbsp;&nbsp;&nbsp;</font><a href="http://forum.endless-4um.com/index.php"><span style="text-decoration: none;">Community</span></a><font size="-1">&nbsp;&nbsp;&nbsp;&nbsp;</font><a href="http://topsites.endless-4um.com/"><span style="text-decoration: none;">Top 
			Sites</span></a><font size="-1">&nbsp;&nbsp;&nbsp;&nbsp;</font><a href="http://theatre.endless-4um.com/"><span style="text-decoration: none;">Theatre</span></a></span><br>
            <input name="query" type="text" id="query" value="<?php echo $_GET['query'];?>" size="40">
              <input type="submit" value="Search Again">
              <input name="www" type="hidden" id="www" value="true">
              </td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="1" colspan="4" class="td_search_color"></td>
  </tr>
  <tr class="td_search_color">
    <td width="10" bgcolor="#e5ecf9">&nbsp;</td>
    <td height="25" bgcolor="#e5ecf9"><strong>Search Results</strong></td>
    <td height="25" bgcolor="#e5ecf9"><div align="right">Results <?php echo $begin;?> 
		- <?php echo $end;?> of about <?php echo $total;?> results</i> for <i><?php echo $query;?></i></div></td>
    <td width="10" bgcolor="#e5ecf9">&nbsp;</td>
  </tr>
</table><br>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>