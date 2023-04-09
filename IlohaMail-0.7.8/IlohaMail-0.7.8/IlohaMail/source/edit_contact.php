<?
/////////////////////////////////////////////////////////
//	
//	source/edit_contact.php
//
//	(C)Copyright 2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//		This file is part of IlohaMail.
//		IlohaMail is free software released under the GPL 
//		license.  See enclosed file COPYING for details,
//		or see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	AUTHOR: Ryo Chijiiwa <ryo@ilohamail.org>
	FILE: source/edit_contact.php
	PURPOSE:
		Provide an interface for viewing/adding/updating contact info.
	PRE-CONDITIONS:
		$user - Session ID
		[$edit] - $id of item to modify or update (-1 means "new")
	POST-CONDITIONS:
		POST's data to contacts.php, which makes the requested changes.
	COMMENTS:
		This program is essentially a portal/shell for other scripts that provide
		actual functionality.
		Includes:
			include/read_contacts.inc - Extract contacts from data source into array

********************************************************/
include("../include/super2global.inc");
include("../include/header_main.inc");
include("../lang/".$my_prefs["lang"]."/contacts.inc");
include("../lang/".$my_prefs["lang"]."/edit_contact.inc");

if (!isset($groups)){
    include("../include/contacts_commons.inc");
    include("../include/read_contacts.inc");
    $groups = GetGroups($contacts);
}

if (isset($edit)){
	if (!isset($contacts)){
        include("../include/read_contacts.inc");
	}
	if (is_array($contacts)){
		reset($contacts);
		while ( list($k, $foobar) = each($contacts)){
			if ($contacts[$k]["id"]==$edit){
				$name=$contacts[$k]["name"];
				$email=$contacts[$k]["email"];
				$email2=$contacts[$k]["email2"];
				$group=$contacts[$k]["grp"];
				$aim=$contacts[$k]["aim"];
				$icq=$contacts[$k]["icq"];
				$phone=$contacts[$k]["phone"];
				$work=$contacts[$k]["work"];
				$cell=$contacts[$k]["cell"];
				$address=$contacts[$k]["address"];
				$url=$contacts[$k]["url"];
				$comments=$contacts[$k]["comments"];
			}
		}
	}
}else{
	$edit=-1;
}

?>

<FORM ACTION="contacts.php" METHOD=POST>
	<input type="hidden" name="user" value="<? echo $user; ?>">
	<input type="hidden" name="delete_item" value="<? echo $edit; ?>">	
	<input type="hidden" name="edit" value="<? echo $edit; ?>">
	
	<font size=+1><b><? echo $cStrings[1]; ?></b></font>
	<table><tr>
		<td><?=$ecStrings[3]; ?>:<input type="text" name="name" value="<?=$name?>"></td>
		<td><?=$ecStrings[6]; ?>:
			<select name="group">
			<option value="_otr_"><?=$ecStrings[14]?>
			<?
				$groups=base64_decode($groups);
				$groups_a=explode(",", $groups);
				
				while (list($key,$val)=each($groups_a)){
					if (!empty($val)) echo "<option ".(strcmp($val,$group)==0?"SELECTED":"").">$val\n";
				}
			?>
			</select>
			<input type="text" name="other_group" value="<?=$other_group; ?>">
		</td>
	</tr>
	<tr>
	<td><p>
		<?=$ecStrings[4];?>:<input type="text" name="email" value="<?=$email; ?>">
		<br><?=$ecStrings[12];?>:<input type="text" name="email2" value="<?=$email2; ?>">
	</td>
	<td><p>
		AIM:<input type="text" name="aim" value="<?=$aim; ?>" size=12>
		<br>ICQ:<input type="text" name="icq" value="<?=$icq; ?>" size=12>
	</td>
	</tr>
	<tr>
	<td><p>
		<?=$ecStrings[8];?>:</b><input type="text" name="phone" value="<?=$phone; ?>"  size=20>
		<br><?=$ecStrings[9];?>:<input type="text" name="work" value="<?=$work; ?>" size=20>
		<br><?=$ecStrings[10];?>:<input type="text" name="cell" value="<?=$cell; ?>" size=20>
	</td>
	<td><p>
		<?=$ecStrings[11];?>:<br><textarea name="address" rows=7 cols=30><?=$address;?></textarea>
	</td>
	</tr>
	</table>
	<table width=300><tr>
		<td align=left><input type="submit" name="add" value="<?=$cStrings[8]; ?>"></td>
		<td align=right><input type="submit" name="remove" value="<?=$ecStrings[13]; ?>"></td>
	</tr></table>
</FORM>
<table>
</body>
</html>