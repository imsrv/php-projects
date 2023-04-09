<?

	OutputPageHeader(false);
	?>
		<table width="96%" align="center" border="0">
			<tr>
				<td>
	<?php

	if(@$BadLogin == "")
	{
		$OUTPUT = '

		<TABLE width="100%" cellspacing="0" cellpadding="4">
		<TR>
			<TD class="heading1">Administrator Login</TD>
		</TR>
		<TR height="1">
			<TD></TD>
		</TR>
		<TR>
			<TD><span class="admintext">Login with your username and password<FORM onSubmit="return CheckForm()" formid="myform"  name="SelectList" action="' . $ROOTURL . 'admin/index.php?LOGINNOW" method="post">
			<TABLE width=100% border=0 cellspacing=0 cellpadding=0>
			<TR><TD colspan=2 bgcolor=#ADAAAD height=20 class=menutext>&nbsp;&nbsp;Login</TD></TR><TR><TD colspan=2 bgcolor=#F7F7F7 height=10 class=menutext></TD></TR><TR><TD valign="top" width=150 align="left" bgcolor="#F7F7F7"><p style="margin-left:10"><span class="formtext">Username:&nbsp;</span></TD><TD bgcolor="#F7F7F7"><INPUT type="text" size="25" name="username" class="inputfields" size="5" maxlength="15" value=""></TD></TR>

			<TR><TD valign="top" width=150 align="left" bgcolor="#F7F7F7"><p style="margin-left:10"><span class="formtext">Password:&nbsp;</span></TD><TD bgcolor="#F7F7F7"><INPUT type="password" name="password" size="25" class="inputfields" size="5" maxlength="15" value=""></TD></TR>

			<TR><TD valign="top" width=150 align="left" bgcolor="#F7F7F7"><p style="margin-left:10"><span class="formtext"></span></TD><TD bgcolor="#F7F7F7"><input  type="submit" name="SubmitButton" value="Login" class="smallbutton"><br>&nbsp;</TD></TR>

			</FORM></TABLE></SPAN></TD>
				</TR>
				<TR><TD><BR></TD></TR>
				</TABLE>

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.username.value == "")
							{
								alert("Please enter your username.");
								f.username.focus();
								return false;
							}

							if(f.password.value == "")
							{
								alert("Please enter your password.");
								f.password.focus();
								return false;
							}
						}
					
					</script>


		';

		echo $OUTPUT;
	}
	else
	{
		echo MakeErrorBox("Login", "<br>You have entered an incorrect username and password combination.");
	}

?>

			</td>
		</tr>
	</table>
<?php

	OutputPageFooter();
?>