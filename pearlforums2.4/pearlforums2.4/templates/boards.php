<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    boards.php - HTML templates for outputs of board screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format top board with title & quick login box
//  Return: HTML
function getTopBoardHTML(){
	global $Member,$Language,$Document;
	$contents= <<<EOF
		<TABLE WIDTH="100%">
		<TR>
			<TD WIDTH="50%">
				$Document[title]						
			</TD>
			<TD WIDTH="50%" ALIGN="RIGHT">
				$Document[quickLogin]		
			</TD>						
		</TR>
		</TABLE>
EOF;
	return $contents;		
}//getTopBoardHTML

//  Format each board row on listing
//  Parameter: BoardDetails(Array)
//  Return: HTML	
function getBoardRowHTML($board){
	Global $Document,$Language;
	$closed=$board[boardStatus]?"":commonGetIconImage("closed",$Language['Boardclosed']);
	if($Document[showBoardDescription])
		$description=trim($board[description])?"[$board[description]]":"";
	if($board[groupNames])
		$board[groupNames]="[$Language[Reservedfor] $board[groupNames]]";	
	$contents= <<<EOF
	<TR>
		<TD COLSPAN="6" CLASS="TDAltStyle"><STRONG>$board[boardName]$closed</STRONG>$board[groupNames] $description</TD>
	</TR>	
EOF;
	return $contents;		
}//getBoardRowHTML

//  Column labels on listings
//  Return: HTML
function getForumLabelsHTML(){
	global $Language,$Member;
	$Member['memberId']?$startColumn = "<TD CLASS=\"TitleTR\" WIDTH=\"2%\">$Language[Start]</TD>":$colspan=" COLSPAN=2";
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR" COLSPAN="2">$Language[Forums]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Topics]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Posts]</TD>
		<TD CLASS="TitleTR"$colspan>$Language[LatestPosts]</TD>
		$startColumn
	</TR>	
EOF;
	return $contents;
}//getForumLabelsHTML

//  Format each forum row on listing
//  Parameter: BoardDetails(Array)
//  Return: HTML	
function getForumRowHTML($forum){
	global $Document,$Language,$Member;
	$closed=$forum[boardStatus] && $forum[forumStatus]?"":commonGetIconImage("closed",$Language['Boardforumclosed']);
	
	$Member[memberId] || $Document[allowGuestPosting]?$startButton = "<TD CLASS=\"TDStyle\" WIDTH=\"2%\" ALIGN=\"CENTER\">" . commonGetIconButton("newtopic","$Language[NewTopic]","?mode=post&action=new&forumId=$forum[forumId]","") . "</TD>":$colspan=" COLSPAN=2";
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle" WIDTH="2%"><IMG SRC="images/forumread$forum[forumRead].gif"></TD>
		<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=forums&forumId=$forum[forumId]">$forum[forumName]</A>$closed$forum[announcement]</TD>
		<TD CLASS="TDStyle" WIDTH="5%" ALIGN="CENTER">$forum[topics] </TD>
		<TD CLASS="TDStyle" WIDTH="5%" ALIGN="CENTER">$forum[posts] </TD>
		<TD CLASS="TDStyle"$colspan>
			<A HREF="$Document[mainScript]?mode=topics&topicId=$forum[topicId]&page=x#$forum[latestPostId]">$forum[subject]</A><BR />
			$forum[latestPostDate]  $forum[latestMemberName]
		</TD>
		$startButton
	</TR>	
EOF;
	return $contents;		
}//getForumRowHTML

//  Format bottom part of listings with quick search box & mark-as-read button if available
//  Return: HTML	
function getBottomBoardHTML(){
	global $Member,$Language,$Document,$VARS;
	if($Member['memberId']){
		$navigation = commonLanguageButton("markread",$Language['Markasread'],"?mode=boards&boardId=$VARS[boardId]&action=markread","");
	}
	$Document[quickSearch]=commonQuickSearch();
	$contents= <<<EOF
		<TABLE WIDTH="100%">
		<TR>
			<TD WIDTH="50%">
				$navigation							
			</TD>
			<TD WIDTH="50%" ALIGN="RIGHT">
				$Document[quickSearch]
			</TD>						
		</TR>
		</TABLE>
EOF;
	return $contents;		
}//getBottomBoardHTML
	
?>