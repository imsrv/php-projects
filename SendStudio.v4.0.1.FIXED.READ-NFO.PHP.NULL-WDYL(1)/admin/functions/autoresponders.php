<?

$Action = @$_REQUEST["Action"];
$SubAction = @$_REQUEST["SubAction"];
$ListID = @$_REQUEST["ListID"];
$Save = @$_REQUEST["Save"];
$TempID = @$_REQUEST["TempID"];
$Subject = @$_REQUEST["Subject"];
$HoursAfter = @$_REQUEST["HoursAfter"];
$HTMLBODY = @$_REQUEST["wysiwyg"];
$TEXTBODY = @$_REQUEST["TEXTBODY"];
$Subject = @$_REQUEST["Subject"];
$SendFrom = @$_REQUEST["SendFrom"];
$SubmitButton = @$_REQUEST["SubmitButton"];
$Format = @$_REQUEST["Format"];

$alllists = "";
$alltemps = "";
$OUTPUT = "";
$AO = "";

if($Action=="Edit"){
		
		if($Save){
			mysql_query("UPDATE " . $TABLEPREFIX . "autoresponders SET HTMLBody='".addslashes($HTMLBODY)."', TextBody='".addslashes($TEXTBODY)."', Subject='" . addslashes($Subject) . "', HoursAfterSubscription='$HoursAfter', SendFrom='" . addslashes($SendFrom) . "' WHERE AutoresponderID='$AutoresponderID'");
				$Action="ViewResponders";
			
			$OUTPUT .= MakeSuccessBox("Autoresponder Saved Successfully", "The selected autoresponder has been saved successfully.", MakeAdminLink("autoresponders?ListID=$ListID&Action=ViewResponders"));
			$Action = "None";
		}
		else
		{

		$responder=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "autoresponders WHERE AutoresponderID='$AutoresponderID' ORDER BY Subject ASC"));

		$intro = "";
		$req = "<span class=req>*</span> ";
		$Format = $responder["Format"];

		switch($Format)
		{
			case "1": //HTML
			{
				$intro = "Complete the form below to build a HTML-only autoresponder.";
				break;
			}
			case "2": //Text
			{
				$intro = "Complete the form below to build a text-only autoresponder.";
				break;
			}
			case "3": //Both
			{
				$intro = "Complete the form below to build a multi-part autoresponder containing both text and HTML versions.";
				break;
			}
		}

		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		$FORM_ITEMS[$req . "Email Subject"]="textfield|Subject:1000:46:" . $responder["Subject"];
		$HELP_ITEMS["Subject"]["Title"] = "Email Subject";
		$HELP_ITEMS["Subject"]["Content"] = "The subject line that your subscribers will see when this autoresponder arrives in their inbox.";

		$FORM_ITEMS[$req . "From Email"] = "textfield|SendFrom:1000:46:" . $responder["SendFrom"];
		$HELP_ITEMS["SendFrom"]["Title"] = "From Email";
		$HELP_ITEMS["SendFrom"]["Content"] = "The email address that should appear in the \'From\' field when this autoresponder email is sent.";

		$FORM_ITEMS[$req . "Send Time"]="textfield|HoursAfter:4:3:" . $responder["HoursAfterSubscription"];
		$HELP_ITEMS["HoursAfter"]["Title"] = "Send Time";
		$HELP_ITEMS["HoursAfter"]["Content"] = "How many hours after someone subscribes to your mailing list should this autoresponder be sent to them (in hours)?";

		$FORM_ITEMS["-4"]="spacer|&nbsp;";

		if($Format == 1 || $Format == 3)
		{			
			$FORM_ITEMS[$req . "HTML Content"]="wysiwyg|HTMLBODY:64:10:".str_replace(":",'$$COLON$$',stripslashes($responder["HTMLBody"]));
			$HELP_ITEMS["HTMLBODY"]["Title"] = "HTML Content";
			$HELP_ITEMS["HTMLBODY"]["Content"] = "Enter the HTML content for your autoresponder here.";

			$FORM_ITEMS[-4]="spacer|<br>[ <a href=javascript:void(0) onClick=toggleMergePopup(1,1)>Insert HTML Merge Field</a> ]";

			if($Format == 3)
				$FORM_ITEMS[-2]="spacer|<br>[ <a href=javascript:extractHTMLtoText()>Extract Text from HTML »</a> ]";
		}

		if($Format == 2 || $Format == 3)
		{
			if($Format == 3)
				$FORM_ITEMS[-3]="spacer|&nbsp;";

			$FORM_ITEMS[$req . "Text Content"]="textarea|TEXTBODY:116:20:".str_replace(":",'$$COLON$$',stripslashes($responder["TextBody"]));
			$HELP_ITEMS["TEXTBODY"]["Title"] = "Text Content";
			$HELP_ITEMS["TEXTBODY"]["Content"] = "Enter the text for your autoresponder here.";

			$FORM_ITEMS[-7]="spacer|<br>[<a href=javascript:void(0) onClick=toggleMergePopup(2,0)>Insert Text Merge Field</a>]";
		}

		$FORM_ITEMS["-5"]="spacer|&nbsp;";		
		$FORM_ITEMS["-1"]="submit|Save Autoresponder:1-autoresponders";

		$RandomKey=uniqid("a");
		$FORM_ITEMS["-12"]="hidden|RandomKey:$RandomKey";

		$FORM=new AdminForm;
		$FORM->title="EditEmail";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("autoresponders?Action=Edit&ListID=$ListID&AutoresponderID=$AutoresponderID&Save=Yes&Subject=" . urlencode($Subject) . "&SendFrom=" . urlencode($SendFrom) . "&Format=$Format&HoursAfter=" . urlencode((int)$HoursAfter));
		$FORM->MakeForm("Autoresponder Details");

		$FORM->output = $intro . $FORM->output;

		if($SubAction == "")			
			$OUTPUT.=MakeBox("Create Autoresponder (Step 2 of 2)",$FORM->output);
		else
			$OUTPUT.=MakeBox("Update Autoresponder",$FORM->output);

		$OUTPUT .= GenerateMergeFieldInserts();

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

				if(f.Subject.value == "")
				{
					alert("Please enter a subject line for this newsletter.");
					f.Subject.focus();
					return false;
				}

				if(f.SendFrom.value.indexOf("@") == -1 || f.SendFrom.value.indexOf(".") == -1)
				{
					alert("Please enter a valid \'From\' email address for this autoresponder.");
					f.SendFrom.focus();
					f.SendFrom.select();
					return false;
				}

				if(isNaN(f.HoursAfter.value) || f.HoursAfter.value == "")
				{
					alert("Please enter the number of hours after a subscription takes place for when this autoresponder should be sent.");
					f.HoursAfter.focus();
					f.HoursAfter.select();
					return false;
				}
		';	

			// What type of newsletter is being created? HTML, text or both?
		if($Format != 2)
		{
			$OUTPUT .= '

					f.wysiwyg.value = foo.document.body.innerHTML;

					if(f.wysiwyg.value == "" || foo.document.body.innerText == "")
					{
						alert("Please enter HTML content for your newsletter.");
						foo.focus();
						return false;
					}
			';
		}

		if($Format > 1)
		{
			$OUTPUT .= '

					if(f.TEXTBODY.value == "")
					{
						alert("Please enter text content for your newsletter.");
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

	}
}
if($Action=="Preview"){
	$POPOUTPUT=1;
	include "includes$DIRSLASH"."preview.inc.php";
}

