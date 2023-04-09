<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    register.php - HTML templates for outputs of registration screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format registration form
//  Parameters:  Errors(Array)
//  Return: HTML
function getRegisterFormHTML($errorFields,$image){
	global $GlobalSettings,$Language,$VARS,$Document;
	extract ($VARS,EXTR_OVERWRITE);
	
	$IAgreeChecked = $IAgree?"checked":"";
	$contents =commonTableHeader(true,0,300,$Document['title']);
	if(trim($image)){
		$spamGuard=<<<EOF
<TR>
	<TD CLASS="TDStyle">		
		$Language[Verify7DigitCode]:
	</TD>
	<TD CLASS="TDStyle">		
		<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0">
		<TR>
			<TD><INPUT TYPE=TEXT SIZE="15" NAME="code"></TD>
			<TD><IMG SRC="fetchimage.php?$image" VSPACE="0"></TD>
			<TD><SPAN CLASS="Error">$errorFields[code]</SPAN></TD>
		</TR>
		</TABLE>
	</TD>
</TR>
EOF;
	}		
	$contents .= <<<EOF
		<BR />
		<FORM ACTION="$Document[scriptName]" METHOD="POST">
		<INPUT TYPE="HIDDEN" NAME="mode" VALUE="register" />
		<INPUT TYPE="HIDDEN" NAME="action" VALUE="final" />
		<TABLE ALIGN="CENTER" CELLPADDING="0" CELLSPACING="4" BORDER="0">
		<TR>
			<TD CLASS="TDStyle" COLSPAN="2">$Language[RegisterInstruction]</TD>
		</TR>			
		<TR>
			<TD></TD>
			<TD CLASS="TDStyle"><BR/>$errorFields[fieldsincomplete]</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				$Language[Email]:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="TEXT" NAME="email" SIZE="35" VALUE="$email" MAXLENGTH="100" /> <SPAN CLASS="Error">$errorFields[email]</SPAN>
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				$Language[FullName]:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="TEXT" NAME="name" SIZE="35" VALUE="$name" MAXLENGTH="40" /> <SPAN CLASS="Error"> $errorFields[name]</SPAN>
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">
				$Language[LoginName]:
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="TEXT" NAME="loginName" SIZE="35" VALUE="$loginName" MAXLENGTH="20" /> <SPAN CLASS="Error">$errorFields[loginName]</SPAN>					
			</TD>
		</TR>
		$spamGuard
		$passwordDetails
		<TR>
			<TD CLASS="TDStyle" ALIGN="RIGHT">
				<SPAN CLASS="Error">$errorFields[IAgree]</SPAN>
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="CHECKBOX" NAME="IAgree" $IAgreeChecked/> <A HREF="$Document[mainScript]?mode=terms">$Language[IAgree]</A>
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle">						
			</TD>
			<TD CLASS="TDStyle">
				<INPUT TYPE="SUBMIT" VALUE="$Language[Register]" CLASS="SubmitButtons" />
			</TD>
		</TR>
		<TR>
			<TD CLASS="TDStyle" COLSPAN="2"><BR/><BR/>
				$Language[Loginnamehelp]
			</TD>
		</TR>
		</TABLE>
		</FORM>
EOF;
	$contents .=commonTableFooter(true,0,"&nbsp;");		
	return $contents;
}//getRegisterFormHTML
	
?>