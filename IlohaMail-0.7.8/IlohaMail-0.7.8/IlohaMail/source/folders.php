<?
/////////////////////////////////////////////////////////
//	
//	source/folders.php
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
	FILE: source/folders.php
	PURPOSE:
		Display a list of folders, with links to main.php (which lists the contents of the folder).
		Also provides link to edit_folders.php (for creating/deleting/renaming folders).
	PRE-CONDITIONS:
		$user - Session ID
	COMMENTS:
		Currently simply lists all folders, regardless of subscription, etc.
		Seems to work fine for most purposes.
		
********************************************************/
include("../include/super2global.inc");
include("../include/nocache.inc");

function InArray($array, $item){
    reset($array);
    while (list($k,$v)=each($array)) if (strcmp($v,$item)==0) return true;
    return false;
}

function IndentPath($path, $containers, $delim){
	$containers->reset();
	$pos = strrpos($path, $delim);
	if ($pos>0){
		$folder = substr($path, $pos);
		$path = substr($path, 0, $pos);
	}
	
	do{
		$container = $containers->next();
		if ($container) $path = str_replace($container, "&nbsp;&nbsp;&nbsp;", $path);
	}while($container);
	
	return $path.$folder;
}

if (isset($user)){
	include("../include/session_auth.inc");
	include("../include/ryosimap.inc");
	include("../include/icl.inc");
	include("../include/stack.inc");

	$linkc=$my_colors["folder_link"];
	$bgc=$my_colors["folder_bg"];
	$bodyString= '<BODY BGCOLOR="'.$bgc.'" TEXT="'.$linkc.'" LINK="'.$linkc.'" ALINK="'.$linkc.'" VLINK="'.$linkc.'">';	
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
	
	$conn = iil_Connect($host, $loginID, $password, $AUTH_MODE);
	if (!$conn)
		echo "failed";
	else{
	include("../lang/".$my_prefs["lang"]."folders.inc");
	
	$folders = iil_C_ListMailboxes($conn, $my_prefs["rootdir"], "*");
	if (!is_array($folders)){
    	echo "Couldn't get folder list from stream $mbox at $host.<br>\n";
	} else {
		sort($folders);
		$c=sizeof($folders);
		echo "<NOBR>";

		reset ($defaults);
 		while (list($key, $value) = each ($defaults)) {
			if (($value!=".")&&(!empty($key))) echo "<a href=\"main.php?folder=$key&user=".$user."\" target=\"list2\">$value</a><br>";
 		}

		echo "<br>\n";
        $delim = iil_C_GetHierarchyDelimiter($conn);

        $containers = array();
        reset($folders);
        while ( list($k, $path) = each($folders) ){
            $pos = strrpos($path, $delim);
            if ($pos > 0){
                $container = substr($path, 0, $pos);
                if ($containers[$container]!=1) $containers[$container]=1;
            }
        }

        reset($containers);
        while ( list($container, $v) = each($containers) ){
            if (!InArray($folders,$container)) array_push($folders, $container);
        }
        asort($folders);

        reset($folders);
        while ( list($k, $path) = each($folders) ){
            $a = explode($delim, $path);
            $c = count($a);
            $folder = $a[$c-1];
            if (($path[0]!=".") && ($folder[0]!=".")){
                for($i=0;$i<($c-1);$i++) $result[$path].="&nbsp;&nbsp;&nbsp;";
                $result[$path] .= $folder;
            }
        }

        reset($result);
        while ( list($path, $display) = each($result) ){
            if ((!empty($display)) && (empty($defaults[$path]))){
                $path = urlencode($path);
                //echo "<a href=\"main.php?folder=$path\">$display</a><br>";
                echo "<NOBR><a href=\"main.php?folder=$path&user=".$user."\" target=\"list2\">".$display."</a></NOBR><BR>\n";
            }
        }
	}
	iil_Close($conn);
	}
}else{
	echo "User unspecified.";
	exit;
}
?>
<script language="JavaScript">
<?
	/*
		if ($oi==1){
			if ($new_user) echo "parent.list2.location=\"prefs.php?user=$user&new_user=$new_user\";\n";
			else echo "parent.list2.location=\"main.php?user=".$user."&folder=INBOX\";\n";
		}
	*/
?>
</script>
</BODY></HTML>