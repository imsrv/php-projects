<? 
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    post.php - HTML templates for outputs of posting screens.
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
function getPostFormHTML($title,$actionType){
	global $GlobalSettings,$Language, $Document,$VARS,$Member;
	$Document[HTMLAreaMode]=true;
	extract($VARS,EXTR_OVERWRITE);
	$submitButton =commonGetSubmitButton(false,$Language[$actionType],"");
	$contents = commonTableHeader(true,0,300,$title);	
	$smileyListing= commonSmileyListing($smileyId);
	$message=stripslashes($message);
	if($poll){
		include_once("$GlobalSettings[templatesDirectory]/poll.php");
		$pollDetails=getPollFormHTML($pollId);
	}
	if($topicId && $subject==""){
		$subject =preg_match('/^Re:/', $Document[subject])?$Document[subject]:"Re: $Document[subject]";
	}
	if($Member[accessLevelId] < 4 && !$topicId){ //admin, global moderators, or moderators
		$lockChecked=$locked?"checked":"";
		$lockTopic = <<<EOF
		<TR>
			<TD CLASS="TDPlain">
				<INPUT TYPE="CHECKBOX" NAME="locked" VALUE="1" $lockChecked>$Language[LockTopic]
			</TD>		
		</TR>		
EOF;
	}

	if($Document['allowAttachments']){ //admin or global moderators
	$attachments = <<<EOF
	<TR>
		<TD CLASS="TDPlain">
			<INPUT SIZE="40" NAME="userfile" TYPE="file"> <SPAN CLASS="GreyText">[$Language[AttachFile]]</SPAN>
		</TD>		
	</TR>	
EOF;
	}	
	
	$contents .= <<<EOF
	<BR />
<TABLE CLASS="htmlAreaTable" WIDTH="600" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0">
<TR>
	<TD>

	<FORM NAME="edit" ID="edit" ACTION="$Document[mainScript]" METHOD="POST" ENCTYPE="multipart/form-data">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="post">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="$actionType">
	<INPUT TYPE="HIDDEN" NAME="postId" VALUE="$postId">	
	<INPUT TYPE="HIDDEN" NAME="forumId" VALUE="$forumId">
	<INPUT TYPE="HIDDEN" NAME="topicId" VALUE="$topicId">
	<INPUT TYPE="HIDDEN" NAME="oldExt" VALUE="$fileType">	
	<INPUT TYPE="HIDDEN" NAME="poll" VALUE="$poll">	
	<TABLE ALIGN="CENTER" CELLPADDING="2" CELLSPACING="0">
	<TR>
		<TD CLASS="TDPlain">
			<SPAN CLASS="Error">$Document[msg]</SPAN> &nbsp;
		</TD>		
	</TR>		
	<TR>
		<TD CLASS="TDPlain">$pollDetails</TD>		
	</TR>			
	<TR>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="subject" STYLE="width:420px" VALUE="$subject" MAXLENGTH="100">	
			<SELECT NAME="smileyId" onChange="showSampleSmiley()">
				$smileyListing
			</SELECT>
			<IMG NAME="sampleSmiley" SRC="$GlobalSettings[smileysPath]/default.gif">
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDPlain">
			<TEXTAREA ID="message" NAME="message" STYLE="width:560" COLS="60" ROWS="20">$message</TEXTAREA>
		</TD>		
	</TR>	
	$attachments
	<TR>
		<TD CLASS="TDPlain">
			<INPUT TYPE="CHECKBOX" NAME="disableHTML" VALUE="1">$Language[DisableHTML]
		</TD>		
	</TR>		
	$lockTopic
	<TR>
		<TD CLASS="TDPlain">
			$submitButton 
		</TD>		
	</TR>	
	</TABLE>
	</FORM>
	<BR>
	</TD>
</TR>
</TABLE>
<BR><BR>
	<SCRIPT>
		var sampleSmileys=new Array($Document[sampleSmileys]);
		showSampleSmiley();
		
		function showSampleSmiley(){
			document.images.sampleSmiley.src="$GlobalSettings[smileysPath]/"+sampleSmileys[document.edit.smileyId.selectedIndex];
        }
	</SCRIPT>

EOF;
	$contents .= commonTableFooter(true,0,"&nbsp;");
	return $contents;
}//getPostFormHTML

//  Format message as quote
//  Parameter: Message(String)
//  Return: HTML
function quoteHTML($message){
	$contents =<<<EOF
<TABLE STYLE="border: black 1px dotted;background-color: #EEEEEE">
<TR>
	<TD CLASS="TDPlain"><FONT SIZE=2><em>$message</em></FONT></TD>
</TR>
</TABLE>

EOF;
	return $contents;
}//quoteHTML

//  Format results page with auto forwading
//  Parameter: Message(string), RedirectTime(integer)
//  Return: HTML
function displayMessageHTML($msg,$redirectTime){
	global $Language, $Document,$VARS,$Member;
	extract($VARS,EXTR_OVERWRITE);
	$page=$page==""?"x":$page;
	$redirectTime=$redirectTime * 1000;
	$subject=trim($subject)==""?$Document['topicSubject']:stripslashes($subject);
	$contents = commonTableHeader(true,0,300,$Language['Posting']);
	if($redirectTime){
		$redirectScript = <<<EOF
		<script language="javascript">
			setTimeout("forward()",$redirectTime);
			function forward(){
				location = '$Document[mainScript]?mode=topics&topicId=$topicId&page=$page&nl=1';
			}
		</script>
EOF;
	}		
	$contents .= <<<EOF
		<P ALIGN="CENTER">
		<BR />
		$Language[Thankyou] $msg <BR /><BR /><BR />
				
		<A HREF="$Document[mainScript]?mode=topics&topicId=$topicId&page=$page&nl=1">$subject</A>	
		
		<BR /><BR /><BR />
		$redirectScript	
		</P>
EOF;
	$contents .= commonTableFooter(true,0,"&nbsp;");
	return $contents;
}//displayMessageHTML

?>
