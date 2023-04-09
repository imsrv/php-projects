<%@ Page Language="vb" AutoEventWireup="false" Codebehind="createboard.aspx.vb" Inherits="dotBoardUI.createboard"%>
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
			<table width="100%" cellpadding="0" border="0">
				<tr>
					<td width="30%" valign="top">
						<uc1:userArea id="UserArea1" runat="server">
						</uc1:userArea>
					</td>
					<td width="70%" valign="top">
						<asp:Panel id="Panel1" runat="server" Width="100%">
							<DIV class="header">
								create new board
							</DIV>
							<P>
								<asp:ValidationSummary id="ValidationSummary1" runat="server" HeaderText="There were errors"></asp:ValidationSummary>
								<BR>
								<asp:Label id="Label1" runat="server">Board Name</asp:Label>
								<asp:TextBox id="txtBoardName" runat="server"></asp:TextBox>
							</P>
							<P>
								<BR>
								<asp:Label id="Label2" runat="server">Board Description</asp:Label>
							</P>
							<P>
								<asp:TextBox id="txtBoardDescription" runat="server" Width="423px" Height="56px" TextMode="MultiLine"></asp:TextBox>
							</P>
							<P>
								<asp:Button id="btnCreate" runat="server" Text="Create Board"></asp:Button>
							</P>
						</asp:Panel>
					</td>
				</tr>
			</table>
			<asp:RequiredFieldValidator id="valName" style="Z-INDEX: 101; LEFT: 381px; POSITION: absolute; TOP: 337px" runat="server" ErrorMessage="You must enter a name" ControlToValidate="txtBoardName" Display="None"></asp:RequiredFieldValidator>
			<asp:RequiredFieldValidator id="valDescription" style="Z-INDEX: 102; LEFT: 458px; POSITION: absolute; TOP: 339px" runat="server" ErrorMessage="You must enter a description" ControlToValidate="txtBoardDescription" Display="None"></asp:RequiredFieldValidator>
		</form>
	</body>
</HTML>
