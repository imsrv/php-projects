<%@ Page language="c#" Codebehind="newCustomer.aspx.cs" AutoEventWireup="false" Inherits="bookSourceUI.newCustomer" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<meta name="GENERATOR" Content="Microsoft Visual Studio 7.0">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript (ECMAScript)">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
	</HEAD>
	<body bgColor="#ffffff">
		<!-- #Include file="header.htm" -->
		<div align="left">
			<form id="loginCustomer" method="post" runat="server">
				<table style="WIDTH: 350px; HEIGHT: 183px" cellSpacing="2" cellPadding="2" border="0">
					<tr bgColor="red">
						<td colSpan="3" align="middle">
							<FONT face="Verdana" color="#ffffff" size="2">Sign Up</FONT>
						</td>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">First Name:</FONT>
						</td>
						<td style="WIDTH: 127px">
							<asp:textbox id="txtFName" runat="server" Width="106px" Height="24px"></asp:textbox>
						</td>
						<TD>
							<asp:requiredfieldvalidator id="passFName" runat="server" ErrorMessage="You must supply a Name" ControlToValidate="txtFName" Width="121px" Height="57px"></asp:requiredfieldvalidator>
						</TD>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">Last Name:</FONT>
						</td>
						<td style="WIDTH: 127px">
							<asp:textbox id="txtLName" runat="server" Width="106px" Height="24px"></asp:textbox>
						</td>
						<TD>
							<asp:requiredfieldvalidator id="passLName" runat="server" ErrorMessage="You must supply a Last Name" ControlToValidate="txtLName"></asp:requiredfieldvalidator>
						</TD>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">Email:</FONT>
						</td>
						<td style="WIDTH: 127px">
							<asp:textbox id="txtEmail" runat="server" Width="106px" Height="24px"></asp:textbox>
						</td>
						<TD>
							<asp:requiredfieldvalidator id="passEmail" runat="server" ErrorMessage="You must supply an email" ControlToValidate="txtEmail" Width="121px" Height="57px"></asp:requiredfieldvalidator>
						</TD>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">Password: </FONT>
						</td>
						<td style="WIDTH: 127px">
							<asp:textbox MaxLength="6" TextMode="Password" id="txtPassword" runat="server" Width="106px" Height="24px"></asp:textbox>
						</td>
						<TD>
							<asp:requiredfieldvalidator id="passValid" runat="server" ErrorMessage="You must put in your password" ControlToValidate="txtPassword"></asp:requiredfieldvalidator>
						</TD>
					</tr>
					<tr>
						<td align="middle" colSpan="3">
							<P align="center">
								<asp:button id="submitLogin" runat="server" Text="Submit"></asp:button>
								<INPUT type="reset" value="Reset">
							</P>
						</td>
					</tr>
				</table>
				<DIV align="center">
					<asp:Label id="addCustLabel" runat="server" ForeColor="Red"></asp:Label>
				</DIV>
			</form>
		</div>
	</body>
</HTML>
