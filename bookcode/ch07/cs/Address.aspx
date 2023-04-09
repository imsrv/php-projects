<%@ Page language="c#" Codebehind="Address.aspx.cs" AutoEventWireup="false" Inherits="Chapter7_cs.Address" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>ASP.NET - Chapter 7 - ADO.NET - Address sample</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio 7.0">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript (ECMAScript)">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="Address.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body>
		<form method="post" runat="server">
			<asp:label runat="server" CssClass="bigNBold" id="Label1">Address List</asp:label>
			<br>
			<asp:datalist id="dlAddress" runat="server" DataKeyField="AdrsID" OnEditCommand="EditAddress_Click" OnUpdateCommand="UpdateAddress_Click" OnDeleteCommand="DeleteAddress_Click" OnCancelCommand="Cancel_Click">
				<SelectedItemStyle BorderStyle="Solid" CssClass="editRow"></SelectedItemStyle>
				<HeaderTemplate>
					<TABLE width="740">
						<TR>
							<TH width="50">
								&nbsp;</TH>
							<TH width="150">
								Name</TH>
							<TH width="250">
								Contact Info</TH>
							<TH>
								Notes</TH>
						</TR>
					</TABLE>
				</HeaderTemplate>
				<FooterTemplate>
					<asp:Button id="cmdAddNew" OnClick="addContact_Click" Runat="server" Text="Add New"></asp:Button>
				</FooterTemplate>
				<ItemStyle BorderStyle="Solid" Width="740px" CssClass="smallRow" VerticalAlign="Top"></ItemStyle>
				<ItemTemplate>
					<table width="740" class="smallRow" bgcolor="">
						<tr>
							<td width="50" valign="top">
								<asp:LinkButton CommandName="Edit" Text="Edit" Runat="server" />
							</td>
							<td width="150" valign="top">
								<%# DataBinder.Eval(Container.DataItem, "LName") %>
								,&nbsp;<%# DataBinder.Eval(Container.DataItem, "FName") %>
							</td>
							<td width="250" valign="top">
								phone:&nbsp;<%# DataBinder.Eval(Container.DataItem,"Phone") %>
								<br>
								email:&nbsp;<%# DataBinder.Eval(Container.DataItem,"EMail") %>
								<br>
								web page:&nbsp;<%# DataBinder.Eval(Container.DataItem,"WebPage") %>
								<br>
								age:&nbsp;<%# DataBinder.Eval(Container.DataItem,"Age") %>
							</td>
							<td valign="top">
								<%# DataBinder.Eval(Container.DataItem,"Comments") %>
							</td>
						</tr>
					</table>
				</ItemTemplate>
				<HeaderStyle BorderStyle="Solid" Width="740px" CssClass="tableHeader"></HeaderStyle>
				<EditItemTemplate>
					<asp:Table Runat="server" CssClass="editRow">
						<asp:TableRow Runat="server">
							<asp:TableCell width="80" VerticalAlign="Top" Runat="server">
								<asp:Button CommandName="update" Text="Update" Runat="server" Width="80" />
								<br>
								<asp:Button CommandName="delete" Text="Delete" Runat="server" Width="80" />
								<br>
								<asp:Button CommandName="cancel" Text="Cancel" Runat="server" Width="80" />
								<br>
								ID:&nbsp;
<asp:TextBox id="txtAdrsID" Runat="server" Text='<%# DataBinder.Eval(Container.DataItem,"AdrsID") %>' Width="24" />
							</asp:TableCell>
							<asp:TableCell width="660" verticalalign="top" Runat="server">
								<asp:Table Runat="server" ID="Table2">
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">First Name</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtFName" Runat="server" Text='<%# DataBinder.Eval(Container.DataItem,"FName") %>' Width="400" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">Last Name</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtLName" Runat="server" Text='<%# DataBinder.Eval(Container.DataItem,"LName") %>' Width="400" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">email:</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtEMail" runat="server" Text='<%# DataBinder.Eval(Container.DataItem,"EMail") %>' Width="660" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">web page:</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtWebPage" runat="server" Text='<%# DataBinder.Eval(Container.DataItem,"WebPage") %>' Width="660" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">phone:</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtPhone" runat="server" Text='<%# DataBinder.Eval(Container.DataItem,"Phone") %>' Width="120" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">age:</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox Id="txtAge" runat="server" Text='<%# DataBinder.Eval(Container.DataItem,"Age") %>' Width="24" />
										</asp:TableCell>
									</asp:TableRow>
									<asp:TableRow Runat="server">
										<asp:TableCell Runat="server">Notes:</asp:TableCell>
										<asp:TableCell Runat="server">
											<asp:TextBox ID="txtComments" Runat="server" Text='<%# DataBinder.Eval(Container.DataItem,"Comments") %>' textmode="MultiLine" Columns="50" Rows="4" />
										</asp:TableCell>
									</asp:TableRow>
								</asp:Table>
							</asp:TableCell>
						</asp:TableRow>
					</asp:Table>
				</EditItemTemplate>
			</asp:datalist>
		</form>
	</body>
</HTML>
