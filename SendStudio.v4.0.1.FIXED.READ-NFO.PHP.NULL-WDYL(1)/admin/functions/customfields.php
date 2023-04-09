<?

	$Action = @$_REQUEST["Action"];
	$ListID = @$_REQUEST["ListID"];
	$FieldName = @$_REQUEST["FieldName"];
	$FieldType = @$_REQUEST["FieldType"];
	$FieldID = @$_REQUEST["FieldID"];
	$Required = @$_REQUEST["Required"];
	$Value = @$_REQUEST["Value"];
	$Label = @$_REQUEST["Label"];
	$DefaultValue = @$_REQUEST["DefaultValue"];
	$AllValues = @$_REQUEST["AllValues"];
	$Width = @$_REQUEST["Width"];
	$Height = @$_REQUEST["Height"];
	$Size = @$_REQUEST["Size"];
	$Min = @$_REQUEST["Min"];
	$Max = @$_REQUEST["Max"];

	$alltypes = "";
	$all_vals = "";
	$OUTPUT = "";

	switch($Action)
	{
		case "Edit":
		{
			ShowEditField();
			break;
		}
		case "SaveField":
		{
			SaveField();
			break;
		}
		case "Add1":
		{
			ShowAddCustomField1();
			break;
		}
		case "Add":
		{
			ShowAddCustomField();
			break;
		}

		default:
			ShowFieldList();
	}

	function ShowEditField()
	{
		// Show the form that lets the field be changed
		global $FieldID;
		global $FieldName;
		global $FieldType;
		global $OUTPUT;
		global $HELP_ITEMS;
		global $TABLEPREFIX;
		global $CURRENTADMIN;

		$FORM_ITEMSX = array();

		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		$Field=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE FieldID='$FieldID' ORDER BY FieldName ASC"));
		$FORM_ITEMS[$req . "Field Name"]="textfield|FieldName:30:44:".$Field["FieldName"];
		$HELP_ITEMS["FieldName"]["Title"] = "Field Name";
		$HELP_ITEMS["FieldName"]["Content"] = "The name of this field as it will be shown on your newsletter subscription form. It should be something like \'salary\', \'age\', etc.";
		
		$size = $min = $max = $Width = $Height = $j = 0;
		
		switch($Field["FieldType"])
		{
			case "shorttext":
			{
				$FORM_ITEMSX[$noreq . "Default Value"]="textfield|DefaultValue:100:44:".$Field["DefaultValue"];
				$HELP_ITEMS["DefaultValue"]["Title"] = "Default Value";
				$HELP_ITEMS["DefaultValue"]["Content"] = "Should this field contain some text by default? If so, enter that text in this box.";

				if(!$Field["AllValues"]){$Field["AllValues"]="30,0,100";}
				list($size,$min,$max)=explode(",",$Field["AllValues"]);
				
				$FORM_ITEMSX[$req . "Size"]="textfield|Size:4:4:$size";
				$HELP_ITEMS["Size"]["Title"] = "Size";
				$HELP_ITEMS["Size"]["Content"] = "How wide should this text box be? 30 is the default width of a text box on a web page.";

				$FORM_ITEMSX[$req . "Minimum Length"]="textfield|Min:4:4:$min";
				$HELP_ITEMS["Min"]["Title"] = "Mininum Length";
				$HELP_ITEMS["Min"]["Content"] = "Do you require a minimum number of characters for this field? If so, enter the minimum length here, such as \'2\'.";

				$FORM_ITEMSX[$req . "Maximum Length"]="textfield|Max:4:4:$max";
				$HELP_ITEMS["Max"]["Title"] = "Maximum Length";
				$HELP_ITEMS["Max"]["Content"] = "Should the text in this field not exceed a certain number of characters? If so, enter the maximum length here, such as \'10\'.";

				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.FieldName.value == "")
							{
								alert("Please enter a name for this field.");
								f.FieldName.focus();
								return false;
							}

							if(isNaN(f.Size.value) || f.Size.value == "")
							{
								alert("Please enter a size for this field.");
								f.Size.focus();
								f.Size.select();
								return false;
							}

							if(isNaN(f.Min.value) || f.Min.value == "")
							{
								alert("Please enter a minimum length for this field.");
								f.Min.focus();
								f.Min.select();
								return false;
							}

							if(isNaN(f.Max.value) || f.Max.value == "")
							{
								alert("Please enter a maximum length for this field.");
								f.Max.focus();
								f.Max.select();
								return false;
							}

							return true;
						}
					
					</script>
				';

				break;
			}		
			case "longtext":
			{
				$FORM_ITEMSX[$noreq . "Default Value"]="textarea|DefaultValue:46:5:".$Field["DefaultValue"];
				$HELP_ITEMS["DefaultValue"]["Title"] = "Default Value";
				$HELP_ITEMS["DefaultValue"]["Content"] = "Should this field contain some text by default? If so, enter that text in this box.";

				if(!$Field["AllValues"]){$Field["AllValues"]="40,5";}
					list($width,$height)=explode(",",$Field["AllValues"]);
				
				$FORM_ITEMSX[$req . "Width"]="textfield|Width:4:4:$width";
				$HELP_ITEMS["Width"]["Title"] = "Width";
				$HELP_ITEMS["Width"]["Content"] = "How wide should this text box be? 30 is the default width of a multiline text box on a web page.";
				
				$FORM_ITEMSX[$req . "Height"]="textfield|Height:4:4:$height";
				$HELP_ITEMS["Height"]["Title"] = "Height";
				$HELP_ITEMS["Height"]["Content"] = "How high should this text box be? 5 is the default height of a multiline text box on a web page.";

				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.FieldName.value == "")
							{
								alert("Please enter a name for this field.");
								f.FieldName.focus();
								return false;
							}

							if(isNaN(f.Width.value) || f.Width.value == "")
							{
								alert("Please enter the width of this field.");
								f.Width.focus();
								f.Width.select();
								return false;
							}

							if(isNaN(f.Height.value) || f.Height.value == "")
							{
								alert("Please enter the height of this field.");
								f.Height.focus();
								f.Height.select();
								return false;
							}

							return true;
						}
					
					</script>
				';

				break;
			}		
			case "checkbox":
			{
				$FORM_ITEMSX[$req . "Default Status"]="select|DefaultValue:1:0->Unchecked;CHECKED->Checked:".$Field["DefaultValue"];
				$HELP_ITEMS["DefaultValue"]["Title"] = "Default Value";
				$HELP_ITEMS["DefaultValue"]["Content"] = "Should this checkbox be unchecked (not ticked) or checked (ticked) by default?";

				$FORM_ITEMSX[$noreq . "Label"]="textfield|AllValues:30:44:".$Field["AllValues"];
				$HELP_ITEMS["AllValues"]["Title"] = "Label";
				$HELP_ITEMS["AllValues"]["Content"] = "Any text you enter here will appear as a label next to this checkbox.";

				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.FieldName.value == "")
							{
								alert("Please enter a name for this field.");
								f.FieldName.focus();
								return false;
							}

							return true;
						}
					
					</script>
				';

				break;
			}		
			case "dropdown":
			{
				$FORM_ITEMSX["-2"]="spacer|<BR>";
				$vals=explode(";",$Field["AllValues"]);
				$i=1;
				foreach($vals as $val){
					if($val){
					list($sys,$lab)=explode("->",$val);

					if($i < 3)
					{
						$FORM_ITEMSX[$req . "Value $i"]="textfield|Value[$i]:30:44:$sys";
						$FORM_ITEMSX[$req . "Label $i"]="textfield|Label[$i]:30:44:$lab";
					}
					else
					{
						$FORM_ITEMSX[$noreq . "Value $i"]="textfield|Value[$i]:30:44:$sys";
						$FORM_ITEMSX[$noreq . "Label $i"]="textfield|Label[$i]:30:44:$lab";
					}
					$i++;
					}
				}

				for($x=$i;$x<6;$x++){
					if($x < 3)
					{
						$FORM_ITEMSX[$req . "Value $x"]="textfield|Value[$x]:30:44:";
						$FORM_ITEMSX[$req . "Label $x"]="textfield|Label[$x]:30:44:";
					}
					else
					{
						$FORM_ITEMSX[$noreq . "Value $x"]="textfield|Value[$x]:30:44:";
						$FORM_ITEMSX[$noreq . "Label $x"]="textfield|Label[$x]:30:44:";
					}
				}

				$FORM_ITEMSX[$noreq . "Default Value"]="textfield|DefaultValue:50:44:".$Field["DefaultValue"];

				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.FieldName.value == "")
							{
								alert("Please enter a name for this field.");
								f.FieldName.focus();
								return false;
							}

							if(f.elements[2].value == "")
							{
								alert("Please enter text for the first value.");
								f.elements[2].focus();
								return false;
							}

							if(f.elements[3].value == "")
							{
								alert("Please enter a label for the first value.");
								f.elements[3].focus();
								return false;
							}

							if(f.elements[4].value == "")
							{
								alert("Please enter text for the second value.");
								f.elements[4].focus();
								return false;
							}

							if(f.elements[5].value == "")
							{
								alert("Please enter a label for the second value.");
								f.elements[5].focus();
								return false;
							}

							return true;
						}
					
					</script>
				';
			}
		}
				
		$FORM_ITEMS[$req . "Required"]="select|Required:1:0->No;1->Yes:".$Field["Required"];
		$HELP_ITEMS["Required"]["Title"] = "Required?";
		$HELP_ITEMS["Required"]["Content"] = "When filling out your subscription form, does this form have to be completed?";

		$FORM_ITEMS=array_merge($FORM_ITEMS, $FORM_ITEMSX);

		$FORM_ITEMS["-1"]="submit|Save Field:1-customfields";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="EditFielde";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("customfields?Action=SaveField&FieldID=$FieldID");
		$FORM->MakeForm("Custom Field Details");

		$FORM->output = "Complete the form below to modify this custom subscriber field." . $FORM->output;
		$OUTPUT.=MakeBox("Edit Custom Field",$FORM->output);
	}

	function SaveField()
	{
		// Save this field to the database
		global $FieldID;
		global $FieldName;
		global $Required;
		global $Value;
		global $Label;
		global $AllValues;
		global $DefaultValue;
		global $OUTPUT;
		global $Width;
		global $Height;
		global $Size;
		global $Min;
		global $Max;
		global $TABLEPREFIX;
		global $CURRENTADMIN;

		$Field=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE FieldID='$FieldID'"));
		$all_vals = "";

		switch($Field["FieldType"]){
			case "checkbox":
			{
				$all_vals = $AllValues;
				break;
			}
			case "dropdown":
			{
				foreach($Value as $key=>$val){
					if($val){$lab=$Label[$key];
						$all_vals.=$val."->".$lab.";";
					}
				}
				break;
			}
			case "longtext":
			{
				$all_vals="$Width,$Height";
				break;
			}
			case "shorttext":
			{
				$all_vals="$Size,$Min,$Max";
				break;
			}	
		}

		mysql_query("UPDATE " . $TABLEPREFIX . "list_fields SET FieldName='$FieldName', Required='$Required', AllValues='$all_vals',DefaultValue='$DefaultValue' WHERE FieldID='$FieldID'");

		$OUTPUT .= MakeSuccessBox("Custom Field Updated Successfully", "The custom field that you created has been saved successfully.", MakeAdminLink("customfields?Action=ListFields&ListID=$ListID"));
	}

	function ShowAddCustomField1()
	{
		global $FieldName;
		global $FieldType;
		global $OUTPUT;
		global $HELP_ITEMS;
		global $TABLEPREFIX;
		global $CURRENTADMIN;

		mysql_query("INSERT INTO " . $TABLEPREFIX . "list_fields SET AdminID='" . $CURRENTADMIN["AdminID"] . "', FieldType='$FieldType', FieldName='$FieldName'");
		$FieldID=mysql_insert_id();

		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		$Field=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE FieldID='$FieldID' ORDER BY FieldName ASC"));
		$FORM_ITEMS[$req . "Field Name"]="textfield|FieldName:30:44:".$Field["FieldName"];
		$HELP_ITEMS["FieldName"]["Title"] = "Field Name";
		$HELP_ITEMS["FieldName"]["Content"] = "The name of this field as it will be shown on your newsletter subscription form. It should be something like \'salary\', \'age\', etc.";
		
		$size = $min = $max = $Width = $Height = $j = 0;
		
		switch($Field["FieldType"])
		{
			case "shorttext":
			{
				$FORM_ITEMSX[$noreq . "Default Value"]="textfield|DefaultValue:100:44:".$Field["DefaultValue"];
				$HELP_ITEMS["DefaultValue"]["Title"] = "Default Value";
				$HELP_ITEMS["DefaultValue"]["Content"] = "Should this field contain some text by default? If so, enter that text in this box.";

				if(!$Field["AllValues"]){$Field["AllValues"]="30,0,100";}
				list($size,$min,$max)=explode(",",$Field["AllValues"]);
				
				$FORM_ITEMSX[$req . "Size"]="textfield|Size:4:4:$size";
				$HELP_ITEMS["Size"]["Title"] = "Size";
				$HELP_ITEMS["Size"]["Content"] = "How wide should this text box be? 30 is the default width of a text box on a web page.";

				$FORM_ITEMSX[$req . "Minimum Length"]="textfield|Min:4:4:$min";
				$HELP_ITEMS["Min"]["Title"] = "Mininum Length";
				$HELP_ITEMS["Min"]["Content"] = "Do you require a minimum number of characters for this field? If so, enter the minimum length here, such as \'2\'.";

				$FORM_ITEMSX[$req . "Maximum Length"]="textfield|Max:4:4:$max";
				$HELP_ITEMS["Max"]["Title"] = "Maximum Length";
				$HELP_ITEMS["Max"]["Content"] = "Should the text in this field not exceed a certain number of characters? If so, enter the maximum length here, such as \'10\'.";

				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.FieldName.value == "")
							{
								alert("Please enter a name for this field.");
								f.FieldName.focus();
								return false;
							}

							if(isNaN(f.Size.value) || f.Size.value == "")
							{
								alert("Please enter a size for this field.");
								f.Size.focus();
								f.Size.select();
								return false;
							}

							if(isNaN(f.Min.value) || f.Min.value == "")
							{
								alert("Please enter a minimum length for this field.");
								f.Min.focus();
								f.Min.select();
								return false;
							}

							if(isNaN(f.Max.value) || f.Max.value == "")
							{
								alert("Please enter a maximum length for this field.");
								f.Max.focus();
								f.Max.select();
								return false;
							}

							return true;
						}
					
					</script>
				';

				break;
			}		
			case "longtext":
			{
				$FORM_ITEMSX[$noreq . "Default Value"]="textarea|DefaultValue:46:5:".$Field["DefaultValue"];
				$HELP_ITEMS["DefaultValue"]["Title"] = "Default Value";
				$HELP_ITEMS["DefaultValue"]["Content"] = "Should this field contain some text by default? If so, enter that text in this box.";

				if(!$Field["AllValues"]){$Field["AllValues"]="40,5";}
					list($width,$height)=explode(",",$Field["AllValues"]);
				
				$FORM_ITEMSX[$req . "Width"]="textfield|Width:4:4:$width";
				$HELP_ITEMS["Width"]["Title"] = "Width";
				$HELP_ITEMS["Width"]["Content"] = "How wide should this text box be? 30 is the default width of a multiline text box on a web page.";
				
				$FORM_ITEMSX[$req . "Height"]="textfield|Height:4:4:$height";
				$HELP_ITEMS["Height"]["Title"] = "Height";
				$HELP_ITEMS["Height"]["Content"] = "How high should this text box be? 5 is the default height of a multiline text box on a web page.";

				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.FieldName.value == "")
							{
								alert("Please enter a name for this field.");
								f.FieldName.focus();
								return false;
							}

							if(isNaN(f.Width.value) || f.Width.value == "")
							{
								alert("Please enter the width of this field.");
								f.Width.focus();
								f.Width.select();
								return false;
							}

							if(isNaN(f.Height.value) || f.Height.value == "")
							{
								alert("Please enter the height of this field.");
								f.Height.focus();
								f.Height.select();
								return false;
							}

							return true;
						}
					
					</script>
				';

				break;
			}		
			case "checkbox":
			{
				$FORM_ITEMSX[$req . "Default Status"]="select|DefaultValue:1:0->Unchecked;CHECKED->Checked:".$Field["DefaultValue"];
				$HELP_ITEMS["DefaultValue"]["Title"] = "Default Value";
				$HELP_ITEMS["DefaultValue"]["Content"] = "Should this checkbox be unchecked (not ticked) or checked (ticked) by default?";

				$FORM_ITEMSX[$noreq . "Label"]="textfield|AllValues:30:44:".$Field["AllValues"];
				$HELP_ITEMS["AllValues"]["Title"] = "Label";
				$HELP_ITEMS["AllValues"]["Content"] = "Any text you enter here will appear as a label next to this checkbox.";

				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.FieldName.value == "")
							{
								alert("Please enter a name for this field.");
								f.FieldName.focus();
								return false;
							}

							return true;
						}
					
					</script>
				';

				break;
			}		
			case "dropdown":
			{
				$FORM_ITEMSX["-2"]="spacer|<BR>";
				$i = 1;

				for($x=$i;$x<($i+5);$x++){
					if($x < 3)
					{
						$FORM_ITEMSX[$req . "Value $x"]="textfield|Value[$x]:30:44:";
						$FORM_ITEMSX[$req . "Label $x"]="textfield|Label[$x]:30:44:";
					}
					else
					{
						$FORM_ITEMSX[$noreq . "Value $x"]="textfield|Value[$x]:30:44:";
						$FORM_ITEMSX[$noreq . "Label $x"]="textfield|Label[$x]:30:44:";
					}
				}

				$FORM_ITEMSX[$noreq . "Default Value"]="textfield|DefaultValue:50:44:".$Field["DefaultValue"];

				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.FieldName.value == "")
							{
								alert("Please enter a name for this field.");
								f.FieldName.focus();
								return false;
							}

							if(f.elements[2].value == "")
							{
								alert("Please enter text for the first value.");
								f.elements[2].focus();
								return false;
							}

							if(f.elements[3].value == "")
							{
								alert("Please enter a label for the first value.");
								f.elements[3].focus();
								return false;
							}

							if(f.elements[4].value == "")
							{
								alert("Please enter text for the second value.");
								f.elements[4].focus();
								return false;
							}

							if(f.elements[5].value == "")
							{
								alert("Please enter a label for the second value.");
								f.elements[5].focus();
								return false;
							}

							return true;
						}
					
					</script>
				';
			}
		}
				
		$FORM_ITEMS[$req . "Required"]="select|Required:1:0->No;1->Yes:".$Field["Required"];
		$HELP_ITEMS["Required"]["Title"] = "Required?";
		$HELP_ITEMS["Required"]["Content"] = "When filling out your subscription form, does this form have to be completed?";

		$FORM_ITEMS=array_merge($FORM_ITEMS, $FORM_ITEMSX);

		$FORM_ITEMS["-1"]="submit|Save Field:1-customfields";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="EditFielde";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("customfields?Action=SaveField&FieldID=$FieldID");
		$FORM->MakeForm("Custom Field Details");

		$FORM->output = "Complete the form below to finish adding a custom subscriber field." . $FORM->output;
		$OUTPUT.=MakeBox("Create Custom Field (Step 2 of 2)",$FORM->output);
	}

	function ShowAddCustomField()
	{
		global $OUTPUT;
		global $FIELDTYPES;
		global $HELP_ITEMS;
		global $TABLEPREFIX;
		global $CURRENTADMIN;

		$EXT = "";
		$alltypes = "";

		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		//add extra field!
		$FORM_ITEMS2[$req . "Field Name"]="textfield|FieldName:30:44:";
		$HELP_ITEMS["FieldName"]["Title"] = "Field Name";
		$HELP_ITEMS["FieldName"]["Content"] = "The name of this field as it will be shown on your newsletter subscription form. It should be something like \'salary\', \'age\', etc.";

		foreach($FIELDTYPES AS $k=>$n)
		{
			$alltypes.=$k."->".$n.";";
		}
		
		$FORM_ITEMS2[$req . "Field Type"]="select|FieldType:1:$alltypes";
		$HELP_ITEMS["FieldType"]["Title"] = "Field Type";
		$HELP_ITEMS["FieldType"]["Content"] = "What type of field should be used to collect your subscribers input for this field?";

		$FORM_ITEMS2["-1"]="submit|Continue:1-customfields";

		//make the form
		$FORM2=new AdminForm;
		$FORM2->title="AddCustom";
		$FORM2->items=$FORM_ITEMS2;
		$FORM2->action=MakeAdminLink("customfields?Action=Add1");
		$FORM2->MakeForm("Custom Field Details");
		$FORM2->output = "Complete the form below to create a new custom subscriber field.<br>Click on the \"Continue to Step 2\" button to continue." . $FORM2->output;
		$OUTPUT.=MakeBox("Create Custom Field (Step 1 of 2)",$FORM2->output);

		$OUTPUT .= '

			<script language="JavaScript">

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.FieldName.value == "")
					{
						alert("Please enter a name for this field.");
						f.FieldName.focus();
						return false;
					}

					return true;
				}
			
			</script>
		';

	}

	function ShowFieldList()
	{
		global $FieldID;
		global $OUTPUT;
		global $ROOTURL;
		global $TABLEPREFIX;
		global $CURRENTADMIN;

		$RTB = "";
		$ListName = "All Lists";

		// If $FieldID isn't empty, it means we need to delete a field
		if($FieldID != "")
			@mysql_query("DELETE FROM " . $TABLEPREFIX . "list_fields WHERE FieldID = '$FieldID'");

		if($CURRENTADMIN["Manager"] != 1)
		{
			$Total = (int)@mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC"));
			$results = mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");
		}
		else
		{
			$Total=mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields ORDER BY FieldName ASC"));
			$results = mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields ORDER BY FieldName ASC");
		}

		if($Total == 0)
			$RTB .= 'The are currently no custom subscriber fields. Click "Create Custom Field" to create one.<br><br><input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("customfields?Action=Add&ListID=$ListID") . '\'" value="Create Custom Field"><br><br>';
		else	
			$RTB .= 'Use the form below to review, edit and delete custom subscriber fields.<br>To create a new field, click on the "Create Custom Field" button below.<br><br><input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("customfields?Action=Add&ListID=$ListID") . '\'" value="Create Custom Field"><br><br>';

		if($Total > 0)
		{
			$RTB .= '

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
					<td class="headbold bevel5" width=40%>
						Field Name
					</td>
					<td class="headbold bevel5" width=20%>
						Field Type
					</td>
					<td class="headbold bevel5" width=16%>
						Required
					</td>
					<td class="headbold bevel5" width=20%>
						Action
					</td>
				</tr>
			';

			while($r=mysql_fetch_array($results)){

				switch($r["FieldType"])
				{
					case "shorttext":
						$FieldType = "One Line Textbox";
						break;
					case "longtext":
						$FieldType = "Multiline Textbox";
						break;
					case "checkbox":
						$FieldType = "Checkbox (Yes/No)";
						break;
					case "dropdown":
						$FieldType = "Dropdown List";
						break;
				}

				 $Req = ($r["Required"] == 1 ? "Yes" : "No");

				$RTB .= '

					<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
						<td height=20 class="body bevel4" width=4% class="body">
							<img src="' . $ROOTURL . 'admin/images/field.gif" width="16" height="13">
						</td>
						<td class="body bevel4" width=40%>' . $r["FieldName"] . '</td>
						<td class="body bevel4" width=20%>' . $FieldType . '</td>
						<td class="body bevel4" width=16%>' . $Req . '</td>
						<td class="body bevel4" width=20%>';

						$RTB.=MakeLink("customfields?Action=Edit&FieldID=" . $r["FieldID"],"Edit") . "&nbsp;&nbsp;&nbsp;";
						$RTB.=MakeLink("customfields?Action=ListFields&FieldID=" . $r["FieldID"],"Delete", 1);

				$RTB .= '		
						</td>
					</tr>
				';

			}

			$RTB .= '</table>';
		}

		$OUTPUT.=MakeBox("Manage Custom Subscriber Fields for $ListName",$RTB);
	}

?>