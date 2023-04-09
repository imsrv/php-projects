<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    latest.php - HTML templates for outputs of latest postings.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format each posting with full topic links, member profiles, polls, attachments etc.. for each post
//  Parameter: PostDetails(Array)
//  Return: HTML
function getPostingRowHTML($post){
	global $Language,$Document,$GlobalSettings,$Member;
	
	$memberName=$post[name]?"<A HREF=\"$Document[mainScript]?mode=profile&loginName=$post[loginName]\">$post[name]</A> <BR />":"$Language[Guest]<BR/>"; 

	if($Document[displayMemberProfile]){
		$avatar=$post[avatar]?"<DIV ID=\"MemberPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/$post[avatar]\"></DIV>":"<DIV ID=\"MemberPhoto\"><IMG SRC=\"$GlobalSettings[avatarsPath]/nophoto.gif\"></DIV>";
		$onlineStatus=$post[online]?$Language[CurrentlyOnline]:$Language[Offline];
		$onlineAlt=($Document[showIPs] || commonVerifyAdmin() || $Member['moderator'])?"[$Language[Messagepostedfrom] $post[ip]]":"";
		if(!$post[name]){//Guest posting
			$post[messageButton]="";
			$onlineStatus="";
		}
		$userProfileColumn = <<<EOF
			<TD VALIGN="TOP" WIDTH="120" CLASS="TDStyle" ALIGN="CENTER">
				<TABLE CELLPADDING="5" STYLE="border-style:outset;border-color:white;border-width:3px" WIDTH="100%">
				<TR>
					<TD ALIGN="CENTER">
					$avatar
					$memberName					
					$post[messageButton]
					<BR/>
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
	$postControls=$Member['memberId'] || $Document['allowGuestPosting']?commonWhiteTableBoxHTML(0,$post[postControls]):"";	
	$contents= <<<EOF
	<TR>
		<TD CLASS="TitleTR">
			<A HREF="$Document[mainScript]?boardId=$post[boardId]">$post[boardName]</A> <IMG SRC="images/separator.gif" WIDTH="7" HEIGHT="7">
			<A HREF="$Document[mainScript]?mode=forums&forumId=$post[forumId]">$post[forumName]</A> <IMG SRC="images/separator.gif" WIDTH="7" HEIGHT="7">
			<A HREF="$Document[mainScript]?mode=topics&action=forward&topicId=$post[topicId]&postId=$post[postId]">$post[fsubject]</A>
		</TD>
	</TR>
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
	
?>