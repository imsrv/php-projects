<?

	include("../includes/config.inc.php");
	include("../includes/members.inc.php");

	global $ROOTURL;

	$ListID = @$_REQUEST["ListID"];
	$FormID = @$_REQUEST["FormID"];
	$PageID = @$_REQUEST["PageID"];
	$Email = @$_REQUEST["Email"];
	$Format = @$_REQUEST["Format"];
	$FormCode = @$_REQUEST["FormCode"];
	$SelectLists = @$_REQUEST["SelectLists"];
	$Fields = @$_REQUEST["Fields"];

	$ListsToUse = array();
	$Errors = array();
	$ListsList = "";
	$aller = "";

	$form = mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID' && FormCode='$FormCode'");

	if(mysql_num_rows($form) != 1)
	{
		include "../includes/"."forms.inc.php";
		echo FormCode($FormID);
	}
	else
	{
		$form = mysql_fetch_array($form);
		$ListID = @mysql_result(@mysql_query("SELECT ListID FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'"), 0, 0);
		$list = @mysql_fetch_array(@mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='$ListID'"));
		$WebmasterName = @$list["WebmasterName"];
		$WebmasterEmail = @$list["WebmasterEmail"];
		$status = 0;

		// Now we need to workout if this list can accept subscriptions/unsubscriptions
		if($form["FormType"] == "sub")
			$status = $list["CanSubscribe"];
		else
			$status = $list["CanUnSubscribe"];

		// Can this form accept subscriptions/unsubscriptions?
		if($status == 1)
		{
			switch($form["FormType"])
			{
				case "sub":
				{
					//decide which lists!
					$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");

					while($fl=mysql_fetch_array($form_lists))
					{
						if($form["SelectLists"]==1)
						{
							if(@$SelectLists[$fl["ListID"]]=="YES")
							{
								$ListsToUse[]=$fl["ListID"];
							}
						}
						else
						{
							$ListsToUse[]=$fl["ListID"];
						}
					}

					//check the fields needed are all there!
					if(!$Email)
					{
						$Errors[] = "<li>You forgot to enter a valid email address</li>";
					}
					else if(substr_count($Email,"@")!=1 || substr_count($Email,".")==0)
					{
						$Error = "<li>You entered an invalid email address</li>";
					}
					
					if($Format!=1 && $Format!=0)
					{
						$Errors[] = "<li>You forgot to specify a newsletter format</li>";
					}
					
					//now other field verifications!
					//first do anything special with the fields!
					$form_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_fields WHERE FormID='$FormID'");

					while($ff=mysql_fetch_array($form_fields))
					{
						if($ff["Combine"]==1)
						{
							$Fields[$ff["FieldID"]]=$Fields[$ff["CombineWith"]];
						}
						
						if($ff["SetValue"]==1)
						{
							$Fields[$ff["FieldID"]]=$ff["TheValue"];
						}
					}
						
					//now verify all provided data is ok for all lists!			
					$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");

					foreach($ListsToUse as $ListID)
					{
						$fl["ListID"]=$ListID;
						$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='$ListID'"));
						//check the email is not being replicated and it not banned
						if(Banned($Email,$fl["ListID"]))
						{
							$Errors[] = "<li>Your email address is banned from joining '" . $listinfo["ListName"] . "'</li>";
						}
						
						if(mysql_num_rows($rest=mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE Email LIKE '$Email' && ListID='$ListID'"))>0)
						{
							$rest=mysql_fetch_array($rest);
							
							if($rest["Confirmed"]==0 || $rest["Status"]==0)
							{
								mysql_query("DELETE FROM " . $TABLEPREFIX . "members WHERE MemberID='".$rest["MemberID"]."'");
							}
							else
							{
								$Errors[] = "<li>Your are already subscribed to '" . $listinfo["ListName"] . "'</li>";
							}
						}

						$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $form["AdminID"] . "'");
						
						while($lf=mysql_fetch_array($list_fields))
						{
							//if its a drop down check the value fits!
							if($lf["FieldType"]=="dropdown")
							{
								$FieldGood=0;
								$valpa=explode(";", $lf["AllValues"]);

								foreach($valpa as $pair)
								{
									if($pair != "")
									{
										list($val,$name) = @explode("->",$pair);

										if($val == $Fields[$lf["FieldID"]])
										{
											$FieldGood=1;
										}
									}
								}
								
								if($FieldGood!=1)
								{
									$Errors[] = "<li>The field '" . $lf["FieldName"] . "' has an invalid value</li>";
								}	
							}

							//check if its required!
							if($lf["Required"]==1)
							{
								if(!$Fields[$lf["FieldID"]] OR $Fields[$lf["FieldID"]]==$lf["DefaultValue"])
								{
									$Errors[] = "<li>The field '" . $lf["FieldName"] . "' is a required field</li>";
								}
							}
						}
					}
				
					if(sizeof($Errors)==0)
					{
						//we are safe to add the user!
						reset($ListsToUse);
						
						if($form["RequireConfirm"]==1)
						{
							$Conf=0;
							$ConfirmCode=md5(uniqid(rand()));
						}
						else
						{
							$Conf=1;
							$ConfirmCode = "";
						}

						foreach($ListsToUse as $ListID)
						{
							$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='$ListID'"));
							
							mysql_query("INSERT INTO " . $TABLEPREFIX . "members SET Format='$Format', FormID='$FormID', ConfirmCode='$ConfirmCode', Email='$Email', ListID='$ListID', Status='1', Confirmed='$Conf', SubscribeDate='$SYSTEMTIME'");
							
							$UserID=mysql_insert_id();
							$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $form["AdminID"] . "'");
							
							while($f=mysql_fetch_array($fields))
							{
								mysql_query("INSERT INTO " . $TABLEPREFIX . "list_field_values SET UserID='$UserID', ListID='$ListID', FieldID='".$f["FieldID"]."', Value='" . @$Fields[$f["FieldID"]] . "'");
							}
							$ListsList.=$listinfo["ListName"]."\n";
						}

						if($Fields)
						{
							foreach($Fields as $Field=>$Val)
							{
								@$Tags["Field:".$FieldID]=$Val;
							}
						}
					
					$Tags["EMAIL"]=$Email;
					$Tags["LISTS"]=$ListsList;

					if($form["RequireConfirm"]==1)
					{
						$Tags["CONFIRMLINK"] = $ROOTURL . "users/confirm.php?Email=$Email&ConfirmCode=$ConfirmCode";
						$ConfEmail = ParsePage("ConfirmEmail", $Tags, $FormID);

						$ConfEmail = str_replace("\r\n", chr(13), $ConfEmail);
						@mail($Email, "Confirmation request", $ConfEmail, "From: $WebmasterName <$WebmasterEmail>");

						// Should we output the confirmation page, or redirect to a page they have specified?
						$pURL = @mysql_result(@mysql_query("select ResponseData from " . $TABLEPREFIX . "form_responses where FormID = " . $FormID . " and ResponseName='ConfirmURL'"), 0, 0);

						if($pURL != "" && $pURL != "http://")
						{
							header("location: " . $pURL);
							die();
						}
						else
						{
							echo ParsePage("ConfirmPage", $Tags, $FormID);
						}
					}
					else if($form["SendThankyou"]==1)
					{
						$ConfEmail = ParsePage("ThanksEmail", $Tags, $FormID);

						$ConfEmail = str_replace("\r\n", chr(13), $ConfEmail);
						@mail($Email,"Welcome to our list",$ConfEmail,"From: $WebmasterName <$WebmasterEmail>");
					
						// Should we output the thankyou page, or redirect to a page they have specified?
						$tURL = @mysql_result(@mysql_query("select ResponseData from " . $TABLEPREFIX . "form_responses where FormID = " . $FormID . " and ResponseName='ThanksURL'"), 0, 0);

						if($tURL != "" && $tURL != "http://")
						{
							header("location: " . $tURL);
							die();
						}
						else
						{
							echo ParsePage("ThanksPage", $Tags, $FormID);
						}
					}
					else
					{
						// Default thank you page
						// Should we output the thankyou page, or redirect to a page they have specified?
						$tURL = @mysql_result(@mysql_query("select ResponseData from " . $TABLEPREFIX . "form_responses where FormID = " . $FormID . " and ResponseName='ThanksURL'"), 0, 0);

						if($tURL != "" && $tURL != "http://")
						{
							header("location: " . $tURL);
							die();
						}
						else
						{
							echo ParsePage("ThanksPage", $Tags, $FormID);
						}
					}
				}
				else
				{
					foreach($Errors as $Error)
					{
						$aller .= $Error;
					}

					$aller = str_replace("\n", "", "<ul>" . $aller . "</ul>");
					$Tags["ERRORLIST"]=$aller;

					// Should we output the error page, or redirect to a page they have specified?
					$eURL = @mysql_result(@mysql_query("select ResponseData from " . $TABLEPREFIX . "form_responses where FormID = " . $FormID . " and ResponseName='ErrorURL'"), 0, 0);

					if($eURL != "" && $eURL != "http://")
					{
						header("location: " . $eURL . "?error=" . urlencode($aller));
						die();
					}
					else
					{
						echo ParsePage("ErrorPage",$Tags,$FormID);
					}
				}
				
				break;
				
				}
				
				case "unsub":
				{
					//find user in lists!
					$Good=0;
					
					//decide which lists!
					$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
					
					while($fl=mysql_fetch_array($form_lists))
					{
						if($form["SelectLists"]==1)
						{
							if($SelectLists[$fl["ListID"]]=="YES")
							{
								$ListsToUse[]=$fl["ListID"];
							}
						}
						else
						{
							$ListsToUse[]=$fl["ListID"];
						}
					}
					
					$ConfirmCode=md5(uniqid(rand()));

					if($form["RequireConfirm"]==1)
					{
						foreach($ListsToUse as $ListID)
						{
							//search for member in list!
							if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE Email LIKE '$Email' && ListID='$ListID' && Confirmed='1' && Status='1'")))
							{
								mysql_query("UPDATE " . $TABLEPREFIX . "members SET FormID='$FormID', ConfirmCode='$ConfirmCode' WHERE Email LIKE '$Email' && ListID='$ListID'");
								$Good=1;
							}
						}

						if($Good!=1)
						{
							$Tags["ERRORLIST"] = "<ul><li>Your email was not found in any of the selected mailing lists</li></ul>";

							// Should we output the error page, or redirect to a page they have specified?
							$eURL = @mysql_result(@mysql_query("select ResponseData from " . $TABLEPREFIX . "form_responses where FormID = " . $FormID . " and ResponseName='ErrorURL'"), 0, 0);

							if($eURL != "" && $eURL != "http://")
							{
								header("location: " . $eURL . "?error=" . urlencode($Tags["ERRORLIST"]));
								die();
							}
							else
							{
								echo ParsePage("ErrorPage",$Tags,$FormID);
							}
						}
						else
						{
							//send confirmation request email.
							$Tags["CONFIRMLINK"] = $ROOTURL . "users/unsub.php?Email=$Email&ConfirmCode=$ConfirmCode";
							$ConfEmail=ParsePage("ConfirmEmail", $Tags, $FormID);
							$ConfEmail = str_replace("\r\n", chr(13), $ConfEmail);
					
							@mail($Email,"Unsubscribe confirmation request",$ConfEmail,"From: $WebmasterName <$WebmasterEmail>");

							// Should we output the confirmation page, or redirect to a page they have specified?
							$pURL = @mysql_result(@mysql_query("select ResponseData from " . $TABLEPREFIX . "form_responses where FormID = " . $FormID . " and ResponseName='ConfirmURL'"), 0, 0);

							if($pURL != "" && $pURL != "http://")
							{
								header("location: " . $pURL);
								die();
							}
							else
							{
								echo ParsePage("ConfirmPage", $Tags, $FormID);
							}
						}
					}
					else
					{
						foreach($ListsToUse as $ListID)
						{
							//search for member in list!
							if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE Email = '$Email' && ListID='$ListID'")))
							{
								mysql_query("DELETE FROM " . $TABLEPREFIX . "members WHERE Email = '$Email' && ListID='$ListID'");
								$Good=1;
							}
						}
					
						if($Good!=1)
						{
							$Tags["ERRORLIST"] = "<ul><li>Your email was not found in any of the selected mailing lists</li></li>";

							// Should we output the error page, or redirect to a page they have specified?
							$eURL = @mysql_result(@mysql_query("select ResponseData from " . $TABLEPREFIX . "form_responses where FormID = " . $FormID . " and ResponseName='ErrorURL'"), 0, 0);

							if($eURL != "" && $eURL != "http://")
							{
								header("location: " . $eURL . "?error=" . urlencode($Tags["ERRORLIST"]));
								die();
							}
							else
							{
								echo ParsePage("ErrorPage",$Tags,$FormID);
							}
						}
						else
						{
							if($form["SendThankyou"]==1)
							{
								$Tags["EMAIL"]=$Email;
								$ConfEmail=ParsePage("ThanksEmail", $Tags, $FormID);
								$ConfEmail = str_replace("\r\n", chr(13), $ConfEmail);
								@mail($Email,"Unsubscription successful",$ConfEmail,"From: $WebmasterName <$WebmasterEmail>");

								// Should we output the thankyou page, or redirect to a page they have specified?
								$tURL = @mysql_result(@mysql_query("select ResponseData from " . $TABLEPREFIX . "form_responses where FormID = " . $FormID . " and ResponseName='ThanksURL'"), 0, 0);

								if($tURL != "" && $tURL != "http://")
								{
									header("location: " . $tURL);
									die();
								}
								else
								{
									echo ParsePage("ThanksPage", $Tags, $FormID);
								}
							}
						}
					}
					break;
				}
			}
		}
		else
		{
			// This form isn't accepting subscriptions/unsubscriptions
			$type = "";

			if($form["FormType"] == "sub")
				$type = "subscriptions";
			else
				$type = "unsubscriptions";
			
			echo "<font face=Verdana size=2>This mailing list is currently not accepting " . $type . ".<br><br><a href='javascript:history.go(-1)'>Try Again...</a></font>";
		}
	}

	function ParsePage($PageID, $Tags, $FormID)
	{
		global $TABLEPREFIX;

		$page=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='$PageID'"));
		$Page=$page["ResponseData"];
		
		foreach($Tags as $Tag=>$Value)
		{
			$Page=str_replace("%$Tag%",$Value,$Page);
		}

		return $Page;
	}

?>