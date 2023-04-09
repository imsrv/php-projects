<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: admin-box.php3,v 1.16 2001/05/30 21:17:03 fluffy Exp $

if (!isSet($ADMIN_BOX_INCLUDED))
{
	$ADMIN_BOX_INCLUDED = 1;

	include('box.php3');
	include('error/error.php3');
	include('sql/sql.php3');
	include('../auth/session.php3');
	include('../auth/permissions.php3');
	include('pulldown.php3');
	include('includes/config.php3');
	include('gettext.php3');

	class SRCAdminBox extends SRCBox
	{
		function SRCAdminBox($new_action_url = "",
				$new_session_var = "")
		{
			$this->action_url = $new_action_url;
			$this->session_var = $new_session_var;
			$this->uses_headers = 0;
			$this->login_required = 1;
			$this->help_available = 1;
			$this->help_topic = _("Configuring the Calendar");
			$this->error = "";
		}

		function outputBox()
		{
			if (!$this->verifyPermissions())
			{
				$this->outputPDeniedNotice();
				return;
			}

			$this->outputAdminBox();
		}

		function outputAdminBox()
		{
			echo("<A HREF=\"" . $this->action_url .
				"&amp;form_action=output_form\"><BIG>" .
				_("Admin") . "</BIG></A>");
		}

		function outputPDeniedNotice()
		{
			echo("<P><BIG>" . _("Admin") . "</BIG><BR>\n");
			echo(_("You are not allowed to configure the calendar."));
			echo("</P>");
		}

		function outputResults()
		{
			if (!$this->verifyPermissions())
			{
				$this->outputPDeniedNotice();
				return;
			}

			echo("<BIG>" . _("Admin") . ":</BIG><BR>\n");

			$this->outputAdminMenu();
			echo("<HR>\n");

			switch ($GLOBALS["form_action"])
			{
				case "parse_item_form": $this->parseItemForm();
				case "output_item_form": $this->outputItemForm();
					break;
				case "parse_cal_form": $this->parseCalForm();
				case "output_cal_form": $this->outputCalForm();
					break;
				case "parse_user_form": $this->parseUserForm();
				case "output_user_form": $this->outputUserForm();
					break;
				case "output_form":
				default:
					break;
			}
		}

		function outputAdminMenu()
		{
			$perms = $GLOBALS[$this->session_var]->permissions_list["-1"];

			if ($perms & $GLOBALS["pConfigureItems"])
			{
				echo("<BR><STRONG>" . _("Configure Items") .
					":</STRONG><BR>\n<UL>\n");

				echo("<LI><A HREF=\"" . $this->action_url .
					"&amp;form_action=output_item_form" .
					"&amp;item=location\">" .
					_("Locations") . "</A></LI>\n");

				echo("<LI><A HREF=\"" . $this->action_url .
					"&amp;form_action=output_item_form" .
					"&amp;item=category\">" .
					_("Categories") . "</A></LI>\n");

				echo("<LI><A HREF=\"" . $this->action_url .
					"&amp;form_action=output_item_form" .
					"&amp;item=audience\">" .
					_("Audiences") . "</A></LI>\n");

				echo("</UL>\n");
			}

			if ($perms & $GLOBALS["pConfigureCalendar"])
			{
				echo("<BR>\n<A HREF=\"" . $this->action_url .
					"&amp;form_action=output_cal_form\">" .
					_("Configure the Calendar") . ".</A>");

				echo("<BR>\n<A HREF=\"" . $this->action_url .
					"&amp;form_action=output_user_form\">" .
					_("Manage Users") . ".</A>");
			}
		}


// "Configure Item" functions...
		function outputItemForm() {
// FIXME - There's a lot of dependency here on having a src$item table, which
//  contains $item_id and name columns, where "edit the following $item" also
//  makes sense.  It works for now, but isn't very flexible...

			global $item;

			echo("<BR><STRONG>" . _("Configure Items") . ":</STRONG><BR>\n");
			echo("<FORM METHOD=POST ACTION=\"" . $this->action_url ."\">\n");
			echo("<INPUT TYPE=hidden NAME=\"form_action\" VALUE=\"parse_item_form\">\n");
			echo("<INPUT TYPE=hidden NAME=\"item\" VALUE=\"$item\">\n");

			if (!$my_conn = @connectROToCalendar())
			{
				reportError($php_errormsg, "while connecting to the database");
				return;
			}

			echo(_wv("Edit the following %s1", array($item)) . ": ");
			if ($error = outputPulldownFromTable($my_conn,
				"src" . $item, $item . "_id", "name",
				"old_item"))
			{
				reportError($error, "while building a pulldown menu");
				return;
			}

			echo("<BR>\n");

			echo("<INPUT TYPE=radio NAME=\"item_action\" " .
				"VALUE=\"rename\">" . _("Rename to") . ":\n");
			echo("<INPUT TYPE=text NAME=\"renamed_item\" SIZE=15><BR>\n");

			echo("<INPUT TYPE=radio NAME=\"item_action\" " .
				"VALUE=\"replace\">" .
				_("Delete and replace with") . ":\n");

			if ($error = outputPulldownFromTable($my_conn,
				"src" . $item, $item . "_id", "name",
				"replacement_item"))
			{
				reportError($error, "while building a pulldown menu");
				return;
			}
			echo("<BR>\n");


			echo("<INPUT TYPE=radio NAME=\"item_action\" " .
				"VALUE=\"create\">" . _("Create") . ":\n");
			echo("<INPUT TYPE=text NAME=\"created_item\" SIZE=15><BR>\n");

// The submit button goes at the very bottom
			echo("<INPUT TYPE=submit VALUE=\"" . _("Edit Item") . "\">\n");
			echo("<INPUT TYPE=reset VALUE=\"" . _("Reset") . "\">\n");
			echo("<BR>\n</FORM>\n");
		}

		function parseItemForm()
		{
			global $item, $item_action, $renamed_item, $created_item;
			$old_item = parsePulldown("old_item");
			$replacement_item = parsePulldown("replacement_item");

			$perms = $GLOBALS[$this->session_var]->permissions_list["-1"];
			if (!($perms & $GLOBALS["pConfigureItems"]))
			{
				echo("<BR><STRONG>" . _("Configure Items") .
					":</STRONG><BR>\n");
				reportError(
"Permission denied.  Make sure your session has not expired.",
"while processing the &quot;Configure Items&quot; form");
				return;
			}

			switch ($GLOBALS["item_action"])
			{
				case "rename": $this->renameItem($item,
						$old_item, $renamed_item);
					break;
				case "replace": $this->replaceItem($item,
						$old_item, $replacement_item);
					break;
				case "create": $this->createItem($item,
						$created_item);
					break;
				default: echo(_("You did not select an action.") .
						"<BR>\n");
					break;
			}
		}

		function renameItem($item_type, $item_id, $new_name)
		{
			if(!$my_conn = connectRWToCalendar())
			{
				reportError($php_errormsg, "connecting to the database");
				return;
			}

			$query = "SELECT name from src" . $item_type .
				" WHERE " . $item_type . "_id = " . $item_id;

			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while renaming a " . $item_type);
				return;
			}

			if ($count = pg_numrows($result_id) != 1)
			{
				reportError(
"Search returned an unexpected number of results ($count). QUERY = $query",
"searching for the item's old name");
				return;
			}

			$old_name = pg_fetch_array($result_id, 0);
			$old_name = $old_name["name"];

			$query = "UPDATE src" . $item_type . " SET name = '" .
				$new_name . "' WHERE " . $item_type . "_id = " .
				$item_id;

			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while renaming a " . $item_type);
				return;
			}

			echo(_wv("Successfully renamed %s1 to %s2.",
				array($old_name, $new_name)));
		}

		function replaceItem($item_type, $item_id, $new_id)
		{
			if ($item_id == $new_id)
			{
				echo(_("The old and new items are the same.") .
					" " . _("Choose a different item to replace the old one.") .
					"<BR>\n");
				return;
			}

			if (!$my_conn = connectRWToCalendar())
			{
				reportError($php_errormsg, "connecting to the database");
				return;
			}

			$query = "SELECT * from src" . $item_type . " WHERE " .
				$item_type . "_id IN ( $item_id, $new_id )";

			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= $query",
					"updating the database");
				return;
			}

			if (($count = pg_numrows($result_id)) != 2)
			{
				reportError(
"Search returned an unexpected number of results ($count). QUERY = $query",
"searching for the item names");
				return;
			}

			for ($i = 0; $i < $count; $i++)
			{
				$stuff = pg_fetch_array($result_id, $i);
				if ($stuff[$item_type . "_id"] == $item_id)
				{
					$old_name = $stuff["name"];
				}
				else
				{
					$new_name = $stuff["name"];
				}
			}
			

			if (!$result_id = @pg_exec($my_conn, "BEGIN WORK"))
			{
				reportError($php_errormsg . " QUERY= BEGIN WORK",
					"updating to the database");
				return;
			}

			// FIXME - it'd be really easy to break this...
			$query = "UPDATE " . ( $item_type == "location" ?
				"srcEvent" : "src" . $item_type . "list" ) .
				" SET " . $item_type . "_id = " . $new_id .
				" WHERE " . $item_type . "_id = " . $item_id;

			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while replacing a " . $item_type);
				@pg_exec($my_conn, "ROLLBACK WORK");
				return;
			}

			$query = "DELETE from src" . $item_type . " WHERE " .
				$item_type . "_id = " . $item_id;
			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while deleting a " . $item_type);
				@pg_exec($my_conn, "ROLLBACK WORK");
				return;
			}

			if ($item_type == "location")
			{
				// also need to remove permissions for this location
				if (!$auth_conn = connectRWToAuth())
				{
					// yes, that's supposed to be $my_conn and not $auth_conn
					//  we don't want to commit unless we can do everything
					@pg_exec($my_conn, "ROLLBACK WORK");
					reportError($php_errormsg,
						"connecting to the database");
					return;
				}

				$query = "delete from permissions WHERE location_id = " . $item_id;
				if(!$result_id = @pg_exec($auth_conn, $query))
				{
					reportError($php_errormsg . " QUERY= " . $query,
						"while deleting a " . $item_type);
					@pg_exec($my_conn, "ROLLBACK WORK");
					return;
				}
			}

			if (!$result_id = @pg_exec($my_conn, "COMMIT WORK"))
			{
				reportError($php_errormsg . " QUERY= COMMIT WORK",
					"while replacing a " . $item_type);
				@pg_exec($my_conn, "ROLLBACK WORK");
				return;
			}

			echo(_wv("Successfully replaced %s1 with %s2.",
				array($old_name, $new_name)) . "<BR>\n");
		}

		function createItem($item_type, $new_name)
		{
			if (!$my_conn = connectRWToCalendar())
			{
				reportError($php_errormsg,
					"connecting to the database");
				return;
			}

			$query = "INSERT INTO src" . $item_type .
				" ( name ) VALUES ( '" . $new_name . "' )";

			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while creating a " . $item_type);
				return;
			}

			echo(_wv("Successfully created %s1.", array($new_name)) .
				"<BR>\n");
		}

