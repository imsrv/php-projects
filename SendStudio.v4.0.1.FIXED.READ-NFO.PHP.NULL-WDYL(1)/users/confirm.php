<?

include("../includes/config.inc.php");

$Email = @$_REQUEST["Email"];
$ConfirmCode = @$_REQUEST["ConfirmCode"];

$res = mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE Confirmed = 0 && Email = '$Email' && ConfirmCode = '$ConfirmCode'");

if(mysql_num_rows($res) > 0)
{	
	while($c=mysql_fetch_array($res))
	{
		$FormID = $c["FormID"];
		$form=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID'"));
		mysql_query("UPDATE " . $TABLEPREFIX . "members SET ConfirmCode='', Confirmed='1' WHERE MemberID='".$c["MemberID"]."'");
		$ListID = (int)@mysql_result(@mysql_query("SELECT ListID FROM " . $TABLEPREFIX . "members WHERE MemberID='" . $c["MemberID"] . "'"), 0, 0);
	}

	// Workout the webmaster name and email
	$wResult = @mysql_query("SELECT WebmasterName, WebmasterEmail FROM " . $TABLEPREFIX . "lists WHERE ListID='$ListID'");

	if($wRow = @mysql_fetch_array($wResult))
	{
		$WebmasterName = @$wRow["WebmasterName"];
		$WebmasterEmail = @$wRow["WebmasterEmail"];
	}
	else
	{
		$WebmasterName = $WebmasterEmail = "";
	}
	
	$Tags["EMAIL"] = $c["Email"];
	echo ParsePage("ThanksPage",$Tags,$FormID);
	
	if($form["SendThankyou"]==1)
	{
		$ConfEmail = ParsePage("ThanksEmail", $Tags, $FormID);
		$ConfEmail = str_replace("\r\n", chr(13), $ConfEmail);
		mail($Email,"Welcome to our list",$ConfEmail,"From: $WebmasterName <$WebmasterEmail>");
	}
}
else
{
	echo "<font face=Verdana size=2>You have already confirmed your subscription to this mailing list.</font>";
}

function ParsePage($PageID, $Tags, $FormID)
{
	global $TABLEPREFIX;

	$page = mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='$PageID'"));
	$Page = $page["ResponseData"];
	
	foreach($Tags as $Tag=>$Value)
	{
		$Page = str_replace("%$Tag%",$Value,$Page);
	}

	return $Page;
}

?>