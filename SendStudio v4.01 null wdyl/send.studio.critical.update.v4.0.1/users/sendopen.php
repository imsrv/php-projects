<?

	include("../includes/config.inc.php");

	$MemberID = @$_REQUEST["MemberID"];
	$SendID = @$_REQUEST["SendID"];

	if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE MemberID='$MemberID'")) > 0 && mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'")))
	{
		// Has this open already been tracked?
		$alreadyTracked = @mysql_result(@mysql_query("SELECT COUNT(*) FROM " . $TABLEPREFIX . "email_opens WHERE MemberID='$MemberID' and SendID='$SendID'"), 0, 0) > 0 ? true : false;

		if(!$alreadyTracked)
			@mysql_query("INSERT INTO " . $TABLEPREFIX . "email_opens SET MemberID='$MemberID', SendID='$SendID', TimeStamp='$SYSTEMTIME'");
	}

?>