<?

$Save = @$_REQUEST["Save"];
$SubAction = @$_REQUEST["SubAction"];
$Action = @$_REQUEST["Action"];
$Delete = @$_REQUEST["Delete"];
$Edit = @$_REQUEST["Edit"];
$DontDo = @$_REQUEST["DontDo"];
$AllowFunction = @$_REQUEST["AllowFunction"];
$AllowList = @$_REQUEST["AllowList"];
$AdminName = @$_REQUEST["AdminName"];
$Password = @$_REQUEST["Password"];
$Email = @$_REQUEST["Email"];
$Status = @$_REQUEST["Status"];
$Manager = @$_REQUEST["Manager"];
$Root = @$_REQUEST["Root"];
$MaxLists = (int)@$_REQUEST["MaxLists"];

$NewUsername = @$_REQUEST["NewUsername"];
$NewPassword = @$_REQUEST["NewPassword"];
$Error = @$_REQUEST["Error"];
$OUTPUT = "";
$p = "";
$AddingNew = false;

if($Action == "Add")
{
	if(ss9024kwehbehb())
	{
		$req = "<span class=req>*</span> ";

		$FORM_ITEMS[$req . "Username"]="textfield|NewUsername:40:44:$NewUsername";
		$HELP_ITEMS["NewUsername"]["Title"] = "Username";
		$HELP_ITEMS["NewUsername"]["Content"] = "The username for this user to enter when logging in.";

		$FORM_ITEMS[$req . "Password"]="password|NewPassword:40:44:$NewPassword:0";
		$HELP_ITEMS["NewPassword"]["Title"] = "Password";
		$HELP_ITEMS["NewPassword"]["Content"] = "The password for this user to enter when logging in.";

		$FORM_ITEMS[-1]="submit|Continue to Step 2:1-admins";

		$FORM=new AdminForm;
		$FORM->title="EditAdmin";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("admins?Action=NewAdmin&Adding=1");
		$FORM->MakeForm("User Account Details");

		$FORM->output = "Complete the form below to create a new user account.<br>When you are done, click on the 'Continue to Step 2' button." . $FORM->output;
				
		$OUTPUT.=MakeBox("Create User Account (Step 1 of 2)", $FORM->output);
		$OUTPUT .= '

			<script language="JavaScript">

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.NewUsername.value.length < 4)
					{
						alert("Please enter a username of at least 4 characters.");
						f.NewUsername.focus();
						return false;
					}

					if(f.NewPassword.value.length < 5)
					{
						alert("Please enter a password of at least 5 characters.");
						f.NewPassword.focus();
						return false;
					}

					return true;
				}
			
			</script>
		';
	}
	else
	{
		$OUTPUT .= MakeErrorBox("Invalid License Key", "<br>Your license key does not allow you to create more users. <a href=" . MakeAdminLink("index?Page=Settings") . ">Click here to update your license key</a>.");
	}

	$DontDo = true;
}

if($Delete=="Admin"){

	// There must be at least 1 admin account
	$admins = @mysql_result(@mysql_query("SELECT COUNT(*) FROM " . $TABLEPREFIX . "admins"), 0, 0);

	if($admins > 1)
	{
		mysql_query("DELETE FROM " . $TABLEPREFIX . "admins WHERE AdminID='$AdminID'");
		mysql_query("DELETE FROM " . $TABLEPREFIX . "allow_functions WHERE AdminID='$AdminID'");
		mysql_query("DELETE FROM " . $TABLEPREFIX . "allow_lists WHERE AdminID='$AdminID'");
	}
	else
	{
		$DontDo = true;
		$OUTPUT .= MakeErrorBox("Unable to Remove Account", "<br>You must have at least 1 user account at all times. Removing this account would mean that no one could login to the control panel.");
	}
}

if($Action=="NewAdmin")
{
	// Is there already a user with this username?
	$exists = @mysql_result(@mysql_query("SELECT count(*) FROM " . $TABLEPREFIX . "admins WHERE Username = '$NewUsername'"), 0, 0) > 0 ? true : false;

	if($exists)
	{
		// An account with this name already exists
		$DontDo = true;
		$OUTPUT .= MakeErrorBox("Duplicate Account Username", "<br>The account username that you entered is already in use. Please choose another username.");
	}
	else
	{
		$P=Encrypt($NewPassword);
		mysql_query("INSERT INTO " . $TABLEPREFIX . "admins SET Status='1', Username='$NewUsername', Password='$P', MaxLists=$MaxLists");
		$NewUsername="";
		$NewPassword="";
		$AdminID=mysql_insert_id();
		$Edit="Admin";
		$AddingNew = true;
	}
}

