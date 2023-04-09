<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    split.php - HTML templates for outputs of topic split screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format form with forums listing for split selection
//  Parameters: TopicDetails(Array), ActionButtons(string)
//  Return: HTML
function getSplitFormHTML($topic,$buttons){
	global $GlobalSettings,$Language,$VARS,$Document;
	$contents .= <<<EOF
	<BR><BR>
	<FORM ACTION="$Document[mainScript]" METHOD="POST" ENCTYPE="multipart/form-data">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="split">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="split">
	<INPUT TYPE="HIDDEN" NAME="postId" VALUE="$topic[postId]">	
	<INPUT TYPE="HIDDEN" NAME="topicId" VALUE="$topic[topicId]">
	<INPUT TYPE="HIDDEN" NAME="preForumId" VALUE="$topic[preForumId]">
	<TABLE>
	<TR>
		<TD CLASS="TDStyle">					
			$Language[Split]
		</TD>
		<TD CLASS="TDStyle">					
			<INPUT NAME="subject" VALUE="$topic[subject]" SIZE="30" />
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">					
			$Language[Asanewtopicin]
		</TD>
		<TD CLASS="TDStyle">					
			<SELECT NAME="forumId">
				$topic[forumsListing]
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">					
		</TD>
		<TD CLASS="TDStyle"><BR /><BR />					
			$buttons
		</TD>
	</TR>				
	</TABLE>
	<BR /><BR />
	<TABLE WIDTH="80%" CLASS="TableStyle">
	<TR>
		<TD CLASS="TDStyle">
			<strong><u>$Language[From] $topic[name]:</u></strong> 
			<BR /><BR />
			$topic[message]
		</TD>
	</TR>
	</TABLE>
	</FORM>
EOF;
		return $contents;
}//getSplitFormHTML

?>