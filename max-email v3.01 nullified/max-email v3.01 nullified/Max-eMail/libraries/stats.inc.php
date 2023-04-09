<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
// Distribution         : via WebForum, ForumRU and associated file dumps   //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////

function FieldListStats($ListID){
	GLOBAL $FULL_OUTPUT, $Fields, $Action, $FilterString;
	
	if($Fields && $Action){
					if($FilterString){
					$FilterString=trim($FilterString);
					$tempmembers=filter_members(list_info($ListID), $FilterString, parse_member_list(list_info($ListID), get_list_members($ListID)));
					}else{
					$tempmembers=parse_member_list(list_info($ListID), get_list_members($ListID));
					}	
			
			foreach($Fields as $f){
				$totalval=0;$t=0;$highestval=0;$lowestval='';
				if($Action=="avg"){
					//calculate average value!
					foreach($tempmembers as $m){
						if($m["x-unique"]){
							$totalval=$totalval+$m[$f];
							$t++;
						}
					}
					$Out[]='The average value of '.$f.' is '.($totalval/$t);
				}elseif($Action=="total"){
					foreach($tempmembers as $m){
						if($m["x-unique"]){
							$totalval=$totalval+$m[$f];
						}
					}
					$Out[]='The total calculated value of '.$f.' is '.$totalval;
				}elseif($Action=="max"){
					foreach($tempmembers as $m){
					if($m["x-unique"]){
						if($m[$f]>$highestval){
							$highestval=$m[$f];
						}
					}}
					$Out[]='The highest value of '.$f.' is '.$highestval;
				}elseif($Action=="min"){
					$lowestval="Unknown";
					foreach($tempmembers as $m){
					if($m["x-unique"]){
						if(($m[$f]<$lowestval || $lowestval=="Unknown") && isset($m[$f])){
							$lowestval=$m[$f];
						}
					}}
					$Out[]='The lowest value of '.$f.' is '.$lowestval;
				}elseif($Action=="value"){
					$TO='<B>Known values of '.$f.'...<BR></B>';
					foreach($tempmembers as $m){
					if($m[$f]){
						$TO.=$m[$f]."<BR>";
					}}
					$Out[]=$TO;
				}
			}
			
			foreach($Out as $O){
				$AllOut.="<P>$O";
			}
	$FULL_OUTPUT.=MakeBox("Field statistics results",$AllOut.'<P>'.MakeLink("stats.php?action=list&page=fields&ListID=$ListID", "Back to field stats main"));
	
	}else{
		$list_fields=list_fields($ListID);
			foreach($list_fields as $f){
				$allfields.=$f."->".$f.";";
			}
		
				$FORM_ITEMS["Filter String"]="textfield|FilterString:200:50::";
				$FORM_ITEMS[-2]="spacer|".MakeLink(MakePopup('filterstring_popup.php',600,400,"FilterBy"),"Filter String Wizard");
				$FORM_ITEMS["Fields"]="checkboxes|Fields:$allfields";
				$FORM_ITEMS["Action"]="select|Action:1:avg->Average;total->Total;max->Maximum Value;min->Minimum Value;value->Print all values";
				$FORM_ITEMS[-1]="submit|Get Stats";
				$FORM=new AdminForm;
				$FORM->title="MemberSearch";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="stats.php?action=list&ListID=$ListID&page=fields";
				$FORM->MakeForm();
				$BO.='Which field(s) would you like to work with?<P>'.$FORM->output;
				
		$FULL_OUTPUT.=MakeBox("Field statistics options", $BO);
	
	}
	
}

