<?

	$Step = @$_REQUEST["Step"];
	$OUTPUT = "";

	if($Step == "")
		$Step = 1;
	
	if($Step == 1)
	{
		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		// Database box

		$FORM_ITEMS[$req . "MySQL Server"] = "textfield|MySQLServer:100:44:" . $DBHOST;
		$HELP_ITEMS["MySQLServer"]["Title"] = "MySQL Server";
		$HELP_ITEMS["MySQLServer"]["Content"] = "MySQL server I.P. address/hostname, such as \'localhost\'";

		$FORM_ITEMS[$req . "MySQL Username"] = "textfield|MySQLUsername:100:44:" . $DBUSER;
		$HELP_ITEMS["MySQLUsername"]["Title"] = "MySQL Server";
		$HELP_ITEMS["MySQLUsername"]["Content"] = "Username for a valid MySQL account, such as \'admin\'";

		$FORM_ITEMS[$noreq . "MySQL Password"] = "password|MySQLPassword:100:44:" . $DBPASS . ":0";
		$HELP_ITEMS["MySQLPassword"]["Title"] = "MySQL Password";
		$HELP_ITEMS["MySQLPassword"]["Content"] = "Password for a valid MySQL account, such as \'mypassword\'";

		$FORM_ITEMS[$req . "MySQL Database"] = "textfield|MySQLDatabase:100:44:" . $DBNAME;
		$HELP_ITEMS["MySQLDatabase"]["Title"] = "MySQL Database";
		$HELP_ITEMS["MySQLDatabase"]["Content"] = "MySQL database name where SendStudio information will be saved, such as \'mydatabase\'";

		$FORM_ITEMS[$noreq . "Table Prefix"] = "textfield|TablePrefix:100:44:" . $TABLEPREFIX;
		$HELP_ITEMS["TablePrefix"]["Title"] = "Table Prefix";
		$HELP_ITEMS["TablePrefix"]["Content"] = "Optional text to be prepended to all table names, such as \'ss_\'";

		$FORM = new AdminForm;
		$FORM->title = "Install1_1";
		$FORM->items = $FORM_ITEMS;
		$FORM->dontCloseForm = true;
		$FORM->action = MakeAdminLink("index?Page=Settings&Step=2");
		$FORM->MakeForm("MySQL Database Details");

		// Directories box
		$FORM2_ITEMS[$req . "SendStudio Path"] = "textfield|SendStudioPath:100:44:" . str_replace(":", "&#58;", $ROOTURL);
		$HELP_ITEMS["SendStudioPath"]["Title"] = "SendStudio Path";
		$HELP_ITEMS["SendStudioPath"]["Content"] = "The full URL to the main SendStudio directory, such as \'http://www.mysite.com/sendstudio/\'. Make sure you include a trailing forwardslash. The install script has tried to guess this URL for you, however it may fail.";

		$FORM2_ITEMS[$req . "Root Directory"] = "textfield|SendStudioRoot:100:44:" . $ROOTDIR;
		$HELP_ITEMS["SendStudioRoot"]["Title"] = "SendStudio Root Directory";
		$HELP_ITEMS["SendStudioRoot"]["Content"] = "The full root-relative path to the main SendStudio directory, such as \'/htdocs/www/sendstudio/\'. Make sure you include a trailing forwardslash.";

		$FORM2 = new AdminForm;
		$FORM2->title = "Install1_2";
		$FORM2->items = $FORM2_ITEMS;
		$FORM2->action = "DEADLINK";
		$FORM2->MakeForm("SendStudio Directories");

		

		$FORM3_ITEMS[$noreq . "<center><b>License Key not need more,<br> thanks to WDYL</center></b>"] = "hidden|LicenseKey:100:44:" . "prout";
		$HELP_ITEMS["LicenseKey"]["Title"] = "License Key";
		$HELP_ITEMS["LicenseKey"]["Content"] = "The license key that was emailed to you when you ordered or upgraded.";

		$FORM3 = new AdminForm;
		$FORM3->title = "Install1_3";
		$FORM3->items = $FORM3_ITEMS;
		$FORM3->action = "DEADLINK";
		$FORM3->MakeForm("SendStudio License Key");

		$sel = ($ShowInfoTips == 1 ? "CHECKED" : "");

		$FORM4_ITEMS["Show Info Tips?"] = "checkbox|ShowInfoTips:1:Yes:" . $sel;
		$HELP_ITEMS["ShowInfoTips"]["Title"] = "Show Info Tips?";
		$HELP_ITEMS["ShowInfoTips"]["Content"] = "If ticked, SendStudio will show a random email marketing tip across of the top of the control panel.";

		$sel1 = ($AutoArchive == 1 ? "CHECKED" : "");

		$FORM4_ITEMS["Auto Archive Content?"] = "checkbox|AutoArchive:1:Yes:" . $sel1;
		$HELP_ITEMS["AutoArchive"]["Title"] = "Auto Archive Content?";
		$HELP_ITEMS["AutoArchive"]["Content"] = "If ticked, SendStudio will save a copy of each newsletter sent to the /sendstudio/archive folder automatically.";

		$FORM4 = new AdminForm;
		$FORM4->title = "Install1_4";
		$FORM4->items = $FORM4_ITEMS;
		$FORM4->action = "DEADLINK";
		$FORM4->MakeForm("Miscellaneous Settings");

		$FORM5_ITEMS["Test Email"]="textfield|TestEmail:100:44::0:<input class='submit' type='button' value='Test Sending System' onClick='PrepareSendingSystem()'>";
		$HELP_ITEMS["TestEmail"]["Title"] = "Test Email";
		$HELP_ITEMS["TestEmail"]["Content"] = "To test the SendStudio sending system, enter your email address here. If SendStudio can send emails, a sample email will be sent to this email address when you click on the \'Test Sending System\' button.";

		$FORM5_ITEMS[-1]="submit|Update Settings:1-index";

		$FORM5 = new AdminForm;
		$FORM5->title = "Install1_5";
		$FORM5->items = $FORM5_ITEMS;
		$FORM5->action = "DEADLINK";
		$FORM5->MakeForm("Test Sending System");

		$FORM->output = "Complete the form below to update your SendStudio settings. Click on the \"Update Settings\" button at the bottom of the page to continue.<br>Fields marked with an asterix (<span class=req>*</span>) are required.<br>" . $FORM->output . "<br>" . $FORM2->output . "<br>" . $FORM3->output . "<br>" . $FORM4->output . "<br>" . $FORM5->output;

		$OUTPUT .= MakeBox("SendStudio Settings", $FORM->output);
		$OUTPUT .= "</form>";

		$OUTPUT .= '

			<script language="JavaScript">

				function PrepareSendingSystem()
				{
					document.forms[0].target = "_blank";
					prevAction = document.forms[0].action;
					document.forms[0].action = "' . MakeAdminLink("index?Page=TestSendingSystem") . '";
					document.forms[0].submit();
					document.forms[0].target = "";
					document.forms[0].action = prevAction;
				}

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.MySQLServer.value == "")
					{
						alert("Please enter your MySQL server I.P. address/hostname.");
						f.MySQLServer.focus();
						return false;
					}

					if(f.MySQLUsername.value == "")
					{
						alert("Please enter a valid MySQL username.");
						f.MySQLUsername.focus();
						return false;
					}

					if(f.MySQLDatabase.value == "")
					{
						alert("Please enter your MySQL database name.");
						f.MySQLDatabase.focus();
						return false;
					}

					if(f.SendStudioPath.value == "")
					{
						alert("Please enter the full URL to your SendStudio folder.");
						f.SendStudioPath.focus();
						return false;
					}

					if(f.SendStudioRoot.value == "")
					{
						alert("Please enter the root-relative path to your SendStudio folder.");
						f.SendStudioRoot.focus();
						return false;
					}

					if(f.LicenseKey.value == "")
					{
						alert("Please enter the license key that you receive via email (as part of your invoice) when you ordered.");
						f.LicenseKey.focus();
						return false;
					}

					// If the license key is updated, they will be logged out automatically
					if(f.OldLicenseKey.value != f.LicenseKey.value)
					{
						alert("Because you have changed your license key, you will automatically be logged out after your settings are updated.");
					}
					
					return true;
				}
			
			</script>
		';
	}
	else if($Step == 2)
	{
		// Include the MySQL schema file
		include("includes/schema.php");

		// Escape all of the request variables
		foreach($_REQUEST as $k => $v)
		{
			$_REQUEST[$k] = str_replace("$", "\\$", $v);
		}

		$MySQLServer = @$_REQUEST["MySQLServer"];
		$MySQLUsername = @$_REQUEST["MySQLUsername"];
		$MySQLPassword = @$_REQUEST["MySQLPassword"];
		$MySQLDatabase = @$_REQUEST["MySQLDatabase"];
		$TablePrefix = @$_REQUEST["TablePrefix"];

		$SendStudioPath = @$_REQUEST["SendStudioPath"];
		$SendStudioRoot = @$_REQUEST["SendStudioRoot"];

		$LicenseKey = @$_REQUEST["LicenseKey"];
		$OldLicenseKey = @$_REQUEST["OldLicenseKey"];
		$ShowInfoTips = @(int)@$_REQUEST["ShowInfoTips"];
		$AutoArchive = @(int)@$_REQUEST["AutoArchive"];

		// Firstly, is the config file writable?
		if(!@is_writable("../includes/config.inc.php"))
		{
			// Config file isn't writable
			$OUTPUT .= MakeInstallErrorBox("Config File Unwritable", "<br>The \"" . $SendStudioRoot . "includes/config.inc.php\" file is not writable. Please CHMOD this file to 757 and then click on the \"Try Again\" button below.");
		}
		else
		{

				// Now write out the config file
				$fp = @fopen("../includes/config.inc.php", "wb");

				if(!$fp)
				{
					// Couldn't open the config file
					$OUTPUT .= MakeInstallErrorBox("Couldn't Open Config File", "<br>The \"" . $SendStudioRoot . "includes/config.inc.php\" file couldn't be opened. Please make sure that it exists and then click on the \"Try Again\" button below.");
				}
				else
				{
					// The config file was opened OK, let's write to it
					$configData = "<?

ERROR_REPORTING(E_ALL);

\$IsSetup = 1;

\$DBHOST=\"$MySQLServer\";
\$DBUSER=\"$MySQLUsername\";
\$DBPASS=\"$MySQLPassword\";
\$DBNAME=\"$MySQLDatabase\";
\$TABLEPREFIX=\"$TablePrefix\";

\$ROOTURL=\"$SendStudioPath\";
\$ROOTDIR=\"$SendStudioRoot\";

\$LicenseKey=\"$LicenseKey\";
\$ShowInfoTips=$ShowInfoTips;
\$AutoArchive=$AutoArchive;

\$SYSTEMTYPE=\"L\";
\$LOGINDURATION=7200;
\$SYSTEMTIME=time();
\$DateFormat=\"j M Y\";
\$ImageFileSizeLimit=1000000;

@mysql_connect(\$DBHOST, \$DBUSER,\$DBPASS);
@mysql_select_db(\$DBNAME);

\$FIELDTYPES[\"shorttext\"]=\"One Line Textbox\";
\$FIELDTYPES[\"longtext\"]=\"Multiline Textbox\";
\$FIELDTYPES[\"dropdown\"]=\"Dropdown List\";
\$FIELDTYPES[\"checkbox\"]=\"Checkbox (Yes/No)\";

\$DIRSLASH='/';

function DisplayDate(\$Date){
GLOBAL \$DateFormat;
return date(\$DateFormat, \$Date);
}

?>";

					// Can we write to the config file?
					if(@fputs($fp, $configData))
					{
						// Close the config file
						@fclose($fp);

						if($OldLicenseKey != $LicenseKey)
						{
							@ob_end_clean();
							@ob_start();

							header("location:index?Page=Logout");
							die();
						}
						else
						{
							$OUTPUT .= MakeSuccessBox("SendStudio Settings Updated!", "<br>Your SendStudio settings have been updated successfully.<br>&nbsp;", MakeAdminLink("index"));
						}
					}
			}
		}
	}

?>