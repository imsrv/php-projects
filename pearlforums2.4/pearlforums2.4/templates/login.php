<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    login.php - HTML templates for outputs of login screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////
	
//  Format form for login inputs, plus password retrieval requests
//  Parameters: InvalidLogin?(boolean)
//  Return: HTML
function getLoginFormHTML($invalid,$image){
	global $Language,$Document,$VARS,$HTTP_COOKIE_VARS,$Session;
		
	$errorMsg = $invalid?$Language[InvalidLogin] . ". " . $Language[Pleasetryagain] . "<BR /><BR />":"";
	
	$HTTP_COOKIE_VARS[loginName]=$VARS[loginName]==""?$HTTP_COOKIE_VARS[loginName]:$VARS[loginName];
	$VARS[sessionDuration]=$VARS[sessionDuration]==""?$Document[sessionDuration]:$VARS[sessionDuration];

    $durationListing=durationListing($VARS[sessionDuration]);
	$contents = commonTableHeader(true,0,200,$Language['Login']);
	$retrieveForm=retrieveFormHTML();
	
	if(trim($image)){
		$spamGuard=<<<EOF
<TR>
	<TD CLASS="TDStyle">		
		$Language[Verify7DigitCode]:
	</TD>
	<TD CLASS="TDStyle">		
		<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0">
		<TR>
			<TD><INPUT TYPE=TEXT SIZE="15" NAME="code" VALUE="$code"></TD>
			<TD><IMG SRC="fetchimage.php?$image" VSPACE="0"></TD>
			<TD><SPAN CLASS="Error">$Document[invalidCodeMsg]</SPAN></TD>
		</TR>
		</TABLE>
	</TD>
</TR>
EOF;
	}			
	
	$contents .= <<<EOF
	<FORM ACTION="$Document[mainScript]" METHOD="POST">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="login" />
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="login" />
	<BR /><BR />
	<TABLE CELLPADDING="0" CELLSPACING="5" BORDER="0" ALIGN="CENTER">
	<TR>
		<TD CLASS="Error" COLSPAN="2">
			$errorMsg
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">
			$Language[LoginName]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="TEXT" NAME="loginName" VALUE="$HTTP_COOKIE_VARS[loginName]" SIZE="15" />
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">
			$Language[Password]:
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="PASSWORD" NAME="passwd" VALUE="$VARS[passwd]" SIZE="15" />
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDStyle">
			$Language[Duration]:
		</TD>
		<TD CLASS="TDStyle">
			<SELECT NAME="sessionDuration">
				$durationListing
			</SELECT>
		</TD>
	</TR>	
	$spamGuard	
	<TR>
		<TD CLASS="TDStyle">
		</TD>
		<TD CLASS="TDStyle">
			<INPUT TYPE="SUBMIT" VALUE="$Language[Login]" CLASS="GoButton">
		</TD>
	</TR>										
	</TABLE>
	</FORM>
	<BR/>
	$retrieveForm
	<BR/>
EOF;
	$contents .= commonTableFooter(true,0,"&nbsp;");
	return $contents;		
}//getLoginFormHTML
	
?>