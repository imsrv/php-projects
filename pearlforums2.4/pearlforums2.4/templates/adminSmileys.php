<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminSmileys.php - HTML templates for outputs of 
//                  smiley screens in admin.
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
function getSmileyFormHTML($title,$actionType){
	global $Language,$AdminLanguage, $Document,$HTTP_POST_VARS,$GlobalSettings;
	extract($HTTP_POST_VARS,EXTR_OVERWRITE);
	$submitButton =commonGetSubmitButton(false,$Language[$actionType],"");
	if($fileName){
		$image="<IMG SRC=$GlobalSettings[smileysPath]/$fileName>";
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
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="smileys">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="$actionType">
	<INPUT TYPE="HIDDEN" NAME="smileyId" VALUE="$smileyId">
	<INPUT TYPE="HIDDEN" NAME="fileName" VALUE="$fileName">	
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
			<INPUT TYPE="TEXT" NAME="name" SIZE="25" VALUE="$name" MAXLENGTH="100">	
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle" VALIGN="TOP">
			$AdminLanguage[Image]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT SIZE="25" NAME="userfile" TYPE="file">
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDStyle">	
			$image		
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
}//getSmileyFormHTML

//  Format each row on listing
//  Parameter: SmileyDetails(Array)
//  Return: HTML
function getSmileyRowHTML($smiley){
	global $Language,$Document,$GlobalSettings,$AdminLanguage;
	$confirm=commonDeleteConfirmation("$Language[Delete] $AdminLanguage[Smiley]?");
	$deleteButton=commonGetIconButton("delete",$Language['Delete'],"?mode=admin&case=smileys&action=delete&smileyId=$smiley[smileyId]&fileName=$smiley[fileName]",$confirm);
	$editButton=commonGetIconButton("edit",$Language['Edit'],"?mode=admin&case=smileys&action=edit&smileyId=$smiley[smileyId]","");
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle"><IMG SRC="$GlobalSettings[smileysPath]/$smiley[fileName]"></TD>
		<TD CLASS="TDStyle">$smiley[name]</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$deleteButton
		</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$editButton
		</TD>
	</TR>	
EOF;
	return $contents;
}//getSmileyRowHTML

//  Column labels on listings
//  Return: HTML
function getColumnLabelsHTML(){
	global $Language,$AdminLanguage;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">$AdminLanguage[Image]</TD>
		<TD CLASS="TitleTR">$Language[Name]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Delete]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Edit]</TD>
	</TR>	
EOF;
	return $contents;
}//getColumnLabelsHTML

//  Top Create link/quick search box
//  Return: HTML
function getNewLinkHTML(){
	GLOBAL $Language,$Document,$HTTP_GET_VARS,$AdminLanguage;
	$contents= <<<EOF
	<BR />
	<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER">
	<FORM ACTION="$Document[mainScript]">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="smileys">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="list">			
	<TR>
		<TD CLASS="TDStyle">
			<SPAN CLASS="GreyText">&laquo;</SPAN><A HREF="$Document[mainScript]?mode=admin&case=smileys&action=new">$AdminLanguage[CreateNewEntry]</A><SPAN CLASS="GreyText">&raquo;</SPAN>
		</TD>
		<TD CLASS="TDStyle" ALIGN="RIGHT">
			$Language[Keywords]:<INPUT TYPE="TEXT" SIZE="10" NAME="searchText" VALUE="$HTTP_GET_VARS[searchText]"><INPUT TYPE="SUBMIT" VALUE="$Language[Search]" CLASS="GoButton">
		</TD>		
	</TR>	
	</TABLE>
EOF;
	return $contents;
}//getNewLinkHTML

?>