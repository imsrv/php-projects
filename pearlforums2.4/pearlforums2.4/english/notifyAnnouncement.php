<? 

function getNotifyAnnouncement($details){
	$contents = <<<EOF
	
Hello $details[name], <BR><BR>

An announcement has been posted by $details[postedBy], please click
on the link below to view:<BR /><BR />

<STRONG>$details[subject]</STRONG><BR />
<A HREF="$details[url]">$details[url]</A>. <BR /><BR />

If you wish to disable further announcement notifications, please login and update your 
preferences.
<BR /><BR /><BR />

Best Regards,<BR />
$details[organization]<BR />
	
EOF;

	return $contents;
	
}
?>
