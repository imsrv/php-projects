<?

	$Action = @$_REQUEST["Action"];
	$SubAction = @$_REQUEST["SubAction"];
	$DontDo = @$_REQUEST["DontDo"];
	$Save = @$_REQUEST["Save"];
	$FormName = @$_REQUEST["FormName"];
	$Status = @$_REQUEST["Status"];
	$SubSave = @$_REQUEST["SubSave"];
	$Lists = @$_REQUEST["Lists"];
	$RequireConfirm = @$_REQUEST["RequireConfirm"];
	$SendThankyou = @$_REQUEST["SendThankyou"];
	$ContentTypeID = @$_REQUEST["ContentTypeID"];
	$Lists = @$_REQUEST["Lists"];
	$SendThankyouField = @$_REQUESt["SendThankyouField"];
	$Responses = @$_REQUEST["Responses"];
	$Field = @$_REQUEST["Field"];
	$ASubSave = @$_REQUEST["ASubSave"];
	$SelectedType = @$_REQUEST["SelectedType"];
	$FormID = @$_REQUEST["FormID"];
	$TemplateID = @$_REQUEST["TemplateID"];

	$OUTPUT = "";
	$allct = "";
	$SelectLists = 1;
	$fields = array();
	$FORM_ITEMS = array();

	if($Action=="PreviewTemplate")
	{
		// Show a preview of the form
		@ob_end_clean();
		@ob_start();

		switch($TemplateID)
		{
			case 0: // Default white
			{
				$Code = '
					<table cellspacing="0" cellpadding="0">
					  <tr>
						<td height="20" colspan="2">
						  <p style="margin: 7"><font size="2" color="#000000" face="Verdana"><b>&nbsp;My
                          Mailing List</b></font></p>
						</td>
					  </tr>
					  <tr>
						<td valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Your Email Address:</font>
					   </td>
						<td valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="text" style="font-family: Verdana; font-size: 8pt" name="Email" size="30"></font>
					   </td>
					  </tr>
					  <tr>
						<td valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
							</font>
					   </td>
						<td valign="top">
                            <p style="margin: 7">
					<input type="checkbox" name="SelectLists[1]" value="YES" CHECKED><font size="1" face="Verdana">Test
                            Mailing List<br>
                            </font>
						   </td>
						  </tr>
					  <tr>
						<td valign="top">
					   </td>
						<td valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
					   </td>
					  </tr>
					</table>
				';
				break;
			}
			case 1: // Chisel Gray
			{
				$Code = '
					<table style="border: dotted 1px #000000" cellspacing="0" cellpadding="0">
					  <tr>
						<td height="20" bgcolor="#C8C8C8" colspan="2">
						  <p style="margin: 7"><font size="2" color="#000000" face="Verdana"><b>&nbsp;My
                          Newsletter</b></font></p>
						</td>
					  </tr>
					  <tr>
						<td bgcolor="#ECECEC" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Your Email Address:</font>
					   </td>
						<td bgcolor="#ECECEC" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="text" style="font-family: Verdana; font-size: 8pt" name="Email" size="30"></font>
					   </td>
					  </tr>
					  <tr>
						<td bgcolor="#ECECEC" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
							</font>
					   </td>
						<td bgcolor="#ECECEC" valign="top">
                            <p style="margin: 7">
					<input type="checkbox" name="SelectLists[1]" value="YES" CHECKED><font size="1" face="Verdana">Test
                            Mailing List<br>
                            </font>
						   </td>
						  </tr>
					  <tr>
						<td bgcolor="#ECECEC" valign="top">
					   </td>
						<td bgcolor="#ECECEC" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="button" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
					   </td>
					  </tr>
					</table>
				';
				break;
			}
			case 2: // Midnight Blue
			{
				$Code = '
					<table style="border: 1px dotted #034089" cellspacing="0" cellpadding="0">
					  <tr>
						<td height="20" bgcolor="#034089" colspan="2">
						  <p style="margin: 7"><b><font size="2" color="#FFFFFF" face="Verdana">&nbsp;My
                          Newsletter</font></b></p>
						</td>
					  </tr>
					  <tr>
						<td bgcolor="#DDE6F7" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Your Email Address:</font>
					   </td>
						<td bgcolor="#DDE6F7" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="text" style="font-family: Verdana; font-size: 8pt" name="Email" size="30"></font>
					   </td>
					  </tr>
					  <tr>
						<td bgcolor="#DDE6F7" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
							</font>
					   </td>
						<td bgcolor="#DDE6F7" valign="top">
                            <p style="margin: 7">
					<input type="checkbox" name="SelectLists[1]" value="YES" CHECKED><font size="1" face="Verdana">Test
                            Mailing List<br>
                            </font>
						   </td>
						  </tr>
					  <tr>
						<td bgcolor="#DDE6F7" valign="top">
					   </td>
						<td bgcolor="#DDE6F7" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="button" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
					   </td>
					  </tr>
					</table>
				';
				break;
			}
			case 3: // Sunrise Orange
			{
				$Code = '
					<table style="border: 1px solid #FF9900" cellspacing="0" cellpadding="0">
					  <tr>
						<td height="20" bgcolor="#FF9900" colspan="2">
						  <p style="margin: 7"><b><font size="2" color="#FFFFFF" face="Verdana">&nbsp;My
                          Newsletter</font></b></p>
						</td>
					  </tr>
					  <tr>
						<td bgcolor="#FFFFE8" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Your Email Address:</font>
					   </td>
						<td bgcolor="#FFFFE8" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="text" style="font-family: Verdana; font-size: 8pt" name="Email" size="30"></font>
					   </td>
					  </tr>
					  <tr>
						<td bgcolor="#FFFFE8" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
							</font>
					   </td>
						<td bgcolor="#FFFFE8" valign="top">
                            <p style="margin: 7">
					<input type="checkbox" name="SelectLists[1]" value="YES" CHECKED><font size="1" face="Verdana">Test
                            Mailing List<br>
                            </font>
						   </td>
						  </tr>
					  <tr>
						<td bgcolor="#FFFFE8" valign="top">
					   </td>
						<td bgcolor="#FFFFE8" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="button" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
					   </td>
					  </tr>
					</table>
				';
				break;
			}
			case 4: // Evergreen
			{
				$Code = '
					<table style="border: 1px solid #009900" cellspacing="0" cellpadding="0">
					  <tr>
						<td height="20" bgcolor="#009900" colspan="2">
						  <p style="margin: 7"><b><font size="2" color="#FFFFFF" face="Verdana">&nbsp;My
                          Newsletter</font></b></p>
						</td>
					  </tr>
					  <tr>
						<td bgcolor="#E8FFE8" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Your Email Address:</font>
					   </td>
						<td bgcolor="#E8FFE8" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="text" style="font-family: Verdana; font-size: 8pt" name="Email" size="30"></font>
					   </td>
					  </tr>
					  <tr>
						<td bgcolor="#E8FFE8" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
							</font>
					   </td>
						<td bgcolor="#E8FFE8" valign="top">
                            <p style="margin: 7">
					<input type="checkbox" name="SelectLists[1]" value="YES" CHECKED><font size="1" face="Verdana">Test
                            Mailing List<br>
                            </font>
						   </td>
						  </tr>
					  <tr>
						<td bgcolor="#E8FFE8" valign="top">
					   </td>
						<td bgcolor="#E8FFE8" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="button" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
					   </td>
					  </tr>
					</table>
				';
				break;
			}
			case 5: // Devilish Red
			{
				$Code = '
					<table style="border: 1px solid #CC3300" cellspacing="0" cellpadding="0">
					  <tr>
						<td height="20" bgcolor="#CC3300" colspan="2">
						  <p style="margin: 7"><b><font size="2" color="#FFFFFF" face="Verdana">&nbsp;My
                          Newsletter</font></b></p>
						</td>
					  </tr>
					  <tr>
						<td bgcolor="#EBEBEB" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Your Email Address:</font>
					   </td>
						<td bgcolor="#EBEBEB" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="text" style="font-family: Verdana; font-size: 8pt" name="Email" size="30"></font>
					   </td>
					  </tr>
					  <tr>
						<td bgcolor="#EBEBEB" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
							</font>
					   </td>
						<td bgcolor="#EBEBEB" valign="top">
                            <p style="margin: 7">
					<input type="checkbox" name="SelectLists[1]" value="YES" CHECKED><font size="1" face="Verdana">Test
                            Mailing List<br>
                            </font>
						   </td>
						  </tr>
					  <tr>
						<td bgcolor="#EBEBEB" valign="top">
					   </td>
						<td bgcolor="#EBEBEB" valign="top">
							<p style="margin: 7"><font size="1" face="Verdana">
							<input type="button" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
					   </td>
					  </tr>
					</table>
				';
				break;
			}
		}

		echo $Code;
		die();
	}

	if($Action=="Preview")
	{
		// Show a preview of the form
		include "../includes$DIRSLASH"."forms.inc.php";

		@ob_end_clean();
		@ob_start();

		$Code = FormCode($FormID);
		echo $Code;
		die();
	}

	if($Action == "Add")
	{
		//create new form box!
		$DontDo = true;
		$req = "<span class=req>*</span> ";

		$FORM_ITEMS[$req . "Form Name"]="textfield|FormName:100:44:";
		$HELP_ITEMS["FormName"]["Title"] = "Form Name";
		$HELP_ITEMS["FormName"]["Content"] = "Enter the name of this form here. The form name is used in the control panel for your reference and is also included in the HTML code that you can place on your site. An example would be &quot;MySite.com Newsletter Subscription Form&quot;";
		
		$FORM_ITEMS[$req . "Form Type"]="select|FormType:1:sub->Subscription Form;unsub->Unsubscription Form;";
		$HELP_ITEMS["FormType"]["Title"] = "Form Type";
		$HELP_ITEMS["FormType"]["Content"] = "Would you like to create a subscription or unsubscription form?";

		$FORM_ITEMS[$req . "Form Design"]="select|TemplateID:1:0->Default White;1->Chisel Gray;2->Midnight Blue;3->Sunrise Orange;4->Evergreen;5->Devilish Red:0::<input class='pbutton' type='button' value='Preview Design' onClick='PreparePreview()'>";
		$HELP_ITEMS["TemplateID"]["Title"] = "Form Type";
		$HELP_ITEMS["TemplateID"]["Content"] = "How would you like your form to look? Choose a design from this list. You can click the \'Preview Design\' button to see the design before continuing.";
		
		$FORM_ITEMS["-1"]="submit|Continue to Step 2:1-forms";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="View Banned";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("forms?Action=AddForm");
		$FORM->MakeForm("New Form Details");

		$FORM->output = "Complete the form below to create a new subscription/unsubscription form.<br>Click on the \"Continue to Step 2\" button to continue." . $FORM->output;

		$OUTPUT .= MakeBox("Create Form (Step 1 of 3)", $FORM->output);
		$OUTPUT .= '

			<script language="JavaScript">

				function PreparePreview()
				{
					TemplateID = document.getElementById("TemplateID").options[document.getElementById("TemplateID").selectedIndex].value;
					window.open("' . MakeAdminLink("forms?Action=PreviewTemplate") . '&TemplateID=" + TemplateID , "pp");
				}

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.FormName.value == "")
					{
						alert("Please enter a name for this form.");
						f.FormName.focus();
						return false;
					}

					return true;
				}
			
			</script>
		';
	}

	if($Action=="GenerateCode"){
		include "../includes$DIRSLASH"."forms.inc.php";

		$Code=FormCode($FormID);
		
		$FORM_ITEMS["Form HTML"]="textarea|CODE:61:10:" . str_replace(":", "&#58;", htmlentities($Code));
		$HELP_ITEMS["CODE"]["Title"] = "Form HTML";
		$HELP_ITEMS["CODE"]["Content"] = "This is the code that you should place on your website to let your visitors subscribe to your newsletter. Simply select all of the code, right click in the textbox and choose copy. Then, edit your web page and paste the code into the place where you want it to display.";

		$FORM_ITEMS[-2]="spacer|&nbsp;";

		$FORM=new AdminForm;
		$FORM->title="GetHTML";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("forms");
		$FORM->MakeForm("HTML Form Code");

		$FORM->output = "The code for your form is shown below. Simply copy the code below and paste it into your website." . $FORM->output;
		$OUTPUT.=MakeBox("Generate Form Code",$FORM->output);

		$DontDo=1;
	}

	if($Action=="FormFields"){
		$form=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID' ORDER BY FormName ASC"));
		if($SubSave){
			switch($form["FormType"]){
				case "sub":
					if($Field){foreach($Field as $FieldID=>$val){
						switch($val){
							case "exclude":
								$include=0;
								$setvalue=0;
								$combine=0;
							break;
							case "doinclude":
								$include=1;
								$setvalue=0;
								$combine=0;
							break;
							case "combine":
								$combine=1;
								$include=0;
								$setvalue=0;
							break;
							case "value":
								$combine=0;
								$include=0;
								$setvalue=1;
							break;
						}
						if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_fields WHERE FieldID='$FieldID' && FormID='$FormID'"))==0){
						mysql_query("INSERT INTO " . $TABLEPREFIX . "form_fields SET FormID='$FormID', FieldID='$FieldID', Include='$include', SetValue='$setvalue', Combine='$combine', TypeOption='".$val."'");		
						}else{
						mysql_query("UPDATE " . $TABLEPREFIX . "form_fields SET Include='$include', SetValue='$setvalue', Combine='$combine', TypeOption='".$val."' WHERE FormID='$FormID' && FieldID='$FieldID'");		
						}
					}}
				
				break;
				
				case "content":
					foreach($Field as $FieldID=>$val){
						switch($val){
							case "exclude":
								$include=0;
								$setvalue=0;
								$combine=0;
							break;
							case "doinclude":
								$include=1;
								$setvalue=0;
								$combine=0;
							break;
							case "combine":
								$combine=1;
								$include=0;
								$setvalue=0;
							break;
							case "value":
								$combine=0;
								$include=0;
								$setvalue=1;
							break;
						}
						if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_fields WHERE FieldID='$FieldID' && FormID='$FormID'"))==0){
						mysql_query("INSERT INTO " . $TABLEPREFIX . "form_fields SET FormID='$FormID', FieldID='$FieldID', Include='$include', SetValue='$setvalue', TypeOption='".$val."'");		
						}else{
						mysql_query("UPDATE " . $TABLEPREFIX . "form_fields SET Include='$include', SetValue='$setvalue', TypeOption='".$val."' WHERE FormID='$FormID' && FieldID='$FieldID'");		
						}
					}
				break;
			
			}
		$Action="ExtraOptions";
		}else{
			$x=-3;
			switch($form["FormType"]){
				case "sub":
					$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
						while($l=mysql_fetch_array($lists)){
							$x--;
							$list=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$l["ListID"]."'"));
							$FORM_ITEMS[$x]="spacer|<B>".$list["ListName"].'</B>';
							$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='".$CURRENTADMIN["AdminID"]."' ORDER BY FieldName ASC");
								while($f=mysql_fetch_array($fields)){
									$ff=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_fields WHERE FormID='$FormID' && FieldID='".$f["FieldID"]."' ORDER BY FieldName ASC"));
									if($f["Required"]!=1){$r='exclude->Dont include in form;';}else{$r="";}
									$FORM_ITEMS[$list["ListName"].".".$f["FieldName"]]="select|Field[".$f["FieldID"]."]:1:doinclude->Include in form;combine->Combine with another field;value->Use a set value;$r:".$ff["TypeOption"];
								}
						}
				break;
				
				case "unsub":
					$FORM_ITEMS[$x]="spacer|<B>NO OPTIONS HERE FOR UNSUBSCRIBE FORMS</B>";
				break;
			}
		
			$FORM_ITEMS["-1000"]="submit|Save Changes";
			//make the form
			$FORM=new AdminForm;
			$FORM->title="View Banned";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("forms?Action=FormFields&SubSave=Yes&FormID=$FormID");
			$FORM->MakeForm();
		
			$OUTPUT.=MakeBox("Form field options",$FORM->output);
		
		}

	$DontDo=1;
	}



	if($Action=="ExtraOptions"){
	$form=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID' ORDER BY FormName ASC"));

		if($ASubSave){
			switch($form["FormType"]){
				case "sub":
					if($Fields){foreach($Fields as $FieldID=>$Setup){
						mysql_query("UPDATE " . $TABLEPREFIX . "form_fields SET TheValue='".$Setup["Value"]."', CombineWith='".$Setup["Combine"]."' WHERE FormID='$FormID' && FieldID='$FieldID'");
					
					}}
				
				 break;
				 
				 case "content":
					if($Fields){foreach($Fields as $FieldID=>$Setup){
						mysql_query("UPDATE " . $TABLEPREFIX . "form_fields SET TheValue='".$Setup["Value"]."' WHERE FormID='$FormID' && FieldID='$FieldID'");
					}}
				
				 break;
				
			
			}
		$Action="EditForm";
		}else{
			switch($form["FormType"]){
				case "sub":
					$ff=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_fields WHERE FormID='$FormID' ORDER BY FormName ASC");
					while($af=mysql_fetch_array($ff)){
						$f=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE FieldID='".$af["FieldID"]."' ORDER BY FieldName ASC"));
						$ll=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE AdminID='".$CURRENTADMIN["AdminID"]."' ORDER BY ListName ASC"));
						if($af["SetValue"]){
						switch($f["FieldType"]){
						case "shorttext":
							if($Fields[$f["FieldID"]]){
								$f["DefaultValue"]=$Fields[$f["FieldID"]];
							}
							list($size,$min,$max)=explode(",",$f["AllValues"]);
							$FORM_ITEMS[$ll["ListName"].".".$f["FieldName"]." value"]="textfield|Fields[".$f["FieldID"]."][Value]:$max:$size:".$af["TheValue"];
						break;
						
						case "longtext":
							if($Fields[$f["FieldID"]]){
								$f["DefaultValue"]=$Fields[$f["FieldID"]];
							}
							list($Width,$Height)=explode(",",$f["AllValues"]);
							$FORM_ITEMS[$ll["ListName"].".".$f["FieldName"]." value"]="textarea|Fields[".$f["FieldID"]."][Value]:$Width:$Height:".$af["TheValue"];
						break;
						
						case "checkbox":
							if($Fields[$f["FieldID"]] || $Action=="AddMember"){
								$f["DefaultValue"]=$Fields[$f["FieldID"]];
							}
							$FORM_ITEMS[$ll["ListName"].".".$f["FieldName"]." value"]="checkbox|Fields[".$f["FieldID"]."][Value]:CHECKED:Yes:".$af["TheValue"];
						break;
					
						case "dropdown":
							if($Fields[$f["FieldID"]]){
								$f[DefaultValue]=$Fields[$f["FieldID"]];
							}
							$FORM_ITEMS[$ll["ListName"].".".$f["FieldName"]." value"]="select|Fields[".$f["FieldID"]."][Value]:1:".$f["AllValues"].":".$af["TheValue"];
						break;
					}
						}
					if($af["Combine"]==1){
								$rf=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_fields WHERE FormID='$FormID' ORDER BY FieldName ASC");
								$allfields="";
								while($ra=mysql_fetch_array($rf)){
									$lf=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE FieldID='".$ra["FieldID"]."' ORDER BY FieldName ASC"));
									$lr=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$lf["ListID"]."' ORDER BY ListName ASC"));
										if($f["FieldID"]!=$ra["FieldID"]){
											$allfields.=$ra["FieldID"].'->'.$lr["ListName"].".".$lf["FieldName"].';';
										}
								}
									$FORM_ITEMS[$lr["ListName"].".".$f["FieldName"]." combine with"]="select|Fields[".$f["FieldID"]."][Combine]:1:$allfields:".$af["CombineWith"];
					}				
					}
					
						
				break;
			}	
			if(sizeof($FORM_ITEMS)==0){
				$Action="EditForm";
			}else{
			$FORM_ITEMS[-1000]="submit|Save Changes";
			//make the form
			$FORM=new AdminForm;
			$FORM->title="View Banned";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("forms?Action=ExtraOptions&ASubSave=Yes&FormID=$FormID");
			$FORM->MakeForm();
		
			$OUTPUT.=MakeBox("Form field options",$FORM->output);
			}
		}

		$DontDo=1;
	}


	if($Action=="GeneralOptions"){

	$form=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID' ORDER BY FormName ASC"));

		if($SubSave){
			switch($form["FormType"]){
				case "sub":
				mysql_query("UPDATE " . $TABLEPREFIX . "forms SET SelectLists='$SelectLists', SendThankyou='$SendThankyou', RequireConfirm='$RequireConfirm' WHERE FormID='$FormID'");
				mysql_query("DELETE FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
					foreach($Lists as $AListID=>$val){
						if($val==1){
							mysql_query("INSERT INTO " . $TABLEPREFIX . "form_lists SET FormID='$FormID', ListID='$AListID'");
						}
					}
				break;
				
				case "unsub":
				mysql_query("UPDATE " . $TABLEPREFIX . "forms SET SelectLists='$SelectLists', SendThankyou='$SendThankyou', RequireConfirm='$RequireConfirm' WHERE FormID='$FormID'");
				mysql_query("DELETE FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
					if($Lists){foreach($Lists as $ListID=>$val){
						if($val==1){
							mysql_query("INSERT INTO " . $TABLEPREFIX . "form_lists SET FormID='$FormID', ListID='$ListID'");
						}
					}}
				break;
				
				case "content":
					if($SendThankyouField==0){
						$SendThankyou=0;
					}else{
						$SendThankyou=1;
					}
					mysql_query("UPDATE " . $TABLEPREFIX . "forms SET ContentTypeID='$ContentTypeID', EmailField='$SendThankyouField', SendThankyou='$SendThankyou' WHERE FormID='$FormID'");
					mysql_query("DELETE FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
					if($Lists){foreach($Lists as $ListID=>$val){
						if($val==1){
							mysql_query("INSERT INTO " . $TABLEPREFIX . "form_lists SET FormID='$FormID', ListID='$ListID'");
						}
					}}
				break;
			
			}
			$Action="EditForm";
		}else{
			switch($form["FormType"]){
				case "sub":
					$FORM_ITEMS["<B>Work on lists</B>"]="spacer|";
					$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists ORDER BY ListName ASC");
						while($l=mysql_fetch_array($lists)){
							if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE ListID='".$l["ListID"]."' && FormID='$FormID'"))){$s="CHECKED";}else{$s="";}
							$FORM_ITEMS[$l["ListName"]]="checkbox|Lists[".$l["ListID"]."]:1:Yes:$s";
						}	
					$FORM_ITEMS["Require confirmation"]="select|RequireConfirm:1:0->No;1->Yes (Double Opt-In):".$form["RequireConfirm"];
					$FORM_ITEMS["Send Thankyou"]="select|SendThankyou:1:0->No;1->Yes:".$form["SendThankyou"];
			
				break;

				case "unsub":
					$FORM_ITEMS["<B>Work on lists</B>"]="spacer|";
					$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists ORDER BY ListName ASC");
						while($l=mysql_fetch_array($lists)){
							if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE ListID='".$l["ListID"]."' && FormID='$FormID'"))){$s="CHECKED";}else{$s="";}
							$FORM_ITEMS[$l["ListName"]]="checkbox|Lists[".$l["ListID"]."]:1:Yes:$s";
						}	
					$FORM_ITEMS["Require confirmation"]="select|RequireConfirm:1:0->No;1->Yes:".$form["RequireConfirm"];
					$FORM_ITEMS["Send Thankyou"]="select|SendThankyou:1:0->No;1->Yes:".$form["SendThankyou"];
			
				break;
			}
		
			$FORM_ITEMS["-1"]="submit|Save Changes";
			//make the form
			$FORM=new AdminForm;
			$FORM->title="View Banned";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("forms?Action=GeneralOptions&SubSave=Yes&FormID=$FormID");
			$FORM->MakeForm();
			$OUTPUT.=MakeBox("General form options",$FORM->output);
		}

		$DontDo=1;
	}


	if($Action=="AddForm"){
		$FormCode=md5(uniqid(rand()));
		mysql_query("INSERT INTO " . $TABLEPREFIX . "forms SET FormCode='$FormCode', FormType='$FormType', FormName='$FormName', DateCreated='$SYSTEMTIME', AdminID='" . $CURRENTADMIN["AdminID"] . "', TemplateID='$TemplateID'");
		$FormID=mysql_insert_id();
		$Action="EditForm";
	}

	if($Action=="EditForm"){

		$req = "<span class=req>*</span> ";
		$form=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID' ORDER BY FormName ASC"));

		if($Save){

			switch($form["FormType"]){
				case "sub":
				mysql_query("UPDATE " . $TABLEPREFIX . "forms SET SelectLists='$SelectLists', SendThankyou='$SendThankyou', RequireConfirm='$RequireConfirm', TemplateID='$TemplateID' WHERE FormID='$FormID'");
				mysql_query("DELETE FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
					foreach($Lists as $AListID=>$val){
						if($val==1){
							mysql_query("INSERT INTO " . $TABLEPREFIX . "form_lists SET FormID='$FormID', ListID='$AListID'");
						}
					}
				break;
				
				case "unsub":
				mysql_query("UPDATE " . $TABLEPREFIX . "forms SET SelectLists='$SelectLists', SendThankyou='$SendThankyou', RequireConfirm='$RequireConfirm', TemplateID='$TemplateID' WHERE FormID='$FormID'");
				mysql_query("DELETE FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
					if($Lists){foreach($Lists as $ListID=>$val){
						if($val==1){
							mysql_query("INSERT INTO " . $TABLEPREFIX . "form_lists SET FormID='$FormID', ListID='$ListID'");
						}
					}}
				break;
			}

			mysql_query("UPDATE " . $TABLEPREFIX . "forms SET FormName='$FormName', Status='$Status' WHERE FormID='$FormID'");
			$SelectedType=$form["FormType"];
			$Action = "ResponseOptions";
			$SubSave = "";
		}else{
			$form=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID' ORDER BY FormName ASC"));

			$FORM_ITEMS[$req . "Form Name"]="textfield|FormName:100:44:".$form["FormName"];
			$HELP_ITEMS["FormName"]["Title"] = "Form Name";
			$HELP_ITEMS["FormName"]["Content"] = "Enter the name of this form here. The form name is used in the control panel for your reference and is also included in the HTML code that you can place on your site. An example would be &quot;MySite.com Newsletter Subscription Form&quot;";

			$FORM_ITEMS[$req . "Form Design"]="select|TemplateID:1:0->Default White;1->Chisel Gray;2->Midnight Blue;3->Sunrise Orange;4->Evergreen;5->Devilish Red:" . $form["TemplateID"] . "::<input class='pbutton' type='button' value='Preview Design' onClick='PreparePreview()'>";
			$HELP_ITEMS["TemplateID"]["Title"] = "Form Type";
			$HELP_ITEMS["TemplateID"]["Content"] = "How would you like your form to look? Choose a design from this list. You can click the \'Preview Design\' button to see the design before continuing.";
			
			$FORM_ITEMS[$req . "Require Confirmation"]="select|RequireConfirm:1:0->No;1->Yes:".$form["RequireConfirm"];
			$HELP_ITEMS["RequireConfirm"]["Title"] = "Require Confirmation?";

			if($form["FormType"] == "sub")
				$HELP_ITEMS["RequireConfirm"]["Content"] = "If yes, then a double opt-in process will be used to verify subscribers. This means that after they complete the subscription form, they will also be required to confirm their email address by clicking on a link inside an email that will be sent to them automatically.";
			else
				$HELP_ITEMS["RequireConfirm"]["Content"] = "If yes, then a double opt-out process will be used to verify unsubscribers. This means that after they complete the unsubscription form, they will also be required to confirm their email address by clicking on a link inside an email that will be sent to them automatically.";

			$FORM_ITEMS[$req . "Send Thankyou"]="select|SendThankyou:1:0->No;1->Yes:".$form["SendThankyou"];
			$HELP_ITEMS["SendThankyou"]["Title"] = "Send Thankyou?";

			if($form["FormType"] == "sub")
				$HELP_ITEMS["SendThankyou"]["Content"] = "If yes, a thank you email will be sent to this subscriber after they complete the subscription form.";
			else
				$HELP_ITEMS["SendThankyou"]["Content"] = "If yes, a thank you email will be sent to this subscriber after they complete the unsubscription form.";

			if($form["FormType"] == "sub")
				$HELP_ITEMS["SelectLists"]["Content"] = "If yes, all lists will automatically be ticked for subscription.";
			else
				$HELP_ITEMS["SelectLists"]["Content"] = "If yes, all lists will automatically be ticked for unsubscription.";

			$e = 0;

			switch($form["FormType"]){
				case "sub":
				{
					$FORM_ITEMS["<br>$req<b>Lists to Subscribe to</b>"]="spacer|<br><br>&nbsp;";
					$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists ORDER BY ListName ASC");
						while($l=mysql_fetch_array($lists)){
							if(AllowList($l["ListID"]))
							{
								$e++;
								if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE ListID='".$l["ListID"]."' && FormID='$FormID'"))){$s="CHECKED";}else{$s="";}
								$FORM_ITEMS["&nbsp;&nbsp;&nbsp;" . $l["ListName"]]="checkbox|Lists[".$l["ListID"]."]:1:Yes:$s";
							}
						}	
					break;
				}
				case "unsub":
				{
					$FORM_ITEMS["<br>$req<b>Lists to Subscribe to</b>"]="spacer|<br><br>&nbsp;";
					$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists ORDER BY ListName ASC");
						while($l=mysql_fetch_array($lists)){
							if(AllowList($l["ListID"]))
							{
								$e++;
								if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE ListID='".$l["ListID"]."' && FormID='$FormID'"))){$s="CHECKED";}else{$s="";}
								$FORM_ITEMS["&nbsp;&nbsp;&nbsp;" . $l["ListName"]]="checkbox|Lists[".$l["ListID"]."]:1:Yes:$s";
							}
						}	
					break;
				}
			}

			$FORM_ITEMS["-2"]="spacer|<br>";

			if($SubAction == "")
				$FORM_ITEMS[-1]="submit|Continue to Step 3:1-forms";
			else
				$FORM_ITEMS[-1]="submit|Continue to Step 2:1-forms";

			//make the form
			$FORM=new AdminForm;
			$FORM->title="View Banned";
			$FORM->items=$FORM_ITEMS;

			if($SubAction == "")
				$FORM->action=MakeAdminLink("forms?Action=EditForm&Save=Yes&FormID=$FormID");
			else
				$FORM->action=MakeAdminLink("forms?Action=EditForm&SubAction=Edit&Save=Yes&FormID=$FormID");

			$FORM->MakeForm("New Form Details");
			$FO=$FORM->output;
			
			$formType = ($form["FormType"] == "sub" ? "Subscription" : "Unsubscription");

			if($SubAction == "")
			{
				$FO = "Complete the form below to create a new $formType form.<br>Click on the \"Continue to Step 3\" button to continue." . $FO;
				$OUTPUT.=MakeBox("Create Form (Step 2 of 3)", $FO);
			}
			else
			{
				$FO = "Complete the form below to update the selected form.<br>Click on the \"Continue to Step 2\" button to continue." . $FO;
				$OUTPUT.=MakeBox("Edit Form (Step 1 of 2)", $FO);
			}

			$OUTPUT .= '

				<script language="JavaScript">

					function PreparePreview()
					{
						TemplateID = document.getElementById("TemplateID").options[document.getElementById("TemplateID").selectedIndex].value;
						window.open("' . MakeAdminLink("forms?Action=PreviewTemplate") . '&TemplateID=" + TemplateID , "pp");
					}

					function CheckForm()
					{
						var f = document.forms[0];

						if(f.FormName.value == "")
						{
							alert("Please enter a name for this form.");
							f.FormName.focus();
							return false;
						}

						var numLists = 0;
			';

			for($i = 5; $i < $e+5; $i++)
			{
				$OUTPUT .= '

					if(f.elements[' . $i . '].checked)
						numLists++;

				';
			}

			$OUTPUT .= '

						if(numLists == 0)
						{
							alert("Please choose at least one mailing list for this subscription form.");
							return false;
						}

						return true;
					}
				
				</script>
			';
			$DontDo=1;
		}
	}


	if($Action=="ResponseOptions"){
		$form=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID' ORDER BY FormName ASC"));
		if($SubSave){

			mysql_query("DELETE FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID'");
			
			foreach($Responses as $Name=>$Val){
				mysql_query("INSERT INTO " . $TABLEPREFIX . "form_responses SET ResponseName='$Name', FormID='$FormID', ResponseData='$Val'");
			}
		
			$OUTPUT .= MakeSuccessBox("Form Saved Successfully", "Your form has been saved successfully.", MakeAdminLink("forms"), MakeAdminLink("forms?Action=GenerateCode&FormID=$FormID"), "Get HTML");

		}else{

			$req = "<span class=req>*</span> ";
			$extraChecks = "";

			switch($form["FormType"]){
				case "sub":
					$responsee=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ConfirmEmail'"));
					$responsep=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ConfirmPage'"));

					if($form["RequireConfirm"]==1)
					{
						if(!$responsee["ResponseData"])
						{
							$responsee["ResponseData"]="Hi,\r\nPlease click on the link below to confirm your subscription of %EMAIL% to the following mailing lists:\r\n\r\n%LISTS%\r\n\r\n%CONFIRMLINK%";
						}
						
						if(!$responsep["ResponseData"])
						{
							$responsep["ResponseData"]='<html><title>Subscription Confirmation</title></head><body><font face=Verdana size=2>Please check your email to complete your subscription...</font></body></html>';
						}
						
						$FORM_ITEMS[$req . "Confirmation Email"]="textarea|Responses[ConfirmEmail]:64:5:".str_replace(":",'$$COLON$$',$responsee["ResponseData"]);
						$HELP_ITEMS["Responses[ConfirmEmail]"]["Title"] = "Confirmation Email";
						$HELP_ITEMS["Responses[ConfirmEmail]"]["Content"] = "Enter the content that should be sent to this user as the confirmation email.";

						$FORM_ITEMS[$req . "Confirmation Page"]="textarea|Responses[ConfirmPage]:64:5:".str_replace(":",'$$COLON$$',$responsep["ResponseData"]);	
						$HELP_ITEMS["Responses[ConfirmPage]"]["Title"] = "Confirmation Page";
						$HELP_ITEMS["Responses[ConfirmPage]"]["Content"] = "Enter the content that should appear on the confirmation page";

						$responseCURL= str_replace(":", "&#58;", @mysql_result(@mysql_query("SELECT ResponseData FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ConfirmURL'"), 0, 0));

						if($responseCURL == "")
							$responseCURL = "http&#58;//";

						$FORM_ITEMS[$req . "<b><i>OR</i></b> Confirmation Page URL"]="textfield|Responses[ConfirmURL]:1000:62:" . $responseCURL;
						$HELP_ITEMS["Responses[ConfirmURL]"]["Title"] = "Confirmation URL";
						$HELP_ITEMS["Responses[ConfirmURL]"]["Content"] = "If you have already uploaded your confirmation page as a HTML file, enter the URL of that file and your subscribers will be taken to this page instead.";

					}	

					$responsee=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ThanksEmail'"));
					
					$responsep=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ThanksPage'"));
					
					if($form["SendThankyou"]==1)
					{
						if(!$responsee["ResponseData"])
						{
							$responsee["ResponseData"]="Your subscription to our mailing list is now complete. Thank you!";
						}

						$FORM_ITEMS[-3]="spacer|&nbsp;";
						
						$FORM_ITEMS[$req . "Thankyou Email"]="textarea|Responses[ThanksEmail]:64:5:".str_replace(":",'$$COLON$$',$responsee["ResponseData"]);
						$HELP_ITEMS["Responses[ThanksEmail]"]["Title"] = "Thankyou Email";
						$HELP_ITEMS["Responses[ThanksEmail]"]["Content"] = "Enter the content that should be sent to this user as the thankyou email.";
					}	
					
					if(!$responsep["ResponseData"])
					{
						$responsep["ResponseData"]='<html><title>Thanks for Subscribing</title></head><body><font face=Verdana size=2>Thank you for subscribing to our mailing list!</font></body></html>';
					}
					
					$FORM_ITEMS[$req . "Thankyou Page"]="textarea|Responses[ThanksPage]:64:5:".str_replace(":",'$$COLON$$',$responsep["ResponseData"]);
					$HELP_ITEMS["Responses[ThanksPage]"]["Title"] = "Thankyou Page";
					$HELP_ITEMS["Responses[ThanksPage]"]["Content"] = "Enter the content that should appear on the thankyou page."; 

					$responseTURL= str_replace(":", "&#58;", @mysql_result(@mysql_query("SELECT ResponseData FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ThanksURL'"), 0, 0));

					if($responseTURL == "")
						$responseTURL = "http&#58;//";

					$FORM_ITEMS[$req . "<b><i>OR</i></b> Thankyou Page URL"]="textfield|Responses[ThanksURL]:1000:62:" . $responseTURL;
					$HELP_ITEMS["Responses[ThanksURL]"]["Title"] = "Thankyou Page URL";
					$HELP_ITEMS["Responses[ThanksURL]"]["Content"] = "If you have already uploaded your thankyou page as a HTML file, enter the URL of that file and your subscribers will be taken to this page instead.";
					
				break;
				
				case "unsub":
					
					$responsee=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ConfirmEmail'"));
					
					$responsep=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ConfirmPage'"));
					
					if($form["RequireConfirm"]==1)
					{
						if(!$responsee["ResponseData"])
						{
							$responsee["ResponseData"]="Hi,\r\nPlease click on the link below to confirm your unsubscription:\r\n\r\n%CONFIRMLINK%";
						}
						
						if(!$responsep["ResponseData"])
						{
							$responsep["ResponseData"]='<html><title>Unsubscription Confirmation</title></head><body><font face=Verdana size=2>Please check your email to confirm your unsubscription...</font></body></html>';
						}
						
						$FORM_ITEMS[$req . "Confirmation Email"]="textarea|Responses[ConfirmEmail]:64:5:".str_replace(":",'$$COLON$$',$responsee["ResponseData"]);
						$HELP_ITEMS["Responses[ConfirmEmail]"]["Title"] = "Confirmation Email";
						$HELP_ITEMS["Responses[ConfirmEmail]"]["Content"] = "Enter the content that should be sent to this user as the confirmation email";
						
						$FORM_ITEMS[$req . "Confirmation Page"]="textarea|Responses[ConfirmPage]:64:5:".str_replace(":",'$$COLON$$',$responsep["ResponseData"]);	
						$HELP_ITEMS["Responses[ConfirmPage]"]["Title"] = "Confirmation Page";
						$HELP_ITEMS["Responses[ConfirmPage]"]["Content"] = "Enter the content that should appear on the confirmation page."; 

						$responseCURL= str_replace(":", "&#58;", @mysql_result(@mysql_query("SELECT ResponseData FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ConfirmURL'"), 0, 0));

						if($responseCURL == "")
							$responseCURL = "http&#58;//";

						$FORM_ITEMS[$req . "<b><i>OR</i></b> Confirmation Page URL"]="textfield|Responses[ConfirmURL]:1000:62:" . $responseCURL;
						$HELP_ITEMS["Responses[ConfirmURL]"]["Title"] = "Confirmation URL";
						$HELP_ITEMS["Responses[ConfirmURL]"]["Content"] = "If you have already uploaded your confirmation page as a HTML file, enter the URL of that file and your subscribers will be taken to this page instead.";
					}

					$responsee=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ThanksEmail'"));
					
					$responsep=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ThanksPage'"));
					
					if($form["SendThankyou"]==1)
					{
						$FORM_ITEMS[-3]="spacer|&nbsp;";

						if(!$responsee["ResponseData"])
						{
							$responsee["ResponseData"]="Hi,\r\nYour unsubscription is now complete. It's a shame to see you go!";
						}

						$FORM_ITEMS[$req . "Thankyou Email"]="textarea|Responses[ThanksEmail]:64:5:".str_replace(":",'$$COLON$$',$responsee["ResponseData"]);
						$HELP_ITEMS["Responses[ThanksEmail]"]["Title"] = "Thankyou Email";
						$HELP_ITEMS["Responses[ThanksEmail]"]["Content"] = "Enter the content that should be sent to this user as the thankyou email"; 
					}
					
					if(!$responsep["ResponseData"])
					{
						$responsep["ResponseData"]='<html><title>Unsubscription Confirmed</title></head><body><font face=Verdana size=2>You have been successfully removed from our mailing list.</font></body></html>';
					}
					
					$FORM_ITEMS[$req . "Thankyou Page"]="textarea|Responses[ThanksPage]:64:5:".str_replace(":",'$$COLON$$',$responsep["ResponseData"]);
					$HELP_ITEMS["Responses[ThanksPage]"]["Title"] = "Thankyou Page";
					$HELP_ITEMS["Responses[ThanksPage]"]["Content"] = "Enter the content that should appear on the thankyou page";

					$responseTURL= str_replace(":", "&#58;", @mysql_result(@mysql_query("SELECT ResponseData FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ThanksURL'"), 0, 0));

					if($responseTURL == "")
						$responseTURL = "http&#58;//";

					$FORM_ITEMS[$req . "<b><i>OR</i></b> Thankyou Page URL"]="textfield|Responses[ThanksURL]:1000:62:" . $responseTURL;
					$HELP_ITEMS["Responses[ThanksURL]"]["Title"] = "Thankyou Page URL";
					$HELP_ITEMS["Responses[ThanksURL]"]["Content"] = "If you have already uploaded your thankyou page as a HTML file, enter the URL of that file and your subscribers will be taken to this page instead.";

				break;
			}
			
			$responsep=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ErrorPage'"));
			
			if(!$responsep["ResponseData"])
			{
				$responsep["ResponseData"]='<html><head><title>Some Errors Occured</title></head><body><font face=Verdana size=2>The following errors have occured: %ERRORLIST%' . "\r\n" . '<a href="javascript:history.go(-1)">Try Again...</a></font></body></html>';
			}

			$FORM_ITEMS[-4]="spacer|&nbsp;";

			$FORM_ITEMS[$req . "Error Page"]="textarea|Responses[ErrorPage]:64:4:".str_replace(":",'$$COLON$$',$responsep["ResponseData"]);
			$HELP_ITEMS["Responses[ErrorPage]"]["Title"] = "Error Page";
			$HELP_ITEMS["Responses[ErrorPage]"]["Content"] = "Enter the content that should appear on the error page.";

			$responseEURL= str_replace(":", "&#58;", @mysql_result(@mysql_query("SELECT ResponseData FROM " . $TABLEPREFIX . "form_responses WHERE FormID='$FormID' && ResponseName='ErrorURL'"), 0, 0));

			if($responseEURL == "")
				$responseEURL = "http&#58;//";

			$FORM_ITEMS[$req . "<b><i>OR</i></b> Error Page URL"]="textfield|Responses[ErrorURL]:1000:62:" . $responseEURL;
			$HELP_ITEMS["Responses[ErrorURL]"]["Title"] = "Error Page URL";
			$HELP_ITEMS["Responses[ErrorURL]"]["Content"] = "If you have already uploaded your error page as a HTML file, enter the URL of that file and your subscribers will be taken to this page instead.";

			$FORM_ITEMS[-5]="spacer|&nbsp;";

			$FORM_ITEMS["-1000"]="submit|Save Changes:1-forms";
			//make the form
			$FORM=new AdminForm;
			$FORM->title="View Banned";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("forms?Action=ResponseOptions&SubSave=Yes&FormID=$FormID");
			$FORM->MakeForm("New Form Details");

			if($SubAction == "")
			{
				$FORM->output = "Complete the form below to create a new subscription form.<br>Click on the \"Save Form\" button to continue." . $FORM->output;
				$OUTPUT.=MakeBox("Create Form (Step 3 of 3)",$FORM->output);
			}
			else
			{
				$FORM->output = "Complete the form below to update this form.<br>Click on the \"Save Form\" button to continue." . $FORM->output;
				$OUTPUT.=MakeBox("Edit Form (Step 2 of 2)",$FORM->output);
			}

			$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{
						return true;
					}
				
				</script>
			';
		
		}

	$DontDo=1;
	}

	if(!$DontDo)
	{

		if($SubAction=="DeleteForm")
		{
			mysql_query("DELETE FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID'");
		}

		$FormTypes["sub"]="Subscription Form";
		$FormTypes["unsub"]="Unsubscription Form";

		if($CURRENTADMIN["Manager"] == 1)
		{
			$forms=mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms ORDER BY FormName ASC");
		}
		else
		{
			$forms=mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FormName ASC");
		}

		if(mysql_num_rows($forms) > 0)
		{	
			//existing forms!
			$CF='
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
							Form Name
						</td>
						<td class="headbold bevel5" width=20%>
							Form Type
						</td>
						<td class="headbold bevel5" width=16%>
							Date Created
						</td>
						<td class="headbold bevel5" width=20%>
							Action
						</td>
					</tr>
			';

			while($f=mysql_fetch_array($forms))
			{
				$FormType = ($f["FormType"] == "sub" ? "Subscription" : "Unsubscription");
				$CF .= '

					<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
						<td height=20 class="body bevel4" width=4% class="body">
							<img src="' . $ROOTURL . 'admin/images/form.gif" width="16" height="13">
						</td>
						<td class="body bevel4" width=40%>' . $f["FormName"] . '</td>
						<td class="body bevel4" width=20%>' . $FormType . '</td>
						<td class="body bevel4" width=16%>' . DisplayDate($f["DateCreated"]) . '</td>
						<td class="body bevel4" width=20%>';

						$CF .= MakeLink("forms?Action=Preview&FormID=" . $f["FormID"], "View", 0, 0, "_blank") . "&nbsp;&nbsp;&nbsp;";
						$CF .= MakeLink("forms?Action=GenerateCode&FormID=" . $f["FormID"], "Get HTML") . "&nbsp;&nbsp;&nbsp;";
						$CF .= MakeLink("forms?Action=EditForm&SubAction=Edit&FormID=".$f["FormID"], "Edit") . "&nbsp;&nbsp;&nbsp;";
						$CF .= MakeLink("forms?SubAction=DeleteForm&SelectedType=$SelectedType&FormID=".$f["FormID"], "Delete",1);

				$CF .= '		
						</td>
					</tr>
				';
			}

			$CF .= '</table>';

			$CF = 'Use the form below to create, view, edit or delete subscription/unsubscription forms.<br><br><input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("forms?Action=Add") . '\'" value="Create Form"><br><br>' . $CF;
		}
		else
		{
			$CF = 'No forms have been created. Click on the \'Create Form\' button below to create one.<br><br><input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("forms?Action=Add") . '\'" value="Create Form"><br><br>';
		}

		$OUTPUT.=MakeBox("Manage Subscription Forms", $CF);
	}

?>