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

<html>
<head>
<meta name="generator" content="GVIM 5.5">
<title>WYSIWYG Editor</title>
<!-- style definitions from Microsoft -->
<style TYPE="text/css">
<!--
.tbContentElement
{
    POSITION: ABSOLUTE;
    HEIGHT: 1px; 
    LEFT: 0px; 
    TOP: 0px; 
    WIDTH: 1px; 
}
.tbToolbar
{
    POSITION: ABSOLUTE;
    BACKGROUND-COLOR: buttonface; 
    BORDER-BOTTOM: buttonshadow solid 1px; 
    BORDER-LEFT: buttonhighlight solid 1px; 
    BORDER-RIGHT: buttonshadow solid 1px; 
    BORDER-TOP:  buttonhighlight solid 1px; 
    HEIGHT: 27px; 
    TOP:0;
    LEFT:0;
}
.tbButton
{
    POSITION: ABSOLUTE;
    BACKGROUND-COLOR: buttonface; 
    BORDER-BOTTOM: buttonface solid 1px; 
    BORDER-LEFT: buttonface solid 1px; 
    BORDER-RIGHT: buttonface solid 1px; 
    BORDER-TOP:  buttonface solid 1px; 
    TOP: 1px;
    HEIGHT: 23px; 
    WIDTH: 23px;
}
.tbIcon
{
    POSITION: ABSOLUTE;
	LEFT: -1;
	TOP: -1
}
.tbSeparator
{
	POSITION: ABSOLUTE; 
	BORDER-LEFT: buttonshadow solid 1px; 
	BORDER-RIGHT: buttonhighlight solid 1px; 
	FONT-SIZE: 0px; 
    TOP: 1px;
	HEIGHT: 22px; 
	WIDTH: 1px; 
}
.tbMenu
{
    POSITION: ABSOLUTE;
    CURSOR: default;
    BACKGROUND-COLOR: buttonface; 
	BORDER-BOTTOM: buttonface solid 1px; 
    BORDER-LEFT: buttonface solid 1px; 
    BORDER-RIGHT: buttonface solid 1px; 
    BORDER-TOP:  buttonface solid 1px; 
    PADDING-TOP: 4;
    PADDING-BOTTOM: 2;
    TOP: 1px;
	WIDTH: 1px; 
    FONT-FAMILY: MS Sans Serif; 
    FONT-SIZE: 8px;
}
.tbMenuItem
{
    CURSOR: default;
    FONT-FAMILY: MS Sans Serif; 
    FONT-SIZE: 8px;
    DISPLAY: none;    
}
.tbSubmenu 
{
    CURSOR: default;
    FONT-FAMILY: MS Sans Serif; 
    FONT-SIZE: 8px;    
    DISPLAY: none;    
} 
.tbGeneral
{
    POSITION: ABSOLUTE;
    HEIGHT: 22px; 
    TOP:2;
}
/* ---------------------------------------------------------------------------------------------- */
/* Private styles                                                                                 */
/* ---------------------------------------------------------------------------------------------- */
.tbHandleDiv
{
	POSITION: ABSOLUTE;
    BACKGROUND-COLOR: buttonface; 
	BORDER-LEFT: buttonhighlight solid 1px; 
	BORDER-RIGHT: buttonshadow solid 1px;
	BORDER-TOP: buttonhighlight solid 1px; 
	FONT-SIZE: 1px;
	TOP: 1px; 
	HEIGHT: 22px; 
	WIDTH: 3px;
}
.tbButtonMouseOverUp
{
    POSITION: ABSOLUTE;
    BACKGROUND-COLOR: buttonface; 
    BORDER-BOTTOM: buttonshadow solid 1px; 
    BORDER-LEFT: buttonhighlight solid 1px; 
    BORDER-RIGHT: buttonshadow solid 1px; 
    BORDER-TOP:  buttonhighlight solid 1px; 
    TOP: 1px;
    HEIGHT: 23px; 
    WIDTH: 24px;
}
.tbButtonMouseOverDown
{
    POSITION: ABSOLUTE;
    BACKGROUND-COLOR: buttonface; 
    BORDER-BOTTOM: buttonhighlight solid 1px; 
    BORDER-LEFT: buttonshadow solid 1px; 
    BORDER-RIGHT: buttonhighlight solid 1px; 
    BORDER-TOP:  buttonshadow solid 1px; 
    TOP: 1px;
    HEIGHT: 23px; 
    WIDTH: 24px;
}
.tbButtonDown
{
    POSITION: ABSOLUTE;
    BACKGROUND-COLOR: gainsboro; 
    BORDER-BOTTOM: buttonhighlight solid 1px; 
    BORDER-LEFT: buttonshadow solid 1px; 
    BORDER-RIGHT: buttonhighlight solid 1px; 
    BORDER-TOP:  buttonshadow solid 1px; 
    TOP: 1px;
    HEIGHT: 23px; 
    WIDTH: 24px;
}
.tbIconDown
{
    POSITION: ABSOLUTE;
	LEFT: 0px;
	TOP: 0px;
}
.tbIconDownPressed
{
    POSITION: ABSOLUTE;
	LEFT: 1px;
	TOP: 1px;
}
.tbMenuBodyOuterDiv
{
    CURSOR: default; 
    BACKGROUND-COLOR: menu;
	BORDER-BOTTOM: threeddarkshadow solid 1px; 
    BORDER-LEFT: threedface solid 1px; 
    BORDER-RIGHT: threeddarkshadow solid 1px; 
    BORDER-TOP:  threedface solid 1px; 
    POSITION: absolute;
}
.tbMenuBodyInnerDiv
{
    CURSOR: default; 
	BORDER-BOTTOM: threedshadow solid 1px; 
    BORDER-LEFT: threedhighlight solid 1px; 
    BORDER-RIGHT: threedshadow solid 1px; 
    BORDER-TOP:  threedhighlight solid 1px; 
}
.tbMenuBodyTable
{
    CURSOR: default; 
	BORDER-BOTTOM: menu solid 1px; 
    BORDER-LEFT: menu solid 1px; 
    BORDER-RIGHT: menu solid 1px; 
    BORDER-TOP:  menu solid 1px; 
}
.tbMenuSeparator
{
    DISPLAY: none;    
}
.tbMenuSeparatorTop
{
	POSITION: RELATIVE;
	BORDER-BOTTOM: buttonshadow solid 1px; 
	HEIGHT: 5px;
	WIDTH: 94%;
	FONT-SIZE: 0px;
}
.tbMenuSeparatorBottom
{
	POSITION: RELATIVE;
	BORDER-TOP: buttonhighlight solid 1px; 
	HEIGHT: 5px;
	WIDTH: 94%;
	FONT-SIZE: 0px;
}
.tbMenuBlankSpace
{
	WIDTH: 20; 
}
.tbSubmenuGlyph
{
	FONT-FAMILY: webdings; 
	WIDTH: 20; 
	TEXT-ALIGN: right;
}
.tbMenuItemChecked
{
	FONT-FAMILY: webdings; 
	WIDTH: 20; 
	TEXT-ALIGN: right;
}
.tbMenuIcon
{
    BACKGROUND-COLOR: buttonface; 
    BORDER-BOTTOM: buttonface solid 1px; 
    BORDER-LEFT: buttonface solid 1px; 
    BORDER-RIGHT: buttonface solid 1px; 
    BORDER-TOP:  buttonface solid 1px; 
}
.tbMenuIconChecked
{
    BACKGROUND-COLOR: threedlightshadow; 
    BORDER-BOTTOM: buttonhighlight solid 1px; 
    BORDER-LEFT: buttonshadow solid 1px; 
    BORDER-RIGHT: buttonhighlight solid 1px; 
    BORDER-TOP:  buttonshadow solid 1px; 
}
.tbMenuIconMouseOver
{
    BACKGROUND-COLOR: buttonface; 
    BORDER-BOTTOM: buttonshadow solid 1px; 
    BORDER-LEFT: buttonhighlight solid 1px; 
    BORDER-RIGHT: buttonshadow solid 1px; 
    BORDER-TOP:  buttonhighlight solid 1px; 
}
.tbMenuIconCheckedMouseOver
{
    BACKGROUND-COLOR: buttonface; 
    BORDER-BOTTOM: buttonhighlight solid 1px; 
    BORDER-LEFT: buttonshadow solid 1px; 
    BORDER-RIGHT: buttonhighlight solid 1px; 
    BORDER-TOP:  buttonshadow solid 1px; 
}
.tbScriptlet
{
    POSITION: ABSOLUTE;
    CURSOR: default; 
    VISIBILITY: hidden;
}
BODY
{
	MARGIN: 0;
	BORDER: 0;
	BACKGROUND-COLOR: buttonface;
}
//-->
</style>
<!-- constant definitions from Microsoft -->
<script LANGUAGE="JavaScript">
<!--
// DHTML Editing Component Constants for JavaScript
// Copyright 1998-1999 Microsoft Corporation.  All rights reserved.
//

//
// Command IDs
//
DECMD_BOLD =                      5000
DECMD_COPY =                      5002
DECMD_CUT =                       5003
DECMD_DELETE =                    5004
DECMD_DELETECELLS =               5005
DECMD_DELETECOLS =                5006
DECMD_DELETEROWS =                5007
DECMD_FINDTEXT =                  5008
DECMD_FONT =                      5009
DECMD_GETBACKCOLOR =              5010
DECMD_GETBLOCKFMT =               5011
DECMD_GETBLOCKFMTNAMES =          5012
DECMD_GETFONTNAME =               5013
DECMD_GETFONTSIZE =               5014
DECMD_GETFORECOLOR =              5015
DECMD_HYPERLINK =                 5016
DECMD_IMAGE =                     5017
DECMD_INDENT =                    5018
DECMD_INSERTCELL =                5019
DECMD_INSERTCOL =                 5020
DECMD_INSERTROW =                 5021
DECMD_INSERTTABLE =               5022
DECMD_ITALIC =                    5023
DECMD_JUSTIFYCENTER =             5024
DECMD_JUSTIFYLEFT =               5025
DECMD_JUSTIFYRIGHT =              5026
DECMD_LOCK_ELEMENT =              5027
DECMD_MAKE_ABSOLUTE =             5028
DECMD_MERGECELLS =                5029
DECMD_ORDERLIST =                 5030
DECMD_OUTDENT =                   5031
DECMD_PASTE =                     5032
DECMD_REDO =                      5033
DECMD_REMOVEFORMAT =              5034
DECMD_SELECTALL =                 5035
DECMD_SEND_BACKWARD =             5036
DECMD_BRING_FORWARD =             5037
DECMD_SEND_BELOW_TEXT =           5038
DECMD_BRING_ABOVE_TEXT =          5039
DECMD_SEND_TO_BACK =              5040
DECMD_BRING_TO_FRONT =            5041
DECMD_SETBACKCOLOR =              5042
DECMD_SETBLOCKFMT =               5043
DECMD_SETFONTNAME =               5044
DECMD_SETFONTSIZE =               5045
DECMD_SETFORECOLOR =              5046
DECMD_SPLITCELL =                 5047
DECMD_UNDERLINE =                 5048
DECMD_UNDO =                      5049
DECMD_UNLINK =                    5050
DECMD_UNORDERLIST =               5051
DECMD_PROPERTIES =                5052

//
// Enums
//

// OLECMDEXECOPT  
OLECMDEXECOPT_DODEFAULT =         0 
OLECMDEXECOPT_PROMPTUSER =        1
OLECMDEXECOPT_DONTPROMPTUSER =    2

// DHTMLEDITCMDF
DECMDF_NOTSUPPORTED =             0 
DECMDF_DISABLED =                 1 
DECMDF_ENABLED =                  3
DECMDF_LATCHED =                  7
DECMDF_NINCHED =                  11

// DHTMLEDITAPPEARANCE
DEAPPEARANCE_FLAT =               0
DEAPPEARANCE_3D =                 1 

// OLE_TRISTATE
OLE_TRISTATE_UNCHECKED =          0
OLE_TRISTATE_CHECKED =            1
OLE_TRISTATE_GRAY =               2
//-->
</script>

