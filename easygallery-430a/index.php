<?
/********************************************************************************/
/* EasyGallery:                                                                 */
/* ====================================================                         */
/*                                                                              */
/* Copyright (c) 2003 by Angel Stoitsov and Mario Stoitsov                      */
/*    http://software.stoitsov.com                                              */
/*                                                                              */
/* This file is part of EasyBookMarker.                                         */
/* EasyGallery is free software; you can redistribute it and/or modify          */
/*    it under the terms of the GNU General Public License as published by      */
/*    the Free Software Foundation; either version 2 of the License, or         */
/*    (at your option) any later version.                                       */
/* EasyGallery is distributed in the hope that it will be useful,               */
/*    but WITHOUT ANY WARRANTY; without even the implied warranty of            */
/*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             */
/*    GNU General Public License for more details.                              */
/* You should have received a copy of the GNU General Public License            */
/*    along with EasyGallery; if not, write to the Free Software                */
/*    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA */
/********************************************************************************/
/*

// Unzip the zip file in some subdirectory (e.g. EasyGallery) under the root
// directory on your server. Then follow the three easy steps below


// STEP ONE: Create the tables below under your desired DataBase
//           using phpMyAdmin for example


// ********************************************************************
// *********************** Database Tables
// ********************************************************************
/*
        DROP TABLE IF EXISTS `gaCategories`;
	CREATE TABLE gaCategories (
	  ID bigint(20) NOT NULL auto_increment,
	  DisplayName varchar(255) NOT NULL default '',
	  PictureFile varchar(200) NOT NULL default '',
	  PRIMARY KEY  (ID),
	  KEY ID (ID)
	) TYPE=MyISAM;

        DROP TABLE IF EXISTS `gaMediaFolders`;
	CREATE TABLE gaMediaFolders (
	  ID bigint(20) NOT NULL auto_increment,
	  Folder varchar(50) NOT NULL default '',
	  FolderName varchar(200) NOT NULL default '',
	  Description text NOT NULL,
	  Pictures bigint(20) NOT NULL default '0',
	  PictureFile varchar(200) NOT NULL default '',
	  Grand bigint(20) NOT NULL default '0',
	  PRIMARY KEY  (ID),
	  KEY ID (ID),
	  KEY FolderName (FolderName),
	  KEY Folder (Folder)
	) TYPE=MyISAM;

        DROP TABLE IF EXISTS `gaPictures`;
	CREATE TABLE gaPictures (
	  ID bigint(20) NOT NULL auto_increment,
	  Description text NOT NULL,
	  PictureSize varchar(20) NOT NULL default '',
	  FileSize varchar(20) NOT NULL default '',
	  PictureFile varchar(50) NOT NULL default '',
	  Folder bigint(20) NOT NULL default '0',
	  Date date NOT NULL default '0000-00-00',
	  PRIMARY KEY  (ID),
	  KEY ID (ID),
	  KEY Folder (Folder),
	  KEY Date (Date),
	  KEY PictureFile (PictureFile)
	) TYPE=MyISAM;
*/
// STEP TWO: Edit your preferences below


// ********************************************************************
// *********************** Config options
// ********************************************************************
$EasyGallery["mysql_host"]="localhost";       // change to your MySQL Host
$EasyGallery["mysql_user"]="dbuser";      // change to your MySQL Username
$EasyGallery["mysql_pass"]="dbpass"; // change to your MySQL Password
$EasyGallery["mysql_base"]="dbname";       // Database name, to contain EasyClassifields tables
$EasyGallery["web_user"]="adminuser";        // Username for WEB - based editing interface
$EasyGallery["web_pass"]="adminpass";        // Password for WEB - based editing interface
$EasyGallery["demo_mode"]=FALSE; // If True Download, Delete and Reindex functions are disabled
$EasyGallery["media_folder"]="MediaFolders"; // Folder CHMODED 0777 with apache owner and group, under EasyGallery source directory
$EasyGallery["cats_per_page"]=4;  // How many Categories per page
$EasyGallery["pics_per_page"]=8;  // How many Pictures per page
$EasyGallery["upload_fields"]=10; // How many Pictures to upload in a single pass
$EasyGallery["upload_resizeX"]=500; // Maximum X size of uploaded picture
$EasyGallery["upload_resizeY"]=400; // Maximum Y size of uploaded picture
$EasyGallery["gd_version"]="2";  // Set to 2 if you have GD 2 or higher and set to 1 if you have older
$EasyGallery["DarkColor"]="#8C6728"; // Color of the headings, tables, links
$EasyGallery["Background"]="#FFF7E4"; // Page Background color
$EasyGallery["LightColor1"]="#EBE1CB"; // Table Highlight type 1
$EasyGallery["LightColor2"]="#F5F5F5"; // Table Highlight type 2


// LAST STEP THREE: POINT TO INDEX.PHP and ENJOY !!!


// ********************************************************************
// You do not need to edit below this line
// ********************************************************************

// ********************************************************************
// ********************* Initialization & Constants
// ********************************************************************

//error_reporting(0);

$EasyGallery["version"]="4.30a";
session_start();
$sql=mysql_connect($EasyGallery["mysql_host"],$EasyGallery["mysql_user"],$EasyGallery["mysql_pass"]) or
                        Die (gaError("Problem!","<br>The database server is offline. Try again shortly.","If the problem persists, contact the system administrator."));
mysql_select_db($EasyGallery["mysql_base"]) or
                        Die (gaError("Problem!","<br>The database is down for maintenance. It takes about 2 minutes to complete.","If the problem persists, contact the system administrator."));

if (!session_is_registered("gaOrder")) {
	$gaOrder=0;
	session_register("gaOrder");
}

if (isset($setgaOrder)) $gaOrder=$setgaOrder;

switch ($gaOrder) {
	case 1: $QryOrder="Description"; break;
	case 2: $QryOrder="FileSize Desc"; break;
	default: $QryOrder="Date Asc"; break;
} // switch

function gaGetByID($Table,$Field,$ID) {
Global $sql;
	$Result=mysql_query("SELECT ".$Field." FROM ".$Table." WHERE ID='".$ID."';");
	if (mysql_num_rows($Result)==0) {
		return "Неизвестен";
	} else {
		$Ret=mysql_fetch_array($Result);
		return $Ret[$Field];
	} // if
} // function GetByID

function gaMakeThumb($original_file,$new_file) {
global $EasyGallery;
	$W=$H=120;
	$im = @imagecreatefromjpeg ($original_file);
	$size = GetImageSize ($original_file);
	$H1=$size[1]/($size[0]/$W);
	$W1=$size[0]/($size[1]/$H);
	if ($H1<$W1) { $H1=120; $dH=0; $dW=($W1-120)/2; }
	if ($H1>$W1) { $W1=120; $dW=0; $dH=($H1-120)/2; }
	if ($EasyGallery["gd_version"]==2) {
		$im2 = @ImageCreateTrueColor ($W,$H); // GD 2
		imagecopyresampled ($im2, $im, 0-$dW, 0-$dH, 0, 0, $W1, $H1,$size[0],$size[1]); // GD 2
	} else {
		$im2 = @ImageCreate ($W,$H); // GD < 2
		imagecopyresized ($im2, $im, 0-$dW, 0-$dH, 0, 0, $W1, $H1,$size[0],$size[1]); // GD < 2
	}
	$black = ImageColorAllocate ($im2, 0, 0, 0);
	imagerectangle($im2,0,0,$W-1,$H-1,$black);
	ImageJpeg($im2,$new_file);
} // MakeThumb

function gaResize($original_file,$new_file) {
global $EasyGallery;
	if (!isset($EasyGallery["upload_resizeX"]) or $EasyGallery["upload_resizeX"]==0) return FALSE;
	$im = @imagecreatefromjpeg ($original_file);
	$size = GetImageSize ($original_file);
	$RequestedW=$EasyGallery["upload_resizeX"];
	$RequestedH=$EasyGallery["upload_resizeY"];
	$RealH=$size[1];
	$RealW=$size[0];
	if ($RealW<$RequestedW && $RealH<$RequestedH) return FALSE;
	if ($RealW>=$RealH) { // Calculate new H
		$NewW=$RequestedW;
		$NewH=Round($RealH*(100/$RealW*$NewW)/100,0);
	} else { // Calculate new W
		$NewH=$RequestedH;
		$NewW=Round($RealW*(100/$RealH*$NewH)/100,0);
	} // if
	if ($EasyGallery["gd_version"]==2) {
		$im2 = @ImageCreateTrueColor ($NewW,$NewH); // GD 2
		imagecopyresampled ($im2, $im, 0, 0, 0, 0, $NewW, $NewH,$RealW,$RealH); // GD 2
	} else {
		$im2 = @ImageCreate ($NewW,$NewH); // GD < 2
		imagecopyresized ($im2, $im, 0, 0, 0, 0, $NewW, $NewH,$RealW,$RealH); // GD < 2
	} // if
	$black = ImageColorAllocate ($im2, 0, 0, 0);
	imagerectangle($im2,0,0,$NewW-1,$NewH-1,$black);
	ImageJpeg($im2,$new_file);
	return TRUE;
} // Resize

