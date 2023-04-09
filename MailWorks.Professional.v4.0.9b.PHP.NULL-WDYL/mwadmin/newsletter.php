<?php

	include("templates/top.php");

	include_once("includes/functions.php");

  	$what = @$_POST["what"];

	if($what == "")
		$what = @$_GET["what"];

	switch($what)
		{

		// Templates

			case "doDeleteFile";
				if(in_array("newsletters_template", $authLevel))
		      		DeleteImport();
				else
					noAccess();
				break;

			case "doImportFile";
				if(in_array("newsletters_template", $authLevel))
		      		ImportFile();
				else
					noAccess();
				break;

			case "template":
				if(in_array("newsletters_template", $authLevel))
		      		ShowNewTemplate();
				else
					noAccess();
				break;

		// Norm

			case "new":
				if(in_array("newsletters_add", $authLevel))
		      		ShowNewForm();
				else
					noAccess();
				break;

			case "doNew":
				if(in_array("newsletters_add", $authLevel))
			  		ProcessNew();
				else
					noAccess();
				break;

			case "delete":
				if(in_array("newsletters_delete", $authLevel))
			  		DeleteNewsletter();
				else
					noAccess();
				break;

			case "modify":
				if(in_array("newsletters_edit", $authLevel))
			  		ModifyNewsletter();
				else
					noAccess();
				break;

			case "doModify":
				if(in_array("newsletters_edit", $authLevel))
	  				ProcessModify();
				else
					noAccess();
				break;

			default:
				if(in_array("newsletters_view", $authLevel))
			  		ShowNewsletterList();
				else
					noAccess();
				break;
		}

	function DeleteImport()
		{

			// This function will remove the selected newsletters from the database

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

							if(@unlink("newsletters/$value"))
								$i++;

						}

					if(sizeof($fId) == $i)
						{

							// Query executed OK

							$status = "<br>You have successfully delete one/more uploaded templates from the database.<br><br>";

							$status .= "<a href='newsletter.php?what=template'>Continue</a>";

						}
					else
						{

							// Delete querie(s) failed

							$status = "<br>An error occured while trying to delete the selected uploaded template(s). You may not have permission to delete the selected files.<br><br>";

							$status .= "<a href='javascript:document.location.reload()'>Try Again</a>";

						}

				}
			else
				{

					// No newsletters have been chosen

					$status = "<br>You didn't select one/more uploaded templates to delete.<br><br>";

					$status .= "<a href='javascript:history.go(-1)'>Try Again</a>";

				}

			MakeMsgPage('Delete Imported Template(s)', $status);

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

							$upload = @copy($file['tmp_name'], "newsletters/" . $file['name']);

							if($upload)
								{

									@chmod("newsletters/" . $file['name'], 0757);

									header("Location: newsletter.php?what=template");

								}
							else
								MakeMsgPage('Uploaded Template', 'The file that you specified was unable to be uploaded. Please ensure that your server has the correct settings to allow for file uploading. Also please ensure that the directory issues (/mwadmin/issues) has the correct persmissions.<br><br><a href="javascript: history.go(-1);">Continue</a>');

						}
					else
						MakeMsgPage('Uploaded Template', 'Sorry but the file you have selected is not a HTML (htm & html) file. Please return to the previous page and select a valid file type.<br><br><a href="javascript: history.go(-1);">Back</a>');

				}
			else
				MakeMsgPage('Uploaded Template', 'Please ensure that you have selected a file for uploading. Please return to the previous page and select a file to upload.<br><br><a href="javascript: history.go(-1);">Continue</a>');

		}


	function ShowNewTemplate()
		{

			global $siteEmail;

			$fileTypes = array(".htm",".html");

			?>

				<script language="JavaScript">

					function confirmDel()
						{

							 if(confirm('This will permently DELETE any selected files. Are you sure?'))
							 	return true
							else
								return false

						}

				</script>

				<?php MakeMsgPage('Newsletter Templates', 'A list of uploaded templates is shown below. You can use templates as a base for your issues, giving each issue for that newsletter the same look and feel. To upload a template, please use the upload form shown below.<br><br><b>Note:</b> If you upload a template that has the same name as an existing template, then the existing template will be overwritten.<br><br>'); ?>

				<table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">

					<form action="newsletter.php" method="post" name="frmTemplateFile" enctype="multipart/form-data">

					<input type="hidden" name="what" value="doImportFile">

					<tr>

						<td><img border="0" width="1" height="1" src="images/blank.gif"></td>

						<td colspan="3" class="Info" valign="middle">

							<span style="background-color: #E7E8F5; width: 100%; vertical-align: middle; border: 1px solid #787C9B;">

								<p style="margin: 5 5 5 5;">

									Upload Template: <input align="middle" name="strFile" type="file" value=""> <input type="submit" name="" value="Upload Template &raquo;" style="height: 22px;">
									<br>

								</p>

							</span>

							<br><br>

						</td>

						<td><img border="0" width="1" height="1" src="images/blank.gif"></td>

					</tr>

					</form>

					<form action="newsletter.php" method="post" name="frmListFiles" onSubmit="return confirmDel();">

					<input type="hidden" name="what" value="doDeleteFile">

					<tr bgcolor="#787C9B">

						<td bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

						<td height="20" class="MenuHeading"></td>

						<td height="20" class="MenuHeading">

							File Name

						</td>

						<td height="20" class="MenuHeading">

							Created

						</td>

						<td bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

					</tr>


					<?php

						if ($handle = @opendir('newsletters/'))
							{

								$i = 0;

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

												$fileDtls = stat("newsletters/$file");

												$i++;

												$bgColor = (@$bgColor == "#FFFFFF") ? "#E7E8F5" : "#FFFFFF";

												?>

													<tr bgcolor="<?php echo $bgColor; ?>">

														<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

														<td><input type="checkbox" name="fileDel[]" value="<?php echo $file; ?>"></td>

														<td class="TableCell">

															<a title="View <?php echo "$file"; ?>"  target="_blank" href="newsletters/<?php echo "$file"; ?>"><?php echo $file; ?></a>

														</td>

														<td class="TableCell">

															<?php

																	echo date("Y-n-d H:i:s", $fileDtls['mtime']);

															?>

														</td>

														<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

													</tr>

										<?php

											}

									}

								if($i == 0)
									{

										?>

													<tr>

														<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

														<td class="TableCell" colspan="3" height="25" width="100%">

															<p style="margin-left: 10px;">

																There is currently no valid templates.

															</p>

														</td>

														<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

													</tr>

										<?php

									}


							}

						closedir($handle);


					?>

					<tr>

						<td colspan="5" bgcolor="#787C9B" height="1"></td>

					</tr>

					<tr>

						<td colspan="5">

							<br>

							<input type="submit" value="Delete Selected �">

						</td>

					</tr>

					</form>

				</table>

			<?php

		}

	function ShowNewForm()
		{

			global $siteEmail;

			$fileTypes = array(".htm",".html");

			?>

				<script>

					function ShowFreq(data)
						{

							if(data == 'false')
								{

									document.frmNewsletter.freq1.disabled = true;
									document.frmNewsletter.freq2.disabled = true;

								}
							else
								{

									document.frmNewsletter.freq1.disabled = false;
									document.frmNewsletter.freq2.disabled = false;

								}

						}

					function CheckTemplate()
						{

							var frm = document.frmNewsletter;

							if(frm.template.disabled)
								frm.template.disabled = false;
							else
								frm.template.disabled = true;

						}

				</script>

				<?php MakeMsgPage('Create Newsletter', 'Please complete the form below to create a new newsletter. Once you\'ve created a newsletter template, it can be used to create and send a newsletter to your list of subscribers.<br><br>', 0); ?>

				<tr>

					<td>

						<form action="newsletter.php" method="post" name="frmNewsletter">
						<input type="hidden" name="what" value="doNew">

						<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

							<tr>

								<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

									Newsletter Details

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

										<input type="text" name="name" size="40">

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr bgcolor="#E7E8F5">

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="top">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Description</strong><br>

									</p>

								</td>

								<td width="75%">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<textarea name="desc" rows="5" cols="30"></textarea>

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr>

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="top">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Newsletter Topic</strong><br>

									</p>

								</td>

								<td width="75%">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<select name="topicId" size="5" style="width: 196pt">

											<?php GetTopicList(); ?>

										</select>

										<br>

										<input type="text" name="newTopicId" size="40" value="[Enter New Topic Here]" onClick="if(this.value =='[Enter New Topic Here]') { this.value = ''; }">

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr bgcolor="#E7E8F5">

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="middle">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>From Address</strong><br>

										Which email address should this newsletter appear to be sent from?

									</p>

								</td>

								<td width="75%">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<input type="text" name="fromEmail" size="40" value="<?php echo $siteEmail; ?>">

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr>

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="middle">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Reply Address</strong><br>

										What is the reply-to email address for this newsletter?

									</p>

								</td>

								<td width="75%">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<input type="text" name="replyToEmail" size="40" value="[None]" onClick="if(this.value == '[None]') { this.value = ''; }">

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr bgcolor="#E7E8F5">

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="middle">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Newsletter Template</strong><br>

									</p>

								</td>

								<td width="75%" class="BodyText">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<select style="width: 261px;" size="4" name="template">

											<?php

												$i = 0;

												if ($handle = @opendir('newsletters/'))
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

																		$i++;

																		?>

																			<option value="<?php echo $file; ?>"><?php echo $file; ?></option>

																		<?php

																	}

															}

													}

											?>

										</select>

										<br>

										<input type="checkbox" name="checkTemplate" onClick="CheckTemplate();" value="1" <?php if($i == 0) echo 'checked'; ?>> No Template

										<?php if($i == 0) { ?><script language="JavaScript">CheckTemplate();</script><?php } ?>

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr>

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="middle">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Sending Frequency</strong><br>

										How often will this newsletter be sent? Every...

									</p>

								</td>

								<td width="75%" class="BodyText">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<select name="freq1">

											<?php GetFrequencyList(1); ?>

										</select>

										<select name="freq2">

											<?php GetFrequencyList(2); ?>

										</select>

										<input type="checkbox" name="freq3" value="4" onClick="if(this.checked == true) ShowFreq('false'); else ShowFreq('true');">
										No Sending Schedule (Whenever Required) <br>

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr bgcolor="#E7E8F5">

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="middle">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Format</strong><br>

										Will this newsletter contain plain text or HTML?

									</p>

								</td>

								<td width="75%" class="BodyText">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<input type="radio" name="format" value="text" onClick="document.all.trackc.style.display = 'none';"> Plain-Text

										<input type="radio" name="format" value="html"  onClick="document.all.trackc.style.display = 'inline';" CHECKED> HTML

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr id="trackc">

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="middle">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Tracking</strong><br>

										If yes, you will be able to see how many people have opened your newsletter.

									</p>

								</td>

								<td width="75%" class="BodyText">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<input type="radio" name="track" value="1" CHECKED> Yes

											<input type="radio" name="track" value="0" > No

									</p>

								</td>

								<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

							</tr>

							<tr bgcolor="#E7E8F5">

								<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								<td width="25%" class="BodyText" valign="middle">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<strong>Visibility</strong><br>

										Public, everyone can see. Private, only MailWorks admin's can see.

									</p>

								</td>

								<td width="75%" class="BodyText">

									<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

										<input type="radio" name="type" value="public" CHECKED> Public

										<input type="radio" name="type" value="private"> Private

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

									<br>

									<input type="button" value="� Cancel" onClick="ConfirmCancel('newsletter.php')">

									<input type="submit" name="submit" value="Add Newsletter �">

								</td>

							</tr>

						</table>

						</form>

					</td>

				</tr>

				</table>

			<?php

		}

	function ShowNewsletterList()
		{

			global $dbPrefix;

			// Show a list of templates currently in the database

			doDbConnect();

			?>

				<script language="JavaScript">

					function CheckConfirmDelete()
						{

							if(confirm('WARNING: You are about to permanently delete the selected newsletter(s). All issues that use this newsletter will also be deleted. Click OK to continue.'))
								return true;
							else
								return false;

						}

				</script>

				<form onSubmit="return CheckConfirmDelete()" action="newsletter.php" method="post">
				<input type="hidden" name="what" value="delete">

				<?php MakeMsgPage('Newsletters', 'A list of existing newsletters is shown below. To add a new newsletter, click the "Add Newsletter" link. To remove one/more newsletters, click the checkbox for that newsletter and then click on the "Delete Selected" button.'); ?>

			  	<table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">

					<tr>

						<td width="100%" colspan="7" height="40" class="Info">

							<a href="newsletter.php?what=new"> Add Newsletter �</a>

						</td>

					</tr>

					<tr bgcolor="#787C9B">

						<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

						<td height="20" class="MenuHeading">&nbsp;</td>

						<td height="20" class="MenuHeading">

							Newsletter Name

						</td>

						<td height="20" class="MenuHeading">

							Topic

						</td>

						<td width="15%" height="20" class="MenuHeading">

							Format

						</td>

						<td width="15%" height="20" class="MenuHeading">

							Type

						</td>

						<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

					</tr>

					<?php

						$result = mysql_query("SELECT * FROM {$dbPrefix}_newsletters INNER JOIN {$dbPrefix}_topics ON {$dbPrefix}_newsletters.nTopicId = {$dbPrefix}_topics.pk_tId ORDER BY {$dbPrefix}_newsletters.nName ASC");

						if(mysql_num_rows($result) == 0)
							{

								?>

									<tr>

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

										<td colspan="5" class="Info" height="25">

											<p style="margin-left:10">
											There are no newsletter templates in the database.

										</td>

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

									</tr>

								<?php

							}

						while($row = mysql_fetch_array($result))
							{

								$bgColor = (@$bgColor == "#FFFFFF") ? "#E7E8F5" : "#FFFFFF";

								?>

									<tr bgcolor="<?php echo $bgColor; ?>">

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

										<td width="10%" height="20" class="TableCell">

											<input type="checkbox" name="nId[]" value="<?php echo $row["pk_nId"]; ?>">

										</td>

									<td width="40%" height="20" class="TableCell">

										<a href="newsletter.php?what=modify&nId=<?php echo $row["pk_nId"]; ?>"><?php echo $row["nName"]; ?></a>

									</td>

									<td width="20%" height="20" class="TableCell">

										<?php echo $row["tName"]; ?>

									</td>

									<td width="15%" height="20" class="TableCell">

										<?php echo $row["nFormat"]; ?>

									</td>

									<td width="15%" height="20" class="TableCell">

										<?php echo $row["nType"]; ?>

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

						<td width="100%" colspan="7">

							<br>

							<input type="submit" value="Delete Selected �">

						</td>

					</tr>

			  	</table>

				</form>

			<?php

		}

	function ProcessNew()
		{

			global $dbPrefix;

			// Grab the details for the newsletter from the form, create the new
			// topic if necessary and workout whether to show a textbox or EWP control

			$name = @$_POST["name"];
			$desc = @$_POST["desc"];
			$topicId = @$_POST["topicId"];
			$newTopic = @$_POST["newTopicId"];
			$fromEmail = @$_POST["fromEmail"];
			$replyToEmail = @$_POST["replyToEmail"];
			if(@$_POST[''] == 1)
				$template = '';
			else
				$template = @$_POST["template"];
			$freq1 = @$_POST["freq1"];
			$freq2 = @$_POST["freq2"];
			$freq3 = @$_POST["freq3"];
			$format = @$_POST["format"];
			$type = @$_POST["type"];
			$track = @$_POST["track"];

			// Make sure all of the required form variables are complete

			$err = "";

			if($name == "")
				$err .= "<li>You forgot to enter a name for this newsletter</li>";

			if($desc == "")
				$err .= "<li>You forgot to enter a description for this newsletter</li>";

			if($topicId == "" && (trim($newTopic) == "" || $newTopic == "[Enter New Topic Here]"))
				$err .= "<li>You forgot to select a topic for this newsletter</li>";

			if(!is_numeric(strpos($fromEmail, "@")) || !is_numeric(strpos($fromEmail, ".")))
				$err .= "<li>Please enter a valid 'From' email address</li>";

			if($replyToEmail != "" && $replyToEmail != "[None]")
				if(!is_numeric(strpos($replyToEmail, "@")) || !is_numeric(strpos($replyToEmail, ".")))
					$err .= "<li>Please enter a valid 'ReplyTo' email address</li>";

			if($replyToEmail == "[None]")
				$replyToEmail = "";

			doDbConnect();

			// Do we need to add a new topic to the topics table?

			if($topicId == "" || $newTopic != "" || $newTopic != "[Enter New Topic Here]")
				{

					$topicExists = @mysql_result(mysql_query("SELECT count(*) FROM {$dbPrefix}_topics WHERE tName='$newTopic'"), 0, 0) > 0 ? true : false;

					if($topicExists == false && $newTopic != "" && $newTopic != "[Enter New Topic Here]")
						{

							$result = @mysql_query("INSERT INTO {$dbPrefix}_topics (tName) VALUES ('$newTopic')");

							$topicId = @mysql_insert_id();

						}

				}

			if($err != "")
				{

					MakeMsgPage('Create Newsletter', "The form that you've just submitted is incomplete. Please review the errors below and then go back and correct them: <ul>$err</ul><a href=\"javascript:history.go(-1)\"><< Go Back</a>");

					die();

					include("templates/bottom.php");

				}

			// check to see if the name has already been taken

			$cQuery = @mysql_query("SELECT COUNT(pk_nId) FROM {$dbPrefix}_newsletters WHERE nName = '$name'");

			if(mysql_result($cQuery, 0, 0) == 0)
				{

					if($format != "html")
						$track = 0;

					if($freq3 == '4')
						{

							$freq2 = '4';
							$freq1 = 0;

						}

					$query = "INSERT INTO {$dbPrefix}_newsletters VALUES(0, '$name', '$desc', '$topicId', '$fromEmail', '$replyToEmail', $freq1, $freq2, '$format', '$type', $track, '$template')";

					$result = @mysql_query($query);

					$status = "";

					if($result)
						{

							$status = "Your newsletter template has been successfully saved to the database.<br><br>";

							$status .= "<a href='sendissue.php'>Send Newsletter</a> | <a href='newsletter.php'>Continue >></a>";

						}
					else
						{

							$status = "Some errors occured while trying to create this newsletter.<br><br>";

							$status .= "<a href='javascript:history.go(-1)'><< Go Back</a><br>&nbsp;";

						}

					MakeMsgPage('Create Newsletter', $status);

				}
			else
				MakeMsgPage('Create Newsletter', 'The name you have choosen for your newsletter is already taken by another newsletter template. Please return to the previous page and select another name for this template.<br><br><a href="javascript: history.go(-1);">&laquo; Return</a>');

		}

	function DeleteNewsletter()
		{

			global $dbPrefix;

			// This function will remove the selected templates and all newsletters that use this
			// template from the database

			doDbConnect();

			$nId = @$_POST["nId"];

			$query1 = "";

			$query2 = "";

			if(is_array($nId) == true)
				{

					// Templates have been chosen, run 2 delete queries

					$query1 = "DELETE FROM {$dbPrefix}_newsletters WHERE pk_nId = " . implode(" OR pk_nId = ", $nId);
					$query2 = "DELETE FROM {$dbPrefix}_issues WHERE iNewsletterId = " . implode(" OR iNewsletterId = ", $nId);
					$query3 = "DELETE FROM {$dbPrefix}_subscriptions WHERE sNewsletterId = " . implode(" OR sNewsletterId = ", $nId);

					if(@mysql_query($query1))
						$result1 = true;
					else
						$result1 = false;

					if(@mysql_query($query2))
						$result2 = true;
					else
						$result2 = false;

					if(@mysql_query($query3))
						$result3 = true;
					else
						$result3 = false;

					if($result1 && $result2 && $result3)
						{

							// Query executed OK

							$status = "You have successfully deleted one/more newsletters from the database.<br><br>";
							$status .= "<a href='sendissue.php'>Send Newsletter Issue</a> | <a href='newsletter.php'>Continue >></a>";

						}
					else
						{

							// Delete querie(s) failed

							$status = "An error occured while trying to delete the selected newsletter(s).<br><br>";
							$status .= "<a href='javascript:document.location.reload()'>Try Again</a>";

						}

				}
			else
				{

					// No templates have been chosen

					$status = "You didn't select one/more newsletters to delete.<br><br>";
					$status .= "<a href='javascript:history.go(-1)'>Try Again</a>";

				}

			MakeMsgPage('Delete Newsletter Template(s)', $status);

		}

	function ModifyNewsletter()
		{

			// Change the details of a template

			global $dbPrefix;

			$fileTypes = array("html", "htm");

			doDbConnect();

			$nId = @$_GET["nId"];

			$result = mysql_query("SELECT * FROM {$dbPrefix}_newsletters WHERE pk_nId = $nId");

			if($row = mysql_fetch_array($result))
				{

					?>

						<script language="JavaScript">

							function ShowFreq(data)
								{

									if(data == 'false')
										{

											document.frmNewsletter.freq1.disabled = true;
											document.frmNewsletter.freq2.disabled = true;

										}
									else
										{

											document.frmNewsletter.freq1.disabled = false;
											document.frmNewsletter.freq2.disabled = false;

										}

								}

							function CheckTemplate()
								{

									var frm = document.frmNewsletter;

									if(frm.template.disabled)
										frm.template.disabled = false;
									else
										frm.template.disabled = true;

								}

						</script>

						<?php MakeMsgPage('Modify Newsletter', 'Please complete the form below to modify the selected newsletter template. Click on the "Update Template" button to update the details of this template.', 0); ?>

							<tr>

								<td>

									<form action="newsletter.php" method="post" name="frmNewsletter">

									<input type="hidden" name="what" value="doModify">

									<input type="hidden" name="nId" value="<?php echo $nId; ?>">

									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

										<tr>

											<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												Newsletter Details

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

													<input type="text" name="name" size="40" value="<?php echo str_replace("\"", "'", $row["nName"]); ?>">

													<input type="hidden" name="origName" value="<?php echo str_replace("\"", "'", $row["nName"]); ?>">

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr bgcolor="#E7E8F5">

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Description</strong><br>

												</p>

											</td>

											<td width="75%">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<textarea name="desc" rows="5" cols="30"><?php echo $row["nDesc"]; ?></textarea>

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr>

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Topic</strong><br>

												</p>

											</td>

											<td width="75%" class="BodyText">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<select name="topicId" size="3" style="width: 196pt">

														<?php GetTopicList($row["nTopicId"]); ?>

													</select>

													<br><input type="text" name="newTopicId" size="40" value="[Enter New Topic Here]" onClick="if(this.value =='[Enter New Topic Here]') { this.value = ''; }">

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr bgcolor="#E7E8F5">

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>From Address</strong><br>

													What Is The Email Address That This Newsletter Will Be Sent From?

												</p>

											</td>

											<td width="75%" class="BodyText">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<input type="text" name="fromEmail" size="40" value="<?php echo $row["nFromEmail"]; ?>">

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr>

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Reply Address</strong><br>

												</p>

											</td>

											<td width="75%" class="BodyText">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<input type="text" name="replyToEmail" size="40" value="<?php echo $row["nReplyToEmail"]; ?>">

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr bgcolor="#E7E8F5">

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Newsletter Template</strong><br>

												</p>

											</td>

											<td width="75%" class="BodyText">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<select style="width: 261px;" size="4" name="template" <?php if($row['nTempFile'] == '') echo 'disabled'; ?>>

														<?php

															if ($handle = @opendir('newsletters/'))
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

																					?>

																						<option  <?php if($file == $row['nTempFile']) { echo 'selected'; $selected = true;} ?> value="<?php echo $file; ?>"><?php echo $file; ?></option>

																					<?php

																				}

																		}

																}

														?>

													</select>

													<br>

													<input type="checkbox" name="checkTemplate" onClick="CheckTemplate();" value="1" <?php if($row['nTempFile'] == '' || @$selected == false) echo 'checked'; ?>> No Template

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr>

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Frequency</strong><br>

													How Often Will This Newsletter Be Sent? Every...

												</p>

											</td>

											<td width="75%" class="BodyText">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<select name="freq1">

														<?php GetFrequencyList(1, $row["nFrequency1"]); ?>

													</select>

													<select name="freq2">

														<?php GetFrequencyList(2, $row["nFrequency2"]); ?>

													</select>

													<?php if($row["nFrequency2"] == 4) echo "<script>document.frmNewsletter.freq1.disabled = true;document.frmNewsletter.freq2.disabled = true;</script>"; ?>

													<input type="checkbox" name="freq3" value="4" <?php if($row["nFrequency2"] == 4) echo "checked"; ?> onClick="if(this.checked == true) ShowFreq('false'); else ShowFreq('true');"> No Sending Schedule (Whenever Required) <br>

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr bgcolor="#E7E8F5">

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Format</strong><br>

													Will This Newsletter Contain Plain-Text Or HTML?

												</p>

											</td>

											<td width="75%" class="BodyText">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<input type="radio" name="format" value="text" onClick="document.all.trackc.style.display = 'none';" <?php if($row["nFormat"] == "text") { echo " CHECKED "; } ?>> Plain-Text
													<input type="radio" name="format" value="html" onClick="document.all.trackc.style.display = 'inline';" <?php if($row["nFormat"] == "html") { echo " CHECKED "; } ?>> HTML

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr id="trackc" <?php if($row["nFormat"] == "text") { echo "style='display: none'"; }  ?>>

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Tracking</strong><br>

													Would you like to track your newsletters?

												</p>

											</td>

											<td width="75%" class="BodyText">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<input type="radio" name="track" value="1" <?php if($row["nTrack"] == 1) { echo " CHECKED "; } ?>> Yes
														<input type="radio" name="track" value="0" <?php if($row["nTrack"] == 0) { echo " CHECKED "; } ?>> No

												</p>

											</td>

											<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										</tr>

										<tr bgcolor="#E7E8F5">

											<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											<td width="25%" class="BodyText" valign="middle">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<strong>Status</strong><br>

													Should This Newsletter Be Visible To Subscribers, Or Private?

												</p>

											</td>

											<td width="75%" class="BodyText">

												<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

													<input type="radio" name="type" value="public" <?php if($row["nType"] == "public") { echo " CHECKED "; } ?>> Public
													<input type="radio" name="type" value="private" <?php if($row["nType"] == "private") { echo " CHECKED "; } ?>> Private

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

												<br>

													<input type="button" value="� Cancel" onClick="ConfirmCancel('newsletter.php')">

													<input type="submit" name="submit" value="Update Newsletter �">

												</span>

											</p>

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
			MakeMsgPage('Invalid newsletter Selected','The template that you have selected is either invalid or has been deleted from the database<br><br><a href="newsletter.php">Continue >></a>');

		}

	function ProcessModify()
		{

			global $dbPrefix;

			// Grab the details for the newsletter from the form, create the new
			// topic if necessary and workout whether to show a textbox or EWP control

			$name = @$_POST["name"];
			$origName = @$_POST["origName"];
			$desc = @$_POST["desc"];
			$topicId = @$_POST["topicId"];
			$newTopic = @$_POST["newTopicId"];
			$fromEmail = @$_POST["fromEmail"];
			$replyToEmail = @$_POST["replyToEmail"];
			if(@$_POST['checkTemplate'] == 1)
				$template = '';
			else
				$template = @$_POST['template'];
			$freq1 = @$_POST["freq1"];
			$freq2 = @$_POST["freq2"];
			$freq3 = @$_POST["freq3"];
			$format = @$_POST["format"];
			$nId = @$_POST["nId"];
			$type = @$_POST["type"];
			$track = @$_POST["track"];

			// Make sure all of the required form variables are complete

			$err = "";

			if($name == "")
				$err .= "<li>You forgot to enter a name for this newsletter</li>";

			if($desc == "")
				$err .= "<li>You forgot to enter a description for this newsletter</li>";

			if($topicId == "" && (trim($newTopic) == "" || $newTopic == "[Enter New Topic Here]"))
				$err .= "<li>You forgot to select a topic for this template</li>";

			if(!is_numeric(strpos($fromEmail, "@")) || !is_numeric(strpos($fromEmail, ".")))
				$err .= "<li>Please enter a valid 'From' email address</li>";

			if($replyToEmail != "" && $replyToEmail != "[None]")
				if(!is_numeric(strpos($replyToEmail, "@")) || !is_numeric(strpos($replyToEmail, ".")))
					$err .= "<li>Please enter a valid 'ReplyTo' email address</li>";

			if($replyToEmail == "[None]")
				$replyToEmail = "";

			doDbConnect();

			// Do we need to add a new topic to the topics table?

			if($topicId == "" || $newTopic != "" || $newTopic != "[Enter New Topic Here]")
				{

					$topicExists = @mysql_result(@mysql_query("SELECT count(*) FROM {$dbPrefix}_topics WHERE tName='$newTopic'"), 0, 0) > 0 ? true : false;

					if($topicExists == false && $newTopic != "" && $newTopic != "[Enter New Topic Here]")
						{

							$result = @mysql_query("INSERT INTO topics (tName) VALUES ('$newTopic')");
							$topicId = @mysql_insert_id();

						}

				}

			if($err != "")
				{

					MakeMsgPage('Modify Newsletter', "The form that you've just submitted is incomplete. Please review the errors below and then go back and correct them: <ul>$err</ul><a href=\"javascript:history.go(-1)\"><< Go Back</a>");

					include("templates/bottom.php");

					die();

				}

			$cQuery = @mysql_query("SELECT COUNT(pk_nId) FROM {$dbPrefix}_newsletters WHERE nName = '$name'");

			if($name == $origName || @mysql_result($cQuery, 0, 0) == 0)
				{

					if($format != "html")
						$track = '0';

					if($freq3 == '4')
						{

							$freq2 = $freq3;
							$freq1 = 0;

						}

					$query = "UPDATE {$dbPrefix}_newsletters SET nName='$name', nDesc='$desc', nTopicId=$topicId, nFromEmail='$fromEmail', nReplyToEmail='$replyToEmail', nFrequency1=$freq1, nFrequency2=$freq2, nFormat='$format', nType='$type', nTrack='$track', nTempFile = '$template' WHERE pk_nId=$nId";

					$result = @mysql_query($query);

					$status = "";

					if($result)
						{

							$status = "<br>Your newsletter template has been successfully modified.<br><br>";
							$status .= "<a href='sendissue.php'>Send Issue</a> | <a href='newsletter.php'>Continue >></a>";

						}
					else
						{

							$status = "<br>Some errors occured while trying to modify this newsletter.<br><br>";
							$status .= "<a href='javascript:history.go(-1)'><< Go Back</a><br>&nbsp;";

						}

					MakeMsgPage('Modify Newsletter', $status);

				}
			else
				MakeMsgPage('Modify Newsletter', 'The new name you have selected for your newsletter is already taken. Please return to the previous page and select another name.<br><br><a href="javascript: history.go(-1);">&laquo; Return</a>');

		}

	include("templates/bottom.php");

?>