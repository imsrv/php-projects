<?

	include("../includes/config.inc.php");

	$Email = @$_REQUEST["Email"];
	$ConfirmCode = @$_REQUEST["ConfirmCode"];

	$res = mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE Email LIKE '$Email' && ConfirmCode='$ConfirmCode'");

	if(mysql_num_rows($res) > 0)
	{	
		while($c=mysql_fetch_array($res))
		{
			$FormID = $c["FormID"];
			$form=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID'"));
			mysql_query("DELETE FROM " . $TABLEPREFIX . "members WHERE MemberID='" . $c["MemberID"] . "'");
		}
		
		$Tags["EMAIL"] = $c["Email"];

		// Should we output the thankyou page, or redirect to a page they have specified?
		$tURL = @mysql_result(@mysql_query("select ResponseData from " . $TABLEPREFIX . "form_responses where FormID = " . $FormID . " and ResponseName='ThanksURL'"), 0, 0);

		if($tURL != "")
		{
			header("location: " . $tURL);
			die();
		}
		else
		{
			if($FormID != 0)
				echo ParsePage("ThanksPage", $Tags, $FormID);
			else
				echo "<font face=Verdana size=2>You have successfully unsubscribed from our mailing list.</font>";
		}

		if($form["SendThankyou"] == 1)
		{
			$ConfEmail = ParsePage("ThanksEmail", $Tags, $FormID);
			mail($Email,"Unsubscription successful",$ConfEmail,"From: $WebmasterName <$WebmasterEmail>");
		}
	}
	else
	{
		echo "<font face=Verdana size=2>Your email address was not found in our database.</font>";
	}

	function ParsePage($PageID, $Tags, $FormID)
	{
		global $TABLEPREFIX;

		$page=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='$PageID'"));
		$Page=$page["ResponseData"];
		
		foreach($Tags as $Tag=>$Value)
		{
			$Page = str_replace("%$Tag%",$Value,$Page);
		}

		return $Page;
	}

?>