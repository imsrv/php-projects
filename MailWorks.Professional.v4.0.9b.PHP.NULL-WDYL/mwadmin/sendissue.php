<?php

	include("templates/top.php");

	include_once("includes/functions.php");

	$what = @$_POST["what"];

	if($what == "")
		$what = @$_GET["what"];

	if(!in_array("issues_send", $authLevel))
		{

			noAccess();

			include("templates/bottom.php");

			exit;

		}



	switch($what)
		{

			case "send":
				SendNewsletter();
				break;

			case "done":
				ShowStatus();
				break;

			default:
				GetSendingOptions();
		}


	function GetSendingOptions()
		{

			global $siteEmail, $dbPrefix;

			// This will allow the user to choose which newsletter to send

			doDbConnect();

			// Do we need to retrieve the details for a newsletter from the database?

			$iId = @$_GET["iId"];

			if($iId != -1 && $iId != "")
				{

					$result = mysql_query("SELECT * FROM {$dbPrefix}_issues INNER JOIN {$dbPrefix}_newsletters ON {$dbPrefix}_issues.iNewsletterId = {$dbPrefix}_newsletters.pk_nId WHERE {$dbPrefix}_issues.pk_iId = $iId");

					if($row = mysql_fetch_row($result))
						{

							//details

							$fromEmail = $row[13];

							$replyToEmail = $row[14];

							$subject = $row[2];

							$newsletterId = $row[4];

							$status = $row[5];


							// Workout the number of recipients for this newsletter

							$numRecips = mysql_result(mysql_query("SELECT count(pk_sId) FROM {$dbPrefix}_subscriptions INNER JOIN {$dbPrefix}_subscribedusers ON {$dbPrefix}_subscriptions.sSubscriberId = {$dbPrefix}_subscribedusers.pk_suId and {$dbPrefix}_subscriptions.sNewsletterId = '$newsletterId'"), 0, 0);

							$numSubscribers = number_format($numRecips);

						}

				}

			?>

				<script language="JavaScript">

					function GetNewsletterStats()
						{

							var iId = document.frmSend.iId.options[document.frmSend.iId.selectedIndex].value;

							document.location.href = 'sendissue.php?iId='+iId;

						}

				</script>

				<?php

					if($iId == -1 || $iId == "")
						$content = "Sending a newsletter to your subscriber list is easy -- start by choosing which newsletter you would like to send from the list shown below.";
					else
						$content = "The details for the selected newsletter are shown below. To send the newsletter to the subscriber list for this email now, click on the \"Send Newsletter\" button.";

					MakeMsgPage('Send Newsletter', $content . '<br><br>', 0);

				?>

					<tr>

						<td>

							<form name="frmSend" action="sendissue.php" method="post">

							<input type="hidden" name="what" value="send">

							<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

								<tr>

									<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

											Issue Details

									</td>

								</tr>

								<tr>

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Issue To Send</strong><br>

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<select onChange="GetNewsletterStats()" name="iId" style="width: 196pt" tabindex="1">

													<?php

														if($iId == "")
															echo "<option value='-1'>-- Select Newsletter --</option>";

														// Gather a list of newsletters from the database

														$result = mysql_query("SELECT pk_iId, iName, iFile FROM {$dbPrefix}_issues ORDER BY iName ASC");

														while($row = mysql_fetch_row($result))
															{

																echo "<option ";

																if($iId == $row[0])
																	echo " SELECTED ";

																if($row[2] != '')
																	$import = ' -- IMPORTED';
																else
																	$import = '';

																echo " value='{$row[0]}'>{$row[1]}   $import</option>";

															}

													?>

												</select>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

											<?php

												if($iId == -1 || $iId == "")
													{

														?>

															<tr bgcolor="#E7E8F5">

																<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

																<td class="BodyText" valign="middle" colspan="2">

																	<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																		[Please select an Issue to proceed]<br>

																	</p>

																</td>


																<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

															</tr>

															<tr>

																<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="1" valign="middle"></td>

															</tr>

														<?php

													}
												else
													{

														// Display the details of this mailing

														?>

															<tr bgcolor="#E7E8F5">

																<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

																<td width="25%" class="BodyText" valign="middle">

																	<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																		<strong>Subject Line</strong><br>

																		<a href="newsletter.php?what=modify&nId=<?php echo $newsletterId; ?>">Edit</a>

																	</p>

																</td>

																<td width="75%">

																	<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																		<input type="text" DISABLED size="40" value="<?php echo $subject; ?>">

																	</p>

																</td>

																<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

															</tr>

															<tr>

																<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

																<td width="25%" class="BodyText" valign="middle">

																	<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																		<strong>"From" Email Address</strong><br>

																		<a href="newsletter.php?what=modify&nId=<?php echo $newsletterId; ?>">Edit</a>

																	</p>

																</td>

																<td width="75%">

																	<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																		<input type="text" DISABLED size="40" value="<?php echo $fromEmail; ?>">

																	</p>

																</td>

																<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

															</tr>

															<tr bgcolor="#E7E8F5">

																<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

																<td width="25%" class="BodyText" valign="middle">

																	<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																		<strong>"Reply-To" Email Address</strong><br>

																		<a href="newsletter.php?what=modify&nId=<?php echo $newsletterId; ?>">Edit</a>

																	</p>

																</td>

																<td width="75%">

																	<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																		<input type="text" DISABLED size="40" value="<?php echo $replyToEmail; ?>">

																	</p>

																</td>

																<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

															</tr>

															<tr>

																<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

																<td width="25%" class="BodyText" valign="middle">

																	<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																		<strong>Number Of Subscribers</strong><br>

																	</p>

																</td>

																<td width="75%">

																	<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																		<input type="text" DISABLED size="10" value="<?php echo $numSubscribers; ?>">

																	</p>

																</td>

																<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

															</tr>

															<?php

																if($status == 'sent')
																	{

																		$numFailed = mysql_result(mysql_query("SELECT COUNT(pk_isId) FROM {$dbPrefix}_issuestatus WHERE isStatus = '0' AND isNewsletterId = '$iId'"), 0, 0);

																		$numStatus = mysql_result(mysql_query("SELECT COUNT(pk_isId) FROM {$dbPrefix}_issuestatus WHERE isNewsletterId = '$iId'"), 0, 0);

																		$check = $numFailed > 0 ? true : false;

																		?>

																			<tr bgcolor="#E7E8F5">

																				<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

																				<td width="25%" class="BodyText" valign="middle">

																					<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																						<strong>Send To</strong><br>

																					</p>

																				</td>

																				<td width="75%">

																					<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																						<select name="strSend" style="width: 196pt">

																							<option value="all" <?php if(!$check) echo "selected"; ?>>All Subscribers</option>
																							<option value="failed"<?php if($check) echo "selected"; else echo "disabled"; ?> disabled>Failed</option>

																							<?php

																								if(@$numSubscribers > @$numStatus)
																									{

																										?>

																											<option value="continue">Continue</option>

																										<?php

																									}

																							?>

																						</select>

																					</p>

																				</td>

																				<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

																			</tr>

																		<?php

																	}
																else
																	{

																		?>

																			<tr bgcolor="#E7E8F5">

																				<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

																				<td width="25%" class="BodyText" valign="middle">

																					<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																						<strong>Send To</strong><br>

																					</p>

																				</td>

																				<td width="75%" class="BodyText">

																					<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																						<input name="strSend" checked type="radio" value="all"> All Subscribers<br>
																						<input name="strSend" type="radio" value="testEmail"> Test Newsletter (<strong><?php echo $siteEmail; ?></strong>)

																					</p>

																				</td>

																				<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

																			</tr>

																		<?php

																	}

															?>

																<tr>

																	<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="1" valign="middle"></td>

																</tr>

																<tr>

																	<td colspan="4">

																		<br>

																		<input type="button" value="« Cancel" onClick="ConfirmCancel('sendissue.php')">

																		<input type="submit" name="submit" value="Send Newsletter »" <?php if(number_format($numRecips) == 0) { echo "DISABLED"; } ?>>

																	</td>

																</tr>

														<?php

													}

											?>



										</table>

									</td>

								</tr>

							</table>

						</td>

					</tr>

				</table>

			<?php

		}

	function SendNewsletter()
		{

			// Get the details of this newsletter from the database and use JavaScript

			// and a hidden iFrame to send it

			global $siteEmail, $siteURL, $dbPrefix;

			doDbConnect();

			$iId = @$_POST["iId"];
			$strSend = @$_POST['strSend'];

			$result = mysql_query("SELECT * FROM {$dbPrefix}_issues INNER JOIN {$dbPrefix}_newsletters ON {$dbPrefix}_issues.iNewsletterId = {$dbPrefix}_newsletters.pk_nId WHERE {$dbPrefix}_issues.pk_iId = $iId");

			// get the values, and also check that there is actually a newsletter attached to this issue.

			if($row = mysql_fetch_row($result))
				{

					$fromEmail = $row[13];

					$replyToEmail = $row[14];

					$subject = $row[2];

					$newsletterId = $row[4];

					// HTML or TEXT
					$format = $row[17];

					//Append a tracking image to the newsletter (HTML ONLY
					$track = $row[19];

					// If import will need this var
					$file = $row[8];

					// Workout the number of recipients for this newsletter
					// If the sending the failed list, will need a different query because not all the subscribers will fail.

					switch($strSend)
						{

							case "continue";
		 						$strQuery  = @mysql_query("SELECT count(*) FROM {$dbPrefix}_subscriptions INNER JOIN {$dbPrefix}_subscribedusers ON {$dbPrefix}_subscriptions.sSubscriberId = {$dbPrefix}_subscribedusers.pk_suId WHERE {$dbPrefix}_subscribedusers.suStatus = 'subscribed' AND {$dbPrefix}_subscriptions.sNewsletterId = $newsletterId");
								$numTotal  = @mysql_result($strQuery, 0, 0);
								$strQuery  = @mysql_query("SELECT count(*) FROM {$dbPrefix}_issuestatus INNER JOIN {$dbPrefix}_subscribedusers ON {$dbPrefix}_subscribedusers.pk_suId = {$dbPrefix}_issuestatus.isSubscribeId WHERE {$dbPrefix}_subscribedusers.suStatus = 'subscribed' AND {$dbPrefix}_issuestatus.isNewsletterId = $iId");
								$numSent   = mysql_result($strQuery, 0, 0);
								$numRecips = $numTotal - $numSent;
								break;

							case "failed";
								$strQuery  = @mysql_query("SELECT count(*) FROM {$dbPrefix}_issuestatus INNER JOIN {$dbPrefix}_subscribedusers ON {$dbPrefix}_subscribedusers.pk_suId = {$dbPrefix}_issuestatus.isSubscribeId WHERE {$dbPrefix}_subscribedusers.suStatus = 'subscribed' AND {$dbPrefix}_issuestatus.isNewsletterId = $iId AND {$dbPrefix}_issuestatus.isStatus = '0'");
								$numRecips = @mysql_result($strQuery, 0, 0);
								break;

							case "testEmail";
								$numRecips = 1;
								break;

							default;
		 						$strQuery	= @mysql_query("SELECT count(*) FROM {$dbPrefix}_subscriptions INNER JOIN {$dbPrefix}_subscribedusers ON {$dbPrefix}_subscriptions.sSubscriberId = {$dbPrefix}_subscribedusers.pk_suId WHERE {$dbPrefix}_subscribedusers.suStatus = 'subscribed' AND {$dbPrefix}_subscriptions.sNewsletterId = $newsletterId");
								$numRecips 	= @mysql_result($strQuery, 0, 0);
								break;

						}



					// If sending a test email, make sure to set the numRecips to 1

					if($numRecips == 0)
						{

							// There are no recipients for this newsletter

							if($strSend == "failed")
								$content = 'This newsletter that you are currently attempting to send has 0 failed subscribers and therefore it cannot be sent.<br><br><a href="sendissue.php">Continue >></a>';
							else
								$content = 'This newsletter that you are currently attempting to send has 0 subscribers and therefore it cannot be sent.<br><br><a href="sendissue.php">Continue >></a>';

							MakeMsgPage('Send Newsletter',$content);

						}
					else
						{

							// Everything is OK, start sending the emails and set up the variables for sending the email

							// update the status of the email, as if we don't the continue option will not show if the sending fails for some reason

							@mysql_query("UPDATE {$dbPrefix}_issues SET iStatus = 'sent' WHERE pk_iId = '$iId'");

							// This ensures that there are not multiple enteries in the issuestatus.
							if($strSend == "all")
								@mysql_query("DELETE FROM {$dbPrefix}_issuestatus WHERE isNewsletterId = '{$row[0]}'");

							if($file != '')
								{

									// This is an import template, upload the file contents into nContents.

									$fHandle = fopen("issues/$file", "rb");

									if($fHandle)
										{

											while(!feof($fHandle))
												@$data .= fgets($fHandle, 1024);

											$data = addslashes($data);

										}
									else
										$data = '';

									if($data != '')
										{

											// Upload the $data into the database

											@mysql_query("UPDATE {$dbPrefix}_issues SET iContent = '$data' WHERE pk_iId = $iId");

										}

								}

							?>

								<form name="frmSend">

								<input type="hidden" name="subject" value="<?php echo $subject; ?>">
								<input type="hidden" name="fromEmail" value="<?php echo $fromEmail; ?>">
								<input type="hidden" name="replyToEmail" value="<?php echo $replyToEmail; ?>">
								<input type="hidden" name="iId" value="<?php echo $iId; ?>">
								<input type="hidden" name="newsletterId" value="<?php echo $newsletterId; ?>">
								<input type="hidden" name="format" value="<?php echo $format; ?>">
								<input type="hidden" name="currentPos" value="<?php if(isset($numSent)) echo $numSent; else echo '0'; ?>">
								<input type="hidden" name="numSent" value="0">
								<input type="hidden" name="numFailed" value="0">
								<input type="hidden" name="startTime" value="<?php echo time(); ?>">
								<input type="hidden" name="numSubs" value="<?php echo $numRecips; ?>">
								<input type="hidden" name="track" value="<?php echo $track; ?>">
								<input type="hidden" name="strSend" value="<?php echo $strSend; ?>">
								<input type="hidden" name="delArray" value="">

								<?php MakeMsgPage('Send Newsletter Issue', 'The selected issue is being sent...<br><br>If the newsletter should stop sending for an extended period of time, use the following button to continue sending.<br><br><a href="javascript: iSend.history.go(-1);">Resume</a><br><br><strong>Note: </strong>Please do not close or refresh this browser window while the newsletter issue is sending.', 0); ?>

									<tr>

										<td>

											<table width="95%" border="0" cellspacing="0" cellpadding="0">

												<tr>

													<td>

														<iframe id="iNum" frameborder="no" style="background-color: black;" scrolling="no" width="550" height="35"></iframe><br>

														<iframe id="iStatus" frameborder="1" scrolling="auto" width="100%" height="350"></iframe><br>

														<img src="images/blank.gif" width="1" height="5"><br>

														<input type="button" value="« Cancel" onClick="ConfirmCancel('sendissue.php?nId=<?php echo $iId; ?>')">

														<input type="submit" DISABLED name="submit" value="Working...">

														<iframe id="iSend" frameborder="no" scrolling="no" width="550" height="30"></iframe><br>

													</td>

												</tr>

											</table>

										</td>

									</tr>

								</table>

								</form>

								<script language="JavaScript">

									// This will start out the sending

									function SendIt()

										{

											currentPos = document.frmSend.currentPos.value;

											iSend.location.href = 'sendit.php?currentPos='+currentPos;

										}

									SendIt();

								</script>

							<?php

						}

				}
			else
				{

					MakeMsgPage('Send Newsletter Issue', 'An error occured while trying to send this newsletter to the subscriber list.<br><br><a href="javascript:document.location.reload()">Try Again</a>', 0);

				}

		}

	function ShowStatus()
		{

			// Show the status of the mailout

			global $siteName, $siteURL, $siteEmail, $dbPrefix;

			$numSent = @$_GET["success"];
			$numFail = @$_GET["fail"];
			$startTime = @$_GET["start"];
			$iId = @$_GET["iId"];
			$delArray = explode(",", @$_GET["delArray"]);
			$test = @$_GET["test"];

			doDbConnect();

			if($test == "true")
				{

					$content = "The selected newsletter has been sent to $siteEmail. Click on the link below to go back and send it to your subscriber list.<br><br><a href='sendissue.php?iId=$iId'>Continue &raquo;</a>";

					MakeMsgPage("Send Newsletter Issue", $content);

				}
			else
				{

					//@mysql_query("UPDATE {$dbPrefix}_issues SET iStatus = 'sent' WHERE pk_iId = $iId") or die(mysql_error());

					$content = 'The selected issue has been sent. The statistics for the mail out
								are shown in the bulleted list below. Click "Continue" to return to the send
								issue page.';

			// Number of emails sent

			if($numSent == 1)
				$numSent = "{$numSent} email was sent successfully";
			else
				{

					if($numSent < 0)
						$numSent = 0;

				$numSent = "{$numSent} emails were sent successfully\r\n\r\n";

				}

			// Number of emails not sent

			if($numFail == 1)
				$numFail = "{$numFail} email failed";
			else
				$numFail = "{$numFail} emails failed";

			//Time it took to send the emails

			$currTime = time();

			$numMins = number_format(DateDiff("n", $startTime, $currTime), 2);

			$numSecs = DateDiff("s", $startTime, $currTime);

			if($numMins > 0)
				$numMins = "It took  $numMins minute(s) to send the newsletter issue";
			else
				$numMins = "It took  $numSecs second(s) to send the newsletter issue";

			$content .= '<ul><li>' . $numSent . '</li><li>' . $numFail . '</li><li>' . $numMins . '</li></ul>';

			// did any users get deleted?

			if($delArray[0] != '')
				{

					$content .= "Deleted Emails:<ul>";

					for($i = 0; $i < sizeof($delArray) - 1; $i++)
							$content .= "<li>{$delArray[$i]}</li>";

					$content .= "</ul>These Email Account have been deleted because they have failed twice, as per your configuration.";

				}

			if($numFail > 0)
				$content = '<a href="sendissue.php?nId=' . $iId . '">Resend To Failed</a> | ';

			$content .= '<a href="issues.php">Continue >></a>';

			MakeMsgPage('Send Newsletter Issue', $content);




			//send email to administrator about the success/failure of the newsletter being sent!

			$content = "{$siteName} Administrator,<br><br>The purpose of this email is to inform you of the status of your recent newsletter issue being sent out.<br><br>Please review the status of your issue below<br><ul>";

			$content .= "<li>$numSent</li>";

			$content .= "<li>$numFail</li>";

			$content .= "<li>$numMins</li>";

			$content .= "</ul>This concludes the status of the issue that was recently sent.<br><br>{$siteURL}/mwadmin/login.php";

				$content = MakeStatusEmail($content);

				$headers = MakeHeader($siteEmail, 'html');

				mail($siteEmail,"Newsletter Status from MailWorks Professional",$content,$headers);

			}

		}

	include("templates/bottom.php");

?>