<!-- Chapter3/DataGrid1.aspx -->
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<html><head></head>
<script language="VB" Debug="true" runat="server">
Sub Page_Load(Source As Object, E As EventArgs)
  If Not IsPostBack Then
     bindListControl
  End If
End Sub
Sub bindListControl()
  Dim myConn As OleDbConnection
  Dim myOleDbAdapter As OleDbDataAdapter
  Dim connStr, sqlStr As String
  Dim myDataSet As New Dataset
  connStr="Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\Products.mdb"
  sqlStr = "SELECT  ProductId, ProductName, Price " _
         + "FROM Products WHERE Price > 40 ORDER BY Price"
  myConn= New OleDbConnection(connStr)
  myConn.Open()
  myOleDbAdapter =New OleDbDataAdapter(sqlStr,myConn)
  myOleDbAdapter.Fill(myDataSet,"dtProducts")
  DataGrid1.DataSource = myDataSet.Tables("dtProducts")
  DataGrid1.DataBind()
  myConn.Close()
 End Sub
</script>

<body bgcolor="white">
<asp:DataGrid id="dataGrid1" runat="server" />
</center></body></html>
