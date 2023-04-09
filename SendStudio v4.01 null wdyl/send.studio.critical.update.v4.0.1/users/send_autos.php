<?

	include("../includes/config.inc.php");
	include("../admin/includes/createemails.inc.php");

	// Are there any autoresponders that need sending?
	$numAR = @mysql_result(@mysql_query("SELECT COUNT(*) FROM " . $TABLEPREFIX . "autoresponders"), 0, 0);
	$EmailBody = array();

	if($numAR > 0)
	{
		$members = mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE Status='1'");

		while($m = mysql_fetch_array($members))
		{
			$hours = round(($SYSTEMTIME-$m["SubscribeDate"])/3600);
			$lrList = mysql_query("SELECT * FROM " . $TABLEPREFIX . "autoresponders WHERE AutoresponderID='". $m["LastResponderID"] ."'");

			if($lr = mysql_fetch_array($lrList))
				$lasthours = $lr["HoursAfterSubscription"];
			else
				$lasthours = 0;

			$responders = mysql_query("SELECT * FROM " . $TABLEPREFIX . "autoresponders WHERE ListID='".$m["ListID"]."' && HoursAfterSubscription > '$lasthours' ORDER BY HoursAfterSubscription");

			while($r = mysql_fetch_array($responders))
			{
				if($hours >= $r["HoursAfterSubscription"])
				{
					//send the responder!
					$EmailBody["HTMLBody"] = stripslashes($r["HTMLBody"]);
					$EmailBody["TextBody"] = stripslashes($r["TextBody"]);
					$EmailBody["ListID"] = $m["ListID"];

					if($r["Format"] == 1)
					{
						$f = "HTML";
					}
					else
					{
						$f = "TEXT";
					}
				
					$TheEmail = EmailBody("0", $m["MemberID"], $f, $EmailBody);
					$TheEmail = str_replace("\r\n", chr(13), $TheEmail);

					if($f == "TEXT")
						mail($m["Email"], $r["Subject"], $TheEmail, "From: " . $r["SendFrom"]);
					else
						mail($m["Email"], $r["Subject"], $TheEmail, "From: " . $r["SendFrom"] . "\nContent-type: text/html");

					mysql_query("UPDATE " . $TABLEPREFIX . "members SET LastResponderID='" . $r["AutoresponderID"] . "' WHERE MemberID='" . $m["MemberID"] . "'");
				}
			}
		}
	}
?>