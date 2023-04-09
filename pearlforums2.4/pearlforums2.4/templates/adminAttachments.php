<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminAttachments.php - HTML templates for outputs of 
//                  attachment screens in admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Output format for each row
//  Parameter: AttachmentDetails(Array)
//  Return: HTML
function getAttachmentRowHTML($attachment){
	global $AdminLanguage,$Language,$Document;
	
	$deleteLink=$attachment[removedBy]?"<IMG SRC=\"images/trashed.gif\" TITLE=\"$AdminLanguage[Attachmentdeletedby] $attachment[adminName]\">":commonGetIconButton("delete",$Language[Delete],"?mode=admin&case=attachments&action=delete&postId=$attachment[postId]",commonDeleteConfirmation("$Language[Delete] $Language[Attachment]?"));
	$attachment[fileType]=strtoupper($attachment[fileType]);
	$attachment[postDate]=commonTimeFormat(false,$attachment[postDate]);
	
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=topics&topicId=$attachment[topicId]">$attachment[subject]</A></TD>
		<TD CLASS="TDStyle">$attachment[postDate]</TD>
		<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=profile&loginName=$attachment[loginName]">$attachment[name]</A></TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$attachment[fileType]</TD>				
		<TD CLASS="TDStyle" ALIGN="RIGHT">$attachment[fileSize] KB</TD>		
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$deleteLink
		</TD>
	</TR>
EOF;
	return $contents;
}//getAttachmentRowHTML

//  Column labels
//  Return: HTML
function getColumnLabelsHTML(){
	global $Language,$AdminLanguage;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">$Language[Subject]</TD>
		<TD CLASS="TitleTR">$Language[Date]</TD>
		<TD CLASS="TitleTR">$AdminLanguage[Member]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$AdminLanguage[FileType]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$AdminLanguage[FileSize]</TD>						
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Delete]</TD>
	</TR>	
EOF;
	return $contents;
}//getColumnLabelsHTML

//  Quick search box
//  Return: HTML
function getSearchBoxHTML(){
	GLOBAL $Language,$Document,$VARS,$AdminLanguage;
	
	$contents= <<<EOF
	<BR />
	<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0" BORDER="0">
	<FORM ACTION="$Document[mainScript]">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="attachments">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="list">	
	<TR>
		<TD CLASS="TDStyle" VALIGN="BOTTOM">
			$Document[msg]
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

//  Advanced options such as mass delete and purging
//  Return: HTML
function getAttachmentOptions(){
	global $Document,$AdminLanguage,$Language,$VARS;
	extract($VARS,EXTR_OVERWRITE);
	$deleteButton=commonGetSubmitButton(false,"Delete","");
	$contents=<<<EOF
	<BR /><BR />
	<TABLE CELLPADDING="5" ALIGN="CENTER">
	<FORM ACTION="$Document[mainScript]">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="attachments">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="massDelete">
	<INPUT TYPE="HIDDEN" NAME="type" VALUE="size">
	<TR>
		<TD CLASS="TDPlain">
		$deleteButton $AdminLanguage[LargeAttachmentSize]: <INPUT TYPE="TEXT" SIZE="15" NAME="fileSize" VALUE="$fileSize"> KBytes 
		</TD>
	</TR></FORM>
	<FORM ACTION="$Document[mainScript]">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="attachments">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="massDelete">
	<INPUT TYPE="HIDDEN" NAME="type" VALUE="date">
	<TR>
		<TD CLASS="TDPlain">
		$deleteButton $AdminLanguage[LargeAttachmentDate]:&nbsp; <INPUT TYPE="TEXT" SIZE="15" NAME="months" VALUE="$months"> $AdminLanguage[Months]
		</TD>
	</TR></FORM>
	<TR>
		<TD CLASS="TDPlain">
			<A HREF="$Document[mainScript]?mode=admin&case=attachments&action=purge">$AdminLanguage[Purgedeleted]</A>
		</TD>
	</TR>
	</TABLE>
EOF;
	return $contents;
}//getAttachmentOptions
?>