// "Configure Calendar" functions...
		function outputCalForm()
		{
			echo("<BR><STRONG>" . _("Configure the Calendar") .
				":</STRONG><BR>\n");

			if (isset($GLOBALS["item"]))
			{
				if ($GLOBALS["item"] == "new")
				{
					$this->outputNewCalItemForm();
				}
				else if ($GLOBALS["item"])
				{
					$this->outputSetCalItemForm($GLOBALS["item"]);
				}
				echo("<HR>");
			}

			// Make sure we have any updated settings
			$GLOBALS["CONFIG"] = loadCalConfig();
			ksort($GLOBALS["CONFIG"]);
			reset($GLOBALS["CONFIG"]);
			while (list($key, $value) = each($GLOBALS["CONFIG"]))
			{
				echo("$key: <A HREF=\"" . $this->action_url .
					"&amp;form_action=output_cal_form" .
					"&amp;item=$key\">" .
					($value == "" ? _("*No value set*") :
						$value ) .
					"</A><BR>\n");
			}

			echo("<A HREF=\"" . $this->action_url .
				"&amp;form_action=output_cal_form" .
				"&amp;item=new\">" . _("Add new item") .
				"</A><BR>\n");
		}

		function outputNewCalItemForm()
		{
?>

<FORM METHOD=POST ACTION="<?php echo $this->action_url ?>">
<INPUT TYPE=hidden NAME="form_action" VALUE="parse_cal_form">
<INPUT TYPE=hidden NAME="item" VALUE="new">
Key: <INPUT TYPE=text NAME="key"><BR>
Value: <INPUT TYPE=text NAME="value"><BR>
Description: <TEXTAREA NAME="description" ROWS=5 COLS=50></TEXTAREA><BR>
<INPUT TYPE=reset VALUE="<?php echo _("Reset") ?>">
<INPUT TYPE=submit VALUE="<?php echo _("Save Item") ?>">
</FORM>
<?php		
		}

		function outputSetCalItemForm($key)
		{
			if (!$my_conn = connectROToCalendar())
			{
				reportError($php_errormsg,
					"connecting to the database");
				return;
			}

			$query = "SELECT description from srcConfig WHERE key = '$key'";

			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while searching for the description for $key");
				return;
			}

			if ($count = pg_numrows($result_id) != 1)
			{
				reportError(
"Search returned an unexpected number of results ($count). QUERY = $query",
"searching for $key's description");
				return;
			}

			$description = pg_fetch_array($result_id, 0);
			$description = $description["description"];

			echo("<FORM METHOD=POST ACTION=\"" . $this->action_url .
				"\">\n");
			echo("<INPUT TYPE=hidden NAME=\"form_action\" " .
				"VALUE=\"parse_cal_form\">\n");
			echo("<INPUT TYPE=hidden NAME=\"item\" " .
				"VALUE=\"$key\">\n");

			echo("$description<BR>\n");

			// Some settings get special treatment
			if ($key == "auth_module")
			{
				echo(_("Authentication module") . ":\n");
				echo("<SELECT NAME=\"new_auth_module\">\n");

				echo("<OPTION VALUE=\"auth-shadow.php3\"");
				if ($GLOBALS["CONFIG"]["auth_module"] ==
					"auth-shadow.php3")
				{
					echo(" SELECTED");
					$auth_mod_selected = 1;
				}
				echo(">Shadow\n");

				echo("<OPTION VALUE=\"auth-pam.php3\"");
				if ($GLOBALS["CONFIG"]["auth_module"] ==
					"auth-pam.php3")
				{
					echo(" SELECTED");
					$auth_mod_selected = 1;
				}
				echo(">Pam\n");

				echo("<OPTION VALUE=\"auth-nis.php3\"");
				if ($GLOBALS["CONFIG"]["auth_module"] ==
					"auth-nis.php3")
				{
					echo(" SELECTED");
					$auth_mod_selected = 1;
				}
				echo(">NIS\n");

				if (!$auth_mod_selected)
				{
					echo("<OPTION VALUE=\"" .
						$GLOBALS["CONFIG"]["auth_module"] .
						"\" SELECTED>" .
						$GLOBALS["CONFIG"]["auth_module"] .
						"\n");
				}

				echo("</SELECT><BR>\n");
			}
			else
			{
				echo("$key: <INPUT TYPE=text NAME=\"new_$key\" " .
					"SIZE=" . (strlen($GLOBALS["CONFIG"][$key]) + 5) .
					" VALUE=\"" . $GLOBALS["CONFIG"][$key] .
					"\"><BR>\n");
			}

			echo("<INPUT TYPE=checkbox NAME=\"delete_$key\" VALUE=\"buhbye\">Delete this item<BR>\n");
			echo("<INPUT TYPE=reset VALUE=\"" . _("Reset") . "\">\n");
			echo("<INPUT TYPE=submit VALUE=\"" . _("Save value") . "\">\n");
			echo("</FORM>\n");
		}

		function parseCalForm()
		{
			if ($GLOBALS["item"] == "new")
			{
				$this->parseNewCalItemForm();
			}
			else
			{
				$this->parseSetCalItemForm();
			}
		}

		function parseSetCalItemForm()
		{
			$key = $GLOBALS["item"];
			$value = $GLOBALS["new_$key"];

			if (!$my_conn = connectRWToCalendar())
			{
				reportError($php_errormsg,
					"connecting to the database");
				return;
			}

			if ($GLOBALS["delete_$key"])
			{
				$query = "DELETE FROM srcConfig WHERE key = '$key'";
				if (!$result_id = @pg_exec($my_conn, $query))
				{
					reportError($php_errormsg,
						"while removing the setting from the database");
					return;
				}

				echo(_wv("Successfully deleted %s1 from the config database.",
					array($key)) . "<BR>");
				unset($GLOBALS["item"]);
				return;
			}

			if (($key == "auth_module") || ($key == "php_utils"))
			{
				$getpwinfo = $getuidinfo = $chkpass =
					$modified = "";

				if ($key == "auth_module")
				{
					$php_utils = $GLOBALS["CONFIG"]["php_utils"];
					if (substr($php_utils, -1) != "/")
					{
						$php_utils .= "/";
					}

					switch ($value)
					{
						case "auth-shadow.php3":
							$getpwinfo = $php_utils . "getpwinfo";
							$getuidinfo = $php_utils . "getuidinfo";
							$chkpass = $php_utils . "getshcrypt";
							break;
						case "auth-pam.php3":
							$getpwinfo = $php_utils . "getpwinfo";
							$getuidinfo = $php_utils . "getuidinfo";
							$chkpass = $php_utils . "chkpass";
							break;
						case "auth-nis.php3":
							$getpwinfo = $php_utils . "getpwinfo.pl";
							$getuidinfo = $php_utils . "getpwinfo.pl";
							$chkpass = $php_utils . "runshcrypt";
							break;
					}
				}
				else
				{
					$old_utils = $GLOBALS["CONFIG"]["php_utils"];
					$old_pwinfo = $GLOBALS["CONFIG"]["getpwinfo"];
					$old_uidinfo = $GLOBALS["CONFIG"]["getuidinfo"];
					$old_chkpass = $GLOBALS["CONFIG"]["chkpass"];
					$old_utils_length = strlen( $old_utils );
					
					if (substr($value, -1) != "/")
					{
						$value .= "/";
					}

					if (substr($old_pwinfo, 0, $old_utils_length)
						== $old_utils)
					{
						$getpwinfo = $value . substr($old_pwinfo, $old_utils_length);
					}

					if (substr($old_uidinfo, 0, $old_utils_length)
						== $old_utils)
					{
						$getuidinfo = $value . substr($old_uidinfo, $old_utils_length);
					}

					if (substr($old_chkpass, 0, $old_utils_length) == $old_utils)
					{
						$chkpass = $value . substr($old_chkpass, $old_utils_length);
					}
				}

				$query = "BEGIN WORK";
				if (!$result_id = @pg_exec($my_conn, $query))
				{
					reportError($php_errormsg,
						"while preparing to save new settings to the database");
					return;
				}

				$query = "UPDATE srcConfig SET value = " .
					($value == "" ? "NULL" : "'$value'") .
					" WHERE key = '$key'";
				if (!$result_id = @pg_exec($my_conn, $query))
				{
					reportError($php_errormsg . " QUERY= " . $query,
						"while saving the new setting");
					@pg_exec($my_conn, "ROLLBACK WORK");
					return;
				}

				if ($getpwinfo)
				{
					$query = "UPDATE srcConfig SET value = '$getpwinfo' WHERE key = 'getpwinfo'";
					if(!$result_id = @pg_exec($my_conn, $query))
					{
						reportError($php_errormsg . " QUERY= " . $query,
							"while saving the new setting");
						@pg_exec($my_conn, "ROLLBACK WORK");
						return;
					}
					$modified .= "getpwinfo ";
				}

				if ($getuidinfo)
				{
					$query = "UPDATE srcConfig SET value = '$getuidinfo' WHERE key = 'getuidinfo'";
					if (!$result_id = @pg_exec($my_conn, $query))
					{
						reportError($php_errormsg . " QUERY= " . $query,
							"while saving the new setting");
						@pg_exec($my_conn, "ROLLBACK WORK");
						return;
					}
					$modified .= "getuidinfo ";
				}

				if ($chkpass)
				{
					$query = "UPDATE srcConfig SET value = '$chkpass' WHERE key = 'chkpass'";
					if (!$result_id = @pg_exec($my_conn, $query))
					{
						reportError($php_errormsg . " QUERY= " . $query,
							"while saving the new setting");
						@pg_exec($my_conn, "ROLLBACK WORK");
						return;
					}
					$modified .= "chkpass ";
				}

				if (!$result_id = @pg_exec($my_conn, "COMMIT WORK"))
				{
					reportError($php_errormsg,
						"while committing the new settings");
					@pg_exec($my_conn, "ROLLBACK WORK");
					return;
				}
				
				echo(_wv("%s1 successfully saved with value: %s2.",
					array($key, $value)) . "<BR>\n");
				if ($modified)
				{
					echo(_wv("The following settings were also updated: %s1",
						array($modified)) . "<BR>\n");
				}

			// default behavior...
			}
			else
			{
				$query = "UPDATE srcConfig SET value = " .
					($value == "" ? "NULL" : "'$value'") .
					" WHERE key = '$key'";

				if (!$result_id = @pg_exec($my_conn, $query))
				{
					reportError($php_errormsg . " QUERY= " . $query,
						"while saving the new setting");
					return;
				}

				echo(_wv("%s1 successfully saved with value: %s2.",
					array($key, $value)) . "<BR>$description<BR>");
			}

			// Make sure the form isn't printed out again.
			unset($GLOBALS["item"]);
		}

		function parseNewCalItemForm()
		{
			if (!$GLOBALS["key"])
			{
				reportError("Tried to create a new config setting without a key");
				return;
			}

			if (isSet($GLOBALS["CONFIG"][$GLOBALS["key"]]))
			{
				reportError("Tried to create a new setting with the same name as an existing setting.");
				return;
			}

			if (isSet($GLOBALS["value"]))
			{
				$value = $GLOBALS["value"];
			}
			
			if (isSet($GLOBALS["description"]))
			{
				$description = $GLOBALS["description"];
			}
			
			if (!$my_conn = connectRWToCalendar())
			{
				reportError($php_errormsg,
					"connecting to the database");
				return;
			}

			$query = "INSERT INTO srcConfig ( key, value, description ) VALUES ( '" .
				$GLOBALS["key"] . "', " .
				(isSet($value) && ($value != "") ?
					"'$value'" : "NULL") . ", " .
				(isSet($description) && ($description != "") ?
					"'$description' " : "NULL") . " )";

			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while storing the new config setting in the database");
				return;
			}

			echo(_wv("%s1 successfully saved with value: %s2.",
				array($GLOBALS["key"], $value)) .
				"<BR>$description<BR>");

			// Make sure the form isn't printed out again.
			unset($GLOBALS["item"]);
		}

