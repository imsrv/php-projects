<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminGroups.php - HTML templates for outputs of 
//                  group screens in admin.
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
function getGroupFormHTML($title,$actionType){
	global $Language, $Document,$VARS,$AdminLanguage;
	extract($VARS,EXTR_OVERWRITE);
	$submitButton =commonGetSubmitButton(false,$Language[$actionType],"");
	$contents = "<BR />";
	$contents .= commonTableFormatHTML("header","400","CENTER");
	$contents .= <<<EOF
<TR>
	<TD CLASS="TitleTR" ALIGN="CENTER">$title</TD>
</TR>
<TR>
	<TD CLASS="TDStyle">
		
	<FORM ACTION="$Document[mainScript]" METHOD="POST">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">	
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="groups">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="$actionType">
	<INPUT TYPE="HIDDEN" NAME="groupId" VALUE="$groupId">
	<TABLE ALIGN="CENTER" CELLPADDING="5" CELLSPACING="0" WIDTH="100%">
	<TR>
		<TD CLASS="TDStyle" COLSPAN="2" ALIGN="CENTER">
			<SPAN CLASS="Error">$Document[msg]</SPAN> &nbsp;
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[Name]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="TEXT" NAME="name" SIZE="40" VALUE="$name" MAXLENGTH="100">	
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle" VALIGN="TOP">
			$AdminLanguage[Description]:
		</TD>
		<TD CLASS="TDStyle">
			<TEXTAREA NAME="description" COLS="40" ROWS="4">$description</TEXTAREA>	
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
	$contents .= "<BR />";

	return $contents;
}//getGroupFormHTML

//  Format each row on listing
//  Parameter: GroupDetails(Array)
//  Return: HTML
function getGroupRowHTML($group){
	global $Language,$Document;
	$confirm=commonDeleteConfirmation("$Language[Delete] $Language[Group]?");
	$deleteButton=commonGetIconButton("delete",$Language['Delete'],"?mode=admin&case=groups&action=delete&groupId=$group[groupId]",$confirm);
	$editButton=commonGetIconButton("edit",$Language['Edit'],"?mode=admin&case=groups&action=edit&groupId=$group[groupId]","");
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle">$group[name]</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$deleteButton
		</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$editButton
		</TD>
	</TR>	
EOF;
	return $contents;
}//getGroupRowHTML

//  Column labels on listings
//  Return: HTML
function getColumnLabelsHTML(){
	global $Language,$AdminLanguage;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">$AdminLanguage[Groups]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Delete]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Edit]</TD>
	</TR>	
EOF;
	return $contents;
}//getColumnLabelsHTML

//  Top Create link
//  Return: HTML
function getNewLinkHTML(){
	GLOBAL $AdminLanguage,$Document;
	$contents= <<<EOF
	<BR />
	<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER">
	<TR>
		<TD CLASS="TDStyle">
			<SPAN CLASS="GreyText">&laquo;</SPAN><A HREF="$Document[mainScript]?mode=admin&case=groups&action=new">$AdminLanguage[CreateNewGroup]</A><SPAN CLASS="GreyText">&raquo;</SPAN>
		</TD>
	</TR>	
	</TABLE>
EOF;
	return $contents;
}//getNewLinkHTML

?>