if($Edit=="Admin"){

	if($Save){
		//allowed functions!
		mysql_query("DELETE FROM " . $TABLEPREFIX . "allow_functions WHERE AdminID='$AdminID'");
		if($AllowFunction){foreach($AllowFunction as $functionid=>$val){
			mysql_query("INSERT INTO " . $TABLEPREFIX . "allow_functions SET AdminID='$AdminID', SectionID='$functionid'");
		}}
		//allowed lists
		mysql_query("DELETE FROM " . $TABLEPREFIX . "allow_lists WHERE AdminID='$AdminID'");
		if($AllowList){foreach($AllowList as $listid=>$val){
			mysql_query("INSERT INTO " . $TABLEPREFIX . "allow_lists SET AdminID='$AdminID', ListID='$listid'");
		}}
		//general info
		if($Password!="***********"){
			$p="password='".Encrypt($Password)."',";
		}
		mysql_query("UPDATE " . $TABLEPREFIX . "admins SET AdminName='$AdminName', $p Email='$Email', Status='$Status', Root='$Root', Manager='$Manager', MaxLists=$MaxLists WHERE AdminID='$AdminID'");

		if($SubAction != "Edit")
			$OUTPUT .= MakeSuccessBox("User Account Created Successfully", "A new user account has been created successfully.", MakeAdminLink("admins"));
		else
			$OUTPUT .= MakeSuccessBox("User Account Updated Successfully", "The selected user account has been updated successfully.", MakeAdminLink("admins"));

		$DontDo = 1;
	
	}else{

		$admin=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "admins WHERE AdminID='$AdminID' ORDER BY Username ASC"));

		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		$FORM_ITEMS["<B>User Info</b>"]="spacer|<br>&nbsp;";
		$FORM_ITEMS[$noreq . "&nbsp;Username"]="spacer|".$admin["Username"] . "<br>&nbsp;";
		$FORM_ITEMS["&nbsp;&nbsp;" . $req . "&nbsp;Password"]="password|Password:40:44:***********";

		$FORM_ITEMS["&nbsp;&nbsp;" . $req . "&nbsp;Full Name"]="textfield|AdminName:40:44:".$admin["AdminName"];
		$HELP_ITEMS["AdminName"]["Title"] = "Full Name";
		$HELP_ITEMS["AdminName"]["Content"] = "The full name of the user who will be using this account.";

		$FORM_ITEMS["&nbsp;&nbsp;" . $req . "&nbsp;Email"]="textfield|Email:40:44:".$admin["Email"];
		$HELP_ITEMS["Email"]["Title"] = "Email Address";
		$HELP_ITEMS["Email"]["Content"] = "The email address of the user who will be using this account.";

		$FORM_ITEMS["&nbsp;&nbsp;" . $req . "&nbsp;Status"]="select|Status:1:0->Inactive;1->Active:".$admin["Status"];
		$HELP_ITEMS["Status"]["Title"] = "Status";
		$HELP_ITEMS["Status"]["Content"] = "Should this user account be set to active? If yes, this user will be able to login.";

		if($AddingNew)
		{
			$FORM_ITEMS["&nbsp;&nbsp;" . $req . "&nbsp;All Access?"]="select|Root:1:0->No;1->Yes:1:onChange=\"if(this.selectedIndex==1) { chooseAllFunctions(); } else { unchooseAllFunctions(); }\"";
			$HELP_ITEMS["Root"]["Title"] = "All Access?";
			$HELP_ITEMS["Root"]["Content"] = "If yes, this user will have complete access to every part of the control panel, including all functions.";

			$FORM_ITEMS["&nbsp;&nbsp;" . $req . "&nbsp;All Lists?"]="select|Manager:1:0->No;1->Yes:1:onChange=\"if(this.selectedIndex==1) { chooseAllLists(); } else { unchooseAllLists(); } \"";
			$HELP_ITEMS["Manager"]["Title"] = "All Lists?";
			$HELP_ITEMS["Manager"]["Content"] = "If yes, this user will be able to perform tasks on every mailing list.";
		}
		else
		{
			$FORM_ITEMS["&nbsp;&nbsp;" . $req . "&nbsp;All Access?"]="select|Root:1:0->No;1->Yes:".$admin["Root"] . ":onChange=\"if(this.selectedIndex==1) { chooseAllFunctions(); } else { unchooseAllFunctions(); }\"";
			$HELP_ITEMS["Root"]["Title"] = "All Access?";
			$HELP_ITEMS["Root"]["Content"] = "If yes, this user will have complete access to every part of the control panel, including all functions.";

			$FORM_ITEMS["&nbsp;&nbsp;" . $req . "&nbsp;All Lists?"]="select|Manager:1:0->No;1->Yes:".$admin["Manager"] . ":onChange=\"if(this.selectedIndex==1) { chooseAllLists(); } else { unchooseAllLists(); } \"";
			$HELP_ITEMS["Manager"]["Title"] = "All Lists?";
			$HELP_ITEMS["Manager"]["Content"] = "If yes, this user will be able to perform tasks on every mailing list.";
		}

		$FORM_ITEMS["&nbsp;&nbsp;" . $req . "&nbsp;Max Lists"]="textfield|MaxLists:5:5:".$admin["MaxLists"];
		$HELP_ITEMS["MaxLists"]["Title"] = "Maximum Lists";
		$HELP_ITEMS["MaxLists"]["Content"] = "How many lists can this user create? Enter 0 for unlimited.";

		$FORM_ITEMS["-5"]="spacer|&nbsp;";

		$FORM_ITEMS["<B>Allow Functions</b>"]="spacer|<br>&nbsp;";
		ksort($SECTIONS);
		foreach($SECTIONS AS $key=>$info){
			if(@$info["ROOT"]!=1){
				if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "allow_functions WHERE AdminID='$AdminID' && SectionID='".$info["SectionID"]."'"))>0 || $AddingNew){$sel="CHECKED";}else{$sel="";}
				$FORM_ITEMS["&nbsp;&nbsp;&nbsp;" . $info["Name"]]="checkbox|AllowFunction[".$info["SectionID"]."]:1:Yes:".$sel;
			}
		}
		
		$FORM_ITEMS["-2"]="spacer|&nbsp;";
		$FORM_ITEMS["<B>Allow Lists</b>"]="spacer|<br>&nbsp;";	
		$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists ORDER BY ListName ASC");
			while($l=mysql_fetch_array($lists)){
				if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "allow_lists WHERE AdminID='$AdminID' && ListID='".$l["ListID"]."'"))>0 || $AddingNew){$sel="CHECKED";}else{$sel="";}
				$FORM_ITEMS["&nbsp;&nbsp;&nbsp;" . $l["ListName"]]="checkbox|AllowList[".$l["ListID"]."]:1:Yes:".$sel;
			}	

		$FORM_ITEMS["-3"]="spacer|&nbsp;";

		if($SubAction == "")
			$FORM_ITEMS["-1"]="submit|Create User Account:1-admins";
		else
			$FORM_ITEMS["-1"]="submit|Update Account:1-admins";

		//make the form
		$FORM=new AdminForm;
		$FORM->title="EditAdmin";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("admins?Edit=Admin&Save=1&AdminID=$AdminID&SubAction=$SubAction");
		$FORM->MakeForm("User Account Details");

		if($SubAction == "")
			$FORM->output = "Complete the form below to finish the creation of this user account." . $FORM->output;
		else
			$FORM->output = "Complete the form below to modify this user account." . $FORM->output;

		$OUTPUT .= '

			<script language="JavaScript">

				function chooseAllFunctions()
				{
					for(i = 0; i < document.EditAdmin.elements.length; i++)
					{
						if(document.EditAdmin.elements[i].name.substring(0,13) == "AllowFunction")
						{
							document.EditAdmin.elements[i].checked = true;
						}
					}
				}

				function unchooseAllFunctions()
				{
					for(i = 0; i < document.EditAdmin.elements.length; i++)
					{
						if(document.EditAdmin.elements[i].name.substring(0,13) == "AllowFunction")
						{
							document.EditAdmin.elements[i].checked = false;
						}
					}
				}

				function chooseAllLists()
				{
					for(i = 0; i < document.EditAdmin.elements.length; i++)
					{
						if(document.EditAdmin.elements[i].name.substring(0,9) == "AllowList")
						{
							document.EditAdmin.elements[i].checked = true;
						}
					}
				}

				function unchooseAllLists()
				{
					for(i = 0; i < document.EditAdmin.elements.length; i++)
					{
						if(document.EditAdmin.elements[i].name.substring(0,9) == "AllowList")
						{
							document.EditAdmin.elements[i].checked = false;
						}
					}
				}

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.AdminName.value == "")
					{
						alert("Please enter the full name of this user.");
						f.AdminName.focus();
						return false;
					}

					if(f.Password.value == "")
					{
						alert("Please enter a password for this user account.");
						f.Password.focus();
						return false;
					}

					if(f.Email.value.indexOf(".") == -1 || f.Email.value.indexOf("@") == -1)
					{
						alert("Please enter a valid email address for this user account.");
						f.Email.focus();
						return false;
					}

					if(isNaN(f.MaxLists.value) == true || f.MaxLists.value == "" || (isNaN(f.MaxLists.value) == false && parseInt(f.MaxLists.value) < 0))
					{
						alert("Please enter a valid number for the maximum amount of lists that this user can create. Enter 0 for unlimited.");
						f.MaxLists.focus();
						return false;
					}

					return true;
				}
			
			</script>
		';

		if($SubAction == "")
			$OUTPUT.=MakeBox("Create User Account (Step 2 of 2)",$FORM->output);
		else
			$OUTPUT.=MakeBox("Modify User Account",$FORM->output);
		
	$DontDo=1;
	}

}


