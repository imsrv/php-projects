<%@ Control Language="vb" AutoEventWireup="false" Codebehind="userArea.ascx.vb" Inherits="dotBoardUI.userArea" %>
<P>
	<asp:Panel id="pnlNotLoggedIn" runat="server" Width="239px" Height="186px">
		<P>
			<asp:Label id="Label1" runat="server">
				Username</asp:Label>
			<asp:TextBox id="txtUsername" runat="server">
			</asp:TextBox>
		</P>
		<P>
			<asp:Label id="Label2" runat="server">
				Password</asp:Label>
			<asp:TextBox id="txtPassword" runat="server" TextMode="Password">
			</asp:TextBox>
		</P>
		<P>
			<asp:Button id="btnLogIn" runat="server" Text="Log in">
			</asp:Button>
		</P>
		<P>
			<asp:Label id="lblError" runat="server">
			</asp:Label>
		</P>
		<P>
			<asp:LinkButton id="LinkButton1" runat="server">
				Register for an account</asp:LinkButton>
		</P>
	</asp:Panel>
<P>
</P>
<P>
	<asp:Panel id="pnlLoggedIn" runat="server" Width="239px" Height="19px">
		<P>
			Welcome,
			<asp:Label id="lblWelcome" runat="server">
				Label</asp:Label>
		</P>
		<P>
		</P>
		<P>
			<asp:LinkButton id="lnkLogOut" runat="server">
				Log out</asp:LinkButton>
		</P>
		<P>
			<asp:LinkButton id="lnkProfile" runat="server">
				Profile</asp:LinkButton>
		</P>
		<P>
			<asp:LinkButton id="lnkAdmin" runat="server">
				Administration</asp:LinkButton>
		</P>
		<P>
			<asp:LinkButton id="lnkCreateBoard" runat="server">
				Create New Board</asp:LinkButton>
		</P>
	</asp:Panel>
<P>
</P>
