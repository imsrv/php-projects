<?php include("templates/top.php"); ?>
<?php include_once("includes/functions.php"); ?>
<?php

  $what = @$_POST["what"];
  
  if($what == "")
  $what = @$_GET["what"];
  
  switch($what)
  {
    case "new":
		if(in_array("users_add", $authLevel))
			ShowNewForm();
		else
			noAccess();
	  break;
	case "doNew":
		if(in_array("users_add", $authLevel))
			ProcessNew();
		else
			noAccess();
	  break;
	case "delete":
		if(in_array("users_delete", $authLevel))
	  		DeleteUsers();
		else
			noAccess();
	  break;
	case "modify":
		if(in_array("users_edit", $authLevel))
	  		ModifyUsers();
		else
			noAccess();
	  break;
	case "doModify":
		if(in_array("users_edit", $authLevel))
	  		ProcessUsers();
		else
			noAccess();
	  break;
	default:
		if(in_array("users_view", $authLevel))	
			ShowUserList();
		else
			noAccess();
	  break;
  }
  
  function ShowNewForm()
  {
	// Show the form to get the name of a new topic

	global $title;

	$content = "Please complete the form below to create a new user. Once created, this user will be able to login. His/her activities will be restricted by the permissions that you set below.<br><br>";

	MakeMsgPage("Create New User", $content, 0);

	?>

		<tr>

			<td>

				<form name="frmTopic" action="users.php" method="post">

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

								<strong>Username</strong><br>

							</p>

						</td>

						<td width="75%">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<input type="text" name="username" size="40">

							</p>

						</td>

						<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

					</tr>

					<tr bgcolor="#E7E8F5">

						<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

						<td width="25%" class="BodyText" valign="middle">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<strong>Password</strong><br>

							</p>

						</td>

						<td width="75%">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<input type="password" name="password" size="40">

							</p>

						</td>

						<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

					</tr>

					<tr>

						<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

						<td width="25%" class="BodyText" valign="middle">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<strong>Email Address</strong><br>

							</p>

						</td>

						<td width="75%">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<input type="text" name="email" size="40">

							</p>

						</td>

						<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

					</tr>

					<tr bgcolor="#E7E8F5">

						<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

						<td width="25%" class="BodyText" valign="middle">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<strong>First Name</strong><br>

							</p>

						</td>

						<td width="75%">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<input type="text" name="firstname" size="40">

							</p>

						</td>

						<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

					</tr>

					<tr>

						<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

						<td width="25%" class="BodyText" valign="middle">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<strong>Last Name</strong><br>

							</p>

						</td>

						<td width="75%">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<input type="text" name="lastname" size="40">

							</p>

						</td>

						<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

					</tr>

					<tr bgcolor="#E7E8F5">

						<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

						<td width="25%" class="BodyText" valign="top">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<strong>Permissions</strong><br>

								Defines what this user can and cannot access whey they login.

							</p>

						</td>

						<td width="75%" class="BodyText">

							<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

								<?php DisplayPermissions(); ?>

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

							<input type="button" value="� Cancel" onClick="ConfirmCancel('users.php')">
							<input type="submit" name="submit" value="Add User �">

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

		$username = @$_POST["username"];
		$password = @$_POST["password"];
		$email = @$_POST["email"];
		$firstname = @$_POST["firstname"];
		$lastname = @$_POST["lastname"];
				
		$err = "";
		
		// Has the user entered all of the required fields?
		if($username == "")
			$err .= "<li>You forgot to enter a username</li>";
		elseif(strlen($username) < 4 ||  strlen($username) > 20)
			$err .= "<li>Your username must be 4-20 characters long</li>";

		if($password == "")
			$err .= "<li>You forgot to enter a password</li>";
		elseif(strlen($password) < 4 ||  strlen($password) > 20)
			$err .= "<li>Your password must be 4-20 characters long</li>";

		if($email == "")
			$err .= "<li>You forgot to enter an email address</li>";

		if(!is_numeric(strpos($email, "@")) || !is_numeric(strpos($email, ".")))
			$err .= "<li>Please provide a vaild email</li>";

		if($firstname == "")
			$err .= "<li>You forgot to enter a first name</li>";

		if($lastname == "")
			$err .= "<li>You forgot to enter a last name</li>";

		if($err != "")
			MakeMsgPage('Create User', "The form that you've just submitted is incomplete. Please review the errors below and then go back and correct them: <ul>$err</ul><a href=\"javascript:history.go(-1)\"><< Go Back</a>");
		else
		{

			// Set the permissions up

			$perm = '';

			foreach($_POST as $key=>$value)
				{

					switch($key)
						{

							case "what";
							case "username";
							case "password";
							case "email";
							case "firstname";
							case "lastname";
								break;

							default;
								if(@$_POST[$key] != '')
									$perm .= "$key,";
								break;

						}

				}

			if(substr($perm, -1) == ",")
				$perm = substr($perm, 0, -1);

			// All of the fields were complete, save this user to the database

			$password = md5($password);



			$query = "INSERT INTO {$dbPrefix}_users VALUES (0, '$username', '$password', '$email', '$firstname', '$lastname', '$perm', now())";

			doDbConnect();

			if(@mysql_query($query))
				MakeMsgPage('Create User', "You have successfully created and saved a user. This user may now login to MailWorks.<br><br><a href=\"users.php\">Continue</a>");
			else
				MakeMsgPage('Create User', "There was a problem while trying to save the user data. Please try refreshing the page, or contact your administrator.<br><br><a href=\"users.php\">Continue</a>");
		}
  }
  
  function ShowUserList()
  {
	// Show a list of templates currently in the database

	global $dbPrefix;

	doDbConnect();

	$result = mysql_query("SELECT *, concat(uFirstName, ' ', uLastName) AS name FROM {$dbPrefix}_users ORDER BY name ASC");

	?>
		<script language="JavaScript">

			function CheckConfirmDelete()			
			{
				if(confirm('WARNING: You are about to permanently delete the selected users.'))
					return true;
				else
					return false;
			}
			
		</script>
			
		<form onSubmit="return CheckConfirmDelete()" action="users.php" method="post">
		<input type="hidden" name="what" value="delete">

		<?php MakeMsgPage('Users', "Current MailWorks admin users are listed below. These users have the ability to run MailWorks Professional. To add a new user, click on the \"Add User &raquo;\" link below. To remove one/more users, click the checkbox for that user and then click on the \"Delete Selected\" button."); ?>

		<table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">

			<tr>

				<td width="100%" colspan="6" height="25" class="Info">

					<a href="users.php?what=new"> Add User �</a>

				</td>

			</tr>

			<tr>

				<td width="100%" colspan="6" height="18" class="Info" align="right">

					Current Users: <?php echo mysql_num_rows($result); ?>
					<br>&nbsp;

				</td>

			</tr>

			<tr bgcolor="#787C9B">

				<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

				<td height="20" class="MenuHeading"></td>

				<td height="20" class="MenuHeading">
					Name
				</td>

				<td height="20" class="MenuHeading">
					Email
				</td>

				<td height="20" class="MenuHeading">
					Created
				</td>

				<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

			</tr>

			<?php
				
				if(mysql_num_rows($result) == 0)
					{

						?>

							<tr>

								<td width="1" bgcolor="#787C9B"></td>

								<td colspan="4" width="100%" height="25" class="Info">

									There are no users in the database.

								</td>

								<td width="1" bgcolor="#787C9B"></td>

							</tr>

						<?php

					}
					
				while($row = mysql_fetch_row($result))
				{

					$bgColor = (@$bgColor == "#FFFFFF") ? "#E7E8F5" : "#FFFFFF";

					?>
					<tr bgcolor="<?php echo $bgColor; ?>">
						<td width="1" bgcolor="#787C9B"></td>
						<td height="20" class="TableCell">
							<input type="checkbox" name="uId[]" <?php if($row[0] == 1) echo "disabled"; ?> value="<?php echo $row[0]; ?>">
						</td>
						<td height="20" class="TableCell">
							<a href="users.php?what=modify&uId=<?php echo $row[0]; ?>"><?php echo $row[8]; ?></a>
						</td>
						<td height="20" class="TableCell">
							<a href="mailto: <?php echo $row[3]; ?>"><?php echo $row[3]; ?></a>
						</td>
						<td height="20" class="TableCell">
							<?php echo MakeDate($row[7]); ?>
						</td>
						<td width="1" bgcolor="#787C9B"></td>
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
						<input type="submit" value="Delete Selected �">
					</td>
				</tr>
		  </table>
		</form>
	<?php
  }
  
  function DeleteUsers()
  {
		// This function will remove the selected users from the database

		global $dbPrefix;

		doDbConnect();
		
		$uId = @$_POST["uId"];
		$query = "";
		$result1 = "";

		if(is_array($uId) == true)
		{
			// Userss have been chosen, run 2 delete queries
			$query1 = "DELETE FROM {$dbPrefix}_users WHERE pk_uId = " . implode(" OR pk_uId = ", $uId);
			
			if(@mysql_query($query1))
				$result1 = true;
			else
				$result1 = false;
				
			if($result1 == true)
			{
				// Query executed OK
				$status = "You have successfully deleted one/more users from the database.<br><br>";
				$status .= "<a href='users.php'>Continue >></a>";
			}
			else
			{
				// Delete querie(s) failed
				$status = "An error occured while trying to delete the selected users(s).<br><br>";
				$status .= "<a href='javascript:document.location.reload()'>Try Again</a>";
			}
		}
		else
		{
			// No newsletters have been chosen
			$status = "You didn't select one/more users to delete.<br><br>";
			$status .= "<a href='javascript:history.go(-1)'>Try Again</a>";
		}
		
		MakeMsgPage('Delete Users(s)', $status);
		
  }
  
  function ModifyUsers()
  {
		// Change the details of a template

		global $dbPrefix;

		doDbConnect();
		
		$uId = @$_GET["uId"];
		$result = mysql_query("SELECT * FROM {$dbPrefix}_users WHERE pk_uId = $uId");
		
		if($row = mysql_fetch_array($result))
			{

				MakeMsgPage('Modify User', 'Please complete the form below to modify the selected user. Click on the "Update User" button to update this user.', 0);

				?>

					<tr>

						<td>

							<form action="users.php" method="post">
							<input type="hidden" name="what" value="doModify">
							<input type="hidden" name="uId" value="<?php echo $uId; ?>">

							<br>

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

											<strong>UserName</strong><br>

										</p>

									</td>

									<td width="75%">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<input type="text" name="username" size="40" value="<?php echo str_replace("\"", "'", $row["uUsername"]); ?>">

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr bgcolor="#E7E8F5">

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="middle">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong>Password</strong><br>

											Leave blank for no change.

										</p>

									</td>

									<td width="75%">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<input type="password" name="password" size="40">

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr>

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="middle">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong>Email Address</strong><br>

										</p>

									</td>

									<td width="75%">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<input type="text" name="email" size="40" value="<?php echo str_replace("\"", "'", $row["uEmail"]); ?>">

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr bgcolor="#E7E8F5">

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="middle">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong>First Name</strong><br>

										</p>

									</td>

									<td width="75%">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<input type="text" name="firstname" size="40" value="<?php echo str_replace("\"", "'", $row["uFirstName"]); ?>">

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr>

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="middle">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong>Last Name</strong><br>

										</p>

									</td>

									<td width="75%">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<input type="text" name="lastname" size="40" value="<?php echo str_replace("\"", "'", $row["uLastName"]); ?>">

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr bgcolor="#E7E8F5">

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="top">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong>Permissions</strong><br>

											Defines what this user can and cannot access whey they login.

										</p>

									</td>

									<td width="75%" class="BodyText">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<?php DisplayPermissions('edit', explode(",", $row["uPermissions"])); ?>

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

										<input type="button" value="� Cancel" onClick="ConfirmCancel('users.php')">
										<input type="submit" name="submit" value="Update User �">

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
			MakeMsgPage('Invalid User Selected', 'The user that you have selected is either invalid or has been deleted from the database.<br><br><a href="users.php">Continue >></a>');

	}
  
	function ProcessUsers()
		{

			global $dbPrefix;

			$uId = @$_POST["uId"];

			// Make sure all fields are completed
			$username = @$_POST["username"];
			$password = @$_POST["password"];
			$email = @$_POST["email"];
			$firstname = @$_POST["firstname"];
			$lastname = @$_POST["lastname"];
				
			$err = "";
		
			// Has the user entered all of the required fields?
			if($username == "")
				$err .= "<li>You forgot to enter a username</li>";

			if(strlen($username) < 4 ||  strlen($username) > 20)
				$err .= "<li>Your username must be 4-20 characters long</li>";

			if($password != "")
				{

					if(strlen($password) < 4 ||  strlen($password) > 20)
						$err .= "<li>Your password must be 4-20 characters long</li>";

				}

			if($email == "")
				$err .= "<li>You forgot to enter an email address</li>";

			if(!is_numeric(strpos($email, "@")) || !is_numeric(strpos($email, ".")))
				$err .= "<li>Please provide a vaild email</li>";

			if($firstname == "")
				$err .= "<li>You forgot to enter a first name</li>";

			if($lastname == "")
				$err .= "<li>You forgot to enter a last name</li>";
	  
			doDbConnect();

			if($err != "")
				MakeMsgPage('Modify Users', 'The form that you\'ve just submitted is incomplete. Please review the errors below and then go back and correct them: <ul>' . $err .'</ul><a href="javascript:history.go(-1)"><< Go Back</a>');
			else
				{

					// Set the permissions up

					$perm = '';

					foreach($_POST as $key=>$value)
						{

							switch($key)
								{

									case "what";
									case "username";
									case "password";
									case "email";
									case "firstname";
									case "lastname";
									case "uId";
										break;

									default;
										if(@$_POST[$key] != '')
											$perm .= "$key,";
										break;

								}

						}

					if(substr($perm, -1) == ",")
						$perm = substr($perm, 0, -1);

					

					$query = "UPDATE {$dbPrefix}_users SET uUsername='$username', uEmail = '$email', uFirstName = '$firstname', uLastName = '$lastname', uPermissions = '$perm'";

					if($password != "")
						{

							$password = md5($password);
							$query .= ", uPassword = '$password'";

						}

					$query .= " WHERE pk_uId=$uId";

					$result = @mysql_query($query);
					$status = "";
	  
					if($result)
						{

						    $status = "<br>Your user has been successfully modified.<br><br>";
							$status .= "<a href='users.php'>Continue >></a>";

						}
					else
						{

							$status = "<br>Some errors occured while trying to modify this user.<br><br>";
							$status .= "<a href='javascript:history.go(-1)'><< Go Back</a><br>&nbsp;";
						}

					MakeMsgPage('Modify Users', $status);

				}

		}
	  
?>
<?php include("templates/bottom.php"); ?>