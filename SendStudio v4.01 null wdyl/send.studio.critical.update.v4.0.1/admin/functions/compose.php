<?

	$ComposedID = @$_REQUEST["ComposedID"];
	$Save = @$_REQUEST["Save"];
	$TempID = @$_REQUEST["TempID"];
	$TemplateID = @$_REQUEST["TemplateID"];
	$Name = @$_REQUEST["Name"];
	$HTMLBODY = @$_REQUEST["wysiwyg"];
	$TEXTBODY = @$_REQUEST["TEXTBODY"];
	$Subject = @$_REQUEST["Subject"];
	$SubmitButton = @$_REQUEST["SubmitButton"];
	$Action = @$_REQUEST["Action"];
	$Format = @$_REQUEST["Format"];
	$OrigAction = $Action;
	$OffSet = @$_REQUEST["OffSet"];
	$SubAction = @$_REQUEST["SubAction"];
	$HTMLFile = @$_REQUEST["HTMLFile"];
	$NewsletterName = @$_REQUEST["NewsletterName"];
	$PreviewEmail = @$_REQUEST["PreviewEmail"];

	$OUTPUT = "";
	$alltemps = "";

	function ReplaceLinksAndImages($Content, $Format)
	{
		global $CURRENTADMIN;
		global $ROOTURL;
		global $TABLEPREFIX;

		//images
		if($CURRENTADMIN["Manager"] == 1)
		{
			$images=mysql_query("SELECT * FROM " . $TABLEPREFIX . "images");
		}
		else
		{
			$images=mysql_query("SELECT * FROM " . $TABLEPREFIX . "images WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "'");
		}

		while($i = mysql_fetch_array($images))
		{
			if($Format == "html")
			{
				$tv = '<img src="' . $ROOTURL . '/temp/images/' . $i["ImageID"] . "." . $i["ImageType"] . '">';
			}
			else
			{
				$tv = $ROOTURL . '/temp/images/' . $i["ImageID"] . "." . $i["ImageType"];
			}

			$tv = str_replace("http:/", "http://", str_replace("//", "/", $tv));
			$Content = str_replace("%IMAGE:" . $i["ImageID"] . "%", $tv, $Content);
		}

		//links!
		if($CURRENTADMIN["Manager"] == 1)
		{
			$links = mysql_query("SELECT * FROM " . $TABLEPREFIX . "links");
		}
		else
		{
			$links = mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "'");
		}
	
		while($l = mysql_fetch_array($links))
		{
			if($Format == "html")
			{
				$tv = '<a href="' . $ROOTURL . 'users/link.php?LinkID='.$l["LinkID"].'&UserID=">' . $l["LinkName"] . '</a>';
			}
			else
			{
				$tv = $ROOTURL . 'users/link.php?LinkID=' . $l["LinkID"] . '&UserID=';
			}
			
			$Content = str_replace("%LINK:" . $l["LinkID"] . "%", $tv, $Content);
		}

		return $Content;
	}

	function CreatePreviewEmail()
	{
		GLOBAL $TEXTBODY;
		GLOBAL $HTMLBODY;
		GLOBAL $Format;
		GLOBAL $PreviewEmail;
		GLOBAL $Subject;
		
		$TEXTBODY = stripslashes($TEXTBODY);
		$HTMLBODY = stripslashes($HTMLBODY);

		if($Format==1)
		{
			//html version
			$EmailBody = $HTMLBODY;
			$Headers="From: " . $PreviewEmail . "\nX-Mailer: SendStudio\nContent-Type: text/html\nReply-To: " . $PreviewEmail . "\nReturn-Path: " . $PreviewEmail;
			$SendTo = $PreviewEmail;
		}
		else if($Format==2)
		{
			//textbased
			$EmailBody = $TEXTBODY;
			$Headers="From: " . $PreviewEmail . "\nX-Mailer: SendStudio\nContent-Type: text/plain\nReply-To: " . $PreviewEmail . "\nReturn-Path: " . $PreviewEmail;
			$SendTo = $PreviewEmail;
		}
		else
		{
			//Format==3 
			//multipart version
			$SendTo = $PreviewEmail;

			$EmailBodyH = $HTMLBODY;
			
			$EmailBodyT = $TEXTBODY;

			$EmailBody  = '--=======kuomAenidraNShmlimisdsddsdssdfkwaqlewlibik=======' . "\n";
			$EmailBody .= 'Content-Type: text/plain; charset="iso-8859-1"' . "\n";
			$EmailBody .= 'Content-Transfer-Encoding: 7bit' . "\n" . "\n";

			$EmailBody .= $EmailBodyT . "\n" . "\n";
			$EmailBody .= '--=======kuomAenidraNShmlimisdsddsdssdfkwaqlewlibik=======' . "\n";
			$EmailBody .= 'Content-Type: text/html; charset="iso-8859-1"' . "\n";
			$EmailBody .= 'Content-Transfer-Encoding: 7bit' . "\n" . "\n";

			$EmailBody .= $EmailBodyH . "\n" . "\n";
			$EmailBody .= '--=======kuomAenidraNShmlimisdsddsdssdfkwaqlewlibik=======' . "\n" . "\n";
			
			$Headers  = "From: " . $PreviewEmail . "\n";
			$Headers .= "Reply-To: " . $PreviewEmail . "\n";
			$Headers .= "Return-Path: " . $PreviewEmail . "\n";
			$Headers .= "X-Mailer: SendStudio\n";
			$Headers .= "Mime-Version: 1.0\n";
			$Headers .= 'Content-Type: multipart/alternative; boundary="=======kuomAenidraNShmlimisdsddsdssdfkwaqlewlibik======="';
			$Headers .= "\nContent-Transfer-Encoding: 7bit";
		}

		$Email["Subject"]=$Subject;
		$Email["Body"]=$EmailBody;
		$Email["Email"]=$SendTo;
		$Email["Headers"]=$Headers;

		return $Email;
	}

	if($Action == "SendPreview")
	{
		// Do we need to load an external HTML file?
		$IsError = false;

		if($TextFile != "" && $TextFile != "http://")
		{
			if(substr($TextFile, 0,7) == "http://")
			{
				// Try and grab the external file
				$TEXTBODY = "";
				$fp = @fopen($TextFile, "rb");

				if($fp)
				{
					while(!feof($fp))
					{
						$TEXTBODY .= @fgets($fp, 1024);
					}
					
					$TEXTBODY = @addslashes($TEXTBODY);
					@fclose($fp);
				}
				else
				{
					$OUTPUT .= MakeErrorBox("Invalid Content File", "<br>The file '$TextFile' couldn't be loaded. The URL you specified may be invalid.");
					$IsError = true;
				}
			}
			else
			{
				// Invalid file
				$OUTPUT .= MakeErrorBox("Invalid Content File", "<br>The URL you specified must start with 'http://'.");
				$IsError = true;
			}
		}

		// Do we need to load an external HTML file?
		if($HTMLFile != "" && $HTMLFile != "http://")
		{
			if(substr($HTMLFile, 0,7) == "http://")
			{
				// Try and grab the external file
				$HTMLBODY = "";
				$fp = @fopen($HTMLFile, "rb");

				if($fp)
				{
					while(!feof($fp))
					{
						$HTMLBODY .= @fgets($fp, 1024);
					}
					
					$HTMLBODY = @addslashes($HTMLBODY);
					@fclose($fp);
				}
				else
				{
					$OUTPUT .= MakeErrorBox("Invalid Content File", "<br>The file '$HTMLFile' couldn't be loaded. The URL you specified may be invalid.");
					$IsError = true;
				}
			}
			else
			{
				// Invalid file
				$OUTPUT .= MakeErrorBox("Invalid Content File", "<br>The URL you specified must start with 'http://'.");
				$IsError = true;
			}
		}

		if($IsError == false)
		{
			switch($Format)
			{
				case 1:
					$f = "html";
					break;
				case 2:
					$f = "text";
					break;
				case 3:
					$f = "html";
					break;
			}

			$theEmail = CreatePreviewEmail();
			$theEmail = ReplaceLinksAndImages($theEmail, $f);

			if(@mail($theEmail["Email"], $theEmail["Subject"], $theEmail["Body"], $theEmail["Headers"]))
			{
				// The email was sent successfully
				$OUTPUT .= MakeSuccessBox("Preview Email Sent Successfully", "<br>A preview of your newsletter has been sent to '$PreviewEmail'. To save your newsletter, close this window and click on the 'Save Newsletter' button.<br>&nbsp;", "javascript:window.close()");
			}
			else
			{
				// The email couldn't be sent
				$OUTPUT .= MakeErrorBox("An Error Occured", "<br>An error occured while trying to send your preview email.");
			}
		}
	}

	if($Action == "Copy")
	{
		// Copy the newsletter to a new record
		$cResult = @mysql_query("select * from " . $TABLEPREFIX . "composed_emails where ComposedID = '$ComposedID'");

		if($cRow = @mysql_fetch_array($cResult))
		{
			$iQuery = "insert into " . $TABLEPREFIX . "composed_emails values(0,'" . $cRow["Format"] . "','" . addslashes($NewsletterName) . "','" . time() . "','" . addslashes($cRow["Subject"]) . "','" . addslashes($cRow["TextBody"] ). "','" . addslashes($cRow["HTMLBody"]) . "','" . $cRow["AdminID"] . "')";

			if(@mysql_query($iQuery))
			{
				$OUTPUT .= MakeSuccessBox("Newsletter Copied Successfully", "The selected newsletter has been copied successfully.", MakeAdminLink("compose?Action="));
			}
			else
			{
				// Couldn't run the query
				$OUTPUT .= MakeErrorBox("An Error Occured", "<br>The selected newsletter couldn't be copied.");
			}
		}
		else
		{
			$OUTPUT .= MakeErrorBox("An Error Occured", "<br>The selected newsletter no longer exists.");
		}
	}

	if($Action == "CopyForm")
	{
		// Show the form to copy one newsletter to another
		$EmailName = @mysql_result(@mysql_query("select EmailName from " . $TABLEPREFIX . "composed_emails where ComposedID = $ComposedID"), 0, 0);
		$req = "<span class=req>*</span> ";

		$FORM_ITEMS[$req . "Newsletter Name"]="textfield|NewsletterName:100:44:Copy of " . $EmailName;
		$HELP_ITEMS["NewsletterName"]["Title"] = "Newsletter Name";
		$HELP_ITEMS["NewsletterName"]["Content"] = "Enter a name for the new newsletter here.";

		$FORM_ITEMS[-1]="submit|Copy Newsletter:1-compose";
		$RandomKey=uniqid("p");
		$FORM_ITEMS[-12]="hidden|RandomKey:$RandomKey";

		$FORM=new AdminForm;
		$FORM->title="CopyEmail";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("compose?Action=Copy&ComposedID=$ComposedID");
		$FORM->MakeForm("Copy Newsletter");

		$FORM->output = "Complete the form below to copy the selected newsletter.<br>" . $FORM->output;
		$OUTPUT.=MakeBox("Copy Newsletter (Step 1 of 1)",$FORM->output);

		$OUTPUT .= '

			<script language="JavaScript">

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.NewsletterName.value == "")
					{
						alert("Please enter a name for this newsletter.");
						f.NewsletterName.focus();
						return false;
					}

					return true;
				}
			
			</script>
		';
	}

	if($Action=="ViewTags"){
		$POPOUTPUT=1;
		include "includes$DIRSLASH"."emailtags.inc.php";
	}

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
					top.frames[1].document.location.href = '<?php echo MakeAdminLink("compose?Action=Preview&ComposedID=$ComposedID&Format=html"); ?>';
					
				}
				else
				{
					top.frames[1].document.location.href = '<?php echo MakeAdminLink("compose?Action=Preview&ComposedID=$ComposedID&Format=text"); ?>';
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
		$cResult = mysql_query("select * from " . $TABLEPREFIX . "composed_emails where ComposedID = $ComposedID");

		if($cRow = mysql_fetch_array($cResult))
		{
			ob_end_clean();
			ob_start();

			if($cRow["Format"] == 3)
				$theFormat = "html";
			else if($cRow["Format"] == 2)
				$theFormat = "text";
			else
				$theFormat = "html";
			?>
				<frameset rows="35,*">
					<frame src="<?php echo MakeAdminLink("compose?Action=PreviewTopFrame&ComposedID=$ComposedID&Format=" . $cRow["Format"]); ?>">
					<frame src="<?php echo MakeAdminLink("compose?Action=Preview&ComposedID=$ComposedID&Format=" . $theFormat); ?>">
				</frameset>
			<?php
			
			ob_end_flush();
			die();
		}
		else
		{
			// The newsletter doesn't exist
			$OUTPUT .= MakeErrorBox("An Error Occured", "<br>The selected newsletter no longer exists.");
		}
	}

	if($Action=="Preview")
	{
		$cResult = mysql_query("select * from " . $TABLEPREFIX . "composed_emails where ComposedID = $ComposedID");

		if($cRow = mysql_fetch_array($cResult))
		{
			ob_end_clean();
			ob_start();

			if($Format == "text")
			{
				$theContent = str_replace("\n", "<br>", $cRow["TextBody"]);
			}
			else
			{
				$theContent = $cRow["HTMLBody"];
			}

			echo ReplaceLinksAndImages($theContent, $Format);
			
			ob_end_flush();
			die();
		}
		else
		{
			// The newsletter doesn't exist
			$OUTPUT .= MakeErrorBox("An Error Occured", "<br>The selected newsletter no longer exists.");
		}
	}

	if($Action=="AddEmail")
	{
		//template stuff!
		if($TemplateID){
			$template=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "templates WHERE TemplateID='$TempID' ORDER BY TemplateName ASC"));
			$hb=$template["HTMLContent"];
			$tb=$template["TextContent"];
		}
		mysql_query("INSERT INTO " . $TABLEPREFIX . "composed_emails SET HTMLBody='" . addslashes($HTMLBODY) . "', TextBody='" . addslashes($TEXTBODY) . "', EmailName='" . addslashes($Name) . "', Format='$Format', DateCreated='$SYSTEMTIME', AdminID='" . $CURRENTADMIN["AdminID"] . "'");

		$ComposedID=mysql_insert_id();
		$Action="EditEmail";
	}

	if($Action=="DeleteEmail"){
		mysql_query("DELETE FROM " . $TABLEPREFIX . "composed_emails WHERE ComposedID='$ComposedID'");
		$Action="";
	}

	if($Action=="EditEmail"){

		if($Save)
		{		
			$DoSave = true;

			// Do we need to load an external HTML file?
			if($TextFile != "" && $TextFile != "http://")
			{
				if(substr($TextFile, 0,7) == "http://")
				{
					// Try and grab the external file
					$TEXTBODY = "";
					$fp = @fopen($TextFile, "rb");

					if($fp)
					{
						while(!feof($fp))
						{
							$TEXTBODY .= @fgets($fp, 1024);
						}
						
						$TEXTBODY = @addslashes($TEXTBODY);
						@fclose($fp);
					}
					else
					{
						$OUTPUT .= MakeErrorBox("Invalid Content File", "<br>The file '$TextFile' couldn't be loaded. The URL you specified may be invalid.");
						$DoSave = false;
					}
				}
				else
				{
					// Invalid file
					$OUTPUT .= MakeErrorBox("Invalid Content File", "<br>The URL you specified must start with 'http://'.");
					$DoSave = false;
				}
			}

			// Do we need to load an external HTML file?
			if($HTMLFile != "" && $HTMLFile != "http://")
			{
				if(substr($HTMLFile, 0,7) == "http://")
				{
					// Try and grab the external file
					$HTMLBODY = "";
					$fp = @fopen($HTMLFile, "rb");

					if($fp)
					{
						while(!feof($fp))
						{
							$HTMLBODY .= @fgets($fp, 1024);
						}
						
						$HTMLBODY = @addslashes($HTMLBODY);
						@fclose($fp);
					}
					else
					{
						$OUTPUT .= MakeErrorBox("Invalid Content File", "<br>The file '$HTMLFile' couldn't be loaded. The URL you specified may be invalid.");
						$DoSave = false;
					}
				}
				else
				{
					// Invalid file
					$OUTPUT .= MakeErrorBox("Invalid Content File", "<br>The URL you specified must start with 'http://'.");
					$DoSave = false;
				}
			}

			if($DoSave == true)
			{
				mysql_query("UPDATE " . $TABLEPREFIX . "composed_emails SET TextBody='" . addslashes($TEXTBODY) . "', HTMLBody='" . addslashes($HTMLBODY) . "', Format='$Format', Subject='" . addslashes($Subject) . "' WHERE ComposedID='$ComposedID'");
				$Action="";

				$cRow = @mysql_fetch_array(@mysql_query("select * from " . $TABLEPREFIX . "composed_emails where ComposedID='$ComposedID'"));

				$OUTPUT .= MakeSuccessBox("Newsletter Saved Successfully", "The selected newsletter has been saved successfully.", MakeAdminLink("compose?Action="), MakeAdminLink("send?ComposedID=$ComposedID"), "Send Newsletter", false, MakeAdminLink("compose?Action=PreviewPopup&ComposedID=$ComposedID"), "View Newsletter", "_blank", "", "", "");
			}

		}else{

			if($Format == "")
			{
				$r1 = mysql_query("select TextBody, HTMLBody from " . $TABLEPREFIX . "composed_emails where ComposedID='$ComposedID'");

				if($row1 = @mysql_fetch_array($r1))
				{
					$h = $row1["HTMLBody"];
					$t = $row1["TextBody"];

					if($h != "" && $t != "")
						$Format = 3; //Mixed
					else if($h != "")
						$Format = 1; //HTML
					else
						$Format = 2; // Text
				}
			}

			$intro = "";

			switch($Format)
			{
				case "1": //HTML
				{
					$intro = "Complete the form below to build a HTML-only newsletter.";
					break;
				}
				case "2": //Text
				{
					$intro = "Complete the form below to build a text-only newsletter.";
					break;
				}
				case "3": //Both
				{
					$intro = "Complete the form below to build a multi-part newsletter containing both text and HTML versions.";
					break;
				}
			}

			$Composed=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "composed_emails WHERE ComposedID='$ComposedID'"));

			// Are we using a template?
			if($TempID != "")
			{
				$tempResult = mysql_query("SELECT * FROM " . $TABLEPREFIX . "templates WHERE TemplateID='$TempID'");

				if($tempRow = mysql_fetch_array($tempResult))
				{
					$Composed["HTMLBody"] = $tempRow["HTMLContent"];
					$Composed["TextBody"] = $tempRow["TextContent"];
				}
			}

			$req = "<span class=req>*</span> ";
			$noreq = "&nbsp;&nbsp;&nbsp;";

			$FORM_ITEMS[$req . "Newsletter Subject"]="textfield|Subject:1000:100:".$Composed["Subject"];
			$HELP_ITEMS["Subject"]["Title"] = "Newsletter Subject";
			$HELP_ITEMS["Subject"]["Content"] = "The text you enter here will be displayed as the subject line in your newsletter email.<br><br>Keep clear of words such as \'Free\', \'\$\$\$\', \'RE:\', etc as these words could trigger spam filters on your subscribers mail server, meaning that they wouldn\'t receive this newsletter.";

			$FORM_ITEMS[-2]="spacer|&nbsp;";
			$FORM_ITEMS[-2]="hidden|Format:$Format";

			if($Format != 2)
			{		
				$FORM_ITEMS[$req . "HTML Content"]="wysiwyg|HTMLBODY:64:10:".str_replace("|", "&#124;", str_replace(":",'$$COLON$$',stripslashes($Composed["HTMLBody"])));
				$FORM_ITEMS[-4]="spacer|<br>[ <a href=javascript:void(0) onClick=toggleMergePopup(1,1)>Insert HTML Merge Field</a> ]";

				$FORM_ITEMS[-3]="spacer|<br>";
				$FORM_ITEMS[$req . "<b><i>OR</i></b> HTML Content File"]="textfield|HTMLFile:1000:100:http&#58;//";
				$HELP_ITEMS["HTMLFile"]["Title"] = "HTML Content File";
				$HELP_ITEMS["HTMLFile"]["Content"] = "If you have already uploaded your newsletter as a HTML file, enter the URL of the file and it will be downloaded and saved as the content of your newsletter.";

				$FORM_ITEMS[-4]="spacer|<br>[ <a href=javascript:void(0) onClick=toggleMergePopup(1,1)>Insert HTML Merge Field</a> ] [ <a href=javascript:void(0) onClick=addUnsubscribeLink(1)>Insert Unsubscribe Link</a> ]";

				if($Format == 3)
				{
					$FORM_ITEMS[-9]="spacer|<br>[ <a href=javascript:extractHTMLtoText()>Extract Text from HTML »</a> ]<br>&nbsp;";
				}

				$FORM_ITEMS[-3]="spacer|&nbsp;";
			}

			if($Format > 1)
			{
				$FORM_ITEMS[$req . "Text Content"]="textarea|TEXTBODY:102:20:".str_replace(":",'$$COLON$$',stripslashes($Composed["TextBody"]));

				$FORM_ITEMS[-8]="spacer|<br>";
				$FORM_ITEMS[$req . "<b><i>OR</i></b> Text Content File"]="textfield|TextFile:1000:100:http&#58;//";
				$HELP_ITEMS["TextFile"]["Title"] = "Text Content File";
				$HELP_ITEMS["TextFile"]["Content"] = "If you have already uploaded your newsletter as a text file, enter the URL of the file and it will be downloaded and saved as the content of your newsletter.";
				
				$FORM_ITEMS[-8]="spacer|<br>[<a href=javascript:void(0) onClick=toggleMergePopup(2,0)>Insert Text Merge Field</a>] [ <a href=javascript:void(0) onClick=addUnsubscribeLink(2)>Insert Unsubscribe Link</a> ]<br>&nbsp;";
				$FORM_ITEMS[-5]="spacer|&nbsp;";
			}

			$FORM_ITEMS["Preview Email"]="textfield|PreviewEmail:100:44::0:<input class='pbutton' type='button' value='Send Preview' onClick='PreparePreview()'>";
			$HELP_ITEMS["PreviewEmail"]["Title"] = "Preview Email";
			$HELP_ITEMS["PreviewEmail"]["Content"] = "If you\'d like to preview this newsletter before it\'s sent out, then enter your email address here, and click on the \'Preview Newsletter\' button below.";

			$FORM_ITEMS[-6]="spacer|&nbsp;";
			$FORM_ITEMS[-1]="submit|Save Newsletter:1-compose";
			$RandomKey=uniqid("p");
			$FORM_ITEMS[-12]="hidden|RandomKey:$RandomKey";

			$FORM=new AdminForm;
			$FORM->title="EditEmail";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("compose?Action=EditEmail&Format=$Format&ComposedID=$ComposedID&Save=Yes");
			$FORM->MakeForm("Newsletter Content");

			$FORM->output = $intro . $FORM->output;

			if($SubAction == "")
				$OUTPUT.=MakeBox("Create Newsletter (Step 2 of 2)",$FORM->output);
			else
				$OUTPUT.=MakeBox("Update Newsletter",$FORM->output);

			$OUTPUT .= GenerateMergeFieldInserts();

			$OUTPUT .= '

				<script language="JavaScript">

					function addUnsubscribeLink(whichBox)
					{
						if(whichBox == 1) //HTML
						{
							foo.focus();
							var sel = foo.document.selection;
							var r = sel.createRange();
							r.pasteHTML("%BASIC:UNSUBLINK%");
						}
						else //Text
						{
							var t = document.getElementById("TEXTBODY");
							t.value += "%BASIC:UNSUBLINK%";
							t.focus();
						}
					}

					function PreparePreview()
					{
						if(CheckForm())
						{
							document.forms[0].target = "_blank";
							prevAction = document.forms[0].action;
							document.forms[0].action = "' . MakeAdminLink("compose?Action=SendPreview") . '";
							document.forms[0].submit();
							document.forms[0].target = "";
							document.forms[0].action = prevAction;
						}
					}

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
							alert("Please enter the subject line for your newsletter.");
							f.Subject.focus();
							return false;
						}
			';
			
			// What type of newsletter is being created? HTML, text or both?
			if($Format != 2)
			{
				$OUTPUT .= '

						f.wysiwyg.value = foo.document.documentElement.outerHTML;

						if((f.wysiwyg.value == "" || foo.document.body.innerText == "") && (f.HTMLFile.value == "" || f.HTMLFile.value == "http://"))
						{
							alert("Please enter HTML content for your newsletter or specify the path of a file to load.");
							foo.focus();
							return false;
						}
				';
			}

			if($Format > 1)
			{
				$OUTPUT .= '

						if(f.TEXTBODY.value == "" && (f.TextFile.value == "" || f.TextFile.value == "http://"))
						{
							alert("Please enter text content for your newsletter or specify the path of a file to load.");
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

	if($OrigAction != "EditEmail")
	{
		$Total = 0;
		$PerPage = 20;
		$Pages = 0;
		$TO = "";
		$ListName = "All Lists";

		if($Action=="")
		{
			if($CURRENTADMIN["Manager"] == 1)
			{
				$Total = mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "composed_emails ORDER BY EmailName ASC"));
				$templates = mysql_query("SELECT * FROM " . $TABLEPREFIX . "composed_emails ORDER BY EmailName LIMIT ".($OffSet*$PerPage).",$PerPage");
			}
			else
			{
				$Total = mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "composed_emails WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY EmailName ASC"));
				$templates = mysql_query("SELECT * FROM " . $TABLEPREFIX . "composed_emails WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY EmailName LIMIT ".($OffSet*$PerPage).",$PerPage");
			}

			if($Total > 0){

				if($Total <= $PerPage){
					$Pages = 1;
				}else{
					$Pages = ceil($Total/$PerPage);
				}

				if($Total > 0)
				{

					$TO = '

						<script language="JavaScript">

							function selectOn(trObject)
							{
								for(i = 0; i <= 6; i++)
								{
									trObject.childNodes[i].className = "body bevel4 rowSelectOn";
								}
							}

							function selectOut(trObject, whichStyle)
							{
								for(i = 0; i <= 6; i++)
									trObject.childNodes[i].className = "body bevel4";
							}
						
						</script>

						Use the form below to review, edit and send your newsletters.<br>To create a new newsletter, click on the "Create Newsletter" button below.
						<br><br>
						<input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("compose?Action=Add") . '"\' value="Create Newsletter">
						<br><br>
						<table width=100% border=0 cellspacing=2 cellpadding=2>
					';

					if($Pages > 1)
					{
						$TO .= '

						<tr>
							<td width=100% colspan=7 class="navtext">
								<a href="' . MakeAdminLink("compose?Action=&OffSet=".($Page-1)) . '" class="navlink">««</a> |';
					}

					if($Page > 0)
					{
						$TO.='
		
						<a href="' . MakeAdminLink("compose?Action=&Page=" . ($Page-1) . "&OffSet=".($Page-1)) . '" class="navlink">Prev</a> |';
					}

					if($Pages > 1)
					{
						for($i = 0; $i < $Pages; $i++)
						{
							if($Page != $i)
								$TO .= ' <a href="' . MakeAdminLink("compose?Action=&Page=$i&OffSet=".($i)) . '" class="navlink">' . ($i+1) . '</a> |';
							else
								$TO .= ' ' . ($i+1) . ' |';
						}
					}
						
					if($Page < $Pages-1){
						$TO.='
						
									<a href="' . MakeAdminLink("compose?Action=&Page=" . ($Page+1) . "&OffSet=".($Page+1)) . '" class="navlink">Next</a> |';
					}

					if($Pages > 1)
					{
						$TO .= '
								 <a href="' . MakeAdminLink("compose?Action=&Page=" . ($Pages-1) . "&OffSet=".($Pages-1)) . '" class="navlink">»»</a>
							</td>
						</tr>
						';
					}
				
				$TO .= '
					  <tr>
						<td width=4% class="headbold bevel5">&nbsp;</td>
						<td class="headbold bevel5" width=30%>
							Newsletter Name
						</td>
						<td class="headbold bevel5" width=10%>
							Sent
						</td>
						<td class="headbold bevel5" width=15%>
							Date Created
						</td>
						<td class="headbold bevel5" width=10%>
							Format
						</td>
						<td class="headbold bevel5" width=11%>
							Status
						</td>
						<td class="headbold bevel5" width=20%>
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
								<img src="' . $ROOTURL . 'admin/images/newsletter.gif" width="14" height="11">
							</td>
							<td class="body bevel4" width=30%>' . $temp["EmailName"] . '</td>
							<td class="body bevel4" width=10%>';
						
					$TO .= (int)@mysql_result(@mysql_query("select EmailsSent from " . $TABLEPREFIX . "sends WHERE ComposedID = " . $temp["ComposedID"]), 0, 0) . " of " . (int)@mysql_result(@mysql_query("select TotalRecipients from " . $TABLEPREFIX . "sends WHERE ComposedID = " . $temp["ComposedID"]), 0, 0);
					
					$TO .= '</td>
							<td class="body bevel4" width=15%>' . DisplayDate($temp["DateCreated"]) . '</td>
							<td class="body bevel4" width=10%>' . $Format . '</td>
							<td class="body bevel4" width=11%>';

							/*
								Has this email already been sent?
								The sends tables stores the details of newsletters that have been sent.
								The composeID field links from the composed_emails table.
								If an entry exists in the sends table with the same composeID as this newsletter,
								then it has been partially/full sent. To determine which, we add up the HTMLRecipients
								and TextRecipients fields and minus them from the EmailsSent field. If the result
								is positive, then there are still some that need to be sent. If not, it's been sent.		
							*/

							$statusResult = @mysql_query("select * from " . $TABLEPREFIX . "sends where ComposedID = " . $temp["ComposedID"]);

							if($statusRow = @mysql_fetch_array($statusResult))
							{
								// Has it been sent?
								if($statusRow["Completed"] == 0)
								{
									$TO .= "Partially Sent";
								}
								else
								{
									$TO .= "Sent";
								}
							}
							else
							{
								$TO .= "Not Sent";
							}

							$TO .= '</td>
							<td class="body bevel4" width=20%>';

							$TO .= MakeLink("compose?Action=PreviewPopup&ComposedID=".$temp["ComposedID"],"View",0,0, "_blank")  . "&nbsp;&nbsp;&nbsp;";

							if(@is_array($statusRow))
							{
								if($statusRow["Completed"] == 0)
								{
									$SendID = (int)@mysql_result(@mysql_query("select SendID from " . $TABLEPREFIX . "sends where ComposedID = " . $temp["ComposedID"]), 0, 0);

									$TO .= MakeLink("send?Action=FinalOptions&AlreadySet=1&Resending=1&SendID=".$SendID,"Resume") . "&nbsp;&nbsp;&nbsp;";
								}
								else
								{
									$TO .= MakeLink("send?ComposedID=" . $temp["ComposedID"],"Send") . "&nbsp;&nbsp;&nbsp;";
								}
							}
							else
							{
								$TO .= MakeLink("send?ComposedID=" . $temp["ComposedID"],"Send") . "&nbsp;&nbsp;&nbsp;";
							}

							$TO .= MakeLink("compose?Action=EditEmail&SubAction=Edit&ComposedID=".$temp["ComposedID"],"Edit") . "&nbsp;&nbsp;&nbsp;";

							$TO .= MakeLink("compose?Action=CopyForm&ComposedID=".$temp["ComposedID"],"Copy") . "&nbsp;&nbsp;&nbsp;";

							$TO .= MakeLink("compose?Action=DeleteEmail&ComposedID=".$temp["ComposedID"],"Delete",1) . "&nbsp;&nbsp;&nbsp;";

							$TO .= '		
							</td>
						</tr>
					';

				}

				$TO .= '</table>';

				}
				else
				{
					if(AllowSection(11))
					{
						$TO .= 'No newsletters have been created. Click the "Create Newsletter" button to create one.
						<br><br><input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("compose?Action=Add") . '"\' value="Create Newsletter">
						<br><br>';
					}
					else
					{
						$TO .= 'No newsletters have been created.<br><br>';
					}
				}
				
				$OUTPUT.=MakeBox("Newsletter Manager",$TO);
			}
			else
			{
				if(AllowSection(11))
				{
					$TO .= 'No newsletters have been created. Click the "Create Newsletter" button to create one.
					<br><br><input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("compose?Action=Add") . '"\' value="Create Newsletter">
					<br><br>';
				}
				else
				{
					$TO .= 'No newsletters have been created.<br><br>';
				}

				$OUTPUT.=MakeBox("Newsletter Manager",$TO);
			}
		}
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

		while($temp=mysql_fetch_array($templates))
		{
			$alltemps.=$temp["TemplateID"].'->'.$temp["TemplateName"].';';
		}

		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		$FORM_ITEMS[$req . "Newsletter Name"]="textfield|Name:100:44:";
		$HELP_ITEMS["Name"]["Title"] = "Newsletter Name";
		$HELP_ITEMS["Name"]["Content"] = "What do you want to call this newsletter? This name will only be used to show you a \'friendly name\' for this newsletter in the control panel.";

		$FORM_ITEMS[$req . "Newsletter Format"]="select|Format:1:1->HTML;2->Text;3->HTML and Text";
		$HELP_ITEMS["Format"]["Title"] = "Newsletter Format";
		$HELP_ITEMS["Format"]["Content"] = "How will this newsletter be composed and sent? Select HTML if you want to include colored text, images, tables, etc. Choose text to create and send your newsletter in plain-text. Alternatively, you can choose \'Both HTML and Text\' to create 2 versions of your newsletter. Subscribers who can view HTML will see the HTML version. Those that can\'t will see the plain-text version only.";

		$FORM_ITEMS[$noreq . "Use Template"]="select|TempID:5:$alltemps::onDblClick=\"showTemplatePreview(this.options[this.selectedIndex].value)\"";
		$HELP_ITEMS["TempID"]["Title"] = "Use Template?";
		$HELP_ITEMS["TempID"]["Content"] = "If you have created a template, you can choose to use it from the list below. The content from that template will then be included in your newsletter content on the next page.<br><br>Double click on a template to preview it.";

		$FORM_ITEMS[-1]="submit|Continue to Step 2:1-compose";

		$FORM=new AdminForm;
		$FORM->title="AddTemplate";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("compose?Action=AddEmail");
		$FORM->MakeForm("New Newsletter Details");

		$FORM->output = "Complete the form below to create a new newsletter. Double click on a template to preview it before continuing.<br>Click on the \"Continue to Step 2\" button to continue." . $FORM->output;

		$FORM->output .= '

			<script language="JavaScript">

				function showTemplatePreview(tId)
				{
					window.open("' . MakeAdminLink("templates?Action=PreviewPopup") . '&TempID="+tId);
				}

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.Name.value == "")
					{
						alert("Please enter a name for this newsletter.");
						f.Name.focus();
						return false;
					}
				}
			
			</script>
		';

		$OUTPUT.=MakeBox("Create Newsletter (Step 1 of 2)",$FORM->output);
	}

?>