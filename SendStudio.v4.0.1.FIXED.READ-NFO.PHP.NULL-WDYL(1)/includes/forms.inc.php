<?

function FormCode($FormID){

	GLOBAL $TABLEPREFIX;
	
	$form = @mysql_fetch_array(@mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID'"));
	$tID = @$form["TemplateID"];

	return FormByTemplate($tID, $FormID);
}

function FormByTemplate($TemplateID, $FormID)
{
	GLOBAL $ROOTURL;
	GLOBAL $TABLEPREFIX;

	$Code = "";
	$Format = array();
	$form = @mysql_fetch_array(@mysql_query("SELECT * FROM " . $TABLEPREFIX . "forms WHERE FormID='$FormID'"));
	$numMailingLists = @mysql_result(@mysql_query("SELECT COUNT(*) FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'"), 0, 0);

	switch($TemplateID)
	{
		case 0:
		{
			$Code.='
			<table cellspacing="0" cellpadding="0">
			  <tr>
				<form action="'.$ROOTURL.'users/form.php?FormID='.$FormID.'" method="post" name="frmSS" onSubmit="return CheckSS()">
				<td height="20" bgcolor="#FFFFFF" colspan="2">
				  <p style="margin: 7"><font size="2" color="#000000" face="Verdana"><b>&nbsp;' . $form["FormName"] . '</b></font></p>
				</td>
			  </tr>
			  <tr>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Your Email Address:</font>
			   </td>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="text" style="font-family: Verdana; font-size: 8pt" name="Email" size="30"></font>
			   </td>
			  </tr>';

			if($numMailingLists > 1)
			{
				$Code .= '

			  <tr>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
					</font>
			   </td>
				<td bgcolor="#FFFFFF"valign="top">
					<p style="margin: 7">
				';
			}
				
				//general fields!
				$numLists = 0;
				$arrFormItems = array();

				switch($form["FormType"]){
					case "sub":
					{
						//select lists?
						if($form["SelectLists"]==1){
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));

								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}

							if($numMailingLists > 1)
							{
								$Code .= '
								</font>
								   </td>
								  </tr>
								';
							}
						}
						
						$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$l["ListID"]."'"));
								if($list["Formats"]==3 OR $list["Formats"]==2){
									$Format["HTML"]=1;
								}
								if($list["Formats"]==1){
									$Format["Text"]=1;
								}
							}
						//formats	
						if(sizeof($Format)>1)
						{
			$Code .= '
			  <tr>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Preferred Format:</font>
			   </td>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select name="Format" style="font-family: Verdana; font-size: 8pt">
							<option value="0">Text</option>
							<option SELECTED value="1">HTML</option>
						</select>
				  </font>
			   </td>
			  </tr>';
						}
						else
						{
							if(@$Format["HTML"]==1)
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="1">';
							}
							else
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="0">';			
							}
						}
						
						//form code!
						$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						$size = $min = $max = $Width = $Height = 0;
						$i = $numLists + 2;
						$r = "";
						
						//other fields!
							$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='".$form["AdminID"]."'");
									while($lf=mysql_fetch_array($list_fields)){
										$i++;
													switch($lf["FieldType"])
													{
														case "shorttext":
														{
															list($size,$min,$max)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 0); 
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input style="font-family: Verdana; font-size: 8pt" value="'.$lf["DefaultValue"].'" name="Fields['.$lf["FieldID"].']" type="text" size="'.$size.'" maxlength="'.$max.'">
					</font>
			   </td>
			  </tr>';
															
															break;
														}
									
														case "longtext":
														{
															list($Width,$Height)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 1);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<textarea style="font-family: Verdana; font-size: 8pt" cols="'.$Width.'" rows="'.$Height.'" name="Fields['.$lf["FieldID"].']">'.$lf["DefaultValue"].'</textarea>
					</font>
			   </td>
			  </tr>';
				
															break;
														}
									
														case "checkbox":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 2);
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">&nbsp;&nbsp;' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input type="checkbox" name="Fields['.$lf["FieldID"].']" value="CHECKED" '.$lf["DefaultValue"].'> ' . $lf["AllValues"] . '
					</font>
			   </td>
			  </tr>';

															break;
														}					
														case "dropdown":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 3);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select style="font-family: Verdana; font-size: 8pt" name="Fields['.$lf["FieldID"].']">';

															$options=explode(";",$lf["AllValues"]);

															foreach($options as $opt)
															{
																if($opt)
																{
																	list($val,$name)=explode("->",$opt);
																	
																	if($val==$lf["DefaultValue"])
																	{
																		$sel="SELECTED";
																	}
																	else
																	{
																		$sel="";
																	}
																	$Code.='<option value="'.$val.'" '.$sel.'>'.$name;
																}
															}

			$Code .= '
					</font>
			   </td>
			  </tr>';

															break;
														}
													}
												
									}
							}

			$Code.='
			  <tr>
				<td bgcolor="#FFFFFF" valign="top">
			   </td>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to subscribe to.");
						return false;
					}
					';

					// Add the code to check the required form fields
					for($i = 0; $i < sizeof($arrFormItems); $i++)
					{
						switch($arrFormItems[$i][2])
						{
							case 0: // Single line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 1: // Multi line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 2: // Checkbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].checked == false)
									{
										alert("Please tick the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 3: // Dropdown list
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].selectedIndex == -1)
									{
										alert("Please choose a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
						}
					}

			$Code .= '
					
					return true;
				}

			</script>

			';

					break;
				}
					
					case "unsub":
						//select lists?
						if($form["SelectLists"]==1)
						{
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));

								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}
							$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						}

			$Code .= '
				</font>
				   </td>
				  </tr>
			  <tr>
				<td bgcolor="#FFFFFF" valign="top">
			   </td>
				<td bgcolor="#FFFFFF" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Unsubscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to unsubscribe from.");
						return false;
					}

					return true;
				}

			</script>';

					break;
				}

			break;
		}
		case 1:
		{
			$Code.='
			<table style="border: dotted 1px #000000" cellspacing="0" cellpadding="0">
			  <tr>
				<form action="'.$ROOTURL.'users/form.php?FormID='.$FormID.'" method="post" name="frmSS" onSubmit="return CheckSS()">
				<td height="20" bgcolor="#C8C8C8" colspan="2">
				  <p style="margin: 7"><font size="2" color="#000000" face="Verdana"><b>&nbsp;' . $form["FormName"] . '</b></font></p>
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
			';

			if($numMailingLists > 1)
			{
				$Code .= '
			  <tr>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
					</font>
			   </td>
				<td bgcolor="#ECECEC"valign="top">
					<p style="margin: 7">';
			}
				
				//general fields!
				$numLists = 0;
				$arrFormItems = array();

				switch($form["FormType"]){
					case "sub":
					{
						//select lists?
						if($form["SelectLists"]==1){
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));

								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES"';
								}
							}
						}

						//Email
						if($numMailingLists > 1)
						{
							$Code .= '
								</font>
								   </td>
								  </tr>
							';
						}
						
						$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$l["ListID"]."'"));
								if($list["Formats"]==3 OR $list["Formats"]==2){
									$Format["HTML"]=1;
								}
								if($list["Formats"]==1){
									$Format["Text"]=1;
								}
							}
						//formats	
						if(sizeof($Format)>1)
						{
			$Code .= '
			  <tr>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Preferred Format:</font>
			   </td>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select name="Format" style="font-family: Verdana; font-size: 8pt">
							<option value="0">Text</option>
							<option SELECTED value="1">HTML</option>
						</select>
				  </font>
			   </td>
			  </tr>';
						}
						else
						{
							if(@$Format["HTML"]==1)
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="1">';
							}
							else
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="0">';			
							}
						}
						
						//form code!
						$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						$size = $min = $max = $Width = $Height = 0;
						$i = $numLists + 2;
						$r = "";
						
						//other fields!
							$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='".$form["AdminID"]."'");
									while($lf=mysql_fetch_array($list_fields)){
										$i++;
													switch($lf["FieldType"])
													{
														case "shorttext":
														{
															list($size,$min,$max)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 0); 
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input style="font-family: Verdana; font-size: 8pt" value="'.$lf["DefaultValue"].'" name="Fields['.$lf["FieldID"].']" type="text" size="'.$size.'" maxlength="'.$max.'">
					</font>
			   </td>
			  </tr>';
															
															break;
														}
									
														case "longtext":
														{
															list($Width,$Height)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 1);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<textarea style="font-family: Verdana; font-size: 8pt" cols="'.$Width.'" rows="'.$Height.'" name="Fields['.$lf["FieldID"].']">'.$lf["DefaultValue"].'</textarea>
					</font>
			   </td>
			  </tr>';
				
															break;
														}
									
														case "checkbox":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 2);
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">&nbsp;&nbsp;' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input type="checkbox" name="Fields['.$lf["FieldID"].']" value="CHECKED" '.$lf["DefaultValue"].'> ' . $lf["AllValues"] . '
					</font>
			   </td>
			  </tr>';

															break;
														}					
														case "dropdown":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 3);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select style="font-family: Verdana; font-size: 8pt" name="Fields['.$lf["FieldID"].']">';

															$options=explode(";",$lf["AllValues"]);

															foreach($options as $opt)
															{
																if($opt)
																{
																	list($val,$name)=explode("->",$opt);
																	
																	if($val==$lf["DefaultValue"])
																	{
																		$sel="SELECTED";
																	}
																	else
																	{
																		$sel="";
																	}
																	$Code.='<option value="'.$val.'" '.$sel.'>'.$name;
																}
															}

			$Code .= '
					</font>
			   </td>
			  </tr>';

															break;
														}
													}
												
									}
							}

			$Code.='
			  <tr>
				<td bgcolor="#ECECEC" valign="top">
			   </td>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to subscribe to.");
						return false;
					}
					';

					// Add the code to check the required form fields
					for($i = 0; $i < sizeof($arrFormItems); $i++)
					{
						switch($arrFormItems[$i][2])
						{
							case 0: // Single line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 1: // Multi line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 2: // Checkbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].checked == false)
									{
										alert("Please tick the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 3: // Dropdown list
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].selectedIndex == -1)
									{
										alert("Please choose a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
						}
					}

			$Code .= '
					
					return true;
				}

			</script>

			';

					break;
				}
					
					case "unsub":
						//select lists?
						if($form["SelectLists"]==1)
						{
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));
								
								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}
							$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						}

			$Code .= '
				</font>
				   </td>
				  </tr>
			  <tr>
				<td bgcolor="#ECECEC" valign="top">
			   </td>
				<td bgcolor="#ECECEC" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Unsubscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to unsubscribe from.");
						return false;
					}

					return true;
				}

			</script>';

					break;
				}
			break;
		}
		case 2:
		{
			$Code.='
			<table style="border: dotted 1px #034089" cellspacing="0" cellpadding="0">
			  <tr>
				<form action="'.$ROOTURL.'users/form.php?FormID='.$FormID.'" method="post" name="frmSS" onSubmit="return CheckSS()">
				<td height="20" bgcolor="#034089" colspan="2">
				  <p style="margin: 7"><font size="2" color="#FFFFFF" face="Verdana"><b>&nbsp;' . $form["FormName"] . '</b></font></p>
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
			';

			if($numMailingLists > 1)
			{
				$Code .= '
				  <tr>
					<td bgcolor="#DDE6F7" valign="top">
						<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
						</font>
				   </td>
					<td bgcolor="#DDE6F7"valign="top">
						<p style="margin: 7">
				';
			}
				
				//general fields!
				$numLists = 0;
				$arrFormItems = array();

				switch($form["FormType"]){
					case "sub":
					{
						//select lists?
						if($form["SelectLists"]==1){
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));

								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}
						}

						//Email
						if($numMailingLists > 1)
						{
							$Code .= '
								</font>
								   </td>
								  </tr>
							';
						}
						
						$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$l["ListID"]."'"));
								if($list["Formats"]==3 OR $list["Formats"]==2){
									$Format["HTML"]=1;
								}
								if($list["Formats"]==1){
									$Format["Text"]=1;
								}
							}
						//formats	
						if(sizeof($Format)>1)
						{
			$Code .= '
			  <tr>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Preferred Format:</font>
			   </td>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select name="Format" style="font-family: Verdana; font-size: 8pt">
							<option value="0">Text</option>
							<option SELECTED value="1">HTML</option>
						</select>
				  </font>
			   </td>
			  </tr>';
						}
						else
						{
							if(@$Format["HTML"]==1)
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="1">';
							}
							else
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="0">';			
							}
						}
						
						//form code!
						$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						$size = $min = $max = $Width = $Height = 0;
						$i = $numLists + 2;
						$r = "";
						
						//other fields!
							$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='".$form["AdminID"]."'");
									while($lf=mysql_fetch_array($list_fields)){
										$i++;
													switch($lf["FieldType"])
													{
														case "shorttext":
														{
															list($size,$min,$max)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 0); 
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input style="font-family: Verdana; font-size: 8pt" value="'.$lf["DefaultValue"].'" name="Fields['.$lf["FieldID"].']" type="text" size="'.$size.'" maxlength="'.$max.'">
					</font>
			   </td>
			  </tr>';
															
															break;
														}
									
														case "longtext":
														{
															list($Width,$Height)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 1);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<textarea style="font-family: Verdana; font-size: 8pt" cols="'.$Width.'" rows="'.$Height.'" name="Fields['.$lf["FieldID"].']">'.$lf["DefaultValue"].'</textarea>
					</font>
			   </td>
			  </tr>';
				
															break;
														}
									
														case "checkbox":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 2);
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">&nbsp;&nbsp;' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input type="checkbox" name="Fields['.$lf["FieldID"].']" value="CHECKED" '.$lf["DefaultValue"].'> ' . $lf["AllValues"] . '
					</font>
			   </td>
			  </tr>';

															break;
														}					
														case "dropdown":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 3);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select style="font-family: Verdana; font-size: 8pt" name="Fields['.$lf["FieldID"].']">';

															$options=explode(";",$lf["AllValues"]);

															foreach($options as $opt)
															{
																if($opt)
																{
																	list($val,$name)=explode("->",$opt);
																	
																	if($val==$lf["DefaultValue"])
																	{
																		$sel="SELECTED";
																	}
																	else
																	{
																		$sel="";
																	}
																	$Code.='<option value="'.$val.'" '.$sel.'>'.$name;
																}
															}

			$Code .= '
					</font>
			   </td>
			  </tr>';

															break;
														}
													}
												
									}
							}

			$Code.='
			  <tr>
				<td bgcolor="#DDE6F7" valign="top">
			   </td>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to subscribe to.");
						return false;
					}
					';

					// Add the code to check the required form fields
					for($i = 0; $i < sizeof($arrFormItems); $i++)
					{
						switch($arrFormItems[$i][2])
						{
							case 0: // Single line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 1: // Multi line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 2: // Checkbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].checked == false)
									{
										alert("Please tick the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 3: // Dropdown list
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].selectedIndex == -1)
									{
										alert("Please choose a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
						}
					}

			$Code .= '
					
					return true;
				}

			</script>

			';

					break;
				}
					
					case "unsub":
						//select lists?
						if($form["SelectLists"]==1)
						{
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));

								if($numMailingLists > 1)
								{								
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}
							$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						}

			$Code .= '
				</font>
				   </td>
				  </tr>
			  <tr>
				<td bgcolor="#DDE6F7" valign="top">
			   </td>
				<td bgcolor="#DDE6F7" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Unsubscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to unsubscribe from.");
						return false;
					}

					return true;
				}

			</script>';

					break;
				}

			break;
		}
		case 3:
		{
			$Code.='
			<table style="border: solid 1px #FF9900" cellspacing="0" cellpadding="0">
			  <tr>
				<form action="'.$ROOTURL.'users/form.php?FormID='.$FormID.'" method="post" name="frmSS" onSubmit="return CheckSS()">
				<td height="20" bgcolor="#FF9900" colspan="2">
				  <p style="margin: 7"><font size="2" color="#FFFFFF" face="Verdana"><b>&nbsp;' . $form["FormName"] . '</b></font></p>
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
			';

			if($numMailingLists > 1)
			{
				$Code .= '
				  <tr>
					<td bgcolor="#FFFFE8" valign="top">
						<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
						</font>
				   </td>
					<td bgcolor="#FFFFE8"valign="top">
						<p style="margin: 7">
				';
			}
				
				//general fields!
				$numLists = 0;
				$arrFormItems = array();

				switch($form["FormType"]){
					case "sub":
					{
						//select lists?
						if($form["SelectLists"]==1){
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));

								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}
						}

						//Email
						if($numMailingLists > 1)
						{
							$Code .= '
								</font>
								   </td>
								  </tr>
							';
						}
						
						$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$l["ListID"]."'"));
								if($list["Formats"]==3 OR $list["Formats"]==2){
									$Format["HTML"]=1;
								}
								if($list["Formats"]==1){
									$Format["Text"]=1;
								}
							}
						//formats	
						if(sizeof($Format)>1)
						{
			$Code .= '
			  <tr>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Preferred Format:</font>
			   </td>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select name="Format" style="font-family: Verdana; font-size: 8pt">
							<option value="0">Text</option>
							<option SELECTED value="1">HTML</option>
						</select>
				  </font>
			   </td>
			  </tr>';
						}
						else
						{
							if(@$Format["HTML"]==1)
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="1">';
							}
							else
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="0">';			
							}
						}
						
						//form code!
						$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						$size = $min = $max = $Width = $Height = 0;
						$i = $numLists + 2;
						$r = "";
						
						//other fields!
							$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='".$form["AdminID"]."'");
									while($lf=mysql_fetch_array($list_fields)){
										$i++;
													switch($lf["FieldType"])
													{
														case "shorttext":
														{
															list($size,$min,$max)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 0); 
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input style="font-family: Verdana; font-size: 8pt" value="'.$lf["DefaultValue"].'" name="Fields['.$lf["FieldID"].']" type="text" size="'.$size.'" maxlength="'.$max.'">
					</font>
			   </td>
			  </tr>';
															
															break;
														}
									
														case "longtext":
														{
															list($Width,$Height)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 1);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<textarea style="font-family: Verdana; font-size: 8pt" cols="'.$Width.'" rows="'.$Height.'" name="Fields['.$lf["FieldID"].']">'.$lf["DefaultValue"].'</textarea>
					</font>
			   </td>
			  </tr>';
				
															break;
														}
									
														case "checkbox":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 2);
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">&nbsp;&nbsp;' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input type="checkbox" name="Fields['.$lf["FieldID"].']" value="CHECKED" '.$lf["DefaultValue"].'> ' . $lf["AllValues"] . '
					</font>
			   </td>
			  </tr>';

															break;
														}					
														case "dropdown":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 3);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select style="font-family: Verdana; font-size: 8pt" name="Fields['.$lf["FieldID"].']">';

															$options=explode(";",$lf["AllValues"]);

															foreach($options as $opt)
															{
																if($opt)
																{
																	list($val,$name)=explode("->",$opt);
																	
																	if($val==$lf["DefaultValue"])
																	{
																		$sel="SELECTED";
																	}
																	else
																	{
																		$sel="";
																	}
																	$Code.='<option value="'.$val.'" '.$sel.'>'.$name;
																}
															}

			$Code .= '
					</font>
			   </td>
			  </tr>';

															break;
														}
													}
												
									}
							}

			$Code.='
			  <tr>
				<td bgcolor="#FFFFE8" valign="top">
			   </td>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to subscribe to.");
						return false;
					}
					';

					// Add the code to check the required form fields
					for($i = 0; $i < sizeof($arrFormItems); $i++)
					{
						switch($arrFormItems[$i][2])
						{
							case 0: // Single line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 1: // Multi line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 2: // Checkbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].checked == false)
									{
										alert("Please tick the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 3: // Dropdown list
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].selectedIndex == -1)
									{
										alert("Please choose a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
						}
					}

			$Code .= '
					
					return true;
				}

			</script>

			';

					break;
				}
					
					case "unsub":
						//select lists?
						if($form["SelectLists"]==1)
						{
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));
								
								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}
							$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						}

			$Code .= '
				</font>
				   </td>
				  </tr>
			  <tr>
				<td bgcolor="#FFFFE8" valign="top">
			   </td>
				<td bgcolor="#FFFFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Unsubscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to unsubscribe from.");
						return false;
					}

					return true;
				}

			</script>';

					break;
				}

			break;
		}
		case 4:
		{
			$Code.='
			<table style="border: solid 1px #009900" cellspacing="0" cellpadding="0">
			  <tr>
				<form action="'.$ROOTURL.'users/form.php?FormID='.$FormID.'" method="post" name="frmSS" onSubmit="return CheckSS()">
				<td height="20" bgcolor="#009900" colspan="2">
				  <p style="margin: 7"><font size="2" color="#FFFFFF" face="Verdana"><b>&nbsp;' . $form["FormName"] . '</b></font></p>
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
			';

			if($numMailingLists > 1)
			{
				$Code .= '
				  <tr>
					<td bgcolor="#E8FFE8" valign="top">
						<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
						</font>
				   </td>
					<td bgcolor="#E8FFE8"valign="top">
						<p style="margin: 7">
				';
			}
				
				//general fields!
				$numLists = 0;
				$arrFormItems = array();

				switch($form["FormType"]){
					case "sub":
					{
						//select lists?
						if($form["SelectLists"]==1){
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));

								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}
						}

						//Email
						if($numMailingLists > 1)
						{
							$Code .= '
								</font>
								   </td>
								  </tr>
							';
						}
						
						$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$l["ListID"]."'"));
								if($list["Formats"]==3 OR $list["Formats"]==2){
									$Format["HTML"]=1;
								}
								if($list["Formats"]==1){
									$Format["Text"]=1;
								}
							}
						//formats	
						if(sizeof($Format)>1)
						{
			$Code .= '
			  <tr>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Preferred Format:</font>
			   </td>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select name="Format" style="font-family: Verdana; font-size: 8pt">
							<option value="0">Text</option>
							<option SELECTED value="1">HTML</option>
						</select>
				  </font>
			   </td>
			  </tr>';
						}
						else
						{
							if(@$Format["HTML"]==1)
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="1">';
							}
							else
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="0">';			
							}
						}
						
						//form code!
						$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						$size = $min = $max = $Width = $Height = 0;
						$i = $numLists + 2;
						$r = "";
						
						//other fields!
							$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='".$form["AdminID"]."'");
									while($lf=mysql_fetch_array($list_fields)){
										$i++;
													switch($lf["FieldType"])
													{
														case "shorttext":
														{
															list($size,$min,$max)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 0); 
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input style="font-family: Verdana; font-size: 8pt" value="'.$lf["DefaultValue"].'" name="Fields['.$lf["FieldID"].']" type="text" size="'.$size.'" maxlength="'.$max.'">
					</font>
			   </td>
			  </tr>';
															
															break;
														}
									
														case "longtext":
														{
															list($Width,$Height)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 1);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<textarea style="font-family: Verdana; font-size: 8pt" cols="'.$Width.'" rows="'.$Height.'" name="Fields['.$lf["FieldID"].']">'.$lf["DefaultValue"].'</textarea>
					</font>
			   </td>
			  </tr>';
				
															break;
														}
									
														case "checkbox":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 2);
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">&nbsp;&nbsp;' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input type="checkbox" name="Fields['.$lf["FieldID"].']" value="CHECKED" '.$lf["DefaultValue"].'> ' . $lf["AllValues"] . '
					</font>
			   </td>
			  </tr>';

															break;
														}					
														case "dropdown":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 3);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select style="font-family: Verdana; font-size: 8pt" name="Fields['.$lf["FieldID"].']">';

															$options=explode(";",$lf["AllValues"]);

															foreach($options as $opt)
															{
																if($opt)
																{
																	list($val,$name)=explode("->",$opt);
																	
																	if($val==$lf["DefaultValue"])
																	{
																		$sel="SELECTED";
																	}
																	else
																	{
																		$sel="";
																	}
																	$Code.='<option value="'.$val.'" '.$sel.'>'.$name;
																}
															}

			$Code .= '
					</font>
			   </td>
			  </tr>';

															break;
														}
													}
												
									}
							}

			$Code.='
			  <tr>
				<td bgcolor="#E8FFE8" valign="top">
			   </td>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to subscribe to.");
						return false;
					}
					';

					// Add the code to check the required form fields
					for($i = 0; $i < sizeof($arrFormItems); $i++)
					{
						switch($arrFormItems[$i][2])
						{
							case 0: // Single line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 1: // Multi line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 2: // Checkbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].checked == false)
									{
										alert("Please tick the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 3: // Dropdown list
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].selectedIndex == -1)
									{
										alert("Please choose a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
						}
					}

			$Code .= '
					
					return true;
				}

			</script>

			';

					break;
				}
					
					case "unsub":
						//select lists?
						if($form["SelectLists"]==1)
						{
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));
								
								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}
							$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						}

			$Code .= '
				</font>
				   </td>
				  </tr>
			  <tr>
				<td bgcolor="#E8FFE8" valign="top">
			   </td>
				<td bgcolor="#E8FFE8" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Unsubscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to unsubscribe from.");
						return false;
					}

					return true;
				}

			</script>';

					break;
				}

			break;
		}
		case 5:
		{
			$Code.='
			<table style="border: solid 1px #CC3300" cellspacing="0" cellpadding="0">
			  <tr>
				<form action="'.$ROOTURL.'users/form.php?FormID='.$FormID.'" method="post" name="frmSS" onSubmit="return CheckSS()">
				<td height="20" bgcolor="#CC3300" colspan="2">
				  <p style="margin: 7"><font size="2" color="#FFFFFF" face="Verdana"><b>&nbsp;' . $form["FormName"] . '</b></font></p>
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
			';

			if($numMailingLists > 1)
			{
				$Code .= '
				  <tr>
					<td bgcolor="#EBEBEB" valign="top">
						<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Mailing List(s):</p>
						</font>
				   </td>
					<td bgcolor="#EBEBEB"valign="top">
						<p style="margin: 7">
				';
			}
				
				//general fields!
				$numLists = 0;
				$arrFormItems = array();

				switch($form["FormType"]){
					case "sub":
					{
						//select lists?
						if($form["SelectLists"]==1){
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));

								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}
						}

						//Email
						if($numMailingLists > 1)
						{
							$Code .= '
								</font>
								   </td>
								  </tr>
							';
						}
						
						$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$l["ListID"]."'"));
								if($list["Formats"]==3 OR $list["Formats"]==2){
									$Format["HTML"]=1;
								}
								if($list["Formats"]==1){
									$Format["Text"]=1;
								}
							}
						//formats	
						if(sizeof($Format)>1)
						{
			$Code .= '
			  <tr>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana"><font color="red"><b>*</b></font> Preferred Format:</font>
			   </td>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select name="Format" style="font-family: Verdana; font-size: 8pt">
							<option value="0">Text</option>
							<option SELECTED value="1">HTML</option>
						</select>
				  </font>
			   </td>
			  </tr>';
						}
						else
						{
							if(@$Format["HTML"]==1)
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="1">';
							}
							else
							{
								$Code .= "\n" . '<input type="hidden" name="Format" value="0">';			
							}
						}
						
						//form code!
						$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						$size = $min = $max = $Width = $Height = 0;
						$i = $numLists + 2;
						$r = "";
						
						//other fields!
							$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							while($l=mysql_fetch_array($lists)){
								$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='".$form["AdminID"]."'");
									while($lf=mysql_fetch_array($list_fields)){
										$i++;
													switch($lf["FieldType"])
													{
														case "shorttext":
														{
															list($size,$min,$max)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 0); 
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input style="font-family: Verdana; font-size: 8pt" value="'.$lf["DefaultValue"].'" name="Fields['.$lf["FieldID"].']" type="text" size="'.$size.'" maxlength="'.$max.'">
					</font>
			   </td>
			  </tr>';
															
															break;
														}
									
														case "longtext":
														{
															list($Width,$Height)=explode(",",$lf["AllValues"]);

															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 1);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<textarea style="font-family: Verdana; font-size: 8pt" cols="'.$Width.'" rows="'.$Height.'" name="Fields['.$lf["FieldID"].']">'.$lf["DefaultValue"].'</textarea>
					</font>
			   </td>
			  </tr>';
				
															break;
														}
									
														case "checkbox":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 2);
															}
															else
																$r = '&nbsp;&nbsp;';

			$Code .= '

			  <tr>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">&nbsp;&nbsp;' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<input type="checkbox" name="Fields['.$lf["FieldID"].']" value="CHECKED" '.$lf["DefaultValue"].'> ' . $lf["AllValues"] . '
					</font>
			   </td>
			  </tr>';

															break;
														}					
														case "dropdown":
														{
															if($lf["Required"] == 1)
															{
																$r = '<font color="red"><b>*</b></font> ';
																$arrFormItems[] = array($lf["FieldName"], $i, 3);
															}
															else
																$r = '&nbsp;&nbsp;';
			$Code .= '

			  <tr>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">' . $r . $lf["FieldName"].':</font>
			   </td>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
						<select style="font-family: Verdana; font-size: 8pt" name="Fields['.$lf["FieldID"].']">';

															$options=explode(";",$lf["AllValues"]);

															foreach($options as $opt)
															{
																if($opt)
																{
																	list($val,$name)=explode("->",$opt);
																	
																	if($val==$lf["DefaultValue"])
																	{
																		$sel="SELECTED";
																	}
																	else
																	{
																		$sel="";
																	}
																	$Code.='<option value="'.$val.'" '.$sel.'>'.$name;
																}
															}

			$Code .= '
					</font>
			   </td>
			  </tr>';

															break;
														}
													}
												
									}
							}

			$Code.='
			  <tr>
				<td bgcolor="#EBEBEB" valign="top">
			   </td>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Subscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to subscribe to.");
						return false;
					}
					';

					// Add the code to check the required form fields
					for($i = 0; $i < sizeof($arrFormItems); $i++)
					{
						switch($arrFormItems[$i][2])
						{
							case 0: // Single line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 1: // Multi line textbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].value == "")
									{
										alert("Please enter a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 2: // Checkbox
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].checked == false)
									{
										alert("Please tick the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
							case 3: // Dropdown list
							{
								$Code .= '

									if(theFrm.elements[' . $arrFormItems[$i][1] . '].selectedIndex == -1)
									{
										alert("Please choose a value for the \'' . $arrFormItems[$i][0] . '\' field.");
										theFrm.elements[' . $arrFormItems[$i][1] . '].focus();
										theFrm.elements[' . $arrFormItems[$i][1] . '].select();
										return false;
									}
								';
								break;
							}
						}
					}

			$Code .= '
					
					return true;
				}

			</script>

			';

					break;
				}
					
					case "unsub":
						//select lists?
						if($form["SelectLists"]==1)
						{
							$form_lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "form_lists WHERE FormID='$FormID'");
							
							while($fl=mysql_fetch_array($form_lists))
							{
								$numLists++;
								$listinfo=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$fl["ListID"]."'"));
								
								if($numMailingLists > 1)
								{
									$Code .= '<input onClick="doCheckCount(this)" type="checkbox" name="SelectLists['.$fl["ListID"].']" value="YES" CHECKED><font size="1" face="Verdana">'.$listinfo["ListName"].'<br>';
								}
								else
								{
									$Code .= '<input type="hidden" name="SelectLists['.$fl["ListID"].']" value="YES">';
								}
							}
							$Code .= "\n\n" . '<input type="hidden" name="FormCode" value="' . $form["FormCode"] . '">';
						}

			$Code .= '
				</font>
				   </td>
				  </tr>
			  <tr>
				<td bgcolor="#EBEBEB" valign="top">
			   </td>
				<td bgcolor="#EBEBEB" valign="top">
					<p style="margin: 7"><font size="1" face="Verdana">
					<input type="submit" style="font-family: Verdana; font-size: 8pt" value="Unsubscribe"><br>&nbsp;</font>
			   </td>
			 </form>
			  </tr>
			</table>

			<script language="JavaScript">

				var numLists = ' . $numLists . ';

				function doCheckCount(ccObj)
				{
					if(ccObj.checked)
						numLists = numLists + 1;
					else
						numLists = numLists - 1;
				}

				function CheckSS()
				{
					theFrm = document.frmSS;

					hasDot = theFrm.Email.value.indexOf(".");
					hasAt = theFrm.Email.value.indexOf("@");

					if(hasDot + hasAt < 0)
					{
						alert("Please enter a valid email address.");
						theFrm.Email.focus();
						theFrm.Email.select();
						return false;
					}

					if(numLists == 0)
					{
						alert("Please choose a mailing list to unsubscribe from.");
						return false;
					}

					return true;
				}

			</script>';

					break;
				}

			break;
		}
	}

	return $Code;
}

?>