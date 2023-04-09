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
<TITLE><?php echo $text['tooltip22']; ?></TITLE>
<STYLE TYPE="text/css">
 BODY   {margin-left:10; font-family:Verdana; font-size:12; background:menu}
 BUTTON {width:75px}
 TABLE  {font-family:Verdana; font-size:12}
 P      {text-align:center}
 SPAN.help    {font-family:Verdana; font-size:9;}
 SELECT    {font-family:Verdana; font-size:12;}
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
for ( elem in window.dialogArguments ) {
    switch( elem ) {

	    case "LinkUrl":
			if (window.dialogArguments["LinkUrl"] == "") { // If no value is passed in, set a default.
				document.frmLinkPick.LinkUrl.value = "http://www.domain.com/folder/file.html";
			} else {
				document.frmLinkPick.LinkUrl.value = window.dialogArguments["LinkUrl"];
			}
	      break;

	    case "LinkLabel":
			document.frmLinkPick.LinkLabel.value = window.dialogArguments["LinkLabel"];
			break;

	    case "LinkTarget":
			if (window.dialogArguments["LinkTarget"] == "") { // If no value is passed in, set a default.
				document.frmLinkPick.LinkTarget.value = "_self";
			} else {
				document.frmLinkPick.LinkTarget.value = window.dialogArguments["LinkTarget"];
			}
	      break;
    }
}
// -->
</SCRIPT>

<SCRIPT LANGUAGE=JavaScript FOR=Ok EVENT=onclick>
<!--
	var arr = new Array();

	if (document.frmLinkPick.LinkUrl.value.substr(0,1)=='/'){
    // attach the BASE so that it will be converted to relative links
		arr["LinkUrl"] =  '<dtml-var BASE0>' + document.frmLinkPick.LinkUrl.value;
	} else {
		arr["LinkUrl"] =  document.frmLinkPick.LinkUrl.value;
	}

	arr["LinkLabel"] = document.frmLinkPick.LinkLabel.value;

	// if no target was selected, we'll automatically assign it as "_self"
	if (document.frmLinkPick.LinkTarget.value == "") {
		arr["LinkTarget"] = "_self";
	} else {
		arr["LinkTarget"] = document.frmLinkPick.LinkTarget[document.frmLinkPick.LinkTarget.selectedIndex].value;
	}

	if (document.frmLinkPick.LinkUrl.value == "http://www.domain.com/folder/file.html") {
		alert("<?php echo $text['link_error1']; ?>");
	} else {
		window.returnValue = arr;
		window.close();
	}
// -->
</SCRIPT>
</HEAD>
<BODY>
<FORM NAME="frmLinkPick" method="post" action="">
<TABLE CELLSPACING=10>
 <TR>
  <TD VALIGN="top" align="left"><b><?php echo $text['link_browse']; ?>: </b><span class="help"><?php echo $text['link_browse_help']; ?></span>
<br>
<iframe name="LNKPICK" src="browselink.php?language=<?php echo $language; ?>&dir=<?php echo urlencode($BASEURL); ?>" style="border: solid black 1px; width: 340px; height:240px; z-index:1"></iframe>
</TD>
</TR>
<!--
<TR>
<TD VALIGN="middle" align="left" nowrap>Type : <span class="help">Protocols for different type of links.</span>
<SELECT NAME=LinkType onChange="document.forms[0].elements['LinkUrl'].value=document.forms[0].elements['LinkType'][document.forms[0].elements['LinkType'].selectedIndex].value;document.forms[0].elements['LinkUrl'].focus();">
<option value="" selected> -- Normal -- </option>
<option value="http://www.mysite.com/thatfolder/thisfile.html">External Sites</option>
<option value="mailto:someone@mysite.com">Email</option>
<option value="ftp://www.mysite.com/somefolder/somefile.zip">FTP</option>
</SELECT></TD>
</TR>
//-->
<TR>
<TD VALIGN="middle" align="left" nowrap><b><?php echo $text['link_url']; ?>: </b><span class="help"><?php echo $text['link_url_help']; ?></span><br><INPUT TYPE=TEXT SIZE=40 NAME=LinkUrl style="width : 340px;" value="">
</TD>
</TR>
<TD VALIGN="middle" align="left" nowrap><b><?php echo $text['link_target']; ?>: </b><span class="help"><?php echo $text['link_target_help']; ?></span><br>
<SELECT NAME=LinkTarget>
<option value="_self"><?php echo $text['target_self']; ?> (_self)</option>
<option value="_top"><?php echo $text['target_top']; ?> (_top)</option>
<option value="_blank"><?php echo $text['target_blank']; ?> (_blank)</option>
</SELECT></TD>
</TR>
<TR>
<TD VALIGN="top" align="center">
<BUTTON ID=Ok><?php echo $text['submit_button']; ?></BUTTON>
<BUTTON ONCLICK="window.close();"><?php echo $text['cancel_button']; ?></BUTTON>
</TD>
</TR>
</TABLE>
<INPUT TYPE=HIDDEN NAME=LinkLabel value="">
</FORM>
</BODY>
</HTML>
