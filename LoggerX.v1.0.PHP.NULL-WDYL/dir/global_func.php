<?

function send_mails ($to, $subj, $body, $headers) {
	global $sendmail;
	// $smail=fopen("rrr.txt","w+");
	$smail=popen("$sendmail -t -i","w");
	fwrite($smail, "To: ".$to."\n");
	fwrite($smail,  $headers."\n");
	fwrite($smail, "Subject: ".$subj."\n\n");
	$body=stripslashes($body);
	fwrite($smail, $body);
	fwrite($smail, "\n\n");
	pclose($smail);

	//fclose($smail);
	//print ("\n $sendmail || $to || $subj || $body || $headers \n");

}

?>