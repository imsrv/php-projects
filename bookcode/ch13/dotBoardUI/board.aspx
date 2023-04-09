<%@ Register TagPrefix="uc1" TagName="userArea" Src="userArea.ascx" %>
<%@ Page Language="vb" AutoEventWireup="false" Codebehind="board.aspx.vb" Inherits="dotBoardUI.board"%>
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
						<P>
							<asp:Panel Runat="server" id="Panel1">
								<DIV class="header">
									Threads in Board "
									<asp:Label id="lblHeader" Runat="server"></asp:Label>
									"
								</DIV>
								<BR>
								<BR>
								<TABLE cellSpacing="0" cellPadding="0" width="90%" border="0">
									<asp:Repeater id="Repeater1" runat="server">
										<SeparatorTemplate>
											<tr>
												<td colspan="2">
													&nbsp;
												</td>
											</tr>
										</SeparatorTemplate>
										<ItemTemplate>
											<tr>
												<td>
													started by
													<%#DataBinder.Eval(Container, "DataItem.creatorName")%>
												</td>
												<td>
													<%#DataBinder.Eval(Container, "DataItem.PostCount")%>
													total posts
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<a href='thread.aspx?<%#DataBinder.Eval(Container, "DataItem.threadLink")%>'>
														<%#DataBinder.Eval(Container, "DataItem.threadSubject")%>
													</a>
												</td>
											</tr>
										</ItemTemplate>
									</asp:Repeater>
								</TABLE>
							</asp:Panel>
						</P>
						<P>
							<asp:LinkButton id="LinkButton1" runat="server">New Thread</asp:LinkButton>
						</P>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