function gaShowPicture($pic) {
global $EasyGallery;
	// Is there a picture?
	if ($pic["PictureFile"]!="") {
		// Is there thumb ?
		$tmbl=split("/",$pic["PictureFile"]);
		if (!file_exists($EasyGallery["media_folder"]."/".$tmbl[0]."/thumb_".$tmbl[1])) {
			gaMakeThumb($EasyGallery["media_folder"]."/".$pic["PictureFile"],$EasyGallery["media_folder"]."/".$tmbl[0]."/thumb_".$tmbl[1]);
		} // No thumb?
		return "<img src='".$EasyGallery["media_folder"]."/".str_replace("/","/thumb_",$pic["PictureFile"])."' width='120' height='120' alt='".$pic["Description"]."' border='0'>";
	} else {
		return "<img src='nopic.gif' width='120' height='120' alt='No picture available' border='0'>";
	}
}

function getDirList ($dirName) {
	$d = dir($dirName);
	while($entry = $d->read()) {
		if ($entry != "." && $entry != "..") {
			if (is_dir($dirName."/".$entry)) {
				$ret[$entry]=$entry;
			} // if
		} // if
	} // while
	$d->close();
	return $ret;
}

function getFileList ($dirName) {
	$d = dir($dirName);
	while($entry = $d->read()) {
		if ($entry != "." && $entry != "..") {
			if (!is_dir($dirName."/".$entry)) {
				if (substr($entry,0,6)!="thumb_") $ret[$entry]=$entry;
			} // if
		} // if
	} // while
	$d->close();
	return $ret;
}

function GoDelete($file) {
$delete = @unlink($file);
	if (@file_exists($file)) {
		$filesys = eregi_replace("/","\\",$file);
		$delete = @system("del $filesys");
		if (@file_exists($file)) {
			$delete = @chmod ($file, 0775);
			$delete = @unlink($file);
			$delete = @system("del $filesys");
		} else { return TRUE; }
	}  else { return TRUE; }
	if (@file_exists($file)) { return FALSE; } else { return TRUE; }
}

function gaError($Heading="Error!",$Error="",$Solution="") {
return "<br><table border=0 cellspacing=0 cellpadding=0 align=center><tr><td><div style='background-color:#FFD8D8; border: 2px solid red; padding:10 10 10 10; font: 11px Verdana;'>
		<font color=red><b>$Heading</b></font><br><P>".mysql_error()."<b>$Error</b></P><i>$Solution</i></div></td></tr></table><br>";
} // function Error

function gaHackers($Text) {
	$ret=strip_tags($Text);	$ret=escapeshellcmd($ret);
	$ret=trim($ret);	$ret=str_replace("'","`",$ret);
	return $ret;
}

function gaTr($width=1,$height=1) {
	return "<img src='tr.gif' width='$width' height='$height' alt='' border='0'>";
}

function gaElement($Element="default",$Arg1="default",$Arg2="default",$Arg3="default",$Arg4="default",$Arg5="default",$Arg6="default") {
	switch ($Element) {
		case "form" : // Element, Action, Name, Method, Aditional
			$Action=$Arg1; $Name=$Arg2; $Method=$Arg3; $Aditional=$Arg4;
			if ($Name=="default") $Name="my";
			if ($Method=="default") $Method="POST";
			if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; }
			return "<form action='$Action' name='$Name' method='$Method'".$Aditional.">\n";
		break;
		case "hidden" : // Element, Name, Value
			$Name=$Arg1; $Value=$Arg2;
			if ($Value=="default") $Value="";
			return "<input type='hidden' name='".$Name."' value='".$Value."'>\n";
		break;
		case "text" : // Element, Name, Value, Width, Aditional, Class
			$Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; $Class=$Arg5;
			if (strpos($Name,"[")===FALSE) {
				$ID="";
			} else {
				$Tmp=split("\[",$Name);
				$TmpID=split("\]",$Tmp[1]);
				$ID=" ID='".$TmpID[0]."' ";
			}
			if ($Value=="default") $Value="";
			if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; }
			if ($Class=="default") { $Class=" class='f_text'"; } else { $Class=" class='".$Class."'"; }
			if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; }
			return "<input type='text'".$Class.$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n";
		break;
		case "file" : // Element, Name, Value, Width, Aditional, Class
			$Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; $Class=$Arg5;
			if (strpos($Name,"[")===FALSE) {
				$ID="";
			} else {
				$Tmp=split("\[",$Name);
				$TmpID=split("\]",$Tmp[1]);
				$ID=" ID='".$TmpID[0]."' ";
			}
			if ($Value=="default") $Value="";
			if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; }
			if ($Class=="default") { $Class=" class='f_text'"; } else { $Class=" class='".$Class."'"; }
			if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; }
			return "<input type='file'".$Class.$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n";
		break;
		case "textarea" : // Element, Name, Value, Width, Height
			$Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Height=$Arg4;
			if ($Value=="default") $Value="";
			if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; }
			if ($Height=="default") { $Height=""; } else { $Height=" Rows='$Height' "; }
			return "<textarea class='f_text' name='".$Name."'".$Width.$Height.">".$Value."</textarea>\n";
		break;
		case "password" : // Element, Name, Value, Width, Aditional
			$Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4;
			if (strpos($Name,"[")===FALSE) {
				$ID="";
			} else {
				$Tmp=split("[",$Name);
				$TmpID=split("]",$Tmp[1]);
				$ID=" ID='".$TmpID[0]."' ";
			}
			if ($Value=="default") $Value="";
			if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; }
			if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; }
			return "<input type='password' class='f_text'".$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n";
		break;
		case "radio" : // Element, Name, Value, Selected, Aditional
			$Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4;
			if (strpos($Name,"[")===FALSE) {
				$ID="";
			} else {
				$Tmp=split("[",$Name);
				$TmpID=split("]",$Tmp[1]);
				$ID=" ID='".$TmpID[0]."' ";
			}
			if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; }
			if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; }
			return "<input type='radio'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break;
		break;
		case "checkbox" : // Element, Name, Value, Selected, Aditional
			$Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4;
			if (strpos($Name,"[")===FALSE) {
				$ID="";
			} else {
				$Tmp=split("[",$Name);
				$TmpID=split("]",$Tmp[1]);
				$ID=" ID='".$TmpID[0]."' ";
			}
			if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; }
			if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; }
			return "<input type='checkbox'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">";
		break;
		case "submit" : // Element, Heading, Class
			$Value=$Arg1;
			$Class=$Arg2;
			if ($Class=="default") { $Class="f_text"; }
			return "<input type='submit' class='$Class' name='$Value' value='$Value'>";
		break;
		case "button" : // Element, Name, Heading, OnClick
			$Name=$Arg1; $Value=$Arg2; $OnClick=$Arg3;
			if ($OnClick=="default") { $OnClick=""; } else { $OnClick=" OnClick='".$OnClick."'"; }
			return "<input type='button' class='f_text' name='".$Name."' value='".$Value."'".$OnClick.">";
		break;
		case "select" : // Element, Name, Values, Selected, Width, Labels, Aditional
			$Name=$Arg1; $Values=$Arg2; $Selected=$Arg3; $Width=$Arg4; $Labels=$Arg5; $Aditional=$Arg6;
			if (!is_array($Values)) $Values=Array("!!!няма въведени параметри!!!");
			if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; }
			if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; }
			if (strpos($Name,"[")===FALSE) {
				$ID="";
			} else {
				$Tmp=split("\[",$Name);
				$TmpID=split("\]",$Tmp[1]);
				$ID=" ID='".$TmpID[0]."' ";
			}
			$ret="<select class='f_text' name='".$Name."'".$ID.$Width.$Aditional.">";
			while(list($key,$val)=each($Values)) {
				$CurrentLabel="";
				if (isset($Labels[$key])) $CurrentLabel=" Label='".$Labels[$key]."'";
				$ret.="<option value='".$key."'".$CurrentLabel.($Selected==$key ? " selected" : "" ).">".$val."</option>\n";
			} // while
			$ret.="</select>";
			return $ret;
		break;
		case "reset" : // Element, Heading
			$Value=$Arg1;
			if ($Value=="default") $Value="Изчиства";
			return "<input type='reset' class='f_text' name='reset' value='".$Value."'>";
		break;
		default : // (ANY)
			return "</form>";
		break;
	} // switch
} // function Element

function gaHeading($Heading,$BR=1) {
	$ret="";
	$ret.="<span class='h1s'>".$Heading."</span>";
	for ($t=0; $t<$BR; $t++) $ret.="<BR>";
	return $ret."\n";
} // heading

function gaMyQuery($Query) {
Global $sql;
	$Res=mysql_query($Query) or Die (gaError("Error!","<br>Invalid DataBase Query.","<PRE>The query is:<br>$Query</PRE>If the problem persists, contact the system administrator."));
	return $Res;
} // function MyQuery