<script language="JavaScript">
<!--
function fix4NS(instr){
	var re  = /STYLE=\"WIDTH\s*:\s*(\d+)px;\s*HEIGHT:\s*(\d+)px;*\s*\"/gi;
        var re1 = /<A\s+href=".*?"\s*>\s*<\/A>/gi; // for taking out blank links
	/* changes width and height from style definitions
	to plain HTML that NS can understand.
	A troublesome output -
	<IMG style="WIDTH: 10px; HEIGHT: 10px" width=20 height=30>
	  will be changed to
	<IMG width=10 height=10 width=20 height=30>
	DHTML editor takes care of the extra tags.. phew!
	*/
        instr=instr.replace(re1, "");
	return(instr.replace(re, "width=$1 height=$2"));
}
function fixCopyright(instr){
 /*
  changes the attempts at copyright symbol
  to proper HTML coding 
 */
 var re1 = /&amp;copy;/gi;
 var re2 = /©/gi;
 instr = instr.replace(re1, "&copy;");
 return (instr.replace(re2, "&copy;"));
}
function AbsToRel(baseurl, thisurl, bigstr) {
var nexturl = new Array();
var nextstr = bigstr;
var outStr = bigstr;
if (nextstr.match(/(['"])(\w+):\/\/[^'"]*\1/g)) {
	nexturl = nextstr.match(/(['"])(\w+):\/\/[^'"]*\1/g);       //get URL in quotes
	nextstr = RegExp.rightContext;
}
var currdoc = thisurl.slice(baseurl.length);
for (k=0;k < nexturl.length; k++) {
	var nextdoc = nexturl[k];
        nextdoc = nextdoc.replace(/(["])*/g,'');
        if (nextdoc.substr(0,baseurl.length)==baseurl){
           nextdoc = nextdoc.replace(baseurl,'');
           var rellink = ProcessURL(currdoc,nextdoc);
           outStr = outStr.replace(nexturl[k],'"' + rellink + '"');
        }
}
return outStr;
}
                                                                                 

function ProcessURL(currdoc,nextdoc){
var currarr = currdoc.split("/");
var nextarr = nextdoc.split("/");
var matchcnt = 0;
var outstr = "";
var nexturl = "";
for (i=0;i < (currarr.length - 1);i++) {
   if (nextarr[i] == currarr[i]) {
   matchcnt++;
   } else {
      outstr += "../";
   }
}
   nextarr = nextarr.slice(matchcnt);
if (matchcnt == (currarr.length - 1)) {
     outstr +=  nextarr.join("/");
}else if (nextarr.length > 1) {
   nexturl += nextarr.join("/");
   outstr += nexturl;
}else {
   outstr += nextarr;
}
   return (outstr);
}



function findLocalRef(inStr) {
// This function takes finds links beginning with "file://" in a long string and
// lists them with a delimeter of your choice.
// 
//
var delimtr = "|";
var nexturl = new Array();      //holds all URLs from inStr
var nextstr = inStr;           // make copy of inStr to chop up
var outStr = "";            //make another for last search/replace using original didnt work.
if (nextstr.match(/(['"])[a-zA-Z]:\\[^'"]*\1/g)) {              //get urls one at a time
	nexturl = nextstr.match(/(['"])[a-zA-Z]:\\[^'"]*\1/g);       //get URL in quotes
	nextstr = RegExp.rightContext;                         //grab remainder of string to the right
}
for (k=0;k < nexturl.length; k++) {                            //each url is a cell in the array
	var nextfile = nexturl[k];
	nextfile = nextfile.replace(/(["])*/g,'');               //remove quotes around url
	if (k > 0) {
	outStr = (outStr + delimtr + nextfile);  // put delimeter between files..
	} else {
	outStr = nextfile;
	}
}
return outStr;
}

//Depending upon base URL, take out the absolute paths
function delAbsolutePaths(strIn)
{
  var strOut;
  strOut = fix4NS(strIn);
  return ( AbsToRel(ParentBaseURL, ThisURL, strOut) );
}

function RemoveLocalRef(inStr) {
// This function removes the file path and replaces with /images/
// A long string is the only input and it returns the same string
// with the replacement.
//
var nexturl = new Array();      //holds all URLs from inStr
var nextstr = inStr;           // make copy of inStr to chop up
var outStr = inStr;            //make another for last search/replace using original didnt work.
//if (nextstr.match(/(['"])(file+):\/\/[^'"]*\1/g)) {              //get urls one at a time
if (nextstr.match(/(['"])[a-zA-Z]:\\[^'"]*\1/g)) {              //get urls one at a time
	nexturl = nextstr.match(/(['"])[a-zA-Z]:\\[^'"]*\1/g);       //get URL in quotes
	nextstr = RegExp.rightContext;                         //grab remainder of string to the right
}
for (k=0;k < nexturl.length; k++) {                            //each url is a cell in the array
	var nextfile = nexturl[k];
	nextfile = nextfile.replace(/(["])*/g,'');               //remove quotes around url
	var nextpos = nextfile.match(/(\w)+(\.)+\w+[^"]/g);                 //get filename
	outStr = outStr.replace(nexturl[k], "images/" + nextpos);  //search/replace original file with /images/etc..
}
return outStr;
}

function TidyHTML(inStr){
/*
||If you want to run Tidy real time, you can run it as a SOAP service
||and use this function
*/
var xmldom, xmlhttp, soapdata, SoapServer, outStr;
SoapServer = "tidy.php";
soapdata = '<SOAP:Envelope xmlns:SOAP="urn:schemas-xmlsoap-org:soap.v1">';
soapdata += "<SOAP:Body>";
soapdata += "<badhtml><![CDATA[";
soapdata +=  inStr;
soapdata += "]]></badhtml>";
soapdata += "</SOAP:Body>";
soapdata += "</SOAP:Envelope>";
xmldom = new ActiveXObject("Microsoft.XMLDOM");
xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
xmlhttp.open("POST", SoapServer, false);
xmlhttp.setRequestHeader("Man", "POST" + " " + SoapServer + " HTTP/1.1");
xmlhttp.setRequestHeader("MessageType", "CALL");
xmlhttp.setRequestHeader("ContentType", "text/xml");
xmlhttp.send( soapdata );
if (xmlhttp.status == 200)
{
	xmldom = xmlhttp.responseXML;
	outStr=xmldom.documentElement.childNodes.item(0).childNodes.item(0).text;
} else {
  outStr = inStr;
}
if(outStr == ""){
  outStr = inStr;
}
xmldom = null;
xmlhttp = null;
return (outStr);
}
function cleanHTML(mode){
  return;
  if(mode=='CODE'){
    if (tbContentElement.DOM.body.innerText != "")
    tbContentElement.DOM.body.innerText=TidyHTML(tbContentElement.FilterSourceCode(tbContentElement.DOM.body.innerText));
  }else {
    if (tbContentElement.DOM.body.innerHTML != "")
    tbContentElement.DOM.body.innerHTML=TidyHTML(tbContentElement.FilterSourceCode(tbContentElement.DOM.body.innerHTML));
 }
}
//utility function to see if somebody managed to have file:// urls for images
function check_local_images(){
  var filteredHTML;
  if (displayMode == 'RICH'){
  	filteredHTML = tbContentElement.FilterSourceCode (tbContentElement.DOM.body.innerHTML);
    filteredHTML = delAbsolutePaths(filteredHTML);
    LocalImages = findLocalRef(filteredHTML);
    filteredHTML = RemoveLocalRef(fix4NS(filteredHTML));
    if (LocalImages != ''){
       tbContentElement.DOM.body.innerHTML=filteredHTML;
       parent.document.forms[1].elements['data[page_text][0]'].value = filteredHTML;
    }
  }
  return true;
}

function richEditorInsertHTML(sHTML)
{ /* Utility function to paste a given html string sHTML
  at the current selection */
 // Clear the selection if it's an image (would cause an error otherwise)
  if(tbContentElement.DOM.selection.type == "Control")
    tbContentElement.DOM.selection.clear();
  tbContentElement.DOM.selection.createRange().pasteHTML(sHTML);
}

function GetElement(oElement,sTag) {
  /*Utility function; Goes up the DOM from the element oElement, till
  a parent element with the tag that matches sTag
  is found. Returns that parent element.*/
  while ((oElement!=null) && (oElement.tagName!=sTag)) {
    oElement = oElement.parentElement;
  }
  return oElement;
}

// switch between WYSIWYG and HTML edit mode
function setDisplayMode(mode){
	if(mode=='CODE'){
		tbContentElement.DOM.body.clearAttributes;
		tbContentElement.DOM.body.style.fontFamily='Courier New';
		tbContentElement.DOM.body.style.fontSize='10pt';
		if(tbContentElement.DOM.body.innerHTML != "")
			tbContentElement.DOM.body.innerText=fix4NS(tbContentElement.FilterSourceCode(tbContentElement.DOM.body.innerHTML));
		else
			tbContentElement.DOM.body.innerText="";
		displayMode='CODE';
	} else{
		tbContentElement.DOM.body.clearAttributes;
		tbContentElement.DOM.body.style.fontFamily='';
		tbContentElement.DOM.body.style.fontSize='';
		if(tbContentElement.DOM.body.innerText != "")
			tbContentElement.DOM.body.innerHTML=tbContentElement.FilterSourceCode(tbContentElement.DOM.body.innerText);
		else
			tbContentElement.DOM.body.innerHTML="";
		displayMode='RICH';
	}
}
//-->
</script>

<!-- Script Functions and Event Handlers (c) Microsoft -->
<script ID="clientEventHandlersJS" LANGUAGE="javascript">
<!--
// Constants
var MENU_SEPARATOR = ""; // Context menu separator
// Globals
var docComplete = false;
var initialDocComplete = false;
var ParentBaseURL = "<?php echo "$BASEURL"; ?>";
var ThisURL = "<?php echo "$BASEURL"; ?>/";
var displayMode = 'RICH';

var QueryStatusToolbarButtons = new Array();
var QueryStatusEditMenu = new Array();
var QueryStatusFormatMenu = new Array();
var QueryStatusHTMLMenu = new Array();
var QueryStatusTableMenu = new Array();
var QueryStatusZOrderMenu = new Array();
var ContextMenu = new Array();
var GeneralContextMenu = new Array();
var TableContextMenu = new Array();
var AbsPosContextMenu = new Array();


// Constructor for custom object that represents an item on the context menu
function ContextMenuItem(string, cmdId) {
  this.string = string;
  this.cmdId = cmdId;
}

// Constructor for custom object that represents a QueryStatus command and 
// corresponding toolbar element.
function QueryStatusItem(command, element) {
  this.command = command;
  this.element = element;
}

//
// Event handlers
//
function window_onload() {

  // Initialze QueryStatus tables. These tables associate a command id with the
  // corresponding button object. Must be done on window load, 'cause the buttons must exist.
  QueryStatusToolbarButtons[0] = new QueryStatusItem(DECMD_BOLD, document.body.all["DECMD_BOLD"]);
  QueryStatusToolbarButtons[1] = new QueryStatusItem(DECMD_COPY, document.body.all["DECMD_COPY"]);
  QueryStatusToolbarButtons[2] = new QueryStatusItem(DECMD_CUT, document.body.all["DECMD_CUT"]);
  QueryStatusToolbarButtons[3] = new QueryStatusItem(DECMD_HYPERLINK, document.body.all["DECMD_HYPERLINK"]);
  QueryStatusToolbarButtons[4] = new QueryStatusItem(DECMD_INDENT, document.body.all["DECMD_INDENT"]);
  QueryStatusToolbarButtons[5] = new QueryStatusItem(DECMD_ITALIC, document.body.all["DECMD_ITALIC"]);
  QueryStatusToolbarButtons[6] = new QueryStatusItem(DECMD_JUSTIFYLEFT, document.body.all["DECMD_JUSTIFYLEFT"]);
  QueryStatusToolbarButtons[7] = new QueryStatusItem(DECMD_JUSTIFYCENTER, document.body.all["DECMD_JUSTIFYCENTER"]);
  QueryStatusToolbarButtons[8] = new QueryStatusItem(DECMD_JUSTIFYRIGHT, document.body.all["DECMD_JUSTIFYRIGHT"]);
  //rather than locking elements, I would've absolute positioning - vsb
  //QueryStatusToolbarButtons[9] = new QueryStatusItem(DECMD_LOCK_ELEMENT, document.body.all["DECMD_LOCK_ELEMENT"]);
  QueryStatusToolbarButtons[9] = new QueryStatusItem(DECMD_MAKE_ABSOLUTE, document.body.all["DECMD_MAKE_ABSOLUTE"]);
  QueryStatusToolbarButtons[10] = new QueryStatusItem(DECMD_MAKE_ABSOLUTE, document.body.all["DECMD_MAKE_ABSOLUTE"]);
  QueryStatusToolbarButtons[11] = new QueryStatusItem(DECMD_ORDERLIST, document.body.all["DECMD_ORDERLIST"]);
  QueryStatusToolbarButtons[12] = new QueryStatusItem(DECMD_OUTDENT, document.body.all["DECMD_OUTDENT"]);
  QueryStatusToolbarButtons[13] = new QueryStatusItem(DECMD_PASTE, document.body.all["DECMD_PASTE"]);
  QueryStatusToolbarButtons[14] = new QueryStatusItem(DECMD_REDO, document.body.all["DECMD_REDO"]);
  QueryStatusToolbarButtons[15] = new QueryStatusItem(DECMD_UNDERLINE, document.body.all["DECMD_UNDERLINE"]);
  QueryStatusToolbarButtons[16] = new QueryStatusItem(DECMD_UNDO, document.body.all["DECMD_UNDO"]);
  QueryStatusToolbarButtons[17] = new QueryStatusItem(DECMD_UNORDERLIST, document.body.all["DECMD_UNORDERLIST"]);
  QueryStatusToolbarButtons[18] = new QueryStatusItem(DECMD_INSERTTABLE, document.body.all["DECMD_INSERTTABLE"]);
  QueryStatusToolbarButtons[19] = new QueryStatusItem(DECMD_INSERTROW, document.body.all["DECMD_INSERTROW"]);
  QueryStatusToolbarButtons[20] = new QueryStatusItem(DECMD_DELETEROWS, document.body.all["DECMD_DELETEROWS"]);
  QueryStatusToolbarButtons[21] = new QueryStatusItem(DECMD_INSERTCOL, document.body.all["DECMD_INSERTCOL"]);
  QueryStatusToolbarButtons[22] = new QueryStatusItem(DECMD_DELETECOLS, document.body.all["DECMD_DELETECOLS"]);
  QueryStatusToolbarButtons[23] = new QueryStatusItem(DECMD_INSERTCELL, document.body.all["DECMD_INSERTCELL"]);
  QueryStatusToolbarButtons[24] = new QueryStatusItem(DECMD_DELETECELLS, document.body.all["DECMD_DELETECELLS"]);
  QueryStatusToolbarButtons[25] = new QueryStatusItem(DECMD_MERGECELLS, document.body.all["DECMD_MERGECELLS"]);
  QueryStatusToolbarButtons[26] = new QueryStatusItem(DECMD_SPLITCELL, document.body.all["DECMD_SPLITCELL"]);
  QueryStatusToolbarButtons[27] = new QueryStatusItem(DECMD_SETFORECOLOR, document.body.all["DECMD_SETFORECOLOR"]);
  QueryStatusToolbarButtons[28] = new QueryStatusItem(DECMD_SETBACKCOLOR, document.body.all["DECMD_SETBACKCOLOR"]);
  QueryStatusEditMenu[0] = new QueryStatusItem(DECMD_UNDO, document.body.all["EDIT_UNDO"]);
  QueryStatusEditMenu[1] = new QueryStatusItem(DECMD_REDO, document.body.all["EDIT_REDO"]);
  QueryStatusEditMenu[2] = new QueryStatusItem(DECMD_CUT, document.body.all["EDIT_CUT"]);
  QueryStatusEditMenu[3] = new QueryStatusItem(DECMD_COPY, document.body.all["EDIT_COPY"]);
  QueryStatusEditMenu[4] = new QueryStatusItem(DECMD_PASTE, document.body.all["EDIT_PASTE"]);
  QueryStatusEditMenu[5] = new QueryStatusItem(DECMD_DELETE, document.body.all["EDIT_DELETE"]);
  QueryStatusHTMLMenu[0] = new QueryStatusItem(DECMD_HYPERLINK, document.body.all["HTML_HYPERLINK"]);
  QueryStatusHTMLMenu[1] = new QueryStatusItem(DECMD_IMAGE, document.body.all["HTML_IMAGE"]);
  QueryStatusFormatMenu[0] = new QueryStatusItem(DECMD_FONT, document.body.all["FORMAT_FONT"]);
  QueryStatusFormatMenu[1] = new QueryStatusItem(DECMD_BOLD, document.body.all["FORMAT_BOLD"]);
  QueryStatusFormatMenu[2] = new QueryStatusItem(DECMD_ITALIC, document.body.all["FORMAT_ITALIC"]);
  QueryStatusFormatMenu[3] = new QueryStatusItem(DECMD_UNDERLINE, document.body.all["FORMAT_UNDERLINE"]);
  QueryStatusFormatMenu[4] = new QueryStatusItem(DECMD_JUSTIFYLEFT, document.body.all["FORMAT_JUSTIFYLEFT"]);
  QueryStatusFormatMenu[5] = new QueryStatusItem(DECMD_JUSTIFYCENTER, document.body.all["FORMAT_JUSTIFYCENTER"]);
  QueryStatusFormatMenu[6] = new QueryStatusItem(DECMD_JUSTIFYRIGHT, document.body.all["FORMAT_JUSTIFYRIGHT"]);
  QueryStatusFormatMenu[7] = new QueryStatusItem(DECMD_SETFORECOLOR, document.body.all["FORMAT_SETFORECOLOR"]);
  QueryStatusFormatMenu[8] = new QueryStatusItem(DECMD_SETBACKCOLOR, document.body.all["FORMAT_SETBACKCOLOR"]);
  QueryStatusTableMenu[0] = new QueryStatusItem(DECMD_INSERTTABLE, document.body.all["TABLE_INSERTTABLE"]);
  QueryStatusTableMenu[1] = new QueryStatusItem(DECMD_INSERTROW, document.body.all["TABLE_INSERTROW"]);
  QueryStatusTableMenu[2] = new QueryStatusItem(DECMD_DELETEROWS, document.body.all["TABLE_DELETEROW"]);
  QueryStatusTableMenu[3] = new QueryStatusItem(DECMD_INSERTCOL, document.body.all["TABLE_INSERTCOL"]);
  QueryStatusTableMenu[4] = new QueryStatusItem(DECMD_DELETECOLS, document.body.all["TABLE_DELETECOL"]);
  QueryStatusTableMenu[5] = new QueryStatusItem(DECMD_INSERTCELL, document.body.all["TABLE_INSERTCELL"]);
  QueryStatusTableMenu[6] = new QueryStatusItem(DECMD_DELETECELLS, document.body.all["TABLE_DELETECELL"]);
  QueryStatusTableMenu[7] = new QueryStatusItem(DECMD_MERGECELLS, document.body.all["TABLE_MERGECELL"]);
  QueryStatusTableMenu[8] = new QueryStatusItem(DECMD_SPLITCELL, document.body.all["TABLE_SPLITCELL"]);
  QueryStatusZOrderMenu[0] = new QueryStatusItem(DECMD_SEND_TO_BACK, document.body.all["ZORDER_SENDBACK"]);
  QueryStatusZOrderMenu[1] = new QueryStatusItem(DECMD_BRING_TO_FRONT, document.body.all["ZORDER_BRINGFRONT"]);
  QueryStatusZOrderMenu[2] = new QueryStatusItem(DECMD_SEND_BACKWARD, document.body.all["ZORDER_SENDBACKWARD"]);
  QueryStatusZOrderMenu[3] = new QueryStatusItem(DECMD_BRING_FORWARD, document.body.all["ZORDER_BRINGFORWARD"]);
  QueryStatusZOrderMenu[4] = new QueryStatusItem(DECMD_SEND_BELOW_TEXT, document.body.all["ZORDER_BELOWTEXT"]);
  QueryStatusZOrderMenu[5] = new QueryStatusItem(DECMD_BRING_ABOVE_TEXT, document.body.all["ZORDER_ABOVETEXT"]);
  
  // Initialize the context menu arrays.
  GeneralContextMenu[0] = new ContextMenuItem("Cut", DECMD_CUT);
  GeneralContextMenu[1] = new ContextMenuItem("Copy", DECMD_COPY);
  GeneralContextMenu[2] = new ContextMenuItem("Paste", DECMD_PASTE);
  TableContextMenu[0] = new ContextMenuItem(MENU_SEPARATOR, 0);
  TableContextMenu[1] = new ContextMenuItem("Insert Row", DECMD_INSERTROW);
  TableContextMenu[2] = new ContextMenuItem("Delete Rows", DECMD_DELETEROWS);
  TableContextMenu[3] = new ContextMenuItem(MENU_SEPARATOR, 0);
  TableContextMenu[4] = new ContextMenuItem("Insert Column", DECMD_INSERTCOL);
  TableContextMenu[5] = new ContextMenuItem("Delete Columns", DECMD_DELETECOLS);
  TableContextMenu[6] = new ContextMenuItem(MENU_SEPARATOR, 0);
  TableContextMenu[7] = new ContextMenuItem("Insert Cell", DECMD_INSERTCELL);
  TableContextMenu[8] = new ContextMenuItem("Delete Cells", DECMD_DELETECELLS);
  TableContextMenu[9] = new ContextMenuItem("Merge Cells", DECMD_MERGECELLS);
  TableContextMenu[10] = new ContextMenuItem("Split Cell", DECMD_SPLITCELL);
  AbsPosContextMenu[0] = new ContextMenuItem(MENU_SEPARATOR, 0);
  AbsPosContextMenu[1] = new ContextMenuItem("Send To Back", DECMD_SEND_TO_BACK);
  AbsPosContextMenu[2] = new ContextMenuItem("Bring To Front", DECMD_BRING_TO_FRONT);
  AbsPosContextMenu[3] = new ContextMenuItem(MENU_SEPARATOR, 0);
  AbsPosContextMenu[4] = new ContextMenuItem("Send Backward", DECMD_SEND_BACKWARD);
  AbsPosContextMenu[5] = new ContextMenuItem("Bring Forward", DECMD_BRING_FORWARD);
  AbsPosContextMenu[6] = new ContextMenuItem(MENU_SEPARATOR, 0);
  AbsPosContextMenu[7] = new ContextMenuItem("Send Below Text", DECMD_SEND_BELOW_TEXT);
  AbsPosContextMenu[8] = new ContextMenuItem("Bring Above Text", DECMD_BRING_ABOVE_TEXT);
}

// popup dialog to insert a table
function InsertTable() {
  var pVar = ObjTableInfo;
  var args = new Array();
  var arr = null;
  // Display table information dialog
  args["NumRows"] = ObjTableInfo.NumRows;
  args["NumCols"] = ObjTableInfo.NumCols;
  args["TableAttrs"] = ObjTableInfo.TableAttrs;
  args["CellAttrs"] = ObjTableInfo.CellAttrs;
  args["Caption"] = ObjTableInfo.Caption;
  arr = null;
  arr = showModalDialog( "instable.php?language=<?php echo $language; ?>",
                          args,
                         "font-family:Verdana; font-size:12; dialogWidth:36em; dialogHeight:25em");
  if (arr != null) {
    // Initialize table object
    for ( elem in arr ) {
      if ("NumRows" == elem && arr["NumRows"] != null) {
        ObjTableInfo.NumRows = arr["NumRows"];
      } else if ("NumCols" == elem && arr["NumCols"] != null) {
        ObjTableInfo.NumCols = arr["NumCols"];
      } else if ("TableAttrs" == elem) {
        ObjTableInfo.TableAttrs = arr["TableAttrs"];
      } else if ("CellAttrs" == elem) {
        ObjTableInfo.CellAttrs = arr["CellAttrs"];
      } else if ("Caption" == elem) {
        ObjTableInfo.Caption = arr["Caption"];
      }
    }
    tbContentElement.ExecCommand(DECMD_INSERTTABLE,OLECMDEXECOPT_DODEFAULT, pVar);  
  }
}

function tbContentElement_ShowContextMenu() {
  var menuStrings = new Array();
  var menuStates = new Array();
  var state;
  var i
  var idx = 0;
  // Rebuild the context menu. 
  ContextMenu.length = 0;
  // Always show general menu
  for (i=0; i<GeneralContextMenu.length; i++) {
    ContextMenu[idx++] = GeneralContextMenu[i];
  }
  // Is the selection inside a table? Add table menu if so
  if (tbContentElement.QueryStatus(DECMD_INSERTROW) != DECMDF_DISABLED) {
    for (i=0; i<TableContextMenu.length; i++) {
      ContextMenu[idx++] = TableContextMenu[i];
    }
  }
  // Is the selection on an absolutely positioned element? Add z-index commands if so
  if (tbContentElement.QueryStatus(DECMD_LOCK_ELEMENT) != DECMDF_DISABLED) {
    for (i=0; i<AbsPosContextMenu.length; i++) {
      ContextMenu[idx++] = AbsPosContextMenu[i];
    }
  }
  // Set up the actual arrays that get passed to SetContextMenu
  for (i=0; i<ContextMenu.length; i++) {
    menuStrings[i] = ContextMenu[i].string;
    if (menuStrings[i] != MENU_SEPARATOR) {
      state = tbContentElement.QueryStatus(ContextMenu[i].cmdId);
    } else {
      state = DECMDF_ENABLED;
    }
    if (state == DECMDF_DISABLED || state == DECMDF_NOTSUPPORTED) {
      menuStates[i] = OLE_TRISTATE_GRAY;
    } else if (state == DECMDF_ENABLED || state == DECMDF_NINCHED) {
      menuStates[i] = OLE_TRISTATE_UNCHECKED;
    } else { // DECMDF_LATCHED
      menuStates[i] = OLE_TRISTATE_CHECKED;
    }
  }
  // Set the context menu
  tbContentElement.SetContextMenu(menuStrings, menuStates);
}

function tbContentElement_ContextMenuAction(itemIndex) {
  
  if (ContextMenu[itemIndex].cmdId == DECMD_INSERTTABLE) {
    InsertTable();
  } else {
    tbContentElement.ExecCommand(ContextMenu[itemIndex].cmdId, OLECMDEXECOPT_DODEFAULT);
  }
}

// DisplayChanged handler. Very time-critical routine; this is called
// every time a character is typed. QueryStatus those toolbar buttons that need
// to be in synch with the current state of the document and update. 
function tbContentElement_DisplayChanged() {
  var i, s;
  var filteredHTML;
	if (displayMode == 'RICH'){
	  for (i=0; i<QueryStatusToolbarButtons.length; i++) {
  		s = tbContentElement.QueryStatus(QueryStatusToolbarButtons[i].command);
  		if (s == DECMDF_DISABLED || s == DECMDF_NOTSUPPORTED) {
  		  TBSetState(QueryStatusToolbarButtons[i].element, "gray"); 
  		} else if (s == DECMDF_ENABLED  || s == DECMDF_NINCHED) {
  		   TBSetState(QueryStatusToolbarButtons[i].element, "unchecked"); 
  		} else { // DECMDF_LATCHED
  		   TBSetState(QueryStatusToolbarButtons[i].element, "checked");
  		}
	  }
  	s = tbContentElement.QueryStatus(DECMD_GETBLOCKFMT);
	  if (s == DECMDF_DISABLED || s == DECMDF_NOTSUPPORTED) {
  		ParagraphStyle.disabled = true;
	  } else {
  		ParagraphStyle.disabled = false;
  		ParagraphStyle.value = tbContentElement.ExecCommand(DECMD_GETBLOCKFMT, OLECMDEXECOPT_DODEFAULT);
	  }
	  s = tbContentElement.QueryStatus(DECMD_GETFONTNAME);
	  if (s == DECMDF_DISABLED || s == DECMDF_NOTSUPPORTED) {
  		FontName.disabled = true;
	  } else {
  		FontName.disabled = false;
  		FontName.value = tbContentElement.ExecCommand(DECMD_GETFONTNAME, OLECMDEXECOPT_DODEFAULT);
	  }
	  if (s == DECMDF_DISABLED || s == DECMDF_NOTSUPPORTED) {
  		FontSize.disabled = true;
	  } else {
  		FontSize.disabled = false;
  		FontSize.value = tbContentElement.ExecCommand(DECMD_GETFONTSIZE, OLECMDEXECOPT_DODEFAULT);
	  }
  }
  if ("complete" == document.readyState && false == initialDocComplete){ 
    MENU_FILE_OPEN_onclick();
  	initialDocComplete = true;
  }
  if (tbContentElement.isDirty){
// Could use this spot to enable the Save button..
	  MENU_FILE_SAVE_onclick();
  }
}

function tbContentElement_DocumentComplete() {
	return;
    if (initialDocComplete) {
	    if (tbContentElement.CurrentDocumentPath == "") {
        URL_VALUE.value = "http://";
    }
    else {
      URL_VALUE.value = tbContentElement.CurrentDocumentPath;
    }
  }
  initialDocComplete = true;
  docComplete = true;
}

// modified to get content from a text area 
function MENU_FILE_OPEN_onclick() {
    tbContentElement.DocumentHTML="<BASE HREF=\""+ThisURL+"\"> <link rel=\"stylesheet\" type=\"text\/css\" href=\"stylesheet.css\">" + parent.document.forms[1].elements['data[page_text][0]'].value;
}

// modified to save content from to a text area 
function MENU_FILE_SAVE_onclick() {
  var filteredHTML;
  filteredHTML = "";
  if (displayMode == 'RICH') {
	if (tbContentElement.DOM.body.innerHTML != "")
		filteredHTML = tbContentElement.FilterSourceCode (tbContentElement.DOM.body.innerHTML);
  } else {
	if (tbContentElement.DOM.body.innerText != "")
		filteredHTML = tbContentElement.FilterSourceCode (tbContentElement.DOM.body.innerText);
  }
  if (filteredHTML != ""){
	  filteredHTML = delAbsolutePaths(filteredHTML);
	  filteredHTML = fix4NS(filteredHTML);
	  filteredHTML = fixCopyright(filteredHTML);
  }
  // ideally where it should save should be dynamic. hard coding will do for now 
  parent.document.forms[1].elements['data[page_text][0]'].value = filteredHTML;
  return true;
}


function MENU_FILE_SAVEAS_onclick() {
  tbContentElement.SaveDocument("", true);
  tbContentElement.focus();
}

function DECMD_VISIBLEBORDERS_onclick() {
  tbContentElement.ShowBorders = !tbContentElement.ShowBorders;
  tbContentElement.focus();
}

function DECMD_UNORDERLIST_onclick() {
  tbContentElement.ExecCommand(DECMD_UNORDERLIST,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_UNDO_onclick() {
  tbContentElement.ExecCommand(DECMD_UNDO,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_UNDERLINE_onclick() {
  tbContentElement.ExecCommand(DECMD_UNDERLINE,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_SNAPTOGRID_onclick() {
  tbContentElement.SnapToGrid = !tbContentElement.SnapToGrid;
  tbContentElement.focus();
}

function DECMD_SHOWDETAILS_onclick() {
  tbContentElement.ShowDetails = !tbContentElement.ShowDetails;
  tbContentElement.focus();
}

function DECMD_SETFORECOLOR_onclick() {
  var arr = showModalDialog( "selcolor.php?language=<?php echo $language; ?>",
                             "",
                             "font-family:Verdana; font-size:12; dialogWidth:30em; dialogHeight:31em" );
  if (arr != null) {
    tbContentElement.ExecCommand(DECMD_SETFORECOLOR,OLECMDEXECOPT_DODEFAULT, arr);
  }
}

function DECMD_SETBACKCOLOR_onclick() {
  var arr = showModalDialog( "selcolor.php?language=<?php echo $language; ?>",
                             "",
                             "font-family:Verdana; font-size:12; dialogWidth:30em; dialogHeight:31em" );
  if (arr != null) {
    tbContentElement.ExecCommand(DECMD_SETBACKCOLOR,OLECMDEXECOPT_DODEFAULT, arr);
  }
  tbContentElement.focus();
}

function DECMD_SELECTALL_onclick() {
  tbContentElement.ExecCommand(DECMD_SELECTALL,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_REDO_onclick() {
  tbContentElement.ExecCommand(DECMD_REDO,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_PASTE_onclick() {
  tbContentElement.ExecCommand(DECMD_PASTE,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_OUTDENT_onclick() {
  tbContentElement.ExecCommand(DECMD_OUTDENT,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_ORDERLIST_onclick() {
  tbContentElement.ExecCommand(DECMD_ORDERLIST,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_MAKE_ABSOLUTE_onclick() {
  tbContentElement.ExecCommand(DECMD_MAKE_ABSOLUTE,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_LOCK_ELEMENT_onclick() {
  tbContentElement.ExecCommand(DECMD_LOCK_ELEMENT,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_JUSTIFYRIGHT_onclick() {
  tbContentElement.ExecCommand(DECMD_JUSTIFYRIGHT,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_JUSTIFYLEFT_onclick() {
  tbContentElement.ExecCommand(DECMD_JUSTIFYLEFT,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_JUSTIFYCENTER_onclick() {
  tbContentElement.ExecCommand(DECMD_JUSTIFYCENTER,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_ITALIC_onclick() {
  tbContentElement.ExecCommand(DECMD_ITALIC,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_INDENT_onclick() {
  tbContentElement.ExecCommand(DECMD_INDENT,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

// Added to let users upload new files.
function DECMD_UPLOAD_FILE_onclick() {

	window.open("upload.php?language=<?php echo $language; ?>", "UploadWindow", 'width=355,height=198,scrollbars=no,resizable=no,status=no,titlebar=no,toolbar=no,dependant=yes');
}

//modified to use the custom control to browse server side images 
function DECMD_IMAGE_onclick() {
  arr=null;
  var args=new Array();
  //alert(tbContentElement.DOM.selection.type);
  //var rg = tbContentElement.DOM.selection.createRange();
  //rg.collapse;
  //alert(tbContentElement.DOM.selection.type);
  
  if(tbContentElement.DOM.selection.type == "Control"){
     var oImg = tbContentElement.DOM.selection.createRange().item(0);
     args["ImgSrc"] = oImg.src;
     args["AltText"] = oImg.alt;
     args["ImgBorder"] = oImg.border;
     args["HorSpace"] = oImg.hspace;
     args["VerSpace"] = oImg.vspace;
     args["ImgAlign"] = oImg.align;
     args["ImgHeight"] = oImg.height;
     args["ImgWidth"] = oImg.width;
     args["ImgLink"] = "";
	 args["ImgLink_Target"] = "";

	 // Henri
     
    // ------- Find out if this image has a link - SCOTT  8/30/02 -----------
	// get the HTML of the parent of the selected control
	var selectedLink = oImg.parentElement.outerHTML;
	
	// now parse the HTML in to get the contents of the HREF attribute
	// if selectedLink doesn't begin with an <a tag, then there is no link here
	var re=/^<a/i
	var hadLink = re.exec(selectedLink);
	if (hadLink) {	// There's an <a tag so continue

		// Let's get the href value. 
		//re=/(href=("|'))([^"^']+)("|')/i	//Original by SCOTT
		re=/(?:href=)(?:"|')([^"^']+)(?:"|')/i	//Modified by HENRI
		hadLink = re.exec(selectedLink);
		if (hadLink) {
			args["ImgLink"] = hadLink[1]; }

		// Let's get the target value, if it exists. - HENRI 09/07/02
		re=/(?:target=)([^"^']\w+)/i	
		hadLink = re.exec(selectedLink);
		if (hadLink) {
			args["ImgLink_Target"] = hadLink[1]; } // End of mod by Henri
	}
	//------------------------------------------------------

  } 
  // If user selection includes some text (ie: by dragging the cursor over the image) we can't work with it, so tell them what to do.
 if (tbContentElement.DOM.selection.type == "Text") {
	 alert ("*** <?php echo $text['invalid_selection']; ?> ***\n\n<?php echo $text['error1']; ?>\n\n<?php echo $text['instruct1']; ?>");
 } else {
	 // --- dialogHeight was changed from 42em to 45em - SCOTT  8/30/02 ----
  arr = showModalDialog( "insimage.php?language=<?php echo $language; ?>&BASEURL=<?php echo urlencode($BASEURL); ?>",
                             args,
								 "font-family:Verdana; font-size:12; dialogWidth:457px; dialogHeight:560px; help:no; status:no;");

		// -------- NEW CODE TO ADD LINK TO IMAGE - SCOTT 8/30/02
		if (arr != null){
		  // check to see if returning image info has a link specified, if it does, add the <a> tag
		  sHTML='';
		  if (arr["ImgLink"] != null & arr["ImgLink"]!='') {
			  sHTML='<a href="' + arr["ImgLink"] + '" target="' + arr["ImgLink_Target"] + '"> ';
		  }
		  sHTML=sHTML + '<img src="' + arr["ImgSrc"] + '" height="' + arr["ImgHeight"] + '" width="' + arr["ImgWidth"] + '" alt="' + arr["AltText"] + '" vspace="' + arr["VerSpace"] + '" hspace="' + arr["HorSpace"] +  '"align="' + arr["ImgAlign"] +'"border="' + arr["ImgBorder"]+ '">';
		  if (arr["ImgLink"] != null & arr["ImgLink"]!='') {
			  sHTML=sHTML+'</a>';	// Close the <a> tag if there was a link.
		  }
		   if (displayMode == 'RICH'){
			   // remove existing image including the outside <a> tags
			   if (hadLink) {
					if (oImg) {
						oImg.parentElement.outerHTML = "";
				   }
			   }
			   //  the image didn't have <a> tags, so remove just it  
			   else {
					if(tbContentElement.DOM.selection.type == "Control")
						tbContentElement.DOM.selection.clear();
			   }
			  // now insert the HTML we just created. (We're not calling richEditorInsertHTML because we've already deleted the image and link)
			  tbContentElement.DOM.selection.createRange().pasteHTML(sHTML);
		   }
		   check_local_images();
		}
	}
  // ----- END OF NEW CODE --------------------
  
  /* ----- ORIGINAL CODE ------------------------
  if (arr != null){
     sHTML='<img src="' + arr["ImgSrc"] + '" height="' + arr["ImgHeight"] + '" width="' + arr["ImgWidth"] + '" alt="' + arr["AltText"] + '" vspace="' + arr["VerSpace"] + '" hspace="' + arr["HorSpace"] +  '"align="' + arr["ImgAlign"] +'"border="' + arr["ImgBorder"]+ '">';     if (displayMode == 'RICH'){
     richEditorInsertHTML(sHTML);
     check_local_images();
  }
  ------ END OF ORIGINAL CODE --------------- */
  
  /* Original command, before the custom dialog was added
  this browses the local PC's file system, which is useless for a server based
  application. Before you think why can't we parse the file, find out references
  to local PC images (ie, src=file://..) and then automatically upload these images
  from the PC to the server - that is possible via a custom signed ActiveX control.
  I  just don't know how to make one :-( 
    tbContentElement.ExecCommand(DECMD_IMAGE,OLECMDEXECOPT_PROMPTUSER);
    */
  tbContentElement.focus();
}

// Modified to browse server-side files for making the link 
function DECMD_HYPERLINK_onclick() {
	var arr, args, oSel, oParent, sType;
	oSel = tbContentElement.DOM.selection;
	sType=oSel.type;
	// temporary fix to tell them to use the image icon instead of the link icon -- SCOTT  9/6/02 --
	if (sType == "Control") {
		alert ("*** <?php echo $text['invalid_selection']; ?> ***\n\n<?php echo $text['instruct2']; ?>");
	}
	else {
	var oRange = oSel.createRange();
	var oElement = oRange.parentElement();

	// Check if selected text only has an incomplete set of <a> tags. (If only part of a link was selected)
	if (oElement.tagName != "A") { // This isn't an <A> element.. 
		if (oRange.htmlText.match(/<a/i) != null) {	// So there shouldn't be any <A tags...
			alert("*** <?php echo $text['invalid_selection']; ?> ***\n\n<?php echo $text['error2']; ?>\n\n<?php echo $text['instruct3']; ?>");
			return;
		}
	}

	arr=null;
	args=new Array();
	// Initialize array values	(Default values are set in the inslink.php page itself.)
	args["LinkUrl"] = "";
	args["LinkTarget"] = "";

	// Check to see if there is already a hyperlink in the selected text range.
	var cmdEnable = oRange.queryCommandEnabled("Unlink");
	if(cmdEnable){	// Was there a hyperlink in the selected text?
		if (oRange.htmlText == oRange.text) {
			alert("*** <?php echo $text['invalid_selection']; ?> ***\n\n<?php echo $text['error3']; ?>\n\n<?php echo $text['instruct3']; ?>");
			return;
		}

		var aLINK = oRange.htmlText.match(/<a.*href=['"]*([^"' ]+)['"]*/i);
		var aTARGET = oRange.htmlText.match(/<a.*target=['"]*([^"' ]+)['"]*/i);
		args["LinkUrl"] = aLINK[1];
		args["LinkTarget"] = (aTARGET != null?aTARGET[1]:null);
	} 

	arr = showModalDialog( "inslink.php?language=<?php echo $language; ?>&BASEURL=<?php echo urlencode($BASEURL); ?>", 
 						 args,
						 "font-family:Verdana; font-size:12; dialogWidth:391px; dialogHeight:466px; help:no; status:no;");
	
	if (arr != null){
		if(arr["LinkUrl"] != ""){
		  oRange.pasteHTML("<a href=\"" + arr["LinkUrl"] + "\"" + (arr["LinkTarget"] != "" ?  "target=" + arr["LinkTarget"] : "") + ">" + oRange.text + "</a>");
		} else {
		   // clear the selection of A tags.
		   oRange.pasteHTML( oRange.text );
		}
	}

	tbContentElement.focus();
}
}

function DECMD_FINDTEXT_onclick() {
  tbContentElement.ExecCommand(DECMD_FINDTEXT,OLECMDEXECOPT_PROMPTUSER);
  tbContentElement.focus();
}

function DECMD_DELETE_onclick() {
	alert("deleting it");
  tbContentElement.ExecCommand(DECMD_DELETE,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_CUT_onclick() {
  tbContentElement.ExecCommand(DECMD_CUT,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_COPY_onclick() {
  tbContentElement.ExecCommand(DECMD_COPY,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function DECMD_BOLD_onclick() {
  tbContentElement.ExecCommand(DECMD_BOLD,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function OnMenuShow(QueryStatusArray) {
  var i, s;
 
  for (i=0; i<QueryStatusArray.length; i++) {
  s = tbContentElement.QueryStatus(QueryStatusArray[i].command);
  if (s == DECMDF_DISABLED || s == DECMDF_NOTSUPPORTED) {
      TBSetState(QueryStatusArray[i].element, "gray"); 
    } else if (s == DECMDF_ENABLED  || s == DECMDF_NINCHED) {
       TBSetState(QueryStatusArray[i].element, "unchecked"); 
    } else { // DECMDF_LATCHED
       TBSetState(QueryStatusArray[i].element, "checked");
    }
  }
  tbContentElement.focus();
}

function INTRINSICS_onclick(html) {
  var selection;
  selection = tbContentElement.DOM.selection.createRange();
  selection.pasteHTML(html);
  tbContentElement.focus();
}

function TABLE_DELETECELL_onclick() {
  tbContentElement.ExecCommand(DECMD_DELETECELLS,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function TABLE_DELETECOL_onclick() {
  tbContentElement.ExecCommand(DECMD_DELETECOLS,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function TABLE_DELETEROW_onclick() {
  tbContentElement.ExecCommand(DECMD_DELETEROWS,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function TABLE_INSERTCELL_onclick() {
  tbContentElement.ExecCommand(DECMD_INSERTCELL,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function TABLE_INSERTCOL_onclick() {
  tbContentElement.ExecCommand(DECMD_INSERTCOL,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function TABLE_INSERTROW_onclick() {
  tbContentElement.ExecCommand(DECMD_INSERTROW,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function TABLE_INSERTTABLE_onclick() {
  InsertTable();
  tbContentElement.focus();
}

function TABLE_MERGECELL_onclick() {
  tbContentElement.ExecCommand(DECMD_MERGECELLS,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function TABLE_SPLITCELL_onclick() {
  tbContentElement.ExecCommand(DECMD_SPLITCELL,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function FORMAT_FONT_onclick() {
  tbContentElement.ExecCommand(DECMD_FONT,OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function MENU_FILE_NEW_onclick() {
  if (tbContentElement.IsDirty) {
    if (confirm("Save changes?")) {
      MENU_FILE_SAVE_onclick();
    }
  }
  URL_VALUE.value = "http://";
  tbContentElement.NewDocument();
  tbContentElement.focus();
}

function URL_VALUE_onkeypress() {
  if (event.keyCode == 13) {

  /**
    NOTE: The user is not prompted to save the the current 
    document before the call to LoadURL. Therefore the
    user will lose any edits he has made to the current document
    after the call to LoadURL. The purpose of the sample is
    to provide a basic demonstration of how to use the DHTMLEdit 
    control. A complete implementation would check if there were
    unsaved edits to the current document by testing the IsDirty
    property on the control. If the IsDirty property is true, the
    user should be given an opporunity to save his edits first.

    See the implementation of MENU_FILE_NEW_onclick() in this sample
    for a demonstration how to do this.
  **/
    docComplete = false;
    tbContentElement.LoadURL(URL_VALUE.value);
    tbContentElement.focus();
  }
}

function ZORDER_ABOVETEXT_onclick() {
  tbContentElement.ExecCommand(DECMD_BRING_ABOVE_TEXT, OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function ZORDER_BELOWTEXT_onclick() {
  tbContentElement.ExecCommand(DECMD_SEND_BELOW_TEXT, OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function ZORDER_BRINGFORWARD_onclick() {
  tbContentElement.ExecCommand(DECMD_BRING_FORWARD, OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function ZORDER_BRINGFRONT_onclick() {
  tbContentElement.ExecCommand(DECMD_BRING_TO_FRONT, OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function ZORDER_SENDBACK_onclick() {
  tbContentElement.ExecCommand(DECMD_SEND_TO_BACK, OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function ZORDER_SENDBACKWARD_onclick() {
  tbContentElement.ExecCommand(DECMD_SEND_BACKWARD, OLECMDEXECOPT_DODEFAULT);
  tbContentElement.focus();
}

function TOOLBARS_onclick(toolbar) {
  if (toolbar.TBSTATE == "hidden") {
    TBSetState(toolbar, "dockedTop");
  } else {
    TBSetState(toolbar, "hidden");
  }
  tbContentElement.focus();
}

function ParagraphStyle_onchange() {	 
  tbContentElement.ExecCommand(DECMD_SETBLOCKFMT, OLECMDEXECOPT_DODEFAULT, ParagraphStyle.value);
  tbContentElement.focus();
}

function FontName_onchange() {
  tbContentElement.ExecCommand(DECMD_SETFONTNAME, OLECMDEXECOPT_DODEFAULT, FontName.value);
  tbContentElement.focus();
}

function FontSize_onchange() {
  tbContentElement.ExecCommand(DECMD_SETFONTSIZE, OLECMDEXECOPT_DODEFAULT, parseInt(FontSize.value));
  tbContentElement.focus();
}
//-->
</script>

<script LANGUAGE="javascript" FOR="tbContentElement" EVENT="DisplayChanged">
<!--
return tbContentElement_DisplayChanged()
//-->
</script>

<script LANGUAGE="javascript" FOR="tbContentElement" EVENT="DocumentComplete">
<!--
return tbContentElement_DocumentComplete()
//-->
</script>

<script LANGUAGE="javascript" FOR="tbContentElement" EVENT="ShowContextMenu">
<!--
return tbContentElement_ShowContextMenu()
//-->
</script>

<script LANGUAGE="javascript" FOR="tbContentElement" EVENT="ContextMenuAction(itemIndex)">
<!--
return tbContentElement_ContextMenuAction(itemIndex)
//-->
</script>

</head>
<body LANGUAGE="javascript" onload="return window_onload()">
<!-- Toolbars -->
<div class="tbToolbar" ID="StandardToolbar">
    <!-- commented out because we don't use these options. Saving and opening files are
         done by external scripts, probably from a database. 
  <div class="tbButton" ID="MENU_FILE_NEW" TITLE="New File" LANGUAGE="javascript" onclick="return MENU_FILE_NEW_onclick()">
    <img class="tbIcon" src="images/newdoc.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="MENU_FILE_OPEN" TITLE="Open File" LANGUAGE="javascript" onclick="return MENU_FILE_OPEN_onclick()">
    <img class="tbIcon" src="images/open.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="MENU_FILE_SAVE" TITLE="Save File" LANGUAGE="javascript" onclick="return MENU_FILE_SAVE_onclick()">
    <img class="tbIcon" src="images/save.gif" WIDTH="23" HEIGHT="22">
  </div>

  <div class="tbSeparator"></div>
//-->

  <div id=swapButton class="tbButton" TITLE="<?php echo $text['tooltip1']; ?>" LANGUAGE="javascript" onClick="if(displayMode=='CODE'){swapToMode='RICH'}else{swapToMode='CODE'};setDisplayMode(swapToMode);window.event.cancelBubble=true;" accesskey=w><IMG class="tbIcon" src="images/HTML.gif" " WIDTH="23" HEIGHT="22"></div>
<!-- commented out because we don't need it.
  <div id=cleanButton class="tbButton" TITLE="Cleanup HTML. CANNOT BE UNDONE. Please see documentation for proper IE security settings. Custom font settings and text colors will be removed. Please use this if you want a standardized look for your page." LANGUAGE="javascript" onClick="cleanHTML(displayMode)"><IMG class="tbIcon" src="images/tidy.gif" " WIDTH="23" HEIGHT="22"></div>
// -->
  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_CUT" TITLE="<?php echo $text['tooltip2']; ?>" LANGUAGE="javascript" onclick="return DECMD_CUT_onclick()">
    <img class="tbIcon" src="images/cut.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_COPY" TITLE="<?php echo $text['tooltip3']; ?>" LANGUAGE="javascript" onclick="return DECMD_COPY_onclick()">
    <img class="tbIcon" src="images/copy.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_PASTE" TITLE="<?php echo $text['tooltip4']; ?>" LANGUAGE="javascript" onclick="return DECMD_PASTE_onclick()">
    <img class="tbIcon" src="images/paste.gif" WIDTH="23" HEIGHT="22">
  </div>

  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_UNDO" TITLE="<?php echo $text['tooltip5']; ?>" LANGUAGE="javascript" onclick="return DECMD_UNDO_onclick()">
    <img class="tbIcon" src="images/undo.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_REDO" TITLE="<?php echo $text['tooltip6']; ?>" LANGUAGE="javascript" onclick="return DECMD_REDO_onclick()">
    <img class="tbIcon" src="images/redo.gif" WIDTH="23" HEIGHT="22">
  </div>

  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_FINDTEXT" TITLE="<?php echo $text['tooltip7']; ?>" LANGUAGE="javascript" onclick="return DECMD_FINDTEXT_onclick()">
    <img class="tbIcon" src="images/find.gif" WIDTH="23" HEIGHT="22">
  </div>
</div>

<div class="tbToolbar" ID="AbsolutePositioningToolbar">
  <div class="tbButton" ID="DECMD_VISIBLEBORDERS" TITLE="<?php echo $text['tooltip8']; ?>" TBTYPE="toggle" LANGUAGE="javascript" onclick="return DECMD_VISIBLEBORDERS_onclick()">
    <img class="tbIcon" src="images/borders.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_SHOWDETAILS" TITLE="<?php echo $text['tooltip9']; ?>" TBTYPE="toggle" LANGUAGE="javascript" onclick="return DECMD_SHOWDETAILS_onclick()">
    <img class="tbIcon" src="images/details.gif" WIDTH="23" HEIGHT="22">
  </div>
  
  <div class="tbSeparator"></div>
  <div class="tbButton" ID="DECMD_LOCK_ELEMENT" TBTYPE="toggle" LANGUAGE="javascript" TITLE="<?php echo $text['tooltip10']; ?>" onclick="return DECMD_LOCK_ELEMENT_onclick()">
    <img class="tbIcon" src="images/lock.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_MAKE_ABSOLUTE" TBTYPE="toggle" LANGUAGE="javascript" TITLE="<?php echo $text['tooltip11']; ?>" onclick="return DECMD_MAKE_ABSOLUTE_onclick()">
    <img class="tbIcon" src="images/abspos.gif" WIDTH="23" HEIGHT="22">
  </div>
  
  <div class="tbButton" ID="DECMD_SNAPTOGRID" TITLE="<?php echo $text['tooltip12']; ?>" TBTYPE="toggle" LANGUAGE="javascript" onclick="return DECMD_SNAPTOGRID_onclick()">
    <img class="tbIcon" src="images/snapgrid.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbSeparator"></div>
  <div class="tbButton" ID="DECMD_INSERTTABLE" TITLE="<?php echo $text['tooltip13']; ?>" LANGUAGE="javascript" onclick="return TABLE_INSERTTABLE_onclick()">
    <img class="tbIcon" src="images/instable.gif" WIDTH="23" HEIGHT="22">
  </div>

  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_INSERTROW" TITLE="<?php echo $text['tooltip14']; ?>" LANGUAGE="javascript" onclick="return TABLE_INSERTROW_onclick()">
    <img class="tbIcon" src="images/insrow.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_DELETEROWS" TITLE="<?php echo $text['tooltip15']; ?>" LANGUAGE="javascript" onclick="return TABLE_DELETEROW_onclick()">
    <img class="tbIcon" src="images/delrow.gif" WIDTH="23" HEIGHT="22">
  </div>
 
  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_INSERTCOL" TITLE="<?php echo $text['tooltip16']; ?>" LANGUAGE="javascript" onclick="return TABLE_INSERTCOL_onclick()">
    <img class="tbIcon" src="images/inscol.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_DELETECOLS" TITLE="<?php echo $text['tooltip17']; ?>" LANGUAGE="javascript" onclick="return TABLE_DELETECOL_onclick()">
    <img class="tbIcon" src="images/delcol.gif" WIDTH="23" HEIGHT="22">
  </div>
  
  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_INSERTCELL" TITLE="<?php echo $text['tooltip18']; ?>" LANGUAGE="javascript" onclick="return TABLE_INSERTCELL_onclick()">
    <img class="tbIcon" src="images/inscell.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_DELETECELLS" TITLE="<?php echo $text['tooltip19']; ?>" LANGUAGE="javascript" onclick="return TABLE_DELETECELL_onclick()">
    <img class="tbIcon" src="images/delcell.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_MERGECELLS" TITLE="<?php echo $text['tooltip20']; ?>" LANGUAGE="javascript" onclick="return TABLE_MERGECELL_onclick()">
    <img class="tbIcon" src="images/mrgcell.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_SPLITCELL" TITLE="<?php echo $text['tooltip21']; ?>" LANGUAGE="javascript" onclick="return TABLE_SPLITCELL_onclick()">
    <img class="tbIcon" src="images/spltcell.gif" WIDTH="23" HEIGHT="22">
  </div>

  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_HYPERLINK" TITLE="<?php echo $text['tooltip22']; ?>" LANGUAGE="javascript" onclick="return DECMD_HYPERLINK_onclick()">
    <img class="tbIcon" src="images/link.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_IMAGE" TITLE="<?php echo $text['tooltip23']; ?>" LANGUAGE="javascript" onclick="return DECMD_IMAGE_onclick()">
    <img class="tbIcon" src="images/image.gif" WIDTH="23" HEIGHT="22">
  </div>
  
</div>

<div class="tbToolbar" ID="FormatToolbar">
  <select ID="ParagraphStyle" class="tbGeneral" style="width:90" TITLE="<?php echo $text['tooltip24']; ?>" LANGUAGE="javascript" onchange="return ParagraphStyle_onchange()">
    <option value="Normal"><?php echo $text['paragraph_style1']; ?></option>
    <option value="Heading 1"><?php echo $text['paragraph_style2']; ?></option>
    <option value="Heading 2"><?php echo $text['paragraph_style3']; ?></option>
    <option value="Heading 3"><?php echo $text['paragraph_style4']; ?></option>
    <option value="Heading 4"><?php echo $text['paragraph_style5']; ?></option>
    <option value="Heading 5"><?php echo $text['paragraph_style6']; ?></option>
    <option value="Heading 6"><?php echo $text['paragraph_style7']; ?></option>
    <option value="Address"><?php echo $text['paragraph_style8']; ?></option>
    <option value="Formatted"><?php echo $text['paragraph_style9']; ?></option>
  </select>
  <select ID="FontName" class="tbGeneral" style="width:140" TITLE="<?php echo $text['tooltip25']; ?>" LANGUAGE="javascript" onchange="return FontName_onchange()">
    <option value="Arial"><?php echo $text['font_name1']; ?></option>
    <option value="Verdana"><?php echo $text['font_name2']; ?></option>
    <option value="Courier New"><?php echo $text['font_name3']; ?></option>
    <option value="Times New Roman"><?php echo $text['font_name4']; ?></option>
  </select>
  <select ID="FontSize" class="tbGeneral" style="width:40" TITLE="<?php echo $text['tooltip26']; ?>" LANGUAGE="javascript" onchange="return FontSize_onchange()">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
  </select>
  
  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_BOLD" TITLE="<?php echo $text['tooltip27']; ?>" TBTYPE="toggle" LANGUAGE="javascript" onclick="return DECMD_BOLD_onclick()">
    <img class="tbIcon" src="images/bold.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_ITALIC" TITLE="<?php echo $text['tooltip28']; ?>" TBTYPE="toggle" LANGUAGE="javascript" onclick="return DECMD_ITALIC_onclick()">
    <img class="tbIcon" src="images/italic.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_UNDERLINE" TITLE="<?php echo $text['tooltip29']; ?>" TBTYPE="toggle" LANGUAGE="javascript" onclick="return DECMD_UNDERLINE_onclick()">
    <img class="tbIcon" src="images/under.gif" WIDTH="23" HEIGHT="22">
  </div>
  
  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_SETFORECOLOR" TITLE="<?php echo $text['tooltip30']; ?>" LANGUAGE="javascript" onclick="return DECMD_SETFORECOLOR_onclick()">
    <img class="tbIcon" src="images/fgcolor.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_SETBACKCOLOR" TITLE="<?php echo $text['tooltip31']; ?>" LANGUAGE="javascript" onclick="return DECMD_SETBACKCOLOR_onclick()">
    <img class="tbIcon" src="images/bgcolor.gif" WIDTH="23" HEIGHT="22">
  </div>
  
  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_JUSTIFYLEFT" TITLE="<?php echo $text['tooltip32']; ?>" TBTYPE="toggle" NAME="Justify" LANGUAGE="javascript" onclick="return DECMD_JUSTIFYLEFT_onclick()">
    <img class="tbIcon" src="images/left.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_JUSTIFYCENTER" TITLE="<?php echo $text['tooltip33']; ?>" TBTYPE="toggle" NAME="Justify" LANGUAGE="javascript" onclick="return DECMD_JUSTIFYCENTER_onclick()">
    <img class="tbIcon" src="images/center.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_JUSTIFYRIGHT" TITLE="<?php echo $text['tooltip34']; ?>" TBTYPE="toggle" NAME="Justify" LANGUAGE="javascript" onclick="return DECMD_JUSTIFYRIGHT_onclick()">
    <img class="tbIcon" src="images/right.gif" WIDTH="23" HEIGHT="22">
  </div>

  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_ORDERLIST" TITLE="<?php echo $text['tooltip35']; ?>" TBTYPE="toggle" LANGUAGE="javascript" onclick="return DECMD_ORDERLIST_onclick()">
    <img class="tbIcon" src="images/numlist.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_UNORDERLIST" TITLE="<?php echo $text['tooltip36']; ?>" TBTYPE="toggle" LANGUAGE="javascript" onclick="return DECMD_UNORDERLIST_onclick()">
    <img class="tbIcon" src="images/bullist.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbSeparator"></div>

  <div class="tbButton" ID="DECMD_OUTDENT" TITLE="<?php echo $text['tooltip37']; ?>" LANGUAGE="javascript" onclick="return DECMD_OUTDENT_onclick()">
    <img class="tbIcon" src="images/deindent.gif" WIDTH="23" HEIGHT="22">
  </div>
  <div class="tbButton" ID="DECMD_INDENT" TITLE="<?php echo $text['tooltip38']; ?>" LANGUAGE="javascript" onclick="return DECMD_INDENT_onclick()">
    <img class="tbIcon" src="images/inindent.gif" WIDTH="23" HEIGHT="22">
  </div>

  <div class="tbSeparator"></div>

  <div class="tbButton" ID="MENU_UPLOAD_FILE" TITLE="<?php echo $text['tooltip39']; ?>" LANGUAGE="javascript" onclick="return DECMD_UPLOAD_FILE_onclick()">
    <img class="tbIcon" src="images/upload.gif" WIDTH="23" HEIGHT="22">
  </div>

</div>

<!-- DHTML Editing control Object. This will be the body object for the toolbars. -->
<object ID="tbContentElement" CLASS="tbContentElement" CLASSID="clsid:2D360201-FFF5-11D1-8D03-00A0C959BC0A" VIEWASTEXT>
	<param name=Scrollbars value=true>
</object>

<!-- DEInsertTableParam Object -->
<object ID="ObjTableInfo" CLASSID="clsid:47B0DFC7-B7A3-11D1-ADC5-006008A5848C" VIEWASTEXT>
</object>

<!-- DEGetBlockFmtNamesParam Object -->
<object ID="ObjBlockFormatInfo" CLASSID="clsid:8D91090E-B955-11D1-ADC5-006008A5848C" VIEWASTEXT>
</object>

<!-- Toolbar Code File. Note: This must always be the last thing on the page -->
<script LANGUAGE="Javascript">
<!--
var tbEventSrcElement;

//
// Public Error Return Values
// --------------------------
TB_STS_OK = "OK" // Success return
TB_E_INVALID_CLASS = "Invalid class value" // An element has an unrecognized class attribute (probably a misspelling)
TB_E_INVALID_TYPE = "Invalid TBTYPE value"
TB_E_INVALID_STATE = "Invalid TBSTATE value"
TB_E_NO_ID = "Element does not have an ID"

//
//=================================================================================================
// 
// Private Attributes
// ------------------
// TBTOOLBARWIDTH: Width of the toolbar (in px)
// TBUSERONCLICK: Temporary storage of an element's original onclick handler
//
// Private Constants. These can be used along with toolbar.css to change the look of the toolbar package.
// -----------------
TB_DISABLED_OPACITY_FILTER = "alpha(opacity=25)"
TB_HANDLE_WIDTH = 10
TB_HANDLE = '<DIV class=tbHandleDiv style="LEFT: 3"> </DIV>' +
            '<DIV class=tbHandleDiv style="LEFT: 6"> </DIV>'

TB_TOOLBAR_PADDING = 4
TB_SEPARATOR_PADDING = 5
TB_CLIENT_AREA_GAP = 0

//
// Private Globals
// ---------------
var TBInitialized = false; // Set to true when the package has initialized.
var tbToolbars = new Array();  // Array of all toolbars.
var tbContentElementObject = null; // Content element.
var tbContentElementTop = 0;  // Y pixel coordinate of the top of the content element.
var tbContentElementBottom = 0; // Y pixel coordinate of the bottom of the content element.
var tbLastHeight = 0; // Previous client window height (before resize in process).
var tbLastWidth = 0; // Previous client window width. 
var tbRaisedElement = null; // Current toolbar button that is being shown raised.
var tbOnClickInProcess;	// Executing user's onClick event.
var tbMouseOutWhileInOnClick;  // An onmouseout event occurred while executing the user's onClick event.

//
// Functions
//

// Public function for changing an element's state. 
function TBSetState(element, newState) {

  newState = newState.toLowerCase();

  switch (element.className) {
    case "tbToolbar" :
      if ((newState != "dockedtop") && (newState != "dockedbottom") && (newState != "hidden")) {
        return TB_E_INVALID_STATE;    
      }
      element.TBSTATE = newState;
      if (newState == "hidden") {
        element.style.visibility = "hidden";
      } else {
        element.style.visibility = "visible";
      }
      TBLayoutToolbars();
      TBLayoutBodyElement();      
    break;
    
    case "tbButton" :
    case "tbButtonDown" :
    case "tbButtonMouseOverUp" :
    case "tbButtonMouseOverDown" :
    case "tbMenuItem" :
      if ((newState != "gray") && (newState != "checked") && (newState != "unchecked")) {
        return TB_E_INVALID_STATE;
      }
        
      currentState = element.TBSTATE;
      if (currentState == "") {
        currentState = "checked";
      }
      
      if (newState == currentState) {
        return;
      }

      if (element.className != "tbMenuItem") {
        image = element.children.tags("IMG")[0];
     
        // Going into disabled state  
        if (newState == "gray") {
          element.className = "tbButton";  
          image.className = "tbIcon";  
          element.style.filter = TB_DISABLED_OPACITY_FILTER;
        }
      
        // Coming out of disabled state. Remove disabled look.
        if (currentState == "gray") {
          element.style.filter = "";
        }
      
        if (newState == "checked") {
           element.className = "tbButtonDown";  
           image.className = "tbIconDown";
        } else { //unchecked
           element.className = "tbButton";  
           image.className = "tbIcon";
        }  
      }

      if ((element.TBTYPE == "radio") && (newState == "checked")) {
        radioButtons = element.parentElement.children;
        for (i=0; i<radioButtons.length; i++) {
          if ((radioButtons[i].NAME == element.NAME) && (radioButtons[i] != element)) {
            radioButtons[i].TBSTATE = "unchecked";
            
            if (element.className != "tbMenuItem") {
              radioButtons[i].className = "tbButton";
              radioButtons[i].children.tags("IMG")[0].className = "tbIcon";
            }
          }
        }
      }
      
      element.TBSTATE = newState;
      break;
      
    default :
      return TB_E_INVALID_CLASS;
  }
  return TB_STS_OK;
} //TBSetState


// Event handler for tbContentElementObject onmouseover events.
function TBContentElementMouseOver() {
  if (tbRaisedElement) {
    switch (tbRaisedElement.className) {
    case "tbMenu" :
      // Note: TBShowNormal is in tbmenus.js.
      TBShowNormal(tbRaisedElement);
      break;
    case "tbButtonMouseOverUp" :
      tbRaisedElement.className = "tbButton";
      break;
    case "tbButtonMouseOverDown" :
      tbRaisedElement.className = "tbButtonDown";
      break;
    }
    tbRaisedElement = null;
  }
}


// Global onmouseup handler.
function TBGlobalMouseUp() {
}


// Global onmousedown handler.
function TBGlobalMouseDown() {
  // Always bring down any menus that are being displayed.
  if (typeof(tbMenu) != "undefined") {
    TBHideMenus();
  }
} 


//Global ondragstart and onselectstart handler.
function TBGlobalStartEvents() {
}

//Global mouse move handler.
function TBGlobalMouseMove() {
}


// Hander that simply cancels an event
function TBCancelEvent() {
  event.returnValue=false;
  event.cancelBubble=true;
}


// Toolbar button onmouseover handler
function TBButtonMouseOver() {
  var element, image;

  image = event.srcElement;
  element = image.parentElement;
  
  if (element.TBSTATE == "gray") {
    event.cancelBubble=true;
    return;
  }
  // Change button look based on current state of image.
  if (image.className == "tbIcon") {
    element.className = "tbButtonMouseOverUp";
    tbRaisedElement = element;
  } else if (image.className == "tbIconDown") {
    element.className = "tbButtonMouseOverDown";
  }

  event.cancelBubble=true;
} // TBButtonMouseOver


// Toolbar button onmouseout handler
function TBButtonMouseOut() {
  var element, image;
  
  image = event.srcElement;
  element = image.parentElement;
  if (element.TBSTATE == "gray") {
    event.cancelBubble=true;
    return;
  }
  
  tbRaisedElement = null;
  
  // Are we in the middle of an onClick event? Set a flag for the onclick handler and return if so.
  if (tbOnClickInProcess) {
    tbMouseOutWhileInOnClick = true;
    return;
  }

  switch (image.className) {
    case "tbIcon" :
      // Is the user cancelling unchecking a toggle/radio button by moving out?
      if (((element.TBTYPE == "toggle") || (element.TBTYPE == "radio")) && (element.TBSTATE == "checked")) {
        element.className = "tbButtonDown";
        image.className = "tbIconDown";
      } else {
        element.className = "tbButton";
      }
    break;
      
    case "tbIconDown" :
      // Is the user cancelling checking a toggle/radio button by moving out?
      if (((element.TBTYPE == "toggle") || (element.TBTYPE == "radio")) && (element.TBSTATE == "unchecked")) {
        element.className = "tbButton";
        image.className = "tbIcon";
      } else {
        element.className = "tbButtonDown"
      }
    break;
      
    case "tbIconDownPressed" :
      // The only time we'll see this is if the user is cancelling unchecking a checked toggle/radio
      element.className = "tbButtonDown";
      image.className = "tbIconDown";
    break;  
  }
  event.cancelBubble=true;
} // TBButtonMouseOut


// Toolbar button onmousedown handler
function TBButtonMouseDown() {
  var element, image;
  
  if (typeof(tbMenu) != "undefined") {
    TBHideMenus();
  }
  
  if (event.srcElement.tagName == "IMG") {
    image = event.srcElement;
    element = image.parentElement;
  } else {
    element = event.srcElement;
    image = element.children.tags("IMG")[0];
  }
  if (element.TBSTATE == "gray") {
    event.cancelBubble=true;
    return;
  }
  switch (image.className) {
    case "tbIcon" :
      element.className = "tbButtonMouseOverDown";
      image.className = "tbIconDown";
    break;
      
    case "tbIconDown" :
      if ((element.TBTYPE == "toggle") || (element.TBTYPE == "radio")) {
        image.className = "tbIconDownPressed";
      } else {
        element.className = "tbButton";
        image.className = "tbIcon";
      }
    break;
  }   
  
  event.cancelBubble=true;
  return false;
   
} //TBButtonMouseDown

// Toolbar button onmouseup handler
function TBButtonMouseUp() {
  var element, image, userOnClick, radioButtons, i;
 
  if (event.srcElement.tagName == "IMG") {
    image = event.srcElement;
    element = image.parentElement;
  } else {
    element = event.srcElement;
    image = element.children.tags("IMG")[0];
  }
  
  if (element.TBSTATE == "gray") {
    event.cancelBubble=true;
    return;
  }

  // Make sure this is one of our events
  if ((image.className != "tbIcon") && (image.className != "tbIconDown") && (image.className != "tbIconDownPressed")) {
    return;
  }

  // Initialize tbEventSrcElement so that the user's onClick handler can find out where the
  // event is coming from
  tbEventSrcElement = element;
  
  // Execute the  onclick handler that was on the event originally (user's onclick handler).
  // This is a little tricky; we have to call the anonymous function wrapper that was put around
  // the event by IE. Also, we set a global flag so that we can find out if a mouseout event occurs
  // while processing the user's onclick handler. mouseout and onclick behavior have to change
  // if this happens.
  tbOnClickInProcess = true;
  tbMouseOutWhileInOnClick = false;
  if (element.TBUSERONCLICK) {
    eval(element.TBUSERONCLICK + "anonymous()");
  }
  tbOnClickInProcess = false;
  
  // Is the nomouseover flag set on the toolbar?
  if (element.parentElement.TBTYPE == "nomouseover") {
    tbMouseOutWhileInOnClick = true;
  }

  //Update state and appearance based on type of button
  switch (element.TBTYPE) {
    case "toggle" :
      if (element.TBSTATE == "checked") {
        element.TBSTATE = "unchecked";
        if (tbMouseOutWhileInOnClick) {
          element.className = "tbButton";
        } else {
          element.className = "tbButtonMouseOverUp";
        }
        image.className = "tbIcon";
      } else {
        element.TBSTATE = "checked";
        if (tbMouseOutWhileInOnClick) {
          element.className = "tbButtonDown";
        } else {
          element.className = "tbButtonMouseOverDown";
        }
        image.className = "tbIconDown";
      }
    break;
      
    case "radio" :
      // Turn this element on if its not already on
      if (element.TBSTATE == "checked"){
        image.className = "tbIconDown";
        break;
      }
      element.TBSTATE = "checked";
      if (tbMouseOutWhileInOnClick) {
        element.className = "tbButtonDown";
      } else {
        element.className = "tbButtonMouseOverDown";
      }
      image.className = "tbIconDown";
    
      // Turn off every other radio button in this group by going through everything in the parent container
      radioButtons = element.parentElement.children;
      for (i=0; i<radioButtons.length; i++) {
        if ((radioButtons[i].NAME == element.NAME) && (radioButtons[i] != element)) {
          radioButtons[i].TBSTATE = "unchecked";
          radioButtons[i].className = "tbButton";
          radioButtons[i].children.tags("IMG")[0].className = "tbIcon";
        }
      }
    break;
    
    default : // Regular button
      if (tbMouseOutWhileInOnClick) {
        element.className = "tbButton";
      } else {
        element.className = "tbButtonMouseOverUp";
      }
      image.className = "tbIcon";
  }
  
  event.cancelBubble=true;
  return false;
  
} // TBButtonMouseUp


// Initialize a toolbar button
function TBInitButton(element, mouseOver) {
  var image;
 
  // Make user-settable properties all lowercase and do a validity check
  if (element.TBTYPE) {
    element.TBTYPE = element.TBTYPE.toLowerCase();
    if ((element.TBTYPE != "toggle") && (element.TBTYPE != "radio")) {
      return TB_E_INVALID_TYPE;
    }
  }
  if (element.TBSTATE) {
    element.TBSTATE = element.TBSTATE.toLowerCase();
    if ((element.TBSTATE != "gray") && (element.TBSTATE != "checked") && (element.TBSTATE != "unchecked")) {
      return TB_E_INVALID_STATE;
    }
  }
 
  image = element.children.tags("IMG")[0]; 

  // Set up all our event handlers
  if (mouseOver) {
    element.onmouseover = TBButtonMouseOver;
    element.onmouseout = TBButtonMouseOut;
  }
  element.onmousedown = TBButtonMouseDown; 
  element.onmouseup = TBButtonMouseUp; 
  element.ondragstart = TBCancelEvent;
  element.onselectstart = TBCancelEvent;
  element.onselect = TBCancelEvent;
  element.TBUSERONCLICK = element.onclick; // Save away the original onclick event
  element.onclick = TBCancelEvent;
   
  // Set up initial button state
  if (element.TBSTATE == "gray") {
    element.style.filter = TB_DISABLED_OPACITY_FILTER;
    return TB_STS_OK;
  }
  if (element.TBTYPE == "toggle" || element.TBTYPE == "radio") {
    if (element.TBSTATE == "checked") {
      element.className = "tbButtonDown";
      image.className = "tbIconDown";
    } else {
      element.TBSTATE = "unchecked";
    }
  }
  element.TBINITIALIZED = true;
  return TB_STS_OK;
} // TBInitButton


// Populate a toolbar with the elements within it
function TBPopulateToolbar(tb) {
  var i, elements, s;

  // Iterate through all the top-level elements in the toolbar
  elements = tb.children;
  for (i=0; i<elements.length; i++) {
    if (elements[i].tagName == "SCRIPT" || elements[i].tagName == "!") {
      continue;
    }
    switch (elements[i].className) {
      case "tbButton" :			
        if (elements[i].TBINITIALIZED == null) {
          if ((s = TBInitButton(elements[i], tb.TBTYPE != "nomouseover")) != TB_STS_OK) {
            alert("Problem initializing:" + elements[i].id + " Status:" + s);
            return s;
          }
        }
        elements[i].style.posLeft = tb.TBTOOLBARWIDTH;
        tb.TBTOOLBARWIDTH += elements[i].offsetWidth + 1; 
      break;
       
      case "tbMenu" :
        if (typeof(tbMenu) == "undefined") {
          alert("You need to include tbmenus.js if you want to use menus. See tutorial for details. Element: " + elements[i].id + " has class=tbMenu");
        } else {
          if (elements[i].TBINITIALIZED == null) {
            if ((s = TBInitToolbarMenu(elements[i], tb.TBTYPE != "nomouseover")) != TB_STS_OK) {
               alert("Problem initializing:" + elements[i].id + " Status:" + s);
             return s;
            }
          }
          elements[i].style.posLeft = tb.TBTOOLBARWIDTH;
          tb.TBTOOLBARWIDTH += elements[i].offsetWidth + TB_MENU_BUTTON_PADDING; 
        }
      break;
        
      case "tbGeneral" :
        elements[i].style.posLeft = tb.TBTOOLBARWIDTH;
        tb.TBTOOLBARWIDTH += elements[i].offsetWidth + 1; 
      break;
                
      case "tbSeparator" :
        elements[i].style.posLeft = tb.TBTOOLBARWIDTH + 2;
        tb.TBTOOLBARWIDTH += TB_SEPARATOR_PADDING;
      break;
      
      case "tbHandleDiv":
      break;
 
      default :
        alert("Invalid class: " + elements[i].className + " on Element: " + elements[i].id + " <" + elements[i].tagName + ">");
        return TB_E_INVALID_CLASS;
    }
  }
  return TB_STS_OK;
} // TBPopulateToolbar


// Initialize a toolbar. 
function TBInitToolbar(tb) {
  var s1, tr; 

  // Set up toolbar attributes
  if (tb.TBSTATE) {
    tb.TBSTATE = tb.TBSTATE.toLowerCase();
    if ((tb.TBSTATE != "dockedtop") && (tb.TBSTATE != "dockedbottom") && (tb.TBSTATE != "hidden")) {
      return TB_E_INVALID_STATE;    
    }
  } else {
    tb.TBSTATE = "dockedtop";
  }
  
  if (tb.TBSTATE == "hidden") {
    tb.style.visibility = "hidden";
  }
  
  if (tb.TBTYPE) {
    tb.TBTYPE = tb.TBTYPE.toLowerCase();
    if (tb.TBTYPE != "nomouseover") {
      return TB_E_INVALID_TYPE;    
    }
  }
  
  // Set initial size of toolbar to that of the handle
  tb.TBTOOLBARWIDTH = TB_HANDLE_WIDTH;
    
  // Populate the toolbar with its contents
  if ((s = TBPopulateToolbar(tb)) != TB_STS_OK) {
    return s;
  }
  
  // Set the toolbar width and put in the handle
  tb.style.posWidth = tb.TBTOOLBARWIDTH + TB_TOOLBAR_PADDING;
  tb.insertAdjacentHTML("AfterBegin", TB_HANDLE);
  
  return TB_STS_OK;
} // TBInitToolbar


// Lay out the docked toolbars
function TBLayoutToolbars() {
  var x,y,i;
  
  x = 0; y = 0;
  
  // If no toolbars we're outta here
  if (tbToolbars.length == 0) {
    return;
  }
  
  // Lay out any dockedTop toolbars
  for (i=0; i<tbToolbars.length; i++) {
    if (tbToolbars[i].TBSTATE == "dockedtop") {
      if ((x > 0) && (x + parseInt(tbToolbars[i].TBTOOLBARWIDTH) > document.body.offsetWidth)) {
        x=0; y += tbToolbars[i].offsetHeight;
      }
      tbToolbars[i].style.left = x;
      x += parseInt(tbToolbars[i].TBTOOLBARWIDTH) + TB_TOOLBAR_PADDING;
      tbToolbars[i].style.posTop = y;
    }
  } 

  // Adjust the top of the bodyElement if there were dockedTop toolbars
  if ((x != 0) || (y !=0)) {
    tbContentElementTop = y + tbToolbars[0].offsetHeight + TB_CLIENT_AREA_GAP;
  }
    
  // Lay out any dockedBottom toolbars
  x = 0; y = document.body.clientHeight - tbToolbars[0].offsetHeight;
  for (i=tbToolbars.length - 1; i>=0; i--) {
    if (tbToolbars[i].TBSTATE == "dockedbottom") {
      if ((x > 0) && (x + parseInt(tbToolbars[i].TBTOOLBARWIDTH) > document.body.offsetWidth)) {
        x=0; y -= tbToolbars[i].offsetHeight;
      }
      tbToolbars[i].style.left = x;
      x += parseInt(tbToolbars[i].TBTOOLBARWIDTH) + TB_TOOLBAR_PADDING;
      tbToolbars[i].style.posTop = y;
    }
  }
  
  // Adjust the bottom of the bodyElement if there were dockedBottom toolbars
  if ((x != 0) || (y != (document.body.offsetHeight - tbToolbars[0].offsetHeight))) {
    tbContentElementBottom = document.body.offsetHeight - y + TB_CLIENT_AREA_GAP;
  }
  
  tbLastHeight = 0;
  tbLastWidth = 0;
  
} // TBLayoutToolbars


// Adjust the position and size of the body element and the bottom and right docked toolbars.
function TBLayoutBodyElement() {
  
  tbContentElementObject.style.posTop = tbContentElementTop;
  tbContentElementObject.style.left = 0; 
  tbContentElementObject.style.posHeight = document.body.offsetHeight - tbContentElementBottom - tbContentElementTop;
  tbContentElementObject.style.width = document.body.offsetWidth;
  
  // Update y position of any dockedBottom toolbars
  if (tbLastHeight != 0) {
    for (i=tbToolbars.length - 1; i>=0; i--) {
      if (tbToolbars[i].TBSTATE == "dockedbottom" && tbToolbars[i].style.visibility != "hidden") {
        tbToolbars[i].style.posTop += document.body.offsetHeight - tbLastHeight;
      }
    }
  }
  
  tbLastHeight = document.body.offsetHeight;
  tbLastWidth = document.body.offsetWidth;
  
} // TBLayoutBodyElement


// Initialize everything when the document is ready
function document.onreadystatechange() {
  var i, s;
  
  if (TBInitialized) {
    return;
  }
  
  TBInitialized = true;
  
  document.body.scroll = "no";
  
  // Add a <span> that we will use this to measure the contents of menus
  if (typeof(tbMenu) != "undefined") {
    document.body.insertAdjacentHTML("BeforeEnd", "<span ID=TBMenuMeasureSpan></span>");
  }
  
  // Find all the toolbars and initialize them. 
  for (i=0; i<document.body.all.length; i++) {
    if (document.body.all[i].className == "tbToolbar") {
      if ((s = TBInitToolbar(document.body.all[i])) != TB_STS_OK) {
        alert("Toolbar: " + document.body.all[i].id + " failed to initialize. Status: " + s);
      }
      tbToolbars[tbToolbars.length] = document.body.all[i];
    }
  }
  
  // Get rid of the menu measuring span
  if (typeof(tbMenu) != "undefined") {
    document.all["TBMenuMeasureSpan"].outerHTML = "";
  }
  
  // Lay out the page
  TBLayoutToolbars();
  TBLayoutBodyElement();
  
  // Handle all resize events
  window.onresize = TBLayoutBodyElement;
    
  // Grab global mouse events.
  document.onmousedown = TBGlobalMouseDown;
  document.onmousemove = TBGlobalMouseMove;
  document.onmouseup = TBGlobalMouseUp;
  document.ondragstart = TBGlobalStartEvents;
  document.onselectstart = TBGlobalStartEvents;
}


//
// Immediately executed code
//
{
  tbContentElementObject = document.body.all["tbContentElement"];
   
  if (typeof(tbContentElementObject) == "undefined") {
    alert("Error: There must be one element on the page with an ID of tbContentElement");
  }

  if (tbContentElementObject.className != "tbContentElement") {
    alert('Error: tbContentElement must have its class set to "tbContentElement"');
  }
  
  // Add an onmouseover handler to the tbContentElement. We need this for when the DHTML Edting
  // control is the content element. IE doesn't give the toolbars onmouseout events in that case. 
  document.write('<SCRIPT LANGUAGE="JavaScript" FOR="tbContentElement" EVENT="onmouseover"> TBContentElementMouseOver(); </scrip' +'t>');  
  
  DECMD_VISIBLEBORDERS_onclick();

}

// Rebuild toolbar; call after inserting or deleting items on toolbar.
function TBRebuildToolbar(toolbar, rebuildMenus)
{
  var toolbarFound = false;

  // Add a <span> that we will use this to measure the contents of menus
  if (typeof(tbMenu) != "undefined") {
    document.body.insertAdjacentHTML("BeforeEnd", "<span ID=TBMenuMeasureSpan></span>");
  }

  // Look through existing toolbars and see if we get a match
  for (i=0; i<tbToolbars.length; i++) {
    if (tbToolbars[i].id == toolbar.id) {
      toolbarFound = true;
      break;
    }
  }

  // is this is a new toolbar?
  if (false == toolbarFound) { 	
      // new toolbar, initialize it and add it to toolbar array
    if ((s = TBInitToolbar(toolbar)) != TB_STS_OK) {
      alert("Toolbar: " + toolbar.id + " failed to initialize. Status: " + s);
    }

    // add the new toolbar to the internal toolbar array
    tbToolbars[tbToolbars.length] = toolbar;

  }
  else {

    // Set initial size of toolbar to that of the handle
    toolbar.TBTOOLBARWIDTH = TB_HANDLE_WIDTH;

    for (i=0; i<document.body.all.length; i++) {
      if (document.body.all[i].className == "tbMenu") {
        TBRebuildMenu(document.body.all[i], rebuildMenus);
      }
    }

    // Populate the toolbar with its contents
    if ((s = TBPopulateToolbar(toolbar)) != TB_STS_OK) {
      alert("Toolbar: " + document.body.all[i].id + " failed to populate. Status: " + s);
    }

    // Set the toolbar width and put in the handle
    toolbar.style.posWidth = toolbar.TBTOOLBARWIDTH + TB_TOOLBAR_PADDING;

    if (false == toolbarFound) // new toolbar, add handle
      tb.insertAdjacentHTML("AfterBegin", TB_HANDLE);
  }
 
  // Get rid of the menu measuring span
  if (typeof(tbMenu) != "undefined") {
    document.all["TBMenuMeasureSpan"].outerHTML = "";
  }
   
  // Lay out the page
  TBLayoutToolbars();
  TBLayoutBodyElement();
}
//-->
</script>

</body>
</html>
