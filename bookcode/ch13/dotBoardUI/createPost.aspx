<%@ Register TagPrefix="uc1" TagName="userArea" Src="userArea.ascx" %>
<%@ Page Language="vb" AutoEventWireup="false" Codebehind="createPost.aspx.vb" Inherits="dotBoardUI.createPost"%>
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
			<table width="100%" cellpadding="0" border="0">
				<tr>
					<td width="30%" valign="top">
						<uc1:userArea id="UserArea1" runat="server">
						</uc1:userArea>
					</td>
					<td width="70%" valign="top">
						<div class="header">
							Create new post in
							<asp:Label id="lblBoardName" runat="server"></asp:Label>
						</div>
						<br>
						<br>
						<asp:Panel id="pnlShowThread" runat="server" Width="100%">
							<SPAN class="header">Thread
								<asp:Label id="lblThreadName" runat="server"></asp:Label>
							</SPAN>
						</asp:Panel>
						<br>
						<asp:ValidationSummary id="ValidationSummary1" runat="server" HeaderText="There were errors"></asp:ValidationSummary>
						<br>
						<asp:Label id="Label1" runat="server">Thread Subject</asp:Label>
						<br>
						<asp:TextBox id="txtThreadSubject" runat="server"></asp:TextBox>
						<br>
						<asp:Label id="Label2" runat="server">Message Body</asp:Label>
						<br>
						<asp:TextBox id="TextBox1" runat="server" Width="532px" Height="183px" TextMode="MultiLine"></asp:TextBox>
						<br>
						<br>
						<asp:Button id="btnCreatePost" runat="server" Text="Create Post"></asp:Button>
						<asp:RequiredFieldValidator id="valSubject" runat="server" ErrorMessage="You must enter a subject" ControlToValidate="txtThreadSubject" Display="None"></asp:RequiredFieldValidator>
						<asp:RequiredFieldValidator id="valBody" runat="server" ErrorMessage="You must enter a message" ControlToValidate="TextBox1" Display="None"></asp:RequiredFieldValidator>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
