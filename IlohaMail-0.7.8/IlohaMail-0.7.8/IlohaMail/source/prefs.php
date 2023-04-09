<?
/////////////////////////////////////////////////////////
//	
//	source/prefs.php
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
	FILE: source/prefs.php
	PURPOSE:
		Provide interface for setting general options.
		Store settings to back-end and update per-session settings by including include/write_sinc.inc.
	PRE-CONDITIONS:
		$user - Session ID

********************************************************/

	include("../include/super2global.inc");

	if (isset($int_lang)){
		$lang = $int_lang;
	}else{
		$lang = $my_prefs["lang"];
	}
	include("../include/header_main.inc");
	include("../include/langs.inc");
	include("../include/icl.inc");
		
	include("../conf/defaults.inc");
	include("../lang/".$lang."prefs.inc");

	include("../include/pref_header.inc");
    
    if ($new_user){
        echo "<br><table bgcolor=\"".$my_colors["main_hilite"]."\"><tr><td>";
        echo $prefs_new_user;
        echo "</td></tr></table>";
    }
    
	if (isset($apply)) $update=true;
	if ((isset($update))||(isset($revert))){
		//check rootdir
		if ($rootdir=="-") $rootdir = $rootdir_other;
		
		//initialize $my_prefs
		$my_prefs=$init["my_prefs"];
		if (isset($update)){
			reset($my_prefs);
 			while (list($key, $value) = each ($my_prefs)) {
			 	$my_prefs[$key]=$$key;
			}
		}
		
		//save prefs to backend
		include("../include/save_prefs.inc");
		
        if (!empty($error)) echo "<p>".$error."<br>";
        
	}
    
	if (isset($apply)){
		echo "<script language=\"JavaScript\">\n";
		echo "parent.location=\"index.php?session=$user&show_page=prefs\";";
		echo "</script>";
		echo "</body></html>";
		exit;
	}

	$lang=$my_prefs["lang"];
	$langOptions="";
	while (list($key, $val)=each($languages)) 
		$langOptions.="<option value=\"$key\"".($my_prefs["lang"]==$key?" SELECTED":"").">$val\n";
	$charsetOptions="";
	while (list($key, $val)=each($charsets))
		$charsetOptions.="<option value=\"$key\"".($my_prefs["charset"]==$key?" SELECTED":"").">$val\n";
	$tzOptions="";
	for ($i = -12; $i <= 12; $i++)
		$tzOptions.="<option value=\"$i\"".($my_prefs["timezone"]==$i?"SELECTED":"").">$i\n";
		
	$conn=iil_Connect($host, $loginID, $password, $AUTH_MODE);
	if ($conn){
		$mailboxes=iil_C_ListMailboxes($conn, $my_prefs["rootdir"], "*");
		sort($mailboxes);
		iil_Close($conn);
	}
	?>
		<form method="post" action="prefs.php">
		<input type="hidden" name="user" value="<?=$user?>">
		<table width="100%">
			<tr valign=top>
			<td width="50%">
                <table border="0" bgcolor="<?=$my_colors["main_hilite"]?>" width="100%">
                <tr><td><b><?=$prefsStrings["0.0"]?></b></td></tr>
                <tr><td><table bgcolor="<?=$my_colors["main_bg"]?>" width="100%"><tr><td>
				<?=$prefsStrings["0.1"]?><input type=text name="user_name" value="<? echo $my_prefs["user_name"]; ?>">
				<br><?=$prefsStrings["0.2"]?><input type=text name="email_address" value="<? echo $my_prefs["email_address"]; ?>">
				</td></tr></table>
                </td></tr></table>
			</td>
			<td width="50%">
                <table border="0" bgcolor="<?=$my_colors["main_hilite"]?>" width="100%">
                <tr><td><b><?=$prefsStrings["1.0"]?></b></td></tr>
                <tr><td><table bgcolor="<?=$my_colors["main_bg"]?>" width="100%"><tr><td>
                    <?=$prefsStrings["1.1"]?><select name="int_lang"><? echo $langOptions; ?></select>
                    <br><?=$prefsStrings["1.2"]?><select name="charset"><? echo $charsetOptions; ?></select>
                    <br><?=$prefsStrings["1.3"]?><select name="timezone"><? echo $tzOptions; ?></select>
				</td></tr></table>
                </td></tr></table>
			</td>
			</tr>
			<tr valign=top>
			<td width="50%">
                <table border="0" bgcolor="<?=$my_colors["main_hilite"]?>" width="100%">
                <tr><td><b><?=$prefsStrings["2.0"]?></b></td></tr>
                <tr><td><table bgcolor="<?=$my_colors["main_bg"]?>" width="100%"><tr><td>

				<?=$prefsStrings["2.1"]?><input type=text name="view_max" value="<? echo $my_prefs["view_max"]; ?>" size=3>
					<?=$prefsStrings["2.2"]?>
				<p><input type=checkbox name="show_size" value=1 <? echo ($my_prefs["show_size"]==1?"CHECKED":""); ?>>
					<?=$prefsStrings["2.3"]?>
				<p><?=$prefsStrings["2.4"]?><select name="sort_field">
					<?
					DefaultOptions($sort_fields, $my_prefs["sort_field"]);
					?>
					</select><?=$prefsStrings["2.5"]?>
				<br><?=$prefsStrings["2.6"]?><select name="sort_order">
					<?
					DefaultOptions($sort_orders, $my_prefs["sort_order"]);
					?>
					</select><?=$prefsStrings["2.7"]?>
                <?
                if ($ICL_CAPABILITY["folders"]){
                ?>
				<p><input type=checkbox name="list_folders" value=1 <? echo ($my_prefs["list_folders"]==1?"CHECKED":""); ?>>
					<?=$prefsStrings["2.8"]?>
                <?
                }
                ?>
				</td></tr></table>
                </td></tr></table>

			</td>
			<td width="50%">
                <?
                if ($ICL_CAPABILITY["folders"]){
                ?>
                <table border="0" bgcolor="<?=$my_colors["main_hilite"]?>">
                <tr><td><b><?=$prefsStrings["3.0"]?></b></td></tr>
                <tr><td><table bgcolor="<?=$my_colors["main_bg"]?>" width="100%"><tr><td>

				<input type=checkbox name="save_sent" value=1 <? echo ($my_prefs["save_sent"]==1?"CHECKED":""); ?>>
					<?=$prefsStrings["3.1"]?>
				<br><?=$prefsStrings["3.2"]?>
					<select name="sent_box_name">
					<option value="">
					<?
						FolderOptions2($mailboxes, $my_prefs["sent_box_name"]);
					?>
					</select><?=$prefsStrings["3.3"]?>
				<p><?=$prefsStrings["3.5"]?>
					<select name="trash_name">
					<option value="">
					<?
						FolderOptions2($mailboxes, $my_prefs["trash_name"]);
					?>
					</select><?=$prefsStrings["3.6"]?>
				<br><input type=checkbox name="delete_trash" value=1 <? echo ($my_prefs["delete_trash"]==1?"CHECKED":""); ?>>
					<?=$prefsStrings["3.4"]?>
				<p><?=$prefsStrings["3.7"]?>
					<select name="rootdir">
					<option value="">
					<option value="-"><?=$prefsStrings["3.8"]?>
					<?
						FolderOptions2($mailboxes, $my_prefs["rootdir"]);
					?>
					</select>
					<br><?=$prefsStrings["3.8"]?>:<input type="text" name="rootdir_other" value="<?=$rootdir_other?>">

				</td></tr></table>
                </td></tr></table>
                <?
                }
                ?>
			</td>
			</tr>
			<tr valign=top>
			<td width="50%">
                <table border="0" bgcolor="<?=$my_colors["main_hilite"]?>" width="100%">
                <tr><td><b><?=$prefsStrings["4.0"]?></b></td></tr>
                <tr><td>
				<table bgcolor="<?=$my_colors["main_bg"]?>" width="100%"><tr><td>

				<input type=checkbox name="view_inside" value=1 <? echo ($my_prefs["view_inside"]==1?"CHECKED":""); ?>>
					<?=$prefsStrings["4.1"]?>

				<p><input type=checkbox name="html_in_frame" value=1 <? echo ($my_prefs["html_in_frame"]==1?"CHECKED":""); ?>>
					<?=$prefsStrings["4.5"]?>
				<br><input type=checkbox name="show_images_inline" value=1 <? echo ($my_prefs["show_images_inline"]==1?"CHECKED":""); ?>>
					<?=$prefsStrings["4.6"]?>

				<p><input type=checkbox name="colorize_quotes" value=1 <? echo ($my_prefs["colorize_quotes"]==1?"CHECKED":""); ?>>
					<?=$prefsStrings["4.2"]?>
				<br><input type=checkbox name="detect_links" value=1 <? echo ($my_prefs["detect_links"]==1?"CHECKED":""); ?>>
					<?=$prefsStrings["4.4"]?><br><font size=-1><?=$prefsStrings["4.3"]?></font>

				</td></tr></table>
                </td></tr></table>
			</td>
			<td width="50%">
                <table border="0" bgcolor="<?=$my_colors["main_hilite"]?>" width="100%">
                <tr><td><b><?=$prefsStrings["5.0"]?></b></td></tr>
                <tr><td><table bgcolor="<?=$my_colors["main_bg"]?>" width="100%"><tr><td>

				<textarea name="signature1" rows=5 cols=30><? echo $my_prefs["signature1"]; ?></textarea>
				<br><input type=checkbox name="show_sig1" value=1 <? echo ($my_prefs["show_sig1"]==1?"CHECKED":""); ?>>
					<?=$prefsStrings["5.1"]?>
				<br><font size=-1><?=$prefsStrings["5.2"]?></font>

				</td></tr></table>
                </td></tr></table>
			</td>
			</tr>
		</table>
            <p>
            <!--
			<input type="submit" name="update" value="<?=$prefsButtonStrings[0]?>">
            -->
			<input type="submit" name="apply" value="<?=$prefsButtonStrings[1]?>">
			<input type="submit" name="cancel" value="<?=$prefsButtonStrings[2]?>">
			<input type="submit" name="revert" value="<?=$prefsButtonStrings[3]?>">
		</form>
</BODY></HTML>
