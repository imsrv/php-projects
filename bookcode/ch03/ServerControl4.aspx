<!-- Chapter3\ServerControl4.aspx -->
<%@ Page Language="VB" Debug="true" %>
<html><head></head><body>
<form runat="server">
Select a flower, and then click the submit button please:<br/><br/>
<asp:listbox id="lstFlowers" runat="server" rows="3"
        AutoPostBack = "True" 
        onSelectedIndexChanged="showSelection"/>
<br><br>
<asp:Label id=lblMessage runat="server" />
<br/><br/>
</body></form></html>
<script language=vb runat="server">
  Sub Page_Load(source As Object, e As EventArgs)
    If Not Page.IsPostBack Then
          lstFlowers.Items.Add(New ListItem("Tulip"))
	      lstFlowers.Items.Add(New ListItem("Poppy"))
          lstFlowers.Items.Add(New ListItem("Iris"))
          lstFlowers.SelectedIndex=0
   End If
  End Sub
  Sub showSelection(source As Object, e As EventArgs)
        lblMessage.Text = "You have selected " + lstFlowers.SelectedItem.Text
  End Sub 
</script>
