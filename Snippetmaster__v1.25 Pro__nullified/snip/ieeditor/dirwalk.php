<?php
/*+---------------------------------------------------------------------------+
*|	SnippetMaster 
*|	by Electric Toad Internet Solutions, Inc.
*|	Copyright (c) 2002 Electric Toad Internet Solutions, Inc.
*|	All rights reserved.
*|	http://www.snippetmaster.com
*|
*|+----------------------------------------------------------------------------+
*|  Evaluation copy may be used without charge on an evaluation basis for 30 
*|  days from the day that you install SnippetMaster.  You must pay the license 
*|  fee and register your copy to continue to use SnippetMaster after the 
*|  thirty (30) days.
*|
*|  Please read the SnippetMaster License Agreement (LICENSE.TXT) before 
*|  installing or using this product. By installing or using SnippetMaster you 
*|  agree to the SnippetMaster License Agreement.
*|
*|  This program is NOT freeware and may NOT be redistributed in ANY form
*|  without the express permission of the author. It may be modified for YOUR
*|  OWN USE ONLY so long as the original copyright is maintained. 
*|
*|  All copyright notices relating to SnippetMaster and Electric Toad Internet 
*|  Solutions, including the "powered by" wording must remain intact on the 
*|  scripts and in the HTML produced by the scripts.  These copyright notices 
*|  MUST remain visible when the pages are viewed on the Internet.
*|+----------------------------------------------------------------------------+
*|
*|  For questions, help, comments, discussion, etc., please join the
*|  SnippetMaster support forums:
*|
*|       http://www.snippetmaster.com/forums/
*|
*|  You may contact the author of SnippetMaster by e-mail at:
*|	
*|       info@snippetmaster.com
*|
*|  The latest version of SnippetMaster can be obtained from:
*|
*|       http://www.snippetmaster.com/
*|
*|	
*| Are you interested in helping out with the development of SnippetMaster?
*| I am looking for php coders with expertise in javascript and DHTML/MSHTML.
*| Send me an email if you'd like to contribute!
*|
*|
*|+--------------------------------------------------------------------------+

#+-----------------------------------------------------------------------------+
#| 		DO NOT MODIFY BELOW THIS LINE!
#+-----------------------------------------------------------------------------*/
include("../includes/config.inc.php");
include("../includes/ieeditor.inc.php");

// Set language to value passed in and then get translation file.
if (!isset($language)) { $language = $DEFAULT_LANGUAGE; }
if (!@include("$PATH/languages/" . $language . ".php")) { 
	$snippetmaster->returnError("Sorry, but the language you specified (<b>$language</b>) does not 		exist or the language file is invalid.<br><br>The script has been halted until this problem is fixed.  Please provide a language file called <b>$language.php</b>.  (There must be NO php syntax errors in this file.)");
}

/**
   Get the extension of a file. You might want to see objFile.Type too
   In php4, you can use pathinfo() function for this
*/
function get_extension($filename){
  $x=explode(".",strrev($filename));
  return strrev($x[0]);
}
/**
  Utility function. Returns the path minus root folder path
  Also takes out the leading "/"
*/
function cut_root_folder($sub_folder){
	if (strlen($sub_folder) > strlen(ROOTFOLDER)){
		$fld=str_replace(ROOTFOLDER,'',$sub_folder);
		$fld=ereg_replace("^/+","",$fld);
		return $fld;
	} else {
		return "";
	}
}
/**
  Utility function.  check for the existence of a string in an array.
*/
function php3_in_array($str,$arr){
 // in php4, you don't need this function. use in_array instead
 $l=count($arr)-1;
 while($l>=0){
 	if(0==strcmp($str,$arr[$l])){
		return $l;
    }
    $l--;
 }
 return -1;
}
/**
 Utility function. print a file's size
*/
function print_filesize($file){
	$s=filesize($file);
	if($s>1024){
		$s=round($s/1024);
		return "$s Kb";
	}
	if($s>1024*1024){
		$s=round($s/(1024*1024));
		return "$s Mb";
	}
	return "$s b";
}

/**
 print the links at the top to navigate to parent folders
*/
function print_header_links($folder_path){
	global $text;
	//folder path is verified against site root as mild security
	//what if someone passes / or ~?
	global $PHP_SELF;
	if(DEBUG)
		echo "<-- $PHP_SELF : print_header_links('$folder_path') --><br>\n";
    $folder_path = cut_root_folder(ereg_replace("/$","",$folder_path));
	$arr_folders = split("/",$folder_path);
	$prev_folder = "";
	if($folder_path != ""){
		echo '<a href="', $PHP_SELF, '"><img hspace="2" src="icons/openfold.gif" alt="'.$text['close_folder'].'" border="0">/</a>',"\n";
		for($i=0;$i<count($arr_folders); $i++){
			//echo "$i ..$arr_folders[$i]..$prev_folder $arr_folders[$i]<br>\n";
			echo "<br>\n";
			for($x=0;$x<=$i;$x++) echo "&nbsp;";
			if($i==count($arr_folders)-1)
				echo '<img hspace="2" src="icons/openfold.gif" border="0" alt="'.$text['current_folder'].'"><b>', $arr_folders[$i], "</b><br>\n";
			else
				echo '<a href="', $PHP_SELF, '?dir=', urlencode(ereg_replace("^/","","$prev_folder/$arr_folders[$i]")), '"><img hspace="2" src="icons/openfold.gif" border="0" alt="'.$text['close_folder'].'">', $arr_folders[$i], "</a>\n";
            $prev_folder = "$prev_folder/$arr_folders[$i]";
		}
		echo '<b>', $arr_folders[$i], "</b><br>\n";
	}
} // print_header_links end


/**
 display the contents of a directory
*/
function display_directory($dir){
    global $valid_file_types;
	global $PHP_SELF;
	global $text;
	//make link(s) to the parent(s)
	$dir = ereg_replace("/+","/","$dir/"); // squeeze extra slashes
	if(DEBUG)
		echo "<-- $PHP_SELF : display_directory('$dir') --><br>\n";
	print_header_links($dir);
	//Display every file in the folder, that matches
	//the extension given in valid_file_types
	if(!($d=dir($dir))){
		echo "\t Cannot open directory - [$dir]";
		return;
	}
	while($entry=$d->read()){
		if(is_file("$dir/$entry")){
			$ext = get_extension($entry);
			if(0<=php3_in_array($ext,$valid_file_types)){
				echo "<img hspace=\"2\" src=\"icons/$ext.gif\" alt=\"\" border=\"0\">\n";
				//here, it should be a link really
				print_copy_link("$dir/$entry",$entry);
				echo " (",print_filesize("$dir/$entry"),")<br>\n";
			}
		}
	    if (is_dir("$dir/$entry") && $entry!='.' && $entry!='..') {
			printf("<a href=\"%s?dir=%s\">",$PHP_SELF, urlencode(ereg_replace("/+","/",cut_root_folder("$dir/$entry"))));
			printf("<img hspace=\"2\" src=\"icons/closefold.gif\" alt=\"".$text['open_folder']."\" border=\"0\">%s</a><br>\n",$entry);
		}
	}
} // display_directory end

/**
 main process...
*/
function main_process($dir){
	//if a parameter dir is passed, use that
	global $PHP_SELF;
	$dir=ereg_replace(SITEROOT,"",$dir);
	if(!$dir)$dir="";
	$current_folder=ROOTFOLDER."$dir";
	display_directory($current_folder);
}
?>
