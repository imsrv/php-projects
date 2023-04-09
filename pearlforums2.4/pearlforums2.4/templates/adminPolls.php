<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminPolls.php - HTML templates for outputs of 
//                  poll/poll votes screens in admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format each poll row on listing
//  Parameter: PollDetails(Array)
//  Return: HTML
function getPollRowHTML($poll){
	global $AdminLanguage,$Language,$Document;

	$deleteLink=commonGetIconButton("delete","$Language[Delete] $Language[Poll]","?mode=admin&case=polls&action=delete&topicId=$poll[topicId]&pollId=$poll[pollId]",commonDeleteConfirmation("$AdminLanguage[Deletepollconfirm]"));	
	$detailsLink=commonGetIconButton("polldetails",$AdminLanguage['VotingDetails'],"?mode=admin&case=polls&action=details&topicId=$poll[topicId]","");
	$closeLink=$poll['status']?commonGetIconButton("closepoll","$AdminLanguage[ClosePoll]","?mode=poll&action=close&topicId=$poll[topicId]",""):commonGetIconButton("openpoll","$Language[Open] $Language[Poll]","?mode=poll&action=open&topicId=$poll[topicId]","");

	$poll['endDate']=$poll['status']?"":date("F j, Y",$poll['startDate']);
	$poll['startDate']=date("F j, Y",$poll['startDate']);
	
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=topics&topicId=$poll[topicId]">$poll[subject]</A></TD>
		<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=profile&loginName=$poll[loginName]">$poll[name]</A></TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">$deleteLink</TD>		
		<TD CLASS="TDStyle" ALIGN="CENTER">$closeLink</TD>		
		<TD CLASS="TDStyle" ALIGN="CENTER">$detailsLink</TD>
	</TR>
EOF;
	return $contents;
}//getPollRowHTML

//  Format each vote row on listing
//  Parameter: VoteDetails(Array)
//  Return: HTML
function getVoteRowHTML($vote){
	global $AdminLanguage,$Language,$Document;
	$vote['votedDate']=date("F j, Y",$vote['votedDate']);
	
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=profile&loginName=$vote[loginName]">$vote[name]</A></TD>
		<TD CLASS="TDStyle">$vote[option]</TD>
		<TD CLASS="TDStyle">$vote[votedDate]</TD>
	</TR>
EOF;
	return $contents;
}//getVoteRowHTML

//  Column labels on polls' listings
//  Return: HTML
function getColumnLabelsHTML(){
	global $Language,$AdminLanguage;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">$Language[Subject]</TD>
		<TD CLASS="TitleTR">$AdminLanguage[Member]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Delete]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Open]/$Language[Close]</TD>
		<TD CLASS="TitleTR" ALIGN="CENTER">$AdminLanguage[Details]</TD>

	</TR>	
EOF;
	return $contents;
}//getColumnLabelsHTML

//  Column labels on votes' listings
//  Return: HTML
function getVoteLabelsHTML(){
	global $Language,$AdminLanguage;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">$AdminLanguage[Member]</TD>
		<TD CLASS="TitleTR">$AdminLanguage[Voted]</TD>
		<TD CLASS="TitleTR">$Language[Date]</TD>
	</TR>	
EOF;
	return $contents;
}//getColumnLabelsHTML

//  Format top search box and messages
//  Return: HTML
function getSearchBoxHTML(){
	GLOBAL $Language,$Document,$VARS,$AdminLanguage;	
	$contents= <<<EOF
	<BR />
	<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0" BORDER="0">
	<FORM ACTION="$Document[mainScript]">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="polls">	
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

//  Format Poll's summary
//  Parameter: PollDetails(Array)
//  Return: HTML
function getPollSummaryHTML($details){
	Global $Language,$AdminLanguage;	
	$contents= <<<EOF
	<BR />
	<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0" BORDER="0">
	<TR>
		<TD CLASS="TDPlain">
		<STRONG>$AdminLanguage[Summary]</STRONG><BR /><BR />
		$Language[Question]: $details[question]<BR>
		$details[options] <BR />
		$Language[Total]:  $details[totalVotes]
		</TD>
	</TR>	
	</FORM>
	</TABLE>
	<BR />
EOF;
	return $contents;	
}//getPollSummaryHTML

?>