if(!$DontDo){

	$admins=mysql_query("SELECT * FROM " . $TABLEPREFIX . "admins ORDER BY Username ASC");

	$AdTb='

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
				<td class="headbar" width=100% colspan=5>
					&nbsp;' . ssk23twgezm2() . '
				</td>
			</tr>
			<tr>
				<td width=4% class="headbold bevel5">&nbsp;</td>
				<td class="headbold bevel5" width=20%>
					Username
				</td>
				<td class="headbold bevel5" width=36%>
					Full Name
				</td>
				<td class="headbold bevel5" width=20%>
					Status
				</td>
				<td class="headbold bevel5" width=20%>
					Action
				</td>
			</tr>
	';

	while($a=mysql_fetch_array($admins))
	{
		if($a["AdminName"] == "")
			$a["AdminName"] = "N/A";

		$AdTb .= '

			<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
				<td height=20 class="body bevel4" width=4% class="body">
					<img src="' . $ROOTURL . 'admin/images/admin.gif" width="16" height="16">
				</td>
				<td class="body bevel4" width=20%>' . $a["Username"] . '</td>
				<td class="body bevel4" width=36%>' . $a["AdminName"] . '</td>
				<td class="body bevel4" width=20%>';

			if($a["Manager"]==1)
			{
				$AdTb.="All Lists";
			}
			
			if($a["Root"]==1)
			{
				if($a["Manager"] == 1)
					$AdTb .= " / All Actions";
				else
					$AdTb .= "All Actions";
			}

			if($a["Manager"] == 0 && $a["Root"] == 0)
				$AdTb .= "Normal User";
			
		$AdTb .= '</td>
				<td class="body bevel4" width=20%>' . MakeLink("admins?SubAction=Edit&Edit=Admin&AdminID=".$a["AdminID"],"Edit") . '&nbsp;&nbsp;&nbsp;' . MakeLink("admins?Delete=Admin&AdminID=".$a["AdminID"],"Delete",1) . '</td>
		';
	}

	$AdTb .= '</table>';
	
	$AdTb = 'Use the form below to manage your user accounts.<br>You can add a user by clicking on the \'Create User Account\' button below.<br><br><input id="createAccountButton" type=button class=button onClick="document.location.href=\'' . MakeAdminLink("admins?Action=Add") . '\'" value="Create User Account"><br><br>' . $AdTb;
		
	$OUTPUT.=MakeBox("Manage Users", $AdTb);



}


?>