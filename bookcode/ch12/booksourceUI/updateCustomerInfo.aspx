<%@ Page language="c#" Codebehind="updateCustomerInfo.aspx.cs" AutoEventWireup="false" Inherits="bookSourceUI.WebForm1" %>
<%@ Import Namespace="System.Data" %>
<%@ OutputCache Duration="1" VaryByParam="none" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<body>
		<!-- #Include file="header.htm" -->
		<div align="left">
			<table cellSpacing="2" cellPadding="2">
				<tr>
					<td>
						<P align="center">
							<STRONG><FONT face="Arial"><U>Please Update your personal information</U></FONT></STRONG>
						</P>
					</td>
				</tr>
				<tr>
					<td>
						<form id="Form1" runat="server">
							<asp:datagrid id="custGrid" runat="server" AutoGenerateColumns="False" CellPadding="0" BorderColor="DimGray" BorderWidth="0px" OnUpdateCommand="custGrid_Update" OnCancelCommand="custGrid_Cancel" OnEditCommand="custGrid_Edit" HeaderStyle-BackColor="#aaaadd" Font-Size="8pt" Font-Name="Verdana" Font-Names="Verdana" Width="632px" Height="78px">
								<HeaderStyle Font-Size="X-Small" Font-Underline="True" Font-Names="Verdana" HorizontalAlign="Center" ForeColor="White" VerticalAlign="Middle" BackColor="Red"></HeaderStyle>
								<SelectedItemStyle HorizontalAlign="Center" VerticalAlign="Middle"></SelectedItemStyle>
								<EditItemStyle HorizontalAlign="Center" VerticalAlign="Middle"></EditItemStyle>
								<AlternatingItemStyle Font-Size="X-Small" Font-Names="Verdana" HorizontalAlign="Center" VerticalAlign="Middle" BackColor="Gainsboro"></AlternatingItemStyle>
								<ItemStyle HorizontalAlign="Center" VerticalAlign="Middle"></ItemStyle>
								<Columns>
									<asp:EditCommandColumn ButtonType="PushButton" UpdateText="Update" HeaderText="Update" CancelText="Cancel" EditText="Edit">
										<HeaderStyle Wrap="False">
										</HeaderStyle>
										<ItemStyle Wrap="False">
										</ItemStyle>
									</asp:EditCommandColumn>
									<asp:BoundColumn DataField="CT_ID" ReadOnly="True" HeaderText="ID"></asp:BoundColumn>
									<asp:BoundColumn DataField="CT_FirstName" HeaderText="First Name"></asp:BoundColumn>
									<asp:BoundColumn DataField="CT_Lastname" HeaderText="Last Name"></asp:BoundColumn>
									<asp:BoundColumn DataField="CT_Email" HeaderText="Email Address"></asp:BoundColumn>
									<asp:BoundColumn DataField="CT_Password" HeaderText="Password"></asp:BoundColumn>
								</Columns>
							</asp:datagrid>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</body>
</HTML>
