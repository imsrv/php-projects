<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminBoards.php - HTML templates for outputs of 
//                  board screens in admin.
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
function getBoardFormHTML($title,$actionType){
	global $Language, $Document,$VARS,$AdminLanguage;
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
		<FORM NAME="board" ACTION="$Document[mainScript]" METHOD="POST">
		<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">	
		<INPUT TYPE="HIDDEN" NAME="case" VALUE="boards">
		<INPUT TYPE="HIDDEN" NAME="action" VALUE="$actionType">
		<INPUT TYPE="HIDDEN" NAME="boardId" VALUE="$boardId">

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
			<TD CLASS="TDStyle" VALIGN="TOP">
				$AdminLanguage[Groups]:<BR />
				<SPAN CLASS="TinyText"><STRONG>$AdminLanguage[Multipleselect]</STRONG></SPAN>
			</TD>
			<TD CLASS="TDStyle" >
				<SELECT MULTIPLE SIZE="4" NAME="groupsSelected[]">
					$Document[groupsSelected]
				</SELECT> 					
			</TD>		
		</TR>	
		<TR>
			<TD CLASS="TDStyle">			
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="RESET" VALUE="$AdminLanguage[Reset]" CLASS="SubmitButtons"> $submitButton
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
}//getBoardFormHTML

//  Format each row on listing
//  Parameter: BoardDetails(Array)
//  Return: HTML
function getBoardRowHTML($board){
	global $Language,$AdminLanguage,$Document;
	$confirm=commonDeleteConfirmation($AdminLanguage[DeleteConfirmBoard]);
	$board[displayOrder]=$board[displayOrder]<1?1:$board[displayOrder];
	$accessButton=$board['status']==1?commonGetIconButton("adminhide","$AdminLanguage[Closethisboard]","?mode=admin&case=boards&action=access&boardId=$board[boardId]&status=0",""):commonGetIconButton("adminopen","$AdminLanguage[Openthisboard]","?mode=admin&case=boards&action=access&boardId=$board[boardId]&status=1","");
	$moveUpButton=commonGetIconButton("uparrow","$AdminLanguage[Moveup]","?mode=admin&case=boards&action=moveup&boardId=$board[boardId]&displayOrder=$board[displayOrder]","");
	$moveDownButton=commonGetIconButton("downarrow","$AdminLanguage[Movedown]","?mode=admin&case=boards&action=movedown&boardId=$board[boardId]&displayOrder=$board[displayOrder]","");

	$deleteButton=commonGetIconButton("delete",$Language[Delete],"?mode=admin&case=boards&action=delete&boardId=$board[boardId]&displayOrder=$board[displayOrder]",$confirm);
	$editButton=commonGetIconButton("edit",$Language[Edit],"?mode=admin&case=boards&action=edit&boardId=$board[boardId]","");
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle">$board[name]</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$accessButton</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$moveUpButton &nbsp; $moveDownButton</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$deleteButton</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$editButton </TD>
	</TR>	
EOF;
	return $contents;
}//getBoardRowHTML

//  Column labels on listings
//  Return: HTML
function getColumnLabelsHTML(){
	global $Language,$AdminLanguage;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">$Language[Board] $Language[Name]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Access]</TD>		
		<TD CLASS="TitleTR" ALIGN="CENTER">$AdminLanguage[Order]</TD>		
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Delete]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Edit]</TD>
	</TR>	
EOF;
	return $contents;
}//getColumnLabelsHTML

//  Top Create link/reset board button
//  Return: HTML
function getNewLinkHTML(){
	GLOBAL $Language,$Document,$AdminLanguage;
	$resetButton=commonGetIconButton("adminresetorder",$AdminLanguage[Resetdisplayorder],"?mode=admin&case=boards&action=resetOrder","");

	$contents= <<<EOF
	<BR />
	<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER">
	<TR>
		<TD CLASS="TDPlain" VALIGN="BOTTOM">
			<SPAN CLASS="GreyText">&laquo;</SPAN><A HREF="$Document[mainScript]?mode=admin&case=boards&action=new">$AdminLanguage[CreateNewBoard]</A><SPAN CLASS="GreyText">&raquo;</SPAN>
		</TD>
		<TD CLASS="TDPlain" ALIGN="RIGHT">
			$resetButton
		</TD>		
	</TR>	
	</TABLE>
EOF;
	return $contents;
}//getNewLinkHTML

?>