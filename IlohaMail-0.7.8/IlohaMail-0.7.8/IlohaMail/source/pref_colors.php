<?
/////////////////////////////////////////////////////////
//	
//	source/pref_colors.php
//
//	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//		This file is part of IlohaMail.
//		IlohaMail is free software released under the GPL 
//		license.  See enclosed file COPYING for details,
//		or see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	AUTHOR: Ryo Chijiiwa <ryo@ilohamail.org>
	FILE: source/pref_colors.php
	PURPOSE:
		Provide interface for customizing display colors.
	PRE-CONDITIONS:
		$user - Session ID
	COMMENTS:
		File include "include/write_sinc.inc" for storing preferences to back-end, and update
		per-session settings.
		
********************************************************/

include("../include/super2global.inc");
include("../include/header_main.inc");
	include("../lang/".$my_prefs["lang"]."prefs.inc");
	include("../lang/".$my_prefs["lang"]."pref_colors.inc");
	include("../conf/defaults.inc");
	
if (isset($user)){
	include("../include/pref_header.inc");
	
	if (isset($apply)) $update=true;
	if ((isset($update))||(isset($revert))){
		$my_colors=$init["my_colors"];
		if (isset($update)){
			reset($my_colors);
 			while (list($key, $value) = each ($my_colors)) {
			 	$my_colors[$key]=$$key;
			}
		}
		
		include("../include/save_colors.inc");
		
                /*
		$user_name=$loginID;
		$init["my_colors"]=$my_colors;
		
		$session = $user;
		include("../include/write_sinc.inc");
                */
	}
	if (isset($apply)){
		echo "<script language=\"JavaScript\">\n";
		echo "parent.location=\"index.php?session=$user\";";
		echo "</script>";
		echo "</body></html>";
		exit;
	}
	?>
		<p>
                    <? echo $pcStrings["0"]."  ".$pcStrings["0.1"]; ?>
                    <a href=cp.php?user=<?=$user;?> target=_blank>
                    <?=$pcStrings["0.2"]?></a><?=$pcStrings["0.3"]?>
		<form method="post" action="pref_colors.php">
		<input type="hidden" name="user" value="<?=$user?>">
		<table width="100%">
			<tr>
				<td><b><?=$pcStrings["1.0"]?></b></td><td></td><td></td><td></td>
			</tr>
			<tr>
				<td><?=$pcPortions[0]?><input type="text" name="tool_bg" value="<? echo $my_colors["tool_bg"]; ?>" size=7></td>
				<td><?=$pcPortions[1]?><input type="text" name="tool_link" value="<? echo $my_colors["tool_link"]; ?>" size=7></td>
				<td></td><td></td>
			</tr>
			<tr>
				<td><br><br></td><td></td><td></td><td></td>
			</tr>
			<tr>
				<td><b><?=$pcStrings["2.0"]?></b></td><td></td><td></td><td></td>
			</tr>
			<tr>
				<td><?=$pcPortions[0]?><input type="text" name="folder_bg" value="<? echo $my_colors["folder_bg"]; ?>" size=7></td>
				<td><?=$pcPortions[1]?><input type="text" name="folder_link" value="<? echo $my_colors["folder_link"]; ?>" size=7></td>
				<td></td>
			</tr>
			<tr>
				<td><br><br></td><td></td><td></td><td></td>
			</tr>
			<tr>
				<td><b><?=$pcStrings["3.0"]?></b></td><td></td><td></td><td></td>
			</tr>
			<tr>
				<td><?=$pcPortions[0]?><input type="text" name="main_bg" value="<? echo $my_colors["main_bg"]; ?>" size=7></td>
				<td><?=$pcPortions[1]?><input type="text" name="main_link" value="<? echo $my_colors["main_link"]; ?>" size=7></td>
				<td><?=$pcPortions[2]?><input type="text" name="main_text" value="<? echo $my_colors["main_text"]; ?>" size=7></td>
				<td><?=$pcPortions[3]?><input type="text" name="main_hilite" value="<? echo $my_colors["main_hilite"]; ?>" size=7></td>
			</tr>
			<tr>
				<td><br><br></td><td></td><td></td><td></td>
			</tr>
			<tr>
				<td><b><?=$pcStrings["4.0"]?></b></td><td></td><td></td><td></td>
			</tr>
			<tr>
				<td><?=$pcStrings["4.1"]?><input type="text" name="quotes" value="<? echo $my_colors["quotes"]; ?>" size=7></td>
				<td></td><td></td><td></td>
			</tr>
		</table>
			<input type="submit" name="update" value="<?=$prefsButtonStrings[0]?>">
			<input type="submit" name="apply" value="<?=$prefsButtonStrings[1]?>">
			<input type="submit" name="cancel" value="<?=$prefsButtonStrings[2]?>">
			<input type="submit" name="revert" value="<?=$prefsButtonStrings[3]?>">
		</form>
		
	<?

}else{
	echo "User unspecified.";
}
?>
</BODY></HTML>
