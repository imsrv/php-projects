<?

	$Action = @$_REQUEST["Action"];
	$Save = @$_REQUEST["Save"];
	$SubAction = @$_REQUEST["SubAction"];
	$LinkID = @$_REQUEST["LinkID"];
	$LinkURL = @$_REQUEST["LinkURL"];
	$LinkName = @$_REQUEST["LinkName"];
	$Status = @$_REQUEST["Status"];
	$AddLink = @$_REQUEST["AddLink"];

	$alllists = "";
	$OUTPUT = "";

	if($Action == "Add")
	{
		$req = "<span class=req>*</span> ";

		$FORM_ITEMS[$req . "Link URL"]="textfield|LinkURL:1000:44:".str_replace(":",'$$COLON$$',"http://www.");
		$HELP_ITEMS["LinkURL"]["Title"] = "Link URL";
		$HELP_ITEMS["LinkURL"]["Content"] = "The entire URL for this link, such as \'http://www.mysite.com/test.html\'.";

		$FORM_ITEMS[-1]="submit|Continue to Step 2:1-links";

		$FORM=new AdminForm;
		$FORM->title="CreateLink";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("links?Action=CreateLink&AddLink=1");
		$FORM->MakeForm("New Link Details");

		$FORM->output = "Complete the form below to create a new link.<br>Click on the \"Continue to Step 2\" button to continue." . $FORM->output;

		$OUTPUT.=MakeBox("Create Link (Step 1 of 2)",$FORM->output);

		$OUTPUT .= '

			<script language="JavaScript">

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.LinkURL.value == "" | f.LinkURL.value == "http://www.")
					{
						alert("Please enter a URL for this link, such as \'http://www.mysite.com/test.html\'");
						f.LinkURL.focus();
						f.LinkURL.select();
						return false;
					}
				}
			
			</script>
		';

	}

	if($Action=="Preview"){
		$l=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE LinkID='$LinkID'"));
		
		$OUTPUT.="
		<script language=\"JavaScript\">
		window.name='PreviewLink';
		PreviewLink=window.open('".$l["URL"]."','Preview_Link','');
		</script>
			";
		$Action="";
	}

	if($Action=="CreateLink")
	{
		$Name=str_replace("http://","",$LinkURL);
		mysql_query("INSERT INTO " . $TABLEPREFIX . "links SET URL='$LinkURL', LinkName='$Name', Status='1', DateEntered='$SYSTEMTIME', AdminID='" . $CURRENTADMIN["AdminID"] . "'");
		$LinkID=mysql_insert_id();
		$Action="EditLink";
	}



	if($Action=="EditLink"){
		
		if($Save){
			mysql_query("UPDATE " . $TABLEPREFIX . "links SET URL='$LinkURL', LinkName='$LinkName', Status='$Status' WHERE LinkID='$LinkID'");
			$OUTPUT .= MakeSuccessBox("Link Saved Successfully", "The selected link has been saved successfully.", MakeAdminLink("links?Action="));
		}else{
			$l=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE LinkID='$LinkID'"));

			$req = "<span class=req>*</span> ";

			$FORM_ITEMS[$req . "Link URL"]="textfield|LinkURL:1000:44:".str_replace(":",'$$COLON$$',$l["URL"]);
			$HELP_ITEMS["LinkURL"]["Title"] = "Link URL";
			$HELP_ITEMS["LinkURL"]["Content"] = "The entire URL for this link, such as \'http://www.mysite.com/test.html\'.";

			$FORM_ITEMS[$req . "Name"]="textfield|LinkName:100:44:".$l["LinkName"];
			$HELP_ITEMS["LinkName"]["Title"] = "Link Name";
			$HELP_ITEMS["LinkName"]["Content"] = "Enter a name for this link. This name is for your reference only, such as \'Link to my site\'.";

			$FORM_ITEMS[$req . "Status"]="select|Status:1:0->Inactive;1->Active:".$l["Status"];
			$HELP_ITEMS["Status"]["Title"] = "Status";
			$HELP_ITEMS["Status"]["Content"] = "Is this link active? If so, you will be able to add it to your content when composing a newsletter.";

			$FORM_ITEMS["-1"]="submit|Save Link:1-links";

			$FORM=new AdminForm;
			$FORM->title="EditLink";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("links?Action=EditLink&Save=Yes&LinkID=$LinkID");
			$FORM->MakeForm("Link Details");

			if($AddLink == "1")
			{
				$FORM->output = "Complete the form below to finish adding a link." . $FORM->output;
				$OUTPUT.=MakeBox("Create Link (Step 2 of 2)",$FORM->output);
			}
			else
			{
				$FORM->output = "Complete the form below to finish editing this link." . $FORM->output;
				$OUTPUT.=MakeBox("Edit Link",$FORM->output);
			}

			$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{
						var f = document.forms[0];

						if(f.LinkURL.value == "" || f.LinkURL.value == "http://www.")
						{
							alert("Please enter a URL for this link, such as \'http://www.mysite.com/test.html\'");
							f.LinkURL.focus();
							return false;
						}

						if(f.LinkName.value == "")
						{
							alert("Please enter a name for this link.");
							f.LinkName.focus();
							return false;
						}
					}
				
				</script>


			';
		
		}
	}



	if($Action==""){

		$ListName = "All Lists";

		if($SubAction=="DeleteLink"){
			mysql_query("DELETE FROM " . $TABLEPREFIX . "links WHERE LinkID='$LinkID'");
		}

		if($CURRENTADMIN["Manager"] == 1)
		{
			$Total = mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "links ORDER BY LinkName ASC"));
			$links = mysql_query("SELECT * FROM " . $TABLEPREFIX . "links ORDER BY LinkName ASC");
		}
		else
		{
			$Total = mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY LinkName ASC"));
			$links = mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY LinkName ASC");
		}

		if($Total > 0)
		{
			//currently defined links!
			$LO='

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

				Use the form below to preview, edit and delete your links.<br>
				To create a new link, click on the "Create Link" button below.<br><br>
				<input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("links?Action=Add") . '"\' value="Create Link">
				<br><br>

				<table width=100% border=0 cellspacing=2 cellpadding=2>
				  <tr>
					<td width=4% class="headbold bevel5">&nbsp;</td>
					<td class="headbold bevel5" width=30%>
						Link Name
					</td>
					<td class="headbold bevel5" width=30%>
						URL
					</td>
					<td class="headbold bevel5" width=15%>
						Date Created
					</td>
					<td class="headbold bevel5" width=21%>
						Action
					</td>
				</tr>
			';

			while($l=mysql_fetch_array($links))
			{
				if(strlen($l["URL"])>30){
					$URL=substr($l["URL"],0,28)."...";
				}else{
					$URL=$l["URL"];
				}

				$LO .= '

					<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
						<td height=20 class="body bevel4" width=4% class="body">
							<img src="' . $ROOTURL . 'admin/images/link.gif" width="16" height="16">
						</td>
						<td class="body bevel4" width=30%>' . $l["LinkName"] . '</td>
						<td class="body bevel4" width=30%>' . $URL . '</td>
						<td class="body bevel4" width=15%>' . DisplayDate($l["DateEntered"]) . '</td>
						<td class="body bevel4" width=21%>';

				$LO.=MakeLink("links?Action=EditLink&LinkID=".$l["LinkID"],"Edit");
				$LO.="&nbsp;&nbsp;&nbsp;" . MakeLink("links?Action=&SubAction=DeleteLink&LinkID=".$l["LinkID"],"Delete",1);
				$LO.="&nbsp;&nbsp;&nbsp;" . MakeLink("links?Action=Preview&LinkID=".$l["LinkID"],"Preview");

				$LO .= '
					</tr>
				';
			}

			$LO.='</table>';
		}
		else
		{
			$LO = '
				No links have been created. Click the "Create Link" button below to create one.<br><br>
				<input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("links?Action=Add") . '"\' value="Create Link">
				<br><br>';
		}

		$OUTPUT.=MakeBox("Link Manager",$LO);
	}

?>