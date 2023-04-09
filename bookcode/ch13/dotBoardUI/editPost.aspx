<%@ Page Language="vb" AutoEventWireup="false" Codebehind="editPost.aspx.vb" Inherits="dotBoardUI.editPost"%>
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
							<SPAN class="header">Board
								<asp:Label id="lblHeaderBoard" runat="server"></asp:Label>
							</SPAN>
							<BR>
							<SPAN class="header">Thread
								<asp:Label id="lblHeaderThread" runat="server"></asp:Label>
							</SPAN>
							<BR>
							<P>
							</P>
							<P>
							</P>
							<P>
								<asp:Label id="Label1" runat="server">Subject</asp:Label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<asp:RequiredFieldValidator id="valSubject" runat="server" ErrorMessage="You must enter a subject" ControlToValidate="txtSubject"></asp:RequiredFieldValidator>
								<BR>
								<asp:TextBox id="txtSubject" runat="server" Width="504px" Height="24px"></asp:TextBox>
							</P>
							<P>
								<asp:Label id="Label2" runat="server">Message</asp:Label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<asp:RequiredFieldValidator id="valMessage" runat="server" ErrorMessage="You must enter a message" ControlToValidate="txtMessage"></asp:RequiredFieldValidator>
							</P>
							<P>
								<asp:TextBox id="txtMessage" runat="server" Width="504px" Height="209px" TextMode="MultiLine"></asp:TextBox>
							</P>
							<asp:Button id="btnEditPost" runat="server" Text="Edit Post"></asp:Button>
							<BR>
							<BR>
						</asp:Panel>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
