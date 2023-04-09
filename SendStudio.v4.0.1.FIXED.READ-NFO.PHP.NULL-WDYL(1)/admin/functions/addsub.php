<?

	$Action = @$_REQUEST["Action"];
	$ListID = @$_REQUEST["ListID"];
	$AbFormat = @$_REQUEST["AbFormat"];
	$ConfStatus = @$_REQUEST["ConfStatus"];
	$Status = @$_REQUEST["Status"];
	$Method = @$_REQUEST["Method"];
	$Email = @$_REQUEST["Email"];
	$LinkField = @$_REQUEST["LinkField"];

	$alllists = "";
	$data = "";
	$OUTPUT = "";
	$MaxFields = 0;
	$t = 0;
	$ins = "";
	$Error = 0;

	if($Action == "AddFromForm")
	{
		// Does a member already exist in the database for this list with the same email address?
		$exists = mysql_result(mysql_query("select count(*) from " . $TABLEPREFIX . "members where Email='$Email' and ListID='$ListID'"), 0, 0) == 0 ? false : true;
		
		if($exists)
		{
			// Duplicate entry
			$OUTPUT .= MakeErrorBox("Duplicate Subscriber Entry", "<br>A subscriber with the email address '$Email' already exists in this mailing list.");
		}
		else
		{
			// Email is OK, make sure all required fields are completed
			$listRows = mysql_query("select * from " . $TABLEPREFIX . "list_fields where AdminID='" . $CURRENTADMIN["AdminID"] . "'");
			$fieldErr = "";

			while($listRow = mysql_fetch_array($listRows))
			{
				if($listRow["Required"] == 1)
				{
					// Make sure the user has specified a value for this field.
					// If they haven't, build an error list
					if($Fields[$listRow["FieldID"]] == "")
						$fieldErr .= "<li>The field '" . $listRow["FieldName"] . "' can't be left empty</li>";
				}
			}

			// Are there any incomplete fields?
			if($fieldErr != "")
			{
				// Some of the fields weren't completed
				$OUTPUT .= MakeErrorBox("Subscriber Fields Incomplete", "<br>Some errors occured while trying to add this subscriber:<ul>$fieldErr</ul>");
			}
			else
			{
				// All of the required fields are completed. Firstly, add
				// this subscriber to the members table
				if($AbFormat == "text")
					$Format = "0";
				else
					$Format = "1";

				if(@mysql_query("insert into " . $TABLEPREFIX . "members(ListID, Email, SubscribeDate, Format, Status, Confirmed) values('$ListID', '$Email', '" . mktime(0,0,0,date("m"),date("d"),date("y")) . "', '" . $Format . "', '" . $Status . "', '" . $ConfStatus . "')"))
				{
					// Subscriber added to members table OK. Let's now add the custom fields to the list_field_values table
					$memberId = @mysql_insert_id();
					if(@sizeof($Fields) > 0)
					{
						// Add the values for the custom fields
						foreach($Fields as $k=>$v)
						{
							// Is this field a checkbox? If yes, change its value accordingly
							$fType = @mysql_result(@mysql_query("select FieldType from " . $TABLEPREFIX . "list_fields where FieldID = $k"), 0, 0);

							if($fType == "checkbox" && $v != "")
								$v = "checked";

							@mysql_query("insert into " . $TABLEPREFIX . "list_field_values(FieldID, ListID, UserID, Value) values('$k', '$ListID', '$memberId', '$v')");
						}

						// Output a success message
						if(@mysql_error() == "")
						{
							@ob_end_clean();
							@ob_start();

							$OUTPUT .= MakeSuccessBox("Subscriber Added Successfully", "'$Email' has been added successfully. To add another subscriber, click on the 'Add Subscriber' button. Click 'OK' to continue.", MakeAdminLink("index"), MakeAdminLink("addsub?Action=ViaForm&ListID=$ListID"), "Add Subscriber", false, "", "", "", "", "", "");
						}
						else
						{
							$OUTPUT .= MakeErrorBox("Couldn't Add Subscriber", "<br>An error occured while trying to add this subscriber.");
						}
					}
					else
					{
							@ob_end_clean();
							@ob_start();

							$OUTPUT .= MakeSuccessBox("Subscriber Added Successfully", "'$Email' has been added successfully. To add another subscriber, click on the 'Add Subscriber' button. Click 'OK' to continue.", MakeAdminLink("index"), MakeAdminLink("addsub?Action=ViaForm&ListID=$ListID"), "Add Subscriber", false, "", "", "", "", "", "");
					}
				}
				else
				{
					// An error occured while trying to add this subscriber
					$OUTPUT .= MakeErrorBox("Couldn't Add Subscriber", "<br>An error occured while trying to add this subscriber.");
				}
			}
		}
	}

	if($Action == "ViaForm")
	{
		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		$FORM_ITEMS["-3"]="hidden|ListID:$ListID";

		$FORM_ITEMS[$req . "Email"]="textfield|Email:100:44:";
		$HELP_ITEMS["Email"]["Title"] = "Email";
		$HELP_ITEMS["Email"]["Content"] = "This subscribers email address.";

		$list = @mysql_fetch_array(@mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID = $ListID ORDER BY ListName ASC"));

		if($list["Formats"] == 1)
		{
			$FORM_ITEMS[$req . "Format"] = "select|AbFormat:1:text->Text;html->HTML:";
		}
		else if($list["Formats"] == 2)
		{
			$FORM_ITEMS[$req . "Format"] = "select|AbFormat:text:text->Text Only";
		}
		else
		{
			$FORM_ITEMS[$req . "Format"] = "select|AbFormat:html:html->HTML Only";
		}

		$HELP_ITEMS["AbFormat"]["Title"] = "Format";
		$HELP_ITEMS["AbFormat"]["Content"] = "Which newsletter format should this subscriber be \'flagged\' to receive? Text or HTML?";

		$FORM_ITEMS[$req . "Status"]="select|Status:1:0->Inactive;1->Active:1";
		$HELP_ITEMS["Status"]["Title"] = "Status";
		$HELP_ITEMS["Status"]["Content"] = "When this subscriber is added, should he/she be marked as active or inactive?";

		$FORM_ITEMS[$req . "Confirmed"] = "select|ConfStatus:1:1->Confirmed;0->Unconfirmed";
		$HELP_ITEMS["ConfStatus"]["Title"] = "Status";
		$HELP_ITEMS["ConfStatus"]["Content"] = "If a subscriber was to join your list using a normal subscription form with \'Requires Confirmation\' enabled, then they would be marked as unconfirmed until they click on the confirmation link inside the email automatically sent to them.";

		$size = $min = $max = $Width = $Height = 0;

			//extra fields
			$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");
			while($f=mysql_fetch_array($fields)){
				if($f["Required"] == 1)
					$req = "<span class=req>*</span> ";
				else
					$req = "&nbsp;&nbsp;&nbsp;";

				switch($f["FieldType"]){
					case "shorttext":
						@list($size,$min,$max)=explode(",",@$f["AllValues"]);
						$FORM_ITEMS[$req . $f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:$max:44";
					break;
					
					case "longtext":
						list($Width,$Height)=explode(",",$f["AllValues"]);
						$FORM_ITEMS[$req . $f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:500:44";
					break;
					
					case "checkbox":
						$FORM_ITEMS[$req . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:y->Yes;n->No:n";
					break;
				
					case "dropdown":
						$FORM_ITEMS[$req . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:".$f["AllValues"].":";
					break;
				}
			}

		$FORM_ITEMS["-1"]="submit|Add Subscriber:1-members";

		//make the form
		$FORM=new AdminForm;
		$FORM->title="ViaForm";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("addsub?Action=AddFromForm");
		$FORM->MakeForm("New Subscriber Details");

		$FORM->output = "Complete the form below to add a single subscriber. Click on the continue button to proceed." . $FORM->output;

		$OUTPUT.=MakeBox("Add Subscriber (Step 2 of 2)",$FORM->output);
		$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{
						var f = document.forms[0];

						if(f.Email.value.indexOf(".") == -1 || f.Email.value.indexOf("@") == -1)
						{
							alert("Please enter a valid email address for this subscriber.");
							f.Email.focus();
							f.Email.select();
							return false;
						}

						return true;
					}
				
				</script>
			';	
	}

	if($Action == "")
	{
		//select ListID form!
		$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists ORDER BY ListName ASC");
		while($l=mysql_fetch_array($lists))
		{
			if(AllowList($l["ListID"]))
			{
				$numSubs = (int)@mysql_result(@mysql_query("select count(MemberID) from " . $TABLEPREFIX . "members where ListID=" . $l["ListID"]), 0, 0);

				if($numSubs == 1)
					$subs = "1 subscriber";
				else
					$subs = $numSubs . " subscribers";

				$alllists.=$l["ListID"]."->".$l["ListName"]." ($subs);";
			}
		}

		$req = "<span class=req>*</span> ";

		$FORM_ITEMS[$req . "Mailing List"]="select|ListID:5:$alllists";

		$FORM_ITEMS["-1"]="submit|Continue to Step 2:1-members";
		$FORM=new AdminForm;
		$FORM->title="SelectList";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("addsub?Action=ViaForm");
		$FORM->MakeForm("Import Details");

		$FORM->output = "Before you can add a subscriber, please choose a mailing list to work with." . $FORM->output;

		$OUTPUT.=MakeBox("Add Subscriber (Step 1 of 2)",$FORM->output);
		$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.ListID.selectedIndex == -1)
							{
								alert("Please select a list to work with first.");
								f.ListID.focus();
								return false;
							}
						}
					
					</script>
				';
	}

?>