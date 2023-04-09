<?
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    password.php - HTML templates for outputs of password screens.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

//  Format for results HTML after password change for auto login
//  Return: HTML
function getAutoLoginHTML(){
	global $GlobalSettings,$Language,$VARS,$Document,$HTTP_COOKIE_VARS;
	extract ($VARS,EXTR_OVERWRITE);
	$Document[quicklogin]=commonQuickLoginPanel("");
	$contents .= <<<EOF

	<TABLE  ALIGN="CENTER" CELLPADDING="10">
	<TR>
		<TD CLASS="TDPlain" ALIGN="CENTER"><BR/>
			$Language[Recordupdated]
			<BR/><BR/>
			<STRONG>$Language[Login]</STRONG>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain" VALIGN="TOP">
			$Document[quicklogin]
			<script language="javascript">
				document.login.submit();
			</script>
		</TD>
	</TR>
	</TABLE>	
	<BR/><BR/>
EOF;
	return $contents;
}//getAutoLoginHTML

//  Format form for retrieving secret code
//  Return: HTML
function retrieveFormHTML(){
	global $GlobalSettings,$Language,$VARS,$Document,$HTTP_COOKIE_VARS;
	extract ($VARS,EXTR_OVERWRITE);

	$contents .= <<<EOF
	$Document[msg]
	<TABLE CLASS="TableStyle" ALIGN="CENTER" CELLPADDING="10">
	<TR>
		<TD CLASS="TDPlain" ALIGN="CENTER">
			<STRONG>$Language[ForgetYourPassword]</STRONG>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain" VALIGN="TOP">
			<FORM ACTION="$Document[mainScript]" METHOD="POST">
			<INPUT TYPE="HIDDEN" NAME="mode" VALUE="password" />
			<INPUT TYPE="HIDDEN" NAME="action" VALUE="retrieve" />
			<TABLE>
			<TR>
				<TD CLASS="TDPlain">
					$Language[Useemail]:<BR/>
					<INPUT TYPE="TEXT" NAME="email" STYLE="width:200" VALUE="$email" MAXLENGTH="100" /> 
					<INPUT TYPE="SUBMIT" VALUE="$Language[Retrieve]" CLASS="SubmitButtons" />
				</TD>
			</TR>
			</TABLE>		
			</FORM>
		</TD>
	</TR>
	</TABLE>
EOF;
	return $contents;
}//retrieveFormHTML

//  Format form for resetting password
//  Paramemter: Errors(Array)
//  Return: HTML
function resetFormHTML($errorFields){
	global $GlobalSettings,$Language,$VARS,$Document;
	extract ($VARS,EXTR_OVERWRITE);

	$contents .= <<<EOF
	<TABLE ALIGN="CENTER" CELLPADDING="0">
	<TR>
		<TD CLASS="TDPlain" ALIGN="CENTER"><BR/>
			<STRONG>$errorFields[name]</STRONG><BR/><BR/>
			
			[$Language[ChangePassword]]<BR/><BR/>
		</TD>
	</TR>
	<TR>
		<TD CLASS="TDPlain" VALIGN="TOP">
			<FORM NAME="login" ACTION="$Document[mainScript]" METHOD="POST">
			<INPUT TYPE="HIDDEN" NAME="mode" VALUE="password" />
			<INPUT TYPE="HIDDEN" NAME="loginName" VALUE="$loginName" />
			<INPUT TYPE="HIDDEN" NAME="securityCode" VALUE="$securityCode" />
			<INPUT TYPE="HIDDEN" NAME="action" VALUE="update" />
			<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR>
				<TD CLASS="TDPlain" WIDTH="124">
					$Language[NewPassword]:
				</TD>
				<TD CLASS="TDPlain">
					<INPUT TYPE="PASSWORD" NAME="passwd" SIZE="20" VALUE="$passwd" MAXLENGTH="20" /> <SPAN CLASS="Error">$errorFields[newPassword]</SPAN>
				</TD>
			</TR>
			<TR>
				<TD CLASS="TDPlain">
					$Language[ConfirmPassword]:
				</TD>
				<TD CLASS="TDPlain">
					<INPUT TYPE="PASSWORD" NAME="confirmPassword" SIZE="20" VALUE="$confirmPassword" MAXLENGTH="20" /> <SPAN CLASS="Error">$errorFields[confirmPassword]</SPAN>
				</TD>
			</TR>					
			<TR>
				<TD CLASS="TDPlain">
				</TD>
				<TD CLASS="TDPlain">
					<INPUT TYPE="SUBMIT" VALUE="$Language[Update]" CLASS="SubmitButtons" />			
			</TABLE>		
			</FORM>		
		</TD>
	</TR>
	</TABLE>
EOF;
	return $contents;
}//retrieveFormHTML	

?>