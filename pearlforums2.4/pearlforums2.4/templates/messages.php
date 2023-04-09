<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    messages.php - HTML templates for outputs of messaging screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Get correct title for openning table header
//  Return: HTML
function getTopMessagesHTML(){
	global $Language,$Document,$VARS;
	switch($VARS[action]){
		case "new":
			$label="$Language[NewMessage]";
			break;
		case "reply":
			$label="$Language[ReplyMessage]";
			break;
		case "Send":
			$label="$Language[MessageSent]";
			break;
		default:
			$label= $Language[Messages];
	}
	return commonTableHeader(true,0,300,$label);
}//getTopMessagesHTML

//  Format search box
//  Return: HTML
function getSearchBoxHTML(){
	Global $Document,$Language,$VARS;
	$searchBox=<<<EOF
		<BR />
		<TABLE WIDTH="$Document[contentWidth]" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0" BORDER="0">
		<FORM ACTION="$Document[mainScript]">
		<INPUT TYPE="HIDDEN" NAME="mode" VALUE="messages" />
		<TR>
			<TD CLASS="TDStyle">
				$Document[msg]
			</TD>
			<TD CLASS="TDStyle" ALIGN="RIGHT">
			$Language[Keywords]:<INPUT TYPE="TEXT" SIZE="10" NAME="searchText" VALUE="$VARS[searchText]"><INPUT TYPE="SUBMIT" VALUE="$Language[Search]" CLASS="GoButton" />
			</TD>
		</TR></FORM>			
		</TABLE>		
EOF;
	return $searchBox;
}//getSearchBoxHTML

//  Format listing labels
//  Return: HTML
function getTitleMessagesHTML(){
	global $Language,$Document;
	$contents .= <<<EOF
			<TR>
				<TD CLASS="TitleTR">&nbsp;</TD>			
				<TD CLASS="TitleTR" WIDTH="40%">$Language[Subject]</TD>
				<TD CLASS="TitleTR">$Language[Date]</TD>
				<TD CLASS="TitleTR">$Language[From]</TD>
				<TD CLASS="TitleTR" WIDTH="5%">$Language[Delete]</TD>
				<TD CLASS="TitleTR" WIDTH="5%">$Language[ReplyMessage]</TD>
			</TR>
EOF;
	return $contents;
}//getTitleMessagesHTML

//  Format message for display
//  Parameter: MessageDetails(Array)
//  Return: HTML
function getViewMessageHTML($message){
	Global $Language,$Document;
	
	$contents = "<BR />";
	$contents .= commonTableFormatHTML("header",$Document['contentWidth'],"");
	$buttons = commonLanguageButton("deletepost","$Language[Delete]","?mode=messages&action=delete&messageId=$message[messageId]",$confirmation) . " &nbsp; " ;	
	$buttons .= commonLanguageButton("replymessage",$Language['Reply'],"?mode=messages&action=reply&messageId=$message[messageId]","");	
	$navigation=commonWhiteTableBoxHTML(120,$buttons);	
	$message['message']=nl2br($message['message']);

	$contents .= <<<EOF
	<TR>
		<TD CLASS="TitleTR">
			$Language[From]: <A HREF="$Document[mainScript]?mode=profile&loginName=$message[loginName]">$message[name]</A> [$message[sendTime]]
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">
		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
		<TR>
			<TD CLASS="TDStyle">
				<STRONG>$message[subject]</STRONG>
			</TD>
			<TD CLASS="TDStyle" ALIGN="RIGHT">
				$navigation
			</TD>
		</TR>
		</TABLE>
		<BR />
		$message[message]
		<BR />
		$message[attachment]
		</TD>
	</TR>
EOF;
	$contents .= commonTableFormatHTML("footer","","");
	$contents .= "<BR />";
	return $contents;
}//getViewMessageHTML

//  Format each row on listing
//  Parameter: MessageDetails(Array)
//  Return: HTML
function getMessageRowHTML($message){
	global $Language,$Document;
	$confirmation=commonDeleteConfirmation("$Language[Delete] $Language[Message2]?");
	$deleteButton=commonGetIconButton("delete",$Language[Delete],"?mode=messages&&action=delete&messageId=$message[messageId]",$confirmation);
	$replyButton=commonGetIconButton("replymessage",$Language[ReplyMessage],"?mode=messages&action=reply&messageId=$message[messageId]","");

	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle" WIDTH="2%"><IMG SRC="images/message$message[status].gif"></TD>
		<TD CLASS="TDStyle" WIDTH="40%"><A HREF="$Document[mainScript]?mode=messages&action=view&messageId=$message[messageId]">$message[subject]</A> $message[attachment]</TD>
		<TD CLASS="TDStyle">$message[sendTime]</TD>
		<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=profile&loginName=$message[loginName]">$message[name]</A></TD>				
		<TD CLASS="TDStyle" WIDTH="5%" ALIGN="CENTER">
			$deleteButton
		</TD>
		<TD CLASS="TDStyle" WIDTH="5%" ALIGN="CENTER">
			$replyButton
		</TD>
	</TR>
EOF;
	return $contents;
}//getMessageRowHTML

