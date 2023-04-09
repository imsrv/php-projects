<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    topics.php - HTML templates for outputs of topic screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////
		
//  Format topic title row
//  Parameter: ControlButtons(String)
//  Return: HTML
function getTopicTitleRowHTML($topicControls){
	global $Language,$Document,$Member;
	$ispoll=$Document['topicPoll']?"<IMG SRC=\"smileys/poll.gif\">":"";
	$locked=$Document['topicLock']==1?"- <SPAN CLASS=ERROR>$Language[TopicLocked]</SPAN>":"";
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">
			<TABLE WIDTH="100%" CELSPACING="0" CELLPADDING="0" BORDER="0">
			<TR>
				<TD>
					$ispoll $Document[topicSubject] [$Language[view] $Document[topicViews] $Language[times]] $locked
				</TD>
				<TD ALIGN="RIGHT">
				$topicControls
				</TD>
			</TR>
			</TABLE>
		</TD>
	</TR>	
EOF;
	return $contents;		
}//getTopicTitleRowHTML

//  Format each posting details
//  Parameter: PostDetails(Array)
//  Return: HTML
function getPostingRowHTML($post){
	global $Language,$Document,$GlobalSettings;
	
	$memberName=$post[name]?$memberName="<A HREF=\"$Document[mainScript]?mode=profile&loginName=$post[loginName]\">$post[name]</A>":$Language[Guest]; 
	if($Document[displayMemberProfile]){
		$avatar=$post[avatar]?"<DIV ID=\"MemberPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/$post[avatar]\"></DIV>":"<DIV ID=\"MemberPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/nophoto.gif\"></DIV>";
		$onlineStatus=$post[online]?$Language[CurrentlyOnline]:$Language[Offline];
		$onlineAlt=($Document[showIPs] || commonVerifyAdmin() || $Member['moderator'])?"[$Language[Messagepostedfrom] $post[ip]]":"";
		if(!$post[name]){//Guest posting
			$post[messageButton]="";
			$onlineStatus="";
		}
		$userProfileColumn = <<<EOF
			<TD VALIGN="TOP" WIDTH="120" CLASS="TDPlain" ALIGN="CENTER">
				<TABLE CELLPADDING="5" STYLE="border-style:outset;border-color:white;border-width:3px" WIDTH="100%">
				<TR>
					<TD ALIGN="CENTER">
					$avatar
					$memberName	
					$post[adminPosition]				
					
					$post[messageButton]
					<BR /><BR/>
					<IMG SRC="images/online$post[online].gif" ALT="$onlineStatus $onlineAlt" />					
					</TD>
				</TR>
				</TABLE>
			</TD>
			<TD WIDTH="10"><IMG SRC="images/spacer.gif" WIDTH="10" HEIGHT="1"></TD>
EOF;
		$memberName="";
	}
	$post['message']=commonFormatContents($post['message']);
	if($post[postControls])
		$postControls=commonWhiteTableBoxHTML(0,$post[postControls]);	
	if($Document['showEditTime'] && $post['postDate'] != $post['modifiedDate']){
		$by=$post[memberId] != $post[modifiedBy]?" - <A HREF=\"$Document[mainScript]?mode=profile&loginName=$post[modifierLoginName]\">$post[modifierName]</A>":"";
		$modifier="<I>$Language[Modified]: " . commonTimeFormat(false,$post['modifiedDate']) . "$by</I><BR />";
	}
	$post['postDate'] = commonTimeFormat(false,$post['postDate']);		
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle"><A NAME="$post[postId]"></A>
			<TABLE WIDTH="100%" CELLPADDING="0" CELLSPACING="0" BORDER="0">
			<TR>
				$userProfileColumn
				<TD CLASS="TDStyle" VALIGN="TOP">
					<TABLE WIDTH="100%">
					<TR>
						<TD CLASS="TDStyle">
							<STRONG>$post[subject]</STRONG> <IMG SRC="$GlobalSettings[smileysPath]/$post[smiley]"><BR />
							$post[postDate] <BR />	
							$modifier
							$memberName
						</TD>
						<TD ALIGN="RIGHT">
							$postControls
						</TD>
					</TR>
					<TR>
						<TD COLSPAN="2" CLASS="TDStyle"><BR />
							$post[poll]
							$post[message]		
							<BR />
							$post[attachment]				
						</TD>
					</TR>
					</TABLE>
				</TD>
			</TR>
			</TABLE>
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDAltStyle"><IMG SRC="images/spacer.gif" WIDTH="1" HEIGHT="2"></TD>
	</TR>
EOF;
	return $contents;
}//getPostingRowHTML
	
