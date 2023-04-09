<? 
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    adminEmails.php - HTML templates for outputs of 
//                  mass email/messaging screens in admin.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Email form 
//  Parameter:  RecipientsList(String)
//  Return: HTML
function getFormHTML($recipients){
	global $Document,$GlobalSettings,$Language,$AdminLanguage;
	$submitButton = commonGetSubmitButton(false,$Language['Send'],"");
	$contents = <<<EOF
	<BR />
	$Document[msg]
	<BR />
	<FORM ACTION="$Document[mainScript]" METHOD="POST">
	<INPUT TYPE="HIDDEN" NAME="mode" VALUE="admin">
	<INPUT TYPE="HIDDEN" NAME="case" VALUE="emails">	
	<INPUT TYPE="HIDDEN" NAME="action" VALUE="send">		
	<TABLE ALIGN="CENTER">
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[SendAs]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="sendAs">
				<OPTION VALUE="emails">$AdminLanguage[Emails]</OPTION>
				<OPTION VALUE="messages">$Language[Messages]</OPTION>
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$AdminLanguage[Recipients]:
		</TD>
		<TD CLASS="TDPlain">
			<SELECT NAME="groupId">
				<OPTION VALUE="">$AdminLanguage[AllMembers]</OPTION>
				$recipients
			</SELECT>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain">
			$Language[Subject]:
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="TEXT" NAME="subject" VALUE="$subject" SIZE="60">
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain" VALIGN="TOP">
			$Language[Message]:
		</TD>
		<TD CLASS="TDPlain">
			<TEXTAREA NAME="message" COLS="60" ROWS="10">$message</TEXTAREA>
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain">			&nbsp;
		</TD>
		<TD CLASS="TDPlain">
			<INPUT TYPE="CHECKBOX" NAME="enableHTML" VALUE="1"> $AdminLanguage[EnableHTMLcodes]
		</TD>
	</TR>	
	<TR>
		<TD CLASS="TDPlain" VALIGN="TOP">
		</TD>
		<TD CLASS="TDPlain">
			$submitButton
		</TD>
	</TR>	
	</TABLE>
	</FORM>
EOF;
	return $contents;
}//getFormHTML

?>