if($Action == "Add")
{
	if($CURRENTADMIN["Manager"] == 1)
	{
		$templates=mysql_query("SELECT * FROM " . $TABLEPREFIX . "templates ORDER BY TemplateName ASC");
	}
	else
	{
		$templates=mysql_query("SELECT * FROM " . $TABLEPREFIX . "templates WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY TemplateName ASC");
	}

	while($temp=mysql_fetch_array($templates)){
		$alltemps.=$temp["TemplateID"].'->'.$temp["TemplateName"] . ';';
	}

	$req = "<span class=req>*</span> ";
	$noreq = "&nbsp;&nbsp;&nbsp;";

	$FORM_ITEMS[$req . "Email Subject"]="textfield|Subject:1000:44:";
	$HELP_ITEMS["Subject"]["Title"] = "Email Subject";
	$HELP_ITEMS["Subject"]["Content"] = "The subject line that your subscribers will see when this autoresponder arrives in their inbox.";

	$FORM_ITEMS[$req . "From Email"] = "textfield|SendFrom:1000:44";
	$HELP_ITEMS["SendFrom"]["Title"] = "From Email";
	$HELP_ITEMS["SendFrom"]["Content"] = "The email address that should appear in the \'From\' field when this autoresponder email is sent.";

	$FORM_ITEMS[$req . "Email Format"]="select|Format:1:1->HTML;2->Text;3->HTML and Text";
	$HELP_ITEMS["Format"]["Title"] = "Newsletter Format";
	$HELP_ITEMS["Format"]["Content"] = "How will this autoresponder be composed and sent? Select HTML if you want to include colored text, images, tables, etc. Choose text to create and send your autoresponder in plain-text. Alternatively, you can choose \'Both HTML and Text\' to create 2 versions of your autoresponder. Subscribers who can view HTML will see the HTML version. Those that can\'t will see the plain-text version only.";

	$FORM_ITEMS[$noreq . "Use Template"]="select|TempID:5:$alltemps::onDblClick=\"showTemplatePreview(this.options[this.selectedIndex].value)\"";
	$HELP_ITEMS["TempID"]["Title"] = "Use Template?";
	$HELP_ITEMS["TempID"]["Content"] = "If you have created a template, you can choose to use it from the list below. The content from that template will then be included in your autoresponder content on the next page.<br><br>Double click on a template to preview it.";

	$FORM_ITEMS[$req . "Send Time"]="textfield|HoursAfter:4:3:10";
	$HELP_ITEMS["HoursAfter"]["Title"] = "Send Time";
	$HELP_ITEMS["HoursAfter"]["Content"] = "How many hours after someone subscribes to your mailing list should this autoresponder be sent to them (in hours)?";

	$FORM_ITEMS[-1]="submit|Continue to Step 2:1-autoresponders";

	$FORM=new AdminForm;
	$FORM->title="SelectList";
	$FORM->items=$FORM_ITEMS;
	$FORM->action=MakeAdminLink("autoresponders?Action=NewResponder&ListID=$ListID");
	$FORM->MakeForm("Autoresponder Details");

	$FORM->output = "Complete the form below to create your autoresponder. Double click on a template to preview it before continuing.<br>When you are done, click on the 'Continue to Step 2' button." . $FORM->output;

	$OUTPUT.=MakeBox("Create Autoresponder (Step 1 of 2)", $FORM->output);

	$OUTPUT .= '

		<script language="JavaScript">

			function showTemplatePreview(tId)
			{
				window.open("' . MakeAdminLink("templates?Action=PreviewPopup") . '&TempID="+tId);
			}

			function CheckForm()
			{
				var f = document.forms[0];

				if(f.Subject.value == "")
				{
					alert("Please enter a subject line for this newsletter.");
					f.Subject.focus();
					return false;
				}

				if(f.SendFrom.value.indexOf("@") == -1 || f.SendFrom.value.indexOf(".") == -1)
				{
					alert("Please enter a valid \'From\' email address for this autoresponder.");
					f.SendFrom.focus();
					f.SendFrom.select();
					return false;
				}

				if(isNaN(f.HoursAfter.value) || f.HoursAfter.value == "")
				{
					alert("Please enter the number of hours after a subscription takes place for when this autoresponder should be sent.");
					f.HoursAfter.focus();
					f.HoursAfter.select();
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


if($Action=="NewResponder"){
	//template stuff!
	if($TempID){
		$template=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "templates WHERE TemplateID='$TempID'"));
		$hb=$template["HTMLContent"];
		$tb=$template["TextContent"];
	}
	mysql_query("INSERT INTO " . $TABLEPREFIX . "autoresponders SET HTMLBody='" . addslashes($hb) . "', TextBody='" . addslashes($tb) . "', ListID='$ListID', Subject='" . addslashes($Subject) . "', HoursAfterSubscription='$HoursAfter'");
	$AutoresponderID=mysql_insert_id();
	$Action="EditResponder";
}

if($Action=="DeleteResponder"){
	mysql_query("DELETE FROM " . $TABLEPREFIX . "autoresponders WHERE AutoresponderID='$AutoresponderID'");
	$Action="ViewResponders";
}

if($Action=="EditResponder"){
		
		if($Save){
			mysql_query("UPDATE " . $TABLEPREFIX . "autoresponders SET Format=$Format, HTMLBody='".addslashes($HTMLBODY)."', TextBody='".addslashes($TEXTBODY)."', Subject='" . addslashes($Subject) . "', HoursAfterSubscription='$HoursAfter', SendFrom='" . addslashes($SendFrom) . "' WHERE AutoresponderID='$AutoresponderID'");
				$Action="ViewResponders";
			
			$OUTPUT .= MakeSuccessBox("Autoresponder Saved Successfully", "The selected autoresponder has been saved successfully.", MakeAdminLink("autoresponders?ListID=$ListID&Action=ViewResponders"));
			$Action = "None";
		}
		else
		{
		
		$responder=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "autoresponders WHERE AutoresponderID='$AutoresponderID'"));

		$intro = "";
		$req = "<span class=req>*</span> ";

		switch($Format)
		{
			case "1": //HTML
			{
				$intro = "Complete the form below to build a HTML-only autoresponder.";
				break;
			}
			case "2": //Text
			{
				$intro = "Complete the form below to build a text-only autoresponder.";
				break;
			}
			case "3": //Both
			{
				$intro = "Complete the form below to build a multi-part autoresponder containing both text and HTML versions.";
				break;
			}
		}

		if($Format == 1 || $Format == 3)
		{			
			$FORM_ITEMS[$req . "HTML Content"]="wysiwyg|HTMLBODY:64:10:".str_replace(":",'$$COLON$$',stripslashes($responder["HTMLBody"]));
			$HELP_ITEMS["HTMLBODY"]["Title"] = "HTML Content";
			$HELP_ITEMS["HTMLBODY"]["Content"] = "Enter the HTML content for your autoresponder here.";

			$FORM_ITEMS[-4]="spacer|<br>[ <a href=javascript:void(0) onClick=toggleMergePopup(1,1)>Insert HTML Merge Field</a> ]";

			if($Format == 3)
				$FORM_ITEMS[-2]="spacer|<br>[ <a href=javascript:extractHTMLtoText()>Extract Text from HTML »</a> ]";
		}

		if($Format == 2 || $Format == 3)
		{
			if($Format == 3)
				$FORM_ITEMS[-3]="spacer|&nbsp;";

			$FORM_ITEMS[$req . "Text Content"]="textarea|TEXTBODY:116:20:".str_replace(":",'$$COLON$$',stripslashes($responder["TextBody"]));
			$HELP_ITEMS["TEXTBODY"]["Title"] = "Text Content";
			$HELP_ITEMS["TEXTBODY"]["Content"] = "Enter the text for your autoresponder here.";

			$FORM_ITEMS[-7]="spacer|<br>[<a href=javascript:void(0) onClick=toggleMergePopup(2,0)>Insert Text Merge Field</a>]";
		}

		$FORM_ITEMS["-5"]="spacer|&nbsp;";		
		$FORM_ITEMS["-1"]="submit|Save Autoresponder:1-autoresponders";

		$RandomKey=uniqid("a");
		$FORM_ITEMS["-12"]="hidden|RandomKey:$RandomKey";

		$FORM=new AdminForm;
		$FORM->title="EditEmail";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("autoresponders?Action=EditResponder&ListID=$ListID&AutoresponderID=$AutoresponderID&Save=Yes&Subject=" . urlencode($Subject) . "&SendFrom=" . urlencode($SendFrom) . "&Format=$Format&HoursAfter=" . urlencode((int)$HoursAfter));
		$FORM->MakeForm("Autoresponder Details");

		$FORM->output = $intro . $FORM->output;
			
		$OUTPUT.=MakeBox("Create Autoresponder (Step 2 of 2)",$FORM->output);
		$OUTPUT .= GenerateMergeFieldInserts();

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
		if($Format != 2)
		{
			$OUTPUT .= '

					f.wysiwyg.value = foo.document.body.innerHTML;

					if(f.wysiwyg.value == "" || foo.document.body.innerText == "")
					{
						alert("Please enter HTML content for your newsletter.");
						foo.focus();
						return false;
					}
			';
		}

		if($Format > 1)
		{
			$OUTPUT .= '

					if(f.TEXTBODY.value == "")
					{
						alert("Please enter text content for your newsletter.");
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

	}
}

if($Action == "ViewResponders")
{
	$responders=mysql_query("SELECT * FROM " . $TABLEPREFIX . "autoresponders WHERE ListID='$ListID' ORDER BY Subject ASC");

	if(mysql_num_rows($responders) > 0)
	{	
		$AO.='
				<script language="JavaScript">

					function selectOn(trObject)
					{
						for(i = 0; i <= 3; i++)
						{
							trObject.childNodes[i].className = "body bevel4 rowSelectOn";
						}
					}

					function selectOut(trObject, whichStyle)
					{
						for(i = 0; i <= 3; i++)
							trObject.childNodes[i].className = "body bevel4";
					}
				
				</script>

				<table width=100% border=0 cellspacing=2 cellpadding=2>
				  <tr>
					<td width=4% class="headbold bevel5">&nbsp;</td>
					<td class="headbold bevel5" width=36%>
						Autoresponder Subject
					</td>
					<td class="headbold bevel5" width=40%>
						Sent (Hours After Subscribing)
					</td>
					<td class="headbold bevel5" width=20%>
						Action
					</td>
				</tr>
		';

		while($r=mysql_fetch_array($responders))
		{
			$AO .= '

				<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
					<td height=20 class="body bevel4" width=4% class="body">
						<img src="' . $ROOTURL . 'admin/images/autoresponder.gif" width="16" height="15">
					</td>
					<td class="body bevel4" width=30%>' . $r["Subject"] . '</td>
					<td class="body bevel4" width=40%>' . $r["HoursAfterSubscription"] . '</td>
					<td class="body bevel4" width=20%>';

					$AO .= MakeLink("autoresponders?Action=Edit&SubAction=Edit&ListID=$ListID&AutoresponderID=".$r["AutoresponderID"],"Edit") . "&nbsp;&nbsp;&nbsp;";
					$AO .= MakeLink("autoresponders?Action=DeleteResponder&ListID=$ListID&AutoresponderID=".$r["AutoresponderID"],"Delete",1);

			$AO .= '		
					</td>
				</tr>
			';
		}

		$AO .= '</table>';

		$AO = 'Use the form below to review, edit and delete autoresponders.<br>To create a new autoresponder, click on the "Create Autoresponder" button below.<br><br><input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("autoresponders?Action=Add&ListID=$ListID") . '\'" value="Create Autoresponder"><br><br>' . $AO;
	}
	else
	{
		$AO = 'The are currently no saved autoresponders. Click "Create Autoresponder" to create one.<br><br><input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("autoresponders?Action=Add&ListID=$ListID") . '\'" value="Create Autoresponder"><br><br>' . $AO;
	}

	$OUTPUT.=MakeBox("Manage Autoresponders",$AO);
}

if(!$ListID)
{
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
	$FORM_ITEMS["-1"]="submit|Continue";

	$FORM=new AdminForm;
	$FORM->title="SelectList";
	$FORM->items=$FORM_ITEMS;
	$FORM->action=MakeAdminLink("autoresponders?Action=ViewResponders");
	$FORM->MakeForm("Mailing List Details");

	$FORM->output = "Before you can create or view existing autoresponders, please choose a mailing list to work with." . $FORM->output;
		
	$OUTPUT.=MakeBox("Manage Autoresponders",$FORM->output);
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