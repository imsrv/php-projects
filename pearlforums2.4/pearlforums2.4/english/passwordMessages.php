<? 

function getRequestAlreadyProcessedMessage($name){	
	$contents = <<<EOF
<BR/>
<TABLE ALIGN="CENTER" WIDTH="400">
<TR>
	<TD CLASS="TDPlain">
	Hello, $name! <BR><BR>

	You have already changed your password on a previous request.  
	Please submit your email if you wish to change your password again.
	</TD>
</TR>
</TABLE>
<BR/><BR/>
EOF;
	return $contents;
}


function getSecurityCodeSentMessage($name){	
	$contents = <<<EOF
<BR/>
<TABLE ALIGN="CENTER" WIDTH="450">
<TR>
	<TD CLASS="TDPlain">
Thank you, $name! <BR><BR>

Please check your email for instructions on how to reset your password.
<BR /><BR /><BR/>
	</TD>
</TR>
</TABLE>

EOF;
	return $contents;
}

function getSecurityCodeEmailMessage($details){	
	global $GlobalSettings,$Document, $Language, $VARS;
	extract($VARS,EXTR_OVERWRITE);
	$currentTime = date("g:i a, F j, Y ");
	$ip=commonGetIpAddress();
	$contents = <<<EOF
Hello $details[name]! <BR/><BR/>

As requested, please 
<A HREF="http://$GlobalSettings[serverName]$Document[mainScript]?mode=password&action=reset&loginName=$details[loginName]&securityCode=$details[securityCode]">click here</A>
to choose a new password for your account:<BR/><BR/>

If you don't see a link above, copy and paste this URL into your browser's
address window: http://$GlobalSettings[serverName]$Document[mainScript]?mode=password&loginName=$details[loginName]&code=$details[securityCode]&action=reset</A>.<BR/><BR/>

Note that for security purposes, the link above can only be used once.  
If you need to retrieve your password again sometime in the future, you will
have to submit your email again.
<BR/><BR/>

Regards,<BR/>
$GlobalSettings[Organization]<BR/><BR/>

[Time: $currentTime - from $ip]
EOF;
	return $contents;	
}

?>