function gaMyFetch($Query) {
Global $sql;
	$Res=mysql_fetch_array(mysql_query($Query)) or Die (gaError("Error!","<br>Invalid DataBase Query.","<PRE>The query is:<br>$Query</PRE>If the problem persists, contact the system administrator."));
	return $Res;
} // function MyFetch

function gaRegistered($Who) {
Global $Stoitsov,$EasyGallery;
	$ret=-1;
	if (isset($Stoitsov) && session_is_registered("Stoitsov") && $EasyGallery["webuser"]==$Stoitsov["webuser"])
		$ret=2;
	return $ret;
}

// ********************************************************************
// ************************ Actions
// ********************************************************************


if ($action=="login") {
	if ($EasyGallery["webuser"]===$gaUsername && $EasyGallery["webpass"]===$gaPassword) { // valid user
		$Stoitsov["webuser"]=$EasyGallery["webuser"];
		session_register("Stoitsov");
	} else { // invalid user
		$Error="<b>Invalid username or password.</b><br>";
		$page="login";
	}// if
} // Login

if ($action=="logout") {
	session_unregister("Stoitsov");
	unset($Stoitsov);
} // Logout

if ($action=="add_category") {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
			unset($Error);
			if (strlen(gaHackers($gaDisplayName))<4) $Error.="<b>Name is invalid. Min 4 chars.</b><br>";
			if (isset($Error)) { // There are errors
				$page="new"; $what="category";
			} else { // Add Category
				gaMyQuery("INSERT INTO gaCategories VALUES(null,'".gaHackers($gaDisplayName)."','');");
			} // if Errors
	} // if valid
} // Add Category

if ($action=="update_category") {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
			unset($Error);
			if (strlen(gaHackers($gaDisplayName))<4) $Error.="<b>Name is invalid. Min 4 chars.</b><br>";
			if (isset($Error)) { // There are errors
				$page="modify"; $what="category";
			} else { // UPDATE Category
				gaMyQuery("UPDATE gaCategories SET DisplayName='".gaHackers($gaDisplayName)."' WHERE ID=$catid;");
			} // if Errors
	} // if valid
} // Update Category

if ($action=="set_category_picture") {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
		gaMyQuery("UPDATE gaCategories SET PictureFile='".gaHackers($pic)."' WHERE ID=$catid;");
	} // if valid
} // Update Category

if ($action=="delete_category" && isset($catid)) {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
		gaMyQuery("DELETE FROM gaCategories WHERE ID=$catid;");
	} // if valid
} // Delete Category

if ($action=="add_folder") {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
			unset($Error);
			if (strlen(gaHackers($gaFolderName))<4) $Error.="<b>Name is invalid. Min 4 chars.</b><br>";
			if (strlen(gaHackers($gaDescription))<4) $Error.="<b>Description is invalid. Min 4 chars.</b><br>";
			if (isset($Error)) { // There are errors
				$page="new"; $what="folder"; $catid=$gaGrand;
			} else { // Add FOLDER
				$HDD_Name=str_replace(" ","_",strtolower(gaHackers($gaFolderName)));
				if (mkdir ($EasyGallery["media_folder"]."/".$HDD_Name, 0755)) {
					chmod ($EasyGallery["media_folder"]."/".$HDD_Name,0777);
					gaMyQuery("INSERT INTO gaMediaFolders VALUES(null,'".$HDD_Name."','".gaHackers($gaFolderName)."','".gaHackers($gaDescription)."','0','','".$gaGrand."');");
					$page="category"; $catid=$gaGrand;
				} // if
			} // if Errors
	} // if valid
} // Add Folder

if ($action=="update_folder") {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
			unset($Error);
			if (strlen(gaHackers($gaFolderName))<4) $Error.="<b>Name is invalid. Min 4 chars.</b><br>";
			if (strlen(gaHackers($gaDescription))<4) $Error.="<b>Description is invalid. Min 4 chars.</b><br>";
			if (isset($Error)) { // There are errors
				$page="modify"; $what="folder";
			} else { // Update FOLDER
				gaMyQuery("UPDATE gaMediaFolders SET FolderName='".gaHackers($gaFolderName)."', Description='".gaHackers($gaDescription)."', Grand='".$gaGrand."' WHERE ID=$folid;");
				$page="category"; $catid=$gaGrand;
			} // if Errors
	} // if valid
} // Update Folder

if ($action=="set_folder_picture") {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
		gaMyQuery("UPDATE gaMediaFolders SET PictureFile='".gaHackers($pic)."' WHERE ID=$folid;");
		$page="category"; $catid=gaGetByID("gaMediaFolders","Grand",$folid);
	} // if valid
} // Update Category

if ($action=="delete_folder" && isset($folid)) {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
		if (GoDelete($EasyGallery["media_folder"]."/".gaGetByID("gaMediaFolders","Folder",$folid))) {
			$page="category"; $catid=gaGetByID("gaMediaFolders","Grand",$folid);
			gaMyQuery("DELETE FROM gaMediaFolders WHERE ID=$folid;");
		} // if
	} // if valid
} // Delete Folder

if ($action=="upload") {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
		if ($EasyGallery["demo_mode"]) {
			$page="upload"; $folid=$gaFolder;
			$Error="<br><b><font color=red>EasyGallery is running in DEMO mode. You can not UPLOAD or DELETE Files.</font></b><br><font color=green>Install EasyGallery on your server and set DEMO MODE to FALSE!</font><br>";
		} else {
			if (!isset($EasyGallery["upload_fields"])) $EasyGallery["upload_fields"]=10;
			for ($uploaded=0; $uploaded<$EasyGallery["upload_fields"]; $uploaded++) {
				$fname="files".$uploaded;
				$itype=split("/",$_FILES[$fname]['type']);
				if ($_FILES[$fname]['size']!=0 && $itype[0]=="image" && ($itype[1]=="jpeg" OR $itype[1]=="pjpeg")) {
					$isize=getimagesize($_FILES[$fname]['tmp_name']);
					$dimensions=$isize[0]."x".$isize[1]." px";
					$MediaHDD=gaGetByID("gaMediaFolders","Folder",$gaFolder);
					if (!gaResize($_FILES[$fname]['tmp_name'],$EasyGallery["media_folder"]."/".$MediaHDD."/".$_FILES[$fname]['name'])) {
						if (move_uploaded_file($_FILES[$fname]['tmp_name'], $EasyGallery["media_folder"]."/".$MediaHDD."/".$_FILES[$fname]['name'])) {
							gaMyQuery("DELETE FROM gaPictures WHERE PictureFile='".$MediaHDD."/".$_FILES[$fname]['name']."';");
							gaMyQuery("Insert Into gaPictures Values(null,'".$_FILES[$fname]['name']."','$dimensions','".Round($_FILES[$fname]['size']/1024,2)."','".$MediaHDD."/".$_FILES[$fname]['name']."','$gaFolder','".Date("Y-m-d")."');");
							if (file_exists($EasyGallery["media_folder"]."/".$MediaHDD."/thumb_".$_FILES[$fname]['name'])) {
								GoDelete($EasyGallery["media_folder"]."/".$MediaHDD."/thumb_".$_FILES[$fname]['name']);
							}
						}
					} else {
						$isize=getimagesize($EasyGallery["media_folder"]."/".$MediaHDD."/".$_FILES[$fname]['name']);
						$dimensions=$isize[0]."x".$isize[1]." px";
						$filesize=Round(filesize($EasyGallery["media_folder"]."/".$MediaHDD."/".$_FILES[$fname]['name'])/1024,2);
						gaMyQuery("DELETE FROM gaPictures WHERE PictureFile='".$MediaHDD."/".$_FILES[$fname]['name']."';");
						gaMyQuery("Insert Into gaPictures Values(null,'".$_FILES[$fname]['name']."','$dimensions','".$filesize."','".$MediaHDD."/".$_FILES[$fname]['name']."','$gaFolder','".Date("Y-m-d")."');");
						if (file_exists($EasyGallery["media_folder"]."/".$MediaHDD."/thumb_".$_FILES[$fname]['name'])) {
							GoDelete($EasyGallery["media_folder"]."/".$MediaHDD."/thumb_".$_FILES[$fname]['name']);
						} // if
					} // if gaResize
				} else {
					if ($itype[1]!="octet-stream") $Error="<br><font color=red><b>EasyGallery is working only with JPEG (.jpg) images!</b></font><br>";
				} // if
			} // for
			if (isset($turn)) { // goto pictures
				$page="folder"; $folid=$gaFolder; $catid=gaGetByID("gaMediaFolders","Grand",$folid);
			} else { // continue upload
				$page="upload"; $folid=$gaFolder;
			} // if
		} // nodemo
	} // Valid
} // Upload

