<!-- Chapter3\ServerControl2.aspx -->
<%@ page language="VB" debug="true" %>
<html><head></head><body><form runat="server">
Select a flower, and then click the submit button please:<br/><br/>
<asp:listbox id="lstFlowers" runat="server" rows="3" /><br/><br/>
<asp:button id="btnSubmit" runat="server" 
                 text="Submit" onclick="showSelection" />
<br/><br/>
<asp:label id=lblMessage runat="server"></asp:Label>
</body></form></html>
<script language="VB" runat="server">
  Sub Page_Load(source As Object, e As EventArgs)
  	   lstFlowers.Items.Add(New ListItem("Tulip"))
           lstFlowers.Items.Add(New ListItem("Poppy"))
           lstFlowers.Items.Add(New ListItem("Iris"))
           lstFlowers.SelectedIndex=0
  End Sub
  Sub showSelection(sender As Object, e As EventArgs)
        lblMessage.Text = "You have selected " + lstFlowers.SelectedItem.Text   
  End Sub 
</script>
