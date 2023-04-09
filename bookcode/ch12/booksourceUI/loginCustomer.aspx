<%@ Page language="c#" Codebehind="loginCustomer.aspx.cs" AutoEventWireup="false" Inherits="bookSourceUI.loginCustomer" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<meta content="False" name="vs_showGrid">
		<meta content="Microsoft Visual Studio 7.0" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript (ECMAScript)" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
	</HEAD>
	<body bgColor="#ffffff">
		<!--#Include file="header.htm" -->
		<div align="left">
			<form id="loginCustomer" method="post" runat="server">
				<table style="WIDTH: 350px; HEIGHT: 183px" cellSpacing="2" cellPadding="2" border="0">
					<tr bgColor="red">
						<td colSpan="3" align="middle">
							<FONT face="Verdana" color="#ffffff" size="2">Customers Login</FONT>
						</td>
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
					<asp:Label id="loginLabel" runat="server" ForeColor="Red"></asp:Label>
				</DIV>
			</form>
			Don't have a login?
			<br>
			<a href="newCustomer.aspx">Get one here!</a>
		</div>
	</body>
</HTML>
