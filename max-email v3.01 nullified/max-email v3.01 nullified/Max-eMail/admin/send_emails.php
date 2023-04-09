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
include "../config.inc.php";

	$send=mysql_fetch_array(mysql_query("SELECT * FROM sends WHERE SendID='$SendID'"));
		if($send[AdminID]!=$AdminID){
				echo "You are not authorised to use this send!";
				exit;
		}
		
		if(!$send[StartTime]){
			mysql_query("UPDATE sends SET StartTime='".time()."' WHERE SendID='$SendID'");
		}
		
if(!$Page){
//print the frames layout page

echo '<HTML>
<HEAD>
<TITLE>Sending Emails...</TITLE>
</HEAD>
<frameset rows="125,175" border="0">
<frame name="info" src="send_emails?SendID='.$SendID.'&Page=info">
<frame name="sending" src="send_emails?SendID='.$SendID.'&Page=sending">
</frameset>
</HTML>';

}elseif($Page=="info"){
//print the info (top) frame out!
	
	$send=mysql_fetch_array(mysql_query("SELECT * FROM sends WHERE SendID='$SendID'"));
	$failed=mysql_num_rows(mysql_query("SELECT * FROM send_recipients WHERE Failed='1' && SendID='$SendID'"));
	if($failed==0){$failed=$send[Failed];}
	if($send[Completed]){
		echo '<HTML>
	<style type="text/css">
   .admintext{font-size:12; text-decoration:none; color:black}
	</style>
	<BODY bgcolor="#B0C0D0">
	<span class="admintext">
	<CENTER><B>:: Send Completed ::</B></CENTER></span><TABLE WIDTH="100%">
	<TR><TD align="right"><span class="admintext">Sending started at: </td><td><span class="admintext">'.PrintableDate($send[StartTime]).' at '.date("g:iA", $send[StartTime]).'</td></tr>
		<TR><TD align="right"><span class="admintext">Sending finished at: </td><td><span class="admintext">'.PrintableDate($send[FinishTime]).' at '.date("g:iA", $send[FinishTime]).'</td></tr>
	<TR><TD align="right"><span class="admintext">Time Taken: </td><td><span class="admintext">';
		$et=$send[FinishTime]-$send[StartTime];
			$m=round($et/60);		
			echo $m.' minutes (approx)';
			//calculate sent and remaining.
			$totalsent=$send[Done]+$send[Failed];
			$remaining=0;
	}else{
	echo '<HTML>
	<style type="text/css">
   .admintext{font-size:12; text-decoration:none; color:black}
	</style>
	<BODY bgcolor="#B0C0D0">
	<span class="admintext">
	<CENTER><B>:: Send Info ::</B></CENTER></span><TABLE WIDTH="100%">
	<TR><TD align="right"><span class="admintext">Emails Remaining to be sent: </td><td><span class="admintext">'.mysql_num_rows(mysql_query("SELECT * FROM send_recipients WHERE SendID='$SendID' && Failed='0'")).' ('.($send[Done]+$failed).' already sent)</td></tr>
	<TR><TD align="right"><span class="admintext">Sending started at: </td><td><span class="admintext">'.PrintableDate($send[StartTime]).' at '.date("g:iA", $send[StartTime]).'</td></tr>
	<TR><TD align="right"><span class="admintext">Elapsed time: </td><td><span class="admintext">';
		$et=time()-$send[StartTime];
			$m=round($et/60);		
			echo $m.' minutes (approx)';
			$totalsent=$send[Done]+$failed;
			$remaining=mysql_num_rows(mysql_query("SELECT * FROM send_recipients WHERE SendID='$SendID' && Failed='0'"));
	}
		echo '
	</td></tr>';
	//now do the progress bar!
		//calcs!
		$total=$totalsent+$remaining;
			$per=round(($totalsent/$total)*100);
			$width=$per*3;
			$width2=300-$width;
				if($per>50){
				$info='<span class="admintext"><font color="white">'.$per.'% Complete&nbsp;</span>';
				}else{
				$info2='<span class="admintext">&nbsp;'.$per.'% Complete</span>';
				}
	echo '<tr><td colspan="2"><center>';
	echo '<table cellspacing="0" height="20"><TR><td align=right bgcolor="#006699" width="'.$width.'">'.$info.'</td><td width="'.$width2.'">'.$info2.'</td></tr></table>';
	echo '</center></td></tr></TABLE></BODY>
	</HTML>';
	


}elseif($Page=="sending"){
//do the send (bottom) frame.
	$send=mysql_fetch_array(mysql_query("SELECT * FROM sends WHERE SendID='$SendID'"));
	$max_ex=get_cfg_var("max_execution_time");
	$totalex=0;
	$startex=time();
	$ListID=$send[ListID];
	$list_info=list_info($ListID);
	
	while(($totalex+5)<$max_ex && $done<$send[PerExec] && mysql_num_rows(mysql_query("SELECT * FROM send_recipients WHERE SendID='$SendID' && Failed='0'"))){
		//send one email!
			//get the next member to send to from the db!
			$mem=mysql_fetch_array(mysql_query("SELECT * FROM send_recipients WHERE SendID='$SendID' && Failed='0' LIMIT 1"));
			$member=filter_members(list_info($ListID), "x-unique == ".$mem[UniqueKey], parse_member_list(list_info($ListID), get_list_members($ListID)));
			$member=current($member);
			$members_email=$member["x-email"];
			
			$comp=mysql_fetch_array(mysql_query("SELECT * FROM composed_emails WHERE ComposeID='".$send[ComposeID]."'"));
			//get the email to send!
			if($mem[Format]=="html"){
				$the_message=$comp[HTML_Version];
				$Subject=$comp[HTML_Subject];
				$ContentType="text/html";
			}elseif($mem[Format]=="multi"){
				$the_message='--=======kuomAenidraNShmlimisdsddsdssdfkwaqlewlibik=======
				Content-Type: text/plain; charset="iso-8859-1"
				Content-Transfer-Encoding: 8bit

				'.$comp[Text_Version].'
				--=======kuomAenidraNShmlimisdsddsdssdfkwaqlewlibik=======
				Content-Type: text/html; charset="iso-8859-1"
				Content-Transfer-Encoding: 7bit

				'.$comp[HTML_Version].'
				--=======kuomAenidraNShmlimisdsddsdssdfkwaqlewlibik=======--';
			$ContentType='multipart/alternative; boundary="=======kuomAenidraNShmlimilibik======="';
			}else{
				$the_message=$comp[Text_Version];		
				$Subject=$comp[Text_Subject];	
				$ContentType="text/plain; charset=US-ASCII";
			}
		
			//now parse the email!
			$the_message=ParseFields($ListID, $the_message, $member);
			$Subject=ParseFields($ListID, $Subject, $member);
			
			//now make the headers!
			$bounce=mysql_fetch_array(mysql_query("SELECT * FROM bounce_addresses WHERE BounceAddressID='".$list_info[BounceAddressID]."'"));
			$bounce=$bounce[EmailAddress];
			$headers.='From: "'.$send[FromName].'"<'.$send[FromEmail].'>'."\nReturn-Path: <".$bounce.">\nX-Mailer: Max-eMail V3 Elite\nMime-Version: 1.0\nContent-Type: $ContentType\nBounce-To:<".$bounce.">\n";
				
				
			//send the email!
			if(SendEmail($member["x-email"], $Body, $Headers, $SendID, $Subject)==1){
				mysql_query("DELETE FROM send_recipients WHERE UniqueKey='".$member["x-unique"]."' && SendID='$SendID'");
				mysql_query("UPDATE sends SET Done=Done+1 WHERE SendID='$SendID'");
			}else{
				mysql_query("UPDATE send_recipients SET Failed='1' WHERE UniqueKey='".$member["x-unique"]."' && SendID='$SendID'");
			}
			
		//end sending one email!
		$done++;
		$totalex=time()-$startex;
	}
	
	if(mysql_num_rows(mysql_query("SELECT * FROM send_recipients WHERE SendID='$SendID' && Failed='0'"))==0){
						$failed=mysql_num_rows(mysql_query("SELECT * FROM send_recipients WHERE Failed='1' && SendID='$SendID'"));
						$send=mysql_fetch_array(mysql_query("SELECT * FROM sends WHERE SendID='$SendID'"));
						if($failed>0){$add="Failed='$failed',";}
						if(!$send[Completed]){
						mysql_query("UPDATE sends SET Completed='1', $add FinishTime='".time()."' WHERE SendID='$SendID'");
						}
						mysql_query("DELETE FROM send_recipients WHERE SendID='$SendID'");
			echo '<style type="text/css">
  				 .admintext{font-size:12; text-decoration:none; color:black}
				</style><font face="verdana" sze="3" color="red"><center>SEND COMPLETED!</font>';
						$send=mysql_fetch_array(mysql_query("SELECT * FROM sends WHERE SendID='$SendID'"));						
			echo '<P><span class="admintext">'.$send[Done].' emails sent successfully, with '.$send[Failed].' unable to be sent!</center></span>';
			echo '<script language="javascript">
	  			parent.frames[0].location="send_emails.php?Page=info&SendID='.$SendID.'"  
			</script><P>
			
			';
	}else{
	//now print the move on to next page command!
	echo '<script language="javascript">
	  parent.frames[0].location="send_emails.php?Page=info&SendID='.$SendID.'"  
	window.location="send_emails.php?Page=sending&SendID='.$SendID.'"
	</script>';
	}

}
		








?>