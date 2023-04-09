<%@ Register TagPrefix="uc1" TagName="userArea" Src="userArea.ascx" %>
<%@ Page Language="vb" AutoEventWireup="false" Codebehind="thread.aspx.vb" Inherits="dotBoardUI.thread"%>
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
						<P>
							<asp:Panel Runat="server" id="Panel1">
								<SPAN class="header">Board
									<asp:Label id="lblHeaderBoard" runat="server"></asp:Label>
								</SPAN>
								<BR>
								<SPAN class="header">Thread
									<asp:Label id="lblHeaderThread" runat="server"></asp:Label>
								</SPAN>
								<BR>
								<BR>
								<TABLE cellSpacing="2" cellPadding="2" width="90%" border="0">
									<asp:Repeater id="Repeater1" runat="server">
										<ItemTemplate>
											<tr>
												<td bgcolor="#e5e5e5">
													posted by
													<%#DataBinder.Eval(Container, "DataItem.postCreatorName")%>
													<%#DataBinder.Eval(Container, "DataItem.postCreatorEmail")%>
												</td>
												<td bgcolor="#e5e5e5">
													posted at
													<%#DataBinder.Eval(Container, "DataItem.postDate")%>
												</td>
											</tr>
											<tr>
												<td colspan="2" bgcolor="#e5e5e5">
													<b>
														<%#DataBinder.Eval(Container, "DataItem.postSubject")%>
													</b>
												</td>
											</tr>
											<tr>
												<td colspan="2" bgcolor="#e5e5e5">
													<%#DataBinder.Eval(Container, "DataItem.postBody")%>
												</td>
											</tr>
										</ItemTemplate>
										<SeparatorTemplate>
											<tr>
												<td colspan="2">
													&nbsp;
												</td>
											</tr>
										</SeparatorTemplate>
									</asp:Repeater>
								</TABLE>
							</asp:Panel>
						</P>
						<P>
							<asp:LinkButton id="LinkButton1" runat="server">New Post</asp:LinkButton>
						</P>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
