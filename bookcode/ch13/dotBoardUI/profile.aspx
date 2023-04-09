<%@ Page Language="vb" AutoEventWireup="false" Codebehind="profile.aspx.vb" Inherits="dotBoardUI.profile"%>
<%@ Register TagPrefix="uc1" TagName="userArea" Src="userArea.ascx" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<title></title>
		<meta name="GENERATOR" content="Microsoft Visual Studio.NET 7.0">
		<meta name="CODE_LANGUAGE" content="Visual Basic 7.0">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link rel="stylesheet" type="text/css" href="styles.css">
	</HEAD>
	<body MS_POSITIONING="GridLayout">
		<form id="Form1" method="post" runat="server">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="30%" valign="top">
						<uc1:userArea id="UserArea1" runat="server">
						</uc1:userArea>
					</td>
					<td width="70%" valign="top">
						<asp:Panel Runat="server" id="Panel1" Width="100%">
							<DIV class="header">
								your profile
							</DIV>
							<P>
								<asp:ValidationSummary id="ValidationSummary1" runat="server" HeaderText="There were some problems"></asp:ValidationSummary>
								<BR>
								<BR>
								<asp:Label id="Label1" runat="server">First Name</asp:Label>
								<asp:TextBox id="txtFirstName" runat="server"></asp:TextBox>
							</P>
							<P>
								<asp:Label id="Label2" runat="server">Last Name</asp:Label>
								<asp:TextBox id="txtLastname" runat="server"></asp:TextBox>
							</P>
							<P>
								<asp:Label id="Label3" runat="server">New Password</asp:Label>
								<asp:TextBox id="txtNewPassword" runat="server" TextMode="Password"></asp:TextBox>
							</P>
							<P>
								<asp:Label id="Label4" runat="server">Confirm New Password</asp:Label>
								<asp:TextBox id="txtConfirmNewPassword" runat="server" TextMode="Password"></asp:TextBox>
							</P>
							<P>
								<asp:Label id="Label5" runat="server">Email Address</asp:Label>
								<asp:TextBox id="txtEmailAddress" runat="server"></asp:TextBox>
							</P>
							<P>
								<asp:Button id="btnUpdate" runat="server" Text="Update Profile"></asp:Button>
							</P>
							<P>
								<asp:Label id="lblMessage" runat="server" Visible="False">Your profile was updated</asp:Label>
							</P>
						</asp:Panel>
					</td>
				</tr>
			</table>
			<asp:CompareValidator id="valPasswords" style="Z-INDEX: 101; LEFT: 392px; POSITION: absolute; TOP: 395px" runat="server" ErrorMessage="Passwords do not match" ControlToValidate="txtConfirmNewPassword" Display="None" ControlToCompare="txtNewPassword"></asp:CompareValidator>
			<asp:RequiredFieldValidator id="valFirstName" style="Z-INDEX: 102; LEFT: 284px; POSITION: absolute; TOP: 396px" runat="server" ErrorMessage="You must enter a first name" ControlToValidate="txtFirstName" Display="None"></asp:RequiredFieldValidator>
			<asp:RequiredFieldValidator id="valLastName" style="Z-INDEX: 103; LEFT: 488px; POSITION: absolute; TOP: 394px" runat="server" ErrorMessage="You must enter a last name" ControlToValidate="txtLastname" Display="None"></asp:RequiredFieldValidator>
			<asp:RequiredFieldValidator id="valEmailAddress" style="Z-INDEX: 104; LEFT: 382px; POSITION: absolute; TOP: 414px" runat="server" ErrorMessage="You must enter an email address" ControlToValidate="txtEmailAddress" Display="None"></asp:RequiredFieldValidator>
			<asp:RegularExpressionValidator id="valEmailAddress2" style="Z-INDEX: 105; LEFT: 257px; POSITION: absolute; TOP: 417px" runat="server" ErrorMessage="Email address is in an incorrect format" Display="None" ControlToValidate="txtEmailAddress" ValidationExpression="\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*"></asp:RegularExpressionValidator>
		</form>
	</body>
</HTML>