function SystemStats(){
	GLOBAL $FULL_OUTPUT;
	
	//lists!
	$BO.='<P><U><B>List Statistics</B></U><BR>';
	$BO.='Number of lists: '.mysql_num_rows(mysql_query("SELECT * FROM lists"));
	$lists=mysql_query("SELECT * FROM lists");
		while($l=mysql_fetch_array($lists)){
			$ListID=$l[ListID];
				$members_array=parse_member_list(list_info($ListID),get_list_members($ListID)); 
			if($members_array){foreach($members_array as $member){
			if($member["x-unique"]){
			$totalmembers++;
			}
			}}
		}
	$BO.='<BR>Total Members: '.$totalmembers;
	
	//banned emails!
	$BO.='<P><U><B>Banned Emails</B></U><BR>';
	$BO.='Number of banned email groups: '.mysql_num_rows(mysql_query("SELECT * FROM banned_groups"));
	$BO.='<BR>Number of banned emails: '.mysql_num_rows(mysql_query("SELECT * FROM banned_emails"));
	
	//templates
	$BO.='<P><U><B>Templates</B></U><BR>';
	$BO.='Number of templates: '.mysql_num_rows(mysql_query("SELECT * FROM templates"));
	
	//autofill!
	$BO.='<P><U><B>AutoFill</B></U><BR>';
	$BO.='Number of AutoFill groups: '.mysql_num_rows(mysql_query("SELECT * FROM autofill_groups"));
	$BO.='<BR>Number of AutoFill fields: '.mysql_num_rows(mysql_query("SELECT * FROM autofill_fields"));
	
	//composed
	$BO.='<P><U><B>Composed Emails</B></U><BR>';
	$BO.='Number of composed emails: '.mysql_num_rows(mysql_query("SELECT * FROM composed_emails"));
	
		//sends
	$BO.='<P><U><B>Email Sending</B></U><BR>';
		$BO.="Total Sends: ".mysql_num_rows(mysql_query("SELECT * FROM sends"));
	$BO.="<BR>In-Complete Sends: ".mysql_num_rows(mysql_query("SELECT * FROM sends WHERE Completed='0'"));
	$times=mysql_query("SELECT FinishTime, StartTime FROM sends WHERE Completed='1'");
		while($t=mysql_fetch_array($times)){
			$alltimes=($t[FinishTime]-$t[StartTime])+$alltimes;
			$x++;
		}
	$BO.="<BR>Average Time Taken: ".round($alltimes/$x,2)." seconds";
	$b=mysql_query("SELECT Done, Failed FROM sends");
		while($bt=mysql_fetch_array($b)){
			$total=$total+$bt[Done];
			$failed=$failed+$bt[Failed];
		}
		$totaltotal=$total+$failed;
	$BO.="<BR>Emails Sent: ".$total;
	$BO.="<BR>Emails Failed: ".$failed." (".(($failed/$totaltotal)*100)."%)";
	
	//saved content!
	$BO.='<P><U><B>Saved Content</B></U><BR>';
	$BO.='Number of content categories: '.mysql_num_rows(mysql_query("SELECT * FROM content_cats"));
	$BO.='<BR>Number of content items: '.mysql_num_rows(mysql_query("SELECT * FROM content_items"));
	
	//images!
	$BO.='<P><U><B>Images</B></U><BR>';
	$BO.='Number of image groups: '.mysql_num_rows(mysql_query("SELECT * FROM image_groups"));
	$BO.='<BR>Number of images: '.mysql_num_rows($im=mysql_query("SELECT * FROM images"));
		while($i=mysql_fetch_array($im)){$totalimsize=$totalimsize+$i[FileSize];}
	$BO.='<BR>Total images size: '.round(($totalimsize/1024)).'Kb';
	
	//links!
	$BO.='<P><U><B>Links</B></U><BR>';
	$BO.='Number of link groups: '.mysql_num_rows(mysql_query("SELECT * FROM link_groups"));
	$BO.='<BR>Number of links: '.mysql_num_rows(mysql_query("SELECT * FROM links"));
	
	$BO.='<P>'.MakeLink("stats.php", "Back to statistics main");
	
	
	$FULL_OUTPUT.=MakeBox("System statistics", $BO);

}



