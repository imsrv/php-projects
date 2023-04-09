<?
/////////////////////////////////////////////////////////
//	
//	source/contacts.php
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
	FILE:  source/contacts.php
	PURPOSE:
		List basic information of all contacts. 
		Offer links to
			-view/edit contact
			-send email to contact
			-add new contact
		Process posted data to edit/add/remove contacts information
	PRE-CONDITIONS:
		Required:
			$user-Session ID for session validation and user prefernce retreaval
		Optional:
			POST'd data for add/remove/edit entries.  See source/edit_contact.php
	POST-CONDITIONS:
	COMMENTS:
		This program is essentially a portal/shell for other scripts that provide
		actual functionality.
		Includes:
			include/read_contacts.inc - Extract contacts from data source into array
			include/add_contacts.inc - Add/edit contact to/in array of contacts
			include/save_contacts.inc - Write contacts array back into data source
********************************************************/

function FormatHeaderLink($user, $label, $color, $new_sort_field, $sort_field, $sort_order){
	if (strcasecmp($new_sort_field, $sort_field)==0){
		if (strcasecmp($sort_order, "ASC")==0) $sort_order="DESC";
		else $sort_order = "ASC";
	}
	$link = "<a href=\"contacts.php?user=$user&sort_field=$new_sort_field&sort_order=$sort_order\">";
	$link .= "<font color=\"$color\"><b>".$label."</b></font></a>";
	return $link;
}

include("../include/super2global.inc");
include("../include/contacts_commons.inc");
if (isset($user)){
	include("../include/header_main.inc");
	include("../lang/".$my_prefs["lang"]."/contacts.inc");
	include("../lang/".$my_prefs["lang"]."/compose.inc");

	echo '<center><h2>'.$cStrings[0].'</h2></center>';

	include("../include/read_contacts.inc");

	$numContacts = count($contacts);

	if (isset($add)){
		include("../include/add_contacts.inc");
	}else if (isset($delete)){
		include("../include/save_contacts.inc");
		$contacts=array();
		include("../include/read_contacts.inc");
	}else if (isset($remove)){
		include("../lang/".$my_prefs["lang"]."/edit_contact.inc");
		echo "<font color=red>".$errors[6].$name.$errors[7]."</font>\n";
		echo "[<a href=\"contacts.php?user=$sid&delete=1&delete_item=$delete_item\">".$ecStrings[13]."</a>]\n";
		echo "[<a href=\"contacts.php?user=$sid\">Cancel</a>]\n";
	}
	
	if (!empty($error)) echo "<p>".$error."<br>\n";
	
	$groups = GetGroups($contacts);
	echo '<p><a href="edit_contact.php?user='.$sid.'&edit=-1&groups='.$groups.'">'.$cStrings[1].'</a><br>';
	echo "\n";

	if ( is_array($contacts) ){
		reset($contacts);
        echo "<form method=\"POST\" action=\"compose.php\" target=\"_blank\">\n";
        echo "<input type=\"hidden\" name=\"user\" value=\"$user\">\n";
		echo "<table border=1>\n";
		echo "<tr>";
        echo "<td><b>".$composeHStrings[2]."</b></td>";
        echo "<td><b>".$composeHStrings[3]."</b></td>";
        echo "<td><b>".$composeHStrings[4]."</b></td>";        
		echo "<td>".FormatHeaderLink($user, $cStrings[3], $textc, "name", $sort_field, $sort_order)."</td>";
		echo "<td>".FormatHeaderLink($user, $cStrings[4], $textc, "email", $sort_field, $sort_order)."</td>";
		echo "<td>".FormatHeaderLink($user, $cStrings[6], $textc, "grp,name", $sort_field, $sort_order)."</td>";
		echo "</tr>";
		while( list($k1, $foobar) = each($contacts) ){
			echo "<tr>\n";
			$a=$contacts[$k1];
			$id=$a["id"];
			$toString=(!empty($a["name"])?"\"".$a["name"]."\" ":"")."<".$a["email"].">";
			$toString=urlencode($toString);
			if (empty($a["name"])) $a["name"]="--";
            echo "<td><input type=\"checkbox\" name=\"contact_to[]\" value=\"$toString\"></td>";
            echo "<td><input type=\"checkbox\" name=\"contact_cc[]\" value=\"$toString\"></td>";
            echo "<td><input type=\"checkbox\" name=\"contact_bcc[]\" value=\"$toString\"></td>";
			echo "<td><a href=\"edit_contact.php?user=$sid&k=$k1&edit=$id&groups=$groups\">".$a["name"]."</a></td>";
			echo "<td><a href=\"compose.php?user=$sid&to=$toString\" target=_blank>".$a["email"]."</a></td>";
			echo "<td>".$a["grp"]."</td>";
			echo "</tr>\n";
		}
		echo "</table>\n";
        echo "<input type=\"submit\" name=\"contacts_submit\" value=\"".$cStrings[10]."\">\n";
	}else{
		echo "<p>".$cErrors[0];
	}
}
?>
</BODY></HTML>