if ($action=="pictures" && isset($pics)) {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
		if (isset($delete)) { // Delete
			if ($EasyGallery["demo_mode"]) {
				$page="folder";
				$Error="<br><b><font color=red>EasyGallery is running in DEMO mode. You can not UPLOAD or DELETE Files.</font></b><br><font color=green>Install EasyGallery on your server and set DEMO MODE to FALSE!</font><br>";
			} else {
				foreach ($pics as $pic) {
					$Picture=gaMyFetch("SELECT PictureFile FROM gaPictures WHERE ID=$pic;");
					if (GoDelete($EasyGallery["media_folder"]."/".$Picture["PictureFile"])) {
						GoDelete($EasyGallery["media_folder"]."/".str_replace("/","/thumb_",$Picture["PictureFile"]));
						gaMyQuery("DELETE FROM gaPictures WHERE ID=$pic;");
						gaMyQuery("UPDATE gaCategories SET PictureFile='' WHERE PictureFile='".$Picture["PictureFile"]."';");
						gaMyQuery("UPDATE gaMediaFolders SET PictureFile='' WHERE PictureFile='".$Picture["PictureFile"]."';");
					}
				} // foreach
				$page="folder";
			} // nodemo
		} // if delete
		if (isset($move)) { // move
			$NewFolder=gaGetByID("gaMediaFolders","Folder",$gaFolder);
			foreach ($pics as $pic) {
				$Picture=gaMyFetch("SELECT PictureFile FROM gaPictures WHERE ID=$pic;");
				$NewFile=split("/",$Picture["PictureFile"]);
				if (rename($EasyGallery["media_folder"]."/".$Picture["PictureFile"],$EasyGallery["media_folder"]."/".$NewFolder."/".$NewFile[1])) {
					GoDelete($EasyGallery["media_folder"]."/".str_replace("/","/thumb_",$Picture["PictureFile"]));
					gaMyQuery("UPDATE gaPictures SET PictureFile='".$NewFolder."/".$NewFile[1]."', Folder='".$gaFolder."' WHERE ID=$pic;");
					gaMyQuery("UPDATE gaCategories SET PictureFile='' WHERE PictureFile='".$Picture["PictureFile"]."';");
					gaMyQuery("UPDATE gaMediaFolders SET PictureFile='' WHERE PictureFile='".$Picture["PictureFile"]."';");
				}
			}
			$page="folder";
		} // if move
	} // if valid
} // Delete or Move pictures

if ($action=="update_picture") {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
			unset($Error);
			if (strlen(gaHackers($gaDescription))<4) $Error.="<b>Description is invalid. Min 4 chars.</b><br>";
			if (isset($Error)) { // There are errors
				$page="modify"; $what="picture";
			} else { // Update Picture
				gaMyQuery("UPDATE gaPictures SET Date='".gaHackers($gaDate)."', Description='".gaHackers($gaDescription)."' WHERE ID=$picid;");
				$page="folder";
			} // if Errors
	} // if valid
} // Update Picture

if ($action=="reindex") {
	if (gaRegistered($Stoitsov)<0) { // invalid user
		$page="login";
		$Error="<b>You need to be a registered user to use this function.</b><br>";
	} else { // valid
		if ($EasyGallery["demo_mode"]) {
				$page="folder"; $catid=$gaGrand; $folid=$FolderID;
				$Error="<br><b><font color=red>EasyGallery is running in DEMO mode. You can not UPLOAD or DELETE Files.</font></b><br><font color=green>Install EasyGallery on your server and set DEMO MODE to FALSE!</font><br>";
			} else {
				// Add FOLDER & pics
				$isExFolder=gaMyQuery("SELECT ID, Folder FROM gaMediaFolders WHERE Folder='$gaDir';");
				if (mysql_num_rows($isExFolder)!=0) { // Folder Exists
					$Temp=mysql_fetch_array($isExFolder);
					$FolderID=$Temp["ID"];
					gaMyQuery("UPDATE gaMediaFolders SET Grand='".$gaGrand."' WHERE ID=$FolderID;");
				} else { // Folder does not exists, create it
					gaMyQuery("INSERT INTO gaMediaFolders VALUES(null,'".$gaDir."','".gaHackers($gaFolderName)."','".gaHackers($gaDescription)."','0','','".$gaGrand."');");
					$FolderID=mysql_insert_id();
				}
				$Files=getFileList($EasyGallery["media_folder"]."/".$gaDir);
				foreach ($Files as $File) {
					gaResize($EasyGallery["media_folder"]."/".$gaDir."/".$File,$EasyGallery["media_folder"]."/".$gaDir."/".$File);
					$isize=getimagesize($EasyGallery["media_folder"]."/".$gaDir."/".$File);
					$dimensions=$isize[0]."x".$isize[1]." px";
					$filesize=Round(filesize($EasyGallery["media_folder"]."/".$gaDir."/".$File)/1024,2);
					$isExPicture=gaMyQuery("SELECT ID FROM gaPictures WHERE PictureFile='".$gaDir."/".$File."';");
					if (mysql_num_rows($isExPicture)!=0) { // Picture Exists
						gaMyQuery("UPDATE gaPictures SET PictureSize='$dimensions', FileSize='".$filesize."', Folder='$FolderID' WHERE PictureFile='".$gaDir."/".$File."';");
					} else { // Picture does not Exists
						gaMyQuery("INSERT INTO gaPictures VALUES(null,'".$File."','$dimensions','".$filesize."','".$gaDir."/".$File."','$FolderID','".Date("Y-m-d")."');");
					}
				} // foreach
				// Check for deleted files
				$DBPics=gaMyQuery("SELECT ID, PictureFile FROM gaPictures WHERE Folder=$FolderID;");
				while ($DBPic=mysql_fetch_array($DBPics)) {
					if (!file_exists($EasyGallery["media_folder"]."/".$DBPic["PictureFile"])) {
						// Delete it from database, try to delete the thumb
						GoDelete($EasyGallery["media_folder"]."/".str_replace("/","/thumb_",$DBPic["PictureFile"]));
						gaMyQuery("DELETE FROM gaPictures WHERE ID=".$DBPic["ID"].";");
					} // if
				} // while
				$page="folder"; $catid=$gaGrand; $folid=$FolderID;
		} // nodemo
	} // if valid
} // Reindex


// session_write_close();


// ********************************************************************
// **************   EasyGallery Screen Creation
// ********************************************************************

// Login page
if (isset($page) && $page=="login") {
	$ResultHtml="";
	$ResultHtml.=gaHeading("User authorization",1).
	"You need to be registered user in order to add, edit or delete ".$EasyGallery["Articles"].".<br><br><br>
	<div align=center>
	<table border='0' cellspacing='1' cellpadding='2' bgcolor='".$EasyGallery["DarkColor"]."' width=200>
		<tr>
			<td colspan=2>&nbsp;<font color=".$EasyGallery["Background"]."><b>.: Login</b></font></td>
		</tr>
		".gaElement("form",$PHP_SELF,"Login","POST")."
		<tr>
			<td bgcolor=".$EasyGallery["Background"]." align=right><b>Username:</b></td>
			<td bgcolor=".$EasyGallery["Background"].">".gaElement("text","gaUsername",$gaUsername,100)."</td>
		</tr>
		<tr>
			<td bgcolor=".$EasyGallery["Background"]." align=right><b>Password:</b></td>
			<td bgcolor=".$EasyGallery["Background"].">".gaElement("password","gaPassword","",100)."</td>
		</tr>
		<tr>
			<td colspan=2 align=right>".gaElement("submit","Login","f_button")."</td>
		</tr>
		".gaElement("hidden","action","login").gaElement()."
	</table><br>".
	$Error
	."</div>
	";
} // end: Login Page

// Start: New
if (isset($page) && $page=="new" && isset($what)) {
	if ($what=="category" ) { // New Category
		$ResultHtml=gaHeading("Add New Category",1)."Use categories to organize your Media Folders<br><br>
		<div align=center>
		<table border='0' cellspacing='1' cellpadding='2' bgcolor='".$EasyGallery["DarkColor"]."' width=200>
		<tr>
			<td>&nbsp;<font color=".$EasyGallery["Background"]."><b>.: Category Information</b></font></td>
		</tr>
		".gaElement("form",$PHP_SELF,"Category","POST")."
		<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Name:</b> Max 255 chars<br>
			".gaElement("text","gaDisplayName","",150)."</td>
		</tr>
		<tr>
			<td align=right>".gaElement("submit","Create","f_button")."</td>
		</tr>".
		gaElement("hidden","action","add_category").gaElement()."
		</table>
		".$Error;
	} // Category

	if ($what=="folder" ) { // New Folder
		$CatSelects=gaMyQuery("SELECT * FROM gaCategories ORDER BY DisplayName;");
		while ($CatSelect=mysql_fetch_array($CatSelects)) {
			$Categories[$CatSelect["ID"]]=$CatSelect["DisplayName"];
		} // while
		$ResultHtml=gaHeading("Add New Folder",1)."Use folders as a picture containers<br><br>
		<div align=center>
		<table border='0' cellspacing='1' cellpadding='2' bgcolor='".$EasyGallery["DarkColor"]."' width=200>
		<tr>
			<td>&nbsp;<font color=".$EasyGallery["Background"]."><b>.: Folder Information</b></font></td>
		</tr>
		".gaElement("form",$PHP_SELF,"Folder","POST").
		"<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Create under:</b><br>
			".gaElement("select","gaGrand",$Categories,$catid,150)."</td>
		</tr>
		<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Name:</b> Max 255 chars<br>
			".gaElement("text","gaFolderName","",150)."</td>
		</tr>
		<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Description:</b><br>
			".gaElement("text","gaDescription","",300)."</td>
		</tr>
		<tr>
			<td align=right>".gaElement("submit","Create","f_button")."</td>
		</tr>".
		gaElement("hidden","action","add_folder").gaElement()."
		</table>
		".$Error;
	} // Folder
} // End: New

