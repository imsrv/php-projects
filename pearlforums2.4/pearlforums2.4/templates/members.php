<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    members.php - HTML templates for outputs of members' listing.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format top part of members' listing; links & labels
//  Return: HTML
function getTopHTML(){
	global $Language,$Document,$Language,$VARS;
	$chars=array("#","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","R","S","T","U","V","W","X","Y","Z");	
	foreach($chars as $alpha){
		if($VARS[alpha]==$alpha){
			$l="<SPAN CLASS=GreyText>&laquo;</SPAN>";
			$r="<SPAN CLASS=GreyText>&raquo;</SPAN>";
		}
		else{$l=$r='';}
		$links .= "$r<A HREF=\"$Document[mainScript]?mode=members&case=alpha&alpha=$alpha\">$alpha</A>$l &nbsp;";
	}
	$tableHead = commonTableFormatHTML("header",$Document[contentWidth],"CENTER");

	if($VARS['case']=="online")	
		$label=$Language[CurrentlyOnline];
	$contents= <<<EOF
		<BR />
		<TABLE WIDTH="$Document[contentWidth]" CELLSPACING="0" CELLPADDING="0" ALIGN="CENTER" BORDER="0">
		<FORM ACTION="$Document[mainScript]">
		<INPUT TYPE="HIDDEN" NAME="mode" VALUE="members">		
		<INPUT TYPE="HIDDEN" NAME="case" VALUE="search">	
		<TR>
			<TD CLASS="$TDStyle">
				$links			
			</TD>
			<TD CLASS="$TDStyle" ALIGN="RIGHT">
			<INPUT TYPE="TEXT" SIZE="10" NAME="searchText" VALUE="$VARS[searchText]"><INPUT TYPE="SUBMIT" VALUE="$Language[Search]" CLASS="GoButton">
			</TD>
		</TR></FORM>
		</TABLE>
		$tableHead
		<TR>
			<TD CLASS="TitleTR">$Language[Name]</TD>
			<TD CLASS="TitleTR">$Language[Position]</TD>
			<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Messaging]</TD>
			<TD CLASS="TitleTR" ALIGN="CENTER">$Language[Online]</TD>		
		</TR>	
EOF;
	return $contents;
}//getTopHTML

//  Close listing table
//  Return: HTML
function getBottomHTML(){
	$contents= <<<EOF
		</TABLE>
		</TD>
	</TR>
	</TABLE>
EOF;
	return $contents;
}//getBottomHTML

//  Format each row on listing
//  Parameter: MemberDetails(Array)
//  Return: HTML
function getMemberRowHTML($member){
	global $Language,$Document,$Member;
	if($Member['memberId']){
		$messaging=commonGetIconButton("sendmessage","$Language[Sendmessage]","?mode=messages&action=new&loginName=$member[loginName]","");
	}
	else{
		$messaging=commonGetIconImage("sendmessageoff","$Language[Membersonly]");
	}
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=profile&loginName=$member[loginName]">$member[name]</A></TD>
		<TD CLASS="TDStyle">$member[position]</TD>				
		<TD CLASS="TDStyle" ALIGN="CENTER">
			$messaging
		</TD>
		<TD CLASS="TDStyle" ALIGN="CENTER">
			<IMG SRC="images/online$member[online].gif" ALT="$Language[From] $member[ip]" />
		</TD>
	</TR>
EOF;
	return $contents;
}//getMemberRowHTML

//  Display guest row
//  Return: HTML
function getGuestRowHTML($guests){
	Global $Language;
	$contents= <<<EOF
	<TR>
		<TD CLASS="TDStyle" COLSPAN="4">
			$guests $Language[Guests]
		</TD>
	</TR>
EOF;
	return $contents;
}//getGuestRowHTML

?>