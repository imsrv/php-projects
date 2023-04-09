<%@ Page language="c#" Codebehind="adminPage.aspx.cs" AutoEventWireup="false" Inherits="bookSourceUI.adminPage" %>
<%@ OutputCache Duration="1" VaryByParam="none" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<meta content="Microsoft Visual Studio 7.0" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript (ECMAScript)" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
	</HEAD>
	<body>
		<!--#Include file="header.htm" -->
		<div align="left">
			<form id="adminPage" method="post" runat="server">
				<table height="500" cellSpacing="2" cellPadding="2" width="600">
					<tr bgColor="red">
						<td>
							<P align="center">
								<FONT face="Verdana" color="#ffffff"><STRONG>Admin your Site</STRONG></FONT>
							</P>
						</td>
					</tr>
					<tr>
						<td>
							<P align="center">
								<STRONG><FONT face="Verdana" size="2">Update,Add,Delete,Books</FONT></STRONG>
							</P>
						</td>
					</tr>
					<tr>
						<td>
							<asp:datagrid id="changeBooks" runat="server" AllowPaging="True" PageSize="2" AutoGenerateColumns="False" BorderColor="Gainsboro" Height="500px">
								<HeaderStyle Font-Size="X-Small" Font-Underline="True" Font-Names="Verdana" HorizontalAlign="Center" Height="20px" ForeColor="White" VerticalAlign="Middle" BackColor="Red"></HeaderStyle>
								<PagerStyle NextPageText="Next" Height="20px" PrevPageText="Previous"></PagerStyle>
								<SelectedItemStyle Font-Size="XX-Small" Font-Names="Verdana"></SelectedItemStyle>
								<EditItemStyle Font-Size="XX-Small" Font-Names="Verdana" Height="230px"></EditItemStyle>
								<AlternatingItemStyle Font-Size="XX-Small" Font-Names="Verdana" HorizontalAlign="Center" VerticalAlign="Top" BackColor="Gainsboro"></AlternatingItemStyle>
								<ItemStyle Font-Size="XX-Small" Font-Names="Verdana" HorizontalAlign="Center" Height="230px" VerticalAlign="Top"></ItemStyle>
								<Columns>
									<asp:EditCommandColumn ButtonType="LinkButton" UpdateText="Update" HeaderText="Admin Functions" CancelText="Cancel" EditText="Edit"></asp:EditCommandColumn>
									<asp:ButtonColumn Text="Delete" HeaderText="Delete" CommandName="Delete"></asp:ButtonColumn>
									<asp:BoundColumn DataField="isbn" ReadOnly="True" HeaderText="ISBN"></asp:BoundColumn>
									<asp:BoundColumn DataField="author" HeaderText="Author"></asp:BoundColumn>
									<asp:BoundColumn DataField="price" HeaderText="Price"></asp:BoundColumn>
									<asp:BoundColumn DataField="title" HeaderText="Title"></asp:BoundColumn>
									<asp:BoundColumn DataField="description" HeaderText="Description"></asp:BoundColumn>
									<asp:BoundColumn DataField="id" ReadOnly="True" HeaderText="Category"></asp:BoundColumn>
									<asp:BoundColumn DataField="imgSrc" HeaderText="Image Path"></asp:BoundColumn>
								</Columns>
							</asp:datagrid>
						</td>
					</tr>
					<tr>
						<td>
							<asp:Label id="errorLabel" runat="server" ForeColor="Red" Width="100%"></asp:Label>
						</td>
					</tr>
					<tr>
						<td>
							<asp:HyperLink id="addBookLink" runat="server" NavigateUrl="addBook.aspx">Add a Book</asp:HyperLink>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</HTML>
