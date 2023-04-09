<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    move.php - HTML templates for outputs of topic move screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////


//  Format final form with forums listing for selection
//  Parameters: TopicDetails(Array), ActionButtons(string)
//  Return: HTML
function getMoveFormHTML($topic,$buttons){
	global $GlobalSettings,$Language,$VARS,$Document;
	$contents .= <<<EOF
	<P ALIGN="CENTER">
		&nbsp; $Document[msg]
	</P>
	<FORM ACTION="$Document[mainScript]" METHOD="POST" ENCTYPE="multipart/form-data">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="move">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="move">	
	<INPUT TYPE="HIDDEN" NAME="topicId" VALUE="$topic[topicId]">
	<INPUT TYPE="HIDDEN" NAME="preForumId" VALUE="$topic[preForumId]">
	<TABLE CELLPADDING="5">
	<TR>
		<TD CLASS="TDStyle">					
			 $Language[Topic]: 
		</TD>
		<TD CLASS="TDStyle">	
			<STRONG>$topic[subject]</STRONG> 				
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">					
			$Language[From] $Language[Forum]:
		</TD>
		<TD CLASS="TDStyle">						
			 $Document[boardName]: $Document[forumName]
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">					
			$Language[Move] $Language[To]:
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
	</FORM>
EOF;
		return $contents;
}//getMoveFormHTML

?>