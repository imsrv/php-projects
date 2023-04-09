<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    merge.php - HTML templates for outputs of merge screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format final form with topics listing for selection
//  Parameters: TopicDetails(Array), ActionButtons(string)
//  Return: HTML
function getMergeFormHTML($topic,$buttons){
		global $GlobalSettings,$Language,$VARS,$Document;
		if(!$topic[availableTopics]){
			$buttons="<SPAN CLASS=ERROR>$Language[Badmerge]</SPAN>";
			$topic[topicsListing]="<OPTION>[$Language[None]]</OPTION>";
		}
		$contents .= <<<EOF
				<P ALIGN="CENTER">
				&nbsp; $Document[msg]
				</P>
				<FORM ACTION="$Document[mainScript]" METHOD="POST" ENCTYPE="multipart/form-data">
				<INPUT TYPE="HIDDEN" NAME="mode" VALUE="merge">	
				<INPUT TYPE="HIDDEN" NAME="action" VALUE="merge">	
				<INPUT TYPE="HIDDEN" NAME="topicId" VALUE="$topic[topicId]">
				<INPUT TYPE="HIDDEN" NAME="forumId" VALUE="$topic[forumId]">
				<INPUT TYPE="HIDDEN" NAME="newForumId" VALUE="$topic[newForumId]">
				<TABLE CELLPADDING="5">
				<TR>
					<TD CLASS="TDStyle">					
						 $Language[Merge] $Language[Topic]: 
					</TD>
					<TD CLASS="TDStyle">	
						<STRONG>$topic[subject]</STRONG> 	
						$Language[in] 		$Document[forumName]	
					</TD>
				</TR>
				<TR>
					<TD COLSPAN="2">&nbsp;</TD>
				</TR>
				<TR>
					<TD CLASS="TDStyle">					
						$Language[WithTopic]:
					</TD>
					<TD CLASS="TDStyle">					
						<SELECT NAME="newTopicId">
							$topic[topicsListing]
						</SELECT>
						$Language[in] $topic[newForumName]
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
}//getMergeFormHTML

//  Format form with forums listing for selection
//  Parameters: TopicDetails(Array), ActionButtons(string)
//  Return: HTML
function getPreMergeHTML($topic,$buttons){
	global $GlobalSettings,$Language,$VARS,$Document;
	$contents=<<<EOF

	<P ALIGN="CENTER">
		&nbsp; $Document[msg]
	</P>
	<FORM ACTION="$Document[mainScript]" METHOD="POST" ENCTYPE="multipart/form-data">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="merge">	
	<INPUT TYPE="HIDDEN" NAME="topicId" VALUE="$topic[topicId]">
	<INPUT TYPE="HIDDEN" NAME="forumId" VALUE="$topic[forumId]">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="select">
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
			$Language[From]:
		</TD>
		<TD CLASS="TDStyle">						
			 $Document[boardName]: $Document[forumName]
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">					
			$Language[Selectforum]:
		</TD>
		<TD CLASS="TDStyle">					
			<SELECT NAME="newForumId">
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
EOF;
		return $contents;
}//getPreMergeHTML


?>