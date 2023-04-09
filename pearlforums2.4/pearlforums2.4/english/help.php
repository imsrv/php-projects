<? 

function getHelpContents(){
	global $Document,$GlobalSettings,$Language;
	$avatarTypes=implode(",",$Document[avatarTypes]);

	$contents = <<<EOF
	<BR/><BR/>
<TABLE WIDTH="90%" ALIGN="CENTER">
<TR>
	<TD CLASS="TDPlain">
<A NAME="Profile"><STRONG><U>PROFILE</U></STRONG></A><BR><BR>
<EM>Password</EM> - You need to provide your password everytime you make changes
to your profile.<BR>
<EM>Avatar</EM> - You can upload your own photo in one of the following formats: $avatarTypes.

<HR SIZE="10"><BR/>

<A NAME="Messages"></A>
<STRONG><U>MESSAGES</U></STRONG>:<BR><BR>
There's a maximum number of messages you can receive.  It's
now set at: $Document[maxMemberMessages].  You can also 
receive attachments, up to $Document[maxMessageAttachment] bytes.



	</TD>
</TR>
</TABLE>	
EOF;
	return $contents;
	
}
?>
