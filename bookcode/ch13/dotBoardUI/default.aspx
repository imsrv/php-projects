<%@ Register TagPrefix="uc1" TagName="userArea" Src="userArea.ascx" %>
<%@ Page Language="vb" AutoEventWireup="false" Codebehind="default.aspx.vb" Inherits="dotBoardUI.WebForm1"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<title></title>
		<meta name="GENERATOR" content="Microsoft Visual Studio.NET 7.0">
		<meta name="CODE_LANGUAGE" content="Visual Basic 7.0">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link type="text/css" rel="stylesheet" href="styles.css">
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
						<asp:Panel Runat="server" id="Panel1">
							<asp:Repeater id="Repeater1" runat="server">
								<HeaderTemplate>
									<div class="header">
										Available boards
									</div>
								</HeaderTemplate>
								<SeparatorTemplate>
									<br>
									<br>
								</SeparatorTemplate>
								<ItemTemplate>
									<a href='board.aspx?boardid=<%#DataBinder.Eval(Container, "DataItem.BoardName")%>'>
										<%#DataBinder.Eval(Container, "DataItem.BoardName")%>
									</a>
									<br>
									<%#DataBinder.Eval(Container, "DataItem.BoardDescription")%>
								</ItemTemplate>
							</asp:Repeater>
						</asp:Panel>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