//  Format form for creating new message
//  Parameters: Receiver(string), ActionButtons(string)
//  Return: HTML
function getMessageFormHTML($receiver,$buttons){
	global $GlobalSettings,$Language,$Document,$VARS,$Member;
	$Document[HTMLAreaMode]=true;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	extract($VARS,EXTR_OVERWRITE);

	$message=stripslashes($message);

	if($action=="reply"){	
		$subject =preg_match('/^Re:/', $receiver[subject])?$receiver[subject]:"Re: $receiver[subject]";
		$date = commonTimeFormat(false,$receiver[sendTime]);				
		$message=<<<EOF
<BR>
<BR>
----- $Language[OriginalMessage] ----- <BR>
$Language[From]: $receiver[name]<BR>
$Language[Date]: $date<BR>
$Language[Subject]: $receiver[subject] <BR><BR>

$receiver[message]	

EOF;
	}
	if($Document['allowMessageAttachments']){ 
	$attachments = <<<EOF
	<TR>
		<TD CLASS="TDPlain">
			<INPUT STYLE="width:300" NAME="userfile" TYPE="file"> <SPAN CLASS="GreyText">[$Language[Attachment]]</SPAN>
		</TD>		
	</TR>	
EOF;
	}
	
	$contents = <<<EOF
	<BR>
<TABLE CLASS="htmlAreaTable" WIDTH="600" ALIGN="CENTER" CELLPADDING="0" CELLSPACING="0">
<TR>
	<TD>
	
	<FORM NAME="editor" ACTION="$Document[mainScript]" METHOD="POST" ENCTYPE="multipart/form-data">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="messages">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="send">
	<INPUT TYPE="HIDDEN" NAME="receiverId" VALUE="$receiver[memberId]">
	<INPUT TYPE="HIDDEN" NAME="loginName" VALUE="$receiver[loginName]">	
	<INPUT TYPE="HIDDEN" NAME="name" VALUE="$receiver[name]">	
	<INPUT TYPE="HIDDEN" NAME="replyMessageId" VALUE="$receiver[replyMessageId]">
	<INPUT TYPE="HIDDEN" NAME="messageId" VALUE="$receiver[messageId]">
	<TABLE ALIGN="CENTER" CELLPADDING="5" CELLSPACING="0">
	<TR>
		<TD CLASS="TDPlain"  ALIGN="CENTER">
			<SPAN CLASS="Error">$Document[msg]</SPAN> &nbsp;
		</TD>		
	</TR>	
	<TR>		
		<TD CLASS="TDPlain">
			<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
			<TR>
				<TD CLASS="TDPlain" WIDTH="60">$Language[To]:</TD>
				<TD CLASS="TDPlain"><STRONG>$receiver[name]</STRONG></TD>
			</TR>
			<TR>
				<TD CLASS="TDPlain">$Language[Subject]:</TD>
				<TD CLASS="TDPlain"><INPUT TYPE="TEXT" NAME="subject" STYLE="width:400" VALUE="$subject" MAXLENGTH="100">	</TD>
			</TR>
			</TABLE>
		</TD>		
	</TR>	
	<TR>
		<TD CLASS="TDPlain">
			<TEXTAREA ID="message" NAME="message" STYLE="width:560" ROWS="20">$message</TEXTAREA>
		</TD>		
	</TR>	
	$attachments
	<TR>
		<TD CLASS="TDPlain">
			<INPUT TYPE="CHECKBOX" NAME="disableHTML" VALUE="1">$Language[DisableHTML]
		</TD>		
	</TR>			
	<TR>
		<TD CLASS="TDPlain">
			$buttons
		</TD>		
	</TR>	
	</TABLE>
	<BR>
	</FORM>
	</TD>
</TR>
</TABLE>
<BR>
EOF;
	return $contents;
}//getMessageFormHTML


?>