// Start: Modify
if (isset($page) && $page=="modify" && isset($what)) {
	if ($what=="category" && isset($catid)) { // Edit Category
		$Edit=gaMyFetch("SELECT * FROM gaCategories WHERE ID=$catid;");
		$ResultHtml=gaHeading("Edit Category",1)."Use categories to organize your Media Folders<br><br>
		<div align=center>
		<table border='0' cellspacing='1' cellpadding='2' bgcolor='".$EasyGallery["DarkColor"]."' width=200>
		<tr>
			<td>&nbsp;<font color=".$EasyGallery["Background"]."><b>.: Category Information</b></font></td>
		</tr>
		".gaElement("form",$PHP_SELF,"Login","POST")."
		<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Name:</b> Max 255 chars<br>
			".gaElement("text","gaDisplayName",$Edit["DisplayName"],150)."</td>
		</tr>
		<tr>
			<td align=right>".gaElement("submit","Create","f_button")."</td>
		</tr>".
		gaElement("hidden","catid",$catid).gaElement("hidden","action","update_category").gaElement()."
		</table>
		".$Error;
	} // Category
	if ($what=="folder" ) { // Edit Folder
		$Edit=gaMyFetch("SELECT * FROM gaMediaFolders WHERE ID=$folid;");
		$CatSelects=gaMyQuery("SELECT * FROM gaCategories ORDER BY DisplayName;");
		while ($CatSelect=mysql_fetch_array($CatSelects)) {
			$Categories[$CatSelect["ID"]]=$CatSelect["DisplayName"];
		} // while
		$ResultHtml=gaHeading("Edit Folder",1)."Use folders as a picture containers<br><br>
		<div align=center>
		<table border='0' cellspacing='1' cellpadding='2' bgcolor='".$EasyGallery["DarkColor"]."' width=200>
		<tr>
			<td>&nbsp;<font color=".$EasyGallery["Background"]."><b>.: Folder Information</b></font></td>
		</tr>
		".gaElement("form",$PHP_SELF,"Folder","POST").
		"<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Move under:</b><br>
			".gaElement("select","gaGrand",$Categories,$Edit["Grand"],150)."</td>
		</tr>
		<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Name:</b> Max 255 chars<br>
			".gaElement("text","gaFolderName",$Edit["FolderName"],150)."</td>
		</tr>
		<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Description:</b><br>
			".gaElement("text","gaDescription",$Edit["Description"],300)."</td>
		</tr>
		<tr>
			<td align=right>".gaElement("submit","Update","f_button")."</td>
		</tr>".
		gaElement("hidden","folid",$folid).gaElement("hidden","action","update_folder").gaElement()."
		</table>
		".$Error;
	} // Folder
	if ($what=="picture" && isset($picid)) { // Edit Picture
		$Edit=gaMyFetch("SELECT * FROM gaPictures WHERE ID=$picid;");
		$ResultHtml=gaHeading("Edit Picture",1)."Your pictures on the net<br><br>
		<div align=center>
		<table border='0' cellspacing='1' cellpadding='2' bgcolor='".$EasyGallery["DarkColor"]."' width=200>
		<tr>
			<td>&nbsp;<font color=".$EasyGallery["Background"]."><b>.: Picture Information</b></font></td>
		</tr>
		".gaElement("form",$PHP_SELF,"Login","POST")."
		<tr>
			<td align=center bgcolor=".$EasyGallery["LightColor1"].">".gaShowPicture($Edit)."</td>
		</tr>
		<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Description:</b><br>
			".gaElement("text","gaDescription",$Edit["Description"],150)."</td>
		</tr>
		<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Date:</b><br>
			".gaElement("text","gaDate",$Edit["Date"],150)."</td>
		</tr>
		<tr>
			<td align=right>".gaElement("submit","Update","f_button")."</td>
		</tr>".
		gaElement("hidden","catid",$catid).gaElement("hidden","folid",$folid).gaElement("hidden","picid",$picid).gaElement("hidden","action","update_picture").gaElement()."
		</table>
		".$Error;
	} // Picture
} // End: Modify

// Start: Choose Picture
if (isset($page) && $page=="choosefront" && isset($for)) {
	if ($for=="category" && isset($catid)) { // Category
		$ResultHtml=gaHeading("\"".gaGetByID("gaCategories","DisplayName",$catid)."\" Category",1).
		"Click on a picture to become Category Cover<br><br>";
		if (!isset($from)) $from=0;
		$TotalPictures=mysql_num_rows(gaMyQuery("SELECT * FROM gaMediaFolders as t1, gaPictures as t2 WHERE t1.Grand=$catid AND t2.Folder=t1.ID;"));
		$Choices=gaMyQuery("SELECT * FROM gaMediaFolders as t1, gaPictures as t2 WHERE t1.Grand=$catid AND t2.Folder=t1.ID LIMIT $from,".$EasyGallery["pics_per_page"].";");
		while ($Choose=mysql_fetch_array($Choices)) {
			$ResultHtml.="<a href='$PHP_SELF?action=set_category_picture&pic=".$Choose["PictureFile"]."&catid=$catid'>".gaShowPicture($Choose)."</a> ";
		} // while
		$ResultHtml.= "<br><br><div align=center>";
		if ($from!=0) $ResultHtml.= "<a href='$PHP_SELF?page=choosefront&for=category&catid=$catid&from=".($from-$EasyGallery["pics_per_page"])."'><img src='prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
		if ($TotalPictures>$from+$EasyGallery["pics_per_page"]) $ResultHtml.= "<a href='$PHP_SELF?page=choosefront&for=category&catid=$catid&folid=$folid&from=".($from+$EasyGallery["pics_per_page"])."'><img src='next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
		$ResultHtml.= "</div>";
	} // Category
	if ($for=="folder" && isset($folid)) { // Folder
		$ResultHtml=gaHeading("\"".gaGetByID("gaMediaFolders","FolderName",$folid)."\" Media Folder",1).
		"Click on a picture to become Media Folder Cover<br><br>";
		if (!isset($from)) $from=0;
		$TotalPictures=mysql_num_rows(gaMyQuery("SELECT * FROM gaPictures WHERE Folder=$folid;"));
		$Choices=gaMyQuery("SELECT * FROM gaPictures WHERE Folder=$folid LIMIT $from,".$EasyGallery["pics_per_page"].";");
		while ($Choose=mysql_fetch_array($Choices)) {
			$ResultHtml.="<a href='$PHP_SELF?action=set_folder_picture&pic=".$Choose["PictureFile"]."&folid=$folid'>".gaShowPicture($Choose)."</a> ";
		} // while
		$ResultHtml.= "<br><br><div align=center>";
		if ($from!=0) $ResultHtml.= "<a href='$PHP_SELF?page=choosefront&for=folder&folid=$folid&from=".($from-$EasyGallery["pics_per_page"])."'><img src='prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
		if ($TotalPictures>$from+$EasyGallery["pics_per_page"]) $ResultHtml.= "<a href='$PHP_SELF?page=choosefront&for=folder&folid=$folid&folid=$folid&from=".($from+$EasyGallery["pics_per_page"])."'><img src='next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
		$ResultHtml.= "</div>";
	} // Category
} // End: Choose Picture