// "Manage Users" functions...
		function outputUserForm()
		{
			echo("<BR><STRONG>" . _("Manage Users") .
				":</STRONG><BR>\n");

			if (isSet( $GLOBALS["user"]))
			{
				if ($GLOBALS["user"] == "new")
				{
					$this->outputNewUserForm();
				}
				else
				{
					$this->outputEditUserForm();
				}
			}

			if (!$my_conn = connectROToAuth())
			{
				reportError($php_errormsg,
					"connecting to the database");
				return;
			}

			$query = "SELECT DISTINCT user_id from permissions ORDER BY user_id ASC";

			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while searching for the description for $key");
				return;
			}

			if (($count = pg_numrows($result_id)) == 0)
			{
				echo(_("There are currently no users with assigned permissions.") . "<BR>\n");
			}
			else
			{
				echo(_("The following users have been assigned permissions") . ":<BR>\n");
				for ($i = 0; $i < $count; $i++)
				{
					$user_id = pg_fetch_array($result_id, $i);
					$user_id = $user_id["user_id"];

					// Get the user information
					$dummy = "";
					exec($GLOBALS["CONFIG"]["getuidinfo"] .
						" " . $user_id, $dummy,
						$err_num);

					if ($err_num)
					{
						reportError("Could not retrieve user information.");
						return;
					}

					$temp_array = split(":", $dummy[0]);
					$username = $temp_array[0];

					echo("<A HREF=\"" . $this->action_url .
						"&amp;form_action=output_user_form" .
						"&amp;user=" . $user_id .
						"&amp;username=$username\">" .
						"$username</A><BR>\n");
				}

				echo("<A HREF=\"" . $this->action_url .
					"&amp;form_action=output_user_form" .
					"&amp;user=new\">");
				echo(_("Add a new user") . "</A><BR>\n");
			}
		}

		function outputNewUserForm()
		{
?>
<FORM METHOD=POST ACTION="<?php echo $this->action_url ?>">
<INPUT TYPE=hidden NAME="form_action" VALUE="parse_user_form">
<INPUT TYPE=hidden NAME="user" VALUE="new">
Username: <INPUT TYPE=text NAME="username"><BR>
<INPUT TYPE=reset VALUE="<?php echo(_("Reset")) ?>">
<INPUT TYPE=submit VALUE="<?php echo(_("Add user")) ?>">
</FORM>
<HR>
<?
		}

		function outputEditUserForm()
		{
			global $user, $username, $pReadOnly,
				$pApproveOwn, $pApproveOther,
				$pDeleteOwn, $pDeleteOther,
				$pModifyOwn, $pModifyOther,
				$pConfigureItems, $pConfigureCalendar;

			if (!$my_conn = connectROToAuth())
			{
				reportError($php_errormsg,
					"connecting to the database");
				return;
			}

			$query = "SELECT * FROM permissions WHERE user_id = $user";
			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while searching for the user's permissions");
				return;
			}

			$count = pg_numrows($result_id);
			$perms = "";			
			for ($i = 0; $i < $count; $i++)
			{
				$temp_array = pg_fetch_array($result_id, $i);
				$perms[(string)$temp_array["location_id"]] = $temp_array["permissions"];
			}

			if (!$my_conn = connectROToCalendar())
			{
				reportError($php_errormsg,
					"connecting to the database");
				return;
			}
			
			$query = "SELECT * FROM srclocation ORDER BY name ASC";

			if (!$result_id = @pg_exec($my_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while searching for a list of locations");
				return;
			}
?>
<FORM METHOD=POST ACTION="<?php echo $this->action_url ?>">
<INPUT TYPE=hidden NAME="form_action" VALUE="parse_user_form">
<INPUT TYPE=hidden NAME="user" VALUE="<?php echo $user ?>">
<INPUT TYPE=hidden NAME="username" VALUE="<?php echo $username ?>">
Permissions for user <?php echo $username ?>:<BR>
<?php
			$count = pg_numrows($result_id);
			
			echo("<INPUT TYPE=radio NAME=\"read_only\" " .
				"VALUE=\"$pReadOnly\"" .
				($perms["-1"] == $pReadOnly ?
				" CHECKED" : "") . ">");
			echo(_("User is not allowed to submit events, or do anything else really.") . "<BR>\n");
			echo("<INPUT TYPE=radio NAME=\"read_only\" VALUE=0" .
				($perms["-1"] != $pReadOnly ?
				" CHECKED" : "") . ">");
			echo(_("User is assigned the following permissions") .
				":<BR>\n");
			for ($i = -1; $i < $count; $i++)
			{
				$lid = $location = "";
				if ($i == -1)
				{
					$lid = -1;
					$location = _("All locations");
				} else {
					$temp_array = pg_fetch_array($result_id, $i);
					$lid = $temp_array["location_id"];
					$location = $temp_array["name"];
				}

				echo("<STRONG>" . _("Location") .
					": $location</STRONG><BR>\n");

				// We don't want a permission of -1 to show up
				// as everything being enabled in the
				// checkboxes below
				$perm = ($perms["$lid"] > 0 ?
					$perms["$lid"] : 0);

				if ($lid == -1)
				{
					echo("<INPUT TYPE=checkbox " .
						"NAME=\"configure_items_-1\" " .
						"VALUE=\"" . $pConfigureItems .
						"\"" . (($perm & $pConfigureItems) ?
							" CHECKED" : "") . ">" .
						_("Configure Items") . "\n");
					echo("<INPUT TYPE=checkbox " .
						"NAME=\"configure_calendar_-1\" " .
						"VALUE=\"" . $pConfigureCalendar .
						"\"" . (($perm & $pConfigureCalendar) ?
							" CHECKED" : "") . ">" .
						_("Configure the Calendar") .
						"<BR>\n");
				}

				echo("<INPUT TYPE=checkbox " .
					"NAME=\"approve_own_$lid\" " .
					"VALUE=\"" . $pApproveOwn .
					"\"" . ($perm & $pApproveOwn ?
						" CHECKED" : "" ) . ">" .
					_("Approve Own") . "\n");
				echo("<INPUT TYPE=checkbox " .
					"NAME=\"approve_other_$lid\" " .
					"VALUE=\"" . $pApproveOther .
					"\"" . ($perm & $pApproveOther ?
						" CHECKED" : "" ) . ">" .
					_("Approve Other") . "<BR>\n");
				echo("<INPUT TYPE=checkbox " .
					"NAME=\"delete_own_$lid\" " .
					"VALUE=\"" . $pDeleteOwn .
					"\"" . ($perm & $pDeleteOwn ?
						" CHECKED" : "" ) . ">" .
					_("Delete Own") . "\n");
				echo("<INPUT TYPE=checkbox " .
					"NAME=\"delete_other_$lid\" " .
					"VALUE=\"" . $pDeleteOther .
					"\"" . ($perm & $pDeleteOther ?
						" CHECKED" : "" ) . ">" .
					_("Delete Other") . "<BR>\n");
				echo("<INPUT TYPE=checkbox " .
					"NAME=\"modify_own_$lid\" " .
					"VALUE=\"" . $pModifyOwn .
					"\"" . ($perm & $pModifyOwn ?
						" CHECKED" : "" ) . ">" .
					_("Modify Own") . "\n");
				echo("<INPUT TYPE=checkbox " .
					"NAME=\"modify_other_$lid\" " .
					"VALUE=\"" . $pModifyOther .
					"\"" . ($perm & $pModifyOther ?
						" CHECKED" : "" ) . ">" .
					_("Modify Other") . "<BR>\n");
			}

			echo("<INPUT TYPE=reset VALUE=\"" . _("Reset") ."\"> ");
			echo("<INPUT TYPE=submit VALUE=\"" . _("Save Changes") .
				"\">\n</FORM>\n<HR>\n");
		}

		function parseUserForm()
		{
			if ($GLOBALS["user"] == "new")
			{
				$this->parseNewUserForm();
			}
			else
			{
				$this->parseEditUserForm();
			}		
		}

		// get the user ID for the user and set $GLOBALS["user"]
		//  so outputEditUserForm gets a user ID
		function parseNewUserForm()
		{
			$dummy = "";
			exec($GLOBALS["CONFIG"]["getpwinfo"] . " " .
				$GLOBALS["username"], $dummy, $err_num);
			if ($err_num)
			{
				reportError("Could not retrieve user information.");
				return;
			}
			$temp_array = split(":", $dummy[0]);
			$GLOBALS["user"] = $temp_array[2];
		}

		function parseEditUserForm()
		{
			global $user, $pReadOnly;

			if (!$auth_conn = connectRWToAuth())
			{
				reportError($php_errormsg,
					"connecting to the database");
				return;
			}

			if (!$result_id = @pg_exec($auth_conn, "BEGIN WORK"))
			{
				reportError($php_errormsg,
					"while preparing to save new settings to the database");
				return;
			}

			$query = "DELETE FROM permissions WHERE user_id = $user";
			if (!$result_id = @pg_exec( $auth_conn, $query))
			{
				reportError($php_errormsg . " QUERY= " . $query,
					"while clearing old permissions");
				@pg_exec($auth_conn, "ROLLBACK WORK");
				return;
			}

			if ($GLOBALS["read_only"] == $pReadOnly)
			{
				$query = "INSERT INTO permissions (user_id, location_id, permissions) VALUES ($user, -1, $pReadOnly)";
				if (!$result_id = @pg_exec($auth_conn, $query))
				{
					reportError($php_errormsg . " QUERY= " . $query,
						"while saving new permissions");
					@pg_exec($auth_conn, "ROLLBACK WORK");
					return;
				}

				if (!$result_id = @pg_exec($auth_conn, "COMMIT WORK"))
				{
					reportError($php_errormsg,
						"while committing new permissions");
					@pg_exec($auth_conn, "ROLLBACK WORK");
					return;
				}
			}
			else
			{
				if (!$cal_conn = connectROToCalendar())
				{
					reportError($php_errormsg, "connecting to the database");
					return;
				}
			
				$query = "SELECT location_id FROM srclocation ORDER BY location_id ASC";

				if (!$cal_result_id = @pg_exec($cal_conn, $query))
				{
					reportError($php_errormsg . " QUERY= " . $query,
						"while searching for a list of locations");
					return;
				}

				$count = pg_numrows($cal_result_id);

				for ($i = -1; $i < $count; $i++)
				{
					$lid = "";
					$perm = 0;

					if ($i == -1)
					{
						$lid = -1;
						$perm += $GLOBALS["configure_items_-1"] +
							$GLOBALS["configure_calendar_-1"];
					}
					else
					{
						$temp_array = pg_fetch_array($cal_result_id, $i);
						$lid = $temp_array["location_id"];
					}

					$perm += $GLOBALS["approve_own_$lid"] +
						$GLOBALS["approve_other_$lid"] +
						$GLOBALS["delete_own_$lid"] +
						$GLOBALS["delete_other_$lid"] +
						$GLOBALS["modify_own_$lid"] +
						$GLOBALS["modify_other_$lid"];

					if ($perm != 0)
					{
						$query = "INSERT INTO permissions (user_id, location_id, permissions)" .
							" VALUES ($user, $lid, $perm)";
						if (!$result_id = @pg_exec($auth_conn, $query))
						{
							reportError($php_errormsg . " QUERY= " . $query,
								"while saving new permissions");
							@pg_exec($auth_conn, "ROLLBACK WORK");
							return;
						}
					}
				}

				if (!$result_id = @pg_exec($auth_conn, "COMMIT WORK"))
				{
					reportError($php_errormsg,
						"while committing new permissions");
					@pg_exec($auth_conn, "ROLLBACK WORK");
					return;
				}
			}

			echo(_("Successfully saved permissions.") . "<BR>\n");
		}

