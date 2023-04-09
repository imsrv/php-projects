<?
session_start ();
if (!isset($urlpage)) $urlpage='';
include($urlpage."config.php");
$today = date("D, j M Y g:i a");
?>
<html>
<head>
	<title><?=$siteTitle?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="<?=$urlpage?>styles_adm.css" rel="stylesheet" type="text/css">
	<script language="JavaScript" type="text/javascript" src="<?=$urlpage?>js/imageroller.php?urladdress=<?=$urladdress?>"></script>
</head>
<body bgcolor="<?=$siteBackground?>" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
<tr>
	<td width="22" bgcolor="#51BD39" valign="top"><img src="<?=$urlpage?>images/interface/bkleft.gif" width="22" height="174" border="0" usemap="#left"><map name="left"><area alt="BUYFLASHMODULES.com" coords="1,0,23,157" href="http://www.buyflashmodules.com" target="_blank"></map></td>
	<td background="<?=$urlpage?>images/interface/bkleftgray.gif">&nbsp;</td>
	<td width="4" bgcolor="#ECECEC"></td>
	<!-- content -->
	<td width="759" valign="middle">
	<table width="780" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="184" height="123" rowspan="4"><img border="0" src="<?=$urlpage?>images/interface/back1.gif" width="184" height="123"></td>
		<td width="216" height="55" colspan="3"><img border="0" src="<?=$urlpage?>images/interface/back2.gif" width="216" height="55"></td>
		<td width="380" height="55" background="<?=$urlpage?>images/interface/back3.gif" class="text" align="right" style="padding-right:7px">
		<?
		if(session_is_registered("auth")) {
			echo '
			<strong>'.$auth["username"].'</strong> logged in';
		}
		?>
		</td>
	</tr>
	<tr>
		<td width="216" height="35" colspan="3"><img border="0" src="<?=$urlpage?>images/interface/back4.gif" width="216" height="35"></td>
		<td width="380" height="35" background="<?=$urlpage?>images/interface/back5.gif" align="right" style="padding-top:7px;padding-right:7px" class="time11" valign="top"><?=$today;?></td>
	</tr>
	<tr>
		<td width="76" height="19"><a href="<?=$urladdress?>/admin/" onmouseover="cimg('back6',0)" onmouseout="cimg('back6',1)"><img border="0" src="<?=$urlpage?>images/interface/back6.gif" width="76" height="19" name="back6"></a></td>
		<td width="70" height="19"><a href="<?=$urlpage?>adminsetup.php" onmouseover="cimg('back7',0)" onmouseout="cimg('back7',1)"><img border="0" src="<?=$urlpage?>images/interface/back7.gif" width="70" height="19" name="back7"></a></td>
		<td width="70" height="19"><a href="<?=$urlpage?>logout.php" onmouseover="cimg('back8',0)" onmouseout="cimg('back8',1)"><img border="0" src="<?=$urlpage?>images/interface/back8.gif" width="70" height="19" name="back8"></a></td>
		<td width="380" height="19"><img border="0" src="<?=$urlpage?>images/interface/back9.gif" width="380" height="19"></td>
	</tr>
	<tr>
		<td width="216" height="14" colspan="3"><img border="0" src="<?=$urlpage?>images/interface/back10.gif" width="216" height="14"></td>
		<td width="380" height="14"><img border="0" src="<?=$urlpage?>images/interface/back11.gif" width="380" height="14"></td>
	</tr>
	<tr>
		<td width="780" height="100%" colspan="5" valign="top" style="padding-top:15px">