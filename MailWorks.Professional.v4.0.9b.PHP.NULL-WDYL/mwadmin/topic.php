<?php

	include("templates/top.php");
	include_once("includes/functions.php");

	$what = @$_POST["what"];

	if($what == "")
		$what = @$_GET["what"];

	switch($what)
		{

			case "new":
				if(in_array("topics_add", $authLevel))
					ShowNewForm();
				else
					noAccess();
				break;

			case "doNew":
				if(in_array("topics_add", $authLevel))
					ProcessNew();
				else
					noAccess();
				break;

			case "delete":
				if(in_array("topics_delete", $authLevel))
					DeleteTopics();
				else
					noAccess();
				break;

			case "modify":
				if(in_array("topics_edit", $authLevel))
					ModifyTopic();
				else
					noAccess();
				break;

			case "doModify":
				if(in_array("topics_edit", $authLevel))
					ProcessModify();
				else
					noAccess();
				break;

			default:
				if(in_array("topics_view", $authLevel))
					ShowTopicList();
				else
					noAccess();
				break;

		}

	function ShowNewForm()
		{

			// Show the form to get the name of a new topic

			$content = "Please complete the form below to create a new topic. Once created, you can select this topic for new/current newsletters.";

			MakeMsgPage("Create New Topic", $content, 0);

			?>

				<tr>

					<td>

						<form name="frmTopic" action="topic.php" method="post">
						<input type="hidden" name="what" value="doNew">

						<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

							<tr>

								<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

									Topic Details

								</td>

							</tr>

					<tr>

						<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

						<td width="25%" class="BodyText" valign="middle">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<strong>Title</strong><br>

							</p>

						</td>

						<td width="75%">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<input type="text" name="topic" size="40">

							</p>

						</td>

						<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

					</tr>

					<tr>

						<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="1" valign="middle">

						</td>

					</tr>

					<tr>

						<td colspan="4">										

							<br>

							<input type="button" value="� Cancel" onClick="ConfirmCancel('topic.php')">
							<input type="submit" name="submit" value="Add Topic �">

						</td>

					</tr>

				</table>

				</form>

				</td>

			</tr>

		</table>

			<?php

		}

	function ProcessNew()
		{

			// Make sure all fields are completed

			global $dbPrefix;

			$topic = @$_POST["topic"];
			$err = "";

			// Has the user entered all of the required fields?
			if($topic == "")
				$err .= "<li>You forgot to enter a topic</li>";
	
			if($err != "")
				MakeMsgPage("Create Topic", "The form that you've just submitted is incomplete. Please review the errors below and then go back and correct them: <ul>$err</ul><a href=\"javascript:history.go(-1)\"><< Go Back</a>");
			else
				{

					// All of the fields were complete, save this newsletter to the database

					$query = "INSERT INTO {$dbPrefix}_topics VALUES (0, '$topic')";

					doDbConnect();

					if(@mysql_query($query))
						MakeMsgPage("Create Topic", "You have successfully created and saved a topic. You can now add new/current newsletters under this topic.<br><br><a href=\"topic.php\">Continue</a>");

				}

		}

	function ShowTopicList()
		{

			// Show a list of templates currently in the database

			global $dbPrefix;

			doDbConnect();

			$result = mysql_query("SELECT * FROM {$dbPrefix}_topics ORDER BY tName ASC");

			?>

				<script language="JavaScript">

					function CheckConfirmDelete()			
						{

							if(confirm('WARNING: You are about to permanently delete the selected topics. All newsletters and issues that are under this topic will also be deleted. Click OK to continue.'))
								return true;
							else
								return false;

						}

				</script>

				<form onSubmit="return CheckConfirmDelete()" action="topic.php" method="post">

				<input type="hidden" name="what" value="delete">

				<?php MakeMsgPage("Topics", 'A list of existing topics is shown below. To add a new topic, click the "Add Topic" link. To remove one/more topics, click the checkbox for that topic and then click the "Delete Selected" button.'); ?>

				<table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">

					<tr>

						<td width="100%" colspan="5" height="35" class="Info">

							<a href="topic.php?what=new"> Add Topic �</a>

						</td>

					</tr>

					<tr>

						<td width="100%" colspan="5" height="18" class="Info" align="right">

							Current Topics: <?php echo mysql_num_rows($result); ?>

						</td>

					</tr>

					<tr bgcolor="#787C9B">

						<td width="1" bgcolor="#787C9B"><img border="0" width="0" height="0" src="images/blank.gif"></td>

						<td height="20" class="MenuHeading">&nbsp;</td>

						<td height="20" class="MenuHeading">

							Topic Name

						</td>

						<td height="20" class="MenuHeading">

							Number Of Dependants

						</td>

						<td width="1" bgcolor="#787C9B"><img border="0" width="0" height="0" src="images/blank.gif"></td>

					</tr>

				<?php

				if(mysql_num_rows($result) == 0)
					{

						?>

							<tr>

								<td width="1" bgcolor="#787C9B"><img border="0" width="0" height="0" src="images/blank.gif"></td>

								<td colspan="3" width="100%" height="25" class="Info">

									There are no topics in the database.

								</td>

								<td width="1" bgcolor="#787C9B"><img border="0" width="0" height="0" src="images/blank.gif"></td>

							</tr>

						<?php

					}

				while($row = mysql_fetch_row($result))
					{

						$bgColor = (@$bgColor == "#FFFFFF") ? "#E7E8F5" : "#FFFFFF";

						?>

							<tr bgcolor="<?php echo $bgColor; ?>">

								<td width="1" bgcolor="#787C9B"><img border="0" width="0" height="0" src="images/blank.gif"></td>

								<td width="10%" height="20" class="TableCell">

									<input type="checkbox" name="tId[]" value="<?php echo $row[0]; ?>">

								</td>

								<td width="40%" height="20" class="TableCell">

									<a href="topic.php?what=modify&tId=<?php echo $row[0]; ?>"><?php echo $row[1]; ?></a>

								</td>

								<td width="50%" height="20" class="TableCell">

									<?php

										// Workout how many templates and newsletters are dependant on this topic

										$numNewsletters = 0;

										$numIssues = 0;

										$tResult = mysql_query("SELECT pk_nId FROM {$dbPrefix}_newsletters WHERE nTopicId = " . $row[0]);

										$numNewsletters = mysql_num_rows($tResult);

										while($tRow = mysql_fetch_row($tResult))
											{

												$cResult = mysql_query("SELECT count(*) FROM {$dbPrefix}_issues WHERE iNewsletterId = " . $tRow[0]);
												$numIssues += mysql_result($cResult, 0, 0);

											}

										echo "$numNewsletters newsletter(s) and $numIssues newsletter issue(s)";

									?>

								</td>

								<td width="1" bgcolor="#787C9B"><img border="0" width="0" height="0" src="images/blank.gif"></td>

							</tr>

						<?php

					}

				?>

					<tr>

						<td colspan="5" bgcolor="#787C9B" height="1"></td>

					</tr>

					<tr>

						<td width="100%" colspan="5">

							<br>

							<input type="submit" value="Delete Selected �">

						</td>

					</tr>

				</table>

				</form>

			<?php

		}

	function DeleteTopics()
		{

			// This function will remove the selected topics from the database

			global $dbPrefix;

			doDbConnect();

			$tId = @$_POST["tId"];
			$query = "";
			$result1 = "";
			$result2 = "";
			$result3 = "";

			if(is_array($tId) == true)
				{

					// Topics have been chosen, run 2 delete queries
					// Topics have been removed, now get the newsletter id

					$result = @mysql_query("SELECT pk_nId FROM {$dbPrefix}_newsletters WHERE nTopic = " . implode(" OR nTopicId = ", $tId));

					while($row = @mysql_fetch_row($result))
						{

							// Delete issues that reference this newsletter

							$iQuery = mysql_query("SELECT pk_iId FROM {$dbPrefix}_issues WHERE iNewsletterId = " . $row[0]);

							while($iRow = mysql_fetch_array($iQuery))
								{

									@mysql_query("DELETE FROM {$dbPrefix}_issuestatus WHERE isNewsletterId = {$iRow[0]}");
									@mysql_query("DELETE FROM {$dbPrefix}_track WHERE tIId = {$iRow[0]}");

								}

							@mysql_query("DELETE FROM {$dbPrefix}_subsriptions WHERE sNewsletterId = " . $row[0]);

							@mysql_query("DELETE FROM {$dbPrefix}_issues WHERE iNewsletterId = " . $row[0]);

						}

					// Finally, delete the templates

					$result1 = mysql_query("DELETE FROM {$dbPrefix}_topics WHERE pk_tId = " . implode(" OR pk_tId = ", $tId));

					$result2 = @mysql_query("DELETE FROM {$dbPrefix}_newsletters WHERE nTopicId = "  . implode(" OR nTopicId = ", $tId));

					if($result1 && $result2)
						{

							// Query executed OK

							$status = "You have successfully deleted one/more topics from the database, as well as any templates / newsletters that relied on these topics.<br><br>";
							$status .= "<a href='topic.php'>Continue >></a>";

						}
					else
						{

							// Delete querie(s) failed

							$status = "An error occured while trying to delete the selected topic(s).<br><br>";
							$status .= "<a href='javascript:document.location.reload()'>Try Again</a>";

						}

				}
			else
				{

					// No newsletters have been chosen

					$status = "You didn't select one/more topics to delete.<br><br>";
					$status .= "<a href='javascript:history.go(-1)'>Try Again</a>";

				}

			MakeMsgPage('Delete Topic(s)', $status);

		}

	function ModifyTopic()
		{

			// Change the details of a template

			global $dbPrefix;

			doDbConnect();

			$tId = @$_GET["tId"];

			$result = mysql_query("SELECT * FROM {$dbPrefix}_topics WHERE pk_tId = $tId");

			if($row = mysql_fetch_array($result))
				{

					MakeMsgPage('Modify Topic', 'Please complete the form below to modify the selected topic. Click on the "Update Topic" button to update this topic.', 0);

					?>

							<tr>

								<td>

									<form action="topic.php" method="post">
									<input type="hidden" name="what" value="doModify">
									<input type="hidden" name="tId" value="<?php echo $tId; ?>">

									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

										<tr>

											<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												Topic Details

											</td>

										</tr>

								<tr>

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="middle">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong>Title</strong><br>

										</p>

									</td>

									<td width="75%">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<input type="text" name="tName" size="40" value="<?php echo str_replace("\"", "'", $row["tName"]); ?>">

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr>

									<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="1" valign="middle"></td>

								</tr>

								<tr>

									<td colspan="4">


										<br>

										<input type="button" value="� Cancel" onClick="ConfirmCancel('topic.php')">

										<input type="submit" name="submit" value="Update Topic �">

									</td>

								</tr>

							</table>

							</form>

						</td>

						</tr>

						</table>

					<?php
				}
			else
				MakeMsgPage('Invalid Topic Selected', 'The topic that you have selected is either invalid or has been deleted from the database. <br><br><a href="topic.php">Continue >></a>');

		}

	function ProcessModify()
		{

			// Grab the details for the newsletter from the form, create the new
			// topic if necessary and workout whether to show a textbox or EWP control

			global $dbPrefix;

			$tId = @$_POST["tId"];
			$tName = @$_POST["tName"];

			// Make sure all of the required form variables are complete
			$err = "";

			if($tName == "")
				$err .= "<li>You forgot to enter the topic</li>";

			doDbConnect();

			if($err != "")
				MakeMsgPage('Modify Topic', 'The form that you\'ve just submitted is incomplete. Please review the errors below and then go back and correct them: <ul>$err</ul><a href="javascript:history.go(-1)"><< Go Back</a>');
			else
				{

					$query = "UPDATE {$dbPrefix}_topics SET tName='$tName' WHERE pk_tId=$tId";

					$result = @mysql_query($query);

					$status = "";

					if($result)
						{

							$status = "Your topic has been successfully modified.<br><br>";
							$status .= "<a href='topic.php'>Continue >></a>";

						}
					else
						{

							$status = "Some errors occured while trying to modify this template.<br><br>";
							$status .= "<a href='javascript:history.go(-1)'><< Go Back</a>";

						}

					MakeMsgPage('Modify Topic', $status);

				}

		}

	include("templates/bottom.php"); 

?>