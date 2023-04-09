<?

	include("includes".$DIRSLASH."createemails.inc.php");

	global $ROOTURL;
	global $SYSTEMTIME;
	global $send;
	global $OUTPUT;

	$SendID = @$_REQUEST["SendID"];
	$PageID = @$_REQUEST["PageID"];

	$send=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'"));

	if($send["DateStarted"]==0)
	{
		mysql_query("UPDATE " . $TABLEPREFIX . "sends SET DateStarted='$SYSTEMTIME' WHERE SendID='$SendID'");
	}
	
	//check if the send is completed
	if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "send_recipients WHERE SendID='$SendID'"))==0)
	{
		if($send["Completed"]==0)
		{
			mysql_query("UPDATE " . $TABLEPREFIX . "sends SET Completed='1', DateEnded='$SYSTEMTIME' WHERE SendID='$SendID'");
		}
	}
	
	$send=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'"));

	if($PageID=="DoSending")
	{
		$max_ex=get_cfg_var("max_execution_time")-3;
		$time_start=getmicrotime();

		set_error_handler("myErrorHandler");
		$recips=mysql_query("SELECT * FROM " . $TABLEPREFIX . "send_recipients WHERE SendID='$SendID'");

		// Workout the format of this email
		$cFormat = @mysql_result(@mysql_query("SELECT Format FROM " . $TABLEPREFIX . "composed_emails WHERE ComposedID = " . $send["ComposedID"]), 0, 0);

		while(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "send_recipients WHERE SendID='$SendID'"))>0)
		{
			$e=mysql_fetch_array($recips);
			
			if($e["MemberID"]>0)
			{
				//send the email!
				$TheEmail = CreateEmail($SendID, $e["MemberID"], $cFormat);
				
				if(@mail($TheEmail["Email"], $TheEmail["Subject"], $TheEmail["Body"], $TheEmail["Headers"]))
				{			
					//mark off as sent!
					mysql_query("DELETE FROM " . $TABLEPREFIX . "send_recipients WHERE SendID='$SendID' && MemberID='".$e["MemberID"]."'");

					if($e[Format] == 1)
					{
						$s=", HTMLRecipients=HTMLRecipients+1";
					}
					else
					{
						$s=", TextRecipients=TextRecipients+1";					
					}

					mysql_query("UPDATE " . $TABLEPREFIX . "sends SET EmailsSent=EmailsSent+1 $s WHERE SendID='$SendID'");
					
					//time taken so far!
					$time_end = getmicrotime();
					$time = round($time_end - $time_start,2);
				}
			}
		}
	}
	elseif($PageID=="Information")
	{
		if($send["Completed"]==1)
		{
			//print completed string! 
			$OUTPUT .= '<p align="justify" style="margin-left:40; margin-right:30"><font face="verdana" color="white"><font size="2"><b>:: Send Complete! ::</b></font></p>

			<script language="javascript">

				window.onError = function() { return true; }

				if(parent.parent.window.opener.document.title)
				{
					parent.parent.window.opener.document.location.href = "' . MakeAdminLink("send?Action=Done") . '";
				}

				parent.parent.window.close();
			
			</script>';
		}
		else
		{
			$total = mysql_result(mysql_query("SELECT TotalRecipients FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'"), 0, 0);
			$done = $total - mysql_result(mysql_query("SELECT COUNT(*) FROM " . $TABLEPREFIX . "send_recipients WHERE Problems='0' && SendID='$SendID'"), 0, 0);
			$numLeft = $total - $done;

			$OUTPUT .= '<p align="justify" style="margin-left:40; margin-right:30"><font face="verdana" color="white"><font size="2"><b>:: Send Information ::</b></font><font size="1"><br><br>Your newsletter is currently being sent. Please do not close this window. There are <font color="yellow"><b> ' . $numLeft . '</b></font> emails remaining in the queue...</font></p><div align="center"><a class="topLink" href="javascript:parent.window.close(); parent.window.opener.document.location.href=\'' . MakeAdminLink("send?Action=Cancel") . '\'">[Stop Sending -- You Can Always Resume Later]</a></div>';
		}
	}
	else
	{
		//frameset
		echo '<HTML>
		<HEAD>
		<TITLE>Sending Emails...</TITLE>
		</HEAD>
		<frameset rows="100,0,*" border="0">
		<frame name="logo" src="'.MakeAdminLink("send?Action=Logo").'" scrolling="no">
		<frame name="info" src="'.MakeAdminLink("send?SendID=$SendID&Action=DoSending&PageID=DoSending").'" scrolling="no">
		<frame name="sending" src="'.MakeAdminLink("send?SendID=$SendID&Action=DoSending&PageID=Information").'" scrolling="no">
		</frameset>
		</HTML>';

		exit;
	}

	function getmicrotime()
	{ 
		list($usec, $sec) = explode(" ",microtime()); 
		return ((float)$usec + (float)$sec); 
	}

	function myErrorHandler ($errno, $errstr, $errfile, $errline)
	{
		GLOBAL $SendID;
		
		if(@$send["Completed"]!=1)
		{	
			//now print the javascript to jump to the next send page!
			echo '<script language="javascript">
				parent.frames[2].location="'.MakeAdminLink("send?SendID=$SendID&Action=DoSending&PageID=Information").'"  
				parent.frames[1].location="'.MakeAdminLink("send?SendID=$SendID&Action=DoSending&PageID=DoSending").'"
			</script>';
		}
	}

?>