// Start: Upload
if (isset($page) && $page=="upload") {
		$CatSelects=gaMyQuery("SELECT t1.ID as FID, t1.FolderName, t2.DisplayName FROM gaMediaFolders as t1, gaCategories as t2 WHERE t2.ID=t1.Grand ORDER BY t2.DisplayName, t1.FolderName;");
		while ($CatSelect=mysql_fetch_array($CatSelects)) {
			$Categories[$CatSelect["FID"]]=$CatSelect["DisplayName"]." > ".$CatSelect["FolderName"];
		} // while
		if (!isset($EasyGallery["upload_fields"])) $EasyGallery["upload_fields"]=10;
		$ResultHtml=gaHeading("Upload pictures",1)."Your pictures on the net<br><br>
		<div align=center>
		<table border='0' cellspacing='1' cellpadding='2' bgcolor='".$EasyGallery["DarkColor"]."' width=200>
		<tr>
			<td>&nbsp;<font color=".$EasyGallery["Background"]."><b>.: Upload Information</b></font></td>
		</tr>
		".gaElement("form",$PHP_SELF,"Upload","POST","enctype='multipart/form-data'").
		"<tr>
			<td bgcolor=".$EasyGallery["Background"]."><b>Upload under:</b><br>
			".gaElement("select","gaFolder",$Categories,$folid,300)."</td>
		</tr>";
		for ($pics=0; $pics<$EasyGallery["upload_fields"]; $pics++) {
			$ResultHtml.= "<tr>
			<td bgcolor=".$EasyGallery["Background"]." align=right><b>".($pics+1).".</b>
			".gaElement("file","files".$pics,"",280)."</td>
		</tr>";
		} // for
		$ResultHtml.="<tr>
			<td bgcolor=".$EasyGallery["Background"]." align=center>
			".gaElement("checkbox","turn","yes")." After upload go to the upload folder</td>
			</tr>
		<tr>
			<td align=right>".gaElement("submit","Upload","f_button")."</td>
		</tr>".
		gaElement("hidden","MAX_FILE_SIZE",(1024*1024*1024)).gaElement("hidden","action","upload").gaElement()."
		</table>
		".$Error."<br>* <b>Note</b>: Upload speed depends on your Internet connection speed.<br>You may need to wait for a while after pressing the Upload button.<br><i>You <b>do not</b> need to fill all fields.</i></div>";
} // End: Upload

// Start: Reindex
if (isset($page) && $page=="reindex") {
	$CatSelects=gaMyQuery("SELECT * FROM gaCategories ORDER BY DisplayName;");
	while ($CatSelect=mysql_fetch_array($CatSelects)) {
		$Categories[$CatSelect["ID"]]=$CatSelect["DisplayName"];
	} // while
	$Dirs=getDirList($EasyGallery["media_folder"]."/");
	$ResultHtml=gaHeading("Reindex",1)."Searches for new pictures, uploaded via FTP<br><br>
	<div align=center>
	<table border='0' cellspacing='1' cellpadding='2' bgcolor='".$EasyGallery["DarkColor"]."' width=200>
	<tr>
		<td>&nbsp;<font color=".$EasyGallery["Background"]."><b>.: Reindex Information</b></font></td>
	</tr>
	".gaElement("form",$PHP_SELF,"Folder","POST").
	"<tr>
		<td bgcolor=".$EasyGallery["Background"]."><b>Found Directories:</b><br>
		".gaElement("select","gaDir",$Dirs,"",150)."</td>
	</tr>
	<tr>
		<td bgcolor=".$EasyGallery["Background"]."><b>Move under:</b><br>
		".gaElement("select","gaGrand",$Categories,$Edit["Grand"],150)."</td>
	</tr>
	<tr>
		<td bgcolor=".$EasyGallery["Background"]."><b>Name:</b> Max 255 chars<br>
		".gaElement("text","gaFolderName",$Edit["FolderName"],150)."</td>
	</tr>
	<tr>
		<td bgcolor=".$EasyGallery["Background"]."><b>Description:</b><br>
		".gaElement("text","gaDescription",$Edit["Description"],300)."</td>
	</tr>
	<tr>
		<td align=right>".gaElement("submit","Start","f_button")."</td>
	</tr>".
	gaElement("hidden","action","reindex").gaElement()."
	</table><div align=center>This is a slow procedure. You may wait for a while - depending on picture sizes.</div>
	".$Error;
} // End: Reindex

// Start: Folders View
if (isset($page) && $page=="category" && isset($catid)) {
	$ResultHtml=gaHeading(gaGetByID("gaCategories","DisplayName",$catid)." Folders",1).
	"<b>Navigation </b><img src='menu_itema.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF' class=normal>Categories</a>
	<img src='menu_itema.gif' width='9' height='8' alt='' border='0'>".gaGetByID("gaCategories","DisplayName",$catid)." Folders<br><br>";
	if (!isset($from)) $from=0;
	$TotalFolders=mysql_num_rows(gaMyQuery("SELECT ID FROM gaMediaFolders WHERE Grand=$catid;"));
	$Folders=gaMyQuery("SELECT * FROM gaMediaFolders WHERE Grand=$catid ORDER BY FolderName LIMIT $from,".$EasyGallery["cats_per_page"].";");
	$ResultHtml.= "<br><table border=0 cellspacing=3 align=center>";
	$i=0;
	while ($Folder=mysql_fetch_array($Folders)) {
	$i++;
		if ($i==1) echo "<tr>";
		$ResultHtml.= "<td align=center width=130 valign=top><a href='$PHP_SELF?page=folder&catid=$catid&folid=".$Folder["ID"]."' class=normal>
		".gaShowPicture($Folder)."</a><br>";
		if (gaRegistered($Stoitsov)==2) {
			$toDelete=0;
			$toDelete=mysql_num_rows(gaMyQuery("SELECT ID FROM gaPictures WHERE Folder=".$Folder["ID"].";"));
			$ResultHtml.="<a href='$PHP_SELF?page=choosefront&for=folder&folid=".$Folder["ID"]."'><img src='picture.gif' width='60' height='14' alt='Select Picture for this Folder' border='0'></a>".
			"<a href='$PHP_SELF?page=modify&what=folder&folid=".$Folder["ID"]."'><img src='modify.gif' width='60' height='14' alt='Modify this Folder' border='0'></a><br>".
			($toDelete!=0 ? "" : "<a href=\"#\" onClick=\"javascript:YesNo('$PHP_SELF?action=delete_folder&folid=".$Folder["ID"]."','Are you sure you want to delete?');\"><img src='delete.gif' width='60' height='14' alt='Delete this Folder' border='0'></a><br>" )."
			";
		} // if
		$ResultHtml.="<a href='$PHP_SELF?page=folder&catid=$catid&folid=".$Folder["ID"]."' class=normal><b>".$Folder["FolderName"]."</b><br><i>".$Folder["Description"]."</i></a></td>";
		if ($i==4) { $ResultHtml.= "</tr>"; $i=0; }
	} // while
	if ($i!=0) {
		for ($m=$i; $m<4; $m++) $ResultHtml.= "<td>&nbsp;</td>";
		$ResultHtml.= "</tr>";
	}
	$ResultHtml.= "<tr><td colspan=4 align=center><br>";
	if ($from!=0) $ResultHtml.= "<a href='$PHP_SELF?page=category&catid=$catid&from=".($from-$EasyGallery["cats_per_page"])."'><img src='prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
	if ($TotalFolders>$from+$EasyGallery["cats_per_page"]) $ResultHtml.= "<a href='$PHP_SELF?page=category&catid=$catid&from=".($from+$EasyGallery["cats_per_page"])."'><img src='next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
	$ResultHtml.= "</td></tr></table>".$Error;
}
// End: Folders View

// Start: Pictures View
if (isset($page) && $page=="folder" && isset($catid) && isset($folid) ) {
	$ResultHtml=gaHeading(gaGetByID("gaMediaFolders","FolderName",$folid)." Pictures",1).
	"<b>Navigation </b><img src='menu_itema.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF' class=normal>Categories</a>
	<img src='menu_itema.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF?page=category&catid=$catid' class=normal>".gaGetByID("gaCategories","DisplayName",$catid)."</a>
	<img src='menu_itema.gif' width='9' height='8' alt='' border='0'>".gaGetByID("gaMediaFolders","FolderName",$folid)." Pictures
	<br><br>";
	if (!isset($from)) $from=0;
	$TotalPictures=mysql_num_rows(gaMyQuery("SELECT ID FROM gaPictures WHERE Folder=$folid;"));
	$Pictures=gaMyQuery("SELECT * FROM gaPictures WHERE Folder=$folid ORDER BY ".$QryOrder." LIMIT $from,".$EasyGallery["pics_per_page"].";");
	$ResultHtml.= "<br><table border=0 cellspacing=3 align=center>";
	if (gaRegistered($Stoitsov)==2) {
		$ResultHtml.=gaElement("form",$PHP_SELF,"POST");
		$CatSelects=gaMyQuery("SELECT t1.ID as FID, t1.FolderName, t2.DisplayName FROM gaMediaFolders as t1, gaCategories as t2 WHERE t2.ID=t1.Grand ORDER BY t2.DisplayName, t1.FolderName;");
		while ($CatSelect=mysql_fetch_array($CatSelects)) {
			$Categories[$CatSelect["FID"]]=$CatSelect["DisplayName"]." > ".$CatSelect["FolderName"];
		} // while
	} // if
	$i=0;
	while ($Picture=mysql_fetch_array($Pictures)) {
		$i++;
		if ($i==1) echo "<tr>";
		$picSize=split("x",substr($Picture["PictureSize"],0,strlen($Picture["PictureSize"])-3));
		$picW=$picSize[0]; $picH=$picSize[1];
		$ResultHtml.= "<td align=center width=130 valign=top><a href='#' OnClick=\"javascript:PicWindow('$PHP_SELF?picture=".$Picture["ID"]."',$picW,$picH);\" class=normal>
		".gaShowPicture($Picture)."</a><br>";
		if (gaRegistered($Stoitsov)==2) {
			$ResultHtml.="<a href='$PHP_SELF?page=modify&what=picture&picid=".$Picture["ID"]."&catid=$catid&folid=$folid'><img src='modify.gif' width='60' height='14' alt='Modify this Picture' border='0' align=left hspace=5></a> <input type=checkbox name=pics[] value=".$Picture["ID"].">Select<br>";
		}
		$ResultHtml.="<a href='#' OnClick=\"javascript:PicWindow('$PHP_SELF?picture=".$Picture["ID"]."',$picW,$picH);\" class=normal>".
		$Picture["Description"]."<br>".$Picture["PictureSize"]."<br>".$Picture["FileSize"]."kb ".$Picture["Date"]."</a></td>";
		if ($i==4) { $ResultHtml.= "</tr>"; $i=0; }
	} // while
	if ($i!=0) {
		for ($m=$i; $m<4; $m++) $ResultHtml.= "<td>&nbsp;</td>";
		$ResultHtml.= "</tr>";
	}
	if (gaRegistered($Stoitsov)==2) {
	$ResultHtml.= "<tr>
		<td colspan=2 align=center bgcolor='".$EasyGallery["LightColor1"]."'>".gaElement("select","gaFolder",$Categories,$folid,200)." <input type=submit name=move value='Move' class=f_text></td>
		<td colspan=2 align=center bgcolor='".$EasyGallery["LightColor1"]."'><input type=submit name=delete value='Delete' class=f_text></td>".
		gaElement("hidden","catid",$catid).gaElement("hidden","folid",$folid).
		gaElement("hidden","action","pictures").gaElement()."</tr>";
	}
	$ResultHtml.= "<tr><td colspan=4 align=center><br>";
	if ($from!=0) $ResultHtml.= "<a href='$PHP_SELF?page=folder&catid=$catid&folid=$folid&from=".($from-$EasyGallery["pics_per_page"])."'><img src='prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
	if ($TotalPictures>$from+$EasyGallery["pics_per_page"]) $ResultHtml.= "<a href='$PHP_SELF?page=folder&catid=$catid&folid=$folid&from=".($from+$EasyGallery["pics_per_page"])."'><img src='next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
	$ResultHtml.= "</td></tr></table>".$Error;
}
// End: Pictures View

