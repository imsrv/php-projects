<?php

	ob_start();

	include("templates/top.php");
	include_once("includes/functions.php");

	$what = @$_POST["what"];

	if(isset($_GET['showVer']))
		{
			echo "MailWorks Professional Version: $mwp_ver<br>";
			phpinfo();
			exit;
		}

	if($what == "")
		$what = @$_GET["what"];

	switch($what)
		{

			case "doLogin":
				ProcessLogin();
				break;

			case "logout":
				ProcessLogout();
				break;

			default:
				ShowLoginForm();
				break;

		}

	function ShowLoginForm()
		{

			if(is_numeric(@$_COOKIE['uId']))
				header("location: index.php");

			MakeMsgPage('MailWorksPro Admin Login', 'Please complete the form below to login to the MailWorksPro admin area.', 0)

			?>  

					<tr>

						<td>

							<form action="login.php" method="post">

							<input type="hidden" name="what" value="doLogin">

							<table width="95%" align="center" border="0">

								<tr>

									<td width="50%" valign="top">

										<br>

										<table width="100%" border="0">

											<tr>

												<td width="30%">

													<span class="BodyText">Username:</span>

												</td>

												<td width="70%">

													<input type="text" name="userName">

												</td>

											</tr>

											<tr>

												<td width="30%">

													<span class="BodyText">Password:</span>

												</td>

												<td width="70%">

													<input type="password" name="password">

												</td>

											</tr>

											<tr>

												<td width="30%"></td>

												<td width="70%">

													<input type="submit" name="submit" value="Process Login »">

												</td>

											</tr>

										</table>

									</td>

									<td width="50%">

										<img src="images/people.gif">

									</td>

								</tr>

							</table>

							</form>

						</td>

					</tr>

				</table>

			<?php

		}

	function ProcessLogin()
		{

			global $adminUser;
			global $adminPass;
			global $dbPrefix;
			global $delDays;

			$u = @$_POST["userName"];
			$p = @$_POST["password"];

			$err = "";

			if($u == "")
				$err .= "<li>You forgot to enter your username</li>";

			if($p == "")
				$err .= "<li>You forgot to enter your password</li>";

			// Display the page header

			$content = '';

			if($err != "")
				{

					$content .= "Some errors occured while trying to log you in: <ul>$err</ul>";
					$content .= "<a href='login.php'><< Go Back</a>";

				}
			else
				{

					// Is this a valid user?

					doDbConnect();

					$p = md5($p);

					$result = @mysql_query("SELECT * FROM {$dbPrefix}_users WHERE uUsername = '$u' AND uPassword = '$p'");

					if(mysql_num_rows($result) > 0)
						$isValid = true;
					else
						$isValid = false;

					if($isValid == true)
						{

							$userId = mysql_result($result, 0, 0);

							setcookie("auth", true);
							setcookie("uId", $userId);

							//Check if the subscribers have not confirmed there subscription in the last x days.

							if($delDays != 0)
								{

									$time = time() - (60*60*24*$delDays);

									$query = mysql_query("SELECT * FROM {$dbPrefix}_subscribedusers WHERE unix_timestamp(suDateSubscribed) <= $time AND suStatus = 'pending'");

									$del = array();

									while($row = mysql_fetch_array($query))
										{

											if(@mysql_query("DELETE FROM {$dbPrefix}_subscribedusers WHERE pk_suId = {$row[0]}"))
												$del[] = $row[3];

										}

								}

							$content .= "You have successfully logged into the MailWorksPro admin area";

							if(sizeof(@$del) > 0)
								{

									$content .= "<br><br>The following subscribers have been deleted from MailWorks Professional because they have not confirmed there subscription within the last $delDays.<ul>";

									foreach($del as $key=>$value)
										$content .= "<li>$value</li>";

									$content .= "</ul>";

								}

							$content .= "<br><br><a href='index.php'>Continue >></a>";

						}
					else
						{

							$content .= "Your login credentials were invalid or do not exist in the database<br><br>";
							$content .= "<a href='login.php'><< Go Back</a>";

						}

				}


			MakeMsgPage('MailWorksPro Admin Login', $content);

		}

	function ProcessLogout()
		{

			setcookie("auth", true, time() - 3600*60);
			setcookie("uId", false, time() - 3600*60);

			JSRedirectTo("index.php", 0);

		}

	include("templates/bottom.php");

?>