function SendListStats($ListID){
	GLOBAL $FULL_OUTPUT;
	
	$BO.="Total Sends: ".mysql_num_rows(mysql_query("SELECT * FROM sends WHERE ListID='$ListID'"));
	$BO.="<BR>In-Complete Sends: ".mysql_num_rows(mysql_query("SELECT * FROM sends WHERE ListID='$ListID' && Completed='0'"));
	$times=mysql_query("SELECT FinishTime, StartTime FROM sends WHERE ListID='$ListID' && Completed='1'");
		while($t=mysql_fetch_array($times)){
			$alltimes=($t[FinishTime]-$t[StartTime])+$alltimes;
			$x++;
		}
	$BO.="<BR>Average Time Taken: ".round($alltimes/$x,2)." seconds";
	$b=mysql_query("SELECT Done, Failed FROM sends WHERE ListID='$ListID'");
		while($bt=mysql_fetch_array($b)){
			$total=$total+$bt[Done];
			$failed=$failed+$bt[Failed];
		}
		$totaltotal=$total+$failed;
	$BO.="<BR>Emails Sent: ".$total;
	$BO.="<BR>Emails Failed: ".$failed." (".(($failed/$totaltotal)*100)."%)";
				$BO.="<P>".MakeLink("stats.php?action=list&page=charts&ListID=$ListID", "More detailed charts").' | '.MakeLink("stats.php?action=list&ListID=$ListID&page=fields", "Field Stats").' | '.MakeLink("stats.php?action=list&ListID=$ListID", "Basic Stats");
	
	$FULL_OUTPUT.=MakeBox("Send statistics for list!", $BO);
}

function ChartsListStats($ListID){
	GLOBAL $FULL_OUTPUT;
		
	//basic stats!
	$members_array=parse_member_list(list_info($ListID),get_list_members($ListID)); 
		//work out basic stats!
		foreach($members_array as $member){
			if($member["x-unique"]){
			$formats[$member["x-format"]]++;
			$receiving[$member["x-receiving"]]++;
			$totalmembers++;
			}
		}
	
	$BO.="Total Members: ".$totalmembers;	
		
		//formats
			//perc calc!
				@$perhtml=round(($formats[html]/$totalmembers)*100);
				$pertext=100-$perhtml;
			$BO.="<P><B>Format statistics!</B><BR>";
			$BO.='<table><tr><td><center><span class="admintext" font-size:8>'.$perhtml.'%</td><td><center><span class="admintext" font-size:8>'.$pertext.'%</td></tr>
			<tr><td valign="bottom"><span class="admintext" font-size:8><center><img src="images/graph_pixel.gif" width=90 height="'.($perhtml*2).'"></td><td valign="bottom"><span class="admintext" font-size:8><center><img src="images/graph_pixel.gif" width=90 height="'.($pertext*2).'"></td></tr>
			<tr><td><span class="admintext" font-size:8><center>HTML</td><td><span class="admintext" font-size:8><center>Text</td></tr>
			</table>';
		
		//receiving
			//perc calc!
				@$perrec=round(($receiving[yes]/$totalmembers)*100);
				$pernrec=100-$perrec;
			$BO.="<P><B>Receiving statistics!</B><BR>";
			$BO.='<table><tr><td><center><span class="admintext" font-size:8>'.$perrec.'%</td><td><center><span class="admintext" font-size:8>'.$pernrec.'%</td></tr>
			<tr><td valign="bottom"><span class="admintext" font-size:8><center><img src="images/graph_pixel.gif" width=90 height="'.($perrec*2).'"></td><td valign="bottom"><span class="admintext" font-size:8><center><img src="images/graph_pixel.gif" width=90 height="'.($pernrec*2).'"></td></tr>
			<tr><td><span class="admintext" font-size:8><center>Receiving</td><td><span class="admintext" font-size:8><center>Not Receiving</td></tr>
			</table>';
			
			
		
		
		$list_info=list_info($ListID);
		//if we have a joindate field generate reports based on that!
		if($list_info[DateField]){
			$day=time();
			reset($members_array);
			foreach($members_array as $member){
			if($member["x-unique"] && $member[$list_info[DateField]]){
				$tm++;
				$joindate=$member[$list_info[DateField]];
					$days[date("w",$joindate)]++;
			}
			}
		
		$BO.="<P><B>Subscriptions by day of week!</B><BR>";
			$wdays=array(Sun,Mon,Tues,Wed,Thurs,Fri,Sun);
			for($i=0;$i<7;$i++){
				$day=$days[$i];
				if(!$day){$day=0;}
				@$per=round(($day/$tm)*100);
				$tbar.='<td><center><span class="admintext" font-size:8>'.$per.'%</span></td>';
				$bars.='<TD width=50 valign="bottom"><center><img src="images/graph_pixel.gif" width=30 height="'.($per*3).'"></td>';
				$bars2.='<TD><center><span class="admintext" font-size:8>'.$wdays[$i].'</span></td>';
			}
			$bars='<table><tr>'.$tbar.'</tr><tr>'.$bars.'</tr><tr>'.$bars2.'</tr></table>';
			
			$BO.=$bars;
			
			$BO.="<P>".MakeLink("stats.php?action=list&ListID=$ListID", "Basic Stats").' | '.MakeLink("stats.php?action=list&ListID=$ListID&page=sends", "Send Statistics").' | '.MakeLink("stats.php?action=list&ListID=$ListID&page=fields", "Field Stats");
		}
	
		
	$FULL_OUTPUT.=MakeBox("General list stats", $BO);	
}

