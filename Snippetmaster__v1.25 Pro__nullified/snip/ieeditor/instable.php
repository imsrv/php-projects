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
<HTML>
<HEAD>
<TITLE><?php echo $text['tooltip13']; ?></TITLE>

<STYLE TYPE="text/css">
 BODY   {margin-left:10; font-family:Verdana; font-size:12; background:menu}
 BUTTON {width:5em}
 TABLE  {font-family:Verdana; font-size:12}
 P      {text-align:center}
</STYLE>

<SCRIPT LANGUAGE=JavaScript>
<!--
function IsDigit()
{
  return ((event.keyCode >= 48) && (event.keyCode <= 57))
}
// -->
</SCRIPT>

<SCRIPT LANGUAGE=JavaScript FOR=window EVENT=onload>
<!--
  for ( elem in window.dialogArguments )
  {
    switch( elem )
    {
    case "NumRows":
      NumRows.value = window.dialogArguments["NumRows"];
      break;
    case "NumCols":
      NumCols.value = window.dialogArguments["NumCols"];
      break;
    case "TableAttrs":
      TableAttrs.value = window.dialogArguments["TableAttrs"];
      break;
    case "CellAttrs":
      CellAttrs.value = window.dialogArguments["CellAttrs"];
      break;
    case "Caption":
      Caption.value = window.dialogArguments["Caption"];
      break;
    }
  }
// -->
</SCRIPT>

<SCRIPT LANGUAGE=JavaScript FOR=Ok EVENT=onclick>
<!--
  var arr = new Array();
  arr["NumRows"] = NumRows.value;
  arr["NumCols"] = NumCols.value;
  arr["TableAttrs"] = TableAttrs.value;
  arr["CellAttrs"] = CellAttrs.value;
  arr["Caption"] = Caption.value;
  window.returnValue = arr;
  window.close();
// -->
</SCRIPT>

</HEAD>

<BODY>

<TABLE CELLSPACING=10>
 <TR>
  <TD><?php echo $text['table_rows']; ?>:
  <TD><INPUT ID=NumRows TYPE=TEXT SIZE=3 NAME=NumRows ONKEYPRESS="event.returnValue=IsDigit();">
 <TR>
  <TD><?php echo $text['table_columns']; ?>:
  <TD><INPUT ID=NumCols TYPE=TEXT SIZE=3 NAME=NumCols ONKEYPRESS="event.returnValue=IsDigit();">
 <TR>
  <TD><?php echo $text['table_attributes']; ?>:
  <TD><INPUT TYPE=TEXT SIZE=40 NAME=TableAttrs>
 <TR>
  <TD><?php echo $text['table_cell_attributes']; ?>:
  <TD><INPUT TYPE=TEXT SIZE=40 NAME=CellAttrs>
 <TR>
  <TD><?php echo $text['table_caption']; ?>:
  <TD><INPUT TYPE=TEXT SIZE=40 NAME=Caption>
</TABLE>

<P>
<BUTTON ID=Ok TYPE=SUBMIT><?php echo $text['submit_button']; ?></BUTTON>
<BUTTON ONCLICK="window.close();"><?php echo $text['cancel_button']; ?></BUTTON>

</BODY>
</HTML>
