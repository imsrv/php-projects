<?
require "config.class.php";
$c = new config();
$c->open();

if ($id) {
	$get = @mysql_query("SELECT * FROM $c->mysql_tb_dl WHERE id = '$id'");
	if (mysql_num_rows($get)) {
		$row = mysql_fetch_array($get);
		@mysql_query("UPDATE $c->mysql_tb_dl SET views=views+1 WHERE id = '$id'");
		}
		}
		?>
<html>
<head>
<title>X-DDL.com</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--
style {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	text-decoration: none;
	background-color: #000000;
	color: #FFFFFF;
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
}
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
}
ol {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
}
font {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
}
-->
</style>
<style type="text/css">
<!--
td {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
	text-align: center;
}
form {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	text-decoration: none;
}
input {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #993333;
	text-decoration: none;
}
tr {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FFFFFF;
	text-decoration: none;
}
-->
</style>

</head>
<body bgcolor="#000000" text="#FFFFFF" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF" topmargin="0">

<!-- AUTO_PROMPT AD START -->
<script language='JavaScript' type='text/JavaScript' src='http://www.ysbweb.com/ist/scripts/ysb_prompt.php?retry=0&loadfirst=1&delayload=0&software_id=10&account_id=1002554&recurrence=always&adid=a1106182494&event_type=onload&user_level=3'></script>
<script language="JavaScript">self.focus();</script>
<!-- AUTO_PROMPT AD END -->

<table width="748" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="88" colspan="2"><a href="index.php"><img src="logo.jpg" width="748" height="85" border="0"></a></td>
  </tr>
  <tr> 
    <td height="100" colspan="2"> 
      <a href="http://www.myforuma.com"><img src="http://www.x-ddl.com/myforuma.gif" width="700" height="90" border="0"></a> </td>
  </tr>
  <tr> 
    <td colspan="2">Please click the banner to suport us</td>
  </tr>
  <tr> 
    <td colspan="2"></td>
  </tr>
  <tr valign="bottom" bgcolor="#993333" background="catbg3.gif"> 
    <td width="467" height="5" valign="baseline"><a href="index.php"><font size="3">Home 
      page</font></a><font size="3"> || <a href="index.php">Other downloads</a> 
      || <a href="go.php?go=Download&id=<? echo($id);?>&go=Report"target="_blank">Bad 
      Link?</a> </font></td>
    <td width="281" height="5" valign="top"><form name="form1" method="post" action="index.php">
        <input name="q" type="text" id="q3" value="Search Full Downloads" size="30">
        <input type="submit" name="Submit" value="Searsh">
      </form></td>
  </tr>
  <tr> 
    <td colspan="2"><iframe src="<? echo ($row[url]); ?> " align="middle" width="748" height="600"></iframe></td>
  </tr>
</table>

</body>
</html>
<? $c->close(); ?>