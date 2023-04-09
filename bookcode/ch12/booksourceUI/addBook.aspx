<%@ Page language="c#" Codebehind="addBook.aspx.cs" AutoEventWireup="false" Inherits="bookSourceUI.addBook" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<meta content="Microsoft Visual Studio 7.0" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript (ECMAScript)" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
	</HEAD>
	<body bgColor="#ffffff">
		<!--#Include file="header.htm" -->
		<div align="left">
			<form id="loginCustomer" method="post" runat="server">
				<table style="WIDTH: 387px; HEIGHT: 418px" cellSpacing="2" cellPadding="2" border="0">
					<tr bgColor="red">
						<td align="middle" colSpan="3">
							<FONT face="Verdana" color="#ffffff" size="2">Add a Book</FONT>&nbsp;
						</td>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">ISBN:</FONT>
						</td>
						<td style="WIDTH: 127px">
							<asp:textbox id="txtISBN" runat="server" Height="24px" Width="106px"></asp:textbox>
						</td>
						<TD>
							<asp:requiredfieldvalidator id="passISBN" runat="server" Height="57px" Width="121px" ControlToValidate="txtISBN" ErrorMessage="You must supply an ISBN"></asp:requiredfieldvalidator>
						</TD>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">Author:</FONT>&nbsp;
						</td>
						<td style="WIDTH: 127px">
							<asp:textbox id="txtAuthor" runat="server" Height="24px" Width="106px"></asp:textbox>
						</td>
						<TD>
							<asp:requiredfieldvalidator id="passAuthor" runat="server" ControlToValidate="txtAuthor" ErrorMessage="You must supply an Author."></asp:requiredfieldvalidator>
						</TD>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">Price:</FONT>
						</td>
						<td style="WIDTH: 127px">
							<asp:textbox id="txtPrice" runat="server" Height="24px" Width="106px"></asp:textbox>
						</td>
						<TD>
							<asp:requiredfieldvalidator id="passPrice" runat="server" Height="57px" Width="121px" ControlToValidate="txtPrice" ErrorMessage="You must supply a price."></asp:requiredfieldvalidator>
						</TD>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">Title:&nbsp; </FONT>
						</td>
						<td style="WIDTH: 127px">
							<asp:textbox id="txtTitle" runat="server" Height="24px" Width="106px"></asp:textbox>
						</td>
						<TD>
							<asp:requiredfieldvalidator id="passTitle" runat="server" ControlToValidate="txtTitle" ErrorMessage="You must put in a title."></asp:requiredfieldvalidator>
						</TD>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">Description:</FONT>
						</td>
						<td style="WIDTH: 127px">
							<asp:textbox id="txtDesc" runat="server" Height="24px" Width="106px"></asp:textbox>
						</td>
						<TD>
							<asp:requiredfieldvalidator id="passDesc" runat="server" ControlToValidate="txtDesc" ErrorMessage="You must put in a Description."></asp:requiredfieldvalidator>
						</TD>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">Category:</FONT>
						</td>
						<td style="WIDTH: 127px">
							<asp:dropdownlist id="listCat" runat="server" DataValueField="CAT_ID" DataTextField="CAT_Name"></asp:dropdownlist>
						</td>
						<TD>
						</TD>
					</tr>
					<tr>
						<td>
							<FONT face="Verdana" size="2">Image Path:</FONT>
						</td>
						<td style="WIDTH: 127px">
							<asp:textbox id="txtPath" runat="server" Height="24px" Width="106px"></asp:textbox>
						</td>
						<TD>
							<asp:requiredfieldvalidator id="passPath" runat="server" ControlToValidate="txtPath" ErrorMessage="Put in an image with ext."></asp:requiredfieldvalidator>
						</TD>
					</tr>
					<tr>
						<td align="middle" colSpan="3">
							<P align="center">
								<asp:button id="Button1" runat="server" Text="Add"></asp:button>
								<INPUT type="reset" value="Reset">
							</P>
						</td>
					</tr>
				</table>
				<DIV align="center">
					<asp:label id="addBookLabel" runat="server" ForeColor="Red"></asp:label>
				</DIV>
			</form>
		</div>
	</body>
</HTML>
