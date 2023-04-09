<!-- Chapter3/Repeater2.aspx -->
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<html><head></head>
<script language="VB" Debug="true" runat="server">
Sub Page_Load(src As Object, e As EventArgs)
  If Not IsPostBack Then
  	bindListControl
  End If
End Sub
Sub bindListControl()
Dim myConn As OleDbConnection
	Dim myOleDbAdapter As OleDbDataAdapter
	Dim connStr, sqlStr As String
	Dim myDataSet As New Dataset
	connStr="Provider=Microsoft.Jet.OLEDB.4.0; " _
	       + "Data Source=D:\Products.mdb"
	sqlStr = "SELECT ProductId, ProductName, Price, ImagePath " _
	         +   "FROM Products WHERE Price>79.00 ORDER BY Price"
	myConn= New OleDbConnection(connStr)
	myConn.Open()
	myOleDbAdapter =New OleDbDataAdapter(sqlStr,myConn)
  	myOleDbAdapter.Fill(myDataSet,"dtProducts")
  	repeater1.DataSource = myDataSet.Tables("dtProducts")
  	repeater1.DataBind()
End Sub
Sub showSelection(s As Object, e As RepeaterCommandEventArgs)
    lblMessage.Text = "You have selected ProductID : "  _ 
                           + e.CommandSource.Text
    ' Some references use the following statement which is actually not necessary
    ' CType(e.CommandSource, Button).Text
End Sub
</script>
<body><form runat= "server"><center>
<asp:Repeater id=repeater1 OnItemCommand="showSelection" runat="server">
  <HeaderTemplate><table></HeaderTemplate>
  <ItemTemplate><tr>
  <td><asp:Image height=100 width=100
       Img src='<%# Container.DataItem("ImagePath") %>' runat="server" />
  </td><td> Product ID: 
	<asp:Button text=<%# Container.DataItem("ProductId")%> runat="server" /><br/>
      Description: <b><i>
      <%# Container.DataItem("ProductName") %> </b></i><br/>
      <b>Unit Price: 
      <%# FormatCurrency(Container.DataItem("Price")) %></b><br/>
  </td></tr>
  </ItemTemplate>
     <FooterTemplate></table></FooterTemplate>
 </asp:Repeater>
 <asp:Label id=lblMessage runat="server" ForeColor="Brown"
          Font-Size="14pt"  Font-Weight = "700" Font-Name="Arial Black,Arial" >
 </asp:Label></center>
</form></body></html>
 
           
	