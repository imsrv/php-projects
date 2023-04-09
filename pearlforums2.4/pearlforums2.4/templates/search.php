<? 
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    search.php - HTML templates for outputs of search screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format results header, with quicksearch box & column labels
//  Return: HTML
function getResultsHeaderHTML(){
	global $Language,$Document,$Language,$VARS;

	$tableHead = commonTableFormatHTML("header",$Document[contentWidth],"CENTER");
	$quickSearch=commonQuickSearch();
	$contents= <<<EOF
		<BR />
		<TABLE WIDTH="$Document[contentWidth]" BORDER="0" CELLSPACING="0" CELLPADDING="0">
		<TR>
			<TD ALIGN="RIGHT">
				$quickSearch
			</TD>
		</TR>
		</TABLE>		
		$tableHead
		<TR>
			<TD CLASS="TitleTR"></TD>
			<TD CLASS="TitleTR">$Language[Subject]</TD>
			<TD CLASS="TitleTR">$Language[Date]</TD>
			<TD CLASS="TitleTR">$Language[PostedBy]</TD>		
		</TR>	
EOF;
	return $contents;

}//getResultsHeaderHTML

//  Format each row on results listing
//  Parameter: PostDetails(Array)
//  Return: HTML
function getResultRowHTML($post){
	global $Document;
	$post[datePosted]=commonTimeFormat(false,$post[postDate]);
	$contents=<<<EOF
		<TR>
			<TD CLASS="TDStyle">$post[number]</TD>
			<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=topics&action=forward&topicId=$post[topicId]&postId=$post[postId]">$post[subject]</A></TD>
			<TD CLASS="TDStyle">$post[datePosted]</TD>
			<TD CLASS="TDStyle"><A HREF="$Document[mainScript]?mode=profile&loginName=$post[loginName]">$post[name]</A></TD>		
		</TR>	
EOF;
	return $contents;

}//getResultRowHTML

//  Format advanced search form 
//  Return: HTML
function getSearchFormHTML(){
	global $Document,$GlobalSettings,$Language,$VARS;
	extract($VARS,EXTR_OVERWRITE);
	$button=commonGetSubmitButton(false,$Language['Search'],$confirmation);
	$contents = <<<EOF
	<BR /><BR />
	<FORM ACTION="$Document[mainScript]">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="search">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="advanced">
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="search">
	<TABLE ALIGN="CENTER">
	<TR>
		<TD CLASS="TDStyle">
			$Language[Keywords]:
		</TD>
		<TD CLASS="TDStyle">
		<INPUT TYPE="TEXT" NAME="searchText" VALUE="$searchText" SIZE="20" />
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">
			$Language[PostedBy]:
		</TD>
		<TD CLASS="TDStyle">
		<INPUT TYPE="TEXT" NAME="name" VALUE="$name" SIZE="20" /> <SPAN CLASS="GreyText">[$Language[Optional]]</SPAN>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">
			$Language[PostsOlderThan]:
		</TD>
		<TD CLASS="TDStyle"><INPUT TYPE="TEXT" NAME="time" VALUE="$time" SIZE="8" />
		<SELECT NAME="timeSpan">
			<OPTION VALUE="7">$Language[weeks]</OPTION>
			<OPTION VALUE="30">$Language[months]</OPTION>
			<OPTION VALUE="365">$Language[years]</OPTION>
		</SELECT> <SPAN CLASS="GreyText">[$Language[Optional]]</SPAN>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">
			$Language[Forum]:
		</TD>
		<TD CLASS="TDStyle">
		<SELECT NAME="forumId">
			<OPTION VALUE="0">$Language[All]</OPTION>
			$forumsList
		</SELECT>	<SPAN CLASS="GreyText">[$Language[Optional]]</SPAN>	
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">
			&nbsp;
		</TD>
		<TD CLASS="TDStyle">
			$button
		</TD>
	</TR>
	</TABLE>
	</FORM>
EOF;
	return $contents;	
}//getSearchFormHTML
?>
