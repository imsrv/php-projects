<!-- Chapter3\DataBind1.aspx -->
<%@ Page Language="VB" Debug="true" %>
<html><head></head><title></title><body>
<form runat="server">
Select a flower, and then click the submit button please:<br>
<asp:ListBox id="lstFlowers" runat="server" rows="3"
AutoPostBack = "True" onSelectedIndexChanged="showSelection"/>
</asp:ListBox><br><br>
<asp:Label id=lblMessage runat="server"></asp:Label></p>
</body></form></html>
<script language=vb runat="server">
  Sub Page_Load(source As Object, e As EventArgs)
    If Not Page.IsPostBack Then
          Dim myArrayList As New ArrayList
          ' Populate the ArrayList: This will a data source
          myArrayList.Add("Azalea")
          myArrayList.Add("Tulip")
          myArrayList.Add("Rose")
                
          ' Step 1: Specify the Datasource property of the list control
          lstFlowers.DataSource= myArrayList
          
          ' Step 2: Employ the DataBind() method to load the
          ' list control from its DataSource automatically
          lstFlowers.DataBind()
          lstFlowers.SelectedIndex=0
   End If
  End Sub
  Sub showSelection(sender As Object, e As EventArgs)
        lblMessage.Text = "You have selected " + lstFlowers.SelectedItem.Text
  End Sub 
</script>
