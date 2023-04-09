<?

	$Action = @$_REQUEST["Action"];
	$ListID = @$_REQUEST["ListID"];
	$Open = @$_REQUEST["Open"];
	$Status = @$_REQUEST["Status"];
	$Confirmed = @$_REQUEST["Confirmed"];
	$Format = @$_REQUEST["Format"];
	$Email = @$_REQUEST["Email"];
	$HaveClickedLink = @$_REQUEST["HaveClickedLink"];
	$Fields = @$_REQUEST["Fields"];
	$Period = @$_REQUEST["Period"];
	$JO = @$_REQUEST["JO"];
	$DoDays = @$_REQUEST["DoDays"];
	$ReportType = @$_REQUEST["ReportType"];

	if($ReportType == 1)
	{
		$Action = "ListOverview";
		$Open = "SIGNUPS";
	}
	else if($ReportType == 2)
	{
		$Action = "ListOverview";
		$Open = "MEMBERS";
	}
	else if($ReportType == 3)
	{
		$Action = "ListOverview";
		$Open = "SENDS";
	}

	$alllists = "";
	$alllinks = "";
	$mx = "";
	$sx = "";
	$jx = "";
	$OUTPUT = "";
	$MS = "";
	$Disp = "";
	$SI = $SA = $CI = $Members = array();
	$JoinDays = $JoinHours = array();

	if($Action=="MemberStats"){
		include "../includes$DIRSLASH"."members.inc.php";
		
		$Members=ReturnMembers($ListID,$Email,$Status,$Confirmed,$Fields,$HaveClickedLink,$Format);
		
		if(sizeof($Members)==0){

		}else{	
		if($Status=="0"){
			$SI=ReturnMembers($ListID,$Email,"0",$Confirmed,$Fields,$HaveClickedLink,$Format);	
		}elseif($Status==1){
			$SA=ReturnMembers($ListID,$Email,1,$Confirmed,$Fields,$HaveClickedLink,$Format);	
		}else{	
			$SA=ReturnMembers($ListID,$Email,1,$Confirmed,$Fields,$HaveClickedLink,$Format);
			$SI=ReturnMembers($ListID,$Email,"0",$Confirmed,$Fields,$HaveClickedLink,$Format);
		}
		
		if($Confirmed=="0"){
			$CI=ReturnMembers($ListID,$Email,$Status,"0",$Fields,$HaveClickedLink,$Format);	
		}elseif($Confirmed==1){
			$CA=ReturnMembers($ListID,$Email,$Status,1,$Fields,$HaveClickedLink,$Format);
		}else{
			$CA=ReturnMembers($ListID,$Email,$Status,1,$Fields,$HaveClickedLink,$Format);
			$CI=ReturnMembers($ListID,$Email,$Status,"0",$Fields,$HaveClickedLink,$Format);	
		}

		
		if($Format=="0"){
			$FT=ReturnMembers($ListID,$Email,$Status,$Confirmed,$Fields,$HaveClickedLink,"0");		
		}elseif($Format==1){
			$FH=ReturnMembers($ListID,$Email,$Status,$Confirmed,$Fields,$HaveClickedLink,1);
		}else{
			$FH=ReturnMembers($ListID,$Email,$Status,$Confirmed,$Fields,$HaveClickedLink,1);
			$FT=ReturnMembers($ListID,$Email,$Status,$Confirmed,$Fields,$HaveClickedLink,"0");	
		}

		$MS .= '<table width=95% border=0 align=center><tr><td>';	
		$MS.='<b>Member Statistics</b><ul>
		<li>Total Members: '.sizeof($Members).'</li>
		<li>Active: '.sizeof($SA).' ('.round(sizeof($SA)/sizeof($Members)*100).'%)</li>
		<li>Inactive: '.sizeof($SI).' ('.round(sizeof($SI)/sizeof($Members)*100).'%)</li>
		<li>Confirmed: '.sizeof($CA).' ('.round(sizeof($CA)/sizeof($Members)*100).'%)</li>
		<li>Unconfirmed: '.sizeof($CI).' ('.round(sizeof($CI)/sizeof($Members)*100).'%)</li></ul>
		<B>Newsletter Format</B><ul>
		<li>Text Only: '.sizeof($FT).' ('.round(sizeof($FT)/sizeof($Members)*100).'%)</li>
		<li>HTML: '.sizeof($FH).' ('.round(sizeof($FH)/sizeof($Members)*100).'%)</li>
		';
		
		//now do extra list fields!
		$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "'");
		while($f=mysql_fetch_array($list_fields)){
			$yes=0;$no=0;$Values="";
			if($f["FieldType"]=="checkbox"){
			foreach($Members as $MemberID){
				$mv=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_field_values WHERE FieldID='".$f["FieldID"]."' && UserID='$MemberID'"));
				if($mv["Value"]=="CHECKED"){
					$yes++;
				}else{
					$no++;
				}
			}
			$MS.='</ul><B>'.$f["FieldName"].'</B><ul>
				<li>Yes: '.$yes.' ('.round($yes/sizeof($Members)*100).'%)</li>
				<li>No: '.$no.' ('.round($no/sizeof($Members)*100).'%)</li>
				';
			}
			
			if($f["FieldType"]=="dropdown"){
				$MS.='</ul><B>'.$f["FieldName"].' </B><ul>';
				reset($Members);
				foreach($Members as $MemberID){
				$mv=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_field_values WHERE FieldID='".$f["FieldID"]."' && UserID='$MemberID'"));
				@$Values[$mv["Value"]]++;
				}
				$allvals=explode(";",$f["AllValues"]);
				foreach($allvals as $aval){
					@list($sysval,$pri)=@explode("->",$aval);
					if($sysval){
					if(@!$Values[$sysval]){$Values[$sysval]="0";}
					$MS.='<li>'.$pri.': '.$Values[$sysval].' ('.round($Values[$sysval]/sizeof($Members)*100).'%)</li>';
					}
				}
			}
		
		}
		
		//now links!
		$MS.='</ul><B>Clicked Links </B><ul>';
		$links=mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY LinkName");
		while($l=mysql_fetch_array($links)){
			$TotalClicks=0;
			reset($Members);
			foreach($Members as $MemberID){
				$clicked=mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "link_clicks WHERE LinkID='".$l["LinkID"]."' && MemberID='$MemberID'"));
				if($clicked>0){
					$TotalClicks++;
				}
			}
			$MS.='<li>'.$l["LinkName"].': '.$TotalClicks.' ('.round($TotalClicks/sizeof($Members)*100).'%)</li>';
		}
		$MS.='</ul>';
		}

		$MS .= '</td></tr></table>';

		$ListName = "'" . mysql_result(mysql_query("SELECT ListName FROM " . $TABLEPREFIX . "lists WHERE ListID = $ListID"), 0, 0) . "'";

		if(sizeof($Members) > 0)
		{
			$MS = 'The subscriber details report is shown below.<br>Click on the "Generate New Report" button to view other reports.<br><br><input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("stats") . '"\' value="Generate New Report"><br><br>' . $MS;
		}
		else
		{
			$MS = 'No subscribers were found that matched your search criteria.<br>Please click on the button below to search again.<br><br><input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("stats") . '"\' value="Generate New Report">' . $MS;

		}

		$OUTPUT.=MakeBox("Subscriber Details Report for $ListName",$MS);
	}


	if($Action=="SendInfo"){
		//sends, last five overview!
		$sends=mysql_query("SELECT * FROM " . $TABLEPREFIX . "sends WHERE ListID='$ListID' && Completed='1' ORDER BY DateStarted DESC Limit $Buffer,5");
		$SO='<TABLE class="admintext">';
		while($s=mysql_fetch_array($sends)){
			$SO.='<TR><TD>SendID: </td><td>'.$s["SendID"].'</td></tr>';
			$SO.='<TR><TD>Date: </td><td>'.DisplayDate($s["DateStarted"]).'</td></tr>';	
			//format overview!
			$SO.='<TR><TD>Recipients: </td><td>'.$s["EmailsSent"].'</td></tr>';
			$SO.='<TR><TD></td><TD>HTML</td><td>'.$s["HTMLRecipients"].'</td></tr>';
			$SO.='<TR><TD></td><TD>TEXT</td><td>'.$s["TextRecipients"].'</td></tr>';
			//opens!
			$opens=mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "email_opens WHERE SendID='".$s["SendID"]."'"));
			if($s["HTMLRecipients"]>0){
				$openper=$opens/$s["HTMLRecipients"]*100;
			}else{
				$openper=0;
			}
			$SO.='<TR><TD>Opened By: </td><td>'.round(($openper/100)*$s["EmailsSent"]).' ('.round($openper,2).'%)</td></tr>';		
			
			$SO.='<TR><TD>Time Taken: </td><td>'.($s["DateEnded"]-$s["DateStarted"]).' seconds</td></tr>';
			
			$SO.='<TR><TD bgcolor="'.$t["ColorOne"].'" colspan="4"></td></tr>';
		}
		
		$SO.='</table><P>';



		if($Buffer>3){
			$SO.=MakeLink("stats?ListID=$ListID&Action=SendInfo&Buffer=".($Buffer-5),"View Prev 5");
		}else{
			$SO.=MakeLink("stats?ListID=$ListID&Action=ListOverview","Back to list overview");
		}
		
		$SO.=' | ';
		
		if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "sends WHERE ListID='$ListID' && Completed='1'"))>=($Buffer+5)){
		$SO.=MakeLink("stats?ListID=$ListID&Action=SendInfo&Buffer=".($Buffer+5),"View Next 5");
		}
		$OUTPUT.=MakeBox("Overview of sends",$SO);
	}


	if($Action=="ListOverview"){

		$ListName = "'" . mysql_result(mysql_query("SELECT ListName FROM " . $TABLEPREFIX . "lists WHERE ListID = $ListID"), 0, 0) . "'";

		if(!$Open){
			$Open="MEMBERS";
		}
		
		if($Open=="SIGNUPS"){

			//decide on the time period!
			if($Period){
				$JO.='Signup information for signups since '.DisplayDate($Period);
			}else{
				$JO.='The report below shows graphs for when new subscribers joined your mailing list.<br>The report is broken down into two seperate sections: "per day" and "per hour<br><br><input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("stats") . '"\' value="Generate New Report">';
				$Period=1000;
				$DoDays=1;
			}
		
			$members=mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE ListID='$ListID' && SubscribeDate>'$Period'");
		
			while($m=mysql_fetch_array($members)){
				//work out their join day!
				@$JoinDays[date("w",$m["SubscribeDate"])]++;
				@$JoinHours[date("H",$m["SubscribeDate"])]++;		
			}

			//now print out the info!
				$Days=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
				//by day of week!
				$JO.='<P><TABLE class="admintext" width="95%" align="center">
				<TR><TD colspan="3"><B>New Signups by Day</B></td></tr>';
				for($i=0;$i<7;$i++){
					if(@$JoinDays[$i]==0){
						$Perc="0";
						$Width="0";
					}else{
						$Perc=round($JoinDays[$i]/mysql_num_rows($members)*100,2);
						$Width=($Perc*3);
					}
					$JO.='<TR><TD width="20%" align="right">'.$Days[$i].': </td><td width="10%">' . @(int)@number_format(@$JoinDays[$i],0) . '</td><TD width="70%"><img src="'.$ROOTURL.'admin/images/bar_line.gif" height="10" width="'.$Width.'"></TD></tr>';
				}
				$JO.='</TABLE><br>';
				
				//by hour of day!
				$JO.='<TABLE class="admintext" width="95%" align="center">
				<TR><TD colspan="3"><B>New Signups by Hour</B></td></tr>';
				for($i=0;$i<24;$i++){
					if(@$JoinHours[$i]==0){
						$Perc="0";
						$Width="0";
					}else{
						$Perc=round(@$JoinHours[$i]/mysql_num_rows($members)*100,2);
						$Width=($Perc*3);
					}
					
					$LD = $Disp;
					
					if($i < 12)
					{
						$Disp = ($i+1)."am";
					}else
					{
						$Disp = ($i-11)."pm";
					}
					
					if($Disp == "1am")
						$JO.='<TR><TD width="20%" align="right">'.$Disp.': </td><td width="10%">' . @(int)@number_format(@$JoinHours[$i],0) . '</td><TD width="70%"><img src="'.$ROOTURL.'admin/images/bar_line.gif" height="10" width="'.$Width.'"></TD></tr>';
					else
						$JO.='<TR><TD width="20%" align="right">'.$LD . ' - ' . $Disp.': </td><td width="10%">' . @(int)@number_format(@$JoinHours[$i],0) . '</td><TD width="70%"><img src="'.$ROOTURL.'admin/images/bar_line.gif" height="10" width="'.$Width.'"></TD></tr>';
				}
				$JO.='</TABLE>';

				$OUTPUT.=MakeBox("Signup Report for $ListName", $JO);
		}else{
			$JO="";
		}

		if($Open=="MEMBERS")
		{
			//search for members form!
			$req = "<span class=req>*</span> ";
			$noreq = "&nbsp;&nbsp;&nbsp;";

				$FORM_ITEMS[$req . "Status"]="select|Status:1:ALL->View All;0->Inactive;1->Active:1";
				$HELP_ITEMS["Status"]["Title"] = "Status";
				$HELP_ITEMS["Status"]["Content"] = "Should this report include users who are set to active, inactive or both?";

				$FORM_ITEMS[$req . "Confirmed"]="select|Confirmed:1:ALL->Either;0->Not Confirmed;1->Confirmed:1";
				$HELP_ITEMS["Confirmed"]["Title"] = "Confirmed";
				$HELP_ITEMS["Confirmed"]["Content"] = "Should this report include users who are confirmed, unconfirmed or both?";
				
				$FORM_ITEMS[$req . "Format"]="select|Format:1:ALL->Either;0->Text;1->HTML";
				$HELP_ITEMS["Format"]["Title"] = "Format";
				$HELP_ITEMS["Format"]["Content"] = "Should this report include users who are flagged to receive text emails, HTML emails or both?";
				
				$FORM_ITEMS[$noreq . "Search Email"]="textfield|Email:100:44:";

					//extra fields
					$size = $min = $max = $Width = $Height = 0;
					$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "'");
					while($f=mysql_fetch_array($fields)){
						switch($f["FieldType"]){
							case "shorttext":
								list($size,$min,$max)=explode(",",$f["AllValues"]);
								$FORM_ITEMS[$noreq . "Search ".$f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:$max:44";
							break;
							
							case "longtext":
								list($Width,$Height)=explode(",",$f["AllValues"]);
								$FORM_ITEMS[$noreq . "Search ".$f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:500:44";
							break;
							
							case "checkbox":
								$FORM_ITEMS[$noreq . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:y->Yes;n->No;all->All:all";
							break;
						
							case "dropdown":
								$FORM_ITEMS[$noreq . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:->All Values;".$f["AllValues"].":";
							break;
						}
					}

					$links=mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE Status='1' && AdminID='" . $CURRENTADMIN["AdminID"] . "'");
					while($l=mysql_fetch_array($links)){
						$alllinks.=$l["LinkID"].'->'.$l["LinkName"].';';
					}
				
				$FORM_ITEMS[$noreq . "Have Clicked Link"]="select|HaveClickedLink:1:->None;$alllinks";
				$HELP_ITEMS["HaveClickedLink"]["Title"] = "Have Clicked Link";
				$HELP_ITEMS["HaveClickedLink"]["Content"] = "Should this report only include subscribers who have clicked on a particular link from a newsletter that you sent out?";

				$FORM_ITEMS["-1"]="submit|View Report:1-stats";
				
				$FORM=new AdminForm;
				$FORM->title="SearchMembers";
				$FORM->items=$FORM_ITEMS;
				$FORM->action=MakeAdminLink("stats?Action=MemberStats&ListID=$ListID");
				$FORM->MakeForm("Filter Subscriber Details");
				$MO=$FORM->output;

				$MO = "Complete the form below to filter subscribers for this report (optional)." . $MO;
				$OUTPUT.=MakeBox("Subscriber Details Report for $ListName", $MO);

				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							return true;
						}
					
					</script>
				';

		}else{
			$MO="";
			$mx=MakeLink("stats?Action=ListOverview&ListID=$ListID&Open=MEMBERS","OPEN");
		}

		if($Open=="SENDS")
		{
		//sends, last five overview!
		$sends=mysql_query("SELECT * FROM " . $TABLEPREFIX . "sends WHERE ListID='$ListID' && Completed='1' ORDER BY DateStarted DESC");

		if(mysql_num_rows($sends) > 0)
		{
			$SO = 'Details for each newsletter that has been sent are shown below.<br>Click on the "Generate New Report" button to view other reports.<br><br><input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("stats") . '"\' value="Generate New Report">
			<br><br>
				<table width=100% border=0 cellspacing=2 cellpadding=2>
					  <tr>
						<td width=4% class="headbold bevel5">&nbsp;</td>
						<td class="headbold bevel5" width=36%>
							Newsletter
						</td>
						<td class="headbold bevel5" width=15%>
							Date Sent
						</td>
						<td class="headbold bevel5" width=10%>
							Recipients
						</td>
						<td class="headbold bevel5" width=15%>
							Opened By
						</td>
						<td class="headbold bevel5" width=20%>
							Time Taken
						</td>
				</tr>
			';

			while($s=mysql_fetch_array($sends))
			{
				$NewsletterName = mysql_result(mysql_query("SELECT EmailName FROM " . $TABLEPREFIX . "composed_emails WHERE ComposedID = " . $s["ComposedID"]), 0, 0);

					$SO .= '

						<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
							<td height=20 class="body bevel4" width=4% class="SOdy">
								<img src="' . $ROOTURL . 'admin/images/newsletter.gif" width="14" height="11">
							</td>
							<td class="body bevel4" width=36%>' . $NewsletterName . '</td>
							<td class="body bevel4" width=15%>' . DisplayDate($s["DateStarted"]) . '</td>
							<td class="body bevel4" width=10%>' . $s["EmailsSent"] . '</td>';

					$opens = mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "email_opens WHERE SendID='".$s["SendID"]."'"));
					$openPercent = 0;
					
					if($s["EmailsSent"] > 0)
						$openPercent = floor(($opens / (int)$s["EmailsSent"]) * 100);
					else
						$openPercent = "0";

					// Overflow check
					if($opens > $s["EmailsSent"])
					{
						$opens = (int)$s["EmailsSent"];
						$openPercent = "100";
					}

					if($s["HTMLRecipients"] == 0 && $opens == 0)
					{
						$openText = "Unknown";
					}
					else
					{
						$openText = $opens . " (" . $openPercent . "%)";
					}

					$sendSeconds = ($s["DateEnded"]-$s["DateStarted"]);

					// If it took longer than a minute, then express it in minutes instead of seconds
					if($sendSeconds > 60)
					{
						$sendTime = floor($sendSeconds / 60);
						$sendTime .= ($sendTime == 1 ? " minute" : " minutes");
					}
					else
					{
						$sendTime = "$sendSeconds seconds";
					}

					$SO .= '
							<td class="body bevel4" width=15%>' . $openText . '</td>
							<td class="body bevel4" width=20%>' . $sendTime . '</td>';

					$SO .= '
						</tr>
					';
			}
			
			$SO.='</table>

				<script language="JavaScript">

					function selectOn(trObject)
					{
						for(i = 0; i <= 5; i++)
						{
							trObject.childNodes[i].className = "body bevel4 rowSelectOn";
						}
					}

					function selectOut(trObject, whichStyle)
					{
						for(i = 0; i <= 5; i++)
							trObject.childNodes[i].className = "body bevel4";
					}
				
				</script>
			';
		}
		else
		{
			// No newsletters have been sent
			$SO = 'No newsletters have been sent yet. Please click on the button below to view another report.<br><br><input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("stats") . '"\' value="Generate New Report">';
		}

		$OUTPUT.=MakeBox("Send Statistics for $ListName", $SO);
		
		}
		else
		{
			$SO="";
			$sx=MakeLink("stats?Action=ListOverview&ListID=$ListID&Open=SENDS","OPEN");
		}
	}




	if(!$ListID){

		//select ListID form!
			$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists ORDER BY ListName DESC");
			
			while($l=mysql_fetch_array($lists))
			{
				if(AllowList($l["ListID"]))
				{
					$numSubs = (int)@mysql_result(@mysql_query("select count(MemberID) from " . $TABLEPREFIX . "members where ListID=" . $l["ListID"]), 0, 0);

					if($numSubs == 1)
						$subs = "1 subscriber";
					else
						$subs = $numSubs . " subscribers";

					$alllists.=$l["ListID"]."->".$l["ListName"]." ($subs);";
				}
			}

			$allreports = "";
			$allreports .= "1->Signup Time + Day;";
			$allreports .= "2->Subscriber Details;";
			$allreports .= "3->Send Statistics;";

			$req = "<span class=req>*</span> ";		

			$FORM_ITEMS[$req . "Mailing List"]="select|ListID:5:$alllists";
			$HELP_ITEMS["ListID"]["Title"] = "Mailing List";
			$HELP_ITEMS["ListID"]["Content"] = "Which mailing list would you like to view statistics for? Simply choose it from this list.";

			$FORM_ITEMS[$req . "Report"]="select|ReportType:1:$allreports";
			$HELP_ITEMS["ReportType"]["Title"] = "Report Type";
			$HELP_ITEMS["ReportType"]["Content"] = "Which type of report would you like to view? The &quot;Signup Time + Day&quot; report shows signup statistics by the hour and day. The &quot;Subscriber Details&quot; report shows subscriber count details, active subscribers, etc. The &quot;Send Statistics&quot; report shows details on each newsletter, including open rates and send times.";

			$FORM_ITEMS["-1"]="submit|Continue to Step 2";

			$FORM=new AdminForm;
			$FORM->title="SelectList";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("stats?Action=ListOverview");
			$FORM->MakeForm("Report Options");

			$FORM->output = "Which type of report would you like to generate?<br>Complete the form below then click on the \"Continue to Step 2\" button to continue." . $FORM->output;
						
			$OUTPUT.=MakeBox("Reports (Step 1 of 2)",$FORM->output);
			$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{
						var f = document.forms[0];

						if(f.ListID.selectedIndex == -1)
						{
							alert("Please select a list to work with first.");
							f.ListID.focus();
							return false;
						}
					}
				
				</script>
		';
	}

?>