// Start: Search View
if (isset($page) && $page=="search" && isset($search)) {
	$search=gaHackers($search);
	$ResultHtml=gaHeading("Search Results",1).
	"Searched for: <b>$search</b><br><br>";
	if (!isset($from)) $from=0;
	$TotalPictures=mysql_num_rows(gaMyQuery("SELECT ID FROM gaPictures WHERE Description like '%".$search."%';"));
	$Pictures=gaMyQuery("SELECT * FROM gaPictures WHERE Description like '%".$search."%' ORDER BY ".$QryOrder." LIMIT $from,".$EasyGallery["pics_per_page"].";");
	$ResultHtml.= "<br><table border=0 cellspacing=3 align=center>";
	$i=0;
	while ($Picture=mysql_fetch_array($Pictures)) {
		$i++;
		if ($i==1) echo "<tr>";
		$picSize=split("x",substr($Picture["PictureSize"],0,strlen($Picture["PictureSize"])-3));
		$picW=$picSize[0]; $picH=$picSize[1];
		$ResultHtml.= "<td align=center width=130 valign=top><a href='#' OnClick=\"javascript:PicWindow('$PHP_SELF?picture=".$Picture["ID"]."',$picW,$picH);\" class=normal>
		".gaShowPicture($Picture)."</a><br>";
		$ResultHtml.="<a href='#' OnClick=\"javascript:PicWindow('$PHP_SELF?picture=".$Picture["ID"]."',$picW,$picH);\" class=normal>".
		$Picture["Description"]."<br>".$Picture["PictureSize"]."<br>".$Picture["FileSize"]."kb ".$Picture["Date"]."</a></td>";
		if ($i==4) { $ResultHtml.= "</tr>"; $i=0; }
	} // while
	if ($i!=0) {
		for ($m=$i; $m<4; $m++) $ResultHtml.= "<td>&nbsp;</td>";
		$ResultHtml.= "</tr>";
	}
	$ResultHtml.= "<tr><td colspan=4 align=center><br>";
	if ($from!=0) $ResultHtml.= "<a href='$PHP_SELF?page=search&search=$search&from=".($from-$EasyGallery["pics_per_page"])."'><img src='prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
	if ($TotalPictures>$from+$EasyGallery["pics_per_page"]) $ResultHtml.= "<a href='$PHP_SELF?page=search&search=$search&from=".($from+$EasyGallery["pics_per_page"])."'><img src='next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
	$ResultHtml.= "</td></tr></table>".$Error;
}
// End: Search View


// Start: Main Page (Categories View)
if (strlen($ResultHtml)==0) {
	$ResultHtml=gaHeading("Available Categories",1).
	"<b>Navigation: </b><img src='menu_itema.gif' width='9' height='8' alt='' border='0'>Categories<br><br>";
	if (!isset($from)) $from=0;
	$TotalCategories=mysql_num_rows(gaMyQuery("SELECT ID FROM gaCategories;"));
	$Categories=gaMyQuery("SELECT * FROM gaCategories ORDER BY DisplayName LIMIT $from,".$EasyGallery["cats_per_page"].";");
	$ResultHtml.= "<br><table border=0 cellspacing=3 align=center>";
	$i=0;
	while ($Category=mysql_fetch_array($Categories)) {
	$i++;
                if ($i==1) $ResultHtml.="<tr>";
		$ResultHtml.= "<td align=center width=130 valign=top><a href='$PHP_SELF?page=category&catid=".$Category["ID"]."' class=normal>
		".gaShowPicture($Category)."</а><br>";
		if (gaRegistered($Stoitsov)==2) {
			$toDelete=0;
			$toDelete=mysql_num_rows(gaMyQuery("SELECT ID FROM gaMediaFolders WHERE Grand=".$Category["ID"].";"));
			$ResultHtml.="<a href='$PHP_SELF?page=choosefront&for=category&catid=".$Category["ID"]."'><img src='picture.gif' width='60' height='14' alt='Select Picture for this Category' border='0'></a>".
			"<a href='$PHP_SELF?page=modify&what=category&catid=".$Category["ID"]."'><img src='modify.gif' width='60' height='14' alt='Modify this Category' border='0'></a><br>".
			($toDelete!=0 ? "" : "<a href=\"#\" onClick=\"javascript:YesNo('$PHP_SELF?action=delete_category&catid=".$Category["ID"]."','Are you sure you want to delete?');\"><img src='delete.gif' width='60' height='14' alt='Delete this Category' border='0'></a><br>" )."
			";
		} // if
		$ResultHtml.="<a href='$PHP_SELF?page=category&catid=".$Category["ID"]."' class=normal>".$Category["DisplayName"]."</a></td>";
                if ($i==4) { $ResultHtml.= "</tr>"; $i=0; }
        } // while


	if ($i!=0) {
		for ($m=$i; $m<4; $m++) $ResultHtml.= "<td>&nbsp;</td>";
		$ResultHtml.= "</tr>";
	}
	$ResultHtml.= "<tr><td colspan=4 align=center><br>";
	if ($from!=0) $ResultHtml.= "<a href='$PHP_SELF?from=".($from-$EasyGallery["cats_per_page"])."'><img src='prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
	if ($TotalCategories>$from+$EasyGallery["cats_per_page"]) $ResultHtml.= "<a href='$PHP_SELF?from=".($from+$EasyGallery["cats_per_page"])."'><img src='next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
	$ResultHtml.= "</td></tr></table>".$Error;
}
// End: Main Page

// ********************************************************************
// ********************** BuildMenu
// ********************************************************************
$gaMenu="";
if (gaRegistered($Stoitsov)==2) { // is Admin
	$gaMenu.="<b>Administrator</b><br>
	<img src='menu_item.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF?page=new&what=category' class=normal>New Category</a><br>
	<img src='menu_item.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF?page=new&what=folder&catid=$catid' class=normal>New Folder</a><br>
	<img src='menu_item.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF?page=upload&catid=$catid&folid=$folid' class=normal>Upload new pictures</a><br>
	<img src='menu_item.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF?page=reindex&catid=$catid&folid=$folid' class=normal>Reindex FTP Uploaded</a><br><br>";
}
// Always shown
$gaMenu.="<b>Categories & Folders</b><br>
<img src='menu_item.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF' class=normal>Available Categories</a><br>";
$Categories=gaMyQuery("SELECT * FROM gaCategories ORDER BY DisplayName;");
	while ($Category=mysql_fetch_array($Categories)) {
		$gaMenu.="<img src='menu_item.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF?page=category&catid=".$Category["ID"]."' class=normal><b>".$Category["DisplayName"]."</b></a><br>\n";
		if (isset($catid) && $catid==$Category["ID"]) {
			$Folders=gaMyQuery("SELECT * FROM gaMediaFolders WHERE Grand=$catid ORDER BY FolderName;");
			while ($Folder=mysql_fetch_array($Folders)) {
				$gaMenu.=gaTr(9,8)."<img src='menu_item.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF?page=folder&catid=".$Category["ID"]."&folid=".$Folder["ID"]."' class=normal>".$Folder["FolderName"]."</a><br>\n";
			} // while folder
		} // if folder
	} // while category
