<? 

function getNotifyMessage($details){
	$contents = <<<EOF
	
Hello $details[name], <BR><BR>

$details[repliedBy] has replied to the posting <STRONG>$details[subject]</STRONG> on
$details[organization]. <BR><BR>

Click on this link to view: <A HREF="$details[url]">$details[url]</A>. <BR><BR>

If you wish to disable notification for this topic, please login and
remove this notify entry from your list.</A>. <BR><BR>

Best Regards,<BR>
$details[organization]<BR>
	
EOF;

	return $contents;
	
}
?>
