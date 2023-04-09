<?php

	/***************************************************\
	|													|
	|	MailWorks Professional							|
	|	Name: config.php								|
	|	Description: Allows you to setup and change		|
	|	the main prefrences of MailWorks Professional	|
	|													|
	\***************************************************/

	ob_start();

	include("templates/top.php");
	include_once("includes/functions.php");

	//make sure the user is loged in, if not show the login page


	if($isSetup == 1 && !in_array("config_view", $authLevel))
		{

			noAccess();
			exit;

		}

	$what = @$_POST["what"];

	if($what == "")
		$what = @$_GET["what"];

	//select what function to call

	switch($what)
		{

			case "save":
				SaveDetails();
				break;

			default:
				ShowConfigForm();
				break;

		}

	function ShowConfigForm()
		{

			// Show the configuration details from config.php

			include("conf.php");

			if(@$_SERVER["SERVER_NAME"] == "")
				$server = "http://www.youryourdomain.com";
			else
				$server = "http://" . $_SERVER["SERVER_NAME"];

			?>

				<script language="JavaScript">

					function toggleP()
						{

							if(document.all.pMenu.style.display == 'inline')
								{

									document.all.pMenu.style.display = 'none';
									document.all.pText.innerHTML = 'Subscription Page Templates »';

								}
							else
								{

									document.all.pMenu.style.display = 'inline';
									document.all.pText.innerHTML = '« Subscription Page Tempaltes';

								}

						}

					function EnableTemplates()
						{

							document.frmConfig.topTemplate.disabled = false;
							document.frmConfig.bottomTemplate.disabled = false;

						}

					function DisableTemplates()
						{

							document.frmConfig.topTemplate.disabled = true;
							document.frmConfig.bottomTemplate.disabled = true;

						}

				</script>

				<table width="95%" align="center" border="0" cellpadding="0" cellspacing="0">

					<tr>

						<td height="30">

							<span class="Info">

								<span class="MainHeading">Update Configuration</span>

								<br><br>Please complete the form below to update your configuration file.
								You can change database details and site settings, etc.
								Click on the "Save Changes" button when you're done.

								<br><br>

								<a style="cursor:hand" onClick="toggleP()"><u><span id="pText">Subscription Page Templates »</span></u></a>

								<br><br>

									<table style="display:none" width="95%" align="center" id="pMenu">

										<tr>

											<td>

												<span class="Info">

													When a user visits <?php echo $siteURL . '/' . $siteFolder; ?>/ they can subscribe to your newsletter through the
													MailWorksPro subscription manager page. By default this page has a plain white background, however if
													you have site templates and want to make this page look like the rest of your site, then enter the paths to
													your top and bottom templates in the "Subscription Page Templates" fields below.

													<br><br>

													You must specify the full URL to your site templates like this:

													<ul>

														<li>Top Template: http://www.youryourdomain.com/templates/mytop.php</li>

														<li>Bottom Template: http://www.youryourdomain.com/templates/mybottom.php</li>

													</ul>

												</span>

											</td>

										</tr>

									</table>

							</span>

						</td>

					</tr>

					<tr>

						<td>

							<form name="frmConfig" action="config.php" method="post">

							<input type="hidden" name="what" value="save">

								<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												Site Details

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Site Name</strong><br>

												Name of your web site.

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="siteName" size="40" value="<?php echo @$siteName; ?>">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Site URL</strong><br>

												For example: http://www.youryourdomain.com <em>(do not include a trailing forward slash)</em>

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="siteURL" size="40" value="<?php echo @$siteURL; ?>">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Subscription Folder</strong><br>

												The subscription folder. Defaults to mwsubscribe.

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="siteFolder" size="40" value="<?php echo @$siteFolder; ?>">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Document Root</strong><br>

												Path from your root directory to the MailWorks folder.

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="docRoot" size="40" value="<?php echo @$docRoot; ?>">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Admin Email Address</strong>

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="siteEmail" size="40" value="<?php echo @$siteEmail; ?>">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												MySQL Database Details

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Database Server</strong><br>

												Server name or IP address of your MySQL database server.

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="dbServer" size="40" value="<?php echo @$dbServer; ?>">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Database Username</strong><br>

												Your MySQL username to access the database.

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="dbUser" size="40" value="<?php echo @$dbUser; ?>">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Database Password</strong><br>

												Your MySQL password to access the database.

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="password" name="dbPass" size="40" value="<?php echo @$dbPass; ?>">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Database Name</strong><br>

												Name of your MySQL database.

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="dbName" size="40" value="<?php echo @$dbName; ?>">

												<?php // Stores the prefix data, as this WILL NOT BE CHANGED ?>

												<input type="hidden" name="dbPrefix" value="<?php echo @$dbPrefix; ?>">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												Miscellaneous

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Throttling</strong><br>

												Emails sent per hour. Set this to 0 for unlimited. 3600 equates to one email per second.

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input name="sendLimit" type="text" value="<?php if(@$sendLimit != '') echo $sendLimit; else echo "0"; ?>" size="4" maxlength="5"> Email(s) Per Hour

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Show Unsubscribe Links</strong><br>

												Show unsubscribe and change detail links at the bottom of your outgoing emails?

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="radio" name="showUnsubscribe" value="1" <?php if(@$showUnsubscribe == '1' || @$showUnsubscribe != '0') echo "checked"; ?>> Yes
												<input type="radio" name="showUnsubscribe" value="0" <?php if(@$showUnsubscribe == '0') echo "checked"; ?>> No

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Removed Unconfirmed Emails</strong><br>

												If, after this many days, the user has not confirmed their subscription, then they will be removed from your mailing list. Set to 0 for never.

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input name="delDays" type="text" value="<?php if(@$delDays != '') echo $delDays; else echo "10"; ?>" size="1" maxlength="2"> Days

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Delete Failing Emails</strong><br>

												Once you try and send a newsletter, a list of failed email addresses are flagged for those who the newsletter couldn't be sent to.
												If they fail twice, do you wish to remove them from your mailing list?

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="radio" name="delfailed" value="1" <?php if(@$delfailed == '1') echo "checked"; elseif(!isset($delfailed)) echo "checked"; ?>> Yes
												<input type="radio" name="delfailed" value="0" <?php if(@$delfailed == '0') echo "checked"; ?>> No

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												Banning

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Banning</strong><br>

												Check banned email and IP address lists (shown below) before allowing a user to subscribe?

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="radio" value="1" name="banning" <?php if(@$banning == '1') echo "checked"; ?>> On
												<input type="radio" value="0" name="banning" <?php if(@$banning == '0') echo "checked"; elseif(@$banning != '1') echo "checked"; ?>> Off

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Banned Email addresses: </strong><br>

												You can ban certain email addresses from subscribing to your newsletter.
												To ban a specific email address, enter the full address (such as user@yourdomain.com).
												<br><br>
												To ban all email addresses from a certain domain, simply enter the domain name
												(such as someyourdomain.com). Make sure you place a space between each banned email/host.

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<textarea name="banEmail" rows="8" style="width: 98%;"><?php echo @$banEmail; ?></textarea>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Banned IP's</strong><br>

												You can ban users from subscribing based on their IP address. Enter the complete IP address (such as 127.0.0.1), or use a partial IP address (such as 127.0.0).
												<br><br>
												Make sure you place a space between each IP address.

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<textarea name="banIps" rows="8" style="width: 98%;"><?php echo @$banIps; ?></textarea>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												Archives

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Show Archives</strong><br>

												Show previously sent newsletter issues (public view only) as an "archive" link from your subscription page?

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="radio" name="showArchive" value="1" <?php if(@$showArchive == '1') echo "checked"; elseif(@$showArchive =! '0') echo "checked"; ?>> Yes
												<input type="radio" name="showArchive" value="0" <?php if(@$showArchive == '0') echo "checked"; ?>> No

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												Backup

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Backup Tables</strong><br>

												Please select the database tables you would like to backup when you create a backup of your database.

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<select multiple name="backuptables[]" size="6" style="width: 265px">

												<?php

													$tables = mysql_list_tables($dbName);

													while($row = mysql_fetch_array($tables))
														{

															if(!@is_array($backuptable))
																$select = (preg_match("/^$dbPrefix/", $row[0])) ? true : false;
															else
																{

																	if(in_array($row[0], @$backuptable))
																		$select = true;
																	else
																		$select = false;

																}

															if($select)
																{

																	?>

																		<option value="<?php echo $row[0]; ?>" selected><?php echo $row[0]; ?></option>

																	<?php

																}
															else
																{

																	?>

																		<option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>

																	<?php

																}

														}

												?>

												</select>

												<br>

												Hold down <em>CTRL</em> to select more than one table

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												Subscription Page Templates

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Templates</strong><br>

												Would you like to specify the location of templates for your subscription page?

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input onClick="EnableTemplates()" type="radio" name="useTemplates" value="1" <?php if($useTemplates == true) { echo " CHECKED "; } ?>> Yes
												<input onClick="DisableTemplates()" type="radio" name="useTemplates" value="0" <?php if($useTemplates == false) { echo " CHECKED "; } ?>> No

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Top Template</strong><br>

												Provide the FULL path to your top template file.

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="topTemplate" size="40" value="<?php echo @$topTemplate; ?>" <?php if($useTemplates == false) { echo " DISABLED "; } ?>>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Bottom Template</strong><br>

												Provide the FULL path to your bottom template file.

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="bottomTemplate" size="40" value="<?php echo @$bottomTemplate; ?>" <?php if($useTemplates == false) { echo " DISABLED "; } ?>>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												Email Responses

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Retrive Password Email</strong><br>

												This email is sent when a user requests their subscription password. Tokens you can use include:

												<br><br>

												<em>%%site_name%%</em> Site Name<br>
												<em>%%email%%</em> Email of User<br>
												<em>%%pass%%</em> New Password<br>
												<em>%%site_url%%</em> Site URL<br>
												<em>%%sub_folder%%</em> Subscription Folder<br>

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<textarea style="width: 98%;" wrap="off" rows="8" name="confirmEmail"><?php echo stripslashes(str_replace('\r', "\r", str_replace('\n', "\n", $confirmEmail))); ?></textarea>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>New Subscription Confirmation Email</strong><br>

												Please note that the variables on the end of the URL must NOT be changed. Tokens you can use include:

												<br><br>

												<em>%%site_name%%</em> Site Name<br>
												<em>%%email%%</em> Email of User<br>
												<em>%%site_url%%</em> Site URL<br>
												<em>%%sub_folder%%</em> Subscription Folder<br>

												<?php ShowPerTags(0); ?>

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<textarea style="width: 98%;" wrap="off" rows="8" name="confirmEmailNew"><?php  echo stripslashes(str_replace('\r', "\r", str_replace('\n', "\n", $confirmEmailNew))); ?></textarea>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

												Policies

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td class="BodyText" colspan="2">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Privacy Policy</strong><br><br>

												<?php

													// Show an EWP control

													require_once("ew/class.editworks.php");

													$myEW = new EW;

													$myEW->HideDecreaseIndentButton();
													$myEW->HideIncreaseIndentButton();
													$myEW->HideAnchorButton();
													$myEW->HideMailLinkButton();
													$myEW->HideHelpButton();
													$myEW->HideFormatList();
													$myEW->HideStyleList();
													$myEW->HideForeColorButton();
													$myEW->HideBackColorButton();
													$myEW->HideTableButton();
													$myEW->HideFormButton();
													$myEW->HideImageButton();
													$myEW->HidePropertiesButton();
													$myEW->HideGuidelinesButton();
													//$myEW->DisableSourceMode();
													$myEW->DisablePreviewMode();
													$myEW->DisableImageUploading();
													$myEW->DisableImageDeleting();
													$myEW->DisableSingleLineReturn();
													$myEW->HideRemoveTextFormattingButton();
													$myEW->HideSuperScriptButton();
													$myEW->HideSubScriptButton();

													if(@$privacyPolicyStmt == "")
														$privacyPolicyStmt = "[Coming Soon]";

													$myEW->SetValue(stripslashes(str_replace('\n', '', @$privacyPolicyStmt)));

													$myEW->ShowControl('98%', 250, "ewp_images");

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

										<td colspan="4">

												<br>

												<input type="button" value="« Cancel" onClick="ConfirmCancel('config.php')">

												<input type="submit" name="submit" value="Save Changes »">

												<br><br>

										</td>

									</tr>

								</table>

							</span>

						</p>

					</td>

				</tr>

			</table>

		<?php

		}

	function SaveDetails()
		{

			// Get the config details from the form and save them to conf.php

			require_once("ew/class.editworks.php");

			global $isSetup;
			global $siteFolder;

			$oldFolder = $siteFolder;

			$siteName 			= @$_POST["siteName"];
			$siteURL 			= @$_POST["siteURL"];
			$siteEmail 			= @$_POST["siteEmail"];
			$docRoot 			= @$_POST["docRoot"];
			$siteFolder			= @$_POST["siteFolder"];

			$dbServer 			= @$_POST["dbServer"];
			$dbUser 			= @$_POST["dbUser"];
			$dbPass 			= @$_POST["dbPass"];
			$dbName 			= @$_POST["dbName"];
			$dbPrefix 			= @$_POST["dbPrefix"];

			$sendLimit			= @$_POST["sendLimit"]; // Throttling
			$delDays			= @$_POST["delDays"]; // # of days till delete subscribers because they are still pending
			$delfailed 			= @$_POST["delfailed"]; // when sending failed list, if they fail twice delete them from the list.
			$showUnsubscribe	= @$_POST["showUnsubscribe"];
			$banning 			= @$_POST["banning"];
			$banEmail 			= @$_POST["banEmail"];
			$banIps 			= @$_POST["banIps"];
			$showArchive 		= @$_POST["showArchive"];
			$backupTables 		= @$_POST["backuptables"];

			$useTemplates 		= @$_POST["useTemplates"] == "0" ? 0 : 1;
			$topTemplate 		= @$_POST["topTemplate"];
			$bottomTemplate 	= @$_POST["bottomTemplate"];

			$confirmEmail 		= @$_POST["confirmEmail"];
			$confirmEmailNew 	= @$_POST["confirmEmailNew"];

			$myEW = new EW;
			$privacyPolicyStmt = $myEW->GetValue(false);

			if($siteFolder != $oldFolder && $siteFolder != '')
				{

					//mwsubcribe has been renamed again

					if(@rename($_SERVER['DOCUMENT_ROOT'] . $docRoot . "/{$oldFolder}/", $_SERVER['DOCUMENT_ROOT'] . $docRoot . "/${siteFolder}/"))
						$folder = "The front end folder {$oldFolder} has been renamed to {$siteFolder}.";
					else
						$folder = "Unable to rename the folder {$oldFolder}. You will need to manually rename the folder.";

				}


			$err = "";

			// Start the error checking

			// Site Details

			if($siteName == "")
				$err .= "<li>You forgot to enter your web sites name</li>";

			if(!ereg("^https?://", $siteURL))
				$err .= "<li>You forgot to enter your web sites URL</li>";
			else
				$siteURL = ereg_replace("/$", "", $siteURL);

			if( !is_numeric(strpos($siteEmail, "@")) || !is_numeric(strpos($siteEmail, ".")) )
				$err .= "<li>You forgot to enter a vaild email address</li>";

			if($siteFolder == '')
				$err .= '<li>You forgot to enter a site folder name</li>';

			if($docRoot == '')
				$err .= '<li>You must provide a path from your document root to your MailWorks folder</li>';

			// DB Details

			if($dbServer == "")
				$err .= "<li>You forgot to enter the IP/host name of your MySQL server</li>";

			if($dbUser == "")
				$err .= "<li>You forgot to enter a valid username for your MySQL database</li>";

			if($dbName == "")
				$err .= "<li>You forgot to enter a valid MySQL database name</li>";

			// Misc

			if(sizeof($backupTables) == 0)
				$err .= "<li>You need to select at least on table to backup</li>";

			if(!is_numeric($sendLimit))
				$err .= "<li>Throttling  is not a valid number</li>";

			if(!is_numeric($delDays))
				$err .= "<li>The number of days to delete subscribers is not a valid number</li>";

			if($banning == 1 && empty($banEmail) && empty($banIps))
				$err .= "<li>There is no select email or ips to ban</li>";

			// Templates

			if($useTemplates == true)
				{

					if($topTemplate == "")
						$err .= "<li>You forgot to enter a path to your top template file</li>";

					if($bottomTemplate == "")
						$err .= "<li>You forgot to enter a path to your bottom template file</li>";

				}

			if($confirmEmail == "")
				$err .= "<li>You forgot to specify the default retrive password email</li>";

			if($confirmEmailNew == "")
				$err .= "<li>You forgot to specify the default subscription confirmation email</li>";

			if($privacyPolicyStmt == "")
				$err .= "<li>You forgot to enter a privacy statement</li>";

			if($err != "")
				{

					$content = "The form that you've just submitted is incomplete. Please review the errors below and then go back and correct them:";
					$content .= "<ul>$err</ul>";
					$content .= "<a href=\"javascript:history.go(-1)\"><< Go Back</a>";

					MakeMsgPage('Update Configuration', $content);

				}
			else
				{

					// Update the configuration file

					$confirmEmail = str_replace("\r", '', str_replace("\n", '\n', $confirmEmail));
					$confirmEmailNew = str_replace("\r", '', str_replace("\n", '\n', $confirmEmailNew));
					$privacyPolicyStmt = addslashes(str_replace("\r", '', str_replace("\n", '\n', $privacyPolicyStmt)));

					//Make the content for the confiration file

					$configFile  = "";
					$configFile .= "<?php\n\n";
					$configFile .= "\t// MailWorks Professional Configuration File\n";
					$configFile .= "\t// Last Modified: " . date("Y-m-d H:i:s") . "\n\n";

					$configFile .= "\t\$isSetup           = 1;\n";
					$configFile .= "\t\$mwp_ver           = '4.0';\n\n";

					$configFile .= "\t// Database Configuration\n";
					$configFile .= "\t\$dbName            = '" . $dbName . "'; // Database name\n";
					$configFile .= "\t\$dbServer          = '" . $dbServer . "'; // Database host. Most of the time it's 'localhost'\n";
					$configFile .= "\t\$dbUser            = '" . $dbUser . "'; // Database username\n";
					$configFile .= "\t\$dbPass            = '" . $dbPass . "'; // Database password\n";
				    $configFile .= "\t\$dbPrefix          = '" . $dbPrefix . "'; // Prefix for tables. Default: 'mwp'\n\n";

					$configFile .= "\t// Site Details\n";
					$configFile .= "\t\$siteName          = '" . $siteName . "'; // Name of the web site\n";
					$configFile .= "\t\$siteURL           = '" . $siteURL . "'; // Url of the web site\n";
					$configFile .= "\t\$siteEmail         = '" . $siteEmail . "'; // Email for logging, etc\n";
					$configFile .= "\t\$siteFolder        = '" . $siteFolder . "'; // name for mwsubscribe\n";
					$configFile .= "\t\$docRoot           = '" . $docRoot . "'; // path to mwadmin and mwsubscribe\n\n";

					$configFile .= "\t// Misc\n";
					$configFile .= "\t\$showArchive       = " . $showArchive . "; // Show the archive to the front end\n";
					$configFile .= "\t\$delfailed         = " . $delfailed . "; // Delete the email if it fails for a second time\n";
					$configFile .= "\t\$sendLimit         = " . $sendLimit . "; // Throttling: allows to slow down the sending of the emails for some servers\n";
					$configFile .= "\t\$showUnsubscribe   = " . $showUnsubscribe . "; // Show unsubscribe links at the bottom of each mailing for both txt and html emails\n";
					$configFile .= "\t\$delDays           = " . $delDays . "; // Number of days to delete subscribers if not confirmed subscription\n";
					$configFile .= "\t\$banning           = " . $banning . "; // Allow banning of ips/emails\n";
					$configFile .= "\t\$banEmail          = '" . $banEmail . "'; // an array of emails that have been disallowed to signup\n";
					$configFile .= "\t\$banIps            = '" . $banIps . "'; // an array of ips that have been disallowed to signup\n";

					$configFile .= "\t\$backuptable       = array(";

					for($i = 0; $i < sizeof($backupTables); $i++)
						{

							$comma = (sizeof($backupTables) == $i + 1) ? '' : ", ";

							$configFile .= "\"{$backupTables[$i]}\"{$comma}";

						}

					$configFile .= "); // an array of database tables that will be backed up when using the backup feature\n\n";

					$configFile .= "\t// Templates\n";
					$configFile .= "\t\$useTemplates      = " . $useTemplates . "; // Allow the front end to use templates\n";
					$configFile .= "\t\$topTemplate       = '" . $topTemplate . "'; // Path to TOP template file\n";
					$configFile .= "\t\$bottomTemplate    = '" . $bottomTemplate . "'; // Path to BOTTOM template file\n\n";

					$configFile .= "\t// Email Messages and Privacy Policy\n";
					$configFile .= "\t\$confirmEmail      = \"" . $confirmEmail . "\"; // Message subscriber receives when they retrive there password\n";
					$configFile .= "\t\$confirmEmailNew   = \"" . $confirmEmailNew . "\"; // Message subscriber receives when the join the newsletter\n";
					$configFile .= "\t\$privacyPolicyStmt = \"" . $privacyPolicyStmt . "\"; // The content for the privacy Policy\n\n";

					$configFile .= "?>";



					// Open the configuration file and save it

					if($fp = @fopen("conf.php", "w"))
						{

							if(@fputs($fp, $configFile))
								{

									// Config file updated OK

									$content = "Your MailWorksPro configuration file has been updated successfully.<br><br>";

									$content .= (isset($folder)) ?  $folder . "<br><br>" : "";

									$content .= "<a href=\"config.php\">Continue >></a>";

									MakeMsgPage('Update Configuration', $content);

								}
							else
								{

									// Couldnt write to the conf.php file

									$content = "An error occured while trying to write to mwadmin/conf.php. Make sure this file is
												has write permissions (CHMOD 757) and try again.
												<br><br>
												<a href=\"javascript:document.location.reload()\">Try Again</a>";

									MakeMsgPage('Update Configuration', $content);

								}

							@fclose($fp);

						}
					else
						{

							// Coudlnt open the conf.php file

							$content = "An error occured while trying to open admin/conf.php for writing. Please make sure that
										the file exists and that it has write permissions (CHMOD 757).
										<br><br>
										<a href=\"javascript:document.location.reload()\">Try Again</a>";

							MakeMsgPage('Update Configuration', $content);

						}

				}

		}

	include("templates/bottom.php");

?>