<?php

	ob_start();

	include("templates/top.php");

	include_once("includes/functions.php");

	$what = @$_POST["what"];

	if($what == "")
		$what = @$_GET["what"];

	switch($what)
		{

			case "restore";
				if(in_array("subscribe_backup", $authLevel))
					ShowRestore();
				else
					noAccess();
				break;

			case "backup";
				if(in_array("subscribe_backup", $authLevel))
					ShowBackup();
				else
					noAccess();
				break;

			case "editcustom";
				if(in_array("subscribe_custom", $authLevel))
					ShowEditCustomFields();
				else
					noAccess();
				break;

			case "processeditcustom";
				if(in_array("subscribe_custom", $authLevel))
					ProcessEditCustomFields();
				else
					noAccess();
				break;

			case "addcustom";
				if(in_array("subscribe_custom", $authLevel))
					ShowAddCustomFields();
				else
					noAccess();
				break;

			case "processaddcustom";
				if(in_array("subscribe_custom", $authLevel))
					ProcessAddCustomFields();
				else
					noAccess();
				break;

			case "order";
				if(in_array("subscribe_custom", $authLevel))
					ShowChangeOrder();
				else
					noAccess();
				break;

			case "doCustomDelete";
				if(in_array("subscribe_custom", $authLevel))
					ProcessDeleteCustom();
				else
					noAccess();
				break;

			case "custom";
				if(in_array("subscribe_custom", $authLevel))
					ShowCustomFields();
				else
					noAccess();
				break;

			case "import":
				if(in_array("subscribe_import", $authLevel))
					ShowNewForm();
				else
					noAccess();
				break;

			case "doImport":
				if(in_array("subscribe_import", $authLevel))
					ProcessImports();
				else
					noAccess();
				break;

			case "delete":
				if(in_array("subscribe_delete", $authLevel))
					DeleteSubscribers();
				else
					noAccess();
				break;

			case "export":
				if(in_array("subscribe_export", $authLevel))
					ShowExportForm();
				else
					noAccess();
				break;

			case "doExport":
				if(in_array("subscribe_export", $authLevel))
					ProcessExport();
				else
					noAccess();
				break;

			case "deleteAll":
				if(in_array("subscribe_delete", $authLevel))
					DeleteAll();
				else
					noAccess();
				break;

			case "viewdetails":
				if(in_array("subscribe_view", $authLevel))
					ViewDetails();
				else
					noAccess();
				break;

			default:
				if(in_array("subscribe_view", $authLevel))
					ShowSubscriberList();
				else
					noAccess();

		}

	function ViewDetails()
		{

			global $dbPrefix;

			// define the variables used

			$id		= @$_GET['id'];

			if($id == '')
				$id = @$_POST['id'];

			if(@$_POST['status_update'] == 'yes')
				{

					$email			= trim(@$_POST['email']);
					$password		= @$_POST['password'];
					$year			= @$_POST['year'];
					$month			= @$_POST['month'];
					$day			= @$_POST['day'];
					$status			= @$_POST['status'];
					$newsletters	= @$_POST['newsletters'];
					$custom			= null;
					$count			= 0;

					if(count($newsletters) == '0') {

						$update = '<b style="color: red;">You must select at least one newsletter to subscribe to</b>';

					} else {

						// make sure the email is valid

						if(is_numeric(strpos($email, '@')) && is_numeric(strpos($email, '.'))) {

							// make sure the email doesnt already exist!

							if(mysql_result(mysql_query("SELECT COUNT(pk_suId) FROM {$dbPrefix}_subscribedusers WHERE pk_suId != '$id' AND suEmail = '$email'"), 0, 0) == '0') {

								if(!empty($password)) {

									$password = "suPassword = PASSWORD('{$password}),'";

								}

								$query = @mysql_query("SELECT cfTitle, cfFieldName, cfRequired FROM {$dbPrefix}_customfields");

								while($cRow = @mysql_fetch_row($query)) {

									$custom .= " , su_cust_{$cRow[1]} = '" . $_POST['cu_' . $cRow[1]] . "'";

								}

								$query = @mysql_query("UPDATE {$dbPrefix}_subscribedusers SET suDateSubscribed = suDateSubscribed, $password suEmail = '$email', suStatus = '$status' $custom WHERE pk_suId = $id");

								if($query) {

									@mysql_query("DELETE FROM {$dbPrefix}_subscriptions WHERE sSubscriberId = '$id'");

									foreach($newsletters as $k=>$v) {

										$new = @mysql_query("INSERT INTO {$dbPrefix}_subscriptions (sNewsletterId, sSubscriberId) VALUES ('$v', '$id')");

										if($new)
											$count++;

									}

									if(count($count) > 0) {

										$update = "<b>The status of this user has been successfully updated.</b>";

									}

								} else {

									$update = "<b>Could not update subscribers details</b>";

								}

							} else {

								$update = '<b style="color: red;">Email already exists</b>';

							}

						} else {

							$update = '<b style="color: red;">Invalid email address</b>';

						}

					}

				}

			$year	= date("Y");
			$month	= date("n");
			$day	= date("j");

			$query = @mysql_query("SELECT * FROM {$dbPrefix}_subscribedusers WHERE pk_suId = $id");

			if(is_numeric($id) && $id != '' && @mysql_num_rows($query) == 1)
				{

					$row = @mysql_fetch_array($query);

					//User Exists

					MakeMsgPage("View/Edit Details", "Below is the details on the selected user. " . @$update, 0);

					?>

						<tr>

							<td>

								<br>

								<form action="subscriber.php" method="post" name="frmNewsletter">

								<input type="hidden" name="what" value="viewdetails">

								<input type="hidden" name="status_update" value="yes">

								<input type="hidden" name="id" value="<?php echo $id; ?>">

								<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

											Details For <?php echo $row[1]; ?>

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Email</strong><br>

											</p>

										</td>


										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input name='email' type='text' value='<?php echo $row[1]; ?>'>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Password</strong><br>
												Leave blank for no change

											</p>

										</td>


										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="password" name="password" value="">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Date Joined</strong><br>

											</p>

										</td>


										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<?php

													$cyear	= substr($row[4], 0, 4);
													$cmonth	= (int)substr($row[4], 4, 2);
													$cday	= (int)substr($row[4], 6, 2);

												?>

												<select name="year">
													<?php

														for($i = $year - 2; $i <= $year + 2; $i++) {

															if($i == $cyear) {

																echo "<option selected value=\"$i\">$i</option>";

															} else {

																echo "<option value=\"$i\">$i</option>";

															}

														}

													?>
												</select>

												<select name="month">
													<?php

														for($i = 1; $i <= 12; $i++) {

															if($i == $cmonth) {

																echo "<option selected value=\"$i\">" . date("M", mktime(0, 0, 0, $i, $cday, $cyear)) . "</option>";

															} else {

																echo "<option value=\"$i\">" . date("M", mktime(0, 0, 0, $i, $cday, $cyear)) . "</option>";

															}

														}

													?>
												</select>

												<select name="day">
													<?php

														for($i = 1; $i <= 31; $i++) {

															if($i == $cday) {

																echo "<option selected value=\"$i\">$i</option>";

															} else {

																echo "<option value=\"$i\">$i</option>";

															}

														}

													?>
												</select>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<?php

										$bgColor = "#FFFFFF";

										$cQuery = @mysql_query("SELECT * FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

										while($cRow = mysql_fetch_array($cQuery))
											{

												$bgColor = (@$bgColor == "#FFFFFF") ? "#E7E8F5" : "#FFFFFF";

												?>

													<tr bgcolor="<?php echo $bgColor; ?>">

														<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

														<td width="25%" class="BodyText" valign="middle">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<strong><?php echo $cRow[1]; ?></strong><br>

															</p>

														</td>

														<td width="75%" class="BodyText">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<?php

																	switch($cRow['cfFieldType'])
																		{

																			case "textfield";
																				echo "<input type='text' name='cu_{$cRow['cfFieldName']}' value='" . $row['su_cust_'.$cRow['cfFieldName']] . "'>";
																				break;

																			case "textarea";
																				echo "<textarea name='cu_{$cRow['cfFieldName']}'>" . $row['su_cust_'.$cRow['cfFieldName']] . "</textarea>";
																				break;

																			case "yes/no";
																				$yes = null;
																				$no = null;
																				if($row['su_cust_'.$cRow['cfFieldName']] == 1) {

																					$yes = 'checked';

																				} else {

																					$no = 'checked';

																				}
																				echo "<input type='radio' name='cu_{$cRow['cfFieldName']}' value='1' $yes> Yes<br><input type='radio' name='cu_{$cRow['cfFieldName']}' value='0' $no> No";
																				break;

																			case "dropdown";
																				$data = explode(",", $cRow['cfDefaultValue']);

																				echo "<select name='cu_{$cRow['cfFieldName']}'>";

																				if($row[4]  == '0') {

																					echo "<option value='0'></option>";

																				}

																				for($i = 0; $i < count($data); $i++) {

																					if($i == ($row['su_cust_'.$cRow['cfFieldName']] - 1)) {

																						echo "<option selected value=\"" . ($i + 1) . "\">{$data[$i]}</option>";

																					} else {

																						echo "<option value=\"" . ($i + 1) . "\">{$data[$i]}</option>";

																					}

																				}
																				echo "</select>";

																				if($row['su_cust_'.$cRow['cfFieldName']] == 0)
																					echo "[No Option Selected]";
																				break;

																			default;
																				echo $cRow['cfFieldType'];

																		}

																?>

															</p>

														</td>

														<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													</tr>

												<?php

											}

										$bgColor = (@$bgColor == "#FFFFFF") ? "#E7E8F5" : "#FFFFFF";

									?>

									<tr bgcolor="<?php echo $bgColor; ?>">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Status</strong><br>

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="radio" name="status" value="subscribed" <?php if($row['suStatus'] == "subscribed") echo "checked"; ?>> Subscribed<br>
												<input type="radio" name="status" value="pending" <?php if($row['suStatus'] == "pending") echo "checked"; ?>> Pending

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#FFFFFF">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Subscribed To</strong><br>

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<?php

													$query = @mysql_query("SELECT pk_nId, nName, nDesc, nFormat FROM {$dbPrefix}_newsletters ORDER BY nName ASC");

													while($nRow = @mysql_fetch_row($query)) {

														// loop though all the newsletters and list them

														$checked = (mysql_result(mysql_query("SELECT COUNT(pk_sId) FROM {$dbPrefix}_subscriptions WHERE sNewsletterId = '{$nRow[0]}' AND sSubscriberId = '$id'"), 0, 0) == 1) ? 'checked' : null;

														echo "<input type='checkbox' name='newsletters[]' value='{$nRow[0]}' id='new{$nRow[0]}' $checked> <label for='new{$nRow[0]}'>{$nRow[1]}</label><br>\n";

													}

												?>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" colspan="4" height="1" bgcolor="#787C9B"></td>

									</tr>

									<tr>

										<td colspan="4">

											<br>

											<input type="button" value="&laquo; Return" onClick="document.location.href = 'subscriber.php'">

											<input type="submit" value="Update Details &raquo;">

										</td>

									</tr>

									</form>

								</table>

							</td>

						</tr>

						</table>

					<?php

				}
			else
				MakeMsgPage('Subscriber Details', 'The user you have choosen does not have a valid ID, or no longer exists in the datbase. Please return to the previous page and select another subscriber.<br><br><a href="javascript: history.go(-1);">&laquo; Return</a>');

		}

	function ProcessDeleteCustom()
		{

			global $dbPrefix;

			$id = @$_POST['cId'];

			if(is_array($id))
				{

					if(sizeof($id) > 0)
						{

							// build delete queries and alter the db.

							$success = array();

							foreach($id as $key=>$value)
								{

									$name = @mysql_result(mysql_query("SELECT cfFieldName FROM {$dbPrefix}_customfields WHERE pk_cfId = $value"), 0, 0);

									$query = mysql_query("DELETE FROM {$dbPrefix}_customfields WHERE pk_cfId = $value");

									if($query)
										{

											$query = mysql_query("ALTER TABLE {$dbPrefix}_subscribedusers DROP `su_cust_{$name}`");

											if($query)
												$success[] = $name;

										}

								}

							$content = 'The following custom field(s) have successfully been deleted from the database. Please note that all data releated to these fields HAS been permently deleted.';
							$content .= '<ul>';

							foreach($success as $key=>$value) $content .= "<li>su_cust_{$value}</li>";

							$content .= '</ul><a href="subscriber.php?what=custom">Continue >></a>';

							MakeMsgPage('Delete Custom Field(s)', $content);

						}
					else
						{

							// did not select any fields

							MakeMsgPage('Delete Custom Field(s)', 'There were no custom field(s) selected. Please return to the previous page and select a field to delete.<br><br><a href="javascript: history.go(-1);"><< Back</a>');

						}

				}
			else
				{

					// not an array

					MakeMsgPage('Delete Custom Field(s)', 'There were no custom field(s) selected. Please return to the previous page and select a field to delete.<br><br><a href="javascript: history.go(-1);"><< Back</a>');

				}

		}

	function ProcessEditCustomFields()
		{

			global $dbPrefix;

			$id 			= @$_POST['id'];
			$title 			= @$_POST['fieldTitle'];
			$titleDefault	= @$_POST['fieldTitleDefault'];
			$description 	= @$_POST['description'];
			$name 			= @$_POST['fieldName'];
			$req 			= @$_POST['fieldReq'];
			$pertags 		= @$_POST['pertags'];
			$type 			= @$_POST['FieldType'];
			$default 		= @$_POST['defaultValue'];
			$maxlength 		= @$_POST['maxLength'];

			$data = false;

			//if $type is dropdown, use this for the options
			$default = explode(",", $default);
			$default1 = array();

			for($i = 0; $i < sizeof($default); $i++)
				{
					$default[$i] = trim($default[$i]);

					if($default[$i] != '')
						$default1[] = $default[$i];

				}

			$options = @array_unique($default1);

			$default = implode(",", $options);

			foreach($options as $key=>$value)
				if($value != '')
					$data = true;

			$err = '';

			// error checking

			if($title == '')
				$err .= '<li>You must provide a title for this field</li>';

			if($description == '')
				$err .= '<li>You must provide a description for this field</li>';

			if(strlen($description) > 250)
				$err .= '<li>Your description may only be 250 characters long. Please trim your description</li>';

			switch($type)
				{

					case "textfield";
						if($maxlength == '' || !is_numeric($maxlength) || $maxlength > 255)
							$err .= '<li>You must provide a valid max length between 0 and 255</li>';
						break;

					case "textarea";
						if($maxlength == '' || !is_numeric($maxlength) || $maxlength > 999)
							$err .= '<li>You must provide a valid max length between 0 and 999</li>';
						break;

					case "yes/no";
						break;

					case "dropdown";
						if(sizeof($options) < 2)
							$err .= '<li>You must provide at least two options for the drop down list</li>';
						if($data == false)
							$err .= "<li>There are no drop down options for this field type</li>";
						break;

				}

			if($err != "")
				{

					$content = 'The form that you\'ve just submitted is incomplete. Please review the errors below and then go back and correct them:';
					$content .= '<ul>' . $err . '</ul><a href="javascript:history.go(-1)"><< Go Back</a>';

					MakeMsgPage('Edit Custom Field', $content);

				}
			else
				{

					//check if the name or title are already in the database.

					$query = mysql_query("SELECT * FROM {$dbPrefix}_customfields WHERE cfTitle = '$title'");

					if($title == $titleDefault)
						$pass = (mysql_num_rows($query) == 1 ? true : false);
					else
						$pass = (mysql_num_rows($query) == 0 ? true : false);

					if($pass)
						{

							// everything is set. Add the data to the database and build the query to alter the database.

							$query  = "UPDATE {$dbPrefix}_customfields SET ";
							$query .= "cfTitle = '$title', cfFieldType = '$type', cfRequired = '$req', ";
							$query .= "cfPerTags = '$pertags', cfDefaultValue = '$default', ";
							$query .= "cfMaxLength = '$maxlength', cfDescription = '$description' WHERE ";
							$query .= "pk_cfId = $id";

							if(mysql_query($query))
								{

									// alter database table

									//ALTER TABLE `mwp_subscribedusers` CHANGE `su_cust_country` `su_cust_country` INT(4) DEFAULT '0' NOT NULL

									$alter = "ALTER TABLE {$dbPrefix}_subscribedusers CHANGE `su_cust_{$name}` `su_cust_{$name}` ";

									if($req == 1)
										$REQ = "NOT NULL";
									else
										$REQ = "NULL";

									switch($type)
										{

											case "textfield";
													$alter .= "varchar(255) $REQ";
												break;

											case "textarea";
													$alter .= "text $REQ";
												break;

											case "yes/no";
													$alter .= "enum('0','1') $REQ";
												break;

											case "dropdown";
													$alter .= "int(3) $REQ";
												break;

										}

									if(mysql_query($alter))
										{

											$content = 'You have successfully saved the custom field to the subscriber database. ';

											if($pertags == 1)
												$content .= 'You can use this field in your newsletters with personalization tags. ';

											$content .= 'You can export this data with the export option to the left.<br><br><a href="subscriber.php?what=custom">Continue &raquo;</a>';

											MakeMsgPage('Custom Field Updated', $content);

										}
									else
										{

											$content = 'There was a problem when trying to modify the subscribeuser database, and because of this the custom field can not be added.<br><br><a href="subscriber.php?what=custom">Continue</a>';

											MakeMsgPage('Custom Field', $content);

										}

								}
							else
								{

									$content = 'MailWorks Professional is currently unable to process your request as it can not create the required content in the database.<br><br><a href="subscriber.php?what=custom">Continue &raquo;</a>';

									MakeMsgPage('Custom Field', $content);

								}

						}
					else
						{

							$content = 'The field name or title that you have entered is already in use by another custom field.<br><br><a href="javascript: history.go(-1);">Return &raquo;</a>';

							MakeMsgPage('Custom Field', $content);

						}

				}

		}

	function ShowEditCustomFields()
		{

			global $dbPrefix;

			$id = @$_GET['cId'];

			if(is_numeric($id) || $id > 0)
				{

					$query = mysql_query("SELECT * FROM {$dbPrefix}_customfields WHERE pk_cfId = $id limit 1");

					if(mysql_num_rows($query) == 1)
						{

							$row = @mysql_fetch_array($query);

							?>

								<script language="JavaScript">

									function DisableFields()
										{

											var val = document.frmCustField.FieldType.value;

											if(val == 'textfield')
												{

													document.frmCustField.defaultValue.disabled = true;
													document.frmCustField.maxLength.disabled = false;

												}

											if(val == 'textarea')
												{

													document.frmCustField.defaultValue.disabled = true;
													document.frmCustField.maxLength.disabled = false;

												}

											if(val == 'yes/no')
												{

													document.frmCustField.defaultValue.disabled = true;
													document.frmCustField.maxLength.disabled = true;

												}

											if(val == 'dropdown')
												{

													document.frmCustField.defaultValue.disabled = false;
													document.frmCustField.maxLength.disabled = true;

												}

										}

								</script>

								<?php MakeMsgPage('Edit Custom Field', 'Please complete the form below to update the selected custom field.<br><br>', 0); ?>

									<tr>

										<td>

											<form name="frmCustField" action="subscriber.php" method="post">

											<input type="hidden" name="what" value="processeditcustom">
											<input type="hidden" name="id" value="<?php echo $id; ?>">

												<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

													<tr>

														<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

															Custom Field Details

														</td>

													</tr>

													<tr>

														<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

														<td width="25%" class="BodyText" valign="middle">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<strong>Field Title</strong><br>

																The title or question that your subscribers will be presented with.

															</p>

														</td>

														<td width="75%">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<input type="text" name="fieldTitle" size="40" value="<?php echo $row[1]; ?>" maxlength="255">

																<input type="hidden" name="fieldTitleDefault" value="<?php echo $row[1]; ?>">

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

																<textarea name="description" rows="8" cols="30"><?php echo $row[8]; ?></textarea>

															</p>

														</td>

														<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													</tr>

													<tr>

														<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

														<td width="25%" class="BodyText" valign="middle">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<strong>Field Name</strong><br>

															</p>

														</td>

														<td width="75%" class="BodyText">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<input type="text" name="na" value="<?php echo $row[2]; ?>" disabled> <span id="pertagsshow">

																<input type="hidden" name="fieldName" value="<?php echo $row[2]; ?>">

															</p>

														</td>

														<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													</tr>

													<tr bgcolor="#E7E8F5">

														<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

														<td width="25%" class="BodyText" valign="middle">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<strong>Required Field</strong><br>

																Is this field required to be completed?

															</p>

														</td>

														<td width="75%" class="BodyText">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<input type="radio" name="fieldReq" size="40" value="1" <?php if($row[4] == '1') echo "checked"; ?>> Yes
																<input type="radio" name="fieldReq" size="40" value="0" <?php if($row[4] == '0') echo "checked"; ?>> No

															</p>

														</td>

														<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													</tr>

													<tr>

														<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

														<td width="25%" class="BodyText" valign="middle">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<strong>Personalization Tag</strong><br>

																If yes, you will be able to use this custom field as a personalization tag.

															</p>

														</td>

														<td width="75%" class="BodyText">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<input type="radio" name="pertags" size="40" value="1" <?php if($row[5] == '1') echo "checked"; ?> onFocus="document.all.pertagsshow.style.display = 'inline';"> Yes
																<input type="radio" name="pertags" size="40" value="0" <?php if($row[5] == '0') echo "checked"; ?> onFocus="document.all.pertagsshow.style.display = 'none';"> No

															</p>

														</td>

														<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													</tr>

													<tr bgcolor="#E7E8F5">

														<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

														<td width="25%" class="BodyText" valign="middle">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<strong>Field Type</strong><br>

															</p>

														</td>

														<td width="75%" class="BodyText">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<select name="FieldType" onChange="alert('WARNING: If you change from a text field to a yes/no or a dropdown list field type, then any previous user data for this custom field will be deleted.'); DisableFields();">
																	<option value="textfield" <?php if($row[3] == 'textfield') echo "selected"; ?>>Text field (single-line)</option>
																	<option value="textarea" <?php if($row[3] == 'textarea') echo "selected"; ?>>Text field (multi-line)</option>
																	<option value="yes/no" <?php if($row[3] == 'yes/no') echo "selected"; ?>>Yes / no option</option>
																	<option value="dropdown" <?php if($row[3] == 'dropdown') echo "selected"; ?>>Dropdown list</option>
																</select>

															</p>

														</td>

														<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													</tr>

													<tr>

														<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

														<td width="25%" class="BodyText" valign="middle">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<strong>Selectable Options</strong><br>

																If creating a dropdown list, enter selectable values here, seperated by commas (such as cat, dog, cow). Leave blank for other field types.

															</p>

														</td>

														<td width="75%" class="BodyText">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<input type="text" name="defaultValue" size="40" value="<?php echo $row[6]; ?>">

															</p>

														</td>

														<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

													</tr>

													<tr bgcolor="#E7E8F5">

														<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

														<td width="25%" class="BodyText" valign="middle">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<strong>Maximum Length</strong><br>

																Specify the maximum number of characters for this field. Leave blank if not a text field.

															</p>

														</td>

														<td width="75%" class="BodyText">

															<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<input type="text" name="maxLength" size="4" value="<?php echo $row[7]; ?>" maxlength="3" >

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

																<script>DisableFields();</script>

																<br>

																<input type="button" value="� Cancel" onClick="ConfirmCancel('subscriber.php?what=custom')">

																<input type="submit" name="submit" value="Update Custom Field �">

															</span>

														</td>

													</tr>

												</table>

											</td>

										</tr>

									</table>

							<?php

						}

				}

		}

	function ProcessAddCustomFields()
		{

			global $dbPrefix;

			$title = @$_POST['fieldTitle'];
			$description = @$_POST['description'];
			$name = @$_POST['fieldName'];
			$req = @$_POST['fieldReq'];
			$pertags = @$_POST['pertags'];
			$type = @$_POST['FieldType'];
			$default = @$_POST['defaultValue'];
			$maxlength = @$_POST['maxLength'];

			$data = false;

			//if $type is dropdown, use this for the options

			$default = explode(",", $default);
			$default1 = array();

			for($i = 0; $i < sizeof($default); $i++)
				{
					$default[$i] = trim($default[$i]);

					if($default[$i] != '')
						$default1[] = $default[$i];

				}

			$options = @array_unique($default1);

			$default = implode(",", $options);

			$err = '';

			foreach($options as $key=>$value)
				if($value != '')
					$data = true;

			// error checking

			if($title == '')
				$err .= '<li>You must provide a title for this field</li>';

			if($description == '')
				$err .= '<li>You must provide a description for this field</li>';

			if(strlen($description) > 250)
				$err .= '<li>Your description may only be 250 characters long. Please trim your description</li>';

			if($name == '')
				$err .= '<li>You must provide a field name for this custom field</li>';

			switch($type)
				{

					case "textfield";
						if($maxlength == '' || !is_numeric($maxlength) || $maxlength > 255)
							$err .= '<li>You must provide a valid max length between 0 and 255</li>';
						break;

					case "textarea";
						if($maxlength == '' || !is_numeric($maxlength) || $maxlength > 999)
							$err .= '<li>You must provide a valid max length between 0 and 999</li>';
						break;

					case "yes/no";
						break;

					case "dropdown";

						if(sizeof($options) < 2)
							$err .= '<li>You must provide at least two options for the drop down list</li>';
						if($data == false)
							$err .= "<li>There are no drop down options for this field type</li>";
						break;

				}

			if($err != "")
				{

					$content = 'The form that you\'ve just submitted is incomplete. Please review the errors below and then go back and correct them:';
					$content .= '<ul>' . $err . '</ul><a href="javascript:history.go(-1)"><< Go Back</a>';

					MakeMsgPage('Edit Custom Field', $content);

				}
			else
				{

					//check if the name or title are already in the database.

					$query = mysql_query("SELECT * FROM {$dbPrefix}_customfields WHERE cfTitle = '$title' OR cfFieldName = '$name'");

					if(mysql_num_rows($query) == 0)
						{

							// everything is set. Add the data to the database and build the query to alter the database.

							$query  = "INSERT INTO {$dbPrefix}_customfields ";
							$query .= "(cfTitle, cfFieldName, cfFieldType, cfRequired, ";
							$query .= "cfPerTags, cfDefaultValue, cfMaxLength, cfDescription) ";
							$query .= "VALUES ('$title', '$name', '$type', '$req', ";
							$query .= "'$pertags', '$default', '$maxlength', '$description')";

							if(mysql_query($query))
								{

									// alter database table

									$alter = "ALTER TABLE {$dbPrefix}_subscribedusers add `su_cust_{$name}` ";

									if($req == 1)
										$REQ = "NOT NULL";
									else
										$REQ = "NULL";

									switch($type)
										{

											case "textfield";
													$alter .= "varchar(255) $REQ";
												break;

											case "textarea";
													$alter .= "text $REQ";
												break;

											case "yes/no";
													$alter .= "enum('0','1') $REQ";
												break;

											case "dropdown";
													$alter .= "int(3) $REQ";
												break;

										}

									if(mysql_query($alter))
										{

											$content = 'You have successfully saved the custom field to the subscriber database. ';

											if($pertags == 1)
												$content .= 'You can use this field in your newsletter with personalization tags. ';

											$content .= 'You can export this data with the export option to the right.<br><br><a href="subscriber.php?what=custom">Continue &raquo;</a>';

											MakeMsgPage('Custom Field Added', $content);

										}
									else
										{

											// can not alter table.

											$content = 'While attempting to alter the current user table, there was an unforseen error. Please use the link below to continue.';
											$content .= '<br><br><a href="subscriber.php?what=custom">Continue &raquo;</a>';

											MakeMsgPage('Custom Field', $content);

										}

								}
							else
								{

									$content = 'MailWorks Professional is currently unable to process your request as it can not create the required content in the database.<br><br><a href="subscriber.php?what=custom">Continue &raquo;</a>';

									MakeMsgPage('Custom Field', $content);

								}

						}
					else
						{

							$content = 'The field name or title that you have chosen is already in use by another custom field.<br><br><a href="javascript: history.go(-1);">Return &raquo;</a>';

							MakeMsgPage('Custom Field', $content);

						}

				}

		}

	function ShowAddCustomFields()
		{

			?>

				<script language="JavaScript">

					function DisableFields()
						{

							var val = document.frmCustField.FieldType.value;

							if(val == 'textfield')
								{

									document.frmCustField.defaultValue.disabled = true;
									document.frmCustField.maxLength.disabled = false;

								}

							if(val == 'textarea')
								{

									document.frmCustField.defaultValue.disabled = true;
									document.frmCustField.maxLength.disabled = false;

								}

							if(val == 'yes/no')
								{

									document.frmCustField.defaultValue.disabled = true;
									document.frmCustField.maxLength.disabled = true;

								}

							if(val == 'dropdown')
								{

									document.frmCustField.defaultValue.disabled = false;
									document.frmCustField.maxLength.disabled = true;

								}

						}

				</script>

				<?php MakeMsgPage('Add Custom Field', 'Please complete the form below to add a custom field to the subscribers database. Once you have created the field, you can use it to collect extra data from your subscribers. You can also use your custom field in your newsletter with personalization tags.', 0); ?>

					<tr>

						<td>

							<form name="frmCustField" action="subscriber.php" method="post">

							<input type="hidden" name="what" value="processaddcustom">

							<br>

								<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

											Custom Field Details

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Field Title</strong><br>

												The title or question that your subscribers will be presented with.

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="fieldTitle" size="40" value="" maxlength="255">

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

												<textarea name="description" rows="6" cols="30"></textarea>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Field Name</strong><br>

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input maxlength="50" type="text" name="fieldName" size="40" value="" onKeyUp="this.value = this.value.replace(' ', '_'); this.value = this.value.replace(/[^a-zA-Z_]+/, ''); if(this.value != '') { document.all.pertagsshow.innerHTML = '%%'+this.value+'%%'; } else { document.all.pertagsshow.innerHTML = ''; }">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Required Field</strong><br>

												Is this field required to be completed?

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="radio" name="fieldReq" size="40" value="1" checked> Yes
												<input type="radio" name="fieldReq" size="40" value="0"> No

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Personalization Tag</strong><br>

												If yes, you will be able to use this custom field as a personalization tag.

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="radio" name="pertags" size="40" value="1" checked onFocus="document.all.pertagsshow.style.display = 'inline';"> Yes
												<input type="radio" name="pertags" size="40" value="0" onFocus="document.all.pertagsshow.style.display = 'none';"> No

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Field Type</strong><br>

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<select name="FieldType" onChange="DisableFields();">
													<option value="textfield">Text field (single-line)</option>
													<option value="textarea">Text field (multi-line)</option>
													<option value="yes/no">Yes / no option</option>
													<option value="dropdown">Dropdown list</option>
												</select>

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Selectable Options</strong><br>

												If creating a dropdown list, enter selectable values here, seperated by commas (such as cat, dog, cow).
												Leave blank for other field types.

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input DISABLED type="text" name="defaultValue" size="40" value="">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr bgcolor="#E7E8F5">

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>Maximum Length</strong><br>

												Specify the maximum number of characters for this field. Leave blank if not a text field.

											</p>

										</td>

										<td width="75%" class="BodyText">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="text" name="maxLength" size="4" value="" maxlength="3" >

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

												<input type="button" value="� Cancel" onClick="ConfirmCancel('subscriber?what=custom.php')">

												<input type="submit" name="submit" value="Add Custom Field �">

											</span>

										</td>

									</tr>

								</table>

							</td>

						</tr>

					</table>

			<?php

		}

	function ShowChangeOrder()
		{

			global $dbPrefix;

			$order = @$_POST['customOrder'];

			if(is_array($order))
				{

					$order = array_reverse($order);

					for($i = 0; $i < sizeof($order); $i++)
						mysql_query("UPDATE {$dbPrefix}_customfields SET cfWeight = '$i', cfCreated = cfCreated WHERE pk_cfId = {$order[$i]}");

					header("Location: subscriber.php?what=custom");

				}


			?>

				<script>

					function MoveUp()
						{

							var thisForm = document.frmOrder;

							var tmp1 = '';
							var tmp2 = '';
							var tmp3 = '';
							var tmp4 = '';

							if(thisForm.customOrder.selectedIndex > 0)
								{

									thisIndex = thisForm.customOrder.selectedIndex - 1;

									tmp1 = thisForm.customOrder[thisForm.customOrder.selectedIndex].value;
									tmp2 = thisForm.customOrder[thisForm.customOrder.selectedIndex].text;
									tmp3 = thisForm.customOrder[thisForm.customOrder.selectedIndex-1].value;
									tmp4 = thisForm.customOrder[thisForm.customOrder.selectedIndex-1].text;
									thisForm.customOrder[thisForm.customOrder.selectedIndex - 1].value = tmp1;
									thisForm.customOrder[thisForm.customOrder.selectedIndex -1].text = tmp2;
									thisForm.customOrder[thisForm.customOrder.selectedIndex].value = tmp3;
									thisForm.customOrder[thisForm.customOrder.selectedIndex].text = tmp4;

									thisForm.customOrder.selectedIndex = thisIndex;

								}
						}


					function MoveDown()
						{

							var thisForm = document.frmOrder;

							var tmp1 = '';
							var tmp2 = '';
							var tmp3 = '';
							var tmp4 = '';

							if(thisForm.customOrder.selectedIndex < thisForm.customOrder.length - 1)
								{

									thisIndex = thisForm.customOrder.selectedIndex + 1;

									tmp1 = thisForm.customOrder[thisForm.customOrder.selectedIndex].value;
									tmp2 = thisForm.customOrder[thisForm.customOrder.selectedIndex].text;
									tmp3 = thisForm.customOrder[thisForm.customOrder.selectedIndex+1].value;
									tmp4 = thisForm.customOrder[thisForm.customOrder.selectedIndex+1].text;
									thisForm.customOrder[thisForm.customOrder.selectedIndex + 1].value = tmp1;
									thisForm.customOrder[thisForm.customOrder.selectedIndex + 1].text = tmp2;
									thisForm.customOrder[thisForm.customOrder.selectedIndex].value = tmp3;
									thisForm.customOrder[thisForm.customOrder.selectedIndex].text = tmp4;

									thisForm.customOrder.selectedIndex = thisIndex;

								}
						}

					function selectAll()
						{

							var thisForm = document.frmOrder;

							thisForm.customOrder.multiple = true;

							for(i = 1; i <= thisForm.customOrder.length; i++)
								thisForm.customOrder[i-1].selected = true;

							thisForm.customOrder.name = 'customOrder[]';

							return true;

						}

				</script>

				<?php MakeMsgPage('Change Order Of Custom Fields', 'A list of custom fields is shown below. You may change the order of which these fields are displayed to your subscribers by using the up and down buttons below', 0); ?>

					<form name="frmOrder" onSubmit="return selectAll();" method="post">
					<input type="hidden" name="what" value="order">

					<tr>

						<td>

							<br>

							<select multiple size="10" style="width: 545px;" name="customOrder">

								<?php

									$result = mysql_query("SELECT * FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

									while($row = mysql_fetch_array($result))
										{

											echo "<option value=\"{$row[0]}\">{$row[1]}</option>";

										}

								?>

							</select>

							<br>

							<input type="button" value="&laquo Up" onClick="MoveUp();">
							<input type="button" value="Down &raquo;" onClick="MoveDown();">

							<input type="submit" value="Update Order">

						</td>

					</tr>

					</form>

				</table>

			<?php

		}

	function ShowCustomFields()
		{

			global $dbPrefix;

			$result = mysql_query("SELECT *, DATE_FORMAT(cfCreated, '%m/%d/%Y') AS date FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

			$num = mysql_num_rows($result);

			?>

				<script>

					function ConfirmDel()
						{

							if(confirm("Deleting the selected custom fields is a irreversible process. Are you sure you want to continue deleting the selected fields?"))
								return true;
							else
								return false;

						}

				</script>

				<?php MakeMsgPage('Custom Fields', 'A list of custom fields is shown below. These fields allow you to collect extra data from your subscribers.	To remove one/more fields, click the checkbox for that field and then click on the "Delete Selected" button.<br><br><b>Note:</b> The order of the fields below is the order in which they will appear on the subscription page. Use the \'Change Order\' link below to change the order of custom fields.<br><br>'); ?>

				<table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">

					<tr>

						<td colspan="6" class="Info" height="25">

							<?php if($num > 0) { ?>
								<a href="subscriber.php?what=order">Change Order</a>
							<?php } else { ?>
								<span style="color: lightgrey;">Change Order</span>
							<?php } ?>
							 | <a href="subscriber.php?what=addcustom"> Add Custom Field �</a><br><br>

						</td>

					</tr>

					<tr>

						<td colspan="6" height="18" class="Info" align="right">

							Current Custom Fields: <?php echo mysql_num_rows($result); ?>

						</td>

					</tr>

					<tr bgcolor="#787C9B">

						<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

						<td height="20" class="MenuHeading"></td>

						<td height="20" class="MenuHeading">

							Title

						</td>

						<td height="20" class="MenuHeading">

							Field Type

						</td>

						<td height="20" class="MenuHeading">

							Created

						</td>

						<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

					</tr>

					<form method="post" action="subscriber.php" name="frmCustomList" onSubmit="return ConfirmDel();">

					<input type="hidden" name="what" value="doCustomDelete">

					<?php

						if(mysql_num_rows($result) == 0)
							{

								?>

									<tr>

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

										<td colspan="4" height="25" class="Info">

											<p style="margin-left: 10px;">

											There are no custom fields defined in the database.

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

									</tr>

								<?php

							}

						while($row = mysql_fetch_row($result))
							{

								$bgColor = (@$bgColor == "#FFFFFF") ? "#E7E8F5" : "#FFFFFF";

								?>

									<tr bgcolor="<?php echo $bgColor; ?>">

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

										<td height="20" class="TableCell">

											<input type="checkbox" name="cId[]" value="<?php echo $row[0]; ?>">

										</td>

										<td height="20" class="TableCell">

											<a href="subscriber.php?what=editcustom&cId=<?php echo $row[0]; ?>"><?php echo substr($row[1], 0, 30); ?></a>

										</td>

										<td height="20" class="TableCell">

											<?php

												switch($row[3])
													{

														case "textfield";
															echo "Text Field";
															break;

														case "textarea";
															echo "Text Area";
															break;

														case "yes/no";
															echo "Yes/No (binary)";
															break;

														case "dropdown";
															echo "Drop Down List";
															break;

													}

											?>

										</td>

										<td height="20" class="TableCell">

											<?php echo $row[11]; ?>

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

						<td colspan="6">

							<br>

							<input onClick="return CheckConfirmDelete()"  type="submit" value="Delete Selected �">

						</td>

					</tr>

				</table>

				</form>


			<?php

		}

	function ShowRestore()
		{

			$do = @$_POST['do'];

			if($do == 'import')
				{

					//do import

					$file = @$_FILES['file'];

					// do checking

					$handle = @fopen($file['tmp_name'], 'rb');

					while(!@feof($handle))
						@$data .= fgets($handle, 1024);

					$lines = explode("\n", $data);

					MakeMsgPage('Restoring Data For MailWorks Professional', 'The page below contains the status of the data restoration wizard, and will notify you of the status of each database table.', 0);

					?>

						<tr>
							<td>

								<table width="95%" border="0" cellpadding="0" cellspacing="0">

									<tr>
										<td class="BodyText">

											<?php

												$mysql_err = false;

												for($i = 0; $i < sizeof($lines); $i++)
													{



														if($mysql_err == false)
															{

																// If comment is Title

																if(preg_match("/# Dumping data for table `([a-zA-Z0-9_]+)`/", $lines[$i], $name))
																	echo "<br><strong>Restoring Data For " . $name[1] . "...</strong><br><br>";

																$title = @$name[1];

																// If query, run and change to see if it failed.

																if(preg_match("/^[^#\n]/", $lines[$i], $data))
																	{

																		if(@mysql_query($lines[$i]) == false)
																			{

																				echo '&nbsp;&nbsp;&nbsp;<span style="color: red; font-weight: bold;">Error:</span> ' . $lines[$i] . '<br>&nbsp;&nbsp;&nbsp;(Error Message: ' . mysql_error() . ')<br>';

																				$mysql_err = true;

																			}
																		else
																			$mysql_err = false;

																	}

																// If next line is a break line # ------------------------------------------------, and the current line doesnt start with # & not equal to nothing then echo out the status for the previous data

																if(preg_match("/# ------------------------------------------------/", @$lines[$i + 1]) && $lines[$i] != '' && preg_match("/^[^#]/", $lines[$i]))
																	if(@$mysql_err == "failed")
																		echo "";
																	else
																		echo "&nbsp;&nbsp;&nbsp;<span style='color: green; font-weight: bold;'>Success</span><br>";

																// If no queries for this database, notify usre

																if(preg_match("/# No ouput data for table: `([a-zA-Z0-9_]+)`/", $lines[$i]))
																	echo "&nbsp;&nbsp;&nbsp;<span style='color: orange; font-weight: bold;'>Success</span> (No data to restore)<br>";

															}
														else
															{

																if(@$stop == false)
																	echo "<br>&nbsp;&nbsp;&nbsp;<strong>Stopped Due To Error</strong><br>";

																$stop = true;

															}

													}

												if($mysql_err == false)
													echo "<br><a href='index.php'>Continue &raquo;</a>";

											?>

										</td>
									</tr>

								</table>

							</td>
						</tr>
						</table>

					<?php

				}
			else
				{

					// Show Import

					MakeMsgPage('Restore Backup', 'Please selected your backup from your hard drive and then "Contiue &raquo;" to restore your backup to the database. Restoring will completely write over any data that may conflict, with the previous data. MailWorks Professional will return to its previous state from the point of the restore.', 0);

					?>

						<tr>

							<td>

								<br>

								<form action="subscriber.php" method="post" name="frmNewsletter" enctype="multipart/form-data">

								<input type="hidden" name="what" value="restore">

								<input type="hidden" name="do" value="import">

								<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

											Restore Backup

										</td>

									</tr>

									<tr>

										<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

										<td width="25%" class="BodyText" valign="middle">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<strong>SQL File</strong><br>

											</p>

										</td>

										<td width="75%">

											<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

												<input type="file" name="file" value="">

											</p>

										</td>

										<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									</tr>

									<tr>

										<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="1" valign="middle">

										</td>

									</tr>

									<tr>

										<td colspan="4" class="MenuHeading">

											<br>

											<input type="submit" value="Continue &raquo;">

										</td>

									</tr>

								</table>

							</td>

						</tr>

						</table>

					<?php

				}

		}

	function ShowBackup()
		{

			//ensure that they want to backup there database.

			global $dbServer, $dbUser, $dbPass, $dbName, $backuptable, $dbPrefix;

			@ini_set('memory_limit','16M');

			ob_end_clean();
			ob_start();

			$output = '';

			doDbConnect();

			// Start the output

			$output  = "# MailWorks Professional MySQL-Dump\n";
			$output .= "# Nullified by WTN Team\n\n";
			$output .= "# Host: $dbServer\n";
			$output .= "# Database: {$dbName}\n\n";
			$output .= "# Generation Time: " . date('Y-m-d H:i:s') . "\n";
			$output .= "# ------------------------------------------------\n\n";

			$tables = mysql_list_tables($dbName);

			while($tnRow = mysql_fetch_row($tables))
				{

					//check to see if this table has been selected to be backed up.
					//if no the $backuptable var has not been set in the conf.php file then backup all tables in database

					$tablename = $tnRow[0];

					if(@is_array($backuptable))
						{

							if(in_array($tablename, $backuptable))
								$print = true;
							else
								$print = false;

						}
					else
						$print = true;

					if($print)
						{

							//backup newsletters database

							$output .= "#\n# Dumping data for table `{$tablename}`\n#\n";

							// Reconnect to the database otherwise will not be able to get the field names

							$db = mysql_connect($dbServer, $dbUser, $dbPass);

							// Drop the current table

							$output .= "\nDROP TABLE IF EXISTS `{$tablename}`;\n\n";

							// Build the query to recreate the database

							$query = @mysql_query("SHOW CREATE TABLE `$tablename`");

							$output .= str_replace("\n", "", @mysql_result($query, 0, 1)) . ";\n\n";

							// Build the query to create the data

							$fields = mysql_list_fields($dbName, $tnRow[0], $db);

							$count = mysql_num_fields($fields);

							$nResult = mysql_query("select * from {$tablename}");

							if(mysql_num_rows($nResult) == 0)
								$output .= "# No ouput data for table: `{$tablename}`\n";

							while($nRow = @mysql_fetch_array($nResult))
								{

									$output .= "INSERT INTO {$tablename} VALUES (";

									for($i = 0; $i < $count; $i++)
										{

											if($i != $count - 1)
												$output .= "'" . str_replace("\"", "\\\"", str_replace("'", "\'", str_replace("\r", '\r', str_replace("\n", '\n', $nRow[$i])))) . "', ";
											else
												$output .= "'" . str_replace("\"", "\\\"", str_replace("'", "\'", str_replace("\r", '\r', str_replace("\n", '\n', $nRow[$i])))) . "');";

										}

									$output .= "\n";

								}

							$output .= "# ------------------------------------------------\n\n";

						}

				}

			ob_end_clean();
			ob_start();

			@touch('backup.sql');

			$handle = @fopen('backup.sql', 'wb');

			@fwrite($handle, $output, 100000);

			@fclose($handle);

			header("Content-Type: application/php");

			header("Content-Disposition: attachment; filename = backup.sql");

			echo $output;

			die();

		}

	function ShowNewForm()
		{

			global $dbPrefix;

			$content  = "Please complete the form below to add one/more subscribers to your mailing list. Everyone entered in the list below will be able to visit your newsletter subscription page to manage their preferences, change their password, etc. ";
			$content .= "If you have created custom fields and would like to insert values for them, then you should import each subscribers details in the following format (make sure you use a new line as the list delimeter):";
			$content .= "<blockquote>email";

			$query = @mysql_query("SELECT * FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle asc");

			while($row = @mysql_fetch_array($query))
				$content .= ",{$row[1]}";

			$content .= "<br></blockquote>";
			$content .= "<b>Note:</b> If you want to specify values for custom fields that are yes/no or dropdown list fields, then you must use numerical indexes only, such as 1 for yes and 0 for no in a yes/no field. If you have more than 1,000 subscribers to import then you *must* upload them as a text file and not paste them into the \"New Email Addresses\" box shown below.";

			MakeMsgPage('Import Subscribers', $content, 0);

			?>

					<tr>

						<td>

							<form onSubmit="document.frmSubscriber.submit.disabled = true; document.frmSubscriber.submit.value = 'Working...'" enctype="multipart/form-data" name="frmSubscriber" action="subscriber.php" method="post">

							<input type="hidden" name="what" value="doImport">
							<input type="hidden" name="custCount" value="<?php echo mysql_num_rows($query); ?>">

							<br>

							<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

								<tr>

									<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

										Step 1

									</td>

								</tr>

								<tr>

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="top">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong>New Email Addresses</strong><br>

											If importing less than 1,000 email addresses, paste them in this text box.

										</p>

									</td>

									<td width="75%">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<textarea rows="10" wrap="off" cols="47" name="emails"></textarea>

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr bgcolor="#E7E8F5">

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="middle">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">


										</p>

									</td>

									<td width="75%" class="BodyText">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<em><strong>OR</strong></em>

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr>

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="middle">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong>Upload Text File</strong><br>

											Choose a text file from your hard drive that contains subscriber emails and preferences.

										</p>

									</td>

									<td width="75%">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<input type="file" name="eFile" style="width:260">

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr>

									<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

										Step 2

									</td>

								</tr>

								<tr>

									<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

									<td width="25%" class="BodyText" valign="middle">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<strong>List Delimiter</strong><br>

											Select the delimiter that will be used to seperate each subscribers details in the list.

										</p>

									</td>

									<td width="75%">

										<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

											<select name="delim" style="width:260">

												<option selected value="nl">New Line</option>

												<option value=",">Comma</option>

												<option value=";">Semi-Colon</option>

												<option value="|">Pipe</option>

											</select>

										</p>

									</td>

									<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

								</tr>

								<tr>

									<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

										Subscribe These Users To The Following Newsletters

									</td>

								</tr>

								<?php

									// Grab a list of topics and their newsletters from the database and list them

									doDbConnect();

									$result = mysql_query("SELECT * FROM {$dbPrefix}_topics ORDER BY tName ASC");

									while($row = mysql_fetch_row($result))
										{

											$nResult = mysql_query("SELECT pk_nId, nName FROM {$dbPrefix}_newsletters WHERE nTopicId = " . $row[0]);

											if(mysql_num_rows($nResult) > 0)
												{

													$bgColor = (@$bgColor == "#FFFFFF") ? "#E7E8F5" : "#FFFFFF";

													?>

														<tr bgcolor="<?php echo $bgColor; ?>">

															<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

															<td width="25%" class="BodyText" valign="middle">

																<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																	<strong><?php echo $row[1]; ?></strong><br>

																</p>

															</td>

															<td width="75%" class="BodyText">

																<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

																<?php

																	while($nRow = mysql_fetch_row($nResult))
																		{

																			?>

																				<input type="checkbox" CHECKED name="newsletterId[]" value="<?php echo $nRow[0]; ?>">

																				<?php echo $nRow[1]; ?>

																<?php } ?>

																</p>

															</td>

															<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

														</tr>

													<?php

												}

										}

								?>

								<tr>

									<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="1" valign="middle"></td>

								</tr>

								<tr>

									<td colspan="4">

										<br>

										<input type="button" value="� Cancel" onClick="ConfirmCancel('subscriber.php')">

										<input id="submit" type="submit" name="submit" value="Import Subscribers �">

									</td>

								</tr>

							</table>

							</form>

						</td>

					</tr>

				</table>

			<?php

		}

	function ProcessImports()
		{

			// Import the email addresses into the subsribedUsers and subscriptions tables

			global $dbPrefix;

			set_time_limit(0); // No script execution time limit

			doDbConnect();

			$emails = @$_POST["emails"];
			$delim = @$_POST["delim"];
			$arrNewsletterIds = @$_POST["newsletterId"];
			$custCount = @$_POST["custCount"];

			$numValid = 0;
			$numInvalid = 0;
			$numDup = 0;
			$numUpdate = 0;

			$eFileName = trim(@$_FILES["eFile"]["tmp_name"]);
			$hasEmails = false;

			// Should we read-in the file?

			if(@$_FILES["eFile"]['error'] == '0')
				{

					if($fp = @fopen($eFileName, "rb")) // "b" is for binary on Windows servers
						{

							while(!@feof($fp))
								$emails .= @fgets($fp, 1024);

							@fclose($fp);

							$hasEmails = true;

						}
					else
						{

							// Couldn't open email file -- die

							MakeMsgPage('Import Subscribers', 'An error occured while trying to load the uploaded file. Check your php.ini file to make sure that you can upload files via your web browser.<br><a href="javascript:document.location.reload()">Try Again</a>');

						}

				}
			else
				{

					if($emails != "")
						$hasEmails = true;

				}

			// Split the list of subscribers based on the delimiter

			if($delim == "nl")
				$delim = "\r\n";

			if($delim != "_")
				$arrEmails = @explode($delim, $emails);
			else
				$arrEmails = array($emails);

			if($hasEmails == true && $delim != "" && sizeof($arrNewsletterIds) > 0)
				{

					for($i = 0; $i < sizeof($arrEmails); $i++)
						{

							// Is this a valid email address?

							$details = CleanExplode(',', $arrEmails[$i]);

							if(is_numeric(strpos($details[0], "@")) && is_numeric(strpos($details[0], ".")))
								{

									// Does this user already exist in the database?

									$userExists = (@mysql_result(@mysql_query("SELECT count(pk_suId) FROM {$dbPrefix}_subscribedusers WHERE suEmail = '{$details[0]}'"), 0, 0) > 0 ? true : false);

									// Add the user to the subscribedUsers

									$cust_field = '';

									if($userExists == false)
										{

											$cust = @mysql_query("SELECT cfFieldName FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

											while($cRow = mysql_fetch_array($cust))
												@$cust_field .= ", su_cust_{$cRow[0]}";


											$query = "INSERT INTO {$dbPrefix}_subscribedusers (pk_suId, suEmail, suPassword, suStatus, suDateSubscribed" . @$cust_field . ") VALUES (0, '" . $details[0] . "', password('" . GenerateRandomPassword() . "'), 'subscribed', now()";

											for($j = 1; $j <=  $custCount; $j++)
												$query .= ",'" . @$details[$j] . "'";

											$query .= ")";

											if(mysql_query($query))
												{

													// Add the user to his selected newsletter(s)

													$listErr = false;

													$userId = mysql_insert_id();

													for($j = 0; $j < sizeof($arrNewsletterIds); $j++)
														{

															if(!@mysql_query("INSERT INTO {$dbPrefix}_subscriptions VALUES (0, " . $arrNewsletterIds[$j] . ", " . $userId . ")"))
																$listErr = true;

														}

													if($listErr == false)
														++$numValid;
													else
														++$numInvalid;

												}
											else
												++$numInvalid;

										}
									else
										{

											//user already in db
											//add any new subscriptions in.

											//get Id of current email of $arrEmails[$i]

											$strResult = "SELECT pk_suId FROM {$dbPrefix}_subscribedusers WHERE suEmail = '{$details[0]}'";
											$id = @mysql_result(mysql_query($strResult), 0, 0);

											//now that we have the id, build an array of the template ids, that the user is already subscribed to.

											$templateArray = array();

											$strQuery = @mysql_query("SELECT sNewsletterId FROM {$dbPrefix}_subscriptions WHERE sSubscriberId = '$id'");

											while($tArr = @mysql_fetch_array($strQuery))
												$templateArray[] = $tArr[0];

											//loop though template array, checking that the id isnt part of the template id array!, so that we don't have dublicate entries

											for($t = 0; $t < sizeof($arrNewsletterIds); $t++)
												{

													if(in_array($arrNewsletterIds[$t], $templateArray))
														$add = false;
															else
														$add = true;

													$listErr = 0;

													if($add)
														{

															if(@mysql_query("INSERT INTO {$dbPrefix}_subscriptions VALUES (0, '{$arrNewsletterIds[$t]}', '$id')"))
																$listErr++;

														}

												}

											//check if any were added, if so add to updated fielf, else ++$numDup;

											if(@$listErr == 0)
												++$numDup;
											else
												++$numUpdate;

										}

								}
							else
								{

									if($arrEmails[$i] != "")
										++$numInvalid;

								}

						}

					$content = "The subscription process has been completed. Here are the stats:";

					$content .= "<ul>";

					if($numValid == 1)
						$content .= "<li>1 user was subscribed successfully</li>";
					else
						$content .= "<li>$numValid users were subscribed successfully</li>";

					if($numInvalid == 1)
						$content .= "<li>1 user was invalid (bad email addresses)</li>";
					else
						$content .= "<li>$numInvalid users were invalid (bad email addresses)</li>";

					if($numDup == 1)
						$content .= "<li>1 user already existed in the database and wasn't added</li>";
					else if($numDup > 1)
						$content .= "<li>$numDup users already existed in the database and weren't added</li>";

					if($numUpdate == 1)
						$content .= "<li>1 user details updated</li>";
					else if($numUpdate > 1)
						$content .= "<li>$numDup users details updated</li>";

					$content .= "</ul><a href=\"sendissue.php\">Send Issue</a> | <a href=\"subscriber.php\">Continue >></a>";

					MakeMsgPage('Import Subscribers', $content);

				}
			else
				{

					if($hasEmails == false)
						@$err .= "<li>You forgot to type-in or upload a file containing email addresses</li>";

					if($delim == "")
						@$err .= "<li>You forgot to select the delimeter for your subscriber list</li>";

					if(sizeof($arrNewsletterIds) == 0)
						@$err .= "<li>You forgot to select a newsletter to subscribe the emails to</li>";

					$content = "The form that you've just submitted is incomplete. Please review the errors below and then go back and correct them:";
					$content .= "<ul>$err</ul><a href=\"javascript:history.go(-1)\"><< Go Back</a>";

					MakeMsgPage('Import Subscribers', $content);

				}

		}

	function ShowSubscriberList()
		{

			// Show a list of templates currently in the database

			global $dbPrefix;

			doDbConnect();

			// Workout recordset paging

			$page = @$_GET["page"];
			$start = @$_GET["start"];
			$find = @$_GET["find"];
			$show = @$_POST["show"];

			if($show == '')
				$show = @$_GET['show'];

			$recsPerPage = 50;

			if(!is_numeric($page))
				$page = 1;

			$start = ($page * $recsPerPage) - $recsPerPage;

			// Do we use a normal query or do we have to perform a full-text search?

			if($show > 0)
				$find = '';

			if($find == "")
				{

					if($show == 0)
						{

							$countQuery = "SELECT count(pk_suId) FROM {$dbPrefix}_subscribedusers";
							$subQuery = "SELECT * FROM {$dbPrefix}_subscribedusers ORDER BY suEmail ASC LIMIT $start, 50";

						}
					else
						{

							//This shows subscribers under the selected template

							$countQuery = "SELECT count(*) FROM {$dbPrefix}_subscribedusers, {$dbPrefix}_subscriptions WHERE {$dbPrefix}_subscriptions.sNewsletterId = '$show' and {$dbPrefix}_subscriptions.sSubscriberId = {$dbPrefix}_subscribedusers.pk_suId";
							$subQuery = "SELECT * FROM {$dbPrefix}_subscribedusers, {$dbPrefix}_subscriptions WHERE {$dbPrefix}_subscriptions.sNewsletterId = '$show' AND {$dbPrefix}_subscriptions.sSubscriberId = {$dbPrefix}_subscribedusers.pk_suId ORDER BY {$dbPrefix}_subscribedusers.suEmail ASC LIMIT $start, 50";

						}

				}
			else
				{

					if($show == 0)
						{

							$countQuery = "SELECT count(pk_suId) FROM {$dbPrefix}_subscribedusers WHERE MATCH(suEmail) AGAINST('$find')";
							$subQuery = "SELECT * FROM {$dbPrefix}_subscribedusers WHERE MATCH(suEmail) AGAINST('$find') ORDER BY suEmail ASC LIMIT $start, 50";

						}

				}

			$numRows = @mysql_result(mysql_query($countQuery), 0, 0);

			$result = @mysql_query($subQuery);

			if($numRows > 50)
				{

					$nav = "Pages: ";

					if($page > 1)
						$nav = "[<a href='subscriber.php?find=$find&show=$show'>カ</a>] ";

					if($page > 1)
						$nav .= "<a href='subscriber.php?find=$find&page=" . ($page-1) . "&show=$show'><u>� Prev</u></a> | ";

					$min = 1;

					if($page - RECS_TO_SHOW > $min)
						$min = $page - RECS_TO_SHOW;

					$max = ceil($numRows / $recsPerPage);

					if($page + RECS_TO_SHOW < $max)
						$max = $page + RECS_TO_SHOW;

					for($i = $min; $i <= $max; $i++)
						if($i == $page)
							$nav .= "<b>$i</b> | ";
						else
							$nav .= "<a href='subscriber.php?find=$find&page=$i&show=$show'>$i</a> | ";

					if(($start+$recsPerPage) < $numRows && $numRows > 0)
						$nav .= "<a href='subscriber.php?find=$find&page=" . ($page+1) . "&show=$show'><u>Next �</u></a>";

					if(substr(strrev($nav), 0, 2) == " |")
						$nav = substr($nav, 0, strlen($nav)-2);

					if($page < ceil($numRows / $recsPerPage))
						$nav .= " [<a href='subscriber.php?find=$find&page=" . ceil($numRows / $recsPerPage) . "'>뻣</a>]";

					$nav .= "<br><br><i>$numRows record(s) found</i><br>&nbsp;";

				}
			else
				$nav = "";

			?>

				<script language="JavaScript">

					var chkState = 0;

					function CheckConfirmDelete()
						{

							if(confirm('WARNING: You are about to permanently delete the selected subscribers. Click OK to continue.'))
								return true;
							else
								return false;

						}

					function ToggleDel()
						{

							// Loop through the form and check any checkboxes

							var frm = document.frmSubscriber.elements;

							if(chkState == 0)
								{

									// Tick all boxes

									for(i = 0; i < frm.length; i++)
									if(frm.elements[i].type == 'checkbox')
										frm.elements[i].checked = true;

									chkState = 1;

								}
							else
								{

									// UnTick all boxes

									for(i = 0; i < frm.length; i++)
									if(frm.elements[i].type == 'checkbox')
									frm.elements[i].checked = false;

									chkState = 0;

								}

						}

				</script>

				<form name="frmSubscriber" action="subscriber.php?find=<?php echo $find; ?>" method="post">

				<input type="hidden" name="what" value="delete">

				<?php MakeMsgPage('Subscribers', 'A list of existing subscribers is shown below. To import subscribers, click the "Import Subscribers" link. To remove one/more subscribers, click the checkbox for that subscriber and then click the "Delete Selected" button.'); ?>

				<table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">

					<tr>

						<td width="100%" colspan="7" height="70" class="Info">

							<iframe frameborder="no" scrolling="no" width="100%" height="30" src="searchemails.php?find=<?php echo $find; ?>"></iframe>

							<br>

							<table width="100%" border="0" class="Info">

								<tr>

									<td>

										<a href="subscriber.php?what=import"> Import Subscribers �</a>

									</td>

									<td align="right">

										Show Subscribers From:

										<select name="show" size="1" onChange="document.frmSubscriber.what.value='';document.frmSubscriber.submit();">

											<option selected>All</option>

											<?php

												//diplays list of templates to find out which subscribers are subscribed to

												$strQuery = mysql_query("SELECT pk_nId, nName FROM {$dbPrefix}_newsletters ORDER BY nName");

												while($row = mysql_fetch_array($strQuery))
													{

														?>

															<option <?php if($row[0] == $show) echo 'selected'; ?> value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>

														<?php

													}

											?>

										</select>

									</td>

								</tr>

							</table>

						</td>

					</tr>

					<?php if($numRows > 50) { ?>

						<tr>

							<td width="100%" colspan="7" height="40" class="Info">

								<?php echo $nav; ?>

							</td>

						</tr>

					<?php } ?>

					<tr bgcolor="#787C9B">

						<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

						<td height="20" class="MenuHeading">

							<input type="checkbox" name="masterDelete" onClick="ToggleDel()">

						</td>

						<td height="20" class="MenuHeading">

							Subscriber Email

						</td>

						<td height="20" class="MenuHeading">

							Details

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

						if(@mysql_num_rows($result) == 0)
							{

								?>

									<tr>

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

										<td colspan="5" width="100%" height="25" class="Info">

											&nbsp;&nbsp;

											<?php

												if($find == "")
													echo "There are no subscribers in the database.";
												else
													echo "No results were found for search term '$find'.";

											?>

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

											<input type="checkbox" name="sId[]" value="<?php echo $row[0]; ?>">

										</td>

										<td height="20" class="TableCell">

											<a href="mailto:<?php echo $row[1]; ?>"><?php echo substr($row[1], 0, 30); ?></a>

										</td>

										<td>

											<a href="subscriber.php?what=viewdetails&id=<?php echo $row[0]; ?>">Edit Details</a>

										</td>

										<td height="20" class="TableCell">

											<?php echo MakeDate($row[4]); ?>

										</td>

										<td height="20" class="TableCell">

											<?php echo $row[3]; ?>

										</td>

										<td width="1" bgcolor="#787C9B"><img border="0" width="1" height="1" src="images/blank.gif"></td>

									</tr>

								<?php

							}

					?>

					<tr>

						<td colspan="7" bgcolor="#787C9B" height="1"></td>

					</tr>

					<tr>

						<td width="100%" colspan="7">

							<br><input onClick="return CheckConfirmDelete()"  type="submit" value="Delete Selected �">

						</td>

					</tr>

				</table>

				</form>

			<?php

		}

	function DeleteSubscribers()
		{

			// This function will remove the selected newsletters from the database

			global $dbPrefix;

			doDbConnect();

			$sId = @$_POST["sId"];

			$query = "";

			$result = "";

			if(is_array($sId) == true)
				{

					$query1 = "DELETE FROM {$dbPrefix}_subscribedusers WHERE pk_suId = " . implode(" OR pk_suId = ", $sId);
					$query2 = "DELETE FROM {$dbPrefix}_subscriptions WHERE sSubscriberId = " . implode(" OR sSubscriberId = ", $sId);

					if(@mysql_query($query1))
						$result1 = true;
					else
						$result1 = false;

					if(@mysql_query($query2))
						$result2 = true;
					else
						$result2 = false;

					if($result1 == true && $result2 == true)
						{

							// Query executed OK

							$status = "<br>You have successfully deleted one/more subscribers from the database.<br><br>";
							$status .= "<a href='subscriber.php'>Continue >></a>";

						}
					else
						{

							// Delete querie(s) failed

							$status = "<br>An error occured while trying to delete the selected subscriber(s).<br><br>";
							$status .= "<a href='javascript:document.location.reload()'>Try Again</a>";

						}

				}
			else
				{

					// No subscribers have been chosen

					$status = "<br>You didn't select one/more subscribers to delete.<br><br>";
					$status .= "<a href='javascript:history.go(-1)'>Try Again</a>";

				}

			MakeMsgPage('Delete Subscriber(s)', $status);

		}

	function ShowExportForm()
		{

			// Show the form to give users the option to export the list of email addresses

			global $dbPrefix;

			doDbConnect();

			$numSubscribers = @mysql_result(mysql_query("SELECT count(pk_suId) FROM {$dbPrefix}_subscribedusers"), 0, 0);

			$query = @mysql_query("SELECT * FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

			?>

				<script language="JavaScript">

					function ShowSample(sampleId)
						{

							var theDiv = document.all.sample;
							var incEmail = document.all.incEmail.checked;
							var incStatus = document.all.incStatus.checked;
							var incDate = document.all.incDate.checked;
							<?php

								while($row = @mysql_fetch_array($query))
									echo "var inc_cust{$row[2]} = document.all.inc_cust{$row[2]}.checked;\r\n";

							?>
							var sampleBox = "<font color='red'><b><br>";

							switch(sampleId)
								{

									case 0:
										{

											if(incEmail)
												sampleBox = sampleBox + "email|";

											if(incStatus)
												sampleBox = sampleBox + "status|";

											if(incDate)
												sampleBox = sampleBox + "date subscribed|";

											<?php

												@mysql_data_seek($query, 0);

												while($row = mysql_fetch_array($query))
													echo "if(inc_cust{$row[2]})\r\nsampleBox = sampleBox + '{$row[1]}|'\r\n";

											?>

											// Do we need to remove a trailing pipe?

											if(sampleBox.substring(sampleBox.length-1, sampleBox.length) == "|")
												sampleBox = sampleBox.substring(0, sampleBox.length-1);

											theDiv.innerHTML = sampleBox + '</b></font>';

											break;

										}

									case 1:
										{


											if(incEmail)
												sampleBox = sampleBox + "email,";

											if(incStatus)
												sampleBox = sampleBox + "status,";

											if(incDate)
												sampleBox = sampleBox + "date subscribed";


											<?php

												@mysql_data_seek($query, 0);

												while($row = mysql_fetch_array($query))
													echo "if(inc_cust{$row[2]})\r\nsampleBox = sampleBox + '{$row[1]},'\r\n";

											?>
											// Do we need to remove a trailing comma?

											if(sampleBox.substring(sampleBox.length-1, sampleBox.length) == ",")
												sampleBox = sampleBox.substring(0, sampleBox.length-1);

											theDiv.innerHTML = sampleBox + '</b></font>';

											break;

										}

									case 2:
										{

											sampleBox = sampleBox + "&lt;subscriber&gt;<br>";

											if(incEmail)
												sampleBox = sampleBox + "&nbsp;&nbsp;&lt;suEmail&gt;email&lt;/suEmail&gt;<br>";

											if(incStatus)
												sampleBox = sampleBox + "&nbsp;&nbsp;&lt;suStatus&gt;status&lt;/suStatus&gt;<br>";

											if(incDate)
												sampleBox = sampleBox + "&nbsp;&nbsp;&lt;suDateSubscribed&gt;date_subscribed&lt;/suDateSubscribed&gt;<br>";

											<?php

												@mysql_data_seek($query, 0);

												while($row = mysql_fetch_array($query))
													echo "if(inc_cust{$row[2]})\r\nsampleBox = sampleBox + '&nbsp;&nbsp;&lt;su_cust_{$row[2]}&gt;{$row[1]}&lt;/su_cust_{$row[2]}&gt;<br>'\r\n";

											?>

											sampleBox = sampleBox + "&lt;/subscriber&gt;<br>";

											theDiv.innerHTML = sampleBox + '</b></font>';

											break;

										}

								}

						}

				</script>

				<?php

					if($numSubscribers > 0)
						{

							$content = "You can export your newsletter subscribers in plain text, CSV or XML format. Complete the form below and click on the \"Export Subscribers\" button to start the export process.<br><br><b>Note:</b> Depending on how many subscribers you have, it could take anywhere from 5 seconds to 5 minutes to download your entire subscriber list to your hard drive, so please be patient.<br><br>";

							MakeMsgPage('Export Subscribers', $content, 0);

							?>

								<tr>

									<td>

										<form name="frmExport" action="subscriber.php" method="post">
										<input type="hidden" name="what" value="doExport">

										<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

											<tr>

												<td colspan="4" bgcolor="#787C9B" class="MenuHeading" height="18" valign="middle">

													Export Details

												</td>

											</tr>

											<tr>

												<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												<td width="25%" class="BodyText" valign="top">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<strong>Export Format</strong><br>

													</p>

												</td>

												<td width="75%" class="BodyText">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<select onChange="ShowSample(this.selectedIndex)" name="format" size="3" style="width:260">

															<option value="1">Plain Text (Delimeted By New Line)</option>

															<option value="2">CSV For Excel</option>

															<option value="3">XML</option>

														</select>

													</p>

												</td>

												<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											</tr>

											<tr bgcolor="#E7E8F5">

												<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												<td width="25%" class="BodyText" valign="middle">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<strong>Preview Of Output</strong><br>

													</p>

												</td>

												<td width="75%" class="BodyText">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<div id="sample">

															<i>[Please select a format first]</i>

														</div>

													</p>

												</td>

												<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											</tr>

											<tr>

												<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												<td width="25%" class="BodyText" valign="middle">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<strong>Fields</strong><br>

														Which fields should be exported?

													</p>

												</td>

												<td width="75%" class="BodyText">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<input onClick="if(format.selectedIndex > -1) { ShowSample(format.selectedIndex) }" type="checkbox" name="incEmail" CHECKED> Email Address<br>

														<input onClick="if(format.selectedIndex > -1) { ShowSample(format.selectedIndex) }" type="checkbox" name="incStatus" CHECKED> Subscriber Status<br>

														<input onClick="if(format.selectedIndex > -1) { ShowSample(format.selectedIndex) }" type="checkbox" name="incDate" CHECKED> Date Joined<br>

														<?php

															@mysql_data_seek($query, 0);

															while($row = @mysql_fetch_array($query))
																echo "<input onClick=\"if(format.selectedIndex > -1) { ShowSample(format.selectedIndex) }\" type=\"checkbox\" name=\"inc_cust{$row[2]}\" CHECKED> {$row[1]}<br>\r\n";

														?>

													</p>

												</td>

												<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											</tr>

											<tr bgcolor="#E7E8F5">

												<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												<td width="25%" class="BodyText" valign="middle">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<strong>Search</strong><br>

														Only export subscribers who match this search term

													</p>

												</td>

												<td width="75%" class="BodyText">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<input type="text" name="find" value="[None - Export All Subscribers]" onClick="if(this.value == '[None - Export All Subscribers]') { this.value = ''; }" size="40">

													</p>

												</td>

												<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											</tr>

											<tr>

												<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												<td width="25%" class="BodyText" valign="middle">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<strong>Limit</strong><br>

														How many subscribers should be exported?

													</p>

												</td>

												<td width="75%" class="BodyText">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														Export <input type="text" name="number" size="4" value="<?php echo $numSubscribers; ?>"> subscribers starting from record # <input type="text" name="start" size="4" value="0">

													</p>

												</td>

												<td width="1" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

											</tr>

											<tr bgcolor="#E7E8F5">

												<td width="1" height="18" bgcolor="#787C9B"><img src="images/blank.gif" width="1" height="1" border="0"></td>

												<td width="25%" class="BodyText" valign="middle">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<strong>Export Group</strong><br>

														If you only want to export the details of those who are subscribed to a specific newsletter, then select that newsletter here.

													</p>


												</td>

												<td width="75%" class="BodyText">

													<p style="margin-left: 5px; margin-right: 5px; margin-top: 5px; margin-bottom: 5px;">

														<select name="template" style="width: 175px;">

															<option value="all">All Subscribers</option>

															<?php

																$strQuery = mysql_query("SELECT * FROM {$dbPrefix}_newsletters");

																while($row = mysql_fetch_array($strQuery))
																	{

																		?>

																			<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>

																		<?php

																	}

															?>

														</select>

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

													<input type="button" value="� Cancel" onClick="ConfirmCancel('subscriber.php')">

													<input id="submit" type="submit" name="submit" value="Export Subscribers �">

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
					MakeMsgPage('Export Subscribers', 'You currently have 0 subscribers in your list. Please build up a list first.<br><br><a href="subscriber.php">Continue >></a>');

		}

	function ProcessExport()
		{

			global $dbPrefix;

			// This function will export the subscriber list in the selected format (text, CSV, XML)

			$format 	= @$_POST["format"];
			$incEmail 	= @$_POST["incEmail"] != "" ? true : false;
			$incStatus 	= @$_POST["incStatus"] != "" ? true : false;
			$incDate 	= @$_POST["incDate"] != "" ? true : false;
			$find 		= @$_POST["find"];
			$exportNum 	= @$_POST["number"];
			$exportFrom = @$_POST["start"];
			$template 	= @$_POST["template"];


			$query = mysql_query("SELECT * FROM {$dbPrefix}_customfields ORDER BY cfWeight DESC, cfTitle ASC");

			$var = array();

			while($row = mysql_fetch_array($query))
				{

					eval('$cust_' .$row[2] . ' = @$_POST["inc_cust'.$row[2].'"] != "" ? true : false;');

					$var[] = '$cust_' .$row[2];

				}

			$doFullText = ($find == "" || $find == "[None - Export All Subscribers]") ? false : true;

			// Is there at least one field selected to be exported?

			if(sizeof($var) > 0)
				{

					$data = '$data = ((';

					for($i = 0; $i < sizeof($var); $i++)
						{

							$data .= $var[$i];

							if($i != sizeof($var) - 1)
								$data .= " || ";

						}

					$data .= ") ? true : false);";

					eval($data);

				}
			else
				$data = false;

			$noFieldsSelected = (($incEmail || $incStatus || $incDate || $data) ? false : true);

			// Build the error list

			$err = '';

			if($format == "")
				$err .= "<li>You forgot to choose the export format</li>";

			if($noFieldsSelected == true)
				$err .= "<li>You must select at least one field to export</li>";

			if(!is_numeric($exportNum) || @($exportNum <= 0))
				$err .= "<li>You must enter a valid number of records to export</li>";

			if(!is_numeric($exportFrom) || @($exportFrom < 0))
				$err .= "<li>You must enter a valid record numer to start exporting from</li>";

			if($err != "")
				{

					// Invalid forms. Show the error list

					MakeMsgPage('Export Subscribers', 'The form that you\'ve just submitted is incomplete. Please review the errors below and then go back and correct them:<ul>' . $err . '</ul><a href="javascript:history.go(-1)"><< Go Back</a>');

				}
			else
				{

					// No errors, start the export process by building the query

					$result = $query;

					$query = "SELECT ";

					if($incEmail == true)
						$query .= "{$dbPrefix}_subscribedusers.suEmail, ";

					if($incStatus == true)
						$query .= "{$dbPrefix}_subscribedusers.suStatus, ";

					if($incDate == true)
						$query .= "{$dbPrefix}_subscribedusers.suDateSubscribed, ";

					mysql_data_seek($result, 0);

					while($row = mysql_fetch_array($result))
						eval('if($cust_' . $row[2] . ' == true) $query .= "' . $dbPrefix . '_subscribedusers.su_cust_' . $row[2] . ', "' . "?>");

					// Kill the trailing comma if it exists

					$query = ereg_replace(", $", " ", $query);

					$query .= "FROM {$dbPrefix}_subscribedusers";

					if(is_numeric($template))
						$query .= ", {$dbPrefix}_subscriptions";

					if($doFullText == true || is_numeric($template))
						$query .= " WHERE ";

					if($doFullText == true)
						$query .= "MATCH({$dbPrefix}_subscribedusers.suEmail) AGAINST('$find') ";

					if($doFullText == true && is_numeric($template))
						$query .= "and";

					if(is_numeric($template))
						$query .= " {$dbPrefix}_subscriptions.sSubscriberId = {$dbPrefix}_subscribedusers.pk_suId AND {$dbPrefix}_subscriptions.sNewsletterId = '{$template}'";

					$query .= " ORDER BY {$dbPrefix}_subscribedusers.pk_suId ASC ";
					$query .= "LIMIT $exportFrom, $exportNum";

					// Now that we have the query we have to export the results in the selected format.
					// We wil use 3 select cases to perform the different export methods

					doDbConnect();

					$result = mysql_query($query);

					// If there are no rows returned the show an error

					if(mysql_num_rows($result) == 0)
						MakeMsgPage('Export Subscribers', 'The selected export options generated a list containing 0 subscribers. Please try again.	<br><br><a href="javascript:history.go(-1)"><< Go Back</a>');
					else
						{

							ob_end_clean();

							switch($format)
								{

									case 1:
										{

											header("Content-Type: text/plain");
											header("Content-Disposition: attachment; filename=subscribers.txt");

											while($row = mysql_fetch_row($result))
												{

													for($i = 0; $i < sizeof($row); $i++)
														{

															echo $row[$i];

															if($i < sizeof($row)-1)
																echo "|";
															else
																echo "\r\n";

														}

												}

											break;

										}

									case 2:
										{

											header("Content-Type:application/vnd.ms-excel");
											header("Content-Disposition: attachment; filename=subscribers.csv");

											while($row = mysql_fetch_row($result))
												{

													for($i = 0; $i < sizeof($row); $i++)
														{

															echo $row[$i];

															if($i < sizeof($row)-1)
																echo ",";
															else
																echo "\r\n";

														}

												}

											break;

										}

									case 3:
										{

											header("Content-Type:application/xml");
											header("Content-Disposition: attachment; filename=subscribers.xml");

											echo "<subscribers>\r\n";

											while($row = mysql_fetch_array($result))
												{

													echo "  <subscriber>\r\n";

													foreach($row as $k => $v)
														if(!is_numeric($k))
															echo "    <$k>$v</$k>\r\n";

													echo "  </subscriber>\r\n";

												}


											echo "</subscribers>";

											break;

										}

								}

							die();

						}

				}

		}

	function DeleteAll()
		{

			// Delete every entry in the subscribedUsers and subscriptions tables

			global $dbPrefix;

			doDbConnect();

			$result1 = false;
			$result2 = false;

			if(@mysql_query("DELETE FROM {$dbPrefix}_subscriptions"))
				$result1 = true;
			else
				$result1 = false;

			if(@mysql_query("DELETE FROM {$dbPrefix}_subscribedusers"))
				$result2 = true;
			else
				$result2 = false;

			if($result1 == true && $result2 == true)
				MakeMsgPage('Delete Subscriber List','Your entire subscriber list and all of their subscription details have been deleted.<br><br><a href="subscriber.php">Continue >></a>');
			else
				MakeMsgPage('Delete Subscriber List','An internal error occured while trying to delete your entire subscriber list.	<br><br><a href="javascript:document.location.reload()">Try Again</a>');

		}

	include("templates/bottom.php");

?>