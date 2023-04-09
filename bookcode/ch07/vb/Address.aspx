<%@ Page Language="vb" AutoEventWireup="false" Codebehind="Address.aspx.vb" Inherits="Chapter7_vb.Address" enableViewState="True" EnableSessionState="False" trace="False"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<title>ASP.NET - Chapter 7 - ADO.NET - Address sample</title>
		<meta content="Microsoft Visual Studio.NET 7.0" name="GENERATOR">
		<meta content="Visual Basic 7.0" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
		<LINK href="Address.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body>
		<form id="frmAddress" method="post" runat="server">
			<asp:label id="lblTitle" runat="server" CssClass="bigNBold">Address List</asp:label>
			<br>
			<asp:datalist id="dlAddress" runat="server" DataKeyField="AdrsID" OnEditCommand="EditAddress_Click" OnUpdateCommand="UpdateAddress_Click" OnDeleteCommand="DeleteAddress_Click" OnCancelCommand="Cancel_Click">
				<HeaderStyle CssClass="tableHeader" Width="740" BorderStyle="Solid" />
				<ItemStyle CssClass="smallRow" VerticalAlign="Top" Width="740" BorderStyle="Solid" />
				<SelectedItemStyle CssClass="editRow" BorderStyle="Solid" />
				<HeaderTemplate>
					<table width="740">
						<tr>
							<th width="50">
								&nbsp;</th>
							<th width="150">
								Name</th>
							<th width="250">
								Contact Info</th>
							<th>
								Notes</th>
						</tr>
					</table>
				</HeaderTemplate>
				<ItemTemplate>
					<table width="740" class="smallRow" bgcolor="">
						<tr>
							<td width="50" valign="top">
								<asp:LinkButton CommandName="Edit" Text="Edit" Runat="server" />
							</td>
							<td width="150" valign="top">
								<%# Container.DataItem("LName") & ", " & Container.DataItem("FName") %>
							</td>
							<td width="250" valign="top">
								phone:&nbsp;<%# Container.DataItem("Phone") %>
								<br>
								email:&nbsp;<%# Container.DataItem("EMail") %>
								<br>
								web page:&nbsp;<%# Container.DataItem("WebPage") %>
								<br>
								age:&nbsp;<%# Container.DataItem("Age") %>
							</td>
							<td valign="top">
								<%# Container.DataItem("Comments") %>
							</td>
						</tr>
					</table>
				</ItemTemplate>
				<EditItemTemplate>
					<asp:Table Runat="server" CssClass="editRow">
						<asp:TableRow Runat="server">
							<asp:TableCell width="80" VerticalAlign="Top" Runat="server">
								<asp:Button id="cmdUpdate" CommandName="update" Text="Update" Runat="server" Width="80" />
								<br>
								<asp:Button id="cmdDelete" CommandName="delete" Text="Delete" Runat="server" Width="80" />
								<br>
								<asp:Button id="cmdCancel" CommandName="cancel" Text="Cancel" Runat="server" Width="80" />
								<br>
								ID:&nbsp;<asp:TextBox id="txtAdrsID" Runat="server" Text='<%# Container.DataItem("AdrsID") %>' Width="24" />
							</asp:TableCell>
							<asp:TableCell width="660" verticalalign="top" Runat="server">
								<asp:Table Runat="server">
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">First Name</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtFName" Runat="server" Text='<%# Container.DataItem("FName") %>' Width="400" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">Last Name</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox id="txtLName" Runat="server" Text='<%# Container.DataItem("LName") %>' Width="400" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">email:</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txteMail" runat="server" Text='<%# Container.DataItem("EMail") %>' Width="660" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">web page:</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtWebPage" runat="server" Text='<%# Container.DataItem("WebPage") %>' Width="660" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">phone:</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtPhone" runat="server" Text='<%# Container.DataItem("Phone") %>' Width="120" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">age:</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtAge" runat="server" Text='<%# Container.DataItem("Age") %>' Width="24" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">Notes:</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtComments" Runat="server" Text='<%# Container.DataItem("Comments") %>' textmode="MultiLine" Columns="50" Rows="4" />
										</asp:TableCell>
									</asp:TableRow>
								</asp:Table>
							</asp:TableCell>
						</asp:TableRow>
					</asp:Table>
				</EditItemTemplate>
				<FooterTemplate>
					<asp:Button ID="cmdAdd" Text="Add New" Runat="server" onclick="addContact_Click" />
				</FooterTemplate>
			</asp:datalist>
		</form>
	</body>
</HTML>
