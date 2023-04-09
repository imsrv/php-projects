<?php

	include("templates/top.php");
	include_once("includes/functions.php");

	if(!in_array("stats_view", $authLevel))
		{

			noAccess();
			exit;

		}

	// Connect to the database and get a tally of subscribers, etc
	doDbConnect();
	
	$numSubs = mysql_result(mysql_query("SELECT count(pk_suId) FROM {$dbPrefix}_subscribedusers"), 0, 0);
	$totalNumSubs = number_format($numSubs, 0);

	MakeMsgPage('MailWorksPro Statistics', 'The statistics shown below include how many subscribers are on your list, which	newsletters they are subscribed to, how many subscribers joined today, in the last week and in the last month, etc.', 0);

	?>

			<tr>

				<td>

					<form name="frmTopic" action="topic.php" method="post">

					<input type="hidden" name="what" value="doNew">

					<table width="95%" align="center" border="0">

						<tr>

							<td valign="top">

								<span class="BodyText">

									<br>

									<b>Total Number Of Subscribers:</b> <?php echo $totalNumSubs; ?>

									<br><br>

									<b>Subscriber Count By Newsletter:</b>

									<br>

									<?php

										$result = @mysql_query("SELECT * FROM {$dbPrefix}_topics ORDER BY tName ASC");

										$i = 0;

										while($row = @mysql_fetch_row($result))
											{

												$nResult = @mysql_query("SELECT pk_nId, nName, nTrack FROM {$dbPrefix}_newsletters WHERE nTopicId = " . $row[0]);

												if(@mysql_num_rows($nResult) > 0)
													{

														$i++;

														echo "<br>&nbsp;&nbsp;&nbsp;<b><i><font color='#183863'><img src='images/arrow.gif'> " . $row[1] . "</font></i></b><br><br>";

														while($nRow = @mysql_fetch_row($nResult))

															{

																$track = $nRow[2];

																$numSubs = @mysql_result(mysql_query("SELECT count(pk_sId) FROM {$dbPrefix}_subscriptions WHERE sNewsletterId = " . $nRow[0]), 0, 0);

																?>

																	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

																	<?php echo "<strong>" . $nRow[1] . ":</strong> " . number_format($numSubs, 0); ?>

																	<?php 

																		$iQuery = @mysql_query("select iName, pk_iId from {$dbPrefix}_issues where iNewsletterId = {$nRow[0]}");

																		while($iRow = @mysql_fetch_array($iQuery))
																			{

																				if($track == '1')
																					{

																						echo $c = (!isset($c)) ? "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tracking</strong>" : "";

																						echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$iRow[0]}: ";

																						$tResult = @mysql_query("SELECT count(*) FROM {$dbPrefix}_track WHERE tIId = '{$iRow[1]}'");

																						$qResult = @mysql_query("SELECT count(*) FROM {$dbPrefix}_issuestatus WHERE isNewsletterId = '{$iRow[1]}'"); 

																						echo @mysql_result($tResult, 0, 0) . '/' . mysql_result($qResult, 0, 0) . ' Total Views';

																					}

																			}

																		unset($c);

																	?>

																	<br>

																<?php

															}

													}

											}

										if($i == 0)
											echo '<br>&nbsp;&nbsp;&nbsp;[No newsletters exist]<br>';

									?>

									<br><b>Subscriber Count By Date Joined:</b>

									<br><br>

									<?php

										$year = date("Y");
										$month = date("m");
										$day = date("d");
										$yestdate = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
										$yestyear = date("Y", $yestdate);
										$yestmonth = date("m", $yestdate);
										$yestday = date("d", $yestdate);



										$weekdate = mktime(0, 0, 0, date("m"), date("d") - (date("w")), date("Y"));

										$newToday 	= number_format(@mysql_result(mysql_query("SELECT count(suDateSubscribed) FROM {$dbPrefix}_subscribedusers WHERE LEFT(suDateSubscribed, 4) = '$year' AND mid(suDateSubscribed, 5, 2) = '$month' AND mid(suDateSubscribed, 7, 2) = '$day'"), 0, 0));
										$newYest 	= number_format(@mysql_result(mysql_query("SELECT count(suDateSubscribed) FROM {$dbPrefix}_subscribedusers WHERE LEFT(suDateSubscribed, 4) = '$yestyear' AND mid(suDateSubscribed, 5, 2) = '$yestmonth' AND mid(suDateSubscribed, 7, 2) = '$yestday'"), 0, 0));
										$newWeek 	= number_format(@mysql_result(mysql_query("SELECT count(suDateSubscribed) FROM {$dbPrefix}_subscribedusers WHERE suDateSubscribed > $weekdate"), 0, 0));
										$newMonth 	= number_format(@mysql_result(mysql_query("SELECT count(suDateSubscribed) FROM {$dbPrefix}_subscribedusers WHERE LEFT(suDateSubscribed, 4) = '$year' AND mid(suDateSubscribed, 5, 2) = '$month'"), 0, 0));
										$newYear	= number_format(@mysql_result(mysql_query("SELECT count(suDateSubscribed) FROM {$dbPrefix}_subscribedusers WHERE LEFT(suDateSubscribed, 4) = '$year'"), 0, 0));

										// Get subscriber counts by date joined

										echo "&nbsp;&nbsp;&nbsp;New Subscribers Today: $newToday <br>";
										echo "&nbsp;&nbsp;&nbsp;New Subscribers Yesterday: $newYest <br>";
										echo "&nbsp;&nbsp;&nbsp;New Subscribers This Week: $newWeek <br>";
										echo "&nbsp;&nbsp;&nbsp;New Subscribers This Month: $newMonth <br>";
										echo "&nbsp;&nbsp;&nbsp;New Subscribers This Year: $newYear <br>";

									?>

									<br><b>Subscriber Count By Email Domain:</b>

									<br><br>

									<?php

										// Get the number of users for each domain

										$com = @mysql_result(mysql_query("SELECT count(suEmail) FROM {$dbPrefix}_subscribedusers WHERE right(suEmail, 4) = '.com'"), 0, 0);
										$net = @mysql_result(mysql_query("SELECT count(suEmail) FROM {$dbPrefix}_subscribedusers WHERE right(suEmail, 4) = '.net'"), 0, 0);
										$org = @mysql_result(mysql_query("SELECT count(suEmail) FROM {$dbPrefix}_subscribedusers WHERE right(suEmail, 4) = '.org'"), 0, 0);
										$couk = @mysql_result(mysql_query("SELECT count(suEmail) FROM {$dbPrefix}_subscribedusers WHERE right(suEmail, 6) = '.co.uk'"), 0, 0);
										$comau = @mysql_result(mysql_query("SELECT count(suEmail) FROM {$dbPrefix}_subscribedusers WHERE right(suEmail, 7) = '.com.au'"), 0, 0);
										$total = @mysql_result(mysql_query("SELECT count(suEmail) FROM {$dbPrefix}_subscribedusers"), 0, 0);

										$numCOM = number_format($com);
										$numNET= number_format($net);
										$numORG = number_format($org);
										$numCOUK = number_format($couk);
										$numCOMAU = number_format($comau);
										$numMisc = number_format($total - ($com + $net + $org + $couk + $comau));

										if($numMisc < 0)
											$numMisc = 0;

										// Show the subscriber counts via email domain

										echo "&nbsp;&nbsp;&nbsp;Subscribers From .COM Host (ex: john@yourdomain.com): $numCOM <br>";
										echo "&nbsp;&nbsp;&nbsp;Subscribers From .NET Host (ex: john@yourdomain.net): $numNET <br>";
										echo "&nbsp;&nbsp;&nbsp;Subscribers From .ORG Host (ex: john@yourdomain.org): $numORG <br>";
										echo "&nbsp;&nbsp;&nbsp;Subscribers From .CO.UK Host (ex: john@yourdomain.co.uk): $numCOUK <br>";
										echo "&nbsp;&nbsp;&nbsp;Subscribers From .COM.AU Host (ex: john@yourdomain.com.au): $numCOMAU <br>";
										echo "&nbsp;&nbsp;&nbsp;Subscribers From Other Hosts: $numMisc <br>";

									?>

								</span>

							</td>

						</tr>

					</table>

					</form>

				</td>

			</tr>

		</table>

<?php include("templates/bottom.php"); ?>