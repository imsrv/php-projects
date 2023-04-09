<?php

	ob_start();
	error_reporting(0);

	require_once("../mwadmin/conf.php");
	require_once("../mwadmin/includes/functions.php");

	if(substr($siteURL, -1) == "/")
		$siteURL = substr($siteURL, 0, -1);

	// Which page are we displaying?
	$what = @$_GET["what"];

	switch($what)
		{

			case "subscribe":
				{

					TopTemplate();
					ShowNewUserScreen();
					BottomTemplate();
					break;

				}

			case "showarchive":
				{

					if($showArchive == 1)
						{

							TopTemplate();
							ProcessArchive();
							BottomTemplate();

						}
					else
						header("Location: index.php");
					break;

				}

			case "archive":
				{

					if($showArchive == 1)
						{

							TopTemplate();
							ShowArchive();
							BottomTemplate();

						}
					else
						header("Location: index.php");
					break;

				}

			case "unsubscribe":
				{

					TopTemplate();
					ShowUnsubscribeScreen();
					BottomTemplate();
					break;

				}

			case "doUn":
				{

					ProcessUnsubscribeEmail();
					break;

				}

			case "doUnsubscribe":
				{

					ProcessUnsubscribe();
					break;

				}

			case "processNew":
				{

					TopTemplate();
					ProcessSubscription();
					BottomTemplate();
					break;

				}

			case "privacy":
				{

					TopTemplate();
					ShowPrivacyPolicy();
					BottomTemplate();
					break;

				}

			case "confirm":
				{

					TopTemplate();
					ConfirmSubscription();
					BottomTemplate();
					break;

				}

			case "login":
				{

					TopTemplate();
					ShowLoginScreen();
					BottomTemplate();
					break;

				}

			case "processLogin":
				{

					ProcessLogin();
					break;

				}

			case "update":
				{

					TopTemplate();
					ShowUpdateForm();
					BottomTemplate();
					break;

				}

			case "updateDetails":
				{

					ProcessUpdate();
					break;

				}

			case "getPass":
				{

					TopTemplate();
					ShowGetPasswordScreen();
					BottomTemplate();
					break;

				}

			case "sendPass":
				{

					TopTemplate();
					SendPassword();
					BottomTemplate();
					break;

				}

			case "logout":
				{

					setcookie("mwAuth", true, time() - 10000);
					setcookie("mwEmail", true, time() - 10000);

					TopTemplate();
					ShowLogoutScreen();
					BottomTemplate();
					break;

				}

			default:
				{

					TopTemplate();
					ShowMainScreen();
					BottomTemplate();
					break;

				}

		}


	function ShowLogoutScreen()
		{

		// Let the user unsubscribe from his account

		global $siteName;
		global $siteURL;
		global $useTemplates;
		global $siteFolder;
		global $dbPrefix;


		$domain = "$siteURL/$siteFolder/index.php";

		$auth = @$_COOKIE["mwAuth"] == "" ? false : true;



		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		?>

			<tr>

				<td>

					<font face="Verdana" size="5" color="#00000"><b>Logout Successful</b></font>

					<font face="Verdana" size="2" color="#000000">

						<br><br>

						You have successfully logged out of our newsletter subscription system.

						<br><br>

						<a href="<?php echo $domain; ?>">Continue</a>

						<br>&nbsp;

					</font>

				</td>

			</tr>

		<?php



		echo "</table>";

	}

	function ProcessUnsubscribeEmail()

	{

		// Check if the user exists in the database and remove him

		global $siteName;
		global $siteURL;
		global $useTemplates;
		global $siteFolder;
		global $dbPrefix;

		$t = @$_GET['t'];

		$domain = "$siteURL/$siteFolder/index.php";

		if($t == '1' && base64_decode(@$_GET['c']) == @$_GET['email'])
			{

				$email = @$_GET['email'];
				$nId = @$_GET['nId'];

				doDbConnect();

				$result = mysql_query("SELECT * FROM {$dbPrefix}_subscribedusers WHERE suEmail='$email'");



				if($row = mysql_fetch_array($result))
					{

						// User exists in the database, remove him and his subscription details

						$suId = $row["pk_suId"];

						$query = "DELETE FROM {$dbPrefix}_subscriptions WHERE sSubscriberId = $suId AND sNewsletterId = $nId";



						if(@mysql_query($query))
							{

								// User was removed successfully

								TopTemplate();

								if(!$useTemplates)
									echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";
								else
									echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";

								?>

									<tr>

										<td>

											<font face="Verdana" size="5" color="#00000"><b>Subscription Cancelled</b></font>

											<font face="Verdana" size="2" color="#000000">

												<br><br>

												You have successfully been removed from the selected newsletter list. Your other subscriptions still remain.

												<br><br>

												<a href="<?php echo $domain; ?>">Continue</a> | <a href="<?php echo $domain; ?>?what=unsubscribe">Unsubscribe</a>

												<br>&nbsp;

											</font>

										</td>

									</tr>

								<?php

								BottomTemplate();

							}
						else
							{

								// An error occured while removing this user

								TopTemplate();

								if(!$useTemplates)
									echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";
								else
									echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";

								?>

									<tr>

										<td>

											<font face="Verdana" size="5" color="#00000"><b>An Error Occured</b></font>

											<font face="Verdana" size="2" color="#000000">

												<br><br>

												A database error occured while trying to remove you from our subscription database.

												Please click on the link below to try again.

												<br><br>

												<a href="javascript:document.location.reload()">Continue</a>

												<br>&nbsp;

											</font>

										</td>

									</tr>

								<?php

								BottomTemplate();

							}

					}
				else
					{

						// User doesn't exist in the database

						TopTemplate();

						if(!$useTemplates)
							echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";
						else
							echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";

						?>

							<tr>

								<td>

									<font face="Verdana" size="5" color="#00000"><b>User Not Found</b></font>

									<font face="Verdana" size="2" color="#000000">

										<br><br>

										A user with this email address and password combination does not exist in our subscription database.

										Please click on the link below to go back and try again.

										<br><br>

										<a href="javascript:history.go(-1)"><< Go Back</a>

										<br>&nbsp;

									</font>

								</td>

							</tr>

						<?php

						BottomTemplate();

					}

			}
		else
			{

				// User doesn't exist in the database

				TopTemplate();

				if(!$useTemplates)
					echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";
				else
					echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";

				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Internal Error</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								There was an internal error with your request. Please use the link below to return to the previous page.

								<br><br>

								<a href="javascript:history.go(-1)"><< Go Back</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php

				BottomTemplate();

			}

		echo "</table>";

	}

	function ProcessUnsubscribe()

	{

		// Check if the user exists in the database and remove him

		global $siteName;
		global $siteURL;
		global $useTemplates;
		global $siteFolder;
		global $dbPrefix;

		$domain = "$siteURL/$siteFolder/index.php";

		$email = @$_POST["email"];

		$password = @$_POST["password"];


		doDbConnect();


		$result = mysql_query("SELECT * FROM {$dbPrefix}_subscribedusers WHERE suEmail='$email' AND suPassword=password('$password')");



		if($row = mysql_fetch_array($result))

		{

			// User exists in the database, remove him and his subscription details

			$suId = $row["pk_suId"];

			$query1 = "DELETE FROM {$dbPrefix}_subscribedusers WHERE pk_suId = $suId";

			$query2 = "DELETE FROM {$dbPrefix}_subscriptions WHERE sSubscriberId = $suId";



			if(@mysql_query($query1) && @mysql_query($query2))

			{

				// User was removed successfully

				setcookie("mwAuth", true, time() - 10000);

				setcookie("mwEmail", true, time() - 10000);



				TopTemplate();



				if(!$useTemplates)

					echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

				else

					echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Subscription Cancelled</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								You have been removed from our subscription database successfully.

								<br><br>

								<a href="<?php echo $domain; ?>">Continue</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php



				BottomTemplate();

			}

			else

			{

				// An error occured while removing this user

				TopTemplate();



				if(!$useTemplates)

					echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

				else

					echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>An Error Occured</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								A database error occured while trying to remove you from our subscription database.

								Please click on the link below to try again.

								<br><br>

								<a href="javascript:document.location.reload()">Continue</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php



				BottomTemplate();

			}

		}

		else

		{

			// User doesn't exist in the database

			TopTemplate();



			if(!$useTemplates)

				echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

			else

				echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



			?>

				<tr>

					<td>

						<font face="Verdana" size="5" color="#00000"><b>User Not Found</b></font>

						<font face="Verdana" size="2" color="#000000">

							<br><br>

							A user with this email address and password combination does not exist in our subscription database.

							Please click on the link below to go back and try again.

							<br><br>

							<a href="javascript:history.go(-1)"><< Go Back</a>

							<br>&nbsp;

						</font>

					</td>

				</tr>

			<?php



			BottomTemplate();

		}



		echo "</table>";

	}



	function ShowUnsubscribeScreen()

	{

		// Let the user unsubscribe from his account

		global $siteName;
		global $siteURL;
		global $useTemplates;
		global $siteFolder;


		$domain = "$siteURL/$siteFolder/index.php";

		$auth = @$_COOKIE["mwAuth"] == "" ? false : true;



		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		?>

			<script language="JavaScript">



				function ConfirmCancel(CancelURL)

				{

				  if(confirm('WARNING: Are you sure you want to cancel what you are doing? Click OK to proceed.'))

					  document.location.href = CancelURL;

				}



			</script>



			<form action="<?php echo $domain; ?>?what=doUnsubscribe" method="post">

			<tr>

				<td>

					<font face="Verdana" size="5" color="#00000"><b>Unsubscribe</b></font>

					<font face="Verdana" size="2" color="#000000">

						<br><br>

						Please enter your email address and password in the fields below and then click on the "unsubscribe" button.

						You will be removed from the <?php echo $siteName; ?> newsletter subscription database.

						<a href="<?php echo $domain; ?>?what=getPass">Click here</a> if you have forgotten your password and would like it emailed to you.

						<br><br>

						<table width="100%" border="0" cellspacing="0" cellpadding="1">

							<tr>

								<td width="25%">

									<font face="Verdana" size="2" color="#000000">Email Address:</font>

								</td>

								<td width="75%">

									<input type="text" name="email" size="30">

								</td>

							</tr>

							<tr>

								<td width="25%">

									<font face="Verdana" size="2" color="#000000">Password:</font>

								</td>

								<td width="75%">

									<input type="password" name="password" size="30">

								</td>

							</tr>

							<tr>

								<td width="25%">&nbsp;



								</td>

								<td width="75%">

									<input type="button" value="� Cancel" onClick="ConfirmCancel('<?php echo $domain; ?>')">

									<input type="submit" value="Unsubscribe �">

								</td>

							</tr>

						</table>

						<br>&nbsp;

					</font>

				</td>

			</tr>

			</form>

		<?php



		echo "</table>";

	}



	function ShowMainScreen()

	{

		// This function will display a simple menu that lets the user choose what to do

		global $siteName;
		global $siteURL;
		global $useTemplates;
		global $siteURL;
		global $showArchive;
		global $siteFolder;

		$domain = "$siteURL/$siteFolder/index.php";

		$auth = @$_COOKIE["mwAuth"] == "" ? false : true;

		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		?>

			<tr>

				<td>

					<font face="Verdana" size="5" color="#00000"><b><?php echo $siteName; ?> Newsletter Subscriptions</b></font>

					<font face="Verdana" size="2" color="#000000">

						<br>

						Hi, welcome to the <?php echo $siteName; ?> newsletter subscription page. Please choose an option:

						<br><br>

						<ul>

							<li><a href="<?php echo $domain; ?>?what=privacy">Our Privacy Policy</a></li>

							<?php if($auth == false) { ?>

								<li><a href="<?php echo $domain; ?>?what=subscribe">Subscribe</a></li>

							<?php } ?>

							<li><a href="<?php echo $domain; ?>?what=unsubscribe">Unsubscribe</a></li>

							<li><a href="<?php echo $domain; ?>?what=update">Update Preferences</a></li>

							<?php if($auth == false) { ?>

							<li><a href="<?php echo $domain; ?>?what=getPass">Retrieve Password</a></li>

							<?php } ?>

							<?php if($showArchive == 1) { ?>

								<li><a href="<?php echo $domain; ?>?what=archive">Newsletter Archive</a></li>

							<?php } ?>

							<?php if($auth == true) { ?>

								<li><a href="<?php echo $domain; ?>?what=logout">Logout</a></li>

							<?php } ?>

						</ul>

						<br>&nbsp;

					</font>

				</td>

			</tr>

		<?php



		echo "</table>";

	}



	function SendPassword()

	{

		// This function will email the user a new password and save it to the database

		global $siteName;
		global $siteURL;
		global $siteEmail;
		global $useTemplates;
		global $confirmEmail;
		global $siteFolder;
		global $dbPrefix;

		$domain = "$siteURL/$siteFolder/index.php";

		$email = @$_POST["email"];



		doDbConnect();



		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		// Does a user with this email address exist in the database?

		$result = mysql_query("SELECT * FROM {$dbPrefix}_subscribedusers where suEmail = '$email'");



		if($row = mysql_fetch_array($result))

		{

			// User exists in the database, set him a new password

			$randPass = GenerateRandomPassword();



			if(@mysql_query("update {$dbPrefix}_subscribedusers set suPassword = password('" . $randPass . "') where suEmail = '$email'"))

			{

				// Users password was updated OK, email the user

				$mailMsg = $confirmEmail;

				//"Hi,\r\nYour password to manage your newsletter subscriptions at $siteName has been changed and is shown below:\r\n\r\nEmail: $email\r\nNew Password: $randPass\r\n\r\nPlease visit $siteURL/$siteFolder/index.php?what=login to login to your account and update your subscription preferences.\r\n\r\nThanks,\r\nThe $siteName Team\r\n$siteURL";

				$mailMsg = PerTags($mailMsg, true, $row[0], $email);

				$mailMsg = str_replace("mwsubscribe", $siteFolder, $mailMsg);
				$mailMsg = str_replace("%%sub_folder%%", $siteFolder, $mailMsg);
				$mailMsg = str_replace("%%pass%%", $randPass, $mailMsg);
				$mailMsg = str_replace('\r', "\r", str_replace('\n', "\n", $mailMsg));

				$headers = MakeHeader($siteEmail, 'text', $siteEmail);

				if(@mail($email, "Password For $siteName Newsletter Subscriptions", $mailMsg, $headers))

				{

					// The email was sent OK

					?>

						<tr>

							<td>

								<font face="Verdana" size="5" color="#00000"><b>Password Sent</b></font>

								<font face="Verdana" size="2" color="#000000">

									<br><br>

									A new password has been sent to your email address. Please check your email for this new password and

									your link to login and update your subscription preferences.

									<br><br>

									<a href="<?php echo $domain; ?>?what=login">Login</a>

									<br>&nbsp;

								</font>

							</td>

						</tr>

					<?php

				}

				else

				{

				// Couldnt send the email

				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Password Not Sent</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								An error occured while trying to send your password to your email account.

								<br><br>

								<a href="javascript:document.location.reload()">Try Again</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php

				}

			}

			else

			{

				// Couldnt update the users password

				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Password Not Sent</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								An error occured while trying to send your password to your email account.

								<br><br>

								<a href="javascript:document.location.reload()">Try Again</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php

			}

		}

		else

		{

			// User doesn't exist in the database

			?>

				<tr>

					<td>

						<font face="Verdana" size="5" color="#00000"><b>User Not Found</b></font>

						<font face="Verdana" size="2" color="#000000">

							<br><br>

							A subscriber account with this email address was not found in our database. Please use

							the link below to try again.

							<br><br>

							<a href="<?php echo $domain; ?>?what=getPass">Try Again</a>

							<br>&nbsp;

						</font>

					</td>

				</tr>

			<?php

		}



		echo "</table>";

	}



	function ShowGetPasswordScreen()

	{

		// Send the user their password via email

		global $useTemplates, $siteURL, $siteFolder;

		$domain = "$siteURL/$siteFolder/index.php";



		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		?>



			<script language="JavaScript">



				function ConfirmCancel(CancelURL)

				{

				  if(confirm('WARNING: Are you sure you want to cancel what you are doing? Click OK to proceed.'))

					  document.location.href = CancelURL;

				}



			</script>



			<form action="<?php echo $domain; ?>?what=sendPass" method="post">

			<tr>

				<td>

					<font face="Verdana" size="5" color="#00000"><b>Password Retrieval</b></font>

					<font face="Verdana" size="2" color="#000000">

						<br><br>

						Please enter your email address in the field below and then click on the "retrieve password" button.

						A new password will be emailed to you within 2-3 minutes.

						<br><br>

						<table width="100%" border="0" cellspacing="0" cellpadding="1">

							<tr>

								<td width="25%">

									<font face="Verdana" size="2" color="#000000">Email Address:</font>

								</td>

								<td width="75%">

									<input type="text" name="email" size="30">

								</td>

							</tr>

							<tr>

								<td width="25%">&nbsp;



								</td>

								<td width="75%">

									<input type="button" value="� Cancel" onClick="ConfirmCancel('<?php echo $domain; ?>')">

									<input type="submit" value="Retrieve Password �">

								</td>

							</tr>

						</table>

						<br>&nbsp;

					</font>

				</td>

			</tr>

			</form>

		<?php



		echo "</table>";

	}



	function ProcessUpdate()

	{

		// Update the users details and subscription preferences

		global $siteName;
		global $siteURL;
		global $fName;
		global $email;
		global $useTemplates;
		global $siteFolder;
		global $dbPrefix;


		$cEmail = @$_COOKIE["mwEmail"];

		$fName = @$_POST["fName"];

		$lName = @$_POST["lName"];

		$email = @$_POST["email"];

		$pass1 = @$_POST["pass1"];

		$tIds = @$_POST["templateId"];

		$updatePass = false;

		$result1 = false;

		$result2 = false;

		$sOK = true;

		$domain = "$siteURL/$siteFolder/index.php";



		doDbConnect();



		$err = "";

		if(!is_numeric(strpos($email, "@")) || !is_numeric(strpos($email, ".")))

		{

			$err .= "<li>You didn't enter a valid email address</li>";

		}

		else

		{

			// Make sure the user doesn't already exist in the database

			$numEmails = mysql_result(mysql_query("SELECT count(pk_suId) FROM {$dbPrefix}_subscribedusers WHERE suEmail = '$email'"), 0, 0);



			if($cEmail != $email && $numEmails > 0)

				$exists = true;



			if($exists == true)

				$err .= "<li>The selected email address is taken</li>";

		}



		if(strlen($pass1) > 0)

			$updatePass = true;



		if(!is_array($tIds))

			$err .= "<li>You forgot to select at least one newsletter to subscribe to</li>";

		//custom field checking

		$cust = mysql_query("SELECT * FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

		while($row = mysql_fetch_array($cust))
			{

				if($row[4] == '1')
					{

						switch($row[3])
							{

								case "textfield";
								case "textarea";
									if(@$_POST['cust_'.$row[2]] == '')
										$err .= "<li>You must provide a description for '{$row[1]}'</li>";
									if(strlen(@$_POST['cust_'.$row[2]]) > $row[7])
										$err .= "<li>Your description for '{$row[1]}' may only be {$row[7]} characters long. Please trim your description.</li>";
									break;

							}

					}

			}

		// Is there an error?

		if($err != "")

		{

			TopTemplate();



			if(!$useTemplates)

				echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

			else

				echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		?>

			<tr>

				<td>

					<font face="Verdana" size="5" color="#00000"><b>Newsletter Subscription Failed</b></font>

					<font face="Verdana" size="2" color="#000000">

						<br><br>

						Your subscription form appears to be incomplete/invalid. Please review the list of errors

						shown below and then click on the link below to go back and correct them:

						<ul><?php echo $err; ?></ul>

						<p style="margin-left:5">

						<a href="javascript:history.go(-1)"><< Go Back</a>

						<br>&nbsp;

					</font>

				</td>

			</tr>

		<?php

			BottomTemplate();

		}

		else

		{

			// No error, update the users details and preferences

			// Get the users ID

			$sResult = mysql_query("SELECT pk_suId FROM {$dbPrefix}_subscribedusers WHERE suEmail = '$cEmail'");

			if($sRow = mysql_fetch_row($sResult))

				$suId = $sRow[0];

			else

				$suId = -1;

			$query  = "UPDATE {$dbPrefix}_subscribedusers SET ";
			$query .= "suEmail = '$email'";

			$cust = mysql_query("SELECT * from {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

			while($row = mysql_fetch_array($cust))
				$query .= ", su_cust_{$row[2]} = '" . @$_POST['cust_'. $row[2]] . "'";

			if($updatePass == true)
				$query .= ", suPassword = password('$pass1')";

			$query .= ", suDateSubscribed = suDateSubscribed WHERE pk_suId = $suId";



			if(@mysql_query($query))
				$result1 = true;
			else
				$result1 = false;

			// Build the query for the subscriptions

			@mysql_query("DELETE FROM {$dbPrefix}_subscriptions WHERE sSubscriberId = $suId");



			for($i = 0; $i < sizeof($tIds); $i++)

			{

				if(!mysql_query("INSERT INTO {$dbPrefix}_subscriptions VALUES (0, {$tIds[$i]}, $suId)"))

					$sOK = false;

			}



			if($result1 == true && $sOK == true)

			{

				// Everything was updated OK, change the cookie

				setcookie("mwEmail", $email);



				TopTemplate();



				if(!$useTemplates)

					echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

				else

					echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Subscription Details Updated!</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								Your subscription details have been updated successfully.

								<br><br>

								<a href="<?php echo $domain; ?>?what=logout">Logout</a> |

								<a href="<?php echo $domain; ?>">Continue</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php



				BottomTemplate();

			}

			else

			{

				// An error occured while trying to update the details

				TopTemplate();



				if(!$useTemplates)

					echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

				else

					echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";

				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Subscription Details Not Updated</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								An error occured while trying to update your subscription details.

								<br><br>

								<a href="javascript:document.location.reload()">Try Again</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php



				BottomTemplate();

			}

		}



		echo "</table>";

	}



	function ShowUpdateForm()

	{

		// Show the form to update the users subscription details

		global $useTemplates;
		global $topTemplate;
		global $bottomTemplate;
		global $siteURL;
		global $siteFolder;
		global $dbPrefix;


		$auth = @$_COOKIE["mwAuth"];

		$email = @$_COOKIE["mwEmail"];

		$domain = "$siteURL/$siteFolder/index.php";



		// Display the form listing all newsletters, etc

		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		if($auth == true)

		{

			// User is logged in, show their subscription preferences

			doDbConnect();



			$result1 = mysql_query("SELECT * FROM {$dbPrefix}_subscribedusers WHERE suEmail = '$email'");



			if($row1 = mysql_fetch_array($result1))

			{

				// Get the users subscription preferences

				$sId = $row1["pk_suId"];

				$fName = $row1["suFName"];

				$lName = $row1["suLName"];

				$email = $row1["suEmail"];

				$password = $row1["suPassword"];

				$arrTIds = array();

				$result2 = mysql_query("SELECT * FROM {$dbPrefix}_subscriptions WHERE sSubscriberId = $sId");

				while($row2 = mysql_fetch_row($result2))
					$arrTIds[] = $row2[1];

				?>

					<script language="JavaScript">

						function ConfirmCancel(CancelURL)

						{

						  if(confirm('WARNING: Are you sure you want to cancel what you are doing? Click OK to proceed.'))

							  document.location.href = CancelURL;

						}



					</script>



					<form action="<?php echo $domain; ?>?what=updateDetails" method="post">

						<tr>

							<td>

								<font face="Verdana" size="4" color="#00000"><b>Your Subscription Details</b></font>

								<font face="Verdana" size="2" color="#000000">

								<br>

								Fields marked with a * are required.

								<br><br>

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

									<tr>

										<td width="25%">

											<font face="Verdana" size="2" color="#000000">*Email Address:</font>

										</td>

										<td width="75%">

											<input type="text" name="email" size="30" value="<?php echo $email; ?>">

										</td>

									</tr>

									<tr>

										<td width="25%">

											<font face="Verdana" size="2" color="#000000">New Password:</font>

										</td>

										<td width="75%">

											<input type="password" name="pass1" size="30"><br>

											<font face="Verdana" size="1" color="#000000"><i>[Leave blank to keep current password]</i></font>

										</td>

									</tr>

									<?php

										$query = mysql_query("SELECT * FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

										while($row = mysql_fetch_array($query))
											{

												?>

													<tr>

														<td width="25%">

															<font face="Verdana" size="2" color="#000000" title="<?php echo $row['cfDescription']; ?>"><?php if($row[4] == '1') echo "*"; echo $row[1]; ?>:</font>

														</td>

														<td width="75%">

															<?php

																switch($row[3])
																	{

																		case"textfield";
																			$max = ($row[7] != '0' ? $row[7] : '');
																			$size = ($max < 30) ? $max + 1 : 30;
																			echo "<input title='{$row['cfDescription']}' name='cust_{$row[2]}' size='$size' value='{$row1['su_cust_'.$row[2]]}' maxlength='$max'>";
																			break;

																		case "textarea";
																			echo "<textarea title='{$row['cfDescription']}' name='cust_{$row[2]}' cols='40' rows='6'>{$row1['su_cust_'.$row[2]]}</textarea>";
																			break;

																		case "yes/no";
																			$yes = ($row1['su_cust_'.$row[2]] == 1 ? "checked" : '');
																			$no = ($row1['su_cust_'.$row[2]] == 0 ? "checked" : '');
																			echo "<font face='Verdana' size='2' color='#000000' title='{$row['cfDescription']}'>";
																			echo "<input $yes type='radio' value='1' name='cust_{$row[2]}'> Yes ";
																			echo "<input $no type='radio' name='cust_{$row[2]}' value='0'> No</font>";
																			break;

																		case "dropdown";
																			echo "<select title='{$row['cfDescription']}' name='cust_{$row[2]}'>";

																			if($row[4] == '0')
																				echo "<option value=0>Please Select One</option>";

																			$options = explode(",", $row[6]);

																			for($i = 1; $i <= sizeof($options); $i++)
																				if($row1['su_cust_'.$row[2]] == $i)
																					echo "<option selected value=$i>{$options[$i - 1]}</option>";
																				else
																					echo "<option value=$i>{$options[$i - 1]}</option>";

																			echo "</select>";
																			break;

																	}

															?>

														</td>

													</tr>

												<?php

											}

									?>

								</table>

								<br>

								<font face="Verdana" size="4" color="#00000"><b>Newsletter Subscriptions</b></font>

								<br><br>

								<?php



									$result = mysql_query("SELECT * FROM {$dbPrefix}_topics ORDER BY tName ASC");



									while($row = mysql_fetch_row($result))

									{

										$nResult = mysql_query("SELECT pk_nId, nName, nDesc, nFrequency1, nFrequency2, nFormat FROM {$dbPrefix}_newsletters WHERE nType = 'public' and nTopicId = " . $row[0]);



										if(mysql_num_rows($nResult) > 0)

										{

											echo "<b>&nbsp;&nbsp;&nbsp;<img src='$siteURL/$siteFolder/images/arrow.gif'> " . $row[1] . "</b><br><br>";

											echo "<p style='margin-left:25'>";



											while($nRow = mysql_fetch_row($nResult))

											{

											?>

												<input type="checkbox" <?php if(in_array($nRow[0], $arrTIds)) { echo " CHECKED "; } ?> name="templateId[]" value="<?php echo $nRow[0]; ?>">

												<font color="#183863"><b><i><?php echo $nRow[1]; ?>:</i></b><br></font>

												<font face="Verdana" size="1" color="#808080">

													<b>Format:</b>

													<?php

														if($nRow[4] < 4)
															{

																echo $nRow[5]; ?> | <b>Frequency:</b> Every <?php echo $nRow[3];


																switch($nRow[4])

																{

																	case 1:

																		echo " Day(s)";

																		break;

																	case 2:

																		echo " Week(s)";

																		break;

																	case 3:

																		echo " Month(s)";

																		break;

																}

															}
														else
															echo "No Sending Schedule"


													?>

												</font>

												<br><br>

												<?php echo $nRow[2]; ?>

												<br><br>

											<?php

											}

											echo "</p>";

										}

									}

								?>

								<input type="button" value="� Cancel" onClick="ConfirmCancel('<?php echo $domain; ?>')">

								<input type="submit" name="submit" value="Update Subscription Details �">

							</font>

							<br>&nbsp;

						</td>

					</tr>

				</form>

				</table>

				<?php

			}

			else

			{

				// User no longer exists in the database

				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Subscription Details Not Found</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								Your subscription details were not found in our database.

								<br><br>

								<a href="<?php echo $domain; ?>?what=login">Login</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php

			}

		}

		else

		{

			// User hasn't logged in yet

			?>

				<tr>

					<td>

						<font face="Verdana" size="5" color="#00000"><b>Not Logged In</b></font>

						<font face="Verdana" size="2" color="#000000">

							<br><br>

							You must login before you can modify your newsletter subscription details. Please click on the link below to login.

							<br><br>

							<a href="<?php echo $domain; ?>?what=login">Login</a>

							<br>&nbsp;

						</font>

					</td>

				</tr>

			<?php

		}



		echo "</table>";

	}



	function ProcessLogin()

	{

		// This function will check if the user exists in the database and if so it will

		// set cookies for the users details and allow him to update his subscriptions

		global $useTemplates;
		global $topTemplate;
		global $bottomTemplate;
		global $siteURL;
		global $siteFolder;
		global $dbPrefix;

		$email = @$_POST["email"];

		$password = @$_POST["password"];

		$domain = "$siteURL/$siteFolder/index.php";

		doDbConnect();

		$result = mysql_query("SELECT * FROM {$dbPrefix}_subscribedusers WHERE suEmail='$email' AND suPassword = password('$password')");

		if($row = mysql_fetch_array($result))

		{

			if($row["suStatus"] == "subscribed")

			{

				// User exists, get his details and save them as cookies

				setcookie("mwAuth", true);

				setcookie("mwEmail", $email);

				TopTemplate();

				// Display the form listing all newsletters, etc

				if(!$useTemplates)

					echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

				else

					echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Login Successful</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								Thank you for logging in. Please click on the link below to manage your newsletter subscription details.

								<br><br>

								<a href="<?php echo $domain; ?>?what=update">Manage Subscription Details</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php

			}

			else

			{

				// This user hasn't clicked on the link in his confirmation email yet

				TopTemplate();

				// Display the form listing all newsletters, etc

				if(!$useTemplates)

					echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

				else

					echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";

				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Subscription Not Confirmed</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								You were sent a confirmation email for your newsletter subscription when you registered. You must read this email and

								click on the link in that email to confirm your subscription before you can login.

								<br><br>

								<a href="<?php echo $domain; ?>?what=login">Login</a> |

								<a href="<?php echo $domain; ?>">Signup Again</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php

			}

		}

		else

		{

			// User doesn't exist in the database

			TopTemplate();



			// Display the form listing all newsletters, etc

			if(!$useTemplates)

				echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

			else

				echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";

			?>

				<tr>

					<td>

						<font face="Verdana" size="5" color="#00000"><b>Login Failed</b></font>

						<font face="Verdana" size="2" color="#000000">

							<br><br>

							Your details were not found in our subscription database.

							<br><br>

							<a href="<?php echo $domain; ?>?what=subscribe">Become A Subscriber</a> |

							<a href="<?php echo $domain; ?>?what=getPass">Retrieve Password</a> |

							<a href="<?php echo $domain; ?>?what=login">Try Again</a>

							<br>&nbsp;

						</font>

					</td>

				</tr>

			<?php

		}

		echo "</table>";



		BottomTemplate();

	}



	function TopTemplate()

	{

		global $useTemplates;

		global $topTemplate;




		if($useTemplates == true)

		{

			if($fp = @fopen($topTemplate, "rb"))

			{

				while(!@feof($fp))

				{

					$tData .= fgets($fp, 4096);

				}



				@fclose($fp);

				echo $tData . "<br>";

			}

		}

	}



	function ShowLoginScreen()

	{

		// Show the login screen to let users manage their subscription preferences

		global $useTemplates, $siteURL, $siteFolder;

		$email = @$_GET['email'];

		$domain = "$siteURL/$siteFolder/index.php";



		// Display the form listing all newsletters, etc

		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		doDbConnect();



		?>



			<script language="JavaScript">



				function ConfirmCancel(CancelURL)

				{

				  if(confirm('WARNING: Are you sure you want to cancel what you are doing? Click OK to proceed.'))

					  document.location.href = CancelURL;

				}



			</script>



			<form action="<?php echo $domain; ?>?what=processLogin" method="post">

			<tr>

				<td>

					<font face="Verdana" size="5" color="#00000"><b>Newsletter Login</b></font>

					<font face="Verdana" size="2" color="#000000">

						<br><br>

						Please enter your email address and password in the fields below to login and update your newsletter

						subscription information. If you have forgotten your password please <a href="<?php echo $domain;?>?what=getPass">click here</a>.

						<br><br>

						<table width="100%" border="0" cellspacing="0" cellpadding="0">

							<tr>

								<td width="25%">

									<font face="Verdana" size="2" color="#000000">Email Address:</font>

								</td>

								<td width="75%">

									<input type="text" name="email" size="30" value="<?php echo $email; ?>">

								</td>

							</tr>

							<tr>

								<td width="25%">

									<font face="Verdana" size="2" color="#000000">Password:</font>

								</td>

								<td width="75%">

									<input type="password" name="password" size="30">

								</td>

							</tr>

							<tr>

								<td width="25%">&nbsp;



								</td>

								<td width="75%">

									<input type="button" value="� Cancel" onClick="ConfirmCancel('<?php echo $domain; ?>')">

									<input type="submit" name="submit" value="Login �">

								</td>

							</tr>

						</table>

					</font>

				</td>

			</tr>

		</table>

		</form>

		<?php

	}



	function ConfirmSubscription()

	{

		global $useTemplates, $siteURL, $siteFolder, $dbPrefix;

		$domain = "$siteURL/$siteFolder/index.php";

		// Display the form listing all newsletters, etc

		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		$suId = @$_GET["suId"];



		doDbConnect();



		if(is_numeric($suId))

		{

			// Update the subscribedUsers table

			if(@mysql_query("UPDATE {$dbPrefix}_subscribedusers SET suStatus = 'subscribed' WHERE pk_suId = $suId"))

			{

				// Update was successful

				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Subscription Updated Successful</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								Thank you for confirming your subscription to our newsletter. You will now receive your chosen newsletter(s)

								when appropriate. You can manage your subscription details and preferences by logging into your account using

								the link below:

								<br><br>

								<a href="<?php echo $domain; ?>?what=login">Login To Manage Subscription Details</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php

			}

			else

			{

				// Update failed

				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Subscription Updated Failed</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								An error occured while trying to confirm your subscription status. Please click on the

								link below to tryin again.

								<br><br>

								<a href="javascript:document.location.reload()">Try Again</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php

			}

		}

		else

		{

			// Invalid subscribed ID

			?>

				<tr>

					<td>

						<font face="Verdana" size="5" color="#00000"><b>Invalid Subscriber ID</b></font>

						<font face="Verdana" size="2" color="#000000">

							<br><br>

							The selected subscribed ID is invalid.

							<br>&nbsp;

						</font>

					</td>

				</tr>

			<?php

		}

		echo "</table>";

	}



	function ShowPrivacyPolicy()

	{

		global $useTemplates;
		global $privacyPolicyStmt;
		global $siteFolder;
		global $siteFolder;

		// Display the form listing all newsletters, etc

		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		?>

				<tr>

					<td>

						<font face="Verdana" size="5" color="#00000"><b>Our Privacy Policy</b></font>

						<br><br>

						<font face="Verdana" size="2" color="#000000">

							<?php echo stripslashes(str_replace('\n', "", "$privacyPolicyStmt")); ?>

							<br><br>

							<a href="javascript:history.go(-1)"><< Go Back</a>

							<br>&nbsp;

						</font>

					</td>

				</tr>

			</table>

		<?php

	}



	function ShowNewUserScreen()

	{

		// Display the form listing all newsletters, etc

		global $useTemplates, $siteURL, $banning, $banIps, $siteEmail, $siteFolder, $dbPrefix;

		if($banning == '1')
			{

				$ip = $_SERVER['REMOTE_ADDR'];

				$ban = explode(" ", $banIps);

				foreach($ban as $key=>$value)
					{

						if($value != '')
							{

								$partIP = substr($ip, 0, strlen($value));

								if($partIP == $value)
									$deny = true;

							}

					}

				if($deny)
					{

						if(!$useTemplates)
							echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";
						else
							echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";

						?>

								<tr>

									<td>

										<font face="Verdana" size="5" color="#00000"><b>Newsletter Subscriptions</b></font>

										<br><br>

										<font face="Verdana" size="2" color="#000000">

											Sorry but the IP that your computer is using has currently been banned from signing up to this service.<br><br>

											If you feel that this has been a mistake, you can contact the <a href="mailto:<?php echo $siteEmail; ?>">administrator</a> regarding this problem.

											<br><br>

											<a href="javascript:history.go(-1)"><< Go Back</a>

											<br>&nbsp;

										</font>

									</td>

								</tr>

							</table>


						<?php

						BottomTemplate();

						exit;

					}

			}

		doDbConnect();

		if(substr($siteURL, -1) == "/")
			$siteURL = substr($siteURL, 0, -1);


		$domain = $siteURL . "/$siteFolder/index.php";



		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		?>



			<script language="JavaScript">



				function ConfirmCancel(CancelURL)

				{

				  if(confirm('WARNING: Are you sure you want to cancel what you are doing? Click OK to proceed.'))

					  document.location.href = CancelURL;

				}



			</script>



			<form action="<?php echo $domain; ?>?what=processNew" method="post">

				<tr>

					<td>

						<font face="Verdana" size="5" color="#00000"><b>Newsletter Subscriptions</b></font>

						<font face="Verdana" size="2" color="#000000">

							<br><br>

							To subscribe to one/more of our newsletters, please complete the form below, choosing which

							newsletter(s) you'd like to subscribe to. Once you've completed the form, click on the

							"Subscribe Now >>" button. You will receive an emailing containing a confirmation link. Simply

							click this link and you will be automatically subscribed to your selected newsletter(s).

							<br><br>

							<font face="Verdana" size="4" color="#00000"><b>Your Subscription Details</b></font>

							<br>

							Fields marked with a * are required.

							<br><br>

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								<tr>

									<td width="25%">

										<font face="Verdana" size="2" color="#000000">*Email Address:</font>

									</td>

									<td width="75%">

										<input type="text" name="email" size="30" value="<?php echo @$_GET['email']; ?>">

									</td>

								</tr>

								<tr>

									<td width="25%">

										<font face="Verdana" size="2" color="#000000">*Password:</font>

									</td>

									<td width="75%">

										<input type="password" name="pass1" size="30">

									</td>

								</tr>

								<tr>

									<td width="25%">

										<font face="Verdana" size="2" color="#000000">*Confirm Password:</font>

									</td>

									<td width="75%">

										<input type="password" name="pass2" size="30">

									</td>

								</tr>

								<?php

									$query = mysql_query("SELECT * FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

									while($row = mysql_fetch_array($query))
										{

											?>

												<tr>

													<td width="25%">

														<font face="Verdana" size="2" color="#000000" title="<?php echo $row['cfDescription']; ?>"><?php if($row[4] == '1') echo "*"; echo $row[1]; ?>:</font>

													</td>

													<td width="75%">

														<?php

															switch($row[3])
																{

																	case"textfield";
																		$max = ($row[7] != '0' ? $row[7] : '');
																		$size = ($max < 30) ? $max + 1 : 30;
																		echo "<input title='{$row['cfDescription']}' name='cust_{$row[2]}' size='$size' value='{$row[6]}' maxlength='$max'>";
																		break;

																	case "textarea";
																		echo "<textarea title='{$row['cfDescription']}' name='cust_{$row[2]}' cols='40' rows='6'></textarea>";
																		break;

																	case "yes/no";
																		echo "<font face='Verdana' size='2' color='#000000' title='{$row['cfDescription']}'><input checked type='radio' value='1' name='cust_{$row[2]}'> Yes <input type='radio' name='cust_{$row[2]}' value='0'> No</font>";
																		break;

																	case "dropdown";
																		echo "<select title='{$row['cfDescription']}' name='cust_{$row[2]}'>";

																		if($row[4] == '0')
																			echo "<option value=0>Please Select One</option>";

																		$options = explode(",", $row[6]);

																		for($i = 1; $i <= sizeof($options); $i++)
																			echo "<option value=$i>{$options[$i - 1]}</option>";

																		echo "</select>";
																		break;

																}

														?>

													</td>

												</tr>

											<?php

										}

								?>

							</table>

							<br>

							<font face="Verdana" size="4" color="#00000"><b>Newsletter Subscriptions</b></font>

							<br><br>

							<?php



								$result = mysql_query("SELECT * FROM {$dbPrefix}_topics ORDER BY tName ASC");

								$i = 0;

								while($row = mysql_fetch_row($result))

								{

									$nResult = mysql_query("SELECT pk_nId, nName, nDesc, nFrequency1, nFrequency2, nFormat FROM {$dbPrefix}_newsletters WHERE nType='public' and nTopicId = " . $row[0]);



									if(mysql_num_rows($nResult) > 0)

									{

										$i++;

										echo "<b>&nbsp;&nbsp;&nbsp;<img src='$siteURL/$siteFolder/images/arrow.gif'> " . $row[1] . "</b><br><br>";

										echo "<p style='margin-left:25'>";



										while($nRow = mysql_fetch_row($nResult))

										{

										?>

											<input type="checkbox" name="templateId[]" value="<?php echo $nRow[0]; ?>">

											<font color="#183863"><b><i><?php echo $nRow[1]; ?>:</i></b><br></font>

											<font face="Verdana" size="1" color="#808080">

												<b>Format:</b>

												<?php

													if($nRow[4] < 4)
														{

															echo $nRow[5]; ?> | <b>Frequency:</b> Every <?php echo $nRow[3];


															switch($nRow[4])

															{

																case 1:

																	echo " Day(s)";

																	break;

																case 2:

																	echo " Week(s)";

																	break;

																case 3:

																	echo " Month(s)";

																	break;

															}

														}
													else
														echo "{$nRow[5]} | <b>Frequency:</b> No Sending Schedule"


												?>


											</font>

											<br><br>

											<?php echo $nRow[2]; ?>

											<br><br>

										<?php

										}

										echo "</p>";

									}

								}

							?>

							<input type="button" value="� Cancel"  onClick="ConfirmCancel('<?php echo $domain; ?>')">

							<input type="submit" name="submit" value="Subscribe Now �" <?php if($i == 0) echo "disabled"; ?>>

						</font>

						<br>&nbsp;

					</td>

				</tr>

			</table>

		</form>

		<?php

	}

	function ShowArchive()

	{

		// Display the form listing all newsletters, etc

		global $useTemplates, $siteName, $siteURL, $siteFolder, $dbPrefix;

		doDbConnect();

		$domain = "$siteURL/$siteFolder/index.php";



		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		?>


				<tr>

					<td>

						<font face="Verdana" size="5" color="#00000"><b>Newsletter Archives</b></font>

						<font face="Verdana" size="2" color="#000000">

							<br><br>

							Below is a list of previously sent Newsletters that have now been added to this archive. You can view the previous newsletters by using the links below

							<br><br>

							<font face="Verdana" size="4" color="#00000"><b>Newsletters</b></font>

							<br><br>

							<?php



								$result = mysql_query("SELECT * FROM {$dbPrefix}_topics ORDER BY tName ASC");

								while($row = mysql_fetch_row($result))

								{

									$nResult = mysql_query("SELECT pk_nId, nName, nDesc, nFrequency1, nFrequency2, nFormat FROM {$dbPrefix}_newsletters WHERE nType='public' and nTopicId = " . $row[0]);

									if(mysql_num_rows($nResult) > 0)

									{

										echo "<b>&nbsp;&nbsp;&nbsp;<img src='$siteURL/$siteFolder/images/arrow.gif'> " . $row[1] . "</b><br><br>";

										echo "<blockquote>";



										while($nRow = mysql_fetch_row($nResult))

										{

										?>

											<font color="#183863"><b><i><?php echo $nRow[1]; ?></i></b></font>

											<br><br>

											<?php echo $nRow[2]; ?>

											<br><br>

											<blockquote>

											<?php

												$aQuery = mysql_query("SELECT * FROM {$dbPrefix}_issues WHERE iNewsletterId = '{$nRow[0]}' AND iStatus = 'sent'");

												if(mysql_num_rows($aQuery) == 0)

												{

													echo '[No Archived newsletters for this category]';

												}

												while($aRow = mysql_fetch_array($aQuery))

												{

													$title = $aRow[2];

													$title = str_replace("%%complete_name%%", "Sample Name", $title);
													$title = str_replace("%%first_name%%", "Sample", $title);
													$title = str_replace("%%last_name%%", "Name", $title);
													$title = str_replace("%%site_name%%", $siteName, $title);
													$title = str_replace("%%site_url%%", $siteURL, $title);
													$title = str_replace("%%email%%", "sample@yourdomain.com", $title);

													?>

														<a href="<?php echo $siteURL . '/' . $siteFolder; ?>/index.php?what=showarchive&nId=<?php echo $aRow[0]; ?>"><?php echo $title; ?></a><br>

													<?php

												}

											?>

											</blockquote>

										<?php

										}

										echo "</blockquote>";

									}

								}

							?>

							<a href="javascript: history.go(-1);">Go Back</a>

						</font>

					</td>

				</tr>

			</table>

		<?php

	}

	function ProcessArchive()

	{

		// Display the form listing all newsletters, etc

		global $useTemplates, $siteName, $siteURL, $siteFolder, $dbPrefix;

		doDbConnect();

		$domain = "$siteURL/$siteFolder/index.php";


		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";



		if(is_numeric($_GET['nId']))

		{

			$aQuery = mysql_query("SELECT * FROM {$dbPrefix}_issues WHERE pk_iId = '{$_GET['nId']}' AND iStatus = 'sent'");

			if(mysql_num_rows($aQuery))

			{

				$aRow = mysql_fetch_array($aQuery);

				$title = $aRow[2];

				$title = str_replace("%%complete_name%%", "Sample Name", $title);
				$title = str_replace("%%first_name%%", "Sample", $title);
				$title = str_replace("%%last_name%%", "Name", $title);
				$title = str_replace("%%site_name%%", $siteName, $title);
				$title = str_replace("%%site_url%%", $siteURL, $title);
				$title = str_replace("%%email%%", "sample@yourdomain.com", $title);

				$newsletter = $aRow[3];

				$newsletter = str_replace("%%complete_name%%", "Sample Name", $newsletter);
				$newsletter = str_replace("%%first_name%%", "Sample", $newsletter);
				$newsletter = str_replace("%%last_name%%", "Name", $newsletter);
				$newsletter = str_replace("%%site_name%%", $siteName, $newsletter);
				$newsletter = str_replace("%%site_url%%", $siteURL, $newsletter);
				$newsletter = str_replace("%%email%%", "sample@yourdomain.com", $newsletter);

				$tResult = mysql_query("SELECT nTopicId, nName, nFormat FROM {$dbPrefix}_newsletters where pk_nId = '{$aRow['iNewsletterId']}' ");

				$tResultName = mysql_result($tResult, 0, 1);
				$tResultId = mysql_result($tResult, 0, 0);

				$tFormat = mysql_result($tResult, 0, 2);

				$bResult = mysql_query("SELECT tName FROM {$dbPrefix}_topics WHERE pk_tId = '$tResultId'");

				$bResultName = mysql_result($bResult, 0, 0);

				if($tFormat == "text")
					$newsletter = nl2br($newsletter);

				?>


						<tr>

							<td>

								<font face="Verdana" size="5" color="#00000"><b>Newsletter Archives</b></font>

								<font face="Verdana" size="2" color="#000000">

									<br><br>

									<font face="Verdana" size="4" color="#00000"><b><?php echo $title; ?></b></font><br>
									<?php echo $bResultName; ?> > <?php echo $tResultName; ?>

									<br><hr>

									<?php echo $newsletter; ?>

									<hr><br>

									<a href="javascript: history.go(-1);">Continue</a>

								</font>

							</td>

						</tr>

					</table>

				<?php

			}

			else

			{

			?>

				<tr>

					<td>

						<font face="Verdana" size="5" color="#00000"><b>Newsletter Archives</b></font>

						<font face="Verdana" size="2" color="#000000">

							<br><br>

							The newsletter that you have selected no longer exists. Please use the bottom below to return to the archive page.

							<br><br>

							<a href="javascript: history.go(-1);">Go Back</a>

					</td>

				</tr>

			<?php

			}

		}

		else

		{

			//invalid

			?>

				<tr>

					<td>

						<font face="Verdana" size="5" color="#00000"><b>Newsletter Archives</b></font>

						<font face="Verdana" size="2" color="#000000">

							<br><br>

							The newsletter ID that you have provided is not valid. Please use the link below to try again.

							<br><br>

							<a href="javascript: history.go(-1);">Go Back</a>

					</td>

				</tr>

			<?php

		}

		echo "</table>";

	}

	function ProcessSubscription()

	{

		// Take the users details, validate them, and add them to the database

		global $siteName;

		global $siteURL;

		global $siteEmail;

		global $fName;

		global $email;

		global $useTemplates;

		global $confirmEmailNew;

		global $banning;

		global $banEmail;

		global $siteFolder;

		global $dbPrefix;

		$fName = @$_POST["fName"];

		$lName = @$_POST["lName"];

		$email = @$_POST["email"];

		$pass1 = @$_POST["pass1"];

		$pass2 = @$_POST["pass2"];

		$tIds = @$_POST["templateId"];

		if($banning == '1')
			{

				$ban = explode(" ", $banEmail);

				foreach($ban as $key=>$value)
					{

						if($value != '')
							{

								if(!is_numeric(strpos($value, "@")))
									{

										$domain = explode("@", $email);

										if($domain[1] == $value)
											$deny = true;

									}
								else
									{

										if($email == $value)
											$deny = true;

									}

							}

					}

				if($deny)
					{

						if(!$useTemplates)
							echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";
						else
							echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";

						?>

								<tr>

									<td>

										<font face="Verdana" size="5" color="#00000"><b>Newsletter Subscriptions</b></font>

										<br><br>

										<font face="Verdana" size="2" color="#000000">

											Sorry but the email address that you have entered has been banned from subscibing to this service.<br><br>

											If you feel that this has been a mistake, you can contact the <a href="mailto:<?php echo $siteEmail; ?>">administrator</a> regarding this problem.

											<br><br>

											<a href="javascript:history.go(-1)"><< Go Back</a>

											<br>&nbsp;

										</font>

									</td>

								</tr>

							</table>


						<?php

						exit;

					}

			}

		$domain = "$siteURL/$siteFolder/index.php";

		doDbConnect();



		$err = "";


		if(!is_numeric(strpos($email, "@")) || !is_numeric(strpos($email, ".")))

		{

			$err .= "<li>You didn't enter a valid email address</li>";

		}

		else

		{

			// Make sure the user doesn't already exist in the database

			$exists = mysql_result(mysql_query("SELECT count(pk_suId) FROM {$dbPrefix}_subscribedusers WHERE suEmail = '$email'"), 0, 0) > 0 ? true : false;

			if($exists == true)
				$err .= "<li>You are already subscribed to our newsletter(s)</li>";

		}


		if(strlen($pass1) < 5)

		{

			$err .= "<li>You must enter a password of at least 5 characters</li>";

		}

		else

		{

			if($pass1 != $pass2)

				$err .= "<li>Your passwords didn't match</li>";

		}



		if(!is_array($tIds))

			$err .= "<li>You forgot to select at least one newsletter to subscribe to</li>";



		if(!$useTemplates)

			echo "<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>";

		else

			echo "<table width='95%' align='center' border='0' cellspacing='0' cellpadding='0'>";

		//custom field checking

		$cust = mysql_query("SELECT * FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

		while($row = mysql_fetch_array($cust))
			{

				if($row[4] == '1')
					{

						switch($row[3])
							{

								case "textfield";
								case "textarea";
									if(@$_POST['cust_'.$row[2]] == '')
										$err .= "<li>You must provide a description for '{$row[1]}'</li>";
									if(strlen(@$_POST['cust_'.$row[2]]) > $row[7])
										$err .= "<li>Your description for '{$row[1]}' may only be {$row[7]} characters long. Please trim your description.</li>";
									break;

							}

					}

			}

		// Is there an error?

		if($err != "")

		{

		?>

			<tr>

				<td>

					<font face="Verdana" size="5" color="#00000"><b>Newsletter Subscription Failed</b></font>

					<font face="Verdana" size="2" color="#000000">

						<br><br>

						Your subscription form appears to be incomplete/invalid. Please review the list of errors

						shown below and then click on the link below to go back and correct them:

						<ul><?php echo $err; ?></ul>

						<p style="margin-left:5">

						<a href="javascript:history.go(-1)"><< Go Back</a>

						<br>&nbsp;

					</font>

				</td>

			</tr>

		<?php

		}

		else

		{

			// No error, add the user and his subscription preferences to the database

			$query  = "INSERT into {$dbPrefix}_subscribedusers ";
			$query .= "(suEmail, suPassword, suStatus";

			$cust = mysql_query("SELECT * FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

			while($row = mysql_fetch_array($cust))
				$query .= ", su_cust_{$row[2]}";

			$query .= ") VALUES ('$email', password('$pass1'), 'pending'";

			mysql_data_seek($cust, 0);

			while($row = mysql_fetch_array($cust))
				$query .= ", '" . @$_POST['cust_'. $row[2]] . "'";

			$query .= ")";

			if(@mysql_query($query))
				{

					$suId = mysql_insert_id();

					$failed = false;

					// Add the users subscription preferences to the subscriptions table

					for($i = 0; $i < sizeof($tIds); $i++)
						{

							if(!@mysql_query("INSERT INTO {$dbPrefix}_subscriptions VALUES (0, {$tIds[$i]}, $suId)"))
								$failed = true;

						}

					if($failed == true)
						{

							?>

								<tr>

									<td>

										<font face="Verdana" size="5" color="#00000"><b>Newsletter Subscription Failed</b></font>

										<font face="Verdana" size="2" color="#000000">

											<br><br>

											An error occured while trying to add you to our subscription list. Please click on the

											link below to try again:

											<br><br>

											<a href="javascript:document.location.reload()">Try Again</a>

											<br>&nbsp;

										</font>

									</td>

								</tr>

							<?php

						}

					$mailMsg = $confirmEmailNew;

					$mailMsg = PerTags($mailMsg, true, $suId, $email);

					$mailMsg = str_replace("mwsubscribe", $siteFolder, $mailMsg);
					$mailMsg = str_replace("%%sub_folder%%", $siteFolder, $mailMsg);
					$mailMsg = str_replace("%%i%%", $suId, $mailMsg);
					$mailMsg = str_replace("%%c%%", md5($suId), $mailMsg);
					$mailMsg = str_replace('\r', "\r", str_replace('\n', "\n", $mailMsg));

					$headers = MakeHeader($siteEmail, 'text', $siteEmail);

					if(mail($email, "$siteName Subscription Confirmation", $mailMsg, $headers))
						{

							// Email sent OK

							?>

								<tr>

									<td>

										<font face="Verdana" size="5" color="#00000"><b>Newsletter Subscription Successful!</b></font>

										<font face="Verdana" size="2" color="#000000">

											<br><br>

											Thank you for subscribing to our newsletter(s) <?php echo $fName; ?>. We have sent a confirmation email to <?php echo $email; ?>.

											You MUST click the link inside this email to confirm your subscription status, so please check your email in 2-3 minutes.

											<br><br>

											<a href="<?php echo $domain; ?>">Continue</a>

											<br>&nbsp;

										</font>

									</td>

								</tr>

							<?php

						}
					else
						{

							// Couldn't send email

							?>

								<tr>

									<td>

										<font face="Verdana" size="5" color="#00000"><b>Newsletter Subscription Failed</b></font>

										<font face="Verdana" size="2" color="#000000">

											<br><br>

											An error occured while trying to add you to our subscription list. Please click on the

											link below to try again:

											<br><br>

											<a href="javascript:document.location.reload()">Try Again</a>

											<br>&nbsp;

										</font>

									</td>

								</tr>

							<?php

						}

				}

			else

			{

				// An error occured while trying to subscribe this user

				?>

					<tr>

						<td>

							<font face="Verdana" size="5" color="#00000"><b>Newsletter Subscription Failed</b></font>

							<font face="Verdana" size="2" color="#000000">

								<br><br>

								An error occured while trying to add you to our subscription list. Please click on the

								link below to try again:

								<br><br>

								<a href="javascript:document.location.reload()">Try Again</a>

								<br>&nbsp;

							</font>

						</td>

					</tr>

				<?php

			}

		}



		echo "</table>";

	}



	function BottomTemplate()

	{

		global $useTemplates;

		global $bottomTemplate;

		if($useTemplates == true)

		{

			if(@$fp = @fopen($bottomTemplate, "rb"))

			{

				while(!@feof($fp))
					@$tData .= fgets($fp, 4096);

				@fclose($fp);

				echo $tData;

			}

		}

	}



?>