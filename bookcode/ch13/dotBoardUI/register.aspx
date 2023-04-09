<%@ Page Language="vb" AutoEventWireup="false" Codebehind="register.aspx.vb" Inherits="dotBoardUI.register"%>
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
			<asp:Label id="Label1" style="Z-INDEX: 101; LEFT: 40px; POSITION: absolute; TOP: 42px" runat="server" CssClass="header">Register for the dotBoard Message Board!</asp:Label>
			<asp:Label id="Label2" style="Z-INDEX: 102; LEFT: 43px; POSITION: absolute; TOP: 80px" runat="server">First Name</asp:Label>
			<asp:Label id="Label3" style="Z-INDEX: 103; LEFT: 43px; POSITION: absolute; TOP: 107px" runat="server">Last Name</asp:Label>
			<asp:Label id="Label4" style="Z-INDEX: 104; LEFT: 43px; POSITION: absolute; TOP: 133px" runat="server">Desired Username</asp:Label>
			<asp:Label id="Label5" style="Z-INDEX: 105; LEFT: 43px; POSITION: absolute; TOP: 160px" runat="server">Password</asp:Label>
			<asp:Label id="Label6" style="Z-INDEX: 106; LEFT: 43px; POSITION: absolute; TOP: 188px" runat="server">Confirm Password</asp:Label>
			<asp:Label id="Label7" style="Z-INDEX: 107; LEFT: 45px; POSITION: absolute; TOP: 216px" runat="server">Email address</asp:Label>
			<asp:TextBox id="txtFirstName" style="Z-INDEX: 108; LEFT: 170px; POSITION: absolute; TOP: 79px" runat="server"></asp:TextBox>
			<asp:TextBox id="txtLastName" style="Z-INDEX: 109; LEFT: 170px; POSITION: absolute; TOP: 106px" runat="server"></asp:TextBox>
			<asp:TextBox id="txtUsername" style="Z-INDEX: 110; LEFT: 170px; POSITION: absolute; TOP: 133px" runat="server"></asp:TextBox>
			<asp:TextBox id="txtPassword" style="Z-INDEX: 111; LEFT: 170px; POSITION: absolute; TOP: 159px" runat="server" TextMode="Password"></asp:TextBox>
			<asp:TextBox id="txtConfirmPassword" style="Z-INDEX: 112; LEFT: 170px; POSITION: absolute; TOP: 186px" runat="server" TextMode="Password"></asp:TextBox>
			<asp:TextBox id="txtEmailAddress" style="Z-INDEX: 113; LEFT: 170px; POSITION: absolute; TOP: 213px" runat="server"></asp:TextBox>
			<asp:Button id="btnRegister" style="Z-INDEX: 114; LEFT: 46px; POSITION: absolute; TOP: 248px" runat="server" Text="Register"></asp:Button>
			<asp:RequiredFieldValidator id="valFirstName" style="Z-INDEX: 115; LEFT: 64px; POSITION: absolute; TOP: 308px" runat="server" ErrorMessage="You must enter your first name" ControlToValidate="txtFirstName" Display="None"></asp:RequiredFieldValidator>
			<asp:RequiredFieldValidator id="valLastName" style="Z-INDEX: 116; LEFT: 67px; POSITION: absolute; TOP: 336px" runat="server" ErrorMessage="You must enter your last name" ControlToValidate="txtLastName" Display="None"></asp:RequiredFieldValidator>
			<asp:RequiredFieldValidator id="valUsername" style="Z-INDEX: 117; LEFT: 330px; POSITION: absolute; TOP: 313px" runat="server" ErrorMessage="You must enter a username" ControlToValidate="txtUsername" Display="None"></asp:RequiredFieldValidator>
			<asp:RequiredFieldValidator id="valPassword" style="Z-INDEX: 118; LEFT: 69px; POSITION: absolute; TOP: 388px" runat="server" ErrorMessage="You must enter a password" ControlToValidate="txtPassword" Display="None"></asp:RequiredFieldValidator>
			<asp:CompareValidator id="valConfirmPassword" style="Z-INDEX: 119; LEFT: 173px; POSITION: absolute; TOP: 357px" runat="server" ErrorMessage="Passwords do not match" ControlToValidate="txtConfirmPassword" ControlToCompare="txtPassword" Display="None"></asp:CompareValidator>
			<asp:RequiredFieldValidator id="valEmail1" style="Z-INDEX: 120; LEFT: 169px; POSITION: absolute; TOP: 332px" runat="server" ErrorMessage="You must enter an email address" ControlToValidate="txtEmailAddress" Display="None"></asp:RequiredFieldValidator>
			<asp:RegularExpressionValidator id="valEmail2" style="Z-INDEX: 121; LEFT: 272px; POSITION: absolute; TOP: 280px" runat="server" ErrorMessage="Email address in an incorrect format" ControlToValidate="txtEmailAddress" ValidationExpression="\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" Display="None"></asp:RegularExpressionValidator>
			<asp:RequiredFieldValidator id="valConfirmPassword2" style="Z-INDEX: 122; LEFT: 175px; POSITION: absolute; TOP: 306px" runat="server" ErrorMessage="You must enter a confirmation password" ControlToValidate="txtConfirmPassword" Display="None"></asp:RequiredFieldValidator>
			<asp:ValidationSummary id="valSummary" style="Z-INDEX: 123; LEFT: 338px; POSITION: absolute; TOP: 78px" runat="server" HeaderText="There were errors"></asp:ValidationSummary>
			<asp:CustomValidator id="valCustom" style="Z-INDEX: 124; LEFT: 173px; POSITION: absolute; TOP: 278px" runat="server" ErrorMessage="CustomValidator" Display="None"></asp:CustomValidator>
		</form>
	</body>
</HTML>
