<? 

function getRegistrationMessage(){	
	global $GlobalSettings,$Document, $Language, $VARS;
	extract($VARS,EXTR_OVERWRITE);
	$contents = <<<EOF
	
Thank you, $name! <BR><BR>

A random password has been emailed to your account.  Please check
your email for login details.<BR /><BR /><BR/>

Best Regards,<BR>
$GlobalSettings[Organization]<BR>
<BR /><BR />
EOF;
	return $contents;
}

function getRegistrationEmailMessage($details){	
	global $GlobalSettings,$Document, $Language, $VARS;
	extract($VARS,EXTR_OVERWRITE);
	$contents = <<<EOF
	
Hello $details[name]! <BR/><BR/>

Welcome to $GlobalSettings[Organization].  Please login using your details below.  
You might want to change your password to something easier to
remember. <BR/><BR/>

Login Name: $details[loginName]<BR/>
Password: $details[password] <BR/><BR/>
URL: <A HREF="http://$GlobalSettings[serverName]$GlobalSettings[boardPath]/$Document[scriptName]">http://$GlobalSettings[serverName]$GlobalSettings[boardPath]/$Document[scriptName]</A> <BR/><BR/>


Best Regards,<BR>
$GlobalSettings[Organization]<BR>
<BR /><BR />
EOF;
	return $contents;	
}
?>
