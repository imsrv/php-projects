<?php

	/***********************************************************************\
	|																		|
	|	This script grabs the parameter values for the email from the		|
	|	parent frame and calls itself again with these parameters to send	|
	| 	the newsletter. It returns a value to the parent frame indicating	|
	|	success or failure													|
	|																		|
	|	***************  DO NOT EDIT THIS FUNCTION  *********************	|
	|																		|
	\**********************************************************************/

	include_once("conf.php");

	include_once("includes/functions.php");

	echo "<html><head><script language=\"JavaScript\">";

	$send = @$_GET["send"] == "" ? false : true;

	if($send == false)
		{

			// Grab the values from the parent frame and pass them back

			?>

				var subject = escape(parent.document[0].all.subject.value);
				var fromEmail = escape(parent.document[0].all.fromEmail.value);
				var replyToEmail = escape(parent.document[0].all.replyToEmail.value);
				var iId = escape(parent.document[0].all.iId.value);
				var newsletterId = escape(parent.document[0].all.newsletterId.value);
				var currentPos = escape(parent.document[0].all.currentPos.value);
				var format = escape(parent.document[0].all.format.value);
				var track = escape(parent.document[0].all.track.value);
				var strSend = escape(parent.document[0].all.strSend.value);

				//reload the document with the variables
				document.location.href = 'sendit.php?send=true&subject='+subject+'&fromEmail='+fromEmail+'&replyToEmail='+replyToEmail+'&iId='+iId+'&newsletterId='+newsletterId+'&marker='+currentPos+'&format='+format+'&track='+track+'&strSend='+strSend;

			<?php

		}
	else
		{

			// Send the email and pass a value back to the parent frame

			//variables for the function

			$subject = @$_GET["subject"];
			$fromEmail = @$_GET["fromEmail"];
			$replyToEmail = @$_GET["replyToEmail"];
			$iId = @$_GET["iId"];
			$newsletterId = @$_GET["newsletterId"];
			$format = @$_GET["format"];
			$track = @$_GET["track"];
			$strSend = @$_GET["strSend"];
			$currentPos = @$_GET["marker"];

			//Are we sending out the list or the test email?

			if($strSend == "testEmail")
				$test = true;
			else
				$test = false;

			// Grab the actual body of the newsletter from the database

			doDbConnect();

			$result = @mysql_query("SELECT iContent FROM {$dbPrefix}_issues WHERE pk_iId = $iId");

			if($row = @mysql_fetch_row($result))
				{

					// Get the content of the newsletter
					$content = $row[0];

					//build the query for the email list

					if($strSend == "failed")
						{

							$strQuery  = "SELECT * FROM {$dbPrefix}_subscribedusers INNER JOIN {$dbPrefix}_issuestatus ON ";
							$strQuery .= "{$dbPrefix}_subscribedusers.pk_suId = {$dbPrefix}_issuestatus.isSubscribeId WHERE ";
							$strQuery .= "{$dbPrefix}_subscribedusers.suStatus = 'subscribed' AND ";
							$strQuery .= "{$dbPrefix}_issuestatus.isNewsletterId = '$newsletterId' AND ";
							$strQuery .= "{$dbPrefix}_issuestatus.isStatus = '0' ORDER BY {$dbPrefix}_subscribedusers.pk_suId ASC LIMIT $currentPos, 1";

						}
					else
						{

							$strQuery  = "SELECT * FROM {$dbPrefix}_subscribedusers INNER JOIN {$dbPrefix}_subscriptions ON ";
							$strQuery .= "{$dbPrefix}_subscribedusers.pk_suId = {$dbPrefix}_subscriptions.sSubscriberId WHERE ";
							$strQuery .= "{$dbPrefix}_subscribedusers.suStatus = 'subscribed' AND ";
							$strQuery .= "{$dbPrefix}_subscriptions.sNewsletterId = {$newsletterId} ORDER BY {$dbPrefix}_subscribedusers.pk_suId ASC LIMIT $currentPos, 1";

						}

					$nResult = @mysql_query($strQuery);

					if($nRow = @mysql_fetch_row($nResult))
						{

							// Set up newsletter and sending details/options

							// Replace ------------------------------------------------

							$email = $nRow[1];

							if($test == true)
								{

									$content = PerTags($content, true, $nRow[0]);
									$subject = PerTags($subject, false, $nRow[0]);
									$email = $siteEmail;

								}
							else
								{

									$content = PerTags($content, false, $nRow[0], $email);
									$subject = PerTags($subject, true, $nRow[0], $email);

								}

							// Gets the number of custom fields, so that we can select the right index for the subscribe id, when entering the issue status

							$cust_count = mysql_result(mysql_query("select count(pk_cfId) from {$dbPrefix}_customfields"), 0, 0);

							// Add subsubscription line into email

							if(@$showUnsubscribe == '1')
								{

									$unsubscribe = "$siteURL/$siteFolder/index.php?what=doUn&email=$email&c=" . base64_encode($email) . "&t=1&nId=$newsletterId";
									$change = "$siteURL/$siteFolder/index.php?what=login&email=$email";

									if($format == 'html') {

										$formats = "<div align='center' style='font-face: verdana;'>\n<a href='{$unsubscribe}'>Unsubscribe</a>\n | <a href='{$change}'>Change Subscription Preferences</a>\n</div>";
										$content = str_replace("</BODY>", "$formats\n</BODY>", $content);
										$content = str_replace("</body>", "$formats\n</body>", $content);

									} else {

										$content .= "\r\n\r\nUnsubscribe: {$unsubscribe}\r\nChange Subscription Preferences: {$change}";

									}

								}

							// Tracking of HTML newsletters

							if($track == 1 && $test == false && $format == 'html')
								$content .= "<img src='{$siteURL}/$siteFolder/track.php?email={$email}&i={$iId}&r=1' width=1 height=1>";

							// End Replace --------------------------------------------

							// Headers ------------------------------------------------

							$headers = MakeHeader($fromEmail, $format, $replyToEmail);

							// End Headers --------------------------------------------

							// Send the email to the user
							if($currentPos == 0 && @$_GET["mm"] != "")
								$mResult = true;
							else
								$mResult = @mail(trim($email), $subject, $content, $headers);

							// Throttling ---------------------------------------------

							$sendLimit = isset($sendLimit) ? $sendLimit : 0;

							if(@$sendLimit > 0)
								{

									//1 second = 1000 mili secs

									if($sendLimit < 60)
										$sendLimit = 60;

									$sendLimit = 3600 / $sendLimit * 1000;

									if($sendLimit < 0)
										$sendLimit = 0;

								}

							// End Throttling -----------------------------------------

							if($mResult)
								{

									// record the current email as successful
									if($test == true)
										$dummy_var = 0;
									elseif($strSend == "failed")
										@mysql_query("UPDATE {$dbPrefix}_issuestatus SET isStatus = '1' WHERE isSubscribeId = '{$nRow[0]}' AND isNewsletterId = '$iId'");
									else
										@mysql_query("INSERT INTO {$dbPrefix}_issuestatus (isNewsletterId, isSubscribeId, isStatus) VALUES ('$iId', '{$nRow[0]}', 1)");

									?>



										var subject = escape(parent.document[0].all.subject.value);
										var fromEmail = escape(parent.document[0].all.fromEmail.value);
										var replyToEmail = escape(parent.document[0].all.replyToEmail.value);
										var iId = escape(parent.document[0].all.iId.value);
										var newsletterId = escape(parent.document[0].all.newsletterId.value);
										var currentPos = escape(parent.document[0].all.currentPos.value);
										var format = escape(parent.document[0].all.format.value);
										var track = escape(parent.document[0].all.track.value);
										var strSend = escape(parent.document[0].all.strSend.value);

										// Do we need to restart the list?
										if(currentPos % 50 == 0){
											parent.iStatus.document.body.innerHTML = '';}

										currentPos++;

									<?php  if($test == true) { ?>

										var numSent = parseInt(escape(parent.document[0].all.numSent.value));
										var numFailed = escape(parent.document[0].all.numFailed.value);
										var startTime = escape(parent.document[0].all.startTime.value);
										var iId = escape(parent.document[0].all.iId.value);
										var delArray = escape(parent.document[0].all.delArray.value);

										parent.iStatus.document.write('<img src=images/tick.gif> <font face=Verdana size=2 color=black>Sent to <?php echo $email; ?></font>\r\n');

										window.setTimeout("parent.document.location.href = 'sendissue.php?what=done&iId='+iId+'&success='+numSent+'&fail='+numFailed+'&start='+startTime+'&delArray='+delArray+'&test=true';", 1500);

									<?php } else { ?>

										parent.iStatus.document.write('<img src=images/tick.gif> <font face=Verdana size=2 color=black>Sent to <?php echo @$nRow[1]; ?></font><br>\r\n');
										window.setTimeout("document.location.href = 'sendit.php?mm=1&send=true&subject='+subject+'&fromEmail='+fromEmail+'&replyToEmail='+replyToEmail+'&iId='+iId+'&newsletterId='+newsletterId+'&marker='+currentPos+'&format='+format+'&track='+track+'&strSend='+strSend", <?php echo @$sendLimit; ?>);

										++parent.document.all.currentPos.value;
										++parent.document.frmSend.numSent.value;

									<?php } ?>



									<?php
								}
							else
								{

									// Sending to this subscriber failed

									if($strSend == "failed")
										{

											if(@$delfailed == '1')
												{

													//if the user has requested the email be deleted on the second attempt (failing on the failed list)

													$userId = $row[0];

													$del1 = @mysql_query("DELETE FROM {$dbPrefix}_subscribedusers WHERE pk_suId = '$userId'");

													$del2 = @mysql_query("DELETE FROM {$dbPrefix}_issuestatus WHERE and isSubscribeId = '$userId'");

													$del3 = @mysql_query("DELETE FROM {$dbPrefix}_subscriptions WHERE sSubscriberId = '$userId'");

													if($del1 && $del2 && del3)
														{

															?>

																var delArray = escape(parent.document[0].all.delArray.value);

																parent.document[0].all.delArray.value = delArray + '<?php echo $email; ?>,';

															<?php

														}

												}

										}
									elseif($test == false)
										@mysql_query("INSERT INTO {$dbPrefix}_issuestatus (isNewsletterId, isSubscribeId, isStatus) VALUES ('$iId', '{$nRow[0]}', '0')");

									?>

										var subject = escape(parent.document[0].all.subject.value);
										var fromEmail = escape(parent.document[0].all.fromEmail.value);
										var replyToEmail = escape(parent.document[0].all.replyToEmail.value);
										var iId = escape(parent.document[0].all.iId.value);
										var newsletterId = escape(parent.document[0].all.newsletterId.value);
										var currentPos = escape(parent.document[0].all.currentPos.value);
										var format = escape(parent.document[0].all.format.value);
										var track = escape(parent.document[0].all.track.value);
										var strSend = escape(parent.document[0].all.strSend.value);

										currentPos++;

									<?php if($test == true) { ?>

										var numSent = parseInt(escape(parent.document[0].all.numSent.value));
										var numFailed = escape(parent.document[0].all.numFailed.value);
										var startTime = escape(parent.document[0].all.startTime.value);
										var iId = escape(parent.document[0].all.iId.value);
										var delArray = escape(parent.document[0].all.delArray.value);

										parent.iStatus.document.write('<img src=images/cross.gif> <font face=Verdana size=2 color=red>Failed to <?php echo $email; ?><br><br>Please check your configuration and try again.');

										window.setTimeout("parent.location.href = 'sendissue.php?what=done&iId='+iId+'&success='+numSent+'&fail='+numFailed+'&start='+startTime+'&delArray='+delArray+'&test=true'", 1500);

									<?php } else { ?>

										parent.iStatus.document.write('<img src=images/cross.gif> <font face=Verdana size=2 color=red>Failed to <?php echo $nRow[1]; ?></font><br>');
										window.setTimeout("document.location.href = 'sendit.php?send=true&subject='+subject+'&fromEmail='+fromEmail+'&replyToEmail='+replyToEmail+'&iId='+iId+'&newsletterId='+newsletterId+'&marker='+currentPos+'&format='+format+'&track='+track+'&strSend='+strSend", <?php echo $sendLimit; ?>);

										++parent.document.all.currentPos.value;
										++parent.document.frmSend.numFailed.value;

									<?php } ?>

									<?php

								}

							// Scroll to the bottom of the frame

							?>

								parent.iStatus.scrollTo(0, 100000);
								parent.iNum.document.body.innerHTML = '';
								parent.iNum.document.write('<body leftmargin=0><img src=images/arrow.gif> <font face=verdana size=2 color=black><b>Sending copy ' + currentPos + ' of <?php if($test == true) echo "1"; else echo "'+parent.document[0].all.numSubs.value+'"; ?></b></font></body>');

							<?php

						}
					else
						{

							// All newsletters have been sent - there are no more subscribers on the list

							?>

								var numSent = parseInt(escape(parent.document[0].all.numSent.value));
								var numFailed = escape(parent.document[0].all.numFailed.value);
								var startTime = escape(parent.document[0].all.startTime.value);
								var iId = escape(parent.document[0].all.iId.value);
								var delArray = escape(parent.document[0].all.delArray.value);

								parent.location.href = 'sendissue.php?what=done&iId='+iId+'&success='+numSent+'&fail='+numFailed+'&start='+startTime+'&delArray='+delArray;

							<?php

						}

				}
			else
				{

					// Couldn't get the newsletter content

				}

		}

	echo "</script></head></html>";

?>