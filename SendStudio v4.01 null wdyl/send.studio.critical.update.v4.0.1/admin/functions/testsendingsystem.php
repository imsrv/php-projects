<?

	// Test the SendStudio sending system
	$TestEmail = @$_REQUEST["TestEmail"];

	if(@mail($TestEmail, "SendStudio Sending System Test", "If you have received this email, then SendStudio is properly configured to send emails."))
	{
		$OUTPUT .= MakeSuccessBox("SendStudio Sending System OK", "SendStudio can successfully send email. A test email has been sent to '$TestEmail'.", "javascript:window.close()");
	}
	else
	{
		$OUTPUT .= MakeErrorBox("An Error Occured", "<br>An error occured while trying to test the SendStudio sending system. Please contact your web host to make sure that PHP is configured to correctly send email.");
	}
?>