// Standard box stuff...
		function verifyPermissions()
		{
			$perms_list = $GLOBALS[$this->session_var]->permissions_list;
			if (isSet($perms_list["-1"]) &&
				($perms_list["-1"] & $GLOBALS["pConfigureAll"]))
			{
				return 1;
			}

			return 0;
		}

		function outputHelp()
		{
			echo("<BIG>" . $this->help_topic . "</BIG>\n");
?>
<P>If you have the ability to configure the calendar, then logging in
should make available an &quot;Admin&quot; box.  Opening the Admin box
will display three options: Configure Items, Configure Calendar, and
Manage Users.</P>

<P>The Configure Items option show the different lists of items that
you can edit.  These are the lists of locations, categories, etc. that
users have to choose from when submitting events.  Choosing a list to
edit will display a form with a popup list at the top.  Using this list
you may choose an item to rename or replace.  You may then choose to
rename that item, delete the item from the list and update any events
using that item to point to an existing item chosen from a second popup,
or create a new item in the list.
</P>

<P>The Configure Calendar option displays a list of settings that the
calendar uses.  To change a setting or view a description of what the
setting is, click on the value of the setting.  Removing settings from
the database entirely can be done by clicking the item's value, checking
the "Delete this item" box, and clicking the "Save value" button.  You
can also add completely new settings by clicking the link beneath the
list of existing settings.</P>

<P>The Manage Users option displays a list of users who have permissions
set in the database.  (By default, a user has read- and submit-only
access and will not be displayed here.)  To edit a user's privilages,
click their username in this list.  If a user is not listed, click the
"Add a new user" link and type their username into the field displayed.
Note that this does not create a user account, but simply stores access
information for an existing user in the database.  After choosing a user,
a form is displayed in which permissions can be editted.  A user can
either be denied access to anything, or they can be assigned permissions
from the list displayed.  The permissions to configure the calendar are
assigned under the "All locations" location.  Any permissions enabled
in this location apply to all locations.  Otherwise they must be assigned
for the specific location.</P>
<?php
		}

	}
}
?>
