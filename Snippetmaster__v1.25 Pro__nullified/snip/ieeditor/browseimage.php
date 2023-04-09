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

?>
<html><head><title>Browse For Images</title>
<style type="text/css">
<!--
body {font-family:Verdana, Arial, sans-serif; font-size: 10pt;}
-->
</style>
</head>
<body bgcolor="white">
<?php
include("dirwalk.php");

//Prints a link for copying the path to some form field
//todo - quote processing so that it won't make bad Javascript
function print_copy_link($path, $name) {
  $imgsize=GetImageSize($path);
  $width=$imgsize[0];
  $height=$imgsize[1];
  $path=ereg_replace("/+","/",$path);
  $path=ereg_replace(ROOTFOLDER,SITEROOT,$path);
  //$name=ereg_replace("\....$","",$name); // remove the extension in the name
  //$name=ucfirst(ereg_replace("_"," ",$name)); // replace underscores by spaces and capitalize
  echo "<a href=\"#\" onClick=\"top.document.forms[0].elements['ImgSrc'].value='$path';";
  echo "top.document.forms[0].elements['ImgWidth'].value=$width;";
  echo "top.document.forms[0].elements['ImgHeight'].value=$height;";
  echo "top.document.PREVIEWPIC.src='$path';\">$name</a>";
}
if(DEBUG)
	echo "<-- $PHP_SELF --><br>\n";
$valid_file_types =  $VALID_IMAGE_FILE_TYPES;
main_process($dir);
?>
</body>
</html>
