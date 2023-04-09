<?

	$ListName = @$_REQUEST["ListName"];
	$Name = @$_REQUEST["Name"];
	$Save = @$_REQUEST["Save"];
	$HTMLBODY = @$_REQUEST["wysiwyg"];
	$TEXTBODY = @$_REQUEST["TEXTBODY"];
	$Action = @$_REQUEST["Action"];
	$Format = @$_REQUEST["Format"];
	$TemplateID = @$_REQUEST["TemplateID"];
	$TempID = @$_REQUEST["TempID"];
	$TempName = @$_REQUEST["TempName"];
	$Editing = @$_REQUEST["Editing"];

	$alllists = "";

	if($Action == "PreviewTopFrame")
	{
		ob_end_clean();
		ob_start();
		?>
		<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0">
		
		<script>

			function switchView(i)
			{
				if(i == "View HTML Version")
				{
					top.frames[1].document.location.href = '<?php echo MakeAdminLink("templates?Action=Preview&TempID=$TempID&Format=html"); ?>';
					
				}
				else
				{
					top.frames[1].document.location.href = '<?php echo MakeAdminLink("templates?Action=Preview&TempID=$TempID&Format=text"); ?>';
				}

			}

		</script>

		<div align="right" style="padding: 5">
			<select id="f" onChange="switchView(this.options[this.selectedIndex].text)" style="font-family: Verdana; font-size: 9px">
		<?php

		switch($Format)
		{
			case 1: // HTML
			{
			?>
				<option value="html">View HTML Version</option>
			<?php
				break;
			}
			case 2: // text
			{
			?>
				<option value="text">View Text Version</option>
			<?php
				break;
			}
			case 3: // Mixed
			{
			?>
				<option value="html">View HTML Version</option>
				<option value="text">View Text Version</option>
			<?php
				break;
			}
		}
		?>
			</select>
		</div>
		</body>
		<?php
			die();
	}

	if($Action=="PreviewPopup")
	{
		$tResult = mysql_query("select * from " . $TABLEPREFIX . "templates where TemplateID = $TempID");

		if($tRow = mysql_fetch_array($tResult))
		{
			ob_end_clean();
			ob_start();

			if($tRow["Format"] == 3)
				$theFormat = "html";
			else if($tRow["Format"] == 2)
				$theFormat = "text";
			else
				$theFormat = "html";
			?>
				<frameset rows="35,*">
					<frame src="<?php echo MakeAdminLink("templates?Action=PreviewTopFrame&TempID=$TempID&Format=" . $tRow["Format"]); ?>">
					<frame src="<?php echo MakeAdminLink("templates?Action=Preview&TempID=$TempID&Format=" . $theFormat); ?>">
				</frameset>
			<?php
			
			ob_end_flush();
			die();
		}
		else
		{
			// The newsletter doesn't exist
			$OUTPUT .= MakeErrorBox("An Error Occured", "<br>The selected template no longer exists.");
		}
	}

	if($Action=="Preview")
	{
		$tResult = mysql_query("select * from " . $TABLEPREFIX . "templates where TemplateID = $TempID");

		if($tRow = mysql_fetch_array($tResult))
		{
			ob_end_clean();
			ob_start();

			if($Format == "text")
				$theContent = str_replace("\n", "<br>", $tRow["TextContent"]);
			else
				$theContent = $tRow["HTMLContent"];

			echo $theContent;
			
			ob_end_flush();
			die();
		}
		else
		{
			// The template doesn't exist
			$OUTPUT .= MakeErrorBox("An Error Occured", "<br>The selected template no longer exists.");
		}
	}

	if($Action == "Copy")
	{
		// Copy the template to a new record
		$tResult = @mysql_query("select * from " . $TABLEPREFIX . "templates where TemplateID = '$TempID'");

		if($tRow = @mysql_fetch_array($tResult))
		{
			$iQuery = "insert into templates values(0,'" . addslashes($TempName) . "','" . $tRow["Format"] . "','" . time() . "','" . addslashes($tRow["TextContent"]) . "','" . addslashes($tRow["HTMLContent"] ). "','" . $CURRENTADMIN["AdminID"] . "')";

			if(@mysql_query($iQuery))
			{
				$OUTPUT .= MakeSuccessBox("Template Copied Successfully", "The selected template has been copied successfully.", MakeAdminLink("templates?Action="));
			}
			else
			{
				// Couldn't run the query
				$OUTPUT .= MakeErrorBox("An Error Occured", "<br>The selected template couldn't be copied.");
			}
		}
		else
		{
			$OUTPUT .= MakeErrorBox("An Error Occured", "<br>The selected template no longer exists.");
		}
	}

	if($Action == "CopyForm")
	{
		// Show the form to copy one newsletter to another
		$TempName = @mysql_result(@mysql_query("select TemplateName from " . $TABLEPREFIX . "templates where TemplateID = $TempID"), 0, 0);
		$req = "<span class=req>*</span> ";

		$FORM_ITEMS[$req . "Template Name"]="textfield|TempName:100:44:Copy of " . $TempName;
		$HELP_ITEMS["TempName"]["Title"] = "Template Name";
		$HELP_ITEMS["TempName"]["Content"] = "Enter a name for the new template here.";

		$FORM_ITEMS[-1]="submit|Copy Template:1-templates";
		$RandomKey=uniqid("p");
		$FORM_ITEMS[-12]="hidden|RandomKey:$RandomKey";

		$FORM=new AdminForm;
		$FORM->title="CopyTemp";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("templates?Action=Copy&TempID=$TempID");
		$FORM->MakeForm("Copy Template");

		$FORM->output = "Complete the form below to copy the selected template.<br>" . $FORM->output;
		$OUTPUT.=MakeBox("Copy Template (Step 1 of 1)",$FORM->output);

		$OUTPUT .= '

			<script language="JavaScript">

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.TempName.value == "")
					{
						alert("Please enter a name for this template.");
						f.TempName.focus();
						return false;
					}

					return true;
				}
			
			</script>
		';
	
	}

	if($Action == "Add")
	{
		$DontDo = 1;
		$req = "<span class=req>*</span> ";

		$FORM_ITEMS[$req . "Template Name"]="textfield|Name:100:44:";
		$HELP_ITEMS["Name"]["Title"] = "Template Name";
		$HELP_ITEMS["Name"]["Content"] = "The template name will only be used in the control panel to help you identify this template.";

		$FORM_ITEMS[$req . "Format"]="select|Format:1:1->HTML;2->Text;3->HTML and Text";
		$HELP_ITEMS["Format"]["Title"] = "Format";
		$HELP_ITEMS["Format"]["Content"] = "Which type of template would you like to create? Text, HTML or both?";

		$FORM_ITEMS[-1]="submit|Continue to Step 2:1-templates";

		$FORM=new AdminForm;
		$FORM->title="AddTemplate";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("templates?Action=AddTemplate");
		$FORM->MakeForm("New Template Details");

		$FORM->output = "Complete the form below to create a new template.<br>Click on the \"Continue to Step 2\" button to continue." . $FORM->output;
			
		$OUTPUT .= MakeBox("Create Template (Step 1 of 2)",$FORM->output);
		$OUTPUT .= '

			<script language="JavaScript">

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.Name.value == "")
					{
						alert("Please enter a name for this template.");
						f.Name.focus();
						return false;
					}
				}
			
			</script>
		';
	}

	if($Action=="ViewTags"){
		$POPOUTPUT=1;
		include $ROOTDIR."admin$DIRSLASH"."includes$DIRSLASH"."emailtags.inc.php";
	}

	if($Action=="AddTemplate"){
		mysql_query("INSERT INTO " . $TABLEPREFIX . "templates SET TemplateName='$Name', DateCreated='$SYSTEMTIME', AdminID='" . $CURRENTADMIN["AdminID"] . "'");
		$TempID=mysql_insert_id();
		$Action="EditTemplate";
	}

	if($Action=="DeleteTemplate"){
		mysql_query("DELETE FROM " . $TABLEPREFIX . "templates WHERE TemplateID='$TempID'");
		$Action="";
	}

	if($Action=="EditTemplate"){

		if($Save)
		{
			mysql_query("UPDATE " . $TABLEPREFIX . "templates SET TemplateName = '$Name', Format='$Format', HTMLContent='" . addslashes($HTMLBODY) . "', TextContent='" . addslashes($TEXTBODY) . "' WHERE TemplateID='$TempID'");

			$OUTPUT .= MakeSuccessBox("Template Saved Successfully", "The selected template has been saved successfully.", MakeAdminLink("templates?Action="));
		}
		else
		{

			$TemplateType = "";

			switch($Format)
			{
				case 1:
					$TemplateType = "HTML";
					break;
				case 2:
					$TemplateType = "text";
					break;
				case 3:
					$TemplateType = "mixed";
					break;
			}

			$Composed = @mysql_fetch_array(@mysql_query("SELECT * FROM " . $TABLEPREFIX . "templates WHERE TemplateID = '$TempID'"));

			if($Format == "")
				$Format = $Composed["Format"];

			$req = "<span class=req>*</span> ";
			$noreq = "&nbsp;&nbsp;&nbsp;";

			$FORM_ITEMS[$req . "Template Name"]="textfield|Name:100:100:" . $Composed["TemplateName"];
			$HELP_ITEMS["Name"]["Title"] = "Template Name";
			$HELP_ITEMS["Name"]["Content"] = "Enter a name for this template. The template name will be used in the control panel for your reference only.";

			$FORM_ITEMS[-2]="spacer|&nbsp;";
			$FORM_ITEMS[-20]="hidden|Format:$Format";
			$FORM_ITEMS[-21]="hidden|TemplateID:$TempID";

			if($Format == 1 || $Format == 3)
			{		
				$FORM_ITEMS[$req . "HTML Template Content"]="wysiwyg|HTMLBODY:64:10:".str_replace(":",'$$COLON$$', $Composed["HTMLContent"]);
				$HELP_ITEMS["HTMLBODY"]["Title"] = "HTML Template Content";
				$HELP_ITEMS["HTMLBODY"]["Content"] = "Enter the HTML for your newsletter template here.";

				$FORM_ITEMS[-9]="spacer|<br>[ <a href=javascript:void(0) onClick=toggleMergePopup(1,1)>Insert HTML Merge Field</a> ]";
			}

			if($Format == 3)
			{
				$FORM_ITEMS[-7]="spacer|<br>[ <a href=javascript:extractHTMLtoText()>Extract Text from HTML »</a> ]<br>&nbsp;";
			}

			if($Format == 2 || $Format == 3)
			{
				$FORM_ITEMS[$req . "Text Template Content"]="textarea|TEXTBODY:102:20:".str_replace(":",'$$COLON$$', str_replace("\r\n", "&#10;", $Composed["TextContent"]));
				$HELP_ITEMS["TEXTBODY"]["Title"] = "Text Template Content";
				$HELP_ITEMS["TEXTBODY"]["Content"] = "Enter the text for your newsletter template here.";

				$FORM_ITEMS[-11]="spacer|<br>[<a href=javascript:void(0) onClick=toggleMergePopup(2,0)>Insert Text Merge Field</a>]";
				$FORM_ITEMS[-10]="spacer|&nbsp;";
			}

			$OUTPUT .= '

				<script language="JavaScript">

					function extractHTMLtoText()
					{
						var f = document.forms[0];
						f.TEXTBODY.value = foo.document.body.innerText;
					}

					function CheckForm()
					{
						var f = document.forms[0];
						
			';
			
			// What type of newsletter is being created? HTML, text or both?
			if($Format == 1 || $Format == 3)
			{
				$OUTPUT .= '

						f.wysiwyg.value = foo.document.documentElement.outerHTML;

						if(f.wysiwyg.value == "" || foo.document.body.innerText == "")
						{
							alert("Please enter some HTML content for your template.");
							foo.focus();
							return false;
						}
				';
			}

			if($Format == 2 || $Format == 3)
			{
				$OUTPUT .= '

						if(f.TEXTBODY.value == "")
						{
							alert("Please enter some text content for your template.");
							f.TEXTBODY.focus();
							return false;
						}
				';
			}

			$OUTPUT .= '

						return true;
					}
				
				</script>
			';
			
			$FORM_ITEMS[-1]="submit|Save Template:1-templates";
			$RandomKey=uniqid("t");
			$FORM_ITEMS[-12]="hidden|RandomKey:$RandomKey";
			
			$FORM=new AdminForm;
			$FORM->title="EditTemplate";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("templates?Action=EditTemplate&TempID=$TempID&Save=Yes");
			$FORM->MakeForm("New Template Content");

			if($Editing == "")
			{
				$OUTPUT .= MakeBox("Create Template (Step 2 of 2)",$FORM->output);
				$FORM->output = "Complete the form below to create a $TemplateType template." . $FORM->output;
			}
			else
			{
				$OUTPUT .= MakeBox("Update Newsletter Template",$FORM->output);
				$FORM->output = "Complete the form below to update this newsletter template." . $FORM->output;
			}

			$OUTPUT .= GenerateMergeFieldInserts();
		}
	}

	if($Action=="")
	{
		if($CURRENTADMIN["Manager"] == 1)
		{
			$templates=mysql_query("SELECT * FROM " . $TABLEPREFIX . "templates ORDER BY TemplateName ASC");
		}
		else
		{
			$templates=mysql_query("SELECT * FROM " . $TABLEPREFIX . "templates WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY TemplateName ASC");
		}

		if(mysql_num_rows($templates) > 0)
		{		
			$TO = '
			
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
				  <tr>
					<td width=4% class="headbold bevel5">&nbsp;</td>
					<td class="headbold bevel5" width=45%>
						Template Name
					</td>
					<td class="headbold bevel5" width=15%>
						Format
					</td>
					<td class="headbold bevel5" width=15%>
						Date Created
					</td>
					<td class="headbold bevel5" width=21%>
						Action
					</td>
				</tr>
			';

			while($temp=mysql_fetch_array($templates))
			{
				$Format = "";

				switch($temp["Format"])
				{
					case 1:
						$Format = "HTML";
						break;
					case 2:
						$Format = "Text";
						break;
					case 3:
						$Format = "HTML + Text";
						break;
				}

				$TO .= '

					<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
						<td height=20 class="body bevel4" width=4% class="body">
							<img src="' . $ROOTURL . 'admin/images/template.gif" width="16" height="13">
						</td>
						<td class="body bevel4" width=45%>' . $temp["TemplateName"] . '</td>
						<td class="body bevel4" width=15%>' . $Format . '</td>
						<td class="body bevel4" width=15%>' . DisplayDate($temp["DateCreated"]) . '</td>
						<td class="body bevel4" width=21%>';

				$TO .= MakeLink("templates?Action=PreviewPopup&TempID=".$temp["TemplateID"],"View",0,0, "_blank")  . "&nbsp;&nbsp;&nbsp;";
				$TO .= MakeLink("templates?Action=EditTemplate&TempID=".$temp["TemplateID"]."&Editing=1","Edit")  . "&nbsp;&nbsp;&nbsp;";
				$TO .= MakeLink("templates?Action=CopyForm&TempID=".$temp["TemplateID"],"Copy") . "&nbsp;&nbsp;&nbsp;";
				$TO .= MakeLink("templates?Action=DeleteTemplate&TempID=".$temp["TemplateID"],"Delete",1);

				$TO .= '
					</tr>
				';
			}
			
			$TO.='</table>';

			$TO = 'Use the form below to review, edit and delete newsletter templates.<br>To create a new template, click on the "Create Template" button below.<br><br><input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("templates?Action=Add") . '\'" value="Create Template"><br><br>' . $TO;
		}
		else
		{
			// There are no templates in the list
			$TO = 'No newsletter templates have been created. Click "Create Template" to create one.<br><br><input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("templates?Action=Add") . '"\' value="Create Template"><br><br>';
		}

		$OUTPUT.=MakeBox("Manage Newsletter Templates", $TO);

	}

?>