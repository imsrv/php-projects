<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminReserved.php - HTML templates for outputs of 
//                  reserved login name screens in admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format form for editing or creating new record
//  Parameters: Title(string), ActionButtons(string)
//  Return: HTML
function getReservedFormHTML($title,$actionType){
	global $Language,$AdminLanguage, $Document,$VARS,$GlobalSettings;
	extract($VARS,EXTR_OVERWRITE);
	$submitButton =commonGetSubmitButton(false,$Language[$actionType],"");
	$contents = "<BR />";
	$contents .= commonTableFormatHTML("header","$Document[contentWidth]","CENTER");
	$contents .= <<<EOF
<TR>
	<TD CLASS="TitleTR" ALIGN="CENTER">$title</TD>
</TR>
<TR>
	<TD CLASS="TDStyle">
		
	<FORM ACTION="$Document[mainScript]" METHOD="POST" ENCTYPE="multipart/form-data">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">	
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="reserved">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="$actionType">
	<INPUT TYPE="HIDDEN" NAME="reservedId" VALUE="$reservedId">
	<TABLE ALIGN="CENTER" CELLPADDING="5" CELLSPACING="0" WIDTH="100%">
	<TR>
		<TD CLASS="TDStyle" COLSPAN="2" ALIGN="CENTER">
			<SPAN CLASS="Error">$Document[msg]</SPAN> &nbsp;
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$AdminLanguage[Username]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="TEXT" NAME="username" SIZE="25" VALUE="$username" MAXLENGTH="100">	
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle" VALIGN="TOP">
			$AdminLanguage[Notes]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT SIZE="50" NAME="notes" VALUE="$notes" TYPE="text">
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">			
		</TD>
		<TD CLASS="TDStyle">
			$submitButton
		</TD>		
	</TR>	
	</TABLE>
	</FORM>
	</TD>
</TR>	
EOF;
	$contents .= commonTableFormatHTML("footer","","");

	return $contents;
}//getReservedFormHTML

//  Format each row on listing
//  Parameter: ReservedDetails(Array)
//  Return: HTML
function getReservedRowHTML($reserved){
	global $Language,$AdminLanguage,$Document,$GlobalSettings;
	$confirm=commonDeleteConfirmation("$Language[Delete] $AdminLanguage[ReservedLoginNames]?");
	$deleteButton=commonGetIconButton("delete",$Language['Delete'],"?mode=admin&case=reserved&action=delete&reservedId=$reserved[reservedId]",$confirm);
	$editButton=commonGetIconButton("edit",$Language['Edit'],"?mode=admin&case=reserved&action=edit&reservedId=$reserved[reservedId]","");
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle">$reserved[username]</TD>
		<TD CLASS="TDStyle">$reserved[notes]</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$deleteButton
		</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$editButton
		</TD>
	</TR>	
EOF;
	return $contents;
}//getReservedRowHTML

//  Column labels on listings
//  Return: HTML
function getColumnLabelsHTML(){
	global $Language,$AdminLanguage;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">$AdminLanguage[Username]</TD>
		<TD CLASS="TitleTR">$AdminLanguage[Notes]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Delete]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Edit]</TD>
	</TR>	
EOF;
	return $contents;
}//getColumnLabelsHTML

//  Top Create link/quick search box
//  Return: HTML
function getNewLinkHTML(){
	GLOBAL $AdminLanguage,$Language,$Document,$VARS;
	$contents= <<<EOF
	<BR />
	<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0" BORDER="0">
	<FORM ACTION="$Document[mainScript]">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="reserved">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="list">		
	<TR>
		<TD CLASS="TDStyle" VALIGN="BOTTOM">
			<SPAN CLASS="GreyText">&laquo;</SPAN><A HREF="$Document[mainScript]?mode=admin&case=reserved&action=new">$AdminLanguage[CreateNewEntry]</A><SPAN CLASS="GreyText">&raquo;</SPAN>
		</TD>
		<TD CLASS="TDStyle" ALIGN="RIGHT">
			$Language[Keywords]:<INPUT TYPE="TEXT" SIZE="10" NAME="searchText" VALUE="$VARS[searchText]"><INPUT TYPE="SUBMIT" VALUE="$Language[Search]" CLASS="GoButton">
		</TD>
	</TR>	
	</FORM>
	</TABLE>
EOF;
	return $contents;
}//getNewLinkHTML

?>