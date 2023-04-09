<?php

    ob_start();

    include(realpath("conf.php"));
    include(realpath("includes/functions.php"));

	$scriptName = @$_SERVER["SCRIPT_NAME"];

    // Do we need to get the security information?
    if($isSetup == 0)
    {

		header("Location: install.php");
	    
	}

	if($isSetup == 1 && file_exists('install.php'))
		{

			if(@$_GET['do'] == 'del')
				{

					if(!@unlink('install.php'))
						{

							?>

								<html>

									<body>

										<div align="center" style="font-family: verdana; font-size: 12px;">MailWorks Professional is unable to delete the '<b>install.php</b>' file from your server. <br>To continue using MailWorks Professional please remove this file manually via FTP.</div>

									</body>

								</html>

							<?php

							die();

						}

				}
			else
				{

					?>

						<html>

							<body>

								<div align="center" style="font-family: verdana; font-size: 12px;">The file '<b>install.php</b>' still exists. This is a security risk to MailWorks Professional and your server. <br>To continue using MailWorks Professional please delete this file by using the link below.<br><br><a href="<?php echo $_SERVER['PHP_SELF']; ?>?do=del">Delete File</a></div>

							</body>

						</html>

					<?php

					die();

				}

		}

	if($isSetup == 1  && isLoggedIn() == false && !is_numeric(strpos($scriptName, "login.php")))
		{

			?>

				<html>

					<head>

						<meta http-equiv="refresh" content="0; url=login.php">

					</head>

				</html>

			<?php

			die();

		}

	$sConn = @mysql_connect($dbServer, $dbUser, $dbPass) or die("Unable to connect to database server: Please ensure that you have the correct details in the conf.php file");
	$dConn = @mysql_select_db($dbName, $sConn) or die("Unable to select database from database server: Please ensure that you have the correct details in the conf.php file");

	if(@is_numeric(@$_COOKIE['uId']))
		{

			// A user is logged in

			$id = @$_COOKIE['uId'];

			$result = mysql_query("SELECT uPermissions FROM {$dbPrefix}_users WHERE pk_uid = '$id'");

			if($result)
				$authLevel = @explode(",", mysql_result($result, 0, 0));
			else
				$authLevel = array();

		}
	else
		$authLevel = array();

	?>

		<html>

        <head>

	        <title>:: MailWorksPro Administration Area ::</title>

	        <link rel="stylesheet" type="text/css" href="styles/styles.css">

			<script language="JavaScript">

				function handleError()
					{

						return true;

					}

				function ConfirmCancel(CancelURL)
					{

						if(confirm('WARNING: Are you sure you want to cancel what you are doing? Click OK to proceed.'))
							document.location.href = CancelURL;

					}

				function ConfirmStats()
					{

						if(confirm('WARNING: These stats are generated in real-time from the database, and as such may take anywhere from 5 seconds to 1 minute to generate, depending on the number of subscribers currently in your database.\r\n\r\nClick the OK button to continue.'))
							document.location.href = 'stats.php';

					}

				function ConfirmBackup()
					{

						if(confirm('WARNING: You are about to backup your entire database. When the next dialog window opens, choose the "Save As" option and save the file as "backup.php" on your hard drive. If you loose your database, you can then click on the "Restore Backup" link under the menu on the left to upload your saved backup.\r\n\r\nClick the OK button to continue.'))
							document.location.href = 'subscriber.php?what=backup';

					}

				window.onerror = handleError;

			</script>

	        </head>

	        <body background="images/bg.gif">

		        <a name="top"></a>

		        <div align="center">

					<table border="0" width="100%" cellspacing="0" cellpadding="0">

		 	           	<tr>

              				<td valign="top" background="images/topbg.gif"><img border="0" src="images/logo.jpg" width="292" height="115"></td>

				            <td width="70%" background="images/topbg.gif" valign="top" align="right"></td>

				            <td width="16" background="images/topbg.gif" align="right"><img border="0" src="images/topr.gif" width="10" height="115"></td>

						</tr>

					</table>

					<table border="0" width="100%" cellspacing="0" cellpadding="0">

						<tr>

							<td width="176" bgcolor="#CECFCE" valign="top" align="right"><img src="images/spacer.gif" border="0" width="176"><table border="0" cellspacing="0" cellpadding="0" width="150">

								<tr>

									<td width="100%" bgcolor="#E7E8F5" valign="top">

										<p style="margin: 10"><font size="1" face="Verdana">

											<?php if(sizeof($authLevel) == 0) { ?>

												Once you've logged in using the form on the right, you will
												be able to use the menu that will appear here.<br>

											<?php } else { ?>

												Use the menu below to create newsletters for <?php echo $siteName; ?>.<br><br>
												<input onClick="document.location.href='login.php?what=logout'" type="button" value="Logout Now" style="font-size: 8pt; font-family: Verdana; font-weight: normal">

											<?php } ?>

										</font></p>

									</td>

								</tr>

								<tr>

									<td width="100%" bgcolor="#787C9B" valign="middle" height="21">

										<p style="margin-left:10">

											<span class="MenuHeading">Home</span>

										</p>

									</td>

								</tr>

								<tr>

									<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

										<p class="BodyText" style="margin-left:10; margin-right:10">

											 · <a href="index.php">Home Page</a><br>

										</p>

									</td>

								</tr>

								<?php if(sizeof($authLevel) == 0) { ?>

									<tr>

										<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

											<p class="BodyText" style="margin-left:10; margin-right:10">

												· <a href="login.php">Login</a>

											</p>

										</td>

									</tr>

								<?php } ?>


								<?php if(in_array("config_view", $authLevel)) { ?>

									<tr>

										<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

											<p class="BodyText" style="margin-left:10; margin-right:10">

												· <a href="config.php">Update Configuration</a>

											</p>

										</td>

									</tr>

								<?php } ?>

								<?php if(in_array("subscribe_backup", $authLevel)) { ?>

									<tr>

										<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

											<p class="BodyText" style="margin-left:10; margin-right:10">

												· <a href="javascript:ConfirmBackup()">Backup</a><br>

											</p>

										</td>

									</tr>

									<tr>

										<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

											<p class="BodyText" style="margin-left:10; margin-right:10">

												· <a href="subscriber.php?what=restore">Restore Backup</a><br>

											</p>

										</td>

									</tr>

								<?php } 


											if(in_array("stats_view", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="stats.php">Stats</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(@is_numeric(@$_COOKIE['uId']))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="MailWorksSetupGuide.pdf" target="_blank">Help</a>

																</p>

															</td>

														</tr>

													<?php

												}



									if(sizeof($authLevel) > 0)
										{

											if(in_array("users_view", $authLevel) || in_array("users_add", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#787C9B" valign="middle" height="21">

																<p style="margin-left:10">

																	<span class="MenuHeading">Users</span>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("users_add", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="users.php?what=new">Create User</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("users_view", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="users.php">View Users</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("newsletters_view", $authLevel) || in_array("newsletters_add", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#787C9B" valign="middle" height="21">

																<p style="margin-left:10">

																	<span class="MenuHeading">Newsletters</span>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("newsletters_view", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="newsletter.php">View Newsletters</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("newsletters_template", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="newsletter.php?what=template">Manage Templates</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("newsletters_add", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="newsletter.php?what=new">Create New</a>

																</p>

															</td>

														</tr>

													<?php
												}

											if(in_array("issues_view", $authLevel) || in_array("issues_add", $authLevel) || in_array("issues_send", $authLevel) || in_array("issues_import", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#787C9B" valign="middle" height="21">

																<p style="margin-left:10">

																	<span class="MenuHeading">Issues</span>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("issues_view", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="issues.php">View Issues</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("issues_import", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="issues.php?what=import">Imported Issues</a>

																</p>

															</td>

														</tr>

													<?php

												}
											
											if(in_array("issues_add", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="issues.php?what=new">Create New</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("issues_send", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="sendissue.php">Send Issue</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("subscribe_view", $authLevel) || in_array("subscribe_import", $authLevel) || in_array("subscribe_export", $authLevel) || in_array("subscribe_backup", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#787C9B" valign="middle" height="21">

																<p style="margin-left:10">

																	<span class="MenuHeading">Subscribers</span>

																</p>

															</td>

														</tr>

													<?php

												}
											
											if(in_array("subscribe_view", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="subscriber.php">View Subscribers</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("subscribe_custom", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="subscriber.php?what=custom">Custom Fields</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("subscribe_import", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="subscriber.php?what=import">Import</a>

																</p>

															</td>

														</tr>

													<?php

												}
											
											if(in_array("subscribe_export", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="subscriber.php?what=export">Export</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("topics_view", $authLevel) || in_array("topics_add", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#787C9B" valign="middle" height="21">

																<p style="margin-left:10">

																	<span class="MenuHeading">Topics</span>

																</p>

															</td>

														</tr>

													<?php

												}
											
											if(in_array("topics_view", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="topic.php">View Topics</a>

																</p>

															</td>

														</tr>

													<?php

												}

											if(in_array("topics_add", $authLevel))
												{

													?>

														<tr>

															<td width="100%" bgcolor="#E7E8F5" valign="middle" height="21">

																<p class="BodyText" style="margin-left:10; margin-right:10">

																	· <a href="topic.php?what=new">Create New</a>

																</p>

															</td>

														</tr>

													<?php

												}

										}

								?>

								<tr>

									<td height="10" bgcolor="#E7E8F5"></td>

								</tr>

							</table>

						</td>

						<td bgcolor="#FFFFFF" valign="top">

							<a name="top"></a>