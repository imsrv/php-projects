<!-- Chapter3\CodeBehindVb.aspx -->
<%@ page language="VB" debug="true" src="vbCb.vb" 
       inherits="myVbCodeBehind.vbCb" %>
<html><head></head><body>
<form runat="server">
Select a flower, and click the submit button please: <br>
<asp:ListBox id="lstFlowers" runat="server" rows="3">
</asp:ListBox><br><br>
<asp:Button id="btnSubmit" runat="server" 
	text="Submit" onclick="showSelection" /><br><br>
<asp:Label id=lblMessage runat="server" />
</body></form></html>
