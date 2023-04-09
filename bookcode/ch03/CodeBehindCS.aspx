<!-- Chapter3\CodeBehindCS.aspx -->
<%@ page language="cs" Debug="true" codebehind="CSharpCodeBehind.cs" 
       inherits="myCsCodeBehind.cSharpCb" %>
<html><head></head><body>
<form runat="server">
Select a flower, and click the submit button please: <br>
<asp:ListBox id="lstFlowers" runat="server" rows="3">
</asp:ListBox><br><br>
<asp:Button id="btnSubmit" runat="server" 
	text="Submit" onclick="showSelection" /><br><br>
<asp:Label id=lblMessage runat="server" />
</body></form></html>
