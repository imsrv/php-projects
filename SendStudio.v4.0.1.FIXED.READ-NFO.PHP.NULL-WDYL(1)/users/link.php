<?

	include("../includes/config.inc.php");

	$LinkID = @$_REQUEST["LinkID"];
	$UserID = @$_REQUEST["UserID"];

	$Link = @mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE LinkID='$LinkID'");
	$Member = @mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE MemberID='$UserID'");

	if(@mysql_num_rows($Link)==1)
	{
		$Link = mysql_fetch_array($Link);

		if(@mysql_num_rows($Member)==1)		
			mysql_query("INSERT INTO " . $TABLEPREFIX . "link_clicks SET LinkID='$LinkID', TimeStamp='$SYSTEMTIME', MemberID='$UserID', IPAddress='" . @$_SERVER["REMOTE_ADDR"] . "'");

		header("Location: " . $Link["URL"]);
	}
	else
	{
		echo "Invalid link data.";
	}

?>