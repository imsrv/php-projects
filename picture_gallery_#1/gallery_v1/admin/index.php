<?
if (!ini_get('register_globals')) 
   {
       $types_to_register = array('GET','POST','COOKIE','SESSION','SERVER');
       foreach ($types_to_register as $type)
       {
           if (@count(${'HTTP_' . $type . '_VARS'}) > 0)
           {
               extract(${'HTTP_' . $type . '_VARS'}, EXTR_OVERWRITE);
           }
       }
   }

session_start();
if(session_is_registered("auth")){
	header("Location: gallery/index.php");die;
}
include ("config.php");
?>
<html>
<head>
<title><?=$siteTitle?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="styles_adm.css" rel="stylesheet" type="text/css">
	<script language="JavaScript" type="text/javascript" src="js/imageroller.js"></script>
</head>
<body bgcolor="<?=$siteBackground?>" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr>
	<td width="22" bgcolor="#51BD39" valign="top"><img src="images/interface/bkleft.gif" width="22" height="174" border="0"></td>
	<td background="images/interface/bkleftgray.gif">&nbsp;</td>
	<td width="4" bgcolor="#ECECEC"></td>
	<!-- content -->
	<td width="759" valign="middle">
	<table border="0" cellpadding="0" cellspacing="0" width="759" height="120">
	<tr>
		<td bgcolor="#51BD39" height="3"></td>
	</tr>
	<form action="authentific.php" method="post">
    <tr>
    	<td width="100%" height="120" border="0">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" height="100%">
        <tr>
			<td width="190" align="center" valign="middle"><img src="images/interface/logo.gif" width="172" height="112" border="0"></td>
			<td align="center">
			<table cellpadding="0" cellspacing="0" border="0" width="150" height="80">
            <tr>
            	<td class="textblack11" valign="middle" align="center"><strong>Username:</strong>&nbsp;&nbsp;</td>
				<td class="text" align="center"><input name="username" type="Text" maxlength="20" class="field" size="13"></td>
            </tr>
			<tr>
				<td class="textblack11" valign="middle" align="center">&nbsp;<strong>Password:</strong>&nbsp;&nbsp;</td>
				<td class="text" align="center"><input name="password" type="password" maxlength="10" class="field" size="13"></td>
			</tr>
			<tr>
				<td colspan="2" align="right"><input type="image" src="images/interface/buttonlogin.gif" width="67" height="21" border="0" name="buttonlogin" onmouseover="cimg('buttonlogin',0)" onmouseout="cimg('buttonlogin',1)"></td>
			</tr>
            </table>
			</td>
			<td width="190"><img src="images/pixel.gif" width="1" height="1" border="0"></td>
		</tr>
		</table>
		</td>
    </tr>
	</form>
	<tr>
		<td bgcolor="#000000" height="3"></td>
	</tr>
    </table>
	</td>
	<!-- end content -->
	<td background="images/interface/bkrightgray.gif">&nbsp;</td>
	<td width="4" bgcolor="#FFFFFF"></td>
	<td width="22" bgcolor="#B6B6B6"></td>
</tr>
</table>
</body>
</html>