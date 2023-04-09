<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    forums.php - HTML templates for outputs of forum screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format forum description with moderators, if any.  The showForumInfo variable can be set in admin settings
//  Return: HTML
function getDescriptionHTML(){
	global $Document,$Language;
	$Document['forumDescription'] = nl2br($Document['forumDescription']);
	$contents =<<<EOF
	<TR>
		<TD CLASS="TDAltStyle" COLSPAN="6">
			$Document[moderatorsList]
			$Document[forumDescription]			 
		</TD>
	</TR>
EOF;
	return $contents;
}//getDescriptionHTML	

//  Column labels on listings
//  Return: HTML
function getTopicLabelsHTML(){
	global $Language;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR" COLSPAN="2">$Language[Topic]</TD>
		<TD CLASS="TitleTR">$Language[StartedBy]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Replies]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Views]</TD>
		<TD CLASS="TitleTR">$Language[LatestReply]</TD>
	</TR>	
EOF;
	return $contents;
}//getTopicLabelsHTML


//  Format each row on listing
//  Parameter: TopicDetails(Array)
//  Return: HTML
function getTopicRowHTML($topic){
	global $Document,$GlobalSettings,$Language;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle" WIDTH="2%"><IMG SRC="$GlobalSettings[smileysPath]/$topic[fileName]" HSPACE="0"></TD>
		<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=topics&topicId=$topic[topicId]">$topic[subject]</A>$topic[sticky] $topic[locked] $topic[unread]</TD>
		<TD CLASS="TDStyle">$topic[startedBy]</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER" WIDTH="5%">$topic[replies] </TD>
		<TD CLASS="TDStyle" ALIGN="CENTER" WIDTH="5%">$topic[views] </TD>
		<TD CLASS="TDStyle">
			$topic[latestDetails]	
		</TD>
	</TR>	
EOF;
		return $contents;
}//getTopicRowHTML
		
//  Format top forum navigation including paging and buttons
//  Parameter: Buttons(string),$pagingLinks(string)
//  Return: HTML
function getTopForumNavigationHTML($buttons,$paging){
	global $Member,$Language,$Forum,$Document;
	$pageLabel=$Document[TotalPages]>1?$Language[Pages]:$Language[Page];
	$contents= <<<EOF
		<TABLE WIDTH="100%">
		<TR>
			<TD>
				$buttons
			</TD>
			<TD ALIGN="RIGHT">
				$Document[TotalPages] $pageLabel: $paging
			</TD>
		</TR>
		</TABLE>
EOF;
	return $contents;		
}//getTopForumNavigationHTML

//  Format bottom forum navigation including paging, buttons and quicksearch box
//  Return: HTML
function getBottomForumNavigationHTML(){
	global $Member,$Language,$Forum,$Document,$VARS;
	$pageLabel=$Document[TotalPages]>1?$Language[Pages]:$Language[Page];
	$spacer="&nbsp;&nbsp;";
	if($Member['memberId']){
		$navigation = commonLanguageButton("markread",$Language['Markasread'],"?mode=forums&forumId=$Document[forumId]&action=markread&page=$VARS[page]","");
	}
	$Document[quickSearch]=commonQuickSearch();
	$contents= <<<EOF
		<TABLE WIDTH="100%">
		<TR>
			<TD>
				$navigation							
			</TD>
			<TD>
				$Document[quickSearch]					
			</TD>
			<TD ALIGN="RIGHT">
				$Document[TotalPages] $pageLabel: $Document[pageList]
			</TD>
		</TR>
		</TABLE>
EOF;
	return $contents;
		
}//getBottomForumNavigationHTML

?>