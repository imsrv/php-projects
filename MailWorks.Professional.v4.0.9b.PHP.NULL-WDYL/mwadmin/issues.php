<?php

	ob_start();

	include("templates/top.php");
	include_once("includes/functions.php");


	$what = @$_POST["what"];

	if($what == "")
		$what = @$_GET["what"];

	switch($what)
		{

			//normal newsletter

			case "new":

				if(in_array("issues_add", $authLevel))
					ShowNewForm();
				else
					noAccess();
				break;

			case "doNew":

				if(in_array("issues_add", $authLevel))
					ProcessNew();
				else
					noAccess();
				break;

			case "delete":

				if(in_array("issues_delete", $authLevel))
					DeleteIssue();
				else
					noAccess();
				break;

			case "modify":

				if(in_array("issues_edit", $authLevel))
					ModifyIssue();
				else
					noAccess();
				break;

			case "doModify":

				if(in_array("issues_edit", $authLevel))
					ProcessModify();
				else
					noAccess();
				break;

			//import newsletter

			case "import":

				if(in_array("issues_import", $authLevel))
					ShowImport();
				else
					noAccess();
				break;

			case "doDeleteFile";

				if(in_array("issues_import", $authLevel))
					DeleteImport();
				else
					noAccess();
				break;

			case "doImportFile";

				if(in_array("issues_import", $authLevel))
					ImportFile();
				else
					noAccess();
				break;

			case "newImport";

				if(in_array("issues_import", $authLevel))
					ShowNewImport();
				else
					noAccess();
				break;

			case "editImport";

				if(in_array("issues_import", $authLevel))
					ShowEditImport();
				else
					noAccess();
				break;

			case "doEditImport";

				if(in_array("issues_import", $authLevel))
					ProcessEditImport();
				else
					noAccess();
				break;

			case "doNewImport";

				if(in_array("issues_import", $authLevel))
					ProcessNewImport();
				else
					noAccess();
				break;

			//show newsletter list

			default:

				if(in_array("issues_view", $authLevel))
					ShowIssueList();
				else
					noAccess();
				break;

		}

	function ProcessEditImport()
		{

			// Make sure all fields are completed

			global $dbPrefix;

			$iId = @$_POST["iId"];
			$name = @$_POST["name"];
			$subject = @$_POST["subject"];
			$newsletterId = @$_POST["newsletterId"];
			$file = @$_POST['file'];

			$err = "";

			// Has the user entered all of the required fields?

			if($name == "")
				$err .= "<li>You forgot to enter a name for this issue</li>";

			if($subject == "")
				$err .= "<li>You forgot to enter a subject line for this issue</li>";

			if($newsletterId == -1)
				$err .= "<li>You forgot to select a newsletter for this issue</li>";

			if($file == "")
				$err .= "<li>A valid File was not selected for this issue</li>";

			if($err != "")
				MakeMsgPage('Create User', "The form that you've just submitted is incomplete. Please review the errors below and then go back and correct them: <ul>$err</ul><a href=\"javascript:history.go(-1)\"><< Go Back</a>");
			else
				{

					// All of the fields were complete, save this newsletter to the database

					$query = "UPDATE {$dbPrefix}_issues SET iName = '$name', iTitle = '$subject', iNewsletterId = '$newsletterId' WHERE pk_iId = '$iId'";

					doDbConnect();

					if(@mysql_query($query))
						MakeMsgPage('Edit Issue', 'Your issue has been successfully modified.<br><br><a href="sendissue.php">Send Issue</a> | <a href="issues.php?what=import">Continue</a>');
					else
						MakeMsgPage('Edit Issue', 'There was an internal error with MailWorks Professional<br><br><a href="sendissue.php">Send Issue</a> | <a href="issues.php?what=import">Continue</a>');
				}

		}


	function ShowEditImport()
		{

			//firstly check if the supplief file exists

			global $dbPrefix;

			$iId = @$_GET['iId'];

			$result = mysql_query("SELECT * FROM {$dbPrefix}_issues WHERE pk_iId = '$iId'");

			if($row = mysql_fetch_array($result))
				{

					$newsletterId = $row["iNewsletterId"];
					$name = $row["iName"];
					$subject = $row["iTitle"];
					$file = $row["iFile"];



					if(@fopen("issues/".$file, 'r'))
						{

							//file exists

							?>

								<script language="JavaScript">

									function toggleP()
										{

											if(document.all.pMenu.style.display == 'inline')
												{

													document.all.pMenu.style.display = 'none';

													document.all.pText.innerHTML = 'Personalization Tags »';

												}
											else
												{

													document.all.pMenu.style.display = 'inline';

													document.all.pText.innerHTML = '« Personalization Tags';

												}

										}

								</script>

								<?php MakeMsgPage('Create Issue', 'Please complete the form below to create a new issue. Once created, this issue will be saved and you will have the option to send it to your subscriber list.', 0); ?>

									<tr>

										<td>

											<form name="frmIssue" action="issues.php" method="post">
											<input type="hidden" name="what" value="doEditImport">
											<input type="hidden" name="file" value="<?php echo $file; ?>">
											<input type="hidden" name="iId" value="<?php echo $iId; ?>">

											<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

												<tr>

													<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

														User Details

													</td>

												</tr>

												<tr>

													<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													<td width="25%" class="BodyText" valign="middle">

														<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

															<strong>Issue Name</strong><br>

														</p>

													</td>

													<td width="75%">

														<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

															<input type="text" name="name" size="40" value="<?php echo $name; ?>">

														</p>

													</td>

													<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												</tr>

												<tr bgcolor="#E7E8F5">

													<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													<td width="25%" class="BodyText" valign="middle">

														<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

															<strong>Subject Line</strong><br>

														</p>

													</td>

													<td width="75%">

														<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

															<input type="text" name="subject" size="40" value="<?php echo $subject ?>">

														</p>

													</td>

													<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												</tr>

												<tr>

													<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													<td width="25%" class="BodyText" valign="middle">

														<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

															<strong>Issue Template</strong><br>

														</p>

													</td>

													<td width="75%">

														<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

															<select name="newsletterId" style="width: 196pt">

																<?php GetTemplateList(-2, $newsletterId, false, true); ?>

															</select>

														</p>

													</td>

													<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												</tr>

												<tr bgcolor="#E7E8F5">

													<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													<td width="25%" class="BodyText" valign="middle">

														<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

															<strong>Style Sheets</strong><br>

														</p>

													</td>

													<td width="75%" class="BodyText">

														<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

															<em>Style Sheets will be provided by the selected imported file</em>

														</p>

													</td>

													<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												</tr>

												<tr>

													<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													<td width="25%" class="BodyText" valign="middle">

														<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

															<strong>Preview</strong><br>

															<a href="issues/<?php echo $file; ?>" target="_blank">Full Page</a>

														</p>

													</td>

													<td width="75%">

														<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

															<iframe frameborder="1" height="300" width="98%" scrolling="auto" src="issues/<?php echo $file; ?>"></iframe>

														</p>

													</td>

													<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												</tr>

												<tr>

													<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="1" valign="middle"></td>

												</tr>

												<tr>

													<td valign="top" colspan="4">

														<br>

														<input type="submit" value="Edit Issue &raquo;">

													</td>

												</tr>

											</table>

										</td>

									</tr>

								</table>

							<?php

						}
					else
						MakeMsgPage('Create Issue', 'The file specified for this issue does not exist, or can not be loaded. Please ensure that the \'issues\' folder has the correct permissions.<br><br><a href="javascript: history.go(-1);">Return</a>');

				}

		}


	function ProcessNewImport()
		{

			// Make sure all fields are completed

			global $dbPrefix;

			$name = @$_POST["name"];
			$subject = @$_POST["subject"];
			$newsletterId = @$_POST["newsletterId"];
			$file = @$_POST['file'];

			$err = "";

			// Has the user entered all of the required fields?

			if($name == "")
				$err .= "<li>You forgot to enter a name for this issue</li>";

			if($subject == "")
				$err .= "<li>You forgot to enter a subject line for this issue</li>";

			if($newsletterId == -1)
				$err .= "<li>You forgot to select a newsletter for this issue</li>";

			if($file == "")
				$err .= "<li>A valid File was not selected for this issue</li>";

			if($err != "")
				MakeMsgPage('Create An Issue', "The form that you've just submitted is incomplete. Please review the errors below and then go back and correct them: <ul>$err</ul><a href=\"javascript:history.go(-1)\"><< Go Back</a>");
			else
				{

					// All of the fields were complete, save this newsletter to the database

					$query = "INSERT INTO {$dbPrefix}_issues (iName, iTitle, iNewsletterId, iStatus, iFile) ";
					$query .= "VALUES ('$name', '$subject', '$newsletterId', 'pending', '$file')";

					doDbConnect();

					if(@mysql_query($query))
						MakeMsgPage('Create A Newsletter Issue', 'You have successfully created and saved a issue. To send this issue to your subscriber list now, click on the "Send Issue" link below.<br><br><a href="sendissue.php">Send Issue</a> | <a href="issues.php?what=import">Continue</a>');

				}

		}

	function ShowNewImport()
		{

			$file = @$_GET['file'];

			//firstly check if the supplief file exists

			if(@fopen("issues/".$file, 'r'))
				{

					//file exists

					?>

						<script language="JavaScript">

							function toggleP()
								{

									if(document.all.pMenu.style.display == 'inline')
										{

											document.all.pMenu.style.display = 'none';

											document.all.pText.innerHTML = 'Personalization Tags »';

										}
									else
										{

											document.all.pMenu.style.display = 'inline';

											document.all.pText.innerHTML = '« Personalization Tags';

										}

								}

						</script>

						<?php

							$content  = "Please complete the form below to create a new issue. Once created, this issue will be saved ";
							$content .= "and you will have the option to send it to your subscriber list.";
							$content .= "<br><br><a style=\"cursor:hand\" onClick=\"toggleP()\"><u><span id=\"pText\">Personalization Tags »</span></u></a>";
							$content .= "<br><br>";

							$content .= "<table style=\"display:none\" width=\"95%\" align=\"center\" id=\"pMenu\"><tr><td><span class=\"Info\">";
							$content .= "It's easy to add a subscribers first name, last name, complete name or email address to your newsletter. Simply type in one or more of the personalization tags shown below and they will be replaced with the appropriate values when the newsletter is sent.";
							$content .= "<br><br>For example: to greet your subscribers by their first name, type <font color=\"red\">Hi %%first_name%%</font>.";
							$content .= "<ul><li><i>%%email%%</i> The users email address</li>" . ShowPerTags(1, 1) . "</ul>";
							$content .= "<strong>Note:</strong> You may place \"Personalization Tags\" in the Issue Content (Imported html file) and Subject Line</span></td></tr>";
							$content .= "</table>";

							MakeMsgPage('Create A Newsletter Issue', $content, 0);

						?>

							<tr>

								<td>

									<form name="frmIssue" action="issues.php" method="post">
									<input type="hidden" name="what" value="doNewImport">
									<input type="hidden" name="file" value="<?php echo $file; ?>">

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

													<strong>Issue Name</strong><br>

												</p>

											</td>

											<td width="75%">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<input type="text" name="name" size="40" value="">

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr bgcolor="#E7E8F5">

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Subject Line</strong><br>

												</p>

											</td>

											<td width="75%">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<input type="text" name="subject" size="40" value="">

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr>

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Newsletter</strong><br>

												</p>

											</td>

											<td width="75%">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<select name="newsletterId" style="width: 196pt">

														<?php GetTemplateList('','',true,true); ?>

													</select>

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr bgcolor="#E7E8F5">

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Style Sheets</strong><br>

												</p>

											</td>

											<td width="75%" class="BodyText">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<em>Style Sheets and Content will be provided by your selected imported file</em>

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr>

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Preview</strong><br>

													<a href="issues/<?php echo $file; ?>" target="_blank">Full Page</a>

												</p>

											</td>

											<td width="75%">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<iframe frameborder="1" height="300" width="98%" scrolling="auto" src="issues/<?php echo $file; ?>"></iframe>

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr>

											<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="1" valign="middle"></td>

										</tr>

										<tr>

											<td valign="top" colspan="4">

												<span class="BodyText">

													<br>

													<input type="button" value="« Cancel" onClick="ConfirmCancel('issues.php?what=import')">

													<input type="submit" value="Add Issue &raquo;">

												</span>

											</td>

										</tr>

									</table>

								</td>

							</tr>

						</table>

					<?php

				}
			else
				MakeMsgPage('Create A Newsletter Issue', 'The file specified for this issue does not exist, or can not be loaded. Please ensure that the \'issues\' folder has the correct permissions.<br><br><a href="javascript: history.go(-1);">Return</a>');


		}

	function ImportFile()
		{

			$fileTypes = array(".htm",".html");

			$file = @$_FILES['strFile'];

			$file['error'];

			if($file['error'] == 0)
				{

					//check file type

					foreach($fileTypes as $key=>$value)
						{

							$size = strlen($value);

							$ext = substr($file['name'], -$size);

							if($ext == $value)
								$pass = true;

						}

					if(@$pass)
						{

							$upload = copy($file['tmp_name'], "issues/" . $file['name']);

							if($upload)
								{

									chmod("issues/" . $file['name'], 0757);

									header("Location: issues.php?what=import");

								}
							else
								MakeMsgPage('Imported Issue', 'The file that you specified was unable to be uploaded. Please ensure that your server has the correct settings to allow for file uploading. Also please ensure that the directory issues (/mwadmin/issues) has the correct persmissions.<br><br><a href="javascript: history.go(-1);">Continue</a>');


						}
					else
						MakeMsgPage('Imported Issues', 'Sorry but the file you have selected is not a HTML (htm & html) file. Please return to the previous page and select a valid file type.<br><br><a href="javascript: history.go(-1);">Back</a>');

				}
			else
				MakeMsgPage('Imported Issue', 'Please ensure that you have selected a file for uploading. Please return to the previous page and select a file to upload.<br><br><a href="javascript: history.go(-1);">Continue</a>');


		}

	function DeleteImport()
		{

			// This function will remove the selected newsletters from the database

			global $dbPrefix;

			doDbConnect();

			$fId = @$_POST["fileDel"];

			$query = "";

			$result = "";

			$i = 0;

			if(is_array($fId) == true)
				{

					// Templates have been chosen, run 2 delete queries

					foreach($fId as $key=>$value)
						{

							$delete = @unlink("issues/$value");

							$issueId = mysql_result(mysql_query("select pk_iId from {$dbPrefix}_issues where iFile = '$value'"), 0, 0);

							$query1 = mysql_query("delete from {$dbPrefix}_issues where iFile = '$value'");

							$query2 = mysql_query("delete from {$dbPrefix}_issuestatus where isNewsletterId = '$issueId'");

							$query3 = mysql_query("delete from {$dbPrefix}_track where tIId = '$issueId'");

							if($delete && $query1 && $query2 && $query3)
								$i++;

						}

					if(sizeof($fId) == $i)
						{

							// Query executed OK

							$status = "You have successfully delete one/more imported issues from the database.<br><br>";

							$status .= "<a href='issues.php?what=import'>Continue</a>";

						}
					else
						{

							// Delete querie(s) failed

							$status = "An error occured while trying to delete the selected imported issue(s). You may not have permission to delete the selected files.<br><br>";

							$status .= "<a href='javascript:document.location.reload()'>Try Again</a>";

						}

				}
			else
				{

					// No newsletters have been chosen

					$status = "You didn't select one/more imported issues to delete.<br><br>";

					$status .= "<a href='javascript:history.go(-1)'>Try Again</a>";

				}

			MakeMsgPage('Delete Imported Issue(s)', $status);

		}


	function ShowImport()
		{

			global $dbPrefix;

			$fileTypes = array(".htm",".html");

			doDbConnect();

			?>

				<script language="JavaScript">

					function confirmOver()
						{

							 if(confirm('Uploading a html file will overwrite any files with the same name. Do you wish to continue?'))
							 	return true
							else
								return false

						}

					function confirmDel()
						{

							if(confirm('This will permently DELETE any selected files and any issues affiliated with the template file. Are you sure?'))
							 	return true;
							else
								return false;

						}

				</script>

				<?php MakeMsgPage('Imported Newsletter Issues', 'A list of imported issues is shown below. To import a new issue, click the "Browse" button, and select a valid html document. then click the \'Upload Issue\'. To remove one/more imported issues, click the checkbox for that file and then click the "Delete Selected" button. <br><br><strong>Note: </strong>Once you have created a newsletter issue based on a html file, if your required to edit the issue content, you will need to upload the newer version over the old version. Imported issues can still use Personalization Tags.'); ?>


				<table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">

					<form action="issues.php" method="post" name="frmImportFile" onSubmit="return confirmOver();" enctype="multipart/form-data">

					<input type="hidden" name="what" value="doImportFile">

					<tr>

						<td width="100%" colspan="6" height="40" class="Info">

							Import <input name="strFile" type="file" value=""> <input type="submit" name="" value="Upload Issue &raquo;" style="height: 22px;">

						</td>

					</tr>

					</form>

					<form action="issues.php" method="post" name="frmListFiles" onSubmit="return confirmDel();">

					<input type="hidden" name="what" value="doDeleteFile">

					<tr bgcolor="#787C9B">

						<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

						<td height="20" class="MenuHeading">&nbsp;

						</td>

						<td height="20" class="MenuHeading">

							File Name

						</td>

						<td height="20" class="MenuHeading">

							Created

						</td>

						<td height="20" class="MenuHeading">

							Status

						</td>

						<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

					</tr>


					<?php

						$i = 0;

						if ($handle = @opendir('issues/'))
							{

								while ($file = readdir($handle))
									{

										//check file type

										$pass = false;

										foreach($fileTypes as $key=>$value)
											{

												$size = strlen($value);

												$ext = substr($file, -$size);

												if($ext == $value)
													$pass = true;

											}

										if ($file != "." && $file != ".." && $pass)
											{

												$fileDtls = stat("issues/$file");

												$i++;

												$bgColor = (@$bgColor == "#FFFFFF") ? "#E7E8F5" : "#FFFFFF";

												?>

													<tr bgcolor="<?php echo $bgColor; ?>">

														<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

														<td><input type="checkbox" name="fileDel[]" value="<?php echo $file; ?>"></td>

														<td class="TableCell">

															<a title="View <?php echo "$file"; ?>"  target="_blank" href="issues/<?php echo "$file"; ?>"><?php echo $file; ?></a>

														</td>

														<td class="TableCell">

															<?php

																	echo date("Y-n-d H:i:s", $fileDtls['mtime']);

															?>

														</td>

														<td class="TableCell">

															<?php

																$strQuery = @mysql_query("SELECT iStatus, pk_iId from {$dbPrefix}_issues WHERE iFile = '$file'");

																if(@mysql_num_rows($strQuery) > 0)
																	{

																		echo mysql_result($strQuery, 0, 0) . " [<a href=\"issues.php?what=editImport&iId=" . mysql_result($strQuery, 0, 1) . "\">Edit</a>]";

																	}
																else
																	{

																		?>

																			<a href="issues.php?what=newImport&file=<?php echo $file; ?>">Create An Issue</a>

																		<?php

																	}

																?>

														</td>

														<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

													</tr>

												<?php

											}

									}


							}

						closedir($handle);

						if($i == 0)
							{

								?>

									<tr>

										<td></td>

										<td class="TableCell" colspan="6">

											There is currently no valid imported issues.

										</td>

									</tr>

								<?php

							}

					?>

					<tr>

						<td colspan="6" bgcolor="#787C9B" height="1"></td>

					</tr>

					<tr>

						<td colspan="6" class="TableCell">

							<br>

							<input type="submit" value="Delete Selected »">

						</td>

					</tr>

					</form>

				</table>

			<?php

		}

	function ShowNewForm()
		{

			global $docRoot, $siteFolder, $dbPrefix;

			$name = str_replace('\\', '', str_replace("\'", "'", @$_GET["name"]));
			$subject = str_replace('\\', '', str_replace("\'", "'", @$_GET["subject"]));
			$nType = @$_GET["nType"];
			$styleType = (@$_GET["styleType"] != '') ? $_GET["styleType"] : "non";
			$style = @$_GET["style"];

			if($nType == "")
				{

					$nType = 0;

					$nShow = true;

				}
			else
				$nShow = false;

			if($nType > 0)
				{

					$nType--;

					$result = mysql_query("SELECT nFormat, nTempFile FROM {$dbPrefix}_newsletters ORDER BY nName ASC LIMIT $nType, 1");

					if($row = mysql_fetch_row($result))
						{

							if($row[1] != '')
								{

									$handle = fopen('newsletters/' . $row[1], "rb");

									while(@!feof($handle))
										@$content .= fgets($handle, 1024);

								}
							else
								$content = '';

							$format = $row[0];

						}
					else
						{

							$format = false;
							$show =  "<i>ERROR: Selected newsletter was not found in the database</i>";

						}

					$nType++;

				}
			else
				{

					$nType--;

					$format = false;
					$show = "<i>[Please select a newsletter first]</i><br><br>";

				}



			?>

				<script language="JavaScript">

					function changeNewsletter(format,tmp)
						{

							if(format == 'text')
								{

									var name = escape(document.frmIssue.name.value);
									var subject = escape(document.frmIssue.subject.value);
									var nType = document.frmIssue.newsletterId.selectedIndex;

									document.location.href = 'issues.php?what=new&name='+name+'&subject='+subject+'&nType='+nType;

								}
							else
								{

									var name = escape(document.frmIssue.name.value);
									var subject = escape(document.frmIssue.subject.value);
									var nType = document.frmIssue.newsletterId.selectedIndex;
									var styleType = styleTmp;

									if(styleType == 'ext')
										var style = escape(document.frmIssue.styleext.value);
									else
										var style = escape(document.frmIssue.styleint.value);

									if(style.length > 700)
										{
											alert('Your stylesheet CSS code can not be more than 700 characters. Please use an external stylesheet instead.');
											document.frmIssue.styleint.focus();
											document.frmIssue.styleint.select();
											return false;
										}

									if(tmp == 'drop')
										tmp = '#editor';
									else
										tmp = '';

									document.location.href = 'issues.php?what=new&name='+name+'&subject='+subject+'&nType='+nType+'&style='+style+'&styleType='+styleType+tmp;

								}

						}


					function toggleP()
						{

							if(document.all.pMenu.style.display == 'inline')
								{

									document.all.pMenu.style.display = 'none';

									document.all.pText.innerHTML = 'Personalization Tags »';

								}
							else
								{

									document.all.pMenu.style.display = 'inline';

									document.all.pText.innerHTML = '« Personalization Tags';

								}

						}

			    </script>

				<?php

					$data  = "Please complete the form below to create a new issue. Once created, this issue will be saved ";
					$data .= "and you will have the option to send it to your subscriber list.";
					$data .= "<br><br><a style=\"cursor:hand\" onClick=\"toggleP()\"><u><span id=\"pText\">Personalization Tags »</span></u></a>";
					$data .= "<br><br>";

					$data .= "<table style=\"display:none\" width=\"95%\" align=\"center\" id=\"pMenu\"><tr><td><span class=\"Info\">";
					$data .= "It's easy to add a subscribers email address, or any custom fields that you have created (such as age, sex, first name, etc) to your newsletter. Simply type in one or more of the personalization tags shown below and they will be replaced with the appropriate values when the newsletter is sent.";
					$data .= "<br><br>For example: to greet your subscribers by their email address, type <font color=\"red\">Hi %%email%%</font> into your newsletter.";
					$data .= "<ul><li><i><b>%%email%%</b></i> The users email address</li>" . ShowPerTags(1, 1) . "</ul>";
					$data .= "<strong>Note:</strong> You can also place personalization tags in uploaded issues and the subject line of your newsletters.</span></td></tr>";
					$data .= "</table>";

					MakeMsgPage('Create A Newsletter Issue', $data, 0);

				?>

				<tr>

					<td>

						<form name="frmIssue" action="issues.php" method="post">
						<input type="hidden" name="what" value="doNew">

						<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

							<tr>

								<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

									User Details

								</td>

							</tr>

							<tr>

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="middle">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Issue Name</strong><br>

									</p>

								</td>

								<td width="75%">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<input type="text" name="name" size="40" value="<?php echo $name; ?>">

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr bgcolor="#E7E8F5">

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="middle">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Subject Line</strong><br>

									</p>

								</td>

								<td width="75%">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<input type="text" name="subject" size="40" value="<?php echo $subject; ?>">

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<?php if($format != "text") { ?>

								<tr>

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="middle">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong>Stylesheet Type</strong><br>

										</p>

									</td>

									<td width="75%" class="BodyText">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<input type="radio" name="styleType" value="ext" onClick="document.all.titleID.innerHTML = 'Stylesheet URL';document.all.int.style.display = 'none';document.all.ext.style.display = 'inline'; styleTmp = 'ext';" <?php if($styleType == 'ext') echo "checked"; ?>> External<br>
											<input type="radio" name="styleType" value="int" onClick="document.all.titleID.innerHTML = 'Stylesheet Source';document.all.ext.style.display = 'none';document.all.int.style.display = 'inline'; styleTmp = 'int';" <?php if($styleType == 'int') echo "checked"; ?>> Internal<br>
											<input type="radio" name="styleType" value="non" onClick="document.all.titleID.innerHTML = 'Stylesheet';document.all.int.style.display = 'none';document.all.ext.style.display = 'none'; styleTmp = 'non';" <?php if($styleType != 'int' && $styleType != 'ext') echo "checked"; ?>> None

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr bgcolor="#E7E8F5">

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="middle">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong><span id="titleID"> StyleSheet</span></strong><br>

										</p>

									</td>

									<td width="75%" class="BodyText">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<span id="ext" <?php if($styleType == 'int' || $styleType != 'ext') echo "style='display: none;'"; ?>>

												<?php if($styleType == 'ext' || $styleType != 'int') echo "<script language=\"JavaScript\">var styleTmp = 'ext';</script>"; ?>

												<input type="text" name="styleext" size="40" maxlength="255" value="<?php echo $style; ?>">

											</span>

											<span id="int" <?php if($styleType == 'ext' || $styleType != 'int') echo "style='display: none;'"; ?>>

												<?php if($styleType == 'int') echo "<script language=\"JavaScript\">var styleTmp = 'int';</script>"; ?>

												<textarea name="styleint" style="width: 98%;" rows="8" wrap="off"><?php echo $style; ?></textarea>

											</span>

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

							<?php } ?>

							<tr>

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="middle">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Newsletter Template</strong><br>

									</p>

								</td>

								<td width="75%" class="BodyText">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<select name="newsletterId" style="width: 196pt" onChange="changeNewsletter('<?php echo $format; ?>')">

											<?php GetTemplateList($nType); ?>

										</select>

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr bgcolor="#E7E8F5">

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td colspan="2" class="BodyText">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Issue Content</strong><br>

										<?php

											// Do we need to show the content area for this newsletter?

											if(!$format)
												echo $show;
											elseif($format == "text")
												{

													// Show a <textarea> tag

													?>

														<br>

														<textarea name="content" rows="20" style="width: 98%"></textarea>

														<input type="hidden" name="contentType" value="0">

														<br>

													<?php

												}
											else
												{

													// Show an EWP control

													echo "<br>[<a href=\"javascript: if(confirm('Refreshing the style list will remove all data from the editor below. Do you wish to continue?')) changeNewsletter('drop');\">Refresh Style List</a>]<br><br>";

													echo "<a name='editor'></a>";

													include_once("ew/class.editworks.php");

													echo "<input type=\"hidden\" name=\"contentType\" value=\"1\">";

													$myEW = new EW;

													$myEW->DisableXHTMLFormatting();
													$myEW->DisableSingleLineReturn();


													$myEW->SetPathType(EW_PATH_TYPE_FULL);

													$myEW->SetDocumentType(EW_DOC_TYPE_HTML_PAGE);

													$myEW->SetImageDisplayType(EW_IMAGE_TYPE_THUMBNAIL);

													if($style != '')
														{

															if($styleType == 'ext')
																$style = "<LINK rel=\"stylesheet\" type=\"text/css\" href=\"$style\">";
															else
																$style = "<style>$style</style>";

														}
													else
														$style = ' ';

													$myEW->SetValue($style . ' ' . $content);

													//custom inserts

													$cQuery = mysql_query("SELECT cfTitle, cfFieldName FROM {$dbPrefix}_customfields WHERE cfPerTags = '1'  ORDER BY cfWeight DESC, cfTitle ASC");

													while($cRow = mysql_fetch_array($cQuery))
														$myEW->AddCustomInsert("{$cRow[0]}", "%%{$cRow[1]}%%");

													$myEW->ShowControl('98%', 530, "$docRoot/$siteFolder/email_images");

												}


										?>

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr>

								<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="1" valign="middle">

								</td>

							</tr>

							<tr>

								<td valign="top" colspan="4">


										<br><br>

										<input type="button" value="« Cancel" onClick="ConfirmCancel('issues.php')">

										<input type="submit" name="submit" value="Add Issue »">

									</span>

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

			$name = @$_POST["name"];
			$subject = @$_POST["subject"];
			$newsletterId = @$_POST["newsletterId"];
			$contentType = @$_POST["contentType"];
			$styleType = @$_POST["styleType"];

			if($styleType == 'ext')
				$style = @$_POST["styleext"];
			elseif($styleType == 'int')
				$style = @$_POST["styleint"];
			else
				$style = '';

			$content = "";

			$err = "";

			if($contentType == 0)
				{

					$content = @$_POST["content"];

				}
			else
				{

					require_once("ew/class.editworks.php");

					$myEW = new EW;

					$content = $myEW->GetValue();

				}

			// Has the user entered all of the required fields?

			if($name == "")
				$err .= "<li>You forgot to enter a name for this issue</li>";

			if($subject == "")
				$err .= "<li>You forgot to enter a subject line for this issue</li>";

			if($newsletterId == -1)
				$err .= "<li>You forgot to select a template for this issue</li>";

			if($content == "")
				$err .= "<li>You forgot to enter content for this issue</li>";

			if($err != "")
				MakeMsgPage('Create Newsletter Issue', "The form that you've just submitted is incomplete. Please review the errors below and then go back and correct them: <ul>$err</ul><a href=\"javascript:history.go(-1)\"><< Go Back</a>");
			else
				{

					// All of the fields were complete, save this newsletter to the database

					$query = "INSERT INTO {$dbPrefix}_issues (iName, iTitle, iContent, iNewsletterId, iStatus, iStyle, iStyleType) ";
					$query .= "VALUES ('$name', '$subject', '$content', '$newsletterId', 'pending', '$style', '$styleType')";

					doDbConnect();

					if(@mysql_query($query))
						MakeMsgPage('Create Newsletter Issue', 'You have successfully created and saved a newsletter issue. To send this issue to your subscriber list now, click on the "Send Newsletter" link below.<br><br><a href="sendissue.php">Send Newsletter</a> | <a href="issues.php">Continue</a>');

				}

		}

	function ShowIssueList()
		{

			// Show a list of templates currently in the database

			global $dbPrefix;

			doDbConnect();

			?>

				<script language="JavaScript">

					function CheckConfirmDelete()
						{

							if(confirm('WARNING: You are about to permanently delete the selected issue(s) and any related data. Click OK to continue.'))
								return true;
							else
								return false;

						}

				</script>

				<form onSubmit="return CheckConfirmDelete()" action="issues.php" method="post">

				<input type="hidden" name="what" value="delete">

				<?php MakeMsgPage('Newsletter Issues', 'A list of existing issues is shown below. To add a new issue, click the "Add Newsletter Issue" link. To remove one/more issues, click the checkbox for that newsletter and then click the "Delete Selected" button.'); ?>

				<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center">

					<tr>

						<td width="100%" colspan="6" height="40" class="Info">

							<a href="issues.php?what=new"> Add Newsletter Issue »</a>

						</td>

					</tr>

					<tr bgcolor="#787C9B">

						<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

						<td height="20" class="MenuHeading">&nbsp;</td>

						<td height="20" class="MenuHeading">

							Issue Name

						</td>

						<td height="20" class="MenuHeading">

							Newsletter

						</td>

						<td height="20" class="MenuHeading">

							Status

						</td>

						<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

					</tr>

					<?php

						$result = mysql_query("SELECT * FROM {$dbPrefix}_issues INNER JOIN {$dbPrefix}_newsletters ON {$dbPrefix}_issues.iNewsletterId = {$dbPrefix}_newsletters.pk_nId where {$dbPrefix}_issues.iFile = '' ORDER BY {$dbPrefix}_issues.iName ASC");

						if(@mysql_num_rows($result) == 0)
							{

								?>

									<tr>

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

										<td colspan="4" width="100%" height="25" class="Info">

											<p style="margin-left:10">
											There are no issues in the database.

										</td>

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

									</tr>

								<?php

							}

						while($row = @mysql_fetch_row($result))
							{

								$bgColor = (@$bgColor == "#FFFFFF") ? "#E7E8F5" : "#FFFFFF";

								?>

									<tr bgcolor="<?php echo $bgColor; ?>">

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

										<td height="20" class="TableCell">

											<input type="checkbox" name="iId[]" value="<?php echo $row[0]; ?>">

										</td>

										<td height="20" class="TableCell">

											<a href="issues.php?what=modify&iId=<?php echo $row[0]; ?>"><?php echo $row[1]; ?></a>

										</td>

										<td height="20" class="TableCell">

											<?php echo $row[10]; ?>

										</td>

										<td height="20" class="TableCell">

											<?php echo $row[5]; ?>

										</td>

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

									</tr>

								<?php

							}

					?>

					<tr>

						<td colspan="6" bgcolor="#787C9B" height="1"></td>

					</tr>

					<tr>

						<td width="100%" colspan="6">

							<br>

							<input type="submit" value="Delete Selected »">

						</td>

					</tr>

				</table>

				</form>

			<?php

		}

	function DeleteIssue()
		{

			// This function will remove the selected newsletters from the database

			global $dbPrefix;

			doDbConnect();

			$iId = @$_POST["iId"];

			$query = "";

			$result = "";

			if(is_array($iId) == true)
				{

					// Templates have been chosen, run 2 delete queries

					$result = @mysql_query("DELETE FROM {$dbPrefix}_issues WHERE pk_iId = " . implode(" OR pk_iId = ", $iId));

					$result2 = @mysql_query("DELETE FROM {$dbPrefix}_issuestatus WHERE pk_isId = " . implode(" OR pk_isId = ", $iId));
					$result3 = @mysql_query("DELETE FROM {$dbPrefix}_track WHERE tIId = " . implode(" OR tIId = ", $iId));

					if($result && $result2 && $result3)
						{

							// Query executed OK

							$status = "You have successfully delete one/more issues from the database.<br><br>";

							$status .= "<a href='sendissue.php'>Send Issue</a> | <a href='issues.php'>Continue >></a>";

						}
					else
						{

							// Delete querie(s) failed

							$status = "An error occured while trying to delete the selected issue(s).<br><br>";

							$status .= "<a href='javascript:document.location.reload()'>Try Again</a>";

						}

				}
			else
				{

					// No newsletters have been chosen

					$status = "You didn't select one/more issues to delete.<br><br>";

					$status .= "<a href='javascript:history.go(-1)'>Try Again</a>";

				}

			MakeMsgPage('Delete Issue(s)', $status);

		}

	function ModifyIssue()
		{

			// Change the details of a newsletter

			global $dbPrefix, $docRoot, $siteFolder;

			doDbConnect();

			$iId = @$_GET["iId"];
			$name = str_replace('\\', '', str_replace("\'", "'", @$_GET["name"]));
			$subject = str_replace('\\', '', str_replace("\'", "'", @$_GET["subject"]));
			$nType = @$_GET["nType"];
			$styleType = @$_GET["styleType"];
			$style = @$_GET["style"];

			$result = @mysql_query("SELECT * FROM {$dbPrefix}_issues WHERE pk_iId = $iId");

			if($row = @mysql_fetch_array($result))
				{

					if($row['iFile'] != '')
						{

							MakeMsgPage('Invalid Newsletter Selected', 'The issue that you have selected is actually an imported issue, therefore you can only edit it via the import editor.<br><br><a href="issues.php">Continue >></a>');

							include("templates/bottom.php");

							die();

						}


					$newsletterId = $row["iNewsletterId"];

					if(@$_GET["c"] != "")
						{

							// Workout the type of content area to show

							$tResult = mysql_query("SELECT pk_nId FROM {$dbPrefix}_newsletters ORDER BY nName ASC LIMIT $nType, 1");

							if($tRow = mysql_fetch_row($tResult))
								{

									$newsletterId = $tRow[0];

								}

						}
					else
						{

							$name = str_replace('\\', '', str_replace("\'", "'", $row["iName"]));
							$subject = str_replace('\\', '', str_replace("\'", "'", $row["iTitle"]));
							$styleType = $row["iStyleType"];
							$style = $row["iStyle"];

						}

					if(@$_GET["c"] == "")
						$newsletterId = $row["iNewsletterId"];
					else
						{

							// Workout the type of content area to show

							$tResult = mysql_query("SELECT pk_nId FROM templates ORDER BY nName ASC LIMIT $nType, 1");

							if($tRow = mysql_fetch_row($result))
								$newsletterId = $tRow[0];

						}

					$tResult = mysql_query("SELECT nFormat FROM {$dbPrefix}_newsletters WHERE pk_nId = " . $newsletterId);

					$tFormat = "";

					if($tRow = mysql_fetch_row($tResult))
						$format = $tRow[0];

					?>

						<script language="JavaScript">

							function changeNewsletter(tmp)
								{

									var name = escape(document.frmIssue.name.value);
									var subject = escape(document.frmIssue.subject.value);
									var nType = document.frmIssue.newsletterId.selectedIndex;
									var styleType = styleTmp;



									if(styleType == 'ext')
										var style = escape(document.frmIssue.styleext.value);
									else
										var style = escape(document.frmIssue.styleint.value);

									if(tmp == 'drop')
										tmp = '#editor';
									else
										tmp = '';

									document.location.href = 'issues.php?what=modify&c=1&name='+name+'&subject='+subject+'&iId=<?php echo $iId; ?>&nType='+nType+'&style='+style+'&styleType='+styleType+tmp;

								}

							function toggleP()
								{

									if(document.all.pMenu.style.display == 'inline')
										{

											document.all.pMenu.style.display = 'none';

											document.all.pText.innerHTML = 'Personalization Tags »';

										}
									else
										{

											document.all.pMenu.style.display = 'inline';

											document.all.pText.innerHTML = '« Personalization Tags';

										}

								}

						</script>

						<?php

							$content  = "Please complete the form below to modify the selected newsletter. Click on the \"Update Newsletter\" button to update the details of this newsletter.";
							$content .= "<br><br><a style=\"cursor:hand\" onClick=\"toggleP()\"><u><span id=\"pText\">Personalization Tags »</span></u></a>";
							$content .= "<br><br>";

							$content .= "<table style=\"display:none\" width=\"95%\" align=\"center\" id=\"pMenu\"><tr><td><span class=\"Info\">";
							$content .= "It's easy to add a subscribers first name, last name, complete name or email address to your newsletter. Simply type in one or more of the personalization tags shown below and they will be replaced with the appropriate values when the newsletter is sent.";
							$content .= "<br><br>For example: to greet your subscribers by their first name, type <font color=\"red\">Hi %%first_name%%</font>.";
							$content .= "<ul><li><i>%%email%%</i> The users email address</li>" . ShowPerTags(1, 1) . "</ul>";
							$content .= "<strong>Note:</strong> You may place \"Personalization Tags\" in the Issue Content (Imported html file) and Subject Line</span></td></tr>";
							$content .= "</table>";

							MakeMsgPage('Modify Newsletter Issue', $content, 0);

						?>

							<tr>

								<td background="images/yellowbg1.gif"></td>

							</tr>

							<tr>

								<td>

									<form name="frmIssue" action="issues.php" method="post">

									<input type="hidden" name="what" value="doModify">

									<input type="hidden" name="iId" value="<?php echo $iId; ?>">

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

													<strong>Newsletter Name</strong><br>

												</p>

											</td>

											<td width="75%">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<input type="text" name="name" size="40" value="<?php echo $name; ?>">

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr bgcolor="#E7E8F5">

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Subject</strong><br>

												</p>

											</td>

											<td width="75%">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<input type="text" name="subject" size="40" value="<?php echo $subject; ?>">

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<?php if($format != "text") { ?>

											<tr>

												<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												<td width="25%" class="BodyText" valign="middle">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<strong>StyleSheet Type</strong><br>

													</p>

												</td>

												<td width="75%" class="BodyText">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<input type="radio" name="styleType" value="ext" onClick="document.all.int.style.display = 'none';document.all.ext.style.display = 'inline'; styleTmp = 'ext';" <?php if($styleType == 'ext') echo "checked"; else echo "disabled"; ?>> External<br>
														<input type="radio" name="styleType" value="int" onClick="document.all.ext.style.display = 'none';document.all.int.style.display = 'inline'; styleTmp = 'int';" <?php if($styleType == 'int') echo "checked"; else echo "disabled" ?>> Internal<br>
														<input type="radio" name="styleType" value="non" <?php if($styleType != 'int' && $styleType != 'ext') echo "checked"; else echo "disabled" ?>> None


													</p>

												</td>

												<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											</tr>

											<tr bgcolor="#E7E8F5">

												<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												<td width="25%" class="BodyText" valign="middle">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<strong><?php if($styleType == "ext") echo "Stylesheet URL"; elseif($styleType == 'int') echo "Stylesheet Source"; else echo "StyleSheet"; ?></strong><br>

													</p>

												</td>

												<td width="75%" class="BodyText">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<div id="ext" <?php if($styleType == 'int' || $styleType != 'ext') echo "style='display: none;'"; ?>>

															<?php if($styleType == 'ext' || $styleType != 'int') echo "<script language=\"JavaScript\">var styleTmp = 'ext';</script>"; ?>

															<input disabled type="text" name="styleext" size="40" maxlength="255" value="<?php echo $style; ?>">

															<br><br>

														</div>

														<div id="int" <?php if($styleType == 'ext' || $styleType != 'int') echo "style='display: none;'"; ?>>

															<?php if($styleType == 'int') echo "<script language=\"JavaScript\">var styleTmp = 'int';</script>"; ?>

															<textarea disabled name="styleint" cols="65" rows="8" wrap="off"><?php echo $style; ?></textarea>

															<br><br>

														</div>

													</p>

												</td>

												<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											</tr>

										<?php } else { ?>

											<script language="JavaScript">var styleTmp = '';</script>

											<input type="hidden" name="styleint" value="">
											<input type="hidden" name="styleType" value="">

										<?php } ?>

										<tr>

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Newsletter Template</strong><br>

												</p>

											</td>

											<td width="75%">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<select name="newsletterId" style="width: 196pt" onChange="changeNewsletter()">

														<?php GetTemplateList(-2, $newsletterId, false); ?>

													</select>

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr bgcolor="#E7E8F5">

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td class="BodyText" colspan="2">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Newsletter Content</strong>

													<br>

													<?php

														// Get the format type for this newsletter

														if($format == "text")
															{

																// Show a <textarea> tag

																?>

																	<br>

																	<textarea name="content" rows="20" style="width: 98%"><?php echo str_replace("<", "&lt;", $row["iContent"]); ?></textarea>

																	<input type="hidden" name="contentType" value="0">

																	<br>

																<?php

															}
														else
															{

																// Show an EWP control

																echo "<br>[<a href=\"javascript: if(confirm('Refreshing the style list will reset all data from the editor below to its original value. Do you wish to continue?')) changeNewsletter('drop');\">Refresh Style List</a>]<br><br>";

																echo "<a name='editor'></a>";

																//print_r($_SERVER);

																require_once("ew/class.editworks.php");

																$myEW = new EW;

																$myEW->DisableXHTMLFormatting();
																$myEW->DisableSingleLineReturn();


																$myEW->SetPathType(EW_PATH_TYPE_FULL);

																$myEW->SetDocumentType(EW_DOC_TYPE_HTML_PAGE);

																$myEW->SetImageDisplayType(EW_IMAGE_TYPE_THUMBNAIL);

																$myEW->SetValue($row["iContent"]);



																$cQuery = mysql_query("SELECT cfTitle, cfFieldName FROM {$dbPrefix}_customfields WHERE cfPerTags = '1'  ORDER BY cfWeight DESC, cfTitle ASC");

																while($cRow = mysql_fetch_array($cQuery))
																	$myEW->AddCustomInsert("{$cRow[0]}", "%%{$cRow[1]}%%");

																$myEW->ShowControl('97%', 530, "$docRoot/$siteFolder/email_images");

																echo "<input type='hidden' name='contentType' value='1'>";

															}

													?>

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr>

											<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="1" valign="middle"></td>

										</tr>

										<tr>

											<td valign="top" colspan="4">

												<br>

												<input type="button" value="« Cancel" onClick="ConfirmCancel('issues.php')">

												<input type="submit" name="submit" value="Update Newsletter »">

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
				MakeMsgPage('Invalid Issue Selected', 'The newsletter that you have selected is either invalid or has been deleted from the database.<br><br><a href="issues.php">Continue >></a>');

		}

	function ProcessModify()
		{

			// Make sure all fields are completed

			global $dbPrefix;

			$iId = @$_POST["iId"];
			$name = @$_POST["name"];
			$subject = @$_POST["subject"];
			$newsletterId = @$_POST["newsletterId"];
			$contentType = @$_POST["contentType"];

			$content = "";
			$err = "";

			if($contentType == 0)
				{

					$content = @$_POST["content"];

				}
			else
				{

					include_once("ew/class.editworks.php");

					$myEW = new EW;

					$content = $myEW->GetValue(true);

				}

			// Has the user entered all of the required fields?

			if($name == "")
				$err .= "<li>You forgot to enter a name for this newsletter</li>";

			if($subject == "")
				$err .= "<li>You forgot to enter a subject line for this newsletter</li>";

			if($newsletterId == -1)
				$err .= "<li>You forgot to select a template for this newsletter</li>";

			if($content == "")
				$err .= "<li>You forgot to enter content for this newsletter</li>";

			if($err != "")
				MakeMsgPage('Modify Issue', 'The form that you\'ve just submitted is incomplete. Please review the errors below and then go back and correct them: <ul>' . $err .'</ul><a href="javascript:history.go(-1)"><< Go Back</a>');

			else
				{

					doDbConnect();

					$query = "UPDATE {$dbPrefix}_issues SET iName='$name', iTitle='$subject', iContent='$content', iNewsletterId=$newsletterId WHERE pk_iId=$iId";

					$result = @mysql_query($query);

					$status = "";

					if($result)
						{

							$status = "Your newsletter has been successfully modified.<br><br>";

							$status .= "<a href='sendissue.php'>Send Newsletter</a> | <a href='newsletter.php'>Continue >></a>";

						}
					else
						{

							$status = "Some errors occured while trying to modify this newsletter.<br><br>";

							$status .= "<a href='javascript:history.go(-1)'><< Go Back</a><br>&nbsp;";

						}

					MakeMsgPage('Modify Newsletter', $status);

			}

		}

	include("templates/bottom.php");

?>