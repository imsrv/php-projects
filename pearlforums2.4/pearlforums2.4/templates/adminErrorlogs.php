<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminErrologs.php - HTML templates for outputs of 
//                  error log screens in admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format each row on listing
//  Parameter: LogDetails(Array)
//  Return: HTML
function getErrorlogRowHTML($errorlog){
	global $AdminLanguage,$Language,$Document;
	
	$deleteLink=commonGetIconButton("delete",$Language['Delete'],"?mode=admin&case=errorlogs&action=delete&logId=$errorlog[logId]","");
	$logTime=$errorlog['status']?commonGetIconButton("closeerrorlog","$Language[Close] $Language[Errorlog]","?mode=errorlog&action=close&topicId=$errorlog[topicId]",""):commonGetIconButton("openerrorlog","$Language[Open] $Language[Errorlog]","?mode=errorlog&action=open&topicId=$errorlog[topicId]","");
	$errorlog['logTime']=commonTimeFormat(false,$errorlog['logTime']);
	
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">
			<A HREF="$Document[mainScript]?mode=profile&loginName=$errorlog[loginName]">$errorlog[name]</A> - $errorlog[logTime] $deleteLink
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">
			<STRONG>URL</STRONG>: $errorlog[scriptName]<BR />
			<STRONG>SQL</STRONG>: $errorlog[sql]<BR />
			<STRONG>ERROR</STRONG>: $errorlog[errorMessage]<BR />
		</TD>
	</TR>
EOF;
	return $contents;
}//getErrorlogRowHTML

//  Format search box and messages
//  Return: HTML
function getSearchBoxHTML(){
	GLOBAL $Language,$Document,$VARS,$AdminLanguage;
	
	$contents= <<<EOF
	<BR />
	<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0" BORDER="0">
	<FORM ACTION="$Document[mainScript]">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="errorlogs">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="list">	
	<TR>
		<TD CLASS="TDStyle" COLSPAN="2" ALIGN="CENTER">
			$Document[msg]
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle" VALIGN="BOTTOM">
			<A HREF="$Document[mainScript]?mode=admin&case=errorlogs&action=delete">$AdminLanguage[DeleteAll]</A>
		</TD>
		<TD CLASS="TDStyle" ALIGN="RIGHT">
			$Language[Keywords]: <INPUT TYPE="TEXT" SIZE="10" NAME="searchText" VALUE="$VARS[searchText]" TITLE="$Language[Subject]/$AdminLanguage[Member] $Language[Name]"><INPUT TYPE="SUBMIT" VALUE="$Language[Search]" CLASS="GoButton">
		</TD>
	</TR>	
	</FORM>
	</TABLE>
EOF;
	return $contents;
}//getSearchBoxHTML


?>