/////////////////////////////////////////////////////////////

function GeneraListStats($ListID){
	GLOBAL $FULL_OUTPUT;
		
	//basic stats!
	$members_array=parse_member_list(list_info($ListID),get_list_members($ListID)); 
		//work out basic stats!
		foreach($members_array as $member){
			if($member["x-unique"]){
			$formats[$member["x-format"]]++;
			$receiving[$member["x-receiving"]]++;
			$totalmembers++;
			}
		}
	
	$BO.="Total Members: ".$totalmembers;	
		
		//formats
			//perc calc!
				@$perhtml=round(($formats[html]/$totalmembers)*100);
				$pertext=100-$perhtml;
	$BO.="<P><B>Format:</B><BR>HTML: ".$formats[html]." (".$perhtml."%)";	
	$BO.="<BR>Text: ".$formats[text]." (".$pertext."%)";
		
		//receiving
			//perc calc!
				@$perrec=round(($receiving[yes]/$totalmembers)*100);
				$pernrec=100-$perrec;
	$BO.="<P><B>Receiving:</B><BR>HTML: ".$receiving[yes]." (".$perrec."%)";	
	$BO.="<BR>Not Receiving: ".$receiving[no]." (".$pernrec."%)";
		
		$list_info=list_info($ListID);
		//if we have a joindate field generate reports based on that!
		if($list_info[DateField]){
			$day=time();
			reset($members_array);
			foreach($members_array as $member){
			if($member["x-unique"] && $member[$list_info[DateField]]){
				$joindate=$member[$list_info[DateField]];
				$lastweek=0;$lastday=0;$lasthour=0;
				//last week?
				if($joindate>($day-604800) && $joindate<$day){
					$lastweek++;
				}
				
				//last day?
				if($joindate>($day-86400) && $joindate<$day){
					$lastday++;
				}
				
				//last day?
				if($joindate>($day-3600) && $joindate<$day){
					$lasthour++;
				}
				
			}
			}
		
		$BO.="<P><B>Subscriptions:</B> <I>as at ".PrintableDate($day)." ".date("g:iA", $day)."</I><BR>Last Week: $lastweek";
		$BO.="<BR>Last Day: $lastday";	
		$BO.="<BR>Last Hour: $lasthour";	
		}
			$BO.="<P>".MakeLink("stats.php?action=list&page=charts&ListID=$ListID", "More detailed charts").' | '.MakeLink("stats.php?action=list&ListID=$ListID&page=sends", "Send Statistics").' | '.MakeLink("stats.php?action=list&ListID=$ListID&page=fields", "Field Stats");
	
		
	$FULL_OUTPUT.=MakeBox("General list stats", $BO);	
}










?>