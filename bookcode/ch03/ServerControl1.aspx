<!-- Chapter3\ServerControl1.aspx -->
<html><head></head><body>
<form runat="server" action = "ServerControl1.aspx">
Select a flower, and then click the submit button please. You
will see that the page remembers your selection.<br/><br/>
<asp:ListBox  runat="server" rows="3">
     <asp:ListItem>Tulip</asp:ListItem>
     <asp:ListItem>Poppy</asp:ListItem>
     <asp:ListItem>Iris</asp:ListItem>
</asp:ListBox><br/><br/>
<input type="submit" value="Submit" runat="server"/> 
</body></form></html>