//  Format form for quick reply
//  Return: HTML
function getQuickReplyHTML(){
	global $GlobalSettings,$Language, $Document,$VARS,$Member;
	$Document[HTMLAreaMode]=true;

	extract($VARS,EXTR_OVERWRITE);
	$submitButton =commonGetSubmitButton(false,$Language[Post],"");
	$subject = "Re: $Document[topicSubject]";
	$smileyListing= commonSmileyListing($smileyId);

	$contents .= <<<EOF
<TR>
	<TD CLASS="TDStyle"><BR>
<TABLE CLASS="htmlAreaTable" WIDTH="600" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0">
<TR>
	<TD>	
	<FORM NAME="editor" ACTION="$Document[mainScript]" METHOD="POST" ENCTYPE="multipart/form-data">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="post">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="post">	
	<INPUT TYPE="HIDDEN" NAME="forumId" VALUE="$Document[forumId]">
	<INPUT TYPE="HIDDEN" NAME="topicId" VALUE="$topicId">
	<TABLE ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0">
	<TR>
		<TD CLASS="TDPlain">
			$Language[QuickReply]:<BR>
			<INPUT TYPE="TEXT" NAME="subject" STYLE="width:420px" VALUE="$subject" MAXLENGTH="100">	
			<SELECT NAME="smileyId" onChange="showSampleSmiley()">
				$smileyListing
			</SELECT>
			<IMG NAME="sampleSmiley" SRC="$GlobalSettings[smileysPath]/default.gif">
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDPlain">
			<TEXTAREA NAME="message" ID="message" STYLE="width:560" ROWS="15"></TEXTAREA>
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDPlain">
			$submitButton
		</TD>		
	</TR>	
	</TABLE>
	</FORM>
	<SCRIPT>
		var sampleSmileys=new Array($Document[sampleSmileys]);
		showSampleSmiley();
		
		function showSampleSmiley(){
  			document.images.sampleSmiley.src="$GlobalSettings[smileysPath]/"+sampleSmileys[document.editor.smileyId.selectedIndex];
        }
	</SCRIPT>		
	</TD>
</TR>	
<TR>
	<TD CLASS="TDPlain"><IMG SRC="images/spacer.gif" WIDTH="1" HEIGHT="2"></TD>
</TR>	
	</TD>
</TR>
</TABLE>
<BR>
EOF;
	return $contents;
}//getQuickReplyHTML
	
//  Format top navigation
//  Parameters: ControlButtons(String), Paging(String)
//  Return: HTML	
function getTopTopicNavigationHTML($buttons,$paging){
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
}//getTopTopicNavigationHTML

//  Format bottom navigation
//  Parameter: ControlButtons(String)
//  Return: HTML
function getBottomTopicNavigationHTML($buttons){
	global $Member,$Language,$Forum,$Document;	
	$Document[quickSearch]=commonQuickSearch();
	$pageLabel=$Document[TotalPages]>1?$Language[Pages]:$Language[Page];
	$contents= <<<EOF
		<TABLE WIDTH="100%">
		<TR>
			<TD>
				$buttons							
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
}//getBottomTopicNavigationHTML

//  Format HTML for auto forward back to topic
//  Parameter: TopicId(integer)
//  Return: HTML
function getForwardHTML($topicId){
	Global $Document;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle">
		<script language="javascript">
			location = '$Document[mainScript]?mode=topics&topicId=$topicId&page=x';
		</script>		
		</TD>
	</TR>
EOF;
	return $contents;
}//getForwardHTML

//  Format HTML for redirecting to forum listing of all topics
//  Parameter: RedirectTime(integer)
//  Return: HTML
function forwardForumHTML($autoRedirect){
	global $Document;
	$Document['contents'] = commonTableHeader(true,0,300,$Document[forumName]);

	if($autoRedirect){
		$redirectScript = <<<EOF
		<script language="javascript">
			location = '$Document[mainScript]?mode=forums&forumId=$Document[forumId]';
		</script>
EOF;
	}			
	$contents = <<<EOF
	<TABLE ALIGN="CENTER">
	<TR>
		<TD CLASS="TDPlain" ALIGN="CENTER"><BR /><BR />
		$redirectScript
		<A HREF="$Document[mainScript]?mode=forums&forumId=$Document[forumId]">$Document[forumName]</A>	
		<BR /><BR />
		</TD>
	</TR>
	</TABLE>	
EOF;
	$Document['contents'] .= $contents;
	$Document['contents'] .= commonTableFooter(true,0,"&nbsp;");
}//forwardForumHTML

//  Format posting for printer friendly 
//  Parameter: PostDetails(Array)
//  Return: HTML
function printHTML($post){
	$post['message']=commonFormatContents($post['message']);
	$contents =<<<EOF
<TR>
	<TD CLASS="TDStyle"><BR />
	<STRONG>$post[subject]</STRONG> <BR />
	$post[postDate] <BR />	
	$post[name]<BR /><BR />
	$post[poll]
	$post[message] <BR />
	</TD>
</TR>
EOF;
	return $contents;
}//printHTML

?>