<?

	$Action = @$_REQUEST["Action"];
	$Delete = @$_REQUEST["Delete"];
	$CreateNewList = @$_REQUEST["CreateNewList"];
	$Edit = @$_REQUEST["Edit"];
	$DontDo = @$_REQUEST["DontDo"];
	$SubEdit = @$_REQUEST["SubEdit"];
	$New = @$_REQUEST["New"];
	$SubSave = @$_REQUEST["SubSave"];
	$Save = @$_REQUEST["Save"];
	$EditingField = @$_REQUEST["EditingField"];
	$SubDelete = @$_REQUEST["SubDelete"];
	$ListName = @$_REQUEST["ListName"];
	$Status = @$_REQUEST["Status"];
	$CanSubscribe = @$_REQUEST["CanSubscribe"];
	$CanUnSubscribe = @$_REQUEST["CanUnSubscribe"];
	$Formats = @$_REQUEST["Formats"];
	$FieldName = @$_REQUEST["FieldName"];
	$FieldType = @$_REQUEST["FieldType"];
	$ListID = @$_REQUEST["ListID"];
	$Required = @$_REQUEST["Required"];
	$DefaultValue = @$_REQUEST["DefaultValue"];
	$Size = @$_REQUEST["Size"];
	$Min = @$_REQUEST["Min"];
	$Max = @$_REQUEST["Max"];
	$Width = @$_REQUEST["Width"];
	$Height = @$_REQUEST["Height"];
	$Value = @$_REQUEST["Value"];
	$Label = @$_REQUEST["Label"];
	$AllValues = @$_REQUEST["AllValues"];
	$Formats = @$_REQUEST["Formats"];
	$WebmasterName = @$_REQUEST["WebmasterName"];
	$WebmasterEmail = @$_REQUEST["WebmasterEmail"];
	$BouceEmail = @$_REQUEST["BounceEmail"];
	$EmailServer = @$_REQUEST["EmailServer"];
	$EmailUser = @$_REQUEST["EmailUser"];
	$EmailPassword = @$_REQUEST["EmailPassword"];
	$BounceHandler = @$_REQUEST["BounceHandler"];
	$Err = @$_REQUEST["Err"];
	$Msg = @$_REQUEST["Msg"];

	$alltypes = "";
	$all_vals = "";
	$OUTPUT = "";

	if($Action == "BounceSuccess")
	{
		$OUTPUT .= MakeSuccessBox("Bounce Processing Completed", $Msg, MakeAdminLink("lists"));
		$DontDo = 1;
	}

	if($Action == "BounceError")
	{
		$OUTPUT .= MakeErrorBox("An Error Occured", "<br>$Err");
		$DontDo = 1;
	}

	if($Action == "DoBounce")
	{
		ob_end_clean();
		ob_start();

		// Now that we have the variables, lets output the frames
		echo '<HTML>
		<HEAD>
		<TITLE>Processing Bounces...</TITLE>
		</HEAD>
		<frameset rows="100,0,*" border="0">
		<frame name="logo" src="'.MakeAdminLink("lists?Action=BounceLogo").'" scrolling="no">
		<frame name="info" src="'.MakeAdminLink("lists?Action=DoBouncing&ListID=$ListID&BounceEmail=$BounceEmail&EmailServer=$EmailServer&EmailUser=$EmailUser&EmailPassword=$EmailPassword&BounceHandler=$BounceHandler").'" scrolling="no">
		<frame name="sending" src="'.MakeAdminLink("lists?Action=BounceInfo").'" scrolling="no">
		</frameset>
		</HTML>';

		die();		

	}

	if($Action == "BounceInfo")
	{
		@ob_end_clean();
		@ob_start();
		?>
			<script>

				window.onError = function() { return true; }

				if(parent.frames[0].completed == 0)
				{
					parent.frames[2].document.write('<p align="justify" style="margin-left:40; margin-right:30"><font face="verdana" color="white"><font size="2"><b>:: Bounce Information ::</b></font><font size="1"><br><br>Bounced emails are currently being processed. Please do not close this window. <font color="yellow"><b>' + parent.frames[0].numProcessed + '</b></font> bounces have been processed so far...</font></p>');
				}
				else
				{
					if(parent.parent.window.opener.document.title)
					{
						if(parent.frames[0].numProcessed == 1)
						{
							parent.parent.window.opener.document.location.href = "<?php echo MakeAdminLink("lists?Action=BounceSuccess"); ?>&Msg="+parent.frames[0].numProcessed+"%20bounced%20email%20was%20processed%20successfully.";
						}
						else
						{
							parent.parent.window.opener.document.location.href = "<?php echo MakeAdminLink("lists?Action=BounceSuccess"); ?>&Msg="+parent.frames[0].numProcessed+"%20bounced%20emails%20were%20processed%20successfully.";
						}
					}

					parent.parent.window.close();
				}

			</script>

			<body bgcolor="red">
			</body>
		<?php
		die();
	}

	if($Action == "DoBouncing")
	{
		@ob_end_clean();
		@ob_start();

		// Start the bounce handling process
		$inbox = imap_open("{". $EmailServer . ":110/pop3}INBOX", $EmailUser, $EmailPassword);
		$numProcessed = 0;
		$ignorePhrases = array("postmaster");

		if($inbox)
		{
			// We've logged in OK, lets check the inbox
			$total = @imap_num_msg($inbox);

			if($total > 0)
			{
				// There's at least 1 email that we can check, let's go!
				for($i = 1; $i <= $total; $i++)
				{
					// Get the body and regex out the email portion, which is <xxxxxxxxx>
					$emailBody = imap_body($inbox, $i);
					$lPos = strpos($emailBody, "<");
					$rPos = strpos($emailBody, ">");

					if(is_numeric($lPos) && is_numeric($rPos))
					{
						$emailAddress = addslashes(substr($emailBody, $lPos + 1, $rPos - $lPos - 1));

						// Is this an email address? If not, ignore it
						if(in_array($emailAddress, $ignorePhrases))
						{
							$lPos = strpos($emailBody, "<", $lPos + 1);
							$rPos = strpos($emailBody, ">", $lPos + 1);
							$emailAddress = substr($emailBody, $lPos + 1, $rPos - $lPos - 1);
						}

						if($emailAddress != "")
						{
							// Let's see if we can find this email address in the database
							$exists = @mysql_result(@mysql_query("SELECT COUNT(*) FROM " . $TABLEPREFIX . "members WHERE Email='$emailAddress' AND ListID = '$ListID'"), 0, 0) == 0 ? false : true;

							if($exists)
							{
								// The subscriber exists, update his status, depending on which bounce handler has been chosen
								if($BounceHandler == "bounce")
								{
									// Set their status to inactive (0)
									@mysql_query("UPDATE " . $TABLEPREFIX . "members SET Status = 0 WHERE Email='$emailAddress' AND ListID = '$ListID'");
									$numProcessed++;
								}
								else
								{
									// Remove them from the mailing list
									@mysql_query("DELETE FROM " . $TABLEPREFIX . "members WHERE Email='$emailAddress' AND ListID = '$ListID'");
									$numProcessed++;
								}

								// Remove the email from the inbox
								imap_delete($inbox, $i);

								// Update the info frame
								?>
									<script>
										parent.frames[0].numProcessed = parent.frames[0].numProcessed + 1;
										parent.frames[2].document.location.reload();
									</script>
								<?php
							}
						}
					}
					?>
						<script>
							parent.frames[2].document.location.reload();
						</script>
					<?php
				}

				// All done, let's tell JavaScript to close the window
				@imap_expunge($inbox);
				@imap_close($inbox);
				?>
					<script>parent.frames[0].completed = 1;</script>
				<?php
			}
			else
			{
				$Msg = "The selected mailing list contains no bounced emails.";
			?>
				<script language="JavaScript">
					parent.window.close();
					parent.window.opener.document.location.href = '<?php echo MakeAdminLink("lists?Action=BounceSuccess&Msg=$Msg"); ?>';
				</script>
			<?php
			}
		}
		else
		{
			$Err = urlencode("Your email login details were incorrect.");
		?>
			<script language="JavaScript">
				parent.window.close();
				parent.window.opener.document.location.href = '<?php echo MakeAdminLink("lists?Action=BounceError&Err=$Err"); ?>';
			</script>

		<?php
		}

		@imap_close($inbox);
		die();
	}

	if($Action == "BounceLogo")
	{
		@ob_end_clean();
		@ob_start();

		echo '
			<script>
				var numProcessed = 0;
				var completed = 0;
			</script>
			<body bgcolor=red marginleft=0 margintop=0>
			<table cellspacing=0 cellpadding=0 width=100% align=center border=0>
			  <tr>
				<td valign=center align=center class=send><img height=57 src="';
		
		echo $ROOTURL;
		
		echo 'admin/images/logo.gif" width=294 border=0></td>
				<td valign=center class=send></td>
			  </tr>
			</table>
			</body>
		';

		die();
	}

	if($Action == "DoBounceHandler")
	{
		$DontDo = 1;

		$BE = "";
		$BE .= "You are now ready to run the \"Process Bounced Emails\" wizard. <br>Click on the \"Start Processing\" button below to start processing bounced emails.<br><br>";
		$BE .= "<input type=button onClick='window.open(\"" . MakeAdminLink("lists?Action=DoBounce&ListID=$ListID&BounceEmail=$BounceEmail&EmailServer=$EmailServer&EmailUser=$EmailUser&EmailPassword=$EmailPassword&BounceHandler=$BounceHandler") . "\", \"processBounced\", \"width=300,height=300, left=400,top=300\")' value='Start Processing' class=Button>&nbsp;<input class=cancel onClick='if(confirm(\"Are you sure?\")) { document.location.href=\"" . MakeAdminLink("lists") . "\" }' type=button value=Cancel>";

		$OUTPUT .= MakeBox("Process Bounced Emails (Step 2 of 2)", $BE);
	}

	if($Action == "GetBounceLogin")
	{
		// Get the login for the POP3 email account
		$DontDo = 1;

		// Does the server have the required imap extension installed?
		if(!@function_exists("imap_open"))
		{
			$OUTPUT .= MakeErrorBox("IMAP Functionality Unavailable", "<br>Unfortunately your web server does not have support for IMAP email setup. Please contact your web host.");
		}
		else
		{
			$req = "<span class=req>*</span> ";

			$FORM_ITEMS[$req . "Bounce Email Address"]="textfield|BounceEmail:100:44:";
			$HELP_ITEMS["BounceEmail"]["Title"] = "Bounce Email Address";
			$HELP_ITEMS["BounceEmail"]["Content"] = "Enter the email address that you specified as the Return-Path when you sent a newsletter to this list.";

			$FORM_ITEMS[$req . "Email Server"]="textfield|EmailServer:100:44:";
			$HELP_ITEMS["EmailServer"]["Title"] = "Bounce Email Address";
			$HELP_ITEMS["EmailServer"]["Content"] = "Enter the server where your mail is hosted for the bounce email address that you specified above.";

			$FORM_ITEMS[$req . "Email Username"]="textfield|EmailUser:100:44:";
			$HELP_ITEMS["EmailUser"]["Title"] = "Email Username";
			$HELP_ITEMS["EmailUser"]["Content"] = "Enter the username to check email for the bounce email address that you specified above.";

			$FORM_ITEMS[$req . "Email Password"]="password|EmailPassword:100:44:";
			$HELP_ITEMS["EmailPassword"]["Title"] = "Email Password";
			$HELP_ITEMS["EmailPassword"]["Content"] = "Enter the password to check email for the bounce email address that you specified above.";

			$FORM_ITEMS[$req . "Bounce Handler"]="select|BounceHandler:1:bounce->Mark as Inactive;delete->Delete from List";
			$HELP_ITEMS["BounceHandler"]["Title"] = "Bounce Handler";
			$HELP_ITEMS["BounceHandler"]["Content"] = "What would you like to happen to bounced email addresses? Choose \'Mark as Inactive\' to simply mark them as inactive but not to delete them. Choose \'Delete from List\' to remove them from the mailing list completely.";
			
			$FORM_ITEMS[-3]="hidden|ListID:$ListID";
			$FORM_ITEMS["-1"]="submit|Continue";

			$FORM=new AdminForm;
			$FORM->title="GetLogin";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("lists?Action=DoBounceHandler");
			$FORM->MakeForm("POP3 Account Details");

			$FORM->output = "Please enter the details required for processing email bounces below." . $FORM->output;
				
			$OUTPUT.=MakeBox("Process Bounced Emails (Step 1 of 2)",$FORM->output);
			$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{
						var f = document.forms[0];

						if(f.BounceEmail.value.indexOf(".") == -1 || f.BounceEmail.value.indexOf("@") == -1)
						{
							alert("Please enter a valid email address for the bounce handler first.");
							f.BounceEmail.focus();
							return false;
						}

						if(f.EmailServer.value == "")
						{
							alert("Please enter the server where your mail is hosted for this email account.");
							f.EmailServer.focus();
							return false;
						}

						if(f.EmailUser.value == "")
						{
							alert("Please enter the username to check email for this email account.");
							f.EmailUser.focus();
							return false;
						}

						if(f.EmailPassword.value == "")
						{
							alert("Please enter the password to check email for this email account.");
							f.EmailPassword.focus();
							return false;
						}

						return true;
					}
				
				</script>
			';
		}
	}

	if($Action == "Add")
	{
		// Is this user allowed to add a list?
		$canCreate = false;

		if(($CURRENTADMIN["Root"] == 1 && $CURRENTADMIN["Manager"] == 1))
		{
			$canCreate = true;
		}
		else
		{
			$lists = @mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists INNER JOIN " . $TABLEPREFIX . "allow_lists ON " . $TABLEPREFIX . "lists.ListID = " . $TABLEPREFIX . "allow_lists.ListID WHERE " . $TABLEPREFIX . "allow_lists.AdminID = " . $CURRENTADMIN["AdminID"] . " ORDER BY " . $TABLEPREFIX . "lists.ListName ASC");
			$maxLists = $CURRENTADMIN["MaxLists"];
			$numLists = @mysql_num_rows($lists);
			$numListsLeft = (int)$maxLists - (int)$numLists;

			if($maxLists == 0 || $numListsLeft > 0)
				$canCreate = true;
			else
				$canCreate = false;
		}

		if($canCreate)
		{
			//make new list!
			$List=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='$ListID' ORDER BY ListName ASC"));
			$DontDo = true;
			$req = "<span class=req>*</span> ";

			$FORM_ITEMS[$req . "List Name"]="textfield|ListName:50:44:";
			$HELP_ITEMS["ListName"]["Title"] = "List Name";
			$HELP_ITEMS["ListName"]["Content"] = "The name of this list as it will appear both in the control panel and on your subscription forms.";

			$FORM_ITEMS[$req . "List Owners Name"]="textfield|WebmasterName:50:44:";
			$HELP_ITEMS["WebmasterName"]["Title"] = "List Owners Name";
			$HELP_ITEMS["WebmasterName"]["Content"] = "The name of the person who owns this mailing list.";

			$FORM_ITEMS[$req . "List Owners Email"]="textfield|WebmasterEmail:50:44:";
			$HELP_ITEMS["WebmasterEmail"]["Title"] = "List Owners Name";
			$HELP_ITEMS["WebmasterEmail"]["Content"] = "The email address of the person who owns this mailing list.";

			$FORM_ITEMS["-3"]="hidden|Status:1";

			$FORM_ITEMS[$req . "Allow Subscriptions"]="select|CanSubscribe:1:0->No;1->Yes:1";
			$HELP_ITEMS["CanSubscribe"]["Title"] = "Allow Subscriptions";
			$HELP_ITEMS["CanSubscribe"]["Content"] = "Can this list accept subscriptions? If yes, tick this box.";

			$FORM_ITEMS[$req . "Allow Unsubscriptions"]="select|CanUnSubscribe:1:0->No;1->Yes:1";
			$HELP_ITEMS["CanUnSubscribe"]["Title"] = "Allow Unsubscriptions";
			$HELP_ITEMS["CanUnSubscribe"]["Content"] = "Can this list accept unsubscriptions? If yes, tick this box.";

			$FORM_ITEMS[$req . "Newsletter Formats"]="select|Formats:1:1->Text and HTML;2->Text Only;3->HTML Only:1";
			$HELP_ITEMS["Formats"]["Title"] = "Newsletter Formats";
			$HELP_ITEMS["Formats"]["Content"] = "Which type of newsletters would you like to be able to create for this mailing list? text, HTML or both?";

			$FORM_ITEMS["-1"]="submit|Create List:1-lists";

			//make the form
			$FORM=new AdminForm;
			$FORM->title="CreateList";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("lists?CreateNewList=Now");
			$FORM->MakeForm("New List Details");

			$FORM->output = "Complete the form below to create a new mailing list." . $FORM->output;	
			$OUTPUT .= MakeBox("Create Mailing List", $FORM->output);

			$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{
						var f = document.forms[0];

						if(f.ListName.value == "")
						{
							alert("Please enter a name for this mailing list.");
							f.ListName.focus();
							return false;
						}

						if(f.WebmasterName.value == "")
						{
							alert("Please enter the name of the person who owns this mailing list.");
							f.WebmasterName.focus();
							return false;
						}

						if(f.WebmasterEmail.value.indexOf(".") == -1 || f.WebmasterEmail.value.indexOf("@") == -1)
						{
							alert("Please enter the email address of the person who owns this mailing list.");
							f.WebmasterEmail.focus();
							return false;
						}

						return true;
					}
				
				</script>
			';
		}
		else
		{
			// User doesn't have permission to create a new list
			$OUTPUT .= MakeErrorBox("Permission Denied", "<br>You are not allowed to create any more mailing lists.");
			$DontDo = true;
		}
	}

	if($Delete=="List")
	{
		mysql_query("DELETE FROM " . $TABLEPREFIX . "lists WHERE ListID='$ListID'");
		mysql_query("DELETE FROM " . $TABLEPREFIX . "members WHERE ListID='$ListID'");
		mysql_query("DELETE FROM " . $TABLEPREFIX . "allow_lists WHERE ListID='$ListID'");
	}

	if($CreateNewList=="Now")
	{
		// Create a new mailing list
		mysql_query("INSERT INTO " . $TABLEPREFIX . "lists SET ListName='$ListName', CreatedOn='".time()."', CanSubscribe='$CanSubscribe', CanUnsubscribe='$CanUnSubscribe', Status='$Status', Formats='$Formats', WebmasterName='$WebmasterName', WebmasterEmail='$WebmasterEmail'");

		// Give this user permissions to view and edit the list
		mysql_query("INSERT INTO " . $TABLEPREFIX . "allow_lists SET AdminID='" . $CURRENTADMIN["AdminID"] . "', ListID='" . mysql_insert_id() . "'");

		$OUTPUT .= MakeSuccessBox("Mailing List Created Successfully", "The mailing list that you created has been saved successfully.", MakeAdminLink("lists"));
		$DontDo = 1;
	}

	if($Edit=="List")
	{
		if($Save)
		{
			mysql_query("UPDATE " . $TABLEPREFIX . "lists SET ListName='$ListName', Formats='$Formats', WebmasterName='$WebmasterName', WebmasterEmail='$WebmasterEmail', Status='$Status', CanSubscribe='$CanSubscribe', CanUnSubscribe='$CanUnSubscribe' WHERE ListID='$ListID'");

			$OUTPUT .= MakeSuccessBox("Mailing List Updated Successfully", "The selected mailing list has been updated successfully.", MakeAdminLink("lists"));

			$DontDo = 1;
		}
		else
		{
			$req = "<span class=req>*</span> ";
			$List=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='$ListID' ORDER BY ListName ASC"));

			$FORM_ITEMS[$req . "List Name"]="textfield|ListName:50:44:".$List["ListName"];
			$HELP_ITEMS["ListName"]["Title"] = "List Name";
			$HELP_ITEMS["ListName"]["Content"] = "The name of this list as it will appear both in the control panel and on your subscription forms.";

			$FORM_ITEMS[$req . "List Owners Name"]="textfield|WebmasterName:50:44:".$List["WebmasterName"];
			$HELP_ITEMS["WebmasterName"]["Title"] = "List Owners Name";
			$HELP_ITEMS["WebmasterName"]["Content"] = "The name of the person who owns this mailing list.";

			$FORM_ITEMS[$req . "List Owners Email"]="textfield|WebmasterEmail:50:44:".$List["WebmasterEmail"];
			$HELP_ITEMS["WebmasterEmail"]["Title"] = "List Owners Name";
			$HELP_ITEMS["WebmasterEmail"]["Content"] = "The email address of the person who owns this mailing list.";

			$FORM_ITEMS["-3"]="hidden|Status:1";
			
			$FORM_ITEMS[$req . "Allow Subscriptions"]="select|CanSubscribe:1:0->No;1->Yes:".$List["CanSubscribe"];
			$HELP_ITEMS["CanSubscribe"]["Title"] = "Allow Subscriptions";
			$HELP_ITEMS["CanSubscribe"]["Content"] = "Can this list accept subscriptions? If yes, tick this box.";
			
			$FORM_ITEMS[$req . "Allow Unsubscriptions"]="select|CanUnSubscribe:1:0->No;1->Yes:".$List["CanUnSubscribe"];
			$HELP_ITEMS["CanUnSubscribe"]["Title"] = "Allow Unsubscriptions";
			$HELP_ITEMS["CanUnSubscribe"]["Content"] = "Can this list accept unsubscriptions? If yes, tick this box.";
			
			$FORM_ITEMS[$req . "Allowed Formats"]="select|Formats:1:1->Text and HTML;2->Text Only;3->HTML Only:".$List["Formats"];
			$HELP_ITEMS["Formats"]["Title"] = "Newsletter Formats";
			$HELP_ITEMS["Formats"]["Content"] = "Which type of newsletters would you like to be able to create for this mailing list? text, HTML or both?";
			
			$FORM_ITEMS["-1"]="submit|Save Changes:1-lists";

			//make the form
			$FORM=new AdminForm;
			$FORM->title="EditList";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("lists?Edit=List&Save=1&ListID=$ListID");
			$FORM->MakeForm("Mailing List Details");
					
			$OUTPUT.=MakeBox("Edit Mailing List",$FORM->output);
			$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{
						var f = document.forms[0];

						if(f.ListName.value == "")
						{
							alert("Please enter a name for this mailing list.");
							f.ListName.focus();
							return false;
						}

						if(f.WebmasterName.value == "")
						{
							alert("Please enter the name of the person who owns this mailing list.");
							f.WebmasterName.focus();
							return false;
						}

						if(f.WebmasterEmail.value.indexOf(".") == -1 || f.WebmasterEmail.value.indexOf("@") == -1)
						{
							alert("Please enter the email address of the person who owns this mailing list.");
							f.WebmasterEmail.focus();
							return false;
						}

						return true;
					}
				
				</script>
			';

			$DontDo=1;
		}
	}

	if(!$DontDo)
	{
		//current lists!
		if(($CURRENTADMIN["Root"] == 1 && $CURRENTADMIN["Manager"] == 1))
			$lists = @mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists ORDER BY ListName ASC");
		else
			$lists = @mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists INNER JOIN " . $TABLEPREFIX . "allow_lists ON " . $TABLEPREFIX . "lists.ListID = " . $TABLEPREFIX . "allow_lists.ListID WHERE " . $TABLEPREFIX . "allow_lists.AdminID = " . $CURRENTADMIN["AdminID"] . " ORDER BY " . $TABLEPREFIX . "lists.ListName ASC");
		
		$maxLists = $CURRENTADMIN["MaxLists"];
		$numLists = @mysql_num_rows($lists);
		$numListsLeft = (int)$maxLists - (int)$numLists;

		if($numLists > 0)
		{
			$AllLists='
			
				<script language="JavaScript">

					function selectOn(trObject)
					{
						for(i = 0; i <= 4; i++)
						{
							trObject.childNodes[i].className = "body bevel4 rowSelectOn";
						}
					}

					function selectOut(trObject, whichStyle)
					{
						for(i = 0; i <= 4; i++)
							trObject.childNodes[i].className = "body bevel4";
					}
				
				</script>

				<table width=100% border=0 cellspacing=2 cellpadding=2>
				';

				if($numListsLeft > 0)
				{
					$AllLists .= '
					  <tr>
						<td width=100% colspan=5 class="headbar">
							&nbsp;(You are allowed to create ' . $numListsLeft . ' more mailing list';
					  
					  if($numListsLeft != 1)
						  $AllLists .= "s";

					  $AllLists .= ')
					  </tr>
					';
				}

				$AllLists .= '
				  <tr>
					<td width=4% class="headbold bevel5">&nbsp;</td>
					<td class="headbold bevel5" width=30%>
						List Name
					</td>
					<td class="headbold bevel5" width=15%>
						Created
					</td>
					<td class="headbold bevel5" width=15%>
						Subscribers
					</td>
					<td class="headbold bevel5" width=36%>
						Action
					</td>
				</tr>
			';
			
			while($l=mysql_fetch_array($lists))
			{
				$AllLists .= '

					<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
						<td height=20 class="body bevel4" width=4% class="body">
							<img src="' . $ROOTURL . 'admin/images/list.gif" width="16" height="13">
						</td>
						<td class="body bevel4" width=30%>' . $l["ListName"] . '</td>
						<td class="body bevel4" width=15%>' . DisplayDate($l["CreatedOn"]) . '</td>
						<td class="body bevel4" width=15%>' . @(int)mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE ListID='".$l["ListID"]."'"))  . '</td>
						<td class="body bevel4" width=36%>';

						$AllLists .= MakeLink("forms?Action=Add", "Create Subscription Form") . "&nbsp;&nbsp;&nbsp;";

						// Are there any bounces that we can handle for this list?
						$numBounces = @mysql_result(@mysql_query("SELECT COUNT(*) FROM " . $TABLEPREFIX . "sends WHERE EmailsSent > 0 AND ListID=" . $l["ListID"]), 0, 0);

						if($numBounces > 0)
							$AllLists .= MakeLink("lists?Action=GetBounceLogin&ListID=".$l["ListID"], "Process Bounces") . "&nbsp;&nbsp;&nbsp;";
						else
							$AllLists .= "<span class=disabled>Process Bounces</span>&nbsp;&nbsp;&nbsp;";

						$AllLists .= MakeLink("lists?Edit=List&ListID=".$l["ListID"], "Edit") . "&nbsp;&nbsp;&nbsp;";
						$AllLists .= MakeLink("lists?Delete=List&ListID=".$l["ListID"], "Delete",1);

				$AllLists .= '		
						</td>
					</tr>
				';
			}

			$AllLists .= '</table>';

			$Heading = 'Use the form below to review, edit and delete mailing lists.';

			if($maxLists == 0 || $numListsLeft > 0 || ($CURRENTADMIN["Root"] == 1 && $CURRENTADMIN["Manager"] == 1))
				$Heading .= '<br>To create a new mailing list, click on the "Create Mailing List" button below.<br><br><input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("lists?Action=Add") . '\'" value="Create Mailing List"><br><br>';
			else
				$Heading .= "<br><br>";
			
			$AllLists = $Heading . $AllLists;
		}
		else
		{
			$AllLists = 'No mailing lists have been created. Please click on the "Create Mailing List" button below to create one.<br><br><input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("lists?Action=Add") . '\'" value="Create Mailing List"><br><br>';
		}

		$OUTPUT.=MakeBox("Manage Mailing Lists", $AllLists);
	}

?>