<?
/////////////////////////////////////////////////////////
//	
//	source/tool.php
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
	FILE: tool.php
	PURPOSE:
		This is the tool bar.  Provides global access to main functionality, including:
		1. Access to folder list, or folder contents (including INBOX)
		2. Access to message composition page (link to "source/compose.php")
		3. Access to search form (link to "source/search_form.php")
		4. Access to contacts list (link to "source/contacts.php")
		5. Access to preferences (link to "source/prefs.php")
		6. Logout
	PRE-CONDITIONS:
		$user - Session ID
	COMMENTS:
		Depending on whether or not "list_folders" preferences is enabled or not, this page
		may display a pop-up menu of all folders, or a link to source/folders.php.
		
********************************************************/

include("../include/super2global.inc");
include("../include/nocache.inc");

	if (isset($user)){
		include("../include/ryosimap.inc");
		include("../include/encryption.inc");
		include("../include/session_auth.inc");
		include("../include/icl.inc");

		$linkc=$my_colors["tool_link"];
		$bgc=$my_colors["tool_bg"];
		$bodyString='<BODY  LEFTMARGIN=0 RIGHTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0 TOPMARGIN=0 BGCOLOR="'.$bgc.'" TEXT="'.$linkc.'" LINK="'.$linkc.'" ALINK="'.$linkc.'" VLINK="'.$linkc.'">';
	}else{
		echo "User not specified.";
		exit;
	}
?>
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=<? echo $my_prefs["charset"]; ?>">
</HEAD>
<STYLE type="text/css">
	<!--
	A:link, A:visited, A:active, A:hover { text-decoration: none }
	//-->
</STYLE>
<? 
echo $bodyString; 
include("../lang/".$my_prefs["lang"]."tool.inc");
?>
<FONT SIZE="3">
<?
	echo "\n<form method=POST action=\"main.php\" target=\"list2\">\n";
?>
<table width="100%"><tr><td><nobr>
<?
if (($my_prefs["list_folders"])||(!$ICL_CAPABILITY["folders"])){
    echo "[<A HREF=\"main.php?folder=INBOX&user=$user\" target=\"list2\" >".$toolStrings["inbox"]."</A>]\n";
    if ($ICL_CAPABILITY["folders"])
        echo "[<A HREF=\"folders.php?user=$user\" target=\"list1\">".$toolStrings["folders"]."</A>]\n";
}else{
		echo "<input type=hidden name=\"sort_field\" value=\"".$my_prefs["sort_field"]."\">\n";
		echo "<input type=hidden name=\"sort_order\" value=\"".$my_prefs["sort_order"]."\">\n";
		echo "<input type=hidden name=\"user\" value=\"".$user."\">\n";
	
		$conn = iil_Connect($host, $loginID, $password, $AUTH_MODE);
		if ($conn){
			$folderlist=iil_C_ListMailboxes($conn, $my_prefs["rootdir"], "*");
			iil_Close($conn);
		}
		if ($my_prefs["list_folders"]!=1){
			include("../lang/".$my_prefs["lang"]."defaultFolders.inc");
			echo "<select name=folder>\n";
			FolderOptions3($folderlist, $defaults);
			echo "</select>";
			echo "<input type=submit value=\"".$toolStrings["go"]."\">";
		}
        if ($ICL_CAPABILITY["folders"])
            echo "[<A HREF=\"edit_folders.php?user=$user\" target=\"list2\">".$toolStrings["folders"]."</A>]\n";
}
?>
[<A HREF="compose.php?user=<?echo $user;?>" target="_blank"><? echo $toolStrings["compose"]; ?></A>]
[<A HREF="contacts.php?user=<?echo $user;?>" target="list2" ><? echo $toolStrings["contacts"]; ?></A>]
<?
if ($ICL_CAPABILITY["search"]){
    echo "[<A HREF=\"search_form.php?user=$user\" target=\"list2\" >".$toolStrings["search"]."</A>]\n";
}
?>
[<A HREF="prefs.php?user=<?echo $user;?>" target="list2" ><? echo $toolStrings["prefs"]; ?></A>]
</td><td align="right">
[<A HREF="login.php?logout=1&user=<?echo $user;?>" target="_top"><? echo $toolStrings["logout"]; ?></A>]
<nobr>
</td></tr></table>
</form>
</FONT>
</BODY>
</HTML>
