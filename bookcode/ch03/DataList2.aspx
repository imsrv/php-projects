<!-- Chapter3\DataList2.aspx -->
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
  Dim myDataSet As New DataSet
  connStr="Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\Products.mdb"
  sqlStr = "SELECT  ProductId, ProductName, Price " _
         + " FROM Products WHERE Price > 40 ORDER BY Price"
  myConn= New OleDbConnection(connStr)
  myConn.Open()
  myOleDbAdapter=New OleDbDataAdapter(sqlStr,myConn)
  myOleDbAdapter.Fill(myDataSet,"dtProducts")
  dataList1.DataSource=myDataSet.Tables("dtProducts")
  dataList1.DataBind()
  myConn.Close()
 End Sub
Sub showSelection(s As Object, e As DataListCommandEventArgs)
  lblSelectedIndex.Text ="Selected Index is: " + "&nbsp;" + _ 
         e.Item.ItemIndex.toString()
  lblSelectedProductName.Text="You have selected " + e.CommandArgument
End Sub
</script>
<form runat="server">
<asp:DataList id="dataList1" gridlines="both" cellpadding="10" 
   RepeatColumns="3" RepeatDirection="Horizontal"
   onItemCommand="showSelection"
   runat="server">
<ItemTemplate><asp:LinkButton id="myLinkBtns"
   text='<%# Container.DataItem( "ProductName" )%>'
   CommandArgument='<%# Container.DataItem( "ProductName" )%>'
   runat ="server"/>
 </ItemTemplate>
</asp:DataList>
<asp:Label id="lblSelectedProductName" runat="server" ForeColor="Brown"
   Font-Size="12pt" Font-Weight = "500" Font-Name="Arial Black,Arial"/>
<br>
<asp:Label id="lblSelectedIndex" runat="server" ForeColor="Brown"
   Font-Size="12pt" Font-Weight = "500" Font-Name="Arial Black,Arial"/>
</form></html> 
