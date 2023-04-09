<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    poll.php - HTML templates for outputs of poll screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format poll for display in either vote or results mode
//  Parameter: TopicId(integer)
//  Return: HTML
function getPollDisplayHTML($topicId){
	global $GlobalSettings,$Document,$Language,$Member,$VARS;
	extract($GlobalSettings,EXTR_PREFIX_ALL,"Global");
	$graphWidth=200;
	$Member[memberId]=$Member[memberId]==""?0:$Member[memberId];
	
	$fetchedData=mysql_query("select pollId,topicId,question,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,
	voted1,voted2,voted3,voted4,voted5,voted6,voted7,voted8,voted9,voted10,startDate,endDate,status from {$Global_DBPrefix}Polls where topicId=$topicId");
	$dataSet = mysql_fetch_array($fetchedData);

	$fetchedData=mysql_query("select pollId,optionId,votedDate from {$Global_DBPrefix}PollVotes where pollId=$dataSet[pollId] and memberId=$Member[memberId]");
	$dataSet2 = mysql_fetch_array($fetchedData);	
	$voting=$dataSet2[optionId] || $VARS[view] || $Member[memberId]=="0"?false:true;
		
	$buttonVote = commonGetSubmitButton(false,$Language['Vote'],$confirm);
	$buttonView = commonLanguageButton("viewresults",$Language['Viewresults'],"?mode=topics&topicId=$topicId&view=1","");

	if($voting && $dataSet[status]){//vote mode
		for($i=1;$i<11;$i++){//get options
			$option=$dataSet["option{$i}"];
			if(trim($option)!=""){
				$options .="<INPUT TYPE=\"RADIO\" NAME=\"option\" VALUE=\"$i\">$option <BR />";
			}
		}
		$contents=<<<EOF
	<FORM ACTION="$Document[mainScript]" METHOD="POST">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="poll">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="Vote">
	<INPUT TYPE="HIDDEN" NAME="pollId" VALUE="$dataSet[pollId]">
	<INPUT TYPE="HIDDEN" NAME="topicId" VALUE="$dataSet[topicId]">
	<TABLE WIDTH="400" STYLE="border-style:dashed;border-color:#BFC4BF;border-width:3px" CELLPADDING="3" CELLSPACING="0">
	<TR>
		<TD CLASS="TDStyle" COLSPAN="2"><BR />
			<STRONG>$dataSet[question]</STRONG> <BR /><BR />
			$options
		<BR />
		</TD>
	</TR>
	<TR>
		<TD>
			$buttonVote <BR /><BR />
		</TD>
		<TD ALIGN="RIGHT"><BR />
			$buttonView
		</TD>
	</TR></FORM>
	</TABLE>		
	<BR />
EOF;
	}
	else{//results mode
		$optionValues=array();
		$optionNames=array();
		$total=0;
		for($i=1;$i<11;$i++){//get option names & vote counts
			$option=$dataSet["option{$i}"];
			if(trim($option)!=""){
			 	$optionValues["$i"] = $dataSet["voted{$i}"];				 
				$optionNames["$i"]= $option;
				$total += $dataSet["voted{$i}"];
			}
		}	
		while(list($i,$option)=each($optionNames)){//calculate options for graphing
			$votes=$optionValues[$i];
			if($total){
				$pc=($votes/$total) * 100;
				$pc=is_float($pc)?number_format($pc,1):$pc;
				$bar=($votes/$total) * $graphWidth;
			}
			$results .= <<<EOF
			<TR>
				<TD CLASS="TDStyle">$option</TD>
				<TD><IMG SRC="images/poll$i.gif" WIDTH="$bar" HEIGHT="15"></TD>
				<TD CLASS="TDStyle">$pc%</TD>
			</TR>
EOF;
		}
		$status=$dataSet[status]?"": "[$Language[Pollclosed]]";
		$contents=<<<EOF
	<TABLE WIDTH="400" STYLE="border-style:dashed;border-color:#BFC4BF;border-width:3px" CELLPADDING="3" CELLSPACING="0">
	<TR>
		<TD CLASS="TDStyle"><BR />
		<STRONG>$dataSet[question]</STRONG> <BR /><BR />
		<TABLE>		
		$results
		<TR>
			<TD COLSPAN="3" CLASS="TDStyle"><BR />
				<STRONG>$Language[Total]: $total  $Language[votes]</STRONG><BR />
				$status				
			</TD>
		</TR>
		</TABLE>
		<BR />
		
		</TD>
	</TR>
	</TABLE>	
	<BR />	
EOF;
	}
	return $contents;
}//getPollDisplayHTML

//  Format form for editing or creating new record.  Called by post.php
//  Parameters: EditMode?(integer|null)
//  Return: HTML
function getPollFormHTML($edit){
	global $Language, $Document,$VARS,$Member;
	extract($VARS,EXTR_OVERWRITE);
	
	if($edit)
		$button = $status? commonLanguageButton("closepoll",$Language[Close],"?mode=poll&topicId=$topicId&action=close",""):$button = commonLanguageButton("openpoll",$Language[Open],"?mode=poll&topicId=$topicId&action=open","");
	
	$contents=<<<EOF
		<TABLE STYLE="border-style:dashed;border-color:#BFC4BF;border-width:3px" CELLPADDING="3" CELLSPACING="0">
		<TR>
			<TD CLASS="TDStyle" COLSPAN="5">
				<U><STRONG>$Language[Question]:</STRONG></U><BR>
				<TEXTAREA NAME="question" STYLE="width:390" COLS="60" ROWS="3">$question</TEXTAREA>			
			</TD>			
		</TR>
		<TR>
			<TD CLASS="TDStyle" COLSPAN="5">
				<U>$Language[Options]:</U>
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				1:<INPUT TYPE="TEXT" NAME="option1" VALUE="$option1" STYLE="width:150">
			</TD>
			<TD CLASS="TDStyle">
				<SPAN CLASS="GreyText">[$voted1]</SPAN>
			</TD>					
			<TD CLASS="TDStyle" WIDTH="20">
				&nbsp;
			</TD>
			<TD CLASS="TDStyle" ALIGN="RIGHT">
				6:<INPUT TYPE="TEXT" NAME="option6" VALUE="$option6" STYLE="width:150">
			</TD>
			<TD CLASS="TDStyle">
				<SPAN CLASS="GreyText">[$voted6]</SPAN>
			</TD>						
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				2:<INPUT TYPE="TEXT" NAME="option2" VALUE="$option2" STYLE="width:150">
			</TD>
			<TD CLASS="TDStyle">
				<SPAN CLASS="GreyText">[$voted2]</SPAN>
			</TD>					
			<TD CLASS="TDStyle" WIDTH="20">
				&nbsp;
			</TD>
			<TD CLASS="TDStyle" ALIGN="RIGHT">
				7:<INPUT TYPE="TEXT" NAME="option7" VALUE="$option7" STYLE="width:150">
			</TD>
			<TD CLASS="TDStyle">
				<SPAN CLASS="GreyText">[$voted7]</SPAN>
			</TD>						
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				3:<INPUT TYPE="TEXT" NAME="option3" VALUE="$option3" STYLE="width:150">
			</TD>
			<TD CLASS="TDStyle">
				<SPAN CLASS="GreyText">[$voted3]</SPAN>
			</TD>					
			<TD CLASS="TDStyle" WIDTH="20">
				&nbsp;
			</TD>
			<TD CLASS="TDStyle" ALIGN="RIGHT">
				8:<INPUT TYPE="TEXT" NAME="option8" VALUE="$option8" STYLE="width:150">
			</TD>
			<TD CLASS="TDStyle">
				<SPAN CLASS="GreyText">[$voted8]</SPAN>
			</TD>						
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				4:<INPUT TYPE="TEXT" NAME="option4" VALUE="$option4" STYLE="width:150">
			</TD>
			<TD CLASS="TDStyle">
				<SPAN CLASS="GreyText">[$voted4]</SPAN>
			</TD>					
			<TD CLASS="TDStyle" WIDTH="20">
				&nbsp;
			</TD>
			<TD CLASS="TDStyle" ALIGN="RIGHT">
				9:<INPUT TYPE="TEXT" NAME="option9" VALUE="$option9" STYLE="width:150">
			</TD>
			<TD CLASS="TDStyle">
				<SPAN CLASS="GreyText">[$voted9]</SPAN>
			</TD>						
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				5:<INPUT TYPE="TEXT" NAME="option5" VALUE="$option5" STYLE="width:150">
			</TD>
			<TD CLASS="TDStyle">
				<SPAN CLASS="GreyText">[$voted5]</SPAN>
			</TD>					
			<TD CLASS="TDStyle" WIDTH="20">
				&nbsp;
			</TD>
			<TD CLASS="TDStyle" ALIGN="RIGHT">
				10:<INPUT TYPE="TEXT" NAME="option10" VALUE="$option10" STYLE="width:150">
			</TD>
			<TD CLASS="TDStyle">
				<SPAN CLASS="GreyText">[$voted10]</SPAN>
			</TD>						
		</TR>			
		<TR>
			<TD COLSPAN="5"><BR/>$button</TD>
		</TR>	
		</TABLE>
		<BR/>
EOF;
	return $contents;	
}//getPollFormHTML

//  Format HTML for final message and auto redirect back to topic
//  Parameter: TopicId(integer), Message(String), RedirectTime(integer)
//  Return: HTML
function getVotedHTML($topicId,$msg,$redirectTime){
	global $Language, $Document,$VARS;
	extract($VARS,EXTR_OVERWRITE);
	$redirectTime=$redirectTime * 1000;
	$contents = commonTableFormatHTML("header","100%","CENTER");
	$heading=commonWhiteTableBoxHTML(300,$Language[Poll]);
	$contents .= <<<EOF
<TR>
	<TD CLASS="MainTR" ALIGN="CENTER">
		$heading
	</TD>
</TR>
<TR>
	<TD CLASS="TDStyle" ALIGN="CENTER"><BR/><BR/>
		$msg
		<script language="javascript">
			setTimeout("forward()",$redirectTime);
			function forward(){
				location = '$Document[mainScript]?mode=topics&topicId=$topicId&page=x&nl=1';
			}
		</script>				
		<BR/><BR/>
	</TD>		
</TR>
	
EOF;
	$contents .= commonTableFormatHTML("footer","","");
	return $contents;
}//getVotedHTML

?>