<?

	$Step = @$_GET["Step"];
	$OUTPUT = "";

	if($Step == "")
		$Step = 1;

	function AllPermissions()
	{
		global $OUTPUT;

		// Check the config file
		if(!@is_writable("../includes/config.inc.php"))
		{
			// Config file isn't writable
			$OUTPUT .= MakeInstallErrorBox("Config File Unwritable", "<br>The \"includes/config.inc.php\" file is not writable. Please CHMOD this file to 777 and then click on the \"Try Again\" button below.");
			return false;
		}

		// Check the archive folder
		if(!@is_writable("../archive"))
		{
			// Config file isn't writable
			$OUTPUT .= MakeInstallErrorBox("Archive Folder Unwritable", "<br>The \"archive\" folder is not writable. Please CHMOD this folder to 757 and then click on the \"Try Again\" button below.");
			return false;
		}

		// Check the archive/index.php folder
		if(!@is_readable("../archive/index.php"))
		{
			// Config file isn't writable
			$OUTPUT .= MakeInstallErrorBox("Archive File Unreadable", "<br>The \"archive/index.php\" folder is not readable. Please CHMOD this file to 757 and then click on the \"Try Again\" button below.");
			return false;
		}

		// Check the archive/index_list.php folder
		if(!@is_readable("../archive/index_list.php"))
		{
			// Config file isn't writable
			$OUTPUT .= MakeInstallErrorBox("Archive File Unreadable", "<br>The \"archive/index.php\" folder is not readable. Please CHMOD this file to 757 and then click on the \"Try Again\" button below.");
			return false;
		}

		// Check the temp folder
		if(!@is_writable("../temp"))
		{
			// Config file isn't writable
			$OUTPUT .= MakeInstallErrorBox("Temp Folder Unwritable", "<br>The \"temp\" folder is not writable. Please CHMOD this folder to 757 and then click on the \"Try Again\" button below.");
			return false;
		}

		// Check the temp/images folder
		if(!@is_readable("../temp/images"))
		{
			// Config file isn't writable
			$OUTPUT .= MakeInstallErrorBox("Temp Images Folder Unreadable", "<br>The \"temp/images\" folder is not readable. Please CHMOD this folder to 757 and then click on the \"Try Again\" button below.");
			return false;
		}

		// Everything is OK
		return true;
	}

	if($Step == 1)
	{
		if(AllPermissions())
		{
			$req = "<span class=req>*</span> ";
			$noreq = "&nbsp;&nbsp;&nbsp;";

			// Database box

			$FORM_ITEMS[$req . "MySQL Server"] = "textfield|MySQLServer:100:44:";
			$HELP_ITEMS["MySQLServer"]["Title"] = "MySQL Server";
			$HELP_ITEMS["MySQLServer"]["Content"] = "MySQL server I.P. address/hostname, such as \'localhost\'";

			$FORM_ITEMS[$req . "MySQL Username"] = "textfield|MySQLUsername:100:44:";
			$HELP_ITEMS["MySQLUsername"]["Title"] = "MySQL Server";
			$HELP_ITEMS["MySQLUsername"]["Content"] = "Username for a valid MySQL account, such as \'admin\'";

			$FORM_ITEMS[$noreq . "MySQL Password"] = "password|MySQLPassword:100:44::0";
			$HELP_ITEMS["MySQLPassword"]["Title"] = "MySQL Password";
			$HELP_ITEMS["MySQLPassword"]["Content"] = "Password for a valid MySQL account, such as \'mypassword\'";

			$FORM_ITEMS[$req . "MySQL Database"] = "textfield|MySQLDatabase:100:44:";
			$HELP_ITEMS["MySQLDatabase"]["Title"] = "MySQL Database";
			$HELP_ITEMS["MySQLDatabase"]["Content"] = "MySQL database name where SendStudio information will be saved, such as \'mydatabase\'";

			$FORM_ITEMS[$noreq . "Table Prefix"] = "textfield|TablePrefix:100:44:ss_";
			$HELP_ITEMS["TablePrefix"]["Title"] = "Table Prefix";
			$HELP_ITEMS["TablePrefix"]["Content"] = "Optional text to be prepended to all table names, such as \'ss_\'";

			$FORM = new AdminForm;
			$FORM->title = "Install1_1";
			$FORM->items = $FORM_ITEMS;
			$FORM->dontCloseForm = true;
			$FORM->action = "index.php/install?Step=2";
			$FORM->MakeForm("MySQL Database Details");

			// Directories box
			$x1 = strpos($_SERVER["REQUEST_URI"], "/", 0);
			$x2 = strpos($_SERVER["REQUEST_URI"], "/", 1);
			$RPath = substr($_SERVER["REQUEST_URI"], $x1, $x2 - $x1 + 1);
			$Path = "http&#58;//" . $_SERVER["SERVER_NAME"] . $RPath;
			$FORM2_ITEMS[$req . "SendStudio Path"] = "textfield|SendStudioPath:100:44:" . $Path;
			$HELP_ITEMS["SendStudioPath"]["Title"] = "SendStudio Path";
			$HELP_ITEMS["SendStudioPath"]["Content"] = "The full URL to the main SendStudio directory, such as \'http://www.mysite.com/sendstudio/\'. Make sure you include a trailing forwardslash. The install script has tried to guess this URL for you, however it may fail.";

			$RDir = str_replace("//", "/", str_replace("admin/index.php", "", @$_SERVER["DOCUMENT_ROOT"] . "/" . @$_SERVER["REQUEST_URI"] . "/"));

			$FORM2_ITEMS[$req . "Root Directory"] = "textfield|SendStudioRoot:100:44:" . $RDir;
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

			$FORM4_ITEMS[-1]="submit|Install SendStudio";

			$FORM4 = new AdminForm;
			$FORM4->title = "Install1_4";
			$FORM4->items = $FORM4_ITEMS;
			$FORM4->action = "DEADLINK";
			$FORM4->MakeForm("Miscellaneous Settings");

			$FORM->output = "Complete the form below to install SendStudio. Click on the \"Install SendStudio\" button at the bottom of the page to continue.<br>Fields marked with an asterix (<span class=req>*</span>) are required.<br>" . $FORM->output . "<br>" . $FORM2->output . "<br>" . $FORM3->output . "<br>" . $FORM4->output;

			$OUTPUT .= MakeBox("SendStudio Installation Wizard", $FORM->output);
			$OUTPUT .= "</form>";

			$OUTPUT .= '

				<script language="JavaScript">

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

						return true;
					}
				
				</script>
			';
		}
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
		$ShowInfoTips = @(int)@$_REQUEST["ShowInfoTips"];
		$AutoArchive = @(int)@$_REQUEST["AutoArchive"];

		// Firstly, is the config file writable?
		if(!@is_writable("../includes/config.inc.php"))
		{
			// Config file isn't writable
			$OUTPUT .= MakeInstallErrorBox("Config File Unwritable", "<br>The \"" . $SendStudioRoot . "includes/config.inc.php\" file is not writable. Please CHMOD this file to 777 and then click on the \"Try Again\" button below.");
		}
		else
		{
			// We can already write to the config file.
			// Can we connect to the database?
			$svrConn = @mysql_connect($MySQLServer, $MySQLUsername, $MySQLPassword);

			if(!$svrConn)
			{
				// Couldn't connect to the database server
				$OUTPUT .= MakeErrorBox("Database Error", "<br>An error occured while trying to connect to your MySQL database server. The error was: '" . mysql_error() . "'. Click on the \"OK\" button below to correct your MySQL details.");
			}
			else
			{
				// Can we connect to the database?
				$dbConn = @mysql_select_db($MySQLDatabase, $svrConn);

				if(!$dbConn)
				{
					// Couldn't connect to the datbase
					$OUTPUT .= MakeErrorBox("Database Error", "<br>An error occured while trying to connect to your MySQL database. The error was: '" . mysql_error() . "'. Click on the \"OK\" button below to correct your MySQL details.");
				}
				else
				{
					// Can we create the tables?
					$numErrors = 0;

					for($i = 0; $i < sizeof($tableSchema); $i++)
					{
						// Try and run each "CREATE TABLE" query one by one
						@mysql_query(str_replace("%%TABLEPREFIX%%", $TablePrefix, $tableSchema[$i])) or $numErrors++;
					}

					if($numErrors > 0)
					{
						// An error occured while building the tables
						$OUTPUT .= MakeInstallErrorBox("Database Error", "<br>An error occured while trying to build your MySQL database tables. The error was: '" . mysql_error() . "'. Click on the \"Try Again\" button below to try again.");
					}
					else
					{
						// The tables were built OK. Add the default admin user
						@mysql_query("INSERT INTO " . $TablePrefix . "admins SET Username='admin', Password='5f4dcc3b5aa765d61d8327deb882cf99', Manager='1', Root='1', Status='1'");

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

								$OUTPUT .= MakeSuccessBox("SendStudio Installation Completed!", "<br>Congratulations! Your copy of SendStudio has been installed successfully.<br>Your SendStudio username is <b><i>admin</i></b> and your password is <b><i>password</i></b>.<br>Click on the button below to login.<br><br>", MakeAdminLink("index"));
							}
						}
					}
				}
			}
		}
	}
?>