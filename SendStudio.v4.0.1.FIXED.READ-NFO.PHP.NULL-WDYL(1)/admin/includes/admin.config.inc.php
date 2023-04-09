<?

	ini_set("track_errors", "on");

	@include("../includes/config.inc.php");
	@include("includes/basic.inc.php");
	@include("includes/auth.inc.php");
	@include("includes/admin_output.inc.php");
	@include("includes/process.php");

	// Include the functions to generate the page templates
	include_once("includes/templates.php");

	$username = @$_POST["username"];
	$password = @$_POST["password"];

	// Is SendStudio already setup?
	if((int)$IsSetup == 0)
	{
		@include("functions" . $DIRSLASH . "install.php");
		FinishOutput();
		die();
	}

	// Could we connect to the database?
	if(@mysql_error() != "")
	{
		$OUTPUT .= MakeErrorBox("Couldn't Connect to Database", "<br>An error occured while trying to connect to your MySQL database: " . @mysql_error());
		@include("includes/admin.inc.php");
		die();
	}

	$CURRENTADMIN = array();
	$SID = @$_GET["SID"];

	//auth stuff!
	if($_SERVER["QUERY_STRING"] == "LOGINNOW")
	{
		$password = Encrypt($password);
		$lad = @mysql_query("SELECT * FROM " . $TABLEPREFIX . "admins WHERE Username='$username' && Password='$password' && Status='1'");

		if(@mysql_num_rows($lad) > 0)
		{
		
						$SID="xx";

			mysql_query("UPDATE " . $TABLEPREFIX . "admins SET LoginString='$SID', LoginTime='$SYSTEMTIME' WHERE Username='$username'");

			$lError = "";
			ssQmz44Rtt($lError);
			
			if($lError != "")
			{
				@OutputPageHeader();
				?>
					<table width="95%" align="center" border="0">
						<tr>
							<td>
				<?php

					echo MakeErrorBox("Invalid License Key", "<br>Your SendStudio license key is invalid. The error message was: $lError. <a href=" . MakeAdminLink("index?Page=Settings") . ">Click here to update your license key</a>.");
				
				?>
							</td>
						</tr>
					</table>
				<?php
				
				@OutputPageFooter();
				die();
			}
			
		}
		else
		{
			$BadLogin = 1;
			@include("includes/login.inc.php");
			exit;
		}
	}

	if($SID && mysql_num_rows($admin=mysql_query("SELECT * FROM " . $TABLEPREFIX . "admins WHERE LoginString='$SID' && LoginTime>'".($SYSTEMTIME-$LOGINDURATION)."'"))==1)
	{
		$CURRENTADMIN = mysql_fetch_array($admin);
	}
	else
	{
		@include("includes/login.inc.php");
		exit;	
	}

	//check that all members have a confirm code!
	$mems=mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE ConfirmCode=''");

	while($m=mysql_fetch_array($mems))
	{
		$ConfirmCode = md5(uniqid(rand()));
		mysql_query("UPDATE " . $TABLEPREFIX . "members SET ConfirmCode='$ConfirmCode' WHERE MemberID='".$m["MemberID"]."'");
	}
	
?>