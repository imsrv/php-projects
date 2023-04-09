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



 class SnippetMaster {

 	var $ROOT;

 	var $PATH;

 	var $PREVIEW;

 	var $URL;

 	var $DIR_IGNORE;

 	var $AUTH;

 	var $USER;

 	var $PASS;

 	var $META;

 	var $TITLE;

 	var $CONVERT;

 	var $HTML;

 	var $EMAIL;

 	var $REPORT;

	var $MESSAGE;



	function set($name, $value){

		$name == "EMAIL" ? $this->checkEmail($value) : "";

		if($name == "URL"){ }

		if($name == "ROOT") $value = $this->removeSlash($value);

		if($name == "PATH") $value = $this->removeSlash($value);

		if($name == "PREVIEW") $value = $this->removeSlash($value);

		if($name == "URL") $value = $this->removeSlash($value);

		if(phpversion() < 4){ $this->returnError("PHP version ".phpversion()." is not supported. (Only PHP versions 4.x are supported.)"); }

		$name == "MESSAGE" ? $this->getsnippet($value) : "";



		$this->$name = $value;

	}



	function checkEmail($var){

		if((!strstr($var, "@")) || (!strstr($var, ".")) || (strlen($var) < 6)) {

			$this->returnError("Invalid email address in \"config.inc.php\" -> $var");



		} else {

			return true;

		}

	}



    function start(){

    	$this->set('FOLDER1', "includes");

    	$this->set('FOLDER2', "templates");

		$this->set('VERSION', "1.2.5");

		$this->getsnippet2("login.html");

    }



	function version(){

		print $this->VERSION;

	}



	function currentYear(){

		$d = getdate();



		return $d[year];

	}

	//function bad1($input,$name){if ($input!=$this->doHash1($name,"r")){$this->bad2($name);exit;}}



	function checkMethod(){

		global $REQUEST_METHOD;

		$method = strtolower($REQUEST_METHOD);



		if($method == "post"){

			return true;

		} else {

			$this->returnError("Invalid request method - ".$REQUEST_METHOD);

		}

	}



	function printVersion(){



		print "\n<!-- SnippetMaster v$this->VERSION -->\n\n";

	}



	/*function useTemplate($var){

		global $error, $remember, $PHP_SELF;

		global $user, $pass, $html, $action;

		global $file, $directory, $HTML;




		$this->printVersion();



		$template = $this->PATH."/".$this->FOLDER2."/".$var;

		// Henri - Sept. 4, 2002 - Removed.  Was causing errors.

		//if(!file_exists($template)){

		//	$this->returnError("The template named \"$template\" does not exist<br>FUNC: useTemplate()");

		//} else {

			include($template);

		//}

	}*/



	function convertStatus($var){

		$status = ($var == 1)?"ON":"OFF";



		return $status;

	}

	function bad2($input){$this->returnError("The License Key specified in your config.inc.php file is not valid for $input. You MUST purchase a license to use SnippetMaster PRO with $input, otherwise you are stealing. A license for SnippetMaster PRO must be purchased for EVERY hostname you want to use the program with.<br><br>Please see the following page for more information:<br><br>http://www.snippetmaster.com/");return;}





    function returnError($msg){

		$yr = $this->currentYear();

		$title = "SnippetMaster v$this->VERSION : SCRIPT ERROR";



    	print "<br<br>$title\n";

		print "<br><br>SnippetMaster was unable to continue due to the following error:\n";

		print "<br><br>$msg<br>\n";



    	$msg = str_replace("<br>", "\n\n", $msg);



    	if($this->REPORT == 1 && $this->EMAIL){

    		$note = "*** You can turn off email error reporting in the config.inc.php file by setting the REPORT variable to 0";

    		mail($this->EMAIL, $title, $title."\n".$this->URL."\n\n".$msg."\n\n\n".$note, "From: ".$this->EMAIL);

    	}



    	exit;

    }



	function createSession() {

		$session = substr("snippetmaster.com.".md5(uniqid(rand())), 0, 30);



		return $session;

	}



	function rememberUser() {

		$session = $this->createSession();

		setcookie("session", $session, time()+31104000);



		return $session;

	}



	function logIn(){

		$session = $this->createSession();

		setcookie("session", $session, 0);



		return $session;

	}



	function logOut(){

		setcookie("session", "", 0);



		return true;

	}



    function checkLogin($user, $pass, $remember) {

		if(($user == $this->USER) && ($pass == $this->PASS)) {

			$session = ($remember == "Y")?$this->rememberUser():$this->logIn();



			return $session;



		} else {

			return false;

		}

	}



	function domain(){

		global $HTTP_HOST;



		$domain = str_replace("www.", "", $HTTP_HOST);



		return $domain;

	}



	function dirValue() {

		global $directory;

		$value = (!$directory)?$this->ROOT:$this->removeSlash($directory);



		return $value;

	}

	//function bad3($input){$this->returnError("Sorry, but the License Key you supplied is not for the RESELLER version of SnippetMaster. You may NOT modify or remove the 'Powered by SnippetMaster PRO' links or copyright information. You are violating your license agreement if you modify or remove this text from the program.<br><br>Your email address and domain name information have been reported to the snippetmaster.com website and you will soon be investigated for copyright violation.<br><br>If you want to remove the copyright and 'Powered by' text, please purchase a RESELLER license.<br><br>Please see the following page for more information:<br><br>http://www.snippetmaster.com/resellers/<br>");return;}





	function getURL($path){

		$result = str_replace($this->ROOT, "", $path);

		$result = $this->PREVIEW.$result;



		return $result;

	}



	function stripURLjunk($URL) {

		$URL = str_replace("http://", "", $URL);

		$URL = str_replace("www.", "", $URL);



		return $URL;

	}







	function message($saved_directory, $file, $action, $saved_file, $url){

		global $text, $language;

		$msg = ($file)?

		'<b>'.$text['no_snippet_tags'].':<br>'.$this->getURL($file).'</b><P ALIGN="LEFT">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$text['proper_usage'].':<P ALIGN="LEFT">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>&lt;SNIPPET NAME="Snippet name here"&gt;</b><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...your HTML code here... <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>&lt;/SNIPPET &gt;</b>'

				:

		       	"<b>".$text['select_file_to_edit']."</b>";



		$msg = ($action == "Save")?

				'<b>'.$text['file_saved'].'</b><br>('.$this->stripURLjunk($this->getURL($saved_file)).')<p><form action="'.$url.'" method="post"><INPUT TYPE="hidden" NAME="language" VALUE="'.$language.'"><input type="hidden" name="file" value="'.$saved_file.'"><input type="hidden" name="directory" value="'.$saved_directory.'"><input type="button" value="'.$text['view_in_new_window_button'].'" onClick="javascript:MM_openBrWindow(\''.$this->getURL($saved_file).'\',\'View\',\'toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=500,height=400\');">&nbsp;<input type="submit" value="'.$text['re-edit_button'].'"></form>'

				:  

				$msg;



		return $msg;

	}



	function is_demo(){

		if(strstr($this->getname(),"snippetmaster")) { 

			echo "alert('The save function is DISABLED for this demo. Your changes will NOT be saved.');";

		}

	}



	function html(){

		global $user, $pass , $session;

		global $directory, $file, $data;

		global $saved_directory, $saved_file, $action, $PHP_SELF;

		//global $LICENSE_KEY;



		$this->getsnippet2("main.html");

		//if ($this->getsnippet($LICENSE_KEY) == false) { $nobody="none"; }

		$html[user] = $user;

		$html[pass] = $pass;

		$html[session] = $session;

		$html[directoryDropDown] = $this->directoryDropDown($directory, $file);

		$html[fileDropDown] = $this->fileDropDown($directory, $file);

		$html[dirValue] = $this->dirValue();

		$html[urldirValue] = $this->stripURLjunk($this->getURL($directory));

		$html[urlValue] = $this->stripURLjunk($this->getURL($file));

		$html[msg] = $this->message($saved_directory, $file, $action, $saved_file, $PHP_SELF);

		$html[data] = ($file)?$this->extractInfo($file) : "";

		$html[dir] = $directory;

		$html[file] = $file;

		$html[convert_status] = $this->convertStatus($this->CONVERT);

		$html[meta_status] = $this->convertStatus($this->META);

		$html[title_status] = $this->convertStatus($this->TITLE);

		$html[html_status] = $this->convertStatus($this->HTML);

		$html[auth] = $this->AUTH;

		$html[meta] = $this->META;

		$html[title] = $this->TITLE;

		$html[path] = $this->PATH;



		return $html;

	}



	function removeSlash($string) {

		$len = strlen($string);

		$lchar = substr($string, ($len-1), 1);



		$result = ($lchar == "/")?substr($string, 0, ($len-1)):$string;



		return $result;

	}



	function fetchDirectory($path, $int) {	// Get the name of the directory using passed path and integer..

   		$dir = split("/", $path);



   		for($x=0; $x<count($dir); $x++){

   			$result[$x]  = $dir[$x];

   			$string .= ($x != count($dir)-1)?$dir[$x]."/":"";

   		}



  	 	if($int==1) { return $result[(count($dir)-1)]; } else { return $this->removeSlash($string); }

	}





	function workingDirectory($directory) {

		global $saved_file;



		$directory = (!$directory)?$this->ROOT:$directory;

   		$directory = urldecode($directory);



   		return $directory;

	}



	function dirIgnore($dir) {	// Is the passed directory in our "ignore" list?

		$ignore = $this->DIR_IGNORE;

		for($x=0; $x<count($ignore); $x++){

			if($ignore[$x] == $dir) {

				return false;

			}

		}



		return true;

	}

	

	function getsnippet($input){$name=$this->getname();if($input!=$this->doHash1($name,"n")){if($input!=$this->doHash1($name,$this->getsnippet1()))$this->bad1($input,$name);else return true;}}



	function directoryDropDown($directory, $file){

		global $text;



		$directory = $this->workingDirectory($directory);



   		if(!@chdir($directory)) $this->returnError("Unable to change directory to <b>$directory</b> (permissions denied).<br>Check your folder and directory permissions, and your ROOT setting in \"config.inc.php\"<br>FUNC: directoryDropDown()");

   		if(!($main = @opendir($directory))) $this->returnError("Unable to open directory.<br>(Permissions denied for $directory)<br>Check your permissions and your ROOT setting in \"config.inc.php\"<br>FUNC: directoryDropDown()");



		$data  = "<select name=\"directory\" onChange=\"javascript:resetMenu1();\" class=\"Form1\">\n";



		if($directory == $this->ROOT) {	// If we're at the top dir, then display domain name.

			//$data .= "<option value=\"$directory\">".$this->domain()."</option>\n";

			//$data .= "<option value=\"$directory\" selected>[Select a folder]</option>\n";

			$data .= "<option value=\"$directory\" selected>[" . $text['folder_drop_down-select_a_folder'] . "]</option>\n";



		} else {

			//$data .= "<option value=\"$directory\">[".$this->fetchDirectory($directory, 1)."] folder</option>\n";

			//$data .= "<option value=\"$directory\">[NO CHANGE]</option>\n";

			//$data .= "<option value=\"".$this->fetchDirectory($directory, 0)."\" selected>[UP ONE LEVEL]</option>\n";

			$data .= "<option value=\"$directory\">[" . $text['folder_drop_down-no_change'] . "]</option>\n";

			$data .= "<option value=\"".$this->fetchDirectory($directory, 0)."\" selected>[" . $text['folder_drop_down-up_one_level'] . "]</option>\n";

		}



   		while($mydir = @readdir($main)) {

   			if((is_dir($mydir)) && ($mydir != ".") && ($mydir != "..") && ($this->dirIgnore($mydir))) {

				$result[] = $mydir;

 			}

   		}



		$result[0] ? @sort($result) : "";



		for($x=0; $x<count($result); $x++){

			$data .= "<option value=\"$directory/$result[$x]\">$result[$x]</option>\n";

		}



		@closedir($main);



		$data .= "</select>\n";



		return $data;

	}



	function containsSnippetTags($file) {

   		if(!file_exists($file)) $this->returnError("The file located at \"$file\" does not exist<br>FUNC: containsSnippetTags()");

		$lines = file($file);

		$count = 0;

		for($x=0; $x<count($lines); $x++){	// For each line in the file..

			

			if (preg_match ("/<SNIPPET/i", $lines[$x])) { //"i" after the pattern delimiter indicates a case-insensitive search

				$count += 1;

   			}



			if (preg_match ("/<\/SNIPPET/i", $lines[$x])) { 

 				$count += 1;

   			}

		}



		if(!($count%2) && $count>0) { 

			return true; // At least one *pair* of valid tags was found.

		} 

		else { 

			return false;	// No valid tags were found, or tags were not in pairs.

		}

	}



	function minimum_php_version( $vercheck ) {

		$minver = explode(".", $vercheck);

		$curver = explode(".", phpversion());

		if (($curver[0] <= $minver[0]) 

			|| (($curver[0] == $minver[0]) && ($curver[1] < $minver[1]))

			|| (($curver[0] == $minver[0]) && ($curver[1] == $minver[1]) && ($curver[2][0] < $minver[2][0])))

			return false;

		else

			return true;

	}     

	function get1snippet($input){$name=$this->getname();if($input!=$this->doHash1($name,$this->getsnippet1()))$this->bad11($input,$name);else return true;}



	function fileDropDown($directory, $file) {

		global $text;



		$directory = $this->workingDirectory($directory);



   		if(!@chdir($directory)) $this->returnError("Unable to change directory to <b>$directory</b> (permissions denied).<br>Check your folder and directory permissions, and your ROOT setting in \"config.inc.php\"<br>FUNC: fileDropDown()");

   		if(!($main = @opendir($directory))) $this->returnError("Unable to open directory.<br>(Permissions denied for $directory)<br>Check your permissions and your ROOT setting in \"config.inc.php\"<br>FUNC: fileDropDown()");



		$data  = "<select name=\"file\" onChange=\"javascript:resetMenu2();\" class=\"Form1\">\n";

		//$data .= "<option value=\"\">Snippets in [".$this->fetchDirectory($directory, 1)."]</option>\n";

		$data .= "<option value=\"\" selected> </option>\n";



   		while($myfile = @readdir($main)) { // For each file in dir..

   			if((is_file($myfile)) && ($myfile != ".") && ($myfile != "..") && ($this->ignoreFile($myfile))) {

   				if($this->containsSnippetTags($myfile)) {	// Check to see if the file has SnippetTags

					$snippet_found = true;

					$result[] = $myfile;

				}

 			}

   		}



		$result[0] ? sort($result) : "";



		for($x=0; $x<count($result); $x++){

			$value = "$directory/$result[$x]";

			//$data .= ($value==$file)?"<option value=\"$value\" selected>":"<option value=\"$value\">";

			$data .= "<option value=\"$value\">";

			$data .= "$result[$x]</option>\n";

		}



		@closedir($main);



		$data .= "</select>\n";



		// Insert some code to replace $data with "No Snippets found." text if no snippets were found.

		if (!$snippet_found) {

			//$data = "(No Snippets found in this folder.)";

			$data = $text['no_snippets_found'];

		}



		return $data;

	}



	function ignoreFile($file) {

		$array = $this->ignoreFileTypes();

		$ext = $this->getFileExtension($file);	// Get the file extension for the passed file.



		for($x=0; $x<count($array); $x++){	// Check to see if extension matches a filetype we want to ignore.

			if($array[$x] == $ext){

				return false;

			}

		}



		return true;

	}



	function bad11($input,$name){if($input!=$this->doHash1($name,"r")){return false;}}



	function getFileExtension($file) {

		$var = explode(".", $file);

	   	$size = (sizeof($var)-1);

	   	$ext = $var[$size];



	   	!$ext ? $this->returnError("Cannot retrieve file extension for file \"$file\"<br>FUNC: getFileExtension()") : "";



	   	return $ext;

	}



	function ignoreFileTypes() {

		$array = array(

					   "htaccess",

					   "htpasswd",

					   "htgroup",

					   "bmp",

					   "gif",

					   "jpg",

					   "png",

					   "tif",

					   "tiff",

					   "psp",

					   "psd",

					   "doc",

					   "wps",

					   "bak",

					   "bk",

					   "zip",

					   "gz",

					   "xls",

					   "ppt",

					   "csv",

					   "pdf",

					   "jbf",

					   "tem",

					   "tmp",

					   "c",

					   "h",

					   "ico",

					   "log",

					   "epc",

					   "dat",

					   "bat",

					   "db",

					   "sts",

					   "conf",

					   "ini",

					   "cpp",

					   "dev",

					   "o",

					   "rc"

					   );



		return $array;

	}



	function twoDigit($int) {

		$int = ($int<10)?str_replace("0", "", $int):$int;

		$int = ($int<10)?"0$int":$int;



		return $int;

	}



	function getsnippet2($file)
		{
		global $PATH,$LICENSE_KEY;
		$filename="$PATH/templates/$file";
		$fd=fopen($filename,'r');
		$contents=fread($fd,filesize($filename));
		fclose($fd);
		//$string='<A HREF="http://www.snippetmaster.com/" TARGET="_blank"';if ((!stristr($contents,$string)) and (!$this->get1snippet($LICENSE_KEY))){$this->bad3($string);}return;
		}



	function doHash2($input,$type){$input=md5("Henri".md5($input)."was"."here");return $input;}



 	function dateToday() {

		$d = getdate();

		$date = "$d[month] ".$this->twoDigit($d[mday]).", $d[year] @ ".$this->twoDigit($d[hours]).":".$this->twoDigit($d[minutes]);

		return $date;

	}



	function compressText($string){

   		global $breaks;



      	$string = str_replace("  ", " ", $string);

      	$string = str_replace("\t", "", $string);

      	$string = str_replace("\r\n", " ", $string);

      	$string = ($this->CONVERT == 1)?str_replace("<br> ", "\n", $string):str_replace("<br> ", "<br>\n", $string);

      	$string = ($this->CONVERT == 1)?str_replace("<br>", "\n", $string):str_replace("<br>", "<br>\n", $string);

      	$string = chop($string);



		return $string;

	}



	function getTextBoxSize($string) {	// We want to determine the size of our text area box,



		// Count the number of characters in the snippet and divide by size of edit textbox.



		$size = round(strlen($string) / 75 + 2);

		

		// Count the number of linebreaks in the string.

		$linebreaks = substr_count($string, "\r"); 

		$linebreaks = $linebreaks + substr_count($string, "\n");



		if($size < $linebreaks) { $size = $linebreaks + 1; }



		return $size;

	}

	function doHash1($input,$type){$input=md5($this->doHash2($input,$type));if($type=="r"){$input=$this->doHashR($input,$type);}	return $input;}





	function extractText($begin, $end, $file){

		$this->checkMethod();

   		if(!file_exists($file)) $this->returnError("The file located at \"$file\" does not exist<br>FUNC: extractText()");

	   	$lines = file($file);

	   	$start = $begin;



		// Put contents of file array into a string.

		while($start < $end) {



			$string .= str_replace("\n", "\n", $lines[$start]);

	   	 	$start++;

	   	}



	   	$result[size_of_textbox] = $this->getTextBoxSize($string);	// Get size of textbox to use.



		$result[page_text] = stripslashes($string);



	   	$result[begin_line] = $begin;

	   	$result[end_line] = $end;

	   	$result[page_text] = $this->compressText($result[page_text]);



	   	return $result;

	}



	function extractInfo($path){

		$this->checkMethod();

   		if(!file_exists($path)) $this->returnError("The file located at \"$path\" does not exist<br>FUNC: extractInfo()");

   		$lines = file($path);



   		for($x=0; $x<count($lines); $x++) {

   			if(strstr(strtolower($lines[$x]), "<title")){

   				$lines[$x] = str_replace("<title>", "", strtolower($lines[$x]));

   				$lines[$x] = str_replace("</title>", "", strtolower($lines[$x]));

   				$result[page_title] = str_replace("\r\n", "", chop($lines[$x]));

   				$result[title_line] = $x;

   			}



   			if(strstr(strtolower($lines[$x]), "<meta")){

   				$lines[$x] = stripslashes($this->compressText($lines[$x]));

   				if(strstr(strtolower($lines[$x]), "name=description") || strstr(strtolower($lines[$x]), "name=\"description\"") || strstr(strtolower($lines[$x]), "name='description'")){

   					$lines[$x] = str_replace("<meta name=\"description\" content=", "", strtolower($lines[$x]));

    	 			$lines[$x] = str_replace("<meta name=description content=", "", strtolower($lines[$x]));

    	 			$lines[$x] = str_replace("<meta name='description' content=", "", strtolower($lines[$x]));

   					$lines[$x] = str_replace("\"", "", $lines[$x]);

   					$lines[$x] = str_replace("'", "", $lines[$x]);

   					$lines[$x] = str_replace(">", "", $lines[$x]);

   					$result[meta_description] = stripslashes(chop($lines[$x]));

   					$result[description_line] = $x;

   				}



   				if(strstr(strtolower($lines[$x]), "name=keywords") || strstr(strtolower($lines[$x]), "name=\"keywords\"") || strstr(strtolower($lines[$x]), "name='keywords'")){

   					$lines[$x] = str_replace("<meta name=\"keywords\" content=", "", strtolower($lines[$x]));

    	 			$lines[$x] = str_replace("<meta name=keywords content=", "", strtolower($lines[$x]));

    	 			$lines[$x] = str_replace("<meta name='keywords' content=", "", strtolower($lines[$x]));

   					$lines[$x] = str_replace("\"", "", $lines[$x]); #"

   					$lines[$x] = str_replace("'", "", $lines[$x]);

   					$lines[$x] = str_replace(">", "", $lines[$x]);

   					$result[meta_keywords] = chop($lines[$x]);

   					$result[keywords_line] = $x;

   				}

   			}



			if (preg_match ("/<SNIPPET/i", $lines[$x])) { // Find the opening snippet tag.



				if(preg_match('/NAME="(.+?)"/i', $lines[$x], $match)) { // Is there a name for this snippet?

					$result[snippet_name][$i] = $match[1];

				}



				//echo $result[snippet_name][$i]; exit;



				// Mark next line as beginning of editable text

   				$begin = ($x+1);

   			}



			if (preg_match ("/<\/SNIPPET/i", $lines[$x])) {   // Determine line number of end of editable area.

   				$end = $x;

   			}



			$i = (!$i)?"0":$i;

			if(($begin) && ($end)) {

				

				$tmp = $this->extractText($begin, $end, $path);

				unset($begin);

				unset($end);

			   	$result[size_of_textbox][$i] = $tmp[size_of_textbox];

				$result[begin_line][$i] = $tmp[begin_line];

				$result[end_line][$i] = $tmp[end_line];

				$result[page_text][$i] = $tmp[page_text];



				$i++;

			}

		}



		$result[box_count] = $i;



   		return $result;

	}

	function getsnippet1(){global $PATH;$string='<A HREF="http://www.snippetmaster.com/" TARGET="_blank"';$filename="$PATH/templates/main.html";$fd=fopen($filename,'r');$contents1=fread($fd,filesize($filename));fclose($fd);$filename="$PATH/templates/login.html";$fd=fopen($filename,'r');$contents2=fread($fd,filesize($filename));fclose($fd);if((!stristr($contents1,$string)) or (!stristr($contents2,$string))){return "r";}else{return "n";}}







	function replaceText($data, $file){

		global $HTTP_HOST;



   		if(!file_exists($file)) $this->returnError("The file located at \"$file\" does not exist <br>FUNC: replaceText()");



   		$lines = file($file);

   		$count = (count($lines)+2);



   		for($i=0; $i<$count; $i++){

   			$x = (!$x)?"0":$x;

   			if(($i >= $data[begin_line][$x]) && ($i <= $data[end_line][$x])){

				while($data[begin_line][$x] < $data[end_line][$x]) {

					unset($lines[$data[begin_line][$x]]);

   				 	$data[begin_line][$x]++;

   				}



				$data[page_text][$x] = ($this->HTML == 1)?$data[page_text][$x]:@htmlspecialchars($data[page_text][$x]);

   				$lines[$i] = ($this->CONVERT == 1)?stripslashes(str_replace("\n", "<br>", $data[page_text][$x]))."\n":stripslashes($data[page_text][$x])."\n";

   				$x++;

   			}



   			if(($this->META == 1) && ($i == $data[keywords_line])){

   				if(!strstr(strtolower($lines[$i]), "<meta")) {

   					$tmp1 = $lines[$i];

   					unset($lines[$i]);

   				}



   				$lines[$i] = "<meta name=\"keywords\" content=\"".stripslashes($data[meta_keywords])."\">\n";

   			}



   			if(($this->META == 1) && ($i == $data[description_line])){

   				if(!strstr(strtolower($lines[$i]), "<meta")) {

   					$tmp2 = $lines[$i];

   					unset($lines[$i]);

   				}



   				$lines[$i]  = "<meta name=\"description\" content=\"".stripslashes($data[meta_description])."\">\n";

   				if($tmp1) $lines[$i] .= $tmp1."\n";

   				if($tmp2) $lines[$i] .= $tmp2;

   			}



   			if(($this->TITLE == 1) && ($i == $data[title_line])){

   				if(strstr(strtolower($lines[$i]), "<title")) unset($lines[$i]);

   				$lines[$i] .= "<title>".stripslashes($data[page_title])."</title>\n";

   			}

   		}



		//if(strstr($lines[0], "- last update")) unset($lines[0]);

   		//$mydata = "<!-- Last SnippetMaster Update Was On ".$this->dateToday()." -->\r\n";

		//fwrite($fp, $mydata);



		// Now let's put the array into a regular string variable.

		for($i=0; $i<$count; $i++){

   			$HTML .= $lines[$i];

		}

		

		return $HTML;

	}

	function doHashR($input,$type){$input=$type.md5(md5($input));return $input; }



	function saveText($HTML, $file) {



   		if(!file_exists($file)) $this->returnError("The file located at \"$file\" does not exist. <br>FUNC: saveText()");



   		if(!($fp = @fopen($file, "w"))) $this->returnError("There was an error opening <b>$file</b><br>Please check permissions for that directory and file, so that they have necessary read and write permissions.<br>FUNC: saveText()");



		fwrite($fp, $HTML);

		fclose($fp);



    	//

		//$helpURL = "http://www.electrictoad.com/users/index.php?email=$this->EMAIL&url=$HTTP_HOST";

    	//$fp = @fopen($helpURL, "r");

    	//@fclose($fp);



	}



	function getname(){if($this->minimum_php_version("4.1.0")){$name=$_SERVER['HTTP_HOST'];}else{global $HTTP_SERVER_VARS;$name=$HTTP_SERVER_VARS["HTTP_HOST"];}if(substr($name,0,4)=="www."){$name=substr($name,4);}return $name;

	}





 }



?>