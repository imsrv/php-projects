<?
/////////////////////////////////////////////////////////
//	
//	source/edit_folders.php
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
	FILE:  source/edit_folders.php
	PURPOSE:
		Provide functionality to create/delete/rename folders
	PRE-CONDITIONS:
		$user - Session ID
	TODO:
		Modify to detect and allow for hierarchy delimiters other than '/'.
		
********************************************************/

function decodePath($path, $delimiter){
	$parts=explode($delimiter, $path);
	while (list($key, $part)=each($parts)){
		$parts[$key]=urldecode($part);
	}
	$path=implode($delimiter, $parts);

	return $path;
}

function encodePath($path, $delimiter){
		$parts=explode($delimiter, $path);
		while (list($key, $part)=each($parts)){
			$parts[$key]=urlencode($part);
            //echo "Encoded $part as ".$parts[$key]." <br>\n";
		}
		$path=implode($delimiter, $parts);
		
		return $path;
}

include("../include/super2global.inc");
include("../include/header_main.inc");
include("../include/icl.inc");
include("../lang/".$my_prefs["lang"]."defaultFolders.inc");
include("../lang/".$my_prefs["lang"]."edit_folders.inc");

	$conn = iil_Connect($host, $loginID, $password, $AUTH_MODE);
	if (!$conn)
		echo "failed";
	else{
		echo "<p><h2>".$efStrings[0]."</h2>\n";
		$hDelimiter = iil_C_GetHierarchyDelimiter($conn);
		flush();
		
		$modified=false;
		$error="";
		
	/********* Handle New Folder *******/
	if (isset($newfolder)){
		// prepend folder path with rootdir as necessary
		$rootdir=$my_prefs["rootdir"];
		if ((!empty($rootdir)) && (strpos($newfolder, $rootdir)===false)){
			$len = strlen($rootdir);
			if ($rootdir[$len-1]!=$hDelimiter) $rootdir.=$hDelimiter;
			$newfolder=$rootdir.$newfolder;
		}
		// create new folder
		$unencNF=$newfolder;
		//$newfolder=encodePath($newfolder, $hDelimiter);
		if (iil_C_CreateFolder($conn, $newfolder)){
			$error=$errors[0].$unencNF;
			$modified=true;
		}else{
			$error=$errors[1].$unencNF."<br>".$conn->error;
		}
	}
	/************************/
	
	/********* Handle Delete Folder ********/
	if (isset($delmenu)){
		$unencDF=decodePath($delmenu, $hDelimiter);
		if (iil_C_DeleteFolder($conn, decodePath($delmenu, $hDelimiter))){
			$error=$errors[2].$unencDF;
			$modified=true;
		}else{
			$error=$errors[3].$unencDF;
		}
	}
	/***************************/
	
	/********* Handle Rename Folder ********/
	if ((isset($newname)) &&(isset($oldname))){
		$unencNF=$newname;
	    //$newname=encodePath($newname, $hDelimiter);
		$str=decodePath($oldname, $hDelimiter)." --> $unencNF";
	   if (iil_C_RenameFolder($conn, decodePath($oldname, $hDelimiter), $newname)) {
        	$error=$errors[4].$str;
			$modified=true;
      	} else {
        	$error=$errors[5].$str;
      	}
	}
	/***************************/
    //check if folder support is available
	if (!$ICL_CAPABILITY["folders"])  $error .= $errors[6];
	
	if ($modified){
		echo "<font color=green>".$error."</font>";
		echo "<script> parent.list1.location=\"folders.php?user=$user\"; </script>\n";
	}else{
		echo "<font color=red>".$error."</font>";
		if ($port==110){
			iil_Close($conn);
			echo "</body></html>";
			exit;
		}
	}

	$mailboxes = iil_C_ListMailboxes($conn, $my_prefs["rootdir"], "*");
	sort($mailboxes);

	/********* Show Create ********/
	echo "<form method=\"POST\">";
	echo "<b>".$efStrings[1]."</b><br>";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$user."\">";
	echo $efStrings[2];
	echo "<input type=text name=newfolder size=20>";
	echo "<input type=submit value=$efStrings[3]>";
	echo "</form>";

	/********* Show Delete Folder *******/
	echo "<form method=\"POST\">";
	echo "<b>$efStrings[4]</b><br>";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$user."\">";
	echo "<select name=delmenu>";
		FolderOptions2($mailboxes, "");
	echo "</select>";
	echo "<input type=submit name=delete value=$efStrings[5]></form>";
	/************************/

	/********* Show Rename Folder *******/
	echo "<form method=\"POST\">";
	echo "<b>$efStrings[6]</b><br>";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$user."\">";
	echo "<select name=\"oldname\">";
		FolderOptions2($mailboxes, "");
	echo "</select>";
	echo "--><input type=\"text\" name=\"newname\">";
	echo "<input type=submit name=rename value=$efStrings[7]></form>";
	/************************/

	//echo "successful: $mbox ";
	iil_Close($conn);

	}
?>
</BODY></HTML>