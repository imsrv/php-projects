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
*|	installing or using this product. By installing or using SnippetMaster you 
*|  agree to the SnippetMaster License Agreement.
*|
*| 	This program is NOT freeware and may NOT be redistributed in ANY form
*| 	without the express permission of the author. It may be modified for YOUR
*| 	OWN USE ONLY so long as the original copyright is maintained. 
*|
*|	All copyright notices relating to SnippetMaster and Electric Toad Internet 
*|  Solutions, including the "powered by" wording must remain intact on the 
*|  scripts and in the HTML produced by the scripts.  These copyright notices 
*|  MUST remain visible when the pages are viewed on the Internet.
*|+----------------------------------------------------------------------------+
*|
*| 	For questions, help, comments, discussion, etc., please join the
*| 	SnippetMaster support forums:
*|
*|  	    http://www.snippetmaster.com/forums/
*|
*| 	You may contact the author of SnippetMaster by e-mail at:
*|	
*|   	   info@snippetmaster.com
*|
*| 	The latest version of SnippetMaster can be obtained from:
*|
*|   	    http://www.snippetmaster.com/
*|
*|	
*|	Are you interested in helping out with the development of SnippetMaster?
*|	I am looking for php coders with expertise in javascript and DHTML/MSHTML.
*|  Send me an email if you'd like to contribute!
*|
*|
*|+--------------------------------------------------------------------------+

#+---------------------------------------------------------------------------+
#| 		DO NOT MODIFY BELOW THIS LINE!
#+---------------------------------------------------------------------------*/
include("./includes/snippetmaster.inc.php");
if($action == "log_out") {
	$snippetmaster->logOut();
	unset($action);
	unset($session);
}

// Set language to value passed in and then get translation file.
if (!isset($language)) { $language = $DEFAULT_LANGUAGE; }
if (!@include("$PATH/languages/" . $language . ".php")) { 
	$snippetmaster->returnError("Sorry, but the language you specified (<b>$language</b>) does not exist or the language file is invalid.<br><br>The script has been halted until this problem is fixed.  Please provide a language file called <b>$language.php</b>.  (There must be NO php syntax errors in this file.)");
}


if(($action == "view") && (!$session)){	//Was the form submitted from the login?
	if($session = $snippetmaster->checkLogin($user, $pass, $remember)) { //Does session get set (valid user?)
		$html = $snippetmaster->html();
		include("$PATH/templates/main.html");
	} 
	else {	// Session was not set (invalid user)
		$error = 1;

		//Make HTML drop-down box for available languages.
		$dir = opendir("$PATH/languages/");
		while (($file = readdir($dir)) != false) {
		    if ($file != '.' && $file != '..') {
		        $file = ereg_replace('.php', '', $file);
		        if ($language == $file) {
		            $language_options_HTML .= "<option value=\"$file\" SELECTED>$file</option>\n";
		        } else {
		            $language_options_HTML .= "<option value=\"$file\">$file</option>\n";
		        }
		    }
		}
		closedir($dir);

		include("$PATH/templates/login.html");
	}
} 
elseif(($session) || ($snippetmaster->AUTH == 0)) {
	if($action == "Save"){
		if(!strstr($snippetmaster->getname(),"snippetmaster")) { 
			$HTML = $snippetmaster->replaceText($data, $saved_file);
			$snippetmaster->saveText($HTML, $saved_file);
		}
	}
	else if($action == "Preview") {			
		// Set focus on the new window.
		echo '<script language="JavaScript"> document.focus(); </script>';
		// Insert a baseref tag into the page so images will display properly.
		echo '<base href="'.$snippetmaster->getURL($saved_directory).'/">';
		// Insert a button to close preview window.
		echo '<br><center><form><input type="button" value="'.$text['close_preview'].'" onClick="self.close();" name="button"></form></center><HR SIZE="2" WIDTH="100%">';

		// Get text into a variable and then display.
		$HTML = $snippetmaster->replaceText($data, $saved_file);
		echo $HTML;

		exit;
	}

	$html = $snippetmaster->html();
	include("$PATH/templates/main.html");

} 
else {
	//Make HTML drop-down box for available languages.
	$dir = opendir('./languages/');
	while (($file = readdir($dir)) != false) {
	    if ($file != '.' && $file != '..') {
	        $file = ereg_replace('.php', '', $file);
	        if ($language == $file) {
	            $language_options_HTML .= "<option value=\"$file\" SELECTED>$file</option>\n";
	        } else {
	            $language_options_HTML .= "<option value=\"$file\">$file</option>\n";
	        }
	    }
	}
	closedir($dir);

	include("$PATH/templates/login.html");
}


?>
