<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminAvatars.php - HTML templates for outputs of 
//                  avatar screens in admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format form for editing or new record
//  Parameter: Title(string), ActionButtons(string)
//  Return: HTML
function getAvatarFormHTML($title,$actionType){
	global $Language, $Document,$VARS,$GlobalSettings;
	extract($VARS,EXTR_OVERWRITE);
	$submitButton =commonGetSubmitButton(false,$Language[$actionType],"");
	if($Document[msg])$errorMsg .= $Document[msg];
	if($fileName){
		$photo="<IMG SRC=$GlobalSettings[avatarsPath]/$fileName>";
	}
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
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="avatars">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="$actionType">
	<INPUT TYPE="HIDDEN" NAME="avatarId" VALUE="$avatarId">
	<INPUT TYPE="HIDDEN" NAME="fileName" VALUE="$fileName">	
	<TABLE ALIGN="CENTER" CELLPADDING="5" CELLSPACING="0" WIDTH="100%">
	<TR>
		<TD CLASS="TDStyle" COLSPAN="2" ALIGN="CENTER">
			<SPAN CLASS="Error">$errorMsg</SPAN> &nbsp;
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">
			$Language[Avatar] $Language[Name]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="TEXT" NAME="name" SIZE="25" VALUE="$name" MAXLENGTH="100">	
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle" VALIGN="TOP">
			$Language[Photo]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT SIZE="25" NAME="userfile" TYPE="file">
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
	$contents .= "<P ALIGN=CENTER>	$photo </P>";

	return $contents;
}//getAvatarFormHTML

//  Format each row on listing
//  Parameter: AvatarDetails(Array)
//  Return: HTML
function getAvatarRowHTML($avatar){
	global $Language,$Document,$GlobalSettings;
	$confirm=commonDeleteConfirmation("$Language[Delete] $Language[Avatar]?");
	$deleteButton=commonGetIconButton("delete",$Language['Delete'],"?mode=admin&case=avatars&action=delete&avatarId=$avatar[avatarId]&fileName=$avatar[fileName]",$confirm);
	$editButton=commonGetIconButton("edit",$Language['Edit'],"?mode=admin&case=avatars&action=edit&avatarId=$avatar[avatarId]","");
	if(isset($avatar[loginName])){
		$avatar[name]="<A HREF=\"$Document[mainScript]?mode=profile&loginName=$avatar[loginName]\">$avatar[name]</A>";
	}
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle"><IMG SRC="$GlobalSettings[avatarsPath]/$avatar[fileName]" HEIGHT="50"></TD>
		<TD CLASS="TDStyle">$avatar[name]</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$deleteButton
		</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$editButton
		</TD>
	</TR>	
EOF;
	return $contents;
}//getAvatarRowHTML

//  Format column labels on listings
//  Return: HTML
function getColumnLabelsHTML(){
	global $Language;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">$Language[Photo]</TD>
		<TD CLASS="TitleTR">$Language[Name]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Delete]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Edit]</TD>
	</TR>	
EOF;
	return $contents;
}//getColumnLabelsHTML

//  Get top create link and quick search box
//  Return: HTML
function getNewLinkHTML(){
	GLOBAL $Language,$Document,$VARS,$AdminLanguage;
	$contents= <<<EOF
	<BR />
	<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0" BORDER="0">
	<FORM ACTION="$Document[mainScript]">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="avatars">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="list">		
	<TR>
		<TD CLASS="TDStyle" VALIGN="BOTTOM">
			<SPAN CLASS="GreyText">&laquo;</SPAN><A HREF="$Document[mainScript]?mode=admin&case=avatars&action=new">$AdminLanguage[CreateNewEntry]</A><SPAN CLASS="GreyText">&raquo;</SPAN>
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