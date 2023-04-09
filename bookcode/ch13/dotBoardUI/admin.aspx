<%@ Register TagPrefix="uc1" TagName="userArea" Src="userArea.ascx" %>
<%@ Page Language="vb" AutoEventWireup="false" Codebehind="admin.aspx.vb" Inherits="dotBoardUI.admin"%>
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
							Administration
						</div>
						<br>
						<br>
						<asp:Panel id="pnlUsers" runat="server" Width="608px" Height="320px">
							<P>
								<asp:Label id="Label1" Runat="server">Administer users</asp:Label>
								<BR>
								<BR>
								<asp:DropDownList id="dlUsers" runat="server"></asp:DropDownList>
								&nbsp;&nbsp;
								<asp:LinkButton id="lnkChooseUser" runat="server">Administer this user</asp:LinkButton>
							</P>
							<P>
								<asp:Panel id="Panel1" runat="server" Height="19px" Width="545px" Visible="False">
									<P>
										<asp:RadioButtonList id="rblAdmin" runat="server" Visible="False">
											<asp:ListItem Value="Admin">Admin</asp:ListItem>
											<asp:ListItem Value="User">User</asp:ListItem>
										</asp:RadioButtonList>
									</P>
									<P>
									</P>
									<P>
										<asp:RadioButtonList id="rblBanned" runat="server" Visible="False">
											<asp:ListItem Value="Not banned">Not banned</asp:ListItem>
											<asp:ListItem Value="Banned">Banned</asp:ListItem>
										</asp:RadioButtonList>
									</P>
									<P>
										<asp:Button id="btnModify" runat="server" Text="Modify user"></asp:Button>
									</P>
									<P>
								</asp:Panel>
							</P>
						</asp:Panel>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
