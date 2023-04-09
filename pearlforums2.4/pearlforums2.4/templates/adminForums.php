<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminForums.php - HTML templates for outputs of 
//                  forum screens in admin.
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
function getForumFormHTML($title,$actionType){
	global $AdminLanguage,$Language, $Document,$VARS,$AdminLanguage;
	extract($VARS,EXTR_OVERWRITE);
	$submitButton =commonGetSubmitButton(false,$Language[$actionType],"");
	$announcementChecked=$announcement?" checked":"";
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
		<INPUT TYPE="HIDDEN" NAME="case" VALUE="forums">
		<INPUT TYPE="HIDDEN" NAME="action" VALUE="$actionType">
		<INPUT TYPE="HIDDEN" NAME="forumId" VALUE="$forumId">

		<TABLE ALIGN="CENTER" CELLPADDING="5" CELLSPACING="0" WIDTH="100%">
		<TR>
			<TD CLASS="TDStyle" COLSPAN="2" ALIGN="CENTER">
				<SPAN CLASS="Error">$Document[msg]</SPAN> &nbsp;
			</TD>		
		</TR>	
		<TR>
			<TD CLASS="TDStyle" VALIGN="TOP">
				$Language[Board]:<BR />
			</TD>
			<TD CLASS="TDStyle" >
				<SELECT NAME="boardId">
					$Document[boardsListing]
				</SELECT> 					
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
				$AdminLanguage[Moderators]:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="TEXT" NAME="moderators" SIZE="40" VALUE="$moderators" MAXLENGTH="100">	<BR>
				<SPAN CLASS="SmallText">$AdminLanguage[Leaveblankor]</SPAN>
			</TD>		
		</TR>	
		<TR>
			<TD CLASS="TDStyle" VALIGN="TOP">
				$AdminLanguage[AnnouncementsOnly]?
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="checkbox" NAME="announcement" VALUE="1" $announcementChecked>$Language[Yes]
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
}//getForumFormHTML

//  Top Create link
//  Return: HTML
function getNewLinksHTML(){
	global $Language, $Document,$AdminLanguage;
	$contents= <<<EOF
	<BR />
	<TABLE ALIGN="CENTER" WIDTH="$Document[contentWidth]" CELLPADDING="0" CELLSPACING="0">
	<TR>
		<TD CLASS="TDStyle" WIDTH="50%">
			<SPAN CLASS="GreyText">&laquo;</SPAN><A HREF="$Document[mainScript]?mode=admin&case=forums&action=new">$AdminLanguage[CreateNewForum]</A><SPAN CLASS="GreyText">&raquo;</SPAN>
		</TD>
		<TD CLASS="TDStyle" WIDTH="50%" ALIGN="RIGHT">
		</TD>
	</TR>	
	</TABLE>	
EOF;
	return $contents;
}//getNewLinksHTML

//  Column labels on listings
//  Return: HTML
function getColumnLabelsHTML(){
	global $Language,$AdminLanguage;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">$Language[Forum]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Topics]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Posts]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Access]</TD>		
		<TD CLASS="TitleTR" ALIGN="CENTER">$AdminLanguage[Order]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Delete]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Edit]</TD>
	</TR>	
EOF;
	return $contents;
}//getForumLabelsHTML

//  Format each board row on listing
//  Parameter: BoardDetails(Array)
//  Return: HTML
function getBoardRowHTML($board){
	global $Document,$AdminLanguage;
	$reorderButton= commonGetIconButton("adminresetorder",$AdminLanguage[Resetdisplayorder],"?mode=admin&case=forums&action=resetOrder&boardId=$board[boardId]","");
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDAltStyle" COLSPAN="7">
			<SPAN CLASS="GreyText">$board[boardName]</SPAN> $reorderButton
		</TD>
	</TR>	
EOF;
	return $contents;		
}//getBoardRowHTML

//  Format each forum row on listing
//  Parameter: ForumDetails(Array)
//  Return: HTML
function getForumRowHTML($forum){
	global $Document,$Language,$AdminLanguage;
	$confirm=commonDeleteConfirmation($AdminLanguage[DeleteConfirmForum]);
	$forum[displayOrder]=$forum[displayOrder]<1?1:$forum[displayOrder];
	$accessButton=$forum['status']==1?commonGetIconButton("adminhide","$AdminLanguage[Closethisforum]","?mode=admin&case=forums&action=access&forumId=$forum[forumId]&status=0",""):commonGetIconButton("adminopen","$AdminLanguage[Openthisforum]","?mode=admin&case=forums&action=access&forumId=$forum[forumId]&status=1","");
	$moveUpButton=commonGetIconButton("uparrow","$AdminLanguage[Moveup]","?mode=admin&case=forums&action=moveup&forumId=$forum[forumId]&boardId=$forum[boardId]&displayOrder=$forum[displayOrder]","");
	$moveDownButton=commonGetIconButton("downarrow","$AdminLanguage[Movedown]","?mode=admin&case=forums&action=movedown&forumId=$forum[forumId]&boardId=$forum[boardId]&displayOrder=$forum[displayOrder]","");

	$deleteButton=commonGetIconButton("delete",$Language[Delete],"?mode=admin&case=forums&action=delete&forumId=$forum[forumId]&boardId=$forum[boardId]&displayOrder=$forum[displayOrder]",$confirm);
	$editButton=commonGetIconButton("edit",$Language[Edit],"?mode=admin&case=forums&action=edit&forumId=$forum[forumId]","");
	
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle">$forum[name]</A></TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$forum[topics]</A></TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$forum[posts]</A></TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$accessButton</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$moveUpButton &nbsp; $moveDownButton	</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$deleteButton</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$editButton</TD>
	</TR>	
EOF;
	return $contents;		
}//getForumRowHTML

//  Format footer legends
//  Return: HTML
function getLegendHTML(){
	global $Document,$Language;
	$boardType =commonTableFormatHTML("header","10","");	
	$boardType .= "<TR><TD CLASS=TDAltStyle>&nbsp;</TD></TR>";	
	$boardType .=commonTableFormatHTML("footer","","");
	$forumType =commonTableFormatHTML("header","10","");	
	$forumType .= "<TR><TD CLASS=TDStyle>&nbsp;</TD></TR>";	
	$forumType .=commonTableFormatHTML("footer","","");

	$contents= <<<EOF
	<BR />
	<TABLE ALIGN="CENTER">
	<TR>
		<TD CLASS="TDStyle">
			$boardType
		</TD>
		<TD CLASS="TDStyle">
		 	$Language[Boards]
		 </TD>
		 <TD WIDTH="20">&nbsp;</TD>
		 <TD CLASS="TDStyle">
			$forumType 
		</TD>
		 <TD CLASS="TDStyle">	
			$Language[Forums]
		</TD>
	</TR>	
	</TABLE>
EOF;
	return $contents;		
}//getLegendHTML
	

?>