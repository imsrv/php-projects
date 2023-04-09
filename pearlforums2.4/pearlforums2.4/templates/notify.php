<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    notify.php - HTML templates for outputs of notification screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format quick search form
//  Return: HTML
function getSearchFormHTML(){
	global $Language,$Document,$VARS;
		$contents=<<<EOF
		<BR/>
		<TABLE WIDTH="80%" CELLPADDING="0" CELLSPACING="0" BORDER="0">
		<FORM ACTION="$Document[mainScript]">
		<INPUT TYPE="HIDDEN" NAME="mode" VALUE="notify">
		<TR>
			<TD CLASS="TDStyle" ALIGN="RIGHT">
			$Language[Keywords]:<INPUT TYPE="TEXT" SIZE="10" NAME="searchText" VALUE="$VARS[searchText]"><INPUT TYPE="SUBMIT" VALUE="$Language[Search]" CLASS="GoButton">
			</TD>
		</TR></FORM>			
		</TABLE>		
EOF;
	return $contents;
}//getSearchFormHTML

//  Column labels on listings
//  Return: HTML
function getTitleRowHTML(){
	global $Language,$Document;
	$contents .= <<<EOF
		<TR>
			<TD CLASS="TitleTR" WIDTH="60%">$Language[Topic]</TD>
			<TD CLASS="TitleTR">$Language[StartedBy]</TD>
			<TD CLASS="TitleTR" WIDTH="5%">$Language[Remove]</TD>
		</TR>
EOF;
	return $contents;
}//getTitleRowHTML

//  Format each row on listing
//  Parameter: NotifyDetails(Array)
//  Return: HTML
function getNotifyRowHTML($notify){
	global $Language,$Document;
	$button= commonGetIconButton("delete","$Language[Remove]","?mode=notify&action=remove&topicId=$notify[topicId]&case=list",$confirmation);
	$contents .= <<<EOF
			<TR>
				<TD CLASS="TDStyle" WIDTH="60%"><A HREF="$Document[mainScript]?mode=topics&topicId=$notify[topicId]">$notify[subject]</A></TD>
				<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=profile&loginName=$notify[loginName]">$notify[name]</A></TD>
				<TD CLASS="TDStyle" WIDTH="5%" ALIGN="CENTER">$button</TD>
			</TR>
EOF;
	return $contents;
}//getNotifyRowHTML

//  Format form for notify or remove notified topic
//  Parameters: OnNotifyList?(boolean)
//  Return: HTML
function getNotifyFormHTML($on){
		global $GlobalSettings,$Language,$VARS,$Document,$Member;
		
		if($on){
			$msg=$Language['Notifyontext'];
			$button=commonGetSubmitButton(false,$Language[Remove],$confirm);
			$hiddenAction="Remove";
		}
		else{
			$msg=$Language['Notifyofftext'];
			$button=commonGetSubmitButton(false,$Language[Notify],$confirm);
			$hiddenAction="Notify";
		}
		$contents .= <<<EOF
		<TABLE ALIGN="CENTER">
		<TR>
			<TD CLASS="TDStyle" ALIGN="CENTER"><BR />
				<P ALIGN="CENTER">
				&nbsp; $msg
				</P>
				<FORM ACTION="$Document[mainScript]" METHOD="POST">
				<INPUT TYPE="HIDDEN" NAME="mode" VALUE="notify">	
				<INPUT TYPE="HIDDEN" NAME="topicId" VALUE="$VARS[topicId]">
				<INPUT TYPE="HIDDEN" NAME="action" VALUE="$hiddenAction">
				<TABLE CELLPADDING="5">
				<TR>
					<TD CLASS="TDStyle">					
						$Language[Topic]: 
					</TD>
					<TD CLASS="TDStyle">	
						<STRONG>$Document[topicSubject]</STRONG> 							
					</TD>
				</TR>
				<TR>
					<TD CLASS="TDStyle">					
						$Language[Email]: 
					</TD>
					<TD CLASS="TDStyle">	
						<STRONG>$Member[email]</STRONG> 							
					</TD>
				</TR>
				<TR>
					<TD COLSPAN="2">&nbsp;</TD>
				</TR>
				<TR>
					<TD CLASS="TDStyle">					
					</TD>
					<TD CLASS="TDStyle">				
						$button
					</TD>
				</TR>				
				</TABLE>
				<BR />
				</FORM>
			</TD>
		</TR>
		</TABLE>
EOF;
		return $contents;
}//getNotifyHTML


?>