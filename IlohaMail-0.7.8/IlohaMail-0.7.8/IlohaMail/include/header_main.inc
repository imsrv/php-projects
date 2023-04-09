<?
/////////////////////////////////////////////////////////
//	
//	include/header_main.inc
//
//	(C)Copyright 2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	PURPOSE:
		Provide header and initialization functionality common to many pages.
		Including:
			1.  Display HTML header	
					(including BODY tag with colors set according to user prefs)
			2.  Read user preferences into $my_prefs and $my_colors arrays
	PRE-CONDITIONS:
		$user - Session ID
	COMMENTS:
		Reading preferences into array is actually done in "include/session_auth.inc"

********************************************************/
include_once("../include/nocache.inc");
include_once("../conf/conf.inc");
set_time_limit($MAX_EXEC_TIME);
?>
<HTML>
<HEAD>
<?
echo "<!-- \n";
echo "IlohaMail by Ryo Chijiiwa\n";
echo "Moo?\n";
echo "-->\n";
if (isset($user)){
	$sid=$user;

	include("../include/session_auth.inc");

	//over ride saved settings if changed
	if ((isset($int_lang))&&(strlen($int_lang) > 2)){
		$lang = $int_lang;
		include_once("../lang/".$lang."init.inc");
		if (isset($charset)){ 
			if ($supported_charsets[$charset]) $my_prefs["charset"] = $charset;
			else{
				$my_prefs["charset"] = $lang_charset;
				$charset = $lang_charset;
			}
		}else{
			$my_prefs["charset"] = $lang_charset;
		}
	}else{
		$lang = $my_prefs["lang"];
	}

	include("../lang/".$my_prefs["charset"].".inc");
	include("../include/ryosimap.inc");

	$linkc=$my_colors["main_link"];
	$bgc=$my_colors["main_bg"];
	$textc=$my_colors["main_text"];
	$hilitec=$my_colors["main_hilite"];

	?>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?=$my_prefs["charset"]?>">
		<STYLE type="text/css">
			<!--
				A:link, A:visited, A:active, A:hover { text-decoration: none }
			//-->
		</STYLE>
		<SCRIPT type="text/javascript" language="JavaScript1.2">
		function SelectAllMessages() {
		    for (var i = 0; i < document.messages.elements.length; i++) {
				if(document.messages.elements[i].type == 'checkbox') {
					document.messages.elements[i].checked = !(document.messages.elements[i].checked);
				}
		    }
		}
		</SCRIPT>
	</HEAD>
	<?
	echo '<BODY TEXT="'.$textc.'" BGCOLOR="'.$bgc.'" LINK="'.$linkc.'" ALINK="'.$linkc.'" VLINK="'.$linkc.'">';
}else{
	echo "<BODY>";
	echo "User unspecified:".$user;
	//echo "<script> parent.location=\"login.php\"; </script>";
	echo "</HTML></BODY>";
	exit;
}
flush();
?>