$gaMenu.="
<br><b>Picture`s order</b><br>
<img src='menu_item.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF?page=$page&catid=$catid&folid=$folid&From=$From&setgaOrder=0' class=normal>By Date</a><br>
<img src='menu_item.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF?page=$page&catid=$catid&folid=$folid&&From=$From&setgaOrder=1' class=normal>By Description</a><br>
<img src='menu_item.gif' width='9' height='8' alt='' border='0'><a href='$PHP_SELF?page=$page&catid=$catid&folid=$folid&&From=$From&setgaOrder=2' class=normal>By Size</a><br><br>
".gaElement("form","$PHP_SELF","SEARCH","GET")."
<b>Search for</b><br>
".gaElement("text","search",$search,100).gaElement("hidden","page","search").gaElement("submit","Go").gaElement()."
<div align=center><a href='http://software.stoitsov.com/free/easygallery/' target=_stoitsov><img src='powergallery90x30.gif' width='90' height='30' alt='Get EasyGallery for free!' border='0'></a></div><br><br>
";


// ********************************************************************
// ********************** HTML Output
// ********************************************************************
//                                You may edit to suit your site design
//   but *please* leave the donation button, link to us  & author names

// Start HTML HEADER
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>
<title>.: EasyGallery - v".$EasyGallery["version"]." :.</title>
<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=windows-1251\">
<META NAME=\"description\" CONTENT=\"EasySoftware - by http://software.stoitsov.com\">
<META NAME=\"author\" CONTENT=\"Idea&minor development - Mario Stoitsov, Script by Cyber/SAS\">
";

// CSS Style - Edit to fit your site design
echo "<style type=\"text/css\">
body {
	font: 11px Arial, Helvetica; color:black;
	background-color: ".$EasyGallery["Background"]."; scrollbar-DarkShadow-Color: ".$EasyGallery["DarkColor"].";
	scrollbar-Track-Color: ".$EasyGallery["DarkColor"]."; scrollbar-Face-Color:	".$EasyGallery["DarkColor"].";
	scrollbar-Shadow-Color:	".$EasyGallery["Background"]."; scrollbar-Highlight-Color: ".$EasyGallery["Background"].";
	scrollbar-3dLight-Color: ".$EasyGallery["DarkColor"]."; scrollbar-Arrow-Color: ".$EasyGallery["Background"].";
}
td {
	font: 11px Arial, Helvetica; color: black;
}
table.main_tbl {
	border: 1px dotted ".$EasyGallery["DarkColor"].";
}
.h1s {
	font: 18px Verdana; font-weight:bold; color: ".$EasyGallery["DarkColor"].";
}
.f_text {
	font: 11px Arial, Helvetica;
	color: black;
	background-color: ".$EasyGallery["Background"].";
	border: 1px dotted ".$EasyGallery["DarkColor"].";
}
.f_button {
	font: 11px Arial, Helvetica;
	color: ".$EasyGallery["Background"].";
	background-color: ".$EasyGallery["DarkColor"].";
	border: 1px solid black;
}
a:link.normal, a:visited.normal {
	font: 11px Arial, Helvetica; color: ".$EasyGallery["DarkColor"]."; text-decoration:none;
}
a:hover.normal {
	font: 11px Arial, Helvetica; color: red; text-decoration:none;
}
</style>
";

// Start HTML BODY
// DO NOT DELETE THESE JAVA SCRIPTS
echo "<script language='JavaScript'>
// Outputs a window with selected Picture
// Cyber/SAS JavaScript (c)
function PicWindow(fUrl,W,H) {	W=W+60; H=H+130;	if (H>700) H=700;	var X=(screen.availWidth - W) / 2,Y=(screen.availHeight - H - 40) / 2;	w = window.open(fUrl, 'fUrl', 'left=' + X + ',top=' + Y + ',width=' + W + ',height=' + H +',scrollbars=yes');	w.opener=self; } </script>
<script language='JavaScript'>function YesNo(fURL,fMessage) {	if (confirm(fMessage)) { self.top.location.href=fURL; } }</script>\n
</head>";


if (isset($picture)) { // pop up picture only
		$Picture=gaMyFetch("SELECT * FROM gaPictures WHERE ID=$picture;");
		$size=getimagesize($EasyGallery["media_folder"]."/".$Picture["PictureFile"]);
		echo "<table border=0 cellspacing=0 cellpadding=0 width=100% height=96%><tr><td align=center>".
		"<table border=0 cellspacing=1 cellpadding=2 width=1 bgcolor=".$EasyGallery["DarkColor"].">\n".
		"<tr><td colspan=3 bgcolor=".$EasyGallery["DarkColor"]."><font color=".$EasyGallery["LightColor1"]."><b>Picture \"".$Picture["Description"]."\"</b></font></td></tr>".
		"<tr><td colspan=3 bgcolor=".$EasyGallery["LightColor1"]."><a href='javascript:window.close();'>
		<img src=\"".$EasyGallery["media_folder"]."/".$Picture["PictureFile"]."\" ".$size[3]." alt=\"".$Picture["FileSize"]." kb\" border=\"0\"></a><br></td></tr>".
		"<tr><td colspan=3 align=center><font color=".$EasyGallery["LightColor1"]."><b>".$Picture["Description"]."</b></font></td></tr>\n".
		"<tr><td bgcolor=".$EasyGallery["LightColor1"]." align=center>".$Picture["Date"]."</td><td bgcolor=".$EasyGallery["LightColor1"]." align=center>".$Picture["PictureSize"]."</td><td bgcolor=".$EasyGallery["LightColor1"]." align=center>".$Picture["FileSize"]." kb</td></tr>".
		"<tr><td colspan=3 bgcolor=".$EasyGallery["LightColor1"]." align=center><a href='javascript:window.close();' class=normal>Close Picture</a></td></tr>\n";
		"</table></td></tr></table>";
	echo "</body></html>";
	exit;
} // end Picture

echo "<body leftmargin='0' rightmargin='0' topmargin='0' rightmargin='0' background='bg.gif'>
<table border='0' cellspacing='0' cellpadding='0' width='100%'>
	<tr>
		<td><a href='$PHP_SELF'><img src='logo.jpg' width='201' height='84' alt='EasyGallery' border='0'></a><br></td>
		<td><img src='logo_right.jpg' width='199' height='84' alt='' border='0'><br></td>
		<td width=100% background='top_repeat.gif'>".gaTr(1,84)."<br></td>
		<td valign=top align=right><a href='http://software.stoitsov.com/free/easygallery/' target=_stoitsov><img src='stoitsov.gif' width='172' height='65' alt='Get more free software!' border='0'></a><br>
		".(gaRegistered($Stoitsov)==2 ? "<a href='$PHP_SELF?action=logout' class=normal>Logout</a>" : "<a href='$PHP_SELF?page=login' class=normal>Manage EasyGallery</a>" )."&nbsp;&nbsp;
		</td>
	</tr>
</table>
<table border='0' cellspacing='0' cellpadding='0' width='100%'>
	<tr>
		<td nowrap style=' background: no-repeat top url(menu_top.jpg);' align=center valign=top>".gaTr(201,1)."<br>
			<table border='0' cellspacing='0' cellpadding='0' width='100%'>
				<tr>
					<td>".gaTr(15,1)."<br></td>
					<td width=100%>".$gaMenu."<br></td>
					<td>".gaTr(30,1)."<br></td>
				</tr>
			</table>
		</td>
	<td width=100% valign=top>";

// Output current screen
echo $ResultHtml;

// HTML FOOTER START
echo "</td>
	<td>".gaTr(20,89)."<br></td>
	</tr>
</table>
<br><div align=right><table border='0' cellspacing='0' cellpadding='0' width='50%'>
	<tr>
		<td width='100%' bgcolor='".$EasyGallery["DarkColor"]."'>".gaTr(1,1)."<br></td>
	</tr>
	<tr>
		<td width='100%' align=right><font color='".$EasyGallery["DarkColor"]."'><b>EasyGallery</b> v".$EasyGallery["version"]." is a free software by </font><a href='http://software.stoitsov.com' class=normal target=_stoitsov.com>Stoitsov.com</a>&nbsp;&nbsp;<br>
		<a href='https://www.paypal.com/affil/pal=mario%40stoitsov.com' target=_donate><img src='donate.gif' width='110' height='23' alt='Support us!' border='0' hspace=4 align=right></a>To keep it free & developing:
		</td>
	</tr>
</table></div>
";
// End HTML Output
echo "</body>\n</html>";

/*	******************************************************************
        ********************** EasyGallery v4.30a *************************
	******************************************** software.stoitsov.com  */
